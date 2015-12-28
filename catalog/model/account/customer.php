<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data, $file) {

		if ($data['type_person'] == 'firma') {
			$data['privatperson'] = '';
			$data['museum'] = '';
			$data['firma'] = 'on';
		}

		if ($data['type_person'] == 'museum') {
			$data['privatperson'] = '';
			$data['museum'] = 'on';
			$data['firma'] = '';
		}

		if ($data['type_person'] == 'privatperson') {
			$data['privatperson'] = 'on';
			$data['museum'] = '';
			$data['firma'] = '';

		}


		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET  lang = '" . $this->db->escape($data['communic']) . "',  downloadedfile = '" . $this->db->escape($file) . "', username = '" . $this->db->escape($data['username']) . "', mobile = '" . $this->db->escape($data['mobile']) . "', bill_address = '" . $this->db->escape($data['bill_address']) . "', privatperson = '" . $this->db->escape($data['privatperson']) . "', museum = '" . $this->db->escape($data['museum']) . "', firma = '" . $this->db->escape($data['firma']) . "', taxid_number = '" . $this->db->escape($data['taxid_number']) . "', position = '" . $this->db->escape($data['position']) . "', ansprechpartner = '" . $this->db->escape($data['ansprechpartner']) . "', store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['company']) . "', lastname = '" . $this->db->escape($data['company2']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', password = '" . $this->db->escape(md5($data['password'])) . "', newsletter = '0', customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "', status = '1', date_added = NOW()");
			
		$customer_id = $this->db->getLastId();
		if($data['bill_access'] == 'on'){

			$this->db->query("INSERT INTO " . DB_PREFIX . "bill_address SET customer_id = '" . (int)$customer_id . "', bill_address_1 = '" . $this->db->escape($data['bill_address_1']) . "', bill_postcode = '" . $this->db->escape($data['bill_postcode']) . "', bill_city = '" . $this->db->escape($data['bill_city']) . "', bill_land = '" . $this->db->escape($data['bill_land']) . "', bill_taxid_number = '" . $this->db->escape($data['bill_taxid_number']) . "', bill_telephone = '" . $this->db->escape($data['bill_telephone']) . "', bill_mobile = '" . $this->db->escape($data['bill_mobile']) . "', bill_fax = '" . $this->db->escape($data['bill_fax']) . "', bill_email = '" . $this->db->escape($data['bill_email']) . "'");
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['company']) . "', lastname = '" . $this->db->escape($data['company2']) . "', company = '', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . $data['land'] . "', zone_id = ''");

		$address_id = $this->db->getLastId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

		if (!$this->config->get('config_customer_approval')) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	public function editCustomer($data) {
		$data['firstname'] = trim($data['firstname']);
		$data['lastname'] = ucwords(strtolower(trim($data['lastname'])));
		//print_r($data);
		//die();
	 if ($data['type_person'] == 'firma') {
	 	$data['privatperson'] = '';
	 	$data['museum'] = '';
	 	$data['firma'] = 'on';
		}

		if ($data['type_person'] == 'museum') {
			$data['privatperson'] = '';
			$data['museum'] = 'on';
			$data['firma'] = '';
			$data['taxid_number'] = '';
		}

		if ($data['type_person'] == 'privatperson') {
			$data['privatperson'] = 'on';
			$data['museum'] = '';
			$data['firma'] = '';
			$data['taxid_number'] = '';

		}

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET lang = '" . $this->db->escape($data['communic']) . "', privatperson = '" . $this->db->escape($data['privatperson']) . "', museum = '" . $this->db->escape($data['museum']) . "', firma = '" . $this->db->escape($data['firma']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "',  taxid_number = '" . $this->db->escape($data['taxid_number']) . "', ansprechpartner = '" . $this->db->escape($data['ansprechpartner']) . "', position = '" . $this->db->escape($data['position']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', mobile = '" . $this->db->escape($data['mobile']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "address SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', city = '" . $this->db->escape($data['city']) . "', country_id = '" . $this->db->escape($data['land']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		if($this->db->escape($data['password']) && trim($this->db->escape($data['password'])) != '' ){
			$this->editPassword($this->db->escape($data['username']), $data['password']);
		}
	}

	public function editPassword($user, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($password)) . "' WHERE username = '" . $user . "'");
	}
	
	public function editPasswordAdmin( $password ) {
		$this->db->query("UPDATE " . DB_PREFIX . "user SET password = '" . $this->db->escape(md5($password)) . "' WHERE username = 'admin'");
	}	
	

	public function editPasswordByEmail($user, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($password)) . "' WHERE email = '" . $user . "'");
	}	
	
	
	
	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	private function isEUState($country){

		$states = array();

		$states[] = 'Austria';
		$states[] = 'Belgium';
		$states[] = 'Bulgaria';
		$states[] = 'Cyprus';
		$states[] = 'Czech Republic';
		$states[] = 'Denmark';
		$states[] = 'Estonia';
		$states[] = 'Finland';
		$states[] = 'France';
 		$states[] = 'Greece';
		$states[] = 'Hungary';
		$states[] = 'Ireland';
		$states[] = 'Italy';
		$states[] = 'Latvia';
		$states[] = 'Lithuania';
		$states[] = 'Luxembourg';
		$states[] = 'Malta';
		$states[] = 'Netherlands';
		$states[] = 'Poland';
		$states[] = 'Portugal';
		$states[] = 'Romania';
		$states[] = 'Slovakia';
		$states[] = 'Slovenia';
		$states[] = 'Spain';
		$states[] = 'Sweden';
		$states[] = 'United Kingdom';

		return in_array($country, $states);

	}

	public function getCustomerCountry($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$row = $query->row;
 

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		$row = $query->row;

		$country = $row['country_id'];
 
		return $country;

	}	
	
	
	public function getCustomerType($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$row = $query->row;

		$firma = $row['firma'];
		$taxid = $row['taxid_number'];
		$museum = $row['museum'];

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		$row = $query->row;

		$country = $row['country_id'];

		/*user types:
		 1 - Deutschland Unternehmen
		 2 - Deutschland Privatpersonen
		 3 - EU-Staaten Unternehmen with TAXid
		 4 - EU-Staaten Unternehmen without TAXid
		 5 - außerhalb der EU Unternehmen
		 6 - außerhalb der EU Privatpersonen
		  7 - EU Privatpersonen  7 %
		  
		 */
			

		if ( ( $firma == 'on' || $museum == 'on' ) && $country == 'Germany') return 1;
		if ( $firma != 'on' && $museum != 'on' && $country == 'Germany') return 2;
		if ( $this->isEUState($country) && trim($taxid) != '' && ( $firma == 'on' || $museum == 'on' )) return 3;
		if ( $this->isEUState($country) && trim($taxid) == '' && ( $firma == 'on' || $museum == 'on' )) return 4;
		if ( !$this->isEUState($country) && ( $firma == 'on' || $museum == 'on')) return 5;
		if ( !$this->isEUState($country) && ( $firma != 'on' && $museum != 'on')) return 6;
        if ( $this->isEUState($country) && $firma != 'on' && $museum != 'on') return 7; 
         
		return 6;

	}


	public function getBill($customer_id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bill_address WHERE customer_id = '" . (int)$customer_id . "'");
		//print_r($query);
		//die();
		if($query->num_rows == 0){
			$data['bill_address'] = 'on';
		}else{
			$data = $query->row;
			$data['bill_address'] = 'off';
		}
		return $data;
	}
	public function editBill($data){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bill_address WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		if($query->num_rows == 0){
			$this->addBill($data);
		}else{
			$this->db->query("UPDATE " . DB_PREFIX . "bill_address SET bill_address_1 = '" . $this->db->escape($data['bill_address_1']) . "', bill_postcode = '" . $this->db->escape($data['bill_postcode']) . "', bill_city = '" . $this->db->escape($data['bill_city']) . "', bill_land = '" . $this->db->escape($data['bill_land']) . "', bill_taxid_number = '" . $this->db->escape($data['bill_taxid_number']) . "', bill_telephone = '" . $this->db->escape($data['bill_telephone']) . "', bill_mobile = '" . $this->db->escape($data['bill_mobile']) . "', bill_fax = '" . $this->db->escape($data['bill_fax']) . "', bill_email = '" . $this->db->escape($data['bill_email']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}
	}
	public function delBill($data){
		$this->db->query("DELETE FROM " . DB_PREFIX . "bill_address WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
	public function addBill($data){
		$this->db->query("INSERT INTO " . DB_PREFIX . "bill_address SET customer_id = '" . (int)$this->customer->getId() . "', bill_address_1 = '" . $this->db->escape($data['bill_address_1']) . "', bill_postcode = '" . $this->db->escape($data['bill_postcode']) . "', bill_city = '" . $this->db->escape($data['bill_city']) . "', bill_land = '" . $this->db->escape($data['bill_land']) . "', bill_taxid_number = '" . $this->db->escape($data['bill_taxid_number']) . "', bill_telephone = '" . $this->db->escape($data['bill_telephone']) . "', bill_mobile = '" . $this->db->escape($data['bill_mobile']) . "', bill_fax = '" . $this->db->escape($data['bill_fax']) . "', bill_email = '" . $this->db->escape($data['bill_email']) . "'");
	}

	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");

		return $query->row['total'];
	}
	public function getTotalBillByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bill_address WHERE bill_email = '" . $this->db->escape($email) . "'");

		return $query->row['total'];
	}
}
?>