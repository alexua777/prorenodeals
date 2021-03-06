<?php



if (!function_exists('get_user')) {



    function get_user($id = '') {

        $CI = & get_instance();

        $user = new stdClass();

        $user->id = 0;

        if ($CI->session->userdata('user'))

            $user = $CI->session->userdata('user');

        return $user;

    }



}



function pre($data, $exit = false)

{

    echo "<br />";

    print_r($data);

    if(!$exit)

        die();

}





if(!function_exists('__')){

	

	function __($key='', $default_val=''){

		$ci = &get_instance();

		

		$line = $ci->lang->line($key, FALSE);

		if($line){

			return $line;

		}

		

		return $default_val;

	}

	

}





if(!function_exists('filter_data')){

	

	

	function filter_data($data=array()){

		

		if(is_array($data)){

			$return = array();

			foreach($data as $k => $v){

				

				if(!is_array($v)){

					$return[$k] = htmlentities($v);

				}

				

			}

			

			return $return;

		}else{

			return  htmlentities($data);

		}

	

	}

	

}



if(!function_exists('get_earned_amount')){

	

	

	function get_earned_amount($user_id=''){

		if(!$user_id){

			die("Invalid parameter");

		}

		$earned_amount = 0;

		$user_wallet_id = get_user_wallet($user_id);

		$ci = &get_instance();

		$ci->db->select("sum(txn_r.credit) as total_credit")

				->from("transaction_new txn")

				->join("project_transaction p_txn", "p_txn.txn_id=txn.txn_id")

				->join("transaction_row txn_r", "txn_r.txn_id=txn.txn_id")

				->where(array("txn.status" => "Y", "txn_r.wallet_id" => $user_wallet_id));

		$result = $ci->db->get()->row_array();

		

		if(!empty($result['total_credit'])){

			$earned_amount = $result['total_credit'];

		}

		

		return str_replace(',', '', number_format($earned_amount, 2)) ;

	}

	

}



if(!function_exists('get_project_spend_amount')){

	

	

	function get_project_spend_amount($user_id=''){

		if(!$user_id){

			die("Invalid parameter");

		}

		$spend_amount = 0;

		$ci = &get_instance();

		$projects = $ci->db->dbprefix('projects');

		$user_wallet_id = get_user_wallet($user_id);

		

		$ci->db->select("sum(txn_r.debit) - sum(txn_r.credit) as total_spend")

				->from("transaction_new txn")

				->join("project_transaction p_txn", "p_txn.txn_id=txn.txn_id")

				->join("transaction_row txn_r", "txn_r.txn_id=txn.txn_id")

				->where(array("txn.status" => "Y", "txn_r.wallet_id" => $user_wallet_id));

			$ci->db->where("p_txn.project_id IN (select project_id from $projects where user_id = $user_id)");

		$result = $ci->db->get()->row_array();

	

		if(!empty($result['total_spend'])){

			$spend_amount = $result['total_spend'];

		}

		return str_replace(',', '', number_format($spend_amount, 2)) ;

	}

	

}



if(!function_exists('get_total_bids')){

	

	

	function get_total_bids($user_id=''){

		if(!$user_id){

			die("Invalid parameter");

		}



		$ci = &get_instance();

		$count = $ci->db->where("bidder_id", $user_id)->count_all_results('bids');

		return $count;

	}

	

}





if(!function_exists('get_total_project_post')){

	

	

	function get_total_project_post($user_id=''){

		if(!$user_id){

			die("Invalid parameter");

		}

	

		$ci = &get_instance();

		$count = $ci->db->where("user_id", $user_id)->count_all_results('projects');

		return $count;

	}

	

}





if(!function_exists('get_freelancer_project')){

	

	

	function get_freelancer_project($user_id='', $status='C'){

		if(!$user_id){

			die("Invalid parameter");

		}

			

		$count = 0;

		

		$ci = &get_instance();

		if($status=='C'){

			$count = $ci->db->where("FIND_IN_SET('$user_id', bidder_id) AND (status = 'C' OR FIND_IN_SET('$user_id', ended_contractor))")->count_all_results('projects');

		}

		

		return $count;

	}

	

}





