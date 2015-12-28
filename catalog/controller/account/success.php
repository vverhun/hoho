<?php
class ControllerAccountSuccess extends Controller {
	public function index() {
		$this->language->load('account/success');

		$this->document->title = $this->language->get('heading_title');

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
		);

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTPS_SERVER . 'index.php?route=account/success',
        	'text'      => $this->language->get('text_success'),
        	'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$message = '';

		$message = $this->language->get('text_approval');
			
		$todays_date = date("d.m.Y");
		$maintenancedate = $this->config->get('config_maintenance_date');
		$todays_date = strtotime($todays_date);
		$maintenancedate = strtotime($maintenancedate);
		if ( $maintenancedate <= $todays_date ){

			$this->load->model('setting/setting');
			$this->model_setting_setting->updateSetting( '731','config_maintenance_date', '' );
			$this->model_setting_setting->updateSetting( '724','config_maintenance', '1' );

		}
			
			
		if ($this->config->get('config_maintenance') == '0'  && $maintenancedate > $todays_date  ) {
			$message = sprintf($this->language->get('text_approval2'), $this->config->get('config_maintenance_date'));
		}
		 
		if (isset($this->request->get['upload'])){
			$message.= $this->language->get('text_approval3');
		}

		$this->data['text_message'] = $message;









		$this->data['button_continue'] = $this->language->get('button_continue');

		if ($this->cart->hasProducts()) {
			$this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/cart';
		} else {
			$this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/account';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}

		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
			);

			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
}
?>