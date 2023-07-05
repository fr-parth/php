<?php 

$this->load->view('stud_header',$studentinfo);
include 'coupon.inc.php';

include 'lib/phpqrcode/qrlib.php'; 

?>

  <!-- <script type="text/javascript"
    src="http://code.jquery.com/jquery-1.10.1.min.js"></script>-->
<script>
   /* $(document).ready(
            function() {
                setInterval(function() {
                    		
                    $('#result').html("<img src='<?php echo base_url().'/qrcode/qrcode.png'?>'/>");
                });
            });*/
</script>
<!-- <script>
    $(document).ready(
            function() {
                setInterval(function() {
                    var randomnumber = Math.floor(Math.random() * 100);
                    $('#show').text(
                            'I am getting refreshed every 3 seconds..! Random Number ==> '
                                    + randomnumber);
                }, 3000);
            });
</script> --> 


    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Show Coupon</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Show Coupon</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->

                    <div class="row mbl" style="display:none;">
                        <div class="col-lg-8">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                       

                                         <div id="area-chart-spline" style="width: 100%; height:300px"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
             <div class="page-content">
        <div id="form-layouts" class="row">
        <div class="col-lg-12">
      
         <div class="row">
         <div class="col-md-3"></div>
         <div class="col-md-6" style="border:dashed; background-color:#FFF;">
         
         <div clas="row" align="center">
         <img src="<?php echo base_url().'\images\220_76.png'?>">
         
         </div>
         <div class="row" style="margin-top:5%;">
         <div class="col-md-3"></div>
         <div class="col-md-3">	Issued To: </div>
          <div class="col-md-4"><?php echo $couponinfo[0]->std_complete_name;?></div>
		</div>
         
         
          <div class="row" style="margin-top:5%;">
         <div class="col-md-3"></div>
         <div class="col-md-3">	Issue Date: </div>
          <div class="col-md-4"><?php echo $couponinfo[0]->cp_gen_date;?></div>
    </div>
    
    
      <div class="row" style="margin-top:5%;">
         <div class="col-md-3"></div>
         <div class="col-md-3">	Coupon Points: </div>
          <div class="col-md-4"><?php echo $couponinfo[0]->amount;?> Points</div>
    </div>
    
     <div class="row" style="margin-top:5%;">
         <div class="col-md-3"></div>
         <div class="col-md-3">	Coupon Code: </div>
          <div class="col-md-4"><?php echo $couponinfo[0]->cp_code;?> </div>
    </div>
    
    
     <div class="row" style="margin-top:5%;">
         <div class="col-md-3"></div>
         <div class="col-md-3"><?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?> Name: </div>
          <div class="col-md-6"><?php echo $couponinfo[0]->std_school_name;?> </div>
    </div>
         
         
                <div class="row" align="center" style="margin-top:5%;" id="result">
          
				<?php 
				$code=$couponinfo[0]->cp_code;
				$qrfile='qrcode.png';

				$dir='tsmartcookie/qrcode/';

				QRcode::png($code, $dir.$qrfile); 

				echo '<img src='.$dir.$qrfile.' />';
				
				?>
		
                
                </div>
                
                
                <div class="row" style="margin-top:2%;">
                
                </div>
                
                </div>
                </div>
                       </div>
                      </div>
                      </div>
                  
            <!--END CONTENT--><!--BEGIN FOOTER-->
          <?php 


$this->load->view('footer');

?>
            </div>
           
           

</body>
</html>