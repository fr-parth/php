<!--
Author: Pranali
Date created: 22-04-2019
This file was created for adding principal activities (institute, acr, society) for schools under AICTE group
 -->

 
              
 <section class="content">
        <div class="container-fluid">
 
        <div class="row clearfix">
<div class="block-header" align='center'>
   
   <?php 
     
   echo $activityLev =  $list == 'dept_activity' ? ( 'Departmental Activities' ) : ( $list == 'institute' ? ( 'Institute Activities' ) : ( $list == 'society' ? ( 'Contribution To Society' ): ('ACR' )  ) );
  
    ?> 
 

</div>
            
            
<!--
        <?php if($this->session->flashdata('error')){
    
            echo '<div class="alert alert-danger alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->session->flashdata('error') . '</div>';
        } ?>


        <?php if($this->session->flashdata('success')){
            echo
             '<div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. $this->session->flashdata('success') . '</div>'; } ?>
-->
 
<!--
            
<script type="text/javascript" src="<?php //echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php// echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
 
-->
<head>

            
            <style type="text/css">
            
                .form_fee{
                    padding: 50px;
                    background-color: #3c9d9d;
                    width: 900px;
                    border-radius: 17px;
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
                
                .form-group .form-control {
                    width: 100%;
                    border: none;
                    box-shadow: none;
                    -webkit-border-radius: 0;
                    -moz-border-radius: 0;
                    -ms-border-radius: 0;
                    border-radius: 0;
                    padding-left: 11px;
                    border-radius: 4px; 
                }
                
                .pagination {
                    display: inline-block;
                    padding-left: 0;
                    float: right;
                    margin: 20px 0;
                    border-radius: 4px;
                    background-color: bisque !important;
                }
                
                .panel-body {
                        padding: 52px 29px 38px 20px;
                        margin-left: 76px;
                }
                
                .form-group {
                    margin-bottom: 15px;
                    padding-bottom: 25px;
                }
                
               #user_image {
                    padding: 64px; 
                }
                
                #user_image img {
                    
                    margin-right: 10px;
                }
                
                #user_image_edit{
                    padding: 64px; 
                }
                #user_image_edit img{
                    margin-right: 10px; 
                }
                
                .table-bordered tbody tr td, .table-bordered tbody tr th {
                    padding: 10px;
                    border: 1px solid #eee;
                    text-align: center !important;
                }
                
                .block-header {
                    margin-bottom: 15px;
                    color: #fff;
                    background-color: #526f9a;
                    color: #fff;
                    padding: 10px !important;
                    font-size: 26px;
                    font-weight: normal;
                }
                
                 .Textcenter{
           
                       text-align: center;

                   } 
                
                   #overlay{

                        position: fixed;
                        bottom: 100px;
                        right: 650px;
                        width: 300px; 
                   }

                   #overlay img {

                       background: none !important;
                   }
              
                
                
            </style>
            
</head>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
  <form method="post" action="<?php echo base_url().'Teachers/aicte_principal_activity/'; ?><?php echo $list; ?>">
  <!-- <input type="hidden" name="xyz" value="<?php echo $_POST['year']; ?>"> -->
              <div class="row" style="padding:30px;">
                <div class="col-md-4" style="width:25%;"> </div>
                 <div class="col-md-2" style="color:#808080; font-size:18px; margin-left: 30px;">Select Year</div>
                <div class="col-md-3" style="margin-left: -50px;width: 170px;">
                  <?php $acad=$this->session->userdata('current_acadmic_year1'); ?>
                    <select name="year" id="year" class="form-control">
                      <!-- <option value="All">All</option> -->
                        <?php 
                        //print_r($yearAcd);
                        foreach($yearAcd as $acdYear)
                        { 
                        ?>
                               <option value="<?php echo $acdYear->Academic_Year; ?>" <?php if(isset($_POST['year'])) { if($acdYear->Academic_Year==$_POST['year']) { echo "selected"; } } else { if($acdYear->Academic_Year==$acad) { echo "selected"; } }  ?> > <?php echo $acdYear->Academic_Year; ?></option>
                           <?php } ?>
                    </select>
                    </br></br></br>
                </div>
                 <div class="col-md-2" style="margin:0px;">
                <button class="btn btn-success" type="submit" id="clickbind" name="acadmic_yr1">Submit</button>

                            <!-- <input type="submit" name="acadmic_yr1" value="Submit" class="btn btn-success" /> -->
                        </div>
                      

            </div>
       
                </form>
<div style="margin-right: 70px;margin-bottom: 15px;margin-top: -30px;">
<input type="submit" name="add" id="add" value="Add" style="background-color: #32bf29;color: #fff;padding-top: 4px;" class="btn btn-primary">
</div>
                
    
    <div id="live_data"></div>
 
                            </div>
                            </div>
    
    
    
