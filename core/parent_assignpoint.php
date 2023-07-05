<?php
	include_once('Parent_header.php');
 $report="";
 $parent_id=$_SESSION['id'];
 $stud_id=$_GET['id'];
  $sch_id=$_GET['sch_id'];
 $rows=mysql_query("select * from tbl_student where std_PRN='$stud_id' and school_id='$sch_id'");
 $results=mysql_fetch_array($rows);
$school_id=$results['school_id'];
$currentdate=date("d/m/Y");

if(isset($_POST['assign']))
	{
		if(isset($_POST['activity']) )
		{
			//echo $activity = $_POSt['activity'];
			
			  $point=$_POST['point'];
			  if($point!=0)
			  {
				 $activity_id1=$_POST['activity'];
				 $a=explode(",",$activity_id1);
				
				$activity_id=$a[0];
				$sc_id=$a[1];
				$type=$a[2];
				$issue_date=date('d/m/Y');
			 
				  $arrs=mysql_query("select balance_points from tbl_parent where Id='$parent_id' ");
				  $result=mysql_fetch_array($arrs);
				  $p_balance_point=$result['balance_points'];
				  if($p_balance_point>=$point)
				  {
					 if($type=='subject')
					 {	 
					 echo "insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,activity_type,school_id) values('$stud_id',106,'$parent_id','$activity_id','$point','$issue_date','subject','$sch_id')";
						mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,activity_type,school_id) values('$stud_id',106,'$parent_id','$activity_id','$point','$issue_date','subject','$sch_id')");
						
					 }else
					 {
						/* mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,school_id,activity_type,school_id) values('$stud_id',106,'$parent_id','$activity_id','$point','$issue_date','$sc_id','activity','$sch_id')");*/
		 mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,activity_type,school_id) values('$stud_id',106,'$parent_id','$activity_id','$point','$issue_date','activity','$sch_id')");		
		
					
					 }
							  $row1=mysql_query("select purple_points from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$sch_id'");
							$result1=mysql_fetch_array($row1);
							$total_point=$point+$result1['purple_points'];
							$result2= mysql_query("select id from  tbl_student_reward  where sc_stud_id='$stud_id' and school_id='$sch_id'");
							 if(mysql_num_rows($result2)==1)
							 {
							 
							  mysql_query("update tbl_student_reward set purple_points='$total_point' where sc_stud_id='$stud_id' and school_id='$sch_id'");
							 
							  }
							  else
							  {
							   mysql_query("insert into tbl_student_reward (sc_assigned_by,purple_points,sc_stud_id,sc_date,school_id) values('$parent_id',
							   '$total_point','$stud_id','$currentdate','$sch_id') ");
							  
							  }
							 $p_balance_point=$p_balance_point-$point;
							 
							 $D_purple=mysql_query("select distributed_purple from tbl_parent where Id='$parent_id'");
							  $result11=mysql_fetch_array($D_purple);
							 $total_distribute_purple=$point+$result11['distributed_purple'];
							
							   mysql_query("update tbl_parent set balance_points='$p_balance_point',distributed_purple='$total_distribute_purple' where Id='$parent_id'");
							   
							   $report="$point Points are assigned successfully..";
				   }
				   else
				   {
				   $report1="You have insufficient Balance Point ";
				   }
			  }else{$report1="Sorry Points must be greater than 0.. ";}  
			}
			else
			{
				$report1="Please select Activity ";
			 }			  
	  
	}
 
?>
<html>
<head>
<script type="text/javascript">
        function validate()
      {
            //regx1=/^[A-z ]+$/;
			regx2=/^[0-9]+$/;
			 if( document.myForm.point.value == "" )
            {
				alert( "Please Enter Points!" );
				document.myForm.point.focus() ;
				return false;
			}else if(!regx2.test(document.myForm.point.value))
			{
				alert( 'Please enter valid Points.');
					return false;
			}
		   else
			{
				
			}
	  }
</script>	  
<script>
function valid()
{
  var point=document.getElementById("point").value;
  if(point=="")
  {
  document.getElementById('error').innerHTML='Enter Point';
  return false;
  }
   
 
}
</script>

