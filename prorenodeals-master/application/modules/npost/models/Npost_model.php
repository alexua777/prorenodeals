<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Npost_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
	
	public function login() {
	$this->load->helper('date');
		$i=0;
		
		$username=$this->input->post('username');
		//$email=$this->input->post('email');
		$password=$this->input->post('password');
		
		
		if($username==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='username';
			$msg['errors'][$i]['message']="Enter username or email";
			$i++;
		}
		
		if($password==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='password';
			$msg['errors'][$i]['message']="Enter password";
			$i++;
		}
		if(!preg_match('/^[a-zA-Z0-9]+$/',$password) || !preg_match('/^[a-zA-Z0-9]+$/',$username)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='agree_terms';
			$msg['errors'][$i]['message']= 'Login failed! wrong username/email or password';
			$i++;
		}
		if($i==0){
		
			$username = trim($this->input->post("username"));
			$password = $this->input->post("password");
			$response = array();
			$this->db->select('user_id,  username, email,ldate,membership_plan');
			
			$this->db->where("(email = '".$username."' OR username = '".$username."')"); 
			$this->db->where('password',md5($password));
			$this->db->where('status =', 'Y');
			$this->db->where('v_stat =', 'Y');
			$query=$this->db->get('user');

			//echo $this->db->last_query();
			$result = $query->result();
		  
			if ($query->num_rows() == 1) {
				$msg['status'] = "OK";
				$msg['location'] = VPATH.'dashboard';
				$this->session->set_userdata('user', $result);
				$data = array(
				   'ip' => $_SERVER['REMOTE_ADDR']
				);
				$this->db->set('ldate', 'NOW()', FALSE);
				$this->db->update('user', $data);
			   
			} else {
				$msg['status']='FAIL';
				$msg['errors'][$i]['id']='agree_terms';
				$msg['errors'][$i]['message']= 'Login failed! wrong username/email or password or your profile is not activated yet';
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