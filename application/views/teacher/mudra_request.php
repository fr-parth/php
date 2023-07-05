    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Mudra Request To Manager</h2>
            </div>
								
            <?php $empType = $teacher_info[0]->t_emp_type_pid; ?> 
            <div class="row clearfix">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<?php 					
						if($empType == '133' || $empType == '134'){ //Manager
						
							$list = array('Manager','Reviewing Officer','Member Secretary','Vice Chairman','Chairman');
						}
						else if($empType=='135'){ //Reviewing Officer

							$list = array('Reviewing Officer','Member Secretary','Vice Chairman','Chairman');
						}
						// else if($empType=='137'){ //Appointing Authority

						// 	$list = array('Appointing Authority','Reviewing Officer','Member Secretary','Vice Chairman','Chairman');
						// }
						else if($empType=='139'){ //Member Secretary

							$list = array('Member Secretary','Vice Chairman','Chairman');
						}
						else if($empType=='141'){ //Vice Chairman

							$list = array('Vice Chairman','Chairman');
						}
						else if($empType=='143'){ //Chairman

							$list = array('Chairman');
						}
						else{
							$list = array('Manager');
						}
					?>
						<label class="col-sm-3" for="manager_type">Select Type:</label>
							<select name="manager_types" id="manager_type" class="form-control" required />
								<!-- <option value="">Select</option> -->
								<?php 
								foreach ($list as $k => $value) { ?>
									<option value="<?php echo $value; ?>">
									<?php echo $value; ?>					 	
							 		</option>
								<?php } //foreach
								 ?>
							</select>
							
										
			<div id="log_div1" class="scroll"></div>
                            	<div id="onload_div1" class="scroll">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
									<thead class="thead-dark">
									  <th>Sr. No.</th>
									  <th>Manager ID</th>
									  <th>Name</th>
									  <th>Type</th>
						  			  <th>Request Points</th>
									  <th>ThanQ Points</th>
					   				</thead>
                                        <tbody>
																			
                                    <?php 
                                    $i=1;
									foreach($data as $t){ 
									?>
									  
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $t['teacher_id']?></td>
								  <td><?php echo $t['teacher_name'] ?></td>
								  <td><?php echo $key ?></td>
								  <td><a href="<?php echo base_url();?>teachers/request_mudra/<?php echo $t['teacher_id'];?>"><input type="button" class="myButton" value="Request"/></a></td>
								  <td><a href="<?php echo base_url();?>teachers/thanq_mudra/<?php echo $t['teacher_id'];?>"><input type="button" class="myButton" value="ThanQ"/></a></td>
								</tr>
										
					 <?php } //foreach ?>
                                        </tbody>
                                    </table>
                                </div>
                <!-- #END# Browser Usage -->
				</div>
			</div>
		</div>
    </div>
    
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" ></script>
		<script>
			document.getElementById("otheract").className += " active";
			document.getElementById("mudra").className += " active";
		</script>				