
<?php  include('scadmin_header.php');
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
//Updated by Rutuja for SMC-5157 for making Branch drop down dependent on Course Level & Department selected further kept by default as Enabled on 16-01-2021
/*Updated by Rutuja for adding dynamic variables for branch, class and course level for labels and validation messages for SMC-5056 on 25-12-2020 */

//SMC-5009 by Pranali : school id retrieved from session to show department , branch, class and course level records as per displayed in respective lists in master menu.
$sc_id=$_SESSION['school_id'];


?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
function validation()
{
	var semname=document.getElementById("semname").value;
        var pattern = /^[a-zA-Z0-9-/ ]+$/;
        if (pattern.test(semname)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{

        alert("Enter valid <?php echo $dynamic_semester;?> Name!");

		return false;
		}
		
		var extID=document.getElementById("extID").value;
        var pattern = /^[0-9]+$/;
        if (pattern.test(extID)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("Enter valid External <?php echo $dynamic_semester;?> ID!");
		return false;
		}
		
		
		
	var dept=document.getElementById("department").value;
	var branch=document.getElementById("branch").value;
	var classSem=document.getElementById("classSem").value;
	var semester_credit=document.getElementById("Semester_credit").value;
	 regx=/^[0-9]*$/;
	 var corselevel=document.getElementById("courselevel").value;
	if(corselevel=="")
	{
	document.getElementById("errorcourselevel").innerHTML="Please select <?php echo $dynamic_level;?>";	
		return false;
		
	}
	else
	{
		document.getElementById("errorcourselevel").innerHTML="";	
		
	}
	
	if(semname=="")
	{
	document.getElementById("errorsemester").innerHTML="Please enter <?php echo $dynamic_semester;?>";	
		return false;
		
	}
	else
	{
		document.getElementById("errorsemester").innerHTML="";	
		
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
	 
	if(branch=="")
	{
	document.getElementById("errorbranch").innerHTML="Please select an branch!";	
		return false;
		
	}
	else
	{
		document.getElementById("errorbranch").innerHTML="";	
		
	}
	// var branch = document.getElementById("branch");
//    if (branch === "") {
//             //If the "Please Select" option is selected display error.
//             alert("Please select an branch!");
//             return false;
//         }
// 	else
// 	{
// 		document.getElementById("errorbranch").innerHTML="";	
		
// 	}
	if(classSem=="")
	{
	document.getElementById("errorclass").innerHTML="Please select <?php echo $dynamic_class;?>";	
		return false;
		
	}
	else
	{
		document.getElementById("errorclass").innerHTML="";	
		
	}
	
	
	
	
	if(document.getElementById("regular1").checked || document.getElementById("regular2").checked)
	{
	document.getElementById("errorisregular").innerHTML="";	
	
		
	}
	else
	{
		document.getElementById("errorisregular").innerHTML="select regular <?php echo $dynamic_semester;?> yes or no ";	
		return false;
	}
	

	 // if(semester_credit=="")
	 // {
			// document.getElementById("errorsemestercredit").innerHTML="Enter <?php echo $dynamic_semester;?> credit";	
		// return false;	
	 // }

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
	
}
</script>

<?php
$report="";
if($_GET['extID']=='')
{
	//add semester
if(isset($_POST['submit']))
{
 	 $semester=trim($_POST['semname']);
 	 $ExtSemesterID=$_POST['extID'];
	 $dept=$_POST['department'];
	 $classSem=$_POST['class'];
	 $branch=$_POST['branch'];
	 //$branch_str = explode(",", $branch_arr);
	 //$branch = $branch_str[1];
	 $isregular=$_POST['isregular'];
     $Semester_credit=$_POST['Semester_credit'];
	 $isenable=$_POST['isenable'];
	 $courselevel=trim($_POST['courselevel']);

	if(!empty($semester) && !empty($dept) && ($branch!='Select Branch') && ($isregular==0 || $isregular==1) && is_numeric($isenable) )
	{
		$class="";
	     $ext=mysql_query("select ExtSemesterId from tbl_semester_master where ExtSemesterId='$ExtSemesterID' and school_id='$sc_id'");
			$a=mysql_num_rows($ext);
			//echo $a; exit;
			if ($a>0)
			{	
				echo ("<script LANGUAGE='JavaScript'>
								alert('External ".$dynamic_semester." ID Is Already Present');
							</script>");
			}
			else
			{	
			
				$row=mysql_query("insert into tbl_semester_master(school_id,Department_Name,Semester_Name,Branch_name,Is_regular_semester,Semester_credit,Is_enable,CourseLevel,class,ExtSemesterId) values('$sc_id','$dept','$semester','$branch','$isregular','$Semester_credit','$isenable','$courselevel','$classSem','$ExtSemesterID')");
	
				if($row)
				{
				echo ("<script LANGUAGE='JavaScript'>

								alert('Record Added Successfully');

								window.location.href='list_semester.php';
							</script>");
				}
				else
				{
		
					echo "<script>alert('Record Not Added')</script>";
				}
				
			}
	}	
	else
	{
		echo "<script>alert('Please enter all valid parameter')</script>";
	}
			
}
	

?>
 

</head>
<script>

/*function Myfunction(value,fn)

{

 
//Added below variables by Pranaali for SMC-5048
//var teacher = document.getElementById("teacher_id").value;
var course_level = document.getElementById("courselevel").value;
var Dept_Name = document.getElementById("dept").value;
 if(value!='')

 {
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

				if(fn=='fun_course')

				{

					  document.getElementById("department").innerHTML =xmlhttp.responseText;

					

				}

				

				if(fn=='fun_dept')

				{

					 document.getElementById("branch").innerHTML =xmlhttp.responseText;

					

				}

				if(fn=='fun_branch')

				{

					 document.getElementById("semester").innerHTML =xmlhttp.responseText;

					

				}

				

				if(fn=='fun_subject')

				{

					 document.getElementById("subject_code").innerHTML =xmlhttp.responseText;

					

				}


            }

          }
		
		var nval = escape(value);
      

 xmlhttp.open("GET","get_stud_sub_details.php?fn="+fn+"&value="+value+"&course_level="+course_level+"&dept="+Dept_Name,true);

        xmlhttp.send();
	  

 }

}*/

	function MyFunction1() { 
         var course = document.getElementById("courselevel").value;
       
         var department = document.getElementById("department").value;
         //alert(course);alert(department);
        
         $.ajax({
             type:"POST",
             data:{course:course,department:department}, 
             url:'get_sem_details.php',
             success:function(data)
             { //alert(data);
               $('#branch').html(data);
             }
             
             
         });
         
     }
//      $(document).ready(function()
// {
// 	$("#submit").click(function()
// 	{
// 	var branch1=$("#branch");
// 	if(branch1.val()==="")
// 	{
// 		document.getElementById("branch").innerHTML="Please select <?php echo $dynamic_branch;?>";
// 		document.getElementById("branch").style.color="red";
// 	}
// else
// {
// document.getElementById("branch").innerHTML=" <?php echo $dynamic_branch;?>";
// }
// 	});

// });





//      $( "select[name='branch']" ).change(function () {
//     var branch1 = $(this).val();


//     if(branch1) {


//         $.ajax({
//             url: "get_sem_details.php",
//             dataType: 'Json',
//             data: {'id':branch1},
//             success: function(data) {
//                 $('select[name="branch"]').empty();
//                 $.each(data, function(key, value) {
//                     $('select[name="branch"]').append('<option value="'+ key +'">'+ value +'</option>');
//                 });
//             }
//         });


//     }else{
//         $('select[name="branch"]').empty();
//     }
// });

</script>
<body>
<div class="container" style="padding:25px;">
        	<div class="container" style="padding:25px;">
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
                   
                  <div style="color:#FC2338;font-size:16px;margin-top:10px;" align="center">  <?php echo $errorreport;?></div>
                   <div style="color:#090;font-size:16px;margin-top:10px;" align="center">  <?php echo $successeport;?></div>
                    
                 	<div style="margin-top:10px;" class="h1"><center>Add <?php echo $dynamic_semester;?></center></div>
					<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
                     <!--<h5 align="center"><a href="addsemestersheet.php">Add Excel Sheet</a></h5>-->
                 <br>
                   <form method="post" >

<!--Course level design issue solved by Pranali for SMC-5009-->
<div class="row" style="padding-top:10px;">


<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">

<?php echo $dynamic_level;?> <span style="color:red;font-size: 25px;">*</span></div>


<div class="col-md-3">

<select name="courselevel" class="form-control " id="courselevel" onChange="MyFunction1()">
<option value="">Select</option>
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
<div class="row" >
<div class="col-md-6"></div>

<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorcourselevel">

</div></div>

<div class="row" style="padding-top:10px;">



<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
Department Name<span style="color:red;font-size: 25px;">*</span></div>


<div class="col-md-3">
<select name="department" class="form-control " id="department" onChange="MyFunction1()">
<option value="">Select</option>
<?php  $row=mysql_query("select id,Dept_code,trim(Dept_Name) as Dept_Name,ExtDeptId from tbl_department_master  where school_id='$sc_id' and Dept_Name!='' group by Dept_Name order by Dept_Name asc");
while($value=mysql_fetch_array($row))
{
?>
<option value="<?php echo $value['Dept_Name'];?>"><?php echo $value['Dept_Name']?></option>
<?php }?>
</select>
</div>

<div class="col-md-2" style="color:#FF0000;"></div>
</div>


<div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errordept">

</div></div>
<div class="row" style="padding-top:10px;">

<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
<?php echo $dynamic_branch;?> Name<span style="color:red;font-size: 25px;">*</span></div>

<div class="col-md-3">
<select name="branch" class="form-control " id="branch" required>
<!-- <option value="">Select</option> -->
 <?php //$row=mysql_query("select Branch_code,branch_Name from  tbl_branch_master  where school_id='$sc_id' and branch_Name!=''");
/// while($value=mysql_fetch_array($row))
//{
?>
<!-- <option value="<?php //echo $value['branch_Name'];?>"><?php  //echo $value['branch_Name']?></option> -->
<?php //}?>
</select>
</div>
</div>
<div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorbranch">

</div></div>
<div class="row" style="padding-top:10px;">

<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
<?php echo $dynamic_class;?> Name<span style="color:red;font-size: 25px;">*</span></div>

<div class="col-md-3">
<select name="class" class="form-control " id="classSem">
<option value="">Select</option>
<?php  $row=mysql_query("select id,trim(class) as class,ExtClassID,course_level from Class  where school_id='$sc_id' and class!='' group by class order by class asc");
while($value=mysql_fetch_array($row))
{
?>
<option value="<?php echo $value['class'];?>"><?php echo $value['class']?></option>
<?php }?>
</select>
</div>

<div class="col-md-2" style="color:#FF0000;"></div>
</div>

 <div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorclass">

</div></div>

<div class="row" style="margin-top: 17px;">

<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
<?php echo $dynamic_semester;?> Name<span style="color:red;font-size: 25px;">*</span></div>


<div class="col-md-3" >


<input class="form-control" name="semname" id="semname"  type="text">

</div>

<div class="col-md-2" style="color:#FF0000;"></div>
</div>
 <div class="row" >
<div class="col-md-6"></div>

<div class="col-md-3" style="color:#FC2338; font-size:18px;" id="errorsemester">

</div></div>
</br>
 <div class="row" >

<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
Ext<?php echo $dynamic_semester;?> ID<span style="color:red;font-size: 25px;">*</span></div>

<div class="col-md-3" style="text-align:left">


<input class="form-control" name="extID" id="extID"  type="text" >

</div>

<div class="col-md-2" style="color:#FF0000;"></div>
</div>
 <div class="row" >
<div class="col-md-6"></div>


<div class="col-md-3" style="color:#FC2338; font-size:18px;" id="errorExtSemesterID">

</div></div>


   <div class="row" style="margin-top:10px;">




<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
Is_regular_<?php echo $dynamic_semester;?><span style="color:red;font-size: 25px;">*</span></div>



<div class="col-md-3">
<input type="radio" name="isregular" value="1" id="regular1" checked="checked"/> &nbsp Yes &nbsp;&nbsp;
<input type="radio" name="isregular" value="0" id="regular2"/>&nbsp No
</div>
</div>

 <div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorisregular">

</div></div>

 <div class="row" style="padding-top:20px;">




<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
<?php echo $dynamic_semester;?> credit</div>


<div class="col-md-3">
<input class="form-control" name="Semester_credit" id="Semester_credit"  type="text">
</div>
</div>
 <div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorsemestercredit">

</div></div>
<div class="row" style="padding-top:10px;">



<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#808080; font-size:18px;">
Is Enabled<span style="color:red;font-size: 25px;">*</span></div>

<div class="col-md-3">
<input type="radio" name="isenable" id="isenable1" value="1" checked="checked"> &nbsp Yes &nbsp;&nbsp;<input type="radio" name="isenable"id="isenable2" value="0">&nbsp No 
</div>
</div>

 <div class="row" >
<div class="col-md-6"></div>


<div class="col-md-6" style="color:#FC2338; font-size:18px;" id="errorisenable">

</div></div>





<div class="row" style="padding-top:10px;">
<div class="col-md-5"></div>

<div class="col-md-2"><input name="submit" value="Save" class="btn btn-success" type="submit" onClick="return validation()"></div>


<div class="col-md-2"><a href="list_semester.php"><input name="cancel" value="Cancel" class="btn btn-danger" type="button"></a></div>
</div>
                  
                 
                 <div class="row" style="padding-top:30px;"><center style="color:#006600;">
                 
                 </center>
                 </div>
                 
                    
                    </form>
                  
               </div>
               </div>
            
            	

</body>
</html>
<?php }
else
{
//edit semester

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
	
	
    echo "<script>alert('Ext  ".$dynamic_semester." id already present') </script>";
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

</head>
<script>
	function MyFunction1() { 
         var course = document.getElementById("courselevel").value;
       
         var department = document.getElementById("department").value;
         var branch = document.getElementById("branch").value;
         //alert(course);alert(department);
        
         $.ajax({
             type:"POST",
             data:{course:course,department:department}, 
             url:'get_sem_details.php',
             success:function(data)
             { //alert(data);
               $('#branch').html(data);
             }
             
             
         });
         
     }

</script>
<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

	<div class="container" style="padding:25px;">
        	
            
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   
                    
			<div style="background-color:#F8F8F8;">
                    
				<div class="row">
                <div class="col-md-4"></div>
              	<div class="col-md-5 " align="center" style="color:black;padding:5px;" ><h2>Edit <?php echo $dynamic_semester;?></h2></div>
                </div>
                <br>  
                 
                   
                  
		<div class="row">
             
              
	<div class="col-md-11">
            
<form method="post" >
                   
	
<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_level;?><span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<select name="courselevel" class="form-control " id="courselevel" onChange="MyFunction1()">
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


					  
<div class="row" style="padding-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Department Name<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<select name="department" class="form-control " id="department" onchange="MyFunction1()">
<option value="<?php echo $result['Department_Name'];?>" selected="selected"> <?php echo $result['Department_Name'];?></option>
<?php  $row=mysql_query("select id,Dept_code,trim(Dept_Name) as Dept_Name,ExtDeptId from tbl_department_master  where school_id='$sc_id' and Dept_Name!='' group by Dept_Name order by Dept_Name asc ");
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
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_branch;?> Name<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<select name="branch" class="form-control " id="branch">
<option value="<?php echo $result['Branch_name'];?>" selected="selected"><?php echo $result['Branch_name'];?></option>
<?php  $row=mysql_query("select Branch_code,branch_Name from  tbl_branch_master  where school_id='$sc_id' and branch_Name!=''");
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
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_class;?> Name<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<select name="class" class="form-control " id="classSem">
<option value="<?php echo $result['class'];?>" selected="selected"> <?php echo $result['class'];?></option>
<?php  $row=mysql_query("select id,trim(class) as class,ExtClassID,course_level from Class  where school_id='$sc_id' and class!='' group by class order by class asc");
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
<br>
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;"><?php echo $dynamic_semester;?> Name<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<input class="form-control" name="semname" id="semname"  type="text" value="<?php echo $result['Semester_Name'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-4" style="color:#FC2338; font-size:18px;" id="errorsemester"></div>
</div>
<br>
<div class="row">
<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Ext <?php echo $dynamic_semester;?> Id<span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<input class="form-control" name="extID" id="extID"  type="text" value="<?php echo $result['ExtSemesterId'];?>"/>
</div>
<div class="col-md-3" style="color:#FF0000;"></div>
</div>
	
	
	
<div class="row">
<div class="col-md-6"></div>
<div class="col-md-4" style="color:#FC2338; font-size:18px;" id="errorExtSemesterID"></div>
</div>
                      
  

<div class="row" style="margin-top:10px;">
<div class="col-md-4"></div>
<div class="col-md-3" style="color:#808080; font-size:18px;">Is_regular_<?php echo $dynamic_semester;?><span style="color:red;font-size: 25px;">*</span></div>
<div class="col-md-3">
<?php if($result['Is_regular_semester']==1){?>
Yes &nbsp;<input type="radio" name="isregular" value="1" id="regular1" checked="checked"/> &nbsp;
No &nbsp;<input type="radio" name="isregular" value="0" id="regular2"/>
<?php }else{?>
Yes &nbsp;<input type="radio" name="isregular" value="1" id="regular1"/> &nbsp;
No &nbsp;<input type="radio" name="isregular" value="0" id="regular2" checked="checked"/>
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
<div class="col-md-3" style="color:#808080; font-size:18px;">Is Enabled<span style="color:red;font-size: 25px;">*</span></div>
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
	
<?php } ?>
