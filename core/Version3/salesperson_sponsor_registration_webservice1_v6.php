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

	$sponsor_name=mysql_escape_string($obj->{'User_Name'});
    $company_name = mysql_escape_string($obj->{'Company_Name'});
    $lat = $obj->{'Lattitude'};
    $lon = $obj->{'Longitude'};
	$sales_p_lon = $obj->{'sales_p_lon'};
	$sales_p_lat = $obj->{'sales_p_lat'};

    $pin = $obj->{'pin'};
    $sp_email = mysql_escape_string($obj->{'User_email'});
    $sp_address = mysql_escape_string($obj->{'sp_address'});
    $sp_city = $obj->{'city'};
    $sp_state = $obj->{'state'};
    $pass = $obj->{'User_pass'};
    $amount = $obj->{'amount'};
    $sp_phone = $obj->{'sp_phone'};
    $sp_country = $obj->{'country'};
    $country_code = $obj->{'country_code'};
	$current_marketing = mysql_escape_string($obj->{'current_marketing'});
	$current_market_val = mysql_escape_string($obj->{'current_market_val'});
	$discount = $obj->{'discount'};
	$discount_val = $obj->{'discount_val'};
	$digital_marketing = mysql_escape_string($obj->{'digital_marketing'});
	$digital_market_val = mysql_escape_string($obj->{'digital_market_val'});

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
  // $calculated_json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$sp_address&sensor=false&region=$region");
//uses another api for calculation of lat lon by Nikita somawar

			$string = str_replace(' ', '', $sp_address);
			//$calculated_json = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$string");
			$curl = curl_init();

// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "http://maps.googleapis.com/maps/api/geocode/json?address=$string",
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// echo $resp;
// Close request to clear up some resources
//curl_close($curl);

$calculated_json = json_decode($resp);

		//	$calculated_json = json_decode($calculated_json);
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
    $member_id = "M" . str_pad($memberid, 11, "0", STR_PAD_LEFT);

	$query_error_1 = mysql_error($con);
	$query_error = str_replace("'","",$query_error_1);


	$sponsor_shop_imageDataEncoded = $obj->{'sponsor_shop_imagebase64'};
    $sponsor_shop_img = $obj->{'sponsor_shop_Image'};

    $sponsor_shop_ex_img = explode(".", $sponsor_shop_img);
    $sponsor_shop_img_name = $sponsor_shop_ex_img[0] . "_" . $memberid . "_" . date('mdY');
    $sponsor_shop_full_name_path = "image_sponsor/" . $sponsor_shop_img_name . "." . $sponsor_shop_ex_img[1];
    $sponsor_shop_imageName = "../".$sponsor_shop_full_name_path;
	$sponsor_shop_imageData = base64_decode($sponsor_shop_imageDataEncoded);
	$sponsor_shop_source = imagecreatefromstring($sponsor_shop_imageData);


	$sponsor_shop_imageSave = imagejpeg($sponsor_shop_source,$sponsor_shop_imageName,100);


    $imageDataEncoded = $obj->{'User_imagebase64'};
    $img = $obj->{'User_Image'};
    $ex_img = explode(".", $img);
    $img_name = $ex_img[0] . "_" . $memberid . "_" . date('mdY');
    $full_name_path = "image_sponsor/" . $img_name . "." . $ex_img[1];
    $imageName = "../".$full_name_path;
	$imageData = base64_decode($imageDataEncoded);
	$source = imagecreatefromstring($imageData);
	$imageSave = imagejpeg($source,$imageName,100);

	mysql_query("update tbl_sponsorer set sp_img_path='$full_name_path',sponaor_img_path='$sponsor_shop_full_name_path' where id='$memberid'");



	$site = $_SERVER['HTTP_HOST'];
	$msgid='welcomesponsor';
	
	                    $curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "http://$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$pass&platform_source=$platform_source",
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
							$server_name = $_SERVER['SERVER_NAME'];
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

							$ch = curl_init("http://$server_name/core/Version2/error_log_ws.php");


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
		$server_name = $_SERVER['SERVER_NAME'];
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
$ch = curl_init("http://$server_name/core/Version2/error_log_ws.php");


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
 elseif($imageSave & $sponsor_shop_imageSave & $test)
 {


						messageUser($country_code,$sp_phone,$sp_email,$pass,$platform_source);
						$posts = array($member_id,$result_mail);
						$postvalue['responseStatus']  = 200;
						$postvalue['responseMessage'] = "OK";
						$postvalue['posts']           = $posts;




 }
 elseif(($imageSave==false | $sponsor_shop_imageSave==false) & $test)
 {

	 $server_name = $_SERVER['SERVER_NAME'];
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
$ch = curl_init("http://$server_name/core/Version2/error_log_ws.php");


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
