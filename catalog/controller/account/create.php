<?php

class ControllerAccountCreate extends Controller {

    private $error = array();

    public function index() {
        if ($this->customer->isLogged()) {
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/account');
        }

        $this->language->load('account/create');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('account/customer');

        if ($_FILES['uploaddata']['name'] != '') {
            $target_path = "download/";
            $target_path = $target_path . basename($_FILES['uploaddata']['name']);
            move_uploaded_file($_FILES['uploaddata']['tmp_name'], $target_path);
            $_SESSION['uploaddata']['name'] = $_FILES['uploaddata']['name'];
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_account_customer->addCustomer($this->request->post, $_SESSION['uploaddata']['name']);
            unset($this->session->data['guest']);

            $this->customer->login($this->request->post['username'], $this->request->post['password']);

            $this->load->model('account/address');

            $address = $this->model_account_address->getAddress($this->customer->getAddressId());

            $this->tax->setZone($address['country_id'], $address['zone_id']);

            $this->language->load('mail/account_create');

            $subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));


            $message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";

            if (!$this->config->get('config_customer_approval')) {
                $message .= $this->language->get('text_login') . "\n";
            } else {
                $message .= $this->language->get('text_approval') . "\n";
            }

            $lang = $this->request->post['communic'];

            //prepare message
            $message = '';
            if ($lang == 'de-DE') {
                $message = $this->language->get('text_approval_email');
            } else {
                $message = $this->language->get('text_approval_email_en');
            }

            $todays_date = date("d.m.Y");
            $maintenancedate = $this->config->get('config_maintenance_date');
            $todays_date = strtotime($todays_date);
            $maintenancedate = strtotime($maintenancedate);
            if ($maintenancedate <= $todays_date) {

                $this->load->model('setting/setting');
                $this->model_setting_setting->updateSetting('731', 'config_maintenance_date', '');
                $this->model_setting_setting->updateSetting('724', 'config_maintenance', '1');
            }

            if ($this->config->get('config_maintenance') == '0' && $maintenancedate > $todays_date) {
                if ($lang == 'de-DE') {
                    $message = sprintf($this->language->get('text_approval2_email'), $this->config->get('config_maintenance_date'));
                } else {
                    $message = sprintf($this->language->get('text_approval2_email_en'), $this->config->get('config_maintenance_date'));
                }
            }


            if ($_SESSION['uploaddata']['name'] == '') {

                if ($lang == 'de-DE') {
                    $message.= $this->language->get('text_approval3_email');
                } else {
                    $message.= $this->language->get('text_approval3_email_en');
                }
            }


            if ($lang == 'de-DE') {
                $message .= $this->language->get('text_footer_email');
            } else {
                $message .= $this->language->get('text_footer_email_en');
            }

