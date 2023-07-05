    <?php
	 include("conn.php");
	 $id=$_SESSION['id'];
	 $sql=mysql_query("select std_PRN from tbl_student where id='$id'");
	 $resultset=mysql_fetch_array($sql);
	 $std_PRN=$resultset['std_PRN'];

$result=mysql_query("SELECT sc_point as total_point, sc_studentpointlist_id, t.t_complete_name as teacher_name, point_date , IF( activity_type = 'subject', (select subjectName from tbl_student_subject_master where subjcet_code=sc_studentpointlist_id  and student_id='$std_PRN'), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sc_studentpointlist_id ) ) AS sc_list FROM tbl_student_point sp JOIN tbl_teacher t ON sc_teacher_id = t.t_id WHERE sp.sc_entites_id =103 AND sp.sc_stud_id ='$std_PRN'  ");


	
	 /*?>$result=mysql_query("SELECT tbl_studentpointslist.sc_list,SUM(tbl_student_point.sc_point) as total FROM tbl_studentpointslist, tbl_student_point
	WHERE tbl_studentpointslist.sc_id = tbl_student_point.sc_studentpointlist_id  and sc_stud_id =  "  .$_SESSION['id'].
	 "  GROUP BY  tbl_student_point.sc_studentpointlist_id");<?php */
 
	$result1=mysql_num_rows($result);

	$stack = array();
	if($result1>0)
	{
		 while($row = mysql_fetch_assoc($result))
		{
		
 		array_push($stack, $row["sc_list"], $row["total_point"]);


		
		}
	$value=sizeof($stack);
		
	}
	
	
	
?>



<html>
    <head>
    <title>My first chart using FusionCharts Suite XT</title>
    <script type="text/javascript" src="fusioncharts.js"></script>
    <script type="text/javascript" src="themes/fusioncharts.theme.zune.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      <script type="text/javascript" src="jchart.js"></script>
    
    <script type="text/javascript">
    FusionCharts.ready(function(){

    var revenueChart = new FusionCharts({
    type: "column2d",
    renderAt: "chartContainer",
    width: "100%",
    height: "100%",
    dataFormat: "json",
    dataSource: {
    "chart": {
    "caption": "Points for activity",
    "subCaption": "",
    "xAxisName": "Activity",
    "yAxisName": "Points",
    "theme": "zune"
    },
	
	
    "data": [
	<?php 
	
	$i=0; while($i<$value){ ?>
    {
	"label": "<?php echo($stack[$i]);$i++; ?>",
    "value": "<?php echo($stack[$i]);?>"
	},
   
   <?php $i++;}?>
    ]
    }
     
    });
    revenueChart.render("chartContainer");
    });
     
    </script>
    </head>
    <body>
    <div id="chartContainer" >FusionCharts XT will load here!</div>
    </body>
    </html>


   