<?php
error_reporting(0);
include_once ('function.php');
$smartcookie=new smartcookie();
	if(!isset($_SESSION['parent_id']))
	{
		header('location:login.php');
	}
	$id=$_SESSION['id'];
           $fields=array("id"=>$id);

		    $table="tbl_parent";
		   $smartcookie=new smartcookie();

$results=$smartcookie->retrive_individual($table,$fields);
//$result=mysql_fetch_array($results);
$row=mysql_query("select * from tbl_parent where Id='$id'");
$result=mysql_fetch_array($row);
	$p_img=$result['p_img_path'];
	$name=$result['Name'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>
<script>
$('#menu > li').click(function(e) {
    $('li.active').removeClass('active');
    var $this = $(this);
    if (!$this.hasClass('active')) {
        $this.addClass('active');
    }
    e.preventDefault();
});


</script>
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

.preview
{
border-radius:50% 50% 50% 50%;
height:100px;
box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}

</style>
</head>

<body>
<!-- header-->
<div class="container" align="center"  >
        <div class="row">
        		<div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;"><img src="image/Smart_Cookies_Logo001.jpg" width="100%" height="70" class="img-responsive" alt="Responsive image"/>
                </div>

              <div class="col-md-2 col-md-offset-5" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">

                 <?php if($p_img!=""){?>
                <img src="<?php echo $p_img;?>" width="60" height="60" style="border:1px solid #CCCCCC;" class="preview" alt="Image not available" />
                <?php // }else {?> <!--<img src="parent_image/avatar.png" width="60" height="60" style="border:1px solid #CCCCCC;" class="img-responsive" alt="Image not available"/>--> <?php }?>
                &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="background-color:#6C8CD5; padding-top:5px; background-color:#90C; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <b> <?php echo $name; ?></b>| <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;

                    </div>
                    <div  class="row" style="font-size:12px;">
                     	Member ID :<?php
						echo "P".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                        Parent Login
                    </div>
                </div>

        </div>
 </div>
 <div class=" navbar-inverse" role="navigation" style="background-color:#90C;width:100%;">

              <div class="container" >

                <div class="navbar-header">

                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                  </button>


                </div>

                <div class="collapse navbar-collapse" id="menu" style="border-color:#428BCA;">

                  <ul id="header-menu" class="nav navbar-nav navbar-right">

                    <li  style="color:#FFFFF;"><a href="purchase_point.php">Home</a></li>

                    <li ><a href="child.php">Child</a></li>


                        <li ><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Points</a>
                             <ul class="dropdown-menu">

                                  <li><a href="parent_listof_teacher.php">Assign Blue points to Teacher</a></li>
								  <li><a href="parent_listof_student.php">Assign Purple points to Student</a></li>

                              </ul></li>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Purchase Water Points</a>
                             <ul class="dropdown-menu">

							       <li><a href="parent_greenpoint_coupon.php">Water points Giftcard</a></li>
                                  <!--<li><a href="parent_greenpoint_coupon.php">Purple points coupons</a></li>
                                  <li><a href="parent_bluepoint_coupon.php">Blue points coupons</a></li>-->

                              </ul></li>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log</a>
                             <ul class="dropdown-menu">

                                  <li><a href="parent_greenpoint_log.php">Purple points Log</a></li>
                                  <li><a href="parent_bluepoint_log.php">Blue points Log</a></li>

                                      <li><a href="water_giftcard_log.php">Water points Giftcard Log</a></li>
																			<li><a href="received_proud_points.php">Parent Proud Points Log</a></li>
                                      <!--<li><a href="bluepointcoupon.php">Blue points Coupon Log</a></li>-->

                              </ul></li>
                     <li><a href="update_parent_profile.php">Profile</a></li>
                     <li><a href="parent_sponsor_map.php">Sponsor Map</a></li>
					  <li><a href="top10_stud_parent.php">Leaderboard</a></li>

                  </ul>

               </div> <!-- /.nav-collapse -->

              </div> <!-- /.container -->

            </div>
            </body>
            </html>

<!--<div align="center">
    <div style="width:1002px; height:75px;">

        <div>
            <div style="float:left; padding:10px; font-size:21px; font-weight:bold;"><img src="image/Smart_Cookies_Logo001.jpg" width="100" height="70" /></div>
            <div>
            <div style="float:left; padding:5px; width:450px;" align="center">
               <h2 style="color:#428BCA;"></h2>
                &nbsp;
                </div>
            <div style="padding-right:10px;" align="right">
            	<div style="float:left; padding:5px; width:100px;" align="left">
                <?php if($p_img!=""){?>
                <img src="<?php echo $p_img;?>" width="60" height="60" style="border:1px solid #CCCCCC;" />
                <?php }else {?> <img src="image/avatar_2x.png" width="60" height="60" style="border:1px solid #CCCCCC;" /> <?php }?>
                &nbsp;
                </div>

                <div>
                    <div style="width:250px; height:30px;background-color:#9900CC; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">

                     <div>  Welcome <b><?php echo $name; ?> </b>| <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;</div>

                    </div>
                     <div style="font-size:12px;font-weight:bold;">  Parent Login </div>
                    <div  style="font-size:12px;height:30px;margin-top:4px;font-weight:bold;">
                     	Userid :<?php
						echo "M".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                   <!-- <div style="padding-right:10px; height:10px; padding-bottom:7px; font-weight:bold;font-size:12px;">
                        SPONSOR LOGIN
                    </div>-->
                </div>
            </div>

        </div>

    </div>
</div>



</body>
</html>
