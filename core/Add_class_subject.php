<?php
$report="";
$report1="";
include_once("scadmin_header.php");

/*Updated by Rutuja for setting school_id for Staff & adding Enable=1 for Academic year drop down for SMC-5052 on 19-12-2020*/
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
  {
    $sc_id=$_SESSION['school_id']; 
    $query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
    
    
  }
  else{
    $id=$_SESSION['id']; //member id of school admin
  }
$fields=array("id"=>$id);
$table="tbl_school_admin";
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$school_admin=mysql_fetch_array($results);
$sc_id=$_SESSION['school_id']; 


//include_once("scadmin_header.php");
//include ("conn.php");

$report="";

$sql=mysql_query("SELECT school_id,name FROM tbl_school_admin WHERE school_id=$sc_id");
$result=mysql_fetch_array($sql);
$school_id=$result['school_id'];
$uploadedBy=$result['name'];
 
?>

<html>
<head>
 
</head>
<script>
  //added Myfunction for ajax call by Pranali for SMC-5006
function Myfunction(value,fn)

{

 var course_level = document.getElementById("courseLev").value;
 if(fn=="fun_dept")
 {
  var dept_arr = value.split(",");
  
  value = dept_arr[0];

 }
 var dept = document.getElementById("department").value;
 var dept_arr1 = dept.split(",");
  
 var department = dept_arr1[0];

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

        if(fn=='fun_sem')

        {

           document.getElementById("class1").innerHTML =xmlhttp.responseText;

          

        }

        if(fn=='fun_subject')

        {

           document.getElementById("subject_code").innerHTML =xmlhttp.responseText;

          

        }


            }

          }
    
    var nval =escape(value);
      

 xmlhttp.open("GET","get_stud_sub_details.php?fn="+fn+"&value="+nval+"&course_level="+course_level+"&dept="+department,true);

        xmlhttp.send();

 }
 
}
</script>
<body bgcolor="#CCCCCC" >

<div style="bgcolor:#CCCCCC">

<div class="container" style="padding:25px;" >


      <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">

      <h2 style="padding-top:30px;"><center>Add Class Subject</center></h2>

      <!--Removed Add excel sheet option for SMC-4443 by Sayali Balkawade on 18/01/2020 -->
      
      <!--<center><a href="Add_class_Sheet.php">Add Excel Sheet</a> </center>-->
      
<!--replaced school_id with sc_id and removed DITINCT in all queries as per discussed with Rakesh Sir by Pranali for SMC-5147 -->
               <div class="row formgroup" style="padding:5px;">
               
         <form id="AddClassSubForm" method="POST">

<div class="row" style="padding-top:30px;">
<div class="col-md-4">
</div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Course Level
<span style="color:red;">*</span>
</div>
    <div class="col-md-3">
         <select name="courseLev" id="courseLev" class="form-control" required>

            <option value="">Select</option>

            <?php 
            $q=mysql_query("SELECT CourseLevel FROM tbl_CourseLevel WHERE CourseLevel!= '' AND school_id='$sc_id' order by CourseLevel ASC");

                    while($row=mysql_fetch_array($q))
                    {
                        $subject=$row['CourseLevel'];

                        ?>
             <option value="<?php echo $row['CourseLevel'];  ?>"><?php  echo $row['CourseLevel'];  ?></option>  

           <?php } ?>
        </select> 
   </div>            
</div> 

               <div class="row " style="padding-top:30px;">
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Department
         <span style="color:red;">*</span>
                   </div>
         
<div class="col-md-3">
<select  name="dept" id="department" class="form-control" required onchange="Myfunction(this.value,'fun_dept')">
<option value="">Select</option>
<?php 
$q=mysql_query("SELECT  Dept_code,Dept_Name,ExtDeptId FROM tbl_department_master WHERE Dept_Name != '' AND School_ID='$sc_id' ORDER BY Dept_Name ASC");
  
    while($row=mysql_fetch_array($q))
    {
      $department=$row['Dept_Name'];
      
      ?>
    <!--ExtDeptId added in dropdown value by Pranali for SMC-5006 -->      
 <option value="<?php echo $row['Dept_Name']; ?>,<?php echo $row['ExtDeptId']; ?>"> <?php echo $department;  ?> </option> 
<?php } ?>         
 </select>
 </div>
    <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
    </div>
       

    <div class="row " style="padding-top:30px;">
      <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Branch
      <span style="color:red;">*</span></div>   
      
           <div class="col-md-3"  >
         <select name="branch" id="branch" class="form-control" required onchange="Myfunction(this.value,'fun_branch')">
         <option value="">Select</option>
                     
                     
    
