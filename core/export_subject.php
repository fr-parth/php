<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 02-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Subject_List_".date("YmdHis");

    $qr="select * from tbl_school_subject where school_id='$school_id'";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Upload Panel for SMC-5120 on 02-02-2021 by Chaitali Solapure
    $data='SchoolID,"SubjectID","SubjectCode","Subject","SubjectType","SubjectShortName","SubjectCredit"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['school_id']=str_replace(',', ' ', $row['school_id']);
        $row['subject_id']=str_replace(',', ' ', $row['subject_id']);
        $row['Subject_Code']=str_replace(',', ' ', $row['Subject_Code']);
        $row['subject']=str_replace(',', ' ', $row['subject']);
        $row['Subject_type']=str_replace(',', ' ', $row['Subject_type']);
        $row['Subject_short_name']=str_replace(',', ' ', $row['Subject_short_name']);
        $row['subject_credit']=str_replace(',', ' ', $row['subject_credit']);

        $data .= $row['school_id'].','.$row['subject_id'].','.$row['Subject_Code'].','.$row['subject'].','.$row['Subject_type'].','.$row['Subject_short_name'].','.$row['subject_credit'].','."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>