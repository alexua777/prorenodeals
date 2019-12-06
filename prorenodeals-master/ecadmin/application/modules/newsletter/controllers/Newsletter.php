<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
  
class Newsletter extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('newsletter_model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('editor');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
    }
    public function index() {
	$data['data'] = $this->auto_model->leftPannel();	 	 
	 $lay['left']="inc/section_left";
	 $this->layout->view('list',$lay,$data);
    }
	
	
	
	
	/////////////// cms Add ///////////////////////////////////////////////
	public function add() {
	 $data['data'] = $this->auto_model->leftPannel();	 	 
	 $lay['left']="inc/section_left";
	 $data['overview'] = $this->editor->geteditor('overview','Full');
	 $data['responsiblity'] = $this->editor->geteditor('responsiblity','Full');
	 $data['qualification'] = $this->editor->geteditor('qualification','Full');
	 $data['extra'] = $this->editor->geteditor('extra','Full');
	 $data['compensation'] = $this->editor->geteditor('compensation','Full');
	 $data['contact'] = $this->editor->geteditor('contact','Full');
	
	 if($this->input->post()){
	 	$config['upload_path'] = '../assets/career_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);

		$uploaded = $this->upload->do_upload();
		$upload_data = $this->upload->data();
		//echo "<pre>";
		//print_r($upload_data);die;
		$image = $upload_data['file_name'];
		$configs['image_library'] = 'gd2';
		$configs['source_image']	= '../assets/career_image/'.$image;
		$configs['create_thumb'] = TRUE;
		$configs['maintain_ratio'] = TRUE;
		$configs['width']	 = 70;
		$configs['height']	= 55;
		$this->load->library('image_lib', $configs); 
		$rsz=$this->image_lib->resize();
		if($rsz)
		{
			$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
		}
		if (!$uploaded AND $docu != '') {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error_msg', $error['error']);
			redirect(base_url() . 'career/add/');
		}
		$this->form_validation->set_rules('position', 'Job Position', 'required');
		$this->form_validation->set_rules('overview', 'Overview', 'required');
		$this->form_validation->set_rules('responsiblity', 'Responsiblity', 'required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'required');
		$this->form_validation->set_rules('compensation', 'Compensation', 'required');
		$this->form_validation->set_rules('contact', 'Contact', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('add',$lay,$data); 
		}else{
		  $post_data = $this->input->post();
		  $post_data['image'] = $image;
		  $insert_country = $this->career_model->add($post_data);
		  
		  if($insert_country){
		  	$this->session->set_flashdata('succ_msg', 'Job Inserted Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable To Insert');
		  }
		  redirect(base_url().'career/page');
		}
	 	
	 }else{	
	  $this->layout->view('add',$lay,$data); 
	 }
	
    }
	
	
	//////////////edit country menu////////////////////
	public function edit() {
	
	 $data['data'] = $this->auto_model->leftPannel();	 
	 $lay['lft']="inc/section_left";
	 $data['coverview'] = $this->editor->geteditor('overview','Full');
	 $data['cresponsiblity'] = $this->editor->geteditor('responsiblity','Full');
	 $data['cqualification'] = $this->editor->geteditor('qualification','Full');
	 $data['cextra'] = $this->editor->geteditor('extra','Full');
	 $data['ccompensation'] = $this->editor->geteditor('compensation','Full');
	 $data['ccontact'] = $this->editor->geteditor('contact','Full');
	 
	 $id = $this->uri->segment(3);
	 if($id==''){
	 $id = set_value('id'); 
	 }
	 
	 $data['id'] = $id;
	 $data['position'] = $this->auto_model->getFeild('position','career','id',$id);
	 $data['image'] = $this->auto_model->getFeild('image','career','id',$id);
	 $data['overview'] = $this->auto_model->getFeild('overview','career','id',$id);
	 $data['responsiblity'] = $this->auto_model->getFeild('responsiblity','career','id',$id);
	 $data['status'] = $this->auto_model->getFeild('status','career','id',$id);
	 $data['qualification'] = $this->auto_model->getFeild('qualification','career','id',$id);
	 $data['extra'] = $this->auto_model->getFeild('extra','career','id',$id);
	 $data['compensation'] = $this->auto_model->getFeild('compensation','career','id',$id);
	 $data['contact'] = $this->auto_model->getFeild('contact','career','id',$id);
	 
	 if($this->input->post()){
	 	$image="";
		$config['upload_path'] = '../assets/career_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		
		$this->load->library('upload', $config);

		$uploaded = $this->upload->do_upload();
		$upload_data = $this->upload->data();
		//echo "<pre>";
		//print_r($upload_data);die;
		$image = $upload_data['file_name'];
		$configs['image_library'] = 'gd2';
		$configs['source_image']	= '../assets/career_image/'.$image;
		$configs['create_thumb'] = TRUE;
		$configs['maintain_ratio'] = TRUE;
		$configs['width']	 = 70;
		$configs['height']	= 55;
		$this->load->library('image_lib', $configs); 
		$rsz=$this->image_lib->resize();
		if($rsz)
		{
			$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
		}
		
	    $this->form_validation->set_rules('position', 'Job Position', 'required');
		$this->form_validation->set_rules('overview', 'Overview', 'required');
		$this->form_validation->set_rules('responsiblity', 'Responsiblity', 'required');
		$this->form_validation->set_rules('qualification', 'Qualification', 'required');
		$this->form_validation->set_rules('compensation', 'Compensation', 'required');
		$this->form_validation->set_rules('contact', 'Contact', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		
		if ($this->form_validation->run() == FALSE){
			 $this->layout->view('edit',$lay,$data); 
		}else{
		  $post_data['position'] = $this->input->post('position');
		  $post_data['overview'] = $this->input->post('overview');
		  $post_data['responsiblity'] = $this->input->post('responsiblity');
		  $post_data['qualification'] = $this->input->post('qualification');
		  $post_data['compensation'] = $this->input->post('compensation');
		  $post_data['contact'] = $this->input->post('contact');
		  $post_data['extra'] = $this->input->post('extra');
		  $post_data['status'] = $this->input->post('status');
		  $post_data['posted'] = date('Y-m-d');
		  if($image!='')
			{
				$post_data['image'] = $image;
				$img=explode(".",$this->input->post('currimg'));
				$nm=$img[0];
				$ext=end($img);
				$newnm=str_replace("_thumb", "", $nm);
				$newnm=$newnm.".".$ext;
				@unlink('../assets/career_image/'.$this->input->post('currimg'));
				@unlink('../assets/career_image/'.$newnm);
			}
		  $update = $this->career_model->updateCareer($post_data,$id);
		  
		  if($update){
		  	$this->session->set_flashdata('succ_msg', 'Jobs Updated Successfully');
		  }else{
		  	$this->session->set_flashdata('error_msg', 'Unable to Update');
		  }
		  redirect(base_url().'career/page');
		}
	 
	 }
	 else{
	 	$this->layout->view('edit',$lay,$data); 
	 }
    }
	
	///// Delete menu //////////////////////////////////
	public function delete(){
		$id = $this->uri->segment(3);
		$delete = $this->career_model->deleteCareer($id);
		  
		  if($delete){
			$this->session->set_flashdata('succ_msg', 'Job Deleted Successfully');
		  }else{
			$this->session->set_flashdata('error_msg', 'Unable to Delete');
		  }
		  redirect(base_url().'career');
	}
	
	public function page($limit_from='')
	{
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "career/page";
        $config["total_rows"] = $this->career_model->record_count_cms();
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
        $data['list'] = $this->career_model->getCareer($config['per_page'],$start);
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
		
		
		$update = $this->career_model->updateCareer($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'career/page/');
	
	}

    

}
