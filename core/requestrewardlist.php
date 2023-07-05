
<?php include_once('header.php');

if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 $id=$_SESSION['id'];
	 
	 $query = mysql_query("select school_id,t_id,tc_balance_point from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];

$t_id=$value['t_id'];
$reward_points=$value['tc_balance_point'];

	 $report="";
	 $report1="";
	
	

	 if(isset($_POST['submit']))
	 {
	
	$points=$_POST['points'];
	$reason=$_POST['reason'];
	$student_id=$_POST['student_id'];
	$requestdate=$_POST['requestdate'];
	
	$accept_date=Date('d/m/Y');
	
	
	if($reward_points >= $points)
	{
	      $final_points=$reward_points-$points;
		  $test=mysql_query("update tbl_teacher set tc_balance_point='$final_points' where t_id='$t_id'");
		 
		 $arr=mysql_query("select * from tbl_student_reward where sc_stud_id='$student_id' ");
		 $arr1=mysql_fetch_array($arr);
		 
		  
		  $sc_final_point=$arr1['sc_total_point']+$points;
		$sql1=mysql_query("update tbl_student_reward set sc_total_point='$sc_final_point' where sc_stud_id='$student_id'");
			
			$sql2=mysql_query("update tbl_request set flag='Y' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and flag='N' and reason like '$reason'");
			
		$sql3=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('103','$points','$t_id','$student_id','$reason','$accept_date')");
		
		$report="Request successfully accepted";
	
header('Location: requestrewardlist.php?report='.$report); 
	
	}
	else
	{
     $report="Points are insufficient ";
	}
	
	
	
	 }
	 
	 if(isset($_POST['decline']))
	 {
		$points=$_POST['points'];
	$reason=$_POST['reason'];
	$student_id=$_POST['student_id'];
	$requestdate=$_POST['requestdate'];
	
	$accept_date=Date('d/m/Y');
	
	
	$sql2=mysql_query("update tbl_request set flag='P' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and flag='N' and reason like '$reason'");
	
//echo "update tbl_request set flag='P' where stud_id1='$student_id' and stud_id2='$id' and entitity_id='105' and flag='N' and reason like '$reason'";die;
	
	
	 }
	 
	
	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Request List</title>
<style>
.preview
{
border-radius:50% 50% 50% 50%;  
height:100px;
box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}

.btn
{
padding: 5px 20px;
}
</style>
</head>

<body style="background-color:#FFFFFF;">
<div class="container">
<?php 
 $arr1=mysql_query("select stud_id1,requestdate,points,reason from tbl_request where stud_id2='$t_id' and flag='N' and entitity_id='103'");

 if(mysql_num_rows($arr1)!=0 && !isset($_GET['report']) )
 { 
  $query1 = mysql_query("select tc_balance_point from tbl_teacher where t_id = '$t_id'");
	 $st_points1 = mysql_fetch_array($query1);
	
	$reward_points1=$st_points1['tc_balance_point'];

 ?>
<center><h3 style="padding-top:20px;">Requests for Reward Points</h3></center>
  <?php
	while($post = mysql_fetch_assoc($arr1))
	{
	 $st_id=$post['stud_id1'];
	
	 	$sql=mysql_query("select std_name,std_complete_name,std_Father_name,std_lastname,std_img_path from tbl_student where std_PRN='$st_id'");
		$value=mysql_fetch_array($sql);
	 ?>
	 
	
 <div class="container" >  

 <div class="row" style="padding-top:20px;">
 <div class="col-md-2"></div>
<div class="col-md-8"  style="padding:20px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">	
         <form method="post">    
             <div class="row">
            <div class="col-md-3">
            <?php if($value['std_img_path'] != ''){?>
                <img src="<?php echo $value['std_img_path'];?>" style="height:60;width:60;" class="preview">
                <?php }else {?> <img src="image/avatar_2x.png" width="50" height="50" style="border:1px solid #CCCCCC;" class="preview" alt="Responsive image"/> <?php }?></div>
                <div class="col-md-3">
                <b><?php if($value['std_complete_name']!="")
				{
				echo $value['std_complete_name'];
				}
				else
				{
				echo $value['std_name']." ".$value['std_Father_name']." ".$value['std_lastname'];
				}
				
				?></b>
                </div>
                 <div class="col-md-2"><b>Reason:</b></div>
              <div class="col-md-4"><input type="hidden" name="reason" id="reason" value="<?php echo $post['reason']?>" /><?php echo $post['reason']?></div> 
              
               <div class="col-md-2" style="padding-top:10px;"><b>Points:</b></div>
              <div class="col-md-3" style="padding-top:10px;"> <input type="hidden" name="points" id="points" value="<?php echo $post['points']?>" /><?php echo $post['points']?></div> 
              <div class="col-md-7">  <input type="hidden" name="student_id" id="student_id" value="<?php echo $st_id?>" /></div>
               <div class="col-md-3" style="padding-top:10px;"><b>Request Date:</b></div>
                <div class="col-md-2" style="padding-top:10px;"> <input type="hidden" name="requestdate" id="requestdate" value="<?php echo $post['requestdate']?>" /><?php echo $post['requestdate']?></div>
              <div class="col-md-2" style="padding-top:40px;"><input type="submit" name="submit" value="Accept" class="btn btn-primary"></div>
               <div class="col-md-2" style="padding-top:40px;"><input type="submit" name="decline" value="Decline" class="btn btn-danger"></div>
             </div>
             
        
             </div>
             </div>
			 </div>
               
             
               
			 </form>
			 <?php }?>
			  <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" id="errorreport"><?php echo $report;?></div>
			 <?php }
			
			 
			 if(isset($_GET['report']))
			 {?>
			  <div class="container" style="padding-top:150px;">
 <div class="row">
 <div class="col-md-3"></div>
 
 <div class="col-md-6"  style=" border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#FFFFFF;color:#FF0000; font-weight:bold;" align="center" >
  <div style="height:20px;"></div>
 <?php
 $report="Request successfully accepted";
  echo $report;  ?>
 <div style="height:20px;"></div>
 <div class="row">
 <div class="col-md-7"></div>
 
 <div class="col-md-5" style="font-size:12px;"> 
 <a href="requestrewardlist.php"> Pending Requests</a>
 </div>
 </div>
 
 
 
 
 </div>
 
 
 
 
 </div>
 
 </div>
			 
			<?php }
			 if(mysql_num_rows($arr1)==0 && !isset($_GET['report']))
			 {
			 ?>
			 
			 <div class="container" style="padding-top:150px;">
 <div class="row">
 <div class="col-md-3"></div>
 
 <div class="col-md-6"  style=" border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#FFFFFF;color:#FF0000; font-weight:bold;" align="center" >
  <div style="height:20px;"></div>
 <?php echo "You don't have any request";  ?>
 <div style="height:20px;"></div>
 </div>
 
 
 
 
 </div>
 
 </div>
			 <?php } 
			 
			 ?>
</div>
</body>
</html>
