<?php
 include("conn.php");
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$result['school_id'];

 $dup_email=$_POST['dup_email'];
 //Below conditions added by Rutuja for SMC-5191 for not giving an duplicate Email ID error if Email ID is of that specific user on edit page on 06-03-2021
 if(isset($_POST['std_prn'])){
    $std_prn=$_POST['std_prn'];
    $cond = " and std_PRN!='$std_prn' ";
 }
 else
 {
    $cond= "";
 }
$row = mysql_query("select * from tbl_student where std_email='".$dup_email."' and school_id='".$sc_id."' $cond ");

$count=mysql_num_rows($row);
               
                    echo $count;
            
                ?>