<?php $this->load->view('sp/header'); 

//print_r($user); //echo "<hr/>"; //print_r($cdata); 

if(!empty($cdata->price) && !empty($cdata->discount)){ $saving=$cdata->price*($cdata->discount/100); }else{ $saving=0; }  // if price an discount set then 
if(!empty($cdata->buy) && !empty($cdata->buy_get)){ $saving=$cdata->buy_get*$cdata->price; }else{ $saving=0; } 

//echo $cdata->up;
?>
<?php $this->load->helper('imageurl'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Preview Coupon</h2>
			</div>
		</div>	
	</div>
<div class="col-xs-12 col-sm-4 col-md-3">
	<div class="coup_box">	
	
<a href="<?php if($user[0]->sp_website!=""){ ?>http://<?php echo htmlspecialchars(urlencode($user[0]->sp_website)); } ?>" target='_blank' >
	<img src="<?php echo imageurl($user[0]->sp_img_path,'sclogo','sp_profile'); ?>" class="sp_logo img-responsive" style="height:83px;" />
</a>
		
		<img src="<?php echo imageurl($cdata->file_name,'','product');?>" class="sp_prod img-responsive"  style="height:140px;"/>
		
		<div class="coup_txtbox" ><p class="couptxt1"><?php if($user[0]->sp_company!=""){  echo  "<font color=\"black\">".strtoupper($user[0]->sp_company)."</font>"; }else{ ?> <p class="couptxt1" style="visibility:hidden;" >NA</p> <?php } ?></p>
		<?php if($cdata->name!=""){ ?>
		<p class="couptxt1"><?php echo strtoupper($cdata->name);?></p>
		<?php } else { ?>
		<p class="couptxt1" style="visibility:hidden;" >NA</p>
		<?php } ?>
		<p><span class="couptxt2"><?php if($cdata->discount!=0 or $cdata->discount!=0){ 
		echo $cdata->discount."% Off"; 
		} 
		if($cdata->buy!=0 and $cdata->buy_get!=0){ 
		if($cdata->discount!=0){ 
		echo ' Or ';
		} 
		echo 'Buy '.$cdata->buy.' Get '.$cdata->buy_get.' Free'; 
		} 
		?></span> <br />
		<?php if($cdata->price!=""){ ?>
		<span class="couptxt3">MRP: <?php echo $cdata->currency_value[0]->currency." ".$cdata->price; ?>/-</span><br />
		<?php }else{ ?>
		<span class="couptxt3"  style="visibility:hidden;">MRP: <?php echo $cdata->currency." ".$cdata->price; ?>/-</span><br />
		<?php } ?>
		<span class="couptxt3">(on <?php echo $cdata->points; ?> points)</span></p>
		<?php if($saving!=0){ ?><p class="couptxt4">SAVE   <?php echo $cdata->currency." ".$saving; ?>/-</p> <?php }else{?>
		<p class="couptxt4" style="visibility:hidden;">SAVE <?php echo $cdata->currency." ".$saving; ?>/-</p>
		<?php   } ?>
		<p>
		<button type="button" class="catbtn"  data-container="body" data-toggle="popover" data-placement="top" 
		data-viewport="" data-trigger="focus"
		data-html="true" data-content="<?php 
		if($cdata->enddate!=""){ echo "Valid Until: <strong>".$cdata->enddate."</strong><br/>"; } ?>
				Today's Limit: <?=($cdata->total_coupons==0)?"unlimited":$cdata->daily_limit;?>
				Total Coupons Left: <?=($cdata->total_coupons==0)?"unlimited":$cdata->total_coupons;?>	
		<?php
		if($cdata->offer_description!=""){ echo "Description: ".$cdata->offer_description."<br/>"; }
		if($user[0]->sp_address!=""){ echo "Address: ".$user[0]->sp_address."<br/>"; }
		if($user[0]->sp_city!=""){ echo "City: ".$user[0]->sp_city."<br/>"; }
		if($user[0]->sp_state!=""){ echo "State: ".$user[0]->sp_state."<br/>"; }
		if($user[0]->sp_country!=""){ echo "Country: ".$user[0]->sp_country."<br/>"; }
		if($user[0]->sp_email!=""){ echo "Email: ".$user[0]->sp_email."<br/>"; }if($user[0]->sp_website!=""){ ?><a href='http://<?php echo $user[0]->sp_website; ?>' target='_blank' ><strong><?php echo $user[0]->sp_website; ?></a></strong> 
		<?php } ?> "> Description</button>	  						   
		<input type="submit" name="select" value="Select" class="getcoubtn" disabled /></p>
		
		<div class="clearfix" ></div>
		</div>
	</div>
</div> 
					<div class="col-md-9">
						<div class="panel panel-default">
							<div class="panel-body">
								<h4>Summary</h4>
<!--changes done by Pranali for bug SMC-3366 -->
								<p>Product Name: <?php echo $name=isset($cdata->name)? $cdata->name:''; ?><br/>
								Product Category: <?php echo $category=isset($cdata->category_value[0]->category)? $cdata->category_value[0]->category:''; ?><br/>
								Start Date: <?php echo $startdate= isset($cdata->startdate)? $cdata->startdate:''; ?><br/>
								End Date: <?php echo $enddate=isset($cdata->enddate)?$cdata->enddate:''; ?><br/>
								Points: <?php echo $points= isset($cdata->points) ? $cdata->points: ''; ?><br/>
								Product MRP: <?php echo $cdata->currency_value[0]->currency.' '.$cdata->price; ?><br/>
								Discount: <?php echo $discount= isset($cdata->discount) ?$cdata->discount :'' ; ?>%<br/>
								Buy: <?php echo $buy= isset($cdata->buy) ? $cdata->buy :'' ; ?> Get <?php echo $buyget= isset($cdata->buy_get) ? $cdata->buy_get :''; ?><br/>
								Offer Description: <?php echo $offer=isset($cdata->offer_description) ? $cdata->offer_description :''; ?><br/>
				Daily Coupon Accepting Limit: <?=($cdata->total_coupons==0)?"unlimited":$cdata->daily_limit;?><br/>
				Total Number of Coupons: <?=($cdata->total_coupons==0)?"unlimited":$cdata->total_coupons;?><br/>
								Unique Coupon Code (if Set): <?php echo $uniquecode=isset($cdata->uniquecode) ? $cdata->uniquecode : ''; ?><br/>
							</div>
							<!--changes end -->
						</div>
					</div>
					<a href="<?php echo site_url('Csponsor/page/log_generated_coupons'); ?>"><button class="btn btn-success">Next</button></a>
</div> 