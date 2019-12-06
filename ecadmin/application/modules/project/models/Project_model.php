<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  Project_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }


	
	################### OPEN PROJECT ##############
	
	public function getAllOpenList($limit = '', $start = '')
	{ // 	id	project_id	title	description	category	skills	attachment	project_type F=FIXED H=HOURLY	buget_min	buget_max	featured Y=Yes N=No	post_date	expiry_date	user_id	bidder_id	expiry_date_extend Y=Yes N=No	status
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get_where('projects',array('status' => 'O'));
		$data = array();
		foreach($rs->result() as $row)
		{
		
			$data[] = array(
				'id' => $row ->id,		
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' =>$row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'status'=>$row->status,
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'projectstatus'=>$row->project_status
			);
			
		}
		return $data;
	}
	
	
	################### PROCESS PROJECT ##############
	
	
	public function getAllProcessList($limit = '', $start = '')
	{ 
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get_where('projects',array('status' => 'P'));
		$data = array();
		foreach($rs->result() as $row)
		{
		
			$data[] = array(
			     'id' => $row ->id,
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' => $row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'status'=>$row->status,
				
			);
			
		}
		return $data;
	}
	
	
		################### FROZEN PROJECT ##############
	
	
	public function getAllFrozenList($limit = '', $start = '')
	{ 
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get_where('projects',array('status' => 'F'));
		$data = array();
		foreach($rs->result() as $row)
		{
		/*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();*/
			$data[] = array(
			     'id' => $row ->id,
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' => $row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'status'=>$row->status,
				
			);
			
		}
		return $data;
	}
	
		################### COMPLETED PROJECT ##############
	
	
	public function getAllCompletedList($limit = '', $start = '')
	{ 
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get_where('projects',array('status' => 'C'));
		$data = array();
		foreach($rs->result() as $row)
		{
		/*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();*/
			$data[] = array(
			     'id' => $row ->id,
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' => $row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'status'=>$row->status
				
			);
			
		}
		return $data;
	}
	
		################### EXPIRE PROJECT ##############
	
	
	public function getAllExpireList($limit = '', $start = '')
	{ 
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$start);
		$rs = $this->db->get_where('projects',array('status' => 'E'));
		$data = array();
		foreach($rs->result() as $row)
		{
		/*$rss=$this->db->get_where('company',array("comp_id"=>$row->comp_id));
		$al=$rss->row();*/
			$data[] = array(
			     'id' => $row ->id,
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' => $row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'status'=>$row->status
				
			);
			
		}
		return $data;
	}
	
        
	################################# BIDS LIST ##########################	
		
	 public function getAllBidsList($project_id)
			{   
			
				$this->db->select('bidder_id');
				$this->db->where('project_id', $project_id);
				$this->db->from('bids');
				return $this->db->count_all_results();
				//echo $this->db->count_all_results();
				 //echo $this->db->last_query();
				//die;
				
			}
			
		public function getMilestoneCount($project_id)
		{   
			
				$this->db->select('*');
				$this->db->where('project_id', $project_id);
				$this->db->from('project_milestone');
				return $this->db->count_all_results();			
				
		}	
		

		
		 public function getAllBidder($project_id)
			{   
			
				$this->db->select('*');
				$this->db->where('project_id', $project_id);
                                $this->db->order_by("id","desc");
				$rs = $this->db->get('bids');
				
				$data = array(); 
				foreach($rs->result() as $row)
				{		
					$data[] = array(
						
						'id' => $row->id,							
						'bidder_id' => $row->bidder_id,
						'details'	=> $row-> details,
						'bidder_amt' => $row->bidder_amt,
						'total_amt' => $row->total_amt,
						'days_required' => $row->days_required,
						'add_date' => $row-> add_date
					);
					
				}
				
				return $data;
				//$this->db->count_all_results();
				//echo $this->db->count_all_results();
				 //echo $this->db->last_query();
				//die;
				
			}
			
			
			
	public function getAllMilestone($project_id)
			{   
			
				$this->db->select('*');
				$this->db->where('project_id', $project_id);
                $this->db->order_by("id","desc");
				$rs = $this->db->get('project_milestone');
				
				$data = array(); 
				foreach($rs->result() as $row)
				{		
					$data[] = array(
						
						'id' => $row->id,							
						'milestone_no' => $row->milestone_no,
						'project_id'	=> $row-> project_id,
						'amount' => $row->amount,
						'mpdate' => $row->mpdate,
						'bidder' => $this->getBiddername($row->bidder_id),
						'employer' => $this->getBiddername($row->employer_id),
						'description' => $row->description,
						'request_by' => $row->request_by,
						'client_approval' => $row->client_approval,
						'fund_release' => $row->fund_release,
						'release_payment' => $row->release_payment
					);
					
				}
				
				return $data;				
			}
			
		public function	getInvoiceId($project_id,$milestone_id){
			$invoice_id='';
			$this->db->select('invoice_id');
			$this->db->from('invoice');
			$this->db->where('project_id',$project_id);
			$this->db->where('milestone_id',$milestone_id);
			$r = $this->db->get()->result();
			foreach($r as $val){
				$invoice_id = $val->invoice_id;
			}
			if($invoice_id){
				return $invoice_id;
			}else{
				return false;
			}
			
		}
		
		public function getBiddername($bidder_id='')
		{	$bidder='';
			$this->db->select('username,fname,lname');
			$this->db->where('user_id',$bidder_id);
			$rs = $this->db->get('user');			
			foreach($rs->result() as $row)
			{
				if($row->fname != '' && $row->lname != '')
				{										
					$bidder =$row->fname." ".$row->lname;						
				}
				else
				{
					$bidder = $row->username;						
				}
			}
			
			return $bidder;
		}
		
		
       /*
	public function getAllCheckList()
	{
		$this->db->select('*');
		$this->db->order_by('varify_id');
		$rs = $this->db->get('varify_record');
		$data = array();
		foreach($rs->result() as $row)
		{		
			$data[] = array(
				'varify_id' => $row->varify_id,
				'text' => $row->text,				
				'when' => $row->when,
				'status' => $row->status
			);
			
		}
		return $data;
	}        
        */
	
	public function add_membership($data)
	{
		return $this->db->insert('membership_plan',$data);
	}
	public function add_jobnotification($data)
	{
		return $this->db->insert('jobnotification',$data);
	}
	
	public function updateProject($data,$id,$status, $subskill=array()){ 
		$project_id =  getField('project_id', 'projects', 'id', $id);
		$subskillarr = $subskill;
		$this->db->set('status', $status);
		$this->db->where('id',$id);
		$this->db->update('projects',$data);
		
		$this->db->where('project_id', $project_id)->delete('project_skill');
		
		if(count($subskillarr) > 0){
			foreach($subskillarr as $k => $v){
				$this->db->insert('project_skill' , array('project_id' => $project_id , 'skill_id' => $v));
			}
		}
		
		return TRUE;
		
	}
	
	public function updateprojectstatus($data,$id)
	{  
		$this->db->where('id',$id);
		return $this->db->update('projects',$data);
		// echo $this->db->last_query();
	}
	
	public function getOpenProject($status,$id)
	{ // 	id	project_id	title	description	category	skills	attachment	project_type F=FIXED H=HOURLY	buget_min	buget_max	featured Y=Yes N=No	post_date	expiry_date	user_id	bidder_id	expiry_date_extend Y=Yes N=No	status
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get_where('projects',array('status' =>$status,'id'=>$id));
		$data = array();
		$row=$rs->row();
			$data = array(
				'id' => $row->id,
				'project_id' => $row->project_id,
				'title' => $row->title,
				'category' => $row->category,
				'skills' => $row->skills,
				'visibility_mode' => $row->visibility_mode,
				'environment' => $row->environment,
				'featured' => $row->featured,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' => $row->project_type,
				'description' => $row->description,
				'user_id' => $row->user_id,
				'post_date'=>$row->post_date,
				'status'=>$row->status
				
			);
			
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	

	
	public function deleteProject($id)
	{
		return $this->db->delete('projects', array('id' => $id)); 
	}
	
	public function getCompany()
	{
		$this->db->select('*');
		$this->db->order_by('comp_id','desc');
		$rs = $this->db->get_where('company',array('status'=>'Y'));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
				'comp_id' => $row->comp_id,
				'name' => $row->name
			);
			
		}
		/*echo "<pre>";
		print_r($data);die;*/
		return $data;
	}
	public function record_count_open() 
	{
        $this->db->select('id');
		$this->db->where('status','O');
		$this->db->from('projects');
        return $this->db->count_all_results();
    }
	
	public function record_count_filter($st,$title) 
	{
		$this->db->select('id');
		$this->db->like('title',$title);
		$this->db->where('status',$st);
		$this->db->from('projects');
        return $this->db->count_all_results();
    }
        
     
	 	public function record_count_process() 
	{
         $this->db->select('id');
		$this->db->where('status','P');
		$this->db->from('projects');
        return $this->db->count_all_results();
        } 
		
		public function record_count_frozen() 
	{
         $this->db->select('id');
		$this->db->where('status','F');
		$this->db->from('projects');
        return $this->db->count_all_results();
        }  	
    
	
	 	public function record_count_complete() 
	{
          $this->db->select('id');
		$this->db->where('status','C');
		$this->db->from('projects');
        return $this->db->count_all_results();
        } 
		
		public function record_count_expire() 
	{
          $this->db->select('id');
		$this->db->where('status','E');
		$this->db->from('projects');
        return $this->db->count_all_results();
        }  	
				
		
		public function record_count_bids() 
	{
          return $this->db->count_all('projects');
        }	
		
		
		
		
		public function getAllProjects($status)
		{
		$this->db->select('*');
		$this->db->order_by('id','desc');
		$rs = $this->db->get_where('projects',array('status'=>$status));
		$data = array();
		foreach($rs->result() as $row)
		{
			$data[] = array(
					'id' => $row->id,
					'project_id' => $row->project_id,
					'title' => $row->title,
					'category' => $row->category,
					'buget_min' => $row->buget_min,
					'buget_max' => $row->buget_max,
					'project_type' => $row->project_type,
					'description' => $row->description,
					'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
					'post_date'=>$row->post_date,
					'bid_count'=>$this->getAllBidsList($row->project_id),
					'milestone_count'=>$this->getMilestoneCount($row->project_id),
					'status'=>$row->status
					
					
				
			);
			
		}
		//echo "<pre>";
		//print_r($data);die;
		return $data;
	}
		
	public function SearchProjects($proj_select,$search_element,$status)
			{
				
				
			$this->db->select('*');
			$this->db->order_by('id','desc');
			$this->db->like($proj_select, $search_element, 'after'); 
			$rs = $this->db->get_where('projects',array('status'=>$status));
			echo $this->db->last_query();
			die;
			$data = array();
			foreach($rs->result() as $row)
			{
				$data[] = array(
					'id' => $row->id,
					'project_id' => $row->project_id,
					'title' => $row->title,
					'category' => $row->category,
					'buget_min' => $row->buget_min,
					'buget_max' => $row->buget_max,
					'project_type' => $row->project_type,
					'description' => $row->description,
					'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
					'post_date'=>$row->post_date,
					'bid_count'=>$this->getAllBidsList($row->project_id),
					'milestone_count'=>$this->getMilestoneCount($row->project_id),
					'status'=>$row->status
					
				);
			}
		
		
		
		
		
		//echo "<pre>";
		//print_r($data);die;
		return $data;
	}
	public function getFilterProjectList($title,$st,$limit = '', $start = '')
	{
		$this->db->select('*');
		$this->db->like('title',$title);
		$this->db->order_by('id','desc');
		$this->db->limit($limit, $start);
		$rs = $this->db->get_where('projects',array('status' => $st));
		$data = array();
		foreach($rs->result() as $row)
		{
		
			$data[] = array(
				'id' => $row ->id,		
				'project_id' => $row->project_id,
				'title' => $row->title,
				'buget_min' => $row->buget_min,
				'buget_max' => $row->buget_max,
				'project_type' =>$row->project_type,
				'user_name' =>$this->auto_model->getFeild('username','user','user_id',$row->user_id),
				'post_date'=>$row->post_date,
				'bid_count'=>$this->getAllBidsList($row->project_id),
				'milestone_count'=>$this->getMilestoneCount($row->project_id),
				'status'=>$row->status,
				
			);
			
		}
		return $data;
	}
