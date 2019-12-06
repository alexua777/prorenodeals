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
        
        if($res->num_rows()>0){ 
            foreach($res->result() as $row){ 
                $data[]=array(
                   "account_id" =>$row->account_id,
                   "account_for" =>  $row->account_for,
                   "paypal_account" => $row->paypal_account,
                   "skrill_account" => $row->skrill_account,
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
	
// Check Security question Before Addfund /Pay

public function checkAnswerBeforePayQuery($data){
			$user=$this->session->userdata('user');
			$user_id=$user[0]->user_id;	
			$selectSql = "SELECT u.user_id,a.question_id FROM serv_user AS u JOIN serv_answers AS a ON u.user_id = a.user_id JOIN serv_questions AS q ON q.id = a.question_id
			WHERE u.user_id= '".$user_id."' AND BINARY a.answers = '".trim(strtolower($data['answers']))."'";
			
			$resultExe = $this->db->query($selectSql);
			//print_r($resultExe->num_rows());
			//die();
			if($resultExe->num_rows() > 0)
			{
				return 'Y';
			}
			else{
				return 'N';
			}
 }
	  // Get data After update
		public function getUpdatedAnswer(){
			$user=$this->session->userdata('user');
			$user_id=$user[0]->user_id;	  
          
		  // GET question id from Answers tables
			
			$result = $this->db->query("SELECT question_id FROM serv_answers WHERE user_id = '".$user_id."'");
			//echo $this->db->last_query(); echo "<br/>";
			$data=array();
			if( $result->num_rows())
			{
				$row = $result->row_array();
				$questionId = $row['question_id'];
		    
		   
		   
		  // ends here
		  
		  // Displaying the Question 
		 $this->db->select("questions");
         $this->db->from('questions');	
		 $this->db->where("id",$questionId);
         $res = $this->db->get();    
         
         if(count($res->result())>0){ 
                
          foreach($res->result() as $val){ 
                    $data[]=array(
                        "question" => $val->questions
                        
                    );
                } 
                
   }
		
		} 
		
	return $data;
		
		
}
		  

// ends here	
    
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
        $this->db->select("id,paypal_transaction_id,project_id,activity,amount,transction_type,transaction_for,transction_date,status");
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
			   "activity" =>  $row->activity,
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
        $this->db->select("id,paypal_transaction_id,amount,transction_type,transaction_for,project_id,transction_date,status");
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
               "project_id"  => $row->project_id,
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
        $res=$this->db->get_where("project_milestone",array("project_id"=>$pid, 'status' => 'A'));
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
				"release_payment" => $row->release_payment,
				"invoice_id" => $row->invoice_id,
            );
        }
        return $data;
        
    }
	
	public function insert_notification($data){ 
              $this->db->insert("notification",$data);
          }
		  		  
	/////////////////////////For Manual Hour/////////////////////////
	public function updateProjectTracker_manual($data,$where)
	{
		$this->db->where($where);
		return $this->db->update('project_tracker_manual',$data);	
	}
	///////////////////////For Manual hour//////////////////////////
	
	
	/* ----------------- new transaction (Bishu)   -----------------------*/
	
	public function getWalletTxn($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select('tr.*, tn.status,tn.invoice_id,tn.txn_type')
				->from('transaction_row tr')
				->join('transaction_new tn', 'tn.txn_id=tr.txn_id', 'LEFT');
	
		$this->db->where('tr.wallet_id', $srch['wallet_id']);
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tr.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tr.datetime) <= DATE('{$to_dt}')");
		}
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function wallet_debit_balance($wallet_id=''){
		$res = $this->db->select("sum(tr.debit) as debit")
				->from('transaction_row tr')
				->join('transaction_new t', 't.txn_id=tr.txn_id', 'LEFT')
				->where('tr.wallet_id', $wallet_id)
				->where('t.status', 'Y')
				->get()
				->row_array();
		
		return $res['debit'];
	}
	
	public function wallet_credit_balance($wallet_id=''){
		$res = $this->db->select("sum(tr.credit) as credit")
				->from('transaction_row tr')
				->join('transaction_new t', 't.txn_id=tr.txn_id', 'LEFT')
				->where('tr.wallet_id', $wallet_id)
				->where('t.status', 'Y')
				->get()
				->row_array();
		
		return $res['credit'];
	}
	
	public function getProjectAllTxn($srch=array(), $limit=0, $offset=30, $for_list=TRUE){
		$this->db->select("p_txn.project_id,tr.*,tn.status")
				->from('project_transaction p_txn')
				->join('transaction_new tn', 'p_txn.txn_id=tn.txn_id', 'LEFT')
				->join('transaction_row tr', 'tn.txn_id=tr.txn_id', 'LEFT');
				
		
		$this->db->where('p_txn.project_id', $srch['project_id']);
		$this->db->where('tn.status', 'Y');
		
		if(!empty($srch['from'])){
			$from_dt = date('Y-m-d', strtotime($srch['from']));
			$this->db->where("DATE(tr.datetime) >= DATE('{$from_dt}')");
		}
		if(!empty($srch['to'])){
			$to_dt = date('Y-m-d', strtotime($srch['to']));
			$this->db->where("DATE(tr.datetime) <= DATE('{$to_dt}')");
		}
		$this->db->where('tr.wallet_id', ESCROW_WALLET);
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('tr.txn_row_id', 'DESC')->get()->result_array();
			
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function award_freelancer($bid_id='', $user_id=''){
		
		$this->load->model('dashboard/dashboard_model');
		$user_wallet_id = get_user_wallet($user_id);
		$acc_balance  = get_wallet_balance($user_wallet_id);
		
		$bid_row = get_row(array('select' => '*', 'from' => 'bids', 'where' => array('id' => $bid_id)));
		
		$alluser=$bid_row['bidder_id']; 
		$allarrayuser=explode(",",$alluser); 
		
		$project_id=$bid_row['project_id'];
		$all_chosen=array();
		$all_chosen=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id));
		$bidder_amt = $bid_row;
		
		if(empty($bidder_amt) || $bidder_amt['total_amt'] >  $acc_balance){
			$fund = '<b>'.CURRENCY.$bidder_amt['total_amt'].'</b>';
			$remaining_bal = number_format(($bidder_amt['total_amt'] - $acc_balance), 2);
			$add_fund_url = base_url('myfinance?amt_to_add='.$remaining_bal);
			$res['msg'] =  "<div class='success alert-danger alert'>You don't have sufficient balance in your wallet <a href='".$add_fund_url."' target='_blank'>click here </a>to add fund  . Minimum $fund required . </div>";

		}else{
			
			$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$project_id);
			$multifree=$this->auto_model->getFeild('multi_freelancer','projects','project_id',$project_id);
			
			$get_key_chosen=array_search($bid_row['bidder_id'],$all_chosen);
			$exi=trim(implode(",",$all_chosen));
			if($exi!='' && !$get_key_chosen && $project_type=='H' && $multifree=='Y'){
				$alluser=trim(implode(",",$all_chosen)).",".$bid_row['bidder_id'];
			}else{
				$alluser=$bid_row['bidder_id'];
			}
			
			$new_data['bidder_id']= $alluser;
			$new_data['status']= 'P';
			$new_data['hire_date']= date('Y-m-d');
			$upd=$this->dashboard_model->updateProject($new_data,$project_id);
			
			if($project_type == 'F'){
				$bid_r = $bid_row;
				if($bid_r){
			
					$this->db->where(array('bid_id' => $bid_id))->update('project_milestone', array('status' => 'A', 'client_approval' => 'Y'));
					
					$prev_escrow_count = $this->db->where('project_id', $project_id)->count_all_results('escrow_new');
					
					if(($bid_r['enable_escrow'] == 1) && ($prev_escrow_count == 0)){
						
						$this->load->model('myfinance/transaction_model');						
						$this->load->helper('invoice');
						
						$ref =  json_encode(array('project_id' => $project_id, 'project_type' => 'F'));						
						/* $bid_amount = ($bidder_amt['bidder_amt'] + $bidder_amt['admin_fee']); */
						$bid_amount_before_tax = ($bidder_amt['bidder_amt'] + $bidder_amt['admin_fee']);
						$bid_amount = $bidder_amt['total_amt'];
						
						$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $user_id)));												
						$sender_info = array(							
						'name' => SITE_TITLE,							
						'address' => ADMIN_ADDRESS,
						);						
						$receiver_info = array(							
						'name' => $user_info['fname'].' '.$user_info['lname'],							
						'address' => getUserAddress($user_info['user_id']),						
						);						
						$invoice_data = array(							
							'sender_id' => 0,							
							'receiver_id' =>  $user_id,							
							'invoice_type' => 1,							
							'sender_information' => json_encode($sender_info),							
							'receiver_information' => json_encode($receiver_info),							
							'receiver_email' => $user_info['email'],	
							'hst_rate' => HST_RATE,
						);						
						$inv_id = create_invoice($invoice_data); 												
						$invoice_row_data = array(							
							'invoice_id' => $inv_id,							
							'description' => 'Bidder Amount ',			
							'per_amount' => $bid_amount_before_tax,							
							'unit' => '-',								
							'quantity' => 1,						
						);												
						add_invoice_row($invoice_row_data);
						
						
						 // transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(PROJECT_PAYMENT_ESCROW,  $user_id, 'Y', $inv_id);
		   
						// deduct project amount from employer wallet 
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $bid_amount, 'ref' => $ref , 'info' => 'Project payment added to <b>On Hold Payment</b>'));
						
						// transfer project amount to excrow wallet ESCROW_WALLET
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $bid_amount, 'ref' => $ref , 'info' => 'Project payment #'.$project_id));
						
					
						/* $new_txn_id_2 = $this->transaction_model->add_transaction(TAX_PAYMENT,  $user_id); */												
						/* $this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $user_wallet_id, 'debit' => $bidder_amt['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$project_id)); */
						/* transfer project amount to TAX wallet TAX_WALLET */						
						/* $this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => TAX_WALLET, 'credit' => $bidder_amt['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$project_id)); */
						
						wallet_less_fund($user_wallet_id, $bidder_amt['total_amt']);						
						wallet_add_fund(ESCROW_WALLET,$bid_amount);						
					/* 	wallet_add_fund(TAX_WALLET,$bidder_amt['tax_amount']); */
						
						check_wallet($user_wallet_id,  $new_txn_id);						
						check_wallet(ESCROW_WALLET,  $new_txn_id);						
						/* check_wallet(TAX_WALLET,  $new_txn_id);	 */
						
						$project_txn = array(
							'project_id' => $project_id,
							'txn_id' => $new_txn_id,
						);
						
						$this->db->insert('project_transaction', $project_txn);
						$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
						
						
					
						// record escrow in escrow table
					
						
						$milestones = $this->db->where('bid_id', $bid_id)->get('project_milestone')->row_array();
						
						if(count($milestones) > 0){
							
							$escrow_data = array(
								'milestone_id' => $milestones['id'],
								'amount' => $bidder_amt['total_amt'],
								'bidder_amt' => $bidder_amt['bidder_amt'],
								'admin_fee' => $bidder_amt['admin_fee'],
								'tax_amount' => $bidder_amt['tax_amount'],
								'status' => 'P',
								'project_id' => $project_id,
							);

							$this->db->insert('escrow_new', $escrow_data);
							
						}
						
						/* send email to freelancer and employer */
						$p_title = getField('title', 'projects', 'project_id',$project_id);
						$PROJECT_TITLE = $p_title;
						
						$employer_email = getField('email', 'user', 'user_id', $user_id);
						$freelancer_email = getField('email', 'user', 'user_id', $alluser);
						$CONTRACTOR_NAME = getField('fname', 'user', 'user_id', $alluser);
						$CONTRACTOR_NAME .= ' ';
						$CONTRACTOR_NAME .= getField('lname', 'user', 'user_id', $alluser);
						
						$EMPLOYER_NAME = getField('fname', 'user', 'user_id', $user_id);
						$EMPLOYER_NAME .= ' ';
						$EMPLOYER_NAME .= getField('lname', 'user', 'user_id', $user_id);
						
						$template = 'project_fund_escrowed';
						$to = array($employer_email, $freelancer_email);
						$data_parse = array(
							'AMOUNT' => format_money($bidder_amt['total_amt'], TRUE),
							'PROJECT_TITLE' => $p_title,
							'NAME' => $EMPLOYER_NAME,
							
						);
						send_layout_mail($template, $data_parse, $to);
						
						$template = 'awarded_bid_detail';
						$to = $employer_email;
						$data_parse = array(
							'USER' => $EMPLOYER_NAME,
							'PROJECT_TITLE' => $PROJECT_TITLE,
							'CONTRACTOR_NAME' => $CONTRACTOR_NAME,
							'BID_AMOUNT' => format_money($bid_amount_before_tax, TRUE),
							'HST' => format_money($bidder_amt['tax_amount'], TRUE),
							'TOTAL' => format_money($bidder_amt['total_amt'], TRUE),
						);
						
						send_layout_mail($template, $data_parse, $to);
						
						
					}

				}
			}
			
			$title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
			$link=VPATH."jobdetails/details/".$project_id;
			$from=ADMIN_EMAIL;
			foreach($allarrayuser as $valU){
				if(!in_array($valU,$all_chosen)){
					$user_id=$valU;

					$to=$this->auto_model->getFeild('email','user','user_id',$user_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$user_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$user_id);
					$template='select_job_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title,
										'copy_url'=>$link,
										'url_link'=>$link
										);
					
					send_layout_mail($template, $data_parse, $to);

					$post_data['from_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
					$post_data['to_id']=$user_id;
					
					$notification = 'Congratulations! You have been hired for the project'.$title;
					$link = "projectroom/freelancer/overview/".$project_id;
					$this->notification_model->log($post_data['from_id'], $post_data['to_id'], $notification, $link);
				}
			}

		}
	
	}
	
	public function update_featured_project($project_id='', $user_id='', $amount=''){
		
		$this->load->helper('invoice');
	
		$this->load->model('myfinance/transaction_model');
		
		$user_wallet_id = get_user_wallet($user_id);
		
		$inv_id = create_quick_invoice(0, $user_id, 5);
		
		add_quick_invoice_row($inv_id, 'Featured project',$amount);
		
		$ref = json_encode(array( 'featured_fee' => $amount));
		
		// transaction insert
		$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FEATURED,  $user_id, 'Y', $inv_id);
		
		
		
		$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $amount, 'ref' => $ref , 'info' => 'Project featured fee #'.$project_id));
		
		$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $amount, 'ref' => $ref, 'info' => 'Project featured fee received #'.$project_id));
		
		wallet_less_fund($user_wallet_id,  $amount);
	
		wallet_add_fund(PROFIT_WALLET, $amount);
		
		check_wallet($user_wallet_id,  $new_txn_id);
		
		check_wallet(PROFIT_WALLET,  $new_txn_id);
		
		$featured = 'Y';
		
		if($featured == 'Y'){
			$expiry_date = getField('expiry_date', 'projects', 'project_id', $project_id);
			$expiry_date = date("Y-m-d",  strtotime('+30 day', strtotime($expiry_date)));
			$this->db->where('project_id', $project_id)->update('projects', array('expiry_date' => $expiry_date, 'featured' => $featured));
		}
	
		return TRUE;

	}
	
	
	public function deposit_project_fund($project_id='', $user_id='', $amount='', $notify_freelancer=TRUE){
		
		$this->load->model('myfinance/transaction_model');
		$this->load->model('projectdashboard_new/projectdashboard_model');
		$this->load->helper('project');
	
		$ref = json_encode(array('project_id' => $project_id, 'added_amount' => $amount));
		
		$user_wallet_id = get_user_wallet($user_id);
		
		// transaction insert
		$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FUND_ADDED_DIRECT,  $user_id);
		
		
		
		$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $amount, 'ref' => $ref , 'info' => 'Project fund deposited #'.$project_id));
		
		$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $amount, 'ref' => $ref , 'info' => 'Project fund deposited #'.$project_id));
		
		wallet_less_fund($user_wallet_id,  $amount);
	
		wallet_add_fund(ESCROW_WALLET, $amount);
		
		check_wallet($user_wallet_id,  $new_txn_id);
		
		check_wallet(ESCROW_WALLET,  $new_txn_id);
		
		$project_txn = array(
			'project_id' => $project_id,
			'txn_id' => $new_txn_id,
		);
		
		$this->db->insert('project_transaction', $project_txn);
		
		$project_title = getField('title', 'projects', 'project_id', $project_id);
		
		$notification = "Fund successfully added for project <b>$project_title </b>";
		$link = 'projectroom/employer/overview/'.$project_id; 
		$this->notification_model->log($user_id, $user_id, $notification, $link);
		
		$bidders = getField('bidder_id', 'projects', 'project_id', $project_id);
		$bidders = explode(',', $bidders);
		
		if($notify_freelancer){
			if(count($bidders) > 0){
				$noti_msg =  "Fund added for project <b>$project_title </b>";
				$link = 'projectroom/freelancer/overview/'.$project_id; 
				foreach($bidders as $k => $v){
					if(empty($v)){
						continue;
					}
					$this->notification_model->log($user_id, $v, $noti_msg, $link);
				}
			}
		}
		
		
		
		$this->projectdashboard_model->checkProjectDeposit(0, $project_id);
		
		return TRUE;
	}
	
	public function pay_hourly_invoice($invoice_id='', $project_id='', $user_id=''){
	
		/* $user = $this->session->userdata('user');
		$user_id = $user[0]->user_id; */
		$msg  = array();
		$error = 0;
		$total_cost_new = 0;
		$invoice_row = get_row(array('select' =>'*', 'from' => 'invoice_main' ,  'where' => array('invoice_id' => $invoice_id)));
		
		$invoice_number = $invoice_row['invoice_number'];
		$tracker_rows = get_results(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('invoice_id' => $invoice_id, 'payment_status <>' => 'P')));
		
		$freelancer_id = $invoice_row['sender_id'];
		$freelancer_wallet_id = get_user_wallet($freelancer_id);
		
		$tracker_ids = array();
		
		if(count($tracker_rows) > 0){
			foreach($tracker_rows as $tracker_row){
				$tracker_ids[] =  $tracker_row['id'];
				
				$bid_row=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$tracker_row['worker_id'])));
				
				$client_amt = $bid_row['total_amt'];
				$minute_cost_min = ($client_amt/60);
				$total_min_cost = $minute_cost_min *floatval($tracker_row['minute']);
				$cost_n=(($client_amt*floatval($tracker_row['hour']))+$total_min_cost);
				$cost_n=round($cost_n , 2);
				$total_cost_new += $cost_n;
			}
			
			$total_deposit = get_project_deposit($project_id);
			$total_release = get_project_release_fund($project_id);
			$total_pending = get_project_pending_fund($project_id);
			$remaining_bal = $total_deposit - $total_release - $total_pending;
			
			$remaining_deposit = $total_deposit - $total_release;
			
			$commission = (($total_cost_new * SITE_COMMISSION) / (100 + SITE_COMMISSION)) ; 
			
			if($remaining_deposit < $total_cost_new){
				//  employer has no enough balance in his deposit
				$diff = ($total_cost_new - $remaining_deposit);
				$diff_str = CURRENCY.''.number_format($diff ,  2);
				
				$employer_wallet_id = get_user_wallet($user_id);
				$wallet_bal = CURRENCY.''.get_wallet_balance($employer_wallet_id);
				
				$link = base_url('projectroom/add_process_invoice?project_id='.$project_id.'&invoice_id='.$invoice_id);
			
				
				$html = '<div><b>'.$diff_str.'</b> is needed in your deposit to process this invoice. Current wallet balance <b>'.$wallet_bal.'</b> <a href="'.$link .'">click here</a> to add fund and process invoice </div>';
				$msg['msg'] = '<div class="info-error">Not enough balance in your project deposit</div>'.$html;
				$msg['status']=0;
				$error++;
			}
			
			if($error == 0){
				
				$this->load->helper('invoice');
				
				$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $invoice_row['sender_id'])));
				$freelancer_fname = $user_info['fname'];
				$sender_info = array(
					'name' => SITE_TITLE,
					'address' => ADMIN_ADDRESS,
				);
				$receiver_info = array(
					'name' => $user_info['fname'].' '.$user_info['lname'],
					'address' => getUserAddress($user_info['user_id']),
				);
				
				$invoice_data = array(
					'sender_id' => 0,
					'receiver_id' => $user_info['user_id'],
					'invoice_type' => 3,
					'sender_information' => json_encode($sender_info),
					'receiver_information' => json_encode($receiver_info),
					'receiver_email' => $user_info['email'],
				
				);
				
				$inv_id = create_invoice($invoice_data); // creating invoice
				
				$invoice_row_data = array(
					'invoice_id' => $inv_id,
					'description' => 'Commission - ' . SITE_COMMISSION . '% for invoice number #'.$invoice_number,
					'per_amount' => $commission,
					'unit' => '-',
					'quantity' => 1,
				);
				
				add_invoice_row($invoice_row_data); // adding invoice row
				
				add_project_invoice($project_id, $inv_id);
				
				$this->load->model('myfinance/transaction_model');
				
				$ref = $invoice_id;
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $total_cost_new, 'ref' => $ref , 'info' => 'Project payment to '.$freelancer_fname.' #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $total_cost_new, 'ref' => $ref , 'info' => 'Project payment received #'.$project_id));
				
				$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $freelancer_id, 'Y', $inv_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $freelancer_wallet_id, 'debit' => $commission, 'ref' => $inv_id , 'info' => 'Commission paid #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $inv_id, 'info' => 'Commission received #'.$project_id));
				
				wallet_less_fund(ESCROW_WALLET,  $total_cost_new);
			
				wallet_add_fund($freelancer_wallet_id, ($total_cost_new-$commission));
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where_in('id', $tracker_ids)->update('project_tracker', array('status' => '1', 'payment_status' => 'P', 'commission_invoice_id' => $inv_id));
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
				
				$this->db->insert('project_transaction', $project_txn);
				
				$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
				
				$msg['status']=1;
			}
			

		}
		
		return $msg;
	}
	
	
	public function givebonustouser($bonus_freelancer_id='',$user_id='',$bonus_amount='',$bonus_reason=''){
		$this->load->model('myfinance/transaction_model');
		
		$user_wallet_id = get_user_wallet($user_id);
		$freelancer_wallet_id = get_user_wallet($bonus_freelancer_id);
		
		$err=0;
		
		if($err==0){
			$data=array(
				'freelance_id'=>$bonus_freelancer_id,
				'user_id'=>$user_id,
				'reason_desc'=>$bonus_reason,
				'sent_date'=>date('Y-m-d H:i:s'),
				'amount'=>$bonus_amount,
				'status'=>'N'					
			);
			
			
			$this->db->insert('bonus',$data);
			$insert=$this->db->insert_id();
		
			if($insert){
			
				$new_txn_id = $this->transaction_model->add_transaction(BONUS_TO_FREELANCER,  $user_id);
				
				$ref1 = json_encode(array('user_id' => $bonus_freelancer_id));
				$ref2 = json_encode(array('user_id' => $user_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $bonus_amount, 'ref' => $ref1, 'info' => 'Bonus given'));
					
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $bonus_amount , 'ref' => $ref2, 'info' => 'Bonus received'));
				
				wallet_less_fund($user_wallet_id,$bonus_amount);	
				
				wallet_add_fund($freelancer_wallet_id,$bonus_amount);				
				
				check_wallet($user_wallet_id,  $new_txn_id);
					
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
			
				$this->db->where('id',$insert)->update('bonus',array('status'=>'Y'));
		
			   
				$msg['status']='OK';  
				
				$employer_name=$this->auto_model->getFeild('fname','user','user_id', $user_id)." ".$this->auto_model->getFeild('lname','user','user_id', $user_id);
				
				$bidder_name=$this->auto_model->getFeild('fname','user','user_id', $bonus_freelancer_id)." ".$this->auto_model->getFeild('lname','user','user_id', $bonus_freelancer_id);
				
				$notification = "You have successfully give bonus (".CURRENCY."".$bonus_amount.") to ".$bidder_name; 
				$notification2 = $employer_name . ' send you a bonus ('.CURRENCY.$bonus_amount.')';
				$link = 'myfinance/transaction';
				$this->notification_model->log($user_id, $user_id, $notification, $link);
				$this->notification_model->log($user_id, $bonus_freelancer_id, $notification2, $link);
			
			}
		
			
		}
		
		return TRUE;
	}
	
	public function feature_profile($user_id='', $feature_type=''){
		$type = $feature_type;
		$price = 0;
		if($type == 'monthly'){
			$price = PROFILE_FEATURED_MONTHLY;
		}else if($type == 'yearly'){
			$price = PROFILE_FEATURED_YEARLY;
		}
		
		if($price > 0){
			$payment_status = make_payment($price, $user_id, FEATURED_PROFILE_PAYMENT);
			
			if($payment_status['status'] == 'PAYMENT_SUCCESS'){
				
				$this->load->model('dashboard/dashboard_model');
				
				$MONTH = 1;
				if($type == 'yearly'){
					$MONTH = 12;
				}
				
				$this->dashboard_model->make_profile_feature($user_id, $MONTH);
			
			}
		}
		
		return TRUE;
	}
	
	
}
