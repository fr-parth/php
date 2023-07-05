<?php 
 
//Created by Rutuja Jori on 21/12/2019 for SMC-4278
//Updated by Rutuja Jori to show Department of logged in Manager on 03/01/2019 for SMC-4370
 $t_dept=$teacher_info[0]->t_dept;
	
?>

	 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php //echo form_open("","class='form-horizontal' onSubmit='window.location.reload(true)'");?>
				<form method="post" action=" " id="assign_form">
				<input type="hidden" name = "avail_green" id="avail_green" value="<?php echo $teacher_info[0]->tc_balance_point; ?>">
				<input type="hidden" name = "avail_water" id="avail_water" value="<?php echo $teacher_info[0]->water_point; ?>">
                    <thead>
						  <tr><th colspan=3>Set Department Hierarchy for <?php echo $t_dept;?> Department</th>
						  </tr>
                    </thead>
                    <tbody>
						
						<tr>
							<td>
								Select Reporting Manager:
							</td>
							<td>
								<select class="form-control searchselect" id="reporting_mang" name="reporting_mang" style="width:495px;" required/> 
									<option value=''>Select Reporting Manager</option>
									<?php foreach($reporting_mang_list as $t){?>
									<option value="<?php echo $t->t_id;?>"><?php echo $t->t_complete_name;?></option>
									<?php }?>
									
								</select>
								<div id="repmang"></div>
								<?php echo form_error('reporting_mang', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						  
						<tr>
							<td>
								Select Category:
							</td>
							<td>
								<select class="form-control" id="category" name="category" style="width:495px;" required/> 
									<option value=''>Select Category(Employee/Manager)</option>
									<option value='Employee'>Employee</option>
									<option value='Manager'>Manager</option>
									
								</select>
								<div id="actsub"></div>
								<?php echo form_error('reporting_mang', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						
						<tr>
							<td>
								Select Employee/Manager:
							</td>
							<td>
								<select class="form-control searchselect" id="emp_mang_l" name="emp_mang_l" style="width:495px;" required/> 
								<option value="">Select</option>	
								</select>
								<div id="actsub"></div>
								<?php echo form_error('reporting_mang', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						
						<tr>
							<td align='center'><input type="button" value="Back" class="myButton" onclick="javascript:history.go(-1)";></td>
							<td align='center'>
								<?php 
									echo form_submit('update', 'Update','class="myButton btn-success" id="submit_button" onclick=" return dept_hierarchy();"');
								?>
							</td>
							
						</tr>
					</tbody>
				</table>
				
				<label class="col-sm-4" for="type_emp_mang">Select Reporting Personnel For:</label>
							<select name="type_emp_mang" id="type_emp_mang" class="form-control" required />
								<option value="">Select</option>
								<option value="Employee">Employee</option>
								<option value="Manager">Manager</option>
								
							</select>
							
				<div id="log_div1" class="scroll"></div>
                            	<div id="onload_div1" class="scroll">
				    
				</table>
				</div>
			</div>
		</div>
		</div>
	</div>
  
 
<script type="text/javascript">

$('#category').change(function() {
			var value = $(this).val();
 
 			$.ajax({
					type: "POST",
					url: base_url + '/Employee_Manager/emp_manager_list',
					data: { sc_type : value}, 
					cache:false,
					success: function(data) { 
                        console.log(data); 
							$('#emp_mang_l').html(data);
						}		
				});
		});

   
$(document).ready(function() {
    $('.searchselect').select2();

    <?php if(isset($_POST['submit'])){?>
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value =   "<?= $_POST['reporting_mang'];?>";
			var value =   "<?= $_POST['emp_mang_l'];?>";
         <?php  }?>
});

</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH; ?>/js/validation.js"></script>
	
	<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>