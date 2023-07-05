<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default

include 'conn.php';
  $server_name=$_SERVER['SERVER_NAME'];
  $key = $obj->{'key'};
 $t_complete_name=$obj->{'User_FName'}." ".$obj->{'User_MName'}." ".$obj->{'User_LName'}; 
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
			 $sc_id= $obj->{'school_id'};
  
			  $imageDataEncoded=$obj->{'User_imagebase64'};
			  $image = $obj->{'User_Image'};
  
				$filename = $_FILES['filUpload']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
					$img= $_FILES['filUpload']['name'];
						$ex_img = explode(".",$image);
						 $img_name = $ex_img[0].".".$ex_img[1];
				 
						$year=date('Y');
						$entity="Teacher";
						$start_dir="Images";
						$full_name_path=$start_dir.'/'.$sc_id.'/'.$entity.'/'.$sc_id.'_';
						if(!file_exists($full_name_path))
						{
							mkdir($full_name_path, 0777, true);
						}
					
					$filenm=$full_name_path."".$img_name;
				 
					move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);				
			  $imageData = base64_decode($imageDataEncoded);
			  $source = imagecreatefromstring($imageData);
			$imageSave = imagejpeg($source,$imageName,100);
  }


  if($obj->{'key'}=='Email')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name', t_name ='".$obj->{'User_FName'}."' , t_middlename='".$obj->{'User_MName'}."' ,t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$filenm',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' , CountryCode = '".$obj->{'CountryCode'}."'  where t_email = '".$obj->{'User_email'}."'");
	  }
  if($obj->{'key'}=='member-id')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name', t_name ='".$obj->{'User_FName'}."' , t_middlename='".$obj->{'User_MName'}."' ,t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$filenm',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' , CountryCode = '".$obj->{'CountryCode'}."' where id = '".$obj->{'User_Meid'}."'");
	  }
  if($obj->{'key'}=='phone-number')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name', t_name ='".$obj->{'User_FName'}."' , t_middlename='".$obj->{'User_MName'}."',t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$filenm',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."' where 	t_phone = '".$obj->{'User_Phone'}."' , CountryCode = '".$obj->{'CountryCode'}."'  and CountryCode= '".$obj->{'CountryCode'}."'");
	  }
  if($obj->{'key'}=='employee-id')
	  {
			$test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name',t_name ='".$obj->{'User_FName'}."' , t_middlename='".$obj->{'User_MName'}."' ,t_lastname ='".$obj->{'User_LName'}."', t_dob = '".$obj->{'User_dob'}."', t_address = '".$obj->{'User_address'}."', t_city = '".$obj->{'User_city'}."', t_country = '".$obj->{'User_country'}."',state = '".$obj->{'state'}."', t_gender = '".$obj->{'User_gender'}."',t_pc = '$filenm',	t_phone = '".$obj->{'User_Phone'}."', t_password = '".$obj->{'User_password'}."', CountryCode = '".$obj->{'CountryCode'}."'  where t_id = '".$obj->{'employee_id'}."' and  school_id= '".$obj->{'school_id'}."'");
	  }
  
  if($key!='' )
{
  
  if($obj->{'key'}=='Email')
	  {
		  $nik ="select * from `tbl_teacher` where t_email = '".$obj->{'User_email'}."'";
			$arr = mysql_query($nik);
	  }
  if($obj->{'key'}=='member-id')
	  {
			$arr = mysql_query("select * from `tbl_teacher` where id = '".$obj->{'User_Meid'}."'");
	  }
  if($obj->{'key'}=='phone-number')
	  {
			$arr = mysql_query("select * from `tbl_teacher` where 	User_Phone = '".$obj->{'User_Phone'}."' and CountryCode= '".$obj->{'CountryCode'}."'");
	  }
  if($obj->{'key'}=='employee-id')
	  {
			$arr = mysql_query("select * from `tbl_teacher` where t_id = '".$obj->{'employee_id'}."' and  school_id= '".$obj->{'school_id'}."'");
	  }
$row1 = mysql_fetch_array($arr);
						$img=$row1['t_pc'];
						if($img=="")
						 {
							$imagepath="https://".$server_name."/Assets/images/avatar/avatar_2x.png";
						 }
						else
						{
							$imagepath="https://".$server_name."/core/".$img;
							
						}

//$posts[]="successfully updated";
$data=array(
"id"=>$row1['id'],
"t_complete_name"=>$row1['t_complete_name'],
"t_name"=>$row1['t_name'],
"t_middlename"=>$row1['t_middlename'],
"t_lastname"=>$row1['t_lastname'],
"t_address"=>$row1['t_address'],
"t_dob"=>$row1['t_dob'],
"t_city"=>$row1['t_city'],
"t_country"=>$row1['t_country'],
"state"=>$row1['state'],
"t_phone"=>$row1['t_phone'],
"t_password"=>$row1['t_password'],
"CountryCode"=>$row1['CountryCode'],
"t_email"=>$row1['t_email'],
"t_pc"=>$imagepath

);
$posts[]= $data;
$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK"; 
				$postvalue['posts']=$posts;

}
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