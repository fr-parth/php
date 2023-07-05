<?php
/*Author:Rutuja Jori
  Date  :22/01/2021
  This file was created for generating Reward points summary csv report of Teacher for SMC-5119
*/
$report="";
include_once('scadmin_header.php');
$id=$_SESSION['id'];
$school_id = $_SESSION['school_id'];
$f_dt = $_POST['fromdt'];//table column
$t_dt = $_POST['todt'];//table column
$cond="";
//$filename="Student_List_".date("YmdHis");
if(isset($_POST['submit']))
{
if($_POST['department']!=''){
$department= $_POST['department']; 
$cond = " and t.t_dept='$department' ";
}

if($_POST['designation']!=''){
$designation_teacher= $_POST['designation'];  
$cond.= " and t.t_designation='$designation_teacher' ";
}
if($f_dt!="" && $t_dt!=""){
         $from_dt = date('Y-m-d H:i',strtotime($f_dt));
         $to_dt = date('Y-m-d H:i',strtotime($t_dt));
        $where .= " AND point_date between '$from_dt' AND '$to_dt'";
      }
 $qr="Select t.t_designation,t.t_dept,t.school_id,t.t_id,t.t_pc,ucwords(t.t_complete_name) as name,t.t_current_school_name,SUM(tp.sc_point) as Assigned_Points from 
          tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id where t.school_id='$school_id' and (tp.sc_entities_id='102' or  tp.sc_entities_id='105' or tp.sc_entities_id='103') and (point_type='bluepoint' or point_type='blue_point') and point_date between '$from_dt' AND '$to_dt' $cond group by tp.sc_teacher_id order by Assigned_Points desc"; //echo $qr;exit;

$rs_result=mysql_query($qr);
$j1 = mysql_num_rows($rs_result);

?> <div align="center"> <?php if($j1>0){ echo "<h3>".$j1." $dynamic_teacher Data Downloaded Successfully"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_reward_summary.php'>Back</a></h3>"; }else{echo "<h3>$dynamic_teacher data not found"; ?>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo "<a href='teacher_reward_summary.php'>Back</a></h3>";} ?> </div> 
<?php 

echo ("<script LANGUAGE='JavaScript'> 
          window.location.href='export_teacher_reward_summary.php?department=".$department."&designation=".$designation_teacher."';
          </script>");
}
?>


<html>
<head>
      <script src="js/bootstrap-datetimepicker.js"></script>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script type="text/javascript">
   $(function () {

            // alert('hi');    
                
            $("#fromdt").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd HH:mm',
                    endDate: new Date()
                    // alert('hi1');
                });

                $("#todt").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd HH:mm',
                    endDate: new Date()
                });

            });
        </script>
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
                   
                     <div class="col-md-11 " align="center" style="color:#663399;" >

                          <h2>Download <?php echo $dynamic_teacher;?> Data</h2>
                     </div>
                     <div class="col-md-3" style="margin-left: 200px;">
          <label for="type" class ="control-label col-sm-3">From Date:</label>
          <div class="col-sm-9" id="typeedit">
          <input type="text" class="form-control datetimepic" name="fromdt" autocomplete="off" id="fromdt" value="<?php if(isset($_POST)){if($f_dt!=""){echo date('d-m-Y H:i',strtotime($f_dt)); }else{ echo $fr_date; }}  else{ echo $fr_date; }  ?>">    
          </div>
        </div>
        <div class="col-md-3">
          <label for="type" class ="control-label col-sm-3">To Date:</label>
          <div class="col-sm-9" id="typeedit">
            <input type="text" class="form-control datetimepic" name="todt" autocomplete="off" id="todt" value="<?php if(isset($_POST)){if($t_dt!=""){echo date('d-m-Y H:i',strtotime($t_dt)); }else{ echo $to_date;}}  else{ echo $to_date;} ?>">    
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
                    <b><h4>Department</h4></b>
                    </div>
          <div class="col-md-3">
<select name="department" id="department" class="smartsearch form-control" />

            <option value="">Select Department</option>
      
<?php $row=mysql_query("Select Dept_Name,ExtDeptId,Dept_code,id from tbl_department_master  where school_id='$school_id' and Dept_Name!='' group by Dept_Name order by `Dept_Name` ASC");
      while($value1=mysql_fetch_array($row)){?>

            <option value="<?php echo $value1['Dept_Name'];?>"><?php echo $value1['Dept_Name'];?></option>
      <?php }?>

      </select>

                  </div>
          </div>
  <br>
                  <div class="row " style="padding:5px;" >
                 <div class="col-md-2" >

                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Designation</h4></b>
                    </div>
          <div class="col-md-3">
<select name="designation" id="designation" class="smartsearch form-control" />

            <option value="">Select Designation</option>
      
<?php $row=mysql_query("select * from tbl_teacher_designation where school_id='$school_id'");
      while($value1=mysql_fetch_array($row)){?>

            <option value="<?php echo $value1['designation'];?>"><?php echo $value1['designation'];?></option>
      <?php }?>

      </select>

                  </div>
          </div>

                   <div class="row" style="padding-top:15px;">
                  
                  <div class="col-md-6 col-md-offset-4 "  >
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="btn btn-success" name="submit" value="Export to CSV" />
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