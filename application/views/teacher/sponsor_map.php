<?php
//$this->load->view('stud_header',$teacher_info);
?>
<head>
		<script>
			document.getElementById("sponsors").className += " active";
			document.getElementById("sponsmap").className += " active";
		</script>
</head>
<?php  echo $map['js']; ?>
<body>
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<form action="" method="POST">
		<div class="panel-body">
			<label class="control-label col-sm-2" for="schoolName">Enter Location:</label>
				<div class="col-sm-6" style="margin-left:5%;"> 
				<input id="address" type="text" name="address" placeholder="Enter Location" class="form-control" value="<?php echo $locate;?>" />
				<?php echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
				<div class="col-sm-2" style="margin-left:420px;margin-top:-35px;"><input type="submit" name="submit1" value="Submit" id="submit1" class="myButton"/></div>
				</div>
            </div>
		</form>

		<div id="result"></div>
		<div id="map_div"><?php echo $map['html']; ?></div>
		</div>
		</div>
		</div>
	</div>
</body>
<script>
$(document).ready(function() {
	$("#submit1").click(function () {
		var location = $('#address').val();
		if(!$.trim(location))
		{
			alert("Please enter location!!");
			$("#autocomplete").focus();
			$("#autocomplete").val("");
			return false;
		}
	});
	
});
</script>