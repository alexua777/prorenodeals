<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('get_project_deposit')){
	
	function get_project_deposit($project_id=''){
		
		$ci = &get_instance();
		
		$ci->db->select("p_txn.*, SUM(txn_row.credit) as total")
		->from("project_transaction p_txn")
		->join("transaction_row txn_row", "txn_row.txn_id=p_txn.txn_id AND wallet_id = ".ESCROW_WALLET);
		
		$ci->db->where('p_txn.project_id', $project_id);
		$result = $ci->db->get()->row_array();
		
		if(!empty($result['total'])){
			return $result['total'];
		}
		
		return 0;
	}
	
}

if(!function_exists('get_project_release_fund')){
	
	function get_project_release_fund($project_id=''){
		
		$ci = &get_instance();
		
		$ci->db->select("p_txn.*, SUM(txn_row.debit) as total")
		->from("project_transaction p_txn")
		->join("transaction_row txn_row", "txn_row.txn_id=p_txn.txn_id AND wallet_id = ".ESCROW_WALLET);
		
		$ci->db->where('p_txn.project_id', $project_id);
		$result = $ci->db->get()->row_array();
		
		if(!empty($result['total'])){
			return $result['total'];
		}
		
		return 0;
	}
	
}

if(!function_exists('get_project_pending_fund')){
	
	function get_project_pending_fund($project_id=''){
		
		$total_pending = 0;
		
		$ci = &get_instance();
		
		$ci->db->select("worker_id,hour,minute")
		->from("project_tracker_manual p_t_m")
		->where(array('p_t_m.project_id' => $project_id, 'p_t_m.payment_status <>' => 'P'));
		$result = $ci->db->get()->result_array();
		
		$ci->db->select("worker_id,hour,minute")
		->from("project_tracker p_t")
		->where(array('p_t.project_id' => $project_id, 'p_t.payment_status <>' => 'P'));
		$result2 = $ci->db->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$v['worker_id'])));
				
				$client_amt = $data['total_amt']; // hourly rate
				$minute_cost_min = ($client_amt/60); // minute rate
				$total_min_cost = $minute_cost_min *floatval($v['minute']);
				$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
				$total_pending += $total_cost_new;
			}
		}
		
		if($result2){
			foreach($result2 as $k => $v){
				$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$v['worker_id'])));
				$client_amt = $data['total_amt']; // hourly rate
				if($v['minute'] > 0){
					$minute_cost_min = ($client_amt/60);
					$total_min_cost = $minute_cost_min *floatval($v['minute']);
					$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
					
				}else{
					$seconds_new = 0;
					$days_new    = 0;
					$hours_new   = 0;
					$minutes_new = 0;
					$total_cost_new = 0;
					
					$seconds_new = strtotime($v['stop_time']) - strtotime($v['start_time']);
					$days_new    = floor($seconds_new / 86400);
					$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
					$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
					$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
					$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
					
				}
				
				$total_pending += $total_cost_new;
			}
		}
		
		
		
		return number_format($total_pending, 2);
	}
	
}


if(!function_exists('get_freelancer_payment')){
	
	function get_freelancer_payment($freelancer_id='' , $project_id='', $type=''){
		
		$ci = &get_instance();
		$payment = 0;
		if($type == 'pending'){
			
			$ci->db->select("worker_id,hour,minute")
			->from("project_tracker_manual p_t_m")
			->where(array('p_t_m.project_id' => $project_id, 'p_t_m.payment_status <>' => 'P', 'p_t_m.worker_id' => $freelancer_id));
			$result = $ci->db->get()->result_array();
			
			if($result){
				foreach($result as $k => $v){
					$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$v['worker_id'])));
					
					$client_amt = $data['total_amt']; // hourly rate
					$minute_cost_min = ($client_amt/60); // minute rate
					$total_min_cost = $minute_cost_min *floatval($v['minute']);
					$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
					$payment += $total_cost_new;
				}
			}
			
			$ci->db->select("worker_id,hour,minute")
			->from("project_tracker p_t")
			->where(array('p_t.project_id' => $project_id, 'p_t.payment_status <>' => 'P', 'p_t.worker_id' => $freelancer_id));
			$result2 = $ci->db->get()->result_array();
			
			if($result2){
			foreach($result2 as $k => $v){
				$data=get_row(array('select'=>'total_amt,pausedcontract','from'=>'bids', 'where'=>array('project_id'=>$project_id,'bidder_id'=>$v['worker_id'])));
				$client_amt = $data['total_amt']; // hourly rate
				
				if($v['minute'] > 0){
					$minute_cost_min = ($client_amt/60);
					$total_min_cost = $minute_cost_min *floatval($v['minute']);
					$total_cost_new=(($client_amt*floatval($v['hour']))+$total_min_cost);
					
				}else{
					$seconds_new = 0;
					$days_new    = 0;
					$hours_new   = 0;
					$minutes_new = 0;
					$total_cost_new = 0;
					
					$seconds_new = strtotime($v['stop_time']) - strtotime($v['start_time']);
					$days_new    = floor($seconds_new / 86400);
					$hours_new   = floor(($seconds_new - ($days_new * 86400)) / 3600);
					$minutes_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600))/60);
					$seconds_new = floor(($seconds_new - ($days_new * 86400) - ($hours_new * 3600) - ($minutes_new*60)));
					$total_cost_new=$client_amt*(($days_new*24)+$hours_new+$minutes_new/60);
					
				}
				
				$payment += $total_cost_new;
			}
		}
		
		
		}
	
		return $payment;
	}
	
}


