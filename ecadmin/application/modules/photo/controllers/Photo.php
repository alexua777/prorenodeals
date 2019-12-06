<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Photo extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('photo_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
      redirect(base_url() . 'photo/page');
		/*$data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
		$data['list'] = $this->photo_model->getphotoList();
        $this->layout->view('list', $lay, $data); */
      
    }

    /////////////// Menu Add ///////////////////////////////////////////////
   /* public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        //$data['add'] = $this->advertisement_model->getbannertype();
        $lay['lft'] = "inc/section_left";

        if ($this->input->post()) {

            $image = '';
            $config['upload_path'] = '../assets/business_photo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';

            $this->load->library('upload', $config);

            $uploaded = $this->upload->do_upload();
            $upload_data = $this->upload->data();
            $image = $upload_data['file_name'];

            if (!$uploaded and $image != "") {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error_msg', $error['error']);
                redirect(base_url() . 'photo/edit');
            }


            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('link', 'Link', 'required');
            $this->form_validation->set_rules('order', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');



            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                // $post_data = $this->input->post();
                if (isset($image) AND $image != '') {
                    $post_data['image'] = $image;
                }
                $post_data['image'] = $image;
                $post_data['order'] = $this->input->post('order');
                $post_data['link'] = $this->input->post('link');
                $post_data['type'] = $this->input->post('type');
                $post_data['status'] = $this->input->post('status');
               echo "<pre>";
                  print_r($post_data);die; 
                $insert = $this->advertisement_model->add_banner($post_data);
                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Advertisement Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'advertisement/page');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
  }*/

   /* public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('order', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');


            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {

                $image = '';
                $config['upload_path'] = '../assets/advertisement_image/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                $uploaded = $this->upload->do_upload();
                $upload_data = $this->upload->data();

                $image = $upload_data['file_name'];

                if (!$uploaded AND $image != '') {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error_msg', $error['error']);
                    redirect(base_url() . 'advertisement/edit/' . $this->input->post('id'));
                }

                $post_data = $this->input->post();
                if (isset($image) AND $image != '') {
                    $id = $this->input->post('id');
                    $prev_ban = $this->auto_model->getFeild('image', 'advertisement', 'id', $id);
                    if ($prev_ban != "" && file_exists("../assets/advertisement_image/" . $prev_ban)) {
                        @unlink("../assets/advertisement_image/" . $prev_ban);
                    }

                    $post_data['image'] = $image;
                }

                $update = $this->advertisement_model->update_banner($post_data);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Advertisement Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'advertisement/page');
            }
        } else {

            $data['id'] = $id;
            $data['type'] = $this->auto_model->getFeild('type', 'advertisement', 'id', $id);
            $data['link'] = $this->auto_model->getFeild('link', 'advertisement', 'id', $id);
            $data['image'] = $this->auto_model->getFeild('image', 'advertisement', 'id', $id);
            $data['order'] = $this->auto_model->getFeild('order', 'advertisement', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'advertisement', 'id', $id);

            $this->layout->view('edit', $lay, $data);
        }
    }*/

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->photo_model->delete_photo($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Photo Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'photo/page');
    }

 public function page($business_id='',$limit_from = '') {
        
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "photo/page";
        $config["total_rows"] = $this->photo_model->record_count_photo();
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
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
		$data['business_id']='';
        $data['list'] = $this->photo_model->getphotoList($business_id,$config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

    public function change_photo_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->photo_model->updatephoto($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'photo/page/');
    }

}
