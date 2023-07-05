<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save

if ($obj->{'User_Name'} != '' && ($obj->{'User_email'} != '' || $obj->{'sp_phone'} != '') && $obj->{'User_pass'} != ''  && $obj->{'Lattitude'} && $obj->{'Longitude'} != '' && $obj->{'country_code'} != '' && $obj->{'sales_p_lon'} != ''  && $obj->{'sales_p_lat'} != '' && $obj->{'User_Image'}!='' && $obj->{'User_imagebase64'} && $obj->{'sponsor_shop_Image'}!='' && $obj->{'sponsor_shop_imagebase64'})

	{

    //include 'conn.php';
	require 'conn.php';
	require "twilio.php";

	$site = $GLOBALS['URLNAME'];
	// START SMC-3487 Pravin 2018-09-27 2:17 PM
	$sponsor_name=xss_clean(mysql_escape_string($obj->{'User_Name'}));
    $company_name = xss_clean(mysql_escape_string($obj->{'Company_Name'}));
    $lat = xss_clean(mysql_escape_string($obj->{'Lattitude'}));
    $lon = xss_clean(mysql_escape_string($obj->{'Longitude'}));
	$sales_p_lon = xss_clean(mysql_escape_string($obj->{'sales_p_lon'}));
	$sales_p_lat = xss_clean(mysql_escape_string($obj->{'sales_p_lat'}));

    $pin = xss_clean(mysql_escape_string($obj->{'pin'}));
    $sp_email = xss_clean(mysql_escape_string($obj->{'User_email'}));
    $sp_address = xss_clean(mysql_escape_string($obj->{'sp_address'}));
    $sp_city = xss_clean(mysql_escape_string($obj->{'city'}));
    $sp_state = xss_clean(mysql_escape_string($obj->{'state'}));
    $pass = xss_clean(mysql_escape_string($obj->{'User_pass'}));
    $amount = xss_clean(mysql_escape_string($obj->{'amount'}));
    $sp_phone = xss_clean(mysql_escape_string($obj->{'sp_phone'}));
    $sp_country = xss_clean(mysql_escape_string($obj->{'country'}));
    $country_code = xss_clean(mysql_escape_string($obj->{'country_code'}));
	$discount = xss_clean(mysql_escape_string($obj->{'discount'}));
	$current_marketing = xss_clean(mysql_escape_string($obj->{'current_marketing'}));
	$current_market_val = xss_clean(mysql_escape_string($obj->{'current_market_val'}));
	$discount_setup = xss_clean(mysql_escape_string($obj->{'discount_setup'}));
	$discount_val = xss_clean(mysql_escape_string($obj->{'discount_val'}));
	$points = xss_clean(mysql_escape_string($obj->{'points'}));
	$digital_marketing = xss_clean(mysql_escape_string($obj->{'digital_marketing'}));
	$digital_market_val = xss_clean(mysql_escape_string($obj->{'digital_market_val'}));


	if($country_code==91)
	{
		//date_default_timezone_set("Asia/Calcutta");
		//$dates = date("Y-m-d h:i:s A");
		$dates = CURRENT_TIMESTAMP;
	}
	elseif($country_code==1)
	{
		date_default_timezone_set("America/Boa_Vista");
		$dates = date("Y-m-d h:i:s");
	}

    $sp_sales_person_id = xss_clean(mysql_escape_string($obj->{'sales_person_id'}));
    $sp_status = xss_clean(mysql_escape_string($obj->{'sp_status'}));	                 //Sponsor status
    $sp_product_category = xss_clean(mysql_escape_string($obj->{'sp_product_category'}));	 //Sponsor category
	$callback_date_time = xss_clean(mysql_escape_string($obj->{'callback_date_time'}));
	$v_responce_status = xss_clean(mysql_escape_string($obj->{'v_responce_status'}));
	$comment = xss_clean(mysql_escape_string($obj->{'comment'}));
	$platform_source = xss_clean(mysql_escape_string($obj->{'platform_source'}));
	$app_version = xss_clean(mysql_escape_string($obj->{'app_version'}));
	$payment_method = xss_clean(mysql_escape_string($obj->{'source'}));
    $amount1 = $amount / 100;

    if ($amount1 != 0) {

        $add_days = 365 * $amount1;
        //$date = date('m/d/Y');
        //$date1 = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));
		$date = CURRENT_TIMESTAMP;
        $date1 = date('Y-m-d H:i:s', strtotime($date) + (24 * 3600 * $add_days));

    }

    if ($amount1 == 0) {
        $add_days = 15;
        //$date = date('m/d/Y');
        //$date1 = date('m/d/Y', strtotime($date) + (24 * 3600 * $add_days));
		 $date = CURRENT_TIMESTAMP;
        $date1 = date('Y-m-d h:i:s', strtotime($date) + (24 * 3600 * $add_days));
		
        $amount = "Free Registration";

    }


			$string = str_replace(' ', '', $sp_address);
			$curl = curl_init();
			
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?address=$string&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY",
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);