<div class="row clearfix" id='add_activity'>
            <div class="panel panel-default">
<div class="panel-body">
<div class="form_fee">
<div id="error"></div>
    
<!--<form id='aicte_form' action="<?php //echo base_url();?>TeachersActivity/aicte_principal_activity/<?php //echo $list;?>" method="POST">-->
    
<form id="user_form" method="post" action="<?php echo base_url().'TeachersActivity/addActivityData'; ?>" enctype="multipart/form-data">
    <input type="hidden" value="<?php if(isset($_POST['year'])){ echo $_POST['year']; } ?>" name="AcademicYear3" id="AcademicYear3">
<center><h4 >Add Activity</h4></center>
          <table class="table table-bordered table-responsive" id="myTable"> 
                
              <tr>  
                <div class="form-group">   
                    <label class="control-label col-sm-3" for="dept">Select Department:</label>
                    <div class="col-sm-9"> 

                                 <select class="form-control" id="dept" name="dept" required>
                                    <option value="">Select Department</option>
                                     
                                     <?php 
                                 
                                     if($empType == '133' || $empType == '134' || $empType == '135' || $empType == '137')
                                     { 

                                     foreach($deptName_Tid as $row) { ?>
                                          <option value="<?php echo $row->t_dept.",".$empType.",".$row->t_DeptCode; ?>"><?php echo $row->t_dept; ?></option>
                                     
                                     <?php } }  ?>

                                  </select>
                            
                    </div> 
                </div>
             </tr>

              <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="teacher_name">Select Teacher Name:</label>
                    <div class="col-sm-9">  
                         <select class="form-control" id="teacher_nameID" name="teacher_name" required> 
                              
                         </select> 
                    </div> 
                 </div>
              </tr>
              
              <?php if($list == 'acr'){ ?>
               
            <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="teacher_academicYear">Select Year:</label>
                    <div class="col-sm-9">  
                          <select class="form-control" id="teacher_academicYear" name="teacher_academicYear" required>
                              
                 <option value="" selected="selected">Select Academic_Year</option> 
                              
                <?php foreach($yearAcd as $acdYear){ ?>
                   <option value="<?php echo $acdYear->Academic_Year;?>,<?php echo $list;?>"><?php echo $acdYear->Academic_Year; ?></option>
                <?php } ?> 
                                
                          </select>  
                     </div>
                 </div>
              </tr>
              
              <?php }else{ ?>
              
             <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="semester">Select Semester:</label>
                    <div class="col-sm-9">  
                         <select class="form-control" id="teacher_semesterID" name="semester" required>
                                
                          </select>  
                     </div>
                 </div>
              </tr>
              
            <?php } ?>  
               
            <?php if($list == 'acr'){
              ?>
              
              <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="semester">Select Activity:</label>
                    <div class="col-sm-9">  
                         <select class="form-control" id="activity" name="activity" required>
                       
                 <?php foreach($aicte_activity as $activity){
                   //print_r($aicte_activity); ?>
                   <option value="<?php echo $activity->act360_ID.','.$activity->act360_activity.','.$activity->act360_activity_level_ID.','.$activity->act360_credit_points;?>"><?php echo $activity->act360_activity; ?></option>
                <?php } ?> 
                        
                          </select>  
                     </div>
                 </div>
              </tr> 
              
            <?php }else{ ?>  
              
               <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="semester">Select Activity:</label>
                    <div class="col-sm-9">  
                         <select class="form-control" id="activity" name="activity" required>
                             
                     <option value="" selected="selected">Select Activity</option>
 
                 <?php foreach($aicte_activity as $activity){
                  ?>
                   <option value="<?php echo $activity->act360_ID.','.$activity->act360_activity.','.$activity->act360_activity_level_ID.','.$activity->act360_credit_points;?>"><?php echo $activity->act360_activity; ?></option>
                <?php } ?> 
                        
                          </select>  
                     </div>
                 </div>
              </tr> 
 
            <?php } ?>  
  
              <?php if($list == 'acr'){ ?>
              
              <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="activity">Select Rating:</label>
                    <div class="col-sm-9"> 
                        <select class="form-control" id="rating" name="rating" required> 
                            <option value="">Select Rating</option> 
                            <option value="5"><?php echo 'Satisfactory'; ?></option>
                            <option value="7"><?php echo 'Good'; ?></option>
                            <option value="8"><?php echo 'Very Good'; ?></option>
                            <option value="9"><?php echo 'Excellent'; ?></option>
                            <option value="10"><?php echo 'Extraordinary'; ?></option>  
                        </select> 
                    </div>
                 </div>
              </tr>
              
              <?php } ?>
              
               <tr>  
                <div class="form-group">  
                    <label class="control-label col-sm-3" for="semester">Choose Image</label>
                     <div class="col-sm-9">  
                        <input type="file" name="user_userfile[]" id="user_userfile" class="form-control" multiple/>  
                     </div>
                 </div>
              </tr> 
 
