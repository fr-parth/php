                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
						 <th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?> Name</th>
							
							<th>Points</th>
											
						</tr>
                    </thead>
                    <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($data2 as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                             
												<td data-title="Employee Name"><?php echo $t['Employee_name'];?></td>
                                            <td data-title="Points" ><?php echo $t['Assigned_points'];?></td>
											
                                        </tr>
                                      <?php $i++;}?>
									</tbody>
									</table>