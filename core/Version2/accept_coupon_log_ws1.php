<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
$sp_id=$obj->{'sp_id'};

if($sp_id!=""){
$sm=mysql_query("select id, stud_id, coupon_id, points, product_name, issue_date, user_type, school_id from tbl_accept_coupon where sponsored_id ='$sp_id' order by id desc");

$sp= mysql_query("select sv.id as spc_id, sv.coupon_id,sp.id, sv.timestamp, sv.for_points, sv.code, sv.entity_id, sv.user_id, sp.Sponser_product from tbl_selected_vendor_coupons sv 
 left join tbl_sponsored sp on sp.id=sv.coupon_id and sp.sponsor_id=sv.sponsor_id
where sv.used_flag='used' and sv.sponsor_id='$sp_id' order by sv.id desc")or die(mysql_query());
$r=mysql_num_rows($sm)+ mysql_num_rows($sp);

if(!($r>=1)){
	  			$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;

}else{

$user_name="";

			while($res=mysql_fetch_array($sm)){
			$user_id=trim($res['stud_id']);
			$school_id=trim($res['school_id']);
			switch($res['user_type']){
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
			}
						/* 	$user_image
							$user_name; 
							$entity_type; 
							$res['coupon_id']; 
							$res['product_name']; 
							$res['points']; 
							$res['issue_date'];  */				
						
						$posts[] = array(
						'user_image'=>$user_image,
						'user_name'=>$user_name,
						'entity_type'=>$entity_type,
						'code'=>$res['coupon_id'],
						'product_name'=>$res['product_name'],
						'points'=>$res['points'],
						'timestamp'=>$res['issue_date'],
						'coupon_type'=>'smartcookie',
						'coupon_id'=>$res['id']
						);	
			}

			while($res=mysql_fetch_array($sp)){
			$entity=$res['entity_id'];
			$user_id=$res['user_id'];
			switch($res['entity_id']){
				case 1: 
					$entity_type='School Admin';
					break;
				case 2: 
					$entity_type='Teacher';
					$n=mysql_query("select t_complete_name, t_name, t_middlename,t_lastname,t_pc from tbl_teacher where id='$user_id'");
					$name=mysql_fetch_array($n);
					if($name['t_complete_name']!=""){
						$user_name=$name['t_complete_name'];
					}else{
						$user_name=$name['t_name'].' '.$name['t_middlename'].' '.$name['t_lastname'];
					}
					$user_image=$name['t_pc'];
					break;
				case 3: 
					$entity_type='Student';
					$n=mysql_query("select std_complete_name,std_name,std_lastname,std_Father_name,std_img_path from tbl_student where id='$user_id' ");
					$name=mysql_fetch_array($n);
					if($name['std_complete_name']!=""){
						$user_name=$name['std_complete_name'];
					}else{
						$user_name=$name['std_name'].' '.$name['std_Father_name'].' '.$name['std_lastname'];
					}
						$user_image=$name['std_img_path'];
					break;
				case 4: 
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
					break;
			}
					$dt=explode(" ",$res['timestamp']);
					$dte=explode("-",$dt[0]); 

					$date=$dte[1].'/'.$dte[2].'/'.$dte[0];

			/* 		$user_image
					$user_name; 
					$entity_type; 
					$res['code']; 
					$res['Sponser_product']; 
					$res['for_points']; 
					$res['timestamp']; */
					
				$posts[] = array(
				'user_image'=>$user_image,
				'user_name'=>$user_name,
				'entity_type'=>$entity_type,
				'code'=>$res['code'],
				'product_name'=>$res['Sponser_product'],
				'points'=>$res['for_points'],
				'timestamp'=>$date,
				'coupon_type'=>'sponsor',
				'coupon_id'=>$res['spc_id']
				);
		 } 
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
 
}
header('Content-type: application/json');
echo json_encode($postvalue);
}else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;

	header('Content-type: application/json');
	echo  json_encode($postvalue); 
} 
 ?>