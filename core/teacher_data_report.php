<?php
/*Author:Rutuja Jori
  Date  :30/12/2020
  This file was created for generating Excel Report of Teachers for SMC-5075
*/
$report="";
include_once('scadmin_header.php');
$id=$_SESSION['id'];
$school_id = $_SESSION['school_id'];
$cond="";
if(isset($_POST['submit']))
{
$year= $_POST['year'];
// $qry = "SELECT Year from tbl_academic_year where AcademicYear = '$year';
  // $year1 = explode()



if($year!=''){
  if($year == 'all'){
    $qr="select * from tbl_teacher where school_id='$school_id' and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137')";
    $rs_result=mysql_query($qr);
    $j1 = mysql_num_rows($rs_result);
  }
  else{
    $cond = "and t_academic_year <= '$year'";
    $qr="select * from tbl_teacher where school_id='$school_id' and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137') and t_academic_year!='' $cond";
    $rs_result=mysql_query($qr);
    $j1 = mysql_num_rows($rs_result); 
  }
}
  

?> 
<div align="center"> <?php if($j1>0){ echo "<h3>".$j1." $dynamic_teacher Data Downloaded Successfully"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_data_report.php'>Back</a></h3>"; }else{echo "<h3>$dynamic_teacher data not found"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_data_report.php'>Back</a></h3>";} ?> </div> <?php 

echo ("<script LANGUAGE='JavaScript'> 
          window.location.href='export_teacher.php?year=".$year."';
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
                   <form method="post" style="height: 47%;">

                    <div style="background-color:#F8F8F8 ;height:105%;">
                    <div class="row">
                   
                     <div class="col-md-11 " align="center" style="color:#663399;" >

                          <h2>Download <?php echo $dynamic_teacher;?> Data</h2>
                     </div>

                     </div>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >

                    </div>

                  </div>
                  <br>
              <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4><?php echo $dynamic_year;?></h4></b>
                    </div>
          <div class="col-md-3">
      <select name="year" id="year" class="smartsearch form-control" />

              <option value="">Select upto <?php echo $dynamic_year;?></option>
              <option value="all" <?php if($_POST['year'] == 'all') echo 'selected="selected"' ?> >All</option>

              <?php $row=mysql_query("select t_academic_year from tbl_teacher where school_id='$school_id' and t_academic_year !='' group by t_academic_year");
        while($value=mysql_fetch_array($row)){?> 
          <?php
            $year_split = explode("-",$value['t_academic_year']);
            $year1 = $year_split[0];
            $year2 = $year_split[1];
          ?>
              <!-- <option value="<#?php echo $value['t_academic_year'];?>"><#?php echo $value['t_academic_year'];?></option> -->
              <option value="<?php echo $value['t_academic_year'];?>"><?php echo $year2 ;?></option>
        <?php }?>

      </select>

                  </div>
                  </div>
               

                   <div class="row" style="padding-top:15px;">
                  
                  <div class="col-md-6 col-md-offset-4 "  >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- Changed button name for SMC-5120 by Chaitali on 26-03-2021 -->
                    <input type="submit" class="btn btn-primary" name="submit" value="Generate CSV Report" />
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