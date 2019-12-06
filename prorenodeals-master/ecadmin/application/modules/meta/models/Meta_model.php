<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Meta_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	////// ADD cms///////////////////////////////
	public function add_meta($data){
		$new_data = array(
               'pagename' => $data['pagename'],
			   'meta_title' => $data['meta_title'],
			   'meta_desc' => $data['meta_desc'],
			   'meta_keys' => $data['meta_keys'],
			   'status' => $data['status']);
	 	return $this->db->insert('meta',$new_data);
	}
	
	public function record_count_meta() 
	{
        return $this->db->count_all('meta');
    }
	
	///// Edit cms ///////////////////////////////
	public function update_meta($post){
		$data = array(
               'pagename' => $post['pagename'],
			   'meta_title' => $post['meta_title'],
			   'meta_desc' => $post['meta_desc'],
			   'meta_keys' => $post['meta_keys'],
			   'status' => $post['status']);
		$this->db->where('id', $post['id']);
		return $this->db->update('meta', $data); 
	}
	
	
	
	
	//// Delete cms //////////////////////////////////
	public function delete_meta($id){
		return $this->db->delete('meta', array('id' => $id)); 
	}
	
/*	public function getpagename() {
        $this->db->select('id,pagename,status');
        $this->db->order_by("id", "asc");
        $rs = $this->db->get_where('meta', array('status' => 'Y'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'pagename' => $row->pagename,
                'status' => $row->status
            );
        }
        return $data;
	}*/
	
	
	
	/// Get country list ////////////////////////////
	public function getmeta($limit='',$start=''){
	    $this->db->limit($limit,$start);
		$rs=$this->db->get('meta');
	
		 $data = array();
		 
		 foreach ($rs->result() as $row){
		  $data[]= array(
		  			'id' => $row->id,
					'pagename' => $row->pagename,
					'meta_title' => $row->meta_title,
					'status' => $row->status);
		 }
		 return $data;
	}

	public function updatemeta($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('meta',$data);
		
	}

}
