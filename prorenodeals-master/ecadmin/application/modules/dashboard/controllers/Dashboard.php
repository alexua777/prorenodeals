<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('user_model');
        parent::__construct();		//print_r('fsdfs'); die();
    }

    public function index() {
        $data['data'] = $this->auto_model->leftPannel();	 
        $lay['lft'] = "inc/section_left";
		$data['total_member'] = $this->user_model->count_member();
		$data['active_member'] = $this->user_model->count_member('Y');
		$data['inactive_member'] = $this->user_model->count_member('N');
		$data['suspended_member'] = $this->user_model->count_member('S');
        $data['total_project'] = $this->user_model->count_project();
		$data['open_project'] = $this->user_model->count_project('O');
		$data['working_project'] = $this->user_model->count_project('P');
		$data['frozen_project'] = $this->user_model->count_project('F');
		$data['complete_project'] = $this->user_model->count_project('C');
		$data['expire_project'] = $this->user_model->count_project('E');
		$data['free_member'] = $this->user_model->member_type('1');
		$data['silver_member'] = $this->user_model->member_type('2');
		$data['gold_member'] = $this->user_model->member_type('3');
		$data['platinum_member'] = $this->user_model->member_type('4');
		$data['total_registration_2']=$this->user_model->registration('',date('Y-m',strtotime('-2 month')));
		$data['paid_registration_2']=$this->user_model->registration('2',date('Y-m',strtotime('-2 month')));
		$data['free_registration_2']=$this->user_model->registration('1',date('Y-m',strtotime('-2 month')));
		$data['total_registration_1']=$this->user_model->registration('',date('Y-m',strtotime('last month')));
		$data['paid_registration_1']=$this->user_model->registration('2',date('Y-m',strtotime('last month')));
		$data['free_registration_1']=$this->user_model->registration('1',date('Y-m',strtotime('last month')));
		$data['total_registration_current']=$this->user_model->registration('',date('Y-m'));
		$data['paid_registration_current']=$this->user_model->registration('2',date('Y-m'));
		$data['free_registration_current']=$this->user_model->registration('1',date('Y-m'));
		
        $this->layout->view('dashboard', $lay, $data);

        //$this->layout->view('dashboard',$lay,$count); 
    }

    public function login() {
        $result = $this->user_model->login();
        echo json_encode($result);
    }

    public function register() {
        if ($this->input->post('submit')) {
            $result = $this->user_model->register();
            echo json_encode($result);
            return;
        }
        $param = "";
        $this->load->view('register', $param);
    }

    public function logout() {
        $this->session->unset_userdata('user');
    }
}
