<?php
//sponsored_coupons
include("cookieadminheader.php");
//Comment include conn file to display coupon by Dhanashri
//@include 'conn.php';
$user_id=$_SESSION['id'];
//coupon deletion
if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query(" DELETE FROM `tbl_sponsored` WHERE `id`= $del ");
	$sp_id=$_COOKIE['cpns'];
	$get_cpn = mysql_query("SELECT * FROM tbl_sponsored WHERE `sponsor_id` = $sp_id ");
	$num_rows = mysql_num_rows($get_cpn);
}
if(isset($_GET['cpns'])){
	$sp_id=$_GET['cpns'];
	setcookie("cpns",$sp_id,time()+3600);
	$get_cpn = mysql_query("SELECT * FROM tbl_sponsored WHERE `sponsor_id` = $sp_id ");
	$num_rows = mysql_num_rows($get_cpn);
	$sp_name=mysql_query("SELECT `sp_name` FROM tbl_sponsorer WHERE `id` = $sp_id ");
	$spname=mysql_fetch_array($sp_name);
	$sponsor=$spname['sp_name'];
}
$sr=1;
 ?>
  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#example').DataTable();
});
</script>
<div class="container-fluid">
<div class="panel panel-default" width='100%'>
  <div class="panel-heading"><center><h3>Coupons Sponsored By</h3><h2 class='panel-title'><?php echo strtoupper($sponsor); ?></h2></center></div>
	<?php if($num_rows >= 1){ ?>
	<div class="table-responsive">
	<table class="table" id='example'>
	<thead>
	<tr>
	<th>#</th>
	<th>Coupon ID</th>
<!--	<th>Sponsored Type</th>-->
	<th>Product Name</th>
	<th>Image</th>
	<th>Points</th>
	<th>Start Date</th>
	<th>End Date</th>
	
	<th>Category</th>
	<th>Price</th>
	<th>Discount</th>
	<th>Buy</th>
	<th>Get</th>
	<th>Saving</th>
	<th>Description</th>
	<th>Daily Limit</th>
	<th>Total Coupons</th>
	
	<th>Unique Code</th>
	<th>Priority</th>
<th></th> 
	<th></th>	
	</tr></thead><tbody>
<?php
while($cpn=mysql_fetch_array($get_cpn)){ 
$cat=$cpn['category'];
$cat1=mysql_query("SELECT `category` FROM `categories` WHERE `id`= $cat ");
$cat2=mysql_fetch_array($cat1);
$category=$cat2['category'];
?>
	<tr>
	<td><?php echo $sr; ?></td>
	<td><?php echo $cpn['id']; ?></td>
<!--	<td><?php echo $cpn['Sponser_type']; ?></td>-->
	<td><?php echo $cpn['Sponser_product']; ?></td>
	<td><img src="<?php echo $cpn['product_image'];?>" style="height:50px; width:120px;" /></td>
	<td><?php echo $cpn['points_per_product']; ?></td>
	<td><?php echo $cpn['sponsered_date']; ?></td>
	<td><?php echo $cpn['valid_until']; ?></td>
	<td><?php echo $category; ?></td>
	<td><?php echo $cpn['currency'].' '.$cpn['product_price']; ?></td>
	<td><?php echo $cpn['discount']; ?></td>
	<td><?php echo $cpn['buy']; ?></td>
	<td><?php echo $cpn['get']; ?></td>
	<td><?php echo $cpn['saving']; ?></td>
	<td><?php echo $cpn['offer_description']; ?></td>
	<td><?php echo $cpn['daily_limit']; ?></td>
	<td><?php echo $cpn['total_coupons']; ?></td>
	<td><?php echo $cpn['coupon_code_ifunique']; ?></td>
	<td><?php echo $cpn['priority']; ?></td> 
	<td><a href="single_field_edit.php?pri=<?php echo $cpn['id']; ?>" ><button type="button" class="btn btn-primary">Set Priority</button></a></td>
	<td><a href="sponsored_coupons.php?del=<?php echo $cpn['id']; ?>" ><span class="glyphicon glyphicon-trash"></span></a></td>
	</tr>
	<?php $sr++;	} ?>
</tbody>
</table>
	<?php	} ?>
	<a class="btn btn-primary" href="sponsor_sponsored.php" role="button">Back</a>
	</div>
	
	</div>
</div>
	</body>
</html>