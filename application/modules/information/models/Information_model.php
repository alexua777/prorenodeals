<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Information_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }


   	
	public function getinfo($page_id = '')
	{
		$this->db->select('id,cont_title,contents');
		$rs = $this->db->get_where('content',array('status'=>'Y','pagename'=>$page_id));
		
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'page_id' => $row->id,
                'content_title' => $row->cont_title,
                'contents' => $row->contents
				);
		}
		//echo $this->db->last_query();
		//die();
		return $data;
	   
	}
}