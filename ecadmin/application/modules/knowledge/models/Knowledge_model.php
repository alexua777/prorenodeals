<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Knowledge_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	
	public function getAllKnowledgeList($limit = '', $start = '')
	{
		$this->db->select('*');
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
	public function countcatFaq($cat)
	{
		$this->db->select('id');
		$this->db->where('knowledge_type',$cat);
		$this->db->from('knowledge');
		
		return $this->db->count_all_results();
	}
	
	public function add_faq($data)
	{
		return $this->db->insert('knowledge',$data);
		
	}
	
	public function updateKnowledge($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('knowledge',$data);
		
	
	}
	
	public function getAPerticulerFooterDataUsingId($id)
	{
		$this->db->select('*');
		$this->db->order_by('id','asc');
		$rs = $this->db->get_where('knowledge',array('id'=>$id));
		$data = array();
		$gl=$rs->row();
			$data = array(
				'id' => $gl->id,
				'title' => $gl->title,
				'content' => $gl->content,
				'knowledge_type' => $gl->knowledge_type,
                                'meta_title' => $gl->meta_title,
                                'meta_key' => $gl->meta_key,
                                'meta_description' => $gl->meta_description,
				'order'=> $gl->order,
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
	
	public function deleteKnowledge($id)
	{
		return $this->db->delete('knowledge', array('id' => $id)); 
	
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
        $this->db->select('id,name,parent_id,ord,status');
        //$this->db->order_by("ord", "asc");
        $this->db->order_by("id", "desc");
        $rs = $this->db->get_where('knowledge_type', array('parent_id' => '0'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'name' => $row->name,
                'parent_id' => $row->parent_id,
				'ord' => $row->ord,
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
	
	public function updatecategory($data,$id)
	{
		/*echo "<pre>";
			print_r($data);die;*/
		$this->db->where('id',$id);
		return $this->db->update('knowledge_type',$data);
		
	}
	
	public function delete_menu($id) {
        return $this->db->delete('knowledge_type', array('id' => $id));
    }
	
	public function update_category($post,$id) {
        $this->db->where('id', $id);
        return $this->db->update('knowledge_type', $post);
    }
	
	public function add_category($data) {
        return $this->db->insert('knowledge_type', $data);
    }
	public function getcatFaqList($cat,$limit = '', $start = '')
	{
		$this->db->select('*');
		$this->db->where('knowledge_type',$cat);
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
	
	
	

}
