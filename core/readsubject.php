<?php
require_once("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];

if(!empty($_POST["keyword"])) {
$query =mysql_query("SELECT * FROM tbl_school_subject WHERE subject like '" . $_POST["keyword"] . "%' and school_id='$sc_id' ORDER BY subject LIMIT 0,6");

while($row=mysql_fetch_assoc($query)) {
			$result[] = $row;
		}	
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectCountry('<?php echo $country["subject"]; ?>');"><?php echo $country["subject"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>