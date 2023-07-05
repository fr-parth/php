<?php
//login sponsor shop.php
include("conn.php");

if(isset($_GET['id']) && $_GET['id']!=""){
	
					$_SESSION['id'] = $_GET['id'];					
					//$_POST['username']=$username;
 					//$_SESSION['username'] = $_POST['username'];
					unset($_SESSION['ids']);
					header("Location:coupon_accept.php");
					
}
?>
<!DOCTYPE html>
<html>
<head>
<link href="bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>

</head>
<body>
<div class="container-fluid">
<div class="col-md-12">

<div class="row">
<h3>Select Shop</h3>
</div>



<div class="row">

<table id="myTable" name="myTable" class="table" >
<thead>
<tr><th>#</th><th>Sponsor Name</th><th>Company</th><th>Mobile</th><th>Email</th><th>Address</th><th>City</th><th>Select Shop</th></tr>
</thead>
<tbody>

<?php
$sr=1;
foreach($_SESSION['ids'] as $key => $value){	

$s=mysql_query("select id, sp_company, sp_img_path, sp_address, sp_city, sp_name, sp_phone, sp_email from tbl_sponsorer where id='$value'");
$r=mysql_fetch_array($s);
?>
<tr><td><?php echo $sr; ?></td><td>
		
		<?php echo $r['sp_name']; ?></td><td>
		<?php echo $r['sp_company']; ?></td><td>
		<?php echo $r['sp_phone']; ?></td><td>
		<?php echo $r['sp_email']; ?></td><td>
		<?php echo $r['sp_address']; ?></td><td>
		<?php echo $r['sp_city']; ?></td><td>
	<a href="login_shop.php?id=<?php echo $value; ?>">
	<!--<input type='button' name='submit' id='submit' value='Select' class='btn btn-success' />-->
	<span class="glyphicon glyphicon-circle-arrow-right" ></span></a>
</td><!--<td><input type='radio' class="form-control" name='id' value='<?php echo $value; ?>'></td>--></tr>
<?php
$sr++;
 } ?>

</tbody>
</table>

</div>

</div>
</div>

</body>
</html>