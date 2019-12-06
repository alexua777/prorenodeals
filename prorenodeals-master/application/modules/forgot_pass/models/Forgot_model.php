<?php 

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Forgot_model extends BaseModel {



    public function __construct() {

	$this->load->library("mailtemplete");

        return parent::__construct();

    }

	

	

	

	

	

	public function check_email() {

		$this->load->helper('date');

		$i=0;

		

		$user_email=strip_tags($this->input->post('user_email'));

		

		

		if($user_email==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='user_email';

			$msg['errors'][$i]['message']=__('forgotpass_enter_your_email','Enter your email');

			$i++;

		}else if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='user_email';

			$msg['errors'][$i]['message']=__('forgotpass_invalid_email','Invalid email format');

			$i++;

		}

		

		

		if($i==0){

		

			$user_email = htmlentities(strip_tags(trim($this->input->post("user_email"))), ENT_QUOTES);

			

			$response = array();

			$this->db->select('user_id,username');

			$this->db->where("(email = '".$user_email."')"); 

			$this->db->where('status =', 'Y');

			$this->db->where('v_stat =', 'Y');

			$query=$this->db->get('user');

			$result = $query->result();
			
			if ($query->num_rows() == 1) {
				
				$token = md5(time().'-PRORENODEALS@FORGET!PASSWORD##-'.$result[0]->user_id);				
				$this->db->where('user_id', $result[0]->user_id)->update('user', array('token' => $token));
				$nurl=VPATH."forgot_pass/reset_pass/".$token;
				
				$username=$result[0]->username;

				$from=ADMIN_EMAIL;

				$to=$user_email;

				$template='forgot_password';

				$data_parse=array('username'=>$username,

								'url'=>$nurl,

								);

				

				/*$this->auto_model->send_email($from,$to,$template,$data_parse);*/
				send_layout_mail($template, $data_parse, $to);

				$msg['status']='OK';

				$msg['message']=__('forgotpass_new_password_has_been_sent_to_your_email','New password was sent to your email.');

				

			   

				} else {

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='agree_terms';

				$msg['errors'][$i]['message']= __('forgotpass_sorry_email_address_is_not_found_in_db','Sorry! This email address was not found in our database');

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

			$msg['errors'][$i]['message']=__('forgotpass_enter_new_password','Enter new password');

			$i++;

		}

		if($conf_pass==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='conf_pass';

			$msg['errors'][$i]['message']=__('forgotpass_please_confirm_your_password','Please confirm your password');

			$i++;

		}

		if($conf_pass!='' && $user_pass!=$conf_pass){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='conf_pass';

			$msg['errors'][$i]['message']=__('forgotpass_confirm_password_does_not_match','Confirm password doesn\'t match');

			$i++;

		}

		

		

		if($i==0){

		

			$ndata['password'] = md5($this->input->post("user_pass"));

			$user_id=$this->input->post('uid');

			$response = array();

			$this->db->where('user_id', $user_id);

			$query=$this->db->update('user',$ndata);

			

			if ($query) {

				

				$username=$this->auto_model->getFeild('username','user','user_id',$user_id);

				$user_email=$this->auto_model->getFeild('email','user','user_id',$user_id);

				$from=ADMIN_EMAIL;

				$to=$user_email;

				$template='reset_password';

				$data_parse=array('username'=>$username,

								);

				

				/* $this->auto_model->send_email($from,$to,$template,$data_parse); */
				send_layout_mail($template, $data_parse, $to);

				$msg['status']='OK';

				$msg['message']=__('forgotpass_password_reset_successful','Password Reset Successfully.').__('forgotpass_please','Please').' <a href="'.VPATH.'/login"><b>'.__('forgotpass_login_in','Log In').'</b></a>'.__('forgotpass_to_continue','To Continue.');

				

			   

				} else {

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='agree_terms';

				$msg['errors'][$i]['message']= __('forgotpass_failed_database_error_occured_please_try_again','failed! Database Error Occured. Please Try Again.');

			}

       	

		}

		

	unset($_POST);

	echo json_encode($msg);

	}

	public function updateuser($data,$id)

	{

		$this->db->where('user_id',$id);

		return $this->db->update('user',$data);

	}

}

?>