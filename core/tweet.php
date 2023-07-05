<?php

// Include twitteroauth
require_once('TwitterOAuth.php');

// Set keys
$consumerKey = 'KPrkpIvW8XJ8s8lPPtit08PMn';
$consumerSecret = 'fifWMJ3DDwUIoagSt98URRULOCdeP63FwIiRTM6HTIaqISchnl';
$accessToken = '2889659868-DMiWrG3kytw10Azv5OZaLgXCOzMRBXW2Uoy1rQZ';
$accessTokenSecret = 'GYzkQOVdED0m6AxH3cFiXDbPgg3YfSMVzXnbtsbCFFVRN';

// Create object
$tweet = new twitteroauth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Set status message
$tweetMessage = 'This is a tweet to my Twitter account via PHP.';

// Check for 140 characters
if(strlen($tweetMessage) <= 140)
{
    // Post the status message
 $tweet->post('statuses/update', array('status' => $tweetMessage));
 echo "hi";
}

?>