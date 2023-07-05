<?php
error_reporting(0);
if(session_id() == ''){
    //session has not started
    session_start();
}
$position = isset($_SESSION['hr_id']) ? $_SESSION['hr_id'] : 0;
if(empty($position))
    $_SESSION['hr_id'] = 0;
$con = mysql_connect('testethicalhr3.db.7121184.hostedresource.com','testethicalhr3','Bpsi@1234'); 
      //or die('Cannot connect to the DB');
mysql_select_db('testethicalhr3',$con);
if ($con->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
} 
//else{echo "Connected successfully";}


?>

