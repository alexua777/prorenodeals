<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class home_skills_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
    public function add_skill($data) {
        return $this->db->insert('skills', $data);
    }

    ///// Edit MENU ///////////////////////////////
    public function update_category($post,$id) {
        $this->db->where('id', $id);
        return $this->db->update('skills', $post);
    }

    //// Delete Menu //////////////////////////////////
    public function delete_menu($id) {
        return $this->db->delete('skills', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getCats() {
        $this->db->select('id,skill_name,parent_id,status,show_status');
        $this->db->order_by("id", "desc");
        $rs = $this->db->get_where('skills', array('parent_id' => '0'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'skill_name' => $row->skill_name,
                'parent_id' => $row->parent_id,
                'status' => $row->status,
                'show_status' => $row->show_status
            );
        }
        return $data;
    }

    /// Menu list  ///////////////////////////////
    /// Get Child menu list ////////////////////////////
    public function getChildCatsById($id) {
        $this->db->select('id,skill_name,parent_id,status');
        $rs = $this->db->get_where('skills', array('parent_id' => $id));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
	public function updatecategory($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('skills',$data);
		
	} 
	
	

}
