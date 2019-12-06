<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clientdetails_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }

         public function getskillsname($user_id){ 
             
             $skill_id= $this->getuserskill($user_id);
             
             if($skill_id){
             
            $skill_list=  explode(",",$skill_id[0]['skills_id']);
             
            $this->db->select("skill_name,id");
	    $this->db->where_in("id",$skill_list);
            $this->db->order_by("skill_name");
            $result=  $this->db->get("skills");
            
	       
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skill_name" => $val->skill_name,
             "id" => $val->id
		   );
		}  
                return $data;
             }  
             else{ 
                 return "";
                 
             }
         }
    
	public function getUserSkills($user_id=''){
		if($user_id == ''){
			return FALSE;
		}
		
		$this->db->select('ps.skill_name as parent_skill_name,s.skill_name as skill,s.skill_name,s.arabic_skill_name,s.spanish_skill_name,s.swedish_skill_name , ps.id as parent_skill_id , s.id as skill_id')
				->from('new_user_skill us')
				->join('skills ps' , 'ps.id=us.skill_id' , 'LEFT')
				->join('skills s' , 's.id=us.sub_skill_id' , 'INNER');
		$this->db->where('us.user_id' , $user_id);
		$result = $this->db->get()->result_array();
		return $result;
	}	 
	
         
	 public function getuserskill($user_id=''){ 
        $this->db->select("skills_id");
	    $result=$this->db->get_where("user_skills",array("user_id" =>$user_id));
	    if(count($result->result())>0){ 
		$data=array();
		foreach($result->result() as $val){ 
		   $data[]=array(		     
			 "skills_id" => $val->skills_id
		   );
		}
		return $data;
            }
            else{ 
               return "";
            }

	 }
	 
	 public function getSimilarUser($user_id)
	 {
		$skill_id= $this->getuserskill($user_id);
		$data=array();
		if($skill_id)
		{
			$skill_list=  explode(",",$skill_id[0]['skills_id']);
			
			$this->db->select('user_id,skills_id');
			$res=$this->db->get_where("user_skills",array("user_id !=" =>$user_id));
			
			foreach($res->result() as $row)
			{
				if($row->skills_id)
				{
					$sk=explode(",",$row->skills_id);
					if(count(array_intersect($skill_list,$sk))>0)
					{
						$data[]=array(
							"user_id"=>$row->user_id
						);	
					}	
				}	
			}
			
		}
		return $data;
			 
      }
         
         
 public function getportfolio($user_data,$limit = '10', $start = ''){
               
              $this->db->select("*");
              $this->db->order_by('id', "asc");
              $this->db->limit($limit, $start);
              $res= $this->db->get_where("user_portfolio",array("user_id" => $user_data));
             
              
              
             if(count($res->result())>0){ 
                $data=array();
                foreach($res->result() as $val){ 
                    $data[]=array(
                        "id" => $val->id,
                        "title" =>$val->title,
                        "description" =>$val->description,
                        "tags" =>$val->tags,
                        "url" =>$val->url,
                        "add_date" =>$val->add_date,
                        "original_img" => $val->original_img,
                        "status" => $val->status,
                        "thumb_img" => $val->thumb_img
                    );
                } 
                return $data;
             }
             else{ 
                 return "";
             }
          } 
		  
		  public function getReferences($user_id)
		  {
			$this->db->select();
			$this->db->where('user_id',$user_id);
			$this->db->order_by('add_date','desc');
			$res=$this->db->get_where('references',array('rating_status'=>'Y','admin_review'=>'Y'));
			$data=array();
			foreach($res->result() as $row)
			{
				$data[]=array(
				'id' => $row->id,
				'name' => $row->name,
				'company' => $row->company,
				'contact_name' =>$row->contact_name,
				'email' =>$row->email,
				'phone_no' =>$row->phone_no,
				'add_date' =>$row->add_date
				);	
			}
			return $data;	  
		}  
		
	public function insertMessage($data)
	{
		return $this->db->insert('message',$data);	
	}      
	
	public function get_total_earning($uid=''){
		$this->db->select_sum('amount' , 'amount')->from('transaction');
		$this->db->where(array('user_id' => $uid , 'transction_type' => 'CR' , 'status' => 'Y' , 'project_id > ' => '0'));
		$result = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return ($result['amount'] > 0 || !empty($result['amount'])) ? $result['amount'] : 0;
	}
	
	public function get_total_expenditure($uid=''){
		$this->db->select_sum('amount' , 'amount')->from('transaction');
		$this->db->where(array('user_id' => $uid , 'transction_type' => 'DR' , 'status' => 'Y' , 'project_id > ' => '0'));
		$result = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return ($result['amount'] > 0 || !empty($result['amount'])) ? $result['amount'] : 0;
	}

}
