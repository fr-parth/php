<?php
//Below variables added by Rutuja Jori
$webHost = $_SERVER['SERVER_NAME'];
  $_SESSION['webHost']=$webHost;

 $isSmartCookie=strpos($webHost, 'cookie')==true;
 $_SESSION['isSmartCookie']=$isSmartCookie;

$url_old='core/login.php';
$url_old_otp='core/otpFormLogin.php';

//$url_new='http://test.smartcookie.in/Welcome/login/';
$url_new=base_url('Clogin/login/');
$url_new_otp=base_url('LoginOTP/OTPLoginForm/');
date_default_timezone_set('ASIA/KOLKATA');

// phpinfo();
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <!--====== USEFULL META ======-->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Smart Cookie, AICTE 360 Degree Feedback " />
    <meta name="keywords" content="Smart Cookie, AICTE, 360 Degree Feedback, AICTE 360" />

    <!--====== TITLE TAG ======-->
    <title><?php if($isSmartCookie){ ?>
    :: Smart Cookie::
        <?php  }else{  ?>
        :: Protsahan-Bharati::
        <?php } ?></title>

    <!--====== FAVICON ICON =======-->
    <link rel="shortcut icon" type="image/ico" href="rkassets/img/favicon.png" />

    <!--====== STYLESHEETS ======-->
    <link href="rkassets/css/plugins.css" rel="stylesheet">
    <link href="rkassets/css/plugins/bx-slider.css" rel="stylesheet">
    <link href="rkassets/css/theme.css" rel="stylesheet">
    <link href="rkassets/css/icons.css" rel="stylesheet">

    <!--====== MAIN STYLESHEETS ======-->
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="rkassets/css/materialdesignicons.min.css">
    <link href="rkassets/css/responsive.css" rel="stylesheet">

    <script src="rkassets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        function fnloginadmin(){
            var url = "https://smartcookie.in/core/login.php";
            document.loginform.action = url;
            document.forms["loginform"].submit();  
        }

        function fnactivateschool(){
            var url = "https://smartcookie.in/core/activate_school.php";
            document.loginform.action = url;
            document.forms["loginform"].submit();     
        }  
          function handleSelect(elm)
  {
    window.location = elm.value+".php";
}  
    </script>
    
   <style type="text/css">
    .welcome-area
    {
        margin-top: 0px;
    }
    marquee{
        margin-top: 100px;
  color: #dd4b39;
  font-weight: 2em;
height: 35px;
}

marquee>span{ margin-right:"80px"}
marquee:hover{
  background-color:rgb(161, 147, 191);
cursor: pointer;
color:white;
}
    .clients1
{
    margin-top: 790px;
}
.clients
{
    margin-top: 0px;
}
.clients2
{
    margin-top: 220px;
}
       .column:hover {
        background-color:#ADD8E6;
    /*background-color: #00ffd5;*/
    
}
.help_link
 {
    height: 50px;
    width: 100%;
    background-color: lightgray;
    color: black;
 }
 .addli1{
            float: left;
        }
        ul {
 list-style-type: none;
}


ul li {
  
  margin: 5px;
}
.meeting
{
   
    margin-top: -480px;
    margin-left: 750px;
  border: 3px solid pink;
}
.meeting1
{
    margin-top: -480px;
    border: 3px solid pink;
    margin-left:950px;
    /*box-shadow: rgba(240, 46, 170, 0.4) 5px 5px, rgba(240, 46, 170, 0.3) 10px 10px, rgba(240, 46, 170, 0.2) 15px 15px, rgba(240, 46, 170, 0.1) 20px 20px, rgba(240, 46, 170, 0.05) 25px 25px;*/
}
.img_SLIDE
{
   width:45%;
   height: 80%;
    float: right;
    margin-top: -150px;
}

/*.appimg
{
    margin-top: 900px;
}*/
.ab{
      width: 150px;
      padding:2px;
      /* border-style: solid; */
      /* border-color: rgb(1, 3, 10); */
      /*display:inline;*/
    }
.img1 img{
      margin:10px 15px;
      width: 350px;
      height: 150px;
      padding: 2px;
      margin-left: 0px;
     /* border-radius: 25px;*/
      display:inline;
    }
    .img1 p{
      /*margin:2px 20px;*/
      margin-left:2px 150px;
      width: 150px;
      font-family: 'Zen Antique', serif;
      padding-bottom: 20px;
      line-height: 1.5;
      font-weight: 10;
      font-size: 20px;
      text-align: center;
    }
    .img1 a{
      margin-left: 0px;
      width: 150px;
        cursor: pointer;
        text-decoration: none;

    }
.img1 i{
      font-size: 4rem;
      color: rgb(8, 35, 95);
      margin-left: 0px;

    }
 
   </style>
   
</head>

