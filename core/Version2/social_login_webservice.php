<?php  

include 'conn.php';
include("emailfunction.php");
 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$method = xss_clean(mysql_real_escape_string($obj->{'method'}));   //Android or iOS or Web	
$device_type = xss_clean(mysql_real_escape_string($obj->{'device_type'}));    // phone or Tab	
$device_details = xss_clean(mysql_real_escape_string($obj->{'device_details'}));   // version or entire device details	

$platform_OS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));   // OS name			 
$ip_add = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$lat = xss_clean(mysql_real_escape_string($obj->{'lat'}));	
$long = xss_clean(mysql_real_escape_string($obj->{'long'}));	
$country_code = xss_clean(mysql_real_escape_string($obj->{'country_code'}));

$User_Email = xss_clean(mysql_real_escape_string($obj->{'User_Email'}));  

 $posts = array();


$User_Email = xss_clean(mysql_real_escape_string($obj->{'User_Email'}));  
//// Start SMC-3450 Modify By Pravin 2018-09-21 04:48 PM 
 //$date = date('d-m-Y H:i:s');
 $date = CURRENT_TIMESTAMP;
 ////End SMC-3450

     $posts = array();


  
 $format = 'json'; 
 
 if($User_Email != "")
		{
   $First_Name = xss_clean(mysql_real_escape_string($obj->{'First_Name'}));
   $Last_Name = xss_clean(mysql_real_escape_string($obj->{'Last_Name'}));
   $img = xss_clean(mysql_real_escape_string($obj->{'User_Image'}));
   $full_name=$First_Name." ".$Last_Name;
	
   $query=mysql_query("select id from tbl_student where std_email='$User_Email'");
   $count=mysql_num_rows($query);
		 
if($count>=1)
{
	
	 $query = "SELECT * FROM tbl_student where std_email='$User_Email'";
  $result = mysql_query($query);
  

  if(mysql_num_rows($result)==1) 
  {
    while($post = mysql_fetch_assoc($result)) 
	{
      $posts[] = $post;	  $std_row_id=$post["id"];	  $sch_id= $post["school_id"];
    }			  				$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='105'");    		        if(mysql_num_rows($arr)==0)    	        	{						                         $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                FirstPlatformOS,FirstIPAddress,FirstLatitude,FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)                                            values ('$std_row_id','105','$date','$method','$device_details','$platform_OS',											'$ip_add','$lat','$long','$date',                                            '$method','$device_details','$platform_OS','$ip_add','$lat','$long',											'$country_code','$sch_id')");                    }                    else{                                $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method',                                LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',LatestIPAddress='$ip_add',LatestLatitude='$lat',LatestLongitude='$long',CountryCode='$country_co'								,school_id='$sch_id',LogoutTime=''                                  where EntityID='$std_row_id' and Entity_type='105'");                    }
	
   }
}
else
{
	
	$User_Type = xss_clean(mysql_real_escape_string($obj->{'UserType'}));
	$fb_id = xss_clean(mysql_real_escape_string($obj->{'fb_id'}));
	$gplus_id = xss_clean(mysql_real_escape_string($obj->{'gplus_id'}));
	$linkedin_id = xss_clean(mysql_real_escape_string($obj->{'linkedin_id'}));
	
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
 $password = substr( str_shuffle( $chars ), 0, 8 );
 
	$test = mysql_query("INSERT INTO `tbl_student` 
	(std_name,std_lastname,std_complete_name,std_img_path,std_email,std_password,fb_id,gplus_id,linkedin_id) 
	VALUES('$First_Name','$Last_Name','$full_name','$img','$User_Email','$password','$fb_id','$gplus_id','$linkedin_id')");
	
	$arr1 = mysql_query("SELECT * FROM tbl_student where std_email='$User_Email' order by id desc");
$row1 = mysql_fetch_array($arr1);
$memberid = $row1['id'];
	
	
	 $emailfunction=new emailfunction();
	$to=$User_Email;
	  $type="Student";
		$results=$emailfunction->registrationemail($to,$password,$type);

	
	 $imageDataEncoded=$obj->{'User_imagebase64'};
   $ex_img = explode(".",$img);

  $img_name = $ex_img[0]."_".$id."_".date('Ymd');//SMC-3450
  //End SMC-3450

  $full_name_path = "image/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);
  $imageSave = imagejpeg($source,$imageName,100);
  
  mysql_query("update `tbl_student` set std_img_path = '$full_name_path' where id = $memberid");
  
	
		 $query = "SELECT * FROM tbl_student where std_email='$User_Email' order by id desc";
  $result = mysql_query($query);
  /* create one master array of the records */
  
  if(mysql_num_rows($result)==1) 
  {
    while($post = mysql_fetch_assoc($result)) 
	{
      $posts[] = $post;	  $std_row_id=$post["id"];	  $sch_id= $post["school_id"];
    }	$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='105'");    		        if(mysql_num_rows($arr)==0)    	        	{                         $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                             FirstPlatformOS,FirstIPAddress,FirstLatitude,                                            FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)                                            values ('$std_row_id','105','$date','$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date',                                            '$method','$device_details','$platform_OS','$ip_add','$lat','$long',											'$country_code','$sch_id')");                    }                    else{                                $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method',                                LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',LatestIPAddress='$ip_add',LatestLatitude='$lat',LatestLongitude='$long',CountryCode='$country_co'								,school_id='$sch_id',LogoutTime=''                                  where EntityID='$std_row_id' and Entity_type='105'");                    }
	
   }

}
 
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
	
 
  /* output in necessary format */
  if($format == 'json') {
   					 header('Content-type: application/json');
   					 echo json_encode($postvalue);
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