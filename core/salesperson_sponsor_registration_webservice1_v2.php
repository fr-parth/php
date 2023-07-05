<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save
if ($obj->{'User_Name'} != '' && $obj->{'User_email'} != '' && $obj->{'User_pass'} != '' && $obj->{'sp_phone'} != '' && $obj->{'Lattitude'} && $obj->{'Longitude'} != '' && $obj->{'country_code'} != '')
	{

    //include 'conn.php';
	require 'conn.php';
	require "twilio.php";
	
	$sponsor_name=mysql_escape_string($obj->{'User_Name'});
    $company_name = mysql_escape_string($obj->{'Company_Name'});
    $lat = $obj->{'Lattitude'};
    $lon = $obj->{'Longitude'};
    $dates = date('m/d/Y');
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
    $sp_sales_person_id = $obj->{'sales_person_id'};	
    $sp_status = $obj->{'sp_status'};	                 //Sponsor status
    $sp_product_category = $obj->{'sp_product_category'};	 //Sponsor category
	$callback_date_time = $obj->{'callback_date_time'};
	$v_responce_status = $obj->{'v_responce_status'};
	$comment = $obj->{'comment'};
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
	
    $test = mysql_query("INSERT INTO `tbl_sponsorer` (sp_name,sp_company,sp_email,CountryCode,v_status,v_category, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin,comment,calback_date_time,v_responce_status)VALUES('$sponsor_name','$company_name','$sp_email','$country_code','$sp_status','$sp_product_category', '$pass','$sp_address','$sp_phone','$sp_city','$sp_state','$sp_country','$sp_sales_person_id','$lat','$lon','$dates','$date1','$amount','$pin','$comment','$callback_date_time','$v_responce_status')");

	
    $arr1 = mysql_query("select id from `tbl_sponsorer`  where sp_email = '" . $obj->{'User_email'} . "' order by id desc ");
    $row1 = mysql_fetch_array($arr1);
    $memberid = $row1['id'];
    $member_id = "M" . str_pad($memberid, 11, "0", STR_PAD_LEFT);
    $id = $row1['id'];
    $imageDataEncoded = $obj->{'User_imagebase64'};
    $img = $obj->{'User_Image'};
    $ex_img = explode(".", $img);
    $img_name = $ex_img[0] . "_" . $id . "_" . date('mdY');
    $full_name_path = "image_sponsor/" . $img_name . "." . $ex_img[1];
    $imageName = "../" . $full_name_path;
	/*if($obj->{'sp_phone'} != '')
    $imageData = base64_decode($imageDataEncoded);
    $source = imagecreatefromstring($imageData);
    //$imageName = "image/".$obj->{'User_Image'};
    $imageSave = imagejpeg($source, $imageName, 100);
	}*/

    mysql_query("update `tbl_sponsorer` set sp_img_path = '$full_name_path' where id = $memberid");
	
 if($obj->{'User_Image'}!='')
 {
 $imageData = base64_decode($imageDataEncoded);
 $source = imagecreatefromstring($imageData);
//$imageName = "image/".$obj->{'User_Image'};
 $imageSave = imagejpeg($source,$imageName,100);
 }


    mysql_close($con);
//
    
						 /*  $to='nikitas@roseland.com'; 
						   $subject=" test mail ";
						   $body="Rohit is testing ";
						   $header='form : smartcookiesprogramme@gmail.com';
						   
						   if(mail($to,$subject,$body,$header))
						   {
							   echo 'Email has been sent '.$to;
						   }
						   else
						   {
							   echo 'there was error to sending mail';
						   }*/

	
	/*function emailUser($sp_email,$pass){
							$to=$sp_email;
							$from="smartcookiesprogramme@gmail.com";
							$subject="SmartCookie Registration";
							$html_message = "CONGRATULATIONS!,You are now a registered Sponsors of Smart Cookie,\r\n\r\n" .
								"A Student/Teacher Rewards Program\r\n" .
								"Your Username is: " . $sp_email . "\n\n" .
								"Your Password is: " . $pass . "\n\n" .
								"Regards,\r\n" .
								"Smart Cookie Admin \n" . "http://tsmartcookies.bpsi.us\r\n";  
								$mail =mail($to, $subject, $html_message);
							
							//$mail =mail($to, $subject, $html_message);
							
							
						}*/
	$site = $_SERVER['HTTP_HOST'];
	$msgid='welcomesponsor';
	//$a = "http://$site/core/clickmail/sendmail.php?email=$sp_email&name=$sponsor_name&msgid=$msgid&site=$site&pass=$pass";
	
						$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$sp_email&msgid=$msgid&site=$site&pass=$pass");
						if(stripos($res,"Mail sent successfully"))
						{
							$result_mail = 'mail sent successfully';
						}
						else{
							$result_mail = 'mail not sent';
						}
						$posts = array($member_id,$result_mail);
						//$posts[] = "INSERT INTO `tbl_sponsorer` (sp_name,sp_company,sp_email,CountryCode,v_status,v_category, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin)
										     //VALUES('$sponsor_name','$company_name','$sp_email','$country_code','$sp_status','$sp_product_category', '$pass','$sp_address','$sp_phone','$sp_city','$sp_state','$sp_country','$sp_sales_person_id','$lat','$lon','$dates','$date1','$amount','$pin')";
    header('Content-type: application/json');
    echo json_encode(array('posts' => $posts));
    $success = $error = false;

    // Object syntax looks better and is easier to use than arrays to me
   // $post = new stdClass;
    // Usually there would be much more validation and filtering, but this
    // will work for now.
    // Check for blank fields
    // Get this directory, to include other files from
 //   $dir = dirname(__FILE__);
    // Get the contents of the pdf into a variable for later
  //  ob_start();
   // require_once($dir . '/pdf.php');
 //   $pdf_html = ob_get_contents();
//    ob_end_clean();
    // Load the dompdf files
   // require_once($dir . '/dompdf/dompdf_config.inc.php');
 //   $dompdf = new DOMPDF(); // Create new instance of dompdf
//    $dompdf->load_html($pdf_html); // Load the html
 //   $dompdf->render(); // Parse the html, convert to PDF
 //   $pdf_content = $dompdf->output(); // Put contents of pdf into variable for later
    // Get the contents of the HTML email into a variable for later
 //   ob_start();
    	
							

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
				 
				
				//messageUser($cc,$sp_phone,$sp_email,$pass);								
			
} else {
    $member_id = "Please send parameters";
    $posts = array($member_id);
    header('Content-type: application/json');
    echo json_encode(array('posts' => $posts));
}

?>