if(!function_exists('get_available_bids')){

	

	

	function get_available_bids($user_id='', $free=FALSE){

		

		$total_free_bid_month = getField('free_bid_per_month', 'setting', 'id', 1);

		

		$used_free_bid = get_used_bids($user_id, TRUE);

		$available_free_bid = $total_free_bid_month - $used_free_bid;

		

		if($free){

			$available_bids = $available_free_bid;

		}else{

			

			$available_purchase_bid = getField('available_bids', 'user', 'user_id', $user_id);

			$available_bids = $available_free_bid + $available_purchase_bid;

			

		}

		

		

		return $available_bids;

		

	}

	

}





if(!function_exists('get_used_bids')){

	

	

	function get_used_bids($user_id='', $free=FALSE){

		$date = date('n'); // current month

		$year = date('Y'); // current year

		$ci = &get_instance();

		$row_count = $ci->db->where("MONTH(add_date) = $date AND YEAR(add_date) = $year AND bidder_id = $user_id")->count_all_results('bids');

		

		if($free){

			

			$total_free_bid_month = getField('free_bid_per_month', 'setting', 'id', 1);

			if($row_count > $total_free_bid_month){

				$row_count =  $total_free_bid_month;

			}

		}

		

		return $row_count;

	}

	

}





if(!function_exists('update_user_bids')){

	

	

	function update_user_bids($user_id='', $bids=0){

		$ci = &get_instance();

		$ci->db->set('available_bids', 'available_bids + '.$bids, FALSE);

		$ci->db->where('user_id', $user_id);

		return $ci->db->update('user');

	}

	

}





if(!function_exists('format_money')){

	function format_money($amount=0, $use_seperator=FALSE){

		if(!is_numeric($amount)){

			$amount = 0;

		}
		if($use_seperator){
			return number_format($amount, 2);
		}else{
			return str_replace(',', '', number_format($amount, 2));
		}
		

	}

	

}



