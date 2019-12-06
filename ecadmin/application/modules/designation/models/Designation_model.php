<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Designation_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllDesignationList()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get('designation');
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'designation' => $row->designation,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";*/
		//print_r($data);die;
		return $data;
	}
	
	public function add($data)
	{
		return $this->db->insert('designation',$data);
		//echo $this->db->last_query();die;
	}
	
	public function updateDesignation($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('designation',$data);
		
	
	}
	

	
	public function deleteDesignation($id)
	{
		return $this->db->delete('designation', array('id' => $id)); 
	
	}
	public function getAllDesignationListbyId($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('designation',array("id"=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'designation' => $row->designation,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";*/
		//print_r($data);die;
		return $data;
	}
	


}
