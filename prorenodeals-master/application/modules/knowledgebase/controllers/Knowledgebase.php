<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Knowledgebase extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('knowledgebase_model');
        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
                        array(
                                'title'=>'Knowledge Base','path'=>''
                        )
                );
			$data = '';
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Knowledge Base');
			$head['current_page']='knowledge_base';
			$head['ad_page']='success_tips';
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
			
			$this->autoload_model->getsitemetasetting("meta","pagename","Knowledgebase");
			$lay['client_testimonial']="inc/footerclient_logo";
			/*$page_name =$this->uri->segment(2);
			$data['page_name'] = $page_name;
			$data['page_info'] = $this->information_model->getinfo($page_name);*/
			
			$data['faq_question_parent'] = $this->knowledgebase_model->getKnowledgeTitle();
			$this->layout->view('knowledgebase_body', $lay,$data, 'normal');
	 }
	
	
	

}
