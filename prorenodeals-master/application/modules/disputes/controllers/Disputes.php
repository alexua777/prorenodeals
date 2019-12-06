<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disputes extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('disputes_model');
		$this->load->model('message/message_model');
        parent::__construct();
    }

    public function index(){
     
        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{ 
	
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Dispute Details','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Disputes');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
		
					$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
                    $data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

                    ///////////////////////////Leftpanel Section end//////////////////

                    $head['current_page']='dispute';
					
					$head['ad_page']='dispute_list';

                    $load_extra=array();

                    $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

                    $this->layout->set_assest($head);

                    $this->autoload_model->getsitemetasetting("meta","pagename","Disputes");
                    $data['disput_list']=$this->disputes_model->getDisputesList($user_id);

                    $lay['client_testimonial']="inc/footerclient_logo";	

                    $this->layout->view('list',$lay,$data,'normal');
		}       
        
    }
 
    



    public function details($did){                        
        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
        else{ 
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Dispute Details','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Disputes');

                $data['disput_details']=$this->disputes_model->disputeDetails($did);

                $data['disput_discuss']=$this->disputes_model->disputeDiscuss($did);
				
				$data['disput_conversation']=$this->disputes_model->disputeConversation($did);
                
                  $data['milestone_details']=$this->disputes_model->getMilestoneDetails($data['disput_details']['milestone_id']);
                
                
                    $head['current_page']='dispute';
					
					$head['ad_page']='dispute_discussion';

                    $load_extra=array();

                    $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

                    $this->layout->set_assest($head);

                    $this->autoload_model->getsitemetasetting("meta","pagename","Disputes");
                    $data['disput_list']=$this->disputes_model->getDisputesList($user_id);

                    $lay['client_testimonial']="inc/footerclient_logo";	

                    $this->layout->view('details',$lay,$data,'normal');            
        }            
       
        
    }

    public function closed(){                 
      if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{ 
	
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Dispute Details','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Disputes');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
					$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
                    $data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

                    ///////////////////////////Leftpanel Section end//////////////////

                    $head['current_page']='dispute';
					
					$head['ad_page']='dispute_list';

                    $load_extra=array();

                    $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

                    $this->layout->set_assest($head);

                    $this->autoload_model->getsitemetasetting("meta","pagename","Disputes");
                    $data['disput_list_close']=$this->disputes_model->getClosedDisputesList($user_id);

                    $lay['client_testimonial']="inc/footerclient_logo";	

                    $this->layout->view('list_close',$lay,$data,'normal');
		}                 
       
        
    }
	public function worker_offer()
	{
		if($this->input->post())
		{
			//print_r($this->input->post());
			$worker_amt=$this->input->post('offer_amt');
			$disput_amt=$this->auto_model->getFeild('disput_amt','dispute','id',$this->input->post('dispute_id'));
			if($worker_amt!='')
			{
			if($worker_amt > $disput_amt)
			{
				$this->session->set_flashdata('amt_error',"Offer amount can't be greater than disputed amount.");
				redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
			}
			else
			{
				$new_data['worker_amt']=$worker_amt;
				$new_data['employer_amt']= ($disput_amt - $worker_amt);
				$new_data['accept_opt']='E';
				$upd=$this->disputes_model->updateDiscussion($new_data,$this->input->post('dispute_id'));
				if($upd)
				{
					$this->session->set_flashdata('msg_succ',"Your new offer has been posted successfully");
					redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
				}
				else
				{
					$this->session->set_flashdata('msg_eror',"Post offer unsuccessful. Please try again.");
					redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
				}
			}
			}
			else
			{
				$this->session->set_flashdata('amt_error',"Offer amount can't be left blank.");
				redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));
			}
		}	
	}
	public function employer_offer()
	{
		if($this->input->post())
		{
			//print_r($this->input->post());
			$employer_amt=$this->input->post('offer_amt');
			$disput_amt=$this->auto_model->getFeild('disput_amt','dispute','id',$this->input->post('dispute_id'));
			if($employer_amt > $disput_amt)
			{
				$this->session->set_flashdata('amt_error',"Offer amount can't be greater than disputed amount.");
				redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
			}
			else
			{
				$new_data['employer_amt']=$employer_amt;
				$new_data['worker_amt']= ($disput_amt - $employer_amt);
				$new_data['accept_opt']='W';
				$upd=$this->disputes_model->updateDiscussion($new_data,$this->input->post('dispute_id'));
				if($upd)
				{
					$this->session->set_flashdata('msg_succ',"Your new offer has been posted successfully");
					redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
				}
				else
				{
					$this->session->set_flashdata('msg_eror',"Post offer unsuccessful. Please try again.");
					redirect(VPATH.'disputes/details/'.$this->input->post('dispute_id'));	
				}
			}	
		}	
	}
	public function acceptOffer($did='',$name='')
	{
		 $disput_details=$this->disputes_model->disputeDetails($did);

         $disput_discuss=$this->disputes_model->disputeDiscuss($did);
		 
		 //print_r($disput_discuss); die();
		 
		 $emp_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$disput_details['employer_id']);
		 $wor_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$disput_details['worker_id']);
		 
		 $emp_data['acc_balance']=($disput_discuss[0]['employer_amt']+$emp_balance);
		 $wor_data['acc_balance']=($disput_discuss[0]['worker_amt']+$wor_balance);
		 
		 $transf_emp=$this->disputes_model->updateUser($emp_data,$disput_details['employer_id']);
		 $transf_wor=$this->disputes_model->updateUser($wor_data,$disput_details['worker_id']);
		 
		 
		 if($transf_emp && $transf_wor)
		 {
		 $dis_data['status']='Y';
		 $this->disputes_model->updateDiscussion($dis_data,$did);
		 
		 $disp_data['status']='Y';
		 $this->disputes_model->updateDispute($disp_data,$did);
		 
		 $mile_data['status']='Y';
		 $mile_data['payamount']=$disput_discuss[0]['worker_amt'];
		 $this->disputes_model->updateMilestone($mile_data,$disput_details['milestone_id']);
		 
		 $trans_emp['user_id']=$disput_details['employer_id'];
		 $trans_emp['amount']=$disput_discuss[0]['employer_amt'];
		 $trans_emp['transction_type']='CR';
		 $trans_emp['transaction_for']='Disputed payment';
		 $trans_emp['transction_date']=date('Y-m-d H:i:s');
		 $trans_emp['status']='Y';
		 $this->disputes_model->insertTransaction($trans_emp);
		 
		 $trans_wor['user_id']=$disput_details['worker_id'];
		 $trans_wor['amount']=$disput_discuss[0]['worker_amt'];
		 $trans_wor['transction_type']='CR';
		 $trans_wor['transaction_for']='Disputed payment';
		 $trans_wor['transction_date']=date('Y-m-d H:i:s');
		 $trans_wor['status']='Y';
		 $this->disputes_model->insertTransaction($trans_wor);
		 redirect(VPATH.'disputes/closed');
		 }
	}
    public function message($did,$name)
	{
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Dispute Details','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Disputes');

		$data['disput_details']=$this->disputes_model->disputeDetails($did);

		$data['disput_discuss']=$this->disputes_model->disputeDiscuss($did);
		
		$data['milestone_details']=$this->disputes_model->getMilestoneDetails($data['disput_details']['milestone_id']);
		
		
		$head['current_page']='dispute';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Disputes");
		$data['disput_list']=$this->disputes_model->getDisputesList($user_id);

		$lay['client_testimonial']="inc/footerclient_logo";
		if($this->input->post('submit'))
		{
			
            
                $this->form_validation->set_rules('message', 'Message', 'required');
             
                if($this->form_validation->run()==FALSE){  
                    
                    $this->layout->view('details',$lay,$data,'normal');                    
                }
                else{ 
                     $image="";   

                     
                    $config['upload_path'] ='assets/dispute_file/';
                    $config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';


                    $this->load->library('upload', $config);
                     
                    $uploaded = $this->upload->do_upload();
                    $upload_data = $this->upload->data();
					//print_r($upload_data); die();
                    $fname = $upload_data['file_name'];                     
                     
                  /*?> if (!$uploaded AND $fname == ''){
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error_msg', $error['error']);
                         redirect(base_url()."ireportupload");
                    }   <?php */                 
                    
                    $post_data["message"]=  $this->input->post("message");
                    $post_data["attachment"]=  $fname;
                    $post_data["dispute_id"]=  $did;
                    $post_data["user_id"]=  $user_id;
					$post_data["add_date"]=  date('Y-m-d H:i:s');
                  
                    $insert=  $this->disputes_model->insertMessage($post_data);
	
                    if($insert){
						$this->session->set_flashdata('msg_sent',"Message sent successfully."); 
                        redirect(base_url()."disputes/details/".$did."/".$name);                        
                    }
                    else{
						$this->session->set_flashdata('msg_failed',"Message sending failed"); 
                        redirect(base_url()."disputes/details/".$did."/".$name);                        
                    }
                }
            	
		}	
	}
	
	public function admin_involve($did,$name)
	{
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;
 
		$post_data["admin_involve"]=  'Y';
	  
		$insert=  $this->disputes_model->updateDispute($post_data,$did);

		if($insert){
			$this->session->set_flashdata('admin_request_sent',"Request to admin sent successfully."); 
			redirect(base_url()."disputes/details/".$did."/".$name);                        
		}
		else{
			$this->session->set_flashdata('admin_request_failed',"Request to admin sending failed"); 
			redirect(base_url()."disputes/details/".$did."/".$name);                        
		}
        	
	}

}