</table>
    
<div class="col-sm-offset-3 col-sm-9"  >
         <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" />
    
</div>
</form>
    
    
</div>
</div>
</div>
</div>
            
            
      
<div id="imgViewModal" class="modal fade">
    <div class="modal-dialog"> 
        <form id="update_form1">
            <div class="modal-content">
                <div class="modal-header"> 
                   <h4 class="modal-title">View</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                </div> 
           
                <div id="user_image"></div>
 
            </div>  
        </form> 
    </div>
</div>
 
            
<div id="imgViewModaledit" class="modal fade">
    <div class="modal-dialog"> 
        <form id="update_form" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
 
                   <h4 class="modal-title">Update Activity Image</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                </div>
                
                <div id="user_image_edit"></div> 
                
                <div class="modal-body">  
                    <label>Choose image</label>
 
                    <input type="file" name="user_userfile1" id="userfile1" value="" class="form-control"/> 
                    <span id="user_uploaded_image"></span>  
 
                </div>
 
                <div class="modal-footer">
                    <input type="hidden" id="user_id" value="" name="userid"> 
                    <input type="submit" name="action" id="action1" value="Update" class="btn btn-success" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div> 
            </div>  
        </form>  
     </div>    
 </div> 
            
            
            <div id="overlay" class="col-sm-offset-5">
                 <img src="<?php echo base_url(); ?>core/group_admin/image/loading.gif" class="Textcenter" alt="Loading" /> 
            </div>
    
            
</section>
  

<br/><br/><br/>
    
<script>

