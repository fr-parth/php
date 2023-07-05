<?php
	 include('stud_header.php');
	  if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}

	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 
	 $value = mysql_fetch_array($query);
	 $std_PRN=$value['std_PRN'];
	 $school_id=$value['school_id'];
	 
	 $query_points = mysql_query("select sum(sc_point) points from tbl_student_point where sc_stud_id = ".$_SESSION['id']." and sc_status = 'N'");
	 $row_points = mysql_fetch_array($query_points);


	  	 $sql2=mysql_query("select s.BranchName,s.DeptName,s.SemesterName,s.DivisionName, s.CourseLevel,s.AcdemicYear from StudentSemesterRecord s join tbl_academic_Year Y on Y.Year= s.AcdemicYear and Y.Enable='1' where s.IsCurrentSemester='1' and s.student_id='$std_PRN'");
	 $value2=mysql_fetch_array($sql2);
	 
	
	
	 
if(isset($_POST['update']))
{
$std_name=$_POST['std_complete_name'];
$gender=$_POST['gender'];
$dob=$_POST['datepicker'];

$dates = date('Y-m-d');
							
						
							 list($year,$month,$day) = explode("-",$dob);
								$year_diff  = date("Y") - $year;
								$month_diff = date("m") - $month;
								$day_diff   = date("d") - $day;
									if ($day_diff < 0 || $month_diff < 0) $year_diff--;
										$age= $year_diff;
//$age=$_POST['std_age'];

 $arr= mysql_query("update tbl_student set std_complete_name='$std_name',std_dob='$dob',std_gender='$gender',std_age='$age' where std_PRN='$std_PRN'");
  header('Location:student_profile1.php');

}


if(isset($_POST['update1']))
{

$std_password=$_POST['std_password'];
$std_phone=$_POST['std_phone'];
$std_email=$_POST['std_email'];
$address=$_POST['address'];
//$age=$_POST['std_age'];

 $arr= mysql_query("update tbl_student set std_password='$std_password',std_phone='$std_phone',std_email='$std_email', permanent_address='$address' where std_PRN='$std_PRN'");
  header('Location:student_profile1.php');
}




	
?>
	 
	 
	 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>

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







</style>

 <script src='js/jquery.min.js' type='text/javascript'></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
<script type="text/javascript" src="js/jquery.form.js"></script> 
<script type="text/javascript">
$(document).ready(function() 
{ 
 
$('#photoimg').live('change', function()	
{

$("#mypicture").html('');
$("#mypicture").html('<img src="image/loader.gif" alt="Uploading...."/>');
$("#imageform").ajaxForm(
{

target: '#mypicture'
}).submit();
});


  
});
</script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script>
function mouseoverPass(obj)
 {
   var obj = document.getElementById('std_password');
  obj.type = "text";
}
function mouseoutPass(obj) {
  var obj = document.getElementById('std_password');
  obj.type = "password";
}
</script>

   
  

