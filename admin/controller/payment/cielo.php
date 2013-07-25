<?php
class ControllerPaymentCielo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/cielo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cielo', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_loja'] = $this->language->get('text_loja');
		$this->data['text_administradora'] = $this->language->get('text_administradora');

		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_afiliacao'] = $this->language->get('entry_afiliacao');
		$this->data['entry_chave'] = $this->language->get('entry_chave');
		$this->data['entry_teste'] = $this->language->get('entry_teste');
		$this->data['entry_parcelamento'] = $this->language->get('entry_parcelamento');
		$this->data['entry_cartao_visa'] = $this->language->get('entry_cartao_visa');
		$this->data['entry_cartao_visae'] = $this->language->get('entry_cartao_visae');
		$this->data['entry_cartao_mastercard'] = $this->language->get('entry_cartao_mastercard');
		$this->data['entry_cartao_diners'] = $this->language->get('entry_cartao_diners');
		$this->data['entry_cartao_discover'] = $this->language->get('entry_cartao_discover');
		$this->data['entry_cartao_elo'] = $this->language->get('entry_cartao_elo');
		$this->data['entry_cartao_amex'] = $this->language->get('entry_cartao_amex'); 
		$this->data['entry_parcelas'] = $this->language->get('entry_parcelas');
		$this->data['entry_cartao_minimo'] = $this->language->get('entry_cartao_minimo');
		$this->data['entry_cartao_semjuros'] = $this->language->get('entry_cartao_semjuros');
		$this->data['entry_cartao_juros'] = $this->language->get('entry_cartao_juros');
		$this->data['entry_aprovado'] = $this->language->get('entry_aprovado');
		$this->data['entry_nao_aprovado'] = $this->language->get('entry_nao_aprovado');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		if (isset($this->error['cielo_afiliacao'])) {
			$this->data['error_afiliacao'] = $this->error['cielo_afiliacao'];
		} else {
			$this->data['error_afiliacao'] = '';
		}

 		if (isset($this->error['cielo_chave'])) {
			$this->data['error_chave'] = $this->error['cielo_chave'];
		} else {
			$this->data['error_chave'] = '';
		}

 		if (isset($this->error['cielo_cartao_semjuros'])) {
			$this->data['error_cartao_semjuros'] = $this->error['cielo_cartao_semjuros'];
		} else {
			$this->data['error_cartao_semjuros'] = '';
		}

 		if (isset($this->error['cielo_cartao_juros'])) {
			$this->data['error_cartao_juros'] = $this->error['cielo_cartao_juros'];
		} else {
			$this->data['error_cartao_juros'] = '';
		}

 		if (isset($this->error['cielo_cartao_minimo'])) {
			$this->data['error_cartao_minimo'] = $this->error['cielo_cartao_minimo'];
		} else {
			$this->data['error_cartao_minimo'] = '';
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/cielo', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('payment/cielo', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['cielo_total'])) {
			$this->data['cielo_total'] = $this->request->post['cielo_total'];
		} else {
			$this->data['cielo_total'] = $this->config->get('cielo_total');
		}
		
		if (isset($this->request->post['cielo_afiliacao'])) {
			$this->data['cielo_afiliacao'] = $this->request->post['cielo_afiliacao'];
		} else {
			$this->data['cielo_afiliacao'] = $this->config->get('cielo_afiliacao');
		}

		if (isset($this->request->post['cielo_chave'])) {
			$this->data['cielo_chave'] = $this->request->post['cielo_chave'];
		} else {
			$this->data['cielo_chave'] = $this->config->get('cielo_chave');
		}		

		if (isset($this->request->post['cielo_teste'])) {
			$this->data['cielo_teste'] = $this->request->post['cielo_teste'];
		} else {
			$this->data['cielo_teste'] = $this->config->get('cielo_teste');
		}
		
		if (isset($this->request->post['cielo_parcelamento'])) {
			$this->data['cielo_parcelamento'] = $this->request->post['cielo_parcelamento'];
		} else {
			$this->data['cielo_parcelamento'] = $this->config->get('cielo_parcelamento');
		}

		if (isset($this->request->post['cielo_cartao_visa'])) {
			$this->data['cielo_cartao_visa'] = $this->request->post['cielo_cartao_visa'];
		} else {
			$this->data['cielo_cartao_visa'] =  $this->config->get('cielo_cartao_visa');
		}

		if (isset($this->request->post['cielo_cartao_visae'])) {
			$this->data['cielo_cartao_visae'] = $this->request->post['cielo_cartao_visae'];
		} else {
			$this->data['cielo_cartao_visae'] =  $this->config->get('cielo_cartao_visae');
		}

		if (isset($this->request->post['cielo_cartao_mastercard'])) {
			$this->data['cielo_cartao_mastercard'] = $this->request->post['cielo_cartao_mastercard'];
		} else {
			$this->data['cielo_cartao_mastercard'] =  $this->config->get('cielo_cartao_mastercard');
		}

		if (isset($this->request->post['cielo_cartao_diners'])) {
			$this->data['cielo_cartao_diners'] = $this->request->post['cielo_cartao_diners'];
		} else {
			$this->data['cielo_cartao_diners'] =  $this->config->get('cielo_cartao_diners');
		}

		if (isset($this->request->post['cielo_cartao_discover'])) {
			$this->data['cielo_cartao_discover'] = $this->request->post['cielo_cartao_discover'];
		} else {
			$this->data['cielo_cartao_discover'] =  $this->config->get('cielo_cartao_discover');
		}

		if (isset($this->request->post['cielo_cartao_elo'])) {
			$this->data['cielo_cartao_elo'] = $this->request->post['cielo_cartao_elo'];
		} else {
			$this->data['cielo_cartao_elo'] =  $this->config->get('cielo_cartao_elo');
		}
		
		if (isset($this->request->post['cielo_cartao_amex'])) {
			$this->data['cielo_cartao_amex'] = $this->request->post['cielo_cartao_amex'];
		} else {
			$this->data['cielo_cartao_amex'] =  $this->config->get('cielo_cartao_amex');
		}

		if (isset($this->request->post['cielo_visa_parcelas'])) {
			$this->data['cielo_visa_parcelas'] = $this->request->post['cielo_visa_parcelas'];
		} else {
			$this->data['cielo_visa_parcelas'] =  $this->config->get('cielo_visa_parcelas');
		}

		if (isset($this->request->post['cielo_visae_parcelas'])) {
			$this->data['cielo_visae_parcelas'] = $this->request->post['cielo_visae_parcelas'];
		} else {
			$this->data['cielo_visae_parcelas'] =  $this->config->get('cielo_visae_parcelas');
		}

		if (isset($this->request->post['cielo_mastercard_parcelas'])) {
			$this->data['cielo_mastercard_parcelas'] = $this->request->post['cielo_mastercard_parcelas'];
		} else {
			$this->data['cielo_mastercard_parcelas'] =  $this->config->get('cielo_mastercard_parcelas');
		}

		if (isset($this->request->post['cielo_diners_parcelas'])) {
			$this->data['cielo_diners_parcelas'] = $this->request->post['cielo_diners_parcelas'];
		} else {
			$this->data['cielo_diners_parcelas'] =  $this->config->get('cielo_diners_parcelas');
		}

		if (isset($this->request->post['cielo_discover_parcelas'])) {
			$this->data['cielo_discover_parcelas'] = $this->request->post['cielo_discover_parcelas'];
		} else {
			$this->data['cielo_discover_parcelas'] =  $this->config->get('cielo_discover_parcelas');
		}

		if (isset($this->request->post['cielo_elo_parcelas'])) {
			$this->data['cielo_elo_parcelas'] = $this->request->post['cielo_elo_parcelas'];
		} else {
			$this->data['cielo_elo_parcelas'] =  $this->config->get('cielo_elo_parcelas');
		}

		if (isset($this->request->post['cielo_amex_parcelas'])) {
			$this->data['cielo_amex_parcelas'] = $this->request->post['cielo_amex_parcelas'];
		} else {
			$this->data['cielo_amex_parcelas'] =  $this->config->get('cielo_amex_parcelas');
		}

		if (isset($this->request->post['cielo_cartao_semjuros'])) {
			$this->data['cielo_cartao_semjuros'] = $this->request->post['cielo_cartao_semjuros'];
		} else {
			$this->data['cielo_cartao_semjuros'] = $this->config->get('cielo_cartao_semjuros');
		}

		if (isset($this->request->post['cielo_cartao_minimo'])) {
			$this->data['cielo_cartao_minimo'] = $this->request->post['cielo_cartao_minimo'];
		} else {
			$this->data['cielo_cartao_minimo'] = $this->config->get('cielo_cartao_minimo');
		}

		if (isset($this->request->post['cielo_cartao_juros'])) {
			$this->data['cielo_cartao_juros'] = $this->request->post['cielo_cartao_juros'];
		} else {
			$this->data['cielo_cartao_juros'] = $this->config->get('cielo_cartao_juros');
		}
		
		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['cielo_aprovado_id'])) {
			$this->data['cielo_aprovado_id'] = $this->request->post['cielo_aprovado_id'];
		} else {
			$this->data['cielo_aprovado_id'] = $this->config->get('cielo_aprovado_id'); 
		}
		
		if (isset($this->request->post['cielo_nao_aprovado_id'])) {
			$this->data['cielo_nao_aprovado_id'] = $this->request->post['cielo_nao_aprovado_id'];
		} else {
			$this->data['cielo_nao_aprovado_id'] = $this->config->get('cielo_nao_aprovado_id'); 
		}
		
		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['cielo_geo_zone_id'])) {
			$this->data['cielo_geo_zone_id'] = $this->request->post['cielo_geo_zone_id'];
		} else {
			$this->data['cielo_geo_zone_id'] = $this->config->get('cielo_geo_zone_id');
		}		

		if (isset($this->request->post['cielo_status'])) {
			$this->data['cielo_status'] = $this->request->post['cielo_status'];
		} else {
			$this->data['cielo_status'] = $this->config->get('cielo_status');
		}

		if (isset($this->request->post['cielo_sort_order'])) {
			$this->data['cielo_sort_order'] = $this->request->post['cielo_sort_order'];
		} else {
			$this->data['cielo_sort_order'] = $this->config->get('cielo_sort_order');
		}

		$this->template = 'payment/cielo.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/cielo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['cielo_afiliacao']) {
			$this->error['cielo_afiliacao'] = $this->language->get('error_afiliacao');
		}

		if (!$this->request->post['cielo_chave']) {
			$this->error['cielo_chave'] = $this->language->get('error_chave');
		}

		if (!$this->request->post['cielo_cartao_semjuros']) {
			$this->error['cielo_cartao_semjuros'] = $this->language->get('error_cartao_semjuros');
		}

		if (!$this->request->post['cielo_cartao_juros']) {
			$this->error['cielo_cartao_juros'] = $this->language->get('error_cartao_juros');
		}

		if (!$this->request->post['cielo_cartao_minimo']) {
			$this->error['cielo_cartao_minimo'] = $this->language->get('error_cartao_minimo');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>