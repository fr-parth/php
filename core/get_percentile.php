<?php
 include("conn.php");
$id=$_SESSION['id'];
$percentile=$_GET['percentile'];


$query = mysql_query("select * from tbl_teacher where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];






if(($percentile>=30)&&($percentile<=50))
{

$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =2
AND range_id =1 AND school_id='$school_id'";

}

elseif(($percentile>=51)&&($percentile<=70))
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =2
AND range_id =2  AND school_id='$school_id'";


}


elseif(($percentile>=71) && ($percentile<=90))
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =2
AND range_id =3  AND school_id='$school_id'";


}



else 
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =2
AND range_id =4  AND school_id='$school_id'";


}




$result=mysql_query($sql);
 $row = mysql_fetch_array($result);
echo $points =$row['points'];die;
mysql_close($link);

?>


