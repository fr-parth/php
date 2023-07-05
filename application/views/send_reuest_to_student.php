<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>

<title>Request For Points</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Request For Points </div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo base_url();?>/main/members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Requests</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Request For Points </li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
        <div class="page-content">
        <div id="form-layouts" class="row">
                    <div class="col-lg-12">
         <div id="tab-two-columns-readonly" >
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-yellow">
                                            <div class="panel-heading"><?php
											if($studinfo[0]->std_complete_name!='')
											{
											 echo ucwords( strtolower($studinfo[0]->std_complete_name));
											}
											 else
											 {
											  echo ucwords(strtolower( $studinfo[0]->std_name." ".$studinfo[0]->std_Father_name." ".$studinfo[0]->std_lastname	));
											  }
											 ?></div>
                                            <div class="panel-body pan">
                                           
                                              <?php 
echo form_open("main/send_reuest_to_student/".$studinfo[0]->std_PRN,"class=form-horizontal");?>
                                                 <div class="row" align="center" style="margin-top:2%;">
                                                 <?php if ($studinfo[0]->std_img_path==""){ ?> <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:80px;width:80px;"/><?php  } else {?><img src="<?php echo base_url()?>/core/<?php echo $studinfo[0]->std_img_path?>"  alt="" class="img-circle" style="height:80px;width:80px;border: 5px solid #eee;"/> <?php };?>
                                                           
                                                           
                                                        </div>
                                                    <div class="form-body pal" style="margin-top:-2%;"><h3>Personal</h3>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputFirstName" class="col-md-3 control-label"> Name:</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php
											if($studinfo[0]->std_complete_name!='')
											{
											 echo ucwords( strtolower($studinfo[0]->std_complete_name));
											}
											 else
											 {
											  echo ucwords(strtolower( $studinfo[0]->std_name." ".$studinfo[0]->std_Father_name." ".$studinfo[0]->std_lastname	));
											  }
											 ?></p></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputLastName" class="col-md-3 control-label">Email:</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $studinfo[0]->std_email?></p></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="row">
                                                        
                                                         <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Phone</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $studinfo[0]->std_phone?></p></div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                          
                                                        </div>
                                                        
                                                        
                                                              <div class="row">
                                                        
                                                         <div class="col-md-6">
                                                                <div class="form-group"><label for="thanq_reason" class="col-md-3 control-label"> Reason<span class="mandatory" style="color:red;">*</span></label>
                                                                    <div class="col-md-9"><input id="reason" name="reason" type="text" placeholder="Reason" class="form-control" value="<?php echo ($reset) ? "" : set_value('reason',$reasonpost); ?>"><?php echo form_error('reason', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <div class="col-md-9"><input id="activity" name="activity" type="hidden" placeholder="activity" class="form-control" value="request"></div>
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                     
                                                     
                                                      <div class="row">
                                                     
                                                      <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label"> Points<span class="mandatory" style="color:red;">*</span></label>

                                                                    <div class="col-md-9"><input id="points" name="points" type="text" placeholder="Points" class="form-control" value="<?php echo ($reset) ? "" : set_value('points',$pointspost); ?>"><?php echo form_error('points', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                            
                                                             
                                                            
                                                            
                                                            </div>
                                                        
                                                      
                                                    </div>
                                                    <div class="form-actions text-center pal" style="background-color:#FFF;">
                                                    <div class="error" align="center">
                                                    <?php if(isset($report))
													{ ?>
													<font color="green"><?php echo $report;?></font>	
														
													<?php }
													
													if(isset($report1))
													{ ?>
														<font color="red"><?php echo $report1;?></font>
													<?php }
														?></div>
                                                    <?php 
													echo form_submit('request', 'Send Request','class="btn btn-green"');
													?>
                                                    
                                                    
                                                      
                                                        &nbsp;
                                                         <a href="<?php echo site_url();?>/main/show_studlistfor_request" ><button type="button" class="btn btn-danger">Cancel</button></a>
                                                    </div>
                                               <?php

echo form_close();
	?>
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