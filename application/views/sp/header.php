<?php //print_r($user); ?>
<!DOCTYPE html>
<html lang="en">
<head><title>SmartCookie :: Sponsor</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/bootstrap/css/bootstrap.min.css">
    <!--LOADING STYLESHEET FOR PAGE-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/intro.js/introjs.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/calendar/zabuto_calendar.min.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-pace/pace.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/iCheck/skins/all.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/jquery-news-ticker/jquery.news-ticker.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/themes/style3/red-dark.css" id="theme-change" class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/style-responsive.css">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/jquery.dataTables.css">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/coupon_style.css">
<style>
.panel {
    border: 0px solid #e5e5e5;
}
.form-control {
    border: 1px solid #e5e5e5;
}
.btn{
    border: 1px solid #e5e5e5;	
}
</style>
</head>
<body>
	
	<script src="<?php echo base_url(); ?>Assets/js/jquery-1.11.1.min.js"></script>	
	<script src="<?php echo base_url(); ?>Assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url(); ?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
<div>
	<!--BEGIN BACK TO TOP--><a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP-->
	<!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" data-intro="&lt;b&gt;Topbar&lt;/b&gt; has other styles with live demo. Go to &lt;b&gt;Layouts-&gt;Header&amp;Topbar&lt;/b&gt; and check it out." class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                <a id="logo" href="<?php echo base_url(); ?>" class="navbar-brand"><span class="fa fa-rocket"></span><span class="logo-text">SmartCookie</span></a></div>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
             
                <ul class="nav navbar navbar-top-links navbar-right mbn">
                
                    <li class="dropdown topbar-user" >
					<?php $this->load->helper('imageurl'); ?>
					
                           
                        
                        
                            <li><a href="<?php echo site_url('Csponsor/logout'); ?>"><i class="fa fa-key"></i>Log Out</a></li>
                        
                    </li>
               
                </ul>
            </div>
        </nav>

    <div id="wrapper"><!--BEGIN SIDEBAR MENU-->
        <nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;" data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
				
				
                    <li class="user-panel">
                        <div class="thumb">
						<?php
							$server_name = $_SERVER['SERVER_NAME'];
							if($user[0]->sp_img_path != '')
							{
								//VaibhavG Here with I've added below code to update Shop image on web when a user updates shop image from Sponsor Android App for the ticket number SMC-3484 on 3Oct2018.
								$explode = explode("/",$user[0]->sp_img_path);
								if($explode[0]=='image_sponsor')
									$logoexist="https://$server_name/core/".$user[0]->sp_img_path;
								else
									$logoexist="https://$server_name/core/image_sponsor/".$user[0]->sp_img_path;
							}
							else{
								$logoexist="https://$server_name/Assets/images/avatar/avatar_2x.png";
							}
						?>
						<img src="<?php echo $logoexist; ?>" alt="" class="img-circle"/>
						<!--previous code
						<img src="<?php //echo imageurl($user[0]->sp_img_path,'avatar','sp_profile'); ?>" alt="" class="img-circle"/>-->
						</div>
                        <div class="info">
                            <p><b><?=$user[0]->sp_company;?></b></p>                            
                            <p>Sponsor</p>
							<div class='row text-center' style='background-color:#CF4346;'>
							<p><?='SP'.$user[0]->id;?></p>
							</div>
							
							
                        </div>
                        <div class="clearfix"></div>
                    </li>
