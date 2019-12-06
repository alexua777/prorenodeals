<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Clientdetails extends MX_Controller {



    /**

     * Description: this used for check the user is exsts or not if exists then it redirect to this site

     * Paremete: username and password 

     */

    public function __construct() {

        $this->load->model('clientdetails_model');

		$this->load->model('dashboard/dashboard_model');

		$this->load->model('references/references_model');

		$this->load->model('findtalents/findtalents_model');

		$this->load->model('notification/notification_model');

		$idiom=$this->session->userdata('lang');

		$this->lang->load('clientdetails',$idiom);

        parent::__construct();

    }



    public function index() {

        

    }



public function showdetails(){ 

		

			

		 

		   $user_id=  $this->uri->segment(3);

		

		   if(!$this->session->userdata('user')){

			   

			   $verify_token = $this->input->get('access_token');

			   $access_token_key = 'ORIGINATE_SOFT_FLANCE_@123--'.date('Y-m-d');

			    $access_token = md5($access_token_key);

				

				if( $access_token ==  $verify_token){

					

				}else{

					redirect(VPATH."login/?refer=clientdetails/showdetails/".$user_id);

				}

				

			}

           

         // $user_id=  3;

          //  $user=$this->session->userdata('user');

			$status = $this->auto_model->getFeild('status','user','user_id',$user_id);

			

			if($status != 'Y' && (!$verify_token || ($access_token !=  $verify_token))){

				show_404();

			}

			

            $data['user_id']=$user_id;



            $data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);

			

            $data['account_type']=$this->auto_model->getFeild('account_type','user','user_id',$user_id);



            $data['fname']=$this->auto_model->getFeild('fname','user','user_id',$user_id);



            $data['lname']=$this->auto_model->getFeild('lname','user','user_id',$user_id);



            $data['rate']=$this->auto_model->getFeild('hourly_rate','user','user_id',$user_id);



            $data['overview']=$this->auto_model->getFeild('overview','user','user_id',$user_id);



            $data['work_experience']=$this->auto_model->getFeild('work_experience','user','user_id',$user_id);



            $data['ldate']=$this->auto_model->getFeild('ldate','user','user_id',$user_id);

            

            $data['user_skill']=$this->clientdetails_model->getUserSkills($user_id);

			

            $data['country']=$this->auto_model->getFeild('country','user','user_id',$user_id);

            $data['flag']=$this->auto_model->getFeild('Code2','country','Code',$data['country']);

            $data['city']=$this->auto_model->getFeild('city','user','user_id',$user_id);

            

            $data['verify']=$this->auto_model->getFeild('verify','user','user_id',$user_id);



            $data['facebook_link']=$this->auto_model->getFeild('facebook_link','user','user_id',$user_id);



            $data['twitter_link']=$this->auto_model->getFeild('twitter_link','user','user_id',$user_id);



            $data['gplus_link']=$this->auto_model->getFeild('gplus_link','user','user_id',$user_id);



            $data['linkedin_link']=$this->auto_model->getFeild('linkedin_link','user','user_id',$user_id);

			

			$data['education']=$this->auto_model->getFeild('education','user','user_id',$user_id);

			 

			$data['certification']=$this->auto_model->getFeild('certification','user','user_id',$user_id);

			

			$data['rating']=$this->dashboard_model->getrating_new($user_id);

			

			$data['user_reference']=$this->clientdetails_model->getReferences($user_id);

			

			$data['simuser']=$this->clientdetails_model->getSimilarUser($user_id);

			

			//$data['total_earning'] = $this->clientdetails_model->get_total_earning($user_id);

			

			$data['total_row']=$this->references_model->countReference($user_id);

            $breadcrumb=array(

                array(

                        'title'=>'Talent Details','path'=>''

                )

            );

			$txt=$data['fname']." ".$data['lname']."'s Profile";



            $data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,$txt);

			

			// ------------------ Notification Section -----------------------------------//

			/*$notification_content = 'You are invited for the project '.$p_title;

			$link = 'jobdetails/details/'.$post['project_id'];

			$this->notification_model->log($user_id,  $v, $notification_content, $link);*/

			//--------------------------End Of Notification Section ---------------------//

			



            ///////////////////////////Leftpanel Section start//////////////////



            $data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user_id);



		if($logo=='')



		{



			$logo="images/user.png";



		}



		else



		{



			$logo="uploaded/".$logo;



		}



		//$data['leftpanel']=$this->autoload_model->leftpanel($logo);



            ///////////////////////////Leftpanel Section end//////////////////

			

			$meta_all='<title>'.$txt.'</title><meta name="description" content="'.$txt.'" /><meta name="keywords" content="'.$txt.'" /><meta name="application-name" content="'.$txt.'" /><meta property="og:title" content="'.$txt.'" /><meta property="og:image" content="'.VPATH.'assets/images/job_detailslogo.png'.'" /><meta property="og:description" content="'.$txt.'" /><meta property="og:url" content="'.VPATH.'"clientdetails/showdetails/'.$user_id.'" /><meta property="og:site_name" content="'.VPATH.'" /><meta name="twitter:card" content="'.$txt.'">

