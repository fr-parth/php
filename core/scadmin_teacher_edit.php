<?php

     include_once('scadmin_header.php');

     $report="";
	 $teacher_id1=$_GET['t_id'];
	 
	 
	 $results=$smartcookie->retrive_individual($table,$fields);

	$result=mysql_fetch_array($results);
	$school_id=$result['school_id'];

$res= mysql_query("select * from tbl_teacher where t_id='$teacher_id1' and school_id='$school_id'");
$values = mysql_fetch_array($res);
$id=$values['id'];
$query = mysql_query("select * from tbl_teacher where id ='$id'");
$value = mysql_fetch_array($query);
 
$sc_id=$value['school_id'];
$teacher_id=$value['id'];
$t_id=$value['t_id'];

?>
<?php
$report="";
$report1="";
$report2="";
$report3="";


        if(isset($_POST['update']))
		 {
		      $t_name=$_POST['std_complete_name'];
		      $date=$_POST['datepicker1'];
			  $dates = date('Y-m-d');
			  @list($year,$month,$day) = explode("-",$date);
			  $year_diff  = date("Y") - $year;
			  $month_diff = date("m") - $month;
			  $day_diff   = date("d") - $day;
			  if ($day_diff < 0 || $month_diff < 0) $year_diff--;
			    $age= $year_diff;
			  
			  $t_gender=$_POST['gender'];
			  $quelification=$_POST['qualification'];
			  
		//	echo "</br>update tbl_teacher set t_name='$t_name',t_qualification='$quelification',t_dob='$date',t_age='$age',t_gender='$t_gender' where id='$t_id'";
	$arr= mysql_query("update tbl_teacher set t_complete_name='$t_name',t_qualification='$quelification',t_dob='$date',t_age='$age',t_gender='$t_gender' where t_id ='$t_id'");
			  
		if(mysql_affected_rows()>=0)
			  {
			  	$report="successfully Updated";
			  }
		 }
//-----------------------------------------------------------WorkPlanceUpdate---------------------------------------------------------------------		 
		 
		 
		 if(isset($_POST['workplaceUpdate']))
		 {
		   
		    $Department=$_POST['Department'];
			$Experience=$_POST['Exp'];
		  //  $Appointment=$_POST['Appointment'];
			$EmployeeID=$_POST['EmployeeID'];
			
/*echo "update tbl_teacher set t_dept='$Department',t_exprience='$Experience',t_date_of_appointment='$Appointment',t_emp_type_pid='$EmployeeID' where t_id ='$t_id'";
	die;*/
	$arr= mysql_query("update tbl_teacher set t_dept='$Department',t_exprience='$Experience',t_emp_type_pid='$EmployeeID' where t_id ='$t_id'");
			  
			  if(mysql_affected_rows()>=0)
			  {
			  	$report1="successfully Updated";
			  }
		 }
		 
//-----------------------------------------------------------ContactDetails---------------------------------------------------------------------		 
		 
		  if(isset($_POST['contactdetailsUpdate']))
		 {
		    $Pss=$_POST['Pss'];
		    $MobileNo=$_POST['Mobile_No'];
		    $Landline=$_POST['Landline_No'];
			$Email=$_POST['Email_id'];
			$InternalEmail=$_POST['Internal_Email'];
		    $Address=$_POST['Address1'];
			$Pincode=$_POST['Pincode_no'];
			  
		//	  echo "update tbl_teacher set t_password='$Pss',t_phone='$MobileNo',t_landline='$Landline',t_email='$Email',t_internal_email='$InternalEmail',t_address='$Address',t_permanent_pincode='$Pincode' where t_id ='$t_id'";
	
	
	$arr= mysql_query("update tbl_teacher set t_password='$Pss',t_phone='$MobileNo',t_landline='$Landline',t_email='$Email',t_internal_email='$InternalEmail',t_address='$Address',t_permanent_pincode='$Pincode' where t_id ='$t_id'");
			  
			  if(mysql_affected_rows()>=0)
			  {
			  	$report2="successfully Updated";
			  }
		 }
		 
