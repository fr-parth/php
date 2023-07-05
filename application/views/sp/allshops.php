<?php //print_r($user); ?>

<!DOCTYPE html>

<html lang="en">

<head><title>SmartCookie :: Sponsor</title>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!--Loading bootstrap css-->

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">

    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/font-awesome/css/font-awesome.min.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/bootstrap/css/bootstrap.min.css">

    <!--LOADING STYLESHEET FOR PAGE-->

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/intro.js/introjs.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/calendar/zabuto_calendar.min.css">

    <!--Loading style vendors-->

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/animate.css/animate.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-pace/pace.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/iCheck/skins/all.css">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-news-ticker/jquery.news-ticker.css">

    <!--Loading style-->

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/themes/style3/pink-blue.css" id="theme-change" class="style-change color-change">

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/style-responsive.css">

	 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/jquery.dataTables.css">

	 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/coupon_style.css">
	 
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

.panel {

    border: 0px solid #e5e5e5;

}

.form-control {

    border: 1px solid #e5e5e5;

}

.btn{

    border: 1px solid #e5e5e5;	

}

</style>

</head>

<body>

	<script src="<?php echo base_url(); ?>Assets/js/jquery-1.11.1.min.js"></script>

	<script src="<?php echo base_url(); ?>Assets/js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function(){

	if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(showPosition);

    } else { 

        x.innerHTML = "Geolocation is not supported by this browser.";

    }

});

function showPosition(position) {   

	document.getElementById("lat").value=position.coords.latitude;

	document.getElementById("lon").value=position.coords.longitude;

}

</script>

<div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>

<div>

	<!--BEGIN BACK TO TOP--><a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP-->

	<!--BEGIN TOPBAR-->

    <div id="header-topbar-option-demo" class="page-header-topbar">

        <nav id="topbar" role="navigation" style="" class="navbar navbar-default">

            <div class="navbar-header">                

                <a id="logo" href="#" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">SmartCookie</span></a></div>

            <div class="topbar-main">            

                <ul class="nav navbar navbar-top-links navbar-right mbn">                

                    <li class="dropdown topbar-user">

                        <a href="<?php echo site_url('Csponsor/logout'); ?>"><i class="fa fa-key"></i>Log Out</a>

                    </li>             

                </ul>

            </div>

        </nav>



    <!--END TOPBAR-->

<script>

$(document).ready(function(){

    $('#myTable1').DataTable();

});

</script>

<script>

function confirmation(xxx, shop){	

    var answer = confirm("Are you sure to delete "+shop+"?");

    if (answer){        

       // window.location = <?php echo base_url();?>+"/Csponsor/del/tbl_sponsored/"+xxx;

		/*var url ="<?php echo site_url('Allshops/del/'); ?>"+'/'+xxx;
		$.post(url,
			function(data)
				{
						alert(shop+" Deleted Success!");

				}
		);*/
		window.location ="<?php echo site_url('Allshops/del/'); ?>"+'/'+xxx;	
    }

    else{       

    }

}

</script>

<script>

$(document).ready(function(){

	$("#sp_country").change(function(){

		var cntr=$(this).val();

		jQuery.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>" + "Allshops/country_state",

			dataType: 'text',

			data: { country: cntr},

			success: function(res) {

				if (res)

				{

					//alert(res);

 					obj = JSON && JSON.parse(res) || $.parseJSON(res);

					$("#sp_state").empty();

					$("#sp_city").empty();

						$.each(obj, function () {

							$.each(this, function (name, value) {

								//console.log(name + '=' + value);

									$('#sp_state')

									 .append($("<option></option>")

									 .attr("value",value)

									 .text(value));

							});

						});				



				}

			}

		});

	});	

});

</script>

<script>

