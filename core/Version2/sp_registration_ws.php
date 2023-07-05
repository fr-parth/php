<?php
/* Array ( [0] => stdClass Object ( [id] => 349 [sp_name] => Sudhir Deshmukh [sp_address] => shivajinagar [sp_city] => Pune [sp_dob] => 10/01/1992 [sp_gender] => male [sp_country] => India [sp_state] => Maharashtra [sp_email] => sudhirp@roseland.com [sp_phone] => 9922449794 [sp_password] => 123 [sp_date] => 08/16/2015 [sp_occupation] => [sp_company] => Sudhirs Shop [sp_website] => www.sudhirdeshmukh.in [sp_img_path] => images/uploaded_logo/SC_51639952c2de0ed6eda1b739a88ae983.png [school_id] => [register_throught] => [lat] => 18.5308 [lon] => 73.8475 [pin] => 411038 [sales_person_id] => 0 [expiry_date] => [amount] => [v_status] => [v_likes] => [v_category] => Food [temp_phone] => [otp_phone] => 1 [temp_email] => [otp_email] => 1 ) )  */

$json = file_get_contents('php://input');
$obj = json_decode($json);
//$obj=JSON.parse($parse);
include 'conn.php';

$sp_email = xss_clean(mysql_real_escape_string($obj->{'sp_email'}));
$sp_password = xss_clean(mysql_real_escape_string($obj->{'sp_password'}));
$sp_phone = xss_clean(mysql_real_escape_string($obj->{'sp_phone'}));
$country_code = xss_clean(mysql_real_escape_string($obj->{'sp_countrycode'}));
$sp_name = xss_clean(mysql_real_escape_string($obj->{'sp_name'}));
$lat = xss_clean(mysql_real_escape_string($obj->{'sp_lat'}));
$long = xss_clean(mysql_real_escape_string($obj->{'sp_long'}));
$v_category = xss_clean(mysql_real_escape_string($obj->{'category'}));
$sp_address = xss_clean(mysql_real_escape_string($obj->{'address'}));
$sp_comment = xss_clean(mysql_real_escape_string($obj->{'comment'}));
$platform_source = xss_clean(mysql_real_escape_string($obj->{'platform_source'}));
$sp_payment_mode = xss_clean(mysql_real_escape_string($obj->{'payment_mode'}));
$sponsor_shop_imageDataEncoded = $obj->{'sponsor_shop_imagebase64'};
$sponsor_shop_img = $obj->{'sponsor_shop_Image'};
$imageDataEncoded = $obj->{'User_imagebase64'};
$img = $obj->{'User_Image'};

if($country_code==91)
	{
		// Start SMC-3452 Date Format Modified By Pranali 2018-09-19 03:48 PM
		//date_default_timezone_set("Asia/Calcutta");
		//$dates = date("Y-m-d h:i:s A");
		$dates = CURRENT_TIMESTAMP;
		$sp_country='India';
	}

	elseif($country_code==1)
	{
		date_default_timezone_set("America/Boa_Vista");
		$dates = date("Y-m-d H:i:s");
		$sp_country='USA';
	} 
	else{
		//date_default_timezone_set("Asia/Calcutta");
		//$dates = date("Y-m-d h:i:s A");
		$dates = CURRENT_TIMESTAMP;
		$sp_country='India';
	}
	
