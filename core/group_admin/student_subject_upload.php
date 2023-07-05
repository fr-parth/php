<?php
include("groupadminheader.php");
//include('../conn.php');
define('CURR_ACAD_YEAR','2017-2018');
$uploaded_by = $_SESSION['group_admin_id'];

$group_member_id = $_SESSION['group_admin_id'];

/*function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}*/

if($_SESSION['entity'] !=12){

	echo "You are not authorize to view this page.";
	exit;
}
?>
<div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading' align ='center'>

<h2> Student Subject Upload Panel</h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>

 <tr><br><td><b>Select Academic Year: </td>
 <td><select name='acad_year' id='acad_year'>

				<option value=''>Select Year</option>
				<option value="<?php echo CURR_ACAD_YEAR; ?>"><?php echo CURR_ACAD_YEAR; ?></option>
			</select></td></tr> 
<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
 </form>

 <form method='post' enctype='multipart/form-data'>
<table align='right'>
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='basic_data_format'>Student subject data format</option>
			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
		</div>	
</table>
		</form>
	<div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>

	</div>
	</div>
	</div>
	</div>
	</div>
<?php
	if(isset($_POST["submit_file"]))
	{ 
	 $acad_year = $_POST["acad_year"];
	 $filename = basename($_FILES['file']['name']); //exit; 
	 $file = $_FILES['file']['tmp_name'];
	 $handle = fopen($file, "r");
		
		if ($acad_year == '')
		{
		 echo "Please Select Academic Year";
		 exit; 
		}

		if ($file == NULL)
		 {
			 echo "Please select a file to import"; 
		 }

		$i		= 0;
		$m		= 0;
		$a		= 0;
		$j		= 0;
		$row	= 0;
		
		

		$main_table			= "tbl_student_subject_master";
		$raw_table			= "tbl_student_subject";
		$school_sub_table	= "tbl_games";
		$tbl_student		= "tbl_student";

			while ( ($data = fgetcsv($handle) ) !== FALSE )
			{
				if($row==0){$row++; continue;}

				$ok = 1;
		 
				$school_id		= $data[0];
				$student_id		= $data[1];
				$subject_code	= $data[2];
				$semester_id	= $data[3];
				$branch_id		= $data[4];
				$subject_id		= $data[5];
				$year_id		= $data[6];
				$division_id	= $data[7];
				$subject_name	= $data[8];
				$division		= $data[9];
				$semester		= $data[10];
				$branch			= $data[11];
				$department		= $data[12];
				$course_level	= $data[13];
				$teacher_id		= $data[14];

		
				if($student_id == '' || $school_id == '' ||  $subject_code == '')
				{
					$ok = 0;
					$msg = "Either Student Id, School Id or Subject Code is missing.";

				}

				$myquery = "select std_PRN from $tbl_student where std_PRN='$student_id' and school_id='$school_id' and group_member_id='$group_member_id'";
				$myres = mysql_query($myquery);
				$count = mysql_num_rows($myres);

				$myquery1 = "select subject_code from $school_sub_table where subject_code = '$subject_code' and group_member_id='$group_member_id'";
				$myres1 = mysql_query($myquery1);
				$count1 = mysql_num_rows($myres1);

				if($count > 0 )
				{
					
					$myquery2 = "select student_id,subjcet_code from $main_table where student_id='$student_id' and subjectName='$subject_name' and group_member_id='$group_member_id' ";
					$myres2 = mysql_query($myquery2);
					$count2 = mysql_num_rows($myres2);

					if($count2 > 0)
					{
						$ok = 2;
						$update = "UPDATE $main_table SET school_id='$school_id', ExtSemesterId='$semester_id', ExtBranchId='$branch_id', ExtSchoolSubjectId='$subject_id', ExtYearID='$year_id', ExtDivisionID='$division_id', subjectName='$subject_name', Division_id='$division', Semester_id='$semester', Branches_id='$branch', Department_id='$department', CourseLevel='$course_level', AcademicYear='$acad_year', teacher_ID='$teacher_id',uploaded_by='$uploaded_by',upload_date=NOW() where student_id='$student_id' and subjectName='$subject_name' and group_member_id='$group_member_id';"; 
						$update_res = mysql_query($update);

						if($update_res)
						{
							$a++;
						}
						else
						{
							$ok = 0;
							$msg = "DB Error - ".mysql_error();
						}
					}

					if($ok == 1)
					{
						$insert = "INSERT INTO $main_table (school_id, student_id, subjcet_code, ExtSemesterId, ExtBranchId, ExtSchoolSubjectId, ExtYearID, ExtDivisionID, subjectName, Division_id, Semester_id, Branches_id, Department_id, CourseLevel, AcademicYear, teacher_ID,uploaded_by,upload_date,group_member_id) VALUES ('$school_id','$student_id','$subject_code','$semester_id','$branch_id','$subject_id','$year_id','$division_id','$subject_name','$division','$semester','$branch','$department','$course_level','$acad_year','$teacher_id','$uploaded_by',NOW(),'$group_member_id');";
						$insert_res = mysql_query($insert);
						
						if($insert_res)
						{
							
							$i++;
						}
						else
						{
							$ok = 0;
							$msg = "DB Error - ".mysql_error();
						}

					}

				}
				else if($count == 0)
				{
					$ok = 0;
					$msg = "Student Id does not exist.";
				}

				if($count1 == 0)
				{
					$ok = 0;
					$msg = "Subject Code does not exist.";
				}

				if($ok == 0)
				{
					$insertraw = "INSERT INTO $raw_table (school_id, student_id, subjcet_code, ExtSemesterId, ExtBranchId, ExtSchoolSubjectId, ExtYearID, ExtDivisionID, subjectName, Division_id, Semester_id, Branches_id, Department_id, CourseLevel, AcademicYear, teacher_ID,uploaded_by,upload_date,error_msg,group_member_id) VALUES ('$school_id','$student_id','$subject_code','$semester_id','$branch_id','$subject_id','$year_id','$division_id','$subject_name','$division','$semester','$branch','$department','$course_level','$acad_year','$teacher_id','$uploaded_by',NOW(),'$msg','$group_member_id');";
					$insertraw_res = mysql_query($insertraw);

					$j++;

				}

			}

				echo "<div align='center'><font color='green'><b>Total inserted records: ".$i."</b></font></div>";
				echo "<div align='center'><font color='green'><b>Total updated records: ".$a."</b></font></div>";
				echo "<div align='center'><br><br><font color='red'><b>Total rejected records: ".$j."</b></font></div>";
?>
	<?php if($j > 0){?>
		<table border='1px' align='center'>

		<tr>
		<th>Sr No.</th>
		<th>Error Message</th>
		<th>Student Id</th>
		<th>School Id</th>
		<th>Subject Code</th>
		<th>Subject Name</th>
		<th>Upload Date</th>
		</tr>
		<?php 
		
		$myquery1 = "select error_msg,school_id, student_id, subjcet_code,subjectName,upload_date from $raw_table where group_member_id='$group_member_id' and uploaded_by = '$uploaded_by' and upload_date > timestamp(DATE_SUB(NOW(), INTERVAL 10 MINUTE)) order by upload_date DESC";
		$myres1 = mysql_query($myquery1);
		$k = 1;
		while($row = mysql_fetch_array($myres1))
		{
		?>
		<tr>
		<td align='center'><?php echo $k++ ?></td>
		<td><?php echo $row['error_msg'] ;?></td>
		<td><?php echo $row['student_id'] ?></td>
		<td><?php echo $row['school_id'] ?></td>
		<td><?php echo $row['subjcet_code'] ?></td>
		<td><?php echo $row['subjectName'] ?></td>
		<td><?php echo date('Y-M-d H:i:s',strtotime($row['upload_date'])); ?></td>
		</tr>

		<?php }?>
		</table>
<?php } }?>
			
	<?php	
		
	if(isset($_POST['dformat']))
	{

		$data_format=$_POST['data_format'];	
		$path = url()."/core/Importdata/";

		if($data_format =='basic_data_format')
		{
			$filename="GroupStudentSubjectFormat.csv";
			$filepath = $path.$filename;

			echo "<script>window.open('$filepath');</script>";

		}
		
	}
?>