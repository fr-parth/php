<?php
    $class = "";
    include("scadmin_header.php");
    if (isset($_GET["class"])) {
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
        $sc_id = $result['school_id'];
		
		
		
		
		
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
	regx1=/^[A-z0-9\.\-]+$/;
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
             <option value=<?php echo $arr['course_level'];?>><?php echo $arr['course_level'];?></option>
             
			 
			 
                <?php
			 while($result1=mysql_fetch_array($query1))
			 { ?>
			 
			
               <option value=<?php echo $result1['CourseLevel'];?>><?php echo $result1['CourseLevel'];?></option>
			 
			 <?php }?>
             
             </select>
			 <div class='col-md-4 indent-small' id="errorCourseLevel" style="color:#FF0000">
                                        </div>
                </div>
              
                  </div>

                                    <div class="row" style="padding-top:35px;padding-left:350px;">
                                        <div class="col-md-2 col-md-offset-2 ">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Update" style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid();" />
                                        </div>

                                        <div class="col-md-3 " align="left">
                                            <a href="list_school_class.php" style="text-decoration:none;"><input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
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
   

