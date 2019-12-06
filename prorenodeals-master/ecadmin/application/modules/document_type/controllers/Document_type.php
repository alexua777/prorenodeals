<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document_type extends MX_Controller {

    //private $auto_model;

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('document_type_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url('document_type/list_record'));
       
    }

  
    public function list_record($limit_from = ''){
	$data['data'] = $this->auto_model->leftPannel();
	$srch = $this->input->get();
	$lay['lft'] = "inc/section_left";
		$config = array();
        $config["base_url"] = base_url('document_type/list_record');
        $config["total_rows"] =  $this->document_type_model->getList($srch, '', '', FALSE);
        $config["per_page"] = 30;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $page = ($limit_from) ? $limit_from : 0;
        $per_page = $config["per_page"];
        $start = 0;
        if ($page > 0)
        {
            for ($i = 1; $i < $page; $i++)
            {
                $start = $start + $per_page;
            }
        }
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
        
		$data['all_data'] = $this->document_type_model->getList($srch, $config['per_page'], $start);
		
		$this->layout->view('list', $lay, $data);
    }
    
	public function add(){
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('status', 'status', '');
			
			
			if($this->form_validation->run()){
				$post_data = $this->input->post();
				unset($post_data['submit']);
				
				$insert = $this->db->insert('document_type', $post_data);
				$insert_id = $this->db->insert_id();
				
				if ($insert_id) {
                    $this->session->set_flashdata('succ_msg', 'Data Added Successfully');
                }else  {
                    $this->session->set_flashdata('error_msg', 'Unable to Add Data');
                }
                redirect(base_url() . 'document_type/add/');
			
			}
		}
		
		$this->layout->view('add', $lay, $data);
	}
	
	public function edit($id=''){
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('status', 'status', '');
			
			if($this->form_validation->run()){
				$post_data = $this->input->post();
				unset($post_data['submit']);
				$update = $this->db->where('document_type_id', $id)->update('document_type', $post_data);
				
				if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Data Updated Successfully');
                }else  {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Data');
                }
                redirect(base_url() . 'document_type/list_record/');
			
			}
		}
		
		
		$data['all_data'] = $this->db->where('document_type_id', $id)->get('document_type')->row_array();
		
		$this->layout->view('edit', $lay, $data);
	}
	
	
	public function delete_plan($id=''){
		$del = $this->db->where('document_type_id', $id)->delete('document_type');
		
		if ($del) {
			$this->session->set_flashdata('succ_msg', 'Data Deleted Successfully');
		}else  {
			$this->session->set_flashdata('error_msg', 'Unable to Delete Data');
		}
		
		redirect(base_url() . 'document_type/list_record/');
	
	}
	
	
  
   

}