if(!function_exists('create_pagging')){
	
	
	function create_pagging($nconfig){
		$ci = &get_instance();
		$ci->load->library('pagination');
		$config['base_url'] = $nconfig['base_url'];
		
		$config['page_query_string'] = TRUE;
		$config['total_rows'] =  $nconfig['total_rows'];
		$config['per_page'] = $nconfig['per_page'];
		if($nconfig['use_page_numbers']){
			$config['use_page_numbers'] = TRUE;
		}
		
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = __('pagination_first','First');
		$config['first_tag_open'] = '<li class="waves-effect">';
		$config['first_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li class="waves-effect">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = '</a></li>';
		$config['last_link'] = __('pagination_last','Last');;
		$config['last_tag_open'] = "<li class='last waves-effect'>";
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<i class="zmdi zmdi-chevron-right"></i>';
		$config['next_tag_open'] = '<li class="waves-effect">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="zmdi zmdi-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="waves-effect">';
		$config['prev_tag_close'] = '</li>'; 
		
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
	
}


if(!function_exists('get_all_country')){
	
	
	function get_all_country(){
		$ci = &get_instance();
		$country_list = $ci->autoload_model->getCountry();
		return $country_list;
	}
	
}

if(!function_exists('get_country_city')){
	
	
	function get_country_city($country_code=''){
		$ci = &get_instance();
		$city_list = $ci->db->select('ID as city_id,Name as name')
			->from('city')
			->where('CountryCode', $country_code)
			->get()->result_array();
			
		return $city_list;
	}
	
}

if(!function_exists('get_city_country')){
	
	
	function get_city_country($city_id='', $code=TRUE){
		$country = '';
		
		if($code){
			$country =  getField('CountryCode', 'city', 'ID', $city_id);
		}else{
			$code =  getField('CountryCode', 'city', 'ID', $city_id);
			$country = getField('Name', 'country', 'Code', $code);
		}
		return $country;
	}
	
}

if(!function_exists('replace_email')){
	
	
	function replace_email($str=''){
		$str = trim($str);
		if(strlen($str) == 0){
			return $str;
		}
		
		$email_pattern = '/[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/';
		
		$replace_str = preg_replace($email_pattern, 'xxxxxxxxxxxx',$str);
		return $replace_str;
		
	}
	
}

if(!function_exists('replace_phone')){
	
	
	function replace_phone($str=''){
		$str = trim($str);
		if(strlen($str) == 0){
			return $str;
		}
		
		$phone_pattern = '/(\+?[\d-\(\)\s]{7,}?\d)/';
		
		$replace_str = preg_replace($phone_pattern, 'xxxxxxxxxxxx',$str);
		return $replace_str;
		
	}
	
}


if(!function_exists('print_select_option')){
	
	
	function print_select_option($array=array(), $value='', $name='', $selected=''){
		if(count($array) > 0){
			
			if(!empty($value) && !empty($name)){
				
				foreach($array as $k => $v){
					$select = '';
					
					if(!empty($selected)){
						if($selected == $v[$value]){
							$select = 'selected';
						}
					}
					if($select){
						echo  '<option value="'.$v[$value].'" '.$select.'>'.$v[$name].'</option>';
					}else{
						echo  '<option value="'.$v[$value].'">'.$v[$name].'</option>';
					}
					
				
				}
			
			}else{
				
				foreach($array as $k => $v){
					if(!is_array($v)){
						
						$select = '';
						if(!empty($selected)){
							if($selected == $v){
								$select = 'selected';
							}
						}
						if($select){
							echo  '<option value="'.$v.'" '.$select.'>'.$v.'</option>';
						}else{
							echo  '<option value="'.$v.'">'.$v.'</option>';
						}
						
					}
					
				
				}
				
			}
			
		}
		
	}
	
}

if(!function_exists('print_select_option_assoc')){
	
	
	function print_select_option_assoc($array=array(),  $selected=''){
		if(count($array) > 0){
			
			foreach($array as $k => $v){
				$select = '';
				
				if(!empty($selected)){
					if($selected == $k){
						$select = 'selected';
					}
				}
				if($select){
					echo  '<option value="'.$k.'" '.$select.'>'.$v.'</option>';
				}else{
					echo  '<option value="'.$k.'">'.$v.'</option>';
				}
				
			
			}
			
		}
		
	}
	
}

if(!function_exists('get_k_value_from_array')){
	
	
	function get_k_value_from_array($array=array(), $key_name=''){
		$val = array();
		if(count($array) > 0){
			foreach($array as $k => $v){
				if(is_array($v)){
					$val[] = $v[$key_name];
				}
				
			}
		}
		
		return $val;
		
	}
	
}

if(!function_exists('generate_token')){
	
	
	function generate_token($key, $salt=''){
		$token = md5($key.'-'.date('Y-m-d').'-'.$salt);
		return $token;
		
	}
	
}

if(!function_exists('verify_token')){
	
	
	function verify_token($key, $salt='', $token=''){
		if(!VERIFY_TOKEN){
			return TRUE;
		}else{
			
			$ver_token = md5($key.'-'.date('Y-m-d').'-'.$salt);
			if($token == $ver_token){
				return TRUE;
			}
			
			return FALSE;
		}
		
		
	}
	
}

if(!function_exists('get_user_rating')){
	
	
	function get_user_rating($user_id=''){
		$ci = &get_instance();
		$ci->load->model('dashboard/dashboard_model');
		$rating = $ci->dashboard_model->getrating_new($user_id);
		$avg_rating=round($rating[0]['avg']/$rating[0]['num'], 1);
		if(is_nan($avg_rating)){
			$avg_rating = 0;
		}
		return $avg_rating;
		
	}
	
}


if(!function_exists('get_country_flag')){
	
	
	function get_country_flag($country_code=''){
		$flag=getField("code2","country","Code",$country_code);
		$flag =  strtolower($flag).".png";
		$flag_file = ASSETS.'images/cuntryflag/'.$flag;

		return $flag_file;
		
	}
	
}

if(!function_exists('get_country_name')){
	
	
	function get_country_name($country_code=''){
		$name=getField("Name","country","Code",$country_code);
		
		return $name;
		
	}
	
}

if(!function_exists('get_city_name')){
	
	
	function get_city_name($city_id=''){
		$name=getField("Name","city","ID",$city_id);
		
		return $name;
		
	}
	
}


if(!function_exists('get_user_logo')){
	
	
	function get_user_logo($user_id=''){
		$logo = getField("logo","user","user_id",$user_id);
		if($logo != ''){
			if(file_exists('assets/uploaded/cropped_'.$logo)){
				$logo = ASSETS.'uploaded/cropped_'.$logo;
			}else if(file_exists('assets/uploaded/'.$logo)){
				$logo = ASSETS.'uploaded/'.$logo;
			}else{
				$logo = ASSETS.'images/user.png';
			}
		}else{
			$logo = ASSETS.'images/user.png';
		}
		
		return $logo;
	}
	
}

if(!function_exists('get_user_cover_photo')){
	
	
	function get_user_cover_photo($user_id=''){
		$bg_pic= getField("profile_bg_pic","user","user_id",$user_id);
		$bg_full_path = ASSETS.'images/default-bg.png';
		
		if(!empty($bg_pic)){
			if(file_exists('assets/uploaded/bgcropped_'.$bg_pic)){
				$bg_full_path = ASSETS.'uploaded/bgcropped_'.$bg_pic;
			}else if(file_exists('assets/uploaded/'.$bg_pic)){
				$bg_full_path = ASSETS.'uploaded/'.$bg_pic;
			}

		}
		
		return $bg_full_path;

	}
	
}

if(!function_exists('is_online_user')){
	
	
	function is_online_user($time=''){
		$status=((time()-60) > $time)?false:true;
		return $status;
	}
	
}

if(!function_exists('check_user_log')){
	
	
	function check_user_log(){
		$ci = &get_instance();
		$ci->load->helper('url');
		$user = $ci->session->userdata('user');
		if(!$user){
			$ref = uri_string();
			$get = get();
			if($get){
				$ref .= '?'.http_build_query($get);
			}
			$ref = urlencode($ref);
			redirect(base_url('login?refer='.$ref));
		}
		
	}
	
}


if(!function_exists('get_month')){
	
	function get_month($type=''){
		
		/*
			type : option, array (default)
		*/
		
		$month_arr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		if($type == 'option'){
			$html = '';
			foreach($month_arr as $k => $v){
				$html .= '<option value="'.$v.'">'.$v.'</option>';
			}
			return $html;
		}
		
		return $month_arr;
		
	}
	
}



if(!function_exists('project_start_on')){
	
	function project_start_on($type=''){
		
		
		
		$start_date  = array(						
			'tomorrow' => 'Tomorrow',						
			'less_than_1_month' => 'Less than 1 month',						
			'in_1_2_month' => '1-2 month',						
			'more_than_2_month' => 'More than two month',					
		);	
	
		
		if($type){
			$type = trim($type);
		}
		
		if($type && !empty($start_date[$type])){
			return $start_date[$type];
		}
		
		return $start_date;
	}
	
}

if(!function_exists('date_crossed')){
	
	function date_crossed($date=''){
		$today = strtotime(date('Y-m-d'));
		if($today > strtotime($date)){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
}

if(!function_exists('is_fav')){
	
	
	function is_fav($object_id='', $type='', $user_id=''){
		$ci = &get_instance();
		$where = array(
			'object_id' => $object_id,
			'type' => $type,
			'user_id' => $user_id,
		);
		$count = (bool) $ci->db->where($where)->count_all_results('favorite');
		return $count;
	}
	
}

if(!function_exists('make_payment')){
	
	
	function make_payment($price='', $user_id='', $txn_type=''){
		$ci = &get_instance();
		$ci->load->helper('wallet');
		$ci->load->helper('invoice');
		$user_wallet_id = get_user_wallet($user_id);
		$balance = get_wallet_balance($user_wallet_id);
		$payment_info = array(
			FEATURED_PROFILE_PAYMENT => 'Profile Featured',
			BID_PURCHASE => 'Bid Purchase',
			PROJECT_FEATURED => 'Project Featured',
		);
		
		$invoice_info  = array(
			FEATURED_PROFILE_PAYMENT => 'Profile Featured',
			BID_PURCHASE => 'Bid Purchase',
			PROJECT_FEATURED => 'Project Featured',
		);
		
		if($price > $balance){
			
			$data['status'] = 'INSUFFICIENT_BALANCE';
			$data['amount_diff'] = $price - $balance;
			
		}else{
			$ci->load->model('myfinance/transaction_model');
			
			$info  = !empty($payment_info[$txn_type]) ? $payment_info[$txn_type] : 'Payment';
			
			$new_txn_id = $ci->transaction_model->add_transaction($txn_type,  $user_id);
			
			$ci->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'debit' => $price, 'ref' => '' , 'info' => $info));
			
			$ci->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => PROFIT_WALLET, 'credit' => $price, 'ref' => '' , 'info' => $info));
			
			wallet_less_fund($user_wallet_id, $price);
			wallet_add_fund(PROFIT_WALLET,$price);
			
			$user_info = get_row(array('select' => 'user_id,fname,lname,email','from' => 'user', 'where' => array('user_id' => $user_id)));
				
			$sender_info = array(
				'name' => SITE_TITLE,
				'address' => ADMIN_ADDRESS,
			);

			$receiver_info = array(
				'name' => $user_info['fname'].' '.$user_info['lname'],
				'address' => getUserAddress($user_info['user_id']),

			);

			$invoice_data = array(

				'sender_id' => 0,
				'receiver_id' =>$user_id,
				'invoice_type' => 1,
				'sender_information' => json_encode($sender_info),
				'receiver_information' => json_encode($receiver_info),
				'receiver_email' => $user_info['email'],
			);

			$inv_id = create_invoice($invoice_data); 
			
			$inv_dscr = !empty($invoice_info[$txn_type]) ? $invoice_info[$txn_type] : 'Payment';
			$invoice_row_data = array(
				'invoice_id' => $inv_id,
				'description' => $inv_dscr,
				'per_amount' => $price,
				'unit' => '-',
				'quantity' => 1,

			);
			
			add_invoice_row($invoice_row_data);
			
			$ci->db->where('invoice_id', $inv_id)->update('invoice_main', array('is_paid' => date('Y-m-d H:i:s')));
			$ci->db->where('txn_id', $new_txn_id)->update('transaction_new', array('invoice_id' => $inv_id, 'status' => 'Y'));
			
			$data['status'] = 'PAYMENT_SUCCESS';
		
		}
		
		return $data;
	}
	
}


