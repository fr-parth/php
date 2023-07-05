 <?php include_once('function.php');

	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 $id=$_SESSION['id'];
	   $entity=$_SESSION['entity'];
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $std_PRN=$value['std_PRN'];
	 $query_points = mysql_query("select sc_total_point,yellow_points,sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = '$std_PRN'");
	 $row_points = @mysql_fetch_array($query_points);
	 
include 'up_cart.php';

?>


 
 
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>:: Smart Cookie-Student::</title>

<!-- Bootstrap -->
<link href="bootstrap.css" rel="stylesheet">
<link href="css/coupon_style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open+Sans:300italic,400italic,400,300,600:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
  
  <style>
  h1
{
  margin: 0px;
  padding: 0px 0px 5px;
  font-size: 24px;
  line-height: 1.333;
  font-family: Arial,Helvetica,sans-serif;
  font-weight: normal;color:#0073BD;
  }
  
  .pro_picbox {
  text-align: center;
  padding: 16px 0px;
  background: #027cd5;
}

.logo img
{
width:32%;
}
.navbar-nav {
float:left;
}
  </style>
  <!-- font-family: 'Open Sans', sans-serif; -->
</head>
<body>
<div class="navbar-fixed-top ">
<!----========================= header_title Start ---->
    <div class="header_title">
      <div class="container">  
       <div class="row">                  
                           
                   <div class="col-xs-9 col-sm-10 col-md-11">
                   <div class="ht_box">
                     <p><strong>Member ID :</strong> <?php 
						echo "S".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?></p> 
                     <p><strong>College name :</strong>  <?php echo $value['std_school_name'];?></p>
                     <p><strong>Student name :</strong> <?php   if($value['std_name']==""){
			   echo $value['std_email'];
			   } 
			   else {echo $value['std_name']." ".$value['std_lastname'];}?></p>
                     </div>
                   </div> 
   <?php		
					
		$user_cart =mysql_query("SELECT * FROM cart WHERE `user_id` ='$user_id' and `entity_id` ='$entity' and `coupon_id` IS NOT NULL");
		$total_cart_items = mysql_affected_rows(); 
		if($total_cart_items==0){
	?>
			<a href="cart.php"><div class="col-xs-3 col-sm-2 col-md-1 cartbox">
            <span class="carttext">0		 
            </span>
			</div></a>
	
	<?php }else{ ?>	
			
			<a href="cart.php"><div class="col-xs-3 col-sm-2 col-md-1 cartbox">
            <span class="carttext">	
			<?php 
			echo $total_cart_items; 
			?>
            </span>
			</div></a>
	
	<?php }  ?>
                   
           </div>
       </div>
       </div>
<!----========================= header_title end ---->

<!----========================= header_main Start ---->
       <div class="header_main">
      <div class="container">  
       <div class="row">                          
                   <div class="col-md-8 col-sm-6 col-xs-5 logo"><img src="images/logo.png" class="img-responsive"></div>
                   
                   <div class="col-md-4 col-sm-6 col-xs-7 hedpoint_box">
                         <div class="col-xs-8" style="height:111px;">
                            
                               
                                
                         </div>
                         <div class="col-xs-4 pro_picbox" style="height:111px;">
                        <?php if($value['std_img_path'] != ''){?>
                <img src="<?php echo $value['std_img_path'];?>" alt="" class="img-circle" style="height:50px;width:50px">
                <?php }else { ?> <img src="image/avatar_2x.png" alt="" class="img-circle" style="height:50px;width:50px"/> <?php }?>
                         
                         
                          <?php 
			$sql2=mysql_query("select status from tbl_coordinator where stud_id = ".$_SESSION['id']);
			$res=@mysql_fetch_array($sql2);				 

$status=$res['status'];

 if($status =="Y"){?>
 
                    
                          <p >STUDENT Coordinator</p>
                          
                          <?php }
						  
						  else
						  {?>
						 <p >STUDENT</p>  
						  
						  <?php }?>
                         </div>
                       
                   </div>
                   
                   
              </div>
           </div>
       </div>
       </div>
<!----========================= header_main end ---->
</div>
<div id="middel_top_padding"><!---- middel top padding end ---->
<!----=========================- header_vigation Start ----> 
       
       <nav class="navbar navbar-inverse" style="
   margin-top:-2%
">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="collapse navbar-collapse ">
          <ul class="nav navbar-nav">
           
            <li><a href="student_dashboard.php">Dashboard</a></li>
            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Logs</a>
             <ul class="dropdown-menu">
                     <li><a href="My_Reward.php">Reward Points</a></li>
                     <li><a href="reward_product.php">Used Coupons Logs</a></li>
                     <li><a href="self_motivationlog.php">Self Motivation Logs</a></li>
                     
                     <?php 
					 
				
