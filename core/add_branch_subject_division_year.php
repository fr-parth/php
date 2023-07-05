<?php
                           /*Created New Form By Dhanashri_Tak Intern */
$report="";
//Updated by Rutuja for SMC-5164 for merging Add & Edit pages. Made same page for add & edit on 22-02-2021
include('scadmin_header.php');

$id=$_SESSION['id'];

           $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$result=mysql_fetch_array($results);
//school id removed from session by Pranali for SMC-5051
$sc_id=$_SESSION['school_id'];
if(isset($_GET['subject']))
{
$subject_id = $_GET['subject'];
    //echo "select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";
    $sql1 = "select * from Branch_Subject_Division_Year where id='$subject_id' and school_id='$sc_id'";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $id = $arr['id'];	
}

if(isset($_POST['submit']))

{
	$sub = $_POST['SubjectTitle'];
	$s= explode(",", $sub);
	$SubjectTitle = $s['0'];
	$Intruduce_YeqarID = $_POST['Intruduce_YeqarID'];
$ExtSchoolSubjectId = $_POST['ExtSchoolSubjectId'];
$SubjectCode = $_POST['SubjectCode'];
$SubjectType = $_POST['SubjectType'];
$SubjectShortName = $_POST['SubjectShortName'];
$IsEnable = $_POST['IsEnable'];
$DeptID = $_POST['DeptID'];
$dept = $_POST['DeptName'];
$dept1= explode(",", $dept);
$DeptName = $dept1['1'];
$BranchID = $_POST['BranchID'];
$branch = $_POST['BranchName'];
$branch1= explode(",", $branch);
$BranchName = $branch1['1'];

$DevisionId = $_POST['DevisionId'];
$div = $_POST['DivisionName'];
$div1= explode(",", $div);
$DivisionName = $div1['1'];
$ExtYearID = $_POST['ExtYearID'];
$year = $_POST['Year'];
$y1= explode(",", $year);
$Year = $y1['1'];

// SMC-5005 by Pranali : Added || $user == 'School Admin Staff' in if condition for displaying course level and semester name to School Admin Staff also.
	if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user == 'School Admin Staff'){
	//echo "sgbrfuygrf";
$course = $_POST['CourseLevel'];
$course1= explode(",", $course);
$CourseLevel = $course1['1'];
$CourseLevelPID = $_POST['CourseLevelPID'];
$SemesterID = $_POST['SemesterID'];
$sem = $_POST['SemesterName'];
$sem1= explode(",", $sem);
$SemesterName = $sem1['1'];
 
	 
 }else{
$CourseLevel = "";
$CourseLevelPID = "";
$SemesterID = "";
$SemesterName = "";
 }
/*echo "insert into Branch_Subject_Division_Year(Intruduce_YeqarID,ExtSchoolSubjectId,SubjectTitle,SubjectCode,
SubjectType,SubjectShortName,IsEnable,CourseLevel,CourseLevelPID,DeptID,DeptName,BranchID,BranchName,SemesterID,SemesterName
,DevisionId,DivisionName,ExtYearID,Year)values('$Intruduce_YeqarID','$ExtSchoolSubjectId','$SubjectTitle','$SubjectCode',
'$SubjectType','$SubjectShortName','$IsEnable','$CourseLevel','$CourseLevelPID','$DeptID','$DeptName','$BranchID','$BranchName','$SemesterID',
'$SemesterName','$DevisionId','$DivisionName','$ExtYearID ','$Year')";*/

if(isset($_GET['subject']))
{	
$sql1= mysql_query("update Branch_Subject_Division_Year set Intruduce_YeqarID='$Intruduce_YeqarID', SubjectTitle='$SubjectTitle', SubjectCode='$SubjectCode', SubjectType='$SubjectType',SubjectShortName='$SubjectShortName', 	IsEnable='$IsEnable',CourseLevelPID='$CourseLevelPID',ExtDeptId='$DeptID',DeptName='$DeptName',ExtBranchId='$BranchID', ExtSemesterId='$SemesterID', SemesterName='$SemesterName', ExtDivisionID='$DevisionId',DivisionName='$DivisionName',BranchName='$BranchName',CourseLevel='$CourseLevel',Year='$Year' where id='$id' and school_id='$sc_id'");
$msg = "Updated succesfully";
$error = "Not updated";
}
else{
$sql1 = mysql_query("insert into Branch_Subject_Division_Year(school_id,Intruduce_YeqarID,ExtSchoolSubjectId,SubjectTitle,SubjectCode,
SubjectType,SubjectShortName,IsEnable,CourseLevel,CourseLevelPID,ExtDeptId,DeptName,ExtBranchId,BranchName,ExtSemesterId,SemesterName,
ExtDivisionID,DivisionName,ExtYearID,Year)
values('$sc_id','$Intruduce_YeqarID','$ExtSchoolSubjectId','$SubjectTitle','$SubjectCode',
'$SubjectType','$SubjectShortName','$IsEnable','$CourseLevel','$CourseLevelPID','$DeptID',
'$DeptName','$BranchID','$BranchName','$SemesterID',
'$SemesterName','$DevisionId','$DivisionName','$ExtYearID ','$Year')");
$msg = "Added succesfully";
$error = "Not Inserted";
}
if($sql1)
{
	
	echo "<script LANGUAGE='JavaScript'>
					alert('$msg');	window.location.href='branch_subject_master.php';
					</script>";
}
else
{
	echo '<span style="font-weight: bold; align: center; color: Red
	;">"'.$error.'"</span>';
	//echo"not inserted";
}

