<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobdetails extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('jobdetails_model');
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('findtalents/findtalents_model');
		$this->load->model('notification/notification_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('jobdetails',$idiom);
        parent::__construct();
    }

    public function details($pid='', $title=''){       
			if(!$this->session->userdata('user')){
				redirect(VPATH."login/?refer=jobdetails/details/".$pid);
			}	
            $user=$this->session->userdata('user');
			$data['available_bid'] = 0;
            if($user){ 
            
              $data['apprivestatus']=$this->auto_model->getFeild('verify','user','user_id',$user[0]->user_id);
				
            
               $data['uid']=$user[0]->user_id;
               $data['logeduser_bid']=  $this->jobdetails_model->getPostBidCount($user[0]->user_id);
               $data['total_plan_bid']=  $this->auto_model->getFeild("bids","membership_plan","id",$user[0]->membership_plan);
	       	   $data['bidwin_charge']=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$user[0]->membership_plan);
			   $data['available_bid'] = get_available_bids($user[0]->user_id);
            }
              
        
        // $data['pid']=$pid=  $this->uri->segment(3);
		
			/* if(!$this->session->userdata('user')){
				redirect(VPATH."login/?refer=jobdetails/details/".$pid);
			} */
           
		$data['pid']=$pid;   
		$userproject= $this->auto_model->getFeild("user_id","projects","project_id",$pid);
		
		$membershipplan = $this->auto_model->getFeild("membership_plan","user","user_id",$userproject);
		
		$data['bidwin_charge']= $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$membershipplan);
		
        $data['project']=  $this->jobdetails_model->getprojectdetails($pid);
        
		if(!$data['project']){
			redirect(base_url('pagenotfound'));
		}
        
        $data['owner_id']=$user_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
        
        $data["totalbid"]=$this->jobdetails_model->gettotalbid($pid);
        $data["avgbid"]=0;
        if($data["totalbid"]!=0){ 
           $data["avgbid"]=($this->jobdetails_model->gettotalbidamt($pid)/$this->jobdetails_model->gettotalbid($pid));    
        }
        
        $data["user_totalproject"]=$this->jobdetails_model->gettotaluserproject($user_id);
        
        $data['user']=  $this->jobdetails_model->getuserdetails($user_id);
        
        
        
        $breadcrumb=array(
            array(
                    'title'=>__('job_details','Job Details'),'path'=>''
            )
        );
		
		
		$data['srch'] = $this->input->get();
		
        $data['bid_details']=  $this->jobdetails_model->getbid_details($pid, $data['srch']);
		//get_print($data['bid_details']);
		 $data['revised_milestone']  = array();
		 
        if($user){ 
           $data['revised_user']=  $this->is_bidder($data['bid_details'],$user[0]->user_id);
		   if($data['revised_user'])  
		   {         
           	 $data['revised_data']=$this->jobdetails_model->getrevised_details($user[0]->user_id,$pid);
			 $bid_row = $this->db->select('id')->from('bids')->where(array('bidder_id' => $user[0]->user_id, 'project_id' => $pid))->get()->row_array();
			 if(!empty($bid_row)){
				$data['revised_milestone'] = $this->jobdetails_model->getmilestone($bid_row['id']); 
			 }
			 
		   }else{
			    $data['revised_data'] = array();
				 $data['revised_milestone']  = array();
		   }           
           
        }       
        
        
        
      //print_r($data);
        
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('job_details','Job Details'));

        $title= $data['project'][0]['title'];

        $image="";

        $desc=html_entity_decode($data['project'][0]['description']);        
        
        $meta_all='<title>'.$title.'</title><meta name="description" content="'.$title.'" /><meta name="keywords" content="'.$title.'" /><meta name="application-name" content="'.$title.'" /><meta property="og:title" content="'.$title.'" /><meta property="og:image" content="'.VPATH.'assets/images/job_detailslogo.png'.'" /><meta property="og:description" content="'.$title.'" /><meta property="og:url" content="'.VPATH.'"jobdetails/details/'.$pid.'" /><meta property="og:site_name" content="'.VPATH.'" /><meta name="twitter:card" content="'.$title.'">
