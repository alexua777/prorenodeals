<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bid_plan extends MX_Controller {

    //private $auto_model;

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('bid_plan_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url());
       
    }

  
    public function bid_plan_list($limit_from = ''){
	$data['data'] = $this->auto_model->leftPannel();
	$srch = $this->input->get();
	$lay['lft'] = "inc/section_left";
		$config = array();
        $config["base_url"] = base_url();
        $config["total_rows"] =  $this->bid_plan_model->getAllBidList($srch, '', '', FALSE);
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
        
		$data['all_data'] = $this->bid_plan_model->getAllBidList($srch, $config['per_page'], $start);
		
		$this->layout->view('list', $lay, $data);
    }
    
	public function add(){
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('plan_name', 'Name', 'required');
			$this->form_validation->set_rules('bids', 'No of Bids', 'required');
			$this->form_validation->set_rules('price', 'Plan Price', 'required');
			
			if($this->form_validation->run()){
				$post_data = $this->input->post();
				unset($post_data['submit']);
				
				$insert = $this->db->insert('bid_plan', $post_data);
				$insert_id = $this->db->insert_id();
				
				if ($insert_id) {
                    $this->session->set_flashdata('succ_msg', 'Data Added Successfully');
                }else  {
                    $this->session->set_flashdata('error_msg', 'Unable to Add Data');
                }
                redirect(base_url() . 'bid_plan/add/');
			
			}
		}
		
		$this->layout->view('add', $lay, $data);
	}
	
	public function edit($id=''){
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($this->input->post('submit')){
			$this->form_validation->set_rules('plan_name', 'Name', 'required');
			$this->form_validation->set_rules('bids', 'No of Bids', 'required');
			$this->form_validation->set_rules('price', 'Plan Price', 'required');
			
			if($this->form_validation->run()){
				$post_data = $this->input->post();
				unset($post_data['submit']);
				$update = $this->db->where('id', $id)->update('bid_plan', $post_data);
				
				if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Data Updated Successfully');
                }else  {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Data');
                }
                redirect(base_url() . 'bid_plan/bid_plan_list/');
			
			}
		}
		
		
		$data['all_data'] = $this->db->where('id', $id)->get('bid_plan')->row_array();
		
		$this->layout->view('edit', $lay, $data);
	}
	
	
	public function delete_plan($id=''){
		$del = $this->db->where('id', $id)->delete('bid_plan');
		
		if ($del) {
			$this->session->set_flashdata('succ_msg', 'Data Deleted Successfully');
		}else  {
			$this->session->set_flashdata('error_msg', 'Unable to Delete Data');
		}
		
		redirect(base_url() . 'bid_plan/bid_plan_list/');
	
	}
	
	
  
   

}
