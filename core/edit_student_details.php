<?php
/*error_reporting(0); */
$report = "";
include("scadmin_header.php");
 $sc_id=$_SESSION['school_id'];
/*$id=$_SESSION['id'];*/
$fields = array("id" => $id);
$table="tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$arrs = mysql_fetch_array($results);
$school_id = $arrs['school_id'];
$std_PRN = $_GET['std_prn'];
$std_complete_name = "";
if ($std_PRN != '') {
    if (isset($_POST['update'])) {
        if ($std_PRN != '') {
            $std_prn = $_POST['std_prn'];
            //$l_name=$_POST['id_last_name'];
            
            $fname = $_POST['id_first_name'];
            $mname = $_POST['id_first_name_f'];
            $lname = $_POST['id_last_name_f'];
            
           $full_name = $fname . " " . $mname . " " . $lname;
		   $std_class= $_POST['class'];
		   $std_div= $_POST['id_div'];
			$std_gen= $_POST['gender'];	
			$std_email_id= $_POST['id_email'];
			$std_internal_emailid= $_POST['in_email'];
			$std_mob= $_POST['id_phone'];
			 $std_dob= $_POST['id_checkin'];
			$std_t_address= $_POST['t_address'];
			$std_p_address= $_POST['id_address'];
			$std_country= $_POST['country'];
			$std_state= $_POST['state'];
			$std_cty= $_POST['city'];
			$emp_desig= $_POST['emp_designation'];
			
		$Specialization = $_POST['Specialization']; 
		$CourseLevel = $_POST['CourseLevel']; 
	 
		$BranchName1 = $_POST['BranchName'];
		$BranchName2 = explode (",", $BranchName1);
		$BranchName = $BranchName2[1];
		$Branchid = $BranchName2[0];
		
		
		 $Intruduce_YeqarID1 = $_POST['Intruduce_YeqarID'];
		
	
		$PermanentVillage = $_POST['PermanentVillage']; 
$PermanentTaluka = $_POST['PermanentTaluka']; 
$PermanentDistrict = $_POST['PermanentDistrict']; 
$PermanentPincode = $_POST['PermanentPincode']; 
 

$DeptName1=$_POST['DeptName'];
$DeptName2 = explode (",", $DeptName1);
$DeptName = $DeptName2[1];
$Deptid = $DeptName2[0];

$SemesterName1 = $_POST['SemesterName'];
$SemesterName2 = explode (",", $SemesterName1);
$SemesterName = $SemesterName2[1];
$Semesterid = $SemesterName2[0];

list($month,$day,$year) = explode("/",$std_dob);
	
	
	$year_diff  = date("Y") - $year; 
    $month_diff = date("m") - $month; 
    $day_diff   = date("d") - $day; 
		if ($day_diff < 0 || $month_diff < 0) $year_diff--;
	
	$age= $year_diff;
	
	$dateformat=$year. "-" .$month. "-" .$day;

            $sql_update11 = "UPDATE `tbl_student` SET std_PRN='$std_prn',std_name='$fname',std_Father_name='$mname',std_lastname='$lname',std_complete_name='$full_name',
		std_class='$std_class',std_div='$std_div',emp_designation='$emp_desig',std_gender='$std_gen',std_email='$std_email_id',Email_Internal='$std_internal_emailid',std_phone='$std_mob',std_dob='$dateformat',
		Temp_address='$std_t_address',permanent_address='$std_p_address',std_country='$std_country',std_state='$std_state',std_city='$std_cty',Specialization='$Specialization',Course_level='$CourseLevel',std_branch='$BranchName',Academic_Year='$Intruduce_YeqarID1',Permanent_village='$PermanentVillage',Permanent_taluka='$PermanentTaluka',Permanent_district='$PermanentDistrict',Permanent_pincode='$PermanentPincode',Admission_year_id='$std_year',std_dept='$DeptName',ExtDeptId='$Deptid',ExtBranchId='$Branchid',std_year='$Year',std_semester='$SemesterName',ExtSemesterId='$Semesterid'
		WHERE std_PRN='$std_PRN' AND school_id='$school_id'";
		
		
		
            $retval11 = mysql_query($sql_update11) or die('Could not update data: ' . mysql_error());
        } else {
			
			//window.location='studentlist.php' added by Pranali for bug SMC-3308
            echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
        }
        if ($retval11 > 0) {
            echo "<script type=text/javascript>alert('Record Updated Successfully '); window.location='studentlist.php'</script>";
        } else {
            echo "<script type=text/javascript>alert('Ooops..you didn't make any kind of change'); window.location='studentlist.php'</script>";
        }
		//changes end
    }


    $query = mysql_query("select * from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");
    if (mysql_num_rows($query) > 0) {
        while ($value1 = mysql_fetch_assoc($query)) {
			$std_complete_name=$value1['std_complete_name'];
            $fname1 = $value1['std_name'];
            $l2name1 = $value1['std_lastname'];
           $mname1 = $value1['std_Father_name'];
			if($std_complete_name == '')
			{
				
             $std_complete_name = $fname . " " . $mname . " " . $lname;
			}
			
			$complete_std_name=$value1['std_complete_name'];
		
		$complete_name=explode(" ",$complete_std_name);
		 $count=count($complete_name);
		
		if ($fname1==''){
			if($count<='5')
			{
			$fname1=ucwords($complete_name['0']);
			}
		}
		
      if($mname1==''){
		  
		  if($count=='2')
			{
			$mname1="";
			}
			if($count=='3' || $count=='4' || $count=='5')
			{
			$mname1=ucwords($complete_name['1']);
			}
		
	  }
        
		if ($l2name1==''){
			if($count=='3')
			{
			$l2name1=ucwords($complete_name['2']);
			}
			if($count=='2')
			{
			$l2name1=ucwords($complete_name['1']);
			}
			if($count=='4')
			{
			$l2name1=ucwords($complete_name['2'])."".ucwords($complete_name['3']);
			}
			if($count=='5')
			{
			$l2name1=ucwords($complete_name['2'])."".ucwords($complete_name['3'])."".ucwords($complete_name['4']);
			}
		}	
			
	
            /* $std_cname=$value1['std_complete_name'];
            $c_name=explode(" ",$std_cname);
            $fname=$c_name[0];
            $mname=$c_name[1];
            $lname=$c_name[2];
            $l2name=$c_name[3];
            $std_complete_name=$fname." ".$mname." ".$lname." ".$l2name; */
            $std_father_name = $value1['std_complete_father_name'];
            $std_dob = $value1['std_dob'];
            $std_branch = $value1['std_branch'];
            $std_class = $value1['std_class'];
            $std_div = $value1['std_div'];
			 $emp_designation = $value1['emp_designation'];
            $std_year = $value1['std_year'];
            $std_sem = $value1['std_semester'];
            $std_add = $value1['std_address'];
            $std_city = $value1['std_city'];
            $std_country = $value1['std_country'];
            $std_state = $value1['std_state'];
            $std_gender = $value1['std_gender'];
            $std_email = $value1['std_email'];
            $std_phone = $value1['std_phone'];
            $std_internal_email = $value1['Email_Internal'];
            $std_temp_address = $value1['Temp_address'];
            $std_permanant_add = $value1['permanent_address'];
            $std_permanant_village = $value1['Permanent_village'];
            $std_permanant_taluka = $value1['Permanent_taluka'];
            $std_permanant_district = $value1['Permanent_district'];
            $std_permanant_pincode = $value1['Permanent_pincode'];
			$Specialization = $value1['Specialization'];
			$Course_level = $value1['Course_level'];
			$Academic_Year = $value1['Academic_Year'];
			$Admission_year_id = $value1['Admission_year_id'];
			$std_dept = $value1['std_dept'];
			$std_semester = $value1['std_semester'];
			$ExtSemesterId = $value1['ExtSemesterId'];
			$year = $value1['std_year'];
			$ExtDeptId = $value1['ExtDeptId'];
			$ExtBranchId = $value1['ExtBranchId'];
			
        }
    }
} else {
    echo "<script type=text/javascript>alert('Sry... No PRN Number.Unable to update this record '); window.location='studentlist.php'</script>";
}
?>