            //send email to customer
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($this->request->post['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));

            if ($lang == 'de-DE') {
                $mail->setSubject($this->language->get('heading_title_email'));
            } else {
                $mail->setSubject($this->language->get('heading_title_email_en'));
            }

            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            @$mail->send();


            //mail to Admin

            $message = "Sehr geehrter Damen und Herren,<br/>";
            $message .= "eine neue Anmeldung ist im Shop eingegangen.<br/><br/>";
            $message .= "Mit freundlichen Grüßen<br/><br/>";
            $message .= "www.gerhard-richter-images.de<br/><br/>";
            $message .= "(Diese E-Mail wurde automatisch erstellt)";

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject("Eine neue Anmeldung ist im Shop eingegangen");
            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            @$mail->send();


            if ($_SESSION['uploaddata']['name'] != '') {
                $_SESSION = array();
                $this->redirect(HTTPS_SERVER . 'index.php?route=account/success');
            } else {
                $_SESSION = array();
                $this->redirect(HTTPS_SERVER . 'index.php?route=account/success&upload=0');
            }
        }

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => HTTP_SERVER . 'index.php?route=common/home',
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=account/account',
            'text' => $this->language->get('text_account'),
            'separator' => $this->language->get('text_separator')
        );

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=account/create',
            'text' => $this->language->get('text_create'),
            'separator' => $this->language->get('text_separator')
        );
        $this->data['spesial_text2'] = $this->language->get('spesial_text2');
        $this->data['spesial_text'] = $this->language->get('spesial_text');
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['heading_title2'] = $this->language->get('heading_title2');
        $this->data['heading_title3'] = $this->language->get('heading_title3');
        $this->data['heading_title4'] = $this->language->get('heading_title4');

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

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');

        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_zone'] = $this->language->get('entry_zone');
        $this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['entry_confirm'] = $this->language->get('entry_confirm');

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
        $this->data['communication'] = $this->language->get('communication');





        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['error_warning'] = '';

        //process errors
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        }
        if (isset($this->error['confirm'])) {
            $this->data['error_warning'] = $this->error['confirm'];
        }
        if (isset($this->error['password'])) {
            $this->data['error_warning'] = $this->error['password'];
        }
        if (isset($this->error['username'])) {
            $this->data['error_warning'] = $this->error['username'];
        }
        if (isset($this->error['email'])) {
            $this->data['error_warning'] = $this->error['email'];
        }
        if (isset($this->error['telephone'])) {
            $this->data['error_warning'] = $this->error['telephone'];
        }
        if (isset($this->error['taxid_number'])) {
            $this->data['error_warning'] = $this->error['taxid_number'];
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
        if (isset($this->error['company'])) {
            $this->data['error_warning'] = $this->error['company'];
        }

        if (isset($this->error['ansprechpartner'])) {
            $this->data['error_warning'] = $this->error['ansprechpartner'];
        }


        if (isset($this->error['communic'])) {
            $this->data['error_warning'] = $this->error['communic'];
        }



        $this->data['action'] = HTTPS_SERVER . 'index.php?route=account/create';


        //return data back to form
        if (isset($this->request->post['company'])) {
            $this->data['company'] = $this->request->post['company'];
        } else {
            $this->data['company'] = '';
        }

        if (isset($this->request->post['company2'])) {
            $this->data['company2'] = $this->request->post['company2'];
        } else {
            $this->data['company2'] = '';
        }




        if (isset($this->request->post['communic'])) {
            $this->data['communic'] = $this->request->post['communic'];
        } else {
            $this->data['communic'] = '';
        }


        if (isset($this->request->post['ansprechpartner'])) {
            $this->data['ansprechpartner'] = $this->request->post['ansprechpartner'];
        } else {
            $this->data['ansprechpartner'] = '';
        }

        if (isset($this->request->post['position'])) {
            $this->data['position'] = $this->request->post['position'];
        } else {
            $this->data['position'] = '';
        }

        if (isset($this->request->post['address_1'])) {
            $this->data['address_1'] = $this->request->post['address_1'];
        } else {
            $this->data['address_1'] = '';
        }
        if (isset($this->request->post['bill_address_1'])) {
            $this->data['bill_address_1'] = $this->request->post['bill_address_1'];
        } else {
            $this->data['bill_address_1'] = '';
        }

        if (isset($this->request->post['postcode'])) {
            $this->data['postcode'] = $this->request->post['postcode'];
        } else {
            $this->data['postcode'] = '';
        }
        if (isset($this->request->post['bill_postcode'])) {
            $this->data['bill_postcode'] = $this->request->post['bill_postcode'];
        } else {
            $this->data['bill_postcode'] = '';
        }

        if (isset($this->request->post['city'])) {
            $this->data['city'] = $this->request->post['city'];
        } else {
            $this->data['city'] = '';
        }
        if (isset($this->request->post['bill_city'])) {
            $this->data['bill_city'] = $this->request->post['bill_city'];
        } else {
            $this->data['bill_city'] = '';
        }

        if (isset($this->request->post['land'])) {
            $this->data['land'] = $this->request->post['land'];
        } else {
            $this->data['land'] = 'Germany';
        }
        if (isset($this->request->post['bill_land'])) {
            $this->data['bill_land'] = $this->request->post['bill_land'];
        } else {
            $this->data['bill_land'] = '';
        }

        if (isset($this->request->post['taxid_number'])) {
            $this->data['taxid_number'] = $this->request->post['taxid_number'];
        } else {
            $this->data['taxid_number'] = '';
        }

        if (isset($this->request->post['bill_taxid_number'])) {
            $this->data['bill_taxid_number'] = $this->request->post['bill_taxid_number'];
        } else {
            $this->data['bill_taxid_number'] = '';
        }

        if ($this->request->post['type_person'] == 'firma' || $this->request->post['type_person'] == '') {
            $this->data['firma'] = 'on';
        } else {
            $this->data['firma'] = '';
        }

        if ($this->request->post['type_person'] == 'museum') {
            $this->data['museum'] = 'on';
        } else {
            $this->data['museum'] = '';
        }

        if ($this->request->post['type_person'] == 'privatperson') {
            $this->data['privatperson'] = 'on';
        } else {
            $this->data['privatperson'] = '';
        }




        if (isset($this->request->post['bill_address'])) {
            $this->data['bill_address'] = $this->request->post['bill_address'];
        } else {
            $this->data['bill_address'] = 'on';
        }



        if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
        } else {
            $this->data['telephone'] = '';
        }


        if (isset($this->request->post['bill_telephone'])) {
            $this->data['bill_telephone'] = $this->request->post['bill_telephone'];
        } else {
            $this->data['bill_telephone'] = '';
        }

        if (isset($this->request->post['mobile'])) {
            $this->data['mobile'] = $this->request->post['mobile'];
        } else {
            $this->data['mobile'] = '';
        }
        if (isset($this->request->post['bill_mobile'])) {
            $this->data['bill_mobile'] = $this->request->post['bill_mobile'];
        } else {
            $this->data['bill_mobile'] = '';
        }

        if (isset($this->request->post['fax'])) {
            $this->data['fax'] = $this->request->post['fax'];
        } else {
            $this->data['fax'] = '';
        }
        if (isset($this->request->post['fax'])) {
            $this->data['bill_fax'] = $this->request->post['bill_fax'];
        } else {
            $this->data['bill_fax'] = '';
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } else {
            $this->data['email'] = '';
        }
        if (isset($this->request->post['bill_email'])) {
            $this->data['bill_email'] = $this->request->post['bill_email'];
        } else {
            $this->data['bill_email'] = '';
        }

        if (isset($this->request->post['username'])) {
            $this->data['username'] = $this->request->post['username'];
        } else {
            $this->data['username'] = '';
        }

        if (isset($this->request->post['password'])) {
            $this->data['password'] = $this->request->post['password'];
        } else {
            $this->data['password'] = '';
        }

        if (isset($this->request->post['confirm'])) {
            $this->data['confirm'] = $this->request->post['confirm'];
        } else {
            $this->data['confirm'] = '';
        }

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();





        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/create.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/create.tpl';
        } else {
            $this->template = 'default/template/account/create.tpl';
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
        if ((strlen(utf8_decode($this->request->post['company'])) < 1) || (strlen(utf8_decode($this->request->post['company'])) > 264)) {
            $this->error['company'] = $this->language->get('error_company');
        }

        if ((strlen(utf8_decode($this->request->post['ansprechpartner'])) < 1) || (strlen(utf8_decode($this->request->post['ansprechpartner'])) > 264)) {
            $this->error['ansprechpartner'] = $this->language->get('error_ansprechpartner');
        }


        if ((strlen(utf8_decode($this->request->post['address_1'])) < 1) || (strlen(utf8_decode($this->request->post['address_1'])) > 64)) {
            $this->error['address_1'] = $this->language->get('error_address_1');
        }

        if (((strlen(utf8_decode($this->request->post['bill_address_1'])) < 1) || (strlen(utf8_decode($this->request->post['bill_address_1'])) > 64)) && ($this->request->post['bill_address'] == 'off' )) {
            $this->error['address_1'] = $this->language->get('error_address_1');
        }

        if ((strlen(utf8_decode($this->request->post['postcode'])) < 1) || (strlen(utf8_decode($this->request->post['postcode'])) > 64)) {
            $this->error['postcode'] = $this->language->get('error_postcode');
        }

        if (((strlen(utf8_decode($this->request->post['bill_postcode'])) < 1) || (strlen(utf8_decode($this->request->post['bill_postcode'])) > 64)) && ($this->request->post['bill_address'] == 'off')) {
            $this->error['postcode'] = $this->language->get('error_postcode');
        }

        if ((strlen(utf8_decode($this->request->post['city'])) < 1) || (strlen(utf8_decode($this->request->post['city'])) > 128)) {
            $this->error['city'] = $this->language->get('error_city');
        }


        if (((strlen(utf8_decode($this->request->post['bill_city'])) < 1) || (strlen(utf8_decode($this->request->post['bill_city'])) > 128)) && ($this->request->post['bill_address'] == 'off')) {
            $this->error['city'] = $this->language->get('error_city');
        }

        if ((strlen(utf8_decode($this->request->post['land'])) < 1) || (strlen(utf8_decode($this->request->post['land'])) > 128)) {
            $this->error['land'] = $this->language->get('error_land');
        }


        if (((strlen(utf8_decode($this->request->post['bill_land'])) < 1) || (strlen(utf8_decode($this->request->post['bill_land'])) > 128)) && ($this->request->post['bill_address'] == 'off')) {
            $this->error['land'] = $this->language->get('error_land');
        }

        /* if (((strlen(utf8_decode($this->request->post['taxid_number'])) < 3) || (strlen(utf8_decode($this->request->post['taxid_number'])) > 128)) && ($this->request->post['type_person'] == 'firma')) {
          $this->error['taxid_number'] = $this->language->get('error_taxid_number');
          }
         */




        if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 64)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match(EMAIL_PATTERN, $this->request->post['email']))) {
            $this->error['email'] = $this->language->get('error_email');
        }


        if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
            $this->error['warning'] = $this->language->get('error_exists');
        }


        if ((strlen(utf8_decode($this->request->post['username'])) < 1) || (strlen(utf8_decode($this->request->post['username'])) > 64)) {
            $this->error['username'] = $this->language->get('error_username');
        }

        if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
            $this->error['password'] = $this->language->get('error_password');
        }

        if ($this->request->post['confirm'] != $this->request->post['password']) {
            $this->error['confirm'] = $this->language->get('error_confirm');
        }

        if ($this->request->post['communic'] == '-') {
            $this->error['communic'] = $this->language->get('error_communic');
        }


        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function zone() {
        $output = '<option value="FALSE">' . $this->language->get('text_select') . '</option>';

        $this->load->model('localisation/zone');

        $results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);

        foreach ($results as $result) {
            $output .= '<option value="' . $result['zone_id'] . '"';

            if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
                $output .= ' selected="selected"';
            }

            $output .= '>' . $result['name'] . '</option>';
        }

        if (!$results) {
            if (!$this->request->get['zone_id']) {
                $output .= '<option value="0" selected="selected">' . $this->language->get('text_none') . '</option>';
            } else {
                $output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
            }
        }

        $this->response->setOutput($output, $this->config->get('config_compression'));
    }

    public function postcode() {

        $this->language->load('account/create');

        $this->load->model('localisation/country');

        $result = $this->model_localisation_country->getCountry($this->request->get['country_id']);

        $output = '';

        if (isset($result['postcode_required']) && $result['postcode_required']) {
            $output = '<span class="required">*</span> ' . $this->language->get('entry_postcode');
        } else {
            $output = $this->language->get('entry_postcode');
        }

        $this->response->setOutput($output, $this->config->get('config_compression'));
    }

}

?>