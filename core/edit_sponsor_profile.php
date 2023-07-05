<?php
@include 'conn.php';
@include 'coupon.inc.php';
include 'country_state_city.inc.php';

//$id=$_SESSION['id'];
$id=$_GET['id'];	
if(isset($_POST['submit_prof'])){
	function trimslashes($value){
		//$a=trim(addslashes($value));
		$a=trim(htmlentities($value));
		return $a;
	}
		$sp_name=trimslashes($_POST['sp_name']);
		$sp_company=trimslashes($_POST['sp_company']);
		$product_type=trimslashes($_POST['product_type']);
		$phone=trimslashes($_POST['phone']);
		$email=trimslashes($_POST['email']);
		$sp_website=trimslashes($_POST['sp_website']);
		$sp_dob=trimslashes($_POST['sp_dob']);
		$sp_gender=trimslashes($_POST['sp_gender']);
		$sp_occupation=trimslashes($_POST['sp_occupation']);
		$address=trimslashes($_POST['address']);
		$pin=trimslashes($_POST['pin']);
		$sp_country=trimslashes($_POST['sp_country']);
		$sp_state=trimslashes($_POST['sp_state']);
		$sp_city=trimslashes($_POST['sp_city']);
		
		if(empty($sp_name)){
			$report='Please enter owners name.';
		}
		if(empty($product_type)){
			$report='Please select default product type';
		}
		if(empty($sp_company)){
			$report='Please enter company name';
		}
		if(empty($sp_dob)){
			$report='Please enter Birth Date';
		}
		if(empty($sp_gender)){
			$report='Please select gender';
		}
		if(empty($address)){
			$report='Please enter address';
		}
		if(empty($sp_city)){
			$report='Please enter city';
		}
		if(empty($sp_state)){
			$report='Please enter state';
		}
		if(empty($sp_country)){
			$report='Please enter country';
		}
		if(empty($pin)){
			$report='Please enter ZIP/PIN code';
		}
		//$abc=new data();
		
		//$abc->currentGeoLocationOnInit();
		//$arr=$abc->calLatLongByAddress($sp_country, $sp_state, $sp_city);
	$addr=$address.", ".$city.", ".$state.", ".$country;
	$add= urlencode($addr);
	$geocode_selected=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$add.'&sensor=false');
	$output_selected= json_decode($geocode_selected);
	$lat = $output_selected->results[0]->geometry->location->lat;
	$lon = $output_selected->results[0]->geometry->location->lng;
		
$query=	
"UPDATE `tbl_sponsorer` SET `sp_name`='$sp_name' ,`sp_address`='$address' ,`sp_city`='$sp_city' ,`sp_dob`='$sp_dob' ,`sp_gender`='$sp_gender' ,`sp_country`='$sp_country' ,`sp_state`='$sp_state' ,`sp_occupation`='$sp_occupation' ,`sp_company`='$sp_company' ,`sp_website`='$sp_website' ,`lat`='$lat',`lon`='$lon',`pin`='$pin',`v_category`='$product_type' WHERE `id`='$id'";
$a=mysql_query($query)or die(mysql_error());
if($a){
	$report="Profile is successfully updated";
	header( "Location: sponsor_profile.php");
}else{
	$report ='Error occured';
	echo $query;
}

}



