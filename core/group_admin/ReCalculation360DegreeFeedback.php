<?php  
 include("groupadminheader.php"); 
 $group_member_id=$_SESSION['id']; 
?>

<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../js/jquery-1.11.1.min.js"></script> 
    <script src="../js/select2.min.js"></script>
    <script src='../js/bootstrap.min.js' type='text/javascript'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
    <style type="text/css">
    
        .feedback{ 
            padding:2px 2px 2px 2px;
            border:1px solid #CCCCCC; 
            border:1px solid #CCCCCC;
            box-shadow: 0px 1px 3px 1px #C3C3C4;
            background-color:#F8F8F8;
            margin-top: 50px;
        } 
        
        .feedBg{
            background-color:#F8F8F8;
 
            padding: 100px;
        }
        
        .div{
            
            padding: 20px 0px 30px 0px;
        }
        
        .feedTop{
            margin-bottom: 50px;
        }
        
        .feedOpt{
            
            margin-top: -50px;
 
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
    
    
<script type="text/javascript">
   $(document).ready(function(){
       
       $("#overlay").hide();
       
    $('.searchselect').select2();    
       
          $("#submit").on('click', function(){
              
                 $("#overlay").show();
                
                 var schoolID = $("#school_id").val();
                 var acdYear  = $("#academicYear").val();
                 
                  $.ajax({
                             url:"generate_360feedback.php",
                             method:"POST",
                             data:{schoolID:schoolID,acdYear:acdYear},  
                             success:function(data)
                              {  
                                 alert(data);
                                 $("#overlay").hide();  
                              }
                         }); 
                              return false;
          });
        
   });
</script>
    
    
</head>
<body>
<div class="container">
     
<div class="feedback">
    <form  id="feedbackForm">

        <div class="feedBg">
            <div class="row">
                <div class="col-md-12 feedTop" align="center" style="color:#663399;">
                    <h2>Recalculate 360 degree feedback</h2>
                </div>
            </div>

       <div class="div">
            <div class="row"> 
                <div class="col-md-4"></div> 
 
                     <div class="col-md-4 feedOpt"> 
                        <label>Select Institute</label> 
                        <select id="school_id" name="school_id" class="form-control searchselect"> 
                                        
                                            <option value="all">All</option>
                                        
                                        <?php 
                                        
                                         $sq = "SELECT school_id,school_name
                                          
                                         FROM tbl_school_admin 
                                         
                                         WHERE group_member_id='$group_member_id'
                                         
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
           
           <br/><br/><br/><br/>
           
                <div class="row">
                    <div class="col-md-4"></div> 
                          <div class="col-md-4 feedOpt">
                  
                                  <label>Select Year</label>     
                                  <select id="academicYear" name="academicYear" class="form-control "> 
                                        
                                            <option value="all">All</option>
                                        
                                        <?php 
                                        
                                         $sq = "SELECT DISTINCT academic_year
                                          
                                         FROM aicte_ind_feedback_summary_report 
                                         
                                         ";

                                           $IndFilter = mysql_query($sq); 

                                           while($raw = mysql_fetch_assoc($IndFilter))
                                            {  
                                        
                                        ?>  
                                                <option value="<?php echo $raw['academic_year']?>"><?php echo $raw['academic_year']?></option>'; 
                                        
                                               
                                            
                                      <?php }  ?>
                                      
                                    </select> 
                      
                           </div>
                     </div>
                
            </div>

             
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-1"><input type="submit" name="submit" id="submit" value="Recalculate" class="btn btn-success btn-lg"> 
                </div>  
            </div> 
        </div> 
    </form>
    </div>
</div>
            <div id="overlay" class="col-sm-offset-5">
                 <img src="image/loading.gif" class="Textcenter" alt="Please Wait it's Loading..." /> 
                <span class="text-center" style="margin-left:90px;">Please Wait...</span>  
            </div>
    
</body>
</html>
    
    
    
