<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projecthourly extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('projectdashboard_model');
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('findtalents/findtalents_model');
		$this->offset = 10;
		$this->load->library('pagination');
        parent::__construct();
		
    }

    public function employer(){
		                 
            if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}  
		
		$user=$this->session->userdata('user');
           
        $limit=0;   
        $data['pid']=$pid=$this->uri->segment(3);
		
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['project_details']=$this->projectdashboard_model->getprojectdetails($data['pid']);
		
		
		
        $breadcrumb=array(
            array(
                    'title'=>'Project Dashboard','path'=>''
            )
        );

        ////////////////////////pagination start////////////////////////////
		$search_parameters = $this->input->get();
        $data['search_parameters'] = $search_parameters;
        $pagination_string = '';
        if (isset($search_parameters['limit'])) {
            if ($search_parameters['limit'] != "" && is_numeric($search_parameters['limit'])) {
                $limit = $search_parameters['limit'];
            }

            unset($search_parameters['limit']);
            unset($search_parameters['page']);
        }
        if (count($search_parameters) > 1) {
            $pagination_string = http_build_query($search_parameters);
        }
		
		////////////////////////pagination end//////////////////////////////
		
		$data['tracker_details']=$this->projectdashboard_model->getprojecttracker($data['pid'],$search_parameters, $this->offset, $limit);
		
		$data['pagination'] = $this->projectdashboard_model->listing_search_pagination($data['pid'],$pagination_string, $this->offset);
		
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Job Details');
		$head['current_page']='project_dashboard';
		
		$head['ad_page']='project_dashboard';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting();

        $lay['client_testimonial']="inc/footerclient_logo";
        
		$sess_user_id_p=$user[0]->user_id;
		$user_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
		if($sess_user_id_p==$user_id){
			$data['showpaush']=1;	
		}else{
			$data['showpaush']=0;	
		}
		$data['currentstats']=$this->auto_model->getFeild('status','projects','project_id',$pid);
		



        $this->layout->view('client_dashboard',$lay,$data,'normal');

        
    }
	
	public function freelancer()
	{
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}  
		
		$user=$this->session->userdata('user');
        $limit=0;   
            
        $data['pid']=$pid=  $this->uri->segment(3);
		
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['project_details']=$this->projectdashboard_model->getprojectdetails($data['pid']);
		
		
		
        $breadcrumb=array(
            array(
                    'title'=>'Project Dashboard','path'=>''
            )
        );

        
		////////////////////////pagination start////////////////////////////
		$search_parameters = $this->input->get();
        $data['search_parameters'] = $search_parameters;
        $pagination_string = '';
        if (isset($search_parameters['limit'])) {
            if ($search_parameters['limit'] != "" && is_numeric($search_parameters['limit'])) {
                $limit = $search_parameters['limit'];
            }

            unset($search_parameters['limit']);
            unset($search_parameters['page']);
        }
        if (count($search_parameters) > 1) {
            $pagination_string = http_build_query($search_parameters);
        }
		
		////////////////////////pagination end//////////////////////////////
		
		$data['tracker_details']=$this->projectdashboard_model->getprojecttracker($data['pid'],$search_parameters, $this->offset, $limit);
		
		$data['pagination'] = $this->projectdashboard_model->listing_search_pagination($data['pid'],$pagination_string, $this->offset);
		
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Job Details');
		$head['current_page']='project_dashboard';
		
		$head['ad_page']='project_dashboard';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting();

        $lay['client_testimonial']="inc/footerclient_logo";

        $this->layout->view('freelancer_dashboard',$lay,$data,'normal');

        
    	
	}
	public function screenshot()
	{
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}  
		
		$user=$this->session->userdata('user');
         
		$data['tracker_id']=$this->uri->segment(3);  
            
        $data['pid']=$this->auto_model->getFeild('project_id','project_tracker','id',$data['tracker_id']);
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$data['pid']);
		
		$data['screenshot_date']=$this->auto_model->getFeild('start_time','project_tracker','id',$data['tracker_id']);
		
		$data['tracker_details']=$this->projectdashboard_model->getscreenshot($data['tracker_id']);
		
        $breadcrumb=array(
            array(
                    'title'=>'Project Sreenshot','path'=>''
            )
        );

        
        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Job Details');
		$head['current_page']='project_dashboard';
		
		$head['ad_page']='project_dashboard';

        $load_extra=array();

        $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

        $this->layout->set_assest($head);

        $this->autoload_model->getsitemetasetting();

        $lay['client_testimonial']="inc/footerclient_logo";

        $this->layout->view('screenshot',$lay,$data,'normal');

        
    	
	}
	public function paushjob(){
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}
		$pid=$this->input->post('id');
		
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$upd=$this->projectdashboard_model->paushProject($pid,$user_id);	
		if($upd)
		{
			$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
			$bidder_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
			$bidder_name=$this->auto_model->getFeild('fname','user','user_id',$bidder_id)." ".$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
			$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
			/*$from=ADMIN_EMAIL;
			$to=$employer_email;
			$template='job_closed_notification';
			$data_parse=array('title'=>$projects_title, 
								'name'=>ucwords($bidder_name)
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			 */
			 $data_notification=array( 
			   "from_id" =>$employer_id,
			   "to_id" =>$employer_id,
			   "notification" =>"You have successfully paush the project : ".$projects_title,
			   "add_date"  => date("Y-m-d")
			 );
			 $data_notic=array( 
			   "from_id" =>$employer_id,
			   "to_id" =>$bidder_id,
			   "notification" =>"Employer has successfully paush the project ".$projects_title,
			   "add_date"  => date("Y-m-d")
			 );
			 
			 $this->dashboard_model->insert_notification($data_notification);
			 
			 $this->dashboard_model->insert_notification($data_notic);
			
				
		}
		ob_start();
		ob_clean();
		echo $upd;
		
		
	}

}
