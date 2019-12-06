<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banner extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('banner_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'banner/page');
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        if ($this->input->post()) 
		{
			//print_r($this->input->post()); die();
           
            
            /*$image = $upload_data['file_name'];
			$configs['image_library'] = 'gd2';
			$configs['source_image']	= '../assets/banner_image/'.$image;
			$configs['create_thumb'] = TRUE;
			$configs['maintain_ratio'] = TRUE;
			$configs['width']	 = 256;
			$configs['height']	= 256;
			$this->load->library('image_lib', $configs); 
			$rsz=$this->image_lib->resize();
			if($rsz)
			{
				$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			}*/
			
			//echo $image; die();
            
            $this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('url', 'URL', 'required|prep_url');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('display_for', 'display for', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } 
			else
			{	if($this->input->post('display_for') == 'D'){
					 $image = '';
					$config['upload_path'] = '../assets/banner_image/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->load->library('upload', $config);
					$uploaded = $this->upload->do_upload();
					$upload_data = $this->upload->data();
					
					//$image=$upload_data['raw_name'].$upload_data['file_ext'];
					
					$image = $upload_data['file_name'];
					$configs['image_library'] = 'gd2';
					$configs['source_image']	= '../assets/banner_image/'.$image;
					//$configs['create_thumb'] = TRUE;
					$configs['maintain_ratio'] = TRUE;
					$configs['width']	 = 1600;
					$configs['height']	= 720;
					$this->load->library('image_lib', $configs); 
					$rsz=$this->image_lib->resize();
					if($rsz)
					{
						$image=$upload_data['raw_name'].$upload_data['file_ext'];
					}
					
					if (!$uploaded AND $image == '') 
					{
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error_msg', $error['error']);
						redirect(base_url() . 'banner/add');
					}
			}else{
				 $image = '';
					$config['upload_path'] = '../assets/banner_image/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->load->library('upload', $config);
					$uploaded = $this->upload->do_upload();
					$upload_data = $this->upload->data();
					
					//$image=$upload_data['raw_name'].$upload_data['file_ext'];
					
					$image = $upload_data['file_name'];
					$configs['image_library'] = 'gd2';
					$configs['source_image']	= '../assets/banner_image/'.$image;
					//$configs['create_thumb'] = TRUE;
					$configs['maintain_ratio'] = TRUE;
					$configs['width']	 = 480;
					$configs['height']	= 360;
					$this->load->library('image_lib', $configs); 
					$rsz=$this->image_lib->resize();
					if($rsz)
					{
						$image=$upload_data['raw_name'].$upload_data['file_ext'];
					}
					
					if (!$uploaded AND $image == '') 
					{
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error_msg', $error['error']);
						redirect(base_url() . 'banner/add');
					}
				
			}
					
					$post_data['title'] = $this->input->post('title');
					$post_data['description'] = $this->input->post('description');
					$post_data['url'] = $this->input->post('url');
					$post_data['status'] = $this->input->post('status');
                    $post_data['image'] = $image;
                    $post_data['display_for'] = $this->input->post('display_for');
					
            

             $insert = $this->banner_model->add_banner($post_data);
             if ($insert) 
			 {
                    $this->session->set_flashdata('succ_msg', 'Banner Inserted Successfully');
              } else 
			  {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
              }
              redirect(base_url() . 'banner/page');
			 }
        }
        else 
		{
            $this->layout->view('add', $lay, $data);
        }
    }
    
    public function get_banner_type_position($type)
    {
        $data['positions'] = $this->banner_model->get_banner_position($type); 
        $this->layout->view("banner_type_position", "", $data, FALSE);
    }

    public function edit() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
			$data['id'] = $id;
            $data['image'] = $this->auto_model->getFeild('image', 'banner', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'banner', 'id', $id);
            $data['title'] = $this->auto_model->getFeild('title', 'banner', 'id', $id);
			$data['url'] = $this->auto_model->getFeild('url', 'banner', 'id', $id);
			$data['description'] = $this->auto_model->getFeild('description', 'banner', 'id', $id);
			$data['display_for'] = $this->auto_model->getFeild('display_for', 'banner', 'id', $id);
        if ($this->input->post()) {
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('url', 'URL', 'required|prep_url');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
				if($_FILES['userfile'] && $_FILES['userfile']['tmp_name']){
				if($this->input->post('display_for') == 'D'){
                $image = '';
                $config['upload_path'] = '../assets/banner_image/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                $uploaded = $this->upload->do_upload();
                $upload_data = $this->upload->data();

                $image = $upload_data['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/banner_image/'.$image;
				//$configs['create_thumb'] = TRUE;
				$configs['maintain_ratio'] = TRUE;
				$configs['width']	 = 1600;
				$configs['height']	= 720;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if($rsz)
				{
					$image=$upload_data['raw_name'].$upload_data['file_ext'];
				}

                if (!$uploaded AND $image != '') {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error_msg', $error['error']);
                    redirect(base_url() . 'banner/edit/' . $this->input->post('id'));
                }
			}else{
				$image = '';
					$config['upload_path'] = '../assets/banner_image/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$this->load->library('upload', $config);
					$uploaded = $this->upload->do_upload();
					$upload_data = $this->upload->data();
					$image = $upload_data['file_name'];
					$configs['image_library'] = 'gd2';
					$configs['source_image']	= '../assets/banner_image/'.$image;
					//$configs['create_thumb'] = TRUE;
					$configs['maintain_ratio'] = TRUE;
					$configs['width']	 = 480;
					$configs['height']	= 360;
					$this->load->library('image_lib', $configs); 
					$rsz=$this->image_lib->resize();
					if($rsz)

					{
						$image=$upload_data['raw_name'].$upload_data['file_ext'];
					}
					if (!$uploaded AND $image == '') 
					{
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error_msg', $error['error']);
						redirect(base_url() . 'banner/edit/' . $this->input->post('id'));
					}
					}
				}
				$id=$this->input->post('id');
                if (isset($image) AND $image != '') {
                    $post_data['image'] = $image;
                }
				$post_data['title'] = $this->input->post('title');
				$post_data['description'] = $this->input->post('description');
				$post_data['url'] = $this->input->post('url');
				$post_data['status'] = $this->input->post('status');
				$post_data['display_for'] = $this->input->post('display_for');
                $update = $this->banner_model->update_banner($post_data,$id);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Banner Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'banner/page');
            }
        } else {
            $data['id'] = $id;
            $data['image'] = $this->auto_model->getFeild('image', 'banner', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'banner', 'id', $id);
            $data['title'] = $this->auto_model->getFeild('title', 'banner', 'id', $id);
			$data['description'] = $this->auto_model->getFeild('description', 'banner', 'id', $id);
			$data['url'] = $this->auto_model->getFeild('url', 'banner', 'id', $id);
            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->banner_model->delete_banner($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Banner Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'banner/page');
    }

    public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "banner/page";
        $config["total_rows"] = $this->banner_model->record_count_banner();
        $config["per_page"] = 30;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }

        $data['data'] = $this->auto_model->leftPannel();
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["total_rows"];
        $data['all_data'] = $this->banner_model->getbannerList($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }

    public function change_banner_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->banner_model->update_banner($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'banner/page/');
    }

    public function search_banner() {
        $type = $this->uri->segment(3);
        $data['data'] = $this->auto_model->leftPannel();
        //$data['list'] = $this->banner_model->getbannerList($type);
        $lay['lft'] = "inc/section_left";
        if ($this->input->post('submit')) {
            $usr_select = $this->input->post('usr_select');
            $search_element = $this->input->post('search_element');
            $data['usr_select'] = $usr_select;
            $data['search_element'] = $search_element;
            if ($usr_select == '' || $search_element == '' || $usr_select == 'all') {
                if ($usr_select == 'all') {
                    $data['all_data'] = $this->banner_model->getbannerList($type);
                    //echo "<pre>";
                    //print_r($data);die;
                    $this->layout->view('list', $lay, $data);
                }
                redirect(base_url() . 'banner/page/' . $type);
            } else {


                if ($usr_select == 'type') {
                    $get_type = $this->auto_model->getFeild('id', 'banner', 'type', $search_element);
                    $data['all_data'] = $this->banner_model->getAllSearchData('id', $get_type, $type);
                    $this->layout->view('list', $lay, $data);
                } else {
                    $data['all_data'] = $this->banner_model->getAllSearchData($usr_select, $search_element, $type);


                    $this->layout->view('list', $lay, $data);
                }
            }
        }
    }

}
