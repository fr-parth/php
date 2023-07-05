<?php
include("cookieadminheader.php");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<!--<link href="css/style.css" rel="stylesheet"> -->
<!-- <link rel="stylesheet" href="/lib/w3.css">-->
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  rgba(150,150,150, 0.5);
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>
</head>
<body>


<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div class="radius " style="height:50px; width:100%; background-color:#ddd;" align="left">
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard </h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                	<h4 class="" align="center">Points used for buying coupons today's</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("select sum(for_points)as pufbct from tbl_selected_vendor_coupons where used_flag='unused' and timestamp=curdate()") or die(mysql_error());
                                             $result=mysql_fetch_array($row);
                                                echo (!empty($result['pufbct']))?$result['pufbct']:'0';
												


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                	<h4 align="center">Number of sponsors registered today's</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
                $result = mysql_query("select count(sp_date)as nostoday from tbl_sponsorer where sp_date=curdate()");
				$row = mysql_fetch_array($result);
				echo $row['nostoday'];

				?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
                	<h4 align="center">Number of sponsors registered todays by salesperson</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									 <?php
                $result = mysql_query("select count(v_status)as nostsalep from tbl_sponsorer where v_status='Active' AND sp_date=curdate() and sales_person_id!='0' ");
				$row = mysql_fetch_array($result);
		 			    echo $row['nostsalep'];
				?>

                        		</div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                	<h4 align="center">Number of sponsors registered by themselves</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
									    $result=mysql_query("select count(sp_date)as nosrbt from tbl_sponsorer where sp_date=curdate() AND sales_person_id='0' and v_status in('Active',NULL)");
                                             $row=mysql_fetch_array($result);
                                                 echo $row['nosrbt'];


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
                	<h4 align="center">Number of sponsors registered till today's</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $result=mysql_query("select count(id)as norstt from tbl_sponsorer where v_status in('Active',NULL)");
                                             $row=mysql_fetch_array($result);
                                              echo $row['norstt'];


                                    ?>

                        	</div>

     </div>
				
<div class="col-sm-1" style="padding-top:20px;"></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
                	<h4 align="center">Number of sponsors registered till today by salesperson</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $result=mysql_query("select count(id)as nosrttbs from tbl_sponsorer");
                                             $row=mysql_fetch_array($result);
                                              echo $row['nosrttbs'];


                                    ?>

                        	</div>

    </div>
	
	</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                	<h4 align="center">Number of sponsors registered till today by themselves</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
									    $result=mysql_query("select count(sp_date)as nosrttbs from tbl_sponsorer");
                                             $row=mysql_fetch_array($result);
                                                 echo $row['nosrttbs'];


                                    ?>

                        		</div>

                </div></a>
</div>				
</div>



</div>
</body>
</html>