<!--
<?php 
//$q1=mysql_query("SELECT DISTINCT branch_id,branch_Name FROM tbl_branch_master WHERE branch_Name != '' AND school_id='$school_id' ORDER BY branch_Name ASC");
  
    /*while($row1=mysql_fetch_array($q1))
    {
      $branch=$row1['branch_Name']; */
      
      ?>
                     
 <option value="<?php //echo $row1['branch_Name']; ?>,<?php //echo $row1['branch_id']; ?>">  <?php //echo $branch; } ?> </option>
-->


         </select>

            </div>
          <div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>
      

         </div> <!--row-->


<div class="row" style="padding-top:30px;">

<div class="col-md-4"></div>

<div class="col-md-2" style="color:#808080; font-size:18px;">Semester
<span style="color:red;">*</span>
</div>

<div class="col-md-3">
 <select name="semester" id="semester" class="form-control" required onchange="Myfunction(this.value,'fun_sem')">

<option value="">Select</option>

<!--
<?php 
$q=mysql_query("SELECT  Semester_Id,Semester_Name FROM tbl_semester_master WHERE Semester_Name!= '' AND school_id='$sc_id' order by Semester_Name ASC");
  
    while($row=mysql_fetch_array($q))
    {
      $semester=$row['Semester_Name'];
      
      ?>
 <option value="<?php echo $row['Semester_Name']; ?>,<?php echo $row['Semester_Id']; ?>">  <?php echo $semester; }  ?>  </option> 
-->
     
</select>
</div> 
    
  <div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>
</div>

 
<div class="row" style="padding-top:30px;">
<div class="col-md-4">
</div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Class
<span style="color:red;">*</span>
</div>
    <div class="col-md-3">
         <select name="class1" id="class1" class="form-control" required>

            <option value="">Select</option>

            
        </select> 
   </div>            
</div>
                                    
 
                   
<div class="row" style="padding-top:30px;">
<div class="col-md-4">
</div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Subject Name
<span style="color:red;">*</span>
</div>
    <div class="col-md-3">
         <select name="subject_code" id="subject_code" class="form-control class11" required>

            <option value="">Select</option>

            <?php 
            $q=mysql_query("SELECT subject_id,subject,Subject_Code,Subject_type,Subject_short_name,Uploaded_by FROM tbl_school_subject WHERE subject!= '' AND school_id='$sc_id' order by subject ASC ");
              
                    while($row=mysql_fetch_array($q))
                    { 
                        $subject=$row['subject'];

                        ?>
             <option value="<?php echo $row['subject'];  ?>,<?php echo $row['subject_id'];  ?>,<?php  echo $subject=$row['Subject_Code'];  ?>,<?php  echo $subject=$row['Subject_type'];  ?>,<?php  echo $subject=$row['Subject_short_name'];  ?>,<?php  echo $subject=$row['batch_id'];  ?>,<?php  echo $subject=$row['Uploaded_by'];  ?>"><?php  echo $subject=$row['subject'];  ?></option> 
           <?php } ?>
        </select> 
   </div>            
</div>
                   
<div class="row" style="padding-top:30px;">
<div class="col-md-4">
</div>
<div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year
<span style="color:red;">*</span>
</div>
    <div class="col-md-3">
         <select name="acd_year" id="acd_year" class="form-control" required>

            <option value="">Select</option>

            <?php 
            $q=mysql_query("SELECT  Year,Academic_Year FROM tbl_academic_Year WHERE Academic_Year!= '' AND school_id='$sc_id' and Enable='1' order by Academic_Year ASC");

                    while($row=mysql_fetch_array($q))
                    {
                        $subject=$row['Academic_Year'];

                        ?>
             <option value="<?php echo $row['Academic_Year'];  ?>,<?php echo $row['Year'];  ?>"><?php  echo $subject=$row['Academic_Year'];  ?></option> 
           <?php } ?>
        </select> 
   </div>            
</div> 
                   
                   
                   
                   
 

        <div class="row" style="padding-top:40px;">
             <div class="col-md-2">
               </div>
                  <div class="col-md-1 col-md-offset-3">
                    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Add"  style="width:100%;" />
                    </div>
                     <div class="col-md-3"  align="left">
          <?php $site=$_SERVER['SERVER_NAME'];   ?>

        <a href="<?php echo "http://$site/core/list_class_subject.php"; ?>" style="text-decoration:none;"> 
    <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:28%;"  /></a>
            </div> 
           </div>

 
 </form>

 </div>
  </div>
   </div>
    </div>
  
<!--  Changes done end by Pranali_intern -->
</body>

</html>

