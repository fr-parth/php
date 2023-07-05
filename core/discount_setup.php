<?php
$report="";
	include("sponsor_header.php");
    if(isset($_POST['submit']))
		{
			 $discount=$_POST['discount'];
			 $points=$_POST['points'];
			if($discount==""|| $points==""  )
			{
				$report="Please Enter Discount and Point";
			}
			 else
			 {
			$sp_id=$_SESSION['id'];
			if (strpos($discount,'%')) {
						// We found a string inside string
				}
				else
				{
				 $discount=$discount."%";
				
				}
			
     $arr=  mysql_query("select * from  tbl_sponsored where Sponser_type='discount' and Sponser_product='$discount'and sponsor_id='$sp_id'");
		 if(mysql_num_rows($arr)<=0)
		 {
		$newdate1 = strtotime('+6 months', time()) ; // sponsored date
		$valid_until = date ("m/d/Y", $newdate1);
		$sponsored=date("m/d/Y",time()); // sponsored date
$query="insert into tbl_sponsored(Sponser_type,Sponser_product,Points_per_product,sponsor_id,total_coupons,valid_until,sponsered_date,daily_limit,daily_counter,reset_date,discount) values('discount','$discount','$points','$sp_id','unlimited','$valid_until','$sponsored','unlimited','unlimited','$sponsored','$discount')";
				$rs = mysql_query( $query );
		  }
		  else
		  {
		  
		  		$report="Discount is already present";
		  }
		   
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie Program</title>
<link href="css/style.css" rel="stylesheet">
<script>

function confirmation(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_discount.php?id="+xxx;
    }
    else{
       
    }
	}
	</script>

<script>
function valid_discount()
{	
	var discount=document.getElementById("discount").value;
	
		if(discount=="" || discount==null || discount==0)
			{
				document.getElementById('errordiscount').innerHTML='Please enter discount';
				
				return false;
			}
			else
			{
			document.getElementById('errordiscount').innerHTML='';
			}
			regx1=/^[0-9%]+$/;
				//validation for discount
				if(!regx1.test(discount))
				{
				document.getElementById('errordiscount').innerHTML='Please enter valid discount';
					return false;
				}
				else
			{
			document.getElementById('errordiscount').innerHTML='';
			}
}
function valid_points_per_discount()
{	
	var points=document.getElementById("points").value;
	
		if(points=="" || points==null || points==0 )
			{
				document.getElementById('errorpoints').innerHTML='Please enter points';
				
				return false;
			}
			else
			{
			document.getElementById('errorpoints').innerHTML='';
			}
			regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
			document.getElementById('errorpoints').innerHTML='Please enter valid points';
					return false;
				}
				
					else
			{
			document.getElementById('errorpoints').innerHTML='';
			}
				
}
function valid()
{
	var product=document.getElementById("discount").value;
	
		if(product=="" || product==null || product==0)
			{
			document.getElementById('errordiscount').innerHTML='Please enter discount';
				
				
				return false;
			}
				else
			{
			
			document.getElementById('errordiscount').innerHTML='';
			}
			
		
			regx1=/^[0-9% ]+$/;
				//validation for discount
				if(!regx1.test( product))
				{
				document.getElementById('errordiscount').innerHTML='Please enter valid discount';
					return false;
				}
				
				
					else
			{
			
			document.getElementById('errordiscount').innerHTML='';
			}
		var points=document.getElementById("points").value;
	
		if(points=="" || points==null || points==0)
			{
				document.getElementById('errorpoints').innerHTML='Please enter points';
				
				return false;
			}
				else
			{
			
			document.getElementById('errorpoints').innerHTML='';
			}
		regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
			document.getElementById('errorpoints').innerHTML='Please enter valid points';
					return false;
				}
					else
			{
			
			document.getElementById('errorpoints').innerHTML='';
			}




}
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
</head>

<body style="background-color:#F8F8F8;">
<div class="container" style="padding:10px;" >
<div class="container">
        <div class="row">
        </div>
        <div class="row" style="border-bottom: thin solid #CCCCCC;" align="left">
        <h1 style="padding-left:20px; margin-top:2px;color: #666;
font-family: "Open Sans",sans-serif;
font-size: 12px;">Discount Setup</h1>
        </div>
        
