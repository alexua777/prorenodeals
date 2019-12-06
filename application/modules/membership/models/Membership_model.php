<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Membership_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function getplan(){ 
        $this->db->select("*");
        $this->db->order_by('id');
        $res=$this->db->get_where("membership_plan",array("status"=>"Y"));
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "name" => $val->name,
				"project" => $val->project,
                "bids" => $val->bids,
                "skills" => $val->skills,
                "portfolio" => $val->portfolio,
                "price" => $val->price,
                "default_plan" => $val->default_plan,
                "days" => $val->days
            );
        }
        return $data;
    }
    
    public function getPlaneDetails($plane_name){ 
        $this->db->select("*");
        $this->db->order_by('id');
        $res=$this->db->get_where("membership_plan",array("status"=>"Y","name"=>$plane_name));
        $data=array();
        
        foreach($res->result() as $val){ 
            $data[]=array(
                "id" => $val->id,
                "name" => $val->name,
				"project" => $val->project,
                "bids" => $val->bids,
                "skills" => $val->skills,
                "portfolio" => $val->portfolio,
                "price" => $val->price,
                "default_plan" => $val->default_plan,
                "days" => $val->days
            );
        }
        return $data;        
               
    }
    
    public function insertTransaction($data){ 
        return $this->db->insert("transaction",$data);
    }

    public function updateUser($data,$user_id){ 
        $this->db->where('user_id', $user_id);
        $this->db->update('user', $data);
    }    
    
}