<!DOCTYPE html>
<html>
<head>

    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src='js/bootstrap-switch.min.js' type='text/javascript'></script>
    <script src='js/bootstrap-multiselect.js' type='text/javascript'></script>






	
<script type="text/javascript">
    
	 
            $(function () {

                $("#id_checkin").datepicker({
					 changeYear: true,
                    changeMonth: true 
                });

            });
        </script>


   <script>
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
		
  function goBack() 
  {
    window.history.back();
   }
    </script>
    <script>
        function showOrhide() {

            if (document.getElementById("firstBtn")) {

                document.getElementById('text_country1').style.display = "block";
                document.getElementById('text_country').style.display = "none";
                document.getElementById('text_state1').style.display = "block";
                document.getElementById('text_state').style.display = "none";
                return false;
            }
        }
    </script>
    
    <style>
        body {
            background-color: #F8F8F8;
        }

        .indent-small {
            margin-left: 5px;
        }

        .form-group.internal {
            margin-bottom: 0;
        }

        .dialog-panel {
            margin: 10px;
        }

        .panel-body {
            font: 600 15px "Open Sans", Arial, sans-serif;
        }

        label.control-label {
            font-weight: 600;
            color: #777;
        }

        .internal_email {
            padding-left: 200px;
        }
    </style>
    <script src="js/city_state.js" type="text/javascript"></script>
	<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
           
            <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>
			<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
			 <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
			
			<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
 

   <script>
   //Below code for duplicte Email-ID added by Rutuja Jori on 01/11/2019
