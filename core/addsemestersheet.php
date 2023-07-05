<?php
include("scadmin_header.php");
$report="";
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$arrs=mysql_fetch_array($results);

			$school_id=$arrs['school_id'];
			
$uploadedStatus = 0;

if ( isset($_POST["submit"]) ) 
{
if ( isset($_FILES["file"])) 
{
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
//echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
echo "<script type=text/javascript>alert('Please Select File'); window.location=''</script>";
}
else {
if (file_exists($_FILES["file"]["name"])) {
unlink($_FILES["file"]["name"]);
}
$storagename= $_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
$uploadedStatus = 1;

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
// This is the file path to be uploaded.
$inputFileName = $storagename; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$reports="";
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  $arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$arr=array();
$email_already=array();
 $j=0;
for($i=2;$i<=$arrayCount;$i++){
$courselevel=trim($allDataInSheet[$i]["A"]);
$semester=trim($allDataInSheet[$i]["B"]);
$branchname=trim($allDataInSheet[$i]["C"]);
$deptname=trim($allDataInSheet[$i]["D"]);
$semestercredit=trim($allDataInSheet[$i]["E"]);
$isregular=trim($allDataInSheet[$i]["F"]);
$isenable=trim($allDataInSheet[$i]["G"]);
$school_id=trim($allDataInSheet[$i]["H"]);
$ExtBranchId=trim($allDataInSheet[$i]["I"]);
$ExtSemesterId=trim($allDataInSheet[$i]["J"]);

if($semester=="" or $school_id=="")
{
}
else
{
 $class="";
		if($courselevel=="UG" )
		{
			
			if($semester=="Semester I")
			{
				$class="F.Y.B.Tech";
			}
			else if($semester=="Semester II")
			{
				$class="F.Y.B.Tech";
			}
			else if($semester=="Semester III")
			{
				$class="S.Y.B.Tech";
			}
			else if($semester=="Semester IV")
			{
				$class="S.Y.B.Tech";
			}
			else if($semester=="Semester V")
			{
				$class="T.Y.B.Tech";
			}
			else if($semester=="Semester VI")
			{
				$class="T.Y.B.Tech";
			}
			else if($semester=="Semester VII")
			{
				$class="Final B.Tech";
			}
			else if($semester=="Semester VIII")
			{
				$class="Final B.Tech";
			}
			else 
			{
				$class="";
				
			}
		}
		else if($courselevel=="PG")
		{
			if($semester=="Semester I")
			{
				$class="F.Y.M.Tech.";
			}
			else if($semester=="Semester II")
			{
				$class="F.Y.M.Tech.";
			}
			else if($semester=="Semester III")
			{
				$class="S.Y.M.Tech.";
			}
			else if($semester=="Semester IV")
			{
				$class="S.Y.M.Tech.";
			}
			
			else 
			{
				
				
			}
		}
		else if($courselevel="PG Diploma")
		{
			
			$class="PGD-ERP";
		}
		else
		{
			
		}

/* $rows=mysql_num_rows(mysql_query("select * from tbl_semester_master where Semester_Name='$semester' and  Branch_name='$branchname'  and Department_Name='$deptname' and school_id='$school_id' and class='$class' and CourseLevel='$courselevel'")); */
//and Is_enable='$isenable'
//and Semester_credit='$semestercredit'
// and Is_regular_semester='$isregular'
// and class='$class'
$rows=0;
if($rows==0){
	$sql_insert="INSERT INTO tbl_semester_master(Semester_Name,Branch_name,Semester_credit,Is_regular_semester,Department_Name,school_id,Is_enable,CourseLevel,class,Dept_Id,ExtBranchId,ExtSemesterId) VALUES ('$semester','$branchname','$semestercredit','$isregular','$deptname','$school_id','$isenable','$courselevel','$class','1','$ExtBranchId','$ExtSemesterId')";
		$count = mysql_query($sql_insert) or die(mysql_error()); 
					$j++;
}		
	
				
					$report=$j." records added <br/>";

		
		}
}





}


echo "<script type=text/javascript>alert('file is successfully added'); window.location=''</script>";
} 

else {
$report= "No file selected ";
}
}

?>









<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add semester sheet</title>



</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;" align="center"> <?php echo $report;?></div>
          <div class='panel-heading'>
            <div align="center"> 
                <h3>Add Excel Sheet of Semester</h3>
            </div>
            
               
              </div>
      <div class='panel-body'>
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
          
                  <div class="row">
                    <div class='col-md-8 col-md-offset-5'>
                       
                            <input type='file' name='file'  id='file' size='30' />                        
                    </div>
                    </div>
                 
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-4 col-md-3'>
                                  <input class='btn-lg btn-primary' type='submit'   value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3'>
                                  <a href="addsemester.php"><button class='btn-lg btn-danger'  type='button'>Back</button></a>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' style="color:#FF0000;">
                                  
                                    </div>
                                </div>
                 
         </form>
	</div>
</div>
<div class="row">
<div class="col-md-12 ">
<!--<table cellpadding="4" cellspacing="4" border='1';>


<tr bgcolor="#9900CC" style="height:40px;"><th  bgcolor="#CCCCCC" ><b><center> CourseLevel</center></b></th><th  bgcolor="#CCCCCC" ><center>Semester Name  </center></th><th  bgcolor="#CCCCCC" ><b><center>Branch Name</center></b></th><th  bgcolor="#CCCCCC" ><b><center>Department Name</center></b></th><th  bgcolor="#CCCCCC" ><b><center>Semester credit</center></b></th><th bgcolor="#CCCCCC" ><b><center>Is Regular semester</center></b></th><th  bgcolor="#CCCCCC" ><b><center> Is Enable</center></b></th>
<th  bgcolor="#CCCCCC" ><b><center>school_id</center></b></th>
<th  bgcolor="#CCCCCC" ><b><center>BranchId</center></b></th>
<th  bgcolor="#CCCCCC" ><b><center>SemesterId</center></b></th>

</tr>
</table>-->
</div>
</div>





</body>

</html>
