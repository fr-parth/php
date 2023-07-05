<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 $coupon_id=xss_clean(mysql_real_escape_string($obj->{'coupon_id'}));
 $std_PRN=xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
 $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 
 
	if($coupon_id)
		{
			//retrive info from  tbl_accept_coupon
		 $query=mysql_query("select balance_water_points from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
		 $result_query=mysql_fetch_array($query);
		 $balance_water_points=$result_query['balance_water_points'];
		 
		 $sql= "select * FROM tbl_giftcards where  card_no='$coupon_id' and status='Unused'";
		 
 			 $arr = mysql_query($sql);
  
  			
  			if(mysql_num_rows($arr)==1) {
    			while($post = mysql_fetch_assoc($arr)) {
					
						//$sc_id=(int)$post['sc_id'];
						$amount=$post['amount'];
						 $balance_water_points=$balance_water_points+$amount;
				$date1=date('d/m/Y'); 
					$status='Used';
						$query1=mysql_query("update tbl_student set balance_water_points='$balance_water_points' where std_PRN='$std_PRN' and school_id='$school_id'");
			   mysql_query("update  tbl_giftcards  set  amount='0' ,status='$status' where card_no='$coupon_id' ");
			$test=mysql_query("insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,stud_id,school_id)values('$coupon_id','$amount','$date1','105','$std_PRN','$school_id')");
			 
			 
			  ///calling  master action log
			 
			 
			$s=mysql_query("select id,std_complete_name from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
							$rows=mysql_fetch_array($s);
							$uname=$rows['std_complete_name'];
							$student_id=$rows['id'];
			 
			 $server_name = $_SERVER['SERVER_NAME'];
							
									$data = array('Action_Description'=>'Purchased Water Points',
												'Actor_Mem_ID'=>$student_id,
												'Actor_Name'=>$uname,
												'Actor_Entity_Type'=>105,
												'Second_Receiver_Mem_Id'=>$student_id,
												'Second_Party_Receiver_Name'=>$uname,
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>'',
												'Points'=>$amount,
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
			 
			 
			 
      				 	$report="Gift card is successfully purchased";
					  $posts[]=array('report'=>$report);
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
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>