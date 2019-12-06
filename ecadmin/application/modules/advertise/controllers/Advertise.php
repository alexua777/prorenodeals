<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advertise extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */	 
    public function __construct()
	{
        $this->load->model('advertise_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
      
	   redirect(base_url() .'advartise/page');
    }
    
    

    /////////////// Event Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['left'] = "inc/section_left";
	
        if ($this->input->post()) {
			
            $this->form_validation->set_rules('advertise_name', 'Advertise Name', 'required');
            $this->form_validation->set_rules('page_name', 'Page Name', 'required');
          
            //$this->form_validation->set_rules('add_pos', 'Add Position', 'required');
           
		   $this->form_validation->set_rules('advartise_description', 'Advertise Time', 'required');
          
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
				} else {
				$post_data['advertise_name']  		=  $this->input->post('advertise_name');
				$post_data['page_name'] 			=  $this->input->post('page_name');
				$post_data['advartise_description'] =  $this->input->post('advartise_description');
                $post_data['add_pos'] 				=  $this->input->post('add_pos');
			
				$image = '';
				$config['upload_path'] = '../assets/advertise_image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this->load->library('upload', $config);
				$uploaded = $this->upload->do_upload();
				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];

            if ($image!= '') {
				$post_data['advartise_image'] = $image;
			}
				
				$post_data['add_date'] = date('Y-m-d');
				
				
				
				$insert_event =  $this->advertise_model->add_advartise($post_data);
                
				if ($insert_event) {
                    $this->session->set_flashdata('succ_msg', 'Event Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert');
                }
                redirect(base_url() . 'advertise/add');
            }
        } 
        else {
            $this->layout->view('add', $lay, $data);
          }
    }

    //////////////edit state menu////////////////////
   
    
    
    public function edit()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
                
       		
		if($id)
		{
        $data['all_data'] =  $this->advertise_model->getAllevent($id);
		//$data['cat_data']= $this->advertise_model->getAllCategory('E');
		}
		if($this->input->post())
		{
				
			    $post_data['advertise_name']  		=  $this->input->post('advertise_name');
				$post_data['page_name'] 			=  $this->input->post('page_name');
				$post_data['advartise_description'] =  $this->input->post('advartise_description');
                $post_data['add_pos'] 				=  $this->input->post('add_pos');
			
				$image = '';
				$config['upload_path'] = '../assets/advertise_image/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this->load->library('upload', $config);
				$uploaded = $this->upload->do_upload();
				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];

				if ($image!= '') {
				
				$prevmage =  $this->auto_model->getFeild('advartise_image','advartise','id',$id);
				
				unlink('../assets/advertise_image/'.$prevmage);
				
				$post_data['advartise_image'] = $image;
				}
				
				$post_data['add_date'] = date('Y-m-d');
			  
			  $update = $this->advertise_model->updateevent($post_data,$id);
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Advertise Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update ');
                }
                redirect(base_url() . 'advertise/edit/'.$id);
            }
		
		
		
		
		$this->layout->view('edit', $lay, $data);
		
	}
    
        
        
     
   


        ///// Delete menu //////////////////////////////////
    public function delete_event() {
        $id = $this->uri->segment(3);
		
		$prevmage =  $this->auto_model->getFeild('advartise_image','advartise','id',$id);
		if($prevmage!=''){
		unlink('../assets/advertise_image/'.$prevmage);
		}
        $delete = $this->advertise_model->delete_event($id);
        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Event Deleted Successfully');
			} else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
			}
        redirect(base_url() . 'advertise/page');
    }

    
    public function record_count_event(){
        
        
    }

   public function page($limit_from = '') {
		
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url()."advartise/page";
        $config["total_rows"] = $this->advertise_model->record_count_event();
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
        if ($page > 0) {
            for ($i = 1; $i < $page; $i++) {
                $start = $start + $per_page;
            }
        }

        $data['data'] = $this->auto_model->leftPannel();
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
       
        $data['list'] = $this->advertise_model->getstate($config['per_page'], $start);
        
        $this->layout->view('list', $lay, $data);
    }

    public function change_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->advertise_model->updateevent($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        redirect(base_url() . 'advertise/page');
    }

}