//-----------------------------------------------------------My Class---------------------------------------------------------------------		 
		 if(isset($_POST['myclassUpdate']))
		 {
		  $class=$_POST['class'];
		   
			  
			  /*echo "</br>update tbl_teacher set class='$class' where t_id ='$t_id'";
	die;*/
	
	$arr= mysql_query("update tbl_teacher set t_class='$class' where t_id ='$t_id'");
			  
			  if(mysql_affected_rows()>=0)
			  {
			  	$report3="successfully Updated";
			  }
		    }
             ?> 
		 
		 
          
             
             
             
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Profile::Smart Cookies</title>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/accordian.js"></script>



</head>
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

<body>

 
 
 <div class="container">
  <div class="row" style="padding-top:20px;">
  <div class="col-md-12">

      <div  class="col-md-12" style="border:1px solid #CCCCCC; background-color:#FFFFFF; padding-top:5px;">
        	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; background-color:#FFFFFF;">
                    <div style="padding:2px 2px 2px 2px; background-image:url(image/images_.jpg); color:#FFFFFF; ">
                    Profile
                    </div></div>
                    
                    
 <table width="100%">
                    <tr>
                    	<td style="width:49%" align="center">
<p style="font-size:24px; color:#0080FF;">
                			<?php
							if(  $value['t_pc']==""){?><img id="imgprvw" name="img" src='image/avatar_2x.png' width="120" height="100" class="preview" /><?php }else{ ?><img src='<?php echo $value['t_pc'] ?>' width="120" height="120" class="preview" /><?php }?></p>
                <p style="size:18px; padding-bottom::15px; margin-bottom:18px; border-bottom:2px solid #ccc;"><a href="update_teacher_profile.php?id=1">Edit</a></p>
                 <p style="size:18px; padding-bottom::15px; margin-bottom:18px; border-bottom:2px solid #ccc;"><a href="remove_teacher_profile.php?id=<?php echo  $t_id ;?>">Remove</a></p>
                    </td>
                    </tr>
                    
</table>
           
                       

   


<script>
function mouseoverPass(obj)
 {
 //alert('onmouseoverpass');
  var obj = document.getElementById('Pss');
  obj.type = "text";
  
		
		
}
function mouseoutPass(obj) {
  var obj = document.getElementById('Pss');
  obj.type = "password";
  
			
		
}
</script>

  <script>
document.getElementById("cancel").innerHTML = '';

function mybasicinfo()
	{
	var qualification=document.getElementById("qualification").value;	
	
	if(qualification=="")
			{
			   
				document.getElementById('errorqua').innerHTML='Please Enter Qualification';
				
				return false;
			}
			var qualification=document.getElementById("qualification").value;	
	
 var letters = /^[a-zA-Z\s-, ]+$/;  
 if(!( qualification.match(letters)))  
			{
			   
				document.getElementById('errorqua').innerHTML='Please Enter  valid Qualification';
				
				return false;
			}
	           
	var datepicker=document.getElementById("datepicker1").value;	
	if(datepicker=="")
			{
		
				document.getElementById('errordate').innerHTML='Please Enter date';
				
				return false;
			}
			
			var name =document.getElementById("std_complete_name").value;
			 
			 
			   var letters = /^[a-zA-Z\s-, ]+$/;  
   if(!(name.match(letters)))  
     {  
      	document.getElementById('errorname').innerHTML='Please Enter valid name';
     return false;  
     }  
			 
	
			
			
			
	}                       
	
function valid_exp()

