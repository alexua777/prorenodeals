<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonial extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('testimonial_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    $data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['all_data'] = $this->testimonial_model->getAllTestimonialList();
   		$this->layout->view('list', $lay, $data);
       
    }

	public function add()
	{
		
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['user']=$this->testimonial_model->getallUser();		
		if($this->input->post('submit'))
		{
            
            $this->form_validation->set_rules('user_id', 'User name', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {              
                $this->layout->view('add', $lay, $data);
            } else {
     
			   	$post_data['user_id'] = $this->input->post('user_id');
				$post_data['description'] = $this->input->post('description');
				$post_data['posted_date'] =date('Y-m-d');
                $post_data['status'] = $this->input->post('status');
              
                $insert_team = $this->testimonial_model->add($post_data);
               
                if ($insert_team) {
                    $this->session->set_flashdata('succ_msg', 'Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }
                redirect(base_url() . 'testimonial/add');
            }
        
		
		
		}
		else
		{
		
			$this->layout->view('add', $lay, $data);
		}
		
	}
	
	
	public function edit()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['user']=$this->testimonial_model->getallUser();		
		if($id)
		{
			$data['all_data'] = $this->testimonial_model->getAllTestimonialListbyId($id);
		
		}
		if($this->input->post('submit'))
		{
			
            $this->form_validation->set_rules('user_id', 'User Name', 'required');
			$this->form_validation->set_rules('description', 'User Feedback', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');



            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
				$new_data['user_id'] = $this->input->post('user_id');
				$new_data['description'] = $this->input->post('description');
				$new_data['status'] = $this->input->post('status');
				$post_data['id'] = $id;
			$update = $this->testimonial_model->updateTestimonial($new_data,$id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'testimonial/edit/'.$id);
			}
		
		
		}
		
		$this->layout->view('edit', $lay, $data);
		
	}
	
	
	
	
	
	public function change_status()
	{
		$id = $this->uri->segment(3);
		$type=$this->uri->segment(5);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
			
		if($this->uri->segment(4) == 'del')
		{
			$update = $this->testimonial_model->deleteTestimonial($id);	
		}
		else
		{
			$update = $this->testimonial_model->updateTestimonial($data,$id);
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
		redirect(base_url() . 'testimonial/');
		
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
	
	
	/*public function edit()
	{
		$id = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($id)
		{
			$data['all_data'] = $this->gallery_model->getAPerticulerFooterDataUsingId($id);
			$data['cat_data']= $this->gallery_model->getAllCategory($type);
			//echo "<pre>";
			//print_r($data);die;
		
		}
		if($this->input->post('submit'))
		{
			$config['upload_path'] = '../assets/gallery_image/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
			
            $this->load->library('upload', $config);

            $uploaded = $this->upload->do_upload();
            $upload_data = $this->upload->data();
            //echo "<pre>";
            //print_r($upload_data);die;
            $image = $upload_data['file_name'];
            $this->form_validation->set_rules('category', 'category', 'required');
            $this->form_validation->set_rules('gal_type', 'Gallery type', 'required');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
			$new_data['cat_id'] = $this->input->post('category');
			$gal_id =  $this->input->post('id');
			$type= $this->input->post('gal_type');
			$new_data['gal_type'] = $this->input->post('gal_type');
			if($image!='')
			{
				$new_data['image'] = $image;
			}
			$new_data['status'] = $this->input->post('status');
			
			$update = $this->gallery_model->updateGallery($new_data,$gal_id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'gallery/edit_gallery/'.$gal_id.'/'.$type.'/');
			}
		
		
		}
		
		$this->layout->view('edit', $lay, $data);
		
	}*/
	
	public function add_sub_footer()
	{
		$id = $this->uri->segment(3);
		if($id == '')
			$id = 0;
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
			//echo "<pre>";
			//print_r($data);die;
			
		
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
    

	

}
