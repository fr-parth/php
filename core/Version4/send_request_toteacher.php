<?php  
error_reporting(0);
//include('../function.php');
//include('../config.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include '../conn.php';

	$date=CURRENT_TIMESTAMP;
	//input from user
	
    $stud_id = xss_clean(mysql_real_escape_string($obj->{'stud_id'}));
	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$activity_type = xss_clean(mysql_real_escape_string($obj->{'activity_type'}));
	
	if($activity_type==1)
	{
		$type="activity";
	}
	if($activity_type==2)
	{
		$type="subject";
	}
	if($activity_type==3)
	{
		$type="Innovation Cell";
	}
	if($activity_type==4)
	{
		$type="event";
	}
	
	$reason = xss_clean(mysql_real_escape_string($obj->{'reason'}));
	$points = xss_clean(mysql_real_escape_string($obj->{'points'}));
	$sender_entity = xss_clean(mysql_real_escape_string($obj->{'sender_entity'}));
	$receiver_entity = xss_clean(mysql_real_escape_string($obj->{'receiver_entity'}));
	//new parameter student_comment added by Pranali for SMC-3810 on 26-3-19
	$student_comment = xss_clean(mysql_real_escape_string($obj->{'student_comment'}));
	$achievement_id =xss_clean(mysql_real_escape_string($obj->{'achievement_id'}));
	$imageDataEncoded = xss_clean(mysql_real_escape_string($obj->{'imagebase64'}));
	
	if($imageDataEncoded!='')
		{
			$PlantIDq=mysql_query("SELECT id from tbl_request order by id desc limit 1");
			$PlantID1=mysql_fetch_row($PlantIDq);
			$plantID=$PlantID1[0];
			$plantID=$plantID+1; 
		//upload image in smartcookie/Images folder 
			//$CurrentYear=date("Y");
			//$Currentmonth=date("m");

			$full_name_path='../../images/Activity_Image/';

			//if path ($full_name_path) does not exist then create path
				if(!file_exists($full_name_path))
				{
					 mkdir($full_name_path, 0777, true);
				}
				//extract name of image
				$ex_img = explode(".",$image);
				$img_name = $ex_img[0].".".$ex_img[1];
				
				//rand() used for generating random number for image name
				$randno=rand();
			
				$image=$randno."_".$plantID."."."jpg";
				$insertpath="images/Activity_Image/".$randno."_".$plantID."."."jpg";


			
				$filenm=$full_name_path.$randno."_".$plantID."."."jpg";
				

				 $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded));
				 file_put_contents($filenm, $imageDataEncoded);
		}
	
    if($stud_id!="" && $t_id!="" && $reason!="" && $points!="" && $activity_type!="" && $student_comment!="" && $sender_entity!="" && $receiver_entity!="")
	{	

		$sql=mysql_query("select * from tbl_request where stud_id1='$stud_id' and stud_id2='$t_id' AND school_id='$school_id' and reason like '$reason' and flag='N' and requestdate='$date' and  points='$points' and entitity_id='$receiver_entity' and entitity_id1='$sender_entity' and activity_type='$type' and student_comment='$student_comment'");
		
		$count=mysql_num_rows($sql);
		
		if($count==0)
		{		
			//$student_comment inserted into tbl_request by Pranali for SMC-3810 on 26-3-19	
			$arr = mysql_query("insert into tbl_request(stud_id1,stud_id2,requestdate,points,reason,flag,entitity_id,entitity_id1,activity_type,school_id,student_comment,achievement_id,activity_image) values('$stud_id','$t_id','$date','$points','$reason','N','$receiver_entity','$sender_entity','$type','$school_id','$student_comment','$achievement_id','$image')");
		
			if($arr)
			{
				$report="Request Sent Successfully";
				$posts[]=array('report'=>$report);	
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
			}
			else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Record Not Inserted";
				$postvalue['posts']=null;
			}
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		}
				
		if($format == 'json') 
		{
			header('Content-type: application/json');
			echo json_encode($postvalue);
		}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	  
		header('Content-type: application/json');
		echo  json_encode($postvalue);  
	}	
	
	  
  /* disconnect from the db */
  @mysql_close($con);	
	
		
  ?>
