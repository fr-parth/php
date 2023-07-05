<!--Created by Rutuja Jori & Sayali Balkawade(PHP Interns) for Bug SMC-3773 on 19/04/2019-->



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
 Membership Discount Log <span class="badge"><?=$count_membership_discount;?></span>
  </div>
  <div class="panel-body">		
	<div class="table-responsive" id="no-more-tables">
	<table class="table table-bordered table-striped table-condensed cf" id="myTable" style="margin-left: 0px !important;">
	<thead class="cf">
	<tr>

	<th>Sr.No.</th>
	<th>Image</th>
	<th>Used By</th>
	<th>User Type</th>
	<th>PRN/Employee ID</th>
	<th>Product Name</th>
	<th>Discount</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
<?php 

$sr=1;
foreach ($log_membership_discount as $key => $value): 

?>
<tr>
	<td data-title="Sr." ><?=$sr;?></td>	


    <td data-title="Image" >
		<img src="<?php
        if($value->photo!='')
		{
			//below if else added and default avatar image displayed by Pranali on 16-5-19
			if($value->Entity_name=='Student')
			echo base_url().'core/'.$value->photo;

			else
			echo base_url().'teacher_images/'.$value->photo;
		}
		else
		{
			echo base_url().'Assets/images/avatar/avatar_2x.png';
			//echo imageurl($value->photo,'avatar');
		}
		?>" height="64px" width="64px"></td>

    <?php  
		if($value->name!='')
		{
	?>
			<td data-title="Used By" ><?php echo $value->name;?></td>
   <?php
		}
		else
		{
	?>
			<td data-title="Used By" ><?php echo $value->name;?></td>
	<?php
		}
	?>
	<td data-title="User Type" ><?php echo $value->Entity_name;?></td>
	<td data-title="PRN/Employee ID" ><?php echo $value->prn_tid;?></td>
	<td data-title="Product Name" ><?php echo $value->product;?></td>	
	<td data-title="Discount" ><?php echo $value->discount;?></td>
	
	<td data-title="Date" ><?php echo $value->date;?></td>	
</tr>
<?php 
$sr++;
endforeach;
 ?>		

</tbody>
</table></div></div>
	</div>
	
