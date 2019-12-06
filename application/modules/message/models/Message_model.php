<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class message_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
   
	public function getMessage($user_id,$limit = '', $start = '' , $status=''){ 
        $this->db->select("m.*, IF(m.recipient_id = '$user_id', CONCAT(m.sender_id,'-',m.project_id), CONCAT(m.recipient_id,'-',m.project_id)) as msg_user , (select max(m1.id) from serv_message m1 where m1.project_id=m.project_id AND (m1.sender_id='$user_id' OR  m1.recipient_id = '$user_id')) as last_msg", FALSE);
		$this->db->from("message m");
		$this->db->where("(m.recipient_id = $user_id OR m.sender_id = $user_id)");
		if(!empty($status)){
			$this->db->where('m.read_status' , trim($status));
			$this->db->where('m.recipient_id' , $user_id);
		}
		$this->db->where("m.project_id NOT IN(select msg_obj_id from serv_hidden_msg where uid = '$user_id' AND type = 'P')");
		$this->db->group_by('msg_user');
        $this->db->order_by('last_msg','desc');
        $this->db->order_by('m.add_date','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get();
		
        $data=array();
        //echo $this->db->last_query();
		
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				"msg_user" => $val->msg_user,
				"msg_user" => $val->msg_user,
				"unread_msg" => $this->db->where(array('recipient_id' => $user_id , 'read_status' => 'N' , 'project_id' => $val->project_id))->count_all_results('message')  
            );
        }
		
        return $data;
    }
	
	
	public function getProjectMessage($pid='',$user_other='',$status=''){
		$user = $this->session->userdata('user');
		$user_id = $me = $user[0]->user_id;
		$this->db->select('*');
		$this->db->where('project_id',$pid);
		$this->db->where("((sender_id = $user_other AND recipient_id = $me) OR (sender_id = $me AND recipient_id = $user_other))");
		if(!empty($status)){
			$this->db->where('read_status' , trim($status));
		}
		$this->db->where("project_id NOT IN(select msg_obj_id from serv_hidden_msg where uid = '$user_id' AND type = 'P')");
		
        //$this->db->order_by('id','desc');
        $res=$this->db->get("message")->result_array();
		return $res;
  
	}
	
	
	public function getInterviewMessage($user_id,$limit = '', $start = '' , $status=''){ 
        $this->db->select();
		$this->db->where('recipient_id',$user_id);
		if(!empty($status)){
			$this->db->where('read_status' , trim($status));
		}
		$this->db->where("project_id NOT IN(select msg_obj_id from serv_hidden_msg where uid = '$user_id' AND type = 'P')");
		$this->db->where('interview' , 'Y');
		$this->db->group_by('project_id');
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				"unread_msg" => $this->db->where(array('recipient_id' => $user_id , 'read_status' => 'N' , 'project_id' => $val->project_id))->count_all_results('message')  
            );
        }
        return $data;
    }
	// Cystom function 
	public function getMessageRight($user_id){ 
        $this->db->select();
		$this->db->where('recipient_id',$user_id);
		$this->db->where("project_id NOT IN(select msg_obj_id from serv_hidden_msg where uid = '$user_id' AND type = 'P')");
		$this->db->group_by('project_id');
        $this->db->order_by('id','desc');
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date
            );
        }
        return $data;
    }
	public function getAllMessage($project_id,$sender_id,$recipient_id,$limit = '', $start = '')
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->limit($limit, $start);
		$rs=$this->db->get('message');
		$data=array();
        
        foreach($rs->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
				"attachment" => $val->attachment,
                "add_date" => $val->add_date
            );
        }
        return $data;
	}
	
	// Right container message listing
	
	public function getAllMessageRight($project_id,$sender_id,$recipient_id , $interview='')
	{
		//echo $interview;
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		if(!empty($interview)){
			$this->db->where('interview' , $interview);
		}
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','asc');
		$rs=$this->db->get('message');
		//echo $this->db->last_query();
		$data=array();
        
        foreach($rs->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
				"attachment" => $val->attachment,
                "add_date" => $val->add_date,
                "read_status" => $val->read_status,
            );
        }
		

        return $data;
	}
	
	
	public function countAllMessage($project_id,$sender_id,$recipient_id)
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->from('message');
		return $this->db->count_all_results();
		
	}
	/*public function insertMessage($data)
	{
		return $this->db->insert('message',$data);	
	}*/
	
	public function insertMessage($data)
	{
		if($data['recipient_id'] == 'room'){
			$msg = array(
				'room_id' => $data['project_id'],
				'sender' => $data['sender_id'],
				'message' => $data['message'],
				'attachment' => $data['attachment'],
				'send_date' => $data['add_date']
			);
			$ins=$this->db->insert('room_message',$msg);	
		}else{
			$ins=$this->db->insert('message',$data);	
		}
		return $this->db->insert_id(); 
	}
	
	public function getMsgById($msg_id = '' , $type=''){
		if($type == 'room'){
			return $this->db->where('id' , $msg_id)->get('room_message')->row_array();
		}else{
			return $this->db->where('id' , $msg_id)->get('message')->row_array();
		}
		
	}
	
	public function getFavMsg($user=''){
		$result = array();
		$this->db->select('*')
				->from("message");
		$this->db->where("id IN (select msg_id from serv_fav_msg where user = $user)");
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function getallRooms($user){
		$rooms=$this->db->dbprefix('chatroom');
		$members=$this->db->dbprefix('room_members');
		$res=$this->db->select("$rooms.id,$rooms.name,$rooms.topic,$rooms.created")->from('room_members')->join("chatroom","$members.room_id=$rooms.id",'left')->where(array("$members.member_id"=>$user))->get()->result_array();
        return $res;
	}
	public function getallUsers($user){
		$res=$this->db->select('user_id,fname,lname,logo')->from('user')->where(array('user_id <'=>50))->get()->result_array();
		return $res;
	}

}

if(!function_exists('mysort')){
	function mysort($a, $b) {
		return ($a['unread_msg'] < $b['unread_msg']) ? 1 : -1;
	}
}

