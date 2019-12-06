<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Newsletter_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	////// ADD cms///////////////////////////////
	public function add($data){
		$new_data = array(
               'position' => $data['position'],
			   'image' => $data['image'],
               'overview' => htmlentities($data['overview']),
			   'responsiblity' => htmlentities($data['responsiblity']),
			   'qualification' => htmlentities($data['qualification']),
			   'extra' => htmlentities($data['extra']),
			   'compensation' => htmlentities($data['compensation']),
			   'contact' => htmlentities($data['contact']),
			   'status' => $data['status'],
			   'posted' => date('Y-m-d'));
	 	return $this->db->insert('career',$new_data);
	}
	
	public function record_count_cms() 
	{
        return $this->db->count_all('career');
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
	public function deleteCareer($id){
		return $this->db->delete('career', array('id' => $id)); 
	}
	
	
	
	
	
	
	/// Get country list ////////////////////////////
	public function getCareer($limit='',$start=''){
	    $this->db->limit($limit,$start);
		$rs=$this->db->get('career');
	
		 $data = array();
		 
		 foreach ($rs->result() as $row){
		  $data[]= array(
		  			'id' => $row->id,
					'position' => $row->position,
					'image' => $row->image,
					'status' => $row->status);
		 }
		 return $data;
	}

	public function updateCareer($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('career',$data);
		
	}

}
