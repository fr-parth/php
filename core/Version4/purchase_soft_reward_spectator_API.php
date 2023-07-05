<?php

 $json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
    
    //$mobile = $obj->{'mobile'};  
    $soft_id = $obj->{'softreward_id'};
    //$assign_date=date('d/m/Y : H:i:s',time());

    $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
    $MemberID = $obj->{'MemberID'};
    //MemberID added as i/p parameter by Pranali for SMC-3734 on 24-1-19

 $format = 'json';
include '../conn.php';

    if($MemberID!='' && $soft_id!='')


    {

        
                            $soft=mysql_query("select fromRange from softreward where softrewardId='$soft_id'");
                            $result=mysql_fetch_array($soft);
                            $soft_reward_point=$result['fromRange'];
                            
                            $prn=mysql_query("select * from tbl_vol_spect_master where id='$MemberID'");
                            $arr1=mysql_fetch_array($prn);
                            
                            $t_balance_green_points=$arr1['reward_points'];
                            $category=$arr1['category'];
                            $school_id=$arr1['school_id'];
                            $mobile=$arr1['mobile'];
                            
                            
                            if($soft_reward_point<=$t_balance_green_points)
                            {
                                        $total_bal_green_points=$t_balance_green_points-$soft_reward_point;
                                        $affect=mysql_query("update tbl_vol_spect_master set reward_points='$total_bal_green_points'
                                        where id='$MemberID'");
                                if(mysql_affected_rows()>0)
                                 {
                                            $insertsoftreward=mysql_query("INSERT INTO purcheseSoftreward (`user_id`,`userType`,`school_id`,`reward_id`,


                                            `point`,`date`) VALUES ('$mobile','$category','$school_id','$soft_id','$soft_reward_point',NOW())");


                                        $postvalue['responseStatus']=200;
                                        $postvalue['responseMessage']="I got"." ".$soft_reward_point." "."points successfully.";
                                        $postvalue['posts']=null;
                                         header('Content-type: application/json');
                                         echo json_encode($postvalue);
                                 }

                            }
                            else
                            {
                                        $postvalue['responseStatus']=204;
                                        $postvalue['responseMessage']="Sorry you don't have sufficient points to buy soft reward.";
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