<?php

include('cookieadminheader.php');
$id=$_SESSION['id'];
$rows=mysql_query("select std_city,std_country,latitude,longitude from tbl_student where id='$id'");
$results=mysql_fetch_array($rows);
$city=$results['std_city'];
$country=$results['std_country'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">
</head>

<body>
     <!-- body-->
<div align="center" >
<div id="RewardsOverview-content" >
	<div id="rewards_overview_content" >
        <div class="rewards-head">&nbsp;</div>
        <div  id="rewards-content">
            <!--left side-->
           <!--/* <div class="csc-x-small-column">
                <div class="leftcol csc-subsection" align="left" style="padding:2px;">*/-->
                    <!--<div class="my-account-header" style="background: -moz-linear-gradient(center top , #FFF 20%, #E7E7E7 100%) repeat scroll 0px 0px transparent;padding:4px;">-->
                       <!-- <span>Sponsors</span>
                    </div>
                    <span><b>Local Sponsors</b></span>
                    <ul class="my-account-nav">
							<?php /*?><?php $rows=mysql_query("select * from tbl_sponsorer where sp_city='$city' and sp_country='$country' ");
							   while($result=mysql_fetch_array($rows))
							   {?><a style="text-decoration:none;" href="sponsormap-new.php?id=<?php echo $result['sp_name'].",". $result['sp_city'].",". $result['sp_country']; ?>"><li ><?php
							   echo $result['sp_name'];
							   echo "-";
							   echo $result['sp_city'];
							   echo ",";
							   echo $result['sp_country'];?></li></a><?php
							   }
					     ?>          
                       <?php */?>
                                      </ul>
                    -->
           
               
                 
                  <!--  <span><b>Other Sponsors</b></span>
                    <ul class="my-account-nav">
							
                       <?php /*?>  <?php $rows=mysql_query("select * from tbl_sponsorer where sp_city!='$city' or sp_country!='$country'  ");
							   while($result=mysql_fetch_array($rows))
							   {?><a style="text-decoration:none;" href="sponsormap-new.php?id=<?php echo $result['sp_name'].",". $result['sp_city'].",". $result['sp_country']; ?>"><li ><?php
							   echo $result['sp_name'];
							    echo "-";
							   echo $result['sp_city'];
							   echo ",";
							   echo $result['sp_country'];
							   ?></li></a><?php
							   }
					     ?>  <?php */?>  
                         
                                      </ul>-->
                    
               <!-- </div>-->
          <!--  </div>-->
           <!-- reight side-->
             <div id="rewards-main-content" >
              <?php $id=$_GET['id'];
			         $rows=mysql_query("select * from tbl_sponsorer where id=$id");
					 $result=mysql_fetch_array($rows);
				?>
                <div id="rewardsSection-points" class="col-md-6 col-md-offset-2" style="width: 100%; background: none repeat scroll 0% 0% transparent;  overflow: hidden;  height:400px;" align="center">
                  <div id="rewardsSection-head" class="row"  style="color:#FFFFFF;" align="left"><div class="col-md-6"><h1><?php echo $result['sp_name'];?></h1></div></div>
                       <div class="row" style="border:1 px solid #333333;padding:5px;">
                             <div class="col-md-2 col-md-offset-1"><?php if($result['sp_img_path']!=''){?><img src=<?php echo $result['sp_img_path'];?> style="width:100px;height:60px;"  /><?php }else{?><img src="image_sponsor/default-logo.png" style="width:100px;height:100px;" /> <?php }?></div>
                      <div class="col-md-6" > 
                             <div class="row" style="font-size:14px;font-weight:bold;"><?php echo $result['sp_address'];?></div>
                            <div class="row" style="font-size:12px;font-weight:bold;"><?php echo $result['sp_city'];?>&nbsp;&nbsp;<?php echo $result['sp_country'];?></div>
							<div class="row" style="font-size:12px;font-weight:bold;"> <?php echo $result['sp_name'];?></div>
                      </div>
                       </div>
                    <div style="border:1 px solid #CCCCCC;padding:10px;" class="row">
                       <div class="col-md-6 col-md-offset-2" style="background:#009999;font-size:25px;color:#FFFFFF;">
                                         
                  	 Contact Us
               
                   </div>
                         </div>
                         <div class="row">      
                         <div class="col-md-3" style="font-size:16px;font-weight:bold;" align="right">
                         </div>
                                     <div class="col-md-2" style="font-size:16px;font-weight:bold;" align="left">
									 <?php if($result['sp_email']!="") {?>Email <?php } ?>
                                     </div>
                                     <div class="col-md-2" style="font-size:16px;" align="left">
									      <?php echo $result['sp_email'];?>
                                      </div>
                         </div>
                         <div class="row"> 
                                     <div class="col-md-3" style="font-size:16px;font-weight:bold;" align="leftt">
                                     </div>   
                                     <div class="col-md-2" style="font-size:16px;font-weight:bold;" align="left">
									         <?php if($result['sp_phone']!="") {?>Phone <?php } ?>
                                     </div>
                                     <div class="col-md-2" style="font-size:16px;" align="left">
									          <?php echo $result['sp_phone'];?>
                                      </div>
                                      </div>
                          <div class="row">   
                                     <div class="col-md-3" style="font-size:16px;font-weight:bold;" align="left">
                                     </div> 
                                     <div class="col-md-2" style="font-size:16px;font-weight:bold;" align="left">
									                <?php if($result['sp_website']!="") {?>Website<?php }?>
                                     </div>
                                     <div class="col-md-2" style="font-size:16px;" align="left">
									                 <?php echo $result['sp_website'];?>
                                     </div>
                         </div>
       
         
         				<div class="row" style="border:1 px solid #CCCCCC;padding:10px;">
                            <div class="col-md-6 col-md-offset-2" style="background:#009999;padding-top:5px;font-size:25px;color:#FFFFFF;">
                                           
                                 Our Product
                             </div>
                         </div>
                        <?php $row1=mysql_query("select * from tbl_sponsored where Sponser_type='Product' and sponsor_id='$id'");?>
						<div  class="row" style="color:#999999;font-size:22px;padding:5px;">
                        <div  class="col-md-2" style="color:#999999;font-size:22px;padding:5px;">
                        </div>
                        <div  class="col-md-7" style="color:#999999;font-size:22px;padding:5px;">
						 <?php 
						 $count=mysql_num_rows($row1);
						 $i=1;
						  while($results=mysql_fetch_array($row1)){?>      
                                   
                                     <?php echo $results['Sponser_product'];
                                    if($i<$count) 
                                    {
                                    echo "|";
                                     }
									 ?>
                               
                                     
                                     <?php $i++;}?>
                                     </div>
                          </div>
         </div>
         </div>
         </div>
</body>
</html>
