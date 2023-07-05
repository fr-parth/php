<?php
ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
ignore_user_abort(true);
set_time_limit(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

//print_r($obj)exit;

$format = 'json'; //xml is the default
include '../conn.php';

require "twilio.php";

		$firstname = xss_clean(mysql_real_escape_string($obj->{'firstname'}));
		$middlename = xss_clean(mysql_real_escape_string($obj->{'middlename'}));
		$lastname = xss_clean(mysql_real_escape_string($obj->{'lastname'}));
		$password = xss_clean(mysql_real_escape_string($obj->{'password'}));
		$phonenumber = xss_clean(mysql_real_escape_string($obj->{'phonenumber'}));
		$emailid = xss_clean(mysql_real_escape_string($obj->{'emailid'}));
		$countrycode = xss_clean(mysql_real_escape_string($obj->{'countrycode'}));
		$platform_source = xss_clean(mysql_real_escape_string($obj->{'platform_source'}));
		$type = xss_clean(mysql_real_escape_string($obj->{'type'}));
//extra parameter school_id added by Pranali on 28-1-19
		$school_id     =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
		$emp_type_pid    =  xss_clean(mysql_real_escape_string($obj->{'emp_type_pid'}));
		$site = $GLOBALS['URLNAME'];

		if($countrycode=='91')
		{
				$country="INDIA";
		}
		else if($countrycode=='1')
		{
			$country="USA";
		}
		else
		{
			$country="INDIA";
		}

		
		$StudentAndroidApp="https://goo.gl/G6jpu2";
		$StudentiOSApp="https://goo.gl/HNqrPR";
		$TeacherAndroidApp="https://goo.gl/89Fr11";
		$TeacheriOSApp="https://goo.gl/cdi711";
						/*$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
						$password = substr(str_shuffle($chars) , 0, 8);*/
						

							// validation of input

							if ($phonenumber != "" && $emailid != "" && $firstname != "" && $lastname != "" && filter_var($emailid, FILTER_VALIDATE_EMAIL) && strlen($phonenumber) == 10)
								{
									$date = CURRENT_TIMESTAMP;
									if($school_id=='')
	  								{
										  $school_id='OPEN';
									}
									$school_details = mysql_query("SELECT school_type,group_member_id FROM tbl_school_admin WHERE school_id='$school_id'");
									$school_details1 = mysql_fetch_assoc($school_details);
									$school_type = $school_details1['school_type'];
									$group_id = $school_details1['group_member_id'];
								// for student

								if ($type == "student")
									{				
									$std_complete_name = $firstname . " " . $middlename . " " . $lastname;
									
									$row = mysql_query("select * from tbl_student where school_id='$school_id' and (std_email='$emailid' or std_phone='$phonenumber')");

									// email id and phone already exist
//$school_id value inserted into tbl_student by Pranali
									if (mysql_num_rows($row) <= 0)
										{
										mysql_query("insert into tbl_student(std_complete_name,std_name,std_lastname,std_Father_name,std_phone,school_id,std_email,std_password,country_code,std_country,RegistrationSource,group_member_id,entity_type_id,std_date) values ('$std_complete_name','$firstname','$lastname','$middlename','$phonenumber','$school_id','$emailid','$password','$countrycode','$country','SELF','$group_id','105','$date')");
										
										$next_id = mysql_insert_id();
										mysql_query("update tbl_student set std_PRN='$next_id' where std_email='$emailid' and school_id='$school_id'");
										
										//Student get reward points on self registration logic added by Pranali for SMC-4449 on 21-1-20
										$reward = mysql_query("select points,referal_reason_id,school_id from rule_engine_for_referral_activity WHERE From_entityid='105' AND referal_reason_id='1004' and is_enable='1'");
										if(mysql_num_rows($reward)>0){

										$reward1 = mysql_fetch_assoc($reward);
										$points = $reward1['points'];
										$referal_reason_id = $reward1['referal_reason_id'];
										$type_points='BrownPoints';

										$reward_insert = mysql_query("insert into tbl_student_reward(sc_stud_id,sc_date,school_id,brown_point) values ('$next_id','$date','$school_id','$points')");
									 	
									 	$reward_log_insert = mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_point,point_date,reason,type_points,school_id,referral_id) values ('$next_id','105','$points','$date','Rewards for Self Registration','$type_points','$school_id','$referal_reason_id')");

									 	$referral_insert = mysql_query("insert into referral_activity_log(sender_member_id,sender_user_type,receiver_country_code,receiver_mobile_number,receiver_email_id,method,firstname,middlename,lastname,point,referral_id,invitation_sent_datestamp,accepted_datestamp) values ('$next_id','$type','$countrycode','$phonenumber','$emailid','Android','$firstname','$middlename','$lastname','$points','$referal_reason_id','$date','$date')");
									}
									//school_id added in where condition by Pranali for SMC-4449 on 14-2-20
										$row_student = mysql_query("select id, std_password,std_name,school_id,std_PRN,std_phone from tbl_student where std_email = '$emailid' and school_id='$school_id'");
										
										/* create one master array of the records */
										$postvalue = array();   
										if (mysql_num_rows($row_student) > 0)
											{
											while ($post = mysql_fetch_assoc($row_student))
												{
												$std_password = $post['std_password'];
												$student_name = $post['std_name'];
												$student_id = (int)$post['std_PRN'];
												$school_id = $post['school_id'];
												$member_id = $post['id'];
												$phone = $post['std_phone'];
												$posts[] = array(
													'id' => $student_id,
													'password' => $std_password,
												);
												
												
												$msgid='welcomestudentthroughquickregitrationws';
												$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$emailid&msgid=$msgid&site=$site&pass=$password&platform_source=$platform_source&studname=$student_name&school_id=$school_id&member_id=$member_id&t_phone=$phone&PRN=$student_id");
												if(stripos($res,"Mail sent successfully"))
												{
													$result_mail = 'mail sent successfully';
												}
												else{
													$result_mail = 'mail not sent';
												} 
												
												if ($countrycode == 91)
													{
														/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
														$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
														$dynamic_fetch= mysql_fetch_array($sql_dynamic);
														$dynamic_user = $dynamic_fetch['mobileno'];
														$dynamic_pass = $dynamic_fetch['email'];
														$dynamic_sender = $dynamic_fetch['otp'];
														
														$Text = "Congratulations!+" . $firstname . "+" . $lastname . "+Your+registration+is+successful+as+Student+through+quick+registration+on+www.smartcookie.in+Your+Username+is+" . $phonenumber . "+,+Your+Email+ID+is+" . $emailid . "+,+Your+PRN+Number+is+" . $student_id . "+,+Your+Member+ID+is+" . $member_id . "+,+Your+School+ID+is+". $school_id ."+and+Password+is+" . $password . "+Android+App:+" . $StudentAndroidApp ."+iOS+App:+"  . $StudentiOSApp ."+on+" .$platform_source."+app";
													//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166
													$url = SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phonenumber&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
													file_get_contents($url);
													}
												  else
												if ($countrycode == 1)
													{
													$ApiVersion = "2010-04-01";

													// set our AccountSid and AuthToken

													$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
													$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

													// instantiate a new Twilio Rest Client

													$client = new TwilioRestClient($AccountSid, $AuthToken);
													$number = "+1" . $phonenumber;

													$message = "Congratulations!" .$firstname . " " . $lastname . "Your registration is successful through quickregitration on www.smartcookie.in Your Username is" . $phonenumber . ",Your Email ID is " . $emailid . " , Your PRN Number is " . $student_id . " , Your Member ID is " . $member_id . ", Your School ID is ". $school_id ." and Password is " . $pass . "Android App:" . $StudentAndroidApp ."iOS APP:" .$StudentiOSApp ."on" . $platform_source . "app.";
													
													$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", array(
														"To" => $number,
														"From" => "732-798-7878",
														"Body" => $message
													));
													}
												  else
													{
													}
												}

											$postvalue['responseStatus'] = 200;
											$postvalue['responseMessage'] = "OK";
											$postvalue['mailstatus'] = $result_mail;
											$postvalue['posts'] = $posts ;
											header('Content-type: application/json');
											echo json_encode($postvalue);
											}
										  else
											{
											$postvalue['responseStatus'] = 204;
											$postvalue['responseMessage'] = "No Response";
											$postvalue['posts'] = null;
											header('Content-type: application/json');
											echo json_encode($postvalue);
											}
										}
									  else
										{
											//Updated web service for removing echo for SMC-4449 on 22/01/2020 -Rutuja
										$postvalue['responseStatus'] = 409;
										$postvalue['responseMessage'] = "Record already exists";
										$postvalue['posts'] = null;
										header('Content-type: application/json');
										echo json_encode($postvalue);
										}
									}

								// for teacher

						else if ($type == "teacher")
									{
									$teacher_complete_name = $firstname . " " . $middlename . " " . $lastname;
									//$row = mysql_query("select * from tbl_teacher where t_email like '$emailid' or t_phone='$phonenumber'");
									$row = mysql_query("select * from tbl_teacher where t_email like '$emailid' or t_phone='$phonenumber'");
									//echo $row; exit;
									if (mysql_num_rows($row) <= 0)
										{
											
										//// Start SMC-3450 Modify By Pravin 2018-09-21 08:27 PM 
											//$date=date('Y-m-d');
											//End SMC-3450
												mysql_query("insert into tbl_teacher(t_complete_name,t_name,t_lastname,t_middlename,t_phone,t_email,t_password,school_id,CountryCode,t_country,entity_type_id,t_emp_type_pid,school_type,group_member_id,t_date) values ('$teacher_complete_name','$firstname','$lastname','$middlename','$phonenumber','$emailid','$password','$school_id',$countrycode,'$country','103','$emp_type_pid','$school_type','$group_id','$date')");
												$next_id = mysql_insert_id();
												mysql_query("update tbl_teacher set t_id='$next_id' where t_email='$emailid' and school_id='$school_id'");
												$school_id="$school_id";

											
										//Teacher get reward points on self registration logic added by Pranali for SMC-4449 on 21-1-20
										$reward = mysql_query("select points,referal_reason_id,school_id from rule_engine_for_referral_activity WHERE From_entityid='103' AND referal_reason_id='1004' and is_enable='1'");
										
										if(mysql_num_rows($reward)>0){

										$reward1 = mysql_fetch_assoc($reward);
										$points = $reward1['points'];
										$referal_reason_id = $reward1['referal_reason_id'];
										$type_points='BrownPoints';

									 	$reward_log_insert = mysql_query("insert into tbl_teacher_point(sc_teacher_id,sc_entities_id,sc_point,point_date,reason,school_id,point_type,referral_id) values ('$next_id','103','$points','$date','Rewards for Self Registration','$school_id','$type_points','$referal_reason_id')");
										
										$reward_update = mysql_query("update tbl_teacher set brown_point='$points' where t_id='$next_id' and school_id='$school_id'");

									 	$referral_insert = mysql_query("insert into referral_activity_log(sender_member_id,sender_user_type,receiver_country_code,receiver_mobile_number,receiver_email_id,method,firstname,middlename,lastname,point,referral_id,invitation_sent_datestamp,accepted_datestamp) values ('$next_id','$type','$countrycode','$phonenumber','$emailid','Android','$firstname','$middlename','$lastname','$points','$referal_reason_id','$date','$date')");
									}		
										
										$row_teacher = mysql_query("select id,t_password,t_name,school_id,t_phone,t_id from tbl_teacher where t_email = '$emailid' and school_id='$school_id'");
										
										
										
										if (mysql_num_rows($row_teacher) > 0)
											{
											while ($post = mysql_fetch_assoc($row_teacher))
												{
												$t_password = $post['t_password'];
												$t_name = $post['t_name'];
												$teacher_id = (int)$post['t_id'];
												$school_id = $post['school_id'];
												$member_id = $post['id'];
												$phone = $post['t_phone'];
												$posts[] = array(
													'id' => $teacher_id,
													'password' => $t_password
												);

												
												
												$msgid='welcometeacherthroughquickregitrationws';
												$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$emailid&msgid=$msgid&site=$site&pass=$password&platform_source=$platform_source&techname=$t_name&school_id=$school_id&member_id=$member_id&t_phone=$phone&PRN=$teacher_id");
												
												if(stripos($res,"Mail sent successfully"))
												{
													$result_mail = 'mail sent successfully';
												}
												else{
													$result_mail = 'mail not sent';
												}
										
												if ($countrycode == 91)
													{
						/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
				
					$Text1="Welcome! " . $firstname . " " . $lastname ." Your registration is successful as Teacher through quickregistration on " . $site . " Your Username is " . $emailid . " , Your Phone Number is " . $phonenumber . " , Your Employee ID is " . $teacher_id . ",Your Member ID is " . $member_id . " , Your School ID is ". $school_id ." and Password is:".$password." iOS App:". $TeacheriOSApp ." Android App: ".$TeacherAndroidApp ." Preferred sponsors: ".$site."/preferredsponsors on " .$platform_source." app " ;
													
								$Text=urlencode($Text1);
												//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166	
											$url = SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phonenumber&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
													file_get_contents($url);
													}
												  else
												if ($countrycode == 1)
													{
													$ApiVersion = "2010-04-01";

													// set our AccountSid and AuthToken

													$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
													$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

													// instantiate a new Twilio Rest Client

													$client = new TwilioRestClient($AccountSid, $AuthToken);
													$number = "+1" . $phonenumber;

													$message = "Congratulations!" .$firstname . " " . $lastname . "Your registration is successful through quickregitration on www.smartcookie.in Your Username is" . $phonenumber . " , Your Email ID is " . $emailid . " Your Employee ID is " . $teacher_id . ", Your Member ID is " . $member_id . " , Your School ID is ". $school_id ." and Password is " . $pass . "Android App:" . $StudentAndroidApp ."iOS APP:" .$StudentiOSApp ."on" . $platform_source . "app.";
													
													$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", array(
														"To" => $number,
														"From" => "732-798-7878",
														"Body" => $message
													));
													}
												  else
													{
													}
												}

											$postvalue['responseStatus'] = 200;
											$postvalue['responseMessage'] = "OK";
											$postvalue['posts'] = $posts;
											header('Content-type: application/json');
											echo json_encode($postvalue);
											}
										  else
											{
											$postvalue['responseStatus'] = 204;
											$postvalue['responseMessage'] = "No Response";
											$postvalue['posts'] = null;
											header('Content-type: application/json');
											echo json_encode($postvalue);
											}
								        }
											else
											{
											$postvalue['responseStatus'] = 409;
											$postvalue['responseMessage'] = "record already exists";
											$postvalue['posts'] = null;
											header('Content-type: application/json');
											echo json_encode($postvalue);
											}
										
										}
									  else
										{
										$postvalue['responseStatus'] = 409;
										$postvalue['responseMessage'] = "conflict";
										$postvalue['posts'] = null;
										header('Content-type: application/json');
										echo json_encode($postvalue);
										}
									}
								
							  else
								{
								$postvalue['responseStatus'] = 1000;
								$postvalue['responseMessage'] = "Invalid Input";
								$postvalue['posts'] = null;
								header('Content-type: application/json');
								echo json_encode($postvalue);
								}

							/* disconnect from the db */
							@mysql_close($con);
?>