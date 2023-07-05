<?php
include("scadmin_header.php");
include_once("conn.php");
	
$report="";
$scidnf=0;
$stdnf=0;
$subnf=0;
$semnf=0;
$tchnf=0;
$confirm=0;
$invalid=0;
$present=0;

//get school mnemonic
$id=$_SESSION['id'];
$loggedin=$id;
$query="select * from `tbl_school_admin` where id='$id'";       // uploaded by
$row=mysql_query($query) or die(mysql_error());
$value=mysql_fetch_array($row);
$uploaded_by=$value['name'];
$school_id=$value['school_id'];

$sql=mysql_query("select batch_id from tbl_Batch_Master where school_id='$school_id' and entity='School_Admin' and uploaded_by='$uploaded_by' and db_table_name='tbl_student_subject_master' order by id desc") or die(mysql_error());
$batch_id1=mysql_fetch_array($sql);
$batch_id=$batch_id1['batch_id'];


$countrows=mysql_fetch_array(mysql_query("SELECT count(*) FROM tbl_student_subject WHERE batch_id='$batch_id' and school_id='$school_id'")) or die(mysql_error());
$r=$countrows[0];


function search_student($prn,$school_id){
	$is=mysql_query("select id from tbl_student where std_PRN='$prn' and school_id='$school_id'") or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}

function search_school_id($passed,$loggedin){
	$is=mysql_query("select * from tbl_school_admin where school_id='$passed' and id='$loggedin'") or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}

function search_teacher($mis,$school_id){
	$is=mysql_query("select id from tbl_teacher where  t_id='$mis' and school_id='$school_id'") or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}

function search_subject($subcode,$school_id){
	$is=mysql_query("select id from tbl_school_subject where  Subject_Code='$subcode' and school_id='$school_id'") or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}

function search_semester($school_id,$semname, $branchname,$deptname, $courselevel){
$is=mysql_query("select Semester_Id from tbl_semester_master where  Semester_Name='$semname' and Branch_name='$branchname' and Department_Name='$deptname' and CourseLevel='$courselevel' and school_id='$school_id'")or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}

function update_raw($stud_sub_id, $status, $validity){
$is=mysql_query("update tbl_student_subject set status='$status', validity='$validity' where stud_sub_id='$stud_sub_id'") or die(mysql_error());
	if($is){
		return true;
	}else{
		return false;
	}
}

function update_batch($batch_id, $school_id, $uploaded, $invalid, $scidnf, $present, $confirm, $confirm, $present, $disp_table, $tbl, $existing_records ){
	$is=mysql_query("update tbl_Batch_Master set num_records_uploaded='$uploaded', num_errors_records= num_errors_records + '$invalid', num_errors_scid= num_errors_scid + '$scidnf', num_duplicates_record= num_duplicates_record + '$present', 	num_correct_records= num_correct_records + '$confirm', num_newrecords_inserted= num_newrecords_inserted + '$confirm', num_records_updated= num_records_updated + '$present', display_table_name='$disp_table', db_table_name='$tbl', existing_records='$existing_records' where school_id='$school_id' and batch_id='$batch_id'") or die(mysql_error());
	if($is){
		return true;
	}else{
		return false;
	}
}


function search_std_sub_master($student_id, $teacher_ID, $school_id, $subjcet_code, $subjectName, $Division_id, $Semester_id, $Branches_id, $Department_id, $CourseLevel, $AcademicYear){
$is=mysql_query("select id from tbl_student_subject_master where  student_id='$student_id' and teacher_ID='$teacher_ID' and school_id='$school_id' and subjcet_code='$subjcet_code'  and  	Division_id='$Division_id' and  Semester_id='$Semester_id' and  Branches_id='$Branches_id' and  Department_id='$Department_id' and  CourseLevel='$CourseLevel' and  AcademicYear='$AcademicYear'") or die(mysql_error());
	$r=mysql_num_rows($is);
	if($r>0){
		return true;
	}else{
		return false;
	}
}


$toproc1=mysql_fetch_array(mysql_query("SELECT count(*) FROM tbl_student_subject WHERE batch_id='$batch_id' and school_id='$school_id' and status=''"));
$toproc=$toproc1[0];


