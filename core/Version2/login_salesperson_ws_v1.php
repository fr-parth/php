<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $User_Name = $obj->{'User_Name'};
 $User_Pass = $obj->{'User_Pass'};
	
	
	//$FirstLoginTime="";
	//$FirstMethod="";
	//$FirstDevicetype="";
	//$FirstDeviceDetails="";
	//$FirstPlatformOS="";
	//$FirstIPAddress=$obj->{'ip_address'};
	//$FirstLatitude="";
	//$FirstLongitude="";
	//$FirstBrowser="";
	
	$LatestMethod=$obj->{'method'};
	$LatestDevicetype=$obj->{'device_type'}; 
	$LatestDeviceDetails=$obj->{'device_details'};
	$LatestPlatformOS=$obj->{'platform_OS'};
	$LatestIPAddress=$obj->{'ip_address'};
	$LatestLatitude=$obj->{'lat'};
	$LatestLongitude=$obj->{'long'};
	$LatestBrowser=$obj->{'platform_OS'};
	//$LogoutTime="";
	
	
	 /*$User_Name = $obj->{'User_Name'};
  $College_Code=$obj->{'College_Code'};
  $User_Pass = $obj->{'User_Pass'};
  $User_Type =$obj->{'User_Type'};
  $method =$obj->{'method'};         // Android or iOS or Web
  $device_type =$obj->{'device_type'};    // phone or Tab
  $device_details =$obj->{'device_details'};    // version or entire device details
  $platform_OS =$obj->{'platform_OS'};    // OS name
  $ip_add =$obj->{'ip_address'};
  $lat =$obj->{'lat'};
  $long =$obj->{'long'};*/
	

include 'conn.php';
 
  $User_Name_id1 = str_replace("M","",$User_Name);
  $User_Name_id = str_replace("0","",$User_Name_id1);
  
if($User_Name!='' and $User_Pass!=''){
	
  
	    //$query = "SELECT * FROM `tbl_salesperson` where p_password = '$User_Pass' and person_id = (select person_id from `tbl_salesperson` where p_email = '$User_Name' or person_id = '$User_Name_id' or p_phone='$User_Name')";
	    //$result = mysql_query($query,$con) or die('Errant query:  '.$query);
		$result=mysql_query("select * from tbl_salesperson where p_password = '$User_Pass' AND (p_email = '$User_Name' OR person_id = '$User_Name' OR p_phone='$User_Name')");
		
  $posts = array();
  if(mysql_num_rows($result)>=1) { 
  
	$getDataResults=mysql_fetch_array($getdata);
	$Entity_type="116";
	$EntityID=$getDataResults['person_id'];
	$CountryCode=$getDataResults['CountryCode'];
	$LatestLoginTime=date('Y-m-d H:i:s');
	
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
    while($post = mysql_fetch_assoc($result)) {
      $posts[] = array('post'=>$post);
    }
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