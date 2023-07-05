
<?php
$report=""; 
include('conn.php');

 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $student_prn=$value['std_PRN'];
	  $sc_id=$value['school_id'];
if(isset($_POST['submit']))
	{
		$id=$_GET['id'];
		$stud_id=$_SESSION['id'];
		if($id==1)
		{
		
				if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				 echo	$ex_img = explode(".",$img);
                    $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
				 
$year=date('Y');
$entity="Student";
$college=trim($value['college_mnemonic']);
$start_dir="Images";
$path=$start_dir.'/'.$college.'/'.$entity.'/'.$year.'/';

if(!file_exists($path)){
	mkdir($path, 0777, true);
}
					
					$filenm=$path.$img_name;
				 }
		 mysql_query("update tbl_student set std_img_path='$filenm' where id='$stud_id'");
		move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
		if(mysql_affected_rows()>0)
			  {
			  	$report="successfully accepted";
			  }
			  header('Location:student_profile.php');
		}
		 if($id==2)
		 {
		      $std_name=$_POST['std_name'];
			  $std_father_name=$_POST['std_father_name'];
			  $std_dob=$_POST['std_dob'];
			  $std_age=$_POST['std_age'];
			  $std_gender=$_POST['gender'];
			
			 $arr= mysql_query("update tbl_student set std_name='$std_name',std_father_name='$std_father_name',std_dob='$std_dob',std_age='$std_age',std_gender='$std_gender' where id='$stud_id'");
			  if(mysql_affected_rows()>0)
			  {
			  	$report="successfully accepted";
			  }
			  header('Location:student_profile.php');
		 
		 
		   
		 }
		 if($id==4)
		 {
		 		$std_email=$_POST['std_email'];
				$std_city=$_POST['std_city'];
				$std_country=$_POST['std_country'];
				$std_phone=$_POST['std_phone'];
				$std_internal_email=$_POST['std_internal_email'];
				$std_temp_address=$_POST['std_temp_add'];
				$std_perm_add=$_POST['std_perm_add'];
				$std_perm_village=$_POST['std_perm_v'];
				$std_perm_taluka=$_POST['std_perm_t'];
				$std_perm_district=$_POST['std_perm_d'];
				$std_perm_pincode=$_POST['std_perm_p'];
				
				
				$arr= mysql_query("update tbl_student set std_email='$std_email',std_city='$std_city',std_phone='$std_phone',std_country='$std_country',Email_Internal='$std_internal_email',
				Temp_address='$std_temp_address',permanent_address='$std_perm_add',Permanent_village='$std_perm_village',Permanent_taluka='$std_perm_taluka',Permanent_district='$std_perm_district',Permanent_pincode='$std_perm_pincode' where std_PRN='$student_prn' and school_id='$sc_id'");
				if(mysql_affected_rows()>0)
			  {
			  
			  header('Location:student_profile.php');
			  }
			  else
			  {
			    header('Location:student_profile.php');
			  }
			  
		}
		
		if($id==5)
		{
			$std_prn=$_POST['std_enroll'];
			$std_school_name=$_POST['std_school_name'];
			$std_branch=$_POST['std_branch'];
			$std_spec=$_POST['std_specialization'];
			$std_d=$_POST['std_dept'];
			$std_semester=$_POST['std_semester'];
			$std_a_year=$_POST['std_admission_year'];
			$std_c_year=$_POST['std_current_year'];
			$std_course_level=$_POST['std_course_level'];
			$std_class=$_POST['std_class'];
			
		    mysql_query("update tbl_student set std_PRN='$std_prn',std_school_name='$std_school_name',std_branch='$std_branch',std_semester='$std_semester', 
			Specialization='$std_spec',std_dept='$std_d',Admission_year_id='$std_a_year',std_year='$std_c_year',Course_level='$std_course_level',std_class='$std_class' where std_PRN='$student_prn' and school_id='$sc_id'");
		if(mysql_affected_rows()>0)
			  {
			  
			  header('Location:student_profile.php');
			  }
		
		}
		if($id==3)
		{
			$std_password=$_POST['std_password'];
		
				mysql_query("update tbl_student set std_password='$std_password' where id='$stud_id'");
		if(mysql_affected_rows()>0)
			  {
			  
			  header('Location:student_profile.php');
			  }
			  else
			  {
			  header('Location:student_profile.php');
			  }
		
		}
		if($id==6)
		{
			$std_hobbies=$_POST['std_hobbies'];
		
				mysql_query("update tbl_student set std_hobbies='$std_hobbies' where id='$stud_id'");
		if(mysql_affected_rows()>0)
			  {
			  
			  header('Location:student_profile.php');
			  }
		
		}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" href="css/bootstrap.min.css">
<title>Untitled Document</title>
<script>
function validpassword()
{
 var password=document.getElementById("std_password").value;
 var cnfpassword=document.getElementById("cnfpassword").value;
 
 if (password != cnfpassword) {
            //alert("Passwords Do not match");
		
            document.getElementById("errorcnfpassword").innerHTML = "password and confirm password should match";
        return false;
        }
		regx=/^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
		
		if(!regx.test(password)||password.length<6 )
		{
		document.getElementById('errorcnfpassword').innerHTML='password contain specialchar alphbet digit and min length 6';
					return false;
		}
		
}
function validbasic()
{

 var std_name=document.getElementById("std_name").value;
 
 var std_father_name=document.getElementById("std_father_name").value;
 var std_dob=document.getElementById("std_dob").value;
 var std_age=document.getElementById("std_age").value;
 regx1=/^[A-z ]+$/;
		 if(std_name==null||std_name=="")
			{
			   
				document.getElementById('errorname').innerHTML='Please Enter Name';
				
				return false;
			}
		//validation for name
				if(!regx1.test(std_name))
				{
					document.getElementById('errorname').innerHTML='Please enter valid Name';
					return false;
				}
 if(std_father_name==null||std_father_name=="")
 			{
			   
				document.getElementById('errorfathername').innerHTML='Please Enter Father Name';
				
				return false;
			}
			//validation for father name
				if(!regx1.test(std_father_name))
				{
					document.getElementById('errorname').innerHTML='Please enter valid Name';
					return false;
				}
		if(std_dob==null||std_dob=="")
			{
				document.getElementById('errordob').innerHTML='Please Enter Date of Birth';
				
				return false;
			}
if(std_age==null||std_age=="")
			{
				document.getElementById('errorage').innerHTML='Please Enter Age';
				
				return false;
			}
			regx=/^[0-9]{1,10}$/;
				//validation of mobile
				
				if(!regx.test(std_age))
				{
					document.getElementById('errorage').innerHTML='Please Enter Age';
					return false;
				}
			
		
}
function validcontact()
{
var phone=document.getElementById("std_phone").value;

 if((phone.length)!=10)
 {

 document.getElementById('errorphone').innerHTML='Please Enter valid Phone Number..';
 return false;
 }
 
 var email=document.getElementById("std_email").value;
 var std_address=document.getElementById("std_address").value;
 
 var std_country=document.getElementById("std_country").value;
 
 var std_city=document.getElementById("std_city").value;
 regx1=/^[A-z ]+$/;
if(std_address==null||std_address=="")
 			{
			  
				document.getElementById('erroraddress').innerHTML='Please Enter Address';
				
				return false;
			}
			
if(phone==null||phone=="")
 			{
			  alert("hii");
				document.getElementById('errorphone').innerHTML='Please Enter Phone Number..';
				
				return false;
			}
						
if(std_country==null||std_country=="")
			{
				document.getElementById('errorcountry').innerHTML='Please Enter country';
				
				return false;
			}
//validation for name
				if(!regx1.test(std_country))
				{
					document.getElementById('errorcountry').innerHTML='Please enter valid Coutry';
					return false;
				}
if(std_city==null||std_city=="")
			{
				document.getElementById('errorcity').innerHTML='Please Enter city';
				
				return false;
			}
			   //validation for name
				if(!regx1.test(std_city))
				{
					document.getElementById('errorcity').innerHTML='Please enter valid City';
					return false;
				}
                var atpos = email.indexOf("@");
				var dotpos = email.lastIndexOf(".");
				if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
					document.getElementById('erroremail').innerHTML='Please enter valid Email Id';
					return false;
				}

 
			
		
}
function valideducation()
{
	 var std_school_name=document.getElementById("std_school_name").value;
	 var std_branch=document.getElementById("std_branch").value;
	 var std_semester=document.getElementById("std_semester").value;
 			if(std_school_name==null||std_school_name=="")
				{
				  
					document.getElementById('errorschoolname').innerHTML='Please Enter School Name';
				    return false;
				}
			if(std_branch==null||std_branch=="")
				{
				  
					document.getElementById('errorclass').innerHTML='Please Enter Branch';
				    return false;
				}
			if(std_semester==null||std_semester=="")
				{
				  
					document.getElementById('errordiv').innerHTML='Please Enter Semester';
				    return false;
				}

}
</script>
</head>

<body >

<div style="width:100%;">

<?php $id=$_GET['id'];
if($id==1)
	{?>
    <div class="row">
   <div class="col-md-3">
   </div>
 
        <div class="col-md-6" style="padding:80px;">
    <div class="panel panel-primary" align="center">
        <form name="f1" method="post" enctype="multipart/form-data">
          <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
                    <div style="padding:10px; height:20px;  font-size:18px; font-weight:bold;">Profile PC</div>
                    <p style="font-size:24px; color:#0080FF;padding:10px;"> <div>
<input type="file" name="filUpload" id="filUpload" onchange="showimagepreview(this)" />
</div></p>
                 <div style="padding-top:20px;">   <input type='submit' value='submit' name='submit' /></div>
           </div>
           
           </form>
           </div>
           </div>
           </div>
          
<?php	}
if($id==2){?>
<div class="row">
<div class="col-sm-4"></div>
<div class="col-sm-5" style="padding:40px;">
    <div class="panel panel-primary" align="center">
<div class="">
	<form name="f1" method="post" enctype="multipart/form-data">
		   <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
         <div style="padding:10px; height:20px;  font-size:18px; font-weight:bold;">Basic Information</div>
			
			<div class="row" style="padding-top:40px;">
            
				<div class="col-sm-6"><strong>Name</strong></div>
                
                
				<div class="col-sm-6">
					<input type="text"name="std_name" id="std_name" value='<?php echo $value['std_name']; ?>'/>
                 
				</div>
                
			</div>
               
                     <div align="center" id='errorname' style="color:#FF0000;font-weight:bold;"></div>
             
			
            
            <div class="row" style="padding-top:20px;">
            <div class="col-sm-6"><strong>Father Name</strong></div>
				
				<div class="col-sm-6">
					<input type="text" name="std_father_name"  id="std_father_name" value='<?php echo $value['std_Father_name']; ?>'/>
                  
				</div>
              
			</div>
                <div align="center" id='errorfathername' style="color:#FF0000;font-weight:bold;"></div>
            
            
            
			<div class="row" style="padding-top:20px;">
          
				<div class="col-sm-6"><strong>Date of Birth</strong></div>
            
				<div class="col-sm-6">
					<input type="date" name="std_dob" id="std_dob" value='<?php echo $value['std_dob']; ?>'/>
                     
				</div>
			</div>
               
            <div align="center" id='errordob' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row" style="padding-top:20px;">
				<div class="col-sm-6"><strong>Age</strong></div>
        
				<div class="col-sm-6">
					    <input type="text" name="std_age" id="std_age" value='<?php echo $value['std_age']; ?>' />
                              <div align="center" id='errorage' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
				</div>
			</div>
      
            
                      
            
			<div class="row" style="padding-top:20px;">
				 <div class="col-sm-6"><strong>Gender</strong></div>
                                <div class="col-sm-6">
                                     <?php  if( $value['std_gender']=='Male'){?>
                     
                          Male
                            <input type="radio" id='gender' name="gender" value="Male" checked >
                        
                       &nbsp; Female
                            <input type="radio" id='gender' name="gender" value="Female">
                        
                        <?php }else{?>
                         
                          Male
                            <input type="radio" id='gender' name="gender" value="Male" >
                        
                      &nbsp; Female
                            <input type="radio" id='gender' name="gender" value="Female" checked>
                        
                        <?php }?>
                                 </div>
				</div>
			
     
            
            
            
            
            
		
					 <div style="padding-left:50px; padding-top:40px;">  <input type='submit' value='submit' name='submit' onclick="return validbasic()"/></div>
			</div>	
	</form>
</div>
</div>
</div>
</div>

    
 <?php }if($id==4){?>
 <div class="row" style="padding:30px;">
 <div class="col-sm-4" style="padding:10px;"></div>
 
 <div class="col-sm-5" style="padding:10px;">
    <div class="panel panel-primary" align="center" >
  
<div class="" align="center">
	<form name="f1" method="post" >
		  <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
         <div style="padding:10px;  font-size:18px; font-weight:bold;">Contact Information</div>
			<?php $row=mysql_query("select std_phone,std_email,Email_Internal,Temp_address,permanent_address,Permanent_village,Permanent_taluka,Permanent_district,Permanent_pincode,std_city,std_country from tbl_student where std_PRN='$student_prn'"); 
						$result=mysql_fetch_array($row);
							$mob=$result['std_phone'];
							$email=$result['std_email'];
							$internal_email=$result['Email_Internal'];
							$tadd=$result['Temp_address'];
							$padd=$result['permanent_address'];
							$pvill=$result['Permanent_village'];
							$ptaluka=$result['Permanent_taluka'];
							$pdist=$result['Permanent_district'];
							$ppincode=$result['Permanent_pincode'];
							$city=$result['std_city'];
							$country=$result['std_country'];?>
			<div class="row" style="padding-top:20px;">
			 <div class="col-sm-6"><strong>Phone number</strong></div>
             
				<div class="col-sm-5">
					 <input type="text"  style="width:100%" name="std_phone" id="std_phone" value='<?php echo $mob; ?>' />
                    
				</div>
                
			</div>
             
			
                     <div align="center" id='errorphone' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Email ID</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_email" id="std_email" value='<?php echo $email; ?>' />
              
				</div>
			</div>
                  <div align="center" id='erroremail' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Internal Email ID</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_internal_email" id="std_email" value='<?php echo $internal_email; ?>' />
              
				</div>
			</div>
			
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Temporary Address</strong></div>
			
		<div class="col-md-5">
					<textarea name="std_temp_add"  style="width:100%" id="std_address" ><?php echo $tadd; ?></textarea>
                     
				</div>
			</div>
			<div align="center" id='erroraddress' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
			
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Permanant Address</strong></div>
			
		<div class="col-md-5">
					<textarea name="std_perm_add"  style="width:100%" id="std_address" ><?php echo $padd; ?></textarea>
                     
				</div>
			</div>
			
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Permanant Village</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_perm_v" id="std_email" value='<?php echo $pvill; ?>' />
              
				</div>
			</div>
			
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Permanant Taluka</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_perm_t" id="std_email" value='<?php echo $ptaluka; ?>' />
              
				</div>
			</div>
			
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Permanant District</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_perm_d" id="std_email" value='<?php echo $pdist; ?>' />
              
				</div>
			</div>
			<div class="row"  style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Permanant Pincode</strong></div>
			
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_perm_p" id="std_email" value='<?php echo $ppincode; ?>' />
              
				</div>
			</div>
			
			
               
            
            
            <div class="row" style="padding-top:20px;">
				<div  class="col-sm-6"><strong>Country</strong></div>
             
				<div class="col-sm-5">
					    <input type="text" style="width:100%" name="std_country" id="std_country" value='<?php echo $country; ?>' />
                             
				</div>
			</div>
      
       <div align="center" id='errorcountry' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row"  style="padding-top:20px;">
				<div class="col-sm-6"><strong>City</strong></div>
               
				<div class="col-sm-5">
					    <input type="text" style="width:100%" name="std_city" id="std_city" value='<?php echo $city; ?>' />
                           
				</div>
			</div>
                      
                <div align="center" id='errorcity' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
			           
		
					   
                       <div style="padding-left:50px;padding-top:20px;"> <center> <input type='submit' value='submit' name='submit' onclick="return validcontact()"/>
					   &nbsp;&nbsp; <a href="student_profile.php"><input type='button' value='Cancel' name='submit'/></a></center></div>
			</div>
            	
	</form>
</div>
</div>
</div>
 
 </div>
 
 
 
<?php }if($id==5){?>

<div class="row" style="padding:30px;">
 <div class="col-sm-4" style="padding:10px;"></div>
 
 <div class="col-sm-5" style="padding:10px;">
    <div class="panel panel-primary" align="center">
  
<div class="" align="center">
	<form name="f1" method="post" >
		  <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
         <div style="padding:10px;  font-size:18px; font-weight:bold;">Education</div>
			<?php $row=mysql_query("select std_PRN,std_school_name,std_branch,std_dept,Specialization,std_semester,Admission_year_id,std_year,Course_level,std_class from tbl_student where std_PRN='$student_prn'"); 
						$result=mysql_fetch_array($row);
						    $stud_prn=$result['std_PRN'];
							$sc_name=$result['std_school_name'];
							$branch=$result['std_branch'];
							$dept=$result['std_dept'];
							$specialization=$result['Specialization'];
							$semester=$result['std_semester'];
							$admission_year=$result['Admission_year_id'];
							$c_year=$result['std_year'];
							$course_level=$result['Course_level'];
							$class=$result['std_class'];?>
			<div class="row" style="padding-top:20px;">
			 <div class="col-sm-6"><strong>School Name</strong></div>
             	
				<div class="col-sm-5" >
					 <input type="text" style="width:100%"  name="std_school_name" id="std_school_name" value='<?php echo $sc_name; ?>'/>
                    
				</div>
                
			</div>
             
			
                     <div align="center" id='errorschoolname' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
			<div class="row" style="padding-top:20px;">
			 <div class="col-sm-6"><strong>Enrollment No.</strong></div>
             	
				<div class="col-sm-5" >
					 <input type="text" style="width:100%"  name="std_enroll" id="std_enroll" value='<?php echo $stud_prn; ?>'/>
                    
				</div>
                
			</div>
			
            <div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Branch</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_branch" id="std_branch" value='<?php echo $branch; ?>' />
              
				</div>
			</div>
                  <div align="center" id='errorclass' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
			<div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Department</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_dept" id="std_dept" value='<?php echo $dept; ?>' />
              
				</div>
			</div>
			
			<div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Specialization</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_specialization" id="std_specialization" value='<?php echo $specialization; ?>' />
              
				</div>
			</div>
			
			
            
			<div class="row" style="padding-top:20px;">
				<div  class="col-sm-6"><strong>Semester</strong></div>
            
				<div class="col-sm-5">
					<input type="text"  style="width:100%" id="std_semester" name="std_semester"  value='<?php echo $semester; ?>'/>
                     
				</div>
			</div>
               <div align="center" id='errordiv' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Admission Year</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_admission_year" id="std_admission_year" value='<?php echo $admission_year; ?>' />
              
				</div>
			</div>
			
			
            <div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Current Year</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_current_year" id="std_current_year" value='<?php echo $c_year; ?>' />
              
				</div>
			</div>
			
			<div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Course Level</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_course_level" id="std_course_level" value='<?php echo $course_level; ?>' />
              
				</div>
			</div>
			
			<div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Class</strong></div>
				
		<div class="col-sm-5">
					<input type="text"  style="width:100%" name="std_class" id="std_class" value='<?php echo $class; ?>' />
              
				</div>
			</div>
           
            
					   
                       <div style="padding-left:50px; padding-top:20px;">  <center><input type='submit' value='submit' name='submit' onclick="return valideducation()"/>
					   &nbsp;&nbsp; <a href="student_profile.php"><input type='button' value='Cancel' name='submit'/></a></center></div>
				</div>
                
	</form>
</div>
</div>
</div>
 
 </div>
 
 




<?php }
	
if($id==3){?>

<div class="row" style="padding:30px;">
 <div class="col-sm-4" style="padding:10px;"></div>
 
 <div class="col-sm-5" style="padding:10px;">
    <div class="panel panel-primary" align="center">
  
<div class="" align="center">
	<form name="f1" method="post" >
		  <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
         <div style="padding:10px;  font-size:18px; font-weight:bold;">Change Password</div>
			
			<div class="row" style="padding-top:20px;">
			 <div class="col-sm-6"><strong>Password</strong></div>
				<div class="col-sm-5">
					 <input type="password"  style="width:100%" name="std_password" id="std_password"value='<?php echo $value['std_password']; ?>'/>
                    
				</div>
                
			</div>
             
			
                     <div align="center" id='errorphone' style="color:#FF0000;padding:5px;font-weight:bold;"></div>
            
            <div class="row" style="padding-top:20px;">
         <div class="col-sm-6" ><strong>Confirm Password</strong></div>
		
		<div class="col-sm-5" >
					<input type="password"  style="width:100%" name="cnfpassword" id="cnfpassword" value='<?php echo $value['std_password']; ?>' />
              
				</div>
			</div>
                   <div align="center" style="color:#FF0000;font-weight:bold;font-size:14px;" id="errorcnfpassword"></div>
            
			
            
          
            
           
		
					   
                       <div style="padding-left:50px; padding-top:40px;">  <center><input type='submit' value='submit' name='submit' onclick="return validpassword()"/>
			&nbsp;&nbsp; <a href="student_profile.php"><input type='button' value='Cancel' name='submit'/></a></center></div>
			</div>
            	
	</form>
</div>
</div>
</div>
 
 </div>
 
 





			
<?php }if($id==6){?>

<div class="row" style="padding:30px;">
 <div class="col-sm-4" style="padding:10px;"></div>
 
 <div class="col-sm-5" style="padding:10px;">
    <div class="panel panel-primary" align="center" >
  
<div class="" align="center">
	<form name="f1" method="post" >
		  <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); color:#000000; border:1px solid #CCCCCC;">
         <div style="padding:10px;  font-size:18px; font-weight:bold;">Other</div>
			
			<div class="row" style="padding:20px;">
			 <div class="col-sm-6"><strong>Hobbies</strong></div>
             	
				<div class="col-sm-6" >
					<textarea name="std_hobbies"  id="std_hobbies"  style="width:100% "><?php echo  $value['std_hobbies']; ?>
         </textarea>           
				</div>
                
                
			</div>
      
              
				
          
           <div style="padding-left:50px; padding:10px;"> <center> <input type='submit' value='submit' name='submit' />
		   &nbsp;&nbsp; <a href="student_profile.php"><input type='button' value='Cancel' name='submit'/></a></center></div>
			           
		
			</div>
            		   
                     
	</form>

</div>
</div>
 
 </div>
 
 




<?php }





          ?>


<?php echo $report;?>
</div>
</div>
 </div>
 
</center>
</body>
</html>





