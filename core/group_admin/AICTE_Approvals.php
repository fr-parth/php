<?php

include("groupadminheader.php");
//echo $_SERVER['SERVER_NAME']; exit;
error_reporting(0);
$group_member_id = $_SESSION['group_admin_id'];

if(isset($_POST['submit'])){
session_start();

 $check=$_POST['submit'];
 $school_id=$_POST['school_id'];
 $_SESSION["school_id"]= $school_id;
if($school_id!='')
{
  //join aicte_college_info on aicte_college_info.college_id=tbl_school_admin.school_id
   $sqln1="SELECT * FROM tbl_school_admin WHERE school_id='$school_id'";


     $qr1="SELECT expected_records,school_id FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Course Level'";
                       
      $qr11="SELECT MAX(updated_date)as b,count(id) as a  FROM tbl_CourseLevel where school_id='$school_id'";
       $qr12="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_CourseLevel where school_id='$school_id' and batch_id IS NOT NULL";
                                        
      $qr13="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_CourseLevel where school_id='$school_id' and batch_id IS NULL";
                       
      $qr14="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Degree Master'";
                       
        $qr15="SELECT MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id'";
          
           $qr16="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id' and batch_id IS NOT NULL";
                                   
        $qr17="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_degree_master where school_id='$school_id' and batch_id IS NULL";
                       
       $qr18="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Department'";
                     
        $qr19="SELECT count(id) as a FROM tbl_department_master where school_id='$school_id'";
        $qr20="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_department_master where school_id='$school_id' and batch_id IS NOT NULL";
                                  
        $qr21="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_department_master where school_id='$school_id' and batch_id IS NULL";
                        
       $qr22="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Branch Master'";
                      
        $qr23="SELECT count(id) as a FROM tbl_branch_master where school_id='$school_id'";
          
        $qr24="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_branch_master where school_id='$school_id' and batch_id IS NOT NULL";
                       
        $qr25="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_branch_master where school_id='$school_id' and batch_id IS NULL";

          $qr26="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Master'";
           $qr27="SELECT count(id) as a FROM Class where school_id='$school_id'";
            $qr28="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Class where school_id='$school_id' and batch_id IS NOT NULL";
                       
          $qr29="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Class where school_id='$school_id' and batch_id IS NULL";
               
                $qr30="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Division Master'";
                                 
         $qr31="SELECT count(id) as a FROM Division where school_id='$school_id'";
        $qr32="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Division where school_id='$school_id' and batch_id IS NOT NULL";
        $qr33="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM Division where school_id='$school_id' and batch_id IS NULL";
        $qr34="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Subject'";
                                                                              
        $qr35="SELECT count(id) as a FROM tbl_school_subject where school_id='$school_id'";
                       
        $qr36="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_school_subject where school_id='$school_id' and batch_id IS NOT NULL";
                       
       $qr37="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_school_subject where school_id='$school_id' and batch_id IS NULL";
                      
 $qr38="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Academic Year'";
                     
 $qr39="SELECT count(id) as a FROM tbl_academic_Year where school_id='$school_id'";
                      
 $qr40="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_academic_Year where school_id='$school_id' and batch_id IS NOT NULL";
 $qr41="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_academic_Year where school_id='$school_id' and batch_id IS NULL";
                      
 $qr42="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Master'";
                      
 $qr43="SELECT count(id) as a FROM StudentSemesterRecord where school_id='$school_id'";
                      
 $qr44="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NOT NULL";
                      

$qr45="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NULL";
                       
 $qr46="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Teacher'";
                     
  $qr47="SELECT count(id) as a FROM tbl_teacher where school_id='$school_id'";
                      
 $qr48="SELECT MAX(created_on)as c,MAX(updated_date)as b,count(id) as a FROM tbl_teacher where school_id='$school_id' and batch_id IS NOT NULL";
 $qr49="SELECT MAX(created_on)as c,MAX(updated_date)as b,count(id) as a FROM tbl_teacher where school_id='$school_id' and batch_id IS NULL";
  $qr50="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Teacher Subject'";
    $qr51="SELECT count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id'";
                         
 $qr52="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id' and batch_id IS NOT NULL";

  $qr53="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(tch_sub_id) as a FROM tbl_teacher_subject_master where school_id='$school_id' and batch_id IS NULL";
                     
  $qr54="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Branch-Subject-Div-Year'";
  $qr55="SELECT count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id'";
                     
 $qr56="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id' and batch_id IS NOT NULL";
                      
  $qr57="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM Branch_Subject_Division_Year where school_id='$school_id' and batch_id IS NULL";
                    
  $qr58="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Class Subject'";
  $qr59="SELECT count(id) as a FROM tbl_class_subject_master where school_id='$school_id'";
   $qr60="SELECT MAX(uploaded_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_class_subject_master where school_id='$school_id' and batch_id IS NOT NULL";
   $qr61="SELECT MAX(uploaded_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_class_subject_master where school_id='$school_id' and batch_id IS NULL";
                                                  
 $qr62="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student'";
                      
                     $qr63="SELECT count(id) as a FROM tbl_student where school_id='$school_id'";
                      $qr64="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student where school_id='$school_id' and batch_id IS NOT NULL";


                       $qr65="SELECT MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student where school_id='$school_id' and batch_id IS NULL";
                       
                       $qr66="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student Semester'";


 $qr67="SELECT count(id) as a FROM StudentSemesterRecord where school_id='$school_id'";
                      $qr68="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NOT NULL";
                       
 $qr69="SELECT MAX(created_date)as c,MAX(updated_date)as b,count(id) as a FROM StudentSemesterRecord where school_id='$school_id' and batch_id IS NULL";
                     
$qr70="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Student Subject'";
                       
 $qr71="SELECT count(id) as a FROM tbl_student_subject_master where school_id='$school_id'";
                      
 $qr72="SELECT  MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student_subject_master where school_id='$school_id' and batch_id IS NOT NULL";
     $qr73="SELECT  MAX(upload_date)as c,MAX(updated_date)as b,count(id) as a FROM tbl_student_subject_master where school_id='$school_id' and batch_id IS NULL";
                                         
    $qr74="SELECT MAX(updated_date)as b,expected_records FROM tbl_school_datacount where school_id='$school_id' and tbl_display_name='Parents'";
                    
                      $qr75="SELECT count(id) as a FROM tbl_parent where school_id='$school_id'";
                       
                        $qr76="SELECT MAX(old_uploaded_date_time)as c,MAX(updated_date)as b,count(id) as a FROM tbl_parent where school_id='$school_id' and batch_id IS NOT NULL";

                        $qr77="SELECT MAX(old_uploaded_date_time)as c,MAX(updated_date)as b,count(id) as a FROM tbl_parent where school_id='$school_id' and batch_id IS NULL";
                       

                      
                        
}

 }
 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<script src="../js/select2.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="../css/select2.min.css" rel="stylesheet" />
