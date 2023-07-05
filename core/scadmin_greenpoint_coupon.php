<?php 
include_once("scadmin_header.php");
 $report="";
 $report1="";
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
	    $query = mysql_query("select * from tbl_school_admin where id ='$id'");

    $value = mysql_fetch_array($query);

    $school_id = $value['school_id'];
 if(!isset($id))
	{
		header('location:login.php');
	}

		 if(isset($_POST['submit']))
		 	{
			
			$coupon_id=$_POST['coupon_id'];
			
			$data=array(
			'card_no'=>$coupon_id,
			'user_id'=>$id,
			'school_id'=>$school_id,
			'entity_id'=>'102',
			'point_color'=>'GREEN'
			);
			//WEB_SERVICE_PATH is define in core/securityfunctions.php
			$url=WEB_SERVICE_PATH."purchase_water_point_student_teacher_parent_school_admin.php";
		
			$redirect=$GLOBALS['URLNAME'].'/core/scadmin_greenpoint_coupon.php';
			$result=get_curl_result($url,$data);
			
			$responseStatus = $result["responseStatus"];
			$points = $result["posts"][0]['Points'];
		//	print_r($responseStatus);exit;
			if($responseStatus==200)
				{														
					echo "<script>alert('$points Green points purchased successfully');location.assign('$redirect');</script>";	
				}
				else						
				{														
					$msg = $result["responseMessage"];		
					echo "<script>alert('$msg');</script>";						
				}
			
			/*if($coupon_id!="")
			{
			
			  mysql_query("update tbl_giftof_rewardpoint set parent_id='$parent_id' where coupon_id='$coupon_id'");
			  $row=mysql_query("select * FROM tbl_giftcards where card_no='$coupon_id' ");
			  if(mysql_num_rows($row)>0)
			  {
			  $arr=mysql_fetch_array($row);
			  $point=$arr['amount'];
			  	$rows=mysql_query("select * from tbl_school_admin where id='$id'");
			  $arrs=mysql_fetch_array($rows);
			  $balance_point=$arrs['school_balance_point'];
			  $balance_point=$balance_point+$point;
			$status='Used';

			
			// Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
						//$date1=date('d/m/Y');
							$date1 = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
							//end SMC-3495

			   mysql_query("update tbl_school_admin set  school_balance_point='$balance_point' where id='$id' ");
			   mysql_query("update  tbl_giftcards  set  amount='0',status='$status' where card_no='$coupon_id' ");
			   
			   mysql_query("insert into tbl_giftof_rewardpoint(coupon_id,point,issue_date,entity,user_id)values('$coupon_id','$point','$date1','102','$id')");
			  
			  	$report1="You  got ".$point. " Green Points";
				
			  }
			  else
			  {
			  	$report="Coupon is Invalid";
			  }
			  
			 }
			 else
			 {
			 
			 $report="Please Enter Card No.";
			 }
			  
			  */
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
<!-- below remove align="center" in body tag by Chaitali for SMC-4492 -->
<body>
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
                 
                    
                  
                    
                    <div class="row" style="padding:10px;color:#308C00;font-weight:bold;font-size:32px;">
                    <?php $rows=mysql_query("select * from tbl_school_admin  where id='$id'");
					
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
                       
              
            </div>
    <div class="col-md-8">
           <div class="container" style="padding:10px;background-color:#FFFFFF;box-shadow:0px 1px 3px 1px #C3C3C4;" align="center ">
           			 <div class="row" style="font-weight:bold;color:#000000;" align="center"> 
           			   <h1> Purchase Green Points</h1>
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
                             <input type="submit" class="btn btn-primary" value="Search" name="Search" style="width:100px;font-weight:bold;font-size:14px;"/>
                             </div>
                             </form>
                         </div>
                         <div class="row" style="padding:10px;"></div>
            <?php
			//else if and else condition added and change in query done by Pranali
			            if(isset($_POST['Search']) && ($_POST['cp_id']!=""))
						{
								$cp_id=$_POST['cp_id'];
																				
								$row=mysql_query("SELECT * FROM tbl_giftcards where card_no='$cp_id' AND amount!='0' AND status!='Used'");
								$values=mysql_fetch_array($row);
								$test=mysql_num_rows($row);
								
								if($test==0)
								
								{
								
								$report="Invalid Coupon";
								}
						
						}else if(isset($_POST['Search']) && ($_POST['cp_id']=="")){
							
                            $report="Enter Coupon ID";
                        }
						else{
							$report="";
						}
						
						
                      ?>
                      <div class="row" style="padding:10px;" >
                     
                      <div class="col-md-10 col-md-offset-1">
                         <div class="container " style="background-color:#FFFFFF; border:1px solid #CCCCCC;width:100%;padding:10px; " >
                        <form method="post">
                                 <div class="row">
                                            <div class="col-md-4 col-md-offset-1" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 14px;font-weight:bold;" align="left">Card No. :</div>
                                            <div class="col-md-4" align="left"><?php    if(isset($_POST['Search']) )
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
                                      <div class="col-md-6 col-md-offset-3"  align="center" style="color:red;">
                                     <?php echo $report;?>
									 </div>
									 
									 <!-- Following div added  by Pranali-->
									 <div class="col-md-6 col-md-offset-3"  align="center" style="color:green;">
                                     <?php echo $report1;?>
									 </div>
                                          															                                       
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
