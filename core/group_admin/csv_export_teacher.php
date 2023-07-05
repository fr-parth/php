<?php 
include("../conn.php");
if(isset($_GET['gid'])){
    $group_member_id = $_GET['gid'];
    $g_sql="SELECT group_name FROM tbl_cookieadmin where id='$group_member_id'";
    $g_query= mysql_query($g_sql);
    $g_row= mysql_fetch_assoc($g_query);
    $group_name=$g_row['group_name'];
$where =  "t.group_member_id = '$group_member_id'";
$filename="Teachers_List-of-$group_name".date("d-m-Y");

}
if(isset($_GET['sid']) && $_GET['sid']!=''){
    $school_id = $_GET['sid'];
    $sc_sql="SELECT school_name FROM tbl_school_admin where school_id='$school_id'";
    $sc_query= mysql_query($sc_sql);
    $sc_row= mysql_fetch_assoc($sc_query);
    $school_name=str_replace(' ', '-',$sc_row['school_name']);
$where .=  " AND t.school_id = '$school_id'";
$filename="Teachers_List-of-$school_name".date("d-m-Y");

} 
if($_GET['slmt']!="" && $_GET['elmt']!=""){
            $start=((int)$_GET['slmt']-1);
            $Limit= "LIMIT ".$start.",".$_GET['elmt'];
        }
        else if($_GET['slmt']!="" && $_GET['elmt']==""){
            $Limit= "LIMIT ".$_GET['slmt'];
        }
        else{$Limit= "";}   

$s_query="SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,sa.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id where $where group by t.t_id $Limit";
// echo $s_query; exit;
$query1= mysql_query($s_query);

$data = 'Sr. No.,"Teacher Name","School ID","School Name","Email ID","Teacher Id","Password","Mobile"'."\n";
$i = 1;
while ($row = mysql_fetch_array($query1)) {
    $row['school_name']=str_replace(',', ' ', $row['school_name']);
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['t_complete_name']=str_replace(',', ' ', $row['t_complete_name']);
    $row['t_email']=str_replace(',', ' ', $row['t_email']);
  $data .=  $i.','.$row['t_complete_name'].','.$row['school_id'].','.$row['school_name'].','.$row['t_email'].','.$row['t_id'].','.$row['t_password'].','. $row['t_phone']."\n";
$i++;}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit();
?>