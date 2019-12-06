<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Member_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	public function getAllMemberList($lim_to,$lim_from,$s_key="")
	{ // 	user_id	username	password	fname	lname	gender	status	email	mobile	address	country	zip	image	reg_date	edit_date	ldate	v_stat	ip	acc_balance	slogan	logo	overview	work_experience	hourly_rate	qualification	certification	education	asclient_aboutus	membership_plan	membership_start	membership_end
            $this->db->select('*');
            $this->db->order_by('user_id',"desc");
			$this->db->limit($lim_to,$lim_from);
			if($s_key !=""){
			$this->db->like('fname',$s_key);
			}
			
            $rs = $this->db->get('user_affiliate');
            $data = array();
			
			
            foreach($rs->result() as $row)
            {
                /*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();*/
		if($row->v_stat=='Y'){
			$verify="<div class='i-checkmark-3 green'> Verified</div>";
		}else{
			$verify="<div class='i-checkmark-3 red'> Not Verified</div>";
		}
                $data[] = array(
			'user_id'=>$row->user_id,
			'username' => $row->username,
			'fname' => $row->fname,
			'lname' => $row->lname,
			'email' => $row->email,
			'reg_date' => $row-> reg_date,
			'v_status' =>$verify,

			'acc_balance' => $row-> acc_balance,
			'edit_date' => $row->edit_date,
			'reg_date' => $row-> reg_date,
			'status' => $row->status,

			);
			
            }
            return $data;
	}
	
	
	

	
	public function getFilterMemberList($key)
	{ 
            $this->db->select('*');
			$this->db->like('fname',$key);
			$this->db->or_like('lname',$key);
			$this->db->or_like('username',$key);
			$this->db->or_like('email',$key);
            $this->db->order_by('user_id');
			
			
			
            $rs = $this->db->get('user_affiliate');
            $data = array();
			
			
            foreach($rs->result() as $row)
            {
            	if($row->verify=='Y'){
			$verify="<div class='i-checkmark-3 green'> Verified</div>";
		}else{
			$verify="<div class='i-checkmark-3 red'> Not Verified</div>";
		}
                $data[] = array(
			'user_id'=>$row->user_id,
			'username' => $row->username,
			'fname' => $row->fname,
			'lname' => $row->lname,
			'email' => $row->email,
			'reg_date' => $row-> reg_date,

			'v_status' =>$verify,
			'acc_balance' => $row-> acc_balance,
			'edit_date' => $row->edit_date,
			'reg_date' => $row-> reg_date,
			'status' => $row->status,

			);
			
            }
            return $data;
	}
        
	
	public function updateField($uid, $data){
	
		$this->db->where('user_id',$uid);
		return $this->db->update('user_affiliate',$data);
	
	
	}
	public function record_count_member() 
	{
          return $this->db->count_all('user_affiliate');
     }
	
	public function deleteMember($id)
	{
		return $this->db->delete('user_affiliate', array('user_id' => $id)); 
	}
	public function updateMemberStatus($data,$id)
	{
			
            $this->db->where('user_id',$id);
            return $this->db->update('user_affiliate',$data);
	}
	
	

	
	
	
	

	
	
	

	

}
