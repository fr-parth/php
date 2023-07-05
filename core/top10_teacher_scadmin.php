<?php
//Created by Rutuja Jori on 10/10/2019 for Adding functionality: Teacher Leaderboard
/*Updated by Rutuja for SMC-4805 on 02-09-2020*/
error_reporting(0);

include_once("scadmin_header.php");
$report="";
$subject_id=$_GET['id'];

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
$group_member_id=$result['group_member_id'];
$usertype= $_SESSION['usertype'];

?>
					 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

	 
 <form action="" method="POST" >
<div class="container" style="margin-left:75px;">
    <div class="col-md-1"></div>
  <div class="col-md-11 center centered">
<div class="panel panel-danger " style="margin-top:22px;">
  <div class="panel-heading text-center">
  
    <h3 class="panel-title"><font color="#580000"><b>List of Top 10 <?php echo $dynamic_teacher;?></b></font></h3>
  </div>
  <div class="panel-body" style="margin-top:10px;">
 
 <?php if ($school_type == 'school' && $user=='School Admin'){?>

  <div class="col-md-3">
<select name="schoolname"  id="schoolname" name="schoolname" class="form-control " style="width:85%; height:30px; border-radius:2px;margin-left:50px;margin-top:20px;margin-bottom:20px;">
   <?php $sql1=mysql_query("Select id,school_name,school_id from tbl_school_admin  where `school_name`!='' and school_id='$school_id' 
   group by school_name order by `school_name` ASC");?>
    <option value="<?php echo $school_id; ?>" disabled selected><?php echo $organization;?> Name</option>
	
	 <option value="all" selected <?php echo (isset($_POST['schoolname']) && $_POST['schoolname'] == 'all') ? 'selected="selected"' : ''; ?>>All <?php echo $dynamic_school;?></option>
	
	

	<?php while($row=mysql_fetch_array($sql1)){ ?>
	<option <?php if($row['school_id']==$school_id && $_POST['schoolname'] != 'all'){echo "selected";} ?> value="<?php echo $row['school_id']; ?>"><?php echo $row['school_name']; ?></option>
    <?php }?>
  </select>
</div>
  <?php } ?>


 


<div class="row">
 <div class="col-md-3">
<select name="duration" class="duration" id="duration" style=" height:30px; border-radius:2px;margin-left:50px;margin-top:20px;margin-bottom:20px;">
    <option id="time" value="" disabled selected>Select Duration</option>
	<!--<option value="allDuration">All</option>-->
	
	 <option value="1" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '1') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_teacher;?> of the Week</option>
	
	 <option value="2" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '2') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_teacher;?> of the Month</option>
	 
	  <option value="3" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '3') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_teacher;?> of the Year</option>
	  
	

  </select>
</div>
<!--Department filter added by Rutuja for SMC-5112 on 21-01-2021-->
 <div class="col-md-3">
<select name="department"  id="department" class="form-control " style="width:85%; height:30px; border-radius:2px;margin-left:50px;margin-top:20px;margin-bottom:20px;">

   <?php $sql1=mysql_query("Select Dept_Name,ExtDeptId,Dept_code,id from tbl_department_master  where school_id='$school_id' and Dept_Name!='' group by Dept_Name order by `Dept_Name` ASC");?>
    
	 <option value="allDept" selected <?php echo (isset($_POST['department']) && $_POST['department'] == 'allDept') ? 'selected="selected"' : ''; ?>>All Departments</option>
	
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	<option <?php echo (isset($_POST['department']) && $_POST['department'] == $row['Dept_Name']) ? 'selected="selected"' : ''; ?> value="<?php echo $row['Dept_Name'];?>"><?php echo $row['Dept_Name'];?></option>
    <?php }?>
  </select>
</div>


  <div class="col-md-3">
<select name="point_type" class="point_type" id="point_type" <?php if($usertype=="School Admin" || $usertype== "School Admin Staff"){ ?> style="width:80%; height:30px; border-radius:2px;margin-left:790px;margin-top:-50px;margin-bottom:20px;" <?php }else{ ?>style=" height:30px; border-radius:2px;margin-left:43px;margin-top: 21px;"<?php } ?> >
   <option id="point" value="" disabled selected>Points Given By</option>
   
    <option value="allPoint" <?php echo (isset($_POST['point_type']) && $_POST['point_type'] == 'allPoint') ? 'selected="selected"' : ''; ?>>All</option>
	
	 <option value="stud" <?php echo (isset($_POST['point_type']) && $_POST['point_type'] == 'stud') ? 'selected="selected"' : ''; ?>>By <?php echo $dynamic_student;?></option>
	 
	  <option value="teacher" <?php echo (isset($_POST['point_type']) && $_POST['point_type'] == 'teacher') ? 'selected="selected"' : ''; ?>>By <?php echo $dynamic_teacher;?></option>
	  
	   <option value="school" <?php echo (isset($_POST['point_type']) && $_POST['point_type'] == 'school') ? 'selected="selected"' : ''; ?>>By <?php echo $organization;?> Admin</option>
	   
	</select>
	</div>
	
	<div class="col-md-3" <?php if($usertype=="School Admin" || $usertype== "School Admin Staff"){ ?> style="margin-left: 150px" <?php }else{ ?> style="margin-left: 245px;margin-top: -30px" <?php } ?> > 			 
 <input type="submit" name="submit" value="Submit" class="btn btn-success" />&nbsp;&nbsp;&nbsp;
					
			 
	<a href="csv_export_teacher.php?schoolname=<?= $_POST['schoolname'];?>&duration=<?= $_POST['duration'];?>&point_type=<?= $_POST['point_type'];?>&department=<?= $_POST['department'];?>" class="btn btn-success" >Export to CSV</a> 		</div>		   
