 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Employee Activity Summary Report</h2>
            </div>
	
			<form method="post" action=" " id="report">
			<div class="col-md-6">
	<div class="col-md-3 " id="fromDiv" style="font-size:15px;"><b>From</b><span class="mandatory"></span>
	</div>
	<div class="col-md-4">
 <input  type="text" class="form-control" id="from" style="margin-top: 1px;"  name="from" value="<?= $_POST['from']; ?>"  autocomplete="off"  />
			  
		  </div>
		  </div>
		  <div class=" col-md-6">
		  <div class="col-md-3 " id="toDiv" style="font-size:15px;"><b>To</b><span class="mandatory"></span>
		  </div>
		  <div class="col-md-4">
			<input type="text" class="form-control" id="to"  style="margin-top: 1px;" name="to" value="<?= $_POST['to']; ?>" autocomplete="off" />
			 
		  </div>
		   </div>
	<br><br><br>
						<?php 
									//echo $t_id1;								//print_r($data);
								$emp= $_POST['employee'];
								$arr=explode('#',$emp);
	 
								 //array
								 $t_dept1=$arr[1];
								 $t_class1=$arr[2];
								  $t_id1=$arr[3];
	
						$empType = $teacher_info[0]->t_emp_type_pid; 
							$t_class=$this->session->userdata('t_class');
							
						if($empType=='137' || $empType=='139' || $empType=='141' || $empType=='143')
						{?>
						<div class="col-md-4">
									<div class="row " style="padding-top:30px;">
										 <div class="col-md-4" style="font-size:15px;"><b>Department List</b><span class="mandatory"></span>
										</div>
										<div class="col-md-6">
										
										   <select name="department" id="department" class="form-control"/>
											<option value="All">All</option>
											<?php
									
											foreach ($data3 as $key => $value) { ?>
												<option  <?php if($_POST['department']==$value['Dept_Name'])
												{ echo 'selected'; }?> value="<?php echo $value['Dept_Name']; ?>">
												<?php echo $value['Dept_Name']; ?>					 	
												</option>
											<?php }
											 ?>
										</select>
										</div>
										</div>
										</div>
					
						
										<div class="col-md-4">
										<div class="row " style="padding-top:30px;">
										<div class="col-md-4" style="font-size:15px;"><b>Manager List</b><span class="mandatory"></span>
										</div>
										<div class="col-md-6">
										
										  <select name="employee" id="employee" class="form-control"    />
								<option value="All">All</option>
								<?php 
								foreach ($data as $key => $value) { ?>
								
									<option  <?php if( $employee==$value['t_emp_type_pid'] && $t_id1==$value['t_id'])
									{
										echo 'selected'; }?> value="<?php echo $value['t_emp_type_pid'].'#'.$value['t_dept'].'#'.$value['t_class'].'#'.$value['t_id']; ?>">
									<?php echo $value['t_complete_name']; ?>					 	
							 		</option>
								<?php }
								 ?>
							</select>
										</div>
										</div>
										</div>
						
						<div class="col-md-4">
						<div class="row " style="padding-top:30px;">
						 <div class="col-md-4" style="font-size:15px;"><b>Activity List</b><span class="mandatory"></span>
										</div>
										<div class="col-md-6">
										
										   <select name="activity" id="activity" class="form-control"/>
											<option value="0">All</option>
											<?php 
											foreach ($data1 as $key => $value) { ?>
												<option <?php if($_POST['activity']==$value['sc_id'])
												{ echo 'selected'; }?> value="<?php echo $value['sc_id']; ?>">
												<?php echo $value['sc_list']; ?>					 	
												</option>
											<?php }
											 ?>
										</select>
										</div>
										</div>
										</div>
										
										
										<br><br><br>
										
										
										
										
							<?php } else if ($empType=='135'){ ?>
							
							<div class="col-md-6">
							<div class="col-md-3" style="font-size:15px;"><b>Manager List</b><span class="mandatory"></span>
                            </div>
                            <div class="col-md-4">
							
                               <select name="employee" id="employee" class="form-control"    />
								<option value="All">All</option>
								<?php 
								foreach ($data as $key => $value) { ?>
								
									<option  <?php if( $employee==$value['t_emp_type_pid'] && $t_id1==$value['t_id'])
									{
										echo 'selected'; }?> value="<?php echo $value['t_emp_type_pid'].'#'.$value['t_dept'].'#'.$value['t_class'].'#'.$value['t_id']; ?>">
									<?php echo $value['t_complete_name']; ?>					 	
							 		</option>
								<?php }
								 ?>
							</select>
                            </div>
							</div>
			<div class="col-md-6">
			 <div class="col-md-3" style="font-size:15px;"><b>Activity List</b><span class="mandatory"></span>
                            </div>
                            <div class="col-md-4">
							
                               <select name="activity" id="activity" class="form-control"/>
								<option value="0">All</option>
								<?php 
								foreach ($data1 as $key => $value) { ?>
									<option <?php if($_POST['activity']==$value['sc_id'])
									{ echo 'selected'; }?> value="<?php echo $value['sc_id']; ?>">
									<?php echo $value['sc_list']; ?>					 	
							 		</option>
								<?php }
								 ?>
							</select>
                            </div>
							</div>
							
							<?php } else { ?>
							<div class="col-md-6">
							<div class="col-md-3" style="font-size:15px;"><b>Activity List</b><span class="mandatory"></span>
                            </div>
                            <div class="col-md-4">
							
                               <select name="activity" id="activity" class="form-control"/>
								<option value="0">All</option>
								<?php 
								foreach ($data1 as $key => $value) { ?>
									<option <?php if($_POST['activity']==$value['sc_id'])
									{ echo 'selected'; }?> value="<?php echo $value['sc_id']; ?>">
									<?php echo $value['sc_list']; ?>					 	
							 		</option>
								<?php }
								 ?>
							</select>
                            </div>
                            </div>
							
							<?php } ?>
							<br><br><br>
							
							
							
							<div class="col-md-6">
							<div class="col-md-3" style="font-size:15px;"><b>Summary Report Of :</b><span class="mandatory"></span>
                            </div>
                            <div class="col-md-4">
							
                                 <select name="type" id="type" class="form-control" />
								<option value="Employee">Employee</option>
								<option value="Manager">Manager</option>
								
							</select>
                            </div>
							
			</div>
			<div class="col-md-6">
					<tr>
						
							<div style='margin-left:28%'>
								<?php 
									echo form_submit('assign', 'Submit','class="myButton btn-success" id="submit_button"');
								?>
							</div>
							
						</tr>
			</div>
			
                                </div>
								</form>
               <br><br><br>
			   
			   <div class="row clearfix">
			  
		<?php if ( $this->input->post('assign'))
		{?>
	
	<?php
		
if($employee =='')
	{
	$employee='All';
	}?>
	<?php 
	$t_dept=$_POST['department']; 
	if($t_dept=='')
	{
	$t_dept=$this->session->userdata('t_department');
	}

	?> 
	
	<?php 
	
	if($empType=='133' || $empType=='134')
	{
		$class=$t_class;
		
	}

		else if ($empType=='135' && $employee=='All')
		{
		if ($t_class !='')
		{
			$class=$t_class;
		}
		}
	else if ($empType=='135' && $employee !='All')
	{
		$class=$t_class1;
	} 
	
	 else if (($empType=='137' || $empType=='139' || $empType=='141'|| $empType=='143')  && $employee =='All') 
	 {
		 $class=$t_class;
	 }
	 
	 else if (($empType=='137' || $empType=='139' || $empType=='141'|| $empType=='143')  && $employee !='All') 
	 {
		 $class=$t_class1;
	 }
	?>
	
	
	
	<?php if($empType=='133' || $empType=='134')
	{

			if ($class !='')
			{?>
				
		<div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>/<?php echo $class;?>">Graph</a></span></div><br>
		
		
	<?php } else {?>
		 <div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>">Graph</a></span></div><br>
	<?php }?>


	<?php }else if ($empType=='135' && $employee=='All')
	{
		if ($class !='')
			{?>
				
		<div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>/<?php echo $class;?>">Graph</a></span></div><br>
	<?php } else {?>
		 <div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>">Graph</a></span></div><br>
	<?php } } else if ($empType=='135' && $employee !='All')
	{ ?>
		
		<div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>/<?php echo $class;?>">Graph</a></span></div><br>
		
	<?php } else if (($empType=='137' || $empType=='139' || $empType=='141'|| $empType=='143')  && $employee =='All') 
	{?>
		 <div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>">Graph</a></span></div><br>
		
	<?php } else if (($empType=='137' || $empType=='139' || $empType=='141'|| $empType=='143')  && $employee !='All') {?>
	
	
		<div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/employeeActivity_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $employee;?>/<?php echo $activity;?>/<?php echo $empManType;?>/<?php echo $t_id;?>/<?php echo $school_id;?>/<?php echo $empType;?>/<?php echo $t_dept;?>/<?php echo $class;?>">Graph</a></span></div><br>
	<?php }?>
		
		
	
	
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll" id="resTable">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
						 <th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?> Name</th>
						 <th>ID</th>
							
							<th>Points</th>
											
						</tr>
                    </thead>
                    <tbody>
                                            <?php 
                                            $i=1;
													
											$fromdt=$_POST['from'];
											$todt=$_POST['to'];
											$activityID=$_POST['activity'];
											$entityType=$_POST['type'];
											
											$userID= $t['Employee_ID'];
											//$entityType=
                                            foreach($data2 as $t) {?>
											
											<input type='hidden' name='from_date' value='<?php echo $fromdt; ?>' />
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                             
												<td data-title="Employee Name"><?php echo $t['Employee_name'];?></td>
												<td data-title="ID"><?php echo $t['Employee_ID'] ;?></td>
                                            <td data-title="Points" >
											
											<a href="<?php echo base_url();?>teachers/activityWisePoint/<?php echo $fromdt;?>/<?php echo $todt;?>/<?php echo $t['Employee_ID'];?>/<?php echo $activityID;?>/<?php echo $entityType;?>"><?php echo $t['Assigned_points'];?></td>
											
										
                                        </tr>
										
                                      <?php $i++;}?>
									</tbody>
									</table>
								</div>
		<?php }?>
							
				</div>    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 <script>
        $(document).ready(function (){
			var cr_dt= new Date();
			var mnth= cr_dt.getMonth()+1;
			var yr = cr_dt.getFullYear();
			//var fr_dt = "01-"+mnth+"-"+yr;
//maxDate : 0 added in from and to date by Pranali for SMC-4834 ON 19-9-20
			var fr_dt= yr+"-"+mnth+"-01";
            $("#from").datepicker({
               changeMonth: true,
                changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate : 0
				
				
            });
        
            $("#to").datepicker({
                changeMonth: true,
                changeYear: true,
				
        dateFormat : 'yy-mm-dd',
		 
        defaultDate: new Date(),
				maxDate : 0
    });
   $("#to").datepicker('setDate', new Date());
  $("#from").datepicker('setDate', fr_dt);
				
            });
	
    </script>
	<script>
	//for department change
// $('#department').change(function() {
// var value = $(this).val();
//alert(value);
  // $.ajax({
// type: "POST",
 
// url: base_url + '/empActivity/departmentWise',
// data: { dept : value},
// cache:false,
// success: function(data)
 // { //alert('hii');
                         // console.log(data);
// $('#employee').html(data);
// }
// });
// });
</script>

