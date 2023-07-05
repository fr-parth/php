<?php

$q=$_GET["q"];

include_once('conn.php');


$sql="SELECT * FROM tbl_sponsored WHERE id= '".$q."'";

$result = mysql_query($sql);

$row = mysql_fetch_array($result);

echo $name =$row['points_per_product'];die;

if($name == '' || empty($name))
{
echo "<b>ID not found.</b>";
}
else
{
echo "<b>".$name."</b>";
}

mysql_close($link);
?>