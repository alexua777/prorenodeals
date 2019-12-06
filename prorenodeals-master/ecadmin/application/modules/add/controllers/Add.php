<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('add_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'add/page');
    }

    /////////////// Menu Add ///////////////////////////////////////////////
    public function add_advertise() {
		
		  
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        
        if ($this->input->post()) {
		    
            $this->form_validation->set_rules('page_name', 'Page name', 'required');
            $this->form_validation->set_rules('position', 'Position', 'required');
			if($this->input->post('type')=='A')
			{
				$this->form_validation->set_rules('advertise_code', 'Addvertise code', 'required');
			}
			else
			{
				$this->form_validation->set_rules('banner_url', 'url', 'required');
			}
			
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
				$image='';
				foreach ($this->input->post('page_name') as $selectedOption)
              	{
					foreach ($this->input->post('position') as $positionOption)
              		{
						if($image=='')
						{
							$config['upload_path'] = '../assets/ad_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg';
							$this->load->library('upload', $config);
							$uploaded = $this->upload->do_upload();
							$upload_data = $this->upload->data();
							
							$image = $upload_data['file_name'];
							$configs['image_library'] = 'gd2';
							$configs['source_image']	= '../assets/ad_image/'.$image;
							$configs['create_thumb'] = TRUE;
							$configs['maintain_ratio'] = TRUE;
							$configs['width']	 = 720;
							$configs['height']	= 90;
							$this->load->library('image_lib', $configs); 
							$rsz=$this->image_lib->resize();
							if($rsz)
							{
								$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
							}
							if (!$uploaded AND $image != '') {
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('error_msg', $error['error']);
								redirect(base_url() . 'add/add/');
							}
						}
						$post_data['page_name'] = $selectedOption;
						$post_data['type'] = $this->input->post('type');
						$post_data['advertise_code'] = $this->input->post('advertise_code');
						$post_data['banner_image'] = $image;
						$post_data['banner_url'] = prep_url($this->input->post('banner_url'));
						$post_data['add_pos'] = $positionOption;
						$post_data['add_date'] = date('Y-m-d');
						$post_data['status'] = $this->input->post('status');
						$check=$this->auto_model->getFeild('id','advartise','','',array('page_name'=>$selectedOption,'add_pos'=>$positionOption));
						if($check>0)
						{
							$insert=$this->add_model->update_banner($post_data,$check);	
						}
						else
						{
							$insert = $this->add_model->add_banner($post_data);	
						}
						
					}
                }
				if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Advertise Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'add/page');
		  }
		  

        } else {
            $this->layout->view('add', $lay, $data);
        }
    }
    
    public function get_banner_type_position($type)
    {
        $data['positions'] = $this->add_model->get_banner_position($type); 
        $this->layout->view("banner_type_position", "", $data, FALSE);
    }

    public function edit() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }

        if ($this->input->post()) {
						
			$this->form_validation->set_rules('type', 'Addvertise Type', 'required');
			if($this->input->post('type')=='A')
			{
				$this->form_validation->set_rules('advertise_code', 'Addvertise code', 'required');
			}
			else
			{
				$this->form_validation->set_rules('banner_url', 'url', 'required');
			}
			
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
				$image="";
				if($this->input->post('type')=='B')
				{
					
					$config['upload_path'] = '../assets/ad_image/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					
					$this->load->library('upload', $config);
		
					$uploaded = $this->upload->do_upload();
					$upload_data = $this->upload->data();
					$image = $upload_data['file_name'];
					$configs['image_library'] = 'gd2';
					$configs['source_image']	= '../assets/ad_image/'.$image;
					$configs['create_thumb'] = TRUE;
					$configs['maintain_ratio'] = TRUE;
					$configs['width']	 = 720;
					$configs['height']	= 90;
					$this->load->library('image_lib', $configs); 
					$rsz=$this->image_lib->resize();
					if($rsz)
					{
						$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
					}
					if($image!='')
					{
						$post_data['banner_image']=$image;
					}
					$post_data['banner_url'] = prep_url($this->input->post('banner_url'));
					$post_data['advertise_code'] = '';
				}
				else
				{
					$post_data['advertise_code'] = $this->input->post('advertise_code');
					$post_data['banner_image']=$image;
					$post_data['banner_url'] ='';	
				}
          
				$post_data['type'] = $this->input->post('type');
                
				
				
                $update = $this->add_model->update_banner($post_data,$id);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'advertise Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'add/page');
            }
        } else {
            $data['id'] = $id;
            $data['page_name'] = $this->auto_model->getFeild('page_name', 'advartise', 'id', $id);
            $data['position'] = $this->auto_model->getFeild('add_pos', 'advartise', 'id', $id);
			$data['type'] = $this->auto_model->getFeild('type', 'advartise', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'advartise', 'id', $id);
            $data['advertise_code'] = $this->auto_model->getFeild('advertise_code', 'advartise', 'id', $id);
			$data['banner_image'] = $this->auto_model->getFeild('banner_image', 'advartise', 'id', $id);
			$data['banner_url'] = $this->auto_model->getFeild('banner_url', 'advartise', 'id', $id);
            $data['add_date'] = $this->auto_model->getFeild('add_date', 'advartise', 'id', $id);
            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete() {
        $id = $this->uri->segment(3);
        $delete = $this->add_model->delete_banner($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'advertise Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'add/page');
    }

    public function page($limit_from = '') {
        $type = $this->uri->segment(3);
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "add/page";
        $config["total_rows"] = $this->add_model->record_count_banner();
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
        $data['all_data'] = $this->add_model->getbannerList($config['per_page'], $start);
        $this->layout->view('list', $lay, $data);
    }
	
    public function change_banner_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->add_model->updatebanner($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        $status = $this->uri->segment(5);
        redirect(base_url() . 'add/page/');
    }

    public function search_banner() {
        $type = $this->uri->segment(3);
        $data['data'] = $this->auto_model->leftPannel();
        //$data['list'] = $this->add_model->getbannerList($type);
        $lay['lft'] = "inc/section_left";
        if ($this->input->post('submit')) {
            $usr_select = $this->input->post('usr_select');
            $search_element = $this->input->post('search_element');
            $data['usr_select'] = $usr_select;
            $data['search_element'] = $search_element;
            if ($usr_select == '' || $search_element == '' || $usr_select == 'all') {
                if ($usr_select == 'all') {
                    $data['all_data'] = $this->add_model->getbannerList($type);
                    //echo "<pre>";
                    //print_r($data);die;
                    $this->layout->view('list', $lay, $data);
                }
                redirect(base_url() . 'add/page/' . $type);
            } else {


                if ($usr_select == 'type') {
                    $get_type = $this->auto_model->getFeild('id', 'banner', 'type', $search_element);
                    $data['all_data'] = $this->add_model->getAllSearchData('id', $get_type, $type);
                    $this->layout->view('list', $lay, $data);
                } else {
                    $data['all_data'] = $this->add_model->getAllSearchData($usr_select, $search_element, $type);


                    $this->layout->view('list', $lay, $data);
                }
            }
        }
    }

}
