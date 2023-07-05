<?php
$con=mysqli_connect("Tsmartcookies.db.7121184.hostedresource.com","Tsmartcookies","B@v!2018297","Tsmartcookies");
var_dump($_POST);
echo $result = $_POST['university_name'];echo 'sesd';
$sql = mysqli_query($con,"Select college_name from Institution_directory where university_name like '%$result%'");
echo "<option value='$a'>Select Option</option>";
while($result_array = mysqli_fetch_array($sql)) {
	$a = $result_array['college_name'];
	
	echo "<option value='$a'>$a</option>";

    
}


?>
