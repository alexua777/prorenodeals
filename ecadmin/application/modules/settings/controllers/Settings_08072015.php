<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Settings extends MX_Controller {



    /**

     * Description: this used for check the user is exsts or not if exists then it redirect to this site

     * Paremete: username and password 

     */

    public function __construct() {

        $this->load->model('settings_model');

        $this->load->library('form_validation');

		$this->load->library('editor');

        parent::__construct();

		$this->load->helper('url'); 

		$this->load->helper('ckeditor');

    }



    public function index() {

        $data['data'] = $this->auto_model->leftPannel();



        $lay['lft'] = "inc/section_left";



        $data['edit'] = $this->settings_model->update_Setting($post_data);



        $this->layout->view('edit', $lay, $data);

    }



	

	

	

	public function account_edit(){

	

		$data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = set_value('id');

        }

		

		$data['all_data'] = $this->settings_model->getAllSettingsData($id);

	

		if ($this->input->post()) {



            $this->form_validation->set_rules('fix_featured_charge', 'Fixed Featured', 'required');

			$this->form_validation->set_rules('fix_non_featured_charge', 'Fixed Non Featured', 'required');

            $this->form_validation->set_rules('featured_charge_hourly', 'Featured Hourly', 'required');

            $this->form_validation->set_rules('fix_non_featured_charge', 'Non Featured Hourly', 'required');

             $this->form_validation->set_rules('currency_txt', 'Currency Text', 'required');

			  $this->form_validation->set_rules('bidwin_charge', 'Bidwin charge', 'required|numeric');

	

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('account_edit', $lay, $data);

            } else {

                

                $post_data = $this->input->post();

               

                $update = $this->settings_model->update_account_Setting($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Settings Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/account_edit/1');

            }

        } else {

            

            $this->layout->view('account_edit', $lay, $data,'setting');

        }

	

	

	

	

	}

	

	

	public function maintenance_setting(){

	

        $lay['lft'] = "inc/section_left";

		$data['ckeditor'] = $this->editor->geteditor('contents','Full');

		$data['data'] = $this->auto_model->leftPannel();

        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = set_value('id');

        }

		

		$data['all_data'] = $this->settings_model->getAllSettingsData($id);

	

		if ($this->input->post()) {



            $this->form_validation->set_rules('maintaince_heading', 'Maintanence heading','required');

			$this->form_validation->set_rules('maintaince_description', 'Maintanence description','required');

           

            

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('maintain_message', $lay, $data);

            } else {

                

                $post_data = $this->input->post();

               

                $update = $this->settings_model->update_account_maintance_Setting($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Settings Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/maintenance_setting/1');

            }

        } else {

            

            $this->layout->view('maintain_message', $lay, $data,'setting');

        }

	

	

	

	}

	

	

	

	public function transfer_edit(){

		$data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

 		

        $id = $this->uri->segment(3);

		 if ($id == '') {

            $id = set_value('id');

        }

        

		$data['all_data'] = $this->settings_model->getAllSettingsData($id);

		if ($this->input->post()) {

			

			



            $this->form_validation->set_rules('paypal_mail', 'Paypal Email','required');

			$this->form_validation->set_rules('paypal_mode', 'Paypal Mode','required');

            

			//$this->form_validation->set_rules('withdrawl_method_paypal', 'Withdrawl method','required');

            //$this->form_validation->set_rules('withdrawl_method_wire_transfer', 'withdrawl_method_wire_transfer','required');

            $this->form_validation->set_rules('withdrawl_commission_paypal', 'Paypal withdraw commission','required');

            $this->form_validation->set_rules('withdrawl_commission_wire_transfer', 'Wire transfer withdraw commission','required');

			

			$this->form_validation->set_rules('bank_ac', 'bank account no','required');

			

			$this->form_validation->set_rules('bank_name', 'bank name','required');

			

			$this->form_validation->set_rules('bank_address', 'bank_address','required');

            

            if ($this->form_validation->run() == FALSE) {

				

				

                $this->layout->view('account_transfer', $lay, $data);

			

				

            } else {

                

                $post_data = $this->input->post();

				

				//print_r($post_data); die();

               

                $update = $this->settings_model->update_account_transfer_Setting($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Settings Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/transfer_edit/1');

            }

        } else {            

            $this->layout->view('account_transfer', $lay, $data,'setting');
        }

	}
	

    public function edit() {



        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = set_value('id');

        }

		

		$data['all_data'] = $this->settings_model->getAllSettingsData($id);



        if ($this->input->post()) {



            $this->form_validation->set_rules('site_title', 'site title', 'required');

            /*$this->form_validation->set_rules('meta_desc', 'meta description', 'required');

            $this->form_validation->set_rules('meta_keys', 'meta keys', 'required');

            $this->form_validation->set_rules('comp_desc', 'company description', 'required');

            $this->form_validation->set_rules('admin_mail', 'admin mail', 'required|valid_email');

            $this->form_validation->set_rules('career_mail', 'career mail', 'required|valid_email');

            $this->form_validation->set_rules('support_mail', 'support mail', 'required|valid_email');*/

            /*$this->form_validation->set_rules('facebook', 'facebook', 'required');

		    $this->form_validation->set_rules('twitter', 'twitter', 'required');

			$this->form_validation->set_rules('linkedin', 'linkedin', 'required');

			$this->form_validation->set_rules('pinterest', 'pinterest', 'required');

			$this->form_validation->set_rules('rss', 'rss', 'required');

            $this->form_validation->set_rules('address', 'address', 'required');*/

            /*$this->form_validation->set_rules('corporate_address', 'corporate address', 'required');

            $this->form_validation->set_rules('contact_no', 'contact no', 'required|numeric');

           /* $this->form_validation->set_rules('office_no', 'office no', 'required|numeric');

            $this->form_validation->set_rules('corporate_no', 'corporate no', 'required|numeric');

            $this->form_validation->set_rules('telephone', 'telephone', 'required|numeric');*/

			/*$this->form_validation->set_rules('map', 'map', 'required');*/

           /* $this->form_validation->set_rules('customer_care_no', 'customer care no', 'required|numeric');

			$this->form_validation->set_rules('email_verify', 'Verify Email', 'required');*/

			$this->form_validation->set_rules('job_expiration', 'Job expiration days', 'required|numeric');

          



            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('edit', $lay, $data);

            } else {

				$site_logo = '';

                $config['upload_path'] = '../assets/img/';

                $config['allowed_types'] = 'gif|jpg|png|jpeg';

                $this->load->library('upload', $config);

                $uploaded = $this->upload->do_upload('site_logo');				

                $upload_data = $this->upload->data();

                //print_r($upload_data); die();           

                $site_logo = $upload_data['file_name'];

                if ($uploaded AND $site_logo == '') {

                    $error = array('error' => $this->upload->display_errors());

                    // print_r($this->upload->display_errors());

                    // die();

                    $this->session->set_flashdata('error_msg', $error['error']);

                    redirect(base_url() . 'settings/edit/1');

                }

                //$post_data = $this->input->post();

                
				
				
				
				

                $favicon = '';

                $config['upload_path'] = '../assets/favicon/';

                $config['allowed_types'] = 'gif|jpg|png|jpeg';
				
				$this->upload->initialize($config);

                //$this->load->library('upload', $config);

                $uploaded = $this->upload->do_upload();				

                $upload_data = $this->upload->data();

                //print_r($upload_data); die();           

                $favicon = $upload_data['file_name'];

                if ($uploaded AND $favicon == '') {

                    $error = array('error' => $this->upload->display_errors());

                    // print_r($this->upload->display_errors());

                    // die();

                    $this->session->set_flashdata('error_msg', $error['error']);

                    redirect(base_url() . 'settings/edit/1');

                }

                $post_data = $this->input->post();

                if (isset($favicon) AND $favicon != '') {

                    // $id = $this->input->post('id');

                    $prev_img = $this->auto_model->getFeild('favicon', 'setting', 'id', 1);

                    if ($prev_img != "" && file_exists("../assets/favicon/" . $prev_img)) {

                        @unlink("../assets/favicon/" . $prev_img);

                    }



                    $post_data['favicon'] = $favicon;

                }

				else

				{

					$prev_img = $this->auto_model->getFeild('favicon', 'setting', 'id', 1);	

					$post_data['favicon'] = $prev_img;

				}
				
				if (isset($site_logo) AND $site_logo != '') {

                    // $id = $this->input->post('id');

                    $prev_img = $this->auto_model->getFeild('site_logo', 'setting', 'id', 1);

                    if ($prev_img != "" && file_exists("../assets/img/" . $prev_img)) {

                        @unlink("../assets/img/" . $prev_img);

                    }



                    $post_data['site_logo'] = $site_logo;

                }

				else

				{

					$prev_img = $this->auto_model->getFeild('site_logo', 'setting', 'id', 1);	

					$post_data['site_logo'] = $prev_img;

				}

				//echo "<pre>";print_r($post_data);die;
                //$post_data = $this->input->post();

                $update = $this->settings_model->update_Setting($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Settings Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/edit/1');

            }

        } else {

            

            $this->layout->view('edit', $lay, $data,'setting');

        }

    }



    public function pass_edit($aid='') {

        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

		if($aid=='')

		{

			$ses_data = $this->session->userdata('user');

        	$data['id']=$id = $ses_data->admin_id;

		}

		else

		{

			$data['id']=$id=$aid;	

		}

        if ($this->input->post()) {



            $this->form_validation->set_rules('old_pass', 'Old Password', 'required');

            $this->form_validation->set_rules('new_pass', 'New Password', 'required');

            // $this->form_validation->set_rules('con_pass', 'Confirm Password', 'required');

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('password_edit', $lay, $data);

            } else {

                $update = $this->settings_model->update_pass($id);



                if ($update > 0) {

					$username=$this->auto_model->getFeild('username','admin','admin_id',$id);

					$email=$this->auto_model->getFeild('email','admin','admin_id',$id);

					$from=ADMIN_EMAIL;

					$to=$email;

					$template='change_password';

					$data_parse=array('username'=>$username,

										'password'=>$this->input->post('new_pass')

										);

					$this->auto_model->send_email($from,$to,$template,$data_parse);

                    $this->session->set_flashdata('succ_msg', 'Password Updated Successfully');

                } else {



                    $this->session->set_flashdata('error_msg', 'Unable to Update');

                }

                redirect(base_url() . 'settings/pass_edit');

            }

        } else {

            $this->layout->view('password_edit', $lay, $data);

        }

    }

	public function profile_complete()

	{

        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = 1;

        }

		

		$data['all_data'] = $this->settings_model->getProfile($id);



        if ($this->input->post()) {



            $this->form_validation->set_rules('basic_info', 'Basic information', 'required|numeric');

            $this->form_validation->set_rules('social_info', 'Social information', 'required|numeric');

            $this->form_validation->set_rules('portfolio_info', 'portfolio information', 'required|numeric');

            $this->form_validation->set_rules('skill_info', 'skill information', 'required|numeric');

            $this->form_validation->set_rules('finance_info', 'finance information', 'required|numeric');

			$this->form_validation->set_rules('reference_info', 'reference information', 'required|numeric');

          



            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('prof_complete', $lay, $data);

            } else {

				$tot=$this->input->post('basic_info')+$this->input->post('social_info')+$this->input->post('portfolio_info')+$this->input->post('skill_info')+$this->input->post('finance_info')+$this->input->post('reference_info');

				

				if($tot>100)

				{

					$this->session->set_flashdata('error_msg', 'Updation failed. Total weigtage must be less than 100!');

					redirect(base_url() . 'settings/profile_complete/1');		

				}

				

                $post_data = $this->input->post();

                

                //$post_data = $this->input->post();

                $update = $this->settings_model->update_prof($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Settings Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/profile_complete/1');

            }

        } else {

            

            $this->layout->view('prof_complete', $lay, $data,'setting');

        }

    	

	}

	public function homepage()

	{

		$data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = 1;

        }

		

		$data['all_data'] = $this->settings_model->getHomepage($id);

		if($this->input->post())

		{

			$this->form_validation->set_rules('skills', 'Skill view', 'required');

            $this->form_validation->set_rules('testimonial', 'testimonial view', 'required');

            $this->form_validation->set_rules('cms', 'cms view', 'required');

            $this->form_validation->set_rules('counting', 'counting view', 'required');

            $this->form_validation->set_rules('partner', 'partner view', 'required');

			$this->form_validation->set_rules('newsletter', 'newsletter view', 'required');

			$this->form_validation->set_rules('posts', 'posts view', 'required');

			 $this->form_validation->set_rules('popular_links', 'popiular links view', 'required');

			$this->form_validation->set_rules('skill_no', 'skill no', 'required|numeric');

			$this->form_validation->set_rules('testimonial_no', 'testimonial no', 'required');

          



            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('home_list', $lay, $data);

            } else {				

                $post_data = $this->input->post();

                

                //$post_data = $this->input->post();

                $update = $this->settings_model->update_home($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Home page module Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/homepage/1');

			}

		}

		else

		{

		$this->layout->view('home_list', $lay, $data,'setting');

		}

	}

	

	public function homecms()

	{

		$data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = 1;

        }

		

		$data['all_data'] = $this->settings_model->getHomecms();

		

		if($this->input->post())

		{

			$this->form_validation->set_rules('title_1', 'title for section1', 'required');

            $this->form_validation->set_rules('desc_1', 'description for section1', 'required');

			$this->form_validation->set_rules('title_2', 'title for section2', 'required');

            $this->form_validation->set_rules('desc_2', 'description for section2', 'required');

			$this->form_validation->set_rules('title_3', 'title for section3', 'required');

            $this->form_validation->set_rules('desc_3', 'description for section3', 'required');

           

            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('home_cms', $lay, $data);

            } else {

				

				$image1 = '';

				$image2 = '';

				$image3 = '';

                $config['upload_path'] = '../assets/cms_image/';

                $config['allowed_types'] = 'gif|jpg|png';



                $this->load->library('upload', $config);



                $uploaded1 = $this->upload->do_upload('image_1');

                $upload_data1 = $this->upload->data();

                $image1 = $upload_data1['file_name'];

				

				$uploaded2 = $this->upload->do_upload('image_2');

                $upload_data2 = $this->upload->data();

                $image2 = $upload_data2['file_name'];

				

				$uploaded3 = $this->upload->do_upload('image_3');

                $upload_data3 = $this->upload->data();

                $image3 = $upload_data3['file_name'];

				

				 /*?>$configs['image_library'] = 'gd2';

				$configs['source_image']	= '../assets/cms_image/'.$image1;

				$configs['create_thumb'] = TRUE;

				$configs['maintain_ratio'] = TRUE;

				$configs['width']	 = 70;

				$configs['height']	= 70;

				$this->load->library('image_lib', $configs); 

				$rsz1=$this->image_lib->resize();

				if($rsz1)

				{

					$image1=$upload_data1['raw_name'].'_thumb'.$upload_data1['file_ext'];

				}

				

				$configs['image_library'] = 'gd2';

				$configs['source_image']	= '../assets/cms_image/'.$image2;

				$configs['create_thumb'] = TRUE;

				$configs['maintain_ratio'] = TRUE;

				$configs['width']	 = 70;

				$configs['height']	= 70;

				$this->load->library('image_lib', $configs); 

				echo $rsz2=$this->image_lib->resize();

				if($rsz2)

				{

					$image2=$upload_data2['raw_name'].'_thumb'.$upload_data2['file_ext'];

				}

				

				$configs['image_library'] = 'gd2';

				$configs['source_image']	= '../assets/cms_image/'.$image3;

				$configs['create_thumb'] = TRUE;

				$configs['maintain_ratio'] = TRUE;

				$configs['width']	 = 70;

				$configs['height']	= 70;

				$this->load->library('image_lib', $configs); 

				echo $rsz3=$this->image_lib->resize(); die();

				if($rsz3)

				{

					$image3=$upload_data3['raw_name'].'_thumb'.$upload_data3['file_ext'];

				}<?php */



                if (!$uploaded1 AND $image1 != '') {

                    $error = array('error' => $this->upload->display_errors());

                    $this->session->set_flashdata('error_msg', $error['error']);

                    redirect(base_url() . 'settings/homecms/');

                }

				if (!$uploaded2 AND $image2 != '') {

                    $error = array('error' => $this->upload->display_errors());

                    $this->session->set_flashdata('error_msg', $error['error']);

                    redirect(base_url() . 'settings/homecms/');

                }

				if (!$uploaded3 AND $image3 != '') {

                    $error = array('error' => $this->upload->display_errors());

                    $this->session->set_flashdata('error_msg', $error['error']);

                    redirect(base_url() . 'settings/homecms/');

                }



                if (isset($image1) AND $image1 != '') {

                    $post_data['image'] = $image1;

                }

								

                $post_data['title'] = $this->input->post('title_1');

				$post_data['desc'] = $this->input->post('desc_1');

            

                $update1 = $this->settings_model->update_cms($post_data,'1');

				

				

				if (isset($image2) AND $image2 != '') {

                    $new_data['image'] = $image2;

                }

								

                $new_data['title'] = $this->input->post('title_2');

				$new_data['desc'] = $this->input->post('desc_2');

            

                $update2 = $this->settings_model->update_cms($new_data,'2');

				

				if (isset($image3) AND $image3 != '') {

                    $pst_data['image'] = $image3;

                }

								

                $pst_data['title'] = $this->input->post('title_3');

				$pst_data['desc'] = $this->input->post('desc_3');

            

                $update3 = $this->settings_model->update_cms($pst_data,'3');



                if ($update1 && $update2&& $update3) {

                    $this->session->set_flashdata('succ_msg', 'Home page cms Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/homecms/1');

			}

		}

		else

		{

		$this->layout->view('home_cms', $lay, $data,'setting');

		}

	}

	

	public function popular()

	{

		$data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";



        $id = $this->uri->segment(3);

        if ($id == '') {

            $id = 1;

        }

		

		$data['all_data'] = $this->settings_model->getPopularlinks($id);

		if($this->input->post())

		{

			$this->form_validation->set_rules('terms', 'Terms and Condition view', 'required');

          



            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('popular', $lay, $data);

            } else {				

                $post_data = $this->input->post();

                

                //$post_data = $this->input->post();

                $update = $this->settings_model->update_popular($post_data);



                if ($update) {

                    $this->session->set_flashdata('succ_msg', 'Popular links module Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'unable to update');

                }

                redirect(base_url() . 'settings/popular/1');

			}

		}

		else

		{

		$this->layout->view('popular_list', $lay, $data,'setting');

		}

	}



}

