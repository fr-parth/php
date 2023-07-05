<?php
$report="";

$report1="";


include_once("scadmin_header.php");



$id=$_SESSION['id'];

	 $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$school_admin=mysql_fetch_array($results);

	

			$sc_id=$school_admin['school_id'];

			$uploadedBy=$school_admin['name'];









if(isset($_POST['submit']))



{

	$std_PRN=$_POST['student_id'];

$course1=$_POST['course'];
$course2 = explode (",", $course1); 
$course_id = $course2[0];
$course_name = $course2[1];

$department1=$_POST['department'];
$department2 = explode (",", $department1);
$department_id = $department2[0];
$department_name = $department2[1];

$branch1=$_POST['branch'];

$semester1=$_POST['semester'];

$academic_year1=$_POST['academic_year'];

$division1=$_POST['division'];

$specialization=$_POST['specialization'];

$academic_year2 = explode (",", $academic_year1); 
$academic_year = $academic_year2[1];
$yearid = $academic_year2[0];

$semester2 = explode (",", $semester1); 
$semester = $semester2[1];
$semesterid = $semester2[0];

$division2 = explode (",", $division1); 
$division = $division2[1];
$diviid = $division2[0];

$isactiv = $_POST['isactiv'];
$Is_enable = $_POST['Is_enable'];
$branch2 =  explode (",", $branch1);
 $branch = $branch2[1];
$branchids = $branch2[0]; 
//uploaded date set to current date time by Pranali for SMC-3765 on 14-5-19
$upload_date=date('Y-m-d h:i:s');



$query="insert into StudentSemesterRecord (student_id,school_id,ExtSemesterId,SemesterName,ExtBranchId,BranchName,ExtDeptId,DeptName,CourseLevel,ExtYearID,IsCurrentSemester,ExtDivisionID,ExtCourseLevelID,UpdatedBy,AcdemicYear,DivisionName,Specialization) values('$std_PRN','$sc_id','$semesterid','$semester','$branchids','$branch','$department_id','$department_name','$course_name','$yearid','$isactiv','$diviid','$course_id','$uploadedBy','$academic_year','$division','$specialization')";
$resultsd = mysql_query($query);
                       

//$report1="Subject is successfully Inserted";
echo ("<script LANGUAGE='JavaScript'>
					alert('Student Semester is successfully Inserted');
					window.location.href='student_semester_record.php';
					</script>");


}





?>





<html>







<head>



<script>



function Myfunction(value,fn)

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

					  document.getElementById("department").innerHTML =xmlhttp.responseText;

					

				}

				

				if(fn=='fun_dept')

				{

					 document.getElementById("branch").innerHTML =xmlhttp.responseText;

					

				}

				
            }

          }

       

		  xmlhttp.open("GET","get_stud_semester_details.php?fn="+fn+"&value="+value,true);

        xmlhttp.send();

		  

		  

 }

 

 

 



}



  function valid()  

       {
  

		   var student_id=document.getElementById("student_id").value;

	  if(student_id==null || student_id=="")

		{
		document.getElementById('errorstudent').innerHTML='Please select Student';
				return false;
		}
		else
		{

		document.getElementById('errorstudent').innerHTML='';
		}
		
/*			var teacher_id=document.getElementById("teacher_id").value;

	  if(teacher_id==null || teacher_id=="")
		{
		document.getElementById('errorteacher').innerHTML='Please select Teacher';
				return false;
		}
		else
		{
		document.getElementById('errorteacher').innerHTML='';
		}   
*/
	   //validaion for compnay name
var course=document.getElementById("course").value;
	  if(course==null || course=="" || course== "Select")
		{
		document.getElementById('errorcourse').innerHTML='Please select Course Level';

				return false;
		}

		else

		{
		document.getElementById('errorcourse').innerHTML='';
		}

var department=document.getElementById("department").value;

	  if(department==null || department=="" || department == "select")

		{
		document.getElementById('errordepartment').innerHTML='Please select department';
		
				return false;
		}

		else

		{
		document.getElementById('errordepartment').innerHTML='';
		}
	
 var branch=document.getElementById("branch").value

	  if(branch==null || branch=="" || branch == "select")

		{
		document.getElementById('errorbranch').innerHTML='Please select Branch';

				return false
		}

		else

		{
		document.getElementById('errorbranch').innerHTML='';

		}
 
		
      
		//
		var division=document.getElementById("division").value;

	  if(division==null || division=="" || division == "Select")

		{
		document.getElementById('errordivision').innerHTML='Please select division';

				return false;

		}

		else

		{

		document.getElementById('errordivision').innerHTML='';

		}
		
		var academic_year=document.getElementById("academic_year").value;
	  if(academic_year==null || academic_year=="" || academic_year=="Select")
		{
		document.getElementById('erroracdemic').innerHTML='Please select academic year';		

				return false;

		}

		else

		{

		document.getElementById('erroracdemic').innerHTML='';
		}
		
		var semester=document.getElementById("semester").value;

	if(semester==null || semester=="" || semester == "select")

		{

		document.getElementById('errorsemester').innerHTML='Please select semester';
	
				return false;
		}

		else

		{

		document.getElementById('errorsemester').innerHTML='';

		}
		
		
		var subject_name=document.getElementById("subject_name").value;


	  if(subject_name==null || subject_name=="" || subject_name=="Select")
		{

		document.getElementById('errorsubject_name').innerHTML='Please Enter Subject';		

				return false;

		}

		else
		{

		document.getElementById('errorsubject_name').innerHTML='';

		}
		
		   var subject_code=document.getElementById("subject_code").value;

	  if(subject_code==null || subject_code=="" || subject_code=="select")

		{

		document.getElementById('errorsubject_code').innerHTML='Please Enter Subject Code';

				return false;

		}

		else

		{

		document.getElementById('errorsubject_code').innerHTML='';

		}

	   }








