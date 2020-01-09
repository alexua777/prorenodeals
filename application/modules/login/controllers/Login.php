<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Login extends MX_Controller {



    /**

     * Description: this used for check the user is exsts or not if exists then it redirect to this site

     * Paremete: username and password 

     */

    public function __construct() {


		$this->load->helper('captcha');
       // $this->load->helper('recaptcha');
        $this->load->model('login_model');
		$this->load->model('membership/membership_model');
		$this->load->model('signup/signup_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('login', $idiom);
        parent::__construct();

    }



    public function index() {
	$user = $this->session->userdata('user');
	if($user){
		redirect(base_url('dashboard'));
		/* redirect(base_url('jobfeed')); */
	}
	if($this->uri->segment(3)){

		/*$uid=base64_decode($this->uri->segment(3));*/
		$token = $this->uri->segment(3);
		$new_data['status']='Y';
		$this->db->select('user_id,account_type');
		$this->db->where('email_verification_link',$token);
		$result=$this->db->get('user')->row();
		if($result->account_type=='E'){
			$new_data['verify']='Y';
		}else{
			$new_data['verify']='N';
		}
		$new_data['email_verified']='Y';

		$new_data['v_stat']='Y';
		$new_data['email_verification_link']='';
		$update = $this->db->where('email_verification_link', $token)->update('user', $new_data);
		/* if($this->login_model->updateuser($new_data,$uid)){
			$this->session->set_flashdata('refer_succ_msg','Account varified');
			redirect(VPATH.'login');
		}else{
		$this->session->set_flashdata('log_eror','Account varified failed ');
			redirect(VPATH.'login');
		} */
		
		if($update){
			$this->session->set_flashdata('refer_succ_msg','Account verified');
			redirect(VPATH.'login');
		}else{
			$this->session->set_flashdata('log_eror','Account verified failed ');
			redirect(VPATH.'login');
		}
		

	}

	$breadcrumb=array(

					array(

						'title'=>'Login','path'=>''

					)

				);

	$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Login');

	$head['current_page']='login';
	
	$head['ad_page']='login';

	$load_extra=array();

	$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

	$this->layout->set_assest($head);

	$table='contents';

	$by="cms_unique_title";

	$val='login';
	
	$data['refer']=$this->input->get('refer');

	$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
	$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
	$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
	$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
	/*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

        $data['country']=$this->autoload_model->getCountry();
        
        $data['state']=$this->autoload_model->getCity("NGA");
        
        
	$this->autoload_model->getsitemetasetting("meta","pagename","Login");

	$lay['client_testimonial']="inc/footerclient_logo";

	$this->layout->view('login',$lay,$data,'normal');

	

    }
	
		public function testTrns() {	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://192.168.0.129/joomla/index.php?option=com_banners&task=test");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, true);
		$data = curl_exec($ch);
		print_r($data);
	 }

	public function check() {

	$this->auto_model->checkrequestajax();
	 if($this->input->post()){
		
	  $post_data = $this->input->post();
		  $insert = $this->login_model->login($post_data);

		 

	 }

	

    }
	public function create_captcha()
	{
		$text=$this->GetCaptchaText();
		$vals = array(
		'word'=>$text,
                'img_path'	=> 'assets/captcha/',
                'img_url'	=> VPATH.'assets/captcha/',
                'font_path'=> 'assets/fonts/ftltlt.ttf',
                'img_width'	=> '200',
                'img_height' => '60'
		 );

		$cap = create_captcha($vals);
	
		$this->session->set_userdata('captcha_word',$cap['word']);
		echo $cap['image'];
   
    	//$word= $cap['word'];
		//return $captcha;	
	}
	function GetCaptchaText() {
            $text = $this->GetRandomCaptchaText();
        return $text;
    }






    /**
     * Random text generation
     *
     * @return string Text
     */
    function GetRandomCaptchaText($length = null) {
        if (empty($length)) {
            $length = rand(5, 8);
        }

        $words  = "abcdefghijlmnopqrstvwyz";
        $vocals = "aeiou";

        $text  = "";
        $vocal = rand(0, 1);
        for ($i=0; $i<$length; $i++) {
            if ($vocal) {
                $text .= substr($vocals, mt_rand(0, 4), 1);
            } else {
                $text .= substr($words, mt_rand(0, 22), 1);
            }
            $vocal = !$vocal;
        }
        return $text;
    }


	public function fblogin()
	{
        $fb_config = array(
            'appId'  => YOUR_APP_ID,
            'secret' => YOUR_APP_SECRET
        );

        $this->load->library('facebook', $fb_config);
		
		$login_url = $this->facebook->getLoginUrl();
		
		$user = $this->facebook->getUser();
		if(!$user)
		{
		
			header('Location:'.$login_url);
		}

		
        if ($user) {
            try {
                $user_profile= $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }
      	
	   if($user)
	   {
		
			$exist_user=$this->login_model->checkUser($user_email);
			
			if($exist_user)
			{
				$log=$this->login_model->loginUser($user_email);
				echo "<script>window.location.href='".VPATH."dashboard/'</script>";	
			}
			else
			{
				$signup=$this->signup_model->socialSignup($user_profile);
				if($signup)
				{
					$this->login_model->loginUser($user_email);
					echo "<script>window.location.href='".VPATH."dashboard/'</script>";	
				}	
			}	   
	   }
    }
    
	public function getcity($country='')
	{
		$country_code=$country;
		$state=	$this->autoload_model->getCity($country_code);
		?>
		<option value=""><?php echo __('login_select_one_city','Select one city'); ?></option>
      
		<?php 
          foreach($state as $c){ 
        ?>
          <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
        <?php
          } 
	}

	

}

