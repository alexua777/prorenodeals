<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminmenu extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('adminmenu_model');
        $this->load->library('form_validation');
        parent::__construct();
    }

    public function index() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->adminmenu_model->getMenus();

        $this->layout->view('list', $lay, $data);
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";


        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[adminmenu.name]');
            $this->form_validation->set_rules('url', 'Url', 'required');
            $this->form_validation->set_rules('ord', '', '');
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                $post_data = $this->input->post();
                $insert = $this->adminmenu_model->add_menu($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Menu  Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'menulist');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		
        if ($this->input->post()) {
		
			$post_data = $this->input->post();
			$data['id'] = $id = $post_data['id'];
			$data['name'] = $post['name'] = $post_data['name'];
			$data['url'] = $post['url'] = $post_data['url'];
			$data['ord'] = $post['ord'] = $post_data['ord'];
			$data['title'] = $post['title'] =  $post_data['title'];
			$data['parent_id'] = $post['parent_id'] =  $post_data['parent_id'];
			$data['parent_name'] = $post['name'] =  $post_data['name'];
			$data['status'] = $post['status'] =  $post_data['status'];
			$data['ord'] = $post['ord'] =  $post_data['ord'];
			$data['title'] = $post['title'] =  $post_data['title'];
			$data['style_class'] = $post['style_class'] =  $post_data['style_class'];
			
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('url', 'Url', 'required');
            $this->form_validation->set_rules('ord', '', '');
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');	

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('edit', $lay,$data);
            } else {
                $update = $this->adminmenu_model->update_menu($post,$id);
				
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Menu Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'menulist');
            }
        } else {

            $data['id'] = $id;
            $data['name'] = $this->auto_model->getFeild('name', 'adminmenu', 'id', $id);
            $data['url'] = $this->auto_model->getFeild('url', 'adminmenu', 'id', $id);
            $data['ord'] = $this->auto_model->getFeild('ord', 'adminmenu', 'id', $id);
            $data['title'] = $this->auto_model->getFeild('title', 'adminmenu', 'id', $id);
            $data['parent_id'] = $this->auto_model->getFeild('parent_id', 'adminmenu', 'id', $id);
            $data['parent_name'] = $this->auto_model->getFeild('name', 'adminmenu', 'id', $data['parent_id']);
            $data['status'] = $this->auto_model->getFeild('status', 'adminmenu', 'id', $id);
            $data['ord'] = $this->auto_model->getFeild('ord', 'adminmenu', 'id', $id);
            $data['title'] = $this->auto_model->getFeild('title', 'adminmenu', 'id', $id);
            $data['style_class'] = $this->auto_model->getFeild('style_class', 'adminmenu', 'id', $id);

            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->adminmenu_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Menu Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'menulist');
    }
	
	public function change_admin_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->adminmenu_model->updateadmin($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'adminmenu');
	
	}
	
	
	
	

}
