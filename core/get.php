<?php
/* header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Tables_fields_".date("Ymd")."_SP.xls"); */

$result = mysql_query("SHOW TABLES FROM Tsmartcookies")or die(mysql_error()); 
echo "<table>
<tr><th>#</td><th>Table Name</th><th>Fields</th></tr>";
$sr=1;
while($r=mysql_fetch_array($result)){
	$table=$r['Tables_in_Tsmartcookies'];
	$f=mysql_query("SHOW COLUMNS FROM ".$table)or die(mysql_error()); 
	echo "<tr><td>$sr</td><td>$table</td><td></td></tr>";
	$sr1=1;
	while($fld=mysql_fetch_array($f)){
		$field=$fld['Field'];
		echo "<tr><td></td><td>$sr1</td><td>$field</td></tr>";
		$sr1++;
	}
	$sr++;
}
echo "</table>";