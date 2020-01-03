<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myfinance extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('myfinance_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('notification/notification_model');
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('myfinance', $idiom);
		$this->lang->load('form_validation', $idiom);
    }

    public function index() {
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);
		// Get the Question  From model
		$data['question']=$this->myfinance_model->getUpdatedAnswer();

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

                $data['paypal_setting']=$this->auto_model->getFeild('withdrawl_method_paypal','setting');

                $data['wire_setting']=$this->auto_model->getFeild('withdrawl_method_wire_transfer','setting');                 $data['skrill_setting']=$this->auto_model->getFeild('method_skrill','setting');
                
  
                
                
		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

              

	
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('details',$lay,$data,'normal');

	}        
    }

	// checkAnswerBeforePay  
	
	
	public function checkAnswerBeforePay(){
	
	$user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;	  
	$this->auto_model->checkrequestajax();
	if($this->input->post()){	
    //Setting values for Table columns
	$data= array(
	'user_id' => $user_id,
	'answers' => $this->input->post('answer')
	);
	
	//Transfer  data to Model
	$reultStaus = $this->myfinance_model->checkAnswerBeforePayQuery($data);
	print $reultStaus; die; 
   }     
	
}
	
	
	
	
	
	
    public function payment_confirm(){             
        $user=$this->session->userdata('user');

        $data['user_id']=$user[0]->user_id;


        $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

        $data['ldate']=$user[0]->ldate;

        $breadcrumb=array(
            array(
                    'title'=>'My Finance','path'=>''
            )
        );

        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

        ///////////////////////////Leftpanel Section start//////////////////

        $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

        if($logo==''){
                $logo="images/user.png";
        }else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

        $data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

        ///////////////////////////Leftpanel Section end//////////////////

        $head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);




        $this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

        $lay['client_testimonial']="inc/footerclient_logo";

        $user_id=$user[0]->user_id;        
        
        $pay_id=  $this->uri->segment(3);
      
        if($user_id!=$pay_id)
        {
            redirect(base_url(). "myfinance/wrong_entry");
        }
        else{ 
           $this->layout->view('thankyou',$lay,$data,'normal');           
        }
               
    }
    
    public function paypal_notify(){   
		if ( ! count($this->input->post())) {
            throw new Exception("Missing POST Data");
               die('ok');
        }

		require(APPPATH.'third_party/PaypalIPN.php');
		$ipn = new PaypalIPN();
		if(PAYPAL_MODE=="DEMO"){
			$ipn->useSandbox();
		}
		$verified = $ipn->verifyIPN();
        if ($verified) {
        	
        }else{
        	header("HTTP/1.1 200 OK");
			die;
		}
		$this->load->model('transaction_model');
		$track_id = get('track_id');
        $user_id=  $this->uri->segment(3);
		$msg = json_encode($this->input->post());
		
		/* $log_file = fopen('paypal.log', 'a+');
		fwrite($log_file, '['.date('Y-m-d H:i:s').']'.PHP_EOL);
		fwrite($log_file, $msg.PHP_EOL); */
		
		file_put_contents('paypal.log', $msg);
		
		
		$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);
		
		$user_wallet_id = get_user_wallet($user_id);
		$acc_balance=get_wallet_balance($user_wallet_id);
		
        if($this->input->post('payment_status')=="Completed"){
			$paypal_fee_percent = getField('deposite_by_paypal_commission', 'setting', 'id', 1);
			$paypal_fee_fixed = PAYPAL_FIXED_FEE;
			$gross = $this->input->post('mc_gross');
			$net = $gross;
			if($paypal_fee_fixed > 0){
				$net = $gross - $paypal_fee_fixed;
			}else{
				$paypal_fee_fixed = 0;
			}
			
			$fee = str_replace(',', '', number_format((($net * $paypal_fee_percent)/(100+$paypal_fee_percent)), 2));
			$net = $net - $fee;
			$paypal_commission = str_replace(',', '', number_format(($fee + $paypal_fee_fixed), 2));
			if($this->input->get('cmd')){
				if($this->input->get('cmd') == 'wallet'){
					$net=$this->input->post('mc_gross');
					$paypal_commission=$this->input->post('mc_fee');
				}
			}
            $post['status']="Y";
            $post['paypal_transaction_id']=$this->input->post('txn_id');
           /*  $post['amount']=($this->input->post('mc_gross')-$this->input->post('payment_fee')); */
            $post['amount']=$net;
            $post['transction_type']="CR";
            $post['transaction_for']="Add Fund";
            $post['user_id']=$user_id;
            $post['transction_date']=date("Y-m-d H:i:s");
			/* $paypal_commission = $this->input->post('payment_fee'); */
           /*$id=$this->myfinance_model->insertTransaction($post);*/
		   
		   $track_count = $this->db->where('txn_id', $post['paypal_transaction_id'])->count_all_results('payment_track');
		   if( $track_count > 0){
			   return;
		   }
		   
		   $user_wallet_id = get_user_wallet($user_id);
			$wallet_balance = get_wallet_balance($user_wallet_id);
		
		   // transaction insert
		   $new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_PAYPAL,  $user_id);
           
            if($user_id && $new_txn_id){ 
				
				/* $tot_balance=($acc_balance+$post['amount']);
                $this->myfinance_model->updateUser($tot_balance,$user_id); */
				
				// Affected transaction row and wallet
				
				
				// credit main wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'credit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through paypal. Paypal Fee Charged : '.$paypal_commission));
				
				// transfer money from main wallet to user wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'debit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through paypal. Paypal Fee Charged : '.$paypal_commission));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => ($post['amount']+$paypal_commission), 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through paypal'));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $paypal_commission, 'ref' => $post['paypal_transaction_id'], 'info' => 'Paypal Fee Charged'));
				
				
				wallet_add_fund($user_wallet_id, $post['amount']);
				
				check_wallet($user_wallet_id,  $new_txn_id);
				
				
				
				
				$cmd = get('cmd');
				
				if($cmd == 'award_job'){
					$bid_id = get('bid_id');
					if(!$bid_id){
						return;
					}
					
					$this->myfinance_model->award_freelancer($bid_id, $user_id);
					
				}
				
				if($cmd == 'featured_project'){
					$project_id = get('project_id');
					if(!$project_id){
						return;
					}
					
					$this->myfinance_model->update_featured_project($project_id, $user_id, $post['amount']);
					
				}
				
				if($cmd == 'feature_profile'){
					$feature_type = get('feature_type');
					if(!$feature_type){
						return;
					}
					
					$this->myfinance_model->feature_profile($user_id, $feature_type);
					
				}
				
				
				if($cmd == 'deposit_project_fund'){
					$project_id = get('project_id');
					if(!$project_id){
						return;
					}
					if($track_id){
						$this->db->where('track_id', $track_id)->update('payment_track', array('status' => 'S', 'txn_id' => $post['paypal_transaction_id']));
					}
				
					$amt_to_add = ($post['amount']+$wallet_balance);
					$this->myfinance_model->deposit_project_fund($project_id, $user_id, $amt_to_add);
				}
				
				if($cmd == 'process_invoice'){
					$project_id = get('project_id');
					$invoice_id = get('invoice_id');
					if(!$project_id || !$invoice_id){
						return;
					}
					if($track_id){
						$this->db->where('track_id', $track_id)->update('payment_track', array('status' => 'S', 'txn_id' => $post['paypal_transaction_id']));
					}
				
					$amt_to_add = ($post['amount']+$wallet_balance);
					$this->myfinance_model->deposit_project_fund($project_id, $user_id, $amt_to_add, FALSE);
					$this->myfinance_model->pay_hourly_invoice($invoice_id, $project_id, $user_id);
					
				}
				
				if($cmd == 'bonus_to_freelancer'){
					$freelancer_id = get('freelancer_id');
					$reason = urldecode(get('reason'));
					
					if(!$freelancer_id){
						return;
					}
					
					$this->myfinance_model->givebonustouser($freelancer_id, $user_id, $post['amount'], $reason); 
					
				}
				
				
				if($track_id){
					$this->db->where('track_id', $track_id)->update('payment_track', array('status' => 'S', 'txn_id' => $post['paypal_transaction_id']));
				}
				
			
				
            }
            
        }else{ 
            if($track_id){
				$this->db->where('track_id', $track_id)->update('payment_track', array('status' => 'F'));
			}
        }
        header("HTTP/1.1 200 OK");
    }
    
    public function payment_cancel(){ 

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
        $lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('cancel',$lay,$data,'normal');        
        
        
        
        
        
        
 
      /*  $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;        
        
        $pay_id=  $this->uri->segment(3);
      
        if($claim_id!=$pay_id)
        {
            redirect(base_url(). "myfinance/wrong_entry");
        }
        else{ 
           $this->layout->view('cancel', '', "", 'normal', 'N');          
        }    */    
        
    }   
    
    public function wrong_entry(){ 
        $this->layout->view('wrong', '', "", 'normal', 'N');
    }        

    public function transaction($limit_from=''){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                     'title'=>__('my_finance_txn_history','Transaction History'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='all_transaction';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		
                
                
		$this->load->library('pagination');
		/* $config['base_url'] = VPATH.'myfinance/transaction/';
		if($this->input->post())
		{
			$from=$this->input->post('from_txt');
			$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$total_rows=$this->myfinance_model->getfilterTransactionCount($user[0]->user_id,$from,$to);
			}
			else
			{
				$total_rows=$this->myfinance_model->getTransactionCount($user[0]->user_id);		
			}
		}
		else
		{
			$total_rows=$this->myfinance_model->getTransactionCount($user[0]->user_id);	
		}
		
                
				$config['total_rows'] =$total_rows;
				$config['per_page'] = 5; 
				$config["uri_segment"] = 3;
				$config['use_page_numbers'] = TRUE;  
                
                $config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
                $config['cur_tag_close'] = '</a></li>';
                $config['last_tag_open'] = "<li class='last'>";
                $config['last_tag_close'] = '</li>';
                $config['next_link'] = 'Next &gt;&gt;';
                $config['next_tag_open'] = "<li>";
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = '&lt;&lt; Previous';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>';                 
                
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		
         $data['transaction_count']=$total_rows;
         $data['links']=$this->pagination->create_links();       
         $this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		$data['tot_debit']=$this->myfinance_model->getAlldebit($user[0]->user_id);
		$data['tot_credit']=$this->myfinance_model->getAllcredit($user[0]->user_id); 
		$data['from']='';
		$data['to']='';
		if($this->input->post())
		{
			//print_r($this->input->post()); die();
			$data['from']=$from=$this->input->post('from_txt');
			$data['to']=$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$data['transaction_list']=$this->myfinance_model->filterTransaction($user[0]->user_id,$from,$to,$config['per_page'],$start);	
			}
			else
			{
				$data['transaction_list']=$this->myfinance_model->getTransaction($user[0]->user_id,$config['per_page'],$start);	
			}	
		}
		else
		{
                
        	$data['transaction_list']=$this->myfinance_model->getTransaction($user[0]->user_id,$config['per_page'],$start);
		} */
		//print_r($data);
		//die();
		
		/* -------------------New transaction history (Bishu) ------------------ */
		
		
		$page = ($limit_from) ? $limit_from : 0;
		$per_page = 15;
		$start = 0;
		if ($page > 0) {
			for ($i = 1; $i < $page; $i++) {
				$start = $start + $per_page;
			}
		}
		 
		$data['srch'] = $srch = $this->input->get();
		$wallet_id = get_user_wallet($user[0]->user_id);
		
		$data['wallet_id'] = $srch['wallet_id'] = $wallet_id; 
		$data['balance'] = get_wallet_balance($wallet_id);
		$data['all_data'] = $this->myfinance_model->getWalletTxn($srch,  $start, $per_page);
		
		$data['all_data_count'] = $this->myfinance_model->getWalletTxn($srch, '', '', FALSE);
		
		
		
		$data['debit_total'] = $this->myfinance_model->wallet_debit_balance($wallet_id);
		$data['credit_total'] = $this->myfinance_model->wallet_credit_balance($wallet_id);
		
		$config2['base_url'] = VPATH.'myfinance/transaction/';
		$config2['total_rows'] =$data['all_data_count'] ;
		$config2['per_page'] = $per_page; 
		$config2["uri_segment"] = 3;
		$config2['use_page_numbers'] = TRUE;  
		
		$config2['full_tag_open'] = "<ul class='pagination'>";
		$config2['full_tag_close'] = '</ul>';
		$config2['first_link'] = 'First';
		$config2['first_tag_open'] = '<li>';
		$config2['first_tag_close'] = '</li>';
		$config2['num_tag_open'] = '<li>';
		$config2['num_tag_close'] = '</li>';
		$config2['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config2['cur_tag_close'] = '</a></li>';
		$config2['last_tag_open'] = "<li class='last'>";
		$config2['last_tag_close'] = '</li>';
		$config2['next_link'] = 'Next &gt;&gt;';
		$config2['next_tag_open'] = "<li>";
		$config2['next_tag_close'] = '</li>';
		$config2['prev_link'] = '&lt;&lt; Previous';
		$config2['prev_tag_open'] = '<li>';
		$config2['prev_tag_close'] = '</li>';                 
		
		$this->pagination->initialize($config2); 
	    $data['links2']=$this->pagination->create_links(); 
		
		$this->layout->view('transaction_history',$lay,$data,'normal');      
        
        }
        
    }
    
    public function milestone($project_id=''){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);
		
		$data['project_id']=$project_id;
		
		if($project_id!='')
		{
        
        	$data['set_milestone_list']=$this->myfinance_model->getsetMilestone($project_id);
		
		}

		$data['outgoint_milestone_list']=$this->myfinance_model->getOutgoingMilestone($user[0]->user_id);
		
		$data['incoming_milestone_list']=$this->myfinance_model->getIncomingMilestone($user[0]->user_id);                
		
		$breadcrumb=array(
			array(
					'title'=>__('my_milestone','My Milestone'),'path'=>''
			)
		);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_milestone','My Milestone'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='milestone';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);
	
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
     
		$this->layout->view('milestone',$lay,$data,'normal');

	}          
    }

    public function workerDetails(){ 
        $pid=$this->input->post("pid");
        $wid= $this->auto_model->getFeild("bidder_id","projects","project_id",$pid);
		$ptype= $this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $wfname=$this->auto_model->getFeild("fname","user","user_id",$wid);
        $wlname=$this->auto_model->getFeild("lname","user","user_id",$wid);
        $total_bid_amount=$this->auto_model->getFeild("total_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
		 $bidder_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
        $paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
        if($ptype=='F')
		{
        $result="<div class='acount_form'><p>Provide User :</p><div id='mysubcat'>".$wfname." ".$wlname."<br>
            <input type='hidden' name='worker_id' value='".$wid."'>
			<input type='hidden' id='paid_amount' name='paid_amount' value='".$paid_amount."'>
			<input type='hidden' id='remaining_amount' name='remaining_amount' value='".($total_bid_amount-$paid_amount)."'>
			<input type='hidden' name='proj_type' id='proj_type' value='".$ptype."'/>
			
  <label id='displabel'>Total Bid Amount : ".CURRENCY." ".$total_bid_amount."</label><br>
  <p></p><label id='displabel'>Remaining Payment : ".CURRENCY." ".($total_bid_amount-$paid_amount)."</label>	
</div>
<div class='acount_form'><p>How much money would you like to transfer ? ".CURRENCY."  :</p>
<input type='text' class='acount-input' onblur='valcheck(this.value)' id='payamount' size='15' name='payamount' title='Enter your milestone payment amount' tooltipText='How much money would you like to transfer ?' />    
".form_error('payamount', '<div class="error-msg3">', '</div>')."
</div>";
		}
		else
		{
		$result="<div class='acount_form'><p>Provide User :</p><div id='mysubcat'>".$wfname." ".$wlname."<br>
            <input type='hidden' name='worker_id' value='".$wid."'>
			<input type='hidden' id='paid_amount' name='paid_amount' value='".$paid_amount."'>
			<input type='hidden' id='hour_amount' name='hour_amount' value='".$total_bid_amount."'>
			<input type='hidden' name='proj_type' id='proj_type' value='".$ptype."'/>
			
  <label id='displabel'>Hourly Rate : ".CURRENCY." ".$total_bid_amount."</label><br>	
</div>
<div class='acount_form'><p>Enter Total Hour of Payment? :</p>
<input type='text' class='acount-input' id='total_hour' onblur='putval(this.value)' size='15' name='total_hour' title='Enter your milestone payment hour' tooltipText='For How much hour would you like to transfer ?'/>    
".form_error('total_hour', '<div class="error-msg3">', '</div>')."
</div>
<div class='acount_form'><p>Total Amount Will Be Transfer :".CURRENCY."  </p>
<input type='text' class='acount-input' id='payamount' size='15' name='payamount' title='Enter your milestone payment amount' tooltipText='How much money would you like to transfer ?' readonly='readonly'/>    
".form_error('payamount', '<div class="error-msg3">', '</div>')."
</div>";	
		}
      echo $result;  
        
        
    }
    
    
    public function milestonepay(){ 
        
/* Page Details Start */
        
        $user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$acc_balance=$data['balance'];
                
                $data['project_list']=$this->myfinance_model->getProjectList($user[0]->user_id);

                $data['outgoint_milestone_list']=$this->myfinance_model->getOutgoingMilestone($user[0]->user_id);
                
                $data['incoming_milestone_list']=$this->myfinance_model->getIncomingMilestone($user[0]->user_id);                
		
                
                
		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='milestone';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);
	
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
/* Page Details End */        
        
       if($this->input->post("pay_btn")){ 
           
          
           $this->form_validation->set_rules('project_id', 'Project', 'required');
           $this->form_validation->set_rules('payamount', 'Transfer Amount', 'required|numeric');
           $this->form_validation->set_rules('reason_txt', 'Reason', 'required');
           if ($this->form_validation->run() == FALSE){ 
               $this->layout->view('milestone',$lay,$data,'normal');    
           }
           else{
			    
		   		$chk_escrow=$this->auto_model->getFeild('id',"escrow","project_id",$this->input->post('project_id'));
				$pln_id=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);
                $bidwin_charge=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$pln_id);
				
                $post_data['bider_to_pay']=($this->input->post('payamount')-($this->input->post('payamount')*$bidwin_charge)/100);
                $post_data['employer_id'] =$user[0]->user_id;
                $post_data['project_id'] = $this->input->post('project_id');
                $post_data['worker_id'] = $this->input->post('worker_id');
                $post_data['payamount'] = $this->input->post('payamount');                
                $post_data['reason_txt'] = $this->input->post('reason_txt'); 
                $insert = $this->myfinance_model->insertMilestone($post_data);
                 
                if($insert){ 
                    
                    $data_transaction=array(
						"project_id" =>$this->input->post('project_id'),
                        "user_id" =>$user[0]->user_id,
                        "amount" =>$this->input->post('payamount'),
			            "profit" => ($this->input->post('payamount')*$bidwin_charge)/100,
                        "transction_type" =>"DR",
                        "transaction_for" => "Milestone Payment",
                        "transction_date" => date("Y-m-d H:i:s"),
                        "status" => "Y"
                    );

					if($chk_escrow>0)
					{
						$esc_balance=$this->auto_model->getFeild('payamount',"escrow","id",$chk_escrow);
						$balance=($esc_balance-$this->input->post('payamount'));	
					}
					else
					{
						$balance=($acc_balance-$this->input->post('payamount'));
					}
                    

                    if($this->myfinance_model->insertTransaction($data_transaction)){
					if($chk_escrow>0)
					{
						$this->myfinance_model->updateEscrow($balance,$chk_escrow);
						if($balance==0)
						{
							$status="I";
							$this->myfinance_model->update_Escrow($status,$chk_escrow);	
						} 
					}
					else
					{
						$this->myfinance_model->updateUser($balance,$user[0]->user_id);  
					}
					
					$from=ADMIN_EMAIL;
					$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$this->input->post('project_id'));
					$title=$this->auto_model->getFeild('title','projects','project_id',$this->input->post('project_id'));
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
					$template='milestone_set_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);	 
                    
                       $this->session->set_flashdata('succ_msg', 'Milestone is set successfully.You can release the milestone later.');
                       redirect(VPATH."myfinance/milestone");
                       
                    }              
                } 
                else{ 
                    $this->session->set_flashdata('error_msg', 'Milestone Payment Filed');
                    redirect(VPATH."myfinance/milestone");
                }
             $this->layout->view('milestone',$lay,$data,'normal');    
           }
           
       }
       else{ 
           $this->layout->view('milestone',$lay,$data,'normal');         
       }
    }

    public function releasepayment($milestone_id=''){
		 
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","milestone_id",$milestone_id); 
		$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid);
		
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
        
		$milestone_payment_status = $this->auto_model->getFeild("release_payment","project_milestone","id",$milestone_id); 
		
		$next = get('next');
		if($milestone_payment_status == 'Y'){
			if(!empty($next)){
				redirect(base_url($next));
			}
			redirect(VPATH."projectdashboard/milestone_employer/".$pid);
		}
		
      
		$data_milistone=array(
			"release_type" =>"P",
			"status" => "Y"
		);
        $this->myfinance_model->updateMilestone($data_milistone,$mid);	
		
		$val['release_payment']='Y';
		$val['fund_release']='A';
		$where=array("id"=>$milestone_id);
		$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
		
		$return_row=$this->myfinance_model->checkproject_milestone($pid);
		if($return_row==0)
		{
			/* $proj_data['status']='C';
			$this->myfinance_model->updateProject($proj_data,$pid); */
			
			/* ask user whether he want to complete the project or not */
			$url_query = parse_url($next, PHP_URL_QUERY);
			if($url_query){
				$next .= '&call_bk=confirm_complete&p_id='.$pid;
			}else{
				$next .= '?call_bk=confirm_complete&p_id='.$pid;
			}
			
		}
		
		$from=ADMIN_EMAIL;
		$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
		$title=$this->auto_model->getFeild('title','projects','project_id',$pid);
		$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
		$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
		$template='milestone_release_notification';
		$data_parse=array('name'=>$fname." ".$lname,
							'title'=>$title
							);
		
		/* send_layout_mail($template, $data_parse, $to_mail); */
		$bidder_id=$to_id;
		$employer_id=$data['user_id'];
		$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
		
		$notification = htmlentities("You have successfully release milestone: ".$milestone_title." for ".$projects_title);
		$link = "projectroom/employer/milestone/".$pid;
		$this->notification_model->log($employer_id, $employer_id, $notification, $link);
			
			
		$notification1 = htmlentities("Payment received for milestone: ".$milestone_title." for the project  ".$projects_title);
		$link1 = "projectroom/freelancer/milestone/".$pid;
		$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
		
		$this->session->set_userdata('succ_msg',"You have successfully release this milestone");
		

		if(!empty($next)){
			redirect(base_url($next));
		}
        
  
    }
    
    
    public function dispute($milestone_id=''){ 
		
		$mid=$this->auto_model->getFeild("id","milestone_payment","milestone_id",$milestone_id); 
		
		$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);       
        
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
        
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );
        
        $did=$this->myfinance_model->insertDispute($data_dispute);
               
        if($did){          
            
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);    
            
            
            $data_dispute_discuss=array(            
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);
			
			$val['release_payment']='D';
			$where=array("id"=>$milestone_id);
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			
			$post_data['from_id']=$employer_id;
			$post_data['to_id']=$worker_id;
			/*$post_data['notification']="One of your project: <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a> has been disputed. Please check your <a href='".VPATH."disputes/'>disputes list</a>.";
			$post_data['add_date']=date('Y-m-d');
			$post_data['read_status']='N';
			$this->dashboard_model->insert_Notification($post_data); */
			
			$notification = "One of your project: ".$project_title." has been disputed. Please check your disputes list.";
			$link = 'disputes/';
			$this->notification_model->log($employer_id, $worker_id, $notification, $link);
			
            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			
			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
		/*	$data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the milestone: <a href='".VPATH."myfinance/milestone/".$project_id."'>".$milestone_title."</a> for <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status" =>'N'
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>Milestone: ".$milestone_title."</a> have been disputed for the project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status" =>'N'
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				 
				 $notification = "You have successfully dispute the milestone: ".$milestone_title." for ".$project_title;
				$link = "myfinance/milestone/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Milestone: ".$milestone_title." have been disputed for the project ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
			
			$this->session->set_userdata('mile_succ',"You have successfully dispute this milestone");        
            
        }
        else{ 
            $this->session->set_userdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        }
		
		redirect(VPATH."myfinance/milestone/".$project_id);
        
        
                
    }    














    /*  public function check_balance(){ 
       $user=$this->session->userdata('user');       
       $balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
       if($balance>=$amt){
           return TRUE;
       } 
       else{ 
           $this->form_validation->set_message("check_balance", 'The %s field can not be the word "test"');
           return FALSE;
       }
    } */

	
	
	
	
	
	public function wire_setting(){
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id'] = $user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);
		
	
		
		
		
		
		
		 if($this->input->post("save_wire")){ 
           
          
           $this->form_validation->set_rules('wire_account_no', 'Account Number', 'required');
           $this->form_validation->set_rules('wire_account_name', 'Account Name', 'required');
         /*  $this->form_validation->set_rules('wire_account_IFCI_code', 'IFCI code', 'required');*/
           $this->form_validation->set_rules('address', 'Address', 'required');
           $this->form_validation->set_rules('city', 'City', 'required');
		   $this->form_validation->set_rules('country', 'Country', 'required');
		   $this->form_validation->set_rules('wire_account_email', 'Email', 'required|valid_email');
		   if($this->form_validation->run() == FALSE){ 
		   
            $this->layout->view('wire_transfare',$lay,$data,'normal');    
           
		   }else{ 
          
			
		  
				$post_data['wire_account_no']= $this->input->post('wire_account_no');
                $post_data['user_id'] =  $user[0]->user_id;
                $post_data['wire_account_name'] = $this->input->post('wire_account_name');
                $post_data['wire_account_IFCI_code'] = $this->input->post('wire_account_IFCI_code');
                $post_data['city'] = $this->input->post('city');                
                $post_data['country'] = $this->input->post('country'); 
				$post_data['address'] = $this->input->post('address'); 
				$post_data['wire_account_email'] = $this->input->post('wire_account_email'); 
				
				$post_data['account_for'] = 'W';
				
				$post_data['status'] = 'Y';
				
				
                $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', 'Bank account is set successfully.');
					
					}else{
					
					$this->session->set_flashdata('error_msg', 'Error on update please try again');
					
					}
					
					redirect(VPATH."myfinance/wire_setting");
		   
		   }
		   
	
		}else{
		
		$this->layout->view('wire_transfare',$lay,$data,'normal');      
        
		}
		
		
		
		
        }
	
	
	
	}
	
	
	
	public function paypal_setting(){
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance','My Finance'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('deposite_by_paypal_fees' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		 if($this->input->post("update")){ 
           $this->form_validation->set_rules('paypal_account', __('myfinance_paypal_account_no','PayPal Account Number'), 'required');
		   if($this->form_validation->run() == FALSE){ 
		   
				$this->layout->view('paypal_setting',$lay,$data,'normal');    
           
			}else{ 
		   
			
		   $post_data['paypal_account']= $this->input->post('paypal_account');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['account_for'] =  $this->input->post('account_for');
		   $post_data['status'] =  'Y';
		   
		  
		   $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', 'Detail successfully updated');
					
					}else{
					
					$this->session->set_flashdata('error_msg', 'Error on update please try again');
					
					}
					
					//redirect(VPATH."myfinance/paypal_setting");
					redirect(VPATH."myfinance/withdraw");
		   
		   
          
			 }
			}else{
			$this->layout->view('paypal_setting',$lay,$data,'normal');      
			}
       
	   }
	
	
	
	}
	public function skrill_setting(){
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('deposite_by_paypal_fees' ,'setting', 'id',1);
		$data['skrill_fees'] =$this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		 if($this->input->post("update")){ 
           $this->form_validation->set_rules('skrill_account', 'Skrill Account Number', 'required');
		   if($this->form_validation->run() == FALSE){ 
		   
				$this->layout->view('skrill_account',$lay,$data,'normal');    
           
			}else{ 
		   
			
		   $post_data['skrill_account']= $this->input->post('skrill_account');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['account_for'] =  $this->input->post('account_for');
		   $post_data['status'] =  'Y';
		   
		   
		   $insert = $this->myfinance_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', 'Skrill account is set successfully.');
					
					}else{
					
					$this->session->set_flashdata('error_msg', 'Error on update please try again');
					
					}
					
					redirect(VPATH."myfinance/skrill_setting");
		   
		   
          
			 }
			}else{
			$this->layout->view('skrill_setting',$lay,$data,'normal');      
			}
       
	   }
	
	
	
	}
	public function transfer(){
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
	

		$data['tras_type'] = $this->uri->segment(3);
	
		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              
                
		$data['balance']=$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=$balance=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		$data['skrill_fees'] =$this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		
		
		
		
		if($this->input->post("save_wire")){ 
			
			$this->form_validation->set_rules('$balance', 'Total balance', '');
           $this->form_validation->set_rules('amount_transfer', 'Amount', 'required');
		   if($this->form_validation->run() == FALSE){ 
			$this->layout->view('transaction',$lay,$data,'normal');    
			}else{ 
			
			$post_data['transer_through'] =	$this->input->post('transfer_through'); 
		   
		   $post_data['admin_pay']= $this->input->post('total_amount');
		   $post_data['account_id']= $this->input->post('account_id');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['total_amount'] =  $this->input->post('amount_transfer');
		   $post_data['status'] =  'N';
		   if($post_data['total_amount']> $balance)
		   {
				  $this->session->set_flashdata('error_msg', 'Transfer amount should not be greater than your total balance'); 
				  redirect(VPATH."myfinance/transfer".strtolower($this->input->post('transfer_through')));
			}
			else
			{
		   
		   
				$insert = $this->myfinance_model->add_withdrawl($post_data);
				$withdraw_id = $this->db->insert_id();
				if($insert){
				
					$t_data['user_id'] =$user[0]->user_id;
					$t_data['amount'] = $this->input->post('amount_transfer');
					$t_data['profit'] = ($this->input->post('amount_transfer') - $this->input->post('total_amount'));
					$t_data['transction_type'] = "DR";
					$t_data['transaction_for'] = "Withdrawl";
					$t_data['transction_date'] = date('Y-m-d h:i:s');
					$t_data['status'] = 'N';
					
					$transation = $this->myfinance_model->add_transation($t_data);
					$txn_id = $this->db->insert_id();
					$this->db->where('withdrawl_id', $withdraw_id)->update('withdrawl', array('transaction_id' => $txn_id));
					
					
					$user_balance =  $this->input->post('user_balance');
					
					$updatet_balance = $user_balance - $this->input->post('amount_transfer');
					
					
					$this->myfinance_model->updateUser($updatet_balance,$user[0]->user_id);
					
					$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
					
					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='withdrawl_request_notification';
					$data_parse=array('name'=>$fname." ".$lname
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					
					$this->session->set_flashdata('succ_msg', 'Your request has been submitted.');

				}else{

				$this->session->set_flashdata('error_msg', 'Error on update please try again');

				}
				

				redirect(VPATH."myfinance/withdraw");
			   
			}
          
			}
		}else{
			
			$this->layout->view('transaction',$lay,$data,'normal');
			}
		
		
		
		

		
	
	
	}
	
	}
	
	
	public function send_withdraw_otp(){
		/*$this->load->library('mailtemplete');*/
		$user=$this->session->userdata('user');
		if($user){
			$user_id = $user[0]->user_id;
			$withdraw_amount = $this->input->post('amount_transfer');
			$otp = rand(1111111, 9999999);
			
			$expire_on = date('Y-m-d H:i:s', strtotime("+5 minutes"));
			
			$this->db->where('user_id', $user_id)->update('user', array('otp' => $otp, 'otp_expire_on' => $expire_on));
			// send mail to user
			
			$param = array(
				"NAME" => $this->auto_model->getFeild('fname', 'user', 'user_id', $user_id),
				"AMOUNT" => CURRENCY.$withdraw_amount,
				"OTP" => $otp,
			);
			$to_email = $this->auto_model->getFeild('email', 'user', 'user_id', $user_id);
			
			$contact = $this->auto_model->get_setting();
			$from = ADMIN_EMAIL;
			/* $ml=$this->mailtemplete->send_mail($from, $to_email, 'withdraw_otp', $param); */
			
		
			$template = 'withdraw_otp';
			send_layout_mail($template, $param, $to_email);
			
			$json['status'] = 1;
			/* $json['otp'] = $otp; */
			$json['msg'] = 'An OTP has been send to your email id. Enter OTP to confirm withdraw';
			
			echo json_encode($json);
		}
		
	}
	
	public function transfer_ajax(){
		if($this->input->post()){
			$json = array();
			$user=$this->session->userdata('user');
			$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$balance=get_wallet_balance($user_wallet_id);
			
			$this->form_validation->set_rules('amount_transfer', 'Amount', 'required');
			
			if($this->form_validation->run()){
				
				$post_otp = $this->input->post('otp');
				
				$otp = $this->auto_model->getFeild('otp','user','user_id',$user[0]->user_id);
				$otp_expire_on = $this->auto_model->getFeild('otp_expire_on','user','user_id',$user[0]->user_id);
				
				$curr_time = time();
				
				if(strlen($otp) > 0 && $curr_time <= strtotime($otp_expire_on) && ($otp == $post_otp)){
					
					$post_data['transer_through'] =	$this->input->post('transfer_through'); 
					$post_data['admin_pay']= $this->input->post('total_amount');
					$post_data['account_id']= $this->input->post('account_id');
					$post_data['user_id'] =  $user[0]->user_id;
					$post_data['total_amount'] =  $this->input->post('amount_transfer');
					$post_data['status'] =  'N';
					
					if($post_data['total_amount']>$balance){
						
						$json['status'] = 0;
						$json['msg'] = 'Transfer amount should not be greater than your total balance';
						
						
					}else{
						
						$this->load->model('transaction_model');
						
						$user_account_detail = $this->db->where('account_id', $this->input->post('account_id'))->get('user_bank_account')->row_array();
						
						
						$insert = $this->myfinance_model->add_withdrawl($post_data);
						$withdraw_id = $this->db->insert_id();
						
						$new_txn_id = $this->transaction_model->add_transaction(WITHDRAW_WALLET_FUND,  $user[0]->user_id, 'P');
						
						if($insert && $new_txn_id){
							/* transaction new bishu */
							
							$user_wallet_id = get_user_wallet($user[0]->user_id);
							
							$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $this->input->post('amount_transfer'), 'info' => 'Fund withdraw', 'ref' => json_encode($user_account_detail)));
							
							$this->db->where('user_id', $user[0]->user_id)->update('user', array('otp' => '', 'otp_expire_on' => '0000-00-00 00:00:00'));
							/* No profit will be charged during withdraw */ 
							/* To enable profit just remove the comment from below line code */ 
							//$profit = ($this->input->post('amount_transfer') - $this->input->post('total_amount'));
							//$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $profit, 'info' => 'Withdraw fund fee'));
				
							
							/* end transaction new bishu */
							
							
							
							$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
							$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
							
							$from=ADMIN_EMAIL;
							$to=ADMIN_EMAIL;
							$template='withdrawl_request_notification';
							$data_parse=array('name'=>$fname." ".$lname
							);
							/* $this->auto_model->send_email($from,$to,$template,$data_parse); */
							send_layout_mail($template, $data_parse, $to);
							
							$template='withdrawl_request_user';
							$data_parse=array(
								'NAME'=>$fname." ".$lname,
								'AMOUNT' => format_money($this->input->post('amount_transfer'), TRUE),
							);
							$to = getField('email','user','user_id',$user[0]->user_id);
							send_layout_mail($template, $data_parse, $to);
							
							
							$json['status'] = 1;
							$json['msg'] = 'Your request has been submitted.';
							
							/* $this->session->set_flashdata('succ_msg', 'Your request has been submitted.'); */
							
							
							
							

						}else{
							
							$json['status'] = 0;
							$json['msg'] = 'Error on update please try again';
						}
					}
					
				}else{
					
					$json['status'] = 0;
					$json['msg'] = 'Invalid OTP';
					
				}
				
				
			}else{
				$json['status'] = 0;
				$json['msg'] = validation_errors();
			}
			
			echo json_encode($json);
		}
	}
   
    public function withdraw(){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
              // Get the Question  From model
		$data['question']=$this->myfinance_model->getUpdatedAnswer();
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('my_finance_withdraw_fund','Withdraw fund'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_finance','My Finance'));

                $data['paypal_setting']=$this->auto_model->getFeild('withdrawl_method_paypal','setting');

                $data['wire_setting']=$this->auto_model->getFeild('withdrawl_method_wire_transfer','setting');                 $data['skrill_setting']=$this->auto_model->getFeild('method_skrill','setting');
                  
                
		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		$data['skill_fees'] =  $this->auto_model->getFeild('deposite_by_skrill_fees' ,'setting', 'id',1);
		$data['bank_account'] = $this->myfinance_model->get_account($user[0]->user_id);

		
		

		$this->layout->view('withdrawfund',$lay,$data,'normal');      
        
        }
        
    }
    public function exchagerate(){ 
        $amount=  $this->input->post("amt"); 
		$converted = $amount;
		$paypal_commission_percent = getField('deposite_by_paypal_commission', 'setting', 'id', 1);
		$commission = ($converted * $paypal_commission_percent)/100;
		$converted += $commission;
		$converted += 0.35;
        /*$from="INR";
        $to="USD";
		
        $url  = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);*/
       echo round($converted, 3);
    }
	public function addFundWire()
	{
	
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id'] = $user[0]->user_id;
              
                
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$data['balance']=get_wallet_balance($user_wallet_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'My Finance','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");
		$lay['client_testimonial']="inc/footerclient_logo";

		
		 if($this->input->post("save_wire")){ 
           
          
           $this->form_validation->set_rules('trans_id', 'Transaction Id', 'required');
		   $this->form_validation->set_rules('amount', 'Amount', 'required');
           $this->form_validation->set_rules('payee_name', 'Payee name', 'required');
           $this->form_validation->set_rules('dep_bank', 'Bank name', 'required');
           $this->form_validation->set_rules('dep_date', 'transaction date', 'required');
           
		   if($this->form_validation->run() == FALSE){ 
		   
            $this->layout->view('add_wire',$lay,$data,'normal');    
           
		   }else{ 
          
			
		  
				$post_data['trans_id']= $this->input->post('trans_id');
				$post_data['amount']= $this->input->post('amount');
                $post_data['user_id'] =  $user[0]->user_id;
                $post_data['payee_name'] = $this->input->post('payee_name');
                $post_data['dep_bank'] = $this->input->post('dep_bank');
                $post_data['dep_date'] = $this->input->post('dep_date');                
                $post_data['dep_branch'] = $this->input->post('dep_branch'); 
				
                $insert = $this->myfinance_model->add_wirefund($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', 'Your details have been submitted successfully. Your account will be credited after verification by Admin');
					
					}else{
					
					$this->session->set_flashdata('error_msg', 'Error on submit please try again');
					
					}
					
					redirect(VPATH."myfinance/addFundWire");
		   
		   }
		   
	
		}else{
		
		$this->layout->view('add_wire',$lay,$data,'normal');      
        
		}
		
		
		
		
        }
		
	}
	public function generateCSV()
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{

			$user=$this->session->userdata('user');
            $this->load->database();
			$this->db->select('id,amount,transction_type,transaction_for,activity,transction_date,status');
			$this->db->where('user_id',$user[0]->user_id);
            $query = $this->db->get('transaction');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Transaction_list_'.date("dMy").'.csv');
			
		}
	}
	
	public function generateCSV_new()
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{

			$user=$this->session->userdata('user');
			$wallet_id = get_user_wallet($user[0]->user_id);
           /*  $this->load->database(); */
			$this->db->select("tr.txn_id,tr.debit,tr.credit,tr.info,tr.datetime,if(tn.status='Y', 'success', if(tn.status = 'P', 'pending', 'failed')) as status", false)
				->from('transaction_row tr')
				->join('transaction_new tn', 'tn.txn_id=tr.txn_id', 'LEFT');
				
			$this->db->where('tr.wallet_id', $wallet_id);
			
            $query = $this->db->get();
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Transaction_list_'.date("dMy").'.csv');
			
		}
	}
	
	
	public function ClientApproval($pid='',$st='')
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		elseif($pid=='' && $st=='')
		{
			redirect(VPATH."/dashboard/myproject_client/");	
		}
		else
		{
			$user=$this->session->userdata('user');
			$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
			$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$pid);
			$val['client_approval']=$st;
			$where=array("project_id"=>$pid);
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			if($upd)
			{
				if($st=='Y')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
					$template='milestone_approved_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have approved the <a href='".VPATH."myfinance/milestone/".$pid."'>Milestone Chart</a> for project: <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$pid."'>Milestone Chart</a> have been approved for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "You have approved the Milestone Chart for project: ".$project_title;
				$link = "myfinance/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Milestone Chart have been approved for the project ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',"Congratulation!! You have approved the milestone.");	
				}
				if($st=='D')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
					$template='milestone_decline_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have declined the <a href='".VPATH."myfinance/milestone/".$pid."'>milestone</a> for project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N',
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"<a href='".VPATH."dashboard/MilestoneChart/".$pid."'>Milestone</a> have been declined for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N',
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
				$notification = "You have declined the milestone for project ".$project_title;
				$link = "myfinance/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Milestone have been declined for the project ".$project_title;
				$link1 = "dashboard/MilestoneChart/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',"Congratulation!! You have declined the milestone.");	
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Oops!!Something got wrong.Please Try Again.");	
			}
			if($request_by=='F')
			{
				redirect(VPATH."myfinance/milestone/".$pid);
			}
			else
			{
				redirect(VPATH."dashboard/MilestoneChart/".$pid);	
			}
		}
		
	}
	
	public function releaseFund($milestone_id='',$st=''){
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$this->load->model('transaction_model');
			$this->load->helper('invoice');
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
			
			$milestone_title = $this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
			
			if($st=='A')
			{
				
				$user_wallet_id = get_user_wallet($user[0]->user_id);
				
				$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
				
				$acc_balance=get_wallet_balance($user_wallet_id);
				
				
				$pln_id=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);
				
                $bidwin_charge=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$pln_id);
				
				$bid_id = $this->auto_model->getFeild("bid_id","project_milestone","id",$milestone_id);	
				$bid_row = get_row(array('select' => '*', 'from' => 'bids', 'where' => array('id' => $bid_id)));				
				$admin_fee = $this->auto_model->getFeild("admin_fee","bids","id",$bid_id);
				
				$bidder_id = $this->auto_model->getFeild("bidder_id","bids","id",$bid_id);
				$pid = $this->auto_model->getFeild("project_id","bids","id",$bid_id);
				$employer_id = $this->auto_model->getFeild("user_id","projects","project_id",$pid);
				
				$milestone_amount = $this->auto_model->getFeild("amount","project_milestone","id",$milestone_id);
				 
				/* $commission = (($milestone_amount * SITE_COMMISSION) / (100+SITE_COMMISSION)) ;  */				
				$commission = $admin_fee;
				
				/* $bidder_to_pay = $milestone_amount - $commission; */
				$bidder_to_pay = $bid_row['bidder_amt'];
				$amount_before_tax = $bid_row['bidder_amt'];
				
				$post_data['bider_to_pay']=$bidder_to_pay;
				
               /* $post_data['employer_id'] =$this->auto_model->getFeild("employer_id","project_milestone","id",$milestone_id); */
                $post_data['employer_id'] =$employer_id;
                $post_data['project_id'] = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
				$post_data['milestone_id'] = $milestone_id;
				
              /* $post_data['worker_id'] = $this->auto_model->getFeild("bidder_id","project_milestone","id",$milestone_id); */
                $post_data['worker_id'] = $bidder_id;
               
                $post_data['payamount'] = $milestone_amount;
                $post_data['commission'] = $commission;
			  
                $post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 
				
				$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);
				$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
				
				$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $bidder_id)));
				
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
					'receiver_id' => $bidder_id,
					'invoice_type' => 1,
					'sender_information' => json_encode($sender_info),
					'receiver_information' => json_encode($receiver_info),
					'receiver_email' => $user_info['email'],
					'hst_rate' => HST_RATE,
				
				);
				
				$inv_id = create_invoice($invoice_data); // creating invoice
				
				$invoice_row_data[] = array(
					'invoice_id' => $inv_id,
					'description' => 'Pay amount',
					'per_amount' => $amount_before_tax,
					'unit' => '-',
					'quantity' => 1,
				);
				$invoice_row_data[] = array(
					'invoice_id' => $inv_id,
					'description' => 'Commission ('.SITE_COMMISSION.' %)',
					'per_amount' => $commission,
					'unit' => '-',
					'quantity' => 1,
				);
				
				/* $invoice_row_data[] = array(
					'invoice_id' => $inv_id,
					'description' => 'Commission - ' . SITE_COMMISSION . '% for invoice number #'.$invoice_number,
					'per_amount' => $commission,
					'unit' => '-',
					'quantity' => 1,
				); */
				foreach($invoice_row_data as $k => $v){
					add_invoice_row($v); // adding invoice row
				}
				
				
				add_project_invoice($pid, $inv_id);
				
				
				$post_data['commission_invoice_id'] = $inv_id;
				
				$escrow_check = $this->db->where(array('milestone_id' => $milestone_id, 'status' => 'P', 'project_id' => $project_id))->get('escrow_new')->row_array();
				
				$ref1 = json_encode(array('project_id' => $pid, 'project_type' => 'F', 'milestone_id' => $milestone_id));
				
				if(!empty($escrow_check)){
					
					$bidder_wallet_id = get_user_wallet($bidder_id);
					$bidder_fname = getField('fname', 'user', 'user_id', $bidder_id);
					// deduct milestone amount from escrow and transfer the amount in freelancer account
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user[0]->user_id);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $escrow_check['amount'], 'ref' => $escrow_check['escrow_id'], 'info' => 'Project payment to '.$bidder_fname.' #'.$pid));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => $escrow_check['amount'] , 'ref' => $milestone_id, 'info' => 'Project payment received #'.$pid));
					
					$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $bidder_id, 'Y', $inv_id);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $bidder_wallet_id, 'debit' => $commission , 'ref' => $milestone_id, 'info' => 'Commission paid #'.$pid));
					
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $milestone_id, 'info' => 'Commission received #'.$pid));
					
					$new_txn_id_3 = $this->transaction_model->add_transaction(TAX_PAYMENT,  $bidder_id);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_3, 'wallet_id' => $bidder_wallet_id, 'debit' => $bid_row['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$pid));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_3, 'wallet_id' => TAX_WALLET, 'credit' => $bid_row['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$pid));
					
					wallet_less_fund(ESCROW_WALLET,$escrow_check['amount']);
					
					wallet_add_fund($bidder_wallet_id, $bidder_to_pay);
					
					wallet_add_fund(PROFIT_WALLET, $commission);
					wallet_add_fund(TAX_WALLET, $bid_row['tax_amount']);
					
					check_wallet($bidder_wallet_id,  $new_txn_id);
					check_wallet(ESCROW_WALLET,  $new_txn_id);
					check_wallet(PROFIT_WALLET,  $new_txn_id);
					check_wallet(TAX_WALLET,  $new_txn_id);
					
					$project_txn = array(
						'project_id' => $project_id,
						'txn_id' => $new_txn_id,
					);
					
					$this->db->insert('project_transaction', $project_txn);
					
					$this->db->where('escrow_id', $escrow_check['escrow_id'])->update('escrow_new', array('status' => 'R'));
					
					$insert = $this->myfinance_model->insertMilestone($post_data);
					
					$val['fund_release']=$st;
					$val['commission_invoice_id']=$inv_id;
					$where=array("id"=>$milestone_id);
					$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
					
					$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
					$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); // commission invoice mark as paid
					
					if($upd){
						
						$flg="S";	
						
					}else{
						
						$flg="D";	
					}
					
				}else{
					
					if($acc_balance >= $post_data['payamount']){
						$insert = $this->myfinance_model->insertMilestone($post_data);
						
						if($insert){ 
							
							
								$milestone_pay_amount = $milestone_amount;
								// pay freelancer through employer wallet 
								
								$bidder_wallet_id = get_user_wallet($bidder_id);
								$bidder_fname = getField('fname', 'user', 'user_id', $bidder_id);
					
								// transaction insert
								$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_DIRECT,  $user[0]->user_id);
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => 'Project payment to '.$bidder_fname.' #'.$pid));
								
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $bidder_wallet_id, 'credit' => $milestone_pay_amount, 'ref' => $milestone_id, 'info' => 'Project payment received #'.$pid));
								
								$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $bidder_id, 'Y', $inv_id);
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $bidder_wallet_id, 'debit' => $commission, 'ref' => $milestone_id, 'info' => 'Commission paid #'.$pid));
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $milestone_id, 'info' => 'Commission received #'.$pid));
								
								
								wallet_less_fund($user_wallet_id,$milestone_pay_amount);
								
								wallet_add_fund($bidder_wallet_id, $bidder_to_pay);
								
								wallet_add_fund(PROFIT_WALLET, $commission);
								
								check_wallet($bidder_wallet_id,  $new_txn_id);
								
								check_wallet($user_wallet_id,  $new_txn_id);
								
								check_wallet(PROFIT_WALLET,  $new_txn_id);
								
								$project_txn = array(
									'project_id' => $project_id,
									'txn_id' => $new_txn_id,
								);
								
								$this->db->insert('project_transaction', $project_txn);
					
						} 
						
						$val['fund_release']=$st;
						$val['commission_invoice_id']=$inv_id;
						$where=array("id"=>$milestone_id);
						$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
						
					
						$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
					
						$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); 
					
						
						if($upd){
							$flg="S";	
						}else{
							$flg="D";	
						}
						
					}else{
						$flg="I";	
					}
				
				}
				
				
			}elseif($st=='P'){
				$val['fund_release']=$st;
				$where=array("id"=>$milestone_id);
				$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
				if($upd)
				{
					$flg="P";	
				}
				else
				{
					$flg="D";	
				}
			}
			
		
			if($flg){
				if($flg=='S'){
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
					$employer_id= $this->auto_model->getFeild('user_id','projects','project_id',$project_id);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_released';
					$data_parse=array('USER'=>$fname,
										'PROJECT_TITLE'=>$project_title,
										'AMOUNT'=>format_money($post_data['bider_to_pay'], TRUE),
										'COPY_URL'=>base_url('projectroom/contractor/milestone/'.$project_id),
										);
					send_layout_mail($template, $data_parse, $to_mail);
					/* $this->auto_model->send_email($from,$to_mail,$template,$data_parse); */
					/* send_layout_mail($template, $data_parse, $to_mail); */
					
					/* $to_mail=$this->auto_model->getFeild('email','user','user_id',$employer_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$employer_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$employer_id);
					$template='payment_release_employer';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										'amount'=>$post_data['bider_to_pay']
										);
					send_layout_mail($template, $data_parse, $to_mail); */
					
					
					/* $from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='add_fund_escrow';
					$data_parse=array('title'=>$project_title
					);
					send_layout_mail($template, $data_parse, $to); */
					
					
						$post_data['employer_id'] =$employer_id;
						
						$this->session->set_flashdata('succ_msg',"Congratulation!! Fund added in Escrow Successfully.");
						
				}elseif($flg=='P'){
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_declined';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										);
					/* send_layout_mail($template, $data_parse, $to_mail); */
					
					$post_data['employer_id'] =$this->auto_model->getFeild("employer_id","project_milestone","id",$milestone_id);					
					
					$notification = "You have declined the Fund request for milestone: ".$milestone_title." for project ".$project_title;
					$link = "projectdashboard_new/employer/milestone/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
					
					$notification1 = "Your Fund request declined for milestone: ".$milestone_title." for the project ".$project_title;
					$link1 = "projectdashboard_new/freelancer/milestone/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);
				
					
					$this->session->set_flashdata('succ_msg',"Congratulation!! You have declined the request.");	
				}elseif($flg=='I'){
					
					$this->session->set_flashdata('error_msg',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet.");	
					
				}elseif($flg=='D'){
					$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");	
				}
			}else{
				$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");		
			}
			$next = get('next');
			
			if(!empty($next)){
				redirect(VPATH."myfinance/releasepayment/".$milestone_id.'?next='.$next);
			}
			redirect(VPATH."myfinance/releasepayment/".$milestone_id);
		}
	}
	
	public function cancelpayment($id='')
    {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		elseif($id=='')
		{
			redirect(VPATH."/dashboard/myproject_client/");	
		}
		else
		{
			$user=$this->session->userdata('user');
			$pid = $this->auto_model->getFeild("project_id","project_milestone","id",$id);
			$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$id);
			$milestone_title = $this->auto_model->getFeild("title","project_milestone","id",$id);
			$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
			$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$pid);
			$val['release_payment']='C';
			$val['invoice_id']=0;
			$where=array("id"=>$id);
			$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_deleted' => date('Y-m-d H:i:s')));
			$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
			if($upd)
			{
				
					$from=ADMIN_EMAIL;
					$bidder_id= $this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$pid);
					$template='payment_declined_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					/* $data_notification=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$employer_id,
						   "notification" =>"You have declined the payment for milestone: <a href='".VPATH."myfinance/milestone/".$pid."'>".$milestone_title."</a> for project: <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" => "N"
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$employer_id,
						   "to_id" =>$bidder_id,
						   "notification" =>"Payment have been canceled for milestone: <a href='".VPATH."dashboard/MilestoneChart/".$pid."'>".$milestone_title."</a> for the project <a href='".VPATH."projectdashboard/index/".$pid."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>"N"
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "You have declined the payment for milestone: ".$milestone_title." for project: ".$project_title;
				$link = "projectdashboard_new/employer/milestone/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Payment have been canceled for milestone: ".$milestone_title." for the project ".$project_title;
				$link1 = "projectdashboard_new/freelancer/milestone/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
				
				
					$this->session->set_flashdata('succ_msg',"Congratulation!! You have Canceled the payment.");	
				
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Oops!!Something got wrong.Please Try Again.");	
			}
			
			$ref = $this->input->server('HTTP_REFERER');
			if($ref){
				redirect($ref);
			}else{
				redirect(VPATH."myfinance/milestone/".$pid);
			}
			
			
		}	
	}
	
	public function releasefund_hourly($tracker_id="")
	{
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_tracker","id",$tracker_id);
			$worker_id = $this->auto_model->getFeild("worker_id","project_tracker","id",$tracker_id);
			$start_time = $this->auto_model->getFeild("start_time","project_tracker","id",$tracker_id);
			$stop_time = $this->auto_model->getFeild("stop_time","project_tracker","id",$tracker_id);
			$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$freelancer_amt=$this->auto_model->getFeild("bidder_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
				
			$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$acc_balance=get_wallet_balance($user_wallet_id);
			
			$seconds_new = strtotime($stop_time) - strtotime($start_time);
			if($seconds_new<1){
				$seconds_new=0;
				}
			$days_new    = floor($seconds_new / 86400);
			$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
			$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
			$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
			$total_cost_client=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
			$total_cost_bidder=$freelancer_amt*(($days_new*24)+$hours_new+$minutes_new/60);
	
			
			$post_data['bider_to_pay']=$total_cost_bidder;
			$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
			$post_data['project_id'] = $project_id;
			$post_data['milestone_id'] = '0';
			if($post_data['employer_id']!=$user[0]->user_id){
				redirect(VPATH);
				exit();
			}
			
			$post_data['worker_id'] = $worker_id;
			$post_data['payamount'] = $total_cost_client;
							
			$post_data['reason_txt'] = "Hourly job paid"; 
			
			$post_data['tracker_id'] = $tracker_id; 
			if($acc_balance >= $post_data['payamount'])
			{
				$insert = $this->myfinance_model->insertMilestone($post_data);
				 
				if($insert){ 
					
					$data_transaction=array(
						"user_id" =>$user[0]->user_id,
						"amount" =>$post_data['payamount'],
						"profit" => ($post_data['payamount']-$post_data['bider_to_pay']),
						"transction_type" =>"DR",
						"transaction_for" => "Add Fund To Escrow",
						"transction_date" => date("Y-m-d H:i:s"),
						"status" => "Y"
					);

					$balance=($acc_balance-$post_data['payamount']);
					
					

					if($this->myfinance_model->insertTransaction($data_transaction)){
					
					$this->myfinance_model->updateUser($balance,$user[0]->user_id);  
					
					
				/*	$from=ADMIN_EMAIL;
					$to_id=$post_data['worker_id'];
					$title=$this->auto_model->getFeild('title','projects','project_id',$post_data['project_id']);
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
					$template='milestone_set_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);*/
					  
					}              
				} 
				
				$val['escrow_status']='Y';
				$where=array("id"=>$tracker_id);
				$upd=$this->myfinance_model->updateProjectTracker($val,$where);
				if($upd)
				{
					$flg="S";	
				}
				else
				{
					$flg="D";	
				}
			}
			else
			{
				$flg="I";	
			}
			
			
			
			/////Set Success//////////
			if($flg)
			{
				if($flg=='S')
				{
					$from=ADMIN_EMAIL;
					$bidder_id= $worker_id;
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$worker_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$worker_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$worker_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_approved';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										'amount'=>$post_data['bider_to_pay']
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
					
					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='add_fund_escrow';
					$data_parse=array('title'=>$project_title
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
					/* $data_notification=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$post_data['employer_id'],
						   "notification" =>"Fund added in Escrow Successfully for hourly job for the project: <a href='".VPATH."projecthourly/employer/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status" =>'N'
						 );
						 
						 $data_notic=array( 
						   "from_id" =>$post_data['employer_id'],
						   "to_id" =>$worker_id,
						   "notification" =>"Fund added in Escrow for hourly job for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
						   "add_date"  => date("Y-m-d"),
						   "read_status"=>'N'
						 );
						 
						 $this->myfinance_model->insert_notification($data_notification);
						 
						 $this->myfinance_model->insert_notification($data_notic); */
						 
						 
				$notification = "Fund added in Escrow Successfully for hourly job for the project: ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
				
				$notification1 = "Fund added in Escrow for hourly job for the project ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($post_data['employer_id'], $worker_id, $notification1, $link1);
					
					$this->session->set_flashdata('succ_msg',"Congratulation!! Fund added in Escrow Successfully.");	
				}
				elseif($flg=='I')
				{
					$this->session->set_flashdata('error_msg',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet.");	
				}	
				elseif($flg=='D')
				{
					$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");	
				}
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");		
			}
			redirect(VPATH."projecthourly/employer/".$project_id);
		}
		
	}
	
	public function releasepayment_hourly($tracker_id='')
	{
		
		 
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid);
		
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
        
        $pay_amt=($worker_balance+$bider_to_pay);
        
            $data_transaction=array(
                "user_id" =>$wid,
                "amount" =>$bider_to_pay,
                "transction_type" =>"CR",
                "transaction_for" => "Milestone Payment",
                "transction_date" => date("Y-m-d H:i:s"),
                "status" => "Y"
            );         
          if($this->myfinance_model->insertTransaction($data_transaction)){ 
             
              $this->myfinance_model->updateUser($pay_amt,$wid); 
           
            $data_milistone=array(
                "release_type" =>"P",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);
			
			if($ptype=='F')
			{
			
				$total_bid_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
				$paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
				if($total_bid_amount==$paid_amount)
				{
					$proj_data['status']='C';
					$this->myfinance_model->updateProject($proj_data,$pid);	
				}
			}
			
			$val['payment_status']='P';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker($val,$where);
			
			$from=ADMIN_EMAIL;
			$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
			$title=$this->auto_model->getFeild('title','projects','project_id',$pid);
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_release_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
			$bidder_id=$to_id;
			$employer_id=$data['user_id'];
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
			
			/* $data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully release hourly job payment for <a href='".VPATH."projecthourly/employer/".$pid."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$bidder_id,
				   "notification" =>"Payment received for hourly job payment for the project <a href='".VPATH."projecthourly/freelancer/".$pid."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				  $notification = "You have successfully release hourly job payment for ".$projects_title;
				$link = "projectdashboard_new/hourly_employer/".$pid;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Payment received for hourly job payment for the project ".$projects_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$pid;
				$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
			
			$this->session->set_flashdata('succ_msg',"You have successfully release this payment");
            
        }
        else{ 
            $this->session->set_flashdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        }
		
		redirect(VPATH."projecthourly/employer/".$pid);
        
        
	}
	
	public function dispute_hourly($tracker_id="")
	{
		 
		
		$mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
		      
        
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
        
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );
        
        $did=$this->myfinance_model->insertDispute($data_dispute);
               
        if($did){          
            
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);    
            
            
            $data_dispute_discuss=array(            
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);
			
			$val['payment_status']='D';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker($val,$where);
			
			/*$post_data['from_id']=$employer_id;
			$post_data['to_id']=$worker_id;
			$post_data['notification']='One of your project has been disputed. Please check you disputes list.';
			$post_data['add_date']=date('Y-m-d');
			$this->dashboard_model->insert_Notification($post_data);*/
			
            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			
			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
		/*	$data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the hourly job payment for <a href='".VPATH."projecthouly/employer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"Hourly Job payment have been disputed for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 
				 $this->myfinance_model->insert_notification($data_notification);
				 
				 $this->myfinance_model->insert_notification($data_notic); */
				 
				 $notification = "You have successfully dispute the hourly job payment for ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Hourly Job payment have been disputed for the project ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
			
			$this->session->set_flashdata('succ_msg',"You have successfully dispute this milestone");        
            
        }
        else{ 
            $this->session->set_flashdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        }
		
		redirect(VPATH."projecthourly/employer/".$project_id);
	}
	
	
	///////////////////////For Manual hourly Payment///////////////////
	
	public function releasefund_hourly_manual($tracker_id="")
	{		

		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else
		{
			$flg="";
			$user=$this->session->userdata('user');
			$project_id = $this->auto_model->getFeild("project_id","project_tracker_manual","id",$tracker_id);
			$worker_id = $this->auto_model->getFeild("worker_id","project_tracker_manual","id",$tracker_id);
			$hour = $this->auto_model->getFeild("hour","project_tracker_manual","id",$tracker_id);			
			$client_amt=$this->auto_model->getFeild("total_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$freelancer_amt=$this->auto_model->getFeild("bidder_amt",'bids','','',array("project_id"=>$project_id,"bidder_id"=>$worker_id));
			$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
			
			$this->load->model('transaction_model');
			
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$acc_balance=get_wallet_balance($user_wallet_id);
			
			$total_cost_client=$client_amt*floatval($hour);
			$total_cost_bidder=$freelancer_amt*floatval($hour);
			
			$post_data['bider_to_pay']=$total_cost_bidder;
			$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
			$post_data['project_id'] = $project_id;
			$post_data['milestone_id'] = '0';
			$post_data['worker_id'] = $worker_id;
			$post_data['payamount'] = $total_cost_client;
			$post_data['reason_txt'] = "Hourly job paid";
			$post_data['tracker_id'] = $tracker_id; 
			if($acc_balance >= $post_data['payamount'])
			{
				$insert = $this->myfinance_model->insertMilestone($post_data);
				$milestone_ins_id = $this->db->insert_id();
				if($insert){
					
					
				
					/* $data_transaction=array(
						"user_id" =>$user[0]->user_id,
						"amount" =>$post_data['payamount'],
						"profit" => ($post_data['payamount']-$post_data['bider_to_pay']),
						"transction_type" =>"DR",
						"transaction_for" => "Add Fund To Escrow",
						"transction_date" => date("Y-m-d H:i:s"),
						"status" => "Y"
					);
					$balance=($acc_balance-$post_data['payamount']);
					 */
					// fund added to escrow	

					$ins['data'] = array(
						'milestone_id' => $milestone_ins_id,
						'amount' => $post_data['payamount'],
						'project_id' => $project_id,
						'status' => 'P',
					);
					
					$ins['table'] = 'escrow_new';
					
					insert($ins);
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(PROJECT_PAYMENT_ESCROW,  $user[0]->user_id);
					
					$ref1 = json_encode(array('manual_traker_id' => $tracker_id, 'project_type' => 'H', 'project_id' => $project_id, 'milestone_payment_id' => $milestone_ins_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $post_data['payamount'], 'ref' => $ref1, 'info' => 'Hourly project fund added to escrow'));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $post_data['payamount'], 'ref' => $ref1, 'info' => 'Hourly project fund added to escrow'));
					
					wallet_less_fund($user_wallet_id, $post_data['payamount']);
					
					wallet_add_fund(ESCROW_WALLET,$post_data['payamount']);
					
					check_wallet($user_wallet_id,  $new_txn_id);
					
					check_wallet(ESCROW_WALLET,  $new_txn_id);
					
					
					/* if($this->myfinance_model->insertTransaction($data_transaction)){	
					$this->myfinance_model->updateUser($balance,$user[0]->user_id); 				  

					}   */  


				} 		

				$val['escrow_status']='Y';
				$where=array("id"=>$tracker_id);
				$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);
				
				if($upd){
					
					$flg="S";
					
				}else{
					
					$flg="D";
					
				}
				
			}else{
				$flg="I";	
			}

			/////Set Success//////////

			if($flg){
				
				if($flg=='S'){

					$from=ADMIN_EMAIL;
					$bidder_id= $worker_id;
					$to_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
					$project_title= $this->auto_model->getFeild('title','projects','project_id',$project_id);
					$template='fund_approved';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$project_title,
										'amount'=>$post_data['bider_to_pay']
										);
					$this->auto_model->send_email($from,$to_mail,$template,$data_parse);			

					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='add_fund_escrow';
					$data_parse=array('title'=>$project_title
					);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
					$post_data['employer_id'] =$this->auto_model->getFeild("user_id","projects","project_id",$project_id);
				
					$notification = "Fund added in Escrow Successfully for hourly job for the project: ".$project_title;
					$link = "projectdashboard/hourly_employer/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $post_data['employer_id'], $notification, $link);
					
					$notification1 = "Fund added in Escrow for hourly job for the project ".$project_title;
					$link1 = "projectdashboard/hourly_freelancer/".$project_id;
					$this->notification_model->log($post_data['employer_id'], $bidder_id, $notification1, $link1);						 

					$this->session->set_flashdata('succ_msg',"Congratulation!! Fund added in Escrow Successfully.");	

				}elseif($flg=='I'){
					
					$this->session->set_flashdata('error_msg',"Oops!! You have insufficient fund in your wallet. Please add fund in your wallet.");	
					
				}elseif($flg=='D'){
					
					$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");	
					
				}
			}else{
				$this->session->set_flashdata('error_msg',"Oops!! Something got wrong. Please try again later.");
			}
			
			//redirect(VPATH."projectdashboard/employer/".$project_id);
			redirect(VPATH.get('next'));
		}		

	}

	

	public function releasepayment_hourly_manual($tracker_id=''){
		
		$this->load->model('transaction_model');
		
     	$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
	    $mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id); 
        $pid=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
        $wid=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		$ptype=$this->auto_model->getFeild("project_type","projects","project_id",$pid);
        $bider_to_pay=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid); 
        $worker_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$wid); 
			
		$user_wallet_id = get_user_wallet($wid);
		$worker_balance=get_wallet_balance($user_wallet_id);
		
		// transaction insert
		
		$escrow_row_check = $this->db->where(array('project_id' => $pid, 'milestone_id' => $mid, 'status' => 'P'))->get('escrow_new')->row_array();
		
		if(!empty($escrow_row_check)){
			
			$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user[0]->user_id);
		
			$ref1 = json_encode(array('manual_tracker_id' => $tracker_id, 'project_type' => 'H', 'milestone_payment_id' => $mid, 'project_id' => $pid));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $bider_to_pay, 'ref' => $ref1, 'info' => 'Freelancer payment through escrow wallet'));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' =>  $bider_to_pay, 'ref' => $ref1, 'info' => 'Hourly project payment through escrow'));
			
			wallet_less_fund(ESCROW_WALLET,$bider_to_pay);

			wallet_add_fund($user_wallet_id, $bider_to_pay);

			check_wallet($user_wallet_id,  $new_txn_id);
			
			check_wallet(ESCROW_WALLET,  $new_txn_id);
			
			$this->db->where('escrow_id', $escrow_row_check['escrow_id'])->update('escrow_new', array('status' => 'R'));
		}
		
		

		
        /* $pay_amt=($worker_balance+$bider_to_pay);   
		$activity = $this->auto_model->getFeild("activity","project_tracker_manual","id",$tracker_id); 
		if($activity){
			$act_arr = array();
			$act = $this->db->where("id IN ($activity)")->get('project_activity')->result_array();
			if(count($act) > 0){
				foreach($act as $k => $v){
					$act_arr[] = $v['task'];
				}
			}
			$act_str = implode(',', $act_arr);
		}else{
			$act_str = '';
		}
            $data_transaction=array(
                "user_id" =>$wid,
                "amount" =>$bider_to_pay,
                "transction_type" =>"CR",
                "transaction_for" => "Milestone Payment",
                "transction_date" => date("Y-m-d H:i:s"),
				"activity" => $act_str,
                "status" => "Y"
            );    */
			
		$data_milistone=array(
			"release_type" =>"P",
			"status" => "Y"
		);
        $this->myfinance_model->updateMilestone($data_milistone,$mid);
		
		$val['payment_status']='P';
		$where=array("id"=>$tracker_id);
		$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);	
		
		$from=ADMIN_EMAIL;
		$to_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
		$title=$this->auto_model->getFeild('title','projects','project_id',$pid);
		$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
		$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
		$template='milestone_release_notification';
		$data_parse=array('name'=>$fname." ".$lname,
							'title'=>$title
							);
		$this->auto_model->send_email($from,$to_mail,$template,$data_parse);			

		$bidder_id=$to_id;
		$employer_id=$data['user_id'];
		$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);		

		


		$notification = "You have successfully release hourly job payment for ".$projects_title;
		$link = "projectdashboard/hourly_employer/".$pid;
		$this->notification_model->log($employer_id, $employer_id, $notification, $link);
		
		$notification1 = "Payment received for hourly job payment for the project ".$projects_title;
		$link1 = "projectdashboard/hourly_freelancer/".$pid;
		$this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);
	
		$this->session->set_flashdata('succ_msg',"You have successfully release this payment");
			
		/*if($this->myfinance_model->insertTransaction($data_transaction)){   
              $this->myfinance_model->updateUser($pay_amt,$wid); 
            

			 if($ptype=='F')
			{		

				$total_bid_amount=$this->auto_model->getFeild("bidder_amt","bids","","",array("project_id"=>$pid,"bidder_id"=>$wid));
				$paid_amount=$this->myfinance_model->getPaidAmount($pid,$wid);
				if($total_bid_amount==$paid_amount)
				{
					$proj_data['status']='C';
					$this->myfinance_model->updateProject($proj_data,$pid);	
				}
			}		

			
			  
        }else{ 
            $this->session->set_flashdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        } */		
		
		/* if(get('next')){
			
			$next = get('next');
		} */
		//redirect(VPATH."projecthourly/employer/".$pid);            
		//redirect(VPATH."projectdashboard/employer/".$pid);   
		
		redirect(VPATH.get('next'));      
		

	}

	

	public function dispute_hourly_manual($tracker_id="")
	{	

		$mid=$this->auto_model->getFeild("id","milestone_payment","tracker_id",$tracker_id);  
		$project_id=$this->auto_model->getFeild("project_id","milestone_payment","id",$mid);
		$project_title=$this->auto_model->getFeild("title","projects","project_id",$project_id);
        $disput_amt=$this->auto_model->getFeild("bider_to_pay","milestone_payment","id",$mid);
        $employer_id=$this->auto_model->getFeild("employer_id","milestone_payment","id",$mid);
        $worker_id=$this->auto_model->getFeild("worker_id","milestone_payment","id",$mid);
		
		$this->db->where(array('milestone_id' => $mid, 'project_id' => $project_id))->update('escrow_new', array('status' => 'D'));
		
        $data_dispute=array(
            "milestone_id" => $mid, 
            "employer_id" =>$employer_id,
            "worker_id" =>$worker_id,
            "disput_amt" =>$disput_amt,
            "add_date"=> date("Y-m-d"),
            "status"=>"N"
        );      

        $did=$this->myfinance_model->insertDispute($data_dispute);
        if($did){
            $data_milistone=array(
                "release_type" =>"D",
                "status" => "Y"
            );
            $this->myfinance_model->updateMilestone($data_milistone,$mid);  
			
            $data_dispute_discuss=array( 
                "disput_id" => $did,
                "employer_id" => $employer_id,
                "worker_id" => $worker_id,
                "employer_amt" => $disput_amt,
                "worker_amt" => "0.00",
                "accept_opt" => "W",
                "status" => "N",
            );      
            $this->myfinance_model->insertDisputDiscuss($data_dispute_discuss);	

			$val['payment_status']='D';
			$where=array("id"=>$tracker_id);
			$upd=$this->myfinance_model->updateProjectTracker_manual($val,$where);

            $from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='dispute_notification';
			$data_parse=array('title'=>$project_title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);		

			$from=ADMIN_EMAIL;
			$to_id= $worker_id;
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
			$template='milestone_dispute_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title
								);
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
			/* $data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully dispute the hourly job payment for <a href='".VPATH."projecthouly/employer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );		 

				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$worker_id,
				   "notification" =>"Hourly Job payment have been disputed for the project <a href='".VPATH."projecthourly/freelancer/".$project_id."'>".$project_title."</a>",
				   "add_date"  => date("Y-m-d")
				 );	 

				 $this->myfinance_model->insert_notification($data_notification);	
				 $this->myfinance_model->insert_notification($data_notic);	*/		
				
				$notification = "You have successfully dispute the hourly job payment for ".$project_title;
				$link = "projectdashboard_new/hourly_employer/".$project_id;
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				
				$notification1 = "Hourly Job payment have been disputed for the project ".$project_title;
				$link1 = "projectdashboard_new/hourly_freelancer/".$project_id;
				$this->notification_model->log($employer_id, $worker_id, $notification1, $link1);
				
				
				
			$this->session->set_flashdata('succ_msg',"You have successfully dispute this milestone");  
        }
        else{ 
            $this->session->set_flashdata('error_msg',"Oops!!Something Got Wrong. Please Try Again Later.");
        }
		/* if(get('next')){
			$next = get('next');
		} */
		//redirect(VPATH."projecthourly/employer/".$project_id);
		redirect(VPATH.get('next'));
	}
	
	///////////////////////For Manual hourly Payment///////////////////

    
	public function migrate_wallet_balance(){
		/*$this->load->model('transaction_model');
		
		$users = $this->db->get('user')->result_array();
		foreach($users as $user){
			$user_wallet_id = get_user_wallet($user['user_id']);
			$prev_balance = $user['acc_balance'];
			
			// transaction insert
			$new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_MANUAL,  $user['user_id']);
		
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $prev_balance, 'ref' => '', 'info' => 'Fund added by admin'));
				
			wallet_add_fund($user_wallet_id, $prev_balance);
			
			check_wallet($user_wallet_id,  $new_txn_id);
		
		}*/
	}
	
	/* ----------------------- Milestone dispute function  ------------------------------*/
	
	public function disputeMilestone($milestone_id='', $project_id=''){
		
		if(!$milestone_id != ''){
			return false;
		}
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}else{
			$this->load->helper('project');
			$user = $this->session->userdata('user');
			$user_id = $user[0]->user_id;
			//$project_id = getField('project_id', 'project_milestone', 'id', $milestone_id);
			$owner_id = getField('user_id', 'projects', 'project_id', $project_id);
			$bid_id = getField('bid_id', 'project_milestone', 'id', $milestone_id);
			$worker_id = getField('bidder_id', 'bids', 'id', $bid_id);
			$project_title  = getField('title', 'projects', 'project_id', $project_id);
			
			$escrow_row = $this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id, 'status' => 'P'))->get('escrow_new')->row_array();
			$escrow_id = $escrow_row['escrow_id'] ? $escrow_row['escrow_id'] : 0;
				
			if($owner_id == $user_id){
				
				// update status as D in escrow_new table
				
				$this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id, 'status' => 'P'))->update('escrow_new', array('status' => 'D'));
				
				
				// update release_payment status as D in project_milestone table
				
				$this->db->where(array('id' => $milestone_id, 'release_payment' => 'R', 'project_id' => $project_id))->update('project_milestone', array('release_payment' => 'D'));
				
				
				$ins['data'] = array(
					'milestone_id' => $milestone_id,
					'project_id' => $project_id,
					'escrow_id' => $escrow_id,
					'employer_id' => $owner_id,
					'worker_id' => $worker_id,
					'add_date' => date('Y-m-d'),
				);
				$ins['table'] = 'dispute';
				$dispute_id = insert($ins, TRUE);
				
				$notification = "You have successfully dispute the payment for ".$project_title;
				$link = "projectroom/employer/milestone/".$project_id;
				$this->notification_model->log($owner_id, $owner_id, $notification, $link);
				
				
				$notification1 = "Payment have been disputed for the project ".$project_title;
				$link1 = "projectroom/freelancer/milestone/".$project_id;
				$this->notification_model->log($owner_id, $worker_id, $notification1, $link1);
				
				$user_fname= $this->auto_model->getFeild('fname','user','user_id',$user_id);
				$to_id= $worker_id;
				$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
				$template='milestone_dispute_notification';
				$data_parse=array(
					'name'=>$fname." ".$lname,
					'PROJECT'=>$project_title,
					'USER'=>$user_fname,
				);
				send_layout_mail($template, $data_parse, $to_mail);
				
			
			}else if(is_bidder($user_id, $project_id)){
				
				
				// update status as D in escrow_new table
				$this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id, 'status' => 'P'))->update('escrow_new', array('status' => 'D'));
				
				// update release_payment status as D in project_milestone table
				
				$this->db->where(array('id' => $milestone_id, 'release_payment' => 'R', 'project_id' => $project_id))->update('project_milestone', array('release_payment' => 'D'));
				
				$ins['data'] = array(
					'milestone_id' => $milestone_id,
					'project_id' => $project_id,
					'escrow_id' => $escrow_id,
					'employer_id' => $owner_id,
					'worker_id' => $worker_id,
					'add_date' => date('Y-m-d'),
				);
				$ins['table'] = 'dispute';
				$dispute_id = insert($ins, TRUE);
				
				$notification = "You have successfully dispute the payment for ".$project_title;
				$link = "projectroom/freelancer/milestone/".$project_id;
				$this->notification_model->log($worker_id, $worker_id, $notification, $link);
				
				
				$notification1 = "Payment have been disputed for the project ".$project_title;
				$link1 = "projectroom/employer/milestone/".$project_id;
				$this->notification_model->log($worker_id, $owner_id, $notification1, $link1);
				
				$user_fname= $this->auto_model->getFeild('fname','user','user_id',$user_id);
				$to_id= $owner_id;
				$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$to_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$to_id);
				$template='milestone_dispute_notification';
				$data_parse=array(
					'name'=>$fname." ".$lname,
					'title'=>$project_title,
					'USER'=>$user_fname,
				);
				send_layout_mail($template, $data_parse, $to_mail);
				
			}
			
			$ref = $this->input->server('HTTP_REFERER');
			if($ref){
				redirect($ref);
			}else{
				redirect(VPATH."projectdashboard/milestone_employer/".$project_id);
			}
		}
	}
	
	
	public function project_all_transaction($project_id='', $limit_from=0){
		
		if(empty($project_id)){
			return false;
		}
		$this->load->library('pagination');
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
		$data['project_id'] = $srch['project_id'] = $project_id; 
		$data['project_title'] = getField('title', 'projects', 'project_id', $project_id);
		
		$data['all_data'] = $this->myfinance_model->getProjectAllTxn($srch,  $start, $per_page);
		$data['all_data_count'] = $this->myfinance_model->getProjectAllTxn($srch, '', '', FALSE);
		
		
		$config["base_url"] = base_url()."myfinance/project_all_transaction/".$project_id;
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt; Previous';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';                 
		
		$this->pagination->initialize($config); 
		
		$data['links']=$this->pagination->create_links(); 
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('project_all_txn', $lay, $data, 'normal'); 
	}
	
	public function add_fund_paypal(){
		$user = $this->session->userdata('user');
		if(!$user){
			redirect(base_url('login'));
		}
		$data['user_id'] = $user[0]->user_id;
		$data['amount'] = get('amt');
		$data['cmd'] = get('cmd');
		if(!empty($data['cmd'])){
			
			if($data['cmd'] == 'award_job'){
				$data['bid_id'] = get('b_id');
				if(empty($data['bid_id'])){
					return false;
				}
			}
			
			if($data['cmd'] == 'featured_project'){
				$data['project_id'] = get('project_id');
				if(empty($data['project_id'])){
					return false;
				}
				
				$project_type = getField('project_type', 'projects', 'project_id', $data['project_id']);
				if($project_type == 'H'){
					$data['amount'] = HOURLY_RATE;
				}else if($project_type == 'F'){
					$data['amount'] = FIXED_RATE;
				}else{
					$data['amount'] = 0;
				}
			}
			
			if($data['cmd'] == 'deposit_project_fund'){
				$data['project_id'] = get('project_id');
				if(empty($data['project_id'])){
					return false;
				}
				
				$project_type = getField('project_type', 'projects', 'project_id', $data['project_id']);
				if($project_type == 'F'){
					return false;
				}
			}
			
			if($data['cmd'] == 'process_invoice'){
				$data['project_id'] = get('project_id');
				$data['invoice_id'] = get('invoice_id');
				if(empty($data['project_id']) || empty($data['invoice_id'])){
					return false;
				}
				
				$project_type = getField('project_type', 'projects', 'project_id', $data['project_id']);
				if($project_type == 'F'){
					return false;
				}
			}
			
			if($data['cmd'] == 'bonus_to_freelancer'){
				$data['freelancer_id'] = get('freelancer_id');
				$data['reason'] = urlencode(htmlentities(trim(get('reason'))));
				$data['project_id'] = get('project_id');
				
				if(empty($data['freelancer_id'])){
					return false;
				}
				
			}
			
			if($data['cmd'] == 'feature_profile'){
				$data['feature_type'] = get('feature_type');
				if(empty($data['feature_type'])){
					return false;
				}
			}
			
			
		}
		
		$ins['data'] = array('api' => 'paypal', 'status' => 'P');
		$ins['table'] = 'payment_track';
		$data['track_id'] = insert($ins, TRUE);
		$this->load->view('paypal_pay', $data);
	}
	
	public function paypal_process(){
		$data = array();
		$data['next'] = urldecode(get('next'));
		$data['track_id'] = get('track_id');
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('paypal_process', $lay, $data, 'normal'); 
	}
	
	public function check_track_status($track_id=''){
		$status = getField('status', 'payment_track', 'track_id', $track_id);
		if($status == 'S'){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function make_payment_stripe(){
		$user = $this->session->userdata('user');
		if(!$user){
			redirect(base_url('login'));
		}
		$user_id = $user[0]->user_id;
		$user_wallet_id = get_user_wallet($user_id);
		/* $secret_key = 'sk_test_mMTbmXzTYyUVPubjY16qFxI5'; */
		$this->load->helper('stripe');
		$api=\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
		$token  = $this->input->post('token');
		$payamount = $this->input->post('amount');
		
		try {
		  $charge = \Stripe\Charge::create(array(
			  'card' => $token,
			  'amount'   => $payamount*100,
			  'currency' => 'CAD',
			   "expand" => array("balance_transaction")
		  ));
		}catch (Exception $e) {
			$error = $e->getMessage();
		}	
		
		if($charge['paid']){
			$stripe_fee = get_stripe_fee($payamount);
			$balance_transaction=$charge['balance_transaction'];
			if($balance_transaction){
				$stripe_fee=clean_money_format($balance_transaction['fee']/100);
			}
			$this->load->model('transaction_model');
			$new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_STRIPE,  $user_id);
			// credit main wallet 
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'credit' => $payamount, 'ref' => $charge['balance_transaction'], 'info' => 'Fund added through Stripe. <a href="'.$charge['receipt_url'].'"  target="_blank">See Receipt</a>'));
			
			// transfer money from main wallet to user wallet 
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'debit' => $payamount, 'ref' => $charge['balance_transaction'], 'info' => 'Fund added through Stripe. <a href="'.$charge['receipt_url'].'"  target="_blank">See Receipt</a>'));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $payamount, 'ref' => $charge['balance_transaction'], 'info' => 'Fund added through Stripe. <a href="'.$charge['receipt_url'].'" target="_blank">See Receipt</a>'));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $stripe_fee, 'ref' => $charge['balance_transaction'], 'info' => 'Transaction Fee'));
		
			
			
			wallet_add_fund($user_wallet_id, ($payamount-$stripe_fee));
			check_wallet($user_wallet_id,  $new_txn_id);
			
			$dataR['response'] = $charge;
			$dataR['status']='ok';
			
			$cmd = get('cmd');
			if($cmd){
				$this->_stripe_execute_command($cmd, $user_id);
			}
			
		}elseif($error){
			$dataR['status']='fail';
			$dataR['message']=$error;
		}else{
			$dataR['status']='fail';
			$dataR['message']='Error with processing payment.  Please contact support.';
		}
		echo json_encode($dataR);
		
	}
	
	private function _stripe_execute_command($cmd='', $user_id=''){
		if($cmd == 'award_job'){
			$bid_id = get('b_id');
			if(!$bid_id){
				return;
			}
			
			$this->myfinance_model->award_freelancer($bid_id, $user_id);
			
		}
		
	
	}
	
	
	
	
}