$(document).ready(function(){  
 
        $("#overlay").hide();
    
        console.log($(".myTable").DataTable()); 


        $("#add_activity").hide();

        $("#add").click(function(){
          $("#add_activity").toggle();


        }); 
    
      $(document).on('click','.imgView', function(){  
     
           var Imgid = $(this).attr("dept_act_id");
         
             $.ajax({ 
                url:"<?php echo base_url();?>/TeachersActivity/ActImageDisplay",
                method:"POST", 
                data:{deptId:Imgid}, 
                success:function(data)
                   {   
                     //alert(data);   
                     $("#user_image").html(data); 
                   }
               });
          return false;
          
          });
    
 
         function show_data1(ImgId)
           {  
              $.ajax({ 
               url:"<?php echo base_url();?>/TeachersActivity/updateData",
               method:"POST", 
               data:{user_id:ImgId},
               // dataType:"json",
               success:function(data)
               {
                  // alert("test");  
                 $("#user_image_edit").html(data); 
   
                }
              }) 
           }
           show_data1();
    
    
    $(document).on('click','.cImg', function(){
        
        if(confirm("Are you sure you want to delete this data?"))
          {
     
           var ImgId  = $(this).attr("techpro_id");
           var ImgUrl = $(this).attr("techimg_url");  
         
             $.ajax({ 
                url:"<?php echo base_url();?>/TeachersActivity/DelImageDisplayAct",
                method:"POST", 
                data:{techId:ImgId,techImgUrl:ImgUrl}, 
                success:function(data) 
                   {  
                      show_data1(ImgId);  
 
                   }
               });
 
            return false; 
      
        }else{

               return false;
           }       
 
          });
        
    
                                                 $(document).on('click','.btn_edit', function(){  
                                                        var id = $(this).attr("user_id"); 
                                                        $.ajax({ 
                                                        url:"<?php echo base_url();?>/TeachersActivity/updateData",
                                                        method:"POST", 
                                                        data:{user_id:id}, 
                                                               success:function(data)
                                                   {
                                                                    //alert(data);
                                                                    //var result= data.split('|');
                                                                    //var productDesc = result[0];
                                                                    //var productSize = result[1];
                                                                    
                                                                    $("#user_id").val(id);  
                                                                    $("#user_image_edit").html(data);  
 
                                                               }
                                                       });
                                                     return false;

                                                   }); 
 

                                                     $('#update_form').submit(function(e){ 
                                                         
                                                         $("#overlay").show();
                                                         
                                                           e.preventDefault();  
                                                                $.ajax({
                                                                     url:'<?php echo base_url();?>/TeachersActivity/updateUserData',
                                                                     type:"POST",
                                                                     data:new FormData(this), //this is formData
                                                                     processData:false,
                                                                     contentType:false,
                                                                     cache:false,
                                                                     async:false,
                                                                      success: function(data){
                                                                          alert(data);
                                                                          //$('form').unbind("submit").submit();  
                                                                          $('#update_form')[0].reset();
                                                                          $("#imgViewModaledit").modal('hide');
                                                                          show_data(); 
                                                                          $("#overlay").hide();
                                                                   }
                                                             });

                                                         return false;

                                                          }); 

    
    
                                 $(document).on('click','.btn_delete', function(){ 
                                        //var id = $(this).attr("user_id");  
                                       if(confirm("Are you sure you want to delete this data?"))
                                           { 
                                               $("#overlay").show();
                                               
                                              $.ajax({ 
                                                url:"<?php echo base_url();?>/TeachersActivity/deleteData",
                                                method:"POST", 
                                                data:"user_id="+$(this).attr("user_id"), 
                                                success:function(data)
                                                {
                                                   alert(data); 
                                                   //dataTable.ajax.reload();    
                                                   show_data();
                                                   $("#overlay").hide();    

                                                }
                                              });  

                                                return false;
                                           }else{

                                               return false;
                                           } 
                                   });
    
 
           function show_data() 
           {   
              var activityList = '<?php echo $list; ?>';
              var year = '<?php echo $_POST['year']; ?>';
             
              $.ajax({ 
               url   :"<?php echo base_url();?>TeachersActivity/fetchdata",
               method:"POST", 
               data:{activityList:activityList,year:year},      
                //contentType: "application/json; charset=utf-8",
               // dataType:"json",
               success:function(data)
               {
                 // alert(data);  
                  $("#live_data").html(data);
                   
                }
              }) 
           }
           show_data();

    
    $("#user_form").submit(function(e){
        
             e.preventDefault();
        console.log($('#AcademicYear3').val());
        $("#overlay").show();
        
        var activityList = '<?php echo $list; ?>';
        
               var error = "";
               var valerror = ""; 
        
                      if(activityList == 'acr'){
                        
                              if($("#dept").val() == "")
                                {
                                    error += "<p>Department field is required</p>";
                                } 
                               if($("#teacher_nameID").val() == "")
                                {
                                    error += "<p>Teacher name field is required</p>";
                                }
                                if($("#teacher_academicYear").val() == "")
                                  {
                                    error += "<p>AcademicYear field is required</p>";
                                  } 
                               if($("#rating").val() == "")
                                  {
                                    error += "<p>Rating field is required</p>";
                                  }
                                 
                          
                      }else{
                               if($("#dept").val() == "")
                                {
                                    error += "<p>Department field is required</p>";
                                } 
                               if($("#teacher_nameID").val() == "")
                                {
                                    error += "<p>Teacher name field is required</p>";
                                }
                               if($("#teacher_semesterID").val() == "")
                                 {
                                    error += "<p>Semester field is required</p>";
                                 } 
                              if($("#activity").val() == "")
                                 {
                                    error += "<p>Activity field is required</p>";
                                 } 
                                
                        
                             }      
                   
                                  
                     if(error != "")
                            {

                              $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }
                            else{ 

                                 $.ajax({
                                         type: "POST",
                                         url: "<?php echo base_url();?>TeachersActivity/addActivityData",
                                     //  data: {deptName:deptName,empType:empType,teaID:teaID,teaName:teaName,semID:semID,courLev:courLev,actID:actID,actName:actName,actLevID:actLevID,ratingPoints:ratingPoints,userfile:userfile}, 
                                     
                                          data:new FormData(this), //this is formData
                                          processData:false,
                                        contentType:false,
                                         cache:false, 
                                         success: function(data){
                                            alert(data);
                                              $("#error").hide();
                                             $('#user_form')[0].reset();  
                                              show_data();
                                              //$('form').unbind("submit").submit();
                                              $("#overlay").hide();
 
                                          } 
                                      }); 

                                 return false;
                                 
                                }
                           
                      });
 
    
    
    $("#dept").on('change',function(){
        
        var dept     = $("#dept").val(); //Civil Engineering ,133
        var deptName = dept.split(',')[0];
        var empType  = dept.split(',')[1];
        var depts    = dept.split(',')[2];
        var activityList = '<?php echo $list; ?>';
        //alert(deptcode); 
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>TeachersActivity/depatTeacherName",
                 data: {depts:depts,empType:empType,activityList:activityList},
                 dataType: "text",  
                 cache:false,
                 success: 
                      function(data){ 
                        // alert(data); 
                        $("#teacher_nameID").html(data);  
                      }
                  }); 
         
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>TeachersActivity/depatTeacherNameSemester",
                 data: {deptName:deptName},
                 dataType: "text",  
                 cache:false,
                 success: 
                      function(data){
                        //alert(data);  //as a debugging message. 
                        $("#teacher_semesterID").html(data);  
                      }
                  }); 
             return false;
          
         });
     
         
});
</script>