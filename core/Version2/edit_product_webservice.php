<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;

include 'conn.php';
//Save
if(xss_clean(mysql_real_escape_string($obj->{'id'})) != '')
{

	 $id=xss_clean(mysql_real_escape_string($obj->{'id'}));
	 $product=xss_clean(mysql_real_escape_string($obj->{'product'}));
	  $discount=xss_clean(mysql_real_escape_string($obj->{'discount'}));
	  $points_per_product=xss_clean(mysql_real_escape_string($obj->{'points_per_product'}));
	  
//Start SMC-3490 Modify By Pravin 2018-09-29 
//As discussed with tabassum add input parameter SAND-1445 
	  $product_price=xss_clean(mysql_real_escape_string($obj->{'product_price'}));
	  
	  		$Image=$obj->{'Image'};
			$ImageBase64=$obj->{'ImageBase64'};
			
		if($Image!='' and $ImageBase64!=''){
	
	$ex_img = explode(".",@$Image);
	// Start SMC-3452 Date Format Modified By Pranali 2018-09-20 03:38 PM
	$img_name = @$ex_img[0]."_".@$sp_id."_".date('Ymd').".".@$ex_img[1];
	//End SMC-3452
	$full_name_path = "Assets/images/sp/productimage/".$img_name;
	$imageName = "../../".$full_name_path;
	$imageData = base64_decode($ImageBase64); 
	$source = imagecreatefromstring($imageData);  
	$imageSave = imagejpeg($source,$imageName,100);			
			
			 $sql="update tbl_sponsored set Sponser_product ='$product', discount = '$discount', points_per_product = '$points_per_product', product_image='$img_name', product_price = '$product_price' where id=$id ";
			
		}else{
			$sql="update tbl_sponsored set Sponser_product = '$product', discount='$discount', points_per_product = '$points_per_product' , product_price = '$product_price' where id=$id ";//End SMC-3490
		}
	 
	
		
	$result=mysql_query($sql);
	 $row=mysql_affected_rows();
	if($row>=1)
		  {
            $postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;
		  }
		  else
		  {
		    $postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		   } 
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