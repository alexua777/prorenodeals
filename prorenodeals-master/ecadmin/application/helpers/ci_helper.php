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