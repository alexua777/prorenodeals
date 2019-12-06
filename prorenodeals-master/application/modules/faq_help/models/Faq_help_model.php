<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq_Help_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

public function getFaqTitle(){
	$this->db->select('id,name');
	$this->db->from('faq_category');
	$this->db->where('parent_id',0);
	$this->db->where('status','Y');
	$this->db->order_by('ord','asc');
	$rs = $this->db->get();
	
	$data =  array();
	foreach($rs->result() as $row)
	{
		$data[] = array(
		'id' => $row->id,
		'name' => $row->name,
		'sub_title' => $this->getQuestionAns($row->id)
		);
	}
		//echo '<pre>';
		//print_r($data); die;
		return $data;

}
	
	public function  getSubTitle($id){
		$this->db->select('id,name');
		$this->db->from('faq_category');
		$this->db->where('parent_id',$id);
		//$this->db->order_by('ord','asc');
		$rs = $this->db->get();
	
		$data =  array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'id' => $row->id,
				'sub_name' => $row->name,
				'answers' => $this->getQuestionAns($row->id)
				
			);
		}
		//echo '<pre>';
		//print_r($data); die;
		return $data;
	
	}
	
	
	public function getQuestionAns($id){
	
		$this->db->select('id,question,answers');
		$this->db->from('faq');
		$this->db->where('faq_cat',$id);
		$this->db->where('status','Y');
		$this->db->order_by('order','asc');
		$rs = $this->db->get();
		
		$data =  array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'faq_id' => $row->id,
				'faq_question' => $row->question,
				'faq_answers' => $row->answers
			);
		}
		
		return $data;
	
	}
	
/*	public function getFaq()
	{
		$this->db->select('*');
		$this->db->from('faq');
		$this->db->order_by('ord','asc');
		$rs = $this->db->get();
		
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'faq_title' => $row->title,
				'faq_contents' => $row->contents
			);
		}
		//echo "<pre>";
	//	print_r($data);
	//	die;
		return $data;
		
		
	}*/
}