$(document).ready(function(){

	$("#sp_state").change(function(){

		var sp_state=$(this).val();

		var sp_country=$("#sp_country").val();

		jQuery.ajax({

			type: "POST",

			url: "<?php echo base_url(); ?>" + "Allshops/country_state_city",

			dataType: 'text',

			data: { country: sp_country, state: sp_state},

			success: function(res) {

				if (res)

				{

					//alert(res);

 					obj = JSON && JSON.parse(res) || $.parseJSON(res);

					$("#sp_city").empty();

						$.each(obj, function () {

							$.each(this, function (name, value) {

								//console.log(name + '=' + value);

									$('#sp_city')

									 .append($("<option></option>")

									 .attr("value",value)

									 .text(value));

							});

						});

				}

			}

		});

	});	

});

</script>

<script>

$(document).ready(function(){

	var disp=document.getElementById("disp").value;

	if(disp==0){

		$("#addsh").hide();

	}else{

		$("#addsh").show();

	}

	

	

	$("#p").click(function(){

        $("#addsh").toggle();		

	});

	//add code for hide div tag by VaibhavG for the ticket number SMC-3357 27Aug18 3:29PM
	$("#c").click(function(){

        $("#addsh").hide();		

	});
	
	
	//end code for the ticket number SMC-3357 27Aug18 3:29PM

});





</script>

<script>

function validate(){

	var sp_phone=document.getElementById("sp_phone").value;

	if(isNaN(sp_phone)){

		document.getElementById("err_sp_phone").innerHtml='Please Enter Valid Phone Number';

		return false;

	}else{

		document.getElementById("err_sp_phone").innerHtml='';

		return true;

	}

	

}

</script>

</head>

<body>

<style>

.required{

	color:#f00;

}

</style>

<div class="container-fluid">
	<!--
	Author VaibhavG
	Added success shop insertion & Already Exist Shop code for the ticket number SMC-3357 27Aug18 3:29PM
	-->
	<?php 
		if(!empty($success))
		{
	?>
	<div class="alert alert-success alert-dismissible fade in">
		<a href="#" id='c' class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<?php
			echo "<h4>$success</h4>";
	?>
	</div>
	<?php
		}
		elseif(!empty($AlreadyExist))
		{
	?>
	<div class="alert alert-danger alert-dismissible fade in">
		<a href="#" id='e' class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<?php
			echo "<h4>$AlreadyExist</h4>";
	?>
	</div>
	<?php
		}
	?>
	<!--code end for SMC-3357-->
<div class="panel panel-violet">

  <div class="panel-heading">

  Select Shop <span class="badge"><?=$total_shops;?></span>

  </div>

  <div class="panel-body">	

			<?php if ($this->session->flashdata('successdeleteshop')) { ?>
				<h3 style="color:green;">
					<?php echo $this->session->flashdata('successdeleteshop'); ?>
				</h3>
			<?php } ?>
			<?php if ($this->session->flashdata('errordeleteshop')) { ?>
				<h3 style="color:red;">
					<?php echo $this->session->flashdata('errordeleteshop'); ?>
				</h3>
			<?php } ?>

	<div class="table-responsive" id="no-more-tables">

	<table class="table table-bordered table-striped table-condensed cf" id="myTable1" style="margin-left: 0px !important;">

	<thead class="cf">
<!-- Camel Casing in email done by Pranali for bug SMC-2275 on 9-7-2018 -->
<tr><th>Sr.No.</th><th>Sponsor ID</th><th>Company Name</th><th>Sponsor Name</th><th>Mobile No.</th><th>Email</th><th>Address</th><th>City</th><th>Select</th><th>Delete</th></tr>

	</thead>

	<tbody>



<?php

$sr=1;

