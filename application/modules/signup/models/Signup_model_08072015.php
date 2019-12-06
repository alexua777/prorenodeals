<?php







if (!defined('BASEPATH'))



    exit('No direct script access allowed');







class signup_model extends BaseModel {







    public function __construct() {



        return parent::__construct();



    }















	public function register() {



	$this->load->helper('date');



	 $this->load->library('MY_Validation');



	 //$this->load->library('form_validation');



     $this->load->helper('recaptcha');



        



		$i=0;



		$fname=$this->input->post('fname');



		$lname=$this->input->post('lname');



		$username=$this->input->post('regusername');



		$email=$this->input->post('email');



		$cnfemail=$this->input->post('cnfemail');



		$password=$this->input->post('regpassword');



		$cpassword=$this->input->post('cpassword');



                $country=$this->input->post('country');



                $city=$this->input->post('city');



                



		$captcha=trim(strtolower($this->input->post('captcha'))); 



		if($fname==''){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='fname';



			$msg['errors'][$i]['message']="Please enter first name";



			$i++;



		}



		if($lname==''){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='lname';



			$msg['errors'][$i]['message']="Please enter last name";



			$i++;



		}



		if($username=='' || strlen($username)<4 || strlen($username)>20 || !preg_match('/^[a-zA-Z0-9]+$/',$username)){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='regusername';



			$msg['errors'][$i]['message']="Username must be 4 to 20 characters, only letters and/or numbers";



			$i++;



		}else{



			$this->db->where("username",$username);



			$un=$this->db->count_all_results('user');



			if($un>0){



				$msg['status']='FAIL';



				$msg['errors'][$i]['id']='username';



				$msg['errors'][$i]['message']='The username you are trying to use already exists please try again';



				$i++;



			}



		}



		if($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='email';



			$msg['errors'][$i]['message']="Please type email address";



			$i++;



		}elseif($cnfemail=='' || $email!=$cnfemail){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='cnfemail';



			$msg['errors'][$i]['message']="Confirm email not match";



			$i++;



		}



		else{



			$this->db->where("email",$email);



			$em=$this->db->count_all_results('user');



			if($em>0){



				$msg['status']='FAIL';



				$msg['errors'][$i]['id']='email';



				$msg['errors'][$i]['message']= "This email is already in use. Please enter a different one";



				$i++;



			}



		}



		if($password=='' || strlen($password)<6 || strlen($password)>12 || !preg_match('/^[a-zA-Z0-9,_@+*^]+$/',$password)){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='regpassword';



			$msg['errors'][$i]['message']="Your password must be at least 6 characters and no longer than 12. Password can only contain numbers or letters or both or ',_@+*^' all other symbols are invalid";



			$i++;



		}elseif($cpassword=='' || $password!=$cpassword){



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='cpassword';



			$msg['errors'][$i]['message']="Confirm password not match";



			$i++;



		}



                if($country==""){ 



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='country';



			$msg['errors'][$i]['message']="Select Your Country";



			$i++;                    



                }



		if($country==""){ 



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='country';



			$msg['errors'][$i]['message']="Select Your Country";



			$i++;                    



             }



		if($city==""){ 



			$msg['status']='FAIL';



			$msg['errors'][$i]['id']='city';



			$msg['errors'][$i]['message']="Select Your city";



			$i++;                    



             }



		/*if (!$this->my_validation->recaptcha_matches()) {



        	$msg['status']='FAIL';



			$msg['errors'][$i]['id']='captcha';



			$msg['errors'][$i]['message']="Captcha is invalid";



			$i++;



    	}*/



		



		if($i==0){



			if(EMAIL_VERI=='N')



			{



				$v_stat='Y';



				$status='N';



			}



			else



			{



				$v_stat='N';



				$status='N';



			}



			$data = array(



			'username' => $this->input->post('regusername'),



			'fname' => $this->input->post('fname'),



			'lname' => $this->input->post('lname'),



			'password' => md5($password),



			'email' => $this->input->post('email'),



			'country' => $this->input->post('country'),



            'city' => $this->input->post('city'),   



			'v_stat' => $v_stat,



			'status' => $status,

			'verify' =>'N',

			'membership_plan' => '1',



			'membership_start' => date("Y-m-d"),                           



			'ip'=>$_SERVER['REMOTE_ADDR']



			);



                        



			$this->db->set('reg_date', 'NOW()', FALSE);



			$this->db->set('edit_date', 'NOW()', FALSE);



			$this->db->set('ldate', 'NOW()', FALSE);



			parent::insert("user", $data);



			if ($this->db->insert('user', $data)) 



			{



			



			$user_id=$this->db->insert_id();
			/**
			* 
			* @var ******************************
			* 
			*/
			if($this->session->userdata('user_affiliate_set')){
				
				$affiliate_data=array(
									'user_id'=>$user_id,
									'affiliate_id'=>$this->session->userdata('user_affiliate_set'),
									'email'=>$this->input->post('email'),
									'reg_date'=>date('Y-m-d H:i:s'),
									'status'=>'N',
									'ip'=>$this->input->ip_address()
				);
				$this->db->insert('user_affiliate_list',$affiliate_data);
				
				
			}
			/**
			* 
			* @var ***********************
			* 
			*/


			$url=SITE_URL."login/index/".base64_encode($user_id);



			if(EMAIL_VERI=='Y')



			{



				$link=$url;



			}else



			{



				$link=SITE_URL."login/";



			}



			$from=ADMIN_EMAIL;



                        



			$to=$email;



			$template='registration';



			$data_parse=array('username'=>$username,



								'password'=>$password,



								'email'=>$email,



								'copy_url'=>$link,



								'url_link'=>$link



								);



					$msg['status']='OK';



					$msg['message']= 'Registration Successfully';



					$msg['uid']=$user_id;



				if($this->auto_model->send_email($from,$to,$template,$data_parse))



				{



			



					$msg['status']='OK';



					if(EMAIL_VERI=='Y')



					{



						$msg['message']='Registration Success.Please check your mail for activation link';



					}



					else{



						$msg['message']='Registration Success.Please check your mail';



					}



				}else



				{



					$msg['status']='OK';



					$msg['message']='Registration Success. Mail sending fail';



				}



				



			



			} else {



				$msg['status']='FAIL';



				$msg['errors'][$i]['id']='agree_terms';



				$msg['errors'][$i]['message']= 'dB error!';



			}



		}



	unset($_POST);



	echo json_encode($msg);



	}



