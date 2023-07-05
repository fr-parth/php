<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

$selid = xss_clean(mysql_real_escape_string($obj->{'selid'}));
$proid = xss_clean(mysql_real_escape_string($obj->{'coupon_id'}));
if($selid!='' && $proid!=''){
	$counter1=mysql_query("select total_coupons, daily_counter from tbl_sponsored spd where spd.id='$proid'");
	$counter=mysql_fetch_array($counter1);

	$total_coupons=$counter['total_coupons'];
	
	if($total_coupons!='unlimited' and $total_coupons!='NULL' and !$total_coupons<1 ){
		$total_coupons +=1;
		
		mysql_query("UPDATE tbl_sponsored SET total_coupons='$total_coupons' WHERE `id`='$proid'");

	}				
	
	$daily_counter=$counter['daily_counter'];	
	
	if($daily_counter!='unlimited' and $daily_counter!='NULL' and !$daily_counter<1 ){
			$daily_counter +=1;
		mysql_query("UPDATE tbl_sponsored SET daily_counter='$daily_counter' WHERE `id`='$proid'");
	}
	
	
	
	$q=mysql_query("DELETE FROM cart WHERE id='$selid'");
	
			if($q){
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']="coupon $proid get deleted";			
			}else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;				
			}
}else{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;	
}
header('Content-type: application/json');
echo json_encode($postvalue); 
?>
