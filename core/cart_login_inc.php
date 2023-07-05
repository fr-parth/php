<?php
function upcartonlogin($entity,$id, $rid, $school_id){
if($entity==3){
if($rid!=""){
$get_points= mysql_query("select sc_total_point,yellow_points,purple_points from `tbl_student_reward` sr
join  tbl_student s on sr.sc_stud_id=s.std_PRN where s.id='$id' and s.std_PRN='$rid'");	
				
	$pts1=mysql_fetch_array($get_points);
	$pts_green=$pts1['sc_total_point'];
	$pts_yellow=$pts1['yellow_points'];
	$pts_purple=$pts1['purple_points'];					
	$pts=$pts_green+$pts_yellow+$pts_purple;
}else{
	$pts=0;
}	
}

if($entity==2){
	//teacher	
$get_points= mysql_query("select balance_blue_points from `tbl_teacher` where id ='$id'");
			$pts1=mysql_fetch_array($get_points);
			$pts_blue=$pts1['balance_blue_points'];
			$pts=$pts_blue;
}
if($entity==5){
	//parent
}				
$r=@mysql_query("select id from cart where entity_id='$entity' and user_id='$id' and coupon_id is null");
if(@mysql_num_rows($r)){
	$q=mysql_query("update `cart` set `timestamp`=CURRENT_TIMESTAMP, `available_points`='$pts' where entity_id='$entity' and user_id='$id' and coupon_id is null");
}else{
	$q=mysql_query("INSERT INTO `cart` (`id`, `entity_id`, `user_id`, `coupon_id`, `for_points`, `timestamp`, `available_points`) VALUES (NULL, \"$entity\", \"$id\", NULL, NULL, CURRENT_TIMESTAMP, \"$pts\" )");
}	

	if($q){
		return true;
	}else{
		return false;
	}			
}
?>