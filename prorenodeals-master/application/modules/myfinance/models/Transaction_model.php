<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
	public function add_transaction($txn_type='', $user_id='', $status='', $inv_id=''){
		
		$txn_data = array(
			'txn_type' => $txn_type,
			'datetime' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'status' => !empty($status) ? $status : 'Y',
			'invoice_id' => !empty($inv_id) ? $inv_id : '0',
		
		);
		
		$ins = $this->db->insert('transaction_new', $txn_data);
		
		return $this->db->insert_id();
		
	}
	
	public function add_transaction_row($txn_data=array()){
		
		$txn_data = array(
			'txn_id' => !empty($txn_data['txn_id']) ? $txn_data['txn_id'] : 0,
			'wallet_id' => !empty($txn_data['wallet_id']) ? $txn_data['wallet_id'] : 0,
			'credit' => !empty($txn_data['credit']) ? $txn_data['credit'] : 0,
			'debit' => !empty($txn_data['debit']) ? $txn_data['debit'] : 0,
			'reference' => !empty($txn_data['ref']) ? $txn_data['ref'] : '',
			'datetime' => date('Y-m-d H:i:s'),
			'info' => !empty($txn_data['info']) ? $txn_data['info'] : '',
		
		);
		
		$ins = $this->db->insert('transaction_row', $txn_data);
		
		return $this->db->insert_id();
		
	}
	
}
