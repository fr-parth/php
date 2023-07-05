<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AICTE 360 Feedback</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/nice-select.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/flaticon.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/animate.css">
    <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/slicknav.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>css/cssfb/style.css"> -->
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>
    
    <style>
    
    .align-items-center {
    -webkit-box-align: center!important;
    -ms-flex-align: center!important;
    align-items: none!important;
}
        
        .aicteLogo{
            position: relative;
            left: 50px;
            bottom: 65px;
         }
        
        .header-area .donate_now a:hover {
            background: none !important;
            border-color: #fff;
            color: #450000 !important;
        }

       .section_title1 p {
            font-size: 70px;
            position: relative;
            top: 150px;
            color: brown;
            text-shadow: 5px -2px 6px;
        }
        
      .slider_area::before {
            position: absolute;
            content: "";
            background: #ffd868 !important;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            opacity: .8;
        }
        
        .slider_area {
                padding-top: 80px;
                height: 380px;
                position: relative;
                z-index: 0 !important;
                background-repeat: no-repeat;
                background-size: cover;
            }
        
        
        
        .fotText{
            font-size: 18px;
            text-shadow: 2px 6px 13px orangered;
/*
            position: relative;
            bottom: 100px;
*/
 
        } 
        
       
  
       
    </style>
    <script type="text/javascript">
        function changeMessage(){
            var url = "core/login.php";
            document.loginform.action = url;
            document.forms["loginform"].submit();
            
        }
        function changeMessage2(){
            var url = "core/activate_school.php";
            document.loginform.action = url;
            document.forms["loginform"].submit();
            
        }
    </script>
<body>
  
        <header>
            <div class="header-area ">
                <div id="sticky-header" class="main-header-area">
                    <div class="container-fluid p-0">
                        <nav class="navbar navbar-expand-lg navbar-light ">
      <a class="navbar-brand" href="#"><img src="<?= base_url();?>image/pro-logo-with-name-transparent-bg.png" height="100px" alt=" "></a>
      <div class="collapse navbar-collapse align-items-middle text-white justify-content-center" id="navbarNavAltMarkup">
        <div class="col-md-12">
            <h1 style="color: #000;" class="text-center">AICTE 360 Degree Feedback</h1>  
        </div>
      </div>
      <a class="navbar-brand justify-content-end" href="#"><img src="<?= base_url();?>image/aicte.png" height="100px" alt=" "></a>
    </nav>
        
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    <!-- header-end -->

    <!-- slider_area_start -->
    <!-- <div class="slider_area slider_bg_1 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="single_slider">
                        <div class="slider_text">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- slider_area_end -->
 
 
    <div class="slider_area about_area" style="position:relative;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4 col-md-4 text-center">
                            <a href="<?= base_url();?>Clogin/login/student" class=" " role="button"><img src="<?= base_url();?>image/student250.png" alt="" width="200" height="200"></a>
                            <br/>
                             <span class="sf"><h4>Student Feedback</h4></span>           
                </div> 
                <div class="col-xl-4 col-md-4 text-center">
                            <a href="<?= base_url();?>Clogin/login/teacher" class=" " role="button"><img src="<?= base_url();?>image/teacher250.png" alt=""  width="200" height="200"></a>
                            <br/>
                            <span><h4>Teacher/Hod/Principal Feedback</h4></span>
                </div>

                 <div class="col-xl-4 col-md-4 text-center">
                            <form method="POST" name='loginform' id='loginform'>
                                <input type="hidden" name="entity" value="1"><a onclick="changeMessage()" href="#" role="button"><img src="<?= base_url();?>image/admin250.png" alt="" width="200" height="200"></a>
                            </form>
                             <span class="sf"><h4>School Admin</h4></span>           
                </div>

            </div>
        </div>
    </div>
    <br>
    <!--Below link for School Activation added by Rutuja for SMC-5175 on 23-02-2021-->
     <div align="center"><input type="button" class="btn btn-success" onclick="changeMessage2()" value="Activate Your School"></div>
    <div class="container">
        <div class =" row justify-content-center pt-5 ">
            <a href="<?= base_url('Assets/documents/Frequestly_Asked_Questions_AICTE_20201230.pdf');?>" target="_blank"><center><img src="<?= base_url();?>Assets/image/faq.png" class="rounded mx-4 shadow-lg p-3 bg-white rounded"></center>
               <div class="card-body">
                  <center><h5 class="card-title">FAQ</h5></center>
               </div>   
            </a>
            <a href="<?= base_url('AICTE-360degreefeedback/Past-Webinar');?>"><center><img src="<?= base_url();?>Assets/image/webinar.png" class="rounded mx-4 shadow-lg p-3 bg-white rounded"></center>
               <div class="card-body">
                  <center><h5 class="card-title">Past Webinar</h5></center>
               </div>
            </a>
            <a href="<?= base_url('AICTE-360degreefeedback/Upcoming-Events');?>"><center><img src="<?= base_url();?>Assets/image/event.png" class="rounded mx-4 shadow-lg p-3  bg-white rounded"></center>
               <div class="card-body">
                  <center><h5 class="card-title">Upcoming Events</h5></center>
               </div>
            </a>
            <a href="<?= base_url('Assets/documents/AICTE_360_Degree_Feedback_Login_Activation_20210210.pdf');?>" target="_blank"><center><img src="<?= base_url();?>Assets/image/login.png" class="rounded mx-4 shadow-lg p-3  bg-white rounded"></center>
               <div class="card-body">
                  <center><h5 class="card-title">Login/Activation</h5></center>
               </div>
            </a>
            <a href="<?= base_url('Assets/documents/AICTE_360_Degree_Feedback_Implementation_Manual_20210123.pdf');?>" target="_blank"><center><img src="<?= base_url();?>Assets/image/help.png" class="rounded mx-4 shadow-lg p-3 bg-white rounded"></center>
               <div class="card-body">
                  <center><h5 class="card-title">Help</h5></center>
               </div>
            </a>
        </div>
    </div>
    
    <footer id="footer" style="min-height: 3.5rem;"class="bg-dark p-2 text-center align-items-middle  text-white">

        <div>

          <strong><span>Powered By Smart Cookie Rewards PVT.LTD.</span></strong>

        </div>
            
    </footer>
    
</body>

</html>