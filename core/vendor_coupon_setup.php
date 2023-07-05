<?php
@include 'sponsor_header.php';

$user_id=$_SESSION['id'];
$entity=$_SESSION['entity'];
if($entity!=4){
	
	header("Location:login.php");
}

$img="";
$saving="";
$msg="";
$t=0;
if(isset($_GET['up'])){ 
	$up=$_GET['up'];
	$to_edit=mysql_query("SELECT * FROM tbl_sponsored WHERE `id`= $up ");
	$edit=mysql_fetch_array($to_edit);
	$Sponser_product=$edit['Sponser_product'];
	$points_per_product=$edit['points_per_product'];
	$sponsered_date=$edit['sponsered_date'];
	$valid_until=$edit['valid_until'];
	$product_image=$edit['product_image'];

	$product_price=$edit['product_price'];
	$discount=$edit['discount'];
	$buy=$edit['buy'];
	$get=$edit['get'];
	$saving=$edit['saving'];
	$offer_description=$edit['offer_description'];
	
	$daily_limit=$edit['daily_limit'];
	
	$total_coupons=$edit['total_coupons'];
	$curren=$edit['currency'];
	$cat=$edit['category'];
	$uniquecode=$edit['coupon_code_ifunique'];
	$cat1=mysql_query("SELECT `category` FROM `categories` WHERE `id`= $cat ");
	$cat2=mysql_fetch_array($cat1);
	$category=$cat2['category'];
	$img=$product_image;
}


