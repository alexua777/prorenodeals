<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contest extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('contest_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
		$this->check_contest();
    }
	

    public function index() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        //$data['list'] = $this->skills_model->getCats();

        $this->layout->view('list', $lay, $data);
    }
	
	
	
	public function list_all($limit_from=0){
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
		
		$data['all_data'] = $this->contest_model->getContestList($srch,  $start, $per_page);
		$data['all_data_count'] = $this->contest_model->getContestList($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."contest/list_all";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
		
		//pre($data);
		
		$this->layout->view('list', $lay, $data); 
	}
	
	public function contest_entries($contest_id='', $limit_from=0){
		if(!$contest_id){
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
		
		$srch['contest_id'] = $contest_id;
		
		$data['all_data'] = $this->contest_model->getContestEntries($srch,  $start, $per_page);
		$data['all_data_count'] = $this->contest_model->getContestEntries($srch, '', '', FALSE);
		$data['contest_detail'] = $this->db->where('contest_id', $contest_id)->get('contest')->row_array();
        $config = array();
        $config["base_url"] = base_url()."contest/contest_entries/".$contest_id;
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 4;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
		
		//pre($data);
		
		$this->layout->view('entry_list', $lay, $data); 
	}
	
	public function entry_detail($id=''){
		$data = array();
		
		$entry_id = $id;
		
		$data['entry_detail'] = $this->db->where('entry_id', $entry_id)->get('contest_entry')->row_array();
		$data['entry_files'] = $this->db->where('entry_id', $entry_id)->get('contest_entry_files')->result_array();
		$data['entry_user_detail'] = $this->db->where('user_id', $data['entry_detail']['user_id'])->get('user')->row_array();
		
		$data['entry_comments'] = $this->contest_model->getEntryComments($entry_id);
		
		//get_print($data, false);
		$this->load->view('entry_detail', $data);
	}
	
	public function award_contest(){
		$json = array();
		
		$this->load->model('notification_model');
		
		if(post() && $this->input->is_ajax_request()){
			$entry_id = post('entry_id');
			$contest_id = post('contest_id');
			$contest_owner = getField('user_id', 'contest', 'contest_id', $contest_id);
			$contest_row = $this->db->where(array('contest_id' => $contest_id))->get('contest')->row_array();
			$entry_user_id = getField('user_id', 'contest_entry', 'entry_id', $entry_id);
			
			$user_id =$contest_owner;
			
			$entry_user_wallet_id = get_user_wallet($entry_user_id);
			// check contest owner
			if(($contest_owner == $user_id) && ($contest_row['status'] != 'C')){
				// award to user
				$budget = getField('budget', 'contest', 'contest_id', $contest_id);
				$user_wallet_id = get_user_wallet($user_id);
				$wallet_balance = get_wallet_balance($user_wallet_id);
				
				if($wallet_balance < $budget){
					
					// no enough balance in wallet
					
					$json['errors']['wallet'] = 'Not enough balance in wallet '; 
					$json['status'] = 0;
			
					
				
				}else{
					
					$this->load->model('member/transaction_model');
					
					$ref = json_encode(array('entry_id' => $entry_id, 'contest_id' => $contest_id));
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(CONTEST_AWARDED,  $user_id);
					
					
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $budget, 'ref' => $ref , 'info' => 'Contest Awarded To Entry #'.$entry_id));
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $entry_user_wallet_id, 'credit' => $budget, 'ref' => $ref , 'info' => 'Contest Awarded'));
					
					wallet_less_fund($user_wallet_id,  $budget);
				
					wallet_add_fund($entry_user_wallet_id, $budget);
					
					check_wallet($user_wallet_id,  $new_txn_id);
					
					check_wallet($entry_user_wallet_id,  $new_txn_id);
					
					$this->db->where('entry_id', $entry_id)->update('contest_entry', array('is_awarded' => 1));
					$this->db->where('contest_id', $contest_id)->update('contest', array('status' => 'C'));
					
					$contest_title = getField('title', 'contest', 'contest_id', $contest_id);
					
					$notification = "Congratulation, you have been awarded for the contest <b>$contest_title</b>";
					$link = 'contest/contest_detail/'.$contest_id;
					$this->notification_model->log($user_id, $entry_user_id, $notification, $link);
					
					$json['status'] = 1;
					
				}
			
			}else{
				$json['errors']['user'] = 'Invalid Request '; 
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
		
	
	}
	
	
	public function check_contest(){
		$today = date('Y-m-d');
		$this->db->where("DATE('$today') > ended AND status = 'Y'")->update('contest', array('status' => 'N'));
	}
	
	
	

}
