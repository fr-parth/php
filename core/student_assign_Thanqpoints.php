<?php
 include_once('stud_header.php');
 $id=$_SESSION['id'];
		
		$query=mysql_query("select balance_bluestud_points,school_id,std_PRN from tbl_student where id='$id' ");
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
		
		
		
		
		
		$sql=mysql_query("select thanqu_flag from tbl_school_admin where school_id='$school_id'");
$results=mysql_fetch_array($sql);
$thanqu_flag=$results['thanqu_flag'];
$st="St";
$pos=strpos($thanqu_flag,$st);

     
 
 
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

window.location = "teacherthanqpoints.php?t_id="+t_id;
}
 
 }
 
</script>

 
<body style="background-color:#FFFFFF">
<?php 
if($pos !== false)
{?>
 <div class="container" style="padding-top:20px;">
 <div class="col-md-3">
 <div class="panel panel-info">
 <div class="panel-heading"><h3 style="color:#000000;"><center style="
    font-family: &quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;
">My Blue Points</center></h3></div>
  <div class="panel-body" style="color:#0066FF;font-weight:bold;font-size:40px;">
 <center> <?php echo $result['balance_bluestud_points'];?></center>
  </div>
  
</div>
</div>



<div class="col-md-9">
 <div class="panel panel-default">
 <div style="padding-top:20px;">
 
  <form method="post">
            
            
            <div class="row" style="padding-left:50px;">
           
            <div class="col-md-4">
            <input type="text" name="teacher_name" placeholder="Enter Teacher Name" class="form-control" value="<?php if(isset($_POST['teacher_name'])){echo $_POST['teacher_name'];}?>"></input>
            </div>
            <div class="col-md-3">
            <input type="submit" class="btn btn-primary" name="submit" value="Search">
         </div>
           
                 <div class="col-md-3 "> <a   href = "bluepointlog.php?id=<?php echo $id;?>"   >    <input type="button" value="My assigned points" class="btn btn-default"></input></a></div></form></div>
           <div style="height:20px;"></div> 
            </div>
            </div>
            
            
   
   <?php 
   if(isset($_POST['submit']))
	{
		$name=$_POST['teacher_name'];
		
	
		$sql=mysql_query(  "select distinct t.t_id,t.t_name,t.t_complete_name,t.t_lastname,t.t_pc,t.t_email,t.t_phone from tbl_teacher t join tbl_student_subject_master sm  on sm.teacher_id=t.t_id JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
WHERE  (t.t_name like'%$name%' or t.t_complete_name='%$name') and  sm.student_id = '$std_PRN' AND sm.school_id = '$school_id' AND a.Enable = '1' AND a.school_id = '$school_id'");
			?>
            <div style="padding-top:20px;">
          <table id="example" class="display table table-striped table-hover dt-responsive" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                           <th>Profile Picture</th>
                        <th>Teacher Name</th>
                        <th>Email ID</th>
                        <th>Phone No</th>
                       <th>Assign</th>
                      
                       
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
                            <td> <a class="txt-button" ><input type="button" value="Assign" onClick="openwindow(<?php echo $result['t_id'];?>);" class="btn btn-primary"></a></td>
                           
                            
                           
                        
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
                       
                        <th>Phone No</th>
                       <th>Assign</th>
                      
                       
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
							
							 echo $test['t_name']." ".$test['t_lastname'];
                            }
                            
                            else
							{
							echo $test['t_complete_name'];
							}?>
                            
                            </td>
                            
     					
                            <td  style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?php echo $test['t_phone'];?>
     
							</td>
                            <td> <a class="txt-button" ><input type="button" value="Assign" onClick="openwindow(<?php echo $test['t_id'];?>);" class="btn btn-primary"></a></td>
                           
                            
                           
                        
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
 
 
 <?php }else
 {?>
 
 <div class="container" style="padding-top:150px;">
 <div class="row">
 <div class="col-md-3"></div>
 
 <div class="col-md-6"  style=" border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#FFFFFF;color:#FF0000; font-weight:bold;" align="center" >
  <div style="height:20px;"></div>
 <?php echo "You do not have permission to assign Blue Points !...  "?>
 <div style="height:20px;"></div>
 </div>
 
 
 
 
 </div>
 
 </div>
 
  <?php }
 ?>

 </body>
 