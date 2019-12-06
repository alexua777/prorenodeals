<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('report_model');
		$this->load->model('notification/notification_model');
        parent::__construct();
		
	
		
    }
	
	public function report_spam($type='', $obj_id=''){
		$next = get('next');
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$this->report_model->add_spam($user_id, $type, $obj_id);
		
		if($next){
			redirect(base_url($next));
		}
		
	}
	
	public function report_abuse($type='', $obj_id=''){
		$next = get('next');
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		$this->report_model->add_abuse($user_id, $type, $obj_id);
		
		if($next){
			redirect(base_url($next));
		}
	}
	

	
	
}
