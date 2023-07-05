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
    <title>Smart Cookie | AICTE 360 Degree Feedback</title>

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


    </script>
   
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

        $group_member_id='91';
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
                            <a href="main.php" class="navbar-brand"><img src="rkassets/img/logo.png" alt="logo"></a>
                        </div>
                        <div class="mainmenu-and-right-button">
                            <div id="main-nav" class="stellarnav">
                                <ul id="nav" class="nav navbar-nav">
                                    <li class="active"><a href="#home">Home</a></li>
                                    <li><a href="#team">Team</a></li>
                                    <li><a href="#news">Products</a></li>
                                    <li><a href="#contact">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <!--END MAINMENU AREA END-->
        </div>
        
    </header>
    

    <div class="container">
         <div class="row">
            <div class="welcome-area">
                <div class="welcome-text">
                    <h1 class="color_grad wow fadeInUp" data-wow-delay="0.2s">About Smart Cookie</h1>
                    <p class="wow fadeInUp" data-wow-delay="0.3s">Smart Cookie / Protsahan Bharti is a Student-Teacher Reward Program. It is a process of providing Just in Time Rewards for the encouragement of Students and Teachers to bring out the Best in them.</p>
                    <div class="home-button mt60 xs-mt40 wow fadeInUp" data-wow-delay="0.4s">
                        <a class="left" href="#">Know More</a>
                    </div>
                </div>
        
                 <div class="right-image">

                    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
                 
                        <div class="carousel-inner slide">
                            <div class="item active" >
                              <img src="rkassets/img/is1.jpg" alt="Slide1"></a>
                            </div>

                            <div class="item">
                              <img src="rkassets/img/is2.jpg" alt="Slide2">
                            </div>
                         
                            <div class="item">
                              <img src="rkassets/img/is3.jpg" alt="Slide3">
                            </div>

                            <div class="item" >
                              <img src="rkassets/img/is4.jpg" alt="Slide4">
                            </div>

                            <div class="item" >
                              <img src="rkassets/img/is5.jpg" alt="Slide5">
                            </div>


                        </div>
 
                             <!-- <img src="rkassets/img/home/home-mockup.png" alt=""> -->
                 
                    </div>
    
                </div>
            </div>
        </div>
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
    
  <section class="client-area no-padding wow fadeIn">
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
                            $sql_schoolimg = "SELECT school_name,img_path FROM tbl_school_admin where group_member_id='".$group_member_id."'".$whereSQL1." Order by RAND() Limit 30" ;
                            $result=mysqli_query($conn, $sql_schoolimg);
                            $schoolarr = array();
                            $schoolcnt=0;
                            $url="https://smartcookie.in/core/";
                            while($row = mysqli_fetch_assoc($result)) {
                                // $schoolarr = array_merge($schoolarr, array( "School Name" => $row['school_name'],"Image" => $row['img_path']));
                                echo '<div class="single-client"><img src="'.$url.'/'.$row["img_path"].'" alt="'.$row["school_name"].'" title="'.$row["school_name"].'"></div>';
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
        </div>
    </section>

 <!-- ==================================================
                            vision-area
      ================================================== -->
    <section class="vision-area padding-top-0-20">
        <div class="container">
            <div class="row">
                  
               
                    <div class="area-title text-center">
                        <h2 style="margin-top:-220px;"><div class="area-title text-center">
                        <h2>How Smart Cookie Works?</h2>
                    </div></h2>
                    </div>
                    <div class="col-md-2 col-lg-2">
                    </div>
                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                        <iframe height="350" style="margin-top:-100px;" src="https://www.youtube.com/embed/wOEz5ez1vHQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                   <!--  <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                        <h2 class="box-title"><a href="#">How Smart Cookie Works?</a></h2>
                          

                    </div> -->
            </div>
  
              <!--   <div class="row padding10">
                    <div class="col-md-3 col-4">
                        <div><img src="rkassets/img/procoinmain.png" alt=""></div>
                    </div>
                    <div class="col-md-6 col-4" style="text-align: center;"><h1>AICTE 360 Degree Feedback</h1></div>
                    <div class="col-md-3 col-4" style="text-align: right;">
                        <div style="text-align: right;"><img src="rkassets/img/aictemain.png" alt=""></div>
                    </div>
                </div> -->
            <!-- <div class="row flex-v-center"> -->
                <!-- <div class="mid">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="about-content xs-mb50">
                            <h3 class="mb30">A Satisfied Customer is best for business</h3>
                            <p>We build your brand recognition and online reputation around keyword phrases your customers are already using (especially those that prove they’re ready to buy!) Our relationships with high-end websites mean we don’t pay for bad backlinks, nor do we acquire links that’ll harm your site or disappear within a month.</p>
                            <a href="#" class="read-more mt30 inline-block">Get a Free Website Audit</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="about-mockup">
                            <img src="rkassets/img/schooladmin.png" alt="">
                        </div>
                    </div>
                </div> -->
            
            
    
   <!--  -->

          <!-- </div> -->
      </section>

    <!--CLIENT AREA-->
    <section class="client-area no-padding wow fadeIn">
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
                                <img src="rkassets/img/student1.png" alt="">
                                <h4 class="text-center text">Student</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/teacher_icon1.png" alt="">
                                <h4 class="text-center" style="margin-top:40px;">Teacher</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/school_admin.jpg" alt="">
                                <h4 class="text-center text">School Admin</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/school_admin_staff.jpg" alt="">
                                <h4 class="text-center text">School Admin Staff</h4>
                              </div>
                              </div>
                          </div>
                         <div class="col-md-12">
                        <div class="Images1">
                             <div class="column">
                                <img src="rkassets/img/employee_icon.png" alt="">
                                <h4 class="text-center">Employee</h4>
                              </div>
                            <div class="column">
                                <img src="rkassets/img/maneger_icon.png" alt="">
                                <h4 class="text-center">Maneger</h4>
                              </div>
                               <div class="column">
                                <img src="rkassets/img/hr_admin.png" alt="">
                                <h4 class="text-center">HR Admin</h4>
                              </div>
                                <div class="column">
                                <img src="rkassets/img/hr_admin_staff.png" alt="">
                                <h4 class="text-center">HR Admin Staff</h4>
                              </div>
                              
                              </div>
                          </div>
                         <div class="col-md-12">
                        <div class="Images2">
                             <div class="column">
                                <img src="rkassets/img/group_admin1.jpg" alt="">
                                <h4 class="text-center" style="margin-top:30px;">Group Admin</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/group_admin_staff1.png" alt="">
                                <h4 class="text-center">Group Admin Staff</h4>
                              </div>
                            <div class="column">
                                <img src="rkassets/img/cookie_admin1.png" alt="">
                                <h4 class="text-center">Cookie Admin</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/admin_staff.jpg" alt="">
                                <h4 class="text-center">Cookie Admin Staff</h4>
                              </div>
                             
                              </div>
                         </div>
                         <div class="col-md-12">
                        <div class="Images3">
                              <div class="column">
                                <img src="rkassets/img/sponser_icon.png" alt="">
                                <h4 class="text-center">Sponser</h4>
                              </div>
                               <div class="column">
                                <img src="rkassets/img/parent_icon.jpg" alt="">
                                <h4 class="text-center">Parent</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/salesperson_icon1.png" alt="">
                                <h4 class="text-center">Sales Person</h4>
                              </div>
                              <div class="column">
                                <img src="rkassets/img/salesperson_manager1.png" alt="">
                                <h4 class="text-center">Sales Person Manager</h4>
                              </div>
                              
                              </div>
                         </div>
                </div>
            </div>
        </div>
    </section>
                        
    
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
    <!-- <div class="container">
            <div class="row clients2">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2>Review.</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        
                     </div>
            </div> -->

     <!--Team AREA Start-->
    <section class="team-area padding-top wow fadeIn" id="team">
        <div class="container">
            <div class="row clients1">
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
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
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
                                    <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    <!--Team AREA END-->



    <!-- ABOUT AREA START -->
    <section class="about-area sky-gray-bg padding-100-30 relative wow fadeIn" id="about">
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



    <!--BLOG AREA-->
    <section class="blog-area padding-100-40 wow fadeIn" id="news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3 col-sm-12 col-xs-12">
                    <div class="area-title text-center">
                        <h2 style="">Our Other Products</h2>
                    </div>
                </div>
            </div>
            <div class="row blog-slider">
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/campusradio.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">Smart Cookie</a></p>
                                <a href="#">
                                    <h5>Campus Radio</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/campustv.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">Smart Cookie</a></p>
                                <a href="#">
                                    <h5>Campus TV</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/startupworld.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">Startup World</a></p>
                                <a href="#">
                                    <h5>Startup World</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/learningplanet.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">eLearning</a></p>
                                <a href="#">
                                    <h5>Learning Planet</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/internships.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">Startup World</a></p>
                                <a href="#">
                                    <h5>Internships</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-sm-6 col-xs-12">
                    <div class="single-blog-item mb50 shadow">
                        <div class="blog-thumb">
                            <a href="blog.html"><img src="rkassets/img/blog/innovation.jpg" alt=""></a>
                        </div>
                        <div class="post-item-content padding30">
                            <div class="col-lg-9 col-md-12">
                                <p><i class="fa fa-user"></i> <a href="#" class="link">Startup World</a></p>
                                <a href="#">
                                    <h5>Innovation</h5>
                                </a>
                                <a class="read-more" href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>                                                
            </div>
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
            <div class="col-md-2"></div>
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
                                        <li><a href="#">Help</a></li>
                                        <li><a href="#contact">Contact us</a></li>
                                        <li><a href="#">Media</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-footer-widget">
                                    <h4>Social Media</h4>
                                    <ul>
                                        <li><a href="https://www.facebook.com/Smarcookie-108920238009055" title="Facebook" target="_blank"><i class="fa fa-facebook"></i> &nbsp;&nbsp; Facebook </a> </li>

                                        <li><a href="https://twitter.com/smartcookieinn" title="Twitter" target="_blank"><i class="fa fa-twitter"></i> &nbsp;&nbsp; Twitter </a></li>

                                        <li><a href="#" title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i> &nbsp;&nbsp; LinkedIn</a></li>

                                        <li><a href="https://www.instagram.com/smartcookieinn/" title="Instagram" target="_blank"><i class="fa fa-instagram"></i> &nbsp; Instagram</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="single-footer-widget">
                                    <h4>Legal</h4>
                                    <ul>
                                        <li><a href="https://smartcookie.in/core/tnc.php" target="_blank">Terms of Service</a></li>
                                        <li><a href="#">Security Policy</a></li>
                                        <li><a href="https://smartcookie.in/new/privacy-policy/" target="_blank">Privacy Policy</a></li>
                                        <li><a href="#">Media</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-copyright mt50 center">
                            <p>Copyright &copy; <a href="#">Smart Cookie</a> All Right Reserved.</p>
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
</body>

</html>

