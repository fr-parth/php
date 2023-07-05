<?php include("conn.php");
$user=$_GET['user'];

$user;

?>

<html>
<body>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>

$(document).ready(function(){
    $('#ggTable').DataTable( {
		"pageLength": 6
	} );
});
</script>

</head>

<div class="col-md-12">
<?php //include 'discount_setup.php';?>
<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><b><?=$user;?></b> 
			<?php
				if($user !='Student' && $user != 'Parent' && $user != 'Teacher')
				{
			?>
				<a href="delete_soft.php?userid=<?php echo $user;?>"><img src="http://purlinbrackets.com.au/Prod/Order/prod_img/delete.png" alt="delete" width="20" height="20"></a>
			<?php
				}
			?>
			</h2>
		</div>
		<div class="panel-body">
		
        
			<div class="row">
			<div class="col-md-12">
				<div class="row">
				<table class="table" id="ggTable">
					<thead>
						<tr><th>No</th><th>Name</th><th>SoftRewards</th><th>Points</th><th>Edit</th><th>Delete</th></tr>
					</thead>
					<tbody>
						<?php
                            $i=0;
							
							
							$teacher=mysql_query("SELECT `softrewardId`,`user`,`rewardType`,`fromRange`,`imagepath` FROM `softreward` WHERE `user`='$user'");
					             while($result=mysql_fetch_array($teacher))
							      {
										$softid=$result['softrewardId'];// db row id
										$user=$result['user'];  
										$star=$result['fromRange'];// for points
										$rewardtype=$result['rewardType']; // star trophy 
										$imagespath=$result['imagepath']; // reward image
									$i++;
						?>
						<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $rewardtype;?></td>
						<td ><img src="<?php echo $imagespath ?>" name="star" height="75" width="75" class="img-responsive" ></td>
						<td><?php echo $star;?></td>
						<td>										
	<a onClick="edit_discount('<?php echo $softid; ?>','<?php echo $rewardtype; ?>','<?php echo $star; ?>','<?php echo $user; ?>','<?php echo $imagespath; ?>');myFunction()" >
						<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
						<td>
							<a href="delete_soft.php?softid=<?php echo $softid;?>"><img src="http://purlinbrackets.com.au/Prod/Order/prod_img/delete.png" alt="delete" width="20" height="20"></a>
						</td>
						<!--
<td><a onClick="confirmation('<?php // echo $row['id'];?>','<?php // echo $row['Sponser_product'];?>')"  >
						<span class="glyphicon glyphicon-trash"></span></a></td>-->
						</tr>
						<?php  } ?>
					</tbody>
				</table>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
</div>

</div>
</div>
</body></html>