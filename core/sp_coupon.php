<?php
ob_start();
@include 'sponsor_header.php';
$user_id=$_SESSION['id'];
$entity=$_SESSION['entity'];

$Sponser_product="";
$sponsered_date="";
$valid_until="";
$product_price="";
$discount="";
$buy="";	
$buy_get="";	
$offer_description="";
$daily_limit="";
$total_coupons="";
$uniquecode="";
$msg="";
$points_per_product=0;
$product_image="";
$saving=0;
$currency=0;
$cat=0;
$up=0;
$img="";
$t=0;
$sponsor_type="";

if(isset($_GET['up'])){ 
	$up=$_GET['up'];
	$to_edit=mysql_query("SELECT * FROM tbl_sponsored WHERE `id`='$up' and `sponsor_id`='$user_id' ");
	$edit=mysql_fetch_array($to_edit);
	$Sponser_product=$edit['Sponser_product'];
	$points_per_product=$edit['points_per_product'];
	$sponsered_date=$edit['sponsered_date'];
	$valid_until=$edit['valid_until'];
	$product_image=$edit['product_image'];
	$product_price=$edit['product_price'];
	$discount=$edit['discount'];
	$buy=$edit['buy'];
	$buy_get=$edit['get'];
	$saving=$edit['saving'];
	$offer_description=$edit['offer_description'];	
	$daily_limit=$edit['daily_limit'];	
	$total_coupons=$edit['total_coupons'];
	$currency=$edit['currency'];
	$cat=$edit['category'];
	$uniquecode=$edit['coupon_code_ifunique'];	
}
function resizejpeg($dir, $newdir, $img, $max_w, $max_h, $th_w, $th_h){

	    // set destination directory
	    if (!$newdir) $newdir = $dir;

	    // get original images width and height
	    list($or_w, $or_h, $or_t) = getimagesize($dir.$img);

	    // make sure image is a jpeg
	    if ($or_t == 2) {

	        // obtain the image's ratio
			
	        $ratio = ($or_h / $or_w);

	        // original image
	        $or_image = imagecreatefromjpeg($dir.$img);

	        // resize image?
	        if ($or_w > $max_w || $or_h > $max_h) {

	            // resize by height, then width (height dominant)
	            if ($max_h < $max_w) {
	                $rs_h = $max_h;
	                $rs_w = $rs_h / $ratio;
	            }
	            // resize by width, then height (width dominant)
	            else {
	                $rs_w = $max_w;
	                $rs_h = $ratio * $rs_w;
	            }

	            // copy old image to new image
	            $rs_image = imagecreatetruecolor($rs_w, $rs_h);
	            imagecopyresampled($rs_image, $or_image, 0, 0, 0, 0, $rs_w, $rs_h, $or_w, $or_h);
	        }
	        // image requires no resizing
	        else {
	            $rs_w = $or_w;
	            $rs_h = $or_h;
	            $rs_image = $or_image;
	        }
	        // generate resized image
	        imagejpeg($rs_image, $newdir.$img, 100);
	        return true;
	    } 
	    else {
	        return false;
	    }
     }

if(isset($_POST['submit'])){

		$cat=$_POST['product_type'];
		
		$up=$_POST['up'];
		
		$pro_name=$_POST['name'];
	
		$startdate=$_POST['startdate'];
	
		$enddate=$_POST['enddate'];
		
		$currency=$_POST['currency'];
		$up=$_POST['up'];
		
		$price=$_POST['price'];
		if($price < 0){
			$msg="Please Enter Valid Price";			
		}
		$points_per_product=$_POST['points_per_product'];
		if($points_per_product < 0){
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
		$daily_limit=$_POST['daily_limit'];
		if($daily_limit < 0){
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
		
		if(isset($_FILES["file"]["type"]))
			{
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["file"]["name"]);
				$file_extension = end($temporary);
				if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
				) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
				&& in_array($file_extension, $validextensions)) {
			
					if ($_FILES["file"]["error"] > 0)
					{
					$msg="Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
					}
					else
					{
						if (file_exists("images/uploaded_product_image/" . $_FILES["file"]["name"])) {
							$msg=$_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
						}
						else
						{
							
							$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
							$targetPath = "images/uploaded_product_image/".$_FILES['file']['name']; // Target path where file is to be stored
							move_uploaded_file($sourcePath,$targetPath) ;	
							$img=$_FILES['file']['name'];
								$size    = 300;
								$dir =   'images/uploaded_product_image/';
								$newdir= 'images/resized_product_image/';
								$max_w = 208;
								$max_h = 140;
								$th_w = 100;
								$th_h = 100;
								if($_FILES["file"]["type"] == "image/jpeg"){
									resizejpeg($dir, $newdir, $img, $max_w, $max_h, $th_w, $th_h);
								}
									 
								
							// Moving Uploaded file
							//echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
							//echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
							//echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
							//echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
							//echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
							//echo "<b> file:</b> " . $newdir.$_FILES["file"]["name"] . "<br>";
							if(file_exists($newdir.$_FILES["file"]["name"])){
								$product_image=$newdir.$_FILES["file"]["name"];
							}else{
								$product_image=$dir.$_FILES["file"]["name"];
							}
							
						}
					}
				}
			}
		
		//after daily limit feature is enabled comment the line given below
	
		if(!empty($price) && !empty($discount)){ $saving=$price*($discount/100); } // if price an discount set then calculate saving 
		if(!empty($buy) && !empty($buy_get)){ $saving=$buy_get*$price; } 
		$today = date ("m/d/Y", time());
 			if(empty($daily_limit)){ $daily_limit='unlimited'; $daily_counter='unlimited';
			}else{ $daily_counter=$daily_limit;}
			if(empty($total_coupons)){ $total_coupons='unlimited'; }
			
				
			if(!$_POST['discount']){ $sponsor_type='Product'; }
			
			$offer_description = htmlentities($_POST['offer_description']);
		
		$product_price=$price;
		$valid_until=$enddate;	
		$sponsered_date=$startdate;
		$Sponser_product=$pro_name;
		if($_POST['proimg']!="" and $product_image==""){
				$product_image=$_POST['proimg'];
		}
