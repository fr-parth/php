 <?php 
 
  include("../conn.php");  
error_reporting(0);
  $group_member_id=$_SESSION['id'];  
 
  if(isset($_POST['schoolID']))
  {
         $schoolID =  $_POST['schoolID'];
         $acadYear =  $_POST['acdYear'];
  }
 
 
if($schoolID === 'all' && $acadYear === 'all')
{ 
        //indivitual student feedback   
        $sql1 = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2) as stuTotalPoints 
        FROM tbl_student_feedback sf
        INNER JOIN tbl_school_admin tsa ON 
        tsa.school_id = sf.stu_feed_school_id   
        INNER JOIN tbl_academic_Year tay ON 
        tay.school_id = sf.stu_feed_school_id
        WHERE  tsa.group_member_id = '$group_member_id' AND  sf.stu_feed_points != '0'  
        GROUP BY sf.stu_feed_teacher_id 
        ";
                      
      $que = mysql_query($sql1); 
    
      while($r = mysql_fetch_assoc($que))
       {  
        //print_r($r);exit;
          
          $inStuSchoolID        = $r['school_id'];
          $inStuSchoolName      = $r['school_name'];
          $inStuState           = $r['scadmin_state']; 
          $inTeaId              = $r['stu_feed_teacher_id'];
          $stuTeaPoins          = $r['stuTotalPoints'];
          $stuActYear           = $r['Academic_Year'];
          $groupMemId           = $r['group_member_id'];
          
                  $tNd = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                   
                  $re  = mysql_query($tNd);

                  while($row = mysql_fetch_assoc($re))
                  { 

                            $inDeptName   = $row['t_dept'];
                            $inTeaName    = $row['t_complete_name'];  

                  }
      if($inTeaId != '')
      {
            
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inStuSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
 
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,student_feedback)VALUES('$inStuSchoolID','$inStuSchoolName','$inStuState','$inDeptName','$inTeaId','$inTeaName','$stuActYear','$groupMemId','$stuTeaPoins')";

          $in = mysql_query($ins); 

          }else{
       
           $Insins =  "UPDATE aicte_ind_feedback_summary_report
                        SET student_feedback='$stuTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($Insins); 
              
          }
      }
    }        
              
 
     //indivitual teaching process              
     $IndfeedTea = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 

                FROM tbl_360feedback_template tp

                LEFT JOIN tbl_school_admin tsa ON 
                tsa.school_id = tp.feed360_school_id
                
                LEFT JOIN tbl_teacher t ON 
                t.t_id = tp.feed360_teacher_id
                
                LEFT JOIN tbl_academic_Year tay ON 
                tay.school_id = tp.feed360_school_id

                WHERE tsa.group_member_id = '$group_member_id'    
 
                GROUP BY tp.feed360_teacher_id
              ";        
                        
                   
       $TeaProque = mysql_query($IndfeedTea); 
            
    
      while($r = mysql_fetch_assoc($TeaProque))
       { 
          $inTeaSchoolID        = $r['school_id'];
          $inTeaSchoolName      = $r['school_name']; 
          $inDeptName           = $r['t_dept'];
          $inTeaId              = $r['t_id'];
          $inTeaName            = $r['t_complete_name'];
          $inState              = $r['scadmin_state'];
          $inActYear            = $r['Academic_Year'];
          $TeaProcessTeaPoins   = $r['tp_points'];
          $groupMemId           = $r['group_member_id'];
          
          
      if($inTeaId != '')
      {
          
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inTeaSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,teaching_process)VALUES('$inTeaSchoolID','$inTeaSchoolName','$inState','$inDeptName','$inTeaId','$inTeaName','$inActYear','$groupMemId','$TeaProcessTeaPoins')";

          $in = mysql_query($ins); 

          }else{
            
           $TeaProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($TeaProsins); 
          }
        }   
    }
                   
    
    //activity department          
    $IndDeptAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                 SUM(tad.credit_point) as ActcreditPoints

                 FROM tbl_360_activities_data tad

                 LEFT JOIN tbl_school_admin tsa
                 ON tad.schoolID = tsa.school_id
                 
                 LEFT JOIN tbl_academic_Year tay ON 
                 tay.school_id = tad.schoolID

                 where tsa.group_member_id='$group_member_id' and tad.activity_level_id='1'

                 group by tad.Receiver_tID

              ";                   

     
       $IndDeptAt = mysql_query($IndDeptAct); 
          
    
      while($r = mysql_fetch_assoc($IndDeptAt))
        { 
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ActcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 20)
          { 
              $deptPoi = 20;
              
          }else if($deptcPoints <= 20){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
          
          if($inTeaId != '')
          {
              $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
              $result = mysql_num_rows($sql);

              if($result =="0"){ 

              $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,dept_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

              $in = mysql_query($ins); 

              }else{

               $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                            SET dept_activity='$deptPoi' WHERE teacher_id='$inTeaId'";

                $in = mysql_query($DepProsins); 

              }    
          }
          
          
       }       
  
     //indivitual institute activity              
     $IndInstAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as IntcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tad.schoolID

                     where tsa.group_member_id='$group_member_id' and tad.activity_level_id='2'

                     group by tad.Receiver_tID

                  ";             
                        
                   
       $IndInstAt = mysql_query($IndInstAct); 
            
    
        while($r = mysql_fetch_assoc($IndInstAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['IntcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
         if($inTeaId != '')
          { 
              $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
              $result = mysql_num_rows($sql);

              if($result =="0"){

              $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,inst_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

              $in = mysql_query($ins); 

              }else{

                  $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                            SET inst_activity='$deptPoi' WHERE teacher_id='$inTeaId'";

                  $in = mysql_query($DepProsins); 

                }
             
           }
             
       }               
           
       
                   
                   
      //indivitual contribute to society activity              
     $IndConToSocAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as ContToSoccreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tad.schoolID

                     where tsa.group_member_id='$group_member_id' and tad.activity_level_id='3'

                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndConToSotAt = mysql_query($IndConToSocAct); 
            
    
        while($r = mysql_fetch_assoc($IndConToSotAt))
        {  
            
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ContToSoccreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
      if($inTeaId != '')
      {
          
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,cont_society)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins); 

          }else{
            
            $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET cont_society='$deptPoi' WHERE teacher_id='$inTeaId'";
              
             $in = mysql_query($DepProsins); 
              
          }
          
        }
    }               
         
    
     //indivitual ACR activity   //SUM(tad.credit_point) as ActcreditPoints           
     $IndACRAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                 tad.credit_point as ActcreditPoints

                 FROM tbl_360_activities_data tad

                 LEFT JOIN tbl_school_admin tsa
                 ON tad.schoolID = tsa.school_id
                 
                 LEFT JOIN tbl_academic_Year tay ON 
                 tay.school_id = tad.schoolID

                 where tsa.group_member_id='$group_member_id' and tad.activity_level_id='4'

                 group by tad.Receiver_tID

                  ";       
                        
                   
       $IndACRAt = mysql_query($IndACRAct); 
            
    
       while($r = mysql_fetch_assoc($IndACRAt))
        {   
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ActcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,acr)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins); 

          }else{
             
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET acr='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins); 
              
          }
      }
    }
     
     echo "Successfully Recalculate all 360 degree feedback...Please visit to 'AICTE feedback summary'";  
     exit;
}
      


