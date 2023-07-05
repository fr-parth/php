<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
//print_r($json);
$User_Name = xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
$User_Pass = xss_clean(mysql_real_escape_string($obj->{'User_Pass'}));
$User_Id = xss_clean(mysql_real_escape_string($obj->{'User_Id'}));
$LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
$LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'}));
$LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
$LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
$LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
$LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
$LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
//$LatestBrowser=$obj->{'browser'};

//$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
$format = 'json'; //xml is the default


if ($User_Name != "" and $User_Pass != "" and $User_Id != "") {

    $User_Name_id1 = str_replace("M", "", $User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');


    $query = "SELECT * FROM `tbl_sponsorer` where (sp_email = '$User_Name' or  sp_phone = '$User_Name' ) and binary sp_password = '$User_Pass' and id = '$User_Id'";
    $result = mysql_query($query);

    $getdata = "SELECT * FROM `tbl_sponsorer` where (sp_email = '$User_Name' or  sp_phone = '$User_Name' ) and binary sp_password = '$User_Pass' and id = '$User_Id'";

    $result1 = mysql_query($getdata);

    $getDataResults = mysql_fetch_assoc($result1);
    /* create one master array of the records */
    $posts = array();
    if (mysql_num_rows($result) >= 1) {

        $Entity_type = "108";
        //$EntityID=$getDataResults['id'];
        $EntityID = $User_Id;
        $CountryCode = $getDataResults['CountryCode'];
		// Start SMC-3452 Date Format Modified By Pranali 2018-09-19 01:51 PM 
       // $LatestLoginTime = date('Y-m-d H:i:s');
	   $LatestLoginTime = CURRENT_TIMESTAMP;
		//End SMC-3452
        $arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$EntityID' and Entity_type='108' ORDER BY `RowID` DESC  limit 1");
        $result_arr = mysql_fetch_assoc($arr);
        if (mysql_num_rows($arr) == 0) {
            $LoginStatus = mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`)
			 VALUES ('$EntityID','$Entity_type','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$CountryCode')");

            /*	$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`)
             VALUES ('$EntityID','$Entity_type','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$CountryCode')");*/

        } else {

            /*$LoginStatus = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$LatestLoginTime',LatestMethod='$LatestMethod',
                                LatestDeviceDetails='$LatestDeviceDetails',LatestPlatformOS='$LatestPlatformOS',
                                LatestIPAddress='$LatestIPAddress',LatestLatitude='$LatestLatitude', LatestLongitude='$LatestLongitude',CountryCode='$CountryCode'
                                where EntityID='$EntityID' and Entity_type='108'");	*/
            $LoginStatus = mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`)
							     VALUES ('" . $result_arr['EntityID'] . "','" . $result_arr['Entity_type'] . "','" . $result_arr['LatestLoginTime'] . "','" . $result_arr['LatestMethod'] . "','" . $result_arr['LatestDevicetype'] . "','" . $result_arr['LatestDeviceDetails'] . "','" . $result_arr['LatestBrowser'] . "','" . $result_arr['LatestIPAddress'] . "','" . $result_arr['LatestLatitude'] . "','" . $result_arr['LatestLongitude'] . "','" . $result_arr['LatestBrowser'] . "','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode')");

            if ($result_arr['LogoutTime'] == '') {
                $LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$LatestLoginTime' where EntityID='$EntityID' and Entity_type='108' and RowID=" . $result_arr['RowID'] . " ");
            }
        }

//SMC-3490 Modify By Pravin 2018-09-29 
//Change code because of image path of sponsor_image

        /*while ($post = mysql_fetch_assoc($result)) {

            $post['id'] = (int)$post['id'];
            $post['pin'] = (int)$post['pin'];
            $post['sales_person_id'] = (int)$post['sales_person_id'];
            $post['sp_phone'] = (int)$post['sp_phone'];

            $posts[] = $post;


        }*/
		
	$image=$getDataResults['sp_img_path'];
	  
	  if($image=='')
	  {
		  
		  $sponsor_image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
	  }
	  else{
		  $sponsor_image=$GLOBALS['URLNAME']."/core/image_sponsor/".$image;
	  }
	  
	   
	   foreach($getDataResults as $key=>$value)
	   {
		   
		   $posts[$key] = $value;
		   $posts['sp_img_path'] = $sponsor_image;
	   }
//End SMC-3490  
	   $posts1[] = $posts;
        $postvalue['responseStatus'] = 200;
        $postvalue['responseMessage'] = "OK";
        $postvalue['posts'] = $posts1;

    } else {
        $postvalue['responseStatus'] = 204;
        $postvalue['responseMessage'] = "No Response";
        $postvalue['posts'] = null;
    }
    /* output in necessary format */
    if ($format == 'json') {
        header('Content-type: application/json');
        echo json_encode($postvalue);
    } else {
        header('Content-type: text/xml');
        echo '';
        foreach ($posts as $index => $post) {
            if (is_array($post)) {
                foreach ($post as $key => $value) {
                    echo '<', $key, '>';
                    if (is_array($value)) {
                        foreach ($value as $tag => $val) {
                            echo '<', $tag, '>', htmlentities($val), '</', $tag, '>';
                        }
                    }
                    echo '</', $key, '>';
                }
            }
        }
        echo '';
    }
    /* disconnect from the db */


} else {

    $postvalue['responseStatus'] = 1000;
    $postvalue['responseMessage'] = "Invalid Input";
    $postvalue['posts'] = null;

    header('Content-type: application/json');
    echo json_encode($postvalue);


}
@mysql_close($con);

?>