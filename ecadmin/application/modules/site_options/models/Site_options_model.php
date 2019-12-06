<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_options_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
 

    
	////// ADD sitemap///////////////////////////////
	public function add_sitemap($data){
	 	return $this->db->insert('setting_option',$data);
	}
	
	///// Edit sitemap ///////////////////////////////
	public function update_setting_option($post){
		$data = array(
               'setting_value' => $post['setting_value']);
		$this->db->where('option_id', $post['option_id']);
		return $this->db->update('setting_option', $data); 
		
	}
    /* public function record_count_sitemap() 
	{
        return $this->db->count_all('sitemap');
    } */
	

	//// Delete sitemap //////////////////////////////////
	/* public function delete_sitemap($id){
		return $this->db->delete('sitemap', array('id' => $id)); 
	} */
	

	/// Get setting_option list ////////////////////////////
	public function getsiteoptions(){
	    $this->db->where('is_editable', '1');
		$rs=$this->db->get('setting_option');
		
		$data = array();
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
