<?php
$report="";
$report1="";
 include('header.php');
$id=$_SESSION['id'];

$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];
$t_id=$value['t_id'];
//$upload_date=date('d/m/Y');
$uploadedBy=$value['t_complete_name'];


if(isset($_POST['submit']))

{

$course=$_POST['course'];
$department=$_POST['department'];
$branch=$_POST['branch'];
$semester=$_POST['semester'];
$academic_year=$_POST['academic_year'];

$sql_year1=mysql_query("select ExtYearID from tbl_academic_Year where school_id='$sc_id' and Enable='1' and Year='$academic_year'");
$result_year1=mysql_fetch_array($sql_year1);
$ExtYearID=$result_year1['ExtYearID'];


$division=$_POST['division'];
$subject_name=$_POST['subject_name'];
$subject_code=$_POST['subject_code'];
$upload_date=date('Y-m-d h:i:s',strtotime('+330 minute'));
$query=mysql_query("insert into tbl_teacher_subject_master (ExtYearID,teacher_id,school_id,school_staff_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) values('$ExtYearID','$t_id','$sc_id','','$subject_code','$subject_name','$division','$semester','$branch','$department','$course','$academic_year','$upload_date','$uploadedBy')");
                       
$report="Teacher Subject is successfully Inserted";

}


?>


<html>



<head>
<style>

#country-list{float:left;list-style:none;margin:0;padding:0;}
#country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
#country-list li:hover{background:#F0F0F0;}

</style>

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
       
		  xmlhttp.open("GET","get_teachsubject.php?fn="+fn+"&value="+value,true);
        xmlhttp.send();
		  
		  
 }
 
 
 

}

  function valid()  
       {
	   //validaion for compnay name
	
		
		
		
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
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#subject_name").keyup(function(){
		$.ajax({
		type: "POST",
		url: "readsubject.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#subject_name").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#subject_name").css("background","#FFF");
		}
		});
	});
});
//To select country name
function selectCountry(val) {
$("#subject_name").val(val);
var subject=$("#subject_name").val();
Myfunction(subject,'fun_subject');
$("#suggesstion-box").hide();

}
</script>
</head>
<body bgcolor="#CCCCCC" >

<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
                   <h2 style="padding-top:30px;"><center><?php echo ($_SESSION['usertype']=='Manager')? 'Add Project':'Add Subject';?></center></h2>
                   
                
               <div class="row formgroup" style="padding:5px;">
                   <form method="post" >
                      
              




<div class="row " style="padding-top:50px;">
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Course Level</div>
               
               <div class="col-md-3">
               

            <select name="course" id="course" class="form-control" onChange="Myfunction(this.value,'fun_course')">
			
             <?php 
			 $sql_course=mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' order by id");
			 while($result_course=mysql_fetch_array($sql_course))
			 {?>
				 <option value="<?php echo $result_course['CourseLevel']?>" selected="selected"><?php echo $result_course['CourseLevel']?></option>
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
        
        

  <div class="row " style="padding-top:30px;">
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Branch</div>
               
               <div class="col-md-3">
               
 <select name="branch" id="branch" class="form-control"  onChange="Myfunction(this.value,'fun_branch')">
			
			
             </select>
           
             </div>
			  <div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>
                
        </div>



<!--------------------------------------Department--------------------------------------->


<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Semester</div>
<div class="col-md-3">
 <select name="semester" id="semester" class="form-control" >
			
			
             </select>


</div>
</div>


<div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>
<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($_SESSION['usertype']=='Manager')? 'Evaluation Year':'Academic Year';?></div>
<div class="col-md-3">
<select name="academic_year" id="academic_year" class="form-control">
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
<!------------------------------------Division----------------------------------------->


 <div class="row " style="padding-top:30px;">
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Division</div>
               
               <div class="col-md-3">
   
            <select name="division" id="division" class="form-control">
             
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



<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($_SESSION['usertype']=='Manager')? 'Project Title':'Subject Title';?></div>
<div class="col-md-3">

<input type="text" id="subject_name" name="subject_name" class="form-control"  />
	<div id="suggesstion-box"></div>


</div>
</div>

   <div class="row" style="padding-top:30px;">
<div class="col-md-4"></div>
<div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($_SESSION['usertype']=='Manager')? 'Project Code':'Subject Code';?></div>
<div class="col-md-3">

 <select name="subject_code" id="subject_code" class="form-control" >

   
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

<div class="col-md-2"> <a href="dashboard.php" style="text-decoration:none"> <input type="button" name="cancel"  value="Back" class="btn btn-danger" ></a></div>
</div>
                  
                 
                 <div class="row" style="padding-top:30px;" ><center style="color:#006600;">
                 
                 <?php echo $report?></center>
                 </div>
                 
                    
                    </form>
                  
               </div>
               </div>
</body>
</html>