$(document).ready(function() 
 {  
	 $("#id_email").on('change',function(){ 	 
		 var dup_email = document.getElementById("id_email").value;

		 $.ajax({
			 type:"POST",
			 data:{dup_email:dup_email}, 
			 url:'email_validation_student.php',
			 success:function(data)
			 {
				 if(data == 0)
				 {
					  $(data).hide();
				 }
				 else{
					 
			           alert("Email ID already present...Please try another one");
					  $('#id_email').val("");
				 }
				// $('#managerList').html(data);
			 }
			 
			 
		 });
		 
	 });
 </script>  
<script>   
        $(document).ready(function () {
            $('.multiselect').multiselect();
            $('.datepicker').datepicker();
			
        });
 $(function () {
                $("#std_dob").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                });
            });

		
//		


</script>
<script>
 function Relationfunction(value,fn)
{
	
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
					  document.getElementById("DeptName").innerHTML =xmlhttp.responseText;
				}
				if(fn=='fun_dept')
				{
					 document.getElementById("BranchName").innerHTML =xmlhttp.responseText;
				}
				
				if(fn=='fun_branch')
				{
					 document.getElementById("SemesterName").innerHTML =xmlhttp.responseText;

				}
				
            }
          }
xmlhttp.open("GET","get_student_detail.php?fn="+fn+"&value="+value,true);
        xmlhttp.send();
 }
 


				
} 	 
</script>
<script>		
		
		function valid()
	{//Validations added by Rutuja Jori on 04/11/2019
		var first_name=document.getElementById("id_first_name").value;
		
		if(first_name.trim()==null||first_name.trim()==""  )
			{
			   
				alert('Please enter first name');
				
				return false;
			}
			 
			regx1=/^[A-Za-z\s]+$/;
			
				if(!regx1.test(first_name)  )
				{
				alert('Please Enter valid Name');
					return false;
				}
				
				
				
				
			var phone = document.getElementById("id_phone").value;
				var pattern = /^[6789]\d{9}$/;
				
				if (!pattern.test(phone)) {
				   alert("Please enter 10 digits number!");
					return false;
				}
				
				
				var std_cource=document.getElementById("CourseLevel").value;
					if(std_cource=='' || std_cource=='Select <?php echo $dynamic_level;?>')
					{
						alert('Please select <?php echo $dynamic_level;?>');
						return false;
					}
					
					
					
					var std_dept=document.getElementById("DeptName").value;
					if(std_dept=="" || std_dept=='Select Department' || std_dept=='select')
					{
						alert('Please select Department');
						return false;
					}
					
					
				
				
				
				var year_id=document.getElementById("Intruduce_YeqarID").value;
					if(year_id=='' || year_id=='Select <?php echo $dynamic_year;?>' || year_id=='select')
					{
						alert('Please select <?php echo $dynamic_year;?>');
						return false;
					}
					
				
				var id_email = document.getElementById("id_email").value;
				var pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,4})$/;
				
				if (id_email=="") {
					 alert("Please enter Email ID");
					 return false;  
				}
				
				if (!pattern.test(id_email)) {
					 alert("It is not valid Email id!");
					 return false;  
				}
				
				var id_country=document.getElementById("country").value;
			
					if(id_country=='-1')
					{
						alert('Please select country');
						return false;
					}
					
					var state=document.getElementById("state").value;
			
					if(state=='' || state=='Select State')
					{
						alert('Please select state');
						return false;
					}
					
					var city=document.getElementById("id_accomodation").value;
					regx2=/^[A-z]+$/;
						if(city.trim()==null||city.trim()=="")
					{
			    
						alert('Please enter city');
						return false;
					}
					else if(!regx2.test(city))
				{
				alert('Please enter valid city');
				return false;
				
				}	
				
				
				
					
					
					
