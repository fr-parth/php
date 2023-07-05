<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2> Points provided by <?php echo ($school_type=='organization')?'Organization':'School'; ?> Admin and <?php echo ($school_type=='organization')?'Manager':'Teacher'; ?></h2>
        </div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example2" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Name</th>
							 <th><?php echo ($school_type=='organization')?'Organization':'School';?> Admin / <?php  echo ($school_type=='organization')?'Manager':'Teacher';?></th>
							<th>Reason</th>	
							<th>Points</th>
							<th>Date</th>
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
											
						foreach($teacher_points as $teacher){
								if(!empty($teacher->t_complete_name))
								{
									 $teacher_name = $teacher->t_complete_name;
								}
								else
								{
									 $teacher_name = $teacher->t_name.' '.$teacher->t_middlename.' '.$teacher->t_lastname;
								}
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $teacher_name; ?></td>
							<td><?php echo ($school_type=='organization')?'Manager':'Teacher'; ?></td>
							<td><?php echo ucwords($teacher->reason); ?></td>
							<td><?php echo $teacher->sc_point; ?></td>
							<td><?php echo date('Y/m/d',strtotime($teacher->point_date)); ?></td>
						</tr>
							<?php } ?>
							
							<?php
						
						foreach($school_points as $school){
							$school_name = (!empty($school->sa_name)) ? $school->sa_name : $school->school_name;
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $school_name; ?></td>
							<td><?php echo ($school_type=='organization')?'Organization':'School'.' Admin'; ?></td>
							<td><?php echo ucwords($school->reason); ?></td>
							<td><?php echo $school->sc_point; ?></td>
<!--modified strtotime($school->point_date) to display date by Pranali for bug SMC-3427 -->
							<td><?php echo date('Y/m/d',strtotime($school->point_date)); ?></td>
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
			document.getElementById("myblue").className += " active";
			document.getElementById("allblue").className += " active";
		</script>
</head>
<script>
$(document).ready(function() {
    $('#example2').DataTable( {
        "order": [[ 5, "desc" ]], //sorted by order desc on date column by Pranali for bug SMC-3427  
		
    } );
} );
</script>
<style>div#example2_length {
   float: right;
}
div#example2_paginate {
   float: right;
}
a#example2_previous {
   margin-right: 1%;
}</style>