$status=$res['status'];

 if($status =="Y"){?>
 
 <li><a href="my_assigned_points.php">Assigned Points</a></li>
 <?php }?>
 
					
              </ul> </li>
              
              <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Coupons</a>
              <ul class="dropdown-menu">
					<li class="dropdown-header">Smartcookie Coupons</li>
                    <li><a href="unusedcoupon.php">Unused Coupons</a></li>
            
                    <li><a href="partialusedcoupon.php">Partial used Coupons</a></li>
					<li class="dropdown-header">Vendor Coupons</li>
					<li><a href="coupons.php">Select Coupons</a></li>
					<li><a href="cart.php">My Cart</a></li>
					<li><a href="view_print_coupons.php">Unused Coupons</a></li>
					<li><a href="used_vendor_coupons.php">Used Coupons</a></li>
             </ul> 
			</li>
           <li><a href="#"  class="dropdown-toggle" data-toggle="dropdown">Sponsor</a>
             <ul class="dropdown-menu">
                      <li><a href="sponsor_map.php">Sponsor Map</a></li>
                      <li><a href="vendor_suggested_like.php">Suggest Sponsor</a></li>
                                           
                      </ul></li>
                      
                      
            <li><a href="#"  class="dropdown-toggle" data-toggle="dropdown">Points</a>
             <ul class="dropdown-menu">
                      <li><a href="sharepoint.php">Share Points</a></li>
                        <?php 
			$sql2=mysql_query("select status from tbl_coordinator where stud_id = ".$_SESSION['id']);
			$res=mysql_fetch_array($sql2);				 

$status=$res['status'];

 if($status =="Y"){?>
 
                        
                       
                       
                      <li><a href="assignpointascoordinator.php">Assign point as coordinator </a></li>
                      
                        
                        <?php }?>
                      <li><a href="student_assign_Thanqpoints.php">Blue Points</a></li>
                      <li><a href="purchase_waterpoint.php">Purchase Points</a></li>
                      
                      
                        <li><a href="online_presence.php">Online Presence</a></li>
                      
                      </ul></li>
                      
                      
                      <?php
                      
					  $arr1=mysql_query("select stud_id1 as stud_id,requestdate,points,reason from tbl_request where stud_id2='$id' and flag='N' and entitity_id='105'");
					  $count=mysql_num_rows($arr1);
					  ?>
                       <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Requests</a>
                        <ul class="dropdown-menu">
                     <li><a href="requestlist.php">Requests from students <span class="badge"><?php echo $count;?></span></a></li>
                     <li><a href="requestgreenpoint_teacher.php">Requests to Teacher</a></li>
                     
 
					
              </ul>
                       
                       
                       </li>
                       
                         <li><a href="mysubjectlist.php" >My Subjects</a></li>
                      
            <li><a href="student_profile.php">My Profile</a></li>  
          <li> <a href="top10_stud_20150518.php">Leaderboard</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="images/navi_tabbg.png"></a>
              <ul class="dropdown-menu">
              
                <li><a href="logout.php"><strong>Sign Out </strong></a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
       
<!----========================= header_avigation end ---->

<!----========================= header_filter Start ---->
     
<!----========================= header_filter end ---->


      
<!----========================== middle_container end ---->

<!----========================= footer Start ---->
      
<!----========================= footer end ---->
  </div><!--- middel top padding end ---->
       
    <div class="container" style="padding-top:5px;">   
       <div class="row">

<div class="col-md-3">
<a href="My_Reward.php" style="text-decoration:none;"><div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Rewards &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($row_points['sc_total_point']=="")
   {
   echo "0";
   }
   else
   {
   echo $row_points['sc_total_point'];
   }
   
   ?></h3>
  </div>
  
</div></a>
</div>

<div class="col-md-3">
<a href="bluepointlog.php?id=<?php echo $id;?>" style="text-decoration:none;"><div class="panel panel-primary">
  <div class="panel-heading" style="background-color:#00BFFF;border-color:#00BFFF;">
    <h3 class="panel-title">
   ThanQ Points&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <?php
  
   if($value['balance_bluestud_points']=="")
   {
   echo "0";
   }
   else
   {
 echo $value['balance_bluestud_points'];
   }
  ?></h3>
  </div>
 
</div></a>
</div>


<div class="col-md-3">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" >Water Points&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php
  
   if($value['balance_water_points']=="")
   {
   echo "0";
   }
   else
   {
 echo $value['balance_water_points'];
   }
  ?></h3>
  </div>
 
</div>
</div>


<div class="col-md-3">
<div class="panel panel-warning">
  <div class="panel-heading">
    <h3 class="panel-title" >Friendship Points&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php 
	 if($row_points['yellow_points']=="")
   {
   echo "0";
   }
   else
   {
 echo $row_points['yellow_points'];
   }
	
	?></h3>
  </div>
  
</div>
</div>


</div>



</div>
       
 <!-- Bootstrap core JavaScript ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>     
       
</body>
</html>