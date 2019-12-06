<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Country extends MX_Controller {

    public function __construct() {
        $this->load->model('country_model');
        $this->load->library('form_validation');
        $this->load->library("pagination");
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'country/page');
    }

    /////////////// Menu Add /////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['left'] = "inc/section_left";


        if ($this->input->post()) {
            $config['upload_path'] = '../assets/country_flag_logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
            $this->load->library('upload', $config);

            $uploaded = $this->upload->do_upload();
            $upload_data = $this->upload->data();
            //echo "<pre>";
           // print_r($upload_data);die;
            $image = $upload_data['file_name'];

            if (!$uploaded AND $image != '') {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_msg', $error['error']);
                redirect(base_url() . 'country/add');
            }
            $this->form_validation->set_rules('c_name', 'Country Name', 'required|xss_clean|max_length[70]|is_unique[countries.c_name]');
            $this->form_validation->set_rules('domain', 'Url', 'required|xss_clean|max_length[500]');
            $this->form_validation->set_rules('c_code', 'Code', 'required|xss_clean|max_length[5]|is_unique[countries.c_code]');
            $this->form_validation->set_rules('order_id', 'lang:Order', 'required|numeric|greater_than[0.99]');
            $this->form_validation->set_rules('lat', 'Latitude', 'required|numeric');
            $this->form_validation->set_rules('lng', 'Longitude', 'required|numeric');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                //$post_data = $this->input->post();
                $post_data['flag_logo'] = $image;
                $post_data['c_name'] = $this->input->post('c_name');
                $post_data['domain'] = $this->input->post('domain');
                $post_data['c_code'] = $this->input->post('c_code');
                $post_data['lat'] = $this->input->post('lat');
                $post_data['lng'] = $this->input->post('lng');
                $post_data['order_id'] = $this->input->post('order_id');
                $post_data['status'] = $this->input->post('status');
                //echo "<pre>";
               //print_r($post_data);die;
                $insert_country = $this->country_model->add_countrymenu($post_data);
                //  echo $this->db->last_query();die;
                if ($insert_country) {
                    $this->session->set_flashdata('succ_msg', 'Country Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'country/page');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    //////////////edit country menu////////////////////
    public function edit() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        $id = $this->uri->segment(3);
        if ($id == '') {
            $id = set_value('id');
        }

        if ($this->input->post()) {
            $image = '';
            $config['upload_path'] = '../assets/country_flag_logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $this->load->library('upload', $config);
            $uploaded = $this->upload->do_upload();
            $upload_data = $this->upload->data();
         //  echo "<pre>";
         // print_r($upload_data);die;
            $image = $upload_data['file_name'];

            if (!$uploaded AND $image != '') {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_msg', $error['error']);
                redirect(base_url() . 'country/edit/' . $id);
            }

            $this->form_validation->set_rules('c_name', 'Country Name', 'required');
            $this->form_validation->set_rules('domain', 'Url', 'required');
            $this->form_validation->set_rules('c_code', 'Code', 'required');
            $this->form_validation->set_rules('order_id', 'Order', '');
            $this->form_validation->set_rules('lat', 'Latitude', 'required|numeric');
            $this->form_validation->set_rules('lng', 'Longitude', 'required|numeric');
            $this->form_validation->set_rules('status', '', '');


            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {


                if ($image != "")
                    $post_data['flag_logo'] = $image;
                $post_data['c_name'] = $this->input->post('c_name');
                $post_data['domain'] = $this->input->post('domain');
                $post_data['c_code'] = $this->input->post('c_code');
                $post_data['order_id'] = $this->input->post('order_id');
                $post_data['set_default'] = $this->input->post('set_default');
                $post_data['lat'] = $this->input->post('lat');
                $post_data['lng'] = $this->input->post('lng');
                $post_data['status'] = $this->input->post('status');

                $update = $this->country_model->update_countrymenu($post_data, $id);
                // echo $this->db->last_query();die;
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Country Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update');
                }
                redirect(base_url() . 'country/page');
            }
        } else {

            $data['id'] = $id;
            $data['c_code'] = $this->auto_model->getFeild('c_code', 'countries', 'id', $id);
            $data['domain'] = $this->auto_model->getFeild('domain', 'countries', 'id', $id);
            $data['c_name'] = $this->auto_model->getFeild('c_name', 'countries', 'id', $id);
            $data['flag_logo'] = $this->auto_model->getFeild('flag_logo', 'countries', 'id', $id);
            $data['order_id'] = $this->auto_model->getFeild('order_id', 'countries', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'countries', 'id', $id);
            $data['lat'] = $this->auto_model->getFeild('lat', 'countries', 'id', $id);
            $data['lng'] = $this->auto_model->getFeild('lng', 'countries', 'id', $id);
            $data['set_default'] = $this->auto_model->getFeild('set_default', 'countries', 'id', $id);


            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->country_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Country Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'country');
    }

    public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "country/page";
        $config["total_rows"] = $this->country_model->record_count_country();
        $config["per_page"] = 30;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        // $config['page_query_string'] = TRUE;
        //$config['display_pages'] = TRUE;
        $this->pagination->initialize($config);

        // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }


        $data['data'] = $this->auto_model->leftPannel();
        $data['page'] = $config['per_page'];
        $data["links"] = $this->pagination->create_links();
        $data['list'] = $this->country_model->getcountrylist($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

    public function change_country_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->country_model->updatecountry($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'country/page');
    }

    public function change_default_country() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'nod')
            $data['set_default'] = 'N';
        if ($this->uri->segment(4) == 'yd')
            $data['set_default'] = 'Y';


        $update = $this->country_model->updatecountry($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'nod')
                $this->session->set_flashdata('succ_msg', 'Default Country Setting Successfully Done...');
            if ($this->uri->segment(4) == 'yd')
                $this->session->set_flashdata('succ_msg', 'Cancell Default Country Setting... ');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'country/page');
    }

}
