<?php $this->load->view('stud_header',$studentinfo);?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Employee Activity Summary Report</title>
	<script>
        $(document).ready(function() {
            $('#example').dataTable();
        });
    </script>
</head>
<body>  
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Employee Activity Summary</div>
                </div>
				
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   <!-- <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">Employee Activity Summary</li>
                </ol>
				
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                   	<div class="row">
						   <?php echo form_open("main/Employee_activity_summary","class=form-horizontal");?>
            <div class="col-md-4">
              <label class="control-label col-md-4" for="fr_date">From </label>
  						<div class="col-md-8">
  						  <input type="text" id="fr_date" name="fr_date" class="form-control datepick" value="<?= $_POST['fr_date'];?>" autocomplete="off" >
  						  <?php echo form_error('fr_date', '<div class="error">', '</div>'); ?>
              </div>
						</div>
            <div class="col-md-4">
              <label class="control-label col-md-4" for="to_date">To </label>
						  <div class="col-md-8">
  						<input type="text" id="to_date" name="to_date" class="form-control datepick" value="<?= $_POST['to_date'];?>" autocomplete="off" >
  						<?php echo form_error('to_date', '<div class="error">', '</div>'); ?>
              </div>
					 </div>
						<div class="col-md-4">
						  <?php 
						 
								echo form_submit('submit', 'Submit','class="btn btn-green"'); 
						     //echo form_submit('submit', 'Add Subject','class="btn btn-green"');
								//echo form_submit('button', 'Add Subject','class="btn btn-green"');
						  
				    ?>
					</div>
						<?php
							echo form_close();
						?>
				</div>
				<?php if($_POST['submit']=="Submit"){ 
          $fr_dt = $_POST['fr_date'];
            $to_dt = $_POST['to_date'];
            $std_PRN = $this->session->userdata('std_PRN');
            $school_id=$this->session->userdata('school_id');
          ?>		
				<div class="row" style="margin-top:5%;">
                                <div class="col-md-12" style="padding-bottom: 10px;"><span class="pull-right"><a class="btn btn-info" href="<?= base_url('Main/Employee_activity_summary_Graph/'.$fr_dt.'/'.$to_dt)?>">Graph</a></span></div>
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
	                                        <tr>
	                                            <th>Sr.No.</th>
	                                            <th>Activity Name</th>
	                                            <th>Points</th>
	                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
											//print_r($student_subjectlist); exit;
											if ($student_subjectlist['responseStatus']==204){
												echo "<script>alert('No Record Found');</script>"; 
											}
											else{
										foreach($student_subjectlist['posts'] as $t) 
											{
												//print_r($t['SubjectCode']);exit;
												
												?>
                                        	<tr>
                                            	<td data-title="Sr.No"><?php echo $i;?></td>
                                            	<td><?= $t['sc_list'];?></td>
                                            	<td><?= $t['point'];?></td>
											</tr>
                                      		<?php $i++;} }?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        <?php } ?>
                        </div>
                                    
                    </div>
                </div>
                    
                          
                            
                          
                          
                            
                        
                          
                          
                                       
                                    </div>
                                </div>
           <!--END CONTENT--><!--BEGIN FOOTER-->
            
           
        <!--END PAGE WRAPPER-->
           
                  <?php $this->load->view('footer');?>
 
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
                            </div>
         
   <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
   <script type="text/javascript">
   		$(function(){
   			$('.datepick').datepicker({
   				dateFormat: 'dd-mm-yy',
   				changeMonth: true,
   				changeYear: true,
   				maxDate:0
   			});
   		});
   </script>     
</body>
</html>