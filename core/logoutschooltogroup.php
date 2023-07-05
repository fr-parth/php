<?php
//include('./conn.php');
 //session_start();

//print_r($_SESSION);exit;
//include_once("./group_admin/groupadminheader.php");
// $group_admin_id=$_GET['group_member_id'];
 //$entity=12;
// //$admin_password='admin_password';
// $a="SELECT admin_password,group_mnemonic_name,group_name,admin_name,admin_email,current_ay,current_sem_type,balance_green_point,balance_blue_point,balance_water_point FROM tbl_cookieadmin where id='$group_admin_id'";
// $b=mysql_query($a);
// $a1=mysql_fetch_array($b);
// $id1 = $a1['admin_password'];
// $id2 = $a1['group_mnemonic_name'];
// $id3 = $a1['group_name'];
// $id4 = $a1['admin_name'];
// $id5 = $a1['admin_email'];

// $id6 = $a1['current_ay'];
// $id7 = $a1['current_sem_type'];
// $id8 = $a1['balance_green_point'];
// $id9 = $a1['balance_blue_point'];
// $id10 = $a1['balance_water_point'];

// $_SESSION["group_admin_id"] = $group_admin_id;
// $_SESSION['entity']=$entity;
// $_SESSION['admin_password']=$id1;
// $_SESSION['group_mnemonic_name']=$id2;
// $_SESSION['id']=$group_admin_id;
// $_SESSION['admin_name']=$id4;
//  $_SESSION['admin_email']=$id5;
//  //$_SESSION['group_type']='School';
//  $_SESSION['group_name']=$id3;
//  $_SESSION['usertype']='Group Admin';
//  $_SESSION['login_UserID']=$group_admin_id;
//  $_SESSION['login_TblEntityID']=113;

//  $_SESSION['current_ay']=$id6;
//  $_SESSION['current_sem_type']=$id7;
//  $_SESSION['balance_green_point']=$id8;
//  $_SESSION['balance_blue_point']=$id9;
//  $_SESSION['balance_water_point']=$id10;
 //$a='';
  //$_SESSION['vals']='grp';
  
header('location:group_admin/club_list.php');
// echo '<script>
//  window.location="./group_admin/club_list.php";
//  </script>';

?>
