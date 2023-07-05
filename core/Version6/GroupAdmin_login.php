<?php
/*Created by Rutuja Jori for SMC-4811 on 04-09-2020*/
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

//print_r($json);
  $User_Name = xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
  $User_Pass = xss_clean(mysql_real_escape_string($obj->{'User_Pass'}));
  $User_Type = xss_clean(mysql_real_escape_string($obj->{'User_Type'}));
  $group_mnemonic_name = xss_clean(mysql_real_escape_string($obj->{'group_mnemonic_name'}));
  $LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
  $country_code = xss_clean(mysql_real_escape_string($obj->{'country_code'}));
  $LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
  $LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
  $LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
  $LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
  $LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
  $LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
  $LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'browser'}));
  $entity_type_id = xss_clean(mysql_real_escape_string($obj->{'entity_type_id'}));
  
    $date = CURRENT_TIMESTAMP; 
  
$condition = "";
if($User_Type=='Email'){

$condition = "admin_email='".$User_Name."' and  group_mnemonic_name='".$group_mnemonic_name."'";
}
else if($User_Type=='MemberID')
{
  $condition = "id='".$User_Name."'";
  
}
$email = "";

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
    {

  $sql = "SELECT * FROM tbl_cookieadmin where $condition and binary admin_password = '$User_Pass'";

//$query = mysql_query($sql) or die('Errant query:  '.$sql);
$query = mysql_query($sql);
if(!$query){
            $postvalue['responseStatus']=204;
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
                $group_member_id= $post['id'];
                //School count
                $result = mysql_query("SELECT count(school_id) as schoolscount FROM tbl_school_admin where group_member_id='$group_member_id'");

                         $num_rows = mysql_fetch_array($result);
                         
                         if($num_rows['schoolscount']=="")
                         {
                             $school_count= 0;
                         }
                         else
                         {
                             $school_count= $num_rows['schoolscount'];
                         }

                //Teachers count
                $result2 = mysql_query("SELECT COUNT(id) AS total_teachers FROM tbl_teacher where group_member_id='$group_member_id' AND t_emp_type_pid IN (133,134,135,137)");

                    $row2 = mysql_fetch_array($result2);
                    if($row2['total_teachers']=="")
                    {
                        $teacher_count= 0;
                    }
                    else
                    {
                        $teacher_count= $row2['total_teachers'];
                    }

                //Students count
                $result3 = mysql_query("SELECT COUNT(id) AS total_students FROM tbl_student where group_member_id='$group_member_id' ");
                    $row3 = mysql_fetch_array($result3);
                    
                if($row3['total_students']=="")
                {
                    $student_count = 0;
                }
                else
                {
                     $student_count = $row3['total_students'];
                    
                }

                //Sponsors count
                $row4 = mysql_query("select * from tbl_sponsorer");
                        $sponsor_count = mysql_num_rows($row4);
                        
                //Parents Count
                $row5 = mysql_query("select * from tbl_parent where group_status='".$post['group_type']."'");
                    $parent_count = mysql_num_rows($row5);
                    
                //Non-teaching Staff
                $result6 = mysql_query("SELECT COUNT(id) AS NonTeacher FROM tbl_teacher where group_member_id='$group_member_id' AND t_emp_type_pid NOT IN (133,134)");
                $row6 = mysql_fetch_array($result6);
                    
                if($row6['NonTeacher']=="")
                {
                    $nonteacher_count = 0;
                }
                else
                {
                    $nonteacher_count = $row6['NonTeacher'];
                    
                }  

                //Subject count  
                if($post['group_type']=='SPORT' or $post['group_type']=='Sports')
              { 
                $table="tbl_games"; 
              }
              else
              {
                $table="tbl_school_subject";    
              }
              $row7 = mysql_query("select count(id) as count from $table where group_member_id='$group_member_id'");
              $r = mysql_fetch_array($row7);  
              $subject_count =  $r['count'];           
              

            //Student Subject Mapping
            $sql_sp = "select count(stm.group_member_id) as count from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id and stm.group_member_id =sa.group_member_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id where stm.group_member_id ='$group_member_id' order by stm.school_id ";                            
                $row_sp = mysql_query($sql_sp);
                            $count_sp = mysql_fetch_array($row_sp);
                            $subject_mapping_count= $count_sp['count']; 

            
          $posts[] = array(
          
          'school_count'=>$school_count,
          'teacher_count'=>$teacher_count,
          'student_count'=>$student_count,
          'sponsor_count'=>$sponsor_count,
          'parent_count'=>$parent_count,
          'nonteacher_count'=>$nonteacher_count,
          'subject_count'=>$subject_count,
          'subject_mapping_count'=>$subject_mapping_count
          );
                  
      $arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$group_member_id' and Entity_type='113' ORDER BY `RowID` DESC  limit 1");
         $result_arr = mysql_fetch_assoc($arr);
         
         if (mysql_num_rows($arr) == 0)
        {
                $LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`)
                   VALUES ('$group_member_id','113','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$country_code')");
                                      
                
        }
        else
        {
          $LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,FirstBrowser,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`)
                   VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['FirstLoginTime']."','".$result_arr['FirstMethod']."','".$result_arr['FirstDevicetype']."','".$result_arr['FirstDeviceDetails']."','".$result_arr['FirstPlatformOS']."','".$result_arr['FirstIPAddress']."','".$result_arr['FirstLatitude']."','".$result_arr['FirstLongitude']."','".$result_arr['FirstBrowser']."','$LatestBrowser',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$country_code')");

          if($result_arr['LogoutTime']=='')
          {
          $LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$group_member_id' and Entity_type='113' and RowID=".$result_arr['RowID']." ");
          }         
        } 
    $postvalue['responseStatus']=200;
        $postvalue['responseMessage']="OK";
        $postvalue['posts']=$posts;
                   }
    else
      {

        $postvalue['responseStatus']=1000;
        $postvalue['responseMessage']="Invalid Input";
        $postvalue['posts']=null;

      }      
        
        }
        
 //Below code added by Rutuja for inserting Error logs for SMC-4915 on 21-10-2020
 if($postvalue['responseStatus']!=200 )
 {
  
  $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version3/error_log_ws_v1.php';
  $webservice_name = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version6/GroupAdmin_login.php';
  $response_msg = $postvalue['responseMessage'];

  $error_description = '{"Response Message":"'.$response_msg.'","Login Option":"'.$User_Type.'","Password":"'.$User_Pass.'","'.$User_Type.'":"'.$User_Name.'"}';
  
  $app_name = "Group Admin";
  $last_programmer_name = 'Rutuja Jori';

  $data = array('error_type'=>'Login Fails','error_description'=>$error_description,'datetime'=>$date,'app_name'=>$app_name,'webservice_name'=>$webservice_name,'last_programmer_name'=>$last_programmer_name);

  $ch = curl_init($url);
  $data_string = json_encode($data);      
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
  $result = json_decode(curl_exec($ch),true);
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

  @mysql_close($con);

?>