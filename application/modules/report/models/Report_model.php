<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
	public function add_spam($user_id=null, $type='USER', $obj_id='0'){
		$data = array(
			'obj_id' => $obj_id,
			'obj_type' => $type,
			'user_id' => $user_id,
			'date' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('report_spam', $data);
		
		if($type == 'USER'){
			$this->db->set('spam', 'spam+1', FALSE)->where('user_id', $obj_id)->update('user');
		}else if($type == 'PROJECT'){
			$this->db->set('spam', 'spam+1', FALSE)->where('project_id', $obj_id)->update('projects');
		}
	}
	
	public function add_abuse($user_id=null, $type='USER', $obj_id='0'){
		$data = array(
			'obj_id' => $obj_id,
			'obj_type' => $type,
			'user_id' => $user_id,
			'date' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('report_abuse', $data);
		/* get_print($this->db->last_query()); */
		
		if($type == 'USER'){
			$this->db->set('abuse', 'abuse+1', FALSE)->where('user_id', $obj_id)->update('user');
		}else if($type == 'PROJECT'){
			$this->db->set('abuse', 'abuse+1', FALSE)->where('project_id', $obj_id)->update('projects');
		}
	}
	
	
	public function is_abuse($obj_id='0', $type='USER'){
		$user = $this->session->userdata('user');
		$login_user = $user[0]->user_id;
		
		$count = (bool) $this->db->where(array('obj_id' => $obj_id, 'obj_type' => $type, 'user_id' => $login_user))->count_all_results('report_abuse');
		return $count;
	}
	
	public function is_spam($obj_id='0', $type='USER'){
		$user = $this->session->userdata('user');
		$login_user = $user[0]->user_id;
		
		$count = (bool) $this->db->where(array('obj_id' => $obj_id, 'obj_type' => $type, 'user_id' => $login_user))->count_all_results('report_spam');
		return $count;
	}
	

}