var gender1=document.getElementById("gender1").checked;
			
				var gender2=document.getElementById("gender2").checked;
				
			    if(gender1==false && gender2==false)
				{
					alert("Please select gender");
					return false;
				}else{
					
				}
				
				
			var id_checkin=document.getElementById("id_checkin").value;
					 var myDate = new Date(id_checkin);

                  

				var today = new Date();
				if(id_checkin=="")
			{
	
			   
				
			}
			else if(myDate.getFullYear()>=today.getFullYear())
				{
					
					if(myDate.getFullYear()==today.getFullYear())
				   {
					
						if(myDate.getMonth()==today.getMonth())
						{
							if(myDate.getDate()>=today.getDate())
							{
								
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							}	
							else
							{
								document.getElementById("errordob").innerHTML ="";
							}
							
							
						}	
						else if(myDate.getMonth()>today.getMonth())
						{
							document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
							
						}
						else
				           {
							   document.getElementById("errordob").innerHTML ="";
							 }
				   }
				   else 
				   {
					   document.getElementById("errordob").innerHTML ="please enter valid birth date";
						return false;
					   
					 }
					 
				   
				}
					  else
					  {
						   document.getElementById("errordob").innerHTML ="";
						  
						 }	
				
				
				
		//end
		var complete_name=document.getElementById("complete_name").value;
		regx1=/^[A-z ]+$/;
		if(complete_name=="")
			{
			   
				document.getElementById('errorname').innerHTML='Please enter full name';
				
				return false;
			}
		else if(!regx1.test(complete_name))
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
				 document.getElementById('errorname').innerHTML='';
				
				}
				var c_father_name=document.getElementById("c_father_name").value;
		regx1=/^[A-z ]+$/;
		if(c_father_name=="")
			{
			   
				document.getElementById('errorfatname').innerHTML='Please enter full name';
				
				return false;
			}
		else if(!regx1.test(c_father_name))
				{
				document.getElementById('errorfatname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
				 document.getElementById('errorfatname').innerHTML='';
				
				}
				
				
				
				var c_lastname=document.getElementById("c_lastname").value;
		regx1=/^[A-z ]+$/;
		if(c_lastname=="")
			{
			   
				document.getElementById('errorlastname').innerHTML='Please enter last name';
				
				return false;
			}
		else if(!regx1.test(c_lastname))
				{
				document.getElementById('errorlastname').innerHTML='Please Enter valid Name';
					return false;
				}
				else
				{
				 document.getElementById('errorlastname').innerHTML='';
				
				}
				  <?php  if ($_SESSION['usertype'] == 'School Admin') {?>
				var id_class=document.getElementById("id_class").value;
				regx=  /^[a-zA-Z0-9&_\.-]+$/;
					if(id_class.trim()=="" || id_class.trim()==null)
					{
						document.getElementById('errorclass').innerHTML='Please enter class';
						return false;
					}
					else if(!regx1.test(id_class))
					{
						document.getElementById('errorclass').innerHTML='Please Enter valid  class name';
						return false;
					}
					else
					{
						document.getElementById('errorclass').innerHTML='';
					}
					
					var std_cource=document.getElementById("CourseLevel").value;
					if(std_cource=='')
					{
						document.getElementById('errorcource').innerHTML='Please select Course Level';
						return false;
					}
					else
					{
						document.getElementById('errorcource').innerHTML='';
					}
					

				  <?php }?>
				var id_div=document.getElementById("id_div").value;
					if(id_div=='')
					{
						document.getElementById('errordiv').innerHTML='Please enter division';
					return false;
					}
					else
					{
						document.getElementById('errordiv').innerHTML='';
					}
					
            regx1 = /^[6789]\d{9}$/;
            //validation for name

			
		/*	var gender1=document.getElementById("gender1").checked;
		
			var gender2=document.getElementById("gender2").checked;
			
		if(gender1==false && gender2==false)
			{
				document.getElementById('errorgender').innerHTML='Please Select gender';
				return false;
			}else{
				document.getElementById('errorgender').innerHTML='';
			}
			
			var permanant_address=document.getElementById("id_address").value;
		regx2=/^[A-z ]+$/;
		if(permanant_address=="")
			{
			   
				document.getElementById('erroraddress').innerHTML='Please enter address';
				
				return false;
			}
	
			else
				{
				 document.getElementById('erroraddress').innerHTML='';
				}
			*/	
				
				
			
			//var city=document.getElementById("id_accomodation").value;
			var city=document.getElementById("city").value;
				regx2=/^[A-z ]+$/;
			if(city==null||city=="")
			{
			    
				document.getElementById('errorcity').innerHTML='Please enter city';
				return false;
			}
			else if(!regx2.test(city))
			{
				document.getElementById('errorcity').innerHTML='Please enter valid city';
				return false;
				
				}
			else
			{
				
				document.getElementById('errorcity').innerHTML='';
			}
			
			var std_dept=document.getElementById("DeptName").value;
					if(std_dept=='')
					{
						document.getElementById('errordept').innerHTML='Please select Department';
						return false;
					}
					else
					{
						document.getElementById('errordept').innerHTML='';
					}
					
					var std_branch=document.getElementById("BranchName").value;
					if(std_branch=='')
					{
						document.getElementById('errorbranch').innerHTML='Please select <?php echo $dynamic_branch;?>';
						return false;
					}
					else
					{
						document.getElementById('errorbranch').innerHTML='';
					}
					var id_vill=document.getElementById("PermanentVillage").value;
					if(id_vill=='')
					{
						document.getElementById('errorvillage').innerHTML='Please Enter Permanent Village';
						return false;
					}
					else
					{
						document.getElementById('errorvillage').innerHTML='';
					}
					
					var id_taluka=document.getElementById("PermanentTaluka").value;
					if(id_taluka=='')
					{
						document.getElementById('errortaluka').innerHTML='Please Enter Permanent Taluka';
						return false;
					}
					else
					{
						document.getElementById('errortaluka').innerHTML='';
					}
			
			var id_distric=document.getElementById("PermanentDistrict").value;
					if(id_distric=='')
					{
						document.getElementById('errorDIST').innerHTML='Please Enter Permanent District';
						return false;
					}
					else
					{
						document.getElementById('errorDIST').innerHTML='';
					}
					
					var id_pincode=document.getElementById("PermanentPincode").value;
					if(id_pincode=='')
					{
						document.getElementById('errorpincode').innerHTML='Please Enter Pincode';
						return false;
					}
					else
					{
						document.getElementById('errorpincode').innerHTML='';
					}
					
					
					
					var id_Year=document.getElementById("Year").value;
					if(id_Year=='')
					{
						document.getElementById('errorYI').innerHTML='Please select Year';
						return false;
					}
					else
					{
						document.getElementById('errorYI').innerHTML='';
					}
			
	}		
		
		
    </script>

