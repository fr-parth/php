<?php
//product part
include("sponsor_header.php");
$edit_pid="";
$reportp="";
$sp_id=$_SESSION['id'];	
if(isset($_GET['del'])){
	$del=$_GET['del'];
	mysql_query("delete from tbl_sponsored where id='$del'");
	header("Location:product_setup.php");
}
$v_category1=mysql_query("select v_category from tbl_sponsorer where id='$sp_id'");
$v_category =mysql_fetch_array($v_category1);
$category=$v_category['v_category'];

if(isset($_POST['submit_product'])){
 			$product=$_POST['product'];
 			$pointsp=$_POST['pointsp'];
					
			$edit_pid=$_POST['edit_pid'];//id of product to edit
		
			if($product==""|| $pointsp=="")
			{
				$reportp="Please enter product and point";
			}else{			
			if($edit_pid!=""){		//update after edit product		
				$q=mysql_query("update `tbl_sponsored` set `Sponser_product`='$product',`Points_per_product`='$pointsp' where `id`=$edit_pid");
				if($q){
					$reportp='Updated';
				}
			}else{
				$arr1=mysql_query("select * from  tbl_sponsored where Sponser_type='Product' and Sponser_product like '$product' and sponsor_id='$sp_id'");
				$num_rows =mysql_num_rows($arr1);
			
				if($num_rows<=0){
						$newdate1 = strtotime('+6 months', time()) ; // sponsored date
						$valid_until = date ("m/d/Y", $newdate1);		

						$sponsored=date("m/d/Y",time()); // sponsored date
					
					
					
	$query="insert into tbl_sponsored(Sponser_type,Sponser_product,Points_per_product,sponsor_id,total_coupons,valid_until,sponsered_date,daily_limit,daily_counter,reset_date,category) values('Product','$product','$pointsp','$sp_id','unlimited','$valid_until','$sponsored','unlimited','unlimited','$sponsored','$category')";

						$rs = mysql_query( $query )or die(mysql_error());					
				}else{
					  $reportp="Product is already present";
				}
			}	
			}
}
	
?>
<?php
//discount part

