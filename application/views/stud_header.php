<?php 
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
//$school_type variable added by Sayali to display project/subject accordingly in SMC-4610 on 22/9/2020.
$school_type = $studentinfo[0]->school_type;
$Academic_Year = $studentinfo[0]->std_academic_year;
 ?>
<!DOCTYPE html>
<html lang="en">
<head><title>
<?php if($isSmartCookie) { ?> 
SmartCookie
<?php }else{ ?>
Protsahan-Bharati
<?php } ?>
</title>
    <meta charset="utf-8">
    <meta https-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  

    <!--Loading bootstrap css-->
 
<!--
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">  
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,700,300">
-->
    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/themes/style3/green-grey.css" id="theme-change" class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/css/style-responsive.css">
 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/css/coupon_style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/bootstrap/css/bootstrap.css">
</head>
<style>
.error
{
	color:red;
}

#sofrreward {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.sofrreward {
    float: left;
}
    
    .rating_model{ 
         
/*        margin: 110px !important;*/
    }
    
    .modal .modal-dialog .modal-content {
    -webkit-border-radius: 0 !important;
    -moz-border-radius: 0 !important;
    border-radius: 10px !important;
 
} 
.project{
	position: absolute;
    display: inline-block;
	width:50%;
	top:1rem;
	margin-left:10px;
}
.project-bar {
    height: 25px;
	display: inline-block;
    background: #e0e0e0;
	position: relative;
	z-index: 10;
    border-radius: 12px;
	width:90%;
}
.project-percent {
    height: 25px;
    background-color: #2196F3;
    border-radius: 30px;
    position: relative;
    width: 0;
    transition: 2s linear;
}
.project-percent:hover{
	cursor: pointer;
}
.project-percent::before {
    content: attr(percent);
    position: absolute;
    right: 0px;
    left: 0px;
    padding: 1px 0px;
    color: #ffffff;
    font-size: 15px;
    border-radius: 25px;
    font-weight: bold;
    width: 20px;
    margin: 0px auto;
}
</style>

<body>
    
<!--    <script src="<?php //echo base_url(); ?>Assets/js/jquery-3.4.0.js"></script> -->
	
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
                <a id="logo" href="<?php echo base_url(); ?>/main/members" class="navbar-brand"><span class="fa fa-rocket"></span>
				
				<span class="logo-text">
				<?php if($isSmartCookie) { ?>
				SmartCookie
				<?php }else{ ?>
				<font size="5">Protsahan-Bharati</font>
				<?php } ?>
				</span></a></div>
				<?php 
				$std_info= array_values((array) $studentinfo[0]);
				//print_r($std_info);
				// print_r($studentinfo[0]);
									$count=0;
									// x 29 is academic yr
					for ($x = 0; $x <= count($std_info); $x++) {
						if($x==0 || $x==3 || $x==5 || $x==6 || $x==7 || $x==9  || $x==10 || $x==11 || $x==14 || $x==15 || $x==16 || $x==17 || $x==18 || $x==19 || $x==20 || $x==21 || $x==23 || $x==25 || $x==26 || $x==30 || $x==36 || $x==37 || $x==38){
							if(is_null($std_info[$x]) || empty($std_info[$x]) || $std_info[$x] =='' ){
								// echo "blanck";
								continue;
								
							}else{
								$count++;
								//echo "<center>".$std_info[$x] . "<br></center>";
							}
						}
						else{
						continue;
						}
					}
						
					
					$persent_fraction= ($count*100)/23;
					$persent=ceil($persent_fraction);
					//echo "Count value " . $count;
					//echo "Ceil  value " . $persent;
					// exit;
				
				?>
                                            <input type="hidden" name="hdn_val" value="<?php echo $persent; ?>" id="hdn_persent"	>
            <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
            	<i class="fa">
            		 <div style="position:relative;color:white;font-size:3.0rem;"><h4>Profile Completed  </h4></div>
			        
            	</i>
            	<!-- <i class="fa">
            		<div style="color:white;"><h4>Profile Completed:</h4></div>
            		<div id="rt_nav" style="position:relative;float:right;right:10%;top:5px;font-size:2.0rem;">
                    <span style="color:white;"></span>
                   </div>
            	</i> -->
				<div class="project">
					<div class="project-bar">
						<div class="project-percent" percent="70"></div>
					</div>
        		</div>

             
			<!-- <div class="div" id="rt_nav" style="position:relative;float:right;right:15%;top:10px;font-size:1.5rem">
				<span style="color:white;"></span>
			</div> -->
                <ul class="nav navbar navbar-top-links navbar-right mbn" >
                
                    <li class="dropdown topbar-user">
					
					<?php if($studentinfo[0]->std_img_path=="")
					{
					
							 $this->load->helper('imageurl'); ?>
                            <a data-hover="dropdown" href="#" class="dropdown-toggle">	
								<img src="<?php echo imageurl($studentinfo[0]->std_img_path,'avatar','sp_profile');?>" alt="" class="img-responsive img-circle" />
								
					<?php	
					}
					else
					{
						?>		<a data-hover="dropdown" href="#" class="dropdown-toggle">
								<img src="<?php echo base_url().'core/'?><?php echo $studentinfo[0]->std_img_path?>" alt="" class="img-responsive img-circle" /> 
				    <?php
					}
					?>
					
				
                                        
				
                                <span class="hidden-xs"><?php  if($studentinfo[0]->std_complete_name!="")
											{
												
												echo ucwords(strtolower($studentinfo[0]->std_complete_name));
											}
											else
											{
											echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname	));	
											} ?></span>&nbsp;<span class="caret"></span>
                            </a>
                        <ul class="dropdown-menu dropdown-user pull-right">
						
                           <li><a id="iconid" href="<?php echo base_url();?>/main/update_profile"><i  class="fa fa-user"></i>My Profile</a></li>
    
