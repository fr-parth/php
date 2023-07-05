<?php
@include_once 'conn.php';
class a{

	function datediffr($date1,$date2){

		/* 
		$date1  date in m/d/Y format  may be today's date
		$d1=trim($date1);
		$p1 = explode('/',$d1);
			$y1=@$p1['2'];
			$m1=@$p1['0'];
			$d1=@$p1['1'];
		$date1=$y1.'-'.$m1.'-'.$d1;
		//-----------------------
		//$date2  date in m/d/Y format
		$d2=trim($date2);
		$p2 = explode('/',$d2);
			$y2=@$p2['2'];
			$m2=@$p2['0'];
			$d2=@$p2['1'];
		$date2=$y2.'-'.$m2.'-'.$d2;
		//-----------------------

	$date11=date_create($date1);
	$date22=date_create($date2);
	$diff=date_diff($date11,$date22);
	$d=$diff->format("%R%a"); */
	
	$datetime1=trim($date1);//todays date
	$datetime2=trim($date2);//last date
	$DateDiff = floor( strtotime($datetime2 ) - strtotime( $datetime1 ) ) / 86400 ;
	$d=$DateDiff;
	return $d;

	}
	function total_coupon_check(){ // for all coupons
		$t1=mysql_query("SELECT `id`,`total_coupons` FROM `tbl_sponsored` WHERE `validity`!='invalid' and `total_coupons`!='unlimited'");	
		while($t=@mysql_fetch_array($t1)){
			$total_coupons=$t['total_coupons'];	
			$id=$t['id'];	
			if($total_coupons==0){
			mysql_query("UPDATE `tbl_sponsored` SET `validity`='invalid' WHERE `id`=$id");		
			}
		}
	return 1;	
	}

	function valid_until_check(){
		$t1=mysql_query("SELECT `id`,`valid_until` FROM `tbl_sponsored` WHERE `validity`!='invalid'");
		
		while($t=@mysql_fetch_array($t1)){
			$valid_until=$t['valid_until'];	
			$id=$t['id'];					
			$td=date("m/d/Y",time());		
			$di=$this->datediffr($td,$valid_until);
			
		if($di < 0){
			mysql_query("UPDATE `tbl_sponsored` SET `validity`='invalid' WHERE `id`=$id");		
			}  
		}
		return 1;	
		
	}


	function up_daily_counter(){
		$t1=mysql_query("SELECT `id`,`daily_limit`,`reset_date` FROM `tbl_sponsored` WHERE `validity`!='invalid' and `daily_limit`!='unlimited'");
		
		while($t=@mysql_fetch_array($t1)){
			$daily_limit=$t['daily_limit'];	
			$reset_date=$t['reset_date'];	
			$id=$t['id'];					
			$today=date("m/d/Y",time());		
			$daily=$this->datediffr($today,$reset_date);
		
			if($daily < 0){
	mysql_query("UPDATE `tbl_sponsored` SET `reset_date`='$today',`daily_counter`='$daily_limit' WHERE `id`=$id");		
			}
		}
	return 1;
	}

	function counter_check($val){
		if($val!='unlimited' and $val==0){
			return 0;
		}else{
			return 1;
		}	
	}
}
$abc= new a();
$abc->total_coupon_check();
$abc->valid_until_check();
$abc->up_daily_counter();


?>