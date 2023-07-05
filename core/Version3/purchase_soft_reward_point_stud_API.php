<?php

 $json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
    $stud_PRN = $obj->{'stud_prn'};
    $sch_id = $obj->{'school_id'};
    $soft_id = $obj->{'softreward_id'};
    //$assign_date=date('d/m/Y : H:i:s',time());
 
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';


 $dates = CURRENT_TIMESTAMP;// define in core/securityfunctions.php


    if($stud_PRN!='' && !empty($sch_id) && $soft_id!='')
	{
                //school_type retreived from tbl_school_admin based on school_id and used for further queries by Pranali for SMC-4452 on 27-1-20
              $school_org = mysql_query("SELECT school_type FROM tbl_school_admin WHERE school_id='$sch_id'");
              $school_type1 = mysql_fetch_assoc($school_org);
              $school_type = $school_type1['school_type'];
              $user_type = ($school_type=='organization')?'Employee':'Student';

                            $soft=mysql_query("select fromRange from softreward where softrewardId='$soft_id' and user='$user_type'");
                            $result=mysql_fetch_array($soft);
							$soft_reward_point=$result['fromRange'];
                  	        $prn=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='$stud_PRN' and school_id='$sch_id'");
							$arr1=mysql_fetch_array($prn);
                            $t_balance_green_points=$arr1['sc_total_point'];
                            if($soft_reward_point<=$t_balance_green_points)
                            {
                                        $total_bal_green_points=$t_balance_green_points-$soft_reward_point;
                                    	$affect=mysql_query("update tbl_student_reward set sc_total_point='$total_bal_green_points'
                                        where sc_stud_id='$stud_PRN' and school_id='$sch_id'");
                                if(mysql_affected_rows()>0)
                                 {
                                        	$insertsoftreward=mysql_query("INSERT INTO purcheseSoftreward (`user_id`,`userType`,`school_id`,`reward_id`,
                                            `point`,`date`) VALUES ('$stud_PRN','$user_type','$sch_id','$soft_id','$soft_reward_point','$dates')");
                                        $postvalue['responseStatus']=200;
                        				$postvalue['responseMessage']="I got"." ".$soft_reward_point." "."points successfully.";
                        				$postvalue['posts']=null;
                                         header('Content-type: application/json');
                           				 echo json_encode($postvalue);
                                 }


                            }else
                            {
                                        $postvalue['responseStatus']=204;
                        				$postvalue['responseMessage']="Sry.. you don't have sufficient points to buy soft reward.";
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