<?php
	session_start();
	include("./phptextClass.php");	
	
	/*create class object*/
	$phptextObj = new phptextClass();	
	/*phptext function to genrate image with text*/
	$phptextObj->phpcaptcha('#5c70b2','#FFFFFF',120,40,10,25);	//Changes done by pranali intern
 ?>