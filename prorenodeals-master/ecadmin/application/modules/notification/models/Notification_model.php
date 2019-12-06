<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }


    /// Get Parent menu list ////////////////////////////
    public function getnotification($limit='',$start='') {
		
		/* $data['invitation'] = get_results(array('select' => 'i.*,p.title,p.project_type', 'from' => 'new_inviteproject i', 'join' => array(array('projects p', 'p.project_id=i.project_id', 'left')), 'where' => array('freelancer_id' => $data['user_id']), 'order_by' => array('i.id', 'DESC'))); */
		$data = array();
        $this->db->select('i.*,p.title,p.project_type')->from('new_inviteproject i');
        $this->db->join('projects p', 'p.project_id=i.project_id', 'left');
		$this->db->order_by('i.project_id', 'DESC');
		$this->db->limit($limit,$start);
		$data = $this->db->get()->result_array();
		
        
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
	
	public function log($from='', $to='', $notification='', $link=''){
		if(empty($to) || empty($notification)){
			die('Invalid parameter');
		}
		if(empty($link)){
			$link = 'notification';
		}
		$noti = array(
			'from_id' => $from,
			'to_id' => $to,
			'notification' => $notification,
			'link' =>  $link,
			'add_date' => date('Y-m-d'),
			'read_status' => 'N',
		);
		$this->db->insert('notification', $noti);
		$ins_id = $this->db->insert_id();
		
		$this->insert_notification_file($to);
		
	}
	
	public function insert_notification_file($id){
		
	  $this->load->helper('file');
	  if($id>0){
		$count_notic=$this->db->where(array('to_id'=>$id,'read_status'=>'N'))->count_all_results('notification');
		
		$filename="../application/ECnote/".$id.".echo";
		if(!file_exists($filename)){
			if ( !write_file($filename, $count_notic, 'w')){
				 echo 'Unable to write the file';
			}
		
		}else{
			if ( !write_file($filename, $count_notic, 'w')){
				 echo 'Unable to write the file';
			}
		}
	  }
	}
	

}