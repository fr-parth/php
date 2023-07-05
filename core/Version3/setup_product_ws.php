<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

$product=xss_clean(mysql_real_escape_string($obj->{'product'}));
$points=xss_clean(mysql_real_escape_string($obj->{'points'}));
$sponsor_id=xss_clean(mysql_real_escape_string($obj->{'sponsor_id'}));
$product_type=xss_clean(mysql_real_escape_string($obj->{'product_type'}));
$discount=xss_clean(mysql_real_escape_string($obj->{'discount'}));
$product_price=xss_clean(mysql_real_escape_string($obj->{'product_price'}));

//below if condition changed by Pranali on 08-10-2018 for Bug SMC-3551
if($product != "" && $points != "" && $sponsor_id != "" && ($product_type == "product" && $product_price!="" && $discount !="") || ($product_type == "discount" && $discount !="" && $product_price == ""))
{
	
	
		$sp_id=$sponsor_id;
		$v_category1=mysql_query("select v_category from tbl_sponsorer where id='$sp_id'");
		$v_category =mysql_fetch_array($v_category1);
		$category=$v_category['v_category'];	
	
$arr = mysql_query("select id from tbl_sponsored where Sponser_product = '".$product."' and sponsor_id='".$sponsor_id."'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {
	// Start SMC-3452 Date Format Modified By Pranali 2018-09-20 06:37 PM
		$newdate1 = strtotime('+6 months -1 day');// sponsored date
		//$valid_until = date ("Y-m-d", $newdate1);
		//$sponsored=date("m/d/Y",time()); // sponsored date
		//H:i:s added in below date() by Pranali for SMC-3452 2018-09-25 12:55 PM
		$valid_until = date("Y-m-d H:i:s", $newdate1);
		$sponsored = CURRENT_TIMESTAMP;
	
		  	$Image=$obj->{'Image'};
			$ImageBase64=$obj->{'ImageBase64'};
			
		if($Image!='' and $ImageBase64!=''){
	
	$ex_img = explode(".",@$Image);
	//date format changed by pravin 2017-08-20
	//SMC-3452 Date Format Modified By Pranali 2018-09-20 06:37 PM
	$img_name = @$ex_img[0]."_".@$sp_id."_".date('Ymd').".".@$ex_img[1];
	//End SMC-3452
	//$img_name = "product". "_" .@$sp_id . "_" . date('Y-m-d') ."_". $ex_img[0];
	$full_name_path = "Assets/images/sp/productimage/".$img_name;
	$imageName = "../../".$full_name_path;
	$imageData = base64_decode($ImageBase64); 
	$source = imagecreatefromstring($imageData);  
	$imageSave = imagejpeg($source,$imageName,100);	
//added product_price in insert queries by Pranali	
	$test1 = mysql_query("INSERT INTO `tbl_sponsored` (Sponser_type,Sponser_product,points_per_product,sponsor_id,total_coupons,valid_until,sponsered_date,daily_limit,daily_counter,reset_date,category,product_price, discount,product_image) VALUES('".$product_type."', '".$product."', '".$points."', '".$sponsor_id."','unlimited','$valid_until','$sponsored','unlimited','unlimited','$sponsored','$category','".$product_price."','".$discount."','".$img_name."')");
		
		}
		else
		{
	
$test1 = mysql_query("INSERT INTO `tbl_sponsored` (Sponser_type,Sponser_product,points_per_product,sponsor_id,total_coupons,valid_until,sponsered_date,daily_limit,daily_counter,reset_date,category, product_price,discount) VALUES('".$product_type."', '".$product."', '".$points."', '".$sponsor_id."','unlimited','$valid_until','$sponsored','unlimited','unlimited','$sponsored','$category','".$product_price."','".$discount."')");
		}	
		
		$sid=mysql_insert_id();
		
		mysql_close($con);
		if($sid!=""){
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;			
		}else{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;			
		}

	}
	else
	{
			$postvalue['responseStatus']=409;
			$postvalue['responseMessage']="Conflict";
			$postvalue['posts']=null;
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