<?php 
include ("conn.php");
// include('mpdf/mpdf.php');
// $mpdf=new mPDF();
// $baseurl = $_SERVER['SERVER_NAME'];
// echo $baseurl;exit;
// echo $GLOBALS['URLNAME'];exit;
if(isset($_POST['submit']))
{
    $p = $_POST['360_feedback'];
    $exp = explode(',',$p);
    $academic_year = $exp[0];
    $teacher_id = $exp[1];
    $school_id = $exp[2];
    $sc_logo = $exp[3];
    $aicte = $exp[4];
}  
$sql = mysql_query("select * from tbl_teacher where t_id = '$teacher_id' and school_id = '$school_id' ");
$res = mysql_fetch_array($sql);
$t_name = $res['t_complete_name'];



//api call starts here
$url = $GLOBALS['URLNAME']."/core/Version6/360_feedback_report_api.php";
// echo $url;exit;

    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"teaching_process",
                "limit"=>"" );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $teaching_process_det = json_decode($arr,TRUE);
    
//student feedback

    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"student_feedback",
                "limit"=>""  );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $student_feed_det = json_decode($arr,TRUE); 
//dept activity

    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"departmental_activity",
                "limit"=>""  );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $dept_activity_det = json_decode($arr,TRUE); 
//institute

    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"institute_activity",
                "limit"=>""  );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $institute_activity_det = json_decode($arr,TRUE); 
//acr
    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"ACR",
                "limit"=>""  );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $acr_det = json_decode($arr,TRUE); 

//society
    $data = array("school_id"=>$school_id,
                "teacher_id"=>$teacher_id,
                "academic_year"=>$academic_year,
                "entity_key"=>"society_contribution",
                "limit"=>""  );
    $data_string = json_encode($data); 
    $arr = post_function($url,$data_string);
    $society_contri_det = json_decode($arr,TRUE); 


                    //teaching process = avg
                    $count=count($teaching_process_det['posts']);
                    foreach($teaching_process_det['posts'] as $rows){
                     $student_feed=round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);
     
                             $temp=$temp+$student_feed;
                             $tc_feedback = round(($temp/$count),2);
                    }
                    if($tc_feedback >25)
                        {
                          
                           $teac_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Teaching Process' ");
                           $teac_res = mysql_fetch_array($teac_max_sql);
                           $tc_feedback = $teac_res['total_points'];
                            
                        }
                    
                    //student feedback = avg
                    $count1=count($student_feed_det['posts']);
                               foreach($student_feed_det['posts'] as $rows){
                                 $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
                                             $temp1=$temp1+$avg_stud_feed;
                                              $st_feed = round(($temp1/$count1),2);
                               
                                  }
                                  if($st_feed >25)
                                  {
                                  
                                  $stud_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Students Feedback' ");
                                  $stud_res = mysql_fetch_array($teac_max_sql);
                                  $st_feed = $stud_res['total_points'];
                                  }
                               
                                  //dept feedback = sum
                                  $dept_total=0;
                                 foreach($dept_activity_det['posts'] as $rows) { ;
                                   $dept_total+= $rows['credit_point'];
                                   $dept_feed = round(($dept_total),2);
                                 }
                                 if($dept_feed >20)
                                       {
                                          // $inst_feed=10;
                                          $dept_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Departmental Activities' ");
                                          $dept_res = mysql_fetch_array($dept_max_sql);
                                          $dept_feed = $dept_res['total_points'];
                                           //echo $inst_feed ;
                                       }

                                 //institute feedback = sum
                                 $institute_total = 0;
                     foreach($institute_activity_det['posts'] as $rows) { 
     
                                     $institute_total+=$rows['credit_point'];
                                   $inst_feed = round(($institute_total),2); 
                               
                                     
                                 if($inst_feed >10)
                                 {
                                    // $inst_feed=10;
                                    $inst_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Institute Activities' ");
                                    $inst_res = mysql_fetch_array($inst_max_sql);
                                    $inst_feed = $inst_res['total_points'];
                                 }
 
                         }
                         //acr = avg
                          $ACR_count=count($acr_det['posts']);
                                 $ACR_total = 0;
                                 foreach($acr_det['posts'] as $rows) { 
                                   $ACR_total+= $rows['credit_point'];
                                             $acr_feed = round(($ACR_total/$ACR_count),2);
                                 }
                                 if($acr_feed >10)
                                 {
                                    // $inst_feed=10;
                                    $acr_max_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'ACR' ");
                                    $acr_res = mysql_fetch_array($acr_max_sql);
                                    $acr_feed = $acr_res['total_points'];
                                     //echo $inst_feed ;
                                 }

                                 //society contribution = sum
                                //  $contribution_total = ;
                                 foreach($society_contri_det['posts'] as $rows) { 
                                   $contribution_total+= $rows['credit_point'];
                                            //  $society_feed = round(($contribution_total/$contribution_cnt),2);
                                 }
                                 if($contribution_total > 10)
                                 {
                                  $soc_sql = mysql_query("select total_points from tbl_360activity_level where actL360_activity_level = 'Contribution to Society' ");
                                  $soc_res = mysql_fetch_array($soc_sql);
                                  $contribution_total = $soc_res['total_points'];
                                  }
     
     
                              $feedback_score= $tc_feedback + $st_feed + $dept_feed + $inst_feed + $acr_feed + $contribution_total ;
