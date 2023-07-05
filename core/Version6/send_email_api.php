<?php

//include '../conn.php';
$conn=mysqli_connect("50.63.166.149", "techindi_Develop", "A*-fcV6gaFW0","techindi_Dev");
$json = file_get_contents('php://input');
$obj = json_decode($json);
//error_reporting(0);



  $school_id = $obj->school_id;
  $teacher_id = $obj->teacher_id;
  $teacher_name = $obj->teacher_name;
  $msg_type = $obj->msg_type;
  $Entity_and_email_id = $obj->Entity_email_id;
  //$name = xss_clean(mysql_real_escape_string($obj->{'Name'}));

   if($school_id == "")
   {
    $postvalue['responseStatus']=204;
    $postvalue['responseMessage']="Please Enter School ID";
	echo json_encode($postvalue);
	die;
   }

   if($msg_type == "")
   {
    $postvalue['responseStatus']=210;
    $postvalue['responseMessage']="Please Enter Message Type";
	echo json_encode($postvalue);
	die;
   }
   
   
   if($Entity_and_email_id == "")
   {
    $postvalue['responseStatus']=214;
    $postvalue['responseMessage']="Please Enter Entity IDs and Email ID";
	echo json_encode($postvalue);
	die;
   }
   
     $site = "dev.smartcookie.in";//$_SERVER['HTTP_HOST'];
	 $res1 = mysqli_query($conn,"select * from tbl_email_parameters where use_default='1'");
	 $newres = mysqli_fetch_array($res1);
	 $senderid = $newres['e_id'];
	 
	 $msgid_query = mysqli_query($conn,"select * from tbl_email_sms_templates where type='$msg_type'");
	 $msgid_para = mysqli_fetch_array($msgid_query);
	 $msg_id = $msgid_para['id'];
	 $msg_count = mysqli_num_rows($msgid_query);
	 if($msg_count == 0)
	 {
		 $postvalue['responseStatus']=218;
		 $postvalue['responseMessage']="No Meesage ID Found, Please Send Correct Message Type!";
		 echo json_encode($postvalue);
		 die;
	 }
	 
     $b = json_decode(json_encode($Entity_and_email_id),true);
	     foreach($b as $new)
		 {
		  foreach($new as $key=>$val)
		  {
			$res = file_get_contents("http://$site/core/clickmail/sendmail_new.php?email=$val&msgid=$msg_id&site=$site&senderid=$senderid");
			
		  }
         }
		 if (stripos($res, "Mail sent successfully"))
			{
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="Mail sent successfully";
				echo json_encode($postvalue);
			}
			else 
			{
				$postvalue['responseStatus']=216;
				$postvalue['responseMessage']="Mail error $res";
				echo json_encode($postvalue);
			}
   
  
  
?>