if(!function_exists('get_paypal_pay_amount')){
	
	
	function get_paypal_pay_amount($amount=0){
		$paypal_fee_percent = getField('deposite_by_paypal_commission', 'setting', 'id', 1);
		$paypal_fee_fixed = PAYPAL_FIXED_FEE;
		$diff = $amount;

		$paypal_comm = ($diff * $paypal_fee_percent)/100;
		if($paypal_fee_fixed > 0){
			$paypal_comm += $paypal_fee_fixed;
		}
		
		$paypal_comm = clean_money_format($paypal_comm);

		$amount_to_pay = $diff + $paypal_comm;

		/* $amount_to_pay = ceil(clean_money_format($amount_to_pay)); */
		$amount_to_pay = clean_money_format($amount_to_pay);
		return $amount_to_pay;
	}
	
}

if(!function_exists('get_strip_pay_amount')){
	
	
	function get_strip_pay_amount($amount=0){ 
		$stripe_fee_percent = STRIP_FEE_PERCENT;
		$stripe_fee_fixed = STRIP_FEE_FIXED;
		$diff = $amount;
		if($stripe_fee_percent > 0){
			$comm = ($diff * $stripe_fee_percent)/100;
			if($stripe_fee_fixed){
				$comm += $stripe_fee_fixed;
			}
			$comm = clean_money_format($comm);
		}else{
			$comm = 0;
			if($stripe_fee_fixed){
				$comm += $stripe_fee_fixed;
			}
		}
		

		$amount_to_pay = $diff + $comm;

		/* $amount_to_pay = ceil(clean_money_format($amount_to_pay)); */
		$amount_to_pay = clean_money_format($amount_to_pay);
		return $amount_to_pay;
	}
	
}

