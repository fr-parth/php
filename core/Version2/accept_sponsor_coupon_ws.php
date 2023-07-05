<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 
 $sponsor_id=$obj->{'sponsor_id'};
 $sponsor_coupon_code=$obj->{'sponsor_coupon_code'};
  

 $posts=array();
 
 
	if($sponsor_id != "" && $sponsor_coupon_code !="" )
		{
			
			 $sql= mysql_query("update tbl_selected_vendor_coupons set used_flag='used'
		, timestamp=CURRENT_TIMESTAMP where sponsor_id ='$sponsor_id' AND code='$sponsor_coupon_code'");
			 
			 $count = mysql_affected_rows();
 			
			 
			 if($count)
			 {
				 //call master_action_log_ws
			$sq=mysql_query("select sp_company from tbl_sponsorer where id='$sponsor_id'");
									$rows1=mysql_fetch_assoc($sq);
									$sp_company=$rows1['sp_company'];
									
									//$entity_id=$rows1['entity_id'];
			 
			 $server_name = $_SERVER['SERVER_NAME'];
			 
							
									$data = array('Action_Description'=>'Accept Coupon',
												'Actor_Mem_ID'=>$sponsor_id,
												'Actor_Name'=>$sp_company,
												'Actor_Entity_Type'=>108,
												'Second_Receiver_Mem_Id'=>'',
												'Second_Party_Receiver_Name'=>'',
												'Second_Party_Entity_Type'=>'',
												'Third_Party_Name'=>'',
												'Third_Party_Entity_Type'=>'',
												'Coupon_ID'=>$sponsor_coupon_code,
												'Points'=>'',
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
							$postvalue['posts']="Coupon Accepted Successfully";
					
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
