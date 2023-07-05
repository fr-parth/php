<?php
error_reporting(0);
//include("scadmin_header.php");
include('conn.php');
require "twilio.php";

//changes done by Sachin for bug SMC-2185
$i = $_POST['i'];
$teacher_id = $_POST['teacher_id'];
$phone=$_POST['t_phone'];

$p_lenght=strlen(trim(($phone)));
$School_id=$_POST['school_id'];
$Sms_status=$_POST['Status'];
$Country=strtoupper($_POST['country']);
$email = $_POST['email'];
$msgid = $_POST['msgid'];
if(empty($msgid))
{
	$msgid = "8";
}
$pass = $_POST['pass'];


$query2="select t_name,t_lastname,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where t_phone='$phone' and school_id='$School_id'";
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$tname=$value2['t_name'].' '.$value2['t_lastname'];
$password=$value2['t_password'];
$status=$value2['send_unsend_status'];
$school_name=$value2['t_current_school_name'];
$s_name=explode(" ",$school_name);
$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
$site = $_SERVER['HTTP_HOST'];

$res_sms = mysql_query("select subject,email_body,sms_body,template_id_sms from tbl_email_sms_templates where id ='$msgid'");
$row_sms= mysql_fetch_array($res_sms);

//assign variables and send email
$sms_body = $row_sms['sms_body'];
$template_id = $row_sms['template_id_sms'];
// print_r($sms_body); exit;
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
					if(($p_lenght>0) && $p_lenght==10)
						{

							$response = messageUser($cc,$site,$phone,$email,$password,$teachershortside,$School_id,$sc_name,$sms_body,$tname,$msgid);
							// print_r($response);
							// echo $cc.'-'.$site.'-'.$phone.'-'.$email.'-'.$password.'-'.$teachershortside.'-'.$School_id.'-'.$sc_name.'-'.$tname.'-'.$msgid;
							if($response['responseStatus']==200)
							{
                            $date=(new \DateTime())->format('Y-m-d H:i:s');
							$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS',sms_time_log='$date',sms_response = '$response' WHERE t_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
						
							$sql="SELECT t.*,sc.school_name as sc_name FROM  tbl_teacher t LEFT JOIN tbl_school_admin sc ON t.school_id=sc.school_id WHERE t.t_id='$teacher_id' AND t.school_id='$School_id'";
							// print_r($sql); exit;
							$row1=mysql_query($sql);
							$row=mysql_fetch_array($row1);	
							$et= $row['email_time_log'];
							$st= $row['sms_time_log'];
							$t_complete_name=$row['t_complete_name'];
							$t_phone=$row['t_phone'];
							$t_internal_email=$row['t_internal_email'];
							$sc_name=$row['sc_name'];
							$send_unsend_status=$row['send_unsend_status'];
							$t_email=$row['t_email'];
							$batch_id=$row['batch_id'];
							$t_country=$row['t_country'];
							$email_status=$row['email_status'];

							$rese .="<td data-title='Sr.No' style='width:4%;'><b>$i</b></td>";
							$rese .="<td data-title='Teacher ID' style='width:6%;'><b> $teacher_id</b></td>";
                            $rese .="<td data-title='First Name' style='width:12%;'>$t_complete_name($t_phone)</td>";            
                            $rese .="<td data-title='Email' style='width:10%;'>";
										if($row['t_email']=="")
										{
										$rese .="$t_internal_email</td>";
										}
										else
										{
										$rese .="$t_email</td>";	
										} 
                            
                            if(!$_SESSION['school_id']){
                            $rese .="<td data-title='School Name' style='width:15%;'>$sc_name </td>";
                        	}

							$rese .="<td data-title='Batch Id' style='width:6%;'>$batch_id </td>";

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
                            $rese .="<td >SMS :$st <br>Email :$et </td>";
                            if(!$_SESSION['school_id']){
                             $rese .="<td data-title='Phone' style='width:10%;'>
                            		
                            		<img src='../Images/S.png' onclick=\"confirmSMS('$School_id','$email','$t_phone','$send_unsend_status','$t_country','$teacher_id','$i');\" >

                                    <img src='../Images/E.png' onclick=\"confirmEmail('$School_id','$email','$t_phone','$email_status','$teacher_id','$i');\" >
                                        </td>";
                            }else{
                            	$rese .="<td data-title='Phone' style='width:10%;'>
                            		
                            		<img src='../Images/S.png' onclick=\"confirmSMS('$School_id','$email','$t_phone','$send_unsend_status','$t_country','$teacher_id','$i');\" >

                                    <img src='../Images/E.png' onclick=\"confirmEmail('$School_id','$email','$t_phone','$email_status','$teacher_id','$i');\" >
                                        </td>";
                            }

							echo $rese ;
						
							}
							else
								{
								echo "<script type=text/javascript>alert('Sorry,Message Not sent.'); </script>";
								}
						}
						else
						{
						echo "<script type=text/javascript>alert('Sorry,Invalid Phone No.'); </script>";
						}
			}
			elseif($Country=='US' || $Country=='USA')                // for USA
			{
						$ApiVersion = "2010-04-01";
								// set our AccountSid and AuthToken
						$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
						$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
								// instantiate a new Twilio Rest Client
						$client = new TwilioRestClient($AccountSid, $AuthToken);
						$number="+1".$phone;
						//$Text="Welcome in Smartcookie as Teacher UserID: $phone and Password: $password android app $androidlink iOS app $ioslink";
						$Text="Your college is now a member of a Student-Teacher Reward platform (SMART COOKIE) that rewards you for your accomplishments as a teacher/mentor. It also enables you to reward your Students for their good deeds in Studies & Extracurricular activities.  UserID: $phone and Password: $password College/School_id is $School_id $url2 ";
						$res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
										"POST", array(
										"To" => $number,
										"From" => "732-798-7878",
										"Body" => $Text
									));
								echo "<script type=text/javascript>alert('SMS has been sent Successfully on $number'); </script>";
                        $date=(new \DateTime())->format('Y-m-d H:i:s');
						$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS',sms_time_log='$date' WHERE t_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());

						$sql="SELECT * FROM  tbl_teacher WHERE t_id='$teacher_id' AND school_id='$School_id'";

							$row1=mysql_query($sql);
							$row=mysql_fetch_array($row1);	
							$et= $row['email_time_log'];
							$st= $row['sms_time_log'];
							$t_complete_name=$row['t_complete_name'];
							$t_phone=$row['t_phone'];
							$t_internal_email=$row['t_internal_email'];
							$send_unsend_status=$row['send_unsend_status'];
							$t_email=$row['t_email'];
							$batch_id=$row['batch_id'];
							$t_country=$row['t_country'];
							$email_status=$row['email_status'];

							
							$rese .="<td data-title='Sr.No' style='width:4%;'><b>$i</b></td>";
							$rese .="<td data-title='Teacher ID' style='width:6%;'><b> $teacher_id</b></td>";
                            $rese .="<td data-title='First Name' style='width:12%;'>$t_complete_name($t_phone)</td>";            
                            $rese .="<td data-title='Email' style='width:10%;'>";
										if($row['t_email']=="")
										{
										$rese .="$t_internal_email</td>";
										}
										else
										{
										$rese .="$t_email</td>";
											
										} 
                                 
							$rese .="<td data-title='Batch Id' style='width:6%;'>$batch_id </td>";

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
                            $rese .="<td >SMS :$st <br>Email :$et</td>";

                            $rese .="<td data-title='Phone' style='width:10%;'>
                            		
                            		<img src='Images/S.png' onclick=\"confirmSMS('$School_id','$email','$t_phone','$send_unsend_status','$t_country','$teacher_id','$i');\" >

                                    <img src='Images/E.png' onclick=\"confirmEmail('$School_id','$email','$t_phone','$email_status','$teacher_id','$i');\" >
                                        </td>";


							echo $rese ;
							//changes end
			}
			else
			{
				echo "<script type=text/javascript>alert('Sorry,Unable to send message without Country name'); </script>";
			}
