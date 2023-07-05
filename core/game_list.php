<?php
include("cookieadminheader.php");

	$sql="SELECT g.*,ca.group_name FROM tbl_games g LEFT JOIN  tbl_cookieadmin ca on g.group_member_id = ca.id order by id ";
	$row=mysql_query($sql);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Games Information</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

  <script>
  $(function() {
    $( "#from_date" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });

  $(function() {
    $( "#to_date" ).datepicker({
      changeMonth: true,
      changeYear: true,

    });
  });
  </script>

  <script>
      $(document).ready(function(){
     $('#example').dataTable()
		  ({
    		});
		});

   </script>
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
 </head>

<body bgcolor="#CCCCCC">
<div align="center">
<div class="container" style="width:100%;">
<div style="padding-top:30px">

        	<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#694489; margin-top:2px;color:#666;color:white">All Games Information</h2>

</div>





<div id="no-more-tables">
  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf"  >

        		<thead>

        				<tr  style="background-color:#694489; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Game Name</th>
					<th>Group Name</th>
                    
                    
                  <!--  <th>Assign</th>-->
                </tr>

        		</thead>

             <?php $i=1;

 while($result=mysql_fetch_array($row)){
	 //print_r($result); exit;
?>
<tr>
<td data-title="Sr.No."><?php echo $i;  ?></td>

<td  data-title="Name"><?php echo $result['name'];?></td>
<td  data-title="Name"><?php echo $result['group_name'];?></td>

</tr>
<?php  $i++;} ?>

        	</table>










</div>




</div>

</div>


</div>
</div>
</body>
</html>