if(isset($_GET['im'])){ 
				$imgetid = $_GET['im'];
				if( $imgetid != 'skipped'){
					$im1=mysql_query("SELECT product_image FROM tbl_sponsored WHERE `id`=$imgetid");
					$im=mysql_fetch_array($im1);
					$img=$im['product_image'];
				}
				
			
}
if(isset($_POST['submit'])){

		$cat=$_POST['product_type'];
	
		$pro_name=$_POST['name'];
	
		$startdate=$_POST['startdate'];
	
		$enddate=$_POST['enddate'];
		
		$currency=$_POST['currency'];
		
		$price=$_POST['price'];
		if($price < 0){
			$msg="Please Enter Valid Price";			
		}
		$points=$_POST['points'];
		if($points < 0){
			$msg="Please Enter Valid Number of Purchase Points";				
		}
		$discount=$_POST['discount'];
		if($discount < 0 or $discount > 100){
			$msg="Please Enter Valid Discount%";				
		}
		$buy=$_POST['buy'];
		if($buy < 0){
			$msg="Please Enter Valid Buy Value";
			
		}
		$buy_get=$_POST['buy_get'];
		if($buy_get < 0){
			$msg="Please Enter Valid Get Value";	
			
		}
		$limit_value=$_POST['limit_value'];
		if($limit_value < 0){
			$msg="Please Enter Valid Daily Limit Value";	
		}
		$total_coupons=$_POST['total_coupons'];
		if($total_coupons < 0){
			$msg="Please Enter Valid Number of Coupons";	
			
		}
		$uniquecode=$_POST['uniquecode'];
		
		
		if(empty($uniquecode)){
			$uniquecode=0;			
		}
		
		//after daily limit feature is enabled comment the line given below
	
		if(!empty($price) && !empty($discount)){ $saving=$price*($discount/100); } // if price an discount set then calculate saving 
		if(!empty($buy) && !empty($buy_get)){ $saving=$buy_get*$price; } 
		$today = date ("m/d/Y", time());
 			if(empty($limit_value)){ $limit_value='unlimited'; $daily_counter='unlimited';
			}else{ $daily_counter=$limit_value;}
			if(empty($total_coupons)){ $total_coupons='unlimited'; }
			
				
			if(!$_POST['discount']){ $sponsor_type='Product'; }
			
			$offerdes = htmlentities($_POST['offer_description']);

if(empty($saving)){ $saving='NULL'; }


if($msg ==""){	
$imgetid = $_GET['im'];		
if($imgetid != 'skipped'){
	if(isset($_GET['up'])){
$sql=mysql_query("UPDATE `tbl_sponsored` SET `Sponser_type`=\"$sponsor_type\",`Sponser_product`=\"$pro_name\",`school_id`='0',`points_per_product`=\"$points\",`sponsered_date`=\"$startdate\",`valid_no_of_student`='0',`validity`='valid',`sponsor_id`=\"$user_id\",`valid_until`=\"$enddate\",`category`=\"$cat\",`product_price`=\"$price\",`discount`=\"$discount\",`buy`=\"$buy\",`get`=\"$buy_get\",`saving`=\"$saving\",`offer_description`=\"$offerdes\",`daily_limit`=\"$limit_value\",`total_coupons`=\"$total_coupons\",`priority`='0',`coupon_code_ifunique`='0',`currency`=\"$currency\", `coupon_code_ifunique`=\"$uniquecode\",`daily_counter`=\"$daily_counter\", `reset_date`=\"$today\" WHERE `id`=\"$up\"");
	}else{
		$sql=mysql_query("UPDATE `tbl_sponsored` SET `Sponser_type`=\"$sponsor_type\",`Sponser_product`=\"$pro_name\",`school_id`='0',`points_per_product`=\"$points\",`sponsered_date`=\"$startdate\",`valid_no_of_student`='0',`validity`='valid',`sponsor_id`=\"$user_id\",`valid_until`=\"$enddate\",`category`=\"$cat\",`product_price`=\"$price\",`discount`=\"$discount\",`buy`=\"$buy\",`get`=\"$buy_get\",`saving`=\"$saving\",`offer_description`=\"$offerdes\",`daily_limit`=\"$limit_value\",`total_coupons`=\"$total_coupons\",`priority`='0',`coupon_code_ifunique`='0',`currency`=\"$currency\",`coupon_code_ifunique`=\"$uniquecode\",`daily_counter`=\"$daily_counter\", `reset_date`=\"$today\" WHERE `id`=\"$imgetid\"");		
	}
}
if($imgetid == 'skipped'){
		if(isset($_GET['up'])){
$sql=mysql_query("UPDATE `tbl_sponsored` SET `Sponser_type`=\"$sponsor_type\",`Sponser_product`=\"$pro_name\",`school_id`='0',`points_per_product`=\"$points\",`sponsered_date`=\"$startdate\",`valid_no_of_student`='0',`validity`='valid',`sponsor_id`=\"$user_id\",`valid_until`=\"$enddate\",`category`=\"$cat\",`product_price`=\"$price\",`discount`=\"$discount\",`buy`=\"$buy\",`get`=\"$buy_get\",`saving`=\"$saving\",`offer_description`=\"$offerdes\",`daily_limit`=\"$limit_value\",`total_coupons`=\"$total_coupons\",`priority`='0',`coupon_code_ifunique`='0',`currency`=\"$currency\", `coupon_code_ifunique`=\"$uniquecode\",`daily_counter`=\"$daily_counter\", `reset_date`=\"$today\" WHERE `id`=\"$up\"");
	}else{
$sql=mysql_query("INSERT INTO `smartcookies`.`tbl_sponsored` (`id`, `Sponser_type`, `Sponser_product`, `school_id`, `points_per_product`, `sponsered_date`, `valid_no_of_student`, `validity`, `sponsor_id`, `product_image`, `valid_until`, `category`, `product_price`, `discount`, `buy`, `get`, `saving`, `offer_description`, `daily_limit`, `total_coupons`, `priority`, `coupon_code_ifunique`, `currency`, `daily_counter`,`reset_date`) VALUES (NULL, \"$sponsor_type\", \"$pro_name\", '0', \"$points\", \"$startdate\", '0', 'valid', \"$user_id\", NULL, \"$enddate\", \"$cat\", \"$price\", \"$discount\", \"$buy\", \"$buy_get\", \"$saving\", \"$offerdes\", \"$limit_value\", \"$total_coupons\", '0', \"$uniquecode\", \"$currency\", daily_counter, $today) ");
 //`reset_counter_flag`,  NULL, 
$insid=mysql_insert_id();	
	}
}


if($imgetid != 'skipped'){ $insid=$imgetid; }
if(isset($_GET['up'])){ $insid=$up; }

if($sql){
			header("Location:vendor_generated_coupon.php?ins=".$insid);
		}
}
		
}

?>

<script>

  $(function() {
    $( "#startdate" ).datepicker();
  });
  
    $(function() {
    $( "#enddate" ).datepicker();
  });
  
 </script>



