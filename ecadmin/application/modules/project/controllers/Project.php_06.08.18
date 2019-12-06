<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project extends MX_Controller {

   
    public function __construct() {
        $this->load->model('project_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		parent::__construct();
		$this->load->helper('url');
    }

    public function index() {
	    redirect (base_url());
       
    }

  
    public function open($limit_from = '')
    {
		$data['data'] = $this->auto_model->leftPannel();
		//$data['new_data'] = $this->project_model->getAllBidsList($project_id);
		$data['status']=$this->uri->segment(2);
		//$data['srch']=$this->uri->segment(3);
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."project/open/";
        $config["total_rows"] = $this->project_model->record_count_open();
        $config["per_page"] =20;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

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
        $data["links"] = 	$this->pagination->create_links();
       // $data["links"] = $this->pagination->create_links();
        //$data["page"] = $config["per_page"];
        //$data($config['per_page'])=3;
		$data['all_data'] = $this->project_model->getAllOpenList($config["per_page"], $start);
   		$this->layout->view('list', $lay, $data);
    }
           
		   
		   
		
  public function process($limit_from = '')
    {
	$data['data'] = $this->auto_model->leftPannel();
	$data['status']=$this->uri->segment(2);
	//$data['srch']=$this->uri->segment(3);
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."project/process/";
        $config["total_rows"] = $this->project_model->record_count_process();
        $config["per_page"] = 20;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

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
        $data["links"] = 	$this->pagination->create_links();
        
		$data['all_data'] = $this->project_model->getAllProcessList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
    }   
		  
		  
		  
		  
	public function frozen($limit_from = '')
    {
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
	$data['status']=$this->uri->segment(2);
	//$data['srch']=$this->uri->segment(3);
        $config = array();
        $config["base_url"] = base_url().'project/frozen/';
        $config["total_rows"] = $this->project_model->record_count_frozen();
        $config["per_page"] = 20;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

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
        $data["links"] = 	$this->pagination->create_links();
        
		$data['all_data'] = $this->project_model->getAllFrozenList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
    }   
		  
		  
     public function complete($limit_from = '')
    {
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
	$data['status']=$this->uri->segment(2);
	//$data['srch']=$this->uri->segment(3);
        $config = array();
        $config["base_url"] = base_url().'project/complete/';
        $config["total_rows"] = $this->project_model->record_count_complete();
        $config["per_page"] = 20;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

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
        $data["links"] = 	$this->pagination->create_links();
       
		$data['all_data'] = $this->project_model->getAllCompletedList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
    }   
		
		
   public function expire($limit_from = '')
    {
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
	$data['status']=$this->uri->segment(2);
	//$data['srch']=$this->uri->segment(3);
        $config = array();
        $config["base_url"] = base_url().'project/expire/';
        $config["total_rows"] = $this->project_model->record_count_expire();
        $config["per_page"] = 20;
		$config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
		//$id = $this->input->get('project_id', TRUE);

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
        $data["links"] = 	$this->pagination->create_links();
    
		$data['all_data'] = $this->project_model->getAllExpireList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
    }   
	
	public function employer($pid="",$limit_from="")
	{     
		$data['data'] = $this->auto_model->leftPannel();	
		$lay['lft'] = "inc/section_left";            
        $data['pid']=$pid=$this->uri->segment(3);
		$config = array();
        $config["base_url"] = base_url().'project/employer/';
        $config["total_rows"] = $this->project_model->record_count_projecttracker($data['pid']);
        $config["per_page"] = 20;
		$config["uri_segment"] = 4;
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
        $data["links"] = 	$this->pagination->create_links();
		
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['project_details']=$this->project_model->getprojectdetails($data['pid']);
		
		$data['tracker_details']=$this->project_model->getprojecttracker($data['pid'], $config['per_page'], $start);  
		$data['from']='';
		$data['to']='';
        $this->layout->view('view_workroom', $lay, $data);
    }	
	public function employer_search($pid)
	{		
		
		$data['from']=$from=$this->input->get('from_txt');
		$data['to']=$to=$this->input->get('to_txt');
		$limit_from=$this->input->get('limit_from');
		$data['pid']=$pid=$this->uri->segment(3);
		if($from!='' && $to!='')
		{ 
	
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
 		$data['links']="";
		
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['project_details']=$this->project_model->getprojectdetails($data['pid']);		
		
		$data['tracker_details'] = $this->project_model->getFilterprojecttracker($pid,$from,$to);
   		$this->layout->view('view_workroom', $lay, $data);   
        
		}
		else
		{
			redirect(base_url().'project/employer/'.$pid);	
		}
        
  }
	
	public function screenshot($tracker_id="",$limit_from="")
	{		
		$data['data'] = $this->auto_model->leftPannel();	
		$lay['lft'] = "inc/section_left";         
		$data['tracker_id']=$this->uri->segment(3);  
		
		$config = array();
        $config["base_url"] = base_url().'project/screenshot/'.$data['tracker_id'].'/';
        $config["total_rows"] = $this->project_model->record_count_screenshot($data['tracker_id']);
        $config["per_page"] = 12;
		$config["uri_segment"] = 4;
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
        $data["links"] = 	$this->pagination->create_links();
            
        $data['pid']=$this->auto_model->getFeild('project_id','project_tracker','id',$data['tracker_id']);
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['screenshot_date']=$this->auto_model->getFeild('start_time','project_tracker','id',$data['tracker_id']);
		
		$data['tracker_details']=$this->project_model->getscreenshot($data['tracker_id'], $config['per_page'], $start);		
		
        $this->layout->view('screenshot', $lay, $data);        
    	
	}
		
		
   	public function bids($limit_from = '')
		{
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
			$config = array();
			$config["base_url"] = base_url();
			$config["total_rows"] = $this->project_model->record_count_bids();
			$config["per_page"] = 30;
			
			$id = $this->input->get('project_id', TRUE);
		
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
        $data["links"] = 	$this->pagination->create_links();
			//$data($config['per_page'])=3;
			$data['all_data'] = $this->project_model->getAllBidsList($id, $start);
			
			$this->layout->view('bids_list', $lay, $data);
		}
			   
		    
	
    public function change_status()
	{
		
		$status=$this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
			
		if($this->uri->segment(5) == 'del')
		{
			$update = $this->project_model->deleteProject($id);	
		}
		else
		{
			$update = $this->project_model->updateProject($data,$id,$status);
		}
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			if($this->uri->segment(4) == 'del')
				$this->session->set_flashdata('succ_msg', 'Deletion Successfully Done...');
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		if($this->uri->segment(3)=="O")
		{
			redirect(base_url() . 'project/open/');
		}
		else if($this->uri->segment(3)=="E")
		{
			redirect(base_url() . 'project/expire/');
		}
	}
	
    public function get_category()
	{
		$id = $this->uri->segment(3);
		$data['get_cat_list'] = $this->listing_model->getCatList($id);
		//print_r($data);die;
		$this->layout->view('get_category_list','', $data);
	}

 
	
    public function search_parent_footers()
	{
		$id = 0;
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		if($this->input->post('submit'))
		{
			$usr_select = $this->input->post('usr_select');
			$search_element = $this->input->post('search_element');
			$data['usr_select'] = $usr_select;
			$data['search_element'] = $search_element;
			if($usr_select=='' || $search_element=='' ||$usr_select=='all' )
			{	
				if($usr_select == 'all')	
				{
					$data['all_data'] = $this->footer_model->getAllFooterList($id);
					/*echo "<pre>";
					print_r($data);die;*/
					$data['usr_select'] = $usr_select;
					$this->layout->view('list', $lay, $data);
				}
				redirect(base_url().'footer/footer_list/'.$id);
			}
			else
			{
				$data['all_data'] = $this->footer_model->getAllSearchData($usr_select,$search_element,$id);
				$data['usr_select'] = $usr_select;
				$this->layout->view('list', $lay, $data);	
			}
		}
	}
	
        
        public function edit_project()
		{

		$data['id']=$id = $this->uri->segment(4);
		$data['status']=$status = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['parent_cat']=$this->project_model->getParentcat();
		$data['parent_skill']=$this->project_model->getParentskill();	
		//$data['id']=$id;
		if($id && $status)
		{
			$data['all_data'] = $this->project_model->getOpenProject($status,$id);
			
				
		}
		//get_print($data['all_data']);
		
		if($this->input->post('submit'))
		{  
					//print_r($this->input->post());die();
                    $this->form_validation->set_rules('title', 'Title', 'required');
    
                   // $this->form_validation->set_rules('category', 'Category', 'required');
					
					$this->form_validation->set_rules('skills', 'Skills', 'required');
					
					$this->form_validation->set_rules('description', 'Description', 'required');
					
					 $this->form_validation->set_rules('project_type', 'Project Type', 'required');
					 
					 if($this->input->post('project_type')=='F')
					 {
						//$this->form_validation->set_rules('budgetall', 'Budget', 'required');
					}
					elseif($this->input->post('project_type')=='H')
					{
					 //$this->form_validation->set_rules('buget_min', 'Minimum Budget', 'required|numeric');

					 //$this->form_validation->set_rules('buget_max', 'Miximum Budget', 'required|numeric');
					}
				
                    if ($this->form_validation->run() == FALSE)
                    {
						
                        $this->layout->view('edit', $lay, $data);
                    }
                    else
                    { 
					
						
						$post_data['title'] = $this->input->post('title');
						
						//$post_data['category'] = $this->input->post('category');
						
						$post_data['description'] =$this->input->post('description');
						
						$post_data['project_type'] = $this->input->post('project_type');
						
						/*  if($this->input->post('project_type')=='F')
						 {
							$b=  explode("#",$this->input->post('budgetall'));
							$post_data['buget_min']=$b[0];
							$post_data['buget_max']=$b[1];	 
						}
						else
						{
							$post_data['buget_min']=$this->input->post('budget_min');
							$post_data['buget_max']=$this->input->post('budget_max');	
						} */
						$post_data['visibility_mode'] = $this->input->post('visibility_mode');
						$post_data['environment'] = $this->input->post('environment');
						$post_data['featured']=	$this->input->post('featured');					
						//$post_data['budgetall'] = $this->input->post('budgetall');
						/*
						$ball=$this->input->post('budgetall');
							$bmin=0;
							$bmax=0;
							if($ball!=""){ 
							$b=  explode("-",$this->input->post('budgetall'));
							$bmin=$b[0];
							$bmax=$b[1];
							}
							else{ 
							$bmin=$this->input->post('budget_min');
							$bmax=$this->input->post('budget_max');
							} */
						
						
							if($status=='O'){
							$fnc = 'open';
						}elseif($status=='F'){
							$fnc = 'frozen';
						}
						elseif($status=='P'){
							$fnc = 'process';
						}
						elseif($status=='C'){
							$fnc = 'complete';
						}
						elseif($status=='E'){
							$fnc = 'expire';
						}
						$subskill = $this->input->post('skills');
			            $update = $this->project_model->updateProject($post_data,$id,$status, $subskill);
						
							
			if ($update)
            {
                            $this->session->set_flashdata('succ_msg', 'Update Successfully');
			}
           else
           {
                            $this->session->set_flashdata('error_msg', 'unable to Update');
		    }
			redirect(base_url() . 'project/'.$fnc);
                    }
		
		
		}
		//print_r($data['all_data']);die();
			$this->layout->view('edit', $lay, $data);
		
		
	}
	
	
	
	
	
	
	
		   	public function bid_list($project_id,$limit_from = '')
				{
					$data['data'] = $this->auto_model->leftPannel();
					$lay['lft'] = "inc/section_left";
				    $id = $project_id; 
					$data['all_data'] = $this->project_model->getAllBidder($id);
					
					$this->layout->view('bids_list', $lay, $data);
				}
					
		public function milestone_list($project_id,$limit_from = '')
				{
					$data['data'] = $this->auto_model->leftPannel();
					$lay['lft'] = "inc/section_left";
				    $id = $project_id; 
					$data['all_data'] = $this->project_model->getAllMilestone($id);
					foreach($data['all_data'] as $key => $val){
						$data['all_data'][$key]['invoice_id']=$this->project_model->getInvoiceId($project_id,$val['id']);
					}
					$data['project_id'] = $project_id;
					
					$this->layout->view('milestone_list', $lay, $data);
				}			
					
		/////////////////////////////////////////// SEARCH PROJECT START //////////////////////////////////////
		
			public function search_project($status='',$title='',$limit_from='') {
					$data['data'] = $this->auto_model->leftPannel();
					$data['status']=$this->uri->segment(3);
					//$data['srch']=$this->uri->segment(4);
					$data['srch']=$this->input->get();
					
					$title=$this->input->get('search_element');
					$lay['lft'] = "inc/section_left";
					if ($title=='') {
						redirect(base_url() . 'project/'.$status );
					}
					else
					{
						if($status=='open')
						{
							$st='O';	
						}
						if($status=='process')
						{
							$st='P';	
						}
						if($status=='frozen')
						{
							$st='F';	
						}
						if($status=='complete')
						{
							$st='C';	
						}
						if($status=='expire')
						{
							$st='E';	
						}
						
						
						$config = array();
						$config["base_url"] = base_url()."project/search_project/".$status."/".$title."/";
						$config["total_rows"] = $this->project_model->record_count_filter($st,$title);
						$config["per_page"] =20;
						$config["uri_segment"] = 5;
						$config['use_page_numbers'] = TRUE;
						//$id = $this->input->get('project_id', TRUE);
				
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
						$data['all_data'] = $this->project_model->getFilterProjectList($title,$st,$config["per_page"], $start);
						$this->layout->view('list', $lay, $data);
						
					}
			}
		
		
		
		/////////////////////////////////////////// SEARCH PROJECT END //////////////////////////////////////
	
	
    public function add_sub_footer()
	{
		$id = $this->uri->segment(3);
		if($id == '')
                {
			$id = 0;
                }
                else
		{
			$data['parent_id'] = $id;
			$data['parent_footer_name'] = $this->auto_model->getFeild('footer_cat_name','footer_management','footer_id',$id);
		}
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		
		if($this->input->post('submit'))
		{
			$new_data['footer_cat_name'] = $this->input->post('footer_cat_name');
			$new_data['footer_link'] = $this->input->post('footer_link');
			$new_data['ord'] = $this->input->post('ord');
			
			$new_data['footer_parent_id'] = $this->input->post('footer_parent_id');
			$new_data['footer_status'] = $this->input->post('footer_status');
			
			$insert = $this->footer_model->insertParentCategory($new_data);
			if ($insert) {
				$this->session->set_flashdata('succ_msg', 'Inserted Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to insert');
			}
			redirect(base_url() . 'footer/add_sub_footer/'.$id);
		
		
		}
		
		$this->layout->view('add_sub_footer', $lay, $data);
		
	}
        
    public function sub_footer_list() {
		$id = $this->uri->segment(3);
		if($id != '')
		{
			$data['parent_id'] = $id;
			$data['parent_footer_name'] = $this->auto_model->getFeild('footer_cat_name','footer_management','footer_id',$id);
		}
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['all_data'] = $this->footer_model->getAllFooterList($id);
		/*echo "<pre>";
		print_r($data);die;*/
   		$this->layout->view('sub_footer_list', $lay, $data);
		
	}
	
    public function search_sub_footers()
	{
		$id = $this->uri->segment(3);
		if($id != '')
		{
			$data['parent_id'] = $id;
			$data['parent_footer_name'] = $this->auto_model->getFeild('footer_cat_name','footer_management','footer_id',$id);
		}
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		if($this->input->post('submit'))
		{
			$usr_select = $this->input->post('usr_select');
			$search_element = $this->input->post('search_element');
			$data['usr_select'] = $usr_select;
			$data['search_element'] = $search_element;
			if($usr_select=='' || $search_element=='' ||$usr_select=='all' )
			{	
				if($usr_select == 'all')	
				{
					$data['all_data'] = $this->footer_model->getAllFooterList($id);
					/*echo "<pre>";
					print_r($data);die;*/
					$data['usr_select'] = $usr_select;
					$this->layout->view('sub_footer_list', $lay, $data);
				}
				redirect(base_url().'footer/sub_footer_list/'.$id);
			}
			else
			{
				$data['all_data'] = $this->footer_model->getAllSearchData($usr_select,$search_element,$id);
				$data['usr_select'] = $usr_select;
				$this->layout->view('sub_footer_list', $lay, $data);	
			}
		}
	}
	
    public function edit_sub_footer()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$parent_id = $this->uri->segment(4);
		$data['parent_id'] = $parent_id;
		$data['parent_footer_name'] = $this->auto_model->getFeild('footer_cat_name','footer_management','footer_id',$parent_id);
		if($id)
		{
			$parent_id=0;
			$data['all_data'] = $this->footer_model->getAPerticulerFooterDataUsingId($id);
			$data['parent_info'] = $this->footer_model->getAllFooterList($parent_id);
		}
		else
		{
			redirect(base_url().'footer/footer_list');
		}
		if($this->input->post('submit'))
		{
			$footer_id = $this->input->post('footer_id');
			$parent_id = $this->input->post('parent_id');
			$new_data['footer_cat_name'] = $this->input->post('footer_cat_name');
			$new_data['footer_link'] = $this->input->post('footer_link');
			$new_data['ord'] = $this->input->post('ord');
			$new_data['footer_parent_id'] = $this->input->post('footer_parent_id');
			$new_data['footer_status'] = $this->input->post('footer_status');
			/*echo "<pre>";
			print_r($new_data);die;*/
			$update = $this->footer_model->updateFooterCategory($new_data,$footer_id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to update');
			}
			redirect(base_url() . 'footer/edit_sub_footer/'.$footer_id.'/'.$parent_id);
		}
		
		$this->layout->view('edit_sub_footer', $lay, $data);
		
	}
	
	public function change_project_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['project_status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['project_status'] = 'Y';
		
		
		$update = $this->project_model->updateprojectstatus($data,$id);
		if($update)
		
		if ($update) {
			$user=$this->auto_model->getFeild('user_id','projects','id',$id);
			$user_country=$this->auto_model->getFeild('user_country','projects','id',$id);
			$title=$this->auto_model->getFeild('title','projects','id',$id);
			$project_id=$this->auto_model->getFeild('project_id','projects','id',$id);
			$to_mail=$this->auto_model->getFeild('email','user','user_id',$user);
			$from=ADMIN_EMAIL;
			$to=$this->input->post('email');
			$template='admin_approve_job';
			$data_parse=array('title'=>$this->input->post('title')
						);					
			$this->auto_model->send_email($from,$to_mail,$template,$data_parse);
			
			$sender_userid=$this->auto_model->get_results('user',array('country'=>$user_country),'user_id','','','');						
			$userid="";
			foreach($sender_userid as $key=>$val)
			{
				 $userid.= $val['user_id'].",";
			}
			$userid=rtrim($userid,",");
			$postdata['project_id']=$project_id;
			$postdata['user_id']=$userid;
			$inser_jobnotification = $this->project_model->add_jobnotification($postdata);
			
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(6);
		
		redirect(base_url() . 'project/'.$status);
	
	}
	  
 	public function getsubcat(){ 
        $data=$this->auto_model->getcategory($this->input->post('pid'));
        
        $result="<option value='>Select one sub category</option>";        
        foreach($data as $key=>$row){           
           $result.="<option value='".$row['cat_name']."'>".$row['cat_name']."</option>";            
        }
        echo $result;        
    }

    public function getsubskill(){ 
        $data=$this->auto_model->getskill($this->input->post('sid'));
        
		$result="<option value=''>Plese Choose Subskill</option>";        
        foreach($data as $key=>$row){           
           $result.="<option value='".$row['skill_name']."'>".$row['skill_name']."</option>";            
        }
        echo $result;        
    }
	
	/* Release fund hourly */ 
	
	public function release_hour(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request()){
			$id = post('id');
			
			$error = 0;
			
			$tracker_row = get_row(array('select' =>'*', 'from' => 'project_tracker' ,  'where' => array('id' => $id)));
			
			$project_id = $tracker_row['project_id'];
			$freelancer_id = $tracker_row['worker_id'];
			
			$user_id = getField('user_id', 'projects', 'project_id', $project_id);
			$freelancer_wallet_id = get_user_wallet($freelancer_id);
			
			$total_cost_new = 0;
			$bid_row=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$tracker_row['worker_id'])));
			
			$client_amt = $bid_row['total_amt'];
			$minute_cost_min = ($client_amt/60);
			$total_min_cost = $minute_cost_min *floatval($tracker_row['minute']);
            $total_cost_new=(($client_amt*floatval($tracker_row['hour']))+$total_min_cost);
			$total_cost_new=round($total_cost_new , 2);
			$total_pay_amount=$total_cost_new;
			
			$total_deposit = get_project_deposit($project_id);
			$total_release = get_project_release_fund($project_id);
			$total_pending = get_project_pending_fund($project_id);
			$remaining_bal = $total_deposit - $total_release - $total_pending;
			
			$remaining_deposit = $total_deposit - $total_release;
			
			$commission = (($total_cost_new * SITE_COMMISSION) / 100) ; 
			$total_cost_new = $total_cost_new - $commission;
			
			
			if($remaining_deposit < $total_cost_new){
				//  employer has no enough balance in his deposit
				$json['errors']['fund'] = '<div class="info-error">Not enough balance in employer project deposit</div>';
				$error++;
			}
		
			if($error == 0){
				$this->load->model('member/transaction_model');
				
				$ref = json_encode(array('project_id' => $project_id, 'paid_amount' => $total_cost_new, 'commission' => $commission));
				
				// transaction insert
				$new_txn_id = $this->transaction_model->add_transaction(FREELANCER_PAYMENT_ESCROW,  $user_id);
				
				
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $total_pay_amount, 'ref' => $ref , 'info' => 'Project payment to freelancer #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $freelancer_wallet_id, 'credit' => $total_cost_new, 'ref' => $ref , 'info' => 'Project payment received #'.$project_id));
				
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $commission , 'ref' => $ref, 'info' => 'Commission received'));
				
				wallet_less_fund(ESCROW_WALLET,  $total_pay_amount);
			
				wallet_add_fund($freelancer_wallet_id, $total_cost_new);
				wallet_add_fund(PROFIT_WALLET, $commission);
				
				check_wallet($freelancer_wallet_id,  $new_txn_id);
				
				check_wallet(ESCROW_WALLET,  $new_txn_id);
				check_wallet(PROFIT_WALLET,  $new_txn_id);
				
				$this->db->where('id', $id)->update('project_tracker', array('status' => '1', 'payment_status' => 'P'));
				
				$project_txn = array(
					'project_id' => $project_id,
					'txn_id' => $new_txn_id,
				);
				
				$this->db->insert('project_transaction', $project_txn);
				
				$project_txn_id  = $this->db->insert_id();	
				
				set_flash('succ_msg', 'Fund Successfully Released');		
				
				$e_user_id = getField('user_id', 'projects', 'project_id', $project_id);
				$title = getField('title', 'projects', 'project_id', $project_id);
			
			/* 	$notification = "Payment received for $title";
				$link = 'projectdashboard_new/freelancer/milestone/'.$project_id;
				$this->notification_model->log($e_user_id, $freelancer_id, $notification, $link); */
				
				$json['status'] = 1;
				
			}else{
				$json['status'] = 0;
			}
			
			
			echo json_encode($json);
		}
	}
	
}
