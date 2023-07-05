 <?php 
//This view is created by Sayali Balkawade for SMC-4277 on 25/12/2019 
?>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Activity List Summary Report</h2>
            </div>
	
	
	
    <div class='row'>
			
					<form method="post" class="pull-left" action="<?php echo base_url();?>teachers/empActivitySummary_report">
					
      <input type="hidden" name="year" value="" />
     
      <button class="btn btn-info" type="submit"><i class="glyphicon glyphicon-chevron-left"></i>Back</button>
    </form>
						
						
		 </div> 
		 
	
			   <div class="row clearfix">
			   
	<div class="col-md-12"><span class="pull-right"><a class="btn btn-info" href="<?php echo base_url();?>teachers/activityWisePoint_graph/<?php echo $from;?>/<?php echo $to;?>/<?php echo $userId;?>/<?php echo $activity;?>/<?php echo $entity;?>">Graph</a></span></div><br>
	
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr No</th>
						 <th> Activity Name</th>
							
							<th>Points</th>
											
						</tr>
                    </thead>
                    <tbody>
                                            <?php 
                                            $i=1;
											
						
                                            foreach($data as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                             
												<td data-title="Activity Name"><?php echo $t['sc_list'];?></td>
                                            <td data-title="Points" ><?php echo $t['point'];?></td>
											
                                        </tr>
                                      <?php $i++;}?>
									</tbody>
									
									</table>
								</div>
							
								
						
				</div>  
		</div>		
</div>	

		 
		 
		 
		 