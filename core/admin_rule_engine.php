<?php
ob_start();
include("scadmin_header.php");
$msg = $_GET['seccess'];
$school_id = $_SESSION['school_id'];
$query = mysql_query("select * from  school_rule_engine where school_id='$school_id'");

$count = mysql_num_rows($query);
$result_query = mysql_fetch_array($query);
$query_admin = mysql_query("select proud_point_percentage,school_type from  tbl_school_admin where school_id='$school_id'");
$query_admin_result = mysql_fetch_assoc($query_admin);
 $school_type=$query_admin_result['school_type']; 


if (isset($_POST['submit'])) {

    $set_1 = $_POST['set-1'];
    $set_2 = $_POST['set-2'];
    $set_3 = $_POST['set-3'];
    $set_4 = $_POST['set-4'];
    $set_5 = $_POST['set-5'];
    $set_6 = $_POST['set-6'];
    $set_7 = $_POST['set-7'];
    $set_8 = $_POST['set-8'];
    $set_9 = $_POST['set-9'];
    $percentage = $_POST['percentage'];
    $allow_stud = $_POST['allow_stud'];

	if($set_1=='Y')
	{
		//echo "<script>alert('yes')</script>";
		$sql_flag=mysql_query("update tbl_school_admin set thanqu_flag='ScTeStPa' where school_id='$school_id'");
	}
	else
	{
		//echo "<script>alert('no')</script>";
		//echo "update tbl_school_admin thanqu_flag='' where school_id='$school_id'";die;
		$sql_flag=mysql_query("update tbl_school_admin set thanqu_flag='' where school_id='$school_id'");
	}
    if($count==0)
    {
      $sql = mysql_query("insert into school_rule_engine (blue_points_teacher,water_points,brown_points,parent_to_teacher,parent_to_student,student_share_points,teacher_share_points,sponsor_coupon,parent_proud_points,Allow_student_add_subject_360,school_id) values ('$set_1','$set_2','$set_3','$set_4','$set_5','$set_6','$set_7','$set_8','$set_9','$allow_stud','$school_id')");
    }
    else {
        $sql = mysql_query("update school_rule_engine set blue_points_teacher='$set_1', water_points='$set_2', brown_points='$set_3', parent_to_teacher='$set_4',parent_to_student='$set_5',student_share_points='$set_6', teacher_share_points='$set_7',sponsor_coupon='$set_8',parent_proud_points='$set_9',Allow_student_add_subject_360= '$allow_stud' where school_id='$school_id'");
    }

    $sql_admin = mysql_query("update tbl_school_admin set proud_point_percentage= '$percentage' where school_id='$school_id'");

	
    header("refresh:0;url=admin_rule_engine.php?seccess=Rules set successfully");
   
   


}

?>



<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie </title>
    <!-- Added comment link by Chaitali for SMC-4490 on 18-02-2021 -->
  <!-- <link href="css/style.css" rel="stylesheet"> -->
   <style>
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 1px;
        }

        #percentage{
          width: 40px;
        }
    </style>
    <script>
      function radiostatuson(){
      //  document.getElementbyId('percentagediv').style.display = 'block';
          document.getElementById("percentagediv").style.display = 'block';
      }
      function radiostatusoff(){
      //  document.getElementbyId('percentagediv').style.display = 'block';
          document.getElementById("percentagediv").style.display = 'none';
          document.getElementById("percentagediv").value='';
      }
      function validatepercentage(){
        var status = document.getElementById("percentagediv").style.display.toString();
        if(status=='block')
        {
          var percentage = document.getElementById("percentage").value;
          if(percentage=='' || percentage ==0){
          document.getElementById("percentagediverror").style.color = 'red';
          document.getElementById("percentagediverror").innerHTML='please Enter Valid Percentage';
            return false;
          }
        }
        else {
            return true;
        }

      }

    </script>
