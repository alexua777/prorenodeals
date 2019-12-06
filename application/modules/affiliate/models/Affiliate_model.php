<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class affiliate_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }


	public function login() {

	$this->load->helper('date');

		$i=0;

		

		$username=$this->input->post('username');
		$password=$this->input->post('password');
		if($username==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='username';
			$msg['errors'][$i]['message']="Enter username ";
			$i++;
		}
		if($password==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='password';
			$msg['errors'][$i]['message']="Enter password";
			$i++;
		}

		if($i==0){
			$username = trim($this->input->post("username"));
			$password = $this->input->post("password");
			$response = array();
			$this->db->select('user_id, username,fname,lname, email,ldate,acc_balance');
			$this->db->where("(email = '".$username."' OR username = '".$username."')"); 
			$this->db->where('password',md5($password));
			$this->db->where('status =', 'Y');
			$this->db->where('v_stat =', 'Y');
			$query=$this->db->get('user_affiliate');
			$result = $query->result();
			if ($query->num_rows() == 1) {
				$msg['status'] = "OK";		
				$msg['location'] = VPATH.'affiliate/dashboard';						
				$this->session->set_userdata('user_affiliate', $result);				
				$data = array(
				   'ip' => $_SERVER['REMOTE_ADDR']
				);
				$this->db->set('ldate', 'NOW()', FALSE);
				$this->db->update('user_affiliate', $data); 
				  
			} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'Login failed! wrong username or password or your profile is not activated yet';
			}
		}
	unset($_POST);
	return json_encode($msg);
	}     
	public function updateuser($data,$id,$v_code){
		
		$this->db->where('user_id',$id);
		$this->db->where('MD5(v_code)',$v_code);
		 $a=$this->db->update('user_affiliate',$data);
		 //echo $this->db->last_query();
		return $a;
	}
	public function register() {
	$this->load->helper('date');
	$this->load->library('MY_Validation');
		$i=0;
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$username=$this->input->post('regusername');
		$email=$this->input->post('email');
		$cnfemail=$this->input->post('cnfemail');
		$password=$this->input->post('regpassword');
		$cpassword=$this->input->post('cpassword');
		$captcha=trim(strtolower($this->input->post('captcha'))); 
		if($this->input->post('termsandcondition')!='Y'){
		$msg['status']='FAIL';
			$msg['errors'][$i]['id']='termsandcondition';
			$msg['errors'][$i]['message']="Please check terms and conditions";
			$i++;
	     }
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
			$un=$this->db->count_all_results('user_affiliate');
			if($un>0){
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='regusername';
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
			$em=$this->db->count_all_results('user_affiliate');
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
			$msg['errors'][$i]['message']="Your password must be at least 6 characters and no longer than 12. Password can only contain numbers or letters or both or ',_@+*^' - all other symbols are invalid";
			$i++;
		}elseif($cpassword=='' || $password!=$cpassword){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='cpassword';
			$msg['errors'][$i]['message']="Confirm password not match";
			$i++;
		}
        if (!$this->my_validation->recaptcha_matches()) {
        	$msg['status']='FAIL';
			$msg['errors'][$i]['id']='captcha';
			$msg['errors'][$i]['message']="Captcha is invalid";
			$i++;
    	} 
		if($i==0){
			
				$v_stat='N';
				$status='N';
			
			$ip=$this->input->ip_address();
			$code = uniqid("$ip.", TRUE);
			$codemd5 = md5($code);
			$data = array(
			'username' => $this->input->post('regusername'),
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'password' => md5($password),
			'email' => $this->input->post('email'),
			'country' => $this->input->post('country'),
            'city' => $this->input->post('city'),   
			'v_stat' => $v_stat,
			'v_code' => $code,
			'status' => $status,
			'ip'=>$ip
			);
			$this->db->set('reg_date', 'NOW()', FALSE);
			$this->db->set('edit_date', 'NOW()', FALSE);
			$this->db->set('ldate', 'NOW()', FALSE);
			parent::insert("user_affiliate", $data);
			if ($this->db->insert('user_affiliate', $data)){
			$user_id=$this->db->insert_id();
			$url=SITE_URL."affiliate/index/".base64_encode($user_id)."/".$codemd5;	
			$link=$url;			
			$from=ADMIN_EMAIL;
			$to=$email;
			$template='affiliate_reg';
			$data_parse=array('username'=>$username,
								'password'=>$password,
								'email'=>$email,
								'copy_url'=>$link,
								);
					$msg['status']='OK';
					$msg['message']= 'Registration Successfully';
					$msg['uid']=$user_id;
				if($this->auto_model->send_email($from,$to,$template,$data_parse)){
					$msg['status']='OK';
					$msg['message']='Registration Success.Please check your mail for activation link';					
				}else{
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
	return json_encode($msg);
	}
	public function getuserlist($user_id,$limit = '', $start = ''){
	$this->db->select('user_affiliate_list.reg_date,user_affiliate_list.status,user_affiliate_list.ip,user.fname,user.lname');
	$this->db->join('user','user_affiliate_list.user_id = user.user_id','left');
	$this->db->order_by('user_affiliate_list.id ','desc');
	$this->db->limit($limit, $start);
	$result=$this->db->get_where('user_affiliate_list',array('user_affiliate_list.affiliate_id'=>$user_id));
	$data=array();
	 foreach ($result->result() as $row){ 
	 if($row->status=='Y'){
	 	$status='<font color=green>Active</font>';
	 }else{
	 	$status='<font color=red>Pending</font>';
	 }
            $data[]=array(
               "name" => $row->fname." ".$row->lname,
               "add_date" => $row->reg_date,
               "status"=>$status 
            );
        }
	return $data;
	}
/**
* *********************
* @param Transcation
* 
* @return
*/	
    public function getfilterTransactionCount($user_id,$from,$to){ 
        $this->db->where("user_id",$user_id);
		$this->db->where("transction_date >=",$from);
		$this->db->where("transction_date <=",$to);
		
        $this->db->from('user_affiliate_transaction');
        return $this->db->count_all_results(); 
    }
	public function getTransactionCount($user_id){ 
        $this->db->where("user_id",$user_id);
        $this->db->from('user_affiliate_transaction');
        return $this->db->count_all_results(); 
    }	
	public function getAlldebit($user_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('user_id',$user_id);
		$res=$this->db->get_where('user_affiliate_transaction',array('transction_type'=>'DR'));
		return $res->result();	
	}
	public function getAllcredit($user_id)
	{
		$this->db->select_sum('amount');
		$this->db->where('user_id',$user_id);
		$res=$this->db->get_where('user_affiliate_transaction',array('transction_type'=>'CR'));
		return $res->result();	
	}
	public function filterTransaction($user_id,$from,$to,$limit = '', $start = ''){ 
        $this->db->select("id,amount,transction_type,transaction_for,transction_date,status");
        $this->db->order_by("id","desc");
		$this->db->where('transction_date >=',$from);
		$this->db->where('transction_date <=',$to);
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("user_affiliate_transaction",array("user_id"=>$user_id));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
			   "id" => $row->id,
               
               "amount" =>  $row->amount,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
        return $data;
    }
	public function getTransaction($user_id,$limit = '5', $start = '0'){ 
        $this->db->select("id,amount,transction_type,transaction_for,transction_date,status");
        $this->db->order_by("id","desc");
        $this->db->limit($limit,$start);      
        $res=$this->db->get_where("user_affiliate_transaction",array("user_id"=>$user_id));
        $data=array();
        
        foreach($res->result() as $row){ 
            $data[]=array(
			   "id" => $row->id,
              
               "amount" =>  $row->amount,
               "transction_type" => $row->transction_type,
               "transaction_for" => $row->transaction_for,
               "transction_date"  => $row->transction_date,
               "status" => $row->status
            );
        }
        return $data;
    }    

    public function editprofile() {
    	$user=$this->session->userdata('user_affiliate');
		$user_id=$user[0]->user_id;
		$this->load->helper('date');
		$i=0;
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		if($fname==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='fname';
			$msg['errors'][$i]['message']="Enter your first name";
			$i++;
		}		
		if($lname==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='lname';
			$msg['errors'][$i]['message']="Enter your last name";
			$i++;
		}
		
		
		/**
		* 
		* @var **********************
		* 
		*/
		if($this->input->post('change_pass')){
			 $oldpass=$this->input->post("old_pass");
       		 $newpass=$this->input->post("new_pass");
       		 $confirmpass=$this->input->post("confirm_pass");   
		
		
		if($oldpass==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='old_pass';
			$msg['errors'][$i]['message']="Please Enter Old Password";
			$i++;
		}
                
		if($newpass==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='new_pass';
			$msg['errors'][$i]['message']="Please Enter New Password";
			$i++;
		}
                
		if($confirmpass==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='confirm_pass';
			$msg['errors'][$i]['message']="Please Enter Confirm Password";
			$i++;
		}  

		if($confirmpass!=$newpass){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='confirm_pass';
			$msg['errors'][$i]['message']="Password Missmatch";
			$i++;
		}
		 if($oldpass!=''){
            $con=array(
               "user_id" => $user_id,
               "password" => md5($oldpass) 
            );
                    
            $this->db->select("*");
            $res=$this->db->get_where('user_affiliate',$con);                        
            $c= count($res->result());                      
            if($c==0){ 
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='old_pass';
				$msg['errors'][$i]['message']="Please Enter Correct Password";
				$i++;                           
             }
		}
		
		}


		if($i==0){		
		  	
			$data = array(
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'edit_date' => 'NOW()'
			);
			if($this->input->post('change_pass')){
			$data['password']=md5($newpass);
			}
			$response = array();
			$this->db->where('user_id',$user_id);
			$upd_user=$this->db->update('user_affiliate', $data);
		
			if ($upd_user) {
				$msg['status'] = "OK";				
				$msg['message']= "Your profile has been updated successfuly.";
			} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'Updation Failed';
			}  	
		}
		
	unset($_POST);
	return json_encode($msg);

	}
    /**
	* **********
	* 
	* @return forget password
	*/
	public function check_email() {
		$this->load->helper('date');
		$i=0;
		
		$user_email=$this->input->post('user_email');
		
		
		if($user_email==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='username';
			$msg['errors'][$i]['message']="Enter your email";
			$i++;		
			
		}
		
		
		if($i==0){
		
			$user_email = trim($this->input->post("user_email"));
			
			$response = array();
			$this->db->select('user_id,username');
			$this->db->where("(email = '".$user_email."')"); 
			$this->db->where('status =', 'Y');
			$this->db->where('v_stat =', 'Y');
			$query=$this->db->get('user_affiliate');
			$result = $query->result();
			$ip=$this->input->ip_address();
			$code = uniqid("$ip.", TRUE);
			$codemd5 = md5($code);			
			if ($query->num_rows() == 1) {
				if($this->affiliate_model->updateuser_forget(array('v_code' => $code),$result[0]->user_id)){				
				$nurl=VPATH."affiliate/reset_pass/".base64_encode($result[0]->user_id)."/".$codemd5;			
				$username=$result[0]->username;
				$from=ADMIN_EMAIL;
				$to=$user_email;
				$template='affiliate_forgot_password';
				$data_parse=array('username'=>$username,
								'url'=>$nurl,
								);				
				$this->auto_model->send_email($from,$to,$template,$data_parse);
				$msg['status']='OK';
				$msg['message']='Reset password link is send to your Email-Id.';

				}else{
					$msg['status']='FAIL';
					$msg['errors'][$i]['id']='agree_terms';
					$msg['errors'][$i]['message']= 'failed! This Email Address Is Not Save In Our Database';
					
					}
				} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'failed! This Email Address Is Not Save In Our Database';
			}
       	
		}
		
	unset($_POST);
	echo json_encode($msg);
	}
	
	public function reset_password() {
		$this->load->helper('date');
		$i=0;
		
		$user_pass=$this->input->post('user_pass');
		$conf_pass=$this->input->post('conf_pass');
		
		
		if($user_pass==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='user_pass';
			$msg['errors'][$i]['message']="Enter new password";
			$i++;
		}
		if($conf_pass==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='conf_pass';
			$msg['errors'][$i]['message']="Please confirm your password";
			$i++;
		}
		if($conf_pass!='' && $user_pass!=$conf_pass){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='conf_pass';
			$msg['errors'][$i]['message']="Confirm password doesn't match";
			$i++;
		}
		if($this->input->post('uid')=='' || $this->input->post('v_code')==''){
			$msg['status']='FAIL';			
			$msg['errors'][$i]['id']='agree_terms';
			$msg['errors'][$i]['message']= 'failed! . Please Try Again.';
		}
		if($i==0){
		
			$ndata['password'] = md5($this->input->post("user_pass"));
			$user_id=$this->input->post('uid');
			$v_code=$this->input->post('v_code');
			$response = array();
			$this->db->where('MD5(v_code)',$v_code);
			$this->db->where('user_id', $user_id);
			$query=$this->db->update('user_affiliate',$ndata);
			
			if ($query) {
				
				$username=$this->auto_model->getFeild('username','user_affiliate','user_id',$user_id);
				$user_email=$this->auto_model->getFeild('email','user_affiliate','user_id',$user_id);
				$from=ADMIN_EMAIL;
				$to=$user_email;
				$template='affiliate_reset_password';
				$data_parse=array('username'=>$username,
								);
				
				$this->auto_model->send_email($from,$to,$template,$data_parse);
				$msg['status']='OK';
				$msg['message']='Password Reset Successfully. Please <a href="'.VPATH.'affiliate"><b>Log In</b></a> To Continue.';
				
			   
				} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'failed! d. Please Try Again.';
			}
       	
		}
		
	unset($_POST);
	echo json_encode($msg);
	}
	public function updateuser_forget($data,$id)
	{
		$this->db->where('user_id',$id);
		return $this->db->update('user_affiliate',$data);
	}
