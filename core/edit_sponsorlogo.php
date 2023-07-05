<?php 

include 'sponsor_header.php';
//edit sponsor logo
function viewlogo($sp_id){
	
	$img1= mysql_query("SELECT `sp_img_path` FROM `tbl_sponsorer` WHERE `id` = $sp_id ");
	$sp=mysql_fetch_array($img1);
	$img=$sp['sp_img_path'];
	return $img;
}
$sp_id=$_SESSION['id'];
$sp="";
$path="";
?>
<img src="<?php echo viewlogo($sp_id); ?>" style="height:120px; width:210.5px;"/>
<a href="edit_sponsorlogo.php?sp=<?php echo $sp_id; ?>"> <button class="btn btn-success" >Update</button></a>


<?php 
if(isset($_GET['sp'])){
	$sp=$_GET['sp'];
	setcookie('sp',$sp, time()+3600);
	header("Location:edit_sponsorlogo.php");
} 
if(isset($_GET['usp'])){
	$usp=$_GET['usp'];
	setcookie('sp',$usp, time()-3600);
	header("Location:sponsor_profile.php");
} 

$sp=@$_COOKIE['sp'];
if($sp !="" ){

if(isset($_POST['send'])){
	include 'upload_logo.class.php';
	$size    = 300;
	$dir =   'images/uploaded_logo/';
	$newdir= 'images/resized_logo/'; 
	$img = $upload->photoUpload();
	$max_w = 208;
	$max_h = 83;
	//$max_w = 210.5;
	//$max_h = 210;
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
}			
if($sp!="" && $path!=""){ 
		
				$sql=mysql_query("UPDATE `tbl_sponsorer` SET `sp_img_path`=\"$path\" WHERE `id`=\"$sp\"");
				if($sql){
					setcookie("sp",$sp,time()-3600);
					header("Location:sponsor_profile.php");
					
				}
}


if($sp!=""){
?>

<div class="panel panel-default" style="width: 50%;">
  <div class="panel-heading"><h4>Upload Logo</h4></div>
  <div class="panel-body">  
<div class="photo-upload">
  <form action="edit_sponsorlogo.php" method="POST"  enctype="multipart/form-data">
		<input type="file" name="photo" class="form-control" value="browse" id="photo"/>
		<br/>
		<div class="row">
		<input type="submit" name="send" class="btn btn-success" value="Upload" id="post" />
		<a href="edit_sponsorlogo.php?usp=<?php echo $sp_id; ?>"><button type="button" class="btn btn-default" style="margin-top:15px;">Cancel</button></a>
		</div>
	</form>
</div>
  </div>
</div>
<?php } ?>




