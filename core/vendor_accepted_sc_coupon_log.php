<?php

//vendor_accepted_sponsor_coupon_log.php
include 'sponsor_header.php';

//tbl_selected_vendor_coupons

$q=mysql_query("select id, stud_id, coupon_id, points, product_name, issue_date, user_type, school_id from tbl_accept_coupon where sponsored_id ='$_SESSION[id]' order by id desc");
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
<div class="container-fluid" style="padding-top:5px;">
<div class="panel panel-default">
<div class="panel-heading">

<h2 class="panel-title"><b>Accepted SmartCookie Coupons Log </b><span class="badge"><?php echo mysql_num_rows($q); ?></span></h2>
</div>
<div class="panel-body">
<table id="myTable" class="table table-responsive">
<thead>
<tr><th>#</th><th>Image</th><th>Used By</th><th>User Type</th><th>Code</th><th>Product</th><th>Points</th><th>TimeStamp</th></tr>
</thead>
<tbody>
<?php 
$sr=1;
$user_name="";
while($res=mysql_fetch_array($q)){
//$entity=$res['user_type'];
$user_id=trim($res['stud_id']);
$school_id=trim($res['school_id']);
switch($res['user_type']){
	/* case '': 
		$entity_type='School Admin';
		break; */
	case 'teacher': 
		$entity_type='Teacher';
		$n=mysql_query("select t_complete_name, t_name, t_middlename,t_lastname, t_pc from tbl_teacher where id='$user_id' and school_id='$school_id'");
		$name=mysql_fetch_array($n);
		if(!empty($name['t_complete_name'])){
			$user_name=$name['t_complete_name'];
		}else{
			$user_name=$name['t_name'].' '.$name['t_middlename'].' '.$name['t_lastname'];
		}
		$user_image=$name['t_pc'];
		break;
	case 'student': 
		$entity_type='Student';
		$n=mysql_query("select std_complete_name,std_name,std_lastname,std_Father_name, std_img_path  from tbl_student where std_PRN='$user_id' and school_id='$school_id'");
		$name=mysql_fetch_array($n);
		if($name['std_complete_name']!=""){
			$user_name=$name['std_complete_name'];
		}else{
			$user_name=$name['std_name'].' '.$name['std_Father_name'].' '.$name['std_lastname'];
		}
			$user_image=$name['std_img_path'];
		break;
/* 	case 4: 
		$entity_type='Sponsor';
		break;
	case 5: 
		$entity_type='Parent';
		$n=mysql_query("select Father_name from tbl_parent where id='$user_id'");
		$name=mysql_fetch_array($n);
		$user_name=$name['Father_name'];
		break;
	case 6: 
		$entity_type='Cookie Admin';
		break;
	case 7: 
		$entity_type='School Admin Staff';
		break;
	case 2: 
		$entity_type='Cookie Admin Staff';
		break; */
}


?>
<tr>
<td><?php echo $sr; ?></td>
<td><?php if(file_exists($user_image)){ echo "<img src='".$user_image."' height='64px' width='64px'/>"; }else{ echo "<img src='image/avatar_2x.png' height='64px' width='64px'/>"; } ?></td>
<td><?php echo $user_name; ?></td>
<td><?php echo $entity_type; ?></td>
<td><?php echo $res['coupon_id']; ?></td>
<td><?php echo $res['product_name']; ?></td>
<td><?php echo $res['points']; ?></td>
<td><?php echo $res['issue_date']; ?></td>
</tr>
<?php 

$sr++; } ?>
</tbody>
</table>
</div>
</div>
</div>