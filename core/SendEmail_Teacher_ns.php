<?php
error_reporting(0);
include('conn.php');


$email=$_GET['email'];
$e_lenght=strlen(trim(($email)));

$School_id=$_GET['school_id'];
$Email_status=$_GET['status'];
if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{

		$query2="select t_password,email_status,t_current_school_name from `tbl_teacher` where t_email='$email' and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
		$row2=mysql_query($query2);
		$value2=mysql_fetch_array($row2);
		$password=$value2['t_password'];
		$status=$value2['email_status'];
		$school_name=$value2['t_current_school_name'];
		$s_name=explode(" ",$school_name);
		$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
		  if($status!='Send_Email')

		  {
													    $from="smartcookiesprogramme@gmail.com";
														$to=$email;
														$subject="Successful Registration";
														$message="
														<html>
														<head>
														
														</head>
														<body>
														<table width=400 border=1 cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
														  <tr>
															<td><table width=400 border=0 cellspacing=0 cellpadding=8>
															  <tr>
																<td colspan=2 bgcolor=#CDD9F5>".$school_name." <strong>is pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program</strong></td>
															  </tr>
															  <tr>
															   
																<td width=168 bgcolor=#FFFFEC><strong>Your Username is:</strong></td>
																<td width=168 bgcolor=#FFFFEC>".$email."</td>
															  </tr>
															  <tr>
																<td width=168 bgcolor=#FFFFDD><strong>& Password is:</strong></td>
																<td width=168 bgcolor=#FFFFDD> ".$password." </td>
															  </tr>
															    <tr>
																<td><img src='https://www.getsafedrive.com/wp-content/themes/safedrive/images/googleplay.svg' alt='Download Smart Teacher App by clicking below link' style='width:100px;height:50px;'></td>
															     </tr>
																  <tr>
																<td width=200 bgcolor=#FFFFEC>https://goo.gl/71F2hc</td>
															     </tr>
															  
																<p>Please visit www.smartcookie.in for more details.</p>
																<p>Regards,</p>
															     <p>Smart Cookie Admin</p>
															  
															</td>
														  </tr>
														</table>
														</body>
														</html>
														";
														
									   
														$headers = "MIME-Version: 1.0" . "\r\n";
														$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
														$headers .= "X-Mailer: PHP/".phpversion();
														// More headers
														$headers .= 'From: <smartcookiesprogramme@gmail.com>' . "\r\n";
														$headers .= 'Cc: ' . "\r\n";
														mail($to, $subject, $message,$headers);
echo "<script type=text/javascript>alert('Email has been sent Successfully on $email'); window.location='Send_Msg_Teacher.php'</script>";

   /*  $from="smartcookiesprogramme@gmail.com";
	$to=$email;
	$subject="Successful Registration";
	$message="".$sc_name." is pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program\r\n".
		   "your User ID is: "  .$email.  "\n\n".
		  "& your password is: ".$password."\n".
		  "School ID is:".$School_id."\n\n".
		  "Download Smart Teacher App by clicking below link"."\r\n".
		  "https://play.google.com/store/apps/details?id=com.blueplanet.smartcookieteacher&hl=en"."\r\n".
		  "Please visit www.smartcookie.in for more details"."\r\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message); */

                 function sendmail(){
					 								    $from="smartcookiesprogramme@gmail.com";
														$to=$email;
														$subject="Successful Registration";
														$message="
														<html>
														<head>
														
														</head>
														<body>
														<table width=400 border=1 cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
														  <tr>
															<td><table width=400 border=0 cellspacing=0 cellpadding=8>
															  <tr>
																<td colspan=2 bgcolor=#CDD9F5>".$school_name." <strong>is pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program</strong></td>
															  </tr>
															  <tr>
															   
																<td width=168 bgcolor=#FFFFEC><strong>Your Username is:</strong></td>
																<td width=168 bgcolor=#FFFFEC>".$email."</td>
															  </tr>
															  <tr>
																<td width=168 bgcolor=#FFFFDD><strong>& Password is:</strong></td>
																<td width=168 bgcolor=#FFFFDD> ".$password." </td>
															  </tr>
															    <tr>
																<td><img src='https://www.getsafedrive.com/wp-content/themes/safedrive/images/googleplay.svg' alt='Download Smart Teacher App by clicking below link' style='width:100px;height:50px;'></td>
															     </tr>
																  <tr>
																<td width=200 bgcolor=#FFFFEC>https://goo.gl/71F2hc</td>
															     </tr>
															  
																<p>Please visit www.smartcookie.in for more details.</p>
																<p>Regards,</p>
															     <p>Smart Cookie Admin</p>
															  
															</td>
														  </tr>
														</table>
														</body>
														</html>
														";
														
									   
														$headers = "MIME-Version: 1.0" . "\r\n";
														$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
														$headers .= "X-Mailer: PHP/".phpversion();
														// More headers
														$headers .= 'From: <smartcookiesprogramme@gmail.com>' . "\r\n";
														$headers .= 'Cc: ' . "\r\n";
														mail($to, $subject, $message,$headers);
					echo "<script type=text/javascript>alert('Email has been sent Successfully on $email'); window.location='Send_Msg_Teacher.php'</script>";
				 };                              
												   

		
		$sql_update="UPDATE `tbl_teacher` SET email_status='Send_Email' WHERE t_email='$email' AND school_id='$School_id'";
		$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error()); 

       }
		else
		{
		//echo "<script type=text/javascript>alert('You have already sent Email on $email. Thank You!! '); window.location='Send_Msg_Teacher.php'</script>";	
		echo "<script type=text/javascript>
		if (confirm('Are you sure you want to send again Email'))
			{
			
				 sendmail();
				
			}
			else
				{
					window.location='Send_Msg_Teacher.php'
				} 
				</script>";
			
		
		}
}
else
{
  
  echo "<script type=text/javascript>alert('Sorry,Invalid Email ID..'); window.location='Send_Msg_Teacher.php'</script>";	
}


?>


