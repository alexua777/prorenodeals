<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class disputes_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function getDisputesList($uid){ 
        $this->db->select("*");
        //$this->db->where("status","N");
        $this->db->where(array("employer_id"=>$uid,"status"=>'N'));
        $this->db->or_where(array("worker_id"=>$uid));
		$this->db->where(array("status"=>'N'));
        $res=  $this->db->get("dispute");
		//echo $this->db->last_query();die();
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "milestone_id"=> $row->milestone_id,
                "employer_id"=> $row->employer_id,
                "worker_id"=> $row->worker_id,
                "disput_amt"=> $row->disput_amt,
                "add_date"=> $row->add_date,
                "status"=> $row->status                
            );
        }
        return $data;
    }
    
    public function getClosedDisputesList($uid){ 
        $this->db->select("*");
        
        $this->db->where(array("employer_id"=>$uid,"status"=>'Y'));
        $this->db->or_where(array("worker_id"=>$uid));
		$this->db->where(array("status"=>'Y'));
        
        $res=  $this->db->get("dispute");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "milestone_id"=> $row->milestone_id,
                "employer_id"=> $row->employer_id,
                "worker_id"=> $row->worker_id,
                "disput_amt"=> $row->disput_amt,
                "add_date"=> $row->add_date,
                "status"=> $row->status                
            );
        }
        return $data;
    }
    
    
    public function getMilestoneDetails($mid){ 
        $this->db->select("*");
        $res=$this->db->get_where("milestone_payment",array("id"=>$mid));
        $data=array();
        foreach($res->result() as $row){ 
            $data=array(
                "project_id" =>$row->project_id,
                "employer_id"=>$row->employer_id,
                "worker_id"=>$row->worker_id,
				"reason_txt" => $row->reason_txt,
				"add_date" => $row->add_date                
            );
        }
        return $data;
    }
    
    
    public function disputeDetails($did){ 
        $this->db->select("*");
        $res=$this->db->get_where("dispute",array("id"=>$did));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data=array(
                "id" => $row->id,
                "milestone_id" => $row->milestone_id,
                "disput_amt" => $row->disput_amt, 
                "employer_id" => $row->employer_id,
                "worker_id" => $row->worker_id,
                "add_date" => $row->add_date,
                "status" => $row->status,
				"admin_involve" => $row->admin_involve
            );
        }
        return $data;
    }
	
	 public function disputeConversation($did){ 
        $this->db->select("*");
        $res=$this->db->get_where("dispute_conversation",array("dispute_id"=>$did));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "user_id" => $row->user_id,
                "message" => $row->message, 
                "attachment" => $row->attachment,
                "add_date" => $row->add_date
            );
        }
        return $data;
    }
    
    public function insertDisputDiscuss($data){ 
        $this->db->insert("dispute_discussion",$data);
    }
	
	public function insertMessage($data){ 
        return $this->db->insert("dispute_conversation",$data);
    }
    
    public function disputeDiscuss($did){ 
        $this->db->select("*");
        $res=  $this->db->get_where("dispute_discussion",array("disput_id" => $did));        
       
        
        
        $data=array();
        if(count($res->result())>0){ 
          foreach($res->result() as $row){ 
            $data[]=array(
                "employer_id" => $row->employer_id,
                "worker_id" => $row->worker_id,
                "employer_amt" => $row->employer_amt,
                "worker_amt" => $row->worker_amt,
                "accept_opt" => $row->accept_opt,
                "status" => $row->status
            );
          }          
        }
        else{ 
            $data[]=array(
                "employer_id" => "",
                "worker_id" => "",
                "employer_amt" => "0.0",
                "worker_amt" => "0.0",
                "accept_opt" => "0.0",
                "status" => ""
            );            
        }

        return $data;
        
    }
	public function updateDiscussion($data,$id)
	{
		$this->db->where('disput_id',$id);
		return $this->db->update('dispute_discussion',$data);	
	}
	public function updateDispute($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('dispute',$data);	
	}
	public function updateUser($data,$id)
	{
		$this->db->where('user_id',$id);
		return $this->db->update('user',$data);	
	}
	public function insertTransaction($data)
	{
		return $this->db->insert('transaction',$data);	
	}
	public function updateMilestone($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('milestone_payment',$data);
	}
    
}