<script>
	   function valid()  
       {
		  

			regx1=/^[A-z ]+$/;
			regx2=/^[0-9 .]+$/;
		  
 
			var val=$("#cat").val();

			var obj=$("#product_type").find("option[value='"+val+"']")
			if(val==null||val=="") 
			{
		    document.getElementById('errorproduct_type').innerHTML='Enter Product Category';
				
				return false;
			}
			else
			{
				document.getElementById('errorproduct_type').innerHTML="";
			}
			

			if(!regx2.test(val))
		   {
				document.getElementById('errorproduct_type').innerHTML='Please enter valid Product Category';
					return false;
		   }
		   else
			{
				document.getElementById('errorproduct_type').innerHTML="";
			}
			
			
			
			
			var product_name=document.getElementById("name").value; 
		   if(product_name == null || product_name == " ") 
		   {
		    document.getElementById('errorname').innerHTML='Enter Product Name';
				
				return false;
			}
			
			
			 if(!regx1.test(product_name))
		   {
				document.getElementById('errorname').innerHTML='Enter Valid Product Name';
					return false;
		   }
		   else
			{
				document.getElementById('errorname').innerHTML="";
			}

		    var startdate  = document.getElementById("startdate").value;
			var enddate  = document.getElementById("enddate").value;
			if (startdate == null || startdate == "")
			{
				
				document.getElementById('errordate').innerHTML='Please enter Start Date';
				return false;
			}
			else
			{
				document.getElementById('errordate').innerHTML="";
			}
			
			
				if (enddate == null || enddate == " ")
			{
			
				document.getElementById('errorenddate').innerHTML='Please enter End Date';
				return false;
			}			
			else
			{
				document.getElementById('errorenddate').innerHTML="";
			}
			
			if ((Date.parse(enddate) <= Date.parse(startdate))) {

			document.getElementById('errorenddate').innerHTML='End date should be greater than Start date';
			return false;   
			}
			else
			{
				document.getElementById('errorenddate').innerHTML='';
			}
			
				var CurrentDate = new Date();




			
			var mrp=document.getElementById("price").value;
			 if (mrp == null || mrp == " ")
			{
		      
				document.getElementById('errormrp').innerHTML='Please enter Product Price';
				return false;
			}
			
			 if(!regx2.test(mrp))
		   {
				document.getElementById('errormrp').innerHTML='Please enter valid Product price';
					return false;
		   }
		   else
			{
				document.getElementById('errormrp').innerHTML="";
			}
			
			
			var mrp=document.getElementById("points").value;
			 if (mrp == null || mrp == " ")
			{
		      
				document.getElementById('errorpoints').innerHTML='Please enter Purchase Points';
				return false;
			}
			
			 if(!regx2.test(mrp))
		   {
				document.getElementById('errorpoints').innerHTML='Please enter valid Purchase Points';
					return false;
		   }
		   else
			{
				document.getElementById('errorpoints').innerHTML="";
			}
		
}
</script>
<script>

