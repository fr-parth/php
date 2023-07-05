<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

     $coupon_id = $obj->{'coupon_id'};
     $school_id = $obj->{'school_id'};
      $color = $obj->{'point_color'};
     $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
     $format = 'json'; //xml is the default
     include 'conn.php';
 if(!empty($school_id) && !empty($coupon_id) && !empty($color))
		{

             if($color=='BLUE')
             {

                    $posts=array();
                   // mysql_query("update tbl_giftof_rewardpoint set parent_id='$parent_id' where coupon_id='$coupon_id'");
      			  $row=mysql_query("select amount,valid_to FROM tbl_giftcards where  card_no='$coupon_id' and status!='Used'");
      			  $arr=mysql_fetch_array($row);
      			  $point=$arr['amount'];
                  $validity_date=$arr['valid_to'];
					
					//Start  SMC-3489 Modify By sachin 2018-10-01 
					//$date1=date('d/m/Y');
						$date1 = CURRENT_TIMESTAMP; 
					//define in core/securityfunctions.php
					//End  SMC-3489

                    
                    $today_time = strtotime($date1);
                    $expire_time = strtotime($validity_date);

                if ($today_time <= $expire_time)
                {
      			  $rows=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");
      			  $arrs=mysql_fetch_array($rows);
      			  $balance_blue_points=$arrs['balance_blue_points'];
      			  $balance_point=$balance_blue_points+$point;
      			  $status='Used';

      			   mysql_query("update tbl_school_admin set balance_blue_points='$balance_point' where school_id='$school_id'");
      			   mysql_query("update  tbl_giftcards  set  amount='0' ,status='$status' where card_no='$coupon_id'");

      			     if(mysql_affected_rows()>0)
      			     {
      			            $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="You  got ".$point. " Blue Points";
                				$postvalue['posts']=$posts;
                               header('Content-type: application/json');
                     			 echo json_encode($postvalue);

      			     }
      			     else
      			            {
      			                $postvalue['responseStatus']=204;
              			    	$postvalue['responseMessage']="Coupon is Invalid";
              				    $postvalue['posts']=null;
                                   header('Content-type: application/json');
                     		    	 echo json_encode($postvalue);

      			             }
 mysql_query("insert into tbl_giftof_bluepoint(coupon_id,points,issue_date,entities_id,user_id)values('$coupon_id','$point','$date1','102','$school_id')");
               } else
      			            {
      			                $postvalue['responseStatus']=204;
              			    	$postvalue['responseMessage']="Sorry.. Coupon date expired.";
              				    $postvalue['posts']=null;
                                   header('Content-type: application/json');
                     		    	 echo json_encode($postvalue);

      			             }



                }else if($color=='GREEN')
               {

                           $row=mysql_query("select amount,valid_to FROM tbl_giftcards where  card_no='$coupon_id' and status!='Used'");
              			   $arr=mysql_fetch_array($row);
              			   $point=$arr['amount'];
                           $validity_date=$arr['valid_to'];
							
							//Start  SMC-3489 Modify By sachin 2018-10-01 
							//$date1=date('d/m/Y');
								$date1 = CURRENT_TIMESTAMP; 
							//define in core/securityfunctions.php
							//End  SMC-3489

                            $today_time = strtotime($date1);
                            $expire_time = strtotime($validity_date);

                    if ($today_time <= $expire_time)
                    {
              			  $rows=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");
              			  $arrs=mysql_fetch_array($rows);
              			  $balance_green_points=$arrs['school_balance_point'];
              			  $balance_point=$balance_green_points+$point;
              		    	$status='Used';

              			   mysql_query("update tbl_school_admin set school_balance_point='$balance_point' where school_id='$school_id'");
              			   mysql_query("update  tbl_giftcards set amount='0',status='$status' where card_no='$coupon_id'");

              			  if(mysql_affected_rows()>0)
              			  {
              			        $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="You  got ".$point. " Green Points";
                				$postvalue['posts']=$posts;
                               header('Content-type: application/json');
                     			 echo json_encode($postvalue);
              			  }
              			  else
              			  {
              			  	 $postvalue['responseStatus']=204;
              			    	$postvalue['responseMessage']="Coupon is Invalid";
              				    $postvalue['posts']=null;
                                   header('Content-type: application/json');
                     		    	 echo json_encode($postvalue);
              			  }


mysql_query("insert into tbl_giftof_rewardpoint(coupon_id,point,issue_date,entity,user_id)values('$coupon_id','$point','$date1','102','$school_id')");
                 }else
      			            {
      			                $postvalue['responseStatus']=204;
              			    	$postvalue['responseMessage']="Sorry.. Coupon date expired.";
              				    $postvalue['posts']=null;
                                   header('Content-type: application/json');
                     		    	 echo json_encode($postvalue);

      			             }

               } else{

                                 $postvalue['responseStatus']=204;
              			    	$postvalue['responseMessage']="Invalid Point Color";
              				    $postvalue['posts']=null;
                                   header('Content-type: application/json');
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


              @mysql_close($con);







?>