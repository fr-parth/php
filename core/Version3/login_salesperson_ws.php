<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

$User_Name = $obj->{'User_Name'};
$User_Pass = $obj->{'User_Pass'};


$FirstLoginTime="";
$FirstMethod="";
$FirstDevicetype="";
$FirstDeviceDetails="";
$FirstPlatformOS="";
$FirstIPAddress="";
$FirstLatitude="";
$FirstLongitude="";
$FirstBrowser="";

$LatestMethod="";
$LatestDevicetype="";
$LatestDeviceDetails="";
$LatestPlatformOS="";
$LatestIPAddress="";
$LatestLatitude="";
$LatestLongitude="";
$LatestBrowser="";
$LogoutTime="";


include 'conn.php';

$User_Name_id1 = str_replace("M","",$User_Name);
$User_Name_id = str_replace("0","",$User_Name_id1);

if($User_Name!='' and $User_Pass!=''){


    $query = "SELECT * FROM `tbl_salesperson` where p_password = '$User_Pass' and person_id = (select person_id from `tbl_salesperson` where p_email = '$User_Name' or person_id = '$User_Name_id' or p_phone='$User_Name')";
    $result = mysql_query($query,$con) or die('Errant query:  '.$query);
    $getdata=mysql_query("select * from `tbl_salesperson` where p_email = '$User_Name' or person_id = '$User_Name_id' or p_phone='$User_Name' and p_password = '$User_Pass'");
    $getDataResults=mysql_fetch_array($getdata);
    $posts = array();
    if(mysql_num_rows($result)>=1) {

        $Entity_type="116";
        $EntityID=$getDataResults['person_id'];
        $CountryCode=$getDataResults['CountryCode'];
        $LatestLoginTime=date('Y-m-d H:i:s');

        $arr = mysql_query("select EntityID from `tbl_LoginStatus` where EntityID='$EntityID' and Entity_type='116'");
        if (mysql_num_rows($arr) == 0)
        {
            $LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `LogoutTime`, `CountryCode`)
									VALUES ('$EntityID','$Entity_type','$FirstLoginTime','$FirstMethod','$FirstDevicetype','$FirstDeviceDetails','$FirstPlatformOS','$FirstIPAddress','$FirstLatitude','$FirstLongitude','$FirstBrowser','$LatestLoginTime','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$LogoutTime','$CountryCode')");
        }
        else
        {
            $LoginStatus = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$LatestLoginTime',LatestMethod='$LatestMethod',
										LatestDeviceDetails='$LatestDeviceDetails',LatestPlatformOS='$LatestPlatformOS',
										LatestIPAddress='$LatestIPAddress',LatestLatitude='$LatestLatitude', LatestLongitude='$LatestLongitude',CountryCode='$CountryCode',LogoutTime=''
										where EntityID='$EntityID' and Entity_type='116'");
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