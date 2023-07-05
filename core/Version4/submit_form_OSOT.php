<?php 
include '../conn.php';
 $json = file_get_contents('php://input');
 $obj = json_decode($json);
 $format = 'json';

  $institude_id = xss_clean(mysql_real_escape_string($obj->{'institude_id'}));
  $institude_name = xss_clean(mysql_real_escape_string($obj->{'institude_name'}));
  $student_name = xss_clean(mysql_real_escape_string($obj->{'student_name'}));
  $student_email = xss_clean(mysql_real_escape_string($obj->{'student_email'}));
  $phone_no  = xss_clean(mysql_real_escape_string($obj->{'phone_no'}));
  $student_prn = xss_clean(mysql_real_escape_string($obj->{'student_prn'}));
  $planted_tree = xss_clean(mysql_real_escape_string($obj->{'planted_tree'}));
  $state = xss_clean(mysql_real_escape_string($obj->{'state'}));
$entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
$gender = xss_clean(mysql_real_escape_string($obj->{'gender'}));
 $project = xss_clean(mysql_real_escape_string($obj->{'project'})); 
 $geo_lat = xss_clean(mysql_real_escape_string($obj->{'geo_lat'}));
  $geo_long = xss_clean(mysql_real_escape_string($obj->{'geo_long'}));
  $imageDataEncoded = xss_clean(mysql_real_escape_string($obj->{'imagebase64'}));
 $date=CURRENT_TIMESTAMP;
 $query1 = mysql_query("SELECT * FROM tbl_project_event WHERE project_id='$project'");
			$result1=mysql_fetch_array($query1);
			$id1=$result1['id']; 
	//$image="OSOT_plantImage.png";
  $imageDataEncoded = xss_clean(mysql_real_escape_string($obj->{'imagebase64'}));
