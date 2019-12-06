<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends MX_Controller {

   
    public function __construct() {
       
        parent::__construct();
	}

	
	public function matching_job(){
		$usrs_list =  $this->cron_model->getUsers();
	}
	
	public function handle_dispute(){
		$this->load->model('projectdashboard/projectdashboard_model');
		$this->projectdashboard_model->check_unresponded_disputes();
	}
	
}