if(empty($saving)){ $saving='NULL'; }
if($msg==""){
if($up!=0){
	$sql=mysql_query("UPDATE `tbl_sponsored` SET `Sponser_type`='$sponsor_type',`Sponser_product`='$pro_name',`school_id`='0',`points_per_product`='$points_per_product',`sponsered_date`='$startdate',`valid_no_of_student`='0',`validity`='valid',`sponsor_id`='$user_id',`valid_until`='$enddate',`category`='$cat',`product_price`='$price',`discount`='$discount',`buy`='$buy',`get`='$buy_get',`saving`='$saving',`offer_description`='$offer_description',`daily_limit`='$daily_limit',`total_coupons`='$total_coupons',`priority`='0',`coupon_code_ifunique`='0',`currency`='$currency', `coupon_code_ifunique`='$uniquecode',`daily_counter`='$daily_counter', `reset_date`='$today', `product_image`='$product_image' WHERE `id`='$up' and `sponsor_id`='$user_id'")or die(mysql_error());
	$insid=$up;
}else{
	$sql=mysql_query("INSERT INTO `tbl_sponsored` (`id`, `Sponser_type`, `Sponser_product`, `school_id`, `points_per_product`, `sponsered_date`, `valid_no_of_student`, `validity`, `sponsor_id`, `product_image`, `valid_until`, `category`, `product_price`, `discount`, `buy`, `get`, `saving`, `offer_description`, `daily_limit`, `total_coupons`, `priority`, `coupon_code_ifunique`, `currency`, `daily_counter`,`reset_date`) VALUES (NULL, '$sponsor_type', '$pro_name', '0', '$points_per_product', '$startdate', '0', 'valid', '$user_id', '$product_image', '$enddate', '$cat', '$price', '$discount', '$buy', '$buy_get', '$saving', '$offer_description', '$daily_limit', '$total_coupons', '0', '$uniquecode', '$currency', '$daily_counter', '$today') ")or die(mysql_error());
	$insid=mysql_insert_id();
}

if($sql){
			header("Location: vendor_generated_coupon.php?ins=$insid");
		}
}
}	 
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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
			
			
			var mrp=document.getElementById("points_per_product").value;
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


