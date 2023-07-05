<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
					<h2>Activity Log</h2>
			</div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>

						<tr>
							<th>Sr No</th>
							<th>Activity</th>
							<th>To</th> 
						<th>Entity Type</th>
						 <th>Points</th>
						<th>Device Details</th>
                         <th> Date</th>					
						</tr>
                    </thead>
                    <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($data as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                             <td data-title="Activity" ><?php echo $t['Activity'];?></td>
                                
												<?php if($t['sp_company']!=null){ ?>
													<td data-title="To" ><?php echo $t['sp_company'];?></td>
												<?php } 
												else if($t['std_complete_name']!=null){ ?>
													<td data-title="To" ><?php echo $t['std_complete_name'];?></td>
												<?php }
												else {?>
													<td data-title="To" ><?php echo $t['t_complete_name'];?></td>
												<?php }?>
												
												<?php if($teacher_info[0]->sctype=='school' && $t['Entity_Type_2']=='103')
												{ ?>
													 <td data-title="Entity Type" ><?php echo "Teacher";?></td>
												<?php }
												else if ($teacher_info[0]->sctype=='organization' && $t['Entity_Type_2']=='103')
												{ ?>
													<td data-title="Entity Type" ><?php echo "Manager";?></td>
												<?php }
												else if ($teacher_info[0]->sctype=='school' && $t['Entity_Type_2']=='105')
												{ ?>
													<td data-title="Entity Type" ><?php echo "Student";?></td>
												<?php }
												else if ($teacher_info[0]->sctype=='organization' && $t['Entity_Type_2']=='105')
												{ ?>
													<td data-title="Entity Type" ><?php echo "Employee";?></td>
												<?php }
												else 
												{?>
													<td data-title="Entity Type" ><?php echo "Sponsor";?></td>
												<?php }?>
												
                                            <td data-title="Points" ><?php echo $t['quantity'];?></td>
											    <td data-title="Device Details" ><?php echo ucwords(strtolower( $t['FirstDeviceDetails']));?></td>
											<td data-title="Date"><?php echo $t['Timestamp'];?></td>
                                         
                                          
                                        </tr>
                                      <?php $i++;}?>
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