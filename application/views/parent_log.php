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
			$('#example1').dataTable( {
		
				
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
                    <div class="page-title">My Parent</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   
                    <li class="active">My Parent</li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <ul id="generalTab" class="nav nav-tabs responsive">
                           </li>
                          <?php 
						 if($studentinfo[0]->status=='')
						 {?>  <li></li>
						 <?php }?>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="teacher" class="tab-pane fade in active">
                                <div class="row">
                                
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Parent Name</th>
                                           
                                            <th >Parent Email</th>
                                            <th >Phone</th>
                                             <th >Occupation</th>
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($parentinfo as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                           
                                         
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php  if($t->Name=='')
											
											{
											echo $t->Mother_name;
											
											}
											else
											{
												echo $t->Name;
											}
											
											
											?>	</td>									                                          
               <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php echo$t->email_id	?>	</td>	
               
               <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php echo$t->Phone	?>	</td>																	                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php echo$t->Occupation		?>	</td>									
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                
                                
                                    
                                </div>
                            </div>
							
							<?php 
						 if($studentinfo[0]->status=='')
						 {?>
                            <div id="Student-Coordinator" class="tab-pane fade">
                                <div class="row">
                                
                                
                                 <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example1" >
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Parent Name</th>
                                           
                                            <th >ParentEmail</th>
                                            <th >Phone</th>
                                             <th >Occupation</th>
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($rewardcoordinatorlog as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No" style="width:5%;"><?php echo $i;?></td>
                                            <td data-title="Reason" style="width:10%;"><?php echo $t->reason ;?>  <?php  if($t->Father_name=='NULL')
											
											{
											echo $t->Mother_name;
											
											}
											else
											{
												echo $t->Father_name;
											}
											
											
											?></td>
                                          
                                              <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php echo ucwords(strtolower($t->coordinator));?></td>
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> Name" ><?php echo ucwords(strtolower($t->teacher)) ;?></td>
                                            <td data-title="Date"><?php echo $t->point_date;?></td>
                                         
                                           
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