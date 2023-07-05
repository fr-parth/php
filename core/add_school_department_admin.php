<?php
//Created by Rutuja Jori on 30/12/2019 for SMC-4278
if (isset($_GET['name'])) {
    include('school_staff_header.php');
    $table = "tbl_school_adminstaff";
} else {
    include('scadmin_header.php');
    $table = "tbl_school_admin";
}
 $auto_id=$_GET['id'];
 $t_dept=$_GET['dept'];
 $t_id=$_GET['t_id'];
$successreport = "";
$errorreport = "";
$report1 = "";

$fields = array("id" => $id);

$smartcookie = new smartcookie();

$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $_SESSION['school_id'];


$query = mysql_query("select * from tbl_teacher where school_id='$sc_id' AND t_id='$t_id' and t_dept='$t_dept'");
   
    if (mysql_num_rows($query) >= 1) {
        $value1 = mysql_fetch_assoc($query);
         $t_complete_name = $value1['t_complete_name'];
          $dept = $value1['t_dept'];
          
    }

if (isset($_POST['submit'])) {
    
   $t_dept=$_POST['dept_id'];
   $r=$_POST['reporting_id'];
   $b = explode (",", $r);
         $reporting_id = $b[0];
        $reporting_name = $b[1];
        
        
        
         $sql = mysql_query("select * from tbl_teacher where  is_dept_admin='1' and t_dept='$t_dept' and school_id='$sc_id'");
             $count=mysql_num_rows($sql);
             $val1 = mysql_fetch_assoc($sql);
             $t_id_previous = $val1['t_id'];

             if($count>=1){
             if($reporting_id!=$t_id_previous)   
             {?>
           <script LANGUAGE='JavaScript'>
                  var r=  window.confirm('Department Admin already exists...Do you want to change the Department Admin??');
                    <?php $var = "<script>document.write(r)</script>"?>  
                    </script>
                
<?php 

    if($var==true)
    {
        $update1 = "UPDATE tbl_teacher SET   
      is_dept_admin = case  t_id 
      when '$t_id_previous' then '0'
      when '$reporting_id' then '1'
      end where school_id='$sc_id'
      and t_dept='$t_dept'";
        
        $q1=mysql_query($update1);
        
        echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Updated Successfully...');
                    window.location.href='list_school_department_admin.php';
                    </script>");
            
             
    }else
    {
        echo ("<script LANGUAGE='JavaScript'>
                    window.alert('No change...');
                    window.location.href='list_school_department_admin.php';
                    </script>");
    }


}else{

    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('The same record already exists...');
                    window.location.href='list_school_department_admin.php';
                    </script>");
}
    
}else{
       
            $query = mysql_query("update tbl_teacher set is_dept_admin='1' where t_dept='$t_dept' and t_id='$reporting_id' and school_id='$sc_id'");
            
           echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Department Admin is successfully Inserted');
                    window.location.href='list_school_department_admin.php';
                    </script>");

        }
}
?>
<html>
<head>
   <script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script type="text/javascript">
            
            function Myfunction(value, fn) {
                
                
                
                if (value != '') {
                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            
                            if (fn == 'fun_emp_type_edit') {
                                document.getElementById("reporting_id").innerHTML = xmlhttp.responseText;
                            }
                        }
                    }
                    xmlhttp.open("GET", "get_teacher_list_for_deptadmin.php?fn=" + fn + "&value=" + value, true);
                    xmlhttp.send();
                }
            }
            
function valid() {  

var dept = document.getElementById("dept_id").value;

                var reporting_id = document.getElementById("reporting_id").value;


                if (dept == "-1") {

                  alert('Please Select Department');

                    return false;
                } 
                
                if (reporting_id == "-1") {

                  alert('Please Select Manager');

                    return false;
                } 
}
 
</script>
</head>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>
    </div>
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
            <h2 style="padding-top:30px;">
                <center>Add Department Admin</center>
            </h2>

            <form method="post">
                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>
                    <div class="col-md-2" style="color:#808080; font-size:18px;">Department<span style="color:red;font-size: 25px;">*</span></div>

                    <div class="col-md-3">
                       <select class='form-control' id="dept_id" name="dept_id" placeholder='Enter Department' onChange="Myfunction(this.value,'fun_emp_type_edit')">
                       
                       <option value="-1"> Select Department</option>

                <?php $arr = mysql_query("select * from tbl_department_master where school_id='$sc_id' ORDER BY Dept_Name"); ?>
                        
                        
                        <?php while ($row = mysql_fetch_array($arr)) { ?>
                        <option value="<?php echo $row['Dept_Name']?>"><?php echo $row['Dept_Name'] ?></option><?php } ?>
                  </select>

                    </div>
                
                    </div>
                <div class="row">
                    <div class="col-md-3 " id="errordept" style="color:#F00; text-align: center;"></div>
                </div>

                <div class="row" style="padding-top:30px;">
                    <div class="col-md-4"></div>

                    <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_teacher;?> <span style="color:red;font-size: 25px;">*</span></div>

                    <div class="col-md-3">
                        <select class='form-control' id="reporting_id" name="reporting_id" placeholder='Enter Manager'>
                    
                  <option value="-1"> Select Manager</option>
                      
                        
                        
               
               
                  </select>
                    </div>
                    
                    <div class="col-md-3 col-md-offset-6" style="color:#FF0000; text-align: center;"><?php echo $report1; ?></div>
                </div>
            


                <div class="row" style="padding-top:60px;">
                    <div class="col-md-5"></div>
                    <div class="col-md-1"><input type="submit" name="submit" value="Add" class="btn btn-success" onClick="return valid()"></div>
                    <div><a href="list_school_department_admin.php" style="text-decoration:none;">
                            <input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/>
                        </a>
                    </div>
                    <!--<div class="col-md-2"><input type="reset" name="cancel" value="Cancel"  class="btn btn-danger"></div>-->
                </div>

                <div class="row" style="padding-top:30px;">
                    <center style="color:#FF0000;"><?php echo $errorreport ?></center>
                    <center style="color:#093;"><?php echo $successreport ?></center>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
