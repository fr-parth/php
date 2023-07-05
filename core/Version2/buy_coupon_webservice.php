<?php 

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default
$school_id ="";

include 'conn.php';

$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));
$user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
$cid = xss_clean(mysql_real_escape_string($obj->{'coupon_id'}));

if($entity=='' or $user_id=='' or $cid==''){
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}else{
	$buy_row_id==0;
	
	$spd=mysql_query("SELECT spd.id, spd.Sponser_product, spd.coupon_code_ifunique, spd.points_per_product, spd.valid_until, spd.total_coupons, spd.daily_counter, spd.sponsor_id , s.id, s.sp_company FROM tbl_sponsored spd join tbl_sponsorer s on spd.sponsor_id=s.id where spd.id='$cid'")or die(mysql_query());
	$rows=mysql_num_rows($spd);	
	$c=mysql_fetch_array($spd);
	
	if($entity==3){
		$userexist=mysql_num_rows(mysql_query("select id from tbl_student where id='$user_id'"));
	}elseif($entity==2){
		$userexist=mysql_num_rows(mysql_query("select id from tbl_teacher where id='$user_id'"));
	}else{
		$userexist=0;
	}
	
	if($rows>0 && $userexist){
		$product=$c['Sponser_product'];
		$coupon_code_ifunique=$c['coupon_code_ifunique'];
		$ppp=$c['points_per_product'];
		$valid_until=$c['valid_until'];
		$sp_id=$c['sponsor_id'];					
		$total_coupons=$c['total_coupons'];
		$daily_counter=$c['daily_counter'];

			if(empty($coupon_code_ifunique)){
				$code1 = $company.$product.$user_id.$entity;							
				$a=rand(0,26);				
				$cpue=substr(md5($code1),$a,5);	
				$sr=rand(10,99);
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
			
		if($entity==3){
			$get_points= mysql_query("select SUM( sc_total_point + yellow_points + purple_points ) as tp, sc_total_point, yellow_points, purple_points, s.school_id from `tbl_student_reward` sr join tbl_student s on sr.sc_stud_id=s.std_PRN where s.id='$user_id'")or die(mysql_query());
			$s=mysql_fetch_array($get_points);
				$tp=$s['tp'];
				
			if($tp>=$ppp){	
				$pts_green=$s['sc_total_point'];
				$pts_yellow=$s['yellow_points'];
				$pts_purple=$s['purple_points'];
				$school_id=$s['school_id'];
				
				$deduct=$ppp;
				if($deduct > $pts_green){
					$deduct=$deduct-$pts_green;
					$pts_green=0;
					if($deduct > $pts_yellow){
						$deduct=$deduct-$pts_yellow;
						$pts_yellow=0;
						if($deduct > $pts_purple){
							$deduct=$deduct-$pts_purple;
							$pts_purple=0;
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
				$insert_selected_vendor_coupons=mysql_query("INSERT INTO tbl_selected_vendor_coupons (id, entity_id, user_id,	coupon_id, for_points, timestamp, code,	used_flag, sponsor_id, valid_until, school_id) VALUES(NULL,\"$entity\",\"$user_id\",\"$cid\",\"$ppp\",CURRENT_TIMESTAMP,\"$code\",'unused',\"$sp_id\",\"$valid_until\",\"$school_id\")")or die(mysql_query());
				$buy_row_id= mysql_insert_id();
				$q=mysql_query("UPDATE `tbl_student_reward` sr INNER JOIN tbl_student s ON sr.sc_stud_id=s.std_PRN SET `sc_total_point`='$pts_green', `yellow_points`='$pts_yellow', `purple_points`='$pts_purple' WHERE s.id='$user_id'")or die(mysql_query());			
			
			
				if($total_coupons!='unlimited' and $total_coupons!='NULL'){
					$total_coupons -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `total_coupons`='$total_coupons' WHERE `id`='$cid'")or die(mysql_query());	
				}
				
				if($daily_counter!='unlimited' and $daily_counter!='NULL'){
					$daily_counter -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `daily_counter`='$daily_counter' WHERE `id`='$cid'")or die(mysql_query());	
				}	
			}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
			}
						
		}elseif($entity==2){
			$get_points=mysql_query("select balance_blue_points, school_id from `tbl_teacher` where id='$user_id'")or die(mysql_query());	;
			$s=mysql_fetch_array($get_points);
			$tp=$s['balance_blue_points'];
			$school_id=$s['school_id'];
			
			if($tp>=$ppp){
				$pts=$tp-$ppp;
				$insert_selected_vendor_coupons=mysql_query("INSERT INTO tbl_selected_vendor_coupons (id, entity_id, user_id,	coupon_id, for_points, timestamp, code,	used_flag, sponsor_id, valid_until, school_id) VALUES(NULL,\"$entity\",\"$user_id\",\"$cid\",\"$ppp\",CURRENT_TIMESTAMP,\"$code\",'unused',\"$sp_id\",\"$valid_until\",\"$school_id\")")or die(mysql_query());		
				$buy_row_id= mysql_insert_id();
				$q=mysql_query("UPDATE `tbl_teacher` SET `balance_blue_points`='$pts' WHERE `id`='$user_id'");				
				if($total_coupons!='unlimited' and $total_coupons!='NULL'){
					$total_coupons -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `total_coupons`='$total_coupons' WHERE `id`='$cid'")or die(mysql_query());	
				}				
				if($daily_counter!='unlimited' and $daily_counter!='NULL'){
					$daily_counter -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `daily_counter`='$daily_counter' WHERE `id`='$cid'")or die(mysql_query());	
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

		if($buy_row_id!=0){
			$arr = mysql_query("SELECT * FROM `tbl_selected_vendor_coupons` WHERE `id`='$buy_row_id'")or die(mysql_query());
				$posts = array();
                $user_id = "";
                $entity_id = "";
                $for_points = "";
                $coupon_id = "";
                $sponsor_id = "";

    			while($post = mysql_fetch_assoc($arr)) {

						$uid=$post['id'];
						$entity_id=$post['entity_id'];
						$user_id=$post['user_id'];
						$coupon_id=$post['coupon_id'];
						$for_points=$post['for_points'];
						$code=$post['code'];
						$sponsor_id=$post['sponsor_id'];
						$timestamp=$post['timestamp'];
						$used_flag=$post['used_flag'];
						$valid_until=$post['valid_until'];
						$posts[] =array("uid"=>$uid,
							"entity_id"=>$entity_id,
							"user_id"=>$user_id,
							"coupon_id"=>$coupon_id,
							"for_points"=>$for_points,
							"code"=>$code,
							"sponsor_id"=>$sponsor_id,
							"timestamp"=>$timestamp,
							"used_flag"=>$used_flag,
							"valid_until"=>$valid_until
						);
    			}

             function checkEntityType($e_id)
            {
              $id="";
              switch($e_id)
              {
                case 2:
                    $id = 103;
                    break;
                case 3:
                    $id = 105;
                    break;

              }
              return $id;
            }

            $ent_type =  checkEntityType($entity_id);
            $p = mysql_query("SELECT sp.id,`Sponser_product`,`Sponser_type`,`sp_company`  FROM  `tbl_sponsorer` sp,  `tbl_sponsored` spd WHERE sp.id = spd.sponsor_id AND spd.sponsor_id =  '".$sponsor_id."'  AND spd.id =  '".$coupon_id."'");

            $prod = mysql_fetch_array($p);
            $p_name = $prod['Sponser_product'];
            $percent = "";
            if($prod['Sponser_type']=="discount")
            {
               $percent = "% "."(".$prod['Sponser_type'].")";
            }
            $sp_id = $prod['id'];

			// Start SMC-3450 Modify By Pravin 2018-09-19 07:04 PM 
            //$sql = mysql_query("INSERT INTO `tbl_ActivityLog`(EntityID,Entity_type,EntityID_2,Entity_Type_2,Timestamp,Activity,quantity,school_id) VALUES ('".$user_id."','".$ent_type."','".$sp_id."','102','".date("Y-m-d h:i:s")."','Bought ".$p_name.$percent."','".$for_points." Points','".$school_id."')")or die(mysql_query());
			
            $sql = mysql_query("INSERT INTO `tbl_ActivityLog`(EntityID,Entity_type,EntityID_2,Entity_Type_2,Timestamp,Activity,quantity,school_id) VALUES ('".$user_id."','".$ent_type."','".$sp_id."','102','CURRENT_TIMESTAMP','Bought ".$p_name.$percent."','".$for_points." Points','".$school_id."')")or die(mysql_query());
			//End SMC-3450
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;


		}else{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response1";
			$postvalue['posts']=null;
		}
		
	}else{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	}
}
header('Content-type: application/json');
echo json_encode($postvalue); 
?>