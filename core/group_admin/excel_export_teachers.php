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
// $filename="Teachers_List".date("d-m-Y");
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/ 

$s_query="SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,sa.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name,t.t_password FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id where $where group by t.t_complete_name order by sa.school_name $Limit";
// echo $s_query; exit;
$query1= mysql_query($s_query);
echo '<table>
                <thead>
                 <tr>
                    <th style="border:1px solid #000;"> Sr. No.</th>
                    <th style="border:1px solid #000;"> Teacher Name </th>
                    <th style="border:1px solid #000;"> School ID </th>
                    <th style="border:1px solid #000;"> School Name </th>
                    <th style="border:1px solid #000;"> Email ID </th>
                    <th style="border:1px solid #000;"> Teacher Id </th>
                    <th style="border:1px solid #000;"> Password </th> 
                    <th style="border:1px solid #000;"> Mobile </th>
                   
                 </tr>
                </thead>';
                     $i = 1;
                            //$sql="select * from tbl_school_admin where group_member_id = '$group_member_id' order by id";
                            //echo $sql;    
                            //$arr = mysql_query("$sql");
                     while ($row = mysql_fetch_array($query1)) {
                            $teacher_id = $row['id'];
                    echo '<tr> 
                        <td style="text-align:right; border:1px solid #000;"><b>'. $i.'</b></td>
                        <td style="text-align:left; border:1px solid #000;"><b>'. $row['t_complete_name'].'</b></td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['school_id'].'</td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['school_name'].'</td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['t_email'].' </td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['t_id'].' </td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['t_password'].' </td>
                        <td style="text-align:left; border:1px solid #000;">'. $row['t_phone'].' </td>
                    </tr>';
                     $i++;
                            }
           echo '</table>';
?>