<?php
class ControllerProductSearch extends Controller {
	public function index() {
		$this->language->load('product/search');

		/*print_r($_REQUEST);
		 die;*/



		if (isset($this->request->get['keyword'])) {
			$this->document->title = $this->language->get('heading_title') .  ' - ' . $this->request->get['keyword'];
		} else {
			$this->document->title = $this->language->get('heading_title');
		}

		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
		);

		$url = '';

		if (isset($this->request->get['keyword'])) {
			$url .= '&keyword=' . $this->request->get['keyword'];
		}

		if (isset($this->request->get['category_id'])) {
			$url .= '&category_id=' . $this->request->get['category_id'];
		}

		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
		}

		if (isset($this->request->get['model'])) {
			$url .= '&model=' . $this->request->get['model'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
			
			
			
		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_SERVER . 'index.php?route=product/search' . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_info_1'] = $this->language->get('text_info_1');
		$this->data['text_info_2'] = $this->language->get('text_info_2');
		$this->data['text_info_3'] = $this->language->get('text_info_3');

		$this->data['text_info_4'] = $this->language->get('text_info_4');



		$this->data['my_shotyon'] = $this->language->get('my_shotyon');
		$this->data['my_Auswahl'] = $this->language->get('my_Auswahl');
		$this->data['my_text_desc'] = $this->language->get('my_text_desc');
		$this->data['my_year'] = $this->language->get('my_year');
		$this->data['my_day'] = $this->language->get('my_day');
		$this->data['my_Monat'] = $this->language->get('my_Monat');
		$this->data['my_size'] = $this->language->get('my_size');
		$this->data['my_file_size'] = $this->language->get('my_file_size');
		$this->data['my_width'] = $this->language->get('my_width');
		$this->data['my_height'] = $this->language->get('my_height');
		$this->data['my_resolution'] = $this->language->get('my_resolution');
		$this->data['my_color'] = $this->language->get('my_color');
		$this->data['my_titel'] = $this->language->get('my_titel');

		$this->data['text_critea'] = $this->language->get('text_critea');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_sort'] = $this->language->get('text_sort');

		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_model'] = $this->language->get('entry_model');

		$this->data['button_search'] = $this->language->get('button_search');

		$this->data['show_all'] = $this->language->get('show_all');
		$this->data['show_4']   = $this->language->get('show_4');
		$this->data['show_8']   = $this->language->get('show_8');
		$this->data['show_12']  = $this->language->get('show_12');
		$this->data['show_16']  = $this->language->get('show_16');
		$this->data['show_32']  = $this->language->get('show_32');

		/*print_r($_REQUEST);
		 die;*/

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['keyword'])) {
			$this->data['keyword'] = $this->request->get['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->get['category_id'])) {
			$this->data['category_id'] = $this->request->get['category_id'];
		} else {
			$this->data['category_id'] = '';
		}

		$this->load->model('catalog/category');

		$this->data['categories'] = $this->getCategories(0);
		$this->data['parent'] = $this->request->get['parent_id'];

		if (isset($this->request->get['description'])) {
			$this->data['description'] = $this->request->get['description'];
		} else {
			$this->data['description'] = '';
		}

		if (isset($this->request->get['model'])) {
			$this->data['model'] = $this->request->get['model'];
		} else {
			$this->data['model'] = '';
		}

		$this->load->model('catalog/product');

		$this->data['start_year41'] = $this->model_catalog_product->getMaxYearByCategoryId(41);
		$this->data['end_year41']   = $this->model_catalog_product->getMinYearByCategoryId(41);

		$this->data['start_year42'] = $this->model_catalog_product->getMaxYearByCategoryId(42);
		$this->data['end_year42']   = $this->model_catalog_product->getMinYearByCategoryId(42);

		$this->data['start_year43'] = $this->model_catalog_product->getMaxYearByCategoryId(43);
		$this->data['end_year43']   = $this->model_catalog_product->getMinYearByCategoryId(43);

		$this->data['start_year40'] = $this->model_catalog_product->getMaxYearByCategoryId(40);
		$this->data['end_year40']   = $this->model_catalog_product->getMinYearByCategoryId(40);

		$this->data['start_year'] = '2020';
		$this->data['end_year']   = '1950';




		if ( isset($this->request->get['category_id'])) {


			$product_total = 1; //$this->model_catalog_product->getTotalProductsByKeyword($this->request->get['keyword'], isset($this->request->get['category_id']) ? $this->request->get['category_id'] : '', isset($this->request->get['description']) ? $this->request->get['description'] : '', isset($this->request->get['model']) ? $this->request->get['model'] : '');

			$product_tag_total = $this->model_catalog_product->getTotalProductsByTag($this->request->get['keyword'], isset($this->request->get['category_id']) ? $this->request->get['category_id'] : '');

			$product_total = max($product_total, $product_tag_total);


			$this->data['start_year'] = $this->model_catalog_product->getMaxYearByCategoryId($this->request->get['category_id']);
			$this->data['end_year']    = $this->model_catalog_product->getMinYearByCategoryId($this->request->get['category_id']);



			if ($product_total) {
				$url = '';

				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['model'])) {
					$url .= '&model=' . $this->request->get['model'];
				}

				$this->load->model('catalog/review');
				$this->load->model('tool/seo_url');
				$this->load->model('tool/image');

				$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');

				$this->data['products'] = array();







				if(isset($this->request->get['titel'])) {
					$titel = $this->request->get['titel'];

				}else {
					//$titel = 0;
				}
					
				if(isset($this->request->get['wv_cr_nr'])) {
					$wv_cr_nr = $this->request->get['wv_cr_nr'];
				}else {
					//$wv_cr_nr = 0;
				}
				if(isset($this->request->get['jahr_t'])) {
					$jahr_t = $this->request->get['jahr_t'];
				}else {
					//$jahr_t = 0;
				}
				$this->data['titel'] = $titel;
				$this->data['wv_cr_nr'] = $wv_cr_nr;
				$this->data['jahr_t'] = $jahr_t;



				if(isset($this->request->get['titel2'])) {
					$titel2 = $this->request->get['titel2'];

				}else {
					//$titel = 0;
				}
				if(isset($this->request->get['tag'])) {
					$tag = $this->request->get['tag'];
					if(strlen ($tag) == 1) $tag = "0".$tag;

				}else {
					//$tag = 0;
				}
				if(isset($this->request->get['monat'])) {
					$monat = $this->request->get['monat'];
					if(strlen ($monat) == 1) $monat = "0".$monat;
				}else {
					//$monat = 0;
				}
				if(isset($this->request->get['jahr'])) {
					$jahr = $this->request->get['jahr'];
				}else {
					//$jahr = 0;
				}
				$this->data['titel2'] = $titel2;
				$this->data['tag'] = $tag;
				$this->data['monat'] = $monat;
				$this->data['jahr'] = $jahr;




				$category_id = $this->request->get['category_id'];
				/*----for first categories items---------*/
				if( $this->request->get['search_cat'] == 1 /*isset($this->request->get['titel']) || isset($this->request->get['wv_cr_nr']) || isset($this->request->get['jahr_t'])*/ ) {

					$results = $this->model_catalog_product->getProductsByTitles(trim($titel), $wv_cr_nr, $jahr_t, $category_id, $start = ($page-1)*$this->request->get['perpage'], $limit = $this->request->get['perpage']);
					$results_total = $this->model_catalog_product->getTotalProductsByTitles( trim($titel), $wv_cr_nr, $jahr_t, $category_id );

					$product_total = count($results_total);
				}
				/*--------for second categories items------*/
				else {

					if(!isset($this->request->get['tag']) && !isset($this->request->get['monat'])){
						$search_date = $this->request->get['jahr'];
					}else if (isset($this->request->get['jahr']) && isset($this->request->get['monat']) && !isset($this->request->get['tag'])){
						$search_date = $monat.'.'.$jahr;
					}else if (isset($this->request->get['jahr']) && isset($this->request->get['monat']) && isset($this->request->get['tag'])){
						$search_date = $tag.'.'.$monat.'.'.$jahr;
					}else{
						$search_date = '';
					}


					$results = $this->model_catalog_product->getProductsByDate(trim($titel2), $search_date, $category_id, $start = ($page-1)*$this->request->get['perpage'], $limit = $this->request->get['perpage']);

					$results_total = $this->model_catalog_product->getTotalProductsByDate( trim($titel2), $search_date, $category_id );

					$product_total = count($results_total);

				}
					
				if ( $this->request->get['search_cat'] == 1 && !isset($this->request->get['titel']) && !isset($this->request->get['wv_cr_nr']) && !isset($this->request->get['jahr_t']) ){
					$results = array();
					$product_total = 0;
				}

				if ( $this->request->get['search_cat'] == 2 &&  !isset($this->request->get['tag']) && !isset($this->request->get['monat']) && !isset($this->request->get['jahr']) && !isset($this->request->get['titel2'])){

					$results = array();
					$product_total = 0;
				}





				foreach ($results as $result) {



					if ($result['image']) {
						$image = $result['image'];
					} else {
						$image = 'no_image.jpg';
					}

					if ($this->config->get('config_review')) {
						$rating = $this->model_catalog_review->getAverageRating($result['product_id']);
					} else {
						$rating = false;
					}

					$special = FALSE;

					$discount = $this->model_catalog_product->getProductDiscount($result['product_id']);

					if ($discount) {
						$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
							
						$special = $this->model_catalog_product->getProductSpecial($result['product_id']);
							
						if ($special) {
							$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
						}
					}

					$options = $this->model_catalog_product->getProductOptions($result['product_id']);

					if ($options) {
						$add = $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&product_id=' . $result['product_id']);
					} else {
						$add = HTTPS_SERVER . 'index.php?route=checkout/cart&product_id=' . $result['product_id'];
					}

					$this->data['products'][] = array(
            			'name'    		   => $result['name'],
						'product_id'       => $result['product_id'],
            			'width'    		   => $result['width'],		
					    'height'    	   => $result['height'],
					    'model'    		   => $result['model'],									
					    'meta_keywords'    => $result['meta_keywords'],
				        'meta_description' => $result['meta_description'],
				        'description' 	   => $result['description'],					
						'location'   	   => $result['location'],
					    'weight'   => $result['weight'],
					    'sku'      => $result['sku'],		
					    'add'	  => $add,

					    'image'      => $result['image'],

              			'thumb'    => $this->model_tool_image->resize($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
 						'href'     => $this->model_tool_seo_url->rewrite(HTTP_SERVER . 'index.php?route=product/product&keyword=' . urlencode($this->request->get['keyword']) . $url . '&product_id=' . $result['product_id']), 
					);




				}






				if (!$this->config->get('config_customer_price')) {
					$this->data['display_price'] = TRUE;
				} elseif ($this->customer->isLogged()) {
					$this->data['display_price'] = TRUE;
				} else {
					$this->data['display_price'] = FALSE;
				}

				$url = '';

				if (isset($this->request->get['keyword'])) {
					$url .= '&keyword=' . $this->request->get['keyword'];
				}

				if (isset($this->request->get['category_id'])) {
					$url .= '&category_id=' . $this->request->get['category_id'];
				}

				if (isset($this->request->get['description'])) {
					$url .= '&description=' . $this->request->get['description'];
				}

				if (isset($this->request->get['model'])) {
					$url .= '&model=' . $this->request->get['model'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}

				$this->data['sorts'] = array();

				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_default'),
					'value' => 'p.sort_order-ASC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=p.sort_order&order=ASC'
					);

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_asc'),
					'value' => 'pd.name-ASC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=pd.name&order=ASC'
					);

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_name_desc'),
					'value' => 'pd.name-DESC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=pd.name&order=DESC'
					);

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_asc'),
					'value' => 'p.price-ASC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=p.price&order=ASC'
					);

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_price_desc'),
					'value' => 'p.price-DESC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=p.price&order=DESC'
					);

					if ($this->config->get('config_review')) {
						$this->data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_desc'),
						'value' => 'rating-DESC',
						'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=rating&order=DESC'
						);
							
						$this->data['sorts'][] = array(
						'text'  => $this->language->get('text_rating_asc'),
						'value' => 'rating-ASC',
						'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=rating&order=ASC'
						);
					}

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_asc'),
					'value' => 'p.model-ASC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=p.model&order=ASC'
					);

					$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_model_desc'),
					'value' => 'p.model-DESC',
					'href'  => HTTP_SERVER . 'index.php?route=product/search' . $url . '&sort=p.model&order=DESC'
					);

					$url = '';

					if (isset($this->request->get['keyword'])) {
						$url .= '&keyword=' . $this->request->get['keyword'];
					}

					if (isset($this->request->get['category_id'])) {
						$url .= '&category_id=' . $this->request->get['category_id'];
					}

					if (isset($this->request->get['description'])) {
						$url .= '&description=' . $this->request->get['description'];
					}

					if (isset($this->request->get['model'])) {
						$url .= '&model=' . $this->request->get['model'];
					}

					if (isset($this->request->get['sort'])) {
						$url .= '&sort=' . $this->request->get['sort'];
					}

					if (isset($this->request->get['order'])) {
						$url .= '&order=' . $this->request->get['order'];
					}

					$pagination = new Pagination();
					$pagination->total = $product_total;
					$pagination->page = $page;
					$pagination->limit = $this->request->get['perpage'];
					$pagination->text = $this->language->get('text_pagination');

					$pagination_sub_url = "";
					if($this->request->get['search_cat'] == 1) {

						if(isset($this->request->get['titel'])) {
							$pagination_sub_url .= "&titel=".$this->request->get['titel'];
						}
						if(isset($this->request->get['wv_cr_nr'])) {
							$pagination_sub_url .= "&wv_cr_nr=".$this->request->get['wv_cr_nr'];
						}
						if(isset($this->request->get['jahr_t'])) {
							$pagination_sub_url .= "&jahr_t=".$this->request->get['jahr_t'];
						}
					}elseif($this->request->get['search_cat'] == 2 ) {

						if(isset($this->request->get['titel2'])) {
							$pagination_sub_url .= "&titel2=".$titel2;
						}else {
							//$titel = 0;
						}
						if(isset($this->request->get['tag'])) {
							$pagination_sub_url .= "&tag=".$tag;

						}else {
							//$tag = 0;
						}
						if(isset($this->request->get['monat'])) {
							$pagination_sub_url .= "&monat=".$monat;
						}else {
							//$monat = 0;
						}
						if(isset($this->request->get['jahr'])) {
							$pagination_sub_url .= "&jahr=".$jahr;
						}else {
							//$jahr = 0;
						}

					}

					$pagination->url = HTTP_SERVER . 'index.php?route=product/search' . $url . '&page={page}&search_cat='.
					$this->request->get['search_cat'].'&perpage='.$this->request->get['perpage'].
								'&parent_id='.$this->request->get['parent_id'].$pagination_sub_url;


					;

					//print_r($_REQUEST);

					$this->data['pagination'] = $pagination->render();

					$this->data['sort'] = $sort;
					$this->data['order'] = $order;
					$this->data['perpage'] = $this->request->get['perpage'];
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/search.tpl';
		} else {
			$this->template = 'default/template/product/search.tpl';
		}

		$this->children = array(
			'common/column_right',
			'common/column_left',
			'common/footer',
			'common/header'
			);

			$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function getCategories($parent_id, $level = 0) {
		$level++;

		$data = array();

		$results = $this->model_catalog_category->getCategories(36);

		foreach ($results as $result) {
			$data[] = array(
				'category_id' => $result['category_id'],
				'parent_id' => $result['parent_id'],
				'name'        => str_repeat('', $level) . $result['name']
			);
		}

		$results = $this->model_catalog_category->getCategories(37);

		foreach ($results as $result) {
			$data[] = array(
				'category_id' => $result['category_id'],
				'parent_id' => $result['parent_id'],
				'name'        => str_repeat('', $level) . $result['name']
			);
		}


		return $data;
	}
}
?>