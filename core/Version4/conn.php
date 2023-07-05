<?php
include('../securityfunctions.php');
error_reporting(0);
session_start();
//Protsahan-Bharati cases added by Rutuja Jori on 17/07/2019

$server_name = $_SERVER['SERVER_NAME'];

Switch($server_name)
{ 
	case "old.smartcookie.in":
					$con =mysql_connect("SmartCookies.db.7121184.hostedresource.com","SmartCookies","b@V!2017297");
					mysql_select_db("SmartCookies",$con);

					//Below query(SET NAMES utf8) is added by Rutuja Jori on 08/07/2019 for all switch cases.
					 mysql_query("SET NAMES utf8");
					
		break;
		
		
	
	
	case "test.smartcookie.in":
					$con=mysql_connect("50.63.166.149","smartcoo_test","ERnd_5Mtz=;4");
					mysql_select_db("smartcoo_test",$con);
					mysql_query("SET NAMES utf8");
		break;
		
		

	case "dev.smartcookie.in":
						$con=mysql_connect("50.63.166.149","techindi_Develop","A*-fcV6gaFW0");
						mysql_select_db("techindi_Dev",$con) ;

						mysql_query("SET NAMES utf8");
		break;
		
		
		
	case "smartcookie.in":
					$con =mysql_connect("localhost","smartcoo_cookie","#VQss80$N)MU");
					mysql_select_db("smartcoo_smartcookie",$con);
					 mysql_query("SET NAMES utf8");
		break;
		
		case "protsahanbharati.com":
					$con =mysql_connect("localhost","smartcoo_cookie","#VQss80$N)MU");
					mysql_select_db("smartcoo_smartcookie",$con);
					 mysql_query("SET NAMES utf8");
		break;

	 case "protsahanbharati.com":
                                        $con =mysql_connect("localhost","smartcoo_cookie","#VQss80$N)MU");
                                        mysql_select_db("smartcoo_smartcookie",$con);
                                        mysql_query("SET NAMES utf8");
                break;


    case "localhost.smartcookie.in":
	
        $con=mysql_connect("50.63.166.149","techindi_Develop","A*-fcV6gaFW0");
						mysql_select_db("techindi_Dev",$con) ;
						mysql_query("SET NAMES utf8");
						
		break;
		
		case "localhost.protsahanbharati.com":
	
        $con=mysql_connect("50.63.166.149","techindi_Develop","A*-fcV6gaFW0");
						mysql_select_db("techindi_Dev",$con) ;
						mysql_query("SET NAMES utf8");
						
		break;
}
?> 

