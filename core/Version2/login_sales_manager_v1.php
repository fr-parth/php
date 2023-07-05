<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

$email_id = $obj->{'email'};
$password = $obj->{'password'};

if($email_id!='' and $password!='')
{

	$query = mysql_query("select * from tbl_cookie_adminstaff where designation='sales Manager' and email='$email_id' and pass='$password'");
	$count = mysql_num_rows($query);
	if($count==1)
	{
			$query_result = mysql_fetch_assoc($query);
			$nik = $query_result['id'];
			$postvalue['responseStatus']="200";
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$query_result;
			header('Content-type:application/json');
			echo json_encode($postvalue);
	}
	else if($count>1)
	{
			$postvalue['responseStatus']="409";
			$postvalue['responseMessage']="conflict";
			$postvalue['posts']=null;
			header('Content-type:application/json');
			echo json_encode($postvalue);
	}
	else
	{
			$postvalue['responseStatus']="204";
			$postvalue['responseMessage']="no responce";
			$postvalue['posts']=null;
			header('Content-type:application/json');
			echo json_encode($postvalue);

	}
}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="invalide inputs";
	$postvalue['posts']=null;
	header('Content-type:application/json');
	echo json_encode($postvalue);
}

@mysql_close($conn);


24425135


?>
