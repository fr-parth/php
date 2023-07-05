<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
       
</head>

<title>Display Request List</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
      
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Points Request from <?php echo ($this->session->userdata('usertype')=='employee')?'Employees':'Students'; ?></div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Request</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Requets from <?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?></li>
                </ol>
                <div class="clearfix"></div>
							
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
        <div class="page-content">
						<?php 
						if(isset($report))
						{
						?>
						<div style="color:green;" align="center">
							<h3><?php echo $report;?></h3>
						</div>						
						<?php 
						}
						if(isset($report1))
						{
						?>
						<div style="color:red;" align="center">
							<h3><?php echo $report1;?></h3>
						</div>
						<?php 
						}
						?>
                <div class="row">
                    <div class="col-md-12">
                    
                  
                       <?php  
					   
					if(count($requestslist)!=0)
					   {
					   
					   foreach($requestslist as $t)
						   {?>
                            <div id="one-column" >
                            
                            
                          
                                <div id="md9" class="message-item blue">
                                    <div class="message-inner">
                                        <div class="message-head clearfix">
                                           
                                            <div class="avatar pull-left">
                                            <?php if($t->std_img_path==""){?>
                                                    <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle"/>
                                                    
<?php }
else
{?>
	<img src="<?php echo base_url()?><?php $t->std_img_path?>"  alt="" class="img-circle"/>
<?php }?>
                                            
                                            
                                            </div>

                                     <div class="user-detail"><h5 class="handle"><?php if($t->std_complete_name=="")
											{
												echo ucwords(strtolower( $t->std_name." ".$t->std_Father_name." ".$t->std_lastname));
												
											}
											else
											{
												echo ucwords(strtolower( $t->std_complete_name));
											}
											
											
											?></h5>


                                        </div>
													
											<div class="post-meta">
												<div class="asker-meta"><span class="qa-message-when"><span class="qa-message-when-data"><?php echo $t->requestdate;?></span></span><span class="qa-message-who"><span class="qa-message-who-pad">For :</span><span class="qa-message-who-data"></span><?php echo  $t-> points;?> Points</span>
												
												<?php 
													//Author VaibhavG checked condition to getting only Not Accepted Request by student for ticket number SMC-3289  18Aug18 12:40PM
													if($t->flag!="Y"){?>
													<a href="<?php echo site_url();?>/main/student_requestlist/<?php echo $t->id;?>" ><i class="fa fa-check-circle" style="font-size:34px;color:#063;margin-left: 550px;" id="accept" name="accept"></i> </a> <a href="<?php echo site_url();?>/main/student_requestlist/<?php echo "R".$t->id;?>" ><i class=" fa fa-times-circle" style="font-size:34px; color:#E60000;margin-left:15px;" id="decline" name="decline"></i> </a>
												<?php }?>
												</div>
								   
											</div>
													





                                        </div>
                                       <b> <span class="qa-message-when-data">Reason : <?php echo $t->reason;?></span></b>
                                       
                                      
                                    </div>
                                </div>
                               
                               

                               
                               
                               
                            </div>
                            
                      

                        
                        <?php }  }
						
						else
						
						{?>
							
							
							<div id="one-column" >
                            
                            
                          
                                <div id="md9" class="message-item blue">
                                 <div class="message-inner">
                                        <div class="message-head clearfix">
                                
                                    <div class="user-detail" align="center"><h5 class="handle" style="color:#F00;">
                                    You don't have any request
                                    </h5>

                                    <!-- Author VaibhavG changed Pending Request as Accepted Request to show Accepted Request by student for ticket number SMC-3289  18Aug18 12:40PM -->
                                   <a href="<?php echo site_url();?>/main/pending_request_student"> <h6>Click here to See Accepted Requests</h6> </a>
                                    </div>
                                    </div>
                                    </div>
                                
                                
                                </div>
                                
                                </div>
							
						<?php }
						
						
						
						?>

                        
                                               
                               
                        
                           
                     
                        </div>
                        
                        
              
                        
                    </div>
                </div>
                
                
                
            </div>
            
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
            
           
        <!--END PAGE WRAPPER-->
           </div>    
           
                   
                  <?php 


$this->load->view('footer');

?>
 
                </div>
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            
            
         
</body>
</html>