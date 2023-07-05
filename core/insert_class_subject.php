<?php  
    include('conn.php'); 

        if(isset($_POST['clas']))
        {   
            $dept                    = $_POST['dept'];
            $deptID                  = $_POST['deptID']; 
            $branch                  = $_POST['branch'];
            $branchID                = $_POST['branchID'];
            $semester                = $_POST['sem'];
            $semesterID              = $_POST['semID'];
            //$classs                  = $_POST['classs'];
            $classID                 = $_POST['clasID'];
            $className               = $_POST['clas']; 
            $batchID                 = $_POST['batchID']; 
            $subject_name            = $_POST['subj'];
            $subject_code            = $_POST['subjectCode'];
            $subjectID               = $_POST['subjectID']; 
            $subjectType             = $_POST['subjectType'];
            //$subjectCredit           = $_POST['subject_credit'];
            $subjectShortName        = $_POST['subShortName'];
            $Uploaded_by             = $_POST['subUploadBy'];
            $schoolID                = $_POST['schoolID'];
            $acdYear                 = $_POST['acd_year'];
            $acdYearID               = $_POST['acd_yearID'];
            $courseLevel             = $_POST['courLev'];
            $updatedDate             = date("Y-m-d h:i:sa"); 
        if($className==''){
             echo "<script>alert('Please enter a class parameter')</script>";
            }
        
        else
        {
            $sql = "SELECT * FROM tbl_class_subject_master WHERE class='$className' and subject_code='$subject_code' and semester_id='$semesterID' and branch='$branch' and department='$dept' and academic_yearID='$acdYearID' and  school_id='$schoolID' and course_level='$courseLevel'";
            
            $res = mysql_query($sql);
         
            $result = mysql_num_rows($res);
            //changed below code for SMC-5283 by Chaitali on 28-04-2021
            $data = array();
            if($result =="0"){ 
                 
//            $ins = "INSERT INTO tbl_class_subject_master(clas,class_id,subject_code,subject_name,subject_id,subject_type,subject_short_name,semester_id,semester,branch_id,branch,dept_id,department,school_id,academic_year,academic_yearID,batch_id,uploaded_by,course_level,uploaded_date)VALUES('$className','$classID','$subject_code','$subject_name','$subjectID','$subjectType','$subjectShortName','$semesterID','$semester','$branchID','$branch','$deptID','$dept','$schoolID','$acdYear','$acdYearID','$batchID','$Uploaded_by','$courseLevel','$updatedDate')";

//Changed class column in below queries by Pranali for SMC-5006
                //changed field from upload_date to uploaded_date by Pranali as class subject not added at test environment
        $ins = "INSERT INTO tbl_class_subject_master(class,class_id,subject_code,subject_name,subject_id,subject_type,subject_short_name,semester_id,semester,branch_id,branch,dept_id,department,school_id,academic_year,academic_yearID,batch_id,uploaded_by,course_level,uploaded_date)VALUES('$className','$classID','$subject_code','$subject_name','$subjectID','$subjectType','$subjectShortName','$semesterID','$semester','$branchID','$branch','$deptID','$dept','$schoolID','$acdYear','$acdYearID','$batchID','$Uploaded_by','$courseLevel','$updatedDate')";
                
            $in = mysql_query($ins);  
           // echo "Class Subject is successfully added";    
                
           



                if($in)
                {
                    $data['status'] = 'Class Subject is successfully added';
                }else{ 
                    $data['status'] = 'Class Subject not added'; 
                } 
                
        }else{
                 
            // $Stuins =  "UPDATE tbl_class_subject_master
            //         SET class='$className',class_id='$classID',subject_code='$subject_code',subject_name='$subject_name',subject_id='$subjectID',subject_type='$subjectType',subject_short_name='$subjectShortName',semester_id='$semesterID',semester='$semester',branch_id='$branchID',branch='$branch',dept_id='$deptCode',department='$dept',school_id='$schoolID',academic_year='$acdYear',academic_yearID='$acdYearID',batch_id='$batchID',Uploaded_by='$Uploaded_by',course_level='$courseLevel',upload_date='$updatedDate'

            //         WHERE class='$className' and subject_code='$subject_code' and semester_id='$semesterID' and branch='$branch' and department='$dept' and academic_yearID='$acdYearID' and  school_id='$schoolID' and course_level='$courseLevel'";

            //         $in = mysql_query($Stuins);

            //      if($in){

            //           echo "Class Subject is successfully updated";
            //      }
            //      else{
            //         echo "Class Subject not updated";
            //      }

           // $data['status'] = $subject_name." class subject is already added";
             $data['status'] = "<script>alert('Please enter a class parameter')</script>";
            }  

            echo json_encode($data);
            
         }
    
    }
?>