{
	
	var Exp=document.getElementById("Exp").value;
	
	
		if (Exp.length > 3 )
			{
              document.getElementById('errorexp').innerHTML='Please Enter valid experience';
						   
						   return false; 
           }
		
	
	if (Exp < 0 )
			{
              document.getElementById('errorexp').innerHTML='Please Enter valid experience';
						   
						   return false; 
           }
	
			if(Exp=="")
			{
			   
				document.getElementById('errorexp').innerHTML='Please Enter experience';
				
				return false;
			}
			
			
			
			if(isNaN(Exp)|| Exp.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorexp').innerHTML='Please Enter valid experience';
						   
						   return false; 
						   
				}
				
	
}

 function valid_contact()
    {
		var password=document.getElementById("Pss").value;
			if(password=="")
			{
				alert("Please Enter Your Password");
				 return false; 
			}
		
		
		
		var id_phone=document.getElementById("Mobile_No").value;
			if(id_phone=="")
			{
			   
				document.getElementById('errorphone').innerHTML='Please Enter Phone no';
				
				return false;
			}
			
			
			
			if(isNaN(id_phone)|| id_phone.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
						   
				}
				
				
				
				if (id_phone.length > 10 )
			{
              document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
           }
		   
		   
		   if (id_phone.length < 10 )
			{
              document.getElementById('errorphone').innerHTML='Please Enter valid Phone no';
						   
						   return false; 
           }
		  /* var password=document.getElementById("Pss").value;
			if(password=="")
			{
			   
				document.getElementById('password').innerHTML='Please Enter Password';
				
				return false;
			}
			*/
			
			
			
			var Landline_No=document.getElementById("Landline_No").value;
			if(Landline_No=="")
			{
			   
				document.getElementById('errorlandline').innerHTML='Please Enter Landline no';
				
				return false;
			}
			
			
			
			if(isNaN(Landline_No)|| Landline_No.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorlandline').innerHTML='Please Enter valid Landline no';
						   
						   return false; 
						   
				}

				
				
				
			//var LandlineNo	=/^[0-9]\d{2,4}-\d{6,8}$/;
			 //var Landline_No=document.getElementById("Landline_No").value;
			if(Landline_No.length < 6)
			{
					document.getElementById('errorlandline').innerHTML='Please Enter valid Landline_No ';
					  return false; 
						   
			}
			if(Landline_No.length > 12)
			{
					document.getElementById('errorlandline').innerHTML='Please Enter valid Landline_No ';
					  return false; 
						   
			}
				
				
			     var email=document.getElementById("Email_id").value;
				  var InternalEmail=document.getElementById("Internal_Email").value;
				  
		if(email==null||email=="")
			{
			   
				document.getElementById('erroremail').innerHTML='Please enter email ID';
				
				return false;
			}	
	  
	  		  
		if(InternalEmail==null||InternalEmail=="")
			{
			   
				document.getElementById('errorinternalemail').innerHTML='Please enter email ID';
				
				return false;
			}	
	  
	  
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
			  if(!email.match(mailformat))  
				{  
				document.getElementById('erroremail').innerHTML='Please Enter valid email ID';

				return false;  
				} 
				
				  if(!InternalEmail.match(mailformat))  
				{  
				document.getElementById('errorinternalemail').innerHTML='Please Enter valid email ID';

				return false;  
				} 
				
				
				var Pincode_no=document.getElementById("Pincode_no").value;
			if(Pincode_no=="")
			{
			   
				document.getElementById('errorpincode').innerHTML='Please Enter pincode';
				
				return false;
			}
			
			
			
			if(isNaN(Pincode_no)|| Pincode_no.indexOf(" ")!=-1)
			  {			  
			       
				   document.getElementById('errorpincode').innerHTML='Please Enter valid pincode';
						   
						   return false; 
						   
				}
				
				var Address = document.getElementById("Address1").value;
			
			
				if(Address=="")
			{
				//alert('enter address');
			   
				document.getElementById('erroraddress').innerHTML='Please enter Adress';
				
			return false;
			}	
	  
				var Pincode_no=document.getElementById("Pincode_no").value;
			if(Pincode_no.length!=6)
			{
			   
				document.getElementById('errorpincode').innerHTML='Please Enter valid no pincode';
				
				return false;
			}
			
				
		
		
	}

 function myFunction()
    {
	document.getElementById("cancel").innerHTML='<input type="button" class="btn btn-danger" value="Cancel" onclick="myFunction1()">';
	
	document.getElementById('std_name').innerHTML='<input type="text" name="std_complete_name"  id="std_complete_name" value="<?php echo $value['t_complete_name'];?>">';
    document.getElementById("gender").innerHTML='<input type="radio" name="gender" id="gender1" value="Male" checked > Male <input type="radio" name="gender" id="gender2" value="Female" >Female';
	document.getElementById("datepicker").innerHTML='<input type="date" min="1950-01-01" max="2000-01-01" id="datepicker1" name="datepicker1" value="<?php echo $value['t_dob'];?>" >';
	document.getElementById("age").innerHTML='<input type="text" id="std_age" name="std_age" value="<?php echo $value['t_age'];?>" disabled>';
	document.getElementById("quali").innerHTML='<input type="text" id="qualification" name="qualification" value="<?php echo $value['t_qualification'];?>">';
	document.getElementById('errorpoints').innerHTML='<input type="submit" class="btn btn-primary pull-right text-center" name="update" value="Update" onclick="return mybasicinfo()">';
    }
	
	
	
