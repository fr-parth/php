<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default

include 'conn.php';
  

$arr = mysql_query("select id,school_id from `tbl_student` where (std_email = '".$obj->{'User_email'}."' AND  school_id = '$school_id') or id = '".$obj->{'User_Meid'}."'");

  $row = mysql_fetch_array($arr);
  $count = mysql_num_rows($arr);
  if($count == 1)
  {
  $id = $row['id'];
  $school_id = $row['school_id'];
  if($obj->{'User_imagebase64'}!='' and $obj->{'User_Image'}!='')	{
  $imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'};
  $ex_img = explode(".",$img);
  
  // Start SMC-3450 Modify By Pravin 2018-09-18 07:20 PM 
  //$img_name = $ex_img[0]."_".$id."_".date('mdY');  
  $img_name = $ex_img[0]."_".$id."_".date('Ymd'); 
  //End SMC-3450
  
  $full_name_path = "student_image/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);	
  $student_name = $obj->{'User_FName'}." ".$obj->{'User_fathername'}." ".$obj->{'User_LName'};
 
  
  
	//$imageName = "image/".$obj->{'User_Image'};
  $imageSave = imagejpeg($source,$imageName,100);	
  }
  $std_dept=$obj->{'User_department'};
  $std_branch=$obj->{'User_branch'};
	  $std_semester=$obj->{'User_semester'};
  $country_code=$obj->{'country_code'};
	$User_age=$obj->{'User_age'};
	$password=$obj->{'User_password'};
  if($User_age=='')
	  {
		  $User_age='0';
	  }
	  else
	  {
		  $User_age;
	  }
 if($obj->{'User_imagebase64'}!='' and $obj->{'User_Image'}!='')
	 {
		$test = mysql_query("update `tbl_student` set std_complete_name = '$student_name', std_name ='".$obj->{'User_FName'}."',std_lastname ='".$obj->{'User_LName'}."',std_Father_name = '".$obj->{'User_fathername'}."', std_dob = '".$obj->{'User_dob'}."', std_age = '$User_age', std_school_name = '".$obj->{'User_schoolname'}."',country_code='$country_code',std_dept='$std_dept',std_branch='$std_branch',std_semester='$std_semester', std_class = '".$obj->{'User_class'}."', std_address = '".$obj->{'User_address'}."', std_city = '".$obj->{'User_city'}."', std_country = '".$obj->{'User_country'}."',std_state = '".$obj->{'state'}."', std_gender = '".$obj->{'User_gender'}."', std_div = '".$obj->{'User_div'}."', std_hobbies = '".$obj->{'User_hobbies'}."', std_classteacher_name = '".$obj->{'User_classteachername'}."', std_img_path = '$full_name_path', std_email = '".$obj->{'User_email'}."',std_phone = '".$obj->{'User_Phone'}."',std_username = '".$obj->{'User_username'}."', std_date = '".$obj->{'User_date'}."'  where id ='$id' or (std_email = '".$obj->{'User_email'}."' AND  school_id = '$school_id')");

	}
 else
 {
$test = mysql_query("update `tbl_student` set std_complete_name = '$student_name', std_name ='".$obj->{'User_FName'}."',std_lastname ='".$obj->{'User_LName'}."',std_Father_name = '".$obj->{'User_fathername'}."', std_dob = '".$obj->{'User_dob'}."', std_age = '$User_age', std_school_name = '".$obj->{'User_schoolname'}."',country_code='$country_code',std_dept='$std_dept',std_branch='$std_branch',std_semester='$std_semester', std_class = '".$obj->{'User_class'}."', std_address = '".$obj->{'User_address'}."', std_city = '".$obj->{'User_city'}."', std_country = '".$obj->{'User_country'}."',std_state = '".$obj->{'state'}."', std_gender = '".$obj->{'User_gender'}."', std_div = '".$obj->{'User_div'}."', std_hobbies = '".$obj->{'User_hobbies'}."', std_classteacher_name = '".$obj->{'User_classteachername'}."', std_email = '".$obj->{'User_email'}."',std_phone = '".$obj->{'User_Phone'}."',std_username = '".$obj->{'User_username'}."', std_date = '".$obj->{'User_date'}."'  where id = '$id' or (std_email = '".$obj->{'User_email'}."' AND school_id = '$school_id')");	 
 }
 
 //mysql_close($con);
$posts[]="successfully updated";

if($password != '')
	{
		$test = mysql_query("update `tbl_student` set std_password = '$password' where id = $id and school_id = '$school_id'");
	}
		
		if($test)
			{

				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
			}

  }
  else
  {
  	$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
  }
  //
  //$posts = array($json);
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
  
	mysql_close($con);
	
	
		
  ?>