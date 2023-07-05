<?php
/*Author:Sayali Balkawade 
  Date:24/10/2020
  This file is created for generate report in excel 
*/
$report="";
  include_once('groupadminheader.php');
$id=$_SESSION['id'];
$group_member_id = $_SESSION['group_admin_id'];

if(isset($_POST['submit']))
{
	
$college= $_POST['college'];
$college_name = $_POST['college_nm'];

$qr="select * from tbl_department_master where School_ID='$college'";

$rs_result=mysql_query($qr);
 unset($_SESSION['report_header']);
  unset($_SESSION['report_values']);

    $_SESSION['report_header']=array("Sr.No.","Member ID","Department Code","Department Name","Establishment Year","Phone Number","Email ID","Is Enabled","School ID");
  $j1=0;
          
    while($row7=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
          
  $_SESSION['report_values'][$j][0]=$j1;
   $_SESSION['report_values'][$j][1]=$row7['id'];
  $_SESSION['report_values'][$j][2]=$row7['Dept_code'];
  $_SESSION['report_values'][$j][3]=$row7['Dept_Name'];
  $_SESSION['report_values'][$j][4]=$row7['Establiment_Year'];
  $_SESSION['report_values'][$j][5]=$row7['PhoneNo'];
  $_SESSION['report_values'][$j][6]=$row7['Email_Id'];
  $_SESSION['report_values'][$j][7]=$row7['Is_Enabled'];
  $_SESSION['report_values'][$j][8]=$row7['School_ID'];

     } ?>
     <div align="center"> <?php if($j1>0){ echo "<h2>".$college_name."</h2><h3>".$j1." Department Downloaded Successfully"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='department_data_report.php'>Back</a></h3>"; }else{echo "<h2>".$college_name."</h2><h3>Department data not found"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='department_data_report.php'>Back</a></h3>";} ?> </div> <?php 

echo ("<script LANGUAGE='JavaScript'>
				
					window.location.href='Export_report.php?fn=".$college."_department';
					
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

                   				<h2>Download Department Data</h2>
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
			<!-- select query modified by Pranali for bug SMC-3189  -->

            <?php $row=mysql_query("select school_name,school_id from tbl_school_admin where group_member_id='$group_member_id' order by school_name ASC");
			while($value=mysql_fetch_array($row)){?>

            <option value="<?php echo $value['school_id'];?>"><?php echo $value['school_name'];?>(<?php echo $value['school_id']; ?>)</option>
			<?php }?>
			</select>
      <input type="hidden" id="college_nm" name="college_nm">
             </div>
              

                  </div>

 <!--Below code commented by Rutuja for removing Academic Year dropdown as Academic year is not inserted in tbl_department_master for SMC-4969 on 26-11-2020-->
             <!--  <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Academic Year</h4></b>
                    </div>
          <div class="col-md-3">
<select name="year" id="year" class="smartsearch form-control" required />

            <option value="">First Select College</option>

            <?php// $row=mysql_query("select Establiment_Year from tbl_department_master where School_ID='".$value['school_id']."' group by Establiment_Year");
      //while($value=mysql_fetch_array($row)){?>

            <option value="<?php //echo $value['Establiment_Year'];?>"><?php// echo $value['Establiment_Year'];?></option>
      <?php //}?>

      </select>

                  </div>
                  </div>
               
-->

                   <div class="row" style="padding-top:15px;">
                  
                  <div class="col-md-6 col-md-offset-4 "  >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-info" name="submit" value="Generate Report In Excel" />
                    </div>
                     
                   </div>

                     
<!--Added new div for Success message by Dhanashri Tak-->

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
$('#college').change(function(){
  var college_nm = $('#college option:selected').text();
  $('#college_nm').val(college_nm);
});
  });

  </script>
   <script type="text/javascript">
  $("#college").change(function(){
    var d_id = $(this).val();
    //alert(d_id);
    $.ajax({
      url : "academic_year.php",
      data : { d_id : d_id },
      type : "POST",
      success : function(data){
        $("#year").html(data);
      }

    });
  });
  
</script>