<div class="container-fluid" style="padding-top:5px;">
	<div class="panel panel-default" > 
	<div class="panel-heading">                
		<h2 class="panel-title"><b>Sponsor Coupon Setup</b></h2>
	</div>
	<div class="panel-body">
		<div class="col-md-12">
		<div class="row">
			<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
			<div class="col-sm-6" style="padding-top:5px;">
				<div class="form-group" >
				<label for="product_type">Product Category: </label>
				<select class="form-control cat-sel-opt input-sm" id="cat" name="product_type" > 				
				<?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 
				while($cats=mysql_fetch_array($catfromtbl)){
				$cat_id=$cats['id'];
				$cat_cat=$cats['category'];
				?>
				<option value="<?php echo $cat_id; ?>" <?php if($cat_id==$cat){ echo 'selected';} ?>><?php echo $cat_cat; ?></option>
				<?php } ?>  
				</select>
				<div  id="errorproduct_type" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group">
				<label for="name">Product Name:</label>
				<input class='form-control  input-sm' id='name' name="name" ng-model="name" placeholder='Product Name' type='text' 
				value="<?php echo $Sponser_product;  ?> " />
				<div  id="errorname" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group">
				<label for="startdate">Start Date:</label>
				<input  type="text" class='form-control input-sm' placeholder="Start Date" name="startdate" id="startdate" 
				value="<?php echo $sponsered_date; ?>"/>
				<div  id="errordate" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group">
				<label for="enddate">Valid Until:</label>
				<input  type="text" class='form-control input-sm' placeholder="End Date" name="enddate" id="enddate" 
				value="<?php echo $valid_until; ?> "/>
				<div id="errorenddate" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group form-inline">
				<label for="price">Product MRP:&nbsp;&nbsp;&nbsp;</label>
				<select class="form-control cat-sel-opt  input-sm" id="cat" name="currency" > 					
				<?php $currencies=mysql_query("SELECT * FROM `currencies`"); 
				while($currency=mysql_fetch_array($currencies)){
				$curr_id=$currency['id'];
				$curr=$currency['currency'];
				?>
				<option value="<?php echo $curr_id; ?>" <?php if($curr_id==$currency){ echo 'selected';} ?>><?php echo $curr; ?></option>
				<?php } ?> 
				<input class='form-control input-sm' id='price' name="price"  type='number' 
				value="<?php echo $product_price;  ?>" />
				<div  id="errormrp" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group" >
				<label for="points">Coupon Purchase Points: </label>
				<input class='form-control input-sm' id='points_per_product' name="points_per_product" placeholder='Coupon points' onkeyup="checkPoints()" type='number' value="<?php echo $points_per_product; ?>" />
				<div  id="errorpoints" style="color:#FF0000" align="center"></div>
				</div>
				
				<div class="form-group" id="offer">
				<label >Offer:</label>
				<input type="button" class="btn btn-default btn-sm" value="Discount" id="show1" /> or 
				<input type="button" class="btn btn-default btn-sm" value="Buy-Get" id="show2" />
				</div>
				
				<div class="form-group form-inline" id="d">
				<label for="discount">Discount:&nbsp;<input class='form-control input-sm' id='discount' name="discount" placeholder='Discount%' type='number' 
				value="<?php echo $discount; ?>"  
				onblur="return valid_discount()" />&nbsp;%.</label>
				</div>

				<div class="form-group form-inline" id="bg">
				<label for="buy"> Or Buy &nbsp;</label><input type="number" class='form-control input-sm' style="width:100px;" 
				value="<?php echo $buy; ?>"
				name="buy" />
				<label for="buy_get">&nbsp; Get&nbsp; <input type="number" class='form-control input-sm' style="width:100px;"
				value="<?php echo $buy_get; ?>"
				name="buy_get" />&nbsp; Free.</label>
				<div  id="errordorbg" style="color:#FF0000;" align="center"></div>
				</div>
				
				<div class="form-group">
				<label for="offer_description">Offer Description:</label>
				<textarea name="offer_description" class="form-control input-sm" rows="3" placeholder="Offer Description"><?php echo $offer_description; ?></textarea>
				</div>
				
				<div class="form-group  form-inline">
				<label > Limitation for daily accepting coupons:</label>
				<div id="unlimited"><button type="button" name="unlimited" class="btn btn-default btn-sm"  id="show4">Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
				<div id="limited"><input class='form-control input-sm' style="margin-top:10px;" id='daily_limit' name="daily_limit" placeholder='Limitation' type='number' 
				value="<?php echo $daily_limit; ?>" /></div>
				</div> 
				
				<div class="form-group form-inline">
				<label > Total coupons to generate:</label>
				<div id="unlimited1"><button type="button" name="unlimited1" class="btn btn-default  btn-sm" id="show5" >Unlimited <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
				<div id="limited1"><input class='form-control input-sm' style="margin-top:10px;" id='total_coupons' name="total_coupons" placeholder='No.Of Coupons' type='number'  
				value="<?php echo $total_coupons; ?>" /></div>
				</div>
				
				<div class="form-group form-inline">
				<label >Do want to Specify same Unique Code for all coupons:</label>
				<div id="No"><button type="button" name="unique_code" class="btn btn-default btn-sm" id="show6" >No<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></div>
				<div id="Yes"><input class='form-control input-sm' style="margin-top:10px;" type="text" id='uniquecode' name="uniquecode" 
				placeholder='Unique Code'  
				value="<?php echo $uniquecode; ?>" /></div>
				</div> 
			</div>
			<!-- right side start -->
			<div class="col-sm-6" style="padding-top:5px;padding-left:40px;">
			<div id="image_preview"><img id="previewing" class="image_preview1"
			src="<?php echo $product_image; ?>" /></div>
				<hr id="line">
				<div id="selectImage">
				<label>Select Product Image</label><br/>
				<input type="file" name="file" id="file" />				
				</div>
			</div>
			<input type="hidden" name="proimg" id='proimg' value="<?php echo $product_image; ?>">
			<input type="hidden" name="up" id='up' value="<?php echo $up; ?>">
			<div class="row">
				<div class="col-md-12" style="padding-top:10px; padding-bottom:30px;">
				<div class="row"><?php if(!empty($msg)){ ?> <div class="alert alert-warning" role="alert"><?php echo $msg; ?></div><?php } ?></div>
				<input type="submit" name="submit" class="btn btn-success btn-sm" value="Submit" onClick="return valid()" /> 
				<a href="vendor_generated_coupons.php"><button type="button" class="btn btn-danger btn-sm">CANCEL</button></a> 
				</div>
				</form>  
			</div>
		</div>
		<div class="clearfix"></div>        
		</div>   
	</div>
	</div>
</div>
</body>
</html>