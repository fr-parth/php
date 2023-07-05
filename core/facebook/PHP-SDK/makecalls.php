<?php
//session_start();
$number='9735512095';
//$_SESSION['meid']=$_POST['me_id'];
require "twilio.php";

/* Twilio REST API version */
$ApiVersion = "2008-08-01";

/* Set our AccountSid and AuthToken */
/*$AccountSid = "ACa921fadc433d1c1e57b5c9a5bb0c1fcf";
$AuthToken = "e9744aa4ca656cbf4060fff6a73c7502";
*/
$AccountSid = "ACf18c09b41ab29ceb4683917d044fdfdd";
$AuthToken = "e069a9049d1243932efb717b3ed3ac87";

// @start snippet
/* Create an Array of people to be called */
$people = array(
	0 => "".trim($number," ")."",
	//0 => "973-568-0605",
	//1 => "973-486-9642"//,
	//2 => "415-555-3456"
);
// @end snippet
// @start snippet
/* Create a FOR loop that will call each person in the people array */
for($i = 0; $i < count($people); $i++) {

   	/* Instantiate a new Twilio Rest Client */
   	$client = new TwilioRestClient($AccountSid, $AuthToken);

	/* Create a variable for the number you wish to dial */
	$Called = $people[$i];
	$data = array(
		"Caller" => "973-775-9743",	// Outgoing Caller ID
		"Called" => $Called,		// The phone number you wish to dial
		"Url" => "http://ivr.blueplanetsolutions.com/doctor.php"
	);
	//print_r($data);
	$uri = "/{$ApiVersion}/Accounts/{$AccountSid}/Calls";
	$response = $client->request($uri, "POST", $data);
	// check response for success or error
	if($response->IsError)
	{
   		echo "Error starting phone call: {$response->ErrorMessage}\n";
		?>
		 <script type="text/javascript">
		alert("Error Initiating IVR Call<?php if($_GET['number']!=""){?> to<?php echo $_GET['number']; }?>, Please Try Again");
		</script>
		<?php	
	}
	else
	{
   		echo "Started call: {$response->ResponseXml->Call->Sid}\n";
	?>
    <script type="text/javascript">
	alert("IVR Call Initiated to <?php echo $_GET['number'];?>");
	</script>
    <?php 
	}
}

// @end snippet
