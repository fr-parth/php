<?php
session_start();
@include 'conn.php';
@include 'cart_login_inc.php';
$rows=0;



if(isset($_POST['name'])){
	$name=$_POST['name'];
	$id=$_POST['id'];
	$image=$_POST['image'];
	$email=$_POST['email'];	

	


	$qe=mysql_query("select id,std_PRN,std_username,school_id,gplus_id,std_img_path,college_mnemonic from tbl_student where `std_email`='$email' or `gplus_id`='$id'")or die(mysql_error());	
	$rows=mysql_num_rows($qe); 

	
if($rows>=1){
		$qm=mysql_fetch_array($qe);
		$stud_id=$qm['id'];
		$gplus_id=$qm['gplus_id'];
		$std_img_path=$qm['std_img_path'];
		$std_PRN=$qm['std_PRN'];
		$college_mnemonic=$qm['college_mnemonic'];
	if($stud_id!=""){
				if($gplus_id=="" or $std_img_path==""){					
					

					$year=date('Y');
					$entity="Student";
					$college=$college_mnemonic;
					$start_dir="images";
					$path=$start_dir.'/'.$college.'/'.$entity.'/'.$year.'/';
					if(!file_exists($path)){
						mkdir($path, 0777, true);
					}
					
				
					$file = $college.'_'.$std_PRN.'.jpg';	
					//$file = $i.'.png';
					$filename=$path.$file;
					
					$content = file_get_contents($image);
					//Store in the filesystem.
					$fp = fopen($filename, "w");
					fwrite($fp, $content);
					fclose($fp);					
					
				mysql_query("update tbl_student set gplus_id='$id',std_img_path='$filename' where id='$stud_id'")or die(mysql_error());	
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