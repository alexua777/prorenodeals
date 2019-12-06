<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_notification_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	
	public function getNotificationList($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		
		$this->db->select("*")
				->from('admin_notification n');
				
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('n.noti_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	
}
