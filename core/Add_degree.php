<?php
//Merging of two files add and edit done by Sayali Balkawade for id SMC-2195 
include('scadmin_header.php');
$report = "";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];

if(($_GET["degree_id"])=='')
{
if (isset($_POST['submit'])) {

    if (empty($_POST["Degee_name"])) {
        $ErrDegeename = "Degee name is required";
    } else {
        $Degee_name = $_POST['Degee_name'];
    }

    if (empty($_POST["Degree_code"])) {
        $ErrDegreecode = "Degree code is required";
    } else {
        $Degree_code = $_POST['Degree_code'];
    }


    if (empty($_POST["course_level"])) {
        $Errcourselevel = "course level name is required";
    } else {
        $course_level = $_POST['course_level'];
    }

    if (empty($_POST["ExtDegreeID"])) {
        $ErrExtDegreeID = "Degree ID code is required";
    } else {
        $ExtDegreeID = $_POST['ExtDegreeID'];
    }

    if ($ExtDegreeID != '' && $course_level != '' && $Degree_code != ''&& $Degee_name != '' ) {
        //Modified below query (added  Degee_name instead of Courselevel) for adding validations  by Pranali for SMC-4856 on 24-9-20
        $sql = mysql_query("SELECT school_id,Degee_name FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and `Degee_name`='$Degee_name' ");
        $row = mysql_fetch_row($sql);
        if ($row != '') {
            $errorreport = "This $dynamic_degree is already present ";
        } else {
            if(mysql_query("insert into `tbl_degree_master`(ExtDegreeID,Degee_name,Degree_code,course_level,school_id) values('$ExtDegreeID','$Degee_name','$Degree_code','$course_level','$sc_id')")){
               // $report=" Degree  successfully inserted";
			   echo "<script LANGUAGE='JavaScript'>
					alert('$dynamic_degree successfully inserted');
					window.location.href='list_school_degree.php';
					</script>";
            }else{
                $errorreport="Please Try Again";
            }
        }
    } else {
        $errorreport = "All fields are requird";
    }
}
?>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	-->
</head>
<body>
<div class="container" style="padding:25px;"" >
<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">
    <form method="post">

        <div style="background-color:#F8F8F8 ;">
            <div class="row">
                <div class="col-md-12 " align="center" style="color:#663399;">
                    <h2>Add <?php echo $dynamic_degree;?></h2>
                </div>
            </div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_degree;?> Name<span style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="Degee_name" id="Degee_name" placeholder="Enter <?php echo $dynamic_degree;?> name" value="<?php echo $Degee_name;?>">
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $ErrDegreename; ?></span>
            </div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_degree;?> Code<span
                            style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="Degree_code" id="Degree_code" placeholder="Enter <?php echo $dynamic_degree;?> code" value="<?php echo $Degree_code; ?>">
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $ErrDegreecode; ?></span>
            </div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_level;?><span
                            style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <select name="course_level" id="course_level" class="form-control" required>
                        <option value="" disabled selected> Select <?php echo $dynamic_level;?></option>
                        <?php
                        $sql = "SELECT * FROM `tbl_CourseLevel` WHERE `school_id`='$sc_id'";
                        $query = mysql_query($sql);
                        while ($rows = mysql_fetch_assoc($query)) { ?>
                            <option value="<?php echo $rows['CourseLevel']; ?>" <?php if($rows['CourseLevel']==$course_level){ echo "selected";}else{}?>><?php echo $rows['CourseLevel'];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $Errcourselevel; ?></span>
            </div>

            <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_degree;?> ID<span
                            style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="ExtDegreeID" id="ExtDegreeID" placeholder="Enter <?php echo $dynamic_degree;?> ID" value="<?php echo $ExtDegreeID; ?>">
                </div>
            </div>

            <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                <span class="error"><?php echo $ErrExtDegreeID; ?></span>
            </div>

            <div class="row" style="padding-top:60px;">
                <div class="col-md-5"></div>
                <div class="col-md-1"><input type="submit" name="submit" value="Add" class="btn btn-success" onClick = "return valid()"></div>
                <div class="col-md-1"><a href="list_school_degree.php"><input type="button" value="Back" class="btn btn-danger"></a></div>
            </div>

            <div class="row" style="padding:30px;padding-left:450px;">
                <div class="col-md-4" style="color:#F00;" align="center" id="error">
                    <b><?php echo $errorreport; ?></b>
                </div>
            </div>
            <div class="row" style="padding:30px;padding-left:450px;">
                <div class="col-md-4" style="color:#008000;" align="center" id="error">
                    <b><?php echo $report; ?></b>
                </div>
            </div>
        </div>

    </form>

</div>
</body>
</html>


<?php } 

else
{
	

// Update Record
if (isset($_GET["degree_id"])) {
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $school_id;
    //delete recoard
    //fetch courseLevel data from database
    $degree_id = $_GET["degree_id"];
    $sql1 = "select * from tbl_degree_master where id='$degree_id' and school_id='$sc_id' ";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $Degee_name = $arr['Degee_name']; 
    $Degree_code = $arr['Degree_code'];
    $course_level = $arr['course_level'];
    $ExtDegreeID = $arr['ExtDegreeID'];
	
	
	
    // GET FORM DATA
 if (isset($_POST['submit'])) {
        
	$DegreeName = $_POST['DegreeName'];
	$DegreeCode = $_POST['Degree_code'];
    $courseLevel = $_POST['course_level'];
	$degreeId = $_GET["degree_id"];
    $ExtDegree_ID = $_POST['ExtDegreeID'];

//if else conditons are added by Sayali Balkawade for SMC-2195 . For proper validation of Degree Name And Degree Code		 
if($Degree_code == $DegreeCode && DegreeName==$DegreeName )
{
	

	$r = "update tbl_degree_master set Degee_name='$DegreeName', Degree_code= '$DegreeCode', course_level= '$courseLevel', ExtDegreeID= '$ExtDegree_ID' where id='$degreeId'";
	//echo "<script>alert('123') </script>";

}
else if($Degree_code == $DegreeCode || $DegreeName==$DegreeName)

{
	

	$r = "update tbl_degree_master set Degee_name='$DegreeName', Degree_code= '$DegreeCode', course_level= '$courseLevel', ExtDegreeID= '$ExtDegree_ID' where id='$degreeId'";
	//echo "<script>alert('123') </script>";

}

else
{
$sql1 = mysql_query("SELECT school_id,Degee_name,Degree_code FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and  Degee_name='$DegreeName'");
$count=mysql_num_rows($sql1);

$sql2 = mysql_query("SELECT school_id,Degee_name,Degree_code FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and  Degree_code='$DegreeCode'");
$count1=mysql_num_rows($sql2);

if ($count > 0 && $count1 > 0 ) 
{
	
	
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update tbl_degree_master set Degee_name='$DegreeName', Degree_code= '$DegreeCode', course_level= '$courseLevel', ExtDegreeID= '$ExtDegree_ID' where id='$degreeId'"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_degree.php';
                        </script>");
        } else 
		{
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("SELECT school_id,Degee_name FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and Degree_code='$DegreeCode'");




if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

      
    ?>

	
	
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">




	

<!--End-->

    </head>
    <body align="center">
    <div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div style="padding:2px -20px 122px -42px;border:0px solid #CCCCCC; border:0px solid #CCCCCC;box-shadow: 0px 1px 1px 1px #C3C3C4;">
                <div class="container">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:0px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div style="background-color:#F8F8F8 ;">
                                <div class="row">
                                    <div class="col-md-12 " align="center" style="color:#663399;">
                                        <h2>Update <?php echo $dynamic_degree;?></h2>
                                    </div>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_degree;?> name<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="DegreeName" id="Degee_name" value="<?php echo $Degee_name;?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrDegreename; ?></span>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_degree;?> code<span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="Degree_code" id="Degree_code" value="<?php echo $Degree_code; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrDegreecode; ?></span>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_level;?><span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <select name="course_level"  class="form-control" >
										
                                            <option value="" disabled selected> Select <?php echo $dynamic_level;?></option>
                                            <?php
                                            $sql = "SELECT * FROM `tbl_CourseLevel` WHERE `school_id`='$sc_id'";
                                            $query = mysql_query($sql);
                                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                                <option value="<?php echo $rows['CourseLevel']; ?>" <?php if($rows['CourseLevel']==$course_level){ echo "selected";}else{}?>><?php echo $rows['CourseLevel'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $Errcourselevel; ?></span>
                                </div>

                               <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_degree;?> ID<span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="ExtDegreeID" id="ExtDegreeID" value="<?php echo $ExtDegreeID; ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrExtDegreeID; ?></span>
                                </div>

                                <div class="row" style="padding-top:60px;">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-1"><input type="submit" name="submit" value="Update" class="btn btn-success" onClick ="return valid()"></div>
                                    <div class="col-md-1"><a href="list_school_degree.php"><input type="button" value="Back" class="btn btn-danger"></a></div>
                                </div>

                                <div class="row" style="padding:30px;padding-left:450px;">
                                    <div class="col-md-4" style="color:#F00;" align="center" id="error">
                                        <b><?php echo $errorreport; ?></b>
                                    </div>
                                </div>
                                <div class="row" style="padding:30px;padding-left:450px;">
                                    <div class="col-md-4" style="color:#008000;" align="center" id="error">
                                        <b><?php echo $report; ?></b>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
    </html>
<?php } ?>
<?php 
}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript">
			//Validation for Degree name is done by Sayali Balkawade for id SMC-2195 
		 function valid() {
			  var Degee_name = document.getElementById("Degee_name").value;
        var pattern = /^[a-zA-Z-_\&\. ]+$/;
		if(Degee_name.trim()=="" || Degee_name.trim()==null)
		{

			alert("Please enter <?php echo $dynamic_degree;?> Name!");

		return false;
		}
        if (pattern.test(Degee_name)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{

        alert("It is not valid <?php echo $dynamic_degree;?> Name!");

		return false;
		}
		
		  var Degree_code = document.getElementById("Degree_code").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
		if(Degree_code.trim()=="" || Degree_code.trim()==null)
		{
			alert("Please enter <?php echo $dynamic_degree;?> code!");
		return false;
		}
        if (pattern.test(Degree_code)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("It is not valid <?php echo $dynamic_degree;?> Code!");
		return false;
		}
	/*	 var course_level=document.getElementById("course_level").value;
	  if(course_level==null || course_level=="" || course_level== "Select")
		{
		alert("Please course level");
		return false;
		}
*/
		  var ExtDegreeID = document.getElementById("ExtDegreeID").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
		if(ExtDegreeID.trim()=="" || ExtDegreeID.trim()==null)
		{
			alert("Please enter <?php echo $dynamic_degree;?> ID!");
		return false;
		}
        if (pattern.test(ExtDegreeID)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("It is not valid <?php echo $dynamic_degree;?> ID!");
		return false;
		}
			
	}
</script>

	





