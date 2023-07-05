<?php 
 include_once('stud_header.php');
 include 'lib/phpqrcode/qrlib.php'; 
 //get table record id
 $id= $_GET['id'];
 //retrive coupon id using table id
$arra=mysql_query("select *  from  tbl_coupons where id =$id");
			$row=mysql_fetch_array($arra); 
		
			$cp_code=$row['cp_code'];
			$cp_point=$row['amount'];
			$cp_stud_id=$row['cp_stud_id'];
			
 //retrive student info using student id
 $arr=mysql_query("select *  from  tbl_student where std_PRN =$cp_stud_id");
			$rows=mysql_fetch_array($arr);
			
			$std_name=$rows['std_name'];
			$std_complete_name=$rows['std_complete_name'];
			$std_lastname=$rows['std_lastname'];
			$std_school_name=$rows['std_school_name'];
			$std_Father_name=$rows['std_Father_name'];
			
			//retrive use of coupon
$aray=mysql_query("select *  from  tbl_accept_coupon where coupon_id =$cp_code and stud_id=$cp_stud_id");
			$record=mysql_fetch_array($aray); 
		
			$product_name=$record['product_name'];
	     
	   ?>

<html>
<head>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>
<script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body><center>" + 
              divElements + "</center></body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>
    <style>
	.barcode-align
	{
	text-align:center !important;
	}
	</style>

</head>
<body style="background-color:#FFFFFF;">
<div class="container" style="padding:10px;">
<div class="row">

<div class="col-md-1">
 <a href="student_dashboard.php" style="text-decoration:none;">
                <input type="button" value="Back"  style="width: 70px;">
            </a>
 </div>
 <div class="col-md-1">
       	    <INPUT TYPE="button" value="Print" onClick="javascript:printDiv('printablediv')" style="width:70px;">
    </div>     
   <div class="col-md-2">    
           <?php  if($row['status']=='no' || $row['status']=='p'){
      $sql1= "SELECT ac.id,ac.sponsored_id ,sp.sp_name,ac.product_name FROM tbl_accept_coupon ac join tbl_sponsorer sp on sp.id=ac.sponsored_id where coupon_id=$cp_code ORDER BY id DESC LIMIT 1";
       						$arrs1=	mysql_query($sql1);
                            $record1=mysql_fetch_array($arrs1); 
                           ?>
                                     <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="I have used my Smart Cookie Coupon to get  <?php  echo $record1['product_name'];?>   at <?php  echo $record1['sp_name'];?> "  data-hashtags="smartcookieprogram" >Tweet</a>
             <?php }?>
              <?php  if($row['status']=='yes'){
   
       						$arrs7=	mysql_query("SELECT id,amount FROM tbl_coupons where cp_code=$cp_code ORDER BY id DESC LIMIT 1");
                            $record7=mysql_fetch_array($arrs7); 
                           ?>
                                     <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="I have converted my Smart Cookie points into a rewards Coupon worth <?php $record7['amount'];?> points. " data-size="" data-hashtags="smartcookieprogram" style="margin-top:5px;">Tweet</a>
             <?php }?>
</div>
</div>
</div>
<div class="container" id="printablediv" >
<div class="row" style="padding:20px;" align="center">

 
<div class="col-md-9 col-md-offset-2"  align="center" style="border-width:2px;border-style:dashed;padding:10px;">
<div class="row">
<div class="col-md-3"></div>
 <div class="col-md-5">
                            <img src="images/logo.png" width="100%" height="40" class="img-responsive" style="padding-left:4px; " alt="Responsive image"/>
                            </div>

           
  <?php /*?>  <div class="panel" style="border:1px solid #999999;padding:10px;">
    <div class="row">
                        <div class="col-md-6">
                        <h1 style="font-size:18px;font-family:Verdana, Arial, Helvetica, sans-serif;"  >
                                    
                                        Smartcookie
                                        </h1>
                                        </div>
                            
                            
                            <div class="col-md-5">
                             <div class="row" style="padding-top:5px;font-weight:bold; ">
                               
                            <?php echo ucwords($std_complete_name);?>
                           
                            </div>
                            <div class="row" style="font-size:15px; ">
                           
                 				<?php echo $std_school_name;?>
                   	
                             </div>
                             </div>
                             </div>
                    </div>
                    </div><?php */?>
                    
                    </div>
                    
<div class="row" style="padding-top:7px;">
    
        		
                <div class="col-md-3 col-md-offset-2" style="font-size:15px;font-weight: bold;">
                Coupon code:</div>
                 <div class="col-md-2" >
                <?php echo $cp_code;?>
                         </div> 
                         </div>
                         
                         
                        <div class="row" style="padding-top:15px;">
    
        		
                <div class="col-md-3 col-md-offset-2" style="font-size:15px;font-weight: bold;">
               Issue To:</div>
                 <div class="col-md-1" >
              <?php echo ucwords($std_complete_name);?>
                         </div> </div>
                          <div class="row" style="padding-top:15px;">
                          <div class="col-md-3 col-md-offset-2" style="font-size:15px;font-weight: bold;">
               School Name:</div>
                 <div class="col-md-5" >
              <?php echo ucwords($std_school_name);?>
                         </div> 
                         </div>
                         
                
                  <div class="row" style="padding-top:25px;">
                          <div class="col-md-4 col-md-offset-4" style="font-size:42px;font-weight:bold;" ><?php echo $cp_point;?>
                          </div>
                          </div>
                          <div class="row">
                          <div class="col-md-4 col-md-offset-4" style="font-size:18px;font-style:italic;padding-top:10px;">
                             Points
               </div>
               </div>
                            <div class="container" align="center">
              
                  
               <div class="row"><div class="col-md-2"></div>
               <div class="col-md-4">
                <!-- <iframe src="html/BCGcode39.php?id=<?php echo  $cp_code ?>"  frameBorder="0" style="width:100%;">
                  <p>Your browser does not support iframes.</p>
                 
                  </iframe>-->

<?php    
                $qrfile=$cp_code.'.png';
                    $dir='images/coupon_qr/';
                QRcode::png($cp_code, $dir.$qrfile); 
                echo '<img src='.$dir.$qrfile.' />'; ?>
				  </div> 
                </div>
                 
               
              
                  
                       </div>
                
                 
           </div>
                      
                 
          
                                                  
              
                    
                   
                      
                   
                 
                </div>
                
           
       

 					
          
   
 
                     
                
                                    
</div>
</div>
</div>
</body>

</html>
  






