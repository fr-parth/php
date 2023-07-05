<?php 
//print_r($schoolinfo);

$this->load->view('scadmin_header',$schoolinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard | Dashboard</title>
    
  
</head>
<body>

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Add Teacher</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active"><a href="#">Masters</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Teacher</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          <div align="center"  style="margin-top:15%;color:#000;">
				<h4>Successfully Registered!</h4><br>
                <div align="center"><a href="addteacher" style="text-decoration:none;"><button type="submit" class="btn btn-green">Add Teacher</button></a></div>
                </div>
            <!--END CONTENT--><!--BEGIN FOOTER-->
          <div id="footer">
                <div class="copyright">2014 © &mu;Admin - Responsive Multi-Style Admin Template</div>
            </div>
            </div>
            
         
</body>
</html>