else if($schoolID === 'all' && $acadYear != 'all' && $acadYear != '')
{
        //indivitual student feedback   
        $sql1 = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2)  as stuTotalPoints 

        FROM tbl_student_feedback sf

        LEFT JOIN tbl_school_admin tsa ON 
        tsa.school_id = sf.stu_feed_school_id
        
        LEFT JOIN tbl_academic_Year tay ON 
        tay.school_id = sf.stu_feed_school_id
 
        WHERE  tsa.group_member_id = '$group_member_id' AND  sf.stu_feed_points != '0' AND tay.Academic_Year = '".$acadYear."' 
 
        GROUP BY sf.stu_feed_teacher_id 

               ";
                   
                  
      $que = mysql_query($sql1); 
    
      while($r = mysql_fetch_assoc($que))
       {  
          $inStuSchoolID        = $r['school_id'];
          $inStuSchoolName      = $r['school_name'];
          $inStuState           = $r['scadmin_state']; 
          $inTeaId              = $r['stu_feed_teacher_id'];
          $stuTeaPoins          = $r['stuTotalPoints'];
          $stuActYear           = $r['Academic_Year'];
          $groupMemId           = $r['group_member_id'];
          
                  $tNd = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                   
                  $re  = mysql_query($tNd);

                  while($row = mysql_fetch_assoc($re))
                  { 

                            $inDeptName   = $row['t_dept'];
                            $inTeaName    = $row['t_complete_name'];  

                  } 
          
      if($inTeaId != '')
       {
            
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inStuSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
 
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,student_feedback)VALUES('$inStuSchoolID','$inStuSchoolName','$inStuState','$inDeptName','$inTeaId','$inTeaName','$stuActYear','$groupMemId','$stuTeaPoins')";

          $in = mysql_query($ins);
           
              

          }else{
       
           $Insins =  "UPDATE aicte_ind_feedback_summary_report
                        SET student_feedback='$stuTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($Insins);
              
          }
        }   
    }        
              
 
     //indivitual teaching process              
     $IndfeedTea = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id ,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 

                FROM tbl_360feedback_template tp

                LEFT JOIN tbl_school_admin tsa ON 
                tsa.school_id = tp.feed360_school_id
                
                LEFT JOIN tbl_teacher t ON 
                t.t_id = tp.feed360_teacher_id
                
                LEFT JOIN tbl_academic_Year tay ON 
                tay.school_id = tp.feed360_school_id
 
                WHERE tsa.group_member_id = '$group_member_id' AND tay.Academic_Year = '".$acadYear."'    
 
                GROUP BY tp.feed360_teacher_id
              ";        
                        
                   
       $TeaProque = mysql_query($IndfeedTea); 
            
    
      while($r = mysql_fetch_assoc($TeaProque))
       { 
          $inTeaSchoolID        = $r['school_id'];
          $inTeaSchoolName      = $r['school_name']; 
          $inDeptName           = $r['t_dept'];
          $inTeaId              = $r['t_id'];
          $inTeaName            = $r['t_complete_name'];
          $inState              = $r['scadmin_state'];
          $inActYear            = $r['Academic_Year'];
          $TeaProcessTeaPoins   = $r['tp_points'];
          $groupMemId           = $r['group_member_id'];
          
      if($inTeaId != '')
      {
          
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inTeaSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,teaching_process)VALUES('$inTeaSchoolID','$inTeaSchoolName','$inState','$inDeptName','$inTeaId','$inTeaName','$inActYear','$groupMemId','$TeaProcessTeaPoins')";

          $in = mysql_query($ins); 

          }else{
            
           $TeaProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($TeaProsins);
            
             }
        }   
    }
                   
    
    //activity department          
    $IndDeptAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                 SUM(tad.credit_point) as ActcreditPoints

                 FROM tbl_360_activities_data tad

                 LEFT JOIN tbl_school_admin tsa
                 ON tad.schoolID = tsa.school_id
                 
                 LEFT JOIN tbl_academic_Year tay ON 
                 tay.school_id = tsa.school_id
 
                 where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=1 AND tay.Academic_Year = '".$acadYear."'
 
                 group by tad.Receiver_tID

              ";                   

     
       $IndDeptAt = mysql_query($IndDeptAct); 
          
    
      while($r = mysql_fetch_assoc($IndDeptAt))
        {   
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ActcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 20)
          { 
              $deptPoi = 20;
              
          }else if($deptcPoints < 20){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
   if($inTeaId != '')
      {
          
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,dept_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
             
          }else{
              
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET dept_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
              
          }
       
       }  
     }
        
  
     //indivitual institute activity              
     $IndInstAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as IntcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id
 
                     where tsa.group_member_id='$group_member_id' and tad.activity_level_id=2 AND tay.Academic_Year = '".$acadYear."'
 
                     group by tad.Receiver_tID

                  ";             
                        
                   
       $IndInstAt = mysql_query($IndInstAct); 
            
    
        while($r = mysql_fetch_assoc($IndInstAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['IntcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
   if($inTeaId != '')
      {
          
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,inst_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
              
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET inst_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
               
          }  
       }               
  }
       
                   
                   
      //indivitual contribute to society activity              
     $IndConToSocAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as ContToSoccreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id
 
                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=3 AND tay.Academic_Year = '".$acadYear."'
 
                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndConToSotAt = mysql_query($IndConToSocAct); 
            
    
        while($r = mysql_fetch_assoc($IndConToSotAt))
        {  
            
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ContToSoccreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
   if($inTeaId != '')
      {
          
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,cont_society)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
               
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET cont_society='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
            
          }  
       }               
    }
    
     //indivitual ACR activity              
     $IndACRAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as AcrcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id
 
                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=4 AND tay.Academic_Year = '".$acadYear."'
 
                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndACRAt = mysql_query($IndACRAct); 
            
    
       while($r = mysql_fetch_assoc($IndACRAt))
        {   
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['AcrcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,acr)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins); 
               

          }else{
             
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET acr='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
             
          }  
       }
    }
    
