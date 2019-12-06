<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('notification_model');
        $this->load->library('form_validation');
		$this->load->library('mailtemplete');
		$this->load->library('pagination');
        $this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }

    public function index() {
	   redirect (base_url(). 'notification/notification_list');
       
    }

    
   
	public function notification_list($limit_from='')
	{
		$lay['lft'] = "inc/section_left";
		$data['ckeditor'] = $this->editor->geteditor('body','Full');
        $config = array();
        $config["base_url"] = base_url() . "notification/notification_list";
        $config["total_rows"] = $this->db->get('new_inviteproject')->num_rows();
        $config["per_page"] = 20;
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
		$config['next_link'] = 'Next'.' <i class="la la-angle-double-right"></i>';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="la la-angle-double-left"></i> '.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
      $data['invitation'] = $this->notification_model->getnotification($config['per_page'],$start);
	   
	   //print_r($data['invitation']);
        $this->layout->view('list', $lay, $data);
    }
	
	public function registered($limit_from='')
	{
		$lay['lft'] = "inc/section_left";
		$data['ckeditor'] = $this->editor->geteditor('body','Full');
        $config = array();
        $config["base_url"] = base_url() . "invite/registered";
        $config["total_rows"] = $this->db->get('inviteprivate_project')->num_rows();
        $config["per_page"] = 20;
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
		
        $data['list'] = $this->notification_model->getRegisteredList($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('registered_list', $lay, $data);
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
       
			$this->form_validation->set_rules('reply_message', 'Message', 'required');
             if ($this->form_validation->run() == FALSE) 
			 {
                $this->layout->view('reply_message', $lay,$data, 'normal');
             } else
			 {
			 
			 $user_email =  $this->input->post('mail_to');
			 $message =  	$this->input->post('reply_message');
			 $admin_mail =   $this->auto_model->getFeild('admin_mail', 'setting', 'id', 1);
			 
				$this->session->set_flashdata('succ_msg', '<b>Well done ! </b> Your message has been send successfully !');
				
			
				$param = array(
                        "{email}" => $admin_mail,
						"{subject}" => 'Reply Message',
						"{Message}" => ucwords($message)
                    );	
					
				$this->mailtemplete->send_mail($admin_mail, $user_email, 'Contact information', $param);
				
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
	public function getMail($uid)
	{
		
		$uid=explode(',',$uid);
		$umail='';
		for($i=0;$i<count($uid);$i++)
		{
			
			$mail=$this->auto_model->getFeild('friend_email','invite_friend','id',$uid[$i]);
			
			$umail.=$mail.",";
		}
		$umail=rtrim($umail,', ');
		echo $umail;
	}
	public function getMails($uid)
	{
		
		$uid=explode(',',$uid);
		$umail='';
		for($i=0;$i<count($uid);$i++)
		{
			
			$mail=$this->auto_model->getFeild('inviteuser_email','inviteprivate_project','id',$uid[$i]);
			
			$umail.=$mail.",";
		}
		$umail=rtrim($umail,', ');
		echo $umail;
	}
	public function send_mail()
	{
		$to=$this->input->post('to');
		$message=$this->input->post('body');
		
		$from=SITE_TITLE;
		
		$subject="Notification from SMEclub";
		
		$this->load->library('email');

			
		$this->email->from($from, 'admin');
		$this->email->to($to); 
		$this->email->subject($subject);
		$this->email->set_mailtype("html");
		
		$contents=str_replace('src="/','src="'.SITE_URL,$message);
		$contents=html_entity_decode($contents);
		$this->email->message($contents);	

		$a=$this->email->send();
		
		if($a)
		{
			$this->session->set_flashdata('succ_msg',"Email send successfuly.");	
		}
		else
		{
			$this->session->set_flashdata('error_msg',"Email sending failed.");	
		}
		redirect(base_url().'invite/page');
			
	}
	
	public function generatechkCSV()
	{
            $this->load->database();
            $query = $this->db->get('invite_friend');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Unregistered_Invitee_list_'.date("dMy").'.csv');
	}
	
	public function generateCSV()
	{
            $this->load->database();
            $query = $this->db->get('inviteprivate_project');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Registered_Invitee_list_'.date("dMy").'.csv');
	}

}