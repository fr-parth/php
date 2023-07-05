<?php
 include("conn.php");
 error_reporting(0);
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$result['school_id'];

 $dup_email=$_POST['dup_email'];
 //Below conditions added by Rutuja for SMC-5191 for not giving an duplicate Email ID error if Email ID is of that specific user on edit page on 12-03-2021
 if(isset($_POST['t_id'])){
 	$t_id=$_POST['t_id'];
 	$cond = " and t_id!='$t_id' ";
 }
 else
 {
 	$cond= "";
 }

$row = mysql_query("select * from tbl_teacher where t_email = '".$dup_email."' and school_id ='".$sc_id."' $cond ");
$count=mysql_num_rows($row);
               
					echo $count;
			
				?>