</script>





</head>

<body bgcolor="#CCCCCC" >



<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;" >

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">

                   <h2 style="padding-top:30px;"><center>Add Student Semester </center></h2>

                  <!--  <center><a href="merge_student_subject.php">Insert Student Semester</a></center>-->

              

               <div class="row formgroup" style="padding:5px;">

                   <form method="post" >

				   

				   

				   <div class="row" style="padding-top:50px;">

<div class="col-md-4"></div>





 <div class="col-md-2" style="color:#808080; font-size:18px;">Student Name <span class="error" style="color:#FF0000"><b> *</b></span></div>

<div class="col-md-3">



  <select name="student_id" id="student_id" class="form-control" >

			<option value=""> Select Student</option>

             <?php 

			 $sql_teacher=mysql_query("select std_PRN,std_complete_name,std_name,std_lastname from tbl_student where school_id='$sc_id' and std_PRN!='' ");

			 while($result_teacher=mysql_fetch_array($sql_teacher))

			 {

				 if($result_teacher['std_complete_name']=='')

				 {

				 $std_complete_name=ucwords(strtolower($result_teacher['std_name']." ".$result_teacher['std_lastname']));

				 }

				 else

				 {

					 $std_complete_name=ucwords(strtolower($result_teacher['std_complete_name']));

				 }

				 ?>

				 <option value="<?php echo $result_teacher['std_PRN']?>"><?php echo ucwords(strtolower($std_complete_name))?></option>

				 <?php }

			 ?>

			 

			 

             </select>

</div>

 <div class='col-md-3 indent-small' id="errorstudent" style="color:#FF0000"></div>

 </div>





<!------------------------------------Acadmic Year----------------------------------------->





<!---------------------------------------------Degree---------------------------------->


<div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Course Level<b style="color:red";>*</b></div>

               

               <div class="col-md-3">

               



            <select name="course" id="course" class="form-control" onChange="Myfunction(this.value,'fun_course')">
<option value="">Select Course Level</option>
			

             <?php 

			 $sql_course=mysql_query("select * from tbl_CourseLevel where school_id='$sc_id' order by id");

			 while($result_course=mysql_fetch_array($sql_course))

			 {?>

				 <option value="<?php echo $result_course['ExtCourseLevelID'].',',$result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>

				 <?php }

			 ?>

			 

			 

             </select>

             </div>
					<div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                

        </div>



 <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Department<b style="color:red";>*</b></div>

               

               <div class="col-md-3"  >

			   <select name="department" id="department" class="form-control"  onChange="Myfunction(this.value,'fun_dept')" >
			   <option value="">Select Department</option>
             <?php 

			 $sql_dept=mysql_query("select * from  tbl_department_master where school_id='$sc_id' order by id");

			 while($result_dept=mysql_fetch_array($sql_dept))

			 {?>

				 <option value="<?php echo $result_dept['ExtDeptId'].','.$result_dept['Dept_Name'];?>"><?php echo $result_dept['Dept_Name'];?></option>

				 <?php }

			 ?>
             </select>
             </div>

				<div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
        </div>

        

        



  <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Branch<b style="color:red";>*</b></div>

               

               <div class="col-md-3">

               

 <select name="branch" id="branch" class="form-control" >
<option value="">Select Branch</option>
			
