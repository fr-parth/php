<?php

set_error_handler('myErrorHandler');
register_shutdown_function('fatalErrorShutdownHandler');
				function myErrorHandler($code, $message, $file, $line) 
				{
					if (!(error_reporting() && $code))
					{
							// This error code is not included in error_reporting
					    return;
					}
					//$err_type=intl_error_name ($code);
					$Date=date("d-m-Y h:i:sa");
					$name="Pratik Tambekar";
					$emailid="pratikt@roseland.com";
					$last="Reshma Karande";
				    $error_log="INSERT INTO `tbl_error_log`(error_type,error_description,subroutine_name,line,school_id,name,email,datetime,last_programmer_name)
					VALUES ('$code','$message','$file','$line','$school_id','$name','$emailid','$Date','$last')";
					$err_count = mysql_query($error_log) or die(mysql_error());
				}
				function fatalErrorShutdownHandler()
				{
					if ($e = error_get_last())
					{
						switch($e['type'])
						{
							case E_USER_WARNING:
							myErrorHandler(E_USER_WARNING, $e['message'], $e['file'], $e['line']);
							break;
							
							case E_USER_NOTICE:
							myErrorHandler(E_USER_NOTICE, $e['message'], $e['file'], $e['line']);
							break;
							case E_ERROR:
							myErrorHandler(E_ERROR, $e['message'], $e['file'], $e['line']);
							break;
							case E_CORE_ERROR:
								myErrorHandler(E_CORE_ERROR, $e['message'], $e['file'], $e['line']);
								break;
							case E_COMPILE_ERROR:
										myErrorHandler(E_COMPILE_ERROR, $e['message'], $e['file'], $e['line']);
										break;
							case E_USER_ERROR:
									myErrorHandler(E_USER_ERROR, $e['message'], $e['file'], $e['line']);
										break;
							case E_NOTICE:
								myErrorHandler(E_NOTICE, $e['message'], $e['file'], $e['line']);
										break;
							case E_STRICT:
								myErrorHandler(E_STRICT, $e['message'], $e['file'], $e['line']);
										break;
							case E_WARNING:
							myErrorHandler(E_WARNING, $e['message'], $e['file'], $e['line']);
										break;
							case E_PARSE:
							myErrorHandler(E_PARSE, $e['message'], $e['file'], $e['line']);
										break;
							case E_USER_ERROR:
								myErrorHandler(E_USER_ERROR, $e['message'], $e['file'], $e['line']);
										break;
							case UPLOAD_ERR_INI_SIZE:
							myErrorHandler(UPLOAD_ERR_INI_SIZE, $e['message'], $e['file'], $e['line']);
													break;
							case UPLOAD_ERR_NO_FILE:
							myErrorHandler(UPLOAD_ERR_NO_FILE, $e['message'], $e['file'], $e['line']);
													break;	
							case UPLOAD_ERR_EXTENSION:
							myErrorHandler(UPLOAD_ERR_EXTENSION, $e['message'], $e['file'], $e['line']);
													break;							
							
							default:						
								myErrorHandler(E_ALL, $e['message'], $e['file'], $e['line']);
										break;
						}	
					}
				}

?>
