<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
			<div class="block-header" align='center'>
					<h2>Purchase Water Points</h2>
			</div>
		<div class="row clearfix">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form action="" method="POST">
					<div class="panel-body">
						<label class="control-label col-sm-2" for="cardNo">Enter Card No:</label>
						<div class="col-sm-6"> 
						<input id="cardNo" type="text" name="cardNo" maxlength="15" placeholder="Enter Card No" class="form-control" />
						<?php echo form_error('cardNo', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
						<br>
						<div class="col-sm-2" style="margin-left:147px;margin-top:20px;"><input type="submit" name="save" value="Submit" id="save" class="myButton"/></div>
						</div>
					</div>
			</form>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById("otheract").className += " active";
	document.getElementById("purchaseWPts").className += " active";
</script>
<script>
$(document).ready(function() {
	$("#save").click(function () {
		var cardNo = $('#cardNo').val();
		
		if(!$.trim(cardNo))
		{
			alert("Please enter card number!!");
			$("#cardNo").focus();
			$("#cardNo").val("");
			return false;
		}
	});
	
});
</script>