<?php
/*Author: Pranali Dalvi
Date : 31-3-20
This file was created to Add count of expected data to be upload for school for data upload tracking purpose.
*/
/*Below code updated by Rutuja Jori for adding Edit functionality on the same form to display records if already data is present for that School. Also added queries and updated the form for displaying values for SMC-4807 on 03-09-2020*/
include("scadmin_header.php");
$school_id = $_SESSION['school_id'];
$strAcademicYear = $_SESSION['AcademicYear'];

// echo $add = $_GET['add'];
$date = CURRENT_TIMESTAMP;
$school_details = mysql_query("SELECT school_type FROM tbl_school_admin WHERE school_id='$school_id'");
$school_type1 = mysql_fetch_assoc($school_details);
$school_type = ($school_type1['school_type'] ? $school_type1['school_type']:'school');

$Year = mysql_query("SELECT Academic_Year,Year FROM tbl_academic_Year WHERE school_id='".$school_id."' AND Enable='1'");
        $Year1 = mysql_fetch_assoc($Year);
       $year = $Year1['Academic_Year'];

 $sql1 = "SELECT dw.*,sd.expected_records,sd.semister_type FROM tbl_datafile_weightage dw left join tbl_school_datacount sd on sd.tbl_display_name=dw.table_name and sd.tbl_name=dw.tbl_name WHERE dw.school_type='$school_type' and sd.school_id='$school_id' and sd.semister_type='$sem' and sd.academic_year='$year' group by dw.tbl_name order by sd.id";
$sql=mysql_query($sql1);
$count = mysql_num_rows($sql);
if($count==0){
$sql1 = "SELECT * FROM tbl_datafile_weightage WHERE school_type='$school_type'";
$sql=mysql_query($sql1);
$count = mysql_num_rows($sql);
}
$sql2=mysql_query($sql1);
$sql3=$sql2;
$res1 = mysql_fetch_assoc($sql3);
$pattern = mysql_query("SELECT school_pattern FROM tbl_school_admin WHERE school_id='$school_id'");
$pattern1=mysql_fetch_assoc($pattern);
$school_pattern = $pattern1['school_pattern'];

if(isset($_POST['submit'])){

    // if($add == 'add'){-
        if($res1['semister_type']!=''){
        $sem = $res1['semister_type'];
        }else{
        $sem = $_POST['sem'];
        }
       // echo $sem;
        

        for($i=1;$i<=$count;$i++){
            $data_count = $_POST['data'.$i];
            $tbl_name = $_POST['table'.$i];
            $display_table = $_POST['display_table'.$i];
           
            
            if($tbl_name=='tbl_department_master'){
               $school_id_var = 'School_ID';
            }else{
               $school_id_var = 'school_id';
            }
            //select count of all masters table
            $master = mysql_query("SELECT * FROM $tbl_name WHERE $school_id_var='$school_id'");
            $cnt = mysql_num_rows($master);
            
            // echo "SELECT id FROM tbl_school_datacount WHERE school_i-d='$school_id' AND tbl_display_name='$tbl_name' AND semister_type='$sem'";
            $record = mysql_query("SELECT id FROM tbl_school_datacount WHERE school_id='$school_id' AND tbl_name='$tbl_name' AND semister_type='$sem'");
            
                if(mysql_num_rows($record)==0)
                {
                    $insert = mysql_query("INSERT INTO tbl_school_datacount(school_id,academic_year,semister_type,tbl_name,tbl_display_name,uploaded_records,expected_records,inserted_date) VALUES ('$school_id','$year','$sem','$tbl_name','$display_table','$cnt','$data_count','$date')");
                }
                else{
                    $update = mysql_query("update tbl_school_datacount set academic_year='$year' ,uploaded_records='$cnt',expected_records='$data_count',updated_date='$date',semister_type='$sem' where tbl_name='$tbl_name' and tbl_display_name='$display_table' and school_id='$school_id' and academic_year='$year'");

                }
        }
        if($insert){
                echo "<script>alert('Data inserted successfully');header('Refresh:0');
        </script>";
    }elseif($update){
        echo "<script>alert('Data updated successfully!!');header('Refresh:0');
        </script>";
        
 
    }else{
        echo "<script>alert('Something went wrong!!');header('Refresh:0');
        </script>";
        
 
    }
}
$sql1 = "SELECT dw.*,sd.expected_records,sd.semister_type FROM tbl_datafile_weightage dw left join tbl_school_datacount sd on sd.tbl_display_name=dw.table_name and sd.tbl_name=dw.tbl_name WHERE dw.school_type='$school_type' and sd.school_id='$school_id' and academic_year='$year' group by dw.tbl_name order by sd.id";
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
</head>
<script type="text/javascript">
    
