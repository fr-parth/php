<?php
include('../conn.php');
session_start();
//print_r($_SESSION);
//include_once('groupadminheader.php');
//session_start();
$school_id=$_GET['school_id'];
$group_member_id=$_GET['group_member_id'];

$a="SELECT id FROM tbl_school_admin where school_id='$school_id'";
$b=mysql_query($a);
$a1=mysql_fetch_array($b);
$id1 = $a1['id'];

$_SESSION["id"] = $id1;
$_SESSION['usertype']='School Admin';
$_SESSION['school_id']=$school_id;
$_SESSION['entity']=1;
$_SESSION['school_type']='school';
$_SESSION['group_member_id']=$group_member_id;
$_SESSION['school_admin_id']=$id1;

$_SESSION['vals']='grp';
$_SESSION['check_login_from']='group';
//print_r($_SESSION);
header('location:../scadmin_dashboard.php');
// echo '<script>
//  window.location="../scadmin_dashboard.php"
//  </script>';

?>