//api call ends here



//sql for teacher details
$t_sql =mysql_query("SELECT a.Academic_Year,a.Year,t.t_complete_name,(CASE WHEN t.t_emp_type_pid='133' THEN 'Teacher'
                            WHEN (t.t_emp_type_pid='134' or t.t_emp_type_pid='133')  THEN 'Teacher'
                            WHEN t.t_emp_type_pid='135' THEN 'HOD'
                            WHEN t.t_emp_type_pid='137' THEN 'Principal'
                            ELSE 'Non-Teacher' END) as teacher_type
                            FROM tbl_teacher t
                            JOIN tbl_academic_Year a
                            on t.school_id=a.school_id
                            WHERE a.Enable='1' and t.school_id='$school_id' AND t.t_id='$teacher_id' group by t.t_id");
$rows = mysql_fetch_array($t_sql);
//sql for teacher ends here

//sql for school details 
// echo "SELECT * from tbl_school_admin where school_id = '$school_id' ";exit;
$sql = mysql_query("SELECT * from tbl_school_admin where school_id = '$school_id' ");
$res = mysql_fetch_array($sql);
$principal_name = $res['name'];
$school_name = $res['school_name'];
// $sc_logo = $res['img_path'];
// echo $GLOBALS['URLNAME'].'/'.$sc_logo;
// exit;


// if($sc_logo == '')
// {
//     $school_logo = '/Assets/images/avatar/avatar_2x.png'; 
// }
// else
// {
//     $school_logo = '/core/'.$sc_logo;
// }
// echo $GLOBALS['URLNAME'].$school_logo;
// echo "<br>";
// echo $GLOBALS['URLNAME']."/core/scadmin_image/aicte_logo.jpg";
// exit;

// echo $school_logo;exit;

include('mpdf/mpdf.php');
$mpdf=new mPDF();
// $mpdf->showImageErrors = true;
$html="<html><head>
<link rel='preconnect' href='https://fonts.googleapis.com'>
<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
<link href='https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap' rel='stylesheet'>
</head><body style='border: 5px solid red';><div align ='center'>

<table cellpadding='10px' style='border-spacing: 15px; width: 100%;'>
    <tr>
        <td>
            <img src=".$sc_logo." height='70'  width='70' style='border-radius: 70%;'  class='preview'/>
        </td>
        <td align='center' >
            <h3>360 Feedback Report (".$academic_year.")</h3><br>".$school_name."
        </td>
        <td align='right' >
            <img src=".$aicte." width='70' height='70' class='preview' />
        </td>
    </tr>
</table>
<table  cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>    
    <tr>
        <th style='border: 0.5px solid black;'>
            Teacher Name
        </th>
        <th style='border: 0.5px solid black;'>
            Feedback Score
        </th>
        <th style='border: 0.5px solid black;'>
            Teacher Position
        </th>
        <th style='border: 0.5px solid black;'>
            Academic Year
        </th>
    </tr>
    <tr>
        <td align='center' style='border: 0.5px solid black;'>".$rows['t_complete_name']."</td>
        <td align='center' style='border: 0.5px solid black;'>".$feedback_score."</td>
        <td align='center' style='border: 0.5x solid black;'>".$rows['teacher_type']."</td>
        <td align='center' style='border: 0.5px solid black;'>".$academic_year."</td>
    </tr>

</table><br><br>

<h2><span>A) Teaching Process (Max 25 Point)</span></h2>
<table  cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>    
    <tr>
        <th style='border: 0.5px solid black;'>
            Semester
        </th>
        <th style='border: 0.5px solid black;'>
            Subject Code
        </th>
        <th style='border: 0.5px solid black;'>
            No. of Scheduled Classes
        </th>
        <th style='border: 0.5px solid black;'>
            No. of Actually held classes
        </th>
        <th style='border: 0.5px solid black;'>
            Points Earned
        </th>
        <th style='border: 0.5px solid black;'>
            Enclosure No.
        </th>
    </tr>";   
    