<meta name="twitter:url" content="'.VPATH.'"clientdetails/showdetails/'.$user_id.'">

<meta name="twitter:title" content="'.$txt.'">

<meta name="twitter:description" content="'.$txt.'"><meta name="twitter:image" content="'.VPATH.'assets/images/job_detailslogo.png'.'">';

        

        $data['meta_tag']=$meta_all;



            $head['current_page']='talentdetails';



            $load_extra=array();



            $data['load_css_js']=$this->autoload_model->load_css_js($load_extra);



            $this->layout->set_assest($head);



            







            $this->autoload_model->getsitemetasetting("meta","pagename","Clientdetails");



            $lay['client_testimonial']="inc/footerclient_logo";

			

	    	$data['user_portfolio']=$this->dashboard_model->getportfolio($user_id); 

			

			//$data['review']=$this->dashboard_model->getmyreview($user_id);

			$data['review']=$this->dashboard_model->getmyreview_new($user_id);

			

			$data['educations'] = $this->db->where(array('user_id' =>  $user_id))->get('user_education')->result_array();

			

			$data['experiences'] = $this->db->where(array('user_id' => $user_id))->get('user_experience')->result_array();

			

			$data['certificates'] = $this->db->where(array('user_id' =>  $data['user_id']))->get('user_certificate')->result_array();

			

			$this->load->library('pagination');

			$get = get();

			$offset = 5;

			$open_limit = !empty($get['limit_open']) ? $get['limit_open'] : 0;

			$completed_limit = !empty($get['limit_completed']) ? $get['limit_completed'] : 0;

			

			/*Completed Pagination Start*/

			$config['base_url'] = base_url('clientdetails/project_ajax?type=C&user_id='.$data['user_id']);

			

			$config['total_rows'] = $this->db->where(array('status' => 'C', 'user_id' => $data['user_id']))->count_all_results('projects');

			

			$config['per_page'] = $offset;

			$config['page_query_string'] = TRUE;

			$config['reuse_query_string'] = TRUE;

			$config['query_string_segment'] = 'limit';

			

			$config['full_tag_open'] = "<ul class='pagination ajax_pagination' data-target='#completed_project_wrapper'>";

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

			$config['next_link'] = "<i class='icon-feather-chevron-right'></i>";

			$config['next_tag_open'] = "<li>";

			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = "<i class='icon-feather-chevron-left'></i>";

			$config['prev_tag_open'] = '<li>';

			$config['prev_tag_close'] = '</li>'; 

			

			$this->pagination->initialize($config);

			$data['links1'] = $this->pagination->create_links();

			/*Pagination End*/

			

			//$this->pagination->clear();

			

			/*Open project Pagination Start*/

			$config = array();

			$config['base_url'] = base_url('clientdetails/project_ajax?type=O&user_id='.$data['user_id']);

			

			$config['total_rows'] = $this->db->where(array('status' => 'O', 'user_id' => $data['user_id']))->count_all_results('projects');

			

			$config['per_page'] = $offset;

			$config['page_query_string'] = TRUE;

			$config['reuse_query_string'] = TRUE;

			$config['query_string_segment'] = 'limit';

			

			$config['full_tag_open'] = "<ul class='pagination ajax_pagination' data-target='#open_project_wrapper'>";

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

			$config['next_link'] = "<i class='icon-feather-chevron-right'></i>";

			$config['next_tag_open'] = "<li>";

			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = "<i class='icon-feather-chevron-left'></i>";

			$config['prev_tag_open'] = '<li>';

			$config['prev_tag_close'] = '</li>'; 

			

			$this->pagination->initialize($config);

			$data['links2'] = $this->pagination->create_links(); 

			/*Pagination End*/

			

			

			$data['completed_projects'] = $this->db->where(array('status' => 'C', 'user_id' => $data['user_id']))->limit($offset, $completed_limit)->order_by('id', 'desc')->get('projects')->result_array();

			

			$data['open_projects'] = $this->db->where(array('status' => 'O', 'user_id' => $data['user_id']))->limit($offset, $open_limit)->order_by('id', 'desc')->get('projects')->result_array();

			

			if($data['account_type'] == 'E'){

				$this->layout->view('talent_details_employer',$lay,$data,'normal');

			}else{

				$this->layout->view('talent_details',$lay,$data,'normal');

			}

			

            

}

	

	public function project_ajax(){

		$data = array();

		$data['user_id'] = get('user_id');

		

		$type = get('type');

		$target_wrapper = '';

		if($type == 'O'){

			$target_wrapper = 'open_project_wrapper';

		}

		if($type == 'C'){

			$target_wrapper = 'completed_project_wrapper';

		}

		

		$this->load->library('pagination');

		$get = get();

		$offset = 5;

		$limit = !empty($get['limit']) ? $get['limit'] : 0;

		

		$config['base_url'] = base_url('clientdetails/project_ajax?type='. $type.'&user_id='.$data['user_id']);

		

		$config['total_rows'] = $this->db->where(array('status' => $type, 'user_id' => $data['user_id']))->count_all_results('projects');

		

		$config['per_page'] = $offset;

		$config['page_query_string'] = TRUE;

		$config['query_string_segment'] = 'limit';

		

		$config['full_tag_open'] = "<ul class='pagination ajax_pagination' data-target='#".$target_wrapper."'>";

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

		$config['next_link'] = "<i class='icon-feather-chevron-right'></i>";

		$config['next_tag_open'] = "<li>";

		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = "<i class='icon-feather-chevron-left'></i>";

		$config['prev_tag_open'] = '<li>';

		$config['prev_tag_close'] = '</li>'; 

		

		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();

		

		$data['projects'] = $this->db->where(array('status' => $type, 'user_id' => $data['user_id']))->limit($offset, $limit)->order_by('id', 'desc')->get('projects')->result_array();

		

		$data['type'] = $type;

		

		$this->load->view('project_list_ajax', $data);

	}



	public function getProject()

	{

		$user_id=$this->input->post('user_id');

		$project=$this->findtalents_model->getprojects($user_id);		

		if(count($project)>0)

		{

			$i=0;

?>

<select name="project_id" class="prjct form-control" >

<?php

			foreach($project as $key=>$val)

			{

				$i++;

		?>

   <option value="<?php echo $val['id'];?>" <?php if($i==1){echo "checked";}?>><?php echo ucwords($val['title']);?></option>

        <?php

			}

			?>

       </select>     

      <?php

		}

		else

		{

			echo 0;	

		}	

	}

	

	public function sendMessage($freelancer_id,$projects_id,$message)

	{

		$user=$this->session->userdata('user');

		$user_id=$user[0]->user_id;

		$pid = $this->auto_model->getFeild('project_id','projects','id',$projects_id);

		$post_data["message"] =  urldecode($message);		

		$post_data["project_id"] =  $pid;

		$post_data["recipient_id"] = $freelancer_id;

		$post_data["sender_id"] = $user_id;

		$post_data["add_date"] = date('Y-m-d H:i:s');

		

		$insert=  $this->clientdetails_model->insertMessage($post_data);

		if($insert)

		{

			$this->session->set_flashdata('invite_success', __('clientdetails_sidebar_your_message_send_successfully','Your Message Send Successfuly.'));

			redirect(VPATH."clientdetails/showdetails/".$freelancer_id."/");

		}

	}

	public function sendMessagenew()

	{	$freelancer_id=$this->input->post('freelancer_id');

		$projects_id=$this->input->post('projects_id');

		$message=$this->input->post('message');

		$user=$this->session->userdata('user');

		$user_id=$user[0]->user_id;

		$pid = $this->auto_model->getFeild('project_id','projects','id',$projects_id);

		$post_data["message"] =  urldecode($message);		

		$post_data["project_id"] =  $pid;

		$post_data["recipient_id"] = $freelancer_id;

		$post_data["sender_id"] = $user_id;

		$post_data["add_date"] = date('Y-m-d H:i:s');

		

		$insert=  $this->clientdetails_model->insertMessage($post_data);

		

		if($insert){

			$dir = "user_message/";

			if(!is_dir($dir)){

				mkdir($dir);

			}

			$count = file_get_contents($dir."user_".$post_data["recipient_id"].".newmsg");

			if($count > 0){

				$count += 1;

			}else{

				$count = 1;

			}

			file_put_contents($dir."user_".$post_data["recipient_id"].".newmsg" , $count);

			

			$this->session->set_flashdata('invite_success', __('clientdetails_sidebar_your_message_send_successfully','Your Message Send Successfuly.'));

			//redirect(VPATH."clientdetails/showdetails/".$freelancer_id."/");

			echo 1;

		}else{

			echo 0;

		}

	}

	

	public function invite_user(){

		if($this->input->post()){

			$res = array();

			$user=$this->session->userdata('user');

			$user_id =$user[0]->user_id;

			

			$post = $this->input->post();

			

			$post['date'] = date('Y-m-d');

			unset($post['condition']);

			if($post['project_type'] == 'F'){

				$post['invitation_amount'] = $post['amount_fixed'];

			}else{

				$post['invitation_amount'] = $post['amount_hourly'];

			}

			unset($post['amount_fixed']);

			unset($post['amount_hourly']);

			

			$ins = $this->db->insert('new_inviteproject', $post);

			$project_name = getField('title','projects','project_id',$post['project_id']);

			$notification_content = 'You are invited for the project '.$project_name;

			//$notification_content = 'You are invited for the project '.$post['project_id'];

			//$link = 'jobdetails/details/'.$post['project_id'];

			$link = 'dashboard/myproject_professional';

			$this->notification_model->log($user_id,  $post['freelancer_id'], $notification_content, $link);
			
			$p_id_public = $post['project_id'];
			
			$username = getField('fname','user','user_id',$user_id);
			$username .= ' ';
			$username .= getField('lname','user','user_id',$user_id);
			
			$freelancer_fname = getField('fname', 'user', 'user_id', $post['freelancer_id']);
			$f_email = getField('email','user','user_id',$post['freelancer_id']);
			$mail_param = array(
				'name' => $freelancer_fname,
				'username' => $username,
				'project_name' => $project_name,
				'project_url' => base_url('jobdetails/details/'.$p_id_public),
				'copy_url' => base_url('jobdetails/details/'.$p_id_public),
				'message' => $post['message'],
			);
			
			send_layout_mail('invite_freelancer', $mail_param, $f_email);
			

			$res['status'] = 1;

			echo json_encode($res);

		}

	}



}

