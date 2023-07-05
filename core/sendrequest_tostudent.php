 <?php include_once('stud_header.php');
 
  if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 
 $report="";
 $report1="";

 
  $stud_id=$_GET['stud_id'];
  
 
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $school_id=$value['school_id'];
	 $id=$value['id'];
	 $std_PRN=$value['std_PRN'];
	 
	 $query1 = mysql_query("select sc_total_point, sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = '$std_PRN'");
	 $st_points = mysql_fetch_array($query1);
	
	$sc_total_point=$st_points['sc_total_point'];
	

	$sql=mysql_query("select std_complete_name from tbl_student where std_PRN='$stud_id' and school_id='$school_id' ");
	$result=mysql_fetch_array($sql);
	$std_name=$result['std_complete_name'];
	
	if(isset($_POST['submit']))
	{
	$date=Date('d/m/Y');
	$points=$_POST['points'];
	$comment=$_POST['comment'];
	
	$sql1=mysql_query("select * from tbl_request where stud_id1='$std_PRN' and stud_id2='$stud_id' and reason like '$comment' and flag='N' and requestdate='$date' and points='$points' and entitity_id=105 and school_id='$school_id'");
	
				$result=mysql_num_rows($sql1);	
				
					
					
					
		
			
							if($result==0)
							{
								
								$sql3=mysql_query("insert into tbl_request(stud_id1,stud_id2,reason,points,requestdate,flag,entitity_id,school_id) values('$std_PRN','$stud_id','$comment','$points','$date','N','105','$school_id')");
								 
								$report="Request Sent Successfully";
								 
								header("Location:sendrequest_tostudent.php?report=".$report."&stud_id=".$stud_id);
								
								
								
							}
							
							else
							{
								 $report1="Request Already Sent";
								
							}
	    

	
	
	
	
	}
	
	

?>
<html>
<head>


<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
    
    <script>
	function valid()
	{
	var points=document.getElementById('points').value;
		var comment=document.getElementById('comment').value;
	
	if(points=="" || points==null)
	{
	document.getElementById('errorreport').innerHTML="Please enter points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport').innerHTML="Please enter valid points";
      return false;  
      }  

	
	if(comment=="" || comment==null)
	{
	document.getElementById('errorreport').innerHTML="Please enter reason";
	return false;
	
	}
	
	
	
	
	
	}
	</script>
    <style>
	textarea {
    resize: none;
}
	</style>
<div class="row" style="padding-top:60px;">

</head>
<div class="container">
 <div class="col-sm-3" style="padding:20px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
         <div  style="height:50px; background-color:#0073BD; border:1px solid #0073BD;color:#FFFFFF" align="left">
        		<div style="float:left;"><h1 style="padding-left:20px; margin-top:10px; color:#FFFFFF;"> My Rewards</h1></div>
          </div> 
           <div align="center" style="padding-top:20px;font-size:40px;color: #308C00;
font-weight: bold;
line-height: 1.1;">
           <?php $sql=mysql_query("select sc_total_point from  tbl_student_reward  where sc_stud_id='$std_PRN'");
		   $result=mysql_fetch_array($sql);
		   $sc_total_point=$result['sc_total_point'];
		   if($sc_total_point=="")
		   {
		   echo "0";
		   }
		   else
		   {
		   echo $sc_total_point; 
		   
		   }
		   ?> 
		  
           
            </div>  
              <div align="center" style="color:#0073BD;font-size:20px; padding-top:15px;">Points</div>    
       	    </div>
            <div class="col-md-2"></div>
<div class="col-md-5">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Send Request to Student</h3>
  </div>
  <div class="panel-body">
   <form method="post">
   <b> Name: </b>&nbsp;&nbsp;<?php echo $std_name;?><br><br>
   
    
    I want <br><br> <input type="text" name="points" id="points" class="form-control" onKeyPress="return isNumberKey(event)"><b>Points</b><br><br>
    Reason<br><br><textarea class="form-control" rows="5" id="comment" name="comment"></textarea><br><br>
   
<input type="submit" name="submit" id="submit" value="Send" class="btn btn-primary" onClick="return valid();">
  <a href="sharepoint.php" style="text-decoration:none"> <input type="button" name="cancel" id="submit" value="Back" class="btn btn-danger" ></a>
  
    </form>
    
    <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" id="errorreport"><?php if(isset($_GET['report'])){ echo $_GET['report']; }?></div>
    <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" ><?php echo $report1;?></div>
    
 

  </div>
  
</div>
</div>


  </div> 

    
</head>
<body style="background-color:#FFFFFF">
<div class="container" >
 

</div>
</body>

</html>

