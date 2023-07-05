<?php
//require_once('tcpdf_include.php');
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
//$pdf = new Pdf();
$pdf->setPrintHeader(false);
//$pdf->SetAutoPageBreak(true);
// $pdf->SetAuthor('Author');
// $pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();
if(isset($_POST['submit']))
{
  $p = $_POST['xyz'];
  $exp = explode(',',$p);
   $academic_year = $exp[1];
   $teacher_id = $exp[0];
  $img = $exp[2];
   $sname = $exp[3];
  $img1 = $exp[4];
    $img2= $exp[5];
   $teacher_type= $exp[6];
   $feedback_score= $exp[7];
   //echo $school_id = $exp[2];
  $school_id=$this->session->userdata('school_id');
  $t_id=$this->session->userdata('t_id');
}
$count=count($teaching_process_det['posts']);
               foreach($teaching_process_det['posts'] as $rows)
               {
                $rows['feed360_semester_ID'];
                $student_feed=round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);
                        $temp=$temp+$student_feed;
                        $tc_feedback = round(($temp/$count),2);
               }
               $count1=count($student_feed_det['posts']);
                          foreach($student_feed_det['posts'] as $rows)
                          {
                            $avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
                                        $temp1=$temp1+$avg_stud_feed;
                                       $st_feed = round(($temp1/$count1),2);
                             $feedback_score1 = $feedback_score1 + $st_feed;
                              //echo $feedback_score1;    
                             }
                             $dept_total=0;
                            $dept_cnt=0;
                            foreach($dept_activity_det['posts'] as $rows)
                             { $dept_cnt++;
                              $dept_total+= $rows['credit_point'];
                              $dept_feed = round(($dept_total/$dept_cnt),2);
                              if($dept_total >20)
                            {
                               $dept_total=20;                              
                            }
                            }
                            $institute_total = 0;
                $institute_cnt = 0;
                foreach($institute_activity_det['posts'] as $rows) 
                  { $institute_cnt++;
                                $institute_total+=$rows['credit_point'];   
                              //($r > 10) ? echo "10" : echo $r;     
                            if($institute_total >10)
                            {
                               $institute_total=10;                     
                            }        
                    }
                     $ACR_count=count($acr_det['posts']);
                            $ACR_total = 0;
                            foreach($acr_det['posts'] as $rows) { 
                              $ACR_total+= $rows['credit_point'];
                                        $acr_feed = round(($ACR_total/$ACR_count),2);
                            }
                            $contribution_total = 0;
                            $contribution_cnt = 0;
                            foreach($society_contri_det['posts'] as $rows) { $contribution_cnt++;
                              $contribution_total+= $rows['credit_point'];
                                        $society_feed = round(($contribution_total/$contribution_cnt),2);
                              if($contribution_total >10)
                            {
                               $contribution_total=10;
                              
                            }
                            }
                        $feedback_score= $tc_feedback+$st_feed+$dept_total+$institute_total+$acr_feed+ $contribution_total;
  $pt .='<img src="'.$img2.'" style="width:60px; height:60px;">';     
  $print .='<img src="'.$img.'" style="width:60px; height:60px;">';
 $print1 .='<img src="'.$img1.'" style="width:60px; height:60px;">';
   
// $print .='<img src="$img" style="width:{40}px; height:{40}px;">';
//$print1 .='<img src="../core/scadmin_image/161863938052.jpg" style="width:{40}px; height:{40}px;">';
 // $pdf->SetDefaultMonospacedFont('PDF_FONT_MONOSPACED');
if($print!='')
{
  $print3=$print; 
}
else
{
  $print3=$print1;
}

$html = <<<EOD
  <div style="text-align:center;">
<h1>360 Feedback Report For ({$academic_year})</h1>
  </div>
  <table cellpadding="10px" style="border-spacing: 15px; width: 100%;" nobr="true">
    <tr>
        <td style="text-align:left;">$print3</td>
        <td style="text-align: center;">
             $sname
        </td>
        <td style="text-align:right;">$pt
        </td>
    </tr>
</table>
EOD;
//echo $html;
$tb = <<<EOD
  <table cellpadding="10px" border="1">
    <tr>
        <th style="border: 0.5px solid black;text-align:center;">
            Teacher Name
        </th>
        <th style="border: 0.5px solid black;text-align:center;">
            Teacher Position
        </th>
        <th style="border: 0.5px solid black;text-align:center;">
            Feedback Score
        </th>
        <th style="border: 0.5px solid black;text-align:center;">
            Academic Year
        </th>
    </tr>
    <tr>
        <td style="border: 0.5px solid black;text-align:center;">  $teacher_id</td>
        <td style="border: 0.5x solid black;text-align:center;">    $teacher_type</td>
        <td style="text-align:center; border: 0.5px solid black;"> {$feedback_score} </td>
        <td style="text-align:center; border: 0.5px solid black;"> {$academic_year}</td>
    </tr>
