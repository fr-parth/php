<?php
	mysql_connect("panmom.db.7121184.hostedresource.com", "panmom", "Pass@123") or die(mysql_error());
	mysql_select_db("panmom") or die(mysql_error());
	
	$number1 = str_replace('+','',$_REQUEST['From']);
	$number = substr ($number1,'2','11');
	$body=$_REQUEST['Body'];
	$curr_date = date('M/d/Y');
	$app_date = date('M/d/Y',strtotime('-2 day'));
	$message = explode(" ",$body);
	$count = count($message);
	if($count == 1)
	{
		//echo "SELECT twillioId FROM twillioresponse where tNumber='$number' and AnsweredBy = 'SMS' and  `callStatus` = '' and app_date between '$app_date' and '$curr_date' order by twillioId desc limit 1";die;
		$response = strtoupper($body);
		$result = mysql_query("SELECT twillioId FROM twillioresponse where tNumber='$number' and AnsweredBy = 'SMS' and  `callStatus` = '' and app_date between '$app_date' and '$curr_date' order by twillioId desc limit 1");
	}
	else
	{
	 	$response = strtoupper($message[1]);
	 	$reminderid = $message[0];
		$result = mysql_query("SELECT twillioId FROM twillioresponse where tNumber='$number' and AnsweredBy = 'SMS' and me_id = '$reminderid' and  `callStatus` = '' and app_date between '$app_date' and '$curr_date' order by twillioId desc limit 1");
	}
	
	//echo "SELECT * FROM pancare_sms where number='".$number[1]."' and option = '$reminder_type' and  reply_datetime='0000-00-00 00:00:00' and datetime like '$curr_date %' order by ps_id desc limit 1";
	
	echo $no = mysql_num_rows($result);die;
	while($row = mysql_fetch_array($result))
	  {
	   $id = $row['twillioId'];
	  }
	// now greet the sender
	header("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	if($no == 1)
	{
		if($response == 'Y' || $response == 'YES')
		{
		?>
				<Response>
				<Sms>Thank you for conform your appointment. Good bye.</Sms>
				</Response>
		<?php
		mysql_query("UPDATE `twillioresponse` SET `myDigit`='1',`callStatus`='response' WHERE `mysid`='$id'");
		}
		elseif($response == 'N' || $response == 'NO')
		{
		?>
				<Response>
				<Sms>You have cancel your appintment, Please call practice office for reschedule your appointment. Good Bye.</Sms>
				</Response>
		<?php
		mysql_query("UPDATE `twillioresponse` SET `myDigit`='7',`callStatus`='response' WHERE `mysid`='$id'");
		}
		else
		{
		?>
				<Response>
				<Sms>You send wrong response, Please send correct response like yes/no.</Sms>
				</Response>
		<?php
		}
	}
	elseif($no >= 1)
	{
	?>
				<Response>
				<Sms>System find <?php echo $no;?> mobile number for appointment reminder sms, Please send reminder ID and YES/NO.</Sms>
				</Response>
	<?php
	mysql_query("UPDATE `twillioresponse` SET `myDigit`='9',`callStatus`='response' WHERE `mysid`='$id'");
	}
	else
	{
	?>
				<Response>
				<Sms>Record is not found.</Sms>
				</Response>
	<?php
	}
?>