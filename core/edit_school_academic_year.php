<?php
ob_start();
include('scadmin_header.php');
	$id=$_SESSION['id'];
	$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
	$rows=mysql_fetch_array($sql);
	$sc_id=$rows['school_id'];

	$id=$_GET['id'];
			$fields=array("id"=>$id);
			$table="tbl_academic_Year";
		   
			$smartcookie=new smartcookie();
		   
			$results=$smartcookie->retrive_individual($table,$fields);
			$rows=mysql_fetch_array($results);
			$exId= $rows['ExtYearID'];

if(isset($_POST['submit']))
{
	 $id=$_POST['id'];
	$Academic_Year= $_POST['Academic_Year']; 
	$Year= $_POST['Year'];
	$extId= $_POST['extId'];
	$enabled = $_POST['enabled'];
	
	 $sql = mysql_query("UPDATE `tbl_academic_Year` SET Academic_Year='$Academic_Year', Year='$Year', Enable='$enabled',ExtYearID='$extId' WHERE id='$id'");
	 if($sql)
	 {
	 echo "<script>alert('Record Updated Successfully..!!')
			window.location.href='list_school_academic_year.php';
	 </script>";
		//header("Refresh:0; url=list_school_academic_year.php");
	 }
	 else
	 {
		 echo "<script>alert('External year ID already present ..!!') 
		 </script>";
		 
	 }
}
?>
	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit <?php echo $dynamic_year;?></title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<!--Done validation for academic year and year by Dhanashri_Tak PHP-->

<script>
function validation()
{
	//var semname=document.getElementById("semname").value;
	var Academic_Year=document.getElementById("Academic_Year").value;
	var Year=document.getElementById("Year").value;
	
	//var semester_credit=document.getElementById("Semester_credit").value;
	regx=/^[0-9 -]+$/;
	 regx1=/^[0-9]*$/;
	
	 if(Academic_Year.trim()=="" || Academic_Year.trim()==null)
	{
		document.getElementById("errorAcademic_Year").innerHTML="Please Enter valid <?php echo $dynamic_year;?>";	
			return false;
	}
	if(Academic_Year=="" || Academic_Year==null)
	{
	document.getElementById("errorAcademic_Year").innerHTML="Please Enter <?php echo $dynamic_year;?>";	
		return false;
		
	}
	if(regx.test(Academic_Year)==false)
	{
	document.getElementById("errorAcademic_Year").innerHTML="Please Enter Valid <?php echo $dynamic_year;?>";	
		return false;
	}
	else
	{
		document.getElementById("errorAcademic_Year").innerHTML="";	
		
	}
	
	
	var extId = document.getElementById("extId").value;
        var pattern = /^[0-9]+$/;
		if(extId.trim()=="" || extId.trim()==null)
		{
			alert("Please Enter External year Id !");
		return false;
		}
        if (pattern.test(extId)) {
            //alert("Your your Academic Year is : " + ExtCourseLevelID);
           // return true;
        }
		else{
        alert("It is not valid External year Id !");
		return false;
		}
	
	
	
	
	 if(Year.trim()=="" || Year.trim()==null)
	{
		document.getElementById("errorYear").innerHTML="Please Enter valid Year";	
			return false;
	}
	if(Year=="" || Year==null)
	{
	document.getElementById("errorYear").innerHTML="Please Select Year";	
		return false;
		
	}
	if(regx1.test(Year)==false)
	{
	document.getElementById("errorYear").innerHTML="Please Select Valid Year";	
		return false;
		
	}
	else
	{
		document.getElementById("errorYear").innerHTML="";	
		
	}
//validations for enabled year added by Pranali for bug SMC-3554
		var enabled = document.getElementById("enabled");
		if(enabled.value == '-1'){
			alert("Please Select if year is Enabled or not!");
			return false;	
		}
	
		
		//alert("Record Updated Succefully");
		var enabled = document.getElementById("enabled");
		if(enabled.value == '-1'){
			alert("Please Select if year is Enabled or not!");
			return false;	
		}
	
}
</script>

<!--End-->

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

	<div class="container" style="padding:25px;">
        	
            
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
			<div style="background-color:#F8F8F8;">
                    
				<div class="row">
                <div class="col-md-4"></div>
              	<div class="col-md-5 " align="center" style="color:black;padding:5px;" ><h2>Edit <?php echo $organization;?> <?php echo $dynamic_year;?></h2></div>
                </div>
                  
                 
                   
                  
		<div class="row">
             
              
	<div class="col-md-11">
            
<form method="post">
                   
<?php// echo $result['Academic_Year'];?> 
	<?php// echo $result['Year'];die?>			   
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_year;?> :<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<input type="text" class="form-control" name="Academic_Year" id="Academic_Year"   value="<?php echo $rows['Academic_Year'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>

	
<!--change in div class and font-size by Dhanashri_Tak PHP-->	
	
<div class="row">
<div class="col-md-7"></div>
<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errorAcademic_Year"></div>
</div>
 <!--END-->
				   
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"> Current Year :<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3" style="margin-left:-1px;">
<input type="text" class="form-control" name="Year" id="Year" value="<?php echo $rows['Year'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">External Year ID :<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<input type="text" class="form-control" name="extId" id="extId"   value="<?php echo $rows['ExtYearID'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<!--Enabled Year added by Pranali for bug SMC-3554 -->
 <div class="row">
				   <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:350px;"> Enabled :<span style="color:red;font-size: 25px;">*</span></div>
						<div class="col-md-3">
						
							<select name="enabled" id="enabled" class="form-control" style="width:235px;margin-left:85px;">			  
							<option value="-1">Choose</option>
							<option value="1" >Yes </option>
							<option value="0" >No </option>
							</select>
						</div>
                    <br/><br/>
             <!--changes end for bug SMC-3554  -->
                   <div class="col-md-3 col-md-offset-4">

                   </div>

                    <!--<br/><br/>
-->


                 </div>

	
	
<!--change in div class and font-size by Dhanashri_Tak PHP-->	
<div class="row">
<div class="col-md-7"></div>
<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errorYear"></div>
</div>
  <!--END-->

<div class="row" style="padding-top:10px;">
<div class="col-md-5"></div>
<div class="col-md-2"><input name="submit" value="Save" class="btn btn-success" type="submit" onClick="return validation()"></div>

<div class="col-md-2"><a href="list_school_academic_year.php"><input name="cancel" value="Cancel" class="btn btn-danger" type="button"></a></div>
</div>
                  
                 
					
<div class="row" style="padding-top:30px;">
<center style="color:#006600;"></center>
</div>
                 
                    
</form>
                  
	</div>
        
		</div>
                  
                  
					<div class="row" style="padding:5px;">
					<div class="col-md-4"></div>
					<div class="col-md-3 " align="center"></div>
                    </div>
                    
                
                  
                 
                    
            </div>
				
		</div>
		
	</div>
	
</div>	

</body>

</html>
