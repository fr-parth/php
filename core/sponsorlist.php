<?php

		 

     include_once('scadmin_header.php');

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

		

		padding-right: 10px; 

		white-space: nowrap;

		

		

	}

 

	/*

	Label the data

	*/

	#no-more-tables td:before { content: attr(data-title); }

}

</style>

        







<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Sponsor List</title>

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
			    <div style="background-color:#F8F8F8 ;">
				    
					<div class="row">
					    <div class="col-md-3"  style="color:#700000 ;padding:5px;">
						</div>
						<div class="col-md-6 " align="center"  >
							<h2>List of Sponsors </h2>
						</div>
					</div>

					<div class="row" align="center" style="margin-top:3%;">
                        <form method="post">
                            <div class="col-md-4"></div>
                            <div class="col-md-3">
                                <select name="info" class="form-control"> 
								<?php $select_option_value= $_POST['info'] ?>
									<option value="All" <?php if($select_option_value == "All") echo "selected"; ?>> All </option>
									<option value="Interested" <?php if($select_option_value == "Interested") echo "selected"; ?>> Interested </option>
                                    <option value="NotInterested" <?php if($select_option_value == "NotInterested") echo "selected"; ?>> Not Interested </option>
									<option value="Suggested" <?php if($select_option_value == "Suggested") echo "selected"; ?>> Suggested </option>
                                    <option value="CallBack" <?php if($select_option_value == "CallBack") echo "selected"; ?>> Call Back </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" name="submit" value="Show" class="btn btn-success">
                            </div>
                        </form>
                    </div>

					<div class="row" style="padding:10px;">
	                	<div class="col-md-12" id="no-more-tables" >
				  			<?php $i=0;?>
               				<table class="table-bordered  table-condensed cf" id="example" width="100%;" > 
							   <thead>
									<tr style="background-color:#555;color:#FFFFFF;height:30px;" ><th >Sr.No</th><th >Sponsor Name</th><th>Sponsor Address</th><th >Phone No.</th>
									<th >Email ID</th></tr>
								</thead>
							<tbody>

                 <?php
					
					$i=1;// for serial number
					//query to get data of 100rows each time
					$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer order by sp_company ");
					
					if(isset($_POST['submit'])) {
			//changes in below queries done by Pranali for bug SMC-3350
			
						if ($_POST['info'] == 'All') {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer order by sp_company ");
						} 
						else if ($_POST['info'] == 'Interested') {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer where v_responce_status='Interested' order by sp_company ");
						} 
						else if ($_POST['info'] == 'NotInterested') {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer where v_responce_status='Not Interested' order by sp_company; ");
						} 
						else if($_POST['info'] == 'Suggested') {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer where v_responce_status='Suggested' order by sp_company;");
						}
						else if($_POST['info'] == 'CallBack') {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer where v_responce_status='Call back/Come later' order by sp_company ");
						}
						else {
							
							$arr=mysql_query("select sp_company,sp_address,sp_phone,sp_email from tbl_sponsorer order by sp_company ");
						}
			//changes end
					}

					$result = mysql_num_rows($arr);
					if(isset($_POST['info']))
						{
							$selection_value=  $_POST['info'];
						}
					else {
						$selection_value= "";
						}

                    ?>
                  	<?php while($row=mysql_fetch_array($arr)){ ?>
					<tr class="d0"  style="height:30px;color:#808080;">
						<td><?php echo $i;?></td>
						<td><?php echo $row['sp_company'];?></td>
						<td><?php echo $row['sp_address'];?> </td>
						<td><?php echo $row['sp_phone'];?> </td>
						<td><?php echo $row['sp_email'];?> </td>
					</tr>
                	<?php $i++; ?>
					<?php }?>
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

</body>

</html>

