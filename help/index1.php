<!DOCTYPE html>
<?php 
//Added by Sayali for SMC-4804 on 9/2/2020
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST']; 
  
//echo $link; 
?>
<html>
<title></title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="../Assets/css/bootstrap.css">

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<!--<a href="" ><img src="student.png"  width="200px" height="200px"></a>&nbsp;&nbsp;&nbsp;&nbsp;




<a href="teacher.html"><img src="teacher.png"  width="200px" height="200px"></a>&nbsp;&nbsp;&nbsp;&nbsp;



<a href="sponsor.html"><img src="sponsor.png" width="200px" height="200px"></a>-->


<form>
<div id="example1" >
<center><h1>SmartCookie Help!</h1></center>
<!--student , teacher, sponsor help-->
<div class="row"  >
  <div class="col-sm-3 col-md-3" id ="student">
    <div class="thumbnail">
      <img class="Image" src="student.png" data-toggle="tooltip" title="Click Here to Student Help!" height="200" width="200">
      <div class="caption">
        <h3>Student Help</h3>
        <p>Click here to show Student Help!</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3 col-md-3" id ="teacher">
    <div class="thumbnail">
      <img class="Image" src="teacher.png" data-toggle="tooltip" title="Click Here to Teacher Help!" height="200" width="200">
      <div class="caption">
        <h3>Teacher Help</h3>
        <p>Click here to show Teacher Help!</p>
      </div>
    </div>
  </div>

  <div class="col-sm-3 col-md-3" id ="sponsor">
    <div class="thumbnail">
      <img class="Image" src="sponsor.png" data-toggle="tooltip" title="Click Here to Sponsor Help!" height="200" width="200">
      <div class="caption">
        <h3>Sponsor Help</h3>
        <p>Click here to show Sponsor Help!</p>
      </div>
    </div>
  </div>
  
  <div class="col-sm-3 col-md-3" id ="aicte">
    <div class="thumbnail">
      <img class="Image" src="student.png" data-toggle="tooltip" title="Click Here to AICTE Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Feedback Help</h3>
        <p>Click here to show AICTE Help!</p>
      </div>
    </div>
  </div>
</div>
<!--STAR-4788 by Pranali : Added employee and manager pdf link-->
<!--STAR-4804 by Sayali  Added employee and manager pdf link to web and android on 3/9/2020-->
  <div class="col-sm-3 col-md-3" id ="emp">
    <div class="thumbnail">
      <img class="Image" src="emp.jpg" data-toggle="tooltip" title="Click Here to Employee Help!" height="200" width="200">
      <div class="caption">
        <h3>Employee Help</h3>
        <p>Click here to show Employee Help!</p>
      </div>
    </div>
  </div>
  <div class="col-sm-3 col-md-3" id ="manager1">
    <div class="thumbnail">
      <img class="Image" src="Manager.jpg" data-toggle="tooltip" title="Click Here to Manager Help!" height="200" width="200">
      <div class="caption">
        <h3>Manager Help</h3>
        <p>Click here to show Manager Help!</p>
      </div>
    </div>
  </div>
   <div class="user">
     
   </div>
   <!--student web , android, iOS help-->
<div class="row" id ="student_id" style="display:none">
  <a href="web/student/index.htm"><div class="col-sm-6 col-md-4" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to Student Website Help!" height="200" width="200">
      <div class="caption">
        <h3>Student Website Help</h3>
        <p>Click here to show Student Website Help!</p>
      </div>
    </div>
  </div></a>
  <a href="apps/student/android.htm"><div class="col-sm-6 col-md-4" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to Student Android Help!" height="200" width="200">
      <div class="caption">
        <h3>Student Android Help</h3>
        <p>Click here to show Student Android Help!</p>
      </div>
    </div>
  </div></a>

  <a href="apps/student/iOS.htm"><div class="col-sm-6 col-md-4" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/ioslogo.jpg" data-toggle="tooltip" title="Click Here to Student iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>Student iOS Help</h3>
        <p>Click here to show Student iOS Help!</p>
      </div>
    </div>
  </div></a>
</div>   
 
   <!--teacher web , android, iOS help--> 
   
