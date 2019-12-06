<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class testimonial_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function add($data)
	{
		return $this->db->insert('testimonial',$data);
		//echo $this->db->last_query();die;
	}


}
