<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
 

    /* public function leftPannel() {
	     $result = array();
		 $this->db->select();
		 $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => 0));
		 $i = 0;
	     foreach ($query->result() as $row)
          {
		  $i++;
		     $result[$i]['id'] = $row->id;
             $result[$i]['name'] = $row->name;
			 $result[$i]['url'] = $row->url;
			 $result[$i]['parent_id'] = $row->parent_id;
			 $result[$i]['status'] = $row->status;
          }
		 return $result;
    }
	public function leftpanelchild($id) {	
		 $result = array();
		 $this->db->select();
		 $query = $this->db->get_where("adminmenu", array("status" => 'Y', "parent_id" => $id));
		 $i = 0;
	     foreach ($query->result() as $row)
          {
		  $i++;
		     $result[$i]['id'] = $row->id;
             $result[$i]['name'] = $row->name;
			 $result[$i]['url'] = $row->url;
			 $result[$i]['parent_id'] = $row->parent_id;
			 $result[$i]['status'] = $row->status;
          }
		 return $result;
	}*/
	
	////// ADD sitemap///////////////////////////////
	public function add_sitemap($data){
	 	return $this->db->insert('sitemap',$data);
	}
	
	///// Edit sitemap ///////////////////////////////
	public function update_sitemap($post){
		$data = array(
               'name' => $post['name'],
               'url' => $post['url']);
		$this->db->where('id', $post['id']);
		return $this->db->update('sitemap', $data); 
		
	}
    public function record_count_sitemap() 
	{
        return $this->db->count_all('sitemap');
    }
	

	//// Delete sitemap //////////////////////////////////
	public function delete_sitemap($id){
		return $this->db->delete('sitemap', array('id' => $id)); 
	}
	

	/// Get sitemap list ////////////////////////////
	public function getsitemap($limit='',$start=''){
	    $this->db->limit($limit,$start);
		$rs=$this->db->get('sitemap');
		
		$data = $rs->result_array();
		return $data;
		
	}
	

	
	
	
	public function getfield($select,$table,$feild,$value){
		$this->db->select($select);	
		$rs = $this->db->get_where($table,array($feild=>$value));
		 $data = '';
		 foreach ($rs->result() as $row){
		  $data = $row->$select;
		 }
		 return $data;
		
	}
	
	

}