foreach($shops as $key => $value){
	
?>

<tr>

<td data-title="Sr." ><?=$sr;?></td>

<td data-title="Sponsor#" ><?='SP'.$shops[$key][0]->id;?></td>

<td data-title="Company" ><?=$shops[$key][0]->sp_company;?></td>

<td data-title="Company" ><?=$shops[$key][0]->sp_name;?></td>

<td data-title="Mobile" ><?=$shops[$key][0]->sp_phone;?></td>

<td data-title="Email" ><?=$shops[$key][0]->sp_email;?></td>

<td data-title="Address" ><?=$shops[$key][0]->sp_address;?></td>

<td data-title="City" ><?=$shops[$key][0]->sp_city;?></td>

<td data-title="Go" >

	<a href="<?php echo site_url('allshops/redir/'.$shops[$key][0]->id); ?>">

	<button class='btn btn-success'>Login Shop <span class="glyphicon glyphicon-circle-arrow-right glyphicon-lg" ></span></button>

	</a>

</td>

	<td data-title="Delete" >

<?php if($sr!=1){ ?>

		<a onclick="confirmation('<?=$shops[$key][0]->id;?>','<?=addslashes($shops[$key][0]->sp_company);?>')">

		<span class="glyphicon glyphicon-trash"></span></a>

<?php } ?>		

	</td>

</tr>

<?php

$sr++;

 } ?>

</tbody>

</table></div></div>

<div class='panel-footer'>

<button class="btn btn-violet" name="p" id="p">+ Add Shop</button>

</div>

	</div>

<div id='addsh'>	

