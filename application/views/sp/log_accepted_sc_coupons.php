<?php $this->load->view('sp/header'); 
$this->load->helper('imageurl');
?>

<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>

<div class="panel panel-violet">
  <div class="panel-heading">
  Accepted SmartCookie Coupons <span class="badge"><?=$count_accepted_sc_coupons;?></span>
  </div>
  <div class="panel-body">		
	<div class="table-responsive" id="no-more-tables">
	<table class="table table-bordered table-striped table-condensed cf" id="myTable" style="margin-left: 0px !important;">
	<thead class="cf">
	<tr>
	<!--Camel Casing in email done by Pranali for bug SMC-2275 on 9-7-2018-->
	<th>Sr.No.</th>
	<th>Image</th>
	<th>Used By</th>
	<th>User Type</th>
	<th>Code</th>
	<th>Product</th>
	<th>Points</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
<?php 

$sr=1;
foreach ($log_accepted_sc_coupons as $key => $value): 
//print_r($value);
// VaibhavG commented below code to new date format for ticket number SMC-3486 27Sept18 1:31PM
		//$vu1=explode('/',$value->issue_date);
		//$vu=$vu1[1].'/'.$vu1[0].'/'.$vu1[2];
?>
<tr>
	<td data-title="Sr." ><?=$sr;?></td>	


    <td data-title="Image" >
		<img src="<?php
        if($value->photo!='')
		{
			echo base_url().'core/'.$value->photo;
		}
		else
		{
			echo imageurl($value->photo,'avatar');
		}
		?>" height="64px" width="64px"></td>

    <?php  
		if($value->cmp_name!='')
		{
	?>
			<td data-title="Used By" ><?php echo $value->cmp_name;?></td>
   <?php
		}
		else
		{
	?>
			<td data-title="Used By" ><?php echo $value->name;?></td>
	<?php
		}
	?>
	<td data-title="User Type" ><?php echo $value->user_type;?></td>
	<td data-title="Code" ><?php echo $value->coupon_id;?></td>
	<td data-title="Product" ><?php echo $value->product_name;?></td>	
	<td data-title="Points" ><?php echo $value->points;?></td>
	<!--VaibhavG added new date format for ticket number SMC-3486 27Sept18 1:31PM-->
	<td data-title="Date" ><?php echo $value->issue_date;?></td>	
</tr>
<?php 
$sr++;
endforeach;
 ?>		

</tbody>
</table></div></div>
	</div>
	
