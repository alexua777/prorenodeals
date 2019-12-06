<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

  /**
  ***    Add event
  */
    public function add_event($data) {
        return $this->db->insert('event', $data);
    }

    public function update_event($post) {
/*        $data = array(
            'state_name' => $post['state_name'],
            'order_id' => $post['order_id'],
            'country_id' => $post['country_id'],
            'status' => $post['status']);*/
        $this->db->where('event_id', $post['id']);
        return $this->db->update('event', $post);
    }

    
	public function record_count_event() 
	{
        return $this->db->count_all('event');
    }
	
	
	
	
    //// Delete state //////////////////////////////////
    public function delete_event($id) {
        return $this->db->delete('event', array('event_id' => $id));
    }

    /// Get Event list ////////////////////////////
    
        public function getstate($limit='',$start='') {
        $this->db->select('*');
        $this->db->order_by("event_id", "desc");
		$this->db->limit($limit,$start);
        $rs = $this->db->get_where('event', array());
        //$rs = $this->db->from('state');
        $data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'event_id' => $row->event_id,
                'event_name' => $row->event_name,
				'created' => $row->created,
                'status' => $row->status);
        }
        return $data;
    }
	
    /// Get Category list ////////////////////////////

    
    	public function getAllevent($id)
	{
		$this->db->select('*');
		$this->db->order_by('event_id','desc');
		$rs = $this->db->get_where('event',array('event_id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data = array(
                                'event_id' => $row->event_id,
								
                                'event_name' => $row->event_name,
                                
                                'event_desc' => $row->event_desc,
                                'start_date' => $row->start_date,
                                'end_date' => $row->end_date,
								
                                'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
    
    
	
	public function updateevent($data,$id)
	{
		$this->db->where('event_id',$id);
		return $this->db->update('event',$data);
		
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
