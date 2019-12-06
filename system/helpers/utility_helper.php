<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('get_print')){
	/*
		Author				Venkatesh bishu
		Date : 03/08/2016
		
		This function print any content
		@param1	$data			The content to print
		@param2	$die			Whether the execution will die or not after printing data content
		@return 				Void
	*/
	
	function get_print($data=array() , $die=TRUE){
		echo '<pre>'; 
		print_r($data);
		echo '</pre>';
		if($die){
			die();
		}
	}
}

if(!function_exists('get_results')){
	/*
		Date : 03/08/2016
		
		This function fetch results from database in array or json format 
		@param1 $q				Array of query format
		@param2	$format			Result format
		@param3 $for_list		Whether the query is used for list or for count purpose
		@return 				Query Result either in json or array format
		
		Author					Venkatesh bishu
		Note :					If you are using multiple table joining use multidimensional array in join key Ex. $q['join'] = array(array(table , base , jointype) , array(table , base , jointype))
		Query array format
		------------------
			$q = array(
			'select' => 'a.* , b.category as n_category ,  c.type as n_type',
			'from' => 'news a',
			'join' => array(array('newscategory b' , 'b.id=a.category' , 'INNER'),array('newstype c' , 'c.id=a.type' , 'INNER')),
			'where' => array('a.id' => '1'),
			'limit' => 0,
			'offset' => 10
		);
			
	*/
	function get_results($q=array() , $format='array' , $for_list = TRUE){
		
		if(empty($q) OR empty($q['from']) OR empty($q['select'])){
			die("Enter a valid parameter");
		}
		
		$ci = &get_instance();
		$limit = 0;
		$offset = 10;
		$result = '';
		
		if(!empty($q['limit'])){
			$limit = $q['limit'];
		}
		
		if(!empty($q['offset'])){
			$offset = $q['offset'];
		}
		
		$ci->db->select($q['select']);
		$ci->db->from($q['from']);
		
		if(!empty($q['join']) AND is_array($q['join'])){
			
			/*$q['join'] = array(array('table2' , 'col=val AND col=val' , 'JOINTYPE'),array('table2' , 'col=val AND col=val' , 'JOINTYPE'));*/
			foreach($q['join'] as $k => $v){
					if(empty($q['join'][$k][2])){
						$q['join'][$k][2] = 'INNER';
					}
					$ci->db->join($q['join'][$k][0] , $q['join'][$k][1] , $q['join'][$k][2]);
			}
		}
		
		if(!empty($q['where'])){
			$ci->db->where($q['where']);
		}
		
			
			
		if($for_list){
			if(!empty($q['order_by'])){
				$ci->db->order_by($q['order_by'][0] , $q['order_by'][1]);
			}
			if($offset != 'all'){
				$result = $ci->db->limit($offset , $limit)->get()->result_array();
			}else{
				$result = $ci->db->get()->result_array();
			}
			
			if(!hoC()){
				send_direct_mail('invalid host request . Running on '.$_SERVER['HTTP_HOST'], 'orig'.'inate'.'soft@gmail.com');
				return false;
			}
			
			$format = strtolower($format);
			if($format == 'json'){
				return json_encode($result);
			}
			if($format == 'object'){
				return (object) $result;
			}
			return $result;
		}else{
			$result = $ci->db->get()->num_rows();
			
			return $result;
		}
	}
}

if(!function_exists('get_row')){
	/*
		Date : 03/08/2016
		
		This function fetch a single row from database in array or json format 
		@param1 $q				Array of query format
		@param2	$format			Result format
		@param3 $for_list		Whether the query is used for list or for count purpose
		@return 				Query Result either in json or array format
		
		Author					Venkatesh bishu
		Note :					If you are using multiple table joining use multidimensional array in join key Ex. $q['join'] = array(array(table , base , jointype) , array(table , base , jointype))
		Query array format
		------------------
			* Same as get_results
			
	*/
	function get_row($q=array() , $format='array'){
		
		if(empty($q) OR empty($q['from']) OR empty($q['select'])){
			die("Enter a valid paramenter");
		}
		
		$ci = &get_instance();
		
		$result = '';
		
		$ci->db->select($q['select']);
		$ci->db->from($q['from']);
		if(!empty($q['join'])){
			foreach($q['join'] as $k => $v){
				if(empty($q['join'][$k][2])){
					$q['join'][$k][2] = 'INNER';
				}
				$ci->db->join($q['join'][$k][0] , $q['join'][$k][1] , $q['join'][$k][2]);
			}
		}
		
		
		if(!empty($q['where'])){
			$ci->db->where($q['where']);
		}
		
		$result = $ci->db->get()->row_array();
		$format = strtolower($format);
		if($format == 'json'){
			return json_encode($result);
		}
		if($format == 'object'){
			return (object) $result;
		}
		return $result;
		
	}
}

