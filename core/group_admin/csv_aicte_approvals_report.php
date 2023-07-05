<?php
include("../conn.php"); 
session_start();
$group_member_id = $_SESSION['group_admin_id']; 

$school_id=$_SESSION['school_id'];

$file = "AICTEapprovalsinfoReport".date('Y-m-d');
header('Content-Type: text/csv');
header ( "Content-Disposition: attachment; filename=".$file.".csv" );
$user_CSV[0] = array('Sr No','Data File Name','Expected','No of Records','Batch Upload','Batch Upload','Manual Upload','Manual Upload');
$user_CSV[1]=array('','','','','By Batch','Batch Date','By Manual','Manual Date');

//$user_CSV[3]=array($school_id,'School',$sc_id);

    
if($school_id!='')
{
  //join aicte_college_info on aicte_college_info.college_id=tbl_school_admin.school_id
   $sqln1="SELECT * FROM tbl_school_admin WHERE school_id='$school_id'";

     $qr10="SELECT expected_records,school_id FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Course Level'";
     $a=mysql_query($qr10);
     $qr1=mysql_fetch_array($a);

      $qr11="SELECT MAX(updated_date)as b,count(id) as a  FROM tbl_CourseLevel where school_id='$school_id'";
      $a=mysql_query($qr11);
    $qr2=mysql_fetch_array($a);
      
       $qr12="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_CourseLevel where school_id='$school_id' and batch_id IS NOT NULL";
                         
 $a=mysql_query($qr12);
 $qr3=mysql_fetch_array($a);


  if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
   $course_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
                            $course_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $course_batch_date= "";
 }               
      $qr13="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_CourseLevel where school_id='$school_id' and batch_id IS NULL";
      $a=mysql_query($qr13);
      $qr4=mysql_fetch_array($a);
      
     
       if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
      {
        $course_manual_date=date("Y-m-d", strtotime($qr4['c'])); 
      }
      else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                             {
                                 $course_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
      }
      else
      {
         $course_manual_date= "";
      }
 $user_CSV[3]=array('1','Course Level',$qr1['expected_records'],$qr2['a'], $qr3['a'],$course_batch_date,$qr4['a'],$course_manual_date);

      $qr14="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Degree Master'";
      $a=mysql_query($qr14);
      $qr1=mysql_fetch_array($a);
      
        $qr15="SELECT MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id'";
        $a=mysql_query($qr15);
        $qr2=mysql_fetch_array($a);
        
           $qr16="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id' and batch_id IS NOT NULL";
           $a=mysql_query($qr16);
           $qr3=mysql_fetch_array($a);
                

            if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
           {
             $degree_batch_date=date("Y-m-d", strtotime($qr3['c'])); 
           }
           else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                                  {
                                    $degree_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
           }
           else
           {
            $degree_batch_date="";
           }
        $qr17="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id' and batch_id IS NULL";
        $a=mysql_query($qr17);
        $qr4=mysql_fetch_array($a);
    
           if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
        {
            $degree_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
        }
        else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                               {
         $degree_manual_date=date("Y-m-d", strtotime($qr4['b'])); 
        }
        else
        {
            $degree_manual_date="";
        }

        $user_CSV[4]=array('2','Degree',$qr1['expected_records'], $qr2['a'],$qr3['a'],$degree_batch_date,    $qr4['a'],$degree_manual_date);

       $qr18="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Department'";
       $a=mysql_query($qr18);
       $qr1=mysql_fetch_array($a);
           
        $qr19="SELECT count(id) as a FROM tbl_department_master where school_id='$school_id'";
        $a=mysql_query($qr19);
        $qr2=mysql_fetch_array($a);

        $qr20="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_department_master where school_id='$school_id' and batch_id IS NOT NULL";
                  $a=mysql_query($qr20);
                         $qr3=mysql_fetch_array($a);
                         
                        
                          if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
                         {
                           $dept_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
                         }
                         else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                                                {
                                                    $dept_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
                         }
                         else
                         {
                            $dept_batch_date= "";
                         }                 
        $qr21="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_department_master where school_id='$school_id' and batch_id IS NULL";
        $a=mysql_query($qr21);
        $qr4=mysql_fetch_array($a);
       
      
         if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
        {
            $dept_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
        }
        else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                               {
                                $dept_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
        }
        else
        {
            $dept_manual_date= "";
        }
        $user_CSV[5]=array('3','Department',$qr1['expected_records'], $qr2['a'],$qr3['a'],$dept_batch_date,$qr4['a'],$dept_manual_date);

       $qr22="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Branch Master'";
       $a=mysql_query($qr22);
       $qr1=mysql_fetch_array($a);   

        $qr23="SELECT count(id) as a FROM tbl_branch_master where school_id='$school_id'";
        $a=mysql_query($qr23);
        $qr2=mysql_fetch_array($a);

        $qr24="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_branch_master where school_id='$school_id' and batch_id IS NOT NULL";
        $a=mysql_query($qr24);
        $qr3=mysql_fetch_array($a);
        
         if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
        {
          $branch_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
        }
        else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                               {
                                $branch_batch_date=  date("Y-m-d", strtotime($qr3['b'])); 
        }
        else
        {
            $branch_batch_date= "";
        }

 
        $qr25="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_branch_master where school_id='$school_id' and batch_id IS NULL";
        $a=mysql_query($qr25);
        $qr4=mysql_fetch_array($a);
        
         if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
        {
          $branch_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
        }
        else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                               {
                                $branch_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
        }
        else
        {
            $branch_manual_date="";
        }
        $user_CSV[6]=array('4','Branch',$qr1['expected_records'], $qr2['a'],$qr3['a'],$branch_batch_date,$qr4['a'],$branch_manual_date);
          $qr26="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Master'";
          $a=mysql_query($qr26);
          $qr1=mysql_fetch_array($a);
          
          $qr27="SELECT count(id) as a FROM Class where school_id='$school_id'";
          $a=mysql_query($qr27);
          $qr2=mysql_fetch_array($a);

          $qr28="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Class where school_id='$school_id' and batch_id IS NOT NULL";
               $a=mysql_query($qr28);
                         $qr3=mysql_fetch_array($a);
                      
                          if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
                         {
                           $class_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
                         }
                         else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                                                {
                                                    $class_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
                         }
                         else
                         {
                            $class_batch_date=  "";
                         }
         
          $qr29="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Class where school_id='$school_id' and batch_id IS NULL";
          $a=mysql_query($qr29);
          $qr4=mysql_fetch_array($a);
                  
           if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
          {
            $class_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
          }
          else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                                 {
                                    $class_manual_date=date("Y-m-d", strtotime($qr4['b'])); 
          }
          else
          {
            $class_manual_date= "";
          }
          $user_CSV[7]=array('5','Class',$qr1['expected_records'], $qr2['a'],$qr3['a'],$class_batch_date,$qr4['a'],$class_manual_date);
                $qr30="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Division Master'";
                $a=mysql_query($qr30);
                $qr1=mysql_fetch_array($a);  
        $qr31="SELECT count(id) as a FROM Division where school_id='$school_id'";
        $a=mysql_query($qr31);
        $qr2=mysql_fetch_array($a);

        $qr32="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Division where school_id='$school_id' and batch_id IS NOT NULL";
        $a=mysql_query($qr32);
        $qr3=mysql_fetch_array($a);
        
         if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
        {
          $div_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
        }
        else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                               {
                                $div_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
        }
        else
        {
            $div_batch_date= "";
        }

        $qr33="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Division where school_id='$school_id' and batch_id IS NULL";
        $a=mysql_query($qr33);
        $qr4=mysql_fetch_array($a);
        
          if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
        {
          $div_manual_date=date("Y-m-d", strtotime($qr4['c'])); 
        }
        else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                               {
                                $div_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
        }
        else
        {
            $div_manual_date= "";
        }
        $user_CSV[8]=array('6','Division',$qr1['expected_records'], $qr2['a'],$qr3['a'],$div_batch_date,$qr4['a'],$div_manual_date);
        $qr34="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Subject'";
        $a=mysql_query($qr34);
        $qr1=mysql_fetch_array($a);                                                                  
        $qr35="SELECT count(id) as a FROM tbl_school_subject where school_id='$school_id'";
        $a=mysql_query($qr35);
        $qr2=mysql_fetch_array($a);    
        $qr36="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_school_subject where school_id='$school_id' and batch_id IS NOT NULL";
        $a=mysql_query($qr36);
        $qr3=mysql_fetch_array($a);
        
         if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
        {
          $sub_batch_date=date("Y-m-d", strtotime($qr3['c'])); 
        }
        else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                               {
                                $sub_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
        }
        else
        {
            $sub_batch_date="";
        }
       $qr37="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_school_subject where school_id='$school_id' and batch_id IS NULL";
       $a=mysql_query($qr37);
       $qr4=mysql_fetch_array($a);
       
        if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
       {
         $sub_manual_date =date("Y-m-d", strtotime($qr4['c'])); 
       }
       else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                              {
                                $sub_manual_date = date("Y-m-d", strtotime($qr4['b'])); 
       }
       else
       {
        $sub_manual_date = "";
       }
       $user_CSV[9]=array('7','Subject',$qr1['expected_records'], $qr2['a'],$qr3['a'],$sub_batch_date,$qr4['a'],$sub_manual_date);

 $qr38="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Academic Year'";
 $a=mysql_query($qr38);
 $qr1=mysql_fetch_array($a);    
 $qr39="SELECT count(id) as a FROM tbl_academic_Year where school_id='$school_id'";
 $a=mysql_query($qr39);
 $qr2=mysql_fetch_array($a);       
 $qr40="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_academic_Year where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr40);
 $qr3=mysql_fetch_array($a);
 
    if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
   $year_batch_date=date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
                            $year_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $year_batch_date= "";
 }


 $qr41="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_academic_Year where school_id='$school_id' and batch_id IS NULL";
 $a=mysql_query($qr41);
 $qr4=mysql_fetch_array($a);
 
  if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
 {
   $year_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
 }
 else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                        {
                            $year_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
 }
 else
 {
    $year_manual_date="";
 }
 $user_CSV[10]=array('8','Academic year',$qr1['expected_records'], $qr2['a'],$qr3['a'],$year_batch_date,$qr4['a'],$year_manual_date);
 $qr42="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Master'";
 $a=mysql_query($qr42);
 $qr1=mysql_fetch_array($a);                  
 $qr43="SELECT count(id) as a FROM StudentSemesterRecord where school_id='$school_id'";
 $a=mysql_query($qr43);
 $qr2=mysql_fetch_array($a);                
 $qr44="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr44);
 $qr3=mysql_fetch_array($a);

  if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
   $sem_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
                            $sem_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $sem_batch_date="";
 }                  

