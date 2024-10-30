<?php
class IngBoo {
  private $url;               // IngBoo API URL to connect to
  private $useragent;         // UserAgent string associated with this instance

  public function __construct() {
    $this->url = 'http://www.ingboo.com/api';
    $this->useragent = 'IngBoo WPApp 1.0 PHP ' . phpversion();
  }

  public function __destruct() {
  }


  private function get_appclient_authkey() {
    $response = $this->do_client_login();
    if ($response) {
      return ($response["Auth"]);
    } else {
      return null;
    }
  }

  public function do_client_login() {
    try {
      /* Generate the base 64 encoding of SHA Digest of the (App Name.AppKey) string */
      $clientInfo = sha1('WPApp1174appPW', true);
      $encodedInfo = preg_replace('/[+]/s', '%2b',base64_encode($clientInfo) );
      $fields = "client=WPApp&password=".$encodedInfo;
      $ch = curl_init($this->url."/client/access");
      curl_setopt($ch, CURLOPT_POST,1);
      curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
      curl_setopt($ch,CURLOPT_FAILONERROR,false);
      curl_setopt($ch,CURLOPT_HEADER,true);
      $data = curl_exec($ch);
      $this->check_exception($ch, $data, null, IngbooAPIErrorCodes::API_EC_APP_CLIENT_AUTH_ERROR);
      curl_close($ch);
      $strArr = explode ("\r\n", $data);
      $arrSz = count($strArr);
      for ($i=0; $i < $arrSz; $i++) {
	$ret = explode("=", $strArr[$i], 2);
	if (count($ret) == 2) {
	  $response[$ret[0]] = preg_replace('/["]/s', '', $ret[1]);
	}
      }
      return ($response["Auth"]);
    } catch (Exception $e){
      throw $e;
    }
  }

  public function get_partner($partnerEmail, $partnerPassword) {
    try {
      /* Authenticate the FaceBook Application and get a authentication key */
      $authKey = $this->do_client_login();
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
      curl_setopt($ch, CURLOPT_URL, $this->url."/partner?username=$partnerEmail&password=$partnerPassword");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      /* Set the headers */
      curl_setopt($ch, CURLOPT_HTTPHEADER,
		  array('Authorization: IngbooClient auth='.$authKey));
      curl_setopt($ch,CURLOPT_FAILONERROR,false);
      curl_setopt($ch,CURLOPT_HEADER,true);
      $data = curl_exec($ch);
      // This will throw an exception if ther was any error with calling IngBoo Server
      $this->check_exception($ch, $data, "xml", IngbooAPIErrorCodes::API_EC_USER_ERROR, $xml);
      curl_close($ch);
      if ($xml->id == -1) {
	throw new IngbooRestClientException("Invalid Partner. ", IngbooApiErrorCodes::API_EC_USER_ERROR);
      }
      return  ($xml);
    } catch (Exception $e){
      throw $e;
    }
  }

  public function mk_pulse($pulseUrl, $partnerEmail, $partnerPassword,$imageRef) {
    try {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
      if ($imageRef===undefined || $imageRef=='') {
	curl_setopt($ch, CURLOPT_URL, $this->url."/partner/like?username=$partnerEmail&password=$partnerPassword&href=".urlencode($pulseUrl));
      } else {
	curl_setopt($ch, CURLOPT_URL, $this->url."/partner/like?username=$partnerEmail&password=$partnerPassword&href=".urlencode($pulseUrl)."&im=".urlencode($imageRef));
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch,CURLOPT_FAILONERROR,false);
      curl_setopt($ch,CURLOPT_HEADER,true);
      $data = curl_exec($ch);
      // This will throw an exception if ther was any error with calling IngBoo Server
      $this->check_exception($ch, $data, "xml", IngbooAPIErrorCodes::API_EC_USER_ERROR, $xml);
      curl_close($ch);
      if ($xml->id == -1) {
	throw new IngbooRestClientException("Invalid Partner. ", IngbooApiErrorCodes::API_EC_USER_ERROR);
      }
      return  ($xml);
    } catch (Exception $e){
      throw $e;
    }
  }

  /*
   * Checks if the CURL invocation had an error
   *
   */
  private function check_exception(&$ch, &$response, $expected_content, $code, &$xml=null) {
    $errno=curl_errno($ch);
    preg_match("!^HTTP/\S*\s*\d+\s*(.*?)\r\n.*\r\n\r\n(.*)$!s",$response,$parts);
    if ($errno!=0 && $errno!==22) {
      $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      error_log("ingboo-api-error: url=[$url] curl error ".curl_errno($ch)."[".curl_error($ch));
      curl_close($ch);
      throw new IngbooRestClientException("Error occurred when talking with IngBoo Server. ".$parts[1], $code);
    } else {
      $response=$parts[2];
      $ct = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpCode==200 || $httpCode==201) {
	if ($expected_content!=null && isset($ct) && isset($expected_content) && stristr($ct,$expected_content)!==false) {
	  if ($expected_content == "xml") {
	    $xml = simplexml_load_string($response);
	    if (!($xml instanceof SimpleXMLElement)) {
	      error_log("ingboo-api-error: url=[$url] httpCode[$httpCode] received Invalid XML response [$response]");
	      curl_close($ch);
	      throw new IngbooRestClientException("Invalid XML Response from IngBoo Server", $code);
	    }
	  }
	} else if ($expected_content === null) {
	  // Accept
	} else {
	  $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	  $httpErrorText = "curlErrorCode:".curl_errno($ch)." curlErrorText:".curl_error($ch);
	  $description = "Error occurred in Communicating with IngBoo Server.";
	  error_log("ingboo-api-error: url=[$url] httpCode[$httpCode] httpErrorText[$httpErrorText] expected[$expected_content] but got [$ct]. response[$response]");
	  curl_close($ch);
	  throw new IngbooRestClientException($description, $code);
	}
      } else if ($httpCode==202) {
	// Already existing subscription
      } else if ($httpCode==401) {
	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	$httpErrorText = "curlErrorCode:".curl_errno($ch)." curlErrorText:".curl_error($ch);
	$description = "Authorization failed. Invalid username or password.";
	error_log("ingboo-api-error: url=[$url] httpCode[$httpCode] httpErrorText[$httpErrorText] expected[$expected_content] but got [$ct]. response[$response]");
	curl_close($ch);
	throw new IngbooRestClientException($description, $code);
      } else {
	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
	$httpErrorText = "curlErrorCode:".curl_errno($ch)." curlErrorText:".curl_error($ch);
	$description = "Error occurred in Communicating with IngBoo Server. ".$parts[1];
	error_log("ingboo-api-error: url=[$url] httpCode[$httpCode] httpErrorText[$httpErrorText] expected[$expected_content] but got [$ct]. response[$response]");
	curl_close($ch);
	throw new IngbooRestClientException($description, $code);
      }
    }
  }
}

class IngbooRestClientException extends Exception {
}

class IngbooAPIErrorCodes {

  const API_EC_SUCCESS = 0;

  /*
   * GENERAL ERRORS
   */
  const API_EC_HTTP_ERROR = 1;

  /*
   * INGOO SPECIFIC ERRORS
   */
  const API_EC_CATALOG_ERROR = 100;
  const API_EC_PULSE_ERROR = 101;
  const API_EC_BUNDLE_ERROR = 102;
  const API_EC_SEARCH_ERROR = 103;
  const API_EC_USER_ERROR = 104;
  const API_EC_SUBSCRIPTION_ERROR = 105;
  const API_EC_ATL_ERROR = 106;
  const API_EC_APP_CLIENT_AUTH_ERROR = 107;
}
?>
