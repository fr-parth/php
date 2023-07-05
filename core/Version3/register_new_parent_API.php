<?php
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $parent_name = $obj->{'user_name'};
  $parent_email = $obj->{'email'};
   $parent_phone = $obj->{'phone'};
   $parent_pswd = $obj->{'pass'};
   $parent_cnf_paswd = $obj->{'cnf_pswd'};
    $country_code = $obj->{'country_code'};
   //$date = date('d/m/Y');
   // Start SMC-3453 Modify By Yogesh 2018-09-19 03:04 PM 
  //$date = date('d/m/Y');
  $date =CURRENT_TIMESTAMP; // define in core/securityfunctions.php
  //Start SMC-3453
   /* $fullname=explode(" ",$parent_name);
	 $fname=$fullname[0];
	 $mname=$fullname[1];
	 $lname=$fullname[2]; */
   


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($parent_email) && !empty($parent_pswd) && !empty($parent_cnf_paswd))
{
	
		
  
	      if($parent_pswd==$parent_cnf_paswd)
		  { 
			$get_parent_info=mysql_query("select * from `tbl_parent` where `email_id`='$parent_email'");
			//SAND-324(change done by sachin as per pramode & Rakesh sir discussion)
			$get_parent_info_phone=mysql_query("select * from `tbl_parent` where `Phone`='$parent_phone'");
			//end SAND-324(change done by sachin)
			if(mysql_num_rows($get_parent_info)==0)
			{
				//SAND-324(change done by sachin as per pramode & Rakesh sir discussion)
					if(mysql_num_rows($get_parent_info_phone)==0)
						{
						//end SAND-324(change done by sachin)
				
				$password = trim($parent_pswd);                                   
				$insert_parent_info="INSERT INTO `tbl_parent` (Name,email_id,Phone,Password,reg_date,CountryCode)
				VALUES ('$parent_name','$parent_email','$parent_phone','$password','$date','$country_code')";
				$result_insert1 = mysql_query($insert_parent_info) or die(mysql_error());
					
											 $from="smartcookiesprogramme@gmail.com";
											  $to=$parent_email;
											  $subject="Registration Successfully";
											  $message="
											    <html>
												<head>
												
												</head>
												<body>
											    <table width=400 border=1 cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
												  <tr>
													<td><table width=400 border=0 cellspacing=0 cellpadding=8>
													  <tr>
														<td colspan=2 bgcolor=#CDD9F5><strong>Thanks you!, You are registered as a Parent in SmartCookie</strong></td>
													  </tr>
													  <tr>
														<td width=168 bgcolor=#FFFFEC><strong>Your Username is:</strong></td>
														<td width=290 bgcolor=#FFFFEC><?php ".$parent_email." ?></td>
													  </tr>
													  <tr>
														<td bgcolor=#FFFFDD><strong>Your Password is:</strong></td>
														<td bgcolor=#FFFFDD><?php ".$password." ?></td>
													  </tr>
													  
													  <p>Thanks for your registration with Smart Cookie - A student/Teacher Rewards Program</p>
													  <p>Regards,</p>
													  <p>Smart Cookie Admin Please visit to www.smartcookie.in</p>
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
												mail($to, $subject, $message,$headers);
				
												$postvalue['responseStatus']=200;
												$postvalue['responseMessage']="Parent has been registered successfully..";
												header('Content-type: application/json');
												echo  json_encode($postvalue);
					//SAND-324(change done by sachin as per pramode & Rakesh sir discussion)
						}
						else
							{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Phone Number already exist..";
								 header('Content-type: application/json');
								 echo  json_encode($postvalue); 
							}
					//end SAND-324(change done by sachin)
			}
			else
				{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="Email ID already exist..";
					 header('Content-type: application/json');
   			         echo  json_encode($postvalue); 
				}
		  }	else
				{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="Sry.. Your confirm password and password didn't match";
					 header('Content-type: application/json');
					echo  json_encode($postvalue); 
				}	

	
}
	else
			{
			
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>