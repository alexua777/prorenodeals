<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class  affiliate_mass_model extends BaseModel {

    public function __construct() {
    	
        return parent::__construct();
    }
	public function masspay($id){

				$approve_id =  $id;               
                $uid=$this->auto_model->getFeild("user_id","withdrawl_affiliate","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N"));
                $accid=$this->auto_model->getFeild("account_id","withdrawl_affiliate","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N")); 
                $admin_pay=$this->auto_model->getFeild("admin_pay","withdrawl_affiliate","","",array("withdrawl_id"=>$approve_id,"transer_through"=>"P","status"=>"N")); 
                $user_bank_details=$this->auto_model->getFeild("paypal_account","user_bank_account_affiliate","","",array("account_id"=>$accid,"user_id"=>$uid));
                
        if($uid!="" && $accid!="" && $admin_pay!=""){ 
       
		$emailSubject =urlencode('Withdrawal fund from Jobbid.org');
		$receiverType = urlencode('EmailAddress');
		$currency = urlencode('USD');
		$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
		
                $from = $this->auto_model->getFeild("admin_mail","setting");
                $to=$this->auto_model->getFeild("email","user_affiliate","user_id",$uid);
                $username=$this->auto_model->getFeild("fname","user_affiliate","user_id",$uid);
                $data_parse=array(
                    'username'=>$username,
                    'amount'=>$admin_pay,
                    'cur' => CURRENCY
                );                
                
		               
		if($user_bank_details!=''){		
			$receiverEmail = urlencode($user_bank_details);
			$amount = urlencode($admin_pay);			
			$uniqueID =date('dmYHis');
			$note = urlencode("Withdrawal fund from Jobbid.org");
			$nvpStr .= "&L_EMAIL0=$receiverEmail&L_Amt0=$amount&L_UNIQUEID0=$uniqueID&L_NOTE0=$note";			
			$httpParsedResponseAr = $this->PPHttpPost($id,'MassPay', $nvpStr);			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {	
                     $data_trans=array(
                         "status"=>"Y"
                     );                      
                     $data_withdraw=array(
                         "status"=>"Y"
                     );            
                     $this->updateWithdraw($data_withdraw,$approve_id);
                     $msg['status']='OK';                                       
                     $msg['msg']= "ID : ".$id.' > Fund Transfer Success.<br>';
                     $this->auto_model->send_email($from,$to,"withdraw_payment_request_for_freelancer",$data_parse);
			  } else{ 
			 		 $msg['status']='Error';                                       
                     $msg['msg']= "ID : ".$id.' >Fund Transfer Failed0.<br>';

               }
			
		 	} else{
					$msg['status']='Error';                                       
                     $msg['msg']= "ID : ".$id.' >Fund Transfer Failed1.<br>';
			}
		}else{
			$msg['status']='Error';                                       
             $msg['msg']= "ID : ".$id.' >Fund Transfer Failed2.<br>';
			
		}

	}
	public function PPHttpPost($id,$methodName_, $nvpStr_) {

		$ps=$this->paypal_settings();

 	if ($ps['paypal_mode'] == 'DEMO') {
        $environment = 'sandbox';
        $API_UserName = urlencode($ps['sandbox_api_uid']);

        $API_Password = urlencode($ps['sandbox_api_pass']);

        $API_Signature = urlencode($ps['sandbox_api_sig']);
    } else {
        $environment = '';
        $API_UserName = urlencode($ps['paypal_api_uid']);

        $API_Password = urlencode($ps['paypal_api_pass']);

        $API_Signature = urlencode($ps['paypal_api_sig']);
    }
    
	// Set up your API credentials, PayPal end point, and API version.

		
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');
 
	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	//die($nvpreq);
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
//echo'<br>';
	// Get response from the server.
	$httpResponse = curl_exec($ch);
	//echo'<br>';

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("ID: ".$id."=> Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}
	
	return $httpParsedResponseAr;
	}
	public function updateWithdrawl($wid){
		$data = array(
			'status' => 'Y'
			);
		$this->db->where('withdrawl_id', $wid);
		return $this->db->update("withdrawl_affiliate" ,$data);
	
	}
	  public function updateWithdraw($data,$wid){
           $this->db->where('withdrawl_id', $wid);
           $this->db->update("withdrawl_affiliate", $data);              
        }
	 public function paypal_settings(){ 
            $this->db->select("paypal_mail,paypal_api_uid,paypal_api_pass,paypal_api_sig,sandbox_api_uid,sandbox_api_pass,sandbox_api_sig,paypal_mode,deposite_by_creaditcard_fees,deposite_by_paypal_commission,deposite_by_paypal_fees");         
            $res=$this->db->get("setting");
            
            $data=array();
            
            foreach($res->result() as $row){ 
                $data=array(
                    "paypal_mail" => $row->paypal_mail,
                    "paypal_api_uid"=> $row->paypal_api_uid,
                    "paypal_api_pass"=> $row->paypal_api_pass,
                    "paypal_api_sig"=> $row->paypal_api_sig,
                    "sandbox_api_uid"=> $row->sandbox_api_uid,
                    "sandbox_api_pass"=> $row->sandbox_api_pass,
                    "sandbox_api_sig"=> $row->sandbox_api_sig,
                    "paypal_mode"=> $row->paypal_mode,
                    "deposite_by_creaditcard_fees"=> $row->deposite_by_creaditcard_fees,
                    "deposite_by_paypal_commission"=> $row->deposite_by_paypal_commission,
                    "deposite_by_paypal_fees"=> $row->deposite_by_paypal_fees                                        
                );
            }
            
            return $data;
            
        }
}
