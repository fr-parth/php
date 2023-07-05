<?php
$json   = file_get_contents('php://input');
$obj    = json_decode($json);
error_reporting(1);
//include 'conn.php';
include '../distance.php';
require '../coupon_validity_check.php';


$cat_id  = xss_clean(mysql_real_escape_string($obj->{'cat_id'}));
$dist    = xss_clean(mysql_real_escape_string($obj->{'distance'}));
$lat1    = xss_clean(mysql_real_escape_string($obj->{'lat'}));
$lon1    = xss_clean(mysql_real_escape_string($obj->{'lon'}));
$last_id = xss_clean(mysql_real_escape_string($obj->{'last_id'}));

if ($cat_id != "" or ($dist != "" and $lat1 != "" and $lon1 != "")) {
	if ($dist != "no_limit" and $dist != "") {
		$chk_dist = $dist;
	} elseif ($dist == 'no_limit') {
		$chk_dist = 1000;
	} else {
		$chk_dist = 10;
	}
	if ($last_id != 0 AND $last_id != "") {
		$sql = "SELECT spd.validity, spd.id, sp.sp_img_path, sp.sp_address, sp.sp_company, spd.Sponser_type, spd.Sponser_product, sp.lat,sp.lon, spd.points_per_product, spd.sponsered_date, spd.sponsor_id, spd.product_image, spd.valid_until, cat.category, spd.product_price, spd.discount, spd.buy, spd.get, spd.saving, spd.offer_description, spd.total_coupons, spd.priority, spd.coupon_code_ifunique, spd.currency, spd.daily_counter, spd.daily_limit
             FROM tbl_sponsorer sp 
			 JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id 
			 JOIN categories cat ON cat.id = spd.category 
			 WHERE spd.category='$cat_id' and `validity`<>'invalid' AND spd.id>'$last_id' LIMIT 10";
	} else {
		$sql = "SELECT spd.validity, spd.id, sp.sp_img_path, sp.sp_address,sp.sp_company, spd.Sponser_type, spd.Sponser_product, sp.lat,sp.lon, spd.points_per_product, spd.sponsered_date, spd.sponsor_id, spd.product_image, spd.valid_until, cat.category, spd.product_price, spd.discount, spd.buy, spd.get, spd.saving, spd.offer_description, spd.total_coupons, spd.priority, spd.coupon_code_ifunique, spd.currency, spd.daily_counter, spd.daily_limit
             FROM tbl_sponsorer sp 
			 JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id 
			 JOIN categories cat ON cat.id = spd.category 
			 WHERE spd.category='$cat_id' and `validity`<>'invalid' LIMIT 10";
	}
	$arr   = mysql_query($sql);
	$posts = array();
	
	if (mysql_num_rows($arr) >= 1) {
		while ($post = mysql_fetch_assoc($arr)) {
			$coupon_id            = $post['id'];
			$sponsor_img_path          = $post['sp_img_path'];
			$sponser_type         = $post['Sponser_type'];
			$sp_company           = $post['sp_company'];
			$sp_address           = $post['sp_address'];
			$sponser_product      = $post['Sponser_product'];
			$points_per_product   = $post['points_per_product'];
			$sponsered_date       = $post['sponsered_date'];
			$sponsor_id           = $post['sponsor_id'];
			$sponsor_product_img = $post['product_image'];
			$valid_until          = $post['valid_until'];
			$validity             = $post['validity'];
			$category             = $post['category'];
			$product_price        = $post['product_price'];
			$discount             = $post['discount'];
			$buy                  = $post['buy'];
			$get                  = $post['get'];
			$saving               = $post['saving'];
			$offer_description    = trim($post['offer_description']);
			$total_coupons        = $post['total_coupons'];
			$daily_limit          = $post['daily_limit'];
			$daily_counter        = $post['daily_counter'];
			$priority             = $post['priority'];
			$coupon_code_ifunique = $post['coupon_code_ifunique'];
			$currid               = $post['currency'];
			
			if ($currid != 0 or $currid != null) {
				$curre    = mysql_query("SELECT `currency` FROM `currencies` WHERE `id`=$currid ");
				$curr     = mysql_fetch_array($curre);
				$currency = $curr['currency'];
			} else {
				$currency = null;
			}
			//Sponsor Profile Image
			if($sponsor_img_path==''){
				
				$sp_img_path= $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}
			else{
				$sp_img_path=$GLOBALS['URLNAME']."/core/".$sponsor_img_path;
			}
			
			//Sponsor Product Image
			if($sponsor_product_img==''){
			$product_img_path= $GLOBALS['URLNAME']."/Assets/images/sp/profile/imgnotavl.png";
			}
			else{
				$product_img_path=$GLOBALS['URLNAME']."/Assets/images/sp/productimage/".$sponsor_product_img;
			}
				// Start SMC-3450 Modify By Pravin 2018-09-19 02:26 PM 		
				// $date1=date("m/d/Y");
				 $date1=CURRENT_TIMESTAMP;
				 //End SMC-3450
				$date2 = $valid_until;

				$diff = abs(strtotime($date2) - strtotime($date1));

				$years = floor($diff / (365*60*60*24));
				$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			
			
			
			
			$c_chk            = $abc->counter_check($daily_counter);
			
			$lat2             = @$post['lat'];
			$lon2             = @$post['lon'];
			
			if(!empty($lat1) and !empty($lon1) and !empty($lat2) and !empty($lon2)){
				$miles            = calculateDistance($lat1, $lon1, $lat2, $lon2);
				$kilometers       = $miles * 1.609344;
				if ($kilometers <= 0) {
					$meters = $miles * 1609.34;
				}			
			
				
				if ($kilometers <= $chk_dist) {
					$dist_acceptable = 1;
				} else {
					$dist_acceptable = 0;
				} 				
			}else{
			
				$dist_acceptable = 0;
			}
			
			if ($dist_acceptable) {
				//if ($c_chk && ($validUntil_check >= 0) && ($start_check <= 0)) {
				if ($c_chk && $months >= 0) {	
					$posts[]                      = array(
						"coupon_id" => $coupon_id,
						"sp_img_path" => $sp_img_path,
						"sponser_type" => $sponser_type,
						"sp_address" => $sp_address,
						"sp_company" => $sp_company,
						"sponser_product" => $sponser_product,
						"validity" => $validity,
						"points_per_product" => $points_per_product,
						"sponsered_date" => $sponsered_date,
						"sponsor_id" => $sponsor_id,
						"product_image" => $product_img_path,
						"valid_until" => $valid_until,
						"category" => $category,
						"product_price" => $product_price,
						"discount" => $discount,
						"buy" => $buy,
						"get" => $get,
						"saving" => $saving,
						"offer_description" => $offer_description,
						"total_coupons" => $total_coupons,
						"priority" => $priority,
						"coupon_code_ifunique" => $coupon_code_ifunique,
						"currency" => $currency,
						"daily_counter" => $daily_counter,
						"daily_limit" => $daily_limit,
						"distance_kms" => $kilometers
					);

				}
			}else {
		$postvalue['responseStatus']  = 204;
		$postvalue['responseMessage'] = "No Response ";
		$postvalue['posts']           = null;
	}
			
		}
		if(count($posts)>=1){
			$postvalue['responseStatus']  = 200;
			$postvalue['responseMessage'] = "OK";
			$postvalue['posts']           = $posts;
		}		
					
	} else {
		$postvalue['responseStatus']  = 204;
		$postvalue['responseMessage'] = "No Record Found ";
		$postvalue['posts']           = null;
	}
} else {
	$postvalue['responseStatus']  = 1000;
	$postvalue['responseMessage'] = "Invalid Input";
	$postvalue['posts']           = null;
}
header('Content-type: application/json');
echo json_encode($postvalue);
@mysql_close($link);
?>