$temp=0;  
if($entity_id=='105')
{

	  if($institude_id!='' && ($student_prn!='' || $student_email!='' || $phone_no!=''))
	  {
				$query = mysql_query("SELECT * FROM tbl_student WHERE std_PRN='$student_prn' and school_id='$institude_id'");
				$result=mysql_fetch_array($query);
				$id=$result['id'];

				$count = mysql_num_rows($query);
				
				if($count > 0)
				{ //echo "std_PRN"; exit;
					$temp=1;
				}
				else if($count == 0)
				{
						$query = mysql_query("SELECT * FROM tbl_student WHERE std_email='$student_email' and school_id='$institude_id'");
						$result=mysql_fetch_array($query);
						$id=$result['id'];
						
						$count = mysql_num_rows($query);
					
						if($count > 0)
						{// echo "student_email"; exit;
							$temp=1; 
						}
						else if($count == 0)
						{ 
								$query = mysql_query("SELECT * FROM tbl_student WHERE std_phone='$phone_no' and school_id='$institude_id'");
								$result=mysql_fetch_array($query);
								$id=$result['id'];
								
								$count = mysql_num_rows($query); 
							
								if($count > 0)
								{ //echo "phone_no"; exit;
									$temp=1;	
								}
								else if($count == 0)
								{	
									$query = mysql_query("INSERT INTO tbl_student (std_PRN,std_complete_name,std_school_name,school_id,std_gender,std_email,std_phone,std_state,upload_date) VALUES ('$student_prn','$student_name','$institude_name','$institude_id','$gender','$student_email','$phone_no','$state','$date')");	
								}
								
						}

				//$count = mysql_num_rows($query);
				}
				if($temp==1)
				{ 
					$sql=mysql_query("update tbl_student set std_PRN='$student_prn',std_complete_name='$student_name', std_school_name='$institude_name', school_id='$institude_id', std_gender='$gender', std_email='$student_email', std_phone='$phone_no', std_state='$state', upload_date='$date' where id='$id'");
						
				}	
				
			
		if($imageDataEncoded!='')
		{
			$PlantIDq=mysql_query("SELECT id from tbl_student_project_transaction order by id desc limit 1");
			$PlantID1=mysql_fetch_row($PlantIDq);
			$plantID=$PlantID1[0];
			$plantID=$plantID+1; 
		//upload image in smartcookie/Images folder 
			$CurrentYear=date("Y");
			$Currentmonth=date("m");

			$full_name_path='../../images/project/'.$CurrentYear.'/'.$Currentmonth.'/';

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

				$insertpath="images/project/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$plantID."."."jpg";


			
				$filenm=$full_name_path.$randno."_".$plantID."."."jpg";
				

				 $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded));
				 file_put_contents($filenm, $imageDataEncoded);
		}
			

			$insert=mysql_query("INSERT INTO tbl_student_project_transaction(std_PRN,std_member_id ,school_id,project_id ,date_time,geo_lat,geo_long,object_photo,entity_id) VALUES('$student_prn','$std_member_id','$institude_id','$id1','$date','$geo_lat','$geo_long','$image','$entity_id')");

			if($insert)
			{
				//echo "tiii"; exit;
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']="Plant added successfully";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
			}
			else
			{
			$postvalue['responseStatus']=204;
			$postvalue['posts']="Plant not added";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
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
}
else if($entity_id=='103')
{
		if($institude_id!='' && ($student_prn!='' || $student_email!='' || $phone_no!=''))
	  {
				$query = mysql_query("SELECT * FROM tbl_teacher WHERE t_id='$student_prn' and school_id='$institude_id'");
				$result=mysql_fetch_array($query);
				$id=$result['id'];

				$count = mysql_num_rows($query);
				
				if($count > 0)
				{ //echo "std_PRN"; exit;
					$temp=1;
				}
				else if($count == 0)
				{
						$query = mysql_query("SELECT * FROM tbl_teacher WHERE t_email='$student_email' and school_id='$institude_id'");
						$result=mysql_fetch_array($query);
						$id=$result['id'];
						
						$count = mysql_num_rows($query);
					
						if($count > 0)
						{ //echo "student_email"; exit;
							$temp=1; 
						}
						else if($count == 0)
						{ 
								$query = mysql_query("SELECT * FROM tbl_teacher WHERE t_phone='$phone_no' and school_id='$institude_id'");
								$result=mysql_fetch_array($query);
								$id=$result['id'];
								
								$count = mysql_num_rows($query); 
							
								if($count > 0)
								{ //echo "phone_no"; exit;
									$temp=1;	
								}
								else if($count == 0)
								{	//echo "insert"; exit;
									$query = mysql_query("INSERT INTO tbl_teacher (t_id,t_complete_name,t_current_school_name,school_id,t_gender,t_email,t_phone,state,created_on) VALUES ('$student_prn','$student_name','$institude_name','$institude_id','$gender','$student_email','$phone_no','$state','$date')");	
								}
								
						}

				//$count = mysql_num_rows($query);
				}
				if($temp==1)
				{ //echo "update"; exit;
					$sql=mysql_query("update tbl_teacher set t_id='$student_prn',t_complete_name='$student_name', t_current_school_name='$institude_name', school_id='$institude_id', t_gender='$gender', t_email='$student_email', t_phone='$phone_no', state='$state', created_on='$date' where id='$id'");
						
				}	
				
			
		if($imageDataEncoded!='')
		{
			$PlantIDq=mysql_query("SELECT id from tbl_student_project_transaction order by id desc limit 1");
			$PlantID1=mysql_fetch_row($PlantIDq);
			$plantID=$PlantID1[0];
			$plantID=$plantID+1; 
		//upload image in smartcookie/Images folder 
			$CurrentYear=date("Y");
			$Currentmonth=date("m");

			$full_name_path='../../images/project/'.$CurrentYear.'/'.$Currentmonth.'/';

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

				$insertpath="images/project/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$plantID."."."jpg";


			
				$filenm=$full_name_path.$randno."_".$plantID."."."jpg";
				

				 $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded));
				 file_put_contents($filenm, $imageDataEncoded);
		}
			

			$insert=mysql_query("INSERT INTO tbl_student_project_transaction(std_PRN,std_member_id ,school_id,project_id ,date_time,geo_lat,geo_long,object_photo,entity_id) VALUES('$student_prn','$std_member_id','$institude_id','$id1','$date','$geo_lat','$geo_long','$image','$entity_id')");

			if($insert)
			{
				//echo "tiii"; exit;
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']="Plant added successfully";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
			}
			else
			{
			$postvalue['responseStatus']=204;
			$postvalue['posts']="Plant not added";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
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
}
else if($entity_id=='102')
{
	if($institude_id!='')
	  {		
		if($imageDataEncoded!='')
		{
			$PlantIDq=mysql_query("SELECT id from tbl_student_project_transaction order by id desc limit 1");
			$PlantID1=mysql_fetch_row($PlantIDq);
			$plantID=$PlantID1[0];
			$plantID=$plantID+1; 
		//upload image in smartcookie/Images folder 
			$CurrentYear=date("Y");
			$Currentmonth=date("m");

			$full_name_path='../../images/project/'.$CurrentYear.'/'.$Currentmonth.'/';

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

				$insertpath="images/project/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$plantID."."."jpg";


			
				$filenm=$full_name_path.$randno."_".$plantID."."."jpg";
				

				 $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded));
				 file_put_contents($filenm, $imageDataEncoded);
		}
			

			$insert=mysql_query("INSERT INTO tbl_student_project_transaction(std_PRN,std_member_id ,school_id,project_id ,date_time,geo_lat,geo_long,object_photo,entity_id) VALUES('$student_prn','$std_member_id','$institude_id','$id1','$date','$geo_lat','$geo_long','$image','$entity_id')");

			if($insert)
			{
				//echo "tiii"; exit;
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']="Plant added successfully";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
			}
			else
			{
			$postvalue['responseStatus']=204;
			$postvalue['posts']="Plant not added";
			header('Content-type: application/json');
			echo  json_encode($postvalue);
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
}
else
  {
	  	$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	  
		header('Content-type: application/json');
		echo  json_encode($postvalue);
  }	
  ?>