$qr45="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NULL";
$a=mysql_query($qr45);
$qr4=mysql_fetch_array($a);

 if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
{
  $sem_manual_date=date("Y-m-d", strtotime($qr4['c'])); 
}
else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                       {
                        $sem_manual_date=date("Y-m-d", strtotime($qr4['b'])); 
}
else
{
    $sem_manual_date= "";
}
$user_CSV[11]=array('9','Semester',$qr1['expected_records'], $qr2['a'],$qr3['a'],$sem_batch_date,$qr4['a'],$sem_manual_date);
 $qr46="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Teacher'";
 $a=mysql_query($qr46);
 $qr1=mysql_fetch_array($a);

  
  $qr47="SELECT count(id) as a FROM tbl_teacher where school_id='$school_id'";
  $a=mysql_query($qr47);
  $qr2=mysql_fetch_array($a);
                     
 $qr48="SELECT MAX(created_on)as c,MAX(updated_date)as b,count(id) as a FROM tbl_teacher where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr48);
 $qr3=mysql_fetch_array($a);
 
  if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
   $tea_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
                            $tea_batch_date=  date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $tea_batch_date=  "";
 }
 $qr49="SELECT MAX(created_on)as c,MAX(updated_date)as b,count(id) as a FROM tbl_teacher where school_id='$school_id' and batch_id IS NULL";
 $a=mysql_query($qr49);
 $qr4=mysql_fetch_array($a);
 
 if($qr4['b']=='')
 {
 $tea_manual_date= "";
 }
  else if($qr4['b']=='0000-00-00 00:00:00')
 {
    $tea_manual_date=  date("Y-m-d", strtotime($qr4['c'])); 
 }
 else
 {
    $tea_manual_date=  date("Y-m-d", strtotime($qr4['b']));
 }
 $user_CSV[12]=array('10','Teachers',$qr1['expected_records'], $qr2['a'],$qr3['a'],$tea_batch_date,$qr4['a'],$tea_manual_date);

 $qr50="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Teacher Subject'";
 $a=mysql_query($qr50);
 $qr1=mysql_fetch_array($a);

 
 $qr51="SELECT count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id'";
 $a=mysql_query($qr51);
 $qr2=mysql_fetch_array($a);                    
 $qr52="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr52);
 $qr3=mysql_fetch_array($a);
 
 if($qr3['b']=='')
 {
 $tea_sub_batch_date= "";
 }
  else if($qr3['b']=='0000-00-00 00:00:00')
 {
    $tea_sub_batch_date=  date("Y-m-d", strtotime($qr3['c'])); 
 }
 else
 {
    $tea_sub_batch_date= date("Y-m-d", strtotime($qr3['b']));
 }

  $qr53="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id' and batch_id IS NULL";
  $a=mysql_query($qr53);
  $qr4=mysql_fetch_array($a);

  if($qr4['b']=='')
  {
   $tea_sub_manual_date= "";
  }
   else if($qr4['b']=='0000-00-00 00:00:00')
  {
    $tea_sub_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
  }
  else
  {
     $tea_sub_manual_date= date("Y-m-d", strtotime($qr4['b']));
  }
  $user_CSV[13]=array('11','Teachers Subject',$qr1['expected_records'], $qr2['a'],$qr3['a'],$tea_sub_batch_date,$qr4['a'],$tea_sub_manual_date);
  $qr54="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Branch-Subject-Div-Year'";
  $a=mysql_query($qr54);
  $qr1=mysql_fetch_array($a);
   
  $qr55="SELECT count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id'";
          $a=mysql_query($qr55);
     $qr2=mysql_fetch_array($a);               
 $qr56="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr56);
 $qr3=mysql_fetch_array($a);
 
  if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
  $sub_div_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
   $sub_div_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $sub_div_batch_date= "";
 }               
  $qr57="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id' and batch_id IS NULL";
  $a=mysql_query($qr57);
  $qr4=mysql_fetch_array($a);
  
   if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
  {
    $sub_div_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
  }
  else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                         {
                            $sub_div_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
  }
  else
  {
    $sub_div_manual_date= "";
  }
  $user_CSV[14]=array('12','Subject Division',$qr1['expected_records'], $qr2['a'],$qr3['a'],$sub_div_batch_date,$qr4['a'],$sub_div_manual_date);     
  
  $qr58="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Subject'";
  $a=mysql_query($qr58);
  $qr1=mysql_fetch_array($a);
 
   
  $qr59="SELECT count(id) as a FROM tbl_class_subject_master where school_id='$school_id'";
  $a=mysql_query($qr59);
  $qr2=mysql_fetch_array($a);
  $qr60="SELECT MAX(uploaded_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_class_subject_master where school_id='$school_id' and batch_id IS NOT NULL";
  $a=mysql_query($qr60);
  $qr3=mysql_fetch_array($a);
 
   if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
  {
    $class_sub_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
  }
  else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                         {
                            $class_sub_batch_date=date("Y-m-d", strtotime($qr3['b'])); 
  }
  else
  {
    $class_sub_batch_date= "";
  }
  $qr61="SELECT MAX(uploaded_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_class_subject_master where school_id='$school_id' and batch_id IS NULL";
  $a=mysql_query($qr61);
  $qr4=mysql_fetch_array($a);
  
   if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
  {
    $class_sub_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
  }
  else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                         {
                            $class_sub_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
  }
  else
  {
    $class_sub_manual_date= "";
  }
  $user_CSV[15]=array('13','Class Subject',$qr1['expected_records'], $qr2['a'],$qr3['a'],$class_sub_batch_date,$qr4['a'],$class_sub_manual_date);                                            
 
   $qr62="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student'";
   $a=mysql_query($qr62);
   $qr1=mysql_fetch_array($a);
         
 $qr63="SELECT count(id) as a FROM tbl_student where school_id='$school_id'";
 $a=mysql_query($qr63);
 $qr2=mysql_fetch_array($a);   

