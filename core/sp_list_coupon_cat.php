<?php

$pts='';

if(xss_clean(mysql_real_escape_string(isset($_POST['cat1'])))){
	$cats=xss_clean(mysql_real_escape_string($_POST['cat1']));
	setcookie("cat1_vlist",$cats,time()+3600);
	header("Location:vendor_suggested_like.php");
}

if(xss_clean(mysql_real_escape_string(isset($_POST['dist'])))){
	$dist=xss_clean(mysql_real_escape_string($_POST['dist']));
	setcookie("distance_vlist",$dist,time()+3600);
	header("Location:vendor_suggested_like.php");
}

if(xss_clean(mysql_real_escape_string(isset($_COOKIE['cat1_vlist'])))){	
$catsid=$_COOKIE['cat1_vlist'];
	if($catsid==100){
		
	$su =mysql_query("SELECT id,sp_name,v_category,sp_phone,sp_email,sp_address,sp_city,sp_state,sp_country,v_status,v_likes FROM tbl_sponsorer WHERE `v_status`='Inactive'");
	$count =mysql_fetch_array($su);
	}else{
		
	$su =mysql_query("SELECT id,sp_name,v_category,sp_phone,sp_email,sp_address,sp_city,sp_state,sp_country,v_status,v_likes FROM  tbl_sponsorer WHERE `v_status`='Inactive' and `v_category`=\"$catsid\"");
	$count =mysql_fetch_array($su);	
	}
	
}else{
	
$su =mysql_query("SELECT id,sp_name,v_category,sp_phone,sp_email,sp_address,sp_city,sp_state,sp_country,v_status,v_likes FROM  tbl_sponsorer WHERE `v_status`='Inactive'  ");
$count =mysql_fetch_array($su);
}
if(xss_clean(mysql_real_escape_string(isset($_POST['c_loc'])))){
	$country_selected=xss_clean(mysql_real_escape_string($_POST['sp_country']));
	$state_selected=xss_clean(mysql_real_escape_string($_POST['sp_state']));
	$city_selected=xss_clean(mysql_real_escape_string($_POST['sp_city']));

		$address_selected=$city_selected.", ".$state_selected.", ".$country_selected;	
		$prepAddr_selected = urlencode($address_selected);
$geocode_selected=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr_selected.'&sensor=false&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY');
		$output_selected= json_decode($geocode_selected);
		$lat_selected = $output_selected->results[0]->geometry->location->lat;
		$long_selected = $output_selected->results[0]->geometry->location->lng;		
		header("Location:vendor_suggested_like.php?getlat=".$lat_selected."&getlong=".$long_selected);	
}
?>
 <script>

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
		function showPosition(position) {
	var string_url = "vendor_suggested_like.php?getlat="+position.coords.latitude+"&getlong="+position.coords.longitude;
	window.location = string_url;
}
    } else {
		alert('no');
        alert("Geolocation is not supported by this browser.");
    }
}

</script>
<script>
$(function() {

    

    $("#cat1").change(function() {
  var category= document.getElementById('cat1').value;
	    document.forms["category"].submit();

	  
    })

});
</script>
<script>
$(function() {
	$("#dist").change(function() {
  var category= document.getElementById('dist').value;
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

<button type="button" class="btn btn-default btn-sm" name="points_avl" id="points_avl" ><strong>Points Available</strong><span class="badge"><?php echo xecho($pts); ?></span></button>


<button type="button" class="btn btn-default btn-sm" name="current_loc" id="current_loc" onClick="getLocation()" ><strong>Current Location</strong></button>


<button type="button" class="btn btn-default btn-sm" name="choose_loc" id="choose_loc" ><strong>Choose Location</strong></button>



		<div class="pull-right">					
					<form id="distance" action="" name="distance" method="post">					
					<select class="form-control btn-sm" style="width:150px;" name="dist" id="dist"> 
					<option><strong>Distance Limit</strong></option>
					<option value="no_limit">No Limit</option>
					<option value="2">2</option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="200">200</option>
					<option value="300">300</option>  
					</select>
					</form>					
		</div>
		<div class="pull-right">
					
					<form id="category" action="" name="category" method="post">
                    <select class="form-control btn-sm" style="width:150px;"  name="cat1" id="cat1"> 
					<option ><strong>Select Category</strong></option>
					<option value="100">All</option>
					<?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 
						while($cats=mysql_fetch_array($catfromtbl)){
							$cat_id=$cats['id'];
							$cat_cat=$cats['category'];
					?>
                         <option value="<?php echo xecho($cat_id); ?>"><?php echo xecho($cat_cat); ?></option>
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
				<div class="row">
				<div class="col-md-1 choose_label">
					<h4><center>Choose</center></h4>					
				</div>
				<form action="vendor_suggested_like.php" method="post">
			
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
	   </div>
