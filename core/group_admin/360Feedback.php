<?php
//hradmin_report.php
include('groupadminheader.php');
$group_member_id = $_SESSION['group_admin_id'];
$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");

if (isset($_POST['submit']))
	{
		
		$department=$_POST['department'];
	    $year=$_POST['year']; 
		
		//Student 360 Feedback
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlFeedStudent = " SELECT  sf.stu_feed_student_ID,st.group_member_id,st.std_PRN FROM 
            techindi_Dev.tbl_student_feedback sf  join tbl_student st on 
			sf.stu_feed_student_ID=st.std_PRN
            
            where st.group_member_id='$group_member_id';
            ";
		
		$resultFeedStudent = mysql_query($sqlFeedStudent);
		$countFeedStudent = mysql_num_rows($resultFeedStudent); 
		
		$sqlStudent = " SELECT id FROM tbl_student where group_member_id='$group_member_id'";
		
		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		$remainingStudent=$CountTotalStudent - $countFeedStudent;
		
		$percentageStudent =  round((($countFeedStudent*100)/$CountTotalStudent),2);

		}
		
		else
		
		{
		
		$sqlFeedStudent = "SELECT distinct stu_feed_dept_ID,stu_feed_student_ID,stu_feed_academic_year,stu_feed_dept_ID,stu_feed_school_id FROM tbl_student_feedback where (stu_feed_academic_year='$year' and stu_feed_dept_ID='$department') and (stu_feed_school_id='$sc_id') group by stu_feed_student_ID";
		
		$resultFeedStudent = mysql_query($sqlFeedStudent);
		$countFeedStudent = mysql_num_rows($resultFeedStudent); 
		

		$sqlStudent = " SELECT * FROM tbl_student where school_id='$sc_id'";
		
		$resultStudent=mysql_query($sqlStudent);
		$CountTotalStudent=mysql_num_rows($resultStudent);
		$remainingStudent=$CountTotalStudent - $countFeedStudent;
		
		$percentageStudent =  round((($countFeedStudent*100)/$CountTotalStudent),2);
		}
		
		//Teaching Process 
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlTeachingProcess = "SELECT f.feed360_teacher_id,t.t_id,t.group_member_id FROM techindi_Dev.tbl_360feedback_template f join 
tbl_teacher t on f.feed360_teacher_id=t.t_id and t.group_member_id='$group_member_id'";
		
		$resultTeachingProcess = mysql_query($sqlTeachingProcess);
		$countTeachingProcess = mysql_num_rows($resultTeachingProcess); 
		
		$sqlTeacher = " SELECT id FROM tbl_teacher where group_member_id='$group_member_id' and  t_emp_type_pid 
		in (133,134,135,137)";
		
		$resultTeacher=mysql_query($sqlTeacher);
		$CountTotalTeacher=mysql_num_rows($resultTeacher);
		$remainingTprocess=$CountTotalTeacher - $countTeachingProcess;
		
		$percentageTProcess =  round((($countTeachingProcess*100)/$CountTotalTeacher),2);

		}
		
		else
		
		{
		
		$sqlTeachingProcess = "SELECT distinct feed360_teacher_id ,feed360_academic_year_ID,feed360_dept_ID,feed360_school_id
            FROM tbl_360feedback_template where feed360_academic_year_ID='$year' and feed360_dept_ID='$department' and feed360_school_id='$sc_id' group by feed360_teacher_id";
		
		$resultTeachingProcess = mysql_query($sqlTeachingProcess);
		 $countTeachingProcess = mysql_num_rows($resultTeachingProcess); 
		
		$sqlTeacher = " SELECT * FROM tbl_teacher where school_id='$sc_id' and  t_emp_type_pid 
		in (133,134,135,137)";
		
		$resultTeacher=mysql_query($sqlTeacher);
		 $CountTotalTeacher=mysql_num_rows($resultTeacher); 
		 $remainingTprocess=$CountTotalTeacher - $countTeachingProcess;
		
		$percentageTProcess =  round((($countTeachingProcess*100)/$CountTotalTeacher),2);
		
		}
		
		
		
		
		
		
		
		//ACR Activities 
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlAcr = "SELECT  distinct tID ,schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (activity_level_id='4') and (Emp_type_id in (137)) and  (group_member_id='$group_member_id') group by tID";
		
		$resultAcr= mysql_query($sqlAcr);
		$countAcr = mysql_num_rows($resultAcr); 
		
		$sqlTeacherAcr = " SELECT distinct t_id FROM tbl_teacher where t_emp_type_pid in (137) and group_member_id='$group_member_id' ";
		
		$resultTeacherAcr=mysql_query($sqlTeacherAcr);
		$CountTotalAcr=mysql_num_rows($resultTeacherAcr);
		$remainingAcr=$CountTotalAcr-$countAcr;
		
		$percentageAcr =  round((($countAcr*100)/$CountTotalAcr),2);

		}
		else
		
		{
		
		$sqlAcr = "SELECT distinct tID ,schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (Academic_YearID='$year') and (deptName='$department') and (activity_level_id='4') and (Emp_type_id='137') and  (schoolID='$sc_id') group by tID ";
		
		$resultAcr= mysql_query($sqlAcr);
		$countAcr = mysql_num_rows($resultAcr); 
		
		$sqlTeacherAcr = " SELECT * FROM tbl_teacher where t_emp_type_pid='137' and school_id='$sc_id' ";
		
		$resultTeacherAcr=mysql_query($sqlTeacherAcr);
		$CountTotalAcr=mysql_num_rows($resultTeacherAcr);
		$remainingAcr=$CountTotalAcr-$countAcr;
		$percentageAcr =  round((($countAcr*100)/$CountTotalAcr),2);
		
		
		}
		//Institutional activities 
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlInst = "SELECT distinct tID , schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (activity_level_id='2') and (Emp_type_id='137') and  (group_member_id='$group_member_id') group by tID";
		
		$resultInstitute= mysql_query($sqlInst);
		$countInstitute = mysql_num_rows($resultInstitute); 
		
		$totalTeacherInstitute = " SELECT distinct t_id FROM tbl_teacher where t_emp_type_pid='137' and group_member_id='$group_member_id' ";
		
		$resultTeacherInstitute=mysql_query($totalTeacherInstitute);
		$CountTotalInstitute=mysql_num_rows($resultTeacherInstitute);
		$remainingInstitute=$CountTotalInstitute-$countInstitute;
		
		$percentageInstitute =  round((($countInstitute*100)/$CountTotalInstitute),2);

		}
		
		else
		
		{
		
		$sqlInst = "SELECT distinct tID,schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (Academic_YearID='$year') and (deptName='$department') and (activity_level_id='2')and (Emp_type_id in (133,134,135,137))  and (group_member_id='$group_member_id') group by tID";
		
		$resultInstitute= mysql_query($sqlInst);
		$countInstitute = mysql_num_rows($resultInstitute); 
		
		$totalTeacherInstitute = " SELECT distinct t_id FROM tbl_teacher where t_emp_type_pid in (133,134,135,137) and group_member_id='$group_member_id' ";
		
		$resultTeacherInstitute=mysql_query($totalTeacherInstitute);
		$CountTotalInstitute=mysql_num_rows($resultTeacherInstitute);
		$remainingInstitute=$CountTotalInstitute-$countInstitute;
		
		$percentageInstitute =  round((($countInstitute*100)/$CountTotalInstitute),2);
		
		
		}
		//Departmental Activities
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlDept = "SELECT distinct tID , schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where activity_level_id='1' and (Emp_type_id in (135,137)) and  group_member_id='$group_member_id' group by tID";
		
		$resultDept= mysql_query($sqlDept);
		$countDept = mysql_num_rows($resultDept); 
		
		$resultTeacherDept = " SELECT distinct t_id FROM tbl_teacher where t_emp_type_pid in (135,137) and group_member_id='$group_member_id' ";
		
		$totaltTeacherDept=mysql_query($resultTeacherDept);
		$CountTotalDept=mysql_num_rows($totaltTeacherDept);
		$remainingDept=$CountTotalDept-$countDept;
		$percentageDept =  round((($countDept*100)/$CountTotalDept),2);

		}
		
		else
		
		{
		
		$sqlDept = "SELECT distinct tID,schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (Academic_YearID='$year') and (deptName='$department') and (activity_level_id='1') and (Emp_type_id in (135,137))and (group_member_id='$group_member_id') group by tID";
		
		$resultDept= mysql_query($sqlDept);
		$countDept = mysql_num_rows($resultDept); 
		
		$resultTeacherDept = " SELECT distinct t_id FROM tbl_teacher where t_emp_type_pid in (135,137) and group_member_id='$group_member_id' ";
		
		$totaltTeacherDept=mysql_query($resultTeacherDept);
		$CountTotalDept=mysql_num_rows($totaltTeacherDept);
		$remainingDept=$CountTotalDept-$countDept;
		$percentageDept =  round((($countDept*100)/$CountTotalDept),2);
		
		
		
		
		}
		
		
		
		
		
		//Society Activities
		if($year == 'ALL' && $department =='ALL')
		{
			$sqlSociety = "SELECT distinct tID , schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where activity_level_id='3' and (Emp_type_id in (133,134,135,137)) and  group_member_id='$group_member_id' group by tID";
		
		$resultSociety= mysql_query($sqlSociety);
		$countSociety = mysql_num_rows($resultSociety); 
		
		$resultTeacherSociety = " SELECT distinct t_id FROM tbl_teacher where (t_emp_type_pid in (133,134,135,137)) and group_member_id='$group_member_id' ";
		
		$totaltTeacherSociety=mysql_query($resultTeacherSociety);
		$CountTotalSociety=mysql_num_rows($totaltTeacherSociety);
		$remianingSociety=$CountTotalSociety-$countSociety;
		$percentageSociety =  round((($countSociety*100)/$CountTotalSociety),2);

		}
		
		else
		
		{
		
		$sqlSociety = "SELECT distinct tID,schoolID,deptName,Academic_YearID,Emp_type_id,activity_level_id
			FROM tbl_360_activities_data where (Academic_YearID='$year') and (deptName='$department') and (activity_level_id='1') and (Emp_type_id in (133,134,135,137)) and (group_member_id='$group_member_id') group by tID";
		
		$resultSociety= mysql_query($sqlSociety);
		$countSociety = mysql_num_rows($resultSociety); 
		
		$resultTeacherSociety = " SELECT * FROM tbl_teacher where t_emp_type_pid in (133,134,135,137) and group_member_id='$group_member_id' ";
		
		$totaltTeacherSociety=mysql_query($resultTeacherSociety);
		$CountTotalSociety=mysql_num_rows($totaltTeacherSociety);
		$remianingSociety=$CountTotalSociety-$countSociety;
		$percentageSociety =  round((($countSociety*100)/$CountTotalSociety),2);

		
		
		
		
		}
		
		
		
 }
	
	

