<?php
include("groupadminheader.php");

$year = date('Y');
$month = date('m');
if($month < 08){
  $ayear = ($year - 1).'-'.$year;
}
else{
  $ayear = ($year).'-'.($year + 1);
}

  $group_member_id = $_SESSION['group_admin_id'];
      
  $where =  "group_member_id='$group_member_id'";
  $Lmt = 10;
  $academic_year = "All";
  if(isset($_POST)){
    if(isset($_POST['Academic_Year'])){
      $academic_year = $_POST['Academic_Year'];
      if($academic_year != "All"){
        $where .= " AND academic_year='$academic_year'";
      }
    }
    if(isset($_POST['institute'])){
      $Lmt = $_POST['institute'];
    }
  }
  $sqln1="SELECT count(id) as cnt,school_id,teacher_id,teacher_name,school_name,scadmin_state,ROUND((SUM(IFNULL(teaching_process,0))/count(id)), 2) as teaching_process,ROUND((SUM(IFNULL(student_feedback,0))/count(id)),2) as student_feedback,ROUND((SUM(IFNULL(dept_activity,0))/count(id)),2) as dept_activity,ROUND((SUM(IFNULL(inst_activity,0))/count(id)),2) as inst_activity,ROUND((SUM(IFNULL(acr,0))/count(id)),2) as acr,ROUND((SUM(IFNULL(cont_society,0))/count(id)),2) as cont_society, (ROUND((SUM(IFNULL(teaching_process,0))/count(id)), 2)+ROUND((SUM(IFNULL(student_feedback,0))/count(id)),2)+ROUND((SUM(IFNULL(dept_activity,0))/count(id)),2)+ROUND((SUM(IFNULL(inst_activity,0))/count(id)),2)+ROUND((SUM(IFNULL(acr,0))/count(id)),2)+ROUND((SUM(IFNULL(cont_society,0))/count(id)),2)) as total_points FROM aicte_ind_feedback_summary_report where $where group by teacher_id,school_id order by total_points DESC LIMIT $Lmt";
    // echo $sqln1; exit;
     
    $sqln2="Select DISTINCT(ay.Academic_Year) as Academic_Year,ay.year,sa.group_member_id from tbl_academic_Year as ay, tbl_school_admin as sa where sa.group_member_id='$group_member_id' AND ay.school_id=sa.school_id";
    // echo $sqln2; exit;
    $sql2 = mysql_query($sqln2);

    $sqln3="SELECT count(id) as cnt,school_id,school_name,scadmin_state,ROUND((SUM(IFNULL(teaching_process,0))/count(id)), 2) as teaching_process,ROUND((SUM(IFNULL(student_feedback,0))/count(id)),2) as student_feedback,ROUND((SUM(IFNULL(dept_activity,0))/count(id)),2) as dept_activity,ROUND((SUM(IFNULL(inst_activity,0))/count(id)),2) as inst_activity,ROUND((SUM(IFNULL(acr,0))/count(id)),2) as acr,ROUND((SUM(IFNULL(cont_society,0))/count(id)),2) as cont_society, (ROUND((SUM(IFNULL(teaching_process,0))/count(id)), 2)+ROUND((SUM(IFNULL(student_feedback,0))/count(id)),2)+ROUND((SUM(IFNULL(dept_activity,0))/count(id)),2)+ROUND((SUM(IFNULL(inst_activity,0))/count(id)),2)+ROUND((SUM(IFNULL(acr,0))/count(id)),2)+ROUND((SUM(IFNULL(cont_society,0))/count(id)),2)) as total_points FROM aicte_ind_feedback_summary_report where $where group by school_id order by total_points DESC LIMIT $Lmt";
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
 <link href="../css/charts-c3js/c3.min.css" rel="stylesheet" type="text/css">

<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #694489;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #694489;
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

.detail_color{
   color:#7647a2;
}

.detail_color:hover{
   color:#188e8e;
   font-size: 28px;
}

