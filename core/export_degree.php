<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 01-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Degree_List_".date("YmdHis");

    $qr="select * from tbl_degree_master where school_id='$school_id'";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Upload Panel for SMC-5120 on 01-02-2021 by Chaitali Solapure
    $data='SchoolID,"DegreeID","DegreeName","DegreeCode","CourseLevel"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        $row['ExtDegreeID']=str_replace(',', ' ', $row['ExtDegreeID']);
        $row['Degee_name']=str_replace(',', ' ', $row['Degee_name']);
        $row['Degree_code']=str_replace(',', ' ', $row['Degree_code']);
        $row['course_level']=str_replace(',', ' ', $row['course_level']);

        $data .= $row['school_id'].','.$row['ExtDegreeID'].','.$row['Degee_name'].','.$row['Degree_code'].','.$row['course_level'].','."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>