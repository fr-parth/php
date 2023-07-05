<?php
     
/*$server     = 'Tsmartcookies.db.7121184.hostedresource.com';
$username   = 'Tsmartcookies';
$password   = 'B@v!2018297';
$database   = 'Tsmartcookies';
 
$dsn        = "mysql:host=$server;dbname=$database"; 

     
/* $server     = 'SmartCookies.db.7121184.hostedresource.com';
$username   = 'SmartCookies';
$password   = 'Bpsi@1234';
$database   = 'SmartCookies';
 
$dsn        = "mysql:host=$server;dbname=$database;"; */
?>
<?php
error_reporting(0);
session_start();

$server_name = $_SERVER['SERVER_NAME'];

Switch($server_name)
{
	case "old.smartcookie.in":
	$server     = 'SmartCookies.db.7121184.hostedresource.com';
	$username   = 'SmartCookies';
	$password   = 'b@V!2017297';
	$database   = 'SmartCookies';
 
		$dsn    = "mysql:host=$server;dbname=$database"; 
	
	
					//$con =mysql_connect("SmartCookies.db.7121184.hostedresource.com","SmartCookies","b@V!2017297");
					//mysql_select_db("SmartCookies",$con);
		break;
	
	
	case "tsmartcookies.bpsi.us":
	$server     = 'Tsmartcookies.db.7121184.hostedresource.com';
	$username   = 'Tsmartcookies';
	$password   = 'B@v!2018297';
	$database   = 'Tsmartcookies';
 
		$dsn    = "mysql:host=$server;dbname=$database"; 
					//$con=mysql_connect("Tsmartcookies.db.7121184.hostedresource.com","Tsmartcookies","B@v!2018297");
					//mysql_select_db("Tsmartcookies",$con);
		break;

	case "devsmart.bpsi.us":
	$server     = 'devsmart.db.7121184.hostedresource.com';
	$username   = 'devsmart';
	$password   = 'devsmart';
	$database   = 'devsmart';
 
		$dsn    = "mysql:host=$server;dbname=$database"; 
					///$con=mysql_connect("devsmart.db.7121184.hostedresource.com","devsmart","devsmart");
					//mysql_select_db("devsmart",$con);
		break;
		
	
	case "smartcookie.in":
	$server     = 'localhost';
	$username   = 'smartcoo_cookie';
	$password   = '#VQss80$N)MU';
	$database   = 'smartcoo_smartcookie';
 
		$dsn    = "mysql:host=$server;dbname=$database"; 
					//$con =mysql_connect("localhost","smartcoo_cookie","#VQss80$N)MU");
					//mysql_select_db("smartcoo_smartcookie",$con);
		break;

    default:
	$server     = '50.63.166.149';
	$username   = 'smartcoo_dev1';
	$password   = 'Black348Berry';
	$database   = 'smartcoo_dev';
 
		$dsn    = "mysql:host=$server;dbname=$database"; 
       // $con=mysql_connect("50.63.166.149","smartcoo_dev1","Black348Berry") or die('conn failed');
       // mysql_select_db("smartcoo_dev",$con) or die('db failed');
		
}
?> 