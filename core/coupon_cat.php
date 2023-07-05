<?php
$data= new data();
if(xss_clean(mysql_real_escape_string(isset($_POST['cat1'])))){
	$cats=xss_clean(mysql_real_escape_string($_POST['cat1']));
	setcookie("cat1",$cats,time()+3600);
	header("Location:".htmlspecialchars($_SERVER['PHP_SELF']));
}	

if(isset($_COOKIE['cat1'])){	
$catsid=$_COOKIE['cat1'];
	if($catsid==100){
	$coupon =mysql_query("SELECT * FROM tbl_sponsorer sp JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id WHERE `points_per_product`!=0 and `validity`<>'invalid' and `category`='1' ORDER BY priority DESC");
	$count = mysql_num_rows($coupon);
	}else{
	$coupon =mysql_query("SELECT * FROM tbl_sponsorer sp JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id WHERE `points_per_product`!=0 and `category`=\"$catsid\" and `validity`<>'invalid' ORDER BY priority DESC");
	$count = mysql_num_rows($coupon);	
	}
	
}else{
$coupon =mysql_query("SELECT * FROM tbl_sponsorer sp JOIN tbl_sponsored spd ON sp.id = spd.sponsor_id WHERE `points_per_product`!=0 and `validity`<>'invalid' and `category`='1' ORDER BY priority DESC");
$count = mysql_num_rows($coupon);
}


if(xss_clean(mysql_real_escape_string(isset($_POST['dist'])))){
	$dist=xss_clean(mysql_real_escape_string($_POST['dist']));
	setcookie("distance",$dist,time()+3600);
	header("Location:".htmlspecialchars($_SERVER['PHP_SELF']));
}


if(xss_clean(mysql_real_escape_string(isset($_POST['c_loc'])))){
	$sp_country = xss_clean(mysql_real_escape_string($_POST['sp_country']));
	$sp_state = xss_clean(mysql_real_escape_string($_POST['sp_state']));
	$sp_city = xss_clean(mysql_real_escape_string($_POST['sp_city']));
	
	$loc=$data->calLatLongByAddress($sp_country,$sp_state,$sp_city);
	header("Location:".htmlspecialchars($_SERVER["PHP_SELF"])."?getlat=".$loc[0]."&getlong=".$loc[1]);		
}
$loc=$data->currentGeoLocation();
?>

<script>
$(function() {   

    $("#cat1").change(function() {
  var category= document.getElementById('cat1').value;
	// document.category.submit();
	    document.forms["category"].submit();	  
    })

});
</script>
<script>
$(function() {
	$("#dist").change(function() {
  var category= document.getElementById('dist').value;
	// document.category.submit();
	    document.forms["distance"].submit();
    })

});
</script>
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script>
$(document).ready(function(){ 
$('#search_container').hide();
$("#choose_loc").click(function(){
    $("#search_container").toggle();
});
});
</script>
<?php include 'country_state_city.inc.php'; ?>

<style>
.coup_txtbox {
  padding: 14px 0px 5px 0px;
}
.btn{
	padding: 5px 15px;
}
.search{
	padding-top:10px;
}
.choose_label{
	padding-top:5px;
}
.top-row{
	padding-top:10px;
	padding-bottom:10px;
}
</style>
<script src="js/city_state.js" type="text/javascript"></script>
<div class="header_filter">
<div class="container">                                
<div class="col-md-12" >				   		  
<div class="row top-row"> 

<a href="cart.php">  
 <button type="button" class="btn btn-success btn-lg" name="points_avl" id="points_avl" >
 <strong>
 <div class="cartbox"><span class="carttext"> <?php	
		$user_cart =mysql_query("SELECT * FROM cart WHERE `user_id` ='$id' and `entity_id` ='$entity' and `coupon_id` IS NOT NULL");
		$total_cart_items = mysql_affected_rows(); 
		if($total_cart_items==0){
			echo '0'; 
		}else{ 
			echo xecho($total_cart_items); }  
		?>  </span></div></strong>
</button>
		
</a>

<strong>Points Available</strong><span class="badge"><?php if($pts>0 and ($pts!="" or $pts!=0)){ echo xecho($pts);} else { echo '0';} ?></span> 


<button type="button" class="btn btn-default btn-sm" name="current_loc" id="current_loc" onClick="getLocation()" ><strong>Current Location</strong></button>


<button type="button" class="btn btn-default btn-sm" name="choose_loc" id="choose_loc" ><strong>Choose Location</strong></button>



		<div class="pull-right">					
					<form id="distance" action="" name="distance" method="post">
					
					<select class="form-control btn-sm" style="width:150px;" name="dist" id="dist"> 
					<option><strong>Distance Limit</strong></option>
					<option value="5" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='5'){ 
							echo 'selected'; 
						} 
					} ?> >5</option>
					<option value="10" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='10'){ 
							echo 'selected'; 
						} 
					} ?> >10</option>
					<option value="30" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='30'){ 
							echo 'selected'; 
						} 
					} ?> >30</option>
					<option value="50" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='50'){ 
							echo 'selected'; 
						} 
					} ?> >50</option>
					<option value="70" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='70'){ 
							echo 'selected'; 
						} 
					} ?> >70</option>
					<option value="100" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='100'){ 
							echo 'selected'; 
						} 
					} ?> >100</option>
					<option value="200" <?php if(isset($_COOKIE['distance'])){ 
						if($_COOKIE['distance']=='200'){ 
							echo 'selected'; 
						} 
					} ?> >200</option>  
					</select>
					
					</form>					
		</div>
		<div class="pull-right">
					
					<form id="category" action="" name="category" method="post">
					
                    <select class="form-control btn-sm" style="width:150px;"  name="cat1" id="cat1">
						<option value=''>Select Categories </option>
					<?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 
					 
						while($cats=mysql_fetch_array($catfromtbl)){
							$cat_id=$cats['id'];
							$cat_cat=$cats['category'];

					?>
                         <option value="<?php echo xecho($cat_id); ?>" <?php if(!isset($_COOKIE['cat1']) && $cat_id=='1'){ 
									
								}elseif($_COOKIE['cat1']==$cat_id){
									 
								} ?> ><?php echo xecho($cat_cat); ?></option>
						<?php } ?>    
                    </select>
					</form>
				
		</div>		
	
</div>
</div>
</div>
</div>
	   
	   <div class="container " id="search_container">
		<div class="row search">
			<div class="col-md-12">
				<div class="col-md-1 choose_label">
					<h4><center>Choose</center></h4>					
				</div>
				<form action="coupons.php" method="post">
				<div class="col-md-6"><div class="col-md-12">
					<?php include 'country_state_city.form.inc.php';?>
				</div></div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-default" name="c_loc" id="c_loc" >View</button>		
				</div>
				</form>
			</div>
		  </div>
	   </div>
