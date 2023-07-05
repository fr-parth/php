<?php 
$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

		$sp_id=xss_clean(mysql_real_escape_string(@$obj->{'sp_id'}));
		$sp_company=xss_clean(mysql_real_escape_string(@$obj->{'sp_company'}));
		$sp_occupation=xss_clean(mysql_real_escape_string(@$obj->{'sp_occupation'}));
		$sp_name=xss_clean(mysql_real_escape_string(@$obj->{'sp_name'}));
		$sp_website=xss_clean(mysql_real_escape_string(@$obj->{'sp_website'}));
		$sp_address=xss_clean(mysql_real_escape_string(@$obj->{'sp_address'}));
		$sp_city=xss_clean(mysql_real_escape_string(@$obj->{'sp_city'}));
		$sp_state=xss_clean(mysql_real_escape_string(@$obj->{'sp_state'}));
		$sp_country=xss_clean(mysql_real_escape_string(@$obj->{'sp_country'}));
		$sp_email=xss_clean(mysql_real_escape_string(@$obj->{'sp_email'}));
		$sp_phone=xss_clean(mysql_real_escape_string(@$obj->{'sp_phone'}));	
		
		$User_Image=@$obj->{'User_Image'};		

		$img = $obj->{'User_Image'};  
  
		$imageDataEncoded=$obj->{'User_imagebase64'};
 
		$sp_password=xss_clean(mysql_real_escape_string(@$obj->{'sp_password'}));
		
		function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}else{
				$path='';
			}
			$base_url=$GLOBALS['URLNAME'];
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}else{
					$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
				}
			return $logoexist;
		}
//Save
if($sp_company != '' && $sp_address != '' && $sp_password!='')
{
	
 if( $img!="" and $imageDataEncoded!=""){
  $ex_img = explode(".",@$img);
  // Start SMC-3452 Date Format Modified By Pranali 2018-09-19 05:44 PM
  $img_name = @$ex_img[0]."_".@$sp_id."_".date('Ymd').".".@$ex_img[1];
  //End SMC-3452
  //$img_name = @$ex_img[0]."_".@$sp_id."_".date('mdY').".png";
  $full_name_path = "core/image_sponsor/".$img_name;
  $imageName = "../../".$full_name_path;
  $imageData = base64_decode($imageDataEncoded); 
 //header('Content-Type: image/png');
  $source = imagecreatefromstring($imageData);  
  
  // $imageSave =   imagepng($source,$imageName,100);
$imageSave = imagejpeg($source,$imageName,100);	
 }else{
	 $img_name='';
 }	

	 if($User_Image!=''){
		 $sql="update tbl_sponsorer set sp_company='$sp_company',sp_password='$sp_password', sp_occupation='$sp_occupation', sp_name='$sp_name',  sp_website='$sp_website', sp_address='$sp_address', sp_city='$sp_city', sp_state='$sp_state', sp_country='$sp_country', sp_email='$sp_email', sp_phone='$sp_phone', sp_img_path='$img_name'
	 where id='$sp_id'"; 
	 
	 }else{
		 $sql="update tbl_sponsorer set sp_company='$sp_company',sp_password='$sp_password', sp_occupation='$sp_occupation', sp_name='$sp_name',  sp_website='$sp_website', sp_address='$sp_address', sp_city='$sp_city', sp_state='$sp_state', sp_country='$sp_country', sp_email='$sp_email', sp_phone='$sp_phone' where id='$sp_id'";  
	 }
	
	 $result=mysql_query($sql)or die(mysql_error());
	  
	  $i=mysql_query("select *  from tbl_sponsorer where id='$sp_id'");
	  $posts = array();
	  $results=mysql_fetch_assoc($i);
	  
	   $image=$results['sp_img_path'];
	  //print_r($results);exit;
	  
	  if(empty($image))
	  {
		  
		  $sponsor_image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
	  }
	  else{
		  //VaibhavG Here with I've added below code to update Shop image on android when a user updates shop image from Sponsor Website for the ticket number SAND-1665 on 3Oct2018.
		  $explode = explode("/",$image);
		  if($explode[0]=='image_sponsor')
				$sponsor_image=$GLOBALS['URLNAME']."/core/".$image;
			else
				$sponsor_image=$GLOBALS['URLNAME']."/core/image_sponsor/".$image;
				//previous code
				//$sponsor_image=$GLOBALS['URLNAME']."/core/image_sponsor/".$image;
	  }
	  
	   
	   foreach($results as $key=>$value)
	   {
		   
		   $posts[$key] = $value;
		   $posts['sp_img_path'] = $sponsor_image;
	   }
	   $posts1[] = $posts;
	  
	        $postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts1;
			

			mysql_close($con);
	
}
else
{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
}	
header('Content-type: application/json');
echo  json_encode($postvalue); 		
		
?>