<div class="row" id ="teacher_id" style="display:none">
  <a href="web/teacher/index.htm"><div class="col-sm-6 col-md-4" id ="teacher_id">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to Teacher Website Help!" height="200" width="200">
      <div class="caption">
        <h3>Teacher Website Help</h3>
        <p>Click here to show Teacher Website Help!</p>
      </div>
    </div>
  </div></a>
 <a href="apps/teacher/android.htm"><div class="col-sm-6 col-md-4" id ="teacher_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to Teacher Android Help!" height="200" width="200">
      <div class="caption">
        <h3>Teacher Android Help</h3>
        <p>Click here to show Teacher Android Help!</p>
      </div>
    </div>
  </div></a>

  <a href="apps/teacher/iOS.htm"><div class="col-sm-6 col-md-4" id ="teacher_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/ioslogo.jpg" data-toggle="tooltip" title="Click Here to Teacher iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>Teacher iOS Help</h3>
        <p>Click here to show Teacher iOS Help!</p>
      </div>
    </div>
  </div></a>
</div>   

  <!--sponsor web , android, iOS help--> 
<div class="row" id ="sponsor_id" style="display:none">
  <a href="web/sponsor"><div class="col-sm-6 col-md-4" id ="sponsor_id">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to Sponsor Website Help!" height="200" width="200">
      <div class="caption">
        <h3>Sponsor Website Help</h3>
        <p>Click here to show Sponsor Website Help!</p>
      </div>
    </div>
  </div></a>
  <a href="apps/sponsor/android.html"><div class="col-sm-6 col-md-4" id ="sponsor_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to Sponsor Android Help!" height="200" width="200">
      <div class="caption">
        <h3>Sponsor Android Help</h3>
        <p>Click here to show Sponsor Android Help!</p>
      </div>
    </div>
  </div></a>

  <a href="apps/sponsor/iOS.html"><div class="col-sm-6 col-md-4" id ="sponsor_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/ioslogo.jpg" data-toggle="tooltip" title="Click Here to Sponsor iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>Sponsor iOS Help</h3>
        <p>Click here to show Sponsor iOS Help!</p>
      </div>
    </div>
  </div></a>
</div> 
  
  <!--AICTE web , android, iOS help--> 
<div class="row" id ="aicte_id" style="display:none">
<div class="col-sm-3 col-md-3" id ="aicte_id1">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to AICTE Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE web Help</h3>
        <p>Click here to show AICTE web Help!</p>
      </div>
    </div>
  </div>

  <div class="col-sm-3 col-md-3" id ="aicte_id2">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to AICTE Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE Android Help</h3>
        <p>Click here to show AICTE Android Help!</p>
      </div>
    </div>
  </div>
<!--
  <a href="apps/sponsor/iOS.html"><div class="col-sm-6 col-md-4" id ="aicte_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/ioslogo.jpg" data-toggle="tooltip" title="Click Here to Sponsor iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE iOS Help</h3>
        <p>Click here to show AICTE iOS Help!</p>
      </div>
    </div>
  </div></a> -->
</div>
  <!--Employee web , android help--> 
  
<div class="row" id ="emp_id" style="display:none">
<a href="<?php echo $link;?>/help/pdf/Employee_Documentation.pdf"><div class="col-sm-3 col-md-3" id ="emp_id">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to Employee Help!" height="200" width="200">
      <div class="caption">
        <h3>Employee web Help</h3>
        <p>Click here to show Employee web Help!</p>
      </div>
    </div>
  </div></a>

  <a href="http://bit.ly/2rJInfV"><div class="col-sm-3 col-md-3" id ="emp_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to Employee Help!" height="200" width="200">
      <div class="caption">
        <h3>Employee Android Help</h3>
        <p>Click here to show Employee Android Help!</p>
      </div>
    </div>
  </div></a>
  </div>
  
    <!--Manager web , android help--> 
  
<div class="row" id ="manager_id" style="display:none">
<a href="<?php echo $link;?>/help/pdf/Manager_Documentation.pdf"><div class="col-sm-3 col-md-3" id ="manager_id">
    <div class="thumbnail">
      <img class="Image" src="web.png" data-toggle="tooltip" title="Click Here to Manager Help!" height="200" width="200">
      <div class="caption">
        <h3>Manager web Help</h3>
        <p>Click here to show Manager web Help!</p>
      </div>
    </div>
  </div></a>

  <a href="http://bit.ly/2MJ0ABg"><div class="col-sm-3 col-md-3" id ="manager_id">
    <div class="thumbnail">
      <img class="Image" src="apps/applogo/androidlogo.jpg" data-toggle="tooltip" title="Click Here to Manager Help!" height="200" width="200">
      <div class="caption">
        <h3>Manager Android Help</h3>
        <p>Click here to show Manager Android Help!</p>
      </div>
    </div>
  </div></a>
  </div>

  <!--AICTE web help 4-->
  
