<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 01-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Semester_List_".date("YmdHis");

    $qr="select * from tbl_semester_master where school_id='$school_id'";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Upload Panel for SMC-5120 on 01-02-2021 by Chaitali Solapure
    $data='SchoolID,"BranchID","SemesterID","SemesterName","SemesterCredit","IsRegularSemester","BranchName","DepartmentName","DepartmentID","CourseLevel","Class","IsEnabled","DepartmentCode"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        $row['Branch_ID']=str_replace(',', ' ', $row['Branch_ID']);
        $row['Semester_Id']=str_replace(',', ' ', $row['Semester_Id']);
        $row['Semester_Name']=str_replace(',', ' ', $row['Semester_Name']);
        $row['Semester_credit']=str_replace(',', ' ', $row['Semester_credit']);
        $row['Is_regular_semester']=str_replace(',', ' ', $row['Is_regular_semester']);
        $row['Branch_name']=str_replace(',', ' ', $row['Branch_name']);
        $row['Department_Name']=str_replace(',', ' ', $row['Department_Name']);
        $row['Dept_Id']=str_replace(',', ' ', $row['Dept_Id']);
        $row['CourseLevel']=str_replace(',', ' ', $row['CourseLevel']);
        $row['class']=str_replace(',', ' ', $row['class']);
        $row['Is_enable']=str_replace(',', ' ', $row['Is_enable']);
        $row['Dept_code']=str_replace(',', ' ', $row['Dept_code']);

        $data .= $row['school_id'].','.$row['Branch_ID'].','.$row['Semester_Id'].','.$row['Semester_Name'].','.$row['Semester_credit'].','.$row['Is_regular_semester'].','.$row['Branch_name'].','.$row['Department_Name'].','.$row['Dept_Id'].','.$row['CourseLevel'].','.$row['class'].','.$row['Is_enable'].','.$row['Dept_code']."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>