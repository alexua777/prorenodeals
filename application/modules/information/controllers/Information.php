<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Information extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('information_model');
        parent::__construct();
    }

    public function index() {
        $data = '';
        $this->layout->view('information_body', '', $data, '');
    }
    
	  public function info($page_name="")
    {
			if($page_name=='about_us')
			{
				$breadcrumb=array(
							array(
								'title'=>'About Us','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'About Us');	
				$head['current_page']='about_us';
				$head['ad_page']='aboutus';
			}
			elseif($page_name=='step_to_success')
			{
				$breadcrumb=array(
							array(
								'title'=>'Step To Success','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Step To Success');
				$head['current_page']='step_to_success';
					
			}
			elseif($page_name=='terms_condition')
			{
				$breadcrumb=array(
							array(
								'title'=>'Terms & Condition','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Terms & Condition');	
				$head['current_page']='terms_condition';
				$head['ad_page']='terms_condition';
			}
			elseif($page_name=='service_agreement')
			{
				$breadcrumb=array(
							array(
								'title'=>'Service Provider Agreement','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Service Provider Agreement');
				$head['current_page']='service_agreement';
				$head['ad_page']='service_agreement';	
			}
			elseif($page_name=='refund_policy')
			{
				$breadcrumb=array(
							array(
								'title'=>'Refund Policy','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Refund Policy');	
				$head['current_page']='refund_policy';
				$head['ad_page']='refund_policy';
			}
			elseif($page_name=='privacy_policy')
			{
				$breadcrumb=array(
							array(
								'title'=>'Privacy Policy','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Privacy Policy');
				$head['current_page']='privacy_policy';
				$head['ad_page']='privacy_policy';	
			}
			elseif($page_name=='how_it_works')
			{
				$breadcrumb=array(
							array(
								'title'=>'How it work','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'How it work');
				$head['current_page']='how_it_works';	
			}
			elseif($page_name=='money_back')
			{
				$breadcrumb=array(
							array(
								'title'=>'Money Back Guranteed','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Money Back Guranteed');
				$head['current_page']='money_back';
				$head['ad_page']='money_back';	
			}
			elseif($page_name=='knowledge_base')
			{
				$breadcrumb=array(
							array(
								'title'=>'Knowledge Base','path'=>''
							)
						);
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Knowledge Base');
				$head['current_page']='knowledge';	
			}
			
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			//$table='contents';
			//$by="cms_unique_title";
			//$val='login';
			/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			$this->autoload_model->getsitemetasetting("content","pagename",$page_name);
			$lay['client_testimonial']="inc/footerclient_logo";
			$page_name =$this->uri->segment(3);
			$data['page_name'] = $page_name;
			$data['page_info'] = $this->information_model->getinfo($page_name);
			$this->layout->view('information_body', $lay,$data, 'normal');
    }
	
	
 }
