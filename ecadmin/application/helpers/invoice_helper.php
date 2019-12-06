<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('create_invoice')){
	
	// function definition here 
	
	function create_invoice($data=array()){
		
		if(empty($data['receiver_id'])){
			die('Invalid input data');
		}
		
		$invoice = array(
			'invoice_number' => getInvoiceNumber(),
			'invoice_type' => !empty($data['invoice_type']) ? $data['invoice_type'] : 1,
			'sender_id' => $data['sender_id'],
			'receiver_id' =>  $data['receiver_id'],
			'sender_information' => !empty($data['sender_information']) ? $data['sender_information'] : '',
			'receiver_information' => !empty($data['receiver_information']) ? $data['receiver_information'] : '',
			'receiver_email' =>!empty($data['receiver_email']) ? $data['receiver_email'] : getUserEmail($data['receiver_id']),
			'invoice_date' => date('Y-m-d'),
		
		
		);
		$ci = &get_instance();
		$ci->db->insert('invoice_main', $invoice);
		$invoice_id = $ci->db->insert_id();
		
		updateInvoiceNumber();
		return $invoice_id;
	}
	
}

if(!function_exists('create_quick_invoice')){
	
	// function definition here 
	
	function create_quick_invoice($sender_id='', $receiver_id='', $type=1, $receiver_email=''){
		
		$data = array();
		if(empty($receiver_id)){
			die('Invalid input data');
		}
		
		if($sender_id == 0){
			
			$sender_info = array(
				'name' => SITE_TITLE,
				'address' => ADMIN_ADDRESS,
			);
			
		}else{
			
			$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $sender_id)));
			
			$sender_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($user_info['user_id']),
			);
			
		}
		
		if($receiver_id == 0){
			
			$receiver_info = array(
				'name' => SITE_TITLE,
				'address' => ADMIN_ADDRESS,
			);
			
		}else{
			
			$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $sender_id)));
			
			$receiver_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($user_info['user_id']),
			);
			
		}
		
		$sender_information = json_encode($sender_info);
		$receiver_information = json_encode($receiver_info);
		
		$data['invoice_type'] = $type;
		$data['sender_id'] = $sender_id;
		$data['receiver_id'] = $receiver_id;
		$data['sender_information'] = $sender_information;
		$data['receiver_information'] = $receiver_information;
		$data['receiver_email'] = $receiver_email;
	
		
		$invoice = array(
			'invoice_number' => getInvoiceNumber(),
			'invoice_type' => !empty($data['invoice_type']) ? $data['invoice_type'] : 1,
			'sender_id' => $data['sender_id'],
			'receiver_id' =>  $data['receiver_id'],
			'sender_information' => !empty($data['sender_information']) ? $data['sender_information'] : '',
			'receiver_information' => !empty($data['receiver_information']) ? $data['receiver_information'] : '',
			'receiver_email' =>!empty($data['receiver_email']) ? $data['receiver_email'] : getUserEmail($data['receiver_id']),
			'invoice_date' => date('Y-m-d'),
		
		
		);
		$ci = &get_instance();
		$ci->db->insert('invoice_main', $invoice);
		$invoice_id = $ci->db->insert_id();
		
		updateInvoiceNumber();
		return $invoice_id;
	}
	
}

if(!function_exists('add_invoice_row')){
	
	// function definition here 
	
	function add_invoice_row($data=array()){
		
		if(empty($data['invoice_id']) || empty($data['per_amount']) || empty($data['description'])){
			return FALSE;
		}
		
		$inv_row_array = array(
			'invoice_id' => $data['invoice_id'],
			'description' => $data['description'],
			'quantity' => !empty($data['quantity']) ? $data['quantity'] : 1,
			'per_amount' => $data['per_amount'],
			'unit' => !empty($data['unit']) ? $data['unit'] : 'Fixed',
		);
		$ci = &get_instance();
		$ci->db->insert('invoice_row', $inv_row_array);
		return $ci->db->insert_id();
	}
	
}

if(!function_exists('add_quick_invoice_row')){
	
	// function definition here 
	
	function add_quick_invoice_row($invoice_id='', $dscr='', $per_amount=0, $quantity=1, $unit='-'){
		
		if(empty($invoice_id) || empty($per_amount) || empty($dscr)){
			return FALSE;
		}
		
		$data['invoice_id'] = $invoice_id;
		$data['description'] = $dscr;
		$data['quantity'] = $quantity;
		$data['per_amount'] = $per_amount;
		$data['unit'] = $unit;
		
		$inv_row_array = array(
			'invoice_id' => $data['invoice_id'],
			'description' => $data['description'],
			'quantity' => !empty($data['quantity']) ? $data['quantity'] : 1,
			'per_amount' => $data['per_amount'],
			'unit' => !empty($data['unit']) ? $data['unit'] : 'Fixed',
		);
		$ci = &get_instance();
		$ci->db->insert('invoice_row', $inv_row_array);
		return $ci->db->insert_id();
	}
	
}

if(!function_exists('add_project_invoice')){
	
	// function definition here 
	
	function add_project_invoice($project_id='', $invoice_id=''){
		$ins = array(
			'project_id' => $project_id,
			'invoice_id' => $invoice_id,
		);
		$ci = &get_instance();
		return $ci->db->insert('project_invoice', $ins);
		
	}
	
}

if(!function_exists('getInvoiceNumber')){
	
	// function definition here 
	
	function getInvoiceNumber(){
		$invoice_auto_number = getField('value', 'invoice_number', 'key', 'invoice');
		$invoice_number = str_pad($invoice_auto_number, 10, "0", STR_PAD_LEFT);
		
		return $invoice_number;
		
	}
	
}

if(!function_exists('getUserEmail')){
	
	// function definition here 
	
	function getUserEmail($user_id=''){
		$email = getField('email', 'user', 'user_id', $user_id);
		
		return $email;
		
	}
	
}


if(!function_exists('updateInvoiceNumber')){
	
	// function definition here 
	
	function updateInvoiceNumber(){
		$ci = &get_instance();
		$ci->db->set('value', 'value + 1', FALSE);
		$ci->db->where('key', 'invoice');
		return $ci->db->update('invoice_number');
		
	}
	
}


if(!function_exists('getUserAddress')){
	
	// function definition here 
	
	function getUserAddress($user_id=''){
		$user_info = get_row(array('select' => 'city,country','from' => 'user', 'where' => array('user_id' => $user_id)));
		$user_city = getField('Name','city','ID',$user_info['city']); 
		$user_country = getField('Name','country','Code',$user_info['country']); 	
		$address = '';
		if(!empty($user_city)){
			$address .= $user_city.', ';
		}
		if(!empty($user_country)){
			$address .= $user_country;
		}
		
		return rtrim($address, ',');
	}
	
}


