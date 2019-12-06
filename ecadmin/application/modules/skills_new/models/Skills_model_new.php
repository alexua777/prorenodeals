<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Skills_model_new extends BaseModel {

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
    public function getCats($srch=array()) {
       $this->db->select('*');
        $this->db->order_by("id", "desc");
		/* $this->db->limit(50); */
		if(!empty($srch['cat_id'])){
			$this->db->where('cat_id', $srch['cat_id']);
		}
		$rs = $this->db->get_where('skills');
		
        $data = array();		
        foreach ($rs->result_array() as $k => $row) {						
		$data[$k] = $row;			
		$data[$k]['cat_name'] = getField('cat_name', 'categories', 'cat_id', $row['cat_id']);		
		/* $data[$k]['childs'] = $this->getChildCatsById($row['id']); */
		$data[$k]['childs'] = array();
        }
        return $data;
		
		/* $data = $this->db->limit(50)->get('skills')->result_array(); */
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
		/*	echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('skills',$data);
		
	} 
	
	

}
