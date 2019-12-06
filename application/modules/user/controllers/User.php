<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
		
        $this->load->model('user_model');
        $this->load->library("mailtemplete");
		$this->load->library('user_agent');
       
		$idiom = $this->session->userdata('lang');
		$this->lang->load('home', $idiom);
        parent::__construct();
    }

    public function index() {
		
        /*if($this->session->userdata('user')){ 
            redirect(VPATH."dashboard");
        }*/
	
    $head['site_info']=$this->autoload_model->getsitemetasetting("meta","pagename","Home");
	$head['current_page']='home';
	$head['ad_page']='home';
	$load_extra=array();
	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	$this->layout->set_assest($head);
	if($this->agent->mobile()){
		$m='M';
	$data['banner']=$this->user_model->getBanner($m);
	}else{
		$m='D';
		$data['banner']=$this->user_model->getBanner($m);
	}
	//$m='D';
	//$data['banner']=$this->user_model->getBanner($m);
	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
	$skill_no=$this->auto_model->getFeild('skill_no','pagesetup','id','1');
	$catagory_no=$this->auto_model->getFeild('catagories','pagesetup','id','1');
	$testimonial_no=$this->auto_model->getFeild('testimonial_no','pagesetup','id','1');
	$data['skills']=$this->user_model->getSkills($skill_no);
	$data['categories']=$this->user_model->getCatagories($skill_no);
	$data['testimonials']=$this->user_model->getTestimonials($testimonial_no);
	$data['mem_plans'] = $this->user_model->getPlans();
	$data['partner'] = $this->user_model->getPartners();
	
	/* $data['catagories']=$this->user_model->getCatagories($catagory_no); */
	foreach($data['catagories'] as $k =>$v){
		$data['count_project'][$v['id']]=$this->user_model->count_project($v['id']);
	}
	
	$data['top_skill']=$this->user_model->get_top_skills($catagory_no);
	foreach($data['top_skill'] as $k =>$v){
		$data['count_project_top_skill'][$v['id']]=$this->user_model->count_project_top_skill($v['id']);
	}
		
	$lay['client_testimonial']="inc/footerclient_logo";
	//echo '<pre>'; print_r($data). die();
	$data['featured_users'] = $this->user_model->get_featured_users(4);
	$data['featured_projects'] = $this->user_model->get_featured_projects(6);

	$this->layout->view('home',$lay,$data,'normal');   
    }

	public function set_account_type($token=''){
		$data['token'] = $token;
		$this->load->view('set_account_type',$data);
	}
	
	public function acc_type_update(){
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data = $json = array();
		$token = post('token');
		if(post() && $user_id && !empty($token)){
			$data = post();
			$count = $this->db->where('token', $token)->get('user')->row_array();
			if($count['user_id'] == $user_id){
				$upd = $this->user_model->acc_type_update_model($data);
			}
			
			if($upd){
				$user[0]->account_type = post('acc_type');
				
				$this->session->unset_userdata('user');
				$this->session->set_userdata('user', $user);
				$json['status'] = 1;
				$json['next'] = base_url('dashboard');
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
		}
	}
	
    public function is_login() {
        $user_id = $this->session->userdata('fab_user_id');
        if (isset($user_id) AND $user_id != '' AND $user_id != 0) {
            redirect(base_url() . 'dashboard');
        }
    }

    public function login() {
		
		
		$data['welcome']=$this->user_model->getWelcome();   
		$data['service']= $this->user_model->getService();
		$data['gallary']= $this->user_model->getGallary();
		$data['event']= $this->user_model->getEvent();
		$data['banner']= $this->user_model->getBanner();
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
		//echo "<pre>";print_r($data);die;
        if ($this->input->post('login')) {
            $this->load->helper('cookie');

            $data['email'] = $this->input->post('email');
            $data['pwd'] = $this->input->post('password');
           


            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

            if ($this->form_validation->run() == FALSE) {
				
        		$this->layout->view('home', '', $data, 'normal');
            } else {
                echo $userid = $this->user_model->login($data);
				die();
                if ($userid AND ($userid != 0 OR $userid != '')) {
                    $this->session->set_userdata('user_id', $userid);
					redirect(base_url());
                } else {
                    $this->session->set_flashdata('error_msg', "Email or Password didn't match");
                    //$this->layout->view('login', '', $data2, 'blank');
                    redirect(base_url());
                }
            }
        } else {
            $this->layout->view('home', '', $data, 'normal');
        }
    }

    public function fblogin() {

        $country = 0;
        $state = 0;
        $city = 0;
        $country_id = 0;
        $state_id = 0;
        $city_id = 0;

        $this->load->library('facebook_login');

        $cookie = $this->facebook_login->get_facebook_cookie(YOUR_APP_ID, YOUR_APP_SECRET);


        $user = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token=' . $cookie['access_token']));
        @$picture = 'https://graph.facebook.com/' . $user->id . '/picture?type=large';

        $token = $cookie['access_token'];
        if ($cookie['access_token'] == "") {
            $user = "";
        }


        if ($token) {
            $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=" . $token;
            $result = json_decode(@file_get_contents($graph_url));

            delete_cookie($_COOKIE['fbsr_' . YOUR_APP_ID], '', '0');
            unset($_COOKIE['fbsr_' . YOUR_APP_ID]);
        }
        delete_cookie('fbsr_' . YOUR_APP_ID, '', '0');

        if ($user) {
            $hometown = @$user->hometown;

            $homeaddress = @$hometown->name;
            $addressArray = @explode(',', $homeaddress);

            if (count($addressArray) > 1) {
                if (isset($addressArray[2])) {
                    $country = trim($addressArray[2], ' ');
                }
                if (isset($addressArray[1])) {
                    $state = trim($addressArray[1], ' ');
                }
                if (isset($addressArray[0])) {
                    $city = trim($addressArray[0], ' ');
                }
            }

            $country_id = $this->auto_model->getFeild("id", "countries", "c_name", $country);
            $state_id = $this->auto_model->getFeild("id", "state", "state_name", $state);
            $city_id = $this->auto_model->getFeild("id", "city", "city_name", $city);

            $data['user_name'] = $user->username;
            $data['full_name'] = $user->first_name . ' ' . $user->last_name;
            $data['email'] = $user->email;
            $data['user_img'] = $picture;
            $data['country'] = $country_id;
            $data['state'] = $state_id;
            $data['city'] = $city_id;
            $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['active_status'] = 'Y';
            $data['status'] = 'Y';
            $data['create_date'] = date('Y-m-d');
            $data['user_type'] = 'S';

            $exst_email = $this->auto_model->getFeild("email", "user", "email", $data['email']);
            $exst_blank_pwd = $this->auto_model->getFeild("pwd", "user", "email", $data['email']);
            $id = $this->auto_model->getFeild("id", "user", "email", $data['email']);

            if ($id != '' AND $exst_email != '' AND $exst_blank_pwd == '') {
                $this->session->set_userdata('fab_user_id', $id);
                delete_cookie('fbsr_' . YOUR_APP_ID, '', '0');
                redirect(base_url() . 'dashboard');
            }


            $user_id = $this->user_model->fb_registration($data);

            if (isset($user_id) AND $user_id != 0) {
                $this->user_model->fb_auth($user_id, $token);
                $this->session->set_userdata('fab_user_id', $user_id);
                delete_cookie('fbsr_' . YOUR_APP_ID, '', '0');
                redirect(base_url() . "dashboard/");
            } else {
                unset($_COOKIE['fbsr_' . YOUR_APP_ID]);
                delete_cookie('fbsr_' . YOUR_APP_ID, '', '0');
                redirect(base_url() . "user/fblogin");
            }
        }//user if
    }

    public function signup() {
		
		$data['country']=$this ->user_model->getCountry();
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
        if ($this->input->post('signup'))
		 {
		 	//print_r($_POST); die();
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]|matches[cemail]');
			$this->form_validation->set_rules('cemail', 'Confirm Email','required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[cpassword]');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|min_length[10]|numeric');
            $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('address1', 'Address Line 1', 'required');
			$this->form_validation->set_rules('dob', 'Date of Birth', 'required');

            if ($this->form_validation->run() === FALSE) 
			{
                $this->layout->view('register', '', $data, 'normal');
            } else 
			{
                $user_id = $this->user_model->register();
				if($user_id)
				{
				$email=$this->input->post('email');
				$first_name=$this->input->post('first_name');
				$last_name=$this->input->post('last_name');
				$password=$this->input->post('password');
	
				$data['new_data'] = array(
				'fname' => $this->input->post('first_name'),
        		'lname' => $this->input->post('last_name'),
            	'email' => $this->input->post('email')
				);
				
				$param = array(
                    "{name}" => $first_name,
					"{email}" => $email,
                    "{password}" => $password
                );
				$contact = $this->auto_model->get_setting();
                $ml=$this->mailtemplete->send_mail($from = $contact[0]['admin_mail'], $email, 'AfterRegistration', $param);
					$this->layout->view('registersuccess', '', $data, 'normal');
					
                } else {
                    $data['error']='Unable to Register';
					$this->layout->view('register', '', $data, 'normal');
                }
            }
        }
		else
        {
            $this->layout->view('register', '', $data, 'normal');
        }
    }

    public function forgot_password() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() === FALSE) {
            $this->layout->view('forgot_pass', '', '', 'normal');
        } else {

            $email_exst = $this->auto_model->getFeild('email', 'users', 'email', $this->input->post('email'));

            if ($email_exst == '') {
                $this->session->set_flashdata('error_msg', 'Your email id is not registered');
                redirect(base_url(). 'user/forgot_password/');
            }
            $new_pwd = rand(200000, 900000);
            $pwd_changed = $this->user_model->random_password($email_exst, $new_pwd);

            if ($pwd_changed) {
                $param = array(
                    "{name}" => $this->auto_model->getFeild('fname', 'users', 'email', $this->input->post('email')),
                    "{password}" => $new_pwd
                );
				$contact = $this->auto_model->get_setting();
                $ml=$this->mailtemplete->send_mail($from = $contact[0]['admin_mail'], $email_exst, 'user_forgot_password', $param);
				
				$this->session->set_flashdata('succ_msg', 'A new password has been emailed to you');
                redirect(base_url(). 'user/forgot_password/');
            } else {
                $this->session->set_flashdata('error_msg', 'Your account currently disabled');
                redirect(base_url(). 'user/forgot_password/');
            }
        }
    }

    public function register() {
        if ($this->input->post('submit')) {
            $result = $this->user_model->register();
            echo json_encode($result);
            return;
        }
        $param = "";
        $this->load->view('register', $param);
    }

    public function logout() {
		$lang=$this->session->userdata('lang');
        $this->session->unset_userdata('user_id');
        $this->session->sess_destroy();
		$this->session->set_userdata('lang', $lang);
		//$lang1=$this->session->userdata('lang');
        redirect(base_url());
    }
	public function profile()
	{
		if($this->session->userdata('user_id'))
		{
		$data['all_data']=$this->user_model->getUser();
		$this->layout->view('profile','',$data,'us');
		}
		else
		{
			redirect(base_url().'login/');
		}
	}
	public function editprofile()
	{
		$id=$this->uri->segment(3);
		$data['all_data']=$this->user_model->getUserbyId($id);
		$data['country']=$this->user_model->getCountry();
		if($this->input->post())
		{
			$this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|matches[cemail]');
			$this->form_validation->set_rules('cemail', 'Confirm Email','required|valid_email');
			$this->form_validation->set_rules('phone', 'Phone number', 'required|min_length[10]|numeric');
            $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('country', 'Country', 'required');
			$this->form_validation->set_rules('address1', 'Address Line 1', 'required');
            if ($this->form_validation->run() === FALSE) 
			{
                $this->layout->view('editprofile', '', $data, 'us');
            } else 
			{
                $user_id = $this->user_model->editUser($id);
				if($user_id)
				{
					$this->session->set_flashdata('succ_msg', 'Your profile updated successfuly!!');
					redirect(base_url().'user/editprofile/'.$id.'/');
					
                } else {
                    $this->session->set_flashdata('error_msg', 'Updation failed!!');
    				redirect(base_url().'user/editprofile/'.$id.'/');
                }
            }

		
		}
		else
		{
			$this->layout->view('editprofile','',$data,'us');
		}
	}
	public function uploadphoto()
	{
		$id=$this->uri->segment(3);
		//die();
		$image="";
		$config['upload_path'] = 'assets/user_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$uploaded = $this->upload->do_upload();
		$upload_data = $this->upload->data();
		$image = $upload_data['file_name'];
		$configs['image_library'] = 'gd2';
		$configs['source_image']	= 'assets/user_image/'.$image;
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
		if (!$uploaded AND $image != '')
		{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error_msg', $error['error']);
				redirect(base_url() . 'user/profile/');
		}
		$post_data['image'] = $image;
		//print_r($post_data);die();
		$update = $this->user_model->updatemember($post_data,$id);
		if($update)
		{
			//echo FCPATH; die();
			if($this->input->post('curimg')!='')
			{
				$img=explode(".",$this->input->post('curimg'));
				$nm=$img[0];
				$ext=end($img);
				$newnm=str_replace("_thumb", "", $nm);
				$newnm=$newnm.".".$ext;
				unlink('assets/user_image/'.$this->input->post('curimg'));
				unlink('assets/user_image/'.$newnm);
			}
			$this->session->set_flashdata('succ_msg', 'User Updated Successfully');
		}
		redirect(base_url() . 'user/profile/');
	}
	
	public function addproduct()
	{
		$data['company']=$this->user_model->getCompany();
		if($this->input->post())
		{			
            $this->form_validation->set_rules('name', 'Product Name', 'required');
            $this->form_validation->set_rules('company', 'Company Name', 'required');
			$this->form_validation->set_rules('batch', 'Model/batch No', 'required');
			$this->form_validation->set_rules('product_no', 'Product No', 'required|is_unique[product.product_no]');
			$this->form_validation->set_rules('mdate', 'Manufacture Date', 'required');
			$this->form_validation->set_rules('edate', 'Expire Date', 'required');
			$this->form_validation->set_rules('nafdac', 'NAFDAC No', 'required');
			$this->form_validation->set_rules('phone', 'Contact Number', 'required|numeric|min_length[10]');
			$this->form_validation->set_rules('email', 'Email Id', 'required|valid_email');
            if ($this->form_validation->run() == FALSE) 
			{
                $this->layout->view('addproduct','',$data,'us');
            } 
			else 
			{
				//echo "pritam"; die();
				$post_data['user_id'] = $this->session->userdata('user_id');
				$post_data['product_name'] = $this->input->post('name');
				$post_data['comp_id'] =$this->input->post('company');
				$post_data['model_no'] =$this->input->post('batch');
				$post_data['product_no'] =$this->input->post('product_no');
				$post_data['manufacture_date'] =$this->input->post('mdate');
				$post_data['expire_date'] =$this->input->post('edate');
				$post_data['nafdac_no'] =$this->input->post('nafdac');
				$post_data['phone'] =$this->input->post('phone');
				$post_data['email'] =$this->input->post('email');
				$post_data['status'] = 'N';
				//print_r($post_data); die();
                $insert_company = $this->user_model->add_product($post_data);
                if ($insert_company) {
                    $this->session->set_flashdata('succ_msg', 'Product Inserted Successfully');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }
                 redirect(base_url() . 'user/addproduct/');
            }
		}
		else
		{
			$this->layout->view('addproduct','',$data,'us');
		}
	}
	public function productlist()
	{
		$data['all_data'] = $this->user_model->getAllProductList();
		$this->layout->view('productlist','',$data,'us');
	}
	public function changepassword()
	{
		$this->layout->view('changepass','','','us');
	}
	
	public function usertransfer()
	{
		$ret = "sent data";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://192.168.0.129/joomla/index.php?option=com_usertransfer&view=default&task=transferuser");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ret);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$users = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);
		$newusers = json_decode($users);
		$this->user_model->transferdatafromjoomlatocodingniter($newusers);
	}
	public function newsletterSubscription(){ 
	  if($this->input->post("email")==""){ 
			echo 0;
	  }else{ 
			$email=$this->input->post("email");
			
			$cnt=$this->auto_model->getFeild('users_id','news_users','email_address',$email);
			$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
			if(!preg_match($regex, $email)){
				echo 4;
			}else{
				if($cnt==''){
					 $data=array(
					   "email_address" => $email,
					   "signup_date" => time(),
					   "group_id" => "2"
					 );
				 
					$insert=$this->auto_model->insert_data("news_users",$data);
					if($insert){ 
					  echo 1;
					}
					else{ 
					  echo 2;
					}
				}else{
					echo 3;	 
				}
			}
		}
	} 
	
	public function pdf(){
		$data = array();
		$this->load->view('pdf_html', $data);
	}
	
	public function changeLanguage(){
		$lang = $this->input->post('language');
		$this->session->unset_userdata('lang');
		$res['status']=0;
		if($lang){
		 $this->session->set_userdata('lang', $lang);
		 $res['status']=1;
		}
		
		
		echo json_encode($res);
	}
	
	public function migrate(){
		
		$except = array('demoemployer,demoemployee1,demoemployee2');
		$users = $this->db->select('user_id,username')->get('user')->result_array();
		if($users){
			foreach($users as $k => $v){
				$u_key = $k + 1;
				$update = array(
					'fname' => 'Demo',
					'lname' => 'User '.$u_key,
					'email' => 'demouser'.$u_key.'@gmail.com',
					'username' => 'demouser'.$u_key,
				
				);
				
				if(in_array($v['username'], $except)){
					continue;
				}
				
				$this->db->where('user_id', $v['user_id'])->update('user', $update);
			}
		}
		
	}
	
	/* Date : 11.07.19 */
	
	public function skill_list(){
		$data = array();
		/* $data['skills'] = $this->user_model->get_all_skills(); */
		$data['categories'] = $this->user_model->get_all_catagories();
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('skill_list',$lay,$data,'normal');
	}
}
