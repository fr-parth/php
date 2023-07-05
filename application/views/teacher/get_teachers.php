<?php 
//print_r($teacher_info); 
$points_type = array('Bluepoints'=>'Blue Points','Waterpoints'=>'Water Points','Brownpoints'=>'Brown Points');
 ?>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align="center">
                <h2>Share Points to Teacher</h2>
            </div>
		<div class="row clearfix">
		<head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
		<script>
			document.getElementById("otheract").className += " active";
			document.getElementById("sharepts").className += " active";
		</script>
		</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				$thanqu_flag=$teacher_details[0]->thanqu_flag;
				$te="Te";
				$pos = strpos($thanqu_flag,$te);
				if($pos == false)
				{
					echo "<tr>
					<td colspan=6>You do not have permission to Share blue Points !... </td></tr> ";
					exit;
				}
				echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Teacher':'Manager'; ?></a> Id</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Teacher':'Manager'; ?> Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Share Points</th>						
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($teacher_details as $teachers){	
							//$filepath = PRODUCT_IMG_ROOT_PATH.$cart_coupon->product_image;
							if(!empty($teachers->complete_name)){
								  $teacher_name = $teachers->complete_name;
							  }
							  else{
								  $teacher_name = $teachers->firstname.' '.$teachers->middlename.' '.$teachers->lastname;
							  }
							?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $teachers->t_id; ?></td>
							<td><?php echo $teacher_name; ?></td>
							<td><?php echo $teachers->t_internal_email; ?></td>
							<td><?php echo $teachers->t_phone; ?></td>
							<td><a href="<?php echo base_url();?>teachers/share_pointsto_teacher/<?php echo $teachers->t_id;?>"><input type="button" value="Share" class="myButton"></a></td>
						</tr>
							<?php } ?>
						
					</tbody>
				</table>
			</div>
			 
		</div>
		</div>
</div>