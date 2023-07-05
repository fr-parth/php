<?php

include('conn.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);
$posts  = array();
$address=$obj->{'address'};
if($address!=''){
$query = mysql_query("select * from tbl_sponsorer where sp_address like '%$address%' ");

$count = mysql_num_rows($query);
if($count > 0)
{
while($row = mysql_fetch_assoc($query))
{
    foreach($row as $k=>$v)
    {
        $row[$k]=htmlentities(preg_replace( "/\r|\n|\'/", "", $v ));
    }
   
 $posts[] = $row;
}
}
else
{
    $posts[] = 'no records';
}
$postvalue['responseStatus']=200;
$postvalue['responseMessage']="ok";
$postvalue['posts']=$posts;
header('Content-type: application/json');
echo json_encode($postvalue);
}
else {

  $postvalue['responseStatus']=1000;
  $postvalue['responseMessage']="Invalid Inputs";
  $postvalue['posts']=null;
  header('Content-type: application/json');
  echo json_encode($postvalue);		
}
?>