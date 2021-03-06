<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_support extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('user_support_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
		
    }
	

    public function index() {
       redirect(base_url('user_support/list_all'));
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
		
		$data['all_data'] = $this->user_support_model->get_support_list($srch,  $start, $per_page);
		$data['all_data_count'] = $this->user_support_model->get_support_list($srch, '', '', FALSE);
		
        $config = array();
        $config["base_url"] = base_url()."user_support/list_all";
        $config["total_rows"] = $data['all_data_count'];
        $config["per_page"] = $per_page;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		
        $this->pagination->initialize($config);

        $config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' <i class="la la-angle-double-right"></i>';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="la la-angle-double-left"></i> '.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
		
		$this->layout->view('list', $lay, $data); 
	}
	
	public function detail($id=''){
		$this->load->model('notification/notification_model');
		$data = array();
		$data['srch'] = $srch = $this->input->get();
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['detail'] = $this->user_support_model->get_detail($id);
		
		if(post()){
			$post = post();
			$post['replied'] = 1;
			$update['data'] = $post;
			$update['where']= array('id' => $id);
			$update['table']= 'user_support';
			$upd = update($update);
			$msg = 'New Reply From Admin ';
			$link= 'dashboard/support';
			$this->notification_model->log(0, $data['detail']['user_id'], $msg, $link);
			if($upd){
				set_flash('succ_msg', 'Reply Successfully Send');
			}else{
				set_flash('error_msg', 'Unable to send reply');
			}
			
			redirect(base_url('user_support/list_all'));
			
		}
		
		$this->layout->view('detail', $lay, $data); 
	}
	
	public function delete($id=''){
		$del = $this->db->where('id', $id)->delete('user_support');
		
		if($del){
			set_flash('succ_msg', 'Record successfully deleted');
		}else{
			set_flash('error_msg', 'Unable to delete record');
		}
		
		redirect(base_url('user_support/list_all'));
	}
	
	

}
