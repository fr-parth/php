<?php
include("scadmin_header.php");
$school_id = base64_decode($_REQUEST['id']);
$report = "";
$query = mysql_query("select * from sport_school_all_details where schcd = " . $school_id);
$value = mysql_fetch_array($query);
//$school_id = $value['school_id'];
$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <!-- <title>School's Additional Details</title> -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style>

#details th, #details td{
border: 1px solid #000000; 
}
#details td:hover { 
background-color: #ddd;
}
th{
background-color:  LightSkyBlue    ;
text-align: center;
}
td{
background-color:  none;
text-align: center;
}
table{
border: 1px solid black;
}
  </style>

</head>
<body>

<div class="container">
  <center><h2 > School's Additional Details</h2></center>
              
  <table class="table table-bordered" id="details">
    <thead>
     
	  <tr>
       <!-- <th>Id</th>
        <td><?php echo $value['id']; ?></td>-->

       	<th>Ac Year</th>
		<th>State Name</th>
        <th>District Code</th>
        <th>District Name</th>
		<th>Blkcd</th>
        <th>Blkname</th>
		<th>Clucd</th>
		<th>Cluname</th>
		<th>Vilcd</th>
		<th>Vilname</th></tr>

        <tr>	
		<td><?php echo $value['ac_year']; ?></td>
        
        <td><?php echo $value['state_name']; ?></td>
        
        <td><?php echo $value['district_code']; ?></td>
       
        <td><?php echo $value['district_name']; ?></td>
        
        <td><?php echo $value['blkcd']; ?></td>
        
		<td><?php echo $value['blkname']; ?></td>
        
        <td><?php echo $value['clucd']; ?></td>
        
         <td><?php echo $value['cluname']; ?></td>
        
         <td><?php echo $value['vilcd']; ?></td>
        
        <td><?php echo $value['vilname']; ?></td></tr>
        
		 <tr>
        <th>Schcd</th>
		<th>Schname</th>
		<th>Schstatus</th>
		<th>Pancd</th>
        <th>Edublkcd</th>
		<th>Habitcd</th>
        <th>Aconstcd</th>
        <th>Municipalcd</th>
         <th>City</th>
         <th>Schmgt Desc</th></tr>

        <tr>
        <td><?php echo $value['schcd']; ?></td>
        
        <td><?php echo $value['schname']; ?></td>
        
        <td><?php echo $value['schstatus']; ?></td>
	        
        <td><?php echo $value['pancd']; ?></td>
        
        <td><?php echo $value['edublkcd']; ?></td>
      
		<td><?php echo $value['habitcd']; ?></td>
        
        <td><?php echo $value['aconstcd']; ?></td>
        
        <td><?php echo $value['municipalcd']; ?></td>
        
        <td><?php echo $value['city']; ?></td>
        
        <td><?php echo $value['schmgt_desc']; ?></td></tr>

        <tr>
        <th>Schmgt</th>
		<th>Schcat</th>
        <th>Rururb Id</th>
		<th>Schcat Desc</th>
		<th>Rururb</th>
		<th>Lowclass</th>
		<th>Highclass</th>
		<th>Email</th>
		<th>C1 B</th>
		<th>C1 G</th></tr>
		
		<tr>
		<td><?php echo $value['schmgt']; ?></td>
        
        <td><?php echo $value['schcat']; ?></td>
        
        <td><?php echo $value['rururbid']; ?></td>
        
        <td><?php echo $value['schcat_desc']; ?></td>
         
         <td><?php echo $value['rururb']; ?></td>

	    <td><?php echo $value['lowclass']; ?></td>
        
        <td><?php echo $value['highclass']; ?></td>
         
        <td><?php echo $value['email']; ?></td>
        
        <td><?php echo $value['c1_b']; ?></td>
        
        <td><?php echo $value['c1_g']; ?></td></tr>

        <tr>
        <th>C2 B</th>
        <th>C2 G</th>
		<th>C3 B</th>
        <th>C3 G</th>
        <th>C4 B</th>
        <th>C4 G</th>
        <th>C5 B</th>
        <th>C5 G</th>
        <th>C6 B</th>
        <th>C6 G</th></tr>

        <tr>
        <td><?php echo $value['c2_b']; ?></td>
        
        <td><?php echo $value['c2_g']; ?></td>
        
        <td><?php echo $value['c3_b']; ?></td>
        
        <td><?php echo $value['c3_g']; ?></td>
        
        <td><?php echo $value['c4_b']; ?></td>
                
        <td><?php echo $value['c4_g']; ?></td>       
        
        <td><?php echo $value['c5_b']; ?></td>
        
        <td><?php echo $value['c5_g']; ?></td>
        
        <td><?php echo $value['c6_b']; ?></td>        
        
        <td><?php echo $value['c6_g']; ?></td></tr>

        <tr>
        <th>C7 B</th>
        <th>C7 G</th>
        <th>C8 B</th>
        <th>C8 G</th>
        <th>C9 B</th>
		<th>C9 G</th>
		<th>C10 B</th>
		<th>C10 G</th>
		<th>C11 B</th>
        <th>C11 G</th></tr>

        <tr>
        <td><?php echo $value['c7_b']; ?></td>
        
         <td><?php echo $value['c7_g']; ?></td>
        
        <td><?php echo $value['c8_b']; ?></td>
        
         <td><?php echo $value['c8_g']; ?></td>
        
         <td><?php echo $value['c9_b']; ?></td>
        
         <td><?php echo $value['c9_g']; ?></td>
         
         <td><?php echo $value['c10_b']; ?></td>
        
        <td><?php echo $value['c10_g']; ?></td>
        
         <td><?php echo $value['c11_b']; ?></td>
         
         <td><?php echo $value['c11_g']; ?></td></tr>

        <tr>
         <th>C12 B</th>
		 <th>C12 G</th>
         <th>TotalB</th>
         <th>TotalG</th>
         <th>Total</th>
         <th>Tch M</th>
         <th>Tch F</th>
         <th>Tch T</th></tr>

         <tr>
         <td><?php echo $value['c12_b']; ?></td>
         
         <td><?php echo $value['c12_g']; ?></td>
        
        <td><?php echo $value['totalb']; ?></td>
        
         <td><?php echo $value['totalg']; ?></td>
         
         <td><?php echo $value['total']; ?></td>

         <td><?php echo $value['tch_m']; ?></td>
         
         <td><?php echo $value['tch_f']; ?></td>
         
         <td><?php echo $value['tch_t']; ?></td></tr>
		   
     </thead>
   
  </table>
</div>

</body>
</html>
        
    