$reportd="";
$edit_did="";
if(isset($_POST['submit_discount'])){
			 $discount=$_POST['discount'];
			 $pointsd=$_POST['pointsd'];
			 $edit_did=$_POST['edit_did'];//edit discount
			
		if($discount==""|| $pointsd==""){
			$reportd="Please Enter Discount and Point";
		}else{
							
				if (strpos($discount,'%')){
						// We found a string inside string
				}else{
					$discount=$discount."%";				
				}
			if($edit_did!=""){		//update after edit discount		
				$q=mysql_query("update `tbl_sponsored` set `Sponser_product`='$discount',`Points_per_product`='$pointsd' where `id`=$edit_did");
				if($q){
					$reportd='Updated';
				}
			}else{
				$arr=  mysql_query("select * from  tbl_sponsored where Sponser_type='discount' and Sponser_product='$discount'and sponsor_id='$sp_id'");
				if(mysql_num_rows($arr)<=0){
					$newdate1 = strtotime('+6 months', time()) ; // sponsored date
					$valid_until = date ("m/d/Y", $newdate1);
					$sponsored=date("m/d/Y",time()); // sponsored date
					$query="insert into tbl_sponsored(Sponser_type,Sponser_product,Points_per_product,sponsor_id,total_coupons,valid_until,sponsered_date,daily_limit,daily_counter,reset_date,discount,category) values('discount','$discount','$pointsd','$sp_id','unlimited','$valid_until','$sponsored','unlimited','unlimited','$sponsored','$discount','$category')";
					$rs = mysql_query( $query );
				}else{		  
					$reportd="Discount is already present";
				}
			}
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie Program</title>
<script>

function confirmation(xxx, product) {

    var answer = confirm("Are you sure to delete "+product+"?");
    if (answer){
        
        window.location = "product_setup.php?del="+xxx;
    }
    else{
       
    }
	}
</script>
<script>
function valid_product()
{	
	var product=document.getElementById("product").value;
	
		if(product=="" || product==null)
			{
				document.getElementById('errorproduct').innerHTML='Please enter product';
				
				return false;
			}
			regx1=/^[A-z ]+$/;
				//validation for product
				if(!regx1.test( product) || !regx1.test( product))
				{
				document.getElementById('errorproduct').innerHTML='Please enter valid product';
					return false;
				}
}
function valid_points_per_product()
{	

	var points=document.getElementById("pointsp").value;
	
		if(points=="" || points==null)
			{
				document.getElementById('errorpointsp').innerHTML='Please enter points';
				
				return false;
			}
		regx1=/^[0-9]+$/;
				//validation for points
				if(!regx1.test(points) || !regx1.test(points))
				{
				document.getElementById('errorpointsp').innerHTML='Please enter valid points';
					return false;
				}
}
function validp()
{
	var product=document.getElementById("product").value;
	
		if(product=="" || product==null)
			{
				document.getElementById('errorproduct').innerHTML='Please enter product';
				
				return false;
			}
			regx1=/^[A-z ]+$/;
				//validation for product
				if(!regx1.test( product))
				{
				document.getElementById('errorproduct').innerHTML='Please enter valid product';
					return false;
				}
		var points=document.getElementById("pointsp").value;
	
		if(points=="" || points==null || points==0)
			{
				document.getElementById('errorpointsp').innerHTML='Please enter points';
				
				return false;
			}
		regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
				document.getElementById('errorpointsp').innerHTML='Please enter valid points';
					return false;
				}

}
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script>
function edit_product(id, pro, point){
	oFormObject = document.forms['product_form'];
	oFormObject.elements["product"].value =pro;
	oFormObject.elements["pointsp"].value =point;
	oFormObject.elements["edit_pid"].value =id;
}
</script>
<script>
function edit_discount(id, pro, point){
	oFormObject = document.forms['discount_form'];
	oFormObject.elements["discount"].value =pro;
	oFormObject.elements["pointsd"].value =point;
	oFormObject.elements["edit_did"].value =id;
}
</script>

<script>
function valid_discount()
{	
	var discount=document.getElementById("discount").value;
	
		if(discount=="" || discount==null || discount==0)
			{
				document.getElementById('errordiscount').innerHTML='Please enter discount';
				
				return false;
			}
			else
			{
			document.getElementById('errordiscount').innerHTML='';
			}
			regx1=/^[0-9%]+$/;
				//validation for discount
				if(!regx1.test(discount))
				{
				document.getElementById('errordiscount').innerHTML='Please enter valid discount';
					return false;
				}
				else
			{
			document.getElementById('errordiscount').innerHTML='';
			}
}
function valid_points_per_discount()
{	
	var points=document.getElementById("pointsd").value;
	
		if(points=="" || points==null || points==0 )
			{
				document.getElementById('errorpointsd').innerHTML='Please enter points';
				
				return false;
			}
			else
			{
			document.getElementById('errorpointsd').innerHTML='';
			}
			regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
			document.getElementById('errorpointsd').innerHTML='Please enter valid points';
					return false;
				}
				
					else
			{
			document.getElementById('errorpointsd').innerHTML='';
			}
				
}
function validd()
{
	var product=document.getElementById("discount").value;
	
		if(product=="" || product==null || product==0)
			{
			document.getElementById('errordiscount').innerHTML='Please enter discount';
				
				
				return false;
			}
				else
			{
			
			document.getElementById('errordiscount').innerHTML='';
			}
			
		
			regx1=/^[0-9% ]+$/;
				//validation for discount
				if(!regx1.test( product))
				{
				document.getElementById('errordiscount').innerHTML='Please enter valid discount';
					return false;
				}
				
				
					else
			{
			
			document.getElementById('errordiscount').innerHTML='';
			}
		var points=document.getElementById("pointsd").value;
	
		if(points=="" || points==null || points==0)
			{
				document.getElementById('errorpointsd').innerHTML='Please enter points';
				
				return false;
			}
				else
			{
			
			document.getElementById('errorpointsd').innerHTML='';
			}
		regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
			document.getElementById('errorpointsd').innerHTML='Please enter valid points';
					return false;
				}
					else
			{
			
			document.getElementById('errorpointsd').innerHTML='';
			}




}
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script>
$(document).ready(function(){
    $('#dTable').DataTable( {
		"pageLength": 6
	} );
});
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#pTable').DataTable( {
		"pageLength": 6
	} );
	
});

