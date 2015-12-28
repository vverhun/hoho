<?php

class ModelSaleCustomer extends Model {

    public function addCustomer($data, $filename) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET downloadedfile = '" . $this->db->escape($filename) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int) $data['newsletter'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', password = '" . $this->db->escape(md5($data['password'])) . "', status = '" . (int) $data['status'] . "', date_added = NOW()");

        $customer_id = $this->db->getLastId();

        if (isset($data['addresses'])) {
            foreach ($data['addresses'] as $address) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int) $customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int) $address['country_id'] . "', zone_id = '" . (int) $address['zone_id'] . "'");
                if (isset($address['default'])) {
                    $address_id = $this->db->getLastId();

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . $address_id . "' WHERE customer_id = '" . (int) $customer_id . "'");
                }
            }
        }
    }

    public function editCustomer($customer_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int) $data['newsletter'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', status = '" . (int) $data['status'] . "' WHERE customer_id = '" . (int) $customer_id . "'");

        if ($data['password']) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET password = '" . $this->db->escape(md5($data['password'])) . "' WHERE customer_id = '" . (int) $customer_id . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int) $customer_id . "'");

        if (isset($data['addresses'])) {
            foreach ($data['addresses'] as $address) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int) $customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int) $address['country_id'] . "', zone_id = '" . (int) $address['zone_id'] . "'");
                if (isset($address['default'])) {
                    $address_id = $this->db->getLastId();

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . $address_id . "' WHERE customer_id = '" . (int) $customer_id . "'");
                }
            }
        }
    }

    public function getAddressesByCustomerId($customer_id) {
        $address_data = array();

        $query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");

        $default_address_id = $query->row['address_id'];

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int) $customer_id . "'");

        foreach ($query->rows as $result) {
            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $result['country_id'] . "'");

            if ($country_query->num_rows) {
                $country = $country_query->row['name'];
                $iso_code_2 = $country_query->row['iso_code_2'];
                $iso_code_3 = $country_query->row['iso_code_3'];
                $address_format = $country_query->row['address_format'];
            } else {
                $country = '';
                $iso_code_2 = '';
                $iso_code_3 = '';
                $address_format = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $result['zone_id'] . "'");

            if ($zone_query->num_rows) {
                $zone = $zone_query->row['name'];
                $code = $zone_query->row['code'];
            } else {
                $zone = '';
                $code = '';
            }

            $address_data[] = array(
                'address_id' => $result['address_id'],
                'firstname' => $result['firstname'],
                'lastname' => $result['lastname'],
                'company' => $result['company'],
                'address_1' => $result['address_1'],
                'address_2' => $result['address_2'],
                'postcode' => $result['postcode'],
                'city' => $result['city'],
                'zone_id' => $result['zone_id'],
                'zone' => $zone,
                'zone_code' => $code,
                'country_id' => $result['country_id'],
                'country' => $country,
                'iso_code_2' => $iso_code_2,
                'iso_code_3' => $iso_code_3,
                'address_format' => $address_format,
                'default' => ($default_address_id == $result['address_id']) ? true : false
            );
        }

        return $address_data;
    }

    public function deleteCustomer($customer_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int) $customer_id . "'");
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->row;
    }

    public function getCustomers($data = array()) {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

        $implode = array();

        if (isset($data['letter']) && !is_null($data['letter'])) {
            if ($data['letter'] == 1) {
                $implode[] = "(LOWER(c.firstname) LIKE 'a%' or LOWER(c.firstname) LIKE 'b%' or LOWER(c.firstname) LIKE 'c%' or LOWER(c.firstname) LIKE 'd%' or LOWER(c.firstname) LIKE 'e%')";
            }

            if ($data['letter'] == 2) {
                $implode[] = "(LOWER(c.firstname) LIKE 'f%' or LOWER(c.firstname) LIKE 'g%' or LOWER(c.firstname) LIKE 'h%' or LOWER(c.firstname) LIKE 'i%' or LOWER(c.firstname) LIKE 'j%')";
            }

            if ($data['letter'] == 3) {
                $implode[] = "(LOWER(c.firstname) LIKE 'k%' or LOWER(c.firstname) LIKE 'l%' or LOWER(c.firstname) LIKE 'm%' or LOWER(c.firstname) LIKE 'n%' or LOWER(c.firstname) LIKE 'o%')";
            }

            if ($data['letter'] == 4) {
                $implode[] = "(LOWER(c.firstname) LIKE 'p%' or LOWER(c.firstname) LIKE 'q%' or LOWER(c.firstname) LIKE 'r%' or LOWER(c.firstname) LIKE 's%' or LOWER(c.firstname) LIKE 't%')";
            }

            if ($data['letter'] == 5) {
                $implode[] = "(LOWER(c.firstname) LIKE 'u%' or LOWER(c.firstname) LIKE 'v%' or LOWER(c.firstname) LIKE 'w%' or LOWER(c.firstname) LIKE 'x%' or LOWER(c.firstname) LIKE 'y%' or LOWER(c.firstname) LIKE 'z%')";
            }
        }

        if (isset($data['privat']) && !is_null($data['privat'])) {
            $implode[] = "c.privatperson = 'on'";
        }

        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "c.email = '" . $this->db->escape($data['filter_email']) . "'";
        }

        if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
            $implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "c.status = '" . (int) $data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "c.approved = '" . (int) $data['filter_approved'] . "'";
        }

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        $sql .= ' where c.customer_group_id > 0 ';
        if ($implode) {
            $sql .= " AND " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'c.email',
            'customer_group',
            'c.status',
            'c.date_added',
            'c.customer_id'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else if (isset($data['sort']) && in_array($data['sort'], array('c.firstname', 'c.ansprechpartner'))) {
            $sql .= " ORDER BY LOWER(" . $data['sort'] . ")";
        } else {

            $sql .= " ORDER BY c.customer_id";
        }


        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        /* if (isset($data['start']) || isset($data['limit'])) {
          if ($data['start'] < 0) {
          $data['start'] = 0;
          }

          if ($data['limit'] < 1) {
          $data['limit'] = 20;
          }

          $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
          } */

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function approve($customer_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE customer_id = '" . (int) $customer_id . "'");
    }

    public function denie($customer_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '0', customer_group_id = '0', status='0' WHERE customer_id = '" . (int) $customer_id . "'");
    }

    public function getCustomersByNewsletter() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE newsletter = '1' ORDER BY firstname, lastname, email");

        return $query->rows;
    }

    public function getCustomersByKeyword($keyword) {
        if ($keyword) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LCASE(CONCAT(firstname, ' ', lastname)) LIKE '%" . $this->db->escape(strtolower($keyword)) . "%' ORDER BY firstname, lastname, email");

            return $query->rows;
        } else {
            return array();
        }
    }

    public function getCustomersByProduct($product_id) {
        if ($product_id) {
            $query = $this->db->query("SELECT DISTINCT `email` FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE op.product_id = '" . (int) $product_id . "' AND o.order_status_id <> '0'");

            return $query->rows;
        } else {
            return array();
        }
    }

    public function getAddresses($keyword) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->rows;
    }

    public function getTotalCustomers($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";

        $implode = array();

        if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
            $implode[] = "customer_group_id = '" . (int) $data['filter_customer_group_id'] . "'";
        }

        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "status = '" . (int) $data['filter_status'] . "'";
        }
        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "approved = '" . (int) $data['filter_approved'] . "'";
        }


        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }



        $sql .= ' where customer_group_id > 0 ';
        if ($implode) {
            $sql .= " AND " . implode(" AND ", $implode);
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalCustomersAwaitingApproval() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE status = '0' OR approved = '0'");

        return $query->row['total'];
    }

    public function getTotalAddressesByCustomerId($customer_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->row['total'];
    }

    public function getTotalAddressesByCountryId($country_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int) $country_id . "'");

        return $query->row['total'];
    }

    public function getTotalAddressesByZoneId($zone_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int) $zone_id . "'");

        return $query->row['total'];
    }

    public function getTotalCustomersByCustomerGroupId($customer_group_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int) $customer_group_id . "'");

        return $query->row['total'];
    }

}

?>