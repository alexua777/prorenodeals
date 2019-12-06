<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  affiliate_fund_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }


   public function getTransaction($limit = '', $start = ''){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("user_affiliate_transaction");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
			   "project_id" =>$row->project_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	public function getTransaction_byproject_id($project_id, $limit = '', $start = ''){ 
        $this->db->select('*');
		$this->db->where('project_id',$project_id);
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("user_affiliate_transaction");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
			   "project_id" =>$row->project_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	public function getFilterTransaction($from,$to,$limit = '', $start = ''){ 
        $this->db->select('*');
		$this->db->where('transction_date >=',$from);
		$this->db->where('transction_date <=',$to);
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("user_affiliate_transaction");
		//echo $this->db->last_query();
		//die();
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	
   public function getTransactionCount($project_id=''){ 
   		if($project_id!="")
		{
       		$this->db->where("project_id",$project_id);
	   	}
        $this->db->from("user_affiliate_transaction");
        return $this->db->count_all_results(); 
    }
	
	public function getFundCount(){ 
       // $this->db->where("user_id",$user_id);
        $this->db->from('useraddfund');
        return $this->db->count_all_results(); 
    }
	   
	public function getFilterCount($from,$to){ 
       // $this->db->where("user_id",$user_id);
	   $this->db->where('transction_date >=',$from);
		$this->db->where('transction_date <=',$to);
        $this->db->from("user_affiliate_transaction");
        return $this->db->count_all_results(); 
    } 
    
	
  public function insertTransaction($data){          
        return $this->db->insert("user_affiliate_transaction",$data);
    }
	
	
	 public function updateUser($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
         $this->db->update('user_affiliate', $data); 
    }
	
	
	
  public function getDispute($limit = '20', $start = '0'){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("dispute",array('status' =>'N'));
        $data=array();
        
        foreach($res->result() as $row){ 
		
            $data[]=array( 
					"id" => $row->id,
					"milestone_id" => $row->milestone_id,
					"employer_id" => $row->employer_id,
					"worker_id" => $row->worker_id,
					"disput_amt" => $row->disput_amt,
					"add_date" => $row->add_date,
					"admin_involve" => $row->admin_involve
            );
        }
		//print_r($data);
		//die;
        return $data;
    }
	
	
	public function getWithdrawlReq($limit,$start){
		$this->db->select('*');
        $this->db->order_by("withdrawl_id","desc");
        $this->db->limit($limit,$start); 
		$res=$this->db->get("withdrawl_affiliate");
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
		$res=$this->db->get_where('user_affiliate',array("user_id"=>$uid));
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
		return $this->db->update("withdrawl_affiliate" ,$data);
	
	}
	
	
	
	public function getGetAccountDetails($acc_id){
	
		$this->db->select('*');
        $res=$this->db->get_where("user_bank_account_affiliate",array("account_id"=>$acc_id));
		$data=array();
		
		 foreach($res->result() as $row){ 
            $data=array( 
			"account_for" => $row->account_for,
			"paypal_account" => $row->paypal_account,
			
			"wire_account_no" => $row->wire_account_no,
			"wire_account_name" => $row->wire_account_name,
			"wire_account_IFCI_code" => $row->wire_account_IFCI_code,
			"city" => $row->city,
			"country" => $row->country,
			"address" => $row->address
			);
		}
	
		return $data;
		
	}
	
	
	
	
	
	
	
   public function getEscrowCount(){ 
   	$a='Y';
       $this->db->where('fund_release','A');
	   $this->db->where(array("release_payment !="=>$a));
        $this->db->from('project_milestone');
		return $this->db->count_all_results(); 
		//echo $this->db->last_query();die;
    }   
	
	public function getDisputeCount(){ 
       $this->db->where("status","N");
	    //$this->db->where("admin_involve","Y");
        $this->db->from('dispute');
        return $this->db->count_all_results(); 
    } 
    
	
	  public function joinEscrow(){ 
			$this->db->select('*');  
			$this->db->from('escrowmilestone_payment');  
			$this->db->join('bids', 'bids.id = escrow.bid_id');  
			$this->db->join('projects', 'projects.project_id = bids.project_id');  
			$query = $this->db->get();
			//echo $this->db->last_query();die;			
	  }
	  
	 
	    public function searchTransaction($from='',$to=''){ 
		
		$from = $this->input->post('from_txt');
        $to = $this->input->post('to_txt');
		
		$this->db->select('*');  
		$this->db->from("user_affiliate_transaction");
		$this->db->where('transction_date >= ',$from);
		$this->db->where('transction_date <= ',$to);
		
		
		
        $res=$this->db->get();
	        $data=array();
       foreach($res->result() as $row){ 
            $data[]=array(
               "paypal_transaction_id" =>$row->paypal_transaction_id,
               "amount" =>  $row->amount,
			   "user_id" => $row->user_id,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
		
		
        return $data;
    }     
        
   
    	  public function getProfit(){ 
		  
		  		$data=array();
		  		for($i=0;$i<6;$i++)
				{
					$from_date=date("Y-m", strtotime("-$i months"));
					$this->db->select_sum('profit');
					$this->db->like('transction_date', $from_date);	
					$res=$this->db->get("user_affiliate_transaction");
					foreach($res->result() as $row){ 
					$data[]=array(
					   "profit" => $row->profit,
					   "transction_date"  => $from_date
					   );
					}

				}
				//print_r($data);die();
				return $data;
   		 }
	  
    
		/*public function getProfitCount(){
			$this->db->select_sum('profit');
			$query = $this->db->get("user_affiliate_transaction");
			return $query->result();
		}
*/
		
		
	 public function getProfitCount(){ 
      
        $this->db->from("user_affiliate_transaction");
        return $this->db->count_all_results(); 
    }    
	
	
	
	 	  public function getProfitDetails($from_date){ 
		  			
				$from_date = date('Y-m');	
			    $this->db->select('*');
				
				$this->db->like('transction_date', $from_date);
			
				$this->db->order_by("transction_date","desc");
			    
				$res=$this->db->get("user_affiliate_transaction");
				
				$data=array();
				
				foreach($res->result() as $row){ 
					$data[]=array( 
						"id" => $row->id,
						"paypal_transaction_id" => $row->paypal_transaction_id,
						"user_id" => $row->user_id,
						"profit" => $row->profit,
						"transaction_for" => $row->transaction_for,
						"transction_date" => $row->transction_date
									
					   
					);
				}
				//print_r($data);die();
				return $data;
   		 }
	  
                 
        public function getWithdrawReqCount(){ 
            $this->db->select("withdrawl_id");
            //$this->db->where("transer_through","P");
            //$this->db->where("status","N");
            $res =  $this->db->get("withdrawl_affiliate");        
            $count = $res->num_rows();
            return $count;
            
        }

        public function getuserWithdrawDetails($wid){
            $this->db->select("user_id,account_id,admin_pay");
            $res=$this->db->get_where("withdrawl_affiliate",array("withdrawl_id"=> $wid,"status"=>"N","transer_through"=>"P"));
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
            $res=$this->db->get_where("user_bank_account_affiliate",array("account_id"=> $accid,"status"=>"Y","user_id"=>$uid,"account_for"=>"P"));
            $data=array();
            foreach($res->result() as $row){ 
                $data[]=array(
                   "paypal_account" => $row->paypal_account
                );
                
            }
           return $data; 
            
        }        
        
        
        public function paypal_settings(){ 
            $this->db->select("paypal_mail,paypal_api_uid,paypal_api_pass,paypal_api_sig,sandbox_api_uid,sandbox_api_pass,sandbox_api_sig,paypal_mode,deposite_by_creaditcard_fees,deposite_by_paypal_commission,deposite_by_paypal_fees");         
            $res=$this->db->get("setting");
            
            $data=array();
            
            foreach($res->result() as $row){ 
                $data=array(
                    "paypal_mail" => $row->paypal_mail,
                    "paypal_api_uid"=> $row->paypal_api_uid,
                    "paypal_api_pass"=> $row->paypal_api_pass,
                    "paypal_api_sig"=> $row->paypal_api_sig,
                    "sandbox_api_uid"=> $row->sandbox_api_uid,
                    "sandbox_api_pass"=> $row->sandbox_api_pass,
                    "sandbox_api_sig"=> $row->sandbox_api_sig,
                    "paypal_mode"=> $row->paypal_mode,
                    "deposite_by_creaditcard_fees"=> $row->deposite_by_creaditcard_fees,
                    "deposite_by_paypal_commission"=> $row->deposite_by_paypal_commission,
                    "deposite_by_paypal_fees"=> $row->deposite_by_paypal_fees                                        
                );
            }
            
            return $data;
            
        }


        public function updateTransaction($data,$tid){
           $this->db->where('id', $tid);
           $this->db->update("user_affiliate_transaction", $data);              
        }

        public function updateWithdraw($data,$wid){
           $this->db->where('withdrawl_id', $wid);
           $this->db->update("withdrawl_affiliate", $data);              
        }        
        

        /*	public function getProfitDetails($date){
	
		//$date = $this->input->get('2017-07');
		$date = date('Y-m-d');
		$exp = explode('-',$date);
	 	$year = $exp['0'];
		$month = $exp['1'];
	
		$this->db->select('*');
		$t_date = $this->db->like($year,$month);
        $res=$this->db->get_where("user_affiliate_transaction",array("transction_date"=>$t_date));
		echo $this->db->last_query();
		die;
		$data=array();
		
		 foreach($res->result() as $row){ 
            $data=array( // 	id	paypal_transaction_id	amount	profit	transction_type CR=Credit DR=Debit	transaction_for	transction_date	status
			"id" => $row->id,
			"paypal_transaction_id" => $row->paypal_transaction_id,
			"user_id" => $row->user_id,
			"profit" => $row->profit,
			"transaction_for" => $row->transaction_for,
			"transction_date" => $row->transction_date
			);
		}
	
		return $data;
		
	}*/
	
	
    


	public function getAllFund($limit = '', $start = ''){ 
        $this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get("useraddfund");
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
               "trans_id" =>$row->trans_id,
               "id"  =>$row->id,
               "amount" =>  $row->amount,
	       "user_id" => $row->user_id,
               "payee_name" => $row->payee_name,
               "dep_bank" => $row->dep_bank,
               "dep_branch"  => $row->dep_branch,
	       "dep_date"  => $row->dep_date,
               "status" => $row->status
            );
        }
		//print_r($data);
		//die;
        return $data;
    }

    public function releaseFund($fid){ 
        
        $user_id=  $this->auto_model->getFeild("user_id","useraddfund","id",$fid);
        
        $fund_balance=$this->auto_model->getFeild("amount","useraddfund","id",$fid);
        
        $user_balance=$this->auto_model->getFeild("acc_balance",'user_affiliate',"user_id",$user_id);
        
        $amount=$user_balance+$fund_balance;
        
        $data_userfind=array(
            "status" =>"Y"
        );
        
        $data_user=array( 
            "acc_balance"=>$amount
        );
        
        $data_transaction=array(
            "user_id"=> $user_id,
            "amount"=> $fund_balance,
            "transction_type"=>"CR",
            "transaction_for"=>"Add Cash Wire",
            "transction_date"=>date("Y-m-d"),
            "status"=>"Y"
        );
        
        $tid=$this->db->insert("user_affiliate_transaction", $data_transaction); 
        
        if($tid>0){ 
            $this->db->where('user_id', $user_id);
            $this->db->update('user_affiliate', $data_user); 
            
            $this->db->where('id', $fid);
            $this->db->update('useraddfund', $data_userfind);            
            return 1;
        }
        
    }
	public function deleteFund($fid)
	{
		$this->db->where('id',$fid);
		return $this->db->delete('useraddfund');	
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
		$this->db->order_by('id','asc');
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
	public function insertMessage($data){ 
        return $this->db->insert("dispute_conversation",$data);
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
	public function update_user($data,$id)
	{
		$this->db->where('user_id',$id);
		return $this->db->update('user_affiliate',$data);	
	}
	/*public function insertTransaction($data)
	{
		return $this->db->insert("user_affiliate_transaction",$data);	
	}*/
	public function updateWithdrawl_new($data,$id)
	{
		$this->db->where('withdrawl_id',$id);
		return $this->db->update("withdrawl_affiliate",$data);
	}
	public function updateMilestone($data,$id)
	{
		$this->db->where('id',$id);
		return $this->db->update('milestone_payment',$data);
	}    
    public function getEscrow($limit = '20', $start = '0')
	{
		$this->db->select('*');
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("project_milestone",array('fund_release' =>'A','release_payment !=' => 'Y'));
		
		$data=array();
        
        foreach($res->result() as $row){ 
		
            $data[]=array( 
					"id" => $row->id,
					"project_id" => $row->project_id,
					"employer_id" => $row->employer_id,
					"bidder_id" => $row->bidder_id,
					"amount" => $row->amount,
					"mpdate" => $row->mpdate,
					"release_payment" => $row->release_payment
            );
		}
		return $data;
	}   

}
