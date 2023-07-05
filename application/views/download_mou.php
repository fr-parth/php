<!DOCTYPE html>
<html>
<head>
	<title>Download MOU</title>
	<meta charset="utf-8">
    <meta https-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/bootstrap/css/bootstrap.min.css">
    
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<?= $success_msg;?>
			<?= $error_msg;?>
		</div>
		<div class="col-md-12">
			<div class="col-md-offset-4 col-md-4"></div>
				<a href="<?= base_url('NPIUcollegeinfo/College_MOU/'.$college_id); ?>" class="btn btn-info">Download MOU</a> &emsp;&emsp;
				<a href="<?= base_url();?>" class="btn btn-warning">Home</a>
			</div>
		</div>
	</div>
</body>
<script src="<?php echo base_url(); ?>Assets/js/jquery-1.11.1.min.js"></script> 
	<script src="<?php echo base_url(); ?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
</html>