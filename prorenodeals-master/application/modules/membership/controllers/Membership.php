<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membership extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('membership_model');
        parent::__construct();
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('membership', $idiom);
		$this->lang->load('myfinance', $idiom);
    }

    public function index() {
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                $data['user_membership']=$this->auto_model->getFeild('membership_plan','user','user_id',$user[0]->user_id);

		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>__('membership','Membership'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('Membership','Membership'));

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

		$head['current_page']='membership';
		
		$head['ad_page']='membership';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

        $data['membership_plan']=$this->membership_model->getplan();    

	
		$this->autoload_model->getsitemetasetting("meta","pagename","Membership");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('details',$lay,$data,'normal');

	}        
    }

    public function upgrade(){
		
		$this->load->model('myfinance/myfinance_model');
		$this->load->model('myfinance/transaction_model');
		
		$user=$this->session->userdata('user');
		
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		
        $upgrade_type=  $this->input->post("uptype");
        $auto_upgrade=  ($this->input->post("autoup")=="1")? "Y" : "N";
	
        if($upgrade_type!=""){ 
            
	   
            
            $plane=  $this->membership_model->getPlaneDetails(ucfirst(strtolower($upgrade_type)));
            $balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
            $balance= get_wallet_balance($user_wallet_id);
            
            if($balance>=$plane[0]['price']){ 
                $amount=$balance-$plane[0]['price'];
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(MEMBERSHIP_UPGRADE,  $user[0]->user_id);
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $plane[0]['price'], 'ref' => $upgrade_type, 'info' => 'Membership upgrade'));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MEMBERSHIP_WALLET, 'credit' => $plane[0]['price'] , 'ref' => $upgrade_type , 'info' => 'Membership upgrade'));
				
				wallet_less_fund($user_wallet_id,$plane[0]['price']);	
				
				wallet_add_fund(MEMBERSHIP_WALLET ,$plane[0]['price']);			
				
				check_wallet($user_wallet_id,  $new_txn_id);
					
				check_wallet(MEMBERSHIP_WALLET,  $new_txn_id);
				
                $data_transaction=array(
                    "user_id" =>$user[0]->user_id,
                    "amount" =>$plane[0]['price'],
                    "transction_type" =>"DR",
                    "transaction_for" => "Upgrade Membership",
                    "transction_date" => date("Y-m-d H:i:s"),
                    "status" => "Y"
                );
                
                $data_user=array(
                    "membership_plan" =>$plane[0]['id'],
                    "membership_start" => date("Y-m-d"),
                    "membership_end" => date('Y-m-d', strtotime("+".$plane[0]['days']." day", strtotime(date("Y-m-d")))),
                    "membership_upgrade" =>$auto_upgrade,
                    "acc_balance"=>$amount 
                    
                );
                
                if($this->membership_model->insertTransaction($data_transaction)){ 
                    $this->membership_model->updateUser($data_user,$user[0]->user_id);
                    echo 1;
                }
            }
            else{ 
                echo 2;
            }
            
        }      
    }

    public function thankyou(){ 
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;
                $data['user_membership']=$user[0]->membership_plan;

		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

		$data['ldate']=$user[0]->ldate;

		$breadcrumb=array(
                    array(
                            'title'=>'Membership','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Membership');

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

		$head['current_page']='membership';
		
		$head['ad_page']='membership';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

                $data['membership_plan']=$this->membership_model->getplan();    

	
		$this->autoload_model->getsitemetasetting("meta","pagename","Membership");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('thankyou',$lay,$data,'normal');

	}    
        
        
        
    }
    
    
}
