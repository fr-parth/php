<script>
function really(sel_id,school_id){
	
	var y = confirm("You must be present at sponsor's place to use this coupon now.");
	if(y){
		window.location="<?php echo base_url(); ?>" + "/Ccoupon/use_now/"+sel_id+"/"+school_id;
	}
}
</script>
<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<button type="button" class='btn btn-violet' onclick="printDiv('printableArea')" >Print  <span class='glyphicon glyphicon-print'></span></button>
<?php if($userinfo[0]->email!=''){ ?>
  <a href='<?=site_url('Ccoupon/email_coupons');?>'><button type="button" class='btn btn-violet' value="Email Coupons" >Email <span class='glyphicon glyphicon-send'></span></button></button></a>
<?php  } 

$this->load->helper('imageurl');
//print_r($my_coupons);
/*VaibhavG => COUPON SHOWING CODE BLOCK => Removed below row div id='printableArea' & added hidden-print class for the ticket number SMC-3447 on 29Sept18
*/
echo "<div class='row hidden-print'>";
foreach($my_coupons as $key=>$value){
?>
	<div class="col-xs-12 col-sm-4 col-md-4" >
	  <div class="coup_box2" style="">
	 <img src="<?php echo imageurl($value->sp_img_path,'sclogo','sp_profile');?>" class="sp_logo img-responsive" style="height:83px;"/>
	  <div class="coup_txtbox" style="height:350px; padding-top:0px;" >	  
			<div class="box_content" style="text-align:left">
			<div class='row'>
				<div class='col-xs-12 col-sm-12 col-md-7'>
				Product ID:<?php echo $value->id; //.$dir.$qrfile.?><br/>Code :<b><?php echo strtoupper($value->code); ?></b>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3'>	
				<img src='<?php echo imageurl($value->code.'.png','','spqr');?>'>
				</div>
			</div>
			<p align="left" style="padding:0px 5px 5px 5px; ">
			<?php 	if($value->sp_company!=""){  
						echo  "<font color=\"black\">".strtoupper($value->sp_company)."</font><br/>"; 
					}else{ 
						echo "<font color=\"red\"> NA </font><br/>";
					} ?>
			<?php echo strtoupper($value->Sponser_product)."<br/>";?>
			<?php echo "On ".$value->points_per_product." Points<br/>";?>
			<strong>
			<?php if($value->discount!=0 or $value->discount!=0){ 
												echo $value->discount."% Off"; 
											} 
											if($value->buy!=0 and $value->get!=0){ 
												if($value->discount!=0){ 
													echo ' Or ';
												} 
												echo 'Buy '.$value->buy.' Get '.$value->get.' Free'; 
											} 
			?><br/>
			<?php if($value->saving!=0){ echo "Save ".$value->currency.' '.$value->saving."</br>";}?></strong>
			<?php if($value->offer_description!=""){ echo "Description: ".$value->offer_description."</br>";}?>
					
		
			<span style="font-size:11px">
			Issued To: <?php echo $userinfo[0]->name;?><br/>
			On: <?php echo $value->timestamp;?></br>			
			Valid Until: <?php echo $value->valid_until;?></br>
			Address:<?php echo $value->sp_address."</br>".$value->sp_city;?></span></p>	
			</div>
		  <div class="clearfix" ></div>
		  <div class="btn_use">
<button name="self_accept" id="self_accept" onClick="really('<?=$value->sel_id; ?>','<?=$userinfo[0]->school_id; ?>')" class="btn btn-primary visible-xs visible-sm hidden-print" style="margin-bottom: 0px;">Use Now</button>
		  </div>
		</div>
		
	  </div>
	</div>
<?php } 
echo "</div>";
//end code
//VaibhavG => COUPON PRINTING CODE BLOCK ONLY => added below hidden class for the ticket number SMC-3447 on 29Sept18
echo "<div class='row hidden-xs hidden-sm hidden-md hidden-lg' id='printableArea'>";
foreach($my_coupons as $key=>$value){
?>
<!--VaibhavG added below clearfix class and changed below col-xs-12 to col-xs-6 & add col-md-offset-4 for the ticket number SMC-3447 on 29Sept18-->
	<div class="clearfix" ></div>
	<div class="col-xs-6 col-sm-4 col-md-4 col-md-offset-4" >
	  <div class="coup_box2" style="">
	 <img src="<?php echo imageurl($value->sp_img_path,'sclogo','sp_profile');?>" class="sp_logo img-responsive" style="height:83px;"/>
	  <div class="coup_txtbox" style="height:350px; padding-top:0px;" >	  
			<div class="box_content" style="text-align:left">
			<div class='row'>
				<div class='col-xs-12 col-sm-12 col-md-7'>
				Product ID:<?php echo $value->id; //.$dir.$qrfile.?><br/>Code :<b><?php echo strtoupper($value->code); ?></b>
				</div>
				<div class='col-xs-12 col-sm-12 col-md-3'>	
				<img src='<?php echo imageurl($value->code.'.png','','spqr');?>'>
				</div>
			</div>
			<p align="left" style="padding:0px 5px 5px 5px; ">
			<?php 	if($value->sp_company!=""){  
						echo  "<font color=\"black\">".strtoupper($value->sp_company)."</font><br/>"; 
					}else{ 
						echo "<font color=\"red\"> NA </font><br/>";
					} ?>
			<?php echo strtoupper($value->Sponser_product)."<br/>";?>
			<?php echo "On ".$value->points_per_product." Points<br/>";?>
			<strong>
			<?php if($value->discount!=0 or $value->discount!=0){ 
												echo $value->discount."% Off"; 
											} 
											if($value->buy!=0 and $value->get!=0){ 
												if($value->discount!=0){ 
													echo ' Or ';
												} 
												echo 'Buy '.$value->buy.' Get '.$value->get.' Free'; 
											} 
			?><br/>
			<?php if($value->saving!=0){ echo "Save ".$value->currency.' '.$value->saving."</br>";}?></strong>
			<?php if($value->offer_description!=""){ echo "Description: ".$value->offer_description."</br>";}?>
					
		
			<span style="font-size:11px">
			Issued To: <?php echo $userinfo[0]->name;?><br/>
			On: <?php echo $value->timestamp;?></br>			
			Valid Until: <?php echo $value->valid_until;?></br>
			Address:<?php echo $value->sp_address."</br>".$value->sp_city;?></span></p>	
			</div>
		  <div class="clearfix" ></div>
		  <div class="btn_use">
<button name="self_accept" id="self_accept" onClick="really('<?=$value->sel_id; ?>','<?=$userinfo[0]->school_id; ?>')" class="btn btn-primary visible-xs visible-sm hidden-print" style="margin-bottom: 0px;">Use Now</button>
		  </div>
		</div>
		
	  </div>
	</div>
<?php } 
echo "</div>";
?>