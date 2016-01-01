<?php

class ControllerAccountHistory extends Controller {

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/history';

            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
        }

        $this->language->load('account/history');

        $this->document->title = $this->language->get('heading_title');

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
            'href' => HTTPS_SERVER . 'index.php?route=account/history',
            'text' => $this->language->get('text_history'),
            'separator' => $this->language->get('text_separator')
        );

        $this->load->model('account/order');

        $order_total = $this->model_account_order->getTotalOrders();
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['my_prgect'] = $this->language->get('my_prgect');
        $this->data['my_angared'] = $this->language->get('my_angared');
        $this->data['my_offersStudio'] = $this->language->get('my_offersStudio');
        $this->data['my_complatedProgect'] = $this->language->get('my_complatedProgect');
        $this->data['my_openProgect'] = $this->language->get('my_openProgect');
        $this->data['my_NO'] = $this->language->get('my_NO');
        $this->data['my_sentReqvest'] = $this->language->get('my_sentReqvest');
        $this->data['my_image'] = $this->language->get('my_image');
        $this->data['my_getOffer'] = $this->language->get('my_getOffer');
        $this->data['my_Preis'] = $this->language->get('my_Preis');
        $this->data['my_Status'] = $this->language->get('my_Status');
        $this->data['my_edit'] = $this->language->get('my_edit');
        $this->data['my_show'] = $this->language->get('my_show');
        $this->data['my_title'] = $this->language->get('my_title');
        $this->data['my_plasing'] = $this->language->get('my_plasing');
        $this->data['my_type'] = $this->language->get('my_type');
        $this->data['my_rep'] = $this->language->get('my_rep');
        $this->data['my_size'] = $this->language->get('my_size');
        $this->data['my_total'] = $this->language->get('my_total');
        $this->data['my_totalAm'] = $this->language->get('my_totalAm');
        $this->data['my_close'] = $this->language->get('my_close');
        $this->data['my_comment'] = $this->language->get('my_comment');
        $this->data['my_archive'] = $this->language->get('my_archive');
        $this->data['my_angebot'] = $this->language->get('my_angebot');
        $this->data['my_offen'] = $this->language->get('my_offen');
        $this->data['my_bezahlt'] = $this->language->get('my_bezahlt');
        $this->data['my_abgelehnt'] = $this->language->get('my_abgelehnt');
        $this->data['approved_text'] = $this->language->get('approved_text');
        $this->data['my_front_page'] = $this->language->get('my_front_page');
        $this->data['my_inside'] = $this->language->get('my_inside');
        $this->data['print'] = $this->language->get('print');
        $this->data['text_order'] = $this->language->get('text_order');
        $this->data['text_status'] = $this->language->get('text_status');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_products'] = $this->language->get('text_products');
        $this->data['text_total'] = $this->language->get('text_total');
        $this->data['my_tax'] = $this->language->get('my_tax');
        $this->data['my_subtotal'] = $this->language->get('my_subtotal');
        $this->data['my_kasse'] = $this->language->get('my_kasse');
        $this->data['my_verwerfen'] = $this->language->get('my_verwerfen');
        $this->data['button_view'] = $this->language->get('button_view');
        $this->data['button_continue'] = $this->language->get('button_continue');
        if ($order_total) {

            $this->data['action'] = HTTP_SERVER . 'index.php?route=account/history';
            if (!$this->config->get('pp_standard_test')) {
                $this->data['actionPP'] = 'https://www.paypal.com/cgi-bin/webscr';
            } else {
                $this->data['actionPP'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            }
            $this->data['business'] = $this->config->get('pp_standard_email');
            $this->data['notifyUrl'] = PP_NOTIFY_URL;


            $this->getOrdersList1(1);

            $this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/account';
            $this->template = 'default/template/account/history_offene.tpl';
            $this->children = array(
                'common/column_right',
                'common/footer',
                'common/column_left',
                'common/header'
            );

            $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
        } else {
            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_error'] = $this->language->get('text_error');

            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/account';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
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

    public function angebote() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/history';

            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
        }

        $this->language->load('account/history');

        $this->document->title = $this->language->get('heading_title');

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
            'href' => HTTPS_SERVER . 'index.php?route=account/history',
            'text' => $this->language->get('text_history'),
            'separator' => $this->language->get('text_separator')
        );

        $this->load->model('account/order');

        $order_total = $this->model_account_order->getTotalOrders();
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['my_prgect'] = $this->language->get('my_prgect');
        $this->data['my_angared'] = $this->language->get('my_angared');
        $this->data['my_offersStudio'] = $this->language->get('my_offersStudio');
        $this->data['my_offersStudio_'] = $this->language->get('my_offersStudio_');

        $this->data['my_complatedProgect'] = $this->language->get('my_complatedProgect');
        $this->data['my_openProgect'] = $this->language->get('my_openProgect');
        $this->data['my_NO'] = $this->language->get('my_NO');
        $this->data['my_sentReqvest'] = $this->language->get('my_sentReqvest');
        $this->data['my_image'] = $this->language->get('my_image');
        $this->data['my_getOffer'] = $this->language->get('my_getOffer');
        $this->data['my_Preis'] = $this->language->get('my_Preis');
        $this->data['my_Status'] = $this->language->get('my_Status');
        $this->data['my_edit'] = $this->language->get('my_edit');
        $this->data['my_show'] = $this->language->get('my_show');
        $this->data['my_title'] = $this->language->get('my_title');
        $this->data['my_plasing'] = $this->language->get('my_plasing');
        $this->data['my_type'] = $this->language->get('my_type');
        $this->data['my_rep'] = $this->language->get('my_rep');
        $this->data['my_size'] = $this->language->get('my_size');
        $this->data['my_total'] = $this->language->get('my_total');
        $this->data['my_totalAm'] = $this->language->get('my_totalAm');
        $this->data['my_close'] = $this->language->get('my_close');
        $this->data['my_comment'] = $this->language->get('my_comment');
        $this->data['my_archive'] = $this->language->get('my_archive');
        $this->data['my_angebot'] = $this->language->get('my_angebot');
        $this->data['my_offen'] = $this->language->get('my_offen');
        $this->data['my_bezahlt'] = $this->language->get('my_bezahlt');
        $this->data['my_abgelehnt'] = $this->language->get('my_abgelehnt');
        $this->data['approved_text'] = $this->language->get('approved_text');
        $this->data['my_front_page'] = $this->language->get('my_front_page');
        $this->data['my_inside'] = $this->language->get('my_inside');
        $this->data['print'] = $this->language->get('print');
        $this->data['text_order'] = $this->language->get('text_order');
        $this->data['text_status'] = $this->language->get('text_status');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_products'] = $this->language->get('text_products');
        $this->data['text_total'] = $this->language->get('text_total');
        $this->data['my_tax'] = $this->language->get('my_tax');
        $this->data['my_subtotal'] = $this->language->get('my_subtotal');
        $this->data['my_kasse'] = $this->language->get('my_kasse');
        $this->data['my_verwerfen'] = $this->language->get('my_verwerfen');
        $this->data['button_view'] = $this->language->get('button_view');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['approved_message'] = $this->language->get('approved_message');

        $this->data['action'] = HTTP_SERVER . 'index.php?route=account/history';
        if (!$this->config->get('pp_standard_test')) {
            $this->data['actionPP'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $this->data['actionPP'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        $this->data['business'] = $this->config->get('pp_standard_email');
        $this->data['notifyUrl'] = PP_NOTIFY_URL;


        $this->getOrdersList1(3);

        $this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/account';
        $this->template = 'default/template/account/history_angebote.tpl';
        $this->children = array(
            'common/column_right',
            'common/footer',
            'common/column_left',
            'common/header'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function abgeschlossene() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=account/history';
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
        }

        $this->language->load('account/history');

        $this->document->title = $this->language->get('heading_title');

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
            'href' => HTTPS_SERVER . 'index.php?route=account/history',
            'text' => $this->language->get('text_history'),
            'separator' => $this->language->get('text_separator')
        );

        $this->load->model('account/order');

        $order_total = $this->model_account_order->getTotalOrders();
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['my_prgect'] = $this->language->get('my_prgect');
        $this->data['my_angared'] = $this->language->get('my_angared');
        $this->data['my_offersStudio'] = $this->language->get('my_offersStudio');
        $this->data['my_complatedProgect'] = $this->language->get('my_complatedProgect');
        $this->data['my_openProgect'] = $this->language->get('my_openProgect');
        $this->data['my_NO'] = $this->language->get('my_NO');
        $this->data['my_sentReqvest'] = $this->language->get('my_sentReqvest');
        $this->data['my_image'] = $this->language->get('my_image');
        $this->data['my_getOffer'] = $this->language->get('my_getOffer');
        $this->data['my_Preis'] = $this->language->get('my_Preis');
        $this->data['my_Status'] = $this->language->get('my_Status');
        $this->data['my_edit'] = $this->language->get('my_edit');
        $this->data['my_show'] = $this->language->get('my_show');
        $this->data['my_title'] = $this->language->get('my_title');
        $this->data['my_plasing'] = $this->language->get('my_plasing');
        $this->data['my_type'] = $this->language->get('my_type');
        $this->data['my_rep'] = $this->language->get('my_rep');
        $this->data['my_size'] = $this->language->get('my_size');
        $this->data['my_total'] = $this->language->get('my_total');
        $this->data['my_totalAm'] = $this->language->get('my_totalAm');
        $this->data['my_close'] = $this->language->get('my_close');
        $this->data['my_comment'] = $this->language->get('my_comment');
        $this->data['my_archive'] = $this->language->get('my_archive');
        $this->data['my_angebot'] = $this->language->get('my_angebot');
        $this->data['my_offen'] = $this->language->get('my_offen');
        $this->data['my_bezahlt'] = $this->language->get('my_bezahlt');
        $this->data['my_abgelehnt'] = $this->language->get('my_abgelehnt');
        $this->data['approved_text'] = $this->language->get('approved_text');
        $this->data['my_front_page'] = $this->language->get('my_front_page');
        $this->data['my_inside'] = $this->language->get('my_inside');
        $this->data['print'] = $this->language->get('print');
        $this->data['text_order'] = $this->language->get('text_order');
        $this->data['text_status'] = $this->language->get('text_status');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_customer'] = $this->language->get('text_customer');
        $this->data['text_products'] = $this->language->get('text_products');
        $this->data['text_total'] = $this->language->get('text_total');
        $this->data['my_tax'] = $this->language->get('my_tax');
        $this->data['my_subtotal'] = $this->language->get('my_subtotal');
        $this->data['my_kasse'] = $this->language->get('my_kasse');
        $this->data['my_verwerfen'] = $this->language->get('my_verwerfen');
        $this->data['button_view'] = $this->language->get('button_view');
        $this->data['button_continue'] = $this->language->get('button_continue');


        $this->data['action'] = HTTP_SERVER . 'index.php?route=account/history';
        if (!$this->config->get('pp_standard_test')) {
            $this->data['actionPP'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $this->data['actionPP'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        $this->data['business'] = $this->config->get('pp_standard_email');
        $this->data['notifyUrl'] = PP_NOTIFY_URL;

        $this->getOrdersList2();
        $this->data['continue'] = HTTPS_SERVER . 'index.php?route=account/account';
        $this->template = 'default/template/account/history_abgeschlossene.tpl';
        $this->children = array(
            'common/column_right',
            'common/footer',
            'common/column_left',
            'common/header'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function getOrdersList1($type) {


        $this->data['action'] = HTTP_SERVER . 'index.php?route=account/history';

        $totals = $this->model_account_order->getTotalCountOfOrdersByStatus();
        $this->data['orders_total1'] = $totals[0];
        $this->data['orders_total2'] = $totals[1];
        $this->data['orders_total3'] = $totals[2];


        $this->data['orders1'] = array();

        if ($type == 1) {
            $results = $this->model_account_order->getOrders1();
        }

        if ($type == 3) {
            $results = $this->model_account_order->getOrders3();
        }
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->language->load('checkout/cart');
        $this->data['my_book'] = $this->language->get('my_book');
        $this->data['my_artCatalog'] = $this->language->get('my_artCatalog');
        $this->data['my_broshur'] = $this->language->get('my_broshur');
        $this->data['my_promotion'] = $this->language->get('my_promotion');
        $this->data['my_jornal'] = $this->language->get('my_jornal');
        $this->data['my_newspaper'] = $this->language->get('my_newspaper');
        $this->data['my_calendarr'] = $this->language->get('my_calendarr');
        $this->data['my_promcalendar'] = $this->language->get('my_promcalendar');

        $this->data['auction_Catalog'] = $this->language->get('auction_Catalog');
        $this->data['my_advert'] = $this->language->get('my_advert');
        $this->data['my_others'] = $this->language->get('my_others');



        $this->data['my_tax'] = $this->language->get('my_tax');

        $this->data['my_subtotal'] = $this->language->get('my_subtotal');

        $this->load->model('account/customer');
        $customer_type = $this->model_account_customer->getCustomerType($this->customer->getId());

        $this->data['numberpercent'] = "0";
        if ($customer_type == 1 or $customer_type == 2 or $customer_type == 4 or $customer_type == 7) {
            $this->data['numberpercent'] = "7";
        }


        $art = array();
        $art['1'] = $this->data['my_book'];
        $art['2'] = $this->data['my_artCatalog'];
        $art['3'] = $this->data['my_broshur'];
        $art['4'] = $this->data['my_promotion'];
        $art['5'] = $this->data['my_jornal'];
        $art['6'] = $this->data['my_newspaper'];
        $art['7'] = $this->data['my_calendarr'];
        $art['8'] = $this->data['my_promcalendar'];

        $art['9'] = $this->data['auction_Catalog'];
        $art['10'] = $this->data['my_advert'];
        $art['11'] = $this->data['my_others'];



        foreach ($results as $result) {
            $product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
            $order_products = $this->model_account_order->getOrderProducts($result['order_id']);
            $products_order = array();

            foreach ($order_products as $order_product) {
                $product_id = $order_product['product_id'];
                $product_details = $this->model_catalog_product->getProduct($product_id);
                if ($product_details['image']) {
                    $image = $product_details['image'];
                } else {
                    $image = 'no_image.jpg';
                }
                $sku = ($product_details['sku'] == -1 ) ? "0" : $product_details['sku'];

                $products_order[] = array(
                    'name' => $order_product['name'],
                    'titel' => $order_product['titel'],
                    'komentar' => $order_product['komentar'],
                    'titelseite' => $order_product['titelseite'],
                    'innenseite' => $order_product['innenseite'],
                    'art' => $art[$order_product['art']],
                    'auflage' => $order_product['auflage'],
                    'grosse' => $order_product['grosse'],
                    'total' => $order_product['total'],
                    'status_id' => $order_product['status_id'],
                    'sku' => $sku,
                    'art_id' => $order_product['art'],
                    'thumb' => $this->model_tool_image->resize($image, 117, 117),
                    'id' => $product_id
                );
            }

            $status = $result['order_status_id'];

            //status:
            // 1 - pending
            // 3 - proposal
            // 5 - paid
            // 7 - cancelled


            if ($status == '1') {
            
                $status = "<span style='color:red'>" . $this->data['my_offen'] . "</span>";
            }
            if ($status == '3') {
          
                $status = "<span style='color:blue'>" . $this->data['my_angebot'] . "</span>";
            }

            $this->data['orders1'][] = array(
                'order_id' => $result['order_id'],
                'name' => $result['firstname'] . ' ' . $result['lastname'],
                'status' => $status,
                'order_status_id' => $result['order_status_id'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'products' => $product_total,
                'subtotal' => $result['subtotal'],
                'tax' => $result['tax'],
                'total' => $result['total'],
                'href' => HTTPS_SERVER . 'index.php?route=account/invoice&order_id=' . $result['order_id'],
                'products_orders' => $products_order
            );
        }
    }

    private function geTotalOrders() {
        $this->data['orders_total1'] = 0;
        $this->data['orders_total2'] = 0;
        $this->data['orders_total3'] = 0;
    }

    private function getOrdersList2() {



        $this->data['action'] = HTTP_SERVER . 'index.php?route=account/history';


        $this->data['orders2'] = array();
        $totals = $this->model_account_order->getTotalCountOfOrdersByStatus();
        $this->data['orders_total1'] = $totals[0];
        $this->data['orders_total2'] = $totals[1];
        $this->data['orders_total3'] = $totals[2];



        $results = $this->model_account_order->getOrders2();
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        $this->language->load('checkout/cart');
        $this->data['my_book'] = $this->language->get('my_book');
        $this->data['my_artCatalog'] = $this->language->get('my_artCatalog');
        $this->data['my_broshur'] = $this->language->get('my_broshur');
        $this->data['my_promotion'] = $this->language->get('my_promotion');
        $this->data['my_jornal'] = $this->language->get('my_jornal');
        $this->data['my_newspaper'] = $this->language->get('my_newspaper');
        $this->data['my_calendarr'] = $this->language->get('my_calendarr');
        $this->data['my_promcalendar'] = $this->language->get('my_promcalendar');
        $this->data['my_tax'] = $this->language->get('my_tax');
        $this->data['auction_Catalog'] = $this->language->get('auction_Catalog');
        $this->data['my_advert'] = $this->language->get('my_advert');
        $this->data['my_others'] = $this->language->get('my_others');
        $this->data['my_subtotal'] = $this->language->get('my_subtotal');

        $this->load->model('account/customer');
        $customer_type = $this->model_account_customer->getCustomerType($this->customer->getId());

        $this->data['numberpercent'] = "0";
        if ($customer_type == 1 or $customer_type == 2 or $customer_type == 4 or $customer_type == 7) {
            $this->data['numberpercent'] = "7";
        }

        $art = array();
        $art['1'] = $this->data['my_book'];
        $art['2'] = $this->data['my_artCatalog'];
        $art['3'] = $this->data['my_broshur'];
        $art['4'] = $this->data['my_promotion'];
        $art['5'] = $this->data['my_jornal'];
        $art['6'] = $this->data['my_newspaper'];
        $art['7'] = $this->data['my_calendarr'];
        $art['8'] = $this->data['my_promcalendar'];
        $art['9'] = $this->data['auction_Catalog'];
        $art['10'] = $this->data['my_advert'];
        $art['11'] = $this->data['my_others'];

        foreach ($results as $result) {
            $product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
            $order_products = $this->model_account_order->getOrderProducts($result['order_id']);
            $products_order = array();

            foreach ($order_products as $order_product) {
                $product_id = $order_product['product_id'];
                $product_details = $this->model_catalog_product->getProduct($product_id);
                if ($product_details['image']) {
                    $image = $product_details['image'];
                } else {
                    $image = 'no_image.jpg';
                }
                if (intval($order_product['status_id']) != 0) {

                    $products_order[] = array(
                        'name' => $order_product['name'],
                        'titel' => $order_product['titel'],
                        'komentar' => $order_product['komentar'],
                        'titelseite' => $order_product['titelseite'],
                        'innenseite' => $order_product['innenseite'],
                        'art' => $art[$order_product['art']],
                        'auflage' => $order_product['auflage'],
                        'status_id' => $order_product['status_id'],
                        'grosse' => $order_product['grosse'],
                        'total' => $order_product['total'],
                        'sku' => $product_details['sku'],
                        'art_id' => $order_product['art'],
                        'thumb' => $this->model_tool_image->resize($image, 117, 117)
                    );
                }
            }

            $status = $result['order_status_id'];


            if ($status == '5')
                $status = "<span style='color:green'>" . $this->data['my_bezahlt'] . "</span>";
            if ($status == '7')
                $status = "<span style='color:#404042;'>" . $this->data['my_abgelehnt'] . "</span>";
          
            $this->data['orders2'][] = array(
                'order_id' => $result['order_id'],
                'order_status_id' => $result['order_status_id'],
                'name' => $result['firstname'] . ' ' . $result['lastname'],
                'status' => $status,
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'products' => $product_total,
                'subtotal' => $result['subtotal'],
                'tax' => $result['tax'],
                'total' => $result['total'],
                'href' => HTTPS_SERVER . 'index.php?route=account/invoice&order_id=' . $result['order_id'],
                'products_orders' => $products_order
            );
        }
    }

}

?>
