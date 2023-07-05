<?php
//vendor_target.php
include 'sponsor_header.php';

function getSchoolName($scid){
	$sc=mysql_query("select school_name from tbl_school where id='$scid'");
	if($sc){ 
	$scn=mysql_fetch_array($sc);
	return $scn['school_name'];
	}else{
		return 0;
	}
}

function countit($query){
	$q=mysql_query($query);
	if($q){
		$r=mysql_fetch_array($q);
		return $r[0];
	}else{
		return 0;
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
<div class="col-md-12">
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"><b>College Wise Sponsor Coupon Usage</b></h4>
		</div>
		<div class="panel-body">
			<table class="table" id="myTable" name="myTable" style="text-align:left;" border='1'>
			<thead>
			<tr><th rowspan="2">#</th><th rowspan="2">School / College</th><th colspan="3">Student</th><th colspan="3">Teacher</th></tr>
				<tr>								<th >Total</th><th>Used</th><th >Unused</th>
													<th >Total</th><th >Used</th><th >Unused</th></tr>
			</thead>
			<tbody>
<?php 
       





	$s=mysql_query("select school_id,count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' group by `school_id`");
	$sr=1;
	while($r=mysql_fetch_array($s)){
		$school_id=$r[0];
		$count=$r[1];
		$school_name=getSchoolName($school_id);
					
$studs=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='3'");
$used_studs=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='3' and used_flag='used'");					
$unused_studs=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='3' and used_flag='unused'");	


$teachers=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='2'");
$used_teachers=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='2' and used_flag='used'");					
$unused_teachers=countit("select count(id) from tbl_selected_vendor_coupons where sponsor_id='$id' and school_id='$school_id' and entity_id='2' and used_flag='unused'");
		
			?>		
			
			
<tr><td><?php echo $sr; ?></td><td><?php echo $school_name; ?><span class="badge"><?php echo $count; ?></span></td><td><?php echo $studs; ?></td><td><?php echo $used_studs; ?></td><td><?php echo $unused_studs; ?></td><td><?php echo $teachers; ?></td><td><?php echo $used_teachers; ?></td><td><?php echo $unused_teachers; ?></td></tr>
				
<?php $sr++; } ?>	</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>
<table>