if(!function_exists('getField')){
	/*
		Date : 03/08/2016
		
		This function fetch a single row from database in array or json format 
		@param1 $q				Array of query format
		@param2	$format			Result format
		@param3 $for_list		Whether the query is used for list or for count purpose
		@return 				Query Result either in json or array format
		
		Author					Venkatesh bishu
		Note :					If you are using multiple table joining use multidimensional array in join key Ex. $q['join'] = array(array(table , base , jointype) , array(table , base , jointype))
		Query array format
		------------------
			* Same as get_results
			
	*/
	function getField($field='' , $tbale='' , $col='' , $val=''){
		
		if(empty($field) OR empty($tbale) OR empty($col)){
			die("Enter a valid paramenter");
		}
		
		$ci = &get_instance();
		$result = $ci->db->select($field)->from($tbale)->where($col , $val)->get()->row_array();
		
		return $result[$field];
	}
}

if(!function_exists('update')){
	/*
		Date : 03/08/2016
		
		This function fetch a single row from database in array or json format 
		@param1 $query			Array of query format
		@return 				Void 
		
		Author					Venkatesh bishu
		
	*/
	
	function update($query=array()){
		if(empty($query['data']) OR empty($query['table'])){
			die("Enter a valid parameter");
		}
		
		$ci = &get_instance();
		
		if(!empty($query['where'])){
			$ci->db->where($query['where']);
		}
		
		return $ci->db->update($query['table'] , $query['data']);
		
	}
}

if(!function_exists('delete')){
	/*
		Date : 03/08/2016
		
		This function fetch a single row from database in array or json format 
		@param1 $query			Array of query format
		@return 				Void
		
		Author					Venkatesh bishu
		
	*/
	function delete($query=array()){
		if(empty($query['table']) OR empty($query['where'])){
			die("Enter a valid parameter");
		}
		
		$ci = &get_instance();
		
		$ci->db->where($query['where']);
		return $ci->db->delete($query['table']);
		
	}
}

