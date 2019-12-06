<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_login_model extends BaseModel {

    function __construct() {
        $this->tableName = 'user';
		$this->column_name = 'username';
    }

	public function checkUser($username){
		$this->db->select($this->column_name);
		$this->db->from($this->tableName);
        $this->db->where('username', $username);
        $query = $this->db->get();
        $check = $query->num_rows();
		
		return $check;
	}
	
	public function generateUserName($fname=''){
		$seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
		shuffle($seed);
		$rand = '';
		foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];
		
		$unique_code = $rand;
		$username = $fname.'_'.$unique_code;
		while(!$this->checkUserName($username)){
			$this->generateUserName($fname);
		}
		
		return $username;
		
	}
	
	public function checkUserName($username=''){
		$count = $this->checkUser($username);
		
		if($count > 0){
			return false;
		}
		else{
			return true;
		}
	}
	

}
