<!--Below code added by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3479 on 25/04/2019-->	


<?php 
//print_r($schoolinfo);
$this->load->view('stud_header',$studentinfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!--dataTable() for example2 added by Pranali for bug SMC-3559 -->
<script>
        $(document).ready(function() {
            $('#example').dataTable( {
         });
		 
			$('#example1').dataTable( {
         });
		 $('#example2').dataTable( {
         });
        } );
        </script>
</head>
<title>Brown Log</title>
<body>
    <!--END THEME SETTING-->
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                      <div class="page-title">Brown Points Log</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Reward Points</li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div id="generalTabContent" class="tab-content responsive">
                            <div  class="tab-pane fade in active">
                                <div class="row">
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Reason</th>
                                            <th>Points</th>
                                            <th>Receiver Name</th>
                                            <th>Date Time</th>
                                         
											

                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
											
											
                                            foreach($loginfo as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            <td data-title="Reason"><?php echo $t->reason ;?></td>
                                            <td data-title="Points" ><?php echo $t->sc_point;?></td>
                                            <td data-title="Receiver Name" ><?php echo ucwords(strtolower($t->firstname." ".$t->middlename." ".$t->lastname));?></td>
                                            <td data-title="Date Time" ><?php echo $t->point_date;?></td>
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
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