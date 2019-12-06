<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Jobdetails_model extends BaseModel {



    public function __construct() {

        return parent::__construct();

    }
	
	public function getmilestone($bid_id=''){
		if(empty($bid_id)){
			return FALSE;
		}
		return $this->db->where(array('bid_id' => $bid_id))->order_by('id', 'ASC')->get('project_milestone')->result_array();
	}
	
	public function addFav($data=array()){
		if(empty($data)){
			return FALSE;
		}
		$count = $this->db->where(array('user_id' => $data['user_id'] , 'type' => $data['type'], 'object_id' => $data['object_id']))->count_all_results('favorite');
		if($count == 0){
			return $this->db->insert('favorite' , $data);
		}
		return TRUE;
	}
	
	public function removeFav($data=array()){
		if(empty($data)){
			return FALSE;
		}
		$this->db->where(array('user_id' => $data['user_id'] , 'type' => $data['type'], 'object_id' => $data['object_id']))->delete('favorite');
		return TRUE;
	}

    

    public function getprojectdetails($id){ 

        $this->db->select("project_id,title,description,featured,category,skills,attachment,project_type,buget_min,buget_max,expiry_date,user_id,user_country,bidder_id,status,environment,visibility_mode,project_status,sub_category,hr_per_week,no_of_freelancer,exp_level,postal_code,bidding_deadline,project_start_on,abuse,spam");

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
				
                "exp_level"=>$row->exp_level,                

                "status"=>$row->status,

				"environment"=>$row->environment,

				"visibility_mode"=>$row->visibility_mode,

				"project_status"=>$row->project_status,
				'sub_category' => $row->sub_category,
				'hr_per_week' => $row->hr_per_week,
				'no_of_freelancer' => $row->no_of_freelancer,
				'postal_code' => $row->postal_code,
				'bidding_deadline' => $row->bidding_deadline,
				'project_start_on' => $row->project_start_on,
				'abuse' => $row->abuse,
				'spam' => $row->spam,

				

            );

        }

        return $data;

        

        

    }



    

    public function getuserdetails($uid){ 

        $this->db->select("*");

        $res=$this->db->get_where("user",array("user_id" => $uid));

        $data=array();

        foreach ($res->result() as $row){ 

            $data[]=array(                

                "user_id"=>$row->user_id,      

                "fname"=>$row->fname,

                "lname"=>$row->lname,        

                "status"=>$row->status,

                "email"=>$row->email, 

                "city"=>$row->city,

                "country"=>$row->country,

                "logo"=>$row->logo,

                "hourly_rate"=>$row->hourly_rate,

				"rating" => $this->dashboard_model->getrating_new($row->user_id),

			   	"com_project" => $this->countComplete_client($row->user_id)

            );

        }

        return $data;

        

    }

    

    public function gettotalbid($pid){

        $this->db->where('project_id',$pid);

        $this->db->from('bids');        

       return $this->db->count_all_results();

    }

    

    public function gettotalbidamt($pid){ 

        $this->db->select_sum('bidder_amt');

        $this->db->where('project_id',$pid);

        $res= $this->db->get('bids');               

        $data=array();

        foreach($res->result() as $row){ 

            $data[]=$row->bidder_amt;

        }

       

        return $data[0];

        

    }

    

    public function gettotaluserproject($uid){ 

        $this->db->where('user_id',$uid);

        $this->db->from('projects');        

       return $this->db->count_all_results();        

    }

    

    public function post_bid(){ 

		
		$days_required=0;
		$user=$this->session->userdata('user');

        $details=$this->input->post("details");
		
		$project_type=$this->input->post('project_type');
		
		$attachment = ltrim($this->input->post('upload_file1'),",");

        $bidder_amt=$this->input->post("bidder_amt");

        $total_amt=$this->input->post("total_amt");
        if($project_type=="F")
		{
        $days_required=$this->input->post("days_required");
        } 
        $pid=$this->input->post("pid");
        $bid=$this->input->post("bid");
        $project_user=$this->auto_model->getFeild('user_id','projects','project_id',$pid);
        $i=0;
		if($details==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='details';

			$msg['errors'][$i]['message']="Please Enter Details";

			$i++;

		}

		if($bidder_amt=='' || $total_amt==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='client_bidamount';

			$msg['errors'][$i]['message']="Please Enter Earnings";

			$i++;

		} 
        if($project_type=="F")
		{
			if($days_required==''){

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='delivery';

				$msg['errors'][$i]['message']="Please Enter Days Required";

				$i++;

			}
        }		

                

                if($i==0){

                    

						$data = array(

                            'project_id' => $pid,

                            'bidder_id' => $bid,

                            'details' => $details,
							
							'attachment' => $attachment,

                            'bidder_amt' => $bidder_amt,

                            'total_amt' => $total_amt,

                            'days_required' => $days_required,

                            'add_date' => date("Y-m-d")

                            

						);			
			
			parent::insert("bids", $data);

                        

                        if($this->isalreadypost($pid,$bid)){ 

                            

                            $this->db->where('project_id', $pid);

                            $this->db->where('bidder_id', $bid);                             

                            

                            if ($this->db->update('bids', $data)) {

                                $msg['status']='OK';    

                                $msg['message']='Bid Updated Successfuly.';

								$msg['location']=VPATH.'jobdetails/details/'.$pid;

                            }

                            else {

                                $msg['status']='FAIL';

                                $msg['errors'][$i]['id']='agree_terms';

                                $msg['errors'][$i]['message']= 'dB error!';

                            } 

                            
							$bidder_fname=$this->auto_model->getFeild('fname','user','user_id',$bid);
							$bidder_lname=$this->auto_model->getFeild('lname','user','user_id',$bid);
							$project_name=$this->auto_model->getFeild('title','projects','project_id',$pid);

                            $data_notification=array(

                                "from_id" => $bid,

                                "to_id" => $project_user,

                                "notification" =>  htmlentities("<a href='".VPATH."clientdetails/showdetails/".$user[0]->user_id."'>".ucwords($bidder_fname." ".$bidder_lname)."</a> has been updated his bid on <a href='".VPATH."jobdetails/details/".$pid."/".$this->auto_model->getcleanurl($project_name)."/'>".ucwords($project_name)."</a>"),

                                "add_date" => date("Y-m-d"),
								
								"read_status" => 'N'                              

                            );

                            $this->db->insert("notification",$data_notification);

                        }

                        else{ 

                            if ($this->db->insert('bids', $data)) {

                                $msg['status']='OK';    
                                $msg['message']='Bid posted successfully';
                                $msg['pid']=$pid;
								
								$from=ADMIN_EMAIL;
								
								$to=$this->auto_model->getFeild('email','user','user_id',$project_user);
								$fname=$this->auto_model->getFeild('fname','user','user_id',$project_user);
								$lname=$this->auto_model->getFeild('lname','user','user_id',$project_user);
								$project_name=$this->auto_model->getFeild('title','projects','project_id',$pid);
								$bidder_fname=$this->auto_model->getFeild('fname','user','user_id',$bid);
								$bidder_lname=$this->auto_model->getFeild('lname','user','user_id',$bid);
								$template='bid_on_job_for_employe';
								$data_parse=array('username'=>$fname." ".$lname,
													'freelancer'=>$bidder_fname." ".$bidder_lname,
													'project'=>$project_name,
													'project_url'=>VPATH.'jobdetails/details/'.$pid.'/'.$this->auto_model->getcleanurl($project_name),
													'amount'=>$bidder_amt,
													'duration'=>$days_required
													);
								$this->auto_model->send_email($from,$to,$template,$data_parse);



                            }

                            else {

                                $msg['status']='FAIL';

                                $msg['errors'][$i]['id']='agree_terms';

                                $msg['errors'][$i]['message']= 'dB error!';

                            }

							

                            $bid_plan_limit=$this->auto_model->getFeild('bids','membership_plan','id',$user[0]->membership_plan);

							if($user[0]->membership_plan!='1')

							{

								$membership_start=$this->auto_model->getFeild('membership_start','user','user_id',$user[0]->user_id);

								$membership_end=$this->auto_model->getFeild('membership_end','user','user_id',$user[0]->user_id);

								$bid_count=$this->bidCount($user[0]->user_id,$membership_start,$membership_end);

							}

							else

							{

								$bid_count=$this->bidCount($user[0]->user_id,'','');

							}

							

							if($bid_count > $bid_plan_limit){

                                 $from=ADMIN_EMAIL;

								

								$to=$this->auto_model->getFeild('email','user','user_id',$user[0]->user_id);

								$fname=$this->auto_model->getFeild('fname','user','user_id',$user[0]->user_id);

								$lname=$this->auto_model->getFeild('lname','user','user_id',$user[0]->user_id);

								$template='bid_limit_notification';

								$data_parse=array('name'=>$fname." ".$lname

													);

								$this->auto_model->send_email($from,$to,$template,$data_parse);

                             }

							   

							

							

                            $data_notification=array(

                                "from_id" => $bid,

                                "to_id" => $project_user,

                                "notification" => htmlentities("<a href='".VPATH."clientdetails/showdetails/".$user[0]->user_id."'>".ucwords($bidder_fname." ".$bidder_lname)."</a> has been placed a bid on <a href='".VPATH."jobdetails/details/".$pid."/".$this->auto_model->getcleanurl($project_name)."/'>".ucwords($project_name)."</a>"),

                                "add_date" => date("Y-m-d"),
								
								"read_status" => 'N'                              

                            );                            

                            $this->db->insert("notification",$data_notification);

                        }

                        

		                    

                    

                }

		

            unset($_POST);

            echo json_encode($msg);                

         

    }

    

    public function post_question(){ 

            $attachment=$this->input->post("upload_file");

            

        

                $message=$this->input->post("message");



                $pid=$this->input->post("pid");

                $bid=$this->input->post("bid");

                $rid=$this->input->post("rid");



                $i=0;

        

		if($message==''){

			$msg['status']='FAIL';

			$msg['errors'][$i]['id']='message';

			$msg['errors'][$i]['message']="Please Enter Message";

			$i++;

		}

		

                

                if($i==0){

                    

			$data = array(

                            "project_id" =>$pid,

                            "recipient_id"=>$rid,

                            "sender_id" =>$bid,

                            "message"=>$message,

                            "attachment"=>$attachment,

                            "add_date"=> date("Y-m-d H:i:s")

                            

			);

			parent::insert("message", $data);

			if ($this->db->insert('message', $data)) {

                        $msg['status']='OK';    

			$msg['message']='Question posted successfully';

                        

			

			

			} else {

				$msg['status']='FAIL';

				$msg['errors'][$i]['id']='agree_terms';

				$msg['errors'][$i]['message']= 'dB error!';

			}                    

                    

                }

            unset($_POST);

            echo json_encode($msg);                

         

    }    

    

    

    

    public function getbid_details($pid, $srch=array()){ 

        $this->db->select("b.*, sum(r.average) as avg");        
		$this->db->from("bids b");
		$this->db->join("review r", "r.user_id=b.bidder_id", "LEFT");
		
		$this->db->where(array("b.project_id" => $pid));
		
		$this->db->group_by("b.bidder_id");
		if(!empty($srch['sort']) AND $srch['sort'] == 'bid'){
			$this->db->order_by('b.total_amt', $srch['sortval']);
		}else if(!empty($srch['sort']) AND $srch['sort'] == 'rating'){
			$this->db->order_by("avg", $srch['sortval']);
		}else{
			$this->db->order_by("b.id", "desc");
		}
		
		$data=array();
        $data = $this->db->get()->result_array();
	
        return $data;        

    }

    

  public function getrevised_details($uid,$pid){ 

 // echo $uid.",".$pid;

        $this->db->select("*");        

        $res=$this->db->get_where("bids",array("project_id" => $pid,"bidder_id" =>$uid));

        $data=array();

        foreach($res->result_array() as $row){ 

            $data[]=$row;

        }
		
		
		
        return $data;        

    }    

    

    public function isalreadypost($pid,$bid){ 

        $this->db->where('project_id',$pid);

        $this->db->where('bidder_id',$bid);

        $this->db->from('bids');        

       return $this->db->count_all_results();

    }

    

    public function getPostBidCount($uid){ 

        $this->db->where('bidder_id',$uid);

        $this->db->where('add_date >=',date('Y-m-d', strtotime('first day of this month')));

        $this->db->where('add_date <=',date('Y-m-d', strtotime('last day of this month')));

        $this->db->from('bids');     

        return $this->db->count_all_results();         

         

    }

	public function countComplete_client($user_id)

   {

		$this->db->select('project_id');

		$this->db->where('user_id',$user_id);

		$this->db->where('status','C');

		$this->db->from('projects');

		return $this->db->count_all_results();  

   } 

   public function insert_table($table,$data)

	{

		$this->db->insert($table,$data);               

		return $this->db->insert_id();	

	}

	public function bidCount($user_id,$start='',$end='')

	  {

			$this->db->select('id');

			$this->db->where('bidder_id',$user_id);

			if($start!='' && $end!='')

			{

				$this->db->where("add_date BETWEEN ".$start." AND ".$end."");

			}

			$this->db->from('bids');

			return $this->db->count_all_results();

	 }
	 
	 public function getProjectActivity($pid=''){
		 $this->db->select('*')
				->from('project_activity')
				->where('project_id', $pid);
		$res = $this->db->get()->result_array();
		if(count($res) > 0){
			foreach($res as $k => $v){
				$res[$k]['assigned_user'] = $this->_getActivityAssignedUser($v['id']);
			}
		}
		return $res;
	 }
	 
	 public function _getActivityAssignedUser($act_id=''){
		 $this->db->select('u.user_id,u.fname,u.lname,au.approved')
					->from('project_activity_user au')
					->join('user u', 'u.user_id=au.assigned_to', 'LEFT');
		$this->db->where('au.activity_id', $act_id);
		$result = $this->db->get()->result_array();
		return $result;
	 }
	 
	 
	public function getComments($project_id=''){
		$this->db->select('c.*')
			->from('project_comment pc')
			->join('comments c', 'c.comment_id=pc.comment_id');
			
		$this->db->where('pc.project_id', $project_id);
		$this->db->where('c.parent_id', '0');
		$result = $this->db->order_by('c.comment_id', 'DESC')->get()->result_array();
		if(count($result) > 0){
			foreach($result as $k => $v){
				$result[$k]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $v['user_id'])->get()->row_array();
				$result[$k]['comment_replies'] = $this->db->where('parent_id', $v['comment_id'])->get('comments')->result_array();
				
				if($result[$k]['comment_replies']){
					foreach($result[$k]['comment_replies'] as $key => $val){
						$result[$k]['comment_replies'][$key]['user_info'] = $this->db->select('fname,lname,logo')->from('user')->where('user_id', $val['user_id'])->get()->row_array();
					}
				}
			}
		}
		
		return $result;
	}

}

