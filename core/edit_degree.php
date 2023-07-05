

<?php
ob_start();
/*
 * @auther(changes) Rohit Pawar rohitp@roseland.com <9595512151>
 * @description Edit Degree
 * @date 07/09/2017
 * */
include("scadmin_header.php");
// For Delete Record
if (isset($_GET["delete_id"])) {
    $delete_id=$_GET['delete_id'];
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
    $sql1 = "delete from tbl_degree_master where id='$delete_id' and school_id='$sc_id' ";
    $row = mysql_query($sql1);
    header('Location: ' ."/core/list_school_degree.php" );
}
// Update Record
if (isset($_GET["degree_id"])) {
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
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
		 
if($Degree_code == $DegreeCode)
{
	

	$r = "update tbl_degree_master set Degee_name='$DegreeName', Degree_code= '$DegreeCode', course_level= '$courseLevel', ExtDegreeID= '$ExtDegree_ID' where id='$degreeId'";
	//echo "<script>alert('123') </script>";

}
else
{
$sql1 = mysql_query("SELECT school_id,Degee_name,Degree_code FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and Degree_code ='$DegreeCode' ");
$count=mysql_num_rows($sql1);


if ($count > 0) 
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
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("SELECT school_id,Degee_name FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and Degree_code='$DegreeCode'");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

       /* if ($ExtDegreeID != '' && $course_level != '' && $Degree_code != ''&& $Degee_name != '' ) {
            $sql = mysql_query("SELECT school_id,Degee_name FROM `tbl_degree_master` WHERE `school_id`='$sc_id' and `CourseLevel`='$Degee_name' ");
            $row = mysql_fetch_row($sql);
            if ($row != '') {
                $errorreport = "This degree is already present ";
            } else {

                if(mysql_query(" update tbl_degree_master set Degee_name='$Degee_name', Degree_code= '$Degree_code', course_level= '$course_level', ExtDegreeID= '$ExtDegreeID' where id='$degree_id'")){
                    //$report="Updated degree  successfully";
					echo ("<script LANGUAGE='JavaScript'>
					alert('Updated degree  successfully');
					window.location.href='list_school_degree.php';
					</script>");
                }else{
                    $errorreport="Please Try Again";
                }
            }
        } else {
            $errorreport = "All fields are requird";
        }
    }*/
    ?>

	
	
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">




	<script>
	function formvalidation()
			{
				 var name1 = /^[a-zA-Z ]+$/; 
				 var code=/^[a-zA-Z0-9-]+$/;
			   var DegreeName = document.getElementById("DegreeName").value;	
	           var dcode = document.getElementById("Degree_code").value;
			     var did1 = document.getElementById("ExtDegreeID").value;
			    
//Degree Name
		if(DegreeName.trim()=="" || DegreeName.trim()==null)
				{
					alert("Degree name should be proper");
						return false;
				}	
	   if ((DegreeName == "") || (DegreeName == null))
			  {
				  alert("Degree Name is mandatory");
				//myform.myname.focus();
			   return false;
			  }
	    if(name1.test(DegreeName)== false)
			   {
					alert(" Degree Name should be character only");
					return false;
				}


//Degree code
			if(dcode.trim()=="" || dcode.trim()==null)
					{
						alert("Degree code should be proper");
							return false;
					}	
		     if ((dcode == "") || (dcode == null))
				  {
					  alert("Degree code is mandatory");
					//myform.myname.focus();
				   return false;
				  }
				if(code.test(dcode)== false)
			   {
					alert(" Enter valid Degree code");
					return false;
				}
			  

//Degree Id
              if(did1.trim()=="" || did1.trim()==null)
					{
						alert("Degree ID should be proper");
							return false;
					}	
		     if ((did1 == "") || (did1 == null))
				  {
					  alert("Degree ID is mandatory");
					//myform.myname.focus();
				   return false;
				  }
			  }

           
	</script>



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
                                        <h2>Update Degree</h2>
                                    </div>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;">Degree name<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="DegreeName" id="DegreeName" value="<?php echo $Degee_name;?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-md-offset-5"  style="color:#F00; text-align: center;">
                                    <span class="error"><?php echo $ErrDegreename; ?></span>
                                </div>

                                <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"> Degree code<span
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
                                    <div class="col-md-2" style="color:#808080; font-size:18px;"> Course level<span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <select name="course_level"  class="form-control" >
										
                                            <option value="" disabled selected> Select Course Level</option>
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
                                    <div class="col-md-2" style="color:#808080; font-size:18px;">Degree ID<span
                                            style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="ExtDegreeID" id="ExtDegreeID" value="<?php echo $ExtDegreeID; ?>">
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

<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript">
			
		 function valid() {
			  var Degee_name = document.getElementById("Degee_name").value;
        var pattern = /^[a-zA-Z0-9 ]+$/;
		if(Degee_name.trim()=="" || Degee_name.trim()==null)
		{
			alert("Please enter Degee Name!");
		return false;
		}
        if (pattern.test(Degee_name)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("It is not valid Degee Name!");
		return false;
		}
		
		  var Degree_code = document.getElementById("Degree_code").value;
        var pattern = /^[a-zA-Z0-9-_ ]+$/;
		if(Degree_code.trim()=="" || Degree_code.trim()==null)
		{
			alert("Please enter Degree code!");
		return false;
		}
        if (pattern.test(Degree_code)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("It is not valid Degree Code!");
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
			alert("Please enter DegreeID!");
		return false;
		}
        if (pattern.test(ExtDegreeID)) {
           // alert("Your your name is : " + name);
           // return true;
        }
		else{
        alert("It is not valid DegreeID!");
		return false;
		}
			
	}
</script>
	
