<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

// START SMC-3487 Pravin 2018-09-27 2:50 PM
 $User_Name = xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
 $User_Pass = xss_clean(mysql_real_escape_string($obj->{'User_Pass'}));
	
	
	$LatestMethod=xss_clean(mysql_real_escape_string($obj->{'method'}));
	$LatestDevicetype=xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
	$LatestDeviceDetails=xss_clean(mysql_real_escape_string($obj->{'device_details'}));
	$LatestPlatformOS=xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	$LatestIPAddress=xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
	$LatestLatitude=xss_clean(mysql_real_escape_string($obj->{'lat'}));
	$LatestLongitude=xss_clean(mysql_real_escape_string($obj->{'long'}));
	$LatestBrowser=xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	
  $User_Name_id1 = str_replace("M","",$User_Name);
  $User_Name_id = str_replace("0","",$User_Name_id1);
  
if($User_Name!='' and $User_Pass!=''){
	
		$result=mysql_query("select * from tbl_salesperson where p_password = '$User_Pass' AND (p_email = '$User_Name' OR person_id = '$User_Name' OR p_phone='$User_Name')");
		
  $posts = array();
  if(mysql_num_rows($result)>0) { 
  
	$getDataResults=mysql_fetch_assoc($result);
	$Entity_type="116";
	$EntityID=$getDataResults['person_id'];
	$CountryCode=$getDataResults['CountryCode'];
	//$LatestLoginTime=date('Y-m-d H:i:s');
	$LatestLoginTime=CURRENT_TIMESTAMP;
	//End SMC-3487
			$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$EntityID' and Entity_type='116' ORDER BY `RowID` DESC  limit 1");
			$result_arr = mysql_fetch_assoc($arr);
			
			if (mysql_num_rows($arr) == 0)
				{
								$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`)
							     VALUES ('$EntityID','$Entity_type','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$CountryCode')");
																			
								
				}
				else
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`)
							     VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode')");

					//$LoginStatus = mysql_query("insert into `tbl_LoginStatus` (`LatestLoginTime`,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode) values ('$LatestLoginTime''$LatestMethod','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode');
					if($result_arr['LogoutTime']=='')
					{
					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$LatestLoginTime' where EntityID='$EntityID' and Entity_type='116' and RowID=".$result_arr['RowID']." ");
					}					
				}	

		$posts = $getDataResults;
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
  }
  else
  {
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
  }

}else{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
}  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
  /* disconnect from the db */
  @mysql_close($con);

?>