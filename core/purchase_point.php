<?php
 error_reporting(0);
 include_once('Parent_header.php');
 $report="";
 $parent_id=$_SESSION['id'];

		if(!isset($_SESSION['id']))
	{
    	header("location:login.php");
	}
	$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_parent";

		   $smartcookie=new smartcookie();

$row=$smartcookie->retrive_individual($table,$fields);
		$result_p=mysql_fetch_array($row);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
#center {
   width: 200px;
   height: 20px;
   position: absolute;
      background: rgba(0,0,0,1);
  border: 2px solid rgba(255,255,255,1);
  border-radius: 5px;
  box-shadow: 0px 0px 10px 5px rgba(255,255,255,0.2);
}

#main {

   height: 16px;
  background: #92C81A;
  float: left;
  animation: stretch 5s infinite linear;
}
</style>
</head>

<body align="center" >
	<div class="container" style="padding:5px;">

    <div class="row">
            <div class="col-md-5">
            <div class="container" style="padding:5px;background-color:#D4EFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #D4EFFF;" align="center">
                <div class="panel panel-danger" >
                    <div class="panel-heading">
                         <span  style="font-size:14px;font-weight:bold;">Water Points</span>
                        </div>

                   

                     <div class="panel-body" >
                     <div class="col-md-6">
                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                Purchase Points
                               </div>


                                <div class="row" style="font-size:64px;padding-left:5px;color:#9DE7CA;font-weight:bold;">
                                    <?php echo $result_p['balance_points'];?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>
                     </div>

                   <div class="col-md-6" >


                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                    Assigned Points
                                </div>
                                <?php $arrs=mysql_query("select sum(sc_point) as assign_point from tbl_student_point where sc_teacher_id='$parent_id' and sc_entites_id=106 " );
                                      $result=mysql_fetch_array($arrs);
                                ?>
                                <div class="row" style="font-size:64px;padding-left:5px;color:#9DE7CA;font-weight:bold;">

                                    <?php if($result['assign_point']!=0)
									{ echo $result['assign_point']; }
									else
									{
									echo "0";
									}?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>
                            <!--<span  style="font-size:14px;font-weight:bold;">Water Points</span>

                      </div>

                     <div class="panel-body" >
                     <div class="col-md-6">
                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                Purchase Points
                               </div>
                                <?php


                                                         ?>

                                <div class="row" style="font-size:64px;padding-left:5px;color:#0066FF;font-weight:bold;">
                                    <?php echo $result_p['balance_blue_points'];?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>
                </div>

                   <div class="col-md-6" >


                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                    Assigned Points
                                </div>
                                <?php

								 $arrs=mysql_query("select sum(sc_point) as assign_point from tbl_teacher_point where assigner_id='$parent_id' and sc_entities_id='106' " );
                                      $result=mysql_fetch_array($arrs);

                                ?>
                                <div class="row" style="font-size:64px;padding-left:5px;color:#0066FF;font-weight:bold;">

                                    <?php if($result['assign_point']==''){echo "0"; }else{ echo $result['assign_point'];}?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>-->
                      </div>
                    </div>
                  </div>
                  </div>


              <div class="container" style="padding:5px;" align="center">
                <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>

                   <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                     <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                     <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>


              </div>
             <!-- <div class="container" style="padding:5px;background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;" align="center">

              <div class="panel panel-danger" >
                    <div class="panel-heading">
                            <span  style="font-size:14px;font-weight:bold;">Green Points</span>
                        </div>



                     <div class="panel-body" >
                     <div class="col-md-6">
                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                Balance Points
                               </div>


                                <div class="row" style="font-size:64px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php echo $result_p['balance_points'];?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>
                     </div>

                   <div class="col-md-6" >


                               <div class="row" style="font-size:18px;padding-left:5px;font-weight:bold;color:#000000;">
                                    Assigned Points
                                </div>
                                <?php $arrs=mysql_query("select sum(sc_point) as assign_point from tbl_student_point where sc_teacher_id='$parent_id' and sc_entites_id=106 " );
                                      $result=mysql_fetch_array($arrs);
                                ?>
                                <div class="row" style="font-size:64px;padding-left:5px;color:#308C00;font-weight:bold;">

                                    <?php if($result['assign_point']!=0)
									{ echo $result['assign_point']; }
									else
									{
									echo "0";
									}?>
                                </div>
                                <div class="row" style="font-size:14px;color:#000000;padding-left:5px;">
                                    Points
                                </div>
                      </div>
                    </div>
                  </div>
              </div> -->
              </div>

    <div class="col-md-7">
           <div class="container" style="padding:20px;  background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;" align="center">
           			<div class="row" style="padding-bottom:5px;">
                        <div class="col-md-1 " style="background-color:#8D0FE9;" >
                        &nbsp;&nbsp;
                        </div>
                        <div  class="col-md-5">
                          Point Assigned by parent
                        </div>


                        <div style="background-color:#41D50A;" class="col-md-1">
                        &nbsp;&nbsp;
                        </div>
                        <div  class="col-md-5">

                          Point Assigned by Teacher
                        </div>

     				 </div>
                       <div class="row" style="font-size:14px;background-color:#9900CC;height:30px;color:#FFFFFF;font-weight:bold;padding-top:5px;">Child </div>
                       <div class="row">
         <?php

            //retive child information using parent id

           /*  $a=0;
			$b=0;
			$sql=mysql_query("SELECT school_id,`std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$parent_id'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$school_ids[$b]=$result['school_id'];
					$a++;$b++;
				}
				$id1s = join("','",$students);
				$schids = join("','",$school_ids); */

            ?>
            <?php
                     $sql=mysql_query("SELECT school_id,`std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$parent_id'");
					while($result=mysql_fetch_array($sql))
				    {
                        $std_prn=$result['std_PRN'];
						 $sch_id=$result['school_id'];
						 $result1=mysql_query("select std_img_path,std_complete_name,std_school_name from tbl_student where std_PRN='$std_prn' and school_id='$sch_id'");
						 //$rows1=mysql_fetch_array($result1);
						 while($rows1=mysql_fetch_array($result1))
                        {
                        ?>
                         <div  style="border:1 px solid #CCCCCC;">
                         <div class="row">
                         <div class="col-md-4" align="center">
                         &nbsp;&nbsp;</div>
                         </div>
                        	<div class="row">
                            <div class="col-md-1">
                            </div>

                             <!-- start div of image-->

                              <div class="col-md-2" >
                              <?php




							  if($rows1['std_img_path']!=""){?>
                                    <div><img src='<?php echo  $rows1['std_img_path'];   ?>' width="100%;"  height="70px;" alt=""/></div>
                                    <?php }
                                    else{ ?>
                                        <div><img src='image/avatar_2x.png' width="100%;" height="70px;" alt=""/></div>
                                        <?php }?>

                                        <!-- <div style="float:left;width:90px;font-weight:bold;padding-top:10px;" >
                                           <a href="parent_assignpoint.php?id=<?php echo $stud_id;?> "> <input type="button" value="assign" name="assign"/></a>
                                        </div>
                                           <div style="float:right;width:180px;"><?php  ?></div>
                                        </div>-->
                                 </div>
                                 <!-- End div of image-->
                                 <!-- start div of info-->
                                 <div class="col-md-9" >

                                        <div class="row">
                                            <div class="col-md-6" style="font-weight:bold;" align="left">Name</div>
                                            <div class="col-md-6" align="center"><?php echo  $rows1['std_complete_name']; ?></div>
                                         </div>
                                        <div class="row">
                                            <div class="col-md-6" style="font-weight:bold;" align="left">School Name</div>
                                            <div class="col-md-6" ><?php echo  $rows1['std_school_name'];   ?></div>
                                        </div>

                                         <?php
										 $sql1=mysql_query("SELECT `teacher_ID` FROM `tbl_student_subject_master` where `student_id` IN ('$std_prn') and `school_id` IN ('$sch_id') ");
											while($result1=mysql_fetch_array($sql1))
											{
												$teachers[$t]=$result1['teacher_ID'];
												$t++;

											}
											 $id1s = join("','",$teachers);



            								//retive student total point by student id
												$row1=mysql_query("select purple_points from tbl_student_reward where sc_stud_id='$std_prn' and school_id='$sch_id'");
												$result2=mysql_fetch_array($row1);
										   ?>
                                         <div class="row">
                                            <div class="col-md-6" style="font-weight:bold;" align="left">Total Purple Points</div>
                                            <div class="col-md-5" ><?php  $total_point= $result2['purple_points']; if($total_point==0){echo "0";} else { echo $total_point;}?></div>
                                         </div>
                                         <?php

                                                                //$row32=mysql_query("select sum(sc_point) as assign_point from tbl_student_point where sc_teacher_id='$parent_id' and sc_entites_id=106 and sc_stud_id='$std_prn' and school_id='$sch_id'");
																$row32=mysql_query("select sum(sc_point) as assign_point from tbl_student_point where `sc_teacher_id` IN ('$id1s') and sc_entites_id=103 and sc_stud_id='$std_prn' and school_id='$sch_id'");

                                                                $result32=mysql_fetch_array($row32);
                                                     ?>
                                         <div class="row">
                                            <div class="col-md-6" style="font-weight:bold;" align="left">Assigned Points by teacher</div>
                                            <div class="col-md-5" ><?php  $assign_point=$result32['assign_point'];echo $assign_point; if($assign_point==""){ echo "0";}?></div>
                                         </div> <!-- end div of info-->

                                          <div class="row" style="height:30px;">
                                            <div class="col-md-5" style="font-weight:bold;" style="padding-top:2px;" align="left"><br>
                                                   &nbsp;&nbsp;&nbsp;&nbsp; <a href="parent_assignpoint.php?id=<?php echo $std_prn;?>&sch_id=<?php echo $sch_id;?>"  style="text-decoration:none;align:center;">  <input  type="button" value="Assign" name="Assign"  class="form-control" style='width:50%; height:32px; background-color:#800080;color:#FFFFFF; border:1px solid #CCCCCC;text-align:center;'/></a>
                                             </div>


                                            <?php if($assign_point<=$total_point){
											               if($total_point!=0){
														           $len=((200*$assign_point)/$total_point);?>

                                               <div class="col-md-5"  style="padding-top:2px;">
                                                 <div id="center">
                                                                 <div id="main" style="width:<?php echo $len."px";?>;" ></div>
                                                  </div>
                                               </div>
																<?php  }}
											if($assign_point>$total_point)
											                   {
															    if($assign_point!=0){
																$len=((200*$total_point)/$assign_point);
																?>

                                               <div class="col-md-5"  style="padding-top:2px;">
                                                 <div id="center">
                                                                 <div id="main" style="width:<?php echo $len."px";?>;" ></div>
                                                  </div>
                                               </div>

                                                                <?php
															    }
												}
											?>





                                         </div>





                                  </div>

							</div>

						<?php

						}

						}?>


         </div>
         </div>
       </div><!--end of row-->


           </div><!--inner container-->
</div><!--outer container-->


</body>
</html>
