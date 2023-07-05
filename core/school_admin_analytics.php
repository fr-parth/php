<?php
include_once("scadmin_header.php");
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<!-- <script src='js/bootstrap.min.js' type='text/javascript'></script>
<link href="css/style.css" rel="stylesheet"> -->
 <link rel="stylesheet" href="/lib/w3.css">
 
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #428BCA;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #428BCA;
}
.radius{
    border-radius: 80px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>
</head>
<body>


<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        	<h2 style="padding-left:20px;padding-top:15px; margin-top:20px;color:white"> <?php echo  $organization?> Analytics</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="sc_teacher_login_Details.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
	<!--Title changed to Teacher's Login Logout Details by Pranali  -->

                	<h4 class="" align="center"><?php echo $dynamic_teacher;?> Login Logout </br> Details </h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

							
					<!--Below Teacher's Login Logout Details count displayed by Rutuja Jori(PHP Intern) for the Bug SMC-3803 on 30/04/2019-->
        <!--$entity_id added and matched with l.Entity_type  by Pranali for SMC-4629 on 10-4-20 -->
									<?php 
                                    $entity_id = ($dynamic_teacher=='Teachers')?'103':'203';
                                    $row=mysql_query("SELECT count(l.EntityID) as teacher from tbl_LoginStatus l  join tbl_teacher t on t.id=l.EntityID 
                                        where l.Entity_type='".$entity_id."' and l.school_id='$school_id'  ORDER BY l.RowID DESC;");
									

                                             $result=mysql_fetch_array($row);
                                                 echo $result['teacher'];


                                    ?>

                        		</div>

                </div></a>
</div>

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_student_login_Details.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
	<!--Title changed to Students's Login Logout Details by Pranali  -->

                	<h4 align="center"><?php echo $dynamic_student;?> Login Logout </br> Details</h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

								
                  <!--Below Student's Login Logout Details count displayed by Rutuja Jori(PHP Intern) for the Bug SMC-3803 on 30/04/2019--><!--$entity_id added by Pranali for SMC-4629-->		
									<?php 
                                    $entity_id = ($dynamic_student=='Student')?'105':'205';
                                    $result = mysql_query("SELECT count(l.EntityID) as student from tbl_LoginStatus l  join tbl_student t on t.id=l.EntityID 
where l.Entity_type='".$entity_id."' and l.school_id='$school_id' ORDER BY l.RowID DESC");

				$row = mysql_fetch_array($result);
			echo $row['student'];

				?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_analytics_details_smartcookie_coupons_used_by_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
	<!-- Camel casing done for SmartCookie by Pranali-->


                	<h4 align="center">SmartCookie Coupons </br> Used By <?php echo $dynamic_teacher;?> </h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php
		$result = mysql_query( "SELECT COUNT(A.id) AS total FROM tbl_teacher_coupon A INNER JOIN tbl_teacher B ON A.user_id = B.id 
   WHERE (status = 'no' or status = 'p') AND school_id = '$school_id'");
                /*$result = mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher_coupon where(status='no' or status='p') AND school_id = '$school_id'");*/
				 /*  $result = mysql_query( "SELECT COUNT(tc.id) AS total FROM tbl_teacher_coupon tc 
					join tbl_teacher t  on tc.user_id=t.id
					where tc.status='no' or tc.status='p' 
					and t.school_id='$school_id'");*/
					$row = mysql_fetch_array($result);

		 			    echo $row['total'];

				?>

                        		</div>

                </div></a>



</div>



<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_soft_reward_purchase_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center">Soft Rewards Purchased </br> By <?php echo $dynamic_teacher;?></h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
             <!--Below query done by Rutuja Jori to display correct count for the Bug SMC-3803 on 24/05/2019-->
<!--$soft_reward_user checked for p.userType to match Teacher for school and Manager for organization by Pranali for bug SMC-4626 on 9-4-20-->
									<?php 
                                    $soft_reward_user = ($dynamic_teacher=='Teachers')?'Teacher':'Manager';
                                    $row =mysql_query("SELECT p.user_id,t.t_complete_name,p.school_id ,s.rewardType FROM purcheseSoftreward as p  join softreward as s on p.reward_id=s.softrewardId join tbl_teacher t
on p.user_id=t.id and p.school_id=t.school_id where p.userType='".$soft_reward_user."' 
AND p.school_id = '$school_id'");




				///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
				$result = mysql_fetch_array($row);
											$r=mysql_num_rows($row);
                                                echo $r;

				?>

                        		</div>

                </div></a>
</div>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="sc_soft_reward_purchase_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">

                	<h4 align="center">Soft Rewards Purchased </br> By <?php echo $dynamic_student;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
		 <!--Below query done by Rutuja Jori to display correct count for the Bug SMC-3803 on 24/05/2019-->	
									
<!--$dynamic_student checked for p.userType in below query by Pranali to match Student or Employee according to school type and distinct removed for bug SMC-4649 on 9-4-20 -->									
									<?php
									//Change the query and added mysql_num_rows by Sayali Balkawade for SMC-4532 on 2/3/2020
									    $result=mysql_query(

										"SELECT  p.user_id ,p.school_id ,s.rewardType,p.userType,st.std_complete_name,st.std_PRN 

FROM purcheseSoftreward as p left join softreward as s on 
s.softrewardId=p.reward_id  join tbl_student st on p.user_id=st.std_PRN and p.school_id=st.school_id
where p.userType='".$dynamic_student."' and s.rewardType!='' and p.school_id='$school_id'");
										
										
										/*"SELECT count(p.user_id) AS total ,p.school_id ,s.rewardType,p.userType,st.school_id,
st.std_PRN,st.std_complete_name
 FROM purcheseSoftreward as p 
inner join softreward as s on p.reward_id=s.softrewardId 
right join tbl_student as st on st.school_id=p.school_id and st.std_PRN=p.user_id
where ucwords(p.userType)='Student' AND p.school_id = '$school_id'");*/
											
                                            $row = mysql_fetch_array($result);
											$res=mysql_num_rows($result);
											echo $res;


                                    ?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_analytics_details_green_points_distributed_by_cookieadmin.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center">Green Points Distributed  </br>To <?php echo $dynamic_teacher;?> By  </br><?php echo $organization;?> Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
									
	<!--Below Green Points Distributed To Teachers By School Admin count displayed by Rutuja Jori(PHP Intern) for the Bug SMC-3803 on 30/04/2019-->


				<!--$dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019-->					
									<?php
                $result = mysql_query("SELECT sum(tp.sc_point) as teacher_green_points FROM tbl_teacher_point tp join tbl_teacher t on t.t_id=tp.sc_teacher_id where tp.sc_entities_id='102' 
AND tp.school_id='$school_id' 
AND tp.reason = 'assigned by $dynamic_school_admin' order by tp.id desc");

				$row = mysql_fetch_array($result);
				if($row['teacher_green_points']==0){
					echo "0";
				}
				else{
				echo $row['teacher_green_points'];
				}
			      

				?>

                        		</div>

                </div></a>			


				
				




</div>




<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_vendor_coupon_purchased_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">

                	<h4 align="center">Vendor Coupons Used By <?php echo $dynamic_teacher;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php $row=mysql_query("SELECT count(t.t_complete_name) as total,tvc.coupon_id, tvc.code, tvc.user_id,t.school_id  
 FROM tbl_selected_vendor_coupons tvc 
 INNER JOIN tbl_teacher t ON tvc.user_id=t.id and t.school_id=tvc.school_id where tvc.entity_id='2' and t.school_id='$school_id'");
									//SELECT * FROM tbl_selected_vendor_coupons where  user_id='498';
                                             $result = mysql_fetch_array($row);
                                                echo $result['total'];


                                    ?>

                        		</div>

                </div></a>
</div>

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_vendor_coupon_purchased_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">

                	<h4 align="center">Vendor Coupons Used By <?php echo $dynamic_student;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php $row=mysql_query("SELECT count(s.std_complete_name) as total,s.school_id ,  tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where   
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$school_id')");
                                             $row = mysql_fetch_array($row);
											 
		 			                          echo $row['total'];


                                    ?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="sc_analytics_details_smartcookie_coupons_used_by_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
	<!-- Camel casing done for SmartCookie by Pranali-->

                	<h4 class="" align="center">SmartCookie Coupons </br> Used By <?php echo $dynamic_student;?> </h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
						<?php	
									 $result=mysql_query("SELECT COUNT(id) AS total FROM tbl_coupons as student_smartcookie_used where (status = 'no' or status = 'p') AND school_id = '$school_id' ");
									//SELECT DISTINCT  * FROM tbl_LoginStatus where  Entity_type=103 
                                              $row = mysql_fetch_array($result);
				
		 			                          echo $row['total'];


                                    ?>

                        		</div>
								

                </div></a>
</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_analytics_details_blue_points_distributed_by_cookieadmin.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center">Blue Points Distributed </br>To <?php echo $dynamic_student;?> By </br> <?php echo $organization;?> Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
									
  <!--Below Blue Points Distributed To Students By School Admin count displayed by Rutuja Jori(PHP Intern) for the Bug SMC-3803 on 30/04/2019-->					
									
									<?php
                $result = mysql_query("SELECT sum(sp.sc_point) as student_blue_points FROM tbl_student_point sp join tbl_student s on
 sp.sc_stud_id=s.std_PRN and sp.school_id=s.school_id where sp.sc_entites_id='102'
 AND sp.school_id='$school_id' AND sp.type_points='blue_point'
order by sp.id desc;");

				$row = mysql_fetch_array($result);
				if($row['student_blue_points']==0){
					echo "0";
				}
				else{
				echo $row['student_blue_points'];
				}
				?>

                        		</div>

                </div></a>			
</div>

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_analytics_details_teachers_without_email.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">

	<!-- Camel casing done for Email ID by Pranali-->
                	<h4 align="center"><?php echo $dynamic_teacher;?> Without Email ID</h4>


                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_email='' AND school_id = '$school_id'");
				//SELECT * FROM techindi_Dev.tbl_teacher where t_email='';
				///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];
				?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_analytics_details_teachers_without_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center"><?php echo $dynamic_teacher;?> Without Phone No</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_phone='' AND school_id = '$school_id'");
				///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];
				?>

                        		</div>

                </div></a>

</div>



<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_analytics_details_teachers_without_email_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center"><?php echo $dynamic_teacher;?> Without Email </br> And Phone No </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php
                $result = mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_email ='' and t_phone='' AND school_id = '$school_id'");
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];

				?>

                        		</div>

                </div></a>				

</div>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_analytics_details_students_without_email.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
	<!-- Camel casing done for Email ID by Pranali-->
                	<h4 align="center"><?php echo $dynamic_student;?> Without Email ID</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_email='' AND school_id = '$school_id'");
				//SELECT * FROM techindi_Dev.tbl_teacher where t_email='';
				///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];
				?>

                        		</div>

                </div></a>
<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_analytics_details_students_without_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center"><?php echo $dynamic_student;?> Without Phone No</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_phone='' AND school_id = '$school_id'");
				///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];
				?>

                        		</div>

                </div></a>
				
				</div>
				
				<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:50px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="sc_analytics_details_students_without_email_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center"><?php echo $dynamic_student;?> Without Email </br> And Phone No </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php
                $result = mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_phone ='' and std_email='' AND school_id = '$school_id' ;");
				$row = mysql_fetch_array($result);
				
		 			    echo $row['total'];

				?>

                        		</div>

                </div></a>				


</div>
<?php if($school_type=='Sports')
{?>
<div class="row" style="padding-top:10px; width:100%;">
<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_spectator_login_Details.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center">Spectator's Login Logout Details</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result = mysql_query("Select count( vm.name) as spectator,vm.category,vm.mobile,ls.EntityID,ls.school_id,ls.LatestLoginTime,ls.LogoutTime from tbl_LoginStatus
 ls inner join 
tbl_vol_spect_master vm on vm.id=ls.EntityID and vm.school_id=ls.school_id 
 where ls.Entity_type='119' and ls.school_id='$school_id'");
				$row = mysql_fetch_array($result);
				
		 			    echo $row['spectator'];
				?>

                        		</div>

                </div></a>
				
				<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_soft_rewards_purchase_spectator.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center">Soft Rewards Purchased </br> By Spectator</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php $row=mysql_query("SELECT COUNT(id) AS total FROM 
									tbl_selected_vendor_coupons where  entity_id='2' AND used_flag ='used' AND school_id = '$school_id'");
									//SELECT * FROM tbl_selected_vendor_coupons where  user_id='498';
                                             $result = mysql_fetch_array($row);
                                                echo $result['total'];


                                    ?>

                        		</div>

                </div></a>
				<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="sc_analytics_details_smartcookie_coupons_used_by_spectator.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center">SmartCookie Coupons </br> Used By Spectator </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									 <?php
                $result = mysql_query("Select count(vm.name) as spectator ,vm.category,vm.mobile,ac.points,ac.coupon_id
from tbl_accept_coupon ac inner join 
tbl_vol_spect_master vm on vm.mobile=ac.stud_id and vm.school_id=ac.school_id 
where ac.school_id='$school_id'");
				$row = mysql_fetch_array($result);
				
		 			    echo $row['spectator'];
				?>

                        		</div>

                </div></a>
				

</div>
<?php }?>
</body>
</html>


<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link href="css/style.css" rel="stylesheet">
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  rgba(150,150,150, 0.5);
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>

</head>
<body>
<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div style="height:50px; width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #666666;" align="left">
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;padding-left:15px;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="school_list.php" style="text-decoration:none";>
    <div class="col-md-3 " style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Schools</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_school_admin where school_id!='0'");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="teacher_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
                $result = mysql_query('SELECT COUNT(id) AS total_teachers FROM tbl_teacher where school_id!=""');
				$row = mysql_fetch_array($result);
			echo $row['total_teachers'];

				?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="student_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									 <?php
                $result = mysql_query('SELECT COUNT(id) AS total_students FROM tbl_student where school_id!=""');
				$row = mysql_fetch_array($result);
		 			    echo $row['total_students'];
				?>

                        		</div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="sponsor_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Sponsors</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
									    $row=mysql_query("select * from tbl_sponsorer");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="parent_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Parents</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_parent");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                        		</div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="CookieAdminStaff_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Staff</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select * from tbl_cookie_adminstaff");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                        		</div>

                </div></a>
</div>


</div>









</div>

</body>
</html>







-->
