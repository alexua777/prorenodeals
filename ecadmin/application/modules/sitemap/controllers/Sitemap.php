<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('sitemap_model');
        $this->load->library('form_validation');
		$this->load->library('pagination');
        parent::__construct();
    }

    public function index() {
	    redirect (base_url(). 'sitemap/page');
       /* $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

        $data['list'] = $this->sitemap_model->getsitemap();


        $this->layout->view('list', $lay, $data);*/
    }

    /////////////// sitemap Add ///////////////////////////////////////////////
    public function add() {
        $data['data'] = $this->auto_model->leftPannel();
        $lay['left'] = "inc/section_left";

        if ($this->input->post()) {
           $this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length[10]');
            $this->form_validation->set_rules('url', 'Url', 'required');
           $this->form_validation->set_rules('status', '', '');

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('add', $lay, $data);
            } else {

                $post_data = $this->input->post();
                $insert_country = $this->sitemap_model->add_sitemap($post_data);

                if ($insert_country) {
                    $this->session->set_flashdata('succ_msg', 'Sitemap Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert');
                }
                redirect(base_url() . 'sitemap');
            }
        } else {
            $this->layout->view('add', $lay, $data);
        }
    }

    //////////////edit sitemap menu////////////////////
    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();
        
        $lay['lft'] = "inc/section_left";

        $id = $this->uri->segment(3);
        if ($id == '') {
            $id = set_value('id');
        }

        if ($this->input->post()) {

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('url', 'Url', 'required');
            //$this->form_validation->set_rules('status','Status','');


            if ($this->form_validation->run() == FALSE) {
                $this->layout->view('edit', $lay, $data);
            } else {

                $post_data = $this->input->post();
                $update = $this->sitemap_model->update_sitemap($post_data);

                if ($update) {
                    $this->session->set_flashdata('succ_msg', 'Sitemap Updated Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Update ');
                }
                redirect(base_url() . 'sitemap');
            }
        } else {

            $data['id'] = $id;
            $data['name'] = $this->sitemap_model->getfield('name', 'sitemap', 'id', $id);
            $data['url'] = $this->sitemap_model->getfield('url', 'sitemap', 'id', $id);
            //$data['status'] = $this->sitemap_model->getfield('status','sitemap','id',$id);
           
            $this->layout->view('edit', $lay, $data);
        }
    }

    ///// Delete sitemap //////////////////////////////////
    public function delete_sitemap() {
        $id = $this->uri->segment(3);
        $delete = $this->sitemap_model->delete_sitemap($id);

        if ($delete) {
            $this->session->set_flashdata('succ_msg', 'Sitemap Deleted Successfully');
        } else {
            $this->session->set_flashdata('error_msg', 'Unable to Delete');
        }
        redirect(base_url() . 'sitemap');
    }
	 public function page($limit_from='')
	{
	$lay['lft'] = "inc/section_left";
        $config = array();
        $config["base_url"] = base_url() . "sitemap/page";
        $config["total_rows"] = $this->sitemap_model->record_count_sitemap();
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
        if($page>0)	
        {   
            for($i = 1; $i<$page; $i++)
            {
                $start = $start + $per_page;		
            }
        }
		
        $data['data'] = $this->auto_model->leftPannel();
        $data["links"] = $this->pagination->create_links();
		$data["page"]=$config["per_page"];
		//$data($config['per_page'])=3;
        $data['list'] = $this->sitemap_model->getsitemap($config['per_page'],$start);
        //$data['edit'] = $this->notification_model->update_countrymenu();
        $this->layout->view('list', $lay, $data);
    }
	
	
	
	

}
