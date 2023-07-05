<?php
session_start();
@include 'conn.php';
@include 'cart_login_inc.php';
$rows=0;
if(isset($_POST['name'])){
	$name=$_POST['name'];
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$id=$_POST['id'];
	$gender=$_POST['gender'];
	$email=$_POST['email'];	
	
	$pass=rand(100000,999999);
	//10/24/2015
	
	$date=date("m/d/Y",time());

$qe=mysql_query("select id,std_PRN,std_username,school_id,fb_id from tbl_student where `std_email`='$email' or `fb_id`='$id'")or die(mysql_error());	
$rows=mysql_num_rows($qe); 

if($rows>=1){
		$qm=mysql_fetch_array($qe);
		$stud_id=$qm['id'];
		$fb_id=$qm['fb_id'];
	if($stud_id!=""){
				if($fb_id==""){
					mysql_query("update tbl_student set fb_id='$id' where id='$stud_id'")or die(mysql_error());	
				}
					$_SESSION['id'] = $stud_id;					
 					$_SESSION['username']=$qm['std_username'];
					$_SESSION['rid']=$qm['std_PRN'];
					$_SESSION['school_id']=$qm['school_id'];
					$_SESSION['entity'] = 3;				
					
					
					if(upcartonlogin('3',$stud_id, $qm['std_PRN'], $qm['school_id'])){
						//header("Location:hangme.php");	
						echo "success";
					}else{
					$to=$email;
					$from="smartcookiesprogramme@gmail.com";
					$subject="Smartcookies Registration";
					$message="Dear ".$name.",\r\n\r\n".
						 "Thanks for visiting our site, \n".
						 "Your college is not registered with smartcookie programme."."\n\n".
						 "Please ask your college administrator to register with us."."\n\n".
						 "Regards,\r\n".
						 "Smart Cookie Admin \n"."www.smartcookie.in";
						  
					mail($to, $subject, $message);
					}
	}else{

					$to=$email;
					$from="smartcookiesprogramme@gmail.com";
					$subject="Smartcookies Registration";
					$message="Dear ".$name.",\r\n\r\n".
						 "Thanks for visiting our site, \n".
						 "Your college is not registered with smartcookie programme."."\n\n".
						 "Please ask your college administrator to register with us."."\n\n".
						 "Regards,\r\n".
						 "Smart Cookie Admin \n"."www.smartcookie.in";
						  
					mail($to, $subject, $message);

	}
	
}else{
	echo "error";
}
}
?>