<?php 

$this->load->view('stud_header',$studentinfo);
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
?>
<!--Changes  done by Pranali_intern start -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
function resetform() {
document.getElementById("myform").reset();
}

</script>

</head>

<!-- <title>Request To Join SmartCookie</title> -->
    

<body>

 <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div> 
	<!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
                  
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                   
<?php if($isSmartCookie) { ?>
				   <div class="page-title">Request To Join SmartCookie</div>
<?php }else{ ?>
<div class="page-title">Request To Join Protsahan-Bharati</div>
<?php } ?>

                </div>
				
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                  
				    <li><a href="#">Requests</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

                   <!-- <li class="active">Requests</li>&nbsp;&nbsp;-->
					<?php if($isSmartCookie) { ?>
					<li class="active">Request To Join SmartCookie</li>
					<?php }else{ ?>
					<li class="active">Request To Join Protsahan-Bharati</li>
					<?php } ?>
	  </ol>
				
                <div class="clearfix"></div>
            </div>

<div style="bgcolor:#CCCCCC">

<div class="container" style="width:100%;height:330px;" >
<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8; height:auto;">
                   <h2 style="padding-top:30px;"><center>
				   <?php if($isSmartCookie) { ?>
				   Request To Join SmartCookie
				   	<?php }else{ ?>
				   Request To Join Protsahan-Bharati
				   <?php } ?>
				  
				   </center></h2>
				   
				   <div class="row formgroup" style="padding:5px;">
                 
					<h3 style="color:green;"><center>
						<?php 
							/*if(isset($result))
							{
								foreach($result as $key=>$val)
									if($key=='responseMessage')
										echo $val;
							}*/
						?>
					</center></h3>
				 <!-- <?php echo validation_errors('<div class="alert alert-danger" align="center">',  '</div>');  ?>  -->


				<!--   <form id="form" action="" method="POST">-->
        <?php echo form_open('Main/request_to_join_samrtcookie','id="myform"'); ?>
        		 
				   <div class="row " style="padding-top:30px;">
                   <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Select User
                   <span style="color:red;">*</span></div>
				   <div class="col-md-3">

				   	<?php
				   	if($abc=='student') { ?>
                   <select name="user_entity" id="user_entity" class="form-control">

                   <option value="-1"  <?php echo ($reset) ? set_select('user_entity', '-1') : ''; ?>>Choose</option> 
                   <option value="103" <?php echo ($reset) ? set_select('user_entity', '103') : ''; ?>>Student</option>
                   <option value="105" <?php echo ($reset) ? set_select('user_entity', '105') : ''; ?>>Teacher</option>
               </select>
         <?php  } else {  ?>

    
                   <select name="user_entity" id="user_entity" class="form-control">

                   <option value="-1"  <?php echo ($reset) ? set_select('user_entity', '-1') : ''; ?>>Choose</option> 
                   <option value="203" <?php echo ($reset) ? set_select('user_entity', '203') : ''; ?>>Employee</option>
                   <option value="205" <?php echo ($reset) ? set_select('user_entity', '205') : ''; ?>>Manager</option>
               </select>
         <?php  } ?>
                    

                   			<!--?php
								
 $selectuser = array(
                  'Choose'  => 'Choose',
                  'Student'  => 'Student',
                  'Teacher'    => 'Teacher',
                 
                );
    
	echo form_dropdown('select_user', $selectuser, 'required="required"');
	
	
   ?>-->
								
		<?php echo form_error('user_entity', '<div class="error">', '</div>'); ?>
                           
			 </div>
						</div>

						<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">First Name
                           <span style="color:red;">*</span> </div>
							 <div class="col-md-3">
							 <input type="text" name="firstname" id="firstname" maxlength="25" value="<?php echo ($reset) ? set_value('firstname') : ''; ?>" placeholder="First Name" class="form-control" />
							<?php  echo form_error('firstname', '<div class="error">', '</div>');  ?>
							</div>
                        </div>             
						<!--commented middle name field by Pranali for SMC-5139-->
							<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Middle Name
                            <!-- <span style="color:red;">*</span> --></div>
							 <div class="col-md-3">
							 <input type="text" name="middlename" id="middlename" maxlength="25" value="<?php echo ($reset) ? set_value('middlename') : ''; ?>" placeholder="Middle Name" class="form-control" />
							 <?php //echo form_error('middlename', '<div class="error">', '</div>');  ?>
							</div>
                        </div>            
	

						<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Last Name
                            <span style="color:red;">*</span></div>
							 <div class="col-md-3">
							 <input type="text" name="lastname" id="lastname" maxlength="25" value="<?php echo ($reset) ? set_value('lastname') : ''; ?>" placeholder="Last Name" class="form-control" />
							<?php echo form_error('lastname', '<div class="error">', '</div>');  ?></div>
                        </div>      

						<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Email ID
                            <span style="color:red;">*</span></div>
							 <div class="col-md-3">
							 <input type="email" name="receiveremail_id" id="receiveremail_id" maxlength="60" value="<?php echo ($reset) ? set_value('receiveremail_id') : ''; ?>" placeholder="Receiver Email ID" class="form-control" />
							 <?php echo form_error('receiveremail_id', '<div class="error">', '</div>'); ?>
							</div>
                        </div>      

<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Country Code
                           <span style="color:red;">*</span> </div>

						<div class="col-md-3">
                                <select name="country_code" id="country_code" class="form-control">
                                    
									<option value="-1" <?php echo ($reset) ? set_select('country_code', '-1', TRUE) : ''; ?>>Choose</option>
									<option value="91" <?php echo ($reset) ? set_select('country_code', '91') : ''; ?>>91</option>
                                   <option value="1" <?php echo ($reset) ? set_select('country_code', '1') : ''; ?>>1</option>
                                
								</select>
								<?php  echo form_error('country_code', '<div class="error">', '</div>'); ?>
                            </div>
                        </div>

					<div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Mobile Number
                            <span style="color:red;">*</span></div>
							 <div class="col-md-3">
							 <input type="text" name="receivermobileno" min="0" maxlength="10" id="receivermobileno" value="<?php echo ($reset) ? set_value('receivermobileno') : ''; ?>" placeholder="Receiver Mobile Number" class="form-control" />
							<?php echo form_error('receivermobileno', '<div class="error">', '</div>'); ?>
							</div>
                        </div>      

	<div class="row" style="padding-top:30px;">
                            <div class="col-md-5"></div>
						<div class="col-md-1" align="center"><input type="submit" name="submit" id="submit" value="Send" class="btn btn-success">
						 <?php //echo form_submit('submit', 'submit', 'class=btn btn-green'); ?>  
						 <?php //echo form_reset('reset', 'reset', 'class=btn btn-red'); ?>
						 </div>

					
					<div class="col-md-1" align="center"><input type="submit" name="reset" id="reset" value="Reset" class="btn btn-danger" /></div>

						<div class="col-md-1"></div>

						<!--</form>-->
						<?php echo form_close(); ?>
						</div>
               </div>
            </div>
		</div>
    </div>
	<?php 


$this->load->view('footer');

?>
	
	
</body>

</html>
<!--Changes  done end-->