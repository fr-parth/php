<?php
include('scadmin_header.php');
//include('conn.php');
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
 if(isset($_GET['activity'])=='')
	{

if(isset($_POST['submit']))
		{
			$reason_name=$_POST['reason'];
			
			$res=mysql_query("select * from tbl_student_recognition where student_recognition='$reason_name' and school_id='$school_id'");
			
			$test=mysql_num_rows($res);
			if($test<=0)
			{
			$query="insert into tbl_student_recognition(student_recognition,school_id) values('$reason_name','$school_id')";
			$rs = mysql_query( $query );
							if($rs)
							{
								//echo "<script>alert('$reason_name Successfully Added')</script>";
								echo ("<script LANGUAGE='JavaScript'>
					            window.alert('$reason_name Successfully Added');
					            window.location.href='sc_stud_activity.php';
				               </script>");
							}
							else
							{
								echo "<script>alert('Error While Inserted')</script>";
							}
			
			}
			else
			{
				 echo "<script>alert('$reason_name is Already Exists')</script>";
			}
		}
		
		

?>

<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">
function valid() {

		var reason = document.getElementById("reason").value;
		var pattern = /^[a-zA-Z ]+$/;
       if(reason.trim()=="" || reason.trim()==null)
		{
			alert("please enter Reason!");
			return false;
		}
        
        else if (pattern.test(reason)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
		else{
        alert("It is not valid Reason!!");
		return false;
		}
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies</title>
</head>

<!--<link href="css/style.css" rel="stylesheet"> -->
 <link rel="stylesheet" href="css/bootstrap.min.css">
 
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

</head>

<body style="background-color:#F8F8F8;">
<div align="center">
	<div style="width:100%">
    	
        
        	<div style="height:10px;"></div>
    		<div style="height:50px; border-bottom: thin solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;color:#666;text-align:center"> Student Recognition Reason</h1>
        	</div>
    	<div style="height:30px;"></div>
    	
         <div class="container">
        <div class="row">
         <div class="col-md-10">
		 <form method="post" name="product">
        	<div style=" background-color:#FFFFFF; border:1px solid #CCCCCC; padding-left:200px;margin-left: 200px;" align="left">
            	<div style="height:10px;"></div>
            	<div>
					<h2 style="color:#666;">Add Reason</h2>
                </div>
                <div style="height:10px;"></div>
            	<div>
      <input type="text" id="reason"  name="reason" style="width:50%; height:30px; padding:5px;" placeholder="Enter Reason" /></br></br>
                </div>
				
				<div>
                <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Submit" onClick="return valid()"/>
                &nbsp;&nbsp;&nbsp;
           <a href="sc_stud_activity.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>
                
                </div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</body>
</html>
	<?php }
	else{
	
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
	<?php } ?>