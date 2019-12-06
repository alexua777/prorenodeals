<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rssfeed extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {

        $this->load->model('rssfeed_model');
        parent::__construct();
		$this->load->helper(array('xml'));
    }

    public function index($category = '', $project_type = '', $min_budget='', $max_budget = '', $posted = '', $country = '',$city='',$featured='',$environment='',$uid='') {
		
		
		$ptype=$project_type;
		$minb=$min_budget;
		$maxb=$max_budget;
		$post_with=$posted;
		$cat=str_replace('_','&',$category);
		$cat=str_replace('%20',' ',$cat);
		$country=str_replace('%20',' ',$country);
		$city=str_replace('%20',' ',$city);
		
		$data['feed_name'] = 'elanceadvance.scriptfirm.com';
       // set page encoding
       $data['encoding'] = 'utf-8';
       // set feed url
       $data['feed_url'] = 'http://elanceadvance.scriptfirm.com/rssfeed';
       // set page language
       $data['page_language'] = 'en';
       // set page Description
       $data['page_description'] = 'PHP | CodeIgniter | Wordpress | MySQL | Css3 | HTML5 | JQuery';
       // set author email
       $data['creator_email'] = 'teamelanceadv@scriptgiant.com';
       // this line is very important, this will let browser to display XML format output
       header("Content-Type: application/rss+xml");
	   
	   $data['feed_post']=$this->rssfeed_model->get_feeds($cat,$ptype,$minb,$maxb,$post_with,$country,$city,$featured,$environment,$uid);

	   $this->layout->view('feed','',$data, 'feed');
	 }
	
	
	

}
