<?php $this->load->view('slp/header'); ?>
<?php error_reporting(0); ?>
<style type="text/css">   

	#main { border:1 px solid #CCCCCC; }
	.infoWindow { width: 220px; }
	
	 #map {
        height: 100%;
      }
	.list-group-item{
		padding-top:3px;
		padding-bottom:3px;
	}
</style>
	<script type="text/javascript">
		var centreGot = false;
	</script>
<?php echo $map['js']; ?>
<script type="text/javascript">
		function updateDatabase(newLat, newLng)
		{
			// make an ajax request to a PHP file
			// on our site that will update the database
			// pass in our lat/lng as parameters
			$.post(
				"<?php echo base_url(); ?>" + "/Csponsor/update_coords",
				{ 'newLat': newLat, 'newLng': newLng, 'var1': 'value1' }
			)
			.done(function(data) {
				alert(data);
			});
		}
</script>
<script>
$(document).ready(function(){
	
    $('#myTable').DataTable();
	
});
</script>

<div class="col-md-12">		
<div class="col-md-9">
	<div class="panel panel-violet">
	<div class="panel-heading">
		School &amp; Sponsor Map
	</div>
	<div class="panel-body">
	<!--	<div class="row">
			<div class="col-md-6">
			<b>Distance in km  </b>
				<select name="distance" id="distance" value="" type="text" onChange="return init()" style="width:100px;">
				<option value="2">2</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">50</option>
				<option value="100">100</option>
				<option value="200">200</option>
				<option value="300">300</option>
				</select>
			</div>
		</div>-->
		<div class="row" style="padding-top:10px;">
						<?php echo $map['html']; ?>
		</div>
		<!--
		<div class="row" style="padding-top:10px;">
				<span class='alert alert-warning'>Tip: If your location shown above is incorrect then drag the marker named 'S' to correct location</span>
		</div>-->
	</div>
	</div>
</div>

<div class="col-md-3">
	<div class="panel panel-violet">
		<div class="panel-heading">
			<div class='panel-title'>Local Sponsors</div>
		</div>
		<div class="panel-body"> 
			<div class="table-responsive" id="no-more-tables">
				<table class='table table-bordered table-striped table-condensed cf' id='myTable'>
				<thead>
				<tr><td></td></tr>
				</thead>
				<tbody>
					<?php foreach($location as $key => $value): 
								if($location[$key]->sp_company!=""){ ?>
					<tr><td title="<?=$location[$key]->sp_address;?>"><?=$location[$key]->sp_company;?></td></tr>
					<?php } endforeach; ?>	
				</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
</div>      
   

