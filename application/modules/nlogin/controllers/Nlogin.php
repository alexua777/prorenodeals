<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nlogin extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('nlogin_model');
        parent::__construct();
    }

    public function index() {
	if($this->uri->segment(3))
	{
		$uid=$this->uri->segment(3);
		$new_data['status']='Y';
		$new_data['v_stat']='Y';
		$this->login_model->updateuser($new_data,$uid);
	}
	$breadcrumb=array(
					array(
						'title'=>'Login','path'=>''
					)
				);
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Login');
	$head['current_page']='login';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	$table='contents';
	$by="cms_unique_title";
	$val='login';
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/
	$this->autoload_model->getsitemetasetting();
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('login',$lay,$data,'normal');
	
    }
	public function check() {
	//$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		$insert = $this->nlogin_model->login($post_data);
		 
	 }
	
    }
	
	
}
