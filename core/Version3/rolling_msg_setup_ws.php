<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

$sponsor_id = xss_clean(mysql_real_escape_string($obj->{'sp_id'}));
$rolling_message= xss_clean(mysql_real_escape_string($obj->{'rolling_message'}));
$field_message= xss_clean(mysql_real_escape_string($obj->{'field_message'}));
//SMC-3452 Date Format Modified By Pranali 2018-09-25 03:15 PM
//$dates = date('Y/m/d');
$dates = CURRENT_TIMESTAMP;
//End SMC-3452
if( $sponsor_id!= ''&&  $rolling_message!= ''&& $field_message!= '' )
{

  
 $query="update `tbl_sponsorer` set rolling_message = '$rolling_message', field_message='$field_message' where id = $sponsor_id";
  $result=mysql_query($query);
 
							$posts = "Messages successfully  updated ";
							$postvalue['responseStatus']=200;
							$postvalue['responseMessage']="OK";
							$postvalue['posts']=$posts;
							header('Content-type: application/json');
							echo  json_encode($postvalue); 
	
	
}
else
{
							$postvalue['responseStatus']=1000;
							$postvalue['responseMessage']="Invalid Input";
							$postvalue['posts']=null;
							 header('Content-type: application/json');
							echo  json_encode($postvalue);
}
			  	
mysql_close($con);		
  ?>