	public function getCountry()



	{



		$this->db->select('name');



		$this->db->order_by('name');



		$res=$this->db->get('countries');



		$data=array();



		foreach($res->result() as $row)



		{



			$data[]=array(



			'name'=>$row->name



			);



		}



		return $data;



	}



        



	public function getCity()



	{



		$this->db->select('city');



                $this->db->group_by('city');                



		$this->db->order_by('city');



		$res=$this->db->get('cities');



		$data=array();



		foreach($res->result() as $row)



		{



			$data[]=array(



			'city'=>$row->city



			);



		}



		return $data;



	} 



		



	public function socialSignup($user_profile)



	{



			/*echo "<pre>";



			print_r($user_profile);die();*/



			$v_stat='Y';



			$status='Y';



			//$country=end(explode(",",$user_profile['location']['name']));



			$data = array(



			'username' => strtolower($user_profile['first_name'].$user_profile['last_name']),



			'fname' => $user_profile['first_name'],



			'lname' => $user_profile['last_name'],



			'password' => md5('123456'),



			'email' => $user_profile['email'],



			'v_stat' => $v_stat,



			'status' => $status,



            'membership_plan' => '1',



            'membership_start' => date("Y-m-d"),                           



			'ip'=>$_SERVER['REMOTE_ADDR']



			);



			$this->db->set('reg_date', 'NOW()', FALSE);



			$this->db->set('edit_date', 'NOW()', FALSE);



			$this->db->set('ldate', 'NOW()', FALSE);



			parent::insert("user", $data);



			if ($this->db->insert('user', $data)) 



			{



			$user_id=$this->db->insert_id();



			$url=SITE_URL."login/";



			$link=$url;



			



			$from=ADMIN_EMAIL;



			$to=$user_profile['email'];



			$template='registration';



			$data_parse=array('username'=>strtolower($user_profile['first_name'].$user_profile['last_name']),



								'password'=>'123456',



								'email'=>$user_profile['email'],



								'copy_url'=>$link,



								'url_link'=>$link



								);



			$this->auto_model->send_email($from,$to,$template,$data_parse);



			return true;



			}



					



	} 



	public function linkedinSignup($user_profile)



	{



			



			$v_stat='Y';



			$status='Y';



			$data = array(



			'username' => strtolower($user_profile['first_name'].$user_profile['second_name']),



			'fname' => $user_profile['first_name'],



			'lname' => $user_profile['second_name'],



			'password' => md5('123456'),



			'email' => $user_profile['email-address'],



			'v_stat' => $v_stat,



			'status' => $status,



            'membership_plan' => '1',



            'membership_start' => date("Y-m-d"),                           



			'ip'=>$_SERVER['REMOTE_ADDR']



			);



			$this->db->set('reg_date', 'NOW()', FALSE);



			$this->db->set('edit_date', 'NOW()', FALSE);



			$this->db->set('ldate', 'NOW()', FALSE);



			parent::insert("user", $data);



			if ($this->db->insert('user', $data)) 



			{



			$user_id=$this->db->insert_id();



			$url=SITE_URL."login/";



			$link=$url;



			



			$from=ADMIN_EMAIL;



			$to=$user_profile['email-address'];



			$template='registration';



			$data_parse=array('username'=>strtolower($user_profile['first_name'].$user_profile['second_name']),



								'password'=>'123456',



								'email'=>$user_profile['email-address'],



								'copy_url'=>$link,



								'url_link'=>$link



								);



			$this->auto_model->send_email($from,$to,$template,$data_parse);



			return true;



			}



					



	}     



        



}