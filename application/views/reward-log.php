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
<title>Reward Log</title>
<body>
    <!--END THEME SETTING-->
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                      <div class="page-title">Reward Points Log</div>
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
                        <ul id="generalTab" class="nav nav-tabs responsive">
                            <li class="active"><a href="#teacher" data-toggle="tab">
							
							<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></a></li>							
                          <?php 
						 if($studentinfo[0]->status=='')
						 {?>  <li><a href="#Student-Coordinator" data-toggle="tab">Student <?php echo ($this->session->userdata('usertype')=='employee')?'':'Coordinator'; ?></a></li>						
						 <?php }?>							<li ><a href="#schooladmin" data-toggle="tab"><?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Admin</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="teacher" class="tab-pane fade in active">
                                <div class="row">
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>
											<?php echo ($this->session->userdata('usertype')=='employee')?'Activity/Project':'Activity/Subject'; ?>
											
											</th>
                                            <th>Points</th>
                                            <th >
											<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name</th>
                                            <th >Date Time</th>
											

                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($rewardinfo as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            <td data-title="Reason"><?php echo $t->reason ;?></td>
                                            <td data-title="Points" ><?php echo $t->sc_point;?></td>
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php if($t->t_complete_name=="")											{												echo ucwords(strtolower($t->t_name." ".$t->t_lastname));											}											else											{												echo ucwords(strtolower($t->t_complete_name));																							}												;?></td>
                                            <?php
											//Author VaibhavG. commented below code for the ticket number SMC-3473 22Sept18
												//Author VaibhavG. changed below date format code for the ticket number SMC-3253 18Aug18 6:50PM
												 /*$originalDate = $t->point_date;
												if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) \d{2}:\d{2}:\d{2}$/",$originalDate)) 
												{
													$newDate = date("d/m/Y", strtotime($originalDate));
												} else {
													$newDate = $t->point_date;
												}*/	
											?>
											<td data-title="Date Time"><?php echo $t->point_date;?></td>
											
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>												   								
							<div id="schooladmin" class="tab-pane fade">									
							<div class="row">										
							<div id="no-more-tables">											
<!--style added for example1 & example2 by Pranali for bug SMC-3559 -->							
<table class="table table-bordered table-hover " id="example1" style="margin-left: 0px !important;">												
							<thead class="cf">												
							<tr>                                           
							<th>Sr.No.</th>                                            <th><?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Admin Name</th>                                            <th>Reason</th>                                            <th >Points</th>																						                                            <th >Date Time</th>                                        </tr>                                        </thead>                                        <tbody>                                           <!--php code rewards function-->										   										   <?php                                             $i=1;                                            foreach($rewardschooladmin as $t) {?>                                        <tr>                                            <td data-title="Sr.No"><?php echo $i;?></td>								<!--Added school admin name by Sayali Balkawade for SMC-3846 on 13/12/2019-->														<td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Admin Name" ><?php echo $t->name;?></td>                                            <td data-title="Reason"><?php echo $t->sc_list ;?></td>                                            <td data-title="Points" ><?php echo $t->sc_point;?></td>                                            <td data-title="Date Time"><?php echo $t->point_date; ?></td>                                        </tr>										<?php $i++;}?>										   											</tbody>											</table>									</div>                                                            </div>							</div>																																																																						
							<?php 
						 if($studentinfo[0]->status=='')
						 {?>
                            <div id="Student-Coordinator" class="tab-pane fade">
                                <div class="row">
                                 <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example2" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Activity/Subject</th>
                                            <th>Points</th>
                                    		<th>Coordinator Name</th>

                                            <th >On Behalf of Teacher</th>
                                            <th >Date Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($rewardcoordinatorlog as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No" style="width:5%;"><?php echo $i;?></td>
                                            <td data-title="Reason" style="width:10%;"><?php echo $t->reason ;?></td>
                                            <td data-title="Points" style="width:8%;"><?php echo $t->sc_point;?></td>
                                              <td data-title="Co-ordinator Name" ><?php echo ucwords(strtolower($t->coordinator));?></td>
                                            <td data-title="Teacher Name" ><?php echo ucwords(strtolower($t->teacher)) ;?></td>
                                            <td data-title="Date Time"><?php echo $t->point_date;?></td>
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                          	<?php 
						 } ?>
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