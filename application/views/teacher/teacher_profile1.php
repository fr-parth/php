<!-- Below code done by  by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3467 on 13/04/2019-->

<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
		<div class="row clearfix">
				<head>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
					<!-- Bootstrap Date-Picker Plugin -->
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
				</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form method="post" action=" " >	
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					<div><?php if($this->session->flashdata('msg')): ?>
						<p><?php //echo $this->session->flashdata('msg'); ?></p>
						<?php endif; ?>
					</div>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
					  <h4 class="panel-title">
						<a class="collapsed alert alert-danger" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						  Change Password
						</a>
					  </h4>
					</div>
					<div id="collapseFour"  role="tabpanel" aria-labelledby="headingFour">
					  <div class="panel-body">
					  <div class="form_new">
							<label class="control-label" for="oldPassword">Old Password:</label>
							<div class=""> 
							  <input type="password" class="form-control" id="oldPassword" name="oldPassword" autocomplete ="off"placeholder="Enter Old Password" />
							  <div id="chk_old"></div>
							  <?php echo form_error('oldPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form_new">
							<label class="control-label" for="newPassword">New Password:</label>
							<div class=""> 
							 <input type="password" class="form-control" id="newPassword" name="newPassword" autocomplete ="off" placeholder="Enter New Password" />
							 <?php echo form_error('newPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form_new">
							<label class="control-label" for="confPassword">Confirm Password:</label>
							<div class=""> 
							  <input type="password" class="form-control" id="confPassword" name="confPassword" autocomplete ="off" placeholder="Confirm New Password" />
							  <?php echo form_error('confPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
									</div>				 
							<div class="form_button">
							  <button type="submit" name="pass_submit" class="myButton form2" value="Submit" onclick="return teacher_pass_info();">Submit</button>
							</div>
					  </div>
					</div>
				  </div>
				</div>
				</div>
			</form>
		</div>
	</div>		
</div>		
<!--////*********datepicker*******////////-->
<script>
	var options={
        format: 'mm/dd/yyyy',
		startDate: '01/01/1930',
		endDate: '12/31/2016',
        todayHighlight: true,
        autoclose: true,
      };
	$('#date').datepicker(options);
</script>
<!--	////*********Ends datepicker*******////////-->