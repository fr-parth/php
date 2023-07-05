<?php
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));
error_reporting(0);
//$json = file_get_contents('php://input');
//$obj = json_decode($json);
//print_r($json);
 $User_Name = $_GET['User_Name'];
 $User_Type =$_GET['User_Type'];
 $school_id =$_GET['school_id'];



  
   include 'conn.php';
   
 

  $date = date('d-m-Y H:i:s');




if($User_Type=='MemberId' and $User_Name !="")
{
		//$condition = "std_email='".$User_Name."'";
		//$inputMemberID=substr($User_Name,1);
		$query = mysql_query("SELECT * FROM  `tbl_student` WHERE id =$User_Name");
}


else if($User_Type=='PRN' and $User_Name != "")
{

	// $condition = "std_PRN='".$User_Name."' and school_id='".$College_Code."'";
	// SELECT * FROM table1 USE INDEX (col1_index,col2_index)
    // WHERE col1=1 AND col2=2 AND col3=3;
	
	$query = mysql_query("SELECT * FROM  `tbl_student`  WHERE std_PRN = '$User_Name'and  school_id='".$school_id."'");
	
}else
{
    $User_Name_id1 = str_replace("M","",$User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');
     //$condition = "id='".$User_Name_id."' and school_id='".$College_Code."'";
	
	$query = mysql_query("SELECT * FROM  `tbl_student` WHERE id='".$User_Name_id."' and   school_id='".$College_Code."'");
}




  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_Name != "" and $User_Type !="" )
		{


           

			
			
           // $query = mysql_query("SELECT * FROM tbl_student where $condition and std_password = '$User_Pass'");
		   
            $posts = array();

            if(mysql_num_rows($query)==1)
             {


                                        while($post = mysql_fetch_assoc($query))
                                       {

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

                	            $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="OK";
                				$postvalue['posts']=$posts;
                                $postvalue['posts1']=$posts1;





                    $arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='105'");
    		        if(mysql_num_rows($arr)==0)

    	        	{
                         $login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails,                                                             FirstPlatformOS,FirstIPAddress,FirstLatitude,
                                            FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,                                                LatestLongitude,CountryCode,school_id)
                                            values ('$std_row_id','105',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date',
                                            '$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code','$sch_id')");



                    }
                    else{

                                $test = mysql_query("update `tbl_LoginStatus` set `LatestLoginTime` = '$date',LatestMethod='$method',
                                LatestDeviceDetails='$device_details',LatestPlatformOS='$platform_OS',LatestIPAddress='$ip_add',LatestLatitude='$lat',LatestLongitude='$long',CountryCode='$country_co'
								,school_id='$sch_id',LogoutTime=''
                                  where EntityID='$std_row_id' and Entity_type='105'");

                    }
                    // $activity_log=mysql_query("INSERT INTO `tbl_ActivityLog` //(EntityID,Entity_type,EntitySubType,Timestamp,Activity,CountryCode)
                      //  values ('$std_row_id','105','$entity_type','$date','$activity','$country_code')");





            }
            else
            {

                        $postvalue['responseStatus']=409;
          				$postvalue['responseMessage']="conflict $User_Name $User_Type $school_id";
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