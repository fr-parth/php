<?php
  include('conn.php'); 
  include("pagination/function.php"); 
 
//check with your logic
if (isset($_FILES["file"])) { 
   
    if($_FILES['file']['error'] == 0){
    $name = $_FILES['file']['name'];
    $ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $type = $_FILES['file']['type'];
    $tmpName = $_FILES['file']['tmp_name'];

    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            //set_time_limit(0);

             $rcount = 0;
             $i = 1;
             $j = 1;
             $row = 0;  
            while(($data = fgetcsv($handle, 1000000, ',')) !== FALSE) {
                // number of fields in the csv
                  $col_count = count($data);
                  $rcount = $i++; 
                
               // print_r($data);
                $schID = $_SESSION['school_id'];    
                
                if($rcount > 1)
                {
                           
                     $className          = chop($data[0],"clas");
                     $classID            = chop($data[1],"class_id");
                     $subject_code       = chop($data[2],"subject_code"); 
                     $subject_name       = chop($data[3],"subject_name"); 
                     $subjectID          = chop($data[4],"subject_id");
                     $subjectType        = chop($data[5],"subject_type");
                     $subjectShortName   = chop($data[6],"subject_short_name");
                     //$subjectCredit      = chop($data[7],"subject_credit");
                     $semesterID         = chop($data[8],"semester_id");
                     $semester           = chop($data[9],"semester");
                     $branchID           = chop($data[10],"branch_id");
                     $branch             = chop($data[11],"branch"); 
                     $deptCode           = chop($data[12],"dept_id"); 
                     $dept               = chop($data[13],"department"); 
                     $schoolID           = $schID;
                     $acdYear            = chop($data[14],"academic_year");
                     $acdYearID          = chop($data[15],"academic_yearID");  
                     $Uploaded_by        = chop($data[16],"Uploaded_by"); 
//                   $batchID            = chop($data[17],"batch_id");  
                     $courseLevel        = chop($data[17],"course_level");   
                     $updatedDate        = date("Y-m-d h:i:sa");
                     
                    
                   $error = 0; 
                   if($className == '' || $classID == '' || $subject_code == '' || $subject_name == '' || $subjectID == '' || $subjectType == '' || $subjectShortName == '' ||  $semesterID == '' || $semester == '' || $branchID == '' || $branch == '' || $deptCode == '' || $dept == '' || $schoolID == '' || $acdYear == '' || $acdYearID == '' || $Uploaded_by == '' || $courseLevel == '')
                   { 
                        $error++;
                        
                       
            $errSql = "SELECT * FROM raw_tbl_class_subject_master WHERE clas='$className' and subject_code='$subject_code' and semester='$semester' and branch='$branch' and department='$dept' and academic_yearID='$acdYearID' and  school_id='$schoolID' and course_level='$courseLevel'";
            
            $res = mysql_query($errSql);
             
            $errResult = mysql_num_rows($res);  
        
            if($errResult =="0"){           
                      
            $ins = "INSERT INTO raw_tbl_class_subject_master(clas,class_id,subject_code,subject_name,subject_id,subject_type,subject_short_name,semester_id,semester,branch_id,branch,dept_id,department,school_id,academic_year,academic_yearID,Uploaded_by,course_level,upload_date)VALUES('$className','$classID','$subject_code','$subject_name','$subjectID','$subjectType','$subjectShortName','$semesterID','$semester','$branchID','$branch','$deptCode','$dept','$schoolID','$acdYear','$acdYearID','$Uploaded_by','$courseLevel','$updatedDate')";
 
                       
            $in = mysql_query($ins);  
                
                if($in)
                { 
                    $er += $error;
                
                }else{
                    
                    echo "failed";
                    
                } 

            }
                       
                   }else{ 
                    
            $sql = "SELECT * FROM tbl_class_subject_master WHERE clas='$className' and subject_code='$subject_code' and semester='$semester' and branch='$branch' and department='$dept' and academic_yearID='$acdYearID' and  school_id='$schoolID' and course_level='$courseLevel'";
            
            $res = mysql_query($sql);
             
            $result = mysql_num_rows($res);  
        
            if($result =="0"){  
              
           $ins = "INSERT INTO tbl_class_subject_master(clas,class_id,subject_code,subject_name,subject_id,subject_type,subject_short_name,semester_id,semester,branch_id,branch,dept_id,department,school_id,academic_year,academic_yearID,Uploaded_by,course_level,upload_date)VALUES('$className','$classID','$subject_code','$subject_name','$subjectID','$subjectType','$subjectShortName','$semesterID','$semester','$branchID','$branch','$deptCode','$dept','$schoolID','$acdYear','$acdYearID','$Uploaded_by','$courseLevel','$updatedDate')";

            $in = mysql_query($ins);  
                
                if($in)
                { 
                    $row++;
                
                }else{
                    
                    echo "failed"; 
                } 

             }else{
              
              $Stuins =  "UPDATE tbl_class_subject_master
                SET   class='$className',clas_id='$classID',subject_code='$subject_code',subject_name='$subject_name',subject_id='$subjectID',subject_type='$subjectType',subject_short_name='$subjectShortName',semester_id='$semesterID',semester='$semester',branch_id='$branchID',branch='$branch',dept_id='$deptCode',department='$dept',school_id='$schoolID',academic_year='$acdYear',academic_yearID='$acdYearID',Uploaded_by='$Uploaded_by',course_level='$courseLevel',upload_date='$updatedDate'
                 
                WHERE clas='$className' and subject_code='$subject_code' and semester='$semester' and branch='$branch' and department='$dept' and academic_yearID='$acdYearID' and  school_id='$schoolID' and course_level='$courseLevel'";
              
              $in = mysql_query($Stuins); 
                 
            }
           }   

        }
           
    } 
            
            if($row == 1)
            {
                 echo '<div class="alert alert-success text-center">'. $row .' - Record Successfully Added</div>';
            }else if($row > 1)
            {
                 echo '<div class="alert alert-success text-center">'. $row .' - Records Successfully Added</div>';
            }
            else{
                 echo '<div class="alert alert-info text-center">Class Subject Data Successfully Updated</div>';
            }
            
//            if($er > 0)
//            {
//                 echo '<div class="alert alert-danger text-center">'.$er.' records failed </div>';
//            }
            
            
            fclose($handle);
        }
    }
}
}
       
        $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 1000; //if you want to dispaly 10 records per page then you have to change here
    	$startpoint = ($page * $limit) - $limit;
        $statement = "raw_tbl_class_subject_master order by id asc"; //you have to pass your query over here 
 
       $query = ("SELECT class,class_id,subject_code,subject_name,subject_id,subject_type,subject_short_name,subject_credit,semester_id,semester,branch_id,branch,dept_id,department,school_id,academic_year,academic_yearID,Uploaded_by,course_level,upload_date FROM {$statement} LIMIT {$startpoint} , {$limit}");
 
                   $que = mysql_query($query); 
  
                   $output .= '
                   
                            <table class="table table-bordered text-center" style="position:relative;right:290px; id="mytable"> 
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Class</th>
                                  <th>Class Id</th>
                                  <th>Subject Code</th>
                                  <th>Subject Name</th>
                                  <th>Semester</th> 
                                  <th>Branch</th> 
                                  <th>Department</th>
                                  <th>School Id</th>
                                  <th>Academiv Year</th>
                                  <th>Course Level</th>
                                  <th>Uploaded By</th> 
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++;
                       
                        
                       if($row > 0)
                       { 
                           
                           $output .= '

                                   <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$row['class'].'</td> 
                                       <td>'.$row['class_id'].'</td>
                                       <td>'.$row['subject_code'].'</td> 
                                       <td>'.$row['subject_name'].'</td> 
                                       <td>'.$row['semester'].'</td>
                                       <td>'.$row['branch'].'</td> 
                                       <td>'.$row['department'].'</td> 
                                       <td>'.$row['school_id'].'</td>
                                       <td>'.$row['academic_year'].'</td>
                                       <td>'.$row['course_level'].'</td>
                                       <td>'.$row['Uploaded_by'].'</td> 
                                   </tr>

                           ';  
                        }else{
                           
                           echo "Data Not Found";
                           
                           echo $output .= '

                                   <tr>
                                       <td>Data Not Found</td>
                                        
                                   </tr>

                           ';
                       }
                        
                    } 

 echo '<div class="alert alert-danger text-center"> '.$i.' records failed </div>';

                      $output .= '</table>';
 
                       echo $output; 
 ?>
 
<?php
        echo "<div id='pagingg'>"; 
          echo pagination($statement,$limit,$page);
        echo "</div>";
?>