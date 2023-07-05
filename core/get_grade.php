<?php

include("conn.php");
$id=$_SESSION['id'];
$grade=$_GET['grade'];


$query = mysql_query("select * from tbl_teacher where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];





if($grade=="A")
{

$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =3
AND range_id =1 AND school_id='$school_id'";

}

elseif($grade=="B")
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =3
AND range_id =2  AND school_id='$school_id'";


}


elseif($grade=="C")
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =3
AND range_id =3  AND school_id='$school_id'";


}



else 
{
$sql="SELECT DISTINCT m.points
FROM tbl_master m
JOIN tbl_method t
WHERE method_id =3
AND range_id =4  AND school_id='$school_id'";


}




$result=mysql_query($sql);
 $row = mysql_fetch_array($result);
echo $points =$row['points'];die;
mysql_close($link);

?>


