<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Myfinance_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function insertTransaction($data){          
        return $this->db->insert("transaction",$data);
    }
    
    public function insertDispute($data){          
        $this->db->insert("dispute",$data);
        return $this->db->insert_id();
    }
	public function insertDisputDiscuss($data){          
        return $this->db->insert("dispute_discussion",$data);
    }    
    
	
	 public function add_withdrawl($data){          
        return $this->db->insert("withdrawl",$data);
    }    
    public function add_wirefund($data)
	{
		return $this->db->insert("useraddfund",$data);	
	}
	
	 public function add_transation($data){          
        return $this->db->insert("transaction",$data);
    }    
    
	

	
	
	public function get_account($uid){
		$this->db->select("*");
        $res=$this->db->get_where("user_bank_account",array("user_id"=>$uid));
        $data=array();
        
        if($res->num_rows>0){ 
            foreach($res->result() as $row){ 
                $data[]=array(
                   "account_id" =>$row->account_id,
                   "account_for" =>  $row->account_for,
                   "paypal_account" => $row->paypal_account,
                   "wire_account_no" => $row->wire_account_no,
                   "wire_account_name"  => $row->wire_account_name,
                    "wire_account_IFCI_code"  => $row->wire_account_IFCI_code,
                    "city"  => $row->city,
                    "country"  => $row->country,
                    "address"  => $row->address,
                    "wire_account_email" =>  $row->wire_account_email,
                   "status" => $row->status
                );
            }            
        }
        else{ 
                $data[]=array(
                   "account_id" =>"",
                   "account_for" => "",
                   "paypal_account" => "",
                   "wire_account_no" => "",
                   "wire_account_name"  => "",
                    "wire_account_IFCI_code"  => "",
                    "city"  => "",
                    "country"  => "",
                    "address"  => "",
                    "wire_account_email" =>  "",
                   "status" => ""
                );
        }

        return $data;
	
	
	}
	
	public function modify_account($data){
	
	
	$this->db->select('account_id');
	$res=$this->db->get_where("user_bank_account",array("user_id"=>$data['user_id'],"account_for"=>$data['account_for']));
	
	if($res->num_rows() >0){
		
		
		$acc_id = $res->result();
		
		$this->db->where('account_id', $acc_id[0]->account_id);
        
		return  $this->db->update('user_bank_account', $data); 
		
	
		}else{
	
		return $this->db->insert("user_bank_account",$data);
	}

	
	}
	
	
    
    public function updateUser($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
         $this->db->update('user', $data); 
    }
	 public function updateEscrow($amount,$id){ 
        $data=array(
            "payamount" =>$amount
        );
        $this->db->where('id', $id);
         $this->db->update('escrow', $data); 
    }
	 public function update_Escrow($status,$id){ 
        $data=array(
            "status" =>$status
        );
        $this->db->where('id', $id);
         $this->db->update('escrow', $data); 
    }
	
    public function getTransaction($user_id,$limit = '5', $start = '0'){ 
        $this->db->select("id,paypal_transaction_id,project_id,amount,transction_type,transaction_for,transction_date,status");
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("transaction",array("user_id"=>$user_id));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
			   "id" => $row->id,
               "paypal_transaction_id" =>$row->paypal_transaction_id,
               "amount" =>  $row->amount,
			   "project_id" =>  $row->project_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
        return $data;
    }
    
    public function getTransactionCount($user_id){ 
        $this->db->where("user_id",$user_id);
        $this->db->from('transaction');
        return $this->db->count_all_results(); 
    }
	public function getfilterTransactionCount($user_id,$from,$to){ 
        $this->db->where("user_id",$user_id);
		$this->db->where("transction_date >=",$from);
		$this->db->where("transction_date <=",$to);
		
        $this->db->from('transaction');
        return $this->db->count_all_results(); 
    }    
    
   
    public function getProjectList($user_id){ 
        $this->db->select("project_id,title");
        $this->db->order_by('title');
        $res= $this->db->get_where("projects",array("user_id"=>$user_id,"status"=>"P"));
        $data=array();
        foreach($res->result() as $row){ 
            $data[]=array(
                "project_id" => $row->project_id,
                "title" => $row->title
            );
        }
        return $data;
    }
  
    public function getPaidAmount($pid,$wid){ 
        $this->db->select_sum("payamount"); 
        $this->db->where("project_id",$pid);
        $this->db->where("worker_id",$wid);
        $res=$this->db->get("milestone_payment");
        $data=array();
        if($this->db->count_all_results()>0){ 
            foreach($res->result() as $row){ 
                $data[]=$row->payamount;
            }            
        }
        else{ 
            $data[0]=0;
        }

        return $data[0];        
                
    }
    
    public function insertMilestone($data){    
      $this->db->set('add_date', 'NOW()', FALSE);
      $this->db->set('status', "'N'", FALSE);
      $this->db->set('release_type', "'U'", FALSE);
      return $this->db->insert('milestone_payment',$data);   
    }
    
    public function getOutgoingMilestone($uid){
        $this->db->select("*");
		$this->db->order_by("add_date","desc");
        $res=$this->db->get_where("milestone_payment",array("employer_id"=>$uid));
        $data=array();
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "project_id" => $row->project_id,                
                "worker_id" => $row->worker_id,
                "payamount" => $row->payamount,
                "bider_to_pay" => $row->bider_to_pay,
                "reason_txt" => $row->reason_txt,
                "add_date" => $row->add_date,
                "release_type" =>$row->release_type,
                "status" => $row->status
            );
        }
        return $data;
        
    }
    
    
    public function getIncomingMilestone($uid){
        $this->db->select("*");
		$this->db->order_by("add_date","desc");
        $res=$this->db->get_where("milestone_payment",array("worker_id"=>$uid));
        $data=array();
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
                "project_id" => $row->project_id,                
                "employer_id" => $row->employer_id,
                "payamount" => $row->payamount,
                "bider_to_pay" => $row->bider_to_pay,
                "reason_txt" => $row->reason_txt,
                "add_date" => $row->add_date,
                "release_type" =>$row->release_type,
                "status" => $row->status
            );
        }
        return $data;
        
    }
    
    
    
    
    public function updateMilestone($data,$mid){ 
        $this->db->where('id', $mid);
        $this->db->update('milestone_payment', $data);         
    }
	
	public function getAlldebit($user_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('user_id',$user_id);
		$res=$this->db->get_where('transaction',array('transction_type'=>'DR'));
		return $res->result();	
	}
	public function getAllcredit($user_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('user_id',$user_id);
		$res=$this->db->get_where('transaction',array('transction_type'=>'CR'));
		return $res->result();	
	}
	public function filterTransaction($user_id,$from,$to,$limit = '', $start = ''){ 
        $this->db->select("id,paypal_transaction_id,amount,transction_type,transaction_for,transction_date,status");
        $this->db->order_by("id","desc");
		$this->db->where('transction_date >=',$from);
		$this->db->where('transction_date <=',$to);
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("transaction",array("user_id"=>$user_id));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
			   "id" => $row->id,
               "paypal_transaction_id" =>$row->paypal_transaction_id,
               "amount" =>  $row->amount,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
        return $data;
    }
    public function updateProject($data,$id)
	{
		$this->db->where('project_id',$id);
		return $this->db->update('projects',$data);	
	}
	
	public function updateProjectMilestone($data,$where)
	{
		$this->db->where($where);
		return $this->db->update('project_milestone',$data);	
	}
	public function checkproject_milestone($pid)
	{
		$this->db->where("project_id",$pid);
		$this->db->where("release_payment !=","Y");
		$this->db->from('project_milestone');
		return $this->db->count_all_results();
	}
	public function updateProjectTracker($data,$where)
	{
		$this->db->where($where);
		return $this->db->update('project_tracker',$data);	
	}
		
	public function getsetMilestone($pid){
        $this->db->select("*");
        $res=$this->db->get_where("project_milestone",array("project_id"=>$pid));
        $data=array();
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
				"milestone_no" => $row->milestone_no,
                "project_id" => $row->project_id,                
                "amount" => $row->amount,
                "mpdate" => $row->mpdate,
                "bidder_id" => $row->bidder_id,
                "employer_id" => $row->employer_id,
                "description" => $row->description,
				"title" => $row->title,
				"client_approval" => $row->client_approval,
				"fund_release" => $row->fund_release,
				"release_payment" => $row->release_payment
            );
        }
        return $data;
        
    }
	
	public function insert_notification($data){ 
              $this->db->insert("notification",$data);
          }
	
}
