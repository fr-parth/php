<?php 
include_once('../core/conn.php');
	$state=$_POST['state'];
	$city=$_POST['city'];
	$college=$_POST['college'];
	$country=$_POST['country'];
		if($state!="0" && $city!='0' && $country!="0"){
		$where = "scadmin_state='".$state."' and scadmin_city='".$city."' and scadmin_country='".$country."'";
	}else if($state!="0" && $city!='0' && $country=="0"){
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
	

	$query="SELECT school_id, school_name, aicte_application_id, aicte_permanent_id from tbl_school_admin where ".$where;
	// echo $query; exit;
	$sql_college=mysql_query($query);
?>
	<option value="0">-- Select College --</option>
	<?php while($res_coll=mysql_fetch_assoc($sql_college)){ $sr++; ?>
	 <option <?php if($college==$res_coll['school_id']){echo "selected"; } ?> value="<?= $res_coll['school_id'];?>"><?= $res_coll['school_name'];?></option>
	<?php } ?>
