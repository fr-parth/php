<html>
<head>
	<title>Login Page</title>

	<link href='<?php echo base_url()."/css/style.css"?>' rel="stylesheet" type="text/css">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
	
<div class="container" >
	<div class="headline"><h1 align="center">Login</h1></div>
	<?php 
	
	$hidden = array('entity' => $entity);
echo form_open('welcome/login_validation','',$hidden);
echo "<p>";
echo "<p> Username:";
echo form_input('username',$this->input->post('username'),'class="form-control"');
echo "</p>";

echo "<p> Password:";
echo form_password('password',$this->input->post('password'),'class="form-control"');
echo "</p>";

echo "<p>";
echo form_submit('login_submit', 'Login','class="btn btn-primary"');
echo "</p>";?>

<a href='#'>Sign Up</a>


<?php
echo "<span style='color:#f00;'>".validation_errors()."</span>";
echo form_close();
	?>
</div>
</body>
</html>