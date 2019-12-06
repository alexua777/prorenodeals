<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('notification_model');
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('notification', $idiom);
        parent::__construct();
    }

    public function index($limit_from='') {
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
                            'title'=>__('notification','Notifications'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('notification','Notifications'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		//print_r($data['leftpanel']);
		//die();
		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='membership';
		
		$head['ad_page']='notification';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'notification/index/';
		
		$total_rows=$this->auto_model->count_results('id','notification','','',array('to_id'=>$user[0]->user_id));
		      
        $config['total_rows'] =$total_rows;
		$config['per_page'] = 10; 
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;  
                
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next') ."&gt;&gt;";
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'. __('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';                 
		
$this->pagination->initialize($config); 
$page = ($limit_from) ? $limit_from : 0;
		$per_page = $config["per_page"];
		$start = 0;
		if ($page > 0) {
			for ($i = 1; $i < $page; $i++) {
				$start = $start + $per_page;
			}
		}
		
		 $data['notification_count']=$total_rows;
		 $data['links']=$this->pagination->create_links();

		$this->layout->set_assest($head);

        $data['notification']=$this->notification_model->getnotification($user[0]->user_id,$config['per_page'],$start);    

	
		$this->autoload_model->getsitemetasetting("meta","pagename","Notification");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('notification',$lay,$data,'normal');

	}        
    }
	public function details(){
		if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

	$notifyid=$this->uri->segment('3');
		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
         //$data['user_membership']=$user[0]->membership_plan;

		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'Notifications','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Notification');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='membership';
		
		$head['ad_page']='notification';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'notification/index/';
		
		$total_rows=$this->auto_model->count_results('id','notification','','',array('to_id'=>$user[0]->user_id,'id'=>$notifyid));
		      
        $config['total_rows'] =$total_rows;
		$config['per_page'] = 10; 
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;  
                
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li><a href='javascript:void(0)'><b>";
		$config['cur_tag_close'] = '</b></a></li>';
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt; Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';                 
		
$this->pagination->initialize($config); 
$page = 0;
		$per_page = $config["per_page"];
		$start = 0;
		if ($page > 0) {
			for ($i = 1; $i < $page; $i++) {
				$start = $start + $per_page;
			}
		}
		
		 $data['notification_count']=$total_rows;
		 $data['links']=$this->pagination->create_links();

		$this->layout->set_assest($head);

        $data['notification']=$this->notification_model->getnotification_details($user[0]->user_id,$notifyid);    

	
		$this->autoload_model->getsitemetasetting("meta","pagename","Notification");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('notification',$lay,$data,'normal');

	}
		
		
	}
    ///// Delete Sub Notification //////////////////////////////////
    public function delete($id = '') {
        $delete = $this->notification_model->delete($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Notification Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
        }
        redirect(VPATH. 'notification');
    }
	



}
