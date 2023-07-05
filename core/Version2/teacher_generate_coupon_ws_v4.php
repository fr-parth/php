<?php  
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

$teacher_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$cp_point = xss_clean(mysql_real_escape_string($obj->{'coupon_point'}));
$point_option = xss_clean(mysql_real_escape_string(strtolower($obj->{'point_option'})));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	


$sql=mysql_query("select id from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");
$sql2=mysql_fetch_array($sql);
$id=$sql2['id'];


//if student id is not empty
if( $teacher_id!= "" && $cp_point!=""  && $point_option!='' && $school_id!='')
{
        //retrive total point of student
		
		if($point_option=='bluepoints')
		{
 	 $arr = mysql_query("select balance_blue_points from tbl_teacher where id='$id'");
  		$row = mysql_fetch_array($arr);
			
 			 $sc_total_point= $row['balance_blue_points'];
		     		//check that total point is enough for genrating coupon
  					if($sc_total_point >=$cp_point)
 				 		{						
							$arra = mysql_query("SELECT id FROM tbl_teacher_coupon ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							// Start SMC-3451 Modify By sachin 2018-09-19 14:16:38 PM 
							  //$cp_gen_date=date('d/m/Y');
							  
							  $cp_gen_date = CURRENT_TIMESTAMP;

							  // define in core/securityfunctions.php
							  //Start SMC-3451

							
						$d=strtotime("+6 Months -1 day");

						$validity=date("Y/m/d",$d);
							
						
							

			mysql_query("insert into tbl_teacher_coupon (coupon_id,user_id,amount,issue_date,validity_date,status,used_points,original_point) values('$cp_id','$id','$cp_point','$cp_gen_date','$validity','unused','$point_option','$cp_point')");
					  		//reduce student point after generate coupon
								$sc_total_point = $sc_total_point - $cp_point;
								
						 		
						 		mysql_query("update tbl_teacher set balance_blue_points='$sc_total_point' where id='$id'");
								
								
							
								$c_id = mysql_query("select coupon_id, amount as coupon_point, issue_date, validity_date,balance_blue_points as balance_point,used_points from tbl_teacher_coupon c join tbl_teacher s where c.user_id = s.id  order by c.id desc");
								
								$test[] = mysql_fetch_assoc($c_id);
								//$test = $c_id_row['cp_code'];
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="ok";
								$postvalue['posts']=$test;	
						}
						else
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="insufficient blue points";
							$postvalue['posts']=null;
						}
		}
			elseif($point_option=='waterpoints')
			{
			
					$arr = mysql_query("select water_point from tbl_teacher where id='$id'");
  		$row = mysql_fetch_array($arr);
			
 			 $water_point= $row['water_point'];
		     		//check that total point is enough for genrating coupon
  					if($water_point >=$cp_point)
 				 		{
						
							$arra = mysql_query("SELECT id FROM tbl_teacher_coupon ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							

							// Start SMC-3451 Modify By sachin 2018-09-19 14:16:38 PM 
							  //$cp_gen_date=date('d/m/Y');
							  
							  $cp_gen_date= CURRENT_TIMESTAMP;

							  // define in core/securityfunctions.php
							  //Start SMC-3451

							
						$d=strtotime("+6 Months -1 day");
						$validity=date("Y/m/d",$d);
							
						
							

			mysql_query("insert into tbl_teacher_coupon (coupon_id,user_id,amount,issue_date,validity_date,status,used_points,original_point) values('$cp_id','$id',
							'$cp_point','$cp_gen_date','$validity','unused','$point_option','$cp_point')");
					  		//reduce student point after generate coupon
								$water_point = $water_point - $cp_point;
								
						 		
						 		mysql_query("update tbl_teacher set water_point='$water_point' where id='$id'");
								
								
							
								$c_id = mysql_query("select coupon_id, amount as coupon_point, issue_date, validity_date,water_point as balance_point,used_points from tbl_teacher_coupon c join tbl_teacher s where c.user_id = s.id order by c.id desc");
								
								$test[] = mysql_fetch_assoc($c_id);
								//$test = $c_id_row['cp_code'];
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="ok";
								$postvalue['posts']=$test;	
						}
						else
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="insufficient water points";
							$postvalue['posts']=null;
						}
			
			
			}
			elseif($point_option=='brownpoints')
			{
			
					$arr = mysql_query("select brown_point from tbl_teacher where id='$id'");
  		$row = mysql_fetch_array($arr);
			
 			 $brown_point= $row['brown_point'];
		     		//check that total point is enough for genrating coupon
  					if($brown_point >=$cp_point)
 				 		{
						
							$arra = mysql_query("SELECT id FROM tbl_teacher_coupon ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							// Start SMC-3451 Modify By sachin 2018-09-19 14:16:38 PM 
							  //$cp_gen_date=date('d/m/Y');
							  
							  $cp_gen_date=CURRENT_TIMESTAMP;

							  // define in core/securityfunctions.php
							  //Start SMC-3451

							
						$d=strtotime("+6 Months -1 day");
						$validity=date("Y/m/d",$d);
							
						
							

			mysql_query("insert into tbl_teacher_coupon (coupon_id,user_id,amount,issue_date,validity_date,status,used_points,original_point) values('$cp_id','$id',
							'$cp_point','$cp_gen_date','$validity','unused','$point_option','$cp_point')");
					  		//reduce student point after generate coupon
								$brown_point = $brown_point - $cp_point;
								
						 		
						 		mysql_query("update tbl_teacher set brown_point='$brown_point' where id='$id'");
								
								
							
								$c_id = mysql_query("select coupon_id, amount as coupon_point, issue_date, validity_date,brown_point as balance_point,used_points from tbl_teacher_coupon c join tbl_teacher s where c.user_id = s.id order by c.id desc");
								
								$test[] = mysql_fetch_assoc($c_id);
								//$test = $c_id_row['cp_code'];
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="ok";
								$postvalue['posts']=$test;	
						}
						else
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="insufficient Brown points";
							$postvalue['posts']=null;
						}
			
			
			}

					else
						{
							$postvalue['responseStatus']=409;
							$postvalue['responseMessage']="invalid point type";
							$postvalue['posts']=null;
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
