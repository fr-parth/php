<?php

$user_id=$_SESSION['id'];
$entity=$_SESSION['entity'];
$school_id=$_SESSION['school_id'];
$rid=$_SESSION['rid'];

$user_cart =mysql_query("SELECT * FROM cart WHERE `user_id` ='$user_id' and `entity_id` ='2'");
$total_cart = mysql_num_rows($user_cart);
	
	$tot = mysql_query("SELECT `available_points` FROM cart WHERE `user_id`='$user_id' and `entity_id`='2' and coupon_id is null"); 
	$total=mysql_fetch_array($tot);
	$tp=$total[0];	
	
	$q = mysql_query("SELECT sum(`available_points`) FROM cart WHERE `user_id`='$user_id' and `entity_id`='2' and coupon_id<>'NULL'");  
	$qid=mysql_fetch_array($q);
	$id1=$qid[0];
	$pts=$tp-$id1;

if(isset($_POST['select'])){
		if(!empty($_POST['proid']) && !empty($_POST['ppp'])){
			$proid=$_POST['proid'];
			$ppp=$_POST['ppp'];
			
	$tot = mysql_query("SELECT `available_points` FROM cart WHERE `user_id`='$user_id' and `entity_id`='2' and coupon_id is null"); 
	$total=mysql_fetch_array($tot);
	$tp=$total[0];	

			$q = mysql_query("SELECT sum(`available_points`) FROM cart WHERE `user_id` ='$user_id' and `entity_id` ='2' and coupon_id<>'NULL'");  
				$qid=mysql_fetch_array($q);
				$id1=$qid[0];
				$pts=$tp-$id1;
				
			$pts=$pts-$ppp;
			
			
			if($ppp <= $pts)
			{
					//echo "<script>alert($ppp <= $pts)</script>";
					$cid=$proid;
					$sponsored1=mysql_query("SELECT * FROM `tbl_sponsored` WHERE `id`=$cid");					
					$sponsored=mysql_fetch_array($sponsored1);
					$total_coupons=$sponsored['total_coupons'];
					$daily_counter=$sponsored['daily_counter'];
			
					if($total_coupons!='unlimited' and $total_coupons!='NULL' and !$total_coupons<1 ){
					$total_coupons -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `total_coupons`=\"$total_coupons\" WHERE `id`=\"$cid\"");	
					}
					if($daily_counter!='unlimited' and $daily_counter!='NULL' and !$daily_counter<1 ){
					$daily_counter -=1;
					$daily_count=mysql_query("UPDATE `tbl_sponsored` SET `daily_counter`=\"$daily_counter\" WHERE `id`=\"$cid\"");	
					}
			
			
			$insertnew = mysql_query("INSERT INTO `cart` (`id`, `entity_id`, `user_id`, `coupon_id`, `for_points`, `timestamp`, `available_points`) VALUES (NULL, \"2\", \"$user_id\",\"$proid\" ,\"$ppp\", CURRENT_TIMESTAMP, \"$ppp\" )"); 			
			
			
			
			///calling  master action log
			 
			 $sq=mysql_query("select t_complete_name,id from tbl_teacher where id='$user_id'");
									$rows1=mysql_fetch_assoc($sq);
									//$t_id1=$rows1['id'];
									$t_name=$rows1['t_complete_name'];
			 
			  $sqq=mysql_query("select Sponser_product from tbl_sponsored where id='$cid'");
									$rows11=mysql_fetch_assoc($sqq);
									//$t_id1=$rows1['id'];
									$Sponser_product=$rows11['Sponser_product'];
			 
			 
			 
			 $server_name = $_SERVER['SERVER_NAME'];
							
									$data = array('Action_Description'=>'Purchase Vendor Coupon',
												'Actor_Mem_ID'=>$user_id,
												'Actor_Name'=>$t_name,
												'Actor_Entity_Type'=>103,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$proid,
												'Points'=>$ppp,
												'Product'=>$Sponser_product,
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
			 //end
			
			if($insertnew)
			{
				
				
				echo"<script>alert('Coupons Purchased Succesfully')</script>";
			}
			
			
			
		}
		else
		{
			echo "<script>alert('unsufficient points')</script>";
			}
		
}
}


?>