public function getParentcat()
{
	$this->db->select('cat_id,cat_name');
	$this->db->where('parent_id','0');
	$this->db->where('status','Y');
	$res=$this->db->get('categories');
	$data=array();
	foreach($res->result() as $row)
	{
		$data[]=array(
		'cat_id'=>$row->cat_id,
		'cat_name'=>$row->cat_name
		);	
	}
	return $data;	
}        
public function getParentskill()
{
	$this->db->select('id,skill_name');
	$this->db->where('parent_id','0');
	$this->db->where('status','Y');
	$res=$this->db->get('skills');
	$data=array();
	foreach($res->result() as $row)
	{
		$data[]=array(
		'id'=>$row->id,
		'skill_name'=>$row->skill_name
		);	
	}
	return $data;	
}         

	public function getprojectdetails($id){ 
        $this->db->select("project_id,title,description,featured,category,skills,attachment,project_type,buget_min,buget_max,expiry_date,user_id,user_country,bidder_id,status,environment,visibility_mode,project_status");		
        $res=$this->db->get_where("projects",array("project_id"=> $id));
        $data=array();
        foreach ($res->result() as $row){ 
            $data[]=array(
                "project_id"=>$row->project_id,
                "title"=>$row->title,
                "description"=>$row->description,
                "category"=>$row->category,
				"skills"=>$row->skills, 
				"attachment"=>$row->attachment,
                "featured"=>$row->featured,
                "project_type"=>$row->project_type,
                "buget_min"=>$row->buget_min,
                "buget_max"=>$row->buget_max,               
                "expiry_date"=>$row->expiry_date,
                "user_id"=>$row->user_id,
                "user_country"=>$row->user_country,
                "bidder_id"=>$row->bidder_id,                
                "status"=>$row->status,
				"environment"=>$row->environment,
				"visibility_mode"=>$row->visibility_mode,
				"project_status"=>$row->project_status
				
            );
        }
        return $data;        
        
    }
	
	public function record_count_projecttracker($pid)
	{		
		$this->db->where('project_id',$pid);
		$this->db->from('project_tracker');
		return $this->db->count_all_results();
	}
	public function getFilterCounttracker($pid,$from,$to)
	{
		$this->db->select("*");		
		$this->db->where('project_id',$pid);
		$this->db->where('start_time >=',$from);
		$this->db->where('start_time <=',$to);        
		$this->db->from('project_tracker');
		return $this->db->count_all_results();
	}
	
	public function getprojecttracker($pid, $limit = '', $start = '')
	{		
		$this->db->select("*");
		$this->db->order_by('start_time','DESC');
		$this->db->limit($limit, $start);
		$this->db->where('stop_time <>', '0000-00-00 00:00:00');
        $res=$this->db->get_where("project_tracker",array("project_id"=> $pid));
        $data=array();
		$data = $res->result_array();
		
		return $data;
		
       /*  foreach ($res->result() as $row){ 
            $data[]=array(
				"id"=>$row->id,
                "worker_id"=>$row->worker_id,
                "start_time"=>$row->start_time,
                "stop_time"=>$row->stop_time,
                "escrow_status"=>$row->escrow_status,
				"payment_status"=>$row->payment_status
				
            );
        }
        return $data; */
	}
	
	public function getFilterprojecttracker($pid,$from,$to,$limit = '', $start = '')
	{
		$this->db->select("*");
		$this->db->order_by('start_time','DESC');
		if($limit!='' && $start!='')
		{
			$this->db->limit($limit, $start);
		}
		$this->db->where('project_id',$pid);
		$this->db->where('start_time >=',$from);
		$this->db->where('start_time <=',$to);
        $res=$this->db->get("project_tracker");
        $data=array();
        foreach ($res->result() as $row){ 
            $data[]=array(
				"id"=>$row->id,
                "worker_id"=>$row->worker_id,
                "start_time"=>$row->start_time,
                "stop_time"=>$row->stop_time,
                "escrow_status"=>$row->escrow_status,
				"payment_status"=>$row->payment_status
				
            );
        }
        return $data;
	}
	
	public function record_count_screenshot($tracker_id)
	{				
        $this->db->where('project_tracker_id',$tracker_id);
		$this->db->from('project_tracker_snap');
		return $this->db->count_all_results();
	}
	
	public function getscreenshot($tracker_id, $limit = '', $start = '')
	{
		$this->db->select("*");
		$this->db->order_by('project_work_snap_time','DESC');
		$this->db->limit($limit, $start);
        return $res=$this->db->get_where("project_tracker_snap",array("project_tracker_id"=> $tracker_id))->result_array();
	}
	
}
