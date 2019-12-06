<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class references_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function add($data)
	{
		$this->db->insert('references',$data);
		return $this->db->insert_id();
		//echo $this->db->last_query();die;
	}
	
	public function add_feedback($data)
	{
		return $this->db->insert('referer_review',$data);
		//echo $this->db->last_query();die;
	}
	public function updateTable($table,$data,$by,$value)
	{
		$this->db->where($by,$value);
		return $this->db->update($table,$data);
	}
	public function allReferences($user_id)
	{
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$this->db->order_by('name','asc');
		$res=$this->db->get_where('references',array('status'=>'Y'));
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'id' => $row->id,
			'name' => $row->name,
			'company' => $row->company,
			'contact_name' =>$row->contact_name,
			'email' =>$row->email,
			'phone_no' =>$row->phone_no,
			'rating_status' =>$row->rating_status,
			'admin_review' =>$row->admin_review 
			);	
		}
		return $data;	
	}
	
	public function countReference($user_id)
	{
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$this->db->from('references');
		return $this->db->count_all_results();
	}
	
	public function getReferenceById($id)
	{
		$this->db->select('user_id,name');
		$this->db->where('id',$id);
		$res=$this->db->get('references');
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'user_id' => $row->user_id,
			'name' => $row->name
			);	
		}
		return $data;	
	}
	public function getReview($refer_id,$user_id)
	{
		$this->db->select();
		$this->db->where('refer_id',$refer_id);
		$this->db->where('user_id',$user_id);
		$res=$this->db->get('referer_review');
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'safety'=>$row->safety,
			'flexiblity'=>$row->flexiblity,
			'performence'=>$row->performence,
			'initiative'=>$row->initiative,
			'knowledge'=>$row->knowledge,
			'average'=>$row->average,
			'comments'=>$row->comments
			);	
		}
		return $data;
	}


}
