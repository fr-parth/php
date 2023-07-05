<?php
include("conn.php");
 echo $inst_id = $_GET['inst_id'];
 echo $state = $_GET['col'];
$sql = "DELETE FROM `Institution_directory` WHERE inst_id='$inst_id'";
mysql_query($sql);

header("Location: colleges.php?state=".$state) ;
?>