<?php

                if(isset($_GET['id']))

				{

					$report="";

					include_once("school_staff_header.php");

				$results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");

				$result=mysql_fetch_array($results);

				$sc_id=$result['school_id'];

				if(isset($_POST['submit']))

                   {

				$i=0;

				$count=$_POST['count'];

				$counts=0;			// Loop to store each class.

				$classes=Array();

				$reports="You  are succefully added ";

				$j=0;

				for($i=0;$i<$count;$i++)

				          {

							  $class=$_POST[$i];

				$results=mysql_query("select * from tbl_school_class where school_id='$sc_id' and class like '$class' ");

							  //check already class exist or not

								 if(mysql_num_rows($results)==0 && $class!="")

									{

				$query="insert into tbl_school_class(class,school_id,school_staff_id)values('$class','$sc_id','$staff_id')";

										$rs = mysql_query($query );

										

										 $classes2[$counts]=$class;

										 $counts++; 

									}

								 else

								 	{

									   $classes[$i]=$class;

									   $j++;

										

									}

							    }

							

							$class1="";

							 if($counts==0)

									{

									

									   for($i=0;$i<count($classes);$i++)

									   {

									   

										if($j==$i+1)

										 {

										  $class1=$class1." ".$classes[$i];

									

										 }

										 else

										 {

										

									     $class1=$class1." ".$classes[$i].",";

										 

										

										 }

									   }

									  

									   if(count($classes)>1)

									   {

										 $report=" classes ".$class1." are already present . ";

										}

										else

										{

										 	$report=" class ".$class." is already present";

										

										}

									

									}	

									

								else if($counts==1)

								    {

							            $report="You have successfully added class ".$class." ";

									}

									else

									{

										for($i=0;$i<count($classes2);$i++)

									   {

									   

										if($counts==$i+1)

										 {

										  $class1=$class1." ".$classes2[$i];

									     }

										 else

										 {

										  $class1=$class1." ".$classes2[$i].",";

										  }

									     }

									     $report="You have successfully added classes ".$class1."";

									   }

									}

                                 ?>





<html>

<head>

<script>

var i=1;

function create_input()

{

 var index='E-';

 $("<div class='row formgroup' style='padding:5px;'  ><div class='col-md-3 col-md-offset-4'  ><input type='text'  name="+i+" id="+i+" class='form-control' placeholder=':Enter Class'></div><div class='col-md-3 ' style='color:#FF0000;' id="+index+i+" ></div></div>").appendTo('#add');

   i=i+1;

   document.getElementById("count").value = i;

	}

function valid()

{

 var count=document.getElementById("count").value;

for(var i=0;i<count;i++)

	{

	var index='E-';

		var values=document.getElementById(i).value;

		  if(values==null||values=="")

			{

			  document.getElementById( index+i).innerHTML='Please Enter Class';

				return false;

			}

		  }

		 }



</script>

</head>

<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;" >

        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   <form method="post">

                    

                    <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" >

                      <!-- <input type="button" class="btn btn-primary" name="add" value="Add more" style="width:100px;font-weight:bold;font-size:14px;" onClick="create_input()"/>-->

               			 </div>

              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                         	

                   				<h2>Add Class</h2>

               			 </div>

                         

                     </div>

                 <div class="row " style="padding:5px;" >

               

               <div class="col-md-3 col-md-offset-4">

             <input type="text" name="0" id="0" class="form-control " placeholder="Enter Class">

             </div>

               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               

               </div>

              

                  </div>

                <div id="add">

                </div>

                  

                   <div class="row" style="padding-top:15px;">

                   <div class="col-md-2">

               </div>

                  <div class="col-md-2 col-md-offset-2 "  >

                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                    </div>

                    <script>

					         function backpage()

							 {

                                window.history.go(-1);

							 }

                    </script>

                     <div class="col-md-3 "  align="left">

                    <a href="list_school_class.php" style="text-decoration:none;"><input type="button" onClick="backpage()" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   

                   </div>

                   

                     <div class="row" style="padding:15px;">

                     <div class="col-md-4">

                     <input type="hidden" name="count" id="count" value="1">

                     </div>

                      <div class="col-md-4" style="color:#006600;" align="center" id="error">

                      <b>

                      <?php echo $report;?></b>

               			</div>

                 

                    </div>

                   </div>

                 </form>

                </div>

               </div>

</body>

</html>

<?php	

			    }

				else

				{?>

<?php



$report="";

$report1="";

//Add student subject and Edit student subject these two files are merged by Sayali Balkawade on 11/11/2019 in SMC-4060

include_once("scadmin_header.php");

//Below condition added by Rutuj for SMC-5004 on 09-12-2020
	if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else{
		$id=$_SESSION['id'];
	}


	 $fields=array("id"=>$id);

		   $table="tbl_school_admin";

		   $smartcookie=new smartcookie();

		   

$results=$smartcookie->retrive_individual($table,$fields);

$school_admin=mysql_fetch_array($results);

$sc_id=$_SESSION['school_id'];			

$uploadedBy=$school_admin['name'];
//called webservice for displaying data in all dropdowns by Pranali for SMC-5071.
$url = $GLOBALS['URLNAME']."/core/Version3/teacher_subject_details.php";
//echo $url;
$data = array("school_id"=>$sc_id);
$ch = curl_init($url);             
$data_string = json_encode($data);    
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
$teacher_det = json_decode(curl_exec($ch),true); 
//print_r($teacher_det);exit;
if(($_GET["student_id"])=='')
{
	//add student subject
if(isset($_POST['submit']))
{
//Taken division for respective student from student name field by Pranali for SMC-5071
	$stud_arr=explode(",",$_POST['student_id']);
	$std_PRN = $stud_arr[0];
	$division = $stud_arr[1];
	

$teacher_id=$_POST['teacher_id'];

$course=$_POST['course'];

$department=$_POST['department'];

$branch=$_POST['branch'];

$semester=$_POST['semester'];

$academic_year1=$_POST['academic_year'];

//$division1=$_POST['division'];

$subject_name1=$_POST['subject_name'];
$sub = explode (",", $subject_name1);
$subject_name = $sub[1];
$subject_code = $sub[0];
 
 $academic_year2 = explode (",", $academic_year1); 
$academic_year = $academic_year2[1];

$yearid = $academic_year2[0];

$division1=$_POST['division'];
$division2 = explode (",", $division1); 
$division = $division2[1];
//echo $division;
$diviid = $division2[0];
$divisionname = $arr['Division_id'];
$ExtDivisionID = $arr['ExtDivisionID'];
// $semester2 = explode (",", $semester1); 
// $semester = $semester2[1];
// $semesterid = $semester2[0];

//$division2 = explode (",", $division1); 
//$division = $division2[1];
//$diviid = $division2[0];
//
// $div_sql = mysql_query("SELECT * FROM Division where DivisionName='$std_div' and school_id='$sc_id'");
// $div_res = mysql_fetch_array($div_sql);
// $diviid = $div_res['ExtDivisionID'];
//$branch2 =  explode (",", $branch1);
 //$branch = $branch2[1];
//$branchids = $branch2[0]; 
//uploaded date set to current date time by Pranali for SMC-3765 on 14-5-19
$upload_date=date('Y-m-d h:i:s');


  $check = mysql_query("SELECT * from tbl_student_subject_master 
		   where school_id = '$sc_id' AND student_id = '$std_PRN' AND  AcademicYear = '$academic_year' AND Semester_id = '$semester' AND subjcet_code = '$subject_code' AND Branches_id='$branch' AND Department_id ='$department' AND Division_id ='$division' AND subjectName='$subject_name' ");

$check_num = mysql_num_rows($check);

if($check_num > 0){
	echo "<script>window.alert('Student Subject already exists')</script>";
	echo "<script>window.location.assign('Add_student_subject.php')</script>";
}

else{
	$query=mysql_query("insert into tbl_student_subject_master (student_id,school_id,school_staff_id,subjcet_code,subjectName,Semester_id,Branches_id,Department_id,CourseLevel,Division_id,AcademicYear,upload_date,uploaded_by,ExtSemesterId,ExtBranchId,ExtYearID,ExtDivisionID) 
															values('$std_PRN','$sc_id','','$subject_code','$subject_name','$semester','$branch','$department','$course','$division' ,'$academic_year', '$upload_date','$uploadedBy','$semesterid','$branchids','$yearid','$diviid')");
	//$query=mysql_query("insert into tbl_student_subject_master (student_id,teacher_ID,school_id,school_staff_id,subjcet_code,subjectName,Semester_id,Branches_id,Department_id,CourseLevel,Division_id,AcademicYear,upload_date,uploaded_by,ExtSemesterId,ExtBranchId,ExtYearID,ExtDivisionID) values('$std_PRN','$teacher_id','$sc_id','','$subject_code','$subject_name','$semester','$branch','$department','$course','$division' ,'$academic_year', '$upload_date','$uploadedBy','$semesterid','$branchids','$yearid','$diviid')");       

	//$report1="Subject is successfully Inserted";
	echo ("<script LANGUAGE='JavaScript'>
						alert('$dynamic_subject is successfully Inserted');
						window.location.href='list_student_subject.php';
						</script>");
}



}





?>





<html>







<head>


<script>



function Myfunction(value,fn)

{
//Added below variables by Pranaali for SMC-5048
// var teacher = document.getElementById("teacher_id").value;
var course_level = document.getElementById("course").value;
var Dept_Name = document.getElementById("department").value;
var subject = document.getElementById("subject_name").value;
var semester = document.getElementById("semester").value;
var academic_year_arr = document.getElementById("academic_year").value;
var ay_str = academic_year_arr.split(",");
var year = ay_str[1];
//var division_arr = document.getElementById("division").value;
//var division_str = division_arr.split(",");
// var division = division_str[1];
var branch = document.getElementById("branch").value;
var stud_prn_arr = $("#student_id").val();
var stud_prn_str = stud_prn_arr.split(",");
var stud_prn = stud_prn_str[0];
var division = stud_prn_str[1];
var subject_type = document.getElementById("subject_type").value;
//alert(division);
 if(value!='')
 {
 	//alert('hi');
 	if(fn=="fun_subject_name"){ 
 		//alert(year);
	 	$.ajax({
	 		method : "POST",
	 		url : 'get_student_subject_data.php',
	 		data : {course_level : course_level, Dept_Name : Dept_Name, subjectCode : subject, semester : semester, year : year, division:division, branch:branch, fn_name : "teacher_name"},
	 		success : function(data){
	 			$("#teacher_id").html(data);
	 		}
	 	});

 	}

}
}



  function valid()  

       {
  

		   var student_id=document.getElementById("student_id").value;

	  if(student_id==null || student_id=="")

		{
			 //replace to dynamic variable of student by Sayali for SMC-5058 on 28/12/2020
		document.getElementById('errorstudent').innerHTML='Please select <?php  echo $dynamic_student; ?>';

				

				return false;

		}

		else

		{

		document.getElementById('errorstudent').innerHTML='';
		}
			var teacher_id=document.getElementById("teacher_id").value;

	  if(teacher_id==null || teacher_id=="")

		{
		  //replace to dynamic variable of teacher by Sayali for SMC-5058 on 28/12/2020
		//document.getElementById('errorteacher').innerHTML='Please select <?php echo $dynamic_teacher;?>';
		//return false;
		document.getElementById('errorteacher').innerHTML='';
		}

		else

		{

		document.getElementById('errorteacher').innerHTML='';

		}   

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
		//
		// var division=document.getElementById("division").value;

	 //  if(division==null || division=="" || division == "Select")

		// {
		// document.getElementById('errordivision').innerHTML='Please select division';

		// 		return false;

		// }

		// else

		// {

		// document.getElementById('errordivision').innerHTML='';

		// }
		
		
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

                   <h2 style="padding-top:30px;"><center>Add <?php echo $dynamic_student;?>  <?php echo $dynamic_subject;?> </center></h2>

                   <!--  <center><a href="merge_student_subject.php">Insert <?php echo $dynamic_student;?>  <?php echo $dynamic_subject;?></a></center> -->

              

<div class="row formgroup" style="padding:5px;">

<form method="post" >

<div class="row" style="padding-top:50px;">

<div class="col-md-4"></div>





 <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_student;?> Name <span class="error" style="color:#FF0000"><b> *</b></span></div>

<div class="col-md-3">



  <select name="student_id" id="student_id" class="form-control" onChange="Myfunction(this.value,'student_id')">

			<option value=""> Select <?php echo $dynamic_student;?></option>

             <?php 

			 $sql_teacher=mysql_query("select std_PRN,std_complete_name,std_name,std_lastname,std_div from tbl_student where school_id='$sc_id' and std_PRN!='' order by std_complete_name asc ");

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

				 <option value="<?php echo $result_teacher['std_PRN'].','.$result_teacher['std_div']; ?>"><?php echo ucwords(strtolower($std_complete_name))?></option>

				 <?php }

			 ?>

			 

			 

             </select>

</div>

 <div class='col-md-3 indent-small' id="errorstudent" style="color:#FF0000"></div>

 </div>

<div class="row" style="padding-top:50px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_subject;?> Type <span class="error" style="color:#FF0000"><b> *</b></span></div>
<!--Added onChange for taking relevant data and passing to Myfunction() by Pranali for SMC-5071-->
<div class="col-md-3">

	<select id="subject_type" name="subject_type" class="form-control" onChange="Myfunction(this.value,'subject_type')">
		<option value="0"> Select Subject Type</option>
		<?php if($school_type != 'organization'){  ?>
		<option value="all"> All</option>
		<option value="relevant"> Relevant</option>
		<?php }else{ ?>
		<option value="all"> All</option>
		<?php } ?>

	</select>

</div>
</div>


<!--------------------------------------Department--------------------------------------->
 <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Department<b style="color:red";>*</b></div>

               

               <div class="col-md-3"  >

			   <select name="department" id="department" class="form-control" onChange="Myfunction(this.value,'fun_course_level')" >
			   <option value="">Select Department</option>
             <?php 

			 // $sql_dept=mysql_query("select trim(Dept_Name) as Dept_Name from  tbl_department_master where school_id='$sc_id' and Dept_Name!='' group by Dept_Name order by Dept_Name asc");

			 // while($result_dept=mysql_fetch_array($sql_dept))
			 
			foreach ( $teacher_det["departments"] as $dept){
       			
       
			 ?>

				  <option value="<?php echo $dept['Dept_Name']?>"><?php echo $dept['Dept_Name']?></option>

				 <?php }

			 ?>
             </select>
             </div>

				<div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
</div>



<?php //if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff'){?>
<div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $dynamic_level; ?><b style="color:red";>*</b></div>

               

<div class="col-md-3">


<!--SMC-5048 by Pranali: added || $user=='School Admin Staff' in all conditions -->
<select name="course" id="course" class="form-control" onChange="Myfunction(this.value,'fun_branch')">
<option value="">Select <?php echo $dynamic_level; ?></option>
			

             <?php 

			 // $sql_course=mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' and CourseLevel!='' order by id");

			 // while($result_course=mysql_fetch_array($sql_course))
             foreach ( $teacher_det["courseLevel"] as $result_course)
			 {?>

				 <option value="<?php echo $result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>

				 <?php }

			 ?>

			 

			 

             </select>

             </div>
					<div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                

        </div>

<?php //} ?>

<?php //if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff') { ?>

  <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" ><?php echo $dynamic_branch; ?><b style="color:red";>*</b></div>

               

               <div class="col-md-3">

               

 <select name="branch" id="branch" class="form-control" onChange="Myfunction(this.value,'fun_sem')" >
<option value="">Select <?php echo $dynamic_branch; ?></option>
			
<?php 
//Below code added by Rutuja Jori(PHP Intern) for displaying list of branches for the bug SMC-3765 on 08/04/2019

			 
			 // $sql_branch=mysql_query("select distinct branch_Name from  tbl_branch_master where school_id='$sc_id' group by branch_Name order by id desc");  

			 // while($result_branch=mysql_fetch_array($sql_branch))
			foreach ( $teacher_det["branches"] as $result_branch)
			 {?>

				  <option value="<?php echo $result_branch['branch_Name']?>"><?php echo $result_branch['branch_Name']?></option>

				 <?php }

			 ?>
			

             </select>

           

             </div>

			  <div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>

                

        </div>
<!--Commented division dropdown code for taking division from tbl_student by Pranali for SMC-5071-->

<!------------------------------------Division----------------------------------------->





 <!-- <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php //echo $designation;?><b style="color:red";>*</b></div>

               

               <div class="col-md-3">

   

            <select name="division" id="division" class="form-control" onChange="Myfunction(this.value,'fun_sem')">

             <option value="">Select <?php //echo $designation;?></option>

			 <?php 

			 //foreach ( $teacher_det["divisions"] as $result_div)
			 {
			 	//$sql_div=mysql_query("select ExtDivisionID from Division where school_id='$sc_id' and DivisionName='".$result_div['DivisionName']."' ");

			 //$result_div1=mysql_fetch_array($sql_div);
			 	?>

				  <option value="<?php //echo $result_div1['ExtDivisionID'].",".$result_div['DivisionName'];?>"> <?php //echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?> 

             </select>

             </div>
				<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
              

        </div> -->

<!------------------------------------Acadmic Year----------------------------------------->

<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_year;?><b style="color:red";>*</b></div>

<div class="col-md-3">

<select name="academic_year" id="academic_year" class="form-control" onChange="Myfunction(this.value,'academic_year')">
<option value="">Select <?php echo $dynamic_year;?></option>
<?php 


foreach ( $teacher_det["years"] as $result_year)

{
$sql_year=mysql_query("select Year,ExtYearID,Academic_Year from tbl_academic_Year where school_id='$sc_id' and Year='".$result_year['Year']."' group by Academic_Year ");
$result_year1=mysql_fetch_array($sql_year); 
	?>

<option value="<?php echo $result_year1['ExtYearID'].",".$result_year['Academic_Year']; ?>"><?php echo $result_year['Academic_Year']; ?></option>

<?php 

}

?>

</select>

</div>
<div class='col-md-3 indent-small' id="erroracdemic" style="color:#FF0000"></div>

</div>

<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_semester;?><b style="color:red";>*</b></div>

<div class="col-md-3">

 <select name="semester" id="semester" class="form-control" onChange="Myfunction(this.value,'fun_rel_subject')">
<option value="">Select <?php echo $dynamic_semester;?></option>
			
<?php 
//Below code added by Pranali for displaying list of semester for the bug SMC-3765 on 14/05/2019
			 // $sql_sem=mysql_query("SELECT Semester_Name FROM tbl_semester_master where school_id='$sc_id' group by Semester_Name order by Semester_Id desc");

			 // while($result_sem=mysql_fetch_assoc($sql_sem))
			 foreach ( $teacher_det["semesters"] as $result_sem)
			 { 
 				
			 	?>

			<option value="<?php echo $result_sem['Semester_Name']?>"><?php echo $result_sem['Semester_Name']?></option> 

				 <?php }

			 ?>
			 
			</select>
 

</div>

<div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>

</div>


<?php //} ?>

<div class="row ">
					<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;margin-top: 25px;"><?php echo $designation;?><b style="color:red";>*</b></div>

                               
                                <div class="col-md-3">
                                    <select name="division" id="division" class="form-control" style="width:100%; padding:5px;margin-top: 25px;">
									<option value="<?php echo $ExtDivisionID.','.$divisionname;?>">Select Division<?php echo $divisionname;?></option>
<?php $sql_div=mysql_query("select * from Division where school_id='$sc_id'");

			 while($result_div=mysql_fetch_array($sql_div))

			 {?>

				  <option value="<?php echo $result_div['ExtDivisionID'].",".$result_div['DivisionName'];?>"><?php echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?> 
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
                            </div>
							
	


<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject;?> Title<b style="color:red";>*</b></div>

<div class="col-md-3">

   <select name="subject_name" id="subject_name" class="form-control" onChange="Myfunction(this.value,'fun_subject_name')">

<option value="">Select <?php echo $dynamic_subject;?> Title</option>

                                   <?php
								   $sql_subject = mysql_query("select distinct subject, Subject_Code from  tbl_school_subject where school_id='$sc_id' order by id");
								   while ($result_subject = mysql_fetch_array($sql_subject)) {
									   ?>
									   
									   <option value="<?php echo $result_subject['Subject_Code'].','.$result_subject['subject']?>"><?php echo $result_subject['subject']?>(<?php echo $result_subject['Subject_Code']?>)</option>
									   
								   <?php }
								   ?>

</select>

</div>
<div class='col-md-3 indent-small' id="errorsubject_name" style="color:#FF0000"></div>

</div>

         <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>





<!--<div class="col-md-2" style="color:#808080; font-size:18px;"><?php //echo $dynamic_teacher;?> Name</div>

<div class="col-md-3">



  <select name="teacher_id" id="teacher_id" class="form-control" >-->

			

             <?php 


			 // $sql_teacher=mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and t_complete_name!='' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137' ) order by t_complete_name asc");


			 // while($result_teacher=mysql_fetch_array($sql_teacher))

			 //{?>

				<!--  <option value="<?php //echo $result_teacher['t_id']?>"><?php //echo ucwords(strtolower($result_teacher['t_complete_name']))?></option> -->

				 <?php //}

			 ?>

			 

			 

           <!--  </select>

</div>

 <div class='col-md-3 indent-small' id="errorteacher" style="color:#FF0000"></div>

 </div>-->

		   

   


<!--
   <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject;?> Code<b style="color:red";>*</b></div>

<div class="col-md-3">



 <select name="subject_code" id="subject_code" class="form-control" required>

<option value="">Select <?php echo $dynamic_subject;?> Code</option>

   

</select>



</div>

  <div class='col-md-3 indent-small' id="errorsubject_code" style="color:#FF0000"></div>

</div>
-->



<!---------------------------Course Level----------------------------->









<!------------------------------------END------------------------------------------------>



<div class="row" style="padding-top:60px;">

<div class="col-md-5"></div>



<div class="col-md-1"><input type="submit" name="submit" value="Save"  class="btn btn-success"  onClick="return valid()"></div>



<div class="col-md-1"></div>

<div class="col-md-2"><a href="list_student_subject.php" style="text-decoration:none"> <input type="button" name="cancel"  value="Back" class="btn btn-danger" ></a></div>

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
<script type="text/javascript">
	//Added below ajax calls for taking relevant data by Pranali for SMC-5071
 	$("#subject_type").change(function(){

 	var subject_type = $(this).val();
 	var stud_prn_arr = $("#student_id").val();
 	var stud_prn_str = stud_prn_arr.split(",");
 	var stud_prn = stud_prn_str[0];
 	var division = stud_prn_str[1];

 	if(stud_prn=="")
 	{
 		alert("Please select student name");
 	}
 	else{
 		if(subject_type=="relevant"){
	 						
			 	$.ajax({
			 		type : "POST",
			 		url : 'get_student_subject_data.php',
			 		data : { fn_name : "relevant_data", stud_prn : stud_prn},
			 		dataType: "json", // Set the data type so jQuery can parse it for you
			 		success : function(data){
			 			//alert(data);
			 			var dept = data[0];
			 			var course = data[1];
			 			var branch = data[2];
			 			var year = data[9];
			 			var academic_year = data[8];
			 			var ExtYearID = data[10];
			 			var semester = data[5];
		//Added ExtYearID and year at value tag of academic year dropdown for SMC-5071 by Pranali
			 			$("#department").html('<option value="'+dept+'">'+dept+'</option>');
			 			$("#course").html('<option value="'+course+'">'+course+'</option>');
			 			$("#branch").html('<option value="'+branch+'">'+branch+'</option>');
			 			$("#academic_year").html('<option value="'+ExtYearID+','+year+'">'+academic_year+'</option>');
			 			$("#semester").html('<option value="'+semester+'">'+semester+'</option>');
			 		}
			 	});

	 					var dept = $("#department").val();
			 			var course = $("#course").val();
			 			var branch = $("#branch").val();
			 			var academic_year = $("#academic_year").val();
			 			var semester = $("#semester").val();
				$.ajax({
			 		type : "POST",
			 		url : 'get_student_subject_data.php',
			 		data : { fn_name : "rel_subject", stud_prn : stud_prn},
			 		success : function(data){
			 			
			 			if(data==""){
			 				alert("Relevant subject is not available.. Please check for All subject type");
			 				$("#subject_name").html('');
			 				$("#teacher_id").html('');
			 			}
			 			else{
			 				$("#subject_name").html(data);
			 			}
			 		}
			 	});
		
		}
		else if(subject_type=="all")
		{
			//alert(all_data);
			$.ajax({
			 		type : "POST",
			 		url : 'get_student_subject_data.php',
			 		data : { fn_name : "all_data"},
			 		dataType: "json", // Set the data type so jQuery can parse it for you
			 		success : function(data){
			 			//console.log(data);
			 			var subjects = data.subjects;
			 			var departments = data.departments;
			 			var courseLevel = data.courseLevel;
			 			var semesters = data.semesters;
			 			var years = data.years;
			 			var branches = data.branches;

			 			$("#department").html('<option value="">Select Department</option>');
			 			$("#course").html('<option value="">Select Course Level</option>');
			 			$("#semester").html('<option value="">Select Semester</option>');
			 			$("#academic_year").html('<option value="">Select Academic Year</option>');
			 			$("#branch").html('<option value="">Select Branch</option>');
			 			$("#subject_name").html('<option value="">Select Subject Name</option>');

			 			$.each(subjects, function () {
					    						        
					        $("#subject_name").append( $('<option></option>').text(this.subject).val(this.subject+','+this.Subject_Code) );
					   					   
						});

						$.each(departments, function () {
					    						        
					        $("#department").append( $('<option></option>').text(this.Dept_Name).val(this.Dept_Name) );
					   					   
						});
						$.each(courseLevel, function () {
					    						        
					        $("#course").append( $('<option></option>').text(this.CourseLevel).val(this.CourseLevel) );
					   					   
						});
						$.each(semesters, function () {
					    						        
					        $("#semester").append( $('<option></option>').text(this.Semester_Name).val(this.Semester_Name) );
					   					   
						});
						$.each(years, function () {
					    						        
					        $("#academic_year").append( $('<option></option>').text(this.Academic_Year).val(this.ExtYearID+','+this.Academic_Year) );
					   					   
						});
						
						$.each(branches, function () {
					    						        
					        $("#branch").append( $('<option></option>').text(this.branch_Name).val(this.branch_Name) );
					   					   
						});
			 	}
			});
		}
	}
});
</script>
                  

               </div>

               </div>

</body>

</html>


<?php }	else {
	

//edit  student subject

$report = "";
//include("scadmin_header.php");
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];

if (isset($_GET["subject"],$_GET["student_id"],$_GET["school_id"])) {
    $subject_id = $_REQUEST['subject'];
	$stud_id = $_REQUEST['student_id'];
    //echo "select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";
    $sql1 = "select * from tbl_student_subject_master where subjcet_code='$subject_id' 
			and student_id='$stud_id' and school_id='$sc_id'";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $id = $arr['id'];
    $student_id = $arr['student_id'];
	
    $branchName = $arr['Branches_id'];
	$ExtBranchId = $arr['ExtBranchId'];
	
	$subjectName = $arr['subjectName'];
    $Subject_Code = $arr['subjcet_code'];
	
    $course_level = $arr['CourseLevel'];
    $Department_Name= $arr['Department_id'];
    $teacher_ID = $arr['teacher_ID'];
    $sqlquery = "select * from tbl_teacher where t_id='$teacher_ID' and school_id='$sc_id'";
								$result = mysql_query($sqlquery);
								$rows = mysql_fetch_array($result);
								$teacher_name = $rows['t_complete_name'];
	
$Semester_Name = $arr['Semester_id'];
$semester_id = $arr['ExtSemesterId'];

$AcademicYear = $arr['AcademicYear'];
$ExtYearID = $arr['ExtYearID'];

$divisionname = $arr['Division_id'];
$ExtDivisionID = $arr['ExtDivisionID'];

    if (isset($_POST['submit'])) {

		$branch1=$_POST['branch'];

$semester1=$_POST['semester'];

$academic_year1=$_POST['academic_year'];

$division1=$_POST['division'];
		$academic_year2 = explode (",", $academic_year1); 
$academic_year = $academic_year2[1];
$yearid = $academic_year2[0];

$semester2 = explode (",", $semester1); 
$semester = $semester2[1];
$semesterid = $semester2[0];

$division2 = explode (",", $division1); 
$division = $division2[1];
$diviid = $division2[0];

$branch2 =  explode (",", $branch1);
 $branch = $branch2[1];
$branchids = $branch2[0];

$subject_names=mysql_real_escape_string($_POST['subject_name']);
$subject_name=explode(",",$subject_names)[0];

$subject_code=$_POST['subject_code'];

$course=$_POST['course'];

$department=$_POST['department'];

$teacher_id=$_POST['teacher_id'];
//        $semester = $_POST['Semester_id'];
//                           echo "update tbl_school_subject set Subject_Code='$Subject_Code', subject='$subject', Course_Level_PID='$course_level',Branch_ID='$Branch' where id='$id' and school_id='$sc_id'";
//        die;


        $sql3 = "update tbl_student_subject_master set teacher_ID='$teacher_id', subjcet_code='$subject_code', subjectName='$subject_name', CourseLevel='$course',Branches_id='$branch',ExtBranchId='$branchids',Division_id='$division',ExtDivisionID='$diviid',Semester_id='$semester',ExtSemesterId='$semesterid',AcademicYear='$academic_year',ExtYearID='$yearid',Department_id='$department' where id='$id' and school_id='$sc_id' ";
        if (mysql_query($sql3)) {
			echo ("<script LANGUAGE='JavaScript'>
					alert('Record Updated Successfully..!!');
					window.location.href='list_student_subject.php';
					</script>");
          //  echo "Records  updated successfully.";
        } else {
			echo '<script type="text/javascript"> alert("ERROR: Could not able to execute") </script>';
           // echo "ERROR: Could not able to execute ";
        }
    } ?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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
		
		var nval =escape(value);
      

 xmlhttp.open("GET","get_stud_sub_details.php?fn="+fn+"&value="+nval,true);

        xmlhttp.send();

		  

		  

 }

 

 

 



}
            function valid() {
                var subject = document.getElementById("subject").value;
                if (subject == "") {
                    document.getElementById('error').innerHTML = 'Please Enter Subject';
                    return false;
                }
                regx = /^[0-9]*$/;
                //validation of subject
                if (regx.test(subject)) {
                    document.getElementById('error').innerHTML = 'Please Enter valid Subject';
                    return false;
                }
            }
        </script>
    </head>
    <body align="center">
    <div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                                <h2>Edit <?php echo "$dynamic_student " .$dynamic_subject;?> </h2>
                            </div>
                            <div class="row ">

									<div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
										<b><?php echo $dynamic_student;?> name</b>
									</div>  
									<div class="col-md-5 form-group">
									<?php 
									$sqlquery = "select * from tbl_student where std_PRN='$student_id' and school_id='$sc_id'";
									$result = mysql_query($sqlquery);
									$rows = mysql_fetch_array($result);
									$student_name = $rows['std_complete_name'];
									?>
										<input type="text" name="Student_name" id="Student_name" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_student;?> name" value="<?php echo $student_name; ?>" readonly>
                            </div>

                            <!--Teacher drop down on edit page added by Rutuja for SMC-5022 on 09-12-2020-->    
                           <!-- <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php //echo $dynamic_teacher;?>Name</b>
                                </div>-->
                                <!--<div class="col-md-5 form-group">
                                    <select name="teacher_id" id="teacher_id" class="form-control" style="width:100%; padding:5px;" value="<?php //echo $teacher_name; ?>">
									<option value="<?php //echo $teacher_ID;?>"><?php //echo $teacher_name;?></option>

   <#?php 

			 //$sql_teacher=mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and t_complete_name!='' and (t_emp_type_pid='133' or t_emp_type_pid='134' or t_emp_type_pid='135' or t_emp_type_pid='137' ) order by t_complete_name");

			 // while($result_teacher=mysql_fetch_array($sql_teacher))
			// {if($result_teacher['t_id']!=$teacher_ID)	//{ ?>

				 <option value="<#?php //echo $result_teacher['t_id']?>"><#?php //echo ucwords(strtolower($result_teacher['t_complete_name']))?></option>

				 <#?php //} }


			 ?>
									</select>
                                </div>-->


                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student;?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="" id="" class="form-control" style="width:100%; padding:5px;" placeholder=" <?php echo $dynamic_student;?> ID " value="<?php echo $student_id; ?>" readonly>
                                </div>

                                
                           		<!-- </div> -->

                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_subject;?> Title</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="subject_name" id="subject_name" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_subject')">
									<option value="<?php echo $subjectName;?>,<?php echo $Subject_Code;?>"><?php echo $subjectName;?>(<?php echo $Subject_Code;?>)</option>
									
   <?php 

			 $sql_subject=mysql_query("select distinct subject,Subject_Code from  tbl_school_subject where school_id='$sc_id' order by id");

			 while($result_subject=mysql_fetch_array($sql_subject))

			 {?>

				 <option value="<?php echo $result_subject['subject']?>,<?php echo $result_subject['Subject_Code']?>"><?php echo $result_subject['subject']?>(<?php echo $result_subject['Subject_Code']?>)</option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorsubject_name" style="color:#FF0000"></div>
                            </div>
							
						<div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject;?> Code</b>
                                </div>
                                <div class="col-md-5 form-group">
									<select name="subject_code" id="subject_code" class="form-control" style="width:100%; padding:5px;" readonly>
									<option value="<?php echo $Subject_Code; ?>"><?php echo $Subject_Code; ?></option>
									</select>
                                </div>
								
								
							<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff'){?>
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>course level</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="course" id="course" class="form-control" style="width:100%; padding:5px;" >
									<option value="<?php echo $course_level; ?>"><?php echo $course_level; ?></option>
			

             <?php 

			 $sql_course=mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' order by id");

			 while($result_course=mysql_fetch_array($sql_course))

			 {?>

				 <option value="<?php echo $result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                            </div>
							
							<?php }?>
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Department</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="department" id="department" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_dept')" >
									  <option value="<?php echo $Department_Name; ?>"><?php echo $Department_Name; ?></option>
             <?php 

			 $sql_dept=mysql_query("select `Dept_Name` from  tbl_department_master where school_id='$sc_id' order by id");

			 while($result_dept=mysql_fetch_array($sql_dept))

			 {?>

				 <option value="<?php echo $result_dept['Dept_Name']?>"><?php echo $result_dept['Dept_Name']?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                            </div>
							
						
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_branch;?></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="branch" id="branch" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_branch')">
									<option value="<?php echo $ExtBranchId.','.$branchName; ?>"><?php echo $branchName; ?></option>
			
<?php 
//Below code added by Rutuja Jori(PHP Intern) for displaying list of branches for the bug SMC-3765 on 08/04/2019
			 $sql_branch=mysql_query("select * from  tbl_branch_master where school_id='$sc_id' group by branch_Name order by id desc");

			 while($result_branch=mysql_fetch_array($sql_branch))

			 {?>

				 <option value="<?php echo $result_branch['ExtBranchId'].','.$result_branch['branch_Name'];?>"><?php echo $result_branch['branch_Name'];?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>
                            </div>
							
						<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin' || $user=='School Admin Staff'){?>		
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Semester</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="semester" id="semester" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $semester_id.','.$Semester_Name; ?>"><?php echo $Semester_Name; ?></option>
<?php 
//Below code added by Pranali for displaying list of semester for the bug SMC-3765 on 14/05/2019
			 $sql_sem=mysql_query("SELECT Semester_Name,ExtSemesterId FROM tbl_semester_master where school_id='$sc_id' group by Semester_Name order by Semester_Id desc");

			 while($result_sem=mysql_fetch_array($sql_sem))

			 {

			 	?>

				 <option value="<?php echo $result_sem['ExtSemesterId'].','.$result_sem['Semester_Name'];?>"><?php echo $result_sem['Semester_Name'];?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>
                            
							

							<?php }?>
							</div>
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $designation;?></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="division" id="division" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $ExtDivisionID.','.$divisionname;?>"><?php echo $divisionname;?></option>
<?php $sql_div=mysql_query("select * from Division where school_id='$sc_id'");

			 while($result_div=mysql_fetch_array($sql_div))

			 {?>

				  <option value="<?php echo $result_div['ExtDivisionID'].",".$result_div['DivisionName'];?>"> <?php echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?> 
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
                            </div>
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Academic Year</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="academic_year" id="academic_year" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $ExtYearID.','.$AcademicYear;?>"><?php echo $AcademicYear;?></option>
<?php 
$sql_year=mysql_query("select * from tbl_academic_Year where school_id='$sc_id'  order by id group by Academic_Year");

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
								

                            <div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error" style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit" class='btn-lg btn-primary' style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="submit" onClick="return valid()"/>
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="list_student_subject.php"><input type="button" class='btn-lg btn-danger' name="Back" value="Back" style="width:100%;background-color:#0080C0; color:#FFFFFF;"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
		</div>
    </div>
    </body>
    </html>
	

<?php }
}}?>