<script>
document.getElementById("cancel").innerHTML = '';
    function myFunction()
    {
	document.getElementById("cancel").innerHTML = '<input type="button" class="btn btn-danger pull-right text-center" value="Cancel" onclick="myFunction1()" >';
	
	  document.getElementById('std_name').innerHTML='<input type="text" name="std_complete_name" id="std_complete_name" value="<?php echo $value['std_complete_name'];?>"  >';
	document.getElementById("gender").innerHTML='<input type="radio" name="gender" id="gender1" value="Male" checked > Male <input type="radio" name="gender" id="gender2" value="Female" >Female';
	
	document.getElementById("datepicker1").innerHTML='<input type="date" id="datepicker" name="datepicker">';
	
	 
		 document.getElementById('errorpoints').innerHTML='<input type="submit" class="btn btn-primary  text-center" name="update" value="Update">';
    }
	
	  function myFunction1()
    {
	document.getElementById("cancel").innerHTML = '';
	// var read=document.getElementById("std_complete_name").removeAttribute("readonly",0);
	  document.getElementById('std_name').innerHTML='<?php echo $value['std_complete_name'];?>';
	document.getElementById("gender").innerHTML='<?php echo $value['std_gender'];?>';
	
	document.getElementById("datepicker1").innerHTML='<?php echo $value['std_dob'];?>';
	
	 
		 document.getElementById('errorpoints').innerHTML='<input type="button" class="btn btn-primary pull-right text-center" name="Edit" value="Edit" onclick="myFunction()">';
    }
	
	  function myFunction2()
    {
	document.getElementById("cancel1").innerHTML = '<input type="button" class="btn btn-danger pull-right text-center" value="Cancel" onclick="myFunction3()" >';
	
	  document.getElementById('password').innerHTML='<input type="password" name="std_password" id="std_password" value="<?php echo $value['std_password'];?>"  ><span class="glyphicon " onmouseover="mouseoverPass();" onmouseout="mouseoutPass();">Show</span>' ;
	document.getElementById("phone").innerHTML='<input type="text" name="std_phone" id="std_phone" value="<?php echo $value['std_phone'];?>"   onkeypress="return isNumberKey(event)" >';
	
	document.getElementById("email").innerHTML='<input type="text" id="std_email" name="std_email" value="<?php echo $value['std_email'];?>">';    	document.getElementById("internalemail").innerHTML='<input type="text" id="internalemail" name="std_email" value="<?php echo $value['Email_Internal'];?>">';	
	document.getElementById("std_address").innerHTML=' <textarea  id="address" name="address" rows="3"> <?php echo $value['permanent_address'];?></textarea>';
	
	 
		 document.getElementById('errorpoints1').innerHTML='<input type="submit" class="btn btn-primary pull-right text-center" name="update1" value="Update"  onclick=" return validcontact()" >';
    }
	
	  function myFunction3()
    {
	document.getElementById("cancel1").innerHTML = '';
	
	  document.getElementById('password').innerHTML='***';
	document.getElementById("phone").innerHTML='<?php echo $value['std_phone'];?>';
	
	document.getElementById("email").innerHTML='<?php echo $value['std_email'];?>';	document.getElementById("internalemail").innerHTML='<?php echo $value['Email_Internal'];?>';
	document.getElementById("std_address").innerHTML='<?php echo $value['permanent_address'];?>';
	
	 
		 document.getElementById('errorpoints1').innerHTML='<input type="button" class="btn btn-primary pull-right text-center" name="Edit" value="Edit" onclick="myFunction2()">';
    }
	
	
	
	function mypic()
	{
	 document.getElementById('eroorpic').innerHTML=' <input type="file" name="photoimg" id="photoimg" />';
	 document.getElementById("cancel2").innerHTML = '<input type="button" class="btn btn-danger text-center" value="Cancel"  onclick="mypiccancel()" >';
	
	}
	
	function mypiccancel()
	{
	 document.getElementById("cancel2").innerHTML='';
	 document.getElementById('eroorpic').innerHTML='<input type="button" class="btn btn-primary text-center" onclick="mypic()" value="Edit">';
	 document.getElementById('mypicture').innerHTML='<?php if(  $value['std_img_path']==""){?><img id="imgprvw" name="img" src="image/avatar_2x.png" width="120" height="100" class="preview" /><?php }else{ ?><img src='<?php echo $value['std_img_path'] ?>' width="120" height="120" class="preview" /><?php }?>';
	 
	}
	
	
	function validcontact()
{

 var std_password=document.getElementById("std_password").value;
var std_phone=document.getElementById("std_phone").value;
 

 var std_email=document.getElementById("std_email").value;
 
 regx1=/^[A-z ]+$/;
		 if(std_password==null||std_password=="")
			{
			   
				alert("Please Enter Password");
				return false;
				
			}
			
			
			else if(std_phone==null||std_phone=="")
			{
			
			   
				alert("Please Enter Phone No");
				return false;
			}
				


 		else if(std_email==null||std_email=="")
			{
			   
				alert("Please Enter Email Id");
				return false;
			}
		
		
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  

			  if(!std_email.match(mailformat))  
				{  
					alert("Please Enter valid Email Id");
				return false;
				} 

			
			
		
}
	
	
	 
</script>




       
</head>

