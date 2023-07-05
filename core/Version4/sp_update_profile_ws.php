<?php 
$json = file_get_contents('php://input');
$obj = json_decode($json);

include '../conn.php'; //called conn from core 

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
		$Sponser_product=xss_clean(mysql_real_escape_string(@$obj->{'Sponser_product'}));
		$User_Image=@$obj->{'User_Image'};		

		$img = $obj->{'User_Image'};  
  
		$imageDataEncoded=$obj->{'User_imagebase64'};
 
		$sp_password=xss_clean(mysql_real_escape_string(@$obj->{'sp_password'}));
//Discount, points , revenue_percent & revenue_per_visit added by Pranali for SMC-3678 on 4-12-18
		$discount=xss_clean(mysql_real_escape_string(@$obj->{'discount'}));
		//$points_per_product=xss_clean(mysql_real_escape_string(@$obj->{'points_per_product'}));
		$revenue_percent=xss_clean(mysql_real_escape_string(@$obj->{'revenue_percent'}));
		$revenue_per_visit=xss_clean(mysql_real_escape_string(@$obj->{'revenue_per_visit'}));
		
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
	//below if condition added by Pranali for validation of discount for SAND-1773
	
	if(preg_match('/^(?:100|\d{0,2})(?:\.\d{0,2})?$/',$discount) && preg_match('/^(?:100|\d{0,2})(?:\.\d{0,2})?$/',$revenue_per_visit) && preg_match('/^(?:100|\d{0,2})(?:\.\d{0,2})?$/',$revenue_percent))
	{

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
//minimum_discount & points_for_minimum_discount updated in below query by Pranali for SMC-3678 on 2-2-19
//points_for_minimum_discount removed in below update query by Pranali for SMC-3678 on 6-2-19
			 if($User_Image!=''){
				 $sql="update tbl_sponsorer set sp_company='$sp_company',sp_password='$sp_password', sp_occupation='$sp_occupation', sp_name='$sp_name',  sp_website='$sp_website', sp_address='$sp_address', sp_city='$sp_city', sp_state='$sp_state', sp_country='$sp_country', sp_email='$sp_email', sp_phone='$sp_phone', sp_img_path='$img_name',minimum_discount='$discount' where id='$sp_id'"; 
			 
			 //update query of tbl_sponsored added by Pranali for SMC-3678 on 4-12-18
			 
//if and where Sponser_product='$Sponser_product' condition removed by Pranali for SMC-3678 on 6-2-19
				 $sql1="update tbl_sponsored set revenue_percent='$revenue_percent', revenue_per_visit='$revenue_per_visit' where sponsor_id='$sp_id'";
				 
			 
			 
			 }
//minimum_discount & points_for_minimum_discount updated in below query by Pranali for SMC-3678 on 2-2-19
//points_for_minimum_discount removed in below update query by Pranali for SMC-3678 on 6-2-19
			 else
			 {
				 $sql="update tbl_sponsorer set sp_company='$sp_company',sp_password='$sp_password', sp_occupation='$sp_occupation', sp_name='$sp_name',  sp_website='$sp_website', sp_address='$sp_address', sp_city='$sp_city', sp_state='$sp_state', sp_country='$sp_country', sp_email='$sp_email', sp_phone='$sp_phone',minimum_discount='$discount' where id='$sp_id'";
				 
		//update query of tbl_sponsored added by Pranali for SMC-3678 on 4-12-18 
				
					//if and where Sponser_product='$Sponser_product' condition removed by Pranali for SMC-3678 on 6-2-19
					$sql1="update tbl_sponsored set revenue_percent='$revenue_percent', revenue_per_visit='$revenue_per_visit' where sponsor_id='$sp_id'";
										
				
			 }
			
			 $result=mysql_query($sql)or die(mysql_error());
			 $result1=mysql_query($sql1)or die(mysql_error());
			  
		//changed below query to send revenue_percent and revenue_per_visit as response by Pranali for SMC-3678 on 4-12-18
				//below query added by Pranali to check if sponsor has setup product or not
			$q=mysql_query("SELECT sponsor_id FROM tbl_sponsored where sponsor_id='$sp_id'");
			
			
			if(mysql_num_rows($q) >= 1) 
			{
		//if sponsor has setup some discount / product / revenue_per_visit / revenue_percent 
//query modified (where sponsor_product condition removed) by Pranali for SMC-3678 on 5-2-19
				$i = mysql_query("SELECT sp.*,spd.revenue_percent,spd.revenue_per_visit,spd.discount,spd.points_per_product,spd.Sponser_product , spd.Sponser_type
				FROM tbl_sponsorer sp 
				join tbl_sponsored spd on sp.id = spd.sponsor_id
				where sp.id = '$sp_id'");
			
			}
			else{
		//if sponsor has not setup discount/product/revenue_per_visit/revenue_percent
		
			$i = mysql_query("SELECT * FROM `tbl_sponsorer` where (sp_email = '$sp_email' or  sp_phone = '$sp_phone' ) and binary sp_password = '$sp_password' and id = '$sp_id'");
			}

			  //$i=mysql_query("select sp.*,spd.revenue_percent,spd.revenue_per_visit,spd.discount,spd.points_per_product  from tbl_sponsorer sp
			  //join tbl_sponsored spd on sp.id=spd.sponsor_id
			  //where sp.id='$sp_id'");

			  $posts = array();
			  //while added to display all sponsored products by Pranali
			 while($results=mysql_fetch_assoc($i))
			 {
			  
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
			 }
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts1;
					

					mysql_close($con);
			
		}
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