function myFunction1()
    {
	document.getElementById("cancel").innerHTML = '';
	// var read=document.getElementById("std_complete_name").removeAttribute("readonly",0);
	document.getElementById('std_name').innerHTML='<?php echo $value['t_complete_name'];?>';
	document.getElementById("gender").innerHTML='<?php echo $value['t_gender'];?>';
	document.getElementById("datepicker").innerHTML='<?php echo $value['t_dob'];?>';
	document.getElementById("age").innerHTML='<?php echo $value['t_age'];?>';
	document.getElementById("quali").innerHTML='<?php echo $value['t_qualification'];?>';
	document.getElementById('errorpoints').innerHTML='<input type="button" class="btn btn-primary pull-right text-center" name="Edit" value="Edit" onclick="myFunction()">';
    }
	
	
	function myFunction2()
    {
	document.getElementById("cancel1").innerHTML='<input type="button" class="btn btn-danger" value="Cancel" onclick="myFunction3()">';
	
	document.getElementById('College').innerHTML='<input type="text" size="27" id="College" name="College" value="<?php echo $value['t_current_school_name'];?>" disabled="disabled"/>';
    document.getElementById("Department").innerHTML='<input type="text" size="27" id="Department" name="Department" value="<?php echo $value['t_dept'];?>" disabled="disabled"/>';
    document.getElementById("TeacherID").innerHTML='<input type="text" size="27" id="TeacherID" name="TeacherID" value="<?php echo $value['t_id'];?>" disabled="disabled"/>';
	document.getElementById("Experience").innerHTML='<input type="text" size="27" id="Exp" name="Exp" value="<?php echo $value['t_exprience'];?>"/>';
	//document.getElementById("Appointment").innerHTML='<input type="text" size="27" id="Appointment" name="Appointment" value="<?php echo $value['t_date_of_appointment'];?>"/>';
	document.getElementById("EmployeeID").innerHTML='<input type="text" size="27" id="EmployeeID" name="EmployeeID" value="<?php echo $value['t_emp_type_pid']; ?>"  />';
	
	document.getElementById('errorpoints1').innerHTML='<input type="submit" class="btn btn-primary pull-right text-center" name="workplaceUpdate" value="Update" onClick="return valid_exp()">';
    }
	
	
	