<body style="background-color:#EAEAEA;">
 
 
 
 <div class="container">
  <div class="row" style="padding-top:20px;">
  <div class="col-md-12">

      <div  class="col-md-12" style="border:1px solid #CCCCCC; background-color:#FFFFFF; padding-top:5px;">
        	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; background-color:#FFFFFF;">
                    <div style="padding:2px 2px 2px 2px; background-image:url(image/images_.jpg); color:#FFFFFF; ">
                    Profile
                    </div></div>
                    
                    
 <table width="100%"><form id="imageform" method="post" enctype="multipart/form-data"  action="ajaxpic.php">
                    <tr>
                    
                    
                    <td style="width:35%;"></td>
                    <td style="width:15%;" id="mypicture"><?php if(  $value['std_img_path']==""){?><img  src='image/avatar_2x.png' width="120" height="100" class="preview" /><?php }else{ ?><img src='<?php echo $value['std_img_path'] ?>' width="120" height="120" class="preview" /><?php }?></td>
                    
                    <td><b><?php  if($value['std_complete_name']=="")
					{
						echo ucwords(strtolower($value['std_name']." ".$value['std_lastname']));
					}
						
						else{
							
					echo ucwords(strtolower($value['std_complete_name']));
					
					
						}?></b><br /> <?php  echo $value['std_school_name']; ?><br />
                    <?php echo $value['std_PRN'];?>
                    
                    </td></tr>
                    
                    <tr><td></td><td style="padding-top:12px;" id="eroorpic"><a href="update_student_profile.php?id=1"><input type="button" class="btn btn-primary text-center"  value="Edit"></a></td> <td id="cancel2"> </td></tr>
                    </table>
                   </form>
                    <div style="padding-top:3px;">
                    <hr style="border-bottom:2px solid #ccc;"/>
                 </div>
                  
                    
                    
                    
                    
                    
                 	
                   <div class="table-info" >
                   <div class="row">
                   <div class="col-md-12">
                   
                   <div class="col-md-6">
                   <form method="post">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Basic Information </caption>
   
   <thead>
      <tr>
         <th>Name</th>
         <th id="std_name"><?php if($value['std_complete_name']=="")
		 {
			 echo ucwords(strtolower($value['std_name']." ".$value['sd_lastname']));
			 
		 }	 
		 else
		 {
			 
			 echo ucwords(strtolower($value['std_complete_name']));
		 }
		 
		 
		 ?> </th>
      </tr>
   </thead>
   
   <tbody>
      <tr>
         <td><b>Gender</b></td>
         <td id="gender" ><?php echo $value['std_gender'];?></td>
      </tr>
      
      <tr>
           <td><b>Date of birth</b></td>
         <td id="datepicker1"><?php echo $value['std_dob'];?></td>
      </tr>
      
       
      
     
        <tr>
        
         <td id="cancel"> </td>
<td id="errorpoints"><input type="button" class="btn btn-primary pull-right text-center" onclick="myFunction()" value="Edit"></td>
      </tr>
     </tbody>
</table>

</form>


                   </div>
                   <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Education Details </caption>
   <thead>
      <tr>
         <th style="width:126px;">College Name</th>
         <th id="school_name"><?php echo $value['std_school_name'];?></th>
      </tr>
   </thead>
   
   <tbody>
      
      
      <tr>
           <td><b>Student PRN</b></td>
         <td id="std_PRN"><?php echo $value['std_PRN'];?></td>
      </tr>
      
      <tr>
         <td><b>Department</b></td>
         <td id="dept"><?php echo $value['std_dept'];?></td>
      </tr>
      
         <tr>
           <td><b>Branch</b></td>
         <td id="branch"><?php echo $value['std_branch'];?></td>
         
         
      </tr>
      
      
         <tr>
           <td><b>Class</b></td>
           
         <td id="branch"><?php echo $value['std_class']?></td>
         
         
      </tr>
      
      
      
       
      
           <tr>
           <td><b>Division</b></td>
         <td id="branch"><?php
		 echo $value2['DivisionName'];
	?></td>
      </tr>
      
    
      
  
      
      <tr>
          <td></td>
         <td> <div class="edt-b clearfix text-center" style="" >

<input type="button" class="btn btn-primary pull-right text-center" value="Edit"  style="background-color:#FFFFFF;border-color:#FFFFFF">

</div></td>
      </tr>
      
   </tbody>
	
</table>


                   </div>
                   
                   
                                 
                   
                    <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Activity Graph</caption>
   
   
</table>
<iframe src="fusioncharts/index.php" width="100%" height="330" frameBorder="0" scrolling="no"></iframe>


                   </div>
                   
                   
                   
                   
                   
                     <div class="col-md-6">
                     <form method="post">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Contact Details</caption>
   
   <thead>
      <tr>
         <th>Password</th>
         <th id="password">***</th>
      </tr>
      
     
   </thead>
  
   
   <tbody>
      <tr>
         <td><b>Mobile Number</b></td>
         <td id="phone"><?php echo $value['std_phone'];?></td>
      </tr>
      
           
       <tr>
           <td><b>Email ID</b></td>
         <td id="email"><?php echo $value['std_email'];?></td>
      </tr>	  <tr>           <td><b>Internal Email ID</b></td>         <td id="internalemail"><?php echo $value['Email_Internal'];?></td>      </tr>
      
    
      <tr>
           <td><b>Address</b></td>
         <td id="std_address"><?php echo $value['permanent_address'];?></td>
      </tr>
     
      
     
        <tr>
          <td></td>
         <td> <div class="row"  >
         <div class="col-md-4"></div>
<div id="cancel1" class="col-md-4"></div>
<div id="errorpoints1" class="col-md-4"><input type="button" class="btn btn-primary pull-right text-center" onclick="myFunction2()" value="Edit"></div>

</div></td>
      </tr>
   </tbody>
	
</table></form>



                   </div>
                   
                   
                   
                   
                   </div>
                   </div>
                   </div>
                    
                    
               </div>
           </div>
        </div>
        </div>

</body>
</html>
















