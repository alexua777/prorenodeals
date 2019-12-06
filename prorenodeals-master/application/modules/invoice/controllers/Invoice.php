<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice extends MX_Controller {

    /**
     * Description: this used for check the user is exsts or not if exists then it redirect to this site
     * Paremete: username and password 
     */
    public function __construct() {
        $this->load->model('invoice_model');
		$this->load->model('notification/notification_model');
        parent::__construct();
		$this->load->library('pagination');
		
		
		/* $idiom = $this->session->userdata('lang');
		$this->lang->load('projectdashboard',$idiom); */
		
    }
	
	public function list_all(){
		 if(!$this->session->userdata('user')){
			redirect(VPATH."login/");
		}
	

		$user=$this->session->userdata('user');

		$data['user_id']=$user_id=$user[0]->user_id;

		$breadcrumb=array(
                    array(
                            'title'=>'Invoices','path'=>''
                    )
                );

		$data['breadcrumb']=$this->autoload_model->breadcrumb($breadcrumb,'Invoices');

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
		
		$lay['client_testimonial']="inc/footerclient_logo";
		
		$this->load->library('pagination');
		$data['srch'] = $srch = $this->input->get();
		$limit = $limit_from ? $limit_from : 0;
		$offset = 20;
		
		$srch['user_id'] = $user_id;
		
		$data['invoice_list'] = $this->invoice_model->getInvoiceList($srch, $limit, $offset);
		$data['total_records'] = $this->invoice_model->getInvoiceList($srch, '', '', FALSE);
		
		/*Pagination Start*/
		$config['base_url'] = base_url('invoice/list_all');
		
		$config['total_rows'] = $data['total_records'];
		$config['per_page'] = $offset;
		$config["uri_segment"] = 3;
		
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
		$data['invoice_type'] = get_results(array('select' => '*', 'from' => 'invoice_type'));
		
		$this->layout->view('invoice_list',$lay,$data,'normal');
	}
	
	public function detail($invoice_id='', $type=''){
		
		$data = array();
		if(empty($invoice_id)){
			return;
		}
		
		$token = md5($invoice_id.'-'.date('Y-m-d').'SE##%!@JK');
		$access_token = $this->input->get('token');
		
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['invoice'] = get_row(array('select' => '*','from' => 'invoice_main', 'where' => array('invoice_id' => $invoice_id)));
		
		if(!empty($access_token)){
			if($access_token === $token){
				
			}else{
				return false; die;
			}
		}else{
			if(($data['invoice']['receiver_id'] == $user_id) || ($data['invoice']['sender_id'] == $user_id && $data['invoice']['sender_id'] != 0)){
			
			}else{
				return false;
				die;
			}
		}
		
		
		$data['invoice_row'] = get_results(array('select' => '*','from' => 'invoice_row', 'where' => array('invoice_id' => $invoice_id)));
		$data['download'] = FALSE;
		$this->load->view('pdf_html', $data);
	}
	
	public function download($invoice_id=''){
		$data = array();
		if(empty($invoice_id)){
			return;
		}
		$token = md5($invoice_id.'-'.date('Y-m-d').'SE##%!@JK');
		$access_token = $this->input->get('token');
		
		$user = $this->session->userdata('user');
		$user_id = $user[0]->user_id;
		$data['invoice'] = get_row(array('select' => '*','from' => 'invoice_main', 'where' => array('invoice_id' => $invoice_id)));
		
		/* if(!empty($access_token)){
			if($access_token === $token){
				
			}else{
				return false; die;
			}
		}else{
			if(($data['invoice']['receiver_id'] == $user_id) || ($data['invoice']['sender_id'] == $user_id && $data['invoice']['sender_id'] != 0)){
			
			}else{
				return false;
				die;
			}
		} */
		
		
		$data['invoice_row'] = get_results(array('select' => '*','from' => 'invoice_row', 'where' => array('invoice_id' => $invoice_id)));
		$data['download'] = TRUE;
		$data['filename'] = get('filename');
		$this->load->view('pdf_html', $data);
	}
	
}
