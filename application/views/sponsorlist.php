<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Proud sponsor of Smartcookie</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
 <center><h1>Sponsor List<h1></center>
          
  <table id="newTable" class="table table-striped">
    <thead>
      <tr>
        <th>Sr.No</th> 
		 <th>Shop Image</th>
        <th>Shop Name</th>
        <th>Contact No</th>
        <th>Address</th>
      </tr>
    </thead>
    <tbody>
      
	  <?php 
		$i=1;
		foreach($sponsorlist as $key)
		{
			
		
		if ($key->sponaor_img_path=="")
		{
			$imagepath = "Assets/images/avatar/avatar_2x.png";
		}
		else
		{
			$imagepath= $key->sponaor_img_path;
			
		}
	  ?>
		
		<tr>
		
		<td class="<?php echo $key->id; ?>"><?php echo $i;?></td>
		<td class="<?php echo $key->id; ?>"><img src="<?php echo $imagepath ?>" height="42" width="42"></td>
        <td class="<?php echo $key->id; ?>"><?php echo $key->sp_company; ?></td>
        <td class="<?php echo $key->id; ?>"><?php echo $key->sp_phone;?></td>
        <td class="<?php echo $key->id; ?>"><?php echo $key->sp_address;?></td>
        
      </tr>
      <?php 
	  $i++;
		}
		
		?>
    </tbody>
  </table>
</div>

</body>
</html>
<script>
$(document).ready(function(){
 $("#newTable").on("click", "td", function() {
	 var sp_memb_id=this.className;
	window.open("<?php echo base_url();?>/Sponsors/proudsponsor/"+ sp_memb_id +"")
	//window.open("<?php echo base_url();?>/application/views/Sponsor_Gallary/sponsor.php")
   });
})

</script>


