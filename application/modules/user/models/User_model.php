<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

	public function acc_type_update_model($data=array()){
		$token = $data['token'];
		$acc_type = $data['acc_type'];
		
		$this->db->set('token', '');
		$this->db->set('account_type', $acc_type);
		$this->db->where('token', $token);
		
		return $this->db->update('user');
	}
	
    public function login($data) {
        $id = 0;
        $this->db->select('user_id');
        $query = $this->db->get_where("users", array("email" => $data['email'], "password" => md5($data['pwd']), "status" => 'Y'));
        if ($result = $query->row()) {
            $id = $result->user_id;
        }
        return $id;
    }

    public function fb_registration($data) {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function random_password($email, $pwd) {
        $this->db->where(array("email" => $email, "status" => "Y"));
        return $this->db->update("users", array('password' => md5($pwd)));
    }

	public function getWelcome()
	{
		$this->db->select();
		$rs=$this->db->get_where("content",array('pagename'=>'welcome'));
		$data=$rs->result();
		return $data;
	}
	public function getGallary()
	{
		$this->db->select('*');
		$this->db->group_by("cat_id"); 
		$rs=$this->db->get_where("gallery",array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$rss=$this->db->get_where("category",array('cat_id'=>$row->cat_id),6);
			$cat=$rss->row();
			$data[] = array(
				'gal_id' => $row->gal_id,
				'cat_id' => $row->cat_id,
				'cat_name' => $cat->cat_name,
				'gal_type' => $row->gal_type,
				'image' => $row->image
			);
		}
		return $data;
	}
	public function getService()
	{
		$this->db->select();
		$rs=$this->db->get_where("content",array('pagename'=>'service'));
		$data=$rs->result();
		return $data;
	}

    public function register() {
        $data = array(
			'fname' => $this->input->post('first_name'),
        	'lname' => $this->input->post('last_name'),
            'password' => md5($this->input->post('password')),
            'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
            'created' => date('Y-m-d'),
            'city' => $this->input->post('city'),
            'address1' => $this->input->post('address1'),
			'address2' => $this->input->post('address2'),
            'zip' => $this->input->post('zip'),
			'dob' => date('Y/m/d',strtotime($this->input->post('dob'))),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country'),
            'status' => 'Y'
        );
       $insert_id=$this->db->insert('users', $data);
	// echo "<pre>";
	 // print_r($data);
        return $insert_id;

    }

    public function getcontentlist() {
        $this->db->select('*');
        $rs = $this->db->get_where('content', array('status' => 'Y'));
        $data = array();
        foreach ($rs->result() as $row) {
            $data[] = array(
                'id' => $row->id,
                'content_title' => $row->cont_title,
                'contents' => $row->contents,
                'status' => $row->status
            );
        }
        return $data;
    }

    public function fb_auth($user_id, $token) {
        $data = array(
            'fb_auth_no' => $token
        );
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
    }
	public function getEvent()
	{
		$this->db->select();
		$this->db->order_by('event_id','desc');
		$rs = $this->db->get_where('event',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$rss=$this->db->get_where("gallery",array('cat_id'=>$row->cat_id),1);
			$cat=$rss->row();
			$image="";
			if($cat)
			{
				$image=$cat->image;
			}
			$data[] = array(
				'event_id' => $row->event_id,
				'cat_id' => $row->cat_id,
				'event_name' => $row->event_name,
				'event_desc' => $row->event_desc,
				'start_date' => $row->start_date,
				'end_date' => $row->end_date,
				'venue' => $row->venue,
				'post_code' => $row->post_code,
				'created' => $row->created,
				'image'=> $image
			);
		}
		return $data;
	
	}
	public function getSetting()
	{
		$this->db->select();
		$rs = $this->db->get_where('setting',array('id'=>'45'));
		$row=$rs->row(); 
		$admin= $row->admin_mail;
		return $admin;
	
	}
	public function getCountry()
	{
		$this->db->select();
		$rs = $this->db->get('countries');
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'code' => $row->code,
				'name' => $row->name
			);
		}
		return $data;
	}
	public function getBanner($display='')
	{
		$this->db->select('*');
		$rs = $this->db->get_where('banner',array('status'=>'Y','display_for'=>$display),10);
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'image' => $row->image,
				'title' => $row->title,
				'url' => $row->url,
				'description' => $row->description,
				'display_for' => $row->display_for
			);
		}
		return $data;
	}
	public function getUser()
	{
		$id=$this->session->userdata('user_id');
		$this->db->select();
		$rs = $this->db->get_where('users',array('user_id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$rss = $this->db->get_where('countries',array('code'=>$row->country));
			$al=$rss->row();
			$data[] = array(
				'user_id' => $row->user_id,
                'fname' => $row->fname,
				'lname' => $row->lname,
                'country_code' => $row->country,
				'country' => $al->name,
                'state' => $row->state,
                'email' => $row->email,
             	'city' => $row->city,
                'address1' => $row->address1,
				'address2' => $row->address2,
                'phone' => $row->phone,
				'image' => $row->image,
				'description'=>$row->description,
                'status' => $row->status,
                'created' => $row->created
			);
		}
		return $data;
	}
	public function getUserbyId($id)
	{
		$this->db->select();
		$rs = $this->db->get_where('users',array('user_id'=>$id));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'user_id' => $row->user_id,
                'fname' => $row->fname,
				'lname' => $row->lname,
				'sex' => $row->sex,
                'country' => $row->country,
                'state' => $row->state,
                'email' => $row->email,
             	'city' => $row->city,
                'address1' => $row->address1,
				'address2' => $row->address2,
				'zip' => $row->zip,
				'dob' => $row->dob,
                'phone' => $row->phone,
				'image' => $row->image,
				'description'=>$row->description,
                'status' => $row->status,
                'created' => $row->created
			);
		}
		return $data;
	}
	public function edituser($id)
	{
		$data = array(
			'fname' => $this->input->post('fname'),
        	'lname' => $this->input->post('lname'),
			'description' => $this->input->post('description'),
            'email' => $this->input->post('email'),
			'sex' => $this->input->post('sex'),
			'phone' => $this->input->post('phone'),
            'created' => date('Y-m-d'),
            'city' => $this->input->post('city'),
            'address1' => $this->input->post('address1'),
			'address2' => $this->input->post('address2'),
            'zip' => $this->input->post('zip'),
			'dob' => $this->input->post('dob'),
			'state' => $this->input->post('state'),
			'country' => $this->input->post('country')
        );
       	$this->db->where('user_id', $id);
        return $this->db->update('users', $data);
	}
	public function updatemember($data,$id)
	{
		//echo $id;die();
		$this->db->where('user_id',$id);
		return $this->db->update('users',$data);
		
	}
	public function getSkills($skill_no)
	{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->where('show_status','Y');
		$this->db->where('home_status','Y');
		$this->db->limit($skill_no);
		$rs=$this->db->get('skills');
		$data=array();
		foreach($rs->result() as $row)
		{
			$data[]=array(
			'id'=>$row->id,
			'skill_name'=>$row->skill_name,
			'arabic_skill_name'=>$row->arabic_skill_name,
			'spanish_skill_name'=>$row->spanish_skill_name,
			'swedish_skill_name'=>$row->swedish_skill_name,
			'image'=>$row->image
			);	
		}
		return $data;	
	}
	
	
	
		public function getCatagories($skill_no)
	{
		$this->db->select();
		$this->db->order_by('cat_id','desc');
		$this->db->where('status','Y');
		$this->db->where('show_status','Y');
		if($skill_no){
			$this->db->limit($skill_no);
		}
		
		$rs=$this->db->get_where('categories',array('parent_id'=>'0'));
		$data=array();
		foreach($rs->result() as $row)
		{
			$data[]=array(
			'id'=>$row->cat_id,
			'cat_name'=>$row->cat_name,
			'status'=>$row->status,
			'icon_class'=>$row->icon_class,
			'arabic_cat_name'=>$row->arabic_cat_name,
			'spanish_cat_name'=>$row->spanish_cat_name,
			'swedish_cat_name'=>$row->swedish_cat_name,
			'image'=>$row->image,
			);	
		}
		return $data;	
	}
	
	public function get_all_catagories(){
		$this->db->select();
		$this->db->order_by('cat_id','desc');
		$this->db->where('status','Y');
		if($skill_no){
			$this->db->limit($skill_no);
		}
		
		$rs=$this->db->get_where('categories',array('parent_id'=>'0'));
		$data=array();
		foreach($rs->result() as $row)
		{
			$data[]=array(
			'id'=>$row->cat_id,
			'cat_name'=>$row->cat_name,
			'status'=>$row->status,
			'icon_class'=>$row->icon_class,
			'arabic_cat_name'=>$row->arabic_cat_name,
			'spanish_cat_name'=>$row->spanish_cat_name,
			'swedish_cat_name'=>$row->swedish_cat_name,
			'image'=>$row->image,
			'skills' => get_results(array('select' => '*', 'from' => 'skills', 'where' => array('cat_id' => $row->cat_id, 'status' => 'Y')))
			);	
		}
		return $data;	
	}
	
	
	public function get_top_skills($skill_no)
	{
		$data=array();
		$this->db->where('home_status','Y');
		$data = $this->db->limit($skill_no)->get('skills')->result_array();
		return $data;
	}
	public function count_project_top_skill($perent){
		/* $this->db->select('*');
		$this->db->from('project_skill');
		$this->db->where('skill_id',$perent);
		$query = $this->db->get()->num_rows(); */
		
		$result = $this->db->select('s.id')
			->from('project_skill s')
			->join('projects p', 'p.project_id=s.project_id', 'INNER')
			->where(array('p.visibility_mode' => 'Public', 'status' => 'O'))
			->where('s.skill_id', $perent)
			->get()->num_rows();
	
		return $result;
	}
	/*public function count_project($perent){
		$this->db->select('c.*,p.*')->from('projects p');
		$this->db->join('categories c','p.category=c.cat_id','INNER');
		$this->db->where('c.parent_id',$perent);
		$query = $this->db->get()->num_rows();
	
		return $query;
	}*/
	public function count_project($perent){
		$this->db->select('*');
		$this->db->from('projects');
		$this->db->where('category',$perent);
		$query = $this->db->get()->num_rows();
	
		return $query;
	}
	public function getTestimonials($testimonial_no)
	{
		$this->db->select();
		$this->db->order_by('RAND()');
		$res=$this->db->get_where('testimonial',array('status'=>'Y'),$testimonial_no);
		$data=array();
		foreach($res->result() as $row)
		{
			$data[]=array(
			'id'=>$row->id,
			'user_id' => $row->user_id,
			'description'=>$row->description,
			'posted'=>$row->posted_date
			);	
		}
		return $data;	
	}
	public function transferdatafromjoomlatocodingniter($users)
	{
		
		foreach($users as $userdetails)
		{
			 mysql_query("insert into serv_user set username = '". $userdetails->username."', password = '".$userdetails->password."' , fname = '".$userdetails->name."' , email = '".$userdetails->email."' , reg_date = '".$userdetails->registerDate."' , ldate = '".$userdetails->lastvisitDate."' , transfer_status = '1'");
			
			
		}
	}
	
	public function getPlans(){
		$result =  $this->db->where('status' , 'Y')->get('membership_plan')->result_array();
		return $result;
	}
	
	public function getPartners(){
		$result =  $this->db->where('status' , 'Y')->get('partner')->result_array();
		return $result;
	}
	
	public function get_featured_users($offset=4){
		$this->load->model('findtalents/findtalents_model');
		$this->db->select('u.user_id,u.fname,u.lname,u.gender,u.country,u.city,u.logo,slogan,avg(r.average) as average_rating')
				->from('user u')
				->join('review_new r' , "r.review_to_user=u.user_id" , "LEFT")
				->where('u.account_type', 'F')
				->where('u.status', 'Y');
				/* ->where('u.featured', 1); */
		$this->db->group_by('u.user_id');
		$this->db->order_by('u.featured', 'DESC');
		$this->db->order_by('average_rating', 'DESC');
		$result = $this->db->limit($offset, 0)->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$result[$k]['logo_url'] = get_user_logo($v['user_id']);
				$result[$k]['user_rating'] = get_user_rating($v['user_id']);
				$result[$k]['profile_link'] = base_url('clientdetails/showdetails/'.$v['user_id']);
				$result[$k]['city_name'] = get_city_name($v['city']);
				$result[$k]['skills'] = $this->findtalents_model->getUserSkills($v['user_id']);
			}
			
		}
		
		return $result;
	}
	
	public function get_featured_projects($offset=4){
		$this->db->select("p.project_id,p.title,p.description,p.buget_min,p.buget_max,p.post_date,p.user_id, (select count(id) from serv_bids where project_id=p.project_id) as bid_count", FALSE)
				->from('projects p');
				
		
		$this->db->where('p.status', 'O');
		
		$this->db->order_by('p.id', 'DESC');
		$result = $this->db->limit($offset, 0)->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$result[$k]['amount_spend'] = get_project_spend_amount($v['user_id']);
				$result[$k]['project_detail_url'] = base_url('job-'.seo_string($v['title']).'-'.$v['project_id']);
				$result[$k]['skills'] =$this->_get_project_skills($v['project_id']);
			}
			
		}
		
		return $result;
	}
	
	private function _get_project_skills($project_id=''){
		$this->db->select('p_s.skill_id,s.skill_name as name')
			->from('project_skill p_s')
			->join('skills s', 's.id=p_s.skill_id', 'INNER');
		
		$this->db->where('p_s.project_id', $project_id);
		
		$result = $this->db->get()->result_array();
		
		return $result;
	}
	
	public function get_all_skills(){
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->where('show_status','Y');
		/* $this->db->where('home_status','Y'); */
		$this->db->limit($skill_no);
		$rs=$this->db->get('skills');
		$data=$rs->result_array();
		
		return $data;
	}
	
}
