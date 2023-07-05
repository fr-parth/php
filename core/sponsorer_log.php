<?Php
//Changes done by Pranali intern start
include_once('scadmin_header.php');
//include_once("school_staff_header.php");
$report="";

$smartcookie=new smartcookie();

           $id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);

$sc_id=$result['school_id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



  <style>

@media only screen and (max-width: 800px) {

    

    /* Force table to not be like tables anymore */

	#no-more-tables table, 

	#no-more-tables thead, 

	#no-more-tables tbody, 

	#no-more-tables th, 

	#no-more-tables td, 

	#no-more-tables tr { 

		display: block; 

	}

 

	/* Hide table headers (but not display: none;, for accessibility) */

	#no-more-tables thead tr { 

		position: absolute;

		top: -9999px;

		left: -9999px;

	}

 

	#no-more-tables tr { border: 1px solid #ccc; }

 

	#no-more-tables td { 

		/* Behave  like a "row" */

		border: none;

		border-bottom: 1px solid #eee; 

		position: relative;

		padding-left: 50%; 

		white-space: normal;

		text-align:left;

		font:Arial, Helvetica, sans-serif;

	}

 

	#no-more-tables td:before { 

		/* Now like a table header */

		position: absolute;

		/* Top/left values mimic padding */

		top: 6px;

		left: 6px;

		width: 45%;

		padding-right: 10px; 

		white-space: nowrap;

		text-align:left;

		

	}

 

	/*

	Label the data

	*/

	#no-more-tables td:before { content: attr(data-title); }

}

</style>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Sponsor Log</title>

</head>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>



<script>

$(document).ready(function() {

    $('#example').dataTable( {

	

      

    } );

} );



</script>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div class="container" style="padding:30px;">

  	<div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

    <div style="background-color:#F8F8F8;">

                    <div class="row">

                    <div class="col-md-3"  style="color:#700000 ;padding:5px;">

               			 </div>

              			 <div class="col-md-6 " align="center">

                         <h2>Sponsor Log</h2>

               			 </div>

                         

                     </div>

                  <div class="row" style="padding:10px;" >

                  <div class="col-md-12" id="no-more-tables" >

               <?php $i=0;?>
           

   <table class="table-bordered  table-condensed cf" id="example" width="100%;" > 
   <thead>

<tr style="background-color:#555;color:#FFFFFF;height:30px;">
<th>Sr.No.</th><th>Sponsor Name</th><th>Sponsored Product Type</th><th>Sponsored Product/Discount</th><th>Points Per Product/Discount</th></tr>

                      </thead><tbody>

                 <?php

				 

				$i=1;
	
$arr=mysql_query("select s.id ,s.sp_company,sp.Sponser_type,sp.Sponser_product,sp.points_per_product from tbl_sponsored sp join tbl_sponsorer s on s.id = sp.sponsor_id  ORDER BY sp.id");?>

                  <?php while($row=mysql_fetch_array($arr)){

				 

				  ?>

                  <tr class="d0"  style="height:30px;color:#808080;">

                

                    <td ><?php echo $i;?></td>

					

                <td ><?php echo $row['sp_company'];?></td>

                

                   

                    

					  <td><?php echo $row['Sponser_type'];?> </td>

                    

                    <td><?php echo $row['Sponser_product'];?> </td>

					

					<td ><?php echo $row['points_per_product'];?> </td>

					</tr>

                <?php 

				$i++;

				?>

                 <?php }//while?>

                  

                  </tbody>

                  </table>

                

                  </div>

                  </div>

                  

                  

                   <div class="row" style="padding:5px;">

                   <div class="col-md-4">

               </div>

                  <div class="col-md-3 "  align="center">

                   

                   </form>

                   </div>

                    </div>

                     <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-3" style="color:#FF0000;" align="center">

                      

                      <?php echo $report;?>

               			</div>

                 

                    </div>

                  </div>

               </div>
</div>
</div>
</body>
<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>
<!-- changes done end -->
