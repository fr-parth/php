<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);


$sender_member_id = $obj->{'sender_member_id'};
$sender_entity_id = $obj->{'sender_entity_id'};
$receiver_entity_id = $obj->{'receiver_entity_id'};
$receiver_country_code = $obj->{'receiver_country_code'};
$receiver_mobile_number = $obj->{'receiver_mobile_number'};
$receiver_email_id = $obj->{'receiver_email_id'};
$firstname = $obj->	{'firstname'};
$middlename = $obj->{'middlename'};
$lastname = $obj->{'lastname'};
$platform_source = $obj->{'platform_source'};
$request_status = $obj->{'request_status'};

if((($receiver_country_code!='' && $receiver_mobile_number!='') || $receiver_email_id!='') && $sender_member_id!='' && $sender_entity_id !='' && $receiver_entity_id!='' && $firstname!='' && $middlename!='' && $lastname!='' && $platform_source!='' && $request_status!='')
{
	$check_request_query = mysql_query("select referral_tracking_id from referral_activity_log where receiver_mobile_number='$receiver_mobile_number' or receiver_email_id='$receiver_email_id'");
	if(mysql_num_rows($check_request_query) >= 1)
	{
			$server_name = $_SERVER['SERVER_NAME'];
			$acceptance_flag = 'N';
			$invitation_sent_datestamp = date("Y-m-d h:i:s");
			$password = $firstname.'123';
			$sender_type = $sender_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');
			$receiver_type = $receiver_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');
			
			$data = array('firstname'=>$firstname,
						'middlename'=>$middlename,
						'lastname'=>$lastname,
						'password'=>$password,
						'phonenumber'=>$receiver_mobile_number,
						'emailid'=>$receiver_email_id,
						'countrycode'=>$receiver_country_code,
						'platform_source'=>$platform_source,
						'type'=>$receiver_type
					);
									
			$ch = curl_init("http://$server_name/core/Version2/quickregistration_ws_v1.php"); 	
			$data_string = json_encode($data);    
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
			$result = json_decode(curl_exec($ch),true);
			$responce_from_quick_registration = $result["responseStatus"];
			
			if($responce_from_quick_registration == 200)
			{
				$receiver_member_id = $result['posts']['0']['id'];

				$data = array('request_status'=>$request_status,
						'sender_entity_id'=>$sender_entity_id,
						'receiver_entity_id'=>$receiver_entity_id,
						'sender_member_id'=>$sender_member_id,
						'receiver_member_id'=>$receiver_member_id,
						'receiver_employee_id'=>$receiver_member_id,
					);
									
					$ch = curl_init("http://$server_name/core/Version2/assign_promotion_points.php"); 	
					$data_string = json_encode($data);    
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
					$result = json_decode(curl_exec($ch),true);
					$assign_promotion_points = $result["responseStatus"];
					
					if($assign_promotion_points == 200)
					{
						$referral_activity_log_query = mysql_query("insert into referral_activity_log (sender_member_id,sender_user_type,receiver_country_code,receiver_mobile_number,receiver_email_id,invitation_sent_datestamp,acceptance_flag,receiver_member_id,method,receiver_user_type) values ('$sender_member_id','$sender_type','$receiver_country_code','$receiver_mobile_number','$receiver_email_id','$invitation_sent_datestamp','$acceptance_flag','$receiver_member_id','$platform_source','$receiver_type')");
						
						$postvalue['responseStatus']  = 200;
						$postvalue['responseMessage'] = "ok";
						$postvalue['posts'] = null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
					}
					else
					{
						$postvalue['responseStatus']  = 1000;
						$postvalue['responseMessage'] = "invalid input";
						$postvalue['posts'] = null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
					}
					
			}
			else if($responce_from_quick_registration == 204)
			{
						$postvalue['responseStatus'] = 204;
						$postvalue['responseMessage'] = "No Response";
						$postvalue['posts'] = null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
			}
			else if($responce_from_quick_registration == 409)
			{
						$postvalue['responseStatus'] = 409;
						$postvalue['responseMessage'] = "user already exists";
						$postvalue['posts'] = null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
			}
	}
	else
	{
						$postvalue['responseStatus'] = 208;
						$postvalue['responseMessage'] = "user already requested";
						$postvalue['posts'] = null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
	}

	
}
else
{
				$postvalue['responseStatus'] = 1000;
				$postvalue['responseMessage'] = "user already exists";
				$postvalue['posts'] = null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
}

//$receiver_member_id = $obj->{'receiver_member_id'};
//$accepted_date = $obj->{'accepted_date'};



//$sender_user_type = $obj->{'sender_user_type'};
//$receiver_user_type = $obj->{'sender_user_type'};


?>