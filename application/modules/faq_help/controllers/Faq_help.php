<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq_Help extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('faq_help_model');
        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
                        array(
                                'title'=>'FAQ','path'=>''
                        )
                );
			$data = array();
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'FAQ');
			$head['current_page']='faq_help';
			$head['ad_page']='faq';
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			
			$this->layout->set_assest($head);
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			//$table='contents';
			//$by="cms_unique_title";
			//$val='login';
			/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/
			
			$this->autoload_model->getsitemetasetting("meta","pagename","Faqhelp");
			$lay['client_testimonial']="inc/footerclient_logo";
			/*$page_name =$this->uri->segment(2);
			$data['page_name'] = $page_name;
			$data['page_info'] = $this->information_model->getinfo($page_name);*/
			
			$data['faq_question_parent'] = $this->faq_help_model->getFaqTitle();
			$this->layout->view('faq_help_body', $lay,$data, 'normal');
	 }
	
	
	

}