//             if ($this->input->is_ajax_request()) {
//        
//                   echo "Recalculated All Institute In ".$acadYear." 360 degree feedback"; 
//
//                   exit;
//
//             }
    
     echo "Successfully Recalculate All Institute   360 Degree Feedback"; 
    
     
    
}else if($schoolID != 'all' && $schoolID != '' && $acadYear === 'all')
{
        //indivitual student feedback   
        $sql1 = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id ,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2)  as stuTotalPoints 

        FROM tbl_student_feedback sf

        LEFT JOIN tbl_school_admin tsa ON 
        tsa.school_id = sf.stu_feed_school_id
        
        LEFT JOIN tbl_academic_Year tay ON 
        tay.school_id = sf.stu_feed_school_id

        WHERE  tsa.group_member_id = '$group_member_id' AND  sf.stu_feed_points != '0' AND tay.Academic_Year = '".$acadYear."' 

        GROUP BY sf.stu_feed_teacher_id 

               ";
 
      $que = mysql_query($sql1); 
    
      while($r = mysql_fetch_assoc($que))
       {  
          $inStuSchoolID        = $r['school_id'];
          $inStuSchoolName      = $r['school_name'];
          $inStuState           = $r['scadmin_state']; 
          $inTeaId              = $r['stu_feed_teacher_id'];
          $stuTeaPoins          = $r['stuTotalPoints'];
          $stuActYear           = $r['Academic_Year'];
          $groupMemId           = $r['group_member_id'];
          
                  $tNd = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                   
                  $re  = mysql_query($tNd);

                  while($row = mysql_fetch_assoc($re))
                  { 

                            $inDeptName   = $row['t_dept'];
                            $inTeaName    = $row['t_complete_name'];  

                  } 
          
      if($inTeaId != '')
      {
            
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inStuSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
 
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,student_feedback)VALUES('$inStuSchoolID','$inStuSchoolName','$inStuState','$inDeptName','$inTeaId','$inTeaName','$stuActYear','$groupMemId','$stuTeaPoins')";

          $in = mysql_query($ins);
            
          }else{
       
           $Insins =  "UPDATE aicte_ind_feedback_summary_report
                        SET student_feedback='$stuTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($Insins);
              
          }
        }   
     }        
              
 
     //indivitual teaching process              
     $IndfeedTea = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 

                FROM tbl_360feedback_template tp

                LEFT JOIN tbl_school_admin tsa ON 
                tsa.school_id = tp.feed360_school_id
                
                LEFT JOIN tbl_teacher t ON 
                t.t_id = tp.feed360_teacher_id
                
                LEFT JOIN tbl_academic_Year tay ON 
                tay.school_id = tp.feed360_school_id

                WHERE tsa.group_member_id = '$group_member_id' AND tp.feed360_school_id = '".$schoolID."'   
 
                GROUP BY tp.feed360_teacher_id
              ";        
                        
                   
       $TeaProque = mysql_query($IndfeedTea); 
            
    
      while($r = mysql_fetch_assoc($TeaProque))
       { 
          $inTeaSchoolID        = $r['school_id'];
          $inTeaSchoolName      = $r['school_name']; 
          $inDeptName           = $r['t_dept'];
          $inTeaId              = $r['t_id'];
          $inTeaName            = $r['t_complete_name'];
          $inState              = $r['scadmin_state'];
          $inActYear            = $r['Academic_Year'];
          $TeaProcessTeaPoins   = $r['tp_points'];
          $groupMemId           = $r['group_member_id'];
        
        if($inTeaId != '')
        {
          
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inTeaSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,teaching_process)VALUES('$inTeaSchoolID','$inTeaSchoolName','$inState','$inDeptName','$inTeaId','$inTeaName','$inActYear','$groupMemId','$TeaProcessTeaPoins')";

          $in = mysql_query($ins); 

          }else{
            
           $TeaProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($TeaProsins);
           
          }
        }   
    }
                   
    
    //activity department          
    $IndDeptAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                 SUM(tad.credit_point) as ActcreditPoints

                 FROM  tbl_360_activities_data tad

                 LEFT JOIN tbl_school_admin tsa
                 ON tad.schoolID = tsa.school_id
                 
                 LEFT JOIN tbl_academic_Year tay ON 
                 tay.school_id = tsa.school_id

                 where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=1 AND tad.schoolID = '".$schoolID."'

                 group by tad.Receiver_tID

              ";                   

     
       $IndDeptAt = mysql_query($IndDeptAct); 
          
    
      while($r = mysql_fetch_assoc($IndDeptAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ActcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 20)
          { 
              $deptPoi = 20;
              
          }else if($deptcPoints < 20){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
          
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
 
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,dept_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
             
          }else{
              
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET dept_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
              
          }  
       }
      }
                 
  
     //indivitual institute activity              
     $IndInstAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as IntcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' and tad.activity_level_id=2 AND tad.schoolID = '".$schoolID."'

                     group by tad.Receiver_tID

                  ";             
                        
                   
       $IndInstAt = mysql_query($IndInstAct); 
            
    
        while($r = mysql_fetch_assoc($IndInstAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['IntcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,inst_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
              
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET inst_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
               
          }  
       }               
    }
       
                   
                   
      //indivitual contribute to society activity              
     $IndConToSocAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as ContToSoccreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=3 AND tad.schoolID = '".$schoolID."'

                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndConToSotAt = mysql_query($IndConToSocAct); 
            
    
        while($r = mysql_fetch_assoc($IndConToSotAt))
        {  
            
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ContToSoccreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,cont_society)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
               
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET cont_society='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
            
          }  
       }               
    }
    
     //indivitual ACR activity              
     $IndACRAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as AcrcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=4 AND tad.schoolID = '".$schoolID."'

                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndACRAt = mysql_query($IndACRAct); 
            
    
       while($r = mysql_fetch_assoc($IndACRAt))
        {   
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['AcrcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  if($inTeaId != '')
      {
          
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,acr)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins); 
               

          }else{
             
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET acr='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
             
          }  
       }
       }
     echo "Successfully Recalculate 360 Degree Feedback Institute";
    
