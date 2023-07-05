	
<?php 
//save_selected_coupon.php 
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';

$entity=$obj->{'entity'};
$user_id=$obj->{'user_id'};    
$cid=$obj->{'coupon_id'};    
$pts=$obj->{'remaining_points'};

if($entity=="" or $user_id=="" or $cid=="" or $pts==""){
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
			header('Content-type: application/json');
			echo json_encode($postvalue); 
  die();
}



	if($entity==3){
		$p=mysql_query("select school_id from tbl_student where id='$user_id'")or die(mysql_query()); 
		$s=mysql_fetch_array($p);
		$school_id=$s['school_id'];
	}



if($entity==2){
	$school_id=$obj->{'school_id'};
	$t=mysql_query("select id, school_id from tbl_teacher where t_id='$user_id' and school_id='$school_id'")or die(mysql_query());
	$tid=mysql_fetch_array($t);
	$user_id=$tid['id'];
	$school_id=$tid['school_id'];
}				
					$used_flag='unused';
					
					$spd=mysql_query("SELECT Sponser_product, coupon_code_ifunique, points_per_product, valid_until, total_coupons, sponsor_id FROM tbl_sponsored WHERE `id`='$cid'")or die(mysql_query());
					$c=mysql_fetch_array($spd);
					$product=$c['Sponser_product'];
					$coupon_code_ifunique=$c['coupon_code_ifunique'];
					$ppp=$c['points_per_product'];
					$valid_until=$c['valid_until'];
					$sp_id=$c['sponsor_id'];
					
					$total_coupons=$c['total_coupons'];
					if($total_coupons!='unlimited' and $total_coupons!='NULL'){
					$total_coupons -=1;
					$totalcpn=mysql_query("UPDATE `tbl_sponsored` SET `total_coupons`='$total_coupons' WHERE `id`='$cid'")or die(mysql_query());	
					}
					
					$sp=mysql_query("SELECT sp_company FROM tbl_sponsorer WHERE `id`='$sp_id'");
					if(!$sp){
						$postvalue['responseStatus']=1000;
						$postvalue['responseMessage']="Invalid Input";
						$postvalue['posts']=null;
						header('Content-type: application/json');
						echo json_encode($postvalue); 
						die();
					}
					$s=mysql_fetch_array($sp);
					$company=$s['sp_company'];
					
				if(empty($coupon_code_ifunique)){
							$code1 = $company.$product.$user_id.$entity;							
							$a=rand(0,26);				
							$cpue=substr(md5($code1),$a,5);	
								$sr=rand(10,99);
							$m1=time().$sr;
							$m=md5($m1);
							$b=rand(0,26);	
							$tsr=substr($m,$b,5);							
							$code2='SC'.$cpue.$tsr;
							$code=strtoupper($code2);
				
				}else{ 
					if($coupon_code_ifunique!=null){
					$code=$coupon_code_ifunique;
					}
				}	

 if($entity!=="" and $user_id!=="" and $cid!=="")
  	{
		if($entity==3){
			
		$q=mysql_query("UPDATE `tbl_student_reward` SET `sc_total_point`='$pts' WHERE `sc_stud_id`='$user_id'")or die(mysql_query());
		}
		if($entity==2){
			
		$q=mysql_query("UPDATE `tbl_teacher` SET `balance_blue_points`='$pts' WHERE `id`='$user_id'")or die(mysql_query());
		}
$arr = mysql_query("INSERT INTO tbl_selected_vendor_coupons VALUES(NULL,\"$entity\",\"$user_id\",\"$cid\",\"$ppp\",CURRENT_TIMESTAMP,\"$code\",\"$used_flag\",\"$sp_id\",\"$valid_until\",\"$school_id\")")or die(mysql_query());
$buy_row_id= mysql_insert_id();
if( $buy_row_id !=0 ){

	//retrive info from tbl_selected_vendor_coupons
			 $sql1="SELECT * FROM `tbl_selected_vendor_coupons` WHERE `id`='$buy_row_id'";
 			 $arr = mysql_query($sql1)or die(mysql_query());
  
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {

						$uid=$post['id'];
						$entity_id=$post['entity_id'];
						$user_id=$post['user_id'];
						$coupon_id=$post['coupon_id'];
						$for_points=$post['for_points'];
						$code=$post['code'];
						$sponsor_id=$post['sponsor_id'];
						$timestamp=$post['timestamp'];
						$used_flag=$post['used_flag'];						
						$valid_until=$post['valid_until'];
							
					
$posts[] =array("uid"=>$uid,"entity_id"=>$entity_id,"user_id"=>$user_id,"coupon_id"=>$coupon_id,"for_points"=>$for_points,"code"=>$code,"sponsor_id"=>$sponsor_id,"timestamp"=>$timestamp,"used_flag"=>$used_flag,"valid_until"=>$valid_until);	
      				
    			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;	
  			}
  			else
  				{
						$postvalue['responseStatus']=204;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=null;
  				}
  					/* output in necessary format */
  					if($format == 'json') {
						header('Content-type: application/json');
						echo  json_encode($postvalue); 
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }
//output ends here
}
   } 
 
  else
   {
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		header('Content-type: application/json');
		echo json_encode($postvalue); 
	}

	
	
		
  ?>
