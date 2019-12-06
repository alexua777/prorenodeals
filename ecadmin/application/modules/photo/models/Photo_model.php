<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Photo_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
  /*  public function add_banner($data) {
       /* echo "<pre>";
				print_r($post_data);die;
        //$this->db->insert('advertisement', $data);
        $this->db->insert('advertisement', $data);
        return TRUE;
    }*/

    ///// Edit MENU ///////////////////////////////
   /* public function update_banner($post) {
        $data = array(
		    'id' => $post['id'],
            'type' => $post['type'],
			'link' => $post['link'],
            'order' => $post['order'],
            'status' => $post['status']
        );
		if (isset($post['image'])) {
            $data['image'] = $post['image'];
        }
        $this->db->where('id', $post['id']);
        $this->db->update('advertisement', $data);
		 /*if(($this->input->post('status')=='Y') AND ($this->input->post('type') !='index'))
        {
            $this->db->where("type", $this->input->post('type'));
            $this->db->update("advertisement", array("status"=>'N')); 
            
            $this->db->where("id",$post['id']);
            $this->db->update("advertisement", array("status"=>'Y'));
            
        }
        return TRUE;
	
    }*/
	
	public function record_count_photo() 
	{
        return $this->db->count_all('business_photo_gallery');
    }

    //// Delete Menu //////////////////////////////////
    public function delete_photo($id) {
        return $this->db->delete('business_photo_gallery', array('photo_id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getphotoList($business_id='',$limit='',$start='') {
        $this->db->select('*');
		$this->db->limit($limit,$start);
		if ($business_id!=''){
		$rs = $this->db->get_where('business_photo_gallery',array('business_id'=>$business_id));
        }
		else
		{
		$rs = $this->db->get('business_photo_gallery');
		}
		$data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'photo_id' => $row->photo_id,
				'business_name' =>$this->auto_model->getFeild('business_or_comp_name','listing_table','listing_id',$row->business_id),
				'photo_title' => $row->photo_title,
				'photo' => $row->photo,
				'status' => $row->status
            );
        }
        return $data;
     
   
    }
  
	public function updatephoto($data,$id)
	{
		$this->db->where('photo_id',$id);
		return $this->db->update('business_photo_gallery',$data);
	}
	
	
	
	
}