</head>


<body>

<div class='panel panel-primary dialog-panel'>
<div style="font-size:15px;font-weight:bold;margin-top:5px;" class="col-md-offset-6"><div style="color:#F00"><?php if(isset($_GET['errorreport'])){ echo $_GET['errorreport']; };echo $errorreport;?></div><div style="color:#090"><?php if(isset($_GET['successreport'])){ echo $_GET['successreport']; };echo $successreport;?></div></div>
    <div class='panel-heading'>
        <h3 align="center">Edit <?php echo $dynamic_student;?> Information</h3>

    </div>
      
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="POST" action="" >
        
        		<div class='form-group'>
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;"><?php echo $dynamic_emp;?>  <span class="error"><b style="color:red";> *</b></span></label>
					
              		
                	 <div class='col-md-3' style="text-align:left;">
                <input class='form-control' id='std_prn' name="std_prn" type='text' value="<?php echo $std_PRN; ?>" readonly="readonly">
            </div>


               <!-- 	Changes done (added error1 in class) by Pranali on 30-06-2018 for bug SMC-3201 -->
                     <div class='col-md-3 error1' id="errorrollno" style="color:#FF0000"></div>
					 
                 </div>
             
          		  
                 <div class="row">
                 	<label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;"><?php echo $dynamic_student;?> Name <span class="error"><b style="color:red";> *</b></span></label>
                 	 <div class='col-md-3' style="text-align:left;">
                	 
                  	 <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text' value="<?php echo $fname1; ?>">
                  
              	     </div>

                     <div class='col-md-2 error1' id="errorname" style="color:#FF0000"></div>
                 </div>
               
    			 <div class='form-group'>
            	  </div>
                	
					<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Middle Name <span class="error"></span></label>
            <div class='col-md-3 ' style="text-align:left;">
                
                  <input class='form-control' id="id_first_name_f" name="id_first_name_f" placeholder='Middle Name' type='text' value="<?php echo $mname1; ?>">
              </div>
         
              </div>
			  <div class='form-group'>
			  <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Last Name<span class="error"></span></label>
              <div class='col-md-3 '>
                 <input class='form-control' id="id_last_name_f" name="id_last_name_f" placeholder='Last Name' type='text' value="<?php echo $l2name1; ?>">
              </div>   
			  <div class='col-md-2 error1' id="errorlastname" style="color:#FF0000"></div>
          </div>

		   <div class='form-group'>
				    <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Mobile Number<span class="error"><b style="color:red";> *</b></span></label>
                <div class='col-md-3'>
                  <input class='form-control' id='id_phone' name="id_phone" placeholder='Mobile No' type='text' value="<?php echo $std_phone; ?>" onChange="PhoneValidation(this);">
                </div>
				<div class='col-md-2 error1' id="errorphone" style="color:#FF0000"></div>
          </div>
		  
		   	<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_class;?></label>
                <div class='col-md-3'>
                    <select name='class' id='class' class='form-control'>
					 <?php
                        echo $std_class;
						 if ($std_class == '0') {
							 $std_class="";
						 }
                        if ($std_class != '') {
                            ?>
                            <option value='<?php echo $std_class ?>'
                                    selected><?php echo $std_class; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php $arr = mysql_query("select distinct(class) from Class where school_id='$sc_id'"); 
						 while ($row = mysql_fetch_array($arr)) { 
						 $s_class=$row['class'];
						?>
                        <?php if ($std_class != $s_class) { ?>
                            <option value="<?php echo $s_class;?>"><?php echo $s_class;?></option>
						 <?php }
                            
                         }?>
                
                    </select>
                </div>
               
            </div>
		  
		  <?php if ($_SESSION['usertype'] == 'School Admin') {?>
		   <div class="form-group">
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Specialization<span class="error"></span></label>
                <div class='col-md-2' style="text-align:left;">
                  <input class='form-control' id="Specialization" name="Specialization" placeholder='Enter Specialization' type='text' value="<?php echo $Specialization;?>">
	   
				</div>
		  
          </div>
		   <?php }?>
		   
		 
		 
		 <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_level;?><b style="color:red";> *</b></label>
                <div class='col-md-3'>
                    <select name='CourseLevel' id='CourseLevel' class='form-control' onChange="Relationfunction(this.value,'fun_course')">
					 <option value="<?php echo $Course_level; ?>"><?php echo $Course_level; ?></option>
						<?php 
						$sql = "select DISTINCT CourseLevel  from tbl_CourseLevel where school_id='$sc_id' and ExtCourseLevelID !=''";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							//$ExtCourseLevelID = $row['ExtCourseLevelID'];
							$CourseLevel = $row['CourseLevel'];
							echo "<option value='$CourseLevel'>$CourseLevel</option>";
						}
						?>
                
                    </select>
                </div>
               
            </div>
			
			
					
					
					 <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;">Department<b style="color:red";> *</b></label>
                <div class='col-md-3'>
                    <select name='DeptName' id='DeptName' class='form-control' onChange="Relationfunction(this.value,'fun_dept')">
					<option value="<?php echo $std_dept; ?>"><?php echo $std_dept; ?></option>
						<?php 
						$sql = "select * from tbl_department_master where School_ID='$sc_id'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtDeptId = $row['ExtDeptId'];
							$Dept_Name = $row['Dept_Name'];
							echo "<option value='$Dept_Name'>$Dept_Name</option>";
						}
						?>
                
                    </select>
                </div>
               
            </div>
					
					
					
					 <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation' style="text-align:left;"><?php echo $dynamic_branch;?> Name </label>
                <div class='col-md-3'>
                    <select name='BranchName' id='BranchName' class='form-control' onChange="Relationfunction(this.value,'fun_branch')">
					 <option value="<?php echo $ExtBranchId.','.$std_branch;?>"><?php echo $std_branch;?></option>
						<?php 
						$sql = "select * from tbl_branch_master where school_id='$sc_id'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtBranchId = $row['ExtBranchId'];
							$branch_Name = $row['branch_Name'];
							echo "<option value='$ExtBranchId,$branch_Name'>$branch_Name</option>";
						}
						?>
                
                    </select>
                </div>
               
            </div>
					
			
				<?php if ($_SESSION['usertype'] == 'School Admin') {?>	
					<div class='form-group'>
                
           			 <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Semester Name <span class="error"></span></label>
					
              		
                	  <div class='col-md-3' style="text-align:left;">
                  <select name='SemesterName' id='SemesterName' class='form-control'>
					<option value="<?php echo $ExtSemesterId.','.$std_semester;?>"><?php echo $std_semester;?></option>
						<?php 
						$sql = "select * from tbl_semester_master where school_id='$sc_id'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtSemesterId = $row['ExtSemesterId'];
							$Semester_Name = $row['Semester_Name'];
							echo "<option value='$ExtSemesterId,$Semester_Name'>$Semester_Name</option>";
						}
						?>
                
                    </select>
		  
                </div>

               
                     <div class='col-md-3 error1' id="errorsem" style="color:#FF0000"></div>
					 
                
                    </div>
				<?php } ?>
					
		  
		 
		  
		  
		   
           <div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" ><?php echo $designation;?><span class="error"></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                    <select name='id_div' id='id_div' class='form-control'>
					 <?php
                        echo $std_div;
                        if ($std_div != '') {
                            ?>
                            <option value='<?php echo $std_div ?>'
                                    selected><?php echo $std_div; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select <?php echo $designation;?></option>
                        <?php } ?>
                        <?php $arr = mysql_query("select * from Division where school_id='$sc_id' and DivisionName != ''"); 
						 while ($row = mysql_fetch_array($arr)) { 
						 $t_class=$row['DivisionName'];
						?>
                        <?php if ($std_div != $t_class) { ?>
                            <option value="<?php echo $t_class;?>"><?php echo $t_class;?></option>
						 <?php }
                            
                         }?>
                
                    </select>
                </div>
				<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
               </div>
			   
			   <?php if ($_SESSION['usertype'] == 'HR Admin') {?>	
			   <div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" >Designation<span class="error"></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                   <select class='form-control' id='emp_designation' name="emp_designation" placeholder='Enter Designation'>
				  <option value=""> Select Designation</option>
				 <?php
				 
				 
				  echo $emp_designation;
                        if ($emp_designation != '') {
                            ?>
                            <option value='<?php echo $emp_designation ?>'
                                    selected><?php echo $emp_designation; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select Designation</option>
                        <?php } ?>
                        <?php $arr = mysql_query("select * from tbl_teacher_designation where school_id='$sc_id'"); 
						 while ($row = mysql_fetch_array($arr)) { 
						 $t_class=$row['designation'];
						?>
                        <?php if ($emp_designation != $t_class) { ?>
                            <option value="<?php echo $t_class;?>"><?php echo $t_class;?></option>
						 <?php }
                            
                         }?>
			  
				  </select>
                </div>
				<div class='col-md-3 error1' id="errordiv" style="color:#FF0000"></div>
               </div>
			   
			   <?php } ?>
			   
              
			  <div class="form-group">

            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;" ><?php echo $dynamic_year; ?><span class="error"><b style="color:red";> *</b></span></label>
           
              
                <div class='col-md-3' style="text-align:left;">
                 <select name='Intruduce_YeqarID' id='Intruduce_YeqarID' class='form-control'>
					 <?php
                        echo $Academic_Year;
                        if ($Academic_Year != '') {
                            ?>
                            <option value='<?php echo $Academic_Year ?>'
                                    selected><?php echo $Academic_Year; ?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select <?php echo $dynamic_year; ?></option>
                        <?php } ?>
                        <?php $arr = mysql_query("select * from tbl_academic_Year where school_id='$sc_id' and Academic_Year != ''"); 
						 while ($row = mysql_fetch_array($arr)) { 
						$ExtYearID = $row['ExtYearID'];
						$Year = $row['Year'];
						$AcademicYear = $row['Academic_Year'];
						?>
                        <?php if ($Academic_Year != $AcademicYear) { ?>
                            <option value='<?php echo $AcademicYear;?>'><?php echo $AcademicYear;?></option>
						 <?php }
                            
                         }?>
                
                    </select>
                </div>
				<div class='col-md-3 error1' id="errorAY" style="color:#FF0000"></div>
               </div>
			  
			  
			  
           <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'  style="text-align:left;">E-Mail<span class="error"><b style="color:red";> *</b></span></label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='id_email' name="id_email" placeholder='E-mail' type='text'  value="<?php echo $std_email; ?>">
                </div>
				<div class='col-md-2 error1' id="erroremail" style="color:#FF0000"></div>
				</div>
				
				 <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='in_email'  style="text-align:left;">Internal E-Mail<span class="error"> </span></label>
           <div class='col-md-3' style="text-align:left;">
                  <input class='form-control' id='in_email' name="in_email" placeholder='Internal E-mail' type='text'  value="<?php echo $std_internal_email; ?>">
                </div>
				<div class='col-md-2 error1' id="errorinemail" style="color:#FF0000"></div>
				</div>
				
                 
         

			 <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Date Of Birth<span class="error"></span></label>
            <div class='col-md-3' style="text-align:left;">

			<!-- Changes done by Pranali on 28-06-2018 for bug SMC-3200 -->

             <input type="text"  id='id_checkin' name="id_checkin" value="<?php echo $std_dob; ?>" class="form-control" />

			<!-- Changes end-->

             </div>
			 <div class='col-md-3 error1' id="errordob" style="color:#FF0000"></div>
         </div>

   <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Gender<span class="error"> <b style="color:red";> *</b></span></label>
     <div class='col-md-2' style="font-weight: 600;color: #777;">
                <input type="radio" name="gender" <?php if ($std_gender == "Male") {
                    echo "checked";
                } ?> id="gender1" value="Male"> Male
            </div>
            <div class='col-md-2' style="font-weight: 600; color: #777;">
                <input type="radio" name="gender" <?php if ($std_gender == "Female") {
                    echo "checked";
                } ?> id="gender2" value="Female"> Female
            </div>
			  <div class='col-md-3 error1' id="errorgender" style="color:#FF0000"></div>
          
             </div>
       <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Address<span class="error"></span></label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='id_address' name="id_address" placeholder='Address' rows='3' style="resize:none;" value=""><?php echo $std_permanant_add; ?></textarea>
            </div>
            <div class='col-md-4 indent-small error1' id="erroraddress" style="color:#FF0000"></div>
       </div>
	   
 <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Temporary Address<span class="error"><b> </b></span></label>
            <div class='col-md-3' style="text-align:left;">
              <textarea class='form-control' id='t_address' name="t_address" placeholder='Temporary Address' rows='3' style="resize:none;"value=""><?php echo $std_temp_address; ?></textarea>
            </div>
            <div class='col-md-4 indent-small error1' id="errortaddress" style="color:#FF0000"></div>
       </div>

        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">Country<b style="color:red";> *</b></label>
                <div class='col-md-3'>
                    <select id="country" name="country" class='form-control'></select>
                </div>
                <div class='col-md-3 indent-small' id="errorcountry" style="color:#FF0000"></div>
            </div>
		
		 

		<div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' style="text-align:left;">State<b style="color:red";> *</b></label>
                <div class='col-md-3'>
                    <select name="state" id="state" class='form-control'></select>
                </div>
                <div class='col-md-3 indent-small' id="errorstate" style="color:#FF0000"></div>
            </div>
			
           <script language="javascript">
            populateCountries("country", "state");
            populateCountries("country2");
        </script>

		<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Permanent Village<span class="error"> </span></label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='PermanentVillage' name='PermanentVillage' value="<?php echo $std_permanant_village; ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errorvillage" style="color:#FF0000"></div>
          </div>
		  
		  <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Permanent Taluka<span class="error"> </span></label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='PermanentTaluka' name='PermanentTaluka' value="<?php echo $std_permanant_taluka; ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errortaluka" style="color:#FF0000"></div>
          </div>
		  
		  <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Permanent District<span class="error"> </span></label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='PermanentDistrict' name='PermanentDistrict' value="<?php echo $std_permanant_district; ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errorDIST" style="color:#FF0000"></div>
          </div>
		
