<?php 
ob_start();
 include('../conn.php');
 //include('groupadminheader.php');
 $fields=array("id"=>$id);
//  $smartcookie=new smartcookie();

// $results=$smartcookie->retrive_individual($table,$fields);
// $result=mysql_fetch_array($results);
$group_member_id= $_SESSION['id'];

 $d_id=$_GET['id'];

 $sql="DELETE FROM  `tbl_department_master` WHERE  `group_member_ID` =  '$group_member_id' AND  `id` = '$d_id'";

 $test=mysql_query($sql);
 header('location:list_group_department.php');
 
 
?>