$qr64="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student where school_id='$school_id' and batch_id IS NOT NULL";
$a=mysql_query($qr64);
$qr3=mysql_fetch_array($a);


if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
{
    $stud_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
}
else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                       {
                        $stud_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
}
else
{
    $stud_batch_date= "";
}
                       $qr65="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student where school_id='$school_id' and batch_id IS NULL";
                       $a=mysql_query($qr65);
                         $qr4=mysql_fetch_array($a);
                       if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
                         {
                            $stud_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
                         }
                         else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                                                {
                                                    $stud_manual_date=date("Y-m-d", strtotime($qr4['b'])); 
                         }
                         else
                         {
                            $stud_manual_date="";
                         }
                       $user_CSV[16]=array('14','Student',$qr1['expected_records'], $qr2['a'],$qr3['a'],$stud_batch_date,$qr4['a'],$stud_manual_date);                                            
                       
                       $qr66="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student Semester'";
                       $a=mysql_query($qr66);
                       $qr1=mysql_fetch_array($a);
                      
 $qr67="SELECT count(id) as a FROM StudentSemesterRecord where school_id='$school_id'";
 $a=mysql_query($qr67);
                        $qr2=mysql_fetch_array($a);
                      $qr68="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NOT NULL";
                      $a=mysql_query($qr68);
                      $qr3=mysql_fetch_array($a);
                      
                       if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
                      {
                        $stud_sem_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
                      }
                      else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                                             {
                                                $stud_sem_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
                      }
                      else
                      {
                        $stud_sem_batch_date= "";
                      }
 $qr69="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NULL";
 $a=mysql_query($qr69);
 $qr4=mysql_fetch_array($a);
 if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
 {
    $stud_sem_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
 }
 else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                        {
                            $stud_sem_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
 }
 else
 {
    $stud_sem_manual_date="";
 }
 $user_CSV[17]=array('15','Student Semester',$qr1['expected_records'], $qr2['a'],$qr3['a'],$stud_sem_batch_date,$qr4['a'],$stud_sem_manual_date);                                                     
