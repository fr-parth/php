<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
<!--Naming convention changed based on school_type by Pranali for SMC-4426 on 17-1-20-->
					<h2>ThanQ Points from <?php echo ($school_type=='organization')?'Employees':'Students'; ?></h2>
			</div>
		<div class="row clearfix">		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
						 <th><?php echo ($school_type=='organization')?'Employee':'Student'; ?> Name</th>
							<th>ThanQ Reason</th>
							<th>Points</th>
							<th>Point Date</th>						
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						
						foreach($thanqpoints_log as $thanqpoints){	
						if(!empty($thanqpoints->std_complete_name)){
								  $student_name = $thanqpoints->std_complete_name;
							  }
							  else{
								  $student_name = $thanqpoints->std_name.' '.$thanqpoints->stdMidname.' '.$thanqpoints->std_lastname;
							    }
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $student_name; ?></td>
							<td><?php echo $thanqpoints->t_list; ?></td>
							<td><?php echo $thanqpoints->sc_point; ?></td>
							<td><?php echo date('Y/m/d',strtotime($thanqpoints->point_date)); ?></td>
						</tr>
							<?php } ?>
						
					</tbody>
				</table>
			</div>
			 
		</div>
		</div>
</div>
<head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
		<script>
			document.getElementById("mylogs").className += " active";
			document.getElementById("thanqpt").className += " active";
		</script>
</head>