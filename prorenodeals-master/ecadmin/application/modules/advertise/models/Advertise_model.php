<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertise_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

  /**
  ***    Add event
  */
    public function add_advartise($data) {
        return $this->db->insert('advartise', $data);
    }

    public function update_event($post) {
	
        $this->db->where('id', $post['id']);
        return $this->db->update('advartise', $post);
    }

    
	public function record_count_event() 
	{
        return $this->db->count_all('advartise');
    }
	
	
	
	
    //// Delete state //////////////////////////////////
    public function delete_event($id) {
        return $this->db->delete('advartise', array('id' => $id));
    }

    /// Get Event list ////////////////////////////
    
        public function getstate($limit='',$start='') 
		{
        $this->db->select('*');
        $this->db->order_by("id", "asc");
		$this->db->limit($limit,$start);
        $rs = $this->db->get_where('advartise', array());
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'advertise_name' => $row->advertise_name,
				'page_name' => $row->page_name,
				'advartise_image' => $row->advartise_image,
				'add_pos' => $row->add_pos,
				'advartise_description' => $row->advartise_description,
                'add_date' => $row->add_date,
				'status' => $row->status
				);
        }
        return $data;
    }
	
    /// Get Category list ////////////////////////////

    
    	public function getAllevent($id)
		{
		$this->db->select('*');
		$rs = $this->db->get_where('advartise',array('id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data = array(
				'id' => $row->id,
				'advertise_name' => $row->advertise_name,
				'page_name' => $row->page_name,
				'advartise_image' => $row->advartise_image,
				'add_pos' => $row->add_pos,
				'advartise_description' => $row->advartise_description,
				'add_date' => $row->add_date,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
    
    
	
	public function updateevent($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('advartise',$data);
		
	}
        /////////Get Category ///////////
        
     public function getEventCategory()
	{
		$this->db->select('*');
		$this->db->order_by('cat_id','desc');
		$rs = $this->db->get_where('category',array('type'=>'E'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'cat_id' => $row->cat_id,
				'cat_name' => $row->cat_name,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
        
	public function getAllCategory($type)
	{
		$this->db->select('*');
		$this->db->order_by('cat_id','desc');
		$rs = $this->db->get_where('category',array('type'=>$type));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'cat_id' => $row->cat_id,
				'cat_name' => $row->cat_name,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	
	

}
