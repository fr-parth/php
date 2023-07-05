<?php 
//print_r($schoolinfo);
$this->load->view('stud_header',$studentinfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<script type="text/javascript">
		var centreGot = false;
	</script>
	<title>Sponsor Map</title> 
</head>   
<?php echo $map['js']; ?>
<body>
    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
		<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
			<div class="page-header pull-left">
				<div class="page-title">Sponsor Map</div>
			</div>
			<ol class="breadcrumb page-breadcrumb pull-right">
				<li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
				<li class="hidden"><a href="#">Masters</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
				<li class="active">Sponsor Map</li>
			</ol>
			<div class="clearfix"></div>
        </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
		<div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->

		<!--Author VaibhavG. Below I'hv added Form for accepting Location to show sponsors for the ticket number SMC-3245 22Aug18 5:57PM-->
			<!--code start here-->			
		<center><form class="form-inline" action="" method="POST">
			<div class="form-group">
				<label for="email">Enter Location:</label>
				<input id="address" type="text" name="address" placeholder="Enter Location" class="form-control" value="<?php echo $locate;?>" />
				<?php echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
			</div>
			<input type="submit" name="submit1" class="btn btn-default">
		</form></center>
		<!--code End here-->

		<div class="page-content">
			<div id="form-layouts" class="row">
				<div class="col-lg-12">
					<div class="panel">                  
						<div class="panel-body">
						<?php echo $map['html']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>                
                   
		<?php 
		$this->load->view('footer');
		?>                
		<!--END CONTENT--><!--BEGIN FOOTER-->
         
    </div>
            
         
</body>
</html>