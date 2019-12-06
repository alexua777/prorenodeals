<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Membership_plan_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	public function getAllMembershipList()
	{
		$this->db->select('*');
		$this->db->order_by('id','asc');
		$rs = $this->db->get('membership_plan');
		$data = array();
		foreach($rs->result() as $row)
		{
		/*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();*/
			$data[] = array(
				'id' => $row->id,
				'name' => $row->name,
				'icon' => $row->icon,
				'project'=>$row->project,
				'bids' => $row->bids,
				'skills' => $row->skills,
				'portfolio' => $row->portfolio,
				'price'=>$row->price,
				'bidwin_charge'=>$row->bidwin_charge,
				'days'=>$row->days,
                                'default_plan' =>$row->default_plan,
				'status'=>$row->status
			);
			
		}
		return $data;
	}
        
       /*
	public function getAllCheckList()
	{
		$this->db->select('*');
		$this->db->order_by('varify_id');
		$rs = $this->db->get('varify_record');
		$data = array();
		foreach($rs->result() as $row)
		{		
			$data[] = array(
				'varify_id' => $row->varify_id,
				'text' => $row->text,				
				'when' => $row->when,
				'status' => $row->status
			);
			
		}
		return $data;
	}        
        */
	
	public function add_membership($data)
	{
		return $this->db->insert('membership_plan',$data);
	}
	
	public function updateMembership($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('membership_plan',$data);
	}
        
	public function updateDefaultPal($data,$id){            
		$this->db->where('id',$id);
		return $this->db->update('membership_plan',$data);
	}        
        
        
	
	public function getAPerticulerFooterDataUsingId($id)
	{
		$this->db->select('*');
		$this->db->order_by('id','asc');
		$rs = $this->db->get_where('membership_plan',array('id'=>$id));
		$data = array();
		$row=$rs->row();
			$data = array(
				'id' => $row->id,
				'name' => $row->name,
				'icon' => $row->icon,
				'project' => $row->project,
				'bids' => $row->bids,
				'skills' => $row->skills,
				'portfolio' => $row->portfolio,
				'price'=>$row->price,
				'bidwin_charge'=>$row->bidwin_charge,
				'days'=>$row->days,
				'status'=>$row->status
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
	
	public function deleteMembership($id)
	{
		$this->db->select('icon');
        $this->db->from('membership_plan');
        $this->db->where('id', $id);
        $res = $this->db->get();
        $ban = $res->row();
        $ban = $ban->icon;
        if ($ban != "") {
            unlink("../assets/plan_icon/" . $ban);
        }
		return $this->db->delete('membership_plan', array('id' => $id)); 
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
          return $this->db->count_all('membership_plan');
        }
        
        
	public function record_count_checklist() 
	{
          return $this->db->count_all('varify_record');
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
        
	public function getchkProd($prod)
	{       
                $s= strtoupper(substr($prod, 0, 1));
		$this->db->select('*');
		
		$this->db->or_like("varify_id",$prod);
		$this->db->or_like("text",$prod);
		$this->db->or_like("when",$prod);                
                $this->db->or_like("status",$s);
		$rs = $this->db->get('varify_record');
		$data = array();
		foreach($rs->result() as $row)
		{
			
			$data[] = array(
				'varify_id' => $row->varify_id,
				'text' => $row->text,
				'when'=>$row->when,
				'status' => $row->status
			);
			
		}
		return $data;
	}        

}