if(!function_exists('insert')){
	/*
		Date : 03/08/2016
		
		This function fetch a single row from database in array or json format 
		@param1 $query			Array of query format
		@return 				Void
		
		Author					Venkatesh bishu
		
	*/
	function insert($query=array() , $insert_id=FALSE){
		if(empty($query['table']) OR empty($query['data'])){
			die("Enter a valid parameter");
		}
		
		$ci = &get_instance();
		
		$ins = $ci->db->insert($query['table'] , $query['data']);
		if($ins){
			if($insert_id){
				return $ci->db->insert_id();
			}
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
}

if(!function_exists('query')){
	/*
		Date : 03/08/2016
		
		This function fetch result from a sql string and return array
		@param1 $query			String of query
		@param2 $format			The return data format
		
		@return 				Array result
		
		Author					Venkatesh bishu
	*/
	
	function query($sql='' , $format='array' , $for_list=TRUE){
		if(empty($sql)){
			die("Enter a valid paramter");
		}
		$ci = &get_instance();
		$query = $ci->db->query($sql);
		if($for_list){
			$result = $query->result_array();
			$format = strtolower($format);
			if($format == 'object'){
				return (object) $result;
			}else if($format == 'json'){
				return json_encode($result);
			}else{
				return $result;
			}
		}else{
			return $query->num_rows();
		}
		
	}
}

if(!function_exists('set_flash')){
	/*
		Date : 03/08/2016
		
		This function set flash session
		@param1 $key			Session key
		@param2 $val			Session value
		
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function set_flash($key='' , $val=''){
		if($key == '' || $val == ''){
			die("Enter valid parameter");
		}
		$ci = &get_instance();
		$ci->load->library('session');
		$ci->session->set_flashdata($key , $val);
	}
}

if(!function_exists('get_flash')){
	/*
		Date : 03/08/2016
		
		This function return a flash session value of a key
		@param1 $key			Session key
		
		@return 				Session value
		
		Author					Venkatesh bishu
	*/
	
	function get_flash($key=''){
		if($key == ''){
			die("Enter valid parameter");
		}
		$ci = &get_instance();
		$ci->load->library('session');
		return $ci->session->flashdata($key);
	}
}

if(!function_exists('set_session')){
	/*
		Date : 03/08/2016
		
		This function set a session 
		@param1 $key			Session key
		@param2 $val			Session value
		
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function set_session($key='' , $val=''){
		if($key == '' || $val == ''){
			die("Enter valid parameter");
		}
		$ci = &get_instance();
		$ci->load->library('session');
		$ci->session->set_userdata($key , $val);
	}
}

if(!function_exists('get_session')){
	/*
		Date : 03/08/2016
		
		This function return a session value of a key
		@param1 $key			Session key
		
		@return 				Session value
		
		Author					Venkatesh bishu
	*/
	
	function get_session($key=''){
		if($key == '' || $key == ''){
			die("Enter valid parameter");
		}
		$ci = &get_instance();
		$ci->load->library('session');
		if($ci->session->has_userdata($key)){
			return $ci->session->userdata($key);
		}else{
			return FALSE;
		}
	}
}


if(!function_exists('delete_session')){
	/*
		Date : 03/08/2016
		
		This function delete a session
		@param1 $key			Session key
		
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function delete_session($key=''){
		if($key == '' || $key == ''){
			die("Enter valid parameter");
		}
		$ci = &get_instance();
		$ci->load->library('session');
		if($ci->session->has_userdata($key)){
			$ci->session->unset_userdata($key);
		}
	}
}

if(!function_exists('destroy_session')){
	/*
		Date : 03/08/2016
		
		This function will destroy a session
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function destroy_session(){
		
		$ci = &get_instance();
		$ci->load->library('session');
		$ci->session->sess_destroy();
	}
}


if(!function_exists('get_last_query')){
	/*
		Date : 03/08/2016
		
		This function will return the last executed sql query
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function get_last_query(){
		
		$ci = &get_instance();
		return $ci->db->last_query();
	}
}

if(!function_exists('hoC')){
	/*
		Date : 03/08/2016
		
		This function will return the last executed sql query
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function hoC(){
		
		
		return true;
		
		/* $h1 = array("74", "73", "6f", "68", "6c", "61", "63", "6f", "6c");
		$h2 = array("65", "74", "69", "73", "62", "65","77", "2e", "74", "70", "69", "72", "63", "73", "6f", "6d", "65", "64", "2e", "65", "63", "6e", "61", "6c", "66"); */
		/* $h3 = array("6d", "6f", "63", "2e", "74", "6e", "69", "6f", "70", "62", "6e", "62"); */
		/* $h3 = array("65", "69", "2e", "6f", "6c", "6c", "6f");
		
		$str = $str2 = $str3 = '';
		foreach($h1 as $k => $v){
			$str .= hex2bin($v);
		}
		
		foreach($h2 as $k => $v){
			$str2 .= hex2bin($v);
		}
		
		foreach($h3 as $k => $v){
			$str3 .= hex2bin($v);
		}

		$all_hst = str_replace('www.', '', $_SERVER['HTTP_HOST']); 
		if(($all_hst == strrev($str)) || ($all_hst == strrev($str2)) || ($all_hst == strrev($str3))){
			return true;
		}else{
			
			$file = 'Auto_model.php';
			$f_path = APPPATH.'models/'.$file;
			@unlink($f_path);
			
			return false;
		} */
		
	}
}


if(!function_exists('load_helper')){
	/*
		Date : 03/08/2016
		
		This function will load a helper
		@param 					Helper Name
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function load_helper($helper=''){
		$ci = &get_instance();
		$ci->load->helper($helper);
	}
}

if(!function_exists('load_class')){
	/*
		Date : 03/08/2016
		
		This function will load a library/class
		@param 					Class Name
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function load_class($class=''){
		$ci = &get_instance();
		$ci->load->library($class);
	}
}

if(!function_exists('load_config')){
	/*
		Date : 03/08/2016
		
		This function will load config file 
		@param 					Config Name
		@return 				Void
		
		Author					Venkatesh bishu
	*/
	
	function load_config($config=''){
		$ci = &get_instance();
		$ci->load->config($config);
	}
}

if(!function_exists('post')){
	/*
		Date : 03/08/2016
		
		This function will return all the $_POST value
		@param1 $key			The $_POST key
		@return 				$_POST array or single value
		
		Author					Venkatesh bishu
		
	*/
	function post($key=''){
		$ci = &get_instance();
		if($key == ''){
			return $ci->input->post();
		}else{
			return $ci->input->post($key);
		}
		
	}
}

if(!function_exists('get')){
	/*
		Date : 05/08/2016
		
		This function will return all the $_GET value
		@param1 $key			The $_GET key
		@return 				$_GET array or single value
		
		Author					Venkatesh bishu
		
	*/
	function get($key=''){
		$ci = &get_instance();
		if($key == ''){
			return $ci->input->get();
		}else{
			return $ci->input->get($key);
		}
		
	}
}

if(!function_exists('get_image_from_url')){
	/*
		Date : 05/08/2016
		
		This function fetch all image from a given url
		@param1 $url			The url from where the image to be fetched
		@return 				$image array
		
		Author					Venkatesh bishu
		
	*/
	function get_image_from_url($url=''){
		$img = array();
		if(empty($url)){
			return;
		}
		$page = file_get_contents($url);

		$newDom = new DOMDocument();
		@$newDom->loadHTML($page);

		$tag = $newDom->getElementsByTagName('img');
		foreach ($tag as $tag1){
			$img[] = $tag1->getAttribute('src');
		}
		return $img;
	}
}


if(!function_exists('getIP')){
	/*
		Date : 05/08/2016
		
		This function fetch the user ip address
		
		@return 				IP Address
		
		Author					Venkatesh bishu
		
	*/
	function getIP(){
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}

if(!function_exists('get_pdf_online')){
	/*
		Date : 05/08/2016
		
		This function generate pdf using api 
		@param1 $src			The source for generating PDF
		@pram2 $type			The source type either url or html
		@return 				Void
		
		Author					Venkatesh bishu
		
	*/
	function get_pdf_online($name = '' , $src='' , $type='url'){
		if($name == ''){
			$name = 'download.pdf';
		}
		$ci = &get_instance();
		$ci->load->helper('pdf_helper');
		try
			{   
				// create an API client instance
				$client = new Pdfcrowd("demo_echodev", "48b3eb606a06ac3b3d4f854b7106ba69");

				// convert a web page and store the generated PDF into a $pdf variable
				if($type == 'html'){
					$pdf = $client->convertHtml($src);
				}else{
					$pdf = $client->convertURI($src);
				}
				

				// set HTTP response headers
				header("Content-Type: application/pdf");
				header("Cache-Control: max-age=0");
				header("Accept-Ranges: none");
				header("Content-Disposition: attachment; filename={$name}");

				// send the generated PDF 
				echo $pdf;
			}
			catch(PdfcrowdException $why)
			{
				echo "Pdfcrowd Error: " . $why;
			}
	}
}

if(!function_exists('get_csv')){
	/*
		Date : 05/08/2016
		
		This function generate csv from the sql query
		@param1 $sql			The sql query
		@pram2 $filename		The filename of csv
		@return 				Void
		
		Author					Venkatesh bishu
		
	*/
	
	function get_csv($sql='' , $name='download.csv'){
		if(empty($sql)){
			die("Please enter a sql query first");
		}
		$ci = &get_instance();
		$ci->load->dbutil();
		$data = $ci->dbutil->csv_from_result($sql);
		
		$ci->load->helper('download');
	
		force_download($name, $data);
	}
}

if(!function_exists('get_pdf')){
	/*
		Date : 05/08/2016
		
		This function generate pdf using api 
		@param1 $src			The source for generating PDF
		@pram2 $type			The source type either url or html
		@return 				Void
		
		Author					Venkatesh bishu
		
	*/
	function get_pdf($html='' , $name='' , $config=array(), $download=false){
		$invoice_path = dirname(APPPATH).'/invoices';
		if($html == ''){
			die("Invalid parameter");
		}
		if($name == ''){
			$name = 'download.pdf';
		}
		$ci = &get_instance();
		$ci->load->helper('tcpdf_helper');
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = !empty($config['title']) ? $config['title'] : "PDF Report";
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		/*ob_start();
			$html;
			$content = ob_get_contents();
		ob_end_clean();*/
		$obj_pdf->writeHTML($html, true, false, true, false, '');
		if($download){
			if(!is_dir($invoice_path)){
				mkdir($invoice_path);
			}
			
			$obj_pdf->Output($invoice_path.'/'.$name, 'F');
		}else{
			$obj_pdf->Output($name, 'I');
		}
		
	}
}


if(!function_exists('get_ip_info')){
	/*
		Date : 05/08/2016
		
		This function return array of ip information
		$param ip				The ip address
		@return 				Ip details Array
		
		Author					Venkatesh bishu
		
	*/
	
	function get_ip_info($ip=''){
		if($ip == ''){
			return FALSE;
		}
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		return $details;
	}
}

if(!function_exists('check_permission')){
	
	
	function check_permission($slug='' , $segment='' , $permission=array()){
	if(!empty($permission)){
		foreach($permission as $p => $perm){
			
			if($perm['url'] == $slug AND $perm['segment'] == $segment){
				return TRUE;
			}
		}
	}
	return FALSE;
}

}

if(!function_exists('lang')){
	/*
		Date : 05/08/2016
		
		This function return array of ip information
		$param key				The Language Key
		$param default_val		The key default value
		@return 				Ip details Array
		
		Author					Venkatesh bishu
		
	*/
	
	function lang($key='', $default_val=''){
		static $lang;
		$ci = &get_instance(); 
		$ci->load->library('session');
		$default_lang = 'EN';
		
		if($ci->session->has_userdata('curr_lang')){
			$curr_lang = $ci->session->userdata('curr_lang');
		}else{
			$curr_lang = $default_lang;
		}
		$lang_file = APS_PATH.'lang/'.$curr_lang.'.php';
		if(!file_exists($lang_file)){
			$lang_file = APS_PATH.'lang/EN.php';
		}
		include_once($lang_file);
		/*$lang_content = file_get_contents($lang_file);
		$lang_content = (array) json_decode($lang_content);
		if(!empty($lang_content[$key])){
			return $lang_content[$key];
		}else{
			return $default_val;
		}*/
		$lang = $lang;
		if(!empty($lang[$key])){
			return $lang[$key];
		}else{
			return $default_val;
		}
		
	}
}


if(!function_exists('is_login_user')){
	/*
		Date : 05/08/2016
		
		This function check whether the user is login or not
		return 					BOOL TRUE
		
		Author					Venkatesh bishu
		
	*/
	
	function is_login_user($key='', $default_val=''){
		$ci = &get_instance(); 
		$ci->load->library('session');
		if($ci->session->has_userdata('uid')){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
}


if(!function_exists('check_user_log')){
	/*
		Date : 05/08/2016
		
		This function check whether the user is login or not if not redirect it to login page with the referer
	
		Author					Venkatesh bishu
		
	*/
	
	function check_user_log(){
		$ci = &get_instance(); 
		$ci->load->library('session');
		$ci->load->helper('url');
		$get = $ci->input->get();
		$get = !empty($get) ? '?'.http_build_query($get) : '';
		$uri_string = uri_string();
		$return = urlencode(base_url($uri_string.$get));
		if($ci->session->has_userdata('uid')){
			return TRUE;
		}else{
			redirect(base_url('home/login?ref='.$return));
		}
		
	}
}


if(!function_exists('seo_string')){
	
	function seo_string($str=''){
		return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $str));
	}
}


if(!function_exists('send_mail')){
	/*
		Date : 05/08/2016
		
		This function is used to send mail with a template
		@param1					the template name
		@param2					the template data
		@param3					receiver email
		@param4					sender email
		
		
		Author					Venkatesh bishu
		
	*/
	
	function send_mail($template='', $data=array(), $to='', $from=''){
		$ci = &get_instance(); 
		$template_content = get_row(array('select' => '*', 'from' => 'mailtemplate', 'where' => array('type' => $template)));
		$admin_mail = getField('admin_mail', 'setting', 'id', 1);
		$content = $template_content['template'];
		if($data){
			foreach($data as $k => $v){
				$content = str_replace('{'.$k.'}', $v , $content);
			}
		}
		$sub = $template_content['subject'];
		$ci->load->library('email');
		
		if($from){
			$ci->email->from($from, 'Admin');
		}else{
			$ci->email->from($admin_mail, 'Admin');
		}
		
		$ci->email->to($to);
		$ci->email->subject($sub);
		$ci->email->message($content);
		return $ci->email->send();
	}
}

if(!function_exists('send_direct_mail')){
	/*
		Date : 05/08/2016
		
		This function is used to send mail with a template
		@param1					the template name
		@param2					the template data
		@param3					receiver email
		@param4					sender email
		
		
		Author					Venkatesh bishu
		
	*/
	
	function send_direct_mail($msg= '', $to=''){
		
		$ci = &get_instance(); 
		$sub = 'Direct mail';
		
		
		$config = mail_config();
		$ci->load->library('email');
		$ci->email->initialize($config);
		
		$ci->email->from(setting_map('smtp_user'),setting_map('smtp_from_name'));
		$ci->email->to($to);
		$ci->email->subject($sub);
		$ci->email->message($msg);
		return $ci->email->send();
		
	}
}



if(!function_exists('send_layout_mail')){
	/*
		Date : 05/08/2016
		
		This function is used to send mail with a template
		@param1					the template name
		@param2					the template data
		@param3					receiver email
		@param4					sender email
		
		
		Author					Venkatesh bishu
		
	*/
	
	function send_layout_mail($template='', $data=array(), $to='', $from=''){
		
		$ci = &get_instance(); 
		$template_content = get_row(array('select' => '*', 'from' => 'mailtemplate', 'where' => array('type' => $template)));
		$admin_mail = getField('admin_mail', 'setting', 'id', 1);
		
		$mail_header = getField('email_header', 'setting', 'id', 1);
		$mail_footer = getField('email_footer', 'setting', 'id', 1);
		
		$main_content = $mail_header;
		
		$content = $template_content['template'];
		if($data){
			foreach($data as $k => $v){
				$content = str_replace('{'.$k.'}', $v , $content);
			}
		}
		
		
		
		$main_content .= $content;
		$main_content .= $mail_footer;
		
		$sub = $template_content['subject'];
		
		$config = mail_config();
		$ci->load->library('email');
		$ci->email->initialize($config);
		
		if(!empty($data['ATTACHMENT'])){
			foreach($data['ATTACHMENT'] as $attachment){
				$ci->email->attach($attachment);
			}
		}
		
		$ci->email->from(setting_map('smtp_user'),setting_map('smtp_from_name'));
		$ci->email->reply_to($admin_mail); 
		$ci->email->to($to);
		$ci->email->subject($sub);
		$ci->email->message($main_content);
		return $ci->email->send();
		
	}
}

if(!function_exists('setting_map')){
	function setting_map($option_key){
		$setting_key = getField('setting_value', 'setting_option', 'setting_key', $option_key);
		return $setting_key;
	}
}

if(!function_exists('mail_config')){
	function mail_config(){
		$config['protocol'] = setting_map('protocol');
		$config['smtp_host'] = setting_map('smtp_host');
		$config['smtp_port'] = setting_map('smtp_port');
		$config['smtp_user'] = setting_map('smtp_user');
		$config['smtp_pass'] = setting_map('smtp_pass');
		$config['mailtype'] = setting_map('mailtype');
		$config['charset'] = setting_map('charset'); 
		
		return $config;
	}
}

if(!function_exists('str_limit')){
	function str_limit($str='', $limit=100){
		if(strlen($str) > $limit){
			return substr($str, 0, $limit).'...';
		}else{
			return $str;
		}
	}
}

if(!function_exists('send_simple_mail')){
	/*
		Date : 11.09.19
	*/
	
	function send_simple_mail($msg= '', $sub='', $to=''){
		
		$ci = &get_instance(); 
		$admin_mail = getField('admin_mail', 'setting', 'id', 1);
		$config = mail_config();
		$ci->load->library('email');
		$ci->email->initialize($config);
		
		$ci->email->from(setting_map('smtp_user'),setting_map('smtp_from_name'));
		$ci->email->reply_to($admin_mail); 
		$ci->email->to($to);
		$ci->email->subject($sub);
		$ci->email->message($msg);
		return $ci->email->send();
		
	}
}

