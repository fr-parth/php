<?php  

//$json=$_GET ['json'];

$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; //xml is the default
require "twilio.php";
$condition = "";
if($obj!='')
 {
	 $key=$obj->{'Key'};
	$Org_name=$obj->{'org_name'};
	$phonenumber=$obj->{'phonenumber'};
	//$key=$obj->{'Key'};
	$countrycode=$obj->{'countrycode'};
	$middlename=$obj->{'middlename'};
	$source=$obj->{'source'};
	$User_Type=$obj->{'user_type'};    
	$lastname=$obj->{'lastname'}; 
    $firstname=$obj->{'firstname'};
    $emailid=$obj->{'emailid'}; 
	$MemberId=$obj->{'member_id'};  
	$qualification=$obj->{'qualification'}; 
	$ssc_mark=$obj->{'ssc_mark'}; 
	$person_complete_name=$firstname." ".$middlename." ".$lastname;
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$";
	$password = substr( str_shuffle( $chars ), 0, 6 );
 }
 
elseif($obj='')
 {
	$key=$_GET['Key'];
    $firstname=$_GET['firstname'];
 	$middlename=$_GET['middlename'];
	$lastname=$_GET['lastname'];
    $phonenumber=$_GET['phonenumber'];
    $emailid=$_GET['emailid'];
	$MemberId=$_GET['member_id'];
	$countrycode=$_GET['countrycode'];
	$qualification=$_GET['qualification'];
	//$input_type=$obj->{'input_type'};            //emailid/phone/memberid
	$User_Type=$_GET['user_type'];               //student/employee
	$Org_name=$_GET['org_name'];
	$ssc_mark=$_GET['ssc_mark'];
	$source=$_GET['source'];
	$person_complete_name=$firstname." ".$middlename." ".$lastname;
	$collection=array();
	//password genrator
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$";
	$password = substr( str_shuffle( $chars ), 0, 6 );
 }
 
 
 

