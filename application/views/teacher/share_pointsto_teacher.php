<?php 
//below condition added by Pranali for hiding option of blue point in point type for school_type as 'organization' for SMC-4269 on 17-12-19
if($school_type=='organization'){
	$points_type = array('Waterpoint'=>'Water Points');
}else{
	$points_type = array('Waterpoint'=>'Water Points');
}
	if(!empty($teacher_info[0]->t_complete_name))
	{
		 $teacher_name = ucwords($teacher_info[0]->t_complete_name);
	}
	else
	{
		 $teacher_name = ucwords($teacher_info[0]->t_name).' '.ucwords($teacher_info[0]->t_middlename).' '.ucwords($teacher_info[0]->t_lastname);
	}
?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php echo form_open("","class=form-horizontal");?>
				<input type="hidden" name = "avail_blue" id="avail_blue" value="<?php echo $teacher_info[0]->balance_blue_points; ?>">
				<input type="hidden" name = "avail_water" id="avail_water" value="<?php echo $teacher_info[0]->water_point; ?>">
                    <thead>
						<tr>
							<th colspan=2>Share Points to <?php echo $teacher_name; ?></th>
						</tr>
                    </thead>
					<tbody>
						<!--<tr>
							<td>School Name :</td>
							<td><?php //echo $teacher_info[0]->t_current_school_name?></td>
						</tr>-->
						<tr>
							<td>Department : </td>
							<td><?php echo $teacher_info[0]->t_dept?></td>	
						</tr>
						<tr>
							<td>
								Select Points Type:
							</td>
							<td>			  
								<select name="point_type" id="point_type" class="form-control" required />
									<option value="">Select Points Type</option>
										<?php  
										foreach($points_type as $k=>$val){?>
										<option value="<?php echo $k;?>"><?php echo $val;?>
									</option>
										<?php }?>
								</select>
								<?php echo form_error('point_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr>
							<td>
								Enter Points
							</td>
							<td>			  
								<input type="text" name="points" id="points" placeholder="Enter Points" class="form-control" required/>
								<?php echo form_error('points', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						<tr>
							<td>
								Enter Reason:
							</td>
							<td>			  
								<textarea name="point_reason" id="point_reason" placeholder="Enter Reason" class="form-control"required/></textarea>
								<?php echo form_error('point_reason', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr>
						<td align='center'><input type="button" value="Back" class="myButton" onclick="javascript:history.go(-1);"></td>
							<td align='center'>
								<?php 
									echo form_submit('share', 'Share','class="myButton" onclick="return share_pointsto_teacher();"');
								?>
							</td>
						</tr>
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
	document.getElementById("sharepts").className += " active";
</script>