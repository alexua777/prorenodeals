<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('email_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }

    public function index() {
	    redirect (base_url(). 'email/page');
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $data['add'] = $this->email_model->gettype();
        $lay['lft'] = "inc/section_left";
		$data['ckeditor'] = $this->editor->geteditor('contents','Full');


        if ($this->input->post()) {
            $this->form_validation->set_rules('type', 'Email type', 'required|is_unique[mailtemplate.type]');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('template', 'Template', 'required');
           
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                //$post_data = $this->input->post();
                $insert = $this->email_model->add_email();

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Email Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'email/page');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        $data['edit'] = $this->email_model->gettype();
        $lay['lft'] = "inc/section_left";
		$data['ckeditor'] = $this->editor->geteditor('contents','Full');
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('template', 'Template', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {

                $post_data = $this->input->post();
                $update = $this->email_model->update_email($post_data);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Email Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'email/page');
            }
        } else {

            $data['id'] = $id;
            $data['type'] = $this->auto_model->getFeild('type', 'mailtemplate', 'id', $id);
            $data['subject'] = $this->auto_model->getFeild('subject', 'mailtemplate', 'id', $id);
            $data['template'] = $this->auto_model->getFeild('template', 'mailtemplate', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'mailtemplate', 'id', $id);

            $this->layout->view('edit', $lay, $data);
        }
    }
	public function page($limit_from='')
	{
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "email/page";
        $config["total_rows"] = $this->email_model->record_count_email();
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
        if($page>0)	
        {   
            for($i = 1; $i<$page; $i++)
            {
                $start = $start + $per_page;		
            }
        }
		
        $data['data'] = $this->auto_model->leftPannel();
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		//$data($config['per_page'])=3;
        $data['list'] = $this->email_model->getemailList($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
	
	public function change_email_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->email_model->updateemail($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'email/page/');
	
	}

	
	
	
	
	

}
