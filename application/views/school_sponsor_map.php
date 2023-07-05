<?php 
//print_r($schoolinfo);

$this->load->view('scadmin_header',$schoolinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard | Dashboard</title>
    
<?php echo $map['js']; ?>
<body>

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Sponsor Map</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Masters</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Sponsor Map</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
             <div class="page-content">
                <div id="form-layouts" class="row">
                    <div class="col-lg-12">
                    <div class="panel">
                  
<div class="panel-body">
<?php echo $map['html']; ?>
</div></div>
                   </div>
                    </div>
                    </div>
                   
                   
                  <?php 


$this->load->view('footer');

?>
 
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            </div>
            
         
</body>
</html>