<?php 
//Below code added by Rutuja Jori(PHP Intern) for displaying list of branches for the bug SMC-3765 on 08/04/2019
			 $sql_branch=mysql_query("select * from  tbl_branch_master where school_id='$sc_id' group by branch_Name order by id desc");

			 while($result_branch=mysql_fetch_array($sql_branch))

			 {?>

				 <option value="<?php echo $result_branch['ExtBranchId'].','.$result_branch['branch_Name']?>"><?php echo $result_branch['branch_Name']?></option>

				 <?php }

			 ?>
			

             </select>

           

             </div>

			  <div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>

                

        </div>


		<div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Division<b style="color:red";>*</b></div>

               

               <div class="col-md-3">

   

            <select name="division" id="division" class="form-control" >

             <option value="">Select Division</option>

			 <?php $sql_div=mysql_query("select * from Division where school_id='$sc_id'");

			 while($result_div=mysql_fetch_array($sql_div))

			 {?>

				  <option value="<?php echo $result_div['ExtDivisionID'].','.$result_div['DivisionName'];?>"> <?php echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?> 

             </select>

             </div>
				<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
              

        </div>
		
		


<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year<b style="color:red";>*</b></div>

<div class="col-md-3">

<select name="academic_year" id="academic_year" class="form-control" >
<option value="">Select Academic Year</option>
<?php 

 $sql_year=mysql_query("select * from tbl_academic_Year where school_id='$sc_id'  order by id");

while($result_year=mysql_fetch_array($sql_year))

{?>

<option value="<?php echo $result_year['ExtYearID'].",".$result_year['Academic_Year']; ?>"><?php echo $result_year['Academic_Year']; ?></option>

<?php 

}

?>

</select>

</div>
<div class='col-md-3 indent-small' id="erroracdemic" style="color:#FF0000"></div>

</div>


<!--------------------------------------Department--------------------------------------->





<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;">Semester<b style="color:red";>*</b></div>

<div class="col-md-3">

 <select name="semester" id="semester" class="form-control" >
<option value="">Select Semester</option>
			
<?php 
//Below code added by Pranali for displaying list of semester for the bug SMC-3765 on 14/05/2019
			 $sql_sem=mysql_query("SELECT * FROM tbl_semester_master where school_id='$sc_id' group by Semester_Name order by Semester_Id desc");

			 while($result_sem=mysql_fetch_array($sql_sem))

			 {

			 	?>

				 <option value="<?php echo $result_sem['ExtSemesterId'].','.$result_sem['Semester_Name'];?>"><?php echo $result_sem['Semester_Name'];?></option>

				 <?php }

			 ?>
			 
			</select>
 

</div>

<div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>

</div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Specialization(If Any)</div>
<div class="col-md-3">                      
                            <input type="text" name="specialization" id="specialization" class="form-control" value=""/>

						</div>
                    </div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>
<div class="col-md-2" style="color:#808080; font-size:18px;"> Is Current Semester<b style="color:red";>*</b></div>
<!-- Below code changed by Chaitali for SMC-5248 on 14-04-2021  -->
<div class="col-md-4">
                        <div class='col-md-3' style="font-weight: 600;color: #777;">
                            <input type="radio" name="isactiv" id="isactiv1" value="1" checked>&nbsp; Yes
                        </div>
                        <div class='col-md-3' style="font-weight: 600;color: #777;">
                            <input type="radio" name="isactiv" id="isactiv1" value="0">&nbsp; No
                        </div>
                        
						</div>
                    </div>

					
<!------------------------------------Division----------------------------------------->



   <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>


<!---------------------------Course Level----------------------------->









<!------------------------------------END------------------------------------------------>



<div class="row" style="padding-top:60px;">

<div class="col-md-5"></div>



<div class="col-md-1"><input type="submit" name="submit" value="Save"  class="btn btn-success"  onClick="return valid()"></div>



<div class="col-md-1"></div>

<div class="col-md-2"><a href="student_semester_record.php" style="text-decoration:none"> <input type="button" name="cancel"  value="Back" class="btn btn-danger" ></a></div>

</div>

                  

                 

                 <div  ><center style="color:#006600;">

                 

                 <?php echo $report?></center>

                 </div>

				 

				 

				  <?php if($report!='')

   {?>

   <div class="row" style="padding-top:30px;color:#FF0000;" align="center " > <?php echo $report;?></div>

   <?php } 

   

   else if($report1!='')

   {?>

   <div class="row" style="padding-top:30px;color:#060;margin-left: 500px;" align="center " > <?php echo $report1;?></div>

   <?php }?>

                    </form>

                  

               </div>

               </div>

</body>

</html>

