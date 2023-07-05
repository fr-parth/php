<?php $this->load->view('sp/header'); ?>

<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>

<div class="panel panel-violet">
		<div class="panel-heading">
			Organization Wise Sponsor Coupon Usage
		</div>
		<div class="panel-body">
	<div class="table-responsive" id="no-more-tables">
	<table class="table table-bordered table-striped table-condensed cf" id="myTable" style="margin-left: 0px !important;">
	<thead class="cf">
			<tr>
			<!-- Camel Casing in email done by Pranali for bug SMC-2275 on 9-7-2018-->
				<th colspan="1" rowspan="2">Sr.No.</th>
				<th rowspan="2">Organization</th>
				<th rowspan="1" colspan="3">Student/Employee</th>
				<th rowspan="1" colspan="3">Teacher/Manager </th>
			</tr>
			<tr>
				<th>Total</th>
				<th>Used</th>
				<th>Unused</th>
				<th>Total</th>
				<th>Used</th>
				<th>Unused</th>
			</tr>
			</thead>
			<tbody>					
<?php 
$sr=1;

if($log_collegewise_sp_coupon_usage){
foreach ($log_collegewise_sp_coupon_usage as $key => $value): 
//print_r($value);
?>	
				<tr >
				<td data-title="SR." ><?=$sr;?></td>
				<td data-title="Institute" ><?=$value[0]->school;?><span class="badge"><?=$value[0]->school_count;?></span></td>
				<td data-title="Student/Employee Total" ><?=$value[0]->studs;?></td>
				<td data-title="Student/Employee Used" ><?=$value[0]->used_studs;?></td>
				<td data-title="Student/Employee Unused" ><?=$value[0]->unused_studs;?></td>
				<td data-title="Teacher/Employer Total" ><?=$value[0]->teachers;?></td>
				<td data-title="Teacher/Employer Used" ><?=$value[0]->used_teachers;?></td>
				<td data-title="Teacher/Employer Unused" ><?=$value[0]->unused_teachers;?></td>
				</tr>
<?php 
$sr++;
endforeach;
}
 ?>		

			</tbody>
	</table>
			</div>
		</div>
	</div>

