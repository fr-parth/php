<?php 
/*Author : Pranali Dalvi
Date : 17-12-19
This file was created to assign thanq mudra from manager to manager or higher authority
*/

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
				<input type="hidden" name = "avail_blue" id="avail_blue" value="<?php echo $logged_teacher[0]->balance_blue_points; ?>">
				<input type="hidden" name = "avail_water" id="avail_water" value="<?php echo $logged_teacher[0]->water_point; ?>">
                    <thead>
						<tr>
							<th colspan=2>ThanQ To <?php echo $teacher_name; ?></th>
						</tr>
                    </thead>
					<tbody>
						
						<tr>
							<td>Department : </td>
							<td><?php echo $teacher_info[0]->t_dept?></td>	
						</tr>
						<tr>
							<td>
								Select ThanQ Reason
							</td>
							<td>			  
								<select name="thanq_reason" id="thanq" class="form-control"/>
									<option value="">Select ThanQ Reason</option>
										<?php
											foreach($thanqlist as $t){?>
											<option value="<?php echo $t['id'].'#'.$t['t_list'];?>"><?php echo $t['t_list'];?></option>
											<?php }
									?>
								</select>
								<?php echo form_error('thanq_reason', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
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
						<td align='center'><input type="button" value="Back" class="myButton" onclick="javascript:history.go(-1);"></td>
							<td align='center'>
								<?php 
									echo form_submit('thanq_mudra', 'ThanQ','class="myButton" onclick="return thanq_mudra();"');
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
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
<script>
	document.getElementById("otheract").className += " active";
	document.getElementById("mudra").className += " active";
</script>