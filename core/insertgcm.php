<?php 


echo $gcm_id=$_GET['registrationId'];
include('conn.php');
$_SESSION['registraionid']=$gcm_id;
//setcookie('registraionid','registraionid',time() + 2*7*24*60*60,'/','.tsmartcookies.bpsi.us/', false);





?>