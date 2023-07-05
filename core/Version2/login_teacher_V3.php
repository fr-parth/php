<?php
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
  $User_Name = $obj->{'User_Name'};
  $College_Code=$obj->{'College_Code'};
  $User_Pass = $obj->{'User_Pass'};
  $User_Type =$obj->{'User_Type'};
  $method =$obj->{'method'};         // Android or iOS or Web
  $device_type =$obj->{'device_type'};    // phone or Tab
  $device_details =$obj->{'device_details'};    // version or entire device details
  $platform_OS =$obj->{'platform_OS'};    // OS name
  $ip_add =$obj->{'ip_address'};
  $lat =$obj->{'lat'};
  $long =$obj->{'long'};

   //$entity_type = $obj->{'entity_sub_type'};
   // $activity = $obj->{'activity'};

      $date = date('d-m-Y H:i:s');
 $condition = "";
if($User_Type=='Email'){

$condition = "t_email='".$User_Name."'";
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
                $arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103'");
		        if(mysql_num_rows($arr)==0)

	        	{
                     $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                             FirstPlatformOS,FirstIPAddress,FirstLatitude,
                                        FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)
                                         values ('$t_row_id','103',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date','$method','$device_details','$platform_OS','$ip_add',
										 '$lat','$long','$country_code','$sch_id')");


                }
                else{

                            $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method',
                            LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',
							LatestIPAddress='$ip_add',LatestLatitude='$lat',                                          LatestLongitude='$long',CountryCode='$country_code',school_id='$sch_id',LogoutTime=''
                             where EntityID='$t_row_id' and Entity_type='103'");

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