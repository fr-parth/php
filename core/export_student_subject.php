<?php
    /* Created by Ashutosh Chavhan for SMC-5470 to download student subject 04-07-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Student_Subject_List_".date("YmdHis");

    $year = $_GET['year'];

    if($year!=''){
        
            $qr="select * from tbl_student_subject_master where school_id='$school_id' and AcademicYear = '$year' order by id DESC";
            $rs_result=mysql_query($qr);
    }


    // $qr="select * from tbl_student_subject_master where school_id='$school_id'";
    // $rs_result=mysql_query($qr);

   //Made same headers as present in Upload Panel for SMC-5120 on 02-02-2021 by Chaitali Solapure
   $data='SchoolID,"Student PRN","SubjectCode","SemesterID","BranchID","YearID","DivisionID","SubjectName","Division","Semester","Branch","Department","CourseLevel","AcademicYear"'."\n";
    
    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;

        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        // $row['teacher_id']=str_replace(',', ' ', $row['teacher_id']);
        // $row['ExtSchoolSubjectId']=str_replace(',', ' ', $row['ExtSchoolSubjectId']);
        $row['student_id']=str_replace(',', ' ', $row['student_id']);
        $row['subjcet_code']=str_replace(',', ' ', $row['subjcet_code']);
        $row['subjectName']=str_replace(',', ' ', $row['subjectName']);
        $row['ExtYearID']=str_replace(',', ' ', $row['ExtYearID']);
        $row['ExtDivisionID']=str_replace(',', ' ', $row['ExtDivisionID']);
        $row['Division_id']=str_replace(',', ' ', $row['Division_id']);
        $row['ExtSemesterId']=str_replace(',', ' ', $row['ExtSemesterId']);
        $row['Semester_id']=str_replace(',', ' ', $row['Semester_id']);
        $row['ExtBranchId']=str_replace(',', ' ', $row['ExtBranchId']);
        $row['Branches_id']=str_replace(',', ' ', $row['Branches_id']);
        // $row['ExtDeptId']=str_replace(',', ' ', $row['ExtDeptId']);
        $row['Department_id']=str_replace(',', ' ', $row['Department_id']);
        $row['CourseLevel']=str_replace(',', ' ', $row['CourseLevel']);
        $row['AcademicYear']=str_replace(',', ' ', $row['AcademicYear']);

        $data .= $row['school_id'].','.$row['student_id'].','.$row['subjcet_code'].','.$row['ExtSemesterId'].','.$row['ExtBranchId'].','.$row['ExtYearID'].','.$row['ExtDivisionID'].','.$row['subjectName'].','.$row['Division_id'].','.$row['Semester_id'].','.$row['Branches_id'].','.$row['Department_id'].','.$row['CourseLevel'].','.$row['AcademicYear'].''."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>