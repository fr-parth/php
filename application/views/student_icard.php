<?php 

$this->load->view('stud_header',$studentinfo);
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
?>


<!DOCTYPE html>
<html lang="en">
<head><title>ID Card</title>
    <script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>Assets/vendors/bootstrap/css/bootstrap.css">
<style>

.copuon_main{margin: 0px;padding: 10px 30px 200px 30px;}
.coupon-idsec {margin:0px; padding:0px;}
.bg-imgid {background-image:url('http://tsmartcookies.bpsi.us/images/cad_bgimg_03.png'); height:387px; 
background-repeat: no-repeat;

}
.cuoun-cont .logo-cp{margin:16px 0 12px 0px; background-color:#fff;  text-align:center; padding:0px; width:93%; height:68px;}
.coupon-infid{margin:0px; padding:8px 8px;}
.coupon-infid h5{margin:0px 0px 7px 0px; padding:0px;]}
.coup-clr{margin:0px; padding:0px; color:#ccc; font-size:18px;}
.number-cpn {color:#fff; font-size:18px; font-weight:bolder;}
.number-cpn2 {color:#fff;margin-top:8px; font-size:14px;}
.pont-numsct{margin:0px 0px 0px 8px; padding:8px; background-color:#fff; width:120px;  height:120px; overflow:hidden;}
.pont-numsct img{width:100%; height:100%;}
.pnt-clr{color:#fff; font-weight:bold;}
.colge_nm{background-color:#1c3b81;  margin:0 10px 0 9px; width:90%; padding:8px 12px;  }
.img-brc { margin:0px ; padding:0px;}
.clg_nm{margin:0px ;padding:0px; font-size:20px; color:#fff; text-align:center;}


</style>
   
</head>
<body>

    <!--END THEME SETTING-->
    <div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">ID Card</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">ID Card</li>
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
		
		<div class="row" align="right">
		<input type="button" name="Print" value="Print" onclick="printDiv('printableArea')"/>
		
		</div>
		
         <div class="copuon_main clearfix" id="printableArea">
		 
               <div class="row">
                  <div class="col-md-12">
                     <div class="coupon-idsec clearfix">
					 
					 
                        <div class="col-md-7 col-md-offset-2">
						
								  
						
                           <div class="bg-imgid clearfix">
						    
                              <div class="cuoun-cont clearfix">
							  
							
                                 <div class="logo-cp clearfix">
								
								
								<?php if($isSmartCookie) { ?>
								
									  <img src="<?php echo base_url().'\images\logo-cp.png'?>">
									 <?php }else{ ?>
								
									  <img src="<?php echo base_url().'\images\logo-pb.jpg'?>">
                                   <?php } ?>
								   
								   <img src="<?php echo base_url().'\images\blank.png'?>">
                                 </div>
                                 <div class="coupon-infid clearfix">
								 
								   <div class="col-md-4 pad_no">
                                       <div class="pont-numsct clearfix">
                                       
                                       <?php if($studentinfo[0]->std_img_path==""){?>
                                                    <img src="<?php echo base_url()?>images/avtar.png"  alt="" class=""/>
                                                    
<?php }
else
{?>
	<img src="<?php echo base_url().'core/'?><?php echo $studentinfo[0]->std_img_path?>"  alt="" class=""/>
<?php }?>
									   
									   
									   
									   </div>
                                    </div>
                                    <div class="col-md-8" >
                                       <h5 ><span class="coup-clr"><font color="black"><b>Name:</b></font></span> <span class="number-cpn " ><?php if($studentinfo[0]->std_complete_name!="")
											{?>
											
										<font color="black"><?php echo ucwords(strtolower($studentinfo[0]->std_complete_name));?></font>
											<?php }
											else
											{?>
											<font color="black">	
											<?php echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname	));
												?> </font>
										<?php } ?></span></h5>
                                     
                                       <h5><span class="coup-clr"><font color="black"><b><?php echo ($this->session->userdata('usertype')=='employee')?'EmployeeID: ':'PRN: '; ?></b></font></span><span class="number-cpn2 "><font color="black"><b><?php echo $studentinfo[0]->std_PRN;
									   ?></font></b></span></h5>
									  <h5><span class="coup-clr"><font color="black"><b>
									  <?php echo ($this->session->userdata('usertype')=='employee')?'Organization':'School'; ?>
									  :</b></font></span> <span class="number-cpn "><font color="black"><?php  echo $studentinfo[0]->std_school_name;?></font></span></h5>
                                       </h5>
                                    </div>
                                  
                                 
								 
								 <!-- <div class="colge_nm clearfix">
								 <div class="img-brc clearfix"> -->
								 	<div id="externalbox" name="qrcode_text">
								 		<div class="row" align="center" style="margin-top:5%;" id="result">
                            <?php
                            $output1=$studentinfo[0]->entity_type_id;
                            $output=$studentinfo[0]->id. ' ' .$output1;
                            echo "<p style='text-align:center;'> <img src='".base_url()."/application/views/qr_img0.50j/php/qr_img.php?d=$output' style=\"width:300px; margin:0 auto; \" > </p>";
                            ?>
                        </div>
								 		<!-- <img src="<?php //echo base_url().'\images\bard_03.png'?>" alt="" title="">  -->
									<div id="inputdata" style="color:black;text-align: center;margin-left: 200px;"><?php echo $studentinfo[0]->id.'  '.$studentinfo[0]->entity_type_id;
									   ?></div>
									</div>
 </div>
									
								
								<!--  </div>
								
								 </div> -->
								  <h3 class="clg_nm" style="text-align: center;margin-left: 200px;"> <font color="black">
								  <?php if($isSmartCookie) { ?>
								  www.smartcookie.in
								  <?php }else{ ?>
								   www.protsahanbharati.com
								  <?php } ?>
								  </font></h3>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		 
		 <script type="text/javascript">
/* <![CDATA[ */
  function get_object(id) {
   var object = null;
   if (document.layers) {
    object = document.layers[id];
   } else if (document.all) {
    object = document.all[id];
   } else if (document.getElementById) {
    object = document.getElementById(id);
   }
   return object;
  }
get_object("inputdata").innerHTML=DrawCode39Barcode(get_object("inputdata").innerHTML,1);
/* ]]> */


</script>
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
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