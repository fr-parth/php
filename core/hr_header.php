<?php

include_once ('function.php');

include_once ('school_function.php');

$smartcookie=new smartcookie();

    /*if(!isset($_SESSION['id']))

    {

        header('location:login.php');

    }*/

 if(isset($_SESSION['entity']))
    {
        $entity = $_SESSION['entity'];
        /*echo "ent".$entity; */
        if($entity==11)
        {
          if(!isset($_SESSION['id']))
        	{
                header('location:login.php');
        	}

            $id=$_SESSION['id'];
            $fields=array("id"=>$id);
            $table="tbl_school_admin";
            $results=$smartcookie->retrive_individual($table,$fields);

            $scadmin=mysql_fetch_array($results);

        	$scadmin_name = $scadmin['name'];

            $school_name = $scadmin['school_name'];

            $address=$scadmin['address'];
			
            $staff_name ="School Admin";

            $name = "Cookie Admin";
            $flag = true;
        }
        if($entity==7)
        {
            if(!isset($_SESSION['staff_id']))
        	{
                header('location:login.php');
        	}

            $id=$_SESSION['staff_id'];
           /* echo $id;*/
            $table="tbl_school_adminstaff";
            $fields=array("id"=>$id);
            $results=$smartcookie->retrive_individual($table,$fields);

            $scadmin=mysql_fetch_array($results);

        	$scadmin_name = $scadmin['stf_name'];

            $school_name = "";

            $address="";
            $name = "Admin Staff";
            $flag = false;
        }
    }
            if($scadmin_name=="")
            {
				header('location:login.php');
            }




//print_r(phpinfo());


          /*
           $id=$_SESSION['id'];
*/




           /*$table="tbl_school_admin"; */




?>


<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta charset="utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Smart Cookies:School Admin</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
 
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>


<script>

(function($){

    $(document).ready(function(){

        $('ul.dropdown-menu [data-toggle=dropdown]').on('mouseover', function(event) {





            $(this).parent().siblings().removeClass('open');

            $(this).parent().toggleClass('open');

        });

    });

})(jQuery);

</script>



<style>

a{
cursor : pointer;

}


.carousel {

    height: 300px;

    margin-bottom: 50px;

}

.carousel-caption {

    z-index: 10;

}

.carousel .item {

    background-color: rgba(0, 0, 0, 0.8);

    height: 300px;

}



.navbar-inverse .navbar-nav>li>a {

color: #FFFFFF;

font-weight:bold;

}

.navbar-inverse{



    border-color:#FFFFFF;

}

.preview

{

border-radius:50% 50% 50% 50%;

height:100px;

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

-webkit-border-radius: 99em;

  -moz-border-radius: 99em;

  border-radius: 99em;

  border: 5px solid #eee;

  width:100px;

}

.width-menu{min-width:184px !important;}



.left-drop{left:140px !important; top: -0px !important; width:230px;}



.nav-li-a {

padding:38px 17px;

}

</style>

</head>



<body>



<!-- header-->

<div class="container" align="center" >

        <div class="row">

        		<div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;">
				<img src="images/Smart_Cookies_Logo001.jpg" width="100%" height="70" class="img-responsive" alt="Responsive image"/>

                </div>

			<div  class="col-md-5" align="left">

				<h1 style="color:#666666;font-weight:bold;font-family:Times New Roman, Times, serif;"><?php echo $school_name; ?></h1>

				<h4>Empolyee/Management Reward Program</h4>



			</div>

			<div class="col-md-2" style="padding-right:10px;" >

            	<div style="padding:5px; width:100%;" align="center">



					<?php if($scadmin['img_path']!=""){?>

							<img src='<?php echo $scadmin['img_path']?>'  height="70"; width="70"  class="preview"/>

							<?php }else{ ?>

							<img src="image/avatar_2x.png" width="70" height="70" class="preview" />

							<?php } ?>

                </div>

             </div>

				<div class="col-md-3">

                    <div class="row" style="background-color:#428BCA; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">

                       Welcome
					   <!--'$scadmin_name' added by Rutuja Jori for displaying name of HR Admin on 25/05/2019-->
					   
					   <?php echo $scadmin_name;?>  | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;



                    </div>

                    <div  class="row" style="font-size:12px;height:30px;">

                     	Member ID :<?php

                        echo "HRA".str_pad($id,11,"0",STR_PAD_LEFT);

                        ?>

                    </div >

                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">HR Admin</div>

					
					<div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
