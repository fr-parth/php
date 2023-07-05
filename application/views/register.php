<html>
<head>
	<title>Login Page</title>
</head>
<body>
	<h1>Login</h1>

	<?php 
echo form_open('main/register_validation');

echo validation_errors();

echo "<p>Username: ";
echo form_input('username',$this->input->post('username'));
echo "</p>";

echo "<p>Password";
echo form_password('password');
echo "</p>";

echo "<p>Confirm Password";
echo form_password('cpassword');
echo "</p>";


echo "<p>";
echo form_submit('login_submit', 'Login');
echo "</p>";



echo form_close();
	?>

</body>
</html>