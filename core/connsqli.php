<?php

error_reporting(0);
session_start();

$server_name = $_SERVER['SERVER_NAME'];

Switch($server_name)
{
	case "test.smartcookie.in":
					$conn=mysqli_connect("smcprodnew.crlqlgczdrqb.ap-south-1.rds.amazonaws.com", "techindi_tester", "{1Sl=f8#Kg~U") or die('Unable to establish a DB connection');
					// UTF-8 mode
					mysqli_query($conn,"SET NAMES 'utf8'");

					// Selects the database
					$res=mysqli_select_db($conn,"techindi_tester");
					if(!$res)
					{
						die("connection failed:".mysqli_connect_error());
					}

		break;

	case "dev.smartcookie.in":
						$conn=mysqli_connect("50.63.166.149", "techindi_Develop", "A*-fcV6gaFW0") or die('Unable to establish a DB connection');
						// UTF-8 mode
						mysqli_query($conn,"SET NAMES 'utf8'");

						// Selects the database
						$res=mysqli_select_db($conn,"techindi_Dev");
						if(!$res)
						{
						 die("connection failed:".mysqli_connect_error());
						}
						
		break;
		
	
	case "smartcookie.in":
					$conn=mysqli_connect("localhost", "smartcoo_cookie", "#VQss80$N)MU") or die('Unable to establish a DB connection');
						// UTF-8 mode
					mysqli_query($conn,"SET NAMES 'utf8'");

						// Selects the database
					$res=mysqli_select_db($conn,"smartcoo_smartcookie");
					if(!$res)
					{
						die("connection failed:".mysqli_connect_error());
					}
		break;

    case "localhost.smartcookie.in":
    					$conn=mysqli_connect("50.63.166.149", "techindi_Develop", "A*-fcV6gaFW0") or die('Unable to establish a DB connection');
						// UTF-8 mode
						mysqli_query($conn,"SET NAMES 'utf8'");

						// Selects the database
						$res=mysqli_select_db($conn,"techindi_Dev");
						if(!$res)
					{
						die("connection failed:".mysqli_connect_error());
					}
		
		break;
}
?> 