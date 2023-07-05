<?php
error_reporting(0);
include('conn.php');


$email=$_GET['email'];
/*$e_lenght=strlen(trim(($email)));
$School_id=$_GET['school_id'];
$Email_status=$_GET['status'];
if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$query2="select std_password,std_school_name,email_status from `tbl_student` where std_email='$email' and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
	$row2=mysql_query($query2);
	$value2=mysql_fetch_array($row2);
	$password=$value2['std_password'];
	$status=$value2['send_unsend_status'];
	$school_name=$value2['email_status'];
	$s_name=explode(" ",$school_name);
    $sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
	if($Email_status!='Send_Email')

	{*/
                $from="smartcookiesprogramme@gmail.com";
				$to=$email;
				$school_name="";
				$password="123";
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
																<td><img src='https://www.getsafedrive.com/wp-content/themes/safedrive/images/googleplay.svg' alt='Download Smart Student App by clicking below link' style='width:90px;height:40px;'></td>
															     </tr>
																  <tr>
																<td width=200 bgcolor=#FFFFEC><strong>https://goo.gl/JfmxFP</strong></td>
															     </tr>
															  
																<p>Please visit www.smartcookie.in for more details.</p>
																<p>
																Getting a taste Smart Cookies: Instructions For Students
																<table width=600 border=0 cellspacing=0 cellpadding=8>
															  <tr>
															  <td>
															  <b>
1.       Student</b>
<br>
</td></tr>
<tr>
															  <td>
&nbsp;&nbsp;&nbsp;a.       Credentials
</td>
</tr>										  
															  
															  
<ul style='list-style-type: none;'>
									<li>
                                                               i.      Username
															   </li>
															   <li>

                                                             ii.      Password
															 </li>
															 </ul>
															 
		
															 
<tr>
			<td>
			<br>
			<b>
2.       Web</b>
<br>
<ul style='list-style-type: none;'>
									<li>
a.       Login
</li>
<li>
			
b.      Change Password
</li>
<li>
c.      Features to be tried                       

															<ul style='list-style-type: none;'>
																<li>
                                                               i.      See and Edit Student info
															   </li>
															   </ul>
															   </li>
															   </ul>
															   
															   
<table>
<tr>

1.       Profile
</tr>
<tr>
			<td>
2.       Smart Cookie ID card
</td>
</tr>
			<td>
			<tr>
3.       Dashboard
							<ul style='list-style-type: none;'>
																<li>
                                                             ii.      Give Thanq points to teachers
																</li>
																<li>
                                                            iii.      Self motivate by earning reward points with Social Foot Print
</li>
																<li>
                                                           iv.      Use reward points to buy soft rewards.
																	</li>
																<li>
                                                             v.      Use reward points to create “Smart Cookie Coupons”
</li>
																<li>
                                                         vi.      Sponsors
														 </li>
																</ul>
																</tr>
																<tr>

1.       See Sponsor map
</tr>
<ul style='list-style-type: none;'>
																<li>
a.       Based on School Location
</li>
<li>
b.      Based on Current Location
</li>
<li>
c.       Based on Custom Location
</li>
</ul>
<tr>
2.       Suggest a sponsor
</tr>
<tr>
			<td>
3.       Buy Sponsor coupons using points
</td>
</tr>
			<tr>
			<td>
4.       Use a coupon at sponsor location
<ul style='list-style-type: none;'>
																<li>
a.       Smart Cookie Coupons
</li>
<li>
b.      Sponsor Coupons

                                                          vii.      Let your social network know
														  </li>
</ul>

			</td>
</tr>
<tr>
<td>
1.       When you get points
</tr>
			
			
<tr>
<td>
2.       When you buy coupons
</td>
</tr>
<tr>
			<td>
3.       When you use coupons
</td>
</tr>
<tr>
			<td>
4.       When you buy Soft rewards

			</td>
			</tr>












</li></ul>




			<br>
<b>4.       iOS</b>
<br>
<tr>
			<td>
a.       Use Download link to get iOS app
<tr>
			<td>
b.      Login
<tr>
			<td>
c.       Change Password
<tr>
			<td>
			<br>