function myFunction3()
    {
	document.getElementById("cancel1").innerHTML = '';
	// var read=document.getElementById("std_complete_name").removeAttribute("readonly",0);
	document.getElementById('College').innerHTML='<?php echo $value['t_current_school_name'];?>';
	document.getElementById("Department").innerHTML='<?php echo $value['t_dept'];?>';
	document.getElementById("TeacherID").innerHTML='<?php echo $value['t_id'];?>';
	document.getElementById("Experience").innerHTML='<?php echo $value['t_exprience'];?>';
	//document.getElementById("Appointment").innerHTML='<?php echo $value['t_date_of_appointment'];?>';
	document.getElementById("EmployeeID").innerHTML='<?php echo $value['t_emp_type_pid'];?>';
	
document.getElementById('errorpoints1').innerHTML='<input type="button" class="btn btn-primary pull-right text-center" name="Edit" value="Edit" onclick="myFunction2()">';
    }
	
	
	function myFunction4()
    {
	
	document.getElementById("cancel2").innerHTML='<input type="button" class="btn btn-danger" value="Cancel" onclick="myFunction5()">';
	
	document.getElementById('Pss').innerHTML='<input type="text" size="27" id="Pss" name="Pss" value="<?php echo $value['t_password'];?>"/>';
    document.getElementById("MobileNo").innerHTML='<input type="text" size="27" id="Mobile_No" name="Mobile_No" value="<?php echo $value['t_phone'];?>"/>';
    document.getElementById("Landline").innerHTML='<input type="text" size="27" id="Landline_No" name="Landline_No" value="<?php echo $value['t_landline'];?>"/>';
	document.getElementById("Email").innerHTML='<input type="text" size="27" id="Email_id" name="Email_id" value="<?php echo $value['t_email'];?>"/>';
	document.getElementById("InternalEmail").innerHTML='<input type="text" size="27" id="Internal_Email" name="Internal_Email" value="<?php echo $value['t_internal_email'];?>"/>';
	document.getElementById("Address").innerHTML='<input type="text" size="27" id="Address1" name="Address1" value="<?php echo $value['t_address'];?>"/>';
	document.getElementById("Pincode").innerHTML='<input type="text" size="27" id="Pincode_no" name="Pincode_no" value="<?php echo $value['t_permanent_pincode'];?>"/>';
	
	document.getElementById('errorpoints2').innerHTML='<input type="submit" class="btn btn-primary pull-right text-center" name="contactdetailsUpdate" value="Update" onClick="return valid_contact()">';
    }
	
	
	
function myFunction5()
    {
	document.getElementById("cancel2").innerHTML = '';
	// var read=document.getElementById("std_complete_name").removeAttribute("readonly",0);
	document.getElementById('Pss').innerHTML='<input type="password" size="27" id="Pss" name="Pss" value="<?php echo $value['t_password'];?>" disabled="disabled" /><span class="glyphicon glyphicon-eye-open" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();"></span>';
	document.getElementById("MobileNo").innerHTML='<?php echo $value['t_phone'];?>';
	document.getElementById("Landline").innerHTML='<?php echo $value['t_landline'];?>';
	document.getElementById("Email").innerHTML='<?php echo $value['t_email'];?>';
	document.getElementById("InternalEmail").innerHTML='<?php echo $value['t_internal_email'];?>';
	document.getElementById("Address").innerHTML='<?php echo $value['t_address'];?>';
	document.getElementById("Pincode").innerHTML='<?php echo $value['t_permanent_pincode'];?>';
	
document.getElementById('errorpoints2').innerHTML='<input type="button" class="btn btn-primary pull-right text-center" name="Edit" value="Edit" onclick="myFunction4()">';
    }
	
	
</script>  



                   <div class="table-info">
                   <div class="row">
                   <div class="col-md-12">
                   
         <form name="myform" method="post">    
                   <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Basic Information </caption>
   
   <thead>
      <tr>
         <th>Name</th>
         <th id="std_name"><?php echo $value['t_complete_name'];?></th>
      </tr> <td id="errorname" style="color:red;"></td>
   </thead>
   
   <tbody>
      <tr>
         <td><b>Gender</b></td>
         <td id="gender"><?php echo $value['t_gender'];?> </td>
      </tr>
      
      <tr>
           <td><b>Date of birth</b></td>
         <td  id="datepicker"><?php echo $value['t_dob'];?></td>
      </tr>
       <td id="errordate" style="color:red;"></td>
       <tr>
           <td><b>Age</b></td>
           <td id="age"><?php echo $value['t_age'];?></td>
        
      </tr>
      
      <tr>
         <th>Qualification</th>
          <td id="quali"><?php echo $value['t_qualification'];?></td>
         
      </tr>  <td id="errorqua" style="color:red;"></td>
      
        <tr>
          <td></td>
         <td> 
         <div class="row"  >
         <div class="col-md--2"></div>
