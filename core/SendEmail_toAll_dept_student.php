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
 if($_POST['dept_id']==""){$_POST['dept_id']="0";}
 if($_POST['school_id']==""){$_POST['school_id']="0";}
$p_lenght=strlen(trim(($phone)));
 $dept=$_POST['t_dept'];
 $School_id=$_POST['school_id'];
if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
                    $start=((int)$_POST['startlmt']-1);
                    $Limit= "LIMIT ".$start.",".$_POST['endlmt'];
                }
                else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
                    $Limit= "LIMIT ".$_POST['startlmt'];
                }
                else{$Limit= "";}
if($check == "Yes"){
	if($_POST['t_dept']!="0"){
        $query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND std_dept='$dept'  ORDER BY sa.id $Limit";
    }else if($_POST['school_id']!="0"){
        $query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id'  ORDER BY sa.id $Limit";
    }
    else{
    	$query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id'  ORDER BY sa.id $Limit";

    }
}
else{
	if($_POST['t_dept']!="0"){
        $query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND std_dept='$dept' AND sa.email_status = 'Unsend'  ORDER BY sa.id $Limit";
    }else if($_POST['school_id']!="0"){
    	$query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND sa.email_status = 'Unsend'  ORDER BY sa.id $Limit";
    }
    else{
    	$query2 = "SELECT sa.id,sa.std_PRN,sa.std_complete_name,sa.std_phone,sa.std_branch,sa.std_email,sa.batch_id, sa.send_unsend_status,sa.email_status,sa.school_id,sa.std_country,sa.sms_time_log,sa.email_time_log,sa.std_dept,sa.std_branch,sa.std_class,sa.std_password,sa.std_school_name,sa.std_name,sa.std_Father_name, sa.std_lastname FROM tbl_student sa join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.email_status = 'Unsend'  ORDER BY sa.id $Limit";
    }
}
//  echo $query2; //exit;	
$row2=mysql_query($query2);
$site = $_SERVER['HTTP_HOST'];
// $msgid='welcometeacherfromscadmin';
while($value2=mysql_fetch_array($row2))
{

$email=$value2['std_email'];

$e_lenght=strlen(trim(($email)));
$School_id=$value2['school_id'];
// $Email_status=$value2['status'];
$password=$value2['std_password'];
$status=$value2['email_status'];

$school_name=$value2['std_school_name'];
$s_name=explode(" ",$school_name);
		$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
$t_complete_name=$value2['std_complete_name'];
$t_name = $value2['std_name'];
$t_middlename = $value2['std_Father_name'];
$t_lastname = $value2['std_lastname'];

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
$std_phone = $value2['std_phone'];
$std_PRN = $value2['std_PRN'];
$member_id_std = $value2['id'];
if(empty($msgid))
{
	$msgid = "default";
}
// End
// echo "mailid".$e_lenght;

	if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{					 
						//Added studname in $myvars by Pranali for SMC-4977
						$url = SEND_MAIL_PATH;//defined in securityfunctions.php
						$myvars = 'email='.$email.'&msgid='.$msgid.'&Name='.$tname.'&pass='.$password.'&site='.$site.'&school_id='.$School_id.'&senderid='.$senderid.'&school_name='.urlencode($school_name).'&std_phone='.$std_phone.'&PRN='.$std_PRN.'&member_id='.$member_id_std.'&studname='.$tname;

						$res = post_function($url,$myvars); //function defined in securityfunctions.php
						// echo "res".$res;

						if(stripos($res,"Mail sent successfully"))
						{
							$success++;
							//echo "UPDATE `tbl_teacher` SET email_status='Email sent',email_time_log='$date' WHERE t_email='$email' AND school_id='$School_id'";die;
							$sql_update = "UPDATE `tbl_student` SET email_status='Send_Email',email_time_log='$date' WHERE std_email='$email' AND school_id='$School_id'";
							$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
						}
						else
						{
							$fail++;
							
						}
						//sleep(1);
}
else
{
 $invalide_email++;
}
}

 echo "$success emails sent successfully , $fail mails fails by sendmail library, $invalide_email fails because of wrong email address";	
?>