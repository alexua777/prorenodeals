<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
  
class Cms extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('cms_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }
    public function index() {
	 redirect (base_url(). 'cms/page');
    }
	
	
	
	
	/////////////// cms Add ///////////////////////////////////////////////
	public function add() {
	 $data['data'] = $this->auto_model->leftPannel();	 	 
	 $lay['left']="inc/section_left";
	 $data['ckeditor'] = $this->editor->geteditor('contents','Full');
	
	 if($this->input->post()){
		$this->form_validation->set_rules('cont_title', 'Content Title', 'required|max_length[100]');
		$this->form_validation->set_rules('pagename', 'Pagename', 'required|max_length[100]');
		$this->form_validation->set_rules('contents', '', '');
		$this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
		$this->form_validation->set_rules('meta_keys', 'Meta Keys', 'required');
		$this->form_validation->set_rules('meta_desc', 'Meta Description', 'required');
		$this->form_validation->set_rules('status', '', '');
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('add',$lay,$data); 
		}else{
		  $post_data = $this->input->post();
		  $insert_country = $this->cms_model->add_cms($post_data);
		  
		  if($insert_country){
		  	$this->session->set_flashdata('succ_msg', 'Contents Inserted Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable To Insert');
		  }
		  redirect(base_url().'cms/page');
		}
	 	
	 }else{	
	  $this->layout->view('add',$lay,$data); 
	 }
	
    }
	
	
	//////////////edit country menu////////////////////
	public function edit() {
	
	 $data['data'] = $this->auto_model->leftPannel();
    	 
	 $lay['lft']="inc/section_left";
	 
	 $data['ckeditor'] = $this->editor->geteditor('contents','Full');
	 
	 $id = $this->uri->segment(3);
	 if($id==''){
	 $id = set_value('id'); 
	 }
	 
	 if($this->input->post()){
	    $this->form_validation->set_rules('cont_title', 'Content Title', 'required');
		$this->form_validation->set_rules('contents','','');
		$this->form_validation->set_rules('meta_keys', 'Meta Key', 'required');
		$this->form_validation->set_rules('meta_desc', 'Meata Desc', 'required');
		$this->form_validation->set_rules('pagename', 'pagename', 'required');
		$this->form_validation->set_rules('status', '', '');
		
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('edit',$lay,$data); 
		}else{
		  $post_data = $this->input->post();
		  $update = $this->cms_model->update_cms($post_data);
		  
		  if($update){
		  	$this->session->set_flashdata('succ_msg', 'Contents Updated Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable to Update');
		  }
		  redirect(base_url().'cms/page');
		}
	 
	 }else{
	 
	 $data['id'] = $id;
	 $data['cont_title'] = $this->auto_model->getFeild('cont_title','content','id',$id);
	 $data['pagename'] = $this->auto_model->getFeild('pagename','content','id',$id);
	 $data['contents'] = $this->auto_model->getFeild('contents','content','id',$id);
	 $data['status'] = $this->auto_model->getFeild('status','content','id',$id);
	 $data['meta_title'] = $this->auto_model->getFeild('meta_title','content','id',$id);
	 $data['meta_desc'] = $this->auto_model->getFeild('meta_desc','content','id',$id);
	 $data['meta_keys'] = $this->auto_model->getFeild('meta_keys','content','id',$id);
	 
									
	 	
	 $this->layout->view('edit',$lay,$data); 
	 }
    }
	
	///// Delete menu //////////////////////////////////
	public function delete(){
		$id = $this->uri->segment(3);
		$delete = $this->cms_model->delete_cms($id);
		  
		  if($delete){
			$this->session->set_flashdata('succ_msg', 'Contents Deleted Successfully');
		  }else{
			$this->session->set_flashdata('error_msg', 'Unable to Delete');
		  }
		  redirect(base_url().'cms');
	}
	
	public function page($limit_from='')
	{
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "cms/page";
        $config["total_rows"] = $this->cms_model->record_count_cms();
        $config["per_page"] = 30;
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
        $data["links"] = $this->pagination->create_links();
	$data["page"]=$config["total_rows"];
		//$data($config['per_page'])=3;
        $data['list'] = $this->cms_model->getcontents($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
     
	public function change_cms_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->cms_model->updatecms($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'cms/page/');
	
	}

	
	public function run_query(){
		
		/* $q1 = "
CREATE TABLE `serv_payment_track` (
  `track_id` int(11) NOT NULL,
  `txn_id` varchar(100) NOT NULL,
  `api` varchar(100) NOT NULL,
  `status` enum('P','F','S') NOT NULL DEFAULT 'P' COMMENT 'P=Pending, F=Failed, S=Success'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$q2 = "ALTER TABLE `serv_payment_track` ADD PRIMARY KEY (`track_id`);";
  
		$q3 = "ALTER TABLE `serv_payment_track` MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT; ";

		$q4 = "CREATE TABLE `serv_project_description` (
  `id` int(11) NOT NULL,
  `project_id` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$q5 = "ALTER TABLE `serv_project_description` ADD PRIMARY KEY (`id`);";
		$q6 = "ALTER TABLE `serv_project_description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";

		$this->db->query($q1);
		$this->db->query($q2); 
		$this->db->query($q3);
		$this->db->query($q4);
		$this->db->query($q5);
		$this->db->query($q6); */
		
	}
    

}
