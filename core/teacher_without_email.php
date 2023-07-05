
<?php
include("cookieadminheader.php");
?>
<?php


$sql=mysql_query("select * from tbl_teacher where t_email=''");
$t_phone=mysql_query("select * from tbl_teacher where t_phone=''");
$t_phone_email =mysql_query("select * from tbl_teacher where t_phone='' and   t_email='' ");

$sql1=mysql_num_rows($sql);

$t_phone_email=mysql_num_rows($t_phone_email);

$s_phone_email =mysql_query("select * from tbl_student where std_phone='' and   std_email='' ");
$std_email =mysql_query("select * from tbl_student where std_email='' ");
$std_phone =mysql_query("select * from tbl_student where std_phone=''");
$s_phone_email=mysql_num_rows($s_phone_email);
$std_email=mysql_num_rows($std_email);
$std_phone=mysql_num_rows($std_phone);

echo  $sql1;



?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
	  var spge = '<?php echo $sql1 ;?>';
	  //alert(spge);
	   
      function drawChart() {
		  //alert(spge);
        var data = google.visualization.arrayToDataTable([
          ['teacher_without_email',      spge],
          ['teacher_without_phone',     11],
          ['teacher_without_emailandphone',      2],
          ['student_without_phone',  2],
          ['student_without_email', 2],
          ['student_without_emailandphone',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  
  <body>
    <div id="piechart_3d" style="width: 1000px; height: 500px;"></div>
  </body>
</html>