//$sql1 = mysql_query("select * from tbl_school_subject where subject=$subject_name");
//$count1 = mysql_num_rows($sql1);

//$sql2 = mysql_query("select * from tbl_school_subject where Subject_Code=$subject_code");
//$count2 = mysql_num_rows($sql2);

//if($count1==0 and $count2==0)
//{
	//echo "insert into tbl_school_subject (Subject_Code,subject,Branch_ID,Year_ID,Course_Level_PID,school_id)values('$subject_code','$subject_name','$branch_name','$year','$course_level','$sc_id')";
	
	//$sql1 = mysql_query("insert into tbl_school_subject (Subject_Code,subject,Branch_ID,Year_ID,Course_Level_PID,school_id)values('$subject_code','$subject_name','$branch_name','$year','$course_level','$sc_id')");
	
}
//else
//{
	
	//echo "<script>alert('SUbject already exists')</script>";
//}












?>

<html>

<head>


<script>


function Relationfunction(value,fn)
{
	//Added undefined condition for solving issue of blank dept id is shown at time of edit by Pranali for SMC-5164 on 13-3-21
 if(value!='' && fn!=undefined)
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
				if(fn=='fun_academc')
				{
					 document.getElementById("Year").innerHTML =xmlhttp.responseText;

				}
				
				

            }
          }
xmlhttp.open("GET","get_branch_sub_division.php?fn="+fn+"&value="+value,true);
        xmlhttp.send();
 }
 //alert(value);
 var course = document.getElementById("CourseLevel").value;
 var c= course.split(",");
 var strCourseLevelID=c[0];
					 document.getElementById("CourseLevelPID").value =strCourseLevelID;
 
                     var dept1 = document.getElementById("DeptName").value;
                     var d= dept1.split(",");
 					 var strDeptNameID=d[0];
					 document.getElementById("DeptID").value =strDeptNameID;
 				


 var branch = document.getElementById("BranchName").value;
 var b= branch.split(",");
 var strBranchNameeID=b[0];
					 document.getElementById("BranchID").value =strBranchNameeID;
 
 var sem = document.getElementById("SemesterName").value;
 var s= sem.split(",");
 var strSemesterNameID=s[0];
					 document.getElementById("SemesterID").value =strSemesterNameID;
					 
					 var div = document.getElementById("DivisionName").value;
					 var d1= div.split(",");
 var strDivisionNameID=d1[0];
					 document.getElementById("DevisionId").value =strDivisionNameID;
 
					var year = document.getElementById("Year").value;
					var y= year.split(",");
 var strYearID=y[0];
					 document.getElementById("ExtYearID").value =strYearID;

var subject = document.getElementById("SubjectTitle").value; 
var s= subject.split(",");
var s1=s[1];var s2=s[2];var s3=s[3];var s4=s[4];
if(s1=='blank')
{
s1 = "";
}
if(s2=='blank'){
s1 = "";
}
if(s3=='blank')
{
s1 = "";
}
if(s4=='blank'){
s1 = "";
}
document.getElementById("ExtSchoolSubjectId").value =s1;
document.getElementById("SubjectShortName").value =s2;
document.getElementById("SubjectType").value =s3;
document.getElementById("SubjectCode").value =s4;
				
}


</script>
<script>


