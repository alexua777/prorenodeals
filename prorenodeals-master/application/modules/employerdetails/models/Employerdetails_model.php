<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employerdetails_model extends BaseModel {

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
         
         
	 public function getuserskill($user_id){ 
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

}
