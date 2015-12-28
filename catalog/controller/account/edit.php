<?php
class ControllerAccountEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/edit';

			$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
		}

		$this->language->load('account/edit');
		$this->document->title = $this->language->get('heading_title');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_title2'] = $this->language->get('heading_title2');
		$this->data['heading_title3'] = $this->language->get('heading_title3');
		$this->data['heading_title4'] = $this->language->get('heading_title4');


		$this->language->load('account/create');
		$this->data['heading_title2'] = $this->language->get('heading_title2');

		$this->data['spesial_text2'] = $this->language->get('spesial_text2');
		$this->data['spesial_text'] = $this->language->get('spesial_text');



		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), HTTPS_SERVER . 'index.php?route=account/login');
		$this->data['text_your_details'] = $this->language->get('text_your_details');
		$this->data['text_your_address'] = $this->language->get('text_your_address');
		$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['passinfo'] = $this->language->get('passinfo');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['senden'] = $this->language->get('senden');

		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['communication'] = $this->language->get('communication');
			



		$this->data['typ1'] = $this->language->get('typ1');
		$this->data['typ2'] = $this->language->get('typ2');
		$this->data['typ3'] = $this->language->get('typ3');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_person'] = $this->language->get('entry_person');
		$this->data['street'] = $this->language->get('street');
		$this->data['mobil'] = $this->language->get('mobil');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['mandatory'] = $this->language->get('mandatory');

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_account_customer->editCustomer($this->request->post);
			if($this->request->post['bill_access'] == 'on'){
				$this->model_account_customer->editBill($this->request->post);
			}else{
				$this->model_account_customer->delBill();
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=account/edit&preview=preview');
		}

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
        	'href'      => HTTPS_SERVER . 'index.php?route=account/edit',
        	'text'      => $this->language->get('text_edit'),
        	'separator' => $this->language->get('text_separator')
		);

		$this->data['text_your_details'] = $this->language->get('text_your_details');

		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');


		$this->data['my_datem'] = $this->language->get('my_datem');
		$this->data['my_Einrichtung'] = $this->language->get('my_Einrichtung');
		$this->data['my_contact'] = $this->language->get('my_contact');
		$this->data['my_userName'] = $this->language->get('my_userName');
		$this->data['my_street'] = $this->language->get('my_street');
		$this->data['my_postcode'] = $this->language->get('my_postcode');
		$this->data['my_sity'] = $this->language->get('my_sity');
		$this->data['my_country'] = $this->language->get('my_country');
		$this->data['my_phone'] = $this->language->get('my_phone');
		$this->data['my_access'] = $this->language->get('my_access');
		$this->data['my_tax'] = $this->language->get('my_tax');
		$this->data['my_Passwor'] = $this->language->get('my_Passwor');
		$this->data['my_Passwor_confirm'] = $this->language->get('my_Passwor_confirm');
		$this->data['heading_title3'] = $this->language->get('heading_title3');

		$this->data['bearbeiten'] = $this->language->get('bearbeiten');

		//$this->data['account_edit_active'] = true;;


		if (isset($this->error['email'])) {
			$this->data['error_warning'] = $this->error['email'];
		}
		if (isset($this->error['telephone'])) {
			$this->data['error_warning'] = $this->error['telephone'];
		}
		if (isset($this->error['land'])) {
			$this->data['error_warning'] = $this->error['land'];
		}
		if (isset($this->error['city'])) {
			$this->data['error_warning'] = $this->error['city'];
		}
		if (isset($this->error['postcode'])) {
			$this->data['error_warning'] = $this->error['postcode'];
		}
		if (isset($this->error['address_1'])) {
			$this->data['error_warning'] = $this->error['address_1'];
		}
		if (isset($this->error['taxid_number'])) {
			$this->data['error_warning'] = $this->error['taxid_number'];
		}

		if (isset($this->error['password_confirm'])) {
			$this->data['error_warning'] = $this->error['password_confirm'];
		}



		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		}


		$this->data['action'] = HTTPS_SERVER . 'index.php?route=account/edit';

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			$bill_info = $this->model_account_customer->getBill($this->customer->getId());

			$this->load->model('sale/customer');
			$address_info  = $this->model_sale_customer->getAddressesByCustomerId($this->customer->getId());

		}

		if (isset($this->request->post['postcode'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($customer_info)) {
			$this->data['postcode'] = $address_info[0]['postcode'];
		} else {
			$this->data['postcode'] = '';
		}


		if (isset($this->request->post['communic'])) {
			$this->data['communic'] = $this->request->post['communic'];
		} elseif (isset($customer_info)) {
			$this->data['communic'] = $customer_info['lang'];
		} else {
			$this->data['communic'] = '';
		}



		if (isset($this->request->post['city'])) {
			$this->data['city'] = $this->request->post['city'];
		} elseif (isset($customer_info)) {
			$this->data['city'] = $address_info[0]['city'];
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->request->post['land'])) {
			$this->data['country_id'] = $this->request->post['land'];
		} elseif (isset($customer_info)) {
			$this->data['country_id'] = $address_info[0]['country_id'];
		} else {
			$this->data['country_id'] = '';
		}

		 
		if (isset($this->request->post['address_1'])) {
			$this->data['address_1'] = $this->request->post['address_1'];
		} elseif (isset($customer_info)) {
			$this->data['address_1'] = $address_info[0]['address_1'];
		} else {
			$this->data['address_1'] = '';
		}




		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($customer_info)) {
			$this->data['firstname'] = $customer_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($customer_info)) {
			$this->data['lastname'] = $customer_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (isset($customer_info)) {
			$this->data['email'] = $customer_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($customer_info)) {
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (isset($customer_info)) {
			$this->data['fax'] = $customer_info['fax'];
		} else {
			$this->data['fax'] = '';
		}
			
		if (isset($this->request->post['taxid_number'])) {
			$this->data['taxid_number'] = $this->request->post['taxid_number'];
		} elseif (isset($customer_info)) {
			$this->data['taxid_number'] = $customer_info['taxid_number'];
		} else {
			$this->data['taxid_number'] = '';
		}

		if (isset($this->request->post['ansprechpartner'])) {
			$this->data['ansprechpartner'] = $this->request->post['ansprechpartner'];
		} elseif (isset($customer_info)) {
			$this->data['ansprechpartner'] = $customer_info['ansprechpartner'];
		} else {
			$this->data['ansprechpartner'] = '';
		}

		if (isset($this->request->post['position'])) {
			$this->data['position'] = $this->request->post['position'];
		} elseif (isset($customer_info)) {
			$this->data['position'] = $customer_info['position'];
		} else {
			$this->data['position'] = '';
		}

		if (isset($this->request->post['username1'])) {
			$this->data['username1'] = $this->request->post['username1'];
		} elseif (isset($customer_info)) {
			$this->data['username1'] = $customer_info['username'];
		} else {
			$this->data['username1'] = '';
		}

		if (isset($customer_info)) {
			$this->data['username'] = $customer_info['username'];
		} else {
			$this->data['username'] = '';
		}

		if (isset($this->request->post['firma'])) {
			$this->data['firma'] = $this->request->post['firma'];
		} elseif (isset($customer_info)) {
			$this->data['firma'] = $customer_info['firma'];
		} else {
			$this->data['firma'] = '';
		}

		if (isset($this->request->post['museum'])) {
			$this->data['museum'] = $this->request->post['museum'];
		} elseif (isset($customer_info)) {
			$this->data['museum'] = $customer_info['museum'];
		} else {
			$this->data['museum'] = '';
		}

		if (isset($this->request->post['privatperson'])) {
			$this->data['privatperson'] = $this->request->post['privatperson'];
		} elseif (isset($customer_info)) {
			$this->data['privatperson'] = $customer_info['privatperson'];
		} else {
			$this->data['privatperson'] = '';
		}

			
		if (isset($this->request->post['mobile'])) {
			$this->data['mobile'] = $this->request->post['mobile'];
		} elseif (isset($customer_info)) {
			$this->data['mobile'] = $customer_info['mobile'];
		} else {
			$this->data['mobile'] = '';
		}

		if (isset($this->request->post['bill_address'])) {
			$this->data['bill_address'] = $this->request->post['bill_address'];
		} elseif (isset($bill_info)) {
			$this->data['bill_address'] = $bill_info['bill_address'];
		} else {
			$this->data['bill_address'] = 'off';
		}
		if (isset($this->request->post['bill_address_1'])) {
			$this->data['bill_address_1'] = $this->request->post['bill_address_1'];
		} elseif (isset($bill_info)) {
			$this->data['bill_address_1'] = $bill_info['bill_address_1'];
		} else {
			$this->data['bill_address_1'] = '';
		}
		if (isset($this->request->post['bill_postcode'])) {
			$this->data['bill_postcode'] = $this->request->post['bill_postcode'];
		} elseif (isset($bill_info)) {
			$this->data['bill_postcode'] = $bill_info['bill_postcode'];
		} else {
			$this->data['bill_postcode'] = '';
		}
		if (isset($this->request->post['bill_city'])) {
			$this->data['bill_city'] = $this->request->post['bill_city'];
		} elseif (isset($bill_info)) {
			$this->data['bill_city'] = $bill_info['bill_city'];
		} else {
			$this->data['bill_city'] = '';
		}
		if (isset($this->request->post['bill_land'])) {
			$this->data['bill_land'] = $this->request->post['bill_land'];
		} elseif (isset($bill_info)) {
			$this->data['bill_land'] = $bill_info['bill_land'];
		} else {
			$this->data['bill_land'] = '';
		}
		if (isset($this->request->post['bill_taxid_number'])) {
			$this->data['bill_taxid_number'] = $this->request->post['bill_taxid_number'];
		} elseif (isset($bill_info)) {
			$this->data['bill_taxid_number'] = $bill_info['bill_taxid_number'];
		} else {
			$this->data['bill_taxid_number'] = '';
		}
		if (isset($this->request->post['bill_telephone'])) {
			$this->data['bill_telephone'] = $this->request->post['bill_telephone'];
		} elseif (isset($bill_info)) {
			$this->data['bill_telephone'] = $bill_info['bill_telephone'];
		} else {
			$this->data['bill_telephone'] = '';
		}
		if (isset($this->request->post['bill_mobile'])) {
			$this->data['bill_mobile'] = $this->request->post['bill_mobile'];
		} elseif (isset($bill_info)) {
			$this->data['bill_mobile'] = $bill_info['bill_mobile'];
		} else {
			$this->data['bill_mobile'] = '';
		}
		if (isset($this->request->post['bill_fax'])) {
			$this->data['bill_fax'] = $this->request->post['bill_fax'];
		} elseif (isset($bill_info)) {
			$this->data['bill_fax'] = $bill_info['bill_fax'];
		} else {
			$this->data['bill_fax'] = '';
		}
		if (isset($this->request->post['bill_email'])) {
			$this->data['bill_email'] = $this->request->post['bill_email'];
		} elseif (isset($bill_info)) {
			$this->data['bill_email'] = $bill_info['bill_email'];
		} else {
			$this->data['bill_email'] = '';
		}

		$this->data['back'] = HTTPS_SERVER . 'index.php?route=account/account';

		if(isset($this->request->get['preview']) ) {

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit_preview.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/edit_preview.tpl';
			} else {
				$this->template = 'default/template/account/edit_preview.tpl';
			}

		}
		else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
			} else {
				$this->template = 'default/template/account/edit.tpl';
			}

		}



		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
			);

			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {


		if ((strlen(utf8_decode($this->request->post['address_1'])) < 1) || (strlen(utf8_decode($this->request->post['address_1'])) > 32)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}


		if ((strlen(utf8_decode($this->request->post['postcode'])) < 1) || (strlen(utf8_decode($this->request->post['postcode'])) > 32)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}
			

		if ((strlen(utf8_decode($this->request->post['city'])) < 1) || (strlen(utf8_decode($this->request->post['city'])) > 32)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		if ((strlen(utf8_decode($this->request->post['land'])) < 1) || (strlen(utf8_decode($this->request->post['land'])) > 32)) {
			$this->error['land'] = $this->language->get('error_land');
		}

		if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match(EMAIL_PATTERN, $this->request->post['email']))) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}




		if(isset($this->request->post['password']) && trim($this->request->post['password']) != '') {
			if(isset($this->request->post['confirm'])) {
				if($this->request->post['password'] != $this->request->post['confirm']) {
					$this->error['password_confirm'] = $this->language->get('password_confirm');
				}
			}
			else {
				$this->error['password_confirm'] = $this->language->get('password_confirm');
			}
		}
			

		if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}


		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>