</table><br><br>
EOD;
$tbl =<<<EOD
<h2><span>A) Teaching Process (Max 25 Point)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="border: 0.5px solid black;text-align: center;"> Semester</th>
<th style="border: 0.5px solid black;text-align: center;"> Subject Code</th>
<th style="border: 0.5px solid black;text-align: center;"> No. of Scheduled Classes</th>
<th style="border: 0.5px solid black;text-align: center;"> No. of Actually held classes</th>
<th style="border: 0.5px solid black;text-align: center;"> Points Earned</th>
<th style="border: 0.5px solid black;text-align: center;"> Enclosure No.</th>
</tr>
EOD;
foreach($teaching_process_det['posts'] as $rows){
  $e=round((($rows['feed360_actual_classes'] /$rows['feed360_classes_scheduled'])*25),2);
$tbl.=<<<EOD
<tr nobr="true">
<td style="border: 0.5px solid black;text-align: center;"> {$rows['feed360_semester_ID']}</td>
<td style="border: 0.5px solid black;text-align: center;"> {$rows['feed360_subject_code']}</td>
<td style="border: 0.5px solid black;text-align: center;"> {$rows['feed360_classes_scheduled']}</td>
<td style="border: 0.5px solid black;text-align: center;"> {$rows['feed360_actual_classes']}</td>
<td style="border: 0.5px solid black;text-align: center;"> {$e} </td>
<td style="border: 0.5px solid black;text-align: center;"></td>
</tr>
EOD;
 }
 $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td></td>
<td></td>
<td style="border: 0.5px solid black;text-align: center;"><b> Total</b></td>
<td style="border: 0.5px solid black;text-align: center;"> {$tc_feedback}</td>
<td></td>
</tr>
</table>
EOD;
//echo $tbl;
$tbl.= <<<EOD
<h2><span>B) Student Feedback (Max 25 Point)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="border: 0.5px solid black;text-align: center;"> Semester</th>
<th style="border: 0.5px solid black;text-align: center;"> Subject Code </th>
<th style="border: 0.5px solid black;text-align: center;" > Average Student Feedback </th>
 <th style="border: 0.5px solid black;text-align: center;"> Enclosure No.</th>
</tr>
EOD;
foreach($student_feed_det['posts'] as $rows){
  $qq=$avg_stud_feed=round((($rows['stu_feed_points'])*(25/(5*$rows['count']))),2);
$tbl.=<<<EOD
<tr nobr="true">
<td style="text-align: center; border: 0.5px solid black;"> {$rows['stu_feed_semester_ID']} </td>
<td style="text-align: center; border: 0.5px solid black;"> {$rows['stud_subjcet_code']} </td>
<td style="text-align: center; border: 0.5px solid black;"> {$qq}</td>
<td style="text-align: center; border: 0.5px solid black;"></td>
</tr>
EOD;
 }
 $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td style="text-align: center; border: 0.5px solid black;"><b> Total</b></td>
<td style="text-align: center; border: 0.5px solid black;"> $st_feed</td>
<td></td>
</tr>
</table>
EOD;
$tbl.= <<<EOD
<h2>C) <span>Departmental Activity (Max Credit 20)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="text-align: center;border: 0.5px solid black;"> Semester</th>
<th style="text-align: center;border: 0.5px solid black;"> Activity Code/Name</th>
<th style="text-align: center;border: 0.5px solid black;"> Credit Point </th>
<th style="text-align: center;border: 0.5px solid black;"> Criteria</th>
 <th style="text-align: center;border: 0.5px solid black;"> Enclosure No.</th>
</tr>
EOD;
foreach($dept_activity_det['posts'] as $rows) { 
  $ww=($rows['credit_point']>20) ? $rows['credit_point']=20 : $rows['credit_point'];
$tbl.=<<<EOD
<tr nobr="true">
<td style="text-align: center;border: 0.5px solid black;"> {$rows['semester_name']} </td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['activity_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$ww}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['criteria']}</td>
<td style="text-align: center;border: 0.5px solid black;"></td>
</tr>
EOD;
 }
 $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td style="text-align: center;border: 0.5px solid black;"><b> Total</b></td>
<td style="text-align: center; border: 0.5px solid black;"> {$dept_total}</td>
<td></td>
<td></td>
</tr>
</table>
EOD;
//}
//echo $tbl2;
$tbl.= <<<EOD
<h2>D) <span>Institute Activity (Max Credit 10)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="text-align: center;border: 0.5px solid black;"> Semester</th>
<th style="text-align: center;border: 0.5px solid black;"> Activity Code/Name</th>
<th style="text-align: center;border: 0.5px solid black;"> Credit Point </th>
<th style="text-align: center;border: 0.5px solid black;"> Criteria</th>
 <th style="text-align: center;border: 0.5px solid black;"> Enclosure No.</th>
