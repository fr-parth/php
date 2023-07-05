<?php
error_reporting(0);
include('conn.php');

//changes done by Pranali for bug SMC-2185
$email=$_POST['email'];
$e_lenght=strlen(trim(($email)));
$School_id=$_POST['school_id'];
$i = $_POST['i'];
$teacher_id = $_POST['teacher_id'];
$t_phone=$_POST['t_phone'];
$Email_status=$_POST['Status'];
$senderid = $_POST['senderid'];
if($e_lenght>0 && (filter_var($email, FILTER_VALIDATE_EMAIL)))
{
		$query2="select id,t_id,t_complete_name,t_password,t_name,t_middlename,t_lastname,school_id,email_status,t_current_school_name,t_phone from `tbl_teacher` where t_email='$email' and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
		//echo $query2;
		//exit();
		$row2=mysql_query($query2);
		$value2=mysql_fetch_array($row2);
		$password=$value2['t_password'];
		$t_complete_name=$value2['t_complete_name'];
		$t_name=$value2['t_name'];
		$t_middlename=$value2['t_middlename'];
		$t_lastname=$value2['t_lastname'];
		$status=$value2['email_status'];
		$school_id=$value2['school_id'];
		$school_name=$value2['t_current_school_name'];
		$t_id = $value2['t_id'];
		//$t_phone = $value2['t_phone'];
		$member_id = $value2['id'];
		
		if ($t_complete_name=="")
		{
			 $name=$t_name." ".$t_middlename." ".$t_lastname;
			  
			   $t_complete_name= $name;
		}
		else
		{
			   $t_complete_name;
		}

		$t_name=explode(" ",$t_complete_name);
		 $tname=$t_name[0];
		$s_name=explode(" ",$school_name);
		 
		$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];

		//changes done by Pranali

				$site = $GLOBALS['URLNAME'];

				// $msgid="welcometeacherfromscadmin";
				$msgid=$_POST['msgid'];
				$school_name=urlencode($school_name);

						// $res = file_get_contents("$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&teachername=$tname&school_id=$School_id&school_name=$school_name");

				$url = SEND_MAIL_PATH;//defined in securityfunctions.php
	//modified phone to t_phone in $myvars by Pranali for SMC-4977
						$myvars = 'email=' . $email . '&msgid=' . $msgid. '&site=' . $site. '&pass=' . $password. '&Name=' . $tname. '&school_id=' . $School_id. '&school_name=' . $school_name . '&senderid='.$senderid.'&techname='.$tname.'&teachername='.$t_complete_name.'&t_phone='.$t_phone.'&t_id='.$t_id.'&member_id='.$member_id;

						$res = post_function($url,$myvars); //function defined in securityfunctions.php

	//changes end	
						if(stripos($res,"Mail sent successfully"))
						{
							
                            $date=(new \DateTime())->format('Y-m-d H:i:s');
							$sql_update="UPDATE `tbl_teacher` SET email_status='Send_Email',email_time_log='$date' WHERE t_email='$email' AND school_id='$school_id'";
							$retval = mysql_query($sql_update) or die('Could not update data: '. mysql_error());
							
							$sql="SELECT * FROM  tbl_teacher t inner join tbl_school_admin sa ON t.school_id=sa.school_id WHERE t.t_id='$teacher_id' AND sa.school_id='$School_id'  ";

							$row1=mysql_query($sql);
							$row=mysql_fetch_array($row1);	
							$et= $row['email_time_log'];
							$st= $row['sms_time_log'];
							$school_name= $row['school_name'];
							$t_complete_name=$row['t_complete_name'];
							$t_phone=$row['t_phone'];
							$t_internal_email=$row['t_internal_email'];
							$send_unsend_status=$row['send_unsend_status'];
							$t_email=$row['t_email'];
							$t_dpt=$row['t_dept'];
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
							$rese .="<td data-title='Batch Id' style='width:6%;'>$school_name </td>";
                                 
							$rese .="<td data-title='Batch Id' style='width:6%;'>$t_dpt </td>";

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

                            $rese .="<td data-title='Phone' style='width:10%;'><img src='../Images/S.png' onclick=\"confirmSMS('$School_id','";        
                                        
                                         	if($row['t_email']=="")
                                            {
                                            $rese .="$t_internal_email";
                                            }
                                            else
                                            {
                                            $rese .="$t_email";
                                            }
                                            
                                $rese .="','$t_phone','$send_unsend_status','$t_country','$teacher_id','$i');\" >


                                        <img src='../Images/E.png' onclick=\"confirmEmail('$School_id','";
                                        
                                        if($row['t_email']=="")
                                            {
                                            $rese .="$t_internal_email";
                                            }
                                            else
                                            {
                                            $rese .="$t_email";
                                            } 

                                $rese .="','$t_phone','$email_status','$teacher_id','$i');\" >
                                        </td>";

							echo $rese ;
							//changes end
						}
						else
						{
							echo "<script type=text/javascript>alert('Email not sent on $email'); </script>";
						}
}
else
{
  echo "<script type=text/javascript>alert('Sorry,Invalid Email ID..'); </script>";
}
?>
