<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Affiliate extends MX_Controller {



    /**

     * Description: this used for check the user is exsts or not if exists then it redirect to this site

     * Paremete: username and password 

     */

    public function __construct() {
 $this->load->helper('captcha');
        $this->load->helper('recaptcha');
        $this->load->library('MY_Validation');
        
        $this->load->model('affiliate_model');
		$this->load->model('membership/membership_model');
		$this->load->model('signup/signup_model');
        parent::__construct();

    }



    public function index() {

	if($this->uri->segment(3)){
		$uid=base64_decode($this->uri->segment(3));
		$v_code=$this->uri->segment(4);
		$new_data['status']='N';
		$new_data['v_stat']='Y';
		if($this->affiliate_model->updateuser($new_data,$uid,$v_code)){
			$this->session->set_flashdata('refer_succ_msg','Account varified');
			redirect(VPATH.'affiliate');
		}
	}
	$breadcrumb=array(
					array(
						'title'=>'Login','path'=>''
					)
				);
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Login');
	$head['current_page']='user_affiliate';	
	$head['ad_page']='login';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	$table='contents';
	$by="cms_unique_title";
	$val='login';
	$data['refer']=$this->input->get('refer');
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);       
	$this->autoload_model->getsitemetasetting("meta","pagename","Login");
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('affiliate',$lay,$data,'normal');
    }
	
	

	public function logincheck() {
	$this->auto_model->checkrequestajax();
	 if($this->input->post()){	
	  $post_data = $this->input->post();
		 echo $this->affiliate_model->login($post_data);
	 }
    }
    public function signupcheck() {
	$this->auto_model->checkrequestajax();
	 if($this->input->post()){		
	  $post_data = $this->input->post();
		 echo $this->affiliate_model->register($post_data);
	 }
    }
    public function logout() {
        $this->session->unset_userdata('user_affiliate');
        redirect(VPATH."affiliate/");
    }
	public function check() {
	    $this->auto_model->checkrequestajax();
	     if($this->input->post()){
	      $post_data = $this->input->post();
	            echo  $this->affiliate_model->editprofile($post_data);
	     }
	}
    public function doAffiliate() {
    	
    	$code=$this->uri->segment(3);
    	$affliate_id = base64_decode($code);
    	$checkid=$this->autoload_model->getFeild('status','user_affiliate','user_id',$affliate_id);
     	if($checkid=='Y'){
			$this->session->set_userdata('user_affiliate_set', $affliate_id);
		}
     	redirect(VPATH."signup/");    	
    }
    public function dashboard($limit_from='') {
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else
	{
		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['affiliatecode']= base64_encode($data['user_id']);
		$data['balance']=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		
		$lay['leftpanel']="inc/affiliate_left";

		$head['current_page']='dashboard';
		
		$head['ad_page']='dashboard';
		$load_extra=array();
		
		
		
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'affiliate/dashboard/';
		
		$this->db->join('user','user_affiliate_list.user_id = user.user_id','left');
		$this->db->order_by('user_affiliate_list.id ','desc');
		$tquery=$this->db->get_where('user_affiliate_list',array('user_affiliate_list.affiliate_id'=>$user[0]->user_id));
		$total=$tquery->num_rows();
		$config['total_rows'] =$total;
		$config['per_page'] = 20; 
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;   
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		$data['links']=$this->pagination->create_links();
		$data['affiliatelist']=$this->affiliate_model->getuserlist($user[0]->user_id,$config['per_page'],$start);
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$table='contents';
		$by="cms_unique_title";
		$val='login';
		$this->autoload_model->getsitemetasetting("meta","pagename","Dashboard");
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('dashboard',$lay,$data,'normal');
	}

  }
	
	public function transaction($limit_from=''){ 
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else{

		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;      
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['balance']=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                     'title'=>'My Finance','path'=>''
                    )
                );
		$lay['leftpanel']="inc/affiliate_left";
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');
		$head['current_page']='all_transaction';
		$head['ad_page']='myfinance';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'affiliate/transaction/';
		if($this->input->post())
		{
			$from=$this->input->post('from_txt');
			$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$total_rows=$this->affiliate_model->getfilterTransactionCount($user[0]->user_id,$from,$to);
			}
			else
			{
				$total_rows=$this->affiliate_model->getTransactionCount($user[0]->user_id);		
			}
		}
		else
		{
			$total_rows=$this->affiliate_model->getTransactionCount($user[0]->user_id);	
		}
		
                
        $config['total_rows'] =$total_rows;
		$config['per_page'] = 5; 
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;  
                
                $config['full_tag_open'] = "<div class='pagination'><ul>";
                $config['full_tag_close'] = '</ul></div>';
                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li><a href='javascript:void(0)'><b>";
                $config['cur_tag_close'] = '</b></a></li>';
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
		
		$data['tot_debit']=$this->affiliate_model->getAlldebit($user[0]->user_id);
		$data['tot_credit']=$this->affiliate_model->getAllcredit($user[0]->user_id); 
		$data['from']='';
		$data['to']='';
		if($this->input->post())
		{
			//print_r($this->input->post()); die();
			$data['from']=$from=$this->input->post('from_txt');
			$data['to']=$to=$this->input->post('to_txt');
			if($from && $to)
			{
				$data['transaction_list']=$this->affiliate_model->filterTransaction($user[0]->user_id,$from,$to,$config['per_page'],$start);	
			}
			else
			{
				$data['transaction_list']=$this->affiliate_model->getTransaction($user[0]->user_id,$config['per_page'],$start);	
			}	
		}
		else
		{
                
        	$data['transaction_list']=$this->affiliate_model->getTransaction($user[0]->user_id,$config['per_page'],$start);
		}

		$this->layout->view('transaction',$lay,$data,'normal');      
        
        }
        
    }
    
	
	/**
	* ************Edit Profile************
	*/
	
	    public function editprofile() {
	  	 if(!$this->session->userdata('user_affiliate')){
			redirect(VPATH."affiliate/");
		}else{
        $user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['affiliatecode']= base64_encode($data['user_id']);	
		$data['username']=$this->auto_model->getFeild('username','user_affiliate','user_id',$user[0]->user_id);
		$data['fname']=$this->auto_model->getFeild('fname','user_affiliate','user_id',$user[0]->user_id);
		$data['lname']=$this->auto_model->getFeild('lname','user_affiliate','user_id',$user[0]->user_id);
		$breadcrumb=array(
		               array(
		                     'title'=>'Edit Profile','path'=>''
		                 )
		           );
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
         $lay['leftpanel']="inc/affiliate_left";
        $head['current_page']='editprofile_professional';
		$head['ad_page']='edit_profile';
        $load_extra=array();
        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
        $this->layout->set_assest($head);
        $table='contents';
        $by="cms_unique_title";
        $val='editprofile';	    
	    $this->autoload_model->getsitemetasetting("meta","pagename","Edit");
	    $lay['client_testimonial']="inc/footerclient_logo";
	    $this->layout->view('editprofile',$lay,$data,'normal');

    }

}
	/**
	* ************Forgot Password************
	*/
	public function forgot_pass() {
	
	$breadcrumb=array(
            array(
                    'title'=>'Forgot','path'=>''
            )
        );
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Forgot Password');
	$head['current_page']='forgot_pass';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	$table='contents';
	$by="cms_unique_title";
	$val='forgot_pass';
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/
	$this->autoload_model->getsitemetasetting("meta","pagename","Forgot_pass");
	$lay['client_testimonial']="inc/footerclient_logo";
	$this->layout->view('forgot',$lay,$data,'normal');
	
    }
	public function forgot_check() {
	$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		  $insert = $this->affiliate_model->check_email($post_data);
		 
	 }
	
    }
	public function reset_pass() {
		

	 $uid=base64_decode($this->uri->segment(3));
		$v_code=$this->uri->segment(4);

	if($uid=='' || $v_code=='')
	{
			redirect(VPATH.'affiliate');
	}
	else
	{
	$chk=$this->db->get_where('user_affiliate',array('user_id'=>$uid,'MD5(v_code)'=>$v_code))->num_rows();
	
		if(!$chk){
			$this->session->set_flashdata('refer_succ_msg','Invalid Url');
			redirect(VPATH.'affiliate');
			exit();
		}
		
		$data['user_id']=$uid;
		$data['v_code']=$v_code;
		$breadcrumb=array(
            array(
                    'title'=>'Forgot','path'=>''
            )
        );
	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Reset Password');
	$head['current_page']='reset_pass';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	
	$this->autoload_model->getsitemetasetting();
	$lay['client_testimonial']="inc/footerclient_logo";
	
	
	$this->layout->view('resetpass',$lay,$data,'normal');
	}
    }
	public function resetpass() {
	$this->auto_model->checkrequestajax();
	
	 if($this->input->post()){
	  $post_data = $this->input->post();
		  $insert = $this->affiliate_model->reset_password($post_data);
		 
	 }
	}
	
	/**
	* **************User List*********
	*/
	public function userlist($limit_from='') {
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else
	{
		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['affiliatecode']= base64_encode($data['user_id']);
		$data['balance']=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                            'title'=>'User List','path'=>''
                    )
                );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'User List');
		
		$lay['leftpanel']="inc/affiliate_left";

		$head['current_page']='dashboard';
		
		$head['ad_page']='dashboard';
		$load_extra=array();
		
		
		
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'affiliate/userlist/';
		
		$this->db->join('user','user_affiliate_list.user_id = user.user_id','left');
		$this->db->order_by('user_affiliate_list.id ','desc');
		$tquery=$this->db->get_where('user_affiliate_list',array('user_affiliate_list.affiliate_id'=>$user[0]->user_id));
		$total=$tquery->num_rows();
		$config['total_rows'] =$total;
		$config['per_page'] = 20; 
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;   
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		$data['links']=$this->pagination->create_links();
		$data['affiliatelist']=$this->affiliate_model->getuserlist($user[0]->user_id,$config['per_page'],$start);
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$table='contents';
		$by="cms_unique_title";
		$val='login';
		$this->autoload_model->getsitemetasetting("meta","pagename","Dashboard");
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('userlist',$lay,$data,'normal');
	}

  }
	
	/**
	* ************Withdraw Fund 03/06/2015*********
	* 
	* @return
	*/
	public function withdraw(){ 
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else
	{
		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;      
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['balance']=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                     'title'=>'Withdraw','path'=>''
                    )
                );
		$lay['leftpanel']="inc/affiliate_left";
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Withdraw');

                $data['paypal_setting']=$this->auto_model->getFeild('withdrawl_method_paypal','setting');

                $data['wire_setting']=$this->auto_model->getFeild('withdrawl_method_wire_transfer','setting');             

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->affiliate_model->get_account($user[0]->user_id);

		
		

		$this->layout->view('withdrawfund',$lay,$data,'normal');      
        
        }
        
    }
	
	public function paypal_setting(){
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else
	{
		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;      
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['balance']=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                     'title'=>'Withdraw','path'=>''
                    )
                );
		$lay['leftpanel']="inc/affiliate_left";

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Withdraw');

		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('deposite_by_paypal_fees' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->affiliate_model->get_account($user[0]->user_id);

		
		 if($this->input->post("update")){ 
           $this->form_validation->set_rules('paypal_account', 'PayPal Account Number', 'required');
		   if($this->form_validation->run() == FALSE){ 
		   
				$this->layout->view('paypal_setting',$lay,$data,'normal');    
           
			}else{ 
		   
			
		   $post_data['paypal_account']= $this->input->post('paypal_account');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['account_for'] =  $this->input->post('account_for');
		   $post_data['status'] =  'Y';
		   
		   
		   $insert = $this->affiliate_model->modify_account($post_data);
		  
				if($insert){
					
					$this->session->set_flashdata('succ_msg', 'Bank account is set successfully.');
					
					}else{
					
					$this->session->set_flashdata('error_msg', 'Error on update please try again');
					
					}
					
					redirect(VPATH."affiliate/paypal_setting");
		   
		   
          
			 }
			}else{
			$this->layout->view('paypal_setting',$lay,$data,'normal');      
			}
       
	   }
	
	
	
	}

	public function transfer(){
	
	if(!$this->session->userdata('user_affiliate'))
	{
		redirect(VPATH."affiliate/");
	}
	else
	{
		$user=$this->session->userdata('user_affiliate');
		$data['user_id']=$user[0]->user_id;      
		$data['userfnamename']=$user[0]->fname." ".$user[0]->lname;
		$data['balance']=$balance=$this->auto_model->getFeild('acc_balance','user_affiliate','user_id',$user[0]->user_id);

		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                     'title'=>'Withdraw','path'=>''
                    )
                );
		$lay['leftpanel']="inc/affiliate_left";
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Finance');	
		$data['tras_type'] = $this->uri->segment(3);	
		$head['current_page']='myfinance';
		
		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		$data['paypal_fees'] =$this->auto_model->getFeild('withdrawl_commission_paypal' ,'setting', 'id',1);
		$data['wire_transfer_fees'] =  $this->auto_model->getFeild('withdrawl_commission_wire_transfer' ,'setting', 'id',1);
		
		$data['bank_account'] = $this->affiliate_model->get_account($user[0]->user_id);

		if($this->input->post("save_wire")){ 
			//print_r($this->input->post()); die();
			$this->form_validation->set_rules('$balance', 'Total balance', '');
           $this->form_validation->set_rules('amount_transfer', 'Amount', 'required');
		   if($this->form_validation->run() == FALSE){ 
			$this->layout->view('transfer',$lay,$data,'normal');    
			}else{ 
			
		 $post_data['transer_through'] =	$this->input->post('transfer_through'); 
		   
		   $post_data['admin_pay']= $this->input->post('total_amount');
		   $post_data['account_id']= $this->input->post('account_id');
           $post_data['user_id'] =  $user[0]->user_id;
		   $post_data['total_amount'] =  $this->input->post('amount_transfer');
		   $post_data['status'] =  'N';
		   if($post_data['total_amount']>$balance)
		   {
				  $this->session->set_flashdata('error_msg', 'Transfer amount should not be greater than your total balance'); 
				  redirect(VPATH."affiliate/transfer".strtolower($this->input->post('transfer_through')));
			}
			else
			{
		   
		   
			$insert = $this->affiliate_model->add_withdrawl($post_data);

			if($insert){
			
				$t_data['user_id'] =$user[0]->user_id;
				$t_data['amount'] = $this->input->post('amount_transfer');
				$t_data['profit'] = ($this->input->post('amount_transfer') - $this->input->post('total_amount'));
				$t_data['transction_type'] = "DR";
				$t_data['transaction_for'] = "Withdrawl";
				$t_data['transction_date'] = date('Y-m-d h:i:s');
				$t_data['status'] = 'N';
				
				$transation = $this->affiliate_model->add_transation($t_data);
				
				$user_balance =  $this->input->post('user_balance');
				
				$updatet_balance = $user_balance - $this->input->post('amount_transfer');
				
				
				$this->affiliate_model->updateUser_data($updatet_balance,$user[0]->user_id);
				
				$fname=$this->auto_model->getFeild('fname','user_affiliate','user_id',$user[0]->user_id);
				$lname=$this->auto_model->getFeild('lname','user_affiliate','user_id',$user[0]->user_id);
				
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
			redirect(VPATH."affiliate/withdraw");
		   
		   }          
		}
		}else{
			
			$this->layout->view('transfer',$lay,$data,'normal');
			}
	}
	
	}

	
	
	
	
}

