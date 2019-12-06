<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Testimonial_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllTestimonialList()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get('testimonial');
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'user_id' => $row->user_id,
				'description' => $row->description,
				'posted_date'=>$row->posted_date,
				'status' => $row->status
			);
			
		}
		
		return $data;
	}
	
	public function add($data)
	{
		return $this->db->insert('testimonial',$data);
		//echo $this->db->last_query();die;
	}
	
	public function updateTestimonial($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('testimonial',$data);
	
	}
	

	
	public function deleteTestimonial($id)
	{
		return $this->db->delete('testimonial', array('id' => $id)); 
	
	}
	public function getAllTestimonialListbyId($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('testimonial',array("id"=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'user_id' => $row->user_id,
				'description' => $row->description,
				'posted_date'=>$row->posted_date,
				'status' => $row->status
			);
			
		}
		
		return $data;
	}
	
	public function getallUser()
	{
		$this->db->select('*');
		$this->db->order_by('user_id','desc');
		$rs = $this->db->get_where('user',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'user_id' => $row->user_id,
				'name' => $row->fname." ".$row->lname
			);
			
		}
		return $data;
	}

}
