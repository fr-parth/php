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

<title>Teacher List</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">My Subjects and Teacher</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">My Subjects and Teacher</li>
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
                                    <table class="table table-bordered table-hover " id="example" >
                                        <thead class="cf">
                                        <tr>
                                          <th>Sr.No.</th>
                <th></th>
				 <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Subject Name </th>
                <th>Send Request</th>
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($teacherlist as $t) {?>
                                        <tr><?php 
echo form_open("main/teacherlist_coordinator/","class=form-horizontal");?>
                                            <td data-title="Sr.No."><?php echo $i;?></td>
                                      
									  <td data-title=""><?php if ($t->t_pc==""){ ?> <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:50px;width:50px;"/><?php  } else {?><img src="<?php echo base_url()?><?php echo $t->t_pc?>"  alt="" class="img-circle" style="height:50px;width:50px;"/> <?php };?></td>
                                           <td data-title="teacher_id"><?php echo $t->teacher_id?><input id="teacher_id" name="teacher_id" type="text" value="<?php echo $t->id?>" style="display:none;" ></td>
                                            <td data-title="Amount" ><?php echo ucwords(strtolower( $t->t_complete_name));?></td>
                                            <td data-title="Generation Date" > <?php echo $t->subjectName;?></td>
											
                                            <td> 

											<?php 
											$flag=True;
											foreach($coordinator_request_info as $r)
											{
												if($r->stud_id2==$t->id)
												{
													$flag=False;
	echo form_submit('request', 'Request Sent','class="btn btn-green" disabled');

													break;
													
												}
												
													}
													if($flag)
													{
													echo form_submit('request', 'Send Request','class="btn btn-green"');
	
													}
													
													?>    </td>
                                         <?php

echo form_close();
	?>
                                           
                                        </tr>
                                      <?php $i++;}?>
                                        </tbody>
                                    </table>
									<div class="error" align="left">
                                                    <?php if(isset($report))
													{
														
													echo $report;	
													}?></div>
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