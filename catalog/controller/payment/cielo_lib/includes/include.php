<?php
if ($this->config->get('cielo_teste') == 1) {
    define('ENDERECO',"https://qasecommerce.cielo.com.br/servicos/ecommwsec.do");
} else {
    define('ENDERECO',"https://ecommerce.cbmp.com.br/servicos/ecommwsec.do");
}
define('VERSAO', "1.1.1");
define('CIELO', $this->config->get('cielo_afiliacao'));
define('CIELO_CHAVE', $this->config->get('cielo_chave'));

if ($this->config->get('ssl') == 1){
   	define('RETORNO_URL',HTTPS_SERVER . "index.php?route=payment/cielo/retorno");
} else {
   	define('RETORNO_URL',HTTP_SERVER . "index.php?route=payment/cielo/retorno");
}

if(!isset($_SESSION["pedidos"]))
{
	$_SESSION["pedidos"] = new ArrayObject();
}

// Envia requisiчуo
function httprequest($paEndereco, $paPost){

	$sessao_curl = curl_init();
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);
	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($sessao_curl, CURLOPT_CAINFO, DIR_APPLICATION . "controller/payment/cielo_lib/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
	curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($sessao_curl, CURLOPT_POST, true);
	curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );

	$resultado = curl_exec($sessao_curl);

	curl_close($sessao_curl);

	if ($resultado)
	{
		return $resultado;
	}
	else
	{
		return curl_error($sessao_curl);
	}
}

// Monta URL de retorno
function ReturnURL(){
    $ReturnURL = RETORNO_URL;
    return $ReturnURL;
}

?>