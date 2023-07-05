
<?php
$this->load->view('stud_header', $studentinfo);
//print_r($studentinfo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script>

    $(document).ready(function(){$('#example').dataTable();});

</script>
</head>
<title>Water Points Log</title>
<body>

<!--END THEME SETTING-->
<!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->

    <div id="area-chart-spline" style="width: 100%; height:300px; display:none;">
    </div>
        <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->


    <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
    <div class="page-title">Water Points Log</div>

    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right">

        </i>&nbsp;&nbsp;</li>
        <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Water Points Log</li>
    </ol>
        <div class="clearfix">

        </div>
        </div>
        <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
        <div class="page-content">
        <div class="row">
        <div class="col-lg-12">
        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
        <div id="teacher" class="tab-pane fade in active">


        <div class="row">

        <div id="no-more-tables">
            <!--/*<php
          //    print_r($studentinfo)
        //?>-->
        <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
        <thead class="cf">

        <tr>
            <th>Sr.No.</th>
            <th>Points</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>



<?php
//$i=1;
$i++;
$combined_array = array_merge($student_water_points_log, $student_water_points_log1);
//print_r($student_water_points_log1);
foreach ($student_water_points_log as $t) {
?>
 <tr>
     <td data-title="Sr.No"><?php echo $i; ?></td>
     <td data-title="Points"><?php echo $t->points; ?></td>
     <td data-title="Reason">
  <?php
if (is_numeric($t->coupon_id)) {
        echo "purchased from Cookie Admin";
    } 
else {
        echo $t->coupon_id;
    }
    ?></td>

    <td data-title="Reason">
                <?php
echo date('d-m-Y H:i:s', strtotime($t->issue_date));

    ?>
           </td>
		</tr>
        <?php
$i++;
}?>
        </tbody>
        </table>

        </div>
        </div>

     </div>
    </div>
    <!--END CONTENT--><!--BEGIN FOOTER-->


    <!--END PAGE WRAPPER-->
    <?php
$this->load->view('footer');
?>

     <!--END CONTENT--><!--BEGIN FOOTER-->

     </div>
     </body>
     </html>
     <?php
?>