</div>	
  

</div>
		
</form>

</div>
</div>
</div>
</div>
</html>

 <?php 
 if(isset($_POST['submit']))
	 
	 {
			 $school_id1=$_POST['schoolname'];
			 $duration=$_POST['duration'];
			 $point_type=$_POST['point_type'];
			 $department=$_POST['department'];
					$where="";
					$time_duration="";
					$point1="";
					
					if($school_id1!='all')
					{
						$where .="  t.school_id='$school_id'";
					}
					else
					{
						$where .= "  t.group_member_id='$group_member_id'";
					}
					
						
					if($duration==1)
					{
						$time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
					}
					else if($duration==2)
					{
						$time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
					}
					else
					{
						$time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
					}
					
					/*Below conditions added by Rutuja for SMC-4806 on 05-09-2020*/
					if($point_type=='school')
					{
						$point1 .= " and tp.sc_entities_id='102'";
						$type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
						
					}						
					else if($point_type=='stud')
					{
						$point1 .= " and tp.sc_entities_id='105'";
						$type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
					}
					
					/*else if($point_type=='teacher')
					{
						$point1 .= " and tp.sc_entities_id='103'";
						$type_point .= " and (point_type='Waterpoint' or point_type='Water Points') ";
					}*/
					
					else
					{
						$point1 .= " and (tp.sc_entities_id='102' or  tp.sc_entities_id='105' or tp.sc_entities_id='103') ";
						$type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
					}
					if($department!='')
					{
						if($department=="allDept"){
						$where .= "";	
					}else{
						$where .=" and t.t_dept='$department'";
					}
					}
					
					
					$sqlforall="Select t.t_dept,t.school_id,t.t_id,t.t_pc,ucwords(t.t_complete_name) as name,t.t_current_school_name,SUM(tp.sc_point) as Assigned_Points from 
					tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id where $where $type_point ";
					
			
					
					$groupby= " group by tp.sc_teacher_id order by Assigned_Points desc limit 10";
			
					//echo $sqlforall . $time_duration . $point1 . $groupby;exit;
					$sql=mysql_query( $sqlforall . $time_duration . $point1 . $groupby);
			
					
					$count=mysql_num_rows($sql);
			
				if($count >= 1)
				{
					 ?>	
					  <div class='container' style="margin-left:122px;">
							
								
								<div class="" align="center"> 
								<table class="table table-condensed table-responsive" style="width:1010">
								
								<thead align="center">
									<tr class="danger" >
                                    <th align="center">Sr.No</th>
                                    <th align="center"><?php echo xecho($dynamic_teacher);?> Image</th>
                                    <th align="center"><?php echo xecho($dynamic_teacher);?> Name</th>
									
									<?php if ($school_type == 'school' && $user=='School Admin'){?>
                                    <th align="center"><?php echo xecho($dynamic_teacher." ".$organization."");?>    Name</th>
									<?php } ?>
									<!---Department column added by Rutuja for SMC-5112 on 20-01-2021-->
									<th align="center">Department</th>
									
                                    <th align="center">Points</th>
										
									</tr>
								</thead>
								<?php $i=0;
								 while($row=mysql_fetch_array($sql)){
								 	 $specific_school=$row['t_current_school_name'];
									 
									 $specific_school_id=$row['school_id'];
									 
									
									 $sql_for_school=mysql_query("select school_name,school_id from tbl_school_admin where school_id='$specific_school_id'");
									 
								$i++;?>
								
								<tbody>
									<tr class="success">
									<td ><?php echo xecho($i);?></td>
									<td> <?php if($row['t_pc'] != ''){
										$img="/teacher_images";
										?>
										<img src="<?php echo $img . "/" . xecho($row['t_pc']);?>"  style=" width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);" alt="Responsive image" /> <?php }else {?> <img src="Images/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);"  alt="Responsive image"/> <?php }?></td>
										<td><?php echo xecho($row['name']);?></td>
										
										<?php if ($school_type == 'school' && $user=='School Admin'){?>
										
										<?php
					
										while($row2=mysql_fetch_array($sql_for_school)){?>
										
										<td><?php echo xecho($row2['school_name']);?></td>
										<?php } }?>

										<td><?php echo xecho($row['t_dept']);?></td>
										
										<td><?php echo xecho($row['Assigned_Points']);?></td>
										
									</tr>
								</tbody>
								
								
					
							<?php }}else{
	 
						echo '<script language="javascript">';
						echo 'alert("Record not found!!!")';
						echo '</script>';
						exit;
	 
								}} ?>
	 
               		</table>
					</div>
				
				
				</div>

</body>
</html>

