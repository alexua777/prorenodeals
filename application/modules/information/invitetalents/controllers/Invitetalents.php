<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class invitetalents extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('invitetalents_model');
        $this->load->library('pagination');
        $this->load->model('findjob/findjob_model');
		$this->load->model('findtalents/findtalents_model');
        $this->load->model('message/message_model');
        $this->load->model('dashboard/dashboard_model');
        
        
		$this->load->model('dashboard/dashboard_model');
	//$this->load->library('form_validation');
        parent::__construct();
    }

    public function index($pid,$limit_from='') {

		//$user=$this->session->userdata('user');

	      //  $userid=$user[0]->user_id;
        
        
        
        
		$breadcrumb=array(
                    array(
                            'title'=>'All Talents','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Talents');

		///////////////////////////Leftpanel Section start//////////////////

		$data['parent_skill']=$this->auto_model->getskill("0");
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
		//$data['leftpanel']=$this->autoload_model->job_leftpanel($parent_cat);

		///////////////////////////Leftpanel Section end//////////////////
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'invitetalents/index/'.$pid."/";
		//$total_rows=$this->db->get_where('user',array('status'=>'Y'))->num_rows();
		$total_rows=$this->invitetalents_model->gettalents_count();
                
                $config['total_rows'] =$total_rows;
		$config['per_page'] = 5; 
		$config["uri_segment"] = 4;
		$config['use_page_numbers'] = TRUE;   
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		
                $data['total_rows']=$total_rows;
                
                $data['countries']= $this->findjob_model->getCountry();
                
		$data['talents']=$this->findtalents_model->gettalents($config['per_page'],$start);

		$head['current_page']='invitetalents';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);



		$this->autoload_model->getsitemetasetting("meta","pagename","Invitetalents");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('list',$lay,$data,'normal');

    }
	
	public function getsrch()
	{
		
               $stext=$this->uri->segment(3);
            
               $cat=$this->uri->segment(4);
			   $cat=str_replace("-",",",$cat);
            	
                $country=$this->uri->segment(5);
		$total_rows="";
		if($stext!='_'){    
                    
                    $total_rows=$this->invitetalents_model->getFilertalentSearchCount($stext,$cat,$country);   
                    $data['total_rows']=$total_rows;
                    $data['talents']=$this->invitetalents_model->gettalents_search($stext,$cat,$country);   
		
                    
                }
                else {
                    $total_rows=$this->invitetalents_model->getFilertalentCount($cat,$country);
                    $data['total_rows']=$total_rows;
                    $data['talents']= $this->invitetalents_model->getFilertalent($cat,$country);
                }
              
			
		$this->layout->view('ajax_talentlist', '', $data, 'ajax', 'N');
		//return $data['gallery'];
	}
	
    

    public function filtertalent($limit_from='') {

		$breadcrumb=array(
                    array(
                            'title'=>'All Talents','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Talents');

		///////////////////////////Leftpanel Section start//////////////////

		$data['parent_skill']=$this->auto_model->getskill("0");

		//$data['leftpanel']=$this->autoload_model->job_leftpanel($parent_cat);

		///////////////////////////Leftpanel Section end//////////////////

                
                $data['countries']= $this->findjob_model->getCountry();
                
/**************** Search Condition Start  **************************/
        $pid=$this->uri->segment(3);	
		$skill=$this->uri->segment(4);		
		$data['skill']=$skill=str_replace("-",",",$skill);
		$data['country']=$country=$this->uri->segment(5);
		
		//$skill=$skill;
		$country=str_replace('%20',' ',$country);                
                
                
                
/****************** Search Condition Start **************************/
                                
                
                $data['talents']=$this->invitetalents_model->getFilertalent($skill,$country);
		
                
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'invitetalents/filtertalent/'.$pid.'/'.$skill.'/All/';
		$total_rows=$this->invitetalents_model->getFilertalentCount($skill,$country);
                
                $config['total_rows'] =$total_rows;
		$config['per_page'] = 5; 
		$config["uri_segment"] = 6;
		$config['use_page_numbers'] = TRUE;   
		$config['full_tag_open'] = "<ul class='pagination'>";
                $config['full_tag_close'] = '</ul>';
                $config['first_link'] = 'First';
                $config['first_tag_open'] = '<li>';
                $config['first_tag_close'] = '</li>';
                $config['num_tag_open'] = '<li>';
                $config['num_tag_close'] = '</li>';
                $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'><b>";
                $config['cur_tag_close'] = '</b></a></li>';
                $config['last_tag_open'] = "<li class='last'>";
                $config['last_tag_close'] = '</li>';
                $config['next_link'] = 'Next &gt;&gt;';
                $config['next_tag_open'] = "<li>";
                $config['next_tag_close'] = '</li>';
                $config['prev_link'] = '&lt;&lt; Previous';
                $config['prev_tag_open'] = '<li>';
                $config['prev_tag_close'] = '</li>'; 
		$this->pagination->initialize($config); 
		$page = ($limit_from) ? $limit_from : 0;
                $per_page = $config["per_page"];
                $start = 0;
                if ($page > 0) {
                    for ($i = 1; $i < $page; $i++) {
                        $start = $start + $per_page;
                    }
                }
		
                
                $data['total_rows']=$total_rows;                
                
		$head['current_page']='findtalent';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Invitetalents");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('list',$lay,$data,'normal');

    }
    
    public function inviteFriends(){ 
       
        $invite_list="";        
        foreach($this->input->post("invite_freelancer") as $val){ 
            $fmail=$this->autoload_model->getFeild("email","user","user_id",$val);
            $invite_list.=$fmail.",";
        }        
        $invite_list=  rtrim($invite_list,",");
       
        $pid=  $this->uri->segment("3");
        
        $project_name=$this->autoload_model->getFeild("title","projects","id",$pid);
        
        $project_id=$this->autoload_model->getFeild("project_id","projects","id",$pid);
        
        $project_visibility=$this->autoload_model->getFeild("visibility_mode","projects","id",$pid);
        
        
        
        $user=$this->session->userdata('user');

        $frm_email=$this->autoload_model->getFeild("email","user","user_id",$user[0]->user_id);
        
        $fname=$this->autoload_model->getFeild("fname","user","user_id",$user[0]->user_id);
        $lname=$this->autoload_model->getFeild("lname","user","user_id",$user[0]->user_id);
        
                
        $link=VPATH."jobdetails/details/".$project_id;
        
			$from=$frm_email;
			$to=$invite_list;
			$template='invite_freelancer';
			$data_parse=array(
                            'name' =>"Sir",
                            'username'=>$fname." ".$lname,                                                        
                            'project_name' => $project_name,
                            'copy_url'=>$link,
                            'url_link'=>$link
                        );
                        
        
        foreach($this->input->post("invite_freelancer") as $val){ 
            $fmail=$this->autoload_model->getFeild("email","user","user_id",$val);
            $invite_list.=$fmail.",";
            
            $data=array(
                "project_id" =>$project_id,
                "invite_userid"=>$val,
                "inviteuser_email"=>$fmail,
                "invite_date"=>date("Y-m-d")                
            );
            $this->invitetalents_model->insertInvite($data);
            $this->session->set_flashdata('invite_success', 'Invite Mail Send Successfuly.');
            if($project_visibility=="Private"){                 
                $data=array(
                    "project_id"=>$project_id,
                    "recipient_id"=>$val,
                    "sender_id"=>$user[0]->user_id,
                    "message"=>"You are invited for the project '".$project_name."'",
                    "add_date" =>date("Y-m-d H:i:s")
                );                
                $this->message_model->insertMessage($data);                
            }
            else{ 
                $data=array(                    
                    "to_id"=>$val,
                    "from_id"=>$user[0]->user_id,
                    "notification"=>"You are invited for the project '".$project_name."'",
                    "add_date" =>date("Y-m-d")
                );                
                $this->dashboard_model->insert_notification($data);                  
            }
             
        }               
        $this->auto_model->send_email($from,$to,$template,$data_parse);
        redirect(VPATH."dashboard/myproject_client");        
    }
    
    
    public function inviteGuestFreelancer(){ 
      
        $pid=  $this->input->post("priject_id");
        
        $project_name=$this->autoload_model->getFeild("title","projects","id",$pid);
        
        $project_id=$this->autoload_model->getFeild("project_id","projects","id",$pid);
        
        
        $user=$this->session->userdata('user');

        $frm_email=$this->autoload_model->getFeild("email","user","user_id",$user[0]->user_id);
        
        $fname=$this->autoload_model->getFeild("fname","user","user_id",$user[0]->user_id);
        $lname=$this->autoload_model->getFeild("lname","user","user_id",$user[0]->user_id);
        
                
        $link=VPATH."jobdetails/details/".$project_id;
        
			$from=$frm_email;			
			$template='invite_freelancer';
            
        $i=0;  
        
        $email_list=$this->input->post("femail");
        $name_list=$this->input->post("fname");

       
        
        
        for($i=0;$i<count($email_list) && $i<count($name_list);$i++){ 
            if($email_list[$i]!="" && $name_list[$i]!=""){ 
                    $data_parse=array(
                        'name' =>$name_list[$i],
                        'username'=>$fname." ".$lname,                                                        
                        'project_name' => $project_name,
                        'copy_url'=>$link,
                        'url_link'=>$link
                    );               
                $to=$email_list[$i];
                
                
                $data_g=array(
                    "user_name"=>$fname." ".$lname,
                    "user_email"=>$frm_email,
                    "friend_name"=>$name_list[$i],
                    "friend_email"=>$email_list[$i],
                    "reg_status"=>'N',
                    "project_id"=>$project_id,
                    "invite_date"=>date("Y-m-d H:i:s")     
                );
                
                $this->invitetalents_model->insertInviteGuest($data_g);
                $this->auto_model->send_email($from,$to,$template,$data_parse);                
                
            }
        }                    
                        
        redirect(VPATH."dashboard/myproject_client");
        
        
    }
	
	public function invitefreelancer($freelancer_id,$projects_id,$page)
	{		 
        
        $invite_list="";        
        $fmail=$this->autoload_model->getFeild("email","user","user_id",$freelancer_id);
        $invite_list=$fmail;      
       
        $pid=  $projects_id;
        
        $project_name=$this->autoload_model->getFeild("title","projects","id",$pid);
        
        $project_id=$this->autoload_model->getFeild("project_id","projects","id",$pid);
        
        $project_visibility=$this->autoload_model->getFeild("visibility_mode","projects","id",$pid);
        
        
        
        $user=$this->session->userdata('user');

        $frm_email=$this->autoload_model->getFeild("email","user","user_id",$user[0]->user_id);
        
        $fname=$this->autoload_model->getFeild("fname","user","user_id",$user[0]->user_id);
        $lname=$this->autoload_model->getFeild("lname","user","user_id",$user[0]->user_id);
        
                
        $link=VPATH."jobdetails/details/".$project_id;
        
			$from=$frm_email;
			$to=$invite_list;
			$template='invite_freelancer';
			$data_parse=array(
                            'name' =>"Sir",
                            'username'=>$fname." ".$lname,                                                        
                            'project_name' => $project_name,
                            'copy_url'=>$link,
                            'url_link'=>$link
                        );
                        
        
       
            $fmail=$this->autoload_model->getFeild("email","user","user_id",$freelancer_id);
            $invite_list=$fmail;
            
            $data=array(
                "project_id" =>$project_id,
                "invite_userid"=>$freelancer_id,
                "inviteuser_email"=>$fmail,
                "invite_date"=>date("Y-m-d")                
            );
            $this->invitetalents_model->insertInvite($data);
            $this->session->set_flashdata('invite_success', 'Invite Mail Send Successfuly.');
            if($project_visibility=="Private"){                 
                $data=array(
                    "project_id"=>$project_id,
                    "recipient_id"=>$freelancer_id,
                    "sender_id"=>$user[0]->user_id,
                    "message"=>"You are invited for the project '".$project_name."'",
                    "add_date" =>date("Y-m-d H:i:s")
                );                
                $this->message_model->insertMessage($data);                
            }
            else{ 
                $data=array(                    
                    "to_id"=>$freelancer_id,
                    "from_id"=>$user[0]->user_id,
                    "notification"=>"You are invited for the project '".$project_name."'",
                    "add_date" =>date("Y-m-d")
                );                
                $this->dashboard_model->insert_notification($data);                  
            }
             
                      
        $this->auto_model->send_email($from,$to,$template,$data_parse);
		if($page=="findtalents")
		{
        	redirect(VPATH."findtalents/");        
    	}
		else if($page="clientdetails")
		{
			redirect(VPATH."clientdetails/showdetails/".$freelancer_id."/");
		}
	}
    
    
}
