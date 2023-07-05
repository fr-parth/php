<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
		<div class="row clearfix">
			<head>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
				<script>
					document.getElementById("searchstuds").className += " active";
					document.getElementById("searchstud").className += " active";
				</script>
			</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php echo form_open("","class=form-horizontal");?>
			<div class="input-group">
			<input type="hidden" value="<?php echo $data ?>" id="myval">
			<div class="panel-body">
				<label class="control-label col-sm-2" for="schoolName">Search <?php echo ($this->session->userdata('usertype')=='teacher')?'Students':'Employee'; ?>:</label>
				<div class="col-sm-6"> 
				<input type="text" name="search_text" id="search_text" placeholder="Search by <?php echo ($this->session->userdata('usertype')=='teacher')?'student':'employee'; ?> ID, Name or <?php echo ($this->session->userdata('usertype')=='teacher')?'Class':'Team'; ?>" class="form-control" />
				<div class="col-sm-2" ><input type="button" value="Search" id="search" class="myButton" ></div>
				</div>
            </div>
					<tbody>
					<div id="loading" align="center" style="display:none"><img src="<?php echo base_url();?>/images/ajax-loader.gif"></div>
					<div id="searched_student">
					</tbody>
				
                <!-- #END# Browser Usage -->
			</div>
		</div>
	</div>
</div>