<body class="home-two" data-spy="scroll" data-target=".mainmenu-area" data-offset="90">

    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please upgrade your browser to improve your experience.</p>
    <![endif]-->

    <!--- PRELOADER -->
    <div class="preeloader">
        <div class="preloader-spinner"></div>
    </div>

    <?php 
    //include("core/conn.php");
    include("core/connsqli.php");
        // $host="smartcookieprod.cdx8cgsuynp2.ap-south-1.rds.amazonaws.com"; /* Host name */
        // $username="scarora"; /* Mysql username */
        // $password="fU&HwDgP?d4";  Mysql password 
        // $db_name="ebdb"; /* Database name */
        // $conn = mysqli_connect( $host, $username, $password, $db_name)or die("cannot connect");
        // mysqli_select_db($conn, $db_name)or die("cannot select DB");
        $group_member_id=$_SESSION['group_admin_id'];
        // $group_member_id='91';
        $whereSQL1 = "and school_id not like 'GRP%' and school_id!='COTP' and img_path<>''";
    ?>

    <!--SCROLL TO TOP-->
    <a href="#scroolup" class="scrolltotop"><i class="fa fa-long-arrow-up"></i></a>

    <!--START TOP AREA-->
    <header class="top-area" id="home">
        <div class="header-top-area" id="scroolup">
            <!--MAINMENU AREA-->
            <div class="mainmenu-area" id="mainmenu-area">
                <div class="mainmenu-area-bg"></div>
                <nav class="navbar">
                    <div class="container">
                        <div class="navbar-header">
                            <?php if($isSmartCookie){ ?>
                            <a href="main.php" class="navbar-brand"><img src="rkassets/img/logo.png" alt="logo"></a>
                             <?php  }else{  ?>
                                 <a href="main.php" class="navbar-brand" style="margin-top:-20px;width: 100px;"><img src="<?php echo base_url();?>rkassets/img/plogo.jpeg" alt="logo"></a>
                                   <?php } ?>
                        </div>
                        <div class="mainmenu-and-right-button">
                            <div id="main-nav" class="stellarnav">
                                <ul id="nav" class="nav navbar-nav">
                                    <li class="active"><a href="#home">Home</a></li>
                                    <li><a href="#target1">Team</a></li>
                                    <li><a href="#team">Login As</a></li>
                                    <li><a href="#news">Products</a></li>
                                    <li><a href="#sponsor">Our Sponsors</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                    <li><a href="<?php echo base_url('core/express_registration_sp.php'); ?>">Register</a></li>
                                    <li><a href="#">
                                        <!-- <div class='col-md-2' style="margin-top:30px;"> -->
                                        <select name="formal" onchange="javascript:handleSelect(this)">
                                            <option value="#"><i class="fa fa-search" aria-hidden="true"></i>Find</option>
                                            <option value="college_id/home">Find College id</option>
                                            <option value="core/otpForm">Find member id</option>
                                         </select>
                                        <!-- </div> -->
                                    </a></li>
                       
                                </ul>
                            </div>
                         
                        </div>
                    </div>
                </nav>
            </div>
            <!--END MAINMENU AREA END-->
        </div>
        
    </header>
    
<marquee onmouseover="this.stop();" onmouseout="this.start();" width="98%" direction="left" height="30px" style="font-size: 2em;">
            <b style="font-size:20px; font-family: 'Times New Roman', serif;">College students! Are you looking for internship where you can do meaningful things that make a difference 
            in your career. <a href="https://www.startupworld.in/register.php" target="_blank">Register Here</a></b>
        </marquee>
    <div class="container">
        <div class="row">
            
            <div class="welcome-area">
                <div class="welcome-text">
                    <h1 class="color_grad wow fadeInUp" data-wow-delay="0.2s">About Smart Cookie</h1>
                    <p class="wow fadeInUp" data-wow-delay="0.3s">Smart Cookie / Protsahan Bharti is a Student-Teacher Reward Program. It is a process of providing "Just in Time" Rewards for the encouragement of Students and Teachers to bring out the Best in them.</p>

                        <div class="home-button">
                       <a class="read-more" href="<?php echo base_url()."".'core/about-us.php';?>">Know More</a>    
                    </div>

                     <div class="home" style="margin-left: 200px;margin-top: -60px;
