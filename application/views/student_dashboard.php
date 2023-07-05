<?php 
//print_r($schoolinfo);
//print_r($studentinfo);

$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard</title>
    
    <script>
 $(document).ready(function() 
 {

    $('#example').DataTable({
	"pageLength": 5
	});
	
	
} );

function resetReport()
{
	document.getElementById('Report').innerHTML="";
}
</script>
<script>
function generate_val()
{
	var select_opt = $('#select_opt').val();	
	if(!$.trim(select_opt))
	{
		alert("Select Point Type");
		$("#select_opt").focus();
		$("#select_opt").val("");
		return false;
	}
	
}
</script>
</head>
<body onClick="resetReport();">

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">DashBoard</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">DashBoard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">DashBoard</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
      
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div id="tab-general">
                    <div id="sum_box" class="row mbl">
                        <div class="col-sm-6 col-md-3">
                          <a href="rewards_log"><div class="panel profit db mbm">
                                <div class="panel-body" style="background-color:#3DBD2F;border-color:#3DBD2F; color:#FFF;"><h4 class="value"><?php 
								if(isset($studentpointsinfo[0]->sc_total_point))
								{
									
								   $a=$bloginfo[0]->rating;
								  
								  $b= $studentpointsinfo[0]->sc_total_point;
								echo $c=$a+$b;
								
								}else
								{
									echo "0";
								}?></h4>
									<!--Change the Rewards as a Reward Points as per the ref of ticket SMC-3203-->
                                    <p style="color:#FFF;">Reward Points</p>

                                    
                                </div>
                            </div></a>
                        </div>
                        
                          <div class="col-sm-6 col-md-3">
                           <a href="thanQ_log"> <div class="panel income db mbm">
                                <div class="panel-body"  style="background-color:#203CB6;border-color:#203CB6; color:#FFF;"><h4 class="value"><?php 
								
								if(isset($studentinfo[0]->balance_bluestud_points))
								{
								echo $studentinfo[0]->balance_bluestud_points;
								
								}else
								{
									echo "0";
								}
								?></h4>

                                    <p style="color:#FFF;">ThanQ Points </p>

                                </div>
                            </div></a>
                        </div>
						  
                        <div class="col-sm-6 col-md-3">
                            <a href="student_purchasepoints_log">  <div class="panel task db mbm">
                                <div class="panel-body" style="background-color:#D4EFFF;border-color:#D4EFFF; color:#000000;"><h4 class="value"><?php 
								
								
								if(isset($studentinfo[0]->balance_water_points))
								{
								echo $studentinfo[0]->balance_water_points;
								
								}else
								{
									echo "0";
								}
								?></h4>

                                    <p  style="color:#000000;">Water Points</p>

                                  
                                </div>
                            </div></a>
                        </div>
						
						
                        <div class="col-sm-6 col-md-3">
                          <a href="friendship_log">   <div class="panel visit db mbm">
                                <div class="panel-body"  style="background-color:#DFCF41;border-color:#DFCF41; color:#000000;"><h4 class="value"><?php 
								
						if(isset($studentpointsinfo[0]->yellow_points))
								{
								echo $studentpointsinfo[0]->yellow_points;
								
								}else
								{
									echo "0";
								}
								?></h4>


                                    <p  style="color:#000000;">Friendship Points</p>

                                    
                                </div>
                            </div></a>
                        </div>
                        
                        
                        
                       
                    </div>


                     <div id="tab-general">
                    <div id="sum_box" class="row mbl">
					
					<?php
						 if($this->session->userdata('usertype')=='student'){   ?> 
                        <div class="col-sm-6 col-md-3">
                         <a href="purple_points_log">    <div class="panel profit db mbm">
                                <div class="panel-body" style="background-color:#4B1F81;border-color:#4B1F81; color:#FFF;"><h4 >
								<?php 
								if(isset($studentpointsinfo[0]->purple_points))
								{
								echo $studentpointsinfo[0]->purple_points;
								
								}else
								{
									echo "0";
								}
								?></h4>
									<!--Change the Purple Points as a Family Points as per the ref of ticket SMC-3204-->
                                    <p style="color:#FFF;">Family Points</p>

                                   
                                </div>
                            </div></a>
                        </div>
						 <?php }?>
                        <div class="col-sm-6 col-md-3">
                             <a href="brown_points_log" >  <div class="panel income db mbm">
                                <div class="panel-body" style="background-color:#7C3826;border-color:#7C3826; color:#FFF;"><h4 class="value">
                                    <?php
