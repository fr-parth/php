<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

//Start SMC-3488
$date=CURRENT_TIMESTAMP;
$email_id = xss_clean(mysql_real_escape_string($obj->{'email'}));
$password = xss_clean(mysql_real_escape_string($obj->{'password'}));
$LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
$LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
$LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
$LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
$LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
$LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
$LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));

if($email_id!='' and $password!='')
{

	$query = mysql_query("select * from tbl_cookie_adminstaff where designation='sales Manager' and email='$email_id' and pass='$password'");
	$count = mysql_num_rows($query);
	if($count==1)
	{
			$query_result = mysql_fetch_assoc($query);
			$manager_id = $query_result['id']; //SMC-3488
			$postvalue['responseStatus']="200";
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$query_result;
			header('Content-type:application/json');
			echo json_encode($postvalue);
				//SMC-3488
				$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$manager_id' and Entity_type='114' ORDER BY `RowID` DESC  limit 1");
			   $result_arr = mysql_fetch_assoc($arr);
				if (mysql_num_rows($arr) == 0)
				{
								$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`)
							     VALUES ('$manager_id','114','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser')");
																			
								
				}
				else
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`,`FirstBrowser`)
							     VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','".$result_arr['FirstBrowser']."')");

					
					if($result_arr['LogoutTime']=='')
					{
					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$manager_id' and Entity_type='114' and RowID=".$result_arr['RowID']." ");
					}
						//End SMC-3488
				}
	}		
	else if($count>1)
	{
			$postvalue['responseStatus']="409";
			$postvalue['responseMessage']="conflict";
			$postvalue['posts']=null;
			header('Content-type:application/json');
			echo json_encode($postvalue);
	}
	else
	{
			$postvalue['responseStatus']="204";
			$postvalue['responseMessage']="no responce";
			$postvalue['posts']=null;
			header('Content-type:application/json');
			echo json_encode($postvalue);

	}
}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="invalide inputs";
	$postvalue['posts']=null;
	header('Content-type:application/json');
	echo json_encode($postvalue);
}

@mysql_close($conn);





?>
