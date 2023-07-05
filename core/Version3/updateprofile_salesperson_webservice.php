<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;

//Save

include 'conn.php';

  $p_name=xss_clean(mysql_real_escape_string($obj->{'p_name'}));
  $p_email=xss_clean(mysql_real_escape_string($obj->{'p_email'}));
  $p_password=xss_clean(mysql_real_escape_string($obj->{'p_password'}));
  $p_phone=xss_clean(mysql_real_escape_string($obj->{'p_phone'}));
  
$p_id=xss_clean(mysql_real_escape_string($obj->{'p_id'}));

  $arr = mysql_query("select person_id from `tbl_salesperson` where (p_email ='$p_email' or p_phone = '$p_phone') and person_id='$p_id'");
  $row = mysql_fetch_array($arr);
  $count = mysql_num_rows($arr);
  if($count == 1)
  {
  $id = $row['person_id'];
  
  
   $imageDataEncoded=$obj->{'User_imagebase64'};
		 $img = $obj->{'User_Image'};
		  $ex_img = explode(".",$img);
		  $img_name = $ex_img[0]."_".$id."_".date('Ymd');//SMC-3487
		  $full_name_path = "salesapp_image/".$img_name.".".$ex_img[1];
		$imageName = "../".$full_name_path;
		  
		  $imageData = base64_decode($imageDataEncoded);
		  $source = imagecreatefromstring($imageData);
			
		  //$imageName = "image/".$obj->{'User_Image'};
		   $imageSave = imagejpeg($source,$imageName,100);
 

$test = mysql_query("update tbl_salesperson set p_name='$p_name',p_email='$p_email', p_password='$p_password', p_phone='$p_phone', p_image = '$full_name_path' where person_id='$id'");
mysql_close($con);
$test="Record successfully Updated";


  }
  else
  {
  	$test = "Record not found";
  }
  //
  //$posts = array($json);
  $posts = array($test);
  header('Content-type: application/json');
  echo json_encode(array('posts'=>$posts)); 
	
	
		
  ?>