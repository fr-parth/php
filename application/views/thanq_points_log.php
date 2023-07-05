<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<script>
        $(document).ready(function() {
            $('#example').dataTable( {		
         });
		 $('#ple1').dataTable( {		
         });
        } );
		
</script>
</head>

<title>ThanQ Points Log</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">ThanQ Points Log</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">ThanQ Points Log</li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <ul id="generalTab" class="nav nav-tabs responsive">
                            <li class="active"><a href="#teacher" data-toggle="tab"><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></a></li>							
                          <li ><a href="#schooladmin" data-toggle="tab"><?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Admin</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="teacher" class="tab-pane fade in active">
                                <div class="row">
                                   <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th><?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name</th>
                                               <th>Reason</th>
                                            <th>Points</th>
                                           <th > Date Time</th>
                                           
                                         </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($thanq_points_log as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name"><?php echo ucwords(strtolower( $t->t_complete_name ));?></td>
                                            <td data-title="Reason" ><?php echo $t->t_list;?></td>
                                            <td data-title="Points" ><?php echo $t->sc_point;?></td>
                                         
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
							<table class="table table-bordered table-hover " id="ple1" style="margin-left: 0px !important;">												
								<thead class="cf">												
									<tr>                                           
										<th>Sr.No.</th>     
										<th><?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Name</th>                                            <th>Reason</th>
										<th >Points</th>
										<th >Date Time</th>
									</tr>                                       
								</thead>                                    
								<tbody>                                          
							<!--php code rewards function-->													   <?php                                        
											$i=1;                                            foreach($thanq_points_log_school_admin as $t) {?>                                       
											<tr>  
												<td data-title="Sr.No"><?php echo $i;?></td>				
												<td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Admin Name" ><?php echo $t->school_name;?></td>                                          <td data-title="Reason"><?php echo $t->reason ;?></td>        <td data-title="Points" ><?php echo $t->sc_point;?></td>       <td data-title="Date Time"><?php echo $t->point_date; ?></td>
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