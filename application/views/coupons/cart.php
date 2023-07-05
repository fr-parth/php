<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>
<div class="panel panel-default">
  <div class="panel-heading"><b>Selected Coupons Cart</b>
  </div>
  <div class="panel-body">
	<div class="table-responsive">
	<table class="table" id="myTable" style="margin-left: 0px !important;">
	<thead>
	<tr ><th>Sr.No</th><th>Coupon ID</th><th>Product Name</th><th>Company Name</th><th>Address</th><th>Points</th><th>Delete</th></tr></thead><tbody>
   <?php
	$sr=1;$tot=0;
	foreach($cart_items['items'] as $key =>$value){
	?>		
			<tr>
			<td><?php echo $sr;?></td>
			<td><?=$cart_items['items'][$key]->coupon_id;?></td>
			<td><?=$cart_items['items'][$key]->Sponser_product;?></td>
			<td><?=$cart_items['items'][$key]->sp_company;?></td>
			<td><?=$cart_items['items'][$key]->address; ?></td>
			<td><?=$cart_items['items'][$key]->for_points;?></td>
			<td><a href="<?=site_url('Ccoupon/del_cart/'.$cart_items['items'][$key]->id.'/'.$cart_items['items'][$key]->coupon_id); ?>">
				<span class=" glyphicon glyphicon-trash"></span></a>
			</td>
			</tr>
			<?php $sr++; 
		}	 
	?>
	</tbody>
	<tr>
		<td>Remaining Points</td>
		<td><?=$rem_pts;?></td>
		<td></td>
		<td></td>
		<td>Total</td>
		<td><b><?=$cart_items['usedpts'][0]->usedpts;?></b></td>
		<td></td>
	</tr>
	</table>
	
	
	</div>
	<a href='<?=site_url('Ccoupon/select_coupon'); ?>' ><button class='btn btn-info'>Add More</button></a>
	<a href='<?=site_url('Ccoupon/confirm_cart'); ?>'><button class='btn btn-success'>Confirm</button></a>
</div>
</div>