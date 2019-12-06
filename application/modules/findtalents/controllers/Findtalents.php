<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findtalents extends MX_Controller {
    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('findtalents_model');
        $this->load->library('pagination');
		$this->load->model('dashboard/dashboard_model');
		$idiom = $this->session->userdata('lang');
		$this->lang->load('findtalents',$idiom);
		$this->load->model('notification/notification_model');
        parent::__construct();
    }

    public function index() {
		$data['srch_url'] = uri_string();
		$data['srch_param'] = $data['srch_string'] = $this->input->get();
		
		$data['offset'] = 6;
		$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
		$data['srch_string'] = !empty($data['srch_string']) ? $data['srch_string'] : array();
		
		unset($data['srch_string']['per_page']);
		unset($data['srch_string']['total']);
		
		if(!empty($data['srch_param']['skills']) && is_array($data['srch_param']['skills'])){
			$data['selected_skills'] = $this->db->where_in('id', $data['srch_param']['skills'])->get('skills')->result_array();
		}else if(!empty($data['srch_param']['cat_id'])){
			$data['selected_skills'] = $this->db->where('cat_id', $data['srch_param']['cat_id'])->get('skills')->result_array();
		}else{
			$data['selected_skills'] = array();
			
		}
		
		
		$user=$this->session->userdata('user');
	
		$breadcrumb=array(
                    array(
                            'title'=>__('find_talent','Find Talent'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('find_talent','Find Talent'));
		
		$data['freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset']);
		$data['total_freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset'] , FALSE);
		
		$q1 = array('select' => '*' , 'from' => 'skills' , 'where' => array('status' => 'Y' ,'parent_id' => 0) , 'offset' => 500);
		$data['parent_skills'] = get_results($q1);
		$data['all_plans'] = get_results(array('select' => 'id,name' , 'from' => 'membership_plan' , 'where' => array('status' => 'Y')));
		$data['child_skills'] = array();
		$q3 = array('select' => '*' , 'from' => 'country' , 'offset' => 1000);
		$data['countries'] =  get_results($q3);
		 $data['srch_param']['ccode'] = 'CAN';
		if(!empty($data['srch_param']['ccode']) AND $data['srch_param']['ccode'] != 'All'){
			$data['cities'] = get_results(array('select' => 'ID,Name' , 'from' => 'city', 'where' => array('CountryCode' => $data['srch_param']['ccode']), 'offset' => 'all', 'order_by' => array('Name', 'ASC')));
		}
		
		/*Pagination Start*/
		$config['base_url'] = base_url().$data['srch_url'].'?total=10';
		$config['base_url'] .= !empty($data['srch_string']) ? '&'.http_build_query($data['srch_string']) : '';
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['total_freelancers'];
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
		$config['last_link'] = __('pagination_last','Last');
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
		
		
		$head['current_page']='findtalent';
		$head['ad_page']='findtalent';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Findtalents");
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('list',$lay,$data,'normal');

    }
	
	public function browse($skill='',$skill_id='',$sub_skill='',$sub_skill_id=''){
		$data['srch_url'] = uri_string();
		$data['srch_param'] = $data['srch_string'] = $this->input->get();
		$data['srch_param']['skill'] = $skill;
		$data['srch_param']['skill_id'] = $skill_id;
		$data['srch_param']['sub_skill'] = $sub_skill;
		$data['srch_param']['sub_skill_id'] = $sub_skill_id;
		
		
		$data['offset'] = 6;
		$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
		$data['srch_string'] = !empty($data['srch_string']) ? $data['srch_string'] : array();
		
		unset($data['srch_string']['per_page']);
		unset($data['srch_string']['total']);
		
		$breadcrumb=array(
                    array(
                            'title'=>__('find_talent','Find Talent'),'path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,__('find_talent','Find Talent'));
		
		$user=$this->session->userdata('user');
		if($user){ 
			$userid=$user[0]->user_id;
			$data['previousfreelancer']=$this->findtalents_model->getpreviousfreelancer($userid);
			 
		}else{
			   $userid=0;
			   $data['previousfreelancer']=array('0');
		}
		
		$data['freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset']);
		$data['total_freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset'] , FALSE);
		
		$q1 = array('select' => '*' , 'from' => 'skills' , 'where' => array('status' => 'Y' ,'parent_id' => 0) , 'offset' => 'all');
		$data['parent_skills'] = get_results($q1);
		$data['all_plans'] = get_results(array('select' => 'id,name' , 'from' => 'membership_plan' , 'where' => array('status' => 'Y')));
		$data['child_skills'] = array();
		if(!empty($skill_id)){
			$q2 = array('select' => '*' , 'from' => 'skills' , 'where' => array('status' => 'Y' ,'parent_id' => $skill_id) , 'offset' => 'all');
			$data['child_skills'] =  get_results($q2);
		}
		$q3 = array('select' => '*' , 'from' => 'country' , 'offset' => 1000);
		$data['countries'] =  get_results($q3);
		$data['cities'] = array();
		if(!empty($data['srch_param']['ccode']) AND $data['srch_param']['ccode'] != 'All'){
			$data['cities'] = get_results(array('select' => 'ID,Name' , 'from' => 'city', 'where' => array('CountryCode' => $data['srch_param']['ccode'])));
		}
		
		/*Pagination Start*/
		$config['base_url'] = base_url().$data['srch_url'].'?total=10';
		$config['base_url'] .= !empty($data['srch_string']) ? '&'.http_build_query($data['srch_string']) : '';
		$config['page_query_string'] = TRUE;
		$config['total_rows'] = $data['total_freelancers'];
		$config['per_page'] = $data['offset'];
		
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		/*Pagination End*/
		
		
		$head['current_page']='findtalent';
		$head['ad_page']='findtalent';
		$load_extra=array();
		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		$this->layout->set_assest($head);
		$this->autoload_model->getsitemetasetting("meta","pagename","Findtalents");
		$lay['client_testimonial']="inc/footerclient_logo";
		$this->layout->view('list',$lay,$data,'normal');
	}
	
	public function ajaxsearch(){
		$data['srch_url'] = uri_string();
		$data['srch_param'] = $data['srch_string'] = $this->input->get();
		
		$data['offset'] = 1000;
		//$data['limit'] = !empty($data['srch_param']['per_page']) ? $data['srch_param']['per_page'] : 0;
		$data['limit'] =0;
		$data['srch_string'] = !empty($data['srch_string']) ? $data['srch_string'] : array();
		
		$user=$this->session->userdata('user');
		if($user){ 
			$userid=$user[0]->user_id;
			$data['previousfreelancer']=$this->findtalents_model->getpreviousfreelancer($userid);
			 
		}else{
			   $userid=0;
			   $data['previousfreelancer']=array('0');
		}
		
		$data['freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset']);
		$data['total_freelancers'] = $this->findtalents_model->list_freelancer($data['srch_param'] , $data['limit'] , $data['offset'] , FALSE);
		
		$this->layout->view('ajax_talentlist', '', $data, 'ajax', 'N');
	}
	
	public function myfreelancer($limit_from='')
	{
		
		
		$user=$this->session->userdata('user');

		 $user_id=$user[0]->user_id;
		if($user){ 

			$data['previousfreelancer']=$this->findtalents_model->getpreviousfreelancer($user_id);
			 
		}else{

			   $data['previousfreelancer']=array('0');
			 
		}
        
		$breadcrumb=array(
                    array(
                            'title'=>'All Talents','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'All Talents');

		///////////////////////////Leftpanel Section start//////////////////

		$data['parent_skill']=$this->auto_model->getskill("0");
		
		$data['all_plans']=$this->findtalents_model->getplans();
		
		$data['address']=$this->autoload_model->getFeild('address','setting','id',1);
		$data['contact_no']=$this->autoload_model->getFeild('contact_no','setting','id',1);
		$data['telephone']=$this->autoload_model->getFeild('telephone','setting','id',1);
		$data['email']=$this->autoload_model->getFeild('support_mail','setting','id',1);
		//$data['leftpanel']=$this->autoload_model->job_leftpanel($parent_cat);

		///////////////////////////Leftpanel Section end//////////////////
		$this->load->library('pagination');
		$config['base_url'] = VPATH.'findtalents/myfreelancer/';
		//$total_rows=$this->db->get_where('user',array('status'=>'Y'))->num_rows();
        $total_rows=$this->findtalents_model->countmytalents($user_id);       
                $config['total_rows'] =$total_rows;
		$config['per_page'] = 5; 
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
		
                $data['total_rows']=$total_rows;
                
                $data['countries']= $this->autoload_model->getCountry();
                
		$data['talents']=$this->findtalents_model->getmytalents($user_id,$config['per_page'],$start);

		$head['current_page']='findtalent';
		$head['ad_page']='findtalent';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);



		$this->autoload_model->getsitemetasetting("meta","pagename","Findtalents");

		$lay['client_testimonial']="inc/footerclient_logo";

		$this->layout->view('mylist',$lay,$data,'normal');

    
	}
   
    public function getProject()
	{
		$user_id=$this->input->post('user_id');
		$project=$this->findtalents_model->getprojects($user_id);		
		if(count($project)>0)
		{
			$i=0;
?>
<select name="project_id" class="prjct">
<?php
			foreach($project as $key=>$val)
			{
				$i++;
		?>
   <!--<input type="radio" <?php if($i==1){echo "checked";}?> name="project_id" class="prjct" value="<?php echo $val['id'];?>"/>-->
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

    public function givebonus(){
		if(!$this->session->userdata('user'))
		{
			redirect(VPATH."login/");	
		}
		$bonus_freelancer_id=trim($this->input->post('bonus_freelancer_id'));
		$bonus_amount=trim($this->input->post('bonus_amount'));
		$bonus_reason=trim($this->input->post('bonus_reason'));
		
		$user=$this->session->userdata('user');
		$user_id=$user[0]->user_id;
		$upd=$this->findtalents_model->givebonustouser($bonus_freelancer_id,$user_id,$bonus_amount,$bonus_reason);	
		if($upd)
		{
			if($upd['status'] == 'OK'){
				
				$bidder_id=$bonus_freelancer_id;
				$bidder_mail=$this->auto_model->getFeild('email','user','user_id',$bidder_id);
				$bidder_name=$this->auto_model->getFeild('fname','user','user_id',$bidder_id)." ".$this->auto_model->getFeild('lname','user','user_id',$bidder_id);
				
				$employer_id=$user_id;
				$employer_name=$this->auto_model->getFeild('fname','user','user_id',$employer_id)." ".$this->auto_model->getFeild('lname','user','user_id',$employer_id);
			
				/*  $data_notification=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$employer_id,
				   "notification" =>"You have successfully give bonus (".CURRENCY."".$bonus_amount.") to <a href='".VPATH."clientdetails/showdetails/".$bidder_id."/".$this->auto_model->getcleanurl($bidder_name)."/'>".$bidder_name."</a>",
				   "add_date"  => date("Y-m-d")
				 );
				 $data_notic=array( 
				   "from_id" =>$employer_id,
				   "to_id" =>$bidder_id,
				   "notification" =>"<a href='".VPATH."clientdetails/showdetails/".$employer_id."/".$this->auto_model->getcleanurl($employer_name)."/'>".$employer_name."</a> send you a bonus (".CURRENCY."".$bonus_amount.")",
				   "add_date"  => date("Y-m-d")
				 );
				 
				$this->dashboard_model->insert_notification($data_notification);
				
				$this->dashboard_model->insert_notification($data_notic);
				
				*/
				$notification = "You have successfully give bonus (".CURRENCY."".$bonus_amount.") to ".$bidder_name; 
				$notification = $employer_name . ' send you a bonus ('.CURRENCY.$bonus_amount.')';
				$link = 'myfinance/transaction';
				$this->notification_model->log($employer_id, $employer_id, $notification, $link);
				$this->notification_model->log($employer_id, $bidder_id, $notification2, $link);
		 
			}
			
		}
		ob_start();
		ob_clean();
		echo $upd;
		
		
	}
    
}
