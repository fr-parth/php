<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 28-01-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Class_List_".date("YmdHis");

    $qr="select * from Class where school_id='$school_id'";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Upload Panel for SMC-5120 on 28-01-2021 by Chaitali Solapure
    $data='SchoolID,"Class","ClassID","CourseLevel"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        $row['class']=str_replace(',', ' ', $row['class']);
        $row['ExtClassID']=str_replace(',', ' ', $row['ExtClassID']);
        $row['course_level']=str_replace(',', ' ', $row['course_level']);
        
        $data .= $row['school_id'].','.$row['class'].','.$row['ExtClassID'].','.$row['course_level'].','."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>