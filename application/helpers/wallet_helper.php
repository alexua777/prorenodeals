<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('check_wallet')){
	
	// function defination here 
	
	function check_wallet($wallet_id='',  $txn_id='0'){
		
		$ci = &get_instance();
		
		$res = $ci->db->select("(sum(t.credit) - sum(t.debit)) as balance")
			->from('transaction_row t')
			->join('transaction_new tn', 'tn.txn_id=t.txn_id', 'LEFT')
			->where('t.wallet_id', $wallet_id)
			->where('tn.status', 'Y')
			->get()->row_array();
		
		$txn_balance = $res['balance'];
		
		$wallet_balance = getField('balance', 'wallet', 'wallet_id', $wallet_id);
		
		if($wallet_balance != $txn_balance){
			
			$notification = 'Wallet Error ! Wallet ID # : '.$wallet_id.' after transaction #' . $txn_id;
			
			error_log($notification);
			
			notify_admin($notification);
			
			
		}
		
		
	}
	
}

if(!function_exists('getField')){
	
	// function defination here 
	
	function getField($field='', $table='', $where='', $where_val=''){
		
		$ci = &get_instance();
		
		$res = $ci->db->select($field)
			->from($table)
			->where($where, $where_val)
			->get()->row_array();
		
		if($res[$field]){
			return $res[$field];
		}
		
		return TRUE;
		
	}
	
}


if(!function_exists('notify_admin')){
	
	// function definition here 
	
	function notify_admin($msg=''){
		
		$ci = &get_instance();
		
		return $ci->db->insert('admin_notification', array('description' => $msg, 'date' => date('Y-m-d')));
		
	}
	
}



if(!function_exists('update_wallet_balance')){
	
	// function defination here 
	
	function update_wallet_balance($wallet_id='', $amount=''){
		
		$ci = &get_instance();
		
		return $ci->db->where('wallet_id', $wallet_id)->update('wallet', array('balance' => $amount));
		
	}
	
}

if(!function_exists('get_user_wallet')){
	
	// function return the wallet id of a given user 
	// @param user_id
	
	function get_user_wallet($user_id=''){
		
		$wallet_id = getField('wallet_id', 'wallet', 'user_id', $user_id);
		
		return $wallet_id;
		
	}
	
}

if(!function_exists('wallet_add_fund')){
	
	// function add fund from wallet
	// @param wallet_id AND amount
	
	function wallet_add_fund($wallet_id='', $amount=''){
		
		$prev_balance = getField('balance', 'wallet', 'wallet_id', $wallet_id);
		
		$new_bal = $prev_balance + $amount;
		
		update_wallet_balance($wallet_id, $new_bal);
		
	}
	
}


if(!function_exists('wallet_less_fund')){
	
	// function less fund from wallet
	// @param wallet_id AND amount
	
	function wallet_less_fund($wallet_id='', $amount=''){
		
		$prev_balance = getField('balance', 'wallet', 'wallet_id', $wallet_id);
		
		$new_bal = $prev_balance - $amount;
		
		update_wallet_balance($wallet_id, $new_bal);
		
	}
	
}

if(!function_exists('get_wallet_balance')){
	
	// function return the wallet balance of a given wallet
	// @param wallet_id
	
	function get_wallet_balance($wallet_id=''){
		
		$balance = getField('balance', 'wallet', 'wallet_id', $wallet_id);
		
		return $balance;
		
	}
	
}