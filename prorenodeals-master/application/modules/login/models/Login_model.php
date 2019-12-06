<?php 

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Login_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

	

	public function login() {

	$this->load->helper('date');

		$i=0;

		

		$username=htmlentities(strip_tags(trim($this->input->post('username'))), ENT_QUOTES);

		//$email=$this->input->post('email');
		
		
		


		

$password=$this->input->post('password');


		

		if($username==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='username';

			$msg['errors'][$i]['message']=__('login_username_field_required','The username or email id is required');

			$i++;

		}

		

		if($password==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='password';

			$msg['errors'][$i]['message']=__('login_password_required','The password is required');

			$i++;

		}

		/*if(!preg_match('/^[a-zA-Z0-9]+$/',$password) || !preg_match('/^[a-zA-Z0-9]+$/',$username)){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='agree_terms';

			$msg['errors'][$i]['message']= 'Login failed! wrong username/email or password';

			$i++;

		}*/

		if($i==0){

		

			/*$username = trim($this->input->post("username"));*/

			$password = $this->input->post("password");

			$response = array();
/* Smartbuzz pass Account type to Select */
			$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance,account_type');

			$this->db->where("(email = '".$username."' OR username = '".$username."')"); 

			$this->db->where('password',md5($password));

			$this->db->where('status =', 'Y');

			$this->db->where('v_stat =', 'Y');

			$query=$this->db->get('user');



			//echo $this->db->last_query();die();

			$result = $query->result();
                        

			if ($query->num_rows() == 1) {
                    
					 /*Remember me section */
			   
					$this->load->helper('cookie');
			   
					if(post('remember_me') === '1'){
						
						$cookie_field = array(
							'uname' => $username,
							'pwd' => $password,
						);
						
						$cookie_str = serialize($cookie_field);
						
						set_cookie('r_m_i', $cookie_str, (60*60*24*30));
						
						
					}else{
						delete_cookie('r_m_i');
						
					}
					
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
				
				if($this->input->post('refer')!='')
				{
				$msg['location'] = VPATH.$this->input->post('refer');
				}
				else
				{
				$msg['location'] = VPATH.'dashboard';
				}
				$this->session->set_userdata('user', $result);
				
				if(date("Y-m-d")>=$result[0]->membership_end){ 
						if($result[0]->membership_upgrade=="Y"){ 
						  
							$this->db->select("*");
							$this->db->order_by('id');
							$res=$this->db->get_where("membership_plan",array("status"=>"Y","id"=>$result[0]->membership_plan));
							$plane=$res->result();
							
							$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$result[0]->user_id);
							
							if($balance>=$plane[0]->price){ 
								$amount=$balance-$plane[0]->price;

								$data_transaction=array(
									"user_id" =>$result[0]->user_id,
									"amount" =>$plane[0]->price,
									"transction_type" =>"DR",
									"transaction_for" => "Upgrade Membership",
									"transction_date" => date("Y-m-d H:i:s"),
									"status" => "Y"
								);

								$data_user=array(
									"membership_plan" =>$plane[0]->id,
									"membership_start" => date("Y-m-d"),
									"membership_end" => date('Y-m-d', strtotime("+".$plane[0]->days." day", strtotime(date("Y-m-d")))),
									"membership_upgrade" =>$result[0]->membership_upgrade,
									"acc_balance"=>$amount 

								);

								if($this->membership_model->insertTransaction($data_transaction)){ 
									$this->membership_model->updateUser($data_user,$result[0]->user_id);                                                    
								}
							}                                          
																		
						}
						else{ 
							   $data_user=array(
									"membership_plan" =>"1",
									"membership_start" => date("Y-m-d"),
									"membership_end" => date('Y-m-d', strtotime("+30 day", strtotime(date("Y-m-d"))))
								); 
							   $this->membership_model->updateUser($data_user,$result[0]->user_id);
						}       
				}

				$data = array(

				   'ip' => $_SERVER['REMOTE_ADDR']

				);

				$this->db->set('ldate', 'NOW()', FALSE);

				$this->db->update('user', $data);

			} else {
				
				$this->db->where("(email = '".$username."' OR username = '".$username."')"); 

				$this->db->where('password',md5($password));
				$this->db->where('verify', 'N');
				$count = $this->db->count_all_results('user');
				
				if($count == 0){
					$msg['status']='FAIL';

					$msg['errors'][$i]['id']='agree_terms';

					$msg['errors'][$i]['message']= __('login_failed_to_login_username_password_wrong','Login failed! wrong username/email or password or your profile is not activated yet');
				}else{
					$msg['status']='FAIL';

					$msg['errors'][$i]['id']='agree_terms';

					$msg['errors'][$i]['message']= 'We have sent you an email with account activation link, to activate your profile please confirm your email';
				}
				
				

			}

       	

		}


	unset($_POST);
	ob_start();
	ob_clean();
	echo json_encode($msg);

	}

        

        

	public function updateuser($data,$id){

		$this->db->where('user_id',$id);

		return $this->db->update('user',$data);

	}
	
	public function checkUser($email)
	{
		$this->db->select('user_id');
		$this->db->where('email',$email);
		$this->db->from('user');
		return $this->db->count_all_results();
	}
	public function loginUser($email)
	{
	/* Smartbuzz pass Account type to Select */ 
		$this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance,account_type');
			
			$this->db->where("(email = '".$email."')"); 
			$this->db->where('status =', 'Y');
			$this->db->where('v_stat =', 'Y');
			$query=$this->db->get('user');			
			$result = $query->result();
			if ($query->num_rows() == 1) {
				//print_r($result);exit;
                            
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
			
				$this->session->set_userdata('user', $result);
                                          
				if(date("Y-m-d")>=$result[0]->membership_end){
					
						if($result[0]->membership_upgrade=="Y"){ 
						  echo "pppp";exit; 
							$this->db->select("*");
							$this->db->order_by('id');
							$res=$this->db->get_where("membership_plan",array("status"=>"Y","id"=>$result[0]->membership_plan));
							$plane=$res->result();
							
							$balance=$this->auto_model->getFeild('acc_balance','user','user_id',$result[0]->user_id);
							
							if($balance>=$plane[0]->price){ 
								$amount=$balance-$plane[0]->price;

								$data_transaction=array(
									"user_id" =>$result[0]->user_id,
									"amount" =>$plane[0]->price,
									"transction_type" =>"DR",
									"transaction_for" => "Upgrade Membership",
									"transction_date" => date("Y-m-d H:i:s"),
									"status" => "Y"
								);

								$data_user=array(
									"membership_plan" =>$plane[0]->id,
									"membership_start" => date("Y-m-d"),
									"membership_end" => date('Y-m-d', strtotime("+".$plane[0]->days." day", strtotime(date("Y-m-d")))),
									"membership_upgrade" =>$result[0]->membership_upgrade,
									"acc_balance"=>$amount 

								);

								if($this->membership_model->insertTransaction($data_transaction)){ 
									$this->membership_model->updateUser($data_user,$result[0]->user_id);                                                    
								}
							}                                          
																		
						}
						else{
							
							   $data_user=array(
									"membership_plan" =>"1",
									"membership_start" => date("Y-m-d"),
									"membership_end" => date('Y-m-d', strtotime("+30 day", strtotime(date("Y-m-d"))))
								); 
							   $this->updateuser($data_user,$result[0]->user_id);
						}       
				}
				
				$data = array(
				   'ip' => $_SERVER['REMOTE_ADDR']
				);
				$this->db->set('ldate', 'NOW()', FALSE);
				$this->db->update('user', $data);
			
			}
		return true;
	}

   
} 

?>