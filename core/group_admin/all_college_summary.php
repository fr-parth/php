<?php
include('groupadminheader.php');
 $GroupMemId=$_SESSION['id']; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<!--
 <link rel="stylesheet" href="../css/bootstrap.min.css"> 
<script src="../js/jquery-1.11.1.min.js"></script> 
    <script src="../js/select2.min.js"></script>
    <script src='../js/bootstrap.min.js' type='text/javascript'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
-->
  
    
   <script type="text/javascript">
        
        $(document).ready(function(){ 
            
         $("#overlay").hide();  
          
          $('.searchselect').select2();    
             
            load_data(); 
             
            function load_data(InstState='',allDeptName='',acdYear='')
            {
                $.ajax({
                     url:"storeScadminState.php",
                     method:"POST",
                     data:{adminState:InstState,allDeptName:allDeptName,acdYear:acdYear},
                     success:function(data)
                    {
                        //alert(data);
                         
                    }
                });
            }
            
            $("form").submit(function(){
                
                 $("#overlay").show();
                
                 var InstState    = $("#multi_search_filter").val();
                 var allDeptName  = $("#all_dept_id").val(); 
                 var acdYear      = $("#academicYear").val();
                 
                        var error = "";
                        var valerror = "";  

                        if($("#multi_search_filter").val() == "")
                            {
                                error += "<p>Select School Name</p>";
                            }
                     

                        if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }else{
                               
                                 $.ajax({ 
                                     type:"POST",
                                     url:"fetchAll_AllaicteReport.php",
                                     data:{instState:InstState,allDeptName:allDeptName,acdYear:acdYear},
                                     success:function(data)
                                     {   
                                         
                                         $("#live_data").html(data);
                                       
                                         load_data(InstState,allDeptName,acdYear);
                                         
                                         
                                         $("#overlay").hide();
                                         
                                     } 
                                 });
                                 
                                 
                            }
                return false;
 
            }); 
             
        });
        
    </script>    
 
 

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
           top: 28px;
       }
       
       .submitBtn{
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
         
       

<div class="" style="padding:30px;" > 

                    <div class="row">

                        <div class="col-md-0 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
 
                     </div>

                     <div class="col-md-10 " align="center" style="padding-left:300px;">

                          <h2 style="color:#0000FF">360 Degree Feedback Summary</h2>
                               
                     </div> 
 
 
 <a href="exportALLaicteFeddSummaryReport.php"><button type="text" name="export" id="export" class="btn btn-success" value="export">Export To Excel</button></a>
 
                     </div>
    
    
    
         <form id="submitDataAll">
                 
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
                                     <label for="institute">Select Institute State</label>
                                    <select id="multi_search_filter" name="multi_search_filter" class="form-control searchselect">
 
                                     <option value="all">All</option> 
                                        <?php  
                                         $sq = "SELECT DISTINCT scadmin_state FROM tbl_school_admin WHERE group_member_id='$GroupMemId' AND scadmin_state IS NOT NULL";

                                           $IndFilter = mysql_query($sq); 

                                           while($raw = mysql_fetch_assoc($IndFilter))
                                            {  
                                        
                                        ?>  
                                                <option value="<?php echo $raw['scadmin_state']?>"><?php echo $raw['scadmin_state']?></option>'; 
                                         
                                                
                                       <?php }

                                        ?>
                                        
                                        
                                    </select> 
                                </div>
                    </div>
					 <div class="col-md-2" id="dept1" hidden > 
                          <div class="deptSelect"> 
                                <label for="department">Select Department</label>
 
                                    <select id="all_dept_id" name="all_dept_id" class="form-control"> 
                                        
                                       <option value="all">All</option> 
<!--
                                        
-->
                                        
                                    </select> 
 
                                </div>
                    </div> 
					<div class="col-md-2">
					
                    
                        <input type="submit" name="submitAll" id="submitAll" value="Submit"  class="btn btn-primary" style="margin-top: 50px;" /> 
                    
					</div>
 
 
               </div>
                
        </form>
    

               <div class="row" style="padding:10px;">

               <div class="col-md-12  " id="no-more-tables">
                   
       
  <div id="overlay" class="col-sm-offset-5">
     <img src="image/loading.gif" class="Textcenter" alt="Loading" /> 
</div>
 
                   
                   <div id="live_data"></div>
                   
                   </div>
    </div>
    </div>
    </div>
 
</body>
</html>
    
   
    
    
    
    
    
 