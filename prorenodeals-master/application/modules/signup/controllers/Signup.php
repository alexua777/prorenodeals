<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->helper('captcha');
        $this->load->helper('recaptcha');
        $this->load->library('MY_Validation');
        
        $this->load->model('login/login_model');
		$this->load->model('membership/membership_model');
		$this->load->model('signup/signup_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('signup', $idiom);
        parent::__construct();
    }

   /* public function index() {
	$breadcrumb=array(
					array(
						'title'=>'Signup','path'=>''
					)
				);
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Signup');
	$head['current_page']='signup';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	$table='contents';
	$by="cms_unique_title";
	$val='signup';
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

	$data['country']=$this->signup_model->getCountry();
	$this->autoload_model->getsitemetasetting("meta","pagename","Signup");
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('signup',$lay,$data,'normal');
	
    }
*/
 public function index() {
	 $user = $this->session->userdata('user');
	if($user){
		redirect(base_url('jobfeed'));
	}

	if($this->uri->segment(3)){

		$uid=base64_decode($this->uri->segment(3));

		$new_data['status']='N';

		$new_data['v_stat']='Y';

		$this->login_model->updateuser($new_data,$uid);

	}

	$breadcrumb=array(

					array(

						'title'=>'Signup','path'=>''

					)

				);

	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Signup');

	$head['current_page']='signup';
	
	$head['ad_page']='signup';

	$load_extra=array();

	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

	$this->layout->set_assest($head);

	$table='contents';

	$by="cms_unique_title";

	$val='login';
	
	$data['refer']=$this->input->get('refer');

	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

        	$data['country_list']=$this->autoload_model->getCountry();
			
			//$country_code=$data['country'];
            
            //$data['city_list']=$this->autoload_model->getCity($country_code);
        
        
	$this->autoload_model->getsitemetasetting("meta","pagename","Signup");

	$lay['client_testimonial']="inc/footerclient_logo";

	$this->layout->view('signup',$lay,$data,'normal');
    }
	
	public function check() {
		
	$this->auto_model->checkrequestajax();
	
		  if ($this->input->post()) 
		  {
			
	 			 $post_data = $this->input->post();
		  		$insert = $this->signup_model->register($post_data);
		 }
    }
	 public function usercheck()
	 {
	   $post_data = $this->input->post();
	   $insert = $this->signup_model->usercheck($post_data);
	 }
	 public function emailcheck()
	 {
	   $post_data = $this->input->post();
	   $insert = $this->signup_model->emailcheck($post_data);
	 }

	public function register_success()
	 {
		$breadcrumb=array(

					array(

						'title'=>'Signup','path'=>''

					)

				);

	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Signup');

	$head['current_page']='signup';
	
	$head['ad_page']='signup';

	$load_extra=array();

	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

	$this->layout->set_assest($head);

	$table='contents';

	$by="cms_unique_title";

	$val='login';
	
	$data['refer']=$this->input->get('refer');

	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

        $data['country']=$this->autoload_model->getCountry();
        
        $data['state']=$this->autoload_model->getCity("NGA");
        
        
	$this->autoload_model->getsitemetasetting("meta","pagename","Signup");

	$lay['client_testimonial']="inc/footerclient_logo";
	   $this->layout->view('register_success',$lay,$data,'normal');
	 }

}
