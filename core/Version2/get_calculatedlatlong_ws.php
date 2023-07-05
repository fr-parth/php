<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

</body>
</html>
<?php  


    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=kothrud&sensor=false&region=$region");
    $json = json_decode($json);

    echo $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
   echo $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	
		
  ?>

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	