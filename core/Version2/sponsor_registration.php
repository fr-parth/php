<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save
if($obj->{'user_fname'} != '' && $obj->{'user_email'} !='' && $obj->{'user_country'}!='')
{
	include("emailfunction.php");
include 'conn.php';

				$address1=$obj->{'user_address'};
				 $prepAddr = str_replace(' ','+',$address1);
			     $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
			     $output= json_decode($geocode);
			    $lat = $output->results[0]->geometry->location->lat;
				$long = $output->results[0]->geometry->location->lng;
				//calculate current date
				$dates = date('m/d/Y');
				$email=$obj->{'user_email'};
				$pass=$obj->{'user_password'};
				$category=$obj->{'category'};
				$CountryCode = $obj->{'sp_CountryCode'};
				$country = $obj->{'user_country'};
				if($country=='india')
				{
					date_default_timezone_set("Asia/Calcutta");
					$dates = date("Y-m-d h:i:s A");
				}
				else
				{
					date_default_timezone_set("America/Boa_Vista");
					$dates = date("Y-m-d h:i:s A");
				}
  $arr = mysql_query("select id from tbl_sponsorer where sp_email = '".$obj->{'user_email'}."'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {
		 
		  $sponsor_name = $obj->{'User_FName'};
		$test = mysql_query("INSERT INTO `tbl_sponsorer` (sp_name, sp_address, sp_city, sp_country, sp_email, sp_phone, sp_date, sp_occupation, sp_company,sp_website, sp_img_path,  sp_password, register_throught,lat,lon,v_category,sp_date,CountryCode) VALUES('$sponsor_name', '".$obj->{'user_address'}."', '".$obj->{'user_city'}."',  '".$obj->{'user_country'}."', '".$obj->{'user_email'}."', '".$obj->{'user_phone'}."', '$dates', '".$obj->{'user_occupation'}."',  '".$obj->{'user_company'}."', '".$obj->{'user_website'}."', '".$obj->{'user_image'}."' ,  '".$obj->{'user_password'}."', '".$obj->{'user_register_throught'}."','$lat','$long','$category','$dates','')");
		
		$arr1 = mysql_query("select id from `tbl_sponsorer`  where sp_email = '".$obj->{'user_email'}."'");
		$row1 = mysql_fetch_array($arr1);
		$memberid = $row1['id'];
		$member_id= "M".str_pad($memberid,11,"0",STR_PAD_LEFT);
		$post['member_id']=$member_id;
		$posts[]=$post;
		
		
		
		$emailfunction=new emailfunction();
		$to=$email;
	  $type="Sponsor";
		$results=$emailfunction->registrationemail($to,$pass,$type);
		
		
		$id = $row1['id'];
		 $imageDataEncoded=$obj->{'user_imagebase64'};
		 $img = $obj->{'user_image'};
		
		  $ex_img = explode(".",$img);
		  $img_name = $ex_img[0]."_".$id."_".date('mdY');
		  $full_name_path = "image_sponsor/".$img_name.".".$ex_img[1];
		$imageName = "../".$full_name_path;
		  
		  $imageData = base64_decode($imageDataEncoded);
		  $source = imagecreatefromstring($imageData);
			
		  //$imageName = "image/".$obj->{'User_Image'};
		   $imageSave = imagejpeg($source,$imageName,100);		  
		  mysql_query("update `tbl_sponsorer` set sp_img_path = '$full_name_path' where id = $memberid");
		  
 				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
		

		mysql_close($con);
		}
		else
		{
		$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="conflict";
				$postvalue['posts']=null;
		}
		//
		  
			
			header('Content-type: application/json');
			 echo json_encode($postvalue);
			
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