$loop1 = '';
foreach($teaching_process_det['posts'] as $rows){
    $loop1 .="<tr><td style='border: 0.5px solid black;'>".$rows['feed360_semester_ID']."</td>
                     <td style='border: 0.5px solid black; text-align: center;'>".$rows['feed360_subject_code']."</td>
                     <td style='border: 0.5px solid black; text-align: center;'>".$rows['feed360_classes_scheduled']."</td> 
                     <td style='border: 0.5px solid black;text-align: center;'>".$rows['feed360_actual_classes']."</td>
                     <td style='border: 0.5px solid black;text-align: center;'>".$student_feed=round((($rows['feed360_actual_classes']/$rows['feed360_classes_scheduled'])*25),2)."</td>
                     <td style='border: 0.5px solid black;'></td></tr>";
                    }
                    $loop1 .=  "<tr><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td style='border: 0.5px solid black;'><td align='center' style='border: 0.5px solid black;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$tc_feedback."</td><td style='border: 0.5px solid black;'></td></tr></table>
                    <br><br>";
$loop1 .="<h2><span>B) Student Feedback (Max 25 Point)</span></h2>
<table cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>
    <tr>
       <th style='border: 0.5px solid black;'>
            Semester
       </th>
       <th style='border: 0.5px solid black;'>
            Subject Code
       </th>
       <th style='border: 0.5px solid black; width:25%;'>
            Average Student Feedback
       </th>
       <th style='border: 0.5px solid black;'>
            Enclosure No.
       </th>
    </tr>";
//student feedback table starts here
foreach($student_feed_det['posts'] as $rows){
    $loop1 .="<tr><td style='border: 0.5px solid black;'>".$rows['stu_feed_semester_ID']."</td>
            <td style='border: 0.5px solid black; text-align: center;'>".$rows['stud_subjcet_code']."</td>
            <td style='border: 0.5px solid black; text-align: center;'>".$avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5 * $rows['count']))),2)."</td>
            <td style='border: 0.5px solid black;'></td></tr>"; 
    }
    $loop1 .= "<tr><td style='border: 0.5px solid black; text-align: center;'></td><td style='border: 0.5px solid black; text-align: center;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$st_feed."</td><td style='border: 0.5px solid black; text-align: center;'></td></tr></table><br><br>";

//dept activity
$loop1 .= "<h2>C) <span>Departmental Activity (Max Credit 20)</span></h2>
<table cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>
    <tr>
       <th style='border: 0.5px solid black;'>
            Semester
       </th>
       <th style='border: 0.5px solid black;'>
            Activity Code/Name
       </th>
       <th style='border: 0.5px solid black; width:25%;'>
            Credit Point	
       </th>
       <th style='border: 0.5px solid black;'>
            Criteria
       </th>
       <th style='border: 0.5px solid black;'>
            Enclosure NO.
       </th>
    </tr>";  
    // print_r($dept_activity_det);exit;
foreach($dept_activity_det['posts'] as $rows){
    $loop1 .= "<tr><td style='border: 0.5px solid black;'>".$rows['semester_name']."</td>
                <td style='border: 0.5px solid black;'>".$rows['activity_name']."</td>
                <td style='border: 0.5px solid black; text-align: center;'>".$rows['credit_point']."</td>
                <td style='border: 0.5px solid black;'>".$rows['criteria']."</td>
                <td style='border: 0.5px solid black;'></td></tr>";
            }
            
$loop1 .= "<tr><td style='border: 0.5px solid black;'></td><td align='center' style='border: 0.5px solid black;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$dept_feed."</td><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td></tr></table><br><br>";

//inst activity
$loop1 .= "<h2>D) <span>Institute Activity (Max Credit 10)</span></h2>
<table cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>
    <tr>
       <th style='border: 0.5px solid black;'>
            Semester
       </th>
       <th style='border: 0.5px solid black;'>
            Activity
       </th>
       <th style='border: 0.5px solid black; width:25%;'>
            Credit Point	
       </th>
       <th style='border: 0.5px solid black;'>
            Criteria
       </th>
       <th style='border: 0.5px solid black;'>
            Enclosure NO.
       </th>
    </tr>";
