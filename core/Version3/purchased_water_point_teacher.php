<?php  



$json = file_get_contents('php://input');

$obj = json_decode($json);



 $format = 'json'; //xml is the default



include 'conn.php';



 $coupon_id=$obj->{'coupon_id'};

 $t_id=$obj->{'t_id'};

 $school_id=$obj->{'school_id'};

 

 

	if($coupon_id)

		{

			//retrive info from  tbl_accept_coupon

		 $query=mysql_query("select water_point from tbl_teacher where t_id='$t_id' and school_id='$school_id'");

		 $result_query=mysql_fetch_array($query);

		 $water_point=$result_query['water_point'];

		 

		 $sql= "select * FROM tbl_giftcards where  card_no='$coupon_id' and status='Unused'";

		 

 			 $arr = mysql_query($sql);

  

  			

  			if(mysql_num_rows($arr)==1) {

    			while($post = mysql_fetch_assoc($arr)) {

					

						//$sc_id=(int)$post['sc_id'];

						$amount=$post['amount'];

						  $water_point1=$water_point+$amount;

				$date1=date('d/m/Y'); 

					$status='Used';

						$query1=mysql_query("update tbl_teacher set water_point=' $water_point1' where t_id='$t_id' and school_id='$school_id'");

			   mysql_query("update  tbl_giftcards  set  amount='0' ,status='$status' where card_no='$coupon_id' ");

			$test=mysql_query("insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,stud_id,school_id)values('$coupon_id','$amount','$date1','103','$t_id','$school_id')");

			 ///calling  master action log
			 
			 
			 $sq=mysql_query("select t_complete_name,id from tbl_teacher where t_id='$t_id' and school_id='$school_id'");
									$rows1=mysql_fetch_assoc($sq);
									$t_id1=$rows1['id'];
									$t_name=$rows1['t_complete_name'];
			 
			 $server_name = $_SERVER['SERVER_NAME'];
							
									$data = array('Action_Description'=>'Purchased Water Points',
												'Actor_Mem_ID'=>$t_id1,
												'Actor_Name'=>$t_name,
												'Actor_Entity_Type'=>103,
												'Second_Receiver_Mem_Id'=>$t_id1,
												'Second_Party_Receiver_Name'=>$t_name,
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







































































