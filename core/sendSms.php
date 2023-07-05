<?php

	if(!function_exists('stripos'))
	{
		function stripos($haystack, $needle, $offset = 0)
		{
			return strpos(strtolower($haystack), strtolower($needle), $offset);
		}
	}

	if ( isset($_GET['uid']) && isset($_GET['pwd']) && isset($_GET['phone']) && isset($_GET['msg']) )
	{
		echo sendSMSToMany($_GET['uid'], $_GET['pwd'], $_GET['phone'], $_GET['msg']);
		exit;
	}
	else if ( isset($_POST['uid']) && isset($_POST['pwd']) && isset($_POST['phone']) && isset($_POST['msg']) )
	{
		echo sendSMSToMany($_POST['uid'], $_POST['pwd'], $_POST['phone'], $_POST['msg']);
		exit;
	}

	function sendSMSToMany($uid, $pwd, $phone, $msg)
	{
		$curl = curl_init();
		$timeout = 30;
		$ret = "";

		$uid = urlencode($uid);
		$pwd = urlencode($pwd);

		curl_setopt ($curl, CURLOPT_URL, "http://www1.way2sms.com/auth.cl");
		curl_setopt ($curl, CURLOPT_POST, 1);
		curl_setopt ($curl, CURLOPT_POSTFIELDS, "username=" . $uid . "&password=" . $pwd);
		curl_setopt ($curl, CURLOPT_COOKIESESSION, 1);
		curl_setopt ($curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
		curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($curl, CURLOPT_MAXREDIRS, 20);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
		curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt ($curl, CURLOPT_REFERER, "http://www1.way2sms.com/");
		$text = curl_exec($curl);

		// Check for proper login
		$pos = stripos(curl_getinfo($curl, CURLINFO_EFFECTIVE_URL), "main.jsp");
		if ($pos === "FALSE" || $pos == 0 || $pos == "")
			return "invalid login";

		if (trim($msg) == "" || strlen($msg) == 0) return "invalid message";
		$msg = urlencode($msg);
		$pharr = explode(";", $phone);
		$refurl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
		curl_setopt ($curl, CURLOPT_REFERER, $refurl);
		curl_setopt ($curl, CURLOPT_URL, "http://www1.way2sms.com/jsp/InstantSMS.jsp?val=0");
		$text = curl_exec($curl);

		foreach ($pharr as $p)
		{
			if (strlen($p) != 10 || !is_numeric($p) || strpos($p, ".") != false)
			{
				$ret .= "invalid number;" . $p . "\n";
				continue;
			}
			
			$p = urlencode($p);

			// Send SMS
			curl_setopt ($curl, CURLOPT_URL, "http://www1.way2sms.com/FirstServletsms?custid=");
			curl_setopt ($curl, CURLOPT_REFERER, curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
			curl_setopt ($curl, CURLOPT_POST, 1);
			curl_setopt ($curl, CURLOPT_POSTFIELDS, "custid=undefined&HiddenAction=instantsms&Action=custfrom50000&login=&pass=&MobNo=" . $p . "&textArea=" . $msg . "&qlogin1=Gmail+Id&qpass1=******&gincheck=on&ylogin1=Yahoo+Id&ypass1=******&yincheck=on");
			$text = curl_exec($curl);
		}

		// Logout :P
		curl_setopt ($curl, CURLOPT_URL, "http://www1.way2sms.com/jsp/logout.jsp");
		curl_setopt ($curl, CURLOPT_REFERER, $refurl);
		$text = curl_exec($curl);	

		curl_close($curl);
		return "done\n" . $ret;
	}
	
	if ( file_exists("nusoap/nusoap.php") ) {
		require ("nusoap/nusoap.php");
		if ( !class_exists("soap_server") ) {
			printUsage();
		}
	} else {
		printUsage();
	}
	
	$server = new soap_server();
	$server->configureWSDL('SendSMS','urn:sms');
	$server->register("sendSMSToMany", 
					  array('uid' => 'xsd:string', 'pwd' => 'xsd:string', 'phone' => 'xsd:string', 'msg' => 'xsd:string'),
					  array('status' => 'xsd:string'),
					  'urn:SendSMSToMany', 'urn:sms#SendSMSToMany', 'rpc', 'encoded', 
					  'Sends the same SMS to multiple phone numbers. Give your 10 digit phone number for user ID. Separate each phone number with a semicolon(\';\').');
	$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
	$server->service($HTTP_RAW_POST_DATA);

	function printUsage() {
		$nl = "\r\n";
		echo "invalid_request" . $nl;
		echo "Usage: Refer to  for more informaiton." . $nl;
		exit;
	}

?>
<html>
<body>



<form method=”post” action=”sendSms.php“>
<input type=”hidden” name=”uid” value=”9579337525″ />
<input type=”hidden” name=”pwd” value=”pratik” />
<input type=”hidden” name=”phone” value=”9922449794;9890643987″ />
<input type=”hidden” name=”msg” value=”Hello World” />
<input type=”submit” value=”Send SMS” />
</form>

</body>
</html>