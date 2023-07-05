<?php  
 
defined('BASEPATH') OR exit('No direct script access allowed');

class TeachersActivity extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
       
        $this->load->model('Teacher'); 
         
    } 
    
    //activity drop down 
    public function depatTeacherName()
    {  
        $deptName  = $_POST['depts'];
        $empType   = $_POST['empType'];  
        $activityList = $_POST['activityList'];
        $school_id = $this->session->userdata('school_id');
        $t_id      = $this->session->userdata('t_id');
        
        if($activityList=='society'  && $empType == '135'){
            $data['teacherDeptName'] = $this->Teacher->getTeacherHodsociety($deptName,$school_id);
            
        }
        
         else if($empType == '133' || $empType == '134')
        {
            $data['teacherDeptName'] = $this->Teacher->getTeacherNameUsDeptName($deptName,$school_id,$t_id); 
           
        }else if($empType == '135'){
            
            $data['teacherDeptName'] = $this->Teacher->getTeacherHod($deptName,$school_id); 
            
        }else if($empType == '137'){
            
            $data['teacherDeptName'] = $this->Teacher->getTeacherNameUsDeptNameAll($deptName,$school_id);   
            
        } 

        echo '<option value="" selected="selected">Select Teacher</option>';  
        foreach($data['teacherDeptName'] as $row)
        { 
           $t = $row->t_complete_name;
           $t_id1 = $row->t_id;
           $t_emp_type_pid=$row->t_emp_type_pid;
           


              echo '<option value="'.$t_id1.','.$t.','.$t_emp_type_pid.'">'.$t.'</option>'; 
          
        } 
        

    } 
    
    //dept teachersName
    public function depatTeacherNameSemester()
    { 
        $deptName  = $_POST['deptName'];
        $school_id = $this->session->userdata('school_id');
        
        $data['teacherDeptSemester'] = $this->Teacher->getTeacherNameUsDeptSem($deptName,$school_id);
        
        //print_r($data['teacherDeptSemester']);////$sem->Semester_Id."-".$sem->Semester_Name."-".$sem->clid."-".$sem->CourseLevel;
        echo '<option value="" selected="selected">Select Semester</option>'; 
        foreach($data['teacherDeptSemester'] as $row)
        { 
            
          $sid        = $row->Semester_Id;
          $sName      = $row->Semester_Name;    
          $sCourLev   = $row->CourseLevel; 
            
          echo '<option value='.$sid.','.$sCourLev.'>'.$sName. " , " .$sCourLev.'</option>';
           
        } 
        
    }
    
    
    public function teachingProSem()
    {  
        $subName  = $_POST['subjectName'];
        $school_id = $this->session->userdata('school_id');
     
        $data['semName'] = $this->Teacher->getTeacheSubjectSem($subName,$school_id);
        
        foreach($data['semName'] as $row)
        { 
            
          $sem = $row->Semester_id;
          
          echo '<option value="'.$sem.'">'.$sem.'</option>';
           
        } 
        
    } 
 
    
    public function fetchdata()
    {  
        $t_id       = $this->session->userdata('t_id');
        $school_id  = $this->session->userdata('school_id');
        $list       = $_POST['activityList'];
      $acad=$this->session->userdata('current_acadmic_year1'); 
        $year2= $_POST['year'];
        if($year2=='')
        {
          $acadmic_year=$acad;
          
        }
        else
        {         
          $acadmic_year=$year2;
        } 
       //echo $acadmic_year;//exit;
        $row  = $this->Teacher->teacherinfo($t_id,$school_id); 
        $empType = $row[0]->t_emp_type_pid; 
        $tdept   = $row[0]->t_dept; 
        $activityLev =  $list == 'dept_activity' ? ( 1 ) : ( $list == 'institute' ? ( 2 ) : ( $list == 'society' ? ( 3 ): ( 4 )  ) ); 
        
        //below code commented as common function $this->Teacher->fetchSociety() is kept for fetching activities data by Pranali for SMC-4422 on 16-1-20
        
        // if($list == 'society' && $empType == '133' || $empType == '134')
        // {
        //     $data1  = $this->Teacher->fetchSocietyTeacher($school_id,$activityLev,$empType,$t_id); 
            
        // }else if($list == 'society' && $empType == '135'){
            
        //     $data1  = $this->Teacher->fetchSocietyHod($school_id,$activityLev,$empType,$t_id);   
        //     print_r($data1);
            
        // }else if($list == 'society' && $empType == '137'){
            
        //     $data1  = $this->Teacher->fetchSocietyPri($school_id,$activityLev);
            
        // }else{
           
             $data1  = $this->Teacher->fetchSociety($school_id,$activityLev,$t_id,$empType);
        //}

       $output = ''; 
  //Sender Teacher Id and Sender Teacher Name added by Pranali for SMC-4422 on 18-1-20 
        $output.='<div class="myTable">
        
                    <table class="table text-center table-bordered myTable">
                      <tr class="bgTh" style="background-color:#d8cf63;">
                         <th>Sr.No.</th>
                         <th>Course Level</th>
                         <th>Activity Name</th>
                         <th>Sender Teacher Id</th>
                         <th>Sender Teacher Name</th>
                         <th>Receiver Teacher Id</th>
                         <th>Receiver Teacher Name</th>
                         <th>Academic Year</th>
                         <th>Department</th>
                         <th>Image</th> 
                         <th width="15%">Action</th> 
                      </tr>';
 
        if($data1 > 0 || $year1!=$acadmic_year)
        { 
          $count=0;
            $i = 1;
            foreach($data1 as $row) {  
            //print_r($row);exit;
            $depActID = $row->dept_act_id;
            $year1=$row->Academic_Year;
            //print_r($year1);
            $imgAct = $row->act_img; 
            $ex = explode(",",$imgAct);
            $countArray = count($ex); 
            if($countArray > 1)
            { 
                    $mulImg = explode(",",$imgAct);
                    $firstImg  = $mulImg[1];
                
                    $ext       = pathinfo($firstImg,PATHINFO_EXTENSION);
                    if($ext == 'pdf'){
                       $filePdf = base_url().'image/pdf.png'; 
                    }else if($ext == 'docx'){
                        $filePdf = base_url().'image/word.png'; 
 
                    }else if($firstImg != ''){
 
                        $filePdf =  $firstImg;  
                    } 
            }else{ 
                    $firstImg = $imgAct;
                
                    $ext       = pathinfo($firstImg,PATHINFO_EXTENSION);
                     if($ext == 'pdf'){
                       $filePdf = base_url().'image/pdf.png'; 
                    }else if($ext == 'docx'){
                        $filePdf = base_url().'image/word.png';
                    }else{
                        $filePdf =  $firstImg;  
                    } 
            }
            
            //echo $acadmic_year;  
            if($year1==$acadmic_year)
            {
              //echo $acadmic_year;

              $count++;
            $output.='<tr>
                         <td>'.$i++.'</td>
                         <td>'.$row->courselevel_name.'</td>
                         <td>'.$row->activity_name.'</td>
                         <td>'.$row->tID.'</td>
                         <td>'.$row->teacher_name.'</td> 
                         <td>'.$row->Receiver_tID.'</td>
                         <td>'.$row->receiver_teacher_name.'</td>
                         <td>'.$acadmic_year.'</td>
                         <td>'.$row->deptName.'</td>
                         <td class="">
                         
                         <img src="'.$filePdf.'" dept_act_id="'.$depActID.'" class="img-thumbnail imgView" width="50" height="35" data-toggle="modal" data-target="#imgViewModal">
                          
                         </td>
                         <td>
                             <a href="" user_id="'.$depActID.'" class="btn btn-primary btn_edit" id="btn_edit" data-toggle="modal" data-target="#imgViewModaledit">Edit</a>
                             
                             <a href="" user_id="'.$depActID.'" data-id4="'.$depActID.'" class="btn btn-danger btn_delete" name="btn_delete" id="btn_delete">Delete</a>
                             
                         </td> 
                      </tr>';
                    
                    }

            } 
           
        }
        if($count==0){
            
            $output.='<tr>
                           <td colspan="11" style="text-align:center;">No Record found</td>
                      </tr>';
        }
        
        
        $output.='</table>
        </div>';
         
        echo $output;
   
         
    }
    
    
    function techProShow()
    { 
        $year=$_POST['year'];
        $t_id = $this->session->userdata('t_id');  //450717059
        $school_id = $this->session->userdata('school_id');  //COEP  
        $acad=$this->session->userdata('current_acadmic_year1'); 
        $data1  = $this->Teacher->fetchData360feedback_template($school_id,$t_id); 
          //echo $yr1=$this->input->post('acadmic_yr1');exit;
          if($year=='')
        {
          $acadmic_year=$acad;
          
        }
        else
        {
          
          $acadmic_year=$year;
        } 
        $output = ''; 
        
        $output.='<div class="myTable">
        
                    <table class="table text-center table-bordered myTable">
                      <tr class="bgTh" style="background-color:#d8cf63;">
                         <th>Sr.No.</th>
              <th>Semester</th>
                          <th>Subject Code</th>    
              <th>Subject Name</th> 
                          <th>Department Name</th>
                          <th>Academic Year</th>     
              <th>Scheduled_classes</th>
              <th>Actual_classes</th>
                          <th>Image</th>    
                          <th width="15%">Action</th>
                      </tr>';
 
        if($data1 > 0 || $year1!=$acadmic_year)
        { 
          $count=0;
            $i = 0;
            foreach($data1 as $row) {  
            $i++;
            
            $techID = $row->feed360_ID;
            $year1=$row->feed360_academic_year_ID;
            $imgAct = $row->feed360_img; 
            $ex = explode(",",$imgAct);
            $countArray = count($ex); 
            if($countArray > 1)
            { 
                    $mulImg = explode(",",$imgAct);
                    $firstImg  = $mulImg[1];
                
                    $ext       = pathinfo($firstImg,PATHINFO_EXTENSION);
                    if($ext == 'pdf'){
                       $filePdf = base_url().'image/pdf.png'; 
                    }else if($ext == 'docx'){
                        $filePdf = base_url().'image/word.png'; 
                    }else{
                        $filePdf =  $firstImg;  
                    } 
            }else{ 
                    $firstImg = $imgAct;
                
                    $ext       = pathinfo($firstImg,PATHINFO_EXTENSION);
                     if($ext == 'pdf'){
                       $filePdf = base_url().'image/pdf.png'; 
                    }else if($ext == 'docx'){
                        $filePdf = base_url().'image/word.png';
                    }else{
                        $filePdf =  $firstImg;  
                    } 
            }
                
                if($year1==$acadmic_year){
                $count++;                  
             
            $output.='<tr>
                         <td>'.$i.'</td>
                         <td>'.$row->feed360_semester_ID.'</td>
                         <td>'.$row->feed360_subject_code.'</td> 
                         <td>'.$row->feed360_subject_name.'</td>
                         <td>'.$row->feed360_dept_ID.'</td>
                         <td>'.$acadmic_year.'</td>
                         <td>'.$row->feed360_classes_scheduled.'</td>
                         <td>'.$row->feed360_actual_classes.'</td>
                         <td class="">
                         
                         <img src="'.$filePdf.'" tech_act_id="'.$techID.'" class="img-thumbnail imgView" width="50" height="35" data-toggle="modal" data-target="#imgViewModal">
                          
                         
                         </td>
                         <td>
                             <a href="" user_id="'.$techID.'" class="btn btn-primary btn_edit" id="btn_edit" data-toggle="modal" data-target="#updateModalTechPro">Edit</a>
                             
                             <a href="" user_id="'.$techID.'" data-id4="'.$techID.'" class="btn btn-danger btn_delete" name="btn_delete" id="btn_delete">Delete</a>
                             
                         </td> 
                      </tr>';
                    }
            } 
            
        }

        if($count==0){//echo "in else loop";
            
            $output.='<tr>
                           <td colspan="4">Data not found</td>
                      </tr>';
        }
        
        $output.='</table>
        </div>';
         
        echo $output;
   
         
    }
 
    public function addActivityData($list='NULL')  
    {  

 $acad=$this->session->userdata('current_acadmic_year1');
            if(isset($_POST['rating'])) 
        {  
            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx","xlxs");
            $file = array();
            foreach($_FILES["user_userfile"]["tmp_name"] as $key=>$tmp_name) {
                
               $file_name = $_FILES["user_userfile"]["name"][$key];
               $file_tmp  = $_FILES["user_userfile"]["tmp_name"][$key];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
                    
                   $destination  = './image/' . $file_name;  
                   move_uploaded_file($file_tmp=$_FILES["user_userfile"]["tmp_name"][$key],$destination);    
                }
                 
                $str = str_replace("image/" , "" , "$file_name");  
                $items[] = ltrim(base_url().'image/'.$str,',');
            }
            
             $fimg = implode(",",$items); 
         
            $teach_memid            = $this->session->userdata('id');
            $t_id                   = $this->session->userdata('t_id');
            $school_id              = $this->session->userdata('school_id');
            $yeara=$this->input->post('AcademicYear3');

             $teaAcdYear      = $_POST['teacher_academicYear'];
            $teaAcadYer      = explode(",",$teaAcdYear);
             
            $teaAY = $teaAcadYer[1]; 

             $AcadYear  = $teaAcadYer[0];
 
            $deptName = $_POST['dept'];
            //echo $deptName;exit;  
            $dep      = explode(",",$deptName);

            $teacher = $_POST['teacher_name'];
            $tea     = explode(",",$teacher); 


            $activity = $_POST['activity'];
            $act      = explode(",",$activity);

               $actLevelID  = $act[2];

               if($actLevelID == '4')
               {
                   $rating   = $_POST['rating'];

               }else{

                   $rating   = $act[3]; 
               }

               $departmentName = $dep[0];
               $deptDetails    = $this->Teacher->getTeacherDeptDetails($departmentName);
               if($deptDetails > 0)
               {
                  $deptID         = $deptDetails[0]->id;  
               } 
            
               $courLevNa    = $this->Teacher->getCourseLevelName($departmentName,$school_id);
 
               $courLevName = $courLevNa[0]->CourseLevel; 

               $empTypeID      = $dep[1];

               $recTeaID       = $tea[0];     //115
               $recTeaName     = $tea[1]; 

               $actID          = $act[0];
               $actName        = $act[1];
               $actLevID       = $act[2];

               $acdYeardetails = $this->Teacher->aicte_semester($school_id);
               if($acdYeardetails > 0)
               {
                  $year_id        = $acdYeardetails[0]->yearid;
                  $Academic_Year  = $acdYeardetails[0]->Academic_Year;
                  $classID        = $acdYeardetails[0]->clid;
                  $className      = $acdYeardetails[0]->className;   
               }
            $Academic_Year=$acad;
                $row['group_details']   = $this->Teacher->getGroupMemberDetails($school_id);
        
           if($row['group_details'] > 0)
           {
                $group_member_id        = $row['group_details'][0]->group_member_id;
           } 
        
           $recEmpTypedetai       = $this->Teacher->getRecTeaEmpType($recTeaID);
           $recEmpTypedetails     = $recEmpTypedetai->t_emp_type_pid;    
         
           $created_date = CURRENT_TIMESTAMP;
 
           $data = array(  
               
                'activityID'           => $actID,
                'activity_name'        => $actName,
                'tID'                  => $t_id,   
                'Receiver_tID'         => $recTeaID,
                'schoolID'             => $school_id,
                'deptName'             => $departmentName,
                'deptID'               => $deptID, 
                'credit_point'         => $rating, 
                'courselevel_name'     => $courLevName,
                'Academic_YearID'      => $teaAY,
                'Academic_Year'        =>  $Academic_Year,  
                'Class_ID'             => $classID,
                'Class'                => $className, 
                'group_member_id'      => $group_member_id,
                'created_date'         => $created_date,
                'updated_date'         => $created_date, 
                'activity_level_id'    => $actLevID,
                'Emp_type_id'          => $empTypeID,
                'Emp_type_id_receiver' => $recEmpTypedetails,
                'act_img'              => $fimg,
                'receiver_teacher_name'=> $recTeaName 
                ); 
 
              foreach($data as $key=>$value)
                {
                      if(trim($value) =='' || $value == base_url().'image/') 
                        unset($data[$key]);
                }
 
            $IsExist = $this->Teacher->IsExist_360_activities_data1($t_id,$recTeaID,$school_id,$deptID,$actLevID,$Academic_Year);
          
        
            if($IsExist == 'TRUE')
            { 
                echo "Data is already exists";
 
            }else{
                
                    $ins = $this->Teacher->InsertInto360_activities_data($data);
        
                    if($ins){
                      // start SMC-4456 added by Kunal
                      $aicte_360activity_level = $this->Teacher->aicte_360activity_level($actLevelID);
               
                      $data_activity = array("from_entity_id"=>"103","reason_id"=>"1005","point_feedback"=>$aicte_360activity_level->reward_points,"group_id"=>"91");

                      $ch_act = curl_init(base_url("core/Version3/check_referral_act_points.php"));  
              
                      $data_string2 = json_encode($data_activity);    
                      curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                      curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                      curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                      curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                      $result2 = json_decode(curl_exec($ch_act),true);

                      if($result2['responseStatus']=="200"){
                          $refferal_activity = array("Entity_TypeID"=>"103","Key"=>$aicte_360activity_level->actL360_activity_level,"PRN_EmpID"=>$t_id,"SchoolID"=>$school_id);

                          $ref_act = curl_init(base_url("core/Version5/Assign_Reward_Points360_API.php"));  
                        
                        
                          $refferal_string2 = json_encode($refferal_activity);    
                          curl_setopt($ref_act, CURLOPT_CUSTOMREQUEST, "POST");    
                          curl_setopt($ref_act, CURLOPT_POSTFIELDS, $refferal_string2);  
                          curl_setopt($ref_act, CURLOPT_RETURNTRANSFER, true);      
                          curl_setopt($ref_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($refferal_string2)));
                          $res2 = json_decode(curl_exec($ref_act),true);
                      }
                      // print_r($result2); exit;
                      // End SMC-4456 
                      echo "Insertion Successfully";
 
                    }else{

                       echo "Insertion Failed";
 

                         }
                } 
             
        }else{
            
            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx","xlxs");
            $file = array();
            foreach($_FILES["user_userfile"]["tmp_name"] as $key=>$tmp_name) {
                
               $file_name = $_FILES["user_userfile"]["name"][$key];
               $file_tmp  = $_FILES["user_userfile"]["tmp_name"][$key];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
                    
                   $destination  = './image/' . $file_name;  
                   //move_uploaded_file($_FILES['user_userfile']['tmp_name'], $destination); 
                   move_uploaded_file($file_tmp=$_FILES["user_userfile"]["tmp_name"][$key],$destination);    
                }
                
                //$file[] = $file_name;
                $str = str_replace("image/" , "" , "$file_name");  
                $items[] = ltrim(base_url().'image/'.$str,',');
            }
            
            $fimg = implode(",",$items);  

            $teach_memid            = $this->session->userdata('id');
            $t_id                   = $this->session->userdata('t_id');
            $school_id              = $this->session->userdata('school_id');


            $deptName = $_POST['dept']; 
            $dep      = explode(",",$deptName);

            $teacher = $_POST['teacher_name'];
            $tea     = explode(",",$teacher); 
           

            $activity = $_POST['activity'];
            $act      = explode(",",$activity);

               $actLevelID  = $act[2];

               if($actLevelID == '4')
               {
                   $rating   = $_POST['rating'];

               }else{

                   $rating   = $act[3]; 
               }
             

                $semester = $_POST['semester'];
                $sem      = explode(",",$semester);
                   $courLevName    = $sem[1];
                   $semID          = $sem[0];
                   $semDetails     = $this->Teacher->getTeacherSemesterDetails($semID);
                   if($semDetails > 0)
                   {
                      $semName        = $semDetails[0]->Semester_Name; 
                   } 

                   $branchName     = $semDetails[0]->Branch_name;
                   $branchDetails  = $this->Teacher->getTeacherBranchDetails($branchName);
                   if($branchDetails > 0)
                   {
                      $branchID       = $branchDetails[0]->id;  
                   } 

               $departmentName = $dep[0];
               $deptDetails    = $this->Teacher->getTeacherDeptDetails($departmentName);
               if($deptDetails > 0)
               {
                  $deptID         = $deptDetails[0]->id;  
               } 

               $empTypeID      = $dep[1];

               $recTeaID       = $tea[0];     //115
               $recTeaName     = $tea[1]; 

               $actID          = $act[0];
               $actName        = $act[1];
               $actLevID       = $act[2];

               $acdYeardetails = $this->Teacher->aicte_semester($school_id);
           // print_r($acdYeardetails);
               if($acdYeardetails > 0)
               {
                  $year_id        = $acdYeardetails[0]->aid;
                 $Academic_Year  = $acdYeardetails[0]->Academic_Year;
                  $classID        = $acdYeardetails[0]->clid;
                  $className      = $acdYeardetails[0]->className;   
               }
                $Academic_Year=$acad;
               $row['group_details']   = $this->Teacher->getGroupMemberDetails($school_id);
        
               if($row['group_details'] > 0)
               {
                    $group_member_id        = $row['group_details'][0]->group_member_id;
               } 

                $recEmpTypedetai      = $this->Teacher->getRecTeaEmpType($recTeaID);
                $recEmpTypedetails    = $recEmpTypedetai->t_emp_type_pid;  


               $created_date = CURRENT_TIMESTAMP;
            
            
              $data = array(
                'semesterID'           => $semID,
                'semester_name'        => $semName,
                'activityID'           => $actID,
                'activity_name'        => $actName,
                'tID'                  => $t_id,
                'Receiver_tID'         => $recTeaID,
                'schoolID'             => $school_id,
                'deptName'             => $departmentName,
                'deptID'               => $deptID,
                'credit_point'         => $rating,
                'branch_id'            => $branchID,
                'branch_name'          => $branchName,  
                'courselevel_name'     => $courLevName,
                'Academic_YearID'      => $year_id,
                'Academic_Year'        =>  $Academic_Year, 
                'Class_ID'             => $classID,
                'Class'                => $className, 
                'group_member_id'      => $group_member_id,
                'created_date'         => $created_date,
                'updated_date'         => $created_date, 
                'activity_level_id'    => $actLevID,
                'Emp_type_id'          => $empTypeID,
                'Emp_type_id_receiver' => $recEmpTypedetails,
                'act_img'              => $fimg,
                'receiver_teacher_name'=> $recTeaName 
                );
               
              // print_r($data);
                foreach($data as $key=>$value)
                { 
                      if(trim($value) =='' || $value == base_url().'image/')
                        unset($data[$key]);
                }
             
 
               $IsExist = $this->Teacher->IsExist_360_activities_data($semID,$t_id,$recTeaID,$school_id,$deptID,$actLevID,$courLevName,$Academic_Year); 
          
        
            if($IsExist == 'TRUE')
            {  
                echo "Data is already exists";  
                
            }else{
                
                    $ins = $this->Teacher->InsertInto360_activities_data($data);
        
                    if($ins){
                      // start SMC-4456 added by Kunal
                      $aicte_360activity_level = $this->Teacher->aicte_360activity_level($actLevelID);
                      $data_activity = array("from_entity_id"=>"103","reason_id"=>"1005","point_feedback"=>$aicte_360activity_level->reward_points,"group_id"=>"91");

                      $ch_act = curl_init(base_url("core/Version3/check_referral_act_points.php"));  
                      
                      $data_string2 = json_encode($data_activity);    
                      curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                      curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                      curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                      curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                      $result2 = json_decode(curl_exec($ch_act),true);
                      
                      if($result2['responseStatus']=="200"){
                          $refferal_activity = array("Entity_TypeID"=>"103","Key"=>$aicte_360activity_level->actL360_activity_level,"PRN_EmpID"=>$t_id,"SchoolID"=>$school_id);

                          $ref_act = curl_init(base_url("core/Version5/Assign_Reward_Points360_API.php"));  
                        
                        
                          $refferal_string2 = json_encode($refferal_activity);    
                          curl_setopt($ref_act, CURLOPT_CUSTOMREQUEST, "POST");    
                          curl_setopt($ref_act, CURLOPT_POSTFIELDS, $refferal_string2);  
                          curl_setopt($ref_act, CURLOPT_RETURNTRANSFER, true);      
                          curl_setopt($ref_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($refferal_string2)));
                          $res2 = json_decode(curl_exec($ref_act),true);
                         // print_r($res2); exit;
                      }
                      // End SMC-4456
                       echo "Insertion Successfully";
 
                    }else{

                       echo "Insertion Failed";
 
                         }
                   }
             
              } 
               
        }
    
    public function updateDataTeaProAtImgDel()
    {
         $deptID = $_POST['user_id'];  
        
           $feImage = $this->Teacher->fetchTeachImagesAfDel($deptID);
         
            foreach($feImage as $row)
            {
               $img = $row->feed360_img;
               $exp = explode(",",$img);

            } 
        
        foreach($exp as $key=>$value)
        {
            if(trim($value) =='' || $value == base_url().'image/')
            unset($exp[$key]);
        }
        
        
            foreach($exp as $r)
            {
                 $r1 = $r;

                 if($r1 != '')
                 {
                        $ext       = pathinfo($r1,PATHINFO_EXTENSION);

                        $filePdf = base_url().'image/pdf.png';

                        $fileword = base_url().'image/word.png';
                                             
                     if($ext == 'pdf'){

                        echo $img1 = '
                                  <div>    
                                   <img id="myImg" src="'.$filePdf.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                   <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                  </div>
                                  ';

                    }else if($ext == 'docx'){
                        
                        echo $img1 = '
                                   <div>
                                     <img id="myImg" src="'.$fileword.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                        
                    }else{
                        
                        echo $img1 = '
                                    <div>
                                     <img id="myImg" src="'.$r1.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn cImg btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                    }
                     
                      

                 }
                 
                
            }
    }
          
    
    public function updateData()
    { 
 
           $deptID = $_POST['user_id'];  
        
           $feImage = $this->Teacher->fetchActivitiesImagesEdit($deptID);
         
            foreach($feImage as $row)
            {
               $img = $row->act_img;
               $exp = explode(",",$img);

            }
 
        
        foreach($exp as $key=>$value)
        {
            if(trim($value) =='' || $value == base_url().'image/')
            unset($exp[$key]);
        }
        
        
            foreach($exp as $r)
            {
                 $r1 = $r;

                 if($r1 != '')
                 {
                        $ext       = pathinfo($r1,PATHINFO_EXTENSION);

                        $filePdf = base_url().'image/pdf.png';

                        $fileword = base_url().'image/word.png';
                                             
                     if($ext == 'pdf'){

                        echo $img1 = '
                                  <div>    
                                   <img id="myImg" src="'.$filePdf.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                   <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                  </div>
                                  ';

                    }else if($ext == 'docx'){
                        
                        echo $img1 = '
                                   <div>
                                     <img id="myImg" src="'.$fileword.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                        
                    }else{
                        
                        echo $img1 = '
                                    <div>
                                     <img id="myImg" src="'.$r1.'" techPro_id="'.$deptID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$deptID.'" techImg_Url="'.$r1.'" class="btn cImg btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                    }
                     
                      

                 }
                 
                
            }
         
        
    }
       
    
    public function updateDataTeaPro()
    { 
         $teaID = $_POST['user_id'];  
     
         $feImage = $this->Teacher->fetchActivitiesImagesEditTeaPro($teaID);
  
                              $semID     = $feImage[0]->feed360_semester_ID;
                              $subName   = $feImage[0]->feed360_subject_name;
                              $subCode   = $feImage[0]->feed360_subject_code;
                              $deptID    = $feImage[0]->feed360_dept_ID;
                              $schdCla   = $feImage[0]->feed360_classes_scheduled;
                              $actCla    = $feImage[0]->feed360_actual_classes;
                              $img       = $feImage[0]->feed360_img;
        
        if($img != ''){
        
                              $exp = explode(",",$img); 
                          
           foreach($exp as $r)
            {
                 $r1 = $r;

                 if($r1 != '')
                 {
                     
                    $ext       = pathinfo($r1,PATHINFO_EXTENSION); 
                                             
                    $filePdf = base_url().'image/pdf.png';
                
                    $fileword = base_url().'image/word.png'; 
 
                    if($ext == 'pdf'){

                        $img1[] = '
                                  <div>    
                                   <img id="myImg" src="'.$filePdf.'" techPro_id="'.$teaID.'" class="img-thumbnail" width="100" height="80">
                                   <button techPro_id="'.$teaID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                  </div>
                                  ';

                    }else if($ext == 'docx'){
                        
                        $img1[] = '
                                   <div>
                                     <img id="myImg" src="'.$fileword.'" techPro_id="'.$teaID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$teaID.'" techImg_Url="'.$r1.'" class="btn btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                        
                    }else{
                        
                        $img1[] = '
                                    <div>
                                     <img id="myImg" src="'.$r1.'" techPro_id="'.$teaID.'" class="img-thumbnail" width="100" height="80">
                                     <button techPro_id="'.$teaID.'" techImg_Url="'.$r1.'" class="btn cImg btn-xs cImg">Delete</button>
                                    </div>
                                    ';
                    }
 
                         }else{ 
                             // echo "NO IMAGE"; 

                         } 
                    }
 

                               $return_arr[] = array(
                                        "feed360_semester_ID"         => $semID,
                                        "feed360_subject_name"        => $subName,
                                        "feed360_subject_code"        => $subCode,
                                        "feed360_dept_ID"             => $deptID,
                                        "feed360_classes_scheduled"   => $schdCla,
                                        "feed360_actual_classes"      => $actCla,
                                        "feed360_img"                 => $img1 
                                        );
        
                             
                        // Encoding array in JSON format
                        echo json_encode($return_arr); 
                        exit; 
            
        }else{
            
                       $return_arr[] = array(
                                        "feed360_semester_ID"         => $semID,
                                        "feed360_subject_name"        => $subName,
                                        "feed360_subject_code"        => $subCode,
                                        "feed360_dept_ID"             => $deptID,
                                        "feed360_classes_scheduled"   => $schdCla,
                                        "feed360_actual_classes"      => $actCla,
                                        "feed360_img"                 => 'No_Image' 
                                        );
         

                        // Encoding array in JSON format
                        echo json_encode($return_arr); 
                        exit; 
        }
    }
    
    
    //upadate teaching process 360degree
    public function updateDataTeaProInsertDB()
    { 
        if(isset($_POST['user_id']))
        {
           $extension=array("jpeg","jpg","png","gif","pdf","doc","docx");
            $file = array();
 
               $file_name = $_FILES["user_userfile1"]["name"];
               $file_tmp  = $_FILES["user_userfile1"]["tmp_name"];
 
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
                    
                   $destination  = './image/' . $file_name;  
 
                   move_uploaded_file($file_tmp=$_FILES["user_userfile1"]["tmp_name"],$destination);    
 
                }
               
                $str = str_replace("image/" , "" , "$file_name");  
                $items[] = ltrim(base_url().'image/'.$str,',');
 
          
            $id = $_POST['user_id'];
            
            $fimg = implode(",",$items); 
            
                        $fetchImg = $this->Teacher->fetchImagesteacPro($id);
      
                         foreach($fetchImg as $data)
                         {
                             $imgStr = $data->feed360_img;  
                         }
                             $strArr = explode(",",$imgStr); 
                            
                          
                                 foreach($strArr as $key=>$value)
                                    {
                                          if(trim($value) == $fimg)
                                            unset($strArr[$key]);
                                    }
                               
                         
            
                    if($fimg == base_url().'image/')
                       {
                          $strImg = implode(",",$strArr); 
                       }else{
                            $strImg = implode(",",$strArr).",".$fimg; 
                       }
  
            

                   $scheduleCla = $_POST['schedule_class'];
                   $actCla      = $_POST['actual_class']; 
                   $teaId       = $_POST['user_id']; 

 
                  $data = array(
            
                    "feed360_classes_scheduled" => $scheduleCla,
                    "feed360_actual_classes"    => $actCla, 
                    "feed360_img"               => $strImg 

                    );
            
                      
                    }
 
                        $updateTeaPro = $this->Teacher->UpdateInto360_teachPro_data($teaId,$data);

                        if($updateTeaPro > 0){

                              echo "Updated Successfully";

                        }else{ 
                               echo "Updated Successfully";
                             } 
 
           }  
  
    
    //update 360degree activitiesdata
    public function updateUserData() 
    {   
        if(isset($_POST['userid'])){
            
             $depUserID = $_POST['userid'];  
             $extension=array("jpeg","jpg","png","gif","pdf","doc","docx");
             $file = array();
            
               $file_name = $_FILES["user_userfile1"]["name"];
               $file_tmp  = $_FILES["user_userfile1"]["tmp_name"];
 
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
 
                   $destination  = './image/' . $file_name;  
                   
                   move_uploaded_file($file_tmp=$_FILES["user_userfile1"]["tmp_name"],$destination);    
                }
               
                $str = str_replace("image/" , "" , "$file_name");  
                $items[] = ltrim(base_url().'image/'.$str,',');
         
            
                 $fimg = implode(",",$items);
         
           
                        $fetchImg = $this->Teacher->fetchImagesteacProDeptAcrCS($depUserID);
             
                         foreach($fetchImg as $data)
                         {
                             $imgStr = $data->act_img;  
                         }
            
                             if($imgStr == '')
                             {
                                 $strImg =  $fimg;  
                             }else{
                                 
                                     $strArr = explode(",",$imgStr);  
                          
                                     foreach($strArr as $key=>$value)
                                        {
                                              if(trim($value) == $fimg)
                                                unset($strArr[$key]);
                                        }

                                     $strImg = implode(",",$strArr).",".$fimg; 
                             }
                
        
        $data = array(
        
            'act_img'   =>  $strImg
        );
         
                    foreach($data as $key=>$value)
                    {
                          if(trim($value) == base_url().'image/')
                            unset($data[$key]);
                    }
             
         
                $update = $this->Teacher->UpdateInto360_activities_data($depUserID,$data);
        
                if($update){

                  echo "Updated Successfully";
 
                }else{

                   echo "No Changes";
 
                      }
        }
 
    }
    
    public function deleteData()
    { 
        $id = $_POST['user_id']; 
        $this->Teacher->deleteData($id);
        echo "Data deleted successfully";
        exit;
    }
    
    public function deleteDataTechPro()
    { 
        $id = $_POST['user_id']; 
        $this->Teacher->deleteDataTechPro($id);
        echo "Data deleted successfully";
        exit;
    }
    
 
    public function ActImageDisplayTech()  //teaching process
    {
        $techID = $_POST['techId'];
        
        //echo '<button tech_id="'.$techID.'" id="addImg" class="btn btn-xs" data-toggle="modal" data-target="#addImgeView">Add</button>';
 
        $feImage = $this->Teacher->fetchActivitiesImagesTechPro($techID);
        
        foreach($feImage as $row)
        {
           $img = $row->feed360_img;
 
           $exp = explode(",",$img); 
        } 
 
        
        foreach($exp as $r)
        {
             $r1 = $r;
            
            if($r1 != '')
            {
                
                    $ext     = pathinfo($r1,PATHINFO_EXTENSION);

                     $filePdf = base_url().'image/pdf.png';
 
                     $fileword = base_url().'image/word.png';  
                 
                  if($ext == 'pdf'){ 

                        echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$filePdf.'" class="img-thumbnail" width="100" height="80"></a>';

                    }else if($ext == 'docx'){
                        
                        echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$fileword.'" class="img-thumbnail" width="100" height="80"></a>';
                        
                    }else{
                        
                         echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$r1.'" class="img-thumbnail" width="100" height="80"></a>';
                    }
                
            }else{
 
                //echo "NO IMAGE";
                
            }
           
        } 
        
       exit;
    }
    
    public function ImageDisplayTechProDelete()
    { 
          $id     = $_POST['techId'];
          $imgUrl = $_POST['techImgUrl'];
    
          $fetchImg = $this->Teacher->fetchImagesteacPro($id);
      
         foreach($fetchImg as $data)
         {
             $imgStr = $data->feed360_img;  
             
             $strArr = explode(",",$imgStr); 
             
             $arr = array();
             foreach($strArr as $key=>$value)
              {
                 if($imgUrl == $value)
                 {
                      $Tstr = str_replace($value, "", $imgStr);
                      $st = explode(",",$Tstr);
                     
                      foreach($st as $key=>$value)
                      {
                           if(trim($value) =='')
                           unset($st[$key]);
                      }
                      
                 }
              }
             
              $imp = implode(",",$st);
             
              $data = array(
              
                 'feed360_img' => $imp
              );
             
              $fetchImg = $this->Teacher->updateImageView($data,$id);
             
              if($fetchImg)
              {
                  echo "Deleted Successfully";
                  
              }else{
                  
                  echo "Delete Failed";
              }
 
            
         } 
        
    }
    
    public function DelImageDisplayAct()
    {
          $id     = $_POST['techId'];
          $imgUrl = $_POST['techImgUrl'];
    
          $fetchImg = $this->Teacher->fetchImagesAct($id);
      
         foreach($fetchImg as $data)
         {
             $imgStr = $data->act_img;  
             
             $strArr = explode(",",$imgStr); 
             
             $arr = array();
             foreach($strArr as $key=>$value)
              {
                 if($imgUrl == $value)
                 {
                      $Tstr = str_replace($value, "", $imgStr);
                      $st = explode(",",$Tstr);
                     
                      foreach($st as $key=>$value)
                      {
                           if(trim($value) =='')
                           unset($st[$key]);
                      }
                      
                 }
              }
             
              $imp = implode(",",$st);
             
              $data = array(
              
                 'act_img' => $imp
              );
              
              $fetchImg = $this->Teacher->updateImageViewAct($data,$id);
             
              if($fetchImg)
              {
                  echo "Deleted Successfully";
                  
              }else{
                  
                  echo "Delete Failed";
              }
 
            
         }   
    }
    
    public function ImageDisplayTechProAdd()
    { 
        echo $id     = $_POST['techId']; 
    }
    
    public function finalAddImageFromView()
    {
            $id = $_POST['tech_id'];
        
            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx");
            $file = array();
        
               $file_name = $_FILES["add_Image"]["name"];
               $file_tmp  = $_FILES["add_Image"]["tmp_name"];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
                    
                   $destination  = './image/' . $file_name;    
                    
                   move_uploaded_file($file_tmp=$_FILES["add_Image"]["tmp_name"],$destination);    
                }
                 
                $str = str_replace("image/" , "" , "$file_name");  
                $items = ltrim(base_url().'image/'.$str,',');
        
                     $fetchImg = $this->Teacher->fetchImagesteacPro($id);
      
                         foreach($fetchImg as $data)
                         {
                             $imgStr = $data->feed360_img;  
                         }
                             $strArr = explode(",",$imgStr); 
 
                             $arr = array();
                             foreach($strArr as $key=>$value)
                              { 
                                 if($value == $items)
                                 {    
                                      echo "Image Exists";     
                                     
                                 }else{ 
                                            $addImage = $imgStr.','.$items;

                                            $data = array(

                                                     'feed360_img' => $addImage
                                                 );


                                            $re = $this->Teacher->addImagesteacProView($id,$data);

                                              if($re > 0)
                                               {
                                                   echo "Added Successfully"; 
                                               } 
                                 }
                      } 
                     
           }
 
 
    
    public function ActImageDisplay()
    {
        $deptID = $_POST['deptId'];
        
        $feImage = $this->Teacher->fetchActivitiesImages($deptID);
        
        foreach($feImage as $row)
        {
           $img = $row->act_img;
           $exp = explode(",",$img);
          
        }
        
        foreach($exp as $r)
        {
             $r1 = $r;
            
            if($r1 != '')
            {
                
                    $ext     = pathinfo($r1,PATHINFO_EXTENSION);

                     $filePdf = base_url().'image/pdf.png';
                
                     $fileword = base_url().'image/word.png'; 

                    if($ext == 'pdf'){

                        echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$filePdf.'" class="img-thumbnail" width="100" height="80"></a>';

                    }else if($ext == 'docx'){
                        
                        echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$fileword.'" class="img-thumbnail" width="100" height="80"></a>';
                        
                    }else{
                        
                         echo '<a href="'.$r1.'" target="_blank"><img id="myImg" src="'.$r1.'" class="img-thumbnail" width="100" height="80"></a>';
                    }
                
            }else{
 
               // echo "NO IMAGE";
                
            }
  
             
        }
       exit;
    }
    
    public function teachingProSemester()
    { 
        $subName      = $_POST['subName']; 
        $t_id         = $this->session->userdata('t_id'); //450717059 //COEP
        $school_id    = $this->session->userdata('school_id');
   
        $data['semName'] = $this->Teacher->fetchSemesterSubName($t_id,$subName,$school_id);
     
        foreach($data['semName'] as $row)
        { 
            
          $sem = $row->Semester_id;
          
          echo '<option value="'.$sem.'">'.$sem.'</option>';
           
        } 
     
        exit;
        //print_r($row);
     }
    
    public function teching_process_insertData() 
    {  
      $acad=$this->session->userdata('current_acadmic_year1');
        if(isset($_POST['course_name']))
            {  
            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx","xlxs");
            $file = array();
            foreach($_FILES["user_userfile"]["tmp_name"] as $key=>$tmp_name) {
                
               $file_name = $_FILES["user_userfile"]["name"][$key];
               $file_tmp  = $_FILES["user_userfile"]["tmp_name"][$key];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
                
                if(in_array($ext,$extension)) {
                    
                   $destination  = './image/' . $file_name; 
                   move_uploaded_file($file_tmp=$_FILES["user_userfile"]["tmp_name"][$key],$destination);    
                }
                 
                $str = str_replace("image/" , "" , "$file_name");  
                $items[] = ltrim(base_url().'image/'.$str,',');
            }
           //$AcademicYear=$acad;
             $fimg = implode(",",$items); 
            
            $cName = $_POST['course_name'];  
            $na = explode(",", $cName);
 
                       $Branches_id    =  $na[0];  
                       $subjectName    =  $na[1];
                       $subjectCode    =  $na[2];
                       $Department_id  =  $na[3];
                       $CourseLevel    =  $na[4];
                       $AcademicYear   =  $na[5];
                       $DivID          =  $na[6];    
     
                 
            $t_id = $this->session->userdata('t_id');  
            $school_id = $this->session->userdata('school_id');  
 
                $semesterID = $_POST['semester_name']; 
 
                $schedule_class  = $_POST['schedule_classes'];
                $actual_class    = $_POST['actual_classes'];  
             
             if($schedule_class >= $actual_class)
             { 
 
                   $data = array(   
                 
                      'feed360_teacher_id'         =>  $t_id,
                      'feed360_school_id'          =>  $school_id,
                      'feed360_subject_name'       =>  $subjectName,
                      'feed360_subject_code'       =>  $subjectCode, 
                      'feed360_semester_ID'        =>  $semesterID, 
                      'feed360_classes_scheduled'  =>  $schedule_class,
                      'feed360_actual_classes'     =>  $actual_class,  
                      'feed360_branch_ID'          =>  $Branches_id, 
                      'feed360_dept_ID'            =>  $Department_id, 
                      'feed360_course_level'       =>  $CourseLevel, 
                      'feed360_academic_year_ID'   =>  $acad,
                      'feed360_img'                =>  $fimg
                       
                 ); 
                //print_r($data);exit;
                 foreach($data as $key=>$value)
                    {
                          if(trim($value) =='' || $value == base_url().'image/')
                            unset($data[$key]);
                    }
     
                $chekTeaSchl = $this->Teacher->checkTeacherScheduleSubExt($t_id,$school_id,$subjectName,$subjectCode,$semesterID,$Department_id,$acad,$Branches_id);  
                 
                if($chekTeaSchl)     
                {
                           echo "Your Teaching Schedule For This Subject Is Already Exists"; 
                    
                }else{
                    
                            $res = $this->Teacher->InsertteacherTeachinProcess($data);
 
                             if($res > 0) 
                                {  
                                  $aicte_360activity_level = $this->Teacher->aicte_360activity_level('6');
               
                                $data_activity = array("from_entity_id"=>"103","reason_id"=>"1005","point_feedback"=>$aicte_360activity_level->reward_points,"group_id"=>"91");

                                $ch_act = curl_init(base_url("core/Version3/check_referral_act_points.php"));  
                        
                                $data_string2 = json_encode($data_activity);    
                                curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                                curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                                curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                                curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                                $result2 = json_decode(curl_exec($ch_act),true);

                                if($result2['responseStatus']=="200"){
                                    $refferal_activity = array("Entity_TypeID"=>"103","Key"=>$aicte_360activity_level->actL360_activity_level,"PRN_EmpID"=>$t_id,"SchoolID"=>$school_id);

                                    $ref_act = curl_init(base_url("core/Version5/Assign_Reward_Points360_API.php"));  
                                  
                                  
                                    $refferal_string2 = json_encode($refferal_activity);    
                                    curl_setopt($ref_act, CURLOPT_CUSTOMREQUEST, "POST");    
                                    curl_setopt($ref_act, CURLOPT_POSTFIELDS, $refferal_string2);  
                                    curl_setopt($ref_act, CURLOPT_RETURNTRANSFER, true);      
                                    curl_setopt($ref_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($refferal_string2)));
                                    $res2 = json_decode(curl_exec($ref_act),true);
                                }
                                 echo "Inserted_Successfully"; 
                                  
                                }else
                                {   
                                 echo "Insertion Failed"; 
                                } 
                    
                     }
                 
             }else{ 
                   echo "Schedule Classes Not Allowed More Than Actual Classes";
                 
                  } 
            
            
//                      $res = $this->Teacher->fetchDataFmTeachingProcess();
//
//                      $inTeaSchoolID        = $res->school_id;
//                      $inTeaSchoolName      = $res->school_name; 
//                      $inDeptName           = $res->t_dept;
//                      $inTeaId              = $res->t_id;
//                      $inTeaName            = $res->t_complete_name;
//                      $inState              = $res->scadmin_state;
//                      $inActYear            = $res->Academic_Year;
//                      $TeaProcessTeaPoins   = $res->tp_points;
//                      $groupMemId           = $res->group_member_id;
//          
//                      $data = array(
//
//                         "school_id"            => $inTeaSchoolID,
//                         "school_name"          => $inTeaSchoolName,
//                         "scadmin_state"        => $inState,
//                         "dept_name"            => $inDeptName,
//                         "teacher_id"           => $inTeaId,
//                         "teacher_name"         => $inTeaName,
//                         "academic_year"        => $inActYear,
//                         "group_member_id"      => $groupMemId,
//                         "teaching_process"     => $TeaProcessTeaPoins 
//
//                     );
// 
//                      $stuDeptTeaName = $this->Teacher->checkTeaProFBexist($inTeaSchoolID,$inState,$inTeaId,$inDeptName,$groupMemId);
//             
//
//                      if($stuDeptTeaName =="1")
//                      {  
//                           $updateFbSummaryReport = $this->Teacher->updateFBinSummaryReport($TeaProcessTeaPoins,$inTeaSchoolID,$inTeaId);
//                           // print_r($updateFbSummaryReport);
//
//                      }else{
//                             
//                            $insFbSummaryReport = $this->Teacher->insertFBinSummaryReport($data);
//
//                           } 
            
                   } 
        
    }
     
}
?>