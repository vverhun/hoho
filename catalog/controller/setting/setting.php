<?php
class ControllerSettingSetting extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/setting');
		if (!$this->user->isLogged()) {
			$this->error['warning'] = $this->language->get('error_permission');
			$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
			return FALSE;
			die();
		}
		$this->document->title = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {

			if ( (trim($this->request->post['tag']) == '' ||
			trim($this->request->post['monat']) == ''  ||
			trim( $this->request->post['jahr'] ) == '') && $this->request->post['config_maintenance'] == '0' ){

				$this->data['success'] = '<span style="color:red !important;">Bitte geben Sie ein Datum ein!</span>';
				$this->template = 'default/template/setting/setting.tpl';
				$this->children = array(
						'common/header',	
						'common/footer'	
						);

						$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
						return;

			}

			if ( !$this->validate($this->request->post) && $this->request->post['config_maintenance'] == '0' ){

				$this->data['success'] = '<span style="color:red !important;">Bitte geben Sie ein Datum ein. (tt.mm.yyyy)!</span>';
				$this->template = 'default/template/setting/setting.tpl';
				$this->children = array(
						'common/header',	
						'common/footer'	
						);
			    $this->data['tag']   = $this->request->post['tag'];
				$this->data['monat'] = $this->request->post['monat'];
				$this->data['jahr']  = $this->request->post['jahr'];

				$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
				return;

			}
				
				
			$this->data['success'] = $this->language->get('text_success');

			$this->model_setting_setting->updateSetting('724','config_maintenance', $this->request->post['config_maintenance']);
			if ( $this->request->post['config_maintenance'] == "1"){
				$this->request->post['tag'] = "";
				$this->request->post['monat'] = "";
				$this->request->post['jahr'] = "";
			}
				
				
			$this->model_setting_setting->updateSetting('731','config_maintenance_date', $this->request->post['tag'].'.'.$this->request->post['monat'].'.'.$this->request->post['jahr']);

			//$this->redirect(HTTPS_SERVER . 'index.php?route=setting/setting&token=' . $this->session->data['token']);
		}

			
		$config_maintenance = $this->model_setting_setting->getSettingByName('config_maintenance');
		$config_maintenance = $config_maintenance['value'];
		$this->data['config_maintenance'] = $config_maintenance;

		$config_maintenance_date = $this->model_setting_setting->getSettingByName('config_maintenance_date');


		$dat = explode('.', $config_maintenance_date['value']);
		$this->data['tag']   = $dat[0];
		$this->data['monat'] = $dat[1];
		$this->data['jahr']  = $dat[2];


		$this->data['insert'] = HTTPS_SERVER . 'index.php?route=setting/store/insert&token=' . $this->session->data['token'];
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=setting/setting&token=' . $this->session->data['token'];
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=setting/setting&token=' . $this->session->data['token'];
		$this->data['stores'] = array();


		$ignore = array(
			'common/login',
			'common/logout',
			'error/not_found',
			'error/permission'
			);


			$this->template = 'default/template/setting/setting.tpl';
			$this->children = array(
			'common/header',	
			'common/footer'	
			);

			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate($postarray){
		 
		if (strlen(trim(strval($postarray['tag']))) > 2 || ((int)$postarray['tag']) > 31 ) return FALSE;
		if (strlen(trim(strval($postarray['monat']))) > 2 || (int)$postarray['monat'] > 12 ) return FALSE;
		if (strlen(trim(strval($postarray['jahr']))) != 4 ) return FALSE;

		return TRUE;
		 
	}


	public function template() {
		$template = basename($this->request->get['template']);

		if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
			$image = HTTPS_IMAGE . 'templates/' . $template . '.png';
		} else {
			$image = HTTPS_IMAGE . 'no_image.jpg';
		}

		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
	}
}
?>