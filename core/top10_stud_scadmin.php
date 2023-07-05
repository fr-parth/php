<?php
//Created by Rutuja Jori on 10/10/2019 for Adding functionality: Student Leaderboard
//Updated by Rutuja Jori on 11/12/2019 for SMC-4243 & SMC-4242 as Activity List was not same as displayed in HR Admin on Leaderboard & records were not getting displayed for top 10 Employee.
/*Updated by Rutuja for SMC-4805 on 02-09-2020*/
error_reporting(0); 

include_once("scadmin_header.php");
$report="";
//$subject_id=$_GET['id'];

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
$group_member_id=$result['group_member_id'];
$usertype= $_SESSION['usertype'];
?>


<script>
 $(document).ready(function() 
 {  
	 $("#schoolname").on('change',function(){ 	 
		 var sch = document.getElementById("schoolname").value;

		 $.ajax({
			 type:"POST",
			 data:{sch:sch}, 
			 url:'subject_top10_student.php',
			 success:function(data)
			 {
			     //alert(data);
				 
				 $('#subject_id').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
</script>
<script>
 $(document).ready(function() 
 {  
	 $("#schoolname").on('change',function(){ 	 
		 var sch = document.getElementById("schoolname").value;

		 $.ajax({
			 type:"POST",
			 data:{sch:sch}, 
			 url:'activity_top10_student.php',
			 success:function(data)
			 {
			     //alert(data);
				 
				 $('#activity_id').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
</script>

<script>

function display_top10_students_subject_wise()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;

        t=1;
	    sub_id =document.getElementById("subject_id").value;
	  // var sch_id =document.getElementById("school_id").value;

 		//alert(sub_id);
		if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
      

}

function display_top10_students_activity_wise()
{
		 // document.getElementById('error').innerHTML='';
		//var method_name=document.getElementById("method_name").value;

        t=2;
	    activity_id =document.getElementById("activity_id").value;
 		//alert(activity_id);
		if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {

         document.getElementById("top10_students").innerHTML  =xmlhttp.responseText;
            }
          }
       

}

function subjectChange()
{
    $('#activity_id').get(0).selectedIndex = 0;
    display_top10_students_subject_wise() ;
}

function ActivityChange()
{
    $('#subject_id').get(0).selectedIndex = 0;
    display_top10_students_activity_wise();
}

</script>
<style rel="stylesheet" type="text/css">
.n{
  margin-top: 20px;
  }

</style>

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
  
    <h3 class="panel-title"><font color="#580000"><b>List of Top 10 <?php echo $dynamic_student;?></b></font></h3>
  </div>
  <div class="panel-body" style="margin-top:10px;">
 
 <?php if ($school_type == 'school' && $user=='School Admin'){?>

  <div class="col-md-3">

<select name="schoolname"  id="schoolname" name="schoolname" class="form-control " style="width:85%; height:30px; border-radius:2px;margin-left:10px;margin-top:20px;margin-bottom:20px;">
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
<select name="duration" class="duration" id="duration" style=" height:30px; border-radius:2px;margin-left:10px;margin-top:20px;margin-bottom:20px;">
    <option id="time" value="" disabled selected>Select Duration</option>
	<!--<option value="allDuration">All</option>-->
	
	 <option value="1" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '1') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_student;?> of the Week</option>
	
	 <option value="2" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '2') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_student;?> of the Month</option>
	 
	  <option value="3" <?php echo (isset($_POST['duration']) && $_POST['duration'] == '3') ? 'selected="selected"' : ''; ?>>Top 10 <?php echo $dynamic_student;?> of the Year</option>
	  
	

  </select>
</div>


    <div class="n" >
  <div class="col-md-3">
<select name="subject_id" class="form-control" id="subject_id" style="width:80%; height:30px; border-radius:2px;margin-left:0px;margin-top:0px;margin-bottom:20px;" onChange="subjectChange()">
    <option  value="" disabled selected><?php echo $dynamic_subject;?> Name</option>
	<?php $sql2=mysql_query("Select distinct(subject),id from tbl_school_subject where school_id='$school_id'" );?>
	<?php //if ($school_type == 'organization' && $user=='HR Admin'){?>
<?php while($row=mysql_fetch_array($sql2)){ ?>
	
<option <?php echo (isset($_POST['subject_id']) && $_POST['subject_id'] == $row['id']) ? 'selected="selected"' : ''; ?> value="<?php echo $row['id'];?>"><?php echo $row['subject'];?></option>

    <?php }?>

<?php //}?>
	
	</select>
	</div>
	 <div class="row">
  <div class="col-md-3">
<select name="activity_id" class="form-control" id="activity_id" style="width:80%; height:30px; border-radius:2px;margin-left:0px;margin-top:0px;margin-bottom:20px;" onChange="ActivityChange()" >
	 <option  value="" disabled selected>Activities Name</option>
	<?php $sql3=mysql_query("Select distinct(sc_list),sc_id from tbl_studentpointslist where school_id='$school_id' group by sc_list order by sc_list" );?>
	<?php// if ($school_type == 'organization' && $user=='HR Admin'){?>
	<?php while($row=mysql_fetch_array($sql3)){ ?>
		<?php echo (isset($_POST['duration']) && $_POST['duration'] == '1') ? 'selected="selected"' : ''; ?>

	<option <?php echo (isset($_POST['activity_id']) && $_POST['activity_id'] == $row['sc_id']) ? 'selected="selected"' : ''; ?> value="<?php echo $row['sc_id'];?>"><?php echo $row['sc_list'];?></option>
    <?php } //}?>
  </select>
</div>
  </div>
</div>
	
<!--Department filter added by Rutuja for SMC-5112 on 21-01-2021-->
 <div class="col-md-3">
<select name="department"  id="department" class="form-control " <?php if($usertype=="School Admin" || $usertype== "School Admin Staff"){ ?> style="width:85%; height:30px; border-radius:2px;margin-left:22;margin-top:1px;margin-bottom:20px;" <?php }else{ ?> style="width:85%; height:30px; border-radius:2px;margin-left:733px;margin-top:-49px;margin-bottom:20px;" <?php } ?>>

   <?php $sql1=mysql_query("Select Dept_Name,ExtDeptId,Dept_code,id from tbl_department_master  where school_id='$school_id' and Dept_Name!='' group by Dept_Name order by `Dept_Name` ASC");?>
    
	 <option value="allDept" selected <?php echo (isset($_POST['department']) && $_POST['department'] == 'allDept') ? 'selected="selected"' : ''; ?>>All Departments</option>
	
	<?php while($row=mysql_fetch_array($sql1)){ ?>
	<option <?php echo (isset($_POST['department']) && $_POST['department'] == $row['Dept_Name']) ? 'selected="selected"' : ''; ?> value="<?php echo $row['Dept_Name'];?>"><?php echo $row['Dept_Name'];?></option>
	 
    <?php }?>
  </select>
</div>	

<div class="col-md-3" <?php if($usertype=="School Admin" || $usertype== "School Admin Staff"){ ?> style="margin-left: 150px" <?php }else{ ?> style="margin-left: 150px;margin-top: -1px" <?php } ?> >				 
 <input type="submit" name="submit" value="Submit" class="btn btn-success" />&nbsp;&nbsp;&nbsp;
					
	<a href="csv_export_student.php?schoolname=<?= $_POST['schoolname'];?>&duration=<?= $_POST['duration'];?>&activity_id=<?= $_POST['activity_id'];?>&subject_id=<?= $_POST['subject_id'];?>&department=<?= $_POST['department'];?>" class="btn btn-success" >Export to CSV</a> 							 
					   
</div>	
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
			 $activity_id=$_POST['activity_id'];
			 $subject_id=$_POST['subject_id'];
			 $department=$_POST['department'];
			 $where="";
			 $time_duration="";
			 $subject_activity="";
			 $join_for_sub_act="";
			 $point_type="";		
					
					if($school_id1!='all')
					{
						$where .=" and s.school_id='$school_id'";
					}
					else
					{
						$where .= " and s.group_member_id='$group_member_id'";
					}
					
					
					
						
					if($duration==1)
					{
						$time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
					}
					else if($duration==2)
					{
						$time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
					}
					else
					{
						$time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
					}
					
					
					if($activity_id!='')
					{
					$subject_activity .= " spl.sc_list, ";
					$join_for_sub_act .= " join tbl_studentpointslist spl on spl.sc_id = sp.sc_studentpointlist_id where activity_type='activity'";
					if($activity_id=="allActivity")
					{
					$where .="";
					}
					else{
						$where .=" and sp.sc_studentpointlist_id='$activity_id'";
					}
					
					}
						


					if($subject_id!='')
					{	
					$subject_activity .= " ss.subject,"; 
				
					$join_for_sub_act .= " join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id where activity_type='subject'";
					
					if($subject_id=="allSubject")
					{
					$where .= "";	
					}
					else
					{
					$where .= " and sp.sc_studentpointlist_id='$subject_id'";	
					}	
					
				    }
				    if($department!='')
					{
						if($department=="allDept"){
						$where .= "";	
					}else{
						$where .=" and s.std_dept='$department'";
					}
					}							
										
					
					$sqlforall="Select $subject_activity
					ucwords(s.std_complete_name) as name,s.std_img_path,s.std_school_name,s.school_id,s.std_dept,
					sum(sc_point) as total from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id $join_for_sub_act and (sp.type_points='Greenpoint' or sp.type_points='green_Point')";
					
					$groupby= " GROUP BY sp.sc_stud_id order by total desc limit 10";
					//echo $sqlforall . $time_duration . $where . $groupby;exit;

					$sql=mysql_query( $sqlforall . $time_duration . $where . $groupby);
			
					
					
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
                                    <th align="center"><?php echo xecho($dynamic_student);?> Image</th>
                                    <th align="center"><?php echo xecho($dynamic_student);?> Name</th>
									
									<?php if ($school_type == 'school' && $user=='School Admin'){?>
                                    <th align="center"><?php echo xecho($dynamic_student." ".$organization."");?>    Name</th>
									<?php } ?>
									<!---Department column added by Rutuja for SMC-5112 on 20-01-2021-->
									<th align="center">Department</th>
									
                                    <th align="center">Points</th>
										
									</tr>
								</thead>
								<?php $i=0;
								 while($row=mysql_fetch_array($sql)){
								 	 $specific_school=$row['std_school_name'];
									 
									 $specific_school_id=$row['school_id'];
									 
									 $sql_for_school=mysql_query("select school_name,school_id from tbl_school_admin where school_id='$specific_school_id'");
									 
									
									 
								$i++;?>
								
								<tbody>
									<tr class="success">
									<td ><?php echo xecho($i);?></td>
									<td> <?php if($row['std_img_path'] != ''){?>
													<img src="<?php echo xecho($row['std_img_path']);?>"  style=" width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);" alt="Responsive image" /> <?php }else {?> <img src="Images/avatar_2x.png"  style="border:1px solid #CCCCCC; width:70px;height:70px;border-radius:50% 50% 50% 50%; -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 1);"  alt="Responsive image"/> <?php }?></td>
										<td><?php echo xecho($row['name']);?></td>
										
										<?php if ($school_type == 'school' && $user=='School Admin'){?>
										
										<?php
					
										while($row2=mysql_fetch_array($sql_for_school)){
											if($row2['school_name']!="")
											{
											?>
										
										<td><?php echo xecho($row2['school_name']);?></td>
										<?php }
										else{
											echo xecho ("");
											}
										}


										}?>

										<td><?php echo xecho($row['std_dept']);?></td>
										
										<td><?php echo xecho($row['total']);?></td>
										
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

