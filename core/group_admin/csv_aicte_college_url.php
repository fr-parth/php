<?php
include("../conn.php"); 
$GroupMemId   = $_SESSION['id']; 
$sc_id= $_SESSION['school_id'];

$file = date('d-m-Y')."-AICTEcollegeinfo";
header('Content-Type: text/csv');
header ( "Content-Disposition: attachment; filename=".$file.".csv" );
$user_CSV[0] = array('Sr.No', 'Application ID', 'Permanent ID', 'College Name', 'Email', 'Application ID URL', 'Permanent ID URL');

    $i = 0;
    $sql1="select school_id, school_name, aicte_application_id, aicte_permanent_id, email from tbl_school_admin where group_member_id='$GroupMemId' AND aicte_permanent_id!='' OR aicte_application_id!='' order by school_name";
    $arr = mysql_query($sql1);
     while ($row = mysql_fetch_array($arr)) { $i++;
        $a_link="";
        $p_link="";
        if($row['aicte_application_id']!=''){
            $a_link=$server_name.'/AICTEcollegeinfo/id/'.$row['aicte_application_id'];
        }
        if($row['aicte_permanent_id']!=''){
            $p_link=$server_name.'/AICTEcollegeinfo/pid/'.$row['aicte_permanent_id'];
        }
        $user_CSV[$i] = array($i,$row['aicte_application_id'],$row['aicte_permanent_id'],$row['school_name'],$row['email'],$a_link,$p_link);
     }
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

?>