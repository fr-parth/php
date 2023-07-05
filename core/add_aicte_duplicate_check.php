<?php
ob_end_clean();
include('../core/conn.php');
if(isset($_POST['check_email'])){
    
    $email=$_POST['email'];
    $emails=mysql_query("select t_email,t_phone from tbl_teacher where t_email='$email'");
    if(mysql_num_rows($emails) > 0){
         echo "Email id already exists";  
    }    
}
if(isset($_POST['check_phone'])){
    $phone=$_POST['phone'];
    $phone_no=mysql_query("select t_email,t_phone from tbl_teacher where t_phone='$phone'");
    if(mysql_num_rows($phone_no) > 0){
        echo "Mobile no already exists";
    }
}
if(isset($_POST['check_tid'])){
    $t_id=$_POST['t_id'];
    $ids=mysql_query("select t_id from tbl_teacher where t_id='$t_id'");
    if(mysql_num_rows($ids) > 0){
        echo "Teacher id already exists";
    }
}
?>