$qr70="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student Subject'";
$a=mysql_query($qr70);
$qr1=mysql_fetch_array($a);

 $qr71="SELECT count(id) as a FROM tbl_student_subject_master where school_id='$school_id'";
 $a=mysql_query($qr71);
 $qr2=mysql_fetch_array($a);                 
 $qr72="SELECT  MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student_subject_master where school_id='$school_id' and batch_id IS NOT NULL";
 $a=mysql_query($qr72);
 $qr3=mysql_fetch_array($a);
 if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
 {
    $stud_sub_batch_date=date("Y-m-d", strtotime($qr3['c'])); 
 }
 else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                        {
                            $stud_sub_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
 }
 else
 {
    $stud_sub_batch_date= "";
 }

 $qr73="SELECT  MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student_subject_master where school_id='$school_id' and batch_id IS NULL";
 $a=mysql_query($qr73);
 $qr4=mysql_fetch_array($a);
 
  if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
 {
    $stud_sub_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
 }
 else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                        {
                            $stud_sub_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
 }
 else
 {
    $stud_sub_manual_date= "";
 }

 $user_CSV[18]=array('16','Student Subject',$qr1['expected_records'], $qr2['a'],$qr3['a'],$stud_sub_batch_date,$qr4['a'],$stud_sub_manual_date);                                                                                    
    $qr74="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Parents'";
    $a=mysql_query($qr74);
    $qr1=mysql_fetch_array($a);

                      $qr75="SELECT count(id) as a FROM tbl_parent where school_id='$school_id'";
                      $a=mysql_query($qr75);
                      $qr2=mysql_fetch_array($a);
                        $qr76="SELECT MAX(old_uploaded_date_time)as c,MAX(updated_date)as b,count(id) as a FROM tbl_parent where school_id='$school_id' and batch_id IS NOT NULL";
                        $a=mysql_query($qr76);
                        $qr3=mysql_fetch_array($a);
                      
                   
                         if($qr3['b']=='0000-00-00 00:00:00' && $qr3['c']!='0000-00-00 00:00:00' && $qr3['c']!='')
                        {
                            $parents_batch_date= date("Y-m-d", strtotime($qr3['c'])); 
                        }
                        else if($qr3['b']!='0000-00-00 00:00:00' && $qr3['c']=='0000-00-00 00:00:00' && $qr3['b']!='' )
                                               {
                                                $parents_batch_date= date("Y-m-d", strtotime($qr3['b'])); 
                        }
                        else
                        {
                            $parents_batch_date= "";
                        }

                        $qr77="SELECT MAX(old_uploaded_date_time)as c,MAX(updated_date)as b,count(id) as a FROM tbl_parent where school_id='$school_id' and batch_id IS NULL";
                        $a=mysql_query($qr77);
                        $qr4=mysql_fetch_array($a);
                                       
                         if($qr4['b']=='0000-00-00 00:00:00' && $qr4['c']!='0000-00-00 00:00:00' && $qr4['c']!='')
                        {
                            $parents_manual_date= date("Y-m-d", strtotime($qr4['c'])); 
                        }
                        else if($qr4['b']!='0000-00-00 00:00:00' && $qr4['c']=='0000-00-00 00:00:00' && $qr4['b']!='' )
                                               {
                                                $parents_manual_date= date("Y-m-d", strtotime($qr4['b'])); 
                        }
                        else
                        {
                            $parents_manual_date= "";
                        }
                        $user_CSV[19]=array('17','Parents',$qr1['expected_records'], $qr2['a'],$qr3['a'],$parents_batch_date,$qr4['a'],$parents_manual_date);                                                     
}      
              

?>
<?php



 
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}

fclose($fp);

?>