<style>


</style>
</head>
<body>

<div class="container">

<div class="row" style="padding-top:50px;">

<div class="col-md-4" >

<div class="row" style="padding-top:20px;background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">

<div class="col-md-3">
  <?php if($rows['std_img_path']==""){ ?>
                                                <img src='image/avatar_2x.png'  height="75px;" />
                                                <?php }else{?>
                                            <img src='<?php echo  $results['std_img_path'];   ?>'  height="75px;" />
                                            <?php }?>


</div>


<div class="col-md-9">


   <div class="row">
                                                    <div class="col-md-4" style="font-weight:bold;" align="left">Name</div>
                                                   <div class="col-md-12" align="left" style="padding-left: 28px;">
														
													<font size="2"><?php echo  $results['std_complete_name']; ?></font></div>
                                                 </div>
                                                <div class="row">
                                                    <div class="col-md-4" style="font-weight:bold;" align="left">School Name</div>
                                                    <div class="col-md-12" align="left">
                                                       <font size="2"> <?php echo  $results['std_school_name'];   ?></font>
                                                    </div>																	                                       			 </div>
                                                  <?php 
                                                    //retive student total point by student id
                                                        $row1=mysql_query("select purple_points from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$sch_id'");
                                                        $result12=mysql_fetch_array($row1);
                                                   ?>
                                                   <div class="row">
                                                    <div class="col-md-8" style="font-weight:bold;" align="left">Purple Balance Points </div>
                                                    <div class="col-md-2" align="left"><?php if($result12['purple_points']==""){echo "0";}else{?><font color="#800080" size="5"><?php echo $result12['purple_points'];} ?></font></div>
                                                 </div>
                                                 <div >

<div class="row" style="height:50px;"></div>
</div>

</div>



</div>

<div style="padding-top:50px;">

<div class="row" style="padding-top:20px;background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">


                        			  <?php
                                                   
                                                            $row3=mysql_query("select balance_points,distributed_purple from tbl_parent where Id='$parent_id' "); 
                                                            $result3=mysql_fetch_array($row3);
                                                 ?>
                                                 
                                                     <div class="col-md-6" >
                                                        <div style="font-weight:bold;font-size:14px;" >
                                                        	Parent Balance Points 
                                                        </div>
                                                        <div style="font-size:64px;color:#40a4df;font-weight:bold;" >
															<?php if( $result3['balance_points']==""){echo "0";}else{ echo $result3['balance_points'];} ?>
                                                        </div>
                                                         
                                                       
                                                     </div>
                                                       <?php
                                                       
                                                               /*  $row2=mysql_query("select sum(sc_point) as assign_point from tbl_student_point where sc_teacher_id='$parent_id' and sc_entites_id=106"); 
                                                                $result2=mysql_fetch_array($row2) */;
                                                     ?>
                                                     <div  class="col-md-6" >
                                                        <div style="font-weight:bold;font-size:14px;" >
                                                        	Parent Assigned Points 
                                                        </div>
                                                        <div style="font-size:64px;color:#40a4df;font-weight:bold;" >
															<?php if($result3['distributed_purple']==""){echo "0";}else{echo $result3['distributed_purple'];}?>
                                                        </div>
                                                     </div>
                                                     </div>
                                                     </div>
                                                     

<div class="row" style="height:50px;"></div>
</div>






