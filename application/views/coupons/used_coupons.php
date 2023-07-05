<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>

<div class="panel panel-violet">
  <div class="panel-heading">
  Used Coupons Log
  </div>
  <div class="panel-body">		
	<div class="table-responsive" id="no-more-tables">
	<table class="table table-bordered table-striped table-condensed cf" id="myTable" style="margin-left: 0px !important;">
	<thead class="cf">
	<tr>
	<th>Sr.No</th>
	<th>Product ID</th>
	<th>Coupon Code</th>
	<th>Product</th>
	<th>Points</th>
	<th>Company</th>
	<th>Address</th>
	<th>Offer</th>
	<th>TimeStamp</th>
	</tr>
	</thead>
	<tbody>
	<?php 
$sr=1;
foreach($my_coupons as $key=>$value):
?>
<tr>
	<td data-title="Sr." ><?=$sr;?></td>

	<td data-title="Product ID" ><?=$value->id;?></td>

	<td data-title="Coupon code" ><?=$value->code;?></td>
	<td data-title="Product" ><?=$value->Sponser_product;?></td>
	<td data-title="Points" ><?=$value->points_per_product;?></td>
	<td data-title="Company" ><?=$value->sp_company;?></td>	
	<td data-title="Address" ><?php echo $value->sp_address."</br>".$value->sp_city;?></td>
	<td data-title="Offer" >
			<?php if($value->discount!=0 or $value->discount!=0){ 
												echo $value->discount."% Off"; 
											} 
											if($value->buy!=0 and $value->get!=0){ 
												if($value->discount!=0){ 
													echo ' Or ';
												} 
												echo 'Buy '.$value->buy.' Get '.$value->get.' Free'; 
											} 
			?><br/>
			<?php if($value->saving!=0){ echo "Save ".$value->currency.' '.$value->saving."</br>";}?></td>	
	<td data-title="TimeStamp" ><?=$value->timestamp;?></td>	
</tr>
<?php 
$sr++;
endforeach;
 ?>		

</tbody>
</table></div></div>
	</div>