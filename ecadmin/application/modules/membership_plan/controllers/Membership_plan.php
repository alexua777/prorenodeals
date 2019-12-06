<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membership_plan extends MX_Controller {

    //private $auto_model;

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('membership_plan_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url());
       
    }

  
    public function membership_plan_list($limit_from = '')
    {
	$data['data'] = $this->auto_model->leftPannel();
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url();
        $config["total_rows"] = $this->membership_plan_model->record_count_member();
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
        //$data($config['per_page'])=3;
		$data['all_data'] = $this->membership_plan_model->getAllMembershipList($config['per_page'], $start);
   		$this->layout->view('list', $lay, $data);
    }
           
 	
    public function add_membership_plan()
     {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		//$data['company']=$this->membership_plan_model->getCompany();		
		if($this->input->post('submit'))
		{
                    $this->form_validation->set_rules('name', 'Name', 'required');
                    $this->form_validation->set_rules('bids', 'No of Bids', 'required');
                    $this->form_validation->set_rules('skills', 'No of Skill', 'required');
                    $this->form_validation->set_rules('portfolio', 'No of Portfolio', 'required');
                    $this->form_validation->set_rules('price', 'Plan Price', 'required');
                    $this->form_validation->set_rules('days', 'Days', 'required');
                    $this->form_validation->set_rules('status', 'Status', 'required');
            if ($this->form_validation->run() == FALSE) 
            {
                $this->layout->view('add', $lay, $data);
            } 
            else 
            {
				$image = '';
				$config['upload_path'] = '../assets/plan_icon/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				$uploaded = $this->upload->do_upload();
				$upload_data = $this->upload->data();
				
				//$image=$upload_data['raw_name'].$upload_data['file_ext'];
				
				$image = $upload_data['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/plan_icon/'.$image;
				$configs['create_thumb'] = TRUE;
				$configs['maintain_ratio'] = TRUE;
				$configs['width']	 = 100;
				$configs['height']	= 100;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if($rsz)
				{
					$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
				}
				
				if (!$uploaded AND $image == '') 
				{
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error_msg', $error['error']);
					redirect(base_url() . 'membership_plan/add_membership_plan/');
				}
				
                $post_data['name'] = $this->input->post('name');
				$post_data['bids'] =$this->input->post('bids');
				$post_data['skills'] =$this->input->post('skills');
				$post_data['portfolio'] =$this->input->post('portfolio');
				$post_data['price'] =$this->input->post('price');
				$post_data['days'] =$this->input->post('days');
				$post_data['status'] =$this->input->post('status');
				$post_data['icon'] =$image;
                $insert_membership = $this->membership_plan_model->add_membership($post_data);
                if ($insert_membership)
                {
                    $this->session->set_flashdata('succ_msg', 'Data Added Successfully');
                }
                
                else 
                {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }
                 redirect(base_url() . 'membership_plan/add_membership_plan/');
            }
		}
		
		$this->layout->view('add', $lay, $data);
	}
	
    public function change_status()
	{
		$id = $this->uri->segment(3);
		//$type=$this->uri->segment(5);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
			
		if($this->uri->segment(4) == 'del')
		{
			$update = $this->membership_plan_model->deleteMembership($id);	
		}
		else
		{
			$update = $this->membership_plan_model->updateMembership($data,$id);
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
		redirect(base_url() . 'membership_plan/membership_plan_list/');
		
	}
        
        
    public function change_default()
	{
		$id = $this->uri->segment(3);
		
		if($this->uri->segment(4) == 'inact')
			$data['default_plan'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['default_plan'] = 'Y';
			
		if($this->uri->segment(4) == 'del')
		{
			$update = $this->membership_plan_model->deleteMembership($id);	
		}
		else{
                    
                    $cdp=  $this->auto_model->getFeild("id","membership_plan","default_plan","Y");
                    $data2['default_plan'] = 'N';
                    $update = $this->membership_plan_model->updateDefaultPal($data2,$cdp);
                    
			$update = $this->membership_plan_model->updateDefaultPal($data,$id);
		}
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Default Plan Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', ' Default Plan Activation Successfully Done...');
			if($this->uri->segment(4) == 'del')
				$this->session->set_flashdata('succ_msg', 'Deletion Successfully Done...');
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		redirect(base_url() . 'membership_plan/membership_plan_list/');
		
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
	
        
        public function edit_membership()
	{
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		//$data['company']=$this->membership_plan_model->getCompany();	
		
		if($id)
		{
			$data['all_data'] = $this->membership_plan_model->getAPerticulerFooterDataUsingId($id);
			//echo "<pre>";
			//print_r($data);die;
		
		}
		if($this->input->post('submit'))
		{
			//print_r($this->input->post());die();
                    
                    $this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('project', 'No of Project', 'required|numeric');
                    $this->form_validation->set_rules('bids', 'No of Bids', 'required|numeric');
                    $this->form_validation->set_rules('skills', 'No of Skill', 'required|numeric');
                    $this->form_validation->set_rules('portfolio', 'No of Portfolio', 'required|numeric');
                    $this->form_validation->set_rules('price', 'Plan Price', 'required|numeric');
					$this->form_validation->set_rules('bidwin_charge', 'Bidwin charge', 'required|numeric');
                    $this->form_validation->set_rules('days', 'Days', 'required');
                    $this->form_validation->set_rules('status', 'Status', 'required');

                    if ($this->form_validation->run() == FALSE)
                    {
                        $this->layout->view('edit', $lay, $data);
                    }
                    else
                    {
                $image = '';
                $config['upload_path'] = '../assets/plan_icon/';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->load->library('upload', $config);

                $uploaded = $this->upload->do_upload();
                $upload_data = $this->upload->data();

                $image = $upload_data['file_name'];
				$configs['image_library'] = 'gd2';
				$configs['source_image']	= '../assets/plan_icon/'.$image;
				$configs['create_thumb'] = TRUE;
				$configs['maintain_ratio'] = TRUE;
				$configs['width']	 = 100;
				$configs['height']	= 100;
				$this->load->library('image_lib', $configs); 
				$rsz=$this->image_lib->resize();
				if($rsz)
				{
					$image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
				}

                if (!$uploaded AND $image != '') {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error_msg', $error['error']);
                    redirect(base_url() . 'membership_plan/membership_plan_list/'.$id.'/');
                }

                if (isset($image) AND $image != '') {
                    $post_data['icon'] = $image;
                }
				
			$post_data['name'] = $this->input->post('name');
			$post_data['project'] = $this->input->post('project');
			$post_data['bids'] =$this->input->post('bids');
			$post_data['skills'] =$this->input->post('skills');
			$post_data['portfolio'] =$this->input->post('portfolio');
			$post_data['price'] =$this->input->post('price');
			$post_data['bidwin_charge'] =$this->input->post('bidwin_charge');
			$post_data['days'] =$this->input->post('days');
			$post_data['status'] =$this->input->post('status');
							
			$update = $this->membership_plan_model->updateMembership($post_data,$id);
			if ($update)
                        {
                            $this->session->set_flashdata('succ_msg', 'Update Successfully');
			}
                        else
                        {
                            $this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'membership_plan/membership_plan_list/'.$id.'/');
                    }
		
		
		}
		else
		{
		
			$this->layout->view('edit', $lay, $data);
		}
		
	}
	
    public function add_sub_footer()
	{
		$id = $this->uri->segment(3);
		if($id == '')
                {
			$id = 0;
                }
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
        
        
	public function generatechkCSV()
	{
            $this->load->database();
            $query = $this->db->get('varify_record');
            $this->load->helper('csv');	
            query_to_csv($query, TRUE, 'Checked_Product_list_'.date("dMy").'.csv');
	}        
	
	public function getprod()
	{
		$data['data'] = $this->auto_model->leftPannel();
		//$lay['lft'] = "inc/section_left";
		$cat=$this->uri->segment(3);
		if($cat!='')
		{
		$data['all_data']= $this->membership_plan_model->getProd($cat);
		}
		else
		{
		$data['all_data'] = $this->membership_plan_model->getAllMembershipList();
		}
		$this->layout->view('ajax_product', '', $data, '', 'N');		
	}
        
	public function getchkprod()
	{
		$data['data'] = $this->auto_model->leftPannel();
		
		$cat=$this->uri->segment(3);
		if($cat!='')
		{
		  $data['all_data']= $this->membership_plan_model->getchkProd($cat);
		}
		else
		{
		  $data['all_data'] = $this->membership_plan_model->getAllCheckList();
		}
		$this->layout->view('ajax_chkproduct', '', $data, '', 'N');		
	}        
        
    

	

}
