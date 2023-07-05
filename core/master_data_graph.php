<?php
/*
Author : Pranali Dalvi
Date : 28-12-19
This file was created for displaying graph based on actual and expected records of School
*/
include('scadmin_header.php');

 $school_id = $_SESSION['school_id'];
 $group_id = $_SESSION['group_member_id'];
 $Academic_Year = mysql_query("SELECT Academic_Year,Year FROM tbl_academic_Year where school_id='$school_id' AND Enable='1'");
 $Year = mysql_fetch_assoc($Academic_Year);
 $acad_year = $Year['Academic_Year'];

//API called for getting all Master table's Data
 $url = $GLOBALS['URLNAME'].'/core/Version5/MasterData_API.php';
 $data = array('GroupID'=>$group_id, 'SchoolID'=>$school_id, 'Academic_Year'=>$acad_year, 'Semester_Type'=>'odd');

    $ch = curl_init($url);          
    $data_string = json_encode($data);    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
    $result = json_decode(curl_exec($ch),true);

    $response = $result['responseStatus'];
    $upload_status = array();

    if($response == '200'){
       $upload_status[] = $result['posts'];    
       
    }

    $student_sql = mysql_query("SELECT count(st.id) as cnt,std_PRN FROM StudentSemesterRecord ssr LEFT JOIN tbl_student st on ssr.school_id=st.school_id
        WHERE st.school_id='".$school_id."' AND ssr.AcdemicYear='".$Academic_Year."'");
    $count = mysql_fetch_assoc($student_sql);
    $cnt = $count['cnt'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />

<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #694489;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #694489;
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

.detail_color{
   color:#7647a2;
}

.detail_color:hover{
   color:#188e8e;
   font-size: 28px;
}
</style>
</head>
<body>

<div class="container">
 
  
  <div class="row" style="padding-top:10px;">
   
    <br>
    <br>
    <div class="clearfix"></div>
    <div class="col-md-12" style="padding-top:20px;">
      <div id="chartContainer" style="min-height: 600px;"></div>
      <!-- <canvas id="Mychart" style="min-height: 600px;"></canvas> -->
      <div id="top_x_div" style="height: 600px;"></div>
    </div>
  </div>
</div>
<script src="js/jquery-1.11.1.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- <script src="../js/Chart.min.js"></script> -->
    <!-- <script src="../js/chart-bar-demo.js"></script> -->
<!-- <script src="../js/jquery.canvasjs.min.js"></script>
 --><script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = google.visualization.arrayToDataTable([
          ['Move', 'Percentage', { role: 'style' }, { role: 'annotation' }],

          <?php 
          // while ($res = mysql_fetch_array($upload_status)){
            foreach ($upload_status as $result) {
                       foreach ($result as $res) {
                        if($result['tbl_display_name']=="Student")
                        $actual_count = $cnt;                         
                else
                        $actual_count = $result['uploaded_records'];
                              
                $sum += $result['weightage'];

                if($result['tbl_display_name']=="Branch-Subject-Div-Year")
                {
                    $percent = 0; 
                    $marks = 0;
                }
                else
                {
                    if($actual_count > $result['expected_records']){
                       $percent = 100; 
                    }
                    else{
                    $percent = round(($actual_count / $result['expected_records']) * 100, 2);
                    }

                    $marks = round(($percent * $result['weightage']) / 100, 2);
                }

            ?>
          ["<?= $res['school_name'];?>", <?= $percent;?>],
      <?php }
      } ?>

          // ["King's pawn (e4)", 44, '#b87333', 44],
          // ["Queen's pawn (d4)", 85, '#b17333', 85],
          // ["Knight to King 3 (Nf3)", 62, '#b37333', 62],
          // ["Queen's bishop pawn (c4)", 30, '#b57333', 30],
          // ['Other', 15, 'color: #e5e4e2', 15]
        ]);

        var options = {

          legend: { position: 'none' },
          chart: {
            title: "",
           },
          axes: {
            y: {
              0: { side: 'bottom', label: "School Name"} // Top x-axis.
            },
            x: {
              0: {label:"Percentage (out of 100)", maximum: 100}
            }
          },
          bar: { }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
  </body>
</html>