if(isset($_GET['pro'])){
	$alp1=mysql_query("select count(*) from tbl_student_subject_master where school_id='$school_id'");
	$alp=mysql_fetch_array($alp1);
	$existing_records=$alp[0];
	
$res1=mysql_query("SELECT * FROM tbl_student_subject WHERE batch_id='$batch_id' and school_id='$school_id' and status='' LIMIT 1500") or die(mysql_error());

$scidnf=0;
$stdnf=0;
$subnf=0;
$semnf=0;
$tchnf=0;
$confirm=0;
$invalid=0;
$present=0;

	while($res=mysql_fetch_array($res1)){	
		$stud_sub_id=$res['stud_sub_id'];
		$scid=$res['school_id'];
		$prn=$res['student_id'];
		$subcode=$res['subjcet_code'];
		$semname=$res['Semester_id'];
		$branchname=$res['Branches_id'];
		$deptname=$res['Department_id'];
		$courselevel=$res['CourseLevel'];
		$mis=$res['teacher_ID'];
		$subjectName=$res['subjectName'];
		$Division_id=$res['Division_id'];
		$AcademicYear=$res['AcademicYear'];
		
		if(!search_school_id($scid,$loggedin)){			
			$scidnf++;
			$invalid++;
			update_raw($stud_sub_id, 'scidnf', 'invalid');
		}else{
			if(!search_student($prn,$school_id)){
				$stdnf++;
				$invalid++;
				update_raw($stud_sub_id, 'stdnf', 'invalid');
			}else{
				if(!search_subject($subcode,$school_id)){
					$subnf++;
					$invalid++;
					update_raw($stud_sub_id, 'subnf', 'invalid');
				}else{
					if(!search_semester($school_id,$semname, $branchname,$deptname, $courselevel)){
						$semnf++;
						$invalid++;
						update_raw($stud_sub_id, 'semnf', 'invalid');
					}else{
						if(!search_teacher($mis,$school_id)){
							$tchnf++;
							$invalid++;
							update_raw($stud_sub_id, 'tchnf', 'invalid');
						}else{
							if(search_std_sub_master($prn, $mis, $scid, $subcode, $subjectName, $Division_id, $semname, $branchname, $deptname, $courselevel, $AcademicYear)){
							$present++;
							
							update_raw($stud_sub_id, 'existing', 'invalid');
							}else{
								$confirm++;
								update_raw($stud_sub_id, 'add', 'valid');
							}
						}
					}
				}
			}			
		}
	}
	update_batch($batch_id, $school_id, $r, $invalid, $scidnf, $present, $confirm, $confirm, $present, 'student subject', 'tbl_student_subject_master', $existing_records );
		
	$toproc1=mysql_fetch_array(mysql_query("SELECT count(*) FROM tbl_student_subject WHERE batch_id='$batch_id' and school_id='$school_id' and status=''"));
	$toproc=$toproc1[0];
}
if(isset($_GET['upmain'])){
	$upsql="INSERT INTO tbl_student_subject_master (ExtSemesterId,ExtBranchId,ExtSchoolSubjectId,ExtYearID,ExtDivisionID,student_id,teacher_ID,school_id,school_staff_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id, Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by,batch_id) SELECT ExtSemesterId,ExtBranchId,ExtSchoolSubjectId,ExtYearID,ExtDivisionID,student_id,teacher_ID,school_id, school_staff_id,subjcet_code, subjectName,Division_id,Semester_id,Branches_id,Department_id, CourseLevel,AcademicYear,upload_date,uploaded_by,batch_id FROM tbl_student_subject WHERE validity='valid' and status='add' and batch_id='$batch_id' and school_id='$school_id'";
	$upsql1=mysql_query($upsql)or die(mysql_error());
	if($upsql1){
		mysql_query("UPDATE tbl_student_subject SET status='added' WHERE batch_id='$batch_id' and school_id='$school_id' and status='add'")or die(mysql_error());
		echo "<script>
		alert('Updated Successfully');
		window.location='process_batch_sch_sub.php';	
		</script>";
	}
}
if(isset($_GET['repro'])){
	mysql_query("UPDATE tbl_student_subject SET status='', validity='' WHERE batch_id='$batch_id' and school_id='$school_id'")or die(mysql_error());
	echo "<script>
		alert('Reset For Update Successfull, You may now process this batch');
		window.location='process_batch_sch_sub.php';						
		</script>";
}

if($_GET['storedproc']){	
	$stproc1=mysql_query("call uploadrecordstudentsubject('$batch_id')");
	while($stproc=mysql_fetch_array($stproc1)){
		print_r($stproc);
	}
	
}
?>


<div class='container'>
<div class='panel panel-default'>
	<div class='panel-heading'>
		Add Student Subject Excel Sheet
	</div>
	<div class='panel-body'>
		<form method='post' enctype='multipart/form-data'>
		<div class='row'>
			<div class='col-md-4 col-md-offset-1'>				
				You are Processing Batch# :<?=$batch_id;?> <br/><br/>
				<table border='1'>
				<tr><th>Total Records</th><th>Processed</th><th>To Process</th><th>Invalid</th><th>SchoolID Not Found</th><th>Student Not Found</th><th>Subject Not Found</th><th>Semester Not Found</th><th>Teacher Not Found</th><th>Updated</th><th>Inserted</th></tr>
				<tr><th><?=$r;?></th><th><?=$r-$toproc;?></th><th><?=$toproc;?></th><th><?=$invalid?></th><th><?=$scidnf;?></th><th><?=$stdnf;?></th><th><?=$subnf;?></th><th><?=$semnf;?></th><th><?=$tchnf;?></th><th><?=$present;?></th><th><?=$confirm;?></th></tr>
				</table><br/>
				<a href='process_batch_sch_sub.php?pro=1'><input type='button'  class='btn btn-success' value='Process Next 1500' /></a>
				&nbsp; &nbsp;<button type='reset' name='reset' class='btn btn-warning' >Cancel</button>
			</div>
			<div class='row'>
				<a href='process_batch_sch_sub.php?upmain=1'><input type='button'  class='btn btn-success' value='Update Main Table' /></a>
				<a href='process_batch_sch_sub.php?repro=1'><input type='button'  class='btn btn-warning' value='Reset and Reprocess' /></a>
				<a href='process_batch_sch_sub.php?storedproc=1'><input type='button'  class='btn btn-success' value='Validate and Upload' /></a>
			</div>
		</div>			
		<div class='row'>
		<div class='col-md-4 col-md-offset-4'>
			<!--add excel sheet format here-->
		</div>
		</div>
	</div>

</div>
</div>