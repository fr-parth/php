<?php


$webHost = $_SERVER['SERVER_NAME'];
 $_SESSION['webHost']=$webHost;

 $isSmartCookie=strpos($webHost, 'cookie')==true;
$_SESSION['isSmartCookie']=$isSmartCookie;


//SMC-3480 - This code added by Pravin on 2018-09-19
//All core/.... and core/Version2/....  files are used this common code 

//standard date format and time zone 
date_default_timezone_set("Asia/Kolkata");
define('CURRENT_TIMESTAMP',date('Y-m-d H:i:s'));

//define common standard limit 
$limit=20;

$webpagelimit=10;

//SMC-5166 by Pranali : added below 3 new variables for sending sms through smswave
$msgType="PT"; //PT –Used for English Message text
$pe_id="1701159109114765936"; //Primary Entity ID approved on DLT platform
$template_id=""; //Approved Template ID from DLT platform

function map_check_limit($map){
	if($map=='map')
	{
		$limit=100;
	}
	else{
		$limit=20;
	}
	
	return $limit;
}


//check default offset function
function offset($offset){
if($offset=='' || (!is_numeric($offset) ||$offset < 0 ))
	{
	$offset=0;
	}
	return $offset;
}
//End SMC-3480


//URL call if http or https
 global $url_name;
 
function url(){
 return sprintf(
   "%s://%s",
   isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
   $_SERVER['SERVER_NAME']
 );
}
 
 //$url_name = url();
 $GLOBALS['URLNAME']= url();




define('TEACHER_IMG_PATH',url().'/teacher_images/'); //teacher image path
define('WEB_SERVICE_PATH',url().'/core/Version3/');
define('SEND_MAIL_PATH',url().'/core/clickmail/sendmail_new.php'); //teacher image path

//Added SEND_SMS_PATH by Pranali for SMC-5166 

define('SEND_SMS_PATH','http://www.smswave.in/panel/sendsms2021ack.php'); //sms wave url


//clean string function used to clean the string from unwanted characters
function clean_string($string)
{
	$cleaned_string= preg_replace("~[^A-Za-z0-9- \:\/\.\@\_]~i", "", $string);
	return $cleaned_string;
}



// xecho function used before echo or print the php variables

function xecho($data)
{
   $result = xssafe($data);
   return $result;
}

function xssafe($data,$encoding='UTF-8')
{
   return htmlspecialchars($data,ENT_QUOTES | ENT_HTML401,$encoding);
}

//End of xecho function

//function to post parameters/values on any other page
function post_function($url,$myvars)
{
	//print_r($url);exit;
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

	$res = curl_exec( $ch );
	return $res;

}

// xss_clean function used before input type of text 

function xss_clean($data)
{
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	// we are done...
	return $data;
}
function get_curl_result($url,$data)
	{
		$ch = curl_init($url); 			
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));$result = json_decode(curl_exec($ch),true);
		return $result;
	}

//end of function xss-clean



?>