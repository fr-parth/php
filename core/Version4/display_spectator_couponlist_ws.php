<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';


   $cp_stud_id = xss_clean(mysql_real_escape_string($obj->{'cp_stud_id'}));
   $school_id =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $coupon_unused = xss_clean(mysql_real_escape_string($obj->{'coupon_unused'}));
   $MemberID=xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
	//MemberID added as i/p parameter by Pranali for SMC-3744 on 24-1-19
   
	if($cp_stud_id!='' && $school_id!='' && $coupon_unused=='')
	{
		//retrive info from tbl_coupons for unused coupons
		$sql="select cp_code,amount,status,cp_gen_date,validity from tbl_coupons where cp_stud_id = '$cp_stud_id'  AND school_id='$school_id' and (status='yes' or status='p') order by id desc";
		
	}
	//below condition added by Pranali for displaying Used /partial coupons log for SMC-3744
	else if($cp_stud_id!='' && $school_id!='' && $coupon_unused=='no')
	{
		//query modified by Pranali for SMC-3744
		$sql="SELECT ac.product_name,ac.issue_date,ac.points as amount,ac.stud_id,ac.coupon_id,sp.sp_company,c.cp_code,c.status,c.cp_gen_date,c.validity 
		from tbl_coupons c
		join tbl_accept_coupon ac  
		on c.cp_code=ac.coupon_id and c.cp_stud_id=ac.stud_id and c.school_id=ac.school_id
		join tbl_sponsorer sp on sp.id=ac.sponsored_id
		where ac.stud_id='$cp_stud_id' and ac.school_id='$school_id' and (c.status='no' or c.status='p') order by ac.id desc"; 
		
	}
	
	else
	{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
	}
			
 			 $arr = mysql_query($sql);
 
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1)
				{
    			while($post = mysql_fetch_assoc($arr))
					{
      				$posts[] = array_map(clean_string,$post); 
					
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
   					 echo json_encode($postvalue);
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
		
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