">
                       <a class="btn btn-warning btn-lg" style="height:80px;width: 200px;border-radius: 35px;font-size: 19px;" href="https://helpdesk.smartcookie.in/" target="_blank">Click Here For <br> Helpdesk Chat </a>    
                    </div>
                    
                </div>
            </div>
            
                <div class="right-image img_SLIDE">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">                 
                        <div class="carousel-inner slide">
                            <div class="item active">
                              <img src="rkassets/img/is1.jpg" alt="Slide1">
                            </div>
                            <div class="item">
                              <img src="rkassets/img/is2.jpg" alt="Slide2">
                            </div>
                            <div class="item">
                              <img src="rkassets/img/is3.jpg" alt="Slide3">
                            </div>
                            <div class="item">
                              <img src="rkassets/img/is4.jpg" alt="Slide4">
                            </div>
                            <div class="item">
                              <img src="rkassets/img/is5.jpg" alt="Slide5">
                            </div>
                        </div>
                             <!-- <img src="rkassets/img/home/home-mockup.png" alt=""> -->
                    </div>
                </div>
                
           <!--  </div>

        </div> -->

    </div>   
       <!--  <div class="row" id="divother" style="display: none;">
            <form method="POST" id="loginform" name="loginform">
                <div class="col-md-4">
                    School Admin
                    <input class="form-control" type="text" name="entity" value="1">
                </div>
            </form>
        </div>
    </div> -->
    
  <section class="client-area no-padding wow fadeIn" style="margin-top:90px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 Join">
                   <!--  <div class="area-title text-center">
                        <h2><div class="area-title text-center">
                        <h2>College Lists</h2>
                    </div></h2>
                    </div> -->
                    <div class="client-list client-slider">
                        <?php
                            $sql_schoolimg = "SELECT school_name,img_path FROM tbl_school_admin where img_path!='' and group_member_id='".$group_member_id."'".$whereSQL1." Order by RAND() Limit 30" ;
                            $result=mysqli_query($conn, $sql_schoolimg);
                            $schoolarr = array();
                            $schoolcnt=0;
                            $url=base_url()."".'core/';
                            //$url="https://smartcookie.in/core/";
                            while($row = mysqli_fetch_assoc($result)) {
                                // $schoolarr = array_merge($schoolarr, array( "School Name" => $row['school_name'],"Image" => $row['img_path']));
                                echo '<div class="single-client"><img src="'.$url.'/'.$row["img_path"].'" alt="'.$row["school_name"].'" title="'.$row["school_name"].'"><?= $row["school_name"]; ?></div>';
                                $schoolcnt++;
                            }
                        ?>
                       
                       <!--  <div class="single-client"><img src="rkassets/img/client/client-6.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-7.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-8.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-9.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-10.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-11.png" alt=""></div>
                        <div class="single-client"><img src="rkassets/img/client/client-12.png" alt=""></div>
                        <div  class="single-client"><img src="rkassets/img/client/client-13.png" alt=""></div> -->
                    </div>
                </div>
               
            </div>
        </div>
    </section>

 <!-- ==================================================
                            vision-area
      ================================================== -->
    <section class="vision-area padding-top-0-20">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2 style="margin-top:-160px;">How Smart Cookie Works?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12">
                    </div>
                
                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                        <iframe height="350" style="margin-top:-100px;" src="https://www.youtube.com/embed/wOEz5ez1vHQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
            </div>
        </div>
                   <!--  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <h2 class="box-title"><a href="#">How Smart Cookie Works?</a></h2>
                    </div> -->
        <!-- </div> -->
    </section>
  <section class="team-area padding-top wow fadeIn">
        <div class="container" id="target1">
            <div class="row"  style="margin-top: -600px;">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2>We Have A Awesome Team.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row team-slider no-margin">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/avikulkarni.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Avinash Kulkarni</a><br>
                                <span class="d_block transition_3s">Founder & CEO - Smart Cookie</span><br>
                                <span class="line d_block transition_3s"></span><br>
                                <a href="tel:+19735515593" class="mobile_number transition_3s">+1 973 551 5593</a>

                                <ul class="social_contact">
                                    <li><a href="https://www.facebook.com/Smarcookie-108920238009055" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/smartcookieinn" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/smart-cookie-1537aa210/" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="https://ads.google.com/home/?subid=ww-ww-et-g-aw-a-vasquette_ads_1!o2" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/anil_sahasrabudhe.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Prof. Anil Sahasrabudhe</a><br>
                                <span class="d_block transition_3s">Chairman - AICTE</span><br>
                                <span class="line d_block transition_3s"></span><br>

                                <ul class="social_contact">
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                   <!--  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/mppoonia.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Dr. M.P. Poonia</a><br>
                                <span class="d_block transition_3s">Vice Chairman - AICTE</span><br>
                                <span class="line d_block transition_3s"></span><br>
                                
                                <ul class="social_contact">
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                   <!--  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/rajivekumar.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Prof. Rajive Kumar</a><br>
                                <span class="d_block transition_3s">Member Secretary - AICTE</span><br>
                                <span class="line d_block transition_3s"></span><br>

                                <ul class="social_contact">
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/colbvenkat.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Col. B Venkat</a><br>
                                <span class="d_block transition_3s">Director FDC - AICTE</span><br>
                                <span class="line d_block transition_3s"></span><br>

                                <ul class="social_contact">
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 no-padding">
                        <div class="team_common pos_relative">
                            <div class="member_img">
                                <a href="#"><img src="rkassets/img/team/rakeshkhatri.png" alt="member image"></a>
                            </div>
                            <div class="member_info pos_relative transition_3s">
                                <a href="#" class="d_inline pb_5">Rakesh Khatri</a><br>
                                <span class="d_block transition_3s">CTO - Smart Cookie</span><br>
                                <span class="line d_block transition_3s"></span><br>
                                <a href="tel:+919960903132" class="mobile_number transition_3s">+91 996 090 3132</a>

                                <ul class="social_contact">
                                    <li><a href="https://www.facebook.com/Smarcookie-108920238009055" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/smartcookieinn" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/smart-cookie-1537aa210/" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="https://ads.google.com/home/?subid=ww-ww-et-g-aw-a-vasquette_ads_1!o2" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
</section>
    <!--CLIENT AREA-->

    
                        
    <!--CLIENT AREA END-->
      <!-- ==================================================
                            End vision-area
      ================================================== -->

   <!--TESTMONIAL AREA TWO-->
   <!--
    <section class="testimonials-style-two padding-100-40">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2>What Do Schools Say?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="testmonial-style-two">
                        <div id="testimonials-slider-pager" class="hidden-xs">
                            <a href="#" class="pager-item active" data-slide-index="0"><img src="rkassets/img/testmonial/testmonial-1.jpg" alt="" /></a>
                            <a href="#" class="pager-item" data-slide-index="1"><img src="rkassets/img/testmonial/testmonial-2.jpg" alt="" /></a>
                            <a href="#" class="pager-item" data-slide-index="2"><img src="rkassets/img/testmonial/testmonial-3.jpg" alt="" /></a>
                            <a href="#" class="pager-item" data-slide-index="3"><img src="rkassets/img/testmonial/testmonial-4.jpg" alt="" /></a>
                            <a href="#" class="pager-item" data-slide-index="4"><img src="rkassets/img/testmonial/testmonial-5.jpg" alt="" /></a>
                            <a href="#" class="pager-item" data-slide-index="5"><img src="rkassets/img/testmonial/testmonial-6.jpg" alt="" /></a>
                        </div>
                        <div class="testimonials-slider">
                            <ul class="slider">
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-1.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Habildar</h3>
                                            <p>SEO Specialist , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-2.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Thaowla</h3>
                                            <p>SEO Analyst , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-3.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Kabila</h3>
                                            <p>Support Engr. , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-4.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Chiku</h3>
                                            <p>Designer , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-5.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Ketu</h3>
                                            <p>Developer , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="slide-item">
                                    <div class="single-testimonials">
                                        <div class="author-image">
                                            <img src="rkassets/img/testmonial/testmonial-6.jpg" alt="" />
                                        </div>
                                        <div class="author-content">
                                            <img src="rkassets/img/quotes.png" alt="" />
                                            <p>"Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with"</p>
                                            <h3>Mr. Bala</h3>
                                            <p>SEO Analyst , WallFactory</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    -->
    <!--TESTMONIAL AREA TWO END-->
    <!--<div class="container">
            <div class="row clients2">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2>Review.</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        
                     </div>
                </div> 
            </div>
        </div>-->

     <!--Team AREA Start-->
   
    <!--Team AREA END-->