<li><a href="<?php echo base_url();?>/main/id_card"><i class="fa fa-key"></i>My ID Card</a></li>                           

						   <li><a href="<?php echo base_url();?>/main/logout"><i class="fa fa-key"></i>Log Out</a></li>
                        </ul>
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
<?php if($studentinfo[0]->std_img_path=="")
					{?>
	<img src="<?php echo imageurl($studentinfo[0]->std_img_path,'avatar','sp_profile');?>"  alt="" class="img-circle"/>
					<?php 
					}
					else{
						?><img src="<?php echo base_url().'core/'?><?php echo $studentinfo[0]->std_img_path?>"  alt="" class="img-circle" >
						<?php
					}
					?></div>
                    <!--<div style="width:30px;height:50px;">-->
                 
					
                                        
						
                        <div class="info">
                            <p><?php 
                                            if($studentinfo[0]->std_complete_name!="")
											{
												
												echo ucwords(strtolower($studentinfo[0]->std_complete_name));
											}
											else
											{
											echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname	));	
											}
											?>
											<br> 
											<?php
											
											 if($studentinfo[0]->status=='Y')
											 {
												 
						 if($this->session->userdata('usertype')=='student'){   
												echo "(".ucfirst($this->session->userdata('usertype')).")"; 
											 }else
											 {
												 echo "(".ucfirst($this->session->userdata('usertype')).")"; 
												 
											 }}else
											 {
												 echo "(".ucfirst($this->session->userdata('usertype')).")"; 
												 
											 }?>
											<br>  
				<!--Member ID added by Pranali for SMC-4674 on 21-4-20-->
											Member ID : <?php 
											echo $this->session->userdata('stud_id'); ?>
											</p>
											 Admission Year:<?php
											  if(count($current_acadmic_year>0)){ echo $Academic_Year;
											  // $current_acadmic_year[0]['Academic_Year'];
											} else{echo ""; } ?>
							<ul class="list-inline list-unstyled">
                                <li><a href="<?php echo base_url();?>/main/update_profile" data-hover="tooltip" title="Profile"><i class="fa fa-user"></i></a></li>
                               
                                <li><a href="<?php echo base_url();?>/main/logout" data-hover="tooltip" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                            </ul> 				
											
							
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <li>
                    
                     <div>
                  <ol id="sofrreward">
					<?php 
					 
					$studentzerokey = $studentinfo[0];
					unset($studentinfo[0]);
                   // $studentimage = array_shift($studentinfo);   
					//
					
					
					
					
				/*	if($studentinfo[1]!='')
					{
						
						/*if($studentinfo[0]->imagepath='')
						{
							
								?>
								<li class="sofrreward">
								<img src="<?php echo base_url()."core/images/200_76.png"; ?>" name="star" height="20" width="20" class="img-responsive" >
                     
								</li>
							
								<?php
							
						}*/
					/*	foreach($studentinfo as $r)
						{*/
                      
							?>
							<!--<li class="sofrreward">
							<img src="<?php //echo base_url()."core/".$r->imagepath; ?>" name="star" height="20" width="20" class="img-responsive" >
                     
							</li>-->
							<?php 
					//	}
						
					//	}
						
						
						
						?>
                     
                     
					
					<?php
                    
					array_unshift($studentinfo,$studentzerokey);
					
					?>
                    </ol>
					</div>
                    
                    </li>

                  
					
		                    <li <?php
					
					
					if(strpos(uri_string(), 'main/members') !== FALSE or strpos(uri_string(),'main/friendship_log' ) !== FALSE or strpos(uri_string(),'main/showcoupon' ) !== FALSE ){ echo 'class="active"'; }; ?> ><a href="<?php echo site_url();?>/main/members"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title">DashBoard</span></a></li>

                    <?php
                    /*Below condition added by Rutuja for shifting AICTE option after Dashboard for Student for SMC-5012 on 16-12-2020*/
							 if($this->session->userdata('usertype')=='student'){   ?> 

                    <li <?php
 
                        
                        if(uri_string()=='aictefeed/aicte_feedback' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>aictefeed/aicte_feedback">
                            <i class="fa fa-graduation-cap"></i>
                            <span class="menu-title">AICTE Feedback</span>
                        </a>
                    </li>
                    <?php } ?> 
                     
                        <li <?php if(uri_string()=='main/softreward_log' or uri_string()=='main/student_purchasepoints_log' or uri_string()=='main/rewards_log' or uri_string()=='main/usedcoupon_log' or uri_string()=='main/accepted_requests_log' or uri_string()=='main/send_requests_log'  or uri_string()=='main/assign_coordpointslog' or uri_string()=='main/self_motivation_log' or uri_string()=='main/thanQ_log' or uri_string()=='main/shared_log' or uri_string()=='main/purple_points_log' ){
							echo 'class="active"'; 
						} ?>><a href="#"><i class="fa fa-th-list fa-fw">
                       
                  
                    </i><span class="menu-title">Logs</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level"> 

<li <?php
							
						
							 if(uri_string()=='main/softreward_log' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/softreward_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Soft Reward Log</span></a></li>
                                            
                                            <li <?php
							
						
							 if(uri_string()=='main/rewards_log' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/rewards_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Reward Points Log</span></a></li>



<!--Brown Points Log added by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3479 on 25/04/2019-->
						<!--Added same code for SMC-4388 by Sayali Balkawade on 9/1/2020--> 
						 <li <?php if(uri_string()=='main/brown_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/brown_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Brown Points Log</span></a></li>

                            <li <?php
							
						
							 if(uri_string()=='main/usedcoupon_log' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/usedcoupon_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Used Coupons Log</span></a></li>
                            <li <?php
							
						
							 if(uri_string()=='main/self_motivation_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/self_motivation_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Self Motivation Log</span></a></li>
                                            <li <?php
							
						
							 if(uri_string()=='main/thanQ_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/thanQ_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">ThanQ Points Log</span></a></li>
                                            
                                            
                                            <li <?php
							
						
							 if(uri_string()=='main/shared_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/shared_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Shared Points Log</span></a></li>
                         <?php  if($this->session->userdata('usertype')=='student'){?>
						<li <?php if(uri_string()=='main/purple_points_log'){ 
							//SMC-5138 by Pranali : UI : Rename Purple points log name to Family points log in student header

											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/purple_points_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Family Points Log</span></a></li>
							 <?php }?>
							<li <?php 
							 
							 if(uri_string()=='main/student_purchasepoints_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/student_purchasepoints_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Water Points Log</span></a></li>
<?php 
  if($this->session->userdata('usertype')=='student'){
						 if($studentinfo[0]->status=='Y')
						 {?>
					 
					 <li <?php
					
							if(strpos(uri_string(), 'main/assign_coordpointslog') !== FALSE )
						
							{ 
											echo 'class="active"'; } ?> >
											<a href="<?php echo site_url();?>/main/assign_coordpointslog"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Assign Points On The Behalf Of Teacher Log</span></a></li>
							 
					 
					 
						 <?php }?>
						 
						  <?php }?>
						<li <?php if(uri_string()=='main/accepted_requests_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/accepted_requests_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Accepted Requests Points Log</span></a></li>
 						<li <?php if(uri_string()=='main/send_requests_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/send_requests_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Send Requests Points Log</span></a></li>
											
											<li <?php if(uri_string()=='main/activity_log'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/activity_log"><i class="fa fa-hand-o-up"></i><span class="submenu-title">Activity Log</span></a></li>

						
                        </ul>
                    </li>
                     
                      <li <?php
							
						
							 if(uri_string()=='main/unused_coupons' or uri_string()=='main/partiallyused_coupons' ){ 
											echo 'class="active"'; } ?>><a href="#"><i class="fa fa-file-o fa-fw">
                       
                  
                    </i><span class="menu-title">SmartCookie Coupons</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li <?php
							
						
							 if(uri_string()=='main/unused_coupons' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/unused_coupons"><i class="fa fa-briefcase"></i><span class="submenu-title">Unused SmartCookie Coupons</span></a></li>
                            <li <?php
							
						
							 if( uri_string()=='main/partiallyused_coupons' ){ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url();?>/main/partiallyused_coupons"><i class="fa fa-briefcase"></i><span class="submenu-title">Partial Used  Coupons </span></a></li>
                          
                          
                                                   
                        </ul>
                    </li>
                 
                     <li <?php
							if((uri_string()=='main/show_studlist') or strpos(uri_string(), 'main/assignThanQpoints') !== FALSE or strpos(uri_string(), 'main/purchase_softrewards') !== FALSE or (uri_string()== 'main/assign_points')  or strpos(uri_string(), 'main/Thanq_Assignpoints') !== FALSE or strpos(uri_string(), 'main/show_student') !== FALSE or strpos(uri_string(), 'main/share_points') !== FALSE or strpos(uri_string(), 'main/waterpoints') !== FALSE or strpos(uri_string(), 'main/waterpoints') !== FALSE or strpos(uri_string(), 'main/student_purchase_points') !== FALSE or strpos(uri_string(), 'main/social_media_points') !== FALSE)						
							{ 
								echo 'class="active"';
								
							}
							else{
								echo 'class="off"';
							}
							?>>
							<a href="#"><i class="fa fa-suitcase">
							</i><span class="menu-title">Points</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">

						<?php
							 if($this->session->userdata('usertype')=='student'){
							if(($studentinfo[0]->status=='Y') || ($studentinfo[0]->status=='y'))
							{
						?>  
							 <li <?php
									if(uri_string()=='main/show_studlist' or uri_string()=='main/assign_points' )						
									{ 
										echo 'class="active"'; } ?> ><a href="<?php echo site_url();?>/main/show_studlist"><i class="fa fa-th-large"></i><span class="submenu-title">

										<!-- Camel casing done for Assign Points On Behalf of Teacher by Pranali-->
										Assign Points On Behalf of <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></span></a></li>
						
						 <?php 
							}	
							 }
						 ?>
                            <li <?php
					
							if(strpos(uri_string(), 'main/studentlist') !== FALSE or strpos(uri_string(), 'main/show_student') !== FALSE or strpos(uri_string(), 'main/share_points') !== FALSE )
						
							{ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url();?>/main/show_student"><i class="fa fa-th-large"></i><span class="submenu-title">Share Points</span></a></li>
                            <li   <?php
							
					
							 if(strpos(uri_string(), 'main/assignThanQpoints') !== FALSE or strpos(uri_string(), 'main/Thanq_Assignpoints') !== FALSE ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/assignThanQpoints"><i class="fa fa-th-large"></i><span class="submenu-title">ThanQ Points </span></a></li>
                           <li <?php
					
							if(strpos(uri_string(), 'main/student_purchase_points') !== FALSE  or strpos(uri_string(), 'main/waterpoints') !== FALSE )
						
							{ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url();?>/main/waterpoints"><i class="fa fa-th-large"></i><span class="submenu-title">Purchase Points </span></a></li>
                           <li  <?php
					
							if(strpos(uri_string(), 'main/social_media_points') !== FALSE  )
						
							{ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/social_media_points"><i class="fa fa-th-large"></i><span class="submenu-title">Self Motivation</span></a></li> 


 <li <?php
					
							if(strpos(uri_string(), 'main/purchase_softrewards') !== FALSE  )
						
							{ 
											echo 'class="active"'; } ?> ><a href="<?php echo site_url();?>/main/purchase_softrewards"><i class="fa fa-th-large"></i><span class="submenu-title">Soft Rewards</span></a></li>
                                                   
          											
                        </ul>
                    </li>
                     
                     <li <?php					
							if(strpos(uri_string(), 'main/student_requestlist') !== FALSE  or strpos(uri_string(), 'main/pending_request_student') !== FALSE or strpos(uri_string(), 'main/showstudent_for_request') !== FALSE or strpos(uri_string(), 'main/teacherlist_coordinator') !== FALSE or	(uri_string()== 'main/send_reuest_to_student')  or strpos(uri_string(), 'main/teacherlist_request') !== FALSE or strpos(uri_string(), 'main/send_requestteacher') !== FALSE or (uri_string()=='main/show_studlistfor_request') or strpos(uri_string(), 'main/request_to_join_samrtcookie') !== FALSE  or strpos(uri_string(), 'main/request_to_join_samrtcookie') !== FALSE)  
							{ 
								echo 'class="active"'; 
							} 
						?>>
					<a href="#">
						<i class="fa fa-group"></i>
						<span class="menu-title">Requests</span><span class="fa arrow"></span>
					</a>
                        <ul class="nav nav-second-level">
                            <li <?php
									if(strpos(uri_string(), 'main/student_requestlist') !== FALSE   or strpos(uri_string(), 'main/pending_request_student') !== FALSE  )
									{ 
										echo 'class="active"'; 
									} 
								?> >
								<a href="<?php echo site_url();?>/main/student_requestlist"><i class="fa fa-group"></i><span class="submenu-title">Points Requests from <?php echo ($this->session->userdata('usertype')=='employee')?'Employees':'Students'; ?></span>
								</a>
							</li>
							<li <?php
									if(strpos(uri_string(), 'main/teacherlist_request') !== FALSE or strpos(uri_string(), 'main/send_requestteacher') !== FALSE  )
									{ 
										echo 'class="active"'; 
									} 
								?>>
								<a href="<?php echo site_url();?>/main/teacherlist_request"><i class="fa fa-group"></i><span class="submenu-title">Points Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> </span>
								</a>
							</li> 
							<li <?php
									if(uri_string()=='main/show_studlistfor_request'  or uri_string()== 'main/send_reuest_to_student' )
									{ 
										echo 'class="active"';
									} 
								?> >
								<a href="<?php echo site_url();?>/main/show_studlistfor_request"><i class="fa fa-group"></i><span  class="submenu-title" >Points Request To Other <?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> </span>
								</a>
							</li>						
							<li <?php
									if(strpos(uri_string(), 'main/request_to_join_samrtcookie') !== FALSE  or strpos(uri_string(), 'main/request_to_join_samrtcookie') !== FALSE )
									{ 
										echo 'class="active"'; 
									} 
								?> >
								<a href="<?php echo site_url();?>/main/request_to_join_samrtcookie"><i class="fa fa-group"></i><span class="submenu-title">
								<?php if($isSmartCookie) { ?>
								Request To Join SmartCookie 
								<?php }else{ ?>
								Request To Join Protsahan-Bharati
								<?php } ?>
								</span>
								</a>
							</li>
						    <li <?php
									// VaibhavG Added below more conditions in if() to check whether student is co-ordinator or not then show menu 28Sept18 1:50PM 
									if(($studentinfo[0]->status=='') || ($studentinfo[0]->status==NULL) || ($studentinfo[0]->status=='N') || ($studentinfo[0]->status=='n'))
									{
										if(strpos(uri_string(), 'main/teacherlist_coordinator') !== FALSE)
										{ 
											echo 'class="active"'; 
										} ?> >
										<a href="<?php echo site_url();?>/main/teacherlist_coordinator"><i class="fa fa-th-large"></i><span class="submenu-title">Coordinator Request To <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?> </span>
										</a>
								<?php 
									}
								?>
							</li>       
                        </ul>
                    </li>
                    <li  <?php
					
					
					 if(uri_string()=='main/student_subjectlist'){ echo 'class="active"'; }; ?>><a href="<?php echo site_url();?>/main/student_subjectlist"><i class="fa fa-database fa-fw">
                       
<!--$school_type=='organization' condition checked by Pranali for SMC-4263 on 9-1-20 -->
<!--school type condition modified by Pranali for SMC-4424 on 24-9-20 --> 
                    </i><span class="menu-title">My <?php echo ($studentinfo[0]->school_type=='organization')?'Projects':'Subjects'; ?></span></a>
                        
                    </li>
                     <li  <?php
					
					
					 if(uri_string()=='main/Add_subject_view'){ echo 'class="active"'; }; ?>><a href="<?php echo site_url();?>/main/Add_subject_view"><i class="fa fa-database fa-fw">
                       
                  
                    </i><span class="menu-title"><?php echo ($studentinfo[0]->school_type=='organization')?'Add Project':'Add Subject'; ?></span></a>
    <!--End SMC-4263 -->            
                    </li>
                 
                    <?php if($this->session->userdata('usertype')=='employee'){ ?>       
                    	<li <?php if(uri_string()=='main/Employee_activity_summary' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>main/Employee_activity_summary"><i class="fa fa-warning"></i><span class="menu-title">Employee Activity Summary Report</span></a></li>
                    <?php } ?>
<?php 
//Sponsor options hided for employee as per discussion with Rakesh Sir for SMC-4387 on 18-1-20
if($studentinfo[0]->school_type!='organization'){
?>
                    <li  <?php
					
					
					 if(uri_string()=='main/sponsor_map'){ echo 'class="active"'; }; ?> ><a href="<?php echo site_url();?>/main/sponsor_map "><i class="fa fa-bar-chart-o fa-fw">
                       
                  
                    </i><span class="menu-title">Sponsor Map</span></a>
                       
                    </li>
                    
                    
                                    
					<!-- sponsor coupons-->
						<?php $this->load->view('coupons/coupon_navigation'); 

}
					

				?>
					<!-- sponsor coupons end-->
                    
                    
                    
          <?php
							 if($this->session->userdata('usertype')=='student'){   ?>       
                    
                    
                   <li <?php
							
						
							 if(uri_string()=='main/my_parent' ){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>/main/my_parent"><i class="fa fa-briefcase"></i><span class="menu-title">My Parent</span></a></li>
                    
                    
                    <li <?php 
                    
                        if(uri_string()=='aictefeed/stud_blog'){ 
											echo 'class="active"'; } ?>><a href="<?php echo site_url();?>aictefeed/stud_blog">
                             <i class="fa fa-hand-o-up"></i>
                            <span class="menu-title">Blog</span>
                        </a>

 
                    </li> 


							 <?php } ?>

                </ul>
            </div>
        </nav>
        <!--END SIDEBAR MENU-->
		<!--BEGIN CHAT FORM-->
        <div id="chat-form" class="fixed">
        
        </div>
       
               
			   <?php if(uri_string()=='Ccoupon/select_coupon' or 
								uri_string()=='Ccoupon/cart' or
								uri_string()=='Ccoupon/unused_coupons' or
								uri_string()=='Ccoupon/used_coupons' or 
								uri_string()=='Ccoupon/suggested_sponsors' or
								uri_string()=='Ccoupon/suggest_sponsor'){ 
								echo '<div id="page-wrapper">
								<div class="page-content">
								<div id="tab-general">';
						} ?>
</body>
<script>
	$(document).ready(function(){
		var persentage= $("#hdn_persent").val();
		$("#rt_nav span").append(persentage + "% ");
		// progress baar animation for edit profile start
		
		$('.project-percent').each(function(){
    var $this = $(this);
    var percent = $this.attr('percent');
	percent = $("#hdn_persent").val();
    $this.css("width",percent+'%');
    $({animatedValue: 0}).animate({animatedValue: percent},{
        duration: 2000,
        step: function(){
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
        },
        complete: function(){
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
        }
    });
	});

	$(".project-percent").on('click',function(){
		window.location.href='<?php echo base_url()."main/update_profile" ; ?>'
	})

	});
</script>
</html>