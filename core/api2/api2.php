<?php


require_once("Rest.inc.php");

	class API extends REST {

		public $data = "";
		const demo_version = false;

		private $db 	= NULL;
		private $mysqli = NULL;
		public function __construct() {
			// Init parent contructor
			parent::__construct();
			// Initiate Database connection
			$this->dbConnect();
			//error_reporting(E_ALL);
			error_reporting(E_ERROR | E_PARSE);
			ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
		}

		/*
		 *  Connect to Database
		*/
		private function dbConnect() {
			require_once ("../connsqli.php");
			$this->mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
			$this->mysqli->query('SET CHARACTER SET utf8');
		}

		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi() {
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('Ooops, no method found!',404); // If the method not exist with in this class "Page not found".
		}

		/* Api Checker */
		private function checkConnection() {
			if (mysqli_ping($this->mysqli)) {
				//echo "Responses : Congratulations, database successfully connected.";
                $respon = array(
                    'status' => 'ok', 'database' => 'connected'
                );
                $this->response($this->json($respon), 200);
			} else {
                $respon = array(
                    'status' => 'failed', 'database' => 'not connected'
                );
                $this->response($this->json($respon), 404);
			}
		}

		// Inserted by Tapan 
			
				
			private function user_logs() {
				include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
				$api_key_get = $obj->api_key;
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($conn, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					$App_Name = $obj->App_Name;
					$UserID = $obj->UserID;
					$Action = $obj->Action;
					$ActionStartTime = $obj->ActionStartTime;
					$ActionEndTime = $obj->ActionEndTime;
					$DeviceName=$obj->DeviceName;
					$DeviceTokan = $obj->DeviceTokan;
					$IPAddress = $obj->IPAddress;
					$OSVersion = $obj->OSVersion;
					$CountryCode = $obj->CountryCode;
					$PosLat = $obj->PosLat;
					$PosLong = $obj->PosLong;
					$college_id = $obj->college_id;
					$college_name = $obj->college_name;
					$date = $obj->dates;
					$channel_id = $obj->channel_id;
					$current_track_id = $obj->current_track;
					$city = $obj->city;
					$state = $obj->state;
					$country = $obj->country;
					$CategoryID = $obj->CategoryID;
					
					
					
					if($Action == 'pause'){
						$time_diff55 = strtotime($ActionEndTime) - strtotime($ActionStartTime);
						
						$minis = round($time_diff55 / 60);
						
						$given_points = round($minis / 5);
						
						
						$sqluserquery = mysqli_query($conn,"select * from yt_registartion where id='$UserID'");
						$fetchpoint = mysqli_fetch_array($sqluserquery);
						$user_points = $fetchpoint['user_reward_points'];
						
						$add_user_reward_points = $user_points + $given_points;
						
						$updaterewards = mysqli_query($conn,"UPDATE yt_registartion SET user_reward_points='$add_user_reward_points' WHERE id='$UserID'");
						
						
						$insertpointlog = mysqli_query($conn,"INSERT INTO user_points (action_start,action_end,channel_id,total_duration,user_id,date,total_points,given_point) VALUES ('play','pause','$channel_id','$time_diff55','$UserID','$date','$add_user_reward_points','$given_points')");
					}
						
					if($ActionEndTime != ""){
					$time_diff = strtotime($ActionEndTime) - strtotime($ActionStartTime);
					}else{
						$time_diff = "";
					}
					
					if($Action == 'Logout')
					{
						$sqlquery = mysqli_query($conn,"select * from yt_user_logs_history where UserID='$UserID' and Action='Login' order by id desc limit 1");
						$fetchtime = mysqli_fetch_array($sqlquery);
						
						$ActionStartTimelogin = $fetchtime['ActionStartTime'];
						$datelogin = $fetchtime['date'];
						 $ActionStartTimelogin2 = $datelogin." ".$ActionStartTimelogin;
						 $ActionendTimelogout2 = $date." ".$ActionEndTime;
						
					     $time_diff = strtotime($ActionendTimelogout2) - strtotime($ActionStartTimelogin2);
						
						$minis = round($time_diff / 60);
						
						
						$sqluserquery = mysqli_query($conn,"select * from yt_registartion where id='$UserID'");
						$fetchpoint = mysqli_fetch_array($sqluserquery);
						$user_points = $fetchpoint['user_reward_points'];
						
						$add_user_reward_points = $user_points + $minis;
						
						$updaterewards = mysqli_query($conn,"UPDATE yt_registartion SET user_reward_points='$add_user_reward_points' WHERE id='$UserID'");
						
						
						$insertpointlog = mysqli_query($conn,"INSERT INTO user_points (action_start,action_end,total_duration,user_id,date,total_points,given_point) VALUES ('Login','Logout','$time_diff88','$UserID','$date','$add_user_reward_points','$minis')");
					}
					
					if($current_track_id == ""){
						$current_track_id = "";
					}else{
						$current_track_id = $current_track_id;
					}
					$query = "select * from yt_user_logs where UserID='$UserID'";
					$queryresult = mysqli_query($conn,$query);
					$rows = mysqli_num_rows($queryresult);
					if($rows > 0){
						if($ActionEndTime == ""){
							$sql2 = "UPDATE yt_user_logs SET App_Name='$App_Name',Action='$Action',ActionStartTime='$ActionStartTime',ActionEndTime='$ActionEndTime',DeviceName='$DeviceName',DeviceTokan='$DeviceTokan',IPAddress='$IPAddress',OSVersion='$OSVersion',CountryCode='$CountryCode',PosLat='$PosLat',PosLong='$PosLong',college_id='$college_id',college_name='$college_name',date='$date',channel_id='$channel_id' where UserID='$UserID'";
					$result = mysqli_query($conn,$sql2);
					
					
						}else{
							$sql3 = "UPDATE yt_user_logs SET App_Name='$App_Name',Action='$Action',ActionEndTime='$ActionEndTime',DeviceName='$DeviceName',DeviceTokan='$DeviceTokan',IPAddress='$IPAddress',OSVersion='$OSVersion',CountryCode='$CountryCode',PosLat='$PosLat',PosLong='$PosLong',college_id='$college_id',college_name='$college_name',date='$date',channel_id='$channel_id' where UserID='$UserID'";
							$result = mysqli_query($conn,$sql3);
						}
						
						$sql4 = "INSERT INTO yt_user_logs_history (App_Name,UserID,Action,ActionStartTime,ActionEndTime,DeviceName,DeviceTokan,IPAddress,OSVersion,CountryCode,PosLat,PosLong,college_id,college_name,date,channel_id,Action_Duration,current_track_id,city,state,country,CategoryID) VALUES ('$App_Name','$UserID','$Action','$ActionStartTime','$ActionEndTime','$DeviceName','$DeviceTokan','$IPAddress','$OSVersion','$CountryCode','$PosLat','$PosLong','$college_id','$college_name','$date','$channel_id','$time_diff','$current_track_id','$city','$state','$country','$CategoryID')";
					$result4 = mysqli_query($conn,$sql4);
					}else{
					$sql = "INSERT INTO yt_user_logs (App_Name,UserID,Action,ActionStartTime,ActionEndTime,DeviceName,DeviceTokan,IPAddress,OSVersion,CountryCode,PosLat,PosLong,college_id,college_name,date,channel_id) VALUES ('$App_Name','$UserID','$Action','$ActionStartTime','$ActionEndTime','$DeviceName','$DeviceTokan','$IPAddress','$OSVersion','$CountryCode','$PosLat','$PosLong','$college_id','$college_name','$date','$channel_id')";
					$result = mysqli_query($conn,$sql);
					
					$sql5 = "INSERT INTO yt_user_logs_history (App_Name,UserID,Action,ActionStartTime,ActionEndTime,DeviceName,DeviceTokan,IPAddress,OSVersion,CountryCode,PosLat,PosLong,college_id,college_name,date,channel_id,Action_Duration,current_track_id,city,state,country,CategoryID) VALUES ('$App_Name','$UserID','$Action','$ActionStartTime','$ActionEndTime','$DeviceName','$DeviceTokan','$IPAddress','$OSVersion','$CountryCode','$PosLat','$PosLong','$college_id','$college_name','$date','$channel_id','$time_diff','$current_track_id','$city','$state','$country','$CategoryID')";
					$result5 = mysqli_query($conn,$sql5);
					}
					if($result > 0){
					    $postvalue['responseStatus'] = 200;
						$postvalue['responseMessage'] = "OK";
						$response = json_encode($postvalue);
						 print $response;
					}else{
						$postvalue['responseStatus'] = 202;
						$postvalue['responseMessage'] = "Not Inserted";
						$response = json_encode($postvalue);
						 print $response;
					}
				}else{
					            $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "API_KEY not correct please check!";	
								$response = json_encode($postvalue);
							    print $response;
				}
			}
			
			
		
					
		private function user_log_shows() {
				include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
				$api_key_get = $obj->api_key; 
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($conn, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				if($api_key_get == $api_key){
					$user_id = $obj->user_id;
					$sql = "select * from yt_user_logs_history where UserID = '$user_id'";
					$result = mysqli_query($conn, $sql);
					$count = mysqli_num_rows($result);
					while($row = mysqli_fetch_array($result)){
						$App_Name = $row['App_Name'];
						$Action = $row['Action'];
						$ActionStartTime = $row['ActionStartTime'];
						$ActionEndTime = $row['ActionEndTime'];
						
						$info[] = array('App_Name'=>$App_Name,'Action'=>$Action,'Start_Time'=>$ActionStartTime,'End_Time'=>$ActionEndTime);
						
					}
					if($count > 0){
						        $postvalue['responseStatus'] = 200;
								$postvalue['responseMessage'] = "Ok";	
								$postvalue['data'] = $info;
								$response = json_encode($postvalue);
							    print $response;
					}else{
						        $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "User Not Found Please Enter Correct id";
								$response = json_encode($postvalue);
							    print $response;
					}
				}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
			}
			
			private function FAQ_get() {
				include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
				$api_key_get = $obj->api_key; 
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($conn, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					$sql = "select * from tbl_faq_table order by id asc";
					$result = mysqli_query($conn, $sql);
					$count = mysqli_num_rows($result);
					while($row = mysqli_fetch_array($result)){
						$id = $row['id'];
						$question = $row['question'];
						$answer = $row['answer'];
						$question_catagory = $row['question_catagory'];
						$info[] = array('QuestionId'=>$id,'Question'=>$question,'Answer'=>$answer,'Question_Catagory'=>$question_catagory);
					}
					
					if($count > 0){
						$postvalue['responseStatus'] = 200;
								$postvalue['responseMessage'] = "OK";
								$postvalue['Question_List'] = $info;
								$response = json_encode($postvalue);
							print $response;
					}else{
						  $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "Data Not Found,Please Try Again!";
								$response = json_encode($postvalue);
							print $response;
					}
				}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
				
			}
			
			
				
			private function get_url_api() {
				include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
				$api_key_get = $obj->api_key; 
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($connect, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					$type = $obj->type;
					
					$sql = "SELECT * FROM tbl_others WHERE key_name='Url' AND values_name='$type'";
					$result = mysqli_query($connect, $sql);
					$count = mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					$url = $row['Description'];
					
					
					if($count > 0){
						$postvalue['responseStatus'] = 200;
								$postvalue['responseMessage'] = "OK";
								$postvalue['url'] = $url;
								$response = json_encode($postvalue);
							print $response;
					}else{
						$postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "Please Select Correct Type!";
								$response = json_encode($postvalue);
							print $response;
					}
				}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
				
			}
			

			
			
			
private function get_user_action() {
	include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
	$api_key_get = $obj->api_key; 
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($conn, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				if($api_key_get == $api_key){
					$sql = "select * from tbl_others where key_name='User_Action'";
					$result = mysqli_query($conn,$sql);
					$count = mysqli_num_rows($result);
					while($row = mysqli_fetch_array($result)){
						$values_name = $row['values_name'];
						$post[] = array("Values"=>$values_name);
					}
					if($count > 0){
						$postvalue['responseStatus'] = 200;
	                       $postvalue['responseMessage'] = "OK";
						   $postvalue['User_Action'] = $post;
	                       $response = json_encode($postvalue);
	                       print $response;
					}else{
						$postvalue['responseStatus'] = 204;
	                     $postvalue['responseMessage'] = "No Result Found";
	                     $response = json_encode($postvalue);
	                     print $response;
					}
				}else{
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
}

	
		
	private function send_otp() {
			
			include "../connsqli.php";
			include "../securityfunctions.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
	
			$api_key_get = $obj->api_key; 
			$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
			$setting_result = mysqli_query($conn, $setting_qry);
			$settings_row   = mysqli_fetch_assoc($setting_result);
			$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					$country_code = $obj->country_code;
					$phonenumber = $obj->phone_number;
					$email_id = $obj->email_id;
					$msg_id = $obj->msg;
					$User_school_id = $obj->school_id;
					$User_school_name = $obj->school_name;
					$entity_type = $obj->entity_type;
					$reason = $obj->reason;
					$delivery_method = $obj->delivery_method;
					
					$otpnumber = mt_rand(1000, 9999);
					
					if($phonenumber != '')
					{
						$phone_email_type = 'PhoneNumber';
					}
					if($email_id != '')
					{
						$phone_email_type = 'EmailID';
					}
					
					$res_sms = mysqli_query($conn,"select subject,sms_body,template_id_sms,email_body from tbl_email_sms_templates where type ='$msg_id'");
					 $row_sms= mysqli_fetch_array($res_sms);
					 $template_id = $row_sms['template_id_sms'];
					 $subject = $row_sms['subject'];
					 $email_body = $row_sms['email_body'];
					 $sms_body = $row_sms['sms_body'];
					 $OTPResponse=str_replace("{otpnumber}", $otpnumber, $sms_body);
					 $email_body=str_replace("{otpnumber}", $otpnumber, $email_body);
					
					$query = "select * from tbl_otp where id='1'";
					$reusltquery = mysqli_query($conn,$query);
					$row = mysqli_fetch_array($reusltquery);
					$user = $row['mobileno'];
					$password = $row['email'];
					$senderid = $row['otp'];
					
					$query2 = "select * from tbl_email_parameters where e_id='1'";
					$reusltquery2 = mysqli_query($conn,$query2);
					$row2 = mysqli_fetch_array($reusltquery2);
					$user2 = $row2['email_id'];
					$password2 = $row2['email_password'];
					$host = $row2['host'];
					$port = $row2['port'];
					
					if($country_code != "" && $phonenumber != "" && $email_id == ""){
					if($country_code == '+91' || $country_code == '91'){
					
					$request ="";

					$param["user"] = $user;
					$param["password"] = $password;
					$param["sender"] = $senderid;
					$param["PhoneNumber"] = "$phonenumber";
					$param["Text"] = "$OTPResponse";
					$param["msgType"] = $msgType;
					$param['pe_id'] = $pe_id;
					$param['template_id'] = $template_id;
					foreach($param as $key=>$val)
					{
					$request.= $key."=".urlencode($val);

					$request.= "&";

}

					$request = substr($request, 0, strlen($request)-1);
				    $url = SEND_SMS_PATH."?".$request;
				    //echo $url;
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$curl_scraped_page = curl_exec($ch);
					curl_close($ch);
					//echo "scriptpage :";
					//echo $curl_scraped_page;
					//echo "<br>";
                    $xml = simplexml_load_string($curl_scraped_page);
                    // echo "xml: ";
                    // print_r($xml);
                    
                    $array=Json_encode($xml,true);
                    $array=Json_decode($array,true);
        			//$array['ack_id'];
        			//echo "Array :";
                    //print_r($array);
        			// echo "Array['Ack_id'] :";
        			// echo $array['ack_id'];
            if($array['ack_id']!=""){
	        $sql = "insert into tbl_otp (otp,mobileno) values ('$otpnumber','$phonenumber')";
            $result = mysqli_query($conn,$sql);
			
			$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$otpnumber', '1')");
			
			                $postvalue['responseStatus'] = 200;
							$postvalue['responseMessage'] = "OK";
							$response = json_encode($postvalue);
							print $response;
            }else{
				$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$otpnumber', '0')");
	                             $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "Failed to Send OTP please try again";
								$response = json_encode($postvalue);
							print $response;
                 }
		 }
		else if($country_code != '+91' || $country_code != '91'){

require 'twilio.php';

$ApiVersion = "2010-04-01";
            // set our AccountSid and AuthToken
            $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
            $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
            // instantiate a new Twilio Rest Client
            $client = new TwilioRestClient($AccountSid, $AuthToken);
            $number = $country_code ."". $phonenumber;
            $message = "$OTPResponse";
            $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
                "POST", array(
                    "To" => $number,
                    "From" => "732-798-7878",
                    "Body" => $message
                ));
$myArray = json_decode(json_encode($response), true);
$HttpStatus = $myArray['HttpStatus'];

if($HttpStatus == 400){
	
	$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$otpnumber', '0')");
	
$postvalue['responseStatus'] = 204;
$postvalue['responseMessage'] = "Failed to Send OTP please try again";
$response = json_encode($postvalue);
print $response;
}else{
$sql = "insert into tbl_otp (otp,mobileno) values ('$otpnumber','$phonenumber')";
            $result = mysqli_query($conn,$sql);
			
			$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$otpnumber', '1')");

                   $postvalue['responseStatus'] = 200;
$postvalue['responseMessage'] = "OK";
$response = json_encode($postvalue);
print $response;
}
}		
					
				}	
				
if($phonenumber == "" && $email_id != ""){
$name = $obj->name;
					
error_reporting(0);
define("SMTP_HOST", "SMTP_HOST_NAME");
define("SMTP_PORT", "SMTP_PORT");
define("SMTP_UNAME", "VALID_EMAIL_ACCOUNT"); 
define("SMTP_PWORD", "VALID_EMAIL_ACCOUNTS_PASSWORD"); 
include "class.phpmailer.php";
$myFile ="emaillog.txt";
$mail = new PHPMailer;
$mail->IsSMTP(); 
$mail->Host =$host; 
$mail->Port = $port;
$mail->SMTPAuth = true; 
$mail->Username = $user2; 
$mail->Password = $password2; 
$mail->AddReplyTo($user2, "SmartCookie"); 
$mail->SetFrom($user2, "SmartCookie"); 
$mail->AddAddress( "$email_id", "tapan");
$mail->Subject = "Smart Cookie OTP" ;
$mail->MsgHTML( $email_body ); 
 $send =$mail->Send();

if($send) {
	$sql = "insert into tbl_otp (otp,email) values ('$otpnumber','$email_id')";
    $result = mysqli_query($conn,$sql);
	
	$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$email_id', '$otpnumber', '1')");
	
	$postvalue['responseStatus'] = 200;
	$postvalue['responseMessage'] = "OK";
	$response = json_encode($postvalue);
	print $response;
   
}
else {
	
	$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$email_id', '$otpnumber', '0')");
	
	$postvalue['responseStatus'] = 204;
	$postvalue['responseMessage'] = "Failed to Send OTP please try again";
	$response = json_encode($postvalue);
	print $response;
	
}	
					
}
				
	}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
			}
			
}



private function send_message() {

			
			include "../connsqli.php";
			include "../securityfunctions.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
	
			$api_key_get = $obj->api_key; 
			$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
			$setting_result = mysqli_query($conn, $setting_qry);
			$settings_row   = mysqli_fetch_assoc($setting_result);
			$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					    $country_code = $obj->country_code;
					    $phonenumber = $obj->phone_number;
					    $email_id = $obj->email_id;
					    $msg_id = $obj->msg;
					    $User_school_id = $obj->school_id;
					    $User_school_name = $obj->school_name;
					    $entity_type = $obj->entity_type;
					    $reason = $obj->reason;
					    $delivery_method = $obj->delivery_method;
				        $pass=$obj->password;
				        $username=$obj->username;
					if($phonenumber != '')
					{
						$phone_email_type = 'PhoneNumber';
					}
					if($email_id != '')
					{
						$phone_email_type = 'EmailID';
					}

					$res_sms = mysqli_query($conn,"select id,sms_body,template_id_sms from tbl_email_sms_templates where id ='$msg_id'");

					 $row_sms= mysqli_fetch_array($res_sms);
					 $template_id = $row_sms['template_id_sms'];
					 $sms_body = $row_sms['sms_body'];
					 $temp_id=$row_sms['id'];

					 $OTPResponse=str_replace("{email}", $email_id, $sms_body);
					 $OTPResponse=str_replace("{school_id}", $User_school_id, $OTPResponse);
					 $OTPResponse=str_replace("{pass}", $pass, $OTPResponse);
					 $OTPResponse=str_replace("{site}", "https://smartcookie.in", $OTPResponse);
					 
					 $email_body=str_replace("{otpnumber}", $otpnumber, $OTPResponse);
					
					$query = "select * from tbl_otp where id='1'";
					$reusltquery = mysqli_query($conn,$query);
					$row = mysqli_fetch_array($reusltquery);
					$user = $row['mobileno'];
					$password = $row['email'];
					$senderid = $row['otp'];
					
					if($country_code == '+91' || $country_code == '91'){
					
					$request ="";

					$param["user"] = $user;
					$param["password"] = $password;
					$param["sender"] = $senderid;
					$param["PhoneNumber"] = $phonenumber;
					$param["Text"] = $OTPResponse;
					$param["msgType"] = $msgType;
					$param['pe_id'] = $pe_id;
					$param['template_id'] = $template_id;
					foreach($param as $key=>$val)
					{
					$request.= $key."=".urlencode($val);

					$request.= "&";

                    }

					$request = substr($request, 0, strlen($request)-1);
					$url = SEND_SMS_PATH."?".$request;//echo $url;exit;
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$curl_scraped_page = curl_exec($ch);
					curl_close($ch);
				    $xml = simplexml_load_string($curl_scraped_page);
                    $array=Json_decode(Json_encode($xml),true);
        			$array['ErrorCode'];
					
            if($array['ErrorCode']!='103'){
	       

			$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, template_id, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$temp_id', '1')");
			
			                $postvalue['responseStatus'] = 200;
							$postvalue['responseMessage'] = "OK";
							$response = json_encode($postvalue);
							print $response;
            }else{
				$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, template_id, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$temp_id', '0')");
	                             $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "Failed to Send OTP please try again";
								$response = json_encode($postvalue);
							print $response;
                 }
		 }
		else if($country_code != '+91' || $country_code != '91'){

require 'twilio.php';

$ApiVersion = "2010-04-01";
            // set our AccountSid and AuthToken
            $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
            $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
            // instantiate a new Twilio Rest Client
            $client = new TwilioRestClient($AccountSid, $AuthToken);
            $number = $country_code ."". $phonenumber;
            $message = "$OTPResponse";
            $response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
                "POST", array(
                    "To" => $number,
                    "From" => "732-798-7878",
                    "Body" => $message
                ));
$myArray = json_decode(json_encode($response), true);
$HttpStatus = $myArray['HttpStatus'];
if($HttpStatus == 400){
	
	$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$sms_body', '0')");
	
$postvalue['responseStatus'] = 204;
$postvalue['responseMessage'] = "Failed to Send OTP please try again";
$response = json_encode($postvalue);
print $response;
}else{

			
			$otp_log_sql=mysqli_query($conn,"insert into tbl_otp_log (school_id, school_name, entity_type, reason, delivery_method, phone_email_type, phone_email, otp, status) values ('$User_school_id', '$User_school_name', '$entity_type', '$reason', '$delivery_method', '$phone_email_type', '$phonenumber', '$sms_body', '1')");

                   $postvalue['responseStatus'] = 200;
$postvalue['responseMessage'] = "OK";
$response = json_encode($postvalue);
print $response;
}
}		
					
				
						
	}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
			}
			
}

