<?php 

include("../conn.php"); 

?>
 
<div class="container">
    
<?php 


//isset instState
if(isset($_POST['instState']))
{
    $insState  = $_POST['instState'];
    $deptList  = $_POST['allDeptName'];
    $acdYear   = $_POST['acdYear'];
    
   $GroupMemId   = $_SESSION['id'];   
     
//       //indivitual student feedback   
//        $sql1 = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2) as stuTotalPoints 
//
//        FROM tbl_student_feedback sf
//
//        LEFT JOIN tbl_school_admin tsa ON 
//        tsa.school_id = sf.stu_feed_school_id 
//        
//        LEFT JOIN tbl_academic_Year tay ON 
//        tay.school_id = sf.stu_feed_school_id
//
//        WHERE  tsa.group_member_id = '$GroupMemId' AND  sf.stu_feed_points != '0'  
//
//        GROUP BY sf.stu_feed_teacher_id 
//
//        ";
//                   
//                  
//      $que = mysql_query($sql1); 
//    
//      while($r = mysql_fetch_assoc($que))
//       {  
//          //print_r($r);
//          
//          $inStuSchoolID        = $r['school_id'];
//          $inStuSchoolName      = $r['school_name'];
//          $inStuState           = $r['scadmin_state']; 
//          $inTeaId              = $r['stu_feed_teacher_id'];
//          $stuTeaPoins          = $r['stuTotalPoints'];
//          $stuActYear           = $r['Academic_Year'];
//          $groupMemId           = $r['group_member_id'];
//          
//                  $tNd = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inStuSchoolID'";
//                   
//                  $re  = mysql_query($tNd);
//
//                  while($row = mysql_fetch_assoc($re))
//                  { 
//
//                            $inDeptName   = $row['t_dept'];
//                            $inTeaName    = $row['t_complete_name'];  
//
//                  }
//      if($inTeaId != '')
//      {
//            
//          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inStuSchoolID'");
//          $result = mysql_num_rows($sql);
//
//          if($result =="0"){ 
// 
//          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,student_feedback)VALUES('$inStuSchoolID','$inStuSchoolName','$inStuState','$inDeptName','$inTeaId','$inTeaName','$stuActYear','$groupMemId','$stuTeaPoins')";
//
//          $in = mysql_query($ins); 
//
//          }else{
//       
//           $Insins =  "UPDATE aicte_ind_feedback_summary_report
//                        SET student_feedback='$stuTeaPoins' WHERE teacher_id='$inTeaId'";
//              
//            $in = mysql_query($Insins); 
//              
//          }
//      }
//    } 
//        
//    $IndfeedTea = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 
//
//                FROM tbl_360feedback_template tp
//
//                LEFT JOIN tbl_school_admin tsa ON 
//                tsa.school_id = tp.feed360_school_id
//                
//                LEFT JOIN tbl_teacher t ON 
//                t.t_id = tp.feed360_teacher_id
//                
//                LEFT JOIN tbl_academic_Year tay ON 
//                tay.school_id = tp.feed360_school_id
//
//                WHERE tsa.group_member_id = '$GroupMemId'    
// 
//                GROUP BY tp.feed360_teacher_id
//              ";        
//                        
//                   
//       $TeaProque = mysql_query($IndfeedTea); 
//            
//    
//      while($r = mysql_fetch_assoc($TeaProque))
//       { 
//          $inTeaSchoolID        = $r['school_id'];
//          $inTeaSchoolName      = $r['school_name']; 
//          $inDeptName           = $r['t_dept'];
//          $inTeaId              = $r['t_id'];
//          $inTeaName            = $r['t_complete_name'];
//          $inState              = $r['scadmin_state'];
//          $inActYear            = $r['Academic_Year'];
//          $TeaProcessTeaPoins   = $r['tp_points'];
//          $groupMemId           = $r['group_member_id'];
//          
//          
//      if($inTeaId != '')
//      {
//          
//         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inTeaSchoolID'");
//          $result = mysql_num_rows($sql);
//
//          if($result =="0"){ 
//               
//          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,teaching_process)VALUES('$inTeaSchoolID','$inTeaSchoolName','$inState','$inDeptName','$inTeaId','$inTeaName','$inActYear','$groupMemId','$TeaProcessTeaPoins')";
//
//          $in = mysql_query($ins); 
//
//          }else{
//            
//           $TeaProsins =  "UPDATE aicte_ind_feedback_summary_report
//                        SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId'";
//              
//            $in = mysql_query($TeaProsins); 
//          }
//        }   
//    }
//        
//        
//    //activity department          
//    $IndDeptAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,
//
//                 SUM(tad.credit_point) as ActcreditPoints
//
//                 FROM tbl_360_activities_data tad
//
//                 LEFT JOIN tbl_school_admin tsa
//                 ON tad.schoolID = tsa.school_id
//                 
//                 LEFT JOIN tbl_academic_Year tay ON 
//                 tay.school_id = tad.schoolID
//
//                 where tsa.group_member_id='$GroupMemId' and tad.activity_level_id=1
//
//                 group by tad.Receiver_tID
//
//              ";                   
//
//     
//       $IndDeptAt = mysql_query($IndDeptAct); 
//          
//    
//      while($r = mysql_fetch_assoc($IndDeptAt))
//        { 
//            $inDepSchoolID        = $r['school_id'];
//            $inDepSchoolName      = $r['school_name'];
//            $inState              = $r['scadmin_state'];
//            $inTeaId              = $r['Receiver_tID']; 
//            $inActYear            = $r['Academic_Year']; 
//            $deptcPoints          = $r['ActcreditPoints'];
//            $actLevelID           = $r['activity_level_id'];
//            $groupMemId           = $r['group_member_id'];
//          
//          if($deptcPoints >= 20)
//          { 
//              $deptPoi = 20;
//              
//          }else if($deptcPoints <= 20){ 
//              
//              $deptPoi = $deptcPoints;
//          } 
// 
//                          
//                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inDepSchoolID'";
//                    $teacherName = mysql_query($sTidName); 
//                    while($ret = mysql_fetch_assoc($teacherName))
//                         { 
//                             $tdept = $ret['t_dept'];
//                             $tname = $ret['t_complete_name'];
//                         } 
//  
//          
//          if($inTeaId != '')
//          {
//              $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
//              $result = mysql_num_rows($sql);
//
//              if($result =="0"){ 
//
//              $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,dept_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";
//
//              $in = mysql_query($ins); 
//
//              }else{
//
//               $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
//                            SET dept_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
//
//                $in = mysql_query($DepProsins); 
//
//              }    
//          } 
//       } 
//        
//     //indivitual institute activity              
//     $IndInstAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,
//
//                     SUM(tad.credit_point) as IntcreditPoints
//
//                     FROM tbl_360_activities_data tad
//
//                     LEFT JOIN tbl_school_admin tsa
//                     ON tad.schoolID = tsa.school_id
//                     
//                     LEFT JOIN tbl_academic_Year tay ON 
//                     tay.school_id = tad.schoolID
//
//                     where tsa.group_member_id='$GroupMemId' and tad.activity_level_id=2
//
//                     group by tad.Receiver_tID
//
//                  ";             
//                        
//                   
//       $IndInstAt = mysql_query($IndInstAct); 
//            
//    
//        while($r = mysql_fetch_assoc($IndInstAt))
//        {  
//            $inDepSchoolID        = $r['school_id'];
//            $inDepSchoolName      = $r['school_name'];
//            $inState              = $r['scadmin_state'];
//            $inTeaId              = $r['Receiver_tID']; 
//            $inActYear            = $r['Academic_Year']; 
//            $deptcPoints          = $r['IntcreditPoints'];
//            $actLevelID           = $r['activity_level_id'];
//            $groupMemId           = $r['group_member_id'];
//          
//          if($deptcPoints >= 10)
//          { 
//              $deptPoi = 10;
//              
//          }else if($deptcPoints < 10){ 
//              
//              $deptPoi = $deptcPoints;
//          } 
// 
//                          
//                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inDepSchoolID'";
//                    $teacherName = mysql_query($sTidName); 
//                    while($ret = mysql_fetch_assoc($teacherName))
//                         { 
//                             $tdept = $ret['t_dept'];
//                             $tname = $ret['t_complete_name'];
//                         } 
//  
//         if($inTeaId != '')
//          { 
//              $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
//              $result = mysql_num_rows($sql);
//
//              if($result =="0"){
//
//              $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,inst_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";
//
//              $in = mysql_query($ins); 
//
//              }else{
//
//                  $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
//                            SET inst_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
//
//                  $in = mysql_query($DepProsins); 
//
//                } 
//           } 
//       }
//        
//        
//     //indivitual contribute to society activity              
//     $IndConToSocAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,
//
//                     SUM(tad.credit_point) as ContToSoccreditPoints
//
//                     FROM tbl_360_activities_data tad
//
//                     LEFT JOIN tbl_school_admin tsa
//                     ON tad.schoolID = tsa.school_id
//                     
//                     LEFT JOIN tbl_academic_Year tay ON 
//                     tay.school_id = tad.schoolID
//
//                     where tsa.group_member_id='$GroupMemId' and tad.activity_level_id=3
//
//                     group by tad.Receiver_tID
//
//                  ";       
//                        
//                   
//       $IndConToSotAt = mysql_query($IndConToSocAct); 
//            
//    
//        while($r = mysql_fetch_assoc($IndConToSotAt))
//        {  
//            
//            $inDepSchoolID        = $r['school_id'];
//            $inDepSchoolName      = $r['school_name'];
//            $inState              = $r['scadmin_state'];
//            $inTeaId              = $r['Receiver_tID']; 
//            $inActYear            = $r['Academic_Year']; 
//            $deptcPoints          = $r['ContToSoccreditPoints'];
//            $actLevelID           = $r['activity_level_id'];
//            $groupMemId           = $r['group_member_id'];
//          
//          if($deptcPoints >= 10)
//          { 
//              $deptPoi = 10;
//              
//          }else if($deptcPoints < 10){ 
//              
//              $deptPoi = $deptcPoints;
//          } 
// 
//                          
//                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inDepSchoolID'";
//                    $teacherName = mysql_query($sTidName); 
//                    while($ret = mysql_fetch_assoc($teacherName))
//                         { 
//                             $tdept = $ret['t_dept'];
//                             $tname = $ret['t_complete_name'];
//                         } 
//      if($inTeaId != '')
//      {
//          
//          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
//          $result = mysql_num_rows($sql);
//
//          if($result =="0"){
//             
//          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,cont_society)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";
//
//          $in = mysql_query($ins); 
//
//          }else{
//            
//            $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
//                        SET cont_society='$deptPoi' WHERE teacher_id='$inTeaId'";
//              
//             $in = mysql_query($DepProsins); 
//              
//          } 
//        }
//     }
//        
//        
//        //indivitual ACR activity              
//     $IndACRAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,
//
//                 SUM(tad.credit_point) as ActcreditPoints
//
//                 FROM tbl_360_activities_data tad
//
//                 LEFT JOIN tbl_school_admin tsa
//                 ON tad.schoolID = tsa.school_id
//                 
//                 LEFT JOIN tbl_academic_Year tay ON 
//                 tay.school_id = tad.schoolID
//
//                 where tsa.group_member_id='$GroupMemId' and tad.activity_level_id=4
//
//                 group by tad.Receiver_tID
//
//                  ";       
//                        
//                   
//       $IndACRAt = mysql_query($IndACRAct); 
//            
//    
//       while($r = mysql_fetch_assoc($IndACRAt))
//        {   
//            $inDepSchoolID        = $r['school_id'];
//            $inDepSchoolName      = $r['school_name'];
//            $inState              = $r['scadmin_state'];
//            $inTeaId              = $r['Receiver_tID']; 
//            $inActYear            = $r['Academic_Year']; 
//            $deptcPoints          = $r['ActcreditPoints'];
//            $actLevelID           = $r['activity_level_id'];
//            $groupMemId           = $r['group_member_id'];
//          
//          if($deptcPoints >= 10)
//          { 
//              $deptPoi = 10;
//              
//          }else if($deptcPoints < 10){ 
//              
//              $deptPoi = $deptcPoints;
//          } 
// 
//                          
//                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inDepSchoolID'";
//                    $teacherName = mysql_query($sTidName); 
//                    while($ret = mysql_fetch_assoc($teacherName))
//                         { 
//                             $tdept = $ret['t_dept'];
//                             $tname = $ret['t_complete_name'];
//                         } 
//  
//      if($inTeaId != '')
//      {
//          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
//          $result = mysql_num_rows($sql);
//
//          if($result =="0"){
//             
//          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,acr)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";
//
//          $in = mysql_query($ins); 
//
//          }else{
//             
//           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
//                        SET acr='$deptPoi' WHERE teacher_id='$inTeaId'";
//              
//            $in = mysql_query($DepProsins); 
//              
//          }
//      }
//    } 
    
    
     
    if($insState === 'all' && $deptList === 'all' && $acdYear === 'all')
    {  
        
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report where group_member_id='$GroupMemId' group by school_id");
          
       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
  
        
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report where group_member_id='$GroupMemId' group by school_id  order by school_id ASC  LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th> 
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++; 
                        
                       if($row > 0)
                       {
                          $total = $row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td> </td>
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.$row['student_feedback'].'</td> 
                                       <td>'.$row['teaching_process'].'</td>
                                       <td>'.$row['dept_activity'].'</td>
                                       <td>'.$row['inst_activity'].'</td>
                                       <td>'.$row['acr'].'</td>
                                       <td>'.$row['cont_society'].'</td> 
                                       <td>'.$total.'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.$row['academic_year'].'</td>
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                          $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  

                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
                                
        
    }
    
    else if($insState === 'all' && $deptList === 'all' && $acdYear != '' && $acdYear != 'all')   
    { 
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report WHERE academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td> </td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td>
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                     $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE dept_name='$deptList'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  

    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
    
    
    
    
    }
    else if($insState === 'all' && $deptList != '' && $deptList != 'all' && $acdYear === 'all')   
    { 
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE dept_name='$deptList' and group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report WHERE dept_name='$deptList' and  group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td>'.$row['dept_name'].'</td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td>
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                     $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE dept_name='$deptList'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  

    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
    
    
    
    
    }
    else if($insState === 'all' && $deptList != '' && $deptList != 'all' && $acdYear != '' && $acdYear != 'all')   
    { 
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE dept_name='$deptList' and academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report WHERE dept_name='$deptList' and academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td>'.$row['dept_name'].'</td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td>
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                     $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE dept_name='$deptList'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  

    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
    
    
    
    
    }
    
    else if($insState != '' && $insState != 'all' && $deptList === 'all' && $acdYear === 'all')   
    { 
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE scadmin_state='$insState' and group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report WHERE scadmin_state='$insState' and group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td></td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td>
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                     $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE dept_name='$deptList'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  

    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
    
    
    
    
    }
    else if($insState != '' && $insState != 'all' && $deptList === 'all' && $acdYear != '' && $acdYear != 'all')  
    {   
        
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE scadmin_state='$insState' and academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report  WHERE scadmin_state='$insState' and academic_year='$acdYear' and group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results);  
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                        
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                    <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td> </td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td> 
                                       <td>'.round(($row['academic_year']),2).'</td> 
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                        
 
                    } 
 
                           $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE scadmin_state='$insState'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  
 
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
        
        
    }
    
   else if($insState != '' && $insState != 'all' && $deptList != '' && $deptList != 'all' && $acdYear === 'all')  
    {   
        
       $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE scadmin_state='$insState' and dept_name='$deptList' and  group_member_id='$GroupMemId' group by school_id");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report  WHERE scadmin_state='$insState' and dept_name='$deptList' and group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results);  
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                        
                       if($row > 0)
                       {
                          $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                    <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td>'.$row['dept_name'].'</td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td> 
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                           $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report WHERE scadmin_state='$insState'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  
    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
        
        
    }
    
    else if($insState != '' && $insState != 'all' && $deptList != '' && $deptList != 'all' && $acdYear != '' && $acdYear != 'all')
    { 
        $per_page_results = 1000;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report WHERE scadmin_state='$insState' AND dept_name='$deptList' AND academic_year='$acdYear' AND group_member_id='$GroupMemId' group by school_id");
          
       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
 
 
    $query = ("SELECT school_id,school_name,dept_name,scadmin_state,academic_year,
    
    round(SUM(teaching_process)/COUNT(id),2) as teaching_process,
    
    round(SUM(student_feedback)/COUNT(id),2) as student_feedback,
    
    round(SUM(dept_activity)/COUNT(id),2) as dept_activity,
    
    round(SUM(inst_activity)/COUNT(id),2) as inst_activity,
    
    round(SUM(acr)/COUNT(id),2) as acr,
    
    round(SUM(cont_society)/COUNT(id),2) as cont_society,
    
    total_on_100,total_on_scale_10
    
    FROM aicte_ind_feedback_summary_report  WHERE scadmin_state='$insState' AND dept_name='$deptList' AND academic_year='$acdYear' AND  group_member_id='$GroupMemId' group by school_id order by school_id ASC LIMIT " . $this_page_first_result . ',' .$per_page_results); 
 
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th> 
                                  <th>School State</th> 
                                  <th>Student Feedback <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Teaching Process  <br/><span class="text-center">(Out Of - 25)</span></th>
                                  <th>Departmental Activities  <br/><span class="text-center">(Out Of - 20)</span></th>
                                  <th>Institute Activities  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>ACR  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Contribution To Society  <br/><span class="text-center">(Out Of - 10)</span></th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                                  <th>Academic Year</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++; 
                        
                       if($row > 0)
                       {
                          $total = $row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                           $scaleTen = $total/10;
                           
                           $teaTotal           += $row['teaching_process'];
                           $stuTotal           += $row['student_feedback'];
                           $deptTotal          += $row['dept_activity'];
                           $instTotal          += $row['inst_activity'];
                           $acrTotal           += $row['acr'];
                           $contTotal          += $row['cont_society'];
                           $totalOn100Total    += $total;
                           $totalOn10Total     += $scaleTen;
                           
                           $output .= '

                                    <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['school_id'].'</td> 
                                       <td>'.$row['school_name'].'</td>
                                       <td>'.$row['dept_name'].'</td> 
                                       <td>'.$row['scadmin_state'].'</td> 
                                       <td>'.round(($row['student_feedback']),2).'</td> 
                                       <td>'.round(($row['teaching_process']),2).'</td>
                                       <td>'.round(($row['dept_activity']),2).'</td>
                                       <td>'.round(($row['inst_activity']),2).'</td>
                                       <td>'.round(($row['acr']),2).'</td>
                                       <td>'.round(($row['cont_society']),2).'</td> 
                                       <td>'.round(($total),2).'</td>
                                       <td>'.round(($scaleTen),2).'</td>
                                       <td>'.round(($row['academic_year']),2).'</td> 
                                   </tr>


                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                       
                       
                    }
    
   
     
                        $query1 = ("SELECT COUNT(teaching_process) as teaCount,COUNT(student_feedback) as stuCount,COUNT(dept_activity) as deptCount,COUNT(inst_activity) as instCount,COUNT(acr) as acrCount,COUNT(cont_society) as cotToSocCount FROM aicte_all_feedback_summary_report  WHERE scadmin_state='$insState' AND dept_name='$deptList'"); 
 
                          $que1 = mysql_query($query1);

                          while($row1 = mysql_fetch_assoc($que1))
                           { 
                               $stuCount   = $row1['stuCount'];
                               $teaCount   = $row1['teaCount'];
                               $deptCount  = $row1['deptCount'];
                               $instCount  = $row1['instCount'];
                               $acrCount   = $row1['acrCount'];
                               $ctsCount   = $row1['cotToSocCount'];
                           }

                                           $output .= '

                                                   <tr>
                                                       <td> </td>
                                                       <td> </td> 
                                                       <td> </td>
                                                       <td> </td>  
                                                       <td>Total</td> 
                                                       <td>'.round(($stuTotal/$i),2).'</td> 
                                                       <td>'.round(($teaTotal/$i),2).'</td>
                                                       <td>'.round(($deptTotal/$i),2).'</td>
                                                       <td>'.round(($instTotal/$i),2).'</td>
                                                       <td>'.round(($acrTotal/$i),2).'</td>
                                                       <td>'.round(($contTotal/$i),2).'</td> 
                                                       <td>'.round(($totalOn100Total/$i),2).' </td>
                                                       <td>'.round(($totalOn10Total/$i),2).'</td>
                                                   </tr>

                                           ';  
    
                  
                           
             $output .= '</table>';
 
             echo $output; 
       
                    
  
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'all_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
                                
                                
            }
    
}
    ?>
     
      
          
           </div>        
         