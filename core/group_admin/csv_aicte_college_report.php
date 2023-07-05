<?php
include("../conn.php"); 
$GroupMemId   = $_SESSION['id']; 
$sc_id= $_SESSION['school_id'];

$file = "AICTEcollegeinfoReport".date('Y-m-d');
header('Content-Type: text/csv');
header ( "Content-Disposition: attachment; filename=".$file.".csv" );
$user_CSV[0] = array('Sr.No', 'College ID', 'College Name', 'AICTE Application ID', 'AICTE Permanent ID', 'Register Date', 'Implementation Date', 'Informer Name', 'Informer Designation', 'Informer Email', 'Informer contact', 'ERP Incharge', 'ERP Incharge Contact', 'ERP Incharge Email', 'IT Incharge', 'IT Incharge Contact', 'IT Incharge Email', 'AICTE Coordinator', 'AICTE Coordinator Contact', 'AICTE Coordinator Email', 'TPO', 'TPO Contact', 'TPO Email', 'Placement Help', 'Art Incharge', 'Art Incharge Contact', 'Art Incharge Email', 'Student Incharge',  'Student Incharge Contact',  'Student Incharge Email', 'Admin Incharge', 'Admin Incharge Contact', 'Admin Incharge Email', 'Exam Incharge', 'Exam Incharge Contact', 'Exam Incharge Email', 'Other Contact Person', 'Other Contact Mobile', 'Other Contact Email');
   
    $order="aci.college_name";
    $condition = "WHERE sa.group_member_id='$GroupMemId'";
  
    if($_SESSION['CL_date_type']=="reg_date"){
        $order="aci.reg_date";
        if($_SESSION['CL_fromdate']=="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') <='".$_SESSION['CL_todate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']==""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') >'".$_SESSION['CL_fromdate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') BETWEEN '".$_SESSION['CL_fromdate']."' AND '".$_SESSION['CL_todate']."'";
        }
    
    }else if($_SESSION['CL_date_type']=="imp_date"){
        $order = "aci.impliment_date";
        if($_SESSION['CL_fromdate']=="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND aci.impliment_date <='".$_SESSION['CL_todate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']==""){
          $condition.=" AND aci.impliment_date >'".$_SESSION['CL_fromdate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND aci.impliment_date BETWEEN '".$_SESSION['CL_fromdate']."' AND '".$_SESSION['CL_todate']."'";
        }
    }

    $i = 0;
    $sql1="SELECT DISTINCT aci.college_id,aci.college_name, aci.apply_id, aci.aicte_id, date_format(aci.impliment_date,'%d-%m-%Y') as impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.erp_incharge_nm,aci.erp_incharge_mob,aci.erp_incharge_email,aci.it_incharge_nm,aci.it_incharge_mob,aci.it_incharge_email,aci.aicte_incharge_nm,aci.aicte_incharge_mob,aci.aicte_incharge_email,aci.tpo_incharge_nm,aci.tpo_incharge_mob,aci.tpo_incharge_email,aci.art_incharge_nm,aci.art_incharge_mob,aci.art_incharge_email,aci.student_incharge_nm,aci.student_incharge_mob,aci.student_incharge_email,aci.admin_incharge_nm,aci.admin_incharge_mob,aci.admin_incharge_email,aci.exam_incharge_nm,aci.exam_incharge_mob,aci.exam_incharge_email, date_format(aci.reg_date,'%d-%m-%Y') as reg_date,aci.placement_help,aci.placement_incharge_nm,aci.placement_incharge_mob,aci.placement_incharge_email from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition order by $order";
    // $sql1="select college_id, college_name, apply_id, aicte_id, date_format(impliment_date,'%d-%m-%Y') as impliment_date, informer_name, designation, email_id, phone_no, erp_incharge_nm, erp_incharge_mob, erp_incharge_email, it_incharge_nm, it_incharge_mob, it_incharge_email, aicte_incharge_nm, aicte_incharge_mob, aicte_incharge_email, tpo_incharge_nm, tpo_incharge_mob, tpo_incharge_email, art_incharge_nm, art_incharge_mob, art_incharge_email, student_incharge_nm, student_incharge_mob, student_incharge_email, admin_incharge_nm, admin_incharge_mob, admin_incharge_email, exam_incharge_nm, exam_incharge_mob, exam_incharge_email, placement_incharge_nm, placement_incharge_mob, placement_incharge_email, placement_help, date_format(reg_date,'%d-%m-%Y') as reg_date from aicte_college_info where group_member_id='$GroupMemId' AND aicte_permanent_id!='' OR aicte_application_id!='' order by school_name";
    // echo $sql1; exit;
    $arr = mysql_query($sql1);
     while ($row = mysql_fetch_array($arr)) { $i++;
        $a_link="";
        $p_link="";
        $user_CSV[$i] = array($i,$row['college_id'],$row['college_name'],$row['apply_id'],$row['aicte_id'],$row['reg_date'],$row['impliment_date'],$row['informer_name'],$row['designation'],$row['email_id'],$row['phone_no'],$row['erp_incharge_nm'],$row['erp_incharge_mob'],$row['erp_incharge_email'],$row['it_incharge_nm'],$row['it_incharge_mob'],$row['it_incharge_email'],$row['aicte_incharge_nm'],$row['aicte_incharge_mob'],$row['aicte_incharge_email'],$row['tpo_incharge_nm'],$row['tpo_incharge_mob'],$row['tpo_incharge_email'],$row['placement_help'],$row['art_incharge_nm'],$row['art_incharge_mob'],$row['art_incharge_email'],$row['student_incharge_nm'],$row['student_incharge_mob'],$row['student_incharge_email'],$row['admin_incharge_nm'],$row['admin_incharge_mob'],$row['admin_incharge_email'],$row['exam_incharge_nm'],$row['exam_incharge_mob'],$row['exam_incharge_email'],$row['placement_incharge_nm'],$row['placement_incharge_mob'],$row['placement_incharge_email']);
     }
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

?>