<?php
//Add & Edit page merged on the same page- Rutuja Jori on 20/11/2019
include('scadmin_header.php');
$report="";
/*$id=$_SESSION['id'];
$fields=array("id"=>$id);
$table="tbl_school_admin";*/
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

if(isset($_GET['id'])=='')
{
	if(isset($_POST['submit']))
	{
    $a_year = $_POST['a_year'];
	$Academic_Year_check= explode('-', $a_year);
    $year = $_POST['year'];
	$enabled = $_POST['enabled'];
	$extId= $_POST['extId'];
	if($year == $Academic_Year_check[0])
	{
	//echo"hello1";
	//echo "SELECT * FROM  `tbl_academic_Year` WHERE `school_id`='$sc_id' and Academic_Year='$a_year' or Year = '$year' ";
   /* echo  $d_name." ".$d_post." ". $course; */
    $results=mysql_query("SELECT * FROM `tbl_academic_Year` WHERE `school_id`='$sc_id' and (Academic_Year='$a_year' or ExtYearID='$extId')");
	 //$rs = mysql_num_rows($results);

	
	 $extExistCheckQry=mysql_query("SELECT id from tbl_academic_Year WHERE ExtYearID='$extId' AND school_id='$sc_id'");
	 if(mysql_num_rows($extExistCheckQry)>=1 ){
		echo "<script LANGUAGE='JavaScript'>
                    window.alert('External Year already exist!');
                    window.location.href='Add_academic_year.php';
                    </script>";
		 exit();
	 }

  if(mysql_num_rows($results)==0)
	  
    {
		
		if($a_year > 0 || $extId > 0)
		{
			 $query= "select * from tbl_academic_Year WHERE Academic_Year='$a_year' and ExtYearID='$extId'";
			$query_run = mysql_query($query);
			
			if(mysql_num_rows($query_run)>0)
			{
				//if academic year is alredy present
				echo '<script type="text/javascript"> alert("".$dynamic_year." already exists ") </script>';
			}
		}
		//echo"hello 2";
       //echo"insert into `tbl_academic_Year`(Academic_Year,Year,school_id) values('$a_year','$year','$sc_id'";
	   
	   //$enabled added in insert query by Pranali for bug SMC-3554
	    $query="insert into `tbl_academic_Year` (ExtYearID,Academic_Year,Year,school_id,Enable) values('".$extId."','".$a_year."','".$year."','".$sc_id."','".$enabled."') ";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		if($rs){
			//when enabled=1 sets all other enabled=0
			if($enabled=='1')
			{
				$query="update tbl_academic_Year SET Enable=0 WHERE school_id='$sc_id' and Academic_Year != '$a_year'";
				$rs = mysql_query($query);
			}
			echo "<script type='text/javaScript'>
					alert('Record inserted Successfully');
				window.location.href='list_school_academic_year.php';
						</script>";

		      }

		}
	
	    else
	    {
			
		echo $errorreport = "<script type='text/javaScript'>
			alert('".$dynamic_year."Records already exsists');
		window.location.href='Add_academic_year.php';
				</script>";

	    

	    }
	}
	else{
		echo "<script>alert('Academic year already exist!');
				window.location.href='Add_academic_year.php';
		 		</script>";
	}

}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			
			<script type="text/javascript">
function valid() {

	//^[A-Z]{3}$
		var a_year = document.getElementById("a_year").value;
		var year_ = document.getElementById("year").value;
		const d = new Date();
		let cur_year=d.getFullYear();
		let years=a_year.split("-");
		let years2=parseInt(years[0])+1;

		console.log(d);
		console.log(cur_year);
		console.log(years2);
		console.log(years);
		if((years[0]==cur_year && (years[1]==parseInt(cur_year)+1)) || ((years[0]==parseInt(cur_year)-1) && (years[1]==years2))){  
			if(!(year_==years[0])){
				alert("It is not valid Year!");
				return false;
			}
			console.log("true");
		}else{
			alert("It is not valid Academic Year!");
			return false;
		}
		var a_year = document.getElementById("a_year").value;
        var pattern =/^[0-9-]{9}$/;
        if (pattern.test(a_year)) {
            //alert("Your your Academic Year is : " + a_year);
           // return true;
        }
		else{
        alert("It is not valid <?php echo $dynamic_year;?>! Format YYYY-YYYY");
		return false;
		}
		var year = document.getElementById("year").value;
       
	   var pattern = /^[12]\d{3}$/;
        if (pattern.test(year)) {
            //alert("Your your Academic Year is : " + year);
           // return true;
        }
		else{
        alert("It is not valid Year!");
		return false;
		}
		//validations for enabled year added by Pranali for bug SMC-3554
		var enabled = document.getElementById("enabled");
		if(enabled.value == '-1'){
			alert("Please Select if year is Enabled or not!");
			return false;	
		}
		
		var extId = document.getElementById("extId").value;
        var pattern = /^[0-9]{4}$/;
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
		
		
		
		
}
	</script>
	    <script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<html>
    <head>

    </head>
    <body>
        <div class="container" style="padding:25px;" >

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

                   <form method="post">

                   <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" ></div>

              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                   				<h2>Add <?php echo $dynamic_year;?></h2>

                               <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                                 <br><br>
               			 </div>

                     </div>


          <!--     <div class="row formgroup" style="padding:5px;" >

                   <div class="col-md-3 col-md-offset-4">
-->						
				<div class="row">
						<div class="col-md-4"><input type="hidden" name="yid" value="<?php echo $_GET['ExtYearID']?>" /></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;">External Year ID:<span style="color:red;font-size: 25px;">*</span></div>
					<div class="col-md-3">
                        <input type="text" name="extId" class="form-control " id="extId" placeholder="Enter External Year ID" maxlength="2" onKeyPress="return isNumberKey(event)" required>

                   </div>
               </div>
					<br/><br/>	

				<div class="row">
						
					<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_year;?>:<span style="color:red;font-size: 25px;">*</span></div>
					<div class="col-md-3">
                        <input type="text" name="a_year" class="form-control a_year" id="a_year" placeholder="<?php echo $dynamic_year;?> (YYYY-YYYY)" maxlength="9"  required>

                   </div>
                </div>
                   <br/><br/>

              <!--      <div class="col-md-3 col-md-offset-4">  -->
				<div class="row">
					<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;"> Starting Year:<span style="color:red;font-size: 25px;">*</span></div>
					<div class="col-md-3">
                        <input type="text" name="year" class="form-control " id="year" placeholder="Starting Year (YYYY)" maxlength="4" onKeyPress="return isNumberKey(event)" required>

                   </div>
                </div>
				   <!--Enabled Year added by Pranali for bug SMC-3554 -->
				 <br/><br/>
				<div class="row">
				   <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:382px;"> Enabled :<span style="color:red;font-size: 25px;">*</span></div>
						<div class="col-md-5">
						<!--commented dropdown code and added radio buttons for Enabled by Pranali for SMC-5152-->
							<!-- <select name="enabled" id="enabled" class="form-control" style="width:255px;">			  
							<option value="-1">Choose</option>
							<option value="1" >Yes </option>
							<option value="0" >No </option>
							</select> -->
							<!--displayed label after input type radio by Pranali-->
							 <input type="radio" name="enabled" id="isenable1" class="isenable" value="1" checked> Yes &emsp;
							
							  <input type="radio" name="enabled" id="isenable2" class="isenable" value="0"> No
						</div>
				</div>
                 
                    <br/><br/>
             <!--changes end for bug SMC-3554  -->
                   <div class="col-md-3 col-md-offset-4">

                   </div>
                
                    <!--<br/><br/>
-->


                 

				<div class="row">
                  <div id="error" style="color:#F00;text-align: center;" align="center"></div>
                </div>

					
                   <div class="row" style="padding-top:15px;">

                  <div class="col-md-2 col-md-offset-4 " >

                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                    </div>

                     <div class="col-md-3 "  align="left">

                   <a href="list_school_academic_year.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   </div>
<!--added margin-left: 272px; in below div-->
                     <div class="row" style="padding-top:15px;margin-left: 272px;">

                     <div class="col-md-4">

                     <input type="hidden" name="count" id="count" value="1">

                     </div>

                      <div class="col-md-11" style="color:#FF0000;" align="center" id="error">



                      <?php echo $errorreport;?>

               			</div>
                         <div class="col-md-11" style="color:#063;" align="center" id="error">



                      <?php echo $successreport;?>

               			</div>



                    </div>




                  </form>

          </div>
          </div>

    </body>
</html>
<?php } else{ 
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
	$Academic_Year_check= explode('-', $Academic_Year);
	$Year= $_POST['Year'];
	$extId= $_POST['extId'];
	$enabled = $_POST['enabled'];
	$date_cur = date("Y");
	if($Academic_Year_check[0] <= $date_cur && ($Academic_Year_check[1]-$Academic_Year_check[0] == 1) && ($Year == $Academic_Year_check[0]))
	{
		//$duplicate=mysql_query("select * from tbl_academic_Year where Academic_Year='$Academic_Year'");
		// 	if (mysql_num_rows($duplicate)>0)
		// 	{
		// 		echo "<script>alert('Academic Year already exists')
		// 	window.location.href='list_school_academic_year.php';
	 	// </script>";
			
		// 	}
		// 	else{
		if($enabled=='1')
		{		
		$sql = mysql_query("UPDATE `tbl_academic_Year` SET Academic_Year='$Academic_Year', Year='$Year', Enable='$enabled',ExtYearID='$extId' WHERE id='$id'");
	
		//when enabled=1 sets all other enabled=0
		$query="update tbl_academic_Year SET Enable=0 WHERE school_id='$sc_id' and Academic_Year != '$Academic_Year'";
		$rs = mysql_query($query);
	 	echo "<script>alert('Record Updated Successfully..!!')
			window.location.href='list_school_academic_year.php';
	 	</script>";
	 
		//header("Refresh:0; url=list_school_academic_year.php");
		
     }
		
		else
		{
		
			
			$query = "select Enable from tbl_academic_Year where school_id='$sc_id' and Enable = 1 and (Academic_Year = '$Academic_Year') and ExtYearID='$extId'";
			$rs = mysql_query($query);

			if(mysql_num_rows($rs) > 0)
			{
				echo "<script>alert('Please enable other academic year to disable this..!!')
				window.location.href='list_school_academic_year.php';
		 		</script>";
			}
			else
			{
				$sql = mysql_query("UPDATE `tbl_academic_Year` SET Academic_Year='$Academic_Year', Year='$Year', Enable='$enabled',ExtYearID='$extId' WHERE id='$id'");
				echo "<script>alert('Record Updated Successfully..!!')
						window.location.href='list_school_academic_year.php';
	 					</script>";
			}

		}
	}
	//}

	else{
		echo "<script>alert('It is not valid Academic Year!')
				window.location.href='list_school_academic_year.php';
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
		if(extId.trim()=="" || extId.trim()==null ||extId.trim()=="")
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
<br><br>
	
<!--change in div class and font-size by Dhanashri_Tak PHP-->	
	
<div class="row">
<div class="col-md-7"></div>
<div class="col-md-13" style="color:#FC2338; font-size:15px;" id="errorAcademic_Year"></div>
</div>
 <!--END-->
				   
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"> Starting Year :<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3" style="margin-left:-1px;">
<input type="text" class="form-control" name="Year" id="Year" value="<?php echo $rows['Year'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<br><br>

<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">External Year ID :<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<input type="text" class="form-control" name="extId" id="extId" value="<?php echo $rows['ExtYearID'];?>" readonly/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<br><br>

<!--Enabled Year added by Pranali for bug SMC-3554 -->
 <div class="row">
				   <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:437px;"> Enabled :<span style="color:red;font-size: 25px;">*</span></div>
				   <?php  $year=$rows['Enable']; ?>
						<div class="col-md-3">
							<!-- <select name="enabled" id="enabled" class="form-control" style="width:235px;margin-left:85px;">	
							
							<?php
                        
						if ($year== '-1') {
                            ?>
                            <option value='-1'
                                    selected><?php echo ""; ?></option>
                            <?php
                        }
                       else if ($year == '1') {
                            ?>
                            <option value='1'
                                    selected>Yes</option>
                            <?php
                        }

						else if ($year == '0') {
                            ?>
                            <option value='0'
                                    selected>No</option>
                            <?php
                        }
						else { ?>
                            <option value='-1'>Choose</option>
                        <?php } ?>
                        <?php if ($year != '1') { ?>
                            <option value='1'>Yes</option>
                        <?php }
                        if ($year != '0') {
                            ?>
                            <option value='0'>No</option>
                        <?php }?>
                       
                    </select> -->
                    <!--commented dropdwon and added radio buttons for academic year by Pranali for SMC-5152-->
							<input type="radio" name="enabled" id="isenable1" class="isenable" value="1" <?php if($year==1) echo "checked";?> > Yes &emsp;
							
							  <input type="radio" name="enabled" id="isenable2" class="isenable" value="0" <?php if($year==0) echo "checked";?> > No
						</div>
                    <br/><br/>
             <!--changes end for bug SMC-3554  -->
                   <div class="col-md-3 col-md-offset-4">

                   </div>

                    <!--<br/><br/>
-->


                 </div>

	
	<br><br>
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

<?php } ?>
