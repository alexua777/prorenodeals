<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Location extends MX_Controller {



    public function __construct() {

        $this->load->model('location_model');

        $this->load->library('form_validation');

        $this->load->library("pagination");

        parent::__construct();

    }



    public function index() {

        redirect(base_url() . 'location/city');

    }



    /////////////// Menu Add /////////////////////////////////////////

    public function add() {

        $data['data'] = $this->auto_model->leftPannel();

        $lay['left'] = "inc/section_left";



		$data['country_list'] = $this->location_model->getAllcountrylist();

        if ($this->input->post()) {

            

            $this->form_validation->set_rules('c_name', 'Country Name', 'required');

            $this->form_validation->set_rules('city', 'city name', 'required|max_length[500]');

           

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('add', $lay, $data);

            } else {

               

                $post_data['CountryCode'] = $this->input->post('c_name');

                $post_data['Name'] = $this->input->post('city');

                

                //echo "<pre>";

               //print_r($post_data);die;

                $insert_city = $this->location_model->add_countrymenu($post_data);

                //  echo $this->db->last_query();die;

                if ($insert_city) {

                    $this->session->set_flashdata('succ_msg', 'City Inserted Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'Unable to Insert Successfully');

                }

                redirect(base_url() . 'location/city');

            }

        } else {

            $this->layout->view('add', $lay, $data);

        }

    }



    //////////////edit country menu////////////////////

    public function edit() {

        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

		$data['country_list'] = $this->location_model->getAllcountrylist();

        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = set_value('id');

        }



        if ($this->input->post()) {

            



            $this->form_validation->set_rules('c_name', 'Country Name', 'required');

            $this->form_validation->set_rules('city', 'city name', 'required');

           





            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('edit', $lay, $data);

            } else {





               

                $post_data['CountryCode'] = $this->input->post('c_name');

                $post_data['Name'] = $this->input->post('city');

                



                $update = $this->location_model->update_countrymenu($post_data, $id);

                // echo $this->db->last_query();die;

                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'City Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'Unable to Update');

                }

                redirect(base_url() . 'location/city');

            }

        } else {



            $data['id'] = $id;

            $data['name'] = $this->auto_model->getFeild('Name', 'city', 'ID', $id);

            $data['country_code'] = $this->auto_model->getFeild('CountryCode', 'city', 'ID', $id);





            $this->layout->view('edit', $lay, $data);

        }

    }



    ///// Delete menu //////////////////////////////////

    public function delete() {

        $id = $this->uri->segment(3);

        $delete = $this->location_model->delete_menu($id);



        if ($delete) {

            $this->session->set_flashdata('succ_msg', 'City Deleted Successfully');

        } else {

            $this->session->set_flashdata('error_msg', 'Unable to Delete Successfully');

        }

        redirect(base_url() . 'location');

    }



    public function city($limit_from = '') {
		
		$default_country = 'CAN';
		redirect(base_url('location/getcity/'.$default_country));

        $lay['lft'] = "inc/section_left";

		$data['country_list'] = $this->location_model->getAllcountrylist();

		

		

        $config = array();

        $config["base_url"] = base_url() . "location/city";

        $config["total_rows"] = $this->location_model->record_count_country();

        $config["per_page"] = 20;

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

        $data['data'] = $this->auto_model->leftPannel();

		

        $data['list'] = $this->location_model->getcountrylist($config['per_page'], $start);

        $this->layout->view('list', $lay, $data);

    }



    public function change_country_status() {

        $id = $this->uri->segment(3);

        if ($this->uri->segment(4) == 'inact')

            $data['status'] = 'N';

        if ($this->uri->segment(4) == 'act')

            $data['status'] = 'Y';





        $update = $this->country_model->updatecountry($data, $id);



        if ($update) {

            if ($this->uri->segment(4) == 'inact')

                $this->session->set_flashdata('succ_msg', 'Inactive Successfully Done...');

            if ($this->uri->segment(4) == 'act')

                $this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');

        } else {

            $this->session->set_flashdata('error_msg', 'unable to update');

        }

        $status = $this->uri->segment(5);

        redirect(base_url() . 'country/page');

    }



    public function change_default_country() {

        $id = $this->uri->segment(3);

        if ($this->uri->segment(4) == 'nod')

            $data['set_default'] = 'N';

        if ($this->uri->segment(4) == 'yd')

            $data['set_default'] = 'Y';





        $update = $this->country_model->updatecountry($data, $id);



        if ($update) {

            if ($this->uri->segment(4) == 'nod')

                $this->session->set_flashdata('succ_msg', 'Default Country Setting Successfully Done...');

            if ($this->uri->segment(4) == 'yd')

                $this->session->set_flashdata('succ_msg', 'Cancell Default Country Setting... ');

        } else {

            $this->session->set_flashdata('error_msg', 'unable to update');

        }

        $status = $this->uri->segment(5);

        redirect(base_url() . 'country/page');

    }

	public function getcity($countrycode='',$limit_from='')

	{

		$lay['lft'] = "inc/section_left";

		$data['country_list'] = $this->location_model->getAllcountrylist();

		if($countrycode=='')

		{

			$countrycode=$this->input->post('country');

		}

        $config = array();

        $config["base_url"] = base_url() . "location/getcity/".$countrycode;

        $config["total_rows"] = $this->location_model->record_count_city($countrycode);

        $config["per_page"] = 20;

        $config["uri_segment"] = 4;

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

        $data['list'] = $this->location_model->getcitylist($countrycode,$config['per_page'], $start);

        $this->layout->view('list', $lay, $data);

	

	}



}

