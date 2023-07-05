<?php
//sponsor_my_coupons.php
//include 'sponsor_header.php';
$msg=0;
$coupons=0;

//header("Location:".htmlspecialchars($_SERVER['PHP_SELF']));
//link <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?rd=1" class="btn btn-default btn-sm">Reset</a><br/>

if(isset($_POST['submit_my_coupon'])){
	if(!empty($_POST['code'])){
		$code=$_POST['code'];
$get_my_coupon=mysql_query("SELECT * FROM tbl_selected_vendor_coupons WHERE `code`=\"$code\" and sponsor_id='$id' ORDER BY `id` ASC "); 
		$cpns_with_unique_code=mysql_num_rows($get_my_coupon);
		if($cpns_with_unique_code == 1 ){		
				$my_coupons= mysql_fetch_array($get_my_coupon);
				$selected_cp_id=$my_coupons['id'];
				$cp_holder_entity=$my_coupons['entity_id'];
				$cp_holder_user_id=$my_coupons['user_id'];
				$coupon_id=$my_coupons['coupon_id'];
				$for_points=$my_coupons['for_points'];
				$timestamp=$my_coupons['timestamp'];
				$code=$my_coupons['code'];
				$used_flag=$my_coupons['used_flag'];
				$valid_until=$my_coupons['valid_until'];

				
				if($used_flag=="used"){ $msg="Already Redeemed"; }
				$current_time=time(); 
					
				if($cp_holder_entity==3){ 
				$stud=mysql_query("SELECT std_name, std_school_name, std_img_path,school_id, std_email, std_gender FROM tbl_student WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($stud);
					$name=$userinfo['std_name'];
					$school=$userinfo['std_school_name'];
					$img=$userinfo['std_img_path'];
					$gender=$userinfo['std_gender'];
					$school_id=$userinfo['school_id'];			
					
				}
				
				if($cp_holder_entity==2){ 
				$teacher=mysql_query("SELECT t_name, t_current_school_name,school_id, t_pc, t_email, t_gender FROM tbl_teacher WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($teacher);
					$name=$userinfo['t_name'];
					$school=$userinfo['t_current_school_name'];
					$img=$userinfo['t_pc'];
					$gender=$userinfo['t_gender'];
					$school_id=$userinfo['school_id'];
				}
				
				
				
		}elseif( $cpns_with_unique_code > 1){
			
			
		}		
		else{$msg="Coupon Not Found!";}		
		
	}else{ $msg="Please! Enter Coupon Code Above.";}	
}
if(isset($_POST['confirm'])){
		$selected_cp_id=$_POST['selected_cp_id'];
	$selected_school_id=$_POST['selected_school_id'];
$accepted=mysql_query("UPDATE tbl_selected_vendor_coupons 
	SET `used_flag`='used', `school_id`='$selected_school_id' WHERE `id`='$selected_cp_id' ")or die(mysql_query()) ;
if($accepted){
	$msg='Accepted';
}
}

 /* if(isset($_POST['submit'])){ echo $m; } 
 if(isset($_POST['submit'])){ echo $d; } 
 if(isset($_POST['submit'])){ echo $y; } */ ?>
<script>
$(document).ready(function(){
    $('#userTable').DataTable( {
		"pageLength": 3
	} );
});
</script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<div class="">


<div class="panel panel-default"  style="">
 <div class="panel-heading">
    <h2 class="panel-title"><b>Accept Sponsor Coupons</b></h2>
  </div>
  <div class="panel-body">
		
   <form class="navbar-form navbar-left" role="search" method="post"> 
        <div class="col-md-12">
		<div class="col-md-4">	
		Enter Coupon Code:
		</div>
		<div class="col-md-8">		
		<div class="input-group">
      <input type="text" class="form-control" placeholder="Search" name="code" id="code" />
      <span class="input-group-btn">
        <button class="btn btn-success" id="submit_my_coupon" name="submit_my_coupon" onclick="myFunction()" type="submit">Go!</button>
      </span>
		</div>
		</div>
		
      </div></form>
  </div>
  
    <?php if($msg){ ?><div class="alert alert-warning" role="alert"><?php echo $msg;?></div><?php }else{ ?>
	
	 <?php  
	 if(isset($_POST['submit_my_coupon'])){ ?>
	 <div class="panel panel-default" align="center">
  <div class="panel-body" >
<?php	 if($cpns_with_unique_code > 1 ){	
	 ?>
	 <table class="table" id="userTable">
	 <!--<tr><th>#</th><th>Coupon Code#</th><th>Coupon ID</th><th>Issued To</th><th>Institute Name</th><th>Generated On</th><th>Valid Until</th><td></td></tr>-->
	 <thead><tr><th>#</th><th>Image</th><th>Coupon </th><td></td></tr></thead><tbody>
	 <?php 
	
	 $sr=1;
		while($my_coupons=mysql_fetch_array($get_my_coupon)){
				$selected_cp_id=$my_coupons['id'];
				$cp_holder_entity=$my_coupons['entity_id'];
				$cp_holder_user_id=$my_coupons['user_id'];
				$coupon_id=$my_coupons['coupon_id'];
				$for_points=$my_coupons['for_points'];
				$timestamp=$my_coupons['timestamp'];
				$code=$my_coupons['code'];
				$used_flag=$my_coupons['used_flag'];
				$valid_until=$my_coupons['valid_until'];
				
				if($used_flag=="used"){ $msg="Already Redeemed"; }
				$current_time=time(); //$current_time > $valid_until
				//if($current_time > $valid_until){ $msg="Coupon Expired."; }
					
				if($cp_holder_entity== 3){ 
$stud=mysql_query("SELECT std_name, std_school_name, std_img_path, school_id, std_email, std_gender FROM tbl_student WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($stud);
					$name=$userinfo['std_name'];
					$school=$userinfo['std_school_name'];
					$img=$userinfo['std_img_path'];
					$gender=$userinfo['std_gender'];
					$school_id=$userinfo['school_id'];
								
					
				}
				
				if($cp_holder_entity==2){ 
				$teacher=mysql_query("SELECT t_name, t_current_school_name, school_id, t_pc, t_email, t_gender FROM tbl_teacher WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($teacher);
					$name=$userinfo['t_name'];
					$school=$userinfo['t_current_school_name'];
					$img=$userinfo['t_pc'];
					$gender=$userinfo['t_gender'];
					$school_id=$userinfo['school_id'];
				}
				
	 if($used_flag != "used"){ ?>
	  <tr>
	  
	  <td><?php echo $sr; ?></td>
	  <td><?php if(file_exists($img)){ ?>
		<img src="<?php echo $img; ?>" width="64px" height="64px" />
		<?php } else { ?>
		<img src="image/avatar_2x.png" width="64px" height="64px" />
		<?php } ?></td>
	  <td><?php echo 'Code# '.$code; ?><br/>
	  <?php echo 'Coupon ID '.$selected_cp_id; ?><br/>
	  <?php echo 'Selected To '.$name." (".$gender.")"; ?><br/>
	  <?php echo 'Institute '.$school; ?><br/>
	  <?php echo 'Selected On '.$timestamp; ?><br/>
	  <?php echo 'Valid Until '.$valid_until; ?></td>
	  <td>
	
	  <form method="post" action="#">
	 <input type="hidden" value="<?php echo $selected_cp_id; ?>" name="selected_cp_id" id="selected_cp_id">
	  <input type="hidden" value="<?php echo $school_id; ?>" name="selected_school_id" id="selected_school_id" >
	 <button class="btn btn-success" name="confirm" id="confirm">Accept</button>
	 </form>	  
	 </td></tr><?php } ?>
		<?php $sr++; } ?></tbody></table><?php }else{  
		if(file_exists($img)){ ?>
		<div class="row"><img src="<?php echo $img; ?>" width="64px" height="64px" /></div>
		<?php } else { ?>
		<div class="row"><img src="image/avatar_2x.png" width="64px" height="64px" /></div>
		<?php } ?>
		
	    <div class="row">Coupon Code#: <?php echo $code; ?></div>
	    <div class="row">Selected By: <?php echo $name." (".$gender.")"; ?></div>
	    <div class="row">Institute Name: <?php echo $school; ?></div>
		<div class="row">Selected On: <?php echo $timestamp; ?></div>
		<div class="row">Valid Until: <?php echo $valid_until; ?></div>
		   
	 <form method="post" action="#">
	 <input type="hidden" value="<?php echo $selected_cp_id; ?>" name="selected_cp_id" id="selected_cp_id" >
	 <input type="hidden" value="<?php echo $school_id; ?>" name="selected_school_id" id="selected_school_id" >
	 <br/>
	 <div class="row">
	 <button class="btn btn-success" name="confirm" id="confirm">Accept</button>
	 </div></form>
	 
	 
	 <?php } ?>  </div>
</div> <?php } } 
	 ?>
	
  
 
</div>
</div>
