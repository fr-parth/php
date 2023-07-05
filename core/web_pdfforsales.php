<html>
<head>
	<style>
	body {font-family:Helvetica, Arial, sans-serif; font-size:10pt;}
	table {width:100%; border-collapse:collapse; border:1px solid #CCC;}
	td {padding:5px; border:1px solid #CCC; border-width:1px 0;}
	</style>
</head>
<body>

<img src="logo.png">
	<h1 style="padding-top:30px;"><center>Receipt</center></h1>
	
	<table>
    
    <tr>
<td>Receipt No:
</td>
<td><?php echo "SPR".$id.$dates.$amount;?></td>

</tr>		<tr>
			<td>Name:</td>
			<td><?php echo $sponsor_name ; ?></td>
			<td>Email:</td>
			<td><?php echo $email; ?></td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td colspan="3"><?php echo $amount; ?></td>
		</tr>
		
        <tr>
			<td>validity :</td>
			<td colspan="3"><?php echo $date1; ?></td>
		</tr>
	</table>
	


</body>
</html>