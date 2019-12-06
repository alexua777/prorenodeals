<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('categories_model');
        $this->load->library('form_validation');
        parent::__construct();
    }

    public function index() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->categories_model->getCats();

        $this->layout->view('list', $lay, $data);
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";


        if ($this->input->post()) {
			
			if(!empty($_FILES) && !empty($_FILES['userfile']['name'])){
				$image = '';
				$config['upload_path'] = '../assets/skill_image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				$uploaded = $this->upload->do_upload();
				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/skill_image/'.$image;
				$configs['create_thumb'] = TRUE;
				$configs['maintain_ratio'] = TRUE;
				$configs['width']	 = 174;
				$configs['height']	= 156;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if($rsz){
					$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
				}
			}else{
				$image='';
			}
			
            $this->form_validation->set_rules('cat_name', 'Name', 'required|is_unique[categories.cat_name]');
       /*     $this->form_validation->set_rules('arabic_cat_name', 'Arabic Name', 'required');
            $this->form_validation->set_rules('spanish_cat_name', 'Spanish Name', 'required');
            $this->form_validation->set_rules('swedish_cat_name', 'Swedish Name', 'required'); */
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                $post_data = $this->input->post();
				$post_data['image']=$image;
                $insert = $this->categories_model->add_category($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Category Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'categories/');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $this->uri->segment(3);
       $data['cat_id'] = $id;
		
        if ($this->input->post()) {
		
			if(!empty($_FILES) && !empty($_FILES['userfile']['name'])){
				$image = '';
				$config['upload_path'] = '../assets/skill_image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
			
				$this->load->library('upload', $config);
				if(! $this->upload->do_upload()){
					$this->session->set_flashdata('error_msg', strip_tags($this->upload->display_errors()));
					redirect(base_url() . 'categories/edit/'.$id);
				}
				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/skill_image/'.$image;
				$configs['create_thumb'] = TRUE;
				$configs['maintain_ratio'] = TRUE;
				$configs['width']	 = 174;
				$configs['height']	= 156;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if($rsz){
					$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
				} 
			}else{
				$image='';
			}
			
			$post_data = $this->input->post();
			$data['cat_id'] = $id = $post_data['cat_id'];
			$data['cat_name'] = $post['cat_name'] = $post_data['cat_name'];
			$data['arabic_cat_name'] = $post['arabic_cat_name'] = $post_data['arabic_cat_name'];
			$data['spanish_cat_name'] = $post['spanish_cat_name'] = $post_data['spanish_cat_name'];
			$data['swedish_cat_name'] = $post['swedish_cat_name'] = $post_data['swedish_cat_name'];
			$data['parent_id'] = $post['parent_id'] =  $post_data['parent_id'];
			$data['status'] = $post['status'] =  $post_data['status'];
			$data['icon_class'] = $post['icon_class'] =  $post_data['icon_class'];
			if($image!='')
			{
				$data['image'] = $post['image'] =  $image;
			}
			
			
            $this->form_validation->set_rules('cat_name', 'Name', 'required');
			/* $this->form_validation->set_rules('arabic_cat_name', 'Arabic Name', 'required');
            $this->form_validation->set_rules('spanish_cat_name', 'Spanish Name', 'required');
            $this->form_validation->set_rules('swedish_cat_name', 'Swedish Name', 'required'); */
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');	

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('edit', $lay,$data);
            } else {
				
                $update = $this->categories_model->update_category($post,$id);
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Category Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'categories');
            }
        } else {

            $data['cat_id'] = $id;
            $data['cat_name'] = $this->auto_model->getFeild('cat_name', 'categories', 'cat_id', $id);
            $data['arabic_cat_name'] = $this->auto_model->getFeild('arabic_cat_name', 'categories', 'cat_id', $id);
            $data['spanish_cat_name'] = $this->auto_model->getFeild('spanish_cat_name', 'categories', 'cat_id', $id);
            $data['swedish_cat_name'] = $this->auto_model->getFeild('swedish_cat_name', 'categories', 'cat_id', $id);
            $data['parent_id'] = $this->auto_model->getFeild('parent_id', 'categories', 'cat_id', $id);
            $data['icon_class'] = $this->auto_model->getFeild('icon_class', 'categories', 'cat_id', $id);
            $data['parent_name'] = $this->auto_model->getFeild('cat_name', 'categories', 'cat_id', $data['parent_id']);
            $data['status'] = $this->auto_model->getFeild('status', 'categories', 'cat_id', $id);
			$data['image'] = $this->auto_model->getFeild('image', 'categories', 'cat_id', $id);

            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->categories_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Category Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'categories');
    }
	public function deleteskill() {
        $id = $this->uri->segment(3);
		$cat_id=$this->auto_model->getFeild("cat_id","skills","id",$id);
        $delete = $this->categories_model->delete_skill($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Skill Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'categories/viewskill/'.$cat_id);
    }
	
	public function change_category_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->categories_model->updatecategory($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'categories');
	
	}
	
	public function change_category_show_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact_stat')
			$data['show_status'] = 'N';
		if($this->uri->segment(4) == 'act_stat')
			$data['show_status'] = 'Y';
		
		
		$update = $this->categories_model->updatecategory($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact_stat')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act_stat')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'categories');
	
	}
	
	public function change_skill_status()
	{
		$id = $this->uri->segment(3);
		$cat_id=$this->auto_model->getFeild("cat_id","skills","id",$id);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->categories_model->updateskill($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'categories/viewskill/'.$cat_id);
	
	}
	
	public function addskill($cat_id="") {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
		$data['cat_id']=$cat_id;

        if ($this->input->post()) {
            $this->form_validation->set_rules('skill_name', 'Skill Name', 'required');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('addskill', $lay, $data);
            } else {
                $post_data = $this->input->post();
				$post_data['cat_id']=$cat_id;
				/* $post_data['parent_id']='9999'; */
                $insert = $this->categories_model->add_skill($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Project Skill Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'categories/');
            }
        } else {
            $this->layout->view('addskill', $lay, $data);
        }
    }
	public function viewskill($cat_id="") {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
		$data['cat_id']=$cat_id;
        $data['list'] = $this->categories_model->getSkills($cat_id);

        $this->layout->view('skilllist', $lay, $data);
    }
	
	public function editskill($sid="") {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $sid;
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		
        if ($this->input->post()) {
		
			$post_data = $this->input->post();
			$id = $post_data['id'];
			$data['skill_name'] = $post['skill_name'] = $post_data['skill_name'];
			$data['cat_id'] = $post['cat_id'] =  $post_data['cat_id'];
			$data['status'] = $post['status'] =  $post_data['status'];
			
            $this->form_validation->set_rules('skill_name', 'Skill Name', 'required');
            $this->form_validation->set_rules('status', '', '');	

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('editskill', $lay,$data);
            } else {
                $update = $this->categories_model->updateskill($post,$id);
				
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Skill Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Skill to Update Successfully');
                }
                redirect(base_url() . 'categories/viewskill/'.$post_data['cat_id']);
            }
        } else {

            $data['id'] = $id;
            $data['skill_name'] = $this->auto_model->getFeild('skill_name', 'skills', 'id', $id);
            $data['cat_id'] = $this->auto_model->getFeild('cat_id', 'skills', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'skills', 'id', $id);

            $this->layout->view('editskill', $lay, $data);
        }
    }
	
	

}
