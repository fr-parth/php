<?php
include('scadmin_header.php');

if(isset($_POST['submit_feedback']))
{
    $det = $_POST['feedback_summary'];
    $feedback_array = explode(',',$det);
    // print_r($feedback_array);
    $sem = $feedback_array[0];
    $sub = $feedback_array[1];
    $acad = $feedback_array[2];
    $t_id = $feedback_array[3];
    $sc_id = $feedback_array[4];
}
//  exit;

$url = $GLOBALS['URLNAME']."/core/Version6/360_feedback_report_summary.php";
// echo $url;
// echo "<br>";

$data = array("school_id"=>$sc_id,
                "teacher_id"=>$t_id,
                "stu_feed_semester_ID"=>$sem,
                "stud_subjcet_code"=>$sub,
                "academic_year"=>$acad
            );
// print_r($data);exit;
$data_string = json_encode($data); 
$arr = post_function($url,$data_string);
$std_feed_summary = json_decode($arr,TRUE);
// print_r($std_feed_summary);
// exit;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Student Feedback Summary</title>
        
         <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {
            $('#example').dataTable( {
            "paging":   false,
            "info":false,
            "searching": false,
            //"scrollCollapse": true
            
            } );
        } );
    </script>
    </head>
    <body bgcolor="#CCCCCC">
    <div style="bgcolor:#CCCCCC">
        <div class="container">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-3"  style="color:#700000 ;">
                        <a href="teaching_process.php?t_id=<?php echo $t_id;?>"><button class="btn btn-light" style="margin-top: 21px; margin-left:11px;">Back to Teaching Process</button></a>
                    </div>
                    <div class="col-md-6 " align="center">
                        <h2>Student Feedback Summary</h2>
                    </div>
                    <div class="col-md-3"  style="color:#700000 ;">
                    </div>
                </div>
                <div class="table-responsive style" style="padding:10px;">
                    <table id="example" class="table table-bordered" >
                        <thead>
                            <tr style="background-color:#428BCA;color:#FFFFFF;height:30px;">
                                <th style="width: 10%;">Question ID</th>
                                <th>Question </th>
                                <th>Average Points</th>
                            </tr>
                        </thead>
                        
                            <?php 
                                foreach($std_feed_summary['posts'] as $rows){
                                    if(($rows['stu_feed_que_id']=='3') || ($rows['stu_feed_que_id']=='6')) { ?>
                                <tr>
                                        <td><?php echo $rows['stu_feed_que_id'] ?></td>
                                        <td><?php echo $rows['stu_feed_que'] ?></td>
                                         <td> </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td><?php echo $rows['stu_feed_que_id'] ?></td>
                                        <td><?php echo $rows['stu_feed_que'] ?></td>
                                    
                                        <td><?php  echo $rows['avgpoints']  ?></td>
                                    </tr>
                            <?php } }
                            ?>
                        
                    
                    </table>
                </div>
                
            </div>
        </div>
    </div>
    </body>
</html>