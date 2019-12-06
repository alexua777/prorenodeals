<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobfeed extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('jobfeed_model');
		$this->load->model('jobdetails/jobdetails_model');
		$this->load->library('pagination');
	
        parent::__construct();
    }

    public function index($limit_from='') {
    	if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");
		}
		else
		{
			
			/* $this->auto_model->updateproject(); */
			$user=$this->session->userdata('user');
			
			$data['user_id']=$user[0]->user_id;
			if($this->session->userdata('user')){
				
	  
			///////////////////////////Right Section start//////////////////

				$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);



				if($logo==''){

					$logo="images/user.png";

				}

				else{

					$logo="uploaded/".$logo;

				}

				$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);

				$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
			}
			$data['logo']= $logo;

			$breadcrumb=array(
						array(
								'title'=>'All Jobs','path'=>''
						)
					);
			
			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Jobs');
			$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
			$data['available_hr'] = $this->autoload_model->getFeild('available_hr','user','user_id',$data['user_id']);
			$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
			$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
			$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
			
			$data['srch_param'] = get();
			$data['offset'] = 10;
			$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
			$filter = array();
			$filter['skills'] = $this->jobfeed_model->get_user_skill_id($data['user_id']);
			$data['projects']=$this->jobfeed_model->get_suggested_project($filter, $data['limit'] , $data['offset']);
			$data['projects_count']=$this->jobfeed_model->get_suggested_project($filter, $data['limit'] , $data['offset'] , FALSE);
			
			
			
			/*Pagination Start*/

			$config['base_url'] = base_url('jobfeed/index?total=10');

			$config['page_query_string'] = TRUE;

			$config['total_rows'] = $data['projects_count'];

			$config['per_page'] = $data['offset'];

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
			
			

			$head['current_page']='jobfeed';
			
			$head['ad_page']='jobfeed';

			$load_extra=array();

			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

			$this->layout->set_assest($head);



			$this->autoload_model->getsitemetasetting("meta","pagename","Jobfeed");

			$lay['client_testimonial']="inc/footerclient_logo";
			
			$this->layout->view('list',$lay,$data,'normal');
			

		}
    }
	
	

    
    
}
