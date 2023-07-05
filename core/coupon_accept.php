<?php
$value=" ";
$report="";
$points="";
$product1="";
include("sponsor_header.php");
$fields=array("id"=>$id);
		   $table="tbl_sponsorer";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$name=mysql_fetch_array($results);
	$fname = $name['sp_name'];
	
	if(isset($_POST['accept']))
	{
		 $c_id = trim($_POST['name']);
		$user_type=$_POST['user_type'];
		
 if($user_type=="student")
 {
		 
		$sql1 = "select s.std_PRN, s.school_id, s.std_name, s.std_complete_name, s.std_lastname, p.sc_total_point  from  `tbl_coupons` c join `tbl_student` s on c.cp_stud_id = s.std_PRN  join `tbl_student_reward` p on p.sc_stud_id = s.std_PRN where c.cp_code = '$c_id' ";
		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		 $num1 = mysql_num_rows( $rs1 );
		
		
		
		if($num1 < 1 ){
		  	$value="Coupon not found!";
		}
		else
			{
				 $coupon_used_for = $_POST['coupon_used_for'];
				   $notes=$_POST['note'];
				   if($coupon_used_for=="select" && $notes=="")
				   {
				   $value="Enter Product or Discount or Miscellaneous";
				   }
					else
					{
						if($coupon_used_for=="select")
						{   
							
					
							$points = $_POST['points_used'];
						  $product1=$notes;
						}
						else
						{
							 $sqls="select id, Sponser_product, points_per_product from tbl_sponsored where id = $coupon_used_for";
							$arrs = mysql_query($sqls);
							$rows = mysql_fetch_array($arrs);
							$Sponser_product = $rows['Sponser_product'];
						$product1=$Sponser_product;		
							$points = $rows['points_per_product'];
					   }
					
						$quantity = 1;
						$stud_id = $_POST['id'];
						$sp_id = $_SESSION['id'];
						$issue_date = date('m/d/Y');
						
				
						$values = mysql_fetch_array($rs1);
					  	$total_points = $values['sc_total_point'];
						 $std_PRN=$values['std_PRN'];
						$school_id=$values['school_id'];
					  		$arr=mysql_query("select amount ,status ,cp_code from tbl_coupons where cp_code=$c_id");
						 	 $row=mysql_fetch_array($arr); 
							 $cp_point=$row['amount'];
					 		
					//check total points of student is enough for accept coupon
					if($cp_point>=$points)
					{
					  if($coupon_used_for=="select")
					  {
					
					 
						mysql_query($sqls);
						
							 $count=substr_count($notes,"%");
							
							if($count==1)
							{
								mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$notes','$points','$sp_id')");
								
							}
							else
							{	
								mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$notes','$points','$sp_id')");
							}
						
						}
						else
						{
						 $product1=$Sponser_product;
						 
						mysql_query("insert into tbl_accept_coupon (product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type, school_id) values('$Sponser_product','$points','$c_id','$quantity','$std_PRN','$sp_id','$issue_date','student','$school_id')");
						
						}
					
						
						
						//reduce coupon amount
						 $cp_point=$cp_point-$points;
						
						 $report="successfully accepted coupon";
						 
						/* mysql_query("update tbl_student_reward set sc_total_point='$total_points' where sc_stud_id='$stud_id'");*/
						if($cp_point==0)
							{
					$sqls="update tbl_coupons set amount='$cp_point',status='no' where cp_stud_id='$std_PRN' and cp_code='$c_id'  ";
						 mysql_query($sqls);
						 	}
							else
							{
							 $sqls="update tbl_coupons set amount='$cp_point' ,status='p' where cp_stud_id='$std_PRN' and cp_code='$c_id' ";
							 mysql_query($sqls);
						
							}
						 header("Location:coupon_accept.php?report=".$report."&name=".$c_id);
						 
					}
					else
					{
					 $value="Enough total point not available for coupons";
					}
					
					
					
				
			
			}
			
		  }
}
		
		else
		{
		
		
		
	 $sql1 = "select s.id, t_name, user_id ,balance_blue_points from  `tbl_teacher_coupon` c join `tbl_teacher` s on c.user_id = s.id  where coupon_id = '$c_id' ";
		$rs1 = mysql_query( $sql1 ) or die('Database Error: ' . mysql_error());
		 $num1 = mysql_num_rows( $rs1 );
		     if($num1 < 1 ){
		  	$value="Coupon not found!";
		}
		else
			{
				$coupon_used_for = $_POST['coupon_used_for'];
				   $notes=$_POST['note'];
				   if($coupon_used_for=="select" && $notes=="")
				   {
				   $value="Enter Product or Discount or Miscellaneous";
				   }
					else
					{
						if($coupon_used_for=="select")
						{   
							
					
							$points = $_POST['points_used'];
						   $product1=$notes;
						}
						else
						{
							 $sqls="select id, Sponser_product, points_per_product from tbl_sponsored where id = $coupon_used_for";
							$arrs = mysql_query($sqls);
							$rows = mysql_fetch_array($arrs);
							$Sponser_product = $rows['Sponser_product'];
						    $product1=$Sponser_product;		
							$points = $rows['points_per_product'];
					   }
					
						$quantity = 1;
						$stud_id = $_POST['id'];
						$sp_id = $_SESSION['id'];
						$issue_date = date('m/d/Y');
						
				
						$values = mysql_fetch_array($rs1);
					  	$total_points = $values['balance_blue_points'];
					 
					  		$arr=mysql_query("select amount ,status ,coupon_id from tbl_teacher_coupon where coupon_id='$c_id'");
						 	 $row=mysql_fetch_array($arr); 
							 $cp_point=$row['amount'];
					 		
					//check total points of student is enough for accept coupon
					if($cp_point>=$points)
					{
					  if($coupon_used_for=="select")
					  {
					  $sqls="insert into tbl_accept_coupon(product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type) values('$notes','$points','$c_id','$quantity','$stud_id','$sp_id','$issue_date','teacher')";
					 
						mysql_query($sqls);
						
							 $count=substr_count($notes,"%");
							
							if($count==1)
							{
							mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('discount','$notes','$points','$sp_id')");
								
							}
							else
							{	
							mysql_query("insert into tbl_sponsored (Sponser_type, 	Sponser_product,points_per_product,sponsor_id) values('Product','$notes','$points','$sp_id')");
							}
						
						}
						else
						{
						      $product1=$Sponser_product;
						mysql_query("insert into tbl_accept_coupon (product_name, points, coupon_id, quantity, stud_id, sponsored_id,issue_date,user_type) values('$Sponser_product','$points','$c_id','$quantity','$stud_id','$sp_id','$issue_date','teacher')");
						
						}
						
						/*//reduce student point after accept coupon
						$total_points = $total_points - $points;*/
						
						
						//reduce coupon amount
						 $cp_point=$cp_point-$points;
						
						 $report="successfully accepted coupon";
						 
						/* mysql_query("update tbl_student_reward set sc_total_point='$total_points' where sc_stud_id='$stud_id'");*/
						if($cp_point==0)
							{
				       	$sqls="update tbl_teacher_coupon set amount='$cp_point',status='used' where user_id='$stud_id' and coupon_id='$c_id'  ";
						 mysql_query($sqls);
						 	}
							else
							{
							 $sqls="update tbl_teacher_coupon set amount='$cp_point' ,status='p' where user_id='$stud_id' and coupon_id='$c_id' ";
							 mysql_query($sqls);
						
							}
							
						 header("Location:coupon_accept.php?report=".$report."&name=".$c_id);
						 
					}
					else
					{
					 $value="Enough total point not available for coupons";
					}
					
		
		
		
		
		}
		}
		
		
		
		
		}
	
	}
