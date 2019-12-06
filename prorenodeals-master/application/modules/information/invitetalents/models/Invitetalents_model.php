<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class invitetalents_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
 public function gettalents($limit = '5', $start = '0',$userid=''){ 
     
        $this->db->select("user_id,fname,lname,reg_date,ldate,logo,hourly_rate,country,city,membership_plan,verify");
        
        $user=$this->session->userdata('user');        
        
        $uid = array($user[0]->user_id);
        $this->db->where_not_in('user_id', $uid);        
        
        $this->db->order_by("user_id");
        $this->db->limit($limit,$start);
        
        $res=$this->db->get_where("user",array("status"=>"Y"));
        
        $data=array();
        foreach($res->result() as $row){
            $data[]=array(
               "user_id" => $row->user_id,
               "fname" => $row->fname,
               "lname" => $row->lname,
               "reg_date" => $row->reg_date,
               "ldate" => $row->ldate,
               "logo" => $row->logo,
               "country" => $row->country, 
               "city" => $row->city,  
               "hourly_rate" => $row->hourly_rate,
               "membership_plan" => $row->membership_plan ,
			   "rating" => $this->dashboard_model->getrating($row->user_id),
			   "com_project" => $this->countComplete_professional($row->user_id),
			   "verify"=>$row->verify    
            );
        }
        
        return $data;
    }
	
	public function gettalents_count($userid=''){ 
 
	$this->db->select("user.user_id,user.fname,user.lname,user.reg_date,user.ldate,user.logo,user.hourly_rate,user.country,user.city,user.membership_plan,user.verify");
	$this->db->order_by("user_id");
	//$this->db->limit($limit,$start);
	//$this->db->join("user_skills","user.user_id=user_skills.user_id");
	//$this->db->where("user_skills.skills_id !=","");
	return $this->db->get_where("user",array("status"=>"Y"))->num_rows();
	
	
}

 public function gettalents_search($talent,$skill,$country){ 
     
        $this->db->select("user.user_id,user.fname,user.lname,user.reg_date,user.ldate,user.logo,user.hourly_rate,user.country,user.city,user.membership_plan,user.verify");
		$this->db->order_by("user.user_id");  
        
         
		$this->db->where("(fname LIKE '%$talent%' OR lname LIKE '%$talent%')");           
        
        if($country!="All"){ 
            $this->db->where("country",$country);
        }
		
        if($skill!="All"){ 
            $user =  $this->getskill_userlist($skill);
            $this->db->where_in("user.user_id",$user);
        }
        
        //$this->db->join("user_skills","user.user_id=user_skills.user_id");
		//$this->db->where("user_skills.skills_id !=","");
		$res=$this->db->get_where("user",array("status"=>"Y"));
        
     // echo $this->db->last_query(); die();
        
        $data=array();
        foreach($res->result() as $row){
            $data[]=array(
               "user_id" => $row->user_id,
               "fname" => $row->fname,
               "lname" => $row->lname,
               "reg_date" => $row->reg_date,
               "ldate" => $row->ldate,
               "logo" => $row->logo,
               "country" => $row->country,
               "city" => $row->city, 
               "hourly_rate" => $row->hourly_rate,
               "membership_plan" => $row->membership_plan,
			   "rating" => $this->dashboard_model->getrating($row->user_id),
			   "com_project" => $this->countComplete_professional($row->user_id),
			   "verify"=>$row->verify    
            );
        }
        
        return $data;
    }

    public function getFilertalent($skill,$country){
               $skill_id_list="";
               $user="";
               $this->db->select("user.user_id,user.fname,user.lname,user.reg_date,user.ldate,user.logo,user.hourly_rate,user.country,user.city,user.membership_plan,user.verify");
                if($skill!="All"){
                  $skill_id_list=$this->getskill_userlist($skill);
                  $this->db->where_in("user.user_id",$skill_id_list);
                }
                 	
		if($country!='All')
		{
			$this->db->where('country',$country);
		}
		
		$data=array();
                //if($country!='All' || $skill!='All' && count($skill_id_list)>0){ 
                    $this->db->order_by("user.user_id");
					//$this->db->join("user_skills","user.user_id=user_skills.user_id");
					//$this->db->where("user_skills.skills_id !=","");
                    $res=$this->db->get_where('user',array('status'=>'Y'));
					
                    $data=array();
                    foreach($res->result() as $row){
                        $data[]=array(
                           "user_id" => $row->user_id,
                           "fname" => $row->fname,
                           "lname" => $row->lname,
                           "reg_date" => $row->reg_date,
                           "ldate" => $row->ldate,
                           "logo" => $row->logo,
                           "country" => $row->country, 
                            "city" => $row->city, 
                           "hourly_rate" => $row->hourly_rate,
                           "membership_plan" => $row->membership_plan,
						   "rating" => $this->dashboard_model->getrating($row->user_id),
						   "com_project" => $this->countComplete_professional($row->user_id),
						    "verify"=>$row->verify     
                        );
                    }
                    
                    
                //}
                

		return $data;
	}   
    
        
       public function getFilertalentCount($skill,$country){
               $skill_id_list="";
               $this->db->select("user.user_id,user.fname,user.lname,user.reg_date,user.ldate,user.logo,user.hourly_rate,user.country,user.city,user.membership_plan,user.verify");
               
               if($skill!="All"){
                  $skill_id_list=$this->getskill_userlist($skill);   
                  $this->db->where_in("user.user_id",$skill_id_list);
                }
                
		if($country!='All')
		{
			$this->db->where('country',$country);
		}
		
                
                $this->db->order_by("user.user_id");
		//$this->db->join("user_skills","user.user_id=user_skills.user_id");
		//$this->db->where("user_skills.skills_id !=","");		
		$res=$this->db->get_where('user',array('status'=>'Y'));
		
		return $res->num_rows();   
	}   
    
        
       public function getFilertalentSearchCount($talent,$skill,$country){
               $skill_id_list="";
              $this->db->select("user.user_id,user.fname,user.lname,user.reg_date,user.ldate,user.logo,user.hourly_rate,user.country,user.city,user.membership_plan,user.verify");
            //$this->db->join("user_skills","user.user_id=user_skills.user_id");
			//$this->db->where("user_skills.skills_id !=","");   
            $this->db->where("(fname LIKE '%$talent%' OR lname LIKE '%$talent%')");            
               
               if($skill!="All"){
                  $skill_id_list=$this->getskill_userlist($skill);   
                  $this->db->where_in("user.user_id",$skill_id_list);
                }
                
		if($country!='All')
		{
			$this->db->where('country',$country);
		}
                
        $this->db->order_by("user.user_id");
		$res=$this->db->get_where('user',array('status'=>'Y'));
		
		return $res->num_rows();   
	}           
        
        
        
        
        
   public function getskill_userlist($skill_id){ 
       $data=array();
       if($skill_id!="All"){
	   		$skills=explode(",",$skill_id); 
			foreach($skills as $key=>$val)
			{
           		$user =$this->db->query("SELECT user_id FROM serv_user_skills WHERE FIND_IN_SET('".$val."',skills_id)");
        
				foreach($user->result() as $u){ 
					$data[]=$u->user_id;
				}
			}
			if(count($data)==0){ 
				$data[0]=0;
			}
           
       }
       else{ 
           $data[0]=0;
       }
       
		//print_r($data);die;
        return $data;
    }
   
   public function countComplete_professional($user_id)
   {
		$this->db->select('project_id');
		$this->db->where('bidder_id',$user_id);
		$this->db->where('status','C');
		$this->db->from('projects');
		return $this->db->count_all_results();  
   }     
        
   public function insertInvite($data){ 
       $this->db->insert("inviteprivate_project",$data);
   }
   public function insertInviteGuest($data){ 
       $this->db->insert("invite_friend",$data);
   }   
   
   
   
   
  
}