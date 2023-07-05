<?php 
@include 'sponsor_header.php';
@include 'conn.php';
$user_id=$_SESSION['id'];
$entity=$_SESSION['entity'];
if($entity!=4){
	header("Location:login.php");
}
//coupon deletion
if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query(" DELETE FROM `tbl_sponsored` WHERE `id`= $del ");
	header("Location: vendor_generated_coupons.php");

}
	mysql_query(" DELETE FROM `tbl_sponsored` WHERE `Sponser_product` is null ");
//
$get_cpn = mysql_query("SELECT * FROM tbl_sponsored WHERE `sponsor_id` = $user_id ORDER BY `id` DESC ");
$num_rows = mysql_num_rows($get_cpn);
$sr=1;
 ?>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<style>
.row{
	padding-top:10px;
}
</style>

<div class="panel panel-default">
  <div class="panel-heading">
  <h2 class="panel-title"><b>Sponsored Coupons</b> <span class="badge"><?php echo $num_rows;?></span></h2>
  </div>
  <div class="panel-body">
	<?php if($num_rows >=1){ ?>
	
	<div class="table-responsive">
	<table class="table" id="myTable">
	<thead>
	<tr>
	<th>#</th>
	<th>Coupon ID</th>
<!--	<th>Sponsored Type</th>-->
	<th>Product Name</th>
<!--	<th>Image</th>-->
	<th>Purchase Points</th>
	<th>Start Date</th>
	<th>End Date</th>
	
	<th>Category</th>
	<th>Price</th>
	<th>Discount</th>
	<th>Buy</th>
	<th>Buy_Get</th>
<!--	<th>Saving</th>
	<th>Description</th>
	<th>Daily Limit</th>
	<th>Total Coupons</th>
	
	<th>Unique Code</th>
	<th>Priority</th>-->
	<th></th>
	<th></th>	
	</tr>
	</thead>
	<tbody>
<?php

while($cpn=mysql_fetch_array($get_cpn)){ 
$cat=$cpn['category'];
if($cat!=0 or $cat!=null){
$cat1=mysql_query("SELECT `category` FROM `categories` WHERE `id`= $cat");
$cat2=mysql_fetch_array($cat1);
$category=$cat2['category'];
}else{
		$category=null;		
}
	
	$currid=$cpn['currency'];
	if($currid!=0 or $currid!=null){
		
	$curre=mysql_query("SELECT `currency` FROM `currencies` WHERE `id`=$currid ");	
	$curr=mysql_fetch_array($curre);
	$currency=$curr['currency'];
	}else{
		$currency=null;		
	}
?>

	<tr>
	<td><?php echo $sr; ?></td>
	<td><?php echo $cpn['id']; ?></td>
<!--	<td><?php// echo $cpn['Sponser_type']; ?></td>-->
	<td><?php echo $cpn['Sponser_product']; ?></td>
<!--	<td>
	
		<?php if(file_exists($cpn['product_image'])){ ?>
		<img src="<?php echo $cpn['product_image'];?>" style="height:52.5px; width:52.625px;" /> 
		<?php } elseif($cpn['Sponser_type']=='discount'){ ?>
		<img src="images/discount.png" style="height:52.5px; width:52.625px;" /> 
		<?php } ?>
		
	</td> -->
	<td><?php echo $cpn['points_per_product']; ?></td>
	<td><?php echo $cpn['sponsered_date']; ?></td>
	<td><?php echo $cpn['valid_until']; ?></td>
	
	<td><?php echo $category; ?></td>
	<td><?php echo $currency.' '.$cpn['product_price']; ?></td>
	
	<td><?php echo $cpn['discount']; ?></td>
	<td><?php echo $cpn['buy']; ?></td>
	<td><?php echo $cpn['get']; ?></td>
<!--<td><?php // echo $cpn['saving']; ?></td>
	<td><?php //echo $cpn['offer_description']; ?></td>
	<td><?php //echo $cpn['daily_limit']; ?></td>
	<td><?php //echo $cpn['total_coupons']; ?></td>
	
	<td><?php //echo $cpn['coupon_code_ifunique']; ?></td>
	<td><?php //echo $cpn['priority']; ?></td> -->
	<td><a href="sp_coupon.php?up=<?php echo $cpn['id']; ?>" >
	<span class="glyphicon glyphicon-pencil"></span>
	</a></td> 
	<td><a href="vendor_generated_coupons.php?del=<?php echo $cpn['id']; ?>" >
	<span class="glyphicon glyphicon-trash"></span>
	</a></td>
	</tr>

	<?php $sr++;	} ?>
</tbody>
</table></div>
	<?php	} else{ ?>
	You have not generated any coupons yet.
	<?php	} ?>
</div>	</div>
</body>


</html>
