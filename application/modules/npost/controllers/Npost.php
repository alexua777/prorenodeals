<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Npost extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('npost_model');
        parent::__construct();
    }

    public function index() {
        if($this->input->post()){
			
            $this->session->set_flashdata('title',$this->input->post('title'));
            $this->session->set_flashdata('mail',$this->input->post('mail'));
            
            if($this->session->userdata("user")){ 
              redirect(VPATH.'postjob/');
            }
            else{ 
              redirect(VPATH.'postjob/');  
            }
			
            
        }
	
    }
	public function check() {
	//$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		  $insert = $this->login_model->login($post_data);
		 
	 }
	
    }
	
	
}
