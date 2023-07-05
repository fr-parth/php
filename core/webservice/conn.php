<?php
error_reporting(0);
session_start();

$server_name = $_SERVER['SERVER_NAME'];

Switch($server_name)
{
	case "old.smartcookie.in":
					$con =mysql_connect("SmartCookies.db.7121184.hostedresource.com","SmartCookies","b@V!2017297");
					mysql_select_db("SmartCookies",$con);
		break;
	
	
	case "test.smartcookie.in":
					$con=mysql_connect("50.63.166.149","smartcoo_test","ERnd_5Mtz=;4");
					mysql_select_db("smartcoo_test",$con);
		break;

	case "dev.smartcookie.in":
						$con=mysql_connect("50.63.166.149","smartcoo_dev1","Black348Berry");
						mysql_select_db("smartcoo_dev",$con) ;
		break;
		
	
	case "smartcookie.in":
					$con =mysql_connect("localhost","smartcoo_cookie","#VQss80$N)MU");
					mysql_select_db("smartcoo_smartcookie",$con);
		break;

    case "localhost.smartcookie.in":
	
        $con=mysql_connect("50.63.166.149","smartcoo_dev1","Black348Berry") or die('conn failed');
        mysql_select_db("smartcoo_dev",$con) or die('db failed');
		
		break;
}
?> 