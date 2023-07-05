<?php
include 'conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

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
  
  // Start SMC-3450 Modify By Pravin 2018-09-18 07:04 PM 
  //$date = date('Y-m-d H:i:s');
  $date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
  //End SMC-3450

//$condition = "";
if($User_Type=='Email' and $User_Name !="" and $College_Code != "")
{
		$condition = "std_email ='$User_Name' and school_id='$College_Code'";
}
else if($User_Type=='MemberId' and $User_Name !="")
{
	//$condition ="id ='".substr($User_Name,1)."'";
	//below $condition modified by Pranali for bug SAND-1565 as value of id is received as MemberId only 
	  $condition ="id ='$User_Name'";
		
}
else if($User_Type=='Mobile-No' and $User_Name != "" and $College_Code != "" )
{
	
	$country_code1=$obj->{'country_code'};
	
	$country_code = ltrim($country_code1, '+');
	//$condition = "country_code='$country_code1' AND std_phone='$User_Name' and  school_id='$College_Code'";
	
	//$country_code variable passed to country_code by Pranali for bug SAND-1565
	$condition = "country_code='$country_code' AND std_phone='$User_Name' and  school_id='$College_Code'";
		
}
else if($User_Type=='PRN' and $User_Name != ""  and $College_Code !='')
{
	 $condition = "std_PRN='$User_Name' and  school_id='$College_Code'";
	 
}else
{
    $User_Name_id1 = str_replace("M","",$User_Name);
    $User_Name_id = ltrim($User_Name_id1, '0');		
     $condition = "id='$User_Name_id'";
		
}
 
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
		{
			/* Author VaibhavG 
			*  I've fire queries for getting school name from table school admin If any  *  student has empty school name in student table. 
			*  As per the discussed with Android Developer Pooja Paramshetti for the ticket Number SAND-1602. 	
			*/ 
			$findSchool = mysql_query("SELECT school_name FROM `tbl_school_admin`  WHERE school_id='$College_Code'");
			$schoolName=mysql_fetch_assoc($findSchool);
			//End for the ticket Number SAND-1602.

           $query = mysql_query("SELECT * FROM  `tbl_student`  WHERE $condition and binary std_password = '$User_Pass'");
		   
            $posts = array();
			
$a = mysql_num_rows($query);
            if(mysql_num_rows($query)==1)
             {


                                        while($post = mysql_fetch_assoc($query))
                                       {
												$post["std_img_path"]=$GLOBALS['URLNAME']."/core/".$post["std_img_path"];
												//Start for the ticket Number SAND-1602.
												if(empty($post["std_school_name"]))
													$post["std_school_name"]=$schoolName['school_name'];
												//End for the ticket Number SAND-1602.
                                               $posts[] = $post;
                                                $sch_id= $post["school_id"];
                                                $std_row_id=$post["id"];
												
                                       }
                                       $query1 = "SELECT school_address,school_latitude,school_longitude FROM tbl_school where school_mnemonic='$sch_id'";
                                        $result1 = mysql_query($query1);
                                         $posts1 = array();
                                        if(mysql_num_rows($result1)==1)
                                         {

                                              while($post1 = mysql_fetch_assoc($result1))
                                               {
                                                   $posts1[] = $post1;
                                               }
                                          }

                	           


	 $arr = mysql_query("select  * from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='105' ORDER BY `RowID` DESC  limit 1");
			$result_arr = mysql_fetch_assoc($arr);
			
			if (mysql_num_rows($arr) == 0)
				{
											
																
							 $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                             FirstPlatformOS,FirstIPAddress,FirstLatitude,
                                            FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)
                                            values ('$std_row_id','105',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date',
                                            '$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code','$sch_id')");
											
											if($login_details)
											{
												$a= "yes";
											}
											else
											{
												$a = "no";
											}
																			
								
				}
				else
				{
					
					  $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                             FirstPlatformOS,FirstIPAddress,FirstLatitude,
                                            FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)
                                            values ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['FirstLoginTime']."','".$result_arr['FirstMethod']."','".$result_arr['FirstDeviceDetails']."','".$result_arr['FirstPlatformOS']."','".$result_arr['FirstIPAddress']."','".$result_arr['FirstLatitude']."','".$result_arr['FirstLongitude']."','$date','$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code','$sch_id')");
											if($login_details)
											{
												$b= "inserted again";
											}
											else
											{
												$b = "not";
											}
											
					if($result_arr['LogoutTime']=='')
					{
					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$std_row_id' and Entity_type='105' and RowID=".$result_arr['RowID']." ");
					
					if($LoginStatus_old)
											{
												$c= "updated again";
											}
											else
											{
												$c = "not updated";
											}
					}					
				}				
							
							    $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="OK";
                				$postvalue['posts']=$posts;
                                $postvalue['posts1']=$posts1;
								
            }
            elseif(mysql_num_rows($query)==0)
            {

                        $postvalue['responseStatus']=409;
          				$postvalue['responseMessage']="no record found";
          				$postvalue['posts']=null;

            }
			elseif(mysql_num_rows($query)>1)
            {

                        $postvalue['responseStatus']=409;
          				$postvalue['responseMessage']="More than one record found";
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