?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script>	
    $(function() {
		$( "#sp_dob" ).datepicker();
	});
  
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script type="text/javascript">// < ![CDATA[
function valid()
{		
		//name
		var sp_name=document.getElementById("sp_name").value;
 		if(sp_name==""||sp_name==null)
 		{
   				document.getElementById("err_sp_name").innerHTML = "Please enter owner's name";
   				return false;
 		}
		else
		{
		document.getElementById("err_sp_name").innerHTML = "";
		}
		
		//company
		var sp_company=document.getElementById("sp_company").value;
 		if(sp_company==""||sp_company==null)
 		{
   				document.getElementById("err_sp_company").innerHTML = "Please enter company name";
   				return false;
 		}
		else
		{
		document.getElementById("err_sp_company").innerHTML = "";
		}
		 //category
		 	//var val=$("#cat").val();
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
		 
/* 		//phone
		var phone=document.getElementById("phone").value;
 		if(phone==""||phone==null)
 		{
   				document.getElementById("err_phone").innerHTML = "Please enter phone number";
   				return false;
 		}
		else
		{
		document.getElementById("err_phone").innerHTML = "";
		}
		var phoneno = /^\d{10}$/;  
		if(!phone.match(phoneno)){  
			document.getElementById("err_phone").innerHTML = "Please enter valid Phone no.";
			return false;  
        }else{
			document.getElementById("err_phone").innerHTML = "";
		}

		//email
		var email=document.getElementById("email").value;
 			
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
		if(!email.match(mailformat)){  
				document.getElementById('err_email').innerHTML='Please Enter valid email ID';
				return false;  
		}else{
			document.getElementById('err_email').innerHTML='';
		} */
		
		//website
		//dob 
		var sp_dob=document.getElementById("sp_dob").value;
 		if(sp_dob==""||sp_dob==null)
 		{
   				document.getElementById("err_sp_dob").innerHTML = "Please enter birth date";
   				return false;
 		}
		else
		{
		document.getElementById("err_sp_dob").innerHTML = "";
		}
		
		//address
		var address=document.getElementById("address").value;
		if(address==""||address==null){
			document.getElementById("error_address").innerHTML = "Please Enter Adddress";
			return false;
   		}else{
			document.getElementById("error_address").innerHTML = "";
		}
		
		//pin
		var pin=document.getElementById("pin").value;
 		if(pin==""||pin==null){
   				document.getElementById("err_pin").innerHTML = "Please enter PIN/ZIP code";
   				return false;
 		}
		else{
		document.getElementById("err_pin").innerHTML = "";
		}
}
</script>
<div class="pad-top"></div>
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>Edit Profile</strong></h2>
		</div>
		<div class="panel-body">
			
			
			
		<form method="post" name="edit_prof" id="edit_prof">	
			<table class="table table-hover">
			<tr>
				<td style="font-weight:bold;" >
					Sponsor Name
				</td>
				<td>
					<input type="text" name="sp_name" id="sp_name" class="form-control" 
					value="<?php if(isset($_POST['sp_name'])){echo $_POST['sp_name'];}else { echo $fname;}?>" >
					<div class="row text-danger" align="center" id='err_sp_name' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;" >
					Company Name
				</td>
				<td>
					<input type="text" name="sp_company" id="sp_company" class="form-control" 
					value="<?php if(isset($_POST['sp_company'])){echo $_POST['sp_company'];}else { echo $sp_company;}?>" >
					<div class="row text-danger" align="center" id='err_sp_company' ></div>
				</td>
			</tr>
			
			<tr>
				<td style="font-weight:bold;" >
					Default Product Category
				</td>
				<td>
					<select class="form-control cat-sel-opt" id="product_type" name="product_type" > 
                         <option>Select Category</option>
						  <?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 
						while($cats=mysql_fetch_array($catfromtbl)){
							$cat_id=$cats['id'];
							$cat_cat=$cats['category'];
							?>
                         <option value="<?php echo $cat_id; ?>" <?php if($v_category==$cat_id){ echo "selected"; } ?> ><?php echo $cat_cat; ?></option>
						<?php } ?>  
                       
						</select>
							<div  id="errorproduct_type" style="color:#FF0000" align="center"></div>
				</td>
			</tr>
		<!--
			<tr>
				<td style="font-weight:bold;" >
					Phone
				</td>
				<td>
					<input type="text" name="phone" id="phone" class="form-control" 
					value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];}else { echo $phone;}?>" onkeypress="return isNumberKey(event)">
					<div class="row text-danger" align="center" id='err_phone' ></div>
				</td>
			</tr>
			
			<tr>
				<td style="font-weight:bold;">
					Email
				</td>
				<td>
					<input type="email" name="email" id="email" class="form-control" 
					value="<?php if(isset($_POST['email'])){echo $_POST['email'];}else { echo $email;}?>" >
					<div class="row text-danger" align="center" id='err_email' ></div>
				</td>
			</tr>-->
			<tr>
				<td style="font-weight:bold;">
					Website
				</td>
				<td>
					<input type="text" name="sp_website" id="sp_website" class="form-control" 
					value="<?php if(isset($_POST['sp_website'])){echo $_POST['sp_website'];}else { echo $sp_website;}?>" >
					<div class="row text-danger" align="center" id='err_sp_website' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Date of Birth
				</td>
				<td>
					<input type="date" name="sp_dob" id="sp_dob" class="form-control" 
					value="<?php if(isset($_POST['sp_dob'])){echo $_POST['sp_dob'];}else { echo $sp_dob;}?>" >
					<div class="row text-danger" align="center" id='err_sp_dob' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Gender
				</td>

				<td class="text-capitalize">
					<input type="radio" name="sp_gender" value="male" 
					<?php if((isset($_POST['sp_gender']) && $_POST['sp_gender']=='male') or $sp_gender=='male'){ echo 'checked'; } ?>>Male
					<input type="radio" name="sp_gender" value="female" 
					<?php if((isset($_POST['sp_gender']) && $_POST['sp_gender']=='female') or $sp_gender=='female'){ echo 'checked'; } ?>>Female
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Occupation
				</td>
				<td class="text-capitalize">
					<input type="text" name="sp_occupation" id="sp_occupation" class="form-control" 
					value="<?php if(isset($_POST['sp_occupation'])){echo $_POST['sp_occupation'];}else { echo $sp_occupation;}?>" >
					<div class="row text-danger" align="center" id='err_sp_occupation' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					Address
				</td>
				<td class="text-capitalize">
					<textarea class="form-control custom-control" rows="3" name="address" id="address" style="resize:none"><?php if(isset($_POST['address'])){echo $_POST['address'];}else{ echo trim($address);}?></textarea>
					<div class="row text-danger" align="center" id='err_address' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					
				</td>
				<td class="text-capitalize">
					<?php include 'country_state_city.form.inc.php'; ?>					
				</td>
			</tr>			
			<tr>
				<td style="font-weight:bold;">
					ZIP / PIN
				</td>
				<td class="text-capitalize">
					<input type="text" name="pin" id="pin" class="form-control" 
					value="<?php if(isset($_POST['pin'])){echo $_POST['pin'];}else{ echo $pin;} ?>" onkeypress="return isNumberKey(event)" >
					<div class="row text-danger" align="center" id='err_pin' ></div>
				</td>
			</tr>
	
			
			
			</table>
<div class="row text-danger" align="center"><?php if(isset($_POST['submit_prof'])){ echo $report; }?></div>	
<input type="submit" value="Update" name="submit_prof" id="submit_prof" onClick="return valid();" class="btn btn-success" >
<a href="coupon_accept.php" ><input type="button" value="Back" name="cancel" class="btn btn-warning"></a>
</form>
		</div>
	</div>
</div>