<section class="client-area no-padding wow fadeIn" id="team">
        <div class="container">
            <div class="row">
                <div class="col-md-12 clients">
                    <div class="area-title text-center">
                        <h2><div class="area-title text-center">
                        <h2>Entities</h2>
                    </div></h2>
                </div>
                    <div class="col-md-12">
                        <div class="Images">    
                            <div class="column">
                                <a href="<?php echo $url_new.'/student'; ?>"> 
                                 <button id="entity" class="btn btn-primary btn-hover" value='student' style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/student1.png" alt="">
                                <h4 class="text-center text" style="color:black;">Student</h4>
                            </div></button></a>
                            <div class="column">                  
                                 <a href="<?php echo $url_new.'/teacher'; ?>"> 
                                    <button class="btn btn-primary btn-hover" id="entity" value='teacher' style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/teacher_icon1.png" alt="">
                                <h4 class="text-center" style="margin-top:40px;color:black;margin-left: -10px;">Teacher</h4>
                            </div></button>
                            </a>
                            <div class="column">
                                <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary btn-hover" type="submit" name="entity" value="1" style="background-color: transparent;border: 0px;">
                                    <img src="rkassets/img/school_admin.jpg" alt="">
                                    <h4 class="text-center text" style="color:black;">School Admin</h4></button>
                                </form>
                            </div>
                            <div class="column">
                                <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary btn-hover" type="submit" name="entity" value="7" style="height: ;width: 170px;background-color: transparent;border: 0px;">
                                    <img src="rkassets/img/school_admin_staff.jpg" height="100" width="130" alt="">
                                    <h4 class="text-center text" style="color:black;">School Admin Staff</h4></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Images1">
                             <div class="column">
                                <a href="<?php echo $url_new.'/employee'; ?>"> 
                                <button class="btn btn-primary btn-hover" id="entity" value='employee' style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/employee_icon.png" alt="">
                                <h4 class="text-center" style="color:black;">Employee</h4></button>
                            </a>
                              </div>
                            <div class="column">
                                <a href="<?php echo $url_new.'/manager'; ?>"> 
                                <button class="btn btn-primary" id="entity" value="manager" style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/maneger_icon.png" alt="">
                                <h4 class="text-center" style="color:black;">Manager</h4></button>
                            </a>
                              </div>
                               <div class="column">
                                <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary btn-hover" type="submit" name="entity" value="11" style="background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/hr_admin.png" alt="">
                                    <h4 class="text-center" style="color:black;">HR Admin</h4></button>
                                </form>
                              </div>
                            <div class="column">
                                 <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary btn-hover" type="submit" name="entity" value="71" style="height: 185px;width: 170px; background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/hr_admin_staff.png" alt="">
                                <h4 class="text-center" style="color:black;">HR Admin Staff</h4>
                            </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Images2">
                            <div class="column">
                                 <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary btn-hover" type="submit" name="entity" value="12" style="background-color: transparent;border: 0px;">
                                    <img src="rkassets/img/group_admin1.jpg" alt="">
                                <h4 class="text-center" style="margin-top:30px;color:black;">Group Admin</h4></button>
                                </form>
                            </div>
                            <div class="column">
                                 <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary" type="submit" name="entity" value="13" style="height: 185px;width: 170px;background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/group_admin_staff1.png" alt="">
                                <h4 class="text-center" style="color:black;">Group Admin Staff</h4></button>
                                </form>
                            </div>
                            <div class="column button1">
                                 <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary" type="submit" name="entity" value="6" style="background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/cookie_admin1.png" alt="">
                                <h4 class="text-center" style="color:black;">Cookie Admin</h4></button>
                                </form>
                            </div>
                            <div class="column">
                                <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary" type="submit" name="entity" value="8" style="height: 185px;width: 170px;background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/admin_staff.jpg" height="100" width="130" alt="">
                                <h4 class="text-center" style="color:black;">Cookie Admin Staff</h4></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Images3">
                            <div class="column">
                                <a href="<?php echo $url_new.'/sponsor'; ?>">
                                <button class="btn btn-primary" id="entity" value="sponsor" style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/sponser_icon.png" alt="">
                                <h4 class="text-center" style="color:black;">Sponsors</h4></button></a>
                            </div>
                            <div class="column">
                                <form action="<?php echo base_url()."".$url_old.""; ?>" method="post">
                                    <button class="btn btn-primary" type="submit" name="entity" value="5" style="background-color: transparent;border: 0px;">
                                     <img src="rkassets/img/parent_icon.jpg" alt="">
                                <h4 class="text-center" style="color:black;">Parent</h4></button>
                                </form>
                            </div>
                            <div class="column">
                                <a href="<?php echo $url_new.'/salesperson'; ?>">
                                <button class="btn btn-primary" id="entity" value="salesperson" style="background-color: transparent;border: 0px;">
                                <img src="rkassets/img/salesperson_icon1.png" alt="">
                                <h4 class="text-center" style="color:black;">Sales Person</h4></button></a>
                            </div>
                            <div class="column">
                                <!-- <a href="<?php //echo base_url('core/express_registration_sp.php'); ?>">
                                <button class="btn btn-primary" id="entity" value="Registration" style="height: 185px;width: 170px;background-color: transparent;border: 0px;">
                                <img src="rkassets/img/salesperson_manager1.png" height="100" width="130" alt="">
                                <h4 class="text-center" style="color:black;">Sales Person Manager</h4></button></a> -->
                            </div>
                              
                        </div>
                    </div>
            </div>
            </div>
        </div>