</script>
<style>
.row{
	padding-top:5px;
}
</style>
<body >
<div class="container-fluid">
<div class="col-md-12">
<div class="row">
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><b>Add Product</b></h2>
		</div>
		<div class="panel-body">
		<div class="row">	
			<div class="col-md-12">			
			<div class="col-md-6">
			<form method="post" id="product_form" name="product_form">
			<div class="row">
				<input type="text" class="form-control" name="product" id="product" placeholder="Enter Product" onblur="valid_product()" value="" />
			</div>
			<div class="row text-warning" id="errorproduct"  ></div>
			<div class="row">
				<input type="text" class="form-control" name="pointsp" id="pointsp" placeholder="Points per Product" onblur="valid_points_per_product()" onkeypress="return isNumberKey(event)" value=""/>
			</div>			
			<div class="row text-warning"  id="errorpointsp" ></div>
			<input type="hidden" name="edit_pid" id="edit_pid" value="" />
			<div class="row">
				<input type="submit" class="btn btn-success" name="submit_product" value="Submit" onclick="return validp()"/> <a href="coupon_accept.php"> 
				<input type="button" class="btn btn-warning" name="Cancel" value="Back" /></a>
			</div>
			<div class="row text-success" ><?php echo $reportp;?></div>
			
			</form>
            </div>
			</div>
			</div>
		<div class="row">	
		<div class="col-md-12">
				<div class="row">
				<table class="table" id="pTable">
					<thead>
						<tr><th>#</th><th>Product</th><th>Points</th><th></th><th></th></tr>
					</thead>
					<tbody>
						<?php
                                    $i=0;                                    
                                    $arr2 = mysql_query("select id, Sponser_product, points_per_product  from tbl_sponsored where Sponser_type = 'Product' and sponsor_id='$sp_id'");
                                    while($row = mysql_fetch_array($arr2))
                                    {
                                    $i++;
																		
                        ?>
						<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $row['Sponser_product'];?></td>
						<td><?php echo $row['points_per_product'];?></td>
						<td>										
						<a onclick="edit_product('<?php echo $row['id']; ?>','<?php echo $row['Sponser_product']; ?>','<?php echo $row['points_per_product']; ?>' )" >
						<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
<td><a onClick="confirmation('<?php echo $row['id'];?>','<?php echo $row['Sponser_product'];?>')"  >
						<span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
						<?php  } ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>		
			
		</div>
	</div>
</div>
<div class="col-md-6">
<?php //include 'discount_setup.php';?>
<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><b>Add Discount</b></h2>
		</div>
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">			
			<div class="col-md-6">
			
			<form method="post" name="discount_form">
			<div class="row">
				<input type="text" class="form-control" name="discount" id="discount" placeholder="Enter Discount" onblur="valid_discount()" value="" onkeypress="return isNumberKey(event)" />
			</div>
			<div class="row text-warning" id="errordiscount"  ></div>
			<div class="row">
				<input type="text" class="form-control" name="pointsd" id="pointsd" placeholder="Points" onblur="valid_points_per_discount()" value="" onkeypress="return isNumberKey(event)"/>
			</div>			
			<div class="row text-warning"  id="errorpointsd" ></div>
			<input type="hidden" name="edit_did" id="edit_did" value="" />
			<div class="row">
				<input type="submit" class="btn btn-success" name="submit_discount" value="Submit" onclick="return validd()" /> <a href="coupon_accept.php"> 
				<input type="button" class="btn btn-warning" name="Cancel" value="Back" /></a>
			</div>
			<div class="row text-success" ><?php echo $reportd;?></div>
			</form>
            </div>			
			</div>
		</div>
			<div class="row">
			<div class="col-md-12">
				<div class="row">
				<table class="table" id="dTable">
					<thead>
						<tr><th>#</th><th>Discount</th><th>Points</th><th></th><th></th></tr>
					</thead>
					<tbody>
						<?php
                            $i=0;
							$arr3 = mysql_query("select id,Sponser_product,points_per_product  from tbl_sponsored where Sponser_type = 'discount' and sponsor_id='$sp_id'");
							while($row1 = mysql_fetch_array($arr3))
							{
							$i++;
						?>
						<tr >
						<td><?php echo $i;?></td>
						<td><?php echo $row1['Sponser_product'];?></td>
						<td><?php echo $row1['points_per_product'];?></td>
						<td>
<a onclick="edit_discount('<?php echo $row1['id']; ?>','<?php echo $row1['Sponser_product']; ?>','<?php echo $row1['points_per_product']; ?>' )" ><span class="glyphicon glyphicon-pencil"></span></a>
												
						</td>
<td><a onClick="confirmation('<?php echo $row1['id'];?>','<?php echo $row1['Sponser_product']; ?>')" >
						<span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
						<?php  } ?>
					</tbody>
				</table>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>
</div>

</body>
</html>
