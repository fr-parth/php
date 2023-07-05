<?php

  /*
  Author: Ashutosh Chauhan
  Date  :09/08/2021
  This file was created for generating Excel Report of Teacher Subject for SMC-5470
  */

  include('scadmin_header.php');

  $report = "";
  $fields = array("id" => $id);

  $smartcookie = new smartcookie();

  $results = $smartcookie->retrive_individual($table, $fields);
  $result = mysql_fetch_array($results);
  $sc_id = $result['school_id'];
  $sc_name = $result['school_name'];

  if(isset($_POST['submit']))
  {
    $year = $_POST['year'];

    if($year != ''){
        $qr="select * from tbl_teacher_subject_master where school_id='$sc_id' and AcademicYear = '$year' ";
        $rs_result=mysql_query($qr);
        $j1 = mysql_num_rows($rs_result);
        
      }
    // $qr="select * from tbl_student_subject where school_id='$sc_id'  ";
    // $rs_result=mysql_query($qr);
    // $j1 = mysql_num_rows($rs_result);
   //$_SESSION['report_header']=array("SchoolID","StudentPRN","SubjectCode","SemesterID","BranchID","SubjectID","YearID","DivisionID","SubjectName","Division","Semester","Branch","Department","CourseLevel","AcademicYear","TeacherID");
            
    ?> 
        
    <div align="center"> 
      <?php 
        if($j1>0)
        { 
          //echo "<h2>".$sc_name."</h2>";
          echo "<h3>".$j1." ".$dynamic_teacher_Subject." Downloaded Successfully"; ?>
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <?php echo "<a href='teacher_subject_data_report.php'>Back</a></h3>"; 
        }
        else
        {
          //echo "<h2>".$sc_name."</h2>";
          echo "<h3>".$dynamic_student_Subject." data not found"; ?>
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <?php echo "<a href='teacher_subject_data_report.php'>Back</a></h3>";
        } 
      ?> 
    </div> 
    
    <?php echo ("<script LANGUAGE='JavaScript'> window.location.href='export_teacher_subject.php?year=".$year."'; </script>");		
  
  }

?>

<html>
  <head>
    <script>
      function validateForm() {
      var x = document.forms["academic_yr"]["year"].value;
      if (x == "") {
      alert("Select academic year");
      return false;
  }
}
    </script>
  </head>
    
  <body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">
      <div>
      </div>
            
      <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
          <form method="post" name="academic_yr" style="height: 47%;" onSubmit="return validateForm()">

            <div style="background-color:#F8F8F8 ;height: 105%;">

            <div class="row">
                        
                        <div class="col-md-11 " align="center" style="color:#663399;" >

                              <h2>Download <?php echo $dynamic_teacher_Subject;?> Data</h2>
                        </div>

                        </div>
                      <div class="row " style="padding:5px;" >
                        <div class="col-md-2" >

                        </div>

                      </div>
                      <br>
            <div class="row " style="padding:5px;" >
               <div class="col-md-2" >

                  </div>
                  <div class="col-md-2" align="left">
                  <b><h4><?php echo $dynamic_year;?></h4></b>
                  </div>
        <div class="col-md-3">
          <!-- Query for current academic year -->
          <?php 
              $sql = mysql_query("SELECT 
              tbl_teacher_subject_master.AcademicYear
          FROM
              tbl_teacher_subject_master 
                  inner JOIN
              tbl_academic_Year ON tbl_academic_Year.Academic_Year = tbl_teacher_subject_master.AcademicYear
                  AND tbl_academic_Year.school_id = '$school_id'
                  AND tbl_teacher_subject_master.school_id = '$school_id'
                  AND tbl_academic_Year.Enable = '1'
                  group by Academic_Year;");
               $res = mysql_fetch_array($sql);
               $num = mysql_num_rows($sql);
               //echo $num;
                //echo $res['AcademicYear'];
            ?>
    <select name="year" id="year" class="smartsearch form-control" />



            <option value="<?php if($num>0){echo $res['AcademicYear'];} else{ echo '';} ?>"><?php if($num>0){echo $res['AcademicYear'];} else{ echo 'Select Academic Year';} ?></option>
            <?php $row=mysql_query("select AcademicYear from tbl_teacher_subject_master where school_id='$school_id' and AcademicYear !='' group by AcademicYear");
      while($value=mysql_fetch_array($row)){?> 
        
            <!-- <option value="<#?php echo $value['t_academic_year'];?>"><#?php echo $value['t_academic_year'];?></option> -->
            <option value="<?php echo $value['AcademicYear'];?>"><?php echo $value['AcademicYear'] ;?></option>
      <?php }?>

    </select>

                </div>
                </div>
             

                 <div class="row" style="padding-top:15px;">
                
                <div class="col-md-6 col-md-offset-4 "  >
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <!-- Changed button name for SMC-5120 by Chaitali on 26-03-2021 -->
                  <input type="submit" class="btn btn-primary" name="submit" value="Generate CSV Report" />
                  </div>
                   
                 </div>


            <div class="row" style="padding:15px;">
                  
                  </div>
        </div>
                  
            </div>
    
          </form>

        </div>
      </div>

    </div>
  
  </body>
</html>