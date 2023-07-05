<?php

	mysql_connect('pangohc.db.7121184.hostedresource.com', 'pangohc', 'Pangohc@123');
	mysql_select_db('pangohc');
	if($_POST['search'])
	{
		$from=$_POST['from'];
		$to=$_POST['to'];
		$query = "select * from  tbl_gohc where createddate BETWEEN '$from' AND '$to' order by createddate";
		$sql = mysql_query($query);
	}
	else
	{
		$date=date('Y-m-d');
		$query ="select * from  tbl_gohc where createddate like '%$date%' order by createddate";
	$sql = mysql_query($query);
	}
	
?>
	<html>
	<head>
	<style>
	h1 {
    text-align: center;
	text-decoration: underline;
	
	color: green;
    text-shadow: 2px 2px 4px #000000;
	}

	</style>
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function(){
		$('#myTable').DataTable();
		$('#myTable tr').click(function(){
        window.location = $(this).data('href');   
    });
		});
	</script>
	</head>
	<body>
	<h1>Details Of PHP Database</h1>
   
	<p>&nbsp;</p>
	<p>&nbsp;</p>
    <div align="center"><form method="post"> <b>From <input type="date" name="from" value="<?php if(isset($_POST['search'])){ echo $_POST['from'];} else { echo date('d-m-Y');}?>">  To <input type="date" name="to" value="<?php  if(isset($_POST['search'])){ echo $_POST['to']; }else { echo date('d-m-Y');}?>"> <input type="submit" name="search"></b></form></div>
	<table id="myTable" class="table table-bordered">
	<thead>
	<tr>
		<th>g_id</th>
        <th>Reminder Id</br>Plan Id</th>
		<th>Member id</br>Name</th>
		
		<th>Value</br>Method</br>Way</th>
		<th>Reading</th>
		<th>AnsweredBy</th>
		<th>Medtype</th>
		<th>Template Id</br>Prompt Code</th>
		<th>Recipient Id</br>
        Recipient Phone</br>
		Recipient Email</th>
		<th>Country</th>
		<th>Org Code</th>
		<th>Language</th>
		<th>Template For</th>
		<th>Template Type</th>
		<th>Sponser Name</th>
        <th>Call date</th>
        <th>url</th>
	</tr>
	</thead>
	<tbody>
<?php

if(mysql_num_rows($sql)>0)
{
	while($rows = mysql_fetch_assoc($sql))
	{
?>
		<tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'"

				  onmouseout="this.style.textDecoration='none';this.style.color='black';" 

				  onclick="window.location='detaildata.php?t_id=<?php echo $rows['id'];?>'" 

				  style="cursor: pointer; text-decoration: underline; color: dodgerblue; background-color: rgb(239, 243, 251);height:30px;color:#808080;">
		<td><?php echo $rows['g_id'] ; ?></td>
        <td><?php echo $rows['reminderid'] ; ?></br><?php echo $rows['planid'] ; ?></td>
		<td><?php echo $rows['meid'] ; ?></br><?php echo $rows['name'] ; ?></td>
		<td><?php echo $rows['value'] ; ?></br><?php echo $rows['method'] ; ?></br><?php echo $rows['way'] ; ?></td>
		<td><?php echo $rows['reading'] ; ?></td>
		<td><?php echo $rows['AnsweredBy'] ; ?></td>
		<td><?php echo $rows['medtype'] ; ?></td>
		<td><?php echo $rows['template_id'] ; ?><br><?php echo $rows['pmt_prompt'] ; ?></td>
		<td><?php echo $rows['recipientid'] ; ?></br>
		<?php echo $rows['recipient_phone'] ; ?></br>
		<?php echo $rows['recipient_email'] ; ?></td>
		<td><?php echo $rows['country'] ; ?></td>
		<td><?php echo $rows['org_code'] ; ?></td>
		<td><?php echo $rows['language'] ; ?></td>
		<td><?php echo $rows['template_for'] ; ?></td>
		<td><?php echo $rows['template_type'] ; ?></td>
		<td><?php echo $rows['SponserName'] ; ?></td>
        <td><?php echo $rows['createddate'] ; ?></td>
        <td><?php echo $rows['url'] ; ?></td>
		
		</tr>
<?php
	}
}

else
{
	?>
    <div align="center" style="color:red;">
  
 Record not found
 </div>
 <?php 
}
?>
	</tbody>
	</table>
	
	</body>
	</html>
