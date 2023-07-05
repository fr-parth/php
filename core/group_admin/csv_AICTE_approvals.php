<?php
include("../conn.php"); 
session_start();
$group_member_id = $_SESSION['group_admin_id']; 
// $school_id=$_SESSION['school_id'];
$status=$_SESSION['status'];
$country=$_SESSION['country'];
$state=$_SESSION['state'];
$city=$_SESSION['city'];
// $aicte_id=$_SESSION['aicte_id'];
$from_date=$_SESSION['from_date'];
$to_date=$_SESSION['to_date'];
$gpp=$_SESSION['group_name'];

$file = "ActivationReport".date('Y-m-d');
header('Content-Type: text/csv');
header ( "Content-Disposition: attachment; filename=".$file.".csv" );

$user_CSV[0] = array('Sr.No','School ID','School Name','City','State','is Activated','Activation Date','No. of file Uploaded','Percentage completed','ORG structure','Data Uploaded','Subject','Teacher','Teacher Subject','Student','Student subject','Student Semester','Co-Ordinater Email','Admin Email');
   
$cond =" where gs.group_member_id= '$group_member_id' and ";
$order_by="sa.school_name";

if($group_member_id!='')
{
  if($group_member_id=='All')
  {
    $cond = " where ";
  }
  else
  {
    $cond =" where gs.group_member_id= '$group_member_id' and ";

  }
  // $group_member_id='91';
  // $arr['CountryCode']=$country1;
}
if($country!='')
{
    $country1='91';
  // $arr['CountryCode']=$country1;
  $cond .= " sa.CountryCode='$country1'";

}
if($state!='')
{
   $sql1= mysql_query("SELECT * FROM tbl_state where state_id='$state' order by state asc");
   $a1=mysql_fetch_array($sql1);

   $c=$a1['state'];
   $state1= $a1['state_id'];
  // $arr['scadmin_state']=$c;
 
  $cond .= " and sa.scadmin_state='$c'";
}


if($city!='')
{
   //$arr['scadmin_city']=$city;
 $cond .= " and sa.scadmin_city='$city'";
}

if($from_date!='' && $to_date!='')
{


   $cond .= " and sa.accept_terms_date>='$from_date 00:00:00' and sa.accept_terms_date<='$to_date 23:59:59'";
   $order_by = "sa.accept_terms_date";
}

if($status!='' && $status!='2')

