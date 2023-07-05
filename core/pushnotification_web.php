
<?php

 

							
//Sending Push Notification
  // function send_push_notification($Gcm_id, $message) {
                            // Set POST variables
							$Gcm_id="APA91bGq2vzXxGXjTnBJxWTXaO2qQ-WQxD6BlmfWnNJkMTi6R4yTz7P2R9rIGPjdwAMRNbPTveEO9cphmc12Y0NUJjqDnKfBTi2AVEdKOyWzZpo8rJ0gpXojTlWzTj3sbbdGiHDD8KSLZWUTlGJ_ZtOWwyLJf6mHrA";
							$message="hii";
								$url = 'https://android.googleapis.com/gcm/send';
								
								$fields = array(
												'registration_ids'  => array($Gcm_id),
												'data'              => array("msg"=>$message ),
												);
								
								 $headers = array( 
													'Authorization: key=AIzaSyDHNNZmCBQHAA_So2n35iLG0_l7miJgiOA',
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
								
								echo $result;
								// Close connection
								curl_close($ch);
								//if(curl_errno($ch)){
								//	echo 'Curl error: ' . curl_error($ch);
								//}
								
  // }
								
								
?>