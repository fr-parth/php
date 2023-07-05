<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;

include 'conn.php';
//Save
		$id=xss_clean(mysql_real_escape_string($obj->{'id'}));
		$discount=xss_clean(mysql_real_escape_string($obj->{'discount'}));
		$points_per_discount=xss_clean(mysql_real_escape_string($obj->{'points_per_discount'}));
if($id != '' && $discount != '' && $points_per_discount != '')
{

		
		
		$Image=$obj->{'Image'};
		$ImageBase64=$obj->{'ImageBase64'};
		if($Image!='' and $ImageBase64!=''){
	$ex_img = explode(".",@$Image);
	// Start SMC-3452 Date Format Modified By Pranali 2018-09-20 03:51 PM
	$img_name = @$ex_img[0]."_".@$sp_id."_".date('Ymd').".".@$ex_img[1];
	//End SMC-3452
	$full_name_path = "Assets/images/sp/productimage/".$img_name;
	$imageName = "../../".$full_name_path;
	$imageData = base64_decode($ImageBase64); 
	$source = imagecreatefromstring($imageData);  
	$imageSave = imagejpeg($source,$imageName,100);	
			
			 $sql="update tbl_sponsored set Sponser_product='$discount', discount='$discount', points_per_product='$points_per_discount', product_image='$img_name' where id= $id ";
			$result=mysql_query($sql);
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']='image uploded';
		}else{
			 $sql="update tbl_sponsored set Sponser_product='$discount', discount='$discount', points_per_product='$points_per_discount' where id= $id ";
			$result=mysql_query($sql);
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']='image is null';
		}


	 
	 //$sql="update tbl_sponsored set Sponser_product='$discount', discount='$discount', points_per_product='$points_per_discount' where id= $id ";
	  
	  
            

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