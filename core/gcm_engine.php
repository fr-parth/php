<?php
// Message to be sent
 $message = 'hiii';

// Set POST variables
$url = 'https://android.googleapis.com/gcm/send';

$fields = array(
                'registration_ids'  => array('APA91bFLSsPxHoH2dzjX02wIBUr6WhmGLVEAhvJqYSqDBUe0r9s88EiEQWUxoc7k0BVVKJC-rOTyXDdhnvaraOdl5etbylofj1Yvs6MDGGfqoBU63BGjntb-5nmCsbnRG9MR6bHoJMgB'),
                'data'              => array("msg"=>$message ),
                );

 $headers = array( 
                    'Authorization: key=AIzaSyCKGaMHwFrtX-av-5qTeNsDIUltZnQpYOk',
                    'Content-Type: application/json'
                );

// Open connection
$ch = curl_init();

// Set the url, number of POST vars, POST data
curl_setopt( $ch, CURLOPT_URL, $url );

curl_setopt( $ch, CURLOPT_POST, true );
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

// Execute post
$result = curl_exec($ch);


// Close connection
curl_close($ch);
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}

echo $result;


?>