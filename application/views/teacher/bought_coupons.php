<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>My Bought Coupons (Used/Unused)</h2>
			</div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Image</th>
							<th>Shop Name</th>
							<th>Product Name</th>
							<th>Coupon Code</th>
							<th>Coupon Point</th>
							<th>Valid Until</th>
							<th>Coupon Status</th>
							<th>Show</th>
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($bought_coupons as $bought_coupon){	
						$filepath = PRODUCT_IMG_ROOT_PATH.$bought_coupon->product_image;
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><img src="<?php if(!file_exists($filepath) || empty($bought_coupon->product_image)){echo DEFAULT_IMG_PATH  ;}else{echo PRODUCT_IMG_PATH.$bought_coupon->product_image;}?>" alt="Avatar" width="60" height="50" style="padding-top:5px;"></td>
							<td><?php
//$bought_coupon->sp_company done by sayali intern for SMC-3657 on 29-3-19
							echo $bought_coupon->sp_company; ?></td>
							<td><?php echo $bought_coupon->Sponser_product; ?></td>
							<td><?php echo $bought_coupon->code; ?></td>
							<td><?php echo $bought_coupon->for_points; ?></td>
							<td><?php echo date('Y/m/j', strtotime($bought_coupon->valid_until)); ?></td>
							<td><?php echo $bought_coupon->used_flag; ?></td>
							<td><a href="<?php echo base_url(); ?>/teachers/show_sponsor_coupon/<?php echo $bought_coupon->id; ?>"><input type="button" value="Show" class="myButton"></a></td>
						</tr>
							<?php } ?>
						
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
			document.getElementById("sponCoupon").className += " active";
			document.getElementById("allCoupon").className += " active";
		</script>
</head>