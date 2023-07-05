<?php
ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
ignore_user_abort(true);
set_time_limit(0);
error_reporting(0);
include('conn.php');
$group_member_id = $_SESSION['group_member_id'];
if($_POST['gp_id']!=''){ $group_member_id = $_POST['gp_id']; }
else if ($group_member_id!=''){
	$sqlgp="select group_member_id from tbl_group_school where school_id = '".$_POST['school_id']."' limit 1";
	$row=mysql_query($sqlgp);
	$gp=mysql_fetch_array($row);
	$group_member_id=$gp['group_member_id'];
}
$i=1;
$success=0;
$fail =0;
$flag = "No";
$invalide_email = 0;
$check = $_POST['check'];
 $date=date('Y-m-d H:i:s');
if($_POST['school_id']=="0"){ $_POST['school_id']="";} 
if($_POST['t_dept']=="0"){ $_POST['t_dept']="";} 
//$p_lenght=strlen(trim(($phone)));
$dept=$_POST['t_dept'];
$School_id=$_POST['school_id'];
if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
                   $start=((int)$_POST['startlmt']);
                    $Limit= "LIMIT ".$start.",".$_POST['endlmt'];
                }
                else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
                    $Limit= "LIMIT ".$_POST['startlmt'];
                }
                else{$Limit= "";}
$teacher_grp ="'133','134','135','137','139','141','143'";

if($check != "No"){
	if($_POST['t_dept']!=""){
         $query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND t.t_dept='$dept' AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct'  ORDER BY t.id $Limit";
    }else if($_POST['school_id']!=""){
         $query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id'  AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct'  ORDER BY t.id $Limit";
    }else{
     	 $query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.error_records LIKE 'Correct'  $Limit";
    }
}
else{
	if($_POST['t_dept']!=""){
        $query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND t.t_dept='$dept' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct'  ORDER BY t.id $Limit";
    }else if($_POST['school_id']!=""){
        $query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct'  ORDER BY t.id $Limit";
    }else{
    	$query2 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE gs.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ($teacher_grp) AND t.email_status = 'Unsend' AND t.error_records LIKE 'Correct'  $Limit";
    }
}
 // echo $query2; exit;

$row2=mysql_query($query2);
$site = $_SERVER['HTTP_HOST'];
// $msgid='welcometeacherfromscadmin';
while($value2=mysql_fetch_array($row2))
{
$email=$value2['t_email'];

$e_lenght=strlen(trim(($email)));
$School_id=$value2['school_id'];
$Email_status=$value2['status'];
$password=$value2['t_password'];
$status=$value2['email_status'];

$school_name=$value2['t_current_school_name'];
$s_name=explode(" ",$school_name);
		$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
$t_complete_name=$value2['t_complete_name'];
$t_phone=$value2['t_phone'];
$t_id=$value2['t_id'];
$mem_id=$value2['id'];

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
				
	// for sendmail_new.php
	// $email = $_POST['email'];
// $ccmail = $_POST['ccmail'];
$Name = $_POST['Name'];
$msgid = $_POST['msgid'];
$senderid = $_POST['email'];
if(empty($msgid))
{
	$msgid = "default";
}
// End

	if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{					 
						
						// $res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&school_name=".urlencode($school_name)."");

		//Added phone , t_id and member_id to solve issue of phone number, employee id and member_id showing blank values in email by Pranali for SMC-4977 on 17-2-21
						$url = SEND_MAIL_PATH;//defined in securityfunctions.php
		//modified phone to t_phone in $myvars by Pranali for SMC-4977
						$myvars = 'email='.$email.'&msgid='.$msgid.'&Name='.$tname.'&pass='.$password.'&site='.$site.'&school_id='.$School_id.'&senderid='.$senderid.'&school_name='.urlencode($school_name).'&t_phone='.$t_phone.'&t_id='.$t_id.'&member_id='.$mem_id;

						$res = post_function($url,$myvars); //function defined in securityfunctions.php

						if(stripos($res,"Mail sent successfully"))
						{
							$success++;
							//echo "UPDATE `tbl_teacher` SET email_status='Email sent',email_time_log='$date' WHERE t_email='$email' AND school_id='$School_id'";die;
							$sql_update="UPDATE `tbl_teacher` SET email_status='Send_Email',email_time_log='$date' WHERE t_email='$email' AND school_id='$School_id'";
							$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
						}
						else
						{
							$fail++;
							
						}
						// sleep(1);
}
else
{
 $invalide_email++;
}
}
 echo "$success emails sent successfully , $fail mails fails by sendmail library, $invalide_email fails because of wrong email address";	
?>