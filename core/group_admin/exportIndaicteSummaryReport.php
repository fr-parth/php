<?php
 
include("../conn.php");  

        $qr   = "SELECT * FROM storeSchoolIDdeptName";
        $res  = mysql_query($qr);
        while($r = mysql_fetch_assoc($res))
        {
            $sID            = $r['school_id'];
            $deptName       = $r['dept_name'];
            $academic_year  = $r['academic_year'];
        }

   if($sID === 'all' && $deptName === 'all' && $academic_year === 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year FROM aicte_ind_feedback_summary_report";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID === 'all' && $deptName === 'all' && $academic_year != '' && $academic_year != 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year 
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE academic_year='$academic_year'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID === 'all' && $deptName != '' && $deptName != 'all' && $academic_year === 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year 
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE dept_name='$deptName'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID === 'all' && $deptName != '' && $deptName != 'all' && $academic_year != '' && $academic_year != 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year 
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE dept_name='$deptName' and academic_year='$academic_year'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID != '' && $sID != 'all' && $deptName === 'all' && $academic_year === 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE school_id='$sID' 
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID != '' && $sID != 'all' && $deptName === 'all' && $academic_year != '' && $academic_year != 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year 
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE school_id='$sID' and academic_year='$academic_year'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID != '' && $sID != 'all' && $deptName != '' && $deptName != 'all' && $academic_year === 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE school_id='$sID' and dept_name='$deptName'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }else if($sID != '' && $sID != 'all' && $deptName != '' && $deptName != 'all' && $academic_year != '' && $academic_year != 'all')
   { 
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      $output = fopen("php://output","w");
       
      fputcsv($output,array('Institute_Id','Institute_Name','Department Name','Institute_State','Teacher_Id','Teacher_Name','Student_feedback','Teaching_process','Contribute _To_Society','ACR','Dept_activity','Institute_activity','Total_on_100','Total_on_scale_10','Academic Year')); 
        
       
       $sql = "SELECT school_id,school_name,dept_name,scadmin_state,teacher_id,teacher_name,student_feedback,teaching_process,cont_society,acr,dept_activity,inst_activity,total_on_100,total_on_scale_10,academic_year
       
       FROM aicte_ind_feedback_summary_report
       
       WHERE school_id='$sID' and dept_name='$deptName' and academic_year='$academic_year'
       
       ";
       
      //$sql = "SELECT name from dummydata";
                   
       $query = mysql_query($sql); 
       
       while($row = mysql_fetch_assoc($query))
       {  
           fputcsv($output,$row); 
       }
       fclose($output); 
        
   }


 
       
  exit;
 
  

?>