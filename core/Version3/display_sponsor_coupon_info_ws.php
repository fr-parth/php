<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 $sponsor_id=xss_clean(mysql_real_escape_string($obj->{'sponsor_id'}));
 $sponsor_coupon_code=xss_clean(mysql_real_escape_string($obj->{'sponsor_coupon_code'}));
  

 $posts=array();
 
 
	if($sponsor_id != "" && $sponsor_coupon_code !="" ) 
		{
			
			 $sql= mysql_query("select (case entity_id when '3' then concat(s.std_name,' ',s.std_Father_name,' ',s.std_lastname)
			when '2' then concat(t.t_name,' ',t.t_middlename,' ',t.t_lastname) end) as name,
			
			(case entity_id when '3' then (s.std_complete_name)
			when '2' then t.t_complete_name end ) as completename,
			
		( case entity_id when '3' then s.std_school_name
		when '2' then t.t_current_school_name end ) as school,
		
		( case entity_id when '3' then s.std_img_path
		when '2' then t.t_pc end ) as photo,

		( case entity_id when '3' then 'Student'
			when '2' then 'Teacher' end ) as user_type,
			
		c.`id`,c.`coupon_id`,`code`, sp.Sponser_product,sp.discount,`for_points`,`timestamp`, c.school_id, `used_flag`, sp.valid_until
		
		from tbl_selected_vendor_coupons c
		left join tbl_student s on  s.id=c.user_id 
		left join tbl_teacher t on t.id=c.user_id
		left join tbl_sponsored sp on c.coupon_id=sp.id
		where c.sponsor_id='$sponsor_id' and c.code='$sponsor_coupon_code'
		order by c.used_flag asc, c.timestamp desc");
			 
			 
 			 $arr = mysql_fetch_array($sql);
			 $count=mysql_num_rows($sql);
			 
			 if($count==1)
			 {
				/* $user_id = $arr['user_id'];
				 
				 $stude_info_query = mysql_query("select std_complete_name,std_name,std_lastname,std_Father_name from tbl_student where std_PRN='$user_id'");
				 $info = mysql_fetch_array($stude_info_query);
				 if($info['std_complete_name']!='')
				 {
					 $name = $info['std_complete_name'];
				 }
				 else
				 {
					 $name = $info['std_name'].$info['std_lastname'].$info['std_Father_name'];
				 }*/
				 
				 
				 if($arr['name']=='')
				 {
					 $name=$arr['completename'];
				 }
				 else{
					 $name=$arr['name'];
				 }
				 
			 $posts = array('organization_name'=>$arr['school'],
			 'valid_until'=>$arr['valid_until'],
			 'name'=>$name,
			 'coupon_code'=>$arr['coupon_id'],
			 'selectedon'=>$arr['timestamp'],
			 'product_name'=>$arr['Sponser_product'],
			 'used_flag'=>$arr['used_flag'],
			 'discount'=>$arr['discount']);
			
				
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
			 if($format == 'json')
					
					 {
    					 echo json_encode($postvalue);
  					}
					
 				
		}
	else
			{
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
