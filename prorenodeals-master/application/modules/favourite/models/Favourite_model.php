<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Favourite_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

	
	public function getFavouriteProject($uid=''){
		if(empty($uid)){
			return FALSE;
		}
		$this->db->select('p.project_id,p.id,p.title,p.description,p.category,p.project_type,p.user_id')
				->from('projects p')
				->join("favorite f" , "f.object_id = p.project_id AND f.type = 'JOB'", "INNER");
		if(!empty($uid)){
			$this->db->where('f.user_id' , $uid);
		}
		$result = $this->db->order_by('f.id' , 'DESC')->get()->result_array();
		//print_r($result);
		return $result;
	}
	
	
	public function getFavouriteFreelancer($uid=''){
		if(empty($uid)){
			return FALSE;
		}
		$this->db->select('u.fname,u.lname,u.slogan,u.user_id,u.country,u.reg_date,u.overview')
				->from('user u')
				->join("favorite f" , "f.object_id = u.user_id AND f.type = 'FREELANCER'", "INNER");
		if(!empty($uid)){
			$this->db->where('f.user_id' , $uid);
		}
		$result = $this->db->order_by('f.id' , 'DESC')->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$result[$k]['logo_url'] = get_user_logo($v['user_id']);
				$result[$k]['user_rating'] = get_user_rating($v['user_id']);
				$result[$k]['full_name'] = $v['fname'].' '.$v['lname'];
				$result[$k]['review_count'] = $this->get_review_count($v['user_id']);
				$result[$k]['completed_project'] = get_freelancer_project($v['user_id'], 'C');
				
			}
			
		}
		
		return $result;
	}

	public function get_hired_users($uid=''){
		if(empty($uid)){
			return FALSE;
		}
		$this->db->select('u.fname,u.lname,u.slogan,u.user_id,u.country,u.city,p.title,p.project_id,p.hire_date')
				->from('projects p')
				->join("user u" , "u.user_id = p.bidder_id", "INNER");
				
		$this->db->where('p.user_id' , $uid);
		
		$result = $this->db->order_by('p.project_id' , 'DESC')->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$result[$k]['logo_url'] = get_user_logo($v['user_id']);
				$result[$k]['user_rating'] = get_user_rating($v['user_id']);
				$result[$k]['full_name'] = $v['fname'].' '.$v['lname'];
				$result[$k]['hired_date'] = $v['hire_date'];
				$result[$k]['review_count'] = $this->get_review_count($v['user_id']);
				$result[$k]['project_link'] = base_url('jobdetails/details/'.$v['project_id']);
				$result[$k]['profile_link'] = base_url('clientdetails/showdetails/'.$v['user_id']);
			}
			
		}
		
		return $result;
	}

	public function get_invited_users($uid=''){
		if(empty($uid)){
			return FALSE;
		}
		$this->db->select('u.fname,u.lname,u.slogan,u.user_id,u.country,u.city,i.date as invitation_date,p.title,p.project_id')
				->from('new_inviteproject i')
				->join("projects p" , "p.project_id = i.project_id", "LEFT")
				->join("user u" , "u.user_id = i.freelancer_id", "INNER");
				
		$this->db->where('i.employer_id' , $uid);
		
		$result = $this->db->order_by('i.id' , 'DESC')->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$result[$k]['logo_url'] = get_user_logo($v['user_id']);
				$result[$k]['user_rating'] = get_user_rating($v['user_id']);
				$result[$k]['full_name'] = $v['fname'].' '.$v['lname'];
				$result[$k]['review_count'] = $this->get_review_count($v['user_id']);
				$result[$k]['project_link'] = base_url('jobdetails/details/'.$v['project_id']);
				$result[$k]['profile_link'] = base_url('clientdetails/showdetails/'.$v['user_id']);
			}
			
		}
		
		return $result;
	}
	
	public function get_review_count($user_id=''){
		$this->db->where('view_status', 1);
		return $this->db->where('review_to_user', $user_id)->count_all_results('review_new');
	}
	
}