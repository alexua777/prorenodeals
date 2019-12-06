<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function addPublicRating($data=array()){
		$this->db->insert('review_new', $data);
		$ins_id = $this->db->insert_id();
		return $ins_id;
	}

	public function updatePublicRating($data=array(), $id=''){
		return $this->db->where('review_id', $id)->update('review_new', $data);
	}
}
