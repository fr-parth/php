<?php
//vendor_generated_coupon
@include 'sponsor_header.php';

$logo=$sp_img_path;
$company=$sp_company;
?>
<div class="container" >
<h1>Your coupon will look like this</h1>
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>


<style>
.coup_txtbox {
  padding: 14px 0px 5px 0px;
}
.btn{
	padding: 5px 15px;
}
</style>
 <link href="css/coupon_style.css" rel="stylesheet">

<?php
if(isset($_GET['ins'])){
	$inserted_id=$_GET['ins'];
	$get_just_inserted=mysql_query("SELECT ts.`id`,`Sponser_product`,`points_per_product`,`sponsered_date`,`Sponser_type`,`valid_no_of_student`,
`validity`,`sponsor_id`,`product_image`,`valid_until`, cat.`category`, `product_price`, `discount`, `buy`, `get`, `saving`,`offer_description`, `daily_limit`, `total_coupons`, `priority`, `coupon_code_ifunique`, c.`currency`,`daily_counter`   FROM `tbl_sponsored` ts left join currencies c on c.id=ts.currency left join categories cat on cat.id=ts.category WHERE ts.`id`=$inserted_id");
	$ins=mysql_fetch_array($get_just_inserted); 
	$pro_img=$ins['product_image'];
	$product=$ins['Sponser_product'];
	$discount=$ins['discount'];
	$buy=$ins['buy'];
	$buy_get=$ins['get'];
	
	$currency=$ins['currency'];
	
	$product_price=$ins['product_price'];
	$saving=$ins['saving'];
	$offerdes=$ins['offer_description'];
	
	$ppp=$ins['points_per_product'];
 ?>

       <div class="middle_container">
      <div class="container">  
       <div class="row"> 
	                <div class="col-xs-12 col-sm-4 col-md-3 ">
                      <div class="coup_box">
					  				 
                      <?php if(file_exists($logo)){ ?><img src="<?php echo $logo;?>" class="sp_logo img-responsive" style="height:120px;"/><?php } 
						else { ?><img src="image/newlogo1.png" class="sp_logo img-responsive" style="height:120px;"/><?php }  ?>
                      <?php if(file_exists($pro_img)){ ?><img src="<?php echo $pro_img;?>" class="sp_prod img-responsive"  style="height:210px;"/><?php }  
                       else { ?><img src="image/imgnotavl.png" class="sp_prod img-responsive"  style="height:210px;"/><?php }  ?>
					  <div class="coup_txtbox" ><p class="couptxt1"><?php if($company!=""){  echo  "<font color=\"black\">".strtoupper($company)."</font>"; }else{ echo "<font color=\"red\"> NA </font>";} ?></p>
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
													<span class="couptxt3">MRP: <?php echo $currency." ".$product_price; ?>/-</span><br />
													<span class="couptxt3">(on <?php echo $ppp; ?> points)</span></p>
                           <?php if($saving!=0){ ?><p class="couptxt4">SAVE   <?php echo $currency." ".$saving; ?>/-</p> <?php }else{?>
							<p class="couptxt4" style="visibility:hidden;">SAVE <?php echo $currency." ".$saving; ?>/-</p>
							   
						<?php   } ?>
                           <p>
						    <?php if($offerdes!=""){ ?>
							<button type="button" class="btn btn-default"  data-container="body" data-toggle="popover" data-placement="bottom" data-content="<?php if($offerdes!=null){ echo $offerdes; } ?>">Description</button>
						   <?php } else { ?>
						   <button type="button" class="btn btn-default"  data-container="body" data-toggle="popover" data-placement="bottom" data-content="Offer Description Not Available">Description</button>
						   <?php } ?>
						   </p>
						   
						  <div class="clearfix" ></div>
                        </div>
                      </div>
					  
                    </div>
 	 	 		 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	
					<div class="col-md-7">
						<div class="panel panel-default">
							<div class="panel-body">
								<h4>Summary</h4>
								<p>Product Name: <?=$product; ?><br/>
								Product Category: <?=$ins['category']; ?><br/>
								Start Date: <?=$ins['sponsered_date']; ?><br/>
								End Date: <?=$ins['valid_until']; ?><br/>
								Points: <?=$ppp; ?><br/>
								Product MRP: <?php echo $ins['currency'].' '.$ins['product_price']; ?><br/>
								Discount: <?=$ins['discount']; ?>%<br/>
								Buy: <?=$ins['buy']; ?> Get <?=$ins['get']; ?><br/>
								Offer Description: <?=$ins['offer_description']; ?><br/>
								Daily Coupon Accepting Limit: <?=$ins['daily_limit']; ?><br/>
								Total Number of Coupons: <?=$ins['total_coupons']; ?><br/>
								Unique Coupon Code (if Set): <?=$ins['coupon_code_ifunique']; ?><br/>
							</div>
						</div>
					</div>
					</div>
					
					<a href="vendor_coupon_setup.php?up=<?php echo $inserted_id; ?>"><input type="button" value="Edit" class="btn btn-success" style=""/></a>
					<a href="vendor_generated_coupons.php"><input type="button" value="Continue....." class="btn btn-success" style=""/></a>
					
					</div>
					
					</div>
<?php } ?>
					
					</div>