$(document).ready(function(){
	$("#d").hide();
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
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})</script>
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <div class="container-fluid" style="padding-top:5px;"> 

                  <div class="panel panel-default" > 
					<div class="panel-heading">                
                      <h2 class="panel-title"><b>Sponsor Coupon Setup</b></h2>
					</div>
					  <div class="panel-body">
						<div class="col-md-12">
						<div class="row">
                       
                       <form class="form" method="post" id="uploadimage" >
                       <?php if(isset($_GET['im'])  or isset($_GET['up'])){ ?>
					   <div class="col-sm-6" style="padding-top:5px;">
						<div class="form-group" >
                            <label for="product_type">Product Category: </label>
                           
					      <select class="form-control cat-sel-opt input-sm" id="cat" name="product_type" > 
                         <option>Select Category</option>
						  <?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 
						while($cats=mysql_fetch_array($catfromtbl)){
							$cat_id=$cats['id'];
							$cat_cat=$cats['category'];
							?>
                         <option value="<?php echo $cat_id; ?>" <?php if(isset($_GET['up']) && ($cat==$cat_id)){ echo "selected"; } ?> ><?php echo $cat_cat; ?></option>
						<?php } ?>  
                       
						</select>
							<div  id="errorproduct_type" style="color:#FF0000" align="center"></div>
                          </div>
                          <div class="form-group">
                            <label for="name">Product Name:</label>
                            <input class='form-control  input-sm' id='name' name="name" ng-model="name" placeholder='Product Name' type='text' 
							value="<?php if(isset($_POST['name']) or isset($_GET['up'])){
											if(isset($_POST['name'])){
												$Sponser_product= $_POST['name'];
											}
												echo $Sponser_product; 
										}     ?> " />
							<div  id="errorname" style="color:#FF0000" align="center"></div>
						  </div>
						       
						  <div class="form-group">
                            <label for="startdate">Start Date:</label>
                            <input  type="text" class='form-control input-sm' placeholder="Start Date" name="startdate" id="startdate" 
							value="<?php if(isset($_POST['startdate']) or isset($_GET['up'])){ 
														if(isset($_POST['startdate'])){ 
														$sponsered_date=$_POST['startdate'];
														} 
														echo $sponsered_date; 
										} ?>"/>
							<div  id="errordate" style="color:#FF0000" align="center"></div>
						  </div>
						    <div class="form-group">
                            <label for="enddate">Valid Until:</label>
                            <input  type="text" class='form-control input-sm' placeholder="End Date" name="enddate" id="enddate" 
							value="<?php if(isset($_POST['enddate']) or isset($_GET['up'])){
											if(isset($_POST['enddate'])){
											$valid_until=$_POST['enddate'];
											} 
											echo $valid_until; 
										} ?> "/>
							<div id="errorenddate" style="color:#FF0000" align="center"></div>
                          </div>
						    <div class="form-group form-inline">
                            <label for="price">Product MRP:&nbsp;&nbsp;&nbsp;</label>
							<select class="form-control cat-sel-opt  input-sm" id="cat" name="currency" > 
										<option>Currency</option>
							  <?php $currencies=mysql_query("SELECT * FROM `currencies`"); 
						while($currency=mysql_fetch_array($currencies)){
							$curr_id=$currency['id'];
							$curr=$currency['currency'];
							?>
                         <option value="<?php echo $curr_id; ?>" <?php if(isset($_GET['up']) && ($curren==$curr_id)){ echo "selected"; } ?> ><?php echo $curr; ?></option>
						<?php } ?> 
							
							<input class='form-control input-sm' id='price' name="price"  type='number' 
							value="<?php if(isset($_POST['price']) or isset($_GET['up'])){
								if(isset($_POST['price'])){
									$product_price=$_POST['price'];
								} 
									echo $product_price; 
								} ?>" />
							<div  id="errormrp" style="color:#FF0000" align="center"></div>
                          </div>
						  <div class="form-group" >
                            <label for="points">Coupon Purchase Points: </label>
                            <input class='form-control input-sm' id='points' name="points" placeholder='Coupon points' onkeyup="checkPoints()" type='number' value="<?php if(isset($_POST['points']) or isset($_GET['up'])){
									if(isset($_POST['points'])){
									$points_per_product=$_POST['points'];
									}
									echo $points_per_product; 
									} ?>" />
							<div  id="errorpoints" style="color:#FF0000" align="center"></div>
							
                          </div>
						  
					
						  <div class="form-group" id="offer">
						     <label >Offer:</label>
							 
                             <input type="button" class="btn btn-default btn-sm" value="Discount" id="show1" /> or 
							 <input type="button" class="btn btn-default btn-sm" value="Buy-Get" id="show2" />
                          </div>
						  
						  <div class="form-group form-inline" id="d">
                            <label for="discount">Discount:&nbsp;<input class='form-control input-sm' id='discount' name="discount" placeholder='Discount%' type='number' 
							value="<?php if(isset($_POST['discount']) or isset($_GET['up'])){
								if(isset($_POST['discount'])){
								$discount=$_POST['discount'];
								} 								
								echo $discount; } ?>"  
							onblur="return valid_discount()" />&nbsp;%.</label>
                          </div>
                          <div class="form-group form-inline" id="bg">
                            <label for="buy"> Or Buy &nbsp;</label><input type="number" class='form-control input-sm' style="width:100px;" 
							value="<?php if(isset($_POST['buy']) or isset($_GET['up'])){
												if(isset($_POST['buy'])){
												$buy=$_POST['buy'];
												}								
													echo $buy; } ?>"
							name="buy" />
							<label for="buy_get">&nbsp; Get&nbsp; <input type="number" class='form-control input-sm' style="width:100px;"
							value="<?php if(isset($_POST['buy_get']) or isset($_GET['up'])){
												if(isset($_POST['buy_get'])){
												$get=$_POST['buy_get'];
												} 
												 echo $get; } ?>"
							name="buy_get" />&nbsp; Free.</label>
							<div  id="errordorbg" style="color:#FF0000;" align="center"></div>
                          </div>
						
                          <div class="form-group">
                            <label for="offer_description">Offer Description:</label>
                            <textarea name="offer_description" class="form-control input-sm" rows="3" placeholder="Offer Description"><?php if(isset($_POST['offer_description']) or isset($_GET['up'])){ if(isset($_POST['offer_description'])){$offer_description=$_POST['offer_description']; } echo $offer_description;} ?></textarea>
						  </div>

                          <div class="form-group  form-inline">
                            <label > Limitation for daily accepting coupons:</label>
                            <div id="unlimited"><button type="button" name="unlimited" class="btn btn-default btn-sm"  id="show4">Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="limited"><input class='form-control input-sm' style="margin-top:10px;" id='limit_value' name="limit_value" placeholder='Limitation' type='number' 
							value="<?php if(isset($_POST['limit_value']) or isset($_GET['up'])){
										if(isset($_POST['limit_value'])){
										$daily_limit=$_POST['limit_value'];
										} 								
								echo $daily_limit; } ?>" /></div>
						  </div>   

                           <div class="form-group form-inline">
                            <label > Similar coupons to generate:</label>
                            <div id="unlimited1"><button type="button" name="unlimited1" class="btn btn-default  btn-sm" id="show5" >Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="limited1"><input class='form-control input-sm' style="margin-top:10px;" id='total_coupons' name="total_coupons" placeholder='No.Of Coupons' type='number'  
							value="<?php if(isset($_POST['total_coupons']) or isset($_GET['up'])){
										if(isset($_POST['total_coupons'])){
										$total_coupons=$_POST['total_coupons'];
										} 								
								echo $total_coupons;
								} ?>" /></div>
						  </div> 
						  <div class="form-group form-inline">
                            <label >Do want to Specify same Unique Code for all coupons:</label>
                            <div id="No"><button type="button" name="unique_code" class="btn btn-default btn-sm" id="show6" >No<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
							<div id="Yes"><input class='form-control input-sm' style="margin-top:10px;" type="text" id='uniquecode' name="uniquecode" 
							placeholder='Unique Code'  
							value="<?php if(isset($_POST['uniquecode']) or isset($_GET['up'])){ 
							if(isset($_POST['uniquecode'])){ 
							$uniquecode=$_POST['uniquecode']; 
							}							
							echo $uniquecode; 
							} ?>" /></div>
						  </div> 
						
						 
						</div>
						<?php } ?> 
						 <!-- right side start -->
                          <div class="col-sm-6" style="padding-top:5px;padding-left:40px;">
							<?php if(isset($_GET['im']) or isset($_GET['up'])){  ?>
                           <div class="form-group">
						  
                            <label>Product Image: </label>
								<div class="col-sm-12">
								<img src='<?php echo $img;  ?>' class="preview"  alt="product image" style="height:210px;" />
								</div>
								</div>  <?php } ?>                        
                          <div class="form-group" id="selectImage" style="padding-top:20px; margin-top:10px;">
						<!--	<a href="vendor_product_image.php"> -->
							<?php if(isset($_GET['im'])  or isset($_GET['up'])){  
							
							if(isset($_GET['up'])){
								
							?>
						
				<a href="vendor_product_image.php?up=<?php echo $up; ?>"><button type="button" class="btn btn-default btn-sm" style="margin-top:15px;">Change Product Image</button></a>
						<?php }else{ ?>
						
						<a href="vendor_product_image.php"><button type="button" class="btn btn-default" style="margin-top:15px;">Change Product Image</button></a>
						
				<?php	} }else{ ?> 

<a href="vendor_product_image.php"><button type="button" class="btn btn-default btn-sm" style="margin-top:15px;">Upload Product Image First</button></a>	
				<a href="vendor_coupon_setup.php?im=skipped"><button type="button" class="btn btn-default btn-sm" style="margin-top:15px;">Skip it! </button></a>				
                            <?php } ?>  
                          </div>

          
                <p style="size:18px;"></p>
            
          </div>

                          
                          </div>  
						  <div class="row">
						  <?php if(isset($_GET['im'])  or isset($_GET['up'])){  ?>
                           <div class="col-md-12" style="padding-top:10px; padding-bottom:30px;">
							<div class="row"><?php if(!empty($msg)){ ?> <div class="alert alert-warning" role="alert"><?php echo $msg; ?></div><?php } ?></div>
							
                             <input type="submit" name="submit" class="btn btn-success btn-sm" value="Submit" onClick="return valid()" /> 
                             <a href="vendor_generated_coupons.php"><button type="button" class="btn btn-danger btn-sm">CANCEL</button></a> 
                           </div>     
						  <?php } ?>	
                        </form>  
                        </div> 
                        <div class="clearfix"></div>        
                      </div>   
                  </div>
          </div> </div>
      
	</html>



