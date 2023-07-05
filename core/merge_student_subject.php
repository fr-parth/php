<?php

include_once("scadmin_header.php");



/*$id=$_SESSION['id'];  */

     $fields=array("id"=>$id);

           $table="tbl_school_admin";

           $smartcookie=new smartcookie();



$results=$smartcookie->retrive_individual($table,$fields);

$school_admin=mysql_fetch_array($results);



            $sc_id=$school_admin['school_id'];

            $uploadedBy=$school_admin['name'];


 if (isset($_POST["submit"]) )
{
	$uploded_by=$_POST['txtname'];

	if(!empty($uploded_by))
	{
		$query2="select batch_id from `tbl_student_subject_master` WHERE school_id='$sc_id' ORDER BY id DESC LIMIT 1 ";  //query for getting last batch_id what else if are inserting first time data
			$row2=mysql_query($query2);
	$value2=mysql_fetch_array($row2);
	$batch_id1=$value2['batch_id'];
	$b_id=explode("-",$batch_id1);
	$b=$b_id[1]; 
	$bat_id=$b+1;
	$str=str_pad($bat_id, 3, "00", STR_PAD_LEFT);
	$batch_id=$sc_id."_B"."-".$str;
	$insertcount=0;$notinsert=0;

    $array="";
    $sql1 = "SELECT * FROM `tbl_teacher_subject_master`as ts, tbl_teacher as t
WHERE ts.teacher_id=t.t_id
and t.school_id='$sc_id'";
    $query1 = mysql_query($sql1) or mysql_error($sql1);


    while($row=mysql_fetch_assoc($query1))
    {
    $array[''.$row["subjcet_code"].''] = $row['teacher_id'];
    }

   /* var_dump($array);   echo"<br>";  */
    /* print_r($array);  */
    $sql= "SELECT *
FROM tbl_class_subject_master AS c, StudentSemesterRecord AS s
WHERE s.ExtSemesterId= c.semester_id
AND c.branch = s.BranchName
AND c.school_id = s.school_id
AND s.school_id =  '$sc_id'";
    $query = mysql_query($sql) or mysql_error($sql);


    while($rows=mysql_fetch_assoc($query))
    {
       //echo $rows['subject_code']."-->"; 
       $sub = $rows['subject_code'];
       $t_id = $array[$sub];

       $sql1= "SELECT * FROM `tbl_student_subject_master` WHERE `student_id`='".$rows['student_id']."' and `teacher_ID`='".$t_id."' and `school_id`='$sc_id' and `subjcet_code`='".$rows['subject_code']."' and `AcademicYear`='".$rows['academic_year']."' and Semester_id='".$rows['SemesterName']."'";
      $query1 = mysql_query($sql1) or mysql_error($sql1);
	  if(mysql_num_rows($query1)==1)
	  {
		   $update_stud_sem="UPDATE `tbl_student_subject_master` SET `ExtSemesterId`='".$rows['ExtSemesterId']."',`ExtBranchId`='".$rows['ExtBranchId']."',`ExtSchoolSubjectId`='".$rows['ExtSchoolSubjectId']."',`ExtYearID`='".$rows['academic_year']."',`ExtDivisionID`='".$rows['ExtDivisionId']."',`student_id`='".$rows['student_id']."',`teacher_ID`='".$t_id."',`school_id`='".$rows['school_id']."',`subjcet_code`='".$rows['subject_code']."',`subjectName`='".$rows['subject_name']."',
		   `Division_id`='".$rows['DivisionName']."',`Semester_id`='".$rows['SemesterName']."',`Branches_id`='".$rows['branch_id']."',
		   `Department_id`='".$rows['dept_id']."',`CourseLevel`='".$rows['course_level']."',`AcademicYear`='".$rows['academic_year']."',
		   `upload_date`='".date("m/d/Y")."',`uploaded_by`='$uploded_by',`batch_id`='$batch_id' WHERE `student_id`='".$rows['student_id']."' and `teacher_ID`='".$t_id."' and `school_id`='$sc_id' and `subjcet_code`='".$rows['subject_code']."' and `AcademicYear`='".$rows['academic_year']."'";
		   $update_count = mysql_query($update_stud_sem) or die('Could not update data: ' . mysql_error());
		  
	  } 
      else{  

       $insert = "Insert into tbl_student_subject_master (ExtSemesterId,ExtBranchId,ExtSchoolSubjectId,ExtYearID,ExtDivisionID ,student_id,teacher_ID,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel ,AcademicYear,upload_date,uploaded_by,batch_id) values('".$rows['ExtSemesterId']."','".$rows['ExtBranchId']."','".$rows['ExtSchoolSubjectId']."','".$rows['academic_year']."','".$rows['ExtDivisionId']."','".$rows['student_id']."','".$t_id."','".$rows['school_id']."','".$rows['subject_code']."','".$rows['subject_name']."','".$rows['DivisionName']."','".$rows['SemesterName']."','".$rows['branch_id']."','".$rows['dept_id']."','".$rows['course_level']."','".$rows['academic_year']."','".date("m/d/Y")."','$uploded_by',
	   '$batch_id')";

       if(mysql_query($insert) or mysql_error($insert))
       {
            $insertcount++;
       }
       else
       {
            $notinsert++;
       }
    }
 }
	}else{
		
		$report="Please Enter Uploaded By name..";
	} 
}

  ?>


 <html>
      <body>
      <form method="POST" action="">
	       <b>Uploaded By</b>&nbsp;&nbsp;<input type="text" name="txtname" value="" placeholder="Uploaded By">
          <input type="submit" value="submit" name="submit"><br/>
		  <span style="color:red;"><?php echo $report;?> </span><br/>
		  <span style="color:red;"><?php echo "Number of records Inserted=".$insertcount;?> </span><br/>
		  <span style="color:red;"><?php echo "Number of records not inserted=".$notinsert;?> </span><br/>
      </form>
      </body>
  </html>