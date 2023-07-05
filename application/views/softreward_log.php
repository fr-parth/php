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
                    <div class="page-title">Soft Reward Log</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Soft Reward Log</li>
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
                                        <thead class="cf" align="center">
                                        <tr>
                                            <th>Sr.No.</th>
                                              <th>Reward Image</th>
                                            
                                            <th> Reward Name</th>
                                              
                                            <th>Points</th>
                                          
                                            <th> Date   Time</th> 

											
                                           
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($reward_log as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                            
                                <td data-title="Image" ><img src="<?php echo site_url()."core/".$t->imagepath ?>"  height="20px" width="20px" /></td>
                                
                                  <td data-title="name" ><?php echo $t->rewardType;?></td>
                                   <td data-title="Points" ><?php echo $t->point;?></td>
                                         
									<td data-title="Date Time"><?php echo $t->date; ?></td>
									<!--<?php 
									$time = explode(" ",$t->date);
										?>-->
                                     
                                           
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