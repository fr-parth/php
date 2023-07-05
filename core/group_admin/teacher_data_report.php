<?php
/*Author:Sayali Balkawade 
  Date:22/10/2020
  This file is created for generate report in excel 
*/
$report="";
  include_once('groupadminheader.php');
$id=$_SESSION['id'];
$group_member_id = $_SESSION['group_admin_id'];

if(isset($_POST['submit']))
{
$cond=''; 
$college= $_POST['college'];
$college_name = $_POST['college_nm'];
$year= $_POST['year'];

if($year !='')
{
$cond="and t_academic_year='$year'";
}
//Below conditions for t_emp_type_pid added by Rutuja for SMC-4971 on 30-11-2020 by Rutuja
$qr="select * from tbl_teacher where school_id='$college' AND t_emp_type_pid IN (133,134,135,137) $cond";


$rs_result=mysql_query($qr);
 unset($_SESSION['report_header']);
  unset($_SESSION['report_values']);

    $_SESSION['report_header']=array("Sr.No.","Member ID","Teacher ID","Name","Email ID","Phone Number","Date Of Birth","School Name","School ID","Experience","std_dept","Class","Address","City","State","Country","Country Code","Academic Year","Authority ID","Group member ID");
  $j1=0;
          
    while($row7=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
          
    $_SESSION['report_values'][$j][0]=$j1;
   $_SESSION['report_values'][$j][1]=$row7['id'];
  $_SESSION['report_values'][$j][2]=$row7['t_id'];
  $_SESSION['report_values'][$j][3]=$row7['t_complete_name'];
  $_SESSION['report_values'][$j][4]=$row7['t_email'];
  $_SESSION['report_values'][$j][5]=$row7['t_phone'];
  $_SESSION['report_values'][$j][6]=$row7['t_dob'];
  $_SESSION['report_values'][$j][7]=$row7['t_current_school_name'];
  $_SESSION['report_values'][$j][8]=$row7['school_id'];
   $_SESSION['report_values'][$j][9]=$row7['t_exprience'];
  $_SESSION['report_values'][$j][10]=$row7['t_dept'];
  $_SESSION['report_values'][$j][11]=$row7['t_class'];
  $_SESSION['report_values'][$j][12]=$row7['t_address'];
  $_SESSION['report_values'][$j][13]=$row7['t_city'];
  $_SESSION['report_values'][$j][14]=$row7['state'];
  $_SESSION['report_values'][$j][15]=$row7['t_country'];
  $_SESSION['report_values'][$j][16]=$row7['CountryCode'];
  $_SESSION['report_values'][$j][17]=$row7['t_academic_year'];
  $_SESSION['report_values'][$j][18]=$row7['t_emp_type_pid'];
  $_SESSION['report_values'][$j][19]=$row7['group_member_id'];
 
    
     }
?> <div align="center"> <?php if($j1>0){ echo "<h2>".$college_name."</h2><h3>".$j1." Teacher Downloaded Successfully"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_data_report.php'>Back</a></h3>"; }else{echo "<h2>".$college_name."</h2><h3>Teacher data not found"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_data_report.php'>Back</a></h3>";} ?> </div> <?php 


echo ("<script LANGUAGE='JavaScript'> 
          window.location.href='Export_report.php?fn=".$college."_teacher';
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

                          <h2>Download Teacher Data</h2>
                     </div>

                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>College Name</h4></b>
                    </div>

               <div class="col-md-3">
            <select name="college" id="college" class="smartsearch form-control" required>

            <option value="">Select</option>
      

            <?php $row=mysql_query("select school_name,school_id from tbl_school_admin where group_member_id='$group_member_id' order by school_name ASC");
      while($value=mysql_fetch_array($row)){?>

             <option value="<?php echo $value['school_id'];?>"><?php echo $value['school_name'];?>(<?php echo $value['school_id']; ?>)</option>
      <?php }?>

      </select>

      <input type="hidden" id="college_nm" name="college_nm">
             </div>
              

                  </div>

<!--Below code commented by Rutuja for removing Academic Year dropdown as Academic year is not inserted in tbl_teacher from Upload Panel for SMC-4969 on 26-11-2020-->

             <!--  <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Academic Year</h4></b>
                    </div>
          <div class="col-md-3">
<select name="year" id="year" class="smartsearch form-control" required />

            <option value="">First Select College</option>
      

            <?php //$row=mysql_query("select t_academic_year from tbl_teacher where school_id='".$value['school_id']."' group by t_academic_year");
      //while($value=mysql_fetch_array($row)){?>

            <option value="<?php //echo $value['t_academic_year'];?>"><?php// echo $value['t_academic_year'];?></option>
      <?php //}?>

      </select>

                  </div>
                  </div>-->
               

                   <div class="row" style="padding-top:15px;">
                  
                  <div class="col-md-6 col-md-offset-4 "  >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-info" name="submit" value="Generate Report In Excel " />
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
    var t_id = $(this).val();
    
    $.ajax({
      url : "academic_year.php",
      data : { t_id : t_id },
      type : "POST",
      success : function(data){
        $("#year").html(data);
      }

    });
  });
  
</script>