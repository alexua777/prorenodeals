<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_abuse_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	
	public function get_project_list($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select('p.project_id,p.title,p.post_date,u.username,p.status,p.id as p_id,p.project_status as projectstatus,p.abuse')
			->from('projects p')
			->join('user u', 'u.user_id=p.user_id', 'LEFT')
			->join('report_abuse a_b', "a_b.obj_id = p.project_id AND a_b.obj_type='PROJECT'", 'INNER');

		$this->db->group_by('p.project_id');
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a_b.id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	public function get_user_list($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select('u.user_id,u.username,u.fname,u.lname,u.logo,u.account_type,u.verify,u.abuse')
			->from('user u')
			->join('report_abuse a_b', "a_b.obj_id = u.user_id AND a_b.obj_type='USER'", 'INNER');
		
		$this->db->group_by('u.user_id');
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('a_b.id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
		
	}
	
	
	
}
