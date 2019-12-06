<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('contact_model');
        $this->load->library('form_validation');
		$this->load->library('mailtemplete');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	   redirect (base_url(). 'contact/page');
       
    }

    
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->contact_model->delete_contact($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'contact Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'contact/page');
    }
	public function page($limit_from='')
	{
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "news/page";
        $config["total_rows"] = $this->contact_model->record_count_contact();
        $config["per_page"] = 30;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

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
		
        $data['data']  = 	$this->auto_model->leftPannel();
        $data["links"] = 	$this->pagination->create_links();
		$data["page"]  =	$config["per_page"];
		//$data($config['per_page'])=3;
        $data['list'] = $this->contact_model->getcontactList($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
	
	
	
	
	
	public function reply(){
		$lay['lft'] = "inc/section_left";
		$data['data']  = 	$this->auto_model->leftPannel();
		$id = $this->uri->segment(3);
		$data['user_email'] =  $this->auto_model->getFeild('contact_email', 'contact', 'contact_id', $id);
		
		//$this->layout->view('reply_message', $lay, $data);
		if ($this->input->post('reply'))
		 {
            
            $this->form_validation->set_rules('mail_to', 'Email', 'required|valid_email');
       		$this->form_validation->set_rules('subject', 'Subject', 'required');
			$this->form_validation->set_rules('reply_message', 'Message', 'required');
             if ($this->form_validation->run() == FALSE) 
			 {
                $this->layout->view('reply_message', $lay,$data, 'normal');
             } 
			 else
			 {
			 
			 $user_email =  $this->input->post('mail_to');
			 $subject =  	$this->input->post('subject');
			 $message =  	$this->input->post('reply_message');			 
			 
			 $from=$this->auto_model->getFeild('admin_mail', 'setting', 'id', 1);
		
			$this->load->library('email');
	
				
			$this->email->from($from, 'admin');
			$this->email->to($user_email); 
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			
			$contents=str_replace('src="/','src="'.SITE_URL,$message);
			$contents=html_entity_decode($contents);
			$this->email->message($contents);	
	
			$a=$this->email->send();
			
			if($a)
			{
				$this->session->set_flashdata('succ_msg', '<b>Well done ! </b> Your message has been send successfully !');	
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Email sending failed.");	
			}
				
				
				redirect(base_url() . "contact");
				
			}
		}else{
			//$this->layout->view('reply_message', $lay,$data, 'normal');
		
		
			}
		
		
		$this->layout->view('reply_message', $lay,$data, 'normal');
	}
	
	
	public function change_contact_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['is_red_by_admin'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['is_red_by_admin'] = 'Y';
		
		
		$update = $this->contact_model->updatecons($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'contact/page/');
	
	}

}