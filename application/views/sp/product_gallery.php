<?php $this->load->view('sp/header');

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
 <style>
 .mainclass{
	 height:420px;
 width:260px;
 border-style:solid;
 margin-top:50px;
 margin-left:10px;
 margin-bottom:50px; 
 margin-right:50px;
 padding-top:5px;
  padding-bottom:5px;
 
}
.product{
	color:#000; 
	font-weight:bold;
}
.details{
	color:#000; 
	font-weight:bold;
	font-family:Times New Roman;
	font-size:20px;
	padding-top:5px;
}
.custom_box{
	
	 height:120px;
 width:240px;
 padding-top:10px;
 color:black;
 
}

</style>
</head>
<body>

    <h2 class="product">Product Gallery</h2>
	<hr style="height:1px;border:none;color:#333;background-color:#333;" />
 
    <div class="container">
		<div class="row">
			<!--<div class="col-md-3" style= "height:100%;width:10%; border-style: solid;">-->
		<?php
			$i=1;
			foreach($product_details as $key)
			{
		?>
			<a href="product_gallery_zoom">
			<div class="col-md-2 mainclass details" >
				<center><img src="<?php if($key->product_image!=''):echo base_url().'Assets/images/sp/productimage/'.$key->product_image;  else: echo base_url().'Assets/images/avatar/avatar_2x.png'; endif;?>"  width="220" height="200" style="padding-top:10px;"></center><br>
				<div class ='custom_box' >
					Product Name: <?php echo $key->Sponser_product; ?><br><br>

					Price: <?php echo $key->currency; ?> <?php echo $key->product_price; ?><br><br>
					
					Discount(%): <?php echo $key->discount ;?><br><br>
					
					Points: <?php echo $key->points_per_product;?><br><br>
				</div></a>
					<br><br><p style ="color:black;"align='center'><?php echo $i;$i++; ?></p>		
			</div>	<?php	}?><br>

		</div>
	</div>
	
  </body>
</html>