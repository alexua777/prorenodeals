<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Partner_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllPartnerList()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get('partner');
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'url' => $row->url,
				'image' => $row->image,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";*/
		//print_r($data);die;
		return $data;
	}
	
	public function add($data)
	{
		return $this->db->insert('partner',$data);
		//echo $this->db->last_query();die;
	}
	
	public function updatePartner($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('partner',$data);
	
	}
	

	
	public function deletepartner($id)
	{
		return $this->db->delete('partner', array('id' => $id)); 
	
	}
	public function getAllPartnerListbyId($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('partner',array("id"=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'url' => $row->url,
				'image' => $row->image,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";*/
		//print_r($data);die;
		return $data;
	}
	
	public function getDesignation()
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

}
