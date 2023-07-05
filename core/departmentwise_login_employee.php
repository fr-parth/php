<?php
include("scadmin_header.php");
error_reporting(0);
/* $id=$_SESSION['id']; 
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
 $smartcookie=new smartcookie();*/
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Cookie Program</title>


</head>

<body>

<div class="container" style="padding-top:30px;">

    <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        <?php
                        $sql_sp = "select id,Dept_Name, ExtDeptId from  tbl_department_master where school_id='$school_id' AND Is_Enabled='1' AND (Dept_Name!='' or Dept_Name is not NULL) group by Dept_Name";
                        // echo $sql_sp; exit;
                        $row_sp = mysql_query($sql_sp);
                        // $dept_res = mysql_fetch_array($row_sp); ?>

        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white"><?= ucwords($dynamic_student); ?> Login Report for Department </h2>
        </div>

</div>
</div>

    <div class="row" style="padding-top:20px;">

<?php 
$i = 0;
while ($count_sp = mysql_fetch_array($row_sp)) {
    //Below code changed for SMC-4925 by chaitali on 22-04-2021 
    if($count_sp['id']!= '' && $count_sp['Dept_Name']!= '')
    {
 
    ?>
  <div class="col-md-3">
                            <a href="dept_login_report.php?id=<?= $count_sp['id']; ?>" style="text-decoration:none;">
                                <div class="panel panel-info ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><b><?= $count_sp['Dept_Name'];?></b></h3>
                                    </div>
                                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                                        $cnt_sql="SELECT ls.RowID as totalEmp FROM tbl_LoginStatus ls LEFT JOIN tbl_student s on ls.EntityID=s.id where(s.ExtDeptId='".$count_sp['ExtDeptId']."' OR s.std_dept='".$count_sp['Dept_Name']."') AND s.school_id='$school_id' AND (ls.Entity_type='105' OR ls.Entity_type='205') group by ls.EntityID order by ls.RowID";
                                         //echo $cnt_sql; exit;
                                        $result = mysql_query($cnt_sql);
                                        $row = mysql_num_rows($result);
                                        echo $row;?>
                                    </div>

                                </div></a> 

                </div>



<?php 
$i++;
} 
 


  }
?>
           
    </div> <!-- row 1 End --> 
</div>
</div>
</body>
</html>
