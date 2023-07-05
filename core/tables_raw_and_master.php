<?php
include 'sd_upload_function.php';
include "scadmin_header.php";
$sca=get_school_id($_SESSION['id']);
$school_id=$sca['school_id'];

?>
<html>
<head>
<style>
#key_value {
	
	display:none;
}
</style>
<script>
function input_key(){
	document.getElementById('key_value').style.display = 'inline';
	
}

</script>
</head>
<body>
<form method='post'>
<select name='selection' id='selection' onchange='input_key()'>

					<option value=''></option>

					<option value='tbl_department_master'>1. Departments</option>
					
					<option value='tbl_CourseLevel'>2. Course Level</option>
					
					<option value='tbl_degree_master'>3. Degree</option>
					
					<option value='tbl_branch_master'>4. Branch</option>
					
					<option value='Class'>5. Class</option>
					
					<option value='Division'>6. Division</option>
					
					<option value='tbl_semester_master'>7. Semester</option>

					<option value='tbl_academic_Year'>8. Academic Year</option>

					<option value='tbl_student'>9. Student</option>

					<option value='tbl_teacher'>10. Teacher</option>

				    <option value='tbl_school_subject'>11. Subject</option>	

					<option value='Branch_Subject_Division_Year'>12. Branch Subject Division Year</option>
					
					<option value='tbl_teacher_subject_master'>13. Teacher Subject</option>
					
					<option value='StudentSemesterRecord'>14. Student Semester</option>
					
					<option value='tbl_student_subject_master'>15. Student Subject</option>
					
					<option value='tbl_parent'>16. Parent</option>

</select>
<input type='text' name='key_value' id='key_value'>
<button type='submit' name='submit' class='btn btn-success' >Submit</button>
</form>

<?php

if(isset($_POST[submit]))
{
	
	echo $selection =  $_POST[selection];
	echo $search_key =  $_POST[key_value];
	switch ($selection) {
    case tbl_department_master:
	?>
		<table id="example" class="display" cellspacing="0" width="100%" >
			
            <thead>
			<tr style="background-color:#909497;color: white;"><th align='center' >Sr.No</th>
			<th style="text-align:center">Department  Name</th>
			<th style="text-align:center">Department Code</th>
			<th style="text-align:center">Is-enable flag</th>
              </thead>
            <tbody>
            
            <?php
			echo "select * from tbl_department_master where School_ID='$school_id' and (Dept_code like '$search_key' or Dept_Name like '%$search_key%')";
			$c = 1;
			$sql = mysql_query("select * from tbl_department_master where School_ID='$school_id' and (Dept_code like '%$search_key%' or Dept_Name like '%$search_key%')");
			while($result = mysql_fetch_array($sql))
				{	
					echo "<tr>";
					echo "<td style='text-align:center'>".$c."</td>";
					echo "<td style='text-align:center'>".$result['Dept_Name']."</td>";	
					echo "<td style='text-align:center'>".$result['Dept_code']."</td>";
					echo "<td style='text-align:center'>".$result['Is_Enabled']."</td>";
					echo "</tr>";
					
				$c++;
				}
        echo "department";
        break;
    case tbl_CourseLevel:
        echo "courselevel";
        break;
    case tbl_degree_master:
        echo "degree";
        break;
	 default:
       echo "rugug";
    
}
}


?>

</body>
</html>