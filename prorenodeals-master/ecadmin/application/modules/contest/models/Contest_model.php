<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	
	public function getContestList($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$entries = $this->db->dbprefix("contest_entry");
		$this->db->select("c.*, (select count(entry_id) from $entries where contest_id = c.contest_id) as total_entries")
				->from('contest c');
				
		if(!empty($srch['title'])){
			$this->db->like('c.title', trim($srch['title']));
		}
		
		if(!empty($srch['status'])){
			$this->db->where('c.status', $srch['status']);
		}
		
		if(isset($srch['is_guranteed']) && $srch['is_guranteed'] != ''){
			$this->db->where('c.is_guranteed', $srch['is_guranteed']);
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('c.contest_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getContestEntries($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$review_new = $this->db->dbprefix("review_new");
			$this->db->select("c_e.*,u.fname,u.lname,(select avg(average) from $review_new where review_to_user=c_e.user_id) as user_review")
				->from('contest_entry c_e')
				->join('user u', 'u.user_id=c_e.user_id', 'LEFT');
				
		$this->db->where('c_e.contest_id', $srch['contest_id']);
		
		if(!empty($srch['entry_id'])){
			$this->db->where('c_e.entry_id', $srch['entry_id']);
		}
		
		if(!empty($srch['name'])){
			$srch['name'] = trim($srch['name']);
			$this->db->where("concat(u.fname,' ',u.lname) LIKE '%{$srch['name']}%'");
		}
		
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('c_e.entry_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
	}
	
	public function getComments($contest_id=''){
		$this->db->select('c.*')
			->from('contest_comment cc')
			->join('comments c', 'c.comment_id=cc.comment_id');
			
		$this->db->where('cc.contest_id', $contest_id);
		$result = $this->db->order_by('c.comment_id', 'DESC')->get()->result_array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$result[$k]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $v['user_id'])->get()->row_array();
			}
		}
		
		return $result;
	}
	
	public function getEntryComments($entry_id=''){
		$this->db->select('c.*')
			->from('entry_comment ec')
			->join('comments c', 'c.comment_id=ec.comment_id');
			
		$this->db->where('ec.entry_id', $entry_id);
		$result = $this->db->order_by('c.comment_id', 'ASC')->get()->result_array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$result[$k]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $v['user_id'])->get()->row_array();
			}
		}
		
		return $result;
	}
	
	
}
