<?php 
//print_r($teacher_info); 
$points_type = array('Bluepoints'=>'Blue Points','Waterpoints'=>'Water Points','Brownpoints'=>'Brown Points');
 ?>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>My Cart Coupons</h2>
			</div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
			<?php echo form_open("","class=form-horizontal");?>
			<input type="hidden" name="total" id="total" value="<?php echo $total_points; ?>">
			<input type="hidden" name="avail_blue" id="avail_blue" value="<?php echo $teacher_info[0]->balance_blue_points; ?>">
                <table id="cart_table" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Sponsor Name</th>
							<th>Product Image</th>
							<th>Product Name</th>
							<th>Address</th>
							<th>Points</th>
							<th>Remove</th>							
						</tr>
						<tr><td colspan=7 align='center'><?php if(count($cart_coupon_details)=='0'){ echo "There is no coupon to buy!!"; }?></td></tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($cart_coupon_details as $cart_coupon){
							$filepath = PRODUCT_IMG_ROOT_PATH.$cart_coupon->product_image;
							?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $cart_coupon->sp_name; ?></td>
							<td><img src="<?php if(!file_exists($filepath) || empty($cart_coupon->product_image)){echo DEFAULT_IMG_PATH  ;}else{echo PRODUCT_IMG_PATH.$cart_coupon->product_image;}?>" alt="Avatar" width="70" height="60" style="padding-top:5px;"></td>
							<td><?php echo $cart_coupon->Sponser_product; ?></td>
							<td><?php echo $cart_coupon->sp_address; ?></td>
							<td><?php echo $cart_coupon->for_points; ?></td>
							<td><input type="button" value="Remove" class="myButton" onclick="cartrem('<?php echo $cart_coupon->cartid; ?>')"></td>
						</tr>
							<?php } ?>
						<?php if(count($cart_coupon_details) > '0'){?>
						<tr><td colspan=2 align='center'>
								<input type="button" value="Buy All" id="buy" class="myButton" onclick="return buyFromCart();">
							</td>
							<td colspan=2 align='center'>
								<input type="button" value="Remove All" id="Remove All" class="myButton" onclick="return cartrem(this.value);">
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			 
		</div>
</div>

<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
<script>
document.getElementById("sponCoupon").className += " active";
document.getElementById("cartCoupon").className += " active";
</script>
		