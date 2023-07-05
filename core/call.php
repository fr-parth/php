<?php
require "twilio.php";
require "TwitterOAuth.php";
$ApiVersion = "2010-04-01";
$accountSid = 'ACf8730e89208f1dfc6f741bd6546dc055';
$authToken = '45e624a756b26f8fbccb52a6a0a44ac9';
//$client = new Services_Twilio($accountSid, $authToken, $ApiVersion);
//$phonenumber = '+919579337525';
$client = new Twilio\Rest\Client($accountSid, $authToken);

// Read TwiML at this URL when a call connects (hold music)
$call = $client->calls->create(
  '9579337525', // Call this number
  '9991231234', // From a valid Twilio number
  array(
      'url' => 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient'
  )
);












try {
  $call = $client->account->calls->create(
    $phonenumber,
    '555-123-4567',
    'http://ahoy.twilio.com/voice/api/demo'
  );
  echo 'Started call: ' . $call->sid;
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}


?>