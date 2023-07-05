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

if ( isset($_POST["submit"]) ) {
if ( isset($_FILES["file"])) {
//if there was an error uploading the file
if ($_FILES["file"]["error"] > 0) {
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
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
$CourseLevelPID=trim($allDataInSheet[$i]["A"]);
 $DeptID=trim($allDataInSheet[$i]["B"]);
$BranchID=trim($allDataInSheet[$i]["C"]);
$SemesterID=trim($allDataInSheet[$i]["D"]);
$DevisionId=trim($allDataInSheet[$i]["E"]);
$Intruduce_YeqarID=trim($allDataInSheet[$i]["F"]);
$SubjectTitle=trim($allDataInSheet[$i]["G"]);
$SubjectCode=trim($allDataInSheet[$i]["H"]);
$SubjectType=trim($allDataInSheet[$i]["I"]);
$SubjectShortName=trim($allDataInSheet[$i]["J"]);
$IsEnable=trim($allDataInSheet[$i]["K"]);
$CourseLevel=trim($allDataInSheet[$i]["L"]);
$DeptName=trim($allDataInSheet[$i]["M"]);
$BranchName=trim($allDataInSheet[$i]["N"]);
$SemesterName=trim($allDataInSheet[$i]["O"]);
$DivisionName=trim($allDataInSheet[$i]["P"]);
$Year=trim($allDataInSheet[$i]["Q"]);

 
  
	 $sql_insert="INSERT INTO Branch_Subject_Division_Year(school_id,CourseLevelPID,DeptID,BranchID,SemesterID,DevisionId,Intruduce_YeqarID,SubjectTitle,SubjectCode,SubjectType,SubjectShortName,IsEnable,UpdatedBy,CourseLevel,DeptName,BranchName,SemesterName,DivisionName,Year) VALUES ('55','$CourseLevelPID','$DeptID','$BranchID','$SemesterID','$DevisionId','$Intruduce_YeqarID','$SubjectTitle','$SubjectCode','$SubjectType','$SubjectShortName','$IsEnable','','$CourseLevel','$DeptName','$BranchName','$SemesterName','$DivisionName','$Year')";
					$count = mysql_query($sql_insert) ; 
					$j++;
					$report=$j." records added";
	
					
					 
	
		
	
}





}

} else {
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
                                  <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' style="color:#FF0000;">
                                  
                                    </div>
                                </div>
                 
         </form>
	</div>
</div>
</div>
<div class="row" style="margin-left:10px;">

<table cellpadding="4" cellspacing="4" >


<tr bgcolor="#9900CC" style="height:40px;"><th  bgcolor="#CCCCCC" style="width:100px;"><b><center> CourseLevelPID</center></b></th><th  bgcolor="#CCCCCC" style="width:250px;"><center>DeptID  </center></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center>BranchID</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center>SemesterID</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center>DevisionId</center></b></th><th bgcolor="#CCCCCC" style="width:200px;"><b><center>YearID</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> SubjectTitle</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> SubjectCode</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> SubjectType</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> SubjectShortName</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> IsEnable</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> CourseLevel</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> DeptName</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> BranchName</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> SemesterName</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> DivisionName</center></b></th><th  bgcolor="#CCCCCC" style="width:200px;"><b><center> Year</center></b></th></tr>
</table>

</div>





</body>

</html>
