<?php 
ob_start();
// include('conn.php');
 include('scadmin_header.php');
 $fields=array("id"=>$id);
 $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

 $d_id=$_GET['id'];

 $sql="DELETE FROM  `tbl_department_master` WHERE  `School_ID` =  '$sc_id' AND  `id` = '$d_id'";

 $test=mysql_query($sql);
 header('location:list_school_department.php');
 
?>