 <?php include_once('stud_header.php');
 
  if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 
 $report="";
 $report1="";

 
  $stud_id=$_GET['stud_id'];
  
 
	
	 $id=$_SESSION['id'];


	$query=mysql_query("select std_name from tbl_student where id='$stud_id' ");
	$result=mysql_fetch_array($query);
	$std_name=$result['std_name'];
	
	if(isset($_POST['submit']))
	{
	$date=Date('m/d/Y');
	$points=$_POST['points'];
	$comment=$_POST['comment'];
	
	
			 
				 $sql=mysql_query("select * from tbl_request where stud_id1='$id' and stud_id2='$stud_id' and reason like '$comment' and flag='N' and requestdate='$date' and points='$points' and entitity_id='105'");
		$count=mysql_num_rows($sql);
			
		if($count==0)
		{		
					 $arr = mysql_query("insert into tbl_request(stud_id1,stud_id2,reason,points,requestdate,flag,entitity_id) values('$id','$stud_id','$comment','$points','$date','N','105')");
					  $report="Request Sent Successfully";
		}
		else
		{
	
	$report="Already request sent";
		
		}
		
		
		

	
        
	
	
	
	
	}
	
	

?>
<html>
<head>



 
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
    


    
</head>
<body style="background-color:#FFFFFF;">
<div class="container" >
 
<div class="row" style="padding-top:60px;">
  <div class="col-md-3"></div>
<div class="col-md-5">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Request For Points</h3>
  </div>
  <div class="panel-body">
   <form method="post">
   <b> Name: </b>&nbsp;&nbsp;<?php echo $std_name;?><br><br>
   
    
    I want <br>
    <br> <input type="text" name="points" id="points" class="form-control"><b>Points</b><br><br>
    Reason<br><br><textarea class="form-control" rows="5" id="comment" name="comment"></textarea><br><br>
   
<input type="submit" name="submit" id="submit" value="Request" class="btn btn-primary" onClick="return valid();">
  <a href="sharepoint.php" style="text-decoration:none"> <input type="button" name="cancel" id="submit" value="Back" class="btn btn-danger" ></a>
  
    </form>
    
   
    <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" id="errorreport" ><?php echo $report;?></div>
   
 

  </div>
  
</div>
</div>


  </div> 
</div>
</body>

</html>

