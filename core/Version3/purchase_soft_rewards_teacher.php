<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
  
  include '../conn.php';
  
    $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
    $sch_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
    $soft_id = xss_clean(mysql_real_escape_string($obj->{'softreward_id'}));
   // $assign_date=date('d/m/Y : H:i:s',time());

  $number_of_posts = xss_clean(mysql_real_escape_string(isset($_GET['num']))) ? xss_clean(mysql_real_escape_string(intval($_GET['num']))) : 10; //10 is the default
  $format = 'json';

    if($t_id!='' && !empty($sch_id) && $soft_id!='')
	{				
		          //school_type retreived from tbl_school_admin based on school_id and used for further queries by Pranali for SMC-4452 on 27-1-20
              $school_org = mysql_query("SELECT school_type FROM tbl_school_admin WHERE school_id='$sch_id'");
              $school_type1 = mysql_fetch_assoc($school_org);
              $school_type = $school_type1['school_type'];
              $user_type = ($school_type=='organization')?'Manager':'Teacher';
              
              $query1="select fromRange,rewardType from softreward where softrewardId='$soft_id' and user='$user_type'";
                            $soft=mysql_query($query1);
                            $result=mysql_fetch_array($soft);
              $soft_reward_point=$result['fromRange'];
              $reward_type= $result['rewardType'];
                            $prn=mysql_query("select balance_blue_points from tbl_teacher where id='$t_id' and school_id='$sch_id'");
              $arr1=mysql_fetch_array($prn);
                            $t_balance_blue_points=$arr1['balance_blue_points'];
                            if($soft_reward_point<=$t_balance_blue_points)
                            {
                                        $total_bal_blue_points=$t_balance_blue_points -$soft_reward_point;
                                      $affect=mysql_query("update tbl_teacher set balance_blue_points='$total_bal_blue_points' where id='$t_id'");
                                if(mysql_affected_rows()>0)
                                 {
                                        	$insertsoftreward=mysql_query("INSERT INTO purcheseSoftreward(user_id,userType,school_id,reward_id,point) VALUES ('$t_id', '$user_type','$sch_id','$soft_id','$soft_reward_point')");
                                        $postvalue['responseStatus']=200;
                                $postvalue['responseMessage']="I got"." ".$reward_type." "."reward successfully.";
                                $postvalue['posts']=null;
                                         header('Content-type: application/json');
                                   echo json_encode($postvalue);
                                 }
                 else
                 {
                    $postvalue['responseStatus']=204;
                                $postvalue['responseMessage']="point not updated";
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