.c3-axis-x text 
{
  font-size: 12px; //change the size of the fonts
}
</style>
</head>
<body>


<div class="container">
  <div class="row">

        <div class="radius" style="height:50px; background-color:#694489;" align="center">
          <h2 style="padding-left:20px;padding-top:10px;color:white">360 Feedback Top Teachers</h2>
        </div>
  </div>
  
  <div class="row" style="padding-top:10px;">
    <div class="col-md-12" style="padding:20px 0 10px;">
      <form method="post" action="">
        <div class="col-md-4">
          <label for="type" class ="control-label col-sm-4"> Top :</label>
          <div class="col-sm-8" id="typeedit">
            <select class="form-control searchselect" name="institute" id="institute" required="required">
              <option <?php if(isset($_POST['institute'])){ if($_POST['institute']=="5"){ echo "selected"; } }?> value="5"> 5 Teachers</option>
              <option <?php if(isset($_POST['institute'])){ if($_POST['institute']=="10"){ echo "selected"; } }?> value="10">10 Teachers</option>
              <option <?php if(isset($_POST['institute'])){ if($_POST['institute']=="15"){ echo "selected"; } }?> value="15">15 Teachers</option>
            </select>
          </div>
        </div>
        <div class="col-md-5">
          <label for="type" class ="control-label col-sm-4"> Academic Year:</label>
          <div class="col-sm-8" id="typeedit">
            <select class="form-control searchselect" name="Academic_Year" id="Academic_Year" required="required">
              <option value="All">All Academic Year</option>
              <?php while ($row = mysql_fetch_array($sql2)){ ?>
                <option <?php if(isset($_POST['Academic_Year'])){ if($_POST['Academic_Year']==$row['Academic_Year']){ echo "selected"; } }?> value="<?php echo $row['Academic_Year']; ?>"><?php echo $row['Academic_Year']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        
        <div class="col-md-3">
          <button class="btn btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i> Search</button>
        </div>
      </form>
    </div>
    <br>
    <br>
    <div class="clearfix"></div>
    <div class="col-md-12" style="padding-top:20px;">
      <h3 class="text-center">Top <?= $Lmt; ?> Teachers with Institute's Name</h3>
      <div id="chart" style="height: 600px;"></div>
    </div>
  </div>
</div>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src='../js/bootstrap.min.js' type='text/javascript'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
 <script src="../js/d3/d3.min.js"></script>
<script src="../js/charts-c3js/c3.min.js"></script>
<script src="../js/charts-c3js/c3js-init.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.searchselect').select2();
  });
</script>
<script type="text/javascript">
      <?php
        $j=1; 
        $sc_name="[";
        $sql1= mysql_query($sqln1);
        while($res1 = mysql_fetch_array($sql1)){  
          $sc_name .= "'".$res1['teacher_name']."\t(".$res1['school_name'].")',"; 
        }
        $sc_name .= "]";

        $arr = array();
         $sql3= mysql_query($sqln3);
        while($res3 = mysql_fetch_array($sql3)){  
          $arr[$res3['school_id']] = $res3['total_points'];
        }
      ?>
  var school = <?= $sc_name; ?>;
  var chart = c3.generate({
    padding: {
      bottom: 40,
    },
    data: {
        
        rows: [
          ["Teacher's Name","Institute's Name"],
          <?php $sql1= mysql_query($sqln1); while($res = mysql_fetch_array($sql1)){ ?>
          [<?= $res['total_points'];?>,<?= $arr[$res['school_id']];?>],
      <?php } ?>
        ],
        type: 'bar'
     },
    axis: {
  x: {

        type: 'category',
        categories: school
    },
  y: {
    label: {
      text: "Points (out of 100)",
      max:100,
      position: 'outer-middle'
    }
  }
},
    bar: {
        width: {
            ratio: 0.5 // this makes bar width 50% of length between ticks
        }
    }
});

    </script>
  </body>
</html>