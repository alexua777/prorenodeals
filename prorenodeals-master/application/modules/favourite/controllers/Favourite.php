<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favourite extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('favourite_model');
        parent::__construct();
    }

    public function index($limit_from='') {
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}else{
		
			$user=$this->session->userdata('user');
			$data['user_id']=$user[0]->user_id;
			$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

			if($logo==''){

				$logo="images/user.png";

			}

			else{

				$logo="uploaded/".$logo;

			}

			$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

			$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		
			$data['logo']= $logo;

			///////////////////////////Right Section end//////////////////
			
			
			
			$breadcrumb=array(
						array(
								'title'=>'Favourite','path'=>''
						)
					);
			
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Favourite');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['available_hr'] = $this->autoload_model->getFeild('available_hr','user','user_id',$data['user_id']);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			///////////////////////////Leftpanel Section start//////////////////
			$head['current_page']='jobfeed';
			
			$head['ad_page']='jobfeed';

			$load_extra=array();

			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

			$this->layout->set_assest($head);

			$data['fav_projects'] = $this->favourite_model->getFavouriteProject($data['user_id']);

			$this->autoload_model->getsitemetasetting("meta","pagename","Jobfeed");

			$lay['client_testimonial']="inc/footerclient_logo";

			$this->layout->view('list',$lay,$data,'normal');

		}
    }
	
	public function fav_list(){
		 if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
	

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Bookmarks','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Bookmarks');

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

		
		/* Attributes data */
		
		$data['freelancer'] = $this->favourite_model->getFavouriteFreelancer($user_id);
		$data['project'] = $this->favourite_model->getFavouriteProject($user_id);
	
		/* get_print($data);  */
		$this->layout->view('favourite','',$data,'normal');
	}
	
	
	public function add_fav(){
		$user=$this->session->userdata('user');
        $user_id=$user[0]->user_id;
		$json['status'] = 0;
		
		if($this->input->is_ajax_request() && post() && $user_id){
			$object_id = post('object_id');
			$type = post('type');
			
			$insert = array(
				'object_id' => $object_id,
				'type' => $type,
				'user_id' => $user_id,
			);
			$count = $this->db->where($insert)->count_all_results('favorite');
			if($count == 0){
				$insert['date'] = date('Y-m-d');
				$this->db->insert('favorite', $insert);
			}
			$json['status'] = 1;
			
		}
		
		echo json_encode($json);
		
	}
	
    public function remove_fav(){
		$user=$this->session->userdata('user');
        $user_id=$user[0]->user_id;
		$json['status'] = 0;
		
		if($this->input->is_ajax_request() && post() && $user_id){
			$object_id = post('object_id');
			$type = post('type');
			
			$check = array(
				'object_id' => $object_id,
				'type' => $type,
				'user_id' => $user_id,
			);
			$count = $this->db->where($check)->delete('favorite');
			
			$json['status'] = 1;
			
		}
		
		echo json_encode($json);
	}
	
	public function favourite_contractors(){
		 if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
	

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Bookmarks','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Favourite');

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

		
		/* Attributes data */
		
		$data['hired_contractors'] = $this->favourite_model->get_hired_users($user_id);
		$data['invited_contractors'] = $this->favourite_model->get_invited_users($user_id);
		$data['freelancer'] = $this->favourite_model->getFavouriteFreelancer($user_id);
	
		/* get_print($data);  */
		$this->layout->view('favourite_contractors','',$data,'normal');
	}
	
	
    
}
