<?php
include("cookieadminheader.php");
$id = $_GET['id'];

$conn = mysql_connect("localhost","root","");
$db = mysql_select_db("smartcookie");
?>
<script>
var value = window.confirm('Do you want to delete this record');
if(value)
{
<?php
$query="delete from DTE_college_list where id='$id'";
mysql_query($query);

?>
}
else
{
window.location.assign('college_list_DTE.php');
}
</script>