//validation of input
	if( $key!="" && (($phonenumber !="" && strlen($phonenumber)==10) || ($emailid!="") ) && $firstname!="" && $lastname!="" && $Org_name!="")

		{
			switch ($key) 
			{
							case 1:
								     $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								break;
							case 2:
										$collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									     makeRegistration($collection);
								break;
							case 3:
							         $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								
								break;
							
							case 4:
								     $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								break;	
							
							case 5:
								     $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								break;	
						
							case 6:
								     $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								break;	
							case 7:
								    $collection = array($key,$firstname,$middlename,$lastname,$phonenumber,$emailid,$countrycode,$qualification,$MemberId,$User_Type,$ssc_mark,$person_complete_name,$Org_name,$password,$format,$source);
									 makeRegistration($collection);
								break;
								
							default:
								    
	
										$postvalue['responseStatus']=1000;
										$postvalue['responseMessage']="Invalid Key";
										$postvalue['posts']=null;
										display($postvalue,$posts,$format);										
		
		
			}
		}else
		{
			
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="$a";
				$postvalue['posts']=null;
				//display($postvalue,$posts,$format);
		}
                    
			

 
  /* disconnect from the db */
  function makeRegistration($collected)
  {
	 	$key=$collected[0];
		$firstname=$collected[1];
	    $middlename=$collected[2];
		$lastname=$collected[3];
		$phonenumber=$collected[4];
		$emailid=$collected[5];
		$countrycode=$collected[6];
		$qualification=$collected[7];
		$MemberId=$collected[8];
		$User_Type=$collected[9];
		$ssc_mark=$collected[10];
		$person_complete_name=$collected[11];
		$Org_name=$collected[12];
		$password=$collected[13];
		$format=$collected[14];
		$source=$collected[15];
		$postvalue = array();
	  
	    if($key==1)
		{		$flag='';
				$user="Smart+Cookie";
				$website_name="http://tsmartcookies.bpsi.us/";
				$Send_Emailid="smartcookiesprogramme@gmail.com";
				include 'conn.php';
				
				$row=mysql_query("select * from tbl_student where std_email='$emailid'");// or std_phone='$phonenumber'
				//email id and phone already exist
				if(mysql_num_rows($row)<=0)
				{
					//$next_id =  mysql_insert_id()+1;
					mysql_query("insert into tbl_student(std_complete_name,std_name,std_lastname,std_Father_name,std_phone,std_email,std_password,country_code,RegistrationSource,std_school_name,school_id) values ('$person_complete_name','$firstname','$lastname','$middlename','$phonenumber','$emailid','$password','$countrycode','$source','$Org_name','OPEN')");
					$next_id =  mysql_insert_id();
					mysql_query("update tbl_student set std_PRN='$next_id' where std_email='$emailid' and school_id='OPEN'");
					$flag=1;
					
				}
					    $row_student=mysql_query("select id,std_password,std_email from tbl_student where std_email='$emailid'");//or std_phone='$phonenumber'
					     while($post = mysql_fetch_assoc($row_student))
				
								{
									$std_password=$post['std_password'];
									$student_member_id=(int)$post['id'];
									$student_email_id=$post['std_email'];
									$posts[] = array('id'=>$student_member_id,'email'=>$student_email_id,'password'=>$std_password);
									//mail to student
					
										
								}
								if($flag==1)
								{
									$postvalue['responseStatus']=201;
									$postvalue['responseMessage']="New USer";
									$postvalue['posts']=$posts;
									display($postvalue,$posts,$format);
									sendEmailId($emailid,$password,$Send_Emailid,$user,$User_Type,$website_name);
									sendSMSMessgae($countrycode,$phonenumber,$password,$user);
								}else{
									
										$postvalue['responseStatus']=200;
										$postvalue['responseMessage']="Old User";
										$postvalue['posts']=$posts;
										display($postvalue,$posts,$format);
								}
		}	
		
		else if($key==2)
		{
				$user="Ethical+HR";
				$website_name="http://ethicalhr.org/";
				$Send_Emailid="ethicalhrorg@gmail.com";
				include 'conn_to_db.php';
				$timestamp = time()-86400;
				$time_now=mktime(date('h')+5,date('i')+30,date('s'));
				$indian_time=date('h:i:s A',$time_now);
				$date = date('d-m-Y')." ".$indian_time;
				$date1 = strtotime("+10 day", $timestamp);
				$date_after_10days=date('d-m-Y', $date1);
				$now = time(); // or your date as well
				$your_date = strtotime($date_after_10days);
				$datediff = $now - $your_date;
				$date_diff_days=abs(floor($datediff/(60*60*24)));
				$days=$date_diff_days+1;
				$get_reg_id=mysql_query("select `reg_id` from `tbl_emp_details` ORDER BY `hr_id` DESC LIMIT 1 ");  //query for getting last batch_id what else if are inserting first time data
				$value2=mysql_fetch_array($get_reg_id);
				$reg_id1=$value2['reg_id'];
				$b_id=explode("-",$reg_id1);
				$b=$b_id[1]; 
				$reg_id=$b+1;
				$str=str_pad($reg_id, 5, "0000", STR_PAD_LEFT);
				$system_generated_reg_id="1601"."-".$str;
				$row=mysql_query("select * from tbl_emp_details where email_id='$emailid'"); // or phone_no='$phonenumber'
				//email id and phone already exist
				if(mysql_num_rows($row)<=0)
				{
										
					$insert_emp_info="INSERT INTO `tbl_emp_details` (full_name,first_name,middle_name,last_name,phone_no,country_code,email_id,reg_id,reg_date,password,org_name,user_status,source)
											  VALUES ('$person_complete_name','$firstname','$middlename','$lastname','$phonenumber','$countrycode','$emailid','$system_generated_reg_id','$date','$password','$Org_name','$User_Type','$source')";
											 $result_insert1 = mysql_query($insert_emp_info) or die(mysql_error()); 
											 $get_hr_id=mysql_query("select `hr_id` from `tbl_emp_details` ORDER BY `reg_id` DESC LIMIT 1 ");  //query for getting last batch_id what else if are inserting first time data
											 $value3=mysql_fetch_array($get_hr_id);
											 $hr_id=$value3['hr_id'];
											 $check_dup_record=mysql_query("select * from `tbl_engagement_log` where`ethical_reg_id`='$system_generated_reg_id'");
											 if(mysql_num_rows($check_dup_record)==0)
											 {
										  
											  $insert_eng__log_info="INSERT INTO `tbl_engagement_log`  (ethical_reg_id,hr_id,reg_date,expected_reply_date,days_count_from_reg_date)
											   VALUES ('$system_generated_reg_id','$hr_id','$date','$date_after_10days','$days')";
											  $result_insert11 = mysql_query($insert_eng__log_info) or die(mysql_error());
										  
											}else
												{
													$update_duplicate="UPDATE `tbl_engagement_log` SET ethical_reg_id='$system_generated_reg_id',hr_id='$hr_id',reg_date='$date',expected_reply_date='$date_after_10days',days_count_from_reg_date='$days' where`ethical_reg_id`='$system_generated_reg_id'";
													$udpdate_count = mysql_query($update_duplicate) or die('Could not update data: ' . mysql_error());
												}
												
						$flag1=1;						
					
				}
					    $row_student=mysql_query("select hr_id,email_id,password,reg_id from tbl_emp_details where 
						email_id='$emailid' "); //or phone_no='$phonenumber'
					     while($post = mysql_fetch_assoc($row_student))
				
								{
									$std_password=$post['password'];
									$student_member_id=(int)$post['hr_id'];
									$ethical_reg_id=$post['reg_id'];
									$emailid=$post['email_id'];
									$posts[] = array('id'=>$student_member_id,'password'=>$std_password,'ethical_reg_id'=>$ethical_reg_id,'email'=>$emailid);
									//mail to student
					
										
								}
								if($flag1==1)
								{
									$postvalue['responseStatus']=201;
									$postvalue['responseMessage']="New USer";
									$postvalue['posts']=$posts;
									display($postvalue,$posts,$format);
									sendEmailId($emailid,$password,$Send_Emailid,$user,$User_Type,$website_name);
									sendSMSMessgae($countrycode,$phonenumber,$password,$user);
								}else{
									
										$postvalue['responseStatus']=200;
										$postvalue['responseMessage']="Old User";
										$postvalue['posts']=$posts;
										display($postvalue,$posts,$format);
								}
						
		}	
	    else if($key==3)
		{
								$postvalue['responseStatus']=402;
								$postvalue['responseMessage']="Work in progress";
								$postvalue['posts']=$posts;
								display($postvalue,$posts,$format);
			
		}	
	    else if($key==4)
		{
			
								$postvalue['responseStatus']=402;
								$postvalue['responseMessage']="Work in progress";
								$postvalue['posts']=$posts;
								display($postvalue,$posts,$format);
			
		}	
	    else if($key==5)
		{
				$user="StartUp+World";
				$website_name="http://startupworld.us";
				$Send_Emailid="smartcookiesprogramme@gmail.com";
				include 'conn.php';
				$row=mysql_query("select * from tbl_user where email='$emailid'");// or mobile='$phonenumber'
				//email id and phone already exist
				if(mysql_num_rows($row)<=0)
				{
					
					mysql_query("insert into tbl_user(uname,email,mobile,pass,Source,country_code,college) values 
					('$person_complete_name','$emailid','$phonenumber','$password','$source','$countrycode','$Org_name')");
					
					$flag2=1;
				}
					    $row_student=mysql_query("select id,pass,email from tbl_user where email='$emailid'"); // or mobile='$phonenumber'
					     while($post = mysql_fetch_assoc($row_student))
				
								{
									$std_password=$post['pass'];
									$student_member_id=(int)$post['id'];
									$email_id=$post['email'];
									$posts[] = array('id'=>$student_member_id,'password'=>$std_password,'email'=>$email_id);
									//mail to student
					
										
								}
								if($flag2==1)
								{
									$postvalue['responseStatus']=201;
									$postvalue['responseMessage']="New USer";
									$postvalue['posts']=$posts;
									display($postvalue,$posts,$format);
									sendEmailId($emailid,$password,$Send_Emailid,$user,$User_Type,$website_name);
									sendSMSMessgae($countrycode,$phonenumber,$password,$user);
								}else{
									
										$postvalue['responseStatus']=200;
										$postvalue['responseMessage']="Old User";
										$postvalue['posts']=$posts;
										display($postvalue,$posts,$format);
								}
			
			
		}	
	    else if($key==6)
		{
								$postvalue['responseStatus']=402;
								$postvalue['responseMessage']="Work in progress";
								$postvalue['posts']=$posts;
								display($postvalue,$posts,$format);
			
		}else
		{
			if($key==7)
			{
								$postvalue['responseStatus']=402;
								$postvalue['responseMessage']="Work in progress";
								$postvalue['posts']=$posts;
								display($postvalue,$posts,$format);
				
			}
			
		}			
	  
  }
  function sendEmailId($emailid,$password,$Send_Emailid,$user,$User_Type,$website_name)
  {
	           $abc=explode("+",$user);
			   $a=$abc[0]." ".$abc[1];
										  
										$to =$emailid;
										$subject = $a." "."Registration";
										$message="
											    <html>
												<head>
												
												</head>
												<body>
											    <table width=500 border=1 cellpadding=0 cellspacing=0 bordercolor=#CCCCCC>
												  <tr>
													<td><table width=500 border=0 cellspacing=0 cellpadding=8>
													  <tr>
														<td colspan=2 bgcolor=#CDD9F5><strong>Thanks you!, your Registration has been accepted successfully</strong></td>
													  </tr>
													  <tr>
														<td width=168 bgcolor=#FFFFEC><strong>Your Username is:</strong></td>
														<td width=290 bgcolor=#FFFFEC>".$emailid."</td>
													  </tr>
													  <tr>
														<td bgcolor=#FFFFDD><strong>Your Password is:</strong></td>
														<td bgcolor=#FFFFDD> ".$password." </td>
													  </tr>
													 
													  <p>Thanks for your registration with ".$a."</p>
													  <p>Regards,</p>
													  <p>".$a." Admin ".$website_name."</p>
													</td>
												  </tr>
												</table>
												</body>
												</html>
												";

										$headers = 'From:' .$Send_Emailid. "\r\n" ;
										$headers .='Reply-To: '. $to . "\r\n" ;
										$headers .= "MIME-Version: 1.0\r\n";
										$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
									    $headers .= "X-Priority: 3\r\n";
									    $headers .='X-Mailer: PHP/' . phpversion();
								 										
									if(mail($to, $subject, $message, $headers)) {
									 // echo('<br>'."Email Sent ;D ".'</br>');
									  } 
									  else 
									  {
									 // echo("<p>Email Message delivery failed...</p>");
									  }
  }							  
  function sendSMSMessgae($countrycode,$phonenumber,$password,$user)
  {
	               $mob="/^[789][0-9]{9}$/";
	               if(preg_match($mob, $phonenumber))
				   {
										if($countrycode==91)
										{
											/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                            			$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                            			$dynamic_fetch= mysql_fetch_array($sql_dynamic);
                            			$dynamic_user = $dynamic_fetch['mobileno'];
                            			$dynamic_pass = $dynamic_fetch['email'];
                            			$dynamic_sender = $dynamic_fetch['otp'];
											 //echo "MSG sent";
											$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+".$user."+-+Program.+Your+Username+is+".$phonenumber."+and+Password+is+".$password."."; 
											$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phonenumber&Text=$Text";
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
											$message="CONGRATULATIONS!,You are now a registered User of ".$user.".Your Username is ".$phonenumber." and Password is ".$password."."; 
													
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
	   
  }

  function display($postvalue,$posts,$format)
        {

              	if($format == 'json') 
				{
    					header('Content-Type: application/json');
    					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }


        }

  @mysql_close($link);	

	

		

  ?>

  

 