// Close request to clear up some resources
//curl_close($curl);

$calculated_json = json_decode($resp);

			$calculated_lat = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
			$calculated_lon = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

					function messageUser($cc,$phone,$email,$password,$platform_source){
						/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						switch($cc){
							case 91:
								$Text="CONGRATULATIONS%21,+You+are+now+a+registered+Sponsor+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."+your+regitration+is+successful+through+Salesperson+".$platform_source."+app";
								//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166 
								$url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
									                    $curl = curl_init();
								// Set some options - we are passing in a useragent too here
								curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => "$url",
								CURLOPT_USERAGENT => 'Codular Sample cURL Request'
								));
								// Send the request & save response to $resp
								$res = curl_exec($curl);
 
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



$test1 = "INSERT INTO `tbl_sponsorer`(sp_name,sp_company,sp_email,CountryCode,v_status,v_category, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin,comment,calback_date_time,v_responce_status,sales_p_lat,sales_p_lon,platform_source,app_version,payment_method,calculated_lat,calculated_lon,current_marketing,current_market_val,discount,discount_val,digital_marketing,digital_market_val)VALUES('$sponsor_name','$company_name','$sp_email','$country_code','$sp_status','$sp_product_category', '$pass','$sp_address','$sp_phone','$sp_city','$sp_state','$sp_country','$sp_sales_person_id','$lat','$lon','$dates','$date1','$amount','$pin','$comment','$callback_date_time','$v_responce_status','$sales_p_lat','$sales_p_lon','$platform_source','$app_version','$payment_method','$calculated_lat','$calculated_lon','$current_marketing','$current_market_val','$discount','$discount_val','$digital_marketing','$digital_market_val')";


 $test=mysql_query($test1);
  $memberid =  mysql_insert_id();

	if($test)
		{
			if($discount_setup!='' && $points!=''){
		   //$date = date('mdY');
		   $date = CURRENT_TIMESTAMP;
           $test2="INSERT INTO `tbl_sponsored`(Sponser_type, Sponser_product, points_per_product, sponsered_date, validity, sponsor_id, valid_until, category,discount, daily_limit,daily_counter, reset_date)
		   VALUES('discount', '$discount_setup', '$points', '$date', 'valid', '$memberid','$date1', '$sp_product_category','$discount_setup', 'unlimited', 'unlimited', '$date1')";
		   
		    $res=mysql_query($test2);
			
		}
			
			
			 $ReceiptNo="SPR".$memberid.$date;
			
			$test3="INSERT INTO tbl_insert_receipt (sp_id, ReceiptNo, Name, Email, sp_phone, Amount, Validity) VALUES ('$memberid','$ReceiptNo','$company_name','$sp_email', '$sp_phone','$amount','$date1')";
			 $resultreceipt=mysql_query($test3);
			
			if($resultreceipt){
				
			$msgid='receiptsponsor';
			$ccmail='accounts@blueplanetsolutions.com';
			
			
				 $curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => "$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&ReceiptNo=$ReceiptNo&Name=$company_name&Amount=$amount&Validity=$date1&paymentmethod=$payment_method&ccmail=$ccmail",
				CURLOPT_USERAGENT => 'Codular Sample cURL Request'
				));
				// Send the request & save response to $resp
				 $res = curl_exec($curl);
				
			}
			
		}
		
		
    $member_id = "M" . str_pad($memberid, 11, "0", STR_PAD_LEFT);

	$query_error_1 = mysql_error($con);
	$query_error = str_replace("'","",$query_error_1);


	$sponsor_shop_imageDataEncoded = $obj->{'sponsor_shop_imagebase64'};
    $sponsor_shop_img = $obj->{'sponsor_shop_Image'};

    $sponsor_shop_ex_img = explode(".", $sponsor_shop_img);
    $sponsor_shop_img_name = $sponsor_shop_ex_img[0] . "_" . $memberid . "_" . date('Ymd');//SMC-3487
    $sponsor_shop_full_name_path = "image_sponsor/" . $sponsor_shop_img_name . "." . $sponsor_shop_ex_img[1];
    $sponsor_shop_imageName = "../".$sponsor_shop_full_name_path;
	$sponsor_shop_imageData = base64_decode($sponsor_shop_imageDataEncoded);
	$sponsor_shop_source = imagecreatefromstring($sponsor_shop_imageData);


	$sponsor_shop_imageSave = imagejpeg($sponsor_shop_source,$sponsor_shop_imageName,100);


    $imageDataEncoded = $obj->{'User_imagebase64'};
    $img = $obj->{'User_Image'};
    $ex_img = explode(".", $img);
    $img_name = $ex_img[0] . "_" . $memberid . "_" . date('Ymd');//SMC-3487
	//END SMC-3487
    $full_name_path = "image_sponsor/" . $img_name . "." . $ex_img[1];
    $imageName = "../".$full_name_path;
	$imageData = base64_decode($imageDataEncoded);
	$source = imagecreatefromstring($imageData);
	$imageSave = imagejpeg($source,$imageName,100);

	mysql_query("update tbl_sponsorer set sp_img_path='$full_name_path',sponaor_img_path='$sponsor_shop_full_name_path' where id='$memberid'");



	
	$msgid='welcomesponsor';
	
	                    $curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$pass&platform_source=$platform_source",
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$res = curl_exec($curl);
 
 
 
					//	$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$pass&platform_source=$platform_source");
						if(stripos($res,"Mail sent successfully"))
						{
							$result_mail = 'mail sent successfully';
						}
						else{
							
							$salesperson_info1 = "select p_name,p_email,p_phone from tbl_salesperson where person_id = '$sp_sales_person_id'";
							$salesperson_info = mysql_query($salesperson_info1);
							$nik = mysql_error($con);
							$p = mysql_num_rows($salesperson_info);
							while($salesperson_data_result = mysql_fetch_assoc($salesperson_info))
							{
							 $sales_p_name = $salesperson_data_result['p_name'];
							 $sales_p_phone = $salesperson_data_result['p_phone'];
							 $sales_p_email = $salesperson_data_result['p_email'];
							}

									$data = array('error_type'=>'',
									'error_description'=>$res,
									'data'=>'',
									'datetime'=>$date,
									'user_type'=>'salesperson',
									'member_id'=>$sp_sales_person_id,
									'name'=>$sales_p_name,
									'phone'=>$sales_p_phone,
									'email'=>$sales_p_email,
									'app_name'=>'salesperson app',
									'subroutine_name'=>'',
									'line'=>'83',
									'status'=>''
							);

							$ch = curl_init("$site/core/Version2/error_log_ws.php");


							$data_string = json_encode($data);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);

							$result_mail = 'mail not sent';
						}


	if($test==false)
	{
		
		$salesperson_info1 = "select p_name,p_email,p_phone from tbl_salesperson where person_id = '$sp_sales_person_id'";
		$salesperson_info = mysql_query($salesperson_info1);
		$nik = mysql_error($con);
		$p = mysql_num_rows($salesperson_info);
		while($salesperson_data_result = mysql_fetch_assoc($salesperson_info))
		{
		 $sales_p_name = $salesperson_data_result['p_name'];
		 $sales_p_phone = $salesperson_data_result['p_phone'];
		 $sales_p_email = $salesperson_data_result['p_email'];
		}


				$data = array('error_type'=>'',
				'error_description'=>$query_error,
				'data'=>'',
				'datetime'=>$date,
				'user_type'=>'salesperson',
				'member_id'=>$sp_sales_person_id,
				'name'=>$sales_p_name,
				'phone'=>$sales_p_phone,
				'email'=>$sales_p_email,
				'app_name'=>'salesperson app',
				'subroutine_name'=>'',
				'line'=>'83',
				'status'=>''
);
$ch = curl_init("$site/core/Version2/error_log_ws.php");


					$data_string = json_encode($data);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
					$result = json_decode(curl_exec($ch),true);
					$responce = $result["responseStatus"];

		$postvalue['responseStatus']  = 204;
		$postvalue['responseMessage'] = "Data not inserted,Please try again";
		$postvalue['posts'] = null;


	}
 elseif($sponsor_shop_imageSave & $test)
 {
		if($imageSave==true){
			
			$img="Image upload sucessfully";
			$responseStatus="200";
			$responseMessage="OK";
		}
		elseif($imageSave==false)
		{
			$img='Image not uploded properly please try again';
			$responseStatus="400";
			$responseMessage="Image Upload Problem";
		}
		else{
			$img='something is error';
		}

						messageUser($country_code,$sp_phone,$sp_email,$pass,$platform_source);
						$posts[] = array(
						'member_id'=>$member_id,
						'result_mail'=>$result_mail,
						'receiptno'=>$ReceiptNo,
						'imageresult'=>$img
						);
						
						$postvalue['responseStatus']  = $responseStatus;
						$postvalue['responseMessage'] = $responseMessage;
						$postvalue['posts']           = $posts;




 }
 elseif(($imageSave==false | $sponsor_shop_imageSave==false) & $test)
 {

	 
		$salesperson_info1 = "select p_name,p_email,p_phone from tbl_salesperson where person_id = '$sp_sales_person_id'";
		$salesperson_info = mysql_query($salesperson_info1);
		$nik = mysql_error($con);
		$p = mysql_num_rows($salesperson_info);
		while($salesperson_data_result = mysql_fetch_assoc($salesperson_info))
		{
		 $sales_p_name = $salesperson_data_result['p_name'];
		 $sales_p_phone = $salesperson_data_result['p_phone'];
		 $sales_p_email = $salesperson_data_result['p_email'];
		}

				$data = array('error_type'=>'',
				'error_description'=>'image not saved',
				'data'=>'',
				'datetime'=>$date,
				'user_type'=>'salesperson',
				'member_id'=>$sp_sales_person_id,
				'name'=>$sales_p_name,
				'phone'=>$sales_p_phone,
				'email'=>$sales_p_email,
				'app_name'=>'salesperson app',
				'subroutine_name'=>'',
				'line'=>'83',
				'status'=>''
);
$ch = curl_init("$site/core/Version2/error_log_ws.php");


					$data_string = json_encode($data);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
					$result = json_decode(curl_exec($ch),true);
					$responce = $result["responseStatus"];

	$member_id = "Image not uploded properly please try again";
    $posts = array($member_id);

	messageUser($country_code,$sp_phone,$sp_email,$pass,$platform_source);
	$postvalue['responseStatus']  = 400;
	$postvalue['responseMessage'] = "Image not uploded properly please try again";

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
//mysql_close($con);
header('Content-type: application/json');
echo json_encode($postvalue);
?>