function formvalidation()

			{   
				var IntroYD = /^[0-9]+$/;
			    var ExtSS = /^[0-9]+$/;  
				var Sub1 = /^[a-zA-Z0-9\s]+$/;  
				var Code = /^[a-zA-Z0-9]+$/;
				var type = /^[a-zA-Z]+$/;
				var Sname = /^[a-zA-Z0-9]+$/;  
				var Isen = /^[0-9]+$/;
				var course= /^[a-zA-Z]+$/;
				var course1= /^[0-9]+$/;
				var Dept1=/^[0-9]+$/;
				var DeptName1=/^[a-zA-Z0-9]+$/;
				var BranchID1=/^[0-9]+$/;
				var BranchN1=/^[a-zA-Z0-9]+$/;
				var SemesterID1=/^[0-9]+$/;
				var SemesterName1=/^[a-zA-Z0-9]+$/;
				var DevisionId1=/^[0-9]+$/;
				var DivisionName1=/^[a-zA-Z0-9]+$/;
				var ExtYearID1=/^[0-9]+$/;
				var Year1=/^[0-9]+$/;

                var Intruduce_YeqarID = document.getElementById("Intruduce_YeqarID").value;
				var ExtSchoolSubjectId = document.getElementById("1").value;
			    var SubjectTitle = document.getElementById("SubjectTitle").value;
				var SubjectCode = document.getElementById("SubjectCode").value;
				var SubjectType = document.getElementById("SubjectType").value;
				var SubjectShortName = document.getElementById("SubjectShortName").value;
			    var IsEnable = document.getElementById("IsEnable").value;
				var CourseLevel= document.getElementById("CourseLevel").value;
				var CourseLevelPID= document.getElementById("CourseLevelPID").value;
				var DeptID=document.getElementById("DeptID").value;
				var DeptName=document.getElementById("DeptName").value;
                var BranchID=document.getElementById("BranchID").value;
				var BranchName=document.getElementById("BranchName").value;
				var SemesterID=document.getElementById("SemesterID").value;
				var SemesterName=document.getElementById("SemesterName").value;
				var DevisionId=document.getElementById("DevisionId").value;
				var DivisionName=document.getElementById("DivisionName").value;
				var ExtYearID=document.getElementById("ExtYearID").value;
				var Year=document.getElementById("Year").value;

//1. IntroYD
				  if ((Intruduce_YeqarID== "") || (Intruduce_YeqarID == null))
			  {
					    document.getElementById('errorname').innerHTML='Introduce_YearID is mandatory';
				//alert("Introduce_YearID is mandatory");
							   return false;
			  }
			  if(IntroYD.test(Intruduce_YeqarID)== false)
			   {
				     document.getElementById('errorname').innerHTML='Introduce_YearID should be Number only';
					//alert("Introduce_YearID should be Number only");
					return false;
				}
				else{
				  document.getElementById('errorname').innerHTML='';
                    }//End of intro_year

 //2.  ExtSchoolSubjectId
		
            if ((ExtSchoolSubjectId== "") || (ExtSchoolSubjectId == null))
			  {
					    document.getElementById('errorname1').innerHTML='Ext<?php echo $dynamic_school ." ". $dynamic_subject;?>Id is mandatory';
				  //alert("Introduce_YearID is mandatory");
							   return false;
			  }
			  if(ExtSS.test(ExtSchoolSubjectId)== false)
			   {
				     document.getElementById('errorname1').innerHTML='Ext<?php echo $dynamic_school ." ". $dynamic_subject;?>Id should be Number only';
					//alert("Introduce_YearID should be character only");
					return false;
				} 
			else{
				  document.getElementById('errorname1').innerHTML='';
                    
			  }//End of ExtSS

			
 //3.SubjectTitle	
		 if ((SubjectTitle== "") || (SubjectTitle == null))          
			  {
					    document.getElementById('errorname2').innerHTML='<?php echo $dynamic_subject; ?>Title is mandatory';
				// alert("SubjectTitle is mandatory");
							   return false;
			  }

		 if(Sub1.test(SubjectTitle)== false)
			   {
				     document.getElementById('errorname2').innerHTML='<?php echo $dynamic_subject; ?>Title should be Number only';
					//alert("SubjectTitle should be Number only");
					return false;
				} 
		 else{
				  document.getElementById('errorname2').innerHTML='';
                    
			  }//End of subjett

           
 //4.SubjectCode
		 if ((SubjectCode== "") || (SubjectCode == null))              
			  {
					    document.getElementById('errorcode').innerHTML='<?php echo $dynamic_subject; ?>Code is mandatory';
				//  alert("SubjectCode is mandatory");
							   return false;
			  }
			  if(Code.test(SubjectCode)== false)
			   {
				     document.getElementById('errorcode').innerHTML='<?php echo $dynamic_subject; ?>Code should be Number only';
				//	alert("SubjectCode should be Number only");
					return false;
				} 
				else{
				  document.getElementById('errorcode').innerHTML='';
                    
			  }//End of Subcode

				 
//5.SubjectType
				 if ((SubjectType== "") || (SubjectType == null))
			  {
					    document.getElementById('errortype').innerHTML='<?php echo $dynamic_subject; ?>Type is mandatory';
				//  alert("SubjectType is mandatory");
							   return false;
			  }
			  if(type.test(SubjectType)== false)
			   {
				     document.getElementById('errortype').innerHTML='<?php echo $dynamic_subject; ?>Type should be Alphabets only';
				//	alert("SubjectType should be Alphabets only");
					return false;
				} 
				else{
				  document.getElementById('errortype').innerHTML='';
                    
			  }//End of SubType

//6.SubjectShortName
				 if ((SubjectShortName== "") || (SubjectShortName == null))
			  {
					    document.getElementById('errorSname').innerHTML='<?php echo $dynamic_subject; ?>ShortName is mandatory';
				//  alert("SubjectShortName is mandatory");
							   return false;
			  }
			  if(Sname.test(SubjectShortName)== false)
			   {
				     document.getElementById('errorSname').innerHTML='<?php echo $dynamic_subject; ?>ShortName should be Number only';
					//alert("SubjectShortName should be Number only");
					return false;
				} 
				else{
				  document.getElementById('errorSname').innerHTML='';
                    
			  }//End of SubSName

				
//7.IsEnable
				 if ((IsEnable== "") || (IsEnable == null))
			  {
					    document.getElementById('errorIs').innerHTML='IsEnable is mandatory';
				  //alert("IsEnable is mandatory");
							   return false;
			  }
			  if(Isen.test(IsEnable)== false)
			   {
				     document.getElementById('errorIs').innerHTML='IsEnable should be Number only';
				//	alert("IsEnable should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorIs').innerHTML='';
                    
			  }//End of IsEnable

//8.Courselevel
				 if ((CourseLevel== "") || (CourseLevel == null))
			  {
					    document.getElementById('errorcourse').innerHTML='CourseLevel is mandatory';
				 // alert("CourseLevel is mandatory");
							   return false;
			  }
			  if(course.test(CourseLevel)== false)
			   {
				     document.getElementById('errorcourse').innerHTML='CourseLevel should be Alphabet only';
					//alert("CourseLevel should be Alphabet only");
					return false;
				} 
            else{
				  document.getElementById('errorcourse').innerHTML='';
                    
			  }//End of Courselevel

//9.CourselevelID
				 if ((CourseLevelPID== "") || (CourseLevelPID == null))
			  {
					    document.getElementById('errorcourseid').innerHTML='CourseLevelID is mandatory';
				  alert("CourseLevelID is mandatory");
							   return false;
			  }
			  if(course1.test(CourseLevelPID)== false)
			   {
				     document.getElementById('errorcourseid').innerHTML='CourseLevelID should be Number only';
				//	alert("CourseLevelPID should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorcourseid').innerHTML='';
                    
			  }//End of CourselevelID
              
 //10.Department_ID
				 if ((DeptID== "") || (DeptID == null))
			  {
					    document.getElementById('errordeptid').innerHTML='Department_ID is mandatory';
				 // alert("Department_ID is mandatory");
							   return false;
			  }
			  if(Dept1.test(DeptID)== false)
			   {
				     document.getElementById('errordeptid').innerHTML='Department_ID should be Number only';
					//alert("Department_ID should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errordeptid').innerHTML='';
                    
			  }//End of Department_ID

//11.Department_Name
				 if ((DeptName== "") || (DeptName == null))
			  {
					    document.getElementById('errordeptN').innerHTML='Department_Name is mandatory';
				//  alert("Department_Name is mandatory");
							   return false;
			  }
			  if(DeptName1.test(DeptName)== false)
			   {
				     document.getElementById('errordeptN').innerHTML='Department_Name should be  Alpha Numeric  only';
				//	alert("Department_Name should be Alpha Numeric only");
					return false;
				} 
            else{
				  document.getElementById('errordeptN').innerHTML='';
                    
			  }//End of Department_Name

//12.Branch_ID
				 if ((BranchID== "") || (BranchID == null))
			  {
					    document.getElementById('errorBranch').innerHTML='<?php echo $dynamic_branch;?>ID is mandatory';
				//  alert("BranchID is mandatory");
							   return false;
			  }
			  if(BranchID1.test(BranchID)== false)
			   {
				     document.getElementById('errorBranch').innerHTML='<?php echo $dynamic_branch;?>ID should be Number  only';
				//	alert("BranchID should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorBranch').innerHTML='';
                    
			  }//End of Branch_ID


 //13.Branch_Name
				 if ((BranchName== "") || (BranchName == null))
			  {
					    document.getElementById('errorBranchN').innerHTML='<?php echo $dynamic_branch;?>Name is mandatory';
				//  alert("BranchName is mandatory");
							   return false;
			  }
			  if(BranchN1.test(BranchName)== false)
			   {
				     document.getElementById('errorBranchN').innerHTML='<?php echo $dynamic_branch;?>Name should be Alpha Numeric  only';
				//	alert("BranchName should be Alpha Numeric only");
					return false;
				} 
            else{
				  document.getElementById('errorBranchN').innerHTML='';
                    
			  }//End of BranchName

 //14.SemesterID
				 if ((SemesterID== "") || (SemesterID == null))
			  {
					    document.getElementById('errorSem').innerHTML='SemesterID is mandatory';
				//  alert("SemesterID is mandatory");
							   return false;
			  }
			  if(SemesterID1.test(SemesterID)== false)
			   {
				     document.getElementById('errorSem').innerHTML='SemesterID should be Number  only';
				//	alert("SemesterID should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorSem').innerHTML='';
                    
			  }//End of SemesterID

 //15.SemesterName
				 if ((SemesterName== "") || (SemesterName == null))
			  {
					    document.getElementById('errorSem1').innerHTML='SemesterName is mandatory';
				//  alert("SemesterName is mandatory");
							   return false;
			  }
			  if(SemesterName1.test(SemesterName)== false)
			   {
				     document.getElementById('errorSem1').innerHTML='SemesterName should be Alpha Numeric  only';
			//		alert("SemesterName should be Alpha Numeric only");
					return false;
				} 
            else{
				  document.getElementById('errorSem1').innerHTML='';
                    
			  }//End of SemesterName

 //16.DevisionId
				 if ((DevisionId== "") || (DevisionId == null))
			  {
					    document.getElementById('errorDev1').innerHTML='DivisionId is mandatory';
			//	  alert("DivisionId is mandatory");
							   return false;
			  }
			  if(DevisionId1.test(DevisionId)== false)
			   {
				     document.getElementById('errorDev1').innerHTML='DivisionId should be Number only';
			//		alert("DivisionId should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorDev1').innerHTML='';
                    
			  }//End of DevisionId

//17.DevisionName
				 if ((DivisionName== "") || (DivisionName == null))
			  {
					    document.getElementById('errorDevN1').innerHTML='DivisionName is mandatory';
				//  alert("DivisionName is mandatory");
							   return false;
			  }
			  if(DivisionName1.test(DivisionName)== false)
			   {
				     document.getElementById('errorDevN1').innerHTML='DivisionName should be Alpha Numeric only';
					//alert("DivisionName should be Alpha Numeric only");
					return false;
				} 
            else{
				  document.getElementById('errorDevN1').innerHTML='';
                    
			  }//End of DevisionName


//18.ExtYearID
				 if ((ExtYearID== "") || (ExtYearID == null))
			  {
					    document.getElementById('errorExtY').innerHTML='ExtYearID is mandatory';
				 // alert("ExtYearID is mandatory");
							   return false;
			  }
			  if(ExtYearID1.test(ExtYearID)== false)
			   {
				     document.getElementById('errorExtY').innerHTML='ExtYearID should be Number only';
				//	alert("ExtYearID should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorExtY').innerHTML='';
                    
			  }//End of ExtYearID


//19.Year
				 if ((Year== "") || (Year == null))
			  {
					    document.getElementById('errorYear').innerHTML='Year is mandatory';
				 // alert("Year is mandatory");
							   return false;
			  }
			  if(Year1.test(Year)== false)
			   {
				     document.getElementById('errorYear').innerHTML='Year should be Number only';
				//	alert("Year should be Number only");
					return false;
				} 
            else{
				  document.getElementById('errorYear').innerHTML='';
                    
			  }//End of Year





			}//End of function
