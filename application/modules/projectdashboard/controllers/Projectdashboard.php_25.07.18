<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectdashboard extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('projectdashboard_model');
        parent::__construct();
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('notification/notification_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('projectdashboard',$idiom);
		
    }

    public function index($project_id='') {
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		if($data['account_type'] == 'F'){
			redirect(base_url('projectdashboard/index_freelancer/'.$project_id));
		}
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['page'] = 'index';
		
		$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
		$data['project_info']['type'] = $data['project_details']['project_type'];
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
		$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
		/*working area*/
		
		$data['activity_list'] = $this->projectdashboard_model->getProjectActivity($project_id);
		
		
		$this->autoload_model->getsitemetasetting("meta","pagename","Projectdashboard");
		
		$this->layout->view('index','',$data,'normal');   
    }
	
	public function index_freelancer($project_id='') {
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['page'] = 'index';
		$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
		$data['project_info']['type'] = $data['project_details']['project_type'];
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
		$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		/*working area*/
		
		
		$this->autoload_model->getsitemetasetting("meta","pagename","Projectdashboard");
		
		$this->layout->view('index_freelancer','',$data,'normal');   
    }
	
	public function milestone_employer($project_id='') {
		if($project_id==''){	
			
			show_404();
		}
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['page'] = 'milestone';
			
		$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
		$data['project_info']['type'] = $data['project_details']['project_type'];
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
		$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
		
			
		/*working area*/
		
		$data['set_milestone_list']=$this->projectdashboard_model->getsetMilestone($project_id);
		$data['outgoint_milestone_list']=$this->projectdashboard_model->getOutgoingMilestone($data['user_id']);
		
		$data['incoming_milestone_list']=$this->projectdashboard_model->getIncomingMilestone($data['user_id']);
		
		$this->autoload_model->getsitemetasetting("meta","pagename","milestone");
		
		$this->layout->view('milestone_employer','',$data,'normal');   
    }
	
	
	public function milestone_freelancer($project_id='') {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		}  
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		}  
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['project_info']['type'] = 'F';
		$data['page'] = 'milestone';
		
		/*working area*/
		if($project_id!='')
		{	
			$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
			$data['project_info']['type'] = $data['project_details']['project_type'];
			$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
			$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
        	$data['set_milestone_list']=$this->projectdashboard_model->getsetMilestone($project_id);
		
		}

		$data['outgoint_milestone_list']=$this->projectdashboard_model->getOutgoingMilestone($data['user_id']);
		
		$data['incoming_milestone_list']=$this->projectdashboard_model->getIncomingMilestone($data['user_id']);
		$this->autoload_model->getsitemetasetting("meta","pagename","milestone");
		
		$this->layout->view('milestone_freelancer','',$data,'normal');   
    }
	
	public function hourly_employer($project_id='') {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		}  
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['page'] = 'hourly';
		
		/*working area*/
		
			$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
			$data['project_info']['type'] = $data['project_details']['project_type'];
			$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
			$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
			$data['manual_tracker_details']=$this->projectdashboard_model->getprojecttracker_manual($project_id);
			foreach($data['manual_tracker_details'] as $key =>$val){
				
				$data['manual_tracker_details'][$key]['acti']=$this->getActivity($val['activity']);
				
			}
			//print_r($data['manual_tracker_details']);
		$this->autoload_model->getsitemetasetting("meta","pagename","projecthourly");
		
		$this->layout->view('hourly_employer','',$data,'normal');   
    }
	
	
	public function hourly_freelancer($project_id='') {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		}  
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['project_id'] = $project_id;
		$data['page'] = 'hourly';
		
		$data['project_details'] = $this->projectdashboard_model->getprojectdetails($project_id);
		$data['project_info']['type'] = $data['project_details']['project_type'];
		$data['project_user'] = $this->projectdashboard_model->getProjectUserSingle($data['project_details']['user_id']);
		$data['cityCounrty'] = $this->projectdashboard_model->getCountryCityDetails_user($data['project_user']['country'],$data['project_user']['city']);
			
		/*working area*/
		$data['manual_tracker_details']=$this->projectdashboard_model->getprojecttracker_manual($project_id);
		foreach($data['manual_tracker_details'] as $key =>$val){
			$data['manual_tracker_details'][$key]['acti']=$this->getActivity($val['activity']);
		}
		
		$this->autoload_model->getsitemetasetting("meta","pagename","projecthourly");
		
		$this->layout->view('hourly_freelancer','',$data,'normal');   
    }
	
	
	public function project_activity(){
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		} 
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id; 
		$pid= $this->uri->segment(3);
		$project_title = getField('title', 'projects', 'project_id', $pid);
		//get_print($project_title);
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
						
						$notification = "An activity has been assigned to you on project ".$project_title;
						$link = 'projectroom/freelancer/overview/'.$pid;
						$this->notification_model->log($user_id, $v, $notification, $link);
					
					}
				}
			}
		  
		}
		$ret = get('return');
		if($ret){
			redirect(base_url($ret));
		}
		redirect(base_url('projectdashboard/index/'.$pid));
	}
	
	
	public function approve_activity($act_id=''){
		$user=$this->session->userdata('user');
		$uid = $user[0]->user_id;
		$project  = $this->input->get('project');
		$this->db->where(array('activity_id' => $act_id ,'assigned_to' => $uid))->update('project_activity_user' , array('approved' => 'Y'));
		
		$project_id = getField('project_id', 'project_activity', 'id', $act_id);
		$freelancer = getField('fname', 'user', 'user_id', $uid);
		$project_title = getField('title', 'projects', 'project_id', $project_id);
		$employer_id = getField('user_id', 'projects', 'project_id', $project_id);
		
		$notification = "An activity has been approved by ".$freelancer . " for the project ".$project_title;
		$link = 'projectroom/employer/overview/'.$project_id;
		$this->notification_model->log($uid, $employer_id, $notification, $link);
		
		$next = get('next');
		if(!empty($next)){
			redirect(base_url($next));
		}
		redirect(base_url('projectdashboard/index_freelancer/'.$project));
	}
	
	public function deny_activity($act_id=''){
		$user=$this->session->userdata('user');
		$uid = $user[0]->user_id;
		$project  = $this->input->get('project');
		$this->db->where(array('activity_id' => $act_id ,'assigned_to' => $uid))->delete('project_activity_user');
		
		$project_id = getField('project_id', 'project_activity', 'id', $act_id);
		$freelancer = getField('fname', 'user', 'user_id', $uid);
		$project_title = getField('title', 'projects', 'project_id', $project_id);
		$employer_id = getField('user_id', 'projects', 'project_id', $project_id);
		
		$notification = "An activity has been denied by ".$freelancer . " for the project ".$project_title;
		$link = 'projectroom/employer/overview/'.$project_id;
		$this->notification_model->log($uid, $employer_id, $notification, $link);
		
		$next = get('next');
		if(!empty($next)){
			redirect(base_url($next));
		}
		
		redirect(base_url('projectdashboard/index_freelancer/'.$project));
	}
	
	public function getActivity($act=''){
		
		$res=array();
		if(!empty($act)){
			$res = $this->db->where("id IN($act)")->get('project_activity')->result_array();
		
		}
		return $res;
	
	}
	
	public function dispute_room($milestone_id='', $project_id=''){
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");	
		}  
		$user=$this->session->userdata('user');
		$data = array();
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['login_user_id']=$user[0]->user_id;
		$data['milestone_id'] = $milestone_id;
		$data['project_id'] = $project_id;
		
		$p_type = getField('project_type', 'projects', 'project_id', $project_id);
		
		if($p_type == 'H'){
			
			$data['milestone_detail'] = $this->db->where('id', $milestone_id)->get('milestone_payment')->row_array();
		
			$data['bid_detail'] = $this->db->where('id', $data['milestone_detail']['bid_id'])->get('bids')->row_array();
		
			$data['owner_id'] = getField('user_id', 'projects', 'project_id', $data['milestone_detail']['project_id']);
			$data['freelancer_id'] = $data['milestone_detail']['worker_id'];
			
		}else{
			
			$data['milestone_detail'] = $this->db->where('id', $milestone_id)->get('project_milestone')->row_array();
		
			$data['bid_detail'] = $this->db->where('id', $data['milestone_detail']['bid_id'])->get('bids')->row_array();
		
			$data['owner_id'] = getField('user_id', 'projects', 'project_id', $data['milestone_detail']['project_id']);
			$data['freelancer_id'] = $data['bid_detail']['bidder_id'];
			
		}
		
		$data['project_type'] = $p_type;
	
		
		$data['owner_detail'] = $this->db->where('user_id', $data['owner_id'])->get('user')->row_array();
		$data['freelancer_detail'] = $this->db->where('user_id', $data['freelancer_id'])->get('user')->row_array();
		
		$q['project_id'] = $project_id;
		$q['milestone_id'] = $milestone_id;
		
		$data['messages'] = $this->projectdashboard_model->getDisputeMessages($q);
		$data['messages_count'] = $this->projectdashboard_model->getDisputeMessages($q, '', '', FALSE);
		
		$data['dispute_history'] = $this->projectdashboard_model->getDisputeHistory($q);
		$data['dispute_history_count'] = $this->projectdashboard_model->getDisputeHistory($q, '', '', FALSE);
		
		//get_print($data, false);
		
		$this->layout->view('dispute_room','',$data,'normal');   
	}
	
	public function send_dispute_message(){
		$json = array();
		if($this->input->post()){
			$post = post();
			
			$post['message'] = htmlentities($post['message']);
			
			$post['date'] = date('Y-m-d H:i:s');
			$post['status'] = 'U'; 
			
			$this->db->insert('dispute_messages', $post);
			$insert_id = $this->db->insert_id();
			
			$sender_info = $this->db->where('user_id', $post['sender_id'])->get('user')->row_array();
			$profile_pic = '';
			
			if(!empty($sender_info['logo'])){
				
				$profile_pic = base_url('assets/uploaded/'.$sender_info['logo']);
				
				if(file_exists('assets/uploaded/cropped_'.$sender_info['logo'])){
					$profile_pic = base_url('assets/uploaded/cropped_'.$sender_info['logo']);
				}
			}else{
				$profile_pic = base_url('assets/images/user.png');
			}
			
			$json['data'] = array(
				'message' => $post['message'],
				'message_id' => $insert_id,
				'date' => date('d M, Y h:i A'),
				'attachment' => '',
				'sender' => array(
					'sender_id' => $post['sender_id'],
					'name' => $sender_info['fname'],
					'image' => $profile_pic,
				),
			);
			
			$json['lst_msg_id'] = $insert_id;
			$json['status'] = 1;
			
			if($insert_id){
				$notification = "A new dispute message by ".$sender_info['fname'];
				$link = 'projectdashboard/dispute_room/'.$post['milestone_id'].'/'.$post['project_id'];
				$this->notification_model->log($post['sender_id'], $post['receiver_id'], $notification, $link);
			}
			
			echo json_encode($json);
			
		}
	}
	
	public function send_attachment(){
		$json = array();
		
		if(post()){
			$post = post();
			if(!empty($_FILES['attachment']['name'])){
				
				if(!is_dir('assets/attachments')){
					mkdir('assets/attachments');
				}
				
				$config['upload_path']          = 'assets/attachments/';
				$config['allowed_types']          = 'jpg|jpeg|png|gif|pdf|docx|xls|txt|doc';
				$config['file_ext_tolower']          = TRUE;
				$config['encrypt_name']          = TRUE;
				
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('attachment')) {
					$json['attachmentError'] = $this->upload->display_errors();
					$json['status'] = 0;
					echo json_encode($json); die;
				} else {
					$file_data = $this->upload->data();
					$is_image = false;
					if(stripos($file_data['file_type'], 'image') !== false){
						$is_image = true;
					}
					
					$attachment = array(
						'file_name' => $file_data['file_name'],
						'org_file_name' => $file_data['orig_name'],
						'file_size' => $file_data['file_size'],
						'file_type' => $file_data['file_type'],
						'is_image' => $is_image ? 1 : 0,
						'image_width' => !empty($file_data['image_width']) ? $file_data['image_width'] : '',
						'image_height' => !empty($file_data['image_height']) ? $file_data['image_height'] : '',
					
					);
					$post['attachment'] = json_encode($attachment); 
				}
			}
			
			$post['date'] = date('Y-m-d H:i:s');
			$post['status'] = 'U'; 
			
			
			$ins['data'] = $post;
			$ins['table'] = 'dispute_messages';
			$message_id = insert($ins, TRUE);
			$last_message = get_row(array('select' => '*', 'from' => 'dispute_messages', 'where' => array('message_id' => $message_id)));
			
			$json['status'] = 1;
			
			$sender_info = $this->db->where('user_id', $post['sender_id'])->get('user')->row_array();
			$profile_pic = '';
			
			if(!empty($sender_info['logo'])){
				
				$profile_pic = base_url('assets/uploaded/'.$sender_info['logo']);
				
				if(file_exists('assets/uploaded/cropped_'.$sender_info['logo'])){
					$profile_pic = base_url('assets/uploaded/cropped_'.$sender_info['logo']);
				}
			}else{
				$profile_pic = base_url('assets/images/user.png');
			}
			
			
			$json['data'] = array(
				'message' => $post['message'],
				'message_id' => $message_id,
				'date' => date('d M, Y h:i A'),
				'attachment' => json_encode($attachment),
				'sender' => array(
					'sender_id' => $post['sender_id'],
					'name' => $sender_info['fname'],
					'image' => $profile_pic,
				),
			);
			
			$json['lst_msg_id'] = $message_id;
			
			if($message_id){
				$notification = "A new dispute message by ".$sender_info['fname'];
				$link = 'projectdashboard/dispute_room/'.$post['milestone_id'].'/'.$post['project_id'];
				$this->notification_model->log($post['sender_id'], $post['receiver_id'], $notification, $link);
			}
			
			echo json_encode($json);
		}	
	}
	
	public function send_dispute_amount(){
		$json = array();
		
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		
		if($this->input->post() && $user_id){
			$post = post();
			
			$post['requested_by'] = $user_id;
			
			$post['requested_date'] = date('Y-m-d');
			$post['status'] = 'P'; 
			
			$this->db->where(array('project_id' => $post['project_id'], 'milestone_id' => $post['milestone_id']))->update('dispute_history', array('status' => 'D'));
			
			$this->db->insert('dispute_history', $post);
			$insert_id = $this->db->insert_id();
			
			$json['data'] = array(
				'employer_amount' => $post['employer_amount'],
				'worker_amount' =>  $post['worker_amount'],
				'id' =>  $insert_id,
				'date' => date('Y-m-d'),
				'status' => 'P',
				
				
			);
			
			$json['last_id'] = $insert_id;
			$json['status'] = 1;
			
			if($user_id == $post['worker_id']){
				$send_to = $post['employer_id'];
			}else{
				$send_to = $post['worker_id'];
			}
			
			$name = getField('fname', 'user', 'user_id', $user_id);
			
			$notification = "$name send you a dispute settlement request";
			$link = 'projectdashboard/dispute_room/'.$post['milestone_id'].'/'.$post['project_id'];
			$this->notification_model->log($user_id, $send_to, $notification, $link);
			
			echo json_encode($json);
			
		}
	}
	
	public function accept_dispute_request(){
		
		$this->load->model('myfinance/myfinance_model');
		$this->load->model('myfinance/transaction_model');
		$this->load->helper('invoice');
		$json = array();
		
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$h_id = post('id');
		if($h_id && $user_id){
			$dispute_requester = getField('requested_by', 'dispute_history', 'id', $h_id);
			
			if($dispute_requester != $user_id){
				
				$dispute_history_row = $this->db->where(array('id' => $h_id, 'status' => 'P'))->get('dispute_history')->row_array();
				
				$milestone_id = $dispute_history_row['milestone_id'];
				$project_id = $dispute_history_row['project_id'];
				$p_type = getField('project_type', 'projects', 'project_id', $project_id);
				$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);
				$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
				
				$escrow_check = $this->db->where(array('milestone_id' => $milestone_id, 'status' => 'D'))->get('escrow_new')->row_array();
				
				if(!empty($escrow_check) && !empty($dispute_history_row)){
					
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
					
					$this->db->where('id', $h_id)->update('dispute_history', array('status' => 'A'));
					
					$pid = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
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
						$post_data['project_id'] = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
						$post_data['milestone_id'] = $milestone_id;
						
						$post_data['worker_id'] = $dispute_history_row['worker_id'];
						
						$post_data['payamount'] = $dispute_history_row['worker_amount'];
						
						$post_data['commission'] = $commission;
					  
						$post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 
						
						$post_data['release_type'] = 'P';
						$post_data['add_date'] = date('Y-m-d H:i:s');
						$post_data['status'] = 'Y';
						$post_data['commission_invoice_id'] = $inv_id;
						$insert = $this->myfinance_model->insertMilestone($post_data);
						
						
						
						$val['fund_release']='A';
						$val['release_payment']='Y';
						$val['commission_invoice_id'] = $inv_id;
						$where=array("id"=>$milestone_id);
						$upd=$this->myfinance_model->updateProjectMilestone($val,$where);
						
						$return_row=$this->myfinance_model->checkproject_milestone($pid);
						if($return_row==0){
							$proj_data['status']='C';
							$this->myfinance_model->updateProject($proj_data,$pid);
						}
		
						/* $this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id))->update('invoice', array('payment_status' => 'PAID', 'amount_disputed' => $dispute_history_row['employer_amount'])); */
						
						$notification = "Your dispute settlement request has been approved ";
						$notification2 = "Disputed milestone has been settled";
						
						$link = 'projectdashboard/dispute_room/'.$milestone_id.'/'.$project_id;
						$this->notification_model->log($user_id, $dispute_requester, $notification, $link);
						$this->notification_model->log($user_id, $user_id, $notification2, $link);
						$this->notification_model->log($user_id, $dispute_requester, $notification2, $link);
					
						
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
					$json['msg'] = 'Record successfully approved';
				
				}else{
					$json['status'] = 0;
					$json['msg'] = 'Invalid selection';
				}
				
				
				
			}else{
				$json['status'] = 0;
				$json['msg'] = 'Invalid selection';
			}
			
			echo json_encode($json);
		}
		
	}
	
	public function deny_dispute_request(){
		$json = array();
		
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$h_id = post('id');
		
		if($h_id && $user_id){
			
			$upd = $this->db->where('id', $h_id)->update('dispute_history', array('status' => 'D'));
			
			$json['status'] = 1;
			$milestone_id = getField('milestone_id', 'dispute_history', 'id', $h_id);
			$project_id = getField('project_id', 'dispute_history', 'id', $h_id);
			$requested_by = getField('requested_by', 'dispute_history', 'id', $h_id);
			
			if($milestone_id && $project_id && $requested_by){
				$notification = "Your dispute settlement request has been rejected ";
				$link = 'projectdashboard/dispute_room/'.$milestone_id.'/'.$project_id;
				$this->notification_model->log($user_id, $requested_by, $notification, $link);
			}
			
		}else{
			
			$json['status'] = 0;
			$json['msg'] = 'Invalid selection';
			
		}
		
		echo json_encode($json);
		
	}
	
	public function send_to_admin(){
		$json = array();
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		
		$project_id = post('project_id');
		$milestone_id = post('milestone_id');
		
		if($project_id && $milestone_id){
			$this->db->where(array('project_id' => $project_id, 'id' => $milestone_id))->update('project_milestone', array('send_to_admin' => 'Y'));
		}
		$json['status'] = 1;
		
		$bid_id =  getField('bid_id', 'project_milestone', 'id', $milestone_id);
		
		$employer_id = getField('user_id', 'projects', 'project_id', $project_id);
		$freelancer_id = getField('bidder_id', 'bids', 'id', $bid_id); 
		
		$notification = "Dispute has been send to admin";
		$link = 'projectdashboard/dispute_room/'.$milestone_id.'/'.$project_id;
		$this->notification_model->log($user_id, $employer_id, $notification, $link);
		$this->notification_model->log($user_id, $freelancer_id, $notification, $link);
	
		echo json_encode($json);
	}
	

}
