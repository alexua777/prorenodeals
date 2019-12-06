<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class affiliate extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('affiliate_model');
        $this->load->library('form_validation');
		$this->load->library('mailtemplete');
		$this->load->library('pagination');
        $this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }

    public function index() {
	   redirect (base_url(). 'affiliate/page');
       
    }

    
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->affiliate_model->delete_affiliate($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Affiliate Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'affiliate/page');
    }
	public function page($limit_from='')
	{
		$lay['lft'] = "inc/section_left";
		$data['ckeditor'] = $this->editor->geteditor('body','Full');
        $config = array();
        $config["base_url"] = base_url() . "affiliate/page";
        $config["total_rows"] = $this->db->get('user_affiliate_list')->num_rows();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

	    $page = ($limit_from) ? $limit_from : 0;
		$per_page = $config["per_page"];
        $start = 0;
        if($page>0)	
        {   
            for($i = 1; $i<$page; $i++)
            {
                $start = $start + $per_page;		
            }
        }
		
        $data['data']  = 	$this->auto_model->leftPannel();
        $data["links"] = 	$this->pagination->create_links();
		$data["page"]  =	$config["per_page"];
		
        $data['list'] = $this->affiliate_model->getAffiliateList($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
	
	
	
	
	public function change_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$status = 'N';
		if($this->uri->segment(4) == 'act')
			$status = 'Y';
		
		
		$update = $this->affiliate_model->updateStaus($status,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'affiliate/page/');
	
	}
	
	public function withdraw($limit_from=0){	
		 $this->load->model('affiliate_fund_model');
		 
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
	if($this->input->post('pay')){	
		 $this->load->model('affiliate_mass_model');
		$approve=$this->input->post('approve');
		$succ=array();
		$err=array();
		if($approve && is_array($approve)){

			foreach($approve as $ky=>$app){

				$response=$this->affiliate_mass_model->masspay($app);
				if($response['status']=='OK'){
					$succ[]=$response['msg'];
				}else{
					$err[]=$response['msg'];
				}
				if($succ && is_array($succ)){
					 $this->session->set_flashdata('succ_msg',$succ);
				}
				if($err && is_array($err)){
					 $this->session->set_flashdata('error_msg', $err);
				}
			}
			  redirect(base_url()."affiliate/withdraw/");
			
		}
		
		
	
	}
        $config = array();
        $config["base_url"] = base_url()."affiliate/withdraw";
        $config["total_rows"] = $this->affiliate_fund_model->getWithdrawReqCount();
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
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
      
		$data['all_data'] = $this->affiliate_fund_model->getWithdrawlReq($config["per_page"], $start);
   		
		
		
		$this->layout->view('withdrawn', $lay, $data); 
	
	
	
	
	}
	public function paypal_transfer(){
$data['w_id']=  $this->uri->segment(3);	

$acc_id = $this->auto_model->getFeild('account_id',"withdrawl_affiliate",'withdrawl_id',$data['w_id']);
$data['amount_paid'] = $this->auto_model->getFeild('admin_pay',"withdrawl_affiliate",'withdrawl_id',$data['w_id']);
$data['user_id'] = $this->auto_model->getFeild('user_id',"withdrawl_affiliate",'withdrawl_id',$data['w_id']);

$data['paypal_acc'] = 	$this->auto_model->getFeild('paypal_account','user_bank_account_affiliate','account_id',$acc_id);


$data['admin_paypal_acc'] = $this->auto_model->getFeild('paypal_mail','setting','id',1);


$data['data'] = $this->auto_model->leftPannel();
$lay['lft'] = "inc/section_left";
$config = array();
$config["base_url"] = base_url()."affiliate/withdraw";

$this->layout->view('paypal', $lay, $data);   
	
	}
	
    public function payment_confirm(){             
			 //mail("joybhattacharya69@gmail.com","Test","Hello Joy from confirm");
                         
				$withdrawl_id=  $this->uri->segment(3);
				$admin=$this->session->userdata('user');
				$admin_id=$admin->admin_id;
				$data['status']="Y";
				$data['admin_id']=$admin_id;
				$id=$this->fund_model->updateWithdrawl_new($data,$withdrawl_id);
                
				if($this->input->post()){
		
				$this->session->set_flashdata('succ_msg', 'Updated Successfully');
				}
			
				else 
				{
				$this->session->set_flashdata('error_msg', 'Unable to Update');
             
		
				}
				redirect(base_url().'affiliate/withdraw');  
       
               
			}
	
    public function paypal_notify(){   
          //$a=$this->input->post();
		  //echo "aaa";
         //mail("pritamnath@scriptgiant.com","Paypal Mail","Hello Joy from notify");
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
	
		redirect(base_url().'affiliate/withdraw');  
        
    }  
    /**
	* *******member list******
	*/
	public function member_list($limit_from = ''){	
	$this->load->model('member_model');
	$s_key =  $this->uri->segment(3);		
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
	$data['ckeditor'] = $this->editor->geteditor('body','Full');
        $config = array();
         $config["base_url"] = base_url()."affiliate/member_list";
        $config["total_rows"] = $this->member_model->record_count_member();
        $config["per_page"] = 30;
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
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
        //$data($config['per_page'])=3;
		
	if($s_key ==""){
	$data['all_data'] = $this->member_model->getAllMemberList($config['per_page'], $start);
	}else{
	
	$data['all_data'] = $this->member_model->getAllMemberList($config['per_page'], $start,$s_key);

	
	}

   $this->layout->view('mamber_list', $lay, $data);
    }
	public function filtermember($key='')
	{
		$this->load->model('member_model');
		if($key=='')
		{
			redirect(base_url().'affiliate/member_list/');	
		}
		else
		{
			$all_data = $this->member_model->getFilterMemberList($key);	
			
					$attr = array(
					'onclick' => "javascript: return confirm('Do you want to delete?');",
					'class' => 'i-cancel-circle-2 red',
					'title' => 'Delete'
					);
					$attr9 = array(
					'onclick' => "javascript: return confirm('Do you want to make feature this client?');",
					'class' => 'i-checkmark-3 red',
					'title' => 'Normal'
					);
					$attr8 = array(
					'onclick' => "javascript: return confirm('Do you want to remove featured from this client?');",
					'class' => 'i-checkmark-3 green',
					'title' => 'Featured'
					);
					$atr3 = array(
						'onclick' => "javascript: return confirm('Do you want to active this?');",
						'class' => 'i-checkmark-3 red',
						'title' => 'Inactive'
					);
					$atr4 = array(
						'onclick' => "javascript: return confirm('Do you want to inactive this?');",
						'class' => 'i-checkmark-3 green',
						'title' => 'Active'
					);


					if (count($all_data) != 0) {
						foreach ($all_data as $key => $user) {
							
							?>

                            <tr>
								
                                <td align="center"><?php echo $user['user_id']; ?></td>
                                
                                <td><?php echo $user['username']."<br/>".$user['email']; ?></td> 
                                <td><?php echo ucwords($user['fname'])." ".ucwords($user['lname']); ?></td>
                                 <td><?php echo $user['acc_balance']; ?></td>
                                 
                                  <td><?php echo $user['reg_date']."<br/>".$user['edit_date']; ?></td> 
<?=$user['v_status']?>
                                <td>   <?php
                                        if ($user['status'] == 'Y')
                                        {
                                            echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/inact/'.$user['status'], '&nbsp;', $atr4);
                                        }
                                        elseif($user['status'] == 'N')
                                        {
                                            echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/act/'.$user['status'], '&nbsp;', $atr3);
                                        }
										else
										{
											echo "Closed";	
										}
                                        ?>
                                </td>

                                <td align="center">
                                
                                    <?php
                                    $atr1 = array('class' => 'i-highlight', 'title' => 'Edit');
                                    $atr5= array('class' => 'i-mail-2', 'title' => 'Send mail');
                                    $atr_view = array('class' =>'i-eye' ,'title'=> 'View Details');
                                  
                                    echo anchor(base_url() . 'affiliate/change_status_member/' . $user['user_id'].'/del/','&nbsp;', $attr);
                                  
                                    
                                    ?>
                                   
                                </td>
                            </tr>

    						<?php } ?>

                            <? } else { ?>
                                <tr>
                                    <td colspan="6" align="center" class="red">
                                        No Records Found
                                    </td>
                                </tr>
					<?php
					 } 
		}
	}
	 public function change_status_member()
	{
		$this->load->model('member_model');
		$id = $this->uri->segment(3);
		//$type=$this->uri->segment(5);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
			
		if($this->uri->segment(4) == 'del')
		{
			$update = $this->member_model->deleteMember($id);	
		}
		else
		{
                    $update = $this->member_model->updateMemberStatus($data,$id);
                    
		}
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactivation Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			if($this->uri->segment(4) == 'del')
				$this->session->set_flashdata('succ_msg', 'Deletion Successfully Done...');
		} else {
			$this->session->set_flashdata('error_msg', 'Unable to Process.');
		}
		redirect(base_url() . 'affiliate/member_list/');
		
	}
} 

