<?php 
$this->load->helper('imageurl');
//print_r($my_coupons);
echo "<div class='row' id='printableArea'>";
foreach($my_coupons as $key=>$value){
?>
	<div class="col-xs-12 col-sm-4 col-md-3" style='width: 30%;' >
	  <div class="coup_box2" style="background: #FFF none repeat scroll 0% 0%;
border: 1px solid #C1C0C0;
text-align: center;
margin-bottom: 20px;
padding: 10px;">
	 <img src="<?php echo imageurl($value->sp_img_path,'sclogo');?>" class="sp_logo img-responsive" style="    padding-bottom: 6px;
    width: 100%;     display: block;
    max-width: 100%; height:83px;"/>
	  <div class="coup_txtbox" style="padding: 14px 0px 18px 0px; height:300px;" >	  
			<div class="box_content" style="margin: 0px;
min-height: 300px;
padding: 0px; text-align:left">
			<table>
				<tr>
				<td>Product ID:<?php echo $value->id; //.$dir.$qrfile.?><br/>Code#:<br/><b><?php echo strtoupper($value->code); ?></b></td>
				<td><img src='<?php echo base_url('/Assets/images/sp/coupon_qr/'.$value->code.'.png');?>'></td>
				</tr>
			</table>
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
			<?php if($value->saving!=0){ echo "Save ".$value->currency.' '.$value->saving."<br/>";}?></strong>
			<?php if($value->offer_description!=""){ echo "Description: ".$value->offer_description."<br/>";}?>
					
		
			<span style="font-size:11px">
			Issued To: <?php echo $userinfo[0]->name;?><br/>
			On: <?php echo $value->timestamp;?><br/>			
			Valid Until: <?php echo $value->valid_until;?><br/>
			Address:<?php echo $value->sp_address."<br/>".$value->sp_city;?></span></p>	
			</div>
		  <div class="clearfix" ></div>
		</div>
		
	  </div>
	</div>
<?php } 
echo "</div>";
?>