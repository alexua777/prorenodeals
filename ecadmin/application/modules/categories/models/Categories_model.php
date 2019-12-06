<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class categories_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
    public function add_category($data) {
        return $this->db->insert('categories', $data);
    }
	
	public function add_skill($data) {
        return $this->db->insert('skills', $data);
    }

    ///// Edit MENU ///////////////////////////////
    public function update_category($post,$id) {
        $this->db->where('cat_id', $id);
        return $this->db->update('categories', $post);
    }
	public function updateskill($post,$id) {
        $this->db->where('id', $id);
        return $this->db->update('skills', $post);
    }

    //// Delete Menu //////////////////////////////////
    public function delete_menu($id) {
        return $this->db->delete('categories', array('cat_id' => $id));
    }
	public function delete_skill($id) {
        return $this->db->delete('skills', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getCats() {
        $this->db->select('cat_id,cat_name,parent_id,icon_class,show_status,status');
        $this->db->order_by("cat_name", "ASC");
        $rs = $this->db->get_where('categories', array('parent_id' => '0'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'cat_id' => $row->cat_id,
                'cat_name' => $row->cat_name,
                'parent_id' => $row->parent_id,
                'icon_class' => $row->icon_class,
                'status' => $row->status,
                'show_status' => $row->show_status,
               /*  'childs' => $this->getChildCatsById($row->cat_id) */
                'childs' => array()
            );
        }
        return $data;
    }
	
	public function getSkills($cat_id="") {
        $this->db->select();
        $this->db->order_by("skill_name", "ASC");
        $rs = $this->db->get_where('skills', array('cat_id' => $cat_id));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'skill_name' => $row->skill_name,
                'cat_id' => $row->cat_id,
                'status' => $row->status
            );
        }
        return $data;
    }

    /// Menu list  ///////////////////////////////
    /// Get Child menu list ////////////////////////////
    public function getChildCatsById($id) {
        $this->db->select('cat_id,cat_name,parent_id,icon_class,show_status,status');
        $rs = $this->db->get_where('categories', array('parent_id' => $id));
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
		$this->db->where('cat_id',$id);
		return $this->db->update('categories',$data);
		
	} 
	
	

}
