<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pagenotfound extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
							array(
								'title'=>'404 Not Found','path'=>''
							)
						);
			$data = '';
			$data['address']=$this->autoload_model->getFeild('corporate_address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('office_no','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('admin_mail','setting','id',1);
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'404');
			$head['current_page']='404';
			$head['ad_page']='success_tips';
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			$this->autoload_model->getsitemetasetting("meta","pagename","404");
			$lay['client_testimonial']="inc/footerclient_logo";
			
			
			
			
			
			
			$this->layout->view('pagenotfound',$lay,$data, 'normal');
    }

   

}