<b>5.       Features to be tried </b>         
        
<ul style='list-style-type: none;'>
<li>
a.       See and Edit Student info
<ul style='list-style-type: none;'>
<li>
                                                               i.      Profile
															   </li>
															   <li>
                                                             ii.      Smart Cookie ID card
															</li>
															   <li>

                                                            iii.      Dashboard
															</li>
															   </ul>
															   </li>
<li>
b.      Give Thanq points to teachers
</li>
<li>
c.       Self motivate by earning reward points with Social Foot Print
</li>
<li>
d.      Use reward points to buy soft rewards.
</li>
<li>
e.      Use reward points to create “Smart Cookie Coupons”
</li>
<li>
f.        Sponsors
<ul style='list-style-type: none;'>
<li> i.      See Sponsor map
		<ul style='list-style-type: none;'>
		<li>
		1.       Based on School Location
		</li>
		<li>
		
		2.       Based on Current Location
		</li>
		<li>
		3.       Based on Custom Location
		</li>
		</ul>
</li>
<li> ii.      Suggest a sponsor</li>
<li> iii.      Buy Sponsor coupons using points</li>
<li> iv.      Use a coupon at sponsor location</li>
                                                              
															   



                                                            

                                                           

                                                          

1.       Smart Cookie Coupons

2.       Sponsor Coupons
</ul>
</li>
<li>

g.       Let your social network know
								<ul style='list-style-type: none;'>
									<li>
                                                               i.      When you get points
															   </li>
															   <li>

                                                             ii.      When you buy coupons
															  </li>
															   <li>

                                                            iii.      When you use coupons
															 </li>
															   <li>

                                                           iv.      When you buy Soft rewards
														    </li>
															  </ul>
															  </li>
															  </ul>
															  <br>

<b>6.       Send feedback to</b>
</br>
<ul style='list-style-type: none;'>
									<li>
a.       feedback@smartcokkie.in
 </li>
															   <li>
b.      Or click the Feedback link on Web or App.
</li>
</ul>
</li>
</ul>
																</p>
															   
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

														// More headers
														$headers .= 'From: <smartcookiesprogramme@gmail.com>' . "\r\n";
														$headers .= 'Cc: ' . "\r\n";
													echo	mail($to, $subject, $message,$headers);

														
														
														
			    /* $from="smartcookiesprogramme@gmail.com";
				$to=$email;
				$subject="Successful Registration";
				$message="".$sc_name." is pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program\r\n".
					   "your User ID is: "  .$email.  "\n\n".
					  "& your password is: ".$password."\n".
					  "School ID is:".$School_id."\n\n".
					  "Please visit www.smartcookie.in for more details"."\r\n".
					  "Download Smart Student App by clicking below link"."\r\n".
					  "https://play.google.com/store/apps/details?id=com.bpsi.smartstudent&hl=en"."\r\n".
					  "Regards,\r\n".
					  "Smart Cookie Admin";
					  
				   mail($to, $subject, $message); */

                                               
												   

		/*echo "<script type=text/javascript>alert('Email has been sent Successfully on $email'); window.location='Send_Msg_Student.php'</script>";

		$sql_update="UPDATE `tbl_student` SET email_status='Send_Email' WHERE std_email='$email' AND school_id='$School_id'";
		$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error()); */
/*
		}
		else
		{
		echo "<script type=text/javascript>alert('You have already sent Email on $email. Thank You!! '); window.location='Send_Msg_Student.php'</script>";	
		}
}
else
{
	echo "<script type=text/javascript>alert('Sorry, Invalid Email ID'); window.location='Send_Msg_Student.php'</script>";
}*/


               //$response='OK : 4635242';
 
           /*  // $url1="Please+visit+www.smartcookie.in";
			 //$Text="COEP+is+pleased+to+inform+that+you+are+part+of+smartcookie+program.+UserID+is+pratu9579+&+Pswd+is+pratu123+".$url1."+for+more+details.+"; 
			echo $url="http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=ashishd&passwd=Passion@2015&mobilenumber=919579337525&message=hiiiiiii&sid=SMCOOKIE&mtype=N&DR=Y";
			 $response=file_get_contents($url);
			  */
?>


