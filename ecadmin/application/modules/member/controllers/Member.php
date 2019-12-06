<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Member extends MX_Controller {



    //private $auto_model;



    /**

     * Description: this used for check the user is exsts or not if exists then it redirect to this site

     * Paremete: username and password 

     */

    public function __construct() {

        $this->load->model('member_model');

        $this->load->library('form_validation');

		$this->load->library('pagination');

        $this->load->library('editor');

        parent::__construct();

		$this->load->helper('url'); //You should autoload this one ;)

		$this->load->helper('ckeditor');

    }



    public function index() {

	    redirect (base_url());

      

    }



  

  

  

  

	public function view_details(){

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);

	

	$this->layout->view('user_details', $lay, $data);

	

	

	}
	public function view_documents(){		$uid = $this->uri->segment(3);		$data['data'] = $this->auto_model->leftPannel();		$lay['lft'] = "inc/section_left";		$data['user_details'] = $this->member_model->get_user_details($uid);		$data['documents'] = $this->member_model->get_user_document($uid);		$this->layout->view('user_document', $lay, $data);	}
  
  
	public function doc_status(){
		$doc_id = get('document_id');
		$status = get('status');
		$data = array(
			'status' => $status
		);
		$this->db->where('id', $doc_id)->update('user_documents', $data);
		$refer = $this->input->server('HTTP_REFERER');
		redirect($refer);
	}

	public function view_qualification(){

	

	

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);



	

	$this->layout->view('user_quali', $lay, $data);

	}

  

	public function view_skill(){

	

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_id'] = $this->uri->segment(3);
$data['user_details'] = $this->member_model->get_user_details($uid);
	

	$data['all_p_skill'] = $this->member_model->get_all_p_skill();

	

	

	

	$data['user_skill'] = $this->member_model->get_user_skill($uid);



	$data['user_skill_parent'] = $this->auto_model->getFeild('parent_id','skills','skill_name',$data['user_skill'][0]);



	$data['sub_skill'] = $this->member_model->get_sub_skill($data['user_skill_parent']);

	

	$this->layout->view('user_skill', $lay, $data);

	

	}

  

  

  public function getskill_option(){

   $uid = $this->uri->segment(3);	

   $user_skill = $this->member_model->get_user_skill($uid);

   

   $sub_skill =  $this->member_model->get_sub_skill($this->input->post('pid'));

   $option = '';



    	//$option = $option.'<option value="'.$skill['id'].'">'.$skill['skill_name'].'<option>';

    

	foreach($sub_skill as $skill){

		

	  $option = $option."<li><input type='checkbox' name='c_skill[]'  value='".$skill['id']."' selected class='mailcheck checkIt' />".$skill['skill_name']."</li>";	

            

	

	}

	if($option !=""){

	

	echo $option;

	}else{

	  //echo '<option vaue="0">No Skill Added</option>';

            echo '<li>No Skill Added</li>';

	}

   

   

  

  }

  

    public function  update_member_skill(){

	

	

		$referrer = $this->input->post('referrer');

		$uder_id =  $this->input->post('user_id');

		$data['skills_id']= implode(",",$this->input->post('c_skill'));

		$update = $this->member_model->update_user_skill($data,$uder_id);

		

		if ($update)

                {

                    $this->session->set_flashdata('succ_msg', 'Skill Updated Successfully');

                }

                

                else 

                {

                    $this->session->set_flashdata('error_msg', 'Unable to Update Skill');

                }

		

				redirect($referrer);

	}

  

  

  

  

  

    public function member_list($limit_from = ''){	

		$data['srch'] = $srch = $this->input->get();		

		$data['data'] = $this->auto_model->leftPannel();

		$lay['lft'] = "inc/section_left";

		$data['ckeditor'] = $this->editor->geteditor('body','Full');

			$config = array();

			$config["base_url"] = base_url('member/member_list');

			$config["total_rows"] = $this->member_model->getAllMemberList('', '',$srch, FALSE);

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

			//$data($config['per_page'])=3;

			

		$data['all_data'] = $this->member_model->getAllMemberList($config['per_page'], $start,$srch);



		$this->layout->view('list', $lay, $data);

    }

	

	public function close_member_list($limit_from = '')

    {

	

	$s_key =  $this->uri->segment(3);

	

	

	

	

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['ckeditor'] = $this->editor->geteditor('body','Full');

        $config = array();

        $config["base_url"] = base_url();

        $config["total_rows"] = $this->member_model->record_close_member();

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

        //$data($config['per_page'])=3;

		

	$data['all_data'] = $this->member_model->getcloseMemberList($config['per_page'], $start);

	



   $this->layout->view('close_list', $lay, $data);

    }

	

	

	

	

	 public function page($user_id = '0', $letter = 0, $limit_to = '0') {



        if ($this->input->post()) {

            $post_data = $this->input->post();

            $user_id = $this->input->post('user_id');

        }

        $data['user_id'] = $user_id;

        $data['letter'] = $letter;

        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

        //$data['parent_info'] = $this->car_category_model->getAllParentCatList(0);

        $config['base_url'] = base_url() . 'member/page/' . $user_id . '/' . $letter;

        $config['total_rows'] = $this->member_model->countRecord($user_id, $letter);

        $config['per_page'] = 30;



        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';



        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';



        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';



        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';



        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';



        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';

        $config['cur_tag_close'] = '</a></li>';

        $config["uri_segment"] = 5;



        $data['total_page'] = $config['total_rows'];

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();



        $data['all_data'] = $this->member_model->getAllMember($user_id, $limit_to, $config['per_page'], $letter);



        $this->layout->view('member_list', $lay, $data);

    }

           

 	

	public function update_member(){

		$uid  = $uid = $this->uri->segment(3);

		$allPost = $this->input->post();

		$refferer = $allPost['referrer'];

		unset($allPost['referrer']);

		unset($allPost['submit']);

		$this->member_model->updateField($uid,$allPost);

		redirect($refferer);

	

	}

	

	

	public function view_portfolio(){

		$uid  = $uid = $this->uri->segment(3);

		$data['data'] = $this->auto_model->leftPannel();

		$lay['lft'] = "inc/section_left";

		$data['user_id'] = $this->uri->segment(3);

		$data['user_portfolio'] = $this->member_model->get_user_portfolio($uid);
		$data['user_details'] = $this->member_model->get_user_details($uid);

		$this->layout->view('user_portfolio', $lay, $data);

	

	

	}

	

	

	

	

	public function view_appliedjob(){

	

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);

	$data['user_applyed'] = $this->member_model->get_user_applied($uid);

	$this->layout->view('user_applyed_list', $lay, $data);

	

	}

	

	

	

	public function view_message(){

	

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);

	$data['user_message'] = $this->member_model->get_user_message($uid);

	$this->layout->view('user_message_list', $lay, $data);

	

	

	}

	

	

	

	

	public function view_transition(){

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);

	$data['user_trans'] = $this->member_model->get_user_transition($uid);

	$this->layout->view('user_tran_list', $lay, $data);

	

	

	}

	

	public function view_referee(){

	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);

	$data['user_trans'] = $this->member_model->get_user_referee($uid);

	$this->layout->view('user_referee', $lay, $data);

	

	

	}

	

	

	

	

	

	

	public function view_education(){



	$uid = $this->uri->segment(3);

	$data['data'] = $this->auto_model->leftPannel();

	$lay['lft'] = "inc/section_left";

	$data['user_details'] = $this->member_model->get_user_details($uid);



	

	$this->layout->view('user_education', $lay, $data);

	

	}

	

	

    public function add_membership_plan()

     {

		$data['data'] = $this->auto_model->leftPannel();

		$lay['lft'] = "inc/section_left";

		//$data['company']=$this->member_model->getCompany();		

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

			$post_data['name'] = $this->input->post('name');

			$post_data['bids'] =$this->input->post('bids');

			$post_data['skills'] =$this->input->post('skills');

			$post_data['portfolio'] =$this->input->post('portfolio');

			$post_data['price'] =$this->input->post('price');

			$post_data['days'] =$this->input->post('days');

			$post_data['status'] =$this->input->post('status');

            $insert_membership = $this->member_model->add_membership($post_data);

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

		if($this->uri->segment(4) == 'inapp_veryify'){
		$data['verify'] = 'N';	
		}
		if($this->uri->segment(4) == 'app_veryify'){
			$data['verify'] = 'Y';	
		}

			

		if($this->uri->segment(4) == 'del')

		{

			$update = $this->member_model->deleteMember($id);	

		}

		else

		{

                    $update = $this->member_model->updateMemberStatus($data,$id);

                    

		}

		

		if ($update) {

			if($this->uri->segment(4) == 'inact')

				$this->session->set_flashdata('succ_msg', 'Inactivation Successfully Done...');

			if($this->uri->segment(4) == 'act')

				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');

			if($this->uri->segment(4) == 'del')

				$this->session->set_flashdata('succ_msg', 'Deletion Successfully Done...');
				
			if($this->uri->segment(4) == 'inapp_veryify')

				$this->session->set_flashdata('succ_msg', 'Inactivation Successfully Done...');

			if($this->uri->segment(4) == 'app_veryify')

				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');

		} else {

			$this->session->set_flashdata('error_msg', 'Unable to Process.');

		}
		
		$next = get('next');
		
		if($next){
			redirect(base_url($next));
		}else{
			redirect(base_url() . 'member/member_list/');
		}
		
		

		

	}

	

	public function change_review_status()

	{

		$id = $this->uri->segment(3);

		//$type=$this->uri->segment(5);

		if($this->uri->segment(4) == 'inact')

			$data['admin_review'] = 'N';

		if($this->uri->segment(4) == 'act')

			$data['admin_review'] = 'Y';

			

		if($this->uri->segment(4) == 'del')

		{

			$update = $this->member_model->deleteMember($id);	

		}

		else

		{

                $update = $this->member_model->updateReviewStatus($data,$id);

                    

		}

		

		if ($update) {

			if($this->uri->segment(4) == 'inact')

				$this->session->set_flashdata('succ_msg', 'Inactivation Successfully Done...');

			if($this->uri->segment(4) == 'act')

				$this->session->set_flashdata('succ_msg', 'Activation Successfully Done...');

			if($this->uri->segment(4) == 'del')

				$this->session->set_flashdata('succ_msg', 'Deletion Successfully Done...');

		} else {

			$this->session->set_flashdata('error_msg', 'Unable to Process.');

		}

		redirect(base_url() . 'member/view_referee/'.$this->uri->segment(5));

		

	}

	

    public function get_category()

	{

		$id = $this->uri->segment(3);

		$data['get_cat_list'] = $this->listing_model->getCatList($id);

		//print_r($data);die;

		$this->layout->view('get_category_list','', $data);

	}



 

	

    

	

        

        public function edit_member()

		{

            $id = $this->uri->segment(3);

            $data['data'] = $this->auto_model->leftPannel();

            $lay['lft'] = "inc/section_left";

		    $data['country'] = $this->member_model->getAllcountrylist();

			

            //$data['allcountry']=$this->member_model->getAllcountry();

			// $data['allcity']=$this->member_model->getAllCity();

            //$data['company']=$this->member_model->getCompany();

				

            if($id)

            {

                $data['all_data'] = $this->member_model->getMemberUsingId($id);
				

				$country_code=$this->auto_model->getFeild('Code','country','name',$data['all_data']['country']);

				/* $data['state']=$this->member_model->getCity($country_code) */;				$data['state']=$this->member_model->getCity($data['all_data']['country']);

            }

            if($this->input->post())

            {

                $this->form_validation->set_rules('fname', 'First Name', 'required');

                $this->form_validation->set_rules('lname', 'Last Name', 'required');

                $this->form_validation->set_rules('email', 'Email', 'required');

               // $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|min_length[10]|max_length[11]');

                //$this->form_validation->set_rules('address', 'Address', 'required');

                //$this->form_validation->set_rules('zip', 'Zip Code', 'required|numeric|max_length[10]');

                  

                if ($this->form_validation->run() == FALSE)

                {

                    $this->layout->view('edit', $lay, $data);

                }

                    

                    else

                    {

                        $post_data['fname'] = $this->input->post('fname');

						$post_data['lname'] =$this->input->post('lname');

						$post_data['email'] =$this->input->post('email');

						//$post_data['mobile'] =$this->input->post('mobile');

						//$post_data['address'] =$this->input->post('address');

						$post_data['country'] =$this->input->post('country');

						$post_data['city'] =$this->input->post('city');

						//$post_data['country'] =$this->input->post('country');

                       // $post_data['gender'] =$this->input->post('gender');

                        $post_data['status'] =$this->input->post('status');

						$post_data['verify'] =$this->input->post('verify');
						$post_data['phone'] =$this->input->post('phone');
						$post_data['company'] =$this->input->post('company');

						

						//$update = $this->member_model->updateMember($post_data,$id);

			

                        $image = '';

                        $config['upload_path'] = '../assets/uploaded/';

                        $config['allowed_types'] = 'gif|jpg|png|jpeg';

                        $this->load->library('upload', $config);

                        $uploaded = $this->upload->do_upload();

                        $upload_data = $this->upload->data();

                        $image = $upload_data['file_name'];


						$configs['image_library'] = 'gd2';

						$configs['source_image']	= '../assets/uploaded/'.$image;

						$configs['create_thumb'] = TRUE;

						$configs['maintain_ratio'] = TRUE;

						$configs['width']	 = 150;

						$configs['height']	= 130;

						$this->load->library('image_lib', $configs); 

						$rsz=$this->image_lib->resize();

					if($rsz)

						{

                            $image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];

						}

					if(!$uploaded AND $image != '')

                        {

                            $error = array('error' => $this->upload->display_errors());

                            $this->session->set_flashdata('error_msg', $error['error']);

                            redirect(base_url() . 'member/edit_member/' . $id);

                        }

						$predata = $this->member_model->getMemberUsingId($id);

						if($image=="")

						{

							$post_data['logo'] = $predata['logo'];

						}

						else

						{

                        $post_data['logo'] = $image;

						}

						

                        $update = $this->member_model->updateMember($post_data,$id);

                        

                        if ($update) 

                        {

                            $this->session->set_flashdata('succ_msg', 'User Updated Successfully');

                        }

                        else

                        {

                            $this->session->set_flashdata('error_msg', 'Unable to Update');

                        }

                        

			redirect(base_url() . 'member/member_list');

                    }

		

		

		}

		if(!$this->input->post())

                {

                    $this->layout->view('edit', $lay, $data);

                }

		

	}

	

	public function getcity($country='')

	{

		$country=str_replace("%20"," ",$country);

		$country_code=$this->member_model->getFeild('Code','country','Name',$country);

	/* 	$state=	$this->member_model->getCity($country_code); */		$state =	$this->member_model->getCity($country);	
		?>

<option value="">Please Select</option>
<?php 

          foreach($state as $c){ 

        ?>
<option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
<?php

          } 

	}

	

	public function add() {

        $data['data'] = $this->auto_model->leftPannel();

        $lay['lft'] = "inc/section_left";

		$data['country'] = $this->member_model->getAllcountrylist();

        $data['state']=$this->member_model->getCity("NGA");

        if ($this->input->post()) {

			

			

            $this->form_validation->set_rules('fname', 'Firstname', 'required');

	    	$this->form_validation->set_rules('lname', 'Lastname', 'required');

			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');

	    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]|matches[cemail]');

	    	$this->form_validation->set_rules('cemail', 'Confirm Email', 'required|valid_email');

            $this->form_validation->set_rules('status', 'Status', 'required');

            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[cpassword]');

	    	$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|min_length[6]');

			$this->form_validation->set_rules('country', 'Country', 'required');

	    	$this->form_validation->set_rules('city', 'City', 'required');



            if ($this->form_validation->run() == FALSE) {

                $this->layout->view('add', $lay, $data);

            } else {



                $post_data = $this->input->post();

                $update = $this->member_model->add_user($post_data);



                if ($update) {

					$from=ADMIN_EMAIL;

					$to=$this->input->post('email');

					$template='registration';

					$data_parse=array('username'=>$this->input->post('username'),

									'password'=>$this->input->post('password'),

									'email'=>$this->input->post('email'),

									'copy_url'=>SITE_URL.'login/',

									'url_link'=>SITE_URL.'login/'

								);

					

					$this->auto_model->send_email($from,$to,$template,$data_parse);

                    $this->session->set_flashdata('succ_msg', 'User Updated Successfully');

                } else {

                    $this->session->set_flashdata('error_msg', 'Unable to Update');

                }

                redirect(base_url() . 'member/member_list');

            }

        } else {



            $this->layout->view('add', $lay, $data);

        }

    }

	public function filtermember($key='')

	{

		if($key=='')

		{

			redirect(base_url().'member/member_list/');	

		}

		else

		{

			$all_data = $this->member_model->getFilterMemberList($key);	

			

					$attr = array(

					'onclick' => "javascript: return confirm('Do you want to delete?');",

					'class' => 'i-cancel-circle-2 red',

					'title' => 'Delete'

					);

					$attr9 = array(

					'onclick' => "javascript: return confirm('Do you want to make feature this client?');",

					'class' => 'i-checkmark-3 red',

					'title' => 'Normal'

					);

					$attr8 = array(

					'onclick' => "javascript: return confirm('Do you want to remove featured from this client?');",

					'class' => 'i-checkmark-3 green',

					'title' => 'Featured'

					);

					$atr3 = array(

						'onclick' => "javascript: return confirm('Do you want to active this?');",

						'class' => 'i-checkmark-3 red',

						'title' => 'Inactive'

					);

					$atr4 = array(

						'onclick' => "javascript: return confirm('Do you want to inactive this?');",

						'class' => 'i-checkmark-3 green',

						'title' => 'Active'

					);





					if (count($all_data) != 0) {

						foreach ($all_data as $key => $user) {

							$plan=$this->auto_model->getFeild('name','membership_plan','id',$user['membership_plan']);

							?>
<tr>
  <td align="left"><input type="checkbox" name="mailsend" id="mail_<?php echo $user['user_id'];?>" value="<?php echo $user['user_id'];?>" class="mailcheck checkIt" title="please check to send mail"/></td>
  <td align="center"><?php echo $user['user_id']; ?></td>
  <td><?php if($user['logo']!='')

                                    {

                                        

                                    ?>
    <img src="<?= SITE_URL?>assets/uploaded/<?=$user['logo']?>" height="60" width="60"/>
    <?php

                                    }

                                    else 

                                    {

                                    ?>
    <img src="<?= SITE_URL?>assets/images/face_icon.gif" height="60" width="60"/>
    <?php

                                    }

                                    ?></td>
  <td><?php echo $user['username']."<br/>".$user['email']; ?></td>
  <td><?php echo ucwords($user['fname'])." ".ucwords($user['lname']); ?></td>
  <td><?php echo $user['acc_balance']; ?></td>
  <td><?php echo $plan; ?></td>
  <td><?php echo $user['membership_upgrade'];?></td>
  <td><?php echo $user['reg_date']."<br/>".$user['edit_date']; ?></td>
  <td><?php

                                        if ($user['status'] == 'Y')

                                        {

                                            echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/inact/'.$user['status'], '&nbsp;', $atr4);

                                        }

                                        elseif($user['status'] == 'N')

                                        {

                                            echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/act/'.$user['status'], '&nbsp;', $atr3);

                                        }

										else

										{

											echo "Closed";	

										}

                                        ?></td>
  <td align="center"><?php

                                    $atr1 = array('class' => 'i-highlight', 'title' => 'Edit');

                                    $atr5= array('class' => 'i-mail-2', 'title' => 'Send mail');

                                    $atr_view = array('class' =>'i-eye' ,'title'=> 'View Details');

                                    echo anchor(base_url() . 'member/edit_member/' . $user['user_id'],'&nbsp;', $atr1);

                                   // echo anchor(base_url() . 'member/send_mail/' . $user['user_id'],'&nbsp;', $atr5);

                                    echo anchor(base_url() . 'member/change_status/' . $user['user_id'].'/del/','&nbsp;', $attr);

                                    echo anchor(base_url() . 'member/view_details/' .$user['user_id'],'&nbsp;', $atr_view);

                                    

                                    ?>
    <a href="<?php echo base_url();?>member/add_fund/<?php echo $user['user_id'];?>/">Add Fund</a></td>
</tr>
<?php } ?>
<? } else { ?>
<tr>
  <td colspan="10" align="center" class="red"> No Records Found </td>
</tr>
<?php

					 } 

		}

	}

	public function viewfeedback($user_id='',$refer_id='')

	{

		$feedback=$this->member_model->getReview($refer_id,$user_id);

	?>
<div style="clear:both; height:20px;"></div>
<div class="safetybox">
  <p>Safety :</p>
  <?php

        for($i=0; $i < $feedback[0]['safety'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['safety']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Flexiblity :</p>
  <?php

        for($i=0; $i < $feedback[0]['flexiblity'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['flexiblity']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Performence :</p>
  <?php

        for($i=0; $i < $feedback[0]['performence'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['performence']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Initiative :</p>
  <?php

        for($i=0; $i < $feedback[0]['initiative'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['initiative']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Knowledge :</p>
  <?php

        for($i=0; $i < $feedback[0]['knowledge'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['knowledge']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Average rating :</p>
  <?php

        for($i=0; $i < $feedback[0]['average'];$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/1star.png" alt="review star"/>
  <?php	

        }

        for($i=0; $i < (5-$feedback[0]['average']);$i++)

        {

        ?>
  <img src="<?php echo SITE_URL;?>assets/images/star_3.png" alt="review star"/>
  <?php	

        }

        ?>
</div>
<div class="safetybox">
  <p>Comment :</p>
  <p style="text-align:left !important;"><?php echo $feedback[0]['comments'];?></p>
</div>
<?php

	}

	

	public function add_fund($user_id='')

	{

		if($user_id=='')

		{

			redirect(base_url().'member/member_list');	

		}

		else

		{

			$data['user_id']=$user_id;

			$data['data'] = $this->auto_model->leftPannel();

			$lay['lft'] = "inc/section_left";

			if($this->input->post())

			{

				$this->form_validation->set_rules('amount', 'amount', 'required|numeric');

	    		$this->form_validation->set_rules('reason', 'reaqson', 'required');



            	if ($this->form_validation->run() == FALSE) {

               	 	$this->layout->view('add_fund', $lay, $data);

            	} else {
					
					
					$this->load->model('transaction_model');
					
					$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);

					$acc_balance+=$this->input->post('amount');

					$post_data['acc_balance']=$acc_balance;

					$this->member_model->updateField($user_id,$post_data);

				

					$new_data['user_id']=$user_id;

					$new_data['amount']=$this->input->post('amount');

					$new_data['profit']="0.00";

					$new_data['transction_type']="CR";

					$new_data['transaction_for']=$this->input->post('reason');

					$new_data['transction_date']=date('Y-m-d h:i:s');

					$new_data['status']='Y';

					$inst=$this->member_model->insertTransaction($new_data);
					
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_MANUAL,  $user_id);
		   

					if($inst)

					{
						
						$user_wallet_id = get_user_wallet($user_id);
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $this->input->post('amount'), 'ref' => '', 'info' => 'Fund added by admin'));
				
						wallet_add_fund($user_wallet_id, $this->input->post('amount'));
						
						check_wallet($user_wallet_id,  $new_txn_id);
				
				
						
						$user_name=$this->auto_model->getFeild('username','user','user_id',$user_id);

						$to=$this->auto_model->getFeild('email','user','user_id',$user_id);

							$from=ADMIN_EMAIL;

							$template='add_fund_admin';

							$data_parse=array('name'=>$user_name,

							'amount'=>$this->input->post('amount')

								);

						$this->auto_model->send_email($from,$to,$template,$data_parse);

						

						$this->session->set_flashdata('succ_msg',"Fund added successfully.");

						redirect(base_url().'member/member_list');	

					}

					else

					{

						$this->session->set_flashdata('error_msg',"Updation failed.");

						redirect(base_url().'member/add_fund'.$user_id);	

					}

				}

			}

			else

			{	

				$this->layout->view('add_fund', $lay, $data);

			}

		}

	}

	

	public function getMails($uid)

	{

		

		$uid=explode(',',$uid);

		$umail='';

		for($i=0;$i<count($uid);$i++)

		{

			

			$mail=$this->auto_model->getFeild('email','user','user_id',$uid[$i]);

			

			$umail.=$mail.",";

		}

		$umail=rtrim($umail,', ');

		echo $umail;

	}

	

	public function send_mail()

	{

		$to=$this->input->post('to');

		$subject=$this->input->post('subject');

		$message=$this->input->post('body');

		

		$from=ADMIN_EMAIL;

		if($subject!=''){

		$subject=$this->input->post('subject');

		}

		else{

		$subject="Notification from SITE_TITLE";

		}

		$this->load->library('email');



			

		$this->email->from($from, 'admin');

		$this->email->to($to); 

		$this->email->subject($subject);

		$this->email->set_mailtype("html");

		

		$contents=str_replace('src="/','src="'.SITE_URL,$message);

		$contents=html_entity_decode($contents);

		$this->email->message($contents);	



		$a=$this->email->send();

		

		if($a)

		{

			$this->session->set_flashdata('succ_msg',"Email send successfuly.");	

		}

		else

		{

			$this->session->set_flashdata('error_msg',"Email sending failed.");	

		}

		redirect(base_url().'member/member_list');

			

	}

	public function generateCSV()

	{

            $this->load->database();

            $query = $this->db->get('user');

            $this->load->helper('csv');	

            query_to_csv($query, TRUE, 'User_list_'.date("dMy").'.csv');

	}

	

	public function plan_list($plan,$limit_from='')

	{

		$plan =  $this->uri->segment(3);

		$data['data'] = $this->auto_model->leftPannel();

		$lay['lft'] = "inc/section_left";

		$data['ckeditor'] = $this->editor->geteditor('body','Full');

			$config = array();

			$config["base_url"] = base_url().'member/plan_list/'.$plan."/";

			$config["total_rows"] = $this->member_model->record_count_member();

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

			//$data($config['per_page'])=3;

			

		if($plan ==""){

		$data['all_data'] = $this->member_model->getAllMemberList($config['per_page'], $start);

		}else{

		

		$data['all_data'] = $this->member_model->getplanMemberList($config['per_page'], $start,$plan);

	

		

		}

	

	   $this->layout->view('list', $lay, $data);	

	}
	
	public function close_user_account(){
		$this->load->helper('wallet');
		$user_id = post('user_id');
		$user_type = post('user_type');
		$wallet_id = get_user_wallet($user_id);
		$wallet_balance = get_wallet_balance($wallet_id); // wallet balance must be > 0 
		
		if($user_type == 'E'){
			// check active project 
			$active_projects = $this->member_model->countActiveProject($user_id);
			$pending_payments = $this->member_model->checkEmployerPendingPayment($user_id);
			
		}else if($user_type == 'F'){
			$active_projects = $this->member_model->countActiveProjectFreelancer($user_id);
			$pending_payments = $this->member_model->checkFreelancerPendingPayment($user_id);
		}
		
		$data['user_id'] = $user_id;
		$data['user_type'] = $user_type;
		$data['wallet_balance'] = $wallet_balance;
		$data['active_projects'] = $active_projects;
		$data['pending_payments'] = $pending_payments;
		
		$this->load->view('close_account', $data);
		
		
	}

	public function delete_user_account_ajax(){
		$json = array();
		$user_id = post('user_id');
		$update = $this->db->where('user_id', $user_id)->update('user', array('status' => 'C'));
		if($update){
			$this->session->set_flashdata('succ_msg', 'User successfully deleted');
		}else{
			$this->session->set_flashdata('error_msg', 'Unable to delete user');
		}
		$json['status'] = 1;
		echo json_encode($json);
		
	}

    



}


