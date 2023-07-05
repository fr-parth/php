<html>
<body onload="loadImage()">

<?php

$firstname = $_GET['firstname'];
	$middlename=$_GET['middlename'];
	$lastname=$_GET['lastname'];
	$phonenumber=$_GET['phonenumber'];
	$emailid=$_GET['emailid'];
	$countrycode=$_GET['countrycode'];
	$usertype=$_GET['usertype'];
	$orgname=$_GET['orgname'];
	$project[]=$_GET['project'];
echo "Hello this is rest vibrant minds";

echo "
<script>
function loadImage() {
     window.open('http://tsmartcookies.bpsi.us/core/SimulteneousQuickRegisteration/auto_quick_registeration.php?firstname=".$firstname."&middlename=".$middlename."&lastname=".$phonenumber."&emailid=".$emailid."&countrycode=91&usertype=student&orgname=coep&project=smartcookie,jobsitare,ethicalhr');
}
       // window.open('http://tsmartcookies.bpsi.us/core/SimulteneousQuickRegisteration/auto_quick_registeration.php');
    </script>"
?>
</body>
</html>
