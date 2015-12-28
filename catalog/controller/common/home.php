<?php
class ControllerCommonHome extends Controller {
	public function index() {
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['language_code'])) {
			$this->session->data['language'] = $this->request->post['language_code'];

			if (isset($this->request->post['redirect'])) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect(HTTP_SERVER . 'index.php?route=common/home');
			}
		}
		$this->language->load('common/home');

		$this->document->title = $this->config->get('config_title');
		$this->document->description = $this->config->get('config_meta_description');

		if ($this->customer->isLogged()) {
			$this->redirect(HTTPS_SERVER . 'index.php?route=product/search');
		}
			
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
		$this->data['direction'] = $this->language->get('direction');

		$this->data['intro']   = $this->language->get('intro');
		$this->data['menu1']  = $this->language->get('menu1');
		$this->data['menu2']  = $this->language->get('menu2');
		$this->data['menu3']   = $this->language->get('menu3');
		$this->data['menu4']  = $this->language->get('menu4');
		$this->data['menu5']  = $this->language->get('menu5');


		$this->load->model('setting/store');

		if (!$this->config->get('config_store_id')) {
			$this->data['welcome'] = html_entity_decode($this->config->get('config_description_' . $this->config->get('config_language_id')), ENT_QUOTES, 'UTF-8');
		} else {
			$store_info = $this->model_setting_store->getStore($this->config->get('config_store_id'));

			if ($store_info) {
				$this->data['welcome'] = html_entity_decode($store_info['description'], ENT_QUOTES, 'UTF-8');
			} else {
				$this->data['welcome'] = '';
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}

		$this->children = array();

		$this->load->model('checkout/extension');

		$module_data = $this->model_checkout_extension->getExtensionsByPosition('module', 'home');

		$this->data['modules'] = $module_data;

		foreach ($module_data as $result) {
			$this->children[] = 'module/' . $result['code'];
		}

		$this->children[] = 'common/column_right';
		$this->children[] =	'common/column_left';
		$this->children[] =	'common/footer';
		$this->children[] =	'common/header';

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>