/**
	* ************Withdraw Fund 03/06/2015*********
	* 
	* @return
	*/
    public function get_account($uid){
		$this->db->select("*");
        $res=$this->db->get_where("user_bank_account_affiliate",array("user_id"=>$uid));
        $data=array();
        
        if($res->num_rows>0){ 
            foreach($res->result() as $row){ 
                $data[]=array(
                   "account_id" =>$row->account_id,
                   "account_for" =>  $row->account_for,
                   "paypal_account" => $row->paypal_account,
                   "wire_account_no" => $row->wire_account_no,
                   "wire_account_name"  => $row->wire_account_name,
                    "wire_account_IFCI_code"  => $row->wire_account_IFCI_code,
                    "city"  => $row->city,
                    "country"  => $row->country,
                    "address"  => $row->address,
                    "wire_account_email" =>  $row->wire_account_email,
                   "status" => $row->status
                );
            }            
        }
        else{ 
                $data[]=array(
                   "account_id" =>"",
                   "account_for" => "",
                   "paypal_account" => "",
                   "wire_account_no" => "",
                   "wire_account_name"  => "",
                    "wire_account_IFCI_code"  => "",
                    "city"  => "",
                    "country"  => "",
                    "address"  => "",
                    "wire_account_email" =>  "",
                   "status" => ""
                );
        }

        return $data;
	
	
	}
	public function modify_account($data){
	
	
	$this->db->select('account_id');
	$res=$this->db->get_where("user_bank_account_affiliate",array("user_id"=>$data['user_id'],"account_for"=>$data['account_for']));
	
	if($res->num_rows() >0){
		
		
		$acc_id = $res->result();
		
		$this->db->where('account_id', $acc_id[0]->account_id);
        
		return  $this->db->update('user_bank_account_affiliate', $data); 
		
	
		}else{
	
		return $this->db->insert("user_bank_account_affiliate",$data);
	}

	
	}
	 public function add_withdrawl($data){          
        return $this->db->insert("withdrawl_affiliate",$data);
    }
    
	
	 public function add_transation($data){          
        return $this->db->insert("user_affiliate_transaction",$data);
    }
     public function updateUser_data($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
         $this->db->update('user_affiliate', $data); 
    }

}