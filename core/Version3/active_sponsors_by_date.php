<?php

include('conn.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);
$posts = array();

$date=$obj->{'date'};
if($date==''){
  $date =  date('m/d/Y');
}

$query = mysql_query("select EntityID,LatestLoginTime from tbl_LoginStatus where LatestLoginTime like '$date%' and Entity_type='108' order by LatestLoginTime desc");

$count = mysql_num_rows($query);
if($count>0)
{
while($row = mysql_fetch_assoc($query))
{

  $member_id = $row['EntityID'];
  $sponsor_query =  mysql_query("select sp_name,sp_company,sp_email,sp_phone,sp_address from tbl_sponsorer where id='$member_id'");
  $sponsor_query_result = mysql_fetch_assoc($sponsor_query);
  $sponsor_query_result[LatestLoginTime] = $row['LatestLoginTime'];
  $posts[] = $sponsor_query_result;
}


$postvalue['responseStatus']=200;
$postvalue['responseMessage']="ok";
$postvalue['posts']=$posts;
header('Content-type: application/json');
echo json_encode($postvalue);
}
else {
  $postvalue['responseStatus']=204;
  $postvalue['responseMessage']="No Responce";
  $postvalue['posts']=null;
  header('Content-type: application/json');
  echo json_encode($postvalue);
}

?>
