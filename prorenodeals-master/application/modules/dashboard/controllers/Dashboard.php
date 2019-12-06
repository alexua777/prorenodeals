<?php
if (!defined('BASEPATH'))

    exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct()
	{
        $this->load->model('dashboard_model');
		$this->load->model('references/references_model');
		$this->load->model('postjob/postjob_model');
		$this->load->model('notification/notification_model');
		$idiom=$this->session->userdata('lang');
		$this->lang->load('dashboard', $idiom);
		$this->lang->load('form_validation', $idiom);
        parent::__construct();
		$this->dashboard_model->check_featured_profile();
    }
	
	public function dashboard_new() {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=dashboard/overview");
		}
		
		$this->dashboard_model->check_expired_project();
		
		$data = array();
		$user = $this->session->userdata('user');
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo=base_url("assets/images/user.png");
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo=base_url("assets/uploaded/cropped_".$logo);
			}else{
				$logo=base_url("assets/uploaded/".$logo);
			}
		}
		$breadcrumb=array(
			array(
					'title'=>'Dashboard','path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		
		/*---------------[ GLOBAL VARIABES  ] -----------------------------*/
		
		$data['account_type'] = $user[0]->account_type;
		$data['user_id'] = $user[0]->user_id;
		
		/*---------------[ END OF GLOBAL VARIABES ] -----------------------------*/
		
		if($data['account_type'] == 'F'){
			
			$data['recent_bids'] = $this->dashboard_model->getRecentBidProjects($data['user_id']);
			$data['earned_amount'] = get_earned_amount($data['user_id']);
			$data['total_bids'] = get_total_bids($data['user_id']);
			
			$data['total_ongoing_project'] =$this->dashboard_model->getProjectCountFreelancer($data['user_id'], 'P');
			$data['total_completed_project'] =$this->dashboard_model->getProjectCountFreelancer($data['user_id'], 'C');
			
			$data['completed_project'] = $this->dashboard_model->get_project_amount_freelancer(array('user_id' => $data['user_id'], 'status' => 'C'));
			$data['inprogress_project'] = $this->dashboard_model->get_project_amount_freelancer(array('user_id' => $data['user_id'], 'status' => 'P'));
			
			
		}else{
			
			$data['recent_project'] = $this->dashboard_model->getRecentProjects($data['user_id']);
			$data['spend_amount'] = get_project_spend_amount($data['user_id']);
			$data['total_posted_work'] = get_total_project_post($data['user_id']);
			
			$data['total_ongoing_project'] =$this->dashboard_model->getProjectCount($data['user_id'], 'P');
			$data['total_completed_project'] =$this->dashboard_model->getProjectCount($data['user_id'], 'C');
			
			$data['project_statics'] = $this->dashboard_model->getProjectStatics($data['user_id']);
			
			$data['escrow_statics'] = $this->dashboard_model->getEscrowProject($data['user_id']);
			
			$data['completed_project'] = $this->dashboard_model->get_project_amount(array('user_id' => $data['user_id'], 'status' => 'C'));
			$data['inprogress_project'] = $this->dashboard_model->get_project_amount(array('user_id' => $data['user_id'], 'status' => 'P'));
			
			//get_print($data['recent_project']);
		}
		if($data['account_type'] == 'F'){
			$this->layout->view('dashboard_freelancer','',$data,'normal');  
		}else{
			$this->layout->view('dashboard_employer','',$data,'normal');  
		}
		
    }
	
    public function index() {
	if(!$this->session->userdata('user'))
	{
		redirect(VPATH."login/");
	}
	else
	{
		$user=$this->session->userdata('user');

		 if($user){

			 /* if($user[0]->account_type == 'E'){
			 redirect(VPATH."dashboard/myproject_client");
			 }
			 else{
			 redirect(VPATH."dashboard/myproject_working");
			} */
			
			redirect(base_url('dashboard/overview'));
		 }

		/** Smartbuzz pass Account type to Session */
		$data['account_type']=$user[0]->account_type;
		$data['user_id']=$user[0]->user_id;
		$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$data['ldate']=$user[0]->ldate;
		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')
		{
			$logo="images/user.png";
		}
		else
		{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		/************Project section***********************/
		$status='O';
		$data['projects']=$this->dashboard_model->getProject($status,$data['user_id']);
		$data['proposals']=$this->dashboard_model->getProposals_dashboard($data['user_id'],20);

		/***********************************/


		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='dashboard';
		$head['ad_page']='dashboard';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$table='contents';
		$by="cms_unique_title";
		$val='login';
        $data['notification']=$this->dashboard_model->getNotification($user[0]->user_id);
		$data['user_skill']=$this->dashboard_model->getskillsname($user[0]->user_id);
		$data['parent_skill']=$this->dashboard_model->getcatskill(0);
		if (count($data['parent_skill']) > 0)
		{
			foreach ($data['parent_skill'] as $ts) {
			$sk_name=addslashes($ts['skill_name']);
			$jsarr[] = "'" . $sk_name . "'";
		   }
		}
		$data['ahead'] = implode(',', $jsarr);
		$this->autoload_model->getsitemetasetting("meta","pagename","Dashboard");
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('dashboard',$lay,$data,'normal');
	}

  }

  public function delete_skill($skill_id)
  {
  		$a="";
  		$user=$this->session->userdata('user');
  		$user_id=$user[0]->user_id;
		$skills=$this->auto_model->getFeild('skills_id','user_skills','user_id',$user_id);
		$new_skill=str_replace($skill_id,'',$skills);
		/*$query="UPDATE serv_user_skills SET skills_id =
TRIM(BOTH ',' FROM REPLACE(CONCAT(',', skills_id, ','),
CONCAT(',',".$skill_id.", ','), ','))
WHERE FIND_IN_SET(".$skill_id.", skills_id) and user_id = ".$user_id."";
		$this->db->query($query);*/
		$post_data['skills_id']=$new_skill;
		$this->auto_model->update_data('user_skills',$post_data,array('user_id'=>$user_id));
		$all_skill=$this->auto_model->get_results('user_skills',array('user_id'=>$user_id));
		$user_skill=explode(",",$all_skill[0]['skills_id']);
		if($user_skill!=""){
		  foreach($user_skill as $key => $val){
		  if($val!='')
		  {
		 $skill_name=$this->auto_model->getFeild('skill_name','skills','id',$val);

		  $a.='<a href="'.VPATH.'findtalents/filtertalent/'.$val.'/All/" class="skilslinks">'.$skill_name.'</a> <span class="delete_remove"><a href="javascript:void(0)" title="Delete" onclick=userrmv_skill("'.$val.'")><i class="fa fa-trash"></i></a></span>';
            }
		  }
		}
		else{
			  $a.="No Skill Set Yet";
		}
		echo $a;
  }

  public function add_skill()
  {
  		$a="";
		$skill_id="";
		$skills=$this->input->post('skill');
  		$user=$this->session->userdata('user');
  		$user_id=$user[0]->user_id;
		$upd_skill=explode(",",$skills);

		if($upd_skill!=""){
		  foreach($upd_skill as $key => $val){
			  if($val!='')
			  {

				$skill_id.=$this->auto_model->getFeild('id','skills','skill_name',$val).",";
			  }
		 	}
		}
		$skill_id=rtrim($skill_id,",");
		$skills=$this->auto_model->getFeild('skills_id','user_skills','user_id',$user_id);
		$new_skill="";
		if($skills=="")
		{
			$new_skill=$skill_id;
		}
		else
		{
			$new_skill=$skills.",".$skill_id;
		}

		$post_data['skills_id']=$new_skill;
		$count_row=$this->auto_model->count_results('*','user_skills','','',array('user_id'=>$user_id));
		if($count_row==0)
		{
			$post_data['user_id']=$user_id;
			$post_data['add_date']=date("Y-m-d");
			$this->auto_model->insert_data('user_skills',$post_data);
		}
		else
		{
			$this->auto_model->update_data('user_skills',$post_data,array('user_id'=>$user_id));
		}
		$all_skill=$this->auto_model->get_results('user_skills',array('user_id'=>$user_id));

		$user_skill=explode(",",$all_skill[0]['skills_id']);

		if($user_skill!=""){
		  foreach($user_skill as $key => $val){
		  if($val!='')
		  {
		 $skill_name=$this->auto_model->getFeild('skill_name','skills','id',$val);

		  $a.='<a href="'.VPATH.'findtalents/filtertalent/'.$val.'/All/" class="skilslinks">'.$skill_name.'</a> <span class="delete_remove" style="display:none;"><a href="javascript:void(0)" title="Delete" onclick=userrmv_skill("'.$val.'")><i class="fa fa-trash"></i></a></span>';
            }
		  }
		}
		else{
			  $a.="No Skill Set Yet";
		}
		echo $a;
  }

    public function profile_professional() {

    if(!$this->session->userdata('user'))

    {

            redirect(VPATH."login/");

    }

    else

    {

            $user=$this->session->userdata('user');

            $data['user_id']=$user[0]->user_id;
			
			 $data['total_plan_skill']=  $this->auto_model->getFeild("skills","membership_plan","id",$user[0]->membership_plan);
			 $data['parent_skill']=$this->auto_model->getskill("0");
			
			$data['account_type'] = $user[0]->account_type;
			
			if($this->input->post()){
				$post = filter_data($this->input->post());
				if(!empty($post['submit']) && $post['submit'] == 'edit_hour'){
					if(empty($post['available_week'])){
						$post['available_week'] = 0;
					}
				
					$this->db->set('available_hr' , trim($post['available_week']))->set('hourly_rate', trim($post['hourly_rate']))->where('user_id' , $data['user_id'])->update('user');
				}else{
					$this->db->where('user_id' , $data['user_id'])->update('user' , $post);
				}

			}


            $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

            $data['fname']=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);

            $data['lname']=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
			$data['slogan']=$this->auto_model->getFeild('slogan','user','user_id',$user[0]->user_id);

            $data['rate']=$this->auto_model->getFeild('hourly_rate','user','user_id',$user[0]->user_id);

            $data['available_hr']=$this->auto_model->getFeild('available_hr','user','user_id',$user[0]->user_id);

            $data['hourly_rate']=$this->auto_model->getFeild('hourly_rate','user','user_id',$user[0]->user_id);
			
            $data['overview']=$this->auto_model->getFeild('overview','user','user_id',$user[0]->user_id);

            $data['work_experience']=$this->auto_model->getFeild('work_experience','user','user_id',$user[0]->user_id);

            $data['facebook_link']=$this->auto_model->getFeild('facebook_link','user','user_id',$user[0]->user_id);

            $data['twitter_link']=$this->auto_model->getFeild('twitter_link','user','user_id',$user[0]->user_id);

            $data['gplus_link']=$this->auto_model->getFeild('gplus_link','user','user_id',$user[0]->user_id);

            $data['linkedin_link']=$this->auto_model->getFeild('linkedin_link','user','user_id',$user[0]->user_id);



            $data['ldate']=$user[0]->ldate;

            $data['user_skill']=$this->dashboard_model->getUserSkills($user[0]->user_id);

			$data['rating']=$this->dashboard_model->getrating_new($user[0]->user_id);
			

			$data['country']=$data['user_country']= $this->auto_model->getFeild('country','user','user_id',$user[0]->user_id);

			$data['verify']=$this->auto_model->getFeild('verify','user','user_id',$user[0]->user_id);

            $data['city']=$this->auto_model->getFeild('city','user','user_id',$user[0]->user_id);

			$data['education']=$this->auto_model->getFeild('education','user','user_id',$user[0]->user_id);

			$data['certification']=$this->auto_model->getFeild('certification','user','user_id',$user[0]->user_id);

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

            $breadcrumb=array(

                                            array(

                                                    'title'=>'Dashboard','path'=>''

                                            )

                                    );

            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

            ///////////////////////////Leftpanel Section start//////////////////

            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='dashboard';

			$head['ad_page']='professional_profile';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);

            $table='contents';

            $by="cms_unique_title";

            $val='login';

            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

            $this->autoload_model->getsitemetasetting("meta","pagename","Dashboard");

            $lay['client_testimonial']="inc/footerclient_logo";

			$data['user_portfolio']=$this->dashboard_model->getActiveportfolio($user[0]->user_id);

           
            $data['review']=$this->dashboard_model->getmyreview_new($user[0]->user_id);
			
			$data['user_reference']=$this->references_model->allReferences($user[0]->user_id);
			$data['total_row']=$this->references_model->countReference($user[0]->user_id);

			$data['university'] = $this->db->where(array('status' => 'Y'))->get('university')->result_array();

			$data['educations'] = $this->db->where(array('user_id' =>  $data['user_id']))->get('user_education')->result_array();
			$data['experiences'] = $this->db->where(array('user_id' =>  $data['user_id']))->get('user_experience')->result_array();

			$data['certificates'] = $this->db->where(array('user_id' =>  $data['user_id']))->get('user_certificate')->result_array();
			
			
			$data['completed_projects'] = $this->db->where(array('is_completed' => 'Y', 'status' => 'C', 'user_id' => $user[0]->user_id))->limit(3, 0)->order_by('id', 'desc')->get('projects')->result_array();
			
			$data['open_projects'] = $this->db->where(array('status' => 'O', 'user_id' => $user[0]->user_id))->limit(3, 0)->order_by('id', 'desc')->get('projects')->result_array();
			
			
			if($data['account_type'] == 'E'){
				$this->layout->view('myprofile_employer',$lay,$data,'normal');
			}else{
				$this->layout->view('myprofile',$lay,$data,'normal');
			}
            

    }

}



    public function profile_client() {

    if(!$this->session->userdata('user')){
            redirect(VPATH."/login/");
    }
    else{
            $user=$this->session->userdata('user');

            $data['user_id']=$user[0]->user_id;

            $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

            $data['fname']=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);

            $data['lname']=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);

            $data['about']=$this->auto_model->getFeild('asclient_aboutus','user','user_id',$user[0]->user_id);

			$data['country']=$this->auto_model->getFeild('country','user','user_id',$user[0]->user_id);

			$data['verify']=$this->auto_model->getFeild('verify','user','user_id',$user[0]->user_id);

            $data['city']=$this->auto_model->getFeild('city','user','user_id',$user[0]->user_id);

	    	$data['logo']=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

			$data['rating']=$this->dashboard_model->getrating($user[0]->user_id);

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

			$data['review']=$this->dashboard_model->getmyreview($user[0]->user_id);
			
			$data['facebook_link']=$this->auto_model->getFeild('facebook_link','user','user_id',$user[0]->user_id);

            $data['twitter_link']=$this->auto_model->getFeild('twitter_link','user','user_id',$user[0]->user_id);

            $data['gplus_link']=$this->auto_model->getFeild('gplus_link','user','user_id',$user[0]->user_id);

            $data['linkedin_link']=$this->auto_model->getFeild('linkedin_link','user','user_id',$user[0]->user_id);

            $data['ldate']=$user[0]->ldate;

            $breadcrumb=array(
                array(
                    'title'=>'Dashboard','path'=>''
                )
            );

            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

            ///////////////////////////Leftpanel Section start//////////////////

            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='dashboard';

			$head['ad_page']='client_profile';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);

            $table='contents';

            $by="cms_unique_title";

            $val='login';

            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

            $this->autoload_model->getsitemetasetting("meta","pagename","Dashboard");

            $lay['client_testimonial']="inc/footerclient_logo";

            $this->layout->view('clientprofile',$lay,$data,'normal');

    }

}


    public function editprofile_professional() {

    if(!$this->session->userdata('user'))

    {

            redirect(VPATH."/login/");

    }

    else

    {

            $user=$this->session->userdata('user');

            $data['user_id']=$user[0]->user_id;

            $data['username']=$user[0]->username;

            $data['fname']=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);

            $data['lname']=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);

			$data['cname']=$this->auto_model->getFeild('city','user','user_id',$user[0]->user_id);

			$data['country']=$this->auto_model->getFeild('country','user','user_id',$user[0]->user_id);

			$data['logo']=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

			$data['overview']=$this->auto_model->getFeild('overview','user','user_id',$user[0]->user_id);

			$data['work_experience']=$this->auto_model->getFeild('work_experience','user','user_id',$user[0]->user_id);

			$data['qualification']=$this->auto_model->getFeild('qualification','user','user_id',$user[0]->user_id);

			$data['education']=$this->auto_model->getFeild('education','user','user_id',$user[0]->user_id);

			$data['hourly_rate']=$this->auto_model->getFeild('hourly_rate','user','user_id',$user[0]->user_id);

			$data['certification']=$this->auto_model->getFeild('certification','user','user_id',$user[0]->user_id);

			$data['slogan']=$this->auto_model->getFeild('slogan','user','user_id',$user[0]->user_id);

			$data['facebook_link']=$this->auto_model->getFeild('facebook_link','user','user_id',$user[0]->user_id);

			$data['twitter_link']=$this->auto_model->getFeild('twitter_link','user','user_id',$user[0]->user_id);

			$data['gplus_link']=$this->auto_model->getFeild('gplus_link','user','user_id',$user[0]->user_id);

			$data['linkedin_link']=$this->auto_model->getFeild('linkedin_link','user','user_id',$user[0]->user_id);
			$data['company']=$this->auto_model->getFeild('company','user','user_id',$user[0]->user_id);
			$data['phone']=$this->auto_model->getFeild('phone','user','user_id',$user[0]->user_id);

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
			//print_r($data);
			//die();
            $breadcrumb=array(

                                            array(

                                                    'title'=>'Dashboard','path'=>''

                                            )

                                    );

        $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

            ///////////////////////////Leftpanel Section start//////////////////

        $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='editprofile_professional';

			$head['ad_page']='edit_profile';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);

            $table='contents';

            $by="cms_unique_title";

            $val='login';

            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/

	     	$data['country_list']=$this->autoload_model->getCountry();

			$country_code=$data['country'];

            $data['city_list']=$this->autoload_model->getCity($country_code);

            $this->autoload_model->getsitemetasetting("meta","pagename","Edit");

            $lay['client_testimonial']="inc/footerclient_logo";

            $this->layout->view('editprofile',$lay,$data,'normal');
    }

}

    public function editprofile_skill() {

    if(!$this->session->userdata('user'))

    {

            redirect(VPATH."login/");

    }

    else

    {

            $user=$this->session->userdata('user');

            $data['user_id']=$user[0]->user_id;

            $data['total_plan_skill']=  $this->auto_model->getFeild("skills","membership_plan","id",$user[0]->membership_plan);



            $breadcrumb=array(

                array(

                 'title'=>'Dashboard','path'=>''

                )

            );

			$data['parent_skill']=$this->auto_model->getskill("0");

			$data['user_skill']=$this->dashboard_model->getuserskill($user[0]->user_id);




            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

            ///////////////////////////Leftpanel Section start//////////////////

            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='editprofile_skill';

			$head['ad_page']='edit_profile';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);



            /*$this->autoload_model->getsitemetasetting($table,$by,$val);*/


            $this->autoload_model->getsitemetasetting("meta","pagename","Editprofile_skill");

            $lay['client_testimonial']="inc/footerclient_logo";

            $this->layout->view('editskill',$lay,$data,'normal');

    }

}


    public function check() {

    $this->auto_model->checkrequestajax();

     if($this->input->post()){

      $post_data = $this->input->post();

              $insert = $this->dashboard_model->editprofile($post_data);
     }

}

    public function checkportfolio() {

      $this->auto_model->checkrequestajax();

     if($this->input->post()){

      $post_data = $this->input->post();
	

        $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;

      $insert = $this->dashboard_model->addportfolio($post_data,$user_id);

     }
}

