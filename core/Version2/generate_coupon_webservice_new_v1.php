<?php  
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

include 'conn.php';


//if student id is not empty
if( $cp_stud_id!= "" && $mem_id!= "" && $select_opt!="" && $cp_point!="")
{
	if($select_opt=='Green Points')
	{
        //retrive total point of student
 	 $arr = mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id =$cp_stud_id");
  		$row = mysql_fetch_array($arr);
			
 				$sc_total_point= $row['sc_total_point'];
		     		//check that total point is enough for genrating coupon
  					if($sc_total_point >=$cp_point)
 				 		{
							$arra = mysql_query("SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
				
						$posts = array();
							$mem = mysql_query("select std_complete_name,school_id  from  tbl_student where id =$mem_id");
							$stud_info= mysql_fetch_array($mem);
	 
							$name1=$stud_info['std_complete_name'];
							$school_id=$stud_info['school_id'];

							
							
							
							mysql_query("insert into tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity')");
					  		//reduce student point after generate coupon
								$sc_total_point = $sc_total_point - $cp_point;
								
						 		//$test="successfully generated coupon";
						 		mysql_query("update tbl_student_reward set sc_total_point='$sc_total_point' where sc_stud_id='$cp_stud_id'");
								
								//$c_id = mysql_query("select cp_code, amount , sc_total_point , cp_gen_date, validity from tbl_coupons c join tbl_student_reward s where cp_stud_id = sc_stud_id order by c.id desc");
								$c_id = mysql_query("select c.cp_code, c.amount , s.sc_total_point , c.cp_gen_date, c.validity from tbl_coupons c JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id WHERE c.Stud_Member_Id =$mem_id  order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['sc_total_point'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								$server_name = $_SERVER['SERVER_NAME'];
			 
							
									$data = array('Action_Description'=>'Generate Smartcookie Coupon',
												'Actor_Mem_ID'=>$mem_id,
												'Actor_Name'=>$name1,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$cp_id,
												'Points'=>$cp_point,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
			 //end	
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
								
								//$test = $c_id_row['cp_code'];
						}
						else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Green Points insufficient";
								$postvalue['posts']=null;
						    }
	}
	
	
	
	
	elseif($select_opt=='Purple Points')
	{
        //retrive total point of student
 	 $arr = mysql_query("select purple_points  from  tbl_student_reward where sc_stud_id =$cp_stud_id");
  		$row = mysql_fetch_array($arr);
			
 				$purple_points= $row['purple_points'];
		     		//check that total point is enough for genrating coupon
  					if($purple_points >=$cp_point)
 				 		{
							$arra = mysql_query("SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
				
						$posts = array();
							$mem = mysql_query("select std_complete_name,school_id  from  tbl_student where id =$mem_id");
							$stud_info= mysql_fetch_array($mem);
	 
							$name1=$stud_info['std_complete_name'];
							$school_id=$stud_info['school_id'];

							
							
							
							mysql_query("insert into tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity')");
					  		//reduce student point after generate coupon
								$purple_points = $purple_points - $cp_point;
								
						 		//$test="successfully generated coupon";
						 		mysql_query("update tbl_student_reward set purple_points='$purple_points' where sc_stud_id='$cp_stud_id'");
								
								//$c_id = mysql_query("select cp_code, amount , sc_total_point , cp_gen_date, validity from tbl_coupons c join tbl_student_reward s where cp_stud_id = sc_stud_id order by c.id desc");
								$c_id = mysql_query("select c.cp_code, c.amount , s.sc_total_point , c.cp_gen_date, c.validity from tbl_coupons c JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id WHERE c.Stud_Member_Id =$mem_id  order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['sc_total_point'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								$server_name = $_SERVER['SERVER_NAME'];
			 
							
									$data = array('Action_Description'=>'Generate Smartcookie Coupon',
												'Actor_Mem_ID'=>$mem_id,
												'Actor_Name'=>$name1,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$cp_id,
												'Points'=>$cp_point,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
			 //end	
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
								
								//$test = $c_id_row['cp_code'];
						}
						else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Purple Points insufficient";
								$postvalue['posts']=null;
						    }
	}
		
		
		elseif($select_opt=='Yellow Points')
	{
        //retrive total point of student
 	 $arr = mysql_query("select yellow_points  from  tbl_student_reward where sc_stud_id =$cp_stud_id");
  		$row = mysql_fetch_array($arr);
			
 				$yellow_points= $row['yellow_points'];
		     		//check that total point is enough for genrating coupon
  					if($yellow_points >=$cp_point)
 				 		{
							$arra = mysql_query("SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
				
						$posts = array();
							$mem = mysql_query("select std_complete_name,school_id  from  tbl_student where id =$mem_id");
							$stud_info= mysql_fetch_array($mem);
	 
							$name1=$stud_info['std_complete_name'];
							$school_id=$stud_info['school_id'];

							
							
							
							mysql_query("insert into tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity')");
					  		//reduce student point after generate coupon
								$yellow_points = $yellow_points - $cp_point;
								
						 		//$test="successfully generated coupon";
						 		mysql_query("update tbl_student_reward set yellow_points='$yellow_points' where sc_stud_id='$cp_stud_id'");
								
								//$c_id = mysql_query("select cp_code, amount , sc_total_point , cp_gen_date, validity from tbl_coupons c join tbl_student_reward s where cp_stud_id = sc_stud_id order by c.id desc");
								$c_id = mysql_query("select c.cp_code, c.amount , s.sc_total_point , c.cp_gen_date, c.validity from tbl_coupons c JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id WHERE c.Stud_Member_Id =$mem_id  order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['sc_total_point'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								$server_name = $_SERVER['SERVER_NAME'];
			 
							
									$data = array('Action_Description'=>'Generate Smartcookie Coupon',
												'Actor_Mem_ID'=>$mem_id,
												'Actor_Name'=>$name1,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$cp_id,
												'Points'=>$cp_point,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
								
								//$test = $c_id_row['cp_code'];
						}
						else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Yellow Points insufficient";
								$postvalue['posts']=null;
						    }
	}
		
		elseif($select_opt=='Water Points')
	{
        //retrive total point of student
 	 $arr = mysql_query("select balance_water_points  from  tbl_student where std_PRN =$cp_stud_id");
  		$row = mysql_fetch_array($arr);
			
 				$balance_water_points= $row['balance_water_points'];
		     		//check that total point is enough for genrating coupon
  					if($balance_water_points >=$cp_point)
 				 		{
							$arra = mysql_query("SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
				
						$posts = array();
							$mem = mysql_query("select std_complete_name,school_id  from  tbl_student where id =$mem_id");
							$stud_info= mysql_fetch_array($mem);
	 
							$name1=$stud_info['std_complete_name'];
							$school_id=$stud_info['school_id'];

							
							
							
							mysql_query("insert into tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity')");
					  		//reduce student point after generate coupon
								$balance_water_points = $balance_water_points - $cp_point;
								
						 		//$test="successfully generated coupon";
						 		mysql_query("update tbl_student set balance_water_points='$balance_water_points' where std_PRN='$cp_stud_id'");
								
								//$c_id = mysql_query("select cp_code, amount , sc_total_point , cp_gen_date, validity from tbl_coupons c join tbl_student_reward s where cp_stud_id = sc_stud_id order by c.id desc");
								$c_id = mysql_query("select c.cp_code, c.amount , s.sc_total_point , c.cp_gen_date, c.validity from tbl_coupons c JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id WHERE c.Stud_Member_Id =$mem_id  order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['sc_total_point'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								$server_name = $_SERVER['SERVER_NAME'];
			 
							
									$data = array('Action_Description'=>'Generate Smartcookie Coupon',
												'Actor_Mem_ID'=>$mem_id,
												'Actor_Name'=>$name1,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$cp_id,
												'Points'=>$cp_point,
												'Product'=>'',
												'Value'=>'',
												'Currency'=>''
							);
							
							$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
							$data_string = json_encode($data);    
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
							$result = json_decode(curl_exec($ch),true);
			 
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
								
								//$test = $c_id_row['cp_code'];
						}
						
						else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Water Points insufficient";
								$postvalue['posts']=null;
						    }
	
	}
		if($select_opt=='Brown Points')
	{
        //retrive total point of student
 	 $arr = mysql_query("select brown_point  from  tbl_student_reward where sc_stud_id =$cp_stud_id");
  		$row = mysql_fetch_array($arr);
			
 				$brown_point= $row['brown_point'];
		     		//check that total point is enough for genrating coupon
  					if($brown_point >=$cp_point)
 				 		{
							$arra = mysql_query("SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    							}

        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
				
						$posts = array();
							$mem = mysql_query("select std_complete_name,school_id  from  tbl_student where id =$mem_id");
							$stud_info= mysql_fetch_array($mem);
	 
							$name1=$stud_info['std_complete_name'];
							$school_id=$stud_info['school_id'];

							
							
							
							mysql_query("insert into tbl_coupons(Stud_Member_Id,stud_complete_name,cp_stud_id,school_id,cp_code,amount,cp_gen_date,validity) values('$mem_id',' $name1','$cp_stud_id','$school_id','$cp_id','$cp_point', '$cp_gen_date', '$validity')");
					  		//reduce student point after generate coupon
								$brown_point = $brown_point - $cp_point;
								
						 		//$test="successfully generated coupon";
						 		mysql_query("update tbl_student_reward set brown_point='$brown_point' where sc_stud_id='$cp_stud_id'");
								
								//$c_id = mysql_query("select cp_code, amount , sc_total_point , cp_gen_date, validity from tbl_coupons c join tbl_student_reward s where cp_stud_id = sc_stud_id order by c.id desc");
								$c_id = mysql_query("select c.cp_code, c.amount , s.sc_total_point , c.cp_gen_date, c.validity from tbl_coupons c JOIN tbl_student_reward s on c.cp_stud_id = s.sc_stud_id WHERE c.Stud_Member_Id =$mem_id  order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['sc_total_point'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
								
								//$test = $c_id_row['cp_code'];
						}
						else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Brown Points insufficient";
								$postvalue['posts']=null;
						    }
	}
		
		
					else
						{
							$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response ";
				$postvalue['posts']=null;
						}
						
						if($format == 'json') 
						
						{
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
						
				
}
else
{
	$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
}

 
	
	
		
  ?>