if($sp_email != "" and $sp_password !="" and $country_code!='' and $sp_phone!='' and $sp_address!='')
{
		
			 $string = str_replace(' ', '', $sp_address); 			  
			 $calculated_json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$string&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY ");
			 $calculated_json = json_decode($calculated_json);
			 $calculated_lat = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			 $calculated_lon = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
			/**
				below code is the getting City & State by using Latitude & Longitude 
				@ author: VaibhavG
			*/
			$cityState = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY");
			$data=json_decode($cityState,TRUE);
			$calculatedCity=$data['results'][0]['address_components'][2]['long_name'];
			$calculatedState=$data['results'][0]['address_components'][4]['long_name'];
		
		$q=mysql_query("insert into tbl_sponsorer(`sp_name`,`sp_address`,`sp_city`,`sp_state`,`sp_email`,`CountryCode`,`sp_phone`,`sp_password`,`sp_company`,`lat`,`lon`,`sp_date`,`sp_country`,`v_category`,`comment`,`payment_method`,`platform_source`,`calculated_lat`,`calculated_lon`) 
		values('$sp_name','$sp_address','$calculatedCity','$calculatedState','$sp_email','$country_code','$sp_phone','$sp_password','$sp_name','$lat','$long','$dates','$sp_country','$v_category','$sp_comment','$sp_payment_mode','$platform_source','$calculated_lat','$calculated_lon')")or die(mysql_error());
		
		$memberid=mysql_insert_id();
			
			

    $sponsor_shop_ex_img = explode(".", $sponsor_shop_img);
	//$sponsor_shop_img_name = $sponsor_shop_ex_img[0] . "_" . $memberid . "_" . date('mdY');
	
	//SponsorshopImage Name changed by Pravin 2017-08-04
    $sponsor_shop_img_name = "sponsorshop". "_" . $memberid . "_" . date('Ymd') ."_". $sponsor_shop_ex_img[0];	
    
    $sponsor_shop_full_name_path = "image_sponsor/" . $sponsor_shop_img_name . "." . $sponsor_shop_ex_img[1];
    $sponsor_shop_imageName = "../".$sponsor_shop_full_name_path;
	$sponsor_shop_imageData = base64_decode($sponsor_shop_imageDataEncoded);
	$sponsor_shop_source = imagecreatefromstring($sponsor_shop_imageData);


	$sponsor_shop_imageSave = imagejpeg($sponsor_shop_source,$sponsor_shop_imageName,100);

	
    
    $ex_img = explode(".", $img);
	//$img_name = $ex_img[0] . "_" . $memberid . "_" . date('mdY');
	
	//SponsorImage Name changed by Pravin 2017-08-04
	
    $img_name = "sponsor". "_" . $memberid . "_" . date('Ymd') ."_". $ex_img[0];
	//End SMC-3452
	
    $full_name_path = "image_sponsor/" . $img_name . "." . $ex_img[1];
    $imageName = "../".$full_name_path;
	$imageData = base64_decode($imageDataEncoded);
	$source = imagecreatefromstring($imageData);
	$imageSave = imagejpeg($source,$imageName,100);

	mysql_query("update tbl_sponsorer set sp_img_path='$full_name_path',sponaor_img_path='$sponsor_shop_full_name_path'  where id='$memberid'");
			
		function messageUser($cc,$phone,$email,$password,$platform_source){
						switch($cc){
							case 91:
								
								$Text="CONGRATULATIONS%21,+You+are+now+a+registered+Sponsor+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."+your+registration+is+successful+through+Sponsor+".$platform_source."+app";
								//$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."."; 
								/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
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
								$message="CONGRATULATIONS!,You are now a registered User of Smart Cookie.Your Username is ".$email." and Password is ".$password." your regitration is successful through Sponsor".$platform_source."app."; 
								$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
								"POST", array(
								"To" => $number,
								"From" => "732-798-7878",
								"Body" => $message
								));
								break;
						}
							
					}
$smswave_result = messageUser($country_code,$sp_phone,$sp_email,$sp_password,$platform_source);



					$site = $GLOBALS['URLNAME'];
					$msgid='sponsorapp';
						$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$sp_password&platform_source=$platform_source");
						if(stripos($res,"Mail sent successfully"))
						{
							$result_mail = 'mail sent successfully';
						}
						else{
							$result_mail = 'mail not sent';
						} 
						
					//old	
					/*$to=$sp_email;					
					$subject="Smartcookies Registration";
					$message="Dear Sponsor,\r\n\r\n".
						 "Thanks for your registration with Smart Cookie as sponsor\r\n".
						  "Your Username is: ".$sp_email."\n\n".
						  "Your Password is: ".$sp_password."\n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."www.smartcookie.in";
					$headers = 'From: smartcookiesprogramme@gmail.com' . "\r\n" .							
							'X-Mailer: PHP/' . phpversion();	  
					$m=mail($to, $subject, $message, $headers);*/
					
										
	$posts = array();
	if($memberid){
		//$posts['sponsor_id']=$i;
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="Ok";
		$postvalue['posts']="Sponsor registration has been done successfully. $result_mail";
	}else{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}
}else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}				  
header('Content-type: application/json');
echo  json_encode($postvalue); 

?>