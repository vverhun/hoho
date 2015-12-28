<?php

include "catalog/controller/sale/order.php";

class ControllerAccountNotify extends ControllerSaleOrder {

    public function index() {
        ini_set('display_errors', false);

        $custom_field = $_REQUEST['custom'];
        $payment_status = $_REQUEST['payment_status'];

        $header = '';
        if ($custom_field && trim($payment_status) == 'Completed') {

            $emailtext = '';
            foreach ($_REQUEST as $key => $value) {
                $emailtext .= $key . " = " . $value . '&';
            }

            $this->_process($custom_field, $emailtext);
        } else {

            header("HTTP/1.0 404 Not Found");
        }
    }

    protected function _process($orderId, $sysData) {
        //$this->_loger('before saving',array('ppData'=>$sysData),$orderId);
        $this->load->model('account/order');
        $this->model_account_order->updateStatusData($orderId, 5, $sysData);

        $this->load->model('sale/order');
        $this->load->model('account/customer');
        $this->load->model('sale/customer');

        $order = $this->model_sale_order->getOrder($orderId);
        $customer_info = $this->model_sale_customer->getCustomer($order['customer_id']);
        $lang = $customer_info['lang'];


        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        $message = "Sehr geehrter Damen und Herren,<br> eine neue Bestellung ist im Shop eingegangen.";

        //********* Detailed information about order ******** //
        $customerId = $order['customer_id'];
        $this->load->model('account/customer');
        $this->load->model('sale/customer');

        $customer_info = $this->model_account_customer->getCustomer($order['customer_id']);
        $bill_info = $this->model_account_customer->getBill($order['customer_id']);
        $address_info = $this->model_sale_customer->getAddressesByCustomerId($order['customer_id']);

        $message .= "<br><br><table border=0>";

        $message .= "<tr><td>Einrichtung:</td><td>" . $customer_info['firstname'] . " " . $customer_info['lastname'] . "</td></tr>";
        $message .= "<tr><td>Ansprechpartner:</td><td>" . $customer_info['ansprechpartner'] . "</td></tr>";
        $message .= "<tr><td>Position:	</td><td>" . $customer_info['position'] . "</td></tr>";
        $message .= "<tr><td>Benutzername:</td><td>" . $customer_info['username'] . "</td></tr>	";
        $message .= "<tr><td></td><td></td></tr>";

        $message .= "<tr><td>Straße:</td><td>" . $address_info[0]['address_1'] . "</td></tr>";
        $message .= "<tr><td>PLZ:	</td><td>" . $address_info[0]['postcode'] . "</td></tr> ";
        $message .= "<tr><td>Stadt: </td><td>" . $address_info[0]['city'] . "</td></tr>";
        $message .= "<tr><td>Land:</td><td>" . $address_info[0]['country_id'] . "</td></tr>";
        $message .= "<tr><td>TaxID Number:</td><td>" . $customer_info['taxid_number'] . "</td></tr>";
        $message .= "<tr><td></td><td></td></tr>";
        $message .= "<tr><td>Telefon: </td><td>" . $customer_info['telephone'] . "</td></tr>";
        $message .= "<tr><td>Mobil:	</td><td>" . $customer_info['mobile'] . "</td></tr>";
        $message .= "<tr><td>Fax:	</td><td>" . $customer_info['fax'] . "</td></tr>";
        $message .= "<tr><td>E-Mail:</td><td>" . $customer_info['email'] . "</td></tr>";

        $message .= "</table><br><br>";

        $message .= "<table border=0 cellpadding=5 cellspacing=5><tr><td style='background-color:#bebebe;font-weight:bold;'></td><td style='background-color:#bebebe;font-weight:bold;'>Titel:</td><td style='background-color:#bebebe;font-weight:bold;'>Vorschau:</td><td style='background-color:#bebebe;font-weight:bold;'>Rubrick:</td><td style='background-color:#bebebe;font-weight:bold;'>Dateiname:</td>";

        $ind = 1;

        $this->load->model('catalog/category');
        $this->load->model('account/order');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        //$order =  $this->model_sale_order->getOrder($orderId);

        $order_products = $this->model_sale_order->getOrderProducts($orderId);

        foreach ($order_products as $product) {
            $product = $this->model_catalog_product->getProduct($product['product_id']);
            if ($product['image']) {
                $image = $product['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $category = $this->model_catalog_product->getCategories($product['product_id']);
            $category = $category[0]['category_id'];
            $category_info = $this->model_catalog_category->getCategory($category);

            $message .= "<tr><td>" . $ind . "</td>";
            $message .= "<td>CR:" . $product['sku'] . ", " . $product['name'] . "</td>";
            $message .= "<td><img src='" . $this->model_tool_image->resize($image, 117, 117) . "' /></td>";
            $message .= "<td>" . $category_info['name'] . "</td>";
            $message .= "<td>" . str_replace('data/', '', $image) . "</td></tr>";

            $ind++;
        }

        $message .= "</table><br><br>";

        //***************************************************************************************************************************** //

        $message .= "<br><br>Mit freundlichen Grüßen<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(Diese E-Mail wurde automatisch erstellt)<br>";

        $mail->setTo('support@gerhard-richter-images.de');

        //$mail->setTo('vverhun@gmail.com');

        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));
        $mail->setSubject('Eine neue Bestellung ist eingegangen');
        $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
        @$mail->send();

        $mail->setTo('vverhun@gmail.com');
        @$mail->send();


        //send email to customer
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        $pdfname = $this->saveorder($orderId);


        if ($lang == 'de-DE') {
            $message = 'Sehr geehrter Damen und Herren,<br>wir bedanken uns für Ihren Einkauf.<br><br>Mit freundlichen Grüßen<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(Diese E-Mail wurde automatisch erstellt)<br>';

            $mail->setTo($order['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject('Danke');
            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            $mail->addAttachment('invoice' . $orderId . '.pdf', 'invoice.pdf');
            @$mail->send();

            $mail->setTo('vverhun@gmail.com');
            @$mail->send();
        } else {
            $message = 'Dear Ladies & Gentlemen,<br>thank you for your purchase!<br><br>Kind regards,<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(This email was generated automatically)<br>';

            $mail->setTo($order['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject('Thank you');
            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            $mail->addAttachment('invoice' . $orderId . '.pdf', 'invoice.pdf');
            @$mail->send();

            $mail->setTo('vverhun@gmail.com');
            @$mail->send();
        }


        //$this->_loger('after saving',array('ppData'=>$sysData),$orderId);
    }

    public function manuelle() {
        $orderId = $this->request->get['order_id'];

        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }

        $this->_process($orderId, "");

        $this->redirect(HTTPS_SERVER . 'index.php?route=sale/order/bearbeitete');
    }

    public function testprocess() {
        //$this->_loger('before saving',array('ppData'=>$sysData),$orderId);
        ini_set('display_errors', '1');
        $sysData = '';



        $this->load->model('account/order');
        //$this->model_account_order->updateStatusData( $orderId, 5, $sysData );
        $orderId = $this->request->get['order_id'];
        $this->load->model('account/order');
        $this->model_account_order->updateStatusData($orderId, 5, $sysData);

        $this->load->model('sale/order');
        $this->load->model('account/customer');
        $this->load->model('sale/customer');

        $order = $this->model_sale_order->getOrder($orderId);
        $customer_info = $this->model_sale_customer->getCustomer($order['customer_id']);
        $lang = $customer_info['lang'];


        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        $message = "Sehr geehrter Damen und Herren,<br> eine neue Bestellung ist im Shop eingegangen.";

        //********* Detailed information about order ******** //

        $customerId = $order['customer_id'];
        $this->load->model('account/customer');
        $this->load->model('sale/customer');

        $customer_info = $this->model_account_customer->getCustomer($order['customer_id']);
        $bill_info = $this->model_account_customer->getBill($order['customer_id']);
        $address_info = $this->model_sale_customer->getAddressesByCustomerId($order['customer_id']);

        $message .= "<br><br><table border=0>";

        $message .= "<tr><td>Einrichtung:</td><td>" . $customer_info['firstname'] . " " . $customer_info['lastname'] . "</td></tr>";
        $message .= "<tr><td>Ansprechpartner:</td><td>" . $customer_info['ansprechpartner'] . "</td></tr>";
        $message .= "<tr><td>Position:	</td><td>" . $customer_info['position'] . "</td></tr>";
        $message .= "<tr><td>Benutzername:</td><td>" . $customer_info['username'] . "</td></tr>	";
        $message .= "<tr><td></td><td></td></tr>";

        $message .= "<tr><td>Straße:</td><td>" . $address_info[0]['address_1'] . "</td></tr>";
        $message .= "<tr><td>PLZ:	</td><td>" . $address_info[0]['postcode'] . "</td></tr> ";
        $message .= "<tr><td>Stadt: </td><td>" . $address_info[0]['city'] . "</td></tr>";
        $message .= "<tr><td>Land:</td><td>" . $address_info[0]['country_id'] . "</td></tr>";
        $message .= "<tr><td>TaxID Number:</td><td>" . $customer_info['taxid_number'] . "</td></tr>";
        $message .= "<tr><td></td><td></td></tr>";
        $message .= "<tr><td>Telefon: </td><td>" . $customer_info['telephone'] . "</td></tr>";
        $message .= "<tr><td>Mobil:	</td><td>" . $customer_info['mobile'] . "</td></tr>";
        $message .= "<tr><td>Fax:	</td><td>" . $customer_info['fax'] . "</td></tr>";
        $message .= "<tr><td>E-Mail:</td><td>" . $customer_info['email'] . "</td></tr>";

        $message .= "</table><br><br>";

        $message .= "<table border=0 cellpadding=5 cellspacing=5><tr><td style='background-color:#bebebe;font-weight:bold;'></td><td style='background-color:#bebebe;font-weight:bold;'>Titel:</td><td style='background-color:#bebebe;font-weight:bold;'>Vorschau:</td><td style='background-color:#bebebe;font-weight:bold;'>Rubrick:</td><td style='background-color:#bebebe;font-weight:bold;'>Dateiname:</td>";

        $ind = 1;

        $this->load->model('catalog/category');
        $this->load->model('account/order');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        //$order =  $this->model_sale_order->getOrder($orderId);

        $order_products = $this->model_sale_order->getOrderProducts($orderId);

        foreach ($order_products as $product) {
            $product = $this->model_catalog_product->getProduct($product['product_id']);
            if ($product['image']) {
                $image = $product['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $category = $this->model_catalog_product->getCategories($product['product_id']);
            $category = $category[0]['category_id'];
            $category_info = $this->model_catalog_category->getCategory($category);

            $message .= "<tr><td>" . $ind . "</td>";
            $message .= "<td>CR:" . $product['sku'] . ", " . $product['name'] . "</td>";
            $message .= "<td><img src='" . $this->model_tool_image->resize($image, 117, 117) . "' /></td>";
            $message .= "<td>" . $category_info['name'] . "</td>";
            $message .= "<td>" . str_replace('data/', '', $image) . "</td></tr>";

            $ind++;
        }

        $message .= "</table><br><br>";

        //***************************************************************************************************************************** //
        $message .= "<br><br>Mit freundlichen Grüßen<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(Diese E-Mail wurde automatisch erstellt)<br>";

        //$mail->setTo('support@gerhard-richter-images.de');

        $mail->setTo('vverhun@gmail.com');

        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));
        $mail->setSubject('Eine neue Bestellung ist eingegangen');
        $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
        $mail->send();


        //send email to customer
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');


        $pdfname = $this->saveorder($orderId);


        if ($lang == 'de-DE') {
            $message = 'Sehr geehrter Damen und Herren,<br>wir bedanken uns für Ihren Einkauf.<br><br>Mit freundlichen Grüßen<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(Diese E-Mail wurde automatisch erstellt)<br>';

            $mail->setTo('vverhun@gmail.com');
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject('Danke');
            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            $mail->addAttachment('invoice' . $orderId . '.pdf', 'invoice.pdf');
            $mail->send();
        } else {
            $message = 'Dear Ladies & Gentlemen,<br>thank you for your purchase!<br><br>Kind regards,<br><br>Atelier Richter<br>Osterriethweg 22<br>D - 50996 Köln<br>Telefon: +49 / 22 36 / 96 56 10<br>Fax: +49 / 22 36 / 96 56 12<br>e-mail: gerhard.richter@netcologne.de<br><br>(This email was generated automatically)<br>';

            $mail->setTo('vverhun@gmail.com');
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject('Thank you');
            $mail->setHtml($message, ENT_QUOTES, 'UTF-8');
            $mail->addAttachment('invoice' . $orderId . '.pdf', 'invoice.pdf');
            $mail->send();
        }
        die();



        //$this->_loger('after saving',array('ppData'=>$sysData),$orderId);
    }

    protected function _loger($step, $data, $orderId) {
        $handle = fopen(DIR_LOGS . 'error.log', 'a+');
        fwrite($handle, 'STEP ' . $step . PHP_EOL);
        $string = 'Order id: ' . $orderId . PHP_EOL;
        fwrite($handle, $string);
        foreach ($data as $key => $value) {
            $string = $key . '=' . $value . PHP_EOL;
            fwrite($handle, $string);
        }
        fclose($handle);
    }

}

?>
