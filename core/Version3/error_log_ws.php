<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

// START SMC-3487 Pravin 2018-09-27 3:30 PM
$error_type = xss_clean(mysql_real_escape_string($obj->{'error_type'}));
$error_description = xss_clean(mysql_real_escape_string($obj->{'error_description'}));
$data = xss_clean(mysql_real_escape_string($obj->{'data'}));
$datetime = date("Y-m-d H:i:s");
$user_type = xss_clean(mysql_real_escape_string($obj->{'user_type'}));
$member_id = xss_clean(mysql_real_escape_string($obj->{'member_id'}));
$name = xss_clean(mysql_real_escape_string($obj->{'name'}));
$phone = xss_clean(mysql_real_escape_string($obj->{'phone'}));
$email = xss_clean(mysql_real_escape_string($obj->{'email'}));
$app_name = xss_clean(mysql_real_escape_string($obj->{'app_name'}));
$subroutine_name = xss_clean(mysql_real_escape_string($obj->{'subroutine_name'}));
$line = xss_clean(mysql_real_escape_string($obj->{'line'}));
$status = xss_clean(mysql_real_escape_string($obj->{'status'}));
$device_name=xss_clean(mysql_real_escape_string($obj->{'device_name'}));
$device_OS_version=xss_clean(mysql_real_escape_string($obj->{'device_OS_version'}));
$ip_address=xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$source=xss_clean(mysql_real_escape_string($obj->{'source'}));
$last_programmer_name=xss_clean(mysql_real_escape_string($obj->{'last_programmer_name'}));

if($error_description != ""){
//Below query updated by Rutuja for SMC-4915 for adding last_programmer_name on 21-10-2020
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`device_name`,`device_OS_version`,`ip_address`,`source`,'last_programmer_name') values('$error_type', '$error_description', '$data','$datetime', '$user_type', '$member_id', '$name', '$phone', '$email','$app_name', '$subroutine_name', '$line', '$status','$device_name','$device_OS_version','$ip_address','$source','$last_programmer_name')")or die(mysql_error());

	
	$i=mysql_insert_id();
	$posts = array();
	if($i){
		$posts['error_id']=$i;
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
	}else{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}
}else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}				  
header('Content-type: application/json');
echo  json_encode($postvalue); 

?>