<?php
include 'conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

//print_r($json);
  $User_Name = xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
  $College_Code = xss_clean(mysql_real_escape_string($obj->{'College_Code'}));
  $User_Pass = xss_clean(mysql_real_escape_string($obj->{'User_Pass'}));
  $User_Type = xss_clean(mysql_real_escape_string($obj->{'User_Type'}));
  $LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
  $country_code = xss_clean(mysql_real_escape_string($obj->{'country_code'}));
	$LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
	$LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
	$LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	$LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
	$LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
	$LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
	$LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
	
   //$entity_type = $obj->{'entity_sub_type'};
   // $activity = $obj->{'activity'};platform_OS

	//Start SMC-3451 Modify By sachin 2018-09-19 14:16:38 PM 
	//$date = date('Y-m-d H:i:s');
		$date = CURRENT_TIMESTAMP; 
	//define in core/securityfunctions.php
	//End SMC-3451


 
$condition = "";
if($User_Type=='Email'){

$condition = "t.t_email='".$User_Name."' and  t.school_id='".$College_Code."'";
}


else if($User_Type=='Mobile-No'){
	
$condition = "t.CountryCode='".$country_code."' and t.t_phone='".$User_Name."' and  t.school_id='".$College_Code."'";

}
else if($User_Type=='EmployeeID')
{

	 $condition = "t.t_id='".$User_Name."' and  t.school_id='".$College_Code."'";
}
else if($User_Type=='MemberID')
{
	$condition = "t.id='".$User_Name."'";
	/* author vaibhavg
	* commented by vaibhvG as per the discussed with Teacher Tester M.Kumar & Android Developer Priyanka Gole for ticket number SAND-942.
	*/
	/*if(!(stripos($User_Name,'t')===0)){
		
		$User_Name = "";
	}
	else{
	 $condition = "id='".substr($User_Name,1)."'";
	}*/
}
 else
{
    $User_Name_id1 = str_replace("M","",$User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');
     $condition = "id='".$User_Name_id."'";

}

$email = "";

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
		{





  //$query = "SELECT * FROM tbl_student where std_password = '$User_Pass' and (std_username = '$User_Name' or  std_email='$User_Name' or std_phone='$User_Name' or std_PRN='$User_Name')";
  $sql = "SELECT  t.id , t.t_id , t.t_complete_name,t.t_middlename,t.t_lastname,t.t_name, t.t_current_school_name, t.school_id, t.t_dept, t.t_subject, t.t_class, t.t_qualification, t.t_address, t.t_permanent_village, t.t_permanent_taluka, t.t_permanent_district, t.t_permanent_pincode, t.t_city, t.t_dob, t.t_gender, t.t_country,t.t_email, t.t_academic_year, t.t_password, t.t_pc, t.CountryCode, t.t_phone, t.tc_balance_point, t.tc_used_point, t.state, t.balance_blue_points, t.water_point, t.used_blue_points, t.brown_point, t.school_type, t.group_status,t.group_member_id,c.group_type FROM tbl_teacher t left join tbl_cookieadmin c on c.id=t.group_member_id where $condition and binary t.t_password = '$User_Pass'";

//$query = mysql_query($sql) or die('Errant query:  '.$sql);
$query = mysql_query($sql);
if(!$query){
					  $postvalue['responseStatus']=1001;
					  $postvalue['responseMessage']="No Response";
					  $postvalue['posts']=null;
					  header('Content-type: application/json');
   					 echo json_encode($postvalue); 
					exit;
}
$count = mysql_num_rows($query);

  /* create one master array of the records */
  $posts = array();
  if($count == 1)
   {
                $post = mysql_fetch_array($query);
                      
                        $College_Code= $post["school_id"];
                         $t_row_id=$post["id"];
                         $t_complete_name=$post["t_complete_name"];
                         $tname=$post["t_name"];
                         $tmname=$post["t_middlename"];
                         $tlname=$post["t_lastname"];
						 $img=$post['t_pc'];
						 $school_id=$post['school_id'];
						 $group_type=$post['group_type'];
						 
						 //below if added by Pranali for SMC-3734 on 28-3-19
						 if($school_id=='KIMHC' || $school_id=='kimhc')
						 {
							 $group_type='Sports';
						 }
						 
						 if($t_complete_name=="")
						 {
							 $t_complete_name=$tname." ".$tmname." ".$tlname;
						 }
						 else
						 {
							 $t_complete_name;
						 }
						 if($img=='')
						 {
						$imagepath = $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
						 }
						 else{
//image path changed by Pranali for SMC-3747
							// $imagepath=$GLOBALS['URLNAME']."/core/".$img;
							 $imagepath=$GLOBALS['URLNAME']."/teacher_images/".$img;
						 }
						 //group_type replaced by $group_type in $data by Pranali for SMC-3734 on 28-3-19
						 $data=array(
						 'id' =>$post['id'],
						 't_id' =>$post['t_id'],
						't_complete_name'=>$t_complete_name,
						 't_current_school_name'=>$post['school_id'],
						 'school_id'=>$post['school_id'],
						 't_dept'=>$post['t_dept'],
						 't_subject'=>$post['t_subject'],
						 't_class'=>$post['t_class'],
						 't_qualification'=>$post['t_qualification'],
						 't_address'=>$post['t_address'],
						't_permanent_village'=>$post['t_permanent_village'],
						't_permanent_taluka'=>$post['t_permanent_taluka'], 
						't_permanent_district'=>$post['t_permanent_district'],
						't_permanent_pincode'=>$post['t_permanent_pincode'],
						't_city'=>$post['t_city'], 
						't_dob'=>$post['t_dob'],
						't_gender'=>$post['t_gender'],
						't_country'=>$post['t_country'],
						't_email'=>$post['t_email'], 
						't_academic_year'=>$post['t_academic_year'],
						't_password'=>$post['t_password'],
						't_pc'=>$imagepath, 
						'CountryCode'=>$post['CountryCode'],
						't_phone'=>$post['t_phone'],
						'tc_balance_point'=>$post['tc_balance_point'],
						'tc_used_point'=>$post['tc_used_point'],
						'state'=>$post['state'],
						'balance_blue_points'=>$post['balance_blue_points'], 
						'water_point'=>$post['water_point'],
						'used_blue_points'=>$post['used_blue_points'],
						'brown_point'=>$post['brown_point'],
						'school_type'=>$post['school_type'],
						'group_status'=>$post['group_status'],
						'group_type'=>$group_type
						 );
                     
				$posts[] = $data;
	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
                
				//$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103'");
		       $arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103' ORDER BY `RowID` DESC  limit 1");
			   $result_arr = mysql_fetch_assoc($arr);
			   
			   if (mysql_num_rows($arr) == 0)
				{
								$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`,`school_id`)
							     VALUES ('$t_row_id','103','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$country_code','$College_Code')");
																			
								
				}
				else
				{
					$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`,`school_id`)
							     VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$country_code','$College_Code')");

					//$LoginStatus = mysql_query("insert into `tbl_LoginStatus` (`LatestLoginTime`,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode) values ('$LatestLoginTime''$LatestMethod','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode');
					if($result_arr['LogoutTime']=='')
					{
					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$t_row_id' and Entity_type='103' and RowID=".$result_arr['RowID']." ");
					}					
				}	
                //$activity_log=mysql_query("INSERT INTO `tbl_ActivityLog` //(EntityID,Entity_type,EntitySubType,Timestamp,Activity,CountryCode)
                //    values ('$t_row_id','103','$entity_type','$date','$activity','$country_code')");




  }
  else if($count > 1)
  {

                $postvalue['responseStatus']=409;
				$postvalue['responseMessage']="conflict";
				$postvalue['posts']=null;

  }
  else 
  {

                $postvalue['responseStatus']=1002;
				$postvalue['responseMessage']="No Record Found";
				$postvalue['posts']=null;

  }
  /* output in necessary format */
  if($format == 'json') {
   					 header('Content-type: application/json');
   					 echo json_encode($postvalue);
  }
  else {
    //header('Content-type: text/xml');
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