</tr>
EOD;
 foreach($institute_activity_det['posts'] as $rows) { 
  $rr=($rows['credit_point']>10) ? $rows['credit_point']=10 : $rows['credit_point'];
 $tbl.=<<<EOD
<tr nobr="true">
<td style="text-align: center;border: 0.5px solid black;"> {$rows['semester_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['activity_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rr}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['criteria']}</td>
<td></td>
</tr>
EOD;
 }
 $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td style="text-align: center;border: 0.5px solid black;"> <b> Total</b></td>
<td style="text-align: center;border: 0.5px solid black;"> $institute_total</td>
<td></td>
<td></td>
</tr>
</table>
EOD;
//echo $tbl3;
$tbl.= <<<EOD
<h2>E) <span>ACR (Max Credit 10)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="text-align: center;border: 0.5px solid black;"> Year</th>
<th style="text-align: center;border: 0.5px solid black;"> Activity</th>
<th style="text-align: center;border: 0.5px solid black;"> Credit Point </th>
<th style="text-align: center;border: 0.5px solid black;"> Criteria</th>
 <th style="text-align: center;border: 0.5px solid black;"> Enclosure No.</th>
</tr>
EOD;
foreach($acr_det['posts'] as $rows) {
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
                                          $acr_feed = round(($ACR_total/$ACR_count),2);
                                         // $feedback_score += $acr_feed;
  $tbl.=<<<EOD
<tr nobr="true">
<td style="text-align: center;border: 0.5px solid black;"> {$rows['Academic_Year']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['activity_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['credit_point']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$r}</td>
<td style="text-align: center;border: 0.5px solid black;"> $a21</td>
<td></td>
</tr>
EOD;
}
  $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td style="text-align: center;border: 0.5px solid black;"><b> Total</b></td>
<td style="text-align: center;border: 0.5px solid black;">{$acr_feed}</td>
<td></td>
<td></td>
</tr>
</table>
EOD;
//echo $tbl4;
$tbl.= <<<EOD
<h2>F) <span>Contribution To Society (Max Credit 10)</span></h2>
<table cellpadding="10px" border="1">
<tr nobr="true">
<th style="text-align: center;border: 0.5px solid black;"> Semester</th>
<th style="text-align: center;border: 0.5px solid black;"> Activity</th>
<th style="text-align: center;border: 0.5px solid black;"> Credit Point </th>
<th style="text-align: center;border: 0.5px solid black;"> Criteria</th>
 <th style="text-align: center;border: 0.5px solid black;"> Enclosure No.</th>
</tr>
EOD;
 foreach($society_contri_det['posts'] as $rows) {
  $tbl.=<<<EOD
<tr nobr="true">
<td style="text-align: center;border: 0.5px solid black;"> {$rows['semester_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['activity_name']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['credit_point']}</td>
<td style="text-align: center;border: 0.5px solid black;"> {$rows['criteria']}</td>
<td style="text-align: center;border: 0.5px solid black;"></td>
</tr>
EOD;
}
  $tbl.=<<<EOD
<tr nobr="true">
<td></td>
<td style="text-align: center;border: 0.5px solid black;"><b> Total</b></td>
<td style="text-align: center;border: 0.5px solid black;"> {$contribution_total}</td>
<td></td>
<td></td>
</tr>
</table> <br/>
EOD;
//echo $tbl5;
//$current_date = date("H:i:s d-m-Y");
$current_date = date("d-m-Y");
$current_time = date("h:i:a");
$tbl.= <<<EOD
<table cellpadding="10px">
</table>
EOD;
$tbl.= <<<EOD
<table cellpadding="px">
<tr>
<td style="color:blue;font-family: 'Dancing Script', cursive;">$teacher_id</td>
</tr>
<tr>
<td> $sname</td>
</tr>
<tr>
<td style="text-align: right;"> Time/Date: $current_time $current_date </td>
</tr>
<tr>
<td><h5 style="float:left;margin-left: 40px;"> <b style="color:purple">Powered By : Protsahan Mudra &#169; </b></h5></td>
</tr>
</table>
EOD;
//$pdf->writeHTML(0, $html.$tb.$tbl, '', 0, 'L', true, 0, false, false, 0);
$pdf->writeHTML($html.$tb.$tbl);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$file_name = "360_Feedback_Report_".$teacher_id."_".$academic_year;
$pdf->SetTitle($file_name);
//$pdf->SetAutoPageBreak(true);
$pdf->setPrintFooter(false);
$pdf->Output($file_name.'.pdf', 'I'); exit;
?>