//             if ($this->input->is_ajax_request()) {
//        
//                   echo "Recalculated Institute ".$schoolID." 360 degree feedback"; 
//
//                   exit;
//
//             }
               
}
else if($schoolID != 'all' && $schoolID != '' && $acadYear != 'all' && $acadYear != '')
{
        //indivitual student feedback   
        $sql1 = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2)  as stuTotalPoints 

        FROM tbl_student_feedback sf

        LEFT JOIN tbl_school_admin tsa ON 
        tsa.school_id = sf.stu_feed_school_id
        
        LEFT JOIN tbl_academic_Year tay ON 
        tay.school_id = sf.stu_feed_school_id

        WHERE  tsa.group_member_id = '$group_member_id' AND  sf.stu_feed_points != '0' AND sf.stu_feed_school_id = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."' 

        GROUP BY sf.stu_feed_teacher_id 

               ";
                   
                  
      $que = mysql_query($sql1); 
    
      while($r = mysql_fetch_assoc($que))
       {  
          $inStuSchoolID        = $r['school_id'];
          $inStuSchoolName      = $r['school_name'];
          $inStuState           = $r['scadmin_state']; 
          $inTeaId              = $r['stu_feed_teacher_id'];
          $stuTeaPoins          = $r['stuTotalPoints'];
          $stuActYear           = $r['Academic_Year'];
          $groupMemId           = $r['group_member_id'];
          
                  $tNd = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                   
                  $re  = mysql_query($tNd);

                  while($row = mysql_fetch_assoc($re))
                  { 

                            $inDeptName   = $row['t_dept'];
                            $inTeaName    = $row['t_complete_name'];  

                  }
          
     if($inTeaId != '')
      {
            
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inStuSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
 
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,student_feedback)VALUES('$inStuSchoolID','$inStuSchoolName','$inStuState','$inDeptName','$inTeaId','$inTeaName','$stuActYear','$groupMemId','$stuTeaPoins')";

          $in = mysql_query($ins);
           
              

          }else{
       
           $Insins =  "UPDATE aicte_ind_feedback_summary_report
                        SET student_feedback='$stuTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($Insins);
              
              
          }   
       }        
      }
 
     //indivitual teaching process              
     $IndfeedTea = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 

                FROM tbl_360feedback_template tp

                LEFT JOIN tbl_school_admin tsa ON 
                tsa.school_id = tp.feed360_school_id
                
                LEFT JOIN tbl_teacher t ON 
                t.t_id = tp.feed360_teacher_id
                
                LEFT JOIN tbl_academic_Year tay ON 
                tay.school_id = tp.feed360_school_id

                WHERE tsa.group_member_id = '$group_member_id' AND tp.feed360_school_id = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."'  
 
                GROUP BY tp.feed360_teacher_id
              ";        
                        
                   
       $TeaProque = mysql_query($IndfeedTea); 
            
    
      while($r = mysql_fetch_assoc($TeaProque))
       { 
          $inTeaSchoolID        = $r['school_id'];
          $inTeaSchoolName      = $r['school_name']; 
          $inDeptName           = $r['t_dept'];
          $inTeaId              = $r['t_id'];
          $inTeaName            = $r['t_complete_name'];
          $inState              = $r['scadmin_state'];
          $inActYear            = $r['Academic_Year'];
          $TeaProcessTeaPoins   = $r['tp_points'];
          $groupMemId           = $r['group_member_id'];
          
         $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$inDeptName' and school_id='$inTeaSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,scadmin_state,dept_name,teacher_id,teacher_name,academic_year,group_member_id,teaching_process)VALUES('$inTeaSchoolID','$inTeaSchoolName','$inState','$inDeptName','$inTeaId','$inTeaName','$inActYear','$groupMemId','$TeaProcessTeaPoins')";

          $in = mysql_query($ins); 

          }else{
            
           $TeaProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($TeaProsins);
             
          }   
       }
                   
    
    //activity department          
    $IndDeptAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                 SUM(tad.credit_point) as ActcreditPoints

                 FROM tbl_360_activities_data tad

                 LEFT JOIN tbl_school_admin tsa
                 ON tad.schoolID = tsa.school_id
                 
                 LEFT JOIN tbl_academic_Year tay ON 
                 tay.school_id = tsa.school_id

                 where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=1 AND tad.schoolID = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."'

                 group by tad.Receiver_tID   

              ";                   

     
       $IndDeptAt = mysql_query($IndDeptAct); 
          
    
      while($r = mysql_fetch_assoc($IndDeptAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ActcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 20)
          { 
              $deptPoi = 20;
              
          }else if($deptcPoints < 20){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {  
           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){ 
               
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,dept_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
             
          }else{
              
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET dept_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
              
          }  
       }
      }
                 
  
     //indivitual institute activity              
     $IndInstAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as IntcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' and tad.activity_level_id=2 AND tad.schoolID = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."'

                     group by tad.Receiver_tID

                  ";             
                        
                   
       $IndInstAt = mysql_query($IndInstAct); 
            
    
        while($r = mysql_fetch_assoc($IndInstAt))
        {  
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['IntcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,inst_activity)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
              
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET inst_activity='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
               
          }  
       }               
    }
       
                   
                   
      //indivitual contribute to society activity              
     $IndConToSocAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as ContToSoccreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=3 AND tad.schoolID = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."'

                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndConToSotAt = mysql_query($IndConToSocAct); 
            
    
        while($r = mysql_fetch_assoc($IndConToSotAt))
        {  
            
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['ContToSoccreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
      if($inTeaId != '')
      {
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,cont_society)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins);
               
          }else{
            
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET cont_society='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
            
          }  
       }               
    }
    
     //indivitual ACR activity              
     $IndACRAct = "SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tad.Receiver_tID,tad.activity_level_id,tsa.group_member_id,tay.Academic_Year,

                     SUM(tad.credit_point) as AcrcreditPoints

                     FROM tbl_360_activities_data tad

                     LEFT JOIN tbl_school_admin tsa
                     ON tad.schoolID = tsa.school_id
                     
                     LEFT JOIN tbl_academic_Year tay ON 
                     tay.school_id = tsa.school_id

                     where tsa.group_member_id='$group_member_id' AND tad.activity_level_id=4 AND tad.schoolID = '".$schoolID."' AND tay.Academic_Year = '".$acadYear."'

                     group by tad.Receiver_tID

                  ";       
                        
                   
       $IndACRAt = mysql_query($IndACRAct); 
            
    
       while($r = mysql_fetch_assoc($IndACRAt))
        {   
            $inDepSchoolID        = $r['school_id'];
            $inDepSchoolName      = $r['school_name'];
            $inState              = $r['scadmin_state'];
            $inTeaId              = $r['Receiver_tID']; 
            $inActYear            = $r['Academic_Year']; 
            $deptcPoints          = $r['AcrcreditPoints'];
            $actLevelID           = $r['activity_level_id'];
            $groupMemId           = $r['group_member_id'];
          
          if($deptcPoints >= 10)
          { 
              $deptPoi = 10;
              
          }else if($deptcPoints < 10){ 
              
              $deptPoi = $deptcPoints;
          } 
 
                          
                    $sTidName = "SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId'";
                    $teacherName = mysql_query($sTidName); 
                    while($ret = mysql_fetch_assoc($teacherName))
                         { 
                             $tdept = $ret['t_dept'];
                             $tname = $ret['t_complete_name'];
                         } 
  
     if($inTeaId != '')
      {
          $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
          $result = mysql_num_rows($sql);

          if($result =="0"){
             
          $ins = "INSERT INTO aicte_ind_feedback_summary_report(school_id,school_name,dept_name,teacher_id,teacher_name,scadmin_state,academic_year,group_member_id,acr)VALUES('$inDepSchoolID','$inDepSchoolName','$tdept','$inTeaId','$tname','$inState','$inActYear','$groupMemId','$deptPoi')";

          $in = mysql_query($ins); 
               

          }else{
             
           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
                        SET acr='$deptPoi' WHERE teacher_id='$inTeaId'";
              
            $in = mysql_query($DepProsins);
             
          }  
       }
       }
             
                   echo "Successfully Recalculate 360 Degree Feedback Institute,Year"; 

                 
}

 
//       //total 100 and scale 10
//       $IndACRActall = "SELECT * FROM aicte_ind_feedback_summary_report";  
//       $IndACRAtAll = mysql_query($IndACRActall); 
//            
//    
//       while($row = mysql_fetch_assoc($IndACRAtAll))
//        { 
//            $inDepSchoolID        = $row['school_id']; 
//            $tdept                = $row['dept_name'];
//            $inTeaId              = $row['teacher_id']; 
//             
//            $total = $row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
//                       
//            $scaleTen = $total/10;
//  
//          
//           $sql = mysql_query("SELECT * FROM aicte_ind_feedback_summary_report WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'");
//          $result = mysql_num_rows($sql);
//
//          if($result =="0"){
//             
//         // $ins = "INSERT INTO aicte_ind_feedback_summary_report(total_on_100,total_on_scale_10)VALUES('$total','$scaleTen')";
//
//          $in = mysql_query($ins); 
//               
//
//          }else{
//               
//           $DepProsins =  "UPDATE aicte_ind_feedback_summary_report
//                        SET total_on_100='$total',total_on_scale_10='$scaleTen'  WHERE teacher_id='$inTeaId' and dept_name='$tdept' and school_id='$inDepSchoolID'";
//              
//            $in = mysql_query($DepProsins);
//             
//          }  
//       }
   
 
 
       ?>  