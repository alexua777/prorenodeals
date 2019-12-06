<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
  
class Meta extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('meta_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }
    public function index() {
	 redirect (base_url(). 'meta/page');
    }
	
	
	
	
	/////////////// Meta Add ///////////////////////////////////////////////
	public function add() {
	 $data['data'] = $this->auto_model->leftPannel();	 	 
	 $lay['left']="inc/section_left";
	 //$data['pagename']= $this->meta_model->getpagename();
	
	 if($this->input->post()){
		$this->form_validation->set_rules('pagename', 'Pagename', 'required|xss_clean|max_length[100]');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
		$this->form_validation->set_rules('meta_keys', 'Meta Keys', 'required');
		$this->form_validation->set_rules('meta_desc', 'Meta Description', 'required');
		$this->form_validation->set_rules('status', '', '');
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('add',$lay,$data); 
		}else{
		  $post_data = $this->input->post();
		  $insert_country = $this->meta_model->add_meta($post_data);
		  
		  if($insert_country){
		  	$this->session->set_flashdata('succ_msg', 'Inserted Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable To Insert');
		  }
		  redirect(base_url().'meta/page');
		}
	 	
	 }else{	
	  $this->layout->view('add',$lay,$data); 
	 }
	
    }
	
	
	//////////////edit meta menu////////////////////
	public function edit() {
	
	 $data['data'] = $this->auto_model->leftPannel();
    	 
	 $lay['lft']="inc/section_left";
	 //$data['pagename']= $this->meta_model->getpagename();
	 
	 $id = $this->uri->segment(3);
	 if($id==''){
	 $id = set_value('id'); 
	 }
	 
	 if($this->input->post()){
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
		$this->form_validation->set_rules('meta_keys', 'Meta Key', 'required');
		$this->form_validation->set_rules('meta_desc', 'Meata Desc', 'required');
		$this->form_validation->set_rules('pagename', 'pagename', 'required');
		$this->form_validation->set_rules('status', '', '');
		
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('edit',$lay,$data); 
		}else{
		  $post_data = $this->input->post();
		  $update = $this->meta_model->update_meta($post_data);
		  
		  if($update){
		  	$this->session->set_flashdata('succ_msg', 'Updated Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable to Update');
		  }
		  redirect(base_url().'meta/page');
		}
	 
	 }else{
	 
	 $data['id'] = $id;
	 $data['pagename'] = $this->auto_model->getFeild('pagename','meta','id',$id);
	 $data['status'] = $this->auto_model->getFeild('status','meta','id',$id);
	 $data['meta_title'] = $this->auto_model->getFeild('meta_title','meta','id',$id);
	 $data['meta_desc'] = $this->auto_model->getFeild('meta_desc','meta','id',$id);
	 $data['meta_keys'] = $this->auto_model->getFeild('meta_keys','meta','id',$id);
	 
									
	 	
	 $this->layout->view('edit',$lay,$data); 
	 }
    }
	
	///// Delete menu //////////////////////////////////
	public function delete(){
		$id = $this->uri->segment(3);
		$delete = $this->meta_model->delete_meta($id);
		  
		  if($delete){
			$this->session->set_flashdata('succ_msg', 'Deleted Successfully');
		  }else{
			$this->session->set_flashdata('error_msg', 'Unable to Delete');
		  }
		  redirect(base_url().'meta');
	}
	
	public function page($limit_from='')
	{
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "meta/page";
        $config["total_rows"] = $this->meta_model->record_count_meta();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
       // $config['page_query_string'] = TRUE;
		//$config['display_pages'] = TRUE;
        $this->pagination->initialize($config);

       // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
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
		
        $data['data'] = $this->auto_model->leftPannel();
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
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();
		$data["page"]=$config["total_rows"];
		//$data($config['per_page'])=3;
        $data['list'] = $this->meta_model->getmeta($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
     
	public function change_meta_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->meta_model->updatemeta($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'meta/page/');
	
	}

    

}
