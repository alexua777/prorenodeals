<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transaction_model extends BaseModel {

    public function __construct() {
        return parent::__construct();
    }
    
	public function add_transaction($txn_type='', $user_id='', $status=''){
		
		$txn_data = array(
			'txn_type' => $txn_type,
			'datetime' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'status' => !empty($status) ? $status : 'Y',
		
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
	
	public function approveTransaction($txn_id=''){
		$this->db->where('txn_id', $txn_id)->update('transaction_new', array('status' => 'Y'));
		$this->_updateTransactionBalance($txn_id);
	}
	
	public function denyTransaction($txn_id=''){
		$this->db->where('txn_id', $txn_id)->update('transaction_new', array('status' => 'N'));
	}
	
	private function _updateTransactionBalance($txn_id=''){
		$txn_row = $this->db->where('txn_id', $txn_id)->get('transaction_row')->result_array();
		if($txn_row){
			foreach($txn_row as $k => $v){
				$cmd = '';
				if($v['debit'] == '0.00'){
					$cmd = 'credit';
				}
				if($v['credit'] == '0.00'){
					$cmd = 'debit';
				}
				$wallet_id = $v['wallet_id'];
				
				if($cmd && $cmd == 'credit'){
					wallet_add_fund($wallet_id, $v['credit']);
				}
				
				if($cmd && $cmd == 'debit'){
					wallet_less_fund($wallet_id, $v['debit']);
				}
				
				check_wallet($wallet_id, $txn_id);
				
			}
		}
	}
	
	public function getWithdrawAmount($txn_id=''){
		$txn_row = $this->db->where('txn_id', $txn_id)->get('transaction_row')->row_array();
		if(!empty($txn_row['debit'])){
			return $txn_row['debit'];
		}
		
		return 0;
	}
	
}
