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

	

$teacher_id=$_POST['teacher_id'];



$course=$_POST['course'];

$department=$_POST['department'];

$branch=$_POST['branch'];

$semester=$_POST['semester'];

$academic_year=$_POST['academic_year'];

$division=$_POST['division'];

$subject_name=$_POST['subject_name'];

$subject_code=$_POST['subject_code'];

$upload_date=date('Y-m-d h:i:s',strtotime('+330 minute'));

$query=mysql_query("insert into tbl_student_subject_master (student_id,teacher_ID,school_id,school_staff_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) values('$std_PRN','$teacher_id','$sc_id','','$subject_code','$subject_name','$division','$semester','$branch','$department','$course','$academic_year','$upload_date','$uploadedBy')");

                       

$report1="Subject is successfully Inserted";



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

       

		  xmlhttp.open("GET","get_stud_sub_details.php?fn="+fn+"&value="+value,true);

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

		

		   

	   //validaion for compnay name

	   var teacher_id=document.getElementById("teacher_id").value;

	  

	  

	  if(teacher_id==null || teacher_id=="")

		{

		

		document.getElementById('errorteacher').innerHTML='Please select Teacher';

				

				return false;

		}

		else

		{

		document.getElementById('errorteacher').innerHTML='';

		

		}

		

		

		

		   var department=document.getElementById("department").value;

	  

	  

	  if(department==null || department=="")

		{

		

		document.getElementById('errordepartment').innerHTML='Please select Department';

				

				return false;

		}

		else

		{

		document.getElementById('errordepartment').innerHTML='';

		

		}

		

		

		   var branch=document.getElementById("branch").value;

	  

	  

	  if(branch==null || branch=="")

		{

		

		document.getElementById('errorbranch').innerHTML='Please select Branch';

				

				return false;

		}

		else

		{

		document.getElementById('errorbranch').innerHTML='';

		

		}
      var academic_year=document.getElementById("academic_year").value;

	  

	  

	  if(academic_year==null || academic_year=="")

		{

		

		document.getElementById('erroracdemic').innerHTML='Please select academic_year';

				

				return false;

		}

		else

		{

		document.getElementById('erroracdemic').innerHTML='';

		

		}
		var subject_name=document.getElementById("subject_name").value;

	  

	  

	  if(subject_name==null || subject_name=="")

		{

		

		document.getElementById('errorsubject_name').innerHTML='Please Enter Subject';

				

				return false;

		}

		else

		{

		document.getElementById('errorsubject_name').innerHTML='';

		

		}
		

		   var subject_code=document.getElementById("subject_code").value;

	  

	  

	  if(subject_code==null || subject_code=="")

		{

		

		document.getElementById('errorsubject').innerHTML='Please Enter Subject';

				

				return false;

		}

		else

		{

		document.getElementById('errorsubject').innerHTML='';

		

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

                   <h2 style="padding-top:30px;"><center>Add Employee Project</center></h2>

                    <center><a href="merge_student_subject.php">Insert Employee Project</a></center>

              

               <div class="row formgroup" style="padding:5px;">

                   <form method="post" >

				   

				   

				   <div class="row" style="padding-top:50px;">

<div class="col-md-4"></div>





<div class="col-md-2" style="color:#808080; font-size:18px;">Employee Name</div>

<div class="col-md-3">



  <select name="student_id" id="student_id" class="form-control" >

			<option value=""> Select Employee </option>

             <?php 

			 $sql_teacher=mysql_query("select std_PRN,std_complete_name,std_name,std_lastname from tbl_student where school_id='$sc_id' and std_PRN!='' ");

			 while($result_teacher=mysql_fetch_array($sql_teacher))

			 {

				 if($result_teacher['std_complete_name'])

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

				   

                      

                <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>





<div class="col-md-2" style="color:#808080; font-size:18px;">Manager Name</div>

<div class="col-md-3">



  <select name="teacher_id" id="teacher_id" class="form-control" >

			<option value=""> Select Manager </option>

             <?php 

			 $sql_teacher=mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and t_complete_name!='' and (t_emp_type_pid='133' or t_emp_type_pid='134' ) order by t_complete_name");

			 while($result_teacher=mysql_fetch_array($sql_teacher))

			 {?>

				 <option value="<?php echo $result_teacher['t_id']?>"><?php echo ucwords(strtolower($result_teacher['t_complete_name']))?></option>

				 <?php }

			 ?>

			 

			 

             </select>

</div>

 <div class='col-md-3 indent-small' id="errorteacher" style="color:#FF0000"></div>

 </div>



<!------------------------------------Acadmic Year----------------------------------------->





<!---------------------------------------------Degree---------------------------------->





<div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Degignationl</div>

               

               <div class="col-md-3">

               



            <select name="course" id="course" class="form-control" onChange="Myfunction(this.value,'fun_course')">
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



 <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Department</div>

               

               <div class="col-md-3"  >

			   <select name="department" id="department" class="form-control"  onChange="Myfunction(this.value,'fun_dept')" >

			

			

             </select>

              



            

             </div>

			  <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>

                

        </div>

        

        










<!--------------------------------------Department--------------------------------------->










<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year</div>

<div class="col-md-3">

<select name="academic_year" id="academic_year" class="form-control">
<option value="">Select</option>
<?php 

 $sql_year=mysql_query("select Year  from tbl_academic_Year where school_id='$sc_id' and Enable='1' order by id");

while($result_year=mysql_fetch_array($sql_year))

{?>

<option value="<?php echo $result_year['Year']; ?>"><?php echo $result_year['Year']; ?></option>

<?php 

}

?>

</select>

</div>

</div>
<div><div class="col-md-3 col-md-offset-2" style="color:red;" id="erroracdemic"></div></div>
<!------------------------------------Division----------------------------------------->





 <div class="row " style="padding-top:30px;">

               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Project Domain</div>

               

               <div class="col-md-3">

   

            <select name="division" id="division" class="form-control">

             <option value="">Select</option>

			 <?php $sql_div=mysql_query("select DivisionName from Division where school_id='$sc_id'");

			 while($result_div=mysql_fetch_array($sql_div))

			 {?>

				  <option value="<?php echo $result_div['DivisionName'];?>"> <?php echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?>

			

             

             </select>

             </div>

                

        </div>

   

   

   

   <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>







<div class="col-md-2" style="color:#808080; font-size:18px;">Project Title</div>

<div class="col-md-3">

   <select name="subject_name" id="subject_name" class="form-control" onChange="Myfunction(this.value,'fun_subject')">

<option value="">Select</option>

   <?php 

			 $sql_subject=mysql_query("select distinct subject from  tbl_school_subject where school_id='$sc_id' order by id");

			 while($result_subject=mysql_fetch_array($sql_subject))

			 {?>

				 <option value="<?php echo $result_subject['subject']?>"><?php echo $result_subject['subject']?></option>

				 <?php }

			 ?>

</select>

</div>

</div>



   <div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;">Project ID</div>

<div class="col-md-3">



 <select name="subject_code" id="subject_code" class="form-control" >

<option value="">Select</option>

   

</select>



</div>

  <div class='col-md-3 indent-small' id="errorsubject" style="color:#FF0000"></div>

</div>



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

   <div class="row" style="padding-top:30px;color:#060;" align="center " > <?php echo $report1;?></div>

   <?php }?>

   

                 

                    

                    </form>

                  

               </div>

               </div>

</body>

</html>

			

			











<?php }?>