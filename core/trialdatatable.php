
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
<title>Info Table</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></link>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
	 $('#example tr').click(function(){
        window.location = $(this).data('href');   
    });
} );
</script>
</head>
<body>


<form method="post" >
<table align="center" style="margin-top: 1cm;">
<tr>
<td><input type="text" name="collcode" placeholder="College Code" value="<?php if(isset($_POST['collcode'])) { echo $_POST['collcode']; }?>"></td>
<td><input type="text" name="collname" placeholder="College Name" value="<?php if(isset($_POST['collname'])) { echo $_POST['collname']; }?>"></td>
<td><input type="text" name="stream" placeholder="Stream" value="<?php if(isset($_POST['stream'])) { echo $_POST['stream']; }?>"></td>
<td><input type="text" name="location" placeholder="Location" value="<?php if(isset($_POST['location'])) { echo $_POST['location']; }?>"></td>
<td><input type="submit" value="Go" name="submit"></td>

</tr>

</table>
</form>

<?php

if(isset($_POST['submit']))
{
$collcode = trim($_POST['collcode']);
$collname = trim($_POST['collname']);
$stream = trim($_POST['stream']);
$location = trim ($_POST['location']);


$conn = mysql_connect("localhost","root","");
$db = mysql_select_db("smartcookie");
$query="select * from college_list";
$query1=" where ";

if($collcode=='' & $collname=='' & $stream=='' & $location=='')
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('trialdatatable.php')</script>";
	}
else
{
	$f = 0;
	if($collcode!='')
		{
			$query1.="college_code like '$collcode'";
			$f = 1;
		}
	if($collname!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="college_name like '%$collname%'";
			$f=1;
		}
	if($stream!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="stream like '%$stream%'";
			$f=1;
		}
	if($location!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="college_location  like '$location'";
			$f=1;
		}
	
	
	$query_final=$query.$query1;
	
	$sql = mysql_query($query_final);
	if(mysql_num_rows($sql)>0)
		{

	?>

<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<th>Sr.No</th>
				<th>College Code</th>
				<th>Stream</th>
				<th>College Name</th>
				<th>College Location</th>
				<th>Intake</th>
				<th>Principal Name</th>
				<th>Contact Number</th>
				<th>Alternate Contact</th>
				<th>College Email</th>
				<th>TPO Name</th>
				<th>TPO Contact</th>
				<th>Tpo Email</th>
                <th>number_of_teachers</th>
				<th>number_of_students</th>
                <th>number_of_subjects</th>
				<th>date Updated</th>
                 <th>Source</th>
                <th>Delete</th>
             
            </tr>
        </thead>
         <tbody>
      <?php
      $c = 1;
			while($rows = mysql_fetch_array($sql))
				{?>
       
            <tr data-href='trial.php?id=<?php echo $rows["id"];?>'>
            <td style="padding:10px;" align="center"><?php echo $c;?></td>
            <td style="padding:10px;" align="center"><?php echo $rows['college_code'];?></td>
              <td style="padding:10px;" align="center"><?php echo $rows['stream'];?></td>
                <td style="padding:10px;" align="center"><?php echo $rows['college_name'];?></td>
                  <td style="padding:10px;" align="center"><?php echo $rows['college_location'];?></td>
                    <td style="padding:10px;" align="center"><?php echo $rows['intake'];?></td>
                      <td style="padding:10px;" align="center"><?php echo $rows['pricipal_name'];?></td>
                        <td style="padding:10px;" align="center"><?php echo $rows['contact_number'];?></td>
                          <td style="padding:10px;" align="center"><?php echo $rows['alternate_contact'];?></td>
                            <td style="padding:10px;" align="center"><?php echo $rows['college_email'];?></td>
                              <td style="padding:10px;" align="center"><?php echo $rows['tpo_name'];?></td>
                                <td style="padding:10px;" align="center"><?php echo $rows['tpo_contact'];?></td>
                                  <td style="padding:10px;" align="center"><?php echo $rows['tpo_email'];?></td>
                                     <td style="padding:10px;" align="center"><?php echo $rows['number_of_teachers'];?></td>
                                        <td style="padding:10px;" align="center"><?php echo $rows['number_of_students'];?></td>
                                        <td style="padding:10px;" align="center"><?php echo $rows['number_of_subjects'];?></td>
                                           <td style="padding:10px;" align="center"><?php echo $rows['date_Updated'];?></td>
                                  				 <td style="padding:10px;" align="center"><?php echo $rows['source'];?></td>
                                                <td>	
                        <a href='delete.php?id=<?php echo $rows["id"];?>'><button type="button" class="btn btn-danger btn-sm" style=" border-radius: 25px" >Delete</button></a>
                                                </td>
            
                
            </tr>
            
     <?php $c++; }?>
        </tbody>
    </table>
    	<?php }
       	
	else
		{
			echo "<script>window.alert('No records found')</script>";
			echo "<script>window.location.assign('trialdatatable.php')</script>";
		}
		
}
}?>

 
    </body>
    </html>