{
  $cond .= " and sa.is_accept_terms='$status'";
  //$arr['is_accept_terms']=$status;
}
$sqln1= "SELECT * FROM tbl_school_admin sa join tbl_group_school gs on gs.school_id = sa.school_id $cond order by $order_by ";
$i= 0;                 
                  $arr = mysql_query($sqln1);

                  while ($row = mysql_fetch_array($arr)) {
                  $teacher_id = $row['id'];
                  $no_of_file=0;
                  $org_str =0;
                  $i++;
if($row['is_accept_terms']=='1'){$accept_term = "Yes";}else{$accept_term =  "No";};

 if($row['is_accept_terms']=='1'){$accept_date =  date("Y-m-d", strtotime($row['accept_terms_date']));}else{$accept_term ="";};

$sc_id=$row['school_id'];
         $cond1=" WHERE school_id='$sc_id'";
         
  //1
              $s1="SELECT count(CourseLevel) FROM tbl_CourseLevel $cond1";
               $r1 = mysql_query($s1);
               $r2=mysql_fetch_array($r1);
               if ($r2[0] !=0){
                $no_of_file++;
                  $org_str++;
               }              
  //2
       $sqlDeg = "SELECT count(id) FROM tbl_degree_master $cond1"; 
               $rowD = mysql_query($sqlDeg);
               $resultD = mysql_fetch_array($rowD);
               
               if ($resultD[0] !=0){
                $no_of_file++;
                  $org_str++;
               }  

//8
               $sqlyear = "SELECT count(Academic_Year) 
               FROM tbl_academic_Year $cond1";
               $rowyear = mysql_query($sqlyear);
               $resultyear = mysql_fetch_array($rowyear);

               
               if ($resultyear[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 
   //3
               $sqlDept = "SELECT count(Dept_Name) 
               FROM tbl_department_master $cond1";
               $rowDept = mysql_query($sqlDept);
               $resultDept = mysql_fetch_array($rowDept);
               
               if ($resultDept[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 
 //4
               $sqlbranch = "SELECT count(branch_Name) 
               FROM tbl_branch_master $cond1";
               $rowbranch = mysql_query($sqlbranch);
               $resultbranch = mysql_fetch_array($rowbranch);
               if ($resultbranch[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 

 //5
               $sqlclass = "SELECT count(class) 
               FROM Class $cond1";
               $rowclass = mysql_query($sqlclass);
               $resultclass = mysql_fetch_array($rowclass);


               if ($resultclass[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 
     
 //13
      $sqlcsub = "SELECT count(subject_code) 
      FROM tbl_class_subject_master $cond1";
      $rowcsub = mysql_query($sqlcsub);
      $resultcsub = mysql_fetch_array($rowcsub);


      if ($resultcsub[0] !=0){
        $no_of_file++;
          
    } 
      
 //6
               $sqldivision = "SELECT count(DivisionName) 
               FROM Division $cond1";
               $rowdivision = mysql_query($sqldivision);
               $resultdivision = mysql_fetch_array($rowdivision);

               if ($resultdivision[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 
 //12

      $sqlbsub = "SELECT count(SubjectCode) 
      FROM Branch_Subject_Division_Year $cond1";
      $rowbsub = mysql_query($sqlbsub);
      $resultbsub = mysql_fetch_array($rowbsub);

      if ($resultbsub[0] !=0){
                $no_of_file++;
                  
               } 
   //9
               $sqlsem = "SELECT count(Semester_Name) 
               FROM tbl_semester_master $cond1";
               $rowsem = mysql_query($sqlsem);
               $resultsem = mysql_fetch_array($rowsem);

       
          if ($resultsem[0] !=0){
                $no_of_file++;
                  
               } 
 //7
               $sqlsubject = "SELECT count(subject) 
               FROM tbl_school_subject $cond1";
               $rowsubject = mysql_query($sqlsubject);
               $resultsubject = mysql_fetch_array($rowsubject);


               
          
          if ($resultsubject[0] !=0){
                $no_of_file++;
                  $org_str++;
               } 
  //10

               $sqltea = "SELECT count(t_id) 
               FROM tbl_teacher $cond1";
               $rowtea = mysql_query($sqltea);
               $resulttea = mysql_fetch_array($rowtea);                             
     
           if ($resulttea[0] !=0){
                $no_of_file++;
                  
               }  
 //11
               $sqlteasub = "SELECT count(tch_sub_id) FROM tbl_teacher_subject_master $cond1";
               $rowteasub = mysql_query($sqlteasub);
               $resultteasub = mysql_fetch_array($rowteasub);
              

               if ($resultteasub[0] !=0){
                $no_of_file++;
                  
               }  
  //14
      $sqlstud = "SELECT count(std_PRN) 
      FROM tbl_student $cond1";
      $rowstud = mysql_query($sqlstud);
      $resultstud = mysql_fetch_array($rowstud);
      
      if ($resultstud[0] !=0){
        $no_of_file++;
          
       } 
  //16
      $sqlstudsub = "SELECT count(subjcet_code) 
      FROM tbl_student_subject_master $cond1";
      $rowstudsub = mysql_query($sqlstudsub);
      $resultstudsub = mysql_fetch_array($rowstudsub);
      
      if ($resultstudsub[0] !=0){
        $no_of_file++;
          
       } 
    //15
      $sqlstudsem = "SELECT count(student_id) 
      FROM StudentSemesterRecord $cond1";
      $rowstudsem = mysql_query($sqlstudsem);
      $resultstudsem = mysql_fetch_array($rowstudsem);
      

      if ($resultstudsem[0] !=0){
        $no_of_file++;
          
       } 
    //17
      $sqlparent = "SELECT count(id) 
      FROM tbl_parent $cond1";
      $rowparent = mysql_query($sqlparent);
      $resultparent = mysql_fetch_array($rowparent);
      
      if ($resultparent[0] !=0){
        $no_of_file++;
          
       }
     
$sqlparent = "SELECT t_email 
      FROM tbl_teacher r
      INNER JOIN tbl_school_admin t on r.t_id=t.coordinator_id where r.school_id='$sc_id'";
      //echo $sqlparent ; exit;
      $rowparent = mysql_query($sqlparent);
      $resultparent1 = mysql_fetch_array($rowparent);
     
      if ($resultparent1[0] !=0){
        $no_of_file++;
          
       }
$sqlparent1 = "SELECT email FROM tbl_school_admin
                        WHERE school_id='".$row[school_id]."'";
      //echo $sqlparent1; exit;
      $rowparent1 = mysql_query($sqlparent1);
      $resultparent2 = mysql_fetch_array($rowparent1);
     
      if ($resultparent2[0] !=0){
        $no_of_file++;
          
       }
  
if ($no_of_file >=15)
{
$file_per= "100%";
} 
else
{
$percent = round(($no_of_file / 15) * 100, 2);
$file_per=  $percent ."%";
}



if ($org_str == 8)
{
$org1= "Complete";
}
elseif ($org_str == 0)
{
    $org1=  "No Data";
}
else
{
    $org1= "Partial";
}

if ($no_of_file >= 15)
{
$num_file_status= "Complete ";
}
elseif ($no_of_file == 0)
{
    $num_file_status="No Data";
}
else
{
    $num_file_status= "Partial ";
}

$user_CSV[$i] = array($i,$row['school_id'],$row['school_name'],$row['scadmin_city'],$row['scadmin_state'],$accept_term,$accept_date,$no_of_file,$file_per,$org1,$num_file_status,$resultsubject[0],$resulttea[0],$resultteasub[0],$resultstud[0],$resultstudsub[0],$resultstudsem[0],$resultparent1[0],$row['email']);
         
          } 
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

?>