<?php

	include("cookieadminheader.php");
	
			$report="";
	if(isset($_GET["id"]))
	{
	$id=$_GET['id'];
	$query=mysql_query("select student_recognition from tbl_student_recognition where id='$id'");
	$result=mysql_fetch_array($query);
	$student_recognition=$result['student_recognition'];
	
	if(isset($_POST['submit']))
	{
		$student_recognition=$_POST['student_recognition'];
		
		
		
	   /*	$sql=mysql_query("select * from tbl_thanqyoupointslist where t_list='$t_list'");
		$sql1=mysql_fetch_array($sql);
		$result=mysql_num_rows($sql);
		if($result==0)
		{  */
         if(!empty($student_recognition))
         {
		
      		$sql=mysql_query("update tbl_student_recognition set student_recognition='$student_recognition' where id='$id' ");



      			 if(mysql_affected_rows()>0)
      		{
      		 $report="Reason  Successfully updated ";


      		}

	  
	
		

            else
            	  {
            	  $report="Already Reason  is present";
            	  }
	
	  }else
            	  {
            	  $report="Invalid Activity Name..";
            	  }
		
	
	}
	
	}
	?>
<html>	

<script>
function valid()
{


var activity=document.getElementById("student_recognition").value;

  if(activity=="" )
  {

   document.getElementById('erroractivity').innerHTML='Please enter Reson you Name';
				
				return false;
	}
	
	
 

var letters =/^[a-zA-Z ]+$/;
   if(!activity.match(letters))  
     {  
	
	 document.getElementById('erroractivity').innerHTML='Please enter valid Reason Name';
      return false;  
     }  
 




}
</script>

<body>
<div class="container">
<div clss="row" style="padding-top:100px;">

<div class="col-md-3"></div>
<div class="col-md-6">
 <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
 <div align="center">
 <h3>Edit Reason </h3> </div>
 
 <form method="post" >
 <div class="row" style="padding-top:20px;">

 
 
 <div class="row" style="padding-top:10px; ">
 

 <div class="col-md-6 col-md-offset-3">
 <input type="text" name="student_recognition"  id="student_recognition" value="<?php echo $student_recognition;?>" class="form-control" /></input>
 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
 </div>
 
 
 
 </div>
 
 
  <div class="row" style="padding-top:30px;" align="center">
 
 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>
                &nbsp;&nbsp;&nbsp;
                <a href="student_reason.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>



 
<div style="color:#FF0000;"align="center" > <?php echo $report;?></div>
 </div>
 </form>
 
<div style="height:30px;"></div>
 
 
</div>
</div>





</div>
</div>

</body>
</html>