<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));    
$user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));


if($entity!='' and $user_id!=''){
		$recs1=@mysql_query("select count(1) as recs from cart where user_id='$user_id' and entity_id='$entity' and `coupon_id` IS NOT NULL");
		$recs=@mysql_fetch_array($recs1);	
		if($recs['recs']!='' and $recs['recs']!=0){
		$ap=mysql_query("select sum(for_points) as usedpts from cart where user_id='$user_id' and entity_id='$entity' and `coupon_id` IS NOT NULL");
		$up1=mysql_fetch_array($ap)or die(mysql_error());
		$up=$up1['usedpts'];
	
		if($entity=='3'){
			//get total pts with the user
			$q = mysql_query("select sc_total_point as green, yellow_points as yellow, purple_points as purple, balance_water_points as water, sum(sc_total_point + yellow_points + purple_points + balance_water_points) as totat_pts, std_country as country, std_state as state, std_city as city, std_address as address, s.school_id, concat(s.std_lastname,' ',s.std_name,' ',s.std_Father_name) as name, std_email as email from tbl_student_reward sr left join tbl_student s on sr.sc_stud_id=s.std_PRN where s.id='$user_id'")or die(mysql_error());
			$tp1=mysql_fetch_array($q);
		}elseif($entity=='2'){
			$q = mysql_query("select balance_blue_points as blue, balance_blue_points as totat_pts, t_country as country, state, t_city as city, t_address as address, t.school_id, concat(t.t_lastname,' ',t.t_name,' ',t.t_middlename) as name, t_email as email from  tbl_teacher t where id='$user_id'")or die(mysql_error());
			$tp1=mysql_fetch_array($q);				
		}
			$tp=$tp1['totat_pts'];
			$school_id=$tp1['school_id'];
		if($tp>=$up){
			$rempt=$tp-$up;
				if($entity=='3'){
					$pts_green=$tp1['green'];
					$pts_yellow=$tp1['yellow'];
					$pts_purple=$tp1['purple'];
					$pts_water=$tp1['water'];					
					
					$deduct=$up;
					
					if($deduct > $pts_green){
						$deduct=$deduct-$pts_green;
						$pts_green=0;
						if($deduct > $pts_yellow){
							$deduct=$deduct-$pts_yellow;
							$pts_yellow=0;
							if($deduct > $pts_purple){
								$deduct=$deduct-$pts_purple;
								$pts_purple=0;
								if($deduct > $pts_water){
									$deduct=$deduct-$pts_water;
									$pts_water=0;
								}else{
									$pts_water=$pts_water-$deduct;
									$deduct=0;
								}
							}else{
								$pts_purple=$pts_purple-$deduct;
								$deduct=0;
							}
						}else{
							$pts_yellow=$pts_yellow-$deduct;
							$deduct=0;						
						}					
					}else{
						$pts_green=$pts_green-$deduct;
						$deduct=0;
					}
					
					
					mysql_query("UPDATE `tbl_student_reward` sr INNER JOIN tbl_student s ON sr.sc_stud_id=s.std_PRN SET `sc_total_point`='$pts_green', `yellow_points`='$pts_yellow', `purple_points`='$pts_purple', balance_water_points='$pts_water' WHERE s.id='$user_id'")or die(mysql_error());
					
				}elseif($entity=='2'){					
					$pts_blue=$rempt;
					
					mysql_query("UPDATE `tbl_teacher` SET `balance_blue_points`='$pts_blue' WHERE `id`='$user_id'")or die(mysql_error());
				}
			
			
		$cartq=mysql_query("SELECT c.id, c.entity_id, c.user_id, c.coupon_id, c.for_points, c.timestamp, c.available_points, spd.Sponser_product, s.sp_company, concat(s.sp_address, ', ', s.sp_city) as address, spd.sponsor_id, spd.valid_until, spd.coupon_code_ifunique FROM cart c JOIN tbl_sponsored spd ON spd.id=c.coupon_id JOIN tbl_sponsorer s ON s.id=spd.sponsor_id WHERE c.user_id='$user_id' and c.entity_id='$entity' and c.coupon_id IS NOT NULL")or die(mysql_error());
				$sr=1;
				while($cart=mysql_fetch_array($cartq)){				
					$cid=$cart['coupon_id'];					
					$ppp=$cart['for_points'];
					$time=$cart['timestamp'];
					$selid=$cart['id'];
					$ts=explode(' ',$time);
					$date=$ts[0];
					$tm=$ts[1];
					
					$sp_id=$cart['sponsor_id'];
					$product=$cart['Sponser_product'];
					$valid_until=$cart['valid_until'];
					$coupon_code_ifunique=$cart['coupon_code_ifunique'];
					$company=$cart['sp_company'];
					
						if($coupon_code_ifunique=="" or $coupon_code_ifunique==NULL or $coupon_code_ifunique==0){
							$code1 = $company.$product.$user_id.$entity;							
							$a=rand(0,26);				
							$cpue=substr(md5($code1),$a,5);			
							$m1=time().$sr;
							$m=md5($m1);
							$b=rand(0,26);	
							$tsr=substr($m,$b,5);							
							$code2='SC'.$cpue.$tsr;
							$code=strtoupper($code2);
						}else{ 
							if($coupon_code_ifunique!=null){
							$code=$coupon_code_ifunique;
							}
						}
						
						$p=mysql_query("INSERT INTO tbl_selected_vendor_coupons (id, entity_id, user_id, coupon_id, for_points, timestamp, code, used_flag, sponsor_id, valid_until, school_id) VALUES(NULL,\"$entity\",\"$user_id\",\"$cid\",\"$ppp\",CURRENT_TIMESTAMP,\"$code\",'unused',\"$sp_id\",\"$valid_until\",\"$school_id\")")or die(mysql_error());
						
						$q=mysql_query("DELETE FROM cart WHERE id='$selid'")or die(mysql_error());						

						$sr++;	
				}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']="Coupons get confirmed";	
		}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;				
		}
		}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;				
		}			
}else{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;		
}



header('Content-type: application/json');
echo json_encode($postvalue); 
?>