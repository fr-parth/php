<?php 
 include('stud_header.php');
  $report="";
 $id=$_SESSION['id'];
     $query = mysql_query("select * from tbl_student where id = '$id'");
$value = mysql_fetch_array($query);
$std_PRN=$value['std_PRN'];
$school_id=$value['school_id'];

		 if(isset($_POST['submit']))
		 	{
				$coupon_id=$_POST['coupon_id'];
				
			 // mysql_query("update tbl_giftof_rewardpoint set parent_id='$parent_id' where coupon_id='$coupon_id'");
			  $row=mysql_query("select * FROM tbl_giftcards where  card_no='$coupon_id' ");
			    
			  $arr=mysql_fetch_array($row);
			  
			  $count=mysql_num_rows($row);
			  if($count>=1)
			  {
			 $points=$arr['amount'];
			  
			 
			 $balance_water_points=$value['balance_water_points']+$points;
			$date1=date('d/m/Y'); 
			$status='Used';
			$query1=mysql_query("update tbl_student set balance_water_points='$balance_water_points' where id='$id' ");
			   mysql_query("update  tbl_giftcards  set  amount='0' ,status='$status' where card_no='$coupon_id' ");
			$test=mysql_query("insert into tbl_waterpoint(coupon_id,points,issue_date,entities_id,stud_id,school_id)values('$coupon_id','$points','$date1','105','$std_PRN','$school_id')");
			 
			  	$report="You  got ".$points. " Water Points";
			  
			  
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

<body style="background-color:#FFFFFF;" >

<div class="container" style="padding-top:50px;">

<div class="row">

<div class="col-md-3"  style="background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;">
<div class="row" style="padding-top:30px"></div>
 <div class="row" align="center" style="font-size:18px;font-weight:bold;color:#000000;">
                                My Balance Points                               </div>
                                
                                
                                <div class="row" style="padding-top:40px"></div>
                                
                                 <div class="row" align="center" style="color:#0066FF;font-weight:bold;font-size:32px;">
                    <?php $rows=mysql_query("select balance_water_points from tbl_student where id='$id'");
					
					       $value=mysql_fetch_array($rows);
						   
					?>
                            <?php echo $value['balance_water_points']; ?>
                    </div>
                    
                            
                                <div class="row" style="padding-top:40px"></div>
                      

</div>







<div class="col-md-1" ></div>

<div class="col-md-8" style="background-color:#FFFFFF;border:1px solid #CCCCCC;box-shadow:0px 1px 3px 1px #C3C3C4;">
<div class="row"  style="padding-top:30px;">     <center>   <h1 style="color:#000000; font-size:36px;">Purchase Water Points</h1></center></div>

   <form name="" method="post">
<div class="row" style="padding-top:30px;">

<div class="col-md-4"  style="font-weight:bold;">    Card No.</div>

<div class="col-md-5"><input type="text" class="form-control" name="cp_id" /></div>
 <div class="col-md-2">
                             <input type="submit" class="btn btn-primary "value="Search" name="Search">
                             </div>
                             </form>
                             
                             <?php
			            if(isset($_POST['Search']))
						{
								$cp_id=$_POST['cp_id'];
							
								$row=mysql_query("SELECT * FROM tbl_giftcards where card_no='$cp_id'");
								
								$values=mysql_fetch_array($row);
								
						
						}
                      ?>
                      
                      <div class="row" style="padding-top:20px;" >
                     
                      <div class="col-md-10 col-md-offset-1" style="padding-top:30px;">
                         <div class="container " style="background-color:#FFFFFF; border:1px solid #CCCCCC;width:100%;padding:10px; " >
                        <form method="post">
                                 <div class="row" >

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
                                        <div class="row" style="padding-top:30px;">
                                      <div class="col-md-6 col-md-offset-3"  align="center" style="color:#FF0000;">
                                     <?php echo $report;?></div>
                                          															                                       
                                      </div>
                                      </div>
                                                              
                                      
                                   </form>      
                                       
                      
                      
                      

</div>






</div>
                       

</div>

</div>

    
  
</body>
</html>
