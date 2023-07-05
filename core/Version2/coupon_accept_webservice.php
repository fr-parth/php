	<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//connection to db
include 'conn.php';


   //input from user
   $user=$obj->{'user'};
    $coupon_id=$obj->{'coupon_id'};
	$stud_id = $obj->{'student_id'};
	$school_name = $obj->{'school_name'};
	$school_id = $obj->{'school_id'};
	$coupon_point=$obj->{'coupon_point'};
	$product=$obj->{'product_name'};
	$discount=$obj->{'discount'};
	$note=$obj->{'Miscellaneous'};
    $points=$obj->{'points_per_product'};
	$sponsor_id=$obj->{'sponsor_id'};
	
		/* Author VaibhavG
		* here we check school_id instead of school_name into below if condition as per the discussed with Android Developer Pooja Paramshetti for dependent ticket number SAND-1412.
		*/
    if($sponsor_id!="" && $coupon_id!="" && $stud_id!="" && $school_id!="" && $coupon_point!="" && $user!="")
	{
			if($user=='3'){
    $sql1 = "select s.std_PRN from  `tbl_coupons` c join `tbl_student` s on c.cp_stud_id = s.std_PRN join `tbl_studentpointslist` a  join `tbl_student_reward` p on p.sc_stud_id = s.std_PRN where cp_code = '$coupon_id' ";

		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		 $num1 = mysql_num_rows( $rs1 );
		
		if($num1 < 1 ){
				$test="Coupon not found!";
			  	$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=$test;
		}else{
			  $quantity = 1;
			  // Start SMC-3450 Modify By Pravin 2018-09-19 03:36 PM 
					//$issue_date = date('m/d/Y');
					 $issue_date = CURRENT_TIMESTAMP;
					//End SMC-3450
					$values = mysql_fetch_array($rs1);
					
					$arr=mysql_query("select amount ,status ,cp_code from tbl_coupons where cp_code=$coupon_id");
					$row=mysql_fetch_array($arr); 
					 $status=$row['status'];	
					$amount=$row['amount'];	
					//check total points of student is enough for accept coupon
					if($coupon_point>=$points &&  $status!="Expired")
					{
					     if($product!="")
					  	{
						
						
					 		mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$product','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','student','$school_id')");
					   	}
					  	 else if($discount!="")
					  	 {
					  	 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$discount','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','student','$school_id')");
				
					   	}
						 else
							{
						
									 $count=substr_count($note,"%");
									
									if($count==1)
									{
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$note','$points','$sponsor_id')");
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','student','$school_id')");	  
									}
									else
									{	
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$note','$points','$sponsor_id')");
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','student','$school_id')");	 
									}
									
						
						}
						
						//reduce coupon amount
						 $coupon_point=$coupon_point-$points;
						 /*Author VaibhavG 
							added remaining point variable to calculate coupon remaining point for the ticket number SMC-3327 28Aug10 09:17PM
						*/
						 $remaining_amount=$amount-$points;
						
					
					  if($coupon_point==0)
							{
						 $sqls1="update tbl_coupons set amount='$remaining_amount',status='no' where Stud_Member_Id='$stud_id' and cp_code='$coupon_id'  ";
						 mysql_query($sqls1);
						 	}
							else
							{
						
							 $sqls2="update tbl_coupons set amount='$remaining_amount' ,status='p' where Stud_Member_Id='$stud_id' and cp_code='$coupon_id' ";
							 mysql_query($sqls2);
						
							}
						//	 $test="successfully accepted coupon";
						$postvalue['responseStatus']=200;
						$postvalue['responseMessage']="OK";
						$postvalue['posts']=null;
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
			
	
		
 			$sql1 = "select s.id from  `tbl_teacher_coupon` c join `tbl_teacher` s on c.user_id = s.id  where coupon_id = '$coupon_id' ";
		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		
		 $num1 = mysql_num_rows( $rs1 );
		
		if($num1 < 1 ){
		  	$test="Coupon not found!";
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=$test;
		}else{
			  $quantity = 1;
			  // Start SMC-3450 Modify By Pravin 2018-09-19 03:36 PM 
					//$issue_date = date('m/d/Y');
					$issue_date = CURRENT_TIMESTAMP;
					//End SMC-3450
				
					$values = mysql_fetch_array($rs1);
				$arr=mysql_query("select amount ,status ,coupon_id from tbl_teacher_coupon where coupon_id=$coupon_id");
					$row=mysql_fetch_array($arr); 
					 $status=$row['status'];		
					//check total points of student is enough for accept coupon
					if($coupon_point>=$points &&  $status!="Expired")
					{
					     if($product!="")
					  	{
					
						
						
					 		mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$product','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','teacher','$school_id')");
					   	}
					  	 else if($discount!="")
					  	 {
					  	 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$discount','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','teacher','$school_id')");
				
					   	}
						 else
							{
						
									 $count=substr_count($note,"%");
									
									if($count==1)
									{
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$note','$points','$sponsor_id')");
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','teacher','$school_id')");	  
									}
									else
									{	
										mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$note','$points','$sponsor_id')");
										 mysql_query("insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type,school_id) values('$note','$points','$coupon_id','$quantity','$stud_id','$sponsor_id','$issue_date','teacher','$school_id')");	 
									}
									
						
						}
						
						//reduce coupon amount
						 $coupon_point=$coupon_point-$points;
						
						// $test="successfully accepted coupon";
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=null;
					  if($coupon_point==0)
							{
						
						 $sqls1="update tbl_teacher_coupon set amount='$coupon_point',status='no' where user_id='$stud_id' and coupon_id='$coupon_id'  ";
						 mysql_query($sqls1);
						 	}
							else
							{
						
							 $sqls2="update tbl_teacher_coupon set amount='$coupon_point' ,status='p' where user_id='$stud_id' and coupon_id='$coupon_id' ";
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
	    	header('Content-type: application/json');
   			echo  json_encode($postvalue); 	
	
		?>
	