<meta name="twitter:url" content="'.VPATH.'"jobdetails/details/'.$pid.'">
<meta name="twitter:title" content="'.$title.'">
<meta name="twitter:description" content="'.$title.'"><meta name="twitter:image" content="'.VPATH.'assets/images/job_detailslogo.png'.'">';
        
        $data['meta_tag']=$meta_all;
        
        $head['current_page']='jobdetails';
		
		$head['ad_page']='findjob';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting("meta","pagename","Jobdetails");

        $lay['client_testimonial']="inc/footerclient_logo";
	
        $this->layout->view('details',$lay,$data,'normal');

        
    }

    
    public function is_bidder($bidlist,$uid){ 
        $f=FALSE;
        foreach ($bidlist as $row){ 
            if($row['bidder_id']==$uid){ 
                $f=TRUE;
            } 
        }
        return $f;
    }
	
	/* New Bid function */
	
	public function save_bid(){
		$user=$this->session->userdata('user');
		
		$json = array();
		$json['errors'] = array();
		
		if($this->input->is_ajax_request()){
			$post = $this->input->post();
			
			$p_type = $post['project_type'];
			
			if($p_type == 'H'){
				
				$max_hr = getField('hr_per_week', 'projects', 'project_id', $post['pid']);
				$min_budget = getField('buget_min', 'projects', 'project_id', $post['pid']);
				$max_budget = getField('buget_max', 'projects', 'project_id', $post['pid']);
				
				if(empty($post['amount'][0])){
					$json['errors']['amount'] = __('jobdetails_savebid_please_enter_a_valid_value','Please enter a valid value');
				}else if($post['amount'][0] < $min_budget){
					$json['errors']['amount'] = 'Bid amount must be greater or equal to '.CURRENCY.' '.$min_budget;
				}else if($post['amount'][0] > $max_budget){
					$json['errors']['amount'] = 'Bid amount must be lesser or equal to '.CURRENCY.' '.$max_budget;
				}
				
				
				/* if(empty($post['available_hr'])){
					$json['errors']['available_hr'] = __('jobdetails_savebid_please_enter_a_valid_value','Please enter a valid value');
				}else if($post['available_hr'] > $max_hr){
					$json['errors']['available_hr'] = __('jobdetails_savebid_only','Only'). $max_hr .__('jobdetails_savebid_hours_are_allowed_in_a_week','hours are allowed in a week');
				} */
				
				if(empty($post['pid'])){
					$json['errors']['project'] = __('jobdetails_savebid_invalid_request','Invalid request');
				}
				
				
			}else{
				if(empty($post['amount'])){
					$json['errors']['amount'] = __('jobdetails_savebid_please_enter_a_valid_value','Please enter a valid value');
				}else{
					$total_amount = array();
					foreach($post['amount'] as $k => $v){
						$total_amount[] = $v;
					}
					$total_amount = array_sum($total_amount);
					if($total_amount < 10){
						$json['errors']['amount'] = 'Bid amount must be greater or equal to '.CURRENCY.' 10';
					}
				}
				
				if(empty($post['pid'])){
					$json['errors']['project'] = __('jobdetails_savebid_invalid_request','Invalid request');
				}
				
			}
			
			// Check for previous bid
			$prev_count = $this->db->where(array('bidder_id' => $post['bid'] , 'project_id' =>  $post['pid']))->count_all_results('bids');
			
			/*if($prev_count == 0){
				
				$available_bid = get_available_bids($post['bid']);
				if($available_bid == 0){
					$json['errors']['bid'] = __('jobdetails_bid','Your bid limit is over purchase .');
				}
				
			} */
			
			if(count($json['errors']) == 0){
				
				$project_user=$this->auto_model->getFeild('user_id','projects','project_id',$post['pid']);
				
				if(!empty($post['amount']) AND !empty($post['pid']) AND !empty($post['bid'])){
				
					$total_amount = array();
					foreach($post['amount'] as $k => $v){
						$total_amount[] = $v;
					}
					$bidder_amount = $total_amount = array_sum($total_amount);
					$comm_amt = number_format((($total_amount * SITE_COMMISSION)/100), 2);
					$total_amount += $comm_amt;
					
					$tax_amount= (($total_amount*HST_RATE)/100);
					$total_amount += $tax_amount;
					
					$bid_amount=($bidder_amount+$comm_amt);
					
					$bid_data = array(
							'bidder_id' => $post['bid'],
							'project_id' => $post['pid'],
							'project_type' => $post['project_type'],
							'add_date' => date('Y-m-d'),
							'total_amt' => $total_amount,
							'bidder_amt' => $bidder_amount,
							'admin_fee' => $comm_amt,
							'tax_amount' => $tax_amount,
							'status' => 'P',
							'details' => $post['details'],
							'note' => '',
							'bid_amount_request' =>'',
							'attachment' => trim($post['upload_file1'], ','),
							'days_required' => !empty($post['required_days']) ? $post['required_days'] : 0,
							'update_status' => $post['update_status'],
							'available_hr' => !empty($post['available_hr']) ? $post['available_hr'] : 0,
							'enable_escrow' => !empty($post['enable_escrow']) ? $post['enable_escrow'] : 0,
					);
					
					if(!empty($post['payment_at'])){
						$bid_data['payment_at'] = $post['payment_at'];
					}
					
					/* Handle question answers of freelancer */
					
					$answers = post('freelancer_answer');
					
					$questions = post('questions_id');
					$total_ans = count($answers);
					
					$uid = $user[0]->user_id;
					
					if(!empty($answers) && $total_ans > 0){
						
						for($i=0; $i < $total_ans; $i++){
							
							$question_id = $questions[$i]; 
							$answer = $answers[$i]; 
							
							$ans_array = array(
								'freelancer_id' => $uid,
								'question_id' => $question_id,
								'answer' => trim(htmlentities($answer)),
							);
							
							$count_row = $this->db->where(array('freelancer_id' => $uid, 'question_id' => $question_id))->count_all_results('project_answers');
							
							if($count_row > 0){
								$this->db->where(array('freelancer_id' => $uid, 'question_id' => $question_id))->update('project_answers', $ans_array);
							}else{
								$this->db->insert('project_answers', $ans_array);
							}
							
							
							
						}
					}
					
					if($prev_count == 0){
						// Insert Bid
						$ins = $this->db->insert('bids' , $bid_data);
						$ins_id = $this->db->insert_id();
						
						
						/* $used_bid = get_used_bids($post['bid']); // used bid 
						$free_bid = getField('free_bid_per_month', 'setting', 'id', 1); // free bid per month
						
						if($used_bid > $free_bid){
							$this->db->set('available_bids', 'available_bids - 1', FALSE);
							$this->db->where('user_id', $post['bid']);
							$this->db->update('user');
						} */
					
						$from=ADMIN_EMAIL;
						
						$to=$this->auto_model->getFeild('email','user','user_id',$project_user);
						$fname=$this->auto_model->getFeild('fname','user','user_id',$project_user);
						$lname=$this->auto_model->getFeild('lname','user','user_id',$project_user);
						$project_name=$this->auto_model->getFeild('title','projects','project_id',$post['pid']);
						$bidder_fname=$this->auto_model->getFeild('fname','user','user_id',$post['bid']);
						$bidder_lname=$this->auto_model->getFeild('lname','user','user_id',$post['bid']);
						$template='bid_on_job_for_employe';
						$data_parse=array('username'=>$fname." ".$lname,
											'freelancer'=>$bidder_fname." ".$bidder_lname,
											'project'=>$project_name,
											'project_url'=>VPATH.'jobdetails/details/'.$post['pid'],
											'amount'=>format_money($bid_amount, TRUE),
											'duration'=>$post['required_days']
											);
											
						send_layout_mail($template, $data_parse, $to);
						
						
						$bid_plan_limit=$this->auto_model->getFeild('bids','membership_plan','id',$user[0]->membership_plan);

						$bid_count=$this->jobdetails_model->bidCount($user[0]->user_id,'','');

						$available_bid = get_available_bids($user[0]->user_id);
						$available_bid = 100;
						if($available_bid <= 0){

							 $from=ADMIN_EMAIL;

							

							$to=$this->auto_model->getFeild('email','user','user_id',$user[0]->user_id);

							$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);

							$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);

							$template='bid_limit_notification';

							$data_parse=array('name'=>$fname." ".$lname

												);

							
							send_layout_mail($template, $data_parse, $to);

						 }

						
						$notification_content = ucwords($bidder_fname." ".$bidder_lname). ' has placed a bid on '.ucwords($project_name);
						$link = "jobdetails/details/".$post['pid']."/".$this->auto_model->getcleanurl($project_name);
						
						$this->notification_model->log($post['bid'],  $project_user, $notification_content, $link);

					}else{
						// Update Bid amount 
						$ins = $this->db->where(array('bidder_id' => $post['bid'] , 'project_id' =>  $post['pid']))->update('bids' , $bid_data);
						
						$prev_bid_data = $this->db->where(array('bidder_id' => $post['bid'] , 'project_id' =>  $post['pid']))->get('bids')->row_array();
						
						$ins_id = $prev_bid_data['id'];
						
						$bidder_fname=$this->auto_model->getFeild('fname','user','user_id',$post['bid']);
						$bidder_lname=$this->auto_model->getFeild('lname','user','user_id',$post['bid']);
						$project_name=$this->auto_model->getFeild('title','projects','project_id',$post['pid']);

						
						
						$notification_content = ucwords($bidder_fname." ".$bidder_lname). ' has updated his bid on '.ucwords($project_name);
						
						$link = "jobdetails/details/".$post['pid'];
						
						$this->notification_model->log($post['bid'],  $project_user, $notification_content, $link);
						
						$to=$this->auto_model->getFeild('email','user','user_id',$project_user);
						$fname=$this->auto_model->getFeild('fname','user','user_id',$project_user);
						$lname=$this->auto_model->getFeild('lname','user','user_id',$project_user);
						$project_name=$this->auto_model->getFeild('title','projects','project_id',$post['pid']);
						$bidder_fname=$this->auto_model->getFeild('fname','user','user_id',$post['bid']);
						$bidder_lname=$this->auto_model->getFeild('lname','user','user_id',$post['bid']);
						
						$mail_param = array(
							'USER' => $fname,
							'PROJECT_TITLE' => $project_name,
							'FREELANCER' => $bidder_fname,
							'AMOUNT' => format_money($bid_amount, TRUE),
							'JOB_DETAIL_URL' => VPATH.$link,
						);
						
						send_layout_mail('revise_bid', $mail_param, $to);
				
						
						
					}
					
					
					if($ins_id){
						
						if($prev_count > 0){
							$this->db->where('bid_id' , $ins_id)->delete('project_milestone');
						}
						
						if(!empty($post['project_type']) AND $post['project_type'] != 'H'){
							foreach($post['amount'] as $k => $v){
								$milestone_amt_comm = (($post['amount'][$k] * SITE_COMMISSION)/100);
								$milestone_amt = clean_money_format(($post['amount'][$k] + $milestone_amt_comm));
								$milestone_data = array();
								$milestone_data['milestone_no'] = $k+1;
								$milestone_data['project_id'] = $post['pid'];
								$milestone_data['title'] = $post['title'][$k];
								$milestone_data['amount'] = $milestone_amt;
								$milestone_data['bid_id'] = $ins_id;
								$milestone_data['status'] = 'P';
								$milestone_data['mpdate'] = $post['date'][$k];
								
								$this->db->insert('project_milestone' , $milestone_data);
							
							}
						}
						
						
						$json['status'] = 1;
					}
				
				}else{
					$json['errors']['invalid'] = __('jobdetails_savebid_invalid_request','Invalid request');
				}
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
			
		}
	}

	
