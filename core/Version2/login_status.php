<?php  

//require_once('loader.php');

require_once('function.php');

require_once('config.php');

error_reporting(0);

//$json=$_GET ['json'];

$json = file_get_contents('php://input');

$obj = json_decode($json);

$format = 'json'; 



include 'conn.php';

							/* $con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 

								   or die('Cannot connect to the DB');

							mysql_select_db('SmartCookies',$con); */



   /*$t_id1=$obj->{'t_id'};         // Sender ID

   $t_id2=$obj->{'t_id2'};  // Receiver ID

   $points=$obj->{'points'};

   $reason=$obj->{'reason'};

   $school_id=$obj->{'school_id'};
   $select_opt=$obj->{'point_type'};
   
   
   
*/


  //$College_Code=$obj->{'College_Code'};
  
  
  
  $country_code=$obj->{'country_code'};
  $t_row_id=$obj->{'EntityID'};
  //$User_Type =$obj->{'Entity_type'};
  $method =$obj->{'method'};         // Android or iOS or Web
  $device_type =$obj->{'device_type'};    // phone or Tab
  $device_details =$obj->{'device_details'};    // version or entire device details
  $platform_OS =$obj->{'platform_OS'};    // OS name
  $ip_add =$obj->{'ip_address'};
  $lat =$obj->{'lat'};
  $long =$obj->{'long'};
   $posts = array();
if($t_row_id!="" && $method!="" && $device_type!="" && $device_details !="" && $platform_OS !="" &&  $ip_add!="") 

{
	
	
	$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='108'");
		         if(mysql_num_rows($arr)==0)

	        	{
                     $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,FirstPlatformOS,FirstIPAddress,FirstLatitude, FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode)values ('$t_row_id','108',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date','$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code')");
										 $report="login status succesfully added";

								$posts[]=array('report'=>$report);
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK  INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,FirstPlatformOS,FirstIPAddress,FirstLatitude,
                     FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode)
                                         values ('$t_row_id','108',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date','$method','$device_details','$platform_OS','$ip_add',
										 '$lat','$long','$country_code')";
								$postvalue['posts']=$posts;



                }
                else{

                            $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method', LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',LatestIPAddress='$ip_add',LatestLatitude='$lat',LatestLongitude='$long',CountryCode='$country_code',school_id='$sch_id',LogoutTime='' where EntityID='$t_row_id' and Entity_type='103'");
							 $report="login status succesfully added";

								$posts[]=array('report'=>$report);
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;


                }
	
					
						
					}
					

	

	
		 

		 

      

if($format == 'json') {

							header('Content-type: application/json');

    						 echo json_encode($postvalue);

						}





else{

	   

	   

	   $postvalue['responseStatus']=1000;

				$postvalue['responseMessage']="Invalid Input";

				$postvalue['posts']=null;

			  

			  header('Content-type: application/json');

   			  echo  json_encode($postvalue); 

	   

	 }

//

  //$posts = array($json);

  

	

		

  ?>