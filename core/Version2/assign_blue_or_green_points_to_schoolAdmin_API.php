<?php


$json = file_get_contents('php://input');
$obj = json_decode($json);

     $point = $obj->{'points'};
     $school_id = $obj->{'school_id'};
      $color = $obj->{'point_color'};   // BLUE / GREEN
     $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
     $format = 'json'; //xml is the default
     include 'conn.php';
 if(!empty($point) && !empty($school_id) && !empty($color))
		{

             if($color=='BLUE')
             {

                    $posts=array();
          
      			 
      			  $rows=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");
      			  $arrs=mysql_fetch_array($rows);
      			  $balance_blue_points=$arrs['balance_blue_points'];
				  $sch_name=$arrs['school_name'];
      			  $balance_point=$balance_blue_points+$point;
      			  //$status='Used';

      			   mysql_query("update tbl_school_admin set balance_blue_points='$balance_point' where school_id='$school_id'");
      			 

      			     if(mysql_affected_rows()>0)
      			     {
						 $date=date("m/d/Y");
						$time=date("h:i:sa");
							  $log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date,time)
								values ('cookieadmin','$point','$color','$sch_name','$school_id','$date','$time')");
								
      			            $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="You  got ".$point. " Blue Points";
                				$postvalue['posts']=null;
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
 
               



                }else if($color=='GREEN')
               {

                          
              			  $rows=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");
              			  $arrs=mysql_fetch_array($rows);
              			  $balance_green_points=$arrs['school_balance_point'];
						  $sch_name=$arrs['school_name'];
              			  $balance_point=$balance_green_points+$point;
              		    	

              			   mysql_query("update tbl_school_admin set school_balance_point='$balance_point' where school_id='$school_id'");
              			 
							
              			  if(mysql_affected_rows()>0)
              			  {
							   $date=date("m/d/Y");
								$time=date("h:i:sa");
							  $log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date,time)
								values ('cookieadmin','$point','$color','$sch_name','$school_id','$date','$time')");
								
              			        $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="You  got ".$point. " Green Points";
                				$postvalue['posts']=null;
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