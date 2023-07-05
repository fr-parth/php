<?php

  /*
  Author:Chaitali Solapure
  Date  :02/02/2021
  This file was created for generating Excel Report of Subject for SMC-5120
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
    $qr="select * from tbl_school_subject where school_id='$sc_id'";
    $rs_result=mysql_query($qr);
    $j1 = mysql_num_rows($rs_result);
    //$_SESSION['report_header']=array("SchoolID","SubjectID","SubjectCode","Subject","SubjectType","SubjectShortName","SubjectCredit");
        
    ?> 
        
    <div align="center"> 
      <?php 
        if($j1>0)
        { 
          //echo "<h2>".$sc_name."</h2>";
          echo "<h3>".$j1." ".$dynamic_subject." Downloaded Successfully"; ?>
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <?php echo "<a href='subject_data_report.php'>Back</a></h3>"; 
        }
        else
        {
          //echo "<h2>".$sc_name."</h2>";
          echo "<h3>".$dynamic_subject." data not found"; ?>
          &nbsp;&nbsp;&nbsp;&nbsp; 
          <?php echo "<a href='subject_data_report.php'>Back</a></h3>";
        } 
      ?> 
    </div> 
        
    <?php echo ("<script LANGUAGE='JavaScript'> window.location.href='export_subject.php'; </script>");		
  
  }

?>

<html>
  <head>
  </head>
    
  <body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">
      <div>
      </div>
            
      <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
          <form method="post" style="height: 47%;">

            <div style="background-color:#F8F8F8 ;height: 105%;">

              <div class="row">
                   
                <div class="col-md-11" align="center" style="color:#663399;" >
                  <h2>Download <?php echo $dynamic_subject; ?> Data</h2>
                </div>

              </div>
                    
              <br>
                      
              <div class="row" style="padding-top:15px;">
                  
                <div class="col-md-6 col-md-offset-4">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <!-- Changed button name for SMC-5120 by Chaitali on 26-03-2021 -->
                  <input type="submit" class="btn btn-primary" name="submit" value="Generate CSV Report" />
                </div>
                     
              </div>

              <div class="row" style="padding:15px;">
                    
              </div>
                  
            </div>
    
          </form>

        </div>
      </div>

    </div>
  
  </body>
</html>