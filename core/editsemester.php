<?php
include('scadmin_header.php');

	$id=$_SESSION['id'];
    $exID = $_GET['extID']; 
	$sc_id=$_SESSION['school_id'];

	 $id=$_GET['id'];
			$fields=array("Semester_Id"=>$id);
			$table="tbl_semester_master";
		   
			$smartcookie=new smartcookie();
		   
			$results=$smartcookie->retrive_individual($table,$fields);
			$result=mysql_fetch_array($results);
			// $var=$result['ExtSemesterId']; 
			 
			
		//echo "$var";exit;
			//print_r($result); exit;

$report="";

if(isset($_POST['submit']))
{
		$semester=trim($_POST['semname']);
	    $extID=$_POST['extID'];
		$dept=$_POST['department'];
		$classSem=$_POST['class'];
		$branch=$_POST['branch'];
		$isregular=$_POST['isregular'];
		$Semester_credit=$_POST['Semester_credit'];
		$isenable=$_POST['isenable'];
		$courselevel=trim($_POST['courselevel']);
		$id=$_POST['id'];
		
	//echo $extID ;exit;	
if($exID == $extID)
{
	

	$r = "update  tbl_semester_master set Semester_Name='$semester',Branch_name='$branch',Is_regular_semester='$isregular',Semester_credit='$Semester_credit',Is_enable='$isenable',CourseLevel='$courselevel',Department_Name='$dept',class='$classSem', ExtSemesterId='$extID' where Semester_Id='$id' and school_id='$sc_id'";
	//echo "<script>alert('123') </script>";

}
else
{
$sql1 = mysql_query("select ExtSemesterId from tbl_semester_master where ExtSemesterId='$extID' and school_id='$sc_id'");
$count=mysql_num_rows($sql1);


if ($count > 0) 
{
	
	
    echo "<script>alert('Ext Semester id already present') </script>";
}

else
{
    $r = "update  tbl_semester_master set Semester_Name='$semester',Branch_name='$branch',Is_regular_semester='$isregular',Semester_credit='$Semester_credit',Is_enable='$isenable',CourseLevel='$courselevel',Department_Name='$dept',class='$classSem', ExtSemesterId='$extID' where Semester_Id='$id' and school_id='$sc_id'"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_semester.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("select * from tbl_semester_master where ExtSemesterId='$extID' and school_id='$sc_id'");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $dynamic_semester;?></title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

<script>
function validation()
{
	var semname=document.getElementById("semname").value;
	var extID=document.getElementById("extID").value;regx=/^[0-9]*$/;
	var dept=document.getElementById("dept").value;
	var classSem=document.getElementById("classSem").value;
	var branch=document.getElementById("branch").value;
	
	var semester_credit=document.getElementById("Semester_credit").value;
	 regx=/^[0-9]*$/;
	 
	 
	
	if(semname=="")
	{
	document.getElementById("errorsemester").innerHTML="Please enter <?php echo $dynamic_semester;?>";	
		return false;
		
	}
	else
	{
		document.getElementById("errorsemester").innerHTML="";	
		
	}
	if(extID=="")
	{
	document.getElementById("errorExtSemId").innerHTML="Please Enter External semester ID";	
		return false;
		
	}
	if(!regx.test(extID))
		{
			
		document.getElementById("errorExtSemId").innerHTML="It Is Not valid External semester ID";	
		return false;
		
	}
	else
	{
		document.getElementById("errorExtSemId").innerHTML="";	
		
	}
	if(dept=="")
	{
	document.getElementById("errordept").innerHTML="Please select department";	
		return false;
		
	}
	else
	{
		document.getElementById("errordept").innerHTML="";	
		
	}
	if(classSem=="")
	{
	document.getElementById("errorclass").innerHTML="Please select class";	
		return false;
		
	}
	else
	{
		document.getElementById("errorclass").innerHTML="";	
		
	}
	if(branch=="")
	{
	document.getElementById("errorbranch").innerHTML="Please select <?php echo $dynamic_branch;?>";	
		return false;
		
	}
	else
	{
		document.getElementById("errorbranch").innerHTML="";	
		
	}
	if(document.getElementById("regular1").checked || document.getElementById("regular2").checked)
	{
	document.getElementById("errorisregular").innerHTML="";	
	
		
	}
	else
	{
		document.getElementById("errorisregular").innerHTML="select regular <?php echo $dynamic_semester;?> yes or no";	
		return false;
	}
	
	 if(semester_credit=="")
	 {
			document.getElementById("errorsemestercredit").innerHTML="Enter <?php echo $dynamic_semester;?> credit";	
		return false;	
	 }
	if(!regx.test(semester_credit))
		{
			
		document.getElementById("errorsemestercredit").innerHTML="Enter valid <?php echo $dynamic_semester;?> credit";	
		return false;
		
	}
	else
	{
		document.getElementById("errorsemestercredit").innerHTML="";	
		
	}
	if(document.getElementById("isenable1").checked || document.getElementById("isenable2").checked)
	{
	document.getElementById("errorisenable").innerHTML="";	
		
		
	}
	else
	{
		document.getElementById("errorisenable").innerHTML="Please select isenable or not";	
		return false;
	}
	
	
		
		//alert("Record Updated Succefully");
		//window.location.href = "http://devsmart.bpsi.us/core/list_semester.php";
	
	
}
</script>



</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

	<div class="container" style="padding:25px;">
        	
            
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
			<div style="background-color:#F8F8F8;">
                    
				<div class="row">
                <div class="col-md-4"></div>
              	<div class="col-md-5 " align="center" style="color:black;padding:5px;" ><h2>Edit <?php echo $dynamic_semester;?></h2></div>
                </div>
                  
                 
                   
                  
		<div class="row">
             
              
	<div class="col-md-11">
            
<form method="post" >
                   

				   
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_semester;?> Name</div>
<div class="col-md-3">
<input class="form-control" name="semname" id="semname"  type="text" value="<?php echo $result['Semester_Name'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-4" style="color:#FC2338; font-size:18px;" id="errorsemester"></div>
</div>
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Ext Semester Id</div>
<div class="col-md-3">
<input class="form-control" name="extID" id="extID"  type="text" value="<?php echo $result['ExtSemesterId'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
	
	
	
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-4" style="color:#FC2338; font-size:18px;" id="errorExtSemId"></div>
</div>
                      

					  
<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Department Name</div>
<div class="col-md-3">
<select name="department" class="form-control " id="dept">
<option value="<?php echo $result['Department_Name'];?>" selected="selected"> <?php echo $result['Department_Name'];?></option>
<?php  $row=mysql_query("select * from tbl_department_master  where school_id='$sc_id' ");
while($value=mysql_fetch_array($row))
{
?>
<option value="<?php echo $value['Dept_Name'];?>"><?php echo $value['Dept_Name']?></option>
<?php }?>
</select>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>


<div class="row" >
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errordept">
</div>
</div>

 <div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Class Name</div>
<div class="col-md-3">
<select name="class" class="form-control " id="classSem">
<option value="<?php echo $result['class'];?>" selected="selected"> <?php echo $result['class'];?></option>
<?php  $row=mysql_query("select * from Class  where school_id='$sc_id' ");
while($value=mysql_fetch_array($row))
{
?>
<option value="<?php echo $value['class'];?>"><?php echo $value['class']?></option>
<?php }?>
</select>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>


<div class="row" >
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorclass">
</div>
</div>

 
<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_branch;?> Name</div>
<div class="col-md-3">
<select name="branch" class="form-control " id="branch">
<option value="<?php echo $result['Branch_name'];?>" selected="selected"><?php echo $result['Branch_name'];?></option>
<?php  $row=mysql_query("select Branch_code,branch_Name from  tbl_branch_master  where school_id='$sc_id' ");
while($value=mysql_fetch_array($row))
{
?>
<option value="<?php echo $value['branch_Name'];?>"><?php echo $value['branch_Name']?></option>
<?php }?>
</select>
</div>
</div>



<div class="row" >
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorbranch"></div>
</div>


	
<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_level;?></div>
<div class="col-md-3">
<select name="courselevel" class="form-control " id="courselevel">
<option value="<?php echo $result['CourseLevel'];?>" selected="selected"><?php echo $result['CourseLevel'];?></option>
	<?php 
		$sql_course=mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' order by id");
		while($result_course=mysql_fetch_array($sql_course))
	{?>
	<option value="<?php echo $result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>
	<?php }
	?>
</select>
</div>
</div>



<div class="row">
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorbranch"></div>
</div>

  

<div class="row" style="margin-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Is regular <?php echo $dynamic_semester;?></div>
<div class="col-md-3">
<?php if($result['Is_regular_semester']==1){?>
Yes &nbsp;<input type="radio" name="isregular" value="1" id="regular1" checked="checked"/> &nbsp;
No &nbsp;<input type="radio" name="isregular" value="0" id="regular2"/>
<?php }else{?>
Yes &nbsp;<input type="radio" name="isregular" value="1" id="regular1"/> &nbsp;
No &nbsp;<input type="radio" name="isregular" value="0" id="regular2"/>
<?php }?>
</div>
</div>

 

<div class="row">
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorisregular">
</div>
</div>




<div class="row" style="padding-top:20px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_semester;?> credit</div>
<div class="col-md-3">
<input class="form-control" name="Semester_credit" id="Semester_credit"  type="text"  value="<?php echo $result['Semester_credit'];?>">
</div>
</div>




<div class="row">
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorsemestercredit">
</div>
</div>




<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Is Enabled</div>
<div class="col-md-3">
<?php if($result['Is_enable']==1)
{?>
Yes&nbsp;&nbsp; 
<input type="radio" name="isenable" id="isenable1" value="1" checked="checked"> &nbsp;&nbsp;No&nbsp; &nbsp;&nbsp;<input type="radio" name="isenable"id="isenable2" value="0">
<?php }else{?>
Yes&nbsp;&nbsp; <input type="radio" name="isenable" id="isenable1" value="1"> &nbsp;&nbsp;No&nbsp; &nbsp;&nbsp;<input type="radio" name="isenable"id="isenable2" value="0" checked="checked">
<?php }?>
</div>
</div>



<div class="row" >
<div class="col-md-6"></div>
<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorisenable"></div>
</div>





<div class="row" style="padding-top:10px;">
<div class="col-md-5"></div>
<div class="col-md-2"><input name="submit" value="Save" class="btn btn-success" type="submit" onClick="return validation()"></div>

<div class="col-md-2"><a href="list_semester.php"><input name="cancel" value="Cancel" class="btn btn-danger" type="button"></a></div>
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
