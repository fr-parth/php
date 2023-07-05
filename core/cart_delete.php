<?php
	@include 'conn.php';
	if(isset($_SESSION['id'])){
		$user_id=$_SESSION['id'];
		$entity=$_SESSION['entity'];
			
			$cpn1=mysql_query("SELECT `coupon_id` FROM `cart` WHERE `entity_id`='$entity' and `user_id` ='$user_id' and `coupon_id`<>'NULL'");
			
			while($cpn=mysql_fetch_array($cpn1)){
				$cid=$cpn['coupon_id'];
					
					$sponsored1=mysql_query("SELECT * FROM `tbl_sponsored` WHERE `id`=$cid");					
					$sponsored=mysql_fetch_array($sponsored1);
					$total_coupons=$sponsored['total_coupons'];
					$daily_counter=$sponsored['daily_counter'];
			
					if($total_coupons!='unlimited'){
					$total_coupons +=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `total_coupons`=\"$total_coupons\" WHERE `id`=\"$cid\"");	
					}
					if($daily_counter!='unlimited'){
					$daily_counter +=1;
					$daily_count=mysql_query("UPDATE `tbl_sponsored` SET `daily_counter`=\"$daily_counter\" WHERE `id`=\"$cid\"");	
					}
			}	
				mysql_query("DELETE FROM `cart` WHERE `entity_id`='$entity' and `user_id` ='$user_id' and `coupon_id`<>'NULL'");	
		if($entity==3){
		header('Location:student_dashboard.php');
		}elseif($entity==2){
		header('Location:dashboard.php');
		}
	}else{
	header('Location:login.php');	
	}
?>