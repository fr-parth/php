<?php
//vendors_suggested.php
//home_cookieadmin.php
include("corporate_cookieadminheader.php");

$entity=$_SESSION['entity'];
if($entity!=6){
	header('Location:login.php');
}

$svlist=mysql_query("SELECT sp.id,sp_name,v_category,sp_phone,sp_email,sp_address,sp_city,sp_state,sp_country,v_status,v_likes,cat.category FROM `tbl_sponsorer` sp LEFT JOIN categories cat ON v_category=cat.id WHERE v_likes!='' ORDER BY `v_likes` DESC")or die(mysql_error());


?>
 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#example').DataTable();
});
</script>
<div class="panel panel-default" style="min-height:100%; overflow:hidden;">
  <!-- Default panel contents -->
  <div class="panel-heading">Suggested Sponsors List With Likes</div>

  <!-- Table -->
  <table class="table" id='example'>
  <thead>
    <tr><td>#</td><td>ID</td><td>Sponsor Name</td><td>Category</td><td>Email</td><td>Phone</td><td>Address</td><td>Status</td><td>Likes</td></tr>
	</thead>
	<tbody>

<?php
$sr=1;
while($svl=mysql_fetch_array($svlist)){
	$svid=$svl['id'];
	$v_name=$svl['sp_name'];
	$cat=$svl['v_category'];
	$v_email=$svl['sp_email'];
	$v_phone=$svl['sp_phone'];
	$v_address=$svl['sp_address'];
	$v_status=$svl['v_status'];
	$v_likes=$svl['v_likes'];	
	$cat1=mysql_query("SELECT `category` FROM `categories` WHERE `id`='$cat'");
$cat2=mysql_fetch_array($cat1);
$v_category=$cat2['category'];
?>	
	<tr><td><?php echo $sr;?></td>
		<td><?php echo $svid;?></td>
		<td><?php echo $v_name;?></td>
		<td><?php echo $v_category;?></td>
		<td><?php echo $v_email;?></td>
		<td><?php echo $v_phone;?></td>
		<td><?php echo $v_address;?></td>
		<td><?php echo $v_status;?></td>
		<td><?php echo $v_likes;?></td>
	</tr>
	
<?php $sr++; }
?>	</tbody>
  </table>
</div>
</html>