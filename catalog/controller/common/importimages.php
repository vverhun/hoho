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

                ini_set('display_errors', '0');
		define('DIR_IMAGE_UPLOAD', DIR_IMAGE."upload/");
		include(DIR_COR."index_exif.php");
 


		$this->load->model('tool/image');
		$this->load->model('import/product');
                $allImagesNamesArray = array();
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
                                                        $allImagesNamesArray[] =  $file;

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
											$errors[$i]['default_name'] = "...";
										}
									}
									else {
										$product_description[0]['name'] = "...";
										$product_description[1]['name'] = "...";
										$errors[$i]['default_name'] = "...";
									}
								}else{
									if (isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:CountryCode'])){
										$name   =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:CountryCode'];
										$name2  =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'];

										if (trim($name) != '' ){

											$product_description[0]['name'] =  $name; //eng
											$product_description[1]['name'] =  $name; //ger


										}else{

											$product_description[0]['name'] = "..."; //eng
											$product_description[1]['name'] = "..."; //ger

										}
									}


									/*if (isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'])){
										$name2  =  $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:title']['rdf:Alt']['rdf:li'];
										$product_description[0]['name'] = $name2; //eng
										$product_description[1]['name'] = $name2; //ger
											
										}else{
										$product_description[0]['name'] = "..."; //eng
										$product_description[1]['name'] = "..."; //ger
										}*/


								}

								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li'])) {
									$product_description[0]['meta_keywords'] = trim(str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li']));
									$product_description[1]['meta_keywords'] = trim(str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:description']['rdf:Alt']['rdf:li']));

								}
								else {
									$product_description[0]['meta_keywords'] = "...";
									$product_description[1]['meta_keywords'] = "...";

									$errors[$i]['default_meta_keywords'] = "...";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:IntellectualGenre'])) {

									$meta_description = explode(" / ", $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['Iptc4xmpCore:IntellectualGenre']);
									$product_description[0]['meta_description'] = $meta_description[0]; //eng

									if(isset($meta_description[1])) {
										$product_description[1]['meta_description'] = $meta_description[1]; //ger
									}
									else {
										$product_description[1]['meta_description'] = $meta_description[0]; //ger
										$errors[$i]['default_meta_description'] = "...";
									}
								}
								else {
									$product_description[0]['meta_description'] = "...";
									$product_description[1]['meta_description'] = "...";

									$errors[$i]['default_meta_keywords'] = "...";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source'])) {
									$product_description[0]['description'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source']; //eng
									$product_description[1]['description'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Source']; //ger
								}
								else {
									$product_description[0]['description'] = "...";
									$product_description[1]['description'] = "...";

									$errors[$i]['default_description'] = "...";
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
									$product['model'] = "...";

									$errors[$i]['default_model'] = "...";
								}
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:subject']['rdf:Bag']['rdf:li'])) {
									$product['location'] = substr($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['dc:subject']['rdf:Bag']['rdf:li'], 0, 4);
								}
								else {
									$product['location'] =  "...";
									$errors[$i]['default_location'] = "...";
								}

								if (!in_array((int)$category_id, $catArr)){
									if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['Iptc4xmpCore:SubjectCode']['rdf:Bag']['rdf:li'])) {
										$product['sku'] = $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description']['Iptc4xmpCore:SubjectCode']['rdf:Bag']['rdf:li'];
									}
									else {
										$product['sku'] = -1;
										$errors[$i]['default_sku'] = "...";
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
									$errors[$i]['default_weight'] = "...";
								}
									
								if(isset($xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Instructions'])) {
									$width_height = explode(' x ', str_replace(',', '.', $xmlObj['x:xmpmeta']['rdf:RDF']['rdf:Description_attr']['photoshop:Instructions']) );

									$product['width']  = $width_height[0];
									$product['height'] = trim(str_replace('cm', '', $width_height[1]) );
								}
								else {
									$product['width']  = 0;
									$product['height'] = 0;

									$errors[$i]['default_width_height'] = "...";
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

									$data['sku_sort'] = $this->createSkuSort($sku);


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
									$data['sku_sort'] = $this->createSkuSort($sku);


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
 
                 //check images removing 
                //compare $allImagesNamesArray with names from database
                $idsForDisable = array();
                
                $allImages = $this->model_import_product->getAllProductImages();
                foreach ($allImages as $image){
                    $product_id = $image['product_id'];
                    $image      = str_replace("data/", "", $image['image'] );
                  
                    if (!in_array($image, $allImagesNamesArray)){
                        $idsForDisable[] = $product_id;
                    }
                }

                foreach ( $idsForDisable as $product_id){
                    $this->model_import_product->disableProduct($product_id);
                    $errors[$i]['remove'] = $image.": removed";
                    $i++;
                }
                
                
                $this->data['errors'] = $errors;
                $this->session->data['importerrors'] = $errors;
                
		$this->template = 'default/template/common/import.tpl';


		$this->children = array();




		$this->children[] =	'common/footer';
		$this->children[] =	'common/header';

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));


	}


	private function createSkuSort( $sku ){

		$new_sku = strtolower($sku);

		// perspective
		$pos = strpos($new_sku, 'perspective');
		if ($pos !== false) {
			$new_sku   = str_replace("perspective", ".", $new_sku );
			$new_sku   = str_replace(" ", "", $new_sku );
			return $this->convertOutput($new_sku);
		}

		// _
		$pos = strpos($sku, '_');
		if ($pos !== false) {
			$new_sku   = str_replace("_", ".", $new_sku );
			$new_sku   = str_replace(" ", "", $new_sku );

			$lastsymbol = substr($new_sku, -1);
			$lastsymbol = $this->toNumber($lastsymbol);
			$new_sku = substr($new_sku, 0, -1).$lastsymbol;

			return $this->convertOutput($new_sku);
		}



		//Phase 0
		$pos = strpos($new_sku, 'phase 0');
		$pos2 = strpos($new_sku, '-');
		if ($pos !== false && $pos2 === false) {
			$new_sku   = str_replace("phase 0", ".", $new_sku );
			$new_sku   = str_replace(" ", "", $new_sku );

			return $this->convertOutput($new_sku);
		}

		//-1 phase 0
		if ($pos !== false && $pos2 !== false) {

			$new_sku   = str_replace(" ", "", $new_sku );
			$new_skuArray =  explode("phase", $new_sku);

			$new_sku = str_replace("-", ".", $new_skuArray[0] );
			$new_sku =  $this->convertOutput($new_sku) + 0.0011;
			$new_sku = $new_sku.$new_skuArray[1];
 
				
			return $new_sku;

		}
		
		//Phase
		$pos = strpos($new_sku, 'phase');
		if ($pos !== false) {
			$new_sku   = str_replace("phase", ".", $new_sku );
			$new_sku   = str_replace(" ", "", $new_sku );
			return $this->convertOutput($new_sku);
		}
		//numbers with chars
		//search if sku has chars
		$arrchars = array('a','b','c','d','e','f','g','h','i','g','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$arrcharsreplace = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26');

		$pos = $this->strpos_arr($new_sku, $arrchars);
		$pos2 = strpos($new_sku, '-');
		//130b-1
		if ( $pos !== false && $pos2 !== false){
			$new_sku_temp = intval($new_sku);


			$new_sku   = str_replace("-", "", $new_sku );
			//replace every char into numeric
			$new_sku = str_replace($arrchars, $arrcharsreplace, $new_sku);
			$new_sku = str_replace($new_sku_temp, $new_sku_temp.".", $new_sku);
			return $this->convertOutput($new_sku) + 0.0021;

		}

		//130c
		if ($pos !== false && $pos2 === false) {

			$arrcharsreplace = array('.0010','.0020','.0030','.0040','.0050','.0060','.0070','.0080','.0090','.0100','.0110','.0120','.0130','.0140','.0150','.0160','.0170','.0180','.0190','.0200','.0210','.0220','.0230','.0240','.0250','.0260');

			$new_sku = str_replace($arrchars, $arrcharsreplace, $new_sku);
			return $this->convertOutput($new_sku)+ 0.0021;
		}

			

		$pos = strpos($new_sku, '-');
		if ($pos !== false) {
			$new_sku = str_replace("-", ".", $sku );
			return $this->convertOutput($new_sku) + 0.0011;
		}

		return $new_sku;
	}

	private function convertOutput($input){

		$input2 = explode(".", $input);

		if ( count($input2) == 1 ) return $input;

		$parttwo = $input2[1];
		$partone = $input2[0];
		$parttwo = $this->zerofill($parttwo);

		return $partone.".".$parttwo;

	}


	private function zerofill ($num) {

		while (strlen($num) < 4) {
			$num = "0".$num;
		}
		return $num;
	}


	private function toNumber($dest)
	{
		if ($dest)
		return ord(strtolower($dest)) - 96;
		else
		return 0;
	}

	private function strpos_arr($haystack, $needle) {
		if(!is_array($needle)) $needle = array($needle);
		foreach($needle as $what) {
			if(($pos = strpos($haystack, $what))!==false) return $pos;
		}
		return false;
	}



	public function protocol() {

		$this->data['errors'] = $this->session->data['importerrors'];

		$this->template = 'default/template/common/import2.tpl';

		$this->children = array();

		$this->children[] =	'common/footer';
		$this->children[] =	'common/header';

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));


	}

}
?>
