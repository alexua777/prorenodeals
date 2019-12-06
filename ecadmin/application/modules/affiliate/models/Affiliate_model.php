<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class affiliate_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

   
 	

    //// Delete Menu //////////////////////////////////
    public function delete_affiliate($id) {
        return $this->db->delete('user_affiliate_list', array('id' => $id));
    }

    /// Get Parent menu list ////////////////////////////
    public function getAffiliateList($limit='',$start='') {
    	
    	$this->db->select('user_affiliate_list.id,user_affiliate_list.ip,user_affiliate_list.email,user_affiliate_list.affiliate_id,user_affiliate_list.user_id,user_affiliate_list.reg_date,user_affiliate_list.status,user_affiliate_list.ip,user.fname,user.lname,user_affiliate.fname as aFname,user_affiliate.lname as aLname');
	$this->db->join('user','user_affiliate_list.user_id = user.user_id','left');
	$this->db->join('user_affiliate','user_affiliate_list.affiliate_id = user_affiliate.user_id','left');
	$this->db->order_by('user_affiliate_list.id ','desc');
	$this->db->limit($limit, $start);
	$rs=$this->db->get('user_affiliate_list');

        $data = array();
		
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'user_id'=> $row->user_id,
				"name" => $row->fname." ".$row->lname,
				"email"=>$row->email,
				'affliliate_id'=> $row->affiliate_id,
				'affliliate_by'=> $row->aFname." ".$row->aLname,
               	"add_date" => $row->reg_date,
               	"status"=>$row->status,
               	"ip"=>$row->ip,
            );
        }
        return $data;
     }
	 
	
   
  
	public function updateStaus($status,$id)
	{
		
		
		$this->db->select('id');
		$this->db->where('id',$id);
		$this->db->from('user_affiliate_list');
		$is_user=$this->db->count_all_results();
		
		if($is_user==1)
		{
			$post_data=array(
			'status'=>$status
			);
			$this->db->where('id',$id);
			$this->db->update('user_affiliate_list',$post_data);
			$trn_id=$this->auto_model->getFeild('trn_id','user_affiliate_list','id',$id);
			$user_id=$this->auto_model->getFeild('affiliate_id','user_affiliate_list','id',$id);
			
			$amount=$this->auto_model->getFeild('affiliate_amount','setting','id','1');
			
			$acc_balance=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user_id);
			if($status=='Y'){
				$newbalance=sprintf ("%.2f",$acc_balance)+sprintf ("%.2f",$amount);
			}else{
				$newbalance=sprintf ("%.2f",$acc_balance)-sprintf ("%.2f",$amount);
			}
				
			
			
			if($trn_id>0){
				$this->db->where('id',$trn_id);
				$this->db->update('user_affiliate_transaction',array('status'=>$status));
				
				
				
				$this->db->where('user_id',$user_id);				
				$this->db->update('user_affiliate',array('acc_balance'=>$newbalance));
				
			}else{
				$this->db->insert('user_affiliate_transaction',array('status'=>$status,'user_id'=>$user_id,'amount'=>$amount,'transction_type'=>'CR','transaction_for'=>'Affiliate Amount','transction_date'=>date('Y-m-d H:i:s')));
				$addid=$this->db->insert_id();
				$this->db->where('id',$id);
				$this->db->update('user_affiliate_list',array('trn_id'=>$addid));
				
				
				
				$this->db->where('user_id',$user_id);				
				$this->db->update('user_affiliate',array('acc_balance'=>$newbalance));
			}
			
			$reg_status='Y';	
		}
		return $reg_status;	
	}
	/**
	* ************Widthdrawn*********
	*/
	public function getWithdrawlReq($limit,$start){
		$this->db->select('*');
        $this->db->order_by("withdrawl_id","desc");
        $this->db->limit($limit,$start); 
		$res=$this->db->get("withdrawl");
		$data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array( 
			"withdrawl_id" => $row->withdrawl_id,
			"user_details" => $this->getGetUserDetails($row->user_id),
			"account_details"  => $this->getGetAccountDetails($row->account_id),
			"transer_through" =>$row->transer_through,
			"total_amount" =>$row->total_amount,
			"admin_pay" =>$row->admin_pay,
			"admin_id" =>$row->admin_id,
			"status" =>$row->status,
			"transction_date"=> $row->withdrawn_date
			);
        }
	
		return $data;
	}
	
	
	
	public function getGetUserDetails($uid){
	
		$this->db->select('fname,lname,acc_balance,country,email');
		$res=$this->db->get_where("user",array("user_id"=>$uid));
		$data=array();
		
		foreach($res->result() as $row){ 
            $data=array( 
			"name" => $row->fname.' '.$row->lname,
			"acc_balance" => $row->acc_balance,
			"country"  => $row->country,
			"email" => $row->email
			);
		}
	
		return $data;
		
	
	}
	
	
	
	public function updateWithdrawl($wid){
		$data = array(
			'status' => 'Y'
			);
		$this->db->where('withdrawl_id', $wid);
		return $this->db->update('withdrawl' ,$data);
	
	}
	public function getWithdrawReqCount(){ 
            $this->db->select("withdrawl_id");
            //$this->db->where("transer_through","P");
            //$this->db->where("status","N");
            $res =  $this->db->get("withdrawl");        
            $count = $res->num_rows();
            return $count;
            
        }

        public function getuserWithdrawDetails($wid){
            $this->db->select("user_id,account_id,admin_pay");
            $res=$this->db->get_where("withdrawl",array("withdrawl_id"=> $wid,"status"=>"N","transer_through"=>"P"));
            $data=array();
            if($res->num_rows()>0){ 
                foreach($res->result() as $row){ 
                    $data[]=array(
                       "user_id" => $row->user_id,
                        "account_id" => $row->account_id,
                       "admin_pay" =>  $row->user_id  
                    );

                }                
            }

           return $data; 
            
        }
        
        public function getuserBankDetails($uid,$accid){
            $this->db->select("paypal_account");
            $res=$this->db->get_where("user_bank_account",array("account_id"=> $accid,"status"=>"Y","user_id"=>$uid,"account_for"=>"P"));
            $data=array();
            foreach($res->result() as $row){ 
                $data[]=array(
                   "paypal_account" => $row->paypal_account
                );
                
            }
           return $data; 
            
        }  

}