<?php
 include("conn.php");

 
 $UserID = $_SESSION['login_UserID'];
 $TblEntityID = $_SESSION['login_TblEntityID'];
 /*$calculated_country = $_SESSION['calculated_country'];
 
 if($calculated_country=='India')
{
	date_default_timezone_set("Asia/Calcutta");
		$date = date("Y-m-d h:i:s A");
}
elseif($calculated_country=='United States')
{
	date_default_timezone_set("America/Boa_Vista");
		$date = date("Y-m-d h:i:s A");
}*/

 //$date = date("Y-m-d h:i:s");
$date=date('Y-m-d h:i:s');
 
 $q=mysql_query("update tbl_LoginStatus set LogoutTime='$date' where EntityID = '$UserID' AND Entity_type= '$TblEntityID' ORDER BY `RowID` DESC  limit 1")or die(mysql_error());
 
 
/* $sql=mysql_query("SELECT * FROM tbl_LoginStatus WHERE EntityID = '$UserID' AND Entity_type= '$TblEntityID' ")or die(mysql_error());

		if(mysql_num_rows($sql)>0){		
	
			$q=mysql_query("update tbl_LoginStatus set LogoutTime='$date' where EntityID = '$UserID' AND Entity_type= '$TblEntityID' ")or die(mysql_error());
		}*/
		
 
  mysql_close($con);
 session_destroy();
 setcookie('usertype','');
 //Start changes for Bug No-3379 by Dhanashri Tak
//$host='http://'.$_SERVER['HTTP_HOST'];
 $host=$GLOBALS['URLNAME'];
 //End
 header("location: $host ");
?>
