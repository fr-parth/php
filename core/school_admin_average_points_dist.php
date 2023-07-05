<?php
include("scadmin_header.php");
error_reporting(0);

?>

<?php  
//print_r($_COOKIE); ?> 

 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  id="blockTP">
        <div class="container">
 
            <div class="block-header1" align='center'>
                <h2>School Admin Average Points Distributions</h2>
            </div>
				<head> 
 
            <style type="text/css">
                
 
            
                .form_fee{
                            padding: 20px;
                            background-color: #3c9d9d; 
                            width: 600px;
                            border-radius: 5px;
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
                
                .alert-info {
                    background-color: #06202cde !important;
                }
                
                .modal-footer {
                    padding: 15px;
                    text-align: right;
                    border-top: none !important;
                }
                
                .form-group .form-control {
                    width: 100%;
                    border: 1 px solid gray !important;
                    box-shadow: none;
                    -webkit-border-radius: 0;
                    -moz-border-radius: 0;
                    -ms-border-radius: 0;
                    border-radius: 5px;
                    padding-left: 0;
                }
                
                .block-header1 h2{
                    margin-bottom: 15px;
                    color: #fff;
                    background-color: #526f9a;
                    color: #fff;
                    padding: 10px !important;
                    font-size: 26px;
                    font-weight: normal;
                }
                
                .table-bordered thead tr th {
                    padding: 10px;
                    border: 1px solid #ddd;
                    background: #d8cf63;
                    color: #fff !important;
                    text-align: center !important;
                    color: black !important;
                }
                
               #user_image {
                   
                    padding: 64px; 
                }
                
                 #user_image img {
                    
                    margin-right: 10px;
                }
                
                .cImg{
                    margin-right: 10px;
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
                
               .form-group .form-control {
                    
                    padding: 20px !important;
                }
                
                .well-sm {
                    padding: 9px;
                    border-radius: 3px;
                    height: 2405px !important;
                }
                
                @media (min-width: 768px){
                        .form-horizontal .control-label {
                        text-align: left !important;  
                    }
                }
                
                .form-horizontal .control-label, .form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
                        padding-top: 11px !important;
                        margin-top: 0;
                        margin-bottom: 0;
                    }
                
                
                @media (min-width: 768px){
                    .col-sm-1 {
                        width: 8.333333333333332%;
                        margin-top: 10px;
                    }
                }
                
                legend {
                    display: block;
                    width: 100%;
                    padding: 10px !important;
                    margin-bottom: 20px;
                    font-size: 21px;
                    line-height: inherit;
                    color: #333;
                    background-color: #ffb100 !important;
                    border: 0;
                    border-bottom: 1px solid #e5e5e5;
                }
                
                
            </style>
            
				</head>
          
              
  
            <div id="live_data"></div>
            
 
        