</script>

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div class="container" style="padding:25px;"" >

        	

	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;
			box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="POST" action="">

                    
<!--Added required and pattern in all fields for validation by Pranali for SMC-5051-->
                    

                    <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" ></div>

						<div class="col-md-5 " align="center" style="color:#663399;" >

                         	<h2>Add <?php echo $dynamic_branch ." ". $dynamic_subject;?> </h2>
							<!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
							<!--<h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>-->

						</div>

                         

                    </div>

                  
				

				<div class="row formgroup" style="padding:5px;" >
<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff'){?>
				<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Course Level: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                             
                       <select name="CourseLevel" class="form-control " id="CourseLevel"  onChange="Relationfunction(this.value,'fun_course')" required="">
                       	 <?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['CourseLevelPID'];?>,<?php echo $arr['CourseLevel'];?>"><?php echo $arr['CourseLevel'];?></option> 
                        <?php }else{ ?>  
					   <option value="">Select Course Level</option>
					<?php } ?>
						<?php 
						$sql = "select DISTINCT CourseLevel , ExtCourseLevelID from tbl_CourseLevel where school_id='$sc_id' and ExtCourseLevelID !=''";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtCourseLevelID = $row['ExtCourseLevelID'];
							$CourseLevel = $row['CourseLevel'];
							echo "<option value='$ExtCourseLevelID,$CourseLevel'>$CourseLevel</option>";
						}
						?>
					   </select>
					    <div class='form-group' id="errorcourse" style="color:#FF0000"></div>

                            </div>
                        </div>



						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">CourseLevel ID: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                       <input type="text" name="CourseLevelPID" class="form-control " id="CourseLevelPID" placeholder="CourseLevel ID" required="" pattern="[0-9]+" readonly value="<?php echo $arr['CourseLevelPID'];?>"/>
					     <div class='form-group' id="errorcourseid" style="color:#FF0000"></div>

                            </div>
                        </div>
