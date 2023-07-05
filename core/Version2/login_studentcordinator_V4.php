<?php
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));
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
  $lat = $obj->{'lat'};
  $long = $obj->{'long'};

   //$entity_type = $obj->{'entity_sub_type'};
    //$activity = $obj->{'activity'};

  $date = date('d-m-Y H:i:s');


 $condition = "";
if($User_Type=='Email'){
$condition = "std_email='".$User_Name."'";
}


else if($User_Type=='Mobile-No'){
	$country_code=$obj->{'country_code'};
$condition = "country_code in (".$country_code.",0) and std_phone='".$User_Name."'";
}
else if($User_Type=='PRN')
{

	 $condition = "std_PRN='".$User_Name."' and school_id='".$College_Code."'";
}else
{
    $User_Name_id1 = str_replace("M","",$User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');
     $condition = "id='".$User_Name_id."' and school_id='".$College_Code."'";

}




  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
		{


            include 'conn.php';


            $query = mysql_query("SELECT s.*,cc.teacher_id,cc.status,cc.pointdate,t.`t_id`,t.`school_id` as t_school_id,t.`t_complete_name`,t.`t_pc` FROM tbl_student s Left join tbl_coordinator cc on s.`id`=cc.stud_id and s.school_id=cc.school_id LEFT JOIN tbl_teacher t on cc.teacher_id=t.id and cc.school_id=t.school_id where $condition and std_password = '$User_Pass'");
            $posts = array();

            if(mysql_num_rows($query)==1)
             {
			
				    while($post = mysql_fetch_assoc($query))
                                       {

                                               $posts[] = $post;
                                                $sch_id= $post["school_id"];
                                                $std_row_id=$post["id"];
                                       }
									   $postvalue['responseStatus']=200;
                				       $postvalue['responseMessage']="OK";
                				       $postvalue['posts']=$posts;
									   
                    $arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='105'");
    		        if(mysql_num_rows($arr)==0)

    	        	{
                         $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                       FirstPlatformOS,FirstIPAddress,FirstLatitude,FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id,FirstDevicetype)
                                            values ('$std_row_id','105','$date','$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date',
                                            '$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code','$sch_id','$device_type')");



                    }
                    else{

                                $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method',
                                LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',LatestIPAddress='$ip_add',LatestLatitude='$lat',LatestLongitude='$long',CountryCode='$country_co'
								,school_id='$sch_id',LogoutTime='',LatestDevicetype='$device_type'
                                  where EntityID='$std_row_id' and Entity_type='105'");

                    }
                 
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

  		
			 }	else
			{

			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			    header('Content-type: application/json');
   			    echo  json_encode($postvalue);


			}


  @mysql_close($con);

?>