<br/> <br/>  
            <script>
            $(document).ready(function(){
                
                  $('input').keypress(function( event ) {
                    if(event.which === 32) 
                        return false;
                });
 
                
                $(document).on('keyup', function(){
                   
                    var stuToTeaInputPoints = $("#StudDecPoi").val();
                    $("#stuToTeacherInputPoints").html("Student To Teacher Points(Annualy[Blue]) = " + stuToTeaInputPoints);
                    var teaToStuInputPoints = $("#TeaDecPoi").val();
                    $("#teaToStudentInputPoints").html("Teacher To Student Points(Annualy[Green]) = " + teaToStuInputPoints);
                    
                    var stuCot = $("#Student").val();
                    $("#stuCount").html("Total no of student = " + stuCot);
                    
                    var claCot = $("#Class").val();
                    $("#claCount").html("Total no of classes = " + claCot);
                    
                    var stuPerCla = stuCot/claCot;
                    
                    var stuCountcla = Math.round(isNaN(stuPerCla) ? '0.00' : stuPerCla);  
                    $("#stuPerCla").html("Student per class = " + stuCountcla);
                    
                    var totSubPerClass = $("#Student_Subject").val(); 
                    $("#perClaSub").html("Total no of student subject = " +  totSubPerClass);
                    
                    var totSubClass = Math.round(stuCountcla * totSubPerClass);
                    var stuCountclass = Math.round(isNaN(totSubClass) ? '0.00' : totSubClass);  
                    $("#totSubInCla").html("Total no of subject per class = " +  stuCountclass);
                    
                    
                    var TotAssPotToSchForTeaToSt = Math.round(stuCot * stuToTeaInputPoints);
                    var TotAssPotToSchForTeaToStudent = Math.round(isNaN(TotAssPotToSchForTeaToSt) ? '0.00' : TotAssPotToSchForTeaToSt);  
                    $("#TotAssPotToSchForTeaToStu").html("Total assign points to school for teacher to student(green) = " +  TotAssPotToSchForTeaToStudent);
                    
                    var noOfteacher = $("#Teacher").val();
                    $("#noOfteacher").html("Total no of teacher = " + noOfteacher);
                    
                    var noOfTeacherPerClass =  Math.round(noOfteacher / claCot);
                    var noOfTeacherPerClas = Math.round(isNaN(noOfTeacherPerClass) ? '0.00' : noOfTeacherPerClass);
                    $("#noOfTeacherPerCla").html("No of teacher per class = " + noOfTeacherPerClas);
                    
                    var noOfStuForSingTeacher =  Math.round(stuCountcla / noOfTeacherPerClass);
                    var noOfStuForSingTeach = Math.round(isNaN(noOfStuForSingTeacher) ? '0.00' : noOfStuForSingTeacher);
                    $("#noOfStuForSingTea").html("No of student per teacher = " + noOfStuForSingTeach);
                    
                    
                    var perTeaAssPoints =  Math.round(TotAssPotToSchForTeaToStudent / noOfteacher); 
                    var perTeaAssPoi = Math.round(isNaN(perTeaAssPoints) ? '0.00' : perTeaAssPoints);   
                    $("#perTeaAssPointsFmSchool").html("Per teacher assign points from school = " + perTeaAssPoi);
                    
                    
                    var perStuAssPintsFmTeacher =  Math.round(perTeaAssPoi / noOfStuForSingTeach);
                    var perStuAssPintsFmTeac = Math.round(isNaN(perStuAssPintsFmTeacher) ? '0.00' : perStuAssPintsFmTeacher);
                    $("#annAssPointsToTeacher").html("Per student assign points from teacher(green) = " + perStuAssPintsFmTeac);
                    
                    
                   
//                    var stuCot = $("#StudDecPoi").val();
//                    // alert(stuCot);
//                   
//                    var stuCot = $("#Student").val();
//                    $("#stuCount").html("Total no of student = " + stuCot);
//                    
//                    var claCot = $("#Class").val();
//                    $("#claCount").html("Total no of classes = " + claCot);
//                    
//                    var stuPerCla = stuCot/claCot;
//                    
//                    var stuCountcla = Math.round(isNaN(stuPerCla) ? '0.00' : stuPerCla);  
//                    
//                    $("#stuPerCla").html("Student per class = " + stuCountcla);
//                    
//                    var totSubPerClass = $("#Student_Subject").val();
//                    
//                    $("#perClaSub").html("Total no of student subject = " +  totSubPerClass);
//                    
//                    var totSubClass = Math.round(stuCountcla * totSubPerClass);
//                    
//                    $("#totSubInCla").html("Total no of subject studentwise per class = " +  totSubClass);
//                    
//                    var basePointsForTeacher = 7;
//                    
//                    $("#basePoiToteacher").html("Base points to teacher = " +  basePointsForTeacher);
//                    
//                    var yearWeek = 52;
//                     
//                    var month = 12;
//                    
//                    $("#yearWeek").html("Yearly week = " +  yearWeek);
//                    
//                    var conToasPontToStudent = Math.round(yearWeek * basePointsForTeacher);
//                    
//                    $("#conToassPntToStu").html("Consider to assign weekly points to student = " +  conToasPontToStudent);
//                    
//                    
//                    var tacherAnuualPointFrmSchool = Math.round(claCot * totSubClass); 
//                    
//                    var tacherAnuualPointFrmSc = Math.round(tacherAnuualPointFrmSchool * conToasPontToStudent);
//                    
//                    var tacherAnuualPointFrmSchl = Math.round(isNaN(tacherAnuualPointFrmSc) ? '0.00' : tacherAnuualPointFrmSc);  
//                    
//                    $("#sclassPoinToTeaAnnually").html("Total reward points to school(green) = " +  tacherAnuualPointFrmSchl);
//                    
//                    
//                    var noOfteacher = $("#Teacher").val();
//                    $("#noOfteacher").html("Total no of teacher = " + noOfteacher);
//                    
//                    
//                    var teacherNoSub = $("#Teacher_Subject").val();
//                    $("#noOfteacherSub").html("Teacher no of subjects = " + teacherNoSub);
//                    
//                    var perTeaAssPoints =  Math.round(tacherAnuualPointFrmSchl / noOfteacher);
//                    
//                    var perTeaAssPoi = Math.round(isNaN(perTeaAssPoints) ? '0.00' : perTeaAssPoints);  
//                    
//                    $("#perTeaAssPointsFmSchool").html("Per teacher assign points from school = " + perTeaAssPoi);
//                    
//                    
//                    var noOfTeacherPerClass =  Math.round(noOfteacher / claCot);
//                    var noOfTeacherPerClas = Math.round(isNaN(noOfTeacherPerClass) ? '0.00' : noOfTeacherPerClass);
//                    $("#noOfTeacherPerCla").html("No of teacher per class = " + noOfTeacherPerClas);
//                    
//                    var noOfStuForSingTeacher =  Math.round(stuCountcla / noOfTeacherPerClass);
//                    var noOfStuForSingTeach = Math.round(isNaN(noOfStuForSingTeacher) ? '0.00' : noOfStuForSingTeacher);
//                    $("#noOfStuForSingTea").html("No of student per teacher = " + noOfStuForSingTeach);
//                    
//                    
//                    var perStuAssPintsFmTeacher =  Math.round(perTeaAssPoi / noOfStuForSingTeacher);
//                    var perStuAssPintsFmTeac = Math.round(isNaN(perStuAssPintsFmTeacher) ? '0.00' : perStuAssPintsFmTeacher);
//                    $("#annAssPointsToTeacher").html("Per student assign points from teacher(green) = " + perStuAssPintsFmTeac);
//                    
//                    var monAssPointsToTeache =  Math.round(perStuAssPintsFmTeacher / teacherNoSub);
//                    var monAssPointsToTea = Math.round(isNaN(monAssPointsToTeache) ? '0.00' : monAssPointsToTeache);
//                    $("#monAssPointsToTeacherSub").html("assign points to student from teacher subject = " + monAssPointsToTea); 
//                    
//                    
//                    var monAssPointsToTeach =  Math.round(monAssPointsToTeache / month);
//                    var monAssPointsToTea = Math.round(isNaN(monAssPointsToTeach) ? '0.00' : monAssPointsToTeach);
//                    $("#monAssPointsToTeacher").html("assign points to student from teacher monthly(green) = " + monAssPointsToTea);
//                    
//                    var weekAssPointsToTea =  Math.round(monAssPointsToTeache / yearWeek);
//                    var weekAssPointsToTeachers = Math.round(isNaN(weekAssPointsToTea) ? '0.00' : weekAssPointsToTea);
//                    $("#weekAssPointsToTeacher").html("assign points to student from teacher weekly(green) = " + weekAssPointsToTeachers);
                     
                });
                
                
                 
    });
            
            </script>
            
            
         
 
 
 
    <div class="container">
    <div class="row">
        <div class="well-sm col-md-12">
           
            <div class="well well-sm col-md-6">

                <?php

             if( $_GET['status'] == 'success'):
                ?><h4 id="m1">All data Stored Successfully.</h4><?php
    //echo 'All data Stored Successfully.';
