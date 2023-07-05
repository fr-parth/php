<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>Teacher Summary Report</h2>
			</div>
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-inverse  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Semester</th>
							<th>Course Code/Name</th>
							<th>No. of scheduled classes</th>
							<th>Points Earned</th>
							<th>Enclosure No.</th>						
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($ as $){	
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><img src="<?php echo base_url(); ?>core/<?php echo $softreward->imagepath; ?>" height="75" width="75"></td>
							<td><?php echo $softreward->rewardType; ?></td>
							<td><?php echo $softreward->point; ?></td>
							<td><?php echo date("Y/m/j", strtotime($softreward->logDate)); ?></td>
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
		document.getElementById("mylogs").className += " active";
		document.getElementById("softlog").className += " active";
</script>