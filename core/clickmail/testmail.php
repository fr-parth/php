<?php



$res = file_get_contents("http://devsmart.bpsi.us/core/clickmail/sendmail.php?msgid=2");
						if(stripos($res,"Mail sent successfully"))
						{
							
							$yes++;
							echo "yes is <b>$yes</b> and not is <b>$not</b>";
						}
						else{
							$not++;
							echo "yes is <b>$yes</b> and not is <b>$not</b>";
						}



?>