<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Teams_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllTeamList()
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get('team');
		$data = array();
		foreach($rs->result() as $row)
		{
		$rss=$this->db->get_where('designation',array('id'=>$row->role));
		$al=$rss->row();
		 $data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'role' => $al->designation,
				'description' => $row->description,
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
		return $this->db->insert('team',$data);
		//echo $this->db->last_query();die;
	}
	
	public function updateTeam($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('team',$data);
	
	}
	

	
	public function deleteTeam($id)
	{
		return $this->db->delete('team', array('id' => $id)); 
	
	}
	public function getAllTeamListbyId($id)
	{
		$this->db->select('*');
		$rs = $this->db->get_where('team',array("id"=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
		 $data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'role' => $row->role,
				'description' => $row->description,
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
