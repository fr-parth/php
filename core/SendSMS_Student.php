<?php
error_reporting(0);
include('conn.php');
require "twilio.php";

//changes done by Sachin for bug SMC-2185
$phone=$_POST['phone'];
$email= trim( $_POST['email']);
$p_lenght=strlen(trim(($phone)));
$School_id=$_POST['school_id'];
$Sms_status=$_POST['Status'];
$i = $_POST['i'];
$prn_id = $_POST['prn_id'];
$msgid = $_POST['msgid'];
if(empty($msgid))
{
	$msgid = "9";
}
$Country=strtoupper($_POST['country']);

$query2="select std_password,std_school_name,send_unsend_status from `tbl_student` where std_phone='$phone' and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data

$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$password=$value2['std_password'];
$status=$value2['send_unsend_status'];
$school_name=$value2['std_school_name'];
$s_name=explode(" ",$school_name);
$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];


$site = $_SERVER['HTTP_HOST'];
if ($site=='dev.smartcookie.in')
					{
						$teachershortside="https://goo.gl/MWbV2E";
					}
			else if($site=='test.smartcookie.in')
					{
						$teachershortside="https://goo.gl/CaEhf8";
					}
			else 
					{
						$teachershortside="https://goo.gl/HdVtLL";
					}	

//Below if condition changed by Pranali

			if($Country=='INDIA' || $Country=='india' || $Country=='India' )   
			{	
					$cc=91;
					if($p_lenght>0 && $p_lenght==10)
						{
							//echo $cc." ". $phone." ".$email." ".$password." ".$teachershortside." ".$site." ".$School_id." ".$msgid;
							$response = messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id,$msgid);
							if($response['responseStatus']==200)
							{
                            $date=(new \DateTime())->format('Y-m-d H:i:s');
							$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS',sms_time_log='$date',sms_response = '$response' WHERE  std_phone='$phone' AND school_id='$School_id'";
						    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());

							 $sql="SELECT * FROM  tbl_student  WHERE std_PRN='$prn_id' AND school_id='$School_id'";
						   
							$row1=mysql_query($sql);
							$row=mysql_fetch_array($row1);	
							$et= $row['email_time_log'];
							$st= $row['sms_time_log'];
							$std_PRN=$row['std_PRN'];
							$std_email=$row['std_email'];
							$std_department=$row['std_dept'];
							$std_class=$row['std_class'];
							$std_phone=$row['std_phone'];
							$send_unsend_status=$row['send_unsend_status'];
							$std_country=$row['std_country'];
							$email_status=$row['email_status'];
							$std_complete_name=$row['std_complete_name'];
							$std_branch=$row['std_branch'];
							$batch_id=$row['batch_id'];
							
							$rese .="<td data-title='Sr.No' style='width:4%;'><b>$i</b></td>";

                            $rese .="<td data-title='Student PRN' style='width:6%;'><b> $std_PRN </b></td>";
                            $rese .="<td data-title='Name/Phone No.' style='width:12%;'>$std_complete_name <br> $std_phone</td>";
                            $rese .="<td data-title='Email ID' style='width:8%;'> $std_email</td>";
                            $rese .="<td data-title='Department' style='width:8%;'>$std_department </td>";

                            $rese .="<td data-title='Batch ID' style='width:6%;'>$std_class </td>";
                            $rese .="<td data-title='SMS Status' style='width:5%;'>";
                                    if ($row['send_unsend_status'] == 'Unsend') 
                                    {
                                        $rese .="Unsent</td>";
                                    }
                                    else if($row['send_unsend_status'] == 'Send_SMS')
                                    {
                                        $rese .="SMS Sent</td>";
                                    }
                                  
                            $rese .="<td data-title='Email Status' style='width:5%;'>";

                                        if ($row['email_status'] == 'Send_Email') 
                                        {
                                            $rese .="Email sent</td>";
                                        } 
                                        else if($row['email_status'] == 'Unsend') {
                                            
                                            $rese .="Unsent</td>";
                                        }
                                   
                            $rese .="<td data-title='TimeStramp(SMS/Email)'>SMS :";
							$rese .="$st <br>";
							$rese .="Email :";
							$rese .="$et <br>Response:".$response['responseStatus']."</td>";

							$rese .="<td data-title='Send SMS/Email' style='width:10%;'>
                                     <img src='../Images/S.png'onclick=\"confirmSMS('$std_phone','$School_id','$email','$send_unsend_status','$std_country','$prn_id','$i');\">
                                     <img src='../Images/E.png' onclick=\"confirmEmail('$email_status','$School_id','$email','$std_phone','$std_complete_name','$prn_id','$i');\">
                                     
                                    </td>";


                            echo $rese ;
						
							}
							else
								{
								echo "<script type=text/javascript>alert('Sorry,Message Not sent.'); </script>";
								}
						}
						else
						{
						echo "<script type=text/javascript>alert('Sorry,Invalid Phone No.'); window.location='Send_Msg_Student.php'</script>";
						}
			}
			else if($Country=='US' || $Country=='USA')                // for USA
			{		
				
						$ApiVersion = "2010-04-01";

								// set our AccountSid and AuthToken
						$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
						$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
								// instantiate a new Twilio Rest Client
						$client = new TwilioRestClient($AccountSid, $AuthToken);
						$number="+1".$phone;
						$Text="Your college is now a member of a Student Teacher Reward platform that rewards you for  your accomplishments as a student and also enables you to thank your Teachers for all the motivation, mentoring etc. UserID: $phone and Password: $password College/School_id is $School_id $url2 "; 
								
				
						$res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
										"POST", array(
										"To" => $number,
										"From" => "732-798-7878",
										"Body" => $Text
									));

								//echo "<script type=text/javascript>alert('SMS has been sent Successfully on $number');window.location='Send_Msg_Student.php'</script>";
							
							
						$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS' WHERE std_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
						
						echo $sql="SELECT * FROM  tbl_student  WHERE std_phone='$phone' AND school_id='$School_id'";
							$row1=mysql_query($sql);
							$row=mysql_fetch_array($row1);	
							$et= $row['email_time_log'];
							$st= $row['sms_time_log'];
							$std_PRN=$row['std_PRN'];
							$std_email=$row['std_email'];
							$std_phone=$row['std_phone'];
							$send_unsend_status=$row['send_unsend_status'];
							$std_country=$row['std_country'];
							$email_status=$row['email_status'];
							$std_complete_name=$row['std_complete_name'];
							$std_branch=$row['std_dept'];
							$batch_id=$row['std_class'];
							
							$rese .="<td data-title='Sr.No' style='width:4%;''><b>$i</b></td>";

                            $rese .="<td data-title='student prn' style='width:6%;'><b> $std_PRN </b></td>";
                            $rese .="<td data-title='Name/Phone No.' style='width:12%;'>$std_complete_name <br> $std_phone</td>";
                            $rese .="<td data-title='Email ID' style='width:8%;'> $std_email</td>";
                            $rese .="<td data-title='Phone' style='width:8%;'>$std_branch </td>";

                            $rese .="<td data-title='Phone' style='width:6%;'>$batch_id </td>";
                            $rese .="<td data-title='Phone' style='width:5%;'>";
                                    if ($row['send_unsend_status'] == 'Unsend') 
                                    {
                                        $rese .="Unsent</td>";
                                    }
                                    else if($row['send_unsend_status'] == 'Send_SMS')
                                    {
                                        $rese .="SMS Sent</td>";
                                    }
                                  
                            $rese .="<td data-title='Phone' style='width:5%;'>";

                                        if ($row['email_status'] == 'Send_Email') 
                                        {
                                            $rese .="Email sent</td>";
                                        } 
                                        else if($row['email_status'] == 'Unsend') {
                                            
                                            $rese .="Unsent</td>";
                                        }
                                   
                            $rese .="<td>Email :";
							$rese .="$et <br>";
							$rese .="SMS :";
							$rese .="$st</td>";

							$rese .="<td data-title='Phone' style='width:10%;'>
                                     <img src='Images/E.png' onclick=\"confirmEmail('$email_status','$School_id','$email','$std_phone','$std_complete_name','$prn_id','$i');\">
                                     <img src='Images/S.png'onclick=\"confirmSMS('$std_phone','$School_id','$email','$send_unsend_status','$std_country','$prn_id','$i');\">
                                    </td>";

                            echo $rese ;
			//changes end
			}
			
		else
		{
			echo "<script type=text/javascript>alert('Sorry,Unable to send message without Country name'); window.location='Send_Msg_Student.php'</script>";
		}
function messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id,$msgid)
{
	
	// //$url2=" Android app ".$androidlink." ios app ".$ioslink."";
	// $url2="For App Download click here: https://".$site."/Download";
	// //$url1=" Please visit ".$teachershortside."";

	// $Text1="CONGRATULATIONS!, Get rewarded with the SmartCookie Rewards by your teachers for various good activities throughout the day and Thank your teachers for their help, support and good behavior by giving points to them on the SmartCookie Rewards Program instantly. Your Username is ".$phone." and Password is ".$password." College/School ID is ".$School_id." ".$url2." ".$url1."For more details contact us on  +917219193815"; 
	// $Text = urlencode($Text1);

	// Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020
	// $sql_dynamic= mysql_query("select * from tbl_otp where id=1");
	// $dynamic_fetch= mysql_fetch_array($sql_dynamic);
	// $dynamic_user = $dynamic_fetch['mobileno'];
	// $dynamic_pass = $dynamic_fetch['email'];
	// $dynamic_sender = $dynamic_fetch['otp'];//
	// //Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5173
	// $url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text&msgType=$msgType&pe_id=$pe_id&template_id=$template_id";
	// $response = file_get_contents($url);

$url=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_message";
 //echo $url;exit;
    $data=array(
      "operation"=>"send_message",
      "country_code"=>"+91",
      "phone_number"=>$phone,
      "password"=>$password,
      "email_id"=>$email,
      "school_id"=>$School_id,
      "school_name"=> $school_name,
      "entity_type"=>"student",
      "reason"=>"Registration",
      "delivery_method"=>"SMS",
       "msg"=>$msgid,
     // "msg"=>"welcomeschooladmin",
      "api_key"=>"cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s"

      
      );
  //print_r($data);exit;
        $ch = curl_init($url);          
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $result = json_decode(curl_exec($ch),true);
		return $result;
	}
?>
