<?php 
include_once('../core/conn.php');
	$state=$_POST['state'];
	$city=$_POST['city'];
	$college=$_POST['college'];
	$country=$_POST['country'];

	if($state!="0" && $city!='0' && $country!="0"){
		$where = "scadmin_state='".$state."' and scadmin_city='".$city."' and scadmin_country='".$country."'";
	}
	else if($state!="0" && $city!='0' && $country=="0"){
		$where = "scadmin_city='".$city."' and scadmin_state='".$state."'";
	}else if($state=="0" && $city!='0' && $country!="0"){
		$where = "scadmin_city='".$city."' and scadmin_country='".$country."'";
	}else if($state!="0" && $city=='0' && $country!="0"){
		$where = "scadmin_state='".$state."' and scadmin_country='".$country."'";
	}
	else if($state!="0" && $city=='0' && $country=="0"){
		$where = "scadmin_state='".$state."'";
	}else if($state=="0" && $city!='0' && $country=="0"){
		$where = "scadmin_city='".$city."'";
	}
	else if($state=="0" && $city=='0' && $country!="0"){
		$where = "scadmin_country='".$country."'";
	}
	
	if($college!="0"){
		$where.= " AND school_id='".$college."'";
	}

	$query="SELECT school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where ".$where;
	$sql_college=mysql_query($query);
?>
<table class="table table-bordered">
	<tr>
		<th>Sr. No</th>
		<th>College Id</th>
		<th>College Name</th>
	</tr>
	<?php $sr=0; while($res_coll=mysql_fetch_assoc($sql_college)){ $sr++; ?>
	<tr>
		<th><?= $sr; ?></th>
		<th><?= $res_coll['school_id']; ?></th>
		<th><?= $res_coll['school_name']; ?></th>
	</tr>
	<?php } ?>
</table>