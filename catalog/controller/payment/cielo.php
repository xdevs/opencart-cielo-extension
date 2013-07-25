<?php
class ControllerPaymentCielo extends Controller {
	protected function index() {
		$this->language->load('payment/cielo');

		$this->data['text_barra'] = $this->language->get('text_barra');
		$this->data['text_teste'] = $this->language->get('text_teste');
		$this->data['text_pagamento'] = $this->language->get('text_pagamento');
		$this->data['text_info'] = $this->language->get('text_info');

		$this->data['teste'] = $this->config->get('cielo_teste');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cielo.tpl')) {
			$this->template	= $this->config->get('config_template') . '/template/payment/cielo.tpl';
		} else {
			$this->template	= 'default/template/payment/cielo.tpl';
		}

		$this->render();
	}
	
	public function confirm() {

	}

	function processar() {
		require (DIR_APPLICATION . "controller/payment/cielo_lib/includes/include.php");
		require (DIR_APPLICATION . "controller/payment/cielo_lib/includes/errorHandling.php");
		require_once (DIR_APPLICATION . "controller/payment/cielo_lib/includes/pedido.php");
		require_once (DIR_APPLICATION . "controller/payment/cielo_lib/includes/logger.php");

		$Pedido = new Pedido();

		/* Lê dados do $_POST */
		$Pedido->formaPagamentoBandeira = $_POST["bandeira"];
		if($_POST["formaPagamento"] != "A" && $_POST["formaPagamento"] != "1") {
			$Pedido->formaPagamentoProduto = $this->config->get('cielo_parcelamento');
			$Pedido->formaPagamentoParcelas = $_POST["formaPagamento"];
		} else if ($_POST["formaPagamento"] == "1") {
			$Pedido->formaPagamentoProduto = 1;
			$Pedido->formaPagamentoParcelas = 1;
		} else if ($_POST["formaPagamento"] == "A") {
			$Pedido->formaPagamentoProduto = "A";
			$Pedido->formaPagamentoParcelas = 1;
		}

		$Pedido->dadosEcNumero = CIELO;
		$Pedido->dadosEcChave = CIELO_CHAVE;

		$Pedido->capturar = true;
		$Pedido->autorizar = 2;

		$Pedido->dadosPedidoNumero = $_POST['pedido'];
		$Pedido->dadosPedidoValor  = str_replace(',','',$_POST['valor_total']);

		$Pedido->urlRetorno = ReturnURL();

		/* Envia a requisição ao site da Cielo */
		$objResposta = $Pedido->RequisicaoTransacao(false);

		$Pedido->tid = $objResposta->tid;
		$Pedido->pan = $objResposta->pan;
		$Pedido->status = $objResposta->status;

		$urlAutenticacao = "url-autenticacao";
		$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;

		/* Serializa Pedido e guarda na SESSION */
		$StrPedido = $Pedido->ToString();
		$_SESSION["pedidos"]->append($StrPedido);

		echo '<script type="text/javascript">
				window.location.href = "' . $Pedido->urlAutenticacao . '"
			  </script>';
	}

	function retorno() {
		require (DIR_APPLICATION . "controller/payment/cielo_lib/includes/include.php");
		require (DIR_APPLICATION . "controller/payment/cielo_lib/includes/errorHandling.php");
		require_once (DIR_APPLICATION . "controller/payment/cielo_lib/includes/pedido.php");
		require_once (DIR_APPLICATION . "controller/payment/cielo_lib/includes/logger.php");

		/* Resgata último pedido feito da SESSION */
		$ultimoPedido = $_SESSION["pedidos"]->count();
		$ultimoPedido -= 1;

		$Pedido = new Pedido();
		$Pedido->FromString($_SESSION["pedidos"]->offsetGet($ultimoPedido));

		/* Consulta situação da transação */
		$objResposta = $Pedido->RequisicaoConsulta();

		/* Atualiza status */
		$Pedido->status = $objResposta->status;
		
		if($Pedido->status == '4' || $Pedido->status == '6')
			$finalizacao = 'Aprovado';
		else
			$finalizacao = 'Não Aprovado';

		/* Atualiza Pedido da SESSION */
		$StrPedido = $Pedido->ToString();
		$_SESSION["pedidos"]->offsetSet($ultimoPedido, $StrPedido);

		$comentario = "Situação: ". $finalizacao ."<br />";
		$comentario = $comentario ." Pedido: ". $objResposta->{'dados-pedido'}->numero ."<br />";
		$comentario = $comentario ." TID: ". $objResposta->tid ."<br />";
		$comentario = $comentario ." Cartão: ". strtoupper($objResposta->{'forma-pagamento'}->bandeira) ."<br />";
		$comentario = $comentario ." Parcelado em: ". $objResposta->{'forma-pagamento'}->parcelas ."x";

		if ($Pedido->status == '4' || $Pedido->status == '6') {
			$this->load->model('checkout/order');
			$this->model_checkout_order->confirm($Pedido->dadosPedidoNumero, $this->config->get('cielo_aprovado_id'), $comentario, true);

			$this->db->query("INSERT INTO order_cielo (tid,pan,status,pedido_numero,pedido_valor,pedido_moeda,pedido_data,pedido_idioma,pagamento_bandeira,pagamento_produto,pagamento_parcelas,autenticacao_codigo,autenticacao_mensagem,autenticacao_data,autenticacao_valor,autenticacao_eci,autorizacao_codigo,autorizacao_mensagem,autorizacao_data,autorizacao_valor,autorizacao_lr,autorizacao_arp,autorizacao_nsu,captura_codigo,captura_mensagem,captura_data,captura_valor) values ('" . $objResposta->tid . "','" . $objResposta->pan . "','" . $objResposta->status . "','" . $objResposta->{'dados-pedido'}->numero . "','" . $objResposta->{'dados-pedido'}->valor . "','" . $objResposta->{'dados-pedido'}->moeda . "','" . $objResposta->{'dados-pedido'}->{'data-hora'} . "','" . $objResposta->{'dados-pedido'}->idioma . "','" . $objResposta->{'forma-pagamento'}->bandeira . "','" . $objResposta->{'forma-pagamento'}->produto . "','" . $objResposta->{'forma-pagamento'}->parcelas . "','" . $objResposta->autenticacao->codigo . "','" . utf8_decode($objResposta->autenticacao->mensagem) . "','" . $objResposta->autenticacao->{'data-hora'} . "','" . $objResposta->autenticacao->valor . "','" . $objResposta->autenticacao->eci . "','" . $objResposta->autorizacao->codigo . "','" . utf8_decode($objResposta->autorizacao->mensagem) . "','" . $objResposta->autorizacao->{'data-hora'} . "','" . $objResposta->autorizacao->valor . "','" . $objResposta->autorizacao->lr . "','" . $objResposta->autorizacao->arp . "','" . $objResposta->autorizacao->nsu . "','" . $objResposta->captura->codigo . "','" . utf8_decode($objResposta->captura->mensagem) . "','" . $objResposta->captura->{'data-hora'} . "','" . $objResposta->captura->valor . "')");

			unset($_SESSION["pedidos"]);
			unset($Pedido);
			unset($objResposta);

			$this->redirect($this->url->link('checkout/success'));
		} else {
			$comentario = $comentario ."<br /><br />A operadora deverá ser consultada para mais informações.";
			
			$this->load->model('checkout/order');
			$this->model_checkout_order->confirm($Pedido->dadosPedidoNumero, $this->config->get('cielo_nao_aprovado_id'), $comentario, true);

			$this->db->query("INSERT INTO order_cielo (tid,pan,status,pedido_numero,pedido_valor,pedido_moeda,pedido_data,pedido_idioma,pagamento_bandeira,pagamento_produto,pagamento_parcelas,autenticacao_codigo,autenticacao_mensagem,autenticacao_data,autenticacao_valor,autenticacao_eci,autorizacao_codigo,autorizacao_mensagem,autorizacao_data,autorizacao_valor,autorizacao_lr,autorizacao_arp,autorizacao_nsu,captura_codigo,captura_mensagem,captura_data,captura_valor) values ('" . $objResposta->tid . "','" . $objResposta->pan . "','" . $objResposta->status . "','" . $objResposta->{'dados-pedido'}->numero . "','" . $objResposta->{'dados-pedido'}->valor . "','" . $objResposta->{'dados-pedido'}->moeda . "','" . $objResposta->{'dados-pedido'}->{'data-hora'} . "','" . $objResposta->{'dados-pedido'}->idioma . "','" . $objResposta->{'forma-pagamento'}->bandeira . "','" . $objResposta->{'forma-pagamento'}->produto . "','" . $objResposta->{'forma-pagamento'}->parcelas . "','" . $objResposta->autenticacao->codigo . "','" . utf8_decode($objResposta->autenticacao->mensagem) . "','" . $objResposta->autenticacao->{'data-hora'} . "','" . $objResposta->autenticacao->valor . "','" . $objResposta->autenticacao->eci . "','" . $objResposta->autorizacao->codigo . "','" . utf8_decode($objResposta->autorizacao->mensagem) . "','" . $objResposta->autorizacao->{'data-hora'} . "','" . $objResposta->autorizacao->valor . "','" . $objResposta->autorizacao->lr . "','" . $objResposta->autorizacao->arp . "','" . $objResposta->autorizacao->nsu . "','" . $objResposta->captura->codigo . "','" . utf8_decode($objResposta->captura->mensagem) . "','" . $objResposta->captura->{'data-hora'} . "','" . $objResposta->captura->valor . "')");

			unset($_SESSION["pedidos"]);
			unset($Pedido);
			unset($objResposta);		
		
			$this->redirect($this->url->link('payment/cielo_message'));
		}
	}

	function parcelamento() {
		if (isset($this->request->get['bandeira'])) {
			$bandeira = $this->request->get['bandeira'];
		} else {
			$bandeira = 0;
		}

		if (isset($this->request->get['parcelas'])) {
			$maximo_parcelas = $this->request->get['parcelas'];
		} else {
			$maximo_parcelas = 0;
		}
		
		if (isset($this->request->get['operacao'])) {
			$operacao = $this->request->get['operacao'];
		} else {
			$operacao = 0;
		}

		$this->load->model('checkout/order');
		$order_info  = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$valor = str_replace(',','',number_format($order_info['total'],2));

		$parcelas_sem_juros = $this->config->get('cielo_cartao_semjuros');;

		$juros = $this->config->get('cielo_cartao_juros');

		$parcela_minima = $this->config->get('cielo_cartao_minimo');

		if ($bandeira != 0 || $operacao != 0 || $operacao != 'D') {
			if ($this->config->get('cielo_parcelamento') == "2") {
			?>
				<strong style="line-height:20px;color:#CC0033">Pagamento no Cartão de Crédito <?php echo strtoupper($bandeira);?></strong><br /><br />
				<input type="radio" id="formaPagamento" name="formaPagamento" value="1"><?php echo '1x de '. number_format($valor, 2, ',', '.') .' sem juros.';?>
				<?php
				for ($p = 2; $p <= $maximo_parcelas; $p++) {

					if ($p <= $parcelas_sem_juros) {
						$valor_parcela = $valor / $p;
					}

					if ($p > $parcelas_sem_juros) {
						$valor_parcela = ($valor * pow(1+($juros/100), $p))/$p;
					}

					if ($valor_parcela >= $parcela_minima) {
						if ($p <= $parcelas_sem_juros) {
				?>
							<br><input type="radio" id="formaPagamento" name="formaPagamento" value="<?php echo $p;?>"><?php echo ' '. $p .'x de '. number_format($valor_parcela, 2, ',', '.') .' sem juros.';?>
				<?php   } else { ?>
							<br><input type="radio" id="formaPagamento" name="formaPagamento" value="<?php echo $p;?>"><?php echo ' '. $p .'x de '. number_format($valor_parcela, 2, ',', '.') .' com juros.';?>
				<?php   }
					} else {
						echo '<br /><br /><span style="font-size: smaller;">Parcela mínima de '. number_format($parcela_minima, 2, ',', '.') .'.</span>';
						break;
					}
				}
				if ($parcelas_sem_juros < $maximo_parcelas) {
					$juros = number_format($juros, 2, ',', '.');
					echo '<br /><br /><span style="font-size: smaller;">Juros de '. $juros .'% ao mês.</span>';
				}
			} else if ($this->config->get('cielo_parcelamento') == "3") {
			?>
				<strong style="line-height:20px;color:#CC0033">Pagamento no Cartão de Crédito <?php echo strtoupper($bandeira);?></strong><br /><br />
				<input type="radio" id="formaPagamento" name="formaPagamento" value="1"><?php echo ' 1x de '. number_format($valor, 2, ',', '.') .' sem juros.';?>
				<?php
				for ($p = 2; $p <= $maximo_parcelas; $p++) {
				?>
					<br><input type="radio" id="formaPagamento" name="formaPagamento" value="<?php echo $p;?>"><?php echo ' '. $p .'x (o valor da parcela será consultado no próximo passo)';?>
				<?php
				}
			}
		} else if ($bandeira != 0 || $operacao != 0 || $operacao == 'D') {
		?>
			<strong style="line-height:20px;color:#CC0033">Pagamento no Cartão de Débito Visa Electron</strong><br /><br />
			<input type="radio" id="formaPagamento" name="formaPagamento" value="A" checked="checked"><?php echo ' 1x de '. number_format($valor, 2, ',', '.') .' sem juros.<br /><br />';?>
		<?php
		}
	}
}
?>