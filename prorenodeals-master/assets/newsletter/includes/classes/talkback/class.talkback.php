<?php
/*
	ListMessenger TalkBack Client 2.2.0
	Copyright 2009 Silentweb [http://www.silentweb.ca]. All Rights Reserved.

	Originally:			HTTPPost v1.0 by Daniel Kushner
	Re-Developed By:	Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in licence.html
	$Id: class.talkback.php 481 2009-11-29 16:21:11Z matt.simpson $

	Original Copyright Notice:
		HTTPPost ver 1.0.0
		Author:	Daniel Kushner
		Email:	daniel@websapp.com
		Release:2 Nov 2001 - Copyright 2001
		Domain:	www.websapp.com/classes
*/
class TalkBack {

	var $url;
	var $uri;
	var $version			= "2.2.0";
	var $dataArray			= array();
	var $responseBody		= "";
	var $responseHeaders	= "";
	var $errors				= "";

	function TalkBack($type = "", $dataArray = "", $authInfo = false) {
		switch($type) {
			case "registration" :
				$this->setURL("http://talkback.listmessenger.com/collector.bin");
			break;
			case "trip" :
				$this->setURL("http://talkback.listmessenger.com/tripwire.bin");
			break;
			case "version" :
			default:
				$this->setURL("http://talkback.listmessenger.com/version.bin");
			break;
		}

		$this->setDataArray($dataArray);
		$this->authInfo = $authInfo;
	}

	function setUrl($url = "") {
		if(trim($url) != "") {
			$url = preg_replace("/^(http|https):\/\//i", "", $url);
			$this->url	= substr($url, 0, strpos($url, "/"));
			$this->uri	= strstr($url, "/");

			return true;
		}

		return false;
	}

	function setDataArray($dataArray = array()) {
		if(is_array($dataArray)) {
			$this->dataArray = $dataArray;

			return true;
		}
		
		return false;
	}

	function setAuthInfo($user = "", $pass = false) {
		if(is_array($user)) {
			$this->authInfo = $user;
		} else {
			$this->authInfo = array($user, $pass);
		}
	}

	function getResponseHeaders() {
		return $this->responseHeaders;
	}

	function getResponseBody() {
		return $this->responseBody;
	}

	function getErrors() {
		return $this->errors;
	}

	function prepareRequestBody(&$array, $index = "") {
		$body = array();
		
		if(is_array($array)) {
			foreach($array as $key => $val) {
				if(is_array($val)) {
					if($index) {
						$body[] = $this->prepareRequestBody($val, $index."[".$key."]");
					} else {
						$body[] = $this->prepareRequestBody($val, $key);
					}
				} else {
					if($index) {
						$body[] = $index."[".$key."]=".urlencode($val);
					} else {
						$body[] = $key."=".urlencode($val);
					}
				}
			}
		}
		
		return implode("&", $body);
	}

	function post() {
		$this->responseHeaders	= "";
		$this->responseBody		= "";
		
		$errno		= 0;
		$errstr		= "";
		$isHeader	= true;
		$matches	= false;
		$blockSize	= 0;
		$length		= 0;
		
		$requestBody = $this->prepareRequestBody($this->dataArray);

		if($this->authInfo) {
			$auth = base64_encode("{$this->authInfo[0]}:{$this->authInfo[1]}");
		}

		$contentLength	= strlen($requestBody);
		$request  = "POST ".$this->uri." HTTP/1.1\r\n";
		$request .= "Host: ".$this->url."\r\n";
		$request .= "User-Agent: ListMessenger TalkBack Client ".$this->version."\r\n";
		$request .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$request .= "Content-Length: ".$contentLength."\r\n\r\n";
		$request .= $requestBody."\r\n";

		$socket	= @fsockopen($this->url, 80, $errno, $errstr, 5);
		if(!$socket) {
			$this->error["errno"]	= $errno;
			$this->error["errstr"]	= $errstr;

			return $this->getResponseBody();
		}

		fputs($socket, $request);
		
		while (!feof($socket)) { 
			if($isHeader) {
				$line = fgets($socket, 1024); 
				$this->responseHeaders .= $line;
				
				if(trim($line) == "") {
					if(preg_match("/content-length:\s([0-9]+)/i", $this->responseHeaders, $matches)){
						if((isset($matches[1])) && ($matches[1] != "") && ($matches[1] > 0)) {
							$length = $matches[1];
						}
					}
					
					$isHeader = false;
				}
			} else {
				if((int) $length) {
					$this->responseBody .= fread($socket, $length);
				} else {
					/**
					 * @todo Make sure this works if the $length variable was
					 * not set by the content-length header.
					 */
					if(intval($blockSize) == 0) {
						if($blockSizeHex = trim($line)) {
							$blockSize = hexdec($blockSizeHex);
						}
					} else {
						if((intval($blockSize) == 0) || ($blockSize == "") || ($blockSize < 1) || ($blockSize > 4194304)) {
							$blockSize = 0;
						}
						
						$this->responseBody .= fread($socket, $blockSize);
						$blockSize = 0;
					}
				}
			}
		}

		fclose($socket);
		return $this->getResponseBody();
	}
}
?>