if(!function_exists('get_stripe_fee')){
	
	
	function get_stripe_fee($amount=0){ 
		$stripe_fee_percent = STRIP_FEE_PERCENT;
		$stripe_fee_fixed = STRIP_FEE_FIXED;
		$diff = $amount;
		$stripe_fee=0;
		if($stripe_fee_percent > 0){
			
			if($stripe_fee_fixed > 0){
				$diff = $diff-$stripe_fee_fixed;
			}
			
			$stripe_fee = (($diff * $stripe_fee_percent)/(100+STRIP_FEE_PERCENT));
			
			if($stripe_fee_fixed > 0){
				$stripe_fee += $stripe_fee_fixed;
			}
			
			$stripe_fee = clean_money_format($stripe_fee);
			
		}else{
			$stripe_fee = 0;
		}
		

		return $stripe_fee;
	}
	
}




if(!function_exists('msort')){


	/**
	 * Sort a 2 dimensional array based on 1 or more indexes.
	 * 
	 * msort() can be used to sort a rowset like array on one or more
	 * 'headers' (keys in the 2th array).
	 * 
	 * @param array        $array      The array to sort.
	 * @param string|array $key        The index(es) to sort the array on.
	 * @param int          $sort_flags The optional parameter to modify the sorting 
	 *                                 behavior. This parameter does not work when 
	 *                                 supplying an array in the $key parameter. 
	 * 
	 * @return array The sorted array.
	 */
	function msort($array, $key, $sort_flags = SORT_REGULAR) {
		if (is_array($array) && count($array) > 0) {
			if (!empty($key)) {
				$mapping = array();
				foreach ($array as $k => $v) {
					$sort_key = '';
					if (!is_array($key)) {
						$sort_key = $v[$key];
					} else {
						// @TODO This should be fixed, now it will be sorted as string
						foreach ($key as $key_key) {
							$sort_key .= $v[$key_key];
						}
						$sort_flags = SORT_STRING;
					}
					$mapping[$k] = $sort_key;
				}
				asort($mapping, $sort_flags);
				$sorted = array();
				foreach ($mapping as $k => $v) {
					$sorted[] = $array[$k];
				}
				return $sorted;
			}
		}
		return $array;
	}

}


