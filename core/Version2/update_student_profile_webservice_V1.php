<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default

include 'conn.php';
  
  
  $server_name=$_SERVER['SERVER_NAME'];
  $student_name = $obj->{'User_FName'}." ".$obj->{'User_fathername'}." ".$obj->{'User_LName'};
$arr = mysql_query("select id from `tbl_student` where std_email = '".$obj->{'User_email'}."' or id = '".$obj->{'User_Meid'}."'");
  $row = mysql_fetch_array($arr);
  $count = mysql_num_rows($arr);
  if($count == 1)
  {
  $id = $row['id'];
  if($obj->{'User_imagebase64'}!='' and $obj->{'User_Image'}!='')	{
  /*$imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'};
  $ex_img = explode(".",$img);
  $img_name = $ex_img[0]."_".$id."_".date('mdY');
  $full_name_path = "student_image/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);	
  
	$imageName = "image/".$obj->{'User_Image'};*/

	$sc_id= $obj->{'school_id'};
  
			  $imageDataEncoded=$obj->{'User_imagebase64'};
			  $image = $obj->{'User_Image'};
  
				$filename = $_FILES['filUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$img= $_FILES['filUpload']['name'];
						$ex_img = explode(".",$image);
						 $img_name = $ex_img[0].".".$ex_img[1];
				 
						$year=date('Y');
						$entity="Student";
						$start_dir="Images";
						$full_name_path=$start_dir.'/'.$sc_id.'/'.$entity.'/'.$sc_id.'_';
						if(!file_exists($full_name_path))
						{
							mkdir($full_name_path, 0777, true);
						}
					
					$filenm=$full_name_path.$img_name;
				 
					move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);				
			  $imageData = base64_decode($imageDataEncoded);
			  $source = imagecreatefromstring($imageData);
			$imageSave = imagejpeg($source,$imageName,100);
		
  }
  $std_dept=$obj->{'User_department'};
  $std_branch=$obj->{'User_branch'};
	  $std_semester=$obj->{'User_semester'};
  $country_code=$obj->{'country_code'};
	$User_age=$obj->{'User_age'};
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
		$test = mysql_query("update `tbl_student` set std_complete_name = '$student_name', std_name ='".$obj->{'User_FName'}."',std_lastname ='".$obj->{'User_LName'}."',std_Father_name = '".$obj->{'User_fathername'}."', std_dob = '".$obj->{'User_dob'}."', std_age = '$User_age', std_school_name = '".$obj->{'User_schoolname'}."',country_code='$country_code',std_dept='$std_dept',std_branch='$std_branch',std_semester='$std_semester', std_class = '".$obj->{'User_class'}."', std_address = '".$obj->{'User_address'}."', std_city = '".$obj->{'User_city'}."', std_country = '".$obj->{'User_country'}."',std_state = '".$obj->{'state'}."', std_gender = '".$obj->{'User_gender'}."', std_div = '".$obj->{'User_div'}."', std_hobbies = '".$obj->{'User_hobbies'}."', std_classteacher_name = '".$obj->{'User_classteachername'}."', std_img_path = '$filenm', std_email = '".$obj->{'User_email'}."',std_phone = '".$obj->{'User_Phone'}."',std_username = '".$obj->{'User_username'}."', std_password = '".$obj->{'User_password'}."', std_date = '".$obj->{'User_date'}."'  where id = '".$obj->{'User_id'}."' or std_email = '".$obj->{'User_email'}."'");

	}
 else
 {
$test = mysql_query("update `tbl_student` set std_complete_name = '$student_name', std_name ='".$obj->{'User_FName'}."',std_lastname ='".$obj->{'User_LName'}."',std_Father_name = '".$obj->{'User_fathername'}."', std_dob = '".$obj->{'User_dob'}."', std_age = '$User_age', std_school_name = '".$obj->{'User_schoolname'}."',country_code='$country_code',std_dept='$std_dept',std_branch='$std_branch',std_semester='$std_semester', std_class = '".$obj->{'User_class'}."', std_address = '".$obj->{'User_address'}."', std_city = '".$obj->{'User_city'}."', std_country = '".$obj->{'User_country'}."',std_state = '".$obj->{'state'}."', std_gender = '".$obj->{'User_gender'}."', std_div = '".$obj->{'User_div'}."', std_hobbies = '".$obj->{'User_hobbies'}."', std_classteacher_name = '".$obj->{'User_classteachername'}."', std_email = '".$obj->{'User_email'}."',std_phone = '".$obj->{'User_Phone'}."',std_username = '".$obj->{'User_username'}."', std_password = '".$obj->{'User_password'}."', std_date = '".$obj->{'User_date'}."'  where id = '".$obj->{'User_id'}."' or std_email = '".$obj->{'User_email'}."'");	

 }
 
$sql=mysql_query("select id, school_id, std_complete_name, std_name, std_Father_name, std_lastname, std_address, std_dob, std_age, std_school_name, std_dept, std_branch, std_semester, std_class, std_div, std_city, std_country, std_state, std_phone, std_password, country_code, std_email, std_img_path, std_gender from tbl_student where  id = '$id'");

$result=mysql_fetch_array($sql);



$img=$result['std_img_path'];
  
						if($img!="")
						 {
							$imagepath="https://".$server_name."/core/".$img;
						 }
						else
						{
							$imagepath="https://".$server_name."/Assets/images/avatar/avatar_2x.png";
						}

$data=array(

"id"=>$result['id'],
"school_id"=>$result['school_id'],
"std_name"=>$result['std_name'],
"std_lastname"=>$result['std_lastname'],
"std_Father_name"=>$result['std_Father_name'],
"std_complete_name"=>$result['std_complete_name'],
"std_address"=>$result['std_address'],
"std_dob"=>$result['std_dob'],
"std_age"=>$result['std_age'],
"std_school_name"=>$result['std_school_name'],
"std_dept"=>$result['std_dept'],
"std_branch"=>$result['std_branch'],
"std_semester"=>$result['std_semester'],
"std_class"=>$result['std_class'],
"std_div"=>$result['std_div'],
"std_city"=>$result['std_city'],
"std_country"=>$result['std_country'],
"std_state"=>$result['std_state'],
"std_phone"=>$result['std_phone'],
"std_password"=>$result['std_password'],
"country_code"=>$result['country_code'],
"std_email"=>$result['std_email'],
"std_gender"=>$result['std_gender'],
"std_img_path"=>$imagepath
);
$posts[]=$data;
$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;


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