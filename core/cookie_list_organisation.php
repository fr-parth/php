<?php
include("corporate_cookieadminheader.php");

?>
<html>

 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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



      <script>
       $(document).ready(function() {

	    $('#example').DataTable();
} );
        </script>

        <script>

    function confirmation(xxx)
  {

    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "cookie_delete_school.php?sc_id="+xxx;

    }
    else{

    }
  }
</script>

<body>
<div class="container" style="padding-top:20px;width:100%;">

<div style="width:100%; height:50px; background-color:#f9f9f9; border:1px solid #CCCCCC;" align="center" >
        	<h1 style="padding-left:20px; margin-top:4px;">Edit Organisation Info</h1>
        </div>

         <div style="height:20px;"></div>




              <div id="no-more-tables" style="padding-top:20px;">


  <table id="example" class="table-bordered table-striped ">



        				<thead>
        			<tr style="background-color: #ddd">
                	<th>Sr. No.</th>
                    <th align="center">Company ID</th>
                     <th>Company Name</th>
                    <th>Techanical Non Techanical Head</th>

                    <th>Email</th>
                    <th>Reg Date</th>
                     <th>Edit</th>
                     <th>Delete</th>


                </tr>
                </thead>



             <?php $i=1;
			 	$sql=mysql_query("SELECT id,school_id,school_name,name,school_name,email,reg_date FROM `tbl_school_admin` where `school_id`!=''  order by school_id");

 while($result=mysql_fetch_array($sql)){
 $school_id=$result['school_id'];?>
<tr>
<td><?php echo $i;   ?></td>
<td><?php echo $school_id;?></td>
<td><?php echo $result['school_name'];?></td>
<td><?php echo $result['name'];?></td>
<td><?php echo $result['email'];?></td>
<td><?php echo $result['reg_date'];?></td>
<td><a href="cookie_edit_company.php?s_id=<?php echo $result['id']; ?>">Edit</a></td>
<td><a style="cursor: pointer" onclick="confirmation(<?php echo $school_id; ?>)">Delete</a></td>





</tr>
<?php  $i++;} ?>

        	</table>
        </div>




























            </div>

		       </div>

       </div>


</body>
</html>
