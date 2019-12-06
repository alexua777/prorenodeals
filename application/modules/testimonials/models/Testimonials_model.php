<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonials_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	public function getTestimonials(){
		$this->db->select('id,name,description,posted_date,image');
		$this->db->from('testimonial');
		$rs = $this->db->get();
		
		$data =  array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
					'id' => $row->id,
					'name' => $row->name,
					'description' => $row->description,
					'image' => $row->image,
					'posted_date' => $row->posted_date
				);
		}
			//echo '<pre>';
			//print_r($data); die;
			return $data;
	}

}
