<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 04-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Teacher_Subject_List_".date("YmdHis");

    // $qr="select * from tbl_teacher_subject_master where school_id='$school_id'";
    // $rs_result=mysql_query($qr);

    
    $year = $_GET['year'];

    if($year!=''){
        
            $qr="select * from tbl_teacher_subject_master where school_id='$school_id' and AcademicYear = '$year' order by tch_sub_id DESC";
            $rs_result=mysql_query($qr);
    }

    //Made same headers as present in Upload Panel for SMC-5120 on 02-02-2021 by Chaitali Solapure
    $data='SchoolID,"TeacherID","SubjectID","SubjectCode","SubjectName","YearID","DivisionID","Division","SemesterID","Semester","BranchID","Branch","DepartmentID","Department","CourseLevel","AcademicYear","DepartmentCode"'."\n";
    
    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;

        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        $row['teacher_id']=str_replace(',', ' ', $row['teacher_id']);
        $row['ExtSchoolSubjectId']=str_replace(',', ' ', $row['ExtSchoolSubjectId']);
        $row['subjcet_code']=str_replace(',', ' ', $row['subjcet_code']);
        $row['subjectName']=str_replace(',', ' ', $row['subjectName']);
        $row['ExtYearID']=str_replace(',', ' ', $row['ExtYearID']);
        $row['ExtDivisionID']=str_replace(',', ' ', $row['ExtDivisionID']);
        $row['Division_id']=str_replace(',', ' ', $row['Division_id']);
        $row['ExtSemesterId']=str_replace(',', ' ', $row['ExtSemesterId']);
        $row['Semester_id']=str_replace(',', ' ', $row['Semester_id']);
        $row['ExtBranchId']=str_replace(',', ' ', $row['ExtBranchId']);
        $row['Branches_id']=str_replace(',', ' ', $row['Branches_id']);
        $row['ExtDeptId']=str_replace(',', ' ', $row['ExtDeptId']);
        $row['Department_id']=str_replace(',', ' ', $row['Department_id']);
        $row['CourseLevel']=str_replace(',', ' ', $row['CourseLevel']);
        $row['AcademicYear']=str_replace(',', ' ', $row['AcademicYear']);
        $row['Dept_code']=str_replace(',', ' ', $row['Dept_code']);

        $data .= $row['school_id'].','.$row['teacher_id'].','.$row['ExtSchoolSubjectId'].','.$row['subjcet_code'].','.$row['subjectName'].','.$row['ExtYearID'].','.$row['ExtDivisionID'].','.$row['Division_id'].','.$row['ExtSemesterId'].','.$row['Semester_id'].','.$row['ExtBranchId'].','.$row['Branches_id'].','.$row['ExtDeptId'].','.$row['Department_id'].','.$row['CourseLevel'].','.$row['AcademicYear'].','.$row['Dept_code']."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>