?>
 <?php
           	if(isset($_POST['submit']))
            {
			 	$name = trim($_REQUEST['name']);
				$user_type = $_REQUEST['user_type'];
				if($user_type=="student")
				{
				 $sql = "select s.std_PRN,s.std_Father_name,s.std_lastname,s.std_complete_name, c.amount,c.status, std_name, cp_code, s.std_school_name ,sc_list, sc_total_point,s.std_img_path from  `tbl_coupons` c join `tbl_student` s on c.cp_stud_id = s.std_PRN join `tbl_studentpointslist` a  join `tbl_student_reward` p on p.sc_stud_id = s.std_PRN where cp_code = '$name' ";
				
				
				$rs = mysql_query( $sql ) or die('Database Error: ' . mysql_error());
				$num = mysql_num_rows( $rs );
				$row = mysql_fetch_array( $rs );
				 $status= $row['status'];
					if($status=="no" ){
						$value="Coupon is fully used";
		
						}
					 if($num<1)
					 {
					    $value="Coupon number is not valid";
					 }
		
	
		$cp_id =$name;
		$cp_point= $row['amount'];
		$std_name=$row['std_name'];
		$std_lastname=$row['std_lastname'];
		$std_complete_name=$row['std_complete_name'];
		$std_Father_name=$row['std_Father_name'];
		$std_school_name=$row['std_school_name'];
		$img_path=$row['std_img_path'];
		}
			else
		{
		
		  $sql = "select s.id, c.amount,c.status,t_name, coupon_id, s.t_current_school_name ,s.t_pc from  `tbl_teacher_coupon` c join `tbl_teacher` s on c.user_id = s.id  where coupon_id = '$name' ";
				
				
				$rs = mysql_query( $sql ) or die('Database Error: ' . mysql_error());
				$num = mysql_num_rows( $rs );
				$row = mysql_fetch_array( $rs );
				 $status= $row['status'];
					if($status=="no" ){
						$value="Coupon is fully used";
		
						}
					 if($num<1)
					 {
					    $value="Coupon number is not valid";
					 }
		
	
		$cp_id =$name;
		$cp_point= $row['amount'];
		$std_name=$row['t_name'];
		$std_school_name=$row['t_current_school_name'];
		$img_path=$row['t_pc'];
		}
		
		}
		elseif(isset($_REQUEST['name']))
		{
			$name = trim($_REQUEST['name']);
			
				 $sql = "select s.std_PRN,s.std_Father_name,s.std_complete_name,s.std_lastname, c.amount,c.status, std_name, cp_code, s.std_school_name ,sc_list, sc_total_point,s.std_img_path from  `tbl_coupons` c join `tbl_student` s on c.cp_stud_id = s.std_PRN join `tbl_studentpointslist` a  join `tbl_student_reward` p on p.sc_stud_id = s.std_PRN where cp_code = '$name' ";
				
				
				$rs = mysql_query( $sql ) or die('Database Error: ' . mysql_error());
				$num = mysql_num_rows( $rs );
				$row = mysql_fetch_array( $rs );
				 $status= $row['status'];
					if($status=="no" ){
						$value="Coupon is fully used";
		
						}
					 if($num<1)
					 {
					    $value="Coupon number is not valid";
					 }
		
	
		$cp_id =$name;
		$cp_point= $row['amount'];
		$std_name=$row['std_name'];
		$std_lastname=$row['std_lastname'];
		$std_Father_name=$row['std_Father_name'];
		$std_complete_name=$row['std_complete_name'];
		$std_school_name=$row['std_school_name'];
		$img_path= $row['std_img_path'];
		}
		
	
		
          if(isset($_POST['product_name']))
			  { 
			  //retrive points per product 
			  
			  $points_per_product = mysql_query("select points_per_product from tbl_sponsored where  Sponser_product=".$_POST['product_name'] );
			}
					?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>Smartcookie :: Sponsor Coupon Accept</title>

