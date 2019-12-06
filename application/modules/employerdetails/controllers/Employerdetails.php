<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employerdetails extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('employerdetails_model');
		$this->load->model('dashboard/dashboard_model');
        parent::__construct();
    }

    public function index() {
        
    }

public function showdetails(){ 
            $user_id=  $this->uri->segment(3);
           
           
         // $user_id=  3;
          //  $user=$this->session->userdata('user');

            $data['user_id']=$user_id;

            $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);

            $data['fname']=$this->auto_model->getFeild('fname','user','user_id',$user_id);

            $data['lname']=$this->auto_model->getFeild('lname','user','user_id',$user_id);

            $data['about']=$this->auto_model->getFeild('asclient_aboutus','user','user_id',$user_id);

			$data['country']=$this->auto_model->getFeild('country','user','user_id',$user_id);
			
			$data['verify']=$this->auto_model->getFeild('verify','user','user_id',$user_id);
			
            $data['city']=$this->auto_model->getFeild('city','user','user_id',$user_id);
			
	    	$data['logo']=$this->auto_model->getFeild('logo','user','user_id',$user_id);
			
			$data['rating']=$this->dashboard_model->getrating($user_id);
		
			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user_id);
		
                $data['review']=$this->dashboard_model->getmyreview($user_id);
            $data['facebook_link']=$this->auto_model->getFeild('facebook_link','user','user_id',$user_id);

            $data['twitter_link']=$this->auto_model->getFeild('twitter_link','user','user_id',$user_id);

            $data['gplus_link']=$this->auto_model->getFeild('gplus_link','user','user_id',$user_id);

            $data['linkedin_link']=$this->auto_model->getFeild('linkedin_link','user','user_id',$user_id);                         

                        
            $breadcrumb=array(
                array(
                    'title'=>'Dashboard','path'=>''
                )
            );
			$txt=$data['fname']." ".$data['lname']."'s Profile";

            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,$txt);
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

            ///////////////////////////Leftpanel Section start//////////////////

            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			$logo="uploaded/".$logo;

		}

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='dashboard';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);

            $table='contents';

            $by="cms_unique_title";

            $val='login';

            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

            $this->autoload_model->getsitemetasetting("meta","pagename","Employerdetails");

            $lay['client_testimonial']="inc/footerclient_logo";


            $this->layout->view('talent_details',$lay,$data,'normal');
}



}
