<?php 
  $this->load->view('stud_header',$studentinfo);
 ?>

<!DOCTYPE html>

<html lang="en"> 
    <style type="text/css">
    
        .feedbackAicte{ 
            padding: 10px; 
 
        }  
 
        .rating_model {
            margin: 45px !important;
            background-color: #aec4c8;
            border-radius: 6px;
 
        } 
        .start{
            color: red;
        } 
 
        .form-control {
                display: block;
                width: 100%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px !important;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            }
            
        
        table.dataTable.no-footer {
                border-bottom: 1px solid #111111;
                margin-left: 0px !important;
            }
        
        #tbl_form {
                margin-top: 28px;
                margin-left: 86px
        }
        
 
        .que_width{ 
            
            margin-left: 20px;
            
        }
        
        
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

            fieldset, label { margin: 0; padding: 0; }
 
            .rating { 
              border: none;
              float: left;
            /*  width: 188px;*/
            }

            .rating > input { display: none; } 
            .rating > label:before { 
              margin: 5px;

              font-size: 1.25em;
              font-family: FontAwesome;
              display: inline-block;
              content: "\f005";
            }

            .rating > .half:before { 
              content: "\f089";
              position: absolute;
            }

            .rating > label { 
              color: #ddd; 
             float: right; 
            } 
 
            .rating > input:checked ~ label,  
            .rating:not(:checked) > label:hover,  
            .rating:not(:checked) > label:hover ~ label { color: #FFD700;  }  

            .rating > input:checked + label:hover,  
            .rating > input:checked ~ label:hover,
            .rating > label:hover ~ input:checked ~ label,  
            .rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
   
 
        
        .rating input:checked~label,
        .rating input:not(:checked):not(:disabled) + label:hover,
        .rating input:not(:checked):not(:disabled) + label:hover~label {
 
        color: #FFD700;}
 
       .rating label {
            display: block;
            float: right;
            height: 17px;
            margin-top: 5px;
            padding: 0 0px !important;
            font-size: 17px;
            line-height: 17px;
            cursor: pointer;
            color: #ccc;
            -ms-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -webkit-transition: color 0.3s;
        } 
        
        
        .rating_width{
            width: 170px;
        }
        
        #myTable{
                margin-left: -46px !important; 
        }
        
        .que_dis_num{
            
            margin-left: 50px;
        }
        
        #subFeddback{
            
            margin-right: 24px;
        }
        
        .modal-footer {
            margin-top: 15px;
            padding: 19px 20px 20px;
            text-align: right;
            border-top: none !important;  
        }
        
        .highlight{
            color: #fcb800 !important;
             
        }
        
        .chSubj{
            position: relative;
            right: 45px;
        }
 
        .textComment{
            position: relative;
            right: 0px;
        }
        
        .tesDis {
                position: relative;
                right: 45px;
            }
        
        .whole_table{
            /*background-color: #fff; */
        }
 
    </style>

    
<head>
 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
    <title>Student Rating</title>  
</head> 

    
<body>  
    <script>
        $(document).ready(function(){
         $('.SMCselect2').select2({
        
         });
        });

    </script>

