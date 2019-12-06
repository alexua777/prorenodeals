<?php
/////////////////////////////////////////////////////
///												  ///
///		Send Mail Thorugh Mail Template 		  ///
///		Company: ScriptGiant Technology			  ///
///		Author: Samim Almamun					  ///
///		Type: Library	 						  ///
///												  ///
/////////////////////////////////////////////////////


///////////// NOTE //////////////////////////////////
/*
	DB Table Stucture:
	type(varchar),subject(varchar),template(text),status(Y,N)
	
	from = samim@gmail.com, to = "anyone@gmail.com",
	templete_type = <template_type>
	param = array( "{name}" => "Samim Almamun" )
	
	Function call:
	send_mail($from,$to,$templete_type,$param)
*/
/////////////////////////////////////////////////////

class Mailtemplete{
	private $CI;

	public function __construct() {
		  $CI =   &get_instance();
			$config = Array(
			'mailtype' => 'html'
			);
		  $CI->load->library('email',$config);
	}
	
	public function send_mail($from='',$to='',$templete_type='',$param=array()){
		$CI =   &get_instance();
		$templete_data = $this->get_templete($templete_type);
		
		if(count($templete_data)<1){
			return false;
		}
		
		$subject = $templete_data->subject;
		$body = $this->mail_body($templete_type,$param);

		$CI->email->from($from, 'FabTask');
		$CI->email->to($to); 
		$CI->email->subject($subject);
		$CI->email->message($body);	
		$CI->email->message($body);	
		@$CI->email->send();

	}
	
	public function get_templete($template_type=''){
		$CI =   &get_instance();
        $query  =   $CI->db->get_where('email_template',array("type"=>$template_type,"status"=>"Y"));
        return $result = $query->row();	
	}
	
	public function mail_body($template_type='',$param=array()){
		$CI =   &get_instance();
		
		$template_data = $this->get_templete($template_type);
		$template = $template_data->template;
		foreach($param as $key=>$value){
			$template = str_replace($key,$value,$template); 
		}
		return ($template);
		
		
		
	}


}

?>