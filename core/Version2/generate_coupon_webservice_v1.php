<?php 
include 'conn.php'; 
//header('Content-type: application/json'); //This is comment bz error for call CURRENT_TIMESTAMP from securityfunction.php 
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;
$format = 'json';
//Save
$cp_stud_id=$obj->{'cp_std_id'}; // student_PRN
$cp_point=$obj->{'coupon_point'};
$mem_id=$obj->{'stud_mem_id'};    // student_Member_id
 $select_opt=$obj->{'Points_type'};
 $school_id=$obj->{'school_id'};




//if student id is not empty
if($cp_stud_id!= "" && $mem_id!= "" && $select_opt!="" && $cp_point!="" && $school_id !="")
{

						$arra = mysql_query("SELECT max(id) as id FROM tbl_coupons");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++)
							{
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    						}
        					$cp_id= $cp_id."".$res ;
							
							// Start SMC-3450 Modify By Pravin 2018-09-19 01:39 PM 
							//$cp_gen_date=date('d/m/Y');
							$cp_gen_date=CURRENT_TIMESTAMP;
						$d=strtotime("+6 Months -1 day");
						//$validity=date("d/m/Y",$d);
						$validity=date("Y-m-d",$d);
						//End SMC-3450
						$mem = mysql_query("select std_complete_name,std_name,std_lastname,std_Father_name  from  tbl_student where id ='$mem_id' or (school_id ='$school_id' and std_PRN ='$cp_stud_id')");
							$count=mysql_num_rows($mem);
						if($count > 0)
						{
							$stud_info= mysql_fetch_array($mem);
							
							$name1=$stud_info['std_complete_name'];
							$std_name=$stud_info['std_name'];
							$std_Father_name=$stud_info['std_Father_name'];
							$std_lastname=$stud_info['std_lastname'];
							
							if($std_complete_name =="")
							{
								$name1 = $std_name." ".$std_Father_name." ".$std_lastname;
							}
							else
							{
								$name1;
							}
							
							
						$where="sc_stud_id ='$cp_stud_id'";
							if($select_opt=='Green Points')
							{
								$point_type = "Green Points";
								$table="tbl_student_reward";
								$select="sc_total_point";
								
							}	
							elseif($select_opt=='Purple Points')
							{
								$point_type = "Purple Points";
								$table = "tbl_student_reward";
								$select = "purple_points";
								
							}
							elseif($select_opt=='Yellow Points')
							{
								$point_type = "Yellow Points";
								$table = "tbl_student_reward";
								$select = "yellow_points";
								
							}

							elseif($select_opt=='Water Points')
							{
								$point_type = "Water Points";
								$table = "tbl_student";
								$select = "balance_water_points";
								$where = "std_PRN ='$cp_stud_id'";
							}
							else
							{
														$postvalue['responseStatus']=209;
														$postvalue['responseMessage']="Invalid Point Type";
														$postvalue['posts']=null;
														header('Content-type: application/json');
														echo json_encode($postvalue);
														exit;
							}
							if($select_opt=='Water Points')
							{
								$point_column = "std.".$select;
							}
							else{
								$point_column = "s.".$select;
							}
								//retrive total point of student
							 $arr = mysql_query("select $select from $table where school_id ='$school_id' and $where");
								$row = mysql_fetch_array($arr);
			
								$balance_points = $row['0'];
 				
				
								//check that total point is enough for genrating coupon
								if($balance_points >=$cp_point && $balance_points !='0')
								{
								/*Author VaibhavG 
									added original point columns value into the table coupons for the ticket number SMC-3327 28Aug10 06:56PM
								*/
								mysql_query("insert into 	tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity,original_point) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity','$cp_point')");
							
									//reduce student point after generate coupon
									$balance_point_after_generate_coupon = $balance_points - $cp_point;
								
						 		
									mysql_query("update $table set $select ='$balance_point_after_generate_coupon' where $where");
								
									$c_id = mysql_query("select c.cp_code, c.amount , $point_column as rempoints, c.cp_gen_date, c.validity from tbl_coupons c 
									JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id 
									JOIN tbl_student std on  std.id=c.Stud_Member_Id  WHERE c.Stud_Member_Id ='$mem_id' order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
								
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['rempoints'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
								
						
							}
						
							else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="$point_type are insufficient";
								$postvalue['posts']=null;
							}
						}
						else{
								$postvalue['responseStatus']=205;
								$postvalue['responseMessage']="Student Not Found";
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
    					    echo json_encode($postvalue);
							
	@mysql_close($con);
	
		
  ?>
