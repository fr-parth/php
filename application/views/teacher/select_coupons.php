<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<h1 style="margin-left:400px;">Coming Soon</h1>
</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
  <head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
		<script>
			document.getElementById("sponCoupon").className += " active";
			document.getElementById("selCoupon").className += " active";
		</script>
</head>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
    
		<div class="row">
		 <div class="block-header" align="center">
                <h2>Available Sponsor Coupons</h2>
            </div>-->
			<!--<div class="col-md-3" style= "height:100%;width:10%; border-style: solid;">-->


		<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
		<table id="coupon_table" class="table table-striped table-inverse  table-bordered table-responsive table-dark" style="border:none;" align="center" >
		<input type="hidden" name="avail_blue" id="avail_blue" value="<?php echo $teacher_info[0]->balance_blue_points; ?>">
		<thead>
		<form action="" method="POST">
		<div class="panel-body">
				<label class="col-sm-2" for="schoolName">Enter Location:</label>
				<div class="col-sm-3"> 
				<input id="address1" type="text" name="address" placeholder="Enter Location" class="form-control" value="<?php //echo $locate;?>" />
				<?php echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
				
				</div>
				<label class=" col-sm-2" for="pointType">Select Category:</label>
				<div class="col-sm-3">
					<select name="category" id="category" class="form-control" />
						<option value="">Select Category</option>
						<option value="all">All</option>
						<?php  
						foreach($categories as $cat){?>
						<option value="<?php echo $cat->id;?>"><?php echo $cat->category;?></option>
						<?php }?>
					</select>
					
				</div>
				
				<div class="col-sm-2" ><input type="submit" name="submit1" value="Submit" id="submit2" class="myButton"/></div>
            </div>
		</form>
				</br>
				<div id="loading1" align="center" style="display:none"><img src="<?php echo base_url();?>/image/ajax-loader.gif"></div>
		</thead>
		<tbody>
		</br><div id="onload_div" class="scroll">
		<?php
			$i=1;
			foreach($coupon_details as $coupons)
			{
				$filepath = PRODUCT_IMG_ROOT_PATH.$coupons->product_image;
		?>
			<div class="col-md-4 mainclass details">
				<center><img src="<?php if(!file_exists($filepath) || empty($coupons->product_image)){echo DEFAULT_IMG_PATH  ;}else{echo PRODUCT_IMG_PATH.$coupons->product_image;}?>" alt="Avatar" width="160" height="140" style="padding-top:5px;"></center><br>
				<div class ='' >
					<h4><b><?php echo $coupons->discount ?>% OFF YOUR PURCHASE </b></h4>
					<p><span class="promo">(ON <?php echo $coupons->points_per_product ?> POINTS)</span></p>
					<p>Description: <?php echo $coupons->Sponser_product.'  '.$coupons->offer_description ?></p> 
					<p>Shop Name: <?php echo $coupons->sp_company ?></p>
					<p>Price: <?php echo $coupons->product_price ?> <?php if(!empty($coupons->currency)){echo $coupons->currency;}else {echo "INR";} ?></p>
					<p class="expire">Expires: <?php echo $coupons->valid_until ?></p>
					<input type="hidden" id="ppp[]" name="product_point[]" value="<?php echo $coupons->points_per_product ?>">
					<p><input type="button" class="myButton" id="cart<?php echo $i;?>" value="Add to Cart" onclick="return myfunc('<?php echo $coupons->points_per_product; ?>','<?php echo $coupons->id; ?>','<?php echo $i;?>')"/> <input type="button" class="myButton" id="buy<?php echo $i;?>" value="Buy" onclick="return buyCoupon('<?php echo $coupons->points_per_product; ?>','<?php echo $coupons->id; ?>','<?php echo $i;?>')"/></p>
				</div>		
			</div><?php $i++;}?></div>
		<div id='coupon_div' class="scroll"><div><br>
		
			</tbody>
		</table>
		</div>
		</div>
		</div>
	</div>
	</div>
</div>
</html> -->
<!--Below code commented for bug SMC-3591 by Pranali on 27-9-19 -->
<!-- <script>
        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('address1')),
                {types: ['geocode']});
            autocomplete.addListener('place_changed', fillInAddress);
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY&libraries=places&callback=initAutocomplete" async defer></script>
 -->
