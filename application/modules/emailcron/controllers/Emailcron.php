<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Emailcron extends MX_Controller {    

    public function __construct() 
	{
      
	
        parent::__construct();
		   $this->load->model('email_model');
    }

    public function index() {

		$this->email_model->test();
	

  }
  
}