

<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save
if ($obj->{'User_Name'} != '' && $obj->{'User_email'} != '' && $obj->{'User_pass'} != '' && $obj->{'sp_phone'} != '' && $obj->{'Lattitude'} && $obj->{'Longitude'} != '' && $obj->{'country_code'} != '' && $obj->{'sales_p_lon'} != ''  && $obj->{'sales_p_lat'} != '' && $obj->{'User_Image'}!='' && $obj->{'User_imagebase64'})
	{

    //include 'conn.php';
	require 'conn.php';
	require "twilio.php";
	
	$sponsor_name=mysql_escape_string($obj->{'User_Name'});
    $company_name = mysql_escape_string($obj->{'Company_Name'});
    $lat = $obj->{'Lattitude'};
    $lon = $obj->{'Longitude'};
	$sales_p_lon = $obj->{'sales_p_lon'};
	$sales_p_lat = $obj->{'sales_p_lat'};    
	
    $pin = $obj->{'pin'};
    $sp_email = $obj->{'User_email'};
    $sp_address = $obj->{'sp_address'};
    $sp_city = $obj->{'city'};
    $sp_state = $obj->{'state'};
    $pass = $obj->{'User_pass'};
    $amount = $obj->{'amount'};
    $sp_phone = $obj->{'sp_phone'};
    $sp_country = $obj->{'country'};
    $country_code = $obj->{'country_code'};	
	
	if($country_code==91)
	{
		date_default_timezone_set("Asia/Calcutta");
		$dates = date("Y-m-d h:i:s A");
	}
	elseif($country_code==1)
	{
		date_default_timezone_set("America/Boa_Vista");
		$dates = date("Y-m-d h:i:s A");
	}
	
	
	
    $sp_sales_person_id = $obj->{'sales_person_id'};	
    $sp_status = $obj->{'sp_status'};	                 //Sponsor status
    $sp_product_category = $obj->{'sp_product_category'};	 //Sponsor category
	$callback_date_time = $obj->{'callback_date_time'};
	$v_responce_status = $obj->{'v_responce_status'};
	$comment = $obj->{'comment'};
	$platform_source = $obj->{'platform_source'};
	$app_version = $obj->{'app_version'};
	$payment_method = $obj->{'source'};
    $amount1 = $amount / 100;

    if ($amount1 != 0) {

        $add_days = 365 * $amount1;
        $date = date('m/d/Y');
        $date1 = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));

    }

    if ($amount1 == 0) {
        $add_days = 15;
        $date = date('m/d/Y');
        $date1 = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));
        $amount = "Free Registration";

    }	
   $calculated_json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$sp_address&sensor=false&region=$region");
    $calculated_json = json_decode($calculated_json);

    $calculated_lat = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $calculated_lon = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};


  $test = mysql_query("INSERT INTO `tbl_sponsorer`(sp_name,sp_company,sp_email,CountryCode,v_status,v_category, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin,comment,calback_date_time,v_responce_status,sales_p_lat,sales_p_lon,platform_source,app_version,payment_method,calculated_lat,calculated_lon)VALUES('$sponsor_name','$company_name','$sp_email','$country_code','$sp_status','$sp_product_category', '$pass','$sp_address','$sp_phone','$sp_city','$sp_state','$sp_country','$sp_sales_person_id','$lat','$lon','$dates','$date1','$amount','$pin','$comment','$callback_date_time','$v_responce_status','$sales_p_lat','$sales_p_lon','$platform_source','$app_version','$payment_method','$calculated_lat','$calculated_lon')");
    $memberid =  mysql_insert_id();
    $member_id = "M" . str_pad($memberid, 11, "0", STR_PAD_LEFT);
	
	
	
	
	
    $imageDataEncoded = $obj->{'User_imagebase64'};
    $img = $obj->{'User_Image'};
    $ex_img = explode(".", $img);
    $img_name = $ex_img[0] . "_" . $memberid . "_" . date('mdY');
    $full_name_path = "image_sponsor/" . $img_name . "." . $ex_img[1];
    $imageName = "../".$full_name_path;
	 $imageData = base64_decode($imageDataEncoded);
	 $source = imagecreatefromstring($imageData);
	 $imageSave = imagejpeg($source,$imageName,100);
	 
	 mysql_query("update tbl_sponsorer set sp_img_path='$full_name_path' where id='$memberid'");
	 mysql_close($con);
	 
 if($imageSave)
 {
		
	
	
	$site = $_SERVER['HTTP_HOST'];
	$msgid='welcomesponsor';
	
						$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$pass");
						if(stripos($res,"Mail sent successfully"))
						{
							$result_mail = 'mail sent successfully';
						}
						else{
							$result_mail = 'mail not sent';
						}
						
					
						
						$posts = array($member_id,$result_mail);
						$postvalue['responseStatus']  = 200;
						$postvalue['responseMessage'] = "OK";
						$postvalue['posts']           = $posts;
						

    $success = $error = false;

					function messageUser($cc,$phone,$email,$password){
						/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						switch($cc){
							case 91:
								$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."."; 
								$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
								file_get_contents($url);
								break;
							case 1:
								$ApiVersion = "2010-04-01";
								// set our AccountSid and AuthToken
								$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
								$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
								// instantiate a new Twilio Rest Client
								$client = new TwilioRestClient($AccountSid, $AuthToken);
								$number="+1".$phone;
								$message="CONGRATULATIONS!,You are now a registered User of Smart Cookie.Your Username is ".$email." and Password is ".$password."."; 
								$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
								"POST", array(
								"To" => $number,
								"From" => "732-798-7878",
								"Body" => $message
								));
								break;
						}
					}
                 $cc='91';
				                                                                                                                                    
 }
 else
 {
	$member_id = "Image not uploded properly please try again";
    $posts = array($member_id);
	$postvalue['responseStatus']  = 400;
	$postvalue['responseMessage'] = "Image not uploded properly please try again INSERT INTO `tbl_sponsorer`(sp_name,sp_company,sp_email,CountryCode,v_status,v_category, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin,comment,calback_date_time,v_responce_status,sales_p_lat,sales_p_lon,platform_source,app_version,payment_method,calculated_lat,calculated_lon)VALUES('$sponsor_name','$company_name','$sp_email','$country_code','$sp_status','$sp_product_category', '$pass','$sp_address','$sp_phone','$sp_city','$sp_state','$sp_country','$sp_sales_person_id','$lat','$lon','$dates','$date1','$amount','$pin','$comment','$callback_date_time','$v_responce_status','$sales_p_lat','$sales_p_lon','$platform_source','$app_version','$source','$calculated_lat','$calculated_lon')";
	$postvalue['posts']           = $posts;
	
 }
   
				
				//messageUser($cc,$sp_phone,$sp_email,$pass);								
			
} else {
    $member_id = "Please send parameters";
    $posts = array($member_id);
	$postvalue['responseStatus']  = 204;
	$postvalue['responseMessage'] = "Please send parameters";
	$postvalue['posts']           = $posts;
  
}
header('Content-type: application/json');
echo json_encode($postvalue);
?>