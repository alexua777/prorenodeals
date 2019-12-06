<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function getnotification($user_id,$limit = '10', $start = '0'){ 
        $this->db->select();
		$this->db->limit($limit,$start);   
		$this->db->where('to_id',$user_id);
        $this->db->order_by('id','desc');
        $res=$this->db->get("notification");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "from_id" => $val->from_id,
                "notification" => $val->notification,
                "add_date" => $val->add_date,
				"read_status"=>$val->read_status,
				"link"=>$val->link,
            );
        }
        return $data;
    }
    public function getnotification_details($user_id,$id){ 
        $this->db->select();
		
		$this->db->where('to_id',$user_id);
		$this->db->where('id',$id);
        $this->db->order_by('id','desc');
        $res=$this->db->get("notification");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "from_id" => $val->from_id,
                "notification" => $val->notification,
                "add_date" => $val->add_date,
				"read_status"=>$val->read_status,
				"link"=>$val->link,
            );
        }
        return $data;
    }

		public function delete($id) {
				return $this->db->delete('notification', array('id' => $id));
			}

	
	public function log($from='', $to='', $notification='', $link=''){
		if(empty($from) || empty($to) || empty($notification)){
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
		$count_notic=$this->auto_model->count_results('id','notification','','',array('to_id'=>$id,'read_status'=>'N'));
		$filename=APATH."application/ECnote/".$id.".echo";
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
	
	public function parseNotification($key='', $data=array()){
		$notification_template = array(
			'job_invitaton' => 'Good news! Job Invitation for {TITLE}',
			'new_message' => 'New Message from {NAME}',
			'shortlist' => 'Good progress! You\'re Shortlised for {TITLE}',
			'interview' => 'Good Progress! You\'ve got a Job Interview Request for {TITLE}',
			'applicant_offer' => 'Congrats! Job Offer for {TITLE}',
			'applicant_reject' => 'Sorry! Unsuccessful for {TITLE}',
			'review_received' => 'New Review for {TITLE}',
			'public_review_received' => 'New Review Received',
			'agency_application' => 'New Agency Proposal for {TITLE}',
			'expert_application' => 'New Job Applicant for {TITLE}',
			'job_match' => 'Instant Job Match: {TITLE}',
		
		);
		
		$content = $notification_template[$key];
		if($content && $data){
			foreach($data as $k => $v){
				$content = str_replace('{'.$k.'}', $v , $content);
			}
		}
		
		return $content;
	}
	
	
	
}
