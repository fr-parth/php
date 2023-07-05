<?php 
$name='123';
$name1='Sudhir';
$to  = 'sudhirpatil01@gmail.com'; // note the comma
//'pioneer.designer1@gmail.com';
// subject
$subject = 'Updated Information For ID '.$name.' '.$name1;
	$dob='dob';
	$address='address';

	$street='street';
	$apt='apt';
	$city='city';
	$state='state';
	$marital_status='marital_status';
	$email='email';
	$mobile='mobile';
	$education='education';
	$occupation='occupation';
	$blood_group='b+';
	$native_place='vivare';
	$gotra='bharadwaj';
	$ref='me';
$joining_reason='just';
$url='http://tsmartcookies.bpsi.us/';
$photo='/images/whatsapp_07062015.png';
$id_proof='/images/whatsapp_07062015.png';

$message = "
<html>
<body>
  <p>Updated Information</p>
  <table align='left' border='1'>
    <tr align='left'>
      <td align='left'>ID</th><td align='left'> $name </th>
    </tr>
	 <tr align='left'>
      <td align='left'>Name</th><td align='left'> $name1 </th>
    </tr>
    <tr align='left'>
      <td align='left'>Date of Birth</th><td align='left'> $dob </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Residance Address</th><td align='left'> $address </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Street Address</th><td align='left'> $street </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Apt, Suite, Bldg. (optional)</th><td align='left'> $apt </th>
    </tr>
	     <tr align='left'>
      <td align='left'>City</th><td align='left'> $city </th>
    </tr>
	     <tr align='left'>
      <td align='left'>State</th><td align='left'> $state </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Marital Status</th><td align='left'> $marital_status </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Email Address</th><td align='left'> $email </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Mobile Number</th><td align='left'> $mobile </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Education</th><td align='left'> $education </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Occupation</th><td align='left'> $occupation </th>
    </tr>
	     <tr align='left'>
      <td align='left'>Blood Group</th><td align='left'> $blood_group </th>
    </tr>
	 <tr align='left'>
      <td align='left'>Native Place</th><td align='left'> $native_place </th>
    </tr>
		     <tr align='left'>
      <td align='left'>Gotra</th><td align='left'> $gotra </th>
    </tr>
		     <tr align='left'>
      <td align='left'>Reference</th><td align='left'> $ref </th>
    </tr>
		     <tr align='left'>
      <td align='left'>Reason to Join this club</th><td align='left'> $joining_reason </th>
    </tr>
	 <tr align='left'>
      <td align='left'>Photo</th><td align='left'> <img src='".$url.$photo."' width='200' height='200'/> </th>
    </tr>
			     <tr align='left'>
      <td align='left'>ID Proof</th><td align='left'> <img src='".$url.$id_proof."' width='400' height='200'/> </th>
    </tr>
  </table>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Brotherhood Foundations Youth Wing <sudhirp@roseland.com>' . "\r\n";

// Mail it
if(mail($to, $subject, $message, $headers)){
	echo 'done';
}else{
	echo 'error';
}

?>