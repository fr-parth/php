<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>

document.getElementById("text").innerHTML=xmlhttp.responseText;
</script>

</head>

<body>
<?php
$phone='9922449794';
$password='1233';
$url1="+Please+visit+www.smartcookie.in";
$Text="Success,+you+are+Registered+with+smartcookies+your+UserID+is+".$phone."+%26+Pswd+is+".$password."+.".$url1."+for+more+details.";//$url="http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=ashishd&passwd=Passion@2015&mobilenumber=9922449794&message=$Text&sid=SMCOOKIE&mtype=N&DR=Y&SMS_Job_NO";
//echo $response=file_get_contents($url); 
echo $response='OK : 4635242';
echo "<hr />";

//for checking out balance
$bal="http://api.smscountry.com/SMSCwebservice_User_GetBal.asp?User=ashishd&passwd=Passion@2015";
$acc_bal=file_get_contents($bal);


$resp = explode( ':',$response);
print_r($resp);
echo "<hr />";
echo $resp[1];
?>
Your SMSCountry Account Balance is <?php echo $acc_bal;?>.

Your SMS Job Number is<?php echo $resp[1];?>.

 <?
echo "<hr />";
//delivery reports
$delivery="http://api.smscountry.com/smscwebservices_bulk_reports.aspx?user=ashishd&passwd=Passion@2015&fromdate=06/23/2015+00:00:00+&todate=06/24/2015+23:59:59";
echo $delivery_status=file_get_contents($delivery);






*/
?>
</body>
</html>
