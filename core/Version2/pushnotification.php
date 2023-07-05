
<?php
//Sending Push Notification
   function send_push_notification($Gcm_id, $message) {
                            // Set POST variables
								$url = 'https://android.googleapis.com/gcm/send';
								
								$fields = array(
												'registration_ids'  => array($Gcm_id),
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
								
								//print_r($result);
								
								if(curl_errno($ch)){
									echo 'Curl error: ' . curl_error($ch);
								}
								// Close connection
								curl_close($ch);
   }
								
								
?>