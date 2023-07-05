<?php
error_reporting(0);
include('conn.php');
//changes done by Sachin for bug SMC-2185
$email= trim( $_POST['email']);
$phone=$_POST['phone'];
$e_lenght=strlen(trim(($email)));
$School_id=$_POST['school_id'];
$Email_status=$_POST['Status'];
$name = $_POST['name'];
$i = $_POST['i'];
$prn_id = $_POST['prn_id'];
$senderid = $_POST['senderid'];
$member_id_std = $_POST['member_id'];
$coordinator2 = $_POST['coordinator2'];

$coordinator_name = mysql_query("select t_complete_name from tbl_teacher where t_id='$coordinator2'and school_id='$School_id'");
$coordinator_name1=mysql_fetch_array($coordinator_name);
$coordinatorname3=$coordinator_name1['t_complete_name'];
if($coordinatorname3!='')
{
	$coordinatorname2=$coordinatorname3;
}
else
{
	$admin = mysql_query("select name from tbl_school_admin where school_id='$School_id'");
    $admin1=mysql_fetch_array($admin);
    $coordinatorname2=$admin1['name'];

}

// $logo1 = mysql_query("select img_path from tbl_school_admin where school_id='$School_id'");
// $logo2=mysql_fetch_array($logo1);
// $logo3=$logo2['img_path'];


if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$query2="select id, std_PRN,std_name,std_complete_name, std_lastname,school_id, std_Father_name, std_email, std_phone, std_password, std_school_name, email_status from `tbl_student` where (std_email='$email' or Email_Internal='$email') and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
	// echo $query2;
	$row2=mysql_query($query2);
	$value2=mysql_fetch_array($row2);
	$password=$value2['std_password'];
	$status=$value2['send_unsend_status'];
	$school_name=$value2['std_school_name'];
	$email_status=$value2['email_status'];
	$std_name=$value2['std_name'];
	$std_Father_name=$value2['std_Father_name'];
	$std_lastname=$value2['std_lastname'];
	$std_complete_name=$value2['std_complete_name'];
	$school_id=$value2['school_id'];
	$s_phone=$value2['std_phone'];
	$member_id = $value2['id'];
	if ($std_complete_name=="")
		{
			 $name=$std_name." ".$std_Father_name." ".$std_lastname;
			  
			   $std_complete_name= urlencode($name);
		}
		else
		{
			  $std_complete_name = urlencode($std_complete_name);
		}

		$s_name=explode(" ",$std_complete_name);
		 $stdname=$s_name[0];
	
	$s_name=explode(" ",$school_name);
    $sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
	
	//changes done by Pranali
		$site = $GLOBALS['URLNAME'];
		$school_name=urlencode($school_name);
		$msgid=$_POST['msgid'];
	//changed variable of phone parameter to $phone and added = after member_id parameter by Pranali to solve issue of Student Phone Number and Member ID Not Received in Email SMC-4977 on 17-2-21
						$url = SEND_MAIL_PATH; //defined in securityfunctions.php
						//modified phone to std_phone in below line by Pranali for SMC-4977
						 $myvars = 'email=' . $email . '&msgid=' . $msgid. '&site=' . $site. '&pass=' . $password. '&Name=' . $tname. '&school_id=' . $School_id. '&school_name=' . $school_name . '&senderid='.$senderid.'&studname='.$stdname.'&studentname='.$std_complete_name.'&std_phone='.$phone.'&PRN='.$prn_id.'&member_id='.$member_id_std.'&coordinator_name='.$coordinatorname2.'&logo='.$logo3; 

						 $res = post_function($url,$myvars); //function defined in securityfunctions.php

	//changes end	
						if(stripos($res,"Mail sent successfully"))
						{
							//echo "<script type=text/javascript>alert('Email has been sent Successfully on $email'); window.location='Send_Msg_Student.php'</script>";
                            $date=(new \DateTime())->format('Y-m-d H:i:s');
							echo $sql_update="UPDATE `tbl_student` SET email_status='Send_Email',email_time_log='$date' WHERE (std_email='$email' or Email_Internal='$email') AND school_id='$School_id'";
							$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());

							$sql="SELECT * FROM  tbl_student WHERE std_PRN='$prn_id' AND school_id='$School_id'";
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
							$std_department=$row['std_dept'];
							$batch_id=$row['std_class'];
							
							$rese .="<td data-title='Sr.No' style='width:4%;'><b>$i</b></td>";

                            $rese .="<td data-title='Teacher ID' style='width:6%;'><b> $std_PRN </b></td>";
                            $rese .="<td data-title='Name' style='width:12%;'>$std_complete_name <br>Phone $std_phone</td>";
                            $rese .="<td data-title='Phone' style='width:8%;'> $std_email</td>";
                            $rese .="<td data-title='Phone' style='width:8%;'>$std_department </td>";

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
                            $rese .="<td>SMS :";
							$rese .="$st <br>";
							$rese .="Email :";
							$rese .="$et</td>";

							$rese .="<td data-title='Phone' style='width:10%;'>

									<img src='../Images/S.png'onclick=\"confirmSMS('$std_phone','$School_id','$email','$send_unsend_status','$std_country','$prn_id','$i');\">
                                     <img src='../Images/E.png' onclick=\"confirmEmail('$email_status','$School_id','$email','$std_phone','$std_complete_name','$prn_id','$i');\">
                                     
                                    </td>";

                            echo $rese ; 
							//changes end
						}
						else
						{
							echo "<script type=text/javascript>alert('Email not sent  on $email');</script>";
						}
	
}
else
{
	echo "<script type=text/javascript>alert('Sorry, Invalid Email ID');</script>";
}
               
?>


