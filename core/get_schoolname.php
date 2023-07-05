<?php
//input as school id
$school_id=$_GET["school_id"];

include_once('conn.php');

//retrive school_name of school_id
$sql="SELECT school_name FROM tbl_school WHERE id= $school_id";

$result = mysql_query($sql);

$row = mysql_fetch_array($result);

echo $name =$row['school_name'];




?>