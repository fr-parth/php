<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Smartcookie Sponsor</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>application/views/Sponsor_Gallary/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>application/views/Sponsor_Gallary/css/shop-homepage.css" rel="stylesheet">
	<style>
	body {
        background-image: url("<?php echo base_url();?>application/views/Sponsor_Gallary/img/purty_wood.png");
}
	</style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="">
      <div class="container">
        <a class="navbar-brand" href="http://smartcookie.in/">
		<img src="<?php echo base_url();?>application/views/Sponsor_Gallary/img/250_86.png"  style=" width: 150px;" alt="logo" /></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">
			
          <h1 class="my-4" face="verdana" ><?php foreach ($user as $key){echo $key->sp_company;}?></h1>
       

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-12">

          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="https://static.pexels.com/photos/248797/pexels-photo-248797.jpeg" alt="First slide">
              </div>
              <!-- <div class="carousel-item">
               <img class="d-block img-fluid" src="<?php //echo base_url();?>application/views/Sponsor_Gallary/img/smartcookie_img2.jpg" alt="Second slide">
              </div>-->
              <div class="carousel-item">
                <img class="d-block img-fluid" src="https://static.pexels.com/photos/248797/pexels-photo-248797.jpeg" alt="Second slide">
              </div>
			  <div class="carousel-item">
                <img class="d-block img-fluid" src="https://static.pexels.com/photos/248797/pexels-photo-248797.jpeg" alt="Third slide">
              </div>
			  
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

          <div class="row">
				<?php
						$i=1;
						foreach($product_details as $key)
						{
				?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href="#"><img class="card-img-top" src="<?php if($key->product_image!=''):echo base_url().'Assets/images/sp/productimage/'.$key->product_image;  else: echo base_url().'Assets/images/avatar/avatar_2x.png'; endif;?>" height="300" alt=""></a>
                <div class="card-body">
                  
                  <h5>Discount(%): <?php echo $key->discount; ?></h5>
                  <p class="card-text">
					<b>Product Name: <?php echo $key->Sponser_product; ?><br>
					Points: <?php echo $key->points_per_product; ?><br>
                    Price: <?php echo $key->product_price; ?></b><br>
				  </p>
                </div>
                <div class="card-footer">
                  <h4 class="card-title">
                    <center><?php echo $i;?></center>
					
                  </h4>
                </div>
              </div>
            </div>
						<?php $i++;}?>

          </div>
          <!-- /.row -->

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->
	<div class="card-body">
	<div class="col-md-4">
            <form>
            <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
            <address>
                
				<?php
				foreach($user as $key)
				{
					echo $key->sp_address;?><br>
					<?php echo $key->sp_city;?><br>
					<?php echo $key->sp_country;?><br>
				
				
            </address>
            <address>
                <strong><?php echo $key->sp_name;?></strong><br>
                <a id="webname"><?php echo $key->sp_website;?></a>
				<?php
				}
				?>
            </address>
            </form>
        </div>
</div>
    <!-- Footer -->
    <footer class=" bg-dark" style="hight: 100px;">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; www.smartcookie.in 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url();?>application/views/Sponsor_Gallary/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>application/views/Sponsor_Gallary/vendor/popper/popper.min.js"></script>
    <script src="<?php echo base_url();?>application/views/Sponsor_Gallary/vendor/bootstrap/js/bootstrap.min.js"></script>
  </body>

</html>
<script>
$(document).ready(function(){
 $("#webname").on("click" , function() {
	var webname=$("#webname").text();
	window.open(""+ webname +"")
	//window.open("<?php echo base_url();?>/application/views/Sponsor_Gallary/sponsor.php")
   });
})
</script>