public function checkportfolioajax() {

     // $this->auto_model->checkrequestajax();

     if($this->input->post()){

      $post_data = $this->input->post();
	

        $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;

      $insert = $this->dashboard_model->addportfolioajax($post_data,$user_id);

     }
}

    public function checkportfolioedit() {

      $this->auto_model->checkrequestajax();

     if($this->input->post()){

      $post_data = $this->input->post();

        $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;

      $insert = $this->dashboard_model->editportfolio($post_data,$user_id);

     }
}


    public function client_about_check(){



    $user=$this->session->userdata('user');

    $user_id=$user[0]->user_id;

    if($this->input->post('asclient_aboutus')!=""){

        $post_data['asclient_aboutus']=  $this->input->post('asclient_aboutus');

        $update_about=  $this->dashboard_model->add_about($post_data,$user_id);

        if($update_about){

            redirect(VPATH."dashboard/profile_client");

        }

    }

}

    public function fileUpload(){

            $error = "";

            $msg = "";

            $fileElementName = 'fileToUpload';

            if(!empty($_FILES[$fileElementName]['error']))

            {

                    switch($_FILES[$fileElementName]['error'])

                    {



                            case '1':

                                    $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';

                                    break;

                            case '2':

                                    $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';

                                    break;

                            case '3':

                                    $error = 'The uploaded file was only partially uploaded';

                                    break;

                            case '4':

                                    $error = 'No file was uploaded.';

                                    break;



                            case '6':

                                    $error = 'Missing a temporary folder';

                                    break;

                            case '7':

                                    $error = 'Failed to write file to disk';

                                    break;

                            case '8':

                                    $error = 'File upload stopped by extension';

                                    break;

                            case '999':

                            default:

                                    $error = 'No error code avaiable';

                    }

            }elseif(empty($_FILES['fileToUpload']['tmp_name']) )

            {

                    $error = 'No file was uploaded..';

            }else

            {

                            //$loc="".ASSETS."/uploaded/".$_FILES['fileToUpload']['name'];

                            $config['upload_path'] = 'assets/uploaded/';

            $config['allowed_types'] = 'gif|jpg|png|jpeg';



            $this->load->library('upload', $config);

                            $field_name='fileToUpload';

            $uploaded = $this->upload->do_upload($field_name);

                            $upload_data = $this->upload->data();

                            $image = $upload_data['file_name'];

                            $configs['image_library'] = 'gd2';

                            $configs['source_image']	= 'assets/uploaded/'.$image;

                            $configs['create_thumb'] = TRUE;

                            $configs['maintain_ratio'] = TRUE;

                            $configs['width']	 = 252;

                            $configs['height']	= 330;

                            $this->load->library('image_lib', $configs);

                            $rsz=$this->image_lib->resize();

                            if($rsz)

                            {

                                    $image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];

                            }

                            $msg .=$image;

            }



            echo "{";

            echo				"error: '" . $error . "',\n";

            echo				"msg: '" . $msg . "'\n";

            echo "}";

    }

    public function uploadportfolio(){
	$msg = "";
	$fileElementName = 'userfile';

        $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;


        $config['upload_path'] = 'assets/portfolio/';
        $config['allowed_types'] ="*";

	$this->load->library('upload', $config);
        $result=array() ;

        if ($this->upload->do_upload()){

             $upload_data = $this->upload->data();
             $image = $upload_data['file_name'];



            if($upload_data['file_type']=="image/jpeg" || $upload_data['file_type']=="image/jpg" || $upload_data['file_type']=="image/png" || $upload_data['file_type']=="image/gif"){
                $configs['image_library'] = 'gd2';

                 $configs['source_image']	= 'assets/portfolio/'.$image;

                 $configs['create_thumb'] = TRUE;

                 $configs['maintain_ratio'] = TRUE;

                 $configs['width']	 = 663;

                 $configs['height']	= 276;

                 $this->load->library('image_lib', $configs);

                 $rsz=$this->image_lib->resize();

            if($rsz){
               $image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];

               $data=array(
                   "user_id" =>$user_id,
                   "original_img" => $upload_data['file_name'],
                   "thumb_img" =>$image,
                   "add_date" =>date("Y-m-d")
               );

            }

            }
            else{
               $data=array(
                   "user_id" =>$user_id,
                   "original_img" => $upload_data['file_name'],
                   "thumb_img" =>$upload_data['file_name'],
                   "add_date" =>date("Y-m-d")
               );

            }

            $pid="";
            $pid=$this->dashboard_model->insertportfolio($data);
            $msg .=$image;

            $result["msg"]=$image;
            $result["pid"]=$pid;
        }
	echo json_encode($result);
    }

    public function uploadportfolio_edit(){
	$pid=$this->input->post("id");

	$msg = "";
	$fileElementName = 'userfile';

        $user=$this->session->userdata('user');

        $user_id=$user[0]->user_id;


        $config['upload_path'] = 'assets/portfolio/';
        $config['allowed_types'] = '*';

	$this->load->library('upload', $config);
        $result=array() ;

        if ($this->upload->do_upload()){

             $upload_data = $this->upload->data();

            $image = $upload_data['file_name'];

            if($upload_data['file_type']=="image/jpeg" || $upload_data['file_type']=="image/jpg" || $upload_data['file_type']=="image/png" || $upload_data['file_type']=="image/gif"){
           $configs['image_library'] = 'gd2';

            $configs['source_image']	= 'assets/portfolio/'.$image;

            $configs['create_thumb'] = TRUE;

            $configs['maintain_ratio'] = TRUE;

            $configs['width']	 = 663;

            $configs['height']	= 276;

            $this->load->library('image_lib', $configs);

            $rsz=$this->image_lib->resize();

            //$pid="";
            if($rsz){
               $image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];

               $data=array(
                   "original_img" => $upload_data['file_name'],
                   "thumb_img" =>$image
               );

            }
            else{
               $data=array(
                   "original_img" => $upload_data['file_name'],
                   "thumb_img" =>$upload_data['file_name']
               );

            }




               $pid=$this->dashboard_model->updateportfolioimg($data,$pid);


            }
            $msg .=$image;

            $result["msg"]=$image;
            $result["pid"]=$pid;

        }
	echo json_encode($result);

    }



    public function updateportfolio($limit_from=''){

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);



		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='editportfolio';

		$head['ad_page']='add_portfolio';

		$load_extra=array();


                $this->load->library('pagination');

                $config['base_url'] = VPATH.'dashboard/editportfolio';
                $config['total_rows'] = $this->dashboard_model->count_portfolio($user[0]->user_id);
                $config['per_page'] = 5;
                $config["uri_segment"] = 3;
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
                 $data['page'] = $config['per_page'];
                 $data["links"] = $this->pagination->create_links();

                $data['total_row'] =$config['total_rows'];
                $data['user_portfolio']=$this->dashboard_model->getportfolio($user[0]->user_id,$config['per_page'], $start);

                $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Editportfolio");

		$lay['client_testimonial']="inc/footerclient_logo";



       if($this->input->post()){
            $this->form_validation->set_rules('pid', 'Select File', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');

            if ($this->form_validation->run() == FALSE) {
      		$this->layout->view('edit_portfolio.php',$lay,$data,'normal');
            } else {
                //$post_data = $this->input->post();

                $post_data['title'] = $this->input->post('title');
                $post_data['description'] = $this->input->post('description');

                $this->dashboard_model->updateportfolio($post_data,$this->input->post("pid"));
                redirect(VPATH."dashboard/editportfolio");
            }



       }

   }


    public function updateskill(){
        $user=$this->session->userdata('user');
        $user_id=$user[0]->user_id;


         $total_plan_skill=  $this->auto_model->getFeild("skills","membership_plan","id",$user[0]->membership_plan);

         if($total_plan_skill>=count($this->input->post("user_skill"))){
          		$this->dashboard_model->deleteskill($user_id);
                    foreach($this->input->post("user_skill") as $key => $val){
						 $curr_skill = explode('|' , $val);
						 $data = array(
							'user_id' => $user_id,
							'skill_id' => $curr_skill[0],
							'sub_skill_id' =>  $curr_skill[1],
							'added_date' => date('Y-m-d')
						 );
						 $this->db->insert('new_user_skill' , $data);
                   }
					$this->session->set_flashdata('skill_succ',"Your skilll has been updated successfully.");

                   redirect(VPATH."dashboard/editprofile_skill");
         }
         else{

			 $this->session->set_flashdata('skill_error',"Updation Faild. No of skill can't be grater than ".$total_plan_skill);
             redirect(VPATH."dashboard/editprofile_skill");
         }
    }
	
	 public function updateskillajax(){
        $user=$this->session->userdata('user');
        $user_id=$user[0]->user_id;

		$data = $this->input->post("user_skill");
		
				
         $total_plan_skill=  $this->auto_model->getFeild("skills","membership_plan","id",$user[0]->membership_plan);

         if($total_plan_skill>=count($data)){
          		$this->dashboard_model->deleteskill($user_id);
                    foreach($data as $key => $val){
						 $curr_skill = explode('|' , $val['value']);
						 $data = array(
							'user_id' => $user_id,
							'skill_id' => $curr_skill[0],
							'sub_skill_id' =>  $curr_skill[1],
							'added_date' => date('Y-m-d')
						 );
						$upd = $this->db->insert('new_user_skill' , $data);
                   }
					//$this->session->set_flashdata('skill_succ',"Your skilll has been updated successfully.");
					if($upd){
						$res['status'] = 1;
					}else{
						$res['status'] = 0;
					}

                 
         }
         echo json_encode($res);
    }

	public function update_skill_ajax_new(){
        $user=$this->session->userdata('user');
        $user_id=$user[0]->user_id;

		$data = $this->input->post("user_skills");
		
				
         $total_plan_skill=  $this->auto_model->getFeild("skills","membership_plan","id",$user[0]->membership_plan);

         if($total_plan_skill>=count($data)){
			
          		$this->dashboard_model->deleteskill($user_id);
                    foreach($data as $key => $val){
						/*  $curr_skill = explode('|' , $val['value']); */
						 $insert = array(
							'user_id' => $user_id,
							'skill_id' => 0,
							'sub_skill_id' =>  $val,
							'added_date' => date('Y-m-d')
						 );
						$upd = $this->db->insert('new_user_skill' , $insert);
                   }
				  
					//$this->session->set_flashdata('skill_succ',"Your skilll has been updated successfully.");
					if($upd){
						$res['status'] = 1;
						$res['selected_skill'] = $this->db->where_in('id', $data)->get('skills')->result_array();
					}else{
						$res['status'] = 0;
					}

                 
         }
         echo json_encode($res);
    }
	
   public function editportfolio($limit_from=''){

	if(!$this->session->userdata('user')){
		redirect(VPATH."/login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;



                 $data['logeduser_portfolio']=  $this->dashboard_model->getPostPortfolioCount($user[0]->user_id);
                 $data['total_plan_portfolio']=  $this->auto_model->getFeild("portfolio","membership_plan","id",$user[0]->membership_plan);



		$breadcrumb=array(
                    array(
                            'title'=>'Dashboard','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='editportfolio';

		$head['ad_page']='add_portfolio';

		$load_extra=array();


                $this->load->library('pagination');
                $config['base_url'] = VPATH.'dashboard/editportfolio';
                $config['total_rows'] = $this->dashboard_model->count_portfolio($user[0]->user_id);
                $config['per_page'] = 8;
                $config["uri_segment"] = 3;
                $config['use_page_numbers'] = TRUE;
					$config['full_tag_open'] = "<ul class='pagination'>";
					$config['full_tag_close'] = '</ul>';
					$config['first_link'] = 'First';
					$config['first_tag_open'] = '<li>';
					$config['first_tag_close'] = '</li>';
					$config['num_tag_open'] = '<li>';
					$config['num_tag_close'] = '</li>';
					$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
					$config['cur_tag_close'] = '</a></li>';
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
                 $data['page'] = $config['per_page'];
                 $data["links"] = $this->pagination->create_links();

                $data['total_row'] =$config['total_rows'];
                $data['user_portfolio']=$this->dashboard_model->getportfolio($user[0]->user_id,$config['per_page'], $start);

                $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);



		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Editportfolio");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('edit_portfolio',$lay,$data,'normal');


	}

   }

   public function myproject_client(){
   	if(!$this->session->userdata('user')){
		redirect(VPATH."/login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$id=$user[0]->user_id;


		$breadcrumb=array(
                    array(
                        'title'=>'Dashboard','path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('my_project','My Project'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='client_project';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");
		$status='O';
		$data['projects']=$this->dashboard_model->getProject($status,$id, 0, 10);
		
		$this->load->library('pagination');
		/*Completed Pagination Start*/
			$config['base_url'] = base_url('dashboard/project_ajax?type='.$status);
			
			$config['total_rows'] =$this->dashboard_model->getProject($status,$id, '', '', FALSE);
			
			$config['per_page'] = 10;
			$config['page_query_string'] = TRUE;
			$config['reuse_query_string'] = TRUE;
			$config['query_string_segment'] = 'limit';
			
			$config['full_tag_open'] = "<ul class='pull-right pagination ajax_pagination' data-target='#open_project_wrapper'>";
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = __('pagination_first','First');
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
			$config['cur_tag_close'] = '</a></li>';
			$config['last_link'] = __('pagination_last','Last');;
			$config['last_tag_open'] = "<li class='last'>";
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
			$config['next_tag_open'] = "<li>";
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>'; 
			
			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			/*Pagination End*/
			

		$lay['client_testimonial']="inc/footerclient_logo";
		//print_r($data);
		//die();
		$this->layout->view('project_client',$lay,$data,'normal');
		}
   }
   
   public function project_ajax(){
	   $user=$this->session->userdata('user');

		$data['user_id']=$id=$user[0]->user_id;
		
	   $type = get('type');
	   $limit = get('limit');
	   if(!$limit){
		   $limit = 0;
	   }
	   $offset = 10;
	   $status=$type;
	   $data['projects']=$this->dashboard_model->getProject($status,$id,  $limit, $offset);
	   
	   $this->load->library('pagination');
		/*Completed Pagination Start*/
		$config['base_url'] = base_url('dashboard/project_ajax?type='.$status);
		
		$config['total_rows'] =$this->dashboard_model->getProject($status,$id, '', '', FALSE);
		
		$config['per_page'] = $offset ;
		$config['page_query_string'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['query_string_segment'] = 'limit';
		
		$config['full_tag_open'] = "<ul class='pull-right pagination ajax_pagination' data-target='#open_project_wrapper'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		$this->load->view('project_ajax', $data);
   }

	public function project_frozen(){
	    $user=$this->session->userdata('user');
	    $user_id=  $this->uri->segment(3);
   		$data['user_id']=$id=$user[0]->user_id;
		$data['status'] = $status=$this->input->post('status');
		$data['projects'] = $projects=$this->dashboard_model->getProject($status,$id);

		$extratext=array();
		$this->load->view('project_frozen', $data);
	}

   /* public function project_frozen(){
	    $user=$this->session->userdata('user');
	    $user_id=  $this->uri->segment(3);
   		$data['user_id']=$id=$user[0]->user_id;
		$data['status'] = $status=$this->input->post('status');
		$data['projects'] = $projects=$this->dashboard_model->getProject($status,$id);

     $extratext=array();
?>
<script type="text/javascript">

				$('[data-toggle="tooltip"]').tooltip();
				function onchangeOption(v,i){
				// alert(v);alert(i);

				if(v=="VF"){
                window.location.href=$("#vf_"+i).attr('href');
                    }

				else if(v=="WR"){
			   window.location.href=$("#wr_"+i).attr('href');

				}
				else if(v=="PC"){

				window.location.href=$("#pc_"+i).attr('href');

				}
				else if(v=='M'){

				window.location.href=$("#m_"+i).attr('href');

				}
				else if(v=='GB'){

				window.location.href=$("#gb_"+i).attr('href');

				}
				else if(v=='EC'){

				window.location.href=$("#ec_"+i).attr('href');

				}
					else if(v=='VP'){

				window.location.href=$("#vp_"+i).attr('href');

				}
		}
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
				</script>
				<style>
				.extratext{
				width:100%;
				float:left;
				}
				</style>
<?

				echo "
		<div class='clearfix'></div> ";

		echo '<table id="exampleTabs" class="table table-dashboard">
<thead><tr><th colspan="2" style="width:30%">Project Name</th><th class="text-center">Project Type</th><th>Bids</th><th>Action</th><th>Posted date</th></tr>
</thead>
<tbody>	';

		/*echo "
		<div class='notiftext1'><h4>Project Name</h4><h4>Project Type</h4><h4>Bids</h4><h4>Action</h4><h4>Posted date</h4></div>";

		if(count($projects)>0){
			//print_r($projects);
		   //die();
		//echo '<pre>'; print_r($projects); die();
			foreach($projects as $key=>$val){
				$extratext = array();
				if($val['multi_freelancer']=='Y' && $val['project_type']=='H'){

					$allbidder=explode(",",$val['bidder_id']);
					$allchosen=explode(",",$val['chosen_id']);
					$chosen_id= explode(',',$val['bidder_id']);
					$name="";
					$b=0;$count_review=array();
					foreach($allbidder as $bidder){
						$b++;
						$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
						$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
						$country=$this->auto_model->getFeild('country','user','user_id',$bidder);
						$name=$fname." ".$lname;
						$count_review=$this->dashboard_model->countReview($val['project_id'],$data['user_id'],$bidder);
						$logo=$this->auto_model->getFeild('logo','user','user_id',$bidder);



						$project_type="";
						$project_type='<i class="zmdi zmdi-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hourly"></i>';


						echo "<tr>";

					?>
						<td class="tab_cls">
						<a href="<?php echo VPATH."jobdetails/details/".$val['project_id'];?>">
							<?php
							if($logo!=''){ ?>

							<img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>" width="50" height="50">

							<?php
							}else{ ?>


							<img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif" width="50" height="50">
							<?php

							}

							?>

							</a>
						</td>
							<td class="r_div">
								<a href="<?php echo VPATH."jobdetails/details/".$val['project_id'];?>"><?php echo $val['title'];?></a>
								<h5><?php echo $name;?></h5>
								<h6><?php echo $country;?></h6>

							</td>
					<?php
					echo "<td align='center'>".$project_type."</td>";
					echo "<td>".$val['bidder_details']."</td>";


					if($status=='F'){ ?>


						<?php
						echo "<td><div class='icon-set'>

							 <a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class='fa fa-home'></i></a>
							 </div>
									</td>";


					}elseif($status=='P'){ ?>
					<?php

						echo "<td>

								<div class='icon-set'>
				<a href='".VPATH."projecthourly/employer/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
				<a href='".VPATH."dashboard/selectprovider/".$val['project_id']."' data-toggle='tooltip' title='View Freelancer'><i class='fa fa-dashboard'></i></a>
				 <!--<a href='".VPATH."dashboard/selectprovider/".$val['project_id']."' data-toggle='tooltip' title='Pause Contract'><i class='fa fa-pause'></i></a>-->
				 <a href='".VPATH."message/browse/".$val['project_id']."/".$bidder."' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>
				  <!--<a href='".VPATH."projectcontractor/index/".$val['project_id']."' data-toggle='tooltip' title='End Contractor'><i class=' fa fa-user'></i></a>-->
				 <a href='javascript:void(0)' onclick=\"actionPerform('GB','".$bidder."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

				 </div>

						</td>";

				}elseif($status=='PS'){
					echo "<td><div class='icon-set'>

				 <a href='".VPATH."projecthourly/employer/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
				 <a href='".VPATH."message/' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>
				 <a href='".VPATH."clientdetails/showdetails/".$chosen_id[0]."' data-toggle='tooltip' title='View Freelancer'><i class='fa fa-dashboard'></i></a>
				 <a href='javascript:void(0)' onclick=\"actionPerform('GB','".$bidder."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

				 </div></td>";

				}elseif($status=='C'){
					echo "<td>";
						echo "<div class='icon-set'>

					 <a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
					 <a href='".VPATH."message/' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>";
					$bidert=array();
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
								$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
								$nname=$fname." ".$lname;
						$count_review=$this->dashboard_model->countReview($val['project_id'],$data['user_id'],$bidder);
						if($count_review>0)
						{
							echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$bidder."/".$val['title']."'  data-toggle='tooltip' title='(".$nname.") View Feedback.'><i class='fa fa-comments-o'></i></a> ";
						}
						else
						{
							echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$bidder."/".$val['title']."' data-toggle='tooltip' title='(".$nname.") Give Feedback.'><i class='fa fa-comments-o'></i></a>";
						}


					echo "
					<a href='javascript:void(0)' onclick=\"actionPerform('GB','".$bidder."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

					</div></td>";
				}else{
					if($status == 'E') {
						echo '<td><input class="btn btn-sm btn-site" type="button" id="repost_job" onclick="repost_job('.$val['id'].')" value="Repost Job" /></td>';
					} else {
						echo "<td>----</td>";
					}
				}
				echo "<td>".date('d M,Y',strtotime($val['posted_date']))."</td>";
				echo "</tr>";

					}
			}else{

			$username=$this->auto_model->getFeild('username','user','user_id',$val['chosen_id']);
			$biddername=$this->auto_model->getFeild('username','user','user_id',$val['bidder_id']);
			if(!empty($val['bidder_id'])){
			$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
			}else{
				$fname=$this->auto_model->getFeild('fname','user','user_id',$val['chosen_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$val['chosen_id']);
			}
			$country=$this->auto_model->getFeild('country','user','user_id',$val['bidder_id']);
			$name=$fname." ".$lname;

			$count_review=$this->dashboard_model->countReview($val['project_id'],$data['user_id'],$val['bidder_id']);
			$logo=$this->auto_model->getFeild('logo','user','user_id',$val['bidder_id']);
			// Select for both
			$new_chosen_id= explode(',',$val['bidder_id']);
			$chosen_id=explode(',',$val['chosen_id']);


			///////////////////////////Check Milestone Status/////////////////////////////
			$count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$val['project_id']);
			if($count_milestone>0)
			{
				$client_approval_Y=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'Y'));
				$client_approval_N=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'N'));
				$client_approval_D=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'D'));
				$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$val['project_id']);
			}
			//////////////////////////End Checkinh Milestone////////////////////////////////
		$project_type="";
		if($val['project_type']=="F")
		{
			$project_type='<i class="zmdi zmdi-lock" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fixed"></i>';
		}
		else
		{
			$project_type='<i class="zmdi zmdi-time" data-toggle="tooltip" data-placement="top" title="" data-original-title="Hourly"></i>';
		}

		echo "<tr>";
		?>

		<td class="tab_cls">
		<a href="<?php echo VPATH."jobdetails/details/".$val['project_id'];?>">
			<?php
			if($logo!=''){ ?>

			<img alt="" src="<?php echo VPATH;?>assets/uploaded/<?php echo $logo;?>">

            <?php
			}else{ ?>


			<img alt="" src="<?php echo VPATH;?>assets/images/face_icon.gif">
			<?php

			}

			?>

			</a>
		</td>
		<td class="r_div">
			<a href="<?php echo VPATH."jobdetails/details/".$val['project_id'];?>"><?php echo $val['title'];?></a>
			<h1><?php echo $name;?></h1>
			<h2><?php echo $country;?></h2>

		</td>



		<?php

		echo "<td align='center'>".$project_type."</td>";
		echo "<td>".$val['bidder_details']."</td>";
		if($status=='F'){ ?>



				<?php
				echo "<td><div class='icon-set'>
				<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
				<a href='".VPATH."message/"."' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>
			 	<a href='".VPATH."dashboard/selectprovider/".$val['project_id']."' data-toggle='tooltip' title='View Freelancer'><i class='fa fa-dashboard'></i></a>
				</div>
		 <div class='extratext'>";
		 $extratext[]="Waiting for approval";
		echo implode("|",$extratext);
		echo "</div></td>";

		}elseif($status=='P'){

		echo "<td>
		<div class='icon-set'>
		 ";

		if($val['project_type']=='F'){
		if($count_milestone==0){

			echo "<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a><a href='".VPATH."dashboard/setMilestone/".$val['project_id']."' data-toggle='tooltip' title='Set Milestone'><i class='fa fa-cog'></i></a> ";
		}
		else
		{

			if($request_by=='F')
			{
				if($client_approval_Y >0)
				{
					$extratext[]= "Milestone Approved. ";
				}
				elseif($client_approval_N >0)
				{
					$extratext[]=  " New Milestone Requested. ";
				}

				echo "<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a><a href='".VPATH."myfinance/milestone/".$val['project_id']."' data-toggle='tooltip' title='Click here to see Milestone'><i class='fa fa-tasks'></i></a> ";
			}
			else
			{
				if($client_approval_Y >0)
				{

					echo "<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a><a href='".VPATH."myfinance/milestone/".$val['project_id']."' data-toggle='tooltip' title='Click here to see Milestone'><i class='fa fa-tasks'></i></a> ";
				}
				elseif($client_approval_N >0)
				{

					$extratext[]= "Mileston is Waiting for Freelancee Approval";
					echo "<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a> <a href='".VPATH."dashboard/MilestoneChart/".$val['project_id']."' data-toggle='tooltip' title='View Milestone'><i class='fa fa-tasks'></i></a> ";
				}
				elseif($client_approval_D>0)
				{

				 $extratext[]="Milestone Declined by Client";
				 echo "  <a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a><a href='".VPATH."dashboard/MilestoneEdit/". $val['project_id']."'  data-toggle='tooltip' title='Edit Milestone'><i class=' fa fa-eraser'></i></a>  <a href='".VPATH."dashboard/setMilestone/".$val['project_id']."'  data-toggle='tooltip' title='Create New Milestone'><i class=' fa fa-cog'></i></a> ";
				}
			}
		}
		}
		else
		{

			echo "
		<a href='".VPATH."projecthourly/employer/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a><a href='".VPATH."projectcontractor/index/".$val['project_id']."' data-toggle='tooltip' title='End Contractor'><i class=' fa fa-user'></i></a>
		";
		}
		echo "<a href='".VPATH."message/browse/".$val['project_id']."/".$val['bidder_id']."' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>
		 <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."' data-toggle='tooltip' title='View Profile of ".$name."'><i class='fa fa-dashboard'></i></a>
		 <a href='javascript:void(0)' onclick=\"actionPerform('GB','".$val['bidder_id']."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

		 </div>
		 <div class='extratext'>";
		//echo implode("|",$extratext);
		echo "</div></td>";
		}
		elseif($status=='PS')
		{

			echo "<td>
			<div class='icon-set'>
				<a href='".VPATH."projecthourly/employer/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
				<a href='".VPATH."message/"."' data-toggle='tooltip' title='Message'><i class='fa fa-envelope'></i></a>
			 	<a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."' data-toggle='tooltip' title='View Profile of ".$name."'><i class='fa fa-dashboard'></i></a>
				<a href='javascript:void(0)' onclick=\"actionPerform('GB','".$val['bidder_id']."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

				</div>
			</td>";
		}
		elseif($status=='C')
		{

			echo "<td><div class='icon-set'>
				<a href='".VPATH."projectdashboard/index/".$val['project_id']."' data-toggle='tooltip' title='Work Room'><i class=' fa fa-home'></i></a>
				<a href='".VPATH."message/"."' data-toggle='tooltip' title='Message'><i class='fa fa-envelope-alt'></i></a>
			 	<a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."' data-toggle='tooltip' title='View Profile of ".$biddername."'><i class='fa fa-dashboard'></i></a>
				";
		if($count_review>0){
			echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$val['bidder_id']."/".$val['title']."' data-toggle='tooltip' title='View Feedback'><i class='  fa fa-comments-o'></i></a>";
		}else{
			echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$val['bidder_id']."/".$val['title']."' data-toggle='tooltip' title='Give Feedback'><i class='  fa fa-comment-o'></i></a>";
		}
		echo "
		<a href='javascript:void(0)' onclick=\"actionPerform('GB','".$bidder."')\" data-toggle='tooltip' title='Give Bonus'><i class='fa fa-money'></i></a>

		</div>
		</td>";
		}else{

		echo "<td>----</td>";
		}

		echo "<td>".date('d M,Y',strtotime($val['posted_date']))."</td>";
		echo "</tr>";

		}
			}
		}
		else{


		}

		echo "</table>";


   }*/

   public function myproject_professional(){

        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'My Bid','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

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
		$data['proposals']=$this->dashboard_model->getProposals($user_id);

		$lay['client_testimonial']="inc/footerclient_logo";

		$data['invitation'] = get_results(array('select' => 'i.*,p.title,p.project_type', 'from' => 'new_inviteproject i', 'join' => array(array('projects p', 'p.project_id=i.project_id', 'left')), 'where' => array('freelancer_id' => $data['user_id']), 'order_by' => array('i.id', 'DESC')));


		$this->layout->view('project_professional',$lay,$data,'normal');
		}
   }

   public function myproject_working(){

        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Active Projects','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{
			
		if(file_exists('assets/uploaded/cropped_'.$logo)){
			$logo="uploaded/cropped_".$logo;
		}else{
			$logo="uploaded/".$logo;
		}
			

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

		$data['working_projects']=$this->dashboard_model->getMyprojects($user_id,'P');
		
		$lay['client_testimonial']="inc/footerclient_logo";
		
		if($this->input->is_ajax_request()){
			$this->load->view('project_working_ajax', $data);
		}else{
			$this->layout->view('project_working',$lay,$data,'normal');
		}
		
		
		}
   }
   
   public function myproject_cancelled(){

        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Cancelled Projects','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{
			
		if(file_exists('assets/uploaded/cropped_'.$logo)){
			$logo="uploaded/cropped_".$logo;
		}else{
			$logo="uploaded/".$logo;
		}
			

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

		$data['projects']=$this->dashboard_model->getMyprojects($user_id,'CNL');
		
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$this->layout->view('project_cancelled',$lay,$data,'normal');
		
		
		}
   }

   public function myproject_completed(){

        if(!$this->session->userdata('user')){
          redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Completed projects','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Project');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			

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
		$data['working_projects']=$this->dashboard_model->getMyprojects($user_id,'C');
		
		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('project_completed',$lay,$data,'normal');
		}
   }

   public function setting($code=''){
	if(!$this->session->userdata('user')){
		redirect(VPATH."/login/");
	}
	else{
		$user=$this->session->userdata('user');

        $data['question'] = $this->dashboard_model->getUpdatedAnswer();

		$data['user_id']=$user[0]->user_id;
		$data['user_mail']=$user[0]->email;
		if(!empty($code)){
		$get_code =getField('reset_code','answers','user_id',$data['user_id']);

		if($get_code == $code){
			$data['reset_code'] = $code;
		}else{
			redirect(base_url('dashboard/setting'));
		}

		}
		$breadcrumb=array(
                    array(
                            'title'=>'Setting','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Settings');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='settings';

		$head['ad_page']='setting';

		$load_extra=array();
         $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Settings");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('settings',$lay,$data,'normal');
        }

  }

  public function projectclose(){
      $id=$this->uri->segment(3);
      if($id!=""){
		  $project_id=  $this->auto_model->getFeild("project_id","projects","id",$id);
		  $project_title=  $this->auto_model->getFeild("title","projects","id",$id);

			$all_bidder=$this->postjob_model->getBidder($project_id);
			$from=ADMIN_EMAIL;
			foreach($all_bidder as $key=>$val)
			{
				$to=$this->auto_model->getFeild('email','user','user_id',$val['bidder_id']);
				$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
				$template='close_job_notification';
				$data_parse=array('name'=>$fname." ".$lname,
									'title'=>$project_title
									);
				$this->auto_model->send_email($from,$to,$template,$data_parse);
			}
          $this->db->delete('projects', array('id' => $id));
		  $this->session->set_flashdata('succ_job',"Your requested job has been closed successfuly.");
          redirect(VPATH."dashboard/myproject_client");
      }

  }

  public function projectedit(){
      $id=$this->uri->segment(3);
      if($id!=""){
        //  $this->db->delete('projects', array('id' => $id));
          redirect(VPATH."dashboard/myproject_client");
      }

  }

  public function projectextend(){
      $user=$this->session->userdata('user');

      $user_id=$user[0]->user_id;


      $id=$this->uri->segment(3);
      $extendday=$this->uri->segment(4);
      if($id!=""){
          $expiry_date=$this->auto_model->getFeild("expiry_date","projects","id",$id);

          $newdate=date('Y-m-d', strtotime("+".$extendday." day", strtotime($expiry_date)));

          $data=array(
              "expiry_date" =>$newdate,
              "expiry_date_extend" => "Y"
          );

         $this->dashboard_model->update_extendday($data,$id);

		$project_id=  $this->auto_model->getFeild("project_id","projects","id",$id);
		$project_title=  $this->auto_model->getFeild("title","projects","id",$id);
		$link=VPATH."/jobdetails/details/".$project_id;
		$all_bidder=$this->postjob_model->getBidder($project_id);
		$from=ADMIN_EMAIL;
		foreach($all_bidder as $key=>$val)
		{
			$to=$this->auto_model->getFeild('email','user','user_id',$val['bidder_id']);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
			$template='extend_job_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$project_title,
								'copy_url'=>$link,
								'url_link'=>$link
								);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
		}

        /* $data=array(
           "from_id" =>$user_id,
           "to_id" =>$user_id,
           "notification" =>"Your Project, <a href='".VPATH."dashboard/myproject_client'>".$project_title."</a> has  successfully been extended",
           "add_date"  => date("Y-m-d")
         );

         $this->dashboard_model->insert_notification($data); */

		 $notification = "Your Project, ".$project_title."  has  successfully been extended";
		 $link = 'dashboard/myproject_client';
		 $this->notification_model->log($user_id, $project_id, $notification, $link);

         $this->session->set_flashdata('succ_job',"Your project has successfully been extended");
         redirect(VPATH."dashboard/myproject_client");
      }

  }


  public function changepass(){
        $this->auto_model->checkrequestajax();
         if($this->input->post()){
          $post_data = $this->input->post();
          $insert = $this->dashboard_model->updatepass($post_data);
         }
  }
  // Create Security Question
    public function createquestion(){
    $user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;
	$this->auto_model->checkrequestajax();

	if($this->input->post()){
    //Setting values for Table columns
	$data= array(
	'user_id' => $user_id,
	'answers' => $this->input->post('answer'),
	'question_id' => $this->input->post('answerVal')
	);

	// $question_data= array(
	// 'questions' => $this->input->post('question')
	// );
//print_r($data);
	//Transfer  data to Model
	$this->dashboard_model->insertQuestionAnswer($data);

 }
}

public function resetanswer(){
    $user=$this->session->userdata('user');
	$user_id=$user[0]->user_id;
	$this->auto_model->checkrequestajax();
	$code = time();
	$this->dashboard_model->insertreset_code($user_id,$code);

 }








  public function deleteportfolio(){
      $id=$this->uri->segment(3);
      $this->dashboard_model->deleteportfolio($id);
      redirect(VPATH."dashboard/editportfolio");
  }

  public function addportfolio(){
    if(!$this->session->userdata('user'))

    {

            redirect(VPATH."/login/");

    }

    else

    {

            $user=$this->session->userdata('user');

            $data['user_id']=$user[0]->user_id;

            $data['username']=$user[0]->username;

           if($this->uri->segment(3)){
                  $epid=$this->uri->segment(3);
				  $portfolio_user=$this->auto_model->getFeild('user_id','user_portfolio','id',$epid);
				  if($portfolio_user != $data['user_id']){
					  show_404(); 
				  }
                  $data['title']=$this->auto_model->getFeild('title','user_portfolio','id',$epid);
                  $data['description']=$this->auto_model->getFeild('description','user_portfolio','id',$epid);
                  $data['tags']=$this->auto_model->getFeild('tags','user_portfolio','id',$epid);
                  $data['url']=$this->auto_model->getFeild('url','user_portfolio','id',$epid);
                  $data['thumb_img']=$this->auto_model->getFeild('thumb_img','user_portfolio','id',$epid);
                  $data['original_img']=$this->auto_model->getFeild('original_img','user_portfolio','id',$epid);
            }



            $breadcrumb=array(

                array(
                      'title'=>'Dashboard','path'=>''
                )

            );

            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');

            ///////////////////////////Leftpanel Section start//////////////////

            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

            ///////////////////////////Leftpanel Section end//////////////////

            $head['current_page']='addportfolio';

			$head['ad_page']='add_portfolio';

            $load_extra=array();

            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

            $this->layout->set_assest($head);

            $table='contents';

            $by="cms_unique_title";

            $val='login';


            $this->autoload_model->getsitemetasetting("meta","pagename","Addportfolio");

            $lay['client_testimonial']="inc/footerclient_logo";

            $this->layout->view('addportfolio',$lay,$data,'normal');

    }

  }

  public function activeportfolio(){
      $id=  $this->uri->segment(3);
      $type=$this->uri->segment(4);
      $status="";
      if($type=="A"){
          $status="Y";
      }
      else if($type=="D"){
          $status="N";
      }

      $data=array(
          "status"=> $status
      );
      $this->dashboard_model->activeportfolio($data,$id);
      redirect(VPATH."dashboard/editportfolio");

  }

  public function selectprovider()
  {

   	if(!$this->session->userdata('user')){
		redirect(VPATH."/login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$id=$user[0]->user_id;
		$data['project_id']=$project_id=$this->uri->segment(3);

		$breadcrumb=array(
                    array(
                        'title'=>'Dashboard','path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Select Freelancer');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='client_project';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		$data['bidder']=$this->dashboard_model->getAllBidder($project_id);

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('select_provider.php',$lay,$data,'normal');
		}

   }
   
   
   public function getProvider() {
	  
	   $res = array();
	   $res['status'] = 0;
		$user=$this->session->userdata('user');
		$user_wallet_id = get_user_wallet($user[0]->user_id);
		$acc_balance  = $user[0]->acc_balance;
		$acc_balance  = get_wallet_balance($user_wallet_id);

   		$alluser=$this->input->post('userid'); // selected user
   		$allarrayuser=explode(",",$alluser); // selected user in array
   		$project_id=$this->input->post('projectid');
   		$all_chosen=array();
		//$all_chosen=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id)); // choosen user by employer
		$all_chosen=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id)); // choosen user by employer

		$bidder_amt = $this->db->select('bidder_amt,admin_fee,tax_amount,total_amt,bidder_id')->where(array('project_id' => $project_id, 'bidder_id' => $alluser))->get('bids')->row_array();
		
		$project_type=$this->auto_model->getFeild('project_type','projects','project_id',$project_id);
		
		if((empty($bidder_amt) || $bidder_amt['total_amt'] >  $acc_balance) && $project_type == 'F'){
			$fund = '<b>'.CURRENCY.$bidder_amt['total_amt'].'</b>';
			$remaining_bal = number_format(($bidder_amt['total_amt'] - $acc_balance), 2);
			$add_fund_url = base_url('myfinance?amt_to_add='.$remaining_bal);
			$res['msg'] =  "<div class='success alert-danger alert'>You don't have sufficient balance in your wallet <a href='".$add_fund_url."' target='_blank'>click here </a>to add fund  . Minimum $fund required . </div>";

		}else{
			//$get_key_chosen=array_search($user_id,$all_chosen);

			//$user_id=$this->input->post('userid');

			
			$multifree=$this->auto_model->getFeild('multi_freelancer','projects','project_id',$project_id);

			if($this->input->post('hire')){



				$get_key_chosen=array_search($this->input->post('userid'),$all_chosen);
				$exi=trim(implode(",",$all_chosen));
				if($exi!='' && !$get_key_chosen && $project_type=='H' && $multifree=='Y'){
					$alluser=trim(implode(",",$all_chosen)).",".$this->input->post('userid');
				}else{
					$alluser=$this->input->post('userid');
				}
			}


			//$new_data['chosen_id']= $alluser;
			$new_data['bidder_id']= $alluser;
			$new_data['status']= 'P';
			$new_data['hire_date']= date('Y-m-d');
			$upd=$this->dashboard_model->updateProject($new_data,$project_id);

			if($project_type == 'F'){
				$bid_r = $this->db->where(array('project_id' => $project_id, 'bidder_id' => $alluser))->get('bids')->row_array();
				if($bid_r){
					
					//$this->db->where(array('project_id' => $project_id))->update('project_milestone', array('status' => 'P', 'client_approval' => 'N'));

					$bid_id = $bid_r['id'];
					$this->db->where(array('bid_id' => $bid_id))->update('project_milestone', array('status' => 'A', 'client_approval' => 'Y'));
					
					$prev_escrow_count = $this->db->where('project_id', $project_id)->count_all_results('escrow_new');
					
					if(($bid_r['enable_escrow'] == 1) && ($prev_escrow_count == 0)){
						
						$user_id = $user[0]->user_id; 
						
						$this->load->model('myfinance/transaction_model');
						$this->load->helper('invoice');
						
						$ref =  json_encode(array('project_id' => $project_id, 'project_type' => 'F'));
						
						/* $bid_amount = ($bidder_amt['bidder_amt'] + $bidder_amt['admin_fee'] + $bidder_amt['bidder_amt']); */
						$bid_amount_before_tax = ($bidder_amt['bidder_amt'] + $bidder_amt['admin_fee']);
						$bid_amount = $bidder_amt['total_amt'];
						
						/* create tax invoice here */
						$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $user[0]->user_id)));
						
						$sender_info = array(

							'name' => SITE_TITLE,

							'address' => ADMIN_ADDRESS,

						);

						$receiver_info = array(

							'name' => $user_info['fname'].' '.$user_info['lname'],

							'address' => getUserAddress($user_info['user_id']),

						);

						$invoice_data = array(

							'sender_id' => 0,
							'receiver_id' => $user[0]->user_id,
							'invoice_type' => 1,
							'sender_information' => json_encode($sender_info),
							'receiver_information' => json_encode($receiver_info),
							'receiver_email' => $user_info['email'],
							'hst_rate' => HST_RATE,
						);

						$inv_id = create_invoice($invoice_data); 
						
						/* $invoice_row_data = array(
							'invoice_id' => $inv_id,
							'description' => 'HST (' . HST_RATE . '%) for bid amount '.CURRENCY.$bid_amount,
							'per_amount' => $bidder_amt['tax_amount'],
							'unit' => '-',
							'quantity' => 1,

						); */
						
						$invoice_row_data = array(
							'invoice_id' => $inv_id,
							'description' => 'Bidder Amount ',
							'per_amount' => $bid_amount_before_tax,
							'unit' => '-',
							'quantity' => 1,

						);
						
						
						add_invoice_row($invoice_row_data);
						
						/* transaction insert */
						$new_txn_id = $this->transaction_model->add_transaction(PROJECT_PAYMENT_ESCROW,  $user_id,  'Y', $inv_id);
		   
						/* deduct project amount from employer wallet  */
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $bid_amount, 'ref' => $ref , 'info' => 'Project payment added to <b>On Hold Payment</b>'));
						
						/* transfer project amount to excrow wallet ESCROW_WALLET */
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'credit' => $bid_amount, 'ref' => $ref , 'info' => 'Project payment #'.$project_id));
						
						
						
				
						/* $new_txn_id_2 = $this->transaction_model->add_transaction(TAX_PAYMENT,  $user_id, 'Y', $inv_id); */
						/* $new_txn_id_2 = $this->transaction_model->add_transaction(TAX_PAYMENT,  $user_id);
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => $user_wallet_id, 'debit' => $bidder_amt['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$project_id)); */
						
						/* transfer project amount to TAX wallet TAX_WALLET */
						/* $this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id_2, 'wallet_id' => TAX_WALLET, 'credit' => $bidder_amt['tax_amount'], 'ref' => $bid_id , 'info' => 'HST Charge #'.$project_id)); */
						
					
						wallet_less_fund($user_wallet_id, $bidder_amt['total_amt']);
						wallet_add_fund(ESCROW_WALLET,$bid_amount);
						/* wallet_add_fund(TAX_WALLET,$bidder_amt['tax_amount']); */
				
						
						check_wallet($user_wallet_id,  $new_txn_id);
						check_wallet(ESCROW_WALLET,  $new_txn_id);
						/* check_wallet(TAX_WALLET,  $new_txn_id); */
						
						$project_txn = array(
							'project_id' => $project_id,
							'txn_id' => $new_txn_id,
						);
						
						$this->db->insert('project_transaction', $project_txn);
						$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
					
						// record escrow in escrow table
						
						$milestones = $this->db->where('bid_id', $bid_id)->get('project_milestone')->row_array();
						
						if(count($milestones) > 0){
							
							$escrow_data = array(
								'milestone_id' => $milestones['id'],
								'amount' => $bidder_amt['total_amt'],
								'bidder_amt' => $bidder_amt['bidder_amt'],
								'admin_fee' => $bidder_amt['admin_fee'],
								'tax_amount' => $bidder_amt['tax_amount'],
								'status' => 'P',
								'project_id' => $project_id,
							);

							$this->db->insert('escrow_new', $escrow_data);
							
						}
						
						/* send email to freelancer and employer */
						$p_title = getField('title', 'projects', 'project_id',$project_id);
						$PROJECT_TITLE = $p_title;
						
						$employer_email = getField('email', 'user', 'user_id', $user[0]->user_id);
						$freelancer_email = getField('email', 'user', 'user_id', $alluser);
						$CONTRACTOR_NAME = getField('fname', 'user', 'user_id', $alluser);
						$CONTRACTOR_NAME .= ' ';
						$CONTRACTOR_NAME .= getField('lname', 'user', 'user_id', $alluser);
						
						$EMPLOYER_NAME = getField('fname', 'user', 'user_id', $user[0]->user_id);
						$EMPLOYER_NAME .= ' ';
						$EMPLOYER_NAME .= getField('lname', 'user', 'user_id', $user[0]->user_id);
						
						$template = 'project_fund_escrowed';
						$to = array($employer_email, $freelancer_email);
						$data_parse = array(
							'AMOUNT' => format_money($bidder_amt['total_amt'], TRUE),
							'PROJECT_TITLE' => $p_title,
							'NAME' => $EMPLOYER_NAME,
						);
						send_layout_mail($template, $data_parse, $employer_email);
						
						$data_parse['NAME'] = $CONTRACTOR_NAME;
						send_layout_mail($template, $data_parse, $freelancer_email);
						
						$template = 'awarded_bid_detail';
						$to = $employer_email;
						$data_parse = array(
							'USER' => $EMPLOYER_NAME,
							'PROJECT_TITLE' => $PROJECT_TITLE,
							'CONTRACTOR_NAME' => $CONTRACTOR_NAME,
							'BID_AMOUNT' => format_money($bid_amount_before_tax, TRUE),
							'HST' => format_money($bidder_amt['tax_amount'], TRUE),
							'TOTAL' => format_money($bidder_amt['total_amt'], TRUE),
						);
						
						send_layout_mail($template, $data_parse, $to);
						
						
						
						
						
					}

				}
				
			}
			
			$title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
			$link=VPATH."jobdetails/details/".$project_id;
			$bid_amount_before_tax = ($bidder_amt['bidder_amt'] + $bidder_amt['admin_fee']);
			$fname = getField('fname', 'user', 'user_id', $bidder_amt['bidder_id']);
			$to=  getField('email', 'user', 'user_id', $bidder_amt['bidder_id']);
			$template='freelancer_bid_won';
			$data_parse=array(
				'USER'=>$fname,
				'PROJECT_TITLE'=>$title,
				'BID_AMOUNT'=>format_money($bid_amount_before_tax, TRUE),
				'PROJECT_URL'=>$link
			);
			
			send_layout_mail($template, $data_parse, $to);
			
			$link=VPATH."jobdetails/details/".$project_id;
			$from=ADMIN_EMAIL;
			foreach($allarrayuser as $valU){
				if(!in_array($valU,$all_chosen)){
					$user_id=$valU;

					/* $to=$this->auto_model->getFeild('email','user','user_id',$user_id);
					$fname=$this->auto_model->getFeild('fname','user','user_id',$user_id);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$user_id);
					$template='select_job_notification';
					$data_parse=array('name'=>$fname." ".$lname,
										'title'=>$title,
										'copy_url'=>$link,
										'url_link'=>$link
										);
					
					send_layout_mail($template, $data_parse, $to); */

					$post_data['from_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
					$post_data['to_id']=$user_id;
					
					$notification = 'Congratulations! You have been hired for the project'.$title;
					$link = "projectroom/freelancer/overview/".$project_id;
					$this->notification_model->log($post_data['from_id'], $post_data['to_id'], $notification, $link);
				}
			}
			if($upd){
				$res['status'] = 1;
				$res['msg'] =  "<div class='success alert-success alert'>You have chosen a freelancer successfully</div>";
			}

			
		}

		echo json_encode($res);
   }
   
   
   public function acceptoffer(){
   		$user_id=$this->input->post('userid');
		$project_id=$this->input->post('projectid');

		$all_bidder=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
		if(!empty($all_bidder)){
			$all_bidder = explode(',', $all_bidder);
		}else{
			$all_bidder = array();
		}
		//$all_bidder=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id));


		$all_chosen=$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id);
		if(!empty($all_chosen)){
			$all_chosen = explode(',', $all_chosen);
		}else{
			$all_chosen = array();
		}
		//$all_chosen=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id));
		//$get_key_bidder=array_search($user_id,$all_bidder);
		$get_key_chosen=array_search($user_id,$all_chosen);

		$all_chosen[$get_key_chosen]=0;
		if(!in_array($user_id, $all_bidder)){
			array_push($all_bidder, $user_id);
		}

		//$all_bidder[$get_key_chosen]=$user_id;
		//$new_data['chosen_id']=0;
		$new_data['chosen_id']= implode(",",$all_chosen);
		$new_data['status']= 'P';
		//$new_data['bidder_id']=$user_id;
		$new_data['bidder_id']= implode(",",$all_bidder);


		/*echo "<pre>";
		print_r($new_data);
		die();*/
		$upd=$this->dashboard_model->updateProject($new_data,$project_id);

		$title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
		$link=VPATH."findjob/";
		$all_bidder=$this->postjob_model->getBidder($project_id);
		$from=ADMIN_EMAIL;
		foreach($all_bidder as $key=>$val)
		{
			if($val['bidder_id']!=$user_id)
			{
			$to=$this->auto_model->getFeild('email','user','user_id',$val['bidder_id']);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
			$template='process_job_notification';
			$data_parse=array('name'=>$fname." ".$lname,
								'title'=>$title,
								'copy_url'=>$link,
								'url_link'=>$link
								);
			$this->auto_model->send_email($from,$to,$template,$data_parse);
			}
		}


		$to_id=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
		$username1=$this->auto_model->getFeild('username','user','user_id',$user_id);
		$fname1=$this->auto_model->getFeild('fname','user','user_id',$to_id);
		$lname1=$this->auto_model->getFeild('lname','user','user_id',$to_id);
		$template='accept_offer_notification';
		$data_parse=array('name'=>$fname1." ".$lname1,
							'title'=>$title,
							'username'=>$username1
							);
		$this->auto_model->send_email($from,$to_mail,$template,$data_parse);

		$post_data['to_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$post_data['from_id']=$user_id;
		$username=$this->auto_model->getFeild('username','user','user_id',$user_id);
		$f_name_user=$this->auto_model->getFeild('fname','user','user_id',$user_id);
		$l_name_user=$this->auto_model->getFeild('lname','user','user_id',$user_id);

		//$post_data['notification']='Congratulations! Your project offer for <a href="'.VPATH.'projectdashboard/index/'.$project_id.'">'.$title.'</a> has been accepted by <a href="'.VPATH.'clientdetails/showdetails/'.$user_id.'">'.$username."</a>";

		/* $post_data['notification']='Congratulations! Your project offer for <a href="'.VPATH.'projectdashboard/index/'.$project_id.'">'.$title.'</a> has been accepted by <a href="'.VPATH.'clientdetails/showdetails/'.$user_id.'">'.$username."</a>";

		$post_data['add_date']=date('Y-m-d');
		$this->dashboard_model->insert_Notification($post_data); */

		$notification = 'Congratulations! Your project offer for '.$title.' has been accepted by '.$f_name_user.' '.$l_name_user;
		$link ='projectdashboard/index/'.$project_id;

		$this->notification_model->log($post_data['from_id'], $post_data['to_id'], $notification, $link);
		if($upd)
		{
			echo "<div class='success alert-success alert'>You have accepted this offer successfully</div>";
		}
   }
   
   
   public function declineoffer()
   {
   		$user_id=$this->input->post('userid');
		$project_id=$this->input->post('projectid');

		$all_bidder=explode(",",$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id));
		$all_chosen=explode(",",$this->auto_model->getFeild('chosen_id','projects','project_id',$project_id));
		//$get_key_bidder=array_search($user_id,$all_bidder);
		$get_key_chosen=array_search($user_id,$all_chosen);

		$all_chosen[$get_key_chosen]=0;
		$all_bidder[$get_key_chosen]=$user_id;


		//$new_data['chosen_id']= 0;
		$new_data['chosen_id']= implode(",",$all_chosen);
		if(max($all_chosen)>0){
		$new_data['status']= 'O';
		}else{
			$new_data['status']= 'P';
		}

		$upd=$this->dashboard_model->updateProject($new_data,$project_id);

		$title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
		$to_id=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$to_mail=$this->auto_model->getFeild('email','user','user_id',$to_id);
		$username1=$this->auto_model->getFeild('username','user','user_id',$user_id);
		$fname1=$this->auto_model->getFeild('fname','user','user_id',$to_id);
		$lname1=$this->auto_model->getFeild('lname','user','user_id',$to_id);
		$template='decline_offer_notification';
		$data_parse=array('name'=>$fname1." ".$lname1,
							'title'=>$title,
							'username'=>$username1
							);
		$this->auto_model->send_email($from,$to_mail,$template,$data_parse);

		$post_data['to_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$post_data['from_id']=$user_id;
		$username=$this->auto_model->getFeild('username','user','user_id',$user_id);
		/* $post_data['notification']='Your project offer for project <a href="'.VPATH.'dashboard/myproject_client">'.$title.'</a> has been declined by <a href="'.VPATH.'clientdetails/showdetails/'.$user_id.'">'.$username.'</a>';
		$post_data['add_date']=date('Y-m-d');
		$this->dashboard_model->insert_Notification($post_data); */

		$notification = 'Your project offer for project '.$title.' has been declined by '.$username;
		$link = 'clientdetails/showdetails/'.$user_id;
		$this->notification_model->log($post_data['from_id'], $post_data['to_id'], $notification, $link);

		if($upd)
		{
		echo "<div class='success alert-warning alert'>You have declined this offer</div>";

		}
   }
   public function rating()
   {
		if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['given_id']=$user[0]->user_id;
		$data['project_id']=$this->uri->segment(3);
		$data['user_id']=$this->uri->segment(4);
		$breadcrumb=array(
                    array(
                        'title'=>__('dashboard','Dashboard'),'path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('rating','Rating'));

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='feedback';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		//$data['projects']=$this->dashboard_model->getProject($status,$id);

		$lay['client_testimonial']="inc/footerclient_logo";
		if($this->input->post())
		{
			 $this->form_validation->set_rules('safety', __('dashboard_safety_rating','Safety rating'), 'required');
			 $this->form_validation->set_rules('flexiblity', __('dashboard_flexibility_rating','Flexibility rating'), 'required');
			 $this->form_validation->set_rules('performence', __('dashboard_perfomence_rating','Performence rating'), 'required');
			 $this->form_validation->set_rules('initiative', __('dashboard_initiative_rating','Initiative rating'), 'required');
			 $this->form_validation->set_rules('knowledge', __('dashboard_knowledge_rating','Knowledge rating'), 'required');

             if($this->form_validation->run()==FALSE){

                    $this->layout->view('rating1',$lay,$data,'normal');
                }
				else
				{
					$new_data['user_id']=$this->input->post('user_id');
					$new_data['given_user_id']=$this->input->post('given_id');
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
					$insrt=$this->dashboard_model->insertReview($new_data);
					if($insrt)
					{
						$this->session->set_flashdata('rating_succ',"Your review has been submitted successfully.");
						redirect(VPATH."dashboard/rating/".$data['project_id']."/".$data['user_id']."/".$this->uri->segment(5))	;
					}
					else
					{
						$this->session->set_flashdata('rating_eror',"Submission failed. Please try again.");
						redirect(VPATH."rating/".$data['project_id']."/".$data['user_id']."/".$this->uri->segment(5))	;
					}
				}
		}
		else
		{

			$this->layout->view('rating1',$lay,$data,'normal');
		}
		}

	}
	public function viewfeedback()
	{
		if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['given_id']=$given_id=$user[0]->user_id;
		$data['project_id']=$project_id=$this->uri->segment(3);
		$data['user_id']=$user_id=$this->uri->segment(4);
		$breadcrumb=array(
                    array(
                        'title'=>'Dashboard','path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'myproject');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='feedback';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		$data['feedback']=$this->dashboard_model->getAllreview($project_id,$given_id,$user_id);

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('feedback',$lay,$data,'normal');

		}
	}
	public function myfeedback()
	{
		if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['user_id']=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                        'title'=>'Feedback','path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Feedback');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='feedback';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		$type = 'received';
		
		if(get('tab') && get('tab') == 'given'){
			$type = 'given';
		}

		$data['allfeedback']=$this->dashboard_model->getmyreview_new($data['user_id'], $type);
		//get_print($data['allfeedback'], false);
		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('myfeedback',$lay,$data,'normal');

		}
	}
	public function feedbackdetails()
	{
		if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{

		$user=$this->session->userdata('user');

		$data['given_id']=$given_id=$this->uri->segment(4);
		$data['project_id']=$project_id=$this->uri->segment(3);
		$data['user_id']=$user_id=$user[0]->user_id;
		$breadcrumb=array(
                    array(
                        'title'=>'Feedback','path'=>''
                    )

                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Feedback');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='myproject';

		$head['ad_page']='feedback';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		$data['feedback']=$this->dashboard_model->getAllreview($project_id,$given_id,$user_id);

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('feedback',$lay,$data,'normal');

		}
	}

      public function closeacc(){
		  if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		  }
		  else{
			  $user=$this->session->userdata('user');

				$data['user_id']=$user[0]->user_id;
				 //$data['user_membership']=$user[0]->membership_plan;

				$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);

				$data['ldate']=$user[0]->ldate;

				$breadcrumb=array(
							array(
									'title'=>'Close Account','path'=>''
							)
						);

				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Close Account');

				///////////////////////////Leftpanel Section start//////////////////

				$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

				if($logo==''){
					$logo="images/user.png";
				}
				else{
					if(file_exists('assets/uploaded/cropped_'.$logo)){
						$logo="uploaded/cropped_".$logo;
					}else{
						$logo="uploaded/".$logo;
					}
				}
				$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
				$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

				///////////////////////////Leftpanel Section end//////////////////

				$head['current_page']='testimonial';

				$head['ad_page']='close_account';

				$load_extra=array();

				$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

				$this->layout->set_assest($head);

				$username=$this->auto_model->getFeild('username','user','user_id',$user[0]->user_id);


				$this->autoload_model->getsitemetasetting("meta","pagename","Testimonial");

				$lay['client_testimonial']="inc/footerclient_logo";

			  if($this->input->post())
			  {
			  	$this->form_validation->set_rules('description', '', '');

				if ($this->form_validation->run() == FALSE) {
					$this->layout->view('close_acc',$lay,$data,'normal');
				} else {

					$from=ADMIN_EMAIL;
					$to=ADMIN_EMAIL;
					$template='close_account_admin';
					$data_parse=array('username'=>$username,
										'user_id'=>$user[0]->user_id,
										'reason' => $this->input->post('description')
										);
					$this->auto_model->send_email($from,$to,$template,$data_parse);

					$from1=ADMIN_EMAIL;
					$to1=$this->auto_model->getFeild('email','user','user_id',$user[0]->user_id);
					$template1='close_account';
					$data_parse1=array('username'=>$username
										);
					$this->auto_model->send_email($from1,$to1,$template1,$data_parse1);
					$this->dashboard_model->closeAccount();
					redirect(VPATH."user/logout");
				}
			  }
			  else
			  {
				  $this->layout->view('close_acc',$lay,$data,'normal');
			   }
		  }
      }
	  public function enableescrow($pid='')
	  {
		  $user=$this->session->userdata('user');

		  $user_id=$user[0]->user_id;


		  if($pid!=""){

			  $project_id=$pid;
			  $title=$this->auto_model->getFeild("title","projects","project_id",$pid);
			  $bidder_id=$this->auto_model->getFeild("bidder_id","projects","project_id",$pid);
			  $total_amt=$this->auto_model->getFeild("total_amt","bids","","",array("project_id"=>$project_id,"bidder_id"=>$bidder_id));

			  $acc_balance=$this->auto_model->getFeild("acc_balance","user","user_id",$user[0]->user_id);

			  $escrow_amount=$total_amt+($total_amt*(ESCROW_CHARGE/100));

			  $post_data['user_id'] =$user[0]->user_id;
              $post_data['project_id'] = $project_id;
              $post_data['payamount'] = $total_amt;
              $post_data['posted']=date('Y-m-d');
			  $post_data['status']='A';
              $insert = $this->dashboard_model->insertEscrow($post_data);
              if($insert){
               $data_transaction=array(
                        "user_id" =>$user[0]->user_id,
                        "amount" =>$escrow_amount,
			            "profit" => $total_amt*(ESCROW_CHARGE/100),
                        "transction_type" =>"DR",
                        "transaction_for" => "Escrow Set",
                        "transction_date" => date("Y-m-d H:i:s"),
                        "status" => "Y"
                    );


                $balance=($acc_balance-$escrow_amount);
				$this->dashboard_model->insertTransaction($data_transaction);
                $this->dashboard_model->update_User($balance,$user[0]->user_id);

				$data_escrow=array(
				  "escrow_enabled" => "Y"
			  );

			 $this->dashboard_model->updateProject($data_escrow,$project_id);

			$from=ADMIN_EMAIL;
			$to=ADMIN_EMAIL;
			$template='escrow_enable_notification';
			$data_parse=array('title'=>$title
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);

			/* $data_notification=array(
			   "from_id" =>$user_id,
			   "to_id" =>$user_id,
			   "notification" =>"Escrow is enabled for, ".$title,
			   "add_date"  => date("Y-m-d")
			 );

			 $data_notic=array(
			   "from_id" =>$user_id,
			   "to_id" =>$bidder_id,
			   "notification" =>"Escrow is enabled for ".$title,
			   "add_date"  => date("Y-m-d")
			 );

			 $this->dashboard_model->insert_notification($data_notification);

			 $this->dashboard_model->insert_notification($data_notic); */


			  $notification = "Escrow is enabled for, ".$title;
				$link = '';
				$this->notification_model->log($user_id, $user_id, $notification, $link);


				$notification1 = "Escrow is enabled for ".$title;
				$link1 = '';
				$this->notification_model->log($user_id, $bidder_id, $notification1, $link1);

			 $this->session->set_flashdata('succ_job',"Escrow is enabled successfuly for your project");
			 redirect(VPATH."dashboard/myproject_client");
			}

		  }
	  }
	  ///////////////////////// ADDED 02.02.15 ////////////////////////////

	public function setMilestone($project_id=''){

	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
		$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
        $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$data['bidder_id']=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
		$data['project_id']=$project_id;
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$project_id);
		$data['employer_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$data['bidder_amt']=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_id,'bidder_id'=>$data['bidder_id']));
		$bidder_email=$this->auto_model->getFeild('email','user','user_id',$data['bidder_id']);
		$employer_email=$this->auto_model->getFeild('email','user','user_id',$data['employer_id']);
		$fname=$this->auto_model->getFeild('fname','user','user_id',$data['employer_id']);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$data['employer_id']);
		$data['milestone_no']='';

		if($data['bidder_id']==$data['user_id'])
		{
			$request_by="F";
		}
		if($data['employer_id']==$data['user_id'])
		{
			$request_by="E";
		}

		$breadcrumb=array(
			array(
					'title'=>'My Profile','path'=>'dashboard/'
			),
			array(
					'title'=>'Set Milestone','path'=>''
			)
		);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Set Milestone');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='milestone';

		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";




		if($this->input->post())
		{
			//print_r($this->input->post());die;
			$data['milestone_no']=$this->input->post('milestone_no');
           $this->form_validation->set_rules('amount[]', 'Milestone Amount', 'required|numeric');
           $this->form_validation->set_rules('mpdate[]', 'Date', 'required');
		   $this->form_validation->set_rules('description[]', 'Description', 'required');
		   $this->form_validation->set_rules('title[]', 'Title', 'required');
           if ($this->form_validation->run() == FALSE){
               $this->layout->view('set_milestone',$lay,$data,'normal');
           }
		   else
		   {
			   $count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$project_id);
				if($count_milestone>0)
				{
					$this->dashboard_model->deleteMilestone($project_id);
				}
			   $milestone_no=$this->input->post('milestone_no');
			   $amount=$this->input->post('amount');
			   $mpdate=$this->input->post('mpdate');
			   $description=$this->input->post('description');
			   $title=$this->input->post('title');
			   $i=0;
			   for($i=0;$i<$milestone_no;$i++)
			   {
					$post_data['milestone_no']=$i+1;
					$post_data['amount']=$amount[$i];
					$post_data['mpdate']=date('Y-m-d',strtotime($mpdate[$i]));
					$post_data['description']=$description[$i];
					$post_data['title']=$title[$i];
					$post_data['project_id']=$project_id;
				   	$post_data['bidder_id']=$data['bidder_id'];
				  	$post_data['employer_id']=$data['employer_id'];
					$post_data['request_by']=$request_by;
					$insert = $this->dashboard_model->insertsetMilestone($post_data);
			 }
			 if($insert)
			 {
				$from=ADMIN_EMAIL;
				$to=$employer_email;
				$template='milestone_set_notification';
				$data_parse=array('title'=>$data['project_name'],
									'name'=>$fname." ".$lname
				);
				$this->auto_model->send_email($from,$to,$template,$data_parse);

				/* $data_notification=array(
				   "from_id" =>$data['bidder_id'],
				   "to_id" =>$data['bidder_id'],
				   "notification" =>"Milestone was set successfully for <a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>".$data['project_name']."</a>",
				   "add_date"  => date("Y-m-d")
				 );

				 $data_notic=array(
				   "from_id" =>$data['bidder_id'],
				   "to_id" =>$data['employer_id'],
				   "notification" =>"Milestone was successfully set for your project <a href='".VPATH."myfinance/milestone/".$project_id."'>".$data['project_name']."</a>",
				   "add_date"  => date("Y-m-d")
				 );

				 $this->dashboard_model->insert_notification($data_notification);

				 $this->dashboard_model->insert_notification($data_notic); */



				 $notification = "Milestone was set successfully for ".$data['project_name'];
				$link = "dashboard/MilestoneChart/".$project_id;
				$this->notification_model->log($data['bidder_id'], $data['bidder_id'], $notification, $link);


				$notification1 = "Milestone was successfully set for your project ".$data['project_name'];
				$link1 = "myfinance/milestone/".$project_id;
				$this->notification_model->log($data['bidder_id'], $data['employer_id'], $notification1, $link1);

				$this->session->set_flashdata('succ_msg',"Milestone is set successfully");
			 }
			 else
			 {
					 $this->session->set_flashdata('error_msg',"Milestone is not set successfully");
			 }

			  redirect(VPATH.'dashboard/setMilestone');

		   }


		}
        else
		{

			$this->layout->view('set_milestone',$lay,$data,'normal');
		}

	}
    }

	public function MilestoneEdit($project_id=''){

	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
	}
	else{
		$user=$this->session->userdata('user');
		$data['user_id']=$user[0]->user_id;
        $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		$data['bidder_id']=$this->auto_model->getFeild('bidder_id','projects','project_id',$project_id);
		$data['project_id']=$project_id;
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$project_id);
		$data['employer_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
		$data['bidder_amt']=$this->auto_model->getFeild('bidder_amt','bids','','',array('project_id'=>$project_id,'bidder_id'=>$data['bidder_id']));
		$data['milestone_no']=$this->auto_model->count_results('id','project_milestone','project_id',$data['project_id']);

		$data['set_milestone_list']=$this->dashboard_model->getsetMilestone($project_id);
		$bidder_email=$this->auto_model->getFeild('email','user','user_id',$data['bidder_id']);
		$employer_email=$this->auto_model->getFeild('email','user','user_id',$data['employer_id']);
		$fname=$this->auto_model->getFeild('fname','user','user_id',$data['employer_id']);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$data['employer_id']);
		$breadcrumb=array(
			array(
					'title'=>'My Profile','path'=>'dashboard/'
			),
			array(
					'title'=>'Edit Milestone','path'=>''
			)
		);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Edit Milestone');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='edit_milestone';

		$head['ad_page']='myfinance';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myfinance");

		$lay['client_testimonial']="inc/footerclient_logo";




		if($this->input->post())
		{
			//print_r($this->input->post());die;
			foreach($data['set_milestone_list'] as $key=>$val)
			{
           		$this->form_validation->set_rules('amount_'.$val['id'], 'Milestone Amount', 'required|numeric');
           		$this->form_validation->set_rules('mpdate_'.$val['id'], 'Date', 'required');
		   		$this->form_validation->set_rules('description_'.$val['id'], 'Description', 'required');
				$this->form_validation->set_rules('title_'.$val['id'], 'Title', 'required');
			}
           if ($this->form_validation->run() == FALSE){
               $this->layout->view('edit_milestone',$lay,$data,'normal');
           }
		   else
		   {

			   foreach($data['set_milestone_list'] as $key=>$val)
			   {
					$post_data['amount']=$this->input->post('amount_'.$val['id']);
					$post_data['mpdate']=date('Y-m-d',strtotime($this->input->post('mpdate_'.$val['id'])));
					$post_data['description']=$this->input->post('description_'.$val['id']);
					$post_data['title']=$this->input->post('title_'.$val['id']);
					$post_data['client_approval']='N';
					$post_data['fund_release']='P';
					$post_data['release_payment']='N';

					$insert = $this->dashboard_model->editMilestone($post_data,$val['id']);
			 }
			 if($insert)
			 {
				$from=ADMIN_EMAIL;
				$to=$employer_email;
				$template='milestone_edit_notification';
				$data_parse=array('title'=>$data['project_name'],
									'name'=>$fname." ".$lname
				);
				$this->auto_model->send_email($from,$to,$template,$data_parse);

				/* $data_notification=array(
				   "from_id" =>$data['bidder_id'],
				   "to_id" =>$data['bidder_id'],
				   "notification" =>"Milestone is modified for project: <a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>".$data['project_name']."</a>",
				   "add_date"  => date("Y-m-d")
				 );

				 $data_notic=array(
				   "from_id" =>$data['bidder_id'],
				   "to_id" =>$data['employer_id'],
				   "notification" =>"Milestone is modified for your project <a href='".VPATH."myfinance/milestone/".$project_id."'>".$data['project_name']."</a>",
				   "add_date"  => date("Y-m-d")
				 );

				 $this->dashboard_model->insert_notification($data_notification);

				 $this->dashboard_model->insert_notification($data_notic); */


				$notification = "Milestone is modified for project: ".$data['project_name'];
				$link = "dashboard/MilestoneChart/".$project_id;
				$this->notification_model->log($data['bidder_id'], $data['bidder_id'], $notification, $link);


				$notification1 = "Milestone is modified for your project ".$data['project_name'];
				$link1 = "myfinance/milestone/".$project_id;
				$this->notification_model->log($data['bidder_id'], $data['employer_id'], $notification1, $link1);

				$this->session->set_flashdata('succ_msg',"Milestone is modified successfully");
			 }
			 else
			 {
					 $this->session->set_flashdata('error_msg',"Milestone is not set successfully");
			 }

			  redirect(VPATH.'dashboard/MilestoneEdit/'.$project_id);

		   }


		}
        else
		{

			$this->layout->view('edit_milestone',$lay,$data,'normal');
		}

	}
    }




	public function MilestoneChart($project_id='')
	{
	if(!$this->session->userdata('user')){
		redirect(VPATH."login/");
		}
	else{
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

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['project_id']=$project_id;
		$data['project_name']=$this->auto_model->getFeild('title','projects','project_id',$project_id);
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='My Milestone';

		$head['ad_page']='professional_project';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Myproject");

		$data['set_milestone_list']=$this->dashboard_model->getsetMilestone($project_id, $data['user_id']);

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('milestone_chart',$lay,$data,'normal');
		}
	}

	///////////////////// END 02.02.15/////////////////////////

	public function FundRequest($milestone_id='')
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{
			$this->load->helper('invoice');
			$user=$this->session->userdata('user');
			$data['user_id']=$user[0]->user_id;
			$project_id=$this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
			$project_status=$this->auto_model->getFeild("status",'projects','project_id',$project_id);
			if($project_status=='P'){
			}else{
				$this->session->set_flashdata('error_msg',"You cannot send request on cancel project");
				redirect(VPATH.get('next'));
				exit();
			}	
				
			$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
			$data['employer_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
			$bidder_email=$this->auto_model->getFeild('email','user','user_id',$data['user_id']);
			$employer_email=$this->auto_model->getFeild('email','user','user_id',$data['employer_id']);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$data['employer_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$data['employer_id']);
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$project_id);
			/* $amount=$this->auto_model->getFeild('amount','project_milestone','id',$milestone_id); */
			$bid_id = $this->auto_model->getFeild('bid_id','project_milestone','id',$milestone_id);
			$bid_row = get_row(array('select' => '*', 'from' => 'bids', 'where' => array('id' => $bid_id)));
			$amount= ($bid_row['bidder_amt'] + $bid_row['admin_fee']);
			
			$user_info = get_row(array('select' => 'fname,lname','from' => 'user', 'where' => array('user_id' => $data['user_id'])));
			$sender_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($data['user_id']),
			);
			$receiver_info = array(
				'name' => $fname.' '.$lname,
				'address' => getUserAddress($data['employer_id']),
			);
			
			$invoice_data = array(
				'sender_id' => $data['user_id'],
				'receiver_id' => $data['employer_id'],
				'invoice_type' => 1,
				'sender_information' => json_encode($sender_info),
				'receiver_information' => json_encode($receiver_info),
				'receiver_email' => $employer_email,
				'hst_rate' => HST_RATE,
			
			);
			
			$inv_id = create_invoice($invoice_data); // creating invoice
			
			$invoice_row_data = array(
				'invoice_id' => $inv_id,
				'description' => $projects_title,
				'per_amount' => $amount,
				'unit' => 'Fixed',
				'quantity' => 1,
			);
			
			add_invoice_row($invoice_row_data); // adding invoice row
			
			add_project_invoice($project_id, $inv_id);
			
			$where=array("id"=>$milestone_id);
			$val['fund_release']='R';
			$val['release_payment']='R';
			$val['invoice_id']=$inv_id;
			$val['requested_date']=date('Y-m-d');
			$upd=$this->dashboard_model->updateProjectMilestone($val,$where);
			if($upd){
				$freelancer = getField('fname', 'user', 'user_id', $data['user_id']);
				$from=ADMIN_EMAIL;
				$to=$employer_email;
				$template='milestone_fund_request';
				$data_parse=array('title'=>$projects_title,
									'name'=>$fname." ".$lname,
									'FREELANCER'=>$freelancer,
									'BID_AMOUNT'=>format_money($amount, TRUE),
				);
				/*$this->auto_model->send_email($from,$to,$template,$data_parse);*/
				send_layout_mail($template, $data_parse, $to);

				$notification = "Fund request was sent successfully for: ".$milestone_title." for project: ".$projects_title;
				$link = "projectroom/freelancer/milestone/".$project_id;
				$this->notification_model->log($data['user_id'], $data['user_id'], $notification, $link);


				$notification1 = "{$user_info['fname']} {$user_info['lname']} requested the Fund for milestone: ".$milestone_title." for your project ".$projects_title;
				$link1 = "projectroom/employer/milestone/".$project_id;
				$this->notification_model->log($data['user_id'], $data['employer_id'], $notification1, $link1);
				
				
			
				$this->session->set_flashdata('succ_msg',"Congratulation!! You have Requested the fund.");
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Oops!!Something got wrong.Please Try Again.");
			}
			//redirect(VPATH."dashboard/MilestoneChart/".$project_id);
			//redirect(VPATH."/projectdashboard/milestone/".$project_id);
			redirect(VPATH.get('next'));
		}
	}

	public function paymentRequest($milestone_id='')
	{
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{
			$user=$this->session->userdata('user');
			$data['user_id']=$user[0]->user_id;
			$project_id=$this->auto_model->getFeild("project_id","project_milestone","id",$milestone_id);
			$milestone_title=$this->auto_model->getFeild("title","project_milestone","id",$milestone_id);
			$data['employer_id']=$this->auto_model->getFeild('user_id','projects','project_id',$project_id);
			$bidder_email=$this->auto_model->getFeild('email','user','user_id',$data['user_id']);
			$employer_email=$this->auto_model->getFeild('email','user','user_id',$data['employer_id']);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$data['employer_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$data['employer_id']);
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$project_id);


			$where=array("id"=>$milestone_id);
			$val['release_payment']='R';
			$upd=$this->dashboard_model->updateProjectMilestone($val,$where);
			if($upd)
			{
				$from=ADMIN_EMAIL;
				$to=$employer_email;
				$template='milestone_release_payment_request';
				$data_parse=array('title'=>$projects_title,
									'name'=>$fname." ".$lname
				);
				$this->auto_model->send_email($from,$to,$template,$data_parse);

				/* $data_notification=array(
				   "from_id" =>$data['user_id'],
				   "to_id" =>$data['user_id'],
				   "notification" =>"Release payment request was sent successfully for : <a href='".VPATH."dashboard/MilestoneChart/".$project_id."'>".$milestone_title."</a> for project: <a href='".VPATH."projectdashboard/index/".$project_id."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status"=>'N'
				 );

				 $data_notic=array(
				   "from_id" =>$data['user_id'],
				   "to_id" =>$data['employer_id'],
				   "notification" =>"Bidder requested for the payment of : <a href='".VPATH."myfinance/milestone/".$project_id."'>".$milestone_title."</a> for your project <a href='".VPATH."projectdashboard/index/".$project_id."'>".$projects_title."</a>",
				   "add_date"  => date("Y-m-d"),
				   "read_status"=>'N'
				 );

				 $this->dashboard_model->insert_notification($data_notification);

				 $this->dashboard_model->insert_notification($data_notic); */

				$notification = "Release payment request was sent successfully for : ".$milestone_title." for project: ".$projects_title;
				$link = "dashboard/MilestoneChart/".$project_id;
				$this->notification_model->log($data['user_id'], $data['user_id'], $notification, $link);


				$notification1 = "Bidder requested for the payment of : ".$milestone_title." for your project ".$projects_title;
				$link1 = "myfinance/milestone/".$project_id;
				$this->notification_model->log($data['user_id'], $data['employer_id'], $notification1, $link1);




				$this->session->set_flashdata('succ_msg',"Congratulation!! You have Requested the To Release Payment.");
			}
			else
			{
				$this->session->set_flashdata('error_msg',"Oops!!Something got wrong.Please Try Again.");
			}
			redirect(VPATH."dashboard/MilestoneChart/".$project_id);
		}
	}
	public function getNotificationcount()
	{
		if($this->session->userdata('user')){

		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$this->db->where(array('user_id'=>$user_id))->update('user',array('last_seen'=>time()));
		//echo $this->db->last_query();die;
		/*$count_notic=$this->auto_model->count_results('id','notification','','',array('to_id'=>$user_id,'read_status'=>'N'));
		echo $count_notic;	*/
		if($user_id>0){
		$filename=APATH."application/ECnote/".$user_id.".echo";
		 if(!file_exists($filename)){
		 		$this->dashboard_model->insert_notification_file($user_id);
		 		echo $noti=file_get_contents($filename);
		 	}else{
				echo $noti=file_get_contents($filename);
			}

		}
	}else{
		echo 0;
	}
	}
	
	public function getMessagecount(){
		if($this->session->userdata('user')){

			$user=$this->session->userdata('user');
			$user_id=$user[0]->user_id;
			
			if($user_id>0){
				$dir = "user_message/";
				$filename=$dir."user_".$user_id.".newmsg";
				if(!file_exists($filename)){
					echo 0;
				}else{
					echo $noti=file_get_contents($filename);
				}

			}
		}else{
			echo 0;
		}
	}
	

	public function updatenotification()
	{
		$notif_id=trim($this->input->post('notifid'));
		if($notif_id!=''){
		$notiid=explode(",",$notif_id);
		foreach($notiid as $key=>$val)
		{

			$this->dashboard_model->updateNotification($val);
		}
		}
		echo 1;

	}
	public function closeproject($pid="")
	{
		$data['status']="C";
		$upd=$this->dashboard_model->updateProject($data,$pid);
		if($upd)
		{
			$bidder_id=$this->auto_model->getFeild('bidder_id','projects','project_id',$pid);
			$bidder_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
			$bidder_name=$this->auto_model->getFeild('fname','user','user_id',$bidder_id)." ".$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
			$employer_id=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
			$projects_title=$this->auto_model->getFeild('title','projects','project_id',$pid);
			$from=ADMIN_EMAIL;
			$to=$employer_email;
			$template='job_closed_notification';
			$data_parse=array('title'=>$projects_title,
								'name'=>ucwords($bidder_name)
			);
			$this->auto_model->send_email($from,$to,$template,$data_parse);

			/* $data_notification=array(
			   "from_id" =>$employer_id,
			   "to_id" =>$employer_id,
			   "notification" =>"You have successfully closed the project : ".$projects_title,
			   "add_date"  => date("Y-m-d")
			 );
			 $data_notic=array(
			   "from_id" =>$employer_id,
			   "to_id" =>$bidder_id,
			   "notification" =>"Employer has successfully closed the project ".$projects_title,
			   "add_date"  => date("Y-m-d")
			 );

			 $this->dashboard_model->insert_notification($data_notification);

			 $this->dashboard_model->insert_notification($data_notic);*/



			 $notification = "You have successfully closed the project : ".$projects_title;
			 $link = '';
			 $this->notification_model->log($employer_id, $employer_id, $notification, $link);


			 $notification1 = "Employer has successfully closed the project ".$projects_title;
			 $link1 = '';
			 $this->notification_model->log($employer_id, $bidder_id, $notification1, $link1);

			$this->session->set_flashdata('succ_msg',"Congratulation!! You have successfully close this job.");
			redirect(VPATH."dashboard/myproject_client/");
		}
		else
		{
			$this->session->set_flashdata('error_msg',"Oops!!Something got wrong.Please Try Again.");
			redirect(VPATH."projectdashboard/employer/".$pid);
		}
	}
	public function getnotification(){
	$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$msg='';
		$ajj=array();
		if($user_id > 0){
			$filename=APATH."application/ECnote/".$user_id.".echo";
			file_put_contents($filename, 0);
			/* $this->db->where("to_id",$user_id)->update('notification', array('read_status' => 'Y')); */
		}


	$this->db->select("id,notification,add_date,link,read_status");
			$this->db->where("to_id",$user_id);
			/*$this->db->where('read_status','N');*/
			$this->db->order_by("id","desc");
			$this->db->limit(10);
			$res=  $this->db->get("notification");
			$data=array();
			$result = $res->result();
			if(count($result) > 0){
				foreach($result as $row){
				$hrefs = array();
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				$dom->loadHTML(html_entity_decode($row->notification));
				$tags = $dom->getElementsByTagName('a');
				foreach ($tags as $tag) {
					$hrefs[] =  $tag->getAttribute('href');
				}
				if($row->read_status == 'N'){
					$read_cls = 'unread';
				}else{
					$read_cls = 'read';
				}
				 /* $msg.='<li><a href="'.base_url($row->link).'" class="'.$read_cls.'">'.strip_tags(html_entity_decode($row->notification)).'</a></li>'; */
				 $msg.='<li><a href="'.base_url('dashboard/read_notification?noti_id='.$row->id.'&next='.$row->link).'" class="'.$read_cls.'">'.strip_tags(html_entity_decode($row->notification)).'</a></li>';

				}
			}else{
				$msg.= '<li style="padding: 10px; margin: 5px; background-color: #ddd; border-left: 4px solid grey;">Sorry , No notification found</li>';
			}
			
			if(count($result) > 0){
				// $msg.='<li><a href="'.VPATH.'notification/" class="btn btn-block btn-site">Show more</a></li>';
			}
			echo $msg;
	}
	public function project_dashboard(){
	   $user=$this->session->userdata('user');
   		$data['user_id']=$id=$user[0]->user_id;
		$status=$this->input->post('status');
		$projects=$this->dashboard_model->getProject($status,$id);
		echo "<h1><a ";
		if($status=='O'){
		echo "class='selected'";
		}
		echo "href='javascript:void(0)' onClick=projects('O');>Open Projects</a></h1>
		<h1><a ";
		if($status=='P'){
		echo "class='selected'";
		}
		echo " href='javascript:void(0)' onClick=projects('P');>Active</a></h1>

		<div class='editprofile'> 	 ";

		echo '<table id="example" class="table table-hover">
<thead><tr><th>Project Name</th><th>Project Type</th><th>Bids</th><th>Action</th><th>Posted date</th></tr>
</thead>
<tbody>	';

		/*echo "
		<div class='notiftext1'><h4>Project Name</h4><h4>Project Type</h4><h4>Bids</h4><h4>Action</h4><h4>Posted date</h4></div>";*/

		if(count($projects)>0)
		{
		foreach($projects as $key=>$val)
		{

			if($val['multi_freelancer']=='Y' && $val['project_type']=='H'){

			$allbidder=explode(",",$val['bidder_id']);
			$allchosen=explode(",",$val['chosen_id']);

			$name="";
			$b=0;$count_review=array();
			foreach($allbidder as $bidder){
				$b++;
				$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
				$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
				$name.=$fname." ".$lname;


			}
			$project_type="";
			if($val['project_type']=="F")
		{
			$project_type="<div class='hourly' title='Fixed'><i class='fa fa-lock'></i></div>";
		}
		else
		{
			$project_type="<div class='hourly' title='Hourly'><i class='fa fa-time'></i></div>";
		}
			echo "<tr>";
			echo "<td><a href='".VPATH."jobdetails/details/".$val['project_id']."'>".$val['title']."</a></td>";
			echo "<td align='center'>".$project_type."</td>";
			echo "<td>".$val['bidder_details']."</td>";

			/*echo "<div class='methodbox'>
			<div class='methodtext'><h2><strong><a href='".VPATH."jobdetails/details/".$val['project_id']."'>".$val['title']."</a></strong></h2></div>
			<div class='methodtext'><h2><strong>".$project_type."</strong></h2></div>
			<div class='methodtext'><h2><strong>".$val['bidder_details']."</strong></h2></div>";*/
			if($status=='F'){

				/*echo "<div class='methodtext'><h2><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'> Select a Freelancer</a> | You have chosen ";
				$biderc=array();
				foreach($allchosen as $chosen){
					$fnamec=$this->auto_model->getFeild('fname','user','user_id',$chosen);
					$lnamec=$this->auto_model->getFeild('lname','user','user_id',$chosen);
					$namec=$fnamec." ".$lnamec;
					$biderc[]= "<a href='".VPATH."clientdetails/showdetails/".$chosen."'>".$namec."</a>";
				}
				echo implode(" & ",$biderc);
				echo ". Waiting for approval | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
				echo "<td><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
				/*echo "<div class='methodtext'><h2><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
				}
			elseif($status=='P'){

			/*echo "<div class='methodtext'><h2>You have chosen ";
			$bidert=array();
			foreach($allbidder as $bidder){
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
					$name=$fname." ".$lname;
				$bidert[]="<a href='".VPATH."clientdetails/showdetails/".$bidder."'>".$name."</a>";
			}
			echo implode(" & ",$bidert);
			echo ". | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/
			echo "<td><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projectcontractor/index/".$val['project_id']."'>End Contractor</a> | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></td>";
			/*echo "<div class='methodtext'><h2><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/

		}
		elseif($status=='PS')
		{
			/*echo "<div class='methodtext'><h2>You have chosen ";

			$bidert=array();
			foreach($allbidder as $bidder){
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
					$name=$fname." ".$lname;
				$bidert[]="<a href='".VPATH."clientdetails/showdetails/".$bidder."'>".$name."</a>";
			}
			echo implode(" & ",$bidert);



			echo ". |<a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/
			echo "<td><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></td>";
			/*echo "<div class='methodtext'><h2><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'>View Freelancer</a> | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/
		}
		elseif($status=='C')
		{
		echo "<td>";
			/*echo "<div class='methodtext'><h2>You have chosen ";

			$bidert=array();
			foreach($allbidder as $bidder){
					$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
					$name=$fname." ".$lname;
				$bidert[]="<a href='".VPATH."clientdetails/showdetails/".$bidder."'>".$name."</a>. | ";
			}
			echo implode(" & ",$bidert)." |" ;
			*/
			echo "<a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
		$bidert=array();
		foreach($allbidder as $bidder){
		$fname=$this->auto_model->getFeild('fname','user','user_id',$bidder);
					$lname=$this->auto_model->getFeild('lname','user','user_id',$bidder);
					$name=$fname." ".$lname;
			$count_review=$this->dashboard_model->countReview($val['project_id'],$data['user_id'],$bidder);
			if($count_review>0)
			{
				echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$bidder."/".$val['title']."'>(".$name.") View Feedback.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
			}
			else
			{
				echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$bidder."/".$val['title']."'>(".$name.") Give Feedback.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
			}
		}

		/*echo "</h2></div>";	*/
		echo "</td>";
		}
		else
		{
		echo "<td>----</td>";
		/*echo "<div class='methodtext'><h2>----</h2></div>";*/
		}
		echo "<td>".date('d M,Y',strtotime($val['posted_date']))."</td>";
		/*echo "<div class='methodtext'><h2>".date('d M,Y',strtotime($val['posted_date']))."</strong></h2></div>
		</div>";*/
		echo "</tr>";







/**
* ***************************************************************************************************************
*/
			}else{


			$username=$this->auto_model->getFeild('username','user','user_id',$val['chosen_id']);
			$biddername=$this->auto_model->getFeild('username','user','user_id',$val['bidder_id']);
			$fname=$this->auto_model->getFeild('fname','user','user_id',$val['bidder_id']);
			$lname=$this->auto_model->getFeild('lname','user','user_id',$val['bidder_id']);
			$name=$fname." ".$lname;
			$count_review=$this->dashboard_model->countReview($val['project_id'],$data['user_id'],$val['bidder_id']);
			///////////////////////////Check Milestone Status/////////////////////////////
			$count_milestone=$this->auto_model->count_results('id','project_milestone','project_id',$val['project_id']);
			if($count_milestone>0)
			{
				$client_approval_Y=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'Y'));
				$client_approval_N=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'N'));
				$client_approval_D=$this->auto_model->count_results('id','project_milestone','','',array('project_id'=> $val['project_id'],'client_approval'=>'D'));
				$request_by=$this->auto_model->getFeild('request_by','project_milestone','project_id',$val['project_id']);
			}
			//////////////////////////End Checkinh Milestone////////////////////////////////
		$project_type="";
		if($val['project_type']=="F")
		{
			$project_type="<div class='hourly' title='Fixed'><i class='fa fa-lock'></i></div>";
		}
		else
		{
			$project_type="<div class='hourly' title='Hourly'><i class='fa fa-clock-o'></i></div>";
		}
		/*echo "<div class='methodbox'>
		<div class='methodtext'><h2><strong><a href='".VPATH."jobdetails/details/".$val['project_id']."'>".$val['title']."</a></strong></h2></div>
		<div class='methodtext'><h2><strong>".$project_type."</strong></h2></div>
		<div class='methodtext'><h2><strong>".$val['bidder_details']."</strong></h2></div>";*/
		echo "<tr>";
		echo "<td><a href='".VPATH."jobdetails/details/".$val['project_id']."'>".$val['title']."</a></td>";
		echo "<td align='center'>".$project_type."</td>";
		echo "<td>".$val['bidder_details']."</td>";
		if($status=='F')
		{
		echo "<td><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'> Select a Freelancer</a> | You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['chosen_id']."'>".$name."</a>. Waiting for approval | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
		/*echo "<div class='methodtext'><h2><a href='".VPATH."dashboard/selectprovider/".$val['project_id']."'> Select a Freelancer</a> | You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['chosen_id']."'>".$name."</a>. Waiting for approval | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
		}
		elseif($status=='P')
		{
		/*echo "<div class='methodtext'><h2>";*/
		/*if($val['escrow_enabled']=='N')
		{
		?>
		<a href='javascript:void(0)' onclick="if(confirm('Are you sure to enable escrow?')){window.location.href='<?php echo VPATH;?>dashboard/enableescrow/<?php echo $val['project_id'];?>'}"> Enable Escrow Payment</a> |

		}*/
		/*echo "You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$name."</a>. | ";*/
		echo "<td>You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$name."</a>. | ";
		if($val['project_type']=='F')
		{
		if($count_milestone==0)
		{
			/*echo "<a href='".VPATH."dashboard/setMilestone/".$val['project_id']."'>Set Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
			echo "<a href='".VPATH."dashboard/setMilestone/".$val['project_id']."'>Set Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
		}
		else
		{
			if($request_by=='F')
			{
				if($client_approval_Y >0)
				{
					echo "Milestone Approved. ";
				}
				elseif($client_approval_N >0)
				{
					echo " New Milestone Requested. ";
				}
				 /*echo "<a href='".VPATH."myfinance/milestone/".$val['project_id']."'>Click here to see Milestone.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
				echo "<a href='".VPATH."myfinance/milestone/".$val['project_id']."'>Click here to see Milestone.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
			}
			else
			{
				if($client_approval_Y >0)
				{
					/*echo "<a href='".VPATH."myfinance/milestone/".$val['project_id']."'>Click here to see Milestone.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
					echo "<a href='".VPATH."myfinance/milestone/".$val['project_id']."'>Click here to see Milestone.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
				}
				elseif($client_approval_N >0)
				{
					/*echo "Mileston is Waiting for Freelancee Approval | <a href='".VPATH."dashboard/MilestoneChart/".$val['project_id']."'>View Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
					echo "Mileston is Waiting for Freelancee Approval | <a href='".VPATH."dashboard/MilestoneChart/".$val['project_id']."'>View Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
				}
				elseif($client_approval_D>0)
				{
				 /*echo "Milestone Declined by Client | <a href='".VPATH."dashboard/MilestoneEdit/". $val['project_id']."'>Edit Milestone</a> Or, <a href='".VPATH."dashboard/setMilestone/".$val['project_id']."'>Create New Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></h2></div>";*/
				 echo "Milestone Declined by Client | <a href='".VPATH."dashboard/MilestoneEdit/". $val['project_id']."'>Edit Milestone</a> Or, <a href='".VPATH."dashboard/setMilestone/".$val['project_id']."'>Create New Milestone</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a></td>";
				}
			}
		}
		}
		else
		{
			/*echo "<a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/

			echo "<a href='".VPATH."projectcontractor/index/".$val['project_id']."'>End Contractor</a> | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></td>";
		}
		}
		elseif($status=='PS')
		{
			/*echo "<div class='methodtext'><h2>";
			echo "You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$name."</a>. | ";
			echo "<a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></h2></div>";*/
			echo "<td>You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$name."</a>. | <a href='".VPATH."projecthourly/employer/".$val['project_id']."'>View Workroom</a></td>";
		}
		elseif($status=='C')
		{
			/*echo "<div class='methodtext'><h2>You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$biddername."</a>. | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";*/
			echo "<td>You have chosen <a href='".VPATH."clientdetails/showdetails/".$val['bidder_id']."'>".$biddername."</a>. | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
		if($count_review>0)
		{
			echo "<a href='".VPATH."dashboard/viewfeedback/".$val['project_id']."/".$val['bidder_id']."/".$val['title']."'>View Feedback.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
		}
		else
		{
			echo "<a href='".VPATH."dashboard/rating/".$val['project_id']."/".$val['bidder_id']."/".$val['title']."'>Give Feedback.</a> | <a href='".VPATH."projectdashboard/index/".$val['project_id']."'>Work Room</a>";
		}
		/*echo "</h2></div>";*/
		echo "</td>";
		}
		else
		{
		/*echo "<div class='methodtext'><h2>----</h2></div>";*/
		echo "<td>----</td>";
		}
		/*echo "<div class='methodtext'><h2>".date('d M,Y',strtotime($val['posted_date']))."</strong></h2></div>
		</div>";*/
		echo "<td>".date('d M,Y',strtotime($val['posted_date']))."</td>";
		echo "</tr>";

		}
			}
		}
		else
		{
		//echo "<tr><td></td></tr>";
		//echo "<div class='myprotext'><p><strong>No active jobs to display</strong></p></div>";

		}

		echo "</div>";


   }
       public function tracker()
    {
			$head['current_page']='timetracker';

			//$head['ad_page']='sitemap';

			$load_extra=array();

			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

			$this->layout->set_assest($head);

			$this->autoload_model->getsitemetasetting("meta","pagename","timetracker");

			$lay['client_testimonial']="inc/footerclient_logo";

			$data['sitemap']=$this->dashboard_model->trackercontent();
			$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
			$data['os']=$this->getOS($user_agent);
			$this->layout->view('timetracker', $lay, $data, 'normal');
	}
	function getOS($user_agent) {

   // global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
            '/windows nt 6.2/i'     =>  'Windows',
            '/windows nt 6.1/i'     =>  'Windows',
            '/windows nt 6.0/i'     =>  'Windows',
            '/windows nt 5.2/i'     =>  'Windows',
            '/windows nt 5.1/i'     =>  'Windows',
            '/windows xp/i'         =>  'Windows',
            '/windows nt 5.0/i'     =>  'Windows',
            '/windows me/i'         =>  'Windows',
            '/win98/i'              =>  'Windows',
            '/win95/i'              =>  'Windows',
            '/win16/i'              =>  'Windows',
            '/macintosh|mac os x/i' =>  'Mac',
            '/mac_powerpc/i'        =>  'Mac',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }

    return $os_platform;

}
	///////////////////////////////////Edit Bid Amount///////////////////////////
	public function editBidamount()
	{
		$bid_amount=$this->input->post('bid_amount');
		$projectid=$this->input->post('projectid');
		$bidder_id=$this->input->post('bidder_id');
		$userproject= $this->auto_model->getFeild("user_id","projects","project_id",$projectid);
		$membershipplan = $this->auto_model->getFeild("membership_plan","user","user_id",$userproject);
		$bidwin_charge= $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$membershipplan);
		$data['bidder_amt']=floatval($bid_amount);
		$data['total_amt']=floatval($bid_amount)+floatval((($bid_amount*$bidwin_charge)/100));
		$data['amt_modified']='Y';
		$this->db->where('project_id',$projectid);
		$this->db->where('bidder_id',$bidder_id);
		$this->db->update('bids', $data);
		echo floatval($bid_amount);
	}
	public function editBidnote()
	{
		$note=$this->input->post('note');
		$projectid=$this->input->post('projectid');
		$bidder_id=$this->input->post('bidder_id');
		$userproject= $this->auto_model->getFeild("user_id","projects","project_id",$projectid);
		$membershipplan = $this->auto_model->getFeild("membership_plan","user","user_id",$userproject);
		$bidwin_charge= $this->auto_model->getFeild("bidwin_charge","membership_plan","id",$membershipplan);
		$data['note']=$note;
		$this->db->where('project_id',$projectid);
		$this->db->where('bidder_id',$bidder_id);
		$this->db->update('bids', $data);
		echo $note."hr/week";
	}
	public function repostjob()
	{
		if( $this->input->post('action') == 'repostjob')
		{
			// $dbupdateArr = array('expiry_date'=>date("Y-m-d",  strtotime('+'.JOB_EXPIRATION.' day', strtotime(date("Y-m-d")))),'project_status'=>'Y','status'=>'O');
			//$dbupdateArr = array('project_status'=>'Y','status'=>'O');
			//$this->db->where('id',$this->input->post('jobid'));
			//$this->db->update('serv_projects',$dbupdateArr);
		}
	}

	public function pausecontractFreelancer()
	{
			$projectid=$this->input->post('projectid');
		   $bidder_id=$this->input->post('bidder_id');

			$pausedcontract ="UPDATE serv_bids SET pausedcontract='Y' WHERE project_id='".$projectid."' AND bidder_id='".$bidder_id."'";
			$SqlQuery= mysql_query($pausedcontract);
			if($SqlQuery){
				//echo "updated";

				$SelectSql = "SELECT title FROM serv_projects WHERE project_id='".$projectid."'";
				$ServProject    = mysql_query($SelectSql);
				$Resulttitle    =	mysql_fetch_assoc($ServProject);
				$Title       =	$Resulttitle['title'];
				 $Select 		= "SELECT fname,email FROM serv_user  WHERE user_id='".$bidder_id."'";
				$Resultdata		= mysql_query($Select);
				$GetDataarray	= mysql_fetch_assoc($Resultdata);
			 	$Fname          = $GetDataarray['fname'];
				$Emailsend      =$GetDataarray['email'];
				$url='http://www.jobbid.org/staging/jobdetails/details/'.$projectid;
						$from=ADMIN_EMAIL;
						$to=$Emailsend;
						$template='pausecontractFreelancer';
						$data_parse = array();
						$data_parse=array('username'=>$Fname,
											'jobtittle'=>$Title,
											'copy_url'=>$url,
											'url_link'=>$url
									);
									//echo '<pre>';
									//print_r($data_parse);
									//echo '</pre>';
									$this->auto_model->send_email($from,$to,$template,$data_parse);





			}
	}

	public function recontractFreelancer()
	{
		//ECHO "DFFGGF"; DIE;
		   $projectid=$this->input->post('projectid');
		   $bidder_id=$this->input->post('bidder_id');

			$pausedcontract ="UPDATE serv_bids SET pausedcontract='N' WHERE project_id='".$projectid."' AND bidder_id='".$bidder_id."'";
			$SqlQuery= mysql_query($pausedcontract);
			if($SqlQuery){
				//echo "updated";

				$SelectSql = "SELECT title FROM serv_projects WHERE project_id='".$projectid."'";
				$ServProject    = mysql_query($SelectSql);
				$Resulttitle    =	mysql_fetch_assoc($ServProject);
				$Title       =	$Resulttitle['title'];
				 $Select 		= "SELECT fname,email FROM serv_user  WHERE user_id='".$bidder_id."'";
				$Resultdata		= mysql_query($Select);
				$GetDataarray	= mysql_fetch_assoc($Resultdata);
			 	$Fname          = $GetDataarray['fname'];
				$Emailsend      =$GetDataarray['email'];
				$url='http://www.jobbid.org/staging/jobdetails/details/'.$projectid;
						$from=ADMIN_EMAIL;
						$to=$Emailsend;
						$template='recontractFreelancer';
						$data_parse = array();
						$data_parse=array('username'=>$Fname,
											'jobtittle'=>$Title,
											'copy_url'=>$url,
											'url_link'=>$url
									);
									//echo '<pre>';
									//print_r($data_parse);
									//echo '</pre>';
									$this->auto_model->send_email($from,$to,$template,$data_parse);



			}
	}

	public function saveEducation(){
		$ret = array();
		if($this->input->post()){
			$post = filter_data($this->input->post());
			$user = $this->session->userdata('user');
			$post['user_id'] = $user[0]->user_id;
			$ins = $this->db->insert('user_education', $post);
			$ins_id = $this->db->insert_id();
			$ret['education_id'] = $ins_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function editEducation($edu_id=''){
		$ret = array();
		$user = $this->session->userdata('user');
		if($this->input->post()){
			$post = filter_data($this->input->post());
			$uid = $user[0]->user_id;

			$ins = $this->db->where(array('education_id' => $edu_id, 'user_id' => $uid))->update('user_education', $post);
			$ret['education_id'] = $edu_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function delete_education(){
		$ret = array();
		$user = $this->session->userdata('user');
		if($this->input->post()){
			$edu_id = $this->input->post('edu_id');
			$uid = $user[0]->user_id;

			$this->db->where(array('education_id' => $edu_id, 'user_id' => $uid))->delete('user_education');
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function saveExperience(){
		$ret = array();
		if($this->input->post()){
			$post = filter_data($this->input->post());
			$user = $this->session->userdata('user');
			$post['user_id'] = $user[0]->user_id;
			$ins = $this->db->insert('user_experience', $post);
			$ins_id = $this->db->insert_id();
			$ret['experience_id'] = $ins_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function editExperience($exp_id=''){
		$ret = array();
		if($this->input->post()){
			$post = filter_data($this->input->post());
			if(empty($post['currently_working'])){
				$post['currently_working'] = 'N';
			}
			$user = $this->session->userdata('user');
			$user_id = $user[0]->user_id;
			$ins = $this->db->where(array('experience_id' => $exp_id, 'user_id' => $user_id))->update('user_experience', $post);
			$ret['experience_id'] = $exp_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function delete_experience(){
		$ret = array();
		$user = $this->session->userdata('user');
		if($this->input->post()){
			$exp_id = $this->input->post('exp_id');
			$uid = $user[0]->user_id;

			$this->db->where(array('experience_id' => $exp_id, 'user_id' => $uid))->delete('user_experience');
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}


	public function saveCertificate(){
		$ret = array();
		if($this->input->post()){
			$post = $this->input->post();
			$user = $this->session->userdata('user');
			$post['user_id'] = $user[0]->user_id;
			$ins = $this->db->insert('user_certificate', $post);
			$ins_id = $this->db->insert_id();
			$ret['certificate_id'] = $ins_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function editCertificate($c_id=''){
		$ret = array();
		$user = $this->session->userdata('user');
		if($this->input->post()){
			$post = $this->input->post();
			$uid = $user[0]->user_id;

			$ins = $this->db->where(array('certificate_id' => $c_id, 'user_id' => $uid))->update('user_certificate', $post);
			$ret['certificate_id'] = $c_id;
			$ret['data'] = json_encode($post);
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}

	public function delete_certificate(){
		$ret = array();
		$user = $this->session->userdata('user');
		if($this->input->post()){
			$edu_id = $this->input->post('c_id');
			$uid = $user[0]->user_id;

			$this->db->where(array('certificate_id' => $edu_id, 'user_id' => $uid))->delete('user_certificate');
			$ret['status'] = 1;
		}else{
			$ret['status'] = 0;
		}
		echo json_encode($ret);
	}


	public function invoice($invoice_id='', $type=''){
		$data = array();
		if(empty($invoice_id)){
			return;
		}
		$data['invoice_row'] = get_row(array('select' => '*','from' => 'invoice', 'where' => array('invoice_id' => $invoice_id, 'project_type' => $type)));

		$data['milestone_end_date'] = '';

		if($data['invoice_row']['project_type'] == 'F'){
			$data['milestone_title'] = getField('title', 'project_milestone', 'invoice_id', $invoice_id);
			$data['milestone_end_date'] = getField('mpdate', 'project_milestone', 'invoice_id', $invoice_id);
		}else{
			$data['milestone_title'] = 'Hourly payout';

			$data['manual_hour_row'] =get_row(array('select' => '*','from' => 'project_tracker_manual', 'where' => array('invoice_id' => $data['invoice_row']['invoice_id'])));
			$data['manual_hour_row']['acti']=$this->getActivity($data['manual_hour_row']['activity']);

		}


		$data['project'] = get_row(array('select' => '*','from' => 'projects', 'where' => array('project_id' => $data['invoice_row']['project_id'])));

		$data['owner_info'] = get_row(array('select' => '*','from' => 'user', 'where' => array('user_id' => $data['project']['user_id'])));
		$data['freelancer_info'] = get_row(array('select' => '*','from' => 'user', 'where' => array('user_id' => $data['manual_hour_row']['worker_id'])));
		$data['owner_info']['city'] = getField('Name','city','ID',$data['owner_info']['city']); 
		$data['owner_info']['country'] = getField('Name','country','Code',$data['owner_info']['country']); 
		
		$data['freelancer_info']['city'] = getField('Name','city','ID',$data['freelancer_info']['city']); 
		$data['freelancer_info']['country'] = getField('Name','country','Code',$data['freelancer_info']['country']); 
		//print_r($data);

		$this->load->view('pdf_html', $data);
	}

	public function email_verify(){
		$res =  array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$email = $user[0]->email;


		$ver_code = md5(time().rand(11111, 99999));
		$link = base_url('verify/verify_email/'.$ver_code);

		$this->db->where(array('user_id' => $user_id))->update('user', array('email_verification_link' => $ver_code));

		$res['status'] = 1;

		//$res['link'] = $link;
		$to=$this->auto_model->getFeild('email','user','user_id',$user_id);
		$from = ADMIN_EMAIL;
		$fname=$this->auto_model->getFeild('fname','user','user_id',$user_id);
		$lname=$this->auto_model->getFeild('lname','user','user_id',$user_id);
		$template='email_verification';
		$data_parse=array(
					'NAME'=>$fname." ".$lname,
					'LINK'=>$link
				);
		$this->auto_model->send_email($from,$to,$template,$data_parse);
		echo json_encode($res);

	}

	public function phone_verify(){
		$phone_num = $this->input->post('phone');
		if($phone_num){
			$res =  array();
			$ver_code = rand(11111111, 99999999);
			$this->session->set_userdata('phone_verification_code', $ver_code);
			$res['status'] = 1;
			$res['code'] = $ver_code;
			$res['phone'] = $phone_num;

			// send the code to the user phone
			echo json_encode($res);
		}

	}

	public function phone_code_verify(){
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$res = array();
		$code = $this->input->post('phone_ver_code');
		$phone_num = $this->input->post('phone_num');
		$sess_code = $this->session->userdata('phone_verification_code');
		if(!empty($sess_code) && !empty($code)){
			if($sess_code == $code){
				$this->db->where('user_id', $user_id)->update('user', array('phone_verified' => 'Y', 'phone' => $phone_num));
				$res['status'] = 1;
				$rs['msg'] = 'Phone successfully verified';
			}else{
				$res['status'] = 0;
				$res['msg'] = 'Invalid Code';
			}
		}else{
			$res['status'] = 0;
			$res['msg'] = 'Invalid Code';
		}

		echo json_encode($res);
	}

	public function upload_profile_pic(){
		if($_FILES){
			$res = array();
			$config['upload_path']          = './assets/uploaded/';
			$config['allowed_types']        = 'jpg|png|jpeg';
			$config['encrypt_name']        = TRUE;


			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')){
				$res['result'] = 0;
				$res['error'] = $this->upload->display_errors();
			}else{
				$file_name = $this->upload->data();
				$res['result'] = 1;
				$res['file_name'] = $file_name['file_name'];
            }
			echo json_encode($res);
		}
	}


	public function crop_image(){
		if($this->input->post()){
			$user = $this->session->userdata('user');
			$uid = $user[0]->user_id;
			$post = $this->input->post();
			$update = $this->db->where(array('user_id' => $uid))->update('user', array('logo' => $post['image']));
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'assets/uploaded/'.$post['image'];

			$config['maintain_ratio'] = TRUE;
			$config['width']         = $post['width'];
			$config['height']       = $post['height'];
			$config['x_axis']       = $post['x_pos'];
			$config['y_axis']       = $post['y_pos'];
			$config['maintain_ratio']  = FALSE;
			$config['new_image']  = 'assets/uploaded/'.'cropped_'.$post['image'];

			$this->load->library('image_lib', $config);
			if ( ! $this->image_lib->crop()){
				$res['result'] = 0;
				$res['error'] = $this->image_lib->display_errors();
			}else{
				$file_name = $config['new_image'];
				$configer =  array(
				  'image_library'   => 'gd2',
				  'source_image'    =>  $file_name,
				  'maintain_ratio'  =>  TRUE,
				  'width'           =>  150,
				  'height'          =>  150,
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($configer);
				$this->image_lib->resize();
				
				$res['result'] = 1;
			}
			echo json_encode($res);
		}


	}

	public function crop_image_bg(){
		if($this->input->post()){
			$user = $this->session->userdata('user');
			$uid = $user[0]->user_id;
			$post = $this->input->post();
			$update = $this->db->where(array('user_id' => $uid))->update('user', array('profile_bg_pic' => $post['image']));
			$config['image_library'] = 'gd2';
			$config['source_image'] = 'assets/uploaded/'.$post['image'];

			$config['maintain_ratio'] = TRUE;
			$config['width']         = $post['width'];
			$config['height']       = $post['height'];
			$config['x_axis']       = $post['x_pos'];
			$config['y_axis']       = $post['y_pos'];
			$config['maintain_ratio']  = FALSE;
			$config['new_image']  = 'assets/uploaded/'.'bgcropped_'.$post['image'];

			$this->load->library('image_lib', $config);
			if ( ! $this->image_lib->crop()){
				$res['result'] = 0;
				$res['error'] = $this->image_lib->display_errors();
			}else{
				$res['result'] = 1;
			}
			echo json_encode($res);
		}


	}


	public function project_action_status(){
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post() && $user_id){
			$json = array();
			$project_id = $this->input->post('project_id');
			$status = $this->input->post('status');
			$project_type = getField('project_type', 'projects', 'project_id', $project_id);
			
			
			//get_print($project_type);
			if(!empty($project_id) && !empty($status) && $project_type == 'F'){
				$p_user_id = getField('user_id', 'projects', 'project_id', $project_id);
				$bidder_str = $bidders = getField('bidder_id', 'projects', 'project_id', $project_id);
				$title = getField('title', 'projects', 'project_id', $project_id);

				$project_status = getField('status', 'projects', 'project_id', $project_id);

				$bidders = explode(',', $bidders);
				
				if($status == 'C'){
					
					if($p_user_id == $user_id){
						
						$this->db->where(array('project_id' => $project_id))->update('projects', array('status' => 'C'));
						$json['call_bk'] = 'review_employer';
						$json['bidder_id'] = $bidder_str;
						
					}else{
						
						$this->db->where(array('project_id' => $project_id))->update('projects', array('is_completed' => 'R', 'completed_requested_by' => $user_id));
						
						
					}
				
					if($p_user_id == $user_id){
						if(count($bidders) > 0){
							$noti_msg = 'Project - '. $title . ' : marked as completed';
							$link = 'dashboard/myproject_working';
							foreach($bidders as $k => $v){
								if(empty($v)){
									continue;
								}
								$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
							}
						}
						
						
						
						$invoice_url = get_project_invoice_url($project_id);
						$employer_email = getField('email', 'user', 'user_id', $p_user_id);
						$fname = getField('fname', 'user', 'user_id', $p_user_id);
						$data_parm = array(
							'USER' => $fname,
							'PROJECT_TITLE' => $title,
							'COPY_URL' => base_url('projectroom/employer/overview/'.$project_id),
						);
						
						if($invoice_url){
							$data_parm['ATTACHMENT'] = array($invoice_url);
						}
						
						send_layout_mail('project_completed', $data_parm, $employer_email);
						
					}else{
						$noti_msg = 'Confirm the complete request of '. $title . ' project';
						$link = 'dashboard/myproject_client';
						$this->notification_model->log($user_id, $p_user_id, $noti_msg, $link);
					}

				}else if($status == 'CNL'){

					if($project_status == 'P'){
						$reason = post('reason');
						$this->db->where(array('project_id' => $project_id))->update('projects', array('is_cancelled' => 'R', 'cancel_requested_by' => $user_id, 'note' => $reason));
						
						if($p_user_id == $user_id){
							if(count($bidders) > 0){
								$noti_msg = 'Confirm the cancel request of '. $title . ' project';
								$link = 'dashboard/myproject_working';
								foreach($bidders as $k => $v){
									if(empty($v)){
											continue;
										}
									$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
								}
							}
						}else{
							$noti_msg = 'Confirm the cancel request of '. $title . ' project :'.$reason;
							$link = 'dashboard/myproject_client';
							$this->notification_model->log($user_id, $p_user_id, $noti_msg, $link);
						}
						
					}else{
						$this->db->where(array('project_id' => $project_id))->update('projects', array('status' => $status));
					}



				}else{
					$this->db->where(array('project_id' => $project_id))->update('projects', array('status' => $status));

					if($status == 'PS'){
						if(count($bidders) > 0){
							$noti_msg = $title . ' project is paused by the employer';
							$link = 'dashboard/myproject_professional';
							foreach($bidders as $k => $v){
								if(empty($v)){
									continue;
								}
								$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
							}
						}
					}

					if($status == 'P'){
						if(count($bidders) > 0){
							$noti_msg = $title . ' project is start by the employer';
							$link = 'dashboard/myproject_professional';
							foreach($bidders as $k => $v){
								if(empty($v)){
									continue;
								}
								$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
							}
						}
					}


				}
				
				$json['status'] = 1;
				
			}else{
				
				$this->load->helper('project');
				
				if(!empty($project_id) && !empty($status) && $project_type == 'H'){
					
					$p_user_id = getField('user_id', 'projects', 'project_id', $project_id);
					$bidders = getField('bidder_id', 'projects', 'project_id', $project_id);
					$title = getField('title', 'projects', 'project_id', $project_id);
					$user_wallet_id = get_user_wallet($p_user_id);
					$bidders = explode(',', $bidders);
					
					if($status == 'C'){
						
						// check pending payment
						$pending_payments = get_project_pending_fund($project_id);
						$active_freelancers = $this->db->where(array('project_id' => $project_id, 'is_contract_end' => '0', 'is_project_start' => '1'))->count_all_results('project_schedule');
						
						if($pending_payments > 0){
							
							$json['status'] = 0;
							$json['errors']['pending_payment_c'] = '<div class="info-error">We found that you have '.CURRENCY. number_format($pending_payments, 2).' pending payments . Please clear all payment first</div>';
							
						}else if($active_freelancers > 0){
							$json['status'] = 0;
							$json['errors']['pending_payment_c'] = '<div class="info-error">Please end contract with all active contractor (s)</div>';
						}else{
							
							$total_deposit = get_project_deposit($project_id);
							$total_release = get_project_release_fund($project_id);
							
							$remaining_bal = $total_deposit - $total_release;
							
							if($remaining_bal > 0){
								// refund the payment to employer account 
								// add fund
								$this->load->model('myfinance/transaction_model');
								
								$ref = json_encode(array('project_id' => $project_id, 'refunded_amount' => $remaining_bal));
								
								// transaction insert
								$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FUND_REFUNDED,  $p_user_id);
								
								
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $remaining_bal, 'ref' => $ref , 'info' => 'Project fund refunded #'.$project_id));
								
								$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $remaining_bal, 'ref' => $ref , 'info' => 'Project fund refund received #'.$project_id));
								
								wallet_less_fund(ESCROW_WALLET,  $remaining_bal);
							
								wallet_add_fund($user_wallet_id, $remaining_bal);
								
								check_wallet($user_wallet_id,  $new_txn_id);
								
								check_wallet(ESCROW_WALLET,  $new_txn_id);
								
								$project_txn = array(
									'project_id' => $project_id,
									'txn_id' => $new_txn_id,
								);
								
								$this->db->insert('project_transaction', $project_txn);
								
							}
							
							$this->db->where(array('project_id' => $project_id))->update('projects', array('is_completed' => 'Y', 'status' => 'C'));

							if(count($bidders) > 0){
								$noti_msg = $title . ' project is marked as completed';
								$link = 'projectdashboard_new/freelancer/overview/'.$project_id;
								foreach($bidders as $k => $v){
									if(empty($v)){
										continue;
									}
									$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
								}
							}
							
							$json['status'] = 1;
						}
						
						

					}else if($status == 'PS'){
						$this->db->where(array('project_id' => $project_id))->update('projects', array('status' => 'PS'));

						if(count($bidders) > 0){
							$noti_msg = $title . ' project is paused';
							$link = 'projectdashboard_new/freelancer/overview/'.$project_id;
							foreach($bidders as $k => $v){
								if(empty($v)){
									continue;
								}
								$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
							}
						}
						
						$json['status'] = 1;
						
					}else if($status == 'P'){
						$this->db->where(array('project_id' => $project_id))->update('projects', array('status' => 'P'));

						if(count($bidders) > 0){
							$noti_msg = $title . ' project is now running';
							$link = 'projectdashboard_new/freelancer/overview/'.$project_id;
							foreach($bidders as $k => $v){
								if(empty($v)){
									continue;
								}
								$this->notification_model->log($p_user_id, $v, $noti_msg, $link);
							}
						}
						
						$json['status'] = 1;
						
					}else{
						$json['status'] = 1;
					}
					
					
				}else{
					$json['errors']['pending_payment_c'] = '<div class="info-error">Something went wrong</div>';
					$json['status'] = 0;
				}
			}

			
			echo json_encode($json);
		}
	}


	public function project_complete_confirm($p_id='', $status=''){
		$user = $this->session->userdata('user');
		$uid = $user[0]->user_id;
		$return = $this->input->get('next');
		$p_row = $this->db->where("FIND_IN_SET('".$uid."', bidder_id) AND project_id = $p_id")->get('projects');
		if($p_row){
			if($status == 'Y'){
				$this->db->where('project_id', $p_id)->update('projects', array('is_completed' => 'Y', 'status' => 'C'));
			}else{
				$this->db->where('project_id', $p_id)->update('projects', array('is_completed' => 'N'));
			}
		}
		if($return){
			redirect(base_url($return));
		}

	}

	public function project_cancel_confirm($p_id='', $status=''){
		$user = $this->session->userdata('user');
		$uid = $user[0]->user_id;
		$project_id = $p_id;
		$return = $this->input->get('next');
		$project_user = $p_user_id = getField('user_id', 'projects', 'project_id', $project_id);
		$user_wallet_id = get_user_wallet($project_user);
		
		$p_row = $this->db->where("(FIND_IN_SET('".$uid."', bidder_id) OR user_id = $uid)  AND project_id = $p_id")->get('projects')->row_array();
		if($p_row){
			if($status == 'Y'){
				$this->db->where('project_id', $p_id)->update('projects', array('is_cancelled' => 'Y', 'status' => 'CNL'));
				
				$escrow_check = $this->db->where(array('status' => 'P', 'project_id' => $p_id))->get('escrow_new')->result_array();
				if(count($escrow_check) > 0){
					$remaining_bal = 0;
					foreach($escrow_check as $k => $v){
						$remaining_bal += $v['amount'];
					}
					if($remaining_bal > 0){
						// refund the payment to employer account 
						// add fund
						$this->load->model('myfinance/transaction_model');
						
						$ref = json_encode(array('project_id' => $project_id, 'refunded_amount' => $remaining_bal));
						
						// transaction insert
						$new_txn_id = $this->transaction_model->add_transaction(PROJECT_FUND_REFUNDED,  $p_user_id);
						
						
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => ESCROW_WALLET, 'debit' => $remaining_bal, 'ref' => $ref , 'info' => 'Project fund refunded #'.$project_id));
						
						$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $remaining_bal, 'ref' => $ref , 'info' => 'Project fund refund received #'.$project_id));
						
						wallet_less_fund(ESCROW_WALLET,  $remaining_bal);
					
						wallet_add_fund($user_wallet_id, $remaining_bal);
						
						check_wallet($user_wallet_id,  $new_txn_id);
						
						check_wallet(ESCROW_WALLET,  $new_txn_id);
						
						$project_txn = array(
							'project_id' => $project_id,
							'txn_id' => $new_txn_id,
						);
						
						$this->db->insert('project_transaction', $project_txn);
						
						$this->db->where(array('status' => 'P', 'project_id' => $p_id))->update('escrow_new', array('status' => 'R'));
						
					}
				}
				
			}else{
				$this->db->where('project_id', $p_id)->update('projects', array('is_cancelled' => 'N'));
			}
		}
		if($return){
			redirect(base_url($return));
		}

	}
	
	public function getActivity($act=''){

		$res=array();
		if(!empty($act)){
			$res = $this->db->where("id IN($act)")->get('project_activity')->result_array();

		}

		return $res;

	}
	
	public function getChieldSkill(){
		$parent_id=$this->input->post('id');
		 $sub_skill=$this->auto_model->getskill($parent_id);
		/*$html .='<ul>';
		 foreach($sub_skill as $val){
			$html .= '<li><input class="jbchk" name="user_skill[]" type="checkbox" id="sub_'.$val['id'].'" onclick="return gettotal(this.id);" value="'.$val['id'].'"><label for="chk_1">'.$val['skill_name'].'</label></li>';
		 }
		 $html .='</ul>';*/
		 
		 if(count($sub_skill) > 0){
			  $ref['status']='Y'; 
				$ref['data'] =  $sub_skill;
				$ref['parent'] =  $parent_id;
		 }else{
			  $ref['status']='N'; 
				$ref['data'] =  array();
				$ref['parent'] = '';
		 }
		
		 
		echo json_encode($ref);
	}
	
	public function searchSkill(){
		$term=$this->input->post('term');
		 $sub_skill=$this->auto_model->getskillbyname($term);
		 if(count($sub_skill) > 0){
			 
			$ref['status']='Y'; 
			$ref['data'] =  $sub_skill;
			
		 }else{
			 
			$ref['status']='N'; 
			$ref['data'] =  array();
			
		 }
		
		 
		echo json_encode($ref);
	}
	
	
	public function updatePortfolioFile(){
		$user = $this->session->userdata('user');
		$uid = $user[0]->user_id;
		
		if($this->input->is_ajax_request() && $uid){
			$result=array() ;
			$config['upload_path'] = 'assets/portfolio/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = 2048;

			$this->load->library('upload', $config);
			

			if ($this->upload->do_upload()){

				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];



				if($upload_data['file_type']=="image/jpeg" || $upload_data['file_type']=="image/jpg" || $upload_data['file_type']=="image/png"){
					$configs['image_library'] = 'gd2';

					 $configs['source_image']	= 'assets/portfolio/'.$image;

					 $configs['create_thumb'] = TRUE;

					 $configs['maintain_ratio'] = TRUE;

					 $configs['width']	 = 663;

					 $configs['height']	= 276;

					 $this->load->library('image_lib', $configs);

					 $rsz=$this->image_lib->resize();

					if($rsz){
					   $image=$upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];

					   $data=array(
						   "user_id" =>$user_id,
						   "original_img" => $upload_data['file_name'],
						   "thumb_img" =>$image,
						   "add_date" =>date("Y-m-d")
					   );

					}

				}else{
					
				   $data=array(
					   "user_id" =>$user_id,
					   "original_img" => $upload_data['file_name'],
					   "thumb_img" =>$upload_data['file_name'],
					   "add_date" =>date("Y-m-d")
				   );

				}

				$result["status"]=1;
				$result["data"]= $data;
       
			}else{
				
				$result["status"]=0;
				$result["error"]["userfile"] = $this->upload->display_errors();
			}
			
			echo json_encode($result);
		}
		
	}
	
	public function save_new_portfolio(){
		if($this->input->post()){
			
			$user = $this->session->userdata('user');
			$uid = $user[0]->user_id;
		
			$json = array();
			$post = filter_data($this->input->post());
			$pid = !empty($post['pid']) ? $post['pid'] : 0;
			$error_count = 0;
			
			if($post['title'] == ''){
				$json['errors']['title'] = 'Add title for portfolio';
				$error_count++;
			}
			/* if($post['description'] == ''){
				$json['errors']['description'] = 'Add description for portfolio';
				$error_count++;
			}
			if($post['tags'] == ''){
				$json['errors']['tags'] = 'Add tags for portfolio';
				$error_count++;
			}
			if($post['url'] == ''){
				$json['errors']['url'] = 'Add url for portfolio';
				$error_count++;
			} */
			if($post['original_img'] == ''){
				$json['errors']['original_img'] = 'Add file for portfolio';
				$error_count++;
			}
			if($pid > 0){
				$user_check = getField('user_id', 'user_portfolio', 'id', $pid);
				if($user_check != $uid){
					$json['errors']['original_img'] = 'Invalid data';
					$error_count++;
				}
			}
			if($error_count == 0){
				
				if($pid > 0){
					$data = array(
						'title' => $post['title'],
						'tags' => $post['tags'],
						'url' => $post['url'],
						'description' => $post['description'],
						'original_img' => $post['original_img'],
						'thumb_img' => $post['thumb_img'],
						
					);
					
					$this->db->where('id', $pid)->update('user_portfolio', $data);
					$json['pid'] = $pid; 
					
				}else{
					
					$data = array(
						'user_id' => $uid,
						'title' => $post['title'],
						'tags' => $post['tags'],
						'url' => $post['url'],
						'description' => $post['description'],
						'original_img' => $post['original_img'],
						'thumb_img' => $post['thumb_img'],
						'add_date' => date('Y-m-d'),
						'status' => 'Y',
					
					);
					
					$json['status'] = 1;
					$this->db->insert('user_portfolio', $data);
					$json['pid'] = $this->db->insert_id();
				}
				
				
				
			}else{
				$json['status'] = 0;
			}
			
			echo json_encode($json);
			
			
			
		}
	}
	
	
	public function mycontest_entry(){

	   if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
	

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'My contests','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Contest');

		/*-----------------------Leftpanel Section start ---------------------------*/

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			

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
		$data['active_contest']=$this->dashboard_model->getMyContestsEntry($user_id);

		$lay['client_testimonial']="inc/footerclient_logo";
		
		//get_print($data);
		
		$this->layout->view('mycontest_entry',$lay,$data,'normal');
	}
	
	public function mycontest(){
		 if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
	
		$this->load->library('pagination');
		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Contest','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Contest');

		/*-----------------------Leftpanel Section start ---------------------------*/

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}
			

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
		
		$srch = $srch_string = get();
	
		$limit = !empty($srch_string['per_page']) ? $srch_string['per_page']:  0;
		$offset = 30;
		
		unset($srch_string['per_page']);
		unset($srch_string['total']);
		
		$srch['user_id'] = $user_id;
		
		$data['active_contest']=$this->dashboard_model->getMyContests($srch, $limit, $offset);
		$data['active_contest_count']=$this->dashboard_model->getMyContests($srch, $limit, $offset, FALSE);

		$lay['client_testimonial']="inc/footerclient_logo";
		
		
		/*Pagination Start*/
		
		$config['base_url'] = base_url("dashboard/mycontest?total=".$data['active_contest_count']);
		$config['base_url'] .= !empty($srch_string) ? '&'.http_build_query($srch_string) : '';
		
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['active_contest_count'];
		$config['per_page'] = $offset;
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = __('pagination_next','Next').' &gt;&gt;';
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;&lt;'.__('pagination_previous','Previous');
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>'; 
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		//get_print($data);
		
		$this->layout->view('mycontest_posted',$lay,$data,'normal');
	}
  
  
	public function bid_plan() {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?ref=dashboard/dashboard_new");
		}
		
		$data = array();
		$user = $this->session->userdata('user');
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo=base_url("assets/images/user.png");
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo=base_url("assets/uploaded/cropped_".$logo);
			}else{
				$logo=base_url("assets/uploaded/".$logo);
			}
		}
		$breadcrumb=array(
			array(
					'title'=>'Dashboard','path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Dashboard');
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		
		/*---------------[ GLOBAL VARIABES  ] -----------------------------*/
		
		$data['account_type'] = $user[0]->account_type;
		$data['user_id'] = $user[0]->user_id;
		
		/*---------------[ END OF GLOBAL VARIABES ] -----------------------------*/
		$data['bid_plan'] = get_results(array('select' => '*', 'from' => 'bid_plan', 'offset' => 'all'));
		$this->layout->view('bid_plan','',$data,'normal');  
		
    }
	
	public function buy_bid_ajax(){
		$json = array();
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		
		if(post() && $this->input->is_ajax_request() && $user_id){
			$plan_id= post('plan_id');
			$plan_row = get_row(array('select' => '*', 'from' => 'bid_plan', 'where' => array('id' => $plan_id)));
			if($plan_row){
				$bids = $plan_row['bids'];
				$price = $plan_row['price'];
				$user_wallet_id = get_user_wallet($user_id); //  user wallet id 
				$balance = get_wallet_balance($user_wallet_id); //  wallet balance
				
				if($balance < $price){ // don't have enough money in wallet 
				
					$json['errors']['fund'] = '<div class="info-error">Not enough balance in your wallet .</div>';
					
					$json['status'] = 0;
					
				}else{
					$this->load->helper('invoice');
					$this->load->model('myfinance/transaction_model');
					
					$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $user_id)));
				
					$sender_info = array(
						'name' => SITE_TITLE,
						'address' => ADMIN_ADDRESS,
					);
					$receiver_info = array(
						'name' => $user_info['fname'].' '.$user_info['lname'],
						'address' => getUserAddress($user_info['user_id']),
					);
					
					$invoice_data = array(
						'sender_id' => 0,
						'receiver_id' => $user_info['user_id'],
						'invoice_type' => 4,
						'sender_information' => json_encode($sender_info),
						'receiver_information' => json_encode($receiver_info),
						'receiver_email' => $user_info['email'],
					
					);
					
					$inv_id = create_invoice($invoice_data); // creating invoice
					
					$invoice_row_data = array(
						'invoice_id' => $inv_id,
						'description' => 'Bid purchase',
						'per_amount' =>  $price,
						'unit' => '-',
						'quantity' => 1,
					);
					
					add_invoice_row($invoice_row_data); // adding invoice row
					
					$ref = $plan_id;
				
					// transaction insert
					$new_txn_id = $this->transaction_model->add_transaction(BID_PURCHASE,  $user_id, 'Y', $inv_id);
					
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $price, 'ref' => $ref , 'info' => 'Bid Purchase'));
				
					$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $price , 'ref' => $ref, 'info' => 'Bid Purchase'));
					
					wallet_less_fund($user_wallet_id,  $price);
				
					wallet_add_fund(PROFIT_WALLET, $price);
					
					check_wallet($user_wallet_id,  $new_txn_id);
					
					check_wallet(PROFIT_WALLET,  $new_txn_id);
				
					update_user_bids($user_id, $bids);
					
					$this->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
					
					$json['status'] = 1;
					
					$json['msg'] = '<div class="info-success">Bid successfully added to your account .</div>';
					
				}
				
				echo json_encode($json);
				
			}
		}
		
	}
	public function upload_file(){		
		$user = $this->session->userdata('user');		
		$user_id = $user[0]->user_id;				
		if($_FILES){			
			$res = array();			
			$config['upload_path']          = './assets/uploaded/';			
			$config['allowed_types']        = 'gif|jpg|png|docx|doc|pdf';			
			$config['encrypt_name']        = TRUE;			
			$this->load->library('upload', $config);			
			if (!$this->upload->do_upload('file')){			
				$res['result'] = 0;				
				$res['error'] = $this->upload->display_errors();			
			}else{				
				$file_name = $this->upload->data();				
				$res['result'] = 1;				
				$res['file_name'] = $file_name['file_name'];				
				$res['org_file_name'] = $file_name['orig_name'];								
				$cmd = post('cmd');				
				if($cmd == 'auto_save_cv'){					
					$privacy = post('cv_privacy');					
					if(!isset($privacy)){						
						$privacy = 1;					
					}					
					$this->db->where('user_id', $user_id)->update('user', array('user_cv' => $file_name['file_name'], 'public_cv' => $privacy));
					
				}else if($cmd == 'save_as_document'){		
				
					$ins['data'] = array(						
						'user_id' => $user_id,						
						'org_file_name' => $res['org_file_name'],						
						'file_name' => $res['file_name'],					
					);					
					$ins['table'] = 'user_documents';					
					$doc_id = insert($ins, TRUE);					
					$res['doc_id'] = $doc_id;					
					$res['file_url'] = base_url('assets/uploaded/'.$res['file_name']); 				
				}           
			}			
			echo json_encode($res);		
		}	
	}		
	
	public function remove_doc(){		
		$user = $this->session->userdata('user');		
		$user_id = $user[0]->user_id;		
		if(post() && $this->input->is_ajax_request()){			
			$doc_id = post('id');			
			if($doc_id){				
			$this->db->where(array('user_id' => $user_id, 'id' => $doc_id))->delete('user_documents');									
		}						
			echo 1;		
		}else{	
			echo 0;		
		}	
	}
	
	public function load_ajax(){		
		$user = $this->session->userdata('user');		
		$login_user_id = $user[0]->user_id;		
		$page = get('page');		
		$data['page'] = $page;
		if($page == 'user_document'){	
			if(get('user')){
				$user_id = get('user');
			}else{
				$user_id = $login_user_id;
			}
			
			if($user_id == $login_user_id){
				$data['auth'] = TRUE;
			}else{
				$data['auth'] = FALSE;
			}
			
			$data['documents'] = $this->dashboard_model->get_user_documents($user_id);
			$this->load->view('user-document-ajax', $data);		
		}	
	}

	public function feature_profile(){
		$user = $this->session->userdata('user');		
		$login_user_id = $user[0]->user_id;	
		
		$type = get('type');
		$price = 0;
		if($type == 'monthly'){
			$price = PROFILE_FEATURED_MONTHLY;
		}else if($type == 'yearly'){
			$price = PROFILE_FEATURED_YEARLY;
		}
		
		if($price > 0){
			$payment_status = make_payment($price, $login_user_id, FEATURED_PROFILE_PAYMENT);
			
			if($payment_status['status'] == 'PAYMENT_SUCCESS'){
				
				$MONTH = 1;
				if($type == 'yearly'){
					$MONTH = 12;
				}
				
				$this->dashboard_model->make_profile_feature($login_user_id, $MONTH);
				set_flash('succ_msg', 'Congratulation! Your profile is now featured ');
				
			}else if($payment_status['status'] == 'INSUFFICIENT_BALANCE'){
				$amount_diff = $payment_status['amount_diff'];
				$amount_with_fee = get_paypal_pay_amount($amount_diff);
				$add_fund_url = base_url('myfinance/add_fund_paypal?amt='.$amount_with_fee.'&cmd=feature_profile&feature_type='.$type);
				$msg =  "You don't have sufficient balance in your wallet <a href='".$add_fund_url."'>click here </a>to add fund ";
				set_flash('error_msg', $msg);
				
			}
		}
		$refer = $this->input->server('HTTP_REFERER');
		if($refer){
			redirect($refer);
		}
		
		redirect(base_url('dashboard/setting'));
		
		
	}
	
	public function support(){
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
			return;
		}
		
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post()){
			
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('category', 'category', 'required');
			$this->form_validation->set_rules('support_message', 'message', 'required');
			
			if($this->form_validation->run()){
				$post = post();
				$post['date'] = date('Y-m-d');
				$post['user_id'] = $user_id;
				$insert['data'] = $post;
				$insert['table'] = 'user_support';
				insert($insert);
			}
		}
		
		$breadcrumb=array(
					array(
						'title'=>'Dashboard','path'=>'Support'
					)

				);

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'support');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo=='')

		{

			$logo="images/user.png";

		}

		else

		{

			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo="uploaded/cropped_".$logo;
			}else{
				$logo="uploaded/".$logo;
			}

		}

		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='support';

		$head['ad_page']='support';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

		$this->autoload_model->getsitemetasetting("meta","pagename","Support");

		$data['list']=$this->dashboard_model->get_support_message($user[0]->user_id);
		
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$this->layout->view('support',$lay,$data,'normal');

	}
	
	
	public function my_service() {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/?refer=dashboard/my_service");
		}
		
		$data = array();
		$user = $this->session->userdata('user');
		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo=base_url("assets/images/user.png");
		}else{
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo=base_url("assets/uploaded/cropped_".$logo);
			}else{
				$logo=base_url("assets/uploaded/".$logo);
			}
		}
		$breadcrumb=array(
			array(
					'title'=>'My Service','path'=>''
			)
		);
		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My Service');
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		
		/*---------------[ GLOBAL VARIABES  ] -----------------------------*/
		
		$data['account_type'] = $user[0]->account_type;
		$data['user_id'] = $user[0]->user_id;
		
		/*---------------[ END OF GLOBAL VARIABES ] -----------------------------*/
		
		$data['user_skill']=$this->dashboard_model->getUserSkills($user[0]->user_id);
		
		$this->layout->view('my_service','',$data,'normal');  
		
    }
	
	public function save_user_document(){
		$json = array();
		$json['status'] = 0;
		$user=$this->session->userdata('user');
		$user_id = $user[0]->user_id;
		if(post()){
			
			$doc_type = post('document_type');
			$uploaded_files = post('uploaded_files');
			if(count($uploaded_files) > 0){
				foreach($uploaded_files as $k => $v){
					$file_arr = json_decode($v, true);
					$ins['data'] = array(						
						'user_id' => $user_id,						
						'org_file_name' => $file_arr['org_file_name'],						
						'file_name' => $file_arr['file_name'],					
						'document_type' => $doc_type,					
					);	
					$ins['table'] = 'user_documents';
					insert($ins, TRUE); 	
				}
			}
			
			$json['status'] = 1;
		
		}
		
		echo json_encode($json);
		
	}
	
	public function read_notification(){
		$noti_id = get('noti_id');
		$next = get('next');
		$this->db->where('id', $noti_id)->update('notification', array('read_status' => 'Y'));
		redirect(base_url($next));
	}
	
}

