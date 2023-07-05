<?php 

 $webHost=$_SESSION['webHost']; 
 $isSmartCookie=$_SESSION['isSmartCookie'];
 ?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To Smart Cookie</title>
    <!-- Favicon-->


    
    <?php if($isSmartCookie) { ?>
    <link rel="icon" href="<?php echo base_url();?>images/logo_home_new_300_103.png" type="image/x-icon">
 
    <?php }else{ ?>
    
 <link rel="icon" href="<?php echo base_url();?>images/pblogoname.jpg" type="image/x-icon">
 <?php } ?>
 
    <!-- Google Fonts -->
 
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
 
    <!-- Bootstrap Core Css -->
    <link href="<?php echo TEACHER_ASSETS_PATH;?>/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    
       

    <!-- Waves Effect Css -->
    <link href="<?php echo TEACHER_ASSETS_PATH;?>/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo TEACHER_ASSETS_PATH;?>/plugins/animate-css/animate.css" rel="stylesheet" />  
    <!-- Custom Css -->
    <link href="<?php echo TEACHER_ASSETS_PATH;?>/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo TEACHER_ASSETS_PATH;?>/css/themes/all-themes.css" rel="stylesheet" />
    <!-- Jquery Core Js -->
    <script src="<?php echo TEACHER_ASSETS_PATH;?>/plugins/jquery/jquery.min.js"></script>

    
     
    <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
    <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
    
    
    <!-- Bootstrap Core Js -->
    <script src="<?php echo TEACHER_ASSETS_PATH;?>/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo TEACHER_ASSETS_PATH;?>/plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo TEACHER_ASSETS_PATH;?>/js/admin.js"></script>
  
</head>

<body class="theme-red">
     <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
   
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
 

                <a class="navbar-brand" href="<?php echo base_url(); ?>teachers">
                <?php if($isSmartCookie) { ?>
                <img src="<?php echo base_url();?>images/logo_home_new_300_103.png">
 
                <?php }else{ ?>
                <img src="<?php echo base_url();?>images/pblogoname.jpg">
                <?php } ?>
                </a>
 
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search 
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons" title="Notifications">notifications</i>
                            <span class="label-count"><?php if($pointRequest + $coordinatorRequests + $pointRequestManager > 0) echo $pointRequest + $coordinatorRequests + $pointRequestManager; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                <?php if($pointRequest + $pointRequestManager > 0){?>
                                    <li>
                                        <a href="<?php echo base_url(); ?>teachers/pointRequest_from_student">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><?php echo $pointRequest + $pointRequestManager; ?> point request pending</h4>
                                               
                                            </div>
                                        </a>
                                    </li>
                                <?php } if($coordinatorRequests > 0){?>
                                     <li>
                                        <a href="<?php echo base_url(); ?>teachers/request_for_coordinator">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><?php echo $coordinatorRequests; ?> coordinator request pending</h4>
                                               
                                            </div>
                                        </a>
                                    </li>
                                <?php } ?>

                                  <!--  <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy</b> changed name</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> commented your post</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> updated status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>-->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);"></a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                   <!-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class=""></i></a>
                    <li><a href="<?php echo base_url(); ?>teachers/cart">
                            <i class="material-icons" title="My Cart">add_shopping_cart</i>
                            <span class="label-count" id="cart_count"><?php if($cart_coupon_details > 0)echo $cart_coupon_details; ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" data-close-others="false">
                            <i class="material-icons" title="My Profile">person</i><b class=""></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="<?php echo base_url(); ?>teachers/teacher_profile"><i class="material-icons">person</i>My Profile</a></li>
                            <li class="divider"></li>
                            <!--<li><a tabindex="-1" href="<?php echo base_url(); ?>teachers/teacher_profile">Change Email</a></li>-->
                            
                            <!--Below code added for for the Bug SMC-3467 by Rutuja Jori & Sayali Balkawade(PHP Interns) on 13/04/2019-->
                            
                            <li><a tabindex="-1" href="<?php echo base_url(); ?>teachers/teacher_profile1"><i class="material-icons">lock</i>Change Password</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" href="<?php echo base_url(); ?>Clogin/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </li></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="content">
    <div class="row clearfix" id="points_div">
<!--Ternary operator added in all the points by Pranali for SMC-4210 on 28-11-19-->
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url(); ?>teachers/assigned_points_log">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <span style="color:#fff !important;"><?php echo $teacher_info[0]->tc_balance_point?$teacher_info[0]->tc_balance_point:0; ?></span>
                        </div>
                        <div class="content">
                            <div class="text">Reward Points</div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    </a>
                </div>
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url(); ?>teachers/thanqpoints_log">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <span style="color:#fff !important;"><?php echo $teacher_info[0]->balance_blue_points?$teacher_info[0]->balance_blue_points:0; ?></span>
                        </div>
                        <div class="content">
                            <div class="text">ThanQ Points</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url(); ?>teachers/earned_brown_points">
                    <div class="info-box bg-brown hover-expand-effect">
                        <div class="icon">
                            <span style="color:#fff !important;"><?php echo $teacher_info[0]->brown_point?$teacher_info[0]->brown_point:0; ?></span>
                        </div>
                        <div class="content">
                            <div class="text">Brown Points</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="<?php echo base_url(); ?>teachers/purchase_water_point_log">
                    <div class="info-box hover-expand-effect" style="background-color:#D4EFFF;">
                        <div class="icon">
                            <span style="color:#fff !important;" ><?php echo $teacher_info[0]->water_point?$teacher_info[0]->water_point:0; ?></span>
                        </div>
                        <div class="content">
                            <div class="text">Water Points</div>
                            <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
<!--SMC-4308 </a> added -->
                </a>
                </div>
            </div>
            </section>    