<?php
    /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 01-02-2021 */
    include("conn.php");

    $school_id= $_SESSION['school_id'];

    $filename="Department_List_".date("YmdHis");

    $qr="select * from tbl_department_master where school_id='$school_id'";
    $rs_result=mysql_query($qr);

    //Made same headers as present in Upload Panel for SMC-5120 on 01-02-2021 by Chaitali Solapure
    $data='SchoolID,"DepartmentCode","DepartmentName","DepartmentID","EstablimentYear","PhoneNo","FaxNo","EmailID","IsEnabled"'."\n";

    $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
        $j=$j1++;
        
        $row['School_ID']=str_replace(',', ' ', $row['School_ID']);
        $row['Dept_code']=str_replace(',', ' ', $row['Dept_code']);
        $row['Dept_Name']=str_replace(',', ' ', $row['Dept_Name']);
        $row['ExtDeptId']=str_replace(',', ' ', $row['ExtDeptId']);
        $row['Establiment_Year']=str_replace(',', ' ', $row['Establiment_Year']);
        $row['PhoneNo']=str_replace(',', ' ', $row['PhoneNo']);
        $row['Fax_No']=str_replace(',', ' ', $row['Fax_No']);
        $row['Email_Id']=str_replace(',', ' ', $row['Email_Id']);
        $row['Is_Enabled']=str_replace(',', ' ', $row['Is_Enabled']);

        $data .= $row['School_ID'].','.$row['Dept_code'].','.$row['Dept_Name'].','.$row['ExtDeptId'].','.$row['Establiment_Year'].','.$row['PhoneNo'].','.$row['Fax_No'].','.$row['Email_Id'].','.$row['Is_Enabled'].','."\n";

    }

    ob_end_clean();
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
    echo $data; exit(); 

?>