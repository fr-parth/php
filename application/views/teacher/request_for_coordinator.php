<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2>Students Request for Coordinator</h2>
        </div>
		<div class="row clearfix">
			<head>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
				<script>
					document.getElementById("otheract").className += " active";
					document.getElementById("coordRequest1").className += " active";
				</script>
			</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?> Image</th>
							<th><?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?> Name</th>
							<th>Request Date</th>
							<th>Accept</th>
							<th>Decline</th>							
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($coordinator_requests as $coordinator){
							
						if(!empty($coordinator->std_complete_name))
						{
							 $std_name = $coordinator->std_complete_name;
						}
						else
						{
							 $std_name = $coordinator->std_name.' '.$coordinator->std_Father_name.' '.$coordinator->std_lastname;
						}
						$filepath = $_SERVER['DOCUMENT_ROOT'].'/core/'.$coordinator->std_img_path;
						if(!file_exists($filepath) || empty($coordinator->std_img_path))
						{
							$std_img_path =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
						}
						else
						{
							$std_img_path = base_url().'/core/'.$coordinator->std_img_path;
						}
						$date = explode('/',$coordinator->requestdate);
					?>	
						<tr>
							<td><?php echo $i; ?></td>
							<td><img src="<?php echo $std_img_path; ?>" height="50" width="50"></td>
							<td><?php echo $std_name; ?></td>
<!--// removed from date by Pranali for SMC-3641 on 25-10-19-->
							<td><?php echo $date[2].$date[1].$date[0]; ?></td>
							<td><input type="button" value="Accept" id="accept<?php echo $i;?>" onclick="return adcoordrequest('<?php echo $coordinator->stdmemid; ?>','<?php echo $coordinator->id;?>','<?php echo $i;?>')"></td>
							<td><input type="button" value="Decline" id="decline<?php echo $i;?>" class="myButton" onclick="return deccoordrequest('<?php echo $coordinator->stdmemid;?>','<?php echo $coordinator->id;?>','<?php echo $i;?>')"></td>
						</tr>
							<?php $i++;} ?>
						
					</tbody>
				</table>
			</div>
			 
		</div>
		</div>
</div>