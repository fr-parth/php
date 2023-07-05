<html>
<head>
</head>
<body style='font-family:Helvetica, Arial, sans-serif; font-size:10pt;'>		
	<table style="width:100%; border-collapse:collapse; border:1px solid #CCC;">  
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;"><img src="<?php echo base_url()."images/250_86.png"; ?>" width='188px' height='65px' ></td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;" ><h1 style="padding:10px;"><center>Receipt</center></h1></td>
	</tr>  
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;">Receipt No:</td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;" ><?php echo "SPR".$id.$dates;?></td>
	</tr>
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;">Name:</td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;"><?php echo $sponsor_name ; ?></td>
	</tr>
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;">Email:</td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;"><?php echo $email; ?></td>
	</tr>
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;">Amount:</td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;"><?php echo $amount; ?></td>
	</tr>
	<tr>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;">validity :</td>
		<td style="padding:5px; border:1px solid #CCC; border-width:1px 0;"><?php echo $date1; ?></td>
	</tr>
	</table>
</body>
</html>