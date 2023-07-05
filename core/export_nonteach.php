<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 02-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Non_Teaching_Staff_List_".date("YmdHis");

    $qr="select * from tbl_teacher where school_id='$school_id' AND t_emp_type_pid NOT IN (133,134,135,137)";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Dashboard for SMC-5120 on 02-02-2021 by Chaitali Solapure
    $data='"Teacher ID","Name","Phone Number","Email ID","Department"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['t_id']=str_replace(',', ' ', $row['t_id']);
        $row['t_complete_name']=str_replace(',', ' ', $row['t_complete_name']);
        $row['t_phone']=str_replace(',', ' ', $row['t_phone']);
        $row['t_email']=str_replace(',', ' ', $row['t_email']);
        $row['t_dept']=str_replace(',', ' ', $row['t_dept']);
        
        $data .= $row['t_id'].','.$row['t_complete_name'].','.$row['t_phone'].','.$row['t_email'].','.$row['t_dept'].','."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>