if(!function_exists('clean_money_format')){
	
	
	function clean_money_format($amount=0){ 
		return number_format($amount,2, '.', '');
	}
	
}

if(!function_exists('get_project_budget')){
	
	
	function get_project_budget($project_id=0,$removefloate=false){ 
		$project_sql = array(
			'select' => 'buget_min,buget_max,place_quote',
			'from' => 'projects',
			'where' => array('project_id' => $project_id),
		);
		$project_budget = get_row($project_sql);
		$buget="";
		
		if($project_budget['place_quote'] > 0){
			$buget="Place quote";
		}else{
			if($removefloate){
				if($project_budget['buget_min']!=0 && $project_budget['buget_max']!=0 && $project_budget['buget_max'] !== $project_budget['buget_min']){ 
					$buget=CURRENCY."<strong>".round($project_budget['buget_min']). "</strong> - ".CURRENCY."<strong>".round($project_budget['buget_max']).'</strong>';     
				}else if($project_budget['buget_max'] == $project_budget['buget_min']){
					$buget=CURRENCY."<strong>".round($project_budget['buget_min']).'</strong>'; 
				}else if($project_budget['buget_min']!=0 && $project_budget['buget_max']==0){ 
				   $buget="Over ".CURRENCY."<strong>".round($project_budget['buget_min']).'</strong>';          
				}else if($project_budget['buget_min']==0 && $project_budget['buget_max']!=0){ 
				   $buget="Less than ".CURRENCY."<strong>".round($project_budget['buget_max']).'</strong>';      
				}
			}else{
				if($project_budget['buget_min']!=0 && $project_budget['buget_max']!=0 && $project_budget['buget_max'] !== $project_budget['buget_min']){ 
					$buget=CURRENCY." ".$project_budget['buget_min']. " - ".CURRENCY." ".$project_budget['buget_max'];     
				}else if($project_budget['buget_max'] == $project_budget['buget_min']){
					$buget=CURRENCY." ".$project_budget['buget_min'];
				}else if($project_budget['buget_min']!=0 && $project_budget['buget_max']==0){ 
				   $buget="Over ".CURRENCY." ".$project_budget['buget_min'];          
				}else if($project_budget['buget_min']==0 && $project_budget['buget_max']!=0){ 
				   $buget="Less than ".CURRENCY." ".$project_budget['buget_max'];          
				}
			}
			
		}
		
		return $buget;
		
	}
	
}

if(!function_exists('get_percent')){
	
	
	function get_percent($amount=0, $rate=0){ 
		$percent_value = 0;
		if($amount > 0 && $rate > 0){
			$percent_value = (($amount*$rate)/100);
			$percent_value = clean_money_format($percent_value);
		}
		
		return $percent_value;
		
	}
	
}

