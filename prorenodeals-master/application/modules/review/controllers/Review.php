<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('review_model');
		$this->load->model('notification/notification_model');
        parent::__construct();
    }

    public function index() {
        
    }
	
	public function load_ajax_page(){
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$page = get('page');
		$data['next'] = get('next');
		if($page == 'rating_review'){
			$list_type=get('list_type');
			$data['review_from_user'] = get('review_from_user');
			$data['review_to_user'] = get('review_to_user');
			$data['review_from_agency'] = get('review_from_agency');
			$data['review_to_agency'] = get('review_to_agency');
			$data['agency_id'] = get('review_to_agency');
			$data['job_id'] = get('job_id');
			$data['review_to'] = get('review_to');
			if($data['review_to'] == 'agency' || $data['review_to'] == 'company'){
				if(!$data['review_to_user']){
					$data['review_to_user'] = getField('created_by', 'agency', 'agency_id', $data['agency_id']);
				}
				$name = getField('agency_name', 'agency', 'agency_id', $data['agency_id']);
			}else{
				$name = getField('fname', 'user', 'user_id', $data['review_to_user']);
			}
			
			$data['title'] = 'Review To ' . $name;
			
		}else if($page == 'rating_review_edit'){
			$review_id=get('review_id');
			$data = get_row(array('select' => '*', 'from' => 'review_new', 'where' => array('review_id' => $review_id)));
			/* $data['review_from_user'] = get('review_from_user');
			$data['review_to_user'] = get('review_to_user');
			$data['review_from_agency'] = get('review_from_agency');
			$data['review_to_agency'] = get('review_to_agency');
			$data['agency_id'] = get('review_to_agency');
			$data['job_id'] = get('job_id');
			$data['review_to'] = get('review_to'); */
			if($data && $data['review_to_agency'] > 0){
				$is_company = getField('is_company', 'agency', 'agency_id', $data['review_to_agency']);
				if($is_company == 1){
					$data['review_to'] = 'company';
				}else{
					$data['review_to'] = 'agency';
				}
			}else{
				if($data && $data['review_to_user'] > 0){
					$is_freelancer = getField('account_type', 'user', 'user_id', $data['review_to_user']);
					if($is_freelancer == 'F'){
						$data['review_to'] = 'freelancer';
					}else{
						$data['review_to'] = 'employer';
					}
				}
				
			}
			if($data['review_to'] == 'agency' || $data['review_to'] == 'company'){
				if(!$data['review_to_user']){
					$data['review_to_user'] = getField('created_by', 'agency', 'agency_id', $data['review_to_agency']);
				}
				$name = getField('agency_name', 'agency', 'agency_id', $data['review_to_agency']);
			}else{
				$name = getField('fname', 'user', 'user_id', $data['review_to_user']);
			}
			$data['job_id']=$data['project_id'];
			$data['title'] = 'Review To ' . $name . '(Edit)';
		}
		
		$data['page'] = $page;
		$this->load->view('ajax_page', $data);
		
	}
	
	public function post_review_ajax_old(){
		$json = array();
		$json['status'] = 0;
		
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$validate = $this->_validateForm('post_review');
			
			if($validate['status'] == 1){
				$post = post();
				$review_from = $user_id;
				$review_to_user = filter_data(post('review_to_user'));
				$job_id = filter_data(post('job_id'));
				$agency_id = filter_data(post('agency_id'));
				$review_to = filter_data(post('review_to'));
				
				if($review_to == 'agency'){
					$where=array(
						'review_by_user' => $review_from,
						'agency_id' => $agency_id,
					);
				}else{
					$where=array(
						'review_by_user' => $review_from,
						'review_to_user' => $review_to_user,
					);
				}
				
				
				
				if($job_id){
					$where['project_id'] = $job_id;
				}
				
				$review_data = filter_data(post('public'));
				
				$row = $this->db->where($where)->get('review_new')->row_array();
				if($row && $row['review_id']){
					$review_data['edited_date'] = date('Y-m-d');
					$update = $this->review_model->updatePublicRating($review_data, $row['review_id']);
					$review_id = $row['review_id'];
				}else{
					
					if($review_to == 'agency'){
						$review_data['review_by_user'] = $review_from;
						$review_data['agency_id'] = $agency_id;
					}else{
						$review_data['review_by_user'] = $review_from;
						$review_data['review_to_user'] = $review_to_user;
					}
					
					$review_data['added_date'] = date('Y-m-d');
					if($job_id){
						$review_data['project_id'] = $job_id;
					}
					
					$review_id = $this->review_model->addPublicRating($review_data);
					
					$notification_to = $review_to_user;
					$title = getField('title', 'jobs', 'job_id', $job_id);
					$link = 'dashboard/myfeedback';
					$parse_data = array(
						'TITLE' => $title
					);
					$notification = $this->notification_model->parseNotification('review_received', $parse_data);
					$this->notification_model->log($user_id, $notification_to, $notification, $link);
					
				}
				
				$json['status'] = 1;
				$json['review_id'] = $review_id;
				$json['msg'] = 'Review posted successfully';
				
				set_flash('succ_msg', $json['msg']);
				
			}else{
				$json = $validate;
			}
			
			
			
			echo json_encode($json);
			
		}
	}
	
	public function post_review_ajax(){
		$json = array();
		$json['status'] = 0;
		
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$validate = $this->_validateForm('post_review');
			
			if($validate['status'] == 1){
				$post = post();
				$review_from = $user_id;
				$review_to_user = filter_data(post('review_to_user'));
				$review_from_agency = filter_data(post('review_from_agency'));
				$review_to_agency = filter_data(post('review_to_agency'));
				$job_id = filter_data(post('job_id'));
				$agency_id = filter_data(post('agency_id'));
				$review_to = filter_data(post('review_to'));
				
				
				$where=array(
					'review_by_user' => $review_from,
					'review_to_user' => $review_to_user,
				);
				
				if($review_from_agency){
					$where['review_by_agency'] = $review_from_agency;
				}
				
				if($review_to_agency){
					$where['review_to_agency'] = $review_to_agency;
				}				
				/* if($review_to == 'agency'){
					$where=array(
						'review_by_user' => $review_from,
						'review_to_agency' => $review_to_agency,
					);
				}else{
					
				} */
				
				
				
				if($job_id){
					$where['project_id'] = $job_id;
				}else{
					$where['project_id'] = 0;
				}
				
				$review_data = filter_data(post('public'));
				
				$row = $this->db->where($where)->get('review_new')->row_array();
				if($row && $row['review_id']){
					$review_data['edited_date'] = date('Y-m-d');
					$update = $this->review_model->updatePublicRating($review_data, $row['review_id']);
					$review_id = $row['review_id'];
				}else{
					
					$review_data['review_by_user'] = $review_from;
					$review_data['review_to_user'] = $review_to_user;
					
					if($review_from_agency){
						$review_data['review_by_agency'] = $review_from_agency;
					}
					
					if($review_to_agency){
						$review_data['review_to_agency'] = $review_to_agency;
					}
					
					/* if($review_to == 'agency'){
						$review_data['review_by_user'] = $review_from;
						$review_data['agency_id'] = $agency_id;
					}else{
						$review_data['review_by_user'] = $review_from;
						$review_data['review_to_user'] = $review_to_user;
					} */
					
					$review_data['added_date'] = date('Y-m-d');
					if($job_id){
						$review_data['project_id'] = $job_id;
					}
					
					$review_id = $this->review_model->addPublicRating($review_data);
					
					$notification_to = $review_to_user;
					
					$link = 'dashboard/myfeedback';
					if(!$job_id){
						$key = 'public_review_received';
					}else{
						$key = 'review_received';
						$title = getField('title', 'projects', 'project_id', $job_id);
						$parse_data = array(
							'TITLE' => $title
						);
					}
					$notification = $this->notification_model->parseNotification($key, $parse_data);
					$this->notification_model->log($user_id, $notification_to, $notification, $link);
					
				}
				
				$json['status'] = 1;
				$json['review_id'] = $review_id;
				$json['msg'] = 'Review posted successfully';
				
				set_flash('succ_msg', $json['msg']);
				
				if(check_user_review($review_to_user, $job_id)){
					$review_where['review_by_user'] = $review_from;
					$review_where['review_to_user'] = $review_to_user;
					$review_where['project_id'] = $job_id;
					
					$review_where2['review_to_user'] = $review_from;
					$review_where2['review_by_user'] = $review_to_user;
					$review_where2['project_id'] = $job_id;
					
					
					$this->db->where($review_where)->update('review_new', array('view_status' => 1));
					$this->db->where($review_where2)->update('review_new', array('view_status' => 1));
					
				}
				
				$this->load->helper('project');
				if(is_employer($review_from, $job_id)){
					$template='review_freelancer';
					$freelancer_uname = getField('fname', 'user', 'user_id' , $review_to_user);
					$employer_name = getField('fname', 'user', 'user_id' , $review_from);
					$to_mail = getField('email', 'user', 'user_id' , $review_to_user);
				
				}else{
					$template='review_employer';
					$freelancer_uname = getField('fname', 'user', 'user_id' , $review_from);
					$employer_name = getField('fname', 'user', 'user_id' , $review_to_user);
					$to_mail = getField('email', 'user', 'user_id' , $review_to_user);
				}
				
				
				$data_parse=array( 'EMPLOYER'=>$employer_name, 'FREELANCER' => $freelancer_uname);
				send_layout_mail($template, $data_parse, $to_mail);
				
			}else{
				$json = $validate;
			}
			
			
			
			echo json_encode($json);
			
		}
	}
	
	private function _validateForm($section=''){
		
		$this->load->library('form_validation');
		
		$json = array();
		$json['status'] = 0;
		
		if($section == 'post_review'){
			$errors = array();
		
			$public = post('public');
			$comment = $public['comment'];
			$review_to_user = trim(post('review_to_user'));
			
			if(empty($comment)){
				$errors['comment'] = 'Required field';
			}
			
			if(empty($review_to_user)){
				$errors['review_to_user'] = 'Invalid data';
			}
			
			if(count($errors) > 0){
				$json['status'] = 0;
				$json['errors'] = $errors;
			}else{
				$json['status'] = 1;
			}
			
		}
		
		return $json;
	}

}
