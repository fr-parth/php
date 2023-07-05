<?php
include 'coupon.inc.php';
$rid=$_SESSION['rid'];
$user_id=$_SESSION['id'];
$school_id=$_SESSION['school_id'];


	//get maximum points available with the user at the start
	$p = mysql_query("SELECT available_points FROM cart WHERE `user_id`='$user_id' and `entity_id`='$entity' and coupon_id is null");  
	$pt=mysql_fetch_array($p);
	$maxpt=$pt[0];
		
	$cartinfo =mysql_query("SELECT * FROM cart WHERE `entity_id` ='$entity' and `user_id`='$user_id'");
	$num_rows=mysql_num_rows($cartinfo);

if(isset($_GET['delitem'])){
	mysql_query("DELETE FROM `cart` WHERE `id`= '$_GET[delitem]'");
	header("Location: cart.php");
}
	
	
	if(isset($_POST['submit'])){
	//get minimum points available with the user in cart table 
	$q = mysql_query("SELECT sum(available_points) FROM cart WHERE `user_id`='$user_id' and `entity_id`='$entity' and coupon_id<>'NULL'");  
		$qid=mysql_fetch_array($q);
		$id1=$qid[0];
		$pts=$maxpt-$id1;
		if($entity==3){	
		
$get_points= mysql_query("select sc_total_point,yellow_points,purple_points from `tbl_student_reward` sr
join  tbl_student s on sr.sc_stud_id=s.std_PRN where s.id='$id' and s.std_PRN='$rid'");
					
					$pts1=mysql_fetch_array($get_points);
					
					$pts_green=$pts1['sc_total_point'];
					$pts_yellow=$pts1['yellow_points'];
					$pts_purple=$pts1['purple_points'];
					
				$tp=$pts_green + $pts_yellow + $pts_purple;
				
				$deduct=$id1;
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
/* select sc_total_point,yellow_points,purple_points from `tbl_student_reward` sr
join  tbl_student s on sr.sc_stud_id=s.std_PRN where s.id='$id' and s.std_PRN='$rid'
				
		update ud u
inner join sale s on
    u.id = s.udid
set u.assid = s.assid
 */

		$q=mysql_query("UPDATE `tbl_student_reward` sr INNER JOIN tbl_student s ON sr.sc_stud_id=s.std_PRN SET `sc_total_point`='$pts_green', `yellow_points`='$pts_yellow', `purple_points`='$pts_purple' WHERE s.id='$id' and s.std_PRN='$rid' ");
				$p=mysql_query("UPDATE `cart` SET `available_points`='$pts' WHERE `user_id`='$user_id' and `entity_id`='$entity' and `coupon_id` is null");
		}elseif($entity==2){	
			
			
			$q=mysql_query("UPDATE `tbl_teacher` SET `balance_blue_points`='$pts' WHERE `id`='$user_id'");
			$p=mysql_query("UPDATE `cart` SET `available_points`='$pts' WHERE `user_id`='$user_id' and `entity_id`='$entity' and `coupon_id` is null");
		}


			if($q and $p){
				
			$q = mysql_query("SELECT * FROM cart WHERE `user_id`='$user_id' and `entity_id`='$entity' and `coupon_id`!=''");
				$sr=1;
				while($p = mysql_fetch_array($q)){
					
					$cid=$p['coupon_id'];
					$ppp=$p['for_points'];
					$time=$p['timestamp'];
					$ts=explode(' ',$time);
					$date=$ts[0];
					$tm=$ts[1];
					
					$sponsored1=mysql_query("SELECT * FROM `tbl_sponsored` WHERE `id`=$cid");
					
					$sponsored=mysql_fetch_array($sponsored1);
					$priority=$sponsored['priority'];
					$sp_id=$sponsored['sponsor_id'];
					$product=$sponsored['Sponser_product'];
					$product_image=$sponsored['product_image'];
					
					$total_coupons=$sponsored['total_coupons'];
					$daily_counter=$sponsored['daily_counter'];
					$valid_until=$sponsored['valid_until'];
					$coupon_code_ifunique=$sponsored['coupon_code_ifunique'];
					
					$sp=mysql_query("SELECT * FROM tbl_sponsorer WHERE `id`=$sp_id");
					$s=mysql_fetch_array($sp);
					$used_flag='unused';
					$logo=$s['sp_img_path'];
					$company=$s['sp_company'];
					$address=$s['sp_address'];
				if(empty($coupon_code_ifunique)){
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
				
		
				
$insert_selected_vendor_coupons=mysql_query("INSERT INTO tbl_selected_vendor_coupons (id, entity_id, user_id,	coupon_id, for_points, timestamp, code,	used_flag, sponsor_id, valid_until, school_id) VALUES(NULL,\"$entity\",\"$user_id\",\"$cid\",\"$ppp\",CURRENT_TIMESTAMP,\"$code\",\"$used_flag\",\"$sp_id\",\"$valid_until\",\"$school_id\")");
				$delete_cart=mysql_query("DELETE FROM `cart` WHERE `user_id`=$user_id and `entity_id`=$entity and `coupon_id`!=''");
				 $sr++;
				 } 
				header( "Location:view_print_coupons.php" );		
			}
		
	}

?>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<div class="container-fluid">
<div class="panel panel-default">
  <div class="panel-heading"><b>My Coupons</b></div>
	<?php if($num_rows>1){?>
	<div class="table-responsive">
	<table class="table" id="myTable">
	<thead>
	<tr ><th>#</th><th>Coupon ID</th><th>Company Logo</th><th>Company Name</th><th>Product Name</th><th>Address</th><th>Points</th><th></th></tr></thead><tbody>
   <?php
	$sr=1;$tot=0;
	while($result = mysql_fetch_array($cartinfo )){
		$cid=$result['coupon_id'];
		$cart_row_id=$result['id'];
		$pts=$result['for_points'];
		if($cid!=NULL and $pts!=NULL){ 
			$sponsored1=mysql_query("SELECT * FROM `tbl_sponsored` WHERE `id`=$cid");
			$sponsored=mysql_fetch_array($sponsored1);
			$sp_id=$sponsored['sponsor_id'];
			$product=$sponsored['Sponser_product'];
			$product_image=$sponsored['product_image'];
			
			$sp=mysql_query("SELECT * FROM tbl_sponsorer WHERE `id`=$sp_id");
			$s=mysql_fetch_array($sp);
	
			$logo=$s['sp_img_path'];
			$company=$s['sp_company'];
			$address=$s['sp_address'];
			
			?>		
			
			<tr ><td><?php echo $sr;?></td><td><?php echo $cid;?></td>
		<?php if(file_exists($logo)){ ?><td><img src="<?php echo $logo;?>" style="height:83px; width:120px;" /></td><?php } else{ ?><td><img src="image/newlogo1.png" style="height:83px; width:120px;" /></td><?php } ?>
			<td><?php echo $company;?></td><td><?php echo $product;?></td>
			<td><?php echo $address; ?></td><td><?php echo $pts;?></td><td><a href="cart.php?delitem=<?php echo $cart_row_id; ?>"><span class=" glyphicon glyphicon-trash"></span></a></td></tr>
			<?php $tot=$tot+$pts; $sr++;
		}
	} 
	?>
	
	<tr><td>Remaining Points</td><td><?php echo $rm=$maxpt-$tot;?></td><td></td><td></td><td></td><td></td><td><b><?php echo $tot;?></b></td><td></td></tr></tbody>
	</table>
	
<?php	if($tot!=0){ ?>
	<table class="table table-responsive">
	<tr><td><b></b></td><td></td><td></td><td></td>
	<td><a href="coupons.php"><input type="button" class="btn btn-info" value="Add More" /></a></td>
	<td><a href="cart_delete.php"><input type="button"  name="cancel"  value="Cancel" class="btn btn-danger" /></a></td>
	<td><b><form method="post"><input type="submit" name="submit" value="Confirm" class="btn btn-success"/></form></b></td><td></td></tr></table>
<?php } ?>
	
	
	</div><?php }else{?>
	<div class="alert alert-danger" role="alert" align="center">
	<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"> &nbsp;&nbsp;&nbsp;&nbsp;
	</span>You haven't selected coupons yet.</div>
	<div class="row" align="center" style="padding-top:10px; padding-bottom:10px;">
	<a href="coupons.php"><input type="button"  value="Select Coupons" class="btn btn-default" style=""/></a>
	<a href="view_print_coupons.php"><input type="button" value="View Selected Coupons" class="btn btn-default" style=""/></a>
	</div><?php } ?> 
</div></div>
<?php ?>


