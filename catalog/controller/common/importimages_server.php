<?php
class ControllerCommonImportimages extends Controller {


	public function index() {



	}
	public function get_between($input, $start, $end)
	{
		$substr = substr($input, strlen($start)+strpos($input, $start), (strlen($input) - strpos($input, $end))*(-1));
		return $substr;
	}

	public function upload() {

	define('DIR_IMAGE_UPLOAD', "/serv/www/www.gerhard-richter-images.de/data/image/upload/");
		include("/serv/www/www.gerhard-richter-images.de/data/index_exif.php");


 

		$this->load->model('tool/image');
		$this->load->model('import/product');

		$handle = opendir(DIR_IMAGE_UPLOAD);
		$exempt = array('.','..','.svn');
		$dir_categories = array();
			
			
		/*Aquarelle_41
		 Atlas_39
		 Bilder_Skulpturen_35
		 Editionen_38
		 Oil auf Papier_43
		 Ubermalte Fotograen_40
		 Zeichnungen_42*/
			
		if($handle = opendir(DIR_IMAGE_UPLOAD)) {

			while($dir_cat = readdir($handle)) {
					
				clearstatcache();
				if(!in_array(strtolower($dir_cat), $exempt)) {
					if(is_dir(DIR_IMAGE_UPLOAD.$dir_cat.'/'))  {

						$dir_categories[$dir_cat] = DIR_IMAGE_UPLOAD.$dir_cat.'/';
					}
				}
			}
			closedir($handle);
		}
		else {

			print_r("There is no folder ".DIR_IMAGE_UPLOAD);
			die;
		}

		$errors = array();
		$i = 0;
		//Getting files from directories $key => $dir_cat_name
		//where $key is ID of category
		$catArr = array( 40, 41, 42, 43 );

		if(count($dir_categories) > 0) {
 
			foreach($dir_categories as $category_id => $dir_cat_name ) {

				if($handle = opendir($dir_cat_name)) {

					while($file = readdir($handle)) {
							
							
						clearstatcache();
						if(!in_array(strtolower($file), $exempt)) {


							$img = $dir_cat_name.$file;
							$errors[$i]['file'] = $img;
							$errors[$i]['upload'] = "No";
							if(is_file($img)) {
									
									
								//$content =  file_get_contents($img);
								$handle123  = fopen($img, "rb");
								$content = fread($handle123, filesize($img));

								//$content = iconv('KOI8-R', 'UTF-8', $content);
								//echo $content;
									
								//preg_match_all('/<x:xmpmeta(.*)/s', $content, $match);

								$res = $this->get_between($content, "<x:xmpmeta", "</x:xmpmeta>");
									
								$res =  "<x:xmpmeta".$res."</x:xmpmeta>";


								$xml  = '<?xml version="1.0"?>'. $res;
								$xmlObj = xml2array($xml);
									

								$errors[$i]['upload'] = ": success";
									
								//richterproduct_description
								//language_id 	name 	meta_keywords 	meta_description 	description
									
								//$product_description[0]['product_id'] = 33; //eng
								//$product_description[1]['product_id'] = 33; //ger
								//$product_description[0]['language_id'] = 1; //eng
								//$product_description[1]['language_id'] = 2; //ger

								if (!in_array((int)$category_id, $catArr)){

									if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'])) {

										$names = explode(" / ", $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li']);
										$product_description[0]['name'] = $names[0]; //eng
										if(isset($names[1])) {
											$product_description[1]['name'] = $names[1]; //ger
										}
										else {
											$product_description[1]['name'] = $names[0]; //ger
											$errors[$i]['default_name'] = "Default Product Name";
										}
									}
									else {
										$product_description[0]['name'] = "Default Product Name";
										$product_description[1]['name'] = "Default Product Name";
										$errors[$i]['default_name'] = "Default Product Name";
									}
								}else{
									if (isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:CountryCode'])){
										$name   =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:CountryCode'];
										$name2  =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'];
										if (trim($name) != '' ){

											$product_description[0]['name'] = $name2." ".$name; //eng
											$product_description[1]['name'] = $name2." ".$name; //ger


										}else{

											$product_description[0]['name'] = $name2; //eng
											$product_description[1]['name'] = $name2; //ger

										}
									}else{
										$name2  =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'];
										$product_description[0]['name'] = $name2; //eng
										$product_description[1]['name'] = $name2; //ger

									}

								}


								/*print_r($names);
								 print_r('<br>');
								 print_r($img);
								 print_r('<br>');*/
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li'])) {
									$product_description[0]['meta_keywords'] = trim(str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li']));
									$product_description[1]['meta_keywords'] = trim(str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li']));

								}
								else {
									$product_description[0]['meta_keywords'] = "Default Product meta_keywords";
									$product_description[1]['meta_keywords'] = "Default Product meta_keywords";

									$errors[$i]['default_meta_keywords'] = "Default Product meta_keywords";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:IntellectualGenre'])) {

									$meta_description = explode(" / ", $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:IntellectualGenre']);
									$product_description[0]['meta_description'] = $meta_description[0]; //eng

									if(isset($meta_description[1])) {
										$product_description[1]['meta_description'] = $meta_description[1]; //ger
									}
									else {
										$product_description[1]['meta_description'] = $meta_description[0]; //ger
										$errors[$i]['default_meta_description'] = "Default meta_description";
									}
								}
								else {
									$product_description[0]['meta_description'] = "Default Product meta_description";
									$product_description[1]['meta_description'] = "Default Product meta_description";

									$errors[$i]['default_meta_keywords'] = "Default Product meta_description";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source'])) {
									$product_description[0]['description'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source']; //eng
									$product_description[1]['description'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source']; //ger
								}
								else {
									$product_description[0]['description'] = "Default Product description";
									$product_description[1]['description'] = "Default Product description";

									$errors[$i]['default_description'] = "Default Product description";
								}
									
									
									
									
									
									
								/*//richterproduct_description.name - 2 lang separator " / " - Album Photos / Albumfotos
								 print_r($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li']);

								 //richterproduct_description. - "big size" - 51,7 x 66,7 cm
								 print_r($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li']);

								 //richterproduct_description.meta_description 28 b/w photographs / 28 sw Fotografien
								 print_r($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:IntellectualGenre']);

								 //richterproduct_description.description CMYK
								 print_r($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source']);*/
									
								//print_r($xmlObj['x:xmpmeta']);
									
								//die;
									
									
								//richterproduct
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Credit'])) {
									$product['model'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Credit'];
								}
								else {
									$product['model'] = "Default Product model";

									$errors[$i]['default_model'] = "Default Product model";
								}
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:subject']['rdf:Bag']['rdf:li'])) {
									$product['location'] = substr($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:subject']['rdf:Bag']['rdf:li'], 0, 4);
								}
								else {
									$product['location'] =  "Default Product location";
									$errors[$i]['default_location'] = "Default Product location";
								}

								if (!in_array((int)$category_id, $catArr)){
									if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['Iptc4xmpCore:SubjectCode']['rdf:Bag']['rdf:li'])) {
										$product['sku'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['Iptc4xmpCore:SubjectCode']['rdf:Bag']['rdf:li'];
									}
									else {
										$product['sku'] = -1;
										$errors[$i]['default_sku'] = "Default Product SKU";
									}
								}else{

									$product['sku'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'];

								}
									


								$product['image'] = 'data/'.$file;
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:TransmissionReference'])) {
									$weight = explode(' ', str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:TransmissionReference']));
									$product['weight'] = $weight[0];
								}
								else {
									$product['weight'] = 0;
									$errors[$i]['default_weight'] = "Default Product weight";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Instructions'])) {
									$width_height = explode(' x ', str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Instructions']) );

									$product['width']  = $width_height[0];
									$product['height'] = trim(str_replace('cm', '', $width_height[1]) );
								}
								else {
									$product['width']  = 0;
									$product['height'] = 0;

									$errors[$i]['default_width_height'] = "Default Product width or height";
								}
									
									
									
									
								//this values by default
								$product['quantity'] = -6;
								$product['stock_status_id'] = 5;
								$product['manufacturer_id'] = 0;
								$product['shipping'] = 1;
								$product['price'] = 0.0000;
								$product['tax_class_id'] = 0;
								$product['date_available'] = date("Y-m-d", time());
								$product['weight_class_id'] = 1;
								$product['length'] = 0.00;
								$product['length_class_id'] = 1;
								$product['status'] = 1;
								$product['date_added'] = date("Y-m-d H:i:s", time());
								$product['date_modified'] = date("Y-m-d  H:i:s", time());
								$product['viewed'] = 0;
								$product['sort_order'] = 1;
								$product['subtract'] = 1;
								$product['minimum'] = 1;
								$product['cost'] = 0.0000 ;
									

								//print_r($product);
								//print_r($product_description);
									
									
									
								//this inserting into Data base
									
									
								$product_model = $this->model_import_product->getProductByImage($product['image']);
									
								if(count($product_model) > 0) {
									$product_id = $product_model[0]['product_id'];
									$data = array();

									$data['product_description'][1]['name'] = $product_description[0]['name'];
									$data['product_description'][1]['meta_keywords'] = $product_description[0]['meta_keywords'];
									$data['product_description'][1]['meta_description'] = $product_description[0]['meta_description'];
									$data['product_description'][1]['description'] = $product_description[0]['description'];

									$data['product_description'][2]['name'] = $product_description[1]['name'];
									$data['product_description'][2]['meta_keywords'] = $product_description[1]['meta_keywords'];
									$data['product_description'][2]['meta_description'] = $product_description[1]['meta_description'];
									$data['product_description'][2]['description'] = $product_description[1]['description'];
									$data['model'] = $product['model'];
									$data['sku'] = $product['sku'] ;
										
									$sku  = $product['sku'];
									$sku  = str_replace("a", "", $sku);
									$sku  = str_replace("b", "", $sku);
									$sku  = str_replace("c", "", $sku);
									$sku  = str_replace("d", "", $sku);
									$data['sku_sort'] = str_replace("-", ".", $sku );
										
									$data['location'] = $product['location'];
									$data['image'] = $product['image'];
									$data['width'] = $product['width'];
									$data['height'] = $product['height'];
									$data['weight'] = $product['weight'];
									$data['product_category'][0] = (int)$category_id;


									$data['date_available'] = $product_model[0]['date_available'];
									$data['status'] = $product_model[0]['status'];
									$data['price'] = $product_model[0]['price'];
									$data['cost'] = $product_model[0]['cost'];
									$data['tax_class_id'] = $product_model[0]['tax_class_id'];
									$data['quantity'] = $product_model[0]['quantity'];
									$data['minimum'] = $product_model[0]['minimum'];
									$data['subtract'] = $product_model[0]['subtract'];
									$data['stock_status_id'] = $product_model[0]['stock_status_id'];
									$data['shipping'] = $product_model[0]['shipping'];

									$data['sort_order'] = $product_model[0]['sort_order'];
									$data['length'] = $product_model[0]['length'];
									$data['length_class_id'] = $product_model[0]['length_class_id'];
									$data['weight_class_id'] = $product_model[0]['weight_class_id'];
									$data['manufacturer_id'] = $product_model[0]['manufacturer_id'];

									$data['tax_class_id'] = $product_model[0]['tax_class_id'];
									$data['viewed'] = $product_model[0]['viewed'];
									$data['date_added'] = $product_model[0]['date_added'];

									/*[] => 0
									 [] => 2011-05-25
									 [weight] => 22.52
									 [] => 0
									 [] => 0.00
									 [width] => 22.00
									 [height] => 17.70
									 [] => 0
									 [] => 0
									 [] => 2011-05-25 18:36:01

									 [] => 0
									 [sort_order] => 0
									 [] => 0
									 [] => 0*/



									/*print_r($product_model[0]);
									 die;*/

									$this->model_import_product->editProduct($product_id, $data);
									$errors[$i]['product_id'] = $product_id;
								}
								else {
									$data = array();

									$data['product_description'][1]['name'] = $product_description[0]['name'];
									$data['product_description'][1]['meta_keywords'] = $product_description[0]['meta_keywords'];
									$data['product_description'][1]['meta_description'] = $product_description[0]['meta_description'];
									$data['product_description'][1]['description'] = $product_description[0]['description'];

									$data['product_description'][2]['name'] = $product_description[1]['name'];
									$data['product_description'][2]['meta_keywords'] = $product_description[1]['meta_keywords'];
									$data['product_description'][2]['meta_description'] = $product_description[1]['meta_description'];
									$data['product_description'][2]['description'] = $product_description[1]['description'];
									$data['model'] = $product['model'];
										
									$data['sku'] = $product['sku'];
										
									$sku  = $product['sku'];
									$sku  = str_replace("a", "", $sku);
									$sku  = str_replace("b", "", $sku);
									$sku  = str_replace("c", "", $sku);
									$sku  = str_replace("d", "", $sku);
									$data['sku_sort'] = str_replace("-", ".", $sku );
										
									$data['location'] = $product['location'];
									$data['image'] = $product['image'];
									$data['date_available'] = $product['date_available'];
									$data['width'] = $product['width'];
									$data['height'] = $product['height'];
									$data['weight'] = $product['weight'];
									$data['product_category'][0] = (int)$category_id;

									$data['product_tags'][1] = '';
									$data['product_tags'][2] = '';

									$data['status'] = 1;
									$data['price'] = 0.0000;
									$data['cost'] = 0.0000;
									$data['tax_class_id'] = 0;
									$data['quantity'] = -5;
									$data['minimum'] = 1;
									$data['subtract'] = 1;
									$data['stock_status_id'] = 5;
									$data['shipping'] = 1;
									$data['keyword'] = '';
									$data['sort_order'] = 1;
									$data['length'] = 0.0;
									$data['length_class_id'] = 1;
									$data['weight_class_id'] = 1;
									$data['manufacturer_id'] = 0;
									$data['product_store'][0] = 0;
									$errors[$i]['product_id'] = $this->model_import_product->addProduct($data);
								}
									
								copy($img, DIR_IMAGE.'data/'.$file);
									
								//unlink($img);
									
							}
							$i++;
						}
					}

				}
				else {
					print_r("There is no folder ".$dir_cat_name);
			        die();
				}


			}

		}
		else {
			print_r("There is no folders in ".DIR_IMAGE_UPLOAD);
		    die();

		}

		$this->data['errors'] = $errors;


 
	    $this->template = 'default/template/common/import.tpl';
	 

		$this->children = array();

 
 
 
		$this->children[] =	'common/footer';
		$this->children[] =	'common/header';

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
		

	}









}
?>
