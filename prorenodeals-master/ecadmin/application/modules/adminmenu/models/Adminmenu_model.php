<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class adminmenu_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

    ////// ADD MENU///////////////////////////////
    public function add_menu($data) {
        return $this->db->insert('adminmenu', $data);
    }

    ///// Edit MENU ///////////////////////////////
    public function update_menu($post,$id) {
        $this->db->where('id', $id);
        return $this->db->update('adminmenu', $post);
    }

    //// Delete Menu //////////////////////////////////
    public function delete_menu($id) {
        return $this->db->delete('adminmenu', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getMenus() {
        $this->db->select('id,name,url,parent_id,status,ord,title');
        $this->db->order_by("ord", "asc");
        $rs = $this->db->get_where('adminmenu', array('parent_id' => '0'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'title' => $row->title,
                'url' => $row->url,
                'parent_id' => $row->id,
                'status' => $row->status,
                'ord' => $row->ord,
                'childs' => $this->getChildMenusById($row->id)
            );
        }
        return $data;
    }

    /// Menu list  ///////////////////////////////
    /// Get Child menu list ////////////////////////////
    public function getChildMenusById($id) {
        $this->db->select('id,name,url,parent_id,status,ord,title');
        $rs = $this->db->get_where('adminmenu', array('parent_id' => $id));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
	public function updateadmin($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('adminmenu',$data);
		
	} 
	
	

}