<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">City<span class="error"> <b style="color:red";> *</b></span></label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='id_accomodation' name='city' value="<?php echo $std_city; ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errorcity" style="color:#FF0000"></div>
          </div>
		 
<div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2'  style="text-align:left;">Permanent Pincode
<span class="error"> </span></label>
            <div class='col-md-3' style="text-align:left;">
              <input type="text" class='form-control' id='PermanentPincode' name='PermanentPincode' value="<?php echo $std_permanant_pincode ?>">
            </div>
            <div class='col-md-4 indent-small error1' id="errorpincode" style="color:#FF0000"></div>
          </div>		 
		  
         <div class='form-group'>
            <div class='col-md-3 col-md-offset-3'>
                <center><input class='btn-lg btn-primary' type='submit' value="Update" name="update" onClick="return valid()"/>
                    <!-- onClick="return valid()"/>-->
            </div>

            <div class='col-md-2'>
                <a href="studentlist.php"><input type="button" class='btn-lg btn-danger' value="Cancel"/> </a>
            </div>
        </div>
  </form>
      </div>
</div>
</body>
</html>

    <script>
	$(document).ready(function () {
		  var country = "<?php echo $std_country ?>" ;
		  var  state = "<?php echo $std_state ?>" ;
		  $("#country").val(country).change();
		  $("#state").val(state).change();
	});
</script>   

