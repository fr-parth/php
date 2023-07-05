<?php  
//show_selected_vendor_coupons_ws.php
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



include 'conn.php';

  
$entity_id = xss_clean(mysql_real_escape_string($obj->{'entity'}));
$user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
if(isset($obj->{'coupon_status'}))
	$status=$obj->{'coupon_status'}; //unused //used


// pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin
	function sp_image($sponsor_img_path)
	{
		if($sponsor_img_path=='')
		{
			$sp_img_path= $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
		}
		else
		{
			$sp_img_path=$GLOBALS['URLNAME']."/core/".$sponsor_img_path;
		}
		
		return $sp_img_path; 
	}
	function prod_img($sponsor_product_img)
	{
		if($sponsor_product_img=='')
		{
			$product_image= $GLOBALS['URLNAME']."/Assets/images/sp/profile/imgnotavl.png";
		}
		else
		{
		$product_image=$GLOBALS['URLNAME']."/Assets/images/sp/productimage/".$sponsor_product_img;
		}
		
		return $product_image;
	}
if( $entity_id != "" and $user_id !="")
		{


	/* Author VaibhavG
		changed the order of id by descending order When user redeemed vender Coupon for the ticket number SAND-1623 3Sept18 01:18PM.
	*/
	/* Author VaibhavG
		added condition of isset($obj->{'coupon_status'}) & added extra query to get used & unused vendor coupon log for the ticket number SAND-1622 6Sept18 07:05PM.
	*/
	if(isset($obj->{'coupon_status'}))
	{	

		$sql="SELECT spd.id, ucwords(sp.sp_name) as sp_name, sp.sp_address, sp.sp_country, ucwords(sp.sp_state) as sp_state, ucwords(sp.sp_city) as sp_city, sp.sp_email, sp.sp_phone, sp.sp_company, sp.sp_website, sp.sp_img_path, sp.lat, sp.lon, sp.pin, spd.Sponser_type, spd.Sponser_product, spd.points_per_product, spd.sponsered_date, spd.product_image, svc.used_flag,svc.sponsor_id, svc.valid_until, cat.category, product_price, spd.discount, buy, spd.get, saving, offer_description, daily_limit, total_coupons, priority, coupon_code_ifunique, cur.currency, daily_counter, reset_date, validity, svc.id as sel_id, svc.timestamp, svc.code FROM `tbl_selected_vendor_coupons` svc JOIN tbl_sponsorer sp ON svc.sponsor_id=sp.id JOIN tbl_sponsored spd ON spd.id = svc.coupon_id LEFT JOIN categories cat ON cat.id = spd.category LEFT JOIN currencies cur ON cur.id = spd.currency WHERE  `validity`<>'invalid' and svc.entity_id='$entity_id' and svc.user_id='$user_id' AND svc.used_flag='$status' order by svc.id desc limit $limit OFFSET $offset";
	}
	else
	{
		$sql="SELECT spd.id, ucwords(sp.sp_name) as sp_name, sp.sp_address, sp.sp_country, ucwords(sp.sp_state) as sp_state, ucwords(sp.sp_city) as sp_city, sp.sp_email, sp.sp_phone, sp.sp_company, sp.sp_website, sp.sp_img_path, sp.lat, sp.lon, sp.pin, spd.Sponser_type, spd.Sponser_product, spd.points_per_product, spd.sponsered_date, spd.product_image, svc.used_flag,svc.sponsor_id, svc.valid_until, cat.category, product_price, spd.discount, buy, spd.get, saving, offer_description, daily_limit, total_coupons, priority, coupon_code_ifunique, cur.currency, daily_counter, reset_date, validity, svc.id as sel_id, svc.timestamp, svc.code FROM `tbl_selected_vendor_coupons` svc JOIN tbl_sponsorer sp ON svc.sponsor_id=sp.id JOIN tbl_sponsored spd ON spd.id = svc.coupon_id LEFT JOIN categories cat ON cat.id = spd.category LEFT JOIN currencies cur ON cur.id = spd.currency WHERE  `validity`<>'invalid' and svc.entity_id='$entity_id' and svc.user_id='$user_id' order by svc.id desc limit $limit OFFSET $offset";
	}
	
			 $arr = mysql_query($sql);

  				/* create one master array of the records */
  			$posts = array();
			/* Author VaibhavG
			*	As per the discussed with Pooja Paramshetti, I've changed only date for timestamp value not a datetime for the ticket number SAND-1624 4Sept18 07:25PM
			*/
	//pagination by sachin
			$numrecord=	mysql_num_rows($arr);
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}		
				else if($numrecord>0)
				{
			//end pagination

    			while($post = mysql_fetch_assoc($arr)) {
					$posts[] =array(
					"sel_id"=>$post['sel_id'],
					"coupon_id"=>$post['id'],
					"sponsor_id"=>$post['sponsor_id'],
					"sp_address"=>$post['sp_address'],
					"sp_country"=>$post['sp_country'],
					"sp_state"=>$post['sp_state'],
					"sp_city"=>$post['sp_city'],
					"sp_company"=>$post['sp_company'],						
					"sponsered_date"=>$post['sponsered_date'],						
					"sp_email"=>$post['sp_email'],						
					"sp_phone"=>$post['sp_phone'],						
					"sp_name"=>$post['sp_name'],						
					"sp_website"=>$post['sp_website'],						
					"lat"=>$post['lat'],						
					"lon"=>$post['lon'],						
					"pin"=>$post['pin'],						
					"category"=>$post['category'],						
					"daily_limit"=>$post['daily_limit'],
					//Sponsor Profile Image
					"sp_img_path"=>sp_image($post['sp_img_path']),	
					"Sponser_product"=>$post['Sponser_product'],						
					"product_price"=>$post['product_price'],						
					"points_per_product"=>$post['points_per_product'],
					//Sponsor Product Image
					"product_image"=>prod_img($post['product_image']),						
					"valid_until"=>$post['valid_until'],
					"discount"=>$post['discount'],						
					"buy"=>$post['buy'],		
					"get"=>$post['get'],
					"saving"=>$post['saving'],
					"offer_description"=>$post['offer_description'],						
					"currency"=>$post['currency'],
					"timestamp"=>date("Y-m-d",strtotime($post['timestamp'])),
					"code"=>$post['code'],
					"used_flag"=>$post['used_flag']
					);	
				}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;	
  			}
  			else{
				$postvalue['responseStatus']=204 ;
				$postvalue['responseMessage']="No Response";//No More Points
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
echo json_encode($postvalue); 		
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
	
	
		
  ?>