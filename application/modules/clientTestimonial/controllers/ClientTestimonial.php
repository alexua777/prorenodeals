<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ClientTestimonial extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('clientTestimonial_model');
        parent::__construct();
    }

    public function index() {
		$breadcrumb=array(
                        array(
                                'title'=>'Client testimonials','path'=>''
                        )
                );
			$data = '';
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'');
			$head['current_page']='knowledge_base';
			
			$load_extra=array();
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			
			$this->layout->set_assest($head);
			
			
			
			$this->autoload_model->getsitemetasetting("meta","pagename","Clienttestimonial");
			$lay['client_testimonial']="inc/footerclient_logo";
			
			
			$data['testimonial'] = $this->clientTestimonial_model->getTestimonials();
			$this->layout->view('testimonial_body', $lay,$data, 'normal');
	 }
	
	
	

}
