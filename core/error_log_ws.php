<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
$datetime = date("Y-m-d H:i:s");
$error_type=xss_clean(mysql_real_escape_string($obj->{'error_type'}));
$error_description=xss_clean(mysql_real_escape_string($obj->{'error_description'}));
$data=xss_clean(mysql_real_escape_string($obj->{'data'}));
$user_type=xss_clean(mysql_real_escape_string($obj->{'user_type'}));
$member_id=xss_clean(mysql_real_escape_string($obj->{'member_id'}));
$name=xss_clean(mysql_real_escape_string($obj->{'name'}));
$phone=xss_clean(mysql_real_escape_string($obj->{'phone'}));
$email=xss_clean(mysql_real_escape_string($obj->{'email'}));
$app_name=xss_clean(mysql_real_escape_string($obj->{'app_name'}));

$subroutine_name=xss_clean(mysql_real_escape_string($obj->{'subroutine_name'}));
$line=xss_clean(mysql_real_escape_string($obj->{'line'}));
$status=xss_clean(mysql_real_escape_string($obj->{'status'}));
$lst_prog_name=xss_clean(mysql_real_escape_string($obj->{'last_prog_name'}));
$web_name=xss_clean(mysql_real_escape_string($obj->{'webservice_name'}));
$web_met_name=xss_clean(mysql_real_escape_string($obj->{'webmethod_name'}));
$prog_err_msg=xss_clean(mysql_real_escape_string($obj->{'prog_err_msg'}));
$school_ID=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

$device_name=xss_clean(mysql_real_escape_string($obj->{'device_name'}));
$device_OS_version=xss_clean(mysql_real_escape_string($obj->{'device_OS_version'}));
$ip_address=xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$source=xss_clean(mysql_real_escape_string($obj->{'source'}));




if($error_description != "" and $data !="" and $app_name !=""){

	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('$error_type', '$error_description', '$data', '$datetime', '$user_type', '$member_id', '$name', '$phone', '$email','$app_name', '$subroutine_name', '$line', '$status','$lst_prog_name','$web_name','$web_met_name','$prog_err_msg','$school_ID','$device_name','$device_OS_version','$ip_address','$source')")or die(mysql_error());
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