<style>
    @media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
            display: block;
        }
        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        #no-more-tables tr {
            border: 1px solid #ccc;
        }
        #no-more-tables td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
            white-space: normal;
            text-align: left;
            font: Arial, Helvetica, sans-serif;
        }
        #no-more-tables td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            padding-right: 10px;
            white-space: nowrap;
        }
        /*
        Label the data
        */
        #no-more-tables td:before {
            content: attr(data-title);
        }
    }

    /*for loader*/
    .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    
   
</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">
    <div class="container-fluid" style="padding:30px;width:1152px">
       

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div style="color:#700000 ;padding:5px;" >
                        <div class="col-md-4">
                        
                         </div>
                      
                        <div class="col-md-6 " align="center">
                            <h2>AICTE 360 Degree Feedback Status</h2>
                        </div>
                         </div>
                         
                     </div>
               
                <div class="clearfix"></div>
                <br>
                  
                    </div>
                    <br>
          <form method="post" id="frm">
                  
             <div class="row" id="myform">
                
             
             </div>
 <?php
                                    $arr = mysql_query($sqln1);
                                  // $row1 = mysql_fetch_array($arr);//print_r(count($row1));die;
                                    while ($row = mysql_fetch_array($arr)) {
                                    $country = $row['scadmin_country'];
                                    $state = $row['scadmin_state'];
                                    $city = $row['scadmin_city'];
                                    $status = $row['is_accept_terms'];
                                    if($status=='1'){$a="Yes";}else{$a="No";}
                                    $school_name=$row['school_name'];
                                    $school_id=$row['school_id'];



                                }
                                
                ?>
             <div class="row" id="show">
                          <div class="col-md-12">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Search College By AICTE PID</label>
                                <div class="col-sm-3" id="typeedit">
                                  <input type="text" name="school_id" id="scl_id" value="<?php echo $school_id?>" class="form-control">
                                </div>
                              <div class="col-sm-2" >
                         <div class="form-group">
            <button type="submit" value="Submit" style="" name="submit" id="sub1" class="btn btn-primary">Submit</button>
                        <button type="submit" value="Reset" id="reset1" style="" name="submit" class="btn btn-danger">Reset</button>

          </div>
            </div>





                            </div> 
                 
                        </div>
                  
           </div>

           <div class="row" id="show" style="padding-left: 25px;">
                         
                    
           </div>
      <div id="submit_hide" style="display:<?php if($_POST['submit']=='Submit'){echo 'none'; }else{echo 'block';}?>">      
   <div class="row">
          <div class="col-md-6" style="padding-left: 33px;">
            <div class="form-group">

            <a  id="pid_college_btn" class="btn btn-primary" href="../../college_id/home.php">Search PID by College Name</a>
          

          </div>
          </div> 
  </div>
