<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('sitemap_model');
        parent::__construct();
    }

    public function index() {
		
			//$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'sitemap');
			$head['current_page']='sitemap';
			$head['ad_page']='sitemap';
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$this->layout->set_assest($head);
			$this->autoload_model->getsitemetasetting("meta","pagename","Sitemap");
			$lay['client_testimonial']="inc/footerclient_logo";
			$data['sitemap']=$this->sitemap_model->getSitemap();  
	
	
	   
  			 $this->layout->view('sitemap', $lay, $data, 'normal');
    }

	
}
