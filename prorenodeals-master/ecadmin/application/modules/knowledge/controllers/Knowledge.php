<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Knowledge extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('knowledge_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        $this->load->library('editor');
        parent::__construct();
		$this->load->helper('url');
		$this->load->helper('ckeditor');
    }

    public function index() {
	    redirect (base_url());
       
    }

  
    public function knowledge_list($limit_from='') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		$this->load->library('pagination');
		$config['base_url'] = base_url().'knowledge/knowledge_list/';
		$config['total_rows'] =$this->db->get('knowledge')->num_rows();
		$config['per_page'] = 5; 
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
		$config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();		
		$data['cat']='';
		$data['category']=$this->knowledge_model->getCats();
		$data['all_data'] = $this->knowledge_model->getAllKnowledgeList($config['per_page'], $start);
		//$data['links']=$this->pagination->create_links();
   		$this->layout->view('list', $lay, $data);
		
	}
	
	public function add_knowledge()
	{
		$data['ckeditor'] = $this->editor->geteditor('knowledge_content','Full');
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['cat_data']= $this->knowledge_model->getCats();
		
		if($this->input->post('submit'))
		{
			
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('knowledge_type', 'Knowledge Type', 'required');
            $this->form_validation->set_rules('knowledge_content', 'Content', 'required');
	    $this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
            $this->form_validation->set_rules('meta_keys', 'Meta Keys', 'required');
            
            $this->form_validation->set_rules('order', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
                //$post_data = $this->input->post();
                $post_data['title'] = $this->input->post('title');
		$post_data['knowledge_type'] = $this->input->post('knowledge_type');
                $post_data['content'] = $this->input->post('knowledge_content');
                $post_data['meta_title'] = $this->input->post('meta_title');
                $post_data['meta_key'] = $this->input->post('meta_keys');
                $post_data['meta_description'] = $this->input->post('meta_description');
		$post_data['order'] = $this->input->post('order');
                $post_data['status'] = $this->input->post('status');
             
                $insert_faq = $this->knowledge_model->add_faq($post_data);
                
                if ($insert_faq) {
                    $this->session->set_flashdata('succ_msg', 'Knowledge Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'knowledge/add_knowledge/');
            }
        
		
		
		}
		else
		{
			$this->layout->view('add', $lay, $data);
		}
		
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
			$update = $this->knowledge_model->deleteKnowledge($id);	
		}
		else
		{
			$update = $this->knowledge_model->updateKnowledge($data,$id);
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
		redirect(base_url() . 'knowledge/knowledge_list/');
		
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
	
	
	public function edit_knowledge()
	{    
	
	    $data['ckeditor'] = $this->editor->geteditor('knowledge_content','Full');
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($id)
		{   
		    $data['cat_data']= $this->knowledge_model->getCats();
			$data['all_data'] = $this->knowledge_model->getAPerticulerFooterDataUsingId($id);
			//echo "<pre>";
			//print_r($data);die;
		
		}
		if($this->input->post('submit'))
		{
			//print_r($this->input->post());die();
            $this->form_validation->set_rules('title', 'Title', 'required');
	    $this->form_validation->set_rules('knowledge_type', 'Article', 'required');
            $this->form_validation->set_rules('knowledge_content', 'Content', 'required');
	    $this->form_validation->set_rules('meta_title', 'Meta Title', 'required');
            $this->form_validation->set_rules('meta_keys', 'Meta Keys', 'required');
            $this->form_validation->set_rules('order', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
			$new_data['title'] = $this->input->post('title');
			$new_data['knowledge_type'] = $this->input->post('knowledge_type');
			$new_data['content'] = $this->input->post('knowledge_content');
			$new_data['order'] = $this->input->post('order');
			$new_data['status'] = $this->input->post('status');
                        $new_data['meta_title'] = $this->input->post('meta_title');
                        $new_data['meta_key'] = $this->input->post('meta_keys');
                        $new_data['meta_description'] = $this->input->post('meta_description');
                        
                        
			$update = $this->knowledge_model->updateKnowledge($new_data,$id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'knowledge/edit_knowledge/'.$id.'/');
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
			//echo "<pre>";
			//print_r($data);die;
			
		
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
	
	/////////////////////////////Category Section///////////////////////////////////////
	public function category_list()
	{
		$data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->knowledge_model->getCats();

        $this->layout->view('category_list', $lay, $data);
	}
	
	public function add_category() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";


        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[faq_category.name]');
			$this->form_validation->set_rules('ord', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add_category', $lay, $data);
            } else {
                $post_data = $this->input->post();
                $insert = $this->knowledge_model->add_category($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'Category Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'knowledge/category_list');
            }
        } else {
            $this->layout->view('add_category', $lay, $data);
        }
    }

    public function edit_category() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		
        if ($this->input->post()) {
		
            $post_data = $this->input->post();
            $data['id'] = $id = $post_data['id'];
            $data['name'] = $post['name'] = $post_data['name'];
            $data['parent_id'] = $post['parent_id'] =  $post_data['parent_id'];
            $data['ord'] = $post['ord'] = $post_data['ord'];
            //$data['parent_name'] = $post['parent_name'] =  $post_data['parent_name'];
            $data['status'] = $post['status'] =  $post_data['status'];
			
            $this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('ord', 'Order', 'required');
            $this->form_validation->set_rules('status', '', '');
            $this->form_validation->set_rules('parent_id', '', '');	

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('edit_category', $lay,$data);
            } else {
                $update = $this->knowledge_model->update_category($post,$id);
				
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Menu Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'knowledge/category_list');
            }
        } else {

            $data['id'] = $id;
            $data['name'] = $this->auto_model->getFeild('name', 'knowledge_type', 'id', $id);
            $data['parent_id'] = $this->auto_model->getFeild('parent_id', 'knowledge_type', 'id', $id);
            $data['parent_name'] = $this->auto_model->getFeild('name', 'knowledge_type', 'id', $data['parent_id']);
			$data['ord'] = $this->auto_model->getFeild('ord', 'knowledge_type', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'knowledge_type', 'id', $id);

            $this->layout->view('edit_category', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete_category() {
        $id = $this->uri->segment(3);
        $delete = $this->knowledge_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Menu Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'knowledge/category_list');
    }
	
	public function change_category_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->knowledge_model->updatecategory($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'knowledge/category_list');
	
	}
	public function search_knowledge($limit_from='') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
			$srch = $this->input->get();
			if($srch['search_element']=='')
			{
				redirect(base_url().'knowledge/knowledge_list/');	
			}
			else
			{
				$data['cat']='';
				$qstn=$srch['search_element'];
				
				$data['srch'] = $srch;
				$this->load->library('pagination');
				$config['base_url'] = base_url().'knowledge/search_knowledge';
				$config['total_rows'] =$this->knowledge_model->countFaq($qstn);
				$config['per_page'] = 10; 
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
				$data['category']=$this->knowledge_model->getCats();
				$data['all_data'] = $this->knowledge_model->getfilterFaqList($qstn,$config['per_page'], $start);
				$data['links']=$this->pagination->create_links();
				$this->layout->view('list', $lay, $data);
			}
		
	}
    public function knowledge_cat($srch='',$limit_from='') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
			if($srch=='')
			{
				redirect(base_url().'knowledge/knowledge_list/');	
			}
			else
			{
				$data['cat']=$cat=$srch;
				$this->load->library('pagination');
				$config['base_url'] = base_url().'knowledge/knowledge_cat/'.$cat.'/';
				$config['total_rows'] =$this->knowledge_model->countcatFaq($cat);
				$config['per_page'] = 5; 
				$config["uri_segment"] = 4;
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
						$config["page"]  =	$config["per_page"];
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item last">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next'.' &gt;&gt;';
		$config['next_tag_open'] = '<li class="page-item xyz">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config);
        $data["links"] = 	$this->pagination->create_links();		
				$data['category']=$this->knowledge_model->getCats();
				$data['all_data'] = $this->knowledge_model->getcatFaqList($cat,$config['per_page'], $start);
				//$data['links']=$this->pagination->create_links();
				$this->layout->view('list', $lay, $data);
			}
		
	}

	

}
