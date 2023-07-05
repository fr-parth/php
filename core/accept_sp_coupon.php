<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>
<script type="text/javascript">

// Ajax post
$(document).ready(function() {
	$("#confirm").click(function(event) {
	event.preventDefault();
	var coupon_id = $("input#cpid").val();
	var school_id = $("input#scid").val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/accept_sp_coupon",
			dataType: 'text',
			data: { cpid: coupon_id, scid: school_id },
			success: function(res) {
				if (res)
				{
					alert(res);
					$("#confirm").attr('disabled','disabled');
				}
			}
		});
	});
});
</script>


<div class="panel panel-violet"  style="">
 <div class="panel-heading">
   Accept Sponsor Coupons
  </div>
  <div class="panel-body">

<div class="row">
<?php echo form_open('Csponsor/search_spcoupon_form'); ?>
<div class="col-md-4">
	<?php echo form_label('Enter Coupon Code:', 'code'); ?>
</div>
<div class="col-md-8">	
	<div class="input-group">
		<?php 
		$data=array('type'=>'text', 'name'=>'code', 'placeholder'=>'Search','class'=>'form-control',
		'value'=>set_value('code') );
		echo form_input($data);
		?>
	<span class="input-group-btn">
		<?php
		$data = array(
		'type' => 'submit',
		'value'=> 'Go!',
		'class'=> 'btn btn-success'
		);
		echo form_submit($data); ?>
	</span>	
	</div>
</div>
</form>
</div>



	  
  </div>
</div>
<?php echo validation_errors("<div class='alert alert-warning' role='alert'>", "</div>"); ?>

<?php 
//print_r($coupons);
if($coupons['rows']>0){
?>
<div class="panel panel-violet" align="center">
<div class="panel-body" >
<div class="table-responsive" id="no-more-tables">
<table class="table table-bordered table-striped table-condensed cf" id="myTable">
<thead class="cf">
		<tr>
			<th>#</th>
			<th>Image</th>
			<th>Coupon </th>
			<td></td>
		</tr>
	</thead>
	 <tbody>
<?php 
$sr=1;
$this->load->helper('imageurl');
	foreach($coupons['data'] as $key => $value){
		$dt=explode(' ',$coupons['data'][$key]->timestamp);
		$d=$dt[0];
		$dts=explode('-',$d);
//dd/mm/yyyy
		$tm=$dts[2].'/'.$dts[1].'/'.$dts[0];
		
		$vu1=explode('/',$coupons['data'][$key]->valid_until);
		$vu=$vu1[1].'/'.$vu1[0].'/'.$vu1[2];
		
?>
	  <tr>	  
	  <td data-title="Sr." ><?=$sr;?></td>	
	<td data-title="Image" ><img src="<?php echo imageurl($coupons['data'][$key]->photo,'avatar');?>" height="64px" width="64px"></td>
	
	  <td data-title="Info"><?php echo "Code# <b>".$coupons['data'][$key]->code."</b>"; ?><br/>
<?php echo "Product ID <b>".$coupons['data'][$key]->coupon_id.'-'.$coupons['data'][$key]->Sponser_product."</b>"; ?><br/>
	  <?php echo "Issued To <b>".$coupons['data'][$key]->name."</b>"; ?><br/>
	  <?php echo $coupons['data'][$key]->user_type." at ".$coupons['data'][$key]->school; ?><br/>
	  <?php echo "Selected On <b>".$tm."</b>"; ?> (DD/MM/YYYY)<br/>
	  <?php echo "Valid Until <b>".$vu."</b>"; ?> (DD/MM/YYYY)</td>
	<td>
<form method="post" action="#">
<input type="hidden" value="<?php echo $coupons['data'][$key]->id; ?>" name="cpid" id="cpid" >
<input type="hidden" value="<?php echo $coupons['data'][$key]->school_id; ?>" name="scid" id="scid" >
<button class="btn btn-success" name="confirm" id="confirm" <?php if($coupons['data'][$key]->used_flag=='used'){ echo 'disabled';}?>>Accept</button>
		</form>	  
	</td>
	 </tr>
	<?php $sr++; } ?>
	 </tbody>
	 </table>
</div>
</div> 	
</div>
	<?php  } ?>
