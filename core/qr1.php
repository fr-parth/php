<?php


echo $output=$_POST['fname'];

echo "<img src='qr_img.php?d=$output'>";

?>

<html>
<body>
<form action="" method="POST">
  Enter Value: <input type="text" name="fname"><br>

  <input type="submit" value="Submit">
 
</form>

</body>
</html>