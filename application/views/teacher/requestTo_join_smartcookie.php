<?php
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
$school_type = $teacher_info[0]->sctype;
 ?>

<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
	<div align="center" class="block-header"><h4>
	
	<?php if($isSmartCookie) { ?> 
	Request To Join SmartCookie
	<?php }else{ ?>
	Request To Join Protsahan-Bharati
	<?php } ?>
	
	</h4></div>
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form method="post" action=" " >	
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form1">
							<label class="control-label" for="User type">Request User as:</label>
							<div class="">
							  <select type="text" class="form-control" name="entity_type" id="entity_type" required>
								<!-- Below changed code by Chaitali for SMC-5181 on 03-03-2021 -->
								<option value="">Select User Type</option>
								<option value="103"><?php echo ($school_type=='organization')?'Manager':'Teacher'; ?> </option>
								<option value="105"><?php echo ($school_type=='organization')?'Employee':'Student'; ?> </option>
							  </select>

							  </select>
							  <?php echo form_error('entity_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="firstName">First Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="firstName" id="firstName" placeholder="Enter First Name" required>
							  <?php echo form_error('firstName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="midName">Middle Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="midName" id="midName" placeholder="Enter Middle Name" required>
							  <?php echo form_error('midName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label " for="lastName">Last Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="lastName" id="lastName" placeholder="Enter Last Name" required>
							  <?php echo form_error('lastName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="emailId">Email Id:</label>
							<div class=""> 
							  <input type="email" class="form-control" maxlength="35" name="emailId" id="emailId" placeholder="Enter Email Id" required>
							  <?php echo form_error('emailId', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<input type="hidden" class="form-control" maxlength="3" value="91" name="countryCode" id="countryCode" placeholder="Enter Country Code" >
						<!--<div class="form1">		//  It should be enabled, commented because of twillio not working 			  
							<label class="control-label" for="countryCode">Country Code:</label>
							<div class="">
							   <input type="number" class="form-control" maxlength="3" name="countryCode" id="countryCode" placeholder="Enter Country Code" required>
							  
							  
							  <?php //echo form_error('countryCode', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>-->
						<div class="form1">
							<label class="control-label " for="mobileNumber">Mobile Number:</label>
							<div class=""> 
							  <input type="number" class="form-control" name="mobileNumber" id="mobileNumber" placeholder="Enter Mobile Number" required>
							  <?php echo form_error('mobileNumber', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
							<div class=" ">
							  <button type="submit" name="submit" class="myButton form2" value="Submit" onclick="return requestToJoinSmartcookie();">Submit</button>
							</div>
						 
					</div>
				  </div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
<script>
	document.getElementById("otheract").className += " active";
	document.getElementById("smartRequest").className += " active";
</script>