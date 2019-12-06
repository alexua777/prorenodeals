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
		$this->load->model('notification/notification_model');
        parent::__construct();
		$this->load->library('pagination');
		$this->check_contest();
		
		/* $idiom = $this->session->userdata('lang');
		$this->lang->load('projectdashboard',$idiom); */
		
    }

	public function post_contest(){
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=contest/post_contest");
		}
		
		$data = array();
		$data['categories'] = $this->db->where(array('parent_id' => 0 , 'status' => 'Y'))->get('categories')->result_array();
		//get_print($data, false);
		$breadcrumb=array(
			array(
					'title'=>'Contest','path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Contest');
		$this->layout->view('post_contest','',$data,'normal');   
	}
	
	
	public function contest_entry($contest_id=''){
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=contest/contest_entry/".$contest_id);
		}
		
		$data = array();
		$user = $this->session->userdata('user');
		$data['user_id'] = $user_id = $user[0]->user_id;
		
		$data['details'] = $this->db->where('contest_id', $contest_id)->get('contest')->row_array();
		$data['contest_id'] = $contest_id;
		$data['contest_entry_detail'] = $this->contest_model->getEntryDetail($contest_id, $user_id);
		//get_print($data, false);
		$this->layout->view('contest_entry','',$data,'normal');   
	}
	
	public function contest_detail($contest_id='', $title=''){
		$data = array();
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=contest/contest_detail/".$contest_id);
		}
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['login_user_id'] = $user_id;
		
		
		
		$data['details'] = $this->db->where('contest_id', $contest_id)->get('contest')->row_array();
		$data['details']['employer_detail'] = $this->db->where('user_id', $data['details']['user_id'])->get('user')->row_array();
		$data['details']['skills'] = $this->db->where('contest_id', $contest_id)->get('contest_skills')->result_array();
		
		$data['active_tab'] = 'detail';
		//get_print($data, false);
		
		$this->layout->view('contest_detail','',$data,'normal');   
	}
	
	public function entries($contest_id='', $c_title=''){
		$data = array();
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=contest/entries/".$contest_id);
		}
		
		$srch = $srch_string = get();
		$data['contest_id'] = $srch['contest_id'] = $contest_id;
		
		$limit = !empty($srch_string['per_page']) ? $srch_string['per_page']:  0;
		$offset = 30;
		
		unset($srch_string['per_page']);
		unset($srch_string['total']);
		
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['login_user_id'] = $user_id;
		
		$data['details'] = $this->db->where('contest_id', $contest_id)->get('contest')->row_array();
		
		$data['active_tab'] = 'entries';
		
		$srch['login_user'] = $user_id;
		$data['entries_list'] = $this->contest_model->getContestEntry($srch, $limit, $offset);
		$data['entries_count'] = $this->contest_model->getContestEntry($srch, $limit, $offset, FALSE);
		
		$data['contest_comments'] = $this->contest_model->getComments($contest_id);
		
		$similar_contest_query = array(
			'select' => 'contest_id,user_id,title,budget',
			'from' => 'contest',
			'where' => array('category_id' => $data['details']['category_id'] , 'contest_id <>' => $contest_id, 'status' => 'Y'),
			'order_by' => array('contest_id', 'DESC')
		);
		
		$data['srch'] = $srch;
		/*Pagination Start*/
		
		$config['base_url'] = base_url("contest/entries/$contest_id?total=".$data['entries_count']);
		$config['base_url'] .= !empty($srch_string) ? '&'.http_build_query($srch_string) : '';
		
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['entries_count'];
		$config['per_page'] = $offset;
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		$data['similar_contest'] = get_results($similar_contest_query);
		//get_print($data, false);
		$this->layout->view('contest_entries','',$data,'normal');   
	}
	
	public function browse($c_id=''){
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data = array();
		$srch_string = $srch = get();
		$srch['cid'] = $c_id;
		$limit = !empty($srch_string['per_page']) ? $srch_string['per_page']:  0;
		$offset = 30;
		
		unset($srch_string['per_page']);
		unset($srch_string['total']);
		
		if(!empty($srch['skills'])){
			$data['selected_skills'] = $this->db->where_in('id', $srch['skills'])->get('skills')->result_array();
		}else{
			if($user_id > 0){
				$user_skills_arr = array();
				$user_skills = $this->db->where('user_id', $user_id)->get('new_user_skill')->result_array();
				if(count($user_skills) > 0){
					foreach($user_skills as $k => $v){
						$user_skills_arr[] = $v['sub_skill_id'];
					}
					
				}
				
				if(count($user_skills_arr) > 0){
					$srch['skills'] = $user_skills_arr;
					$data['selected_skills'] = $this->db->where_in('id', $user_skills_arr)->get('skills')->result_array();
				}
				
			}else{
				$data['selected_skills'] = array();
			}
			
		}
		
		$data['categories'] = $this->db->where(array('parent_id' => 0 , 'status' => 'Y'))->get('categories')->result_array();
		
		$data['contest_list'] = $this->contest_model->getContest($srch, $limit, $offset);
		$data['contest_count'] = $this->contest_model->getContest($srch, $limit, $offset, FALSE);
		
		/*Pagination Start*/
		
		$config['base_url'] = base_url('contest/browse?total='.$data['contest_count']);
		$config['base_url'] .= !empty($srch_string) ? '&'.http_build_query($srch_string) : '';
		
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['contest_count'];
		$config['per_page'] = $offset;
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		//get_print($data, false);
		$data['srch'] = $srch;
		$this->layout->view('list','',$data,'normal');   
	}
	
	public function get_skills(){
		$term = get('search');
		$skills = $this->contest_model->getSkills($term);
		echo json_encode($skills);
	}
	
	public function post_contest_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('category_id', 'category', 'required');
			$this->form_validation->set_rules('title', 'title', 'required|max_length[200]');
			$this->form_validation->set_rules('skills[]', 'skills', 'required');
			$this->form_validation->set_rules('description', 'description', '');
			$this->form_validation->set_rules('budget', 'budget', 'required|numeric|greater_than[0]');
			$this->form_validation->set_rules('days_run', 'days', 'required|numeric|greater_than[0]');
			
			if($this->form_validation->run()){
				$post = post();
				$skills_data = $post['skills'];
				
				unset($post['skills']);
				
				$contest_data = $post;
				$contest_data['user_id'] = $user_id;
				$contest_data['posted'] = date('Y-m-d');
				$contest_data['ended'] = date('Y-m-d', strtotime(" +{$post['days_run']} days "));
				$contest_data['status'] = 'Y';
				
				
				$error_count = 0;
				
				$balance_check = 0;
				
				$user_wallet_id = get_user_wallet($user_id);
				$wallet_balance = get_wallet_balance($user_wallet_id);
					
				if(!empty($contest_data['is_featured']) && ($contest_data['is_featured'] == 1)){
					
					$feature_amount = CONTEST_FEATURED_PRICE;
					$balance_check += $feature_amount ;
					
				}
				
				if(!empty($contest_data['is_sealed']) && ($contest_data['is_sealed'] == 1)){
					
					$sealed_amount = CONTEST_SEALED_PRICE;
					$balance_check += $sealed_amount ;
					
				}
				
				if($balance_check > 0){
					
					if($wallet_balance < $balance_check){
						
						// no enough balance in wallet
						$json['errors']['wallet'] = 'You do not have enough balance in your wallet '; 
						$json['status'] = 0;
				
						$error_count++;
					
					}
				}
				
				
				if($error_count == 0){
					
					// database entry
					
					$this->db->insert('contest', $contest_data);
					
					$contest_id = $this->db->insert_id();
					
					$this->load->model('myfinance/transaction_model');
					
					if(!empty($contest_data['is_featured']) && ($contest_data['is_featured'] == 1)){
						
						$ref = json_encode(array('contest_id' => $contest_id));
						
						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(CONTEST_FEATURED_PAYMENT,  $user_id);
						
						
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $feature_amount, 'ref' => $ref , 'info' => 'Featured Contest'));
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $feature_amount, 'ref' => $ref , 'info' => 'Featured Contest'));
						
						wallet_less_fund($user_wallet_id,  $feature_amount);
					
						wallet_add_fund(PROFIT_WALLET, $feature_amount);
						
						check_wallet($user_wallet_id,  $new_txn_id);
						
						check_wallet(PROFIT_WALLET,  $new_txn_id);
					
					}
					
					if(!empty($contest_data['is_sealed']) && ($contest_data['is_sealed'] == 1)){
						
						$ref = json_encode(array('contest_id' => $contest_id));
						
						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(CONTEST_SEALED_PAYMENT,  $user_id);
						
						
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $sealed_amount, 'ref' => $ref , 'info' => 'Sealed Contest'));
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $sealed_amount, 'ref' => $ref , 'info' => 'Sealed Contest'));
						
						wallet_less_fund($user_wallet_id,  $sealed_amount);
					
						wallet_add_fund(PROFIT_WALLET, $sealed_amount);
						
						check_wallet($user_wallet_id,  $new_txn_id);
						
						check_wallet(PROFIT_WALLET,  $new_txn_id);
					
					}
					
					
					if(count($skills_data) > 0){
						$ins = array();
						foreach($skills_data as $k => $v){
							
							$ins[] = array(
								'skill_id' => $v,
								'contest_id' => $contest_id,
							);
							
						}
						
						$this->db->insert_batch('contest_skills', $ins);
					}
					
					$json['status'] = 1;
					$json['data']['contest_id'] = $contest_id;
					
				}
				
				
			}else{
				$json['errors'] = validation_errors_array();
				$json['status'] = 0;
			}
			
			echo json_encode($json);
			
			
		}
	}
	
	public function upload_attachment(){
		
		$json = array();
		
		if(!empty($_FILES['file']['name']) && $this->input->is_ajax_request()){
			
			if(!is_dir('./assets/attachments')){
				mkdir('./assets/attachments');
			}
			
			$config['upload_path'] = './assets/attachments/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = TRUE;
			$config['file_ext_tolower'] = TRUE;
		
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('file')) {
				$json['errors']['file'] = $this->upload->display_errors();
				$json['status'] = 0;
				
			}else{
				$data = $this->upload->data();
				$file = array(
					'filename' => $data['file_name'],
					'org_filename' => $data['orig_name'],
					'file_size' => $data['file_size'],
					'file_type' => $data['file_ext'],
					
				);
				
				$json['data'] = $file;
				$json['data']['file_str'] = json_encode($file);
				$json['data']['file_path'] = base_url('assets/attachments').'/';
				$json['status'] = 1;
			}
			
			echo json_encode($json);
		}
	}
	
	
	public function contest_entry_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$post = post();
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('title', 'title', 'required|max_length[200]');
			$this->form_validation->set_rules('licensed', 'license', 'required');
			$this->form_validation->set_rules('description', 'description', '');
			$this->form_validation->set_rules('attachments[]', 'attachments', 'required', array('required' => 'Please attach some file'));
			$this->form_validation->set_rules('sale_price', 'budget', 'required|numeric');
			$this->form_validation->set_rules('contest_id', 'contest', 'required|numeric');
			
			if($this->form_validation->run()){
				$post = post();
				$attachments = post('attachments');
				
				unset($post['attachments']);
				
				$post['user_id'] = $user_id;
				$post['is_entry_complete'] = 'Y';
				
				$error_count = 0;
				
				$is_sealed_contest = getField('is_sealed', 'contest', 'contest_id', $post['contest_id']);
				
				if($is_sealed_contest == 1){
					$post['is_sealed'] = 1;
				}
				
				if(!empty($post['is_highlight']) && ($post['is_highlight'] == 1)){
					
					$feature_amount = CONTEST_ENTRY_HIGHLIGHT_PRICE;
					$user_wallet_id = get_user_wallet($user_id);
					$wallet_balance = get_wallet_balance($user_wallet_id);
					
					if($wallet_balance < $feature_amount){
						
						// no enough balance in wallet
						
						$json['errors']['wallet'] = 'You do not have enough balance in your wallet '; 
						$json['status'] = 0;
				
						$error_count++;
						
					}
				}
				
				if($error_count == 0){
					
					// database entry
					
					$this->db->insert('contest_entry', $post);
					
					$entry_id = $this->db->insert_id();
					
					if(!empty($post['is_featured']) && ($post['is_featured'] == 1)){
						
						$this->load->model('myfinance/transaction_model');
						
						$ref = json_encode(array('entry_id' => $entry_id));
						
						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(CONTEST_ENTRY_HIGHLIGHT_PAYMENT,  $user_id);
						
						
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $feature_amount, 'ref' => $ref , 'info' => 'Featured Contest'));
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $feature_amount, 'ref' => $ref , 'info' => 'Featured Contest'));
						
						wallet_less_fund($user_wallet_id,  $feature_amount);
					
						wallet_add_fund(PROFIT_WALLET, $feature_amount);
						
						check_wallet($user_wallet_id,  $new_txn_id);
						
						check_wallet(PROFIT_WALLET,  $new_txn_id);
					
					}
					
					if(count($attachments) > 0){
						foreach($attachments as $a){
							$a_arr = (array) json_decode($a);
							$a_arr['added_date'] = date('Y-m-d');
							$a_arr['entry_id'] = $entry_id;
							
							$ins['data'] = $a_arr;
							$ins['table'] = 'contest_entry_files';
							insert($ins);
						}
					}
					$contest_title = getField('title', 'contest', 'contest_id', $post['contest_id']);
					
					$fname = getField('fname', 'user', 'user_id', $user_id);
					$lname = getField('lname', 'user', 'user_id', $user_id);
					$name = $fname.' '.$lname;
					$to_user_id = getField('user_id', 'contest', 'contest_id', $post['contest_id']);
					
					$notification = "$name has posted an entry on contest <b>$contest_title </b>";
					$link = 'contest/entries/'.$post['contest_id'];
					$this->notification_model->log($user_id, $to_user_id, $notification, $link);
					
					$json['status'] = 1;
					$json['data']['entry_id'] = $entry_id;
					
				}
				
				
			}else{
				$json['errors'] = validation_errors_array();
				$json['status'] = 0;
			}
			
			echo json_encode($json);
			
			
		}
	}
	
	public function post_comment_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$post = post();
			$type = get('type');
			$comment = post('comment');
			$parent_id = post('parent_id');
			
			$comment_arr = array(
				'user_id' => $user_id,
				'comment' => $comment,
				'datetime' => date('Y-m-d H:i:s'),
				'parent_id' => !empty($parent_id) ? $parent_id : 0,
			);
			
			$this->db->insert('comments', $comment_arr);
			
			$comment_id = $this->db->insert_id();
			
			if($type == 'contest_comment'){
				
				$contest_id = post('contest_id');
				
				$contest_comment_arr = array(
					'contest_id' => $contest_id,
					'comment_id' => $comment_id,
				);
				
				$this->db->insert('contest_comment', $contest_comment_arr);
			}
			
			if($type == 'entry_comment'){
				$entry_id = post('entry_id');
				
				$entry_comment_arr = array(
					'entry_id' => $entry_id,
					'comment_id' => $comment_id,
				);
				
				$this->db->insert('entry_comment', $entry_comment_arr);
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
			
			
			$json['data']['user_id'] = $user_id;
			$json['data']['name'] = $fname.' '.$lname;
			$json['data']['avatar'] = $logo;
			$json['data']['date'] = date('d M, H:i A');
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	public function award_contest(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$entry_id = post('entry_id');
			$contest_id = post('contest_id');
			$contest_owner = getField('user_id', 'contest', 'contest_id', $contest_id);
			$contest_row = $this->db->where(array('contest_id' => $contest_id))->get('contest')->row_array();
			$entry_user_id = getField('user_id', 'contest_entry', 'entry_id', $entry_id);
			
			$entry_user_wallet_id = get_user_wallet($entry_user_id);
			// check contest owner
			if(($contest_owner == $user_id) && ($contest_row['status'] != 'C')){
				// award to user
				$budget = getField('budget', 'contest', 'contest_id', $contest_id);
				$user_wallet_id = get_user_wallet($user_id);
				$wallet_balance = get_wallet_balance($user_wallet_id);
				
				if($wallet_balance < $budget){
					
					// no enough balance in wallet
					
					$json['errors']['wallet'] = 'You do not have enough balance in your wallet '; 
					$json['status'] = 0;
			
					
				
				}else{
					
					$this->load->model('myfinance/transaction_model');
					
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
	
	public function  check_contest(){
		$today = date('Y-m-d');
		$this->db->where("DATE('$today') > ended AND status = 'Y'")->update('contest', array('status' => 'N'));
	}
	
	public function entry_detail($id=''){
		$data = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$entry_id = $id;
		
		$data['entry_detail'] = $this->db->where('entry_id', $entry_id)->get('contest_entry')->row_array();
		$data['entry_files'] = $this->db->where('entry_id', $entry_id)->get('contest_entry_files')->result_array();
		$data['entry_user_detail'] = $this->db->where('user_id', $data['entry_detail']['user_id'])->get('user')->row_array();
		$data['login_user_id'] = $user_id;
		
		$u_fname = getField('fname', 'user', 'user_id', $user_id);
		$u_lname = getField('lname', 'user', 'user_id', $user_id);
		$u_logo = getField('logo', 'user', 'user_id', $user_id);
		$data['contest_admin_user'] = getField('user_id', 'contest', 'contest_id', $data['entry_detail']['contest_id']);
		
		
		$data['login_user_detail']['fname'] = $u_fname ;
		$data['login_user_detail']['lname'] = $u_lname ;
		$data['login_user_detail']['name'] = $u_fname . ' '. $u_lname ;
		$data['login_user_detail']['logo'] = $u_logo ; 
		
		$data['allowed_users'] = array($data['entry_detail']['user_id'], $data['contest_admin_user']);
		
		$data['entry_markers'] = $this->contest_model->getMarker($data['entry_files']);
		
		$data['entry_comments'] = $this->contest_model->getEntryComments($entry_id);
		
		$data['given_rating'] = $this->db->where(array('entry_id' => $id, 'user_id' => $user_id))->get('entry_rating')->row_array();
		//get_print($data, false);
		$this->load->view('entry_detail', $data);
	}
	
	
	public function toggle_like(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$entry_id = post('entry_id');
			$is_liked = post('is_liked');
			
			$count = $this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->count_all_results('entry_likes');
			
			if($count === 0){
				$ins = array(
					'user_id' => $user_id,
					'entry_id' => $entry_id,
					'is_liked' => $is_liked,
				);
				$this->db->insert('entry_likes', $ins);
			}else{
				$this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->update('entry_likes', array('is_liked' => $is_liked));
			}
			
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	public function notify_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$contest_id = post('contest_id');
			$contest_holder_user_id = getField('user_id', 'contest', 'contest_id', $contest_id);
			
			$contest_title = getField('title', 'contest', 'contest_id', $contest_id);
			
			$fname = getField('fname', 'user', 'user_id', $user_id);
			$lname = getField('lname', 'user', 'user_id', $user_id);
			$name = $fname.' '.$lname;
			$to_user_id =$contest_holder_user_id;
			
			$notification = "$name will work on an entry and submit before end  for the contest <b>$contest_title </b>";
			$link = 'contest/entries/'.$post['contest_id'];
			$this->notification_model->log($user_id, $to_user_id, $notification, $link);
			
			set_flash('succ_msg', 'Notification send to contest holder. Keep your entry ready to submit.');
			$json['status'] = 1;
			echo json_encode($json);
		}
		
	}
	
	public function withdraw_contest(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$entry_id = post('entry_id');
			
			$this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->update('contest_entry', array('is_withdraw' => '1'));
			
			/*$contest_title = getField('title', 'contest', 'contest_id', $contest_id);
			
			 $fname = getField('fname', 'user', 'user_id', $user_id);
			$lname = getField('lname', 'user', 'user_id', $user_id);
			$name = $fname.' '.$lname;
			$to_user_id =$contest_holder_user_id;
			
			$notification = "$name will work on an entry and submit before end  for the contest <b>$contest_title </b>";
			$link = 'contest/entries/'.$post['contest_id'];
			$this->notification_model->log($user_id, $to_user_id, $notification, $link); */
			
			set_flash('succ_msg', 'Entry successfully withdraw');
			
			$json['status'] = 1;
			echo json_encode($json);
		}
		
	}
	
	public function withdraw_contest_repost(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$entry_id = post('entry_id');
			
			$this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->update('contest_entry', array('is_withdraw' => '0'));
			
			/*$contest_title = getField('title', 'contest', 'contest_id', $contest_id);
			
			 $fname = getField('fname', 'user', 'user_id', $user_id);
			$lname = getField('lname', 'user', 'user_id', $user_id);
			$name = $fname.' '.$lname;
			$to_user_id =$contest_holder_user_id;
			
			$notification = "$name will work on an entry and submit before end  for the contest <b>$contest_title </b>";
			$link = 'contest/entries/'.$post['contest_id'];
			$this->notification_model->log($user_id, $to_user_id, $notification, $link); */
			
			set_flash('succ_msg', 'Entry successfully withdraw');
			
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	public function change_entry_price(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$entry_id = post('entry_id');
			$price = post('price');
			
			$this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->update('contest_entry', array('sale_price' => $price));
			
			/*$contest_title = getField('title', 'contest', 'contest_id', $contest_id);
			
			 $fname = getField('fname', 'user', 'user_id', $user_id);
			$lname = getField('lname', 'user', 'user_id', $user_id);
			$name = $fname.' '.$lname;
			$to_user_id =$contest_holder_user_id;
			
			$notification = "$name will work on an entry and submit before end  for the contest <b>$contest_title </b>";
			$link = 'contest/entries/'.$post['contest_id'];
			$this->notification_model->log($user_id, $to_user_id, $notification, $link); */
			
			set_flash('succ_msg', 'Entry successfully withdraw');
			
			$json['status'] = 1;
			echo json_encode($json);
		}
	}
	
	public function save_marker(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$marker_array = array(
				'entry_file_id' => post('item_id'),
				'posX' => post('posX'),
				'posY' => post('posY'),
				'name' => post('name'),
				'user_id' => $user_id,
			);
			
			$this->db->insert('contest_file_marker', $marker_array);
			
			$marker_id = $this->db->insert_id();
			
			set_flash('succ_msg', 'Marker successfully added');
			
			$json['status'] = 1;
			$json['data'] = array(
				'marker_id' => $marker_id
			);
			
			echo json_encode($json);
		}
		
	}
	
	public function save_marker_comment(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$comment_array = array(
				'user_id' => $user_id,
				'marker_id' => post('marker_id'),
				'comment' => post('comment'),
				'datetime' => date('Y-m-d H:i:s'),
				
			);
			
			$this->db->insert('contest_marker_comment', $comment_array);
			
			$comment_id = $this->db->insert_id();
			
			set_flash('succ_msg', 'comment successfully added');
			
			$json['status'] = 1;
			$json['data'] = array(
				'comment_id' => $comment_id
			);
			
			echo json_encode($json);
		}
		
	}
	
	public function delete_marker(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$marker_id = post('marker_id');
			$deleted_by = post('deleted_by');
			
			$this->db->where('marker_id', $marker_id)->delete('contest_marker_comment');
			$this->db->where('marker_id', $marker_id)->delete('contest_file_marker');
			
			set_flash('succ_msg', 'marker successfully delete');
			
			$json['status'] = 1;
			
			echo json_encode($json);
		}
	}
	
	public function change_marker_color(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$marker_id = post('marker_id');
			$color = post('color');
			
			$this->db->where('marker_id', $marker_id)->update('contest_file_marker', array('color' => $color));
			
			set_flash('succ_msg', 'marker successfully delete');
			
			$json['status'] = 1;
			
			echo json_encode($json);
		}
	}
	
	
	public function save_rating(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			
			$entry_id = post('entry_id');
			
			$rating = array(
				'entry_id' => post('entry_id'),
				'user_id' => $user_id,
				'rating' => post('rating'),
				'date' => date('Y-m-d'),
			);
			
			$count = $this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->count_all_results('entry_rating');
			
			if($count > 0){
				$this->db->where(array('user_id' => $user_id, 'entry_id' => $entry_id))->update('entry_rating', $rating);
			}else{
				$this->db->insert('entry_rating', $rating);
			}
			
			set_flash('succ_msg', 'Operation successfully complete');
			
			$json['status'] = 1;
			
			echo json_encode($json);
		}
	}
	
	
}
