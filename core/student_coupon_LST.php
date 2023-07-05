<?php
require 'stud_header.php';
include 'coupon_validity_check.php';
require 'coupon_cat.php';
$distance="";

if(isset($_GET['getlat']) && isset($_GET['getlong'])){	
	$lat21=$_GET['getlat'];
	$lon21=$_GET['getlong'];
	setcookie("lat2", $lat21, time()+3600);
	setcookie("lon2", $lon21, time()+3600);
	header("Location:student_coupon.php");
}
	
	if(isset($_COOKIE['distance'])){
	$distance=$_COOKIE['distance'];
	}else{
	$distance=10;	
	}
	if($distance!="no_limit"){
		$chk_dist=$distance;
	}elseif($distance=='no_limit'){
		$chk_dist=1000;
	}else{
		$chk_dist=5;
	}
	
	
	
if(true){?>
       <div class="middle_container">
      <div class="container">  
       <div class="row"> 

<?php
$meters="";
$tc_check=0;
include 'distance.php';
while($result=@mysql_fetch_array($coupon) ){ 
	$ppp=$result['points_per_product'];
	$logo=$result['sp_img_path'];
	
	$company=$result['sp_company'];
	$product=$result['Sponser_product'];
	$proid=$result['id'];
	
	$product_price=$result['product_price'];
	$discount=$result['discount'];
	$buy=$result['buy'];
	$buy_get=$result['get'];
	$saving=$result['saving'];	
	$valid_until=$result['valid_until'];
	$currid=$result['currency'];
	
	if($currid!=0 or $currid!=null){
	$curre=mysql_query("SELECT `currency` FROM `currencies` WHERE `id`=$currid ");	
	$curr=mysql_fetch_array($curre);
	$currency=$curr['currency'];
	}else{
		$currency=null;		
	}
	
	$pro_img=$result['product_image'];
	$cat=$result['category'];
	
	$sp_email=$result['sp_email'];
	$sp_phone=$result['sp_phone'];
	$sp_address=$result['sp_address'];
	$sp_city=$result['sp_city'];
	$sp_state=$result['sp_state'];
	$sp_country=$result['sp_country'];
	$sp_website=$result['sp_website'];
	
	$priority=$result['priority'];
	$sp_cat=$result['category'];
	$offerdes=$result['offer_description'];
	$daily_counter=$result['daily_counter'];
	
	$total_coupons=$result['total_coupons'];
$c_chk=$abc->counter_check($daily_counter);
	$lat1=$result['lat'];
	$lon1=$result['lon'];
	
	$lat2=$_COOKIE['lat2'];
	$lon2=$_COOKIE['lon2'];
	
	$miles=calculateDistance($lat1, $lon1, $lat2, $lon2);
	
	$kilometers = $miles * 1.609344;
	
	if($kilometers <= 0){
		$meters = $miles * 1609.34;
	}
	

	
	if($kilometers <= $chk_dist){
		$dist_acceptable=1;
	}else{
		$dist_acceptable=0;
	}
	
	if($dist_acceptable){
	if($c_chk){ ?>

	                <div class="col-xs-12 col-sm-4 col-md-3">
                      <div class="coup_box">
					  <form method="post">
					<?php if(file_exists($logo)){ ?>
					<a href="<?php if($sp_website!=""){ ?>http://<?php } echo htmlspecialchars(urlencode($sp_website)); ?>"  target='_blank' >
					<img src="<?php echo $logo;?>" class="sp_logo img-responsive" style="height:83px;"/>
					</a>
					<?php } else { ?>
					<a href="<?php if($sp_website!=""){ ?>http://<?php } echo htmlspecialchars(urlencode($sp_website)); ?>" target='_blank' >
					<img src="image/newlogo1.png" class="sp_logo img-responsive" style="height:83px;"/><?php }  ?>
					</a>
                      <?php if(file_exists($pro_img)){ ?><img src="<?php echo $pro_img;?>" class="sp_prod img-responsive"  style="height:140px;"/><?php }  
                       else { ?><img src="image/imgnotavl.png" class="sp_prod img-responsive"  style="height:140px;"/><?php }  ?>
					  <div class="coup_txtbox" ><p class="couptxt1"><?php if($company!=""){  echo  "<font color=\"black\">".strtoupper($company)."</font>"; }else{ ?> <p class="couptxt1" style="visibility:hidden;" >NA</p> <?php } ?></p>
					 <?php if($product!=""){ ?>
					 <p class="couptxt1"><?php echo strtoupper($product);?></p>
					 <?php } else { ?>
					 <p class="couptxt1" style="visibility:hidden;" >NA</p>
					 <?php } ?>
					 <p><span class="couptxt2"><?php if($discount!=0 or $discount!=0){ 
																echo $discount."% Off"; 
															} 
															if($buy!=0 and $buy_get!=0){ 
																if($discount!=0){ 
																	echo ' Or ';
																} 
																echo 'Buy '.$buy.' Get '.$buy_get.' Free'; 
															} 
													?></span> <br />
													<?php if($product_price!=""){ ?>
													<span class="couptxt3">MRP: <?php echo $currency." ".$product_price; ?>/-</span><br />
													<?php }else{ ?>
													<span class="couptxt3"  style="visibility:hidden;">MRP: <?php echo $currency." ".$product_price; ?>/-</span><br />
													<?php } ?>
													<span class="couptxt3">(on <?php echo $ppp; ?> points)</span></p>
                           <?php if($saving!=0){ ?><p class="couptxt4">SAVE   <?php echo $currency." ".$saving; ?>/-</p> <?php }else{?>
							<p class="couptxt4" style="visibility:hidden;">SAVE <?php echo $currency." ".$saving; ?>/-</p>
							   
						<?php   } ?>
                           <p>
	<button type="button" class="catbtn"  data-container="body" data-toggle="popover" data-placement="top" 
	data-viewport="" data-trigger="focus"
	data-html="true" data-content="<?php 
	if($valid_until!=""){ echo "Valid Until: <strong>".$valid_until."</strong><br/>"; }
if($meters != ""){ echo "Distance: <strong>".round($meters)."</strong> m<br/>"; } else { echo "Distance: <strong>".round($kilometers)."</strong> Kms<br/>"; } 
	if($total_coupons!="unlimited"){ echo "Total Coupons Left <strong>".$total_coupons."</strong><br/>"; }
	if($daily_counter!="unlimited"){ echo "Today's Limit <strong>".$daily_counter."</strong><br/>"; }
	if($offerdes!=""){ echo "Description: ".$offerdes."<br/>"; }
	if($sp_address!=""){ echo "Address: ".$sp_address."<br/>"; }
	if($sp_city!=""){ echo "City: ".$sp_city."<br/>"; }
	if($sp_state!=""){ echo "State: ".$sp_state."<br/>"; }
	if($sp_country!=""){ echo "Country: ".$sp_country."<br/>"; }
	if($sp_email!=""){ echo "Email: ".$sp_email."<br/>"; }
	if($sp_website!=""){ ?><a href='http://<?php echo $sp_website; ?>' target='_blank' ><strong><?php echo $sp_website; ?></a></strong> 
							<?php } ?>">Description</button>
						  				 
						   <input type="hidden" name="proid" value="<?php echo $proid;?>">
						   <input type="hidden" name="ppp" value="<?php echo $ppp;?>">			  						   
						   <input type="submit" name="select" value="Select" class="getcoubtn" <?php if(!($ppp <= $pts) ){ echo 'disabled'; } ?>/></p>
						   </form>
						  <div class="clearfix" ></div>
                        </div>
                      </div>
                    </div>

	 
	


<?php $tc_check++; } }
	//	} } }
} 
if($tc_check==0){
	?>
	<div class="alert alert-danger" role="alert" align="center">
	<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"> &nbsp;&nbsp;&nbsp;&nbsp;
	</span><strong>Sorry! Please select a location.</strong></div>
<?php	
}
?>
</div></div></div>

<?php }else{ ?>	
	<div class="alert alert-danger" role="alert" align="center">
	<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"> &nbsp;&nbsp;&nbsp;&nbsp;
	</span><strong>Sorry</strong> you have no more balance points.</div>

<?php }  ?>
