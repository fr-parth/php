<style>
.row{
	padding-top:5px;
}
</style>
<script type="text/javascript">
// Ajax post
$(document).ready(function() {
	$("#sccodebtn").click(function(event) {
	event.preventDefault();
	var coupon_id = $("input#sccode").val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/accept_sc_coupon_display",
			dataType: 'text',
			data: { cpid: coupon_id },
			success: function(res) {
				if (res)
				{
					//	alert(res);
					obj = JSON && JSON.parse(res) || $.parseJSON(res);

					if(obj.responseStatus==204){
						alert("Coupon Not Found");
	document.getElementById("couponid").innerHTML="";
	document.getElementById("amount").innerHTML="";
	document.getElementById("name").innerHTML="";
	document.getElementById("school_name").innerHTML="";
	document.getElementById("photo").innerHTML="";
	
	
					}else if(obj.responseStatus==1000){
						alert("Please Enter Coupon Code");
	document.getElementById("couponid").innerHTML="";
	document.getElementById("amount").innerHTML="";
	document.getElementById("name").innerHTML="";
	document.getElementById("school_name").innerHTML="";
	document.getElementById("photo").innerHTML="";

					}else{					
					
	document.getElementById("couponid").innerHTML=coupon_id;
	document.getElementById("amount").innerHTML=obj.posts.data[0].amount;
	document.getElementById("name").innerHTML=obj.posts.data[0].name;
	document.getElementById("school_name").innerHTML=obj.posts.data[0].school_name;
	if(obj.posts.data[0].photo==""){
		document.getElementById("photo").innerHTML="";
	}else{
		document.getElementById("photo").innerHTML="<img src='"+"<?php echo base_url(); ?>/core/"+obj.posts.data[0].photo+"' height='75px' width='75px'> ";
	}		}
				}
			}
		});
	});
});
</script>
<script>
function productSelected(){	
	
		var id=document.getElementById("product_name").value;	
		
		if(id!="select"){
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/getProduct",
			dataType: 'text',
			data: { cid: id },
			success: function(res) {
				if (res)
				{
				//alert(res);
					objp = JSON && JSON.parse(res) || $.parseJSON(res);
					document.getElementById("propoints").value=objp.product[0].points_per_product;
					document.getElementById("prodisc").value=objp.product[0].discount;	
					
					document.getElementById("discpoints").value="";
					document.getElementById("discount_name").value="select";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
				
				}
			}
		});	
		}else{			
					document.getElementById("discpoints").value="";
					document.getElementById("discount_name").value="select";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
					document.getElementById("product_name").value="select";
					document.getElementById("propoints").value="";
					document.getElementById("prodisc").value="";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
		}
}
		
</script>

<script>
function discountSelected(){	

	var id=document.getElementById("discount_name").value;	
	
	if(id!='select'){	
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/getProduct",
			dataType: 'text',
			data: { cid: id },
			success: function(res) {
				if (res)
				{
				//alert(res);
					objp = JSON && JSON.parse(res) || $.parseJSON(res);
					document.getElementById("discpoints").value=objp.product[0].points_per_product;		
					
					
					document.getElementById("product_name").value="select";
					document.getElementById("propoints").value="";
					document.getElementById("prodisc").value="";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
				}
			}
		});	
		}else{
					document.getElementById("discpoints").value="";
					document.getElementById("discount_name").value="select";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
					document.getElementById("product_name").value="select";
					document.getElementById("propoints").value="";
					document.getElementById("prodisc").value="";
					document.getElementById("note").value="";
					document.getElementById("miscpoints").value="";
		}
}
	
</script>
<script>
function miscSelected(){
	var note=document.getElementById("note").value;
	var miscpoints=document.getElementById("miscpoints").value;
	
	if(note==""){
		alert("Enter Miscellaneous");
		return false;
	}
	
	if(miscpoints<=0){
		alert("Enter Valid Points");
		return false;
	}
			document.getElementById("product_name").value="select";
			document.getElementById("propoints").value="";
			document.getElementById("prodisc").value="";
			document.getElementById("discpoints").value="";
			document.getElementById("discount_name").value="select";					
}
</script>
<script type="text/javascript">
// Ajax post
$(document).ready(function() {
	$("#accept").click(function(event) {		
	event.preventDefault();
	
	var sccode = $("input#sccode").val();
	var otype = $("input[name=otype]:checked").val();
	var product_name = $("#product_name").val();
	var prodisc = $("input#prodisc").val();
	var propoints = $("input#propoints").val();
	var discount_name = $("#discount_name").val();
	var discpoints = $("input#discpoints").val();
	var note = $("input#note").val();
	var miscpoints = $("input#miscpoints").val();
	
	var proname= $("#product_name option:selected").text();
	var discamt= $("#discount_name option:selected").text();
	
	var ok=true;
	
	if(sccode==""){
			alert("Enter Coupon Code");
			ok=false;
	}
	
	
	if(otype=="Product"){
		if(product_name=="select"){
			alert("Please Select A Product");
			ok=false;
		}
	}else if(otype=="Discount"){
		if(discount_name=="select"){
			alert("Please Select A Flat Discount");
			ok=false;
		}
	}else if(otype=="Miscellaneous"){

		if(note=="" || miscpoints==""){
			alert("Please Enter A Valid Miscellaneous");
			ok=false;
		}
		if(miscpoints<=0){
			alert("Enter Valid Points");
			ok=false;
		}
	}	
	
	if(ok){
/* 		alert("sccode"+sccode+"\n"+"otype"+otype+"\n"+"product_name"+product_name+"\n"+"prodisc"+prodisc+"\n"+"propoints"+propoints+"\n"+"discount_name"+discount_name+"\n"+"discpoints"+discpoints+"\n"+"note"+note+"\n"+"miscpoints"+miscpoints); */
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/accept_sc_coupon",
			dataType: 'text',
			data: { sccode: sccode, otype: otype, product_id: product_name, prodisc: prodisc, propoints: propoints, discount_id: discount_name, discpoints: discpoints, misc: note, miscpoints: miscpoints, proname:proname, discamt:discamt},
			success: function(res) {
				if (res)
				{
					//alert(res);
					obj = JSON && JSON.parse(res) || $.parseJSON(res);

					if(obj.responseStatus==204){
						alert("Not Enough Points Or Something Gone Wrong!");	
					}else if(obj.responseStatus==1000){
						alert("Invalid Input");
					}else{		
						document.getElementById("amount").innerHTML=obj.posts.data[0].amount;	
						alert("Successfully Accepted");
					}
				}
			}
		}); 
	}
	

	});
});
</script>	

	<div class="panel panel-violet">
	<div class="panel-heading">
		
		Accept Smartcookie Coupons
		
	</div>
	<div class="panel-body">
		<div class="col-md-12">		

			<div class="row">
				<form method="post" action="">
				<div class="col-md-4">
					<?php  echo "<b>".form_label('Enter Coupon Code:', 'code')."</b>"; ?>
				</div>
				<div class="col-md-8">	
					<div class="input-group">

		<?php 
		$data=array('type'=>'text', 'name'=>'sccode', 'id'=>'sccode','placeholder'=>'Search','class'=>'form-control','onmouseover'=>'this.focus()',
		'value'=>set_value('sccode') );
		echo form_input($data);
		?>
					<span class="input-group-btn">
