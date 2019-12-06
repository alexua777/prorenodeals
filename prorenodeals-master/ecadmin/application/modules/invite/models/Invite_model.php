<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invite_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

   
 	

    //// Delete Menu //////////////////////////////////
    public function delete_invite($id) {
        return $this->db->delete('invite_friend', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getFriendList($limit='',$start='') {
        $this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get('invite_friend');
        $data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
				'name' => $row->user_name,
				'email' => $row->user_email,
				'fname' => $row->friend_name,
				'femail'=>$row->friend_email,
				'project_id'=>$row->project_id,
                'reg_status' => $this->updateStaus($row->id),
				'invite_date' => $row->invite_date
            );
        }
        return $data;
     }
	 
	 public function getRegisteredList($limit='',$start='') {
        $this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get('inviteprivate_project');
        $data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
				'invite_userid' => $row->invite_userid,
				'inviteuser_email' => $row->inviteuser_email,
				'project_id'=>$row->project_id,
				'invite_date' => $row->invite_date
            );
        }
        return $data;
     }
   
   public function updatecons($data,$id)
	{
		
		$this->db->where('contact_id',$id);
		return $this->db->update('contact',$data);
		
	
	}
	public function updateStaus($id)
	{
		$reg_status=$this->auto_model->getFeild('reg_status','invite_friend','id',$id);
		$user_mail=$this->auto_model->getFeild('friend_email','invite_friend','id',$id);
		
		$this->db->select('id');
		$this->db->where('email',$user_mail);
		$this->db->from('user');
		$is_user=$this->db->count_all_results();
		
		if($is_user>0 && $reg_status=='N')
		{
			$post_data=array(
			'reg_status'=>'Y'
			);
			$this->db->where('id',$id);
			$this->db->update('invite_friend',$post_data);
			$reg_status='Y';	
		}
		return $reg_status;	
	}

}