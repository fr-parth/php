<?php
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
  $User_Name = $obj->{'User_Name'};
  $College_Code=$obj->{'College_Code'};
  $User_Pass = $obj->{'User_Pass'};
  $User_Type =$obj->{'User_Type'};
 $LatestMethod=$obj->{'method'};
	$LatestDevicetype=$obj->{'device_type'}; 
	$LatestDeviceDetails=$obj->{'device_details'};
	$LatestPlatformOS=$obj->{'platform_OS'};
	$LatestIPAddress=$obj->{'ip_address'};
	$LatestLatitude=$obj->{'lat'};
	$LatestLongitude=$obj->{'long'};
	$LatestBrowser=$obj->{'platform_OS'};

   //$entity_type = $obj->{'entity_sub_type'};
   // $activity = $obj->{'activity'};

      $date = date('d-m-Y H:i:s');
 $condition = "";
if($User_Type=='Email'){

$condition = "t_email='".$User_Name."'  and school_id='".$College_Code."'";
}


else if($User_Type=='Mobile-No'){
	$country_code=$obj->{'country_code'};
$condition = "CountryCode='".$country_code."' and t_phone='".$User_Name."'";

}
else if($User_Type=='EmployeeID')
{

	 $condition = "t_id='".$User_Name."' and school_id='".$College_Code."'";
}
else if($User_Type=='MemberID')
{
	if(!(stripos($User_Name,'t')===0)){
		
		$User_Name = "";
	}
	else{
	 $condition = "id='".substr($User_Name,1)."'";
	}
}
 else
{
    $User_Name_id1 = str_replace("M","",$User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');
     $condition = "id='".$User_Name_id."' and school_id='".$College_Code."'";

}


$email = "";

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
		{


include 'conn.php';


  //$query = "SELECT * FROM tbl_student where std_password = '$User_Pass' and (std_username = '$User_Name' or  std_email='$User_Name' or std_phone='$User_Name' or std_PRN='$User_Name')";
  $sql = "SELECT * FROM tbl_teacher where $condition and t_password = '$User_Pass'";
  $query = mysql_query($sql);

$a = mysql_num_rows($query);
  /* create one master array of the records */
  $posts = array();
  if(mysql_num_rows($query)==1)
   {
                while($post = mysql_fetch_assoc($query))
                      {
                        $posts[] = $post;
                        $sch_id= $post["school_id"];
                         $t_row_id=$post["id"];
                      }

	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
                
				//$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103'");
		       $arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103' ORDER BY `RowID` DESC  limit 1");
			   $result_arr = mysql_fetch_assoc($arr);
			   
			   if (mysql_num_rows($arr) == 0)
				{
								$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`)
							     VALUES ('$t_row_id','103','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$country_code')");
																			
								
				}
				else
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`)
							     VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$country_code')");

					//$LoginStatus = mysql_query("insert into `tbl_LoginStatus` (`LatestLoginTime`,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode) values ('$LatestLoginTime''$LatestMethod','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode');
					if($result_arr['LogoutTime']=='')
					{
					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$t_row_id' and Entity_type='103' and RowID=".$result_arr['RowID']." ");
					}					
				}	
                //$activity_log=mysql_query("INSERT INTO `tbl_ActivityLog` //(EntityID,Entity_type,EntitySubType,Timestamp,Activity,CountryCode)
                //    values ('$t_row_id','103','$entity_type','$date','$activity','$country_code')");




  }
  else
  {

                $postvalue['responseStatus']=409;
				$postvalue['responseMessage']="conflict";
				$postvalue['posts']=null;

  }
  /* output in necessary format */
  if($format == 'json') {
   					 header('Content-type: application/json');
   					 echo json_encode($postvalue);
  }
  else {
    header('Content-type: text/xml');
    echo '';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }
  /* disconnect from the db */

  		}
	else
			{

			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);


			}


  @mysql_close($con);

?>