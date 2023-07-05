
<?php 
/*
Author: Pranali Dalvi
Date: 1-3-19
This web service was created to add new blog in smartcookie
*/
include '../conn.php';

 $json = file_get_contents('php://input');
 $obj = json_decode($json);

 $format = 'json';

  $memberId = xss_clean(mysql_real_escape_string($obj->{'memberId'}));
  $entity_Type = xss_clean(mysql_real_escape_string($obj->{'entity_Type'}));
  $name = xss_clean(mysql_real_escape_string($obj->{'name'}));
  $Blog_title  = xss_clean(mysql_real_escape_string($obj->{'Blog_title'}));
  $Description = xss_clean(mysql_real_escape_string($obj->{'Description'}));
  $image = xss_clean(mysql_real_escape_string($obj->{'image'}));
  $imageDataEncoded = xss_clean(mysql_real_escape_string($obj->{'imagebase64'}));
  
  $PRN_TID = xss_clean(mysql_real_escape_string($obj->{'PRN_TID'}));
  $SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));

$activity_id = xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
  
  //define('UPLOAD_DIR', 'blog_image/');
//$data = base64_decode($imageDataEncoded);
//$file = UPLOAD_DIR . uniqid() . '.jpg';
//$success = file_put_contents($file, $data);

  
 



  if($PRN_TID!='' && $SchoolID!='' && $entity_Type!='' && $Blog_title!='' && $Description!='')
  {
		$date=CURRENT_TIMESTAMP;
		
	if($image!='' && $imageDataEncoded!='')
	{
		$BlogID=mysql_query("SELECT BlogID from blog order by BlogID desc limit 1");
		$BlogID1=mysql_fetch_array($BlogID);
		$blogid=$BlogID1['BlogID'];
		$blogid=$blogid+1; //next id for new blog
		
		//Blog Image uploading
		/*$filename = $_FILES['filUpload']['name'];
		//extension of image
		$ext = pathinfo($filename, PATHINFO_EXTENSION);*/
	
	//upload image in smartcookie/Images folder 
		$CurrentYear=date("Y");
		$Currentmonth=date("m");
		

		$full_name_path='../../images/Blog_Images/'.$CurrentYear.'/'.$Currentmonth.'/';

		
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
		//image create path	(blog id appended in the image name)
		//$filepath=$full_name_path.$randno."_".$blogid.".".$ex_img[1];
		//insert path into db


		//$insertpath="images/Blog_Images/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$blogid.".".$ex_img[1]; first time bala
		$insertpath="images/Blog_Images/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$blogid."."."jpg";


		/*create image from string and store in folder at given path
		move_uploaded_file($_FILES['filUpload']['tmp_name'],$filepath);
		$imageData = base64_decode($imageDataEncoded);
		$source = imagecreatefromstring($imageData);
		$imageSave = imagejpeg($source,$filepath,100);*/
		
			 
			 //$ex_img = explode(".",$image);
			// $img_name = "mid_".$member_id."_".date('mdYHi').".jpg";


			 //$filenm=$full_name_path.$randno."_".$blogid.".".$ex_img[1];  first time bala
$filenm=$full_name_path.$randno."_".$blogid."."."jpg";
			// $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded)); first time bala

			 $imageDataEncoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataEncoded));
			 file_put_contents($filenm, $imageDataEncoded);
	}
		

$insert=mysql_query("INSERT INTO blog(BlogTitle,Description,featureimage,MemberID,EntityType,PRN_TID,SchoolID,name, date,activity_id) VALUES('$Blog_title','$Description','$insertpath','$memberId','$entity_Type','$PRN_TID','$SchoolID','$name','$date','$activity_id')");


	  
	  
	    $postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']="Blog added successfully";
		header('Content-type: application/json');
		echo  json_encode($postvalue);
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