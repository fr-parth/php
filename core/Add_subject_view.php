<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<script>
	
        $(document).ready(function() {
            $('#example').dataTable( {
		
				
         });
			
     	$("#subject_name").keyup(function(){
			alert('coming');
			return false;
		$.ajax({
		type: "POST",
		url: "readsubject.php",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#subject_name").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#subject_name").css("background","#FFF");
		}
		});
	});
  
  
  
        } );
		
		//document.getElementById("CourseLevel").value;
		
 </script>
</head>

<title>Add Subject</title>
    

<body  >

     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Add Subject</div>
                </div>
				
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   <!-- <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">Add Subjects</li>
                </ol>
				
                <div class="clearfix"></div>
            </div>

<div style="bgcolor:#CCCCCC">

<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
                   <h2 style="padding-top:30px;"><center>Add Subject</center></h2>
                   
                
               <div class="row formgroup" style="padding:5px;">
                   <form method="post">
				   
				   
						
				   
						<div class="row " style="padding-top:50px;">
						<div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">           Subject Name</div>
							<div class="col-md-3">
							
			   
							<select name="subject_name" id="subject_name" class="form-control" >
							
							
							</select>
							</div>
						</div>
			   
			       <!-- <div class="row " style="padding-top:30px;">
                      <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;" >Department</div>
					  <div class="col-md-3"  >
					  <select name="department" id="department" class="form-control" >
					  </select>
					  </div>
					</div>
			   
			    <div class="row" style="padding-top:30px;">
						<div class="col-md-4"></div>
						<div class="col-md-2" style="color:#808080; font-size:18px;">Semester</div>
							<div class="col-md-3">
							<select name="semester" id="semester" class="form-control" >
							</select>
			
                           </div>
				</div>
				
				<div class="row" style="padding-top:30px;">
					<div class="col-md-4"></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year</div>
					<div class="col-md-3">
					<select name="AcademicYear" id="AcademicYear" class="form-control" >
							</select>

					</div>
					
			

			</div>
				
				
				<div class="row " style="padding-top:30px;">
               <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Division</div>
			   
			   <div class="col-md-3">
			        
			   <select name="Division" id="Division" class="form-control" >
							</select>
			   </div>
			    </div>
			   
			   
			   
			   
			   <div class="row" style="padding-top:30px;">
					<div class="col-md-4"></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;">Subject Title</div>
					<div class="col-md-3">
			<input type="text" id="subject_name" name="subject_name" class="form-control"  />
				<div id="suggesstion-box"></div>
				
			   
			   
					</div>
			   </div>
			   
			    <div class="row" style="padding-top:30px;">
					<div class="col-md-4"></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;">Subject Code</div>
					<div class="col-md-3">

					 <select name="subject_code" id="subject_code" class="form-control" >
				</select>
					</div>
					</div>-->
					
					
					<div class="row" style="padding-top:60px;">
						<div class="col-md-5"></div>

						<div class="col-md-1"><input type="submit" name="submit" value="Add"  class="btn btn-success"  onClick="return valid()"></div>
						
						<div class="col-md-1"></div>

						
					</div>
                 
                    </form>
                  
               </div>
            </div>
		</div>
    </div>
	<?php 


$this->load->view('footer');

?>
</body>
</html>
			   