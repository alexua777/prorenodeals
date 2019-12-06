<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class References extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('references_model');
        parent::__construct();
    }

    public function index() {
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
                            'title'=>'My references','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'My References');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='refernces';
		
		$head['ad_page']='referrence_list';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

        $data['username']=$this->auto_model->getFeild('username','user','user_id',$user[0]->user_id);

	
		$this->autoload_model->getsitemetasetting("meta","pagename","References");

		$lay['client_testimonial']="inc/footerclient_logo";
		$data['user_reference']=$this->references_model->allReferences($user[0]->user_id);
		$data['total_row']=$this->references_model->countReference($user[0]->user_id);
		
		
			$this->layout->view('list',$lay,$data,'normal');
	

	}        
    }
	public function addreferences() {
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
                            'title'=>'add references','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Add Reference');

		///////////////////////////Leftpanel Section start//////////////////

		$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);

		if($logo==''){
			$logo="images/user.png";
		}
		else{
			$logo="uploaded/".$logo;
		}
		
		$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
		$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);

		///////////////////////////Leftpanel Section end//////////////////

		$head['current_page']='refernces';
		
		$head['ad_page']='add_refereence';

		$load_extra=array();

		$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);

		$this->layout->set_assest($head);

        $data['username']=$this->auto_model->getFeild('username','user','user_id',$user[0]->user_id);
		
		$user_fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);
		$user_lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);
		
		$this->autoload_model->getsitemetasetting("meta","pagename","References");

		$lay['client_testimonial']="inc/footerclient_logo";
		
		if($this->input->post())
		{
			
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
			$this->form_validation->set_rules('phone_no', 'phone no', 'required|numeric');
			
            if ($this->form_validation->run() == FALSE) {              
                $this->layout->view('references',$lay,$data,'normal');
            } else {
     
			   	$post_data['user_id'] = $user[0]->user_id;
				$post_data['name'] = $this->input->post('name');
				$post_data['company'] = $this->input->post('company');
				//$post_data['contact_name'] = $this->input->post('contact_name');
				$post_data['email'] = $this->input->post('email');
				$post_data['phone_no'] = $this->input->post('phone_no');
				$post_data['add_date'] =date('Y-m-d h:i:s');
                $post_data['status'] = 'Y';
				$post_data['rating_status'] = 'N';
              
                $insert_team = $this->references_model->add($post_data);
               
                if ($insert_team) {
					$refer_id=$insert_team;
					$url=SITE_URL."references/giveFeedback/".base64_encode($refer_id);
					
					
					$from=ADMIN_EMAIL;
					$to=$this->input->post('email');
					$template='reference';
					$data_parse=array('name'=>$this->input->post('name'),
								'username'=>$user_fname." ".$user_lname,
								'copy_url'=>$url,
								'url_link'=>$url
								);
					$this->auto_model->send_email($from,$to,$template,$data_parse);
                    $this->session->set_flashdata('succ_msg', 'Your reference is added successfuly.');
                } else {
                    $this->session->set_flashdata('error_msg', 'Unable to Insert Data');
                }
                redirect(base_url() . 'references/');
            }
	
		}
		else
		{

			$this->layout->view('references',$lay,$data,'normal');
		}

	}        
    }
	
	public function viewFeedback($refer_id='')
	{
		
		if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
		else{
			
			if($refer_id=='')
			{
				redirect(VPATH.'dashboard/');	
			}
			else
			{
	
				$user=$this->session->userdata('user');
		
				$data['user_id']=$user[0]->user_id;
				$data['refer_id']=$refer_id;
				 //$data['user_membership']=$user[0]->membership_plan;
		
				$data['balance']=$this->auto_model->getFeild('acc_balance','user','user_id',$user[0]->user_id);
		
				$data['ldate']=$user[0]->ldate;
		
				$breadcrumb=array(
							array(
									'title'=>'view feedback','path'=>''
							)
						);
		
				$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'View Feedback');
		
				///////////////////////////Leftpanel Section start//////////////////
		
				$data['logo']=$logo=$this->auto_model->getFeild('logo','user','user_id',$user[0]->user_id);
		
				if($logo==''){
					$logo="images/user.png";
				}
				else{
					$logo="uploaded/".$logo;
				}
				
				$data['completeness']=$completeness=$this->auto_model->getCompleteness($user[0]->user_id);
				$data['leftpanel']=$this->autoload_model->leftpanel($logo,$completeness);
		
				///////////////////////////Leftpanel Section end//////////////////
		
				$head['current_page']='refernces';
				
				$head['ad_page']='feedback';
		
				$load_extra=array();
		
				$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
		
				$this->layout->set_assest($head);
		
				$data['username']=$this->auto_model->getFeild('username','user','user_id',$user[0]->user_id);
				
				$this->autoload_model->getsitemetasetting("meta","pagename","References");
		
				$lay['client_testimonial']="inc/footerclient_logo";
				
				$data['feedback']=$this->references_model->getReview($refer_id,$user[0]->user_id);
					
				$this->layout->view('viewfeedback',$lay,$data,'normal');
			}
	
		}        
    
	}
	public function giveFeedback($refer_id='')
	{
		if($refer_id=='')
		{
			redirect(VPATH);	
		}
		else
		{
			$data['refer_encode']=$refer_id;
			$data['refer_id']=$refer_id=base64_decode($refer_id);
			$refer_deatails=$this->references_model->getReferenceById($refer_id);
			$data['user_id']=$user_id=$refer_deatails[0]['user_id'];
			$data['requester_fname']=$this->auto_model->getFeild('fname','user','user_id',$refer_deatails[0]['user_id']);
			$data['requester_lname']=$this->auto_model->getFeild('lname','user','user_id',$refer_deatails[0]['user_id']);
			$data['requester']=$this->auto_model->getFeild('username','user','user_id',$refer_deatails[0]['user_id']);
			$data['referee_name']=$refer_deatails[0]['name'];
			
			$breadcrumb=array(
                    array(
                            'title'=>'add references','path'=>''
                    )
                );

			$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Add Reference');
			$head['current_page']='refernces';
			
			$head['ad_page']='feedback';

			$load_extra=array();
	
			$data['load_css_js']=$this->autoload_model->load_css_js($load_extra);
	
			$this->layout->set_assest($head);
			
			$this->autoload_model->getsitemetasetting("meta","pagename","References");

			$lay['client_testimonial']="inc/footerclient_logo";
			
			if($this->input->post())
			{
				
				$this->form_validation->set_rules('safety', 'safety', 'required');
				$this->form_validation->set_rules('flexiblity', 'flexiblity', 'required');
				$this->form_validation->set_rules('performence', 'performence', 'required');
				$this->form_validation->set_rules('initiative', 'initiative', 'required');
				$this->form_validation->set_rules('knowledge', 'knowledge', 'required');
				$this->form_validation->set_rules('comment', 'comment', 'required');
				
				if ($this->form_validation->run() == FALSE) {              
					$this->layout->view('feedback',$lay,$data,'normal');
				} 
				else {
						$post_data['average']=($this->input->post('safety')+$this->input->post('flexiblity')+$this->input->post('performence')+$this->input->post('initiative')+$this->input->post('knowledge'))/5;
					
						$post_data['user_id'] = $this->input->post('user_id');
						$post_data['refer_id'] = $this->input->post('refer_id');
						$post_data['safety'] = $this->input->post('safety');
						$post_data['flexiblity'] = $this->input->post('flexiblity');
						$post_data['performence'] = $this->input->post('performence');
						$post_data['initiative'] = $this->input->post('initiative');
						$post_data['knowledge'] =$this->input->post('knowledge');
						$post_data['comments'] =$this->input->post('comment');
						$post_data['status'] = 'Y';
						$post_data['add_date'] = date('Y-m-d h:i:s');
					  
						$insert_team = $this->references_model->add_feedback($post_data);
						
						$new_data['rating_status']='Y';
						
						$this->references_model->updateTable('references',$new_data,'id',$refer_id);
						
						if ($insert_team) {
							$this->session->set_flashdata('refer_succ_msg', 'Thank you for contributing to the success of HireGround. Please register to gain access to our large database of professional service providers');
						} else {
							$this->session->set_flashdata('refer_error_msg', 'Unable to Insert Data');
						}
						redirect(base_url() . 'login/');
					
				}
			}
			else
			{
				$this->layout->view('feedback',$lay,$data,'normal');
			}
		}
		
	}



}
