<?php
include('groupadminheader.php'); 
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<!--
 <link rel="stylesheet" href="../css/bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
  
<script src="../js/jquery-1.11.1.min.js"></script> 
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>    
    
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
-->

<!-- Latest compiled and minified JavaScript -->
<!--
<script src="../js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>    
<link href="../css/select2.min.css" rel="stylesheet" />
-->

  
    

   <style>

 .navbar-inverse .navbar-nav>.open>a .caret, .navbar-inverse .navbar-nav>.open>a:hover .caret, .navbar-inverse .navbar-nav>.open>a:focus .caret {
    border-top-color: #fff !important;
    border-bottom-color: #fff !important;
}
       
       .pagination {
        float: right !important;
        display: inline-block;
        padding-right: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
       
       .rowHeading{
           background-color: #ff9200;
       }
       
       .pagination>li>span:focus {
            background-color: #fe8f08d1 !important;
        }
   
       .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.428571429;
            text-decoration: none;
            background-color: #694489;
            border: 1px solid #ddd;
        }
       
       .selectPicker{ 
            
           margin-left: 12px;
           padding: 30px 0px 30px 0px; 
       }
       
       .bootstrap-select>.dropdown-toggle {
            position: relative;
            width: 100%;
            text-align: right;
            white-space: nowrap;
            display: -webkit-inline-box;
            display: -webkit-inline-flex;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
            background-color: #2a77df57;
            color: black !important;
        }
       
       .searchAreaALLsearch{
            position: relative;
            right: 15px;
       }
       
       .deptSelect{
           position: relative;
           top:30px;
       }
       div#load_screen{
            background: #000;
            opacity: 1;
            position: fixed;
            z-index:10;
            top: 0px;
            width: 100%;
            height: 1600px;
        }
        div#load_screen > div#loading{
            color:#FFF;
            width:120px;
            height:24px;
            margin: 300px auto;
        }
       
       .submitBtn{
           
               position: relative;
               float: right;
       }
       
       .Textcenter{
           
           text-align: center;
           
       }
       
      
       
       #overlay{
           
            position: fixed;
            bottom: 200px;
            right: 650px;
            width: 300px;
            
            
       }
       
       #overlay img {
           
           background: none !important;
       }
       

  </style>
</head>
<body>

   <div style="bgcolor:#CCCCCC"> 

  <?php
       
    $GroupMemId=$_SESSION['id']; 
  
  ?>     
         