?>
<html>
<head>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	
 <script>
 $(document).ready(function() 
 { 
    $('#example').DataTable(
	{
	"pageLength": 5
	});
	
	$('#example1').DataTable(
	{
	"pageLength": 5
	});
} );
</script>
<!-- JQuery script and JavaScript valid() function added  by Pranali for task SMC-2235 on 05-07-2018  -->
<script>
$(document).ready(function(){

		$("#fromDiv").hide();
		$("#toDiv").hide();
    $('#info').on('change', function() {
      if ( this.value == "1")
      {
        $("#fromDiv").show();
		$("#toDiv").show();
      }
      else
      {
        $("#fromDiv").hide();
		$("#toDiv").hide();
      }
    });
});

</script>

</head>


<body>

		<div class="container">
 
  <div class="panel panel-default">
    <div class="panel-heading" align='center'><h3> 360 feedback </h3></div>
	<br>
	 <div class="row" align="center" style="margin-top:3%;">
	 
	 
	 
         <form method="post" id="empActivity"> 

			
						                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                           
                           <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year</div>
                    <?php $date = date('Y'); ?>
                    <div class="col-md-3">
                        <select name="year" id="year" class="form-control" >
			 
             <option value="">Select Year</option>
			 <option value="ALL" >ALL</option>
             <?php
			 
			 $query=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$sc_id' group by Academic_Year");
			 while($result=mysql_fetch_array($query))
			 {?>
			 
			 
               <option value=<?php echo $result['Academic_Year'];?>><?php echo $result['Academic_Year'];?></option>
			 
			 <?php }?>
             
             </select>
                    </div>
                </div>
							<div class='col-md-3 indent-small' id="erroracademic_year" style="color:#FF0000"></div>
                        </div>
						
						
						
						 <div class="row "  style="padding-top:30px;" >
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"> Department</div>
               
               <div class="col-md-3">
             <select name="department" id="department" class="form-control" >
			 
             <option value="">Select Department</option>
			 <option value="ALL" >ALL</option>
             <?php
			 
			 $query=mysql_query("SELECT distinct Dept_Name,school_id FROM tbl_department_master where school_id='$sc_id' group by Dept_Name");
			 while($result=mysql_fetch_array($query))
			 {?>
			 
			 
               <option value=<?php echo $result['Dept_Name'];?>><?php echo $result['Dept_Name'];?></option>
			 
			 <?php }?>
             
             </select>
             </div>
                
              
                  </div>
										
										
				
			
				
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0" align="center">
	 
	
	 
			<div class="col-md-18" style="margin-left:560px;">
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
                        </div>
						
						</br></br>
						</table>
				<table id="example" class="display" width="80%" cellspacing="5" align="center">	
		<tr>
	<th style="width:100px; text-align: left;">Entity </th>
		<th style="width:100px; text-align: left;">360 Feedback Given </th>
		<th style="width:100px; text-align: left;">360 Feedback Not Given </th>
		
		
		<th style="width:100px; text-align: center;">Total </th>
		
		
		<th style="width:100px; text-align: center;">Percentage  </th>
			
                    
		</tr>
		<tr>
		<td style="width:100px; text-align: left;">Student Feedback</td>
					<td style="width:100px; text-align: center;"><a href="studentFeedback.php" ><?php echo $countFeedStudent;?></td>
					<td style="width:100px; text-align: center;"><a href="StudentFeedback_notGiven.php"> <?php echo $remainingStudent;?></td>
					
					<td style="width:100px; text-align: center;"><?php echo $CountTotalStudent;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageStudent;?> %</td>
		</tr>
		<tr>
		<td style="width:100px; text-align: left;">Teaching Process</td>
					<td style="width:100px; text-align: center;"><a href="teachingProcess_Given.php" > <?php echo $countTeachingProcess;?></td>
					<td style="width:100px; text-align: center;"><a href="teachingProcess_notGiven.php"> <?php echo $remainingTprocess;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalTeacher;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageTProcess;?> %</td>
		</tr>
		
		<tr>
		<td style="width:100px; text-align: left;">Department</td>
					<td style="width:100px; text-align: center;"><a href="department360_given.php"> <?php echo $countDept;?></td>
					<td style="width:100px; text-align: center;"><a href="department360_notGiven.php"> <?php echo $remainingDept;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalDept;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageDept;?> %</td>
		</tr>
		
		
		<tr>
		<td style="width:100px; text-align: left;">Institute</td>
					<td style="width:100px; text-align: center;"><a href="institute360_given.php" > <?php echo $countInstitute;?></td>
					<td style="width:100px; text-align: center;"> <a href="institute360_notGiven.php"><?php echo $remainingInstitute;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalInstitute;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageInstitute;?> %</td>
		</tr>
		
		
		
		<tr>
		<td style="width:100px; text-align: left;">ACR</td>
					<td style="width:100px; text-align: center;"><a href="acr360_given.php"> <?php echo $countAcr;?></td>
					<td style="width:100px; text-align: center;"><a href="acr360_notgiven.php"><?php echo $remainingAcr;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalAcr;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageAcr;?> %</td>
		</tr>
		
		<tr>
		<td style="width:100px; text-align: left;">Society</td>
					<td style="width:100px; text-align: center;"><a href="society360_given.php"> <?php echo $countSociety;?></td>
					<td style="width:100px; text-align: center;"><a href="society360_notGiven.php"> <?php echo $remianingSociety;?></td>
					<td style="width:100px; text-align: center;"><?php echo $CountTotalSociety;?></td>
					<td style="width:100px; text-align: center;"><?php echo $percentageSociety;?> %</td>
		</tr>
		
		
	 </form>
</table>


