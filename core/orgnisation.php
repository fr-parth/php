 <head>

<?php
@include 'corporate_cookieadminheader.php';
$state=$_GET['state'];
?>


 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#example').DataTable();
});
</script>


<script>

    function confirmation(xxx)
  {

    var s = "Are you sure you want to delete?";
    var answer = confirm(s);
    if (answer){

        window.location = "delete_college.php?inst_id="+xxx;

    }
    else{

    }
  }
</script>

<style>
tr td
{
   border:1px solid #ccc;
}

</style>
 </head>
 <body>
<div class="" style="margin:10px 30px;">
<div class="col-md-12">

<?php

$c1=mysql_query("select count(inst_id) from Institution_directory");
	$c=mysql_fetch_array($c1);
	$totcol=$c[0];
	?>
 <div align="center">
<div class="row"><h3>Organisations List <span class="badge"> <?php echo $totcol; ?></span></h3></div>
<div class="row">
<script>
$(function() {   

    $("#state").change(function() {
  var category= document.getElementById('state').value;
	// document.category.submit();
	    document.forms["state1"].submit();
    })

});
</script>


<form method="get" name="state1">
<select class="form-cotrol btn-sm" name="state" id="state">
	<option disabled selected>Select State</option>
	<?php 
	$s1=mysql_query("select distinct state from Institution_directory");
	while($s=mysql_fetch_array($s1)){ ?>
		<option <?php if($s['state']==$state){ echo "selected";}  ?> value='<?php echo $s['state'];?>'> <?php echo $s['state'];?></option>
    <?php
	}
	?>
</select>

</form>



<?php if(isset($_GET['state'])){ ?>
  <table class="table-striped  table-condensed" id="example" >
                     <thead>
                    	<tr style="background-color:#999;color:#fff ">
						<th  >Sr.No</th>
						<th  >Company Name</th>
						<th  >Address</th>
						<th  >Website</th>
						<th  >Other Info</th>
					   <!-- <th> Edit</th>
                        <th> Delete</th>-->
					</tr>
					</thead>
				<tbody> <?php
				$i=1;

$arr= mysql_query("select * from Institution_directory where `state`='$state'")or die(mysql_error());?>
                  <?php while($row=mysql_fetch_array($arr)){

			/* 	state,district,university_type,university_name,college_name,college_type,address,website,management,year_of_establishment,specialised_in,location,upload_year,type,country	   */
					  
					 
  echo "<tr >
        <td><b>$i</b></td>
		<td >$row[college_name] ( $row[college_type] )</td>
		<td >$row[address] $row[district] $row[state]</td>
        <td width='30px'>$row[website]</td>
 <td >$row[management] ( $row[year_of_establishment] ) ( $row[specialised_in] ) ( $row[location] ) ( $row[type] )</td>
			   
                 ";

                 ?>
                <!-- <td>
                   <a href="edit_college.php?inst_id=<?php echo $row['inst_id']; ?>">Edit</a>
                 </td>
                 <td>
                   <a style="cursor: pointer" onclick="confirmation('<?php echo $row['inst_id']."&col=".$state;?>')">Delete</a>
                 </td>-->
                 <?php
                echo "</tr>";

                $i++; }
				
				?>
                  
                  </tbody>
                  </table>
<?php } ?>
            	  </div>
</div>
</div>

</div>

</body>