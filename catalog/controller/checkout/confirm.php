<?php
class ControllerCheckoutConfirm extends Controller {
	private $error = array();

	public function index() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['coupon']) && $this->validateCoupon()) {
			$this->session->data['coupon'] = $this->request->post['coupon'];

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/confirm');
		}

		if (!$this->cart->hasProducts() || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/cart');
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';

			$this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
		}

		if ($this->cart->hasShipping()) {
			if (!isset($this->session->data['shipping_address_id']) || !$this->session->data['shipping_address_id']) {
				$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/shipping');
			}

			if (!isset($this->session->data['shipping_method'])) {
				$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/shipping');
			}
		} else {
			unset($this->session->data['shipping_address_id']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}

		/*if (!isset($this->session->data['payment_address_id']) || !$this->session->data['payment_address_id']) {
		 $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/payment');
		 }

		 if (!isset($this->session->data['payment_method'])) {
		 $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/payment');
		 }
		 */
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
			
		$this->load->model('checkout/extension');

		$sort_order = array();

		$results = $this->model_checkout_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			$this->load->model('total/' . $result['key']);

			$this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
		}

		$sort_order = array();
			
		foreach ($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $total_data);

		$this->language->load('checkout/confirm');

		$this->document->title = $this->language->get('heading_title');

		$data = array();

		$data['store_id'] = $this->config->get('config_store_id');
		$data['store_name'] = $this->config->get('config_name');
		$data['store_url'] = $this->config->get('config_url');
		$data['customer_id'] = $this->customer->getId();
		$data['customer_group_id'] = $this->customer->getCustomerGroupId();
		$data['firstname'] = $this->customer->getFirstName();
		$data['lastname'] = $this->customer->getLastName();
		$data['email'] = $this->customer->getEmail();
		$data['telephone'] = $this->customer->getTelephone();
		$data['fax'] = $this->customer->getFax();

		$this->load->model('account/address');

		if ($this->cart->hasShipping()) {
			$shipping_address_id = $this->session->data['shipping_address_id'];

			$shipping_address = $this->model_account_address->getAddress($shipping_address_id);

			$data['shipping_firstname'] = $shipping_address['firstname'];
			$data['shipping_lastname']  = $shipping_address['lastname'];
			$data['shipping_company']   = $shipping_address['company'];
			$data['shipping_address_1'] = $shipping_address['address_1'];
			$data['shipping_address_2'] = $shipping_address['address_2'];
			$data['shipping_city']      = $shipping_address['city'];
			$data['shipping_postcode']  = $shipping_address['postcode'];
			$data['shipping_zone']      = $shipping_address['zone'];
			$data['shipping_zone_id']   = $shipping_address['zone_id'];
			$data['shipping_country']   = $shipping_address['country'];
			$data['shipping_country_id'] = $shipping_address['country_id'];
			$data['shipping_address_format'] = $shipping_address['address_format'];

			if (isset($this->session->data['shipping_method']['title'])) {
				$data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$data['shipping_method'] = '';
			}
		} else {
			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_zone'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_country'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_address_format'] = '';
			$data['shipping_method'] = '';
		}

		$payment_address_id = $this->session->data['payment_address_id'];

		$payment_address = $this->model_account_address->getAddress($payment_address_id);

		$data['payment_firstname'] = $payment_address['firstname'];
		$data['payment_lastname'] = $payment_address['lastname'];
		$data['payment_company'] = $payment_address['company'];
		$data['payment_address_1'] = $payment_address['address_1'];
		$data['payment_address_2'] = $payment_address['address_2'];
		$data['payment_city'] = $payment_address['city'];
		$data['payment_postcode'] = $payment_address['postcode'];
		$data['payment_zone'] = $payment_address['zone'];
		$data['payment_zone_id'] = $payment_address['zone_id'];
		$data['payment_country'] = $payment_address['country'];
		$data['payment_country_id'] = $payment_address['country_id'];
		$data['payment_address_format'] = $payment_address['address_format'];

		if (!$this->cart->hasShipping()) {
			$this->tax->setZone($payment_address['country_id'], $payment_address['zone_id']);
		}

		if (isset($this->session->data['payment_method']['title'])) {
			$data['payment_method'] = $this->session->data['payment_method']['title'];
		} else {
			$data['payment_method'] = '';
		}

			


		$product_data = array();
		$this->load->model('tool/image');
		$this->load->model('catalog/product');

		$prices_cat = array();

		//Bücher
		$seite = $this->language->get('seite');
		$weitere	=  $this->language->get('weitere');  //'je weitere';
		$gdin	=  $this->language->get('gdin'); //'größer als DIN';
		$din	=  $this->language->get('din'); //= 'bis DIN';
		$daruber	=  $this->language->get('daruber'); //= 'darüber';


		$prices_cat['1']['1/8 '.$seite]['3 000'] =  39;
		$prices_cat['1']['1/8 '.$seite]['5 000'] =	54;
		$prices_cat['1']['1/8 '.$seite]['7 500'] =	76;
		$prices_cat['1']['1/8 '.$seite]['10 000'] =	88;
		$prices_cat['1']['1/8 '.$seite]['15 000'] =	96;
		$prices_cat['1']['1/8 '.$seite]['20 000'] =	104;
		$prices_cat['1']['1/8 '.$seite]['30 000'] =	116;
		$prices_cat['1']['1/8 '.$seite]['50 000'] =	150;
		$prices_cat['1']['1/8 '.$seite]['80 000'] =	183;
		$prices_cat['1']['1/8 '.$seite][$weitere.' 10.000'] = 20;

		$prices_cat['1']['1/4 '.$seite]['3 000']=49;
		$prices_cat['1']['1/4 '.$seite]['5 000']=68;
		$prices_cat['1']['1/4 '.$seite]['7 500']=95;
		$prices_cat['1']['1/4 '.$seite]['10 000']=110;
		$prices_cat['1']['1/4 '.$seite]['15 000']=120;
		$prices_cat['1']['1/4 '.$seite]['20 000']=130;
		$prices_cat['1']['1/4 '.$seite]['30 000']=145;
		$prices_cat['1']['1/4 '.$seite]['50 000']=187;
		$prices_cat['1']['1/4 '.$seite]['80 000']=228;
		$prices_cat['1']['1/4 '.$seite][$weitere.' 10.000']=25;

		$prices_cat['1']['1/2 '.$seite]['3 000']=61;
		$prices_cat['1']['1/2 '.$seite]['5 000']=85;
		$prices_cat['1']['1/2 '.$seite]['7 500']=119;
		$prices_cat['1']['1/2 '.$seite]['10 000']=138 ;
		$prices_cat['1']['1/2 '.$seite]['15 000']=150;
		$prices_cat['1']['1/2 '.$seite]['20 000']=163;
		$prices_cat['1']['1/2 '.$seite]['30 000']=181 ;
		$prices_cat['1']['1/2 '.$seite]['50 000']=234;
		$prices_cat['1']['1/2 '.$seite]['80 000']=285;
		$prices_cat['1']['1/2 '.$seite][$weitere.' 10.000']=31;

		$prices_cat['1']['1/1 '.$seite]['3 000']=76 ;
		$prices_cat['1']['1/1 '.$seite]['5 000']=106 ;
		$prices_cat['1']['1/1 '.$seite]['7 500']=148 ;
		$prices_cat['1']['1/1 '.$seite]['10 000']=172 ;
		$prices_cat['1']['1/1 '.$seite]['15 000']=188 ;
		$prices_cat['1']['1/1 '.$seite]['20 000']=203 ;
		$prices_cat['1']['1/1 '.$seite]['30 000']=227 ;
		$prices_cat['1']['1/1 '.$seite]['50 000']=292 ;
		$prices_cat['1']['1/1 '.$seite]['80 000']=357 ;
		$prices_cat['1']['1/1 '.$seite][$weitere.' 10.000']=39 ;

		$prices_cat['1']['2/1 '.$seite]['3 000']=95;
		$prices_cat['1']['2/1 '.$seite]['5 000']=133;
		$prices_cat['1']['2/1 '.$seite]['7 500']=186;
		$prices_cat['1']['2/1 '.$seite]['10 000']=215;
		$prices_cat['1']['2/1 '.$seite]['15 000']=234;
		$prices_cat['1']['2/1 '.$seite]['20 000']=254;
		$prices_cat['1']['2/1 '.$seite]['30 000']=283;
		$prices_cat['1']['2/1 '.$seite]['50 000']=365;
		$prices_cat['1']['2/1 '.$seite]['80 000']=446;
		$prices_cat['1']['2/1 '.$seite][$weitere.' 10.000']=49;

		$prices_cat['2']['1/8 '.$seite]['3 000']=39;
		$prices_cat['2']['1/8 '.$seite]['5 000']=54;
		$prices_cat['2']['1/8 '.$seite]['7 500']=76;
		$prices_cat['2']['1/8 '.$seite]['10 000']=88;
		$prices_cat['2']['1/8 '.$seite]['15 000']=96;
		$prices_cat['2']['1/8 '.$seite]['20 000']=104;
		$prices_cat['2']['1/8 '.$seite]['30 000']=116;
		$prices_cat['2']['1/8 '.$seite]['50 000']=150;
		$prices_cat['2']['1/8 '.$seite]['80 000']=183;
		$prices_cat['2']['1/8 '.$seite][$weitere.' 10.000']=20;


		$prices_cat['2']['1/2 '.$seite]['3 000']=61;
		$prices_cat['2']['1/2 '.$seite]['5 000']=85;
		$prices_cat['2']['1/2 '.$seite]['7 500']=119;
		$prices_cat['2']['1/2 '.$seite]['10 000']=138;
		$prices_cat['2']['1/2 '.$seite]['15 000']=150;
		$prices_cat['2']['1/2 '.$seite]['20 000']=163;
		$prices_cat['2']['1/2 '.$seite]['30 000']=181;
		$prices_cat['2']['1/2 '.$seite]['50 000']=234;
		$prices_cat['2']['1/2 '.$seite]['80 000']=285;
		$prices_cat['2']['1/2 '.$seite][$weitere.' 10.000']=31;

		$prices_cat['2']['1/4 '.$seite]['3 000']=49;
		$prices_cat['2']['1/4 '.$seite]['5 000']=68;
		$prices_cat['2']['1/4 '.$seite]['7 500']=95;
		$prices_cat['2']['1/4 '.$seite]['10 000']=110;
		$prices_cat['2']['1/4 '.$seite]['15 000']=120;
		$prices_cat['2']['1/4 '.$seite]['20 000']=130;
		$prices_cat['2']['1/4 '.$seite]['30 000']=145;
		$prices_cat['2']['1/4 '.$seite]['50 000']=187;
		$prices_cat['2']['1/4 '.$seite]['80 000']=228;
		$prices_cat['2']['1/4 '.$seite][$weitere.' 10.000']=25;

		$prices_cat['2']['1/1 '.$seite]['3 000']=76;
		$prices_cat['2']['1/1 '.$seite]['5 000']=106;
		$prices_cat['2']['1/1 '.$seite]['7 500']=148;
		$prices_cat['2']['1/1 '.$seite]['10 000']=172;
		$prices_cat['2']['1/1 '.$seite]['15 000']=188;
		$prices_cat['2']['1/1 '.$seite]['20 000']=203;
		$prices_cat['2']['1/1 '.$seite]['30 000']=227;
		$prices_cat['2']['1/1 '.$seite]['50 000']=292;
		$prices_cat['2']['1/1 '.$seite]['80 000']=357;
		$prices_cat['2']['1/1 '.$seite][$weitere.' 10.000']=39;

		$prices_cat['2']['2/1 '.$seite]['3 000']=95;
		$prices_cat['2']['2/1 '.$seite]['5 000']=133;
		$prices_cat['2']['2/1 '.$seite]['7 500']=186;
		$prices_cat['2']['2/1 '.$seite]['10 000']=215;
		$prices_cat['2']['2/1 '.$seite]['15 000']=234;
		$prices_cat['2']['2/1 '.$seite]['20 000']=254;
		$prices_cat['2']['2/1 '.$seite]['30 000']=283;
		$prices_cat['2']['2/1 '.$seite]['50 000']=365;
		$prices_cat['2']['2/1 '.$seite]['80 000']=446;
		$prices_cat['2']['2/1 '.$seite][$weitere.' 10.000']=49;



		$prices_cat['3']['1/8 '.$seite]['3 000'] = 39;
		$prices_cat['3']['1/8 '.$seite]['5 000'] = 54;
		$prices_cat['3']['1/8 '.$seite]['7 500'] = 	76;
		$prices_cat['3']['1/8 '.$seite]['10 000'] = 88;
		$prices_cat['3']['1/8 '.$seite]['15 000'] = 96;
		$prices_cat['3']['1/8 '.$seite]['20 000'] = 104;
		$prices_cat['3']['1/8 '.$seite]['30 000'] = 116;
		$prices_cat['3']['1/8 '.$seite]['50 000'] = 150;
		$prices_cat['3']['1/8 '.$seite]['80 000'] = 183;
		$prices_cat['3']['1/8 '.$seite][$weitere.' 10.000'] = 20;

		$prices_cat['3']['1/4 '.$seite]['3 000'] = 49;
		$prices_cat['3']['1/4 '.$seite]['5 000'] = 68;
		$prices_cat['3']['1/4 '.$seite]['7 500'] = 95;
		$prices_cat['3']['1/4 '.$seite]['10 000'] = 110;
		$prices_cat['3']['1/4 '.$seite]['15 000'] = 120;
		$prices_cat['3']['1/4 '.$seite]['20 000'] = 130;
		$prices_cat['3']['1/4 '.$seite]['30 000'] = 145;
		$prices_cat['3']['1/4 '.$seite]['50 000'] = 187;
		$prices_cat['3']['1/4 '.$seite]['80 000'] = 228;
		$prices_cat['3']['1/4 '.$seite][$weitere.' 10.000'] = 25;

		$prices_cat['3']['1/2 '.$seite]['3 000'] = 61;
		$prices_cat['3']['1/2 '.$seite]['5 000'] = 85;
		$prices_cat['3']['1/2 '.$seite]['7 500'] = 	119;
		$prices_cat['3']['1/2 '.$seite]['10 000'] = 138;
		$prices_cat['3']['1/2 '.$seite]['15 000'] = 150;
		$prices_cat['3']['1/2 '.$seite]['20 000'] = 163;
		$prices_cat['3']['1/2 '.$seite]['30 000'] = 181;
		$prices_cat['3']['1/2 '.$seite]['50 000'] = 234;
		$prices_cat['3']['1/2 '.$seite]['80 000'] = 285;
		$prices_cat['3']['1/2 '.$seite][$weitere.' 10.000'] = 31;

		$prices_cat['3']['1/1 '.$seite]['3 000'] = 76;
		$prices_cat['3']['1/1 '.$seite]['5 000'] = 106;
		$prices_cat['3']['1/1 '.$seite]['7 500'] = 	148;
		$prices_cat['3']['1/1 '.$seite]['10 000'] = 172;
		$prices_cat['3']['1/1 '.$seite]['15 000'] = 188;
		$prices_cat['3']['1/1 '.$seite]['20 000'] = 203;
		$prices_cat['3']['1/1 '.$seite]['30 000'] = 227;
		$prices_cat['3']['1/1 '.$seite]['50 000'] = 292;
		$prices_cat['3']['1/1 '.$seite]['80 000'] = 357;
		$prices_cat['3']['1/1 '.$seite][$weitere.' 10.000'] = 39;

		$prices_cat['3']['2/1 '.$seite]['3 000'] = 95;
		$prices_cat['3']['2/1 '.$seite]['5 000'] = 133;
		$prices_cat['3']['2/1 '.$seite]['7 500'] = 	186;
		$prices_cat['3']['2/1 '.$seite]['10 000'] = 215;
		$prices_cat['3']['2/1 '.$seite]['15 000'] = 234;
		$prices_cat['3']['2/1 '.$seite]['20 000'] = 254;
		$prices_cat['3']['2/1 '.$seite]['30 000'] = 283;
		$prices_cat['3']['2/1 '.$seite]['50 000'] = 365;
		$prices_cat['3']['2/1 '.$seite]['80 000'] = 446;
		$prices_cat['3']['2/1 '.$seite][$weitere.' 10.000'] = 49;


		$prices_cat['4'][$din.' A5']['1 000'] = 256;
		$prices_cat['4'][$din.' A5']['2 000'] = 285;
		$prices_cat['4'][$din.' A5']['3 500'] = 315;
		$prices_cat['4'][$din.' A5']['5 000'] = 344;
		$prices_cat['4'][$din.' A5']['7 500'] = 369;
		$prices_cat['4'][$din.' A5']['10 000'] = 396;
		$prices_cat['4'][$din.' A5']['25 000'] = 531;
		$prices_cat['4'][$din.' A5']['50 000'] = 627;
		$prices_cat['4'][$din.' A5'][$weitere.' 10.000'] = 39;

		$prices_cat['4'][$din.' A4']['1 000'] = 328;
		$prices_cat['4'][$din.' A4']['2 000'] = 363;
		$prices_cat['4'][$din.' A4']['3 500'] = 396;
		$prices_cat['4'][$din.' A4']['5 000'] = 437;
		$prices_cat['4'][$din.' A4']['7 500'] = 450;
		$prices_cat['4'][$din.' A4']['10 000'] = 476;
		$prices_cat['4'][$din.' A4']['25 000'] = 666;
		$prices_cat['4'][$din.' A4']['50 000'] = 829;
		$prices_cat['4'][$din.' A4'][$weitere.' 10.000'] = 64;

		$prices_cat['4'][$din.' A3']['1 000'] = 392;
		$prices_cat['4'][$din.' A3']['2 000'] = 436;
		$prices_cat['4'][$din.' A3']['3 500'] = 473;
		$prices_cat['4'][$din.' A3']['5 000'] = 526;
		$prices_cat['4'][$din.' A3']['7 500'] = 546;
		$prices_cat['4'][$din.' A3']['10 000'] = 578;
		$prices_cat['4'][$din.' A3']['25 000'] = 794;
		$prices_cat['4'][$din.' A3']['50 000'] = 973;
		$prices_cat['4'][$din.' A3'][$weitere.' 10.000'] = 71;

		$prices_cat['4'][$gdin.' A3']['1 000'] = 328;
		$prices_cat['4'][$gdin.' A3']['2 000'] = 363;
		$prices_cat['4'][$gdin.' A3']['3 500'] = 396;
		$prices_cat['4'][$gdin.' A3']['5 000'] = 437;
		$prices_cat['4'][$gdin.' A3']['7 500'] = 450;
		$prices_cat['4'][$gdin.' A3']['10 000'] = 476;
		$prices_cat['4'][$gdin.' A3']['25 000'] = 666;
		$prices_cat['4'][$gdin.' A3']['50 000'] = 829;
		$prices_cat['4'][$gdin.' A3'][$weitere.' 10.000'] = 64;


		$prices_cat['5']['1/8 '.$seite]['2 000'] = 54;
		$prices_cat['5']['1/8 '.$seite]['10 000'] = 	54;
		$prices_cat['5']['1/8 '.$seite]['20 000'] = 	54;
		$prices_cat['5']['1/8 '.$seite]['30 000'] = 	60;
		$prices_cat['5']['1/8 '.$seite]['50 000'] = 	79;
		$prices_cat['5']['1/8 '.$seite]['100 000'] = 	96;
		$prices_cat['5']['1/8 '.$seite]['175 000'] = 	111;
		$prices_cat['5']['1/8 '.$seite]['250 000'] = 	122;
		$prices_cat['5']['1/8 '.$seite]['500 000'] = 	152;
		$prices_cat['5']['1/8 '.$seite]['750 000'] = 	198;
		$prices_cat['5']['1/8 '.$seite]['1 000 000'] = 	242;
		$prices_cat['5']['1/8 '.$seite]['1 500 000'] = 	321;
		$prices_cat['5']['1/8 '.$seite]['2 000 000'] = 	377;
		$prices_cat['5']['1/8 '.$seite][$weitere.' 500.000'] = 	45;

		$prices_cat['5']['1/4 '.$seite]['2 000'] = 	54;
		$prices_cat['5']['1/4 '.$seite]['10 000'] = 	61;
		$prices_cat['5']['1/4 '.$seite]['20 000'] = 	69;
		$prices_cat['5']['1/4 '.$seite]['30 000'] = 	79;
		$prices_cat['5']['1/4 '.$seite]['50 000'] = 	110;
		$prices_cat['5']['1/4 '.$seite]['100 000'] = 	136;
		$prices_cat['5']['1/4 '.$seite]['175 000'] = 	157;
		$prices_cat['5']['1/4 '.$seite]['250 000'] = 	172;
		$prices_cat['5']['1/4 '.$seite]['500 000'] = 	212;
		$prices_cat['5']['1/4 '.$seite]['750 000'] = 	276;
		$prices_cat['5']['1/4 '.$seite]['1 000 000'] = 	340;
		$prices_cat['5']['1/4 '.$seite]['1 500 000'] = 	448;
		$prices_cat['5']['1/4 '.$seite]['2 000 000'] = 	528;
		$prices_cat['5']['1/4 '.$seite][$weitere.' 500.000'] = 	64;

		$prices_cat['5']['1/2 '.$seite]['2 000'] = 	54;
		$prices_cat['5']['1/2 '.$seite]['10 000'] = 	65;
		$prices_cat['5']['1/2 '.$seite]['20 000'] = 	84;
		$prices_cat['5']['1/2 '.$seite]['30 000'] = 	107;
		$prices_cat['5']['1/2 '.$seite]['50 000'] = 	164;
		$prices_cat['5']['1/2 '.$seite]['100 000'] = 	224;
		$prices_cat['5']['1/2 '.$seite]['175 000'] = 	258;
		$prices_cat['5']['1/2 '.$seite]['250 000'] = 	292;
		$prices_cat['5']['1/2 '.$seite]['500 000'] = 	372;
		$prices_cat['5']['1/2 '.$seite]['750 000'] = 	481;
		$prices_cat['5']['1/2 '.$seite]['1 000 000'] = 	592;
		$prices_cat['5']['1/2 '.$seite]['1 500 000'] = 	781;
		$prices_cat['5']['1/2 '.$seite]['2 000 000'] = 	932;
		$prices_cat['5']['1/2 '.$seite][$weitere.' 500.000'] = 	111;

		$prices_cat['5']['1/1 '.$seite]['2 000'] = 	61;
		$prices_cat['5']['1/1 '.$seite]['10 000'] = 	84;
		$prices_cat['5']['1/1 '.$seite]['20 000'] = 	107;
		$prices_cat['5']['1/1 '.$seite]['30 000'] = 	132;
		$prices_cat['5']['1/1 '.$seite]['50 000'] = 	228;
		$prices_cat['5']['1/1 '.$seite]['100 000'] = 	321;
		$prices_cat['5']['1/1 '.$seite]['175 000'] = 	368;
		$prices_cat['5']['1/1 '.$seite]['250 000'] = 	394;
		$prices_cat['5']['1/1 '.$seite]['500 000'] = 	502;
		$prices_cat['5']['1/1 '.$seite]['750 000'] = 	652;
		$prices_cat['5']['1/1 '.$seite]['1 000 000'] = 	800;
		$prices_cat['5']['1/1 '.$seite]['1 500 000'] = 	1056;
		$prices_cat['5']['1/1 '.$seite]['2 000 000'] = 	1247;
		$prices_cat['5']['1/1 '.$seite][$weitere.' 500.000'] = 	151;

		$prices_cat['5']['2/1 '.$seite]['2 000'] = 	85;
		$prices_cat['5']['2/1 '.$seite]['10 000'] = 	115;
		$prices_cat['5']['2/1 '.$seite]['20 000'] = 	151;
		$prices_cat['5']['2/1 '.$seite]['30 000'] = 	188;
		$prices_cat['5']['2/1 '.$seite]['50 000'] = 	313;
		$prices_cat['5']['2/1 '.$seite]['100 000'] = 	445;
		$prices_cat['5']['2/1 '.$seite]['175 000'] = 	512;
		$prices_cat['5']['2/1 '.$seite]['250 000'] = 	552;
		$prices_cat['5']['2/1 '.$seite]['500 000'] = 	703;
		$prices_cat['5']['2/1 '.$seite]['750 000'] = 	910;
		$prices_cat['5']['2/1 '.$seite]['1 000 000'] = 	1119;
		$prices_cat['5']['2/1 '.$seite]['1 500 000'] = 	1480;
		$prices_cat['5']['2/1 '.$seite]['2 000 000'] = 	1745;
		$prices_cat['5']['2/1 '.$seite][$weitere.' 500.000'] = 	211;

		$prices_cat['6']['1/8 '.$seite]['2 000'] =	21;
		$prices_cat['6']['1/8 '.$seite]['3 000'] =	24;
		$prices_cat['6']['1/8 '.$seite]['5 000'] =	30;
		$prices_cat['6']['1/8 '.$seite]['10 000'] =	38;
		$prices_cat['6']['1/8 '.$seite]['30 000'] =	50;
		$prices_cat['6']['1/8 '.$seite]['50 000'] =	61;
		$prices_cat['6']['1/8 '.$seite]['100 000'] =	66;
		$prices_cat['6']['1/8 '.$seite]['175 000'] =	80;
		$prices_cat['6']['1/8 '.$seite]['250 000'] =	91;
		$prices_cat['6']['1/8 '.$seite]['500 000'] =	152;
		$prices_cat['6']['1/8 '.$seite]['750 000'] =	207;
		$prices_cat['6']['1/8 '.$seite]['1 000 000'] =	251;
		$prices_cat['6']['1/8 '.$seite][$daruber] =	343;

		$prices_cat['6']['1/4 '.$seite]['2 000'] =	21;
		$prices_cat['6']['1/4 '.$seite]['3 000'] =	25;
		$prices_cat['6']['1/4 '.$seite]['5 000'] =	35;
		$prices_cat['6']['1/4 '.$seite]['10 000'] =	43;
		$prices_cat['6']['1/4 '.$seite]['30 000'] =	57;
		$prices_cat['6']['1/4 '.$seite]['50 000'] =	66;
		$prices_cat['6']['1/4 '.$seite]['100 000'] =	79;
		$prices_cat['6']['1/4 '.$seite]['175 000'] =	96;
		$prices_cat['6']['1/4 '.$seite]['250 000'] =	106;
		$prices_cat['6']['1/4 '.$seite]['500 000'] =	184;
		$prices_cat['6']['1/4 '.$seite]['750 000'] =	243;
		$prices_cat['6']['1/4 '.$seite]['1 000 000'] =	308;
		$prices_cat['6']['1/4 '.$seite][$daruber] =	429;

		$prices_cat['6']['1/2 '.$seite]['2 000'] =	25;
		$prices_cat['6']['1/2 '.$seite]['3 000'] =	29;
		$prices_cat['6']['1/2 '.$seite]['5 000'] =	42;
		$prices_cat['6']['1/2 '.$seite]['10 000'] =	54;
		$prices_cat['6']['1/2 '.$seite]['30 000'] =	69;
		$prices_cat['6']['1/2 '.$seite]['50 000'] =	79;
		$prices_cat['6']['1/2 '.$seite]['100 000'] =	96;
		$prices_cat['6']['1/2 '.$seite]['175 000'] =	115;
		$prices_cat['6']['1/2 '.$seite]['250 000'] =	128;
		$prices_cat['6']['1/2 '.$seite]['500 000'] =	222;
		$prices_cat['6']['1/2 '.$seite]['750 000'] =	292;
		$prices_cat['6']['1/2 '.$seite]['1 000 000'] =	461;
		$prices_cat['6']['1/2 '.$seite][$daruber] =	517;

		$prices_cat['6']['1/1 '.$seite]['2 000'] =	33;
		$prices_cat['6']['1/1 '.$seite]['3 000'] =	38;
		$prices_cat['6']['1/1 '.$seite]['5 000'] =	50;
		$prices_cat['6']['1/1 '.$seite]['10 000'] =	65;
		$prices_cat['6']['1/1 '.$seite]['30 000'] =	86;
		$prices_cat['6']['1/1 '.$seite]['50 000'] =	100;
		$prices_cat['6']['1/1 '.$seite]['100 000'] =	120;
		$prices_cat['6']['1/1 '.$seite]['175 000'] =	144;
		$prices_cat['6']['1/1 '.$seite]['250 000'] =	161;
		$prices_cat['6']['1/1 '.$seite]['500 000'] =	276;
		$prices_cat['6']['1/1 '.$seite]['750 000'] =	364;
		$prices_cat['6']['1/1 '.$seite]['1 000 000'] =	1056;
		$prices_cat['6']['1/1 '.$seite][$daruber] =	644;

		$prices_cat['7'][$din.' A5']['1 000'] =	170;
		$prices_cat['7'][$din.' A5']['2 000'] =	190;
		$prices_cat['7'][$din.' A5']['3 500'] =	210;
		$prices_cat['7'][$din.' A5']['5 000'] =	229;
		$prices_cat['7'][$din.' A5']['7 500'] =	245;
		$prices_cat['7'][$din.' A5']['10 000'] =	264;
		$prices_cat['7'][$din.' A5']['25 000'] =	354;
		$prices_cat['7'][$din.' A5']['50 000'] =	418;
		$prices_cat['7'][$din.' A5'][$weitere.' 10.000'] =	26;

		$prices_cat['7'][$din.' A4']['1 000'] =	219;
		$prices_cat['7'][$din.' A4']['2 000'] =	242;
		$prices_cat['7'][$din.' A4']['3 500'] =	264;
		$prices_cat['7'][$din.' A4']['5 000'] =	292;
		$prices_cat['7'][$din.' A4']['7 500'] =	300;
		$prices_cat['7'][$din.' A4']['10 000'] =	317;
		$prices_cat['7'][$din.' A4']['25 000'] =	444;
		$prices_cat['7'][$din.' A4']['50 000'] =	552;
		$prices_cat['7'][$din.' A4'][$weitere.' 10.000'] =	43;

		$prices_cat['7'][$din.' A3']['1 000'] =		262;
		$prices_cat['7'][$din.' A3']['2 000'] =		291;
		$prices_cat['7'][$din.' A3']['3 500'] =		315;
		$prices_cat['7'][$din.' A3']['5 000'] =		351;
		$prices_cat['7'][$din.' A3']['7 500'] =		363;
		$prices_cat['7'][$din.' A3']['10 000'] =		385;
		$prices_cat['7'][$din.' A3']['25 000'] =		530;
		$prices_cat['7'][$din.' A3']['50 000'] =		649;
		$prices_cat['7'][$din.' A3'][$weitere.' 10.000'] =		47;

		$prices_cat['7'][$gdin.' A3']['1 000'] =	303;
		$prices_cat['7'][$gdin.' A3']['2 000'] =	337;
		$prices_cat['7'][$gdin.' A3']['3 500'] =	369;
		$prices_cat['7'][$gdin.' A3']['5 000'] =	405;
		$prices_cat['7'][$gdin.' A3']['7 500'] =	417;
		$prices_cat['7'][$gdin.' A3']['10 000'] =	452;
		$prices_cat['7'][$gdin.' A3']['25 000'] =	616;
		$prices_cat['7'][$gdin.' A3']['50 000'] =	742;
		$prices_cat['7'][$gdin.' A3'][$weitere.' 10.000'] = 50;

		$prices_cat['8'][$din.' A5']['1 000'] =	256;
		$prices_cat['8'][$din.' A5']['2 000'] =	285;
		$prices_cat['8'][$din.' A5']['3 000'] =	315;
		$prices_cat['8'][$din.' A5']['5 000'] =	344;
		$prices_cat['8'][$din.' A5']['7 500'] =	369;
		$prices_cat['8'][$din.' A5']['10 000'] =	396;
		$prices_cat['8'][$din.' A5']['25 000'] =	354;
		$prices_cat['8'][$din.' A5']['50 000'] =	627;
		$prices_cat['8'][$din.' A5'][$weitere.' 10.000'] =	39;

		$prices_cat['8'][$din.' A4']['1 000'] =	328;
		$prices_cat['8'][$din.' A4']['2 000'] =	363;
		$prices_cat['8'][$din.' A4']['3 000'] =	396;
		$prices_cat['8'][$din.' A4']['5 000'] =	437;
		$prices_cat['8'][$din.' A4']['7 500'] =	450;
		$prices_cat['8'][$din.' A4']['10 000'] =	476;
		$prices_cat['8'][$din.' A4']['25 000'] =	666;
		$prices_cat['8'][$din.' A4']['50 000'] =	829;
		$prices_cat['8'][$din.' A4'][$weitere.' 10.000'] =	64;


		$prices_cat['8'][$din.' A3']['1 000'] =		392;
		$prices_cat['8'][$din.' A3']['2 000'] =		436;
		$prices_cat['8'][$din.' A3']['3 000'] =		473;
		$prices_cat['8'][$din.' A3']['5 000'] =		526;
		$prices_cat['8'][$din.' A3']['7 500'] =		546;
		$prices_cat['8'][$din.' A3']['10 000'] =		578;
		$prices_cat['8'][$din.' A3']['25 000'] =		794;
		$prices_cat['8'][$din.' A3']['50 000'] =		973;
		$prices_cat['8'][$din.' A3'][$weitere.' 10.000'] =		71;


		$prices_cat['8'][$gdin.' A3']['1 000'] =	456;
		$prices_cat['8'][$gdin.' A3']['2 000'] =	505;
		$prices_cat['8'][$gdin.' A3']['3 000'] =	553;
		$prices_cat['8'][$gdin.' A3']['5 000'] =	608;
		$prices_cat['8'][$gdin.' A3']['7 500'] =	626;
		$prices_cat['8'][$gdin.' A3']['10 000'] =	679;
		$prices_cat['8'][$gdin.' A3']['25 000'] =	925;
		$prices_cat['8'][$gdin.' A3']['50 000'] =	1113;
		$prices_cat['8'][$gdin.' A3'][$weitere.' 10.000'] = 76;


		$prices_cat['9']['1/8 '.$seite]['3 000']=39;
		$prices_cat['9']['1/8 '.$seite]['5 000']=54;
		$prices_cat['9']['1/8 '.$seite]['7 500']=76;
		$prices_cat['9']['1/8 '.$seite]['10 000']=88;
		$prices_cat['9']['1/8 '.$seite]['15 000']=96;
		$prices_cat['9']['1/8 '.$seite]['20 000']=104;
		$prices_cat['9']['1/8 '.$seite]['30 000']=116;
		$prices_cat['9']['1/8 '.$seite]['50 000']=150;
		$prices_cat['9']['1/8 '.$seite]['80 000']=183;
		$prices_cat['9']['1/8 '.$seite][$weitere.' 10.000']=20;


		$prices_cat['9']['1/2 '.$seite]['3 000']=61;
		$prices_cat['9']['1/2 '.$seite]['5 000']=85;
		$prices_cat['9']['1/2 '.$seite]['7 500']=119;
		$prices_cat['9']['1/2 '.$seite]['10 000']=138;
		$prices_cat['9']['1/2 '.$seite]['15 000']=150;
		$prices_cat['9']['1/2 '.$seite]['20 000']=163;
		$prices_cat['9']['1/2 '.$seite]['30 000']=181;
		$prices_cat['9']['1/2 '.$seite]['50 000']=234;
		$prices_cat['9']['1/2 '.$seite]['80 000']=285;
		$prices_cat['9']['1/2 '.$seite][$weitere.' 10.000']=31;

		$prices_cat['9']['1/4 '.$seite]['3 000']=49;
		$prices_cat['9']['1/4 '.$seite]['5 000']=68;
		$prices_cat['9']['1/4 '.$seite]['7 500']=95;
		$prices_cat['9']['1/4 '.$seite]['10 000']=110;
		$prices_cat['9']['1/4 '.$seite]['15 000']=120;
		$prices_cat['9']['1/4 '.$seite]['20 000']=130;
		$prices_cat['9']['1/4 '.$seite]['30 000']=145;
		$prices_cat['9']['1/4 '.$seite]['50 000']=187;
		$prices_cat['9']['1/4 '.$seite]['80 000']=228;
		$prices_cat['9']['1/4 '.$seite][$weitere.' 10.000']=25;

		$prices_cat['9']['1/1 '.$seite]['3 000']=76;
		$prices_cat['9']['1/1 '.$seite]['5 000']=106;
		$prices_cat['9']['1/1 '.$seite]['7 500']=148;
		$prices_cat['9']['1/1 '.$seite]['10 000']=172;
		$prices_cat['9']['1/1 '.$seite]['15 000']=188;
		$prices_cat['9']['1/1 '.$seite]['20 000']=203;
		$prices_cat['9']['1/1 '.$seite]['30 000']=227;
		$prices_cat['9']['1/1 '.$seite]['50 000']=292;
		$prices_cat['9']['1/1 '.$seite]['80 000']=357;
		$prices_cat['9']['1/1 '.$seite][$weitere.' 10.000']=39;

		$prices_cat['9']['2/1 '.$seite]['3 000']=95;
		$prices_cat['9']['2/1 '.$seite]['5 000']=133;
		$prices_cat['9']['2/1 '.$seite]['7 500']=186;
		$prices_cat['9']['2/1 '.$seite]['10 000']=215;
		$prices_cat['9']['2/1 '.$seite]['15 000']=234;
		$prices_cat['9']['2/1 '.$seite]['20 000']=254;
		$prices_cat['9']['2/1 '.$seite]['30 000']=283;
		$prices_cat['9']['2/1 '.$seite]['50 000']=365;
		$prices_cat['9']['2/1 '.$seite]['80 000']=446;
		$prices_cat['9']['2/1 '.$seite][$weitere.' 10.000']=49;



		$prices_cat['10']['1/8 '.$seite]['3 000']=100;
		$prices_cat['10']['1/8 '.$seite]['5 000']=100;
		$prices_cat['10']['1/8 '.$seite]['7 500']=100;
		$prices_cat['10']['1/8 '.$seite]['10 000']=100;
		$prices_cat['10']['1/8 '.$seite]['15 000']=100;
		$prices_cat['10']['1/8 '.$seite]['20 000']=100;
		$prices_cat['10']['1/8 '.$seite]['30 000']=100;
		$prices_cat['10']['1/8 '.$seite]['50 000']=100;
		$prices_cat['10']['1/8 '.$seite]['80 000']=100;
		$prices_cat['10']['1/8 '.$seite][$weitere.' 10.000']=100;


		$prices_cat['10']['1/2 '.$seite]['3 000']=100;
		$prices_cat['10']['1/2 '.$seite]['5 000']=100;
		$prices_cat['10']['1/2 '.$seite]['7 500']=100;
		$prices_cat['10']['1/2 '.$seite]['10 000']=100;
		$prices_cat['10']['1/2 '.$seite]['15 000']=100;
		$prices_cat['10']['1/2 '.$seite]['20 000']=100;
		$prices_cat['10']['1/2 '.$seite]['30 000']=100;
		$prices_cat['10']['1/2 '.$seite]['50 000']=100;
		$prices_cat['10']['1/2 '.$seite]['80 000']=100;
		$prices_cat['10']['1/2 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['10']['1/4 '.$seite]['3 000']=100;
		$prices_cat['10']['1/4 '.$seite]['5 000']=100;
		$prices_cat['10']['1/4 '.$seite]['7 500']=100;
		$prices_cat['10']['1/4 '.$seite]['10 000']=100;
		$prices_cat['10']['1/4 '.$seite]['15 000']=100;
		$prices_cat['10']['1/4 '.$seite]['20 000']=100;
		$prices_cat['10']['1/4 '.$seite]['30 000']=100;
		$prices_cat['10']['1/4 '.$seite]['50 000']=100;
		$prices_cat['10']['1/4 '.$seite]['80 000']=100;
		$prices_cat['10']['1/4 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['10']['1/1 '.$seite]['3 000']=100;
		$prices_cat['10']['1/1 '.$seite]['5 000']=100;
		$prices_cat['10']['1/1 '.$seite]['7 500']=100;
		$prices_cat['10']['1/1 '.$seite]['10 000']=100;
		$prices_cat['10']['1/1 '.$seite]['15 000']=100;
		$prices_cat['10']['1/1 '.$seite]['20 000']=100;
		$prices_cat['10']['1/1 '.$seite]['30 000']=100;
		$prices_cat['10']['1/1 '.$seite]['50 000']=100;
		$prices_cat['10']['1/1 '.$seite]['80 000']=100;
		$prices_cat['10']['1/1 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['10']['2/1 '.$seite]['3 000']=100;
		$prices_cat['10']['2/1 '.$seite]['5 000']=100;
		$prices_cat['10']['2/1 '.$seite]['7 500']=100;
		$prices_cat['10']['2/1 '.$seite]['10 000']=100;
		$prices_cat['10']['2/1 '.$seite]['15 000']=100;
		$prices_cat['10']['2/1 '.$seite]['20 000']=100;
		$prices_cat['10']['2/1 '.$seite]['30 000']=100;
		$prices_cat['10']['2/1 '.$seite]['50 000']=100;
		$prices_cat['10']['2/1 '.$seite]['80 000']=100;
		$prices_cat['10']['2/1 '.$seite][$weitere.' 10.000']=100;


		$prices_cat['11']['1/8 '.$seite]['3 000']=100;
		$prices_cat['11']['1/8 '.$seite]['5 000']=100;
		$prices_cat['11']['1/8 '.$seite]['7 500']=100;
		$prices_cat['11']['1/8 '.$seite]['10 000']=100;
		$prices_cat['11']['1/8 '.$seite]['15 000']=100;
		$prices_cat['11']['1/8 '.$seite]['20 000']=100;
		$prices_cat['11']['1/8 '.$seite]['30 000']=100;
		$prices_cat['11']['1/8 '.$seite]['50 000']=100;
		$prices_cat['11']['1/8 '.$seite]['80 000']=100;
		$prices_cat['11']['1/8 '.$seite][$weitere.' 10.000']=100;


		$prices_cat['11']['1/2 '.$seite]['3 000']=100;
		$prices_cat['11']['1/2 '.$seite]['5 000']=100;
		$prices_cat['11']['1/2 '.$seite]['7 500']=100;
		$prices_cat['11']['1/2 '.$seite]['10 000']=100;
		$prices_cat['11']['1/2 '.$seite]['15 000']=100;
		$prices_cat['11']['1/2 '.$seite]['20 000']=100;
		$prices_cat['11']['1/2 '.$seite]['30 000']=100;
		$prices_cat['11']['1/2 '.$seite]['50 000']=100;
		$prices_cat['11']['1/2 '.$seite]['80 000']=100;
		$prices_cat['11']['1/2 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['11']['1/4 '.$seite]['3 000']=100;
		$prices_cat['11']['1/4 '.$seite]['5 000']=100;
		$prices_cat['11']['1/4 '.$seite]['7 500']=100;
		$prices_cat['11']['1/4 '.$seite]['10 000']=100;
		$prices_cat['11']['1/4 '.$seite]['15 000']=100;
		$prices_cat['11']['1/4 '.$seite]['20 000']=100;
		$prices_cat['11']['1/4 '.$seite]['30 000']=100;
		$prices_cat['11']['1/4 '.$seite]['50 000']=100;
		$prices_cat['11']['1/4 '.$seite]['80 000']=100;
		$prices_cat['11']['1/4 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['11']['1/1 '.$seite]['3 000']=100;
		$prices_cat['11']['1/1 '.$seite]['5 000']=100;
		$prices_cat['11']['1/1 '.$seite]['7 500']=100;
		$prices_cat['11']['1/1 '.$seite]['10 000']=100;
		$prices_cat['11']['1/1 '.$seite]['15 000']=100;
		$prices_cat['11']['1/1 '.$seite]['20 000']=100;
		$prices_cat['11']['1/1 '.$seite]['30 000']=100;
		$prices_cat['11']['1/1 '.$seite]['50 000']=100;
		$prices_cat['11']['1/1 '.$seite]['80 000']=100;
		$prices_cat['11']['1/1 '.$seite][$weitere.' 10.000']=100;

		$prices_cat['11']['2/1 '.$seite]['3 000']=100;
		$prices_cat['11']['2/1 '.$seite]['5 000']=100;
		$prices_cat['11']['2/1 '.$seite]['7 500']=100;
		$prices_cat['11']['2/1 '.$seite]['10 000']=100;
		$prices_cat['11']['2/1 '.$seite]['15 000']=100;
		$prices_cat['11']['2/1 '.$seite]['20 000']=100;
		$prices_cat['11']['2/1 '.$seite]['30 000']=100;
		$prices_cat['11']['2/1 '.$seite]['50 000']=100;
		$prices_cat['11']['2/1 '.$seite]['80 000']=100;
		$prices_cat['11']['2/1 '.$seite][$weitere.' 10.000']=100;

		$total = 0;

		foreach ($this->cart->getProducts() as $product) {
			$option_data = array();

			$art     = $this->request->post['art'.$product['product_id']];
			$auflage = $this->request->post['auflage'.$product['product_id']];
			$grosse  = $this->request->post['grosse'.$product['product_id']];
 
			$category = $this->model_catalog_product->getCategories($product['product_id']);
			$category = $category[0]['category_id'];

			$price = $prices_cat[$art][$grosse][$auflage];
			$total = $total + $price + 50;

			foreach ($product['option'] as $option) {
				$option_data[] = array(
					'product_option_value_id' => $option['product_option_value_id'],			   
          			'name'                    => $option['name'],
          			'value'                   => $option['value'],
		  			'prefix'                  => $option['prefix']
				);
			}

			$inner = 0;
			$titel = 0;
			if ($this->request->post['radio'.$product['product_id']] == 'inner') $inner = 1;
			else $titel  = 1;

			$product_data[] = array(
        		'product_id' => $product['product_id'],
				'name'       => $product['name'],
        		'model'      => $product['model'],
        		'option'     => $option_data,
				'download'   => $product['download'],
				'quantity'   => 1,
				'subtract'   => $product['subtract'],
				'price'      => $price,
        		'total'      => $price + 50,


        		'art'        =>  $this->request->post['art'.$product['product_id']],
        		'auflage'    =>  $this->request->post['auflage'.$product['product_id']],      		      		
        		'grosse'     =>  $this->request->post['grosse'.$product['product_id']],
        		'titelseite' =>  $titel,
        		'innenseite' =>  $inner,
        		'titel' 	 =>  $this->request->post['titel'.$product['product_id']],
      		    'komentar'   =>  $this->request->post['komentar'.$product['product_id']],      		      		      		      		


				'tax'        => 50
			);
		}

		$data['products'] = $product_data;
		$data['totals']   = $total_data;
		$data['comment']  = $this->session->data['comment'];
		$data['language_id'] = $this->config->get('config_language_id');
		$data['currency_id'] = $this->currency->getId();
		$data['currency']    = $this->currency->getCode();
		$data['value']       = $this->currency->getValue($this->currency->getCode());

		$this->load->model('account/customer');
		$customer_id = $this->customer->getId();
		$customer_type = $this->model_account_customer->getCustomerType($customer_id);

		/*user types:
		 1 - Deutschland Unternehmen 7 %
		 2 - Deutschland Privatpersonen 7 %
		 3 - EU-Staaten Unternehmen with TAXid  0 %
		 4 - EU-Staaten Unternehmen without TAXid 7 %
		 5 - außerhalb der EU Unternehmen 0 %
		 6 - außerhalb der EU Privatpersonen  0 %
		 7 - 7%
		 */
		if ( $customer_type == 1 || $customer_type == 2 || $customer_type == 4 || $customer_type == 7 ){

			$data['subtotal']    = $total;
			$tax 				 = $total*0.07;
			$data['tax']         = $tax;
			$data['total']       = $total + $tax;

		}else{
			$data['subtotal']    = $total;
			$data['total']       = $total;
			$data['tax']         = 0;
		}


		if (isset($this->session->data['coupon'])) {
			$this->load->model('checkout/coupon');

			$coupon = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);

			if ($coupon) {
				$data['coupon_id'] = $coupon['coupon_id'];
			} else {
				$data['coupon_id'] = 0;
			}
		} else {
			$data['coupon_id'] = 0;
		}

		$data['ip'] = $this->request->server['REMOTE_ADDR'];

		$this->load->model('checkout/order');
 

		$this->session->data['order_id'] = $this->model_checkout_order->create($data);
		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cod_order_status_id'));


		//email to customer
		$message = $this->language->get('text_message_email');

		$todays_date = date("d.m.Y");
		$maintenancedate = $this->config->get('config_maintenance_date');
		$todays_date = strtotime($todays_date);
		$maintenancedate = strtotime($maintenancedate);
		if ( $maintenancedate <= $todays_date ){

			$this->load->model('setting/setting');
			$this->model_setting_setting->updateSetting( '731','config_maintenance_date', '' );
			$this->model_setting_setting->updateSetting( '724','config_maintenance', '1' );

		}


		if ($this->config->get('config_maintenance') == '0' && $maintenancedate > $todays_date ) {
			$message .= sprintf($this->language->get('text_message_option2'), $this->config->get('config_maintenance_date'));
		}else{
			$message .= sprintf($this->language->get('text_message_option1'), $this->config->get('config_maintenance_date'));
		}
		$message .= $this->language->get('text_message_email2');
		$message .= $this->language->get('text_footer_email');


		$mail = new Mail();
		$mail->protocol  = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port     = $this->config->get('config_smtp_port');
		$mail->timeout  = $this->config->get('config_smtp_timeout');
		$mail->setTo($this->customer->getEmail());
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject($this->language->get('text_subject'));
		$mail->setHtml($message, ENT_QUOTES, 'UTF-8');
		@$mail->send();

		//email to Admin
		//8.	Mail an Atelier � eine neue Anfrage -- ����� � ������ - ����� ������

		$message  = "Sehr geehrter Damen und Herren,<br/>";
		$message .= "eine neue Anfrage ist im Shop eingegangen.<br/><br/>";
		
		//********* Detailed information about order ******** //
		
		$customerId = $this->customer->getId();
		$this->load->model('account/customer');
		$this->load->model('sale/customer');
		
		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		$bill_info = $this->model_account_customer->getBill($this->customer->getId());
		$address_info  = $this->model_sale_customer->getAddressesByCustomerId($this->customer->getId());
		
		$message .= "<table border=0>";
		
		$message .= "<tr><td>Einrichtung:</td><td>".$customer_info['firstname']." ".$customer_info['lastname']."</td></tr>";
		$message .= "<tr><td>Ansprechpartner:</td><td>".$customer_info['ansprechpartner']."</td></tr>";
		$message .= "<tr><td>Position:	</td><td>".$customer_info['position']."</td></tr>";
		$message .= "<tr><td>Benutzername:</td><td>".$customer_info['username']."</td></tr>	";
		$message .= "<tr><td></td><td></td></tr>";
		
		$message .= "<tr><td>Straße:</td><td>".$address_info[0]['address_1']."</td></tr>";
		$message .= "<tr><td>PLZ:	</td><td>".$address_info[0]['postcode']."</td></tr> ";
		$message .= "<tr><td>Stadt: </td><td>".$address_info[0]['city']."</td></tr>";
		$message .= "<tr><td>Land:</td><td>".$address_info[0]['country_id']."</td></tr>";
		$message .= "<tr><td>TaxID Number:</td><td>".$customer_info['taxid_number']."</td></tr>";
		$message .= "<tr><td></td><td></td></tr>";
		$message .= "<tr><td>Telefon: </td><td>".$customer_info['telephone']."</td></tr>";
		$message .= "<tr><td>Mobil:	</td><td>".$customer_info['mobile']."</td></tr>";
		$message .= "<tr><td>Fax:	</td><td>".$this->request->post['fax']."</td></tr>";
		$message .= "<tr><td>E-Mail:</td><td>".$customer_info['email']."</td></tr>";
		
		$message .= "</table><br><br>";
		
		$message .= "<table border=0 cellpadding=5 cellspacing=5><tr><td style='background-color:#bebebe;font-weight:bold;'></td><td style='background-color:#bebebe;font-weight:bold;'>Titel:</td><td style='background-color:#bebebe;font-weight:bold;'>Vorschau:</td><td style='background-color:#bebebe;font-weight:bold;'>Rubrick:</td><td style='background-color:#bebebe;font-weight:bold;'>Dateiname:</td>";
		
		$ind = 1;
		
		$this->load->model('catalog/category');
		
		foreach ($this->cart->getProducts() as $product) {
		          
				if ($product['image']) {
					$image = $product['image'];
				} else {
					$image = 'no_image.jpg';
				}
			
				$category = $this->model_catalog_product->getCategories($product['product_id']);
				$category = $category[0]['category_id'];
				$category_info = $this->model_catalog_category->getCategory($category);
			
				$message .= "<tr><td>".$ind."</td>";  
				$message .= "<td>CR:".$product['sku'].", ".$product['name']."</td>"; 
				$message .= "<td><img src='".$this->model_tool_image->resize($image, 117, 117)."' /></td>"; 
				$message .= "<td>".$category_info['name']."</td>"; 
				$message .= "<td>".str_replace('data/', '', $image)."</td></tr>"; 
				
				$ind++; 
				
		}
		
		$message .= "</table><br><br>";
		
		$message .= "Mit freundlichen Gr&uuml;&szlig;en<br/><br/>";
		$message .= "www.gerhard-richter-images.de<br/><br/>";
		$message .= "(Diese E-Mail wurde automatisch erstellt)";

		$mail = new Mail();
		$mail->protocol  = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port     = $this->config->get('config_smtp_port');
		$mail->timeout  = $this->config->get('config_smtp_timeout');
		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_name'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(  'Eine neue Anfrage ist im Shop eingegangen'  );
		$mail->setHtml($message, ENT_QUOTES, 'UTF-8');
		@$mail->send();




		header('location:/index.php?route=checkout/success');


		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => FALSE
		);

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/cart',
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
		);

		if ($this->cart->hasShipping()) {
			$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_SERVER . 'index.php?route=checkout/shipping',
        		'text'      => $this->language->get('text_shipping'),
        		'separator' => $this->language->get('text_separator')
			);
		}

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/payment',
        	'text'      => $this->language->get('text_payment'),
        	'separator' => $this->language->get('text_separator')
		);

		$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_SERVER . 'index.php?route=checkout/confirm',
        	'text'      => $this->language->get('text_confirm'),
        	'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_comment'] = $this->language->get('text_comment');
		$this->data['text_coupon'] = $this->language->get('text_coupon');
		$this->data['text_change'] = $this->language->get('text_change');
			
		$this->data['button_coupon'] = $this->language->get('button_coupon');

		$this->data['entry_coupon'] = $this->language->get('entry_coupon');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if ($this->cart->hasShipping()) {
			if ($shipping_address['address_format']) {
				$format = $shipping_address['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
      			);

      			$replace = array(
	  			'firstname' => $shipping_address['firstname'],
	  			'lastname'  => $shipping_address['lastname'],
	  			'company'   => $shipping_address['company'],
      			'address_1' => $shipping_address['address_1'],
      			'address_2' => $shipping_address['address_2'],
      			'city'      => $shipping_address['city'],
      			'postcode'  => $shipping_address['postcode'],
      			'zone'      => $shipping_address['zone'],
				'zone_code' => $shipping_address['zone_code'],
      			'country'   => $shipping_address['country']  
      			);

      			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		} else {
			$this->data['shipping_address'] = '';
		}

		if (isset($this->session->data['shipping_method']['title'])) {
			$this->data['shipping_method'] = $this->session->data['shipping_method']['title'];
		} else {
			$this->data['shipping_method'] = '';
		}

		$this->data['checkout_shipping'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';

		$this->data['checkout_shipping_address'] = HTTPS_SERVER . 'index.php?route=checkout/address/shipping';
			
		if ($payment_address) {
			if ($payment_address['address_format']) {
				$format = $payment_address['address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
      			);

      			$replace = array(
	  			'firstname' => $payment_address['firstname'],
	  			'lastname'  => $payment_address['lastname'],
	  			'company'   => $payment_address['company'],
      			'address_1' => $payment_address['address_1'],
      			'address_2' => $payment_address['address_2'],
      			'city'      => $payment_address['city'],
      			'postcode'  => $payment_address['postcode'],
      			'zone'      => $payment_address['zone'],
				'zone_code' => $payment_address['zone_code'],
      			'country'   => $payment_address['country']  
      			);

      			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		} else {
			$this->data['payment_address'] = '';
		}

		if (isset($this->session->data['payment_method']['title'])) {
			$this->data['payment_method'] = $this->session->data['payment_method']['title'];
		} else {
			$this->data['payment_method'] = '';
		}

		$this->data['checkout_payment'] = HTTPS_SERVER . 'index.php?route=checkout/payment';

		$this->data['checkout_payment_address'] = HTTPS_SERVER . 'index.php?route=checkout/address/payment';

		$this->data['products'] = array();

		$this->language->load('checkout/cart');
		$this->data['my_inside'] = $this->language->get('my_inside');
		$this->data['my_publication'] = $this->language->get('my_publication');
		$this->data['my_book'] = $this->language->get('my_book');
		$this->data['my_artCatalog'] = $this->language->get('my_artCatalog');
		$this->data['my_broshur'] = $this->language->get('my_broshur');
		$this->data['my_promotion'] = $this->language->get('my_promotion');
		$this->data['my_jornal'] = $this->language->get('my_jornal');
		$this->data['my_newspaper'] = $this->language->get('my_newspaper');
		$this->data['my_calendarr'] = $this->language->get('my_calendarr');
		$this->data['my_promcalendar'] = $this->language->get('my_promcalendar');
			
		$art = array();
		$art['1'] = $this->data['my_book'];
		$art['2'] =        $this->data['my_artCatalog'];
		$art['3'] =        $this->data['my_broshur'];
		$art['4'] =        $this->data['my_promotion'];
		$art['5'] =      $this->data['my_jornal'];
		$art['6'] =       $this->data['my_newspaper'];
		$art['7'] =          $this->data['my_calendarr'];
		$art['8'] =      $this->data['my_promcalendar'];

		foreach ($this->cart->getProducts() as $product) {
			$option_data = array();

			foreach ($product['option'] as $option) {
				$option_data[] = array(
          			'name'  => $option['name'],
          			'value' => $option['value']
				);
			}

			if ($product['image']) {
				$image = $product['image'];
			} else {
				$image = 'no_image.jpg';
			}

			$this->data['products'][] = array(
				'product_id' => $product['product_id'],
        		'name'       => $product['name'],
        		'model'      => $product['model'],
        		'option'     => $option_data,
        		'quantity'   => $product['quantity'],
				'subtract'   => $product['subtract'],
				'sku'   => $product['sku'],			
				'tax'        => $this->tax->getRate($product['tax_class_id']),
        		'price'      => $this->currency->format($product['price']),
        		'total'      => $this->currency->format($product['total']),


      		    'art'        =>  $art[$this->request->post['art'.$product['product_id']]],


        		'auflage'    =>  $this->request->post['auflage'.$product['product_id']],      		      		
        		'grosse'     =>  $this->request->post['grosse'.$product['product_id']],
        		'titelseite' =>  $this->request->post['titelseite'.$product['product_id']],
        		'innenseite' =>  $this->request->post['innenseite'.$product['product_id']],
        		'titel' 	 =>  $this->request->post['titel'.$product['product_id']],
      		    'komentar'   =>  $this->request->post['komentar'.$product['product_id']],  
				'thumb'      => $this->model_tool_image->resize($image, 117, 117),
				'href'       => HTTP_SERVER . 'index.php?route=product/product&product_id=' . $product['product_id']
			);
		}

		$this->data['totals'] = $total_data;

		$this->data['comment'] = nl2br($this->session->data['comment']);

		$this->data['coupon_status'] = $this->config->get('coupon_status');

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=checkout/confirm';

		if (isset($this->request->post['coupon'])) {
			$this->data['coupon'] = $this->request->post['coupon'];
		} elseif (isset($this->session->data['coupon'])) {
			$this->data['coupon'] = $this->session->data['coupon'];
		} else {
			$this->data['coupon'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/confirm.tpl';
		} else {
			$this->template = 'default/template/checkout/confirm.tpl';
		}

		$this->children = array(
			'common/column_right',
			'common/footer',
			'common/column_left',
			'common/header'
			);

			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validateCoupon() {

		$this->load->model('checkout/coupon');

		$this->language->load('checkout/confirm');

		$coupon = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);

		if (!$coupon) {
			$this->error['warning'] = $this->language->get('error_coupon');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>