//brown points displayed from array $studentpointsinfo by Pranali for SMC-4449 on 21-1-20
								if(isset($studentpointsinfo[0]->brown_point))
								{
									echo $studentpointsinfo[0]->brown_point;
								
								}else
								{
									echo "0";
								}
								?></h4>
                                    <p style="color:#FFF;">Brown Points</p>

                                
                                </div>
                            </div></a>
                        </div>
                        
                      
                    </div>



                    <div class="row mbl" style="display:none;">
                        <div class="col-lg-8">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                       

                                         <div id="area-chart-spline" style="width: 100%; height:300px"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                        <?php if($this->session->userdata('usertype')=="employee"){ ?>
                        	<a class="btn btn-lg btn-primary" href="<?= base_url('main/assignThanQpoints');?>">Thank Manager</a> &emsp;&emsp; <a class="btn btn-lg btn-success" href="<?= base_url('main/teacherlist_request');?>">Reuqest for Points</a>
                        <?php } ?>
                        </div>
                        <div class="row" style="margin-top:2%;">
<div class="col-md-12">
<div class="jumbotron" align="center" style="padding-top:16px;">



<div style="font-size:19px;color:#000;">
Generate SmartCookie Coupon </div>


		<?php if ($this->session->flashdata('success_generate_coupon')) { ?>
			<h4 style="color:green;" id="Report">
				<?php echo $this->session->flashdata('success_generate_coupon'); ?>
			</h4>
		<?php } ?>
		<?php if ($this->session->flashdata('error_generate_coupon')) { ?>
			<h4 style="color:red;" id="Report">
				<?php echo $this->session->flashdata('error_generate_coupon'); ?>
			</h4>
		<?php } ?>
  <p style="padding-top:5px;">
   <?php  
   if(!empty($studentpointsinfo[0]->sc_total_point) || !empty($studentpointsinfo[0]->yellow_points)||!empty($studentpointsinfo[0]->purple_points)||!empty($studentwaterpointsinfo[0]->balance_water_points)||!empty($studentpointsinfo[0]->brown_point))
   {
	   //var_dump($studentpointsinfo);
	  // var_dump($studentwaterpointsinfo);die;
	      if(($studentpointsinfo[0]->sc_total_point!="" && $studentpointsinfo[0]->sc_total_point!=0 && $studentpointsinfo[0]->sc_total_point >=100) ||($studentpointsinfo[0]->yellow_points!="" && $studentpointsinfo[0]->yellow_points!=0 && $studentpointsinfo[0]->yellow_points >=100)||($studentpointsinfo[0]->purple_points!="" && $studentpointsinfo[0]->purple_points!=0 && $studentpointsinfo[0]->purple_points >=100 )||($studentwaterpointsinfo[0]->balance_water_points!="" && $studentwaterpointsinfo[0]->balance_water_points!=0 && $studentwaterpointsinfo[0]->balance_water_points >=100 )||($studentpointsinfo[0]->brown_point!="" && $studentpointsinfo[0]->brown_point!=0 && $studentpointsinfo[0]->brown_point >=100 ))
		//if($studentpointsinfo[0]->sc_total_point!=""  && $studentpointsinfo[0]->sc_total_point >=100 ||($studentpointsinfo[0]->yellow_points!=""  && $studentpointsinfo[0]->yellow_points >=100)||($studentpointsinfo[0]->purple_points!=""  && $studentpointsinfo[0]->purple_points >=100 )
				
		  
		  
    {
		
		?>
  <?php echo form_open('Main/generate_smartcookie_coupon');?>
                             
                                       
									   
									   
									   	 <div class="form-group">
											<div class="col-md-4">
												<label for="thanq_reason" class="control-label">Select Point Type</label> 
												       	<select id="select_opt" name="select_opt" class="form-control" >
						
						                         		<option value="">Select Option</option>
														
														<?php if(100 <= $studentpointsinfo[0]->sc_total_point)
														 	{ ?>
                                            				<option value="1" <?php 
																if(isset($_POST['select_opt']))
																	{
																	if($_POST['select_opt']=="1")
																		{  ?> selected <?php  }  
															 		}	?>>	 
																<?php echo "Green Points" ?>
															</option>
														<?php } ?>

														<?php if(100 <= $studentpointsinfo[0]->yellow_points)
														 	{ ?>	
															<option value="2" <?php 
																if(isset($_POST['select_opt']))
																	{
																	if($_POST['select_opt']=="2")
																		{ ?> selected <?php } 
																	}?>> 
																<?php echo "Yellow Points" ?>
															</option>
														<?php } ?>

														<?php if(100 <= $studentpointsinfo[0]->purple_points)
														 	{ ?>		  
															<option value="3" <?php  
																if(isset($_POST['select_opt']))
																	{
																	if($_POST['select_opt']=="3")
																		{  ?> selected <?php } 
																	}?>>
																<?php echo "Purple Points" ?>
															</option>
														<?php } ?>
													
														<?php if(100 <= $studentwaterpointsinfo[0]->balance_water_points)
														 	{ ?>
															<option value="4" <?php 
																if(isset($_POST['select_opt']))
																	{
																	if($_POST['select_opt']=="4")
																		{  ?> selected <?php } 
																	}?>>
																<?php echo "Water Points" ?>
															</option>
														<?php } ?>
														
													
														<?php if(100 <= $studentpointsinfo[0]->brown_point)
														 	{ ?>
															<option value="5" <?php 
															if(isset($_POST['select_opt']))
																{
																if($_POST['select_opt']=="5")
																	{  ?> selected <?php } 
																}?>>
																<?php echo "Brown Points" ?>
															</option>
														<?php } ?>
															  
													</select>
													<?php echo form_error('select_opt', '<div class="error">', '</div>'); ?>
												</div>
											
											<div class="col-md-4">
                                        	<label for="points" class="control-label">Select Point</label>
											<select name="points" class="form-control issueCertificatesSelectPoints"  id="points" >
                                            	<?php
											//Below code added by Rutuja to solve the issue of drop down not getting displayed for selecting points for SMC-4429 on 17/01/2020
											/* student can genrate coupon upto total points*/
												$temp=100; //if you change the value of $temp, then change value in "select point" dropdown
											   	$val=$temp;
												$i=2;
											
												
                                               	while($temp<=$studentpointsinfo[0]->sc_total_point||($temp<=$studentpointsinfo[0]->yellow_points)||($temp<=$studentpointsinfo[0]->purple_points)||($temp<=$studentwaterpointsinfo[0]->balance_water_points))
												{
													?>
                                            		<option value='<?php echo $temp?>' ><?php echo $temp ?></option>
                                                	<?php
												 	$temp=$val*$i;
													$i=$i+1;
												}?>
                                               
                                        	</select>
										</div>
                                        &nbsp;&nbsp;&nbsp;
										<div class="col-md-4">
											<label for="" class="control-label"></label>
										<?php 

											echo form_submit('submit', 'Generate','class="btn btn-green" onclick="return generate_val();"');

										?>
										</div>
										<div class="col-md-4">
											<//input type="submit" name="submit" value="Generate" class="btn btn-success" >
                                           <div id="errorpoints" style="color:#FF0000;">
                                           <?php ?></div></p>
										</div>
                                     <?php echo form_close();?>
                                   
									</div>
                                    <?php 
									
						}
                                     
									 else
						{
						
						?>
                        <div style="color:#FF0000;font-size:small">
                                	
                                  
                                        You should have minimum 100 reward points to generate a coupon.
                                        
                                      
                                        </div>
                        <?php
						}
		}
		else
		{
						
						?>
                        <div style="color:#FF0000;font-size:small">
                                	
                                  
                                        You should have minimum 100 reward points to generate a coupon.
                                        
                                      
                                        </div>
           <?php
		}
			?>
                                  
                                <br><br>   
                                <hr  style="border-top: 1px solid #000;"/>
                                
                                <div class="row" style="font-size:19px;color:#000;">SmartCookie Coupons</div>
                              
                                
                                
                                <table id="example" class="table table-striped table-bordered" cellspacing="0"  >
								<thead style="background-color:#FFFFFF;">
								<tr>
									<th>Sr.No.</th>
									<th>Coupon Id</th>		
									<th>Amount</th>
									<th>Generation Date </th>
									<th>Validity Date</th>
									 <th>Show</th>
              
								</tr>
							</thead>
						<tbody>
							<?php 
		   
							/*	if(!$_SESSION['username'])
									{*/
                                            $i=1;
											
                                            foreach($couponinfo as $t) {?>
                                            
                                             <tr>
                                             <td data-title="Coupon Code"><?php echo $i;?></td>
                                             <td data-title="Coupon ID"><?php echo $t->cp_code;?></td>
											 
											 
											 
                                        
                                             <td data-title="Amount" ><?php echo $t->amount;?></td>
                                             <td data-title="Generation Date" > <?php echo $t->cp_gen_date;?></td>
                                             <td data-title="Validity Date" > <?php echo $t->validity;?></td>
                                             <td><a href="showcoupon/<?php echo $t->id ?>" style="text-decoration:none;">show</a></td>
                                          
                                           
											</tr>
											<?php $i++;}//}?>
             
									</tbody>
									</table>
  
</div>

</div>

                       
                        
                        
                        
                        
                       
                    </div>
                   
                   
                </div>
            </div>
    <center><iframe id="wppas_zone" frameborder="0" src="https://smartcookie.in/new/?wppaszoneid=21" width="468" height="60" scrolling="no"></iframe><center><br>      
        
            <!--END CONTENT--><!--BEGIN FOOTER-->
          <?php 


$this->load->view('footer');

?>
            </div>
           

</body>
</html>