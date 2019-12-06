<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Document_type_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	
	public function getList($srch=array(), $offset=100, $limit=0, $for_list=TRUE){
		$this->db->select('*')
				->from('document_type');
				
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('document_type_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
	}
}
