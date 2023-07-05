<?php  
/*
Changes done by Pranali_intern 
Date: 06/04/2018
*/

include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';

$email_id = xss_clean(mysql_real_escape_string($obj->{'email'}));
$entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));

$site = $GLOBALS['URLNAME'] ;

	if($email_id!="" && $entity_id!="")
	{
		 $posts=array();
		
		if($entity_id==1)  //if user is Student
		{
				$arr=mysql_query("select std_phone,std_email from tbl_student where (std_email='$email_id' OR std_phone='$email_id')");
				$count = mysql_num_rows($arr);

				if($count>0)
				{
						$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
						$password = substr( str_shuffle( $chars ), 0, 8 );
						$query=mysql_query("update tbl_student set std_password='$password' where (std_email='$email_id' OR std_phone='$email_id')");

						while($row=mysql_fetch_array($arr))
						{
								 $std_phone=$row['std_phone'];
								 $std_email=$row['std_email']; 
				
								if(!is_numeric($email_id))           //if email as input
								{
										$msgid='forgotpasswordstudent';
										$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$std_email&msgid=$msgid&site=$site&pass=$password");
										
										$Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site" ;
										$Text=urlencode($Text1);

										/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];

										$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$std_phone&Text=$Text";
										$result= file_get_contents($url);
												
										$report="Your password has been sent to your registered Email ID and Mobile No";
								}//if
			
								else								//if mobile number as input
								{						
										$msgid='forgotpasswordstudent';
										$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$std_email&msgid=$msgid&site=$site&pass=$password");
							   
										$Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site" ;
										$Text=urlencode($Text1);
										/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
						$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$std_phone&Text=$Text";
										$result= file_get_contents($url);
															
										$report="Your password has been sent to your registered Email ID and Mobile No";
								}
						
						}	  //while
				}	
			
			if($report=="Your password has been sent to your registered Email ID and Mobile No")
			{
					$posts[]=array('report'=>$report);	  
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					exit;
			}
			 else    
			{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Response";
					$postvalue['posts']=null;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					exit;
	  
			 }	
		}

		else if($entity_id==2)   //if user is Teacher
		 {
			    $arr=mysql_query("select t_email,t_phone from tbl_teacher where (t_email='$email_id' OR t_phone='$email_id')");
				$count = mysql_num_rows($arr);
							
					if($count>0)
					{
							$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$password = substr( str_shuffle( $chars ), 0, 8 );
 							$query=mysql_query("update tbl_teacher set t_password='$password' where (t_email='$email_id' OR t_phone='$email_id')");
				
								while($row=mysql_fetch_array($arr))
								{
										$t_email=$row['t_email']; 
										$t_phone=$row['t_phone'];
			
									 if(!is_numeric($email_id))      //if input as email
									{
										 $msgid='forgotpasswordteacher';
										 $res = file_get_contents("$site/core/clickmail/sendmail.php?email=$t_email&msgid=$msgid&site=$site&pass=$password");   
		   
										 $Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site" ;
										 $Text=urlencode($Text1);
										 	/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
										 $url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$t_phone&Text=$Text";
										 $result= file_get_contents($url);

										  $report="Your password has been sent to your registered Email ID and Mobile No";
									}
	   
									else
									{
										  $msgid='forgotpasswordstudent';
										  $res = file_get_contents("$site/core/clickmail/sendmail.php?email=$t_email&msgid=$msgid&site=$site&pass=$password");

										  $Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site";
										  $Text=urlencode($Text1);
										  /*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
										  $url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$t_phone&Text=$Text";
										  $result= file_get_contents($url);

										  $report="Your password has been sent to your registered Email ID and Mobile No";
									}
								}//while
						}
			if($report=="Your password has been sent to your registered Email ID and Mobile No")
			{
					$posts[]=array('report'=>$report);			  
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					exit;
			}
		   else
		   {
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				header('Content-type: application/json');
    			echo json_encode($postvalue);
				exit;
	        }
					 
          }
		 
		else if($entity_id==3)   //if user is test
		 {
		 $arr=mysql_query("select email,mobile from tbl_school_admin where (email='$email_id' OR mobile='$email_id')");
				$count = mysql_num_rows($arr);
						
					if($count>0)
					{
							$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							$password = substr( str_shuffle( $chars ), 0, 8 );
 							$query=mysql_query("update tbl_school_admin set password='$password' where (email='$email_id' OR mobile='$email_id')");
				
								while($row=mysql_fetch_array($arr))
								{
										$email=$row['email']; 
										$mobile=$row['mobile'];
			
									 if(!is_numeric($email_id))      //if input as email
									{
										 $msgid='forgotpasswordteacher';
										 $res = file_get_contents("$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password");   
		   
										 $Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site" ;
										 $Text=urlencode($Text1);
										 	/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
										 $url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$mobile&Text=$Text";
										 $result= file_get_contents($url);

										  $report="Your password has been sent to your registered Email ID and Mobile No";
									}
	   
									else
									{
										  $msgid='forgotpasswordstudent';
										  $res = file_get_contents("$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password");

										  $Text1="You recently requested to reset your password. Your Username is: $email_id Your Password is: $password Smartcookie Admin $site";
										  $Text=urlencode($Text1);
										  /*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
										  $url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$mobile&Text=$Text";
										  $result= file_get_contents($url);

										  $report="Your password has been sent to your registered Email ID and Mobile No";
									}
								}//while
						}
			if($report=="Your password has been sent to your registered Email ID and Mobile No")
			{
					$posts[]=array('report'=>$report);			  
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;
					header('Content-type: application/json');
					echo json_encode($postvalue);
					exit;
			}
		   else
		   {
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				header('Content-type: application/json');
    			echo json_encode($postvalue);
				exit;
	        }
					 
          }
		  else 
	  {
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
				header('Content-type: application/json');
    			echo json_encode($postvalue);
				exit;
			 
	  }	
		  
      }      
   
  		
	  else 
	  {
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
				header('Content-type: application/json');
    			echo json_encode($postvalue);
				exit;
			 
	  }			  
?>

		
