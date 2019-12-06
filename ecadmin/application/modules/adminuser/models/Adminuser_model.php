<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Adminuser_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllUserList($limit = '', $start = '')
	{
		$this->db->select('*');
		$this->db->order_by('admin_id','desc');
		$this->db->limit($limit, $start);
		$rs = $this->db->get('admin');
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'admin_id' => $row->admin_id,
				'username' => $row->username,
				'email' => $row->email,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		
		return $data;
	}
	public function getfilterFaqList($qstn,$limit = '', $start = '')
	{
		$this->db->select('*');
		$this->db->like('title',$qstn);
		$this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
		$rs = $this->db->get('knowledge');
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'id' => $row->id,
				'title' => $row->title,
				'content' => $row->content,
				'knowledge_type' => $row->knowledge_type,
				'order'=> $row->order,
				'status' => $row->status
			);
			
		}
		
		return $data;
	}
	
	public function countFaq($qstn)
	{
		$this->db->select('id');
		$this->db->like('title',$qstn);
		$this->db->from('knowledge');
		
		return $this->db->count_all_results();
	}
	
	public function add_user($data)
	{
		return $this->db->insert('admin',$data);

	}
	
	public function updateUser($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('admin_id',$id);
		return $this->db->update('admin',$data);
		
	
	}
	
	public function getAPerticulerFooterDataUsingId($id)
	{
		$this->db->select('*');
		
		$rs = $this->db->get_where('admin',array('admin_id'=>$id));
		$data = array();
		$gl=$rs->row();
			$data = array(
				'admin_id' => $gl->admin_id,
				'username' => $gl->username,
				'name' => $gl->name,
				'email' => $gl->email,
				'type' => $gl->type,
				'image' => $gl->image,
				'status' => $gl->status
			);
			
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	
	public function getAllSearchData($usr_select,$search_element,$id)
	{
		$this->db->select('*');
		$this->db->order_by('ord','asc');
		if($usr_select == 'footer_id')
			$this->db->like($usr_select, trim($search_element), 'none'); 
		else
			$this->db->like($usr_select, trim($search_element), 'after'); 
			
		$rs = $this->db->get_where('footer_management',array('footer_parent_id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'footer_id' => $row->footer_id,
				'footer_cat_name' => $row->footer_cat_name,
				'footer_parent_id' => $row->footer_parent_id,
				'footer_link' => $row->footer_link,
				'ord' => $row->ord,
				'footer_status' => $row->footer_status
			);
		}
		return $data;
			
	}
	
	public function deleteUser($id)
	{
		return $this->db->delete('admin', array('admin_id' => $id)); 
	
	}
	
	public function getAllCategory($type)
	{
		$this->db->select('*');
		$this->db->order_by('cat_id','desc');
		$rs = $this->db->get_where('category',array('type'=>$type));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'cat_id' => $row->cat_id,
				'cat_name' => $row->cat_name,
				'type' => $row->type,
				'status' => $row->status
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	public function getCats() {
        $this->db->select('id,name,status');
        $this->db->order_by("id", "desc");
        $rs = $this->db->get_where('adminuser_type');
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'status' => $row->status
            );
        }
        return $data;
    }
	public function getChildCatsById($id) {
        $this->db->select('id,name,parent_id,ord,status');
        $rs = $this->db->get_where('faq_category', array('parent_id' => $id));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
	
	public function updatetype($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('adminuser_type',$data);
		
	}
	
	public function delete_menu($id) {
        return $this->db->delete('adminuser_type', array('id' => $id));
    }
	
	public function update_type($post,$id) {
        $this->db->where('id', $id);
        return $this->db->update('adminuser_type', $post);
    }
	
	public function add_category($data) {
        return $this->db->insert('adminuser_type', $data);
    } 
	
	public function getleftmenu()
	{
		$this->db->select('id,name');
		$this->db->where('parent_id','0');
		$res=$this->db->get_where('adminmenu',array('status'=>'Y'));
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'id'=>$row->id,
			'name'=>$row->name
			);	
		}
		return $data;	
	}
	

}