if(!function_exists('get_user_city')){
	
	
	function get_user_city($user_id=''){ 
		$city_info = '';
		$user_location = get_row(
			array(
				'select' => 'country,city,user_id',
				'from' => 'user',
				'where' => array('user_id' => $user_id)
			)
		);
		
		$flag = get_country_flag($user_location['country']);
		if(!empty($user_location['city'])){
			
			$city_info = get_city_name($user_location['city']);
			$city_info .= ', ';
			$city_info .= getField('Name', 'country', 'Code', $user_location['country']);
			$city_info .= ' &nbsp;&nbsp';
			$city_info .= '<img src="'.$flag.'" />';
		}else if(!empty($user_location['country'])){
			$city_info = get_country_name($user_location['country']);
			$city_info .= ' &nbsp;&nbsp';
			$city_info .= '<img src="'.$flag.'" />';
		}
		
		return $city_info;
		
	}
	
}

if(!function_exists('get_name')){
	
	
	function get_full_name($user_id=''){ 
		$name = '';
		$fname = getField('fname', 'user', 'user_id', $user_id);
		$lname = getField('lname', 'user', 'user_id', $user_id);
		$company_name = getField('company', 'user', 'user_id', $user_id);
		$name = $fname . ' '.$lname;
		if($company_name){
			$name = $company_name;
		}
		
		return $name; 
	}
	
}


if(!function_exists('is_dispute_project')){
	
	
	function is_dispute_project($project_id=''){ 
		$ci = &get_instance();
		$dispute_rows = $ci->db->where(array('project_id' => $project_id, 'status' => 'D'))->count_all_results('escrow_new');
		if($dispute_rows > 0){
			return TRUE;
		}
		return FALSE;
	}
	
}

if(!function_exists('check_user_review')){
	
	
	function check_user_review($user_id='', $project_id=''){ 
		$ci = &get_instance();
		$dispute_rows = $ci->db->where(array('review_by_user' => $user_id, 'project_id' => $project_id))->count_all_results('review_new');
		if($dispute_rows > 0){
			return TRUE;
		}
		return FALSE;
	}
	
}


if(!function_exists('get_project_invoice_url')){
	
	
	function get_project_invoice_url($project_id=''){ 
		$invoice_id = get_project_invoice($project_id);
		if($invoice_id){
			$invoice_url = download_invoice($invoice_id);
		}else{
			$invoice_url = null;
		}
		
	
		return $invoice_url;
	}
	
}

if(!function_exists('get_project_invoice')){
	
	
	function get_project_invoice($project_id=''){ 
		$ci = &get_instance();
		$where = array(
			'status' => 'A',
			'release_payment' => 'Y',
			'fund_release' => 'A',
			'project_id' => $project_id,

		);
		$invoice_row = $ci->db->select('invoice_id')->where($where)->get('project_milestone')->row_array();
		if(!empty($invoice_row['invoice_id'])){
			$invoice_id = $invoice_row['invoice_id'];
		}else{
			$invoice_id = null;
		}
	
		return $invoice_id;
	}
	
}


if(!function_exists('download_invoice')){
	
	
	function download_invoice($inv_id=''){ 
		$file_name = getField('invoice_number', 'invoice_main', 'invoice_id', $inv_id);
		if($file_name){
			$file_name .= '_'.$inv_id.'.pdf';
		}
		$download_url = base_url('invoice/download/'.$inv_id.'?filename='.$file_name);
		if(!file_exists('./invoices/'.$file_name)){
			$ch = curl_init($download_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
			curl_exec($ch);
			curl_close($ch);
		
		}
		
		$file_url = base_url('invoices/'.$file_name);
		
		return $file_url;	
		
	}
	
}

if(!function_exists('get_dispute_id')){
	
	
	function get_dispute_id($milestone_id, $project_id=''){ 
		$dispute_id = 0;
		$where = array(
			'milestone_id' => $milestone_id
		);
		if($project_id){
			$where['project_id'] = $project_id;
		}
		$dispute_row = get_row(array(
			'select' => 'dispute_id',
			'from' => 'dispute',
			'where' => $where,
		));
		
		if($dispute_row){
			$dispute_id = $dispute_row['dispute_id'];
		}
		
		return $dispute_id;
	}
	
}





