<?php
 $this->load->view('sp/header');
 
?>


<html>
<head>
<style>
.panel
{

 height:100%;
 width:100%;	
}
.logo
{

 height:100%;
 width:20%;

}
.second
{

 height:25%;
 width:100%;	
}
.sponsor_img
{

 height:100%;
 width:20%;
 border-style:solid;
 color:black;
}
.sponsor_img1
{

 height:100%;
 width:40%;
 float:left;
margin-top:-130px;
 margin-left: 223px;
font-weight:bold;
color:black;
padding-left:10px;

}

.sponsor_special
{
 border-style:solid;
 height:150%;
 width:30%;
 float:right;
 margin-top:-245;
 color:black;
 margin-top:-114px;
 margin-right:69px;
 min-height: 100%;
}
.third
{

 height:30%;
 width:100%;	
}
.mainclass{
	 height:420px;
 width:290px;
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
 width:260px;
 padding-top:10px;
 color:black;
 
}
.header{
	color:black;
	font-family:Times New Roman;
	font-weight:bold;
	padding-top:7px;
	border-style:solid;
	width:50%;
	height:50px;
}
.rolling{
border-style:solid;
 height:150%;
 width:30%;
 color:black;
}



</style>
</head>
<body>
<div class="panel">
	<center><h2 class="header">Proud Sponsor of SmartCookie   </h2></center>
	<div class="logo">
		<img src="<?php echo base_url().'core/Images/logo1.png' ?>"   style=" padding-left:10px;">
	</div>

	<div class="second">
		<?php
		foreach($user as $u)
		{?>
		<br>
		<div class="sponsor_img">
			<img src="<?php if($u->sp_img_path!=''):echo base_url().'core/'.$u->sp_img_path;  else: echo base_url().'Assets/images/avatar/avatar_2x.png'; endif;?>"  width="100%" height="100%">
		</div>
		<div class="sponsor_img1">
			Shop Name: <?php echo $u->sp_company;?> <br><br> 
			Address:<?php echo $u->sp_address;?><br><br>
			Email: <?php echo $u->sp_email;?><br><br>
			Phone No:  <?php echo $u->sp_phone;?><br>
			<a href="<?php echo site_url('Csponsor/page/sponsor_map'); ?>">
				<span class="glyphicon glyphicon-map-marker"></span> Map
			</a>
		</div>
		<div class="sponsor_special" style="">
			<center><b>Specials offer</b></center>
			<center>
				<?php
					foreach($rolling_messages as $msg)
					{
						echo $msg->field_message;
					}
				?>
			</center>
		</div>
		<?php }?>
	</div>


	<div class="third">
		<br><br>
		<h3 style="text-align:center; color:black;"><b>Products<b></h3>
		<?php
			$i=1;
			foreach($product_details as $key)
			{
		?>
				<div class="col-md-2 mainclass details" >
					<center><img src="<?php if($key->product_image!=''):echo base_url().'Assets/images/sp/productimage/'.$key->product_image;  else: echo base_url().'Assets/images/avatar/avatar_2x.png'; endif;?>"  width="220" height="200" style="padding-top:10px;"></center><br>
					<div class ='custom_box' >
						Product_Name: <?php echo $key->Sponser_product; ?><br><br>
						Price: <?php echo $key->currency; ?> <?php echo $key->product_price; ?> <br><br>
						Discount(%): <?php echo $key->discount ;?><br><br>
						Points: <?php echo $key->points_per_product;?><br><br>
					</div>
						<br><br><p style ="color:black;"align='center'><?php echo $i;$i++; ?></p>		
				</div>	
		<?php	}?><br>
	</div >
 

	<div style="color:black; font-size:15px; padding:10px; ">
		<marquee>
		<?php
			 foreach($rolling_messages as $msg)
			{
				 echo $msg->rolling_message;
			}
		?>
		</marquee>
	</div>

</div>
</body>
</html>
<?php //$this->load->view('sp/footer');?>