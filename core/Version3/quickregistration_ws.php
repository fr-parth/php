<?php  

//$json=$_GET ['json'];

$json = file_get_contents('php://input');

$obj = json_decode($json);



 $format = 'json'; //xml is the default





include 'conn.php';
require "twilio.php";


 $firstname=$obj->{'firstname'};
 	$middlename=$obj->{'middlename'};
	$lastname=$obj->{'lastname'};
    $phonenumber=$obj->{'phonenumber'};
    $emailid=$obj->{'emailid'};
	$countrycode=$obj->{'countrycode'};
	
	//password genrator
   $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $chars ), 0, 8 );

$type=$obj->{'type'};

//validation of input
	if( $phonenumber !="" && $emailid!="" && $firstname!="" && $lastname!=""  && filter_var($emailid, FILTER_VALIDATE_EMAIL) && strlen($phonenumber)==10)

		{

                     //for student
			if($type=="student")
			{
				$std_complete_name=$firstname." ".$middlename." ".$lastname;
			
				$row=mysql_query("select * from tbl_student where std_email like '$emailid' or std_phone='$phonenumber'");
				//email id and phone already exist
				if(mysql_num_rows($row)<=0)
				{
					
				mysql_query("insert into tbl_student(std_complete_name,std_name,std_lastname,std_Father_name,std_phone,school_id,std_email,std_password,country_code	) values ('$std_complete_name','$firstname','$lastname','$middlename','$phonenumber','OPEN','$emailid','$password','$countrycode')");
                    $next_id =  mysql_insert_id();
                    mysql_query("update tbl_student set std_PRN='$next_id' where std_email='$emailid' and school_id='OPEN'");
				$row_student=mysql_query("select id,std_password from tbl_student where std_email like '$emailid'");
				/* create one master array of the records */

					$postvalue = array();
		
							if(mysql_num_rows($row_student)>0) 
				
							{
				
								while($post = mysql_fetch_assoc($row_student))
				
								{
									$std_password=$post['std_password'];
				
									$student_id=(int)$post['id'];
				
									$posts[] = array('id'=>$student_id,'password'=>$std_password);
									//mail to student
					
										$to=$emailid;
										$from="smartcookiesprogramme@gmail.com";
										$subject="Smartcookies Registration";
										$message="Dear Student,\r\n\r\n".
											 "Thanks for your registration with Smart Cookie as Student\r\n".
											  "Your Username is: ".$emailid."\n\n".
											  "Your Password is: ".$password."\n\n".
											  "Android APP:  https://goo.gl/r4YMt4 \n\n".
                                              "iOS APP:  https://goo.gl/HNqrPR \n\n".
											  "Website: www.smartcookie.in \n\n".
											  "Regards,\r\n".
											  "Smart Cookie Admin";
											  
											  
											  
										mail($to, $subject, $message);
										if($countrycode==91)
										{
											/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						
											//$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+as+Student+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$phonenumber."+and+Password+is+".$password.".";
											$Text="Welcome,+".$firstname."+".$lastname."+to+www.smartcookie.in+as+Student.+Your+Username+is+".$phonenumber."+and+Password+is+".$password."+Android+App:+https://goo.gl/r4YMt4+iOS+App:+https://goo.gl/HNqrPR";
											//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166
											$url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phonenumber&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
					
					
										file_get_contents($url);
										}
										else if($countrycode==1)
										{
											$ApiVersion = "2010-04-01";
									
										// set our AccountSid and AuthToken
										$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
										$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
										
										// instantiate a new Twilio Rest Client
										$client = new TwilioRestClient($AccountSid, $AuthToken);
										$number="+1".$phonenumber;
										//$message="CONGRATULATIONS!,You are now a registered User of Smart Cookie as Student.Your Username is ".$phonenumber." and Password is ".$pass.".";
                                            $message="Welcome ".$firstname." ".$lastname." to www.smartcookie.in as Student.Your Username is ".$phonenumber." and Password is ".$pass."iOS APP:  https://goo.gl/HNqrPR  Android App: https://goo.gl/r4YMt4";
													$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
												"POST", array(
												"To" => $number,
												"From" => "732-798-7878",
												"Body" => $message
											));
													
													
													
											
											
											
										}
										else
										{}
				
								}
				
								
				
									$postvalue['responseStatus']=200;
				
								$postvalue['responseMessage']="OK";
				
								$postvalue['posts']=$posts;
							}
								else
								{
										$postvalue['responseStatus']=204;
				
												$postvalue['responseMessage']="No Response";
				
												$postvalue['posts']=null;
									
								}
				}
				else
						{
								$postvalue['responseStatus']=409;
		
										$postvalue['responseMessage']="conflict";
		
										$postvalue['posts']=null;
							
						}
			}
			//for teacher
			else if($type=="teacher")
			{
				
					$teacher_complete_name=$firstname." ".$middlename." ".$lastname;
				$row=mysql_query("select * from tbl_teacher where t_email like '$emailid' or t_phone='$phonenumber'");
				if(mysql_num_rows($row)<=0)
				{
				mysql_query("insert into tbl_teacher(t_complete_name,t_name,t_lastname,t_middlename,t_phone,t_email,t_password,school_id) values ('$teacher_complete_name','$firstname','$lastname','$middlename','$phonenumber','$emailid','$password','OPEN')");
                    $next_id =  mysql_insert_id();
                    mysql_query("update tbl_teacher set t_id='$next_id' where t_email='$emailid' and school_id='OPEN'");
				$row_teacher=mysql_query("select id,t_password from tbl_teacher where t_email like '$emailid'");
				

						if(mysql_num_rows($row_teacher)>0) 
			
						{
		
								while($post = mysql_fetch_assoc($row_teacher))
				
								{
									$t_password=$post['t_password'];
				
									$teacher_id=(int)$post['id'];
				
									$posts[] = array('id'=>$teacher_id,'password'=>$t_password);
									//mail to student
					
					$to=$emailid;
					$from="smartcookiesprogramme@gmail.com";
					$subject="Smartcookies Registration";
					$message="Dear Student,\r\n\r\n".
						 "Thanks for your registration with Smart Cookie as Teacher\r\n".
						  "Your Username is: ".$emailid."\n\n".
						  "Your Password is: ".$password."\n\n".
                          "Android APP: https://goo.gl/89Fr11  \n\n".
                          "iOS APP: https://goo.gl/cdi711  \n\n".
                          "Website: www.smartcookie.in \n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin ";
						  
					mail($to, $subject, $message);
					
						if($countrycode==91)
										{
											/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						
											//$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+as+Teacher+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$phonenumber."+and+Password+is+".$password.".";
                                            $Text="Welcome,+".$firstname."+".$lastname."+to+www.smartcookie.in+as+Teacher.+Your+Username+is+".$phonenumber."+and+Password+is+".$password."+Android+App:+https://goo.gl/89Fr11+iOS+App:+https://goo.gl/cdi711";
                                            //Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166
											$url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phonenumber&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
					
					
										file_get_contents($url);
										}
										else if($countrycode==1)
										{
											$ApiVersion = "2010-04-01";
									
										// set our AccountSid and AuthToken
										$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
										$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
										
										// instantiate a new Twilio Rest Client
										$client = new TwilioRestClient($AccountSid, $AuthToken);
										$number="+1".$phonenumber;
										//$message="CONGRATULATIONS!,You are now a registered User of Smart Cookie as Teacher.Your Username is ".$phonenumber." and Password is ".$pass.".";
                                            $message="Welcome ".$firstname." ".$lastname." to www.smartcookie.in as Teacher. Your Username is ".$phonenumber." and Password is ".$pass."iOS APP: https://goo.gl/HNqrPR  Android App: https://goo.gl/r4YMt4";
													$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
												"POST", array(
												"To" => $number,
												"From" => "732-798-7878",
												"Body" => $message
											));
													
													
													
											
											
											
										}
										else
										{}
				
								}
				
								
				
									$postvalue['responseStatus']=200;
				
								$postvalue['responseMessage']="OK";
				
								$postvalue['posts']=$posts;
						}
						else
						{
								$postvalue['responseStatus']=204;
		
										$postvalue['responseMessage']="No Response";
		
										$postvalue['posts']=null;
							
						}
				}
				else
				{
					                   $postvalue['responseStatus']=409;
		
										$postvalue['responseMessage']="conflict";
		
										$postvalue['posts']=null;
				
				}
			}
			
		}
		else
		{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;	
		
		
		}
			

 header('Content-type: application/json');
echo json_encode($postvalue); 

  /* disconnect from the db */

  @mysql_close($link);	

	

		

  ?>

  

 