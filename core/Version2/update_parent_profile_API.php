<?php  
//$json=$_GET ['json'];
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

		$p_id=$obj->{'parent_id'};
		$name=$obj->{'user_name'};
		$emailid=$obj->{'User_emailid'};
		$phone=$obj->{'user_phone'};
		$country=$obj->{'user_country'};
		$state=$obj->{'user_state'};
		$city=$obj->{'user_city'};
		$gender=$obj->{'user_gender'};
		$dob=$obj->{'user_dob'};
		$address=$obj->{'user_address'};
		$password=$obj->{'user_password'};
		$qualification=$obj->{'user_qualification'};
		$occupation=$obj->{'user_occupation'};
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
		$img = $obj->{'User_Image'};
		include 'conn.php';
  
   if(!empty($p_id) && !empty($name) && !empty($emailid))
   {
		$arr = mysql_query("select Id from `tbl_parent` where Id='$p_id'");
		if(mysql_num_rows($arr)>=1)
				
		{
		  
		 
			
			
			$test = mysql_query("update `tbl_parent` set Name = '$name', Gender = '$gender', DateOfBirth = '$dob', email_id = '$emailid', Phone = '$phone', country = '$country', 
			Occupation='$occupation',Qualification='$qualification',state='$state',city='$city',country='$country',Password = '$password', Address = '$address',Age='$age' where Id = '$p_id'");
			if(!empty($img))
			{
				
				 $imageDataEncoded=$obj->{'User_Imagebase64'};
				  $ex_img = explode(".",$img);
				  $img_name = $ex_img[0]."_".$p_id."_".date('mdY');
				  $full_name_path = "parent_image/".$img_name.".".$ex_img[1];
				  $imageName = "../".$full_name_path;
				  $imageData = base64_decode($imageDataEncoded);
				  $source = imagecreatefromstring($imageData);
				   $imageSave = imagejpeg($source,$imageName,100);
				 mysql_query("update `tbl_parent` set p_img_path = '$full_name_path' where Id = '$p_id'");
				
				
			}	
		    $postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Parent profile has been updated successfully..";
			header('Content-type: application/json');
			echo  json_encode($postvalue); 

		}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Sorry Unable to update the record..";
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