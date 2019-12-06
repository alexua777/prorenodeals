<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Product_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	public function getAllProductList()
	{
		$this->db->select('*');
		$this->db->order_by('prod_id','desc');
		$rs = $this->db->get('product');
		$data = array();
		foreach($rs->result() as $row)
		{
		$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();
			$data[] = array(
				'id' => $row->prod_id,
				'name' => $row->product_name,
				'company' => $al->name,
				'model_no' => $row->model_no,
				'product_no' => $row->product_no,
				'manufacture_date'=>$row->manufacture_date,
				'expire_date'=>$row->expire_date,
				'nafdac_no'=>$row->nafdac_no,
				'phone'=>$row->phone,
				'email'=>$row->email,
				'status' => $row->status
			);
			
		}
		return $data;
	}
	
	public function add_product($data)
	{
		return $this->db->insert('product',$data);
	}
	
	public function updateProduct($data,$id)
	{
		$this->db->where('prod_id',$id);
		return $this->db->update('product',$data);
	}
	
	public function getAPerticulerFooterDataUsingId($id)
	{
		$this->db->select('*');
		$this->db->order_by('prod_id','asc');
		$rs = $this->db->get_where('product',array('prod_id'=>$id));
		$data = array();
		$gl=$rs->row();
			$data = array(
				'id' => $gl->prod_id,
				'name' => $gl->product_name,
				'company' => $gl->comp_id,
				'model_no' => $gl->model_no,
				'product_no' => $gl->product_no,
				'manufacture_date' => $gl->manufacture_date,
				'expire_date' => $gl->expire_date,
				'nafdac_no' => $gl->nafdac_no,
				'phone' => $gl->phone,
				'email' => $gl->email,
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
	
	public function deleteProduct($id)
	{
		return $this->db->delete('product', array('prod_id' => $id)); 
	
	}
	
	public function getCompany()
	{
		$this->db->select('*');
		$this->db->order_by('comp_id','desc');
		$rs = $this->db->get_where('company',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'comp_id' => $row->comp_id,
				'name' => $row->name
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	public function record_count_member() 
	{
        return $this->db->count_all('product');
    }
	
	public function getProd($prod)
	{
		$this->db->select('comp_id');
		$this->db->like("name",$prod);
		$r = $this->db->get('company');
		$dt=array();
		foreach($r->result() as $rw)
		{
			$dt[]=array(
			"comp_id"=>$rw->comp_id
			);
		}
		//echo $dt[0]['comp_id']; die();
		$this->db->select('*');
		$this->db->like("product_name",$prod);
		if(count($dt)>0)
		{
		$this->db->or_like("comp_id",$dt[0]['comp_id']);
		}
		$this->db->or_like("product_no",$prod);
		$this->db->or_like("nafdac_no",$prod);
		$this->db->or_like("manufacture_date",$prod);
		$this->db->or_like("expire_date",$prod);
		$this->db->order_by('prod_id','desc');
		$rs = $this->db->get('product');
		$data = array();
		foreach($rs->result() as $row)
		{
			
		$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();
			$data[] = array(
				'id' => $row->prod_id,
				'name' => $row->product_name,
				'company' => $al->name,
				'model_no' => $row->model_no,
				'product_no' => $row->product_no,
				'manufacture_date'=>$row->manufacture_date,
				'expire_date'=>$row->expire_date,
				'nafdac_no'=>$row->nafdac_no,
				'phone'=>$row->phone,
				'email'=>$row->email,
				'status' => $row->status
			);
			
		}
		return $data;
	}

}