private function show_otp_logs() {
			
			include "../connsqli.php";
			include "../securityfunctions.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
	
			$api_key_get = $obj->api_key; 
			$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
			$setting_result = mysqli_query($conn, $setting_qry);
			$settings_row   = mysqli_fetch_assoc($setting_result);
			$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					
					$phone_otp_pass_sql = mysqli_query($conn,"select * from tbl_otp_log where status='1' and phone_email_type='PhoneNumber' and otp!=''");
					$phone_otp_fail_sql = mysqli_query($conn,"select * from tbl_otp_log where status='0' and phone_email_type='PhoneNumber' and otp!=''");
				
                     $phone_pass_sql = mysqli_query($conn,"select * from tbl_otp_log where status='1' and phone_email_type='PhoneNumber' and otp=''");
					$phone_fail_sql = mysqli_query($conn,"select * from tbl_otp_log where status='0' and phone_email_type='PhoneNumber'and otp=''");
				

					$email_pass_sql = mysqli_query($conn,"select * from tbl_otp_log where status='1' and phone_email_type='EmailID'");
					$email_fail_sql = mysqli_query($conn,"select * from tbl_otp_log where status='0' and phone_email_type='EmailID'");
					
					$json_otp_phone_pass_sql = array();
					$json_otp_phone_fail_sql = array();
					$json_phone_pass_sql = array();
					$json_phone_fail_sql = array();
				
					$json_email_pass_sql = array();
					$json_email_fail_sql = array();
					
					while($phone_otp_pass_row = mysqli_fetch_assoc($phone_otp_pass_sql))
					{
						$json_otp_phone_pass_sql[] = $phone_otp_pass_row;
					}
					while($phone_otp_fail_row = mysqli_fetch_assoc($phone_otp_fail_sql))
					{
						$json_otp_phone_fail_sql[] = $phone_otp_fail_row;
					}

					while($phone_pass_row = mysqli_fetch_assoc($phone_pass_sql))
					{
						$json_phone_pass_sql[] = $phone_pass_row;
					}
					while($phone_fail_row = mysqli_fetch_assoc($phone_fail_sql))
					{
						$json_phone_fail_sql[] = $phone_fail_row;
					}

					while($email_pass_row = mysqli_fetch_assoc($email_pass_sql))
					{
						$json_email_pass_sql[] = $email_pass_row;
					}
					while($email_fail_row = mysqli_fetch_assoc($email_fail_sql))
					{
						$json_email_fail_sql[] = $email_fail_row;
					}
					
				    $postvalue['responseStatus'] = 200;
					$postvalue['responseMessage'] = "OK";
					$postvalue['SuccessOTPmsgOnPhone'] = $json_otp_phone_pass_sql;
					$postvalue['FailedOTPmsgOnPhone'] = $json_otp_phone_fail_sql;
					
                    $postvalue['SuccessmsgOnPhone'] = $json_phone_pass_sql;
					$postvalue['FailedmsgOnPhone'] = $json_phone_fail_sql;
					
					$postvalue['SuccessOTPmsgOnEmail'] = $json_email_pass_sql;
					$postvalue['SuccessOTPmsgOnEmail'] = $json_email_fail_sql;
					$response = json_encode($postvalue);
					print $response;
					
					}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
			}
}

			private function varify_otp() {
				include "../connsqli.php";
			date_default_timezone_set("Asia/Kolkata");
			$json = file_get_contents('php://input');
			$obj = json_decode($json);
			$operation = $obj->operation;
			
				$api_key_get = $obj->api_key; 
				$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";
				$setting_result = mysqli_query($conn, $setting_qry);
				$settings_row   = mysqli_fetch_assoc($setting_result);
				$api_key    = $settings_row['api_key'];
				
				if($api_key_get == $api_key){
					$phonenumber1 = $obj->phone_number;
					$email_id = $obj->email_id;
					$otp = $obj->otp;
					$phonenumber =  substr($phonenumber1,-10);
					if($phonenumber !="" && $email_id == ""){
						$a = "mobileno='$phonenumber' AND otp='$otp'";
						$b = "mobileno='$phonenumber'";
						
					}
					if($phonenumber =="" && $email_id != ""){
						$a = "email='$email_id' AND otp='$otp'";
						$b = "email='$email_id'";
						
					}
					$sql = "select * from tbl_otp where $a";
					$result = mysqli_query($conn,$sql);
					$count = mysqli_num_rows($result);
					if($count > 0){
						$query = "delete from tbl_otp where $b";
						$queryresult = mysqli_query($conn,$query);
						
						$postvalue['responseStatus'] = 200;
								$postvalue['responseMessage'] = "OTP Verifyed";
								$response = json_encode($postvalue);
							print $response;
							
							
					}else{
						        $postvalue['responseStatus'] = 204;
								$postvalue['responseMessage'] = "Your Contact And OTP are not matched";
								$response = json_encode($postvalue);
							print $response;
					}
				}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
			
			}

			private function school_activation(){
					include "../connsqli.php";
					$json = file_get_contents('php://input');
					$obj = json_decode($json);
					$school_id = $obj->school_id;
					$email_id = $obj->email_id;
					$passwrd = $obj->password;
					$key = $obj->key;
					$api_get_key=$obj->api_key;
					$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";	
					$setting_result = mysqli_query($conn, $setting_qry);
					$settings_row   = mysqli_fetch_assoc($setting_result);
					$api_key    = $settings_row['api_key'];
					if($api_get_key==$api_key){
						if($school_id!='' && $email_id!=''){
							if($key==1){
									$sql2="update tbl_school_admin set is_accept_terms='1' where school_id='$school_id'";
									$key_result = mysqli_query($conn, $sql2);
									if($key_result){
										$postvalue['responseStatus'] = 200;
										$postvalue['responseMessage'] = "T&C Accepted";
										$response = json_encode($postvalue);
										print $response;
									}
							}
							if($key==2){	
								if($passwrd!=""){
									$sql2="update tbl_school_admin set password='$passwrd' where school_id='$school_id'";
									$key_result = mysqli_query($conn, $sql2);
									if($key_result){
										$postvalue['responseStatus'] = 200;
										$postvalue['responseMessage'] = "Password is changed";
										$response = json_encode($postvalue);
										print $response;
									}
									}else{
										$postvalue['responseStatus'] = 204;
										$postvalue['responseMessage'] = "Password can not be null.";
										$response = json_encode($postvalue);
										print $response;
								
									}
							}
						}
						else{
							$postvalue['responseStatus'] = 204;
							$postvalue['responseMessage'] = "Your school id and email id should not be blank!!";
							$response = json_encode($postvalue);
							print $response;
						}
					}else {
					$postvalue['responseStatus'] = 206;
					$postvalue['responseMessage'] = 'Oops, API Key is Incorrect!';
					$response = json_encode($postvalue);
					print $response;
				}
					
			}
		
		private function responseInvalidParam() {
			$resp = array("status" => 'Failed', "msg" => 'Invalid Parameter' );
			$this->response($this->json($resp), 200);
		}

		/* ==================================== End of API utilities ==========================================
		 * ====================================================================================================
		 */

		/* Encode array into JSON */
		private function json($data) {
			if(is_array($data)) {
				return json_encode($data, JSON_NUMERIC_CHECK);
			}
		}

		/* String mysqli_real_escape_string */
		private function real_escape($s) {
			return mysqli_real_escape_string($this->mysqli, $s);
		}
	}

	// Initiate Library
	$api = new API;
	$api->processApi();
?>
