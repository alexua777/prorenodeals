<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminuser extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('adminuser_model');
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

  
    public function user_list($limit_from='') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$this->load->library('pagination');
		$config['base_url'] = base_url().'adminuser/user_list/';
		$config['total_rows'] =$this->db->get('admin')->num_rows();
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
		$data['all_data'] = $this->adminuser_model->getAllUserList($config['per_page'], $start);
		$data['links']=$this->pagination->create_links();
   		$this->layout->view('list', $lay, $data);
		
	}
	
	public function add_user()
	{
		$data['ckeditor'] = $this->editor->geteditor('knowledge_content','Full');
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		$data['type_data']= $this->adminuser_model->getCats();
		
		if($this->input->post('submit'))
		{
			
            $this->form_validation->set_rules('username', 'username', 'required|is_unique[admin.username]');
            $this->form_validation->set_rules('user_type', 'user type', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
	    	$this->form_validation->set_rules('password', 'password', 'required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'confirm password', 'required|min_length[5]');
            
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add', $lay, $data);
            } else {
				
				$config['upload_path']          = './admin_images/';
				$config['allowed_types']        = 'gif|jpg|png';
				$config['encrypt_name']        = TRUE;
	
				if(!empty($_FILES['image'])){
					if(!is_dir('./admin_images')){
						mkdir('./admin_images', 0777);
					}
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('image')){

					}else{
						$upload_data = $this->upload->data();
						$post_data['image'] = $upload_data['file_name'];
					}
				}
			
                //$post_data = $this->input->post();
                $post_data['username'] = $this->input->post('username');
				$post_data['type'] = $this->input->post('user_type');
                $post_data['email'] = $this->input->post('email');
                $post_data['name'] = $this->input->post('name');
                $post_data['password']= md5($this->input->post('password'));
                		
                $post_data['status'] = $this->input->post('status');
             
                $insert_faq = $this->adminuser_model->add_user($post_data);
                
                if ($insert_faq) {
                    $this->session->set_flashdata('succ_msg', 'User Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'adminuser/add_user/');
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
			$update = $this->adminuser_model->deleteUser($id);	
		}
		else
		{
			$update = $this->adminuser_model->updateUser($data,$id);
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
		redirect(base_url() . 'adminuser/user_list/');
		
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
	
	
	public function edit_user()
	{    
	
	    $data['ckeditor'] = $this->editor->geteditor('knowledge_content','Full');
		$id = $this->uri->segment(3);
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
		if($id)
		{   
		    $data['type_data']= $this->adminuser_model->getCats();
			$data['all_data'] = $this->adminuser_model->getAPerticulerFooterDataUsingId($id);
			
		
		}
		if($this->input->post('submit'))
		{
			//print_r($this->input->post());die();
            $this->form_validation->set_rules('username', 'username', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('user_type', 'user type', 'required');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {
			
			$config['upload_path']          = './admin_images/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['encrypt_name']        = TRUE;
			//print_r($_FILES); die;
			if(!empty($_FILES['image'])){
				if(!is_dir('./admin_images')){
					mkdir('./admin_images', 0777);
				}
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('image')){

				}else{
					$upload_data = $this->upload->data();
					$new_data['image'] = $upload_data['file_name'];
				}
			}
			
			$new_data['username'] = $this->input->post('username');
			$new_data['name'] = $this->input->post('name');
			$new_data['type'] = $this->input->post('user_type');
			$new_data['email'] = $this->input->post('email');
			$new_data['status'] = $this->input->post('status');
                        
                        
			$update = $this->adminuser_model->updateUser($new_data,$id);
			if ($update) {
				$this->session->set_flashdata('succ_msg', 'Update Successfully');
			} else {
				$this->session->set_flashdata('error_msg', 'unable to Update');
			}
			redirect(base_url() . 'adminuser/edit_user/'.$id.'/');
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
	public function type_list()
	{
		$data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->adminuser_model->getCats();

        $this->layout->view('category_list', $lay, $data);
	}
	
	public function add_type() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
		$data['leftmenu']=$this->adminuser_model->getleftmenu();
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'required|is_unique[adminuser_type.name]');
            $this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('user_perm', 'Menu permission', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('add_category', $lay, $data);
            } else {
				$menus="";
                    foreach($this->input->post("user_perm") as $key => $val){  
                      $menus.=$val.",";
                   }

                   $menus= rtrim($menus,",");
				$post_data['menus']=$menus;   
                $post_data['name'] = $this->input->post('name');
				$post_data['status'] = $this->input->post('status');
                $insert = $this->adminuser_model->add_category($post_data);

                if ($insert) {
                    $this->session->set_flashdata('succ_msg', 'User Type Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');
                }
                redirect(base_url() . 'adminuser/type_list');
            }
        } else {
            $this->layout->view('add_category', $lay, $data);
        }
    }

    public function edit_type() {

        $data['data'] = $this->auto_model->leftPannel();
        $lay['lft'] = "inc/section_left";
		$data['leftmenu']=$this->adminuser_model->getleftmenu();
		
        $id = $this->uri->segment(3);
        if ($id == '' OR $id == 0) {
            $id = set_value('id');
        }
		$data['id'] = $id;
        if ($this->input->post()) {
		
            $post_data = $this->input->post();
            $data['id'] = $id = $post_data['id'];
            $data['name'] = $post['name'] = $post_data['name'];
            $data['status'] = $post['status'] =  $post_data['status'];		
			
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('user_perm[]', 'Menu permission', 'required');
           

            if ($this->form_validation->run() == FALSE) {
				
                $this->layout->view('edit_category', $lay,$data);
            } else {
				$menus="";
                    foreach($this->input->post("user_perm") as $key => $val){  
                      $menus.=$val.",";
                   }

                   $menus= rtrim($menus,",");
				$post['menus']=$menus;  
                $update = $this->adminuser_model->update_type($post,$id);
				
                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Type Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update Successfully');
                }
                redirect(base_url() . 'adminuser/type_list');
            }
        } else {

           
            $data['name'] = $this->auto_model->getFeild('name', 'adminuser_type', 'id', $id);
            $data['status'] = $this->auto_model->getFeild('status', 'adminuser_type', 'id', $id);
			$data['menus'] = $this->auto_model->getFeild('menus', 'adminuser_type', 'id', $id);

            $this->layout->view('edit_category', $lay, $data);
        }
    }

    ///// Delete menu //////////////////////////////////
    public function delete_type() {
        $id = $this->uri->segment(3);
        $delete = $this->adminuser_model->delete_menu($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Type Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');
        }
        redirect(base_url() . 'adminuser/type_list');
    }
	
	public function change_category_status()
	{
		$id = $this->uri->segment(3);
		if($this->uri->segment(4) == 'inact')
			$data['status'] = 'N';
		if($this->uri->segment(4) == 'act')
			$data['status'] = 'Y';
		
		
		$update = $this->adminuser_model->updatetype($data,$id);
		
		if ($update) {
			if($this->uri->segment(4) == 'inact')
				$this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');
			if($this->uri->segment(4) == 'act')
				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');
			
		} else {
			$this->session->set_flashdata('error_msg', 'unable to update');
		}
		$status = $this->uri->segment(5);
		redirect(base_url() . 'adminuser/type_list');
	
	}
	public function search_knowledge($srch='',$limit_from='') {
		$data['data'] = $this->auto_model->leftPannel();
		$lay['lft'] = "inc/section_left";
		
			if($srch=='')
			{
				redirect(base_url().'knowledge/knowledge_list/');	
			}
			else
			{
				$qstn=$srch;
				$this->load->library('pagination');
				$config['base_url'] = base_url().'knowledge/search_knowledge/'.$qstn.'/';
				$config['total_rows'] =$this->knowledge_model->countFaq($qstn);
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
				$data['all_data'] = $this->knowledge_model->getfilterFaqList($qstn,$config['per_page'], $start);
				$data['links']=$this->pagination->create_links();
				$this->layout->view('list', $lay, $data);
			}
		
	}
    

	

}
