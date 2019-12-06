<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('cms_model');
        parent::__construct();
    }

    public function index($page) {
	
	$head['current_page']=$page;
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	
	$table='contents';
	$by="cms_unique_title";
	$val=$page;
	$this->autoload_model->getsitemetasetting($table,$by,$val);
	$this->layout->set_assest($head);
	$lay['footerclient_logo']="inc/footerclient_logo";
	$lay['search_panel']="inc/search_panel";
	
	$data['page_heading']=$this->autoload_model->getFeild('page_heading','contents','cms_unique_title',$page);
	$data['contents']=$this->autoload_model->getFeild('contents','contents','cms_unique_title',$page);
        $this->layout->view('cms',$lay,$data);
    }


}
