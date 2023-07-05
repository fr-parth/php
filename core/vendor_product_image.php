<?php
@include 'conn.php';

$user_id=$_SESSION['id'];
$entity=$_SESSION['entity'];
$del_earlier=mysql_query("DELETE FROM `tbl_sponsored` WHERE `Sponser_product` is null");

$path="";	
	$insert_id=0;
	if(isset($_GET['up'])){ 
		$up=$_GET['up'];
		setcookie("up",$up,time()+3600);
	}else{
		$up=0;
	}
if(isset($_POST['send'])){
	include 'upload_product_image.class.php';
	$size    = 300;
/* 	$dir =   'uploaded_logo/';
	$newdir= 'resized_logo/'; */
	$dir =   'images/uploaded_product_image/';
	$newdir= 'images/resized_product_image/';
	$img = $upload->photoUpload();
	//$max_w = 210.5;
	//$max_h = 120;
	$max_w = 208;
	$max_h = 140;
	$th_w = 100;
	$th_h = 100;
	$upload->resizejpeg($dir, $newdir, $img, $max_w, $max_h, $th_w, $th_h);

		
	$path1=$newdir.$img;
	if(file_exists($path1)){
		$path=$path1;
	}else{
		$path=$dir.$img;
	}
	
}			
	
		$up=@$_COOKIE['up'];		
		if($up!=0 && $path!=""){ 
		
				$sql=mysql_query("UPDATE `tbl_sponsored` SET `product_image`=\"$path\" WHERE `id`=\"$up\"");
				if($sql){
					setcookie("up",$up,time()-3600);
					header("Location:vendor_coupon_setup.php?up=".$up);
					
				}
		}elseif($up==0 && $path!=""){		
	
$insert=mysql_query("INSERT INTO `tbl_sponsored` (`id`,`valid_no_of_student`, `validity`, `sponsor_id`, `product_image`) VALUES (NULL, \"0\", 'valid', \"$user_id\", \"$path\")");
/* $insert=mysql_query("INSERT INTO `tbl_sponsored` (`id`, `Sponser_type`, `Sponser_product`, `school_id`, `points_per_product`, `sponsered_date`, `valid_no_of_student`, `validity`, `sponsor_id`, `product_image`, `valid_until`, `category`, `product_price`, `discount`, `buy`, `get`, `saving`, `offer_description`, `daily_limit`, `total_coupons`, `priority`, `coupon_code_ifunique`, `currency`, `daily_counter`,`reset_date`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, \"0\", 'valid', \"$user_id\", \"$path\", NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)"); */
						$insert_id=mysql_insert_id();
				
							
					if($insert_id!=0){

						header("Location:vendor_coupon_setup.php?im=".$insert_id);	

					}	
			}

/*   echo '<br />';
  echo '<div class="thumb">';
		$thumb=$upload->dumpPhoto($img,$newdir,0);
	echo '</div>' */

?>

<!DOCTYPE HTML>
<html>
<head>
<script src="js/jquery.min.js"></script>
<style>
.thumb{border:2px dotted #eee;padding:3px;width:100px;}.thumb:hover{border:2px dotted gray;}
</style>
<link href="bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="panel panel-default" style="width: 50%;">
  <div class="panel-heading"><h4>Upload Product Image</h4></div>
  <div class="panel-body">
<div class="photo-upload">
  <form action="vendor_product_image.php" method="POST"  enctype="multipart/form-data">
		<input type="file" name="photo" class="form-control" value="browse" id="photo"/>
		<br/>
		<div class="row">
		<input type="submit" name="send" class="btn btn-success" value="Upload" id="post" />
		<a href="vendor_coupon_setup.php?im=skipped<?php if(isset($_GET['up'])){ echo '&up='.$_GET['up'];}?>"><button type="button" class="btn btn-default" style="margin-top:15px;">Skip it! </button></a>
		</div>
	</form>
</div>
  </div>
</div>

</body>
</html>