if(!function_exists('is_bidder')){
	
	function is_bidder($freelancer_id='' , $project_id=''){
		
		$ci = &get_instance();
		$all_bidders = getField('bidder_id', 'projects', 'project_id', $project_id);
		$bidders_array = explode(',', $all_bidders);
		if(in_array($freelancer_id, $bidders_array)){
			return TRUE;
		}
		
		return FALSE;
	}
	
}

if(!function_exists('is_employer')){
	
	function is_employer($user_id='' , $project_id=''){
		
		$ci = &get_instance();
		$employer_id = getField('user_id', 'projects', 'project_id', $project_id);
		
		if($employer_id == $user_id){
			return TRUE;
		}
		return FALSE;
	}
	
}


if(!function_exists('get_project_min_day')){
	
	function get_project_min_day($date='' , $user_id='', $project_id=''){
		
		$ci = &get_instance();
		$ci->db->select('*');
		$ci->db->from('project_tracker p_t');
		$ci->db->where("DATE(p_t.start_time) = DATE('$date') AND p_t.stop_time <> '0000-00-00 00:00:00'");
		$ci->db->where("p_t.project_id", $project_id);
		if(!empty($user_id)){
			$ci->db->where("p_t.worker_id", $user_id);
		}
		
		$total_mins = 0;
		
		$result = $ci->db->get()->result_array();
		if($result){
			foreach($result as $k => $v){
				/* $start_time = strtotime($v['start_time']);
				$stop_time = strtotime($v['stop_time']);
				$total_mins += round(($stop_time - $start_time) / 60); */
				
				$hours_in_min = $v['hour'] * 60;
				$mins = $v['minute'];
				
				$total_mins += ($hours_in_min + $mins);
			}
			
			/* if($total_mins > 60){
				$hrs = round($total_mins/60);
				$mins = $total_mins % 60;
			}else{
				$mins = $total_mins;
			} */
		}
		
		
		return $total_mins;
	}
	
}

if(!function_exists('get_project_min_week')){
	
	function get_project_min_week($date='' , $user_id='', $project_id=''){
		$ci = &get_instance();
		
		$day_of_week = date('N', strtotime($date));

		$given_date = strtotime($date);

		$first_of_week =  date('Y-m-d', strtotime("- {$day_of_week} day", $given_date));

		$first_of_week = strtotime($first_of_week);
		
		$total_mins = 0;
		
		for($i=0 ;$i<=7; $i++) {
			$d = date('Y-m-d', strtotime("+ {$i} day", $first_of_week));
			$total_mins += get_project_min_day($d, $user_id, $project_id);
		}
		
		return $total_mins;

	}
	
}

if(!function_exists('get_project_all_minutes')){
	
	function get_project_all_minutes($user_id='', $project_id=''){
		
		$ci = &get_instance();
		$ci->db->select('*');
		$ci->db->from('project_tracker p_t');
		$ci->db->where("p_t.stop_time <> '0000-00-00 00:00:00'");
		$ci->db->where("p_t.project_id", $project_id);
		if(!empty($user_id)){
			$ci->db->where("p_t.worker_id", $user_id);
		}
		
		$total_mins = 0;
		
		$result = $ci->db->get()->result_array();
		
		if($result){
			foreach($result as $k => $v){
				/* $start_time = strtotime($v['start_time']);
				$stop_time = strtotime($v['stop_time']);
				$total_mins += round(($stop_time - $start_time) / 60); */
				
				$hours_in_min = $v['hour'] * 60;
				$mins = $v['minute'];
				
				$total_mins += ($hours_in_min + $mins);
				
			}
			
		}
		
		
		return $total_mins;
		

	}
	
}

