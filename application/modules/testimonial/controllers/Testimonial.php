<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('testimonial_model');
        parent::__construct();
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('testimonial', $idiom);
		$this->lang->load('form_validation', $idiom);
    }

    public function index() {
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
         //$data['user_membership']=$user[0]->membership_plan;

		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('testimonial','Testimonial'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('notification','Notifications'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='testimonial';
		
		$head['ad_page']='teastimonial_details';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

        $data['username']=$this->auto_model->getFeild('username','user','user_id',$user[0]->user_id);

	
		$this->autoload_model->getsitemetasetting();

		$lay['client_testimonial']="inc/footerclient_logo";
		if($this->input->post())
		{
			
			$this->form_validation->set_rules('description', __('testimonial_feedback','Feedback'), 'required');

            if ($this->form_validation->run() == FALSE) {              
                $this->layout->view('testimonial',$lay,$data,'normal');
            } else {
     
			   	$post_data['user_id'] = $user[0]->user_id;
				$post_data['description'] = $this->input->post('description');
				$post_data['posted_date'] =date('Y-m-d');
                $post_data['status'] = 'N';
              
                $insert_team = $this->testimonial_model->add($post_data);
               
                if ($insert_team) {
                    $this->session->set_flashdata('succ_msg', __('testimonial_insert_success_text','Your feedback is submitted successfuly. Same will be posted after admin verification'));
                } else {
                    $this->session->set_flashdata('error_msg', __('testimonial_unable_to_insert_data','Unable to Insert Data'));
                }
                redirect(base_url() . 'testimonial/');
            }
	
		}
		else
		{

			$this->layout->view('testimonial',$lay,$data,'normal');
		}

	}        
    }



}
