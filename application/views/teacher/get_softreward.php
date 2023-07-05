<?php
//else if condition added by Pranali for SMC-3910 on 22-11-19
$thanqu_flag=$school_details[0]->thanqu_flag;
				
				if($thanqu_flag!='' || $thanqu_flag!='null'){
						
					$te="Te"; 
					$pos = strpos($thanqu_flag,$te);
					if($pos == false)
					{						
						echo "Admin has disabled purchase of soft rewards!.. \nPlease contact admin";
						exit;
					}

				}
				else if($thanqu_flag=='' || $thanqu_flag=='null'){
						echo "Admin has disabled purchase of soft rewards!.. \n Please contact admin";
						exit;
						
				}
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>Soft Reward List</h2>
			</div>
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				
				echo form_open("","class=form-horizontal");
				?>
				<input type="hidden" name="avail_blue" id="avail_blue" value="<?php echo $teacher_info[0]->balance_blue_points; ?>">
                    <thead>
						<tr>
							<th>Sr No</th>
							<th>Reward Image</th>
							<th>Reward Name</th>
							<th>Reward Points</th>
							<th>Purchase Reward</th>						
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($softreward_list as $softreward){	
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><img src="<?php echo base_url(); ?>core/<?php echo $softreward->imagepath; ?>" height="75" width="75"></td>
							<td><?php echo $softreward->rewardType; ?></td>
							<td><?php echo $softreward->fromRange; ?></td>
							<td><input type="button" value="Purchase" class="myButton" onclick="return reward_funtion('<?php echo $softreward->softrewardId; ?>',<?php echo $softreward->fromRange; ?>)"></td>
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
	document.getElementById("buysoftR").className += " active";
</script>