<script>
function disablediscount()
	{

	
	var str=document.getElementById("product_name").value;
	
	 if(str!="select")
	 {
	 document.getElementById("discount_name").disabled = true;
	 }
	 else
	 {
	  document.getElementById("discount_name").disabled = false;
	 }
	 var test=str;
 		if (str=="" || str=="select")
          {
          document.getElementById("points_used").value="";
		  document.getElementById("points_used").disabled =false;
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("points_used").value=xmlhttp.responseText;
			document.getElementById("points_used").disabled = true;
            }
          }
        xmlhttp.open("GET","get_point.php?q="+str,true);
        xmlhttp.send();
		
		

}
function disableproduct()
{
		
		var str=document.getElementById("discount_name").value;
	var test=document.getElementById("discount_name").value;
	if(str!="select")
	 {
	 document.getElementById("product_name").disabled = true;
	 }
	 else
	 {
	  document.getElementById("product_name").disabled = false;
	 }
 		if (str=="" || str=="select")
          {
          document.getElementById("points_used").value="";
		   
					document.getElementById("points_used").disabled = false;
			
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            document.getElementById("points_used").value=xmlhttp.responseText;
			document.getElementById("points_used").disabled = true;
			
            }
          }
        xmlhttp.open("GET","get_point.php?q="+str,true);
        xmlhttp.send();
		
		


}

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>
</head>

