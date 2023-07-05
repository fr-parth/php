<!--
<div class="middle_container" id="divimage">
      <div class="container" >		
       <div class="row" > 
<?php
$get_selected_vendor_coupons=mysql_query("SELECT * FROM tbl_selected_vendor_coupons WHERE `entity_id`=$entity  and `user_id`=$user_id and `used_flag`=\"unused\"");
$svc= mysql_fetch_array($get_selected_vendor_coupons);	
	$sid=$svc['id'];
	$cid=$svc['coupon_id'];
	$ppp=$svc['for_points'];
	$time=$svc['timestamp'];
	$ts=explode(' ',$time);
	$date=$ts[0];
	$tm=$ts[1];
	$code=$svc['code'];
	$used_flag=$svc['used_flag'];


	$sponsored1=mysql_query("SELECT * FROM `tbl_sponsored` WHERE `id`=$cid");
	
	$sponsored=mysql_fetch_array($sponsored1);
	
	$sp_id=$sponsored['sponsor_id'];
	$product=$sponsored['Sponser_product'];
	$pro_img=$sponsored['product_image'];

	$discount=$sponsored['discount'];
	$buy=$sponsored['buy'];
	$buy_get=$sponsored['get'];
	$saving=$sponsored['saving'];

	$valid_until=$sponsored['valid_until'];
	$sp_cat=$sponsored['category'];
	$offerdes=$sponsored['offer_description'];

	
	$sp=mysql_query("SELECT * FROM tbl_sponsorer WHERE `id`=$sp_id");
	$s=mysql_fetch_array($sp);

	$logo=$s['sp_img_path'];
	$company=$s['sp_company'];
	$address=$s['sp_address'];


?>
		<div class="col-xs-12 col-sm-4 col-md-3">
	  <div class="coup_box" style="">
	  <?php if(file_exists($logo)){ ?><img src="<?php echo $logo;?>" class="sp_logo img-responsive" style="height:83px;"/><?php } 
		else { ?><img src="image/newlogo1.png" class="sp_logo img-responsive" style="height:83px;"/><?php }  ?>
	  <?php if(file_exists($pro_img)){ ?><img src="<?php echo $pro_img;?>" class="sp_prod img-responsive"  style="height:140px;"/><?php }  
	   else { ?><img src="image/imgnotavl.png" class="sp_prod img-responsive"  style="height:140px;"/><?php }  ?>
	  <div class="coup_txtbox" >
	  <p class="couptxt1"><?php if($company!=""){  echo  "<font color=\"black\">".strtoupper($company)."</font>"; }else{ echo "<font color=\"red\"> NA </font>";} ?></p>
	  <p class="couptxt1"><?php echo strtoupper($product);?></p>
		   <p><span class="couptxt2"><?php if($discount!=0 or $discount!=0){ 
												echo $discount."% Off"; 
											} 
											if($buy!=0 and $buy_get!=0){ 
												if($discount!=0){ 
													echo ' Or ';
												} 
												echo 'Buy '.$buy.' Get '.$buy_get.' Free'; 
											} 
									?></span> <span class="couptxt3">(On <?php echo $ppp; ?> Points)</span></p>
		   <?php if($saving!=0){ ?><p class="couptxt4">SAVE  Rs. <?php echo $saving; ?>/-</p> <?php }else{?>
			<p class="couptxt4" style="visibility:hidden;">SAVE  Rs. <?php echo $saving; ?>/-</p><?php   } ?>
			<?php if($offerdes!=null){ ?><p><?php echo $offerdes; ?></p> <?php }else{?>
			<p style="visibility:hidden; padding:0px 5px 5px 5px;" ><?php echo $offerdes; ?></p><?php   } ?>
			<p align="left" style=" padding:0px 5px 5px 5px;">
			Product ID: <?php echo $cid;?><br/>
			Code#:<?php echo  $code; ?><br/>
			<!--<iframe src="html/BCGcode39.php?id=<?php echo $code; ?>" id="coupons" frameBorder="0" style="width:100%;height:80px;"/></iframe>
			Issued to: <?php echo $uname;?><br/>
			On: <?php echo $date;?></br>
			Time: <?php echo $tm;?></br>
			Valid Until: <?php echo $valid_until;?></br>
			<span >Address: <?php echo $address;?></p>
			
			<a href="mail_coupon.php?code=<?php echo $code; ?>&cp=<?php echo $cid; ?>"><button type="button" class="btn btn-default">Email</button></a>
			
		  <div class="clearfix" ></div>
		</div>
	  </div>
	</div>

</div></div></div>
-->
<?php


// multiple recipients
$to  = 'sudhirp@roseland.com';// . ', '; // note the comma
//$to .= 'wez@example.com';

// subject
$subject = 'Birthday Reminders for August';
$message = file_get_contents('view_print_coupons.php');
// message
/* 
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';
 */
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Sudhir <sudhirp@roseland.com>' . "\r\n";
$headers .= 'From: Sudhir Deshmukh <sudhirp@roseland.com>' . "\r\n";
$headers .= 'Cc: reshmak@roseland.com' . "\r\n";
$headers .= 'Bcc: sanjayg@roseland.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
?>
