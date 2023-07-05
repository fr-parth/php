

<?php 
//This view is done by Sayali Balkawade to display Activity Log in  Student Module on 5/11/2019
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
			
  
        } );
		
		
        </script>
</head>

<title>Activity Log</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper" ><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Activity Log</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Activity Log</li>
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
                                
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                         <th style="text-align:center;">Sr. No.</th>
                        
                       
                       
                        <th style="text-align:center;">Activity</th>
						<th style="text-align:center;width:10%;">To</th> 
						<th style="text-align:center;width:15%;">Entity Type</th>
						 <th style="text-align:center;width:10%;">Points</th>
						<!-- <th style="text-align:center;">Device Details</th> -->
                         <th style="text-align:center;width:15%;"> Date</th>
                                        
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($users as $t) {
                                             ?>
                                        <tr>
                                            <td style="text-align:center;" data-title="Sr.No"><?php echo $i; ?></td>
                                            <td style="text-align:center;" data-title="Activity" ><?php echo $t->Activity; ?></td>
                                
												<?php if($t->EntityID_2==''){ ?>
											<td style="text-align:center;" data-title="To" ><?php echo $t->EntityID_2; ?></td>
												<?php } else{ ?>
												<td style="text-align:center;" data-title="To" ><?php echo $t->Entity_Type_2;?></td>
												<?php }?>
												
												<?php if($t->Entity_Type_2=='103')
												{ ?>
													 <td style="text-align:center;" data-title="Entity Type" ><?php echo "Teacher";?></td>
												<?php }
												else if ($t->Entity_Type_2=='105')
												{ ?>
													<td style="text-align:center;" data-title="Entity Type" ><?php echo "Student";?></td>
												<?php }
												else 
												{?>
													<td style="text-align:center;" data-title="Entity Type" ><?php echo "Sponsor";?></td>
												<?php }?>
												
                                            <td style="text-align:center;" data-title="Points" ><?php echo $t->quantity;?></td>
											   <!--  <td data-title="Device Details" ><?php echo ucwords(strtolower( $t->Device));?></td> -->
											<td style="text-align:center;" data-title="Date"><?php echo $t->Timestamp;?></td>
                                         
                                          
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