<!--Default view of Profile given by Pranali for SMC-3697 -->
                    <li <?php if(uri_string()=='Csponsor/search_spcoupon_form' or uri_string()=='Csponsor/page/accept_coupon' or uri_string()=='Csponsor'){ echo 'class="active"'; }; ?> ><a href="<?php echo site_url('Csponsor/page/accept_coupon'); ?>"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">Dashboard</span></a></li>
					
					
					<li <?php if(uri_string()=='Csponsor/page/log_generated_coupons' or 
						uri_string()=='Csponsor/page/log_accepted_sc_coupons' or 
						uri_string()=='Csponsor/page/log_accepted_sp_coupons' or
						uri_string()=='Csponsor/page/log_collegewise_sp_coupon_usage'	
						){
							echo 'class="active"'; 
						} ?> >
					<a href="#"><i class="fa fa-database fa-fw">
                        <div class="icon-bg bg-red"></div>
                    </i><span class="menu-title">Coupons Log</span><span class="fa arrow"></span><!--<span class="label label-yellow">New</span>--></a>
                        <ul class="nav nav-second-level">
                         
							<li <?php if(uri_string()=='Csponsor/page/log_generated_coupons'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Csponsor/page/log_generated_coupons'); ?>">
									<i class="fa fa-angle-right"></i>
									<span class="submenu-title">Generated Coupons</span>
								</a>
							</li>
                            <li <?php if(uri_string()=='Csponsor/page/log_accepted_sc_coupons' or 
										uri_string()=='Csponsor/page/log_collegewise_sp_coupon_usage' or 
										uri_string()=='Csponsor/page/log_accepted_sp_coupons' ){
										echo 'class="active"'; } ?> >
						<a href="#"><i class="fa fa-tencent-weibo"></i><span class="submenu-title">Accepted Coupons</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li <?php if(uri_string()=='Csponsor/page/log_accepted_sc_coupons'){ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url('Csponsor/page/log_accepted_sc_coupons'); ?>"><i class="fa fa-angle-right"></i><span class="submenu-title">SmartCookie</span></a></li>
                                    <li <?php if(uri_string()=='Csponsor/page/log_accepted_sp_coupons'){ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url('Csponsor/page/log_accepted_sp_coupons'); ?>"><i class="fa fa-angle-right"></i><span class="submenu-title">Sponsor</span></a></li>
                                    <li <?php if(uri_string()=='Csponsor/page/log_collegewise_sp_coupon_usage'){ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url('Csponsor/page/log_collegewise_sp_coupon_usage'); ?>"><i class="fa fa-angle-right"></i>
											<!-- Camel Casing in email done by Pranali for bug SMC-2275 on 9-7-2018-->
											<span class="submenu-title">Organization Wise Sponsor Coupon Usage</span></a></li>
<!--Membership Discount Log menu added by Pranali for SMC-3773 on 16-5-19 -->
											 <li <?php if(uri_string()=='Csponsor/page/log_membership_discount'){ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url('Csponsor/page/log_membership_discount'); ?>"><i class="fa fa-angle-right"></i>
											<span class="submenu-title">Membership Discount Log</span></a></li>
                                    
                                </ul>
                            </li>
                 
                        </ul>
                    </li>
					
									
                   <li <?php if(uri_string()=='Csponsor/page/product_setup' or 
										uri_string()=='Csponsor/add_product' or 
										uri_string()=='Csponsor/add_discount' or
										uri_string()=='Csponsor/add_coupon' or	
										strpos(uri_string(),'Csponsor/edit_coupon') or
										uri_string()=='Csponsor/sponsor/'.$user[0]->id or
										uri_string()=='Csponsor/page/sp_coupon') { 
								echo 'class="active"'; 
						} ?> >
					<a href="#"><i class="fa fa-desktop fa-fw"></i>
					<span class="menu-title">Setup</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li <?php if(uri_string()=='Csponsor/page/product_setup' or 
										uri_string()=='Csponsor/add_product' or
										uri_string()=='Csponsor/add_discount'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Csponsor/page/product_setup'); ?>"><i class="fa fa-briefcase"></i><span class="submenu-title">Products & Discounts</span></a></li>
                            <li <?php if(uri_string()=='Csponsor/page/sp_coupon' or	
							strpos(uri_string(),'Csponsor/edit_coupon') or
							uri_string()=='Csponsor/add_coupon'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Csponsor/page/sp_coupon'); ?>"><i class="fa fa-th-large"></i><span class="submenu-title">Sponsor Coupon Setup</span></a></li>
							<li <?php if(uri_string()=='Csponsor/sponsor/'.$user[0]->id){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Csponsor/sponsor/'.$user[0]->id); ?>"><i class="fa fa-picture-o"></i><span class="submenu-title">Proud Sponsor of SmartCookie</span></a></li>
                        </ul>
                    </li>
					 
					<li <?php if(uri_string()=='Csponsor/product_gallery'){ 
											echo 'class="active"'; } ?> >
						<a href="<?php echo base_url('Csponsor/product_gallery')?>"><i class="fa fa-picture-o"><div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">My Product Gallery</span></a>
                    </li>
					
					<li <?php if(uri_string()=='Csponsor/page/sponsor_map'){ echo 'class="active"'; }; ?> >
					<a href="<?php echo site_url('Csponsor/page/sponsor_map'); ?>"><i class="fa fa-map-marker">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Sponsor Map</span></a>
					</li>
					
					
					<li <?php if(uri_string()=='Csponsor/page/profile' or uri_string()=='Csponsor/page/edit_profile'){ echo 'class="active"'; }; ?> ><a href="<?php echo site_url('Csponsor/page/profile'); ?>"><i class="fa fa-edit fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Profile</span></a>
					</li>
<!--End code for SMC-3697 -->					
					<li><a href="<?php echo site_url('Allshops'); ?>"><i class="fa fa-group fa-fw">
                        <div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Another Shop</span></a>
					</li>

                    <li <?php if(uri_string()=='Csponsor/sp_my_qr_code/'.$user[0]->id){ echo 'class="active"'; }; ?> >
					<a href="<?php echo base_url('Csponsor/sp_my_qr_code/'.$user[0]->id)?>"><i class="fa fa-qrcode fa-fw"><div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">My QR Code</span></a>
                    </li>
					
					<!--<li><a href="<?php echo base_url('Csponsor/sp_create_website/'.$user[0]->id)?>"><i class="fa fa-home fa-fw"><div class="icon-bg bg-green"></div>
                    </i><span class="menu-title">Create Website</span></a>
                    </li>-->
					<!-- sponsor coupons-->
						<?php $this->load->view('coupons/coupon_navigation'); ?>
					<!-- sponsor coupons end-->
					
                </ul>
            </div>
        </nav>
        <!--END SIDEBAR MENU-->
		<!--BEGIN CHAT FORM-->
        <div id="chat-form" class="fixed">
        
        </div>
        <!--END CHAT FORM--><!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <div class="page-content">
                <div id="tab-general">
               
 