<!--
Author: Pranali
Date created: 17-04-2019
This file was created for adding department activities for schools under AICTE group
 -->


 
<section class="content">
        <div class="container-fluid">
 
        <div class="row clearfix">
<div class="block-header" align='center'>
<?php
//flashdata added by Pranali for SMC-3825 on 20-5-19
               if($this->session->flashdata('success'))
                { ?>
<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             
               <?php  echo $this->session->flashdata('success'); ?>
               
              
</div>
<?php } 
  else if($this->session->flashdata('error'))
                {
?>
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php
 
              
                echo $this->session->flashdata('error');
               
                ?>
  </div>
  <?php } ?>
<h2>Departmental Activities List</h2>
</div>
<head>
 
<script type="text/javascript" src="<?php //echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php //echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
 
            
            <style type="text/css">
            
                .form_fee{
                            padding: 20px;
                            background-color: #3c9d9d;
                            width: 900px;
                }
                
                .form_group_two{
                        width: 461px;
                        /* padding: 20px; */
                        margin-bottom: 25px;
                   
                }
                
                .teach_process{
                    
                        width: 350px !important;
                }
                
                .form_tea_pro{
                    margin-left: 60px;
                }
            
                .semester{
                    padding-left: 8px !important;
                    border-radius: 5px !important;
                }
                select { vertical-align: top; }
                
            </style>
            
</head>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
<div style="margin-right: 70px;margin-bottom: 15px;">
<input type="submit" name="add" id="add" value="Add" style="background-color: #32bf29;color: #fff;padding-top: 4px;" class="btn btn-primary">
</div>
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    
                    
                   
                    
                    
<?php
//echo form_open("","class=form-horizontal");?>
                    <thead>
<tr>
<th>Sr. No.</th>
<th>Course Level</th> 
<th>Semester</th>
<th>Activity Name</th>
<th>Receiver Teacher ID</th>
<th>Receiver Teacher Name</th>
</tr>
                    </thead>
                    <tbody>
