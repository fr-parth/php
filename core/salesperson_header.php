<?php
include ('function.php');
$smartcookie=new smartcookie();
	if(!isset($_SESSION['salespersonid']))
	{
		header('location:index.php');
	}
	
	$id=$_SESSION['salespersonid'];
           $fields=array("person_id"=>$id);
		   $table="tbl_salesperson";
		   
		
		   
$result=$smartcookie->retrive_individual($table,$fields);
$saleperson=mysql_fetch_array($result);
	$fname = $saleperson['p_name'];
	$sp_img_path=$saleperson['p_image'];
	
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies::Sponsor</title>
 <link rel="stylesheet" href="bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>
<style>
.carousel {
    height: 300px;
    margin-bottom: 50px;
}
.carousel-caption {
    z-index: 10;
}
.carousel .item {
    background-color: rgba(0, 0, 0, 0.8);
    height: 300px;
}

.navbar-inverse .navbar-nav>li>a {
color: #FFFFFF;
font-weight:bold;
}
.navbar-inverse{
  
    border-color:#FFFFFF;
}
.navin-main .navbar-nav > li > a{padding-top:8px  !important; padding-bottom:8px !important;}
.drop-header{
	font-weight:bold;
	color:#000;
}
</style>
	
    
</head>

<body>
<!-- header-->
<div class="container"  align="center" >
		
        <div class="row">
        		<div class="col-md-2" class="pull-left" style="padding:10px;">
				<img src="images/logo.png" />
                </div>
                 <div  class="col-md-3" style=" padding:5px;" align="center">
             
              
             </div>
			 
              <div class="col-md-3" style="padding-right:10px;" >
            	<div style="" align="center">
                <?php if(file_exists($sp_img_path)){?>
                <img src="<?php echo $sp_img_path;?>"   style="height:90px; width:150.5px;" class="img-responsive" alt="Responsive image"/>
                <?php }else {?> <img src="image/avatar_2x.png"  style="height:90px;" class="img-responsive" alt="Responsive image"/><?php }?>
		              </div>
			</div>
             <div class="col-md-4">
                    <div class="row" style="background-color:#7C3826; padding-top:5px; border-radius: 3px 3px 5px 5px; margin-bottom:5px; margin-top:-2px; color:#FFFFFF;">
                       Welcome <b> <?php echo $fname; ?> </b>| <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    <div  class="row" style="">
                     	Member ID :<?php 
						echo "SL".str_pad($_SESSION['salespersonid'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;">
                        <p><b>Sponsor Login</b></p>
                        
                    </div>
					
          </div>
       
        </div>
 </div>      
        
      
            <div class=" navbar-inverse navin-main" role="navigation" style="background-color:#7C3826; width:100%; font-size: 14px;">
            
              <div class="container" >
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#6C8CD5;background-color:#7C3826;">
             	<!--  #6C8CD5-->
                  <ul class="nav navbar-nav navbar-right">
				  <li><a href="home_salesperson.php">Sponsor Registration</a></li>
                               
				 <li><a href="registered_sponsors_list.php">Registered Sponsors</a>
                            
                    </li>                    
				
                   
                     <li><a href="Salesperson_map.php">Sponsor Map</a></li>
                    
                 
            
                  </ul>
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
        