endif;

                ?>

                <script type="text/javascript">
                    
                    function FadeToZero()
{
    $("#m1").children().delay(5000).fadeIn(800);    
}
                </script>
<!--                //method="post" enctype="multipart/form-data"-->
                <form class="form-horizontal" id="user_form" method="post" action="school_admin_dist_points_insert_data.php"  enctype="multipart/form-data">
                    <fieldset>
                      <legend class="text-center header">Add List Of School Details</legend> 
                      
                         <div class="form-group">
                             <div class="col-sm-1"></div><label class="control-label col-sm-4" for="semester">Student To Teacher Points(Annualy[Blue]):</label> 
                            <div class="col-md-5"> 
                                <input id="StudDecPoi" name="StudDecPoi" type="number" placeholder="" class="form-control intPad" required>
                            </div> 
                         </div> 
                        
                         <div class="form-group">
                             <div class="col-sm-1"></div><label class="control-label col-sm-4" for="semester">Teacher To Student Points(Annualy[Green]):</label> 
                            <div class="col-md-5"> 
                                <input id="TeaDecPoi" name="TeaDecPoi" type="number" placeholder="" class="form-control intPad" required>
                            </div> 
                         </div>  
                        
                         <div class="form-group">
                             <div class="col-sm-1">1.</div><label class="control-label col-sm-4" for="semester">No of Student:</label> 
                            <div class="col-md-5"> 
                                <input id="Student" name="Student" type="number" placeholder="" class="form-control intPad" required>
                            </div> 
                         </div> 
                        <div class="form-group">
                            <div class="col-sm-1">2.</div><label class="control-label col-sm-4" for="semester">No of Class:</label> 
                            <div class="col-md-5">
                                <input id="Class" name="Class" type="number" placeholder="" class="form-control intPad" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1">3.</div><label class="control-label col-sm-4" for="semester">No of Student Subject:</label> 
                            <div class="col-md-5">
                                <input id="Student_Subject" name="Student_Subject" type="number" placeholder="" class="form-control intPad" required>
                            </div>
                        </div>
                         <div class="form-group">  
                            <div class="col-sm-1">4.</div><label class="control-label col-sm-4" for="semester">No of Teacher:</label>
                            <div class="col-sm-5">  
                                  <input id="Teacher" name="Teacher" type="number" placeholder="" alt="numbers only" class="form-control intPad" required>
                             </div>
                         </div> 
                          <div class="form-group">
                            <div class="col-sm-1">5.</div><label class="control-label col-sm-4" for="semester">No of Teacher Subject:</label> 
                            <div class="col-md-5">
                                <input id="Teacher_Subject" name="Teacher_Subject" type="number" placeholder="" class="form-control intPad" required>
                            </div>
                         </div>
                        
                         <div class="form-group">
                          <div class="col-sm-1">6.</div><label class="control-label col-sm-4" for="semester">No of Student Semester:</label> 
                            <div class="col-md-5">
                                <input id="Student_Semester" name="Student_Semester" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                         <div class="form-group">
                          <div class="col-sm-1">7.</div><label class="control-label col-sm-4" for="semester">No of Student Activity:</label> 
                            <div class="col-md-5">
                                <input id="Student_Activity" name="Student_Activity" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                         
                        <div class="form-group">
                           <div class="col-sm-1">8.</div><label class="control-label col-sm-4" for="semester">No of School Subject:</label> 
                            <div class="col-md-5">
                                <input id="School_Subject" name="School_Subject" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-sm-1">9.</div><label class="control-label col-sm-4" for="semester">No of Academic Year:</label> 
                            <div class="col-md-5">
                                <input id="Academic_Year" name="Academic_Year" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 
                        

                        <div class="form-group">
                           <div class="col-sm-1">10.</div><label class="control-label col-sm-4" for="semester">No of Course Level:</label> 
                            <div class="col-md-5">
                                <input id="Course_Level" name="Course_Level" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-sm-1">11.</div><label class="control-label col-sm-4" for="semester">No of Degree:</label> 
                            <div class="col-md-5">
                                <input id="Degree" name="Degree" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-sm-1">12.</div><label class="control-label col-sm-4" for="semester">No of Department:</label> 
                            <div class="col-md-5">
                                <input id="Department" name="Department" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-sm-1">13.</div><label class="control-label col-sm-4" for="semester">No of Branch:</label> 
                            <div class="col-md-5">
                                <input id="Branch" name="Branch" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>  
                        
                        
                        <div class="form-group">
                          <div class="col-sm-1">14.</div><label class="control-label col-sm-4" for="semester">No of Division:</label> 
                            <div class="col-md-5">
                                <input id="Division" name="Division" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 
                        
                          <div class="form-group">
                           <div class="col-sm-1">15.</div><label class="control-label col-sm-4" for="semester">No of Semester:</label> 
                            <div class="col-md-5">
                                <input id="Semester" name="Semester" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                       
                        <div class="form-group">
                           <div class="col-sm-1">16.</div><label class="control-label col-sm-4" for="semester">No of Branch Subject Div Year:</label> 
                            <div class="col-md-5">
                                <input id="Branch_Subject_Div_Year" name="Branch_Subject_Div_Year" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>  
                        
                        <div class="form-group">
                           <div class="col-sm-1">17.</div><label class="control-label col-sm-4" for="semester">No of School recognization level:</label> 
                            <div class="col-md-5">
                                <input id="School_recognization_level" name="School_recognization_level" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 
                        
                        
                          <div class="form-group">
                         <div class="col-sm-1">18.</div><label class="control-label col-sm-4" for="semester">No of Diploma Programs:</label> 
                            <div class="col-md-5">
                                <input id="Diploma_Programs" name="Diploma_Programs" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-sm-1">19.</div><label class="control-label col-sm-4" for="semester">No of Certificate Programs:</label> 
                            <div class="col-md-5">
                                <input id="Certificate_Programs" name="Certificate_Programs" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>  
                         
                        <div class="form-group">
                          <div class="col-sm-1">20.</div><label class="control-label col-sm-4" for="semester">No of School Activities:</label> 
                            <div class="col-md-5">
                                <input id="School_Activities" name="School_Activities" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 
                        
                          <div class="form-group">
                          <div class="col-sm-1">21.</div><label class="control-label col-sm-4" for="semester">No of Non Teaching Staff:</label> 
                            <div class="col-md-5">
                                <input id="Non_Teaching_Staff" name="Non_Teaching_Staff" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>

                       
                        <div class="form-group">
                         <div class="col-sm-1">22.</div><label class="control-label col-sm-4" for="semester">No of Suppliers:</label> 
                            <div class="col-md-5">
                                <input id="Suppliers" name="Suppliers" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 

                        <div class="form-group">
                          <div class="col-sm-1">23.</div><label class="control-label col-sm-4" for="semester">No of Internship Programs:</label> 
                            <div class="col-md-5">
                                <input id="Internship_Programs" name="Internship_Programs" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>  
                        
                        <div class="form-group">
                           <div class="col-sm-1">24.</div><label class="control-label col-sm-4" for="semester">No of International Mentors:</label> 
                            <div class="col-md-5">
                                <input id="International_Mentors" name="International_Mentors" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-1">25.</div><label class="control-label col-sm-4" for="semester">No of Sponsors in City:</label> 
                            <div class="col-md-5">
                                <input id="Sponsors_in_City" name="Sponsors_in_City" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                         
                        <div class="form-group">
                         <div class="col-sm-1">26.</div><label class="control-label col-sm-4" for="semester">No of Awards Received by University:</label> 
                            <div class="col-md-5">
                                <input id="Awards_Received_by_University" name="Awards_Received_by_University" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 

                        <div class="form-group">
                          <div class="col-sm-1">27.</div><label class="control-label col-sm-4" for="semester">No of Paper Published by Teachers:</label> 
                            <div class="col-md-5">
                                <input id="Paper_Published_by_Teachers" name="Paper_Published_by_Teachers" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>   
                        
                        <div class="form-group">
                         <div class="col-sm-1">28.</div><label class="control-label col-sm-4" for="semester">No of Paper Published by Students:</label> 
                            <div class="col-md-5">
                                <input id="Paper_Published_by_Students" name="Paper_Published_by_Students" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1">29.</div><label class="control-label col-sm-4" for="semester">No of Meet Ups Conducted:</label> 
                            <div class="col-md-5">
                                <input id="Meet_Ups_Conducted" name="Meet_Ups_Conducted" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 

                           <div class="form-group">
                          <div class="col-sm-1">30.</div><label class="control-label col-sm-4" for="semester">No of Cutting Edge Subjects:</label> 
                            <div class="col-md-5">
                                <input id="Cutting_Edge_Subjects" name="Cutting_Edge_Subjects" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 

                        <div class="form-group">
                           <div class="col-sm-1">31.</div><label class="control-label col-sm-4" for="semester">No of Scholar ships Given:</label> 
                            <div class="col-md-5">
                                <input id="Scholar_ships_Given" name="Scholar_ships_Given" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>  
                        
                        <div class="form-group">
                           <div class="col-sm-1">32.</div><label class="control-label col-sm-4" for="semester">No of Girls to Boys Ratio:</label>  
                            <div class="col-md-5">
                                <input id="Girls_to_Boys_Ratio" name="Girls_to_Boys_Ratio" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-sm-1">33.</div><label class="control-label col-sm-4" for="semester">No of Participation In Sister Sites:</label> 
                            <div class="col-md-5">
                                <input id="Participation_In_Sister_Sites" name="Participation_In_Sister_Sites" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 
                        
                          <div class="form-group">
                           <div class="col-sm-1">34.</div><label class="control-label col-sm-4" for="semester">No of PTA Ratio:</label> 
                            <div class="col-md-5">
                                <input id="PTA_Ratio" name="PTA_Ratio" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div> 

                        <div class="form-group">
                          <div class="col-sm-1">35.</div><label class="control-label col-sm-4" for="semester">Left and Right Brain Usage Acc To subjects and activities:</label> 
                            <div class="col-md-5">
                                <input id="Left_and_Right_Brain_Usage_Acc_To_subjects_and_activities" name="Left_and_Right_Brain_Usage_Acc_To_subjects_and_activities" type="number" placeholder="" class="form-control intPad">
                            </div>
                        </div>   
                        
                        <div class="form-group">
                            <div class="col-md-12 text-center">
