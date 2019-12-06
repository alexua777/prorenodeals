<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Verify extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('verify_model');
      
        parent::__construct();
    }
	
	public function verify_email($code=''){
		$data = array();
		if(empty($code)){
			
			return FALSE;
		}
		$row = $this->db->where(array('email_verification_link' => $code))->get('user')->row_array();
		if(!empty($row) && count($row) > 0){
			$data['status'] = 1;
			$this->db->where(array('email_verification_link' => $code))->update('user', array('email_verification_link' => '', 'email_verified' => 'Y'));
		}else{
			$data['status'] = 0;
		}
		$lay = '';
		$this->layout->view('email_verify',$lay,$data,'normal');
	}

}
