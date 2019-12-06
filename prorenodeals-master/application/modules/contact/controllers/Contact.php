<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contact extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('contact_model');
		$this->load->library("mailtemplete");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
							array(
								'title'=>'Contact','path'=>''
							)
						);
			$data = '';
			$data['address']=$this->autoload_model->getFeild('corporate_address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('office_no','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('admin_mail','setting','id',1);
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Contact');
			$head['current_page']='contact';
			$head['ad_page']='success_tips';
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			$this->autoload_model->getsitemetasetting("meta","pagename","Contact");
			$lay['client_testimonial']="inc/footerclient_logo";
			
			
			$data['contact']=$this->contact_model->getcontact_info();  
			
			
			
			$this->layout->view('view_contact',$lay,$data, 'normal');
    }

    public function contact_form($comes_from = '')
	 {
	 
	 
		$breadcrumb=array(
							array(
								'title'=>'Contact','path'=>''
							)
						);
			$data = '';
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Contact');
			$head['current_page']='contact';
			$load_extra=array();
			
			
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			
			$this->autoload_model->getsitemetasetting("meta","pagename","Contact");
			$lay['client_testimonial']="inc/footerclient_logo";
			$data['contact']=$this->contact_model->getcontact_info();  
			
        if ($this->input->post('contact'))
		 {
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('subject', 'subject', 'required');
			$this->form_validation->set_rules('message', 'Message', 'required');
             if ($this->form_validation->run() == FALSE) 
			 {
                $this->layout->view('view_contact', $lay,$data, 'normal');
             } else
			 {
                $post_data['contact_name'] = $this->input->post('name');
                $post_data['contact_email'] = $this->input->post('email');
                $post_data['contact_subject'] = $this->input->post('subject');
				$post_data['contact_message'] = $this->input->post('message');
                $post_data['contact_date'] = date('Y-m-d');
				$post_data['is_red_by_admin'] = 'N';
				$insert = $this->contact_model->getcontact($post_data);
                if ($insert) {
				
                
                $this->session->set_flashdata('succ_msg', 'Thanks. Your message has been sent successfully!');
				$from=ADMIN_EMAIL;
                $to= $this->input->post('email');
				
				
				$template='contact_support';
				$data_parse=array("name"=>ucwords($this->input->post('name')),
							"email"=>$this->input->post('email'),
							"ticket"=>$insert
							);				
				$this->auto_model->send_email($from,$to,$template,$data_parse);
				
				$template1='contact_request';
				$datanew_parse=array("{name}"=>ucwords($this->input->post('name')),
							"email"=>$this->input->post('email'),
							"ticket"=>$insert,
							"subject"=>ucwords($this->input->post('subject')),
							"message"=>ucwords($this->input->post('message'))
							);
				$to=ADMIN_EMAIL;
				$this->auto_model->send_email($to,$from,$template1,$datanew_parse);
				
				redirect(base_url() . "contact");
				$this->layout->view('view_contact', '', $data, 'normal');
				}	else {
                        $this->session->set_flashdata('error_msg', 'Unable to Send...Please correct the details.');
                        $this->layout->view('view_contact', '', $data, 'normal');
                    }
                }
            }
       else {
            $this->layout->view('view_contact', $lay, $data, 'normal');
        }
    }

}