<?php }?>
						
				<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;" >Department Name: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
 <!--SMC-5164 by Pranali : Modified  DeptID and DeptName value for solving issue of blank records were displayed in dept dropdown value attribute -->
                        <select name="DeptName" class="form-control " id="DeptName" onChange="Relationfunction(this.value,'fun_dept')" required>
                         <?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['DeptID'];?>,<?php echo $arr['DeptName'];?>"><?php echo $arr['DeptName'];?></option> 
                        <?php }else{ ?>  
					  <option value="">Select Department</option>
						<?php } ?>	
						
						<?php 
						$sql = "select * from tbl_department_master where School_ID='$sc_id'";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtDeptId = $row['ExtDeptId'];
							$Dept_Name = $row['Dept_Name'];
							echo "<option value='$ExtDeptId,$Dept_Name'>$Dept_Name</option>";
						}
						?>
						</select>
                          <div class='form-group' id="errordeptN" style="color:#FF0000"></div>
							</div>
                        </div>
						
						
				
				<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Department ID: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                       <input type="text" name="DeptID" class="form-control " id="DeptID" placeholder="Department ID" required="" pattern="[a-zA-Z0-9]+" readonly value="<?php echo $arr['DeptID'];?>"/>
					     <div class='form-group' id="errordeptid" style="color:#FF0000"></div>


                            </div>
                        </div>



						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_branch;?> Name: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                      <select name="BranchName" class="form-control " id="BranchName" onChange="Relationfunction(this.value,'fun_branch')" required>
                      	<?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['BranchID'];?>,<?php echo $arr['BranchName'];?>"><?php echo $arr['BranchName'];?></option> 
                        <?php }else{ ?>  
					  <option value="">Select <?php echo $dynamic_branch;?> Name</option>
						<?php } ?>

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
					   <div class='form-group' id="errorBranchN" style="color:#FF0000"></div>

                            </div>
                        </div>
						
						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_branch;?> ID: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                      <input type="text" name="BranchID" class="form-control " id="BranchID" placeholder="Branch ID" required="" pattern="[0-9]+" readonly value="<?php echo $arr['BranchID'];?>"/>
					  <div class='form-group' id="errorBranch" style="color:#FF0000"></div>

                            </div>
                        </div>
						
						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $designation; ?> Name: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                        <select name="DivisionName" class="form-control " id="DivisionName" onChange="Relationfunction(this.value)" required>
                        <?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['DevisionId'];?>,<?php echo $arr['DivisionName'];?>"><?php echo $arr['DivisionName'];?></option> 
                        <?php }else{ ?>  
					  <option value="">Select <?php echo $designation;?> Name</option>
						<?php } ?>	
						
						<?php 
						$sql = "select DISTINCT DivisionName,ExtDivisionID  from Division where school_id='$sc_id' and DivisionName != ''";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$ExtDivisionID = $row['ExtDivisionID'];
							$DivisionName = $row['DivisionName'];
							echo "<option value='$ExtDivisionID,$DivisionName'>$DivisionName</option>";
						}
						?>
						</select>
						 <div class='form-group' id="errorDevN1" style="color:#FF0000"></div>
                            </div>
                        </div>
						
						
						 <div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $designation; ?> Id: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                       <input type="text" name="DevisionId" class="form-control " id="DevisionId" placeholder="Division Id" required pattern="[0-9]+" readonly value="<?php echo $arr['DevisionId'];?>"/>
					   <div class='form-group' id="errorDev1" style="color:#FF0000"></div>
					
                            </div>
                        </div>
						<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff'){?>
						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Semester Name: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                        <select name="SemesterName" class="form-control " id="SemesterName" onChange="Relationfunction(this.value)" required> 
                        <?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['SemesterID'];?>,<?php echo $arr['SemesterName'];?>"><?php echo $arr['SemesterName'];?></option> 
                        <?php }else{ ?>  
					  <option value="">Select Semester</option>
						<?php } ?>	
						
						</select>
						<div class='form-group' id="errorSem1" style="color:#FF0000"></div>

                            </div>
                        </div>
						
						
                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Semester ID: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                        <input type="text" name="SemesterID" class="form-control " id="SemesterID" placeholder="Semester ID" required pattern="[0-9]+" readonly value="<?php echo $arr['SemesterID'];?>"/>
						   <div class='form-group' id="errorSem" style="color:#FF0000"></div>

                            </div>
                        </div>
						<?php } ?>
                <div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_year;?>: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                                <select name="Intruduce_YeqarID" class="form-control " id="Intruduce_YeqarID" onChange="Relationfunction(this.value,'fun_academc')" required>
                         <?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['Intruduce_YeqarID'];?>"><?php echo $arr['Intruduce_YeqarID'];?></option> 
                        <?php }else{ ?>  
					  <option value="">Select <?php echo $dynamic_year;?></option>
						<?php } ?>		
								
						<?php 
						$sql = "select DISTINCT Academic_Year,Year from tbl_academic_Year where school_id='$sc_id' and Academic_Year != ''";
						$result = mysql_query($sql);
						while($row=mysql_fetch_array($result))
						{
							$Year = $row['Year'];
							$Academic_Year = $row['Academic_Year'];
							echo "<option value='$Academic_Year'>$Academic_Year</option>";
						}
						?>
								</select>
		<div class='form-group' id="errorname" style="color:#FF0000"></div>
                            </div>
                        </div>