<button class="btn btn-success" name="sccodebtn" id="sccodebtn" >Search</button>
					</span>	
					</div>
				</div>	
			</div>
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-10">

		<b><div class="row">Coupon Code#:&nbsp;<span id="couponid" style="font-weight:bold;" ></span></div>
		<div class="row">Balance Points:&nbsp;<span id="amount" style="font-weight:bold;" ></span> </div>
		<div class="row">Issued To:&nbsp;<span id="name" style="font-weight:bold;" ></span></div>
		<div class="row">Organization Name:&nbsp;<span id="school_name" style="font-weight:bold;" ></span></div></b>						
				</div>
				
				<div class="col-md-2">
						<div class="row">
							 <span id="photo"></span>
						</div>
				</div>
				</div>
			</div>
			<div class="panel-heading" style="color: #FFFFFF;background: #9351ad;border-color: #9351ad !important;">
		
		<b>Product, Discount, Miscellaneous </b>
		
	</div>
			<div class="row">
				<div class="col-md-12">
				

						  
						  
				<div class="row">
<div class="col-md-3">
	<b><input type="radio" name="otype" value="Product" checked style="font-weight:bold;"> Product</b>
</div>
<div class="col-md-3">
	<select name="coupon_used_for" class="form-control" id="product_name" onchange="productSelected();">
	<option value="select" selected="selected"> Select any one</option>	
		<?php foreach($product as $key =>$value){ 
		echo "<option value='".$product[$key]->id."'>".$product[$key]->Sponser_product."</option>";
		} ?>
	</select>
</div>
<div class="col-md-1">
<b>Discount</b>
</div>
<div class="col-md-2">
	<input name="prodisc" class="form-control" id="prodisc" placeholder="Discount" type="text" disabled>
</div>
<div class="col-md-1">
<b>Points</b>
</div>
<div class="col-md-2">
	<input name="propoints" class="form-control" id="propoints" placeholder="Points" type="text" disabled>
</div>
				
				</div>
					<hr/>
				<div class="row"  >
<div class="col-md-3">
	<b><input type="radio" name="otype" value="Discount"> Discount</b>
</div>		
						<div class="col-md-3">
	<select name="coupon_used_for" class="form-control" id="discount_name" onchange="discountSelected()">
		<option value="select" selected="selected">Select any one</option>
			<?php foreach($discount as $key =>$value){ 
						echo "<option value='".$discount[$key]->id."'>".$discount[$key]->Sponser_product."</option>";
					} ?>							
							</select>
						</div>	
						<div class="col-md-1">
						<b>Points</b>
						</div>
						<div class="col-md-2">
							<input name="discpoints" class="form-control" id="discpoints" placeholder="Points" type="text" disabled>
						</div>
			
				</div>
				<hr/>
				<div class="row" >
<div class="col-md-3">
	<b><input type="radio" name="otype" id="Miscellaneous" value="Miscellaneous"> Miscellaneous</b>
</div>				
						<div class="col-md-3">
							<input name="note" id="note" class="form-control" placeholder="Miscellaneous" type="text" >
						</div>	
						<div class="col-md-1">
						<b>Points</b>
						</div>
						<div class="col-md-2">
		<input name="miscpoints" class="form-control" id="miscpoints" placeholder="Points" type="number" onchange="miscSelected()" min="1">
						</div>
				
				</div>
				<div class="row">
						<div class="form-actions pll prl">
							<div class="col-md-6 col-md-offset-6 push-left">
								<button type="submit" name="accept" id="accept" class="btn btn-success">Accept</button>
								<a href="<?php echo base_url().'Csponsor'; ?>" style="text-decoration:none;">
								<button type="button" class="btn btn-warning">Cancel</button></a>
						</div>									
						</div>
						</div>
				</div>
				</form>
			</div>
				
		</div>
	</div>
	</div>
