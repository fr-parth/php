<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);
// print_r($studentinfo);
 //echo $studentinfo[0]->ExtYearID;
?>

<!DOCTYPE html>
<html lang="en">
<head>

        <style>
         .mandatory {color: #FF0000;}
      </style>

</head>

<title>Add <?php echo ($school_type=='organization')?'Project':'Subject'; ?></title>



<body  >

     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Add <?php echo ($school_type=='organization')?'Project':'Subject'; ?></div>
                </div>
                 
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   <!-- <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">Add <?php echo ($school_type=='organization')?'Project':'Subject'; ?></li>
                </ol>
                
                <div class="clearfix"></div>
            </div>

<div style="bgcolor:#CCCCCC">
 <!-- Design form proper arrangement by chaitali solapure for SMC-4786 on 08-03-2021 -->
<div class="container" style="width: 100%; height:800px;">
            
            
                <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
                

               <div class="row formgroup" style="padding:5px;">
                  
                  <!--<form method="post" action="Add_subject_view">-->

                    <?php echo  form_open("main/Add_subject_view/".$studentinfo[0]->std_PRN,"class=form-horizontal");?>
                    <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Select Type<span class="mandatory">*</span>
                            </div>
                            <div class="col-md-3">
                            
                                <select name="choose" id="choose" class="form-control" >
                                    <option value="">Select Type</option>
                                    <option value="1">All</option>
                                    <option value="2">Relevant</option>
                                    
                                </select>   
                            </div>
                            <div id='hiddenDivAll' style="display:none">
                    
                            <div class="row " style="padding-top:60px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Department <span class="mandatory">*</span>
                            </div>
                            <div class="col-md-3">
                                <select name="department" id="department" class="form-control">
                                <option value="">Choose</option>
                                    <?php foreach ($getalldepartment as $value) {
                                        ?>
                                        <option value="<?php echo $value['Dept_Name']; ?>"><?php echo $value['Dept_Name']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php echo form_error('department', '<div class="error">', '</div>'); ?>
                        </div>
                        
                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Employee':'Course'; ?> Level <span class="mandatory">*</span>
                            </div>
                            <div class="col-md-3">
                                <select name="CourseLevel" id="CourseLevel" class="form-control">
                                    <option value="">Choose</option>
                                    
                                    <?php foreach ($getCourselevel as $value) {
                                        ?>
                                        <option value="<?php if($value['CourseLevel']){echo $value['CourseLevel'];}else{}?>"><?php if($value['CourseLevel']){echo $value['CourseLevel'];}else{}?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php echo form_error('CourseLevel', '<div class="error">', '</div>'); ?>
                        </div>
                        
                       


                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Section':'Branch'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="Branch" id="Branch" class="form-control">
                                <option value="">Choose</option>
                                     <?php foreach ($getallbranch as $value) {
                                        ?>
                                        <option value="<?php echo $value['branch_Name'] ?>"><?php echo $value['branch_Name']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php echo form_error('Branch', '<div class="error">', '</div>'); ?>
                        </div>
                        
                         <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Location':'Division'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="Division" id="Division" class="form-control">
                                <option value="">Choose</option>
                                <?php foreach ($getDivision as $value) {
                                    ?>
                                    <option value="<?php echo $value['DivisionName'] ?>"><?php echo $value['DivisionName']; ?> </option>
                                <?php  } ?>
                                </select>
                            </div>
                            <?php echo form_error('Division', '<div class="error">', '</div>'); ?>
                        </div> 
                        
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Default Duration':'Semester'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="semester" id="semester" class="form-control">
                                <option value="">Choose</option>
                                    <?php foreach ($getallsemester as $value) {
                                        ?>
                                        <option value="<?php echo $value['Semester_Name'] ?>"><?php echo $value['Semester_Name']; ?> </option>
                                    <?php } ?>
                                </select>

                            </div>
                            <?php echo form_error('semester', '<div class="error">', '</div>'); ?>
                        </div>

                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Financial':'Academic'; ?> Year <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="AcademicYear" id="AcademicYear" class="form-control">
                                <option value="">Choose</option>
                                    
                                    
                                    <?php foreach ($getAcademicYear as $value) {
                                        ?>
                                        <option value="<?php echo $value['Academic_Year']; ?>"><?php echo $value['Academic_Year']; ?> </option>
                                    <?php } ?>
                                </select>

                            </div>
                            <?php echo form_error('AcademicYear', '<div class="error">', '</div>'); ?>

                        </div>
                                                
                         <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Project':'Subject'; ?> Name <span class="mandatory">*</span>
                            </div>
                            <div class="col-md-3">
                                <select name="subject_name" id="subject_name" class="form-control" >
                                <option value="">Choose</option>
                                    <?php foreach ($getallsubject as $value) {
                                        ?>
                                        <option value="<?php echo $value['subject'].','.$value['Subject_Code'] ?>"><?php echo $value['subject']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php echo form_error('subject_name', '<div class="error">', '</div>'); ?>
                        </div>

                        <!-- <div class="row" style="padding-top:30px;"> -->
                            <!-- <div class="col-md-4"></div> -->
                            <!-- <div class="col-md-2" style="color:#808080; font-size:18px;"><?php //echo ($school_type=='organization')?'Manager':'Teacher'; ?></div> -->
                            <!-- <div class="col-md-3"> -->
                                <!-- <select name="teacher_manager1" id="teacher_manager1" class="form-control"> -->
                                <!-- <option value="">Choose</option> -->
                                   <!-- <?php //foreach ($getTeacher as $value) { -->
                                        // ?>
                                        <option value="<?php //echo $value['t_id']; ?>"><?php //echo $value['teacher_name']; ?> </option>
                                    <?php // } ?> 
                                 </select> -->
<!--  -->
                            <!-- </div> -->
                            <!-- <?php //echo form_error('teacher_manager1', '<div class="error">', '</div>'); ?> -->
<!--  -->
                        <!-- </div> -->
                        
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-5"></div>
                            <?php
                            if (isset($report)) {
                            ?> <font color="green"><?php echo $report;?></font>
                          <?php

                            }if(isset($report1)){
                            ?> <font color="red"><?php echo $report1;?></font>
                           <?php }

                            ?>
                        
                        <div class="col-md-1"><input type="submit" name="submit" id="addsubject" value="Add" class="btn btn-success"></div>
                            <!--<input type="button" name="cancel" id="cancel" value="Cancel" class="btn btn-danger" onclick="history.back()" >-->
                            <a href="<?php echo site_url();?>/main/student_subjectlist" ><button type="button" class="btn btn-danger">Cancel</button></a>
                            </div>      <br>
                    </div>
                        
                    <div id='hiddenDivRel' style="display:none">
                    <!--Displayed all relevant data of student in dropdowns by Pranali for SMC-5091-->
                         <div class="row " style="padding-top:60px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Department <span class="mandatory">*</span>
                            </div>
                            <!--SMC-5091 by Pranali: Taken Dept_Name from tbl_department_master for displaying department name -->
                            <div class="col-md-3">
                                <select name="departmentrel" id="departmentrel" class="form-control">
                                <!-- <option value="">Choose</option> -->
                                  <option value="<?php echo $studentinfo[0]->Dept_Name; ?>" selected><?php echo $studentinfo[0]->Dept_Name; ?> </option>
                                    
                                </select>
                            </div>
                            <?php echo form_error('departmentrel', '<div class="error">', '</div>'); ?>
                        </div>
                        
                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Employee':'Course'; ?> Level <span class="mandatory">*</span>
                            </div>
                            <div class="col-md-3">
                                <select name="courselevelrel" id="courselevelrel" class="form-control">
                                    <!-- <option value="">Choose</option> -->
                                    <option value="<?php echo $studentinfo[0]->Course_level; ?>" selected><?php echo $studentinfo[0]->Course_level; ?> </option>
                                    
                                </select>
                            </div>
                            <?php echo form_error('courselevelrel', '<div class="error">', '</div>'); ?>
                        </div>
                        
                       


                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Section':'Branch'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="branchrel" id="branchrel" class="form-control">
                                <!-- <option value="">Choose</option> -->
                                     <option value="<?php echo $studentinfo[0]->std_branch; ?>" selected><?php echo $studentinfo[0]->std_branch; ?> </option>
                                </select>
                            </div>
                            <?php echo form_error('branchrel', '<div class="error">', '</div>'); ?>
                        </div>
                        
                          <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Location':'Division'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="divisionrel" id="divisionrel" class="form-control">
                                <!-- <option value="">Choose</option> -->
                               <option value="<?php echo $studentinfo[0]->std_div; ?>" selected><?php echo $studentinfo[0]->std_div; ?> </option>
                                </select>
                            </div>
                            <?php echo form_error('divisionrel', '<div class="error">', '</div>'); ?>
                        </div> 
                        
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Default Duration':'Semester'; ?> <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="semesterrel" id="semesterrel" class="form-control">
                                <!-- <option value="">Choose</option> -->
                                    <option value="<?php echo $studentinfo[0]->std_semester; ?>" selected><?php echo $studentinfo[0]->std_semester; ?> </option>
                                </select>

                            </div>
                            <?php echo form_error('semesterrel', '<div class="error">', '</div>'); ?>
                        </div>
<!--Displayed academic year from tbl_academic_Year by Pranali for SMC-5091-->
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Financial':'Academic'; ?> Year <span class="mandatory">*</span></div>
                            <div class="col-md-3">
                                <select name="academicyearrel" id="academicyearrel" class="form-control">
                                <!-- <option value="">Choose</option> -->
                                   <option value="<?php echo $studentinfo[0]->std_year; ?>" selected><?php echo $studentinfo[0]->Academic_Year; ?> </option>
                                </select>

                            </div>
                            <?php echo form_error('academicyearrel', '<div class="error">', '</div>'); ?>

                        </div>               
                             <div class="row" style="padding-top:30px;">
                                <div class="col-md-4"></div>
                                <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo ($school_type=='organization')?'Project':'Subject'; ?> Name <span class="mandatory">*</span></div>
                                <div class="col-md-3">
                                    <select name="subjectnamerel" id="subjectnamerel" class="form-control">
                                    <option value="">Choose</option>
                                       
                                    </select>

                                </div>
                                <?php echo form_error('subjectnamerel', '<div class="error">', '</div>'); ?>

                            </div>

                            <!-- <div class="row" style="padding-top:30px;"> -->
                            <!-- <div class="col-md-4"></div> -->
                            <!-- <div class="col-md-2" style="color:#808080; font-size:18px;"><?php //echo ($school_type=='organization')?'Manager':'Teacher'; ?> <span class="mandatory">*</span></div> -->
                            <!-- <div class="col-md-3"> -->
                                <!-- <select name="teacher_manager" id="teacher_manager" class="form-control"> -->
                                <!-- <option value="">Choose</option> -->
                                   <!--  -->
                                <!-- </select> -->
<!--  -->
                            <!-- </div> -->
                            <!-- <?php //echo form_error('teacher_manager', '<div class="error">', '</div>'); ?> -->
<!--  -->
                            <!-- </div> -->
                       
                        
                    
                      <!-- <div class="row " style="padding-top:50px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Subject code
                            </div>
                            <div class="col-md-3">
                                 <select name="Subject_Code" id="Subject_Code" class="form-control">
                                <option value="">Choose</option>
                                    <?php //foreach ($getallsubject as $value) {
                                       // ?>
                                        <option value="<?php// echo $value->Subject_Code ?>"><?php// echo $value->Subject_Code; ?> </option>
                                    <?php //} ?>
                                </select>
                            </div>
                        </div>-->
                
                        
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-5"></div>
                            <?php
                            if (isset($report)) {
                            ?> <font color="green"><?php echo $report;?></font>
                          <?php

                            }if(isset($report1)){
                            ?> <font color="red"><?php echo $report1;?></font>
                           <?php }

                            ?>
                        
                        <div class="col-md-1"><input type="submit" name="submit" id="submit" value="Add" class="btn btn-success"></div>
                            
                            &nbsp;&nbsp;<a href="<?php echo site_url();?>/main/student_subjectlist" ><button type="button" class="btn btn-danger">Cancel</button></a>
                        </div><br>
                    </div> 
                          
                    <!--</form>-->
                    
                    </div>
                    <?php
                        echo form_close();
                    ?>
                    
            </div>
        </div>
    </div>
    <?php 


$this->load->view('footer');

?>
</body>
</html>
<script>
//Added below function by Pranali for SMC-5091
$("#subject_name").change(function(){

var course_level = document.getElementById("CourseLevel").value;
var Dept_Name = document.getElementById("department").value;
var subject = document.getElementById("subject_name").value;
var semester = document.getElementById("semester").value;
var year = document.getElementById("AcademicYear").value;
var branch = document.getElementById("Branch").value;
var division = document.getElementById("Division").value;
var subject_type = document.getElementById("choose").value;
var school_id = '<?php echo $studentinfo[0]->school_id; ?>';
var url = '<?php echo BASE_URL ?>'+'/core/get_student_subject_data.php';
            
            $.ajax({
                method : "POST",
                url : url,
                data : {course_level : course_level, Dept_Name : Dept_Name, subjectCode : subject, semester : semester, year : year, division:division, branch:branch, school_id : school_id ,fn_name : "teacher_name"},
                success : function(data){
                    $("#teacher_manager1").html(data);
                }
            });
    
});
</script>

<script>
 $(document).ready(function() {
     $("#hiddenDivAll").show();
     $("#choose").on('change',function(){
        var value = $(this).val();
        if(value == '1')
        {
            $("#hiddenDivAll").show();
            $("#hiddenDivRel").hide();
            
        }
        else
        {
            $("#hiddenDivAll").hide();
            $("#hiddenDivRel").show();
            $("#hiddensub").hide();
        }
     })
    //Called  get_student_subject_data.php file for getting data from webservice by Pranali for SMC-5091
    var url = '<?php echo BASE_URL ?>'+'/core/get_student_subject_data.php';
    var stud_prn = '<?php echo $studentinfo[0]->std_PRN; ?>';
    var school_id = '<?php echo $studentinfo[0]->school_id; ?>';
    

     
    //   var type = 'department';
         
    //   // $.ajax({
    //      //  type: "POST",
    //      //  url: '<?php //echo base_url();?>/main/subject_relevant_details',
    //      //  data: { type:type, department:department},
    //      //  cache:false,
    //      //  success: function(data) {
    //      //          $('#departmentrel').html(data);
    //      //      }       
    //      //  });


 //            $.ajax({
 //                    method : "POST",
 //                    url : url,
 //                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id},
 //                    success : function(data){
 //                        $("#departmentrel").html(data);
 //                    }
 //                });

    
    // })
     
    //  $("#departmentrel").on('change',function(){
    //   var department = $("#departmentrel").val();
    //   //var courselevel = $(this).val();
    //   var type = 'course_level';
         
    //      $.ajax({
 //                    method : "POST",
 //                    url : url,
 //                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department},
 //                    success : function(data){
 //                        $("#courselevelrel").html(data);
 //                    }
 //                });
    
    // })

    //  $("#courselevelrel").on('change',function(){
    //   var department = $("#departmentrel").val();
    //   var courselevel = $("#courselevelrel").val();
    //   //var branch = $(this).val();
    //   var type = 'branch';
         
    //   $.ajax({
 //                    method : "POST",
 //                    url : url,
 //                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department, course_level : courselevel},
 //                    success : function(data){
 //                        $("#branchrel").html(data);
 //                    }
 //                });
    
    // })
    
    
    // $("#branchrel").on('change',function(){
    //   var department = $("#departmentrel").val();
    //   var courselevel = $("#courselevelrel").val();
    //   var branch = $("#branchrel").val();
    //   //var division = $(this).val();
    //   var type = 'division';
         
    //   $.ajax({
 //                    method : "POST",
 //                    url : url,
 //                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department, course_level : courselevel, branch : branch},
 //                    success : function(data){
 //                        $("#divisionrel").html(data);
 //                    }
 //                });
    
    // })
    
    
    //  $("#divisionrel").on('change',function(){
    //   var department = $("#departmentrel").val();
    //   var courselevel = $("#courselevelrel").val();
    //   var branch = $("#branchrel").val();
         
         
    //   //var semester = $(this).val();
    //   var type = 'semester';
         
    //   $.ajax({
 //                    method : "POST",
 //                    url : url,
 //                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department, course_level : courselevel, branch : branch, division : division},
 //                    success : function(data){
 //                        $("#semesterrel").html(data);
 //                    }
 //                });
    
    // })
    
    // $("#semesterrel").on('change',function(){
    //   var department = $("#departmentrel").val();
    //   var courselevel = $("#courselevelrel").val();
    //   var branch = $("#branchrel").val();
    //   var semester = $(this).val();
    //   var type = 'acyear';
         
    //   $.ajax({
    //          type: "POST",
    //          url: '<?php //echo base_url();?>/main/subject_relevant_details',
    //          data: { type:type,department:department,courselevel:courselevel,branch:branch,division:division,semester:semester},
    //          cache:false,
    //          success: function(data) {
    //                  $('#academicyearrel').html(data);
    //              }       
    //          });
    
    // })
    
    // $("#academicyearrel").on('change',function(){

$("#choose").on('change',function(){
         var choose = $(this).val();
         if(choose == 2){ //relevant

         var department = $("#departmentrel").val();
         var courselevel = $("#courselevelrel").val();
         var branch = $("#branchrel").val();
         var semester = $("#semesterrel").val();
         var division = $("#divisionrel").val();
         var acyear = $("#academicyearrel").val();
         var type = 'rel_subject';
         
         $.ajax({
                    method : "POST",
                    url : url,
                    data : { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department, course_level : courselevel, branch : branch, division : division, semester : semester},
                    success : function(data){
                        $("#subjectnamerel").html(data);
                    }
                });
    }
});
//Start code SMC-4263 by Pranali on 8-1-20 : added below if condition for getting relevant teacher list and update into teacher dropdown
//modified academic year value by Pranali for solving issue of relevant teacher name not displaying
    $("#subjectnamerel").on('change',function(){
         var department = $("#departmentrel").val();
         var courselevel = $("#courselevelrel").val();
         var branch = $("#branchrel").val();
         var semester = $("#semesterrel").val();
         var division = $("#divisionrel").val();
         var acyear = $("#academicyearrel").val();
         var subject_arr = $(this).val();
         var type = 'teacher_name';
         
         $.ajax({
                type: "POST",
                url: url,
                data: { fn_name : type, stud_prn : stud_prn, school_id : school_id, Dept_Name : department, course_level : courselevel, branch : branch, division : division, semester : semester, subjectCode : subject_arr, year : acyear},
                cache : false,
                success: function(data) {
                    //alert(data);
                        $("#teacher_manager").html(data);
                    }       
                });
    
    })
//End SMC-4263
     
})   

 </script>