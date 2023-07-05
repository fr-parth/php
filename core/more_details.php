<?php
include('conn.php');
$t_id=$_GET['t_id'];
$query="select t_complete_name,t_address,t_country,t_date_of_appointment from `tbl_teacher` where t_id='$t_id'";     
$row1=mysql_query($query);
$value1=mysql_fetch_array($row1);
$t_complete_name=$value1['t_complete_name'];
$t_address=$value1['t_address'];
$t_country=$value1['t_country'];
$t_date_of_appointment=$value1['t_date_of_appointment'];


?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>MORE DETAILS</title>
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//js/jquery-1.10.2.js"></script>
  <script src="//js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/js/style.css">
  

  <script>
  $(function() {
    $( "#dialog" ).dialog();
	<?php echo $t_complete_name;?>
  });
  </script>
</head>
<body>
 
<div id="dialog" title="Basic dialog">
  <p></p>
</div>
 
 
</body>
</html>