<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Year: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                          <select name="Year" class="form-control " id="Year" onChange="Relationfunction(this.value,'fun_yearid')" required>
                          	<?php if(isset($_GET['subject'])){ ?>
                        <option value="<?php echo $arr['ExtYearID'];?>,<?php echo $arr['Year'];?>"><?php echo $arr['Year'];?></option> 
                        <?php }else{ ?>  
					   <option value="">Select Year</option>
						<?php } ?>
						 
						  </select>
                     <div class='form-group' id="errorYear" style="color:#FF0000"></div>
                            </div>
                        </div>
						
					<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">ExtYearID: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                           <input type="text" name="ExtYearID" class="form-control " id="ExtYearID"  required="" pattern="[0-9]+" readonly value="<?php echo $arr['ExtYearID'];?>"/>
						    <div class='form-group' id="errorExtY" style="color:#FF0000"></div>
                            </div>
                        </div>

                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_subject;?>: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                       <select name="SubjectTitle" class="form-control " id="SubjectTitle" required="" onChange="Relationfunction(this.value)">
                       	<?php if(isset($_GET['subject'])){ 
                       		$ExtSchoolSubjectId=$arr['ExtSchoolSubjectId'];
                       		$Subject_short_name=$arr['Subject_short_name'];
                       		$Subject_type=$arr['Subject_type'];
                       		$Subject_Code=$arr['Subject_Code'];
                       		if($arr['ExtSchoolSubjectId']==''){
                                    		$ExtSchoolSubjectId='blank';
                                    	}
                                    	if($arr['Subject_short_name']==''){
                                    		$Subject_short_name='blank';
                                    	}
                                    	if($arr['Subject_type']==''){
                                    		$Subject_type='blank';
                                    	}
                                    	if($arr['Subject_Code']==''){
                                    		$Subject_Code='blank';
                                    	}
                       		?>
                        <option value="<?php echo $arr['subject'];?>,<?php echo $ExtSchoolSubjectId;?>,<?php echo $Subject_short_name;?>,<?php echo $Subject_type;?>,<?php echo $Subject_Code;?>"><?php echo $arr['SubjectTitle'];?></option> 
                        <?php }else{ ?>  
					    <option value=""> Select <?php echo $dynamic_subject;?> Title</option>
						<?php } ?>
					  

                                    <?php
                                    //Below code updated by Rutuja for making all the ID fields readonly & adding Subject drop down and fetching all the Subject data automatically for SMC-5156 on 16-02-2021
                                    $sql_subject = mysql_query("select distinct subject, ExtSchoolSubjectId,Subject_short_name,Subject_type,Subject_Code from  tbl_school_subject where school_id='$sc_id' order by id");
                                    while ($result_subject = mysql_fetch_array($sql_subject)) {
                                    	if($result_subject['ExtSchoolSubjectId']==''){
                                    		$result_subject['ExtSchoolSubjectId']='blank';
                                    	}
                                    	if($result_subject['Subject_short_name']==''){
                                    		$result_subject['Subject_short_name']='blank';
                                    	}
                                    	if($result_subject['Subject_type']==''){
                                    		$result_subject['Subject_type']='blank';
                                    	}
                                    	if($result_subject['Subject_Code']==''){
                                    		$result_subject['Subject_Code']='blank';
                                    	}
                                        ?>
                                        
                                        <option value="<?php echo $result_subject['subject'];?>,<?php echo $result_subject['ExtSchoolSubjectId'];?>,<?php echo $result_subject['Subject_short_name'];?>,<?php echo $result_subject['Subject_type'];?>,<?php echo $result_subject['Subject_Code'];?>"><?php echo $result_subject['subject']?></option>
                                        
                                    <?php }
                                    ?>
					   </select>
					    <div class='form-group' id="errorcourse" style="color:#FF0000"></div>

                            </div>
                        </div>
						
                   <div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Ext <?php echo $dynamic_school ." ". $dynamic_subject;?> Id: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                               <input type="text" name="ExtSchoolSubjectId" id="ExtSchoolSubjectId" class="form-control " id="1" placeholder="Ext School SubjectId" required="" pattern="[0-9]+" value="<?php echo $arr['ExtSchoolSubjectId'];?>">
                 <div class='form-group' id="errorname1" style="color:#FF0000"></div>
                            </div>
                        </div>



					<!--<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_subject; ?> Title: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              <input type="text" name="SubjectTitle" class="form-control " id="SubjectTitle" placeholder="Subject Title" required="" pattern="[a-zA-Z0-9\s]+">
                  <div class='form-group' id="errorname2" style="color:#FF0000"></div>
                            </div>
                        </div>-->


						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_subject; ?> Code: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              <input type="text" name="SubjectCode" class="form-control " id="SubjectCode" placeholder="Subject Code" required="" pattern="[a-zA-Z-0-9]+" readonly value="<?php echo $arr['SubjectCode'];?>">
							   <div class='form-group' id="errorcode" style="color:#FF0000"></div>
                            </div>
                        </div>

						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_subject; ?> Type: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                        <input type="text" name="SubjectType" class="form-control " id="SubjectType" placeholder="Subject Type" required="" pattern="[a-zA-Z]+" value="<?php echo $arr['SubjectType'];?>">
						<div class='form-group' id="errortype" style="color:#FF0000"></div>
                            </div>
                        </div>

						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;"><?php echo $dynamic_subject; ?> ShortName: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3">
                              
                        <input type="text" name="SubjectShortName" class="form-control " id="SubjectShortName" placeholder="Subject ShortName" required="" pattern="[a-zA-Z0-9]+" value="<?php echo $arr['SubjectShortName'];?>">	
						<div class='form-group' id="errorSname" style="color:#FF0000"></div>

                            </div>
                        </div>


						<div class="row " style="padding-top:30px;">
                            <div class="col-md-3 col-md-offset-2" style="color:	#000000; font-size:18px;">Is Enable: <span style="color:red;font-size: 25px;">*</span>
                            </div>
                            <div class="col-md-3" style="margin-left: -12px;">
                           <?php 
                           	if(isset($_GET['subject'])){ 
                           	if($arr['IsEnable']==1)
							{?>
							<div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable1" value="0" required checked="checked"> Yes
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable2" value="0" required> No
              </div>
							<?php }else{?>
								<div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable1" value="1" required> Yes
             </div>
							<div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable1" value="1" required checked="checked"> No
             </div>
							<?php }
						}else{?> 	
              <div class='col-md-2'  style="font-weight: 600;color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable1" value="1" required checked="checked"> Yes
             </div>
             <div class='col-md-2'  style="font-weight: 600; color: #777;">
             <input type="radio" name="IsEnable" id="IsEnable2" value="0" required> No
              </div>
          <?php } ?>

					   <div class='form-group' id="errorIs" style="color:#FF0000"></div>
                            </div>
                        </div>


                    <div class="col-md-4" id="E-0" style="color:#FF0000;"></div>

              

				</div>
                  
				  
					<div id="error" style="color:#F00;text-align: center;" align="center"></div>

					<div id="add"></div>

					<div class="row" style="padding-top:15px;">

						<div class="col-md-2 col-md-offset-4 " >

						<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Add " 
						style="width:80px;font-weight:bold;font-size:14px;" onclick="return formvalidation()" />

						</div>

                    

						<div class="col-md-3 "  align="left">

						<a href="branch_subject_master.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

						</div>

					</div>

                 

					<div class="row" style="padding-top:15px;">

						<div class="col-md-4">

						<input type="hidden" name="count" id="count" value="1"/>

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

                                    <!--End-->



					<!--div class="col-md-3 col-md-offset-4">

						<input type="text" name="Intruduce_YeqarID" class="form-control " id="Intruduce_YeqarID" placeholder="Introduce_YearID " required>

					</div><span style="color:red;font-size: 25px;">*</span>

					<br/><br/>
