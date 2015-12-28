<?php

class ModelSaleOrder extends Model {

    public function deleteOrder($order_id) {

        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {
            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

            foreach ($order_product_query->rows as $order_product) {

                $product_query = $this->db->query("SELECT subtract FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $order_product['product_id'] . "'");

                foreach ($product_query->rows as $product) {

                    if ($product['subtract']) {
                        $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int) $order_product['quantity'] . ") WHERE product_id = '" . (int) $order_product['product_id'] . "'");

                        $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . (int) $order_product['order_product_id'] . "'");

                        foreach ($option_query->rows as $option) {
                            $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int) $order_product['quantity'] . ") WHERE product_option_value_id = '" . (int) $option['product_option_value_id'] . "' AND subtract = '1'");
                        }
                    }
                }
            }
        }


        $this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "'");
    }

    public function addProduct($order_id, $data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', product_id = '" . (int) $data['product_id'] . "', name = '" . $this->db->escape($data['name']) . "', model = '" . $this->db->escape($data['model']) . "', price = '" . (float) $data['price'] . "', total = '" . (float) $data['total'] . "', tax = '" . (float) $data['tax']['rate'] . "', quantity = '" . (int) $data['quantity'] . "'");

        $order_product_id = $this->db->getLastId();

        foreach ($data['options'] as $option) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int) $order_id . "', order_product_id = '" . (int) $order_product_id . "', product_option_value_id = '" . (int) $option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', value = '" . $this->db->escape($option['value']) . "', price = '" . (float) $option['price'] . "', prefix = '" . $this->db->escape($option['prefix']) . "'");
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . (float) $data['new_grand_total'] . "' WHERE order_id = '" . (int) $order_id . "'");

        $totals = $this->getOrderTotals($order_id);

        $subtotal = reset($totals); //Assume first total is subtotal

        $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($data['formatted_order_total']) . "', value = '" . (float) $data['order_total'] . "' WHERE order_id = '" . (int) $order_id . "' AND order_total_id = '" . $subtotal['order_total_id'] . "'");

        $total = end($totals); //Assume last total is grand total

        $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($data['formatted_grand_total']) . "', value = '" . (float) $data['new_grand_total'] . "' WHERE order_id = '" . (int) $order_id . "' AND order_total_id = '" . $total['order_total_id'] . "'");

        // TU START
        $query = $this->db->query("SELECT order_total_id, value FROM " . DB_PREFIX . "order_total WHERE sort_order = '" . (int) $data['tax']['sort_order'] . "' AND order_id = '" . (int) $order_id . "' LIMIT 1");
        $tax_value = $query->row;

        if ($tax_value) {
            $new_value = $tax_value['value'] + ($data['tax']['rate'] / 100) * $data['price'] * $data['quantity'];
            $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($this->currency->format($new_value, $data['currency'], $data['currency_value'], true)) . "', value = '" . (float) $this->currency->format($new_value, $data['currency'], $data['currency_value'], false) . "' WHERE order_total_id = '" . $tax_value['order_total_id'] . "'");
        } else {
            $new_value = ($data['tax']['rate'] / 100) * $data['price'] * $data['quantity'];
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_total (order_id, title, text, value, sort_order) VALUES ('" . (int) $order_id . "', '" . $this->db->escape($data['tax']['description'] . ':') . "', '" . $this->db->escape($this->currency->format($new_value, $data['currency'], $data['currency_value'], true)) . "', '" . (float) $this->currency->format($new_value, $data['currency'], $data['currency_value'], false) . "', '" . (int) $data['tax']['sort_order'] . "')");
        } // TU END

        return $order_product_id;
    }

    public function removeProduct($order_id, $data) {
        // TU START
        $query = $this->db->query("SELECT product_id, price, quantity FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . (int) $data['order_product_id'] . "'");
        $order_info = $query->row;

        $tax = $this->getOrderTax($order_info['product_id'], $order_id);

        $query = $this->db->query("SELECT order_total_id, value FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' AND sort_order = '" . (int) $tax['sort_order'] . "'");
        $info = $query->row;

        $new_value = $info['value'] - ($order_info['price'] * $order_info['quantity'] * $tax['rate'] / 100);
        $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($this->currency->format($new_value, $data['currency'], $data['currency_value'], true)) . "', value = '" . (float) $this->currency->format($new_value, $data['currency'], $data['currency_value'], false) . "' WHERE order_total_id = '" . $info['order_total_id'] . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' AND value = 0");
        // TU END

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET total = '" . (float) $data['new_grand_total'] . "' WHERE order_id = '" . (int) $order_id . "'");

        $totals = $this->getOrderTotals($order_id);

        $subtotal = reset($totals); //Assume first total is subtotal

        $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($data['formatted_order_total']) . "', value = '" . (float) $data['order_total'] . "' WHERE order_id = '" . (int) $order_id . "' AND order_total_id = '" . $subtotal['order_total_id'] . "'");

        $total = end($totals);

        $this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($data['formatted_grand_total']) . "', value = '" . (float) $data['new_grand_total'] . "' WHERE order_id = '" . (int) $order_id . "' AND order_total_id = '" . $total['order_total_id'] . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "' AND  order_product_id = '" . (int) $data['order_product_id'] . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "' AND  order_product_id = '" . (int) $data['order_product_id'] . "'");
    }

    public function updateShippingAddress($order_id, $data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int) $data['shipping_zone_id'] . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int) $data['shipping_country_id'] . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");
    }

    public function updatePaymentAddress($order_id, $data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int) $data['payment_zone_id'] . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int) $data['payment_country_id'] . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");
    }

    public function addOrderHistory($order_id, $data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");

        if ($data['append']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int) $order_id . "', order_status_id = '" . (int) $data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int) $data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");
        }

        if ($data['notify']) {
            $order_query = $this->db->query("SELECT *, os.name AS status FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id AND os.language_id = o.language_id) LEFT JOIN " . DB_PREFIX . "language l ON (o.language_id = l.language_id) WHERE o.order_id = '" . (int) $order_id . "'");

            if ($order_query->num_rows) {
                $language = new Language($order_query->row['directory']);
                $language->load($order_query->row['filename']);
                $language->load('mail/order');

                $this->load->model('setting/store');

                $subject = sprintf($language->get('text_subject'), $order_query->row['store_name'], $order_id);

                $message = $language->get('text_order') . ' ' . $order_id . "\n";
                $message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_query->row['date_added'])) . "\n\n";
                $message .= $language->get('text_order_status') . "\n\n";
                $message .= $order_query->row['status'] . "\n\n";
                $message .= $language->get('text_invoice') . "\n";
                $message .= html_entity_decode($order_query->row['store_url'] . 'index.php?route=account/invoice&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";

                if ($data['comment']) {
                    $message .= $language->get('text_comment') . "\n\n";
                    $message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
                }

                $message .= $language->get('text_footer');

                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo($order_query->row['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($order_query->row['store_name']);
                $mail->setSubject($subject);
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();
            }
        }
    }

    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {
            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['payment_country_id'] . "'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['payment_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $order_data = array(
                'order_id' => $order_query->row['order_id'],
                'invoice_id' => $order_query->row['invoice_id'],
                'invoice_prefix' => $order_query->row['invoice_prefix'],
                'store_id' => $order_query->row['store_id'],
                'store_name' => $order_query->row['store_name'],
                'subtotal' => $order_query->row['subtotal'],
                'tax' => $order_query->row['tax'],
                'total' => $order_query->row['total'],
                'store_url' => $order_query->row['store_url'],
                'customer_id' => $order_query->row['customer_id'],
                'customer_group_id' => $order_query->row['customer_group_id'],
                'firstname' => $order_query->row['firstname'],
                'lastname' => $order_query->row['lastname'],
                'telephone' => $order_query->row['telephone'],
                'fax' => $order_query->row['fax'],
                'email' => $order_query->row['email'],
                'shipping_firstname' => $order_query->row['shipping_firstname'],
                'shipping_lastname' => $order_query->row['shipping_lastname'],
                'shipping_company' => $order_query->row['shipping_company'],
                'shipping_address_1' => $order_query->row['shipping_address_1'],
                'shipping_address_2' => $order_query->row['shipping_address_2'],
                'shipping_postcode' => $order_query->row['shipping_postcode'],
                'shipping_city' => $order_query->row['shipping_city'],
                'shipping_zone_id' => $order_query->row['shipping_zone_id'],
                'shipping_zone' => $order_query->row['shipping_zone'],
                'shipping_zone_code' => $shipping_zone_code,
                'shipping_country_id' => $order_query->row['shipping_country_id'],
                'shipping_country' => $order_query->row['shipping_country'],
                'shipping_iso_code_2' => $shipping_iso_code_2,
                'shipping_iso_code_3' => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_method' => $order_query->row['shipping_method'],
                'payment_firstname' => $order_query->row['payment_firstname'],
                'payment_lastname' => $order_query->row['payment_lastname'],
                'payment_company' => $order_query->row['payment_company'],
                'payment_address_1' => $order_query->row['payment_address_1'],
                'payment_address_2' => $order_query->row['payment_address_2'],
                'payment_postcode' => $order_query->row['payment_postcode'],
                'payment_city' => $order_query->row['payment_city'],
                'payment_zone_id' => $order_query->row['payment_zone_id'],
                'payment_zone' => $order_query->row['payment_zone'],
                'payment_zone_code' => $payment_zone_code,
                'payment_country_id' => $order_query->row['payment_country_id'],
                'payment_country' => $order_query->row['payment_country'],
                'payment_iso_code_2' => $payment_iso_code_2,
                'payment_iso_code_3' => $payment_iso_code_3,
                'payment_address_format' => $order_query->row['payment_address_format'],
                'payment_method' => $order_query->row['payment_method'],
                'comment' => $order_query->row['comment'],
                'order_status_id' => $order_query->row['order_status_id'],
                'language_id' => $order_query->row['language_id'],
                'currency_id' => $order_query->row['currency_id'],
                'currency' => $order_query->row['currency'],
                'value' => $order_query->row['value'],
                'coupon_id' => $order_query->row['coupon_id'],
                'date_modified' => $order_query->row['date_modified'],
                'date_added' => $order_query->row['date_added'],
                'ip' => $order_query->row['ip']
            );

            return $order_data;
        } else {
            return FALSE;
        }
    }

    public function getOrders($data = array()) {
        $sql = "SELECT o.order_id, c.ansprechpartner, lower(CONCAT( c.firstname )) AS firstname,  o.order_status_id AS status, o.date_added, IF( ( o.order_status_id = 1 ), '0000-00-00', o.date_modified  ) as date_modified  , o.customer_id, o.total,  o.subtotal,  o.tax, o.currency, o.value, count(p.order_product_id) as totalproducts FROM  " . DB_PREFIX . "order  o, richterorder_product p, richtercustomer c ";


        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql .= " WHERE order_status_id   IN (" . $data['filter_order_status_id'] . ")";
        } else {
            $sql .= " WHERE o.order_status_id > '0'";
        }

        if (isset($data['filter_order_id']) && !is_null($data['filter_order_id'])) {
            $sql .= " AND o.order_id = '" . (int) $data['filter_order_id'] . "'";
        }

        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (isset($data['filter_total']) && !is_null($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float) $data['filter_total'] . "'";
        }
        if ( !is_null($data['year']) ) {

            $sql .= " AND YEAR(o.date_modified) = '" . $data['year'] . "'";
        }

        if (!is_null($data['quater'])) {
            if ($data['quater'] == 1) {
                $sql .= " AND month(o.date_modified) between 1 and 3";
            }
            if ($data['quater'] == 2) {
                $sql .= " AND month(o.date_modified) between 4 and 6";
            }

            if ($data['quater'] == 3) {
                $sql .= " AND month(o.date_modified) between 7 and 9";
            }

            if ($data['quater'] == 4) {
                $sql .= " AND month(o.date_modified) between 10 and 12";
            }
        }

        $sql .= " AND o.order_id = p.order_id and c.customer_id =  o.customer_id group by p.order_id ";

        $sort_data = array(
            'o.order_id',
            'c.ansprechpartner',
            'o.order_status_id',
            'o.date_added',
            'o.date_modified'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY lower(" . $data['sort'] . ")";
        } else if ($data['sort'] == 'date_modified') {
            $sql .= " ORDER BY " . $data['sort'];
        } else if ($data['sort'] == 'totalproducts') {
            $sql .= " ORDER BY " . $data['sort'];
        } else if ($data['sort'] == 'firstname') {
            $sql .= " ORDER BY " . $data['sort'];
        } else if ($data['sort'] == 'o.invoice') {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.date_modified";
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

    public function generateInvoiceId($order_id) {
        $query = $this->db->query("SELECT MAX(invoice_id) AS invoice_id FROM `" . DB_PREFIX . "order`");

        if ($query->row['invoice_id']) {
            $invoice_id = (int) $query->row['invoice_id'] + 1;
        } elseif ($this->config->get('config_invoice_id')) {
            $invoice_id = $this->config->get('config_invoice_id');
        } else {
            $invoice_id = 1;
        }

        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_id = '" . (int) $invoice_id . "', invoice_prefix = '" . $this->db->escape($this->config->get('config_invoice_prefix')) . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");

        return $this->config->get('config_invoice_prefix') . $invoice_id;
    }

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    public function getOrderOptions($order_id, $order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . (int) $order_product_id . "'");

        return $query->rows;
    }

    public function getOrderTotals($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' ORDER BY sort_order");

        return $query->rows;
    }

    public function getOrderHistory($order_id) {
        $query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int) $order_id . "' AND os.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY oh.date_added");

        return $query->rows;
    }

    public function getOrderDownloads($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int) $order_id . "' ORDER BY name");

        return $query->rows;
    }

    public function getOrderTax($product_id, $order_id) { // TU
        $query = $this->db->query("SELECT tr.rate AS rate, tr.description, tr.priority FROM " . DB_PREFIX . "tax_rate tr LEFT JOIN " . DB_PREFIX . "zone_to_geo_zone z2gz ON (tr.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN " . DB_PREFIX . "geo_zone gz ON (tr.geo_zone_id = gz.geo_zone_id) WHERE (z2gz.country_id = '0' OR z2gz.country_id = (SELECT payment_country_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "')) AND (z2gz.zone_id = '0' OR z2gz.zone_id = (SELECT payment_zone_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "')) AND tr.tax_class_id = (SELECT tax_class_id FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "')");

        $tax = array();

        $tax = $query->row;

        if (!isset($tax['rate'])) {
            $tax['rate'] = 0;
        }

        $tax['sort_order'] = $this->config->get('tax_sort_order');

        return $tax;
    }

    public function getTotalOrders($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

        if (isset($data['filter_order_status_id']) && !is_null($data['filter_order_status_id'])) {
            $sql .= " WHERE order_status_id   IN (" . $data['filter_order_status_id'] . ")";
        } else {
            $sql .= " WHERE order_status_id > '0'";
        }


        if (isset($data['filter_order_id']) && !is_null($data['filter_order_id'])) {
            $sql .= " AND order_id = '" . (int) $data['filter_order_id'] . "'";
        }



        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (isset($data['filter_total']) && !is_null($data['filter_total'])) {
            $sql .= " AND total = '" . (float) $data['filter_total'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalOrdersByStoreId($store_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int) $store_id . "'");

        return $query->row['total'];
    }

    public function getOrderHistoryTotalByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT oh.order_id FROM " . DB_PREFIX . "order_history oh LEFT JOIN `" . DB_PREFIX . "order` o ON (oh.order_id = o.order_id) WHERE oh.order_status_id = '" . (int) $order_status_id . "' AND o.order_status_id > '0' GROUP BY order_id");

        return $query->num_rows;
    }

    public function getTotalOrdersByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int) $order_status_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByLanguageId($language_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int) $language_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByCurrencyId($currency_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int) $currency_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalSales() {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalSalesByYear($year) {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . (int) $year . "'");

        return $query->row['total'];
    }

    // TU START
    public function getProductPrice($order_id, $product_id, $quantity, $default_price) {
        $query = $this->db->query("SELECT customer_group_id FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");
        $group = $query->row['customer_group_id'];

        $date = date('Y-m-d');

        $query = $this->db->query("SELECT price FROM `" . DB_PREFIX . "product_discount` WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $group . "' AND quantity <= '" . (int) $quantity . "' AND '" . $date . "' BETWEEN date_start AND date_end ORDER BY priority ASC LIMIT 1");
        if (!empty($query->row)) {
            return $query->row['price'];
        }

        $query = $this->db->query("SELECT price FROM `" . DB_PREFIX . "product_special` WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $group . "' AND '" . $date . "' BETWEEN date_start AND date_end ORDER BY priority ASC LIMIT 1");
        if (!empty($query->row)) {
            return $query->row['price'];
        }

        return $default_price;
    }

    public function updateProductPrices($price, $tax, $total, $product_id, $order_id, $pricediscount, $taxdiscount) {
        $this->db->query("UPDATE richterorder_product SET price = " . $price . " ,tax = " . $tax . ",total = " . $total . ",pricediscount = " . $pricediscount . ",taxdiscount = " . $taxdiscount . "  WHERE product_id = '" . $product_id . "' and order_id = '" . $order_id . "'");
    }

    public function updateProductStatus($status, $product_id, $order_id) {
        $this->db->query("UPDATE richterorder_product SET status_id = " . $status . "  WHERE product_id = '" . $product_id . "' and order_id = '" . $order_id . "'");
    }

    public function updateTotalPrice($price, $subtotal, $tax, $order_id) {
        $this->db->query("UPDATE richterorder SET total = " . $price . ", subtotal = " . $subtotal . ", tax = " . $tax . "   WHERE order_id = '" . $order_id . "'");
    }

    public function updateOrderStatus($status, $order_id) {
        $this->db->query("UPDATE richterorder SET  date_modified = NOW(), order_status_id = " . $status . "   WHERE order_id = '" . $order_id . "'");

        if (intval($status) == 5) {
            $query = $this->db->query("SELECT  max(invoice) as invoice FROM `" . DB_PREFIX . "order` WHERE order_status_id = 5");
            $invoice = $query->row['invoice'];
            $invoice = $invoice + 1;

            $query = $this->db->query("SELECT  invoice as invoice FROM `" . DB_PREFIX . "order` WHERE order_id = '" . $order_id . "'");
            $invoice_check = $query->row['invoice'];

            if (intval($invoice_check) == 0 || intval($invoice_check) == 1) {
                $this->db->query("UPDATE richterorder SET  invoice =  " . $invoice . "   WHERE order_id = '" . $order_id . "'");
            }
        }
    }

    public function getPaidOrderNumber($order_id, $date_modified) {
        $query = $this->db->query("SELECT  invoice as invoice FROM `" . DB_PREFIX . "order` WHERE order_id = '" . $order_id . "'");
        return $query->row['invoice'];
    }

}

?>
