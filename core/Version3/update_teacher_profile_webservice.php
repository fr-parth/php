<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default

include 'conn.php';
  
  $key = $obj->{'key'};
  
 if($key!='' )
{
  
  if($obj->{'key'}=='Email')
	  {
		  $nik ="select id from `tbl_teacher` where t_email = '".$obj->{'User_email'}."'";
			$arr = mysql_query($nik);
	  }
  if($obj->{'key'}=='member-id')
	  {
			$arr = mysql_query("select id from `tbl_teacher` where id = '".$obj->{'User_Meid'}."'");
	  }
  if($obj->{'key'}=='phone-number')
	  {
			$arr = mysql_query("select id from `tbl_teacher` where 	User_Phone = '".$obj->{'User_Phone'}."' and CountryCode= '".$obj->{'CountryCode'}."'");
	  }
  if($obj->{'key'}=='employee-id')
	  {
			$arr = mysql_query("select id from `tbl_teacher` where t_id = '".$obj->{'employee_id'}."' and  school_id= '".$obj->{'school_id'}."'");
	  }
  $count = mysql_num_rows($arr);
  $row = mysql_fetch_array($arr);
  
  
  if($count == 1)
  {

  $id = $row['id'];
    if($obj->{'User_imagebase64'}!='' and $obj->{'User_Image'}!='')
		{

  
  $imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'};
  $ex_img = explode(".",$img);
  $img_name = $ex_img[0]."_".$id."_".date('mdY');
  $full_name_path = "Images/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  //if($obj->{'User_Image'}!='')
  //{
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);
   
  $teacher_name = $obj->{'User_FName'}." ".$obj->{'User_LName'}; 
	//$imageName = "image/".$obj->{'User_Image'};
  $imageSave = imagejpeg($source,$imageName,100);
  }
//  $std_dept=$obj->{'User_department'};
  //$std_branch=$obj->{'User_branch'};
	 // $std_semester=$obj->{'User_semester'};
  //$country_code=$obj->{'country_code'};

  
  if($obj->{'key'}=='Email')
	  {
		  $jay = 1;
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '".$obj->{'User_Complete_Name'}."', t_name ='".$obj->{'User_FName'}."',t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$full_name_path',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' , CountryCode = '".$obj->{'CountryCode'}."'  where t_email = '".$obj->{'User_email'}."'");
	  }
  if($obj->{'key'}=='member-id')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '".$obj->{'User_Complete_Name'}."', t_name ='".$obj->{'User_FName'}."',t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$full_name_path',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' , CountryCode = '".$obj->{'CountryCode'}."' where id = '".$obj->{'User_Meid'}."'");
	  }
  if($obj->{'key'}=='phone-number')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '".$obj->{'User_Complete_Name'}."', t_name ='".$obj->{'User_FName'}."',t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$full_name_path',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' where 	t_phone = '".$obj->{'User_Phone'}."' , CountryCode = '".$obj->{'CountryCode'}."'  and CountryCode= '".$obj->{'CountryCode'}."'");
	  }
  if($obj->{'key'}=='employee-id')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '".$obj->{'User_Complete_Name'}."', t_name ='".$obj->{'User_FName'}."',t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$full_name_path',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."', CountryCode = '".$obj->{'CountryCode'}."'  where t_id = '".$obj->{'employee_id'}."' and  school_id= '".$obj->{'school_id'}."'");
	  }
  
  
  

mysql_close($con);
$posts[]="successfully updated";
$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK $jay ueuwgu"; 
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
  
	@mysql_close($con);
	
	
	
		
  ?>