<div class="row">
          <div class="col-md-6" style="padding-left: 33px;">
            <div class="form-group">

               <a id="activation_report_btn" class="btn btn-primary" href="AICTE_Approval_report.php">AICTE Activation Report by State/City</a>
          

          </div>
          </div> 
  </div>
</div>

       <div id="college_info" style="display:<?php if($_POST['submit']=='Submit'){echo 'block'; }else{echo 'none';}?>">
        <?php if($_POST['submit']=='Submit'){?>
        <div class="row">
        <div class="col-md-offset-3 col-md-2">
                                    <a href="csv_aicte_approvals_report.php">
                                        <button type="button" class="btn btn-info pull-right" name="export">Export to CSV</button>
                                   </a> 
                                </div>
          <div class="col-md-6">
             <div class="form-group">
    <label for="type" class ="control-label col-sm-4" style="vertical-align:bottom;">College Name:</label>
                                <div class="col-sm-8" id="">
                                  <label><?php echo $school_name;?></label>
                 
                                </div>
                            </div> 




                 </div>
                        </div>
         <div class="row" id="show">
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Country:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <label><?php echo $country;?></label>
                                </div>
                            </div> 
                             </div>

                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">State:</label>
                                <div class="col-sm-8" id="">
                                  <label><?php echo $state;?></label>
                 
                                </div>
                            </div> 
                         </div>

                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">City:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <label><?php echo $city;?></label>
                                </div>
                            </div> 
                             </div>

                             <div class="col-md-3">
                            <div class="form-group">
                                <label for="type" class ="control-label col-sm-4">Active:</label>
                                <div class="col-sm-8" id="typeedit">
                                  <label><?php echo $a;?></label>
                                </div>
                            </div> 
                             </div>


                           
           </div>
              
                    <div class="row" style="padding:10px;">
                        <div class="col-md-12  " id="">
                         

                            <table class="table-bordered  table-condensed cf" id="" width="100%;">
                                <thead>
                                <tr style="background-color:#694489;color:white">
                                 <th style="text-align: center;"> Sr. No.</th>
                    <th>Data File Name </th>
                    <th style="text-align: center;"> Expected </th>
                    <th style="text-align: center;"> No of Records</th>
                  <!--   <th> New Data </th>
                  -->   <th style="text-align: center;" colspan="2"> Batch Upload</th>
                    <th style="text-align: center;" colspan="2">Manual Upload</th>
          
                              </tr>
                                </thead>
                              
                                     <tbody id="">
                            
                 <tr>
                   <td style="text-align: center;" data-title="Sr.No" ></td>
                   <td data-title="Teacher ID" ></td>
                   <td data-title="Name" ></td>
                   <td data-title="Teacher ID" ></td>
                   <td style="text-align: center;" data-title="Name" >By Batch</td>
                  
                   <td data-title="Name" >Batch Date</td>
                    <td style="text-align: center;" data-title="Name" >By Manual</td>
                  
                   <td data-title="Name" >Manual Date</td>
                  
                           
                                
                  </tr>


                 <tr>
                   <td style="text-align: center;"data-title="Sr.No" ><b>1</b></td>
                   <td data-title="Teacher ID" ><b>Course Level</b></td>
                   <td style="text-align: center;" data-title="Name" >
                     <?php  

                        $a=mysql_query($qr1);
                        $qr2=mysql_fetch_array($a);
                        echo $qr2['expected_records'];
                        //echo $qr2['school_id']
                     ?>

                   </td>
                   <td style="text-align: center;" data-title="Name" >
                     <?php  
                          $a=mysql_query($qr11);
                         $qr3=mysql_fetch_array($a);
                         echo $qr3['a'];
                       //  echo $qr3['b'];
                          
                          
                     ?>


                   </td>
                     <td style="text-align: center;" data-title="Sr.No" >
                       
                        <?php  
                          $a=mysql_query($qr12);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                     </td>
                  
                   <td data-title="Name" ><?php  $a=mysql_query($qr12);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }
                          
                         ?></td>
                          <td style="text-align: center;" data-title="Teacher ID" >
                      <?php  
                           $a=mysql_query($qr13);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   <td data-title="Name" ><?php  $a=mysql_query($qr13);
                         $qr2=mysql_fetch_array($a);
                        

                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                         
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;"data-title="Sr.No" ><b>2</b></td>
                   <td data-title="Teacher ID" ><b>Degree</b></td>
                   <td style="text-align: center;"data-title="Name" >
                     <?php  
                         $a=mysql_query($qr14);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                     <?php  
                           $a=mysql_query($qr15);
                         $qr3=mysql_fetch_array($a);
                         echo $qr3['a'];
                     ?>
                   </td>
                  
                   <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                          $a=mysql_query($qr16);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                
                   <td data-title="Name" ><?php  $a=mysql_query($qr16);
                         $qr2=mysql_fetch_array($a);
                         

                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                          ?></td>
                           
                              <td style="text-align: center;" data-title="Teacher ID" >
                      <?php  
                           $a=mysql_query($qr17);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                            <td data-title="Name" ><?php  $a=mysql_query($qr17);
                         $qr2=mysql_fetch_array($a);
                        
                            if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                          ?></td>
                           
                                
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;"data-title="Sr.No" ><b>3</b></td>
                   <td data-title="Teacher ID" ><b>Department</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr18);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr19);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                         $a=mysql_query($qr20);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                 
                    <td data-title="Name" ><?php $a=mysql_query($qr20);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                         $a=mysql_query($qr21);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                          <td data-title="Name" ><?php $a=mysql_query($qr21);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }
                         ?></td>
                             
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>4</b></td>
                   <td data-title="Teacher ID" ><b>Branch</b></td>
                    <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr22);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr23);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                 
                    <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr24);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                    <td data-title="Name" ><?php  $a=mysql_query($qr24);
                         $qr2=mysql_fetch_array($a);
                         
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }



                         ?></td>

                         <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr25);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>

                           <td data-title="Name" ><?php  $a=mysql_query($qr25);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>5</b></td>
                   <td data-title="Teacher ID" ><b>Class</b></td>
                    <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr26);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr27);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                          $a=mysql_query($qr28);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                 



                    <td data-title="Name" ><?php $a=mysql_query($qr28);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr29);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                         <td data-title="Name" ><?php $a=mysql_query($qr29);
                         $qr2=mysql_fetch_array($a);
                         
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                          
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>6</b></td>
                   <td data-title="Teacher ID" ><b>Division</b></td>
                  <td style="text-align: center;" data-title="Name" >
                      <?php  
                        $a=mysql_query($qr30);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr31);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                            $a=mysql_query($qr32);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  


  <td data-title="Name" ><?php  $a=mysql_query($qr32);
                         $qr2=mysql_fetch_array($a);
                         
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }



                         ?></td>
                          <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                          $a=mysql_query($qr33);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
        <td data-title="Name" ><?php  $a=mysql_query($qr33);
                         $qr2=mysql_fetch_array($a);
                         
                           if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                        
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>7</b></td>
                   <td data-title="Teacher ID" ><b>Subject</b></td>
                    <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr34);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr35);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                 
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                          $a=mysql_query($qr36);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  


    <td data-title="Name" ><?php $a=mysql_query($qr36);
                         $qr2=mysql_fetch_array($a);
                         
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                          <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr37);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
      <td data-title="Name" ><?php $a=mysql_query($qr37);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                            
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>8</b></td>
                   <td data-title="Teacher ID" ><b>Acadmic Year</b></td>
                  <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr38);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr39);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                          $a=mysql_query($qr40);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  


    <td data-title="Name" ><?php $a=mysql_query($qr40);
                         $qr2=mysql_fetch_array($a);
                         
                            if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                          <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr41);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
       <td data-title="Name" ><?php $a=mysql_query($qr41);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>9</b></td>
                   <td data-title="Teacher ID" ><b>Semester</b></td>
                  <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr42);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr43);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr44);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                 


   <td data-title="Name" ><?php  $a=mysql_query($qr44);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                           <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr45);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
              <td data-title="Name" ><?php  $a=mysql_query($qr45);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>10</b></td>
                   <td data-title="Teacher ID" ><b>Teachers</b></td>
                  <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr46);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr47);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr48);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  


   <td data-title="Name" ><?php  $a=mysql_query($qr48);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           
                            <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr49);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
