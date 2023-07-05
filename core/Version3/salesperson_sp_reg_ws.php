<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save
if($obj->{'User_Name'} != ''&& $obj->{'User_email'} != ''&& $obj->{'User_pass'} != '' && $obj->{'User_imagebase64'}!=''&& $obj->{'User_Image'}!='' && $obj->{'sp_address'}!=''&& $obj->{'sp_phone'}!=''&& $obj->{'city'}!=''&& $obj->{'state'}!=''&& $obj->{'country'}!=''&& $obj->{'sales_person_id'}!='' &&$obj->{'Lattitude'} && $obj-> {'Longitude'}!=''&& $obj->{'amount'}!='' && $obj->{'country_code'}!='' && $obj->{'pin'}!='' )
{

include 'conn.php';
  
  
$arr = mysql_query("select id from tbl_sponsorer where sp_email = '".$obj->{'User_email'}."'")or die(mysql_error());
$count = mysql_num_rows($arr);
$sponsor_name = $obj->{'User_Name'};
$lat= $obj->{'Lattitude'};
$lon= $obj->{'Longitude'};
$dates = date('m/d/Y');
$pin=$obj->{'pin'};
$sp_email=$obj->{'User_email'};
$pass=$obj->{'User_pass'};
$amount=$obj->{'amount'};
$sp_phone=$obj->{'sp_phone'};

$country_code=$obj->{'country_code'};

$amount1=$amount/100;
   
   if($amount1!=0)
   {

	$add_days = 365*$amount1;
	$date=date('m/d/Y');
	$date1 = date('m/d/Y',strtotime($date) + (24*3600*$add_days));

   }
   
   if($amount1==0)
  {
  $add_days = 15;
		$date=date('m/d/Y');
	$date1 = date('m/d/Y',strtotime($date) + (24*3600*$add_days));
	$amount="Free Registration";
 
  }
   
$test = mysql_query("INSERT INTO `tbl_sponsorer` (sp_name,sp_email, sp_password,sp_address,sp_phone,sp_city,sp_state,sp_country,sales_person_id,lat,lon,sp_date,expiry_date,amount,pin) VALUES('$sponsor_name', '".$obj->{'User_email'}."','".$obj->{'User_pass'}."','".$obj->{'sp_address'}."','".$obj->{'sp_phone'}."','".$obj->{'city'}."','".$obj->{'state'}."','".$obj->{'country'}."','".$obj->{'sales_person_id'}."','$lat','$lon','$dates','$date1','$amount','$pin')")or die(mysql_error());


$memberid = mysql_insert_id();


$member_id= "M".str_pad($memberid,11,"0",STR_PAD_LEFT);
$id = $row1['id'];

 $imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'}; 
  
  	$ex_img = explode(".",@$img);
	$img_name = @$ex_img[0]."_".@$sp_id."_".date('mdY').".".@$ex_img[1];
	$full_name_path = "Assets/images/sp/profile/".$img_name;
	$imageName = "../../".$full_name_path;
	$imageData = base64_decode($imageDataEncoded); 
	$source = imagecreatefromstring($imageData);  
	$imageSave = imagejpeg($source,$imageName,100);		
  
  mysql_query("update `tbl_sponsorer` set sp_img_path = '$img_name' where id = $memberid");
  
  
  	if($country_code=='91'){
  		/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
							
$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$sp_email."+and+Password+is+".$pass."."; 
//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166
$url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$sp_phone&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";


					file_get_contents($url);
					
					
			}
			elseif($country_code=='1')		
			{
				include_once 'twilio.php';
				$ApiVersion = "2010-04-01";
				
				

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$sp_phone;
	$message="CONGRATULATIONS!,Your are now registered user of Smartcookie 
	Your Username is ".$sp_email." and Password is ".$pass."."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $message
		));

			} 
  
  
  
  
  
mysql_close($con);

//
  
    $posts = array($member_id);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts)); 
	
	


$success = $error = false;

	// Object syntax looks better and is easier to use than arrays to me
	$post = new stdClass;
	
	// Usually there would be much more validation and filtering, but this
	// will work for now.
	
		
	// Check for blank fields
	
		
	
		// Get this directory, to include other files from
		$dir = dirname(__FILE__);
		
		// Get the contents of the pdf into a variable for later
		ob_start();
		require_once($dir.'/pdf.php');
		$pdf_html = ob_get_contents();
		ob_end_clean();
		
		// Load the dompdf files
		require_once($dir.'/dompdf/dompdf_config.inc.php');
		
		$dompdf = new DOMPDF(); // Create new instance of dompdf
		$dompdf->load_html($pdf_html); // Load the html
		$dompdf->render(); // Parse the html, convert to PDF
		$pdf_content = $dompdf->output(); // Put contents of pdf into variable for later
		
		// Get the contents of the HTML email into a variable for later
		ob_start();
	
		
		
		$html_message="CONGRATULATIONS!,You are now a registered User of Smart Cookie,\r\n\r\n".
						    "A Student/Teacher Rewards Program\r\n".
						  "Your Username is: ".$sp_email."\n\n".
						  "Your Password is: ".$pass."\n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."www.smartcookie.in\r\n";
	
		// Load the SwiftMailer files
		require_once($dir.'/swift/swift_required.php');

		$mailer = new Swift_Mailer(new Swift_MailTransport()); // Create new instance of SwiftMailer

		$message1 = Swift_Message::newInstance()
				       ->setSubject('Smartcookie Registraion') // Message subject
					   ->setTo(array($sp_email => $sponsor_name )) // Array of people to send to
					   ->setFrom(array('smartcookiesprogramme@gmail.com' => 'Smartcookie Registration')) // From:
					   ->setBody($html_message, 'text/html') // Attach that HTML message from earlier
					   ->attach(Swift_Attachment::newInstance($pdf_content, 'receipt.pdf', 'application/pdf')); // Attach the generated PDF from earlier
					   
					   
					   
					   	$html_message1="Hi, Please find attachment of Confirmation receipt of the sponsor";  
					   	$message = Swift_Message::newInstance()
				       ->setSubject('Smartcookie Registraion') // Message subject
					   ->setTo(array("reshmak@roseland.com" => "Reshma","swapnilr@roseland.com"=>"Swapnil" )) // Array of people to send to
					   ->setFrom(array('smartcookiesprogramme@gmail.com' => 'Sponsor Registration')) // From:
					   ->setBody($html_message1, 'text/html') // Attach that HTML message from earlier
					   ->attach(Swift_Attachment::newInstance($pdf_content, 'receipt.pdf', 'application/pdf')); // Attach the generated PDF from earlier
		
				// Send the email, and show user message
		if ($mailer->send($message))
			$success = true;
		else
			$error = true;
		
		
			if ($mailer->send($message1))
			$success = true;
		else
			$error = true;


		// Send the email, and show user message
		





	
}
else
{
$postvalue['responseStatus']=1000;
$postvalue['responseMessage']="Invalid Input";
$postvalue['posts']=null;

}
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 	
		
  ?>