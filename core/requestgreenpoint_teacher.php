<?php
 include_once('stud_header.php');
 $id=$_SESSION['id'];
		
		$query=mysql_query("select school_id,std_PRN from tbl_student where id='$id' ");
		$result=mysql_fetch_array($query);
		$school_id=$result['school_id'];
		$std_PRN=$result['std_PRN'];
		
		
		
		
		
		$sql=mysql_query("select s.SemesterName,s.DeptName,s.BranchName,s.CourseLevel,s.AcdemicYear from StudentSemesterRecord s join tbl_academic_Year y on y.Year=s.AcdemicYear and y.Enable='1'  where s.student_id='$std_PRN' and s.IsCurrentSemester='1'");
		$test=mysql_fetch_array($sql);
		$SemesterName=$test['SemesterName'];
		$DeptName=$test['DeptName'];
		$BranchName=$test['BranchName'];
		$CourseLevel=$test['CourseLevel'];
		$academic_year=$test['AcdemicYear'];
		
		
		


     
 
 
 ?>

 <script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>


  <script>
 function openwindow(t_id)
 {

if(t_id!="")
{

window.location = "teacherrewardrequest.php?t_id="+t_id;
}
 
 }
 
</script>
<style>
.preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}
</style>

 
<body style="background-color:#FFFFFF">

 <div class="container" style="padding-top:20px;">
 <div class="col-sm-3" style="padding:20px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
         <div  style="height:50px; background-color:#0073BD; border:1px solid #0073BD;color:#FFFFFF" align="left">
        		<div style="float:left;"><h4 style="padding-left:20px; margin-top:10px; color:#FFFFFF;font-size:23px;"> My Rewards</h4></div>
          </div> 
           <div align="center" style="padding-top:20px;font-size:40px;color: #308C00;
font-weight: bold;
line-height: 1.1;"><?php

$st_points=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='$std_PRN'");
		$resultset=mysql_fetch_array($st_points);
 if($resultset['sc_total_point']=="")
{
echo "0";
}
else
{
echo $resultset['sc_total_point'];
}


 ?> </div>  
              <div align="center" style="color:#0073BD;font-size:20px;">Points</div>    
       	    </div>



<div class="col-md-9">
 <div class="panel panel-default">
 <div style="padding-top:20px;">
 
  <form method="post">
            
            
            <div class="row" style="padding-left:50px;">
           
            <div class="col-md-4">
            <input type="text" name="teacher_name" id="teacher_name" placeholder="Enter Teacher Name" class="form-control" value="<?php if(isset($_POST['teacher_name'])){echo $_POST['teacher_name'];}?>"></input>
            </div>
            <div class="col-md-3">
            <input type="submit" class="btn btn-primary" name="submit" value="Search" >
         </div>
           
                 <div class="col-md-3 "><a href="my_rewardrequestlog.php" style="text-decoration:none;"><input type="button" name="My Previous Request"  value="My Previous Requests" class="btn btn-default"> </a></div></form></div>
           <div style="height:20px;"></div> 
            </div>
            </div>
            
            
   
   <?php 
   if(isset($_POST['submit']))
	{
		$name=$_POST['teacher_name'];
	
	
		$sql=mysql_query( "select distinct t.t_id,t.t_name,t.t_complete_name,t.t_lastname,t.t_pc,t.t_email,t.t_phone,sm.subjectName from tbl_teacher t join tbl_student_subject_master sm  on sm.teacher_id=t.t_id JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
WHERE  (t.t_name like'%$name%' or t.t_complete_name='%$name') and  sm.student_id = '$std_PRN' AND sm.school_id = '$school_id' AND a.Enable = '1' AND a.school_id = '$school_id'");
			?>
            <div style="padding-top:20px;">
          <table id="example" class="display table table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                           <th>Profile Picture</th>
                        <th>Teacher Name</th>
                        <th>Subject Name</th>
                        <th>Phone No</th>
                       <th>Request</th>
                      
                       
                    </tr>
                </thead>
                <?php 
	
	$i=1;
	 while($result=mysql_fetch_array($sql))
	 { 
	 
	 ?>
	 <tr> <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $i;?>
     
     
							</td>
                             <td><?php if($result['t_pc'] != ''){?>
                <img src="<?php echo $result['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?>
                            </td>
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php
							if($result['t_complete_name']=="")
							{
							
							 echo $result['t_name']." ".$result['t_lastname'];
                            }
                            
                            else
							{
							echo $result['t_complete_name'];
							}?>
                            
                            </td>
                            
                           
     						<td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $result['t_email'];?>
     
							</td>
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $result['t_phone'];?>
     
							</td>
                            <td> <a class="txt-button" ><input type="button" value="Request" onClick="openwindow(<?php echo $result['t_id'];?>);" class="btn btn-success"></a></td>
                           
                            
                           
                        
                            </tr>
     
	 
	 <?php $i++; }
	 
	 
	 }
	 else
	 {
	 

	 $sql=mysql_query( "SELECT  subjectName,teacher_id  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
WHERE student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND a.school_id = '$school_id' order by subjectName ");
			?>
            <div style="padding-top:20px;">
          <table id="example" class="display table table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Profile Picture</th>
                        <th>Teacher Name</th>
                        <th>Subject Name</th>
                        <th>Phone No</th>
                       <th>Request</th>
                      
                       
                    </tr>
                </thead>
                <?php 
	
	$i=1;
	 while($result=mysql_fetch_array($sql))
	 { 
	 
	 
	  $teacher_id= $result['teacher_id'];

$query=mysql_query("select t_pc,t_name,t_middlename,t_lastname,t_complete_name,t_email,t_phone,t_id from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");

$test=mysql_fetch_array($query);
	 ?>
	 <tr> <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $i;?>
     
     
							</td>
                            
                            <td><?php if($test['t_pc'] != ''){?>
                <img src="<?php echo $test['t_pc'];?>" class="preview" style=" width:70px;height:70px;" alt="Responsive image" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;" class="preview" alt="Responsive image"/> <?php }?>
                            </td>
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php
							if($test['t_complete_name']=="")
							{
							
							 echo  ucwords(strtolower($test['t_name']." ".$test['t_lastname']));
                            }
                            
                            else
							{
							echo ucwords(strtolower($test['t_complete_name']));
							}?>
                            
                            </td>
                            
                           
     						<td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $result['subjectName'];?>
     
							</td>
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $test['t_phone'];?>
     
							</td>
                            <td> <a class="txt-button" ><input type="button" value="Request" onClick="openwindow(<?php echo $test['t_id'];?>);" class="btn btn-success"></a></td>
                           
                            
                           
                        
                            </tr>
     
	 
	 <?php $i++; }
	 
	 
	 
	 
	 
	 }
            
            
            ?>
            </table>  
            </div>
	
   
   
   
</div>
  </div>
</div>
</div>

 
 </div>
 
 
 

 </body>
 