<?php
$i=1;
foreach($activities_data as $act_data)
{ 

?>  
<tr>
<td><?php echo $i++; ?></td>
<td><?php echo $act_data->CourseLevel; ?></td>
<td><?php echo $act_data->semester_name; ?></td>
<td><?php echo $act_data->activity_name; ?></td>
<td><?php echo $act_data->Receiver_tID; ?></td>
<td><?php echo $act_data->t_complete_name; ?></td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
<div class="row clearfix" id='add_activity'>
            <div class="panel panel-default">
<div class="panel-body">
<div class="form_fee">
<div id="error"></div>
<form id='aicte_form' action="<?php echo base_url();?>Teachers/aicte_dept_activity" method="POST">
<center><h4>Add Activity</h4></center>
<table class="table table-bordered table-responsive" id="myTable"> 

<tr>  
<div class="form-group">      
<label class="control-label col-sm-3" for="dept">Select Department:</label>
<div class="col-sm-9" style="margin-top:5px;"> 
    
   
    
    


             <select class="form-control" id="dept" name="dept">
              <option value="">Select Department</option>
              
<!--            <option value="<?php //echo $TeacherDept[0]->id."/".$TeacherDept[0]->Dept_Name; ?>"><?php //echo $TeacherDept[0]->Dept_Name; ?></option>\-->
             <?php foreach($TeacherDeptAll as $raw){ 
                 
               if($raw->Dept_Name){
                 ?>
                 
           <option value="<?php echo $raw->Dept_Name; ?>"><?php echo $raw->Dept_Name; ?></option> 
                 
              <?php }else if($raw->t_dept){?>
             
           <option value="<?php echo $raw->t_dept; ?>"><?php echo $raw->t_dept; ?></option>          
                 
                 <?php }}?>
                 
              </select>
        <?php echo form_error('dept', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
</div>

</div>
</tr>
  <tr>  

<div class="form-group"> 
                   
            <label class="control-label col-sm-3" for="teacher_name">Select Teacher Name:</label>
<div class="col-sm-9" style="margin-top:5px;"> 

             <select id="teacher_nameID" name="teacher_name" class="form-control">
                 
<!--                  <option value="all">All</option>  -->
             
              </select>
    
<!--
                                   <select id="live_data1" name="dept_id" class="form-control "> 
                                        
                                        <option value="all">All</option> 
                                        
                                           
                                        
                                    </select> 
-->
    
    
    
        <?php echo form_error('teacher_name', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
</div>

</div>
</tr>
                           <tr>  
                            <div class="form-group"> 
                   
            <label class="control-label col-sm-3" for="semester">Select Semester:</label>
<div class="col-sm-9" style="margin-top:5px;"> 

             <select class="form-control" id="teacher_semesterID" name="semester">
              <option value="">Select Semester</option>
<!--
              <?php
             // foreach($aicte_semester as $sem) 
              {
              ?>
            <option value="<?php //echo $sem->Semester_Id."-".$sem->Semester_Name."-".$sem->clid."-".$sem->CourseLevel; ?>"><?php //echo $sem->Semester_Name."-".$sem->CourseLevel; ?></option>
              <?php
              }

              ?>
-->

              </select>
        <?php echo form_error('semester', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
</div>

</div>
</tr>
  <tr>  
                    <div class="form-group"> 
<label class="control-label col-sm-3" for="activity">Select Activity:</label>
<div class="col-sm-9" style="margin-top:5px;"> 
<select class="form-control" id="activity" name="activity" >
<option value="">Select Activity</option>
<?php foreach($aicte_activity as $activity){?>
<option value="<?php echo $activity->act360_ID.'.'.$activity->act360_activity;?>"><?php echo $activity->act360_activity;?></option>
<?php } ?>
</select>
 <?php echo form_error('activity', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
</div>
</div>
</tr>
</table>
<div class="col-sm-offset-3 col-sm-9" style="margin-top: 25px;">
<input type="submit" name="submit" id="submit" value="Submit" style="margin-bottom: -18px;background-color: #32bf29;color: #fff;padding-top: 4px;" class="btn btn-primary" />
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
 

<br/><br/><br/>

<script>
$(document).ready(function(){

$("#add_activity").hide();

$("#add").click(function(){
  $("#add_activity").toggle();

});

 $("#aicte_form").submit(function(e){
             //e.preventDefault(); 
          
                        var error = "";
                        var valerror = "";
             var semester = $("#semester").val();
             var activity =  $("#activity").val();
var dept = $("#dept").val();
var teacher_name = $("#teacher_name").val();

                    if(dept == "")
                            {
                                error += "<p>Department field is required</p>";
                            }
                    if(teacher_name == "")
                            {
                                error += "<p>Teacher Name field is required</p>";
                            }
                    if(semester == "")
                            {
                                error += "<p>Semester field is required</p>";
                            }
                    
                    if(activity == "")
                            {
                                error += "<p>Activity field is required</p>";
                            }
                    
                                  
                     if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }
//                           else{
//                   
//                                                    $.ajax({
//                                                         url:'?php echo base_url();?>Teachers/aicte_dept_activity',
//                                                         type:"POST",
//                                                         data:{semester : semester, activity : activity}, //this is formData
//                                                        // processData:false,
//                                                        // contentType:false,
//                                                        // cache:false,
//                                                        // async:false,
//                                                          success: function(data){
//                                                              alert(data);
//                                                              $("#error").hide();
//                                                              $('form')[0].reset();
//                                                              //$('form').unbind("submit").submit();
//                                                               
//                                                               
//                                                       }
//                                                            
//                                                 });
//                                         
//                                
//                              } 
              
        });
    

     
         
         
     $("#dept").on('change',function(){
        
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>TeachersActivity/depatTeacherName",
                 data: {deptName: $("#dept").val()},
                 dataType: "text",  
                 cache:false,
                 success: 
                      function(data){
                       
                        $("#teacher_nameID").html(data);  
                      }
                  }); 
         
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>TeachersActivity/depatTeacherNameSemester",
                 data: {deptName: $("#dept").val()},
                 dataType: "text",  
                 cache:false,
                 success: 
                      function(data){
                        alert(data);  //as a debugging message.

                        $("#teacher_semesterID").html(data);  
                      }
                  }); 
             
         });
         
    });
 

</script>