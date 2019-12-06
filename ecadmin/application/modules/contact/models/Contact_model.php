<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
 	
	public function record_count_contact() 
	{
     return $this->db->count_all('contact');
    }

    //// Delete Menu //////////////////////////////////
    public function delete_contact($id) {
        return $this->db->delete('contact', array('contact_id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getcontactList($limit='',$start='') {
        $this->db->select('*');
		$this->db->order_by('contact_date');
		$this->db->limit($limit,$start);
		$rs = $this->db->get('contact');
        $data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->contact_id,
				'name' => $row->contact_name,
				'subject' => $row->contact_subject,
				'email' => $row->contact_email,
				'ticket'=>$row->contact_ticket,
                'comments' => $row->contact_message,
				'add_date' => $row->contact_date,
                'status' => $row->is_red_by_admin
            );
        }
        return $data;
     }
   
   public function updatecons($data,$id)
	{
		
		$this->db->where('contact_id',$id);
		return $this->db->update('contact',$data);
		
	
	}

}