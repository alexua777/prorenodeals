<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class projectdashboard_model extends BaseModel {

    public function __construct() {
		$this->load->model('notification/notification_model');
        return parent::__construct();
    }
    
    public function getMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('recipient_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getoutgoingMessage($user_id,$project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('sender_id',$user_id);
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getfiles($project_id,$limit = '', $start = ''){ 
        $this->db->select();
		$this->db->where('attachment <>',"");
		$this->db->where('project_id',$project_id);
        $this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
        $res=$this->db->get("message");
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
				"sender_id" => $val->sender_id,
                "message" => $val->message,
                "add_date" => $val->add_date,
				'attachment'=>$val->attachment
            );
        }
        return $data;
    }
	public function getAllMessage($project_id,$sender_id,$recipient_id,$limit = '', $start = '')
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->limit($limit, $start);
		$rs=$this->db->get('message');
		$data=array();
        
        foreach($rs->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "project_id" => $val->project_id,
				"sender_id" => $val->sender_id,
				"recipient_id" => $val->recipient_id,
                "message" => $val->message,
				"attachment" => $val->attachment,
                "add_date" => $val->add_date
            );
        }
        return $data;
	}
	public function countAllMessage($project_id,$sender_id,$recipient_id)
	{
		$recipients=array($sender_id,$recipient_id);
		$sender=array($sender_id,$recipient_id);
		$this->db->select();
		$this->db->where('project_id',$project_id);
		$this->db->where_in('sender_id',$sender);
		$this->db->where_in('recipient_id',$recipients);
		$this->db->order_by('add_date','desc');
		$this->db->from('message');
		return $this->db->count_all_results();
		
	}
	public function insertMessage($data)
	{
		return $this->db->insert('message',$data);	
	}
	public function delete_message($mid)
	{
		$this->db->where('id',$mid);
		return $this->db->delete('message');	
	}
	
	
	// ---------------------------Not Use Any More -------------------------------------//
	
	public function getOutgoingMilestone($uid,$pid){
        $this->db->select("*");
		 $data= array();
        $data=$this->db->get_where("milestone_payment",array("employer_id"=>$uid,'project_id'=>$pid))->result_array();
       
        return $data;
        
    }
	
	public function getIncomingMilestone($uid,$pid){
		 $data=array();
		 $this->db->select("*");
		
         $data=$this->db->get_where("milestone_payment",array("worker_id"=>$uid,"project_id"=>$pid))->result_array();
       
	   
      
        return $data;
        
    }
	
	// ---------------------------------------- End Of Not Use Any More ---------------------//
	
	 public function getprojectdetails($id){ 
	  $data=array();
        $this->db->select('*');
         $data=$this->db->get_where("projects",array("project_id"=> $id))->row_array();
       
        
        return $data;
        
        
    }
	
	public function listing_search_pagination($pid,$pagination_string = '', $offset = 6) {
        if ($pagination_string != "") {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?" . $pagination_string;
        } else {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?page_id=0";
        }

        $config['total_rows'] = $this->search_count();
        $config['per_page'] = $offset;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'limit';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
	
	private function search_count() {
        $nor = $this->db->query($this->last_query)->num_rows();
        return $nor;
    }
	
	public function getprojecttracker_manual($pid){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));		
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker_manual");
		$this->db->order_by('start_time','DESC');
		$this_query = $this->db->_compile_select();
        $this->last_query = $this_query;
        $res=$this->db->get();
		//echo $this->db->last_query();die;
        $data=array();
        foreach ($res->result() as $row){ 
            $data[]=array(
				"id"=>$row->id,
				"project_id"=>$row->project_id,
                "worker_id"=>$row->worker_id,
                "start_time"=>$row->start_time,
                "stop_time"=>$row->stop_time,
				"hour"=>$row->hour,
				"minute"=>$row->minute,
				"status"=>$row->status,
                "escrow_status"=>$row->escrow_status,
				"payment_status"=>$row->payment_status,
				"activity"=>$row->activity,
				"comment"=>$row->comment,
				"invoice_id"=>$row->invoice_id,
				
            );
        }
		//get_print($data);
        return $data;
	}
	
	
	public function getProjectUsers($project_id='', $utpye='E'){
		$user = $this->session->userdata('user');
		
		$result = array();
		
		if($utpye == 'F'){
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $p_row['user_id'])));
			if($p_row){
				$result[0]['user_id'] = $p_row['user_id'];
				$result[0]['name'] = $user_row['fname'].' '.$user_row['lname'];
				$result[0]['type'] = 'Employer';
				$result[0]['unread_msg'] =$this->db->where(array('recipient_id' => $user[0]->user_id, 'sender_id' => $p_row['user_id'],  'read_status' => 'N'))->count_all_results('message');
			}
		}else{
			
			$p_row = get_row(array('select' => '*', 'from' => 'projects', 'where' => array('project_id' => $project_id)));
			$p_users = $p_row['bidder_id'];
			//get_print($p_users , FALSE);
			if(!empty($p_users)){
				$all_users = explode(',',$p_users);
				if(count($all_users) > 0){
					foreach($all_users as $k => $v){
						if($v != 0){
							
							$user_row = get_row(array('select' => 'fname,lname', 'from' => 'user', 'where' => array('user_id' => $v['user_id'])));
							
							$result[] = array(
								'user_id' => $v,
								'name' => $user_row['fname'].' '.$user_row['lname'],
								'type' => 'Freelancer',
								'unread_msg' => $this->db->where(array('sender_id' => $v, 'recipient_id' => $user[0]->user_id, 'read_status' => 'N'))->count_all_results('message')
							);
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	public function getsetMilestone($pid){
		$data=array();
		
		$user=$this->session->userdata('user');
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		
        $this->db->select('pm.*')->from('project_milestone pm');
		$this->db->join('bids b','b.id=pm.bid_id','LEFT');
		$this->db->where('pm.project_id',$pid);
		$this->db->where('pm.status','A');
		if($data['account_type'] == 'F'){
		$this->db->where('b.bidder_id',$data['user_id']);
		}
        $data=$this->db->get()->result_array();
       
        
        return $data;
    }
	
	public function getProjectUserSingle($user_id=''){
		
		$user_row = get_row(array('select' => '*', 'from' => 'user', 'where' => array('user_id' => $user_id)));
		
		return $user_row;
	}	
	
	public function getCountryCityDetails_user($counrty='',$city_code=''){
		
		$this->db->select('Name,Code2');
		$this->db->from('country');
		$this->db->where('Code',$counrty);
		$result = $this->db->get()->row_array();
		$result['city_name'] = getField('Name','city','ID',$city_code);
		//get_print($result);
		return $result;
	}	
	

	/* New function */
	
	public function getProjectActivity($pid=''){
		 $this->db->select('*')
				->from('project_activity')
				->where('project_id', $pid);
		$res = $this->db->get()->result_array();
		if(count($res) > 0){
			foreach($res as $k => $v){
				$res[$k]['assigned_user'] = $this->_getActivityAssignedUser($v['id']);
			}
		}
		return $res;
	}
	
	public function _getActivityAssignedUser($act_id=''){
		$this->db->select('u.user_id,u.fname,u.lname,au.approved')
					->from('project_activity_user au')
					->join('user u', 'u.user_id=au.assigned_to', 'LEFT');
		$this->db->where('au.activity_id', $act_id);
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	public function getDisputeMessages($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		/* $this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']); */
		$this->db->where('dispute_id', $srch['dispute_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('message_id', 'ASC')->get('dispute_messages')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$sender_info = $this->db->where('user_id', $v['sender_id'])->get('user')->row_array();
					
					$profile_pic = '';
			
					if(!empty($sender_info['logo'])){
						
						$profile_pic = base_url('assets/uploaded/'.$sender_info['logo']);
						
						if(file_exists('assets/uploaded/cropped_'.$sender_info['logo'])){
							$profile_pic = base_url('assets/uploaded/cropped_'.$sender_info['logo']);
						}
					}else{
						$profile_pic = base_url('assets/images/user.png');
					}
			
					
					$result[$k]['message'] = $v['message'];
					$result[$k]['date'] = date('d M, Y h:i A', strtotime($v['date']));
					$result[$k]['message_id'] = $v['message_id'];
					$result[$k]['attachment'] = $v['attachment'];
					$result[$k]['sender'] = array(
						'sender_id' => $v['sender_id'],
						'name' => $sender_info['fname'],
						'image' => $profile_pic,
					);
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getDisputeHistory($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		/* $this->db->where('milestone_id', $srch['milestone_id']);
		$this->db->where('project_id', $srch['project_id']); */
		$this->db->where('dispute_id', $srch['dispute_id']);
		
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('id', 'DESC')->get('dispute_history')->result_array();

			if(count($result) > 0){
				foreach($result as $k => $v){
					
					$employer_info = $this->db->where('user_id', $v['employer_id'])->get('user')->row_array();
					$freelancer_info = $this->db->where('user_id', $v['worker_id'])->get('user')->row_array();
					
					$result[$k]['employer_info'] = $employer_info;
					$result[$k]['freelancer_info'] = $freelancer_info;
					
				}
			}
		}else{
			$result = $this->db->get('dispute_messages')->num_rows();
		}
		
		return $result;
	}
	
	public function getPendingDispute($project_id='', $bidder_id=''){
		$m_rows= $this->db->select('sum(amount) as amount')->from('escrow_new')->where(array('project_id' => $project_id, 'status' => 'D'))->get()->row_array();
		
		if(!empty($m_rows)){
			return $m_rows['amount'];
		}
		
		return 0;
	}
	
	public function getApproveDispute($project_id=''){
		$m_rows= $this->db->select('milestone_id')->from('escrow_new')->where(array('project_id' => $project_id))->get()->result_array();
		$dispute_milestones = array();
		
		if($m_rows){
			foreach($m_rows as $k => $v){
				$dispute_milestones[] = $v['milestone_id'];
			}
			
			
			
			$this->db->select("(sum(employer_amount)) as diff",FALSE)
				->from('dispute_history')
				->where_in('milestone_id', $dispute_milestones)
				->where('status', 'A');
				
			$result = $this->db->get()->row_array();
			
			if(!empty($result['diff'])){
				return $result['diff'];
			}
			
			return 0;
		}
	}
	
	public function getCommission($project_id=''){
		$c_rows= $this->db->select('sum(commission) as commission')->from('milestone_payment')->where(array('project_id' => $project_id, 'release_type' => 'P'))->get()->row_array();
		
		if(!empty($c_rows)){
			return $c_rows['commission'];
		}
		
		return 0;
		
	}
	
	
	public function update_time_track($data=array()){
		
		$where = array('dispute_id' => $data['dispute_id']);
		$count = $this->db->where($where)->count_all_results('dispute_time_track');
		
		if($count == 0){
			
			$ins = array(
				'dispute_id' => !empty($data['dispute_id']) ? $data['dispute_id'] : '',
				'milestone_id' => !empty($data['milestone_id']) ? $data['milestone_id'] : '',
				'project_id' => !empty($data['project_id']) ? $data['project_id'] : '',
				'last_respond_time' => date('Y-m-d H:i:s'),
				'last_respond_user' => !empty($data['last_respond_user']) ? $data['last_respond_user'] : '',
				'last_respond_against_user' => !empty($data['last_respond_against_user']) ? $data['last_respond_against_user'] : '',
				'dispute_status' => !empty($data['dispute_status']) ? $data['dispute_status'] : 'P',
			);
			
			$this->db->insert('dispute_time_track', $ins);
			
		}else{
			
			$ins = array(
				'milestone_id' => !empty($data['milestone_id']) ? $data['milestone_id'] : '',
				'project_id' => !empty($data['project_id']) ? $data['project_id'] : '',
				'last_respond_time' => date('Y-m-d H:i:s'),
				/* 'last_respond_user' => !empty($data['last_respond_user']) ? $data['last_respond_user'] : '',
				'last_respond_against_user' => !empty($data['last_respond_against_user']) ? $data['last_respond_against_user'] : '', */
				'dispute_status' => !empty($data['dispute_status']) ? $data['dispute_status'] : 'P',
			);
			
			if(!empty($data['last_respond_user'])){
				$ins['last_respond_user'] = $data['last_respond_user'];
			}
			
			if(!empty($data['last_respond_against_user'])){
				$ins['last_respond_against_user'] = $data['last_respond_against_user'];
			}
			
			$this->db->where($where);
			$this->db->update('dispute_time_track', $ins); 
			
		}
	}
	
	public function check_unresponded_disputes(){
		$dispute_list = $this->_get_unresponded_disputes();
		
		if($dispute_list){
			$this->process_dispute($dispute_list);
		}
	}
	
	private function _get_unresponded_disputes(){
		$dispute_respond_time = DISPUTE_RESPOND_TIME;
		$last_dispute_time = date('Y-m-d H:i:s', strtotime("-$dispute_respond_time hours"));
		$this->db
			->where('dispute_status', 'P')
			->where('last_respond_time <', $last_dispute_time);
		
		$result = $this->db->limit(5)->get('dispute_time_track')->result_array();
		
		return $result;
	}
	
	public function process_dispute($dispute_list=array()){
		
		foreach($dispute_list as $k => $v){
			$this->handle_dispute_payment($v);
			
		}
	}
	
	public function handle_dispute_payment($track=array()){
		$this->load->model('myfinance/myfinance_model');

		$this->load->model('myfinance/transaction_model');

		$this->load->helper('invoice');
		
		$milestone_id = $track['milestone_id'];

		$project_id = $track['project_id'];

		$p_type = getField('project_type', 'projects', 'project_id', $project_id);

		$invoice_id = $this->auto_model->getFeild("invoice_id","project_milestone","id",$milestone_id);

		$invoice_number = $this->auto_model->getFeild("invoice_number","invoice_main","invoice_id",$invoice_id);
		
		$escrow_check = $this->db->where(array('milestone_id' => $milestone_id, 'status' => 'D'))->get('escrow_new')->row_array();
		
		$dispute_history_row = array(
			'employer_id' => getField('user_id', 'projects', 'project_id', $project_id),
			'worker_id' => getField('bidder_id', 'projects', 'project_id', $project_id),
		);
		
		if(!empty($escrow_check) && !empty($dispute_history_row)){

			$user_wallet_id = get_user_wallet($track['last_respond_user']);
		
	
			// deduct milestone amount from escrow and transfer the amount in related account

			

			/* $commission = (($escrow_check['amount'] * SITE_COMMISSION) / (100+SITE_COMMISSION));  */
			$commission = $escrow_check['admin_fee'];

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

			

			$inv_id = create_invoice($invoice_data); /* creating invoice*/

			

			$invoice_row_data = array(

				'invoice_id' => $inv_id,

				'description' => 'Commission - ' . SITE_COMMISSION . '% for invoice number #'.$invoice_number,

				'per_amount' => $commission,

				'unit' => '-',

				'quantity' => 1,

			);

			

			add_invoice_row($invoice_row_data); /* adding invoice row*/

			

			add_project_invoice($project_id, $inv_id);


			// transaction insert

			$new_txn_id = $this->transaction_model->add_transaction(DISPUTE_PAYMENT_ESCROW,  $dispute_history_row['employer_id']);

			

			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $escrow_check['amount'], 'ref' => $escrow_check['escrow_id'], 'info' => 'Dispute settlement'));

			

			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $escrow_check['amount'], 'ref' => $milestone_id, 'info' => 'Dispute settlement received #'.$project_id));

			
			$new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $track['last_respond_user']);
			/* $new_txn_id_2 = $this->transaction_model->add_transaction(COMMISSION,  $track['last_respond_user'], 'Y', $inv_id); */

			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $user_wallet_id, 'debit' => $commission, 'ref' => $milestone_id, 'info' => 'commission paid #'.$project_id));

			

			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission, 'ref' => $milestone_id, 'info' => 'Commission received #'.$project_id));
			
			$bid_id = getField('bid_id', 'project_milestone', 'id', $escrow_check['milestone_id']);
			$new_txn_id_3 = $this->transaction_model->add_transaction(TAX_PAYMENT,  $track['last_respond_user']);

			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_3, 'wallet_id' => $user_wallet_id, 'debit' => $escrow_check['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$escrow_check['project_id']));
			
			$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_3, 'wallet_id' => TAX_WALLET, 'credit' => $escrow_check['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$escrow_check['project_id']));
		

			
			$amount_to_credit = $escrow_check['bidder_amt'];
			

			wallet_less_fund(ESCROW_WALLET,$escrow_check['amount']);

			

			wallet_add_fund($user_wallet_id, $amount_to_credit);


			wallet_add_fund(PROFIT_WALLET, $commission);
			wallet_add_fund(TAX_WALLET, $escrow_check['tax_amount']);
			
			check_wallet($user_wallet_id,  $new_txn_id);

			check_wallet(ESCROW_WALLET,  $new_txn_id);

			check_wallet(PROFIT_WALLET,  $new_txn_id);
			check_wallet(TAX_WALLET,  $new_txn_id);

			
			$this->db->where('escrow_id', $escrow_check['escrow_id'])->update('escrow_new', array('status' => 'R'));

			

			$pid = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);

			$pid = $project_id ;

			

			$project_txn = array(

				'project_id' => $project_id,

				'txn_id' => $new_txn_id,

			);

		

			$this->db->insert('project_transaction', $project_txn);

			

			$this->db->where('invoice_id', $invoice_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); 

			$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s'))); /* commission invoice mark as paid*/

			
			$track_update['milestone_id'] = $milestone_id;
			$track_update['project_id'] = $project_id;
			$track_update['dispute_id'] = $track['dispute_id'];
			$track_update['dispute_status'] = 'S'; /* Settled */ 
			
			$this->update_time_track($track_update);
	

			if($p_type == 'F'){

				$post_data['bider_to_pay']=$amount_to_credit;

				$post_data['employer_id'] =$dispute_history_row['employer_id'];

				$post_data['project_id'] = $this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);

				$post_data['milestone_id'] = $milestone_id;

				

				$post_data['worker_id'] = $dispute_history_row['worker_id'];

				

				$post_data['payamount'] = $amount_to_credit;

				

				$post_data['commission'] = $commission;

			  

				$post_data['reason_txt'] = $this->auto_model->getFeild("description","project_milestone","id",$milestone_id); 

				

				$post_data['release_type'] = 'P';

				$post_data['add_date'] = date('Y-m-d H:i:s');

				$post_data['status'] = 'Y';

				$post_data['commission_invoice_id'] = $inv_id;

				$insert = $this->db->insert('milestone_payment',$post_data);  

				

				

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

				$this->db->where('dispute_id', $track['dispute_id'])->update('dispute', array('dispute_settled' => '1'));

				/* $this->db->where(array('milestone_id' => $milestone_id, 'project_id' => $project_id))->update('invoice', array('payment_status' => 'PAID', 'amount_disputed' => $dispute_history_row['employer_amount'])); */

				

				/* $notification = "Your dispute settlement request has been approved "; */

				$notification2 = "Disputed milestone has been settled";
				$notification3 = "You have not responded within the timeframe. So the action has taken against you. ";

				

				$link = 'projectdashboard/dispute_room/'. $track['dispute_id'];

				/* $this->notification_model->log($track['last_respond_user'], $track['last_respond_user'], $notification, $link); */

				$this->notification_model->log($track['last_respond_user'], $track['last_respond_against_user'], $notification2, $link);
				$this->notification_model->log($track['last_respond_user'], $track['last_respond_against_user'], $notification3, $link);
				$this->notification_model->log($track['last_respond_user'], $track['last_respond_user'], $notification2, $link);

				/* send mail*/
				$project_title = getField('title', 'projects', 'project_id', $project_id);
				$user_1 = get_row(array(
					'select' => 'fname,email',
					'from' => 'user',
					'where' => array('user_id' => $track['last_respond_user']),
				));
				$user_2 = get_row(array(
					'select' => 'fname,email',
					'from' => 'user',
					'where' => array('user_id' => $track['last_respond_against_user']),
				));
				
				$template='dispute-settled-auto';
				$data_parse=array(
					'PROJECT'=>$project_title,
				);
				if($user_1){
					$data_parse['NAME'] = $user_1['fname'];
					send_layout_mail($template, $data_parse, $user_1['email']);
				}
				if($user_2){
					$data_parse['NAME'] = $user_2['fname'];
					send_layout_mail($template, $data_parse, $user_2['email']);
				}

				
			}else{

			
			}

			

		}
		
		
	}
	
 
}
