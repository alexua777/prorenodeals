<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class payment_notify_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
    public function insertTransaction($data){          
        return $this->db->insert("transaction",$data);
    }
    
    public function updateUser($amount,$user_id){ 
        $data=array(
            "acc_balance" =>$amount
        );
        $this->db->where('user_id', $user_id);
         $this->db->update('user', $data); 
    }
	
	 }