
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






$StudentRegCode=trim($allDataInSheet[$i]["A"]); 
	
				$SemesterScore=trim($allDataInSheet[$i]["B"]);   //Semester_ID
				$Academic_Score=trim($allDataInSheet[$i]["C"]);   // Subject code
				$DivisionId=trim($allDataInSheet[$i]["D"]);   // subject title
				$Semesterid=trim($allDataInSheet[$i]["E"]);   // Branch ID 
				$BranchId=trim($allDataInSheet[$i]["F"]);   // Degree name 
				$DepartmentId=trim($allDataInSheet[$i]["G"]);   // Subject Type 
				
				$AcademicYearId=trim($allDataInSheet[$i]["H"]);   //Semester_ID
				$SchoolId=trim($allDataInSheet[$i]["I"]);   // Subject code
				$UpdatedBy=trim($allDataInSheet[$i]["J"]);   // subject title
				$IsCurrentSemester=trim($allDataInSheet[$i]["K"]);   // Branch ID 
				$BranchName=trim($allDataInSheet[$i]["L"]);   // Degree name 
				$Specialization=trim($allDataInSheet[$i]["M"]);   // Subject Type 
				
																						 
													
				$DeptName=trim($allDataInSheet[$i]["N"]);   //Semester_ID
				$CourseLevel=trim($allDataInSheet[$i]["O"]);   // Subject code
				$SemesterName=trim($allDataInSheet[$i]["P"]);   // subject title
				$AcdemicYear=trim($allDataInSheet[$i]["Q"]);   // Branch ID 
				$DivisionName=trim($allDataInSheet[$i]["R"]);   // Degree name 
							  
				                				 
				
			 	
				
				
																						
				
				
				echo "INSERT INTO `StudentSemesterRecord` (student_id,SemesterScore,Academic_Score,DivisionId,Semesterid,BranchId,DepartmentId,AcademicYearId,school_id,UpdatedBy,IsCurrentSemester,BranchName,Specialization,DeptName,CourseLevel,SemesterName,AcdemicYear,DivisionName)
										VALUES ('$StudentRegCode','$SemesterScore','$Academic_Score','$DivisionId','$Semesterid','$BranchId','$DepartmentId','$AcademicYearId','$SchoolId','$UpdatedBy','$IsCurrentSemester','$BranchName','$Specialization','$DeptName','$CourseLevel','$SemesterName','$AcdemicYear','$DivisionName')";die;
										
                                        
										$sql_insert1="INSERT INTO `StudentSemesterRecord` (student_id,SemesterScore,Academic_Score,DivisionId,Semesterid,BranchId,DepartmentId,AcademicYearId,school_id,UpdatedBy,IsCurrentSemester,BranchName,Specialization,DeptName,CourseLevel,SemesterName,AcdemicYear,DivisionName)
										VALUES ('$StudentRegCode','$SemesterScore','$Academic_Score','$DivisionId','$Semesterid','$BranchId','$DepartmentId','$AcademicYearId','$SchoolId','$UpdatedBy','$IsCurrentSemester','$BranchName','$Specialization','$DeptName','$CourseLevel','$SemesterName','$AcdemicYear','$DivisionName')";

					
					 
	$result_insert1 = mysql_query($sql_insert1) or die(mysql_error());
		
		
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
<script type="text/javascript">

   
   var _validFileExtensions = [".xlsx", ".xls", ".xlsm", ".xlw", ".xlsb",".xml",".xlt"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//js/jquery-1.10.2.js"></script>
  <script src="//js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/js/style.css">
<style>
H3{
	 text-align: center;
color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;

background-color:grey;
width: 25%;
line-height:30px;
}
H5{
 text-align: center;
 color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;
background-color:grey;
width:35%;
line-height:30px;
}
</style>

<script>
  $(function() {
    $( "#dialog" ).dialog();
  });
  </script>
</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>
             
                <h3>Add Subject Excel Sheet</h3>
            
            
               
              </div>
			
			
      <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
   		<form name='frm' method='post' enctype='multipart/form-data' id='frm'>
        
          
                  <div class='form-group'>
				  <div class="assignlimit">
                                  <div class="assign-limit">
                                        <form method="post" action="#">
                                        	<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left: 430px;">
                                              <option value="20" disabled selected>Set upload Records Limit</option>
											  <option value="1">1</option>
											  <option value="4">4</option>
											  <option value="20">20</option>
											  <option value="40">40</option>
											  <option value="60">60</option>
											  <option value="80">80</option>
											  <option value="100">100</option>
											  <option value="120">120</option>
											  <option value="500">500</option>
                                              <option value="1000">1000</option>
                                              <option value="1500">1500</option>
                                              <option value="2500">2500</option>
                                              <option value="5000">5000</option>
                                              <option value="15000">15000</option>
                                              <option value="20000">20000</option>
                                              <option value="25000">25000</option>
                                              <option value="30000">30000</option>
											</div>
											</div>
											</form>
                  		<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>
                    <div class='col-md-4'>
                        <div class='col-md-2' style="padding-left:100px">
                            <input type='file' name='file' id='file' onChange="ValidateSingleInput(this);" style="margin-left:455px;margin-top:20px"/>                          </div> 
                    </div>
                  </div>
                  <div style="height:50px;"></div>
                  <div class='form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">
                                  <button type="cancel" class='btn-lg btn-danger' onclick="javascript:window.location='list_school_subject.php'">Cancel</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">
									 	
                                    <?php 
									echo $report;
									//echo $no_rows;
									
									?>
									
            
            
               
                                     </div>
                                    </div>
                                </div>
                 
         </form>
		 
		 
		 
		 
		 
		 
	</div>
	  
	
</div>







<div class="row">
<div class="col-md-1"></div>
<div class="col-md-12 ">
<table cellpadding="12" cellspacing="6" align="center">
<tr bgcolor="#9900CC">

<th bgcolor="#CCCCCC">School ID</th>
<th bgcolor="#CCCCCC">Semester Name</th>
<th bgcolor="#CCCCCC">Subject Code</th>
<th bgcolor="#CCCCCC">Subject Name</th>
<th bgcolor="#CCCCCC">Branch Name</th>
<th bgcolor="#CCCCCC">Degree Name</th>
<th bgcolor="#CCCCCC">Subject Type</th>


<tr>


</table>
</div>
</div>





</body>

</html>
