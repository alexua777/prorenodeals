<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cms_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	////// ADD cms///////////////////////////////
	public function add_cms($data){
		$new_data = array(
               'cont_title' => $data['cont_title'],
               'pagename' => $data['pagename'],
			   'contents' => htmlentities($data['contents']),
			   'meta_title' => $data['meta_title'],
			   'meta_desc' => $data['meta_desc'],
			   'meta_keys' => $data['meta_keys'],
			   'status' => $data['status']);
	 	return $this->db->insert('content',$new_data);
	}
	
	public function record_count_cms() 
	{
        return $this->db->count_all('content');
    }
	
	///// Edit cms ///////////////////////////////
	public function update_cms($post){
		$data = array(
               'cont_title' => $post['cont_title'],
               'pagename' => $post['pagename'],
			   'contents' => htmlentities($post['contents']),
			   'meta_title' => $post['meta_title'],
			   'meta_desc' => $post['meta_desc'],
			   'meta_keys' => $post['meta_keys'],
			   'status' => $post['status']);
		$this->db->where('id', $post['id']);
		return $this->db->update('content', $data); 
	}
	
	
	
	
	//// Delete cms //////////////////////////////////
	public function delete_cms($id){
		return $this->db->delete('content', array('id' => $id)); 
	}
	
	
	
	
	
	
	/// Get country list ////////////////////////////
	public function getcontents($limit='',$start=''){
	    $this->db->limit($limit,$start);
            $this->db->order_by("id","desc");
		$rs=$this->db->get('content');
	
		 $data = array();
		 
		 foreach ($rs->result() as $row){
		  $data[]= array(
		  			'id' => $row->id,
					'cont_title' => $row->cont_title,
					'pagename' => $row->pagename,
					'status' => $row->status);
		 }
		 return $data;
	}

	public function updatecms($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('content',$data);
		
	}

}
