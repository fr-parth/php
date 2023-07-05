<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>Student Coordinator List</h2>
			</div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
							<th>Coordinator Name</th>
							<th>Date</th>					
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($coordinator_list as $coordinator){	
						if(!empty($coordinator->std_complete_name)){
								  $student_name = $coordinator->std_complete_name;
							  }
							  else{
								  $student_name = $coordinator->std_name.' '.$coordinator->stdMidname.' '.$coordinator->std_lastname;
							  }
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $student_name; ?></td>
							<td><?php echo date('Y/m/j', strtotime($coordinator->pointdate)); ?></td>
						</tr>
							<?php } ?>
						
					</tbody>
				</table>
			</div>
			 
		</div>
		</div>
</div>

<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
<script>
document.getElementById("otheract").className += " active";
document.getElementById("coordList").className += " active";
</script>
		