<?php
//hradmin_report.php
 include('conn.php');
//$group_member_id = $_SESSION['group_admin_id'];
//$date=date("Y-m-d");
//$date1=date("Y-m-d 23:59:59");

if(isset($_POST['SchoolID']))
{
     $scID = $_POST['SchoolID'];
    
     $query = "SELECT DISTINCT(Dept_Name) FROM tbl_department_master where School_ID = '$scID'" ;
    
    $que = mysql_query($query); 
    
     echo '<option value="all">All</option>'; 
    
      while($r = mysql_fetch_assoc($que))
     {  
          
          echo $deptName = $r['Dept_Name'];
          
          echo '<option value="'.$deptName.'">'.$deptName.'</option>';
     }
    exit;
    
}



 ?>