</div>
				    <div class="col-md-3 col-md-offset-4">

                        <input type="text" name="ExtSchoolSubjectId" class="form-control " id="1" placeholder="Ext School SubjectId" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				    <br/><br/>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SubjectTitle" class="form-control " id="SubjectTitle" placeholder="Subject Title" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				    <br/><br/>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SubjectCode" class="form-control " id="SubjectCode" placeholder="Subject Code" required>

					</div><span style="color:red;font-size: 25px;">*</span>

				      <br/><br/>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SubjectType" class="form-control " id="SubjectType" placeholder="Subject Type" required>

					</div><span style="color:red;font-size: 25px;">*</span>
					
					<br/><br/>
				   
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SubjectShortName" class="form-control " id="SubjectShortName" placeholder="Subject ShortName" required/>

					</div><span style="color:red;font-size: 25px;">*</span>
					
					<br/><br/>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="IsEnable" class="form-control " id="IsEnable" placeholder="Is Enable" required/>

					</div><span style="color:red;font-size: 25px;">*</span>
					<br/><br/>
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="CourseLevel" class="form-control " id="CourseLevel" placeholder="Course Level" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="CourseLevelPID" class="form-control " id="CourseLevelPID" placeholder="CourseLevel PID" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="DeptID" class="form-control " id="DeptID" placeholder="Department ID" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="DeptName" class="form-control " id="DeptName" placeholder="Department Name" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="BranchID" class="form-control " id="BranchID" placeholder="Branch ID" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>


					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="BranchName" class="form-control " id="BranchName" placeholder="Branch Name" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SemesterID" class="form-control " id="SemesterID" placeholder="Semester ID" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="SemesterName" class="form-control " id="SemesterName" placeholder="Semester Name" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>

					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="DevisionId" class="form-control " id="DevisionId" placeholder="Division Id" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="DivisionName" class="form-control " id="DivisionName" placeholder="Division Name" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="ExtYearID" class="form-control " id="ExtYearID" placeholder="ExtYearID" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					
					<div class="col-md-3 col-md-offset-4">

                        <input type="text" name="Year" class="form-control " id="Year" placeholder="Year" required/>

					</div><span style="color:red;font-size: 25px;">*</span></br></br>
					
					
					<br/><br/>

                    <div class="col-md-4" id="E-0" style="color:#FF0000;"></div>

              

				</div>
                  
				  
					<div id="error" style="color:#F00;text-align: center;" align="center"></div>

					<div id="add"></div>

					<div class="row" style="padding-top:15px;">

						<div class="col-md-2 col-md-offset-4 " >

						<input type="submit" class="btn btn-primary" name="submit" value="Add " 
						style="width:80px;font-weight:bold;font-size:14px;"/>

						</div>

                    

						<div class="col-md-3 "  align="left">

						<a href="branch_subject_master.php" style="text-decoration:none;"> <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

						</div>

					</div>

                 

					<div class="row" style="padding-top:15px;">

						<div class="col-md-4">

						<input type="hidden" name="count" id="count" value="1"/>

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

</html-->