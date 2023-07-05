<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//connection to db
include 'conn.php';
//input from user
   $user=xss_clean(mysql_real_escape_string($obj->{'user'}));
    $coupon_id=xss_clean(mysql_real_escape_string($obj->{'coupon_id'}));
	$stud_id = xss_clean(mysql_real_escape_string($obj->{'student_id'}));
	$school_name = xss_clean(mysql_real_escape_string($obj->{'school_name'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$coupon_point=xss_clean(mysql_real_escape_string($obj->{'coupon_point'}));
	$product=xss_clean(mysql_real_escape_string($obj->{'product_name'}));
	$discount=xss_clean(mysql_real_escape_string($obj->{'discount'}));
	$note=xss_clean(mysql_real_escape_string($obj->{'Miscellaneous'}));
    $points=xss_clean(mysql_real_escape_string($obj->{'points_per_product'}));
	$sponsor_id=xss_clean(mysql_real_escape_string($obj->{'sponsor_id'}));
	
    if($sponsor_id!="" && $coupon_id!="" && $stud_id!="" && $school_name!="" && $coupon_point!="" && $user!="")
	{
			if($user=='3'){
    $sql1 = "select s.id , s.std_PRN, c.amount ,c.status ,c.cp_code 
	from  `tbl_coupons` c 
	join `tbl_student` s on c.cp_stud_id = s.std_PRN 
	join `tbl_student_reward` p on p.sc_stud_id = s.std_PRN 
	where c.cp_code = '$coupon_id' ";

		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		 $num1 = mysql_num_rows( $rs1 );
		
		if($num1 < 1 ){
				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
		}else{
			  $quantity = 1;
			  //SMC-3452 Date Format Modified By Pranali 2018-09-25 01:32 PM
					//$issue_date = date('m/d/Y');
					$issue_date = CURRENT_TIMESTAMP;
					$values = mysql_fetch_array($rs1);
					 
					 $mem_id=$values['id'];		
					 $status=$values['status'];		
					//check total points of student is enough for accept coupon
					if($coupon_point>=$points &&  $status!="Expired")
					{
					     if($product!="")
					  	{
						
						
					 		mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$product','$points','$coupon_id','$quantity','$mem_id','$sponsor_id','$issue_date','student','$school_id')");
					   	}
					  	 else if($discount!="")
					  	 {
					  	 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$discount','$points','$coupon_id','$quantity','$mem_id','$sponsor_id','$issue_date','student','$school_id')");
				
					   	}
						 else
							{
						
									 $count=substr_count($note,"%");
									
									if($count==1)
									{
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$note','$points','$sponsor_id')");
										
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$mem_id',,'$sponsor_id','$issue_date','student','$school_id')");	  
									}
									else
									{	
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$note','$points','$sponsor_id')");
										
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$mem_id','$sponsor_id','$issue_date','student','$school_id')");	 
									}
									
						
						}
						
						//reduce coupon amount
						 $coupon_point=$coupon_point-$points;
		
				$msg="Accepted";
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$msg;
				
				
					  if($coupon_point==0)
							{
						 $sqls1="update tbl_coupons set amount='$coupon_point',status='no' where Stud_Member_Id='$mem_id' and cp_code='$coupon_id' ";
						 mysql_query($sqls1);
						 	}
							else
							{
						
							 $sqls2="update tbl_coupons set amount='$coupon_point' ,status='p' where Stud_Member_Id='$mem_id' and cp_code='$coupon_id' ";
							 mysql_query($sqls2);
						
							}
                     }
					 else
					 {
				$test="Enough total point not available for coupons or coupon is expired";				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=$test;	
					 }
					
	        }
			}elseif($user=='2'){ 
			
	
		
 			$sql1 = "select s.id, c.amount ,c.status ,c.coupon_id from  `tbl_teacher_coupon` c join `tbl_teacher` s on c.user_id = s.id  where coupon_id = '$coupon_id' ";
		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		
		 $num1 = mysql_num_rows( $rs1 );
		
		if($num1 < 1 ){
				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
		}else{
			  $quantity = 1;
					//$issue_date = date('m/d/Y');
					$issue_date = CURRENT_TIMESTAMP;
					//End SMC-3452
					$values = mysql_fetch_array($rs1);
				 
					 $tech_mem_id=$values['id'];		
					 $status=$values['status'];		
					//check total points of student is enough for accept coupon
					if($coupon_point>=$points &&  $status!="Expired")
					{
					if($product!="")
						{
					
						
						
					 		mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$product','$points','$coupon_id','$quantity','$tech_mem_id','$sponsor_id','$issue_date','teacher','$school_id')");
					}
						 else if($discount!="")
					{
						 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$discount','$points','$coupon_id','$quantity','$tech_mem_id','$sponsor_id','$issue_date','teacher','$school_id')");
				
					}
						 else
							{
						
									 $count=substr_count($note,"%");
									
									if($count==1)
									{
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$note','$points','$sponsor_id')");
										
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$$tech_mem_id','$sponsor_id','$issue_date','teacher','$school_id')");	  
									}
									else
									{	
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$note','$points','$sponsor_id')");
										
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$tech_mem_id','$sponsor_id','$issue_date','teacher','$school_id')");	 
									}
									
						
						}
						
						//reduce coupon amount
						 $coupon_point=$coupon_point-$points;
						
				$msg='Accepted';
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$msg;
					  if($coupon_point==0)
							{
						
						 $sqls1="update tbl_teacher_coupon set amount='$coupon_point',status='no' where user_id='$tech_mem_id' and coupon_id='$coupon_id'";
						 mysql_query($sqls1);
						 	}
							else
							{
						
							 $sqls2="update tbl_teacher_coupon set amount='$coupon_point' ,status='p' where user_id='$tech_mem_id' and coupon_id='$coupon_id'";
							 mysql_query($sqls2);
						
							}
                     }
					 else
					 {
				$test="Enough total point not available for coupons or coupon is expired";
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=$test;
	
					 }
					
	        }
			 
			//$test='Sorry! Error Occurred';
			}
}
   else
		{
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
		}
			  header('Content-type:application/json');
			  echo json_encode($postvalue);?>