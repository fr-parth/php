 
<?php
include('cookieadminheader.php');
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
<div class="row"><h3>College List <span class="badge" style="margin-left: 25px;"> <?php echo $totcol; ?></span></h3></div>
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
<a href="insert_college.php"><input type= "button" value="Add">
</a>

<select class="form-cotrol btn-sm" name="state" id="state">
	<option >Select State</option>
	<?php 
	$s1=mysql_query("select distinct state from Institution_directory where state IS NOT NULL");
	while($s=mysql_fetch_array($s1)){ ?>
		<option <?php if($s['state']==$state){ echo "selected";}  ?> value='<?php echo $s['state'];?>'> <?php if(!empty($s['state'])) echo $s['state'];?></option>
    <?php
	}
	?>
</select>

</form>



<?php if(isset($_GET['state'])){ ?>
  <table class="table-striped  table-condensed" id="example" >
                     <thead>
                    	<tr style="background-color:#999;color:#fff ">
						<th>Sr.No</th>
						<th>College Name</th>
						<th>Address</th>
						<th>University</th>
						<th>Website</th>
						<th>Other Info</th>
						<th>College Email</th>
						<th>Contact NO</th>
						<th>Source</th>
						<th>calculated_lat</th>
						<th>calculated_lon</th>
						<th>GPS_lat</th>
						<th>GPS_lon</th>
						<th>college_code</th>
						<th>intake</th>
					  <th>principal_name</th>
					<th>tpo_name</th>
					<th>tpo_contact</th>
					<th>tpo_email</th>
					<th>number_of_teachers</th>
					<th>number_of_students</th>
					<th>number_of_subjects</th>
					<th>date_Updated</th>
					   <th> Edit</th>
                        <th> Delete</th>
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
		<td>$row[university_name] ( $row[university_type] )</td>
        <td width='30px'>$row[website]</td>
 <td >$row[management]</td>
  <td >$row[college_email]</td>
  <td >$row[contact]</td>
  
    <td>$row[source]</td>
	 <td>$row[calculated_lat]</td>
	  <td>$row[calculated_lon]</td>
	   <td>$row[GPS_lat]</td>
	    <td>$row[GPS_lon]</td>
		 <td>$row[college_code]</td>
		  <td>$row[intake]</td>
		   <td>$row[principal_name]</td>
		    <td>$row[tpo_name]</td>
			 <td>$row[tpo_contact]</td>
			  <td>$row[tpo_email]</td>
			   <td>$row[number_of_teachers]</td>
			    <td>$row[number_of_students]</td>
			    <td>$row[number_of_subjects]</td>
				 <td>$row[date_Updated]</td>";

                 ?>
                 <td>
                   <a href="edit_college.php?inst_id=<?php echo $row['inst_id'];?>"> <span class="glyphicon glyphicon-pencil"></span></a>
                 </td>
                 <td>
                   <a style="cursor: pointer" onclick="confirmation('<?php echo $row['inst_id']."&col=".$state;?>')"><span class="glyphicon glyphicon-trash"></span></a>
                 </td>
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