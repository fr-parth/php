<?php
//Add & Edit page merged on the same page- Rutuja Jori on 20/11/2019
include('scadmin_header.php');
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);

//school_id taken from session by Pranali for SMC-5007
$sc_id = $_SESSION['school_id'];

 if(isset($_GET["class"])=='')
 {
if (isset($_POST['submit'])) {
	$Class = $_POST['Class'];
	 $ClassID = $_POST['ClassID'];
	 $CourseLevel = $_POST['CourseLevel'];
/*
    if (empty($_POST["Class"])) {
        $ErrClass = "Class Name is required";
    } else {
        $Class = $_POST['Class'];
    }


    if (empty($_POST["ClassID"])) {
        $ErrClassID = "ClassID  is required";
    } else {
        $ClassID = $_POST['ClassID'];
      //  echo ClassID;
    }


    if (empty($_POST["CourseLevel"])) {
        $ErrCourseLevel = "CourseLevel is required";
    } else {
        $CourseLevel = $_POST['CourseLevel'];
    }


    if ($Class != '' && $ClassID != '' && $CourseLevel != '') 
	{
*/		
        $sql = mysql_query("SELECT school_id,class FROM `Class` WHERE `school_id`='$sc_id' and `class`='$Class'");
        $row = mysql_fetch_row($sql);
        if ($row != '') 
		{
            $errorreport = "This Class is already present ";
        } 
		else {
			
            if(mysql_query("INSERT INTO `Class` (ExtClassID,school_id,class,course_level) VALUES ('$ClassID','$sc_id','$Class','$CourseLevel')"))
			{
               // $report="Inserted data successfully";
				echo ("<script LANGUAGE='JavaScript'>
					window.alert('Data Added successfully');
					window.location.href='list_school_class.php';
				</script>");
				
            }
			else
			{
                $errorreport="Please Try Again";
            }
        }
    }
	
?>
<script>
function valid()
{// Validation code updated by Rutuja Jori to accept space while adding Class/Team on 04/01/2019 for SMC-4382
	regx1=/^[A-z0-9\.\- ]+$/;
var Class = document.getElementById("Class").value;
		if(Class.trim()=="" || Class.trim()==null)
            {

                document.getElementById('errorClass').innerHTML='Please Enter <?php echo $dynamic_class;?>';

                return false;
            }

               else if(!regx1.test(Class))
                {
                document.getElementById('errorClass').innerHTML='Please Enter valid <?php echo $dynamic_class;?>';
                    return false;
                }
				else
			{
				document.getElementById('errorClass').innerHTML='';	
			}
			regx1=/^[0-9 ]+$/;			
			var ClassID = document.getElementById("ClassID").value;
		if(ClassID.trim()=="" ||ClassID.trim()==null )
            {

                document.getElementById('errorClassID').innerHTML='Please Enter <?php echo $dynamic_class;?> ID';

                return false;
            }
               else if(!regx1.test(ClassID))
                {
                document.getElementById('errorClassID').innerHTML='Please Enter valid <?php echo $dynamic_class;?> ID';
                    return false;
                }
				else
			{
				document.getElementById('errorClassID').innerHTML='';	
			}
			 regx1=/^[A-z ]+$/;	
			var CourseLevel = document.getElementById("CourseLevel").value;
			if(CourseLevel.trim()=="" ||CourseLevel.trim()==null)
			{
                document.getElementById('errorCourseLevel').innerHTML='Please Enter <?php echo $dynamic_level;?>';
                return false;
            }

               else if(!regx1.test(CourseLevel))
                {
                document.getElementById('errorCourseLevel').innerHTML='Please Enter valid <?php echo $dynamic_level;?>';
                    return false;
                }
					else
			{
				document.getElementById('errorCourseLevel').innerHTML='';	
			}
	/*
			regx1=/^[0-9A-z_- ]+$/;		
				var Batch_ID = document.getElementById("Batch_ID").value;
			if(Batch_ID.trim()=="" || Batch_ID.trim()==null)
            {

                document.getElementById('errorBatch_ID').innerHTML='Please Enter Batch ID';

                return false;
            }

        
              else if(!regx1.test(Batch_ID))
                {
                document.getElementById('errorBatch_ID').innerHTML='Please Enter valid Batch ID';
                    return false;
                }	
						else
			{
				document.getElementById('errorerrorBatch_ID').innerHTML='';	
			}
		*/		
}

</script>
<html>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div class="container" style="padding:25px;">
        <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <form method="post">
                <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                        <div class="col-md-12 " align="center" style="color:#663399;">
                            <h2>Add <?php echo $dynamic_class;?></h2>
                        </div>
                    </div>

                    <div class="row" style="padding-top:30px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_class;?><span
                                    style="color:red;font-size: 25px;">*</span></div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="Class" id="Class" placeholder="Enter <?php echo $dynamic_class;?>" value="">
                        </div>
						<div class='col-md-4 indent-small' id="errorClass" style="color:#FF0000">
                  </div>
                    </div>
					
					
                       
				  <!--
                    <div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00; text-align: center;">
                        <span class="error"><?php// echo $ErrClass; ?></span>
                    </div>
-->
                    <div class="row" style="padding-top:30px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_class;?> ID<span
                                    style="color:red;font-size: 25px;">*</span></div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="ClassID" id="ClassID" placeholder="Enter <?php echo $dynamic_class;?> ID" value="">
                        </div>
						<div class='col-md-4 indent-small' id="errorClassID" style="color:#FF0000">
                  </div>
                    </div>
					
                       
					<!--	
                    <div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00; text-align: center;">
                        <span class="error"><?php //echo $ErrClassID; ?></span>
                    </div>
						
                    <div class="row" style="padding-top:30px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-2" style="color:#808080; font-size:18px;"> CourseLevel<span
                                    style="color:red;font-size: 25px;">*</span></div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="CourseLevel" id="CourseLevel" placeholder="Enter Course Level" value="">
                        </div>
						<div class='col-md-4 indent-small' id="errorCourseLevel" style="color:#FF0000">
                  </div>
                    </div>
				-->	
					   <div class="row" style="padding-top:30px;">
                <div class="col-md-4"></div>
                <div class="col-md-2" style="color:#808080; font-size:18px;"> <?php echo $dynamic_level;?><span
                            style="color:red;font-size: 25px;">*</span></div>
                <div class="col-md-3">
                    <select name="CourseLevel" id="CourseLevel" class="form-control" required>
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
					
<!--
                    <div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00; text-align: center;">
                        <span class="error"><?php //echo $ErrCourseLevel; ?></span>
                    </div>
-->
					
			
                       
<!--
                    <div class="col-md-4 col-md-offset-5" id="errordept" style="color:#F00; text-align: center;">
                        <span class="error"><?php// echo $ErrBatchID; ?></span>
                    </div>
	-->				
                    <div class="row" style="padding-top:35px;padding-left:350px;">
                        <div class="col-md-2 col-md-offset-2 ">
                            <input type="submit" class="btn btn-success" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid();" />
                        </div>

                        <div class="col-md-3 " align="left">
                            <a href="list_school_class.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
                        </div>

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
</body>
</html>

<?php }else{
	
	 $class_id = $_GET["class"];
        $sql1 = "select * from Class where id='$class_id'";
        $row = mysql_query($sql1);
        $arr = mysql_fetch_array($row);
        $class = $arr['class']; 
        $ClassID = $arr['ExtClassID'];
        $CourseLevel = $arr['course_level'];
        $id = $_SESSION['id'];
        $fields = array("id" => $id);
        $table = "tbl_school_admin";
        $smartcookie = new smartcookie();
        $results = $smartcookie->retrive_individual($table, $fields);
        $result = mysql_fetch_array($results);
        $sc_id = $_SESSION['school_id'];
		
		
		
		
		
        // GET FORM DATA
        if (isset($_POST['submit'])) {
            $class_new = $_POST['class'];
		    $Class = $_POST['ClassName']; 
			$ClassID = $_POST['ClassID'];
			$CourseLevel = $_POST['CourseLevel'];
				
				
				
				
if($class == $Class)
{
	

	$r = "update Class set class='$Class', ExtClassID = '$ClassID' ,course_level='$CourseLevel' where id='$class_id' ";
	//echo "<script>alert('123') </script>";

}
else
{
$sql1 = mysql_query("SELECT school_id,class FROM Class WHERE school_id='$sc_id' and class='$Class'");
$count=mysql_num_rows($sql1);


if ($count > 0) 
{
	
	
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update Class set class='$Class', ExtClassID = '$ClassID' ,course_level='$CourseLevel' where id='$class_id'"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_class.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("SELECT school_id,class FROM Class WHERE school_id='$sc_id' and class='$Class'");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

					
				
				
				
				
				
				
				
				
				
				
				
				
               /* $sql = mysql_query("SELECT school_id,class FROM Class WHERE school_id='$sc_id' and class='$Class'");
                $row = mysql_num_rows($sql);
                if ($row != '') {
                    $errorreport = "This Class is already present ";
                } else {

                   

                    if(mysql_query("update Class set class='$Class', ExtClassID = '$ClassID' ,course_level='$CourseLevel' where id=$class_id")){
                       echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_class.php';
                        </script>");
                    }else{

                        $errorreport="Please Try Again";
                    }
                }
           
        }
	}
			*/ ?>
		<script>
function valid()
{
	//alert("hi"); die;
	regx1=/^[A-z0-9\.\- ]+$/;
var ClassName = document.getElementById("ClassName").value;
		if(ClassName.trim()==""||ClassName.trim()==null)
            {

                document.getElementById('errorClass').innerHTML='Please Enter Class';

                return false;
            }

               else if(!regx1.test(ClassName))
                {
                document.getElementById('errorClass').innerHTML='Please Enter valid <?php echo $dynamic_class;?>';
                    return false;
                }
				else
			{
				document.getElementById('errorClass').innerHTML='';	
			}
			regx1=/^[0-9]+$/;			
	var ClassID = document.getElementById("ClassID").value;
			if(ClassID.trim()==""||ClassID.trim()==null)
            {

                document.getElementById('errorClassID').innerHTML='Please Enter <?php echo $dynamic_class;?> ID';

                return false;
            }
               else if(!regx1.test(ClassID))
                {
                document.getElementById('errorClassID').innerHTML='Please Enter valid <?php echo $dynamic_class;?> ID';
                    return false;
                }
				else
			{
				document.getElementById('errorClassID').innerHTML='';	
			}
			
			
}		
		</script>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
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
                                            <h2>Update <?php echo $dynamic_class;?></h2>
                                        </div>
                                    </div>

                                    <div class="row" style="padding-top:30px;">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:18px;"> <?php echo $dynamic_class;?>:<span
                                                    style="color:red;font-size: 25px;">*</span></div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="ClassName" id="ClassName" placeholder="Enter <?php echo $dynamic_class;?>" value="<?php echo $class;?>">
                                        </div>
										<div class='col-md-4 indent-small' id="errorClass" style="color:#FF0000">
										</div>
                                    </div>

                                    

                                    <div class="row" style="padding-top:30px;">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:13px;"> <?php echo $dynamic_class;?> ID:<span
                                                    style="color:red;font-size: 25px;">*</span></div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="ClassID" id="ClassID" placeholder="Enter <?php echo $dynamic_class;?> ID" value="<?php echo $ClassID; ?>" style="margin-left:3px;">
                                        </div>
										<div class='col-md-4 indent-small' id="errorClassID" style="color:#FF0000">
                                       </div>
                                    </div>

									 <div class="row " style="padding-top:30px;" >
									 <div class="col-md-4"></div>
               <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:13px;"> <?php echo $dynamic_level;?>  <span style="color:red;font-size: 25px;">*</span>
               </div>
               <div class="col-md-3">
               <?php
          
			   $query1=mysql_query("select distinct  CourseLevel from tbl_CourseLevel where school_id='$sc_id'");
			 ?>
			 
             <select name="CourseLevel" id="CourseLevel" class="form-control" onChange="MyAlert(this.value)">
             <!-- <option value=<?php //echo $arr['course_level'];?>><?php //echo $arr['course_level'];?></option>
              -->
<!--Commented above code and added if condition for keeping the option selected by Pranali for SCM-5007-->
			 
                <?php
			 while($result1=mysql_fetch_array($query1))
			 { ?>
			 
			
               <option value=<?php echo $result1['CourseLevel'];?>
                <?php 
                if($arr['course_level']==$result1['CourseLevel'])
                    echo "selected";
                ?> >
                <?php echo $result1['CourseLevel'];?></option>
			 
			 <?php }?>
             
             </select>
			 <div class='col-md-4 indent-small' id="errorCourseLevel" style="color:#FF0000">
                                        </div>
                </div>
              
                  </div>
<!--Update and back button colour changed by Pranali for SMC-5007 -->
                                    <div class="row" style="padding-top:35px;padding-left:350px;">
                                        <div class="col-md-2 col-md-offset-2 ">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update" style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid();" />
                                        </div>

                                        <div class="col-md-3 " align="left">
                                            <a href="list_school_class.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
                                        </div>

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
   	
<?php	
}	

 ?>