<?php
	include_once("conn.php");
	
	
	
	
	class emailfunction
	{
		
		function registrationemail($to,$pass,$type) 
		{ 
		
					$from="smartcookiesprogramme@gmail.com";
					$subject="Smartcookies Registration";
					$message="Dear ".$type.",\r\n\r\n".
						 "Thanks for your registration with Smart Cookie as ".$type." \r\n".
						  "Your Username is: ".$to."\n\n".
						  "Your Password is: ".$pass."\n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."http://tsmartcookies.bpsi.us";
						  
					mail($to, $subject, $message);
		
		
		
		
		 } 
	
	}
?>