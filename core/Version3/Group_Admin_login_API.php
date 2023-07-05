<?php  
/*
 * modified on 20181218 by Shivkumar to insert login details into loginStatus table
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');

include 'conn.php';

	$User_Name = xss_clean(mysql_real_escape_string($obj->{'Admin_Name'}));
	$User_Pass = xss_clean(mysql_real_escape_string($obj->{'Admin_Pass'}));
	$group_id = xss_clean(mysql_real_escape_string($obj->{'group_id'}));

	$LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
	$LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
	$LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
	$LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	$LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
	$LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
	$LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
	$LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	$date = CURRENT_TIMESTAMP;

	$condition = "";

	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($User_Name)))
	{
			$condition = "admin_email='".$User_Name."'";
	}

	else //(preg_match('/^[789]\d{9}$/',$User_Name))
	{
		$condition = "(mobile_no='".$User_Name."' OR id='".$User_Name."')";
	}

  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 

 
    if($User_Name!="" && $User_Pass!="" && $group_id!="" )
	{
		$query="SELECT * FROM `tbl_cookieadmin` where $condition and binary admin_password = '$User_Pass' and group_mnemonic_name = '$group_id' and id > 1
		";
  
		$result = mysql_query($query) or die('Errant query: query error ');
		/* create one master array of the records */
		$posts = array();
		if(mysql_num_rows($result) > 0) 
		{
			while($post = mysql_fetch_assoc($result))
			{
				$row_id = $post['id'];
				$posts[] = array_map(clean_string,$post);
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
			
			//query to login status of user from login status table
			$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$row_id' and Entity_type='118' ORDER BY `RowID` DESC  limit 1");
			$result_arr = mysql_fetch_assoc($arr);
			   
			   if (mysql_num_rows($arr) == 0)
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`,`school_id`,LogoutTime)
					VALUES ('$row_id','118','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$country_code','$College_Code','')");									
				}
				else
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`,`school_id`,LogoutTime)
					 VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$country_code','$College_Code','')");	
				}
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;	
	}
  
  echo  json_encode($postvalue); 
  @mysql_close($con);

?>