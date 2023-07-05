<?php

	include('scadmin_header.php');
//include('conn.php');
$school_id = $_SESSION['school_id'];
			$report="";
	if(isset($_GET["activity"]))
	{
	$id=$_GET['activity'];
	$query=mysql_query("select student_recognition from tbl_student_recognition where id='$id' and school_id='$school_id'");
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
		
      		$sql=mysql_query("update tbl_student_recognition set student_recognition='$student_recognition' where id='$id' and school_id='$school_id' ");



      			 if(mysql_affected_rows()>0)
      		{
      		// $report="Reason  Successfully updated ";
				echo ("<script LANGUAGE='JavaScript'>
								window.alert('Reason  Successfully updated');
								window.location.href='sc_stud_activity.php';
								</script>");

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


<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">
			
function valid() {
	//alert('hiiiiii');
var student_recognition = document.getElementById("student_recognition").value;
		var pattern = /^[a-zA-Z ]*$/;
       if(student_recognition.trim()=="" || student_recognition.trim()==null)
		{
			alert("It is not valid Student Reason!");
			return false;
		}
        
        else if (pattern.test(student_recognition)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
		else{
        alert("It is not valid Student Reason!");
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
 <h3>Edit Student Reason </h3> </div>
 
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
                <a href="sc_stud_activity.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>



 
<div style="color:#008000;"align="center" > <?php echo $report;?></div>
 </div>
 </form>
 
<div style="height:30px;"></div>
 
 
</div>
</div>





</div>
</div>

</body>
</html>