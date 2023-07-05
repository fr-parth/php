<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include 'conn.php';



		/* Author VaibhavG
		*	As per the discussed with Rakesh Sir, we changed student member id instead of student PRN. So, I've removed std_PRN as std_id & checked only member id for the ticket number SAND-1628 4Sept18 04:34PM
		*/



  $std_PRN=xss_clean(mysql_real_escape_string($obj->{'std_id'}));
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 //Start SMC-3450 Pagination
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"	 

 
	if( $std_id !="" )
		{
			//retrive info from  tbl_accept_coupon
			

		$sql="select distinct sp.sp_name, ac.points,ac.product_name, ac.issue_date, ac.coupon_id from tbl_accept_coupon ac join tbl_sponsorer sp on sp.id = ac.sponsored_id  where ac.stud_id = '$std_PRN' and ac.school_id='$school_id' ORDER BY ac.id DESC LIMIT $limit OFFSET $offset ";
		 //$limit call from core/securityfunctions.php

 			 $arr = mysql_query($sql);
  			$count=mysql_num_rows($arr);
  				/* create one master array of the records */
  			$posts = array();
			if($count==0 && $arr) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
						
					}
					//End SMC-3450
  			else if($count > 0) {
    			while($post = mysql_fetch_assoc($arr))
				{
					$sp_name=ucwords(strtolower($post['sp_name']));
					$product_name=$post['product_name'];
					$points=$post['points'];
					$issue_date=$post['issue_date'];
      				$coupon_id=$post['coupon_id'];
      				$posts[] = array('coupon_id'=>$coupon_id,'sponsor_name'=>$sp_name,'product_name'=>$product_name,'points'=>$points,'date'=>$issue_date);
    			}
				$sqa=mysql_query("select std_complete_name,id from tbl_student where id='$std_id' and school_id='$school_id' ");
									$rows2=mysql_fetch_assoc($sqa);
									$s_id1=$rows2['id'];
									$std_complete_name=$rows2['std_complete_name'];
									$name=$rows2['std_name'];
									$std_lastname=$rows2['std_lastname'];
									$std_Father_name=$rows2['std_Father_name'];
									if($std_complete_name == "")
									{
										$std_complete_name= $name." ".$std_Father_name." ".$std_lastname;
									}
									else{
										$std_complete_name;
									}
			 
			 $server_name = $GLOBALS['URLNAME'];
			 
							
					$data = array('
					Action_Description'=>'Used SmartCookie Coupon',
					'Actor_Mem_ID'=>$s_id1,
					'Actor_Name'=>$std_complete_name,
					'Actor_Entity_Type'=>105,
					'Second_Receiver_Mem_Id'=>'',
					'Second_Party_Receiver_Name'=>$sp_name,
					'Second_Party_Entity_Type'=>108,
					'Third_Party_Name'=>'',
					'Third_Party_Entity_Type'=>'',
					'Coupon_ID'=>$coupon_id,
					'Points'=>$points,
					'Product'=>$product_name,
					'Value'=>'',
					'Currency'=>''
							);
							
							$ch = curl_init("$server_name/core/Version2/master_action_log_ws.php"); 	
							
							
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
						//	echo '';
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
  
 