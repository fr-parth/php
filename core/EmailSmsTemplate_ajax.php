<?php
include('conn.php');
ob_end_clean();
$id = $_POST['id'];
mysql_set_charset('utf8');
$res = mysql_query("select subject,email_body,sms_body,email_marathi,sms_marathi from tbl_email_sms_templates where id='$id'");
$row= mysql_fetch_array($res);
$data = array('subject'=>$row['subject'],'email_body'=>$row['email_body'],'sms_body'=>$row['sms_body'],'email_marathi'=>$row['email_marathi'],'sms_marathi'=>$row['sms_marathi']);
echo json_encode($data);
?>