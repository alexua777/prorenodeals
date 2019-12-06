<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Projectdashboard_model extends BaseModel {

    private $last_query;
    public function __construct() {
        $this->last_query = '';
		return parent::__construct();
		
    }
	
	public function projectpaused($USERID,$pid){
		$this->db->select("pausedcontract");
        $res=$this->db->get_where("bids",array("project_id"=> $pid,"bidder_id"=>$USERID));
		$data=array();
        foreach ($res->result() as $row){ 
            $data[]=array(
				"projectstatus"=>$row->pausedcontract)  ;
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

    
    public function getprojecttracker($pid,$search_criteria, $offset, $limit){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));
		if (isset($search_criteria['fromdate']) && $search_criteria['fromdate'] != "") {
            $this->db->where("start_time >=", $search_criteria['fromdate']);
        }
		if (isset($search_criteria['todate']) && $search_criteria['todate'] != "") {
            $this->db->where("start_time <=", $search_criteria['todate']);
        }
		$this->db->from("project_tracker");
		$this->db->order_by('start_time','DESC');
		$this_query = $this->db->_compile_select();
        $this->last_query = $this_query;
        $res=$this->db->limit($offset, $limit)->get();
		//echo $this->db->last_query();die;
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
	
	public function getscreenshot($tracker_id)
	{
		$this->db->select("*");
		$this->db->order_by('project_work_snap_time','DESC');
        return $res=$this->db->get_where("project_tracker_snap",array("project_tracker_id"=> $tracker_id))->result_array();
	}
	
	public function listing_search_pagination($pid,$pagination_string = '', $offset = 6) {
        if ($pagination_string != "") {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?" . $pagination_string;
        } else {
            $config['base_url'] = base_url() . "projectdashboard/employer/".$pid."?page_id=0";
        }

        $config['total_rows'] = $this->search_count();
        $config['per_page'] = $offset;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'limit';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
	private function search_count() {
        $nor = $this->db->query($this->last_query)->num_rows();
        return $nor;
    }
    public function paushProject($id,$user_id)
		{
			$status=$this->auto_model->getFeild('status','projects','project_id',$id);
			if($status=='PS' || $status=='P'){
				if($status=='PS'){
					$data=array('status'=>'P');	
					$msg['msg']='Project Active';			
					
				}else{
					$data=array('status'=>'PS');
					$msg['msg']='Project Pause';
				}
				
				$this->db->where('project_id',$id);
				$this->db->where('user_id',$user_id);
				$this->db->where('project_type','H');
				$a=$this->db->update('projects',$data);
			}else{
				$a=0;	
			}
			
			if($a){
				$msg['status']='OK';								
			}else{
				$msg['status']='ERROT';
				$msg['msg']='Error occure';
				
			}
			return json_encode($msg);
	}
	 
	//*********************Newly Added for Manual Time****************//
	
	public function insertTrackerManual($data){ 
        $ins = $this->db->insert("project_tracker_manual",$data);
		return $this->db->insert_id();
    }
	
	public function getprojecttracker_manual($pid){
		$this->db->select("*");
		$this->db->where(array("project_id"=> $pid));		
		$this->db->where('stop_time <>','0000-00-00 00:00:00');
		$this->db->from("project_tracker_manual");
		$this->db->order_by('start_time','DESC');
		$this_query = $this->db->_compile_select();
        $this->last_query = $this_query;
        $res=$this->db->get();
		//echo $this->db->last_query();die;
        $data=array();
        foreach ($res->result() as $row){ 
            $data[]=array(
				"id"=>$row->id,
				"project_id"=>$row->project_id,
                "worker_id"=>$row->worker_id,
                "start_time"=>$row->start_time,
                "stop_time"=>$row->stop_time,
				"hour"=>$row->hour,
				"minute"=>$row->minute,
				"status"=>$row->status,
                "escrow_status"=>$row->escrow_status,
				"payment_status"=>$row->payment_status,
				"activity"=>$row->activity,
				"comment"=>$row->comment,
				
            );
        }
        return $data;
	}
	
	public function insert_notification($data)
	{
		$this->db->insert("notification",$data);
    }
   
}
