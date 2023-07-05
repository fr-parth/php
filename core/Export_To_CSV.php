<?php
/* Author : Pranali Dalvi
* Date : 11/2/21
This file was created to download csv file for Employee Activity Summary Report (SMC-5118)
*/

include("conn.php");

$sc_id= $_SESSION['school_id'];
$where = urldecode($_GET['query']);

$query = "select s.std_complete_name,sp.sc_stud_id,SUM(sp.sc_point) as sc_point from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id where sp.school_id='$sc_id' $where group by sp.sc_stud_id order by sc_point desc";

$result = mysql_query($query);

$file = "Employee_Activity_Summary_Report_".date("Y-m-d");
$users = array();

if (mysql_num_rows($result) > 0) {
	$data = 'Sr. No.,Employee Name, Employee PRN, Assign Point'."\n";
	$i = 1;
    while ($users = mysql_fetch_assoc($result)) {
    	
    	$users['std_complete_name']=str_replace(',', ' ', $users['std_complete_name']);
        $users['sc_stud_id'] = str_replace(',', ' ', $users['sc_stud_id']);
        $users['sc_point'] = str_replace(',', ' ', $users['sc_point']);
        $data .= $i.','.$users['std_complete_name'].','.$users['sc_stud_id'].','.$users['sc_point']."\n";
        
        $i++;
       
    }
}
ob_end_clean();
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$file.'".csv"');
echo $data; exit();

?>