<div id="cancel" class="col-md-7"></div>
<div id="errorpoints" class="col-md-4"><input type="button" class="btn btn-primary pull-right text-center" onclick="myFunction()" value="Edit"></div>

</div>


</td>
      </tr>
     </tbody>
</table>


</form>
<!---------------------------------------------------------------------Work Place------------------------------------------------------------------------------------->
           </div>
                   <form  name="" method="post">
                   <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Work Place </caption>
   <thead>
      <tr>
         <th> <?php echo ($_SESSION['usertype']=='Manager')? 'Organization ':'College';?> Name</th>
         <th id="College"><?php echo $value['t_current_school_name'];?></th>
      </tr>
   </thead>
   
   <tbody>
      <tr>
         <td><b>Department</b></td>
         <td id="Department"><?php echo $value['t_dept'];?></td>
      </tr>
      
      <tr>
           <td><b> <?php echo ($_SESSION['usertype']=='Manager')? 'Manager':'Teacher';?> Id</b></td>
         <td id="TeacherID"><?php echo $value['t_id'];?></td>
      </tr>
      
       <tr>
           <td><b>Experience</b></td>
         <td id="Experience"><?php echo $value['t_exprience'];?></td>
      </tr>
	   <td id="errorexp" style="color:red;"></td>
     
      <tr>
           <td><b>Employee type Id</b></td>
           <td id="EmployeeID"><?php echo $value['t_emp_type_pid'];?></td>
      </tr>
      
      <tr>
          <td></td>
          <td> <div class="row"  >
         <div class="col-md--2"></div>
<div id="cancel1" class="col-md-7"></div>
<div id="errorpoints1" class="col-md-4"><input type="button" class="btn btn-primary pull-right text-center" onclick="myFunction2()" value="Edit"></div>

</div></td>
      </tr>
      
   </tbody>
	
</table>


                   </div>
     </form>              
  <!---------------------------------------------------------------------Contact Details------------------------------------------------------------------------------------->
                 
                                 
        <form  name="ContactDetails" method="post">            
                    <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">Contact Details</caption>
   
   <thead>
      <tr>
         <th>Password</th>
         <th id="Pss"><input type="password" size="27" style="background-color:#CCCCCC; border:none;" id="Pss" name="Pss" value="<?php echo $value['t_password'];?>"  required /><span class="glyphicon glyphicon-eye-open" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();"></span></th>
        
      </tr>
   </thead>
   
   <tbody>
      <tr>
         <td><b>Mobile Number</b></td>
         <td id="MobileNo"><?php echo $value['t_phone'];?></td>
      </tr>
	   
         <td id="errorphone" style="color:red;"></td>
         
  
      
      <tr>
           <td><b>Landline</b></td>
         <td id="Landline"><?php echo $value['t_landline'];?></td>
      </tr>
	   <td id="errorlandline" style="color:red;"></td>
	  
      
       <tr>
           <td><b>Email ID</b></td>
         <td id="Email"><?php echo $value['t_email'];?></td>
      </tr>
	     <td id="erroremail" style="color:red;"></td>
	  
      
      <tr>
           <td><b>Internal Email ID</b></td>
         <td id="InternalEmail"><?php echo $value['t_internal_email'];?></td>
      </tr>
	   <td id="errorinternalemail" style="color:red;"></td>
	  
      <tr>
           <td><b>Address</b></td>
         <td id="Address"><?php echo $value['t_address'];?></td>
      </tr>
      <td id="erroraddress" style="color:red;"></td>
      
      <tr>
           <td><b>Pincode</b></td>
         <td id="Pincode"><?php echo $value['t_permanent_pincode'];?></td>
      </tr>
	  <td id="errorpincode" style="color:red;"></td>
	  
      
      <tr>
          <td></td>
         <td> <div class="row">
         <div class="col-md--2"></div>
<div id="cancel2" class="col-md-7"></div>
<div id="errorpoints2" class="col-md-4"><input type="button" class="btn btn-primary pull-right text-center" onclick="myFunction4()" value="Edit"></div>

</div></td>
      </tr>
      
   </tbody>
	