function valid() {
    var sem = document.getElementById("sem").value;
    if (sem=='') {
        alert("Please Select Semester Pattern");
        return false;
    }else{
        return true;
    }

}

</script>
<body>

 <div class="container" style="padding:25px;">
    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">
    <form method="POST" action="">
        <h2 style="margin-left:425px;">Add Count Of Upload Data</h2>
         
           <!-- Semester pattern added according to school pattern-->
            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;">Select Semester Pattern:<span style="color:red;font-size: 25px;">*</span></div>
               
         <div class="col-md-3">
                                   
                 <select id='sem' name='sem' class="form-control"  <?php if($res1['semister_type']!=''){ ?>>  <?php }else{ ?> <?php } ?>
                  
<!--As discussed with Rakesh Sir, Trisemester option added by Pranali for SMC-4235 on 31-3-20 -->
                <option value="<?php if($res1['semister_type']!=''){ echo $res1['semister_type'];}else{
                    echo '';
                    } ?>" ><?php if($res1['semister_type']!=''){ echo 'Select'; }else{
                    echo $sem;
                    } ?></option>
                <?php if($school_pattern=='Semester'){    ?>
                        <option value="odd">Part 1 - Odd Semester Count</option>
                        <option value="even">Part 2 - Even Semester Count</option>
                        <option value="trisemester">Part 3 - Trisemester</option>
                        <option value="Annual">Annual</option>

            <?php } 
                    else { ?>
                        <option value="Annual">Annual</option>
            <?php } ?>
            </select>
        </div>
            </div>
        <?php 
           $i=1;
      $sql=mysql_query($sql1);
        while($res = mysql_fetch_assoc($sql)) {   
    ?>
    
            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $res['table_name'];?></div>
                <div class="col-md-3">
                    <input type="hidden" name="table<?php echo $i;?>" value="<?php echo $res['tbl_name'];?>" />
                    <input type="hidden" name="display_table<?php echo $i;?>" value="<?php echo $res['table_name'];?>" />
                   <?php if($res['tbl_name']=='tbl_academic_Year'){ ?>
                      <input type="hidden" class="form-control" name="data<?php echo $i;?>" id="data<?php echo $i;?>" placeholder="Enter <?php echo $res['table_name'];?>" value="1" />
                      <input type="text" class="form-control" value="<?php echo $year; ?>" readonly disabled />
                  <?php } else { ?>
                    <input type="<?php if($res['tbl_name']=='tbl_academic_Year'){echo "text"; } else { echo "number"; } ?>" min='0' class="form-control" name="data<?php echo $i;?>" id="data<?php echo $i;?>" placeholder="Enter <?php echo $res['table_name'];?>" value=<?php echo $res['expected_records'];?> />
                <?php } ?>
                </div>
            </div>
        <?php $i++;} //while?>

                    <div class='form-group row' style="margin-top:10px;">
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onclick="return valid();" style="padding:5px;"/>
                        </div>

                        <div class='col-md-1'>

                            <a href="scadmin_dashboard.php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel" style="padding:5px;"/></a>

                        </div>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>