</head>
<body>
<div class="container" style="width:100%">
    <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
            <div style="height:50px; width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #666666;"
                 align="left">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px; font-size:30px;"><?php echo $dynamic_school; ?>
                    Rules Engine</h2>
            </div>

        </div>
    </div>

    <div class="row" style="padding-top:15px; ">
        <div class="col-md-15" style="width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 2px 1px #666666;">

            <form method="post" style="max-width:1200px; width:100%;" onSubmit="return validatepercentage()">
                <div class="row">

                    <div class="col-md-1"></div>
                    <div class="col-md-5" style="margin-top:6px;">
                        <h4>1. Blue points to be given to <?php echo $dynamic_teacher; ?>  </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-1" id="set-1"
                               value="Y" <?php if ($result_query['blue_points_teacher'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-1" id="set-1"
                               value="N" <?php if ($result_query['blue_points_teacher'] == 'N') { ?> checked="checked" <?php } ?>>
                        OFF
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>2. Water Points </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-2" id="set-2"
                                value="Y" <?php if ($result_query['water_points'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-2" id="set-2"
                               value="N" <?php if ($result_query['water_points'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>3. Brown Points allowed </h4>
                    </div>

                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-3" id="set-3"
                               value="Y" <?php if ($result_query['brown_points'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-3" id="set-3"
                               value="N" <?php if ($result_query['brown_points'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>

                </div>
                <hr>

			<?php //$user in scadmin_header file
			if($school_type != 'organization' && $user !='HR Admin'){ ?>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>4. Parents to give points to <?php echo $dynamic_teacher; ?> </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-4" id="set-4"
                               value="Y" <?php if ($result_query['parent_to_teacher'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-4" id="set-4"
                               value="N" <?php if ($result_query['parent_to_teacher'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>5. Parents to give points to <?php echo $dynamic_student; ?> </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-5" id="set-5"
                               value="Y" <?php if ($result_query['parent_to_student'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-5" id="set-5"
                               value="N" <?php if ($result_query['parent_to_student'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>
			<?php } ?>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>6. <?php echo $dynamic_student; ?> to share points </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-6" id="set-6"
                               value="Y" <?php if ($result_query['student_share_points'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-6" id="set-6"
                               value="N" <?php if ($result_query['student_share_points'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>7. <?php echo $dynamic_teacher; ?> to share points </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-7" id="set-7"
                               value="Y" <?php if ($result_query['teacher_share_points'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-7" id="set-7"
                               value="N" <?php if ($result_query['teacher_share_points'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>


                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>8. Sponsor coupons allowed </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-8" id="set-8"
                               value="Y" <?php if ($result_query['sponsor_coupon'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-8" id="set-8"
                               value="N" <?php if ($result_query['sponsor_coupon'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>
				<?php //$user in scadmin_header file
				if($school_type != 'organization' && $user !='HR Admin'){  ?>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>9. Parent Proud Points Allowed</h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-9" id="set-9"
                               onclick="radiostatuson()" value="Y" <?php if ($result_query['parent_proud_points'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="set-9" id="set-9"
                               onclick="radiostatusoff()" value="N" <?php if ($result_query['parent_proud_points'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                    <div class="col-md-2" id='percentagediv' style="margin-top:15px;font-size: initial;display:<?php if($result_query['parent_proud_points'] == 'N') { echo 'none';} ?>;">
                        Enter Percentage:
                        <input type="number" name="percentage" id="percentage"
                               value="<?php echo $query_admin_result['proud_point_percentage'];?>">
                    </div>
                    <div class="col-md-2"  style="margin-top:15px;font-size: initial;">
                      <p id='percentagediverror'></p>
                    </div>



                </div>
                <hr>
				<?php } ?>
                
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <h4>10. Allow students to add subject manually for 360 degree feedback. </h4>
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="allow_stud" id="allow_stud"
                               value="Y" <?php if ($result_query['Allow_student_add_subject_360'] == 'Y') { ?> checked="checked" <?php } ?> >
                        ON
                    </div>
                    <div class="col-md-1" style="margin-top:15px;font-size: initial;">
                        <input type="radio" name="allow_stud" id="allow_stud"
                               value="N" <?php if ($result_query['Allow_student_add_subject_360'] == 'N') { ?> checked="checked" <?php } ?> >
                        OFF
                    </div>


                </div>
                <hr>
				<div align='center'>
				<p style='color:green'><?php echo $msg; ?></p>
				</div>

                <div class="row" style="margin-top:8px; margin-bottom:2px;">
                    <div class="col-md-5"></div>
                    <div class="col-md-1"><input type="submit" name="submit" value="Save" class="btn btn-success"></diV>
                    <div class="col-md-1"><a href="scadmin_dashboard.php"><input type="button" name="cancel"
                                                                                value="Cancel"
                                                                                class="btn btn-danger"></a></div>

                    <div style="height:60px"></div>

                </div>


            </form>


        </div>


    </div>


</div>


</body>
</html>