function messageUser($cc,$site,$phone,$email,$password,$teachershortside,$School_id,$sc_name,$sms,$tname,$msgid)
	{
		
	//  $url2="For download app: https://".$site."/Download";
	//  $url1="For preferred sponsors: https://".$site."/preferredsponsors"; //"Please visit ".$teachershortside."";
			
	//   // $Text1="Welcome!,You are registered as a teacher in Smart Cookie - A Student/Teacher Rewards Program. Your Username is ".$phone." and Password is ".$password." College/School_id is ".$School_id." ".$url2." ".$url1; 
	//  $Text1=$sms;
	//   // echo $Text1; exit; 
	// $Text1 = str_replace("{name}",$tname,$Text1);
	// $Text1 = str_replace("{t_name}",$tname,$Text1);
	// $Text1 = str_replace("{t_email}",$email,$Text1);
	// $Text1 = str_replace("{email}",$email,$Text1);
	// $Text1 = str_replace("{t_password}",$password,$Text1);
	// $Text1 = str_replace("{pass}",$password,$Text1);
	// $Text1 = str_replace("{t_phone}",$phone,$Text1);
	// $Text1 = str_replace("{site}",$site,$Text1);
	// $Text1 = str_replace("{school_id}",$School_id,$Text1);
	// $Text1 = str_replace("{school_name}",$sc_name,$Text1);
	// $Text1 = str_replace("{appurl}",$teachershortside,$Text1);
 // $Text = urlencode($Text1);
	
	// $url="http://www.smswave.in/panel/sendsms2021.php?user=blueplan&password=123123&sender=SCRMSG&pe_id=1701159109114765936&msgType=PT&template_id=$template_id&PhoneNumber=$phone&Text=$Text";
	// //echo $url; exit;
	// 	$response = file_get_contents($url);

	// $sql_dynamic= mysql_query("select school_name from tbl_school_admin where school_id=$school_id");
	// $dynamic_fetch= mysql_fetch_array($sql_dynamic);
	// $school_name = $dynamic_fetch['school_name'];

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