<div class="row" id ="aicte_web" style="display:none">
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Degree_Principal_Feedback.pdf"><div class="col-sm-3 col-md-3" id ="aicte_id">
    <div class="thumbnail">
      <img class="Image" src="principal.png" data-toggle="tooltip" title="Click Here to Student Website Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Principal Feedback Web Help</h3>
        <p>Click here to show Principal Feedback Help!</p>
      </div>
    </div>
  </div></a>
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Degree_HOD_Feedback.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="hod.png" data-toggle="tooltip" title="Click Here to Student Website Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree HOD Feedback Web Help</h3>
        <p>Click here to show HOD Feedback Help!</p>
      </div>
    </div>
  </div></a>

  <a href="https://smartcookie.in/help/pdf/AICTE_360_Degree_Teacher_Feedback.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="teacher.png" data-toggle="tooltip" title="Click Here to Student iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Teacher Feedback Web Help</h3>
        <p>Click here to show Teacher Feedback Help!</p>
      </div>
    </div>
  </div></a>
  
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Degree_Student_Feedback.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="student.png" data-toggle="tooltip" title="Click Here to Student iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Student Feedback Web Help</h3>
        <p>Click here to show Student Feedback Help!</p>
      </div>
    </div>
  </div></a>
</div>   


<!--AICTE android-->
<div class="row" id ="aicte_android" style="display:none">
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Android_Manual_For_Principal.pdf"><div class="col-sm-3 col-md-3" id ="aicte_id">
    <div class="thumbnail">
      <img class="Image" src="principal.png" data-toggle="tooltip" title="Click Here to Student Website Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Principal Feedback Android Help</h3>
        <p>Click here to show Principal Feedback Help!</p>
      </div>
    </div>
  </div></a>
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Android_Manual_For_HOD.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="hod.png" data-toggle="tooltip" title="Click Here to Student Website Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree HOD Feedback Android Help</h3>
        <p>Click here to show HOD Feedback Help!</p>
      </div>
    </div>
  </div></a>

  <a href="https://smartcookie.in/help/pdf/AICTE_360_Android_Manual_For_Teacher.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="teacher.png" data-toggle="tooltip" title="Click Here to Student iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Teacher Feedback Android Help</h3>
        <p>Click here to show Teacher Feedback Help!</p>
      </div>
    </div>
  </div></a>
  
  <a href="https://smartcookie.in/help/pdf/AICTE_360_Android_Manual_For_Student.pdf"><div class="col-sm-3 col-md-3" id ="student_id">
    <div class="thumbnail">
      <img class="Image" src="student.png" data-toggle="tooltip" title="Click Here to Student iOS Help!" height="200" width="200">
      <div class="caption">
        <h3>AICTE 360 Degree Student Feedback Android Help</h3>
        <p>Click here to show Student Feedback Help!</p>
      </div>
    </div>
  </div></a>
</div> 

</div>
</form>
</html> 

<script>
$(document).ready(function(){
 $("#student").click(function(){
  $('#student_id').show();
  $('#teacher_id').hide();
  $('#sponsor_id').hide();
  $('#aicte_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 
 $("#teacher").click(function(){
  $('#teacher_id').show();
  $('#student_id').hide();
  $('#sponsor_id').hide();
  $('#aicte_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 
 $("#sponsor").click(function(){
  $('#sponsor_id').show();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 
 $("#aicte").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#aicte_id').show();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 $("#aicte_id1").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_android').hide();
  $('#aicte_web').show();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 
 $("#aicte_id2").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_web').hide(); 
  $('#aicte_android').show();
  $('#emp_id').hide();
  $('#manager_id').hide();
 });
 
 
 
 $("#emp").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#aicte_id').hide();
  $('#manager_id').hide();
  $('#emp_id').show();
 });
 $("#emp").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_android').hide();
  $('#aicte_web').hide();
  $('#manager_id').hide();
  $('#emp_id').show();
 });
 
  $("#manager1").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_web').hide();
  $('#aicte_android').hide();
  $('#aicte_id').hide();
  $('#emp_id').hide();
  $('#manager_id').show();
 });
 $("#manager1").click(function(){
  $('#sponsor_id').hide();
  $('#student_id').hide();
  $('#teacher_id').hide();
  $('#aicte_android').hide();
  $('#aicte_web').hide();
  $('#emp_id').hide();
  $('#manager_id').show();
 });
 
 
});
</script>

