<?php

include("conn_to_db.php");


$sql_insert3="INSERT INTO `tbl_user_reg`(complete_name,gender,user_type,dob,email,mobile_no) VALUES ('Swapnil Ramtekkar','male','doctor','07-01-1991','pratikt@roseland.com','9579337525')";
								$count3 = mysql_query($sql_insert3) or die(mysql_error()); 
								$reports="Inserted data from Excel Sheet is not valid data";
								

?>								
