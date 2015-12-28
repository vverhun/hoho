<?php 
class ControllerModuleCart extends Controller { 
	protected function index() {
		$this->language->load('module/cart');
		
		$this->load->model('tool/seo_url');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	
		$this->data['text_subtotal'] = $this->language->get('text_subtotal');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_remove'] = $this->language->get('text_remove');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['view'] = HTTP_SERVER . 'index.php?route=checkout/cart';
		$this->data['checkout'] = HTTPS_SERVER . 'index.php?route=checkout/shipping';
		
		$this->data['products'] = array();
		
    	foreach ($this->cart->getProducts() as $result) {
        	$option_data = array();

        	foreach ($result['option'] as $option) {
          		$option_data[] = array(
            		'name'  => $option['name'],
            		'value' => $option['value']
          		);
        	}
			
      		$this->data['products'][] = array(
        		'key' 		 => $result['key'],
        		'name'       => $result['name'],
				'option'     => $option_data,
        		'quantity'   => $result['quantity'],
				'stock'      => $result['stock'],
				'price'      => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
				'href'       => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']),
      		);
    	}
	
		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = TRUE;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = TRUE;
		} else {
			$this->data['display_price'] = FALSE;
		}
	
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
		
    	$this->data['totals'] = $total_data;
		
		$this->data['ajax'] = $this->config->get('cart_ajax');
		
		$this->id = 'cart';
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cart.tpl';
		} else {
			$this->template = 'default/template/module/cart.tpl';
		}
		
		$this->render();
	}
		
	public function callback() {
		$this->language->load('module/cart');

		$this->load->model('tool/seo_url');
		
		unset($this->session->data['shipping_methods']);
		unset($this->session->data['shipping_method']);
		unset($this->session->data['payment_methods']);
		unset($this->session->data['payment_method']);	
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			if (isset($this->request->post['remove'])) {
	    		$result = explode('_', $this->request->post['remove']);
          		$this->cart->remove(trim($result[1]));
      		} else {
				if (isset($this->request->post['option'])) {
					$option = $this->request->post['option'];
				} else {
					$option = array();	
				}
				if ( !$this->cart->hasProduct($this->request->post['product_id'])){
      				$this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
				}else{
					
					$this->response->setOutput('', $this->config->get('config_compression'));
					die();
				}
			}
		}
				
		$output = '0';
		
		if ($this->cart->getProducts()) {
		    $output = $this->cart->countProducts();
    	}  
		
		$this->response->setOutput($output, $this->config->get('config_compression'));
	} 	
}
?>