<?php $this->load->view('sp/header'); ?>
<head>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
#image_preview{
  width: 100%;
  height: 100%;
  border: 1px solid #D9D9D9;
  height: 210px;
  max-width: 200px;
  overflow: hidden;
}
.image_preview1{
	max-width: 100%;
  position: relative;

}
</style>
<script>
	  		/*$( function() {
	   			$( "#startdate" ).datepicker({
	   				minDate: 0
	   			});
	  		});*/
	  	</script>
<script>
$(document).ready(function(){
	$("#d").show();
	$("#bg").hide();
	
	
    $("#show1").click(function(){
        $("#d").show();
		$("#bg").hide();
		
});
    $("#show2").click(function(){
        $("#d").hide();
		
		$("#bg").show();
		
    });

	
	  $("#limited").hide();
	 $("#show4").click(function(){
       $("#limited").toggle();
				
	});
	
	$("#limited1").hide();
	 $("#show5").click(function(){
       $("#limited1").toggle();
				
	});
	$("#Yes").hide();
	 $("#show6").click(function(){
       $("#Yes").toggle();
				
	});


});
</script>
<script>

  <!--$(function() {
   // $( "#startdate" ).datepicker();
  //});
  //dateFormat : 'yy-mm-dd' added for startdate & enddate for SMC-3622 by Pranali
  $( function() {
	   			$("#startdate").datepicker({
	   				dateFormat : 'yy-mm-dd',
					minDate: 0
	   			});
	  		});
  
    $(function() {
    $("#enddate").datepicker({
	   				dateFormat : 'yy-mm-dd'
	//changes end for SMC-3622
  });
  });
 </script>
 <script>
$(document).ready(function (e) {
// Function to preview image after validation
$(function() {
	$("#file").change(function() {
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
			$('#previewing').attr('src','noimage.png');
			$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
	});
});
function imageIsLoaded(e) {
	$("#file").css("color","green");
	$('#image_preview').css("display", "block");
	$('#previewing').attr('src', e.target.result);
	$('#previewing').attr('width', '250px');
	$('#previewing').attr('height', '230px');
};
});
</script>
<!--
<script  type= "text/JavaScript">

function validation()
{

var regex = /^[a-zA-Z]*$/;
var Name1=document.getElementById("name").value;
if(regex.test(Name1)==false || Name1=="")
{
	alert("please enter a valid  name");
	return false;
}
</script>-->
<?php 
$productUrl=@get_headers(base_url('/Assets/images/sp/productimage/'.$cdata->file_name));
if($productUrl[0] != 'HTTP/1.1 404 Not Found' && $cdata->file_name!='new-product.jpg' && $cdata->file_name!='' && !strpos($cdata->file_name,'resized_product_image')){
	$prodexist=base_url('/Assets/Images/sp/productimage/'.$cdata->file_name);
}else{
	$prodexist=base_url('/Assets/Images/sp/profile/imgnotavl.png');
}
// //echo base_url('/Assets/images/sp/productimage/'.$cdata->file_name);

?>
                  <div class="panel panel-violet" > 
					<div class="panel-heading">                
                     Sponsor Coupon Setup
					</div>
					  <div class="panel-body">
						<div class="col-md-12">
						<div class="row">
         
		 <?php $attributes1 = array('id' => 'uploadimage');
		 echo form_open_multipart('Csponsor/add_coupon', $attributes1); ?>                   
                  
					   <div class="col-sm-6" style="padding-top:5px;">
						<div class="form-group" >
                            <label for="product_type">Product Category: </label>
                         <select class="form-control input-sm" id="product_type" name="product_type" >
<!--value="" added in Select Category option by Pranali for bug SMC-3621-->
							<option value="">Select Category</option>
						 <?php foreach ($categories as $key => $value): ?>						 	
                       <option value="<?php echo $categories[$key]->id; ?>" <?php if(@$myData[0]->v_category==$categories[$key]->id){ echo 'selected';} ?> ><?php echo $categories[$key]->category; ?></option>						
                       		<?php endforeach; ?>
						</select>		
						<?php echo form_error('product_type', "<span style='color:red;' id='errorproduct_type' >", "</span>"); ?>
						</div>
					<!--changes end for SMC-3621 -->	
                          <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input class='form-control  input-sm' id='name'  name="name" ng-model="name" placeholder='Product Name' type='text' 
							value="<?php echo $cdata->name;?>" />
						
				<?php echo form_error('name', "<span style='color:red;' id='errorname' >", "</span>"); ?>
						  </div>
						   <div class="form-group">
                            <label for="startdate">Start Date:<small></small></label>
                <input  type="text" class='form-control input-sm' name="startdate" id="startdate" 
							value="<?php echo $cdata->startdate;?>" readonly = "readonly"/>
							
				<?php echo form_error('startdate', "<span style='color:red;' id='errordate' >", "</span>"); ?>			
						  </div>
						  
									
						
						    <div class="form-group">
							
                            <label for="enddate">Valid Until:<small></small></label>
                            <input  type="text" class='form-control input-sm' placeholder="End Date" name="enddate" id="enddate" 
							value="<?php echo $cdata->enddate; ?>"/>
							
				<?php echo form_error('enddate', "<span style='color:red;' id='errorenddate' >", "</span>"); ?>			
                          </div>
						    <div class="form-group form-inline">
                            <label for="price">Product MRP:&nbsp;&nbsp;&nbsp;</label>
							<select class="form-control input-sm" id="currency" name="currency" > 										  
						<?php foreach ($currencies as $key => $value): ?>						 	
					<option value="<?php echo $currencies[$key]->id; ?>" <?php if($cdata->currency==$currencies[$key]->id){ echo 'selected';} ?> ><?php echo $currencies[$key]->currency; ?></option>
					    <?php endforeach; ?>			
							</select>
							<input class='form-control input-sm' id='price' name="price"  type='number' 
							value="<?php echo $cdata->price;?>" min="0"  />
						
				<?php echo form_error('price', "<span style='color:red;' id='errormrp' >", "</span>"); ?>				
                          </div>
						  <div class="form-group" >
                            <label for="points">Coupon Purchase Points: </label>
                            <input class='form-control input-sm' id='points' name="points" placeholder='Coupon points' onkeyup="checkPoints()" type='number' value="<?php echo $cdata->points;?>" min="1"/>
							
				<?php echo form_error('points', "<span style='color:red;' id='errorpoints' >", "</span>"); ?>			
							
                          </div>
						  
					
						  <div class="form-group" id="offer">
						     <label >Offer:</label>
							 
                             <input type="button" class="btn btn-default btn-sm" value="Discount" id="show1" /> or 
							 <input type="button" class="btn btn-default btn-sm" value="Buy-Get" id="show2" />
                          </div>
						  
						  <div class="form-group form-inline" id="d">
                            <label for="discount">Discount:&nbsp;<input class='form-control input-sm' id='discount' name="discount" placeholder='Discount%' type='number' min="0"
							value="<?php echo $cdata->discount;?>"  onblur="return valid_discount()" />&nbsp;%.</label>
                          </div>
                          <div class="form-group form-inline" id="bg">
                            <label for="buy"> Or Buy &nbsp;</label><input type="number" class='form-control input-sm' style="width:100px;" value="<?php echo $cdata->buy;?>" name="buy" id="buy" min="0"/>
							<label for="buy_get">&nbsp; Get&nbsp; <input type="number" class='form-control input-sm' style="width:100px;"
							value="<?php echo $cdata->buy_get;?>"	name="buy_get" id="buy_get" min="0"/>&nbsp; Free.</label>
						</div>
						<?php echo form_error('discount', "<span style='color:red;' >", "</span>"); ?>
						<?php echo form_error('buy', "<span style='color:red;' >", "</span>"); ?>
						<?php echo form_error('buy_get', "<span style='color:red;' id='errordorbg' >", "</span>"); ?>
						
                          <div class="form-group">
                            <label for="offer_description">Offer Description:</label>
                            <textarea name="offer_description" class="form-control" rows="3" placeholder="Offer Description"><?php echo $cdata->offer_description;?></textarea>
						  </div>


						
						 
						</div>
			
						 <!-- right side start -->
			<div class="col-md-6 " style="padding-top:5px;padding-left:40px;">
			<div>
				<div id="image_preview">
				<img id="previewing" class="image_preview1"
				src="<?php echo $prodexist;?>" />				
				</div>
					<hr id="line">
					<div id="selectImage">
					<label>Select Product Image</label><br/>
				
					<input type="file" name="file" id="file" />
					<br/><small>Max Image Size 100KB, image Width X Height should be less than 1024 X 900 pixels.</small>
					<br/><span style='color:red;' ><?php echo $cdata->fileerror; ?></span>
					</div>
					
			</div>
			<br/>
                          <div class="form-group  form-inline">
                            <label > Limitation for daily accepting coupons:</label>
                            <div id="unlimited"><button type="button" name="unlimited" class="btn btn-default btn-sm"  id="show4">Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="limited"><input class='form-control input-sm' style="margin-top:10px;" id='daily_limit' name="daily_limit" placeholder='Limitation' type='number' min="1" 
							value="<?php echo $cdata->daily_limit;?>" /></div>
						  </div>   

                          <div class="form-group form-inline">
                            <label >Total coupons to generate:</label>
                            <div id="unlimited1"><button type="button" name="unlimited1" class="btn btn-default  btn-sm" id="show5" >Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="limited1"><input class='form-control input-sm' style="margin-top:10px;" id='total_coupons' name="total_coupons" placeholder='No.Of Coupons' type='number' min="1" 
							value="<?php echo $cdata->total_coupons;?>" /></div>
						  </div> 
						  <div class="form-group form-inline">
                            <label >Do you want to Specify same Unique Code for all coupons:</label>
                            <div id="No"><button type="button" name="unique_code" class="btn btn-default btn-sm" id="show6" >No<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="Yes"><input class='form-control input-sm' style="margin-top:10px;" type="text" id='uniquecode' name="uniquecode" 
							placeholder='Unique Code'  
							value="<?php echo $cdata->uniquecode;?>" /></div>
						  </div> 			
			</div>
			
                 </div>  
			<input type="hidden" name="proimg" id='proimg' value="<?php echo $cdata->file_name;?>">
			<input type="hidden" name="up" id='up' value="<?php echo $cdata->up;?>">
			
			<div class="row">
			<div class="col-md-12" style="padding-top:10px; padding-bottom:30px;">
				<span style='color:red;' ><?php echo $cdata->formerror; ?></span><br/>
				
				<input type="submit" name="submit" class="btn btn-success btn-sm"  value="Submit" > 
				<a href="<?=site_url('Csponsor/page/log_generated_coupons');?>"><button type="button" class="btn btn-danger btn-sm">Cancel</button></a> 
			</div>
			</form>  
			</div> 
                        <div class="clearfix"></div>        
                      </div>   
                  </div>
          </div>
		  </head>