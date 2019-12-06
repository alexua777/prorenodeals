<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_support_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function get_support_list($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select("u_s.*,concat(u.fname,' ',u.lname) as full_name", FALSE)
				->from('user_support u_s')
				->join('user u', 'u.user_id=u_s.user_id', 'LEFT');
				
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('u_s.id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function get_detail($id){
		$this->db->select("u_s.*,concat(u.fname,' ',u.lname) as full_name", FALSE)
				->from('user_support u_s')
				->join('user u', 'u.user_id=u_s.user_id', 'LEFT');
		$this->db->where('id', $id);
		
		$detail = $this->db->get()->row_array();
		return $detail;
	}
}