<script type="text/javascript">
   $(document).ready(function() {   
        $(".class11").select2();
       
       $("#department").on('change',function(){
           var department      = $("#department").val(); 
           var dept            = department.split(',')[0];   
           var deptID          = department.split(',')[1];  
              if(dept != '')
                  {  
                                $.ajax({ 
                                     type:"POST",
                                     url:"select_branch_u_dept.php",
                                     data:{dept:dept},
                                     success:function(data)
                                     {   
                                                  //alert(data);  
                                                  $('#branch').html(data);
                                              
                                     } 
                                 }); 
                  
                  }else{
                      
                      //alert("Select Department");
                  }
           
           
       })
       
       $("#branch").on('change',function(){
           var branchName   = $("#branch").val(); 
           var branch       = branchName.split(',')[0];   
           var branchID     = branchName.split(',')[1]; 
              if(branch != '')
                  {  
                                $.ajax({ 
                                     type:"POST",
                                     url:"select_branch_u_dept.php",
                                     data:{branch:branch},
                                     success:function(data)
                                     {   
                                                  //alert(data);  
                                                  $('#semester').html(data);
                                              
                                     } 
                                 }); 
                  
                  }else{
                      
                      //alert("Select Department");
                  }
           
           
       })
      
      }); 
       //Added #submit in below line by Pranali for SMC-5006
       $("#submit").click(function(){ 
           //event.preventDefault();
           var courLev  = $("#courseLev").val();  
           var department      = $("#department").val(); 
           var dept            = department.split(',')[0];   
           var deptID          = department.split(',')[1];  
           
           var branchName   = $("#branch").val();
           //alert(branchName); 
           var  branchID       = branchName.split(',')[0];   
           var  branch  = branchName.split(',')[1];   
           
           var semester     = $("#semester").val();
         // alert(semester);
           var semID          = semester.split(',')[0];   
           var sem     = semester.split(',')[1]; 
          
           var classs         = $("#class1").val();
           var clas           = classs.split(',')[0];   
           var clasID         = classs.split(',')[1];
            
           var subjectName    = $("#subject_code").val();
           var subj           = subjectName.split(',')[0];   
           var subjectID      = subjectName.split(',')[1];
           var subjectCode    = subjectName.split(',')[2];   
           var subjectType    = subjectName.split(',')[3];
           var subShortName   = subjectName.split(',')[4];
           var batchID        = subjectName.split(',')[5];
           var subUploadBy    = subjectName.split(',')[6];
          
        
           var academic_year       = $("#acd_year").val(); 
           var acd_year            = academic_year.split(',')[0];   
           var acd_yearID          = academic_year.split(',')[1];
            
           var schoolID = "<?php echo $sc_id; ?>";
           
           var courLev  = $("#courseLev").val();  
           
                        var error = "";
                        var valerror = ""; 
                        if($("#courseLev").val() == "")
                            {
                                //error += "<p>Course Level field is required</p>";
                                alert("Please select an courselevel!");
                                return false;
                            }
                         
       
                        if($("#department").val() == "")
                            {
                                //error += "<p>Department field is required</p>";
                                alert("Please select an department!");
                                return false;
                            }
                       
                        if($("#branch").val() == "select")
                            {
                               // error += "<p>Branch field is required</p>";
                                alert("Please select an branch!");
                                return false;
                            }
           
                        if($("#semester").val() == "select")
                            {
                                //error += "<p>Semester field is required</p>";
                                alert("Please select an semester!");
                                return false;
                            }
           
                        if(($("#class1").val() == "0"))
                            {
                               // error += "<p>Class field is required</p>";
                               alert("Please select an class!");
                                      return false;
                            }
           
                       if($("#subject_code").val() == "")
                            {
                                //error += "<p>Subject field is required</p>";
                                alert("Please select an Subject Name!");
                                return false;
                            }
                       if($("#acd_year").val() == "")
                            {
                                //error += "<p>Academic Year field is required</p>";
                                alert("Please select an Academic Year!");
                               return false;
                            }
                       

                        if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }else{
                             //Added  window.location.href by Pranali for redirecting to list page after alert
                             //changed below code for SMC-5283 by Chaitali on 28-04-2021
                                 $.ajax({ 
                                     type:"POST",
                                     url:"insert_class_subject.php",
                                     data:{dept:dept,deptID:deptID,branch:branch,branchID:branchID,sem:sem,semID:semID,clas:clas,clasID:clasID,subj:subj,subjectID:subjectID,subjectCode:subjectCode,subjectType:subjectType,subShortName:subShortName,batchID:batchID,subUploadBy:subUploadBy,schoolID:schoolID,acd_year:acd_year,acd_yearID:acd_yearID,courLev:courLev},
                                     dataType    :   'JSON',
                                     success:function(data)
                                     {   
                                       
                                      alert(data.status);
                                      window.location.href='list_class_subject.php'; 
                                          /* alert(data);
                                           $("#error").hide();
                                           $('#AddClassSubForm')[0].reset();
                                           window.location.href='list_class_subject.php'; */
                                          
                                     } 
                                 });
                                // return false;
                            }
           
             });  
</script>
