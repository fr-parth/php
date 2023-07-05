<?php

  /* Created by Chaitali Solapure for SMC-5120 to change format from xls to csv on 27-01-2021 */
  include("conn.php");

  $school_id= $_SESSION['school_id'];

  $filename="Branch_List_".date("YmdHis");

  $qr="select * from tbl_branch_master where school_id='$school_id'";
  $rs_result=mysql_query($qr);

  //Made same headers as present in Upload Panel for SMC-5120 on 27-01-2021 by Chaitali Solapure
  $data='SchoolID,"BranchID","Branch","Specialization","Duration","IsEnabled","DepartmentName","CourseLevel"'."\n";

  $j1=0;
        
  while($row=mysql_fetch_assoc($rs_result))
  {
  
    $j=$j1++;
  
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['ExtBranchId']=str_replace(',', ' ', $row['ExtBranchId']);
    $row['branch_Name']=str_replace(',', ' ', $row['branch_Name']);
    $row['Specialization']=str_replace(',', ' ', $row['Specialization']);
    $row['Duration']=str_replace(',', ' ', $row['Duration']);
    $row['IsEnabled']=str_replace(',', ' ', $row['IsEnabled']);
    $row['DepartmentName']=str_replace(',', ' ', $row['DepartmentName']);
    $row['Course_Name']=str_replace(',', ' ', $row['Course_Name']);
  
    $data .=  $row['school_id'].','.$row['ExtBranchId'].','.$row['branch_Name'].','.$row['Specialization'].','.$row['Duration'].','.$row['IsEnabled'].','.$row['DepartmentName'].','.$row['Course_Name'].','."\n";

  }

  ob_end_clean();
  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
  echo $data; exit(); 

?>