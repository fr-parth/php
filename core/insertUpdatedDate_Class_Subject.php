<?php 

include("conn.php");
ob_end_clean();
if(isset($_POST['user_id']))
{    
    $subjName           = trim($_POST['subject_name']);   
    $str_arr            = explode (",", $subjName);  
    $subName     = $str_arr[0];
    $subCode     = $str_arr[1];
    $subType     = $str_arr[2];
    $subShorName = $str_arr[3];
    $uploadBy    = $str_arr[4]; 
    $batchID     = $str_arr[5];
    
    $seme                = trim($_POST['semester']); 
    $sem                 = explode (",", $seme);  
    $semester       = $sem[0];
    $semesterID     = $sem[1];
    
    $courseLevel       = trim($_POST['course_level']); 
    
    $acadYear               = trim($_POST['academic_year']);
    $acYear                 = explode (",", $acadYear);  
    $acdYear       = $acYear[0];
    $acdYearID     = $acYear[1];
     
    $uID               = trim($_POST['user_id']);

    //echo $acdYear;
    //echo $courseLevel;echo $seme;
    
//    $data = array(
//    $subCode           => $_POST['subject_code'],
//    $subName           => $_POST['subject_name'],
//    $subType           => $_POST['subject_type'],
//    $subShorName       => $_POST['subject_short_name'],
//    $semesterID        => $_POST['semester_id'],
//    $semester          => $_POST['semester'],
//    $branchID          => $_POST['branch_id'],
//    $branch            => $_POST['branch'],
//    $deptID            => $_POST['dept_id'],
//    $dept              => $_POST['department'],
//    $schoolID          => $_POST['school_id'],
//    $courseLevel       => $_POST['course_level'],
//    $acdYear           => $_POST['academic_year'],
//    $acdYearID         => $_POST['academic_yearID'],
//    $uploadBy          => $_POST['uploaded_by'],
//    $uID               => $_POST['user_id']
//    );
//    
//    print_r($data);exit;
    
//    $query = mysql_query("UPDATE tbl_class_subject_master SET subject_code = '$subCode' , subject_name = '$subName' , subject_type = '$subType' , subject_short_name = '$subShorName' , semester_id = '$semesterID' , semester = '$semester' , branch_id = '$branchID' , branch = '$branch' , dept_id = '$deptID' , department = '$dept' , school_id = '$schoolID' , course_level = '$courseLevel' , academic_year = '$acdYear' , academic_yrearID = '$acdYearID' , uploaded_by = '$uploadBy'  WHERE id = $uID");
      //,academic_year='$acdYear',academic_yrearID='$acdYearID'
       

    $query = mysql_query("UPDATE tbl_class_subject_master SET subject_name='$subName',subject_code='$subCode',subject_type='$subType',subject_short_name='$subShorName',uploaded_by='$uploadBy',batch_id='$batchID',semester_id='$semesterID',semester='$semester',course_level='$courseLevel',academic_year='$acdYear',academic_yearID='$acdYearID' WHERE id='$uID'");
    
     if($query)
      {
          echo "Class subject updated successfully";
      
      }else{
          
          echo "Updation Failed";
      }
    
   
    exit;
}

?>  