</div>
<div class="container" style="padding:10px;">
    <div class="row">
     <form method="post"  >
      <div class="col-md-6 " style="padding:5px;"> 
             <div class="container" style='border:1px solid #cccccc;padding:2px;width:100%;background-color:#FFFFFF;'>
             	<div class="row" style="height:10px;"></div>
                <div class="row" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 12px;">
                           <div class="col-md-6 col-md-offset-1"  style="color: #666;font-family: "Open Sans",sans-serif;font-size: 12px;">
                            	 <h3>Add Discount</h3>
                           </div>
                </div>
               
                <div class="row form-group ">
                      <div class="col-md-7 col-md-offset-1">
                                        <input type="text" class="form-control" name="discount" id="discount" style="width:100%; height:30px; padding:5px;" placeholder="Enter Discount" onblur="valid_discount()" onkeypress="return isNumberKey(event)" />
                        </div>
                 </div>
                  <div class="row" style="color:#FF0000;font-weight:bold;" >
                  		 <div class="col-md-8 col-md-offset-1" id="errordiscount"></div>
                   </div>
                  <div class="row form-group ">
                  	 <div class="col-md-7 col-md-offset-1">
                          <input type="text" class="form-control" name="points" id="points" style="width:100%; height:30px; padding:5px;" placeholder="Points" onblur="valid_points_per_discount()" onkeypress="return isNumberKey(event)"/>
                     </div>
                  </div>
                   <div class="row" style="color:#FF0000;font-weight:bold;" > 
                   		<div class="col-md-8 col-md-offset-1" id="errorpoints"></div>
                   </div>
                   <div class="row ">
                                      <div class="col-md-8 col-md-offset-1">
                                      <div class="col-md-4">  <input type="submit" name="submit" value="Submit" class="form-control" style="background-color:#0080C0; color:#FFFFFF;" onclick="return valid()"/></div><div class="col-md-4"><a href="coupon_accept.php" style="text-decoration:none;"> <input type="button" class="form-control" name="Cancel" value="Back" style=" background-color:#CC0000; color:#FFFFFF;"/></a></div></div>
                    </div>
                   <div class="row" style="height:30px;color:#FF0000;font-weight:bold;" ><div class="col-md-8 col-md-offset-1 "><?php echo $report;?></div></div>
                   </form>
              </div><!--End of container-->
         </div><!--End of col for left side-->
        
         <div class="col-md-6 " style="padding:5px;">
        <div  style='border:1px solid #cccccc;width:100%;background-color:#FFFFFF;'>
       			 <table class="table-bordered"  cellpadding="2" cellspacing="2" width="100%;">
                              	<tr style="background-color:#0080C0;color:#FFFFFF;" width="100%;" height="30px;"><th width="18%;" style="text-align:center">Sr. No.</th><th width="18%;" style="text-align:center">Discount</th><th width="25%;" style="text-align:center">Points </th><th width="18%;" style="text-align:center">Edit</th><th width="18%;" style="text-align:center">Delete</th></tr>
                        <?php
							$i=0;
							$sp_id1=$_SESSION['id'];
							$arr = mysql_query("select * from tbl_sponsored where Sponser_type = 'discount' and sponsor_id='$sp_id1'");
							while($row = mysql_fetch_array($arr))
							{
							$i++;
						?>
                        <tr>
                            <td align="center"><?php echo $i;?></td>
                            <td align="center">
                            <?php echo $Sponser_product =$row['Sponser_product'];?></td> 
                            <td align="center"><?php echo $row['points_per_product'];?></td>
                            <td align="center"><a href="edit_discount.php?id=<?php echo $row['id'] ?>" style="text-decoration:none;">Edit</a></td>
                            <td align="center">
                            <a onclick="confirmation(<?php echo $row['id']; ?> )"style="text-decoration:none;">Delete</a></td>
                           
                        </tr>
                        <?php
							}
						?>
                  </table>
        </div>
        </div>
        
        </div>
        
      </div><!--End of bottom container-->
      
</div><!--End of outer container-->


<!--<div align="center">
	<div style="width:960px;">
    	<div style="height:10px;"></div>
    	<div style="height:50px; border-bottom: thin solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Discount Setup</h1>
        </div>
    	<div style="height:30px;"></div>
    	<div style="float:left; width:450px;">
        <form method="post"  >
        	<div style="width:430px; background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;" align="left">
            	<div style="height:10px;"></div>
            	<div>
					<h2>Add Discount</h2>
                </div>
                <div style="height:10px;"></div>
            	 <div>
                	<input type="text" name="discount" id="discount" style="width:230px; height:30px; padding:5px;" placeholder=":Enter discount" onblur="valid_discount()"/>
                </div>
                <div style="height:30px;color:#FF0000;font-weight:bold;" id="errordiscount"></div>
                <div>
                	<input type="text" name="points" id="points" style="width:230px; height:30px; padding:5px;" placeholder=":Add number of Points" onblur="valid_points_per_discount()"/>
                </div>
                
                <div style="height:30px;color:#FF0000;font-weight:bold;" id="errorpoints"></div>
                <div>
                <input type="submit" name="submit" style="width:100px; height:30px; background-color:#0080C0; color:#FFFFFF;" placeholder=":Enter Product" />
                </div>
                <div style="height:30px;color:#FF0000;font-weight:bold;" ><?php echo $report;?></div>
                </div>
            </form>
        </div>
        <div style="width:500px; padding-left:480px;">
        	<div style="width:480px; background-color:#FFFFFF; border:1px solid #CCCCCC;">
            	<div style="" align="right">
                	<table cellpadding="2" cellspacing="2">
                    	<tr style="background-color:#0080C0; color:#FFFFFF;"><th style="width:30px;">Sr. No.</th><th style="width:200px;">Product</th><th style="width:100px;">Points per Product</th><th style="width:70px;">Edit</th><th style="width:70px;">Delete</th></tr>
                        <?php
							$i=0;
							$sp_id1=$_SESSION['id'];
							$arr = mysql_query("select * from tbl_sponsored where Sponser_type = 'discount' and sponsor_id='$sp_id1'");
							while($row = mysql_fetch_array($arr))
							{
							$i++;
						?>
                        <tr>
                            <td align="center"><?php echo $i;?></td>
                            <td>
                            <?php echo $Sponser_product =$row['Sponser_product'];?></td> 
                            <td align="center"><?php echo $row['points_per_product'];?></td>
                            <td align="center"><a href="edit_discount.php?id=<?php echo $row['id'] ?>" style="text-decoration:none;">edit</a></td>
                            <td align="center"><a href="delete_discount.php?id=<?php echo $row['id'] ?>" style="text-decoration:none;">delete</a></td>
                        </tr>
                        <?php
							}
						?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php");?>-->
</body>
</html>