<!--                                <button type="submit" id="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>-->
                                 <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" />
                            </div>
                        </div> 
                        
                    </fieldset> 
                    
                </form>
            </div>
            <div class="well well-sm  col-md-6">
                 <legend class="text-center header">Calculations Of School Admin Average Points</legend> 
                <div class="">
                    
                     <p id="stuToTeacherInputPoints" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Student to teacher annual points(Blue)</p>
                     <p id="teaToStudentInputPoints" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Teacher to student annual points(Green)</p>
                    
                     <p id="stuCount" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of student</p>
                     <p id="claCount" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of classes</p>
                     <p id="stuPerCla" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Student per class</p> 
                     <p id="perClaSub" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of student subject</p> 
                     <p id="totSubInCla" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of subject per class</p>
                    
                     <p id="TotAssPotToSchForTeaToStu" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total assign points to school for teacher to student(green)</p>
                    
                      <p id="noOfteacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of teacher</p>
                      <p id="noOfTeacherPerCla" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">No of teacher per class</p>
                      <p id="noOfStuForSingTea" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">No of student per teacher</p>
                      <p id="perTeaAssPointsFmSchool" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Per teacher assign points from school</p>
                      <p id="annAssPointsToTeacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Per student assign points from teacher(green)</p>
                     <!--
                     <p id="basePoiToteacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Base points to teacher</p>
                     <p id="yearWeek" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Yearly week</p>
                     <p id="conToassPntToStu" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Consider to assign weekly points to student</p>
                     <p id="sclassPoinToTeaAnnually" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total reward points to school(green)</p>
                    
                     
                     <p id="noOfteacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Total no of teacher</p>
                     <p id="noOfteacherSub" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Teacher no of subjects</p>
                     <p id="perTeaAssPointsFmSchool" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Per teacher assign points from school</p>
                     <p id="noOfTeacherPerCla" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">No of teacher per class</p>
                     <p id="noOfStuForSingTea" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">No of student for one teacher</p>
                    
                     <p id="annAssPointsToTeacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">Per student assign points from teacher(green)</p>
                    
                     <p id="monAssPointsToTeacherSub" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">assign points to student from teacher subject</p> 
                    
                     <p id="monAssPointsToTeacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">assign points to student from teacher monthly(green)</p>
                     <p id="weekAssPointsToTeacher" class="btn btn-success btn-lg" style="padding:10px;margin:10px;">assign points to student from teacher weekly(green)</p>
-->
                </div>
            
            </div>
        </div>
    </div>
</div>
       
             <div id="overlay" class="col-sm-offset-5">
                 <img src="<?php echo base_url()?>core/group_admin/image/loading.gif" class="Textcenter" alt="Loading" /> 
            </div>
             
             
		 
<br/><br/><br/> 
 

 