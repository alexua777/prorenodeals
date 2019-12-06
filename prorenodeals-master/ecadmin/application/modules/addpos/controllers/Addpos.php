<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addpos extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('addpos_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'addpos/page');
    }

    //////////////edit bannerpos menu////////////////////
    public function edit($banner_id = '') {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $banner_id;
        if ($id == '') {
            $id = set_value('id');
        }
        $data['id'] = $id;
        $data['type'] = $this->auto_model->getFeild('type', 'add_type', 'id', $id);
        $data['position'] = $this->auto_model->getFeild('position', 'add_type', 'id', $id);
        $resolution = $this->auto_model->getFeild('resolution', 'add_type', 'id', $id);
        $data['price'] = $this->auto_model->getFeild('price', 'add_type', 'id', $id);
        $data['validity'] = $this->auto_model->getFeild('validity', 'add_type', 'id', $id);
        $resolution = explode("X", $resolution);
        $data['width'] = $resolution[0];
        $data['height'] = $resolution[1];

        if ($this->input->post()) {
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('width', 'Width', 'required|integer');
            $this->form_validation->set_rules('height', 'Height', 'required|integer');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('validity', 'Validity', 'required|integer');
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
                $post_data = $this->input->post();
                $update = $this->addpos_model->update_banner_pos($post_data);
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Banner type has been updated successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Banner type could not be updated');
                }
                redirect(base_url() . 'addpos/page');
            }
        } else {
            $this->layout->view('edit', $lay, $data);
        }
    }

    public function add() {
        $this->load->model("add/add_model");
        $data['data'] = $this->auto_model->leftPannel();
        $data['add'] = $this->add_model->getbannertype();
        $lay['lft'] = "inc/section_left";

        $data['id'] = '';
        $data['type'] = '';
        $data['position'] = '';
        $data['price'] = '0.00';
        $data['validity'] = '0';
        $data['width'] = '0';
        $data['height'] = '0';

        if ($this->input->post()) {
            $this->form_validation->set_rules('position', 'Position', 'required');
            $this->form_validation->set_rules('width', 'Width', 'required|integer');
            $this->form_validation->set_rules('height', 'Height', 'required|integer');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
            $this->form_validation->set_rules('validity', 'Validity', 'required|integer');
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
                $post_data = $this->input->post();
                $update = $this->addpos_model->add_banner_pos($post_data);
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Advertise type has been inserted successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Banner type could not be inserted');
                }
                redirect(base_url() . 'addpos/page');
            }
        } else {
            $this->layout->view('edit', $lay, $data);
        }
    }
    
    ///// Delete menu //////////////////////////////////
    public function delete_state() {
        $id = $this->uri->segment(3);
        $delete = $this->addpos_model->delete_state($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'State Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
        }
        redirect(base_url() . 'state');
    }

    public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "addpos/page";
        $config["total_rows"] = $this->addpos_model->record_count_state();
        $config["per_page"] = 30;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }

        $data['data'] = $this->auto_model->leftPannel();
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["total_rows"];
        $data['list'] = $this->addpos_model->get_banner_type_list($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

}