<body >
<?php if(isset($_GET["report"]) && $_GET['report']=="Successfully accepted coupon." && !isset($_POST['name']))
{
          $cp_id=$_GET['name'];
		  
   $row=mysql_query("select * from tbl_accept_coupon where coupon_id='$cp_id' ORDER BY id DESC  ");
   $values=mysql_fetch_array($row);
   $cp_id=$values['coupon_id'];
  
   if($values['user_type']=='teacher')
   {
		$rows=mysql_query("select amount,t_name, t_complete_name, t_current_school_name, school_id from tbl_teacher_coupon c join tbl_teacher t on t.id=c.user_id where coupon_id='$cp_id'   ");
		$value1=mysql_fetch_array($rows);
		$cp_point=$value1['amount'];
		$std_name=$value1['t_name'];
		$std_complete_name=$value1['t_complete_name'];
		$school_id=$value1['school_id'];
		$std_school_name=$value1['t_current_school_name'];
		$std_Father_name=$value1['t_middlename'];
		$std_lastname=$value1['t_lastname'];

   }
   else
   {
  
		$rows=mysql_query("select amount,std_name,std_Father_name,std_complete_name,std_lastname,school_id, std_school_name from tbl_coupons c join tbl_student s on s.std_PRN=c.cp_stud_id where cp_code='$cp_id'   ");
		$value1=mysql_fetch_array($rows);
		$cp_point=$value1['amount'];
		$std_name=$value1['std_name'];
		$std_lastname=$value1['std_lastname'];
		$school_id=$value1['school_id'];
		$std_complete_name=$value1['std_complete_name'];
		$std_Father_name=$value1['std_Father_name'];
		$std_school_name=$value1['std_school_name'];
   }

} ?>
<style>
.row{
	padding-top:5px;
}
</style>
<div class="conatainer-fluid">
<div class="col-md-12">
<div class="row">
<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading">
		
		<h2 class="panel-title" ><b>Accept Smartcookie Coupons</b></h2>
		
	</div>
	<div class="panel-body">
		<div class="col-md-12">
		
			<div class="row">
				<span style="color:green; padding-left:10px;"><?php if(isset($_GET["report"]) && !isset($_POST['accept']) && !isset($_POST["submit"])){ echo $_GET["report"]; } if(isset($_POST['accept']) || isset($_POST['submit'])){ echo $value; } ?></span> 
			</div>
			<div class="row">
				<form name="form" method="post">
				
				<div class="col-md-4">
				
					<input type="text" name="name" class="form-control" value="<?php if(isset($_POST['submit'])||isset($_POST['accept'])){ echo $_REQUEST['name'];}?>" placeholder="Enter Coupon ID" />
				</div>
				<div class="col-md-4">
					<select name="user_type" class="form-control">
						<option value="student" 
						<?php if(isset($_POST['submit'])){ 
						$user_type = $_REQUEST['user_type']; 
						if($user_type=="student"){ echo 'selected';} 
						} ?> >Student</option>
						<option value="teacher" 
						<?php 
						if(isset($_POST['submit'])){ 
						$user_type = $_REQUEST['user_type']; 
						if($user_type=="teacher"){ echo 'selected';} 
						} ?> >Teacher</option>
					</select>
				</div>
				<div class="col-md-4">
					<input type="submit" name="submit"  value="Search" id="search-btn" class="btn btn-success" />
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-12">
				<div class="col-md-10">
						<div class="row">Coupon Code#: 
							<?php if((isset($_POST['submit']) && $value!="Coupon code is not valid" )||isset($_GET['name'])){  echo $cp_id; } ?>
						</div>
						<div class="row">Balance Points: 
							<?php if(isset($_POST['submit'])  || isset($_GET['name'])){ echo $cp_point; } ?>
						</div>
						<div class="row">Selected By: 
							<?php if(isset($_POST['submit']) || isset($_GET['name'])){ 
									if( $std_complete_name==""){
                                        echo $std_name." ".$std_Father_name." ".$std_lastname;
									}else{
                                        echo $std_complete_name;
									}
									} ?>
						</div>
						<div class="row">Institute Name: 
							<?php if(isset($_POST['submit']) || isset($_GET['name'])){ echo $std_school_name; } ?>
						</div>						
				</div>
				<div class="col-md-2">
						<div class="row">
							<?php if((isset($_POST['submit']) ||isset($_GET['name'])) && $img_path != ""){ ?>                 <img width="75" height="75" src='<?php echo $img_path;?>' style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"><?php }else{?> <img width="64" height="64" src="image/avatar_2x.png" style="border:1px solid #999999;" class="img-responsive" alt="Responsive image"><?php } ?> 
						</div>
				</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					
						<div class="row">
							<div class="col-md-2">
							Product
							</div>
							<div class="col-md-4">
								<?php
								$arr_product = mysql_query("select id, Sponser_product from tbl_sponsored where Sponser_type='Product' and sponsor_id=".$_SESSION['id'] );
								?>
							 <select name="coupon_used_for" class="form-control" id="product_name" onchange="disablediscount()">
								<option value="select" selected="selected"> Select any one</option>
								<?php
								
								while($row_product = mysql_fetch_array($arr_product))
								{
								?>
								<option value='<?php echo $row_product['id'];?>'><?php echo $row_product['Sponser_product'];?></option>
								<?php
								}
								?>
							</select>
							</div>
							<div class="col-md-2">
							Discount
							</div>
							<div class="col-md-4">
								 <?php
                                
                                            $arr_product = mysql_query("select id, Sponser_product from tbl_sponsored where Sponser_type='discount' and sponsor_id=".$_SESSION['id'] );
                                        ?>
                                    <select name="coupon_used_for" id ="discount_name" class="form-control" style="" onchange="disableproduct()">
                                        <option value="select" selected="selected"> Select any one</option>
                                        <?php
                                        
                                        while($row_product = mysql_fetch_array($arr_product))
                                        {
                                        ?>
                                        <option value='<?php echo $row_product['id'];?>'><?php echo $row_product['Sponser_product'];?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
							Miscellaneous
							</div>
							<div class="col-md-4">
								<input type="text" name="note" class="form-control" placeholder="Miscellaneous" />
							</div>
							<div class="col-md-2">
							Points Used
							</div>
							<div class="col-md-4">
								<input type="text" name="points_used" class="form-control" id="points_used"  placeholder="Point Used" />
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-md-offset-6 push-left">
								<button type='submit' name='accept' class="btn btn-success">Accept</button>
								<a href="coupon_accept.php" style="text-decoration:none;">
								<button type="button" class="btn btn-warning">Cancel</button></a>
								<?php 
                                 if(isset($_GET["report"]) && !isset($_POST['accept']) && !isset($_POST["submit"])){ 
                                 $cp_code=$_GET['name'];
                                
                                 $arrs7=    mysql_query("SELECT id,product_name FROM tbl_accept_coupon where coupon_id=$cp_code ORDER BY id DESC LIMIT 1");
                                        $record7=mysql_fetch_array($arrs7); ?> 
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="I am pleased to give <?php echo $record7['product_name'];?>  to <?php echo $std_name;?> from <?php  echo $std_school_name;?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a> <?php } ?>
							</div>
						</div>
				</div>
				</form>
			</div>
				
		</div>
	</div>
	</div>
</div>
<div class="col-md-6">
<?php 
include 'sponsor_my_coupons.php';

/* $c=mysql_query("select count(id) from tbl_selected_vendor_coupons where used_flag='unused' and sponsor_id='$_SESSION[id]' ");
$tr1 =mysql_fetch_array($c);
$tr=$tr1[0]; */

$r=mysql_query("select count(id) from tbl_selected_vendor_coupons where used_flag='used' and sponsor_id='$_SESSION[id]' ");
$r1 =mysql_fetch_array($r);
$tre=$r1[0];

$s=mysql_query("select count(id) from  tbl_accept_coupon where sponsored_id='$_SESSION[id]' ");
$s1 =mysql_fetch_array($s);
$sp=$s1[0];

?>
<div class="panel panel-default">

<ul class="list-group">
<!--
  <a class="list-group-item">
    <span class="badge"><?php echo $tr; ?></span>
    <h4>Sponsor Coupons To Be Redeemed</h4>
  </a>-->
  <a class="list-group-item" href="vendor_accepted_sponsor_coupon_log.php" >
    <span class="badge"><?php echo $tre; ?></span>
    <h4>Sponsored Coupons Redeemed</h4>
  </a>
       
    <a class="list-group-item" href="vendor_accepted_sc_coupon_log.php" >
    <span class="badge"><?php echo $sp; ?></span>
    <h4>SmartCookie Coupons Redeemed</h4>
  </a>
</ul>

</div>

</div>
</div>
</div>
</div>