<!--'Organization ID' field added by Rutuja Jori for displaying school_id of HR Admin on 25/05/2019-->
               Organization ID : <?php echo $_SESSION['school_id'];?> 

            </div>
                </div>



        </div>

 </div>

				<?php $url=$_SERVER['REQUEST_URI'];
						/*echo $url; */
                $arr=explode('/',$url);
                $pagename=$arr[count($arr)-1];
                ?>



<div class=" navbar-inverse" role="navigation" style="background-color:#428BCA;width:100%;">



              <div class="container" >



                <div class="navbar-header">



					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">



                    <span class="sr-only">Toggle navigation</span>



                    <span class="icon-bar"></span>



                    <span class="icon-bar"></span>



                    <span class="icon-bar"></span>



					</button>





                </div>

					<?php


								$getpermision=mysql_query("select * from tbl_permission where s_a_st_id=".$id."");
							        
									$fetchpermision=mysql_fetch_array($getpermision);
									      
										$perm=$fetchpermision['permission'];


					?>

                
				
				
				<div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#428BCA;">



				<ul class="nav navbar-nav ">
                    <?php 	$Lb="LDBRD";
							$Mst=strpos($perm,$Lb);

							if($Mst !== false || $flag)
					{?>
                    <li  color:#FFFFF <?php if($pagename=='top10_stud_scadmin.php'){?> style="background-color: #080808;"<?php }?>>
					<a href="top10_emp_scadmin.php">Leaderboard</a></li>

					<?php } ?>

                      <?php if($entity==11){ ?>
                     <li color:#FFFFF <?php if($pagename=='hradmin_dashboard.php'){?> style="background-color: #080808;"<?php }?> >
					 <a href="hradmin_dashboard.php">Dashboard</a></li>
                      <?php }else{ ?>
                    <li color:#FFFFF <?php if($pagename=='scadmin_dashboard.php'){?> style="background-color: #080808;"<?php }?> >
					<a href="school_staff_dashboard.php">Dashboard</a></li>
                      <?php } ?>



						<?php $Masters="Master";
							$Mstr=strpos($perm,$Masters);
							if($Mstr !== false || $flag)
						{?>
           
	<li <?php if($pagename=='teacherlist.php' ||$pagename=='studentlist.php' ||$pagename=='parents_list.php' ||$pagename=='list_semester.php' ||$pagename=='student_semester_record.php' ||$pagename=='list_student_subject.php' ||$pagename=='list_teacher_subject.php' ||$pagename=='school_master_table.php' ||$pagename=='activitylist.php' ||  $pagename=='list_school_subject.php' || $pagename=='list_school_branch.php' || $pagename=='list_school_department.php'){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#" >Masters</a>

								<ul class="dropdown-menu">
								<?php $Departments="Departments";
										$Dep=strpos($perm,$Departments);
										if($Dep !== false || $flag)
								{?>

								<li><a href="list_company_department.php">Department</a></li>

								<?php } ?>
								<?php $BrSubjects="Course";
								$Dep=strpos($perm,$BrSubjects);
								if($Dep !== false || $flag)
								{?>

                                

								<?php } ?>
                                  

                 <?php } ?>
								   <?php $Division="Division";
            					      $Div=strpos($perm,$Division);
            						  if($Div !== false || $flag)
            						  {?>

                                  <li><a href="list_company_designation.php">Designation</a></li>

                                  <?php } ?>
								  <?php $Division="year";
            					      $Div=strpos($perm,$Division);
            						  if($Div !== false || $flag)
            						  {?>

                                  <li><a href="list_company_academic_year.php">Academic Year</a></li>

                                  <?php } ?>

                                 

                                   <?php $Student="Student1";
					      $St=strpos($perm,$Student);
						  if($St !== false || $flag)
						  {?>

                                  <li><a href="employeelist.php">Employee</a></li>

                                   <?php } ?>



                                   <?php $Teacher="Teacher1";
					      $Tch=strpos($perm,$Teacher);
						  if($Tch !== false || $flag)
						  {?>
                                  <li><a href="managerlist.php">Manager</a></li>

                                  <?php } ?>


                            <?php $Subject="Subject1";
        					      $Sub=strpos($perm,$Subject);
        						  if($Sub !== false || $flag)
        						  {?>

                                  <li><a href="list_company_projects.php">Project</a></li>


                                   <?php $BrSubjects="BrSubjects";
            					      $Dep=strpos($perm,$BrSubjects);
            						  if($Dep !== false || $flag)
            						  {?>

                                  <li><a href="dep_project_master.php">Departments Projects</a></li>

                                   <?php } ?>


								<?php $TSub="TSub";
								$St=strpos($perm,$TSub);
								if($St !== false || $flag)
								{?>

                                  <li><a href="list_Employee_Project.php">Emoployee Projects</a></li>

                                <?php } ?>


                           


                          

                              

                            <?php $ScholM="School Master";
    					      $SM=strpos($perm,$ScholM);
    						  if($SM !== false || $flag)
    						  {?>

                                  <li><a href="company_master_table.php">Company Master</a></li>

                                  <?php } ?>

                                <?php $Activity="Activity";
        					      $Activi=strpos($perm,$Activity);
        						  if($Activi !== false || $flag)
        						  {?>
                                  <li><a href="Activitylist.php">Activity</a></li>

                                  <?php } ?>

								
								<?php $Division="access";
        					      $Div=strpos($perm,$Division);
        						  if($Div !== false || $flag)
        						  {?>
                                  <li><a href="HRStaff_list.php">HR Staff</a></li>
                                    <?php } ?>
                                  <li><a href="hr_access.php">HR Staff Access</a></li>

                                <!-- <li><a href="Menu_list.php">Add Menu</a></li>-->

                                <!--  <li><a href="Sub_menu_list.php">Add Sub Menu</a></li>-->

                                          <?php $ThanQ="ThanQ";
                					      $Than=strpos($perm,$ThanQ);
                						  if($Than !== false || $flag)
                						  {?>

                                 <li><a href="Thanqyoulist.php">ThanQ Reason List </a></li>
                                 <?php } ?>

                               <!-- <li><a href="school_settings.php">Who Assign Blue Points?</a></li>



                                <li><a href="get_list_teacher_error_file.php">Get Teacher Error file</a></li>-->

                                 <?php $ThanQ="sms";
					      $Than=strpos($perm,$ThanQ);
						  if($Than !== false || $flag)
						  {?>
                                <li><a href="Send_Msg_manager.php">Send SMS/Email</a></li>

                            <?php } ?>

                                 <?php $up="Upload Panel";
					      $W=strpos($perm,$up);
						  if($W !== false || $flag)
						  {?>
								
                                <li><a href="sd_upload_panel1.php">Upload Panel</a></li>

                            <?php } ?>

                             <?php $cre="create";
					      $Than=strpos($perm,$cre);
						  if($Than !== false || $flag)
						  {?>
                                <li><a href="extract_data1.php">Create Excel Files</a></li>
                               <?php } ?>
							    <li><a href="merge_employee_Project.php">Generate Emoployee Project Master</a></li>
                                                               </ul>







            </li>

            <?php } ?>
              <?php $Points="Points";
					      $P=strpos($perm,$Points);
						  if($P !== false || $flag)
						  {?>
             <li <?php if($pagename=='teacherassign.php' || $pagename=='assignbluepointsstud.php' || $pagename=='teacher_thanQ_points.php' || $pagename=='assigngreenpoint.php'){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Points</a>

             <ul class="dropdown-menu width-menu">
                  <?php $BPTs="Distribution";
					      $BP=strpos($perm,$BPTs);
						  if($BP !== false || $flag)
						  {?>
                <li class="dropdown dropdown-submenu" style="margin-left:0px;" ><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Distribution Points</a>

                    <ul class="dropdown-menu left-drop" style="left:0px;">

                            <li class="dropdown dropdown-submenu" style="margin-left:0px;" ><a href="#" class="dropdown-toggle" data-toggle="dropdown">Green Points to manager</a> 
                                    		 <ul class="dropdown-menu left-drop" style="left:0px;">
                                             		<li class="kopie"><a href="managerassign.php">List</a></li>
                                                    <li class="kopie"><a href="search_manager_points.php">Search</a></li>
                                             </ul>
                            </li>
                            <li class="dropdown dropdown-submenu" style="margin-left:0px;" ><a href="#" class="dropdown-toggle" data-toggle="dropdown">Blue Points to employee</a> 
                                    		 <ul class="dropdown-menu left-drop" style="left:0px;">
                                             		<li class="kopie"><a href="assignbluepointsemp.php">List</a></li>
                                                    <li class="kopie"><a href="search_employee_points.php">Search</a></li>
                                             </ul>
                            </li>
                         
                                  

                      </ul>

                </li>
                     <?php }  ?>

                  <?php $BPTs="Reward";
					      $BP=strpos($perm,$BPTs);
						  if($BP !== false || $flag)
						  {?>
                <li class="dropdown dropdown-submenu" ><a href="#" class="dropdown-toggle" data-toggle="dropdown">As Rewards</a>



                 <ul class="dropdown-menu left-drop" style="left:0px;">

                                    
                                    <li class="dropdown dropdown-submenu" style="margin-left:0px;" ><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Blue Points to Manager</a>
                                    		<ul class="dropdown-menu left-drop" style="left:0px;">
                                             		<li class="kopie"><a href="manager_thanQ_points.php">List</a></li>
                                                    <li class="kopie"><a href="search_manager_reward_points.php">Search</a></li>
                                            </ul>
                                    
                                    
                                    </li>
                                    <li class="dropdown dropdown-submenu" style="margin-left:0px;" ><a href="#" class="dropdown-toggle" data-toggle="dropdown">Green Points to Employee</a>
                                    		<ul class="dropdown-menu left-drop" style="left:0px;">
                                             		<li class="kopie"><a href="assigngreenpointsemp.php">List</a></li>
                                                    <li class="kopie"><a href="search_employee_reward_points.php">Search</a></li>
                                             </ul>
                                    
                                    
                                    </li>
                                   
                                </ul>

                </li>
                   <?php }  ?>


            </ul>

            </li>     <?php } ?>




                                 <?php $Points_Status="Points Status";
					      $L=strpos($perm,$Points_Status);
						  if($L !== false || $flag)
						  {?>
                                 <li <?php if($pagename=='log_distribution.php' || $pagename=='student_log.php' || $pagename=='sponsorer_log.php' || $pagename=='bluepoints_teacher_log.php'){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#" >Points Status</a>



                             <ul class="dropdown-menu">
                                <?php $TGP="TGP1";
					      $BGP=strpos($perm,$TGP);
						  if($BGP !== false || $flag)
						  {?>
                                <li><a href="log_distribution1.php">Green Points given to Manager for Distribution</a></li>

                                <?php } ?>



                          <?php $TeacherBluePoint="Teacher Green Point";
					      $TeacherBPoint=strpos($perm,$TeacherBluePoint);
						  if($TeacherBPoint !== false || $flag)
						  {?>

                           <li><a href="blue_point_employee_distribution.php">Blue Points Given to Employee for Distribution</a></li>
                                    <?php } ?>

                                  </ul></li>

                                 <?php } ?>



                            <?php $Sponsor="Sponsor Map";
					      $s=strpos($perm,$Sponsor);
						  if($s !== false || $flag)
						  {?>
                          <li <?php if($pagename=='school_sponsor_map.php'){?> style="background-color: #080808;"<?php }?>><a href="company_sponsor_map.php">Sponsor Map</a></li>
                            <?php } ?>


                         <!-- <li><a href="scadmin_purchase_point.php">Purchase Points</a></li>-->
                            <?php $Purches="purchesC";
					      $Pches=strpos($perm,$Purches);
						  if($Pches !== false || $flag)
						  {?>
                          <li <?php if($pagename=='scadmin_greenpoint_coupon.php' || $pagename=="scadmin_bluepoint_coupon.php" ){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Purchase Points</a>
                             <?php } ?>
                             <ul class="dropdown-menu">

                                   <?php $GeenPointscoupones="Gpc1";
					      $GeenPscoupones=strpos($perm,$GeenPointscoupones);
						  if($GeenPscoupones !== false || $flag)
						  {?>

                                  <li><a href="scadmin_greenpoint_coupon1.php">Green Points</a></li>
                                    <?php } ?>

                            <?php $BluePointscoupones="Bpc2";
					      $Bluecoupones=strpos($perm,$BluePointscoupones);
						  if($Bluecoupones !== false || $flag)
						  {?>
                                  <li><a href="scadmin_bluepoint_coupon1.php">Blue Points </a></li>
                                    <?php } ?>


                              </ul></li>



                              <li <?php  if($pagename=='schooladminprofile_20152904.php' ){?> style="background-color: #080808;"<?php }?> ><a href="companyadminprofile_20152904.php">Profile</a></li>


                 <?php $Logs="Logs";
					      $L=strpos($perm,$Logs);
						  if($L !== false || $flag)
						  {?>
                                 <li <?php if($pagename=='teacherlog.php' || $pagename=='student_log.php' || $pagename=='sponsorer_log.php' || $pagename=='bluepoints_teacher_log.php'){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#" >Log</a>



                             <ul class="dropdown-menu">
                                <?php $TGP="TGP1";
					      $BGP=strpos($perm,$TGP);
						  if($BGP !== false || $flag)
						  {?>
                                <li><a href="managerlog.php">Green Points given to Manager for Distribution</a></li>

                                <?php } ?>

                            <?php $SGP="S2gp";
					      $SG1=strpos($perm,$SGP);
						  if($SG1 !== false || $flag)
						  {?>
                                 <li><a href="employee_log.php">Green Points given to Empolyee as rewards</a></li>

                                 <?php } ?>

                            <?php $Sponsor="Sponsor1";
					      $Sponsor1=strpos($perm,$Sponsor);
						  if($Sponsor1 !== false || $flag)
						  {?>

                                  <li><a href="sponsorer_log1.php">Sponsor</a></li>

                                   <?php } ?>

                                 <?php $TeacherBluePoint="Teacher Blue Point";
					      $TeacherBPoint=strpos($perm,$TeacherBluePoint);
						  if($TeacherBPoint !== false || $flag)
						  {?>
                                  <li><a href="bluepoints_manager_log.php">Blue Points given to Manager as Rewards</a></li>

                                    <?php } ?>

                                <?php $TeacherBluePoint="Teacher Green Point";
					      $TeacherBPoint=strpos($perm,$TeacherBluePoint);
						  if($TeacherBPoint !== false || $flag)
						  {?>

								<li><a href="blue_points_logemployee.php">Blue Points Given to Employee for Distribution</a></li>
                                    <?php } ?>

                                    <?php $BM="status";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                       <li><a href="loginStatus1.php">Login Status Log</a></li>
                        <?php } ?>

                         <?php $BM="actLog";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                       <li><a href="ActivityLog1.php">Activity Log</a></li>
                        <?php } ?>

                                  </ul></li>

                                 <?php } ?>
           <!-- </li> -->


              <?php $Purches="Report";
					      $Pches=strpos($perm,$Purches);
						  if($Pches !== false || $flag)
						  {?>
              <li <?php if($pagename=='Batch_Master_PT.php' || $pagename=="teachersubjectreport.php" || $pagename=="Studentsubjectreport.php" || $pagename=="teacher_report_PT.php" || $pagename=="student_report_PT.php"){?> style="background-color: #080808;"<?php }?>><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Report</a>

               <ul class="dropdown-menu">
                        <?php $BM="BM";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                       <li><a href="Batch_Master_PT_1.php">Batch Master</a></li>
                         <?php } ?>

                          <?php $BM="TSR";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>

                      <li><a href="managerprojectreport.php">Manager Project</a></li>
                        <?php } ?>

                          <?php $BM="SSR";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                      <li><a href="Employeeprojectreport.php">Employee Subject</a></li>
                        <?php } ?>

                          <?php $BM="TR1";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                      <li><a href="manager_report_PT.php">Manager</a></li>
                        <?php } ?>

                          <?php $BM="SR1";
					      $T=strpos($perm,$BM);
						  if($T !== false || $flag)
						  {?>
                       <li><a href="Employee_report_PT.php">Employee</a></li>
                        <?php } ?>


                </ul>

               </li>

                  <?php } ?>



		<li>
			<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Search</a>
			
					<ul class="dropdown-menu">
                        
						<li><a href="displayemp_project.php">Empolyee Projects</a></li>
						
                        <li><a href="managerdisplayproject.php">Manager Project</a></li>
						
						<li><a href="searching1.php">Manager/Project</a></li>
						
					</ul>


		</li>

                  </ul>



				</div> <!-- /.nav-collapse -->



				</div> <!-- /.container -->


</div>

</body>

</html>