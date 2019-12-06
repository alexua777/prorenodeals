<?php
/////////////////////////////////////////////////////
///												  ///
///		FaceBook Login API Library				  ///
///		Company: ScriptGiant Technology			  ///
///		Author: Samim Almamun					  ///
///												  ///
/////////////////////////////////////////////////////

/*
NOTE:-
	define constant in config auto load library for:
	YOUR_APP_ID
	and
	YOUR_APP_SECRET
*/

class Facebook_login{

public function __construct() {
	$app_id = YOUR_APP_ID;
	
	$app_secret = YOUR_APP_SECRET;
}


public function get_facebook_cookie($app_id, $app_secret) 
{
 $signed_request = $this->parse_signed_request(@$_COOKIE['fbsr_' . $app_id], $app_secret);
 $signed_request['uid'] = $signed_request['user_id']; // for compatibility 

 
 if (!is_null($signed_request))
 {
  // the cookie is valid/signed correctly
  // lets change "code" into an "access_token"
  // openssl must enable on your server inorder to access HTTPS
  $access_token_response = '';
  $access_token_response = @file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code={$signed_request['code']}");
  parse_str($access_token_response);
 
  @$signed_request['access_token'] = @$access_token;
  $signed_request['expires'] = time() + @$expires;
 }
 return $signed_request;
}

public function parse_signed_request($signed_request, $secret)
{
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
  $sig = $this->base64_url_decode($encoded_sig);
  $data = json_decode($this->base64_url_decode($payload), true);
  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') 
  {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);

  if ($sig !== $expected_sig)
   {

    error_log('Bad Signed JSON signature!');
  return null;
  }
  return $data;
}

public function base64_url_decode($input)
{
  return base64_decode(strtr($input, '-_', '+/'));
}
}
?>
