<?php 
 include_once('scadmin_header.php');
 $report="";
 $scadmin_id=$_SESSION['id'];

		 if(isset($_POST['submit']))
		 	{
				$coupon_id=$_POST['coupon_id'];
				
			 // mysql_query("update tbl_giftof_rewardpoint set parent_id='$parent_id' where coupon_id='$coupon_id'");
			  $row=mysql_query("select * FROM tbl_giftcards where  card_no='$coupon_id' ");
			  $arr=mysql_fetch_array($row);
			  $point=$arr['amount'];
			   $rows=mysql_query("select * from tbl_school_admin where id='$scadmin_id'");
			  $arrs=mysql_fetch_array($rows);
			  $balance_point=$arrs['school_balance_point'];
			  $balance_point=$balance_point+$point;
			$status='Used';
			  mysql_query("update tbl_school_admin set  school_balance_point='$balance_point' where id='$scadmin_id'");
			 
			   mysql_query("update  tbl_giftcards  set  amount='0',status='$status' where card_no='$coupon_id' ");
			  if(mysql_affected_rows()>0)
			  {
			  	$report="You have got ".$point. " Points";
			  }
			  else
			  {
			  	$report="coupon is invalid";
			  }
			}
		 
		 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
#center {
   width: 200px;
   height: 20px;
   position: absolute;
      background: rgba(0,0,0,1);
  border: 2px solid rgba(255,255,255,1);
  border-radius: 5px;
  box-shadow: 0px 0px 10px 5px rgba(255,255,255,0.2);
}

#main {
  
   height: 16px;
  background: #92C81A;
  float: left;
  animation: stretch 5s infinite linear;
}
</style>
</head>

<body align="center" >
	<div class="container" style="padding:10px;padding-top:60px;">
  
    <div class="row">
            <div class="col-md-4">
            <div class="container" style="padding:10px;background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;" align="center">
                <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      <div class="row" style="font-size:18px;padding-left:10px;font-weight:bold;color:#000000;">
                                My Balance Points                               </div>
                      </div>
                    </div>
                 
                    
                  
                    
                    <div class="row" style="padding:10px;color:#339933;font-weight:bold;font-size:32px;">
                    <?php $rows=mysql_query("select * from tbl_school_admin where id='$scadmin_id'");
					
					       $value=mysql_fetch_array($rows);
						   
					?>
                            <?php echo $value['school_balance_point']; ?>
                    </div>
                     <div class="row" style="font-weight:bold;font-size:14px;">
                    
                    </div>
              </div>
              <div class="container" style="padding:10px;" align="center">
                <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                    
                   <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                     <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                     <div class="row"  align="center">
                    <div class="col-md-8 col-md-offset-2">
                      </div>
                    </div>
                    
                  
              </div>
              <?php /*?><div class="container" style="padding:10px;background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;">
               
            
                               <div class="row" style="font-size:18px;padding-left:10px;font-weight:bold;color:#000000;">
                                My Coupons
                               </div>
                                 <div class="row" style="font-size:12px;font-weight:bold;background-color:#CCCCCC;"> 
                                    <div class="col-md-4">
                                       Coupon ID
                                    </div>
                                    <div class="col-md-4">
                                       Coupon Points
                                    </div>
                                    <div class="col-md-4" > 
                                        Issue Date
                                    </div>
                                </div>
                                <?php
                                                     
                              $row3=mysql_query("select coupon_id,point,issue_date  from tbl_giftof_rewardpoint  where user_id='$scadmin_id' and entity='102' and point!=0 ORDER BY id DESC limit 10 "); 
                             while( $result3=mysql_fetch_array($row3))
							 {
                                                         ?>
                                                         
                                <div class="row" style="font-size:12px;padding:5px;"> 
                                <div class="col-md-4">
                                    <?php echo $result3['coupon_id'];?>
                                </div>
                                <div class="col-md-4" > 
                                    <?php echo $result3['point'];?>
                                </div>
                                 <div class="col-md-4" > 
                                    <?php echo $result3['issue_date'];?>
                                </div>
                                </div>
                                <?php }?>
                  
                  
                    </div>
                  <?php */?>
              
         
              
              
              
            </div>
    <div class="col-md-8">
           <div class="container" style="padding:10px;background-color:#FFFFFF;box-shadow:0px 1px 3px 1px #C3C3C4;" align="center ">
           			 <div class="row" style="font-weight:bold;color:#000000;" align="center"> 
           			   <h1> Purchase Points</h1>
           			 </div>
                       <div class="row" style="padding:5px;">
                       </div>
                       <div class="row" style="padding-top:20px;"> 
                           <form name="" method="post">
                           <div class="col-md-4" style="font-weight:bold;">
                             Card No.
                             </div>
                             <div class="col-md-4">
                            <input type="text" class="form-control" name="cp_id" />
                             </div>
                             <div class="col-md-4">
                             <input type="submit" class="btn btn-primary "value="Search" name="Search" style="width:100px;font-weight:bold;font-size:14px;"/>
                             </div>
                             </form>
                         </div>
                         <div class="row" style="padding:10px;"></div>
            <?php
			            if(isset($_POST['Search']))
						{
								$cp_id=$_POST['cp_id'];
							
								$row=mysql_query("SELECT * FROM tbl_giftcards where card_no='$cp_id'");
								$values=mysql_fetch_array($row);
								
						
						}
                      ?>
                      <div class="row" style="padding:10px;" >
                     
                      <div class="col-md-10 col-md-offset-1">
                         <div class="container " style="background-color:#FFFFFF; border:1px solid #CCCCCC;width:100%;padding:10px; " >
                        <form method="post">
                                 <div class="row">
                                            <div class="col-md-4 col-md-offset-1" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 14px;font-weight:bold;" align="left">Card ID :</div>
                                            <div class="col-md-4" align="left"><?php    if(isset($_POST['Search']))
						{echo  $cp_id; }?> <input type="hidden" name="coupon_id" value="<?php    if(isset($_POST['Search']))
						{echo  $cp_id; }?>" ></div>
                                         </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-1" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 12px;font-weight:bold;" align="left">Card Points :</div>
                                            <div class="col-md-4"  align="left"><?php  if(isset($_POST['Search']))
						{ echo  $values['amount'];   } ?></div>																	                                       
                                        </div>
                                      <div class="row">
                                      <div class="col-md-4 col-md-offset-1" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 12px;font-weight:bold;"  align="left">Issue Date :</div>
                                            <div class="col-md-4" align="left"><?php  if(isset($_POST['Search']))
						{ echo  $values['issue_date'];  } ?></div>																	                                       
                                      </div>
                                  
                                         <div class="row">
                                      <div class="col-md-4 col-md-offset-3"  align="center">
                                      <input type="submit" name="submit" value="Purchase" class="btn btn-primary" style="width:100px;font-weight:bold;font-size:14px;"/></div>
                                          															                                       
                                      </div>
                                      </div>
                                        <div class="row">
                                      <div class="col-md-6 col-md-offset-3"  align="center" style="color:#FF0000;">
                                     <?php echo $report;?></div>
                                          															                                       
                                      </div>
                                      </div>
                                                              
                                      
                                   </form>      
                                       
                                      
                                         
                                  </div>      
</div>
</div>
                        </div>
                        
           
                
                 
         </div>
         </div>
       </div><!--end of row-->
           
           
           </div><!--inner container-->
</div><!--outer container-->
    
  
</body>
</html>