</table>



                   </div>
                   
                   
                   
                   
                   
    </form> 
    <?php 
   if($_SESSION['usertype']=='Manager'){
		   ?>
          
		   
		<?php   
		   }
		   else{
	?>    
     <form  name="myclass1" method="post">                 
                   
                    <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">My Class</caption>
   <?php
                $arr=mysql_query("SELECT distinct st.`Semester_id`,s.class,st.Branches_id,st.CourseLevel
FROM  `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1' inner join tbl_semester_master s on s.Semester_Name=st.Semester_id and st.Branches_id=s.Branch_name and s.CourseLevel=st.CourseLevel
WHERE  st.`teacher_id` ='$t_id' and st.school_id='$sc_id'");
                      $result=mysql_fetch_array($arr)
					  
					  
   
   ?>
   <thead>
      <tr>
         <th>Class</th>
         <th><?php echo $result['class']?></th>
      </tr>
   </thead>
   
   <tbody>
      <tr>
          <td></td>
         <td><?php echo $report3; ?> </td>
      </tr>
      
   </tbody>
	
</table>


                   </div>
                   
  </form>
    <?php
	 }
	 ?>              
                   
                   
      
  
  <!-- <form  name="MySubject" method="post">                 
                   
                    <div class="col-md-6">
                <table class = "table" style="border:1px solid #ccc">
   <caption class="text-center" style="background-color:#ccc; font-size:18px; padding:13px 0px; color:#000;">My Subject</caption>
   <?php
   
                  //	  $branch_name=$result['Branch_name'];
					//  $Semester_id=$result['Semester_id'];
					//  $CourseLevel=$result['CourseLevel'];
					  
					  
                //$arr1=mysql_query("SELECT distinct st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1' inner join tbl_semester_master s on s.Semester_Name=st.Semester_id and st.Branches_id=s.Branch_name and s.CourseLevel=st.CourseLevel WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'");
                      //$result1=mysql_fetch_array($arr1)
   
   ?>
   <thead>
      <tr>
         <th>Class</th>
         <th><input type="text" size="27" id="class" name="class" value="<?php //echo $result1['subjectName']?>" disabled="disabled" /></th>
      </tr>
   </thead>
   
   <tbody>
      <tr>
          <td></td>
         <td><?php// echo $report3; ?> <div class="edt-b clearfix text-center" style="">
            <input type="button" id="myclassEdit" class="btn btn-primary pull-right text-center" name="basic" onClick="myclass()" value="Edit">
            <input type="submit" id="myclassUpdate" class="btn btn-primary pull-center text-center" name="myclassUpdate" disabled="disabled" value="Update">
</div></td>
      </tr>
      
   </tbody>
	
</table>


                   </div>
                   
  </form>    --->             
                   
                   
                   </div>
                   </div>
                   </div>
                    
                    
               </div>
           </div>
        </div>
        </div>

</body>
</html>




<!--<table width="100%">
                    <tr >
                    	<td style="width:49%" align="center">
                       		 <div style=" padding:10px;" >
                                <div style="background-color:#FFFFFF;  border:1px solid #CCCCCC;">
                                    <table width="100%">
                                        <tr >
                                            <th  colspan="2" style="padding:30px;color:#262626; font: 300 20px Roboto,arial,sans-serif;">
                                                 <center><b>Basic Information </center></b>
                                            </th>
                                        </tr>
                                        <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Name</td>
                                            <td width="50%"><?php //echo $value['t_complete_name'];?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Gender</td>
                                            <td width="50%"><?php //echo $value['t_gender'];?></td>
                                        </tr>
                                         <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Date of Birth</td>
                                            <td width="50%"><?php //echo $value['t_dob']; ?></td>
                                        </tr>
                                        <tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Age</td>
                                            <td width="50%"><?php //echo $value['t_age'];?></td>
                                        </tr>
                                         <tr style="background-color:#FFFFFF;" >
                                        	<td align="center" style="padding-top:10px;" colspan="2"><a href="update_teacher_profile.php?id=2">Edit</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                        
                        <td style="width:49%" align="center">
                        	<div style=" padding:10px;">
                                <div style="background-color:#FFFFFF;border:1px solid #CCCCCC;">
                                    <table width="100%">
                                        <tr>
                                            <th colspan="2" style="padding:30px;color:#262626; font: 300 20px Roboto,arial,sans-serif;">
                                                <center><b>Work Place</b></center>
                                            </th>
                                        </tr>
                                      
                                       
                                         <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">College Name</td>
                                            <td width="50%" ><?php //echo $value['t_current_school_name'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Department</td>
                                            <td width="50%" ><?php //echo $value['t_dept'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Teacher Id</td>
                                            <td width="50%" ><?php //echo $value['t_id'];?></td>
                                        </tr>
                                         <tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Experience</td>
                                            <td width="50%" ><?php //echo $value['t_exprience'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Date of Appointment</td>
                                            <td width="50%" ><?php //echo $value['t_date_of_appointment'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Employee type Id</td>
                                            <td width="50%" ><?php //echo $value['t_emp_type_pid'];?></td>
                                        </tr>
                                         <tr style="background-color:#FFFFFF">
                                        	<td align="center" style="padding-top:10px;" colspan="2"><a href="update_teacher_profile.php?id=5">Edit</a></td>
                                        </tr>
                                    </table>
                                </div>
                             </div>
                        </td>
                    </tr>
                    </table>
                    <div>&nbsp;</div>
                    <table width="100%">
                    <tr>
                    	<td style="width:49%" align="center">
                       		 <div style=" padding:10px 10px 10px 10px;">
                                <div style="background-color:#FFFFFF;  border:1px solid #CCCCCC;">
                                    <table width="100%">
                                        <tr>
                                            <th colspan="2" style="padding:30px;color:#262626; font: 300 20px Roboto,arial,sans-serif;">
                                                <center><b> Qualification Details </center></b>
                                            </th>
                                        </tr>
                                          <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Qualification </td>
                                            <td width="50%"><?php //echo $value['t_qualification'];?></td>
                                        </tr>
                                        <tr>
                                        	<td align="center" style="padding-top:10px;" colspan="2"><a href="update_teacher_profile.php?id=6">Edit</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td style="width:2%">&nbsp;
                        
                        </td>
                        <td style="width:49%" align="center">
                        	<div style=" padding:10px 10px 10px 10px;">
                                <div style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                                    <table>
                                    	 <tr >
                                            <th colspan="2" style="padding:30px;color:#262626; font: 300 20px Roboto,arial,sans-serif;" >
                                                 <center><b>Contact Details </center></b>
                                            </th>
                                        </tr>
                                          <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Password</td>
                                            <td width="50%"><?php //echo "*****";?></td>
                                        </tr>
                                       
                                    	  <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Mobile Number</td>
                                            <td width="50%"><?php //echo $value['t_phone'];?></td>
                                        </tr>
                                       <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Landline</td>
                                            <td width="50%"><?php //echo $value['t_landline'];?></td>
                                        </tr>
                                         <tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Email ID</td>
                                            <td width="50%"><?php //echo $value['t_email'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Internal Email ID</td>
                                            <td width="50%"><?php //echo $value['t_internal_email'];?></td>
                                        </tr>
                                          <tr style="background-color:#FFFFFF">
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;max-width:30px;overflow:hidden; text-overflow:ellipsis;white-space: nowrap;">Address</td>
                                            <td width="50%"><?php //echo $value['t_address'];?></td>
                                        </tr>
										<tr>
                                            <td width="50%" style="padding:10px; font-size:14px; font-weight:bold;">Pincode</td>
                                            <td width="50%"><?php //echo $value['t_permanent_pincode'];?></td>
                                        </tr>
                                        <tr>
                                        	<td align="center" style="padding-top:10px;" colspan="2">
                                            <a href="update_teacher_profile.php?id=4">Edit</a></td>
                                        </tr>
                                        
                                        
                                    </table>
                                </div>
                             </div>
                        </td>
                    </tr>
                    </table>-->
                    