</section>


    <!-- ABOUT AREA START -->
    <section class="about-area sky-gray-bg padding-100-30 relative wow fadeIn" id="about" style="margin-top:900px;">
        <div class="area-bg"></div>
        <div class="container">
            <div class="row flex-v-center">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="about-mockup right xs-mb50">
                        <img src="rkassets/img/about/about-3.png" alt="" style="margin-top: -130px;">
                    </div>
                </div>
                <!-- <div class="row flex-v-center">
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="about-mockup right xs-mb50">
                        <img src="rkassets/img/about/about-3.png" alt="">
                    </div>
                </div> -->
                <!-- <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="about-content">
                        <div class="single_goal pos_relative">
                            <i class="material-icons icon-round mdi mdi-trending-up"></i>

                            <h5 class="color_grad box-title">Our mission</h5>
                            <p>Phasellus et elit eget purus efficitur dignissim. Sed eget pretium quam, non rutrum nisi.</p>
                        </div>

                        <div class="single_goal pos_relative">
                            <i class="material-icons icon-round mdi mdi-store"></i>
                            <h5 class="color_grad box-title">Our vision</h5>
                            <p>Phasellus et elit eget purus efficitur dignissim. Sed eget pretium quam, non rutrum nisi.</p>
                        </div>

                        <div class="single_goal pos_relative">
                            <i class="material-icons icon-round mdi mdi-format-line-style"></i>
                            <h5 class="color_grad box-title">Dedicated support</h5>
                            <p>Phasellus et elit eget purus efficitur dignissim. Sed eget pretium quam, non rutrum nisi.</p>
                        </div>
                    </div> -->
                </div>
            </div>
            <!-- <div class="row flex-v-center">
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="about-content xs-mb50">
                        <h3 class="mb30">A Satisfied Customer is best for business</h3>
                        <p>We build your brand recognition and online reputation around keyword phrases your customers are already using (especially those that prove they’re ready to buy!) Our relationships with high-end websites mean we don’t pay for bad backlinks, nor do we acquire links that’ll harm your site or disappear within a month.</p>
                        <a href="#" class="read-more mt30 inline-block">Get a Free Website Audit</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="about-mockup">
                        <img src="rkassets/img/about/about-5.png" alt="">
                    </div>
                </div>
            </div> -->
        </div>
    </section>
    <!--ABOUT AREA END-->