foreach($institute_activity_det['posts'] as $rows){
        $loop1 .= "<tr><td style='border: 0.5px solid black;'>".$rows['semester_name']."</td>
                    <td style='border: 0.5px solid black;'>".$rows['activity_name']."</td>
                    <td style='border: 0.5px solid black; text-align: center;'>".$rows['credit_point']."</td>
                    <td style='border: 0.5px solid black;'>".$rows['criteria']."</td>
                    <td style='border: 0.5px solid black;'></td></tr>";
                }
$loop1 .= "<tr><td style='border: 0.5px solid black;'></td><td align='center' style='border: 0.5px solid black;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$inst_feed."</td><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td></tr></table><br><br>";

$loop1 .="<h2>E) <span>ACR (Max Credit 10)</span></h2>
<table cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>
    <tr>
       <th style='border: 0.5px solid black;'>
            Year
       <th style='border: 0.5px solid black;'>
            Activity
       </th>
       <th style='border: 0.5px solid black; width:25%;'>
            Credit Point	
       </th>
       <th style='border: 0.5px solid black;'>
            Criteria
       </th>
       <th style='border: 0.5px solid black;'>
            Enclosure NO.
       </th>
    </tr>";
    foreach($acr_det['posts'] as $rows){
        if($rows['credit_point'] == 10)
                                            $r =  "Extraordinary" ;
                                            else if($rows['credit_point'] == 9)
                                            $r = "Excellent" ;
                                            else if($rows['credit_point'] == 8)
                                            $r = "Very Good " ;
                                            else if($rows['credit_point'] == 7)
                                            $r = "Good " ;
                                            else
                                            $r = "Satisfactory" ;
                                        
        // if()                                    
        $loop1 .= "<tr><td style='border: 0.5px solid black;'>".$rows['Academic_Year']."</td>
                    <td style='border: 0.5px solid black;'>".$rows['activity_name']."</td>
                    <td style='border: 0.5px solid black; text-align: center;'>".$rows['credit_point']."</td>
                    <td style='border: 0.5px solid black;'>".$r."</td>
                    <td style='border: 0.5px solid black;'></td></tr>";
                }
$loop1 .= "<tr><td style='border: 0.5px solid black;'></td><td align='center' style='border: 0.5px solid black;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$acr_feed."</td><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td></tr></table><br><br>";
          
//society
$loop1 .="<h2>F) <span>Contribution To Society (Max Credit 10)</span></h2>
<table cellpadding='10px' style='border-spacing:px; width: 100%; border: 0.5px solid black;'>
    <tr>
       <th style='border: 0.5px solid black;'>
            Semester
       <th style='border: 0.5px solid black;'>
            Activity
       </th>
       <th style='border: 0.5px solid black; width:25%;'>
            Credit Point	
       </th>
       <th style='border: 0.5px solid black;'>
            Criteria
       </th>
       <th style='border: 0.5px solid black;'>
            Enclosure NO.
       </th>
    </tr>";
    foreach($society_contri_det['posts'] as $rows){
        $loop1 .= "<tr><td style='border: 0.5px solid black;'>".$rows['semester_name']."</td>
                    <td style='border: 0.5px solid black;'>".$rows['activity_name']."</td>
                    <td style='border: 0.5px solid black; text-align: center;'>".$rows['credit_point']."</td>
                    <td style='border: 0.5px solid black;'>".$rows['criteria']."</td>
                    <td style='border: 0.5px solid black;'></td></tr>";
                }
$loop1 .= "<tr><td style='border: 0.5px solid black;'></td><td align='center' style='border: 0.5px solid black;'><b>Total</b></td><td style='border: 0.5px solid black; text-align: center;'>".$contribution_total."</td><td style='border: 0.5px solid black;'></td><td style='border: 0.5px solid black;'></td></tr></table><br><br>";


$current_date = date("d-m-Y");
$current_time = date("h:i:a");
// echo $current_date;exit;
$loop1 .= "<table style='width: 100%;'><tr><td align='left'>".$principal_name."</td><td align='right'>Time/Date:".$current_time.' '.$current_date."</td></tr>
            <tr><td>".$school_name."</td></tr></table>
            <h5 align='center' style='color: blue;'>Powered by: Protsahan Mudra&#169;</h5></body></html>";

$file_name = "360_Feedback_Report_".$t_name."_".$academic_year;
$mpdf->writeHTML($html.$loop1);
$mpdf->SetTitle($file_name);
// $mpdf->WriteHTML($academic_year.','.$teacher_id.','.$school_id);
// $mpdf->WriteHTML($html);
$mpdf->Output($file_name.'.pdf', 'I');   exit;
?>

