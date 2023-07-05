<?php
//ini_set('max_execution_time', -1); //300 seconds = 5 minutes
//ini_set('memory_limit','16M');

include 'conn.php';


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
$inputFileName = 'discussdesk4.xlsx'; 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}



$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet); 

for($i=2;$i<=$arrayCount;$i++){
$id = trim($allDataInSheet[$i]["A"]);
$student_id = trim($allDataInSheet[$i]["B"]);
$SemesterScore = trim($allDataInSheet[$i]["C"]);
$Academic_Score = trim($allDataInSheet[$i]["D"]);
$DivisionId = trim($allDataInSheet[$i]["E"]);
$Semesterid = trim($allDataInSheet[$i]["F"]);
$BranchId = trim($allDataInSheet[$i]["G"]);
$DepartmentId = trim($allDataInSheet[$i]["H"]);
$AcademicYearId = trim($allDataInSheet[$i]["I"]);
$SchoolId = trim($allDataInSheet[$i]["J"]);
$UpdatedBy = trim($allDataInSheet[$i]["K"]);
$IsCurrentSemester = trim($allDataInSheet[$i]["L"]);
$BranchName = trim($allDataInSheet[$i]["M"]);
$Specialization = trim($allDataInSheet[$i]["N"]);
$DeptName = trim($allDataInSheet[$i]["O"]);
$CourseLevel = trim($allDataInSheet[$i]["P"]);
$SemesterName = trim($allDataInSheet[$i]["Q"]);
$AcdemicYear = trim($allDataInSheet[$i]["R"]);
$DivisionName = trim($allDataInSheet[$i]["S"]);

/* $query = "SELECT max(id) FROM StudentSemesterRecord";
$sql = mysql_query($query);
$recResult = mysql_fetch_array($sql);
$existName = $recResult["id"];
//if($existName=="" && $student_id!="") { */
//if($student_id!="") {
$insertTable= mysql_query("INSERT INTO `StudentSemesterRecord` (`id`, `student_id`, `SemesterScore`, `DivisionId`, `Semesterid`, `BranchId`, `DepartmentId`, `AcademicYearId`, `school_id`, `UpdatedBy`, `IsCurrentSemester`, `BranchName`, `Specialization`, `DeptName`, `CourseLevel`, `SemesterName`, `AcdemicYear`, `DivisionName`, `Academic_Score`) VALUES (NULL,'".$student_id."','".$SemesterScore."','".$DivisionId."','".$Semesterid."','".$BranchId."','".$DepartmentId."','".$AcademicYearId."','".$SchoolId."','".$UpdatedBy."','".$IsCurrentSemester."','".$BranchName."','".$Specialization."','".$DeptName."','".$CourseLevel."','".$SemesterName."','".$AcdemicYear."','".$DivisionName."','".$Academic_Score."');");

$msg = 'Record has been added. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
/* } else {
$msg = 'Record already exist. <div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
} */
}

echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
 

?>
<body>
</html>