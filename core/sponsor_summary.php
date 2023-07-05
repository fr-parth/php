<?php 

include 'conn.php';

define('SP_ID',349);
//id 	entity_id 	user_id 	coupon_id 	for_points 	timestamp 	code 	used_flag 	sponsor_id 	valid_until

function countit($query){
	$q=mysql_query($query);
	if($q){
		$r=mysql_fetch_array($q);
		return $r[0];
	}else{
		return 0;
	}	
}

function user_type($entity){
		switch($entity){
		case 1: 
			$entity_type='School Admin';
			break;
		case 2: 
			$entity_type='Teacher';
			break;
		case 3: 
			$entity_type='Student';
			break;
		case 4: 
			$entity_type='Sponsor';
			break;
		case 5: 
			$entity_type='Parent';
			break;
		case 6: 
			$entity_type='Cookie Admin';
			break;
		case 7: 
			$entity_type='School Admin Staff';
			break;
		case 8: 
			$entity_type='Cookie Admin Staff';
			break;
		}
		return $entity_type;
}

function user($query){
	$q=mysql_query($query);	
	$r= array();
	if($q){		
		$r=mysql_fetch_array($q);
		return $r;		
	}else{
		return 0;
	}	
}

function getuserinfo($entity, $user_id){
	switch($entity){
	case 1: 		
		$r=user("select scadmin_city,img_path from tbl_school_admin where id='$user_id'");		
		break;
	case 2: 
		$r=user("select t_city,t_pc from tbl_teacher where id='$user_id'");			
		break;
	case 3:		
		$r=user("select std_city,std_img_path from tbl_student where id='$user_id'");		
		break;
	case 4:		
		$r=user("select sp_city,sp_img_path from tbl_sponsorer where id='$user_id'");	
		break;
	case 5: 		
		$r=user("select city,p_img_path from tbl_parent where id='$user_id'");		
		break;
/* 	case 6: 
		$entity_type='Cookie Admin';
		break;
	case 7: 
		$entity_type='School Admin Staff';
		break;
	case 8: 
		$entity_type='Cookie Admin Staff';
		break; */
	}	
	return $r;
}

// --total_generated_coupons 
echo "<b>Total Generated Coupons</b> => ".$total_generated_coupons = countit("SELECT count(id) FROM tbl_sponsored WHERE `sponsor_id`=".SP_ID);
echo "<br/>";
//---end total_generated_coupons

//---sponsor_coupon_summary according to product and its use
$q=mysql_query("select id, Sponser_product, points_per_product from tbl_sponsored where `sponsor_id`=".SP_ID);

echo "<table>
	<tr><th>#</th><th>Product</th><th>Selected Coupons</th><th>Used Coupons</th><th>Unused Coupons</th></tr>";
	$sr=1;
	$s=0;
	$u=0;
	$un=0;
while($res=mysql_fetch_array($q)){
	$cid=$res['id'];
	$name=strtolower(trim($res['Sponser_product']));
	$ppp=$res['points_per_product'];
	
$selected=countit("SELECT count(id) FROM tbl_selected_vendor_coupons WHERE coupon_id='$cid' and `sponsor_id`=".SP_ID);
$unused=countit("SELECT count(id) FROM tbl_selected_vendor_coupons WHERE coupon_id='$cid' and used_flag='unused' and `sponsor_id`=".SP_ID);
$used=countit("SELECT count(id) FROM tbl_selected_vendor_coupons WHERE coupon_id='$cid' and used_flag='used' and  `sponsor_id`=".SP_ID);
	echo "<tr><td>$sr</td><td>".ucwords($name)."</td><td>$selected</td><td>$used</td><td>$unused</td></tr>";
	
	$s+=$selected;
	$u+=$used;
	$un+=$unused;
	
	$sr++;
}
echo "<tr><td></td><td>Total</td><td>$s</td><td>$u</td><td>$un</td></tr>";
echo "</table>";
//---end sponsor_coupon_summary according to product and its use




//---sponsor coupon users
$u=mysql_query("SELECT entity_id, count(*) as cnt FROM tbl_selected_vendor_coupons WHERE sponsor_id=".SP_ID." GROUP BY entity_id");

$counts = array();
while ($us = mysql_fetch_assoc($u)) {    

	$counts[user_type($us['entity_id'])] = $us['cnt'];	
}

echo "<ul>
		<lh><b>Users:</b></lh>";
foreach($counts as $key =>$value){
	echo "<li>$key : $value</li>";
}
echo "</ul>";

//---end sponsor coupon users




//---where my users are
$u=mysql_query("SELECT entity_id, user_id FROM tbl_selected_vendor_coupons WHERE sponsor_id=".SP_ID);

$cities = array();
$user_images = array();
while ($us = mysql_fetch_assoc($u)) {
	$entity=$us['entity_id'];
	$user_id=$us['user_id'];
	$s= getuserinfo($entity, $user_id);
	
	$cities[]=$s[0];	
	$user_images[]=$s[1];
	//user_type($us['entity_id']);	
}
 
$c=array_unique($cities,SORT_STRING);
$img=array_unique($user_images,SORT_STRING);

echo "<ul>
		<lh><b>Users From Cities:</b></lh>";
foreach($c as $key => $value){
	  if($value!="" and $value!=NULL){ echo "<li>".$value."</li>"; }
} 
echo "</ul>";

echo "<b>Users:</b><br/>";
foreach($img as $key=>$value){
	// echo $value."<br/>";
	if(file_exists($value)){ 
		echo "<img src='".$value."' height='64px' width='64px'/>"; 
	}
}
//---end where are my users are

?>


