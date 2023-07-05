<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
//Save
if(xss_clean(mysql_real_escape_string($obj->{'id'})) != '')
{
	
	$id=xss_clean(mysql_real_escape_string($obj->{'id'}));
	$sql="DELETE FROM tbl_sponsored WHERE id='$id' ";
	$test1 = mysql_query($sql);
	if($test1 == 1)
	{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;
	}else{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;	
	}
	mysql_close($con);
}
else
{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
}
header('Content-type: application/json');
echo  json_encode($postvalue); 	
?>



