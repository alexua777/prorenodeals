<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Jobfeed_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

	public function get_suggested_project($srch_param=array() , $limit=0 , $offset=40 , $for_list=TRUE){
		
		$project = $this->db->dbprefix('projects');
		$user = $this->db->dbprefix('user');
		$this->db->select("$project.*,$user.fname,$user.lname,$user.country,$user.city")->from('projects');
		$this->db->join("user", "$project.user_id = $user.user_id" , "INNER");
		$this->db->join("project_skill", "project_skill.project_id=projects.project_id" , "LEFT");
		
		$this->db->where("$project.visibility_mode", "Public");
		
		if(!empty($srch_param['skills'])){
			$this->db->where_in("project_skill.skill_id", $srch_param['skills']);
		}
		
		if(!empty($srch_param['ccode'])){
			$this->db->where("$user.country" , $this->db->escape_str($srch_param['ccode']));
		}
		
		
		if(!empty($srch_param['min'])){
			$this->db->where("$project.buget_min >=", $this->db->escape_str($srch_param['min']));
		}
		
		if(!empty($srch_param['max'])){
			$this->db->where("$project.buget_max <=" , $this->db->escape_str($srch_param['max']));
		}
		
		if(!empty($srch_param['q']) || !empty($srch_param['term'])){
			$term = !empty($srch_param['q']) ? $srch_param['q'] : $srch_param['term'];
			$term = $this->db->escape_like_str($term);
			$this->db->where("($project.title LIKE '%{$term}%' OR $project.description LIKE '%{$term}%')");
		}
		
		if(!empty($srch_param['posted']) AND $srch_param['posted'] != 'All'){
			$newdate=date('Y-m-d',strtotime("-".$srch_param['posted']." day",strtotime(date('Y-m-d'))));
			$this->db->where('post_date >=',$newdate);
		}
		
		$this->db->where(array("$project.status"=>'O',"$project.project_status"=>'Y'));
		$this->db->group_by("$project.project_id");				
		
		if(!empty($srch_param['sort_by']) && in_array($srch_param['sort_by'], array('new', 'old'))){			
			if($srch_param['sort_by'] == 'new'){				
				$this->db->order_by("$project.id" , "DESC");			
			}else if($srch_param['sort_by'] == 'old'){				
				$this->db->order_by("$project.id" , "ASC");			
			}		
		}else{			
			$this->db->order_by("$project.featured" , 'ASC');			
			$this->db->order_by("$project.id" , "DESC");		
		}	
		
		if($for_list){
			$result = $this->db->limit($offset , $limit)->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function count_user_suggested_project($user_id=''){
		$srch_param = array();
		$srch_param['skills'] = $this->get_user_skill_id($user_id);
		
		$project = $this->db->dbprefix('projects');
		$user = $this->db->dbprefix('user');
		$this->db->select("$project.project_id")->from('projects');
		$this->db->join("user", "$project.user_id = $user.user_id" , "INNER");
		$this->db->join("project_skill", "project_skill.project_id=projects.project_id" , "LEFT");
		
		$this->db->where("$project.visibility_mode", "Public");
		
		if(!empty($srch_param['skills'])){
			$this->db->where_in("project_skill.skill_id", $srch_param['skills']);
		}
		
		
		$this->db->where(array("$project.status"=>'O',"$project.project_status"=>'Y'));
		$this->db->group_by("$project.project_id");				
		
		
		$result = $this->db->get()->num_rows();
		
		return $result;
	}
	
	public function get_user_skill_id($user_id=''){
		$this->load->model('dashboard/dashboard_model');
		$skill = $this->dashboard_model->getuserskill($user_id);
		$skill_ids = array();
		if($skill){
			foreach($skill as $k => $v){
				$skill_ids[] = $v['sub_skill_id'];
			}
		}
		
		return $skill_ids;
	}
	
	

}