<div class="col-md-1"></div>


 <div class="col-md-7" style="background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #C3C3C4;" >

    <form method="post" name="myForm" onSubmit="return(validate());">
     <h1 style="color:#003366;font-family:Comic sans MS" align="center">Assign Points</h1>
     <div class="row" style="padding-top:10px;">
                                   <h3 align="center" style="color:black; font-family: 'Lato', sans-serif; font-size:20px; font-weight: 300; line-height: 58px; margin: 0 0 58px;"><b> Activity List </b></h3>
                                   </div>
                                    <div class="row" >
                                    <div class="col-md-4"  style="padding-top:20px;padding-left:12px;" >
                                    <h4> Study</h4>
                                    
                                     <?php
									 
								//$query1 = mysql_query("select distinct subject,id from tbl_subject where school_id='$school_id' and teacher_id=0");
								//while($row = mysql_fetch_array($query1))
								//{
								//$sql1=mysql_query("Select std_PRN from tbl_student where parent_id='$id'");
						   
								//while($result=mysql_fetch_array($sql1))
								//{ 	
									
										?>
										<!--<select name="limit3" class="dropdownMenu3" id="dropdownMenu3" style="width:80%; height:30px; border-radius:2px;margin-left:0px;margin-top:20px;margin-bottom:20px;">-->
			
		 
										<?php 
						   
										//$std_prn=$result['std_PRN'];   
										$sql2=mysql_query("SELECT id,school_id,`subjectName` FROM `tbl_student_subject_master` WHERE `student_id`='$stud_id' and school_id='$sch_id'" );
								        $result1=mysql_fetch_array($sql2);
										$scid=$result1['school_id'];?>
									<!--<option value="" disabled selected>Subjects Name</option>-->
									
							
									<?php while($row=mysql_fetch_array($sql2)){ ?>
									<!--<option value="<?php //echo $row['id'];?>,<?php //echo $scid; ?>"><?php //echo $row['subjectName'];?></option>-->
									
									</select>
									<input type="radio" value="<?php echo $row['id'];?>,<?php echo $row['school_id'];?>,<?php echo "subject";?>" name="activity" id="<?php echo $row['subjectName'];?>" /> <font size="2">&nbsp;<?php echo $row['subjectName'];?></font><br/>
									<?php 
							
							 }
							 	//}
							 ?>
                                     
                                     
                                     
                                     </div>
                                     
                                     
                                      <div class="col-md-3"  style="padding-top:20px;padding-left:5px;" >
                                    <h4 align="left">Art</h4>
                                    
                                     <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id='$sch_id' AND a.activity_type = 'Art' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity" id="activity" ><font size="2">&nbsp; <?php echo $row['sc_list'];?></font><br/>
                             <?php
							 	}
							 ?>
                                     
                                     
                                     
                                     </div>
                                     
                                     
                                           <div class="col-md-2"  style="padding-top:20px;padding-left:5px;" >
                                    <h4 align="left"> Sports</h4>
                                    
                                     <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND  a.activity_type = 'Sports' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio" value="<?php echo $row['sc_list'];?>" name="activity" id="activity" /><font size="2">&nbsp;<?php echo $row['sc_list'];?></font><br/>
                             <?php
							 	}
							 ?>
                                     
                                     
                                     
                                     </div>
                                     
                                     
                                       <div class="col-md-3"  style="padding-top:20px;padding-left:5px;" >
                                    <h4 align="left"> General</h4>
                                    
                                     <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a  WHERE sp.school_id='$school_id' AND a.activity_type='General Activity' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio" value="<?php echo $row['sc_list'];?>" name="activity" id="activity" /><font size="2">&nbsp;<?php echo $row['sc_list'];?></font><br/>
                             <?php
							 	}
							 ?>
                                     
                                     
                                     
                                     </div>
                                     </div>
                                 <div class="row" style="padding-top:50px;">
                  <div class="col-md-5 col-md-offset-1" ><B>Points Assign to Student</B></div>
                  <div class="col-md-4"><input type="text" name="point" class="form-control" id="point" placeholder="Enter Point"> </div></div>
                  
                  <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                  <div class="col-md-2"><input type="submit" class="btn btn-primary"name="assign" value="Assign" /></div>
                  
                  <div class="col-md-2"><a href="purchase_point.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" /></a> </div>
                  </div>
                  
                                   
                    </form>            
                             
    
<div id="error" style="color:#007f00;font-weight:bold; padding-top:10px;" align="center">
 <?php echo $report;?>
</div>
<div id="error" style="color:#FF0000;font-weight:bold; padding-top:10px;" align="center">
 <?php echo $report1;?>
</div>
<div >&nbsp;&nbsp;
</div>
</div>
</div> 















</div>
</div>
</body>


</html>


