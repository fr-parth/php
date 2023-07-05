<?php
$json   = file_get_contents('php://input');
$obj    = json_decode($json);

include 'conn.php';
//include '../distance.php';
//require '../coupon_validity_check.php';

function imageurl($value, $type = '', $img = '')
{
	if ($img == 'sp_profile') {
		$path = 'sp/profile/';
	} elseif ($img == 'product') {
		$path = 'sp/productimage/';
	} elseif ($img == 'spqr') {
		$path = 'sp/coupon_qr/';
	} else {
		$path = '';
	}
	$base_url = 'http://' . $_SERVER['HTTP_HOST'];
	$logoUrl  = @get_headers($base_url . '/Assets/images/' . $path . $value);
	$tlogoUrl = @get_headers('http://tsmartcookies.bpsi.us/' . $value);
	$slogoUrl = @get_headers('http://www.smartcookie.in/' . $value);
	if ($logoUrl[0] == 'HTTP/1.1 200 OK' && $value != 'new-product.jpg' && $value != '') {
		$logoexist = $base_url . '/Assets/images/' . $path . $value;
	} elseif ($tlogoUrl[0] == 'HTTP/1.1 200 OK' && $value != '') {
		$logoexist = 'http://tsmartcookies.bpsi.us/core/' . $value;
	} elseif ($slogoUrl[0] == 'HTTP/1.1 200 OK' && $value != '') {
		$logoexist = 'http://www.smartcookie.in/core/' . $value;
	} else {
		if ($type == 'sclogo') {
			$logoexist = $base_url . '/Assets/images/sp/profile/newlogo.png';
		} elseif ($type == 'avatar') {
			$logoexist = $base_url . '/Assets/images/avatar/avatar_2x.png';
		} else {
			$logoexist = $base_url . '/Assets/images/sp/profile/imgnotavl.png';
		}
	}
	return $logoexist;
}

$cat_id  = $obj->{'cat_id'};
$dist    = $obj->{'distance'};
$lat1    = $obj->{'lat'};
$lon1    = $obj->{'lon'};
$last_id = $obj->{'last_id'};

if ($cat_id != "" or ($dist != "" and $lat1 != "" and $lon1 != "")) {
	if ($dist != "no_limit" and $dist != "") {
		$chk_dist = $dist;
	} elseif ($dist == 'no_limit') {
		$chk_dist = 1000;
	} else {
		$chk_dist = 10;
	}
	if ($last_id != 0 AND $last_id != "") {
		$sql = "SELECT validity, spd.id, sp_img_path, sp_company, Sponser_type, Sponser_product, lat,lon, points_per_product, sponsered_date, sponsor_id, product_image, valid_until, cat.category, product_price, discount, buy, get, saving, offer_description, total_coupons, priority, coupon_code_ifunique, spd.currency, daily_counter, daily_limit
             FROM tbl_sponsorer sp 
			 JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id 
			 JOIN categories cat ON cat.id = spd.category 
			 WHERE spd.category='$cat_id' and `validity`<>'invalid' AND spd.id>'$last_id' LIMIT 10";
	} else {
		$sql = "SELECT validity, spd.id, sp_img_path, sp_company, Sponser_type, Sponser_product, lat,lon, points_per_product, sponsered_date, sponsor_id, product_image, valid_until, cat.category, product_price, discount, buy, get, saving, offer_description, total_coupons, priority, coupon_code_ifunique, spd.currency, daily_counter, daily_limit
             FROM tbl_sponsorer sp 
			 JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id 
			 JOIN categories cat ON cat.id = spd.category 
			 WHERE spd.category='$cat_id' and `validity`<>'invalid'invalid' LIMIT 10 ";
	}
	$arr   = mysql_query($sql);
	$posts = array();
	
	if (mysql_num_rows($arr) >= 1) {
		while ($post = mysql_fetch_assoc($arr)) {
			$coupon_id            = $post['id'];
			$sp_img_path          = imageurl($post['sp_img_path'], 'sclogo', 'sp_profile');
			$sponser_type         = $post['Sponser_type'];
			$sp_company           = $post['sp_company'];
			$sponser_product      = $post['Sponser_product'];
			$points_per_product   = $post['points_per_product'];
			$sponsered_date       = $post['sponsered_date'];
			$sponsor_id           = $post['sponsor_id'];
			$product_image        = imageurl($post['product_image'], '', 'product');
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
			
			$td               = date("m/d/Y", time());
			$start_check      = $abc->datediffr($td, $sponsered_date);
			$start_check      = (int)$start_check;
			$validUntil_check = $abc->datediffr($td, $valid_until);
			$validUntil_check = (int)$validUntil_check;
			
			
			
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
				if ($c_chk && ($validUntil_check >= 0) && ($start_check <= 0)) {
					
					$posts[]                      = array(
						"coupon_id" => $coupon_id,
						"sp_img_path" => $sp_img_path,
						"sponser_type" => $sponser_type,
						"sp_company" => $sp_company,
						"sponser_product" => $sponser_product,
						"validity" => $validity,
						"points_per_product" => $points_per_product,
						"sponsered_date" => $sponsered_date,
						"sponsor_id" => $sponsor_id,
						"product_image" => $product_image,
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
			}
		}
		if(count($posts)>=1){
			$postvalue['responseStatus']  = 200;
			$postvalue['responseMessage'] = "OK";
			$postvalue['posts']           = $posts;
		}else{
			$postvalue['responseStatus']  = 204;
			$postvalue['responseMessage'] = "No Response";
			$postvalue['posts']           = null;			
		}
		
		
					
	} else {
		$postvalue['responseStatus']  = 204;
		$postvalue['responseMessage'] = "No Response";
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