/*	End of New bid function */
	
    public function check() { 
        $this->auto_model->checkrequestajax();
       
         if($this->input->post()){            
          $post_data = $this->input->post();
          $insert = $this->jobdetails_model->post_bid($post_data);
         }
       
    }	
    
	public function add_fav($obj_id=''){
		$user=$this->session->userdata('user');
		$return = $this->input->get('return');
		if($user){ 
			$data['user_id'] = $user[0]->user_id;
			$data['object_id'] = $obj_id;
			$data['date'] = date('Y-m-d');
			$data['type'] = 'JOB';
			$add = $this->jobdetails_model->addFav($data);
			redirect(base_url($return));
		}else{
			redirect(base_url('login?refer='.$return));
		}
		
	}
	
	
	public function remove_fav($obj_id=''){
		$user=$this->session->userdata('user');
		$return = $this->input->get('return');
		if($user){ 
			$data['user_id'] = $user[0]->user_id;
			$data['object_id'] = $obj_id;
			$data['type'] = 'JOB';
			$add = $this->jobdetails_model->removeFav($data);
			redirect(base_url($return));
		}else{
			redirect(base_url('login?refer='.$return));
		}
		
	}
    
    public function checkquestion(){ 
        $this->auto_model->checkrequestajax();       
         if($this->input->post()){            
          $post_data = $this->input->post();
          $insert = $this->jobdetails_model->post_question($post_data);
         }      
        
    }
  
    
    public function test(){
         
	$msg = "";
	$fileElementName = 'attachment';	
        $msg= $_FILES['attachment']['name'];

        $config['upload_path'] = 'assets/question_file/';
        $config['allowed_types'] = 'pdf|xls|ppt|word|x-zip|zip|doc|docx|gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        $result=array() ;
        $uploded=$this->upload->do_upload('attachment');
        if ($uploded){
            $upload_data = $this->upload->data();
            $result["msg"]=$upload_data['file_name'];
        }
		
	echo json_encode($result);		
 }
 public function invitefriend($pid='')
 {
	if($pid=='')
	{
		redirect(VPATH.'findjob/');
	}
	else
	{
		$project_name=$this->auto_model->getFeild('title','projects','project_id',$pid);
		$user=$this->session->userdata('user');
           
		if($user){ 
		   $data['uid']=$user[0]->user_id;
		   $data['logeduser_bid']=  $this->jobdetails_model->getPostBidCount($user[0]->user_id);
		   $data['total_plan_bid']=  $this->auto_model->getFeild("bids","membership_plan","id",$user[0]->membership_plan);
		   $data['bidwin_charge']=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$user[0]->membership_plan);
		}
		
        $data['pid']=$pid=  $this->uri->segment(3);
        $data['project']=  $this->jobdetails_model->getprojectdetails($pid);
        
        $data['owner_id']=$user_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
        
        $data["totalbid"]=$this->jobdetails_model->gettotalbid($pid);
        $data["avgbid"]=0;
        if($data["totalbid"]!=0){ 
           $data["avgbid"]=($this->jobdetails_model->gettotalbidamt($pid)/$this->jobdetails_model->gettotalbid($pid));    
        }
        
        $data["user_totalproject"]=$this->jobdetails_model->gettotaluserproject($user_id);
        
        $data['user']=  $this->jobdetails_model->getuserdetails($user_id);
        
        
        
        $breadcrumb=array(
            array(
                    'title'=>'Job Details','path'=>''
            )
        );

        $data['bid_details']=  $this->jobdetails_model->getbid_details($pid);
        
        if($user){ 
           $data['revised_user']=  $this->is_bidder($data['bid_details'],$user[0]->user_id);
		   if($data['revised_user'])  
		   {         
           	 $data['revised_data']=$this->jobdetails_model->getrevised_details($user[0]->user_id,$pid);
		   }           
           
        }       
        
        
        
        
        
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Job Details');

        $head['current_page']='jobdetails';
		
		 $head['ad_page']='findjob';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting("meta","pagename","Jobdetails");

        $lay['client_testimonial']="inc/footerclient_logo";
		
		$this->form_validation->set_rules('femail', "friend's email", 'required');
		$this->form_validation->set_rules('fname', "friend's name", 'required');
		$this->form_validation->set_rules('mymail', "your email", 'required');
		$this->form_validation->set_rules('myname', "your name", 'required');

		if ($this->form_validation->run() == FALSE) {              
			$this->layout->view('details',$lay,$data,'normal');
		}
		else
		{
			$femail=$this->input->post('femail');
			//$femail=explode(',',$femail);
			$fname=$this->input->post('fname');
			//$fname=explode(',',$fname);
			$myname=$this->input->post('myname');
			$myemail=$this->input->post('mymail');
                       // echo count($fname); die();
                        
                        
                        
			for($i=0;$i < count($femail);$i++)
			{
                                if($fname[$i]!="" && $femail[$i]!=""){ 
                                $post_data['friend_name']=$fname[$i];
				$post_data['friend_email']=$femail[$i];
				$post_data['user_name']=$myname;
				$post_data['user_email']=$myemail;
				$post_data['reg_status']='N';
				$post_data['invite_date']=date('Y-m-d h:i:s');
                $post_data['project_id']=$pid;
                               
				$insert=$this->jobdetails_model->insert_table('invite_friend',$post_data);
				if ($insert) {
					$refer_id=$insert;
					$url=SITE_URL.'jobdetails/details/'.$pid.'/'.base64_encode($refer_id);
					
					
					$from=ADMIN_EMAIL;
					$to=$femail[$i];
					$template='invite';
					$data_parse=array('name'=>$fname[$i],
								'username'=>$myname,
								'project_name' => $project_name,
								'copy_url'=>$url,
								'url_link'=>$url
								);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
                    $this->session->set_flashdata('succ_msg', 'Your friend is invited successfuly.');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }                                    
                                    
                                }
                            

			}
			redirect(VPATH.'jobdetails/details/'.$pid);	
		}
				
	}	 
 }
  public function bidtest(){
         
	$msg = "";
	$fileElementName = 'userfile';	
        $msg= $_FILES['userfile']['name'];

        $config['upload_path'] = 'assets/jobbid_upload/';
        $config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';
	$this->load->library('upload', $config);
        $result=array() ;
        if ($this->upload->do_upload()){
            $upload_data = $this->upload->data();
            $result["msg"]=$upload_data['file_name'];
        }
	echo json_encode($result);		
 } 
 public function rmvimage($img)
	{
		$file="assets/jobbid_upload/".$img;
		unlink($file);
		echo "1";	
	}   
	
	
    public function activity(){                 
            $user=$this->session->userdata('user');
           
            if($user){ 
            
              $data['apprivestatus']=$this->auto_model->getFeild('verify','user','user_id',$user[0]->user_id);
				
            
               $data['uid']=$user[0]->user_id;
               $data['logeduser_bid']=  $this->jobdetails_model->getPostBidCount($user[0]->user_id);
               $data['total_plan_bid']=  $this->auto_model->getFeild("bids","membership_plan","id",$user[0]->membership_plan);
	       	   $data['bidwin_charge']=  $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$user[0]->membership_plan);
			}else{
				redirect(base_url('login'));
			}
			$data['pid']=$pid=  $this->uri->segment(3);
            $this->load->library('form_validation'); 
			if(post()){
				$this->form_validation->set_rules('task', 'task', 'required');
				$this->form_validation->set_rules('freelancer[]', 'freelancer', 'required');
				if($this->form_validation->run()){
					 $post = post();
					 $freelancer = $post['freelancer'];
					 unset($post['freelancer']);
					 $post['project_id'] = $pid;
					 $ins['data'] = $post;
					 $ins['table'] = 'project_activity';
					 $act_id = insert($ins, TRUE);
					 if(!empty($freelancer) AND count($freelancer) > 0){
						 foreach($freelancer as $k => $v){
							 $act_user['data'] = array(
								'activity_id' => $act_id,
								'assigned_to' => $v
							 );
							 $act_user['table'] = 'project_activity_user'; 
							 insert($act_user);
						 }
					 }
				}
			  
			} 
        
		
		$data['activity_list'] = $this->jobdetails_model->getProjectActivity($pid);
		$userproject= $this->auto_model->getFeild("user_id","projects","project_id",$pid);
		
		$membershipplan = $this->auto_model->getFeild("membership_plan","user","user_id",$userproject);
		
	
		
        $data['project']=  $this->jobdetails_model->getprojectdetails($pid);
        
        
        $data['owner_id']=$user_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
       
        $data["user_totalproject"]=$this->jobdetails_model->gettotaluserproject($user_id);
        
        $data['user']=  $this->jobdetails_model->getuserdetails($user_id);
        
        
        
        $breadcrumb=array(
            array(
                    'title'=>'Job Details','path'=>''
            )
        );

        $data['bid_details']=  $this->jobdetails_model->getbid_details($pid);
        if($user){ 
           $data['revised_user']=  $this->is_bidder($data['bid_details'],$user[0]->user_id);
		   if($data['revised_user'])  
		   {         
           	 $data['revised_data']=$this->jobdetails_model->getrevised_details($user[0]->user_id,$pid);
		   }           
           
        }       
        
        
       
        
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Job Details');

        $title= $data['project'][0]['title'];

        $image="";

        $desc=html_entity_decode($data['project'][0]['description']);        
        
       
        $head['current_page']='jobdetails';
		
		$head['ad_page']='findjob';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting("meta","pagename","Jobdetails");

        $lay['client_testimonial']="inc/footerclient_logo";

        $this->layout->view('project_activity',$lay,$data,'normal');

        
    }

	
	public function viewmilesone($bidder_id=''){
		if($this->input->is_ajax_request()){
			if(empty($bidder_id)){
				echo 'Something went wrong.';
				return;
			}
			
			$milestone = get_results(array('select' => '*', 'from' => 'project_milestone' , 'where' => array('bid_id' => $bidder_id)));
			$data['milestone'] = 	$milestone;
			$data['page'] = 'milestone_view';
			/* if(count($milestone) > 0){
				$total = array();
				echo '<table class="table">';
				echo '<tr>
					<th>Title</th>
					<th>Date</th>
					<th>Amount ('.CURRENCY.')</th>
				</tr>';	
				foreach($milestone as $k => $v){
					$total[] = $v['amount'];
					$pay_date = $v['mpdate'] != '0000-00-00' ? $v['mpdate'] : 'At Project End';
					echo '<tr>
						<td>'.$v['title'].'</td>
						<td>'.$pay_date .'</td>
						<td>'.$v['amount'].'</td>
					<tr>';
				}
				echo '<tr>
						<td></td>
						<td><b>Total ('.CURRENCY.')</b></td>
						<td>'.array_sum($total).'</td>
					<tr>';
					
				echo '</table>';
			} */
			
			$this->load->view('milestone_ajax_check', $data);
			
		}
		
	}
	
	public function check_milestone($bid_id=''){
		$user = $this->session->userdata('user');
		if($this->input->is_ajax_request() && $user){
			$data = array();
			if(empty($bid_id)){
				echo 'Something went wrong.';
				return;
			}
			$data['bidder_id'] = getField('bidder_id', 'bids', 'id', $bid_id);
			$data['bid_id'] = $bid_id;
			$user_wallet_id = get_user_wallet($user[0]->user_id);
			$user_wallet_balance = get_wallet_balance($user_wallet_id);
			$data['user_id'] = $user[0]->user_id;
			$data['wallet_balance'] = $user_wallet_balance;
			
			$data['milestone'] = get_results(array('select' => '*', 'from' => 'project_milestone' , 'where' => array('bid_id' => $bid_id)));
			$data['bid_detail'] = get_row(array('select' => '*', 'from' => 'bids' , 'where' => array('id' => $bid_id)));
			$data['page'] = 'milestone_check';
			
			$this->load->view('milestone_ajax_check', $data);
		}
		
	}
	
	
    public function request_new_milestone(){		
		$user = $this->session->userdata('user');		
		$user_id = $user[0]->user_id;
		if($this->input->is_ajax_request()){
			$post = filter_data($this->input->post());
			if(!empty($post['requested_bid_id']) AND !empty($post['client_comment'])){
				$update['data'] = array('note' => $post['client_comment'], 'bid_amount_request' => $post['bid_amount_request']);
				$update['where'] = array('id' => $post['requested_bid_id']);
				$update['table'] = 'bids';
				$upd = update($update);
				if($upd){
					echo '<div class="alert alert-success"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Revise bid successfully request</div>';
				}else{
					echo '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Unable to send request</div>';
				}				
				$project_id = getField('project_id', 'bids', 'id', $post['requested_bid_id']);				
				$notification_to = getField('bidder_id', 'bids', 'id', $post['requested_bid_id']);				
				
				$link = 'jobdetails/details/'.$project_id;				
				$link2 = 'jobdetails/details/'.$project_id.'?show_bid_panel=1';				
				$notification_content = 'Revise Bid Request - '.htmlentities($post['client_comment']);	
				$notification_content_2 = 'Revise Bid Request Send';
				$this->notification_model->log($user_id,  $notification_to, $notification_content, $link2);
				$this->notification_model->log($user_id,  $user_id, $notification_content_2, $link);
				
				$f_email = getField('email', 'user', 'user_id', $notification_to);
				$f_name = getField('fname', 'user', 'user_id', $notification_to);
				$e_name = getField('fname', 'user', 'user_id', $user_id);
				$project_title = getField('title', 'projects', 'project_id', $project_id);
				$job_detail_url =  base_url('job-'.seo_string($project_title).'-'.$project_id);
				$mail_param = array(
					'USER' => $f_name,
					'PROJECT_TITLE' => $project_title,
					'EMPLOYER' => $e_name,
					'AMOUNT' => format_money($post['bid_amount_request'], TRUE),
					'COMMENT' => $post['client_comment'],
					'JOB_DETAIL_URL' => $job_detail_url,
				);
					
				send_layout_mail('revise_bid_request', $mail_param, $f_email);
			
				
			}else{
				echo '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Something went wrong</div>';
			}					
		}
	}
	
	
	public function invite_user(){
		if(post()){
			$json = array();
			$post = post();
			$user=$this->session->userdata('user');
			$user_id =$user[0]->user_id;
			if(!empty($post['freelancer']) && !empty($post['project_id'])){
				
				$p_type = $this->auto_model->getFeild('project_type','projects','project_id',$post['project_id']);
				$p_title = $this->auto_model->getFeild('title','projects','project_id',$post['project_id']);
				
				$username = getField('fname','user','user_id',$user_id);
				$username .= ' ';
				$username .= getField('lname','user','user_id',$user_id);
				
				foreach($post['freelancer'] as $k => $v){
					$count = $this->db->where(array('project_id' => $post['project_id'], 'freelancer_id' => $v))->count_all_results('new_inviteproject');
					if($count > 0){
						continue;
					}
					$inv = array(
						'employer_id' => $user_id,
						'freelancer_id' => $v,
						'project_id' => $post['project_id'],
						'project_type' => $p_type,
						'invitation_amount' => 0,
						'date' => date('Y-m-d'),
						'message' => 'You are invited for the project '.$p_title,
					
					);
					$this->db->insert('new_inviteproject', $inv);
					$notification_content = 'You are invited for the project '.$p_title;
					$link = 'job-'.seo_string($p_title).'-'.$post['project_id'];
					$this->notification_model->log($user_id,  $v, $notification_content, $link);
					
					/* send mail here */
					$freelancer_fname = $this->auto_model->getFeild('fname' , 'user' , 'user_id' , $v);
					$f_email = getField('email','user','user_id',$v);
					
					$mail_param = array(
						'name' => $freelancer_fname,
						'username' => $username,
						'project_name' => $p_title,
						/* 'project_url' => base_url('job-'.seo_string($p_title).'-'.$post['project_id']),
						'copy_url' => base_url('job-'.seo_string($p_title).'-'.$post['project_id']), */
						'project_url' => base_url('jobdetails/details/'.$post['project_id']),
						'copy_url' => base_url('jobdetails/details/'.$post['project_id']),
						'message' => '',
					);
					
					send_layout_mail('invite_freelancer', $mail_param, $f_email);
				
				}
			}
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	/* public function test_mail(){
		$template = 'registration';
		$data_parse = array('username' => 'vkbsihu');
		$to = 'bishukumar007@gmail.com';
		send_layout_mail($template, $data_parse, $to);
	} */		
	
	public function question_anwser(){		
		$project_id = get('project_id');		
		$data['project_id'] = $project_id;		
		$data['project_comments'] = $this->jobdetails_model->getComments($project_id);		
		$this->load->view('question-component', $data);	
	}	
	
	public function post_comment_ajax(){		
		$json = array();		
		$user = $this->session->userdata('user');		
		$user_id = $user[0]->user_id;			
		
		if(post() && $this->input->is_ajax_request() && $user_id){	
			
			$attachment = '';
			if(!empty($_FILES['attachment']['name'])){
				$config['upload_path']          = './assets/uploaded/';
				$config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|jpeg';
				$config['encrypt_name']        = TRUE;

				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('attachment')) {
					$json['error'] = $this->upload->display_errors();

				} else {
					$attachment = $this->upload->data('file_name');

				}
			}
			
		
			$sender_name = getField('fname','user', 'user_id', $user_id);
			$post = post();			
			$type = get('type');			
			$comment = post('comment');			
			$parent_id = post('parent_id');						
			$comment_arr = array(				
				'user_id' => $user_id,				
				'comment' => $comment,				
				'datetime' => date('Y-m-d H:i:s'),				
				'attachment' => $attachment,				
				'parent_id' => !empty($parent_id) ? $parent_id : 0,			
			);						
			$this->db->insert('comments', $comment_arr);						
			$comment_id = $this->db->insert_id();	
			
			if($type == 'project_comment'){								
				$project_id = post('project_id');							
				$contest_comment_arr = array(				
					'project_id' => $project_id,					
					'comment_id' => $comment_id,				
				);								
				$this->db->insert('project_comment', $contest_comment_arr);								
				$link  = 'jobdetails/details/'.$project_id;				
				$project_title = getField('title', 'projects', 'project_id', $project_id);								
				if($parent_id > 0){					
					$notification_to = getField('user_id', 'comments', 'comment_id', $parent_id);					
					$notification = 'Reply for - '.$project_title;		

					if($notification_to != $user_id){
						$name = getField('fname', 'user', 'user_id', $notification_to);
						$data_parse=array(
							'NAME' => $name,
							'SENDER_NAME' => $sender_name ,
							'PROJECT_TITLE' => $project_title,
							'COMMENT' => $comment,
							'JOB_DETAIL_URL' => base_url('job-'.seo_string($project_title).'-'.$project_id),
							
						);
						$template = 'job-question-reply';
						$to = getField('email', 'user', 'user_id', $notification_to);
						send_layout_mail($template, $data_parse, $to);
					}
					
				}else{					
					$notification_to = getField('user_id', 'projects', 'project_id', $project_id);					
					$notification = 'New Question - '.$project_title;		
					
					if($notification_to != $user_id){
						$name = getField('fname', 'user', 'user_id', $notification_to);
						$data_parse=array(
							'NAME' => $name,
							'SENDER_NAME' => $sender_name ,
							'PROJECT_TITLE' => $project_title,
							'COMMENT' => $comment,
							'JOB_DETAIL_URL' => base_url('job-'.seo_string($project_title).'-'.$project_id),
							
						);
						$template = 'job-ask-question';
						$to = getField('email', 'user', 'user_id', $notification_to);
						send_layout_mail($template, $data_parse, $to);
					}
					
				
				}												
				$this->notification_model->log($user_id,  $notification_to, $notification, $link);	

				
			}									
			$json['data'] = $post;			
			$json['data']['comment_id'] = $comment_id;						
			$fname = getField('fname', 'user', 'user_id', $user_id);			
			$lname = getField('lname', 'user', 'user_id', $user_id);			
			$profile_pic = getField('logo', 'user', 'user_id', $user_id);						
			if(!empty($profile_pic)){				
				$logo = base_url('assets/uploaded/'.$profile_pic);				
				if(file_exists('./assets/uploaded/cropped_'.$profile_pic)){					
					$logo = base_url('assets/uploaded/cropped_'.$profile_pic);				
				}			
			}else{				
				$logo = base_url("assets/images/user.png");			
			}	
			
			$attachment_html = '';
			
			if($attachment){
				$attachment_html = '<a href="'.base_url('assets/uploaded/'.$attachment).'" target="_blank">Attachment</a>';
			}
			
			
			$json['data']['user_id'] = $user_id;			
			$json['data']['name'] = $fname.' '.$lname;			
			$json['data']['avatar'] = $logo;			
			$json['data']['date'] = date('d M, H:i A');			
			$json['data']['attachment'] = $attachment_html;			
			$json['status'] = 1;			
			echo json_encode($json);		
		}	
	}	

}
