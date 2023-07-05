<?php
//accept_coupon_log_ws.php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
$sp_id=xss_clean(mysql_real_escape_string($obj->{'sp_id'}));
$coupon_type=xss_clean(mysql_real_escape_string($obj->{'coupon_type'}));
$lri=xss_clean(mysql_real_escape_string($obj->{'last_record_id'}));
$server_name=$GLOBALS['URLNAME'];

//Added one variable $offset for pagination  bug no-SAND-1647 & 1648 by Dhanashri Tak 
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));

if($sp_id!="" && ($coupon_type=="smartcookie" or $coupon_type=="sponsor")){
	if($coupon_type=='smartcookie'){
		
		$tot1=mysql_fetch_array(mysql_query("select count(id) from tbl_accept_coupon where sponsored_id ='$sp_id'"));
		  $tot=$tot1[0];
		
		 
		if($lri!=''){	

		
			$sm=mysql_query("select ac.id, ac.stud_id,ac.school_id, ac.coupon_id, ac.points, ac.product_name, ac.issue_date, ac.user_type,sp.discount,ac.sponsored_id from
tbl_accept_coupon ac left join tbl_sponsored sp on ac.sponsored_id=sp.sponsor_id
and ac.product_name=sp.Sponser_product where sponsored_id ='$sp_id' and ac.`id`<'$lri'
order by ac.id desc limit 10 offset $offset")or die(mysql_query());
		}else{
			
	
			$sm=mysql_query("select ac.id, ac.stud_id,ac.school_id, ac.coupon_id, ac.points, ac.product_name, ac.issue_date, ac.user_type,sp.discount,ac.sponsored_id from
tbl_accept_coupon ac left join tbl_sponsored sp on ac.sponsored_id=sp.sponsor_id and ac.product_name=sp.Sponser_product
where sponsored_id ='$sp_id' order by ac.id desc limit 10 offset $offset")or die(mysql_query());
		}
		
		$r=mysql_num_rows($sm);
		
	}else{
		$tot1=mysql_fetch_array(mysql_query("select count(id) from tbl_selected_vendor_coupons where sponsor_id ='$sp_id'"));
		 $tot=$tot1[0];
		if($lri!=''){
			$sp= mysql_query("select sv.id as spc_id, sv.coupon_id,sp.id, sv.timestamp, sv.for_points, sv.code, sv.entity_id, sv.user_id, sp.Sponser_product,sp.discount,sv.school_id from tbl_selected_vendor_coupons sv 
			left join tbl_sponsored sp on sp.id=sv.coupon_id and sp.sponsor_id=sv.sponsor_id
			where sv.used_flag='used' and sv.sponsor_id='$sp_id' and sv.timestamp<='$lri' order by sv.timestamp desc limit 10 offset $offset")or die(mysql_query());
		}else{
			$sp= mysql_query("select sv.id as spc_id, sv.coupon_id,sp.id, sv.timestamp, sv.for_points, sv.code, sv.entity_id, sv.user_id, sp.Sponser_product,sp.discount,sv.school_id from tbl_selected_vendor_coupons sv 
			left join tbl_sponsored sp on sp.id=sv.coupon_id and sp.sponsor_id=sv.sponsor_id
			where sv.used_flag='used' and sv.sponsor_id='$sp_id' order by sv.timestamp desc limit 10 offset $offset")or die(mysql_query());
		}	
		$r=mysql_num_rows($sp);
	}

if(!($r>=1)){
	
	  			$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;

}else{

			$user_name="";
			if($coupon_type=='smartcookie'){
				
				while($res=mysql_fetch_array($sm)){
					
				$user_id=trim($res['stud_id']); 
				$school_id=trim($res['school_id']);
				switch($res['user_type']){
					case 'teacher': 
						$entity_type='Teacher';
						$n=mysql_query("select t_complete_name, t_name, t_middlename,t_lastname, t_pc from tbl_teacher where (id='$user_id') or (t_id='$user_id' and school_id='$school_id')");
						$name=mysql_fetch_array($n);
						if(!empty($name['t_complete_name'])){
							$user_name=$name['t_complete_name'];
						}else{
							$user_name=$name['t_name'].' '.$name['t_middlename'].' '.$name['t_lastname'];
						}
						$user_image=$name['t_pc'];
						if ($user_image=="")
							{
							$image="$server_name/Assets/images/avatar/avatar_2x.png";
							}
							else
							{
								$image=TEACHER_IMG_PATH.$user_image;
								
							}
						break;
					case 'student': 
						$entity_type='Student';
						$n=mysql_query("select std_complete_name, std_name, std_lastname,std_Father_name, std_img_path  from tbl_student where (id='$user_id') or (std_PRN='$user_id' and school_id='$school_id')");
						$name=mysql_fetch_array($n);
						
						if($name['std_complete_name']!=""){
							$user_name=$name['std_complete_name'];
						}else{
							$user_name=$name['std_name'].' '.$name['std_Father_name'].' '.$name['std_lastname'];
						}
					
							$user_image=$name['std_img_path'];
							if ($user_image=="")
							{
							$image="$server_name/Assets/images/avatar/avatar_2x.png";
							}
							else
							{
								$image="$server_name/core/".$user_image;
							}
						break;
	//case added for spectator by Pranali for SMC-3734
					case 'spectator':
						
						$n=mysql_query("select * from tbl_vol_spect_master where mobile='$user_id' and school_id='$school_id'");
						$name=mysql_fetch_array($n);
						$user_name=$name['name'];
						$entity_type=$name['category'];
						$image='';
						break;
						
					case 'volunteer':
						
						$n=mysql_query("select * from tbl_vol_spect_master where mobile='$user_id' and school_id='$school_id'");
						$name=mysql_fetch_array($n);
						$user_name=$name['name'];
						$entity_type=$name['category'];
						$image='';
						break;
				
					case 'coach':
						
						$n=mysql_query("select * from tbl_vol_spect_master where mobile='$user_id' and school_id='$school_id'");
						$name=mysql_fetch_array($n);
						$user_name=$name['name'];
						$entity_type=$name['category'];
						$image='';
						break;	
						
					case 'parent':
						
						$n=mysql_query("select * from tbl_vol_spect_master where mobile='$user_id' and school_id='$school_id'");
						$name=mysql_fetch_array($n);
						$user_name=$name['name'];
						$entity_type=$name['category'];
						$image='';
						break;
						
					case 'player':
						
						$n=mysql_query("select * from tbl_vol_spect_master where mobile='$user_id' and school_id='$school_id'");
						$name=mysql_fetch_array($n);
						$user_name=$name['name'];
						$entity_type=$name['category'];
						$image='';
						break;
				}
													
							$posts[] = array(
							'user_image'=>$image,
							'user_name'=>$user_name,
							'entity_type'=>$entity_type,
							'code'=>$res['coupon_id'],
							'product_name'=>$res['product_name'],
							'points'=>$res['points'],
							'discount'=>$res['discount'],
							'timestamp'=>$res['issue_date'],
							'coupon_type'=>'smartcookie',
							'coupon_id'=>$res['id'],
							'rowcount'=>$tot,
							'school_id'=>$res['school_id']
							);	
							
				}
			}elseif($coupon_type=='sponsor'){	
				
				while($res=mysql_fetch_array($sp)){
					
				  $entity=$res['entity_id'];
				 $user_id=$res['user_id'];
				switch($res['entity_id']){
					case 1: 
						$entity_type='School Admin';
						break;
					case 2: 
						$entity_type='Teacher';
						$n=mysql_query("select t_complete_name, t_name, t_middlename,t_lastname,t_pc,school_id from tbl_teacher where id='$user_id'");// Start SMC-3507 add school_id
						$name=mysql_fetch_array($n);
						if($name['t_complete_name']!=""){
							$user_name=$name['t_complete_name'];
						}else{
							$user_name=$name['t_name'].' '.$name['t_middlename'].' '.$name['t_lastname'];
						}
						$user_image=$name['t_pc'];
						if ($user_image=="")
						{
							$image="$server_name/Assets/images/avatar/avatar_2x.png";
						}
						else
						{
							$image=TEACHER_IMG_PATH.$user_image;
							
						}
						$school_id=$name['school_id'];//SMC-3507 add school_id
						break;
					case 3: 
					
						$entity_type='Student';
						$n=mysql_query("select std_complete_name, std_name,std_lastname,std_Father_name,std_img_path,school_id from tbl_student where id='$user_id' ");//SMC-3507 add school_id
						$name=mysql_fetch_array($n);
						if($name['std_complete_name']!=""){
							$user_name=$name['std_complete_name'];
						}else{
							$user_name=$name['std_name'].' '.$name['std_Father_name'].' '.$name['std_lastname'];
						}
							 $user_image=$name['std_img_path'];
							 $school_id=$name['school_id'];//SMC-3507 
							 if ($user_image=="")
							{
							$image="$server_name/Assets/images/avatar/avatar_2x.png";
							}
							else
							{
								$image="$server_name/core/".$user_image;
							}
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
						//$dt=explode(" ",$res['timestamp']);
						//$dte=explode("-",$dt[0]); 

						//$date=$dte[1].'/'.$dte[2].'/'.$dte[0];

				/* 		$user_image
						$user_name; 
						$entity_type; 
						$res['code']; 
						$res['Sponser_product']; 
						$res['for_points']; 
						$res['timestamp']; */
						
					$posts[] = array(
					'user_image'=>$image,
					'user_name'=>$user_name,
					'entity_type'=>$entity_type,
					'code'=>$res['code'],
					'product_name'=>$res['Sponser_product'],
					'points'=>$res['for_points'],
					'discount'=>$res['discount'],
					'timestamp'=>$res['timestamp'],
					'coupon_type'=>'sponsor',
					'coupon_id'=>$res['spc_id'],
					'school_id'=>$school_id,//End SMC-3507 add school_id in query & O/P
					'rowcount'=>$tot
					);
						
				 } 
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