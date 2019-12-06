<?php 

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Dashboard_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }

    public function activeportfolio($data,$id){ 
        $this->db->where('id', $id);
        $this->db->update('user_portfolio', $data); 
    }

    public function editprofile() {

	$this->load->helper('date');

		$i=0;

		$fname=filter_data($this->input->post('fname'));

		$lname=filter_data($this->input->post('lname'));

		$country=filter_data($this->input->post('country'));
                
        $city=filter_data($this->input->post('city'));

		$rate=filter_data($this->input->post('rate'));
		$company=filter_data($this->input->post('company'));
		$phone=filter_data($this->input->post('phone'));
		$profile_links=json_encode(filter_data($this->input->post('profile_links')));
		if(!$phone){
			$phone = '';
		}
		$user_id=$this->input->post("uid");
		$account_type =  getField('account_type', 'user', 'user_id', $user_id);
		
		if($account_type == 'F'){
			if($company==''){

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='company';

				$msg['errors'][$i]['message']= __('dashboard_editprofile_enter_your_company_name','Enter your company name');

				$i++;

			}
		}
		
		/* fname checking */
		if($fname==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='fname';
			$msg['errors'][$i]['message']=__('signup_please_enter_first_name','Please enter first name');
			$i++;
		} else if(!preg_match("/^[a-zA-Z]+$/", $fname)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='fname';
			$msg['errors'][$i]['message']=__('signup_alphabetic','Please enter alphabetic character');
			$i++;
		} else if(strlen($fname)>15){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='fname';
			$msg['errors'][$i]['message']=__('signup_15char_first_name','First name cannot be longer than 15');
			$i++;
		}
		/* lname checking */
		if($lname==''){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='lname';
			$msg['errors'][$i]['message']= __('signup_please_enter_last_name','Please enter last name');
			$i++;
		} else if(!preg_match("/^[a-zA-Z]+$/", $lname)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='lname';
			$msg['errors'][$i]['message']= __('signup_alphabetic','Please enter alphabetic character');
			$i++;
		} else if(strlen($lname)>15){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='lname';
			$msg['errors'][$i]['message']= __('signup_15char_last_name','Last name cannot be longer than 15');
			$i++;
		}

		if($country==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='country';

			$msg['errors'][$i]['message']=__('dashboard_editprofile_enter_your_country','Enter your country');

			$i++;

		}
                
                
		if($city==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='city';

			$msg['errors'][$i]['message']=__('dashboard_editprofile_enter_your_city','Enter your city');

			$i++;

		}                

		/* if($rate=='' || !preg_match('/^[-+]?[0-9]*\.?[0-9]+$/',$rate)){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='rate';

			$msg['errors'][$i]['message']=__('dashboard_editprofile_hourly_rate_is_required','Hourly rate is required and enter only numbers');

			$i++;

		} */

		if($i==0){

		

			

			$curr_image=$this->auto_model->getFeild('logo','user','user_id',$user_id);

			if($this->input->post('logo'))

			{

				$logo=$this->input->post('logo');

			}

			else

			{

				$logo=$curr_image;

			}
            //print_r($logo);
			//die();
			$data = array(

			'slogan' => filter_data($this->input->post('slogan')),

			'fname' => filter_data($this->input->post('fname')),

			'lname' => filter_data($this->input->post('lname')),
			
            'country' =>filter_data( $this->input->post('country')),                

			'city' => filter_data($this->input->post('city')),

			'overview' => filter_data($this->input->post('overview')),

			'work_experience' => filter_data($this->input->post('work_experience')),

			'qualification' => filter_data($this->input->post('qualification')),

			'certification' => filter_data($this->input->post('certification')),

			'education' => filter_data($this->input->post('education')),

			'hourly_rate' => filter_data($this->input->post('rate')),
			'company' => filter_data($this->input->post('company')),

			'facebook_link' => filter_data($this->input->post('facebook_link')),    
				
			'twitter_link' => filter_data($this->input->post('twitter_link')),        
				
			'gplus_link' => filter_data($this->input->post('gplus_link')),            
				
			'linkedin_link' => filter_data($this->input->post('linkedin_link')),   
			'profile_links' => $profile_links,
			'phone' => $phone,    

			'logo' => $logo,

			'edit_date' => 'NOW()'

			);

			$response = array();

			$this->db->where('user_id',$user_id);

			$upd_user=$this->db->update('user', $data);

		  

			if ($upd_user) {

				$msg['status'] = "OK";
				
				$msg['message']= __('dashboard_editprofile_your_profile_updated_successfully','Your profile has been updated successfuly.')."<a class='close' data-dismiss='alert' aria-label='close'>×</a><script>setTimeout(function(){ window.location.reload(); }, 2000);</script>";

				//$msg['location'] = VPATH.'dashboard';

			   

			} else {

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='agree_terms';

				$msg['errors'][$i]['message']= __('dashboard_editprofile_updation_failed','Updation Failed');

			}

       	

		}

		

	unset($_POST);

	echo json_encode($msg);

	}

    public function updateuser($data,$id){

		$this->db->where('user_id',$id);

		return $this->db->update('user',$data);

	}

    public function getCountry(){

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

     
    public function getCity(){ 
        $this->db->select('city');
        $this->db->group_by('city');
	$this->db->order_by('city');

	$res=$this->db->get('cities');

	$data=array();

	foreach($res->result() as $row){

            $data[]=array(

            'city'=>$row->city

            );

	}

		return $data;        
        
        
    }

    
     public function add_about($data,$id){ 

        $this->db->where('user_id', $id);

        return $this->db->update('user', $data);         

     }
     
	 public function deleteskill($user_id){ 
	      $this->db->where('user_id', $user_id);
		 return $this->db->delete('new_user_skill'); 
	 }      
	 
	 public function insertskill($data){ 
	   $this->db->insert('user_skills', $data); 
	 }
	 
	 /*public function getuserskill($user_id){ 
        $this->db->select("skills_id");
	    $result=$this->db->get_where("user_skills",array("user_id" =>$user_id));
	    if(count($result->result())>0){ 
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skills_id" => $val->skills_id
		   );
		}
		return $data;
            }
            else{ 
               return "";
            }

	 }*/
	 
	 public function getuserskill($user_id){ 
        $this->db->select("skill_id,sub_skill_id");
	    $result=$this->db->get_where("new_user_skill",array("user_id" =>$user_id));
	    if(count($result->result())>0){ 
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skill_id" => $val->skill_id,
			 "sub_skill_id" => $val->sub_skill_id,
		   );
		}
		return $data;
            }
            else{ 
               return "";
            }

	 }
         
         /*public function getskillsname($user_id){ 
             
             $skill_id= $this->getuserskill($user_id);
             
             if($skill_id){
             
            $skill_list=  explode(",",$skill_id[0]['skills_id']);
             
            $this->db->select("skill_name,id");
	    $this->db->where_in("id",$skill_list);
            $this->db->order_by("skill_name");
            $result=  $this->db->get("skills");
            
	       
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skill_name" => $val->skill_name,
			 "id" => $val->id
		   );
		}  
                return $data;
             }  
             else{ 
                 return "";
                 
             }
         }*/
		 
		 public function getskillsname($user_id){ 
             
             $skill_id= $this->getuserskill($user_id);
             
             if($skill_id){
             $skill_list = array();
			 if(count($skill_id) > 0){
				 foreach($skill_id as $k => $v){
					 $skill_list[] = $v['sub_skill_id'];
				 }
			 }
           //get_print($skill_id);
             
            $this->db->select("skill_name,id");
	    $this->db->where_in("id",$skill_list);
            $this->db->order_by("skill_name");
            $result=  $this->db->get("skills");
            
	       
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skill_name" => $val->skill_name,
			 "id" => $val->id
		   );
		}  
                return $data;
             }  
             else{ 
                 return "";
                 
             }
         }
		 
		 
	public function getUserSkills($user_id=''){
		if($user_id == ''){
			return FALSE;
		}
		
		$this->db->select('ps.skill_name as parent_skill_name,s.skill_name as skill , ps.id as parent_skill_id , s.id as skill_id')
				->from('new_user_skill us')
				->join('skills ps' , 'ps.id=us.skill_id' , 'LEFT')
				->join('skills s' , 's.id=us.sub_skill_id' , 'INNER');
		$this->db->where('us.user_id' , $user_id);
		$result = $this->db->get()->result_array();
		return $result;
	}	 
         
      public function insertportfolio($data){ 
           $this->db->insert('user_portfolio', $data); 
           return $this->db->insert_id();
      }
      public function updateportfolio($data,$id){ 
         
           $data=array(
               "title" => $data['title'],
               "description" => $data['description']
           ); 
          $this->db->where("id",$id);
          $this->db->update('user_portfolio', $data);          
      }
	  
	  
	  public function updateportfolioimg($data,$id){              
            $this->db->where("id",$id);
            $this->db->update('user_portfolio',$data); 	  
	  }
      
      public function deleteportfolio($id){ 
		  $login_user = $this->session->userdata('user');
		  $login_user_id = $login_user[0]->user_id;
          $user =  $this->auto_model->getFeild("user_id","user_portfolio","id",$id);
		  if($user ==  $login_user_id){
			$file_name=  $this->auto_model->getFeild("original_img","user_portfolio","id",$id);
			  $file_name_thumb=  $this->auto_model->getFeild("thumb_img","user_portfolio","id",$id);
			  unlink("assets/portfolio/".$file_name);
			  unlink("assets/portfolio/".$file_name_thumb);
			  $this->db->delete('user_portfolio', array('id' => $id));   
		  }
		  
		  return TRUE;
          
      }
	  public function getcatskill($pid){         
        $this->db->select("id,skill_name");
        $con=array( 
           "cat_id" => $pid,
           "status" => "Y"
        );
        $this->db->order_by("skill_name");
        $res=$this->db->get_where("skills",$con);
        $data=array();
        
        foreach ($res->result() as $row){ 
            $data[]=array(
               "id" => $row->id,
               "skill_name" => $row->skill_name 
            );
        }
        
        return $data;
    }

      public function getProject($status='',$id='',$limit=0, $offset=80, $for_list=TRUE){
              
	  		$this->db->select("*");
            if($status=='')
			{
				$status='O';
			}else if($status==='RO'){
				$status='O';
				$this->db->where('reopen', 1);
			}                        
			
                        if($id!=""){ 
                          $this->db->where("user_id",$id);    
                        }
						$this->db->where("status",$status); 
						
                        
                        
            $this->db->order_by("post_date", "desc");            
			
			
			if($for_list){
				$this->db->limit($offset, $limit);
				$data=array();
				$rs=$this->db->get('projects');
				foreach($rs->result() as $row){
					$data[]=array(
					'id'=>$row->id,
					'project_id'=>$row->project_id,
					'bidder_details'=>$this->getBidder($row->project_id),
					'title'=>$row->title,
					'description'=>$row->description,
					'category'=>$row->category,
					'skills'=>$row->skills,     
					'project_type'=>$row->project_type, 
					'visibility_mode' =>$row->visibility_mode,    
					'buget_min'=>$row->buget_min,
					'buget_max'=>$row->buget_max,
					'featured'=>$row->featured,
					'expiry_date'=>$row->expiry_date,
					'attachment'=>$row->attachment,
					'bidder_id'=>$row->bidder_id,
					'chosen_id'=>$row->chosen_id,
					'user_id'=>$row->user_id,
					'expiry_date_extend'=>$row->expiry_date_extend,
					'posted_date'=>$row->post_date,
					'project_status'=>$row->project_status,
					'escrow_enabled'=>$row->escrow_enabled,
					'multi_freelancer'=>$row->multi_freelancer,
					'no_of_freelancer'=>$row->no_of_freelancer,
					'is_completed'=>$row->is_completed,
					'is_cancelled'=>$row->is_cancelled,
					'cancel_requested_by'=>$row->cancel_requested_by,
					'completed_requested_by'=>$row->completed_requested_by,
				
					);
				}
				return $data;
			}else{
				$data = $this->db->get('projects')->num_rows();
				return $data;
			}
			
	  }   
	  
	  
          
          public function getportfolio($user_data,$limit = '9', $start = ''){
               
              $this->db->select("*");
			  $this->db->order_by('id', "desc");
              $this->db->limit($limit, $start);
              $res= $this->db->get_where("user_portfolio",array("user_id" => $user_data));
             
              $data=array();
             if(count($res->result())>0){ 
                
                foreach($res->result() as $val){ 
                    $data[]=array(
                        "id" => $val->id,
                        "title" =>$val->title,
                        "description" =>$val->description,
                        "tags" =>$val->tags,
                        "url" =>$val->url,
                        "add_date" =>$val->add_date,
                        "original_img" => $val->original_img,
                        "status" => $val->status,
                        "thumb_img" => $val->thumb_img
                    );
                } 
                
             }
             return $data;
          }
		  
		  public function getActiveportfolio($user_id=''){
			 $this->db->select("*");
			 $this->db->where('status', 'Y');
			  $this->db->order_by('id', "desc");
            
              $res= $this->db->get_where("user_portfolio",array("user_id" => $user_id));
             
              $data=array();
             if(count($res->result())>0){ 
                
                foreach($res->result() as $val){ 
                    $data[]=array(
                        "id" => $val->id,
                        "title" =>$val->title,
                        "description" =>$val->description,
                        "tags" =>$val->tags,
                        "url" =>$val->url,
                        "add_date" =>$val->add_date,
                        "original_img" => $val->original_img,
                        "status" => $val->status,
                        "thumb_img" => $val->thumb_img
                    );
                } 
                
             }
             return $data; 
		  }
          
          public function count_portfolio($user_data){ 
            $this->db->select("*");
            $this->db->where("user_id",$user_data);
            $this->db->from('user_portfolio');
            return $this->db->count_all_results();              
          }
          
          public function update_extendday($data,$id){ 
            $this->db->where('id', $id);
            $this->db->update('projects', $data);               
          }
          
            public function insert_notification($data){ 
              $this->db->insert("notification",$data);
              $this->insert_notification_file($data['to_id']);
              
              
          }
		  
		  // Insert security question/answer Data 
		  
		  
		  public function insertQuestionAnswer($data){

		  $user=$this->session->userdata('user');

		  $user_id=$user[0]->user_id;
		  
		  $this->db->select("answers");
		  $this->db->from('answers');	
		  $this->db->where("user_id",$user_id);
		  $res = $this->db->get();    
		 
		  if(count($res->result())>0){ 
		   $this->db->query("UPDATE serv_answers set answers='".$data['answers']."',question_id ='".$data['question_id']."' ,reset_code ='".''."'WHERE user_id = '".$user_id."'");

		  }else{
		 
         $this->db->insert("answers",$data);		
		  $msg['message']= 'Updated Successfully';
		  }
		  echo json_encode($msg);
	
		  }
		  
	public function insertreset_code($user_id,$code){
		  
	$update = $this->db->query("UPDATE serv_answers set reset_code='".$code."' WHERE user_id = '".$user_id."'");

		if($update){
				$from = ADMIN_EMAIL;
				$to=$this->auto_model->getFeild('email','user','user_id',$user_id);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$user_id);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$user_id);
				$link = base_url().'dashboard/setting/'.$code.'   or  <a href="'.base_url().'dashboard/setting/'.$code.'">Click Here</a>';
				$template='question_ans_reset_code';
				$data_parse=array('NAME'=>$fname." ".$lname,
									'ANS_RESET_CODE'=>$link
									);
				$send_code_mail = $this->auto_model->send_email($from,$to,$template,$data_parse);	
				if($send_code_mail){
					 $msg['message']= 'Reset link send to your email. Please check your email';
				}else{
					 $msg['message']= 'Sorry !!! Reset link not send to your email.';
				}
		  
		}else{
			 $msg['message']= 'Sorry !!! Reset link not created.';
		}
		  echo json_encode($msg);
	
		  }
		  
		  // Get data After update
		public function getUpdatedAnswer(){
			$user=$this->session->userdata('user');
			$user_id=$user[0]->user_id;	  
          
		  // GET question id from Answers tables
			
			$result = $this->db->query("SELECT question_id FROM serv_answers WHERE user_id = '".$user_id."'");
			
			//echo $this->db->last_query(); echo "<br/>";
			$data=array();
			if( $result->num_rows())
			{
				$row = $result->row_array();
				$questionId = $row['question_id'];
		    
		   
		   
		  // ends here
		  
		  // Displaying the Question 
		 $this->db->select("questions");
         $this->db->from('questions');	
		 $this->db->where("id",$questionId);
         $res = $this->db->get();    
         
         if(count($res->result())>0){ 
                
          foreach($res->result() as $val){ 
                    $data[]=array(
                        "question" => $val->questions
                        
                    );
                } 
                
   }
		
		} return $data;
		
		
}
		  
		  
		  
          public function updatepass(){ 
              $user=$this->session->userdata('user');
              $user_id=$user[0]->user_id;              
             $oldpass=$this->input->post("old_pass");
             $newpass=$this->input->post("new_pass");
             $confirmpass=$this->input->post("confirm_pass");
              
              $i=0;
              
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
		}else if($newpass=='' || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $newpass)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='new_pass';
			$msg['errors'][$i]['message']="Your password  must be atleast 8 characters with one Capital letters,one small letter and one numbers and one special characters (@#$%^&+=_) all other symbols are invalid";
			$i++;
		}
		
		/* if($newpass=='' || strlen($newpass)<6 || strlen($newpass)>12 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$%^&+=_])(?=.{6,12}).*$/',$newpass)){
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='new_pass';
			$msg['errors'][$i]['message']="Your password  must be 6 to 12 characters with one Capital letters,one small letter and one numbers and one special characters (@#$%^&+=_) all other symbols are invalid";
			$i++;
		} */
                
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
                        $res=$this->db->get_where('user',$con);                        
                        $c= count($res->result());
                       
                       if($c==0){ 
			$msg['status']='FAIL';
			$msg['errors'][$i]['id']='old_pass';
			$msg['errors'][$i]['message']="Please Enter Correct Password";
			$i++;                           
                       }

		}
                                
                if($i==0){ 
                    $data=array( 
                        "password" => md5($newpass)
                    );
                    
                    $this->db->where('user_id',$user_id);
                    if($this->db->update('user', $data)){ 
                        $msg['status']='OK';    
			$msg['message']='Password Reset Successfully.';                        
                    }
                    else{ 
                        $msg['status']='FAIL';
                        $msg['errors'][$i]['id']='agree_terms';
                        $msg['errors'][$i]['message']= 'dB error!';                    
                    }
                }
            unset($_POST);
            echo json_encode($msg);
                
          }
          
          public function addportfolio(){ 
            
                            $i=0;

                            $title=$this->input->post('title');

                            $description=$this->input->post('description');

                            $tags=$this->input->post('tags');
                            
                            $url=$this->input->post('url');
                            

                            if($title==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='title';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_title','Enter Title');

                                    $i++;

                            }



                            if($description==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='description';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_description','Enter Description');

                                    $i++;

                            }

                            if($i==0){

                                    $pid=$this->input->post("pid");

                                 

                                    $data = array(

                                    'title' => $title,

                                    'description' => $description,

                                    'tags' =>$tags,

                                    'url' => $url                                    
                                    );

                                    $response = array();

                                    $this->db->where('id',$pid);

                                    $upd_user=$this->db->update('user_portfolio', $data);



                                    if ($upd_user) {

                                            $msg['status'] = "OK";
											$msg['location']=VPATH."dashboard/editportfolio/";
                                            $msg['message']=__('dashboard_addportfolio_record_inserted','Record Inserted.'); 

                                    } else {

                                            $msg['status']='FAIL';

                                            $msg['errors'][$i]['id']='agree_terms';

                                            $msg['errors'][$i]['message']= __('dashboard_addportfolio_insertion_failed','Insertion Failed');

                                    }

                            }



                    unset($_POST);

                    echo json_encode($msg);
              
          }
		  
		  public function addportfolioajax(){ 
            
                            $i=0;

                            $title=$this->input->post('title');

                            $description=$this->input->post('description');

                            $tags=$this->input->post('tags');
                            
                            $url=$this->input->post('url');
                            

                            if($title==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='title';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_title','Enter Title');

                                    $i++;

                            }



                            if($description==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='description';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_description','Enter Description');

                                    $i++;

                            }

                            if($i==0){

                                    $pid=$this->input->post("pid");

                                 

                                    $data = array(

                                    'title' => $title,

                                    'description' => $description,

                                    'tags' =>$tags,

                                    'url' => $url                                    
                                    );

                                    $response = array();

                                    $this->db->where('id',$pid);

                                    $upd_user=$this->db->update('user_portfolio', $data);



                                    if ($upd_user) {

                                            $msg['status'] = "OK";
											$msg['location']=VPATH."dashboard/profile_professional/";
                                            $msg['message']='Record Inserted.'; 

                                    } else {

                                            $msg['status']='FAIL';

                                            $msg['errors'][$i]['id']='agree_terms';

                                            $msg['errors'][$i]['message']=  __('dashboard_addportfolio_insertion_failed','Insertion Failed');

                                    }

                            }



                    unset($_POST);

                    echo json_encode($msg);
              
          }
		  
		  
         public function editportfolio(){ 
            
                            $i=0;

                            $title=$this->input->post('title');

                            $description=$this->input->post('description');

                            $tags=$this->input->post('tags');
                            
                            $url=$this->input->post('url');
                            

                            if($title==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='title';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_title','Enter Title');

                                    $i++;

                            }



                            if($description==''){

                                    $msg['status']='FAIL';

                                    $msg['errors'][$i]['id']='description';

                                    $msg['errors'][$i]['message']=__('dashboard_addportfolio_enter_description','Enter Description');

                                    $i++;

                            }

                            if($i==0){

                                    $pid=$this->input->post("pid");

                                 

                                    $data = array(

                                    'title' => $title,

                                    'description' => $description,

                                    'tags' =>$tags,

                                    'url' => $url                                    
                                    );

                                    $response = array();

                                    $this->db->where('id',$pid);

                                    $upd_user=$this->db->update('user_portfolio', $data);



                                    if ($upd_user) {

                                            $msg['status'] = "OK";
											$msg['location'] = VPATH."dashboard/editportfolio/";
                                            $msg['message']='Record Updated.'; 

                                    } else {

                                            $msg['status']='FAIL';

                                            $msg['errors'][$i]['id']='agree_terms';

                                            $msg['errors'][$i]['message']= __('dashboard_addportfolio_updation_failed','Updation Failed');

                                    }

                            }



                    unset($_POST);

                    echo json_encode($msg);
              
          }	
		  public function getBidder($project_id)
		  {
				$this->db->select();
				$this->db->where('project_id',$project_id);	
				$this->db->from('bids');
				return $this->db->count_all_results();  
		 }	
		 public function getAllBidder($project_id)
		 {
				$this->db->select();
				$this->db->where('project_id',$project_id);
				$rs=$this->db->get('bids');
				$data=array();
				foreach($rs->result() as $row)
				{
					$fname = $this->auto_model->getFeild('fname','user','user_id',$row->bidder_id);
					$lname = $this->auto_model->getFeild('lname','user','user_id',$row->bidder_id);
					$fullname = ucfirst($fname).' '.ucfirst($lname);
					$data[]=array(
					'bidder_id'=>$row->bidder_id,
					'bidder_details'=>$fullname,
					'details'=>$row->details,
					'bidder_amt'=>$row->bidder_amt,
					'total_amt'=>$row->total_amt,
					'days_required'=>$row->days_required,
					'posted_date'=>$row->add_date,
					'note'=>$row->note,					
					'status'=>$row->pausedcontract					
					);	
				}
				return $data;		
		} 
		public function updateProject($data,$id)
		{
			$this->db->where('project_id',$id);
			return $this->db->update('projects',$data);
		} 
                
		public function getNotification($uid){ 
			$this->db->select("notification,add_date");
			$this->db->where("to_id",$uid);
			$this->db->order_by("id","desc");
			$this->db->limit(4);
			$res=  $this->db->get("notification");
			$data=array();
			
			foreach($res->result() as $row){ 
			  $data[]=array(
				 "notification" => $row->notification,
				 "add_date" => $row->add_date 
			  );  
			}
			
			return $data;
		}
                
         public function getProposals($user_id)
		 {
		 	$this->db->select();
			$this->db->where('bidder_id',$user_id);
			$this->db->order_by('id','desc');
			$rs=$this->db->get('bids');
			$data=array();
			foreach($rs->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
				'project_id'=>$row->project_id,
				'details' =>$row->details,
				'bidder_amt' =>$row->bidder_amt,
				'total_amt' =>$row->total_amt,
				'days_required' =>$row->days_required,
				'add_date'=>$row->add_date,
				'amt_modified'=>$row->amt_modified,
				'note'=>$row->note
				);
			}
			return $data;
		 }
                 
                 
                 public function getPostPortfolioCount($uid){ 
                    $this->db->where('user_id',$uid);
                    $this->db->where('add_date >=',date('Y-m-d', strtotime('first day of this month')));
                    $this->db->where('add_date <=',date('Y-m-d', strtotime('last day of this month')));
                    $this->db->from('user_portfolio');     
                    return $this->db->count_all_results();                          
                 }
		public function getMyprojects($user_id,$status)
		 {
		 	$this->db->select();
			//$this->db->where('bidder_id',$user_id);
			$this->db->where("FIND_IN_SET('".$user_id."', bidder_id)!=",0);
			$this->db->where('status',$status);
			if($status=='P'){
			$this->db->where("!FIND_IN_SET('$user_id',ended_contractor)!=",0);	
			}            
            if($status=='C'){
			$this->db->or_where("FIND_IN_SET('$user_id',ended_contractor)!=",0);	
			}
			$this->db->order_by('id','desc');
			$rs=$this->db->get('projects');
		
			$data=array();
			$data = $rs->result_array();
			/* foreach($rs->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
				'project_id'=>$row->project_id,
				'user_id' =>$row->user_id,
				'project_type' =>$row->project_type,
				'bidder_id' => $row->bidder_id,
				'post_date'=>$row->post_date,
				'end_contractor'=>$row->end_contractor,
				'is_completed'=>$row->is_completed,
				'is_cancelled'=>$row->is_cancelled,
				'cancel_requested_by'=>$row->cancel_requested_by,
				'completed_requested_by'=>$row->completed_requested_by,
				);
			} */
			
			return $data;
		 }
		 
		 public function insertReview($data)
		 {
			return $this->db->insert('review',$data);	 
		}
		
		public function countReview($pid,$given_id,$user_id)
		{
			$this->db->select();
			$this->db->where('project_id',$pid);
			$this->db->where('given_user_id',$given_id);
			$this->db->where('user_id',$user_id);
			$this->db->from('review');
			return $this->db->count_all_results();
				
		}
		public function getAllreview($pid,$given_id,$user_id)
		{
			$this->db->select();
			$this->db->where('project_id',$pid);
			$this->db->where('given_user_id',$given_id);
			$this->db->where('user_id',$user_id);
			$res=$this->db->get_where('review',array('status'=>'Y'));
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
				'safety' => $row->safety,
				'flexibility' =>$row->flexibility,
				'performence'=>$row->performence,
				'initiative'=>$row->initiative,
				'knowledge'=>$row->knowledge,
				'average'=>$row->average,
				'comments'=>$row->comments
				);	
			}
			return $data;	
		}
		public function getmyreview($user_id)
		{
			$this->db->select("*");
			$this->db->where('user_id',$user_id);
			$res=$this->db->get_where('review',array('status'=>'Y'));
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
                                'user_id'=>$row->user_id,    
				'project_id'=>$row->project_id,
				'given_user_id'=>$row->given_user_id,
				'safety' => $row->safety,
				'flexibility' =>$row->flexibility,
				'performence'=>$row->performence,
				'initiative'=>$row->initiative,
				'knowledge'=>$row->knowledge,
				'average'=>$row->average,
				'comments'=>$row->comments,
				'add_date' =>$row->add_date
				);	
			}
			return $data;
		}
		public function getrating($user_id)
		{
			$this->db->select_sum('average');
			$this->db->where('user_id',$user_id);
			$res=$this->db->get('review');
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				'avg' =>$row->average
				);	
			}
			$new_data[0]['avg']=0;
			$this->db->select_sum('average');
			$this->db->where('user_id',$user_id);
			$res=$this->db->get('referer_review');
			$new_data=array();
			foreach($res->result() as $row)
			{
				$new_data[]=array(
				'avg' =>$row->average
				);	
			}
			
			$data[0]['avg']+=$new_data[0]['avg'];
			
			$this->db->select('average');
			$this->db->where('user_id',$user_id);
			$this->db->from('review');
			$data[0]['num']=$this->db->count_all_results();
			
			$this->db->select('average');
			$this->db->where('user_id',$user_id);
			$this->db->from('referer_review');
			$new_data[0]['num']=$this->db->count_all_results();
			
			$data[0]['num']+=$new_data[0]['num'];
			
			return $data;
		}
   public function closeAccount(){ 
       $user=$this->session->userdata('user');
        $data = array(
                       'status' => "E",
                       "project_status"=>"N"
                    );

        $this->db->where('user_id', $user[0]->user_id);
        $this->db->update('projects', $data);  
        
        $data2 = array(
                       'status' => "C"
                    );

        $this->db->where('user_id', $user[0]->user_id);
        $this->db->update('user', $data2);    
       
   } 
   
   public function insertEscrow($data)
   {
		 return $this->db->insert('escrow',$data);  
	} 
	public function insertTransaction($data){          
        return $this->db->insert("transaction",$data);
    }
	 public function update_User($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
       return $this->db->update('user', $data); 
    }
	
	 public function insertsetMilestone($data){
		    
      return $this->db->insert('project_milestone',$data);   
    }
	public function deleteMilestone($project_id)
	{
		$this->db->where('project_id',$project_id);
		return $this->db->delete('project_milestone');		
	}
	public function editMilestone($data,$mid)
	{
		$this->db->where('id',$mid);
		return $this->db->update('project_milestone',$data);	
	}
	
		public function getsetMilestone($pid, $uid){
		$bid_r = $this->db->where(array('project_id' => $pid, 'bidder_id' => $uid))->get('bids')->row_array();
		if($bid_r){
			$bid_id = $bid_r['id'];
		}else{
			$bid_id = 0;
		}
        $this->db->select("*");
        $res=$this->db->get_where("project_milestone",array("bid_id"=>$bid_id, 'bid_id <>' => 0));
        $data=array();
        foreach($res->result() as $row){ 
            $data[]=array(
                "id" => $row->id,
				"milestone_no" => $row->milestone_no,
                "project_id" => $row->project_id,                
                "amount" => $row->amount,
                "mpdate" => $row->mpdate,
                "bidder_id" => $row->bidder_id,
                "employer_id" => $row->employer_id,
                "description" => $row->description,
				"title" => $row->title,
                "request_by" => $row->request_by,
				"client_approval" => $row->client_approval,
				"fund_release" => $row->fund_release,
				"release_payment" => $row->release_payment,
				"invoice_id" => $row->invoice_id,
            );
        }
        return $data;
        
    }
	public function updateProjectMilestone($data,$where)
	{
		$this->db->where($where);
		return $this->db->update('project_milestone',$data);	
	}
	public function updateNotification($id)
	{
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		if($user_id>0){
			$this->insert_notification_file_update($user_id);
		}
		
		$data['read_status']='Y';
		$this->db->where(array('id'=>$id,'read_status'=>'N'));
		return $this->db->update('notification',$data);	
	}
	
	
	
	public function insert_notification_file($id){
		
              $this->load->helper('file');
              if($id>0){
              	$count_notic=$this->auto_model->count_results('id','notification','','',array('to_id'=>$id,'read_status'=>'N'));
			 $filename=APATH."application/ECnote/".$id.".echo";
		        if(!file_exists($filename)){
					if ( !write_file($filename, $count_notic, 'w')){
						 echo 'Unable to write the file';
					}
				
				}else{
					if ( !write_file($filename, $count_notic, 'w')){
						 echo 'Unable to write the file';
					}
				}
              }
	}
	public function insert_notification_file_update($id){
		$this->load->helper('file');
		$filename=APATH."application/ECnote/".$id.".echo";
		$noti=file_get_contents($filename);
		if($noti>0){
			if ( !write_file($filename, $noti-1, 'w')){
						 echo 'Unable to write the file';
					}
		}
		
	} 
	public function getProposals_dashboard($user_id,$limit)
		 {
		 	$this->db->select();
			$this->db->where('bidder_id',$user_id);
			$this->db->limit($limit,0);
			$this->db->order_by('id','desc');
			$rs=$this->db->get('bids');
			$data=array();
			foreach($rs->result() as $row)
			{
				$data[]=array(
				'id'=>$row->id,
				'project_id'=>$row->project_id,
				'details' =>$row->details,
				'bidder_amt' =>$row->bidder_amt,
				'total_amt' =>$row->total_amt,
				'days_required' =>$row->days_required,
				'add_date'=>$row->add_date
				);
			}
			return $data;
		 }
	public function trackercontent(){
		$data[]=array();
		return $data;
	}

	public function getrating_new($user_id){
		$this->db->select_sum('average');
		$this->db->where('review_to_user',$user_id);
		$this->db->where('view_status',1);
		$res=$this->db->get('review_new');
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'avg' =>$row->average
			);	
		}
		$new_data[0]['avg']=0;
		$this->db->select_sum('average');
		$this->db->where('user_id',$user_id);
		$res=$this->db->get('referer_review');
		$new_data=array();
		foreach($res->result() as $row)
		{
			$new_data[]=array(
			'avg' =>$row->average
			);	
		}
		
		$data[0]['avg']+=$new_data[0]['avg'];
		
		$this->db->select('average');
		$this->db->where('review_to_user',$user_id);
		$this->db->where('view_status',1);
		$this->db->from('review_new');
		$data[0]['num']=$this->db->count_all_results();
		
		$this->db->select('average');
		$this->db->where('user_id',$user_id);
		$this->db->from('referer_review');
		$new_data[0]['num']=$this->db->count_all_results();
		
		$data[0]['num']+=$new_data[0]['num'];
		
		return $data;
	}
	
	public function getRecentBidProjects($user_id=''){
		$this->db->select('p.project_id,p.title,p.post_date,p.status as project_status,p.project_type, p.bidder_id as all_bidders, b.bidder_amt,b.add_date as bid_date,b.admin_fee')
			->from('bids b')
			->join('projects p', 'p.project_id=b.project_id')
			->where('b.bidder_id', $user_id);
			
		$result = $this->db->limit(10)->order_by('b.add_date', 'DESC')->get()->result_array();
		
		return $result;
	}
	
	public function getRecentProjects($user_id=''){
		$today = date('Y-m-d', strtotime("- 30 days"));
		$bids = $this->db->dbprefix('bids');
		$this->db->select("p.project_id,p.title,p.post_date,p.status as project_status,p.project_type, (select count(id) from $bids b where b.project_id=p.project_id) as total_bids")
			->from('projects p')
			->where('p.user_id', $user_id)
			->where("p.post_date >= '$today'");
			
			
		$result = $this->db->limit(10)->order_by('p.id', 'DESC')->get()->result_array();
		
		return $result;
	}
	
	public function getProjectStatics($user_id=''){
		$open_projects = $this->db->where(array('user_id' => $user_id, 'status' => 'O'))->count_all_results('projects');
		$completed_projects = $this->db->where(array('user_id' => $user_id, 'status' => 'C'))->count_all_results('projects');
		
		$active_projects = $this->db->where(array('user_id' => $user_id, 'status' => 'P'))->count_all_results('projects');
		$cnl_projects = $this->db->where(array('user_id' => $user_id, 'status' => 'CNL'))->count_all_results('projects');
		
		$ret = array(
			array(
				'y' => $open_projects,
				'name' => 'Open jobs',
				'color' => '#fc0',
			),
			array(
				'y' => $completed_projects,
				'name' => 'Completed jobs',
				'color' => '#0c0',
			),
			array(
				'y' => $active_projects,
				'name' => 'Processing jobs',
				'color' => '#f06',
			),
			array(
				'y' => $cnl_projects,
				'name' => 'Cancelled jobs',
				'color' => '#0cf',
			),
		);
		
		return $ret;
	}
	
	public function getProjectCount($user_id='', $status=''){
		if(!$status){
			$status = 'O';
		}
		$count = $this->db->where(array('user_id' => $user_id, 'status' => $status))->count_all_results('projects');
		
		
		return $count;
	}
	
	public function getProjectCountFreelancer($user_id='', $status=''){
		if(!$status){
			$status = 'O';
		}
		$count = $this->db->where(array('bidder_id' => $user_id, 'status' => $status))->count_all_results('projects');
		
		
		return $count;
	}
	
	public function getMyContestsEntry($user_id, $limit=0, $offset=100, $for_list=TRUE){
		
		$this->db->select("c.title as contest_title,c.status as contest_status,c_n.*")
			->from('contest c')
			->join('contest_entry c_n', 'c_n.contest_id=c.contest_id')
			->where('c_n.user_id', $user_id);
			
			
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('c_n.entry_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}	
		
		
		return $result;
	}
	
	public function getMyContests($srch=array(), $limit=0, $offset=100, $for_list=TRUE){
		$entry = $this->db->dbprefix('contest_entry');
		$this->db->select("c.*,(select count(entry_id) from $entry where c.contest_id=$entry.contest_id) as total_entries")
			->from('contest c');
		
		$this->db->where('c.user_id', $srch['user_id']);
			
			
		if($for_list){
			$result = $this->db->limit($offset, $limit)->order_by('c.contest_id', 'DESC')->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}	
		
		
		return $result;
	}
	
	public function getmyreview_new($user_id='', $type='received'){
		$this->db->select("*");
		if($type == 'given'){
			$this->db->where('review_by_user',$user_id);
			
		}else{
			$this->db->where('review_to_user',$user_id);
			$this->db->where('view_status',1);
		}
		
		$data=$this->db->order_by('review_id', 'DESC')->get_where('review_new')->result_array();
		
		return $data;

	}
	
	public function getEscrowProject($user_id='', $limit=0, $offset=40, $for_list=TRUE){
		$projects = $this->db->dbprefix('projects');
		$this->db->select("p_txn.project_id, p.title, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, txn_row.wallet_id")
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->where('txn.status', 'Y');
			
			$this->db->where("p_txn.project_id in(select project_id from $projects where user_id=$user_id)");
			$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			$this->db->group_by('p_txn.project_id');
			$this->db->order_by('p.project_id', 'DESC');
			
		if($for_list){
			$result = $this->db->get()->result_array();
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
		
	}
	
	public function get_project_amount($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$projects = $this->db->dbprefix('projects');
		$user_id = !empty($srch['user_id']) ? $srch['user_id'] : '';
		$this->db->select("p_txn.project_id, p.title, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, txn_row.wallet_id,p.bidder_id,u.fname,u.lname")
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->join('user u', 'u.user_id=p.bidder_id', 'LEFT')
			->where('txn.status', 'Y');
			
			$this->db->where("p_txn.project_id in(select project_id from $projects where user_id=$user_id)");
			$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			if(!empty($srch['status'])){
				$this->db->where('p.status', $srch['status']);
			}
			
			$this->db->group_by('p_txn.project_id');
			$this->db->order_by('p.project_id', 'DESC');
			
		if($for_list){
			$result = $this->db->get()->result_array();
			if($result){
				foreach($result as $k => $v){
					$result[$k]['profile_url'] = base_url('clientdetails/showdetails/'.$v['bidder_id']);
				}
			}
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function get_project_amount_freelancer($srch=array(), $limit=0, $offset=40, $for_list=TRUE){
		$projects = $this->db->dbprefix('projects');
		$user_id = !empty($srch['user_id']) ? $srch['user_id'] : '';
		$this->db->select("p_txn.project_id, p.title, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, txn_row.wallet_id,p.user_id,u.fname,u.lname")
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->join('user u', 'u.user_id=p.user_id', 'LEFT')
			->where('txn.status', 'Y');
			
			$this->db->where("p_txn.project_id in(select project_id from $projects where bidder_id=$user_id)");
			$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			if(!empty($srch['status'])){
				$this->db->where('p.status', $srch['status']);
			}
			
			$this->db->group_by('p_txn.project_id');
			$this->db->order_by('p.project_id', 'DESC');
			
		if($for_list){
			$result = $this->db->get()->result_array();
			/* get_print($result); */
			if($result){
				foreach($result as $k => $v){
					$result[$k]['profile_url'] = base_url('clientdetails/showdetails/'.$v['user_id']);
				}
			}
		}else{
			$result = $this->db->get()->num_rows();
		}
		
		return $result;
	}
	
	public function getPendingPaymentProject($user_id=''){
		$total_credit = $total_debit = $total = 0;
		$projects = $this->db->dbprefix('projects');
		$this->db->select("p_txn.project_id, p.title, SUM( txn_row.debit) AS total_debit, SUM( txn_row.credit) AS total_credit, txn_row.wallet_id")
			->from('project_transaction p_txn') 
			->join('transaction_new txn', 'txn.txn_id=p_txn.txn_id')
			->join('transaction_row txn_row', 'txn_row.txn_id=p_txn.txn_id')
			->join('projects p', 'p.project_id=p_txn.project_id', 'LEFT')
			->where('txn.status', 'Y');
			
			$this->db->where("p_txn.project_id in(select project_id from $projects where user_id=$user_id)");
			$this->db->where('txn_row.wallet_id', ESCROW_WALLET);
			$this->db->group_by('p_txn.project_id');
			$this->db->order_by('p.project_id', 'DESC');
			
		$result = $this->db->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$total_credit += $v['total_credit'];
				$total_debit += $v['total_debit'];
			}
			
			$total = $total_credit - $total_debit;
			$total =  number_format($total, 2, '.', '');
			
		}
		
		return $total;
		
	}
	
	public function getFreelancerPendingPaymentProject($user_id=''){
		$total = 0;
		/* $this->db->select('sum((e.bidder_amt+e.admin_fee)) as total') */
		$this->db->select('sum(e.amount) as total')
			->from('bids b')
			->join('project_milestone m', 'm.bid_id=b.id', 'INNER')
			->join('escrow_new e', 'e.milestone_id=m.id', 'LEFT');
		
		$this->db->where('b.bidder_id', $user_id);
		$this->db->where('e.status', 'P');
		
		$result = $this->db->get()->row_array();
		
		if($result && $result['total']){
			$total = $result['total'];
		}
		
		/* $this->db->select('*')
			->from('project_tracker t')
			->where('t.worker_id', $user_id)
			->where('t.payment_status', 'I')
			->where('t.stop_time <>', '0000-00-00 00:00:00');
			
		$result = $this->db->get()->result_array();
		
		if(count($result) > 0){
			foreach($result as  $key => $vals){
				
				$total_cost_new = 0;
				 $data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$vals['project_id'],'bidder_id'=>$vals['worker_id'])));
				$client_amt = $data['total_amt'];
			
				if($vals['minute'] > 0){
					$minute_cost_min = ($client_amt/60);
					$total_min_cost = $minute_cost_min *floatval($vals['minute']);
					$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
					
				}else{
					$minute_cost_min = ($client_amt/60);
					$total_min_cost = 0; // 0 minutes 
					$total_cost_new=(($client_amt*floatval($vals['hour']))+$total_min_cost);
					
				}
				
				$total += number_format($total_cost_new, 2, '.', '');
			}
		} */
		
		return $total;
		
	}
	public function get_user_documents($user_id=''){		
		return $this->db->where('user_id', $user_id)->get('user_documents')->result_array();	
	}
	
	public function make_profile_feature($user_id='', $month=1){
		$last_update_date = date('Y-m-d');
		$update_till = null;
		$update_till = date('Y-m-d', strtotime("+{$month} month"));
		
		$old_date = getField('featured_till', 'user', 'user_id', $user_id);
		$remaining_days = 0;
		
		if($old_date != '0000-00-00'){
			$old_date_time = strtotime($old_date);
			$today_date_time = strtotime(date('Y-m-d'));
			if($old_date_time > $today_date_time){
				$day_diff = (int) (($old_date_time - $today_date_time)/(60*60*24)); /* in days */ 
				if($day_diff > 0){
					$remaining_days = $day_diff;
				}
			}
		}
		
		if($remaining_days > 0){
			$new_update_till = date_create($update_till);
			date_add($new_update_till,date_interval_create_from_date_string("{$remaining_days} days"));
			$new_update_till = date_format($new_update_till,"Y-m-d");
		}else{
			$new_update_till = $update_till;
		}
		
		$this->db->where('user_id', $user_id)->update('user', array('featured' => 1, 'featured_last_update' => $last_update_date, 'featured_till' => $new_update_till));
		
		
	}
	
	
	public function check_featured_profile(){
		$today = date('Y-m-d');
		$this->db->where('featured_till <>', '0000-00-00')->where('featured_till <', $today)->update('user', array('featured' => 0));
	}
	
	public function get_support_message($user_id=''){
		$result = $this->db->where('user_id', $user_id)->order_by('id', 'DESC')->get('user_support')->result_array();
		return $result;
	}
	
	public function check_expired_project(){
		$today = date('Y-m-d');
		$this->db->select("p.project_id,(select count(id) from serv_bids where project_id=p.project_id) as bid_count")
			->from('projects p')
			->where('p.status', 'O')
			->where("p.bidding_deadline != '0000-00-00' AND p.bidding_deadline < '$today'")
			->having('bid_count', 0);
			
		$result = $this->db->get()->result_array();
		$p_ids = array();
		if($result){
			foreach($result as $k => $v){
				$p_ids[] = $v['project_id'];
			}
		}
		
		if($p_ids){
			$this->db->where_in('project_id', $p_ids)->update('projects', array('status' => 'E'));
		}
		
	}

}