<td data-title="Name" ><?php  $a=mysql_query($qr49);
                         $qr2=mysql_fetch_array($a);
                         if($qr2['b']=='')
                         {
                          echo "";
                         }
                          else if($qr2['b']=='0000-00-00 00:00:00')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else
                         {
                            echo date("Y-m-d", strtotime($qr2['b']));
                         }

                          ?></td>
                           

                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>11</b></td>
                   <td data-title="Teacher ID" ><b>Teacher Subject</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr50);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr51);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                            $a=mysql_query($qr52);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   


    <td data-title="Name" ><?php $a=mysql_query($qr52);
                         $qr2=mysql_fetch_array($a);
                         if($qr2['b']=='')
                         {
                          echo "";
                         }
                          else if($qr2['b']=='0000-00-00 00:00:00')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else
                         {
                            echo date("Y-m-d", strtotime($qr2['b']));
                         }

                          ?></td>
                         <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr53);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
        <td data-title="Name" ><?php $a=mysql_query($qr53);
                         $qr2=mysql_fetch_array($a);
                         if($qr2['b']=='')
                         {
                          echo "";
                         }
                          else if($qr2['b']=='0000-00-00 00:00:00')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else
                         {
                            echo date("Y-m-d", strtotime($qr2['b']));
                         }

                          ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>12</b></td>
                   <td data-title="Teacher ID" ><b>Subject Division</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr54);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr55);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr56);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   


     <td data-title="Name" ><?php $a=mysql_query($qr56);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                          ?></td>
                         <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                            $a=mysql_query($qr57);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
      <td data-title="Name" ><?php $a=mysql_query($qr57);
                         $qr2=mysql_fetch_array($a);
                           
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>13</b></td>
                   <td data-title="Teacher ID" ><b>Class Subject</b></td>
                    <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr58);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr59);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                            $a=mysql_query($qr60);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                     <td data-title="Name" ><?php  $a=mysql_query($qr60);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }



                         ?></td>
                          <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr61);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?></td>
                          <td data-title="Name" ><?php  $a=mysql_query($qr61);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>14</b></td>
                   <td data-title="Teacher ID" ><b>Student</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr62);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr63);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                    
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr64);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                      <td data-title="Name" ><?php  $a=mysql_query($qr64);
                         $qr2=mysql_fetch_array($a);
                        
                         if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>

 <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                          $a=mysql_query($qr65);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?> </td>
                           <td data-title="Name" ><?php  $a=mysql_query($qr65);
                         $qr2=mysql_fetch_array($a);
                        
                            if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }


                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>15</b></td>
                   <td data-title="Teacher ID" ><b>Student Semester</b></td>
                  <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr66);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                          $a=mysql_query($qr67);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                            $a=mysql_query($qr68);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   

                        <td data-title="Name" ><?php $a=mysql_query($qr68);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                         <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                            $a=mysql_query($qr69);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>   </td>

                            <td data-title="Name" ><?php $a=mysql_query($qr69);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                           
                                
                  </tr>
                 
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>16</b></td>
                   <td data-title="Teacher ID" ><b>Student Subject</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr70);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                           $a=mysql_query($qr71);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr72);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                   
                     <td data-title="Name" ><?php $a=mysql_query($qr72);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                         <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                          $a=mysql_query($qr73);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>    </td>
                          <td data-title="Name" ><?php $a=mysql_query($qr73);
                         $qr2=mysql_fetch_array($a);
                        
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                           
                                
                  </tr>
                  <tr>
                   <td style="text-align: center;" data-title="Sr.No" ><b>17</b></td>
                   <td data-title="Teacher ID" ><b>Parents</b></td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                        $a=mysql_query($qr74);
                        $qr3=mysql_fetch_array($a);
                        echo $qr3['expected_records'];
                     ?>
                   </td>
                   <td style="text-align: center;" data-title="Name" >
                      <?php  
                         $a=mysql_query($qr75);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                    
                   <td style="text-align: center;" data-title="Phone" >
                     <?php  
                           $a=mysql_query($qr76);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?>
                   </td>
                  
                         <td data-title="Name" ><?php $a=mysql_query($qr76);
                         $qr2=mysql_fetch_array($a);
                       
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>

                          <td style="text-align: center;" data-title="Sr.No" >
                      <?php  
                           $a=mysql_query($qr77);
                         $qr2=mysql_fetch_array($a);
                         echo $qr2['a'];
                     ?> </td>

                          <td data-title="Name" ><?php $a=mysql_query($qr77);
                         $qr2=mysql_fetch_array($a);
                                                   
                          if($qr2['b']=='0000-00-00 00:00:00' && $qr2['c']!='0000-00-00 00:00:00' && $qr2['c']!='')
                         {
                           echo date("Y-m-d", strtotime($qr2['c'])); 
                         }
                         else if($qr2['b']!='0000-00-00 00:00:00' && $qr2['c']=='0000-00-00 00:00:00' && $qr2['b']!='' )
                                                {
                           echo date("Y-m-d", strtotime($qr2['b'])); 
                         }
                         else
                         {
                            echo "";
                         }

                         ?></td>
                           
                                
                  </tr>
                 

                         
                                </tbody>
                            </table>
                        </div>
                    </div>
                  <?php } ?>
  </div>

                     </form>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
</body>
   
</html>

<script type="text/javascript">
  $(document).ready(function(){
    $('#reset1').click(function(){        
     
        $('#frm #scl_id').val('');
      });         
   
  });

</script>