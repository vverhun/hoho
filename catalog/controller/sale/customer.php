<?php

class ControllerSaleCustomer extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }
        $this->load->model('sale/customer');
        $this->load->model('account/customer');
        $this->getList(1);

        $url = '';
        if (isset($this->request->get['letter'])) {
            $letter = $this->request->get['letter'];
            $url .= '&letter=' . $letter;
        }
        $privat = 0;
        if (isset($this->request->get['privat'])) {
            $privat = $this->request->get['privat'];
            $url .= '&privat=' . $privat;
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_customer_id'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.customer_id' . $url;
        $this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.firstname' . $url;
        $this->data['sort_ansprechpartner'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.ansprechpartner' . $url;
        $this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.email' . $url;
        $this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.date_added' . $url;
        $this->data['status_customer'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&sort=c.status' . $url;


        $this->template = 'default/template/sale/customer_list_offene.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function offene() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }
        $this->load->model('sale/customer');
        $this->load->model('account/customer');
        $this->getList(1);

        $url = '';
        if (isset($this->request->get['letter'])) {
            $letter = $this->request->get['letter'];
            $url .= '&letter=' . $letter;
        }
        $privat = 0;
        if (isset($this->request->get['privat'])) {
            $privat = $this->request->get['privat'];
            $url .= '&privat=' . $privat;
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        $this->data['sort_customer_id'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.customer_id' . $url;
        $this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.firstname' . $url;
        $this->data['sort_ansprechpartner'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.ansprechpartner' . $url;
        $this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.email' . $url;
        $this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&token=' . $this->session->data['token'] . '&sort=c.date_added' . $url;
        $this->data['status_customer'] = HTTPS_SERVER . 'index.php?route=sale/customer/offene&sort=c.status' . $url;




        $this->template = 'default/template/sale/customer_list_offene.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function kunden() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }
        $this->load->model('sale/customer');
        $this->load->model('account/customer');
        $this->getList(2);

        if (isset($this->request->get['letter'])) {
            $letter = $this->request->get['letter'];
            $url .= '&letter=' . $letter;
        }

        if (isset($this->request->get['privat'])) {
            $privat = $this->request->get['privat'];
            $url .= '&privat=' . $privat;
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        $this->data['sort_customer_id'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&token=' . $this->session->data['token'] . '&sort=c.customer_id' . $url;
        $this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&token=' . $this->session->data['token'] . '&sort=c.firstname' . $url;
        $this->data['sort_ansprechpartner'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&token=' . $this->session->data['token'] . '&sort=c.ansprechpartner' . $url;
        $this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&token=' . $this->session->data['token'] . '&sort=c.email' . $url;
        $this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&token=' . $this->session->data['token'] . '&sort=c.date_added' . $url;
        $this->data['status_customer'] = HTTPS_SERVER . 'index.php?route=sale/customer/kunden&sort=c.status' . $url;




        $this->template = 'default/template/sale/customer_list_kunden.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function insert() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_customer->addCustomer($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . $this->request->get['filter_email'];
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->redirect(HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url);
        }

        $this->getForm();
    }

    public function update() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_customer->editCustomer($this->request->get['customer_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . $this->request->get['filter_email'];
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->redirect(HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url);
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('sale/customer');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('sale/customer');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $customer_id) {
                $this->model_sale_customer->deleteCustomer($customer_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . $this->request->get['filter_email'];
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->redirect(HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url);
        }

        $this->getList();
    }

    private function getList($type) {


        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['letter'])) {
            $letter = $this->request->get['letter'];
        }
        if (isset($this->request->get['privat'])) {
            $privat = $this->request->get['privat'];
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;
        $this->data['letter'] = $letter;

        $this->data['privat'] = $privat;


        $this->data['approve'] = HTTPS_SERVER . 'index.php?route=sale/customer/approve&token=' . $this->session->data['token'] . $url;
        $this->data['insert'] = HTTPS_SERVER . 'index.php?route=sale/customer/insert&token=' . $this->session->data['token'] . $url;
        $this->data['delete'] = HTTPS_SERVER . 'index.php?route=sale/customer/delete&token=' . $this->session->data['token'] . $url;


        //get not approved customers

        $this->data['customers'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_email' => $filter_email,
            'filter_customer_group_id' => $filter_customer_group_id,
            'filter_status' => $filter_status,
            'filter_approved' => '0',
            'filter_date_added' => $filter_date_added,
            'sort' => $sort,
            'letter' => $letter,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $customer_total = $this->model_sale_customer->getTotalCustomers($data);
        $this->data['customer_total'] = $customer_total;
        if ($type == 1) {
            $results = $this->model_sale_customer->getCustomers($data);

            foreach ($results as $result) {
                $action = array();


                $address = $this->model_sale_customer->getAddressesByCustomerId($result['customer_id']);
                $bill_info = $this->model_account_customer->getBill($result['customer_id']);


                $this->data['customers'][] = array(
                    'customer_id' => $result['customer_id'],
                    'firstname' => $result['firstname'],
                    'email' => $result['email'],
                    'bill_address' => $bill_info['bill_address'],
                    'bill_address_1' => $bill_info['bill_address_1'],
                    'bill_postcode' => $bill_info['bill_postcode'],
                    'bill_city' => $bill_info['bill_city'],
                    'bill_land' => $bill_info['bill_land'],
                    'username' => $result['username'],
                    'postcode' => $address[0]['postcode'],
                    'position' => $result['position'],
                    'telephone' => $result['telephone'],
                    'mobile' => $result['mobile'],
                    'fax' => $result['fax'],
                    'email' => $result['email'],
                    'address_1' => $address[0]['address_1'],
                    'country' => $address[0]['country_id'],
                    'taxid_number' => $result['taxid_number'],
                    'city' => $address[0]['city'],
                    'customer_group' => $result['customer_group'],
                    'ansprechpartner' => $result['ansprechpartner'],
                    'downloadedfile' => $result['downloadedfile'],
                    'status' => $result['approved'],
                    'approved' => ($result['approved'] ? '<span style="color:green;">angelegt</span>' : '<span style="color:red;">in Arbeit</span>'),
                    'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                    'selected' => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
                    'action' => $action
                );
            }
        }
        //get   approved customers
        $this->data['customers2'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_email' => $filter_email,
            'filter_customer_group_id' => $filter_customer_group_id,
            'filter_status' => $filter_status,
            'filter_approved' => '1',
            'filter_date_added' => $filter_date_added,
            'sort' => $sort,
            'letter' => $letter,
            'privat' => $privat,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $customer_total2 = $this->model_sale_customer->getTotalCustomers($data);
        $this->data['customer_total2'] = $customer_total2;
        if ($type == 2) {
            $results = $this->model_sale_customer->getCustomers($data);

            foreach ($results as $result) {
                $action = array();


                $address = $this->model_sale_customer->getAddressesByCustomerId($result['customer_id']);
                $bill_info = $this->model_account_customer->getBill($result['customer_id']);

                $this->data['customers2'][] = array(
                    'customer_id' => $result['customer_id'],
                    'firstname' => $result['firstname'],
                    'email' => $result['email'],
                    'bill_address' => $bill_info['bill_address'],
                    'bill_address_1' => $bill_info['bill_address_1'],
                    'bill_postcode' => $bill_info['bill_postcode'],
                    'bill_city' => $bill_info['bill_city'],
                    'bill_land' => $bill_info['bill_land'],
                    'username' => $result['username'],
                    'postcode' => $address[0]['postcode'],
                    'position' => $result['position'],
                    'telephone' => $result['telephone'],
                    'mobile' => $result['mobile'],
                    'fax' => $result['fax'],
                    'email' => $result['email'],
                    'address_1' => $address[0]['address_1'],
                    'country' => $address[0]['country_id'],
                    'taxid_number' => $result['taxid_number'],
                    'city' => $address[0]['city'],
                    'customer_group' => $result['customer_group'],
                    'ansprechpartner' => $result['ansprechpartner'],
                    'downloadedfile' => $result['downloadedfile'],
                    'status' => $result['approved'],
                    'approved' => ($result['approved'] ? '<span style="color:green;">angelegt</span>' : '<span style="color:red;">in Arbeit</span>'),
                    'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                    'selected' => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
                    'action' => $action
                );
            }
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_email'] = $this->language->get('column_email');
        $this->data['column_customer_group'] = $this->language->get('column_customer_group');
        $this->data['column_status'] = $this->language->get('column_status');
        $this->data['column_approved'] = $this->language->get('column_approved');
        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_approve'] = $this->language->get('button_approve');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->session->data['error'])) {
            $this->data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
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

        $url = '';



        $pagination = new Pagination();
        $pagination->total = $customer_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_email'] = $filter_email;
        $this->data['filter_customer_group_id'] = $filter_customer_group_id;
        $this->data['filter_status'] = $filter_status;
        $this->data['filter_approved'] = $filter_approved;
        $this->data['filter_date_added'] = $filter_date_added;

        $this->load->model('sale/customer_group');

        $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;
        $this->data['type'] = $type;
    }

    private function getForm() {
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_select'] = $this->language->get('text_select');

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_fax'] = $this->language->get('entry_fax');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['entry_confirm'] = $this->language->get('entry_confirm');
        $this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_company'] = $this->language->get('entry_company');
        $this->data['entry_address_1'] = $this->language->get('entry_address_1');
        $this->data['entry_address_2'] = $this->language->get('entry_address_2');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_postcode'] = $this->language->get('entry_postcode');
        $this->data['entry_zone'] = $this->language->get('entry_zone');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_default'] = $this->language->get('entry_default');
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_address'] = $this->language->get('entry_address');
        $this->data['entry_city_postcode'] = $this->language->get('entry_city_postcode');
        $this->data['entry_country_zone'] = $this->language->get('entry_country_zone');
        $this->data['entry_default'] = $this->language->get('entry_default');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add'] = $this->language->get('button_add');
        $this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_address'] = $this->language->get('tab_address');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }

        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }

        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }

        if (isset($this->error['telephone'])) {
            $this->data['error_telephone'] = $this->error['telephone'];
        } else {
            $this->data['error_telephone'] = '';
        }

        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }

        if (isset($this->error['confirm'])) {
            $this->data['error_confirm'] = $this->error['confirm'];
        } else {
            $this->data['error_confirm'] = '';
        }

        if (isset($this->error['address_firstname'])) {
            $this->data['error_address_firstname'] = $this->error['address_firstname'];
        } else {
            $this->data['error_address_firstname'] = '';
        }

        if (isset($this->error['address_lastname'])) {
            $this->data['error_address_lastname'] = $this->error['address_lastname'];
        } else {
            $this->data['error_address_lastname'] = '';
        }

        if (isset($this->error['address_1'])) {
            $this->data['error_address_1'] = $this->error['address_1'];
        } else {
            $this->data['error_address_1'] = '';
        }

        if (isset($this->error['city'])) {
            $this->data['error_city'] = $this->error['city'];
        } else {
            $this->data['error_city'] = '';
        }

        if (isset($this->error['postcode'])) {
            $this->data['error_postcode'] = $this->error['postcode'];
        } else {
            $this->data['error_postcode'] = '';
        }

        if (isset($this->error['address_country'])) {
            $this->data['error_country'] = $this->error['country'];
        } else {
            $this->data['error_country'] = '';
        }

        if (isset($this->error['address_zone'])) {
            $this->data['error_zone'] = $this->error['zone'];
        } else {
            $this->data['error_zone'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['customer_id'])) {
            $this->data['action'] = HTTPS_SERVER . 'index.php?route=sale/customer/insert&token=' . $this->session->data['token'] . $url;
        } else {
            $this->data['action'] = HTTPS_SERVER . 'index.php?route=sale/customer/update&token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url;
        }

        $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url;

        if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $customer_info = $this->model_sale_customer->getCustomer($this->request->get['customer_id']);
        }

        if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
        } elseif (isset($customer_info)) {
            $this->data['firstname'] = $customer_info['firstname'];
        } else {
            $this->data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } elseif (isset($customer_info)) {
            $this->data['lastname'] = $customer_info['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } elseif (isset($customer_info)) {
            $this->data['email'] = $customer_info['email'];
        } else {
            $this->data['email'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
        } elseif (isset($customer_info)) {
            $this->data['telephone'] = $customer_info['telephone'];
        } else {
            $this->data['telephone'] = '';
        }

        if (isset($this->request->post['fax'])) {
            $this->data['fax'] = $this->request->post['fax'];
        } elseif (isset($customer_info)) {
            $this->data['fax'] = $customer_info['fax'];
        } else {
            $this->data['fax'] = '';
        }

        if (isset($this->request->post['newsletter'])) {
            $this->data['newsletter'] = $this->request->post['newsletter'];
        } elseif (isset($customer_info)) {
            $this->data['newsletter'] = $customer_info['newsletter'];
        } else {
            $this->data['newsletter'] = '';
        }

        $this->load->model('sale/customer_group');

        $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

        if (isset($this->request->post['customer_group_id'])) {
            $this->data['customer_group_id'] = $this->request->post['customer_group_id'];
        } elseif (isset($customer_info)) {
            $this->data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
        }

        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (isset($customer_info)) {
            $this->data['status'] = $customer_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        if (isset($this->request->post['password'])) {
            $this->data['password'] = $this->request->post['password'];
        } else {
            $this->data['password'] = '';
        }

        if (isset($this->request->post['confirm'])) {
            $this->data['confirm'] = $this->request->post['confirm'];
        } else {
            $this->data['confirm'] = '';
        }

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        if (isset($this->request->post['addresses'])) {
            $this->data['addresses'] = $this->request->post['addresses'];
        } elseif (isset($this->request->get['customer_id'])) {
            $this->data['addresses'] = $this->model_sale_customer->getAddressesByCustomerId($this->request->get['customer_id']);
        } else {
            $this->data['addresses'] = array();
        }

        $this->template = 'default/template/sale/customer_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    public function zone() {
        $output = '';

        $this->load->model('localisation/zone');

        $results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);

        foreach ($results as $result) {
            $output .= '<option value="' . $result['zone_id'] . '"';

            if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
                $output .= ' selected="selected"';
            }

            $output .= '>' . $result['name'] . '</option>';
        }

        if (!$results) {
            $output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
        }

        $this->response->setOutput($output, $this->config->get('config_compression'));
    }

    public function approve() {
        $this->load->language('sale/customer');
        $this->load->language('mail/customer');
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }
        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->session->data['error'] = $this->language->get('error_permission');
        } else {
            if (isset($this->request->post['selected'])) {
                $this->load->model('sale/customer');

                foreach ($this->request->post['selected'] as $customer_id) {
                    $customer_info = $this->model_sale_customer->getCustomer($customer_id);

                    if ($customer_info && !$customer_info['approved']) {
                        $this->model_sale_customer->approve($customer_id);

                        $this->load->model('setting/store');

                        $store_info = $this->model_setting_store->getStore($customer_info['store_id']);

                        if ($store_info) {
                            $store_name = $store_info['name'];
                            $store_url = $store_info['url'] . 'index.php?route=account/login';
                        } else {
                            $store_name = $this->config->get('config_name');
                            $store_url = $this->config->get('config_url') . 'index.php?route=account/login';
                        }


                        $message = sprintf($this->language->get('text_email'), $customer_info['username']);



                        $mail = new Mail();
                        $mail->protocol = $this->config->get('config_mail_protocol');
                        $mail->parameter = $this->config->get('config_mail_parameter');
                        $mail->hostname = $this->config->get('config_smtp_host');
                        $mail->username = $this->config->get('config_smtp_username');
                        $mail->password = $this->config->get('config_smtp_password');
                        $mail->port = $this->config->get('config_smtp_port');
                        $mail->timeout = $this->config->get('config_smtp_timeout');
                        $mail->setTo($customer_info['email']);
                        $mail->setFrom($this->config->get('config_email'));
                        $mail->setSender($this->config->get('config_name'));
                        $mail->setSubject($this->language->get('text_subject'));
                        $mail->setHtml($message . $this->language->get('text_footer_email'), ENT_QUOTES, 'UTF-8');
                        @$mail->send();

                        $this->session->data['success'] = sprintf($this->language->get('text_approved'), $customer_info['firstname'] . ' ' . $customer_info['lastname']);
                    }
                }
            }
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . $this->request->get['filter_email'];
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->redirect(HTTPS_SERVER . 'index.php?route=sale/customer&token=' . $this->session->data['token'] . $url);
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((strlen(utf8_decode($this->request->post['firstname'])) < 1) || (strlen(utf8_decode($this->request->post['firstname'])) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }

        if ((strlen(utf8_decode($this->request->post['lastname'])) < 1) || (strlen(utf8_decode($this->request->post['lastname'])) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }

        if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match(EMAIL_PATTERN, $this->request->post['email']))) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if ((strlen(utf8_decode($this->request->post['telephone'])) < 3) || (strlen(utf8_decode($this->request->post['telephone'])) > 32)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        if (($this->request->post['password']) || (!isset($this->request->get['customer_id']))) {
            if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
                $this->error['password'] = $this->language->get('error_password');
            }

            if ($this->request->post['password'] != $this->request->post['confirm']) {
                $this->error['confirm'] = $this->language->get('error_confirm');
            }
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function akzept() {
        $this->load->model('sale/customer');
        $this->load->model('account/customer');
        $customer_id = $this->request->get['customer_id'];
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }
        $this->model_sale_customer->approve($customer_id);

        $this->load->language('sale/customer');
        $this->load->language('mail/customer');


        $this->load->model('sale/customer');


        $customer_info = $this->model_sale_customer->getCustomer($customer_id);

        $country = $this->model_account_customer->getCustomerCountry($customer_id);
        $lang = $customer_info['lang'];


        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        if ($lang == 'de-DE') {
            $message = sprintf($this->language->get('text_email'), $customer_info['username']);
            $mail->setTo($customer_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($this->language->get('text_subject_sale'));
            $mail->setHtml($message . $this->language->get('text_footer_email'), ENT_QUOTES, 'UTF-8');
        } else {
            $message = sprintf($this->language->get('text_email_en'), $customer_info['username']);

            $mail->setTo($customer_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($this->language->get('text_subject_sale_en'));
            $mail->setHtml($message . $this->language->get('text_footer_email_en'), ENT_QUOTES, 'UTF-8');
        }





        @$mail->send();



        $this->index();
    }

    public function ablehnen() {
        $this->load->model('sale/customer');
        if (!$this->user->isLogged()) {
            $this->error['warning'] = $this->language->get('error_permission');
            $this->redirect(HTTPS_SERVER . 'index.php?route=account/login');
            return FALSE;
            die();
        }

        $this->load->model('sale/customer');
        $this->load->language('sale/customer');
        $this->load->language('mail/customer');

        $customer_id = $this->request->get['customer_id'];
        $customer_info = $this->model_sale_customer->getCustomer($customer_id);





        $lang = $customer_info['lang'];

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');

        if ($lang == 'de-DE') {
            $message = sprintf($this->language->get('text_email_ablehnen'), $customer_info['username']);
            $mail->setTo($customer_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($this->language->get('text_subject_sale_ablehnen'));
            $mail->setHtml($message . $this->language->get('text_footer_email'), ENT_QUOTES, 'UTF-8');
        } else {
            $message = sprintf($this->language->get('text_email_en_ablehnen'), $customer_info['username']);

            $mail->setTo($customer_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($this->config->get('config_name'));
            $mail->setSubject($this->language->get('text_subject_sale_en_ablehnen'));
            $mail->setHtml($message . $this->language->get('text_footer_email_en'), ENT_QUOTES, 'UTF-8');
        }
        @$mail->send();

        $this->model_sale_customer->deleteCustomer($customer_id);

        $this->index();
    }

}

?>
