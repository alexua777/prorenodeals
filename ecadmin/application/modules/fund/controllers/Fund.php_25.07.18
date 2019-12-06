<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fund extends MX_Controller {

    //private $auto_model;

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('fund_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url());
       
    }

    public function transaction_history($project_id='0', $limit_from=''){ 
	
		$data['data'] = $this->auto_model->leftPannel();
		
		
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/transaction_history/".$project_id;
		if($project_id=="0")
		{
			 $config["total_rows"] = $this->fund_model->getTransactionCount();
		}
		else {
        $config["total_rows"] = $this->fund_model->getTransactionCount($project_id);
		}
        $config["per_page"] = 10;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
		if($project_id=="0")
		{
			$data['all_data'] = $this->fund_model->getTransaction($config["per_page"], $start);
		}
		else
		{
			$data['all_data'] = $this->fund_model->getTransaction_byproject_id($project_id, $config["per_page"], $start);
		}
		
   		$this->layout->view('list', $lay, $data);           
        
        
  }
  		   
    public function wire_transfer(){
		$w_id =  $this->uri->segment(3);
		$transfer = $this->fund_model->updateWithdrawl($w_id);
		if($transfer){
		
             $this->session->set_flashdata('succ_msg', 'Updated Successfully');
			}
			
			else 
			{
            $this->session->set_flashdata('error_msg', 'Unable to Update');
             
		
			}
		$redirect =  base_url().'fund/withdraw';
			
		redirect($redirect);
	}
	
    public function paypal_transfer(){
$data['w_id']=  $this->uri->segment(3);	

$acc_id = $this->auto_model->getFeild('account_id','withdrawl','withdrawl_id',$data['w_id']);
$data['amount_paid'] = $this->auto_model->getFeild('admin_pay','withdrawl','withdrawl_id',$data['w_id']);
$data['user_id'] = $this->auto_model->getFeild('user_id','withdrawl','withdrawl_id',$data['w_id']);

$data['paypal_acc'] = 	$this->auto_model->getFeild('paypal_account','user_bank_account','account_id',$acc_id);


$data['admin_paypal_acc'] = $this->auto_model->getFeild('paypal_mail','setting','id',1);


$data['data'] = $this->auto_model->leftPannel();
$lay['lft'] = "inc/section_left";
$config = array();
$config["base_url"] = base_url()."fund/withdraw";

$this->layout->view('paypal', $lay, $data);   
	
	}
	
    public function payment_confirm(){             
			 //mail("joybhattacharya69@gmail.com","Test","Hello Joy from confirm");
                $sess_txn_key = $this->session->userdata('txn_key');         
				$withdrawl_id=  $this->uri->segment(3);
				$txn_key=  $this->uri->segment(4);
				$admin=$this->session->userdata('user');
				$admin_id=$admin->admin_id;
				$data['status']="Y";
				$data['admin_id']=$admin_id;
				
				if($txn_key == $sess_txn_key){
					$txn_row_id=$this->auto_model->getFeild("transaction_id","withdrawl","","",array("withdrawl_id"=>$withdrawl_id,"status"=>"N"));
					
					$data_trans['status'] = 'Y';
					$id=$this->fund_model->updateWithdrawl_new($data,$withdrawl_id);
					$this->fund_model->updateTransaction($data_trans,$txn_row_id);
					$succ[] = 'Updated Successfully';
					$this->session->set_flashdata('succ_msg', $succ);
					
				}else{
					$error[] = 'Unable to Update';
					$this->session->set_flashdata('error_msg', $error);
				}
				
				/*$id=$this->fund_model->updateWithdrawl_new($data,$withdrawl_id);
                
				if($this->input->post()){
		
				$this->session->set_flashdata('succ_msg', 'Updated Successfully');
				}
			
				else 
				{
				$this->session->set_flashdata('error_msg', 'Unable to Update');
             
		
				} */
				$this->session->unset_userdata('txn_key');
				redirect(base_url().'fund/withdraw');  
       
               
			}
	
    public function paypal_notify(){   
          /*$a= $this->input->post();
		  echo "aaa";
		  error_log('bishukumar');
		  error_log(json_encode($a));*/
         //mail("bishukumar007@gmail.com","Paypal Mail",json_encode($a));
            //$user_id=  $this->uri->segment(3);
            //$acc_balance =$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);

            /*if($this->input->post('payment_status')=== "Completed"){ 
				$withdrawl_id=$this->input->post('custom');
				$admin_id=$this->session->userdata('admin_id');
				$post['status']="Y";
				$post['admin_id']=$admin_id;
				$id=$this->fund_model->updateWithdrawl_new($post,$withdrawl_id);
                //$post['paypal_transaction_id']=$this->input->post('txn_id');
                //$post['amount']=($this->input->post('mc_gross')-$this->input->post('payment_fee'));
                //$post['transction_type']="CR";
                //$post['transaction_for']="Add Fund";
                //$post['user_id']=$user_id;
                //$post['transction_date']=date("Y-m-d H:i:s");

               //$id=$this->fund_model->insertTransaction($post);

               //if($id){ 
                            //$tot_balance=($acc_balance+$post['amount']);
                  //$this->fund_model->updateUser($tot_balance,$user_id);
                //}

            }
            else{ 

            }*/
        
    }
    
    public function payment_cancel(){ 
	
		redirect(base_url().'fund/withdraw');  
        
    }   
	
    public function withdraw($limit_from=0){	
		
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/withdraw";
        $config["total_rows"] = $this->fund_model->getWithdrawReqCount();
        $config["per_page"] =10;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
      
		$data['all_data'] = $this->fund_model->getWithdrawlReq($config["per_page"], $start);
   		
		
		
		$this->layout->view('withdrawn', $lay, $data); 
	
	
	
	
	}
	
	 public function paid_transaction($limit_from=0){	
		$data['srch'] = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/paid_transaction";
        $config["total_rows"] = $this->fund_model->getPaidTransaction('', '', $data['srch'], FALSE);
		
        $config["per_page"] =10;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
      
		$data['all_data'] = $this->fund_model->getPaidTransaction($config["per_page"], $start, $data['srch']);
   		
		
		
		$this->layout->view('paid_transaction', $lay, $data); 
	
	
	
	
	}
	
	public function exportPaidTxn(){
		$srch = $this->input->get();
		$this->db->select("withdrawl.withdrawl_id as Withdrawal_Id, ub.paypal_account as Account, CONCAT(serv_user.fname,' ',serv_user.lname) as Paid_To, withdrawl.transer_through,withdrawl.total_amount as Amount_incl_commission, withdrawl.admin_pay as Amount_Paid, withdrawl.status, withdrawl.withdrawn_date", FALSE);
		$this->db->from('withdrawl');
		$this->db->join('user', 'user.user_id=withdrawl.user_id', 'LEFT');
		$this->db->join('user_bank_account ub', 'ub.account_id=withdrawl.account_id', 'LEFT');
		$this->db->where('withdrawl.status', 'Y');
		
		if(!empty($srch['from_txt'])){
			$from_dt = date('Y-m-d', strtotime($srch['from_txt']));
			$this->db->where("DATE(serv_withdrawl.withdrawn_date) >= DATE('{$from_dt}')");
		}
		
		if(!empty($srch['to_txt'])){
			$to_dt = date('Y-m-d', strtotime($srch['to_txt']));
			$this->db->where("DATE(serv_withdrawl.withdrawn_date) <= DATE('{$to_dt}')");
		}
		
		if(!empty($srch['uname'])){
			$this->db->where("(CONCAT(serv_user.fname,' ',serv_user.lname) LIKE '%{$srch['uname']}%') OR ( serv_user.username LIKE '%{$srch['uname']}%') OR (serv_user.email LIKE '%{$srch['uname']}%')");
		}
		
		if(!empty($srch['uemail'])){
			$this->db->where('user.email', $srch['uemail']);
		}
		$this->db->order_by("withdrawl.withdrawl_id","desc");
		//$this->db->limit($limit,$start); 
		$query=$this->db->get();
		$this->load->helper('csv');	
        query_to_csv($query, TRUE, 'PaidTransaction_list_'.date("dMy").'.csv');
	}
	   
    public function escrow($limit_from=''){ 
	
		$data['data'] = $this->auto_model->leftPannel();
		//$data['new_data'] = $this->project_model->getAllBidsList($project_id);
	
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/escrow";
        $config["total_rows"] = $this->fund_model->getEscrowCount();
        $config["per_page"] =30;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
        //$data($config['per_page'])=3;
		$data['all_data'] = $this->fund_model->getEscrow($config["per_page"], $start);
   		$this->layout->view('escrow_list', $lay, $data);   
        
        
        
  }
    	
    public function generateCSV(){
            $this->load->database();
            $query = $this->db->get('product');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Product_list_'.date("dMy").'.csv');
	}
        
    public function generatechkCSV(){
            $this->load->database();
            $query = $this->db->get('varify_record');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Checked_Product_list_'.date("dMy").'.csv');
	}        

    public function search($limit_from=''){
		 $data["from_txt"] = !empty($_GET["from_txt"]) ? $_GET["from_txt"] : '';
		 $from = $data["from_txt"];
		 $data["to_txt"] =!empty($_GET["to_txt"]) ? $_GET["to_txt"] : '';
		 $to =  $data["to_txt"];
		 $data["uname"] = !empty($_GET["uname"]) ? $_GET["uname"] : '';
		 $uname =  $data["uname"];
		 $data["trnxs"] =!empty($_GET["trnxs"]) ? $_GET["trnxs"] : '';
		 $trnxs = $data["trnxs"];
		 $project= !empty($_GET["project"]) ? $_GET["project"] : '';
		 
		 $data['srch'] = $this->input->get();
	
		$data['data'] = $this->auto_model->leftPannel();
		//$data['new_data'] = $this->project_model->getAllBidsList($project_id);
	
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config['base_url'] = base_url('fund/search');
        $config["total_rows"] = $this->fund_model->getFilterCount($from,$to,$uname,$trnxs,$project);
        $config["per_page"] = 10;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
		
		
		$data['all_data'] = $this->fund_model->getFilterTransaction($from,$to,$uname,$trnxs,$project,$config["per_page"], $start);
   		$this->layout->view('list', $lay, $data);   
        
		
        
  }
	
	
	public function exportTxn(){
		$srch = $this->input->get();
		$this->db->select("t.*,concat(u.fname, ' ',u.lname) as user, p.title", FALSE)->from('transaction t');
		$this->db->join('user u', 't.user_id=u.user_id', 'LEFT');
		$this->db->join('projects p', 'p.project_id=t.project_id', 'LEFT');
		
			if(!empty($srch['from'])){
		   $this->db->where('date(t.transction_date) >=', $srch['from']);
		   }
		   if(!empty($srch['to'])){
			$this->db->where('date(t.transction_date) <=', $srch['to']);
		   }
		   if(!empty($srch['uname'])){
			   
			$this->db->where("(CONCAT(u.fname,' ',u.lname) LIKE '%{$srch['uname']}%') OR ( u.username LIKE '%{$srch['uname']}%') OR (u.email LIKE '%{$srch['uname']}%')");  
			
		   }
		   if(!empty($srch['trnxs'])){
				$this->db->where('t.transction_type',$srch['trnxs']);
			}
			if(!empty($srch['project'])){
				$this->db->like('p.title',$srch['project']);
			}
			$this->db->order_by("t.id","desc");     
			$query=$this->db->get()->result_array();
			$header=array("Transaction Id", "Paypal Transaction Id", "Project", "Activity", "User", "Amount", "Profit", "Debit/Credit", "Transaction For", "Date", "Status");
			$csv[] = $header;
			if(count($query) > 0){
				foreach($query as $k => $v){
					$bal = $v['transction_type'] == 'CR' ? 'Credit' : 'Debit';
					$csv[] = array($v['id'], $v['paypal_transaction_id'], $v['title'], $v['activity'], $v['user'], $v['amount'], $v['profit'], $bal , $v['transaction_for'], $v['transction_date'] , $v['status']);
				}
			}
			
			$this->load->helper('csv');	
            array_to_csv($csv, 'Transaction_History_'.date("dMy").'.csv');
		
	}
	
    public function profit($limit_from=''){ 
	
            $data['data'] = $this->auto_model->leftPannel();
            $lay['lft'] = "inc/section_left";
            $config = array();
            $config["base_url"] = base_url()."fund/profit";
            $config["total_rows"] = $this->fund_model->getProfitCount();

            $data['all_data'] = $this->fund_model->getProfit();
            $this->layout->view('profit', $lay, $data);   
				
    }
	   
    public function profit_details(){ 
				
				$date =  $this->uri->segment(3);	
				$data['data'] = $this->auto_model->leftPannel();
				$lay['lft'] = "inc/section_left";
				//$config = array();
				//$config["base_url"] = base_url()."fund/profit_details";
				//$config["total_rows"] = $this->fund_model->getProfitDetails($date);
				
				$data['all_data'] = $this->fund_model->getProfitDetails($date);
				$this->layout->view('profit_details', $lay, $data);   
				
        
        
       }

    public function approvepay(){ 
        if($this->input->post("updt")){         
        $approve=$this->input->post('approve');
        $succ=array();
		$err=array();
        	if($approve && is_array($approve)){
			foreach($approve as $ky=>$approve_id){
			$transer_through=$this->auto_model->getFeild("transer_through","withdrawl","","",array("withdrawl_id"=>$approve_id,"status"=>"N"));
			
			$txn_row_id=$this->auto_model->getFeild("transaction_id","withdrawl","","",array("withdrawl_id"=>$approve_id,"status"=>"N"));
			
			if($transer_through=='P'){
				 $uid=$this->auto_model->getFeild("user_id","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N"));
                $accid=$this->auto_model->getFeild("account_id","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N")); 
                $admin_pay=$this->auto_model->getFeild("admin_pay","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N")); 
			}elseif($transer_through=='S'){
				 $uid=$this->auto_model->getFeild("user_id","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"S","status"=>"N"));
                $accid=$this->auto_model->getFeild("account_id","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"S","status"=>"N")); 
                $admin_pay=$this->auto_model->getFeild("admin_pay","withdrawl","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"S","status"=>"N")); 
               
			}
               
                
           
    
        if($uid!="" && $accid!="" && $admin_pay!=""){
      
            $user_bank_details=$this->fund_model->getuserBankDetails($uid,$accid);
           
		$emailSubject =urlencode('Withdrawal fund from Jobbid.org');
		$receiverType = urlencode('EmailAddress');
		$currency = urlencode('USD');
		$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
		
                $from = $this->auto_model->getFeild("admin_mail","setting");
                $to=$this->auto_model->getFeild("email","user","user_id",$uid);
                $username=$this->auto_model->getFeild("fname","user","user_id",$uid);
               
                
                
                $data_parse=array(
                    'username'=>$username,
                    'amount'=>$admin_pay,
                    'cur' => CURRENCY
                );                
                
		               
		if($transer_through=='P' && $user_bank_details[0]['paypal_account']!=''){		
			$receiverEmail = urlencode($user_bank_details[0]['paypal_account']);
			$amount = urlencode($admin_pay);
			
			$uniqueID =date('dmYHis');
			$note = urlencode("Withdrawal fund from Jobbid.org");
			$nvpStr .= "&L_EMAIL0=$receiverEmail&L_Amt0=$amount&L_UNIQUEID0=$uniqueID&L_NOTE0=$note";	
				
			$httpParsedResponseAr = $this->PPHttpPost('MassPay', $nvpStr);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			 {	
		 
                             $data_trans=array(
                                 "status"=>"Y",
								 "paypal_transaction_id" => $httpParsedResponseAr["CORRELATIONID"]
                             );   
                             
                             $data_withdraw=array(
                                 "status"=>"Y"
                             );  
           
                             $this->fund_model->updateWithdraw($data_withdraw,$approve_id);
                             $this->fund_model->updateTransaction($data_trans,$txn_row_id);
                             
                             $succ[]='ID:'.$approve_id.' => Fund Transfer Success.<br>';
                             
                             
                             $this->auto_model->send_email($from,$to,"withdraw_payment_request_for_freelancer",$data_parse);    


			  }
                          else{ 
                             $err[]='ID:'.$approve_id.' =>Fund Transfer Failed.<br>';                              
                             $err[]='Error : '.json_encode($httpParsedResponseAr);                              
                          
                          }
			 /* if("FAILURE" == strtoupper($httpParsedResponseAr["ACK"]) && $abdf==''){
				  $abdf=str_replace('%20',' ',$httpParsedResponseAr["L_LONGMESSAGE0"]);
				  
                                  
			  }*/
			
		 } 
		 elseif($transer_through=='S' && $user_bank_details[0]['skrill_account']!=''){
		 	
		 	$receiverEmail = urlencode($user_bank_details[0]['skrill_account']);
			$amount = urlencode($admin_pay);
			
			$uniqueID =date('dmYHis');
			$note = urlencode("Withdrawal fund from Jobbid.org");
			$pss=$this->fund_model->skrill_settings();

			$API_UserName = urlencode($pss['skrill_mail']);
			$API_Password = urlencode($pss['skrill_pass']);
			$deposite_by_skrill_fees = urlencode($pss['deposite_by_skrill_fees']);
        
        
		 	 $API_Endpoint= "https://www.moneybookers.com/app/pay.pl?action=prepare&email=".$API_UserName."&password=".$API_Password."&amount=".$amount."&currency=USD&bnf_email=".$receiverEmail."&subject=Withdrawal+release&note=".$note."&frn_trn_id=".$uniqueID;
		 	$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);

			// Turn off the server and peer verification (TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$httpResponse = curl_exec($ch);
			curl_close($ch);
			/*$httpResponse='<?xml version="1.0" encoding="UTF-8"?> <response>
<sid>5e281d1376d92ba789ca7f0583e045d4</sid> </response>';*/
			$xml = simplexml_load_string($httpResponse);		
			$res = (array)$xml;

			if(array_key_exists('error',$res)){
				$err[]='ID:'.$approve_id.' =>Fund Transfer Failed. Details: '.$res['error']->error_msg.'<br>'; 
			}else{
				$sid=trim($res['sid']);
				if($sid!=''){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://www.moneybookers.com/app/pay.pl?action=transfer&sid=".$sid);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				$httpResponse = curl_exec($ch);
				curl_close($ch);
				/*$httpResponse='<?xml version="1.0" encoding="UTF-8"?> <response> <transaction>
<amount>1.20</amount> <currency>EUR</currency> <id>497029</id>
<status>2</status> <status_msg>processed</status_msg> </transaction>
</response>';*/
				$xml = simplexml_load_string($httpResponse);				
				$res = (array)$xml;
					if(array_key_exists('transaction',$res)){
						$tran=(array)$res['transaction'];
						if(array_key_exists('status',$tran)){
							if($tran['status']==2){
								$data_trans=array(
	                                 "status"=>"Y"
	                             );   
	                             $data_withdraw=array(
	                                 "status"=>"Y"
	                             );  
	                             $this->fund_model->updateWithdraw($data_withdraw,$approve_id);
								$succ[]='ID:'.$approve_id.' => Fund Transfer Success.<br>';
								 $this->auto_model->send_email($from,$to,"withdraw_payment_request_for_freelancer",$data_parse);    
							}else{
								$err[]='ID:'.$approve_id.' =>Fund Transfer Failed.Details :Status=>'.$tran['status'].'<br>'; 
							}
						 
						}else{
							$err[]='ID:'.$approve_id.' =>Fund Transfer Failed. Details: '.$res['error']->error_msg.'<br>'; 
						}
					}else{
						 $err[]='ID:'.$approve_id.' =>Fund Transfer Failed. Details: '.$res['error']->error_msg.'<br>';
					}
				}else{
					 $err[]='ID:'.$approve_id.' =>Fund Transfer Failed. Details :No return ID  from skrill<br>';                              
				}
			}
		 } 
		else{
		 	 $err[]='ID:'.$approve_id.' =>Fund Transfer Failed.<br>';                              
		 }
	}else{
		 $err[]='ID:'.$approve_id.' =>Fund Transfer Failed.<br>';                              
	}
	}
				
				if($succ && is_array($succ)){
					 $this->session->set_flashdata('succ_msg',$succ);
				}
				if($err && is_array($err)){
					 $this->session->set_flashdata('error_msg', $err);
				}
	  
    }        
      
      }
       redirect(VPATH."fund/withdraw");  
   }
     
    
    public function PPHttpPost($methodName_, $nvpStr_) {
	global $prev;
        
        $ps=$this->fund_model->paypal_settings();
        
     
 if ($ps['paypal_mode'] == 'DEMO') {
        $environment = 'sandbox.';
        $API_UserName = urlencode($ps['sandbox_api_uid']);

        $API_Password = urlencode($ps['sandbox_api_pass']);

        $API_Signature = urlencode($ps['sandbox_api_sig']);
    } else {
        $environment = '';
        $API_UserName = urlencode($ps['paypal_api_uid']);

        $API_Password = urlencode($ps['paypal_api_pass']);

        $API_Signature = urlencode($ps['paypal_api_sig']);
    }

    $API_Endpoint = "https://api-3t." . $environment . "paypal.com/nvp";

	$version = urlencode('51.0');
 
	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	//die($nvpreq);
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
//echo'<br>';
	// Get response from the server.
	$httpResponse = curl_exec($ch);
	//echo'<br>';
	
	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}    
    
   public function addfund($limit_from=''){ 
	
	$data['data'] = $this->auto_model->leftPannel();
	//$data['new_data'] = $this->project_model->getAllBidsList($project_id);
	
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/addfund/";
        $config["total_rows"] = $this->fund_model->getFundCount();
        $config["per_page"] = 10;
	$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
		
		
		$data['all_data'] = $this->fund_model->getAllFund($config["per_page"], $start);
   		$this->layout->view('fund', $lay, $data);   
        
    	   
	} 

    public function release($fid){ 
        $this->fund_model->releaseFund($fid);
        redirect(base_url().'fund/addfund');
        
    }
    
    public function deleteAddFund($fid){
		 $this->fund_model->deleteFund($fid);
        redirect(base_url().'fund/addfund');
    }
	
	public function dispute($limit_from=''){ 
	
		$data['data'] = $this->auto_model->leftPannel();
	
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."fund/dispute";
        $config["total_rows"] = $this->fund_model->getDisputeCount();
        $config["per_page"] =30;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		$data['all_data'] = $this->fund_model->getDispute($config["per_page"], $start);
   		$this->layout->view('dispute_list', $lay, $data);   
        
        
        
  }
  public function dispute_details($did=''){ 
	
		$data['data'] = $this->auto_model->leftPannel();
	
		$lay['lft'] = "inc/section_left";
		
        $data['disput_details']=$this->fund_model->disputeDetails($did);

        $data['disput_discuss']=$this->fund_model->disputeDiscuss($did);
				
		$data['disput_conversation']=$this->fund_model->disputeConversation($did);
		//$data['all_data'] = $this->fund_model->getDispute($config["per_page"], $start);
   		$this->layout->view('dispute_details', $lay, $data);   
        
        
        
  }
  public function message($did)
	{
		$data['data'] = $this->auto_model->leftPannel();
	
		$lay['lft'] = "inc/section_left";
		
        $data['disput_details']=$this->fund_model->disputeDetails($did);

        $data['disput_discuss']=$this->fund_model->disputeDiscuss($did);
				
		$data['disput_conversation']=$this->fund_model->disputeConversation($did);
		
		
		if($this->input->post())
		{
			
                $this->form_validation->set_rules('message', 'Message', 'required');
             
                if($this->form_validation->run()==FALSE){  
                    
                    $this->layout->view('dispute_details',$lay,$data,'normal');                    
                }
                else{ 
                                     
                    
                    $post_data["message"]=  $this->input->post("message");
                    $post_data["dispute_id"]=  $did;
                    $post_data["user_id"]=  "0";
					$post_data["add_date"]=  date('Y-m-d H:i:s');
                  
                    $insert=  $this->fund_model->insertMessage($post_data);
	
                    if($insert){
						$this->session->set_flashdata('msg_sent',"Message sent successfully."); 
                        redirect(base_url()."fund/dispute_details/".$did."/");                        
                    }
                    else{
						$this->session->set_flashdata('msg_failed',"Message sending failed"); 
                        redirect(base_url()."fund/dispute_details/".$did."/");                        
                    }
                }
            	
		}
		$this->layout->view('dispute_details', $lay, $data);   	
	}
	
	public function acceptOffer($did='')
	{
		 $disput_details=$this->fund_model->disputeDetails($did);

         $disput_discuss=$this->fund_model->disputeDiscuss($did);
		 
		 //print_r($disput_discuss); die();
		 
		 if($this->input->post())
		 {
			
			//print_r($this->input->post());
			$employer_amt=$this->input->post('emp_amt');
			$worker_amt=$this->input->post('worker_amt');
			$disput_amt=$this->auto_model->getFeild('disput_amt','dispute','id',$did);
			if(($employer_amt+$worker_amt) > $disput_amt)
			{
				$this->session->set_flashdata('amt_error',"Release amount can't be greater than disputed amount.");
				redirect(VPATH.'fund/dispute_details/'.$did);	
			}
			else
			{
				$new_data['employer_amt']=$employer_amt;
				$new_data['worker_amt']= $worker_amt;
				$new_data['accept_opt']='W';
				$upd=$this->fund_model->updateDiscussion($new_data,$did);
				
				$emp_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$disput_details['employer_id']);
				 $wor_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$disput_details['worker_id']);
				 
				 $emp_data['acc_balance']=($employer_amt+$emp_balance);
				 $wor_data['acc_balance']=($worker_amt+$wor_balance);
				 
				 $transf_emp=$this->fund_model->update_user($emp_data,$disput_details['employer_id']);
				 $transf_wor=$this->fund_model->update_user($wor_data,$disput_details['worker_id']);
				 
				 if($transf_emp && $transf_wor)
				 {
				 $dis_data['status']='Y';
				 $this->fund_model->updateDiscussion($dis_data,$did);
				 
				 $disp_data['status']='Y';
				 $this->fund_model->updateDispute($disp_data,$did);
				 
				 $mile_data['status']='Y';
				 $mile_data['payamount']=$worker_amt;
				 $this->fund_model->updateMilestone($mile_data,$disput_details['milestone_id']);
				 
				 $trans_emp['user_id']=$disput_details['employer_id'];
				 $trans_emp['amount']=$employer_amt;
				 $trans_emp['transction_type']='CR';
				 $trans_emp['transaction_for']='Disputed payment';
				 $trans_emp['transction_date']=date('Y-m-d H:i:s');
				 $trans_emp['status']='Y';
				 $this->fund_model->insertTransaction($trans_emp);
				 
				 $trans_wor['user_id']=$disput_details['worker_id'];
				 $trans_wor['amount']=$worker_amt;
				 $trans_wor['transction_type']='CR';
				 $trans_wor['transaction_for']='Disputed payment';
				 $trans_wor['transction_date']=date('Y-m-d H:i:s');
				 $trans_wor['status']='Y';
				 $this->fund_model->insertTransaction($trans_wor);
				 $this->session->set_flashdata('succ_msg',"Amount released succesfully. Dispute solved.");
				 redirect(VPATH.'fund/dispute');
				 }
				
			}	
			 
		}
		 
		 
	}
	
	public function withdraw_new($limit_from=0){	
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['all_data'] = $this->fund_model->getWithdrawlRequestNew($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getWithdrawlRequestNew($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/withdraw_new";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('withdrawn_new', $lay, $data); 
	
	
	
	
	}
	
	public function status_txn_new(){
		$json = array();
		$this->load->model('member/transaction_model');
		if($this->input->post()){
			$txn_id = $this->input->post('txn_id');
			$cmd = $this->input->post('cmd');
			
			if($cmd == 'approve'){
				$this->transaction_model->approveTransaction($txn_id);
				
				$txn_row = $this->db->where('txn_id', $txn_id)->get('transaction_row')->result_array();
				if($txn_row){
					foreach($txn_row as $k => $v){
						
						$wallet_id = $v['wallet_id'];
						$wallet_user = getField('user_id', 'wallet', 'wallet_id', $wallet_id);
						
						$f_email = getField('email', 'user', 'user_id', $wallet_user);
						
						if($cmd && $wallet_user && $cmd == 'credit'){
							$mail_param = array(
								'ACTION' => 'approved',
							);
							
							send_layout_mail('withdraw_request_action', $mail_param, $f_email);
						}
						
						
					}
				}
		
			}
			
			if($cmd == 'deny'){
				$this->transaction_model->denyTransaction($txn_id);
				
				$txn_row = $this->db->where('txn_id', $txn_id)->get('transaction_row')->result_array();
				if($txn_row){
					foreach($txn_row as $k => $v){
						
						$wallet_id = $v['wallet_id'];
						$wallet_user = getField('user_id', 'wallet', 'wallet_id', $wallet_id);
						
						$f_email = getField('email', 'user', 'user_id', $wallet_user);
						
						if($cmd && $wallet_user && $cmd == 'credit'){
							$mail_param = array(
								'ACTION' => 'rejected',
							);
							
							send_layout_mail('withdraw_request_action', $mail_param, $f_email);
						}
						
						
					}
				}
				
			}
			
			$json['status'] = 1;
			
			if($cmd == 'approve'){
				$this->session->set_flashdata('succ_msg',"Transaction approved");
			}else{
				$this->session->set_flashdata('succ_msg',"Transaction denied");
			}
			
			
			echo json_encode($json);
			
		}
	}
	
	/* ----------------------------  Wallet Management  -----------------------------------*/
	
	public function wallet($limit_from=0){	
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['all_data'] = $this->fund_model->getWallet($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getWallet($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/wallet";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('wallet', $lay, $data); 
	
	}
	
	public function wallet_txn_detail($wallet_id='', $limit_from=0){
		
		if(empty($wallet_id)){
			return false;
		}
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		
		$data['all_data'] = $this->fund_model->getWalletTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getWalletTxn($srch, '', '', FALSE);
		
		$data['debit_total'] = $this->fund_model->wallet_debit_balance($wallet_id);
		$data['credit_total'] = $this->fund_model->wallet_credit_balance($wallet_id);
		
        $config = array();
        $config["base_url"] = base_url()."fund/wallet_txn_detail/".$wallet_id;
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('wallet_detail', $lay, $data); 
	
	}
	
	public function update_wallet(){
		$json = array();
		
		$wallet_id = $this->input->post('wallet_id');
		$cmd = $this->input->post('cmd');
		if($cmd == 'update_origional'){
			
			$total_debit = $this->fund_model->wallet_debit_balance($wallet_id);
			$total_credit = $this->fund_model->wallet_credit_balance($wallet_id);
			$org_balance = $total_credit - $total_debit;
			
			update_wallet_balance($wallet_id, $org_balance);
			
			$this->session->set_flashdata('succ_msg',"Wallet successfully updated");
		}
		
		$json['status'] = 1;
		
		echo json_encode($json);
	}
	
	public function transaction_history_new($limit_from=0){	
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['all_data'] = $this->fund_model->getTxnHistoryNew($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getTxnHistoryNew($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/transaction_history_new";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('txn_history', $lay, $data); 
	
	}
	
	public function txn_detail_ajax(){
		$txn_id = $this->input->get('txn_id');
		if($txn_id){
			
			$data['txn_detail'] = $this->db->select('*')->where('txn_id', $txn_id)->get('transaction_row')->result_array();
			$data['txn_id'] = $txn_id;
			
			$this->load->view('txn_detail_ajax', $data);
			
		}else{
			echo '<h3>No transaction choosen</h3>';
		}
	}
	
	public function project_transaction($limit_from=0){	
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['all_data'] = $this->fund_model->getProjectTxnHistoryNew($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getProjectTxnHistoryNew($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/project_transaction";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('project_txn_history', $lay, $data); 
	
	}
	
	public function project_all_transaction($project_id='', $limit_from=0){
		if(empty($project_id)){
			return false;
		}
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 40;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['project_id'] = $srch['project_id'] = $project_id; 
		$data['project_title'] = getField('title', 'projects', 'project_id', $project_id);
		
		$data['all_data'] = $this->fund_model->getProjectAllTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getProjectAllTxn($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/project_all_transaction/".$project_id;
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);
		
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('project_all_txn', $lay, $data); 
	}
	
	public function disputes($limit_from=0){
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$data['all_data'] = $this->fund_model->getDisputes($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getDisputes($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/transaction_history_new";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('disputes', $lay, $data); 
	}
	
	public function view_diputes($project_id='', $milestone_id='', $limit_from=0){
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 60;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$srch['project_id'] = $project_id;
		$srch['milestone_id'] = $milestone_id;
		
		$data['all_messages'] = $this->fund_model->getDisputeMessages($srch,  $start, $per_page);
		$data['all_messages_count'] = $this->fund_model->getDisputeMessages($srch, '', '', FALSE);
		
		$data['all_dispute_history'] = $this->fund_model->getDisputeHistory($project_id,  $milestone_id);
		
		$data['dispute_row'] = $this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id))->get('escrow_new')->row_array();
		
        $config = array();
        $config["base_url"] = base_url()."fund/view_diputes/".$project_id.'/'.$milestone_id;
        $config["total_rows"] = $data['all_messages_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 5;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		//pre($data);
		
		$this->layout->view('dispute_detail_view', $lay, $data);
	}
	
	public function close_dispute(){

		$this->load->model('member/transaction_model');
		$this->load->model('notification/notification_model');
		$this->load->helper('invoice');
		$json = array();
		
		if(post() && $this->input->is_ajax_request()){
			$post = post();
			
			$dispute_history_row = $post;
			$dispute_history_row['status'] = 'A';
			$dispute_history_row['requested_date'] = date('Y-m-d');
			
			$this->db->insert('dispute_history', $dispute_history_row);
			
			$milestone_id = post('milestone_id');
			$project_id = post('project_id');
			
			$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);
				$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
				
			$p_type = getField('project_type', 'projects', 'project_id', $project_id);
			
			
			$escrow_check = $this->db->where(array('milestone_id' => $milestone_id, 'status' => 'D', 'project_id' =>  $project_id))->get('escrow_new')->row_array();
			
			if(!empty($escrow_check)){
				
				$bidder_wallet_id = get_user_wallet($dispute_history_row['worker_id']);
				$employer_wallet_id = get_user_wallet($dispute_history_row['employer_id']);
				
				// deduct milestone amount from escrow and transfer the amount in related account
				
				$commission = (($escrow_check['amount'] * SITE_COMMISSION) / 100) ; 
				
				$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $dispute_history_row['worker_id'])));
				
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
					'receiver_id' => $dispute_history_row['worker_id'],
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
				
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(DISPUTE_PAYMENT_ESCROW,  $dispute_history_row['employer_id']);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $escrow_check['amount'], 'ref' => $escrow_check['escrow_id'], 'info' => 'Freelancer payment through escrow wallet'));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $employer_wallet_id, 'credit' => $dispute_history_row['employer_amount'], 'ref' => $milestone_id, 'info' => 'Disputed Project payment received'));
					
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => ($dispute_history_row['worker_amount'] + $commission), 'ref' => $milestone_id, 'info' => 'Disputed Project payment'));
					
					$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $dispute_history_row['worker_id'], 'Y', $inv_id);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $bidder_wallet_id, 'debit' => $commission, 'ref' => $milestone_id, 'info' => 'commission paid #'.$project_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission, 'ref' => $milestone_id, 'info' => 'Commission received'));
				
				
				wallet_less_fund(ESCROW_WALLET,$escrow_check['amount']);
				
				wallet_add_fund($bidder_wallet_id, $dispute_history_row['worker_amount']);
				
				wallet_add_fund($employer_wallet_id, $dispute_history_row['employer_amount']);
				
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($bidder_wallet_id,  $new_txn_id);
				
				check_wallet($employer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where('escrow_id', $escrow_check['escrow_id'])->update('escrow_new', array('status' => 'R'));
				
				$pid = $project_id ;
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
			
				$this->db->insert('project_transaction', $project_txn);
				
				$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); 
				
				$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); // commission invoice mark as paid
					
				if($p_type == 'F'){
					$post_data['bider_to_pay']=$dispute_history_row['worker_amount'];
			
				
					$post_data['employer_id'] =$dispute_history_row['employer_id'];
					$post_data['project_id'] = $project_id;
					$post_data['milestone_id'] = $milestone_id;
					
					$post_data['worker_id'] = $dispute_history_row['worker_id'];
					
					$post_data['payamount'] = $dispute_history_row['worker_amount'];
					
					$post_data['commission'] = $commission;
				  
					$post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 
					
					$post_data['release_type'] = 'P';
					$post_data['add_date'] = date('Y-m-d H:i:s');
					$post_data['status'] = 'Y';
					
					$this->db->insert('milestone_payment', $post_data);
					
					
					$val['fund_release']='A';
					$val['release_payment']='Y';
					
					$where=array("id"=>$milestone_id);
					$this->db->where($where)->update('project_milestone', $val);
					
					$this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id))->update('invoice', array('payment_status' => 'PAID', 'amount_disputed' => $dispute_history_row['employer_amount']));
					
					$return_row = $this->db->where(array("project_id"=>$project_id, "release_payment !=" => "Y"))->count_all_results('project_milestone');
		
					if($return_row==0){
						$proj_data['status']='C';
						$this->db->where('project_id', $pid)->update('projects', $proj_data);
					}
					
					$notification = "Disputed milestone has been settled";
					
					$link = 'projectdashboard/dispute_room/'.$milestone_id.'/'.$project_id;
					
					$this->notification_model->log($dispute_history_row['employer_id'], $dispute_history_row['worker_id'], $notification, $link);
					
					$this->notification_model->log($dispute_history_row['employer_id'], $dispute_history_row['employer_id'], $notification, $link);
				
					
				}else{
					
					/* $data_milistone=array(
						"release_type" =>"P",
						"status" => "Y",
						"bider_to_pay" => $dispute_history_row['worker_amount'],
					);
					$this->myfinance_model->updateMilestone($data_milistone,$milestone_id);
					
					$tracker_id = getField('tracker_id', 'milestone_payment', 'id', $milestone_id);
					
					$val['payment_status']='P';
					$where=array("id"=>$tracker_id);
					$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where); */
				}
				
				
				$json['status'] = 1;
				$json['msg'] = 'Transaction Successfully Completed';
			
			}else{
				$json['status'] = 0;
				$json['msg'] = 'Invalid selection';
			}
			
			echo json_encode($json);
		}
	}
	
	public function profit_new($limit_from=0){
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$wallet_id = PROFIT_WALLET;
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		
		$data['all_data'] = $this->fund_model->getWalletTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getWalletTxn($srch, '', '', FALSE);
		
		$data['debit_total'] = $this->fund_model->wallet_debit_balance($wallet_id);
		$data['credit_total'] = $this->fund_model->wallet_credit_balance($wallet_id);
		
        $config = array();
        $config["base_url"] = base_url()."fund/profit_new/";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
		$this->layout->view('wallet_detail', $lay, $data); 
	}
	
	public function escrow_new($limit_from=0){
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$wallet_id = ESCROW_WALLET;
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		
		$data['all_data'] = $this->fund_model->getWalletTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getWalletTxn($srch, '', '', FALSE);
		
		$data['debit_total'] = $this->fund_model->wallet_debit_balance($wallet_id);
		$data['credit_total'] = $this->fund_model->wallet_credit_balance($wallet_id);
		
        $config = array();
        $config["base_url"] = base_url()."fund/escrow_new/";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		
		$this->layout->view('wallet_detail', $lay, $data); 
	}
	
	public function escrow_list_new($limit_from=0){
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$wallet_id = ESCROW_WALLET;
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		
		$data['all_data'] = $this->fund_model->getEscrowList($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getEscrowList($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/escrow_list_new/";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		$this->layout->view('escrow_list_new', $lay, $data); 
	}
	
	public function escrow_project_list($limit_from=0){
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 20;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$wallet_id = ESCROW_WALLET;
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		
		$data['all_data'] = $this->fund_model->getEscrowProject($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getEscrowProject($srch, '', '', FALSE);
		
		$data['pending_escrow_balance'] = $this->fund_model->getEscrowPendingBalance();
		
        $config = array();
        $config["base_url"] = base_url()."fund/escrow_project_list/";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		$this->layout->view('escrow_project_list', $lay, $data); 
	}
	
	public function escrow_project_txn($project_id='', $limit_from=0){
		
		$page = ($limit_from) ? $limit_from : 0;
        $per_page = 60;
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$wallet_id = ESCROW_WALLET;
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		$srch['project_id'] = $project_id;
		$data['all_data'] = $this->fund_model->getProjectEscrowTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->fund_model->getProjectEscrowTxn($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."fund/escrow_project_list/";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		
		$this->layout->view('escrow_project_txn', $lay, $data); 
	}
	
	
	
	
}
