<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('event_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
        redirect(base_url() . 'event/page');
    }
    
    

    /////////////// Event Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['left'] = "inc/section_left";
	
        if ($this->input->post()) {
			
            $this->form_validation->set_rules('event_name', 'Event Name', 'required|xss_clean|max_length[100]');
            $this->form_validation->set_rules('event_desc', 'Event Description', 'required');
          
            $this->form_validation->set_rules('start_date', 'Start Time', 'required');
            $this->form_validation->set_rules('end_date', 'End Time', 'required');
          
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
               //$post_data = $this->input->post();
			  
				$post_data['event_name']  = $this->input->post('event_name');
				$post_data['event_desc'] = htmlentities($this->input->post('event_desc'));
				$start_date = $this->input->post('start_date');
				$end_date = $this->input->post('end_date');
				$post_data['start_date'] = $start_date;
				$post_data['end_date'] = $end_date;
				$post_data['created'] = date('Y-m-d');
                            
                $insert_event = $this->event_model->add_event($post_data);
                if ($insert_event) {
                    $this->session->set_flashdata('succ_msg', 'Event Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert');
                }
                redirect(base_url() . 'event/add');
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
            $data['all_data'] =  $this->event_model->getAllevent($id);
			//$data['cat_data']= $this->event_model->getAllCategory('E');
		}
		if($this->input->post())
		{
				
			    $post_data['event_name']  = $this->input->post('event_name');
				$post_data['event_desc'] = $this->input->post('event_desc');
				
				$start_date = $this->input->post('start_date');
				$end_date = $this->input->post('end_date');
				$post_data['start_date'] = $start_date;
				$post_data['end_date'] = $end_date;
				
				$post_data['created'] = date('Y-m-d');
				$post_data['event_id'] = $id;
			
			  $update = $this->event_model->updateevent($post_data,$id);
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Event Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update ');
                }
                redirect(base_url() . 'event/edit/'.$id);
            }
		
		
		
		
		$this->layout->view('edit', $lay, $data);
		
	}
    
        
        
     
   


        ///// Delete menu //////////////////////////////////
    public function delete_event() {
        $id = $this->uri->segment(3);
        $delete = $this->event_model->delete_event($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Event Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
        }
        redirect(base_url() . 'event/page');
    }

    
    public function record_count_event(){
        
        
    }

        public function page($limit_from = '') {
        $lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "event/page";
        $config["total_rows"] = $this->event_model->record_count_event();
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
        //$data($config['per_page'])=3;
        $data['list'] = $this->event_model->getstate($config['per_page'], $start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }

    public function change_status() {
        $id = $this->uri->segment(3);
        if ($this->uri->segment(4) == 'inact')
            $data['status'] = 'N';
        if ($this->uri->segment(4) == 'act')
            $data['status'] = 'Y';


        $update = $this->event_model->updateevent($data, $id);

        if ($update) {
            if ($this->uri->segment(4) == 'inact')
                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
            if ($this->uri->segment(4) == 'act')
                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
        } else {
            $this->session->set_flashdata('error_msg', 'unable to update');
        }
        redirect(base_url() . 'event/page');
    }

}
