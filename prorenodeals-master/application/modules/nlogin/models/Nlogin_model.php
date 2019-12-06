<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nlogin_model extends BaseModel {

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
		/*if(!preg_match('/^[a-zA-Z0-9]+$/',$password) || !preg_match('/^[a-zA-Z0-9]+$/',$username)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='agree_terms';
			$msg['errors'][$i]['message']= 'Login failed! wrong username/email or password';
			$i++;
		}*/
		if($i==0){
		
			$username = trim($this->input->post("username"));
			$password = $this->input->post("password");
			$response = array();
			$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance');
			
			$this->db->where("(email = '".$username."' OR username = '".$username."')"); 
			$this->db->where('password',md5($password));
			$this->db->where('status =', 'Y');
			$this->db->where('v_stat =', 'Y');
			$query=$this->db->get('user');

			//echo $this->db->last_query();
			$result = $query->result();
		  
			if ($query->num_rows() == 1) {
                            
                            /*Membership Auto Upgrade Code Start */   
                               if($result[0]->membership_plan!=1){ 
                                   if(strtotime(date("Y-m-d"))>strtotime($result[0]->membership_end)){ 
                                      if($result[0]->membership_upgrade=="Y"){ 
                                          $plan_charge=$this->auto_model->getFeild("price","membership_plan","id",$result[0]->membership_plan);
                                          $plan_day=$this->auto_model->getFeild("days","membership_plan","id",$result[0]->membership_plan);
                                          $plan_name=$this->auto_model->getFeild("name","membership_plan","id",$result[0]->membership_plan);
                                          $admin_email=$this->auto_model->getFeild("admin_mail","setting");
                                          $fname=$this->auto_model->getFeild("fname","user","user_id",$result[0]->user_id);
                                          $lname=$this->auto_model->getFeild("fname","user","user_id",$result[0]->user_id);
                                                            
                                          if($result[0]->acc_balance>=$plan_charge){ 
                                                $data_transaction = array(
                                                    "user_id" =>$result[0]->user_id,
                                                    "amount"=>$plan_charge,
                                                    "transction_type"=>"DR",
                                                    "transaction_for"=>"Upgrade Membership",
                                                    "transction_date"=>date("Y-m-d"),
                                                    "status"=>"Y"
                                                );
                                                
                                                $data_user=array(
                                                    "acc_balance"=>($result[0]->acc_balance-$plan_charge),
                                                    "membership_plan"=>$result[0]->membership_plan,
                                                    "membership_start"=>date("Y-m-d"),
                                                    "membership_end"=>date('Y-m-d', strtotime("+".$plan_day." day", strtotime(date("Y-m-d"))))
                                                );
                                                
                                                $tid=$this->db->insert('transaction', $data_transaction); 
                                                if($tid){ 
                                                    $this->updateuser($data_user,$result[0]->user_id);
                                                    
                                                    
                                                    
                                                    
                                                    $data_parse=array(
                                                        'username'=>$fname." ".$lname,
                                                        'plan'=>$plan_name,
                                                        'start'=>date("Y-m-d"),
                                                        'end'=>date('Y-m-d', strtotime("+".$plan_day." day", strtotime(date("Y-m-d"))))                                                       
                                                    );   
                                                    
                                                    $this->auto_model->send_email($admin_email,$result[0]->email,"upgrade_membership",$data_parse);
                                                    
                                                }                                                
                                          }
                                          else{ 
                                                $data_user=array(                                                    
                                                    "membership_plan"=>"1",
                                                    "membership_start"=>date("Y-m-d"),                                                    
                                                );   
                                                $this->updateuser($data_user,$result[0]->user_id);
                                              
                                                    $data_parse=array(
                                                        'username'=>$fname." ".$lname                                                        
                                                    );   
                                                    
                                                    $this->auto_model->send_email($admin_email,$result[0]->email,"degrade_membership",$data_parse);
                                                                                                
                                          }
                                          
                                      } 
                                      else{ 
                                                $data_user=array(                                                    
                                                    "membership_plan"=>"1",
                                                    "membership_start"=>date("Y-m-d"),                                                    
                                                );   
                                                $this->updateuser($data_user,$result[0]->user_id);                                          
                                                $data_parse=array(
                                                    'username'=>$fname." ".$lname                                                        
                                                );   

                                                $this->auto_model->send_email($admin_email,$result[0]->email,"degrade_membership",$data_parse);

                                                
                                      }
                                       
                                   }
                                   
                               }
                            /*Membership Auto Upgrade Code End */                               
                            
                            
                            
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
		if($msg['status']=='FAIL')
		{
			$this->session->set_flashdata('log_eror',"Login failed! wrong username/email or password or your profile is not activated yet");
			redirect(VPATH.'login/');
		}
		else
		{
                    
                    if(base_url()==$_SERVER['HTTP_REFERER']){ 
                         redirect(VPATH.'dashboard/');    
                    }
                    else{ 
                        redirect($_SERVER['HTTP_REFERER']);    
                        
                    }
                   
                   //   
                   
                    
		}
	
	//unset($_POST);
	//echo json_encode($msg);
	}
        
        
	public function updateuser($data,$id)
	{
		$this->db->where('user_id',$id);
		return $this->db->update('user',$data);
	}
}
?>