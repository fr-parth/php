<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);
?>
<!DOCTYPE html>

<html lang="en">

<head>
<script type="text/javascript">
  //document.getElementById('thanq_reason').value = "<?php echo $_GET['thanq_reason'];?>";
</script>


</head>



<title>Assign Blue Points</title>


<body>



    <!--END THEME SETTING-->



   

        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->

   

     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>

            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->

             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->

            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">

                <div class="page-header pull-left">

                    <div class="page-title">Assign ThanQ Points</div>

                </div>

                <ol class="breadcrumb page-breadcrumb pull-right">

                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo site_url('Main/members') ?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li><a href="#">ThanQ Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                    <li class="active">Assign ThanQ Points</li>

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

                                            <div class="panel-heading"><?php echo ucwords( strtolower($teacherinfo[0]->t_complete_name))?></div>

                                            <div class="panel-body pan">

                                           

                                              <?php  echo form_open("main/Thanq_Assignpoints/".$teacherinfo[0]->t_id,"class=form-horizontal");?>

                                                 <div class="row" align="center" style="margin-top:2%;">

                                                 <?php 
												 if ($teacherinfo[0]->t_pc=="")
												 { ?> 
													<img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:80px;width:80px;"/>
													<?php 
												  }
											 else
												 {?>
														<img src="<?php echo base_url()?>core/<?php echo $teacherinfo[0]->t_pc?>"  alt="" class="img-circle" style="height:80px;width:80px;border: 5px solid #eee;"/> <?php
												};?>

                                                           

                                                           

                                                        </div>

                                                    <div class="form-body pal" style="margin-top:-2%;"><h3>Personal Details</h3>



                                                        <div class="row">

                                                            <div class="col-md-6">

                                                                <div class="form-group"><label for="inputFirstName" class="col-md-3 control-label"> Name</label>



                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo ucwords(strtolower($teacherinfo[0]->t_complete_name))?></p></div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="form-group"><label for="inputLastName" class="col-md-3 control-label">Email</label>



                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $teacherinfo[0]->t_email?></p></div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                     

                                                        <div class="row">

                                                        

                                                         <div class="col-md-6">

                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Phone</label>



                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $teacherinfo[0]->t_phone?></p></div>

                                                                </div>

                                                            </div>

                                                            

                                                             <div class="col-md-6">

                                                         <!--       <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">ThanQ Points</label>



                                                                    <div class="col-md-9"><p class="form-control-static"><?php// echo $teacherinfo[0]->balance_blue_points?></p></div>

                                                                </div> -->

                                                            </div>

                                                          

                                                        </div>

                                                        

                                                        

                                                              <div class="row">

                                                        

                                                         <div class="col-md-6">

                                                                <div class="form-group"><label for="thanq_reason" class="col-md-3 control-label">ThanQ Reason<sup style="color:#FF0000;">*</sup></label>

                                                                    <div class="col-md-9"><select id="thanq_reason" name="thanq_reason" class="form-control">
                                                                    <option value="0">Select Reason</option>

                                                                    <?php foreach($thanqreasonlist as $t)

																	{?>
																		<option value="<?php echo $t->id; ?>" <?php echo set_select('thanq_reason',  $t->id); ?>><?php echo $t->t_list; ?></option>

                                                                       <?php }?>

                                                                    </select><?php echo form_error('thanq_reason', '<div class="error">', '</div>'); ?></div>

                                                                </div>

                                                            </div>

                                                            

                                                            

                                                          

                                                        </div>

                                                     

                                                     

                                                      <div class="row">

                                                     

                                                      <div class="col-md-6">

                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label"> Points<sup style="color:#FF0000;">*</sup></label>



                                                                    <div class="col-md-9"><input id="points" name="points" type="text" placeholder="ThanQ Points" class="form-control" value="<?php  if(isset($_POST['points'])){echo $_POST['points'];}?>"><?php echo form_error('points', '<div class="error">', '</div>'); ?></div>

                                                                </div>

                                                            </div>

                                                            

                                                             

                                                            

                                                            

                                                            </div>

                                                        

                                                      

                                                    </div>

                                                    <div class="form-actions text-center pal" style="background-color:#FFF;">

                                                    <div style="color:green" align="center">

                                                    <?php if(isset($report))

													{

														

													echo $report;	

													}?></div>

                                                    <?php 

													echo form_submit('assign', 'Assign','class="btn btn-green"');

													?>

                                                    

                                                    

                                                      

                                                        &nbsp;

                                                         <a href="<?php echo site_url();?>/main/assignThanQpoints" ><button type="button" class="btn btn-primary">Cancel</button></a>

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