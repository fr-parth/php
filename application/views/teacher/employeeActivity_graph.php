<?php 
//This view is created by Sayali Balkawade for SMC-4277 on 25/12/2019
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Employee Activity Summary Report Graph</title>
	  <link href="<?= base_url();?>core/css/charts-c3js/c3.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
	
      .c3-axis-x,.c3-axis-y 
      {
        font-size: 10px; 
      }
    </style>
</head>
<body>  
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Employee Activity Graph</div>
                </div>
				
				
                <ol class="breadcrumb page-breadcrumb pull-right">
                   
                   <!-- <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">Employee Activity Graph</li>
                </ol>
				
				
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
            <?php $list ="["; for($k=0; $k<count($act_list);$k++){
			          $list.= "'".str_replace('<br>',' ',$act_list[$k])."',";
			       } $list.="]";?>
                    <div class="col-lg-offset-3 col-lg-9">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                        	<div class="row">
                        		<button class="btn btn-info" onclick="location.replace('<?php echo base_url();?>teachers/empActivitySummary_report')">Back </button>
							</div>
		                   	<div class="row">
								<div class="col-md-12 text-center">
									<div class="col-md-6">
										From Date : <?= $this->uri->segment(3, 0);?>
									</div>
									<div class="col-md-6">
										To Date : <?= $this->uri->segment(4, 0);?>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top:5%;">
	                            <div id="chart" style="height: 600px;"></div>
	                        </div>
                        </div>
                                    
                    </div>
                </div>
              </div>
         </div>
           <!--END CONTENT--><!--BEGIN FOOTER-->
            
           
        <!--END PAGE WRAPPER-->
           
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
                            </div>
         
   <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="<?= base_url();?>core/js/d3/d3.min.js"></script>
<script src="<?= base_url();?>core/js/charts-c3js/c3.min.js"></script>
<script src="<?= base_url();?>core/js/charts-c3js/c3js-init.js"></script>


   <script type="text/javascript">
   		$(function(){
   			$('.datepick').datepicker({
   				dateFormat: 'yy-mm-dd',
   				changeMonth: true,
   				changeYear: true,
   				maxDate:0
   			});
   		});
  var school = <?= $list; ?>;
  var chart = c3.generate({
     padding: {
      bottom: 40,
    },
    data: {
        
        rows: [
          ["Employee Name"],
          <?php for($j=0; $j<count($act_point);$j++){ ?>
          [<?= $act_point[$j];?>],
      <?php } ?>
        ],
        type: 'bar'
     },
    axis: {
  x: {

        type: 'category',
        categories: school
    },
  y: {
    label: {
      text: "Points",
      position: 'outer-middle'
    }
  }
},
    bar: {
        width: {
            ratio: 0.5 // this makes bar width 50% of length between ticks
        }
    }
});
   </script>     
</body>
</html>