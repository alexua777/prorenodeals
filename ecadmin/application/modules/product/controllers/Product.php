<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('product_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url());
       
    }

  
    public function product_list($limit_from = '') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url();
        $config["total_rows"] = $this->product_model->record_count_member();
        $config["per_page"] = 30;
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
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
        //$data($config['per_page'])=3;
		$data['all_data'] = $this->product_model->getAllProductList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
	}
        
        

    public function check_product_list($limit_from = '') {
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url();
        $config["total_rows"] = $this->product_model->record_count_member();
        $config["per_page"] = 30;
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
        $data["links"] = $this->pagination->create_links();
        $data["page"] = $config["per_page"];
        //$data($config['per_page'])=3;
		$data['all_data'] = $this->product_model->getAllProductList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
	}        
        
        
        
        
	
	public function add_product()
	{
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['company']=$this->product_model->getCompany();		
		if($this->input->post('submit'))
		{			
            $this->form_validation->set_rules('name', 'Product Name', 'required');
            $this->form_validation->set_rules('company', 'Company Name', 'required');
			$this->form_validation->set_rules('batch', 'Model/batch No', 'required');
			$this->form_validation->set_rules('product_no', 'Product No', 'required|is_unique[product.product_no]');
			$this->form_validation->set_rules('mdate', 'Manufacture Date', 'required');
			$this->form_validation->set_rules('edate', 'Expire Date', 'required');
			$this->form_validation->set_rules('company', 'Company Name', 'required');
			$this->form_validation->set_rules('nafdac', 'NAFDAC No', 'required');
			$this->form_validation->set_rules('phone', 'Contact Number', 'required|numeric|min_length[10]');
			$this->form_validation->set_rules('email', 'Email Id', 'required|valid_email');
            $this->form_validation->set_rules('status', 'Status', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
				$post_data['product_name'] = $this->input->post('name');
				$post_data['comp_id'] =$this->input->post('company');
				$post_data['model_no'] =$this->input->post('batch');
				$post_data['product_no'] =$this->input->post('product_no');
				$post_data['manufacture_date'] =$this->input->post('mdate');
				$post_data['expire_date'] =$this->input->post('edate');
				$post_data['nafdac_no'] =$this->input->post('nafdac');
				$post_data['phone'] =$this->input->post('phone');
				$post_data['email'] =$this->input->post('email');
				$post_data['status'] = $this->input->post('status');
                $insert_company = $this->product_model->add_product($post_data);
                if ($insert_company) {
                    $this->session->set_flashdata('succ_msg', 'Product Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }
                 redirect(base_url() . 'product/add_product/');
            }
		}
		
		$this->layout->view('add', $lay, $data);
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
			$update = $this->product_model->deleteProduct($id);	
		}
		else
		{
			$update = $this->product_model->updateProduct($data,$id);
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
		redirect(base_url() . 'product/product_list/');
		
	}
	
	public function get_category()
	{
		$id = $this->uri->segment(3);
		$data['get_cat_list'] = $this->listing_model->getCatList($id);
		//print_r($data);die;
		$this->layout->view('get_category_list','', $data);
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
	
	
	public function edit_product()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['company']=$this->product_model->getCompany();	
		
		if($id)
		{
			$data['all_data'] = $this->product_model->getAPerticulerFooterDataUsingId($id);
			//echo "<pre>";
			//print_r($data);die;
		
		}
		if($this->input->post('submit'))
		{
            $this->form_validation->set_rules('name', 'Product Name', 'required');
            $this->form_validation->set_rules('company', 'Company Name', 'required');
			$this->form_validation->set_rules('batch', 'Model/batch No', 'required');
			$this->form_validation->set_rules('mdate', 'Manufacture Date', 'required');
			$this->form_validation->set_rules('edate', 'Expire Date', 'required');
			$this->form_validation->set_rules('company', 'Company Name', 'required');
			$this->form_validation->set_rules('nafdac', 'NAFDAC NO', 'required');
			$this->form_validation->set_rules('phone', 'Contact Number', 'required|numeric|min_length[10]');
			$this->form_validation->set_rules('email', 'Email Id', 'required|valid_email');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
				$post_data['product_name'] = $this->input->post('name');
				$post_data['comp_id'] =$this->input->post('company');
				$post_data['model_no'] =$this->input->post('batch');
				$post_data['manufacture_date'] =$this->input->post('mdate');
				$post_data['expire_date'] =$this->input->post('edate');
				$post_data['nafdac_no'] =$this->input->post('nafdac');
				$post_data['phone'] =$this->input->post('phone');
				$post_data['email'] =$this->input->post('email');
				$post_data['status'] = $this->input->post('status');
			
			$update = $this->product_model->updateProduct($post_data,$id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'product/edit_product/'.$id.'/');
			}
		
		
		}
		
		$this->layout->view('edit', $lay, $data);
		
	}
	
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
	public function generateCSV()
	{
            $this->load->database();
            $query = $this->db->get('product');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Product_list_'.date("dMy").'.csv');
	}
	
	public function getprod()
	{
		$data['data'] = $this->auto_model->leftPannel();
		//$lay['lft'] = "inc/section_left";
		$cat=$this->uri->segment(3);
		if($cat!='')
		{
		$data['all_data']= $this->product_model->getProd($cat);
		}
		else
		{
		$data['all_data'] = $this->product_model->getAllProductList();
		}
		$this->layout->view('ajax_product', '', $data, '', 'N');
		//return $data['gallery'];
	}
    

	

}
