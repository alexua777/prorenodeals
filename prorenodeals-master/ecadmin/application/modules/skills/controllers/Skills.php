<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Skills extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('skills_model');
        $this->load->library('form_validation');
        parent::__construct();
    }

    public function index() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->skills_model->getCats();

        $this->layout->view('list', $lay, $data);
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";


        if ($this->input->post()) {
			
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
			if($rsz)
			{
				$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			}
			if($this->input->post('parent_id')=="")
			{
            	$this->form_validation->set_rules('skill_name', 'Name', 'required|is_unique[skills.skill_name]');
			}
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                $post_data = $this->input->post();
				$post_data['image']=$image;
                $insert = $this->skills_model->add_skill($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Skill Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'skills/');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		
        if ($this->input->post()) {
			
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
			if($rsz)
			{
				$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			}
		
			$post_data = $this->input->post();
			$data['id'] = $id = $post_data['id'];
			$data['skill_name'] = $post['skill_name'] = $post_data['skill_name'];
			$data['arabic_skill_name'] = $post['arabic_skill_name'] = $post_data['arabic_skill_name'];
			$data['spanish_skill_name'] = $post['spanish_skill_name'] = $post_data['spanish_skill_name'];
			$data['swedish_skill_name'] = $post['swedish_skill_name'] = $post_data['swedish_skill_name'];
			$data['parent_id'] = $post['parent_id'] =  $post_data['parent_id'];
			//$data['parent_name'] = $post['parent_name'] =  $post_data['parent_name'];
			$data['status'] = $post['status'] =  $post_data['status'];
			if($image!='')
			{
				$data['image'] = $post['image'] =  $image;
			}
			
            $this->form_validation->set_rules('skill_name', 'Name', 'required');
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');	

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('edit', $lay,$data);
            } else {
				
                $update = $this->skills_model->update_category($post,$id);
				
                if ($update) {
					if($this->input->post('currimage'))
					{
						$curr_img=$this->input->post('currimage');
						$orig_img=str_replace('_thumb','',$curr_img);
						
					}
                    $this->session->set_flashdata('succ_msg', 'Skills Updated Successfully');
					
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'skills');
            }
        } else {

            $data['id'] = $id;
            $data['skill_name'] = $this->auto_model->getFeild('skill_name', 'skills', 'id', $id);
            $data['arabic_skill_name'] = $this->auto_model->getFeild('arabic_skill_name', 'skills', 'id', $id);
            $data['spanish_skill_name'] = $this->auto_model->getFeild('spanish_skill_name', 'skills', 'id', $id);
            $data['swedish_skill_name'] = $this->auto_model->getFeild('swedish_skill_name', 'skills', 'id', $id);
			$data['image'] = $this->auto_model->getFeild('image', 'skills', 'id', $id);
            $data['parent_id'] = $this->auto_model->getFeild('parent_id', 'skills', 'id', $id);
            $data['parent_name'] = $this->auto_model->getFeild('skill_name', 'skills', 'id', $data['parent_id']);
            $data['status'] = $this->auto_model->getFeild('status', 'skills', 'id', $id);

            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->skills_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Menu Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'skills');
    }
	
	public function change_skill_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->skills_model->updatecategory($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'skills');
	
	}
	
	
	
	

}