<div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT--> 
           
    <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left">
                <div class="page-title">AICTE Feedback</div>
            </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?= base_url('Main/members');?>">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   
                    <li class="active">AICTE Feedback</li>
                </ol>
                <div class="clearfix"></div>
        </div>
 
                 <?php if($this->session->flashdata('error')){
    
                    echo '<div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->session->flashdata('error') . '</div>';
                } ?>


                <?php if($this->session->flashdata('success')){
                    echo
                     '<div class="alert alert-success alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. $this->session->flashdata('success') . '</div>'; } ?>
                 
            <div id="success"></div>
            <div id="error"></div>
 
        <form  id="tbl_form" method="POST">
               <div class="row">
                    <div class="col-md-10" style="margin-left: -46px;">
                        <div class="form-group">  
                             <label> Teacher </label>
                            <select class="form-control text-center SMCselect2" name="que_is_teacher" id="que_is_teacher" onclick="doConfirm()"> 
         
                                <option value=" " selected="selected">------------Choose Teacher------------</option> 
                                    <?php $flag=0; foreach($stud_subList['posts'] as $student){if($student['t_id']!=''){$flag=1; ?>
                                <option value="<?php echo $student['t_id']?>"><?php echo $student['t_complete_name'];?></option>  
             
                                    <?php } }?>
             
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php $current_acadmic_year=$Academic_Year[0]->Academic_Year; ?>
                        <div class="col-md-10" style="margin-left: -46px;">

                            <div class="form-group">  
                                <label> Academic Year </label>
                                <select class="form-control text-center SMCselect2" name="acadmic_year1" id="acadmic_year1"> 
             
                                    <option value="" selected="selected">------------Academic Year------------</option> 
                                    <?php foreach($stud_subList1['posts'] as $student){ ?>
                                    <option value="<?php echo $student['Academic_Year']?>" <?php if($student['Academic_Year']==$current_acadmic_year){?> selected <?php } ?>><?php echo $student['Academic_Year'];?></option>  
                                    <?php  }?>
                 
                                </select> 
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-10" style="margin-left: -46px;">
                        <div class="form-group">  
                            <label> Subject </label>
                                <select class="form-control text-center SMCselect2" name="que_is_sub" id="que_is_sub"> 
             
                                </select> 
                        </div>
                    </div>
                </div>
                <?php 
                $allow_stud2=(array)$Allow_student_add_subject_360[0];
                if($allow_stud2['Allow_student_add_subject_360']=='Y'){
                ?> 
                <div class="row">
                    <div class="col-md-3">
                           <label> To Add Subject Manually</label>
                    </div>
                    <div class="col-md-1" id="div_check_manual1_add">
                        <input type="button" name="check_manual" id="check_manual1" value="Add" />
                    </div>
                    <div class="col-md-1" id="div_check_manual1_cancle">
                        <input type="button" name="check_manual" id="check_manual1_cancle" value="Cancel" />
                    </div>
                </div>
                <?php }
                else {
                    ?>

                    <input type="hidden" name="check_manual" id="check_manual1" value="" />
              <?php  }
                  ?>
            <div  id="div123" style="margin-left: -46px;">

                <div class="row"> 
                    <div class="col-md-3">
                     
                        <div class="form-group">
                            <label  for="sub_code_m">Subject Code  </label><span class="mandatory" style="color: red">*</span>
                            <input class="form-control" type="text" name="sub_code_m" id="sub_code_m" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                     
                        <div class="form-group">
                            <label>Subject Name  </label><span class="mandatory" style="color: red">*</span>
                            <input class="form-control" style="margin-bottom: 9px;" type="text" name="sub_name_m" id="sub_name_m" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                     
                        <div class="form-group">
                            <label>Subject Type  </label>
                            <input class="form-control" style="margin-bottom: 9px;" type="text" name="sub_type_m" id="sub_type_m">
                        </div>
                    </div>
                </div>
          
                <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>CourseLevel  </label>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="courselevel_mutual" value="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department  </label>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="dept_mutual" value="<?php echo $this->session->userdata('dept_mutual'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Branch  </label>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="branch_mutual" value="<?php echo $this->session->userdata('branch_mutual'); ?>">
                            </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Class  </label>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="class_mutual" value="">
                            </div>
                        </div>
                     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Division </label>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="div_mutual" value=""> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Semester  </label><span class="mandatory" style="color: red">*</span>
                                <input class="form-control" style="margin-bottom: 9px;" type="text" name="" id="sem_mutual" value="<?php echo $this->session->userdata('sem_mutual'); ?>" required> 
                          
                            </div>
                        </div>
                </div>
                <!-- </div>  -->
            </div>  
                <input class="form-control" type="hidden" name="" id="set_value_manual" > 
                                      
                     <!--  <div class="form-group">  
                                <select class="form-control text-center" name="que_is_sub" id="que_is_sub"> 
 
                <option value=" " class="text-center" selected="selected">------------Choose Student Subject------------</option> 
                <?php foreach($stud_subList1['posts'] as $student){ ?>
                <option value="<?php echo $student->subjectName?>,<?php echo $student->teacher_ID?>,<?php echo $student->subjcet_code?>,<?php echo $student->Division_id?>,<?php echo $student->Semester_id?>,<?php echo $student->Branches_id?>,<?php echo $student->Department_id?>,<?php echo $student->CourseLevel?>,<?php echo $student->AcademicYear?>"><?php echo $student->subjectName?></option> 
   
                <option value="<?php echo $student['subjectName']?>~<?php echo $student['teacher_id']?>~<?php echo $student['subjcet_code']?>~<?php echo $student['Division_id']?>~<?php echo $student['Semester_id']?>~<?php echo $student['Branches_id']?>~<?php echo $student['Department_id']?>~<?php echo $student['CourseLevel']?>~<?php echo $student['AcademicYear']?>"><?php echo $student['subjectName'];?></option>  
     
     
                <?php } ?>
     
                                </select> 
                            </div> -->

                          
                           <!--  <div class="tesDis">
                             <div class="row">
                                 
                                 <div class="col-md-6">
                             
                      <div class="alert alert-success alert-dismissable" id="showTeacherName" style="display:none;"></div>
                                     
                                 </div>  
                             </div>
                             </div>   -->  
                             
                             <br/>
                     
                    <!--                     style="display:none;"-->

            <div class="row">
                <div class="col-md-12">

                    <table class="table table-bordered table-responsive" id="myTable"      style="display:none;"> 
                        <tr> 
                            <input type="hidden" id="subjectName" name="subject_name" value="<?php ?>">     
                        </tr> 
                        <tr> 
                            <th>NO</th>
                            <th>QUESTIONS</th>
                            <th>RATING</th>
                        </tr> 
                            <?php 
                                $quecnt = 0;
                                foreach($stud_rating as $data){  
                                $quecnt = $quecnt + 1;
                               ?>  
                        <tr class="whole_table"> 
                            <td class="que_dis_num"><h4><?php echo $data->que_display_number; ?> </h4> 
                                <input type="hidden" id="frmqueno<?php echo $data->que_ID;?>" value="<?php echo $data->que_display_number;?>">            
                            </td>
                            <td class="que_width"><h4><?php echo $data->que_question; ?>    </h4>                                
                                <input type="hidden" id="frmque<?php echo $data->que_ID;?>" value="<?php echo $data->que_question;?>">
                                    
                            </td> 
                            <td class="rating_width" <?php 
                                if ($data->que_ID == '3'   ||  $data->que_ID == '9')
                                    { 
                                        echo 'style="display:none;"'; 
                                    } 
                            ?>> 
                                <?php  
                                    if($data->que_ID) {
                              
                                ?>
     
                            <fieldset class="rating" id="row-<?php echo $data->que_ID;?>">  

                                <input type="hidden" id="que_ID"  name="que_ID" value="<?php echo $data->que_ID;?>" /> 

                                <input type="text"  id="star1" name="que_ID1" value="1"/ required>
                                <label class="str" id = "i5-<?php echo $data->que_ID;?>" u_data="5" data-id="<?php echo $data->que_question;?>-<?php echo $data->que_display_number;?>" for="star1" title="Excellent"></label>

                                <input type="hidden" id="star2" name="rating" value="2" / required>
                                <label class="str" id = "i4-<?php echo $data->que_ID;?>" u_data="4" for="star2" title="Very Good" data-id="<?php echo $data->que_question;?>-<?php echo $data->que_display_number;?>"></label> 
     
                                <input type="hidden" id="star3" name="rating" value="3" / required>
                                <label class="str" id = "i3-<?php echo $data->que_ID;?>" u_data="3" for="star3" title="Good" data-id="<?php echo $data->que_question;?>-<?php echo $data->que_display_number;?>"></label>  
                                  
                                <input type="hidden" id="star4" name="rating" value="4" / required>
                                <label class="str" id = "i2-<?php echo $data->que_ID;?>" u_data="2" for="star4" title="Poor" data-id="<?php echo $data->que_question;?>-<?php echo $data->que_display_number;?>"></label>   
                                  
                                <input type="hidden" id="star5" name="rating" value="5" / required>
                                <label class="str" id = "i1-<?php echo $data->que_ID;?>" u_data="1" for="star5" title="Very Poor" data-id="<?php echo $data->que_question;?>-<?php echo $data->que_display_number;?>"></label> 
                                  
     
                            </fieldset> 
                              
                              
                            <input type="hidden" id="frm<?php echo $data->que_ID;?>" name="frm<?php echo $data->que_ID;?>" value="" >
     
                              <?php } ?>

                            </td>  
                        </tr> 
                                  
                                <?php }?>  
                        <tr>
                            <td colspan="3">
                                <div class="form-group textComment">  
                                    <textarea type="text" class="form-control" id="textArea"  name="textArea" placeholder="Enter Your Comment"></textarea> 
                                </div>   
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="modal-footer">
                                
                                    <input type="hidden" id="frmquecnt" name="frmquecnt" value="<?php echo $quecnt;?>" >
                                
                                    <input type="submit" name="submit" id="subFeddback" value="submit" class="btn btn-success" onclick="Submit_data()" /> 
                                </div>
                            </td>
                        </tr>
                         
                    </table> 

                         <br/><br/> 
                </div>
            </div> 
        </form>
               <!--  </div>  
            </div> --> 
  
                    <?php  
                        $this->load->view('footer'); 
                    ?>
  
</div> 


<script type="text/javascript">

    $(document).ready(function(){
        $("#div123").hide();
        $("#div_check_manual1_cancle").hide();
        $('#que_is_sub').change(function(){
            var tID = $("#que_is_sub").val(); 
            var teaID   = tID.split('~')[1];
            var subName = tID.split('~')[0];
            var subCode = tID.split('~')[2];
            var semID   = tID.split('~')[4]; 

                document.getElementById("sub_name_m").value=subName;
                document.getElementById("sub_code_m").value=subCode;
                document.getElementById("sem_mutual").value=semID;
                $.ajax({ 
                        url:"<?php echo base_url();?>/Aictefeed/getTeacherID",
                        method:"POST", 
                        data:{teacID:teaID}, 
                        success:function(data)

                        {
                        // alert(data);
                            if(data != '')
                            {
                                
                                $("#showTeacherName").html(data).show();
                                $("#myTable").show();
                              
                            }else {
                              
                                $("#myTable").hide();
                                $("#showTeacherName").hide();
                                
                            } 

                        }
                 
                    });  
    });


    $('#sub_code_m').click(function(){
        var tID = $("#que_is_sub").val();              
        var teaID   = document.getElementById("que_is_teacher").value;                
        $.ajax({ 
                url:"<?php echo base_url();?>/Aictefeed/getTeacherID",
                method:"POST", 
                data:{teacID:teaID}, 
                    success:function(data)
                    {
                                                   
                        if(data != '')
                        {
                                                              
                            $("#showTeacherName").html(data).show();
                            $("#myTable").show();
                                                           
                        }else 
                        {
                                                          
                            $("#myTable").hide();
                            $("#showTeacherName").hide();
                                                            
                        } 
                    }
                                               
                });  
          
            });
            
            $( ".str" ).click(function() {  
                  
                if($("#que_is_sub").val() == ' ')
                    {
                              $("#error").html("<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Please Choose Subject And Get The Points!</div>");
                              
                    }
                else{
                  
                     $("#error").hide();

                      var id = this.id;
                           
                      var queId = id.split('-')[1];   //queId = 14 
                      var strid = id.split('-')[0];
                      var quePoits = strid.substr(1, 2);   //que points
                        // alert(queId);
                        // alert(quePoits);
                                  
                       $("#row-"+queId+" .str").removeClass("highlight"); 

                        for (i = 0; i <= quePoits; i++  ){
                             $("#row-"+queId+" #i"+i+"-"+queId).toggleClass( "highlight" );  
                        }
              
                        document.getElementById("frm"+queId).value = quePoits;
           
                    }
                  
              });    
          
          });            
          var insertCnt=0;
        
            function insert_data(queId,quePoints,question,queNo,subName,teaID,subCode,divID,semID,braID,deptID,courLevel,acdYear,is_manual,stu_class,stu_div)
               { 
                  $('#tbl_form').submit(function(e){   
                  e.preventDefault(); 
                    
                   var textArea  =  $("#textArea").val();  
                   $("#myTable").hide();
                   $("#showTeacherName").hide();
                   $("#div123").hide();
                      $.ajax({ 
                             
                         url:'<?php echo base_url();?>Aictefeed/save',
                         type:"POST",
 
                         data:       {queId:queId,que_points:quePoints,question:question,que_number:queNo,subName:subName,teaID:teaID,subCode:subCode,divID:divID,semID:semID,braID:braID,deptID:deptID,courLevel:courLevel,acdYear:acdYear,textArea:textArea,is_manual:is_manual,stu_class:stu_class},
   
                                success: function(data){
                                           
                                              // alert(data);
                                              insertCnt++;
                                              console.log(insertCnt);
                                            //   console.log(data);
                                              $("#success").html(data);
                                              //$('form').unbind("submit").submit(); 
                                              $("#error").hide();
                                              $('#tbl_form')[0].reset();  
                                              $("#row-"+queId+" .str").removeClass("highlight"); 
                                              $('#showTeacherName').hide();
                                            location.reload(false); 
                                    // alert("Question Feedback Points Inserted Successfully");
                                            return insertCnt;
                            
                                }
                            }); 
                           return false;
 
                        }); 
        
                   }
          
        
                  
        function Submit_data() {
            var loopCnt=0;
            var quecnt = document.getElementById("frmquecnt").value;
            var stu_sub   =  document.getElementById("que_is_sub").value;
            var check_manual = document.getElementById("check_manual1").value;
            var is_manual_flag = document.getElementById("set_value_manual").value;
            var acdYear = document.getElementById("acadmic_year1").value;
            var teaID   = document.getElementById("que_is_teacher").value;
            if(teaID==" "){
              // alert("Select Teacher !!")
                return false;
            }
            if(is_manual_flag==1)
            {
               var subName = document.getElementById("sub_name_m").value;
               var subCode = document.getElementById("sub_code_m").value;
              //var teaID   = stu_sub.split('~')[1];
               var semID = document.getElementById("sem_mutual").value;
               var braID = document.getElementById("branch_mutual").value;
               var deptID = document.getElementById("dept_mutual").value;
               var is_manual=1;
               var courLevel = document.getElementById("courselevel_mutual").value;
               var stu_class = document.getElementById("class_mutual").value;
               var divID = document.getElementById("div_mutual").value;
                for( ni=1; ni <= quecnt; ni++) {
                    var queId = ni;
                    var quePoints = document.getElementById("frm"+ni).value;
                    var queNo = document.getElementById("frmqueno"+ni).value;
                    var question = document.getElementById("frmque"+ni).value;
                
                    if ( quePoints == "") {}
                    else{ 
                        loopCnt++;
                        console.log(loopCnt);
                        insert_data(queId,quePoints,question,queNo,subName,teaID,subCode,divID,semID,braID,deptID,courLevel,acdYear,is_manual,stu_class);
                    }
                    
                }
             
            }
            else if(stu_sub!=0)
            {
            var subName = stu_sub.split('~')[0];
          //  var teaID   = stu_sub.split('~')[1];
            var subCode     = stu_sub.split('~')[2];
            var divID       = stu_sub.split('~')[3]; 
            var semID       = stu_sub.split('~')[4]; 
            var braID       = stu_sub.split('~')[5];
            var deptID      = stu_sub.split('~')[6]; 
            var courLevel   = stu_sub.split('~')[7]; 
            // var acdYear     = stu_sub.split('~')[8];
             if(acdYear=='')
            {
              var acdYear     = document.getElementById("acadmic_year1").value;
            }
            if(semID=='')
            {
                alert('please insert semester');
            }
            else{
            //alert(courLevel);
            var stu_class=stu_sub.split('~')[9];
            var is_manual=0;

             for( ni=1; ni <= quecnt; ni++) {
            
                var queId = ni;
                var quePoints = document.getElementById("frm"+ni).value;
                var queNo = document.getElementById("frmqueno"+ni).value;
                var question = document.getElementById("frmque"+ni).value;
              
                 //var question = $(".que_width").val();
                //alert(queId + " - " + queno + " - " + question + " - " + quePoints);
                if ( quePoints == "") {
                    
                } else {
                    
                    loopCnt++;

                    insert_data(queId,quePoints,question,queNo,subName,teaID,subCode,divID,semID,braID,deptID,courLevel,acdYear,is_manual,stu_class);
                }
                
            }

            }
            if(loopCnt>0){
                     alert("Question Feedback Points Inserted Successfully");   
                }
            }
        }
        
</script>
<script type="text/javascript">
        function doConfirm()
        {
            var flag = '<?php echo $flag; ?>';
            if(flag==0)
            {
             alert("Contact HOD, Principal or AICTE 360 administrator to add your teachers");
            }
            
        }
     
</script>

<script type="text/javascript">  
$(document).ready(function(){
        $('#que_is_teacher').change(function(){
            var teach_id = $('#que_is_teacher').val();
            var acadmic_year1 = $('#acadmic_year1').val();
                if(teach_id != '')
                {
                $.ajax({
                url:"<?php echo base_url(); ?>Aictefeed/show_perticular_subject_teacher",
                method:"POST",
                data:{teach_id:teach_id,acadmic_year1:acadmic_year1},
                        success:function(data)
                        {
                        //alert(data);
                        $('#que_is_sub').html(data); 
                        // $('#state').append(data);
                        }
                    });
                }
                else
                  {
                    $('#que_is_sub').html('<option value="">Select Subject</option>');
                  }
    });
    $('#acadmic_year1').change(function(){
        var teach_id = $('#que_is_teacher').val();
        var acadmic_year1 = $('#acadmic_year1').val();
            if(teach_id != '')
            {
                $.ajax({
                url:"<?php echo base_url(); ?>Aictefeed/show_perticular_subject_teacher",
                method:"POST",
                data:{teach_id:teach_id,acadmic_year1:acadmic_year1},
                    success:function(data)
                    {
                        // alert(data);
                        $('#que_is_sub').html(data); 
                        // $('#state').append(data);
                    }
                });
            }
            else
            {
                $('#que_is_sub').html('<option value="">Select Subject</option>');
            }
    });

    $("#check_manual1").click(function(){
          $("#que_is_sub")[0].selectedIndex = 0;

          $("#div123").show();
          var val=1;
          document.getElementById("set_value_manual").value=val;
          $("#div_check_manual1_cancle").show();
           $("#div_check_manual1_add").hide();

   });
    $("#check_manual1_cancle").click(function(){
        
        var val=0;
        document.getElementById("set_value_manual").value=val;
         $("#que_is_sub")[0].selectedIndex = 0;
                   document.getElementById("sub_name_m").value='';
                   document.getElementById("sub_code_m").value='';
                   document.getElementById("que_is_teacher").value='';
                   document.getElementById("sem_mutual").value='';
                   document.getElementById("branch_mutual").value='';
                   document.getElementById("dept_mutual").value='';
                   document.getElementById("acadmic_year1").value='';
                   document.getElementById("courselevel_mutual").value='';
                   document.getElementById("class_mutual").value='';
                   document.getElementById("div_mutual").value='';
        //$("#div_check_manual1_cancle").show();        
        $("#div123").hide();
        $("#div_check_manual1_cancle").hide();
        $("#div_check_manual1_add").show();
    });

    $("#que_is_sub").click(function(){
          var val=0;
          document.getElementById("set_value_manual").value=val;
    });

});
</script>
</body>
</html>