<section class="client-area no-padding wow fadeIn" id="sponsor">
        <div class="container">
            <div class="row">
                <div class="col-md-12 Join1">
                    <div class="area-title text-center">
                        <h2><div class="area-title text-center">
                        <h2>Our Sponsors</h2>
                    </div></h2>
                    </div>
                    <div class="client-list client-slider">
                        <?php
                        //group_member_id='".$group_member_id."'".$whereSQL1."
                            $sql_schoolimg1 = "SELECT distinct sp_name,sp_img_path FROM tbl_sponsorer where sp_img_path!='' Order by RAND() Limit 30" ;
                            $result=mysqli_query($conn, $sql_schoolimg1);
                            $schoolarr = array();
                            $schoolcnt=0;
                            $url=base_url()."".'core/';
                            // $url="https://smartcookie.in/core/";
                            while($row = mysqli_fetch_assoc($result)) {
                                // $schoolarr = array_merge($schoolarr, array( "School Name" => $row['school_name'],"Image" => $row['img_path']));
                                echo '<div class="single-client"><img src="'.$url.'/'.$row["sp_img_path"].'/'.$row['imagename'].'" alt="'.$row["sp_name"].'" title="'.$row["sp_name"].'"><?= $row["sp_name"]; ?></div>';
                                $schoolcnt++;
                            }
                        ?>
                       
                     
                    </div>
                </div>
               
            </div>
        </div>
    </section>

    <!--BLOG AREA-->
    <section class="blog-area padding-100-40 wow fadeIn slideshow__slides" id="news">
        <div class="container">
            <div class="row product">
                <div class="col-md-8 col-lg-8 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2 style="">Campus Connect companion Products</h2>
                    </div>
                </div>
            </div>

                
    
             <!-- <div class="blog-slider"> -->
                <!-- <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)" style="width: 30px;height: 30px;color:black;margin-left: 0px;">&#10094;</button>
            <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)" style="width: 30px;height: 30px;margin-left:1100px; margin-top: 0px;color:black;">&#10095;</button> -->
             <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="https://www.startupworld.in/project_radio.html" target="_blank"><img src="rkassets/img/blog/campusradio.jpg" alt=""></a>
                        </div>
                        
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/project_radio.html" target="_blank" class="link">Campus Radio</a></p>
                                <a href="https://www.startupworld.in/project_radio.html" target="_blank">
                                    <h5>Campus Radio</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/project_radio.html" target="_blank">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="https://campustv.rocks" target="_blank"><img src="rkassets/img/blog/campustv.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://campustv.rocks" target="_blank" class="link">Campus TV</a></p>
                                <a href="https://campustv.rocks/" target="_blank">
                                    <h5>Campus TV</h5>
                                </a>
                                <a class="read-more" href="https://campustv.rocks" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/market_research.html" target="_blank"><img src="<?php //echo base_url();?>Images/landing_project_img/market_research.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/market_research.html" target="_blank" class="link">Market research</a></p>
                                <a href="https://www.startupworld.in/internship/market_research.html" target="_blank">
                                    <h5>Market research</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/market_research.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/project_radio.html" target="_blank"><img src="<?php //echo base_url();?>Images/landing_project_img/campus_radio.png" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/project_radio.html" target="_blank" class="link">Campus Radio/TV Projects:</a></p>
                                <a href="https://www.startupworld.in/project_radio.html" target="_blank">
                                    <h5>Campus Radio/TV Projects:</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/project_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 col-sm-6 col-x">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/campus_RadioTV_Ads.html" target="_blank"><img src="<?php  //echo base_url();?>Images/landing_project_img/dj.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/campus_RadioTV_Ads.html" target="_blank" class="link">Create Campus Radio/TV Ads</a></p>
                                <a href="https://www.startupworld.in/internship/campus_RadioTV_Ads.html" target="_blank">
                                    <h5>Create Campus Radio/TV Ads</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/campus_RadioTV_Ads.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank"><img src="<?php //echo base_url();?>Images/landing_project_img/radio.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank" class="link">Design Music Radio</a></p>
                                <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank">
                                    <h5>Design Music Radio</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/music_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
                <div class="row mySlides">
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank"><img src="<?php //echo base_url();?>Images/landing_project_img/employement.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank" class="link">Design Employment Radio</a></p>
                                <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank">
                                    <h5>Design Employment Radio</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/employment_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/hr_radio.html" target="_blank"><img src="<?php //echo base_url();?>Images/landing_project_img/hr.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/hr_radio.html" target="_blank" class="link">HR Radio</a></p>
                                <a href="https://www.startupworld.in/internship/hr_radio.html" target="_blank">
                                    <h5>HR Radio</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/hr_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Revenue-models.html" target="_blank"><img src="Images/landing_project_img/Revenue.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Revenue-models.html" target="_blank" class="link">Create Revenue models and plans</a></p>
                                <a href="https://www.startupworld.in/internship/Revenue-models.html" target="_blank">
                                    <h5>Create Revenue models and plans</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Revenue-models.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Gaming.html" target="_blank"><img src="Images/landing_project_img/PUBG.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Gaming.html" target="_blank" class="link">Gaming Portal</a></p>
                                <a href="https://www.startupworld.in/internship/Gaming.html" target="_blank">
                                    <h5>Gaming Portal</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Gaming.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/helpdesk.html" target="_blank"><img src="Images/landing_project_img/help.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/helpdesk.html" target="_blank" class="link">Help Desk Management</a></p>
                                <a href="https://www.startupworld.in/internship/helpdesk.html" target="_blank">
                                    <h5>Help Desk Management</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/helpdesk.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12 ">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Translate-into-other-country-language.html" target="_blank"><img src="Images/landing_project_img/lang.png" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Translate-into-other-country-language.html" target="_blank" class="link">Translate into other country language</a></p>
                                <a href="https://www.startupworld.in/internship/Translate-into-other-country-language.html" target="_blank">
                                    <h5>Translate into other country language</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Translate-into-other-country-language.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank"><img src="Images/landing_project_img/micc.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank" class="link">Customizing Campus Radio for promoting art, music, poetry</a></p>
                                <a href="https://www.startupworld.in/internship/employment_radio.html" target="_blank">
                                    <h5>Customizing Campus Radio for promoting art, music, poetry</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/employment_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/AI-and-Machine-Learning-for-the-Rewards-Engine.html" target="_blank"><img src="Images/landing_project_img/ai.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/AI-and-Machine-Learning-for-the-Rewards-Engine.html" target="_blank" class="link">Use of AI and &nbsp; Machine Learning for the Rewards Engine</a></p>
                                <a href="https://www.startupworld.in/internship/AI-and-Machine-Learning-for-the-Rewards-Engine.html" target="_blank">
                                    <h5>Use of AI and &nbsp; Machine Learning for the Rewards Engine</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/AI-and-Machine-Learning-for-the-Rewards-Engine.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Attract-Funding.html" target="_blank"><img src="Images/landing_project_img/Crowdfundin.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Attract-Funding.html" target="_blank" class="link">Attract Funding</a></p>
                                <a href="https://www.startupworld.in/internship/Attract-Funding.html" target="_blank">
                                    <h5>Attract Funding</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Attract-Funding.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/art_club.html" target="_blank"><img src="Images/landing_project_img/club.png" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/art_club.html" target="_blank" class="link">Attract different Arts clubs</a></p>
                                <a href="https://www.startupworld.in/internship/art_club.html" target="_blank">
                                    <h5>Attract different Arts clubs</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/art_club.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Startup-World-Projects.html" target="_blank"><img src="Images/landing_project_img/Globaltest.png" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Startup-World-Projects.html" target="_blank" class="link">Global Testers</a></p>
                                <a href="https://www.startupworld.in/internship/Startup-World-Projects.html" target="_blank">
                                    <h5>Global Testers</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Startup-World-Projects.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/sharktank.html" target="_blank"><img src="Images/landing_project_img/student_techer.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/sharktank.html" target="_blank" class="link">Friends of Shark Tank</a></p>
                                <a href="https://www.startupworld.in/internship/sharktank.html" target="_blank">
                                    <h5>Friends of Shark Tank</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/sharktank.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/ThankQ-Artist.html" target="_blank"><img src="Images/landing_project_img/tank_you.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/ThankQ-Artist.html" target="_blank" class="link">ThankQ Artist</a></p>
                                <a href="https://www.startupworld.in/internship/ThankQ-Artist.html" target="_blank">
                                    <h5>ThankQ Artist</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/ThankQ-Artist.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/startup-world.html" target="_blank"><img src="Images/landing_project_img/learn.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/startup-world.html" target="_blank" class="link">Education An Interesting Process</a></p>
                                <a href="https://www.startupworld.in/internship/startup-world.html" target="_blank">
                                    <h5>Education An Interesting Process</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/startup-world.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Block-chain-for-Smart-Cookie-Reward-points-system.html" target="_blank"><img src="Images/landing_project_img/block.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Block-chain-for-Smart-Cookie-Reward-points-system.html" target="_blank" class="link">Block chain for Smart Cookie Reward points system</a></p>
                                <a href="https://www.startupworld.in/internship/Block-chain-for-Smart-Cookie-Reward-points-system.html" target="_blank">
                                    <h5>Block chain for Smart Cookie Reward points system</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Block-chain-for-Smart-Cookie-Reward-points-system.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank"><img src="Images/landing_project_img/radio.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank" class="link">Design Music Radio</a></p>
                                <a href="https://www.startupworld.in/internship/music_radio.html" target="_blank">
                                    <h5>Design Music Radio</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/music_radio.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/smartcookie-datacollection.html" target="_blank"><img src="Images/landing_project_img/data_analyst.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/smartcookie-datacollection.html" target="_blank" class="link">Data Collection and Analytics for the Sponsors</a></p>
                                <a href="https://www.startupworld.in/internship/smartcookie-datacollection.html" target="_blank">
                                    <h5>Data Collection and Analytics for the Sponsors</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/smartcookie-datacollection.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/corporate-Current-(Business).html" target="_blank"><img src="Images/landing_project_img/bussiness_smc.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/corporate-Current-(Business).html" target="_blank" class="link">Corporate Currents (Business):</a></p>
                                <a href="https://www.startupworld.in/internship/corporate-Current-(Business).html" target="_blank">
                                    <h5>Corporate Currents (Business):</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/corporate-Current-(Business).html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/Auto-genenration-of-website.html" target="_blank"><img src="Images/landing_project_img/auto_generate.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/Auto-genenration-of-website.html" target="_blank" class="link">Auto generation of websites</a></p>
                                <a href="https://www.startupworld.in/internship/Auto-genenration-of-website.html" target="_blank">
                                    <h5>Auto generation of websites</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/Auto-genenration-of-website.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb img1">
                            <a href="https://www.startupworld.in/internship/smartcookie-measure-social-footprint.html" target="_blank"><img src="Images/landing_project_img/measure social media.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/internship/smartcookie-measure-social-footprint.html" target="_blank" class="link">Measure Social Footprint of a Student and reward him/her</a></p>
                                <a href="https://www.startupworld.in/internship/smartcookie-measure-social-footprint.html" target="_blank">
                                    <h5>Measure Social Footprint of a Student and reward him/her</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/internship/smartcookie-measure-social-footprint.html" target="_blank">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="https://startupworld.in" target="_blank"><img src="rkassets/img/blog/startupworld.jpg" alt="" style="width:350px;"></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://startupworld.in" target="_blank" class="link">Startup World</a></p>
                                <a href="https://startupworld.in" target="_blank">
                                    <h5>Startup World</h5>
                                </a>
                                <a class="read-more" href="https://startupworld.in" target="_blank">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
        <div class="row mySlides">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="http://learningplanet.in/" target="_blank"><img src="rkassets/img/blog/learningplanet.jpg" alt="" style="width:350px;"></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="http://learningplanet.in/" target="_blank" class="link">eLearning</a></p>
                                <a href="http://learningplanet.in/" target="_blank">
                                    <h5>Learning Planet</h5>
                                </a>
                                <a class="read-more" href="http://learningplanet.in/" target="_blank">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="https://www.startupworld.in/" target="_blank"><img src="rkassets/img/blog/internships.jpg" alt="" style="width:350px;"></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://www.startupworld.in/" target="_blank" class="link">Internships</a></p>
                                <a href="https://www.startupworld.in/" target="_blank">
                                    <h5>Internships</h5>
                                </a>
                                <a class="read-more" href="https://www.startupworld.in/" target="_blank">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="https://us06web.zoom.us/j/83187188656?pwd=MlUxNW9sZ0IyWTJ2QWVjZUZ0ZFRnZz09" target="_blank"><img src="rkassets/img/blog/innovation.jpg" alt="" style="width:350px;"></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="https://us06web.zoom.us/j/83187188656?pwd=MlUxNW9sZ0IyWTJ2QWVjZUZ0ZFRnZz09" class="link" target="_blank">Innovation</a></p>
                                <a href="https://us06web.zoom.us/j/83187188656?pwd=MlUxNW9sZ0IyWTJ2QWVjZUZ0ZFRnZz09" target="_blank">
                                    <h5>Innovation</h5>
                                </a>
                                <a class="read-more" href="https://us06web.zoom.us/j/83187188656?pwd=MlUxNW9sZ0IyWTJ2QWVjZUZ0ZFRnZz09" target="_blank">Read More</a>
                            </div>
                        </div>
                    </div>

                </div>  
            </div>
        <!-- </div> -->
         </div>
    </section>
    
    <!--BLOG AREA END-->
    

    <!--Contact area Start -->

    <div class="container" id="contact">

        <div class="row contact-form">
            <div class="col-md-12">
                <div class="area-title text-center">
                    <h2>Contact</h2>
                </div>
            </div>
            <!-- <div class="col-md-2"></div> -->
            <div class="col-md-8 contact_details ">
                <div class="contact-address">
                    <i class="fa fa-map fa-2x"></i>
                    <h5>Location</h5><br/>
                    <p> 55 Anmol, Prashant Society, Kothrud, Pune. (Maharashtra) India.</p>
                    <br>
                </div>
                <div class="contact-address">
                    <i class="fa fa-phone fa-2x"></i>
                    <h5>Contact Number</h5>
                    <p>+91-7219193815</p>
                </div>
                <div class="contact-address">
                    <i class="fa fa-globe fa-2x"></i>
                    <h5>Online</h5>
                    <p>Web: https://smartcookie.in</p>
                </div>
            </div>
            </div>
            <div class="col-md-2 meeting">
                <div class="row">
                    <a href="#" class="list-group-item list-group-item-action active text-center" style="background-color:#00ffd5;color:black;">
                      Internships
                      </a>
                      <a href="https://www.startupworld.in/" class="list-group-item list-group-item-action text-center">Startup World</a>
                      <a href="#" class="list-group-item list-group-item-action active text-center" style="background-color:#00ffd5;color:black;">HELP MEETINGS</a>
                      <a href="https://meet.google.com/ayv-bdrb-wyd" class="list-group-item list-group-item-action text-center">10:00 AM To 11:00 AM</a>
                      <a href="https://meet.google.com/ayv-bdrb-wyd" class="list-group-item list-group-item-action text-center">06:00 PM To 07:00 PM</a>
                      <a href="#" class="list-group-item list-group-item-action active text-center" style="background-color:#00ffd5;color:black;">SESSIONS</a>
                      <a href="https://meet.google.com/ayv-bdrb-wyd" class="list-group-item list-group-item-action text-center">Session 1: 10:00 AM To 11:00 AM</a>
                      <a href="https://meet.google.com/ayv-bdrb-wyd" class="list-group-item list-group-item-action text-center">Session 2: 06:00 PM To 07:00 PM</a>
                  </div>
              </div>
              <div class="col-md-2 meeting1">
                <div class="row">
                      <a href="#" class="list-group-item list-group-item-action active text-center" style="background-color:#00ffd5;color:black;">Daily Events</a>
                      <a href="https://us06web.zoom.us/j/83187188656?pwd=MlUxNW9sZ0IyWTJ2QWVjZUZ0ZFRnZz09" class="list-group-item list-group-item-action text-center">Innovation Sunday</a>
                      <a href="https://us06web.zoom.us/j/83806261722?pwd=OCttYW5TYTd5bHFJSkM4M1MyNkk4Zz09" class="list-group-item list-group-item-action text-center">Healthy Wednesday</a>
                      <a href="https://us06web.zoom.us/j/86447280462?pwd=TERCZXhiZHhlRDlYOU5SUS9sL3FhUT09" class="list-group-item list-group-item-action text-center">Network Building</a>
                      <a href="https://us06web.zoom.us/j/81662493491?pwd=ZllIMWg2bVpRWHNzTzNxMURxVnlhdz09" class="list-group-item list-group-item-action text-center">Placement Fever </a>
                      <a href="#" class="list-group-item list-group-item-action active text-center" style="background-color:#00ffd5;color:black;">AICTE EVENTS</a>
                      <a href="https://meet.google.com/ayv-bdrb-wyd" class="list-group-item list-group-item-action text-center">FDC 360</a>
                </div>
            </div>
        
    </div>
    <!--CONTACT AREA END-->


    <!--FOOER AREA-->
    <footer class="footer-area sky-gray-bg padding-bottom padding-top-50 relative wow fadeIn">
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12 sm-center xs-center sm-mb50 xs-mb50">
                        <div class="footer-logo mb50">
                            <a href="#"><img src="rkassets/img/logo.png" alt=""></a>
                        </div>
                        <div class="footer-about">
                            <p>Smart Cookie believes in the power of youth.</p>
                        </div>
                    </div>
                    <div class="col-md-7 col-md-offset-1 col-xs-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-footer-widget">
                                    <h4>Pages</h4>
                                    <ul>
                                        <li><a href="https://smartcookie.in/new/events/" target="_blank">Events</a></li>
                                        <li><a href="help/index1.php" target="_blank">Help</a></li>
                                        <li><a href="<?php echo base_url()."".'core/contact-us.php';?>" target="_blank">Contact us</a></li>
                                       <!--  <li><a href="<?php //echo base_url()."".'core/about-us.php';?>" target="_blank">About us</a></li> -->
                                        <li><a href="<?php echo base_url()."".'core/SmartCookie.pdf';?>" target="_blank">Info</a></li>
                                        <li><a href="<?php echo base_url()."".'core/student.php';?>" target="_blank">Students</a></li>
                                        <li><a href="<?php echo base_url()."".'core/college.php';?>" target="_blank">School/College</a></li>
                                        <li><a href="<?php echo base_url()."".'core/teacher.php';?>" target="_blank">Teachers</a></li>
                                        <li><a href="<?php echo base_url()."".'core/parent.php';?>" target="_blank">Parents</a></li>
                                        <li><a href="<?php echo base_url()."".'core/sponsor.php';?>" target="_blank">Vendors/Sponsors</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-footer-widget">
                                    <h4>Social Media</h4>
                                    <ul>
                                        <li><a href="https://www.facebook.com/Smarcookie-108920238009055" title="Facebook" target="_blank"><i class="fa fa-facebook"></i> &nbsp;&nbsp; Facebook </a></li>

                                        <li><a href="https://twitter.com/smartcookieinn" title="Twitter" target="_blank"><i class="fa fa-twitter"></i> &nbsp;&nbsp; Twitter </a></li>

                                        <li><a href="https://www.linkedin.com/in/smart-cookie-1537aa210/" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i> &nbsp;&nbsp; LinkedIn</a></li>

                                        <li><a href="https://www.instagram.com/smartcookie360/" title="Instagram" target="_blank"><i class="fa fa-instagram"></i> &nbsp; Instagram</a></li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-footer-widget">
                                    <h4>Legal</h4>
                                    <ul>
                                        <li><a href="https://smartcookie.in/core/tnc.php" target="_blank">Terms of Service</a></li>
                                        <li><a href="https://discord.com/" target="_blank">Security Policy</a></li>
                                        <li><a href="https://smartcookie.in/new/privacy-policy/" target="_blank">Privacy Policy</a></li>
                                        <li><a href="https://www.reddit.com/user/smartcookieinn" target="_blank">Media</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-copyright mt50 center">
                            <p>Copyright &copy; <a href="https://smartcookie.in" target="_blank">Smart Cookie</a> All Right Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--FOOER AREA END-->


    <!--====== SCRIPTS JS ======-->
    <script src="rkassets/js/plugins.js"></script>
    <script src="rkassets/js/main.js"></script>
   <script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000); // Change image every 5 seconds
}
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-FBDC0Z3FQJ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-FBDC0Z3FQJ');
</script>
   <script type="text/javascript">
    (function(w, d, s, u) {
        w.id = 3; w.lang = ''; w.cName = ''; w.cEmail = ''; w.cMessage = ''; w.lcjUrl = u;
        var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
        j.async = true; j.src = 'https://helpdesk.smartcookie.in/js/jaklcpchat.js';
        h.parentNode.insertBefore(j, h);
    })(window, document, 'script', 'https://helpdesk.smartcookie.in/');
</script>
<div id="jaklcp-chat-container"></div>
</body>

</html>