<div class="" style="padding:30px;" > 

                    <div class="row">

                        <div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
 
                     </div>

                     <div class="col-md-10 " align="center" style="padding-left:300px;">

                          <h2 style="color:#0000FF">Institute Wise 360 Degree Feedback Summary</h2> 
                             
                     </div> 
                        
                        <a href="exportIndaicteSummaryReport.php"> <button type="text" name="export" id="export" class="btn btn-success" value="export">Export To Excel</button></a>
        
                     </div>
 
            <form id="submitData">
                 
                <div class="row">
                      <div class="col-md-4"> 
                                    <div class="deptSelect"> 
                                         <label for="department">Select Academic Year</label>
                                        <select id="academicYear" name="academicYear" class="form-control "> 

                                                <option value="all">All</option>

                                            <?php 

                                            //IF(dept_name IS NULL, 'N/A', dept_name) dept_name

                                             $sq = "SELECT DISTINCT IF(academic_year IS NULL, 'N/A', academic_year) academic_year

                                             FROM aicte_ind_feedback_summary_report WHERE group_member_id='$GroupMemId'  

                                             ";

                                               $IndFilter = mysql_query($sq); 

                                               while($raw = mysql_fetch_assoc($IndFilter))
                                                {  
                                            ?>  
                                                    <option value="<?php echo $raw['academic_year']?>"><?php echo $raw['academic_year']?></option>'; 


                                            <?php }  

                                            ?>
                                        </select> 

                                    </div>
                             </div> 
                             <div class="col-md-4"> 
                       
                                 <div class="selectPicker"> 
                                     <label for="institute">Select Institute</label>
                                    <select name="multi_search_filter" id="multi_search_filter"  class="form-control searchselect">
                                        <option value="all">All</option>
                                        
                                        <?php 
                                        
                                         $sq = "SELECT tsa.school_name,tsa.school_id,dm.Dept_Name 
                                          
                                         FROM tbl_school_admin tsa
                                         
                                         LEFT JOIN tbl_department_master dm ON 
                                          dm.School_ID = tsa.school_id  
                                         
                                         WHERE tsa.group_member_id='$GroupMemId'
                                         
                                         GROUP BY tsa.school_name
                                         
                                         ";

                                           $IndFilter = mysql_query($sq); 

                                           while($raw = mysql_fetch_assoc($IndFilter))
                                            {  
                                        
                                        ?>  
                                                <option value="<?php echo $raw['school_id']?>"><?php echo $raw['school_name']." (".$raw['school_id'].")";?></option>'; 
                                        
                                               
                                            
                                        <?php }

                                        ?>

                                    </select> 
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="deptSelect"> 
                                     <label for="department">Select Department</label>
                                    <select id="live_data1" name="dept_id" class="form-control "> 
                                        
                                            <option value="all">All</option>
                                        
                                        <?php 
                                        
                                        //IF(dept_name IS NULL, 'N/A', dept_name) dept_name
                                        

                                         /*$sq = "SELECT DISTINCT IF(dept_name IS NULL, 'N/A', dept_name) dept_name
                                          
                                         FROM aicte_ind_feedback_summary_report WHERE group_member_id='$GroupMemId' AND dept_name!='' 
                                       
                                         ";

                                           $IndFilter = mysql_query($sq); 

                                           while($raw = mysql_fetch_assoc($IndFilter))
                                            {  
                                        ?>  
                                                <option value="<?php echo $raw['dept_name']?>"><?php echo $raw['dept_name']?></option>'; 
                                         
                                            
                                        <?php } */ 

                                        ?>
                                    </select> 
          
                                </div>
                            </div> -->

                    
                </div>
                
                    <div class="submitBtn">
                        <input type="submit" name="submit" id="submit" value="Submit"  class="btn btn-primary" /> 
                    </div>
          </form> 
         
           
        </div>
     
    </div> 
 
  <br /><br />
                   <div id="live_data"> </div>     
             
    
<div id="overlay" class="col-sm-offset-5">
     <img src="image/loading.gif" class="Textcenter" alt="Loading" /> 
</div>
                      
  
</body>
</html>
    
    
    
     <script type="text/javascript"> 
        
        $(document).ready(function(){
             
      
            $("#overlay").hide();
          
            load_data(); 
             
            function load_data(schooID='',deptID='',acdYear='')
            {
                $.ajax({
                     url:"storeSchoolIDdeptName.php",
                     method:"POST",
                     data:{school_id:schooID,dept_name:deptID,academic_year:acdYear},
                     success:function(data)
                    {    
                        //alert(data);
                        //$('#live_data').html(data);
                    }
                });
                
                return false;
            }
            
           
            
            $("form").submit(function(){
                
                $("#overlay").show();
                
                 var schooID  = $("#multi_search_filter").val();
                 var deptID   = $("#live_data1").val();
                 var acdYear  = $("#academicYear").val();
             
                        var error = "";
                        var valerror = "";  

                        if($("#multi_search_filter").val() == "")
                            {
                                error += "<p>Select School Name</p>";
                            }
                       if($("#live_data1").val() == "")
                           {
                                error += "<p>Select Department Name</p>";
                           } 
                 

                        if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }else{
                               
                                 $.ajax({ 
                                     type:"POST",
                                     url:"fetchAllaicteReport.php",
                                     data:{school_id:schooID,dept_name:deptID,academic_year:acdYear},
                                     success:function(data)
                                     {   
                                         $("#live_data").html(data);
                                         
                                         load_data(schooID,deptID,acdYear);
                                          
                                         $("#overlay").hide();
                                     } 
                                 });
                                 
                                 
                            }
                return false;
 
            }); 
               
       
        });
        
           $(document).ready(function() {
                $('.searchselect').select2();
               
               
                    $("#multi_search_filter").on('change',function(){                         
            
                        var SchoolID = $("#multi_search_filter").val();
                        
                         $.ajax({
                             type: "POST",
                             url: "fetchDeptNameAgainstScoolID.php",
                             data: {SchoolID:SchoolID},
                            // dataType: "text",  
                             //cache:false,
                             success: 
                                  function(data){ 
                                      // alert(data); 
                                       $('#live_data1').html(data);  
                                  }
                              });  

                    });

            });
         
         
         
    </script> 
    
    
   