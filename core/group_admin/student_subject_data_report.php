<?php
/*Author: Pranali Dalvi
  Date: 27/11/2020
  This file is created for downloading student subject data in excel 
*/
$report="";
  include_once('groupadminheader.php');
$id=$_SESSION['id'];
$group_member_id = $_SESSION['group_admin_id'];

if(isset($_POST['submit']))
{
	
$college= $_POST['college'];
$year= $_POST['year'];
$sch_name=mysql_query("select school_name from tbl_school_admin where school_id='$college' ");
      $sch_name1=mysql_fetch_array($sch_name);
      $school_name = $sch_name1['school_name'];
if($year !='')
{
$cond="and AcademicYear='$year'";
}

$qr="select * from tbl_student_subject_master where school_id='$college' $cond";
$rs_result=mysql_query($qr);
$num = mysql_num_rows($rs_result);
?>
<div align="center"><?php echo "<h2>". $school_name. "</h2>"; ?> <br>
        <?php echo "<h2>". $num ." Student Subject Data Downloaded Successfully". "</h2>"; ?><br><br>
        <?php echo "<a href='student_subject_data_report.php' class='btn btn-warning'>Back</a>". "</h2>";?> </div> 

<?php

 unset($_SESSION['report_header']);
  unset($_SESSION['report_values']);

    $_SESSION['report_header']=array("Sr.No.","Subject Code","Subject Name","Group Member ID","School ID","School Name","Academic Year","Student Member ID","Student PRN","Teacher Employee ID","Branch","Department","Division","Course Level","Uploaded By","Uploaded Date","Semester");
  $j1=0;
          
    while($row7=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
          
	$_SESSION['report_values'][$j][0]=$j1;
   $_SESSION['report_values'][$j][1]=$row7['subjcet_code'];
  $_SESSION['report_values'][$j][2]=$row7['subjectName'];
  $_SESSION['report_values'][$j][3]=$row7['group_member_id'];
  $_SESSION['report_values'][$j][4]=$row7['school_id'];
  $_SESSION['report_values'][$j][5]=$school_name;
  $_SESSION['report_values'][$j][6]=$row7['AcademicYear'];
  $_SESSION['report_values'][$j][7]=$row7['Stud_Member_Id'];
  $_SESSION['report_values'][$j][8]=$row7['student_id'];
  $_SESSION['report_values'][$j][9]=$row7['teacher_ID'];
  $_SESSION['report_values'][$j][10]=$row7['Branches_id'];
  $_SESSION['report_values'][$j][11]=$row7['Department_id'];
  $_SESSION['report_values'][$j][12]=$row7['Division_id'];
  $_SESSION['report_values'][$j][13]=$row7['CourseLevel'];
  $_SESSION['report_values'][$j][14]=$row7['uploaded_by'];
  $_SESSION['report_values'][$j][15]=$row7['upload_date'];
  $_SESSION['report_values'][$j][16]=$row7['Semester_id'];
		
		 }
      echo ("<script LANGUAGE='JavaScript'>
				
					window.location.href='Export_report.php?fn=student_subject_data';
					
					</script>");
				
}

?>


<html>
<head>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;">
        		<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                   
              			 <div class="col-md-12 " align="center" style="color:#663399;" >

                   				<h2>Download Student Subject Data</h2>
               			 </div>

                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>College Name</h4></b>
                    </div>

               <div class="col-md-3">
            <select name="college" id="college" class="smartsearch form-control" required />

            <option value="">Select</option>

            <?php $row=mysql_query("select school_name,school_id from tbl_school_admin where group_member_id='$group_member_id' order by school_name ASC");
			while($value=mysql_fetch_array($row)){?>

            <option value="<?php echo $value['school_id'];?>"><?php echo $value['school_name'];?>(<?php echo $value['school_id']; ?>)</option>
			<?php }?>

			</select>
             </div>
              

                  </div>



               <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Academic Year</h4></b>
                    </div>
					<div class="col-md-3">
<select name="year" id="year" class="smartsearch form-control" required />

            <option value="">First Select College</option>
		
            
			</select>

                  </div>
                  </div>
               

                   <div class="row" style="padding-top:15px;">
                  
                  <div class="col-md-6 col-md-offset-4 "  >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-info" name="submit" value="Download Data In Excel" />
                    </div>
                     
                   </div>

						  <div class="row" style="padding:15px;">
                    
                    </div>
					</div>
                       </div>
                </form>





               </div>
               </div>
</body>
</html>
<script src="js/jquery-ui.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
 $(document).ready(function() {

$('.smartsearch').select2();

  });
  </script>
  <script type="text/javascript">
	$("#college").change(function(){
		var c_id = $(this).val();
		
		$.ajax({
			url : "academic_year.php",
			data : { c_id : c_id },
			type : "POST",
			success : function(data){
				$("#year").html(data);
			}

		});
	});
	
</script>