<div class="panel panel-violet">

  <div class="panel-heading">

  Add New Shop

  </div>

  <div class="panel-body">	



	<div class="table-responsive" id="">

	

		 

	<?php 	

	//print_r($myData);

	$attributes = array('id' => 'add_shop');
	// VaibhavG added new date format to sp_date for ticket number SMC-3486 26Sept18 4:11PM
	$hidden = array('sp_email' =>  $myData->sp_email, 'sp_password' => $myData->sp_password, 'sp_date' =>CURRENT_TIMESTAMP, 'sp_img_path' => $myData->sp_img_path, 'owner_id'=>$myData->owner_id);
		 echo form_open('Allshops/add_shop', $attributes, $hidden); ?>

	

			<table class="table table-hover table-bordered table-striped table-condensed cf" >

			
			<tr>

				<td style="font-weight:bold;" >

					Sponsor Name <span class="required">*</span>

				</td>

				<td><input type="hidden" name="disp" id="disp" class="form-control" 

					value="<?=$disp; ?>" >

					<input type="text" name="sp_name" id="sp_name" class="form-control" 

					value="<?=$myData->sp_name; ?>"  >

			<?php echo form_error('sp_name', "<span style='color:red;' id='err_sp_company' >", "</span>"); ?>

				</td>

			</tr>



			<tr>

				<td style="font-weight:bold;" >

					Company Name <span class="required">*</span>

				</td>

				<td><input type="hidden" name="disp" id="disp" class="form-control" 

					value="<?=$disp; ?>" >

					<input type="text" name="sp_company" id="sp_company" class="form-control" 

					value="<?=$myData->sp_company; ?>"  >

			<?php echo form_error('sp_company', "<span style='color:red;' id='err_sp_company' >", "</span>"); ?>

				</td>

			</tr>

			

			<tr>

				<td style="font-weight:bold;" >

					Default Product Category <span class="required">*</span>

				</td>

				<td>

					<select class="form-control" id="v_category" name="v_category"  > 

						<option value=''>Select Category</option>

						 <?php foreach ($categories as $key => $value): ?>						 	

                       <option value="<?php echo $categories[$key]->id; ?>" <?php if($myData->v_category==$categories[$key]->id){ echo 'selected';} ?> ><?php echo $categories[$key]->category; ?></option>

					   <?php endforeach; ?>

					</select>

				</td>

			</tr>

			<tr>

				<td style="font-weight:bold;">

					Country Code <span class="required">*</span>

				</td>

				<td>

					<select name="country_code" id="country_code" class="form-control">
						<option value='91'>91</option>
						<option value='1' >1</option>
					</select>


				<?php echo form_error('country_code', "<span style='color:red;' id='err_sp_phone'>", "</span>"); ?>	

				</td>

			</tr>
			
			<tr>

				<td style="font-weight:bold;">

					Mobile Number <span class="required">*</span>

				</td>

				<td>

					<input type="text" name="sp_phone" id="sp_phone" class="form-control" value="<?=$myData->sp_phone; ?>">


				<?php echo form_error('sp_phone', "<span style='color:red;' id='err_sp_phone'>", "</span>"); ?>	

				</td>

			</tr>

			<tr>

				<td style="font-weight:bold;">

					Website

				</td>

				<td>

					<input type="text" name="sp_website" id="sp_website" class="form-control" 

					value="<?=$myData->sp_website; ?>" >

			

				<?php echo form_error('sp_website', "<span style='color:red;' id='sp_website' >", "</span>"); ?>	

				</td>

			</tr>



			<tr>

				<td style="font-weight:bold;">

					Address <span class="required">*</span>

				</td>

				<td class="text-capitalize">

					<textarea class="form-control custom-control" rows="3" name="sp_address" id="sp_address" style="resize:none"><?php if(uri_string()=='Allshops/add_shop'){ echo $myData->sp_address; } ?></textarea>

					<div class="row text-danger" align="center" id='err_address' ></div>

			<?php echo form_error('sp_address', "<span style='color:red;' id='err_address' >", "</span>"); ?>

				</td>

			</tr>

			<tr>

				<td style="font-weight:bold;">

					

				</td>

				<td class="text-capitalize">

					<?php //include 'country_state_city.form.inc.php'; ?>	

						<div class="row">							

						  <div class="col-md-4">

						  Country <span class="required">*</span>

							<select class="form-control" id="sp_country" name="sp_country"  >						
									<option value="">Please Select Your Country</option>
								<?php foreach ($countries as $key => $value): ?>						 	

								<option value="<?php echo $countries[$key]->country; ?>" <?php if($myData->sp_country==$countries[$key]->country){ echo 'selected';} ?> ><?php echo $countries[$key]->country; ?></option>

								<?php endforeach; ?>

							</select>	

							

						 </div> 

						 

							<div class="col-md-4">

							State <span class="required">*</span>

							<select class="form-control" id="sp_state" name="sp_state"  > 							
									
								<?php foreach ($states as $key => $value): ?>						 	

								<option value="<?php echo $states[$key]->state; ?>" <?php if($myData->sp_state==$states[$key]->state){ echo 'selected';} ?> ><?php echo $states[$key]->state; ?></option>

								<?php endforeach; ?>

							</select>							

							</div>

						   <div class="col-md-4">

						    City <span class="required">*</span>

							<select class="form-control" id="sp_city" name="sp_city"  >
								
								<?php foreach ($cities as $key => $value): ?>						 	

								<option value="<?php echo $cities[$key]->sub_district; ?>" <?php if($myData->sp_city==$cities[$key]->sub_district){ echo 'selected';} ?> ><?php echo $cities[$key]->sub_district; ?></option>

								<?php endforeach; ?>

							</select>

							</div>

						  </div>

				<?php echo form_error('sp_country', "<span style='color:red;' id='err_sp_country' >", "</span>"); ?>

				<?php echo form_error('sp_state', "<span style='color:red;' id='err_sp_state' >", "</span>"); ?>

				<?php echo form_error('sp_city', "<span style='color:red;' id='err_sp_city' >", "</span>"); ?>

						  <div class="clearfix"></div>

				</td>

			</tr>			

			<tr>

				<td style="font-weight:bold;">

					ZIP / PIN <span class="required">*</span>

				</td>

				<td class="text-capitalize">

					<input type="text" name="pin" id="pin" class="form-control" 

					value="<?php if(uri_string()=='Allshops/add_shop'){ echo $myData->pin;} ?>" onkeypress="return isNumberKey(event)" >					

				<?php echo form_error('pin', "<span style='color:red;' id='err_pin' >", "</span>"); ?>

				</td>

				<input type='hidden' id='lat' name='lat' value='' />

				<input type='hidden' id='lon' name='lon' value='' />

			</tr>			

			

			</table>	
			<!--commented by VaibhavG for the ticket number SMC-3357 27Aug18 3:29PM -->
			<span style='color:red;' ><?php //echo $AlreadyExist; ?></span><br/>

<input type="submit" name="submit" class="btn btn-success btn-sm" onclick="return validate()" value="Add Shop" />



</form>		

			</div></div>

	</div>	

	</div>

</div>

<div class='clearfix'></div>