<?php

include("sponsor_header.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		 $sql1="select * from tbl_sponsored where id=".$id;
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_array($row);
		$product=$arr['Sponser_product'];
		 $points_per_product=$arr['points_per_product']; 
		
	}
?>
<?php
 if(isset($_POST['submit']))
 {
   $product=$_POST['product'];
	$points_per_product=$_POST['points'];
	 $sql="update tbl_sponsored set Sponser_product='$product', points_per_product='$points_per_product' where id='$id'";
	mysql_query($sql);
	header('location:product_setup.php');
}
 ?>
<html>

<body style="background-color:#EBEBEB;">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
	<div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;" align="center">
         <form method="post"  >
          <div class="row" style="color: #666;font-family: "Open Sans",sans-serif;font-size: 12px;">
                <h2>Edit Product</h2>
          </div>
          <div class="row ">
                  <div class="col-md-5" align="left">
                  <b>Product</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                               <input type="text" name="product" class="form-control" style="width:100%;  padding:5px;" placeholder=":Enter product" value='<?php echo $product ?>'/>
                  </div>
          </div>
          <div class="row ">
                  <div class="col-md-5" align="left">
                 <b> Points for Product</b>
                  </div>
                  <div class="col-md-5">
                        
                            <input type="text" name="points" class="form-control" style="width:100%; padding:5px;" placeholder=":Add number of Points" value='<?php echo $points_per_product?>'/>
                  </div>
          </div>
          <div class="row" >
          	<div class="col-md-3 col-md-offset-3" style="padding:10px;">
          			     <input type="submit" class="form-control" name="submit" style="width:100%; background-color:#0080C0; color:#FFFFFF;" value="Submit">
             </div>
             <div class="col-md-3" style="padding:10px;">
                             
                <a href="product_setup.php" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="Cancel" style="width:100%; background-color:#0080C0; color:#FFFFFF;" ></a>

              </div>
          
          </div>
         </form>
          </div>
      </div>
    </div>
</div>
<!--<div align="center">
	<div style="width:1002px; margin-top:10px;" >
    	 <div style="height:10px;"></div>
<div style="float:left; width:450px;" >
        <form method="post"  >
        	<div style="width:430px; background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:30px;margin-left:200px;" >
            	<div style="height:10px;"></div>
            	<div>
					<h2>Edit Discount</h2>
                </div>
                <div style="height:10px;"></div>
            	 <div >
               
                	Dicount
                
                	<input type="text" name="product" style="width:230px; height:30px; padding:5px;margin-left:105px;" placeholder=":Enter discount" value='<?php echo $product ?>'/>
                
                </div>
                <div style="height:30px;"></div>
                <div>
                
                	Points for Dicount
                
                	<input type="text" name="points" style="width:230px; height:30px; padding:5px;margin-left:50px;" placeholder=":Add number of Points" value='<?php echo $points_per_product?>'/>
                </div>
                
                <div style="height:30px;"></div>
                <div>
                <input type="submit" name="submit" style="width:100px; height:30px;margin-left:80px; background-color:#0080C0; color:#FFFFFF;" >
                <a href="product_setup.php" style="text-decoration:none;"><input type="button" name="cancel" value="cancel" style="width:100px; height:30px;margin-left:20px; background-color:#0080C0; color:#FFFFFF;" ></a>
                </div>
                <div style="height:30px;"></div>
            </div>
            </form>
        </div>
        </div>
        </div>
      -->
</body>
</html>
