<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Postjob extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
		$this->load->helper('recaptcha');
        $this->load->library('MY_Validation');
        $this->load->model('postjob_model');
        $this->load->model('dashboard/dashboard_model');
		$this->load->model('signup/signup_model');
		$this->load->library('form_validation');
       	$this->load->library('editor');
		$this->load->model('notification/notification_model');
        parent::__construct();
		$this->load->helper('url'); //You should autoload this one ;)
		$this->load->helper('ckeditor');
		
		$idiom = $this->session->userdata('lang');
	
		$this->lang->load('postjob',$idiom);
		
    }

    public function index() {
        
			if(!$this->session->userdata('user')){
				redirect(VPATH."login/?refer=postjob");
			}
        
            $breadcrumb=array(
                array(
                   'title'=>__('post_job','Post Job'),'path'=>''
                )
            );
            
			//print_r($this->session->userdata('user'));
			$data['ckeditor'] = $this->editor->geteditor('description','Full');
            
            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('post_job','Post Job'));
			
			if($this->session->userdata('user')){
				
				$user=$this->session->userdata('user');
           /*  $apprivestatus=$this->auto_model->getFeild('verify','user','user_id',$user[0]->user_id);
				if($apprivestatus!='Y'){
					$this->session->set_flashdata('notApprove', 'Your account not approve yet for post job');
					 redirect(VPATH."dashboard/");
				} */
				$data['user_id']=$user[0]->user_id;
				$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id); 
			}   
			
            $head['current_page']='postjob';
			$head['ad_page']='postjob';
            $load_extra=array();
            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
            $data['parent_cat']=$this->auto_model->getcategory("0");			
            $data['parent_skill']=$this->auto_model->getskill("0");
			//echo "<pre>";print_r($data['parent_skill']);die;
            $data['country']=$this->autoload_model->getCountry();
       		$data['state']=$this->autoload_model->getCity("NGA");
			
            $this->layout->set_assest($head);
            $table='contents';
            $by="cms_unique_title";
            $val='postjob';
            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/	
            $this->autoload_model->getsitemetasetting("meta","pagename","Postjob");
            $lay['client_testimonial']="inc/footerclient_logo"; 
            $this->layout->view('jobform',$lay,$data,'normal');            
            
    }
    
    public function getsubcat(){ 
			$lang = $this->session->userdata('lang');
        if($this->input->post('pid')>0){
		  $data=$this->auto_model->getcategory($this->input->post('pid'));   
		}else{
			 $data=array();
		}       
        $result="";    
		$result.="<option value=''>--".__('postjob_select_sub_category','Select Sub Category')."--</option>";    
        foreach($data as $key=>$row){
				
			switch($lang){
						case 'arabic':
							$row['cat_name'] = !empty($row['arabic_cat_name']) ? $row['arabic_cat_name'] : $row['cat_name'];
							break;
						case 'spanish':
							$row['cat_name'] = !empty($row['spanish_cat_name']) ? $row['spanish_cat_name'] : $row['cat_name'];
							break;
						case 'swedish':
							$row['cat_name'] = !empty($row['swedish_cat_name']) ? $row['swedish_cat_name'] : $row['cat_name'];
							break;
						default :
							$row['cat_name'] = $row['cat_name'];
							break;
					}	
				
				
		   $result.="<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";         
        }		
        echo $result;        
    }
	
	public function getsubcatname()
	{ 
		$cid=$this->input->post('catid');
       $catname=$this->auto_model->getFeild('cat_name','categories','cat_id',$cid);
	   echo $catname;        
    }

    public function getsubskill(){ 
		$sid=$this->auto_model->getFeild('cat_id','categories','cat_name',$this->input->post('sid'));
        $data=$this->postjob_model->getcatskill($sid);
        
        $result="";		        
        foreach($data as $key=>$row){		           
		   $result.="<option value='".$row['id']."'>".$row['skill_name']."</option>";         
        }
        echo $result;        
    }   
    
    
    public function check() { 
	
        $this->auto_model->checkrequestajax();
         if($this->input->post()){
          $post_data = $this->input->post();
		
		 
          $insert = $this->postjob_model->post_project($post_data);
         }
    }	

    public function editcheck() { 
        $this->auto_model->checkrequestajax();
         if($this->input->post()){
          $post_data = $this->input->post();
          $insert = $this->postjob_model->updatepost_project($post_data);
         }
    }	

 

    public function uploadattachment(){ 
    
        $config['upload_path'] = ASSETS.'postjob_upload/';
        $config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';
        $this->load->library('upload', $config);
      
        
		if ( ! $this->upload->do_upload())
		{                   
                   $error = array('error' => $this->upload->display_errors());

                   print_r($error);
		}
		else
		{
                    echo "Pass";
		}             
        
    }
    
    
    public function uploadfile(){

  $name=$this->input->post('jbf'); 

   $cat_logo = '';
   $config['upload_path'] = ASSETS.'postjob_upload/';
   $config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx'; 
   $config['encrypt_name'] = 'TRUE';
   
   
   $this->load->library('upload', $config);
   
   $uploaded = $this->upload->do_upload($name);
   
if ( ! $uploaded)
		{                   
                   $error = array('error' => $this->upload->display_errors());

                   print_r($error);
		}
		else
		{
                    echo "Pass";
		}     
   
   
  /* $upload_data = $this->upload->data(); 
   $cat_logo = $upload_data['file_name'];
    echo $cat_logo;*/
 
 }    
    
    public function test(){
         
	$msg = "";
	$fileElementName = 'userfile';	
		//print_r($_FILES);
        $msg= $_FILES['userfile']['name'];

        $config['upload_path'] = 'assets/postjob_upload/';
        $config['allowed_types'] = 'bmp|gif|jpg|jpeg|png|pdf|txt|docx|xls|doc|zip|xl|xlsx';
		$this->load->library('upload', $config);
        $result=array() ;
        if ($this->upload->do_upload('userfile')){
            $upload_data = $this->upload->data();
            $result["msg"]=$upload_data['file_name'];
        }
	echo json_encode($result);		
 }
         
    public function editjob(){ 
		$job_id = $this->uri->segment(3);
        if(!$this->session->userdata('user')){ 
            redirect(VPATH."login?refer=postjob/editjob/".$job_id);
            
        }
        else if($this->uri->segment(3)){ 
            $breadcrumb=array(
                array(
                   'title'=>'Edit Job','path'=>''
                )
            );
            
            $project_id = getField('project_id', 'projects', 'id', $job_id);
			$bid_count = $this->db->where('project_id', $project_id)->count_all_results('bids');
			$data['bid_count'] = $bid_count;
			$data['project_id'] = $project_id;
			/* $this->autoload_model->getsitemetasetting("meta","pagename","Postjob");
			$lay['client_testimonial']="inc/footerclient_logo"; 
			$this->layout->view('edit_job_description',$lay,$data,'normal');  
			 */
		
			$data['ckeditor'] = $this->editor->geteditor('description','Full');
			 $jid=  $this->uri->segment(3);               
			 $data['job_details']=$this->postjob_model->getProject("O",$jid);
			 
			 //$data['job_details']=$this->postjob_model->getProject(" ",$jid);
			
			
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Post Job');
			$user=$this->session->userdata('user');
			$data['user_id']=$user[0]->user_id;                
			$head['current_page']='postjob';
			$load_extra=array();
			
			if($data['job_details'][0]['user_id'] != $data['user_id']){
				show_404();
			 }
			 
			 
			$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);            
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
			$data['parent_cat']=$this->auto_model->getcategory("0");
			$data['parent_skill']=$this->auto_model->getskill("0");
			$this->layout->set_assest($head);
			$table='contents';
			$by="cms_unique_title";
			$val='postjob';
	 
			$this->autoload_model->getsitemetasetting("meta","pagename","Postjob");
			$lay['client_testimonial']="inc/footerclient_logo"; 
			$data['questions'] = get_results(array('select' => '*', 'from' => 'project_questions', 'where' => array('project_id' =>  $data['job_details'][0]['project_id'])));
			//get_print($data['questions']);
			$this->layout->view('editjobform',$lay,$data,'normal');  
			
         
      }
    
    } 
    
    public function member(){ 
            $breadcrumb=array(
                array(
                   'title'=>'Member Information','path'=>''
                )
            );
            
            
            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Member Information');
			if($this->session->userdata('user'))
			{
                            $user=$this->session->userdata('user');
                            $data['user_id']=$user[0]->user_id;
                            $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);            

                        }   
            $head['current_page']='postjob';
            $load_extra=array();
            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
            $data['parent_cat']=$this->auto_model->getcategory("0");
            $data['parent_skill']=$this->auto_model->getskill("0");
            $data['country']=$this->signup_model->getCountry();
            $data['city']=$this->signup_model->getcity();
            $this->layout->set_assest($head);
            $table='contents';
            $by="cms_unique_title";
            $val='postjob';
            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/	
            $this->autoload_model->getsitemetasetting("meta","pagename","Postjob");
            $lay['client_testimonial']="inc/footerclient_logo"; 
            $this->layout->view('member_info',$lay,$data,'normal');             
        
        
    }
    
    public function newuserLogin($uid=""){ 
        if($uid==""){ 
            redirect(VPATH."login");
        }
        else{ 
            $this->db->select('user_id, username, email,ldate,membership_plan,membership_end,membership_upgrade,acc_balance');
            $this->db->where('user_id',$uid);
            $query=$this->db->get('user');
            $result = $query->result();
            $this->session->set_userdata('user', $result);
            redirect(VPATH."postjob");
        }
    }
	
	public function rmvimage($img)
	{
		$file="assets/postjob_upload/".$img;
		unlink($file);
		echo "1";	
	}
     public function getskills(){ 
	 $lang=$this->session->userdata('lang');
     $result=array();
     if($this->input->get('q')){
     	$q=$this->input->get('q');
		// $res=$this->db->select('skill_name,id')->like('skill_name', $q,'after')->where('parent_id <>', 0)->get('skills');
		
		switch($lang){
				case 'arabic':
					$res=$this->db->select('arabic_skill_name as skill_name,id')->like('arabic_skill_name', $q,'after')->where('parent_id <>', 0)->get('skills');
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$res=$this->db->select('spanish_skill_name as skill_name,id')->like('spanish_skill_name', $q,'after')->where('parent_id <>', 0)->get('skills');
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$res=$this->db->select('swedish_skill_name as skill_name,id')->like('swedish_skill_name', $q,'after')->where('parent_id <>', 0)->get('skills');
					break;
				default :
					$res=$this->db->select('skill_name,id')->like('skill_name', $q,'after')->where('parent_id <>', 0)->get('skills');
					break;
			}
		
     	
     	foreach ($res->result() as $row){
	 	$result['items'][]=array(
	 			'id'=>$row->id,
	 			'name'=>$row->skill_name,
	 			"full_name"=>$row->skill_name,
	 			);
	 	}
	 }elseif($this->input->get('sid')){
	 	$sid=$this->auto_model->getFeild('cat_id','categories','cat_name',$this->input->get('sid'));
	 	// $res=$this->db->select('skill_name')->get_where('skills',array('parent_id'=>$sid));
		
		switch($lang){
				case 'arabic':
					$res=$this->db->select('arabic_skill_name as skill_name')->get_where('skills',array('parent_id'=>$sid));
					break;
				case 'spanish':
					//$categoryName = $val['spanish_cat_name'];
					$res=$this->db->select('spanish_skill_name as skill_name')->get_where('skills',array('parent_id'=>$sid));
					break;
				case 'swedish':
					//$categoryName = $val['swedish_cat_name'];
					
					$res=$this->db->select('swedish_skill_name as skill_name')->get_where('skills',array('parent_id'=>$sid));
					break;
				default :
					$res=$this->db->select('skill_name')->get_where('skills',array('parent_id'=>$sid));
					break;
			}
		
     	foreach ($res->result() as $row){
	 	$result['items'][]=array(
	 			'id'=>$row->skill_name,
	 			'name'=>$row->skill_name,
	 			"full_name"=>$row->skill_name,
	 			);
	 	}
	 }
		
        echo json_encode($result);        
    }
	
	public function search_freelancer(){
		$data = array();
		$term = get('term');
		$data['list'] = $this->postjob_model->search_freelancer($term);
		$data['project_id'] = get('project_id');
		$this->load->view('freelancer_list', $data);
	}
	
	public function edit_description(){
		$json = array();
		$user = $this->session->userdata('user');
		if(post() && $this->input->is_ajax_request() && $user){
			$project_id = filter_data(post('project_id'));
			$description = filter_data(post('description'));
			$data = array(
				'description' => $description,
				'project_id' => $project_id,
				'datetime' => date('Y-m-d H:i:s'),
			);
			$pid = getField('id', 'projects', 'project_id', $project_id);
			$this->db->insert('project_description', $data);
			
			$bidders_q = array(
				'select' => 'bidder_id',
				'from' => 'bids',
				'where' => array('project_id' => $project_id),
				
			);
			
			$bidders = get_results($bidders_q);
			$e_f_name = getField('fname', 'user', 'user_id', $user[0]->user_id);
			$e_l_name = getField('lname', 'user', 'user_id', $user[0]->user_id);
			$employer = $e_f_name.' '.$e_l_name;
			$project_title  = getField('title', 'projects', 'project_id', $project_id);
			if(count($bidders) > 0){
				foreach($bidders as $bidder){
					$bidder_id = $bidder['bidder_id'];
					
					$notification = "$employer edited description for project ".$project_title;
					$link = "jobdetails/details/".$project_id;
					$this->notification_model->log($user[0]->user_id, $bidder_id, $notification, $link);
				}
				
			}
			
			$json['status'] = 1;
			$json['message']="<div class='alert alert-success text-center'><h3 class='postjob-alert-title'><span style='margin-right:10px'><i class='fa fa-check'></i></span>Job Edit Success.</h3>
			<p> What would you like to do next?</p> <ul class='alert-choice'><li><a href='".VPATH."jobdetails/details/".$project_id."'>Preview your job </a></li> <li><a  href='".VPATH."postjob/editjob/".$pid."'> Edit your job </a> </li><li><a  href='".VPATH."postjob'> Post another job </a> </li></ul></div>";
		}else{
			$json['status'] = 0;
		}
		
		echo json_encode($json);
	}			public function repost() {        		if(!$this->session->userdata('user')){			redirect(VPATH."login/?refer=postjob");		}        $project_id = get('project_id');		$breadcrumb=array(			array(			   'title'=>__('post_job','Post Job'),'path'=>''			)		);		$data['ckeditor'] = $this->editor->geteditor('description','Full');		$data['job_details']=$this->db->where('project_id', $project_id)->get('projects')->result_array();				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('post_job','Post Job'));				if($this->session->userdata('user')){						$user=$this->session->userdata('user');	  			$data['user_id']=$user[0]->user_id;			$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id); 		}   				$head['current_page']='postjob';		$head['ad_page']='postjob';		$load_extra=array();		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);		$data['parent_cat']=$this->auto_model->getcategory("0");					$data['parent_skill']=$this->auto_model->getskill("0");			$data['country']=$this->autoload_model->getCountry();		$data['state']=$this->autoload_model->getCity("NGA");				$this->layout->set_assest($head);		$table='contents';		$by="cms_unique_title";		$val='postjob';		$this->autoload_model->getsitemetasetting("meta","pagename","Postjob");		$lay['client_testimonial']="inc/footerclient_logo"; 		$this->layout->view('repostjob',$lay,$data,'normal');                }	
    
}
